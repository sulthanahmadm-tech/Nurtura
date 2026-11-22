<?php
/**
 * Need Controller (NurturaNeeds)
 */

require_once __DIR__ . '/../models/Need.php';
require_once __DIR__ . '/../models/DropPoint.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth_helper.php';
require_once __DIR__ . '/../helpers/format_helper.php';
require_once __DIR__ . '/../../config/app.php';

class NeedController {
    public static function explore() {
        $needs = Need::get_published_list();
        require_once __DIR__ . '/../../views/public/explore_needs.php';
    }

    public static function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $need = Need::find_by_id($id);
        if (!$need) {
            die("Kebutuhan tidak ditemukan.");
        }
        require_once __DIR__ . '/../../views/public/need_detail.php';
    }

    public static function ibu_hamil_dashboard() {
        require_auth(['ibu_hamil']);
        $user_id = current_user()['id'];
        $needs = Need::get_by_user($user_id);
        $profile = User::get_profile($user_id);
        require_once __DIR__ . '/../../views/ibu_hamil/dashboard.php';
    }

    public static function create() {
        require_auth(['ibu_hamil']);
        $drop_points = DropPoint::all_active();
        $user_id = current_user()['id'];
        $profile = User::get_profile($user_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }

            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $food_items = trim($_POST['food_items_needed'] ?? '');
            $drop_point_id = (int)($_POST['drop_point_id'] ?? 0);
            $lila = (float)($_POST['lila_measurement'] ?? 0);

            if (empty($title) || empty($description) || empty($food_items) || $drop_point_id <= 0 || $lila <= 0) {
                $error = "Semua kolom wajib diisi!";
                require_once __DIR__ . '/../../views/ibu_hamil/create_need.php';
                return;
            }

            // Validasi & Simpan Dokumen Buku KIA
            $kia_filename = null;
            if (isset($_FILES['kia_document']) && $_FILES['kia_document']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['kia_document'];
                $allowed_mimes = ['image/jpeg', 'image/png', 'application/pdf'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowed_mimes)) {
                    $error = "Format berkas KIA harus berupa JPG, PNG, atau PDF!";
                    require_once __DIR__ . '/../../views/ibu_hamil/create_need.php';
                    return;
                }

                if ($file['size'] > 3 * 1024 * 1024) {
                    $error = "Ukuran berkas KIA maksimal 3 MB!";
                    require_once __DIR__ . '/../../views/ibu_hamil/create_need.php';
                    return;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $kia_filename = 'kia_' . $user_id . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $destination = KIA_UPLOAD_DIR . '/' . $kia_filename;

                if (!move_uploaded_file($file['tmp_name'], $destination)) {
                    $error = "Gagal mengunggah berkas Buku KIA!";
                    require_once __DIR__ . '/../../views/ibu_hamil/create_need.php';
                    return;
                }
            } else {
                $error = "Foto lembar Buku KIA (data LILA & kehamilan) wajib dilampirkan untuk verifikasi medis!";
                require_once __DIR__ . '/../../views/ibu_hamil/create_need.php';
                return;
            }

            Need::create($user_id, [
                'drop_point_id'     => $drop_point_id,
                'title'             => $title,
                'description'       => $description,
                'food_items_needed' => $food_items,
                'lila_measurement'  => $lila,
                'kia_document_path' => $kia_filename,
            ]);

            header("Location: index.php?page=ibu-hamil-dashboard&msg=pengajuan_berhasil");
            exit;
        }

        require_once __DIR__ . '/../../views/ibu_hamil/create_need.php';
    }
}
