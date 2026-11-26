# code.md — Arsitektur Kode Frontend & Integrasi Nurtura

Dokumen ini merangkum struktur implementasi UI/UX, CSS, JavaScript, dan keterhubungannya dengan backend PHP Native + MySQL pada platform **Nurtura**.

---

## 1. Peta File Frontend & Controller

| Lapisan | File | Tanggung Jawab |
| :--- | :--- | :--- |
| **Front Router** | [public/index.php](file:///c:/utee/BreakdownPRD/public/index.php) | Memicu `run_lifecycle_checks()` otomatis dan mengarahkan parameter `?page=` & `?action=` |
| **Desain & Token CSS** | [public/assets/css/style.css](file:///c:/utee/BreakdownPRD/public/assets/css/style.css) | `:root` tokens, `.navbar-clean`, `.hero-clean`, `.btn-lime`, `.btn-ghost-clean`, `.card-clean`, `.clinical-marquee-*`, `.parallax-drawer-*`, `.sticky-need-bar`, `.nurtura-modal-*`, `.nurtura-toast` |
| **Interaksi & Motion JS** | [public/assets/js/main.js](file:///c:/utee/BreakdownPRD/public/assets/js/main.js) | Toggle form registrasi, countdown timer 48 jam, Global Confirm Modal (`[data-confirm]`), Toast, KIA Inspector (Zoom/Rotate), Proof Modal (`#proof-modal-global`), Spring Reveal (`IntersectionObserver`), Scroll Parallax (`requestAnimationFrame`), Drawer Parallax Stack |
| **Diagram Klinis SVG** | [public/assets/js/medical_charts.js](file:///c:/utee/BreakdownPRD/public/assets/js/medical_charts.js) | Render dinamis *Semi-Circular LILA Gauge* (`data-medical-chart="lila-gauge"`) & *5-Axis Nutritional Radar* (`data-medical-chart="nutrition-radar"`) |
| **Layout Global** | [views/layouts/header.php](file:///c:/utee/BreakdownPRD/views/layouts/header.php) & [footer.php](file:///c:/utee/BreakdownPRD/views/layouts/footer.php) | Navbar berbasis peran, `#nurtura-global-confirm-modal`, `#nurtura-toast`, dan pemuatan script ber-versioning (`filemtime`) |

---

## 2. Peta Halaman & Fitur Spesifik

### A. Halaman Publik (`views/public/`)
- **[home.php](file:///c:/utee/BreakdownPRD/views/public/home.php):**
  - Hero putih bersih dengan jendela simulasi `.device-mockup-frame` (`data-parallax="-0.04"`).
  - Alur penyaluran 3 langkah dengan `[data-motion="reveal"]` (*staggered delay*).
  - **Etalase 8 Fakta Medis Global (`clinicalFactsData`):** *Full-bleed* (`100vw`) *infinite marquee* dengan kartu `aspect-ratio: 4 / 3`, *center-focus scale* (`1.09` di tengah ↔ `0.92` di tepi), gulir *wheel* horizontal, serta `#clinical-fact-modal`.
  - **Drawer Parallax Stack:** 3 kartu indeks di `.parallax-drawer-top` dan 3 kartu integritas di `.parallax-drawer-bottom`.
- **[explore_needs.php](file:///c:/utee/BreakdownPRD/views/public/explore_needs.php):**
  - Filter kategori JS `filterNeeds()` mempertahankan `display: flex; flex-direction: column` melalui toggle `''` vs `'none'`.
  - Penjaga peran Ibu Hamil (`openIbuHamilDonateModal()`): menampilkan pop-up ajakan daftar Donatur saat akun `ibu_hamil` mengklik **"Bantu Paket Pangan Ini →"**.
- **[need_detail.php](file:///c:/utee/BreakdownPRD/views/public/need_detail.php):**
  - Merender `LILA Gauge` & `5-Axis Radar Chart`.
  - Menampilkan `#sticky-need-bar` ketika scroll melewati `320px`.
  - Membatasi data query melalui `Need::find_by_id()` tanpa kolom `full_name` (*Zero PII Leakage*).

### B. Autentikasi (`views/auth/`)
- **[login.php](file:///c:/utee/BreakdownPRD/views/auth/login.php):** Form login dengan 3 tombol pengisi demo cepat (`fillDemo()`).
- **[register.php](file:///c:/utee/BreakdownPRD/views/auth/register.php):** Pemilih peran kartu interaktif (`ibu_hamil` vs `donatur`) dengan bidang kehamilan dinamis (usia kehamilan, HPL, LILA).

### C. Panel Peran Pengguna (`views/ibu_hamil/`, `views/donatur/`, `views/admin/`)
- **[ibu_hamil/dashboard.php](file:///c:/utee/BreakdownPRD/views/ibu_hamil/dashboard.php):**
  - *3D Pregnancy Orb*, *LILA Gauge*, riwayat pengajuan dengan `render_need_progress_tracker()`, tombol salin kode `#NTR-XXXX` (`copyNeedCode()` + Toast), modal bukti global di *root level* (`#proof-modal-global` anti *jedag-jedug*), dan konfirmasi penerimaan via `data-confirm`.
- **[ibu_hamil/create_need.php](file:///c:/utee/BreakdownPRD/views/ibu_hamil/create_need.php):**
  - Live 5-Axis Radar preview dari textarea bahan pangan + `updateLiveLilaIndicator()` real-time (`< 23,5 cm` risiko KEK).
- **[donatur/dashboard.php](file:///c:/utee/BreakdownPRD/views/donatur/dashboard.php):**
  - Countdown timer 48 jam real-time (`.countdown-timer`) dengan progress bar dan dropzone unggah bukti serah terima.
- **[admin/dashboard.php](file:///c:/utee/BreakdownPRD/views/admin/dashboard.php):**
  - Inspeksi berkas KIA (`openKiaInspector()` dengan Zoom & Rotate).
  - Manajemen kendala (*dispute*) terbagi menjadi **Kendala Aktif** (dengan modal verifikasi `#dispute-confirm-modal` sebelum final) dan **Riwayat Kendala Selesai / Terkunci** (*read-only*).

---

## 3. Aturan Keamanan & Kepatuhan PRD di Backend

- **CSRF Token:** Seluruh aksi `POST` dilindungi `generate_csrf_token()` dan `verify_csrf_token()`.
- **Role Guard:** Setiap endpoint panel dilindungi `require_auth(['admin' | 'ibu_hamil' | 'donatur'])`.
- **Upload Validation (`SOP 03`):**
  - `NeedController::create()`: memvalidasi MIME type asli (`finfo_file`) JPG/PNG/PDF maks `3 MB`, disimpan di `storage/uploads/kia_documents/` (dilindungi `.htaccess` + dibaca via `AdminController::view_kia`).
  - `DonationController::upload_proof()`: memvalidasi MIME type asli JPG/PNG/WEBP maks `5 MB`, mengecek kepemilikan `donor_user_id` & status `'committed'` di `Donation::upload_proof()`.
- **Dispute Guard:** `Donation::create_dispute()` memverifikasi kepemilikan `needs.user_id` & status `'menunggu_pengambilan'`; `AdminController::update_dispute()` menolak perubahan jika status dispute sudah `resolved` atau `rejected`.
