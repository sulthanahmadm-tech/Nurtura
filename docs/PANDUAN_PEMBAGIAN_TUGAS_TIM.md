# PANDUAN PEMBAGIAN TUGAS & BATASAN AKSES BERKAS (TIM NURTURA)

Dokumen ini adalah aturan kolaborasi kerja untuk **Damar (PM)**, **Uta & Kukuh (Frontend)**, dan **Ucup (Backend)** agar proses pengembangan berjalan mulus tanpa terjadi konflik kode (*merge conflict*) atau tumpang tindih tanggung jawab.

---

## 1. Matriks Akses Berkas & Zona Larangan

| Anggota Tim & Peran | Zona File Milik Sendiri (Boleh Diedit) | ZONA TERLARANG (JANGAN DISENTUH) |
|---|---|---|
| **Damar**<br>*(Project Manager)* | • `docs/*` (PRD, panduan skenario demo)<br>• `directives/*` (SOP alur & regulasi bisnis)<br>• `README.md` | ❌ **Folder `app/`, `public/assets/`, `views/`, dan `database/`** (Jangan menyentuh kode program agar tidak merusak logika sistem). |
| **Uta**<br>*(Frontend 1 - Public & Auth)* | • `views/layouts/*` (Header & Footer)<br>• `views/public/*` (Home, Explore, Detail)<br>• `views/auth/*` (Login & Register)<br>• `public/assets/css/style.css` (Styling global) | ❌ **Folder `app/models/`, `app/controllers/`, `config/`, `database/`** (Jangan menyentuh query SQL & logika backend).<br>❌ **Folder `views/ibu_hamil/`, `views/donatur/`, `views/admin/`** (Milik Kukuh). |
| **Kukuh**<br>*(Frontend 2 - Dashboard Module)* | • `views/ibu_hamil/*` (Dashboard & Form)<br>• `views/donatur/*` (Dashboard Donasi)<br>• `views/admin/*` (Panel NurturaGuard)<br>• `public/assets/js/main.js` (Interaktivitas DOM) | ❌ **Folder `app/models/`, `app/controllers/`, `config/`, `database/`** (Jangan menyentuh query SQL & logika backend).<br>❌ **Folder `views/public/`, `views/auth/`, `views/layouts/`** (Milik Uta). |
| **Ucup**<br>*(Backend Developer)* | • `app/controllers/*` (Semua controller)<br>• `app/models/*` (Semua model query PDO)<br>• `app/helpers/*` (Auth, Format, Cron Helper)<br>• `config/*` (database.php, app.php)<br>• `database/*` (schema.sql, seed.sql)<br>• `public/index.php` (Routing) | ❌ **Folder `public/assets/css/`** (CSS milik Uta).<br>❌ **Elemen HTML/Styling di `views/*`** (Jika Ucup butuh data baru di view, cukup berikan variabelnya ke Uta/Kukuh, jangan rombak layout HTML). |

---

## 2. Aturan Emas Kolaborasi (Pemisahan Frontend vs Backend)

1. **Aturan untuk Uta & Kukuh (Frontend):**
   * Di dalam file `views/`, Anda **HANYA** bertugas mengatur elemen HTML, form, class CSS, dan mencetak variabel data PHP yang sudah disiapkan backend (contoh: `<?= htmlspecialchars($n['title']) ?>`).
   * **DILARANG KERAS** menulis query SQL (`$pdo->query(...)` atau `SELECT * FROM...`) di dalam file view! Jika membutuhkan data baru dari database, minta ke Ucup agar disiapkan lewat Controller.
2. **Aturan untuk Ucup (Backend):**
   * Logika pemrosesan data, validasi upload Buku KIA, perhitungan timer 48 jam, dan query database harus tetap berada di `app/controllers/` dan `app/models/`.
   * Jangan mengotak-atik class CSS atau susunan tag HTML yang sudah dirapikan Uta dan Kukuh di `views/`.
3. **Aturan untuk Damar (PM):**
   * Damar bertindak sebagai penengah alur dan penguji (*quality assurance*). Damar memvalidasi apakah tampilan Uta/Kukuh dan logika Ucup sudah sesuai dengan [PRD_NURTURA_REVISED.md](PRD_NURTURA_REVISED.md).

---

## 3. Cheatsheet Rekomendasi Kustomisasi (Mau Ubah Apa? Di Mana Tempatnya?)

| Kebutuhan Kustomisasi | Penanggung Jawab | Lokasi Berkas & Bagian yang Diubah |
|---|---|---|
| **Ganti Nama Web / Tagline / Durasi Timer 48 Jam** | Ucup | [config/app.php](file:///C:/utee/BreakdownPRD/config/app.php)<br>Ubah nilai `APP_NAME`, `APP_TAGLINE`, atau `LOCK_TIMEOUT_HOURS`. |
| **Ganti Pengaturan Database (Port / Password MySQL)** | Ucup | [config/database.php](file:///C:/utee/BreakdownPRD/config/database.php)<br>Ubah `DB_PORT` atau `DB_PASS`. |
| **Ganti Palet Warna Utama, Font, dan Desain Tombol** | Uta | [public/assets/css/style.css](file:///C:/utee/BreakdownPRD/public/assets/css/style.css)<br>Ubah variabel di blok `:root` (misal `--primary: #10b981`). |
| **Ganti Kata-Kata / Banner di Halaman Depan (Hero)** | Uta | [views/public/home.php](file:///C:/utee/BreakdownPRD/views/public/home.php)<br>Sesuaikan judul `<h1>`, paragraf, dan tombol ajakan aksi (CTA). |
| **Ubah Tampilan Form Pendaftaran & Login** | Uta | [views/auth/login.php](file:///C:/utee/BreakdownPRD/views/auth/login.php) & [views/auth/register.php](file:///C:/utee/BreakdownPRD/views/auth/register.php). |
| **Kustomisasi Tampilan Dashboard Ibu Hamil & Form Pengajuan** | Kukuh | [views/ibu_hamil/dashboard.php](file:///C:/utee/BreakdownPRD/views/ibu_hamil/dashboard.php) & [create_need.php](file:///C:/utee/BreakdownPRD/views/ibu_hamil/create_need.php). |
| **Kustomisasi Tampilan Dashboard Donatur & Panel Admin** | Kukuh | [views/donatur/dashboard.php](file:///C:/utee/BreakdownPRD/views/donatur/dashboard.php) & [views/admin/dashboard.php](file:///C:/utee/BreakdownPRD/views/admin/dashboard.php). |
| **Ubah Animasi / Hitung Mundur / Konfirmasi Dialog** | Kukuh | [public/assets/js/main.js](file:///C:/utee/BreakdownPRD/public/assets/js/main.js). |
| **Tambah Data Posyandu / Akun Dummy Baru untuk Demo** | Ucup | [database/seed.sql](file:///C:/utee/BreakdownPRD/database/seed.sql)<br>Tambah baris `INSERT INTO drop_points...` lalu re-import di phpMyAdmin. |
| **Tambah Field Baru di Database (misal: Golongan Darah)** | Ucup | [database/schema.sql](file:///C:/utee/BreakdownPRD/database/schema.sql), lalu sesuaikan model di `app/models/User.php`. |
| **Update PRD & Persiapan Materi Presentasi Kelompok** | Damar | [docs/PRD_NURTURA_REVISED.md](file:///C:/utee/BreakdownPRD/docs/PRD_NURTURA_REVISED.md) & [docs/USER_FLOW_AND_TESTING.md](file:///C:/utee/BreakdownPRD/docs/USER_FLOW_AND_TESTING.md). |
