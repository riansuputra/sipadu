<?php

class PegawaiModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ----------------------------
    // Ambil semua pegawai
    // ----------------------------
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM pegawai ORDER BY nama_lengkap");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------
    // Simpan pegawai baru
    // ----------------------------
    public function store($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pegawai (nip, nama_lengkap)
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['nip'],
            $data['nama_lengkap']
        ]);
    }
}
