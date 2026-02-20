<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "DIP";

// Mulai buffer konten
ob_start();
?>


<?php

// echo '<pre>';
// foreach ($data as $dt => $d):

//     var_dump(strlen($d['files']));
//     var_dump($d['files']);
//     die;

// endforeach;

// echo '</pre>';


$tahun = $_GET['tahun'] ?? null;
$jenis = $_GET['jenis'] ?? null;

$deskripsi = 'Menampilkan seluruh data';

if ($tahun || $jenis) {

    $parts = [];

    if ($tahun) {
        $parts[] = "tahun '<strong>" . htmlspecialchars($tahun) . "</strong>'";
    }

    if ($jenis) {
        $parts[] = "jenis informasi '<strong>" . htmlspecialchars(ucwords(strtolower($jenis))) . "</strong>'";
    }

    $deskripsi = 'Filter data DIP ' . implode(' dan ', $parts);
}
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">DIP</div>
                <h2 class="page-title">Daftar DIP</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= url('/?page=tambah-dip') ?>" class="btn btn-primary btn-5 d-none d-sm-inline-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah DIP
                    </a>
                    <a href="<?= url('/?page=tambah-dip') ?>" class="btn btn-primary btn-6 d-sm-none btn-icon">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">
            <div class="col-12">
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">
                                    <h3 class="card-title mb-0">Tabel DIP</h3>
                                    <p class="text-secondary m-0"><?= $deskripsi ?></p>
                                </div>
                                <div class="col-md-auto col-sm-6">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </span>
                                            <input id="advanced-table-search" type="text" class="form-control" autocomplete="off" placeholder="Cari Data DIP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-auto col-sm-6">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <form method="get">
                                            <div class="row">

                                                <input type="hidden" name="page" value="dip">
                                                <div class="col-auto">
                                                    <select name="tahun" class="form-select w-auto">
                                                        <option value="">Semua Tahun</option>
                                                        <?php for ($t = date('Y'); $t >= 1990; $t--): ?>
                                                            <option value="<?= $t ?>"
                                                                <?= ($_GET['tahun'] ?? '') == $t ? 'selected' : '' ?>>
                                                                <?= $t ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <select name="jenis" class="form-select w-auto">
                                                        <option value="">Semua Jenis</option>
                                                        <option value="berkala" <?= ($_GET['jenis'] ?? '') == 'berkala' ? 'selected' : '' ?>>Berkala</option>
                                                        <option value="serta_merta" <?= ($_GET['jenis'] ?? '') == 'serta_merta' ? 'selected' : '' ?>>Serta Merta</option>
                                                        <option value="setiap_saat" <?= ($_GET['jenis'] ?? '') == 'setiap_saat' ? 'selected' : '' ?>>Setiap Saat</option>
                                                        <option value="dikecualikan" <?= ($_GET['jenis'] ?? '') == 'dikecualikan' ? 'selected' : '' ?>>Dikecualikan</option>
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
                                                    <a href="<?= url('?page=dip') ?>" class="btn btn-secondary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
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

                        <div id="">
                            <div class="table-responsive">
                                <table id="dipTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:1%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-no">No</button>
                                            </th>
                                            <th style="width:50%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-nama">Nama Informasi</button>
                                            </th>
                                            <th style="width:1%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-tahun">Tahun</button>
                                            </th>
                                            <th style="width:1%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-jenis">Jenis Informasi</button>
                                            </th>
                                            <th style="width:1%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-retensi">Retensi</button>
                                            </th>
                                            <th style="width:1%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-bentuk">Bentuk</button>
                                            </th>
                                            <th style="width:1%;">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-file">File</button>
                                            </th>
                                            <th style="width:1%;">
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
                                                <td class="sort-nama">
                                                    <?= htmlspecialchars($d["nama_informasi"]) ?>
                                                </td>
                                                <td class="sort-tahun">
                                                    <?= htmlspecialchars($d["tahun_pembuatan"]) ?>
                                                </td>
                                                <td class="sort-jenis">
                                                    <?php if ($d["jenis_informasi"] === "berkala") {
                                                        $bg = "bg-blue text-blue-fg";
                                                        $text = 'Berkala';
                                                    } elseif ($d["jenis_informasi"] === "serta_merta") {
                                                        $bg = "bg-red text-red-fg";
                                                        $text = 'Serta Merta';
                                                    } elseif ($d["jenis_informasi"] === "setiap_saat") {
                                                        $bg = "bg-green text-green-fg";
                                                        $text = 'Setiap Saat';
                                                    } else {
                                                        $bg = "bg-yellow text-yellow-fg";
                                                        $text = 'Dikecualikan';
                                                    } ?>
                                                    <span class="badge <?= $bg ?>"><?= $text ?></span>
                                                </td>
                                                <td class="sort-retensi">
                                                    <?= htmlspecialchars($d["retensi_arsip"]) ?>
                                                </td>
                                                <td class="sort-bentuk">
                                                    <?php if ($d["bentuk_informasi"] === "hardcopy") {
                                                        $badge =
                                                            '<span class="badge badge-outline text-dark">Hardcopy</span>';
                                                    } elseif ($d["bentuk_informasi"] === "softcopy") {
                                                        $badge =
                                                            '<span class="badge badge-outline text-dark ">Softcopy</span>';
                                                    } else {
                                                        $badge =
                                                            '<span class="badge badge-outline text-dark">Hardcopy<br>Softcopy</span>';
                                                    }
                                                    ?>
                                                    <div class="badges-list">
                                                        <?= $badge ?>
                                                    </div>
                                                </td>
                                                <td class="sort-file">
                                                    <div class="btn-group w-100">
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
                                                            <a href='<?= url($path) ?>' target='_blank' class="me-1">
                                                                <?= $icon ?>
                                                            </a>
                                                        <?php
                                                        endforeach;
                                                        ?>
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
                                                        <a href="<?= url('?page=edit-dip&id=' . $d["id"]) ?>" class="text-yellow me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <a type="button" class="text-red" onclick="confirmDelete(
                                                                '<?= url('?page=dip-delete&id=' . $d['id']) ?>'
                                                            )">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>


                                            <div class="modal fade" id="modal-detail-<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Detail DIP</h3>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <dl class="row">
                                                                <dt class="col-4 text-muted mb-3">Nama Informasi</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['nama_informasi'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Unit Kerja yang Menyediakan</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['unit_penyedia'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Penanggung Jawab Informasi</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['penanggung_jawab'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Waktu dan Tempat Pembuatan</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong>Tahun <?= $d['tahun_pembuatan'] ?? '-' ?>, <?= $d['tempat_pembuatan'] ?? '-' ?></strong></dd>
                                                                <dt class="col-4 text-muted mb-3">Jenis Informasi</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><span class="badge <?= $bg ?>"><?= $text ?></span></dd>
                                                                <dt class="col-4 text-muted mb-3">Bentuk Informasi</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3">
                                                                    <?php if ($d["bentuk_informasi"] === "hardcopy") {
                                                                        $badge =
                                                                            '<span class="badge bg-dark text-dark-fg">Hardcopy</span>';
                                                                    } elseif ($d["bentuk_informasi"] === "softcopy") {
                                                                        $badge =
                                                                            '<span class="badge badge-outline text-dark ">Softcopy</span>';
                                                                    } else {
                                                                        $badge =
                                                                            '<span class="badge bg-dark text-dark-fg">Hardcopy</span><span class="badge badge-outline text-dark ">Softcopy</span>';
                                                                    }
                                                                    ?>
                                                                    <div class="badges-list">
                                                                        <?= $badge ?>
                                                                    </div>
                                                                </dd>
                                                                <dt class="col-4 text-muted mb-3">Retensi Arsip</dt>
                                                                <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                                <dd class="col-7 text-bold mb-3"><strong><?= $d['retensi_arsip'] ?? '-' ?></strong></dd>
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
    document.addEventListener("DOMContentLoaded", function() {
        new DataTable('#dipTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            stateSave: true,

            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
            }
        });

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
                text: <?= json_encode($_SESSION['flash']['message']) ?>,
                timer: 1000
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . "/../layouts/admin.php";
