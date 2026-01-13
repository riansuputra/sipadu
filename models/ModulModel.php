<?php

class ModulModel
{
    protected $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Ambil semua modul aktif (untuk dashboard staff)
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

    // Ambil modul sesuai role (untuk sidebar admin/pimpinan)
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

    // Cek apakah user boleh akses modul
    public function canAccess(string $roleName, ?int $pokjaId, string $link): bool
    {
        // --------------------------------
        // 1. SUPERADMIN & PIMPINAN BEBAS
        // --------------------------------
        if (in_array($roleName, ['Superadmin', 'Pimpinan'])) {
            return true;
        }

        // --------------------------------
        // 2. CEK MODUL + ROLE
        // --------------------------------
        $stmt = $this->db->prepare("
        SELECT m.id, m.is_global
        FROM modul m
        JOIN modul_role mr ON m.id = mr.modul_id
        JOIN role r ON mr.role_id = r.id
        WHERE r.nama_role = ?
          AND m.link = ?
          AND m.is_active = 1
        LIMIT 1
    ");
        $stmt->execute([$roleName, $link]);
        $modul = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$modul) {
            return false;
        }

        // --------------------------------
        // 3. MODUL GLOBAL → BOLEH SEMUA
        // --------------------------------
        if ((int)$modul['is_global'] === 1) {
            return true;
        }

        // --------------------------------
        // 4. STAFF / ADMIN TIM → CEK POKJA
        // --------------------------------
        if (!$pokjaId) {
            return false;
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
}
