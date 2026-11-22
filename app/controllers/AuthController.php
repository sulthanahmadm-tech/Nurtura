<?php
/**
 * Auth Controller
 */

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth_helper.php';

class AuthController {
    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $user = User::find_by_email($email);
            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $profile = User::get_profile($user['id']);
                $_SESSION['user'] = [
                    'id'        => $user['id'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'full_name' => $profile['full_name'] ?? 'Pengguna',
                ];

                if ($user['role'] === 'admin') {
                    header("Location: index.php?page=admin-dashboard");
                } elseif ($user['role'] === 'ibu_hamil') {
                    header("Location: index.php?page=ibu-hamil-dashboard");
                } else {
                    header("Location: index.php?page=donatur-dashboard");
                }
                exit;
            } else {
                $error = "Email atau kata sandi salah!";
                require_once __DIR__ . '/../../views/auth/login.php';
                return;
            }
        }
        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $role = in_array($_POST['role'], ['ibu_hamil', 'donatur']) ? $_POST['role'] : 'ibu_hamil';
            $full_name = trim($_POST['full_name'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');

            if (empty($email) || empty($password) || empty($full_name) || empty($phone_number)) {
                $error = "Semua kolom wajib diisi!";
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            if (User::find_by_email($email)) {
                $error = "Email sudah terdaftar!";
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            $profile_data = [
                'full_name'             => $full_name,
                'phone_number'          => $phone_number,
                'regency_city'          => trim($_POST['regency_city'] ?? 'Banyumas'),
                'district'              => trim($_POST['district'] ?? 'Purwokerto Timur'),
                'gestational_age_weeks' => !empty($_POST['gestational_age_weeks']) ? (int)$_POST['gestational_age_weeks'] : null,
                'estimated_birth_date'  => !empty($_POST['estimated_birth_date']) ? $_POST['estimated_birth_date'] : null,
                'lila_cm'               => !empty($_POST['lila_cm']) ? (float)$_POST['lila_cm'] : null,
            ];

            try {
                User::register($email, $password, $role, $profile_data);
                header("Location: index.php?page=login&msg=registrasi_sukses");
                exit;
            } catch (Exception $e) {
                $error = "Gagal mendaftar: " . $e->getMessage();
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }
        }
        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public static function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: index.php?page=home&msg=logout_sukses");
        exit;
    }
}
