<?php
/**
 * Donation Model (NurturaGive & Drop-Proof Tracking)
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/app.php';

class Donation {
    public static function create_commitment($need_id, $donor_user_id) {
        $pdo = get_db_connection();
        $pdo->beginTransaction();
        try {
            // Cek apakah status need masih 'dipublikasikan'
            $stmtCheck = $pdo->prepare("SELECT status FROM needs WHERE id = :id FOR UPDATE");
            $stmtCheck->execute([':id' => $need_id]);
            $need = $stmtCheck->fetch();

            if (!$need || $need['status'] !== 'dipublikasikan') {
                $pdo->rollBack();
                return false;
            }

            // Hitung waktu kunci (48 jam dari sekarang)
            $expires_at = date('Y-m-d H:i:s', strtotime('+' . LOCK_TIMEOUT_HOURS . ' hours'));

            // Insert donation record
            $stmtDon = $pdo->prepare("
                INSERT INTO donations (need_id, donor_user_id, committed_at, lock_expires_at, status)
                VALUES (:need_id, :donor_user_id, NOW(), :lock_expires_at, 'committed')
            ");
            $stmtDon->execute([
                ':need_id'         => $need_id,
                ':donor_user_id'   => $donor_user_id,
                ':lock_expires_at' => $expires_at,
            ]);
            $donation_id = $pdo->lastInsertId();

            // Ubah status need menjadi 'dalam_komitmen'
            $stmtNeed = $pdo->prepare("UPDATE needs SET status = 'dalam_komitmen' WHERE id = :id");
            $stmtNeed->execute([':id' => $need_id]);

            $pdo->commit();
            return $donation_id;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function get_active_by_donor($donor_user_id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("
            SELECT d.*, n.title, n.food_items_needed, n.status AS need_status,
                   dp.name AS drop_point_name, dp.officer_in_charge, dp.phone_contact AS drop_point_phone, dp.address_full AS drop_point_address
            FROM donations d
            JOIN needs n ON d.need_id = n.id
            JOIN drop_points dp ON n.drop_point_id = dp.id
            WHERE d.donor_user_id = :donor_user_id
            ORDER BY d.committed_at DESC
        ");
        $stmt->execute([':donor_user_id' => $donor_user_id]);
        return $stmt->fetchAll();
    }

    public static function upload_proof($donation_id, $donor_user_id, $proof_filename, $donor_notes = null) {
        $pdo = get_db_connection();
        $pdo->beginTransaction();
        try {
            // Verifikasi kepemilikan donasi & status komitmen aktif (mencegah IDOR)
            $stmtGet = $pdo->prepare("SELECT need_id FROM donations WHERE id = :id AND donor_user_id = :donor_id AND status = 'committed' FOR UPDATE");
            $stmtGet->execute([':id' => $donation_id, ':donor_id' => $donor_user_id]);
            $don = $stmtGet->fetch();
            if (!$don) {
                $pdo->rollBack();
                return false;
            }

            $stmtUpd = $pdo->prepare("
                UPDATE donations 
                SET proof_of_drop_path = :proof, donor_notes = :notes, status = 'proof_uploaded', proof_uploaded_at = NOW()
                WHERE id = :id
            ");
            $stmtUpd->execute([
                ':proof' => $proof_filename,
                ':notes' => $donor_notes,
                ':id'    => $donation_id,
            ]);

            // Ubah status need menjadi 'menunggu_pengambilan'
            $stmtNeed = $pdo->prepare("UPDATE needs SET status = 'menunggu_pengambilan' WHERE id = :need_id");
            $stmtNeed->execute([':need_id' => $don['need_id']]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function confirm_received_by_mother($need_id, $mother_user_id) {
        $pdo = get_db_connection();
        $pdo->beginTransaction();
        try {
            // Verifikasi bahwa need milik user bersangkutan
            $stmtCheck = $pdo->prepare("SELECT id FROM needs WHERE id = :id AND user_id = :user_id AND status = 'menunggu_pengambilan'");
            $stmtCheck->execute([':id' => $need_id, ':user_id' => $mother_user_id]);
            if (!$stmtCheck->fetch()) {
                $pdo->rollBack();
                return false;
            }

            // Update need status menjadi 'selesai'
            $stmtNeed = $pdo->prepare("UPDATE needs SET status = 'selesai' WHERE id = :id");
            $stmtNeed->execute([':id' => $need_id]);

            // Update donation status menjadi 'completed'
            $stmtDon = $pdo->prepare("UPDATE donations SET status = 'completed', completed_at = NOW() WHERE need_id = :need_id");
            $stmtDon->execute([':need_id' => $need_id]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function create_dispute($need_id, $reporter_user_id, $reason) {
        $pdo = get_db_connection();
        $pdo->beginTransaction();
        try {
            // Verifikasi bahwa pengajuan milik ibu hamil pelapor dan berstatus menunggu_pengambilan
            $stmtCheck = $pdo->prepare("SELECT id FROM needs WHERE id = :need_id AND user_id = :user_id AND status = 'menunggu_pengambilan' FOR UPDATE");
            $stmtCheck->execute([':need_id' => $need_id, ':user_id' => $reporter_user_id]);
            if (!$stmtCheck->fetch()) {
                $pdo->rollBack();
                return false;
            }

            $stmtDisp = $pdo->prepare("
                INSERT INTO disputes (need_id, reporter_user_id, reason, status)
                VALUES (:need_id, :reporter_user_id, :reason, 'open')
            ");
            $stmtDisp->execute([
                ':need_id'          => $need_id,
                ':reporter_user_id' => $reporter_user_id,
                ':reason'           => $reason,
            ]);

            // Ubah status need menjadi 'dispute'
            $stmtNeed = $pdo->prepare("UPDATE needs SET status = 'dispute' WHERE id = :need_id");
            $stmtNeed->execute([':need_id' => $need_id]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function get_proof_for_mother($need_id, $mother_user_id) {
        $pdo = get_db_connection();

        $stmt = $pdo->prepare("
            SELECT d.proof_of_drop_path
            FROM donations d
            INNER JOIN needs n ON d.need_id = n.id
            WHERE n.id = :need_id
            AND n.user_id = :mother_user_id
            AND d.proof_of_drop_path IS NOT NULL
            AND d.status IN ('proof_uploaded', 'completed')
            ORDER BY d.proof_uploaded_at DESC
            LIMIT 1
        ");

        $stmt->execute([
            ':need_id' => $need_id,
            ':mother_user_id' => $mother_user_id
        ]);

        return $stmt->fetch();
    }

}
