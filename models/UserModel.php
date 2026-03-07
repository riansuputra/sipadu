<?php

class UserModel
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
            SELECT 
                u.*,
                r.nama_role,
                r.kode_role,
                p.pokja_nama
            FROM users u
            JOIN role r ON u.role_id = r.id
            LEFT JOIN pokja p ON u.pokja_id = p.id
            ORDER BY u.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function usernameExists($username)
    {
        $stmt = $this->db->prepare("
        SELECT id FROM users WHERE username = ?
    ");

        $stmt->execute([$username]);

        return $stmt->fetch() ? true : false;
    }


    // ============================
    // GET ALL ROLE (UNTUK SELECT)
    // ============================
    public function getRoles()
    {
        $stmt = $this->db->prepare("
            SELECT id, nama_role, kode_role
            FROM role
            ORDER BY id ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ============================
    // GET ALL POKJA (UNTUK SELECT)
    // ============================
    public function getPokja()
    {
        $stmt = $this->db->prepare("
            SELECT id, pokja_nama, pokja_tipe
            FROM pokja
            ORDER BY id ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }



    // ============================
    // FIND USER BY ID
    // ============================
    public function findById(int $id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ============================
    // INSERT USER BARU
    // ============================
    public function insert(array $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (
                username,
                password_hash,
                nama_lengkap,
                role_id,
                pokja_id,
                is_active
            ) VALUES (?,?,?,?,?,1)
        ");

        return $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['nama_lengkap'],
            $data['role_id'],
            $data['pokja_id'] ?: null
        ]);
    }

    // ============================
    // UPDATE PASSWORD
    // ============================
    // ================================
    // Update user
    // ================================
    public function update($id, $data)
    {
        $isActive = $data['is_active'] ?? 1;
        // Jika password diisi
        if (!empty($data['password_baru'])) {

            $stmt = $this->db->prepare("
            UPDATE users SET
                nama_lengkap = ?,
                username = ?,
                role_id = ?,
                pokja_id = ?,
                password_hash = ?,
                is_active = ?
            WHERE id = ?
        ");

            return $stmt->execute([
                $data['nama_lengkap'],
                $data['username'],
                $data['role_id'],
                $data['pokja_id'] ?? null,
                password_hash(trim($data['password_baru']), PASSWORD_DEFAULT),
                $isActive,
                $id
            ]);
        }

        // Jika password kosong → tidak diubah
        $stmt = $this->db->prepare("
        UPDATE users SET
            nama_lengkap = ?,
            username = ?,
            role_id = ?,
            pokja_id = ?,
            is_active = ?
        WHERE id = ?
    ");

        return $stmt->execute([
            $data['nama_lengkap'],
            $data['username'],
            $data['role_id'],
            $data['pokja_id'],
            $isActive,
            $id
        ]);
    }

    // ==============================
    // CARI USER BERDASARKAN USERNAME
    // ==============================
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("
            SELECT 
                u.id,
                u.username,
                u.password_hash,
                u.nama_lengkap,
                r.id as role_id,
                r.kode_role,
                p.id AS pokja_id,
                p.pokja_nama,
                p.pokja_tipe
            FROM users u
            JOIN role r ON u.role_id = r.id
            LEFT JOIN pokja p ON u.pokja_id = p.id
            WHERE u.username = ?
              AND u.is_active = 1
            LIMIT 1
        ");

        $stmt->execute([$username]);

        return $stmt->fetch();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE users SET 
                is_active = 0
            WHERE id = ?
        ");

        $stmt->execute([
            (int)$id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function active($id)
    {
        $stmt = $this->db->prepare("
            UPDATE users SET 
                is_active = 1
            WHERE id = ?
        ");

        $stmt->execute([
            (int)$id
        ]);

        return $stmt->rowCount() > 0;
    }
}
