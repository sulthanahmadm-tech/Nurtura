<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="card" style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%); border: 1px solid #a7f3d0; text-align: center; padding: 48px 24px;">
    <h1 style="font-size: 2.4rem; color: #064e3b; margin-bottom: 12px;">Nurturing Mothers, Nourishing Futures</h1>
    <p style="font-size: 1.15rem; color: #047857; max-width: 700px; margin: 0 auto 24px auto;">
        Platform pencegahan stunting berbasis komunitas. Menghubungkan ibu hamil berisiko Kurang Energi Kronis (KEK) dengan donatur peduli melalui titik penyaluran resmi Posyandu & Bidan Desa.
    </p>
    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
        <a href="index.php?page=explore" class="btn btn-primary" style="font-size: 1.05rem; padding: 12px 24px;">
            🔍 Lihat Kebutuhan yang Memerlukan Bantuan
        </a>
        <a href="index.php?page=register" class="btn btn-secondary" style="font-size: 1.05rem; padding: 12px 24px;">
            ✍️ Gabung Menjadi Donatur / Ajukan Kebutuhan
        </a>
    </div>
</div>

<div class="grid" style="margin-top: 32px;">
    <div class="card">
        <h3 style="color: #059669; margin-bottom: 8px;">🛡️ 100% Bebas Pengelolaan Uang</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            Nurtura bukan platform penghimpun dana donasi (crowdfunding uang). Bantuan disalurkan berupa <strong>paket pangan bergizi riil</strong> (telur, susu hamil, kacang-kacangan, protein) langsung ke mitra Posyandu.
        </p>
    </div>
    <div class="card">
        <h3 style="color: #059669; margin-bottom: 8px;">🔒 Privasi Ibu Hamil Terlindungi</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            Nama dan alamat rumah ibu hamil tidak pernah dipublikasikan. Paket bantuan dikirim ke <strong>Drop-Point Posyandu / Bidan Desa</strong> terdaftar, di mana ibu hamil mengambilnya saat jadwal kontrol.
        </p>
    </div>
    <div class="card">
        <h3 style="color: #059669; margin-bottom: 8px;">📋 Terverifikasi Medis (Buku KIA)</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            Setiap pengajuan wajib melampirkan lembar resmi <strong>Buku KIA (Kesehatan Ibu dan Anak)</strong> dengan indikator Lingkar Lengan Atas (LILA &lt; 23,5 cm) yang diperiksa ketat oleh admin NurturaGuard.
        </p>
    </div>
</div>

<div class="card" style="margin-top: 24px; text-align: center;">
    <h3 style="margin-bottom: 8px;">Data & Target Pencegahan Stunting</h3>
    <p style="color: var(--text-muted); max-width: 750px; margin: 0 auto; font-size: 0.95rem;">
        Berdasarkan data Survei Status Gizi Indonesia (SSGI), prevalensi stunting nasional berada di angka <strong>19,8%</strong>. Nutrisi ibu selama 270 hari masa kehamilan adalah penentu utama pencegahan lahirnya bayi stunting.
    </p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
