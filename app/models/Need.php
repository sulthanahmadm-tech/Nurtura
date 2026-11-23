<?php
/**
 * Need Model (NurturaNeeds & Lifecycle)
 */

require_once __DIR__ . '/../../config/database.php';

class Need {
    public static function create($user_id, $data) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("
            INSERT INTO needs (user_id, drop_point_id, title, description, food_items_needed, lila_measurement, kia_document_path, status, submitted_at)
            VALUES (:user_id, :drop_point_id, :title, :description, :food_items_needed, :lila_measurement, :kia_document_path, 'menunggu_peninjauan', NOW())
        ");
        $stmt->execute([
            ':user_id'           => $user_id,
            ':drop_point_id'     => $data['drop_point_id'],
            ':title'             => $data['title'],
            ':description'       => $data['description'],
            ':food_items_needed' => $data['food_items_needed'],
            ':lila_measurement'  => $data['lila_measurement'],
            ':kia_document_path' => $data['kia_document_path'],
        ]);
        return $pdo->lastInsertId();
    }

    public static function get_by_user($user_id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("
            SELECT n.*, dp.name AS drop_point_name, dp.address_full AS drop_point_address
            FROM needs n
            JOIN drop_points dp ON n.drop_point_id = dp.id
            WHERE n.user_id = :user_id
            ORDER BY n.created_at DESC
        ");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public static function get_published_list() {
        $pdo = get_db_connection();
        $stmt = $pdo->query("
            SELECT n.*, p.district, p.regency_city, dp.name AS drop_point_name, dp.district AS drop_point_district
            FROM needs n
            JOIN profiles p ON n.user_id = p.user_id
            JOIN drop_points dp ON n.drop_point_id = dp.id
            WHERE n.status = 'dipublikasikan'
            ORDER BY n.submitted_at DESC
        ");
        return $stmt->fetchAll();
    }

    public static function find_by_id($id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("
            SELECT n.*, p.full_name, p.district, p.regency_city, p.gestational_age_weeks, p.estimated_birth_date,
                   dp.name AS drop_point_name, dp.officer_in_charge, dp.phone_contact AS drop_point_phone, dp.address_full AS drop_point_address
            FROM needs n
            JOIN profiles p ON n.user_id = p.user_id
            JOIN drop_points dp ON n.drop_point_id = dp.id
            WHERE n.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function get_pending_review_admin() {
        $pdo = get_db_connection();
        $stmt = $pdo->query("
            SELECT n.*, p.full_name, p.phone_number, p.district, dp.name AS drop_point_name
            FROM needs n
            JOIN profiles p ON n.user_id = p.user_id
            JOIN drop_points dp ON n.drop_point_id = dp.id
            WHERE n.status = 'menunggu_peninjauan'
            ORDER BY n.submitted_at ASC
        ");
        return $stmt->fetchAll();
    }

    
    public static function update_status_admin($id, $status, $admin_notes = null) {
        $pdo = get_db_connection();

        $stmt = $pdo->prepare("
            UPDATE needs
            SET status = :status,
                admin_notes = :admin_notes,
                approved_at = IF(:approved_status = 'dipublikasikan', NOW(), approved_at)
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id'               => $id,
            ':status'           => $status,
            ':admin_notes'      => $admin_notes,
            ':approved_status'  => $status,
        ]);
    }

    // Mengambil seluruh laporan kendala untuk Dashboard Admin
    public static function get_disputes_admin() {
        $pdo = get_db_connection();

        $stmt = $pdo->query("
            SELECT
                d.id AS dispute_id,
                d.need_id,
                d.reason,
                d.status,
                d.admin_notes AS dispute_admin_notes,
                d.created_at AS dispute_created_at,
                p.full_name AS reporter_name,
                p.phone_number AS reporter_phone,
                n.title AS need_title,
                dp.name AS drop_point_name
            FROM disputes d
            JOIN needs n ON d.need_id = n.id
            JOIN profiles p ON d.reporter_user_id = p.user_id
            JOIN drop_points dp ON n.drop_point_id = dp.id
            ORDER BY
                CASE d.status
                    WHEN 'open' THEN 1
                    WHEN 'under_review' THEN 2
                    WHEN 'resolved' THEN 3
                    WHEN 'rejected' THEN 4
                END,
                d.created_at DESC
        ");

        return $stmt->fetchAll();
    }

    // Memperbarui status penanganan laporan kendala
    
    public static function update_dispute_status($dispute_id, $status, $admin_notes = null) {
        $pdo = get_db_connection();

        try {
            $pdo->beginTransaction();

            // Perbarui status laporan kendala
            $stmt = $pdo->prepare("
                UPDATE disputes
                SET status = :status,
                    admin_notes = :admin_notes,
                    resolved_at = CASE
                        WHEN :resolved_status IN ('resolved', 'rejected')
                        THEN NOW()
                        ELSE NULL
                    END
                WHERE id = :dispute_id
            ");

            $stmt->execute([
                ':status' => $status,
                ':admin_notes' => $admin_notes,
                ':resolved_status' => $status,
                ':dispute_id' => $dispute_id
            ]);

            // Jika laporan selesai atau ditolak,
            // kembalikan status bantuan seperti semula
            if (in_array($status, ['resolved', 'rejected'], true)) {
                $stmt = $pdo->prepare("
                    UPDATE needs
                    SET status = 'menunggu_pengambilan'
                    WHERE id = (
                        SELECT need_id
                        FROM disputes
                        WHERE id = :dispute_id
                    )
                ");

                $stmt->execute([
                    ':dispute_id' => $dispute_id
                ]);
            }

            $pdo->commit();
            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }


}
