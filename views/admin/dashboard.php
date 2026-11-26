<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$active_disputes = [];
$archived_disputes = [];
foreach ($disputes as $d) {
    if (in_array($d['status'], ['resolved', 'rejected'], true)) {
        $archived_disputes[] = $d;
    } else {
        $active_disputes[] = $d;
    }
}
$open_dispute_count = count($active_disputes);
$archived_dispute_count = count($archived_disputes);

$status_labels = [
    'open' => 'Menunggu Penanganan',
    'under_review' => 'Sedang Ditinjau',
    'resolved' => 'Selesai',
    'rejected' => 'Ditolak'
];
?>

<div style="display: flex; flex-direction: column; gap: 1.75rem; padding-bottom: 2.5rem;">
    <!-- Page Header -->
    <section style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 0.875rem;">
        <div>
            <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.375rem;">
                NurturaGuard · Panel Medis &amp; Verifikasi · Administrator Medis
            </span>
            <h1 style="font-size: clamp(1.5rem, 4.5vw, 2.15rem); font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                Verifikasi Buku KIA &amp; Moderasi Medis
            </h1>
            <p style="color: var(--text-muted); font-size: 0.94rem; margin: 0;">
                Validasi keabsahan dokumen Buku KIA, evaluasi indikator antropometri LILA (&lt; 23,5 cm), serta penanganan kendala serah terima pangan.
            </p>
        </div>

        <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">
            SOP Kemenkes RI
        </span>
    </section>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 0;">
            <?php
                if ($_GET['msg'] === 'status_diperbarui') echo "Status pengajuan berhasil diperbarui dan notifikasi telah dikirimkan.";
                elseif ($_GET['msg'] === 'dispute_diperbarui') echo "Status laporan kendala bantuan berhasil diperbarui.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" style="margin: 0;">
            <?php
                if ($_GET['error'] === 'dispute_locked') echo "Laporan kendala ini sudah berstatus final dan terkunci sehingga tidak dapat diubah kembali.";
                else echo "Terjadi kesalahan saat memproses permintaan.";
            ?>
        </div>
    <?php endif; ?>

    <!-- 3 KPI Cards -->
    <section aria-label="Ringkasan Antrean Admin" class="grid-3col">
        <div class="card-clean" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-md); background: var(--surface-low); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div>
                <div class="font-mono" style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); line-height: 1.1;"><?= count($pending_needs) ?> Pengajuan</div>
                <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-top: 0.125rem;">Antrean Peninjauan KIA</div>
            </div>
        </div>

        <div class="card-clean" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-md); background: var(--surface-low); color: <?= $open_dispute_count > 0 ? 'var(--danger)' : 'var(--text-muted)' ?>; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div>
                <div class="font-mono" style="font-size: 1.5rem; font-weight: 700; color: <?= $open_dispute_count > 0 ? 'var(--danger)' : 'var(--text-main)' ?>; line-height: 1.1;"><?= $open_dispute_count ?> Laporan</div>
                <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-top: 0.125rem;">Kendala Serah Terima Aktif</div>
            </div>
        </div>

        <div class="card-clean" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-md); background: var(--surface-low); color: var(--botanical); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <div class="font-mono" style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); line-height: 1.1;"><?= $archived_dispute_count ?> Arsip</div>
                <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-top: 0.125rem;">Kendala Final Terkunci</div>
            </div>
        </div>
    </section>

    <!-- Section 1: Antrean Pengajuan Menunggu Peninjauan (Table Desktop -> Stacked Cards Mobile) -->
    <section class="card-clean" style="padding: 0; overflow: hidden;">
        <header style="padding: clamp(1rem, 3vw, 1.5rem) clamp(1rem, 3.5vw, 1.75rem); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <div>
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                    Proses Verifikasi Klinis
                </span>
                <h2 style="font-size: clamp(1.2rem, 3.8vw, 1.35rem); font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                    Antrean Pengajuan Menunggu Peninjauan (<?= count($pending_needs) ?>)
                </h2>
                <p style="font-size: 0.86rem; color: var(--text-muted); margin: 0;">
                    Periksa kejelasan tanggal pemeriksaan dan ukuran LILA pada berkas Buku KIA sebelum menyetujui.
                </p>
            </div>
        </header>

        <?php if (empty($pending_needs)): ?>
            <div style="text-align: center; padding: clamp(2rem, 5vw, 3rem) 1.25rem; border-top: 0.0625rem solid var(--border-subtle); background: var(--surface-low);">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.25rem;">Seluruh Berkas Telah Terverifikasi</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Tidak ada pengajuan baru yang menunggu peninjauan saat ini.</p>
            </div>
        <?php else: ?>
            <div class="clinical-table-wrap">
                <table class="clinical-table">
                    <thead>
                        <tr>
                            <th>Kode &amp; Pengaju</th>
                            <th>Indikator LILA</th>
                            <th>Paket Pangan &amp; Posyandu</th>
                            <th>Berkas KIA</th>
                            <th style="min-width: 19.375rem;">Catatan &amp; Keputusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_needs as $pn): ?>
                            <?php $isKek = (float)$pn['lila_measurement'] < 23.5; ?>
                            <tr>
                                <td data-label="Kode &amp; Pengaju">
                                    <div style="display: flex; flex-direction: column; gap: 0.1875rem;">
                                        <span class="font-mono" style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">#NTR-<?= str_pad($pn['id'], 4, '0', STR_PAD_LEFT) ?></span>
                                        <strong style="color: var(--text-main); font-size: 0.92rem;"><?= htmlspecialchars($pn['full_name']) ?></strong>
                                        <span style="font-size: 0.78rem; color: var(--text-muted);">HP: <?= htmlspecialchars($pn['phone_number']) ?></span>
                                        <span style="font-size: 0.76rem; color: var(--text-muted);"><?= format_datetime_id($pn['submitted_at']) ?></span>
                                    </div>
                                </td>
                                <td data-label="Indikator LILA">
                                    <span class="<?= $isKek ? 'status-kek-text' : 'status-normal-text' ?>" style="white-space: nowrap;">
                                        <?= number_format((float)$pn['lila_measurement'], 1) ?> cm · <?= $isKek ? 'KEK' : 'Normal' ?>
                                    </span>
                                </td>
                                <td data-label="Paket Pangan &amp; Posyandu">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem; max-width: min(18.75rem, 100%);">
                                        <strong style="color: var(--text-main); font-size: 0.9rem;"><?= htmlspecialchars($pn['title']) ?></strong>
                                        <span style="color: var(--text-main); font-size: 0.84rem; line-height: 1.45;"><?= nl2br(htmlspecialchars($pn['food_items_needed'])) ?></span>
                                        <span style="font-size: 0.78rem; font-weight: 700; color: var(--botanical);"><?= htmlspecialchars($pn['drop_point_name']) ?></span>
                                        <span style="font-size: 0.76rem; color: var(--text-muted);"><?= htmlspecialchars($pn['description']) ?></span>
                                    </div>
                                </td>
                                <td data-label="Berkas KIA">
                                    <div style="display: flex; flex-direction: column; gap: 0.375rem; align-items: flex-start;">
                                        <button
                                            type="button"
                                            class="btn-ghost-clean btn-sm"
                                            onclick="openKiaInspector('index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>', 'Buku KIA: <?= htmlspecialchars(addslashes($pn['full_name'])) ?> (LILA <?= number_format($pn['lila_measurement'], 1) ?> cm)')">
                                            Inspeksi KIA
                                        </button>
                                        <a
                                            href="index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>"
                                            target="_blank"
                                            style="font-size: 0.76rem; font-weight: 600; color: var(--primary);">
                                            Tab Baru ↗
                                        </a>
                                    </div>
                                </td>
                                <td data-label="Catatan &amp; Keputusan">
                                    <form action="index.php?action=admin-update-status" method="POST" style="display: flex; flex-direction: column; gap: 0.5rem;">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                        <input type="hidden" name="need_id" value="<?= $pn['id'] ?>">

                                        <input
                                            type="text"
                                            id="admin_notes_<?= $pn['id'] ?>"
                                            name="admin_notes"
                                            class="form-control"
                                            style="padding: 0.5rem 0.75rem; font-size: 0.94rem;"
                                            placeholder="Catatan evaluasi (wajib jika revisi/tolak)">

                                        <div style="display: flex; gap: 0.375rem; flex-wrap: wrap;">
                                            <button type="submit" name="action" value="approve" class="btn-botanical btn-sm" data-confirm="Setujui dan publikasikan kebutuhan ini ke katalog publik?">
                                                Setujui
                                            </button>
                                            <button type="submit" name="action" value="revision" class="btn-warning btn-sm" data-confirm="Minta ibu hamil memperbaiki dokumen atau data pengajuan?">
                                                Revisi
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn-danger-outline btn-sm" data-confirm="Tolak pengajuan ini secara permanen?">
                                                Tolak
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <!-- Section 2: Laporan Kendala / Dispute -->
    <section class="card-clean" style="padding: clamp(1rem, 3.5vw, 1.75rem); display: flex; flex-direction: column; gap: 1.25rem;">
        <header style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.625rem;">
            <div>
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--danger); display: block; margin-bottom: 0.25rem;">
                    Eskalasi Masalah Aktif
                </span>
                <h2 style="font-size: clamp(1.2rem, 3.8vw, 1.35rem); font-weight: 700; color: var(--text-main); margin: 0;">
                    Laporan Kendala Bantuan (<?= $open_dispute_count ?> Aktif)
                </h2>
            </div>
            <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">
                Arsip Terkunci: <?= $archived_dispute_count ?> Selesai
            </span>
        </header>

        <?php if (empty($active_disputes)): ?>
            <div class="inset-well" style="text-align: center; padding: clamp(1.5rem, 4vw, 2.25rem) 1.25rem;">
                <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">
                    Tidak ada laporan kendala aktif saat ini. Seluruh penyaluran berjalan lancar.
                </p>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 1.125rem;">
                <?php foreach ($active_disputes as $dispute): ?>
                    <?php $current_status = $dispute['status']; ?>
                    <article class="card-clean" style="padding: clamp(1rem, 3vw, 1.375rem);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.625rem; margin-bottom: 0.75rem;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.25rem;">
                                    <span class="font-mono" style="font-size: 0.78rem; font-weight: 700; color: var(--danger);">#DSP-<?= str_pad((int)$dispute['dispute_id'], 4, '0', STR_PAD_LEFT) ?></span>
                                    <span style="font-size: 0.82rem; color: var(--text-muted);">· <?= htmlspecialchars($dispute['drop_point_name']) ?> · <?= format_datetime_id($dispute['dispute_created_at']) ?></span>
                                </div>
                                <h3 style="margin: 0 0 0.25rem 0; font-size: 1.12rem; font-weight: 700; color: var(--text-main);">
                                    <?= htmlspecialchars($dispute['need_title']) ?>
                                </h3>
                                <span style="font-size: 0.84rem; color: var(--text-muted);">
                                    Pelapor: <strong style="color: var(--text-main);"><?= htmlspecialchars($dispute['reporter_name']) ?></strong> · Kontak: <span class="font-mono"><?= htmlspecialchars($dispute['reporter_phone']) ?></span>
                                </span>
                            </div>

                            <span style="font-size: 0.8rem; font-weight: 700; color: <?= $current_status === 'open' ? 'var(--danger)' : 'var(--warning)' ?>;">
                                <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?>
                            </span>
                        </div>

                        <div class="inset-well" style="border-left: 0.1875rem solid var(--danger); border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.875rem 1rem; margin-bottom: 0.875rem;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--danger); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 0.25rem;">
                                Isi Laporan Kendala
                            </span>
                            <p style="margin: 0; color: var(--text-main); font-weight: 500; line-height: 1.55; font-size: 0.9rem;">
                                <?= nl2br(htmlspecialchars($dispute['reason'])) ?>
                            </p>
                        </div>

                        <?php if (!empty($dispute['dispute_admin_notes'])): ?>
                            <div class="inset-well" style="border-left: 0.1875rem solid var(--primary); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; padding: 0.75rem 0.875rem; font-size: 0.86rem; color: var(--primary-dark); margin-bottom: 0.875rem;">
                                <strong>Catatan Admin Sebelumnya:</strong>
                                <?= nl2br(htmlspecialchars($dispute['dispute_admin_notes'])) ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?action=admin-update-dispute" method="POST" class="dispute-action-form inset-well" style="padding: 1rem;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="dispute_id" value="<?= (int)$dispute['dispute_id'] ?>">
                            <input type="hidden" name="status" value="" class="dispute-status-input">

                            <div class="form-group" style="margin-bottom: 0.75rem;">
                                <label>Tindak Lanjut &amp; Catatan Penanganan Admin</label>
                                <textarea
                                    name="admin_notes"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Tuliskan hasil koordinasi dengan Posyandu atau donatur..."><?= htmlspecialchars($dispute['dispute_admin_notes'] ?? '') ?></textarea>
                            </div>

                            <div style="display: flex; gap: 0.625rem; flex-wrap: wrap;">
                                <button type="button" onclick="submitDisputeDirect(this, 'under_review')" class="btn-ghost-clean btn-sm">
                                    Tandai Sedang Ditinjau
                                </button>
                                <button type="button" onclick="openDisputeConfirmModal(this, 'resolved')" class="btn-cerulean btn-sm">
                                    Selesaikan Laporan
                                </button>
                                <button type="button" onclick="openDisputeConfirmModal(this, 'rejected')" class="btn-danger-outline btn-sm">
                                    Tolak Laporan
                                </button>
                            </div>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($archived_disputes)): ?>
            <div style="padding-top: 1.25rem; border-top: 0.0625rem solid var(--border-subtle);">
                <details>
                    <summary style="cursor: pointer; font-weight: 700; font-size: 0.92rem; color: var(--primary); user-select: none;">
                        Riwayat Kendala Selesai / Terkunci (<?= $archived_dispute_count ?> Arsip Final)
                    </summary>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 0.875rem;">
                        <?php foreach ($archived_disputes as $dispute): ?>
                            <?php $current_status = $dispute['status']; ?>
                            <div class="inset-well" style="border: 0.0625rem solid var(--border-color); padding: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.375rem;">
                                    <div>
                                        <h4 style="margin: 0 0 0.125rem 0; font-size: 1rem; font-weight: 700; color: var(--text-main);">
                                            <?= htmlspecialchars($dispute['need_title']) ?>
                                        </h4>
                                        <span style="font-size: 0.82rem; color: var(--text-muted);">
                                            Pelapor: <strong style="color: var(--text-main);"><?= htmlspecialchars($dispute['reporter_name']) ?></strong> · <?= htmlspecialchars($dispute['drop_point_name']) ?>
                                        </span>
                                    </div>
                                    <span style="font-size: 0.78rem; font-weight: 700; color: <?= $current_status === 'resolved' ? 'var(--botanical)' : 'var(--text-muted)' ?>;">
                                        <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?> (Terkunci)
                                    </span>
                                </div>
                                <p style="margin: 0 0 0.5rem 0; font-size: 0.86rem; color: var(--text-main);">
                                    <strong>Kendala:</strong> <?= nl2br(htmlspecialchars($dispute['reason'])) ?>
                                </p>
                                <?php if (!empty($dispute['dispute_admin_notes'])): ?>
                                    <div style="font-size: 0.84rem; color: var(--primary-dark); background: var(--surface-lowest); border-left: 0.1875rem solid var(--primary); padding: 0.5rem 0.75rem; border-radius: 0 var(--radius-sm) var(--radius-sm) 0;">
                                        <strong>Catatan Penyelesaian Admin:</strong> <?= nl2br(htmlspecialchars($dispute['dispute_admin_notes'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </details>
            </div>
        <?php endif; ?>
    </section>

    <!-- Modal / Bottom-Sheet Konfirmasi Penyelesaian Masalah (Admin) -->
    <div id="dispute-confirm-modal" class="nurtura-modal-backdrop" onclick="closeDisputeConfirmModal()" role="dialog" aria-modal="true" style="display: none;">
        <div class="nurtura-modal-card" onclick="event.stopPropagation()">
            <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--primary); margin-bottom: 0.25rem;">
                Verifikasi Tindakan Final
            </div>
            <h3 id="dispute-confirm-title" style="font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.625rem 0;">
                Apakah masalah ini benar-benar sudah selesai?
            </h3>
            <p id="dispute-confirm-desc" style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0 0 1.25rem 0;">
                Setelah ditetapkan selesai, status laporan ini akan dikunci secara permanen, dipindahkan ke arsip riwayat, dan tidak dapat diubah kembali.
            </p>
            <div style="display: flex; gap: 0.625rem; justify-content: flex-end; flex-wrap: wrap;">
                <button type="button" onclick="closeDisputeConfirmModal()" class="btn-ghost-clean btn-sm" style="padding: 0.5625rem 1.25rem;">
                    Batal
                </button>
                <button type="button" id="dispute-confirm-submit-btn" onclick="confirmDisputeAction()" class="btn-cerulean btn-sm" style="padding: 0.5625rem 1.375rem;">
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

<!-- Reusable Modal / Bottom-Sheet Inspeksi Buku KIA (Zoom & Rotate) -->
<div id="kia-inspector-modal" class="kia-inspector-modal" onclick="closeKiaInspector()">
    <div class="kia-inspector-content" onclick="event.stopPropagation()">
        <div class="kia-inspector-header">
            <div>
                <h3 id="kia-inspect-title" style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--text-main);">
                    Inspeksi Lembar Catatan Buku KIA
                </h3>
                <span style="font-size: 0.78rem; color: var(--text-muted);">
                    Periksa stempel faskes, paraf bidan, dan grafik LILA
                </span>
            </div>
            <div class="kia-inspector-toolbar">
                <button type="button" class="btn-ghost-clean btn-sm" onclick="zoomKia(0.25)" title="Perbesar">Zoom (+)</button>
                <button type="button" class="btn-ghost-clean btn-sm" onclick="zoomKia(-0.25)" title="Perkecil">Zoom (-)</button>
                <button type="button" class="btn-ghost-clean btn-sm" onclick="rotateKia()" title="Putar 90 Derajat">Putar 90°</button>
                <button type="button" class="btn-ghost-clean btn-sm" onclick="resetKia()" title="Reset Ukuran">Reset</button>
                <button type="button" class="modal-close-circle" onclick="closeKiaInspector()" aria-label="Tutup inspeksi KIA">&times;</button>
            </div>
        </div>
        <div class="kia-inspector-body">
            <img id="kia-inspect-img" src="" alt="Lembar Dokumen KIA" class="kia-inspect-img">
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
