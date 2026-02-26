<?php
// ================================
// DASHBOARD CONTROLLER
// ================================

require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../models/ModulModel.php';
require_once __DIR__ . '/../core/BaseController.php';


class PengaturanController extends BaseController
{
    // ----------------------------
    // HALAMAN DASHBOARD
    // ----------------------------
    public function backupData()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        // Ambil role user
        $role = $this->role;

        // ----------------------------
        // 3. STAFF → modul tampil di dashboard
        // ----------------------------
        // if ($role === 'Staff') {
        //     $moduleModel = new ModulModel($pdo);

        //     // ambil semua modul aktif
        //     $modules = $moduleModel->getAllActive();
        //     require __DIR__ . '/../views/dashboard/staff.php';
        //     return;
        // }

        // $adminRole = ['Superadmin', 'Admin'];

        // $view = in_array($role, $adminRole)
        // ? 'index-admin'
        // : 'index';

        // Load dashboard sesuai role
        require __DIR__ . '/../views/pengaturan/backup-data.php';
    }

    public function manajemenFile()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        // Ambil role user
        $role = $this->role;

        // ----------------------------
        // 3. STAFF → modul tampil di dashboard
        // ----------------------------
        // if ($role === 'Staff') {
        //     $moduleModel = new ModulModel($pdo);

        //     // ambil semua modul aktif
        //     $modules = $moduleModel->getAllActive();
        //     require __DIR__ . '/../views/dashboard/staff.php';
        //     return;
        // }

        // $adminRole = ['Superadmin', 'Admin'];

        // $view = in_array($role, $adminRole)
        // ? 'index-admin'
        // : 'index';

        // Load dashboard sesuai role
        require __DIR__ . '/../views/pengaturan/manajemen-file.php';
    }

    public function profil()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        // Ambil role user
        $role = $this->role;

        // ----------------------------
        // 3. STAFF → modul tampil di dashboard
        // ----------------------------
        // if ($role === 'Staff') {
        //     $moduleModel = new ModulModel($pdo);

        //     // ambil semua modul aktif
        //     $modules = $moduleModel->getAllActive();
        //     require __DIR__ . '/../views/dashboard/staff.php';
        //     return;
        // }

        // $adminRole = ['Superadmin', 'Admin'];

        // $view = in_array($role, $adminRole)
        // ? 'index-admin'
        // : 'index';

        // Load dashboard sesuai role
        require __DIR__ . '/../views/pengaturan/profil.php';
    }
}
