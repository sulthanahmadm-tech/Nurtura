-- Database Schema for Nurtura Platform
-- Compatible with MySQL 5.7+ / 8.0+ & MariaDB (phpMyAdmin)

CREATE DATABASE IF NOT EXISTS `nurtura_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nurtura_db`;

-- 1. Tabel Users (Akun Otentikasi)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('ibu_hamil', 'donatur', 'admin') NOT NULL DEFAULT 'ibu_hamil',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel Profiles (Biodata Pengguna)
CREATE TABLE IF NOT EXISTS `profiles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL UNIQUE,
    `full_name` VARCHAR(150) NOT NULL,
    `phone_number` VARCHAR(30) NOT NULL,
    `nik` VARCHAR(30) NULL,
    `address_private` TEXT NULL,
    `regency_city` VARCHAR(100) NOT NULL DEFAULT 'Banyumas',
    `district` VARCHAR(100) NOT NULL DEFAULT 'Purwokerto Timur',
    `gestational_age_weeks` INT UNSIGNED NULL,
    `estimated_birth_date` DATE NULL,
    `lila_cm` DECIMAL(4, 1) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Drop-Points (Posyandu & Bidan Desa Mitra)
CREATE TABLE IF NOT EXISTS `drop_points` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `officer_in_charge` VARCHAR(100) NOT NULL,
    `phone_contact` VARCHAR(30) NOT NULL,
    `address_full` TEXT NOT NULL,
    `regency_city` VARCHAR(100) NOT NULL DEFAULT 'Banyumas',
    `district` VARCHAR(100) NOT NULL DEFAULT 'Purwokerto Timur',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Needs (Pengajuan Kebutuhan Gizi Ibu Hamil)
CREATE TABLE IF NOT EXISTS `needs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `drop_point_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT NOT NULL,
    `food_items_needed` TEXT NOT NULL,
    `lila_measurement` DECIMAL(4, 1) NOT NULL,
    `kia_document_path` VARCHAR(255) NULL,
    `status` ENUM(
        'draf',
        'menunggu_peninjauan',
        'perlu_perbaikan',
        'ditolak',
        'dipublikasikan',
        'dalam_komitmen',
        'menunggu_pengambilan',
        'dispute',
        'selesai',
        'kedaluwarsa_hpl'
    ) NOT NULL DEFAULT 'draf',
    `admin_notes` TEXT NULL,
    `submitted_at` DATETIME NULL,
    `approved_at` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_needs_status` (`status`),
    INDEX `idx_needs_drop_point` (`drop_point_id`),
    CONSTRAINT `fk_needs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_needs_drop_point` FOREIGN KEY (`drop_point_id`) REFERENCES `drop_points` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel Donations (Komitmen Donatur & Bukti Serah Terima)
CREATE TABLE IF NOT EXISTS `donations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `need_id` INT UNSIGNED NOT NULL,
    `donor_user_id` INT UNSIGNED NOT NULL,
    `committed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `lock_expires_at` DATETIME NOT NULL,
    `proof_of_drop_path` VARCHAR(255) NULL,
    `donor_notes` TEXT NULL,
    `status` ENUM('committed', 'proof_uploaded', 'completed', 'cancelled_ghosting') NOT NULL DEFAULT 'committed',
    `proof_uploaded_at` DATETIME NULL,
    `completed_at` DATETIME NULL,
    INDEX `idx_donations_status` (`status`),
    CONSTRAINT `fk_donations_need` FOREIGN KEY (`need_id`) REFERENCES `needs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_donations_donor` FOREIGN KEY (`donor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel Disputes (Laporan Kendala / Sengketa Paket Bantuan)
CREATE TABLE IF NOT EXISTS `disputes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `need_id` INT UNSIGNED NOT NULL,
    `reporter_user_id` INT UNSIGNED NOT NULL,
    `reason` TEXT NOT NULL,
    `evidence_photo_path` VARCHAR(255) NULL,
    `status` ENUM('open', 'under_review', 'resolved', 'rejected') NOT NULL DEFAULT 'open',
    `admin_notes` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `resolved_at` DATETIME NULL,
    CONSTRAINT `fk_disputes_need` FOREIGN KEY (`need_id`) REFERENCES `needs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_disputes_reporter` FOREIGN KEY (`reporter_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel Activity Logs (Audit Trail Sistem)
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NULL,
    `action` VARCHAR(100) NOT NULL,
    `details` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
