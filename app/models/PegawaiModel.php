<?php

class PegawaiModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT p.*, wg.group_name AS nama_pokja
            FROM pegawai p
            LEFT JOIN work_groups wg ON p.work_group_id = wg.id
            WHERE p.is_active = 1
            ORDER BY p.nama_lengkap
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pegawai WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
