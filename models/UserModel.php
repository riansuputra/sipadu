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

            -- role aktif/default user
            r.nama_role,
            r.kode_role,

            pg.nama AS pegawai_nama,
            pg.nip AS pegawai_nip,

            -- default pokja
            p_default.pokja_nama AS pokja_nama,

            -- akses lama (opsional/backward compatibility)
            GROUP_CONCAT(
                DISTINCT CONCAT(
                    pk.pokja_tipe,
                    ' ',
                    pk.pokja_nama
                )
                ORDER BY pk.pokja_nama ASC
                SEPARATOR ', '
            ) AS akses_pokja,

            -- 🔥 akses detail baru
            GROUP_CONCAT(
                DISTINCT CONCAT(
                    pk.pokja_tipe,
                    ' ',
                    pk.pokja_nama,
                    '|',
                    COALESCE(rp.nama_role, '-'),
                    '|',
                    COALESCE(rp.kode_role, '-'),
                    '|',
                    up.is_default
                )
                ORDER BY pk.pokja_nama ASC
                SEPARATOR ';;'
            ) AS akses_detail

        FROM users u

        -- role aktif/default
        LEFT JOIN role r 
            ON u.role_id = r.id

        LEFT JOIN pegawai pg 
            ON u.pegawai_id = pg.id

        -- semua akses user
        LEFT JOIN user_pokja up
            ON up.user_id = u.id
            AND up.is_active = 1

        LEFT JOIN pokja pk
            ON pk.id = up.pokja_id

        -- role per pokja
        LEFT JOIN role rp
            ON rp.id = up.role_id

        -- default pokja
        LEFT JOIN pokja p_default
            ON p_default.id = u.pokja_id

        GROUP BY u.id

        ORDER BY u.created_at DESC
    ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        SELECT 
            u.*,
            r.nama_role,
            r.kode_role,
            p.pokja_nama,
            pg.nama AS pegawai_nama,
            pg.nip AS pegawai_nip
        FROM users u
        JOIN role r ON u.role_id = r.id
        LEFT JOIN pokja p ON u.pokja_id = p.id
        LEFT JOIN pegawai pg ON u.pegawai_id = pg.id
        WHERE u.id = ?
        LIMIT 1
    ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function insert(array $data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO users (
            username,
            password_hash,
            nama_lengkap,
            pegawai_id,
            role_id,
            pokja_id,
            is_active
        ) VALUES (?,?,?,?,?,?,1)
    ");

        $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['nama_lengkap'],
            $data['pegawai_id'] ?: null,

            // 🔥 role utama user
            $data['role_id'],

            // 🔥 pokja aktif/default
            $data['pokja_id'] ?: null
        ]);

        // ambil id user baru
        $userId = $this->db->lastInsertId();

        // simpan multi pokja
        if (!empty($data['pokja_ids'])) {

            $this->saveUserPokja(
                $userId,
                $data['pokja_ids'],
                $data['role_per_pokja'] ?? [],
                $data['pokja_default'] ?? null
            );
        }

        return true;
    }

    public function update($id, $data)
    {
        $isActive = $data['is_active'] ?? 1;

        // =========================
        // DENGAN PASSWORD
        // =========================
        if (!empty($data['password_baru'])) {

            $stmt = $this->db->prepare("
            UPDATE users SET
                nama_lengkap = ?,
                username = ?,
                pegawai_id = ?,
                role_id = ?,
                pokja_id = ?,
                password_hash = ?,
                is_active = ?
            WHERE id = ?
        ");

            $stmt->execute([
                $data['nama_lengkap'],
                $data['username'],
                $data['pegawai_id'] ?: null,

                // 🔥 role utama
                $data['role_id'],

                // 🔥 pokja aktif/default
                $data['pokja_id'] ?: null,

                password_hash(trim($data['password_baru']), PASSWORD_DEFAULT),

                $isActive,
                $id
            ]);
        }

        // =========================
        // TANPA PASSWORD
        // =========================
        else {

            $stmt = $this->db->prepare("
            UPDATE users SET
                nama_lengkap = ?,
                username = ?,
                pegawai_id = ?,
                role_id = ?,
                pokja_id = ?,
                is_active = ?
            WHERE id = ?
        ");

            $stmt->execute([
                $data['nama_lengkap'],
                $data['username'],
                $data['pegawai_id'] ?: null,

                // 🔥 role utama
                $data['role_id'],

                // 🔥 pokja aktif/default
                $data['pokja_id'] ?: null,

                $isActive,
                $id
            ]);
        }

        // =========================
        // UPDATE MULTI POKJA
        // =========================
        if (isset($data['pokja_ids'])) {

            $this->saveUserPokja(
                $id,
                $data['pokja_ids'],
                $data['role_per_pokja'] ?? [],
                $data['pokja_default'] ?? null
            );
        }

        return true;
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

    // ==============================
    // AMBIL SEMUA POKJA USER
    // ==============================
    public function getUserPokjaList($userId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            pk.id,
            pk.pokja_nama,
            pk.slug,
            pk.pokja_tipe,
            

            up.role_id,
            up.is_default,

            r.nama_role,
            r.kode_role
        FROM user_pokja up
        JOIN pokja pk ON up.pokja_id = pk.id
        LEFT JOIN role r
            ON r.id = up.role_id
        WHERE up.user_id = ?
          AND up.is_active = 1
        ORDER BY pk.pokja_nama ASC
    ");

        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // ================================
    // Ambil role per pokja user
    // ================================
    public function getUserRolePokja($userId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            pokja_id,
            role_id
        FROM user_pokja
        WHERE user_id = ?
        AND is_active = 1
    ");

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================
    // SIMPAN USER POKJA
    // ============================
    public function saveUserPokja(
        $userId,
        array $pokjaIds,
        array $rolePerPokja,
        $defaultPokja = null
    ) {

        // hapus lama
        $delete = $this->db->prepare("
        DELETE FROM user_pokja
        WHERE user_id = ?
    ");

        $delete->execute([$userId]);

        // insert baru
        $stmt = $this->db->prepare("
        INSERT INTO user_pokja (
            user_id,
            pokja_id,
            role_id,
            is_default,
            is_active
        ) VALUES (?,?,?,?,1)
    ");

        foreach ($pokjaIds as $pokjaId) {

            $roleId = $rolePerPokja[(string)$pokjaId] ?? null;

            // skip kalau role kosong
            if (!$roleId) {
                continue;
            }

            $stmt->execute([
                $userId,
                $pokjaId,
                $roleId,
                ($defaultPokja == $pokjaId ? 1 : 0)
            ]);
        }
    }

    public function getUserPokja($userId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            up.pokja_id,
            up.role_id,
            up.is_default,

            p.pokja_nama AS nama,
            p.slug,
            p.pokja_tipe AS tipe,

            r.nama_role,
            r.kode_role

        FROM user_pokja up

        JOIN pokja p 
            ON up.pokja_id = p.id

        LEFT JOIN role r
            ON r.id = up.role_id

        WHERE up.user_id = ?
        AND up.is_active = 1
    ");

        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    // ================================
    // RESET GOOGLE AUTHENTICATOR
    // ================================
    public function reset2FA($userId)
    {
        $stmt = $this->db->prepare("
        UPDATE users
        SET
            secret_code = NULL,
            is_2fa_enabled = 0
        WHERE id = ?
    ");

        return $stmt->execute([$userId]);
    }
}
