<?php

class NotifikasiModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Buat notifikasi master
    public function createMaster($judul, $pesan, $url)
    {
        $stmt = $this->db->prepare("
            INSERT INTO notifikasi (judul, pesan, url)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$judul, $pesan, $url]);

        return $this->db->lastInsertId();
    }

    // Assign ke user tertentu
    public function assignToUser($notifikasi_id, $user_id)
    {
        $stmt = $this->db->prepare("
            INSERT INTO notifikasi_user (notifikasi_id, user_id)
            VALUES (?, ?)
        ");
        return $stmt->execute([$notifikasi_id, $user_id]);
    }

    // Hitung unread per user
    public function countUnread($user_id)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM notifikasi_user
            WHERE user_id = ? AND is_read = 0
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Ambil list terbaru
    public function getLatest($user_id)
    {
        $stmt = $this->db->prepare("
        SELECT 
            n.id as notif_id,
            n.judul,
            n.pesan,
            n.url,
            nu.is_read
        FROM notifikasi n
        JOIN notifikasi_user nu 
            ON n.id = nu.notifikasi_id
        WHERE nu.user_id = ?
        ORDER BY n.created_at DESC
        LIMIT 5
    ");

        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Tandai 1 notif
    public function markAsRead($id, $user_id)
    {
        $stmt = $this->db->prepare("
            UPDATE notifikasi_user
            SET is_read = 1, read_at = NOW()
            WHERE notifikasi_id = ? AND user_id = ?
        ");
        return $stmt->execute([$id, $user_id]);
    }

    // Mark all
    public function markAllRead($user_id)
    {
        $stmt = $this->db->prepare("
            UPDATE notifikasi_user
            SET is_read = 1, read_at = NOW()
            WHERE user_id = ?
        ");
        return $stmt->execute([$user_id]);
    }

    // ambil user berdasarkan nama role
    public function getUsersByRoleAndPokja($roles, $keywordPokja)
    {
        $in = str_repeat('?,', count($roles) - 1) . '?';

        $stmt = $this->db->prepare("
        SELECT u.id
        FROM users u
        JOIN role r ON u.role_id = r.id
        JOIN pokja p ON u.pokja_id = p.id
        WHERE r.kode_role IN ($in)
        AND p.pokja_nama LIKE ?
    ");

        $params = array_merge($roles, ["%$keywordPokja%"]);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
