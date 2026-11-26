<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- 1. HERO 2-KOLOM + CLINICAL SNAPSHOT CARD (NURTURA CLINICAL CARE) -->
<section class="hero-clinical">
    <div class="hero-grid-2col">
        <div>
            <span class="hero-eyebrow">Gerakan 1.000 Hari Pertama Kehidupan · Standar Gizi Kemenkes</span>

            <h1>Penuhi Gizi Ibu Hamil, Wujudkan Generasi Bebas Stunting.</h1>

            <p class="hero-subtitle">
                Platform komunitas yang menghubungkan ibu hamil berisiko Kurang Energi Kronis (KEK) dengan paket pangan bergizi riil melalui titik drop-point resmi Posyandu dan Bidan Desa tanpa perantara uang tunai.
            </p>

            <div class="hero-cta-row">
                <a href="index.php?page=explore" class="btn-cerulean" style="padding: 0.75rem 1.625rem; font-size: 0.94rem;">
                    Jelajahi Kebutuhan Pangan Gizi →
                </a>
                <a href="index.php?page=register" class="btn-ghost-clean" style="padding: 0.75rem 1.5rem; font-size: 0.94rem;">
                    Ajukan Kebutuhan Ibu Hamil
                </a>
            </div>

            <div class="hero-trust-row">
                <span class="hero-trust-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Validasi Medis Buku KIA
                </span>
                <span class="hero-trust-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Drop-Point Posyandu Terdaftar
                </span>
                <span class="hero-trust-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    100% Pangan Bergizi Riil
                </span>
            </div>
        </div>

        <!-- Clinical Snapshot Card -->
        <aside class="clinical-snapshot-card" data-parallax="-0.03" aria-label="Ringkasan Standar Antropometri Ibu Hamil">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.625rem; flex-wrap: wrap; border-bottom: 0.0625rem solid var(--border-subtle); padding-bottom: 0.875rem;">
                <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-muted);">
                    Antropometri Ibu Hamil
                </span>
                <span class="status-kek-text">LILA 21,2 cm · Risiko KEK</span>
            </div>

            <div>
                <div style="display: flex; align-items: baseline; gap: 0.375rem;">
                    <span class="font-mono" style="font-size: clamp(1.9rem, 5vw, 2.3rem); font-weight: 700; color: var(--text-main); line-height: 1;">21,2</span>
                    <span style="font-size: 0.92rem; font-weight: 600; color: var(--text-muted);">cm</span>
                </div>
                <p style="font-size: 0.86rem; color: var(--text-muted); margin-top: 0.375rem; line-height: 1.5;">
                    Ambang batas aman Kemenkes RI minimal <strong style="color: var(--text-main);">23,5 cm</strong>. Indikasi di bawah batas membutuhkan intervensi protein hewani segera.
                </p>
            </div>

            <div class="inset-well">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 0.375rem;">
                    Paket Pangan Siap Salur
                </span>
                <div style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">
                    Paket Telur &amp; Susu Prenatal KEK
                </div>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.86rem; color: var(--text-muted); line-height: 1.6;">
                    <li>• Telur Ayam 2 kg (Protein hewani anti-stunting)</li>
                    <li>• Susu Ibu Hamil 2 Kotak (Kalsium &amp; Asam Folat)</li>
                    <li>• Daging Ayam 1 kg &amp; Sayur Bayam Segar</li>
                </ul>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.625rem; flex-wrap: wrap; border-top: 0.0625rem solid var(--border-subtle); padding-top: 0.75rem; font-size: 0.82rem;">
                <span style="color: var(--text-muted);">Drop-Point: <strong style="color: var(--text-main);">Posyandu Melati 01</strong></span>
                <span style="display: inline-flex; align-items: center; gap: 0.25rem; font-weight: 700; color: var(--botanical);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    Terverifikasi KIA
                </span>
            </div>
        </aside>
    </div>
</section>

<!-- 2. PARTNER STRIP FULL-WIDTH -->
<section class="partner-strip-full" aria-label="Jaringan Layanan Kesehatan Mitra">
    <div class="partner-strip-inner">
        <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">
            Terintegrasi Layanan Kesehatan Primer
        </span>
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1.5rem; font-size: 0.88rem; font-weight: 600; color: var(--text-main);">
            <span>Posyandu Melati &amp; Mawar</span>
            <span style="color: var(--outline-variant);">·</span>
            <span>Puskesmas Pembantu</span>
            <span style="color: var(--outline-variant);">·</span>
            <span>Ikatan Bidan Indonesia (IBI)</span>
            <span style="color: var(--outline-variant);">·</span>
            <span>Kader Kesehatan Desa</span>
        </div>
    </div>
</section>

<!-- 3. ALUR PENYALURAN 3 LANGKAH (ACCORDION OTOMATIS DI MOBILE) -->
<section style="margin-bottom: clamp(2rem, 5vw, 3.75rem);">
    <div style="margin-bottom: 1.5rem;">
        <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.375rem;">
            Mekanisme Drop-Point Posyandu
        </span>
        <h2 style="font-size: clamp(1.375rem, 4.5vw, 2.15rem); font-weight: 700; line-height: 1.2; margin-bottom: 0.5rem;">
            Alur Penyaluran Pangan Bergizi
        </h2>
        <p style="color: var(--text-muted); font-size: 0.96rem; max-width: 60ch; line-height: 1.55;">
            Transparansi penuh dari pemeriksaan kehamilan hingga serah terima di Posyandu tanpa perantara uang tunai.
        </p>
    </div>

    <div class="grid-3col">
        <details class="info-accordion-card" open data-mobile-collapse="true" data-mobile-default-open="true" data-motion="reveal" data-delay="0">
            <summary class="info-accordion-summary">
                <div>
                    <span class="font-mono" style="font-size: 0.76rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                        LANGKAH 01
                    </span>
                    <h3 style="font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.35;">
                        Pemeriksaan &amp; Pengajuan KIA
                    </h3>
                </div>
                <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </summary>
            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Ibu hamil memeriksa ukuran LILA di Posyandu. Jika di bawah 23,5 cm (indikasi risiko KEK), ibu hamil mengajukan paket gizi dengan melampirkan lembar catatan Buku KIA untuk diverifikasi admin medis.
            </p>
        </details>

        <details class="info-accordion-card" open data-mobile-collapse="true" data-motion="reveal" data-delay="80">
            <summary class="info-accordion-summary">
                <div>
                    <span class="font-mono" style="font-size: 0.76rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                        LANGKAH 02
                    </span>
                    <h3 style="font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.35;">
                        Komitmen Donatur di Posyandu
                    </h3>
                </div>
                <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </summary>
            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Donatur memilih paket pangan riil (telur, susu, protein hewani) dan mengunci komitmen 48 jam untuk menyerahkan paket langsung ke titik Posyandu atau Bidan Desa mitra resmi.
            </p>
        </details>

        <details class="info-accordion-card" open data-mobile-collapse="true" data-motion="reveal" data-delay="160">
            <summary class="info-accordion-summary">
                <div>
                    <span class="font-mono" style="font-size: 0.76rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                        LANGKAH 03
                    </span>
                    <h3 style="font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.35;">
                        Penyaluran Saat Kontrol Medis
                    </h3>
                </div>
                <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </summary>
            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Ibu hamil mengambil paket saat jadwal kontrol kehamilan rutin di Posyandu. Serah terima dikonfirmasi transparan tanpa mengekspos alamat domisili pribadi ke ruang publik.
            </p>
        </details>
    </div>
</section>

<!-- 4. ETALASE INTERAKTIF: DESKTOP MARQUEE 4:3 ↔ MOBILE CLINICAL ACCORDION -->
<section class="clinical-showcase-section" data-motion="reveal" data-delay="40">
    <div style="text-align: center; max-width: min(45rem, 100%); margin: 0 auto 0.625rem auto;">
        <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.375rem;">
            Data &amp; Fakta Lapangan Klinis Global
        </span>
        <h2 style="font-size: clamp(1.375rem, 4.5vw, 2.05rem); font-weight: 700; margin-bottom: 0.5rem; line-height: 1.2;">
            Mengapa Intervensi Gizi Ibu Hamil Sangat Krusial?
        </h2>
        <p style="color: var(--text-muted); font-size: 0.94rem; margin: 0; line-height: 1.55;">
            Temuan lapangan dokter kandungan, dokter anak, dan ahli gizi di seluruh dunia (WHO, UNICEF, The Lancet, Kemenkes RI). Pilih fakta untuk membaca detail klinis.
        </p>
    </div>

    <!-- Desktop View: Infinite Marquee 4:3 -->
    <div class="clinical-showcase-fullbleed">
        <div class="clinical-marquee-viewport" id="clinical-marquee-viewport">
            <div class="clinical-marquee-track" id="clinical-marquee-track">
                <!-- Kartu 4:3 dirender & diduplikasi untuk seamless infinite auto-scroll -->
            </div>
        </div>
    </div>

    <!-- Mobile View (<= 48rem): Collapsible Clinical Accordion -->
    <div class="clinical-mobile-accordion" id="clinical-mobile-accordion" aria-label="Daftar Akordion Fakta Klinis Global"></div>
</section>

<!-- Modal / Bottom-Sheet Detail Fakta Klinis Global -->
<div id="clinical-fact-modal" class="nurtura-modal-backdrop" onclick="closeClinicalFactModal()" role="dialog" aria-modal="true" style="display: none;">
    <div class="nurtura-modal-card" style="max-width: min(35rem, 100%);" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
            <div>
                <div id="cf-modal-category" style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); margin-bottom: 0.25rem;"></div>
                <h3 id="cf-modal-title" style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;"></h3>
            </div>
            <button type="button" onclick="closeClinicalFactModal()" aria-label="Tutup detail klinis" class="modal-close-circle">&times;</button>
        </div>

        <div id="cf-modal-metric" class="font-mono" style="font-size: clamp(1.5rem, 5vw, 1.85rem); font-weight: 700; color: var(--primary); margin: 0.375rem 0 0.875rem 0;"></div>

        <div class="inset-well" style="margin-bottom: 0.875rem;">
            <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.375rem;">Fakta Lapangan Dokter Global</div>
            <p id="cf-modal-fact" style="font-size: 0.92rem; color: var(--text-main); line-height: 1.6; margin: 0;"></p>
        </div>

        <div style="background: var(--surface-low); border-left: 0.1875rem solid var(--primary); border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.875rem 1rem; margin-bottom: 1.125rem;">
            <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--primary); margin-bottom: 0.25rem;">Kaitan dengan Paket Pangan Nurtura</div>
            <p id="cf-modal-nurtura" style="font-size: 0.88rem; color: var(--primary-dark); line-height: 1.55; margin: 0;"></p>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; padding-top: 0.75rem; border-top: 0.0625rem solid var(--border-subtle);">
            <span id="cf-modal-source" style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted);"></span>
            <a href="index.php?page=explore" class="btn-cerulean btn-sm" style="padding: 0.5625rem 1.25rem;">Lihat Katalog Pangan →</a>
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
    // Render Mobile Clinical Accordion (<= 48rem)
    const mobileAccordion = document.getElementById('clinical-mobile-accordion');
    if (mobileAccordion) {
        mobileAccordion.innerHTML = clinicalFactsData.map((item, idx) => `
            <details class="clinical-accordion-item" ${idx === 0 ? 'open' : ''}>
                <summary>
                    <div style="display: flex; flex-direction: column; gap: 0.2rem; text-align: left;">
                        <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: var(--primary);">
                            ${item.category} · <span class="font-mono">${item.metric}</span>
                        </span>
                        <span style="font-size: 0.98rem; font-weight: 700; color: var(--text-main); line-height: 1.3;">
                            ${item.title}
                        </span>
                    </div>
                    <svg class="clinical-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <div class="clinical-accordion-body">
                    <p style="font-size: 0.88rem; color: var(--text-main); line-height: 1.55; margin: 0;">${item.fact}</p>
                    <div style="background: var(--surface-low); border-left: 0.1875rem solid var(--primary); padding: 0.625rem 0.75rem; border-radius: 0 var(--radius-sm) var(--radius-sm) 0; font-size: 0.84rem; color: var(--primary-dark);">
                        <strong>Kaitan Nurtura:</strong> ${item.nurtura}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.76rem; color: var(--text-muted);">
                        <span>${item.source}</span>
                        <button type="button" onclick="openClinicalFactModal(${idx})" style="background: none; border: none; padding: 0; font-size: 0.82rem; font-weight: 700; color: var(--primary); cursor: pointer;">
                            Buka Ringkasan →
                        </button>
                    </div>
                </div>
            </details>
        `).join('');
    }

    // Desktop Marquee Renderer & Animator
    const viewport = document.getElementById('clinical-marquee-viewport');
    const track = document.getElementById('clinical-marquee-track');
    if (!viewport || !track) return;

    const buildCardHtml = (item, idx) => `
        <article class="clinical-fact-card" data-fact-idx="${idx}" onclick="openClinicalFactModal(${idx})" tabindex="0" role="button" aria-label="Baca detail ${item.title}">
            <div>
                <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary);">
                    ${item.category}
                </div>
                <div class="clinical-fact-metric">${item.metric}</div>
                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.375rem 0; line-height: 1.3;">
                    ${item.title}
                </h3>
                <p style="font-size: 0.84rem; color: var(--text-muted); line-height: 1.48; margin: 0;">
                    ${item.summary}
                </p>
            </div>
            <div class="clinical-fact-source">
                <span>${item.source}</span>
                <span style="color: var(--primary); font-weight: 700;">Detail →</span>
            </div>
        </article>
    `;

    const singleSetHtml = clinicalFactsData.map((item, idx) => buildCardHtml(item, idx)).join('');
    track.innerHTML = singleSetHtml + singleSetHtml;

    const cards = Array.from(track.querySelectorAll('.clinical-fact-card'));
    let halfWidth = track.scrollWidth / 2;
    let offset = 0;
    let targetBoost = 0;
    const baseSpeed = 0.45;
    const mobileQuery = window.matchMedia('(max-width: 48rem)');

    viewport.addEventListener('wheel', (e) => {
        if (mobileQuery.matches) return;
        if (Math.abs(e.deltaY) > 0 || Math.abs(e.deltaX) > 0) {
            e.preventDefault();
            const delta = Math.abs(e.deltaY) >= Math.abs(e.deltaX) ? e.deltaY : e.deltaX;
            targetBoost += delta * 0.9;
        }
    }, { passive: false });

    function animateMarquee() {
        if (!mobileQuery.matches) {
            if (!halfWidth) halfWidth = track.scrollWidth / 2;
            const modalOpen = document.getElementById('clinical-fact-modal')?.style.display === 'flex';
            if (!modalOpen) {
                offset += baseSpeed;
            }

            if (Math.abs(targetBoost) > 0.05) {
                const step = targetBoost * 0.14;
                offset += step;
                targetBoost -= step;
            } else {
                targetBoost = 0;
            }

            if (halfWidth > 0) {
                while (offset >= halfWidth) offset -= halfWidth;
                while (offset < 0) offset += halfWidth;
            }

            track.style.transform = `translate3d(${-offset.toFixed(2)}px, 0, 0)`;

            const vpRect = viewport.getBoundingClientRect();
            const vpCenter = vpRect.left + vpRect.width / 2;
            const maxDist = Math.max(360, vpRect.width * 0.48);

            cards.forEach(card => {
                const cRect = card.getBoundingClientRect();
                const cardCenter = cRect.left + cRect.width / 2;
                const dist = Math.abs(vpCenter - cardCenter);
                const norm = Math.min(1, dist / maxDist);
                const scale = 1.08 - norm * 0.16;
                card.style.transform = `scale(${scale.toFixed(3)})`;
                if (norm < 0.24) {
                    card.classList.add('is-center-focus');
                } else {
                    card.classList.remove('is-center-focus');
                }
            });
        }

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

<!-- 5. DATA STATISTIK NASIONAL & 3 PILAR INTEGRITAS (DRAWER PARALLAX DESKTOP / ACCORDION MOBILE) -->
<section class="parallax-drawer-wrapper" aria-label="Dampak Nasional & Prinsip Akuntabilitas">
    <div class="parallax-drawer-top">
        <div class="grid-3col">
            <div class="card-clean" style="text-align: center; padding: clamp(1rem, 2.5vw, 1.5rem);">
                <div class="font-mono" style="font-size: clamp(1.75rem, 5vw, 2.3rem); font-weight: 700; color: var(--danger); line-height: 1;">
                    19,8%
                </div>
                <div style="font-size: 0.84rem; font-weight: 600; color: var(--text-muted); margin-top: 0.5rem;">
                    Prevalensi Stunting Nasional (SSGI)
                </div>
            </div>
            <div class="card-clean" style="text-align: center; padding: clamp(1rem, 2.5vw, 1.5rem);">
                <div class="font-mono" style="font-size: clamp(1.75rem, 5vw, 2.3rem); font-weight: 700; color: var(--primary); line-height: 1;">
                    &lt; 14%
                </div>
                <div style="font-size: 0.84rem; font-weight: 600; color: var(--text-muted); margin-top: 0.5rem;">
                    Target Bebas Stunting Kemenkes
                </div>
            </div>
            <div class="card-clean" style="text-align: center; padding: clamp(1rem, 2.5vw, 1.5rem);">
                <div class="font-mono" style="font-size: clamp(1.75rem, 5vw, 2.3rem); font-weight: 700; color: var(--botanical); line-height: 1;">
                    270 Hari
                </div>
                <div style="font-size: 0.84rem; font-weight: 600; color: var(--text-muted); margin-top: 0.5rem;">
                    Periode Emas Nutrisi Kehamilan
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-drawer-bottom">
        <div class="grid-3col">
            <details class="info-accordion-card" open data-mobile-collapse="true" data-mobile-default-open="true">
                <summary class="info-accordion-summary">
                    <h4 style="color: var(--text-main); margin: 0; font-size: 1.05rem; font-weight: 700;">Nol Pengelolaan Uang</h4>
                    <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin: 0;">
                    Nurtura bukan platform penggalangan dana tunai. Seluruh bantuan berwujud bahan pangan riil (telur, susu ibu hamil, kacang-kacangan) yang disalurkan langsung ke fasilitas kesehatan mitra.
                </p>
            </details>

            <details class="info-accordion-card" open data-mobile-collapse="true">
                <summary class="info-accordion-summary">
                    <h4 style="color: var(--text-main); margin: 0; font-size: 1.05rem; font-weight: 700;">Kerahasiaan Identitas Ibu Hamil</h4>
                    <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin: 0;">
                    Nama lengkap dan alamat domisili pribadi tidak pernah dipublikasikan. Paket dikirim ke titik drop-point resmi Posyandu atau Bidan Desa, menjaga martabat dan privasi ibu hamil.
                </p>
            </details>

            <details class="info-accordion-card" open data-mobile-collapse="true">
                <summary class="info-accordion-summary">
                    <h4 style="color: var(--text-main); margin: 0; font-size: 1.05rem; font-weight: 700;">Verifikasi Berbasis Data Medis</h4>
                    <svg class="info-accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin: 0;">
                    Penetapan kelayakan penerima merujuk pada standar klinis Kemenkes: lembar catatan Buku KIA resmi dan ambang batas lingkar lengan atas (LILA &lt; 23,5 cm).
                </p>
            </details>
        </div>
    </div>
</section>

<!-- 6. TABEL KOMPARASI MODEL PENYALURAN (STACKED CARDS DI MOBILE) -->
<section style="margin-bottom: clamp(2rem, 5vw, 3.5rem);">
    <div style="margin-bottom: 1.25rem;">
        <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.375rem;">
            Standar Akuntabilitas
        </span>
        <h2 style="font-size: clamp(1.375rem, 4.5vw, 1.95rem); font-weight: 700; margin-bottom: 0.375rem;">
            Perbandingan Model Penyaluran Bantuan
        </h2>
        <p style="color: var(--text-muted); font-size: 0.94rem; max-width: 60ch;">
            Mengapa model drop-point Posyandu lebih aman, transparan, dan berdampak langsung pada janin.
        </p>
    </div>

    <div class="comparison-wrapper">
        <table class="comparison-table">
            <thead>
                <tr>
                    <th style="width: 24%;">Aspek Penyaluran</th>
                    <th style="width: 38%; color: var(--text-muted);">Platform Donasi Konvensional</th>
                    <th style="width: 38%; color: var(--primary);">Model Drop-Point Nurtura</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Aspek Penyaluran"><strong style="color: var(--text-main);">Bentuk Bantuan</strong></td>
                    <td data-label="Platform Konvensional">Saldo uang tunai / dompet digital (rentan dialihkan untuk kebutuhan non-gizi)</td>
                    <td data-label="Model Drop-Point Nurtura" style="color: var(--text-main); font-weight: 500;">100% paket pangan bergizi riil (telur, susu prenatal, protein hewani)</td>
                </tr>
                <tr>
                    <td data-label="Aspek Penyaluran"><strong style="color: var(--text-main);">Titik Penyaluran</strong></td>
                    <td data-label="Platform Konvensional">Alamat rumah pribadi penerima (privasi rentan terekspos ke publik)</td>
                    <td data-label="Model Drop-Point Nurtura" style="color: var(--text-main); font-weight: 500;">Fasilitas kesehatan resmi mitra (Posyandu &amp; Puskesmas Pembantu)</td>
                </tr>
                <tr>
                    <td data-label="Aspek Penyaluran"><strong style="color: var(--text-main);">Validasi Kelayakan</strong></td>
                    <td data-label="Platform Konvensional">Deskripsi subjektif atau foto bebas tanpa standarisasi klinis</td>
                    <td data-label="Model Drop-Point Nurtura" style="color: var(--text-main); font-weight: 500;">Dokumen resmi Buku KIA Kemenkes dengan ambang batas LILA &lt; 23,5 cm</td>
                </tr>
                <tr>
                    <td data-label="Aspek Penyaluran"><strong style="color: var(--text-main);">Kepastian Donasi</strong></td>
                    <td data-label="Platform Konvensional">Sering terjadi komitmen gantung tanpa batas waktu penyelesaian</td>
                    <td data-label="Model Drop-Point Nurtura" style="color: var(--text-main); font-weight: 500;">Sistem batas waktu komitmen 48 jam dengan pelepasan otomatis (anti-ghosting)</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<!-- 7. COHESIVE OCEAN CERULEAN CALL TO ACTION -->
<section class="card-cerulean" style="padding: clamp(1.5rem, 4vw, 2.5rem) clamp(1.25rem, 3.5vw, 2.25rem); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem; margin-bottom: 1.25rem;">
    <div style="max-width: 58ch;">
        <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--primary-container); display: block; margin-bottom: 0.5rem;">
            Solidaritas Gizi Terpadu
        </span>
        <h2 style="font-family: var(--font-display); font-size: clamp(1.375rem, 4vw, 1.9rem); font-weight: 700; color: var(--on-primary); margin: 0 0 0.625rem 0; line-height: 1.25;">
            Mulai Berperan dalam 1.000 Hari Pertama Kehidupan
        </h2>
        <p style="color: var(--on-primary); opacity: 0.92; font-size: 0.94rem; line-height: 1.6; margin: 0;">
            Nutrisi yang cukup selama 270 hari masa kehamilan adalah penentu utama pencegahan stunting permanen. Bergabunglah bersama Posyandu mitra untuk menyalurkan paket pangan riil.
        </p>
    </div>
    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem; width: 100%; max-width: max-content;">
        <a href="index.php?page=explore" class="btn-white">
            Jelajahi Kebutuhan Sekarang
        </a>
        <a href="index.php?page=register" class="btn-cerulean-outline">
            Daftar Sebagai Donatur / Ibu Hamil
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
