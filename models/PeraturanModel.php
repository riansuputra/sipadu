<?php

class PeraturanModel
{
    protected $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ==========================
    // LIST
    // ==========================
    public function getAll()
    {
        $stmt = $this->db->prepare("
        SELECT 
            p.*,
            j.nama AS jenis,
            j.kode AS kode_jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file)
                SEPARATOR '##'
            ) AS files

        FROM peraturan p

        LEFT JOIN jenis_peraturan j 
            ON p.jenis_id = j.id

        LEFT JOIN peraturan_file pf 
            ON p.id = pf.peraturan_id

        GROUP BY p.id
        ORDER BY p.created_at DESC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================
    // DETAIL
    // ==========================
    public function getById($id)
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

    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO peraturan (
                judul,
                nomor,
                teu,
                jenis_id,
                tahun_terbit,
                tempat_penetapan,
                tanggal_penetapan,
                tanggal_pengundangan,
                sumber,
                bahasa,
                status,
                lokasi,
                bidang_hukum,
                subjek,
                pemrakarsa,
                kata_kunci,
                penandatangan,
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['judul'],
            $data['nomor'],
            $data['teu'],
            $data['jenis_id'],
            $data['tahun_terbit'],
            $data['tempat_penetapan'],
            $data['tanggal_penetapan'],
            $data['tanggal_pengundangan'],
            $data['sumber'],
            $data['bahasa'],
            $data['status'],
            $data['lokasi'],
            $data['bidang_huku,'],
            $data['subjek'],
            $data['pemrakarsa'],
            $data['kata_kunci'],
            $data['penandatangan'],
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE peraturan SET
                judul = ?,
                nomor = ?,
                teu = ?,
                jenis_id = ?,
                tahun_terbit = ?,
                tempat_penetapan = ?,
                tanggal_penetapan = ?,
                tanggal_pengundangan = ?,
                sumber = ?,
                bahasa = ?,
                status = ?,
                lokasi = ?,
                bidang_hukum = ?,
                subjek = ?,
                pemrakarsa = ?,
                kata_kunci = ?,
                penandatangan = ?,
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['judul'],
            $data['nomor'],
            $data['teu'],
            $data['jenis_id'],
            $data['tahun_terbit'],
            $data['tempat_penetapan'],
            $data['tanggal_penetapan'],
            $data['tanggal_pengundangan'],
            $data['sumber'],
            $data['bahasa'],
            $data['status'],
            $data['lokasi'],
            $data['bidang_huku,'],
            $data['subjek'],
            $data['pemrakarsa'],
            $data['kata_kunci'],
            $data['penandatangan'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE peraturan SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function insertFile($id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO peraturan_file (
                peraturan_id, 
                nama_file, 
                path_file, 
                tipe_file, 
                ukuran_file
            ) VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $id,
            $file['nama_file'],
            $file['path_file'],
            $file['tipe_file'],
            $file['ukuran_file']
        ]);
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

    public function deleteFiles($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM peraturan_file WHERE peraturan_id = ?
        ");

        return $stmt->execute([$id]);
    }
}
