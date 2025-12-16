<?php

class ModuleModel
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * 🔐 Cek akses module berdasarkan:
     * - role_code
     * - work_group_id
     * - module link
     */
    public function userHasAccess(string $roleCode, ?int $groupId, string $moduleLink): bool
    {
        // 1️⃣ ADMIN & ATASAN bebas
        if (in_array($roleCode, ['ADMIN', 'ATASAN'])) {
            return true;
        }

        // 2️⃣ Cek module + role
        $stmt = $this->db->prepare("
            SELECT m.id, m.is_global
            FROM modules m
            JOIN module_roles mr ON m.id = mr.module_id
            JOIN roles r ON mr.role_id = r.id
            WHERE r.role_code = ?
              AND m.link = ?
              AND m.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$roleCode, $moduleLink]);
        $module = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$module) {
            return false;
        }

        // 3️⃣ Module global
        if ((int)$module['is_global'] === 1) {
            return true;
        }

        // 4️⃣ Cek work group (khusus PEGAWAI)
        if ($groupId === null) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM module_work_groups
            WHERE module_id = ?
              AND work_group_id = ?
        ");
        $stmt->execute([$module['id'], $groupId]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * 🧩 Module untuk card berdasarkan role
     */
    public function getModulesByRole(string $roleCode): array
    {
        $stmt = $this->db->prepare("
            SELECT m.*
            FROM modules m
            JOIN module_roles mr ON m.id = mr.module_id
            JOIN roles r ON mr.role_id = r.id
            WHERE r.role_code = ?
              AND m.is_active = 1
            ORDER BY m.sort_order ASC
        ");
        $stmt->execute([$roleCode]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 🧩 Semua module aktif (card dashboard)
     */
    public function getAllActiveModules(): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM modules
            WHERE is_active = 1
            ORDER BY sort_order ASC
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 🧩 Module sesuai role (card dashboard)
     */
    public function getVisibleModulesByRoleCode($roleCode)
    {
        $sql = "
        SELECT DISTINCT m.*
        FROM modules m
        LEFT JOIN module_roles mr ON m.id = mr.module_id
        LEFT JOIN roles r ON mr.role_id = r.id
        WHERE m.is_active = 1
        AND (
            m.is_global = 1
            OR r.role_code = ?
        )
        ORDER BY m.sort_order ASC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$roleCode]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
