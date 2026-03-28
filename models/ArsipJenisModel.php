<?php


class ArsipJenisModel
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
            SELECT * FROM arsip_jenis
            WHERE arsip_jenis.is_active = 1
            ORDER BY nama ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip_jenis
            WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // simpan
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO arsip_jenis (
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
            UPDATE arsip_jenis SET
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
            UPDATE arsip_jenis SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}
