<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ModuleModel.php';

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
function roleOnly(array $roles)
{
    authOnly();

    if (!in_array(currentRole(), $roles)) {
        http_response_code(403);
        require __DIR__ . '/../views/pages/403.php';
        exit;
    }
}

/**
 * Proteksi module
 */
function moduleOnly(string $moduleLink)
{
    authOnly();

    // ADMIN & ATASAN selalu lolos
    if (in_array(currentRole(), ['ADMIN', 'ATASAN'])) {
        return true;
    }

    global $pdo;
    $moduleModel = new ModuleModel($pdo);

    $user = currentUser();

    $hasAccess = $moduleModel->userHasAccess(
        $user['role'],
        $user['group_id'],
        $moduleLink
    );

    if (!$hasAccess) {
        http_response_code(403);
        // jangan echo → biar JS handle
        exit;
    }

    return true;
}
