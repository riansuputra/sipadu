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
            SELECT * FROM publikasi
            WHERE is_published = 1
            ORDER BY created_at DESC
        ");

        $stmt->execute();
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
                pokja_id, 
                dibuat_oleh
            ) VALUES (?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['tanggal_kegiatan'],
            $data['lokasi'],
            $data['pokja_id'],
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
                pokja_id = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['tanggal_kegiatan'],
            $data['lokasi'],
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
