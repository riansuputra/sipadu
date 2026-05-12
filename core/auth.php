<?php
// ================================
// AUTHENTICATION CORE (SESSION ONLY)
// ================================

require_once __DIR__ . '/../includes/config.php';

class Auth
{
    private static $user = null;

    // ================================
    // INIT SESSION
    // ================================
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        self::$user = $_SESSION['user'] ?? null;
    }

    // ================================
    // CHECK LOGIN STATUS
    // ================================
    public static function check()
    {
        return !empty(self::$user['id']);
    }

    // ================================
    // LOGIN PROCESS
    // ================================
    public static function login(array $user)
    {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id'         => $user['id'],
            'username'   => $user['username'],
            'nama'       => $user['nama_lengkap'],
            'pegawai_id' => $user['pegawai_id'],
            'role'       => $user['kode_role'],
            'role_id'    => $user['role_id'],
            'pokja_id'   => $user['pokja_id'] ?? null,
            'pokja_nama' => $user['pokja_nama'] ?? null,
            'pokja_tipe' => $user['pokja_tipe'] ?? null,
            'foto_profile' => $user['foto_profile'] ?? null,
        ];

        self::$user = $_SESSION['user'];
    }

    // ================================
    // LOGOUT PROCESS
    // ================================
    public static function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header('Location: ' . url('?page=login'));
        exit;
    }

    // ================================
    // GET USER DATA
    // ================================
    public static function user()
    {
        return self::$user;
    }

    public static function role()
    {
        return self::$user['role'] ?? null;
    }

    public static function pokja()
    {
        return self::$user['pokja_id'] ?? null;
    }
}
