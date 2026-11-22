<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 16px;">
        <a href="index.php?page=explore" style="font-weight: 600;">← Kembali ke Katalog Kebutuhan</a>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <?= render_status_badge($need['status']) ?>
            <span class="badge" style="background: #fee2e2; color: #991b1b; font-size: 0.85rem;">
                Indikasi KEK: LILA <?= number_format($need['lila_measurement'], 1) ?> cm (&lt; 23.5 cm)
            </span>
        </div>

        <h1 style="font-size: 1.6rem; margin-bottom: 8px;"><?= htmlspecialchars($need['title']) ?></h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
            Pengaju: <strong><?= mask_name('Ibu', $need['district']) ?></strong> • Usia Kehamilan: <?= $need['gestational_age_weeks'] ?? '-' ?> Minggu • Wilayah: <?= htmlspecialchars($need['district']) ?>, <?= htmlspecialchars($need['regency_city']) ?>
        </p>

        <div style="margin-bottom: 20px;">
            <h4 style="margin-bottom: 6px;">Konteks & Alasan Pengajuan:</h4>
            <p style="background: #f8fafc; padding: 14px; border-radius: 8px; border: 1px solid var(--border-color); font-size: 0.95rem;">
                <?= nl2br(htmlspecialchars($need['description'])) ?>
            </p>
        </div>

        <div style="margin-bottom: 24px;">
            <h4 style="margin-bottom: 6px;">Paket Bahan Pangan Bergizi yang Dibutuhkan:</h4>
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; padding: 16px; border-radius: 8px; color: #065f46; font-size: 1rem;">
                <?= nl2br(htmlspecialchars($need['food_items_needed'])) ?>
            </div>
        </div>

        <div style="background: #f1f5f9; padding: 20px; border-radius: 10px; margin-bottom: 24px;">
            <h4 style="color: #1e293b; margin-bottom: 8px;">📍 Alamat Penyerahan Paket (Drop-Point Resmi):</h4>
            <p style="font-size: 0.95rem; margin-bottom: 6px;">
                <strong><?= htmlspecialchars($need['drop_point_name']) ?></strong>
            </p>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 8px;">
                <?= htmlspecialchars($need['drop_point_address']) ?>
            </p>
            <p style="font-size: 0.85rem; color: #475569;">
                Penanggung Jawab: <?= htmlspecialchars($need['officer_in_charge']) ?> (Kontak: <?= htmlspecialchars($need['drop_point_phone']) ?>)
            </p>
        </div>

        <?php if ($need['status'] === 'dipublikasikan'): ?>
            <?php if (is_logged_in() && is_donatur()): ?>
                <form action="index.php?action=commit-donation" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <input type="hidden" name="need_id" value="<?= $need['id'] ?>">
                    
                    <div class="alert alert-info" style="font-size: 0.9rem;">
                        <strong>Perhatian Donatur:</strong> Dengan menekan tombol di bawah, Anda berkomitmen membantu paket ini. Status akan dikunci selama <strong>48 Jam</strong> untuk Anda mengantarkan / mengirimkan paket ke Posyandu di atas dan mengunggah bukti tanda terima.
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 14px;" data-confirm="Apakah Anda bersedia berkomitmen menyediakan paket pangan ini dan menyerahkannya ke Posyandu dalam 48 jam?">
                        🤝 Saya Bersedia Membantu (Kunci Komitmen 48 Jam)
                    </button>
                </form>
            <?php elseif (is_logged_in() && !is_donatur()): ?>
                <div class="alert alert-warning">
                    Anda masuk sebagai <strong><?= user_role() ?></strong>. Hanya akun ber-peran <strong>Donatur</strong> yang dapat mengunci komitmen bantuan.
                </div>
            <?php else: ?>
                <div class="alert alert-info" style="text-align: center;">
                    <p style="margin-bottom: 12px;">Ingin membantu ibu hamil ini? Silakan masuk atau daftar sebagai Donatur terlebih dahulu.</p>
                    <a href="index.php?page=login" class="btn btn-primary">Masuk untuk Membantu</a>
                    <a href="index.php?page=register" class="btn btn-secondary">Daftar Akun Donatur</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                Pengajuan ini saat ini berstatus: <strong><?= htmlspecialchars($need['status']) ?></strong> dan tidak menerima komitmen baru.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
