<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ModuleModel.php';


function authOnly()
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit;
    }
}

function roleOnly(array $roles)
{
    if (!isLoggedIn() || !in_array(currentRole(), $roles)) {
        die('Akses ditolak');
    }
}


function guestOnly()
{
    if (isLoggedIn()) {
        redirectByRole();
        exit;
    }
}

function moduleOnly($page)
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit;
    }

    global $pdo;

    $roleId = $_SESSION['role_id'];
    $moduleModel = new ModuleModel($pdo);

    if (!$moduleModel->userHasAccess($roleId, $page)) {
        http_response_code(403);
        echo "Akses ditolak";
        exit;
    }
}
