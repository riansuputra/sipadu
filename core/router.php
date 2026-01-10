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

        case 'sd':
            break;

        // ========================
        // DASHBOARD
        // ========================
        case 'dashboard':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        case 'backup-data':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->backupData();
            break;

        case 'manajemen-file':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->manajemenFile();
            break;

        case 'arsip':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/ArsipController.php';
            (new ArsipController())->index();
            break;

        case 'tambah-arsip':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/ArsipController.php';
            (new ArsipController())->create();
            break;

        case 'publikasi':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/PublikasiController.php';
            (new PublikasiController())->index();
            break;

        case 'tambah-publikasi':
            authOnly(); // wajib login
            require_once __DIR__ . '/../controllers/PublikasiController.php';
            (new PublikasiController())->create();
            break;

        // ========================
        // PEGAWAI
        // ========================
        case 'pegawai':
            authOnly();
            require_once __DIR__ . '/../controllers/PegawaiController.php';
            // (new PegawaiController())->index();
            break;

        case 'pegawai-create':
            require_once __DIR__ . '/../controllers/PegawaiController.php';
            // (new PegawaiController())->create();
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
