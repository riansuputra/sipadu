<?php
require_once __DIR__ . '/../config/config.php';

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function login($user)
{
    $_SESSION['user'] = [
        'id'         => $user['id'],
        'username'   => $user['username'],
        'nama'       => $user['nama_lengkap'],
        'role'       => $user['kode_role'],
        'grup_id'    => $user['pokja_id'],
        'tipe_grup'  => $user['tipe_grup'],
        'nama_grup'  => $user['nama_grup'] ?? null
    ];
}

function logout()
{
    $_SESSION = [];
    session_destroy();

    header('Location: ' . BASE_URL . '/?page=login');
    exit;
}

/**
 * Helper
 */
function currentRole()
{
    return $_SESSION['user']['role'] ?? null;
}

function currentUser()
{
    return $_SESSION['user'] ?? null;
}

/**
 * Redirect universal ke dashboard
 */
function redirectToDashboard()
{
    header('Location: ' . BASE_URL . '/?page=dashboard');
    exit;
}
