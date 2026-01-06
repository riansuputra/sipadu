<?php
// ================================
// ROUTER APLIKASI SIPADU
// ================================

// Fungsi utama router
function routeRequest()
{
    // ----------------------------
    // Ambil parameter page
    // ----------------------------
    $page = $_GET['page'] ?? 'login';

    // ----------------------------
    // Routing halaman
    // ----------------------------
    switch ($page) {

        // ========================
        // AUTHENTICATION
        // ========================
        case 'login':
            guestOnly(); // hanya untuk user belum login
            require_once __DIR__ . '/../controllers/AuthController.php';
            (new AuthController())->login();
            break;

        case 'login-process':
            guestOnly();
            require_once __DIR__ . '/../controllers/AuthController.php';
            (new AuthController())->authenticate();
            break;

        case 'logout':
            logout();
            break;

        // ========================
        // DASHBOARD
        // ========================
        case 'dashboard':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        // ========================
        // PEGAWAI
        // ========================
        case 'pegawai':
            authOnly();
            require_once __DIR__ . '/../controllers/PegawaiController.php';
            // (new PegawaiController())->index();
            break;

        // ========================
        // DEFAULT
        // ========================
        default:
            http_response_code(404);
            echo 'Halaman tidak ditemukan';
            break;
    }
}
