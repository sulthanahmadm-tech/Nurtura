# SOP 01: Autentikasi dan Manajemen Peran (Roles)

## Tujuan
Mengatur hak akses dan keamanan akun pengguna pada platform Nurtura menggunakan PHP Native Session & MySQL.

## Peran Pengguna (Roles)
1. **`ibu_hamil` (Pengaju Kebutuhan)**
   - Akses: Membuat profil kehamilan, mengajukan kebutuhan gizi (NurturaNeeds), melihat status pengajuan sendiri, mengonfirmasi penerimaan bantuan di Posyandu, melaporkan kendala/sengketa.
   - Larangan: Tidak dapat melihat data privat ibu hamil lain, tidak dapat mengakses panel admin.
2. **`donatur` (Pemberi Dukungan)**
   - Akses: Menjelajahi katalog kebutuhan terverifikasi publik (`explore_needs`), mengunci komitmen bantuan (maksimal 48 jam), mengunggah bukti pengiriman/penitipan paket ke Posyandu.
   - Larangan: Tidak dapat melihat alamat rumah pribadi, NIK, atau nomor telepon ibu hamil.
3. **`admin` (NurturaGuard / Pengelola Platform)**
   - Akses: Panel NurturaGuard (`views/admin/`), memverifikasi dokumen Buku KIA & LILA pengajuan baru, menyetujui/menolak/meminta revisi, memediasi sengketa (dispute), mengelola master data Posyandu.

## Standar Keamanan
- Password wajib di-hash menggunakan algoritma `password_hash($password, PASSWORD_BCRYPT)`.
- Verifikasi password menggunakan `password_verify($password, $user['password_hash'])`.
- Regenerasi ID sesi saat login sukses: `session_regenerate_id(true)` untuk mencegah Session Fixation.
- Setiap form input wajib menyertakan CSRF Token yang diverifikasi di sisi controller.
