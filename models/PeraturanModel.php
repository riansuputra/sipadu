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
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
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
                penandatangan
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
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
            $data['bidang_hukum'],
            $data['subjek'],
            $data['pemrakarsa'],
            $data['penandatangan']
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
            $data['bidang_hukum'],
            $data['subjek'],
            $data['pemrakarsa'],
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

    public function getLatest($limit = 5)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM peraturan
        WHERE is_active = 1
        ORDER BY created_at DESC
        LIMIT ?
    ");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchByJudul($judul)
    {
        $stmt = $this->db->prepare("
        SELECT 
    p.*,
    j.nama AS jenis,
    GROUP_CONCAT(
        CONCAT(pf.id,'|',pf.nama_file,'|',pf.path_file)
        SEPARATOR '##'
    ) AS files
FROM peraturan p
LEFT JOIN jenis_peraturan j ON p.jenis_id = j.id
LEFT JOIN peraturan_file pf ON p.id = pf.peraturan_id
WHERE p.is_active = 1
-- + kondisi filter dinamis
GROUP BY p.id
ORDER BY p.created_at DESC

    ");
        $stmt->execute(['%' . $judul . '%']);
        return $stmt->fetchAll();
    }

    public function filter($params)
    {
        $sql = "SELECT * FROM peraturan WHERE is_active = 1";
        $bind = [];

        if (!empty($params['judul'])) {
            $sql .= " AND judul LIKE ?";
            $bind[] = '%' . $params['judul'] . '%';
        }

        if (!empty($params['nomor'])) {
            $sql .= " AND nomor LIKE ?";
            $bind[] = '%' . $params['nomor'] . '%';
        }

        if (!empty($params['tahun'])) {
            $sql .= " AND tahun_terbit = ?";
            $bind[] = $params['tahun'];
        }

        if (!empty($params['jenis'])) {
            $sql .= " AND jenis_id = ?";
            $bind[] = $params['jenis'];
        }

        if (!empty($params['status'])) {
            $sql .= " AND status = ?";
            $bind[] = $params['status'];
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll();
    }

    public function incrementDownload($fileId)
    {
        $stmt = $this->db->prepare("
        UPDATE peraturan_file
        SET jumlah_download = jumlah_download + 1
        WHERE id = ?
    ");
        $stmt->execute([$fileId]);
    }

    public function incrementView($id)
    {
        $stmt = $this->db->prepare("
        UPDATE peraturan
        SET jumlah_dilihat = jumlah_dilihat + 1
        WHERE id = ?
    ");
        $stmt->execute([$id]);
    }
}
