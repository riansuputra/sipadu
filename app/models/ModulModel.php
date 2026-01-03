<?php

class ModulModel
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * 🔐 Cek akses module berdasarkan:
     * - kode_role
     * - pokja_id
     * - modul link
     */
    public function userHasAccess(string $kodeRole, ?int $groupId, string $modulLink): bool
    {
        // 1️⃣ ADMIN & ATASAN bebas
        if (in_array($kodeRole, ['Superadmin', 'Pimpinan'])) {
            return true;
        }

        // 2️⃣ Cek module + role
        $stmt = $this->db->prepare("
            SELECT m.id, m.is_global
            FROM modul m
            JOIN modul_role mr ON m.id = mr.modul_id
            JOIN role r ON mr.role_id = r.id
            WHERE r.kode_role = ?
              AND m.link = ?
              AND m.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$kodeRole, $modulLink]);
        $modul = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$modul) {
            return false;
        }

        // 3️⃣ Module global
        if ((int)$modul['is_global'] === 1) {
            return true;
        }

        // 4️⃣ Cek work group (khusus PEGAWAI)
        if ($groupId === null) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM modul_pokja
            WHERE modul_id = ?
              AND pokja_id = ?
        ");
        $stmt->execute([$modul['id'], $groupId]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * 🧩 Module untuk card berdasarkan role
     */
    public function getModulByRole(string $kodeRole): array
    {
        $stmt = $this->db->prepare("
            SELECT m.*
            FROM module m
            JOIN modul_role mr ON m.id = mr.modul_id
            JOIN role r ON mr.role_id = r.id
            WHERE r.kode_role = ?
              AND m.is_active = 1
            ORDER BY m.urutan ASC
        ");
        $stmt->execute([$kodeRole]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 🧩 Semua module aktif (card dashboard)
     */
    public function getAllActiveModules(): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM modul
            WHERE is_active = 1
            ORDER BY urutan ASC
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 🧩 Module sesuai role (card dashboard)
     */
    public function getVisibleModulesByRoleCode($kodeRole)
    {
        $sql = "
        SELECT DISTINCT m.*
        FROM modul m
        LEFT JOIN modul_role mr ON m.id = mr.modul_id
        LEFT JOIN role r ON mr.role_id = r.id
        WHERE m.is_active = 1
        AND (
            m.is_global = 1
            OR r.kode_role = ?
        )
        ORDER BY m.urutan ASC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$kodeRole]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
