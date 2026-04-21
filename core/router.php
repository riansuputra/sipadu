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

    if (isMaintenance($page)) {
        showMaintenance();
    }

    // ----------------------------
    // Routing halaman
    // ----------------------------
    switch ($page) {

        // Autentikasi ================================
        case 'login':
            require __DIR__ . '/../controllers/AuthController.php';
            $controller = new AuthController();
            $controller->login();
            break;

        case 'login-process':
            require __DIR__ . '/../controllers/AuthController.php';
            $controller = new AuthController();
            $controller->authenticate();
            break;

        case 'logout':
            Auth::logout();
            break;

        // Modul ==========================================
        case 'modul':

            require __DIR__ . '/../controllers/ModulController.php';
            $controller = new ModulController();
            $controller->index();
            break;

        case 'tambah-modul':

            require __DIR__ . '/../controllers/ModulController.php';
            $controller = new ModulController();
            $controller->create();
            break;

        case 'modul-store':

            require __DIR__ . '/../controllers/ModulController.php';
            $controller = new ModulController();
            $controller->store();
            break;

        case 'edit-modul':

            require __DIR__ . '/../controllers/ModulController.php';
            $controller = new ModulController();
            $controller->edit();
            break;

        case 'modul-update':

            require __DIR__ . '/../controllers/ModulController.php';
            $controller = new ModulController();
            $controller->update();
            break;

        case 'modul-delete':

            require __DIR__ . '/../controllers/ModulController.php';
            $controller = new ModulController();
            $controller->delete();
            break;

        // Autentikasi ================================
        case 'notifikasi-unread-count':
            require __DIR__ . '/../controllers/NotifikasiController.php';
            $controller = new NotifikasiController();
            $controller->unreadCount();
            break;

        case 'notifikasi-list':
            require __DIR__ . '/../controllers/NotifikasiController.php';
            $controller = new NotifikasiController();
            $controller->getList();
            break;

        case 'notifikasi-read':
            require __DIR__ . '/../controllers/NotifikasiController.php';
            $controller = new NotifikasiController();
            $controller->markAsRead();
            break;

        case 'notifikasi-read-all':
            require __DIR__ . '/../controllers/NotifikasiController.php';
            $controller = new NotifikasiController();
            $controller->markAllRead();
            break;

        // Autentikasi ================================
        case 'user':
            // biasanya hanya Superadmin
            require __DIR__ . '/../controllers/UserController.php';
            $controller = new UserController();
            $controller->index();
            break;

        case 'tambah-user':

            require __DIR__ . '/../controllers/UserController.php';
            $controller = new UserController();
            $controller->create();
            break;

        case 'user-store':

            require __DIR__ . '/../controllers/UserController.php';
            $controller = new UserController();
            $controller->store();
            break;

        case 'user-password':

            require __DIR__ . '/../controllers/UserController.php';
            $controller = new UserController();
            $controller->editPassword();
            break;

        case 'edit-user':

            require __DIR__ . '/../controllers/UserController.php';
            (new UserController())->edit();
            break;

        case 'user-update':

            require __DIR__ . '/../controllers/UserController.php';
            (new UserController())->update();
            break;

        case 'user-delete':

            require __DIR__ . '/../controllers/UserController.php';
            (new UserController())->delete();
            break;

        case 'user-active':

            require __DIR__ . '/../controllers/UserController.php';
            (new UserController())->active();
            break;

        // Tim ================================
        case 'tambah-tim':

            require __DIR__ . '/../controllers/TimController.php';
            $controller = new TimController();
            $controller->create();
            break;

        case 'tim-store':

            require __DIR__ . '/../controllers/TimController.php';
            $controller = new TimController();
            $controller->store();
            break;

        case 'tim-update':

            require __DIR__ . '/../controllers/TimController.php';
            (new TimController())->update();
            break;

        case 'tim-delete':

            require __DIR__ . '/../controllers/TimController.php';
            (new TimController())->delete();
            break;

        // Dashboard =================================
        case 'dashboard':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        case 'pegawai-publik':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        case 'arsip-publik':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        case 'zi-wbbm-publik':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->index();
            break;

        // Tim Kerja =================================
        case 'paud':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->paud();
            break;

        case 'sd':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->sd();
            break;

        case 'smp':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->smp();
            break;

        case 'sma':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->sma();
            break;

        case 'widyaprada':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->widyaprada();
            break;

        case 'link-aplikasi':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->link_aplikasi();
            break;

        case 'kegiatan':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->kegiatan();
            break;

        case 'kegiatan-paud':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->kegiatanPaud();
            break;

        case 'kegiatan-sd':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->kegiatanSd();
            break;

        case 'kegiatan-smp':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->kegiatanSmp();
            break;

        case 'kegiatan-sma':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->kegiatanSma();
            break;

        case 'kegiatan-widyaprada':
            // wajib login
            require __DIR__ . '/../controllers/DashboardController.php';
            (new DashboardController())->kegiatanWp();
            break;

        // Arsip ==========================================
        case 'arsip':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->index();
            break;

        case 'tambah-arsip':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->create();
            break;

        case 'arsip-store':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->store();
            break;

        case 'detail-arsip':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->show();
            break;

        case 'edit-arsip':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->edit();
            break;

        case 'arsip-update':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->update();
            break;

        case 'arsip-delete':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->delete();
            break;

        case 'arsip-kelola-peserta':

            require __DIR__ . '/../controllers/ArsipController.php';
            $controller = new ArsipController();
            $controller->createPeserta();
            break;

        // Arsip Peserta ==========================================
        case 'arsip-peserta-store':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->store();
            break;

        case 'arsip-peserta-update':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->update();
            break;

        case 'arsip-peserta-delete':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->delete();
            break;

        case 'arsip-saya':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->indexPeserta();
            break;

        case 'detail-arsip-saya':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->showPeserta();
            break;

        case 'upload-bukti-arsip-saya':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->uploadBukti();
            break;

        case 'hapus-bukti-arsip-saya':

            require __DIR__ . '/../controllers/ArsipPesertaController.php';
            $controller = new ArsipPesertaController();
            $controller->deleteBukti();
            break;

        // Jenis Arsip =======================================
        case 'jenis-arsip':

            require __DIR__ . '/../controllers/ArsipJenisController.php';
            $controller = new ArsipJenisController();
            $controller->index();
            break;

        case 'tambah-jenis-arsip':

            require __DIR__ . '/../controllers/ArsipJenisController.php';
            $controller = new ArsipJenisController();
            $controller->create();
            break;

        case 'jenis-arsip-store':

            require __DIR__ . '/../controllers/ArsipJenisController.php';
            $controller = new ArsipJenisController();
            $controller->store();
            break;

        case 'edit-jenis-arsip':

            require __DIR__ . '/../controllers/ArsipJenisController.php';
            $controller = new ArsipJenisController();
            $controller->edit();
            break;

        case 'jenis-arsip-update':

            require __DIR__ . '/../controllers/ArsipJenisController.php';
            $controller = new ArsipJenisController();
            $controller->update();
            break;

        case 'jenis-arsip-delete':

            require __DIR__ . '/../controllers/ArsipJenisController.php';
            $controller = new ArsipJenisController();
            $controller->delete();
            break;


        // Publikasi =======================================
        case 'publikasi':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->index();
            break;

        case 'publikasi-paud':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->indexPaud();
            break;

        case 'publikasi-sd':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->indexSd();
            break;

        case 'publikasi-smp':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->indexSmp();
            break;

        case 'publikasi-sma':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->indexSma();
            break;

        case 'publikasi-widyaprada':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->indexWidyaprada();
            break;

        case 'tambah-publikasi':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->create();
            break;

        case 'publikasi-store':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->store();
            break;

        case 'edit-publikasi':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->edit();
            break;

        case 'publikasi-update':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->update();
            break;

        case 'publikasi-delete':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->delete();
            break;

        case 'publikasi-publik':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->publicIndex();
            break;

        case 'timpublikasi':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->publikasiIndex();
            break;

        case 'approve-publikasi':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->approve();
            break;

        case 'edit-status-publikasi':

            require __DIR__ . '/../controllers/PublikasiController.php';
            $controller = new PublikasiController();
            $controller->editStatus();
            break;

        // Jenis Publikasi =======================================
        case 'jenis-publikasi':

            require __DIR__ . '/../controllers/PublikasiJenisController.php';
            $controller = new PublikasiJenisController();
            $controller->index();
            break;

        case 'tambah-jenis-publikasi':

            require __DIR__ . '/../controllers/PublikasiJenisController.php';
            $controller = new PublikasiJenisController();
            $controller->create();
            break;

        case 'jenis-publikasi-store':

            require __DIR__ . '/../controllers/PublikasiJenisController.php';
            $controller = new PublikasiJenisController();
            $controller->store();
            break;

        case 'edit-jenis-publikasi':

            require __DIR__ . '/../controllers/PublikasiJenisController.php';
            $controller = new PublikasiJenisController();
            $controller->edit();
            break;

        case 'jenis-publikasi-update':

            require __DIR__ . '/../controllers/PublikasiJenisController.php';
            $controller = new PublikasiJenisController();
            $controller->update();
            break;

        case 'jenis-publikasi-delete':

            require __DIR__ . '/../controllers/PublikasiJenisController.php';
            $controller = new PublikasiJenisController();
            $controller->delete();
            break;

        // DIP Admin =============================================
        case 'dip':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->index();
            break;

        case 'tambah-dip':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->create();
            break;

        case 'dip-store':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->store();
            break;

        case 'edit-dip':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->edit();
            break;

        case 'dip-update':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->update();
            break;

        case 'dip-delete':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->delete();
            break;

        case 'dip-file':
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->downloadFile();
            break;

        case 'dip-print-filter':
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->printFilter();
            break;

        case 'dip-print':
            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->print();
            break;

        // DIP ======================================
        case 'dip-publik':

            require __DIR__ . '/../controllers/DipController.php';
            $controller = new DipController();
            $controller->publicIndex();
            break;

        // Peraturan Admin ======================================
        case 'peraturan':

            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->index();
            break;

        case 'tambah-peraturan':

            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->create();
            break;

        case 'peraturan-store':

            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->store();
            break;

        // case 'detail-peraturan':

        //     require __DIR__ . '/../controllers/PeraturanController.php';
        //     $controller = new PeraturanController();
        //     $controller->show();
        //     break;

        case 'edit-peraturan':

            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->edit();
            break;

        case 'peraturan-update':

            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->update();
            break;

        case 'peraturan-delete':

            require __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->delete();
            break;

        // Peraturan Publik ======================================
        case 'peraturan-publik':

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

            require_once __DIR__ . '/../controllers/PeraturanController.php';
            $controller = new PeraturanController();
            $controller->detail($_GET['id']);
            break;

        // Jenis Peraturan =================================
        case 'jenis-peraturan':

            require __DIR__ . '/../controllers/PeraturanJenisController.php';
            $controller = new PeraturanJenisController();
            $controller->index();
            break;

        case 'tambah-jenis-peraturan':

            require __DIR__ . '/../controllers/PeraturanJenisController.php';
            $controller = new PeraturanJenisController();
            $controller->create();
            break;

        case 'jenis-peraturan-store':

            require __DIR__ . '/../controllers/PeraturanJenisController.php';
            $controller = new PeraturanJenisController();
            $controller->store();
            break;

        case 'edit-jenis-peraturan':

            require __DIR__ . '/../controllers/PeraturanJenisController.php';
            $controller = new PeraturanJenisController();
            $controller->edit();
            break;

        case 'jenis-peraturan-update':

            require __DIR__ . '/../controllers/PeraturanJenisController.php';
            $controller = new PeraturanJenisController();
            $controller->update();
            break;

        case 'jenis-peraturan-delete':

            require __DIR__ . '/../controllers/PeraturanJenisController.php';
            $controller = new PeraturanJenisController();
            $controller->delete();
            break;

        // Pegawai Admin =======================================
        case 'pegawai':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->index();
            break;

        case 'tambah-pegawai':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->create();
            break;

        case 'pegawai-store':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->store();
            break;

        case 'detail-pegawai':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->show();
            break;

        case 'edit-pegawai':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->edit();
            break;

        case 'pegawai-update':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->update();
            break;

        case 'pegawai-delete':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->delete();
            break;

        case 'print-pegawai':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->print();
            break;

        case 'download-pegawai':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->download();
            break;

        case 'kepegawaian':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->indexPublic();
            break;

        case 'detail-kepegawaian':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->detailPublic();
            break;

        case 'pegawai-pensiun':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->pensiun();
            break;

        case 'kepegawaian-pensiun':

            require __DIR__ . '/../controllers/PegawaiController.php';
            $controller = new PegawaiController();
            $controller->pensiunPublic();
            break;

        // Jabatan Pegawai =======================================
        case 'jabatan-pegawai':

            require __DIR__ . '/../controllers/PegawaiJabatanController.php';
            $controller = new PegawaiJabatanController();
            $controller->index();
            break;

        case 'tambah-jabatan-pegawai':

            require __DIR__ . '/../controllers/PegawaiJabatanController.php';
            $controller = new PegawaiJabatanController();
            $controller->create();
            break;

        case 'jabatan-pegawai-store':

            require __DIR__ . '/../controllers/PegawaiJabatanController.php';
            $controller = new PegawaiJabatanController();
            $controller->store();
            break;

        case 'edit-jabatan-pegawai':

            require __DIR__ . '/../controllers/PegawaiJabatanController.php';
            $controller = new PegawaiJabatanController();
            $controller->edit();
            break;

        case 'jabatan-pegawai-update':

            require __DIR__ . '/../controllers/PegawaiJabatanController.php';
            $controller = new PegawaiJabatanController();
            $controller->update();
            break;

        case 'jabatan-pegawai-delete':

            require __DIR__ . '/../controllers/PegawaiJabatanController.php';
            $controller = new PegawaiJabatanController();
            $controller->delete();
            break;

        // Unclasified
        case 'backup-data':
            // wajib login
            require __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->backupData();
            break;

        case 'manajemen-file':
            // wajib login
            require __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->manajemenFile();
            break;

        case 'profil':
            // wajib login
            require __DIR__ . '/../controllers/PengaturanController.php';
            (new PengaturanController())->profil();
            break;

        case 'switch-pokja':
            require __DIR__ . '/../controllers/AuthController.php';
            $controller = new AuthController();
            $controller->switchPokja();
            break;

        case 'pilih-pokja':
            require __DIR__ . '/../controllers/AuthController.php';
            $controller = new AuthController();
            $controller->switchPokjaPage();
            break;

        // Default ========================================
        default:
            abort404();
            break;
    }
}
