<?php
/**
 * Cron / Background Event Helper
 * Automates Auto-Release 48 Jam, Auto-Complete 72 Jam, and HPL Expiry
 */

require_once __DIR__ . '/../../config/database.php';

function run_lifecycle_checks() {
    $pdo = get_db_connection();

    // 1. GHOSTING AUTO-RELEASE (48 Jam):
    // Kembalikan status ke 'dipublikasikan' jika donatur mangkir melewati batas lock_expires_at
    $stmtGhost = $pdo->prepare("
        SELECT d.id AS donation_id, d.need_id 
        FROM donations d
        JOIN needs n ON d.need_id = n.id
        WHERE n.status = 'dalam_komitmen' 
          AND d.status = 'committed'
          AND d.lock_expires_at < NOW()
    ");
    $stmtGhost->execute();
    $expiredCommitments = $stmtGhost->fetchAll();

    foreach ($expiredCommitments as $exp) {
        $pdo->beginTransaction();
        try {
            // Update donasi menjadi batal karena ghosting
            $updDonation = $pdo->prepare("UPDATE donations SET status = 'cancelled_ghosting' WHERE id = :id");
            $updDonation->execute([':id' => $exp['donation_id']]);

            // Kembalikan status kebutuhan ke 'dipublikasikan' agar donatur lain bisa bantu
            $updNeed = $pdo->prepare("UPDATE needs SET status = 'dipublikasikan' WHERE id = :need_id");
            $updNeed->execute([':need_id' => $exp['need_id']]);

            // Catat log
            $log = $pdo->prepare("INSERT INTO activity_logs (action, details) VALUES ('GHOSTING_AUTO_RELEASE', :details)");
            $log->execute([':details' => "Komitmen donation_id: {$exp['donation_id']} dibatalkan otomatis karena melewati batas 48 jam."]);

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }

    // 2. AUTO-COMPLETE (72 Jam):
    // Jika donatur sudah upload bukti paket di posyandu, dan 72 jam berlalu tanpa dispute, selesaikan otomatis
    $stmtAutoDone = $pdo->prepare("
        SELECT d.id AS donation_id, d.need_id
        FROM donations d
        JOIN needs n ON d.need_id = n.id
        WHERE n.status = 'menunggu_pengambilan'
          AND d.status = 'proof_uploaded'
          AND d.proof_uploaded_at < DATE_SUB(NOW(), INTERVAL 72 HOUR)
          AND NOT EXISTS (SELECT 1 FROM disputes disp WHERE disp.need_id = n.id AND disp.status IN ('open', 'under_review'))
    ");
    $stmtAutoDone->execute();
    $autoCompletes = $stmtAutoDone->fetchAll();

    foreach ($autoCompletes as $done) {
        $pdo->beginTransaction();
        try {
            $updNeed = $pdo->prepare("UPDATE needs SET status = 'selesai' WHERE id = :need_id");
            $updNeed->execute([':need_id' => $done['need_id']]);

            $updDonation = $pdo->prepare("UPDATE donations SET status = 'completed', completed_at = NOW() WHERE id = :id");
            $updDonation->execute([':id' => $done['donation_id']]);

            $log = $pdo->prepare("INSERT INTO activity_logs (action, details) VALUES ('AUTO_COMPLETE_72H', :details)");
            $log->execute([':details' => "Need id: {$done['need_id']} diselesaikan otomatis setelah 72 jam tanpa dispute."]);

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }

    // 3. KEDALUWARSA HPL:
    // Jika tanggal HPL lewat dan kebutuhan belum selesai, tandai kedaluwarsa
    $stmtHpl = $pdo->prepare("
        UPDATE needs n
        JOIN profiles p ON n.user_id = p.user_id
        SET n.status = 'kedaluwarsa_hpl'
        WHERE n.status IN ('dipublikasikan', 'draf', 'perlu_perbaikan')
          AND p.estimated_birth_date IS NOT NULL
          AND p.estimated_birth_date < CURDATE()
    ");
    $stmtHpl->execute();
}
