<?php

class ModulModel
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

    public function getAllWithRelations()
    {
        $stmt = $this->db->prepare("
            SELECT 
                m.*,
                GROUP_CONCAT(DISTINCT CONCAT(p.pokja_tipe, ' ', p.pokja_nama) SEPARATOR ', ') AS pokja_list,
                GROUP_CONCAT(DISTINCT r.kode_role SEPARATOR ', ') AS role_list
            FROM modul m
            LEFT JOIN modul_pokja mp ON m.id = mp.modul_id
            LEFT JOIN pokja p ON mp.pokja_id = p.id
            LEFT JOIN modul_role mr ON m.id = mr.modul_id
            LEFT JOIN role r ON mr.role_id = r.id
            GROUP BY m.id
            ORDER BY 
                CASE WHEN m.parent_slug IS NULL OR m.parent_slug = '' THEN 0 ELSE 1 END,
                m.parent_slug ASC,
                m.urutan ASC,
                m.id ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM modul WHERE id = ? LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO modul (
            judul,
            deskripsi,
            link,
            parent_slug,
            target,
            gambar,
            urutan,
            is_active,
            is_global
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

        $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['link'],
            $data['parent_slug'],
            $data['target'],
            $data['gambar'],
            $data['urutan'],
            $data['is_active'],
            $data['is_global']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE modul SET
            judul = ?,
            deskripsi = ?,
            link = ?,
            parent_slug = ?,
            target = ?,
            gambar = ?,
            urutan = ?,
            is_active = ?,
            is_global = ?,
            updated_at = NOW()
        WHERE id = ?
    ");

        return $stmt->execute([
            $data['judul'],
            $data['deskripsi'],
            $data['link'],
            $data['parent_slug'],
            $data['target'],
            $data['gambar'] ?? null,
            (int) $data['urutan'],
            (int) $data['is_active'],
            (int) $data['is_global'],
            (int) $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM modul WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }

    public function getAllPokja()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pokja
            ORDER BY pokja_tipe ASC, pokja_nama ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRole()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM role
            ORDER BY id ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPokjaIdsByModul($modulId): array
    {
        $stmt = $this->db->prepare("
            SELECT pokja_id FROM modul_pokja WHERE modul_id = ?
        ");
        $stmt->execute([$modulId]);

        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    public function getRoleIdsByModul($modulId): array
    {
        $stmt = $this->db->prepare("
            SELECT role_id FROM modul_role WHERE modul_id = ?
        ");
        $stmt->execute([$modulId]);

        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    public function syncPokjas($modulId, array $pokjaIds)
    {
        $stmt = $this->db->prepare("DELETE FROM modul_pokja WHERE modul_id = ?");
        $stmt->execute([$modulId]);

        if (empty($pokjaIds)) return true;

        $stmt = $this->db->prepare("
            INSERT INTO modul_pokja (modul_id, pokja_id)
            VALUES (?, ?)
        ");

        foreach ($pokjaIds as $pokjaId) {
            if (!ctype_digit((string)$pokjaId)) continue;
            $stmt->execute([(int)$modulId, (int)$pokjaId]);
        }

        return true;
    }

    public function syncRoles($modulId, array $roleIds)
    {
        $stmt = $this->db->prepare("DELETE FROM modul_role WHERE modul_id = ?");
        $stmt->execute([$modulId]);

        if (empty($roleIds)) return true;

        $stmt = $this->db->prepare("
            INSERT INTO modul_role (
                modul_id,
                role_id,
                can_view,
                can_create,
                can_edit,
                can_delete
            ) VALUES (?, ?, 1, 0, 0, 0)
        ");

        foreach ($roleIds as $roleId) {
            if (!ctype_digit((string)$roleId)) continue;
            $stmt->execute([(int)$modulId, (int)$roleId]);
        }

        return true;
    }

    public function getAllActive()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM modul
            WHERE is_active = 1
            ORDER BY urutan ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByRole($roleId)
    {
        $stmt = $this->db->prepare("
            SELECT m.*
            FROM modul m
            JOIN modul_role mr ON m.id = mr.modul_id
            WHERE mr.role_id = ?
              AND m.is_active = 1
            ORDER BY m.urutan ASC
        ");
        $stmt->execute([$roleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // AMBIL MODUL BERDASARKAN HALAMAN
    // contoh: paud, sd, smp, sma, widyaprada, link-aplikasi
    // ================================
    public function getByParentSlug(string $parentSlug): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM modul
            WHERE is_active = 1
              AND parent_slug = ?
            ORDER BY urutan ASC, id ASC
        ");
        $stmt->execute([$parentSlug]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // VALIDASI AKSES HALAMAN / MODUL
    // ================================
    public function canAccess(string $roleName, ?int $pokjaId, string $link): bool
    {
        if (in_array($roleName, ['Superadmin', 'Pimpinan'])) {
            return true;
        }

        if (!$pokjaId) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT id, is_global
            FROM modul
            WHERE link = ?
            AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$link]);
        $modul = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$modul) {
            return false;
        }

        if ((int)$modul['is_global'] === 1) {
            return true;
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM modul_pokja
            WHERE modul_id = ?
            AND pokja_id = ?
        ");
        $stmt->execute([$modul['id'], $pokjaId]);

        return $stmt->fetchColumn() > 0;
    }

    // ================================
    // VALIDASI AKSES MODUL TAMBAHAN
    // berdasarkan modul_id
    // ================================
    public function canAccessByModulId(string $roleName, ?int $pokjaId, int $modulId): bool
    {
        if (in_array($roleName, ['Superadmin', 'Pimpinan'])) {
            return true;
        }

        if (!$pokjaId) {
            return false;
        }

        // staff/admin Widyaprada boleh lintas tim
        if ((int)$pokjaId === 5) {
            return true;
        }

        $stmt = $this->db->prepare("
            SELECT id, is_global
            FROM modul
            WHERE id = ?
            AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$modulId]);
        $modul = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$modul) {
            return false;
        }

        if ((int)$modul['is_global'] === 1) {
            return true;
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM modul_pokja
            WHERE modul_id = ?
            AND pokja_id = ?
        ");
        $stmt->execute([$modul['id'], $pokjaId]);

        return $stmt->fetchColumn() > 0;
    }

    public function canAccessPage(string $roleName, ?string $pokjaNama, string $page): bool
    {
        $pokjaNama = trim((string) $pokjaNama);

        // =====================================
        // 1. SUPERADMIN & PIMPINAN = akses semua
        // =====================================
        if (in_array($roleName, ['Superadmin', 'Pimpinan'], true)) {
            return true;
        }

        // =====================================
        // 2. HALAMAN GLOBAL (semua user login boleh)
        // =====================================
        $globalPages = [
            'pegawai-publik',
            'link-aplikasi',
            'peraturan-publik',
            'arsip-saya',
            'dip-publik',
            'zi-wbbm-publik',
        ];

        if (in_array($page, $globalPages, true)) {
            return true;
        }

        // =====================================
        // 3. HALAMAN TIM
        // =====================================
        $timPages = [
            'paud'       => 'PAUD',
            'sd'         => 'SD',
            'smp'        => 'SMP',
            'sma'        => 'SMA',
            'widyaprada' => 'Widyaprada',
        ];

        if (isset($timPages[$page])) {

            // user hanya boleh akses tim sendiri
            if ($pokjaNama === $timPages[$page]) {
                return true;
            }

            // Widyaprada boleh akses semua halaman tim
            if ($pokjaNama === 'Widyaprada') {
                return true;
            }

            return false;
        }

        // =====================================
        // 4. default deny
        // =====================================
        return false;
    }

    // Ambil urutan berikutnya berdasarkan parent_slug
    public function getNextUrutan($parentSlug = null)
    {
        if (!empty($parentSlug)) {
            $stmt = $this->db->prepare("
            SELECT COALESCE(MAX(urutan), 0) + 1
            FROM modul
            WHERE parent_slug = ?
        ");
            $stmt->execute([$parentSlug]);
        } else {
            $stmt = $this->db->prepare("
            SELECT COALESCE(MAX(urutan), 0) + 1
            FROM modul
        ");
            $stmt->execute();
        }

        return (int) $stmt->fetchColumn();
    }

    public function canAccessHardcodedPage(string $roleName, ?string $pokjaNama, string $page): bool
    {
        $pokjaNama = trim((string) $pokjaNama);

        // =====================================
        // 1. SUPERADMIN & PIMPINAN = akses semua
        // =====================================
        if (in_array($roleName, ['Superadmin', 'Pimpinan'], true)) {
            return true;
        }

        // =====================================
        // 2. HALAMAN GLOBAL (semua user login boleh)
        // =====================================
        $globalPages = [
            'link-aplikasi',
            'pegawai-publik',
            'peraturan-publik',
            'arsip-saya',
            'dip-publik',
            'zi-wbbm-publik',
        ];

        if (in_array($page, $globalPages, true)) {
            return true;
        }

        // =====================================
        // 3. HALAMAN TIM
        // =====================================
        $timPages = [
            'paud'       => 'PAUD',
            'sd'         => 'SD',
            'smp'        => 'SMP',
            'sma'        => 'SMA',
            'widyaprada' => 'Widyaprada',
        ];

        if (isset($timPages[$page])) {

            // akses sesuai tim sendiri
            if ($pokjaNama === $timPages[$page]) {
                return true;
            }

            // Widyaprada boleh akses semua halaman tim
            if ($pokjaNama === 'Widyaprada') {
                return true;
            }

            return false;
        }

        // =====================================
        // 4. default deny
        // =====================================
        return false;
    }

    // ================================
    // CEK AKSES MODUL BERDASARKAN LINK
    // ================================
    public function canAccessModuleByLink(string $roleName, ?int $pokjaId, string $link): bool
    {
        // cari modul berdasarkan link
        $stmt = $this->db->prepare("
        SELECT id, link, parent_slug, is_active
        FROM modul
        WHERE link = ?
        LIMIT 1
    ");
        $stmt->execute([$link]);
        $modul = $stmt->fetch(PDO::FETCH_ASSOC);

        // kalau modul tidak ada / nonaktif
        if (!$modul || (int)$modul['is_active'] !== 1) {
            return false;
        }

        // ============================
        // JIKA MODUL CHILD
        // ============================
        if (!empty($modul['parent_slug'])) {
            return $this->canAccessPage($roleName, $pokjaId, $modul['parent_slug']);
        }

        // ============================
        // JIKA MODUL UTAMA / ROOT
        // ============================
        return $this->canAccessPage($roleName, $pokjaId, $modul['link']);
    }

    public function getByLink(string $link)
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM modul
        WHERE link = ?
        AND is_active = 1
        LIMIT 1
    ");
        $stmt->execute([$link]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
