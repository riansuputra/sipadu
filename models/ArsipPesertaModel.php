<?php

class ArsipPesertaModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollBack();
    }

    public function getAll()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM arsip_peserta p

            LEFT JOIN arsip_peserta_file pf 
                ON p.id = pf.arsip_peserta_id
            WHERE p.is_active = 1

            GROUP BY p.id
            ORDER BY p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip_peserta WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function exists($arsip_id, $pegawai_id)
    {
        $stmt = $this->db->prepare("
        SELECT id
        FROM arsip_peserta
        WHERE arsip_id = ?
        AND pegawai_id = ?
        AND is_active = 1
        LIMIT 1
    ");

        $stmt->execute([$arsip_id, $pegawai_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByArsip($id)
    {
        $stmt = $this->db->prepare("
        SELECT 
            ap.id,
            ap.arsip_id,
            ap.pegawai_id,
            ap.status,
            ap.created_at,

            p.nama,
            p.nip,
            pj.nama AS jabatan

        FROM arsip_peserta ap

        JOIN pegawai p 
            ON p.id = ap.pegawai_id

        LEFT JOIN pegawai_jabatan pj
            ON pj.id = p.jabatan_id

        WHERE ap.arsip_id = ?
        AND ap.is_active = 1

        ORDER BY p.nama ASC
    ");

        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO arsip_peserta (
            arsip_id,
            pegawai_id,
            status,
            is_active,
            created_at
        ) VALUES (?, ?, ?, 1, NOW())
    ");

        return $stmt->execute([
            $data['arsip_id'],
            $data['pegawai_id'],
            $data['status']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE arsip_peserta
        SET pegawai_id = ?
        WHERE id = ?
    ");

        return $stmt->execute([
            $data['pegawai_id'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
        UPDATE arsip_peserta
        SET is_active = 0
        WHERE id = ?
    ");

        return $stmt->execute([$id]);
    }

    // Simpan file DIP
    public function insertFile($id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pegawai_file (
                pegawai_id,
                jenis_dokumen,
                nama_file,
                path_file,
                tipe_file,
                ukuran_file
            ) VALUES (?,?,?,?,?,?)
        ");

        return $stmt->execute([
            $id,
            $file['jenis_dokumen'],
            $file['nama_file'],
            $file['path_file'],
            $file['tipe_file'],
            $file['ukuran_file']
        ]);
    }

    // Ambil file berdasarkan DIP
    public function getFiles($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pegawai_file 
            WHERE pegawai_id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFiles($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM pegawai_file WHERE pegawai_id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function deleteFilesByParent($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM pegawai_file WHERE pegawai_id = ?
        ");

        return $stmt->execute([$id]);
    }

    // cek apakah NIK sudah ada (untuk store & update)
    public function existsNik($nik, $excludeId = null)
    {
        $sql = "SELECT id FROM pegawai 
            WHERE nik = ? 
            AND deleted_at IS NULL";

        $params = [$nik];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }


    public function existsNip($nip, $excludeId = null)
    {
        $sql = "SELECT id FROM pegawai 
            WHERE nip = ? 
            AND deleted_at IS NULL";

        $params = [$nip];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function findByArsipPegawai($arsipId, $pegawaiId)
    {
        $stmt = $this->db->prepare("
        SELECT * 
        FROM arsip_peserta
        WHERE arsip_id = ? AND pegawai_id = ?
        LIMIT 1
    ");

        $stmt->execute([$arsipId, $pegawaiId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function reactivate($id)
    {
        $stmt = $this->db->prepare("
        UPDATE arsip_peserta
        SET 
            is_active = 1,
            updated_at = NOW()
        WHERE id = ?
    ");

        return $stmt->execute([$id]);
    }
}
