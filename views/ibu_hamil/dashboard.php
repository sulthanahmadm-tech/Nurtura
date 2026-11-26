<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$nama_ibu       = $profile['full_name'] ?? $_SESSION['user']['full_name'] ?? 'Bunda';
$usia_minggu    = (int)($gestationalWeeks ?? $profile['gestational_age_weeks'] ?? 0);
$usia_hari      = $usia_minggu * 7;
$progress_pct   = $usia_minggu > 0 ? min(100, round(($usia_minggu / 40) * 100)) : 0;
$hpl_formatted  = !empty($profile['estimated_birth_date']) ? date('d M Y', strtotime($profile['estimated_birth_date'])) : 'Belum diisi';

$raw_lila       = $lilaValue ?? $profile['lila_cm'] ?? null;
$has_lila       = ($raw_lila !== null && $raw_lila !== '' && (float)$raw_lila > 0);
$lila_tampil    = $has_lila ? number_format((float)$raw_lila, 1) : '-';
$is_kek         = $has_lila && ((float)$raw_lila < 23.5);

$domisili       = trim(($profile['district'] ?? '') . ', ' . ($profile['regency_city'] ?? ''), ', ');
if ($domisili === '') $domisili = 'Belum diisi';

$status_lila    = !$has_lila ? 'Belum Ada Data' : ($is_kek ? 'Risiko KEK (< 23,5 cm)' : 'Normal / Aman (≥ 23,5 cm)');
$needs_list     = is_array($needs ?? null) ? $needs : [];

$aktif_count    = 0;
$selesai_count  = 0;
foreach ($needs_list as $item) {
    if (($item['status'] ?? '') === 'selesai') {
        $selesai_count++;
    } else {
        $aktif_count++;
    }
}
?>

<div style="display: flex; flex-direction: column; gap: 1.75rem; padding-bottom: 2rem;">

    <!-- 1. Greeting Header -->
    <section style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
        <div>
            <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.375rem;">
                NurturaCare · Panel Ibu Hamil <?= $usia_minggu > 0 ? '· Trimester ' . ($usia_minggu <= 13 ? '1' : ($usia_minggu <= 27 ? '2' : '3')) : '' ?>
            </span>
            <h1 style="font-size: clamp(1.5rem, 4.5vw, 2.15rem); font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                Halo, <?= htmlspecialchars($nama_ibu) ?>!
            </h1>
            <p style="color: var(--text-muted); font-size: 0.94rem; margin: 0;">
                <?= $usia_minggu > 0 ? "Hari ke-{$usia_hari} perjalanan kehamilan Anda (Minggu ke-{$usia_minggu}). Pantau status gizi dan penyaluran pangan di sini." : "Pantau status gizi dan penyaluran bantuan paket pangan Anda di sini." ?>
            </p>
        </div>

        <a href="index.php?page=create-need" class="btn-cerulean" style="padding: 0.6875rem 1.375rem;">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Ajukan Kebutuhan Gizi
        </a>
    </section>

    <!-- Notifikasi Flash Message -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 0;" role="status">
            <?php
            if ($_GET['msg'] === 'pengajuan_berhasil') echo "Pengajuan berhasil dikirim dan sedang menunggu validasi berkas Buku KIA oleh tim admin NurturaGuard.";
            elseif ($_GET['msg'] === 'bantuan_selesai') echo "Terima kasih! Konfirmasi penerimaan paket telah disimpan. Semoga bermanfaat untuk kesehatan ibu dan janin.";
            elseif ($_GET['msg'] === 'dispute_diajukan') echo "Laporan kendala berhasil diajukan dan sedang ditangani oleh admin NurturaGuard.";
            else echo "Perubahan berhasil disimpan.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" style="margin: 0;" role="alert">
            <?php
            if ($_GET['error'] === 'gagal_konfirmasi') echo "Gagal melakukan konfirmasi penerimaan paket. Silakan coba kembali.";
            elseif ($_GET['error'] === 'alasan_wajib_diisi') echo "Alasan kendala wajib diisi.";
            else echo "Terjadi kesalahan pada sistem.";
            ?>
        </div>
    <?php endif; ?>

    <!-- 2. 3-Column Clinical Summary Grid -->
    <section aria-label="Ringkasan Kehamilan dan Gizi" class="grid-3col" style="align-items: stretch;">

        <!-- Card 1: Usia Kehamilan & Progress -->
        <article class="card-clean" style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
            <header style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;">
                <h2 style="font-family: var(--font-sans); font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0;">Usia Kehamilan</h2>
                <?php if ($usia_minggu > 0): ?>
                    <span class="font-mono" style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">Minggu <?= $usia_minggu ?></span>
                <?php endif; ?>
            </header>

            <div style="text-align: center;">
                <div class="pregnancy-orb">
                    <div class="pregnancy-orb-inner fetus-glow"></div>
                    <div style="position: relative; z-index: 10; text-align: center; color: var(--on-primary); padding: 0 0.75rem;">
                        <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-container); font-weight: 700; display: block;">
                            Kehamilan
                        </span>
                        <div class="font-mono" style="font-size: clamp(1.5rem, 5vw, 1.95rem); font-weight: 700; line-height: 1.1; margin: 0.25rem 0;">
                            <?= $usia_minggu > 0 ? $usia_minggu . ' <span style="font-size: 0.9rem; font-weight: 500;">Mg</span>' : 'KIA' ?>
                        </div>
                        <div style="font-size: 0.75rem; color: var(--primary-container); line-height: 1.35;">
                            HPL: <strong style="color: #FFFFFF;"><?= htmlspecialchars($hpl_formatted) ?></strong>
                        </div>
                    </div>
                </div>
                <div class="pregnancy-ring-orbit"></div>
            </div>

            <div class="inset-well" style="padding: 0.75rem 0.875rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="font-mono" style="font-size: 0.88rem; font-weight: 700; color: var(--text-main);"><?= $usia_minggu ?> / 40 Mg</span>
                    <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted);"><?= $progress_pct ?>% Jalan</span>
                </div>
                <div style="width: 100%; height: 0.5rem; border-radius: var(--radius-pill); background: var(--surface-high); overflow: hidden;">
                    <div style="height: 100%; width: <?= $progress_pct ?>%; border-radius: var(--radius-pill); background: var(--primary);"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.76rem; padding-top: 0.25rem;">
                    <span style="color: var(--text-muted);">Wilayah Posyandu</span>
                    <span style="font-weight: 700; color: var(--botanical);"><?= htmlspecialchars($domisili) ?></span>
                </div>
            </div>
        </article>

        <!-- Card 2: Indikator LILA Klinis -->
        <article class="card-clean" style="display: flex; flex-direction: column; justify-content: space-between; gap: 0.875rem;">
            <header style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;">
                <h2 style="font-family: var(--font-sans); font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0;">Indikator LILA Klinis</h2>
                <span style="font-size: 0.76rem; font-weight: 700; color: <?= !$has_lila ? 'var(--text-muted)' : ($is_kek ? 'var(--danger)' : 'var(--botanical)') ?>;">
                    <?= htmlspecialchars($status_lila) ?>
                </span>
            </header>

            <div style="padding: 0.25rem 0;">
                <div id="lila-gauge-dashboard" data-medical-chart="lila-gauge" data-lila="<?= $has_lila ? (float)$raw_lila : 0 ?>"></div>
            </div>

            <div class="inset-well" style="border-left: 0.1875rem solid <?= !$has_lila ? 'var(--outline)' : ($is_kek ? 'var(--danger)' : 'var(--botanical)') ?>; border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.75rem 0.875rem;">
                <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.1875rem;">
                    <?= !$has_lila ? 'Informasi Pengukuran' : ($is_kek ? 'Perhatian Gizi (Risiko KEK)' : 'Status Gizi Baik') ?>
                </div>
                <p style="font-size: 0.78rem; color: var(--text-muted); margin: 0; line-height: 1.5;">
                    <?= !$has_lila ? 'Ukuran LILA belum tercatat. Ambang batas normal minimal standar Kemenkes adalah 23,5 cm.' : ($is_kek ? 'LILA di bawah 23,5 cm menandakan risiko Kurang Energi Kronis. Prioritaskan asupan protein hewani dan konsultasikan rutin ke bidan Posyandu.' : 'Ukuran LILA memenuhi standar Kemenkes. Pertahankan pola makan bergizi seimbang dan konsumsi Tablet Tambah Darah (TTD).') ?>
                </p>
            </div>
        </article>

        <!-- Card 3: Ocean Cerulean CTA Card -->
        <article class="card-cerulean" style="display: flex; flex-direction: column; justify-content: space-between; gap: 1.25rem;">
            <div>
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary-container); display: block; margin-bottom: 0.375rem;">
                    Program Pangan Posyandu
                </span>
                <h2 style="font-family: var(--font-display); font-size: clamp(1.25rem, 4vw, 1.45rem); font-weight: 700; color: var(--on-primary); margin: 0 0 0.625rem 0; line-height: 1.25;">
                    Butuh Paket Pangan Tambahan?
                </h2>
                <p style="font-size: 0.88rem; color: var(--on-primary); opacity: 0.92; line-height: 1.6; margin: 0;">
                    Ajukan kebutuhan protein hewani, susu ibu hamil, atau suplemen bergizi dengan melampirkan catatan Buku KIA terbaru untuk diverifikasi admin medis.
                </p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="background: var(--primary-dark); border-radius: var(--radius-md); padding: 0.875rem 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; font-weight: 600; color: var(--on-primary);">Total Pengajuan Anda</span>
                    <span class="font-mono" style="font-size: 1.15rem; font-weight: 700; color: #FFFFFF;"><?= count($needs_list) ?> Paket</span>
                </div>
                <a href="index.php?page=create-need" class="btn-white" style="width: 100%;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Buat Pengajuan Baru
                </a>
            </div>
        </article>

    </section>

    <!-- 3. Riwayat Pengajuan Kebutuhan Pangan -->
    <section style="display: flex; flex-direction: column; gap: 1.125rem;">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 0.875rem;">
            <div>
                <h2 style="font-size: clamp(1.25rem, 4vw, 1.45rem); font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                    Riwayat Pengajuan Kebutuhan Pangan
                </h2>
                <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                    Pantau tahapan verifikasi KIA hingga serah terima paket di Posyandu.
                </p>
            </div>

            <?php if (!empty($needs_list)): ?>
                <div class="filter-tabs-clean" style="margin-top: 0;" role="group" aria-label="Filter riwayat pengajuan">
                    <button type="button" class="filter-tab-btn status-tab active" data-status="all" onclick="filterIbuHistory('all', this)">Semua (<?= count($needs_list) ?>)</button>
                    <button type="button" class="filter-tab-btn status-tab" data-status="aktif" onclick="filterIbuHistory('aktif', this)">Proses / Aktif (<?= $aktif_count ?>)</button>
                    <button type="button" class="filter-tab-btn status-tab" data-status="selesai" onclick="filterIbuHistory('selesai', this)">Selesai Diterima (<?= $selesai_count ?>)</button>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($needs_list)): ?>
            <div class="card-clean" style="text-align: center; padding: clamp(2rem, 6vw, 3.25rem) 1.5rem;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.375rem;">
                    Belum Ada Pengajuan Kebutuhan Pangan
                </h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; max-width: min(28.75rem, 100%); margin: 0 auto 1.25rem auto; line-height: 1.55;">
                    Ajukan paket pangan bergizi agar tim NurturaGuard dapat meninjau data Buku KIA Anda dan menghubungkannya dengan donatur.
                </p>
                <a href="index.php?page=create-need" class="btn-cerulean">
                    + Mulai Ajukan Kebutuhan Gizi
                </a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 1.125rem;">
                <?php foreach ($needs_list as $n): ?>
                    <?php
                        $st = $n['status'] ?? '';
                        $itemGroup = ($st === 'selesai') ? 'selesai' : 'aktif';
                    ?>
                    <article class="card-clean history-item" data-item-status="<?= $itemGroup ?>" style="display: flex; flex-direction: column; gap: 1rem;">
                        <header style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.25rem;">
                                    <button type="button"
                                            class="font-mono"
                                            onclick="copyNeedCode('#NTR-<?= str_pad($n['id'], 4, '0', STR_PAD_LEFT) ?>')"
                                            title="Salin kode pengajuan"
                                            style="background: none; border: none; padding: 0; font-size: 0.78rem; font-weight: 700; color: var(--primary); cursor: pointer;">
                                        #NTR-<?= str_pad($n['id'], 4, '0', STR_PAD_LEFT) ?> · Salin
                                    </button>
                                    <span style="font-size: 0.82rem; color: var(--text-muted);">
                                        · Diajukan <?= format_datetime_id($n['submitted_at']) ?> · LILA <strong class="font-mono"><?= number_format((float)($n['lila_measurement'] ?? 0), 1) ?> cm</strong>
                                    </span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin: 0;">
                                    <?= htmlspecialchars($n['title']) ?>
                                </h3>
                            </div>
                            <div>
                                <?= render_status_badge($st) ?>
                            </div>
                        </header>

                        <!-- 5-Stage Progress Stepper -->
                        <?= render_need_progress_tracker($st) ?>

                        <!-- 2-Column Inset Wells -->
                        <div class="grid-2col">
                            <div class="inset-well" style="padding: 0.875rem 1rem;">
                                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">
                                    Paket Pangan Bergizi yang Diajukan
                                </span>
                                <p style="font-size: 0.88rem; color: var(--text-main); font-weight: 500; margin: 0; line-height: 1.5;">
                                    <?= nl2br(htmlspecialchars($n['food_items_needed'])) ?>
                                </p>
                            </div>

                            <div class="inset-well" style="padding: 0.875rem 1rem;">
                                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">
                                    Titik Drop-Point Penyaluran
                                </span>
                                <div style="font-size: 0.92rem; font-weight: 700; color: var(--text-main);">
                                    <?= htmlspecialchars($n['drop_point_name'] ?? 'Posyandu Mitra') ?>
                                </div>
                                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0.125rem 0 0 0;">
                                    Kec. <?= htmlspecialchars($n['drop_point_district'] ?? '-') ?>
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($n['admin_notes'])): ?>
                            <div style="background: var(--surface-low); border-left: 0.1875rem solid var(--warning); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; padding: 0.75rem 0.875rem; font-size: 0.84rem; color: var(--text-main);">
                                <strong style="color: var(--warning);">Catatan Admin NurturaGuard:</strong> <?= htmlspecialchars($n['admin_notes']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Aksi saat Paket Siap Diambil -->
                        <?php if ($st === 'menunggu_pengambilan'): ?>
                            <div class="inset-well" style="border: 0.0625rem solid rgba(0, 109, 48, 0.35); padding: 1.125rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.375rem;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <h4 style="font-size: 0.98rem; font-weight: 700; color: var(--botanical); margin: 0;">
                                        Paket Pangan Telah Tiba di Posyandu
                                    </h4>
                                </div>
                                <p style="font-size: 0.84rem; color: var(--text-muted); margin: 0 0 0.875rem 0; line-height: 1.55;">
                                    Silakan ambil paket di Posyandu mitra di atas. Setelah memeriksa kelengkapan isinya, lakukan konfirmasi di bawah ini.
                                </p>

                                <div style="display: flex; flex-wrap: wrap; gap: 0.625rem;">
                                    <form action="index.php?action=confirm-received" method="POST" style="margin: 0;">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                        <input type="hidden" name="need_id" value="<?= (int)$n['id'] ?>">
                                        <button type="submit" class="btn-botanical btn-sm" data-confirm="Apakah Anda sudah menerima paket pangan ini di Posyandu dan memastikan kondisinya baik?">
                                            ✓ Konfirmasi Terima Paket
                                        </button>
                                    </form>

                                    <button type="button" class="btn-ghost-clean btn-sm" onclick="openProofModal(<?= (int)$n['id'] ?>)">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                            <circle cx="12" cy="13" r="4"></circle>
                                        </svg>
                                        Lihat Bukti Bantuan Donatur
                                    </button>

                                    <button type="button" class="btn-danger-outline btn-sm" onclick="document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display = (document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display === 'none' ? 'block' : 'none')">
                                        Laporkan Kendala
                                    </button>
                                </div>

                                <!-- Form Kendala / Dispute (Toggle) -->
                                <div id="dispute-form-<?= (int)$n['id'] ?>" style="display: none; margin-top: 0.875rem; padding: 1rem; background: var(--surface-lowest); border: 0.0625rem solid rgba(168, 56, 54, 0.45); border-radius: var(--radius-md);">
                                    <h5 style="font-size: 0.86rem; font-weight: 700; color: var(--danger); margin: 0 0 0.5rem 0;">
                                        Pengajuan Laporan Kendala Bantuan
                                    </h5>
                                    <form action="index.php?action=dispute" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                        <input type="hidden" name="need_id" value="<?= (int)$n['id'] ?>">
                                        <textarea name="reason" rows="2" class="form-control" style="font-size: 0.94rem; margin-bottom: 0.625rem;" placeholder="Jelaskan kendala (misal: paket tidak ada di Posyandu, bahan rusak, atau isi tidak sesuai)..." required></textarea>
                                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                            <button type="submit" class="btn-danger btn-sm">Kirim Laporan</button>
                                            <button type="button" class="btn-ghost-clean btn-sm" onclick="document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display='none'">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- Modal / Bottom-Sheet Foto Bukti Drop Bantuan -->
<div id="proof-modal-global" class="proof-modal" onclick="closeProofModal('global')">
    <div class="proof-modal-content" onclick="event.stopPropagation()">
        <div class="proof-modal-header">
            <h3>Foto Bukti Serah Terima dari Donatur</h3>
            <button type="button" class="proof-close" onclick="closeProofModal('global')" aria-label="Tutup">&times;</button>
        </div>
        <div class="proof-modal-body">
            <img id="proof-image-global" src="" alt="Foto Bukti Drop-Point Posyandu" style="display: none;">
            <p id="proof-loading-global" style="font-size: 0.86rem; color: var(--text-muted); padding: 1.25rem 0;">
                Memuat foto bukti bantuan...
            </p>
        </div>
    </div>
</div>

<script>
function filterIbuHistory(status, btnEl) {
    document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('active'));
    btnEl.classList.add('active');
    document.querySelectorAll('.history-item').forEach(item => {
        const itemStatus = item.getAttribute('data-item-status');
        item.style.display = (status === 'all' || itemStatus === status) ? 'flex' : 'none';
    });
}

function copyNeedCode(code) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(code).then(() => {
            if (typeof window.showNurturaToast === 'function') {
                window.showNurturaToast('Kode pengajuan ' + code + ' berhasil disalin.');
            }
        });
    } else if (typeof window.showNurturaToast === 'function') {
        window.showNurturaToast('Kode pengajuan: ' + code);
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
