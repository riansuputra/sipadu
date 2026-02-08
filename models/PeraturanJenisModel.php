<?php

class PeraturanJenisModel
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
            SELECT * FROM peraturan_jenis
            WHERE peraturan_jenis.is_active = 1
            ORDER BY nama ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM peraturan_jenis
            WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // simpan
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO peraturan_jenis (
                kode, 
                nama, 
                keterangan, 
                is_active
            ) VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['keterangan'],
            $data['is_active']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE peraturan_jenis SET
                kode = ?, 
                nama = ?, 
                keterangan = ?, 
                is_active = ? 
            WHERE id = ? 
        ");

        return $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['keterangan'],
            $data['is_active'],
            $id
        ]);
    }

    public function isUsed($id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM peraturan 
        WHERE jenis_id = ?
    ");

        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }


    // hapus
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE peraturan_jenis SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}
