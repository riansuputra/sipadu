<?php

require_once __DIR__ . '/../includes/koneksi.php';


class ModulModel
{
    protected $db;

    public function __construct()
    {
        // ambil dari singleton
        $this->db = Database::getInstance();
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
        // SUPERADMIN & PIMPINAN BEBAS
        if (in_array($roleName, ['Superadmin', 'Pimpinan'])) {
            return true;
        }

        // ADMIN & STAFF → WAJIB POKJA
        if (!$pokjaId) {
            return false;
        }

        // Ambil modul
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

        // MODUL GLOBAL → BOLEH
        if ((int)$modul['is_global'] === 1) {
            return true;
        }

        // CEK MODUL ↔ POKJA
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
