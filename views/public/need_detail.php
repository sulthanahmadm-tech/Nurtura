<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$lila_val = (float)($need['lila_measurement'] ?? 0);
$has_lila = $lila_val > 0;
$is_kek = $has_lila && ($lila_val < 23.5);
?>

<div style="display: flex; flex-direction: column; gap: 1.375rem; padding-bottom: 4.5rem;">
    <!-- Contextual Back Link -->
    <div>
        <a href="index.php?page=explore" style="display: inline-flex; align-items: center; gap: 0.375rem; min-height: var(--touch-target); font-weight: 600; font-size: 0.92rem; color: var(--primary);">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali ke Katalog Kebutuhan Gizi
        </a>
    </div>

    <!-- Header Summary Card -->
    <section class="card-clean" style="padding: clamp(1.25rem, 3.5vw, 1.75rem); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.25rem;">
        <div style="display: flex; flex-direction: column; gap: 0.625rem; max-width: min(47.5rem, 100%);">
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.875rem;">
                <?= render_status_badge($need['status']) ?>
                <span style="display: inline-flex; align-items: center; gap: 0.3125rem; font-size: 0.78rem; font-weight: 700; color: var(--botanical);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    Terverifikasi Buku KIA
                </span>
                <?php if ($has_lila): ?>
                    <span class="<?= $is_kek ? 'status-kek-text' : 'status-normal-text' ?>">
                        <?= $is_kek ? 'Indikasi KEK: LILA ' . number_format($lila_val, 1) . ' cm (< 23,5 cm)' : 'LILA Normal: ' . number_format($lila_val, 1) . ' cm' ?>
                    </span>
                <?php else: ?>
                    <span class="font-mono" style="font-size: 0.78rem; color: var(--text-muted);">LILA: Belum Tercatat</span>
                <?php endif; ?>
            </div>

            <h1 style="font-size: clamp(1.45rem, 4.5vw, 2.05rem); font-weight: 700; color: var(--text-main); line-height: 1.25; margin: 0;">
                <?= htmlspecialchars($need['title']) ?>
            </h1>

            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">
                Pengaju: <strong style="color: var(--text-main);"><?= mask_name('Ibu', $need['district']) ?></strong>
                · Usia Kehamilan: <strong style="color: var(--text-main);"><?= $need['gestational_age_weeks'] ?? '-' ?> Minggu</strong>
                · Wilayah: <strong style="color: var(--text-main);"><?= htmlspecialchars($need['district']) ?>, <?= htmlspecialchars($need['regency_city']) ?></strong>
            </p>
        </div>

        <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 0.25rem; flex-shrink: 0;">
            <span class="font-mono" style="font-size: 0.92rem; font-weight: 700; color: var(--primary);">
                Kode: #NTR-<?= str_pad($need['id'], 4, '0', STR_PAD_LEFT) ?>
            </span>
            <span style="font-size: 0.76rem; font-weight: 600; color: var(--text-muted);">Standar Klinis Kemenkes RI</span>
        </div>
    </section>

    <!-- 2-Column Clinical & Action Layout (5 cols Left / 7 cols Right) -->
    <div class="grid-dashboard-main" style="margin-bottom: 0; align-items: start;">

        <!-- Left Column: Clinical Diagnostics (5 cols) -->
        <div class="col-span-5" style="display: flex; flex-direction: column; gap: 1.375rem;">
            <!-- LILA Gauge Card (Selalu Terlihat Sesuai Standar Klinis PRD) -->
            <article class="card-clean" style="display: flex; flex-direction: column; gap: 0.875rem;">
                <header style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;">
                    <h2 style="font-family: var(--font-sans); font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0;">Pengukuran LILA Ibu</h2>
                    <span style="font-size: 0.75rem; font-weight: 700; color: <?= $is_kek ? 'var(--danger)' : 'var(--botanical)' ?>;">
                        <?= $is_kek ? 'Prioritas KEK' : 'Standar Antropometri' ?>
                    </span>
                </header>

                <div id="lila-gauge-detail" data-medical-chart="lila-gauge" data-lila="<?= $lila_val ?>"></div>

                <div class="inset-well" style="padding: 0.75rem 0.875rem; font-size: 0.84rem; color: var(--text-muted); line-height: 1.55;">
                    <strong style="color: var(--text-main);">Catatan Klinis:</strong> Ibu hamil dengan LILA di bawah 23,5 cm berisiko tinggi melahirkan bayi berat lahir rendah (BBLR) dan memerlukan intervensi protein hewani segera.
                </div>
            </article>

            <!-- 5-Axis Nutritional Radar Card (Collapsible Accordion di Mobile) -->
            <details class="info-accordion-card" open data-mobile-collapse="true">
                <summary class="info-accordion-summary">
                    <div>
                        <h2 style="font-family: var(--font-sans); font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0;">Indeks 5 Sumbu Nutrisi (AKG)</h2>
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary);">Komposisi Paket</span>
                    </div>
                    <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>

                <div style="display: flex; flex-direction: column; gap: 0.875rem;">
                    <div id="nutrition-radar-detail" data-medical-chart="nutrition-radar" data-food-text="<?= htmlspecialchars($need['food_items_needed']) ?>"></div>

                    <div class="inset-well" style="padding: 0.75rem 0.875rem; font-size: 0.84rem; color: var(--text-muted); line-height: 1.55;">
                        <strong style="color: var(--text-main);">Pemetaan AKG:</strong> Menilai keseimbangan protein hewani, kalsium, energi kalori, asam folat, dan zat besi (Fe) yang terkandung dalam paket bahan pangan.
                    </div>
                </div>
            </details>
        </div>

        <!-- Right Column: Food Package, Drop-Point & Action (7 cols) -->
        <div class="col-span-7" style="display: flex; flex-direction: column; gap: 1.375rem;">
            <!-- Food Package Breakdown -->
            <article class="card-clean" style="display: flex; flex-direction: column; gap: 1rem;">
                <h2 style="font-family: var(--font-sans); font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0;">
                    Rincian Paket Bahan Pangan Bergizi
                </h2>

                <div class="inset-well" style="padding: 1.125rem;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 0.375rem;">
                        Daftar Bahan Pangan Dibutuhkan
                    </span>
                    <div style="color: var(--text-main); font-size: 0.96rem; font-weight: 600; line-height: 1.65;">
                        <?= nl2br(htmlspecialchars($need['food_items_needed'])) ?>
                    </div>
                </div>

                <div style="padding-top: 0.875rem; border-top: 0.0625rem solid var(--border-subtle); display: flex; flex-direction: column; gap: 0.25rem;">
                    <span style="font-size: 0.76rem; font-weight: 700; color: var(--text-muted);">
                        Kondisi Kehamilan &amp; Alasan Pengajuan
                    </span>
                    <p style="font-size: 0.9rem; color: var(--text-main); line-height: 1.6; margin: 0;">
                        <?= nl2br(htmlspecialchars($need['description'])) ?>
                    </p>
                </div>
            </article>

            <!-- Posyandu Drop-Point Card -->
            <article class="card-clean" style="display: flex; flex-direction: column; gap: 0.875rem;">
                <header style="display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <h2 style="font-family: var(--font-sans); font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0;">
                            Titik Serah Terima Drop-Point Mitra
                        </h2>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: var(--botanical);">
                        <?= htmlspecialchars($need['drop_point_district'] ?? $need['district']) ?>
                    </span>
                </header>

                <div class="inset-well" style="padding: 1rem; display: flex; flex-direction: column; gap: 0.375rem;">
                    <div style="font-size: 1rem; font-weight: 700; color: var(--text-main);">
                        <?= htmlspecialchars($need['drop_point_name']) ?>
                    </div>
                    <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0; line-height: 1.5;">
                        <?= htmlspecialchars($need['drop_point_address']) ?>
                    </p>
                    <p style="font-size: 0.86rem; color: var(--text-main); margin: 0.25rem 0 0 0;">
                        Penanggung Jawab: <strong><?= htmlspecialchars($need['officer_in_charge']) ?></strong> · Kontak: <span class="font-mono" style="font-size: 0.84rem;"><?= htmlspecialchars($need['drop_point_phone']) ?></span>
                    </p>
                </div>
            </article>

            <!-- Action Commitment Block -->
            <?php if ($need['status'] === 'dipublikasikan'): ?>
                <?php if (is_logged_in() && is_donatur()): ?>
                    <article class="card-clean" style="border-color: rgba(55, 99, 134, 0.45); display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                                Komitmen Waktu 48 Jam
                            </span>
                            <h2 style="font-family: var(--font-sans); font-size: 1.12rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.375rem 0;">
                                Siap Menyalurkan Paket Ini?
                            </h2>
                            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.55; margin: 0;">
                                Dengan mengunci komitmen, Anda bersedia mengantar paket pangan di atas langsung ke <strong style="color: var(--text-main);"><?= htmlspecialchars($need['drop_point_name']) ?></strong> dalam tenggat waktu <strong>48 Jam</strong> serta mengunggah foto bukti serah terima.
                            </p>
                        </div>

                        <form action="index.php?action=commit-donation" method="POST" style="margin: 0;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="need_id" value="<?= $need['id'] ?>">
                            <button type="submit" class="btn-cerulean" style="width: 100%; padding: 0.8125rem 1.5rem; font-size: 0.94rem;" data-confirm="Apakah Anda bersedia berkomitmen menyediakan paket pangan ini dan menyerahkannya ke Posyandu dalam 48 jam?">
                                Kunci Komitmen Donasi (48 Jam) →
                            </button>
                        </form>
                    </article>
                <?php elseif (is_logged_in() && !is_donatur()): ?>
                    <div class="alert alert-warning" style="margin: 0;">
                        Anda saat ini masuk sebagai <strong><?= htmlspecialchars(user_role()) ?></strong>. Hanya akun ber-peran <strong>Donatur</strong> yang dapat mengunci komitmen bantuan pangan.
                    </div>
                <?php else: ?>
                    <article class="card-cerulean" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary-container); display: block; margin-bottom: 0.25rem;">
                                Solidaritas Cegah Stunting
                            </span>
                            <h2 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; color: var(--on-primary); margin: 0 0 0.375rem 0;">
                                Ingin Membantu Ibu Hamil Ini?
                            </h2>
                            <p style="color: var(--on-primary); opacity: 0.92; font-size: 0.9rem; line-height: 1.55; margin: 0;">
                                Masuk ke akun donatur Anda atau daftarkan akun baru untuk mengunci paket bantuan pangan ini dan mengantarkannya ke Posyandu mitra.
                            </p>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.625rem;">
                            <a href="index.php?page=login" class="btn-white">
                                Masuk untuk Membantu
                            </a>
                            <a href="index.php?page=register" class="btn-cerulean-outline">
                                Daftar Akun Donatur
                            </a>
                        </div>
                    </article>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-warning" style="margin: 0;">
                    Pengajuan ini saat ini berstatus: <strong><?= htmlspecialchars($need['status']) ?></strong> dan tidak menerima komitmen baru.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($need['status'] === 'dipublikasikan'): ?>
    <!-- Sticky Mini Summary Bar / Mobile Thumb-Zone Action Bar saat Scroll -->
    <div id="sticky-need-bar" class="sticky-need-bar">
        <div style="min-width: 0;">
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--botanical); text-transform: uppercase;">
                Drop-Point: <?= htmlspecialchars($need['drop_point_name']) ?>
            </div>
            <div style="font-size: 0.94rem; font-weight: 700; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?= htmlspecialchars($need['title']) ?>
            </div>
        </div>
        <div style="flex-shrink: 0;">
            <?php if (is_logged_in() && is_donatur()): ?>
                <button type="button" onclick="document.querySelector('form[action*=commit-donation] button[type=submit]')?.click()" class="btn-cerulean btn-sm" style="padding: 0.625rem 1.25rem;">
                    Kunci Komitmen 48 Jam →
                </button>
            <?php elseif (!is_logged_in()): ?>
                <a href="index.php?page=login" class="btn-cerulean btn-sm" style="padding: 0.625rem 1.25rem;">
                    Masuk untuk Membantu →
                </a>
            <?php endif; ?>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const bar = document.getElementById('sticky-need-bar');
        if (!bar) return;
        window.addEventListener('scroll', function () {
            if ((window.scrollY || window.pageYOffset) > 320) {
                bar.classList.add('is-visible');
            } else {
                bar.classList.remove('is-visible');
            }
        }, { passive: true });
    });
    </script>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
