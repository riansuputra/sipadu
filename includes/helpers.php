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
        return "Sudah pensiun ({$tahunPensiun})";
    }

    $diff = $now->diff($tglPensiun);

    if ($diff->y >= 5) {
        return "> 5 tahun ({$tahunPensiun})";
    }

    if ($diff->y >= 1) {
        return "{$diff->y} th ({$tahunPensiun})";
    }

    return "{$diff->m} bln ({$tahunPensiun})";
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

function logActivity(array $data)
{
    global $pdo;

    if (empty($data['user_id']) || empty($data['action']) || empty($data['entity_type'])) {
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO log
        (user_id, role_id, action, entity_type, entity_id, description, ip_address, user_agent)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        (int) $data['user_id'],
        $data['role_id'] ?? null,
        $data['action'],
        $data['entity_type'],
        $data['entity_id'] ?? null,
        $data['description'] ?? null,
        $_SERVER['REMOTE_ADDR'] ?? null,
        $_SERVER['HTTP_USER_AGENT'] ?? null
    ]);
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
