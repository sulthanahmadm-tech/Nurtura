<?php
/**
 * Donation Controller (NurturaGive)
 */

require_once __DIR__ . '/../models/Donation.php';
require_once __DIR__ . '/../models/Need.php';
require_once __DIR__ . '/../helpers/auth_helper.php';
require_once __DIR__ . '/../helpers/format_helper.php';
require_once __DIR__ . '/../../config/app.php';

class DonationController {
    public static function donatur_dashboard() {
        require_auth(['donatur']);
        $donor_id = current_user()['id'];
        $commitments = Donation::get_active_by_donor($donor_id);
        require_once __DIR__ . '/../../views/donatur/dashboard.php';
    }

    public static function commit() {
        require_auth(['donatur']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $need_id = (int)($_POST['need_id'] ?? 0);
            $donor_id = current_user()['id'];

            $res = Donation::create_commitment($need_id, $donor_id);
            if ($res) {
                header("Location: index.php?page=donatur-dashboard&msg=komitmen_berhasil");
                exit;
            } else {
                header("Location: index.php?page=explore&error=kebutuhan_sudah_diambil_orang_lain");
                exit;
            }
        }
    }

    public static function upload_proof() {
        require_auth(['donatur']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $donation_id = (int)($_POST['donation_id'] ?? 0);
            $donor_id = current_user()['id'];
            $notes = trim($_POST['donor_notes'] ?? '');

            if ($donation_id > 0 && isset($_FILES['proof_file']) && $_FILES['proof_file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['proof_file'];
                $allowed_mimes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if (!isset($allowed_mimes[$mime]) || $file['size'] > 5 * 1024 * 1024) {
                    header("Location: index.php?page=donatur-dashboard&error=gagal_unggah_bukti");
                    exit;
                }

                $ext = $allowed_mimes[$mime];
                $proof_filename = 'proof_' . $donation_id . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $destination = PROOF_UPLOAD_DIR . '/' . $proof_filename;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $updated = Donation::upload_proof($donation_id, $donor_id, $proof_filename, $notes);
                    if ($updated) {
                        header("Location: index.php?page=donatur-dashboard&msg=bukti_terunggah");
                        exit;
                    }
                    @unlink($destination);
                }
            }
            header("Location: index.php?page=donatur-dashboard&error=gagal_unggah_bukti");
            exit;
        }
    }

    public static function confirm_received() {
        require_auth(['ibu_hamil']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $need_id = (int)($_POST['need_id'] ?? 0);
            $mother_id = current_user()['id'];

            $ok = Donation::confirm_received_by_mother($need_id, $mother_id);
            if ($ok) {
                header("Location: index.php?page=ibu-hamil-dashboard&msg=bantuan_selesai");
            } else {
                header("Location: index.php?page=ibu-hamil-dashboard&error=gagal_konfirmasi");
            }
            exit;
        }
    }

    public static function dispute() {
        require_auth(['ibu_hamil']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                die("CSRF Token tidak valid!");
            }
            $need_id = (int)($_POST['need_id'] ?? 0);
            $reason = trim($_POST['reason'] ?? '');
            $mother_id = current_user()['id'];

            if (!empty($reason)) {
                Donation::create_dispute($need_id, $mother_id, $reason);
                header("Location: index.php?page=ibu-hamil-dashboard&msg=dispute_diajukan");
                exit;
            }
            header("Location: index.php?page=ibu-hamil-dashboard&error=alasan_wajib_diisi");
            exit;
        }
    }
}
