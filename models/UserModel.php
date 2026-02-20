<?php
require_once __DIR__ . '/../includes/koneksi.php';

class UserModel
{
    protected $db;

    public function __construct()
    {
        // ambil dari singleton
        $this->db = Database::getInstance();
    }

    // ============================
    // GET ALL USER
    // ============================
    public function getAll()
    {
        $stmt = $this->db->query("
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
        $stmt = $this->db->query("
        SELECT id, nama_role, kode_role
        FROM role
        ORDER BY id ASC
    ");

        return $stmt->fetchAll();
    }

    // ============================
    // GET ALL POKJA (UNTUK SELECT)
    // ============================
    public function getPokja()
    {
        $stmt = $this->db->query("
        SELECT id, pokja_nama, pokja_tipe
        FROM pokja
        ORDER BY id ASC
    ");

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
        // Jika password diisi
        if (!empty($data['password'])) {

            $stmt = $this->db->prepare("
            UPDATE users SET
                nama_lengkap = ?,
                role_id = ?,
                pokja_id = ?,
                password_hash = ?,
                is_active = ?
            WHERE id = ?
        ");

            return $stmt->execute([
                $data['nama_lengkap'],
                $data['role_id'],
                $data['pokja_id'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['is_active'],
                $id
            ]);
        }

        // Jika password kosong → tidak diubah
        $stmt = $this->db->prepare("
        UPDATE users SET
            nama_lengkap = ?,
            role_id = ?,
            pokja_id = ?,
            is_active = ?
        WHERE id = ?
    ");

        return $stmt->execute([
            $data['nama_lengkap'],
            $data['role_id'],
            $data['pokja_id'],
            $data['is_active'],
            $id
        ]);
    }
}
