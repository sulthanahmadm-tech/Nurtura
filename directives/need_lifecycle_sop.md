# SOP 02: Siklus Hidup Pengajuan Kebutuhan (Need Lifecycle & State Machine)

## Daftar Status (State Machine)
Tabel `needs` memiliki kolom `status` dengan nilai enum sebagai berikut:

| Status | Penanggung Jawab | Deskripsi & Tindakan |
|---|---|---|
| `draf` | Ibu Hamil | Pengajuan tersimpan di akun ibu hamil, belum dikirim ke admin. |
| `menunggu_peninjauan` | Admin | Pengajuan telah dikirim beserta lampiran Buku KIA & LILA, menunggu verifikasi NurturaGuard. |
| `perlu_perbaikan` | Ibu Hamil | Admin meminta perbaikan data/foto KIA. Diberi tenggat waktu 7 hari sebelum dibatalkan otomatis. |
| `ditolak` | Admin (Final) | Pengajuan fiktif, dokumen tidak valid, atau bukan indikasi stunting/KEK. |
| `dipublikasikan` | Donatur | Lolos verifikasi admin, tampil di katalog publik, siap didanai donatur. |
| `dalam_komitmen` | Donatur | Donatur telah mengunci komitmen. **Lock-Timer 48 jam aktif**. Donatur lain tidak dapat mengambil pengajuan ini. |
| `menunggu_pengambilan` | Ibu Hamil / Posyandu | Donatur telah mengunggah bukti drop paket di Posyandu. Ibu hamil dapat mengambil paket. |
| `dispute` | Admin | Ibu hamil melapor paket tidak ada di Posyandu / rusak / fiktif. Admin melakukan mediasi. |
| `selesai` | Sistem (Final) | Ibu hamil mengonfirmasi terima paket ATAU auto-complete 72 jam tanpa laporan kendala. |
| `kedaluwarsa_hpl` | Sistem (Final) | Tanggal kehamilan telah melewati Hari Perkiraan Lahir (HPL). |

## Aturan Pewaktu (Timer Rules)
1. **Ghosting Auto-Release (48 Jam):**
   - Jika status `dalam_komitmen` dan selisih waktu `NOW() - commitment_created_at > 48 jam` tanpa adanya bukti upload, cron/trigger sistem otomatis mengembalikan status ke `dipublikasikan` dan membatalkan komitmen donatur.
2. **Auto-Complete (72 Jam):**
   - Jika status `menunggu_pengambilan` dan donatur telah menyerahkan ke posyandu, namun ibu hamil tidak menekan tombol terima dan tidak ada `dispute` selama 72 jam, status otomatis menjadi `selesai`.
3. **Pembersihan Kedaluwarsa HPL:**
   - Setiap hari sistem memeriksa pengajuan aktif yang nilai `estimated_birth_date < CURDATE()`. Status diubah menjadi `kedaluwarsa_hpl`.
