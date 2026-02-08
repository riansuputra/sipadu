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

        LEFT JOIN peraturan_jenis j 
            ON p.jenis_id = j.id

        LEFT JOIN peraturan_file pf 
            ON p.id = pf.peraturan_id
        WHERE p.is_active = 1
        GROUP BY p.id
        ORDER BY p.tahun_terbit DESC, p.created_at DESC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFiltered($tahun = null, $jenis = null)
    {
        $sql = "
        SELECT 
            p.*,
            j.nama AS jenis,
            j.kode AS kode_jenis,
            j.id,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file) 
                SEPARATOR '##'
            ) AS files
        FROM peraturan p
        LEFT JOIN peraturan_jenis j ON p.jenis_id = j.id
        LEFT JOIN peraturan_file pf ON p.id = pf.peraturan_id
        WHERE p.is_active = 1
    ";

        $params = [];

        if (!empty($tahun)) {
            $sql .= " AND p.tahun_terbit = ?";
            $params[] = $tahun;
        }

        if (!empty($jenis)) {
            $sql .= " AND j.kode = ?";
            $params[] = $jenis;
        }

        $sql .= "
        GROUP BY p.id
        ORDER BY p.tahun_terbit DESC, p.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================
    // DETAIL
    // ==========================
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, j.nama as jenis, j.kode as kode
            FROM peraturan p
            LEFT JOIN peraturan_jenis j ON p.jenis_id = j.id
            WHERE p.id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        if (empty($data['created_by']) || !is_numeric($data['created_by'])) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO peraturan (
                judul,
                nomor,
                lembaga,
                jenis_id,
                tahun_terbit,
                tempat_penetapan,
                penandatangan,
                created_by
            ) VALUES (?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['judul'],
            $data['nomor'],
            $data['lembaga'],
            $data['jenis_id'],
            $data['tahun_terbit'],
            $data['tempat_penetapan'],
            $data['penandatangan'],
            (int) $data['created_by']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        if (empty($data['updated_by']) || !is_numeric($data['updated_by'])) {
            return false;
        }

        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE peraturan SET
                judul = ?,
                nomor = ?,
                lembaga = ?,
                jenis_id = ?,
                tahun_terbit = ?,
                tempat_penetapan = ?,
                penandatangan = ?,
                updated_at = NOW(),
                updated_by = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['judul'],
            $data['nomor'],
            $data['lembaga'],
            $data['jenis_id'],
            $data['tahun_terbit'],
            $data['tempat_penetapan'],
            $data['penandatangan'],
            (int) $data['updated_by'],
            (int) $id
        ]);
    }

    public function delete($id, $deletedBy)
    {
        if (empty($data['deleted_by']) || !is_numeric($data['deleted_by'])) {
            return false;
        }

        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE peraturan SET 
                is_active = 0,
                deleted_at = NOW(),
                deleted_by = ? 
            WHERE id = ?
        ");

        return $stmt->execute([
            (int) $deletedBy,
            (int) $id
        ]);
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

    public function getFileById($id)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM peraturan_file WHERE id = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteFileById($fileId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM peraturan_file WHERE id = ?
        ");

        return $stmt->execute([$fileId]);
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
LEFT JOIN peraturan_jenis j ON p.jenis_id = j.id
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

    public function incrementDownload($id)
    {
        $stmt = $this->db->prepare("
        UPDATE peraturan
        SET jumlah_unduhan = jumlah_unduhan + 1
        WHERE id = ?
    ");
        $stmt->execute([$id]);
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
        FROM peraturan p
        LEFT JOIN peraturan_jenis j ON p.jenis_id = j.id
        LEFT JOIN peraturan_file pf ON p.id = pf.peraturan_id
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
        $sql = "SELECT COUNT(DISTINCT p.id) FROM peraturan p WHERE p.is_active = 1";
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
        $stmt = $this->db->query("SELECT COUNT(*) FROM peraturan WHERE is_active = 1");
        return $stmt->fetchColumn();
    }
}
