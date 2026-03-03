<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Peraturan";


// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($data);
// print_r($modelJenis);
// foreach ($data as $dt => $d):
//     if ($d['files']) {

//         $files = explode('##', $d['files']);

//         foreach ($files as $f) {

//             list($id, $nama, $path) = explode('|', $f);

//             echo "<a href='$path'>$nama</a><br>";
//         }
//     }

// endforeach;

echo '</pre>';
$tahun = $_GET['tahun'] ?? null;
$jenis = $_GET['jenis'] ?? null;

$deskripsi = 'Menampilkan seluruh data';

if ($tahun || $jenis) {

    $parts = [];

    if ($tahun) {
        $parts[] = "tahun '<strong>" . htmlspecialchars($tahun) . "</strong>'";
    }

    if ($jenis) {
        $parts[] = "jenis peraturan '<strong>" . htmlspecialchars(ucwords(strtolower($jenis))) . "</strong>'";
    }

    $deskripsi = 'Filter data peraturan ' . implode(' dan ', $parts);
}
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Peraturan</div>
                <h2 class="page-title">Daftar Peraturan</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= url('?page=tambah-peraturan') ?>" class="btn btn-primary btn-5 d-none d-sm-inline-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah Peraturan
                    </a>
                    <a href="<?= url('?page=tambah-peraturan') ?>" class="btn btn-primary btn-6 d-sm-none btn-icon">

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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="peraturanTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Judul</th>
                                        <th class="w-1">Nomor</th>
                                        <th class="w-1">Tahun Terbit</th>
                                        <th>Jenis</th>
                                        <th>File</th>
                                        <th class="w-1">Aksi</th>
                                    </tr>
                                    <tr id="filterRow">
                                        <th></th>
                                        <th><input type="text" placeholder="Cari judul..." class="form-control w-100 h5 m-0"></th>
                                        <th><input type="text" placeholder="Nomor..." class="form-control w-100 h5 m-0"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($data as $dt => $d): ?>
                                        <tr>
                                            <td class=" text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['judul'] ?? '-') ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['nomor'] ?? '-') ?>
                                            </td>
                                            <td class=" text-center">
                                                <?= htmlspecialchars($d['tahun_terbit'] ?? '-') ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['kode_jenis'] ?? '-') ?>
                                            </td>

                                            <td class="">
                                                <div class="btn-group">

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

                                                    $maxShow = 2;
                                                    $totalFile = count($listFile);
                                                    $showFiles = array_slice($listFile, 0, $maxShow);

                                                    // tampilkan
                                                    foreach ($showFiles as $f):
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
                                                    <?php endforeach; ?>

                                                    <?php if ($totalFile > $maxShow): ?>
                                                        <span class="more-files mt-1" title="<?= $totalFile ?> file">
                                                            +<?= $totalFile - $maxShow ?>
                                                        </span>
                                                    <?php endif; ?>
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
                                                    <a href="<?= url('?page=edit-peraturan&id=' . $d["id"]) ?>" class="text-yellow me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <a class="text-red"
                                                        onclick="confirmDelete(
                                                                '<?= url('?page=peraturan-delete') ?>',
                                                                '<?= $d['id'] ?>'
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

                                        <div class="modal modal-blur fade" id="modal-detail-<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Detail Peraturan</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <dl class="row">
                                                            <dt class="col-4 text-muted mb-3">Judul</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['judul'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Lembaga Penerbit</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['lembaga'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Nomor</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['nomor'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Tahun</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong>Tahun <?= $d['tahun_terbit'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Jenis</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['jenis'] ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Singkatan Jenis</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['kode_jenis'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Tempat Penetapan</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['tempat_penetapan'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Penandatangan</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['penandatangan'] ?? '-' ?></strong></dd>
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
                                                                        <a href="<?= url('?page=peraturan-file&file=' . $fid . '&id=' . $d['id']) ?>" class="icon icon-sm text-end mt-0" aria-label="Button" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#peraturanTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,
            layout: {
                topStart: {
                    pageLength: {},
                    div: {
                        html: `
                        <a href="<?= url('?page=peraturan') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                            </svg>
                        </a>
                        `
                    }
                },
                topEnd: 'search'
            },

            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Tidak ada data",
            },

            initComplete: function() {
                const api = this.api();

                // =============================
                // TEXT SEARCH - NAMA INFORMASI
                // =============================
                const namaInput = document.querySelector("#filterRow th:nth-child(2) input");
                const nomorInput = document.querySelector("#filterRow th:nth-child(3) input");

                namaInput.addEventListener("keyup", function() {
                    api.column(1).search(this.value).draw();
                });

                nomorInput.addEventListener("keyup", function() {
                    api.column(2).search(this.value).draw();
                });

                // =============================
                // HELPER BUAT DROPDOWN FILTER
                // =============================
                function createSelectFilter(colIndex, labelMap = null) {

                    const column = api.column(colIndex);
                    const cell = document.querySelector(
                        "#filterRow th:nth-child(" + (colIndex + 1) + ")"
                    );

                    const select = document.createElement("select");
                    select.className = "form-select h5 w-auto m-0";
                    select.innerHTML = `<option value="">Semua</option>`;
                    cell.appendChild(select);

                    const uniqueValues = new Set();

                    // ambil value dari data-search attribute
                    column.nodes().each(function(node) {
                        const val = node.getAttribute("data-search") || node.textContent.trim();
                        if (val) uniqueValues.add(val);
                    });

                    Array.from(uniqueValues).sort().forEach(function(val) {

                        const label = labelMap && labelMap[val] ?
                            labelMap[val] :
                            val;

                        select.innerHTML += `<option value="${val}">${label}</option>`;
                    });

                    select.addEventListener("change", function() {
                        const value = this.value;

                        column.search(
                            value ? '^' + value + '$' : '',
                            true, // regex
                            false // smart search off
                        ).draw();
                    });
                }

                // =============================
                // MAPPING LABEL BENTUK
                // =============================
                const bentukMap = {
                    'hardcopy': 'Hardcopy',
                    'softcopy': 'Softcopy',
                    'hardcopy_softcopy': 'HC + SC'
                };

                const jenisMap = {
                    'berkala': 'Berkala',
                    'serta_merta': 'Serta Merta',
                    'setiap_saat': 'Setiap Saat',
                    'dikecualikan': 'Dikecualikan'
                };

                // =============================
                // PASANG FILTER SELECT
                // =============================
                createSelectFilter(3, jenisMap); // Jenis Informasi
                createSelectFilter(4); // Retensi

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
    function confirmDelete(url, id, label = '') {

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {

            if (result.isConfirmed) {

                // buat form POST dinamis
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
            timer: 5000;

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
                timer: 1000,
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
