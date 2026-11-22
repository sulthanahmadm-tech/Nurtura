<?php
/**
 * User & Profile Model
 */

require_once __DIR__ . '/../../config/database.php';

class User {
    public static function find_by_email($email) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public static function find_by_id($id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function get_profile($user_id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = :user_id LIMIT 1");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch();
    }

    public static function register($email, $password, $role, $profile_data) {
        $pdo = get_db_connection();
        $pdo->beginTransaction();
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, role) VALUES (:email, :hash, :role)");
            $stmt->execute([
                ':email' => $email,
                ':hash'  => $hash,
                ':role'  => $role,
            ]);
            $user_id = $pdo->lastInsertId();

            $stmtProf = $pdo->prepare("
                INSERT INTO profiles (user_id, full_name, phone_number, nik, address_private, regency_city, district, gestational_age_weeks, estimated_birth_date, lila_cm)
                VALUES (:user_id, :full_name, :phone_number, :nik, :address_private, :regency_city, :district, :gestational_age_weeks, :estimated_birth_date, :lila_cm)
            ");
            $stmtProf->execute([
                ':user_id'               => $user_id,
                ':full_name'             => $profile_data['full_name'],
                ':phone_number'          => $profile_data['phone_number'],
                ':nik'                   => $profile_data['nik'] ?? null,
                ':address_private'       => $profile_data['address_private'] ?? null,
                ':regency_city'          => $profile_data['regency_city'] ?? 'Banyumas',
                ':district'              => $profile_data['district'] ?? 'Purwokerto Timur',
                ':gestational_age_weeks' => $profile_data['gestational_age_weeks'] ?? null,
                ':estimated_birth_date'  => $profile_data['estimated_birth_date'] ?? null,
                ':lila_cm'               => $profile_data['lila_cm'] ?? null,
            ]);

            $pdo->commit();
            return $user_id;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
