<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<!-- 1. HEADER KATALOG (CLEAN HEADER) -->
<div class="card-clean" style="padding: 36px; margin-bottom: 28px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 24px;">
        <div style="max-width: 780px;">
            <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 8px;">
                Data Terverifikasi Medis · Penyaluran Drop-Point Posyandu
            </div>
            
            <h1 style="font-size: 2.1rem; color: var(--text-main); margin-bottom: 10px; font-weight: 700; letter-spacing: -0.025em; line-height: 1.15;">
                Katalog Kebutuhan Pangan Bergizi Ibu Hamil
            </h1>
            
            <p style="color: var(--text-muted); font-size: 0.96rem; line-height: 1.6; margin: 0;">
                Seluruh pengajuan di bawah ini telah divalidasi oleh admin NurturaGuard berdasarkan lembar resmi Buku KIA dengan indikator lingkar lengan atas (LILA &lt; 23,5 cm). Bantuan diserahkan langsung ke fasilitas kesehatan mitra dalam wujud bahan pangan riil.
            </p>

            <!-- Filter Cepat Bersih -->
            <div class="filter-tabs-clean">
                <button type="button" class="filter-tab-btn active" onclick="filterNeeds('all', this)">Semua Kebutuhan</button>
                <button type="button" class="filter-tab-btn" onclick="filterNeeds('purwokerto-timur', this)">Purwokerto Timur</button>
                <button type="button" class="filter-tab-btn" onclick="filterNeeds('kek-mendesak', this)">KEK Mendesak (&lt; 22 cm)</button>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px 28px; text-align: center; min-width: 140px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div id="active-count" style="font-size: 2.3rem; font-weight: 800; color: #0284c7; line-height: 1; letter-spacing: -0.03em;">
                <?= count($needs) ?>
            </div>
            <div style="font-size: 0.74rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 6px;">
                Kebutuhan Aktif
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" style="margin-bottom: 24px;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<?php if (empty($needs)): ?>
    <div class="card-clean" style="text-align: center; padding: 64px 20px;">
        <h3 style="font-size: 1.3rem; color: var(--text-main); margin-bottom: 8px; font-weight: 700;">
            Saat ini semua kebutuhan gizi telah terpenuhi.
        </h3>
        <p style="color: var(--text-muted); max-width: 520px; margin: 0 auto; font-size: 0.94rem; line-height: 1.6;">
            Seluruh paket pangan bergizi telah dikomitmenkan oleh donatur atau sedang ditinjau oleh admin medis. Terima kasih atas solidaritas Anda.
        </p>
        <div style="margin-top: 24px;">
            <a href="index.php?page=home" class="btn-lime">Kembali ke Beranda</a>
        </div>
    </div>
<?php else: ?>
    <!-- 2. GRID KARTU KEBUTUHAN (CLEAN CARDS) -->
    <div class="grid" id="needs-grid">
        <?php foreach ($needs as $n): ?>
            <?php 
                $lila_num = (float)($n['lila_measurement'] ?? 0);
                $is_kek = $lila_num < 23.5;
            ?>
            <div class="card-clean need-card-item" 
                 data-district="<?= strtolower(htmlspecialchars($n['district'])) ?>" 
                 data-lila="<?= $lila_num ?>">
                <div>
                    <!-- Status Header Bar (Clean Typographic Row) -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; gap: 8px; flex-wrap: wrap;">
                        <span class="<?= $is_kek ? 'status-kek-text' : 'status-normal-text' ?>" style="font-size: 0.8rem;">
                            <?= $is_kek ? 'LILA ' . number_format($lila_num, 1) . ' cm · Indikasi KEK' : 'LILA ' . number_format($lila_num, 1) . ' cm · Normal' ?>
                        </span>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #0284c7;">
                            Terverifikasi KIA
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 style="font-size: 1.25rem; margin-bottom: 8px; font-weight: 700; line-height: 1.3; letter-spacing: -0.015em;">
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" style="color: var(--text-main); text-decoration: none;">
                            <?= htmlspecialchars($n['title']) ?>
                        </a>
                    </h3>

                    <!-- Pengaju & Wilayah -->
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: #f0f9ff; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 800;">
                            I
                        </div>
                        <span><strong><?= mask_name('Ibu', $n['district']) ?></strong> • <?= htmlspecialchars($n['district']) ?>, <?= htmlspecialchars($n['regency_city']) ?></span>
                    </div>

                    <!-- Paket Pangan Box -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 16px; border-radius: 14px; margin-bottom: 16px;">
                        <span style="font-size: 0.72rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">
                            Paket Bahan Pangan Bergizi:
                        </span>
                        <p style="margin: 0; color: #1e293b; font-size: 0.92rem; font-weight: 600; line-height: 1.55;">
                            <?= nl2br(htmlspecialchars($n['food_items_needed'])) ?>
                        </p>
                    </div>

                    <!-- Titik Antar Posyandu -->
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 22px; line-height: 1.45;">
                        <span style="font-size: 0.72rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.04em; display: block;">Titik Drop-Point Posyandu:</span>
                        <span style="color: var(--text-main); font-weight: 700;"><?= htmlspecialchars($n['drop_point_name']) ?></span>
                    </div>
                </div>

                <!-- Action CTA Button (Clean Lime CTA) -->
                <div>
                    <?php if (is_logged_in() && is_ibu_hamil()): ?>
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>"
                           class="btn-lime"
                           style="width: 100%; justify-content: center; font-size: 0.94rem; padding: 12px 20px;"
                           onclick="return openIbuHamilDonateModal(event, 'index.php?page=need-detail&id=<?= $n['id'] ?>', '<?= htmlspecialchars(addslashes($n['title']), ENT_QUOTES) ?>')">
                            Bantu Paket Pangan Ini →
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" class="btn-lime" style="width: 100%; justify-content: center; font-size: 0.94rem; padding: 12px 20px;">
                            Bantu Paket Pangan Ini →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal Interaktif: Ibu Hamil Klik Donasi -->
<div id="ibu-hamil-donate-modal" class="nurtura-modal-backdrop" onclick="closeIbuHamilDonateModal()" role="dialog" aria-modal="true" aria-labelledby="modal-ibu-title" style="display: none;">
    <div class="nurtura-modal-card" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
            <div>
                <div style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 4px;">
                    Informasi Peran Akun
                </div>
                <h3 id="modal-ibu-title" style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.3;">
                    Anda Masuk Sebagai Ibu Hamil
                </h3>
            </div>
            <button type="button" onclick="closeIbuHamilDonateModal()" aria-label="Tutup" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 50%; width: 32px; height: 32px; font-size: 1.1rem; color: #64748b; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">&times;</button>
        </div>

        <p style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin: 0 0 14px 0;">
            Secara peran di platform Nurtura, akun <strong>Ibu Hamil</strong> dikhususkan sebagai penerima manfaat paket pangan bergizi, bukan pengirim donasi.
        </p>
        <div style="background: #f0f9ff; border-left: 3px solid #0284c7; padding: 12px 14px; border-radius: 0 12px 12px 0; font-size: 0.86rem; color: #0c4a6e; margin-bottom: 20px; line-height: 1.5;">
            Jika Anda ingin ikut menyalurkan bantuan untuk pengajuan <strong id="modal-ibu-need-name">ini</strong>, silakan daftar atau masuk menggunakan akun <strong>Donatur</strong>. Anda juga tetap dapat melihat detail informasinya.
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="index.php?page=register" class="btn-lime" style="width: 100%; justify-content: center; padding: 12px 20px;">
                Daftar Sebagai Donatur →
            </a>
            <a id="modal-ibu-continue-link" href="#" class="btn-ghost-clean" style="width: 100%; justify-content: center; padding: 11px 20px;">
                Tetap Lihat Detail Kebutuhan
            </a>
        </div>
    </div>
</div>

<script>
function filterNeeds(filterType, btnEl) {
    // Update active tab
    document.querySelectorAll('.filter-tab-btn').forEach(el => el.classList.remove('active'));
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
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const activeCountEl = document.getElementById('active-count');
    if (activeCountEl) {
        activeCountEl.textContent = visibleCount;
    }
}

function openIbuHamilDonateModal(event, targetUrl, needTitle) {
    event.preventDefault();
    const modal = document.getElementById('ibu-hamil-donate-modal');
    const link = document.getElementById('modal-ibu-continue-link');
    const titleEl = document.getElementById('modal-ibu-need-name');
    if (link) link.href = targetUrl;
    if (titleEl && needTitle) titleEl.textContent = '"' + needTitle + '"';
    if (modal) {
        modal.style.display = 'flex';
        requestAnimationFrame(() => modal.classList.add('is-open'));
    }
    return false;
}

function closeIbuHamilDonateModal() {
    const modal = document.getElementById('ibu-hamil-donate-modal');
    if (modal) {
        modal.classList.remove('is-open');
        setTimeout(() => { modal.style.display = 'none'; }, 180);
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

