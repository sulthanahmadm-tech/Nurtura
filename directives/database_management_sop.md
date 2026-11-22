# SOP 04: Manajemen Database MySQL & phpMyAdmin

## Konvensi Database
- Nama Database: `nurtura_db`
- Character Set: `utf8mb4`
- Collation: `utf8mb4_unicode_ci`
- Engine Tabel: `InnoDB` (mendukung Foreign Key dan Transaksi ACID).

## Langkah Import ke phpMyAdmin
1. Buka peramban dan akses `http://localhost/phpmyadmin/`.
2. Buat database baru bernama `nurtura_db` dengan collation `utf8mb4_unicode_ci`.
3. Klik tab **Import** pada database `nurtura_db`.
4. Pilih file `database/schema.sql`, lalu klik tombol **Go / Kirim**.
5. Ulangi langkah import untuk file `database/seed.sql` untuk mengisi data dummy awal (admin, akun pengujian, dan posyandu mitra).

## Aturan Penulisan Query di PHP (Pencegahan SQL Injection)
- Dilarang keras menggabungkan variabel string langsung ke query SQL (contoh salah: `"SELECT * FROM users WHERE email = '$email'"`).
- Wajib menggunakan **PDO Prepared Statements** dengan placeholder bernama atau tanda tanya:
  ```php
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
  $stmt->execute([':email' => $email]);
  $user = $stmt->fetch();
  ```
- Operasi multi-tabel yang krusial (misal: donatur komitmen yang mengubah status `needs` dan memasukkan baris baru di `donations`) wajib dibungkus dalam blok transaksi:
  ```php
  $pdo->beginTransaction();
  try {
      // update need status
      // insert donation
      $pdo->commit();
  } catch (\Exception $e) {
      $pdo->rollBack();
      throw $e;
  }
  ```
