<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
?>

<div class="card" style="padding: 28px 32px; margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                <span class="badge badge-info">✓ Data Terverifikasi Medis</span>
                <span class="badge badge-coral">Bebas Transaksi Tunai</span>
            </div>
            <h2 style="font-size: 1.6rem; color: #0f172a; margin-bottom: 6px; font-weight: 800;">
                Katalog Kebutuhan Pangan Bergizi Ibu Hamil
            </h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 720px; line-height: 1.5;">
                Setiap kebutuhan di bawah ini telah divalidasi oleh admin NurturaGuard berdasarkan lembar resmi Buku KIA dengan ukuran LILA di bawah 23,5 cm (Kurang Energi Kronis). Donatur dapat memilih paket dan mengantarkannya langsung ke drop-point Posyandu mitra.
            </p>
        </div>
        <div style="background: #f0f9ff; border: 1px solid rgba(2, 132, 199, 0.2); padding: 12px 20px; border-radius: var(--radius-sm); text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 900; color: #0284c7;"><?= count($needs) ?></div>
            <div style="font-size: 0.76rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Kebutuhan Aktif</div>
        </div>
    </div>
</div>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<?php if (empty($needs)): ?>
    <div class="card" style="text-align: center; padding: 56px 20px;">
        <div style="font-size: 3rem; margin-bottom: 12px;">🎉</div>
        <h3 style="font-size: 1.3rem; color: #0f172a;">Alhamdulillah! Saat ini semua kebutuhan gizi telah terpenuhi.</h3>
        <p style="color: var(--text-muted); margin-top: 8px; max-width: 500px; margin-left: auto; margin-right: auto; font-size: 0.92rem;">
            Seluruh paket pangan bergizi telah dikomitmenkan oleh donatur atau sedang ditinjau oleh admin medis. Terima kasih atas kepedulian Anda!
        </p>
        <div style="margin-top: 20px;">
            <a href="index.php?page=home" class="btn btn-secondary btn-sm">Kembali ke Beranda</a>
        </div>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach ($needs as $n): ?>
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); padding: 26px;">
                <div>
                    <!-- Badge Top Row -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; gap: 8px;">
                        <span class="badge badge-info" style="font-size: 0.72rem;">✓ Terverifikasi KIA</span>
                        <span class="badge badge-coral" style="font-size: 0.72rem;">
                            LILA: <?= number_format($n['lila_measurement'], 1) ?> cm (KEK)
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 style="font-size: 1.2rem; margin-bottom: 6px; font-weight: 800;">
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" style="color: #0f172a;">
                            <?= htmlspecialchars($n['title']) ?>
                        </a>
                    </h3>

                    <!-- Pengaju & Wilayah (Masked) -->
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 14px;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800;">
                            🤰
                        </div>
                        <span><strong><?= mask_name('Ibu', $n['district']) ?></strong> • <?= htmlspecialchars($n['district']) ?>, <?= htmlspecialchars($n['regency_city']) ?></span>
                    </div>

                    <!-- Paket Pangan Box -->
                    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); margin-bottom: 14px;">
                        <span style="font-size: 0.75rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                            📦 Paket Bahan Pangan Dibutuhkan:
                        </span>
                        <p style="margin: 0; color: #1e293b; font-size: 0.92rem; font-weight: 600; line-height: 1.5;">
                            <?= nl2br(htmlspecialchars($n['food_items_needed'])) ?>
                        </p>
                    </div>

                    <!-- Drop Point Posyandu -->
                    <div style="font-size: 0.84rem; color: var(--text-muted); margin-bottom: 18px; line-height: 1.4;">
                        📍 <strong>Titik Antar Posyandu:</strong><br>
                        <span style="color: #0f172a; font-weight: 600;"><?= htmlspecialchars($n['drop_point_name']) ?></span>
                    </div>
                </div>

                <!-- Action CTA Button -->
                <div>
                    <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" class="btn btn-primary" style="width: 100%; font-size: 0.92rem; text-align: center;">
                        Bantu Paket Pangan Ini →
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
