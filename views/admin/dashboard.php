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

<div style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 style="font-size: 1.7rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em;">
                Panel Verifikasi & Moderasi Medis (NurturaGuard)
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
                Validasi keabsahan dokumen Buku KIA, evaluasi indikator gizi LILA (&lt; 23,5 cm), serta penanganan kendala serah terima pangan.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <span class="badge badge-secondary" style="font-size: 0.82rem; padding: 6px 14px;">
                Role: Administrator Sistem
            </span>
        </div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php
            if ($_GET['msg'] === 'status_diperbarui') echo "Status pengajuan berhasil diperbarui dan notifikasi telah dikirimkan.";
            elseif ($_GET['msg'] === 'dispute_diperbarui') echo "Status laporan kendala bantuan berhasil diperbarui.";
        ?>
    </div>
<?php endif; ?>

<!-- Ringkasan Statistik Tugas Admin -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 28px;">
    <div class="card" style="border: 1px solid var(--border-color); padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
        </div>
        <div>
            <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;">Antrean Peninjauan KIA</span>
            <div style="font-size: 1.6rem; font-weight: 900; color: #0f172a; line-height: 1.2;">
                <?= count($pending_needs) ?> <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Pengajuan</span>
            </div>
        </div>
    </div>

    <div class="card" style="border: 1px solid var(--border-color); padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: <?= $open_dispute_count > 0 ? '#fee2e2' : '#f1f5f9' ?>; color: <?= $open_dispute_count > 0 ? '#b91c1c' : '#64748b' ?>; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div>
            <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;">Laporan Kendala Terbuka</span>
            <div style="font-size: 1.6rem; font-weight: 900; color: <?= $open_dispute_count > 0 ? '#b91c1c' : '#0f172a' ?>; line-height: 1.2;">
                <?= $open_dispute_count ?> <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Laporan Baru</span>
            </div>
        </div>
    </div>
</div>

<!-- Section 1: Antrean Pengajuan Menunggu Peninjauan -->
<div class="card" style="border: 1px solid var(--border-color); padding: 28px; margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                Antrean Pengajuan Menunggu Peninjauan (<?= count($pending_needs) ?>)
            </h2>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                Pastikan lembar Buku KIA menunjukkan identitas ibu hamil yang valid, data kehamilan aktif, stempel posyandu/bidan, dan ukuran LILA akurat.
            </p>
        </div>
        <span class="badge badge-info" style="font-size: 0.75rem;">SOP Medis Kemenkes</span>
    </div>

    <?php if (empty($pending_needs)): ?>
        <div style="text-align: center; padding: 44px 20px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
            <div style="width: 44px; height: 44px; background: #e0f2fe; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; color: #0284c7;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Seluruh Berkas Telah Terverifikasi</h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Tidak ada pengajuan baru yang menunggu peninjauan saat ini.</p>
        </div>
    <?php else: ?>
        <?php foreach ($pending_needs as $pn): ?>
            <div style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 22px; margin-bottom: 20px; background: #ffffff;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                            <?= htmlspecialchars($pn['title']) ?>
                        </h3>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">
                            Pengaju: <strong><?= htmlspecialchars($pn['full_name']) ?></strong> (HP: <?= htmlspecialchars($pn['phone_number']) ?>) • Diajukan: <?= format_datetime_id($pn['submitted_at']) ?>
                        </span>
                    </div>
                    <div>
                        <?php if ($pn['lila_measurement'] < 23.5): ?>
                            <span class="badge badge-coral" style="font-size: 0.8rem; padding: 6px 12px;">
                                LILA: <?= number_format($pn['lila_measurement'], 1) ?> cm (Indikasi KEK)
                            </span>
                        <?php else: ?>
                            <span class="badge badge-success" style="font-size: 0.8rem; padding: 6px 12px;">
                                LILA: <?= number_format($pn['lila_measurement'], 1) ?> cm (Normal)
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); font-size: 0.92rem; margin-bottom: 14px;">
                    <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                        Paket Pangan yang Diajukan:
                    </span>
                    <p style="margin: 0; color: #1e293b; font-weight: 600; line-height: 1.5;"><?= nl2br(htmlspecialchars($pn['food_items_needed'])) ?></p>
                </div>

                <div style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 18px; line-height: 1.5;">
                    <div><strong>Alasan Kebutuhan:</strong> <?= htmlspecialchars($pn['description']) ?></div>
                    <div style="margin-top: 2px;"><strong>Drop-Point Posyandu:</strong> <span style="color: #0f172a; font-weight: 700;"><?= htmlspecialchars($pn['drop_point_name']) ?></span></div>
                </div>

                <!-- Berkas Medis Buku KIA (Akses Aman Controller & Inspeksi Langsung) -->
                <div style="margin-bottom: 20px; padding: 16px; background: #f0f9ff; border-radius: var(--radius-sm); border: 1px solid #bae6fd; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div style="width: 32px; height: 32px; background: #e0f2fe; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #0284c7;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div>
                            <span style="font-size: 0.88rem; font-weight: 800; color: #0369a1; display: block;">Dokumen Lampiran Buku KIA</span>
                            <span style="font-size: 0.78rem; color: #0284c7;">Tersimpan aman di storage privat terisolasi</span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button
                            type="button"
                            class="btn btn-secondary btn-sm"
                            style="background: #ffffff; border: 1px solid #93c5fd; font-weight: 700;"
                            onclick="openKiaInspector('index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>', 'Buku KIA: <?= htmlspecialchars(addslashes($pn['full_name'])) ?> (LILA <?= number_format($pn['lila_measurement'], 1) ?> cm)')">
                            Buka Inspeksi Lembar KIA
                        </button>
                        <a
                            href="index.php?action=view-kia&file=<?= urlencode($pn['kia_document_path']) ?>"
                            target="_blank"
                            class="btn btn-secondary btn-sm"
                            style="background: #ffffff; border: 1px solid var(--border-color); font-size: 0.8rem;"
                            title="Buka di tab terpisah">
                            Tab Baru
                        </a>
                    </div>
                </div>

                <!-- Form Keputusan Admin -->
                <form action="index.php?action=admin-update-status" method="POST" style="background: #f8fafc; border: 1px solid var(--border-color); padding: 18px; border-radius: var(--radius-sm);">
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
                            Setujui (Publikasikan)
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
    <?php endif; ?>
</div>

<!-- Section 2: Laporan Kendala / Dispute -->
<div class="card" style="border: 1px solid var(--border-color); padding: 28px; margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                Laporan Kendala Bantuan (<?= $open_dispute_count ?> Laporan Baru)
            </h2>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                Daftar laporan kendala penerimaan bantuan yang disampaikan oleh ibu hamil. Periksa dan tentukan tindak lanjut penanganan.
            </p>
        </div>
    </div>

    <?php if (empty($disputes)): ?>
        <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
            <p style="color: var(--text-muted); font-size: 0.92rem; margin: 0;">
                Tidak ada laporan kendala bantuan saat ini.
            </p>
        </div>
    <?php else: ?>
        <?php foreach ($disputes as $dispute): ?>
            <div style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 22px; margin-bottom: 18px; background: #ffffff;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 12px;">
                    <div>
                        <h4 style="margin: 0 0 4px 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">
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
                    <span class="badge <?= $status_badge_classes[$current_status] ?? 'badge-secondary' ?>" style="font-size: 0.76rem; padding: 5px 12px;">
                        <?= $status_labels[$current_status] ?? htmlspecialchars($current_status) ?>
                    </span>
                </div>

                <div style="background: #fff7ed; border: 1px solid #fed7aa; padding: 14px 18px; border-radius: var(--radius-sm); margin-bottom: 14px;">
                    <span style="font-size: 0.74rem; font-weight: 800; color: #9a3412; text-transform: uppercase; letter-spacing: 0.03em; display: block; margin-bottom: 4px;">
                        Isi Laporan Kendala:
                    </span>
                    <p style="margin: 0; color: #7c2d12; font-weight: 600; line-height: 1.5;">
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

                <form action="index.php?action=admin-update-dispute" method="POST" style="background: #f8fafc; border: 1px solid var(--border-color); padding: 16px; border-radius: var(--radius-sm);">
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
    <?php endif; ?>
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
