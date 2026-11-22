-- Seed Data for Nurtura Platform
-- Password default semua akun contoh: password123
-- Hash bcrypt: $2y$10$e8w612bI38pDfxG3m3qLhOzZJ2B0h9d/dO/w7eHlT/uWomfS6l8y2

USE `nurtura_db`;

-- 1. Insert Akun Users
-- id 1: Admin NurturaGuard
-- id 2: Ibu Hamil Siti (KEK, LILA 21 cm)
-- id 3: Ibu Hamil Rahma (KEK, LILA 22 cm)
-- id 4: Donatur Budi
INSERT INTO `users` (`id`, `email`, `password_hash`, `role`) VALUES
(1, 'admin@nurtura.local', '$2y$10$e8w612bI38pDfxG3m3qLhOzZJ2B0h9d/dO/w7eHlT/uWomfS6l8y2', 'admin'),
(2, 'ibu.siti@nurtura.local', '$2y$10$e8w612bI38pDfxG3m3qLhOzZJ2B0h9d/dO/w7eHlT/uWomfS6l8y2', 'ibu_hamil'),
(3, 'ibu.rahma@nurtura.local', '$2y$10$e8w612bI38pDfxG3m3qLhOzZJ2B0h9d/dO/w7eHlT/uWomfS6l8y2', 'ibu_hamil'),
(4, 'donatur.budi@nurtura.local', '$2y$10$e8w612bI38pDfxG3m3qLhOzZJ2B0h9d/dO/w7eHlT/uWomfS6l8y2', 'donatur')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- 2. Insert Profil Pengguna
INSERT INTO `profiles` (`id`, `user_id`, `full_name`, `phone_number`, `nik`, `address_private`, `regency_city`, `district`, `gestational_age_weeks`, `estimated_birth_date`, `lila_cm`) VALUES
(1, 1, 'Admin NurturaGuard', '081234567890', '3302010101010001', 'Sekretariat Nurtura Banyumas', 'Banyumas', 'Purwokerto Timur', NULL, NULL, NULL),
(2, 2, 'Siti Aminah', '085711223344', '3302015505960002', 'Jl. Kenanga No. 14 RT 02/03', 'Banyumas', 'Purwokerto Timur', 24, DATE_ADD(CURDATE(), INTERVAL 16 WEEK), 21.0),
(3, 3, 'Rahmawati Dewi', '085899887766', '3302016208980003', 'Desa Karangrau RT 01/02', 'Banyumas', 'Sokaraja', 28, DATE_ADD(CURDATE(), INTERVAL 12 WEEK), 22.0),
(4, 4, 'Budi Santoso', '081987654321', NULL, 'Jl. Overste Isdiman No. 8', 'Banyumas', 'Purwokerto Timur', NULL, NULL, NULL)
ON DUPLICATE KEY UPDATE `full_name` = VALUES(`full_name`);

-- 3. Insert Master Drop-Points (Posyandu / Bidan Desa)
INSERT INTO `drop_points` (`id`, `name`, `officer_in_charge`, `phone_contact`, `address_full`, `regency_city`, `district`, `is_active`) VALUES
(1, 'Posyandu Melati 1 - Purwokerto Timur', 'Bidan Sri Wahyuni, A.Md.Keb', '081399881122', 'Balai RW 03, Kel. Mersi, Kec. Purwokerto Timur', 'Banyumas', 'Purwokerto Timur', 1),
(2, 'Posyandu Mawar Sejahtera - Sokaraja', 'Bidan Endang Lestari, S.Tr.Keb', '081288776655', 'Kompleks Balai Desa Karangrau, Kec. Sokaraja', 'Banyumas', 'Sokaraja', 1),
(3, 'Puskesmas Pembantu (Pustu) Kranji', 'Kader Anisa Putri', '081577665544', 'Jl. Supriyadi No. 45, Kranji, Purwokerto Timur', 'Banyumas', 'Purwokerto Timur', 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 4. Insert Contoh Pengajuan Kebutuhan
INSERT INTO `needs` (`id`, `user_id`, `drop_point_id`, `title`, `description`, `food_items_needed`, `lila_measurement`, `kia_document_path`, `status`, `submitted_at`, `approved_at`) VALUES
(1, 2, 1, 'Kebutuhan Protein & Asam Folat Trimester 2', 'Mengalami mual muntah dan LILA di bawah normal (21 cm). Membutuhkan asupan protein telur dan susu hamil untuk mengejar berat janin.', 'Telur Ayam 2 kg, Susu Ibu Hamil Cokelat 2 Box (400g), Kacang Hijau 1 kg', 21.0, 'sample_kia_siti.jpg', 'dipublikasikan', NOW(), NOW()),
(2, 3, 2, 'Dukungan Paket Gizi Trimester 3 Pencegahan BBLR', 'Hasil periksa posyandu terakhir LILA 22 cm, disarankan bidan desa menambah konsumsi protein hewani secara intensif.', 'Telur Ayam 3 kg, Biskuit Hamil 2 Kaleng, Buah Pisang/Pepaya Lokal', 22.0, 'sample_kia_rahma.jpg', 'menunggu_peninjauan', NOW(), NULL)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);
