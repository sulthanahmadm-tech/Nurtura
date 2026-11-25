<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$lila_val = (float)($need['lila_measurement'] ?? 0);
$has_lila = $lila_val > 0;
$is_kek = $has_lila && ($lila_val < 23.5);
?>

<div style="max-width: 980px; margin: 0 auto; padding-bottom: 40px;">
    <!-- Breadcrumb Navigasi -->
    <div style="margin-bottom: 20px;">
        <a href="index.php?page=explore" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; font-size: 0.9rem; color: #0284c7; text-decoration: none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali ke Katalog Kebutuhan Gizi
        </a>
    </div>

    <div class="card-modern" style="padding: 36px; border: 1px solid rgba(226, 232, 240, 0.9);">
        <!-- Top Status Bar & Badges -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <?= render_status_badge($need['status']) ?>
                <span class="badge badge-info">Validasi Medis Buku KIA Terverifikasi</span>
            </div>
            <?php if ($has_lila): ?>
                <span class="badge <?= $is_kek ? 'badge-kek-risk' : 'badge-kek-normal' ?>" style="font-size: 0.82rem; padding: 6px 14px; font-weight: 700;">
                    <?= $is_kek ? 'Indikasi KEK: LILA ' . number_format($lila_val, 1) . ' cm (< 23,5 cm)' : 'LILA Normal: ' . number_format($lila_val, 1) . ' cm' ?>
                </span>
            <?php else: ?>
                <span class="badge badge-secondary" style="font-size: 0.82rem; padding: 6px 14px; font-weight: 700;">
                    LILA: Belum Tercatat
                </span>
            <?php endif; ?>
        </div>

        <h1 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 12px; line-height: 1.25; letter-spacing: -0.02em;">
            <?= htmlspecialchars($need['title']) ?>
        </h1>
        <p style="color: var(--text-muted); font-size: 0.94rem; margin-bottom: 26px; padding-bottom: 18px; border-bottom: 1px solid #e2e8f0;">
            Pengaju: <strong><?= mask_name('Ibu', $need['district']) ?></strong> • Usia Kehamilan: <strong><?= $need['gestational_age_weeks'] ?? '-' ?> Minggu</strong> • Wilayah: <strong><?= htmlspecialchars($need['district']) ?>, <?= htmlspecialchars($need['regency_city']) ?></strong>
        </p>

        <!-- 3D MEDICAL VISUALIZATION & DIAGRAMS (2 KOLOM: GAUGE LILA & RADAR NUTRISI) -->
        <div style="margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #0284c7;">
                        Analisis Diagnostik & Standar AKG
                    </span>
                    <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                        Visualisasi Klinis Status Gizi & Paket Pangan
                    </h2>
                </div>
                <span class="badge badge-secondary" style="font-size: 0.75rem;">Standar Kemenkes RI</span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <!-- DIAGRAM 1: Semi-Circular LILA Gauge -->
                <div class="card-3d-tactile" style="padding: 24px; text-align: center; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #e11d48; letter-spacing: 0.04em;">
                            Indikator Antropometri Ibu
                        </span>
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 4px 0 12px 0;">
                            Pengukuran Lingkar Lengan Atas (LILA)
                        </h3>
                        <div id="lila-gauge-detail" data-medical-chart="lila-gauge" data-lila="<?= $lila_val ?>"></div>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 10px 12px; margin-top: 14px; font-size: 0.74rem; color: #64748b; text-align: left; line-height: 1.45;">
                        <strong>Catatan Klinis:</strong> Ibu hamil dengan LILA &lt; 23,5 cm berada pada risiko tinggi melahirkan bayi berat lahir rendah (BBLR) dan stunting. Paket pangan ini ditargetkan untuk intervensi gizi mendesak.
                    </div>
                </div>

                <!-- DIAGRAM 2: 5-Axis Nutritional Radar Chart -->
                <div class="card-3d-tactile" style="padding: 24px; text-align: center; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0284c7; letter-spacing: 0.04em;">
                            Komposisi Nutrisi Paket
                        </span>
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 4px 0 12px 0;">
                            Indeks 5 Sumbu Nutrisi Pangan
                        </h3>
                        <div id="nutrition-radar-detail" data-medical-chart="nutrition-radar" data-food-text="<?= htmlspecialchars($need['food_items_needed']) ?>"></div>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 10px 12px; margin-top: 14px; font-size: 0.74rem; color: #64748b; text-align: left; line-height: 1.45;">
                        <strong>Pemetaan AKG:</strong> Menilai keseimbangan protein hewani, kalsium, energi kalori, asam folat, dan zat besi (Fe) yang terkandung dalam paket bahan pangan yang diajukan.
                    </div>
                </div>
            </div>
        </div>

        <!-- Rincian Paket Pangan & Alasan Pengajuan -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 28px;">
            <!-- Paket Bahan Pangan yang Dibutuhkan -->
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 22px; border-radius: 18px;">
                <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 8px;">
                    Rincian Paket Bahan Pangan Bergizi:
                </span>
                <div style="color: #0c4a6e; font-size: 1rem; font-weight: 600; line-height: 1.65;">
                    <?= nl2br(htmlspecialchars($need['food_items_needed'])) ?>
                </div>
            </div>

            <!-- Konteks & Alasan Pengajuan -->
            <div style="background: #f8fafc; padding: 22px; border-radius: 18px; border: 1px solid #e2e8f0;">
                <span style="font-size: 0.74rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 8px;">
                    Kondisi Kehamilan & Alasan Pengajuan:
                </span>
                <div style="font-size: 0.92rem; color: #334155; line-height: 1.6;">
                    <?= nl2br(htmlspecialchars($need['description'])) ?>
                </div>
            </div>
        </div>

        <!-- Titik Drop-Point Resmi Faskes -->
        <div class="card-3d-tactile" style="padding: 24px; margin-bottom: 30px; background: #fafcff;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">
                <div>
                    <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                        Titik Serah Terima Paket (Drop-Point Faskes Mitra):
                    </span>
                    <div style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                        <?= htmlspecialchars($need['drop_point_name']) ?>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 12px; line-height: 1.5;">
                        <?= htmlspecialchars($need['drop_point_address']) ?>
                    </p>
                </div>
                <span class="badge badge-secondary" style="font-size: 0.75rem;">
                    Wilayah: <?= htmlspecialchars($need['drop_point_district'] ?? $need['district']) ?>
                </span>
            </div>
            <div style="font-size: 0.84rem; color: #475569; padding-top: 10px; border-top: 1px solid #e2e8f0;">
                Petugas Penanggung Jawab: <strong><?= htmlspecialchars($need['officer_in_charge']) ?></strong> • Kontak: <strong><?= htmlspecialchars($need['drop_point_phone']) ?></strong>
            </div>
        </div>

        <!-- Bagian Aksi Donasi / Komitmen 48 Jam -->
        <?php if ($need['status'] === 'dipublikasikan'): ?>
            <?php if (is_logged_in() && is_donatur()): ?>
                <form action="index.php?action=commit-donation" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <input type="hidden" name="need_id" value="<?= $need['id'] ?>">

                    <div class="card-dark-3d" style="padding: 24px; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(199, 242, 43, 0.15); display: flex; align-items: center; justify-content: center; color: #c7f22b; flex-shrink: 0;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <h3 style="font-size: 1.05rem; font-weight: 800; margin: 0; color: #c7f22b;">
                                Komitmen Waktu 48 Jam
                            </h3>
                        </div>
                        <p style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.6; margin: 0;">
                            Dengan menekan tombol di bawah, Anda berkomitmen untuk menyediakan dan mengantarkan paket pangan di atas langsung ke <strong><?= htmlspecialchars($need['drop_point_name']) ?></strong> dalam tenggat waktu <strong>48 Jam</strong>, serta mengunggah foto bukti serah terima di dashboard donatur Anda.
                        </p>
                    </div>

                    <button type="submit" class="btn-lime" style="width: 100%; font-size: 1.05rem; padding: 16px;" data-confirm="Apakah Anda bersedia berkomitmen menyediakan paket pangan ini dan menyerahkannya ke Posyandu dalam 48 jam?">
                        Saya Bersedia Membantu (Kunci Komitmen 48 Jam) →
                    </button>
                </form>
            <?php elseif (is_logged_in() && !is_donatur()): ?>
                <div class="alert alert-warning" style="font-size: 0.92rem;">
                    Anda saat ini masuk sebagai <strong><?= user_role() ?></strong>. Hanya akun ber-peran <strong>Donatur</strong> yang dapat mengunci komitmen bantuan pangan.
                </div>
            <?php else: ?>
                <div class="card-dark-3d" style="text-align: center; padding: 34px 24px; margin: 0;">
                    <span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #c7f22b;">
                        Solidaritas Cegah Stunting
                    </span>
                    <h3 style="font-size: 1.35rem; color: #ffffff; margin: 8px 0 10px 0; font-weight: 800;">
                        Ingin Membantu Ibu Hamil Ini?
                    </h3>
                    <p style="color: #cbd5e1; font-size: 0.92rem; margin-bottom: 22px; max-width: 520px; margin-left: auto; margin-right: auto; line-height: 1.55;">
                        Masuk ke akun donatur Anda atau daftarkan akun baru untuk mengunci paket bantuan pangan ini dan mengantarkannya ke Posyandu mitra.
                    </p>
                    <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
                        <a href="index.php?page=login" class="btn-lime" style="padding: 12px 28px;">
                            Masuk untuk Membantu
                        </a>
                        <a href="index.php?page=register" class="btn btn-secondary" style="padding: 12px 24px; border-radius: 9999px;">
                            Daftar Akun Donatur
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-warning" style="font-size: 0.92rem;">
                Pengajuan ini saat ini berstatus: <strong><?= htmlspecialchars($need['status']) ?></strong> dan tidak menerima komitmen baru.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
