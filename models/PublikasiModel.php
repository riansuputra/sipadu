<?php
// ======================================================
// MODEL PUBLIKASI SESUAI STRUKTUR TABEL
// ======================================================
class PublikasiModel
{
    protected $db;

    // constructor koneksi
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ----------------------------------------------------
    // Ambil semua publikasi
    // ----------------------------------------------------
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT 
            p.*,
            pj.pokja_tipe AS tim,
            pj.pokja_nama AS nama_tim,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe)
                SEPARATOR '##'
            ) AS files

            FROM publikasi p

            LEFT JOIN pokja pj 
                ON p.pokja_id = pj.id

            LEFT JOIN publikasi_file pf 
                ON p.id = pf.publikasi_id

            GROUP BY p.id
            ORDER BY p.created_at DESC
        ");

        $stmt->execute();
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
        LEFT JOIN publikasi_file df ON publikasi.id = df.publikasi_id
        WHERE publikasi.is_active = 1
    ";

        $params = [];

        if (!empty($tanggalMulai)) {
            $sql .= " AND DATE(publikasi.tanggal_kegiatan) >= ?";
            $params[] = $tanggalMulai;
        }

        if (!empty($tanggalSelesai)) {
            $sql .= " AND DATE(publikasi.tanggal_kegiatan <= ?";
            $params[] = $tanggalSelesai;
        }

        if (!empty($jenis)) {
            $sql .= " AND publikasi.jenis_id = ?";
            $params[] = $jenis;
        }

        $sql .= "
        GROUP BY publiaksi.id
        ORDER BY publiaksi.tanggal_kegiatan DESC, publiaksi.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM publikasi WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ----------------------------------------------------
    // Simpan publikasi
    // ----------------------------------------------------
    public function insert($data)
    {
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
                dibuat_oleh
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
            $data['dibuat_oleh']
        ]);

        return $this->db->lastInsertId();
    }

    // ----------------------------------------------------
    // Update publikasi
    // ----------------------------------------------------
    public function update($id, $data)
    {
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
                pokja_id = ?
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
            $data['pokja_id'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE publikasi SET is_published = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    // ----------------------------------------------------
    // Simpan file publikasi (SESUAI TABEL publikasi_file)
    // ----------------------------------------------------
    public function insertFile($publikasi_id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO publikasi_file (
                publikasi_id,
                tipe, 
                nama_file, 
                path_file
            ) VALUES (?,?,?,?)
        ");

        return $stmt->execute([
            $publikasi_id,
            $file['tipe'],
            $file['nama_file'],
            $file['path_file']
        ]);
    }

    // ----------------------------------------------------
    // Ambil file berdasarkan publikasi
    // ----------------------------------------------------
    public function getFiles($publikasi_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM publikasi_file WHERE publikasi_id = ?
        ");

        $stmt->execute([$publikasi_id]);
        return $stmt->fetchAll();
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
