<?php

class JenisPeraturanModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ambil semua
    public function getAll()
    {
        return $this->db->query("
            SELECT * FROM jenis_peraturan
            ORDER BY nama ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    // simpan
    public function store($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jenis_peraturan
            (kode, nama, keterangan, is_active)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['keterangan'],
            $data['is_active']
        ]);
    }

    // hapus
    public function delete($id)
    {
        return $this->db
            ->prepare("DELETE FROM jenis_peraturan WHERE id = ?")
            ->execute([$id]);
    }
}
