# PRODUCT REQUIREMENTS DOCUMENT (REVISI FINAL)
## Nurtura: Platform Dukungan Gizi Ibu Hamil Berbasis Komunitas & Posyandu Drop-Point untuk Pencegahan Stunting

**Tim:** S-Tech Tim Gensoed Novices  
**Tema:** Ketahanan Pangan  
**Sub-Tema:** Nutrition & Household Security (Konsumsi & Kesehatan Keluarga)  
**Tagline:** *Nurturing Mothers, Nourishing Futures.*  

---

### 1. Latar Belakang & Pernyataan Masalah
Prevalensi stunting di Indonesia masih menjadi tantangan kesehatan prioritas (19,8% berdasarkan survei nasional). Periode 1.000 Hari Pertama Kehidupan (HPK)—khususnya masa kehamilan—merupakan jendela kritis pencegahan stunting. Ibu hamil dengan kondisi Kurang Energi Kronis (KEK, ditandai dengan Lingkar Lengan Atas / LILA < 23,5 cm) memiliki risiko tinggi melahirkan bayi dengan Berat Badan Lahir Rendah (BBLR) yang menjadi faktor utama stunting.

**Masalah Nyata:**
1. Banyak ibu hamil dari keluarga rentan kesulitan menjangkau pangan bergizi tinggi (protein hewani: telur, susu hamil, ikan/daging).
2. Masyarakat dan donatur memiliki kepedulian untuk berbagi, namun khawatir salah sasaran atau tidak mengetahui siapa yang benar-benar membutuhkan di lingkungan sekitarnya.
3. Ketiadaan saluran komunikasi terverifikasi yang aman, yang menjembatani donatur dengan penerima tanpa melanggar privasi ibu hamil dan tanpa memerlukan izin perbankan/dompet digital yang rumit.

---

### 2. Solusi Produk & Batasan Ruang Lingkup
**Nurtura** adalah platform web yang menghubungkan ibu hamil berisiko KEK dengan donatur masyarakat melalui sistem verifikasi medis Buku KIA dan titik penyaluran aman (**Posyandu / Bidan Desa Drop-Point**).

**Prinsip & Batasan Kunci:**
* **Bukan Dompet Digital:** Nurtura tidak mengelola uang kas donasi. Donatur berpartisipasi dengan membelikan dan mengirimkan langsung paket pangan bergizi.
* **Perlindungan Privasi Total (Zero PII Leakage):** Alamat rumah dan nomor kontak pribadi ibu hamil tidak pernah dipublikasikan. Paket dikirimkan ke Posyandu mitra di wilayah tempat tinggal ibu hamil.
* **Verifikasi Medis Objektif:** Kelayakan penerima divalidasi oleh Admin NurturaGuard berdasarkan lembar pemeriksaan Buku KIA resmi (indikator LILA < 23,5 cm), bukan sekadar klaim subjektif.

---

### 3. Arsitektur Aktor & Alur Pengguna

#### Aktor 1: Ibu Hamil (Pengaju Kebutuhan)
1. Mendaftar akun dengan nomor telepon/email dan data domisili.
2. Memilih Posyandu / Bidan Desa terdekat sebagai drop-point resmi.
3. Mengisi formulir kebutuhan gizi (paket telur, susu, kacang hijau, multivitamin) dan melampirkan foto Buku KIA (halaman LILA & HPL).
4. Menunggu verifikasi admin NurturaGuard.
5. Mendapat notifikasi saat donatur telah mengirim paket ke Posyandu.
6. Mengambil paket di Posyandu dan melakukan konfirmasi penerimaan di web (atau melapor jika ada ketidaksesuaian/dispute).

#### Aktor 2: Donatur (Pemberi Dukungan)
1. Menjelajahi katalog kebutuhan terverifikasi publik (`Explore Needs`). Identitas ibu hamil disamarkan.
2. Memilih pengajuan dan menekan tombol **"Bantu Kebutuhan Ini"**.
3. Sistem mengunci pengajuan selama **48 Jam** (*Lock-Timer*).
4. Donatur mengirim/menyerahkan paket pangan ke alamat Posyandu mitra yang tertera.
5. Donatur mengunggah foto bukti penyerahan/resi di halaman dashboard.

#### Aktor 3: Admin (NurturaGuard)
1. Memeriksa keabsahan foto Buku KIA dan angka LILA.
2. Menyetujui pengajuan (beralih ke status `dipublikasikan`) atau meminta revisi foto yang buram.
3. Memantau timer komitmen donatur (sistem otomatis membatalkan jika donatur ghosting > 48 jam).
4. Menangani laporan kendala (dispute) dari ibu hamil atau posyandu.

---

### 4. Spesifikasi Siklus Status Pengajuan (State Machine)
- `draf`: Tersimpan di sisi ibu hamil.
- `menunggu_peninjauan`: Telah dikirim ke admin beserta berkas Buku KIA.
- `perlu_perbaikan`: Draf dikembalikan admin untuk revisi foto/data (tenggat 7 hari).
- `ditolak`: Ditolak admin karena manipulasi data atau tidak memenuhi kriteria medis.
- `dipublikasikan`: Tayang di katalog publik, siap diambil donatur.
- `dalam_komitmen`: Dikunci oleh 1 donatur selama maksimal 48 jam.
- `menunggu_pengambilan`: Donatur telah mengunggah bukti serah terima posyandu.
- `selesai`: Ibu hamil konfirmasi terima ATAU auto-complete setelah 72 jam tanpa laporan kendala.
- `dispute`: Ibu hamil melapor paket bermasalah/fiktif, menunggu penanganan admin.
- `kedaluwarsa_hpl`: Pengajuan otomatis ditutup jika tanggal taksiran melahirkan telah lewat.

---

### 5. Metrik Keberhasilan MVP
1. **Response Time Verifikasi:** Waktu rata-rata admin memvalidasi Buku KIA < 24 jam.
2. **Realisasi Bantuan:** Rasio pengajuan `dipublikasikan` yang mencapai status `selesai`.
3. **Zero Ghosting Rate:** Tidak ada pengajuan yang terkunci permanen akibat donatur mangkir (teratasi 100% oleh mekanisme auto-release 48 jam).
4. **Keamanan Privasi:** 0 insiden kebocoran alamat rumah ibu hamil ke publik.
