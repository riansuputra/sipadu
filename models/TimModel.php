<?php


class TimModel
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
            SELECT * FROM pokja
            ORDER BY pokja_nama ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pokja
            WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // simpan
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pokja (
                pokja_tipe, 
                pokja_nama
            ) VALUES (?, ?)
        ");

        $stmt->execute([
            $data['pokja_tipe'],
            $data['pokja_nama']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE pokja SET
                pokja_tipe = ?, 
                pokja_nama = ?
            WHERE id = ? 
        ");

        return $stmt->execute([
            $data['pokja_tipe'],
            $data['pokja_nama'],
            $id
        ]);
    }

    public function isUsed($id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM users 
        WHERE pokja_id = ?
    ");

        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }


    // hapus
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM pokja WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}
