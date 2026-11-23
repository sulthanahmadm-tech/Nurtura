<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
?>

<div style="margin-bottom: 24px;">
    <h2>Katalog Kebutuhan Gizi Ibu Hamil Terverifikasi</h2>
    <p style="color: var(--text-muted);">
        Semua pengajuan di bawah ini telah divalidasi oleh tim medis/admin NurturaGuard melalui verifikasi lembar Buku KIA dan indikator Kurang Energi Kronis (KEK).
    </p>
</div>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<?php if (empty($needs)): ?>
    <div class="card" style="text-align: center; padding: 48px 20px;">
        <h3>Alhamdulillah! Saat ini belum ada kebutuhan baru yang menunggu bantuan.</h3>
        <p style="color: var(--text-muted); margin-top: 8px;">Semua kebutuhan terverifikasi telah diproses oleh donatur atau sedang ditinjau oleh admin.</p>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach ($needs as $n): ?>
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                        <span class="badge badge-info">✓ Terverifikasi Admin</span>
                        <span class="badge badge-coral">
                            LILA: <?= number_format($n['lila_measurement'], 1) ?> cm (KEK)
                        </span>
                    </div>

                    <h3 style="font-size: 1.15rem; margin-bottom: 8px;">
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>"><?= htmlspecialchars($n['title']) ?></a>
                    </h3>

                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">
                        Pengaju: <strong><?= mask_name('Ibu', $n['district']) ?></strong> • Wilayah: <?= htmlspecialchars($n['district']) ?>, <?= htmlspecialchars($n['regency_city']) ?>
                    </p>

                    <div style="background: #f8fafc; border: 1px dashed var(--border-color); padding: 12px; border-radius: 8px; margin-bottom: 12px; font-size: 0.9rem;">
                        <strong>Paket Pangan yang Dibutuhkan:</strong>
                        <p style="margin-top: 4px; color: #1e293b;"><?= nl2br(htmlspecialchars($n['food_items_needed'])) ?></p>
                    </div>

                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px;">
                        📍 <strong>Tujuan Pengiriman:</strong><br>
                        <?= htmlspecialchars($n['drop_point_name']) ?>
                    </div>
                </div>

                <div>
                    <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" class="btn btn-primary" style="width: 100%;">
                        Lihat Rincian & Bantu Kebutuhan Ini →
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
