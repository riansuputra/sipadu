<?php

class PegawaiModel
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
            SELECT * FROM pegawai
            WHERE is_active = 1
            ORDER BY created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil detail DIP
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pegawai WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Simpan DIP baru
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pegawai (
                nip,
                nama_lengkap,
                tempat_lahir,
                tanggal_lahir,
                jenis_kelamin,
                status_pegawai,
                jabatan,
                pangkat,
                tmt_pengangkatan,
                pokja_id,
                email,
                no_hp,
                alamat_rumah,
                alamat_domisili,
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['nip'],
            $data['nama_lengkap'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['status_pegawai'],
            $data['jabatan'],
            $data['pangkat'],
            $data['tmt_pengangkatan'],
            $data['pokja_id'],
            $data['email'],
            $data['no_hp'],
            $data['alamat_rumah'],
            $data['alamat_domisili'],
        ]);

        return $this->db->lastInsertId();
    }

    // Update DIP
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE pegawai SET
                nip = ?,
                nama_lengkap = ?,
                tempat_lahir = ?,
                tanggal_lahir = ?,
                jenis_kelamin = ?,
                status_pegawai = ?,
                jabatan = ?,
                pangkat = ?,
                tmt_pengangkatan = ?,
                pokja_id = ?,
                email = ?,
                no_hp = ?,
                alamat_rumah = ?,
                alamat_domisili = ?,
            WHERE id = ? 
        ");

        return $stmt->execute([
            $data['nip'],
            $data['nama_lengkap'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['status_pegawai'],
            $data['jabatan'],
            $data['pangkat'],
            $data['tmt_pengangkatan'],
            $data['pokja_id'],
            $data['email'],
            $data['no_hp'],
            $data['alamat_rumah'],
            $data['alamat_domisili'],
        ]);
    }

    // Hapus DIP (soft delete)
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE pegawai SET is_active = 0 WHERE id = ?
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
            DELETE FROM pegawai_file WHERE dip_id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function deleteFilesByParent($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM pegawai_file WHERE dip_id = ?
        ");

        return $stmt->execute([$id]);
    }
}
