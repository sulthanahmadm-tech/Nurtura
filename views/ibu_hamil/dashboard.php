<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

// Ambil data asli dari controller dengan fallback aman (anti Undefined Variable)
$nama_ibu       = $profile['full_name'] ?? $_SESSION['user']['full_name'] ?? 'Bunda';
$usia_minggu    = (int)($gestationalWeeks ?? $profile['gestational_age_weeks'] ?? 0);
$usia_hari      = $usia_minggu * 7;
$hpl_formatted  = !empty($profile['estimated_birth_date']) ? date('d M Y', strtotime($profile['estimated_birth_date'])) : 'Belum diisi';

$raw_lila       = $lilaValue ?? $profile['lila_cm'] ?? null;
$lila_tampil    = ($raw_lila !== null && $raw_lila !== '') ? number_format((float)$raw_lila, 1) : '-';
$is_kek         = isset($lilaAtRisk) ? (bool)$lilaAtRisk : ($raw_lila !== null && $raw_lila !== '' && (float)$raw_lila < 23.5);

$domisili       = trim(($profile['district'] ?? '') . ', ' . ($profile['regency_city'] ?? ''), ', ');
if ($domisili === '') $domisili = 'Belum diisi';

$status_lila    = $is_kek ? 'Risiko KEK (< 23.5 cm)' : 'Normal / Aman (≥ 23.5 cm)';
$badge_lila     = $is_kek ? 'badge-kek-risk' : 'badge-kek-normal';
$needs_list     = is_array($needs ?? null) ? $needs : [];
?>

<div style="max-width: 1200px; margin: 0 auto;">

    <!-- 1. Header Bar Dasbor -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span class="badge badge-info">NurturaCare · Panel Ibu Hamil</span>
                <?php if ($usia_minggu > 0): ?>
                    <span class="badge badge-secondary" style="font-weight: 700;">
                        Trimester <?= $usia_minggu <= 13 ? '1' : ($usia_minggu <= 27 ? '2' : '3') ?>
                    </span>
                <?php endif; ?>
            </div>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em;">
                Halo, <?= htmlspecialchars($nama_ibu) ?>!
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
                <?= $usia_minggu > 0 ? "Hari ke-{$usia_hari} perjalanan kehamilan Anda (Minggu ke-{$usia_minggu}) · Pantau status gizi & bantuan pangan" : "Pantau status gizi dan penyaluran bantuan paket pangan Anda" ?>
            </p>
        </div>

        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="index.php?page=create-need" class="btn-lime">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Ajukan Kebutuhan Gizi
            </a>
        </div>
    </div>

    <!-- Notifikasi Flash Message -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin-bottom: 24px;" role="status">
            <?php
            if ($_GET['msg'] === 'pengajuan_berhasil') echo "Pengajuan berhasil dikirim dan sedang menunggu validasi berkas Buku KIA oleh tim admin NurturaGuard.";
            elseif ($_GET['msg'] === 'bantuan_selesai') echo "Terima kasih! Konfirmasi penerimaan paket telah disimpan. Semoga bermanfaat untuk kesehatan ibu dan janin.";
            elseif ($_GET['msg'] === 'dispute_diajukan') echo "Laporan kendala berhasil diajukan dan sedang ditangani oleh admin NurturaGuard.";
            else echo "Perubahan berhasil disimpan.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" style="margin-bottom: 24px;" role="alert">
            <?php
            if ($_GET['error'] === 'gagal_konfirmasi') echo "Gagal melakukan konfirmasi penerimaan paket. Silakan coba kembali.";
            elseif ($_GET['error'] === 'alasan_wajib_diisi') echo "Alasan kendala wajib diisi.";
            else echo "Terjadi kesalahan pada sistem.";
            ?>
        </div>
    <?php endif; ?>

    <!-- 2. GRID UTAMA 3 KARTU MODERN & 3D CLINICAL VISUALIZATION -->
    <div class="grid-dashboard-main">

        <!-- KARTU 1 (5 Kolom): Visual Fetus Glow & Ringkasan Perjalanan Kehamilan -->
        <div class="col-span-5 card-modern" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid rgba(226, 232, 240, 0.9);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #0284c7;">
                            Fase Perkembangan Janin
                        </span>
                        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 4px;">
                            Perjalanan Kehamilan
                        </h2>
                    </div>
                    <?php if ($usia_minggu > 0): ?>
                        <span class="badge badge-secondary" style="font-size: 0.74rem;">
                            Minggu ke-<?= $usia_minggu ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- 3D Pregnancy Orb Widget -->
                <div style="margin: 24px 0 16px 0; text-align: center;">
                    <div class="pregnancy-orb">
                        <div class="pregnancy-orb-inner fetus-glow"></div>
                        <div style="position: relative; z-index: 10; text-align: center; color: #ffffff; padding: 0 16px;">
                            <span style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.12em; color: #7dd3fc; font-weight: 700; display: block;">
                                Usia Kehamilan
                            </span>
                            <div style="font-size: 2.2rem; font-weight: 800; line-height: 1.1; margin: 4px 0;">
                                <?= $usia_minggu > 0 ? $usia_minggu . ' <span style="font-size: 1rem; font-weight: 500; color: #cbd5e1;">Minggu</span>' : '<span style="font-size: 1.3rem;">Data KIA</span>' ?>
                            </div>
                            <div style="font-size: 0.75rem; color: #cbd5e1; margin-top: 6px; line-height: 1.4;">
                                Perkiraan Lahir (HPL):<br>
                                <strong style="color: #ffffff; font-weight: 700;"><?= htmlspecialchars($hpl_formatted) ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="pregnancy-ring-orbit"></div>
                </div>
            </div>

            <!-- Mini Summary 3 Baris -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 18px; padding-top: 18px; border-top: 1px solid #f1f5f9;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 12px 14px;">
                    <span style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Ukuran LILA Terakhir</span>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 2px;">
                        <?= htmlspecialchars($lila_tampil) ?> <span style="font-size: 0.8rem; font-weight: 500; color: #64748b;">cm</span>
                    </div>
                    <span class="badge <?= $badge_lila ?>" style="font-size: 0.68rem; margin-top: 4px;">
                        <?= $status_lila ?>
                    </span>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 12px 14px;">
                    <span style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Wilayah Posyandu</span>
                    <div style="font-size: 0.88rem; font-weight: 800; color: #0f172a; margin-top: 4px; line-height: 1.3;">
                        <?= htmlspecialchars($domisili) ?>
                    </div>
                    <span style="font-size: 0.7rem; color: #0284c7; font-weight: 600; display: block; margin-top: 4px;">
                        Drop-Point Faskes Terdaftar
                    </span>
                </div>
            </div>
        </div>

        <!-- KARTU 2 (4 Kolom): Interactive Semi-Circular LILA Gauge -->
        <div class="col-span-4 card-modern" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid rgba(226, 232, 240, 0.9);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <div>
                        <span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #e11d48;">
                            Parameter Medis Kemenkes
                        </span>
                        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 2px;">
                            Indikator LILA Klinis
                        </h2>
                    </div>
                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Data KIA</span>
                </div>

                <!-- Canvas/SVG Gauge Embed -->
                <div style="padding: 10px 0;">
                    <div data-medical-chart="lila-gauge" data-lila="<?= (float)($raw_lila ?? 23.5) ?>"></div>
                </div>
            </div>

            <!-- Pedoman Medis Kemenkes -->
            <div style="background: #f8fafc; border-left: 3px solid <?= $is_kek ? '#ef4444' : '#10b981' ?>; border-radius: 0 12px 12px 0; padding: 12px 14px; margin-top: 14px;">
                <div style="font-size: 0.78rem; font-weight: 700; color: #0f172a;">
                    <?= $is_kek ? 'Perhatian Gizi (Risiko KEK)' : 'Status Gizi Baik' ?>
                </div>
                <p style="font-size: 0.74rem; color: #64748b; margin: 4px 0 0 0; line-height: 1.45;">
                    <?= $is_kek ? 'LILA di bawah 23,5 cm menandakan risiko Kurang Energi Kronis. Prioritaskan asupan protein hewani dan konsultasikan ke bidan.' : 'Ukuran LILA memenuhi standar Kemenkes. Pertahankan pola makan bergizi seimbang dan konsumsi Tablet Tambah Darah (TTD).' ?>
                </p>
            </div>
        </div>

        <!-- KARTU 3 (3 Kolom): Dark Hero Status Card & Quick Action -->
        <div class="col-span-3 card-dark-3d" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; gap: 20px;">
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #c7f22b;">
                    Program Pangan Posyandu
                </span>
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-top: 6px; line-height: 1.3;">
                    Butuh Paket Pangan Tambahan?
                </h3>
                <p style="font-size: 0.82rem; color: #cbd5e1; margin-top: 8px; line-height: 1.55;">
                    Ajukan kebutuhan protein hewani, susu ibu hamil, dan suplemen bergizi. Tim NurturaGuard akan memverifikasi berkas Buku KIA Anda.
                </p>

                <div style="margin-top: 18px; padding: 14px; background: rgba(255, 255, 255, 0.06); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.76rem; color: #94a3b8;">Total Pengajuan Anda:</span>
                        <span style="font-size: 1.15rem; font-weight: 800; color: #c7f22b;"><?= count($needs_list) ?> paket</span>
                    </div>
                </div>
            </div>

            <a href="index.php?page=create-need" class="btn-lime" style="width: 100%;">
                + Buat Pengajuan Baru
            </a>
        </div>
    </div>

    <!-- 3. RIWAYAT PENGAJUAN KEBUTUHAN PANGAN (NURTURANEEDS) -->
    <div class="card-modern" style="padding: 32px; border: 1px solid rgba(226, 232, 240, 0.9);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
            <div>
                <span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #0284c7;">
                    Pelacakan Transparan
                </span>
                <h2 style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin-top: 2px;">
                    Riwayat Pengajuan Kebutuhan Pangan
                </h2>
            </div>
            <span class="badge badge-secondary" style="font-size: 0.8rem; padding: 6px 14px;">
                <?= count($needs_list) ?> Pengajuan Tercatat
            </span>
        </div>

        <?php if (empty($needs_list)): ?>
            <div style="text-align: center; padding: 48px 20px; background: #f8fafc; border-radius: 18px; border: 2px dashed #cbd5e1;">
                <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; color: #0284c7;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">
                    Belum Ada Pengajuan Kebutuhan Pangan
                </h3>
                <p style="color: var(--text-muted); font-size: 0.88rem; max-width: 460px; margin: 0 auto 20px auto; line-height: 1.5;">
                    Ajukan paket pangan bergizi agar tim NurturaGuard dapat meninjau data Buku KIA Anda dan menghubungkannya dengan donatur.
                </p>
                <a href="index.php?page=create-need" class="btn-lime">
                    + Mulai Ajukan Kebutuhan Gizi
                </a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <?php foreach ($needs_list as $n): ?>
                    <div class="card-3d-tactile" style="padding: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
                            <div>
                                <span style="font-size: 0.72rem; font-weight: 700; color: #0284c7; text-transform: uppercase;">
                                    ID: #NTR-<?= str_pad($n['id'], 4, '0', STR_PAD_LEFT) ?>
                                </span>
                                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 4px 0;">
                                    <?= htmlspecialchars($n['title']) ?>
                                </h3>
                                <div style="font-size: 0.8rem; color: #64748b;">
                                    Diajukan: <?= format_datetime_id($n['submitted_at']) ?> · LILA: <strong><?= number_format((float)($n['lila_measurement'] ?? 0), 1) ?> cm</strong>
                                </div>
                            </div>
                            <div>
                                <?= render_status_badge($n['status']) ?>
                            </div>
                        </div>

                        <!-- 5-Stage Stepper Alur Status Kebutuhan -->
                        <?= render_need_progress_tracker($n['status']) ?>

                        <!-- Rincian Bahan Pangan & Posyandu -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px; margin: 18px 0;">
                            <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 14px; padding: 14px 16px;">
                                <span style="font-size: 0.74rem; font-weight: 800; color: #0369a1; text-transform: uppercase;">
                                    Paket Pangan Bergizi yang Diajukan
                                </span>
                                <p style="font-size: 0.88rem; color: #0c4a6e; font-weight: 600; margin: 6px 0 0 0; line-height: 1.5;">
                                    <?= nl2br(htmlspecialchars($n['food_items_needed'])) ?>
                                </p>
                            </div>

                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px;">
                                <span style="font-size: 0.74rem; font-weight: 800; color: #475569; text-transform: uppercase;">
                                    Titik Drop-Point Penyaluran
                                </span>
                                <div style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-top: 4px;">
                                    <?= htmlspecialchars($n['drop_point_name'] ?? 'Posyandu Mitra') ?>
                                </div>
                                <p style="font-size: 0.8rem; color: #64748b; margin: 2px 0 0 0;">
                                    Kec. <?= htmlspecialchars($n['drop_point_district'] ?? '-') ?>
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($n['admin_notes'])): ?>
                            <div style="background: #fefce8; border: 1px solid #fef08a; border-radius: 12px; padding: 12px 14px; font-size: 0.82rem; color: #854d0e; margin-bottom: 14px;">
                                <strong>Catatan Admin NurturaGuard:</strong> <?= htmlspecialchars($n['admin_notes']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Aksi saat Paket Siap Diambil -->
                        <?php if (($n['status'] ?? '') === 'menunggu_pengambilan'): ?>
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 18px; margin-top: 14px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <span style="font-size: 1.1rem;">🎉</span>
                                    <h4 style="font-size: 0.95rem; font-weight: 800; color: #166534; margin: 0;">
                                        Paket Pangan Telah Tiba di Posyandu!
                                    </h4>
                                </div>
                                <p style="font-size: 0.82rem; color: #15803d; margin: 0 0 14px 0;">
                                    Silakan ambil paket di Posyandu mitra di atas. Setelah memeriksa kelengkapan isinya, lakukan konfirmasi di bawah ini.
                                </p>

                                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    <form action="index.php?action=confirm-received" method="POST" style="margin: 0;">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                        <input type="hidden" name="need_id" value="<?= (int)$n['id'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda sudah menerima paket pangan ini di Posyandu dan memastikan kondisinya baik?')">
                                            ✓ Konfirmasi Terima Paket
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openProofModal(<?= (int)$n['id'] ?>)">
                                        📷 Lihat Bukti Bantuan Donatur
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display = (document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display === 'none' ? 'block' : 'none')">
                                        Laporkan Kendala
                                    </button>
                                </div>

                                <!-- Form Kendala / Dispute (Toggle) -->
                                <div id="dispute-form-<?= (int)$n['id'] ?>" style="display: none; margin-top: 14px; padding: 16px; background: #ffffff; border: 1px solid #fecaca; border-radius: 12px;">
                                    <h5 style="font-size: 0.85rem; font-weight: 800; color: #b91c1c; margin: 0 0 8px 0;">
                                        Pengajuan Laporan Kendala Bantuan
                                    </h5>
                                    <form action="index.php?action=dispute" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                        <input type="hidden" name="need_id" value="<?= (int)$n['id'] ?>">
                                        <textarea name="reason" rows="2" class="form-control" style="font-size: 0.82rem; margin-bottom: 10px;" placeholder="Jelaskan kendala (misal: paket tidak ada di Posyandu, bahan rusak, atau isi tidak sesuai)..." required></textarea>
                                        <div style="display: flex; gap: 8px;">
                                            <button type="submit" class="btn btn-danger btn-sm">Kirim Laporan</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display='none'">Batal</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Modal Foto Bukti Drop Bantuan -->
                                <div id="proof-modal-<?= (int)$n['id'] ?>" class="proof-modal" onclick="closeProofModal(<?= (int)$n['id'] ?>)">
                                    <div class="proof-modal-content" onclick="event.stopPropagation()">
                                        <div class="proof-modal-header">
                                            <h3>Foto Bukti Serah Terima dari Donatur</h3>
                                            <button type="button" class="proof-close" onclick="closeProofModal(<?= (int)$n['id'] ?>)">&times;</button>
                                        </div>
                                        <div class="proof-modal-body">
                                            <img id="proof-image-<?= (int)$n['id'] ?>" src="" alt="Foto Bukti Drop-Point Posyandu" style="display: none;">
                                            <p id="proof-loading-<?= (int)$n['id'] ?>" style="font-size: 0.85rem; color: #64748b; padding: 20px 0;">
                                                Memuat foto bukti bantuan...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function openProofModal(needId) {
        const modal = document.getElementById('proof-modal-' + needId);
        const img = document.getElementById('proof-image-' + needId);
        const loading = document.getElementById('proof-loading-' + needId);
        if (!modal) return;

        modal.classList.add('active');
        modal.style.display = 'flex';
        loading.style.display = 'block';
        loading.textContent = 'Memuat foto bukti bantuan...';
        img.style.display = 'none';

        img.onload = function () {
            img.style.display = 'block';
            loading.style.display = 'none';
        };
        img.onerror = function () {
            img.style.display = 'none';
            loading.textContent = 'Foto bukti bantuan belum tersedia atau gagal dimuat.';
            loading.style.display = 'block';
        };

        img.src = 'index.php?action=view-proof&need_id=' + encodeURIComponent(needId);
    }

    function closeProofModal(needId) {
        const modal = document.getElementById('proof-modal-' + needId);
        if (modal) {
            modal.classList.remove('active');
            modal.style.display = 'none';
        }
    }
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
