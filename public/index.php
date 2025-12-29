<?php
session_start();

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/core/auth.php';
require_once __DIR__ . '/../app/core/middleware.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$page = $_GET['page'] ?? null;
$auth = new AuthController();

/**
 * Default behavior
 * - jika belum login → login
 * - jika sudah login → dashboard sesuai role
 */
if ($page === null) {
    if (isLoggedIn()) {
        redirectToDashboard();
    } else {
        $page = 'login';
    }
}

switch ($page) {

    case 'login':
        guestOnly();
        $auth->login();
        break;

    case 'login-process':
        guestOnly();
        $auth->authenticate();
        break;

    case 'dashboard':
        authOnly();
        require __DIR__ . '/../app/views/dashboard/' . strtolower(currentRole()) . '.php';
        break;

    case 'tim-kerja-paud':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/paud.php';
        break;

    case 'tim-kerja-sd':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/sd.php';
        break;

    case 'tim-kerja-smp':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/smp.php';
        break;

    case 'tim-kerja-sma':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/sma.php';
        break;

    case 'tim-kerja-program-prioritas':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/program-prioritas.php';
        break;

    case 'kepegawaian':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/kepegawaian.php';
        break;

    case 'peraturan':
        authOnly();
        // moduleOnly('kepegawaian');
        require __DIR__ . '/../app/views/modules/peraturan.php';
        break;

    case 'arsip':
        authOnly();
        // moduleOnly('arsip');
        require __DIR__ . '/../app/views/modules/arsip.php';
        break;

    case 'logout':
        logout();
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
