<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Publikasi SD";
$bannerTitle = "Publikasi SD";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($data);
// foreach ($data as $dt => $d):
//     if ($d['files']) {

//         $files = explode('##', $d['files']);

//         foreach ($files as $f) {

//             list($id, $nama, $path) = explode('|', $f);

//             echo "<a href='$path'>$nama</a><br>";
//         }
//     }

// endforeach;

// echo '</pre>';
$tanggalMulai   = $_GET['tanggal_mulai'] ?? null;
$tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
$jenis          = $_GET['jenis'] ?? null;

$deskripsi = 'Menampilkan seluruh data';

if ($tanggalMulai || $tanggalSelesai || $jenis) {

    $parts = [];

    if ($tanggalMulai && $tanggalSelesai) {
        $parts[] = "tanggal <strong>" . htmlspecialchars($tanggalMulai) .
            "</strong> sampai <strong>" . htmlspecialchars($tanggalSelesai) . "</strong>";
    } elseif ($tanggalMulai) {
        $parts[] = "tanggal <strong>" . htmlspecialchars($tanggalMulai) . "</strong>";
    }

    if ($jenis) {
        $parts[] = "jenis informasi '<strong>" .
            htmlspecialchars(ucwords(strtolower($jenis))) .
            "</strong>'";
    }

    $deskripsi = 'Filter data publikasi ' . implode(' dan ', $parts);
}

?>

<div class="page-body mt-3" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-12 mb-0">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=dashboard') ?>" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="<?= url('?page=peraturan-publik') ?>" class="h3 mb-0">
                                    Publikasi
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">
                                    <h3 class="card-title mb-0">Tabel Publikasi</h3>
                                    <p class="text-secondary m-0"><?= $deskripsi ?></p>
                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </span>
                                            <input id="advanced-table-search" type="text" class="form-control" autocomplete="off" placeholder="Cari Data Publikasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <form method="get">
                                            <div class="row">

                                                <input type="hidden" name="page" value="publikasi-publik">

                                                <div class="col-auto">
                                                    <input type="date"
                                                        name="tanggal_mulai"
                                                        class="form-control"
                                                        value="<?= htmlspecialchars($_GET['tanggal_mulai'] ?? '') ?>">
                                                </div>

                                                <div class="col-auto">
                                                    <input type="date"
                                                        name="tanggal_selesai"
                                                        class="form-control"
                                                        value="<?= htmlspecialchars($_GET['tanggal_selesai'] ?? '') ?>">
                                                </div>

                                                <div class="col-auto">
                                                    <select name="jenis" class="form-select w-auto">
                                                        <option value="">Semua Jenis</option>
                                                        <option value="BERKALA" <?= ($_GET['jenis'] ?? '') == 'BERKALA' ? 'selected' : '' ?>>Berkala</option>
                                                        <option value="SERTA MERTA" <?= ($_GET['jenis'] ?? '') == 'SERTA MERTA' ? 'selected' : '' ?>>Serta Merta</option>
                                                        <option value="SETIAP SAAT" <?= ($_GET['jenis'] ?? '') == 'SETIAP SAAT' ? 'selected' : '' ?>>Setiap Saat</option>
                                                        <option value="DIKECUALIKAN" <?= ($_GET['jenis'] ?? '') == 'DIKECUALIKAN' ? 'selected' : '' ?>>Dikecualikan</option>
                                                    </select>

                                                </div>
                                                <div class="col-auto ms-auto">
                                                    <button class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>
                                                        Filter
                                                    </button>
                                                    <a href="<?= url('?page=publikasi-publik') ?>" class="btn btn-secondary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                        Reset
                                                    </a>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="advanced-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-no">No</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-judul">Judul</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-tanggal">Tanggal</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-lokasi">Lokasi</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-pokja">Unit/Tim</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-file">File</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-aksi">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        <?php foreach ($data as $dt => $d): ?>
                                            <tr>
                                                <td class="sort-no text-center">
                                                    <?= $dt + 1 ?>
                                                </td>
                                                <td class="sort-judul">
                                                    <?= htmlspecialchars($d['judul'] ?? '-') ?>
                                                </td>

                                                <td class="sort-tanggal">
                                                    <?= htmlspecialchars(date('d/m/Y', strtotime($d['tanggal_kegiatan'])) ?? '-') ?>
                                                </td>
                                                <td class="sort-lokasi">
                                                    <?= htmlspecialchars($d['lokasi'] ?? '-') ?>
                                                </td>
                                                <td class="sort-pokja">
                                                    <?= htmlspecialchars($d['nama_tim'] ?? '-') ?>
                                                </td>
                                                <td class="sort-file">
                                                    <div class="btn-group me-1">
                                                        <?php
                                                        $listFile = [];

                                                        if (!empty($d['files'])) {

                                                            $files = explode('##', $d['files']);

                                                            foreach ($files as $f) {

                                                                $part = explode('|', $f);

                                                                if (count($part) === 4) {

                                                                    list($id, $nama, $path, $tipe) = $part;

                                                                    $listFile[] = [
                                                                        'nama_raw' => $nama,
                                                                        'path_raw' => $path,
                                                                        'tipe_raw' => $tipe
                                                                    ];
                                                                }
                                                            }
                                                        }

                                                        // tampilkan
                                                        foreach ($listFile as $f):
                                                            $nama = htmlspecialchars($f['nama_raw'], ENT_QUOTES, 'UTF-8');
                                                            $path = htmlspecialchars($f['path_raw'], ENT_QUOTES, 'UTF-8');
                                                            $ext  = strtolower(pathinfo($f['nama_raw'], PATHINFO_EXTENSION));

                                                            // SVG inline
                                                            if ($ext === 'pdf') {
                                                                $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M17 18h2" />
                                                                <path d="M20 15h-3v6" />
                                                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                            </svg>';
                                                            } else if ($ext === 'jpg' || $ext === 'jpeg') {
                                                                $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" />
                                                            </svg>';
                                                            } else if ($ext === 'png') {
                                                                $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 21v-6l3 6v-6" />
                                                            </svg>
                                                                ';
                                                            } else if ($ext === 'doc' || $ext === 'docx') {
                                                                $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-doc">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                                <path d="M20 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" />
                                                                <path d="M12.5 15a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5" />
                                                            </svg>
                                                                ';
                                                            } else if ($ext === 'ppt' || $ext === 'pptx') {
                                                                $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange icon icon-tabler icons-tabler-outline icon-tabler-file-type-ppt">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M16.5 15h3" />
                                                                <path d="M18 15v6" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                            </svg>
                                                                ';
                                                            } else if ($ext === 'xls' || $ext === 'xlsx') {
                                                                $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green icon icon-tabler icons-tabler-outline icon-tabler-file-type-xls">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M4 15l4 6" />
                                                                <path d="M4 21l4 -6" />
                                                                <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                                                <path d="M11 15v6h3" />
                                                            </svg>
                                                                ';
                                                            } else {
                                                                $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                                            </svg>';
                                                            }

                                                        ?>
                                                            <a href='<?= url($path) ?>' target='_blank'>
                                                                <?= $icon ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group w-100">
                                                        <a href="" class="text-primary me-1" data-bs-toggle="modal" data-bs-target="#modal-detail-<?= $d['id'] ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                            </svg>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>

                                            <div class="modal modal-blur fade" id="modal-detail-<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Detail Publikasi</h3>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <dl class="row">
                                                                <dt class="col-4 text-muted mb-3">Judul</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['judul'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Deskripsi</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['deskripsi'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Tanggal</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['tanggal_kegiatan'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Lokasi</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong>Tahun <?= $d['lokasi'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Jenis</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['jenis'] ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Penulis</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['penulis'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Kabupaten/Kota</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['kabupaten'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Link</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><a href="<?= empty($d['link']) ? '-'  : $d['link'] ?>"><?= empty($d['link']) ? '-'  : $d['link'] ?></a></dd>
                                                                <dt class="col-4 text-muted">File</dt>
                                                                <dt class="col-1 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold">
                                                                    <?php
                                                                    $listFile = [];

                                                                    if (!empty($d["files"])) {
                                                                        $files = explode("##", $d["files"],);

                                                                        foreach ($files as $f) {
                                                                            $part = explode("|", $f,);

                                                                            if (count($part) === 4) {
                                                                                [
                                                                                    $id,
                                                                                    $nama,
                                                                                    $path,
                                                                                    $tipe,
                                                                                ] = $part;

                                                                                $listFile[] = [
                                                                                    'id' => $id,
                                                                                    'nama_raw' => $nama,
                                                                                    'path_raw' => $path,
                                                                                    'tipe_raw' => $tipe
                                                                                ];
                                                                            }
                                                                        }
                                                                    }

                                                                    // tampilkan
                                                                    foreach ($listFile as $f):
                                                                        $nama = htmlspecialchars($f['nama_raw'], ENT_QUOTES, 'UTF-8');
                                                                        $path = htmlspecialchars($f['path_raw'], ENT_QUOTES, 'UTF-8');
                                                                        $ext  = strtolower(pathinfo($f['nama_raw'], PATHINFO_EXTENSION));
                                                                        // SVG inline
                                                                        $fid = $f["id"];
                                                                        if ($ext === 'pdf') {
                                                                            $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M17 18h2" />
                                                                <path d="M20 15h-3v6" />
                                                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                            </svg>';
                                                                        } else if ($ext === 'jpg' || $ext === 'jpeg') {
                                                                            $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" />
                                                            </svg>';
                                                                        } else if ($ext === 'png') {
                                                                            $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 21v-6l3 6v-6" />
                                                            </svg>
                                                                ';
                                                                        } else if ($ext === 'doc' || $ext === 'docx') {
                                                                            $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-doc">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                                <path d="M20 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" />
                                                                <path d="M12.5 15a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5" />
                                                            </svg>
                                                                ';
                                                                        } else if ($ext === 'ppt' || $ext === 'pptx') {
                                                                            $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange icon icon-tabler icons-tabler-outline icon-tabler-file-type-ppt">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M16.5 15h3" />
                                                                <path d="M18 15v6" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                            </svg>
                                                                ';
                                                                        } else if ($ext === 'xls' || $ext === 'xlsx') {
                                                                            $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green icon icon-tabler icons-tabler-outline icon-tabler-file-type-xls">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M4 15l4 6" />
                                                                <path d="M4 21l4 -6" />
                                                                <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                                                <path d="M11 15v6h3" />
                                                            </svg>
                                                                ';
                                                                        } else {
                                                                            $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                                            </svg>';
                                                                        }
                                                                    ?>
                                                                        <div class="col-12 mb-0">

                                                                            <a href='<?= url($path) ?>' target='_blank' class="mb-1">
                                                                                <?= $icon ?>&nbsp;<?= shortname($nama, 20) ?>
                                                                            </a>
                                                                            <a href="<?= url('?page=dip-file&file=' . $fid . '&id=' . $d['id']) ?>" class="icon icon-sm text-end mt-0" aria-label="Button" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2fb344" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                                    <path d="M7 11l5 5l5 -5" />
                                                                                    <path d="M12 4l0 12" />
                                                                                </svg>
                                                                            </a>
                                                                        </div>
                                                                    <?php
                                                                    endforeach;
                                                                    ?>
                                                                </dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <div class="dropdown">
                                    <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                                        <span id="page-count" class="me-1">10</span>
                                        <span>records</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100 records</a>
                                    </div>
                                </div>
                                <ul class="pagination m-0 ms-auto">
                                    <li class="page-item active"><a class="page-link cursor-pointer" data-i="1" data-page="20">1</a></li>
                                    <li class="page-item"><a class="page-link cursor-pointer" data-i="2" data-page="20">2</a></li>
                                    <li class="page-item disabled"><a class="page-link cursor-pointer">...</a></li>
                                    <li class="page-item"><a class="page-link cursor-pointer" data-i="7" data-page="20">7</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const advancedTable = {
        headers: [{
                "data-sort": "sort-no",
                name: "No"
            },

            {
                "data-sort": "sort-judul",
                name: "Judul"
            },
            {
                "data-sort": "sort-tanggal",
                name: "Tanggal"
            },
            {
                "data-sort": "sort-lokasi",
                name: "Lokasi"
            },
            {
                "data-sort": "sort-pokja",
                name: "Unit/Tim"
            },
            {
                "data-sort": "sort-file",
                name: "File"
            },
            {
                "data-sort": "sort-aksi",
                name: "Aksi"
            },
        ],
    };
    const setPageListItems = (e) => {
        window.tabler_list["advanced-table"].page = parseInt(e.target.dataset.value);
        window.tabler_list["advanced-table"].update();
        document.querySelector("#page-count").innerHTML = e.target.dataset.value;
    };
    window.tabler_list = window.tabler_list || {};
    document.addEventListener("DOMContentLoaded", function() {
        const list = (window.tabler_list["advanced-table"] = new List("advanced-table", {
            sortClass: "table-sort",
            listClass: "table-tbody",
            page: parseInt("10"),
            pagination: {
                item: (value) => {
                    return `<li class="page-item"><a class="page-link cursor-pointer">${value.page}</a></li>`;
                },
                innerWindow: 1,
                outerWindow: 1,
                left: 0,
                right: 0,
            },
            valueNames: advancedTable.headers.map((header) => header["data-sort"]),
        }));
        const searchInput = document.querySelector("#advanced-table-search");
        if (searchInput) {
            searchInput.addEventListener("input", () => {
                list.search(searchInput.value);
            });
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const spinner = document.getElementById("spinner");
        const pageContent = document.getElementById("page-content");

        window.addEventListener("load", function() {
            spinner.style.display = "none";
            pageContent.style.display = "block";
        });
    });
</script>

<script>
    function confirmDelete(url, label = '') {

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = url;
            }

        });
    }
</script>
<?php if (isset($_SESSION['flash'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: '<?= $_SESSION['flash']['status'] ?>',
                title: <?= $_SESSION['flash']['status'] === 'success'
                            ? "'Berhasil!'"
                            : "'Gagal!'" ?>,
                text: <?= json_encode($_SESSION['flash']['message']) ?>
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
