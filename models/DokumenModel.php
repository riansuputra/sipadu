<?php

class DokumenModel
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
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

        FROM dokumen p

        LEFT JOIN jenis_dokumen j 
            ON p.jenis_id = j.id

        LEFT JOIN dokumen_file pf 
            ON p.id = pf.dokumen_id

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
            SELECT p.*, j.nama as jenis, j.kode as kode
            FROM dokumen p
            LEFT JOIN jenis_dokumen j ON p.jenis_id = j.id
            WHERE p.id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO dokumen (
                judul,
                deskripsi,
                jenis_id,
                tahun
            ) VALUES (?,?,?,?)
        ");

        $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['jenis_id'],
            $data['tahun']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE dokumen SET
                judul = ?,
                deskripsi = ?,
                jenis_id = ?,
                tahun = ?,
                is_published = ?,
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['jenis_id'],
            $data['tahun'],
            $data['is_published'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE dokumen SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function insertFile($id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO dokumen_file (
                dokumen_id, 
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
            SELECT * FROM dokumen_file
            WHERE dokumen_id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFileById($id)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM dokumen_file WHERE id = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function deleteFiles($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM dokumen_file WHERE dokumen_id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function getLatest($limit = 5)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM dokumen
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
FROM dokumen p
LEFT JOIN jenis_dokumen j ON p.jenis_id = j.id
LEFT JOIN dokumen_file pf ON p.id = pf.dokumen_id
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
        $sql = "SELECT * FROM dokumen WHERE is_active = 1";
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

    public function incrementDownload($id)
    {
        $stmt = $this->db->prepare("
        UPDATE dokumen
        SET jumlah_unduhan = jumlah_unduhan + 1
        WHERE id = ?
    ");
        $stmt->execute([$id]);
    }

    public function incrementView($id)
    {
        $stmt = $this->db->prepare("
        UPDATE dokumen
        SET jumlah_dilihat = jumlah_dilihat + 1
        WHERE id = ?
    ");
        $stmt->execute([$id]);
    }

    public function filterWithPagination($params, $limit, $offset)
    {
        $sql = "
        SELECT 
            p.*,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id,'|',pf.nama_file,'|',pf.path_file)
                SEPARATOR '##'
            ) AS files
        FROM dokumen p
        LEFT JOIN jenis_dokumen j ON p.jenis_id = j.id
        LEFT JOIN dokumen_file pf ON p.id = pf.dokumen_id
        WHERE p.is_active = 1
    ";
        $bind = [];

        if (!empty($params['judul'])) {
            $sql .= " AND p.judul LIKE ?";
            $bind[] = "%{$params['judul']}%";
        }
        if (!empty($params['nomor'])) {
            $sql .= " AND p.nomor LIKE ?";
            $bind[] = "%{$params['nomor']}%";
        }
        if (!empty($params['tahun'])) {
            $sql .= " AND p.tahun_terbit = ?";
            $bind[] = $params['tahun'];
        }
        if (!empty($params['subjek'])) {
            $sql .= " AND p.subjek LIKE ?";
            $bind[] = "%{$params['subjek']}%";
        }
        if (!empty($params['jenis'])) {
            $sql .= " AND p.jenis_id = ?";
            $bind[] = $params['jenis'];
        }
        if (!empty($params['status'])) {
            $sql .= " AND p.status = ?";
            $bind[] = $params['status'];
        }

        $sql .= "
        GROUP BY p.id
        ORDER BY p.created_at DESC
        LIMIT $limit OFFSET $offset
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFiltered($params)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) FROM dokumen p WHERE p.is_active = 1";
        $bind = [];

        if (!empty($params['judul'])) {
            $sql .= " AND p.judul LIKE ?";
            $bind[] = "%{$params['judul']}%";
        }
        if (!empty($params['nomor'])) {
            $sql .= " AND p.nomor LIKE ?";
            $bind[] = "%{$params['nomor']}%";
        }
        if (!empty($params['tahun'])) {
            $sql .= " AND p.tahun_terbit = ?";
            $bind[] = $params['tahun'];
        }
        if (!empty($params['subjek'])) {
            $sql .= " AND p.subjek LIKE ?";
            $bind[] = "%{$params['subjek']}%";
        }
        if (!empty($params['jenis'])) {
            $sql .= " AND p.jenis_id = ?";
            $bind[] = $params['jenis'];
        }
        if (!empty($params['status'])) {
            $sql .= " AND p.status = ?";
            $bind[] = $params['status'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchColumn();
    }

    public function countAll()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM dokumen WHERE is_active = 1");
        return $stmt->fetchColumn();
    }
}
