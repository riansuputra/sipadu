<?php

class NotifikasiModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Buat notifikasi master
    // Buat notifikasi master
    public function createMaster(
        $judul,
        $pesan,
        $url = null,
        $type = null,
        $ref_id = null
    ) {
        $stmt = $this->db->prepare("
        INSERT INTO notifikasi (
            judul,
            pesan,
            url,
            type,
            ref_id
        )
        VALUES (?, ?, ?, ?, ?)
    ");

        $stmt->execute([
            $judul,
            $pesan,
            $url,
            $type,
            $ref_id
        ]);

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
            n.id AS notif_id,
            n.judul,
            n.pesan,
            n.url,
            n.type,
            n.ref_id,
            n.created_at,
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
    // ambil user berdasarkan role + pokja
    public function getUsersByRoleAndPokja($roles, $keywordPokja)
    {
        $in = str_repeat('?,', count($roles) - 1) . '?';

        $stmt = $this->db->prepare("
        SELECT DISTINCT u.id
        FROM users u

        JOIN user_pokja up 
            ON u.id = up.user_id

        JOIN role r 
            ON up.role_id = r.id

        JOIN pokja p 
            ON up.pokja_id = p.id

        WHERE r.kode_role IN ($in)
        AND p.pokja_nama LIKE ?
        AND up.is_active = 1
    ");

        $params = array_merge($roles, ["%$keywordPokja%"]);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // generate notif ulang tahun pegawai
    public function generateBirthdayNotif()
    {
        // ambil pegawai ultah hari ini & besok
        $stmt = $this->db->prepare("
        SELECT id, nama, tanggal_lahir
        FROM pegawai
        WHERE 
            DATE_FORMAT(tanggal_lahir, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')
            OR
            DATE_FORMAT(tanggal_lahir, '%m-%d') = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY), '%m-%d')
    ");

        $stmt->execute();

        $pegawais = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pegawais as $pegawai) {

            $today = date('m-d');

            $birthDate = date('m-d', strtotime($pegawai['tanggal_lahir']));

            // =========================
            // TENTUKAN PESAN
            // =========================

            // Hari H
            if ($birthDate == $today) {

                $pesan = 'Hari ini (' . formatTanggalIndonesia(date('Y-m-d')) . ') ' .
                    $pegawai['nama'] .
                    ' berulang tahun 🎂';
            }

            // H-1
            else {

                $pesan = 'Besok (' . formatTanggalIndonesia(date('Y-m-d', strtotime('+1 day'))) . ') ' .
                    $pegawai['nama'] .
                    ' akan berulang tahun 🎂';
            }

            // =========================
            // CEK DUPLIKAT
            // =========================
            $check = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM notifikasi
            WHERE judul = '[🎉] Ulang Tahun Pegawai'
            AND pesan = ?
            AND DATE(created_at) = CURDATE()
        ");

            $check->execute([$pesan]);

            $exists = $check->fetch(PDO::FETCH_ASSOC);

            // kalau sudah ada → skip
            if ($exists['total'] > 0) {
                continue;
            }

            // =========================
            // BUAT NOTIF MASTER
            // =========================
            $notif_id = $this->createMaster(
                '[🎉] Ulang Tahun Pegawai',
                $pesan,
                null
            );

            // =========================
            // AMBIL USER SUPERADMIN & PIMPINAN
            // =========================
            $in = "?,?";

            $users = $this->db->prepare("
            SELECT DISTINCT u.id
FROM users u

JOIN user_pokja up
    ON u.id = up.user_id

JOIN role r
    ON up.role_id = r.id

WHERE r.kode_role IN ($in)
AND up.is_active = 1
        ");

            $users->execute(['Superadmin', 'Pimpinan']);

            $listUsers = $users->fetchAll(PDO::FETCH_ASSOC);

            // =========================
            // ASSIGN KE USER
            // =========================
            foreach ($listUsers as $user) {
                $this->assignToUser($notif_id, $user['id']);
            }
        }
    }

    // Ambil user berdasarkan daftar pegawai
    public function getUserIdsByPegawaiIds(array $pegawaiIds)
    {
        if (empty($pegawaiIds)) {
            return [];
        }

        // Hilangkan ID duplikat
        $pegawaiIds = array_values(
            array_unique(
                array_map('intval', $pegawaiIds)
            )
        );

        $placeholders = implode(
            ',',
            array_fill(0, count($pegawaiIds), '?')
        );

        $stmt = $this->db->prepare("
        SELECT DISTINCT id
        FROM users
        WHERE pegawai_id IN ($placeholders)
    ");

        $stmt->execute($pegawaiIds);

        return array_map(
            'intval',
            $stmt->fetchAll(PDO::FETCH_COLUMN)
        );
    }

    // Ambil role berdasarkan akses/pokja yang sedang aktif
    public function getActiveRole($userId, $pokjaId)
    {
        $stmt = $this->db->prepare("
        SELECT r.kode_role
        FROM user_pokja up

        JOIN role r
            ON r.id = up.role_id

        WHERE up.user_id = ?
        AND up.pokja_id = ?
        AND up.is_active = 1

        LIMIT 1
    ");

        $stmt->execute([
            $userId,
            $pokjaId
        ]);

        return $stmt->fetchColumn();
    }
}
