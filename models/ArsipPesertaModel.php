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
            ap.created_at,
            ap.updated_at,
            ap.is_active,

            p.nama,
            p.nip,
            pj.nama AS jabatan,

            COUNT(apf.id) AS total_file,

            CASE 
                WHEN COUNT(apf.id) > 0 THEN 'bukti_diunggah'
                ELSE 'diundang'
            END AS status_otomatis

        FROM arsip_peserta ap

        JOIN pegawai p 
            ON p.id = ap.pegawai_id

        LEFT JOIN pegawai_jabatan pj
            ON pj.id = p.jabatan_id

        LEFT JOIN arsip_peserta_file apf
            ON apf.arsip_peserta_id = ap.id
            AND apf.is_active = 1

        WHERE ap.arsip_id = ?
        AND ap.is_active = 1

        GROUP BY 
            ap.id,
            ap.arsip_id,
            ap.pegawai_id,
            ap.created_at,
            ap.updated_at,
            ap.is_active,
            p.nama,
            p.nip,
            pj.nama

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

    public function getArsipSaya($pegawaiId, $filters = [])
    {
        $sql = "
        SELECT 
            ap.id AS arsip_peserta_id,
            ap.arsip_id,
            a.judul,
            a.deskripsi,
            a.tanggal_mulai,
            a.tanggal_selesai,
            a.lokasi,
            a.kategori,
            aj.nama AS jenis_nama,

            COUNT(apf.id) AS total_file,

            CASE 
                WHEN COUNT(apf.id) > 0 THEN 'bukti_diunggah'
                ELSE 'diundang'
            END AS status_otomatis

        FROM arsip_peserta ap

        JOIN arsip a 
            ON a.id = ap.arsip_id
            AND a.deleted_at IS NULL
            AND a.is_active = 1

        LEFT JOIN arsip_jenis aj
            ON aj.id = a.jenis_id

        LEFT JOIN arsip_peserta_file apf
            ON apf.arsip_peserta_id = ap.id
            AND apf.is_active = 1

        WHERE ap.pegawai_id = ?
        AND ap.is_active = 1
    ";

        $params = [$pegawaiId];

        if (!empty($filters['tahun'])) {
            $sql .= " AND YEAR(a.tanggal_mulai) = ? ";
            $params[] = $filters['tahun'];
        }

        if (!empty($filters['judul'])) {
            $sql .= " AND a.judul LIKE ? ";
            $params[] = '%' . $filters['judul'] . '%';
        }

        $sql .= "
        GROUP BY 
            ap.id,
            ap.arsip_id,
            a.judul,
            a.deskripsi,
            a.tanggal_mulai,
            a.tanggal_selesai,
            a.lokasi,
            a.kategori,
            aj.nama

        ORDER BY a.tanggal_mulai DESC, a.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil detail arsip saya + file arsip utama (concat)
    public function getDetailArsipSaya($arsipId, $pegawaiId)
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
        SELECT 
            ap.id AS arsip_peserta_id,
            ap.pegawai_id,
            ap.arsip_id,

            a.judul,
            a.deskripsi,
            a.tanggal_mulai,
            a.tanggal_selesai,
            a.lokasi,
            a.kategori,
            a.created_at,

            aj.nama AS jenis_nama,

            GROUP_CONCAT(
                DISTINCT CONCAT(af.id, '|', af.nama_file, '|', af.path_file, '|', af.tipe_file)
                SEPARATOR '##'
            ) AS files,

            COUNT(DISTINCT apf.id) AS total_file,

            CASE 
                WHEN COUNT(DISTINCT apf.id) > 0 THEN 'bukti_diunggah'
                ELSE 'diundang'
            END AS status_otomatis

        FROM arsip_peserta ap

        JOIN arsip a 
            ON a.id = ap.arsip_id
            AND a.deleted_at IS NULL
            AND a.is_active = 1

        LEFT JOIN arsip_jenis aj
            ON aj.id = a.jenis_id

        LEFT JOIN arsip_file af 
            ON af.arsip_id = ap.arsip_id
            AND af.is_active = 1

        LEFT JOIN arsip_peserta_file apf
            ON apf.arsip_peserta_id = ap.id
            AND apf.is_active = 1

        WHERE ap.arsip_id = ?
        AND ap.pegawai_id = ?
        AND ap.is_active = 1

        GROUP BY 
            ap.id,
            ap.pegawai_id,
            ap.arsip_id,
            a.judul,
            a.deskripsi,
            a.tanggal_mulai,
            a.tanggal_selesai,
            a.lokasi,
            a.kategori,
            a.created_at,
            aj.nama

        LIMIT 1
    ");

        $stmt->execute([$arsipId, $pegawaiId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFilesByArsipPeserta($arsipPesertaId)
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM arsip_peserta_file
        WHERE arsip_peserta_id = ?
        AND is_active = 1
        ORDER BY uploaded_at DESC
    ");

        $stmt->execute([$arsipPesertaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil file utama arsip
    public function getFileArsip($arsipId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            id,
            arsip_id,
            nama_file,
            path_file,
            tipe_file,
            ukuran_file,
            is_active,
            uploaded_at
        FROM arsip_file
        WHERE arsip_id = ?
        AND is_active = 1
        ORDER BY uploaded_at DESC
    ");

        $stmt->execute([$arsipId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Simpan file bukti peserta
    public function insertFileBukti($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO arsip_peserta_file (
            arsip_peserta_id,
            nama_file,
            path_file,
            tipe_file,
            ukuran_file,
            is_active,
            uploaded_at
        ) VALUES (?, ?, ?, ?, ?, 1, NOW())
    ");

        return $stmt->execute([
            $data['arsip_peserta_id'],
            $data['nama_file'],
            $data['path_file'],
            $data['tipe_file'],
            $data['ukuran_file']
        ]);
    }

    // Ambil file bukti berdasarkan ID
    public function getFileById($id)
    {
        $stmt = $this->db->prepare("
        SELECT * 
        FROM arsip_peserta_file
        WHERE id = ?
        LIMIT 1
    ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Nonaktifkan file bukti peserta
    public function deleteFileById($id)
    {
        $stmt = $this->db->prepare("
        UPDATE arsip_peserta_file
        SET is_active = 0
        WHERE id = ?
    ");

        return $stmt->execute([$id]);
    }

    // Cek apakah file bukti ini milik pegawai yang sedang login
    public function isFileMilikPegawai($fileId, $pegawaiId)
    {
        $stmt = $this->db->prepare("
        SELECT apf.id
        FROM arsip_peserta_file apf
        JOIN arsip_peserta ap 
            ON ap.id = apf.arsip_peserta_id
        WHERE apf.id = ?
        AND ap.pegawai_id = ?
        AND ap.is_active = 1
        LIMIT 1
    ");

        $stmt->execute([$fileId, $pegawaiId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cek apakah arsip_peserta ini milik pegawai login
    public function getArsipPesertaByIdAndPegawai($arsipPesertaId, $pegawaiId)
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM arsip_peserta
        WHERE id = ?
        AND pegawai_id = ?
        AND is_active = 1
        LIMIT 1
    ");

        $stmt->execute([$arsipPesertaId, $pegawaiId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFilteredArsipSaya($pegawaiId, $tanggalMulai = null, $tanggalSelesai = null, $jenis = null)
    {
        $stmt = null;

        $sql = "
        SELECT 
            ap.id AS arsip_peserta_id,
            ap.pegawai_id,
            ap.arsip_id,

            a.judul,
            a.deskripsi,
            a.tanggal_mulai,
            a.tanggal_selesai,
            a.lokasi,
            a.kategori,
            a.created_at,

            aj.nama AS jenis_nama,

            COUNT(apf.id) AS total_file,

            CASE 
                WHEN COUNT(apf.id) > 0 THEN 'bukti_diunggah'
                ELSE 'diundang'
            END AS status_otomatis

        FROM arsip_peserta ap

        JOIN arsip a 
            ON a.id = ap.arsip_id
            AND a.deleted_at IS NULL
            AND a.is_active = 1

        LEFT JOIN arsip_jenis aj
            ON aj.id = a.jenis_id

        LEFT JOIN arsip_peserta_file apf
            ON apf.arsip_peserta_id = ap.id
            AND apf.is_active = 1

        WHERE ap.pegawai_id = ?
        AND ap.is_active = 1
    ";

        $params = [$pegawaiId];

        // =========================
        // FILTER JENIS
        // =========================
        if (!empty($jenis) && ctype_digit((string)$jenis)) {
            $sql .= " AND a.jenis_id = ?";
            $params[] = $jenis;
        }

        // =========================
        // FILTER TANGGAL (OVERLAP)
        // =========================
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $sql .= " 
            AND a.tanggal_mulai <= ?
            AND COALESCE(a.tanggal_selesai, a.tanggal_mulai) >= ?
        ";
            $params[] = $tanggalSelesai;
            $params[] = $tanggalMulai;
        } elseif (!empty($tanggalMulai)) {
            $sql .= " 
            AND COALESCE(a.tanggal_selesai, a.tanggal_mulai) >= ?
        ";
            $params[] = $tanggalMulai;
        } elseif (!empty($tanggalSelesai)) {
            $sql .= " 
            AND a.tanggal_mulai <= ?
        ";
            $params[] = $tanggalSelesai;
        }

        $sql .= "
        GROUP BY 
            ap.id,
            ap.pegawai_id,
            ap.arsip_id,
            a.judul,
            a.deskripsi,
            a.tanggal_mulai,
            a.tanggal_selesai,
            a.lokasi,
            a.kategori,
            a.created_at,
            aj.nama
        ORDER BY a.tanggal_mulai DESC, a.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
