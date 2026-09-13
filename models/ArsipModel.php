<?php

class ArsipModel
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

    // Ambil semua data arsip beserta ringkasan peserta
    // Ambil semua data arsip beserta ringkasan peserta
    public function getAll()
    {
        $this->db->exec("
        SET SESSION group_concat_max_len = 100000
    ");

        $stmt = $this->db->prepare("
        SELECT 
            a.*,
            aj.nama AS jenis,

            COUNT(DISTINCT ap.id) AS total_peserta,

            GROUP_CONCAT(
                DISTINCT pg.nama
                ORDER BY pg.nama ASC
                SEPARATOR '##'
            ) AS nama_peserta,

            COUNT(DISTINCT CASE 
                WHEN apf.id IS NOT NULL THEN ap.id 
            END) AS total_upload,

            (
                COUNT(DISTINCT ap.id) - 
                COUNT(DISTINCT CASE 
                    WHEN apf.id IS NOT NULL THEN ap.id 
                END)
            ) AS total_belum,

            CASE
                WHEN COUNT(DISTINCT ap.id) = 0 THEN 0
                WHEN COUNT(DISTINCT ap.id) = COUNT(DISTINCT CASE 
                    WHEN apf.id IS NOT NULL THEN ap.id 
                END) THEN 1
                ELSE 0
            END AS upload_selesai

        FROM arsip a

        LEFT JOIN arsip_jenis aj 
            ON a.jenis_id = aj.id

        LEFT JOIN arsip_peserta ap 
            ON a.id = ap.arsip_id
            AND ap.is_active = 1

        LEFT JOIN pegawai pg
            ON pg.id = ap.pegawai_id

        LEFT JOIN arsip_peserta_file apf 
            ON ap.id = apf.arsip_peserta_id
            AND apf.is_active = 1

        WHERE a.deleted_at IS NULL
        AND a.is_active = 1

        GROUP BY a.id

        ORDER BY a.created_at DESC
    ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFiltered(
        $tanggalMulai = null,
        $tanggalSelesai = null,
        $jenis = null
    ) {
        $this->db->exec("
        SET SESSION group_concat_max_len = 100000
    ");

        $sql = "
        SELECT 
            a.*,
            aj.nama AS jenis,

            COUNT(DISTINCT ap.id) AS total_peserta,

            GROUP_CONCAT(
                DISTINCT pg.nama
                ORDER BY pg.nama ASC
                SEPARATOR '##'
            ) AS nama_peserta,

            COUNT(DISTINCT CASE 
                WHEN apf.id IS NOT NULL THEN ap.id 
            END) AS total_upload,

            (
                COUNT(DISTINCT ap.id) - 
                COUNT(DISTINCT CASE 
                    WHEN apf.id IS NOT NULL THEN ap.id 
                END)
            ) AS total_belum,

            CASE
                WHEN COUNT(DISTINCT ap.id) = 0 THEN 0
                WHEN COUNT(DISTINCT ap.id) = COUNT(DISTINCT CASE 
                    WHEN apf.id IS NOT NULL THEN ap.id 
                END) THEN 1
                ELSE 0
            END AS upload_selesai

        FROM arsip a

        LEFT JOIN arsip_jenis aj 
            ON a.jenis_id = aj.id

        LEFT JOIN arsip_peserta ap 
            ON a.id = ap.arsip_id
            AND ap.is_active = 1

        LEFT JOIN pegawai pg
            ON pg.id = ap.pegawai_id

        LEFT JOIN arsip_peserta_file apf 
            ON ap.id = apf.arsip_peserta_id
            AND apf.is_active = 1

        WHERE a.deleted_at IS NULL
        AND a.is_active = 1
    ";

        $params = [];

        if (!empty($jenis) && ctype_digit((string)$jenis)) {
            $sql .= " AND a.jenis_id = ?";
            $params[] = $jenis;
        }

        if (
            !empty($tanggalMulai) &&
            !empty($tanggalSelesai)
        ) {

            $sql .= "
            AND a.tanggal_mulai <= ?
            AND COALESCE(
                a.tanggal_selesai,
                a.tanggal_mulai
            ) >= ?
        ";

            $params[] = $tanggalSelesai;
            $params[] = $tanggalMulai;
        } elseif (!empty($tanggalMulai)) {

            $sql .= "
            AND COALESCE(
                a.tanggal_selesai,
                a.tanggal_mulai
            ) >= ?
        ";

            $params[] = $tanggalMulai;
        } elseif (!empty($tanggalSelesai)) {

            $sql .= "
            AND a.tanggal_mulai <= ?
        ";

            $params[] = $tanggalSelesai;
        }

        $sql .= "
        GROUP BY a.id
        ORDER BY a.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
                k.*, 
                j.nama as jenis,
                GROUP_CONCAT(
                    CONCAT(kf.id, '|', kf.nama_file, '|', kf.path_file, '|', kf.tipe_file)
                    SEPARATOR '##'
                ) AS files
            FROM arsip k
            LEFT JOIN arsip_jenis j ON k.jenis_id = j.id
            LEFT JOIN arsip_file kf ON k.id = kf.arsip_id

            WHERE k.id = ? AND k.is_active = 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function insert($data)
    {
        if (empty($data['created_by']) || !is_numeric($data['created_by'])) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO arsip (
                judul,
                deskripsi,
                tanggal_mulai,
                tanggal_selesai,
                jenis_id,
                lokasi,
                created_by
            ) VALUES (?,?,?,?,?,?,?)
        ");

        if (!$stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['tanggal_mulai'],
            $data['tanggal_selesai'],
            $data['jenis_id'],
            $data['lokasi'],
            (int)$data['created_by']
        ])) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    // Update data arsip
    public function update($id, $data)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        if (empty($data['updated_by']) || !is_numeric($data['updated_by'])) {
            return false;
        }

        $stmt = $this->db->prepare("
        UPDATE arsip
        SET
            judul = ?,
            deskripsi = ?,
            tanggal_mulai = ?,
            tanggal_selesai = ?,
            jenis_id = ?,
            lokasi = ?,
            kategori = ?,
            updated_by = ?,
            updated_at = NOW()
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        return $stmt->execute([
            trim($data['judul']),
            !empty($data['deskripsi']) ? trim($data['deskripsi']) : null,
            $data['tanggal_mulai'],
            !empty($data['tanggal_selesai']) ? $data['tanggal_selesai'] : null,
            (int)$data['jenis_id'],
            !empty($data['lokasi']) ? trim($data['lokasi']) : null,
            !empty($data['kategori']) ? trim($data['kategori']) : null,
            (int)$data['updated_by'],
            (int)$id
        ]);
    }

    public function delete($id, $deletedBy)
    {
        $stmt = $this->db->prepare("
            UPDATE arsip SET 
                is_active = 0,
                deleted_at = NOW(),
                deleted_by = ?
            WHERE id = ?
        ");

        $stmt->execute([
            (int)$deletedBy,
            (int)$id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function insertFile($id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO arsip_file (
                arsip_id,
                nama_file,
                path_file,
                tipe_file,
                ukuran_file
            ) VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
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
            SELECT * FROM arsip_file
            WHERE arsip_id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getFileById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip_file WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function deleteFileById($fileId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM arsip_file WHERE id = ?
        ");

        return $stmt->execute([$fileId]);
    }

    public function deleteFiles($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM arsip_file WHERE arsip_id = ?
        ");

        return $stmt->execute([$id]);
    }


    public function getLatest($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip
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
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
                p.*,
                j.nama AS jenis,
                GROUP_CONCAT(
                    CONCAT(pf.id,'|',pf.nama_file,'|',pf.path_file)
                    SEPARATOR '##'
                ) AS files
            FROM arsip p
            LEFT JOIN arsip_jenis j ON p.jenis_id = j.id
            LEFT JOIN arsip_file pf ON p.id = pf.arsip_id
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
        $sql = "SELECT * FROM arsip WHERE is_active = 1";
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
            UPDATE arsip
            SET jumlah_unduhan = jumlah_unduhan + 1
            WHERE id = ?
        ");
        $stmt->execute([$id]);
    }

    public function incrementView($id)
    {
        $stmt = $this->db->prepare("
            UPDATE arsip
            SET jumlah_dilihat = jumlah_dilihat + 1
            WHERE id = ?
        ");
        $stmt->execute([$id]);
    }

    public function filterWithPagination($params, $limit, $offset)
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $sql = "
            SELECT 
                p.*,
                j.nama AS jenis,
                GROUP_CONCAT(
                    CONCAT(pf.id,'|',pf.nama_file,'|',pf.path_file)
                    SEPARATOR '##'
                ) AS files
            FROM arsip p
            LEFT JOIN arsip_jenis j ON p.jenis_id = j.id
            LEFT JOIN arsip_file pf ON p.id = pf.arsip_id
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
        return $stmt->fetchAll();
    }

    public function countFiltered($params)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) FROM arsip p WHERE p.is_active = 1";
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

    public function getAvailablePegawai($arsip_id)
    {
        $stmt = $this->db->prepare("
        SELECT 
            p.id,
            p.nama,
            p.nip,
            pj.nama AS jabatan

        FROM pegawai p

        LEFT JOIN pegawai_jabatan pj 
            ON pj.id = p.jabatan_id

        WHERE p.deleted_at IS NULL
        AND p.id NOT IN (
            SELECT ap.pegawai_id
            FROM arsip_peserta ap
            WHERE ap.arsip_id = ?
            AND ap.is_active = 1
        )

        ORDER BY p.nama ASC
    ");

        $stmt->execute([$arsip_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM arsip WHERE is_active = 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Ambil jumlah arsip 7 hari terakhir (GLOBAL, tanpa filter pokja)
    public function getArsipPerHari()
    {
        $stmt = $this->db->prepare("
            SELECT DATE(created_at) as tanggal, COUNT(*) as total
            FROM arsip
            WHERE deleted_at IS NULL
            AND created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at)
            ORDER BY tanggal ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getArsipPerBulan()
    {
        $stmt = $this->db->prepare("
        SELECT 
            MONTH(created_at) as bulan,
            COUNT(*) as total
        FROM arsip
        WHERE deleted_at IS NULL
        AND YEAR(created_at) = YEAR(CURDATE())
        GROUP BY MONTH(created_at)
        ORDER BY bulan ASC
    ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
