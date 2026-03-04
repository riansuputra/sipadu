<?php

class NotifikasiModel
{

    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // simpan notifikasi baru
    public function create($judul, $pesan, $url, $role)
    {
        $stmt = $this->db->prepare("
            INSERT INTO notifikasi (judul, pesan, url, role_target)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$judul, $pesan, $url, $role]);
    }

    // hitung notifikasi belum dibaca
    public function countUnread($role)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total 
            FROM notifikasi 
            WHERE is_read = 0 
            AND (role_target = ? OR role_target = 'semua')
        ");
        $stmt->execute([$role]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // ambil daftar notifikasi terbaru
    public function getLatest($role)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM notifikasi 
            WHERE (role_target = ? OR role_target = 'semua')
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // tandai sudah dibaca
    public function markAsRead($id)
    {
        $stmt = $this->db->prepare("
            UPDATE notifikasi SET is_read = 1 WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
}
