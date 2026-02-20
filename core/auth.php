<?php
// ================================
// AUTHENTICATION CORE
// ================================

require_once __DIR__ . '/../includes/config.php';

// -------------------------------
// CEK APAKAH USER SUDAH LOGIN
// -------------------------------
function isLoggedIn()
{
    // Mengecek apakah session user tersedia
    return isset($_SESSION['user']);
}

// -------------------------------
// SIMPAN DATA USER KE SESSION
// -------------------------------
function loginUser(array $user)
{
    session_regenerate_id(true); // WAJIB

    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'nama' => $user['nama_lengkap'],
        'role' => $user['kode_role'],
        'role_id' => $user['role_id'],
        'pokja_id' => $user['pokja_id'] ?? null,
        'pokja_nama' => $user['pokja_nama'] ?? null,
        'pokja_tipe' => $user['pokja_tipe'] ?? null,
    ];
}

// -------------------------------
// LOGOUT USER
// -------------------------------
function logout()
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

// ambil seluruh data user dari session
function currentUser()
{
    return $_SESSION['user'] ?? null;
}

// -------------------------------
// AMBIL ROLE SAAT INI
// -------------------------------
function currentRole()
{
    return $_SESSION['user']['role'] ?? null;
}

// -------------------------------
// AMBIL ROLE SAAT INI
// -------------------------------
function currentPokja()
{
    return $_SESSION['user']['pokja_id'] ?? null;
}

// -------------------------------
// REDIRECT SETELAH LOGIN
// -------------------------------
function redirectByRole()
{
    // Semua role masuk ke dashboard yang sama
    header('Location: ' . url('?page=dashboard'));
    exit;
}
