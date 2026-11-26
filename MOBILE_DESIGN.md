# MOBILE_DESIGN.md — Kerangka Arsitektur Mobile Nurtura Clinical Care

> **Sistem Desain:** Nurtura Clinical Care (Desktop-to-Mobile Adaptive Blueprint)  
> **Kepatuhan PRD (`docs/PRD_NURTURA_REVISED.md`):** 100% *Offline-Ready* (PHP Native + Vanilla CSS/JS tanpa CDN atau framework CSS eksternal), *Zero PII Leakage* (Drop-Point Posyandu), validasi klinis **LILA < 23,5 cm** & Buku KIA tetap menonjol.  
> **Standar Satuan CSS:** **Zero `px` Length/Width Policy** — seluruh ukuran lebar, tinggi, margin, padding, gap, radius, border, breakpoint, dan tipografi menggunakan satuan relatif **`rem`, `em`, `%`, `vw`, `dvh`, dan `clamp()`** (berbasis `html { font-size: 100%; }`).

---

## 1. Breakpoints & Viewport Target (`rem`-Based)

| Nama Breakpoint | Media Query CSS | Ekuivalen Perangkat | Perilaku Utama |
| :--- | :--- | :--- | :--- |
| **Desktop Wide** | `> 64rem` | `> 1024px` | Grid 2-kolom hero (`7fr 5fr`), Marquee 4:3, Tabel penuh, Parallax drawer |
| **Tablet Adaptive** | `@media (max-width: 64rem)` | `≤ 1024px` | Hero & Dashboard stack 1 kolom, Auth split menjadi vertikal |
| **Mobile Standard** | `@media (max-width: 48rem)` | `≤ 768px` (`390×844` / `24.375rem×52.75rem`) | Header ringkas `3.5rem` + Drawer, Marquee disembunyikan -> Accordion klinis, Modal -> Bottom-Sheet (`85dvh`), Tabel -> Stacked Cards |
| **Small Phone** | `@media (max-width: 30rem)` | `≤ 480px` (`375px` / `23.4375rem`) | Stepper vertikal penuh (`100%`), padding rapat `1rem`, radius kompak |

---

## 2. Skala Tipografi Cair & Touch Target

| Peran Tipografi | Token / Nilai CSS | Skala Font (`rem`/`vw`) | Line Height | Catatan Keterbacaan & Sentuhan |
| :--- | :--- | :--- | :--- | :--- |
| **Hero Headline (H1)** | `--font-display` (Georgia/Cambria Serif) | `clamp(1.75rem, 6vw, 3.25rem)` | `1.16` | Mengunci proporsi editorial tanpa memotong kata pada lebar `23.4rem` |
| **Section Heading (H2)** | `--font-display` | `clamp(1.375rem, 4.5vw, 2rem)` | `1.25` | Kontras tinggi `#2D3339` di atas `#F8F9FD` / `#FFFFFF` |
| **Card / Accordion Title (H3)** | `--font-sans` | `clamp(1.0625rem, 3.2vw, 1.25rem)` | `1.35` | Digunakan pada judul paket pangan & summary akordion |
| **Body & Form Input** | `--font-sans` | `1rem` (mobile inputs dikunci `1rem`) | `1.55` | Mencegah auto-zoom Safari iOS saat input difokuskan |
| **Klinis / Angka LILA / Timer** | `--font-mono` (`tabular-nums`) | `clamp(1.5rem, 5vw, 2.3rem)` (hero/metric), `0.78rem–0.92rem` (badge/kode) | `1.0`–`1.3` | Angka LILA `< 23,5 cm` dan sisa waktu 48 jam selalu rata kolom |
| **Micro Label / Metadata** | `--font-sans` | `>= 0.75rem` | `1.3`–`1.4` | Batas minimum terbaca di layar HP (`0.75rem`, setara `12px`) |
| **Touch Target Minimum** | `--touch-target` | `min-height: 2.75rem; min-width: 2.75rem;` | — | Memenuhi standar ergonomi jari (44pt ekuivalen) pada tombol, drawer link, tab, & close button |

---

## 3. Kerangka Komponen Desktop → Mobile (`≤ 48rem`)

### A. Navigasi Ringkas `3.5rem` + Slide-Over Drawer (`header.php`)
- **Top Bar (`height: 3.5rem`, `padding: 0 4vw`):**
  - Kiri: Logo mark + `Nurtura` (`--font-display`).
  - Kanan: **1 Quick CTA** sesuai peran (`+ Ajukan` untuk Ibu Hamil, `Moderasi` untuk Admin, `Katalog` untuk Donatur, `Masuk` untuk Tamu) + **Tombol Hamburger (`2.75rem × 2.75rem`)**.
- **Drawer Samping (`#mobile-nav-drawer`):**
  - Lebar `min(21rem, 86vw)`, tinggi `100dvh`, geser dari kanan (`translateX(100%)` -> `translateX(0)`).
  - Menampilkan kartu identitas peran aktif, daftar tautan navigasi berjarak sentuh `2.75rem`, dan tombol Daftar/Keluar selebar `100%` di bawah.

### B. Flashcard Marquee & Informasi Klinis → Accordion Lipat (`home.php`, `need_detail.php`)
- **Marquee 4:3 Desktop (`.clinical-showcase-fullbleed`):** Disembunyikan total pada `@media (max-width: 48rem)` (`display: none`).
- **Mobile Clinical Facts Accordion (`#clinical-mobile-accordion`):** Menggantikan *marquee* secara otomatis dengan 8 panel `<details class="clinical-accordion-item">` yang dapat dibuka-tutup (item pertama *open* secara default, dilengkapi kategori, metrik mono, fakta klinis dokter global, kaitan paket Nurtura, dan tombol detail bottom-sheet).
- **Kartu Alur Penyaluran (3 Langkah), 3 Pilar Integritas, & Radar 5 Sumbu AKG:** Menggunakan `<details class="info-accordion-card" data-mobile-collapse="true">` yang tampil terbuka sebagai grid 3 kolom di desktop dan otomatis melipat di mobile agar *viewport* HP langsung fokus pada ringkasan utama.
- **Parallax Reset:** Di layar mobile, efek *parallax drawer* dimatikan (`transform: none; opacity: 1;`) agar tidak menumpuk kartu.

### C. Popup / Modal → Bottom-Sheet Thumb-Friendly (`footer.php`, `explore_needs.php`, `admin/dashboard.php`, `ibu_hamil/dashboard.php`)
Seluruh modal (`#nurtura-global-confirm-modal`, `#clinical-fact-modal`, `#ibu-hamil-donate-modal`, `#proof-modal-global`, `#dispute-confirm-modal`, `#kia-inspector-modal`) otomatis berubah pada `≤ 48rem`:
- **Anchoring:** `align-items: flex-end; padding: 0;`.
- **Dimensi Sheet:** `width: 100%; max-height: 85dvh; overflow-y: auto; border-radius: 1.25rem 1.25rem 0 0;`.
- **Grabber & Safe Area:** Terdapat garis pegangan atas (`width: 2.5rem; height: 0.25rem;`) via `::before`, plus bantalan bawah `calc(1.25rem + env(safe-area-inset-bottom, 0rem))`.
- **Sticky Action Bar (`need_detail.php`):** `#sticky-need-bar` melebar `94vw` (`left: 3vw`) dengan tombol aksi `width: 100%` di zona ibu jari saat pengguna menggulir halaman detail.

### D. Tabel Antrean Admin & Komparasi → Stacked Cards (`admin/dashboard.php`, `home.php`)
- Pada `≤ 48rem`, `thead` disembunyikan dan setiap baris `<tr>` dirender sebagai kartu independen (`border-radius: var(--radius-md); padding: 1rem; margin-bottom: 0.875rem;`).
- Setiap sel `<td>` menampilkan label kolom via `content: attr(data-label)` dengan tipografi uppercase `0.75rem` berwarna `--primary`, meniadakan *horizontal scroll* tabel di HP.

---

## 4. Pemetaan Layout Layar Mobile (`390 × 844` / `24.375rem × 52.75rem`)

Referensi visual kerangka mobile ini juga dibuat sebagai frame editable di Figma pada file `uslwqGZoNm6KFozTP1vMTX` halaman **`03 · Mobile Wireframes (24.375rem)`** yang mencakup:
1. **Mobile Home** (`3.5rem` header, hero 1-kolom, snapshot LILA `21,2 cm`, 8-item *Clinical Accordion*, 3-item *Pilar Accordion*, stacked comparison card).
2. **Mobile Explore + Bottom-Sheet Filter/Modal** (header katalog + swipeable horizontal filter chips + single-column need cards + `#ibu-hamil-donate-modal` bottom-sheet `85dvh`).
3. **Mobile Need Detail + Sticky Thumb Bar** (LILA Gauge full-width, AKG Radar accordion, rincian pangan & Drop-Point Posyandu, sticky bottom action bar).
4. **Mobile Admin Queue Stacked Cards + KIA Bottom-Sheet** (KPI vertical stack, stacked verification card dengan aksi Setujui/Revisi/Tolak, modal KIA mobile inspector).
5. **Mobile Navigation Drawer State** (`86vw` slide-over drawer + role banner + full-width logout/auth buttons).
