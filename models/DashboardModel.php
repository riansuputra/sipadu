<?php

require_once __DIR__ . '/../models/ArsipModel.php';
require_once __DIR__ . '/../models/DipModel.php';
require_once __DIR__ . '/../models/PegawaiModel.php';
require_once __DIR__ . '/../models/PublikasiModel.php';
require_once __DIR__ . '/../models/PeraturanModel.php';

class DashboardModel
{
    protected $db;
    protected $arsipModel;
    protected $dipModel;
    protected $pegawaiModel;
    protected $publikasiModel;
    protected $peraturanModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->arsipModel = new ArsipModel();
        $this->dipModel = new DipModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->publikasiModel = new PublikasiModel();
        $this->peraturanModel = new PeraturanModel();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollBack();
    }

    public function getDashboardAdmin()
    {
        return [
            'total_arsip'   => $this->arsipModel->countAll(),
            'total_pegawai' => $this->pegawaiModel->countAll(),
            'total_publikasi' => $this->publikasiModel->countAll(),
            'total_peraturan' => $this->peraturanModel->countAll(),
        ];
    }

    public function getDashboardArsiparis()
    {
        $totalDip = $this->dipModel->getTotalUkuran();
        $totalPeraturan = $this->peraturanModel->getTotalUkuran();

        return [
            'total_dip' => $this->dipModel->getTotalDip(),
            'size_dip' => formatSize($this->dipModel->getTotalUkuran()),
            'size_peraturan' => formatSize($this->peraturanModel->getTotalUkuran()),
            'dip_tahun_ini' => $this->dipModel->getDipTahunIni(),
            'total_peraturan' => $this->peraturanModel->getTotalPeraturan(),
            'peraturan_tahun_ini' => $this->peraturanModel->getPeraturanTahunIni(),

            // CHART
            'dip_chart' => $this->formatChartPerTahun($this->dipModel->getDipPerTahun()),
            'peraturan_chart' => $this->formatChartPerTahun($this->peraturanModel->getPeraturanPerTahun()),
        ];
    }

    public function getDashboardKepegawaian()
    {
        return [
            'rata_umur' => $this->pegawaiModel->getRataRataUmur(),
            'pensiun' => $this->pegawaiModel->getRingkasanPensiunPerTahun(date('Y'), date('Y')),
            'golongan_chart' => $this->getGolonganChart(),
            'gender_chart' => $this->getGenderChart(),
            'pendidikan_chart' => $this->getPendidikanChart(),
            'komposisi_chart' => $this->getPegawaiChart(),
        ];
    }

    public function getDashboardTimPublikasi()
    {
        return [
            'total_file' => $this->publikasiModel->getTotalFile(),
            'size_publikasi' => formatSize($this->publikasiModel->getTotalUkuran()),
            'terpublikasi' => $this->publikasiModel->getTotalPublished(),
            'total_publikasi' => $this->publikasiModel->countAll(),
            'publikasi_chart' => $this->getPublikasiChartBulanan(),
            'publikasi_pokja_chart' => $this->getPublikasiPerPokjaChartTahunIni(),
        ];
    }



    public function getArsipChart()
    {
        $raw = $this->arsipModel->getArsipPerHari();

        $map = [];
        foreach ($raw as $row) {
            $map[$row['tanggal']] = (int)$row['total'];
        }

        $labels = [];
        $data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $labels[] = date('d M', strtotime($date));
            $data[]   = $map[$date] ?? 0;
        }

        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }

    public function getPublikasiChart()
    {
        $publikasiModel = new PublikasiModel();
        $raw = $publikasiModel->getPublikasiPerHari();

        // mapping tanggal => total
        $map = [];
        foreach ($raw as $row) {
            $map[$row['tanggal']] = (int)$row['total'];
        }

        $labels = [];
        $data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $labels[] = date('d M', strtotime($date));
            $data[]   = $map[$date] ?? 0;
        }

        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }

    public function getPegawaiChart()
    {
        $pegawaiModel = new PegawaiModel();
        $rows = $this->pegawaiModel->getAllPegawaiAktif();

        // default
        $map = [
            'PNS' => 0,
            'PPPK' => 0,
            'PPNPN/OUTSOURCING' => 0
        ];

        foreach ($rows as $row) {

            $usiaPensiun = usiaPensiunPegawai(!empty($row['is_widyaprada']));
            $tanggalPensiun = tanggalPensiunPegawai($row['tanggal_lahir'], $usiaPensiun);

            if (!$tanggalPensiun) {
                continue;
            }

            if (strtotime($tanggalPensiun) <= time()) {
                continue;
            }

            $status = $row['status_asn'];
            $map[$status] = ($map[$status] ?? 0) + 1;
        }

        return [
            'labels' => ['PNS', 'PPPK', 'PPNPN/Outsourcing'],
            'data' => [
                $map['PNS'],
                $map['PPPK'],
                $map['PPNPN/OUTSOURCING']
            ]
        ];
    }

    public function getPublikasiPerPokjaChart()
    {
        $publikasiModel = new PublikasiModel();
        $raw = $publikasiModel->getPublikasiPerPokja();

        $default = ['Widyaprada', 'SD', 'SMP', 'SMA', 'PAUD'];

        $map = array_fill_keys($default, 0);

        foreach ($raw as $row) {
            if (isset($map[$row['pokja_nama']])) {
                $map[$row['pokja_nama']] = (int)$row['total'];
            }
        }

        return [
            'labels' => array_keys($map),
            'data'   => array_values($map)
        ];
    }

    public function getLogDashboard()
    {
        $logModel = new PegawaiModel();
        return $logModel->getLatestLog(5); // ambil 10 terbaru
    }

    public function getArsipChartBulanan()
    {
        $raw = $this->arsipModel->getArsipPerBulan();

        // 12 bulan default
        $bulanLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        $dataMap = array_fill(1, 12, 0);

        foreach ($raw as $row) {
            $dataMap[(int)$row['bulan']] = (int)$row['total'];
        }

        return [
            'labels' => $bulanLabels,
            'data'   => array_values($dataMap)
        ];
    }

    // Chart publikasi bulanan
    public function getPublikasiChartBulanan($pokjaId = null)
    {
        $raw = $this->publikasiModel->getPublikasiPerBulan($pokjaId);

        $bulanLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        $dataMap = array_fill(1, 12, 0);

        foreach ($raw as $row) {
            $dataMap[(int)$row['bulan']] = (int)$row['total'];
        }

        return [
            'labels' => $bulanLabels,
            'data'   => array_values($dataMap)
        ];
    }

    public function getPublikasiPerPokjaChartTahunIni()
    {
        $raw = $this->publikasiModel->getPublikasiPerPokjaTahunIni();

        $default = ['Widyaprada', 'SD', 'SMP', 'SMA', 'PAUD'];
        $map = array_fill_keys($default, 0);

        foreach ($raw as $row) {
            if (isset($map[$row['pokja_nama']])) {
                $map[$row['pokja_nama']] = (int)$row['total'];
            }
        }

        return [
            'labels' => array_keys($map),
            'data'   => array_values($map)
        ];
    }

    private function formatChartPerTahun($raw)
    {
        $labels = [];
        $data   = [];

        foreach ($raw as $row) {
            $labels[] = (string)$row['tahun'];
            $data[]   = (int)$row['total'];
        }

        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }

    public function getJenisInformasiChart()
    {
        $dipModel = new DipModel();
        $raw = $dipModel->getJenisInformasi();

        // 🔥 mapping label custom
        $mapping = [
            'berkala' => 'Berkala',
            'serta_merta' => 'Serta Merta',
            'setiap_saat' => 'Setiap Saat',
            'dikecualikan' => 'Dikecualikan',
        ];

        // default (pakai label yang sudah rapi)
        $map = [
            'Berkala' => 0,
            'Serta Merta' => 0,
            'Setiap Saat' => 0,
            'Dikecualikan' => 0,
        ];

        foreach ($raw as $row) {
            $key = $row['jenis_informasi'];

            if (isset($mapping[$key])) {
                $label = $mapping[$key];
                $map[$label] = (int)$row['total'];
            }
        }

        return [
            'labels' => array_keys($map),
            'data'   => array_values($map)
        ];
    }

    public function getDashboardDip()
    {
        $dipModel = new DipModel();

        $totalDip = $dipModel->getTotalDip();
        $totalFile = $dipModel->getTotalFile();

        return [
            'total_dip' => $totalDip,
            'dip_tahun_ini' => $dipModel->getDipTahunIni(),

            // 🔥 FILE
            'total_file' => $totalFile,
            'total_size' => formatSize($dipModel->getTotalUkuran()),

            // optional
            'avg_file_per_dip' => $totalDip > 0 ? round($totalFile / $totalDip, 2) : 0,
        ];
    }

    public function getGolonganChart()
    {
        $pegawaiModel = new PegawaiModel();
        $raw = $pegawaiModel->getGolonganRuang();

        $labels = [];
        $data   = [];

        foreach ($raw as $row) {
            $labels[] = $row['pangkat_golongan'];
            $data[]   = (int)$row['total'];
        }

        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }

    public function getGenderChart()
    {
        $pegawaiModel = new PegawaiModel();
        $raw = $pegawaiModel->getGender();

        // mapping biar rapi
        $map = [
            'Laki-laki' => 0,
            'Perempuan' => 0,
        ];

        foreach ($raw as $row) {
            if ($row['jenis_kelamin'] === 'L') {
                $map['Laki-laki'] = (int)$row['total'];
            } elseif ($row['jenis_kelamin'] === 'P') {
                $map['Perempuan'] = (int)$row['total'];
            }
        }

        return [
            'labels' => array_keys($map),
            'data'   => array_values($map)
        ];
    }

    public function getPendidikanChart()
    {
        $pegawaiModel = new PegawaiModel();
        $raw = $pegawaiModel->getPendidikan();

        $labels = [];
        $data   = [];

        foreach ($raw as $row) {
            $labels[] = $row['pendidikan'];
            $data[]   = (int)$row['total'];
        }

        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }

    // Chart komposisi publikasi per jenis
    public function getPublikasiJenisChart($pokjaId = null)
    {
        $raw = $this->publikasiModel->getPublikasiPerJenis($pokjaId);

        $labels = [];
        $data   = [];

        foreach ($raw as $row) {
            $labels[] = $row['jenis'];
            $data[]   = (int)$row['total'];
        }

        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }
}
