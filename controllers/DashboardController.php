<?php

require_once __DIR__ . '/../models/ModulModel.php';
require_once __DIR__ . '/../core/BaseController.php';


class DashboardController extends BaseController
{
    public function index()
    {
        $this->auth();

        $mode = $_GET['mode'] ?? null;

        if ($mode === 'staff' && in_array($this->role, ['Admin', 'Superadmin', 'Pimpinan'])) {
            $moduleModel = new ModulModel();

            $modules = $moduleModel->getAllActive();
            $this->view('dashboard/staff', [
                'moduleModel' => $moduleModel,
                'modules' => $modules,
                'user' => $this->user,
                'role' => $this->role,
            ]);
            return;
        }

        if (in_array($this->role, ['Staff', 'Pimpinan'])) {
            $moduleModel = new ModulModel();

            $modules = $moduleModel->getAllActive();
            $this->view('dashboard/staff', [
                'moduleModel' => $moduleModel,
                'modules' => $modules,
                'user' => $this->user,
                'role' => $this->role,
            ]);
            return;
        }

        switch ($this->role) {
            case 'Superadmin':
            case 'Admin':

                $this->view('dashboard/admin', [
                    'user' => $this->user,
                    'role' => $this->role,
                ]);
                break;

            case 'Pimpinan':
            case 'Staff':
                $this->view('dashboard/staff', [
                    'user' => $this->user,
                    'role' => $this->role,
                ]);
                break;
        }
    }

    public function paud()
    {
        $this->auth();

        $this->view('paud/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function sd()
    {
        $this->auth();

        $this->view('sd/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function smp()
    {
        $this->auth();

        $this->view('smp/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function sma()
    {
        $this->auth();

        $this->view('sma/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function widyaprada()
    {
        $this->auth();

        $this->view('widyaprada/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function link_aplikasi()
    {
        $this->auth();

        $this->view('link_aplikasi/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }
}
