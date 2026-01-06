<?php
// ================================
// DASHBOARD CONTROLLER
// ================================

require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../models/ModulModel.php';

class DashboardController
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
        if ($role === 'Staff') {
            $moduleModel = new ModulModel($pdo);

            // ambil semua modul aktif
            $modules = $moduleModel->getAllActive();
            require __DIR__ . '/../views/dashboard/staff.php';
            return;
        }

        // Tentukan view dashboard berdasarkan role
        switch ($role) {
            case 'Superadmin':
                $view = 'superadmin';
                break;

            case 'Admin':
                $view = 'admin';
                break;

            case 'Pimpinan':
                $view = 'pimpinan';
                break;

            default:
                $view = 'staff';
                break;
        }

        // Load dashboard sesuai role
        require __DIR__ . '/../views/dashboard/' . $view . '.php';
    }
}
