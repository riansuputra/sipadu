<?php
// ================================
// DASHBOARD CONTROLLER
// ================================

require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../models/ModulModel.php';
require_once __DIR__ . '/../core/BaseController.php';


class DashboardController extends BaseController
{
    // ----------------------------
    // HALAMAN DASHBOARD
    // ----------------------------
    public function index()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        $mode = $_GET['mode'] ?? null;

        // ----------------------------
        // 3. STAFF → modul tampil di dashboard
        // ----------------------------
        if ($mode === 'staff' && in_array($role, ['Admin', 'Superadmin', 'Pimpinan'])) {
            $moduleModel = new ModulModel();

            // ambil semua modul aktif
            $modules = $moduleModel->getAllActive();
            require __DIR__ . '/../views/dashboard/staff.php';
            return;
        }

        if (in_array($role, ['Staff', 'Pimpinan'])) {
            $moduleModel = new ModulModel();

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

    public function paud()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        require __DIR__ . "/../views/paud/index.php";
    }

    public function sd()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        require __DIR__ . "/../views/sd/index.php";
    }

    public function smp()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        require __DIR__ . "/../views/smp/index.php";
    }

    public function sma()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        require __DIR__ . "/../views/sma/index.php";
    }

    public function widyaprada()
    {
        // Pastikan user sudah login
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        require __DIR__ . "/../views/widyaprada/index.php";
    }
}
