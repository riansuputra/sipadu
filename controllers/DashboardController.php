<?php

require_once __DIR__ . '/../models/ModulModel.php';
require_once __DIR__ . '/../models/DashboardModel.php';
require_once __DIR__ . '/../core/BaseController.php';

class DashboardController extends BaseController
{
    protected $moduleModel;
    protected $dashboardModel;
    protected $publikasiModel;

    public function __construct()
    {
        parent::__construct();
        $this->moduleModel = new ModulModel();
        $this->dashboardModel = new DashboardModel();
        $this->publikasiModel = new PublikasiModel();
    }

    public function index()
    {
        $this->auth();

        // dd([
        //     'user' => $this->user,
        //     'role' => $this->role
        // ]);

        $mode = $_GET['mode'] ?? null;

        $pokjaId = $this->user['pokja_id'];


        // Mode staff preview
        if ($mode === 'staff' && in_array($this->role, ['Admin', 'Superadmin', 'Pimpinan'])) {
            return $this->view('dashboard/staff', [
                'user' => $this->user,
                'role' => $this->role,
            ]);
        }

        // Staff & pimpinan default
        if (in_array($this->role, ['Staff'])) {
            return $this->view('dashboard/staff', [
                'user' => $this->user,
                'role' => $this->role,
            ]);
        }

        // 🔥 SUPERADMIN
        if ($this->role === 'Superadmin') {
            $dashboardData = [
                'card' => $this->dashboardModel->getDashboardAdmin(),
                'arsip_chart' => $this->dashboardModel->getArsipChartBulanan(), // 🔥 baru
                'publikasi_chart' => $this->dashboardModel->getPublikasiChartBulanan(), // 🔥 baru
                'pegawai_chart' => $this->dashboardModel->getPegawaiChart(), // 🔥 baru
                'publikasi_pokja_chart' => $this->dashboardModel->getPublikasiPerPokjaChartTahunIni(),
                'logs' => $this->dashboardModel->getLogDashboard(),
                'arsiparis' => $this->dashboardModel->getDashboardArsiparis(),
                'jenis_informasi_chart' => $this->dashboardModel->getJenisInformasiChart(),
                'dip' => $this->dashboardModel->getDashboardDip(),
                // nanti:
                // 'publikasi_chart' => ...
                // 'pegawai_chart' => ...
            ];

            return $this->view('dashboard/superadmin', array_merge([
                'user' => $this->user,
                'role' => $this->role,
            ], $dashboardData));
        }

        // 🔥 SUPERADMIN
        if ($this->role === 'Pimpinan') {
            $dashboardData = [
                'card' => $this->dashboardModel->getDashboardAdmin(),
                'arsip_chart' => $this->dashboardModel->getArsipChartBulanan(), // 🔥 baru
                'publikasi_chart' => $this->dashboardModel->getPublikasiChartBulanan(), // 🔥 baru
                'pegawai_chart' => $this->dashboardModel->getPegawaiChart(), // 🔥 baru
                'publikasi_pokja_chart' => $this->dashboardModel->getPublikasiPerPokjaChartTahunIni(),
                'logs' => $this->dashboardModel->getLogDashboard(),
                'arsiparis' => $this->dashboardModel->getDashboardArsiparis(),
                'jenis_informasi_chart' => $this->dashboardModel->getJenisInformasiChart(),
                'dip' => $this->dashboardModel->getDashboardDip(),
                'publikasi_terbaru' => $this->publikasiModel->getPublikasiTerbaru(),
                // nanti:
                // 'publikasi_chart' => ...
                // 'pegawai_chart' => ...
            ];

            return $this->view('dashboard/pimpinan', array_merge([
                'user' => $this->user,
                'role' => $this->role,
            ], $dashboardData));
        }

        // 🔥 ADMIN (DIPECAH BERDASARKAN POKJA)
        if ($this->role === 'Admin') {

            $dashboardData = [
                'card' => $this->dashboardModel->getDashboardAdmin(),
                'arsip_chart' => $this->dashboardModel->getArsipChartBulanan(), // 🔥 baru
                'publikasi_chart' => $this->dashboardModel->getPublikasiChartBulanan(), // 🔥 baru
                'pegawai_chart' => $this->dashboardModel->getPegawaiChart(), // 🔥 baru
                'publikasi_pokja_chart' => $this->dashboardModel->getPublikasiPerPokjaChartTahunIni(),
                'logs' => $this->dashboardModel->getLogDashboard(),
                'arsiparis' => $this->dashboardModel->getDashboardArsiparis(),
                'jenis_informasi_chart' => $this->dashboardModel->getJenisInformasiChart(),
                'dip' => $this->dashboardModel->getDashboardDip(),
                'kepegawaian' => $this->dashboardModel->getDashboardKepegawaian(),
                'publikasi' => $this->dashboardModel->getDashboardTimPublikasi(),
                'timker' => $this->getDashboardTim(),
                // nanti:
                // 'publikasi_chart' => ...
                // 'pegawai_chart' => ...
            ];


            $slug = $this->user['pokja_nama'] ?? null;

            $baseData = array_merge([
                'user' => $this->user,
                'role' => $this->role,
            ], $dashboardData);

            switch ($slug) {
                case 'DIP':
                    return $this->view('dashboard/dip', $baseData);

                case 'Arsiparis':
                    return $this->view('dashboard/arsiparis', $baseData);

                case 'Kepegawaian':
                    return $this->view('dashboard/kepegawaian', $baseData);

                case 'Publikasi':
                    return $this->view('dashboard/publikasi', $baseData);

                default:
                    return $this->view('dashboard/umum', $baseData);
            }
        }


        $this->abort403();
    }

    public function getDashboardTim()
    {
        $this->auth();
        $pokjaId = $this->user['pokja_id'];

        return [
            'total_file' => $this->publikasiModel->getTotalFile($pokjaId),
            'size_publikasi' => formatSize($this->publikasiModel->getTotalUkuran($pokjaId)),
            'terpublikasi' => $this->publikasiModel->getTotalPublished($pokjaId),
            'total_publikasi' => $this->publikasiModel->countAll($pokjaId),
            'publikasi_chart' => $this->dashboardModel->getPublikasiChartBulanan($pokjaId),
            'publikasi_jenis' => $this->dashboardModel->getPublikasiJenisChart($pokjaId),
        ];
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

    public function link()
    {
        $this->auth();

        if (!$this->canAccessPage('link-aplikasi')) {
            $this->abort403();
        }

        $modules = $this->moduleModel->getByParentSlug('link-aplikasi');

        $this->view('link_aplikasi/admin', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function kegiatan()
    {
        $this->auth();

        $this->view('kegiatan/index', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function kegiatanPaud()
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug('kegiatan-paud');

        $this->view('kegiatan/paud', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function kegiatanSd()
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug('kegiatan-sd');

        $this->view('kegiatan/sd', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function kegiatanSmp()
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug('kegiatan-smp');

        $this->view('kegiatan/smp', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function kegiatanSma()
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug('kegiatan-sma');

        $this->view('kegiatan/sma', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function kegiatanLainnya()
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug('kegiatan-lainnya');

        $this->view('kegiatan/lainnya', [
            'user' => $this->user,
            'role' => $this->role,
            'modules' => $modules,
        ]);
    }

    public function kegiatanWp()
    {
        $this->auth();

        $modules = $this->moduleModel->getByParentSlug('kegiatan-widyaprada');

        $this->view('kegiatan/widyaprada', [
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
