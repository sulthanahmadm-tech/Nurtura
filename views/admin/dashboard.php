<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$open_dispute_count = 0;
foreach ($disputes as $dispute) {
    if ($dispute['status'] === 'open') {
        $open_dispute_count++;
    }
}
?>

<div style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">
    <!-- Header Admin Dashboard -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div>
                <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 6px;">
                    NurturaGuard · Panel Medis & Verifikasi · Administrator Medis
                </div>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em;">
                    Verifikasi Buku KIA & Moderasi Medis
                </h1>
                <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
                    Validasi keabsahan dokumen Buku KIA, evaluasi indikator antropometri LILA (&lt; 23,5 cm), serta penanganan kendala serah terima pangan.
                </p>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin-bottom: 24px;">
            <?php
                if ($_GET['msg'] === 'status_diperbarui') echo "Status pengajuan berhasil diperbarui dan notifikasi telah dikirimkan.";
                elseif ($_GET['msg'] === 'dispute_diperbarui') echo "Status laporan kendala bantuan berhasil diperbarui.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" style="margin-bottom: 24px;">
            <?php
                if ($_GET['error'] === 'dispute_locked') echo "Laporan kendala ini sudah berstatus final dan terkunci sehingga tidak dapat diubah kembali.";
                else echo "Terjadi kesalahan saat memproses permintaan.";
            ?>
        </div>
    <?php endif; ?>

    <!-- Ringkasan Statistik Tugas Admin (Modern 3D Stat Cards) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px; margin-bottom: 28px;">
        <div class="card-modern" style="border: 1px solid rgba(226, 232, 240, 0.9); padding: 22px; display: flex; align-items: center; gap: 16px;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;">Antrean Peninjauan KIA</span>
                <div style="font-size: 1.8rem; font-weight: 900; color: #0f172a; line-height: 1.1; margin-top: 2px;">
                    <?= count($pending_needs) ?> <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Pengajuan</span>
                </div>
            </div>
        </div>

        <div class="card-modern" style="border: 1px solid rgba(226, 232, 240, 0.9); padding: 22px; display: flex; align-items: center; gap: 16px;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: <?= $open_dispute_count > 0 ? '#fee2e2' : '#f1f5f9' ?>; color: <?= $open_dispute_count > 0 ? '#b91c1c' : '#64748b' ?>; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;">Laporan Kendala Terbuka</span>
                <div style="font-size: 1.8rem; font-weight: 900; color: <?= $open_dispute_count > 0 ? '#b91c1c' : '#0f172a' ?>; line-height: 1.1; margin-top: 2px;">
                    <?= $open_dispute_count ?> <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Laporan Baru</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1: Antrean Pengajuan Menunggu Peninjauan -->
    <div class="card-modern" style="border: 1px solid rgba(226, 232, 240, 0.9); padding: 30px; margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #0284c7;">
                    Proses Verifikasi Klinis
                </span>
                <h2 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                    Antrean Pengajuan Menunggu Peninjauan (<?= count($pending_needs) ?>)
                </h2>
            </div>
            <span class="badge badge-info" style="font-size: 0.75rem;">SOP Medis Kemenkes</span>
        </div>

        <?php if (empty($pending_needs)): ?>
            <div style="text-align: center; padding: 48px 20px; background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;">
                <div style="width: 48px; height: 48px; background: #e0f2fe; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; color: #0284c7;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Seluruh Berkas Telah Terverifikasi</h4>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Tidak ada pengajuan baru yang menunggu peninjauan saat ini.</p>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <?php foreach ($pending_needs as $pn): ?>
                    <div class="card-3d-tactile" style="padding: 24px; background: #ffffff;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                                    <?= htmlspecialchars($pn['title']) ?>
                                </h3>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">
                                    Pengaju: <strong><?= htmlspecialchars($pn['full_name']) ?></strong> (HP: <?= htmlspecialchars($pn['phone_number']) ?>) • Diajukan: <?= format_datetime_id($pn['submitted_at']) ?>
                                </span>
                            </div>
                            <div>
                                <?php if ($pn['lila_measurement'] < 23.5): ?>
                                    <span class="badge badge-kek-risk" style="font-size: 0.82rem; padding: 6px 14px; font-weight: 700;">
                                        LILA: <?= number_format($pn['lila_measurement'], 1) ?> cm (Risiko KEK)
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-kek-normal" style="font-size: 0.82rem; padding: 6px 14px; font-weight: 700;">
                                        LILA: <?= number_format($pn['lila_measurement'], 1) ?> cm (Normal)
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 14px 18px; border-radius: 14px; font-size: 0.92rem; margin-bottom: 14px;">
                            <span style="font-size: 0.72rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                                Paket Pangan yang Diajukan:
                            </span>
                            <p style="margin: 0; color: #0c4a6e; font-weight: 600; line-height: 1.5;"><?= nl2br(htmlspecialchars($pn['food_items_needed'])) ?></p>
                        </div>

                        <div style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 18px; line-height: 1.5;">
                            <div><strong>Alasan Kebutuhan:</strong> <?= htmlspecialchars($pn['description']) ?></div>
                            <div style="margin-top: 2px;"><strong>Drop-Point Posyandu:</strong> <strong style="color: #0f172a;"><?= htmlspecialchars($pn['drop_point_name']) ?></strong></div>
                        </div>

                        <!-- Berkas Medis Buku KIA (Akses Aman Controller & Inspeksi Langsung) -->
                        <div style="margin-bottom: 20px; padding: 16px 20px; background: #fafcff; border-radius: 14px; border: 1px solid #cbd5e1; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="width: 36px; height: 36px; background: #e0f2fe; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #0284c7;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                </div>
                                <div>
                                    <span style="font-size: 0.9rem; font-weight: 800; color: #0f172a; display: block;">Dokumen Lampiran Buku KIA</span>
                                    <span style="font-size: 0.78rem; color: #64748b;">Tersimpan aman di storage privat terenkripsi</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button
                                    type="button"
                                    class="btn-lime-sm btn-lime"
                                    onclick="openKiaInspector('index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>', 'Buku KIA: <?= htmlspecialchars(addslashes($pn['full_name'])) ?> (LILA <?= number_format($pn['lila_measurement'], 1) ?> cm)')"
                                    style="display: inline-flex; align-items: center; gap: 6px;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    Buka Inspeksi Lembar KIA
                                </button>
                                <a
                                    href="index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>"
                                    target="_blank"
                                    class="btn btn-secondary btn-sm"
                                    style="background: #ffffff; border: 1px solid var(--border-color); font-size: 0.8rem;"
                                    title="Buka di tab terpisah">
                                    Tab Baru ↗
                                </a>
                            </div>
                        </div>

                        <!-- Form Keputusan Admin -->
                        <form action="index.php?action=admin-update-status" method="POST" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 18px; border-radius: 14px;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="need_id" value="<?= $pn['id'] ?>">

                            <div class="form-group" style="margin-bottom: 14px;">
                                <label for="admin_notes_<?= $pn['id'] ?>" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                                    Catatan / Alasan Evaluasi (Wajib jika revisi atau tolak):
                                </label>
                                <input
                                    type="text"
                                    id="admin_notes_<?= $pn['id'] ?>"
                                    name="admin_notes"
                                    class="form-control"
                                    placeholder="Contoh: Dokumen KIA terverifikasi valid, status gizi KEK terkonfirmasi."
                                    style="background: #ffffff;">
                            </div>

                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <button type="submit" name="action" value="approve" class="btn btn-primary" data-confirm="Setujui dan publikasikan kebutuhan ini ke katalog publik?">
                                    ✓ Setujui (Publikasikan)
                                </button>
                                <button type="submit" name="action" value="revision" class="btn btn-warning" data-confirm="Minta ibu hamil memperbaiki dokumen atau data pengajuan?">
                                    Minta Revisi
                                </button>
                                <button type="submit" name="action" value="reject" class="btn btn-sm" style="background: #ffffff; border: 1px solid #fecaca; color: #b91c1c; font-weight: 700;" data-confirm="Tolak pengajuan ini secara permanen?">
                                    Tolak Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 2: Laporan Kendala / Dispute -->
    <?php
        $active_disputes = [];
        $archived_disputes = [];
        foreach ($disputes as $d) {
            if (in_array($d['status'], ['resolved', 'rejected'], true)) {
                $archived_disputes[] = $d;
            } else {
                $active_disputes[] = $d;
            }
        }
        $status_labels = [
            'open' => 'Menunggu Penanganan',
            'under_review' => 'Sedang Ditinjau',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak'
        ];
    ?>
    <div class="card-clean" style="padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #b91c1c;">
                    Eskalasi Masalah Aktif
                </span>
                <h2 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                    Laporan Kendala Bantuan (<?= count($active_disputes) ?> Aktif)
                </h2>
            </div>
        </div>

        <?php if (empty($active_disputes)): ?>
            <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1;">
                <p style="color: #64748b; font-size: 0.92rem; margin: 0;">
                    Tidak ada laporan kendala aktif saat ini. Seluruh penyaluran berjalan lancar.
                </p>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 18px;">
                <?php foreach ($active_disputes as $dispute): ?>
                    <?php $current_status = $dispute['status']; ?>
                    <div class="card-clean" style="padding: 22px; background: #ffffff;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 12px;">
                            <div>
                                <h4 style="margin: 0 0 4px 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">
                                    <?= htmlspecialchars($dispute['need_title']) ?>
                                </h4>
                                <span style="font-size: 0.85rem; color: #64748b;">
                                    Pelapor: <strong style="color: #0f172a;"><?= htmlspecialchars($dispute['reporter_name']) ?></strong> • No. Kontak: <?= htmlspecialchars($dispute['reporter_phone']) ?>
                                </span>
                            </div>

                            <span style="font-size: 0.8rem; font-weight: 700; color: <?= $current_status === 'open' ? '#b91c1c' : '#b45309' ?>;">
                                <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?>
                            </span>
                        </div>

                        <div style="background: #f8fafc; border-left: 3px solid #b91c1c; padding: 14px 18px; border-radius: 0 12px 12px 0; margin-bottom: 14px;">
                            <span style="font-size: 0.72rem; font-weight: 800; color: #b91c1c; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                                Isi Laporan Kendala
                            </span>
                            <p style="margin: 0; color: #0f172a; font-weight: 600; line-height: 1.5; font-size: 0.92rem;">
                                <?= nl2br(htmlspecialchars($dispute['reason'])) ?>
                            </p>
                        </div>

                        <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 14px; line-height: 1.5;">
                            <div>Drop-Point Posyandu: <strong style="color: #0f172a;"><?= htmlspecialchars($dispute['drop_point_name']) ?></strong></div>
                            <div>Waktu Laporan Diajukan: <?= format_datetime_id($dispute['dispute_created_at']) ?></div>
                        </div>

                        <?php if (!empty($dispute['dispute_admin_notes'])): ?>
                            <div style="background: #f0f9ff; border-left: 3px solid #0284c7; padding: 12px 16px; border-radius: 0 12px 12px 0; font-size: 0.88rem; color: #0c4a6e; margin-bottom: 14px;">
                                <strong>Catatan Admin Sebelumnya:</strong>
                                <?= nl2br(htmlspecialchars($dispute['dispute_admin_notes'])) ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?action=admin-update-dispute" method="POST" class="dispute-action-form" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 16px; border-radius: 12px;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="dispute_id" value="<?= (int)$dispute['dispute_id'] ?>">
                            <input type="hidden" name="status" value="" class="dispute-status-input">

                            <div class="form-group" style="margin-bottom: 14px;">
                                <label style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                                    Tindak Lanjut & Catatan Penanganan Admin:
                                </label>
                                <textarea
                                    name="admin_notes"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Tuliskan hasil koordinasi dengan posyandu atau donatur..."
                                    style="background: #ffffff;"><?= htmlspecialchars($dispute['dispute_admin_notes'] ?? '') ?></textarea>
                            </div>

                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <button type="button" onclick="submitDisputeDirect(this, 'under_review')" class="btn-ghost-clean" style="padding: 9px 18px; font-size: 0.88rem;">
                                    Tandai Sedang Ditinjau
                                </button>
                                <button type="button" onclick="openDisputeConfirmModal(this, 'resolved')" class="btn-lime" style="padding: 9px 20px; font-size: 0.88rem;">
                                    Selesaikan Laporan
                                </button>
                                <button type="button" onclick="openDisputeConfirmModal(this, 'rejected')" class="btn-ghost-clean" style="padding: 9px 18px; font-size: 0.88rem; color: #b91c1c !important; border-color: #fecaca;">
                                    Tolak Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($archived_disputes)): ?>
            <div style="margin-top: 28px; padding-top: 24px; border-top: 1px solid #e2e8f0;">
                <details>
                    <summary style="cursor: pointer; font-weight: 700; font-size: 0.95rem; color: #0284c7; user-select: none; margin-bottom: 14px;">
                        Riwayat Kendala Selesai / Terkunci (<?= count($archived_disputes) ?> Arsip Final)
                    </summary>
                    <div style="display: flex; flex-direction: column; gap: 14px; margin-top: 12px;">
                        <?php foreach ($archived_disputes as $dispute): ?>
                            <?php $current_status = $dispute['status']; ?>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px; margin-bottom: 8px;">
                                    <div>
                                        <h4 style="margin: 0 0 2px 0; font-size: 1.05rem; font-weight: 700; color: #0f172a;">
                                            <?= htmlspecialchars($dispute['need_title']) ?>
                                        </h4>
                                        <span style="font-size: 0.82rem; color: #64748b;">
                                            Pelapor: <strong><?= htmlspecialchars($dispute['reporter_name']) ?></strong> • <?= htmlspecialchars($dispute['drop_point_name']) ?>
                                        </span>
                                    </div>
                                    <span style="font-size: 0.78rem; font-weight: 700; color: <?= $current_status === 'resolved' ? '#15803d' : '#64748b' ?>;">
                                        <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?> (Terkunci)
                                    </span>
                                </div>
                                <p style="margin: 0 0 8px 0; font-size: 0.88rem; color: #334155;">
                                    <strong>Kendala:</strong> <?= nl2br(htmlspecialchars($dispute['reason'])) ?>
                                </p>
                                <?php if (!empty($dispute['dispute_admin_notes'])): ?>
                                    <div style="font-size: 0.84rem; color: #0c4a6e; background: #f0f9ff; border-left: 3px solid #0284c7; padding: 8px 12px; border-radius: 0 8px 8px 0;">
                                        <strong>Catatan Penyelesaian Admin:</strong> <?= nl2br(htmlspecialchars($dispute['dispute_admin_notes'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </details>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Konfirmasi Penyelesaian Masalah (Admin) -->
    <div id="dispute-confirm-modal" class="nurtura-modal-backdrop" onclick="closeDisputeConfirmModal()" role="dialog" aria-modal="true" style="display: none;">
        <div class="nurtura-modal-card" onclick="event.stopPropagation()">
            <div style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 4px;">
                Verifikasi Tindakan Final
            </div>
            <h3 id="dispute-confirm-title" style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 10px 0;">
                Apakah masalah ini benar-benar sudah selesai?
            </h3>
            <p id="dispute-confirm-desc" style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin: 0 0 20px 0;">
                Setelah ditetapkan selesai, status laporan ini akan dikunci secara permanen, dipindahkan ke arsip riwayat, dan tidak dapat diubah kembali.
            </p>
            <div style="display: flex; gap: 10px; justify-content: flex-end; flex-wrap: wrap;">
                <button type="button" onclick="closeDisputeConfirmModal()" class="btn-ghost-clean" style="padding: 10px 20px;">
                    Batal
                </button>
                <button type="button" id="dispute-confirm-submit-btn" onclick="confirmDisputeAction()" class="btn-lime" style="padding: 10px 22px;">
                    Ya, Masalah Selesai
                </button>
            </div>
        </div>
    </div>

    <script>
    let pendingDisputeForm = null;
    let pendingDisputeStatus = '';

    function submitDisputeDirect(btnEl, statusValue) {
        const form = btnEl.closest('.dispute-action-form');
        if (!form) return;
        form.querySelector('.dispute-status-input').value = statusValue;
        form.submit();
    }

    function openDisputeConfirmModal(btnEl, statusValue) {
        pendingDisputeForm = btnEl.closest('.dispute-action-form');
        pendingDisputeStatus = statusValue;

        const titleEl = document.getElementById('dispute-confirm-title');
        const descEl = document.getElementById('dispute-confirm-desc');
        const submitBtn = document.getElementById('dispute-confirm-submit-btn');

        if (statusValue === 'rejected') {
            titleEl.textContent = 'Apakah laporan kendala ini benar-benar ditolak?';
            descEl.textContent = 'Laporan yang ditolak akan dikunci permanen, dipindahkan ke arsip riwayat, dan tidak dapat diubah kembali.';
            submitBtn.textContent = 'Ya, Tolak Permanen';
        } else {
            titleEl.textContent = 'Apakah masalah ini benar-benar sudah selesai?';
            descEl.textContent = 'Setelah ditetapkan selesai, status laporan ini akan dikunci secara permanen, dipindahkan ke arsip riwayat, dan tidak dapat diubah kembali.';
            submitBtn.textContent = 'Ya, Masalah Selesai';
        }

        const modal = document.getElementById('dispute-confirm-modal');
        if (modal) {
            modal.style.display = 'flex';
            requestAnimationFrame(() => modal.classList.add('is-open'));
        }
    }

    function closeDisputeConfirmModal() {
        const modal = document.getElementById('dispute-confirm-modal');
        if (modal) {
            modal.classList.remove('is-open');
            setTimeout(() => { modal.style.display = 'none'; }, 180);
        }
        pendingDisputeForm = null;
        pendingDisputeStatus = '';
    }

    function confirmDisputeAction() {
        if (pendingDisputeForm && pendingDisputeStatus) {
            pendingDisputeForm.querySelector('.dispute-status-input').value = pendingDisputeStatus;
            pendingDisputeForm.submit();
        }
    }
    </script>
</div>

<!-- Reusable Modal Inspeksi Buku KIA (Zoom & Rotate) -->
<div id="kia-inspector-modal" class="kia-inspector-modal" onclick="closeKiaInspector()">
    <div class="kia-inspector-content" onclick="event.stopPropagation()">
        <div class="kia-inspector-header">
            <div>
                <h3 id="kia-inspect-title" style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                    Inspeksi Lembar Catatan Buku KIA
                </h3>
                <span style="font-size: 0.8rem; color: #64748b;">
                    Periksa stempel faskes, paraf bidan, dan grafik LILA
                </span>
            </div>
            <div class="kia-inspector-toolbar">
                <button type="button" class="btn btn-secondary btn-sm" onclick="zoomKia(0.25)" title="Perbesar">Zoom (+)</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="zoomKia(-0.25)" title="Perkecil">Zoom (-)</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="rotateKia()" title="Putar 90 Derajat">Putar 90°</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetKia()" title="Reset Ukuran">Reset</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeKiaInspector()" style="font-size: 1.2rem; line-height: 1; padding: 4px 10px;">&times;</button>
            </div>
        </div>
        <div class="kia-inspector-body">
            <img id="kia-inspect-img" src="" alt="Lembar Dokumen KIA" class="kia-inspect-img">
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
