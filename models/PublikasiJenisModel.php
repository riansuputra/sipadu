<?php


class PublikasiJenisModel
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

    // ambil semua
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM publikasi_jenis
            WHERE publikasi_jenis.is_active = 1
            ORDER BY nama ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM publikasi_jenis
            WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // simpan
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO publikasi_jenis (
                nama, 
                keterangan, 
                is_active
            ) VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $data['nama'],
            $data['keterangan'],
            $data['is_active']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE publikasi_jenis SET
                nama = ?, 
                keterangan = ?, 
                is_active = ? 
            WHERE id = ? 
        ");

        return $stmt->execute([
            $data['nama'],
            $data['keterangan'],
            $data['is_active'],
            $id
        ]);
    }

    public function isUsed($id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM publikasi 
        WHERE jenis_id = ?
    ");

        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }


    // hapus
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE publikasi_jenis SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function findByName($nama)
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM pegawai_jabatan
        WHERE nama = ?
        LIMIT 1
    ");

        $stmt->execute([$nama]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function reactivate($id)
    {
        $stmt = $this->db->prepare("
        UPDATE pegawai_jabatan
        SET is_active = 1
        WHERE id = ?
    ");

        return $stmt->execute([$id]);
    }
}
