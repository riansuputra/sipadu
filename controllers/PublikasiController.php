<?php
// ================================
// DASHBOARD CONTROLLER
// ================================

require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../models/ModulModel.php';

class PublikasiController
{
    // ----------------------------
    // HALAMAN DASHBOARD
    // ----------------------------
    public function index()
    {
        // Pastikan user sudah login
        authOnly();

        global $pdo;

        $user = currentUser();
        // Ambil role user
        $role = currentRole();

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

        $adminRole = ['Superadmin', 'Admin'];

        $view = in_array($role, $adminRole)
            ? 'index-admin'
            : 'index';

        // Load dashboard sesuai role
        require __DIR__ . '/../views/publikasi/' . $view . '.php';
    }

    public function create()
    {
        // Pastikan user sudah login
        authOnly();

        global $pdo;

        $user = currentUser();
        // Ambil role user
        $role = currentRole();

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
        require __DIR__ . '/../views/publikasi/tambah.php';
    }
}
