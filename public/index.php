<?php
/**
 * Front Controller & Main Router
 * Nurtura Platform - S-Tech Tim Gensoed Novices
 */

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/helpers/cron_helper.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/NeedController.php';
require_once __DIR__ . '/../app/controllers/DonationController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

// Jalankan otomatis pemeriksaan state machine background (Auto-Release 48 Jam & Auto-Complete 72 Jam & HPL)
try {
    run_lifecycle_checks();
} catch (Exception $e) {
    // Abaikan jika database belum di-setup di request pertama
}

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

// Routing Berdasarkan Action (POST / Direct Trigger)
if ($action !== null) {
    switch ($action) {
        case 'logout':
            AuthController::logout();
            break;
        case 'commit-donation':
            DonationController::commit();
            break;
        case 'upload-proof':
            DonationController::upload_proof();
            break;
        case 'confirm-received':
            DonationController::confirm_received();
            break;
        case 'dispute':
            DonationController::dispute();
            break;
        case 'admin-update-status':
            AdminController::update_status();
            break;
        case 'view-kia':
            AdminController::view_kia();
            break;
        default:
            http_response_code(404);
            die("Aksi tidak ditemukan.");
    }
    exit;
}

// Routing Berdasarkan Halaman (GET / View Controller)
switch ($page) {
    case 'home':
        require_once __DIR__ . '/../views/public/home.php';
        break;
    case 'explore':
        NeedController::explore();
        break;
    case 'need-detail':
        NeedController::detail();
        break;
    case 'login':
        AuthController::login();
        break;
    case 'register':
        AuthController::register();
        break;
    case 'ibu-hamil-dashboard':
        NeedController::ibu_hamil_dashboard();
        break;
    case 'create-need':
        NeedController::create();
        break;
    case 'donatur-dashboard':
        DonationController::donatur_dashboard();
        break;
    case 'admin-dashboard':
        AdminController::dashboard();
        break;
    case 'unauthorized':
        http_response_code(403);
        echo "<div style='font-family:sans-serif; text-align:center; padding:50px;'><h1>403 Akses Ditolak</h1><p>Anda tidak memiliki izin untuk mengakses halaman ini.</p><a href='index.php?page=home'>Kembali ke Beranda</a></div>";
        break;
    default:
        http_response_code(404);
        echo "<div style='font-family:sans-serif; text-align:center; padding:50px;'><h1>404 Halaman Tidak Ditemukan</h1><a href='index.php?page=home'>Kembali ke Beranda</a></div>";
        break;
}
