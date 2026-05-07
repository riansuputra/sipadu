<?php

class PublikasiModel
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
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_jenis j 
                ON p.jenis_id = j.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id
            WHERE p.is_active = 1
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPaud()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_jenis j 
                ON p.jenis_id = j.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id
            WHERE p.is_active = 1 and p.pokja_id = 1
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSd()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_jenis j 
                ON p.jenis_id = j.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id
            WHERE p.is_active = 1 and p.pokja_id = 2
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSmp()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_jenis j 
                ON p.jenis_id = j.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id
            WHERE p.is_active = 1 and p.pokja_id = 3
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSma()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_jenis j 
                ON p.jenis_id = j.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id
            WHERE p.is_active = 1 and p.pokja_id = 4
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getWp()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            j.nama AS jenis,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_jenis j 
                ON p.jenis_id = j.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id
            WHERE p.is_active = 1 and p.pokja_id = 5
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByRole($role, $pokjaId = null, $tanggalMulai = null, $tanggalSelesai = null, $jenis = null)
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $sql = "
            SELECT
                p.*,
                pj.pokja_tipe AS tim,
                pj.pokja_nama AS nama_tim,
                j.nama AS jenis,
                GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
                ) AS files
            FROM publikasi p
            LEFT JOIN pokja pj ON p.pokja_id = pj.id
            LEFT JOIN publikasi_jenis j ON p.jenis_id = j.id
            LEFT JOIN publikasi_file pf ON p.id = pf.publikasi_id
            WHERE p.is_active = 1
            ";
        $params = [];

        if (
            !in_array($role, ['Superadmin', 'Pimpinan']) &&
            $pokjaId != 9
        ) {
            $sql .= " AND p.pokja_id = ?";
            $params[] = $pokjaId;
        }
        if (!empty($tanggalMulai)) {
            $sql .= " AND DATE(p.tanggal_kegiatan) >= ?";
            $params[] = $tanggalMulai;
        }
        if (!empty($tanggalSelesai)) {
            $sql .= " AND DATE(p.tanggal_kegiatan) <= ?";
            $params[] = $tanggalSelesai;
        }

        if (!empty($jenis)) {
            $sql .= " AND j.nama = ?";
            $params[] = $jenis;
        }
        $sql .= "
            GROUP BY p.id
            ORDER BY p.tanggal_kegiatan DESC, p.created_at DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getFiltered($tanggalMulai = null, $tanggalSelesai = null, $jenis = null)
    {
        $sql = "
            SELECT 
                publikasi.*,
                GROUP_CONCAT(
                    CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file) 
                    SEPARATOR '##'
                ) AS files
            FROM publikasi
            LEFT JOIN publikasi_file pf ON publikasi.id = pf.publikasi_id
            WHERE publikasi.is_active = 1
        ";

        $params = [];

        if (!empty($tanggalMulai)) {
            $sql .= " AND DATE(publikasi.tanggal_kegiatan) >= ?";
            $params[] = $tanggalMulai;
        }

        if (!empty($tanggalSelesai)) {
            $sql .= " AND DATE(publikasi.tanggal_kegiatan) <= ?";
            $params[] = $tanggalSelesai;
        }

        if (!empty($jenis)) {
            $sql .= " AND publikasi.jenis_id = ?";
            $params[] = $jenis;
        }

        $sql .= "
            GROUP BY publikasi.id
            ORDER BY publikasi.tanggal_kegiatan DESC, publikasi.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
        SELECT p.*, j.nama as jenis
            FROM publikasi p
            LEFT JOIN publikasi_jenis j ON p.jenis_id = j.id
            WHERE p.id = ?
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
            INSERT INTO publikasi (
                judul, 
                deskripsi, 
                tanggal_kegiatan, 
                lokasi, 
                jenis_id, 
                pokja_id, 
                penulis, 
                kabupaten, 
                link, 
                created_by
            ) VALUES (?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['tanggal_kegiatan'],
            $data['lokasi'],
            $data['jenis_id'],
            $data['pokja_id'],
            $data['penulis'],
            $data['kabupaten'],
            $data['link'],
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
            UPDATE publikasi SET
                judul = ?,
                deskripsi = ?,
                tanggal_kegiatan = ?,
                lokasi = ?,
                jenis_id = ?,
                penulis = ?,
                kabupaten = ?,
                link = ?,
                updated_at = NOW(),
                updated_by = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['tanggal_kegiatan'],
            $data['lokasi'],
            $data['jenis_id'],
            $data['penulis'],
            $data['kabupaten'],
            $data['link'],
            (int) $data['updated_by'],
            (int) $id
        ]);
    }

    public function updatePublish($id, $data)
    {
        $sql = "
        UPDATE publikasi SET
            is_published = :is_published,
            published_at = :published_at,
            published_by = :published_by,
            publish_links = :publish_links,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id'            => $id,
            ':is_published'  => $data['is_published'],
            ':published_at'  => $data['published_at'],
            ':published_by'  => $data['published_by'],
            ':publish_links' => $data['publish_links'],
            ':updated_by'    => $data['updated_by']
        ]);
    }


    public function delete($id, $deletedBy)
    {
        $stmt = $this->db->prepare("
            UPDATE publikasi SET 
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
            INSERT INTO publikasi_file (
                publikasi_id,
                nama_file, 
                tipe_file, 
                path_file,
                ukuran_file
            ) VALUES (?,?,?,?,?)
        ");

        return $stmt->execute([
            $id,
            $file['nama_file'],
            $file['tipe_file'],
            $file['path_file'],
            $file['ukuran_file']
        ]);
    }

    public function getFiles($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM publikasi_file WHERE publikasi_id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function deleteFileById($fileId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM publikasi_file WHERE id = ?
        ");

        return $stmt->execute([$fileId]);
    }

    public function getFileById($id)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM publikasi_file WHERE id = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function deleteFiles($publikasi_id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM publikasi_file WHERE publikasi_id = ?
        ");

        return $stmt->execute([$publikasi_id]);
    }

    public function deleteFilesByParent($publikasi_id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM publikasi_file WHERE publikasi_id = ?
        ");

        return $stmt->execute([$publikasi_id]);
    }

    // Total publikasi
    public function countAll($pokjaId = null)
    {
        $sql = "
        SELECT COUNT(*)
        FROM publikasi
        WHERE is_active = 1
        AND deleted_at IS NULL
    ";

        // Filter pokja jika ada
        if ($pokjaId) {
            $sql .= " AND pokja_id = :pokja_id";
        }

        $stmt = $this->db->prepare($sql);

        if ($pokjaId) {
            $stmt->execute([
                ':pokja_id' => $pokjaId
            ]);
        } else {
            $stmt->execute();
        }

        return (int) $stmt->fetchColumn();
    }

    // Ambil jumlah publikasi 7 hari terakhir (GLOBAL)
    public function getPublikasiPerHari()
    {
        $stmt = $this->db->prepare("
        SELECT DATE(created_at) as tanggal, COUNT(*) as total
        FROM publikasi
        WHERE deleted_at IS NULL
        AND created_at >= CURDATE() - INTERVAL 6 DAY
        GROUP BY DATE(created_at)
        ORDER BY tanggal ASC
    ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil jumlah publikasi per pokja
    public function getPublikasiPerPokja()
    {
        $stmt = $this->db->prepare("
    SELECT 
        pk.pokja_nama,
        COUNT(p.id) as total
    FROM publikasi p
    LEFT JOIN users u ON u.id = p.created_by
    LEFT JOIN pokja pk ON pk.id = u.pokja_id
    WHERE p.deleted_at IS NULL
    AND pk.pokja_nama IN ('Widyaprada', 'SD', 'SMP', 'SMA', 'PAUD')
    GROUP BY pk.pokja_nama
    ORDER BY total DESC
");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Statistik publikasi per bulan
    public function getPublikasiPerBulan($pokjaId = null)
    {
        $sql = "
        SELECT 
            MONTH(created_at) as bulan,
            COUNT(*) as total
        FROM publikasi
        WHERE deleted_at IS NULL
        AND is_active = 1
        AND YEAR(created_at) = YEAR(CURDATE())
    ";

        // Filter pokja jika ada
        if ($pokjaId) {
            $sql .= " AND pokja_id = :pokja_id";
        }

        $sql .= "
        GROUP BY MONTH(created_at)
        ORDER BY bulan ASC
    ";

        $stmt = $this->db->prepare($sql);

        if ($pokjaId) {
            $stmt->execute([
                ':pokja_id' => $pokjaId
            ]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublikasiPerPokjaTahunIni()
    {
        $stmt = $this->db->prepare("
        SELECT 
            pk.pokja_nama,
            COUNT(p.id) as total
        FROM publikasi p
        LEFT JOIN users u ON u.id = p.created_by
        LEFT JOIN pokja pk ON pk.id = u.pokja_id
        WHERE p.deleted_at IS NULL
        AND YEAR(p.created_at) = YEAR(CURDATE())
        AND pk.pokja_nama IN ('Widyaprada','SD','SMP','SMA','PAUD')
        GROUP BY pk.pokja_nama
        ORDER BY total DESC
    ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Total file publikasi
    public function getTotalFile($pokjaId = null)
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM publikasi_file pf
        INNER JOIN publikasi p 
            ON p.id = pf.publikasi_id
        WHERE pf.is_active = 1
        AND p.deleted_at IS NULL
    ";

        // Filter pokja jika ada
        if ($pokjaId) {
            $sql .= " AND p.pokja_id = :pokja_id";
        }

        $stmt = $this->db->prepare($sql);

        if ($pokjaId) {
            $stmt->execute([
                ':pokja_id' => $pokjaId
            ]);
        } else {
            $stmt->execute();
        }

        return (int) $stmt->fetchColumn();
    }

    // total ukuran (dalam byte)
    // Total ukuran file publikasi
    public function getTotalUkuran($pokjaId = null)
    {
        $sql = "
        SELECT SUM(pf.ukuran_file) as total
        FROM publikasi_file pf
        INNER JOIN publikasi p 
            ON p.id = pf.publikasi_id
        WHERE pf.is_active = 1
        AND p.deleted_at IS NULL
    ";

        // Filter pokja jika ada
        if ($pokjaId) {
            $sql .= " AND p.pokja_id = :pokja_id";
        }

        $stmt = $this->db->prepare($sql);

        if ($pokjaId) {
            $stmt->execute([
                ':pokja_id' => $pokjaId
            ]);
        } else {
            $stmt->execute();
        }

        return (int) ($stmt->fetchColumn() ?? 0);
    }

    // Hitung total publikasi terpublish
    // Hitung total publikasi publish
    public function getTotalPublished($pokjaId = null)
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM publikasi
        WHERE is_active = 1
        AND deleted_at IS NULL
        AND is_published = 1
    ";

        // Filter pokja jika ada
        if ($pokjaId) {
            $sql .= " AND pokja_id = :pokja_id";
        }

        $stmt = $this->db->prepare($sql);

        if ($pokjaId) {
            $stmt->execute([
                ':pokja_id' => $pokjaId
            ]);
        } else {
            $stmt->execute();
        }

        return (int) $stmt->fetchColumn();
    }

    // Komposisi publikasi per jenis
    public function getPublikasiPerJenis($pokjaId = null)
    {
        $sql = "
        SELECT 
            pj.nama as jenis,
            COUNT(*) as total
        FROM publikasi p
        INNER JOIN publikasi_jenis pj
            ON pj.id = p.jenis_id
        WHERE p.is_active = 1
        AND p.deleted_at IS NULL
    ";

        // Filter pokja jika ada
        if ($pokjaId) {
            $sql .= " AND p.pokja_id = :pokja_id";
        }

        $sql .= "
        GROUP BY p.jenis_id
        ORDER BY total DESC
    ";

        $stmt = $this->db->prepare($sql);

        if ($pokjaId) {
            $stmt->execute([
                ':pokja_id' => $pokjaId
            ]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
