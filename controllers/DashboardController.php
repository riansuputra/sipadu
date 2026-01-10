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
        $role = currentRole();

        $mode = $_GET['mode'] ?? null;

        // ----------------------------
        // 3. STAFF → modul tampil di dashboard
        // ----------------------------
        if ($mode === 'staff' && in_array($role, ['Admin', 'Superadmin'])) {
            $moduleModel = new ModulModel($pdo);

            // ambil semua modul aktif
            $modules = $moduleModel->getAllActive();
            require __DIR__ . '/../views/dashboard/staff.php';
            return;
        }

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
            case 'Admin':
                require __DIR__ . '/../views/dashboard/admin.php';
                break;

            case 'Pimpinan':
            case 'Staff':
                require __DIR__ . '/../views/dashboard/staff.php';
                break;
        }

        // Load dashboard sesuai role
    }
}
