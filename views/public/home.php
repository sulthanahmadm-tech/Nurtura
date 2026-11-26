<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- 1. HERO + DEVICE MOCKUP FRAME (CLEAN ICE CYAN & LIME) -->
<div class="hero-clean">
    <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 12px;">
        Gerakan 1.000 Hari Pertama Kehidupan · Standar Gizi Kemenkes
    </div>
    
    <h1>Penuhi Gizi Ibu Hamil, Wujudkan Generasi Bebas Stunting.</h1>
    
    <p class="hero-subtitle">
        Platform berbasis komunitas yang menghubungkan ibu hamil berisiko Kurang Energi Kronis (KEK) dengan paket pangan bergizi riil melalui titik drop-point resmi Posyandu dan Bidan Desa tanpa perantara uang tunai.
    </p>

    <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; margin-bottom: 28px;">
        <a href="index.php?page=explore" class="btn-lime" style="font-size: 1rem; padding: 13px 30px;">
            Jelajahi Kebutuhan Pangan Gizi →
        </a>
        <a href="index.php?page=register" class="btn-ghost-clean" style="font-size: 1rem; padding: 13px 26px;">
            Ajukan Kebutuhan Ibu Hamil
        </a>
    </div>

    <div style="display: flex; justify-content: center; align-items: center; gap: 20px; font-size: 0.82rem; color: var(--text-muted); flex-wrap: wrap;">
        <span style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            Validasi Medis Buku KIA
        </span>
        <span>•</span>
        <span style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            Drop-Point Posyandu Terdaftar
        </span>
        <span>•</span>
        <span style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            100% Pangan Bergizi Riil
        </span>
    </div>

    <!-- PURE CSS DIMENSIONAL DEVICE MOCKUP FRAME (SIMULASI APPS NURTURA) -->
    <div class="device-mockup-frame" data-parallax="-0.04">
        <div class="device-mockup-topbar">
            <div class="device-dots">
                <div class="device-dot" style="background: #ef4444;"></div>
                <div class="device-dot" style="background: #f59e0b;"></div>
                <div class="device-dot" style="background: #10b981;"></div>
            </div>
            <div class="device-address-bar">
                nurtura.posyandu.id/katalog-gizi-resmi
            </div>
            <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 600;">Sistem Drop-Point Terverifikasi</span>
        </div>
        <div class="device-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; align-items: stretch;">
                <!-- Kolom 1: Kartu Metrik Antropometri LILA -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; text-align: left;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; color: #64748b;">Antropometri Ibu Hamil</span>
                            <span class="status-kek-text" style="font-size: 0.78rem;">Risiko KEK (&lt; 23.5 cm)</span>
                        </div>
                        <div style="display: flex; align-items: baseline; gap: 6px; margin: 6px 0;">
                            <span style="font-size: 2.3rem; font-weight: 800; color: var(--text-main); line-height: 1;">21.2</span>
                            <span style="font-size: 0.92rem; font-weight: 600; color: #64748b;">cm LILA</span>
                        </div>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 4px 0 14px 0; line-height: 1.45;">
                            Ukuran lingkar lengan atas di bawah batas aman Kemenkes. Memerlukan paket pangan tambahan tinggi protein hewani dan asam folat.
                        </p>
                    </div>
                    <div style="display: flex; gap: 12px; font-size: 0.78rem; color: #64748b; font-weight: 600; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                        <span>Trimester 2 (Minggu ke-24)</span>
                        <span>•</span>
                        <span style="color: #0284c7;">Validasi KIA Terverifikasi</span>
                    </div>
                </div>

                <!-- Kolom 2: Kartu Paket Pangan Bergizi & Drop-Point -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 18px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; text-align: left;">
                    <div>
                        <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; color: #0284c7; display: block; margin-bottom: 6px;">
                            Paket Pangan Siap Salur
                        </span>
                        <div style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Paket Telur & Susu Prenatal KEK
                        </div>
                        <div style="font-size: 0.84rem; color: #334155; line-height: 1.55;">
                            • Telur Ayam 2 kg (Protein hewani anti-stunting)<br>
                            • Susu Ibu Hamil 2 Kotak (Kalsium & Asam Folat)<br>
                            • Daging Ayam 1 kg & Sayur Bayam Segar
                        </div>
                    </div>
                    <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem;">
                        <span style="color: #64748b;">Titik Drop-Point Resmi:</span>
                        <strong style="color: var(--text-main);">Posyandu Melati 01</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. WEARABLE PARTNER ROW (JARINGAN FASKES MITRA BEVEL STYLE) -->
<div style="text-align: center; margin: 20px 0 60px 0;">
    <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); display: block; margin-bottom: 18px;">
        Terintegrasi dengan Jaringan Layanan Kesehatan Primer
    </span>
    <div style="display: flex; justify-content: center; align-items: center; gap: 32px; flex-wrap: wrap; opacity: 0.85;">
        <span style="font-size: 0.92rem; font-weight: 700; color: var(--text-main); letter-spacing: -0.01em;">Posyandu Melati & Mawar</span>
        <span style="color: #cbd5e1;">·</span>
        <span style="font-size: 0.92rem; font-weight: 700; color: var(--text-main); letter-spacing: -0.01em;">Puskesmas Pembantu</span>
        <span style="color: #cbd5e1;">·</span>
        <span style="font-size: 0.92rem; font-weight: 700; color: var(--text-main); letter-spacing: -0.01em;">Ikatan Bidan Indonesia (IBI)</span>
        <span style="color: #cbd5e1;">·</span>
        <span style="font-size: 0.92rem; font-weight: 700; color: var(--text-main); letter-spacing: -0.01em;">Kader Kesehatan Desa</span>
    </div>
</div>

<!-- 3. ALUR PENYALURAN 3 LANGKAH (CLEAN CARDS) -->
<div style="margin-bottom: 64px;">
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 6px;">
            Mekanisme Drop-Point Posyandu
        </div>
        <h2 style="font-size: 2.1rem; font-weight: 700; color: var(--text-main); margin-top: 4px; letter-spacing: -0.02em;">
            Alur Penyaluran Pangan Bergizi
        </h2>
        <p style="color: var(--text-muted); font-size: 1rem; max-width: 620px; margin: 8px auto 0 auto; line-height: 1.55;">
            Transparansi penuh dari pemeriksaan kehamilan hingga serah terima di posyandu tanpa perantara uang tunai.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div class="card-clean" data-motion="reveal" data-delay="0">
            <span style="font-size: 0.76rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 12px;">
                Langkah 01
            </span>
            <h3 style="font-size: 1.3rem; color: var(--text-main); margin-bottom: 10px; font-weight: 700; letter-spacing: -0.015em;">
                Pemeriksaan & Pengajuan KIA
            </h3>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Ibu hamil memeriksa ukuran LILA di Posyandu. Jika di bawah 23,5 cm (indikasi risiko KEK), ibu hamil mengajukan paket gizi dengan melampirkan lembar catatan Buku KIA untuk diverifikasi oleh admin medis.
            </p>
        </div>

        <div class="card-clean" data-motion="reveal" data-delay="90">
            <span style="font-size: 0.76rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 12px;">
                Langkah 02
            </span>
            <h3 style="font-size: 1.3rem; color: var(--text-main); margin-bottom: 10px; font-weight: 700; letter-spacing: -0.015em;">
                Komitmen Donatur di Posyandu
            </h3>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Donatur memilih paket pangan riil (telur, susu, protein hewani) dan mengunci komitmen 48 jam untuk menyerahkan paket langsung ke titik Posyandu atau Bidan Desa mitra resmi.
            </p>
        </div>

        <div class="card-clean" data-motion="reveal" data-delay="180">
            <span style="font-size: 0.76rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 12px;">
                Langkah 03
            </span>
            <h3 style="font-size: 1.3rem; color: var(--text-main); margin-bottom: 10px; font-weight: 700; letter-spacing: -0.015em;">
                Penyaluran Saat Kontrol Medis
            </h3>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Ibu hamil mengambil paket saat jadwal kontrol kehamilan rutin di posyandu. Serah terima dikonfirmasi transparan tanpa mengekspos alamat domisili pribadi ke ruang publik.
            </p>
        </div>
    </div>
</div>

<!-- 3B. ETALASE INTERAKTIF FULL-BLEED: 8 FAKTA MEDIS LAPANGAN DOKTER DI SELURUH DUNIA -->
<div class="clinical-showcase-section" data-motion="reveal" data-delay="40">
    <div style="text-align: center; max-width: 720px; margin: 0 auto 12px auto;">
        <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 6px;">
            Data & Fakta Lapangan Klinis Global
        </div>
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--text-main); margin: 0 0 8px 0; letter-spacing: -0.02em;">
            Mengapa Intervensi Gizi Ibu Hamil Sangat Krusial?
        </h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0; line-height: 1.55;">
            Temuan lapangan dokter kandungan, dokter anak, dan ahli gizi di seluruh dunia (WHO, UNICEF, The Lancet, Kemenkes RI). Arahkan kursor dan gulir untuk menggeser, atau klik kartu untuk detail klinis.
        </p>
    </div>

    <div class="clinical-showcase-fullbleed">
        <div class="clinical-marquee-viewport" id="clinical-marquee-viewport">
            <div class="clinical-marquee-track" id="clinical-marquee-track">
                <!-- Kartu 4:3 dirender & diduplikasi untuk seamless infinite auto-scroll -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Fakta Klinis Global -->
<div id="clinical-fact-modal" class="nurtura-modal-backdrop" onclick="closeClinicalFactModal()" role="dialog" aria-modal="true" style="display: none;">
    <div class="nurtura-modal-card" style="max-width: 560px;" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
            <div>
                <div id="cf-modal-category" style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 4px;"></div>
                <h3 id="cf-modal-title" style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.3;"></h3>
            </div>
            <button type="button" onclick="closeClinicalFactModal()" aria-label="Tutup" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 50%; width: 32px; height: 32px; font-size: 1.1rem; color: #64748b; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">&times;</button>
        </div>

        <div id="cf-modal-metric" style="font-size: 2rem; font-weight: 800; color: #0284c7; margin: 6px 0 14px 0;"></div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; margin-bottom: 14px;">
            <div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Fakta Lapangan Dokter Global</div>
            <p id="cf-modal-fact" style="font-size: 0.92rem; color: #0f172a; line-height: 1.6; margin: 0;"></p>
        </div>

        <div style="background: #f0f9ff; border-left: 3px solid #0284c7; border-radius: 0 12px 12px 0; padding: 14px 16px; margin-bottom: 16px;">
            <div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0284c7; margin-bottom: 4px;">Kaitan dengan Paket Pangan Nurtura</div>
            <p id="cf-modal-nurtura" style="font-size: 0.88rem; color: #0c4a6e; line-height: 1.55; margin: 0;"></p>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <span id="cf-modal-source" style="font-size: 0.78rem; font-weight: 600; color: #64748b;"></span>
            <a href="index.php?page=explore" class="btn-lime" style="padding: 9px 20px; font-size: 0.88rem;">Lihat Katalog Pangan →</a>
        </div>
    </div>
</div>

<script>
const clinicalFactsData = [
    {
        category: 'Hematologi Kehamilan',
        metric: '37% Ibu Hamil',
        title: 'Anemia Defisiensi Besi Global',
        summary: 'Lebih dari sepertiga ibu hamil di dunia mengalami anemia akibat kurangnya asupan zat besi bioavailable.',
        fact: 'Menurut data lapangan WHO, sekitar 37% ibu hamil secara global (dan lebih tinggi di negara berkembang) mengalami anemia. Dokter kandungan sering mendapati kelelahan ekstrem, risiko perdarahan saat persalinan, serta pasokan oksigen ke plasenta yang terganggu sehingga memicu bayi lahir dengan berat badan rendah (BBLR).',
        nurtura: 'Paket pangan Nurtura memprioritaskan sumber zat besi heme (daging ayam, hati, ikan, telur) dan sayuran hijau yang penyerapannya jauh lebih efektif dibanding sekadar karbohidrat.',
        source: 'Sumber: WHO Global Health Observatory'
    },
    {
        category: 'Antropometri Klinis',
        metric: 'LILA < 23,5 cm',
        title: 'Indikator Cepat Risiko KEK & Prematur',
        summary: 'Lingkar Lengan Atas (MUAC/LILA) dipakai dokter di seluruh dunia sebagai prediktor cepat malnutrisi ibu.',
        fact: 'Di fasilitas kesehatan primer global, dokter dan bidan mengandalkan pengukuran LILA (Mid-Upper Arm Circumference) karena tidak terpengaruh edema kehamilan. Ibu dengan LILA < 23,5 cm mengalami Kekurangan Energi Kronis (KEK) yang berkorelasi langsung dengan kelahiran prematur dan hambatan tumbuh kembang janin.',
        nurtura: 'Nurtura menggunakan ambang batas LILA < 23,5 cm dari lembar resmi Buku KIA sebagai syarat validasi objektif agar bantuan tepat sasaran.',
        source: 'Sumber: Kemenkes RI & WHO Antenatal Standards'
    },
    {
        category: 'Neurologi Janin',
        metric: '80% Volume Otak',
        title: 'Jendela Emas 1.000 Hari Pertama',
        summary: 'Pertumbuhan struktur otak manusia paling cepat terjadi sejak dalam kandungan hingga usia 2 tahun.',
        fact: 'Studi klinis The Lancet membuktikan 80% perkembangan volume dan sinaps otak anak terjadi pada 1.000 Hari Pertama Kehidupan (270 hari di kandungan + 730 hari pasca lahir). Kekurangan energi dan protein pada trimester 2 dan 3 meninggalkan dampak kognitif permanen yang sulit dikejar di usia sekolah.',
        nurtura: 'Intervensi cepat di masa kehamilan melalui drop-point Posyandu memastikan nutrisi masuk tepat sebelum periode emas tertutup.',
        source: 'Sumber: The Lancet Maternal & Child Nutrition'
    },
    {
        category: 'Asam Amino Esensial',
        metric: '2–3× Risiko Stunting',
        title: 'Kesenjangan Protein Hewani Harian',
        summary: 'Pola makan tinggi karbohidrat tanpa protein hewani gagal menstimulasi hormon pertumbuhan janin.',
        fact: 'Dokter anak di berbagai negara menemukan bahwa ibu hamil dan balita yang hanya mengonsumsi sumber karbohidrat nabati tanpa asam amino esensial hewani (telur, susu, daging, ikan) memiliki risiko stunting 2 hingga 3 kali lebih tinggi. Protein hewani memicu jalur mTORC1 yang esensial untuk pemanjangan tulang.',
        nurtura: 'Setiap paket pangan Nurtura dirancang memuat kombinasi protein hewani riil seperti telur ayam kampung/ras, susu prenatal, dan daging ayam segar.',
        source: 'Sumber: UNICEF & FAO Nutrition Report'
    },
    {
        category: 'Pencegahan Kelainan Bawaan',
        metric: '>70% Pencegahan',
        title: 'Asam Folat & Tabung Saraf Janin',
        summary: 'Defisiensi folat di awal kehamilan memicu cacat tabung saraf (Neural Tube Defects) yang fatal.',
        fact: 'Di seluruh dunia, dokter spesialis obgyn menekankan kecukupan asam folat (Vitamin B9) sebelum dan selama kehamilan. Kekurangan folat meningkatkan risiko spina bifida dan anensefali, sementara asupan folat yang adekuat dari pangan terfortifikasi dan sayuran hijau mencegah lebih dari 70% kasus kelainan tabung saraf.',
        nurtura: 'Komponen susu ibu hamil terfortifikasi dan sayuran hijau (bayam/brokoli) dalam katalog Nurtura membantu menutup defisit folat harian.',
        source: 'Sumber: WHO & CDC Birth Defects Surveillance'
    },
    {
        category: 'Keselamatan Ibu Hamil',
        metric: 'Preeklampsia',
        title: 'Peran Kalsium Menurunkan Risiko Hipertensi',
        summary: 'Kekurangan kalsium saat hamil memperbesar risiko tekanan darah tinggi berat (preeklampsia).',
        fact: 'Preeklampsia merupakan salah satu penyebab utama kematian ibu dan janin secara global. Pedoman WHO Antenatal Care mencatat bahwa populasi dengan asupan kalsium rendah memiliki insiden preeklampsia jauh lebih tinggi; pemenuhan kalsium dari susu dan pangan bergizi membantu menjaga fungsi pembuluh darah plasenta.',
        nurtura: 'Susu ibu hamil dan bahan pangan kaya kalsium menjadi komponen inti dalam paket bantuan pangan bergizi Nurtura.',
        source: 'Sumber: WHO Recommendations on Antenatal Care'
    },
    {
        category: 'Mikronutrien Terselubung',
        metric: 'Hidden Hunger',
        title: 'Kenyang Kalori Namun Lapar Zat Gizi Mikro',
        summary: 'Ibu hamil bisa tampak cukup makan nasi, namun janin mengalami kekurangan Zinc, Yodium, dan Vitamin B12.',
        fact: 'Para ahli gizi global menyebut fenomena ini sebagai "Hidden Hunger". Di lapangan, dokter kerap menjumpai ibu hamil dengan asupan kalori cukup dari pangan murah, namun defisiensi zinc dan vitamin B12 yang menyebabkan Intrauterine Growth Restriction (IUGR) atau janin tumbuh terhambat di dalam rahim.',
        nurtura: 'Bantuan tidak berupa uang tunai yang rawan dibelikan pangan rendah gizi, melainkan paket pangan padat mikronutrien yang terkurasi.',
        source: 'Sumber: FAO State of Food Security & Nutrition'
    },
    {
        category: 'Epidemiologi Lintas Generasi',
        metric: '< 2.500 Gram',
        title: 'Memutus Rantai Stunting Antargenerasi',
        summary: 'Ibu dengan KEK berisiko melahirkan bayi BBLR yang rentan mengulang siklus stunting pada generasi berikutnya.',
        fact: 'Riset epidemiologi global menunjukkan efek domino lintas generasi: ibu hamil yang mengalami kurang gizi kronis berisiko tinggi melahirkan bayi Berat Lahir Rendah (< 2.500 g). Tanpa intervensi nutrisi sejak dalam kandungan, anak perempuan yang lahir BBLR cenderung tumbuh pendek dan mengulangi risiko yang sama kelak.',
        nurtura: 'Pendampingan pangan langsung di Posyandu membantu memutus rantai malnutrisi ini dari titik paling hulu: masa kehamilan.',
        source: 'Sumber: The Lancet Child & Adolescent Health'
    }
];

document.addEventListener('DOMContentLoaded', function () {
    const viewport = document.getElementById('clinical-marquee-viewport');
    const track = document.getElementById('clinical-marquee-track');
    if (!viewport || !track) return;

    const buildCardHtml = (item, idx) => `
        <article class="clinical-fact-card" data-fact-idx="${idx}" onclick="openClinicalFactModal(${idx})" tabindex="0" role="button" aria-label="Baca detail ${item.title}">
            <div>
                <div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: #0284c7;">
                    ${item.category}
                </div>
                <div class="clinical-fact-metric">${item.metric}</div>
                <h3 style="font-size: 1.08rem; font-weight: 700; color: #0f172a; margin: 0 0 6px 0; line-height: 1.28;">
                    ${item.title}
                </h3>
                <p style="font-size: 0.84rem; color: #64748b; line-height: 1.48; margin: 0;">
                    ${item.summary}
                </p>
            </div>
            <div class="clinical-fact-source">
                <span>${item.source}</span>
                <span style="color: #0284c7; font-weight: 700;">Detail →</span>
            </div>
        </article>
    `;

    // Duplikasi 2x untuk loop tak terbatas yang mulus dari ujung ke ujung
    const singleSetHtml = clinicalFactsData.map((item, idx) => buildCardHtml(item, idx)).join('');
    track.innerHTML = singleSetHtml + singleSetHtml;

    const cards = Array.from(track.querySelectorAll('.clinical-fact-card'));
    const halfWidth = track.scrollWidth / 2;
    let offset = 0;
    let targetBoost = 0;
    const baseSpeed = 0.45; // Kecepatan lambat & nyaman dipandang mata

    // Scroll mouse saat hover -> geser ke samping (atas = kiri, bawah = kanan)
    viewport.addEventListener('wheel', (e) => {
        if (Math.abs(e.deltaY) > 0 || Math.abs(e.deltaX) > 0) {
            e.preventDefault();
            const delta = Math.abs(e.deltaY) >= Math.abs(e.deltaX) ? e.deltaY : e.deltaX;
            targetBoost += delta * 0.9;
        }
    }, { passive: false });

    function animateMarquee() {
        const modalOpen = document.getElementById('clinical-fact-modal')?.style.display === 'flex';
        if (!modalOpen) {
            offset += baseSpeed;
        }

        // Terapkan momentum wheel scroll yang halus
        if (Math.abs(targetBoost) > 0.05) {
            const step = targetBoost * 0.14;
            offset += step;
            targetBoost -= step;
        } else {
            targetBoost = 0;
        }

        // Loop seamless
        if (halfWidth > 0) {
            while (offset >= halfWidth) offset -= halfWidth;
            while (offset < 0) offset += halfWidth;
        }

        track.style.transform = `translate3d(${-offset.toFixed(2)}px, 0, 0)`;

        // Efek pembesaran di tengah (4:3 normal di pinggir -> 4:3 lebih besar di tengah)
        const vpRect = viewport.getBoundingClientRect();
        const vpCenter = vpRect.left + vpRect.width / 2;
        const maxDist = Math.max(360, vpRect.width * 0.48);

        cards.forEach(card => {
            const cRect = card.getBoundingClientRect();
            const cardCenter = cRect.left + cRect.width / 2;
            const dist = Math.abs(vpCenter - cardCenter);
            const norm = Math.min(1, dist / maxDist);
            const scale = 1.09 - norm * 0.17; // 1.09 di tengah -> 0.92 di pinggir
            card.style.transform = `scale(${scale.toFixed(3)})`;
            if (norm < 0.24) {
                card.classList.add('is-center-focus');
            } else {
                card.classList.remove('is-center-focus');
            }
        });

        requestAnimationFrame(animateMarquee);
    }

    requestAnimationFrame(animateMarquee);
});

function openClinicalFactModal(idx) {
    const item = clinicalFactsData[idx];
    if (!item) return;
    document.getElementById('cf-modal-category').textContent = item.category;
    document.getElementById('cf-modal-title').textContent = item.title;
    document.getElementById('cf-modal-metric').textContent = item.metric;
    document.getElementById('cf-modal-fact').textContent = item.fact;
    document.getElementById('cf-modal-nurtura').textContent = item.nurtura;
    document.getElementById('cf-modal-source').textContent = item.source;

    const modal = document.getElementById('clinical-fact-modal');
    if (modal) {
        modal.style.display = 'flex';
        requestAnimationFrame(() => modal.classList.add('is-open'));
    }
}

function closeClinicalFactModal() {
    const modal = document.getElementById('clinical-fact-modal');
    if (modal) {
        modal.classList.remove('is-open');
        setTimeout(() => { modal.style.display = 'none'; }, 180);
    }
}
</script>

<!-- 4. DATA STATISTIK NASIONAL & 3 PILAR INTEGRITAS (DRAWER PARALLAX STACK) -->
<div class="parallax-drawer-wrapper">
    <div class="parallax-drawer-top">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
            <div class="card-clean" style="padding: 24px; text-align: center;">
                <div style="font-size: 2.4rem; font-weight: 800; color: #e11d48; letter-spacing: -0.03em; line-height: 1;">
                    19,8%
                </div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 8px;">
                    Prevalensi Stunting Nasional (SSGI)
                </div>
            </div>
            <div class="card-clean" style="padding: 24px; text-align: center;">
                <div style="font-size: 2.4rem; font-weight: 800; color: #0284c7; letter-spacing: -0.03em; line-height: 1;">
                    &lt; 14%
                </div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 8px;">
                    Target Bebas Stunting Kemenkes
                </div>
            </div>
            <div class="card-clean" style="padding: 24px; text-align: center;">
                <div style="font-size: 2.4rem; font-weight: 800; color: #059669; letter-spacing: -0.03em; line-height: 1;">
                    270 Hari
                </div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 8px;">
                    Periode Emas Nutrisi Kehamilan
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-drawer-bottom">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div class="card-clean" style="padding: 28px;">
                <h4 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem; font-weight: 700;">Nol Pengelolaan Uang</h4>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; margin: 0;">
                    Nurtura bukan platform penggalangan dana tunai. Seluruh bantuan berwujud bahan pangan riil (telur, susu ibu hamil, kacang-kacangan) yang disalurkan langsung ke fasilitas kesehatan mitra.
                </p>
            </div>
            <div class="card-clean" style="padding: 28px;">
                <h4 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem; font-weight: 700;">Kerahasiaan Identitas Ibu Hamil</h4>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; margin: 0;">
                    Nama lengkap dan alamat domisili pribadi tidak pernah dipublikasikan. Paket dikirim ke titik drop-point resmi Posyandu atau Bidan Desa, menjaga martabat dan privasi ibu hamil.
                </p>
            </div>
            <div class="card-clean" style="padding: 28px;">
                <h4 style="color: var(--text-main); margin-bottom: 8px; font-size: 1.15rem; font-weight: 700;">Verifikasi Berbasis Data Medis</h4>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; margin: 0;">
                    Penetapan kelayakan penerima merujuk pada standar klinis Kemenkes: lembar catatan Buku KIA resmi dan ambang batas lingkar lengan atas (LILA &lt; 23,5 cm).
                </p>
            </div>
        </div>
    </div>
</div>

<!-- 5. TABEL KOMPARASI MODEL PENYALURAN (CLEAN TABLE) -->
<div style="margin-bottom: 64px;">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 6px;">
            Standar Akuntabilitas
        </div>
        <h2 style="font-size: 1.9rem; font-weight: 700; color: var(--text-main); margin-top: 4px; letter-spacing: -0.02em;">
            Perbandingan Model Penyaluran Bantuan
        </h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 620px; margin: 6px auto 0 auto;">
            Mengapa model drop-point posyandu lebih aman, transparan, dan berdampak langsung pada janin.
        </p>
    </div>

    <div class="comparison-wrapper" style="border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0; background: #ffffff;">
        <table class="comparison-table">
            <thead>
                <tr>
                    <th style="width: 25%; background: #f8fafc; color: var(--text-main);">Aspek Penyaluran</th>
                    <th style="width: 37.5%; background: #f8fafc; color: #64748b;">Platform Donasi Konvensional</th>
                    <th style="width: 37.5%; background: #f0f9ff; color: #0369a1;">Model Drop-Point Nurtura</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Bentuk Bantuan</strong></td>
                    <td style="color: #64748b;">Saldo uang tunai / dompet digital (rentan dialihkan untuk kebutuhan non-gizi)</td>
                    <td style="background: #f8fafc; color: var(--text-main); font-weight: 600;">100% paket pangan bergizi riil (telur, susu prenatal, protein hewani)</td>
                </tr>
                <tr>
                    <td><strong>Titik Penyaluran</strong></td>
                    <td style="color: #64748b;">Alamat rumah pribadi penerima (privasi rentan terekspos ke publik)</td>
                    <td style="background: #f8fafc; color: var(--text-main); font-weight: 600;">Fasilitas kesehatan resmi mitra (Posyandu & Puskesmas Pembantu)</td>
                </tr>
                <tr>
                    <td><strong>Validasi Kelayakan</strong></td>
                    <td style="color: #64748b;">Deskripsi subjektif atau foto bebas tanpa standarisasi klinis</td>
                    <td style="background: #f8fafc; color: var(--text-main); font-weight: 600;">Dokumen resmi Buku KIA Kemenkes dengan ambang batas LILA &lt; 23,5 cm</td>
                </tr>
                <tr>
                    <td><strong>Kepastian Donasi</strong></td>
                    <td style="color: #64748b;">Sering terjadi komitmen gantung tanpa batas waktu penyelesaian</td>
                    <td style="background: #f8fafc; color: var(--text-main); font-weight: 600;">Sistem batas waktu komitmen 48 jam dengan pelepasan otomatis (anti-ghosting)</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- 6. CALL TO ACTION PENUTUP (CLEAN SLATE & LIME ACCENT) -->
<div style="background: #0f172a; border-radius: 24px; padding: 48px 32px; text-align: center; color: #ffffff; margin-bottom: 24px; border: 1px solid #1e293b;">
    <div style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #c7f22b; margin-bottom: 8px;">
        Solidaritas Gizi Terpadu
    </div>
    <h3 style="font-size: 1.85rem; font-weight: 700; color: #ffffff; margin: 0 0 12px 0; letter-spacing: -0.02em;">
        Mulai Berperan dalam 1.000 Hari Pertama Kehidupan
    </h3>
    <p style="color: #94a3b8; max-width: 620px; margin: 0 auto 28px auto; font-size: 0.95rem; line-height: 1.6;">
        Nutrisi yang cukup selama 270 hari masa kehamilan adalah penentu utama pencegahan stunting permanen pada anak. Bergabunglah bersama posyandu mitra untuk menyalurkan paket pangan riil.
    </p>
    <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
        <a href="index.php?page=explore" class="btn-lime" style="font-size: 1rem; padding: 13px 30px;">
            Jelajahi Kebutuhan Sekarang →
        </a>
        <a href="index.php?page=register" class="btn-ghost-clean" style="color: #ffffff; border-color: rgba(255, 255, 255, 0.3); font-size: 1rem; padding: 13px 26px;">
            Daftar Sebagai Donatur / Ibu Hamil
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

