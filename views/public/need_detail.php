<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 820px; margin: 0 auto; padding-bottom: 32px;">
    <div style="margin-bottom: 20px;">
        <a href="index.php?page=explore" style="font-weight: 700; font-size: 0.9rem; color: #0284c7; text-decoration: none;">
            Kembali ke Katalog Kebutuhan
        </a>
    </div>

    <div class="card" style="padding: 36px; border: 1px solid var(--border-color);">
        <!-- Top Status Bar (Tanpa Emoji) -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <?= render_status_badge($need['status']) ?>
            <span class="badge badge-coral">
                Indikasi KEK: LILA <?= number_format($need['lila_measurement'], 1) ?> cm (Ambang &lt; 23,5 cm)
            </span>
        </div>

        <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-bottom: 10px; line-height: 1.25; letter-spacing: -0.02em;">
            <?= htmlspecialchars($need['title']) ?>
        </h1>
        <p style="color: var(--text-muted); font-size: 0.92rem; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
            Pengaju: <strong><?= mask_name('Ibu', $need['district']) ?></strong> • Usia Kehamilan: <?= $need['gestational_age_weeks'] ?? '-' ?> Minggu • Wilayah: <?= htmlspecialchars($need['district']) ?>, <?= htmlspecialchars($need['regency_city']) ?>
        </p>

        <!-- Konteks & Alasan -->
        <div style="margin-bottom: 24px;">
            <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 8px;">
                Kondisi Kehamilan & Alasan Pengajuan:
            </span>
            <div style="background: #f8fafc; padding: 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 0.95rem; color: #334155; line-height: 1.6;">
                <?= nl2br(htmlspecialchars($need['description'])) ?>
            </div>
        </div>

        <!-- Paket Bahan Pangan yang Dibutuhkan -->
        <div style="margin-bottom: 28px;">
            <span style="font-size: 0.78rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 8px;">
                Rincian Paket Bahan Pangan Bergizi:
            </span>
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 20px; border-radius: var(--radius-sm); color: #0c4a6e; font-size: 0.98rem; font-weight: 600; line-height: 1.6;">
                <?= nl2br(htmlspecialchars($need['food_items_needed'])) ?>
            </div>
        </div>

        <!-- Titik Drop-Point Resmi -->
        <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 22px; border-radius: var(--radius-sm); margin-bottom: 28px;">
            <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 8px;">
                Titik Serah Terima Paket (Drop-Point Faskes Mitra):
            </span>
            <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                <?= htmlspecialchars($need['drop_point_name']) ?>
            </div>
            <p style="font-size: 0.92rem; color: var(--text-muted); margin-bottom: 10px; line-height: 1.5;">
                <?= htmlspecialchars($need['drop_point_address']) ?>
            </p>
            <div style="font-size: 0.85rem; color: #475569; padding-top: 8px; border-top: 1px solid #e2e8f0;">
                Penanggung Jawab: <strong><?= htmlspecialchars($need['officer_in_charge']) ?></strong> • Kontak: <?= htmlspecialchars($need['drop_point_phone']) ?>
            </div>
        </div>

        <!-- Bagian Aksi Donasi / Komitmen 48 Jam -->
        <?php if ($need['status'] === 'dipublikasikan'): ?>
            <?php if (is_logged_in() && is_donatur()): ?>
                <form action="index.php?action=commit-donation" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <input type="hidden" name="need_id" value="<?= $need['id'] ?>">
                    
                    <div class="alert alert-info" style="font-size: 0.92rem; line-height: 1.5; margin-bottom: 18px;">
                        <strong>Ketentuan Komitmen Donatur:</strong> Dengan menekan tombol di bawah, Anda berkomitmen menyediakan dan mengantarkan paket pangan di atas ke Posyandu dalam tenggat waktu <strong>48 Jam</strong>, serta mengunggah foto bukti serah terima di dashboard donatur Anda.
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.02rem; padding: 15px;" data-confirm="Apakah Anda bersedia berkomitmen menyediakan paket pangan ini dan menyerahkannya ke Posyandu dalam 48 jam?">
                        Saya Bersedia Membantu (Kunci Komitmen 48 Jam)
                    </button>
                </form>
            <?php elseif (is_logged_in() && !is_donatur()): ?>
                <div class="alert alert-warning" style="font-size: 0.92rem;">
                    Anda saat ini masuk sebagai <strong><?= user_role() ?></strong>. Hanya akun ber-peran <strong>Donatur</strong> yang dapat mengunci komitmen bantuan pangan.
                </div>
            <?php else: ?>
                <div class="card" style="text-align: center; padding: 28px; background: #f8fafc; border: 1px solid var(--border-color); margin: 0;">
                    <h3 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 8px; font-weight: 800;">Ingin Membantu Ibu Hamil Ini?</h3>
                    <p style="color: var(--text-muted); font-size: 0.92rem; margin-bottom: 18px; max-width: 500px; margin-left: auto; margin-right: auto;">
                        Silakan masuk ke akun donatur Anda atau daftarkan akun baru untuk mengunci paket bantuan ini.
                    </p>
                    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                        <a href="index.php?page=login" class="btn btn-primary" style="padding: 10px 24px;">Masuk untuk Membantu</a>
                        <a href="index.php?page=register" class="btn btn-secondary" style="padding: 10px 20px;">Daftar Akun Donatur</a>
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
