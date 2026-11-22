<?php
/**
 * Auth & Session Helper
 */

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return isset($_SESSION['user']['id']);
}

function user_role() {
    return $_SESSION['user']['role'] ?? null;
}

function is_admin() {
    return user_role() === 'admin';
}

function is_ibu_hamil() {
    return user_role() === 'ibu_hamil';
}

function is_donatur() {
    return user_role() === 'donatur';
}

function require_auth($allowed_roles = []) {
    if (!is_logged_in()) {
        header("Location: index.php?page=login&msg=silakan_login");
        exit;
    }
    if (!empty($allowed_roles) && !in_array(user_role(), (array)$allowed_roles)) {
        header("Location: index.php?page=unauthorized");
        exit;
    }
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}
