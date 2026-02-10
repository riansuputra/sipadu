<?php

class PublikasiModel
{
    protected $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAll()
    {
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByRole($role, $pokjaId = null, $tanggalMulai = null, $tanggalSelesai = null, $jenis = null)
    {
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
            // Admin & Staff NON-Publikasi → hanya pokja sendiri
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    // ----------------------------------------------------
    // Simpan file publikasi (SESUAI TABEL publikasi_file)
    // ----------------------------------------------------
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

    // ----------------------------------------------------
    // Ambil file berdasarkan publikasi
    // ----------------------------------------------------
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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ----------------------------------------------------
    // Hapus file by publikasi
    // ----------------------------------------------------
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
}
