<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ModulModel.php';

/**
 * Harus login
 */
function authOnly()
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit;
    }
}

/**
 * Hanya untuk guest (login page)
 */
function guestOnly()
{
    if (isLoggedIn()) {
        redirectToDashboard();
    }
}

/**
 * Batasi berdasarkan role (optional, jarang dipakai)
 */
function roleOnly(array $role)
{
    authOnly();

    if (!in_array(currentRole(), $role)) {
        http_response_code(403);
        require __DIR__ . '/../views/pages/403.php';
        exit;
    }
}

/**
 * Proteksi module
 */
function modulOnly(string $modulLink)
{
    authOnly();

    // ADMIN & ATASAN selalu lolos
    if (in_array(currentRole(), ['Superadmin', 'Pimpinan'])) {
        return true;
    }

    global $pdo;
    $modulModel = new ModulModel($pdo);

    $user = currentUser();

    $hasAccess = $modulModel->userHasAccess(
        $user['role'],
        $user['group_id'],
        $modulLink
    );

    if (!$hasAccess) {
        http_response_code(403);
        // jangan echo → biar JS handle
        exit;
    }

    return true;
}
