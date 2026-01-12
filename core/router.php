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

        // ================= DIP =================
        case 'dip':
            authOnly();
            require_once __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->index();
            break;

        case 'tambah-dip':
            authOnly();
            require_once __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->create();
            break;

        case 'simpan-dip':
            authOnly();
            require_once __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->store();
            break;

        case 'detail-dip':
            authOnly();
            require_once __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->detail();
            break;

        case 'hapus-dip':
            authOnly();
            require_once __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->delete();
            break;

        // =============================
        // PERATURAN
        // =============================
        case 'peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/PeraturanController.php';
            (new PeraturanController())->index();
            break;

        case 'tambah-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/PeraturanController.php';
            (new PeraturanController())->create();
            break;

        case 'simpan-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/PeraturanController.php';
            (new PeraturanController())->store();
            break;

        case 'detail-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/PeraturanController.php';
            (new PeraturanController())->detail();
            break;

        case 'hapus-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/PeraturanController.php';
            (new PeraturanController())->delete();
            break;


        // =============================
        // JENIS PERATURAN (MASTER)
        // =============================
        case 'jenis-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/JenisPeraturanController.php';
            (new JenisPeraturanController())->index();
            break;

        case 'tambah-jenis-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/JenisPeraturanController.php';
            (new JenisPeraturanController())->create();
            break;

        case 'simpan-jenis-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/JenisPeraturanController.php';
            (new JenisPeraturanController())->store();
            break;

        case 'hapus-jenis-peraturan':
            authOnly();
            require_once __DIR__ . '/../controllers/JenisPeraturanController.php';
            (new JenisPeraturanController())->delete();
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
