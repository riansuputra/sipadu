<?php
// ================================
// MODEL DIP
// ================================

class DipModel
{
    protected $db;

    // koneksi database
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Ambil semua data DIP
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT 
                dip.*,
                GROUP_CONCAT(
                    CONCAT(df.id, '|', df.nama_file, '|', df.path_file, '|', df.tipe_file) 
                    SEPARATOR '##'
                ) AS files
            FROM dip
            LEFT JOIN dip_file df ON dip.id = df.dip_id
            WHERE dip.is_active = 1
            GROUP BY dip.id
            ORDER BY dip.created_at DESC
        ");


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil detail DIP
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM dip WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Simpan DIP baru
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO dip (
                judul_informasi,
                ringkasan,
                unit_penguasaan,
                penanggung_jawab,
                jenis_informasi,
                bentuk_informasi,
                tanggal_pembuatan,
                tempat_pembuatan,
                retensi_arsip,
                dibuat_oleh
            ) VALUES (?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['judul_informasi'],
            $data['ringkasan'],
            $data['unit_penguasaan'],
            $data['penanggung_jawab'],
            $data['jenis_informasi'],
            $data['bentuk_informasi'],
            $data['tanggal_pembuatan'],
            $data['tempat_pembuatan'],
            $data['retensi_arsip'],
            $data['dibuat_oleh']
        ]);

        return $this->db->lastInsertId();
    }

    // Update DIP
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE dip SET
                judul_informasi = ?,
                ringkasan = ?,
                unit_penguasaan = ?,
                penanggung_jawab = ?,
                jenis_informasi = ?,
                bentuk_informasi = ?,
                tanggal_pembuatan = ?,
                tempat_pembuatan = ?,
                retensi_arsip = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['judul_informasi'],
            $data['ringkasan'],
            $data['unit_penguasaan'],
            $data['penanggung_jawab'],
            $data['jenis_informasi'],
            $data['bentuk_informasi'],
            $data['tanggal_pembuatan'],
            $data['tempat_pembuatan'],
            $data['retensi_arsip'],
            $id
        ]);
    }

    // Hapus DIP (soft delete)
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE dip SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    // Simpan file DIP
    public function insertFile($dipId, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO dip_file (
                dip_id,
                nama_file,
                path_file,
                tipe_file,
                ukuran_file
            ) VALUES (?,?,?,?,?)
        ");

        return $stmt->execute([
            $dipId,
            $file['nama_file'],
            $file['path_file'],
            $file['tipe_file'],
            $file['ukuran_file']
        ]);
    }

    // Ambil file berdasarkan DIP
    public function getFiles($dipId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM dip_file 
            WHERE dip_id = ?
        ");

        $stmt->execute([$dipId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFiles($dipId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM dip_file WHERE dip_id = ?
        ");

        return $stmt->execute([$dipId]);
    }

    public function deleteFilesByParent($dipId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM dip_file WHERE dip_id = ?
        ");

        return $stmt->execute([$dipId]);
    }
}
