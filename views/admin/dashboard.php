<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="margin-bottom: 24px;">
    <h2>🛡️ NurturaGuard — Panel Verifikasi & Moderasi Medis</h2>
    <p style="color: var(--text-muted);">
        Verifikasi kelayakan berkas Buku KIA, keabsahan nilai LILA (&lt; 23,5 cm), dan penanganan moderasi kebutuhan pangan ibu hamil.
    </p>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'status_diperbarui'): ?>
    <div class="alert alert-success">
        Status pengajuan berhasil diperbarui!
    </div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'dispute_diperbarui'): ?>
    <div class="alert alert-success">
        Status laporan kendala berhasil diperbarui!
    </div>
<?php endif; ?>

<div class="card" style="margin-bottom: 24px;">
    <h3>Antrean Pengajuan Menunggu Peninjauan (<?= count($pending_needs) ?>)</h3>
    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">
        Pastikan lembar Buku KIA menunjukkan identitas ibu hamil yang valid, data kehamilan aktif, dan catatan LILA yang konsisten.
    </p>

    <?php if (empty($pending_needs)): ?>
        <div style="text-align: center; padding: 32px; background: #f8fafc; border-radius: 8px;">
            <p style="color: var(--text-muted);">Tidak ada pengajuan baru yang menunggu peninjauan saat ini.</p>
        </div>
    <?php else: ?>
        <?php foreach ($pending_needs as $pn): ?>
            <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px; background: #ffffff;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h4 style="font-size: 1.2rem; color: #1e293b; margin-bottom: 4px;"><?= htmlspecialchars($pn['title']) ?></h4>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">
                            Nama Pengaju: <strong><?= htmlspecialchars($pn['full_name']) ?></strong> (HP: <?= htmlspecialchars($pn['phone_number']) ?>) • Diajukan: <?= format_datetime_id($pn['submitted_at']) ?>
                        </span>
                    </div>
                    <div>
                        <span class="badge" style="background: <?= ($pn['lila_measurement'] < 23.5) ? '#fee2e2' : '#dcfce7' ?>; color: <?= ($pn['lila_measurement'] < 23.5) ? '#991b1b' : '#166534' ?>; font-size: 0.9rem; padding: 6px 12px;">
                            LILA: <?= number_format($pn['lila_measurement'], 1) ?> cm <?= ($pn['lila_measurement'] < 23.5) ? '(Indikasi KEK)' : '(Normal)' ?>
                        </span>
                    </div>
                </div>

                <div style="background: #f8fafc; padding: 12px; border-radius: 6px; font-size: 0.9rem; margin-bottom: 12px;">
                    <strong>Paket yang Diminta:</strong><br>
                    <?= nl2br(htmlspecialchars($pn['food_items_needed'])) ?>
                </div>

                <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px;">
                    Alasan: <?= htmlspecialchars($pn['description']) ?><br>
                    Drop-Point: <strong><?= htmlspecialchars($pn['drop_point_name']) ?></strong>
                </div>

                <!-- Berkas Medis Buku KIA (Akses Aman melalui Controller) -->
                <div style="margin-bottom: 20px; padding: 14px; background: #eff6ff; border-radius: 8px; border: 1px solid #bfdbfe;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 0.9rem; font-weight: 600; color: #1e40af;">📎 Dokumen Lampiran Buku KIA:</span>
                            <span style="font-size: 0.85rem; color: #3b82f6;"> (Tersimpan aman di storage privat terisolasi)</span>
                        </div>
                        <a href="index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="background: #ffffff; border: 1px solid #93c5fd;">
                            🔍 Buka & Periksa Lembar Buku KIA
                        </a>
                    </div>
                </div>

                <!-- Form Keputusan Admin -->
                <form action="index.php?action=admin-update-status" method="POST" style="background: #fafafa; border: 1px solid var(--border-color); padding: 16px; border-radius: 8px;">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <input type="hidden" name="need_id" value="<?= $pn['id'] ?>">

                    <div class="form-group">
                        <label for="admin_notes_<?= $pn['id'] ?>">Catatan / Alasan (Opsional jika approve, wajib jika revisi/tolak):</label>
                        <input type="text" id="admin_notes_<?= $pn['id'] ?>" name="admin_notes" class="form-control" placeholder="Contoh: Dokumen KIA terverifikasi valid, status gizi KEK terkonfirmasi.">
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="submit" name="action" value="approve" class="btn btn-primary" data-confirm="Setujui dan publikasikan kebutuhan ini ke katalog publik?">
                            ✅ Setujui (Publikasikan)
                        </button>
                        <button type="submit" name="action" value="revision" class="btn btn-warning" data-confirm="Minta ibu hamil memperbaiki dokumen/data pengajuan?">
                            ⚠️ Minta Revisi
                        </button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger" data-confirm="Tolak pengajuan ini secara permanen?">
                            ❌ Tolak Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Laporan Kendala / Dispute -->
<?php
$open_dispute_count = 0;

foreach ($disputes as $dispute) {
    if ($dispute['status'] === 'open') {
        $open_dispute_count++;
    }
}
?>

<div class="card" style="margin-bottom: 24px;">

    <h3 style="margin-bottom: 8px;">
        🔔 Laporan Kendala Bantuan
        (<?= $open_dispute_count ?> Laporan Baru)
    </h3>

    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">
        Daftar laporan masalah bantuan yang disampaikan oleh ibu hamil.
        Periksa laporan dan lakukan tindak lanjut.
    </p>

    <?php if (empty($disputes)): ?>

        <div style="text-align: center; padding: 32px; background: #f8fafc; border-radius: 8px;">
            <p style="color: var(--text-muted);">
                Belum ada laporan kendala bantuan.
            </p>
        </div>

    <?php else: ?>

        <?php foreach ($disputes as $dispute): ?>

            <div style="
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 16px;
                background: #ffffff;
            ">

                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    flex-wrap: wrap;
                    gap: 10px;
                    margin-bottom: 12px;
                ">

                    <div>
                        <h4 style="margin-bottom: 4px;">
                            <?= htmlspecialchars($dispute['need_title']) ?>
                        </h4>

                        <span style="font-size: 0.85rem; color: var(--text-muted);">
                            Pelapor:
                            <strong><?= htmlspecialchars($dispute['reporter_name']) ?></strong>
                            • <?= htmlspecialchars($dispute['reporter_phone']) ?>
                        </span>
                    </div>

                    <?php
                    $status_labels = [
                        'open' => 'Menunggu Penanganan',
                        'under_review' => 'Sedang Ditinjau',
                        'resolved' => 'Selesai',
                        'rejected' => 'Ditolak'
                    ];

                    $status_colors = [
                        'open' => '#fee2e2',
                        'under_review' => '#fef3c7',
                        'resolved' => '#dcfce7',
                        'rejected' => '#e2e8f0'
                    ];

                    $status_text_colors = [
                        'open' => '#991b1b',
                        'under_review' => '#92400e',
                        'resolved' => '#166534',
                        'rejected' => '#475569'
                    ];

                    $current_status = $dispute['status'];
                    ?>

                    <span class="badge" style="
                        background: <?= $status_colors[$current_status] ?? '#e2e8f0' ?>;
                        color: <?= $status_text_colors[$current_status] ?? '#475569' ?>;
                        padding: 6px 12px;
                    ">
                        <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?>
                    </span>

                </div>

                <div style="
                    background: #fff7ed;
                    padding: 14px;
                    border-radius: 6px;
                    margin-bottom: 12px;
                ">
                    <strong>Isi Laporan Kendala:</strong>

                    <p style="margin-top: 6px;">
                        <?= nl2br(htmlspecialchars($dispute['reason'])) ?>
                    </p>
                </div>

                <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">
                    <strong>Drop-Point:</strong>
                    <?= htmlspecialchars($dispute['drop_point_name']) ?>
                    <br>

                    <strong>Waktu Laporan:</strong>
                    <?= format_datetime_id($dispute['dispute_created_at']) ?>
                </div>

                <?php if (!empty($dispute['dispute_admin_notes'])): ?>
                    <div class="alert alert-info">
                        <strong>Catatan Admin:</strong>
                        <?= nl2br(htmlspecialchars($dispute['dispute_admin_notes'])) ?>
                    </div>
                <?php endif; ?>

                <form
                    action="index.php?action=admin-update-dispute"
                    method="POST"
                    style="
                        background: #f8fafc;
                        padding: 14px;
                        border-radius: 8px;
                    "
                >

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= generate_csrf_token() ?>"
                    >

                    <input
                        type="hidden"
                        name="dispute_id"
                        value="<?= (int)$dispute['dispute_id'] ?>"
                    >

                    <div class="form-group">
                        <label>Catatan Penanganan Admin:</label>

                        <textarea
                            name="admin_notes"
                            class="form-control"
                            rows="2"
                            placeholder="Tuliskan hasil pemeriksaan atau tindak lanjut..."
                        ><?= htmlspecialchars($dispute['dispute_admin_notes'] ?? '') ?></textarea>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">

                        <button
                            type="submit"
                            name="status"
                            value="under_review"
                            class="btn btn-warning"
                        >
                            🔍 Sedang Ditinjau
                        </button>

                        <button
                            type="submit"
                            name="status"
                            value="resolved"
                            class="btn btn-primary"
                        >
                            ✅ Selesaikan Laporan
                        </button>

                        <button
                            type="submit"
                            name="status"
                            value="rejected"
                            class="btn btn-danger"
                            data-confirm="Apakah laporan ini benar-benar akan ditolak?"
                        >
                            ❌ Tolak Laporan
                        </button>

                    </div>

                </form>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
