# SOP 03: Privasi Data Medis dan Keamanan Unggah Berkas

## Prinsip Perlindungan Data Pribadi (UU PDP & Etika Medis)
1. **Identitas Terbuka Hanya untuk Admin:**
   - Nama lengkap, NIK, dan nomor telepon ibu hamil hanya tersimpan di tabel `profiles` dan hanya dapat dibaca oleh Admin berwenang.
   - Di tampilan publik dan donatur, identitas ibu hamil wajib disamarkan (*masked*), contoh: `Ibu S***** (Kec. Purwokerto Timur)`.
2. **Lokasi Pengiriman Hanya ke Drop-Point:**
   - Donatur tidak pernah diberikan alamat tempat tinggal ibu hamil.
   - Alamat tujuan pengiriman paket adalah alamat fasilitas kesehatan resmi: Posyandu, Bidan Desa, atau Puskesmas Pembantu (Pustu) yang dipilih saat pengajuan.

## Prosedur Unggah Dokumen Sensitif (Buku KIA)
1. **Validasi File di Sisi Server (PHP):**
   - Tipe berkas yang diizinkan: `image/jpeg`, `image/png`, `application/pdf`.
   - Ukuran maksimum: `3 MB`.
   - Cek MIME type riil menggunakan `mime_content_type($_FILES['file']['tmp_name'])` (bukan sekadar ekstensi file).
2. **Isolasi Folder Penyimpanan:**
   - File foto Buku KIA disimpan di luar `public/`, yaitu di `storage/uploads/kia_documents/`.
   - Folder ini dilindungi file `.htaccess` (`Deny from all`) agar tidak dapat dibuka secara langsung via URL peramban (contoh: `http://localhost/storage/...` akan menghasilkan 403 Forbidden).
   - Hanya skrip PHP admin terotentikasi (`app/controllers/AdminController.php` via endpoint `view_kia.php`) yang dapat membaca dan menampilkan file tersebut ke browser.
