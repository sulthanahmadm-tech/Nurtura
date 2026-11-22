# SKENARIO PENGUJIAN & PANDUAN DEMO PROYEK (NURTURA)

Dokumen ini memandu tim saat presentasi atau demonstrasi sistem di hadapan dosen/penguji.

---

## Skenario 1: Registrasi & Pengajuan Kebutuhan oleh Ibu Hamil
1. Akses halaman pendaftaran: `/public/index.php?page=register`.
2. Pilih peran **Ibu Hamil**. Masukkan data identitas lengkap (termasuk perkiraan HPL dan LILA).
3. Masuk ke dashboard ibu hamil: `/public/index.php?page=create-need`.
4. Isi kebutuhan: misal "Paket Telur 2 kg, Susu Ibu Hamil 2 Box, dan Kacang Hijau 1 kg".
5. Pilih Drop-Point Posyandu terdekat: "Posyandu Melati 1 - Purwokerto Timur".
6. Unggah foto lembar Buku KIA (simulasi berkas gambar JPG/PNG).
7. Klik **Kirim Pengajuan**. Status berubah menjadi `menunggu_peninjauan`.

---

## Skenario 2: Moderasi & Validasi oleh Admin NurturaGuard
1. Login sebagai Admin: `admin@nurtura.local` (Password default di seed).
2. Buka antrean moderasi di dashboard admin: `/public/index.php?page=admin-dashboard`.
3. Klik tombol **Tinjau Dokumen KIA**. Sistem memanggil endpoint aman untuk merender foto KIA dari direktori terlindungi.
4. Cek nilai LILA (contoh 21,5 cm < 23,5 cm -> indikasi KEK valid).
5. Klik tombol **Setujui Pengajuan**.
6. Status pengajuan seketika berubah menjadi `dipublikasikan`.

---

## Skenario 3: Penemuan Kebutuhan & Komitmen Donatur
1. Login sebagai Donatur: `donatur@nurtura.local`.
2. Buka katalog publik: `/public/index.php?page=explore`.
3. Perhatikan bahwa nama ibu hamil disamarkan menjadi `Ibu Hamil #ID-XXX (Purwokerto Timur)`. Alamat rumah tidak ditampilkan; yang ditampilkan adalah alamat Posyandu drop-point.
4. Klik tombol **"Bantu Kebutuhan Ini"**.
5. Sistem mengunci kebutuhan menjadi `dalam_komitmen` dan menampilkan countdown timer **48 Jam tersisa**.
6. Buka kembali katalog explore dengan akun lain; pengajuan tersebut kini bertanda *"Sedang Dibantu Donatur Lain"* sehingga tidak bisa diklik dobel.

---

## Skenario 4: Donatur Mengunggah Bukti Serah Terima Posyandu
1. Donatur menuju Posyandu atau mengirim via kurir ke alamat Posyandu mitra.
2. Di dashboard donatur, klik tombol **"Unggah Bukti Serah Terima"**.
3. Upload foto penyerahan ke petugas posyandu / resi kurir.
4. Status pengajuan berubah menjadi `menunggu_pengambilan`.

---

## Skenario 5: Konfirmasi Akhir Ibu Hamil / Auto-Complete
1. Ibu hamil login ke dashboard dan melihat notifikasi: *"Paket pangan Anda telah tiba di Posyandu Melati 1"*.
2. Setelah mengambil paket, ibu hamil menekan tombol **"Konfirmasi Paket Diterima"**.
3. Status pengajuan berubah menjadi `selesai`.
4. *Uji Edge Case:* Jika ibu hamil tidak mengklik dalam 72 jam dan tidak ada sengketa, cron helper otomatis mengubah status menjadi `selesai`.
