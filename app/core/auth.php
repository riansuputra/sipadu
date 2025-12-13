<?php
require_once __DIR__ . '/../config/config.php';

session_start();

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function login($user)
{
    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'nama' => $user['nama_lengkap'],
        'role' => $user['role_code'],
        'group_id' => $user['work_group_id'],
        'group_type' => $user['group_type']
    ];
}

function logout()
{
    $_SESSION = [];
    session_destroy();

    header('Location: ' . BASE_URL . '/?page=login');
    exit;
}


function redirectByRole()
{
    switch ($_SESSION['user']['role']) {
        case 'ADMIN':
            header('Location: ' . BASE_URL . '/?page=dashboard-admin');
            break;
        case 'ATASAN':
            header('Location: ' . BASE_URL . '/?page=dashboard-atasan');
            break;
        default:
            header('Location: ' . BASE_URL . '/?page=dashboard-pegawai');
    }
    exit;
}
