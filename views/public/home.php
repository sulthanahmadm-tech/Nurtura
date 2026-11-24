<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- 1. Split Hero Section -->
<div class="hero">
    <div class="hero-split">
        <div class="hero-content">
            <div style="display: inline-block; margin-bottom: 12px;">
                <span class="badge badge-coral">🌱 Gerakan 1.000 Hari Pertama Kehidupan</span>
            </div>
            <h1>Penuhi Gizi Ibu Hamil, Cegah Stunting Sejak Janin.</h1>
            <p>
                Platform berbasis komunitas yang menghubungkan ibu hamil berisiko Kurang Energi Kronis (KEK) dengan paket pangan bergizi riil melalui titik drop-point resmi Posyandu & Bidan Desa tanpa perantara uang.
            </p>
            <div class="hero-actions">
                <a href="index.php?page=explore" class="btn btn-primary" style="font-size: 0.98rem; padding: 12px 26px;">
                    🔍 Bantu Paket Pangan Sekarang
                </a>
                <a href="index.php?page=register" class="btn btn-secondary" style="font-size: 0.98rem; padding: 12px 24px;">
                    ✍️ Ajukan Kebutuhan Gizi
                </a>
            </div>
            <div class="hero-trust">
                <span>🛡️ Validasi Buku KIA</span>
                <span>•</span>
                <span>🏥 Drop-Point Posyandu</span>
                <span>•</span>
                <span>🥚 100% Pangan Riil</span>
            </div>
        </div>

        <!-- Floating Card Health Metric Preview -->
        <div class="hero-card">
            <div class="hero-card-header">
                <div>
                    <span style="font-size: 0.72rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.05em;">Pratinjau Kebutuhan Medis</span>
                    <h3 style="font-size: 1.05rem; margin: 2px 0 0 0; color: #0f172a;">Paket Telur & Susu Prenatal</h3>
                </div>
                <span class="badge badge-info">✓ Terverifikasi</span>
            </div>

            <div class="hero-card-metric">
                <div style="display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-size: 0.82rem; font-weight: 700; color: #64748b;">Lingkar Lengan Atas (LILA):</span>
                    <span style="font-size: 1.15rem; font-weight: 900; color: #f43f5e;">21.0 cm</span>
                </div>
                <div class="metric-bar-bg">
                    <div class="metric-bar-fill" style="width: 72%;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 5px; font-size: 0.74rem; color: #64748b;">
                    <span style="color: #f43f5e; font-weight: 700;">Indikasi KEK (&lt; 23.5 cm)</span>
                    <span>Ambang Normal: 23.5 cm</span>
                </div>
            </div>

            <div style="font-size: 0.85rem; color: #475569; margin-bottom: 14px; line-height: 1.5;">
                📍 <strong>Titik Antar Donatur:</strong><br>
                Puskesmas Pembantu (Pustu) Kranji, Purwokerto Timur
            </div>

            <a href="index.php?page=explore" class="btn btn-primary btn-sm" style="width: 100%; text-align: center;">
                Bantu Kebutuhan Ibu Ini →
            </a>
        </div>
    </div>
</div>

<!-- 2. Alur 3 Langkah Komunitas (Bagaimana Nurtura Bekerja) -->
<div style="text-align: center; margin: 36px 0 16px 0;">
    <span class="badge badge-info" style="margin-bottom: 8px;">Transparan & Tanpa Uang Tunai</span>
    <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">
        Bagaimana Bantuan Gizi Sampai ke Ibu Hamil?
    </h2>
    <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 650px; margin: 0 auto;">
        Nurtura memutus risiko penipuan dan kebocoran dana dengan menyalurkan makanan bergizi riil langsung ke fasilitas kesehatan mitra.
    </p>
</div>

<div class="stepper">
    <div class="step-card">
        <div class="step-num">1</div>
        <h3 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 8px;">Pemeriksaan & Pengajuan KIA</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
            Ibu hamil memeriksa ukuran LILA di posyandu. Jika di bawah 23,5 cm (KEK), ibu hamil mengunggah foto lembar catatan Buku KIA untuk diverifikasi oleh admin.
        </p>
    </div>

    <div class="step-card active">
        <div class="step-num">2</div>
        <h3 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 8px;">Donatur Drop di Posyandu</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
            Donatur memilih paket pangan riil (telur, susu, protein) dan memiliki waktu 48 jam untuk menitipkannya langsung ke drop-point Posyandu/Bidan Desa terpilih.
        </p>
    </div>

    <div class="step-card">
        <div class="step-num">3</div>
        <h3 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 8px;">Penyaluran Terpantau</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
            Ibu hamil mengambil paket saat jadwal kontrol rutin Posyandu. Penerimaan dikonfirmasi di sistem dan donatur menerima notifikasi keberhasilan.
        </p>
    </div>
</div>

<!-- 3. Bento Grid 3 Pilar Utama -->
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
            ⏱️
        </div>
        <h3 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem;">Anti-Ghosting Donatur (48 Jam)</h3>
        <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.5;">
            Sistem dilengkapi pengunci otomatis 48 jam. Jika donatur tidak mengunggah bukti serah terima dalam tenggat waktu, kebutuhan otomatis dirilis kembali untuk donatur lain.
        </p>
    </div>
</div>

<!-- 4. Data & Target Nasional Stunting -->
<div class="stat-grid" style="margin-top: 16px;">
    <div class="stat-box">
        <div class="stat-val" style="color: #f43f5e;">19,8%</div>
        <div class="stat-lbl">Prevalensi Stunting Nasional (SSGI)</div>
    </div>
    <div class="stat-box">
        <div class="stat-val" style="color: #0284c7;">&lt; 14%</div>
        <div class="stat-lbl">Target Bebas Stunting Kemenkes</div>
    </div>
    <div class="stat-box">
        <div class="stat-val" style="color: #10b981;">270 Hari</div>
        <div class="stat-lbl">Periode Emas Nutrisi Janin</div>
    </div>
</div>

<!-- 5. Call to Action Banner -->
<div class="card" style="margin-top: 24px; text-align: center; padding: 40px 24px; background: #ffffff; border: 1px solid var(--border-color);">
    <h3 style="font-size: 1.45rem; color: #0f172a; margin-bottom: 8px;">Siap Bergotong Royong Menyelamatkan Generasi Emas?</h3>
    <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto 20px auto; font-size: 0.95rem;">
        Satu paket telur atau susu dari Anda memastikan janin menerima asupan protein cukup di masa pembentukan sel otak vitalnya.
    </p>
    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
        <a href="index.php?page=explore" class="btn btn-primary" style="padding: 12px 28px;">
            🔍 Jelajahi Kebutuhan Sekarang
        </a>
        <a href="index.php?page=register" class="btn btn-secondary" style="padding: 12px 24px;">
            Daftar Sebagai Donatur / Ibu Hamil
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
