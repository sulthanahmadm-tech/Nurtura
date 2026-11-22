<?php
/**
 * DropPoint Model (Posyandu & Bidan Desa Mitra)
 */

require_once __DIR__ . '/../../config/database.php';

class DropPoint {
    public static function all_active() {
        $pdo = get_db_connection();
        $stmt = $pdo->query("SELECT * FROM drop_points WHERE is_active = 1 ORDER BY district ASC, name ASC");
        return $stmt->fetchAll();
    }

    public static function find_by_id($id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM drop_points WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
