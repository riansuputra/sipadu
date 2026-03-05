<?php

class ModulModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
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
}
