<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/config.php';


function authOnly()
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit;
    }
}

function roleOnly(array $roles)
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit;
    }

    if (!in_array($_SESSION['user']['role'], $roles)) {
        http_response_code(403);
        echo "403 | Akses ditolak";
        exit;
    }
}

function guestOnly()
{
    if (isLoggedIn()) {
        redirectByRole();
    }
}
