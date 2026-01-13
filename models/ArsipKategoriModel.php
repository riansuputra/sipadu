<?php

class ArsipKategoriModel
{
    protected $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ambil semua
    public function getAll()
    {
        return $this->db->query("
            SELECT * FROM arsip_kategori
            ORDER BY nama ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip_kategori
            WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // simpan
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO arsip_kategori (
                nama_kategori,
                is_global
            ) VALUES (?, ?)
        ");

        $stmt->execute([
            $data['nama_kategori'],
            $data['is_global'],
        ]);

        return $this->db->lastInsertId();
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("
            UPDATE arsip_kategori SET
                nama_kategori = ?,
                is_global = ?
            ) VALUES (?, ?)
        ");

        return $stmt->execute([
            $data['nama_kategori'],
            $data['is_global'],
        ]);
    }

    public function isUsed($id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM arsip 
        WHERE kategori_id = ?
    ");

        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }


    // hapus
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE arsip_kategori SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}
