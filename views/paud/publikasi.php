<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Publikasi PAUD";
$bannerTitle = "Publikasi PAUD";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// Mulai buffer konten
ob_start();
?>


<?php
$tanggalMulai   = $_GET['tanggal_mulai'] ?? null;
$tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
$jenis          = $_GET['jenis'] ?? null;

$isFiltered = !empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis);

$deskripsi = 'Menampilkan seluruh data publikasi';

if ($isFiltered) {
    $parts = [];

    if ($tanggalMulai && $tanggalSelesai) {
        $parts[] = "tanggal <strong>" . formatTanggalIndonesia($tanggalMulai) .
            "</strong> s/d <strong>" . formatTanggalIndonesia($tanggalSelesai) . "</strong>";
    } elseif ($tanggalMulai) {
        $parts[] = "mulai <strong>" . formatTanggalIndonesia($tanggalMulai) . "</strong>";
    } elseif ($tanggalSelesai) {
        $parts[] = "sampai <strong>" . formatTanggalIndonesia($tanggalSelesai) . "</strong>";
    }

    if (!empty($jenisNama)) {
        $parts[] = "jenis <strong>" . htmlspecialchars($jenisNama) . "</strong>";
    }

    $deskripsi = 'Filter data aktif: ' . implode(' dan ', $parts);
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
                                <a href="" class="h3 mb-0">
                                    Publikasi
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">

                            <form method="get">
                                <div class="row">

                                    <input type="hidden" name="page" value="publikasi-paud">

                                    <div class="col-lg-2">
                                        <label class="form-label">Tanggal Mulai : </label>
                                        <input type="date"
                                            name="tanggal_mulai"
                                            class="form-control"
                                            value="<?= htmlspecialchars($_GET['tanggal_mulai'] ?? '') ?>">
                                    </div>

                                    <div class="col-lg-2">
                                        <label class="form-label">Tanggal Selesai : </label>
                                        <input type="date"
                                            name="tanggal_selesai"
                                            class="form-control"
                                            value="<?= htmlspecialchars($_GET['tanggal_selesai'] ?? '') ?>">
                                    </div>


                                    <div class="col-auto ms-auto">
                                        <label class="form-label">&nbsp;</label>
                                        <button class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>
                                            Filter
                                        </button>
                                        <a href="<?= url('?page=publikasi-paud') ?>" class="btn btn-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
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

            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <?php if ($isFiltered): ?>
                            <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 9h.01" />
                                        <path d="M11 12h1v4h1" />
                                        <path d="M12 3a9 9 0 1 0 9 9a9 9 0 0 0 -9 -9" />
                                    </svg>
                                    <?= $deskripsi ?>
                                </div>
                                <a href="<?= url('?page=publikasi-paud') ?>" class="btn btn-sm btn-info">
                                    Reset Filter
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-muted small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 9h.01" />
                                    <path d="M11 12h1v4h1" />
                                </svg>
                                <em><?= $deskripsi ?></em>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table id="publikasiTimPaudTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th class="text-center">Judul</th>
                                        <th class="w-1 text-center">Unit/Tim</th>
                                        <th class="w-1 text-center">Status <br> Publikasi</th>
                                        <th class="w-1 text-center">Tanggal <br> Kegiatan</th>
                                        <th class="w-1 text-center">Tanggal Dibuat <br>& Diperbarui</th>
                                        <th class="w-1">File</th>
                                        <th class="w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($data as $dt => $d): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['judul'] ?? '-') ?>
                                            </td>

                                            <td class="">
                                                <?= htmlspecialchars($d['nama_tim'] ?? '-') ?>
                                            </td>
                                            <td class=" text-nowrap">
                                                <?php
                                                if ($d['is_published'] === 1) {
                                                    $bg = 'success';
                                                    $text = 'Sudah';
                                                } else {
                                                    $bg = 'secondary';
                                                    $text = 'Belum';
                                                }
                                                ?>
                                                <span class="badge bg-<?= $bg ?> me-1"></span><?= $text ?? '-' ?>
                                            </td>
                                            <td class="">
                                                <span class="badge bg-primary-lt"><?= htmlspecialchars(date('d/m/Y', strtotime($d['tanggal_kegiatan'])) ?? '-') ?></span>
                                            </td>
                                            <td class="">
                                                <span class="badge"><?= htmlspecialchars(date('d/m/Y', strtotime($d['tanggal_kegiatan'])) ?? '-') ?></span> <br> <span class="badge bg-success-lt"><?= htmlspecialchars(date('d/m/Y', strtotime($d['tanggal_kegiatan'])) ?? '-') ?></span>
                                            </td>
                                            <td class="">
                                                <div class="btn-group">
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
                                                            <dd class="col-7 text-bold mb-3"><strong><?= htmlspecialchars(date('d/m/Y', strtotime($d['tanggal_kegiatan'])) ?? '-') ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Lokasi</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong>Tahun <?= $d['lokasi'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Jenis</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['jenis'] ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Penulis</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['penulis'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Kabupaten / Kota</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><strong><?= $d['kabupaten'] ?? '-' ?></strong></dd>
                                                            <dt class="col-4 text-muted mb-3">Link Media</dt>
                                                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                                                            <dd class="col-7 text-bold mb-3"><a href="<?= empty($d['link']) ? ''  : $d['link'] ?>"><?= empty($d['link']) ? ''  : $d['link'] ?></a></dd>
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
                                                            </svg> ';
                                                                    } else if ($ext === 'jpg' || $ext === 'jpeg') {
                                                                        $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" />
                                                            </svg> ';
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
                                                            </svg> ';
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

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#publikasiTimPaudTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,
            layout: {
                topStart: {
                    pageLength: {},
                    div: {
                        html: `
                        <a href="<?= url('?page=publikasi-paud') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
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
