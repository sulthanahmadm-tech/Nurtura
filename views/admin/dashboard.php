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
                <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <span class="badge badge-info">NurturaGuard · Panel Medis & Verifikasi</span>
                    <span class="badge badge-secondary" style="font-weight: 700;">Role: Administrator Medis</span>
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
    <div class="card-modern" style="border: 1px solid rgba(226, 232, 240, 0.9); padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #b91c1c;">
                    Eskalasi Masalah
                </span>
                <h2 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                    Laporan Kendala Bantuan (<?= $open_dispute_count ?> Laporan Baru)
                </h2>
            </div>
        </div>

        <?php if (empty($disputes)): ?>
            <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1;">
                <p style="color: var(--text-muted); font-size: 0.92rem; margin: 0;">
                    Tidak ada laporan kendala bantuan saat ini. Seluruh penyaluran berjalan lancar.
                </p>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 18px;">
                <?php foreach ($disputes as $dispute): ?>
                    <div class="card-3d-tactile" style="padding: 22px; background: #ffffff;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 12px;">
                            <div>
                                <h4 style="margin: 0 0 4px 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">
                                    <?= htmlspecialchars($dispute['need_title']) ?>
                                </h4>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">
                                    Pelapor: <strong><?= htmlspecialchars($dispute['reporter_name']) ?></strong> • No. Kontak: <?= htmlspecialchars($dispute['reporter_phone']) ?>
                                </span>
                            </div>

                            <?php
                                $status_labels = [
                                    'open' => 'Menunggu Penanganan',
                                    'under_review' => 'Sedang Ditinjau',
                                    'resolved' => 'Selesai',
                                    'rejected' => 'Ditolak'
                                ];
                                $status_badge_classes = [
                                    'open' => 'badge-danger',
                                    'under_review' => 'badge-warning',
                                    'resolved' => 'badge-success',
                                    'rejected' => 'badge-secondary'
                                ];
                                $current_status = $dispute['status'];
                            ?>
                            <span class="badge <?= $status_badge_classes[$current_status] ?? 'badge-secondary' ?>" style="font-size: 0.78rem; padding: 6px 14px;">
                                <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?>
                            </span>
                        </div>

                        <div style="background: #fff7ed; border: 1px solid #fed7aa; padding: 14px 18px; border-radius: 12px; margin-bottom: 14px;">
                            <span style="font-size: 0.74rem; font-weight: 800; color: #9a3412; text-transform: uppercase; letter-spacing: 0.03em; display: block; margin-bottom: 4px;">
                                Isi Laporan Kendala:
                            </span>
                            <p style="margin: 0; color: #7c2d12; font-weight: 600; line-height: 1.5; font-size: 0.92rem;">
                                <?= nl2br(htmlspecialchars($dispute['reason'])) ?>
                            </p>
                        </div>

                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 14px; line-height: 1.5;">
                            <div>Drop-Point Posyandu: <strong style="color: #0f172a;"><?= htmlspecialchars($dispute['drop_point_name']) ?></strong></div>
                            <div>Waktu Laporan Diajukan: <?= format_datetime_id($dispute['dispute_created_at']) ?></div>
                        </div>

                        <?php if (!empty($dispute['dispute_admin_notes'])): ?>
                            <div class="alert alert-info" style="font-size: 0.88rem; padding: 10px 14px; margin-bottom: 14px;">
                                <strong>Catatan Admin Sebelumnya:</strong>
                                <?= nl2br(htmlspecialchars($dispute['dispute_admin_notes'])) ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?action=admin-update-dispute" method="POST" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 16px; border-radius: 12px;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="dispute_id" value="<?= (int)$dispute['dispute_id'] ?>">

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
                                <button type="submit" name="status" value="under_review" class="btn btn-warning">
                                    Tandai Sedang Ditinjau
                                </button>
                                <button type="submit" name="status" value="resolved" class="btn btn-primary">
                                    Selesaikan Laporan
                                </button>
                                <button type="submit" name="status" value="rejected" class="btn btn-sm" style="background: #ffffff; border: 1px solid #fecaca; color: #b91c1c; font-weight: 700;" data-confirm="Tolak laporan kendala ini?">
                                    Tolak Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
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
