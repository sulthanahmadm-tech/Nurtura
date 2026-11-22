# Nurtura — Platform Pencegahan Stunting Berbasis Komunitas & Drop-Point Posyandu

> **Tim Pengembang:** S-Tech Tim Gensoed Novices  
> **Tema:** Ketahanan Pangan (Sub-tema: Nutrition & Household Security)  
> **Tagline:** *Nurturing Mothers, Nourishing Futures*  
> **Tech Stack:** PHP (Clean MVC), MySQL, phpMyAdmin, Vanilla JavaScript, Modern CSS, HTML5.

---

## 📌 Ringkasan Solusi
Nurtura menyelesaikan masalah mendasar pencegahan stunting pada masa 1.000 Hari Pertama Kehidupan (HPK) dengan menghubungkan ibu hamil berisiko Kurang Energi Kronis (KEK, LILA < 23,5 cm) dengan masyarakat donatur.

### Inovasi Kunci Mengatasi Celah Logika PRD:
1. **Drop-Point Posyandu / Bidan Desa:** Nol risiko transaksi uang fiktif dan 100% melindungi privasi alamat rumah ibu hamil. Donatur menitipkan paket pangan bergizi riil langsung ke fasilitas kesehatan mitra.
2. **Validasi Medis Buku KIA:** Menghilangkan bias penilaian admin non-medis dengan mewajibkan verifikasi lembar catatan Buku KIA resmi.
3. **Penyelesaian Deadlock & Ghosting:** Dilengkapi *lock-timer* 48 jam (auto-release jika donatur mangkir), auto-complete 72 jam jika paket telah tiba tanpa dispute, dan penutupan otomatis jika melewati HPL.

---

## 🚀 Panduan Menjalankan Proyek (XAMPP / Laragon)

### 1. Letakkan Folder Proyek
Pindahkan atau clone folder `BreakdownPRD` ke direktori web server Anda:
- **XAMPP (Windows):** `C:\xampp\htdocs\BreakdownPRD\`
- **Laragon:** `C:\laragon\www\BreakdownPRD\`

### 2. Import Database di phpMyAdmin
1. Buka browser dan buka `http://localhost/phpmyadmin/`.
2. Buat database baru dengan nama: `nurtura_db`.
3. Klik database `nurtura_db`, pilih tab **Import**, lalu unggah file:
   - `database/schema.sql` (struktur tabel & relasi)
   - `database/seed.sql` (data pengguna contoh & posyandu mitra)
4. Klik **Go / Kirim**.

### 3. Konfigurasi Koneksi (Jika Ada Perubahan Port/Password)
Buka file `config/database.php`:
```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'nurtura_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Sesuaikan jika MySQL Anda memiliki password
```

### 4. Akses Aplikasi di Browser
Buka peramban dan kunjungi:
`http://localhost/BreakdownPRD/public/`

---

## 🔑 Akun Demo Pengujian (Data Seed)
Semua akun demo menggunakan kata sandi: **`password123`**

| Peran (Role) | Email Login | Hak Akses Utama |
|---|---|---|
| **Admin (NurturaGuard)** | `admin@nurtura.local` | Moderasi pengajuan baru, tinjau berkas Buku KIA, validasi nilai LILA, mediasi dispute. |
| **Ibu Hamil (Siti)** | `ibu.siti@nurtura.local` | Profil kehamilan (LILA 21 cm), ajukan NurturaNeeds, upload KIA, konfirmasi terima di Posyandu. |
| **Donatur (Budi)** | `donatur.budi@nurtura.local` | Jelajahi katalog explore, kunci komitmen bantuan (timer 48 jam), upload bukti antar paket posyandu. |

---

## 📂 Struktur Direktori Proyek
```
BreakdownPRD/
├── directives/                # TIER 1: Standard Operating Procedures (SOP Tim)
│   ├── auth_and_roles.md      # SOP Manajemen Peran & Keamanan Sesi
│   ├── need_lifecycle_sop.md  # SOP 8 Status Pengajuan, Timer 48 Jam & 72 Jam
│   ├── privacy_and_upload_sop.md # SOP Keamanan Unggah KIA & Proteksi File
│   └── database_management_sop.md # SOP phpMyAdmin & Query PDO Aman
├── docs/                      # TIER 1: Dokumentasi Lengkap Proyek
│   ├── PRD_NURTURA_REVISED.md # PRD Resmi Hasil Revisi Bebas Celah Logika
│   ├── DATABASE_SCHEMA.md     # Kamus Data Relasional & Diagram ERD
│   └── USER_FLOW_AND_TESTING.md # Skenario Pengujian & Panduan Presentasi Demo
├── database/                  # TIER 3: Database Scripts
│   ├── schema.sql             # DDL Tabel MySQL (InnoDB, FK, Indeks)
│   └── seed.sql               # Data Awal Demo
├── config/                    # Konfigurasi Inti
│   ├── database.php           # Koneksi PDO Prepared Statements
│   └── app.php                # Konstanta Aplikasi & Timer
├── app/                       # TIER 3: Backend Logic (Clean MVC)
│   ├── helpers/               # Auth, Formatting & Cron Background Helpers
│   ├── models/                # User, Need, Donation, DropPoint Models
│   └── controllers/           # Auth, Need, Donation, Admin Controllers
├── storage/                   # Berkas Privat Terisolasi
│   └── uploads/kia_documents/ # Foto Buku KIA (Dilindungi .htaccess Deny All)
├── public/                    # TIER 3: Web Root Publik
│   ├── index.php              # Front Controller & Main Router
│   └── assets/                # CSS Responsif & Vanilla JavaScript
└── views/                     # TIER 3: Tampilan Antarmuka (HTML5 + PHP)
    ├── layouts/               # Header & Footer Terstruktur
    ├── public/                # Beranda, Katalog Explore & Rincian Kebutuhan
    ├── auth/                  # Formulir Login & Register
    ├── ibu_hamil/             # Dashboard Pengajuan & Form NurturaNeeds
    ├── donatur/               # Dashboard Komitmen & Upload Bukti Posyandu
    └── admin/                 # Panel NurturaGuard & Viewer Buku KIA
```
