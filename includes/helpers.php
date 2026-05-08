<?php
function tgl_sekarang()
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $tgl   = (int) date('d');
    $bln   = (int) date('m');
    $thn   = date('Y');

    return $tgl . ' ' . $bulan[$bln] . ' ' . $thn;
}


function shortName($text, $limit = 20)
{
    return strlen($text) > $limit
        ? substr($text, 0, $limit) . '...'
        : $text;
}

if (!function_exists('umurTahun')) {
    function umurTahun($tanggalLahir)
    {
        if (empty($tanggalLahir)) return '-';

        return (new DateTime($tanggalLahir))
            ->diff(new DateTime())
            ->y;
    }
}

if (!function_exists('usiaPensiunPegawai')) {
    function usiaPensiunPegawai($isWidyaprada = false)
    {
        return $isWidyaprada ? 60 : 58;
    }
}

if (!function_exists('tanggalPensiunPegawai')) {
    function tanggalPensiunPegawai($tanggalLahir, $usiaPensiun = 58)
    {
        if (empty($tanggalLahir)) return null;

        $lahir = new DateTime($tanggalLahir);

        // Tanggal ulang tahun usia pensiun
        $ulangTahunPensiun = (clone $lahir)->modify("+{$usiaPensiun} years");

        // Pensiun resmi: tanggal 1 bulan berikutnya
        $tanggalPensiun = (clone $ulangTahunPensiun)->modify('first day of next month');

        return $tanggalPensiun->format('Y-m-d');
    }
}

if (!function_exists('statusPegawai')) {
    function statusPegawai($tanggalLahir, $usiaPensiun = 58)
    {
        $tanggalPensiun = tanggalPensiunPegawai($tanggalLahir, $usiaPensiun);

        if (empty($tanggalPensiun)) return '-';

        $today = new DateTime(date('Y-m-d'));
        $pensiun = new DateTime($tanggalPensiun);

        return $today >= $pensiun ? 'Pensiun' : 'Aktif';
    }
}

if (!function_exists('infoPensiunPegawai')) {
    function infoPensiunPegawai($tanggalLahir, $usiaPensiun = 58)
    {
        if (empty($tanggalLahir)) {
            return [
                'text' => '-',
                'badge' => 'secondary',
                'status' => '-',
                'tanggal_pensiun' => null,
                'tahun_pensiun' => null,
                'sisa_bulan' => null
            ];
        }

        $tanggalPensiun = tanggalPensiunPegawai($tanggalLahir, $usiaPensiun);

        $today = new DateTime(date('Y-m-d'));
        $pensiun = new DateTime($tanggalPensiun);

        $tahunPensiun = $pensiun->format('Y');

        // Kalau sudah pensiun
        if ($today >= $pensiun) {
            return [
                'text' => "Pensiun<br>({$tahunPensiun})",
                'badge' => 'danger w-100',
                'status' => 'Pensiun',
                'tanggal_pensiun' => $tanggalPensiun,
                'tahun_pensiun' => $tahunPensiun,
                'sisa_bulan' => 0
            ];
        }

        $diff = $today->diff($pensiun);
        $totalBulan = ($diff->y * 12) + $diff->m;

        $text = [];

        if ($diff->y > 0) {
            $text[] = $diff->y . ' th';
        }

        if ($diff->m > 0) {
            $text[] = $diff->m . ' bln';
        }

        if ($diff->y == 0 && $diff->m == 0) {
            $text[] = $diff->d . ' hr';
        }

        $label = implode(' ', $text) . "<br>({$tahunPensiun})";

        // Warna badge
        if ($totalBulan < 3) {
            $badge = 'danger w-100';
        } elseif ($totalBulan < 6) {
            $badge = 'warning w-100';
        } else {
            $badge = 'success w-100';
        }

        return [
            'text' => $label,
            'badge' => $badge,
            'status' => 'Aktif',
            'tanggal_pensiun' => $tanggalPensiun,
            'tahun_pensiun' => $tahunPensiun,
            'sisa_bulan' => $totalBulan
        ];
    }
}

if (!function_exists('infoPensiunPegawaiDetail')) {
    function infoPensiunPegawaiDetail($tanggalLahir, $usiaPensiun = 58)
    {
        if (empty($tanggalLahir)) {
            return [
                'text' => '-',
                'badge' => 'secondary',
                'status' => '-',
                'tanggal_pensiun' => null,
                'tahun_pensiun' => null,
                'sisa_bulan' => null
            ];
        }

        $tanggalPensiun = tanggalPensiunPegawai($tanggalLahir, $usiaPensiun);

        $today = new DateTime(date('Y-m-d'));
        $pensiun = new DateTime($tanggalPensiun);

        $tahunPensiun = $pensiun->format('Y');

        // Kalau sudah pensiun
        if ($today >= $pensiun) {
            return [
                'text' => "Pensiun ({$tahunPensiun})",
                'badge' => 'danger',
                'status' => 'Pensiun',
                'tanggal_pensiun' => $tanggalPensiun,
                'tahun_pensiun' => $tahunPensiun,
                'sisa_bulan' => 0
            ];
        }

        $diff = $today->diff($pensiun);
        $totalBulan = ($diff->y * 12) + $diff->m;

        $text = [];

        if ($diff->y > 0) {
            $text[] = $diff->y . ' th';
        }

        if ($diff->m > 0) {
            $text[] = $diff->m . ' bln';
        }

        if ($diff->y == 0 && $diff->m == 0) {
            $text[] = $diff->d . ' hr';
        }

        $label = implode(' ', $text) . " ({$tahunPensiun})";

        // Warna badge
        if ($totalBulan < 3) {
            $badge = 'danger';
        } elseif ($totalBulan < 6) {
            $badge = 'warning';
        } else {
            $badge = 'success';
        }

        return [
            'text' => $label,
            'badge' => $badge,
            'status' => 'Aktif',
            'tanggal_pensiun' => $tanggalPensiun,
            'tahun_pensiun' => $tahunPensiun,
            'sisa_bulan' => $totalBulan
        ];
    }
}

if (!function_exists('masaKerjaPegawai')) {
    function masaKerjaPegawai($tmtMasuk)
    {
        if (empty($tmtMasuk)) return '-';

        $tmt = new DateTime($tmtMasuk);
        $today = new DateTime(date('Y-m-d'));

        if ($tmt > $today) return '-';

        $diff = $tmt->diff($today);

        $hasil = [];

        if ($diff->y > 0) {
            $hasil[] = $diff->y . ' th';
        }

        if ($diff->m > 0) {
            $hasil[] = $diff->m . ' bln';
        }

        if ($diff->y == 0 && $diff->m == 0) {
            $hasil[] = $diff->d . ' hr';
        }

        return implode(' ', $hasil);
    }
}


function statusPensiunSingkat($tanggalLahir, $usiaPensiun = 58)
{
    if (empty($tanggalLahir)) return '-';

    $lahir = new DateTime($tanggalLahir);
    $tglPensiun = (clone $lahir)->modify("+{$usiaPensiun} years");
    $now = new DateTime();

    $tahunPensiun = $tglPensiun->format('Y');

    if ($now >= $tglPensiun) {
        return "Sudah pensiun <br>({$tahunPensiun})";
    }

    $diff = $now->diff($tglPensiun);

    if ($diff->y >= 5) {
        return "> 5 tahun <br>({$tahunPensiun})";
    }

    if ($diff->y >= 1) {
        return "{$diff->y} th <br>({$tahunPensiun})";
    }

    return "{$diff->m} bln <br>({$tahunPensiun})";
}

function abort404()
{
    http_response_code(404);
    require __DIR__ . '/../views/errors/404.php';
    exit;
}

function abort403()
{
    http_response_code(403);
    require __DIR__ . '/../views/errors/403.php';
    exit;
}

function isMaintenance(string $page): bool
{
    return in_array($page, MAINTENANCE_PAGES);
}

function showMaintenance()
{
    require __DIR__ . '/../views/errors/maintenance.php';
    exit;
}

function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function getRoleButuhPokja(): array
{
    // isinya ROLE_ID (bukan kode)
    return [
        2, // ADMIN TIM
        4  // STAFF
    ];
}

function dd(...$vars)
{
    echo "<pre style='background:#111;color:#0f0;padding:20px'>";
    foreach ($vars as $v) {
        var_dump($v);
    }
    echo "</pre>";
    die();
}

function dump(...$vars)
{
    echo "<pre>";
    foreach ($vars as $v) {
        var_dump($v);
    }
    echo "</pre>";
}

// simpan log debug
function debug_log($data, $title = 'DEBUG')
{
    $dir = __DIR__ . '/../logs';

    // buat folder logs jika belum ada
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $file = $dir . '/debug.log';

    $log  = "[" . date('Y-m-d H:i:s') . "] ";
    $log .= $title . PHP_EOL;
    $log .= print_r($data, true);
    $log .= PHP_EOL;
    $log .= str_repeat("=", 80);
    $log .= PHP_EOL . PHP_EOL;

    file_put_contents($file, $log, FILE_APPEND);
}

// Format ukuran file agar lebih mudah dibaca
function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return $bytes . ' byte';
    } else {
        return '0 bytes';
    }
}

// Format tanggal ke versi Indonesia
function formatTanggalIndonesia($tanggal = null)
{
    if (empty($tanggal)) return '-';

    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $timestamp = strtotime($tanggal);

    $hari = date('d', $timestamp);
    $bulanIndex = (int) date('n', $timestamp);
    $tahun = date('Y', $timestamp);

    return $hari . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
}

// Format rentang tanggal kegiatan / arsip
function formatTanggalRange($mulai = null, $selesai = null)
{
    // Jika dua-duanya kosong
    if (empty($mulai) && empty($selesai)) {
        return '-';
    }

    // Jika hanya tanggal mulai yang ada
    if (!empty($mulai) && empty($selesai)) {
        return formatTanggalIndonesia($mulai);
    }

    // Jika hanya tanggal selesai yang ada
    if (empty($mulai) && !empty($selesai)) {
        return formatTanggalIndonesia($selesai);
    }

    // Jika sama, tampilkan sekali saja
    if ($mulai === $selesai) {
        return formatTanggalIndonesia($mulai);
    }

    // Jika berbeda, tampilkan range
    return formatTanggalIndonesia($mulai) . ' - ' . formatTanggalIndonesia($selesai);
}

// Format rentang tanggal untuk tampilan tabel (bisa pakai <br>)
function formatTanggalRangeTable($mulai = null, $selesai = null)
{
    // Jika dua-duanya kosong
    if (empty($mulai) && empty($selesai)) {
        return '-';
    }

    // Jika hanya tanggal mulai yang ada
    if (!empty($mulai) && empty($selesai)) {
        return formatTanggalIndonesia($mulai);
    }

    // Jika hanya tanggal selesai yang ada
    if (empty($mulai) && !empty($selesai)) {
        return formatTanggalIndonesia($selesai);
    }

    // Jika sama, tampilkan sekali saja
    if ($mulai === $selesai) {
        return formatTanggalIndonesia($mulai);
    }

    // Jika berbeda, tampilkan bertingkat untuk tabel
    return formatTanggalIndonesia($mulai) . '<span class="text-muted"> s/d</span><br><span class="">' . formatTanggalIndonesia($selesai) . '</span>';
}


// Format waktu jadi "human readable"
function timeAgo($datetime)
{
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return $diff . ' detik lalu';
    }

    $minutes = floor($diff / 60);
    if ($minutes < 60) {
        return $minutes . ' menit lalu';
    }

    $hours = floor($diff / 3600);
    if ($hours < 24) {
        return $hours . ' jam lalu';
    }

    $days = floor($diff / 86400);
    if ($days < 7) {
        return $days . ' hari lalu';
    }

    $weeks = floor($diff / 604800);
    if ($weeks < 4) {
        return $weeks . ' minggu lalu';
    }

    $months = floor($diff / 2592000);
    if ($months < 12) {
        return $months . ' bulan lalu';
    }

    $years = floor($diff / 31536000);
    return $years . ' tahun lalu';
}

function formatSize($bytes)
{
    if ($bytes >= 1073741824) {
        return round($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    }
    return $bytes . ' B';
}
