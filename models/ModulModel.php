<?php

class ModulModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Ambil semua modul aktif (untuk dashboard staff)
    public function getAllActive()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM modul
            WHERE is_active = 1
            ORDER BY urutan ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil modul sesuai role (untuk sidebar admin/pimpinan)
    public function getByRole($roleId)
    {
        $stmt = $this->db->prepare("
            SELECT m.*
            FROM modul m
            JOIN modul_role mr ON m.id = mr.modul_id
            WHERE mr.role_id = ?
              AND m.is_active = 1
            ORDER BY m.urutan ASC
        ");
        $stmt->execute([$roleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cek apakah user boleh akses modul
    public function canAccess($roleId, $link)
    {
        $stmt = $this->db->prepare("
            SELECT 1
            FROM modul m
            JOIN modul_role mr ON m.id = mr.modul_id
            WHERE mr.role_id = ?
              AND m.link = ?
        ");
        $stmt->execute([$roleId, $link]);
        return $stmt->fetchColumn() ? true : false;
    }
}
