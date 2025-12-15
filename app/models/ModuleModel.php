<?php

class ModuleModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // 🔐 Cek akses halaman berdasarkan role_code
    public function userHasAccess($roleCode, $page)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM modules m
            JOIN module_roles mr ON m.id = mr.module_id
            JOIN roles r ON mr.role_id = r.id
            WHERE r.role_code = ?
              AND m.link = ?
              AND m.is_active = 1
        ");
        $stmt->execute([$roleCode, $page]);

        return $stmt->fetchColumn() > 0;
    }

    // 🧩 Ambil module untuk card / sidebar
    public function getModulesByRole($roleCode)
    {
        $stmt = $this->db->prepare("
            SELECT m.*
            FROM modules m
            JOIN module_roles mr ON m.id = mr.module_id
            JOIN roles r ON mr.role_id = r.id
            WHERE r.role_code = ?
              AND m.is_active = 1
            ORDER BY m.sort_order ASC
        ");
        $stmt->execute([$roleCode]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
