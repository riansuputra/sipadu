<?php

class PeraturanModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ==========================
    // LIST
    // ==========================
    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT p.*, j.nama as jenis
            FROM peraturan p
            LEFT JOIN jenis_peraturan j ON p.jenis_id = j.id
            ORDER BY p.created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // DETAIL
    // ==========================
    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, j.nama as jenis
            FROM peraturan p
            LEFT JOIN jenis_peraturan j ON p.jenis_id = j.id
            WHERE p.id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFiles($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM peraturan_file
            WHERE peraturan_id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // STORE
    // ==========================
    public function store($data)
    {
        $sql = "
        INSERT INTO peraturan (
            judul, nomor, teu, jenis_id, tahun_terbit,
            tempat_penetapan, tanggal_penetapan,
            tanggal_pengundangan, sumber, bahasa,
            status, lokasi, bidang_hukum, subjek,
            pemrakarsa, kata_kunci, penandatangan
        ) VALUES (
            :judul, :nomor, :teu, :jenis_id, :tahun_terbit,
            :tempat_penetapan, :tanggal_penetapan,
            :tanggal_pengundangan, :sumber, :bahasa,
            :status, :lokasi, :bidang_hukum, :subjek,
            :pemrakarsa, :kata_kunci, :penandatangan
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    // ==========================
    // UPLOAD FILE
    // ==========================
    public function uploadFile($id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO peraturan_file
            (peraturan_id, nama_file, path_file, tipe_file, ukuran_file)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $id,
            $file['nama_file'],
            $file['path_file'],
            $file['tipe_file'],
            $file['ukuran_file']
        ]);
    }

    // ==========================
    // DELETE
    // ==========================
    public function delete($id)
    {
        $this->db->prepare("DELETE FROM peraturan_file WHERE peraturan_id = ?")
            ->execute([$id]);

        return $this->db->prepare("DELETE FROM peraturan WHERE id = ?")
            ->execute([$id]);
    }

    // ==========================
    // MASTER JENIS
    // ==========================
    public function getJenis()
    {
        return $this->db->query("
            SELECT * FROM jenis_peraturan
            WHERE is_active = 1
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}
