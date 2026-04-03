<?php

class PeraturanJenisModel
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
        $stmt = $this->db->prepare("
            SELECT *
            FROM peraturan_jenis
            WHERE is_active = 1
            ORDER BY nama ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT *
            FROM peraturan_jenis
            WHERE id = ?
        ");

        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    // ==========================
    // INSERT
    // ==========================
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO peraturan_jenis (
                kode,
                nama,
                keterangan,
                is_active
            ) VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['keterangan'] ?? null,
            $data['is_active'] ?? 1
        ]);

        return $this->db->lastInsertId();
    }

    // ==========================
    // UPDATE
    // ==========================
    public function update($id, $data)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE peraturan_jenis SET
                kode = ?,
                nama = ?,
                keterangan = ?,
                is_active = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['keterangan'] ?? null,
            $data['is_active'] ?? 1,
            (int)$id
        ]);
    }

    // ==========================
    // VALIDASI RELASI
    // ==========================
    public function isUsed($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM peraturan 
            WHERE jenis_id = ?
        ");

        $stmt->execute([(int)$id]);

        return $stmt->fetchColumn() > 0;
    }

    // ==========================
    // SOFT DELETE
    // ==========================
    public function delete($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE peraturan_jenis
            SET is_active = 0
            WHERE id = ?
        ");

        return $stmt->execute([(int)$id]);
    }

    public function kodeExists($kode, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM peraturan_jenis WHERE kode = ?";

        $params = [$kode];

        // untuk update (ignore id sendiri)
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    public function findByName($nama)
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM peraturan_jenis
        WHERE nama = ?
        LIMIT 1
    ");

        $stmt->execute([$nama]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function reactivate($id)
    {
        $stmt = $this->db->prepare("
        UPDATE peraturan_jenis
        SET is_active = 1
        WHERE id = ?
    ");

        return $stmt->execute([$id]);
    }
}
