<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<!-- 1. HEADER KATALOG (NURTURA CLINICAL CARE) -->
<section class="card-clean" style="padding: clamp(1.25rem, 3.5vw, 2rem); margin-bottom: 1.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1.25rem;">
        <div style="max-width: min(45rem, 100%); flex: 1;">
            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.5rem;">
                Data Terverifikasi Medis · Penyaluran Drop-Point Posyandu
            </span>

            <h1 style="font-size: clamp(1.625rem, 4.8vw, 2.2rem); color: var(--text-main); margin-bottom: 0.625rem; font-weight: 700; line-height: 1.2;">
                Katalog Kebutuhan Pangan Bergizi Ibu Hamil
            </h1>

            <p style="color: var(--text-muted); font-size: 0.94rem; line-height: 1.6; margin: 0;">
                Seluruh pengajuan di bawah ini telah divalidasi oleh admin NurturaGuard berdasarkan lembar resmi Buku KIA dengan indikator lingkar lengan atas (LILA &lt; 23,5 cm). Bantuan diserahkan langsung ke fasilitas kesehatan mitra dalam wujud bahan pangan riil.
            </p>

            <!-- Filter Cepat (Swipeable di Mobile) -->
            <div class="filter-tabs-clean" role="group" aria-label="Filter kebutuhan berdasarkan wilayah dan urgensi LILA">
                <button type="button" class="filter-tab-btn active" onclick="filterNeeds('all', this)">Semua Kebutuhan</button>
                <button type="button" class="filter-tab-btn" onclick="filterNeeds('purwokerto-timur', this)">Purwokerto Timur</button>
                <button type="button" class="filter-tab-btn" onclick="filterNeeds('sokaraja', this)">Sokaraja</button>
                <button type="button" class="filter-tab-btn" onclick="filterNeeds('kek-mendesak', this)">KEK Mendesak (&lt; 22 cm)</button>
            </div>
        </div>

        <div class="inset-well" style="padding: 1rem 1.5rem; text-align: center; min-width: 9.25rem; border: 0.0625rem solid var(--border-subtle);">
            <div id="active-count" class="font-mono" style="font-size: 2.2rem; font-weight: 700; color: var(--primary); line-height: 1;">
                <?= count($needs) ?>
            </div>
            <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); margin-top: 0.375rem;">
                Kebutuhan Aktif
            </div>
        </div>
    </div>
</section>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<?php if (empty($needs)): ?>
    <div class="card-clean" style="text-align: center; padding: clamp(2rem, 6vw, 3.75rem) 1.5rem;">
        <h3 style="font-size: 1.25rem; color: var(--text-main); margin-bottom: 0.5rem; font-weight: 700;">
            Saat ini semua kebutuhan gizi telah terpenuhi.
        </h3>
        <p style="color: var(--text-muted); max-width: min(31.25rem, 100%); margin: 0 auto 1.5rem auto; font-size: 0.92rem; line-height: 1.6;">
            Seluruh paket pangan bergizi telah dikomitmenkan oleh donatur atau sedang ditinjau oleh admin medis. Terima kasih atas solidaritas Anda.
        </p>
        <a href="index.php?page=home" class="btn-cerulean">Kembali ke Beranda</a>
    </div>
<?php else: ?>
    <!-- 2. GRID KARTU KEBUTUHAN -->
    <section class="grid" id="needs-grid">
        <?php foreach ($needs as $n): ?>
            <?php
                $lila_num = (float)($n['lila_measurement'] ?? 0);
                $is_kek = $lila_num < 23.5;
            ?>
            <article class="card-clean need-card-item"
                 data-district="<?= strtolower(htmlspecialchars($n['district'])) ?>"
                 data-lila="<?= $lila_num ?>">
                <div style="display: flex; flex-direction: column; gap: 0.875rem;">
                    <!-- Status Header Row -->
                    <header style="display: flex; flex-direction: column; gap: 0.375rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                            <span class="<?= $is_kek ? 'status-kek-text' : 'status-normal-text' ?>">
                                <?= $is_kek ? 'LILA ' . number_format($lila_num, 1) . ' cm · KEK' : 'LILA ' . number_format($lila_num, 1) . ' cm · Normal' ?>
                            </span>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--botanical);">
                                Terverifikasi KIA
                            </span>
                        </div>

                        <h2 style="font-family: var(--font-sans); font-size: 1.15rem; font-weight: 700; line-height: 1.35; margin: 0;">
                            <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" style="color: var(--text-main);">
                                <?= htmlspecialchars($n['title']) ?>
                            </a>
                        </h2>

                        <p style="font-size: 0.86rem; color: var(--text-muted); margin: 0;">
                            <?= mask_name('Ibu', $n['district']) ?> · <?= htmlspecialchars($n['district']) ?>, <?= htmlspecialchars($n['regency_city']) ?>
                        </p>
                    </header>

                    <!-- Paket Pangan Inset Well -->
                    <div class="inset-well" style="padding: 0.875rem 1rem;">
                        <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">
                            Paket Bahan Pangan Bergizi
                        </span>
                        <p style="margin: 0; color: var(--text-main); font-size: 0.88rem; font-weight: 500; line-height: 1.55;">
                            <?= nl2br(htmlspecialchars($n['food_items_needed'])) ?>
                        </p>
                    </div>
                </div>

                <footer style="display: flex; flex-direction: column; gap: 0.75rem; padding-top: 0.875rem; margin-top: 1rem; border-top: 0.0625rem solid var(--border-subtle);">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span style="font-size: 0.86rem; font-weight: 600; color: var(--text-main);">
                            <?= htmlspecialchars($n['drop_point_name']) ?>
                        </span>
                    </div>

                    <?php if (is_logged_in() && is_ibu_hamil()): ?>
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>"
                           class="btn-cerulean"
                           style="width: 100%;"
                           onclick="return openIbuHamilDonateModal(event, 'index.php?page=need-detail&id=<?= $n['id'] ?>', '<?= htmlspecialchars(addslashes($n['title']), ENT_QUOTES) ?>')">
                            Bantu Paket Pangan Ini
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=need-detail&id=<?= $n['id'] ?>" class="btn-cerulean" style="width: 100%;">
                            Bantu Paket Pangan Ini
                        </a>
                    <?php endif; ?>
                </footer>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<!-- Modal / Bottom-Sheet Interaktif: Ibu Hamil Klik Donasi -->
<div id="ibu-hamil-donate-modal" class="nurtura-modal-backdrop" onclick="closeIbuHamilDonateModal()" role="dialog" aria-modal="true" aria-labelledby="modal-ibu-title" style="display: none;">
    <div class="nurtura-modal-card" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
            <div>
                <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); margin-bottom: 0.25rem;">
                    Informasi Peran Akun
                </div>
                <h3 id="modal-ibu-title" style="font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;">
                    Anda Masuk Sebagai Ibu Hamil
                </h3>
            </div>
            <button type="button" onclick="closeIbuHamilDonateModal()" aria-label="Tutup" class="modal-close-circle">&times;</button>
        </div>

        <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin: 0 0 0.875rem 0;">
            Secara peran di platform Nurtura, akun <strong>Ibu Hamil</strong> dikhususkan sebagai penerima manfaat paket pangan bergizi, bukan pengirim donasi.
        </p>
        <div style="background: var(--surface-low); border-left: 0.1875rem solid var(--primary); padding: 0.75rem 0.875rem; border-radius: 0 var(--radius-md) var(--radius-md) 0; font-size: 0.86rem; color: var(--primary-dark); margin-bottom: 1.25rem; line-height: 1.55;">
            Jika Anda ingin ikut menyalurkan bantuan untuk pengajuan <strong id="modal-ibu-need-name">ini</strong>, silakan daftar atau masuk menggunakan akun <strong>Donatur</strong>. Anda juga tetap dapat melihat detail informasinya.
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
            <a href="index.php?page=register" class="btn-cerulean" style="width: 100%; padding: 0.6875rem 1.25rem;">
                Daftar Sebagai Donatur →
            </a>
            <a id="modal-ibu-continue-link" href="#" class="btn-ghost-clean" style="width: 100%; padding: 0.6875rem 1.25rem;">
                Tetap Lihat Detail Kebutuhan
            </a>
        </div>
    </div>
</div>

<script>
function filterNeeds(filterType, btnEl) {
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
        } else if (filterType === 'sokaraja') {
            show = district.includes('sokaraja');
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

function openIbuHamilDonateModal(e, detailUrl, needTitle) {
    if (e) e.preventDefault();
    const modal = document.getElementById('ibu-hamil-donate-modal');
    const titleEl = document.getElementById('modal-ibu-need-name');
    const continueEl = document.getElementById('modal-ibu-continue-link');
    if (!modal) {
        window.location.href = detailUrl;
        return false;
    }
    if (titleEl) titleEl.textContent = '"' + needTitle + '"';
    if (continueEl) continueEl.href = detailUrl;
    modal.style.display = 'flex';
    requestAnimationFrame(() => modal.classList.add('is-open'));
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
