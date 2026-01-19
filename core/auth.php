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
    // Simpan hanya data penting
    $_SESSION['user'] = [
        'id'         => $user['id'],
        'username'   => $user['username'],
        'nama'       => $user['nama_lengkap'],
        'role'       => $user['kode_role'], // SUPERADMIN / ADMIN / PIMPINAN / STAFF
        'role_id'    => $user['role_id'],
        'pokja_id'   => $user['pokja_id'] ?? null,
        'pokja_nama' => $user['pokja_nama'] ?? null,
        'pokja_tipe' => $user['pokja_tipe'] ?? null,
    ];
}

// -------------------------------
// LOGOUT USER
// -------------------------------
function logout()
{
    // Hapus semua session
    $_SESSION = [];
    session_destroy();

    // Redirect ke login
    header('Location: ' . BASE_URL . '/?page=login');
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
    header('Location: ' . BASE_URL . '/?page=dashboard');
    exit;
}
