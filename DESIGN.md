# DESIGN.md — Nurtura Design System & UI/UX Specification

> **Platform:** Nurtura — Dukungan Gizi Ibu Hamil Berbasis Komunitas & Posyandu Drop-Point  
> **Arsitektur Visual:** *Clean Medical Cyan & Lime Craft System* (Putih Polos, Hijau Lime, Ice Cyan)  
> **Kepatuhan PRD:** 100% *Offline-Ready* (tanpa CDN/font eksternal/framework CSS eksternal), *Zero Raw Emoji*, *Zero AI-Slop Floating Pills*, dan *Zero PII Leakage*.

---

## 1. Identitas Visual & Palet Warna

Sistem warna Nurtura menjaga suasana tenang, medis, dan terpercaya tanpa warna dekoratif berlebihan:

| Peran Warna | Token CSS (`style.css`) | Hex Code | Penggunaan Utama |
| :--- | :--- | :--- | :--- |
| **Kanvas Latar Belakang** | `--bg-page` | `#f0f9ff` | Latar belakang utama seluruh halaman (*Ice Cyan Pastel*) |
| **Permukaan Kartu & Navbar** | `--bg-card` | `#ffffff` | Kartu konten (`.card-clean`), navbar (`.navbar-clean`), footer, modal |
| **Aksi Utama (CTA)** | `--accent-cta` | `#C7F22B` | Tombol `.btn-lime`, `.btn-primary` dengan teks `#0f172a` |
| **Hover Aksi Utama** | `--accent-cta-hover` | `#b3df15` | State hover tombol Lime |
| **Aksen Medis & Tautan** | `--primary` | `#0284c7` | *Section kicker*, ikon SVG, link aktif, fokus input, metrik klinis |
| **Aksen Medis Gelap** | `--primary-dark` | `#0369a1` | Teks aksen pada latar cyan terang (`#e0f2fe`) |
| **Teks Utama** | `--text-main` | `#0f172a` | Heading `h1–h4`, label form, angka metrik utama |
| **Teks Sekunder / Deskripsi** | `--text-muted` | `#64748b` | Paragraf isi, metadata wilayah, sumber riset medis |
| **Garis Tepi (Hairline Border)** | `--border-color` | `#e2e8f0` | Border kartu, tabel komparasi, divider header/footer |
| **Status Klinis KEK (< 23,5 cm)** | `--danger` / `.status-kek-text` | `#ef4444` / `#b91c1c` | Indikator risiko Kekurangan Energi Kronis (teks bersih tanpa pil) |
| **Status Klinis Normal** | `--success` / `.status-normal-text` | `#15803d` | Indikator LILA aman (≥ 23,5 cm) & status selesai |

---

## 2. Tipografi & Font yang Digunakan

Untuk menjamin kecepatan *offline* sesuai PRD praktikum, Nurtura menggunakan **Native System Font Stack** tanpa pemanggilan Google Fonts/CDN:

- **Font Utama (UI & Heading):**
  ```css
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  ```
  - Di **Windows**: dirender otomatis sebagai **Segoe UI**.
  - Di **macOS / iOS**: dirender sebagai **San Francisco (SF Pro)**.
  - Di **Android / Linux**: dirender sebagai **Roboto**.
  - *(Referensi impor Figma: gunakan **Inter** atau **Roboto** / **Segoe UI** dengan bobot `Regular 400`, `SemiBold 600`, `Bold 700`, dan `ExtraBold 800`).*
- **Font Monospace (Address Bar Mockup):**
  ```css
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  ```
- **Skala Tipografi:**
  - Hero Headline (`h1`): `clamp(2.2rem, 4.2vw, 3.4rem)`, `font-weight: 800`, `line-height: 1.12`, `letter-spacing: -0.025em`
  - Section Heading (`h2`): `1.9rem – 2.1rem`, `font-weight: 700`
  - Card Title (`h3`): `1.12rem – 1.35rem`, `font-weight: 700`
  - Section Kicker (pengganti pill badge): `0.74rem – 0.8rem`, `font-weight: 700–800`, `text-transform: uppercase`, `letter-spacing: 0.08em`, `#0284c7`
  - Body Copy: `0.92rem – 0.96rem`, `line-height: 1.6`

---

## 3. Logo & Aset Ikonografi

- **Konsep Resmi Logo Terpilih (`14A v1`):** Dua figur dewasa melengkung melindungi anak dengan tangan terangkat gembira di tengah dalam palet *Clinical Care Blue* (**#19496B** *Deep Slate* & **#376386** *Ocean Cerulean*).
- **File Logo Ekspor Master (Vector SVG):**
  - Ikon Utama (*Primary Mark*): [nurtura-icon.svg](file:///c:/utee/BreakdownPRD/docs/design/assets/nurtura-icon.svg)
  - Logo Horizontal Lengkap (*Icon + Wordmark*): [nurtura-logo.svg](file:///c:/utee/BreakdownPRD/docs/design/assets/nurtura-logo.svg)
  - Favicon Adaptif Web (*Dark/Light Media Query*): [nurtura-favicon.svg](file:///c:/utee/BreakdownPRD/public/assets/brand/nurtura-favicon.svg)
- **Paket Lengkap Semua Platform (`docs/design/assets/brand-kit/`):**
  - **Icon Marks:** `01_mark_color.svg`, `02_mark_mono_dark.svg`, `03_mark_mono_white.svg`, `04_mark_inverted_dark_bg.svg`
  - **Horizontal & Stacked Lockups:** `05_lockup_horizontal_color.svg`, `06_lockup_horizontal_white.svg`, `07_lockup_stacked_color.svg`, `08_lockup_stacked_white.svg`
  - **Web, iOS, Android & Social SVG:** `09_favicon_adaptive.svg`, `10_app_icon_ios_pwa.svg`, `11_app_icon_android_adaptive.svg`, `12_social_avatar_square.svg`, `13_social_og_banner.svg`
- **Spesifikasi Ikon Logo:**
  - `viewBox="0 0 256 256"`, figur pelindung `#19496B` (*Deep Slate Blue*) + figur anak `#376386` (*Ocean Cerulean*).
  - Wordmark `"Nurtura"` menggunakan `font-weight: 800`, `color: #19496B`, `letter-spacing: -0.03em`.
- **Aturan Ikon UI:** Seluruh ikon navigasi/status memakai SVG vektor *inline* bergaya *outline* (`stroke-width: 2 – 2.5`) dan **bebas emoji mentah**.

---

## 4. Komponen & Pola Interaksi UX

1. **Header & Navigasi (`.navbar-clean`):**
   - *Sticky top bar* berlatar `#ffffff`, tinggi `68px`, pembatas bawah `1px solid #e2e8f0`, tanpa tag kapsul dekoratif di samping logo.
2. **Hero + Device Mockup Frame (`.hero-clean`, `.device-mockup-frame`):**
   - Bingkai simulasi browser dengan *3 traffic-light dots* (`#ef4444`, `#f59e0b`, `#10b981`), *address bar* `nurtura.posyandu.id/katalog-gizi-resmi`, serta efek *subtle scroll parallax* (`data-parallax="-0.04"`).
3. **Etalase 8 Fakta Medis Global — Full-Bleed Marquee 4:3 (`.clinical-showcase-fullbleed`):**
   - Membentang `100vw` dari ujung kiri ke kanan layar.
   - Kartu berproporsi `aspect-ratio: 4 / 3` (`flex: 0 0 340px`) bergerak otomatis perlahan dalam *infinite loop* (tetap berjalan saat kursor berada di atasnya).
   - **Center-Focus Scaling:** Kartu yang melewati tengah layar membesar secara dinamis (`scale(1.09)` + border `#0284c7`), lalu mengecil kembali ke `scale(0.92)` di tepi.
   - **Wheel Horizontal Control:** Menggulir *mouse wheel* di area etalase menggeser kartu secara horizontal (gulir atas → kiri, gulir bawah → kanan).
   - **Detail Klinis Modal (`#clinical-fact-modal`):** Klik kartu membuka modal fakta lapangan dokter global (WHO, UNICEF, The Lancet, FAO, Kemenkes RI).
4. **Drawer Parallax 3 Kartu Indeks + 3 Kartu Integritas (`.parallax-drawer-wrapper`):**
   - Baris atas (`.parallax-drawer-top`, `z-index: 2`) menampilkan 3 metrik nasional (`19,8%`, `< 14%`, `270 Hari`).
   - Baris bawah (`.parallax-drawer-bottom`, `z-index: 1`) awalnya tersembunyi di belakang baris atas (`translateY(-88%)`) dan meluncur keluar ke bawah saat pengguna men-scroll.
5. **Katalog Kebutuhan & Penjaga Peran (`.card-clean.need-card-item`):**
   - Tab filter kategori (`.filter-tabs-clean` / `.filter-tab-btn`) menjaga layout kartu tetap vertikal konsisten.
   - Jika pengguna ber-peran `ibu_hamil` menekan **"Bantu Paket Pangan Ini →"**, sistem menampilkan modal interaktif (`#ibu-hamil-donate-modal`) untuk mengarahkan pendaftaran akun **Donatur** atau lanjut melihat detail.
6. **Visualisasi Klinis & UX Lanjutan:**
   - **LILA Semi-Circular Gauge & 5-Axis Nutritional Radar Chart** (`medical_charts.js`, SVG murni).
   - **Sticky Mini Summary Bar** (`#sticky-need-bar` di `need_detail.php`) saat scroll melewati `320px`.
   - **Live LILA Risk Indicator** (`#lila-live-indicator` di `create_need.php`) mendeteksi risiko KEK (`< 23,5 cm`) secara langsung saat mengetik.
   - **Website Global Confirmation Modal** (`#nurtura-global-confirm-modal`) menggantikan seluruh dialog `confirm()` bawaan browser.
   - **Root-Level Proof Modal** (`#proof-modal-global`) di luar kartu untuk mencegah getaran *hover* (*anti jedag-jedug*).
   - **Admin Dispute Finality Lock:** Konfirmasi final sebelum `resolved`/`rejected`, lalu laporan terkunci di arsip *read-only*.

---

## 5. Peta Screenshot Halaman (`docs/design/screenshots/`)

| No | Halaman | File Screenshot |
| :---: | :--- | :--- |
| 1 | Beranda Publik (`?page=home`) | [01_home.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/01_home.png) |
| 2 | Katalog Kebutuhan (`?page=explore`) | [02_explore.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/02_explore.png) |
| 3 | Detail Kebutuhan & Diagram 3D/Radar (`?page=need-detail&id=1`) | [03_need_detail.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/03_need_detail.png) |
| 4 | Masuk / Login (`?page=login`) | [04_login.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/04_login.png) |
| 5 | Daftar / Register (`?page=register`) | [05_register.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/05_register.png) |
| 6 | Dashboard Ibu Hamil (`?page=ibu-hamil-dashboard`) | [06_ibu_hamil_dashboard.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/06_ibu_hamil_dashboard.png) |
| 7 | Form Ajukan Kebutuhan (`?page=create-need`) | [07_ibu_hamil_create_need.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/07_ibu_hamil_create_need.png) |
| 8 | Dashboard Donatur (`?page=donatur-dashboard`) | [08_donatur_dashboard.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/08_donatur_dashboard.png) |
| 9 | Dashboard Admin NurturaGuard (`?page=admin-dashboard`) | [09_admin_dashboard.png](file:///c:/utee/BreakdownPRD/docs/design/screenshots/09_admin_dashboard.png) |

---

## 6. File Figma & Ekspor `.fig`

File desain resmi telah dibuat langsung di akun Figma (`sulthanahmadm@gmail.com`) berisi **Variable Collection (`Nurtura Tokens`)**, **Komponen Vektor Logo (`Brand/NurturaLogo`)**, **Komponen Tombol (`Button/LimePrimary`, `Button/GhostClean`)**, serta **Layar UI yang Dapat Diedit** (`01 Home Page` & `02 Explore Needs`):

- **Tautan File Figma Live:** https://www.figma.com/design/uslwqGZoNm6KFozTP1vMTX
- **Cara Mengunduh File `.fig` Lokal:** Buka tautan Figma di atas, lalu pilih menu **File → Save local copy...** untuk menyimpan file `.fig` resmi ke komputer lokal.
- **Aset Vektor & Screenshot Lokal:** Tersedia juga [nurtura-logo.svg](file:///c:/utee/BreakdownPRD/docs/design/assets/nurtura-logo.svg), [nurtura-icon.svg](file:///c:/utee/BreakdownPRD/docs/design/assets/nurtura-icon.svg), dan seluruh 9 screenshot `1280px` di `docs/design/screenshots/`.
