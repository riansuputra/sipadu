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
            SELECT 
            p.*,
            GROUP_CONCAT(
                CONCAT(pf.id, '|', pf.jenis_dokumen, '|', pf.nama_file, '|', pf.path_file, '|', pf.tipe_file)
                SEPARATOR '##'
            ) AS files

            FROM pegawai p

            LEFT JOIN pegawai_file pf 
                ON p.id = pf.pegawai_id

            GROUP BY p.id
            ORDER BY p.created_at DESC
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
                nama,
                nik,
                nip,
                tempat_lahir,
                tanggal_lahir,
                jenis_kelamin,
                agama,
                alamat_domisili,
                no_telepon,
                email,
                status_asn,
                pangkat_golongan,
                grade,
                jabatan,
                pendidikan,
                jurusan,
                nomor_sk_pengangkatan,
                nomor_sk_spmt
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['nama'],
            $data['nik'],
            $data['nip'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['agama'],
            $data['alamat_domisili'],
            $data['no_telepon'],
            $data['email'],
            $data['status_asn'],
            $data['pangkat_golongan'],
            $data['grade'],
            $data['jabatan'],
            $data['pendidikan'],
            $data['jurusan'],
            $data['nomor_sk_pengangkatan'],
            $data['nomor_sk_spmt']
        ]);

        return $this->db->lastInsertId();
    }

    // Update DIP
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE pegawai SET
                nama = ?,
                nik = ?,
                nip = ?,
                tempat_lahir = ?,
                tanggal_lahir = ?,
                jenis_kelamin = ?,
                agama = ?,
                alamat_domisili = ?,
                no_telepon = ?,
                email = ?,
                status_asn = ?,
                pangkat_golongan = ?,
                grade = ?,
                jabatan = ?,
                pendidikan = ?,
                jurusan = ?,
                nomor_sk_pengangkatan = ?,
                nomor_sk_spmt = ?
            WHERE id = ? 
        ");

        return $stmt->execute([
            $data['nama'],
            $data['nik'],
            $data['nip'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['agama'],
            $data['alamat_domisili'],
            $data['no_telepon'],
            $data['email'],
            $data['status_asn'],
            $data['pangkat_golongan'],
            $data['grade'],
            $data['jabatan'],
            $data['pendidikan'],
            $data['jurusan'],
            $data['nomor_sk_pengangkatan'],
            $data['nomor_sk_spmt']
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
}
