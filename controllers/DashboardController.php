<?php

require_once __DIR__ . '/../models/ModulModel.php';
require_once __DIR__ . '/../core/BaseController.php';

class DashboardController extends BaseController
{
    protected $moduleModel;

    public function __construct()
    {
        parent::__construct();
        $this->moduleModel = new ModulModel();
    }

    public function index()
    {
        $this->auth();

        $mode = $_GET['mode'] ?? null;

        if ($mode === 'staff' && in_array($this->role, ['Admin', 'Superadmin', 'Pimpinan'])) {
            $this->view('dashboard/staff', [
                'user' => $this->user,
                'role' => $this->role,
            ]);
            return;
        }

        if (in_array($this->role, ['Staff', 'Pimpinan'])) {
            $this->view('dashboard/staff', [
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

    // ================================
    // HALAMAN TIM / HALAMAN MODUL DINAMIS
    // ================================
    public function teamPage(string $slug, string $title)
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug($slug);

        $this->view('dashboard/team-page', [
            'pageSlug'    => $slug,
            'pageTitle'   => $title,
            'modules'     => $modules,
            'moduleModel' => $this->moduleModel,
            'user'        => $this->user,
            'role'        => $this->role,
        ]);
    }

    public function paud()
    {
        $this->auth();

        if (!$this->canAccessPage('paud')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('paud');

        $this->view('paud/index', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function sd()
    {
        $this->auth();

        if (!$this->canAccessPage('sd')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('sd');

        $this->view('sd/index', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function smp()
    {
        $this->auth();

        if (!$this->canAccessPage('smp')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('smp');

        $this->view('smp/index', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function sma()
    {
        $this->auth();

        if (!$this->canAccessPage('sma')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('sma');

        $this->view('sma/index', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function widyaprada()
    {
        $this->auth();

        if (!$this->canAccessPage('widyaprada')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('widyaprada');

        $this->view('widyaprada/index', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function link_aplikasi()
    {
        $this->auth();

        if (!$this->canAccessPage('link-aplikasi')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('link-aplikasi');

        $this->view('link_aplikasi/index', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    private function canAccessPage(string $page): bool
    {
        $moduleModel = new ModulModel();

        return $moduleModel->canAccessHardcodedPage(
            $this->role,
            $this->user['pokja_nama'] ?? null,
            $page
        );
    }

    public function modulePage()
    {
        $this->auth();

        $slug = $_GET['page'] ?? null;

        if (!$slug) {
            return $this->abort404();
        }

        $moduleModel = new ModulModel();

        // cek akses modul berdasarkan link
        $hasAccess = $moduleModel->canAccessModuleByLink(
            $this->role,
            $this->pokja,
            $slug
        );

        if (!$hasAccess) {
            return $this->abort403();
        }

        // ambil data modul
        $module = $moduleModel->getByLink($slug);

        if (!$module) {
            return $this->abort404();
        }

        // kalau link eksternal, redirect
        if (filter_var($module['link'], FILTER_VALIDATE_URL)) {
            header("Location: " . $module['link']);
            exit;
        }

        $this->view('dashboard/module-page', [
            'module' => $module,
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }
}
