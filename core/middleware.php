<?php
// ================================
// MIDDLEWARE CORE
// ================================

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/config.php';

// -------------------------------
// HALAMAN KHUSUS LOGIN
// -------------------------------
function guestOnly()
{
    // Jika sudah login, langsung lempar ke dashboard
    if (isLoggedIn()) {
        redirectByRole();
        exit;
    }
}

// -------------------------------
// HALAMAN KHUSUS USER LOGIN
// -------------------------------
function authOnly()
{
    // Jika belum login, lempar ke login
    if (!isLoggedIn()) {
        header('Location: ' . url('?page=login'));
        exit;
    }
}

// -------------------------------
// BATASI BERDASARKAN ROLE
// -------------------------------
function roleOnly(array $roles)
{
    authOnly();

    // Jika role tidak sesuai
    if (!in_array(currentRole(), $roles)) {
        http_response_code(403);
        echo 'Akses ditolak';
        exit;
    }
}
