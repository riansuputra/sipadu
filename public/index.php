<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/core/auth.php';
require_once __DIR__ . '/../app/core/middleware.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$page = $_GET['page'] ?? 'login';
$auth = new AuthController();

switch ($page) {

    case 'login':
        guestOnly(); // ⬅️ PENTING
        $auth->login();
        break;

    case 'login-process':
        guestOnly();
        $auth->authenticate();
        break;

    case 'dashboard-admin':
        roleOnly(['ADMIN']);
        require __DIR__ . '/../app/views/dashboard/admin.php';
        break;

    case 'dashboard-atasan':
        roleOnly(['ATASAN']);
        require __DIR__ . '/../app/views/dashboard/atasan.php';
        break;

    case 'dashboard-pegawai':
        roleOnly(['PEGAWAI']);
        require __DIR__ . '/../app/views/dashboard/pegawai.php';
        break;

    case 'arsip':
        moduleOnly('arsip');
        require __DIR__ . '/../app/views/modules/arsip.php';
        break;

    case 'kepegawaian':
        moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/kepegawaian.php';
        break;

    case 'logout':
        logout();
        break;

    default:
        echo "404";
}
