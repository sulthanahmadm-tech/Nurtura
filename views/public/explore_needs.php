<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
?>

<!-- Header Katalog Editorial (Tanpa Emoji) -->
<div class="card" style="padding: 32px; margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
        <div style="max-width: 760px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span class="badge badge-info">Data Terverifikasi Medis</span>
                <span class="badge badge-secondary">Penyaluran Drop-Point Posyandu</span>
            </div>
            <h1 style="font-size: 1.75rem; color: #0f172a; margin-bottom: 8px; font-weight: 800; letter-spacing: -0.02em;">
                Katalog Kebutuhan Pangan Bergizi Ibu Hamil
            </h1>
            <p style="color: var(--text-muted); font-size: 0.96rem; line-height: 1.6; margin: 0;">
                Seluruh pengajuan di bawah ini telah divalidasi oleh admin NurturaGuard berdasarkan lembar resmi Buku KIA dengan indikator lingkar lengan atas (LILA &lt; 23,5 cm). Bantuan diserahkan langsung ke fasilitas kesehatan mitra dalam wujud bahan pangan riil.
            </p>

            <!-- Filter Cepat Pil Teks Bersih -->
            <div class="filter-pills">
                <button type="button" class="filter-pill active" onclick="filterNeeds('all', this)">Semua Kebutuhan</button>
                <button type="button" class="filter-pill" onclick="filterNeeds('purwokerto-timur', this)">Purwokerto Timur</button>
                <button type="button" class="filter-pill" onclick="filterNeeds('kek-mendesak', this)">KEK Mendesak (&lt; 22 cm)</button>
            </div>
        </div>

        <div style="background: #f0f9ff; border: 1px solid rgba(2, 132, 199, 0.2); padding: 16px 24px; border-radius: var(--radius-sm); text-align: center; min-width: 130px;">
            <div id="active-count" style="font-size: 1.8rem; font-weight: 900; color: #0284c7; line-height: 1;"><?= count($needs) ?></div>
            <div style="font-size: 0.74rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 6px;">Kebutuhan Aktif</div>
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
        <h3 style="font-size: 1.25rem; color: #0f172a; margin-bottom: 8px;">Saat ini semua kebutuhan gizi telah terpenuhi.</h3>
        <p style="color: var(--text-muted); max-width: 520px; margin: 0 auto; font-size: 0.94rem; line-height: 1.6;">
            Seluruh paket pangan bergizi telah dikomitmenkan oleh donatur atau sedang ditinjau oleh admin medis. Terima kasih atas solidaritas Anda.
        </p>
        <div style="margin-top: 24px;">
            <a href="index.php?page=home" class="btn btn-secondary btn-sm">Kembali ke Beranda</a>
        </div>
    </div>
<?php else: ?>
    <div class="grid" id="needs-grid">
        <?php foreach ($needs as $n): ?>
            <div class="card need-card-item" 
                 data-district="<?= strtolower(htmlspecialchars($n['district'])) ?>" 
                 data-lila="<?= (float)$n['lila_measurement'] ?>"
                 style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); padding: 26px;">
                <div>
                    <!-- Badge Top Row (Tanpa Emoji) -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; gap: 8px;">
                        <span class="badge badge-info" style="font-size: 0.72rem;">Terverifikasi KIA</span>
                        <span class="badge badge-coral" style="font-size: 0.72rem;">
                            LILA: <?= number_format($n['lila_measurement'], 1) ?> cm • Indikasi KEK
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 style="font-size: 1.2rem; margin-bottom: 6px; font-weight: 800; line-height: 1.3;">
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" style="color: #0f172a;">
                            <?= htmlspecialchars($n['title']) ?>
                        </a>
                    </h3>

                    <!-- Pengaju & Wilayah (Inisial Bulat Bersih, No Emoji) -->
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 14px;">
                        <div style="width: 22px; height: 22px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 800;">
                            I
                        </div>
                        <span><strong><?= mask_name('Ibu', $n['district']) ?></strong> • <?= htmlspecialchars($n['district']) ?>, <?= htmlspecialchars($n['regency_city']) ?></span>
                    </div>

                    <!-- Paket Pangan Box -->
                    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); margin-bottom: 14px;">
                        <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                            Paket Bahan Pangan yang Dibutuhkan:
                        </span>
                        <p style="margin: 0; color: #1e293b; font-size: 0.92rem; font-weight: 600; line-height: 1.5;">
                            <?= nl2br(htmlspecialchars($n['food_items_needed'])) ?>
                        </p>
                    </div>

                    <!-- Drop Point Posyandu -->
                    <div style="font-size: 0.84rem; color: var(--text-muted); margin-bottom: 18px; line-height: 1.45;">
                        <span style="font-size: 0.74rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.03em; display: block;">Titik Antar Posyandu:</span>
                        <span style="color: #0f172a; font-weight: 700;"><?= htmlspecialchars($n['drop_point_name']) ?></span>
                    </div>
                </div>

                <!-- Action CTA Button (Tanpa Emoji/Panah) -->
                <div>
                    <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" class="btn btn-primary" style="width: 100%; font-size: 0.92rem; text-align: center;">
                        Bantu Paket Pangan Ini
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function filterNeeds(filterType, btnEl) {
    // Update active pill
    document.querySelectorAll('.filter-pill').forEach(el => el.classList.remove('active'));
    btnEl.classList.add('active');

    const cards = document.querySelectorAll('.need-card-item');
    let visibleCount = 0;

    cards.forEach(card => {
        const district = card.getAttribute('data-district') || '';
        const lila = parseFloat(card.getAttribute('data-lila') || '99');

        let show = true;
        if (filterType === 'purwokerto-timur') {
            show = district.includes('purwokerto timur');
        } else if (filterType === 'kek-mendesak') {
            show = lila < 22.0;
        }

        if (show) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const countEl = document.getElementById('active-count');
    if (countEl) {
        countEl.textContent = visibleCount;
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
