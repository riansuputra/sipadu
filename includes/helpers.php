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

function umurTahun($tanggalLahir)
{
    if (empty($tanggalLahir)) return '-';

    return (new DateTime($tanggalLahir))
        ->diff(new DateTime())
        ->y;
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

function debug_log($data, $title = 'DEBUG')
{
    $log = "[" . date('Y-m-d H:i:s') . "] $title\n";
    $log .= print_r($data, true) . "\n\n";

    file_put_contents(__DIR__ . '/../logs/debug.log', $log, FILE_APPEND);
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
