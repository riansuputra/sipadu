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

        // Autentikasi ================================
        case 'login':
            guestOnly(); // hanya untuk user belum login
            require __DIR__ . '/../controllers/AuthController.php';
            $controller = new AuthController();
            $controller->login();
            break;

        case 'login-process':
            guestOnly();
            require __DIR__ . '/../controllers/AuthController.php';
            $controller = new AuthController();
            $controller->authenticate();
            break;

        case 'logout':
            logout();
            break;

        // Dashboard =================================
        case 'dashboard':
            authOnly(); // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        // Dokumen =======================================
        case 'dokumen':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->index();
            break;

        case 'tambah-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->create();
            break;

        case 'dokumen-store':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->store();
            break;

        case 'detail-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->show();
            break;

        case 'edit-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->edit();
            break;

        case 'dokumen-update':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->update();
            break;

        case 'dokumen-delete':
            authOnly();
            require __DIR__ . '/../controllers/DokumenController.php';
            $controller = new DokumenController();
            $controller->delete();
            break;

        // Jenis Publikasi =======================================
        case 'jenis-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->index();
            break;

        case 'tambah-jenis-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->create();
            break;

        case 'jenis-dokumen-store':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->store();
            break;

        case 'detail-jenis-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->show();
            break;

        case 'edit-jenis-dokumen':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->edit();
            break;

        case 'jenis-dokumen-update':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->update();
            break;

        case 'jenis-dokumen-delete':
            authOnly();
            require __DIR__ . '/../controllers/JenisDokumenController.php';
            $controller = new JenisDokumenController();
            $controller->delete();
            break;

        // Arsip ==========================================
        case 'arsip':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->index();
            break;

        case 'tambah-arsip':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->create();
            break;

        case 'arsip-store':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->store();
            break;

        case 'detail-arsip':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->show();
            break;

        case 'edit-arsip':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->edit();
            break;

        case 'arsip-update':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->update();
            break;

        case 'arsip-delete':
            authOnly();
            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->delete();
            break;

        // Publikasi =======================================
        case 'publikasi':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->index();
            break;

        case 'tambah-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->create();
            break;

        case 'publikasi-store':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->store();
            break;

        case 'detail-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->show();
            break;

        case 'edit-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->edit();
            break;

        case 'publikasi-update':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->update();
            break;

        case 'publikasi-delete':
            authOnly();
            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->delete();
            break;

        // Jenis Publikasi =======================================
        case 'jenis-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->index();
            break;

        case 'tambah-jenis-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->create();
            break;

        case 'jenis-publikasi-store':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->store();
            break;

        case 'detail-jenis-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->show();
            break;

        case 'edit-jenis-publikasi':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->edit();
            break;

        case 'jenis-publikasi-update':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->update();
            break;

        case 'jenis-publikasi-delete':
            authOnly();
            require __DIR__ . '/../controllers/JenisPublikasiController.php';
            $controller = new JenisPublikasiController();
            $controller->delete();
            break;

        // DIP Admin =============================================
        case 'dip':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->index();
            break;

        case 'tambah-dip':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->create();
            break;

        case 'dip-store':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->store();
            break;

        case 'detail-dip':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->show();
            break;

        case 'edit-dip':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->edit();
            break;

        case 'dip-update':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->update();
            break;

        case 'dip-delete':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->delete();
            break;

        // DIP ======================================
        case 'dip-publik':
            authOnly();
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->publicIndex();
            break;

        // Peraturan Admin ======================================
        case 'peraturan':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->index();
            break;

        case 'tambah-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->create();
            break;

        case 'peraturan-store':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->store();
            break;

        case 'detail-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->show();
            break;

        case 'edit-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->edit();
            break;

        case 'peraturan-update':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->update();
            break;

        case 'peraturan-delete':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->delete();
            break;

        // Peraturan Publik ======================================
        case 'peraturan-publik':
            authOnly();
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->publicIndex();
            break;

        case 'peraturan-file':
            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->downloadFile();
            break;

        case 'peraturan-detail':
            authOnly();
            require_once __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->detail($_GET['id']);
            break;

        // Jenis Peraturan =================================
        case 'jenis-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->index();
            break;

        case 'tambah-jenis-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->create();
            break;

        case 'jenis-peraturan-store':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->store();
            break;

        case 'detail-jenis-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->show();
            break;

        case 'edit-jenis-peraturan':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->edit();
            break;

        case 'jenis-peraturan-update':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->update();
            break;

        case 'jenis-peraturan-delete':
            authOnly();
            require __DIR__ . '/../controllers/JenisPeraturanController.php';
            $controller = new JenisPeraturanController();
            $controller->delete();
            break;

        // Pegawai Admin =======================================
        case 'pegawai':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->index();
            break;

        case 'tambah-pegawai':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->create();
            break;

        case 'pegawai-store':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->store();
            break;

        case 'detail-pegawai':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->show();
            break;

        case 'edit-pegawai':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->edit();
            break;

        case 'pegawai-update':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->update();
            break;

        case 'pegawai-delete':
            authOnly();
            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->delete();
            break;

        // Unclasified
        case 'backup-data':
            authOnly(); // wajib login
            require __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->backupData();
            break;

        case 'manajemen-file':
            authOnly(); // wajib login
            require __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->manajemenFile();
            break;

        // Default ========================================
        default:
            http_response_code(404);
            echo 'Halaman tidak ditemukan';
            break;
    }
}
