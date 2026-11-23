<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="hero">
    <div style="display: inline-block; margin-bottom: 12px;">
        <span class="badge badge-coral">1.000 Hari Pertama Kehidupan</span>
    </div>
    <h1>Nurturing Mothers, Nourishing Futures</h1>
    <p>
        Platform pencegahan stunting berbasis komunitas. Menghubungkan ibu hamil berisiko Kurang Energi Kronis (KEK) dengan donatur peduli melalui titik penyaluran resmi Posyandu & Bidan Desa.
    </p>
    <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
        <a href="index.php?page=explore" class="btn btn-primary" style="font-size: 1rem; padding: 12px 26px;">
            🔍 Lihat Kebutuhan yang Memerlukan Bantuan
        </a>
        <a href="index.php?page=register" class="btn btn-coral" style="font-size: 1rem; padding: 12px 26px;">
            🤝 Gabung Menjadi Donatur / Ajukan Kebutuhan
        </a>
    </div>
</div>

<div class="grid" style="margin-top: 16px;">
    <div class="card">
        <div style="width: 44px; height: 44px; border-radius: var(--radius-sm); background: var(--primary-light); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px;">
            🛡️
        </div>
        <h3 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem;">100% Bebas Pengelolaan Uang</h3>
        <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.5;">
            Nurtura bukan crowdfunding uang. Bantuan disalurkan berupa <strong>paket pangan bergizi riil</strong> (telur, susu ibu hamil, kacang-kacangan, protein) langsung ke mitra Posyandu.
        </p>
    </div>
    <div class="card">
        <div style="width: 44px; height: 44px; border-radius: var(--radius-sm); background: var(--accent-coral-light); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px;">
            🔒
        </div>
        <h3 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem;">Privasi Ibu Hamil Terlindungi</h3>
        <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.5;">
            Nama dan alamat rumah ibu hamil tidak pernah dipublikasikan. Paket bantuan dikirim ke <strong>Drop-Point Posyandu / Bidan Desa</strong> terdaftar, di mana ibu hamil mengambilnya saat jadwal kontrol.
        </p>
    </div>
    <div class="card">
        <div style="width: 44px; height: 44px; border-radius: var(--radius-sm); background: var(--secondary-light); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px;">
            📋
        </div>
        <h3 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem;">Terverifikasi Medis (Buku KIA)</h3>
        <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.5;">
            Setiap pengajuan wajib melampirkan lembar resmi <strong>Buku KIA (Kesehatan Ibu dan Anak)</strong> dengan indikator Lingkar Lengan Atas (LILA &lt; 23,5 cm) yang diperiksa ketat oleh admin NurturaGuard.
        </p>
    </div>
</div>

<div class="card" style="margin-top: 12px; text-align: center; border: 1px solid var(--border-color); background: #ffffff;">
    <h3 style="margin-bottom: 8px; font-size: 1.2rem; color: var(--text-main);">Data & Target Pencegahan Stunting Nasional</h3>
    <p style="color: var(--text-muted); max-width: 750px; margin: 0 auto; font-size: 0.93rem;">
        Berdasarkan data Survei Status Gizi Indonesia (SSGI), prevalensi stunting nasional berada di angka <strong>19,8%</strong>. Nutrisi ibu selama 270 hari masa kehamilan adalah penentu utama pencegahan lahirnya bayi stunting.
    </p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
