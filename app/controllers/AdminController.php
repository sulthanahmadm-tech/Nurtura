<?php
/**
 * Admin Controller (NurturaGuard)
 */

require_once __DIR__ . '/../models/Need.php';
require_once __DIR__ . '/../helpers/auth_helper.php';
require_once __DIR__ . '/../helpers/format_helper.php';
require_once __DIR__ . '/../../config/app.php';

class AdminController {
    
    public static function dashboard() {
        require_auth(['admin']);

        $pending_needs = Need::get_pending_review_admin();
        $disputes = Need::get_disputes_admin();

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }


    public static function update_status() {
        require_auth(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $need_id = (int)($_POST['need_id'] ?? 0);
            $action = $_POST['action'] ?? '';
            $notes = trim($_POST['admin_notes'] ?? '');

            if ($action === 'approve') {
                Need::update_status_admin($need_id, 'dipublikasikan', $notes);
            } elseif ($action === 'revision') {
                Need::update_status_admin($need_id, 'perlu_perbaikan', $notes);
            } elseif ($action === 'reject') {
                Need::update_status_admin($need_id, 'ditolak', $notes);
            }

            header("Location: index.php?page=admin-dashboard&msg=status_diperbarui");
            exit;
        }
    }

    public static function update_dispute() {
        require_auth(['admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode tidak diizinkan.');
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            die("CSRF Token tidak valid!");
        }

        $dispute_id = (int)($_POST['dispute_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $notes = trim($_POST['admin_notes'] ?? '');

        $allowed_statuses = [
            'under_review',
            'resolved',
            'rejected'
        ];

        if ($dispute_id <= 0 || !in_array($status, $allowed_statuses, true)) {
            header("Location: index.php?page=admin-dashboard&error=dispute_invalid");
            exit;
        }

        // Proteksi: laporan yang sudah selesai (resolved/rejected) tidak dapat diubah kembali
        $pdo = get_db_connection();
        $checkStmt = $pdo->prepare("SELECT status FROM disputes WHERE id = :id LIMIT 1");
        $checkStmt->execute([':id' => $dispute_id]);
        $existingDispute = $checkStmt->fetch();
        if (!$existingDispute || in_array($existingDispute['status'], ['resolved', 'rejected'], true)) {
            header("Location: index.php?page=admin-dashboard&error=dispute_locked");
            exit;
        }

        Need::update_dispute_status($dispute_id, $status, $notes);

        header("Location: index.php?page=admin-dashboard&msg=dispute_diperbarui");
        exit;
    }


    // Endpoint aman untuk membaca dokumen KIA yang diisolasi di folder privat
    public static function view_kia() {
        require_auth(['admin']);
        $filename = basename($_GET['file'] ?? '');
        $path = KIA_UPLOAD_DIR . '/' . $filename;

        if (empty($filename) || !file_exists($path)) {
            http_response_code(404);
            die("Berkas Buku KIA tidak ditemukan.");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path);
        finfo_close($finfo);

        header("Content-Type: " . $mime);
        header("Content-Disposition: inline; filename=\"" . $filename . "\"");
        header("Content-Length: " . filesize($path));
        readfile($path);
        exit;
    }
}
