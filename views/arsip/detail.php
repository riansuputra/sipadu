<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Detail Arsip";
$bannerTitle = "Detail Arsip";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// echo '<pre>';
// dd($data, $peserta, $files, $pegawai, $jenis, $this->user, $this->role);
// dd($peserta);
// dd($files);
// dd($pegawai);
// dd($jenis);
// dd($this->user);
// dd($this->role);
// print_r($files);
// echo '</pre>';

// Mulai buffer konten

ob_start();
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Arsip</div>
                <h2 class="page-title">Detail Arsip</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">

        <?php
        $totalPeserta = count($peserta);
        $totalUpload = count(array_filter($peserta, fn($p) => ($p['status_otomatis'] ?? '') === 'bukti_diunggah'));
        $totalBelum = $totalPeserta - $totalUpload;
        ?>

        <div class="row g-3 mb-3">

            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="subheader">Total Peserta</div>
                                <div class="fs-2 fw-bold text-primary"><?= $totalPeserta ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="subheader">Sudah Upload</div>
                                <div class="fs-2 fw-bold text-success"><?= $totalUpload ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-danger text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="subheader">Belum Upload</div>
                                <div class="fs-2 fw-bold text-danger"><?= $totalBelum ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informasi Arsip</h3>
                    <div class="card-actions">
                        <a href="<?= url('?page=edit-arsip&id=' . $data["id"]) ?>" class="btn btn-yellow btn-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Edit Arsip
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="mb-3">"<?= htmlspecialchars($data['judul'] ?? '-') ?>"</h2>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small">Jenis Kegiatan :</div>
                            <div class="fw-semibold"><?= htmlspecialchars($data['jenis'] ?? '-') ?></div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Lokasi :</div>
                            <div class="fw-semibold"><?= htmlspecialchars($data['lokasi'] ?? '-') ?></div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Tanggal Mulai dan Selesai :</div>
                            <div class="fw-semibold">
                                <?= formatTanggalRange($data['tanggal_mulai'] ?? null, $data['tanggal_selesai'] ?? null) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">File :</div>
                            <?php
                            $listFile = [];

                            if (!empty($data["files"])) {
                                $files = explode("##", $data["files"],);

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
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small">Deskripsi :</div>
                            <div class="fw-semibold"><?= !empty($data['deskripsi']) ? nl2br(htmlspecialchars($data['deskripsi'])) : '-' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Informasi Peserta</h3>
                    <div class="card-actions">
                        <a href="#" class="btn btn-primary btn-3" data-bs-toggle="modal" data-bs-target="#modalTambahPeserta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                            </svg>
                            Kelola Peserta
                        </a>
                    </div>
                </div>

                <div class="modal modal-blur fade" id="modalTambahPeserta" tabindex="-1" aria-labelledby="modalTambahPesertaLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form action="?page=arsip-peserta-store" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahPesertaLabel">Tambah Peserta</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="arsip_id" value="<?= $data['id'] ?>">

                                    <?php if (!empty($pegawai)) : ?>
                                        <div class="mb-3">
                                            <input type="text" id="searchPegawai" class="form-control" placeholder="Cari nama atau NIP pegawai...">
                                        </div>

                                        <div class="d-flex gap-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-primary" id="checkAllPegawai">
                                                <i class="ti ti-checks"></i> Pilih Semua
                                            </button>

                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="uncheckAllPegawai">
                                                <i class="ti ti-square-x"></i> Batal Pilih Semua
                                            </button>
                                        </div>

                                        <div class="list-group" id="pegawaiList" style="max-height: 380px; overflow-y: auto;">
                                            <?php foreach ($pegawai as $p) : ?>
                                                <label class="list-group-item pegawai-item">
                                                    <div class="d-flex align-items-center">

                                                        <input class="form-check-input me-3 pegawai-checkbox" type="checkbox" name="pegawai_id[]" value="<?= $p['id'] ?>">
                                                        <div class="flex-fill">
                                                            <div class="fw-semibold">
                                                                <?= htmlspecialchars($p['nama'] ?? '-') ?>
                                                            </div>

                                                            <small class="text-muted d-block">
                                                                NIP: <?= htmlspecialchars($p['nip'] ?? '-') ?>
                                                            </small>

                                                            <small class="text-muted d-block">
                                                                Jabatan: <?= htmlspecialchars($p['jabatan'] ?? '-') ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="alert alert-warning mb-0">
                                            Semua pegawai sudah menjadi peserta arsip ini.
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <?php if (!empty($pegawai)) : ?>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy"></i> Simpan Peserta
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="jenisArsipTable" class="table table-vcenter table-selectable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="w-1">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center w-1">Status Upload</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                <?php foreach ($peserta as $dt => $d): ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $dt + 1 ?>
                                        </td>
                                        <td class="">
                                            <?= htmlspecialchars($d['nama'] ?? '-') ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (($d['status_otomatis'] ?? '') === 'bukti_diunggah'): ?>
                                                <span class="badge bg-success text-success-fg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                    Sudah
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-red text-red-fg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                    Belum
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group w-100">
                                                <a href="" class="text-yellow me-2" data-bs-toggle="modal" data-bs-target="#modalEditPeserta<?= $d['id'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                </a>
                                                <a type="button"
                                                    class="text-red"
                                                    onclick="confirmDeletePeserta(
                                                        '<?= url('?page=arsip-peserta-delete') ?>',
                                                        '<?= $d['id'] ?>',
                                                        '<?= $data['id'] ?>',
                                                        '<?= htmlspecialchars($d['nama'], ENT_QUOTES) ?>'
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

                                    <div class="modal fade" id="modalEditPeserta<?= $d['id'] ?>" tabindex="-1" aria-labelledby="modalEditPesertaLabel<?= $d['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <form action="<?= url('?page=arsip-peserta-update') ?>" method="POST">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditPesertaLabel<?= $d['id'] ?>">
                                                            Ganti Peserta
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <input type="hidden" name="arsip_id" value="<?= $data['id'] ?>">

                                                        <div class="mb-3">
                                                            <input
                                                                type="text"
                                                                class="form-control search-edit-pegawai"
                                                                placeholder="Cari nama / NIP / jabatan pegawai..."
                                                                data-target="pegawaiListEdit<?= $d['id'] ?>">
                                                        </div>

                                                        <div class="list-group" id="pegawaiListEdit<?= $d['id'] ?>" style="max-height: 400px; overflow-y: auto;">

                                                            <?php
                                                            // supaya peserta yang sedang dipakai tetap muncul
                                                            $pegawaiGabungan = $pegawai;

                                                            $sudahAda = false;
                                                            foreach ($pegawaiGabungan as $pg) {
                                                                if ((int)$pg['id'] === (int)$d['pegawai_id']) {
                                                                    $sudahAda = true;
                                                                    break;
                                                                }
                                                            }

                                                            if (!$sudahAda) {
                                                                $pegawaiGabungan[] = [
                                                                    'id' => $d['pegawai_id'],
                                                                    'nama' => $d['nama'],
                                                                    'nip' => $d['nip'],
                                                                    'jabatan' => $d['jabatan']
                                                                ];
                                                            }
                                                            ?>

                                                            <?php foreach ($pegawaiGabungan as $p) : ?>
                                                                <?php $checked = ((int)$p['id'] === (int)$d['pegawai_id']); ?>

                                                                <label class="list-group-item pegawai-item-edit cursor-pointer">
                                                                    <div class="d-flex align-items-center">
                                                                        <input
                                                                            class="form-check-input me-3"
                                                                            type="radio"
                                                                            name="pegawai_id"
                                                                            value="<?= $p['id'] ?>"
                                                                            <?= $checked ? 'checked' : '' ?>
                                                                            required>

                                                                        <div class="flex-fill">
                                                                            <div class="fw-semibold">
                                                                                <?= htmlspecialchars($p['nama'] ?? '-') ?>
                                                                            </div>

                                                                            <small class="text-muted d-block">
                                                                                NIP: <?= htmlspecialchars($p['nip'] ?? '-') ?>
                                                                            </small>

                                                                            <small class="text-muted d-block">
                                                                                Jabatan: <?= htmlspecialchars($p['jabatan'] ?? '-') ?>
                                                                            </small>
                                                                        </div>

                                                                        <?php if ($checked): ?>
                                                                            <i class="ti ti-check text-success fs-4"></i>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </label>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-warning">
                                                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
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

<div class="modal fade" id="modalEditPeserta<?= $d['id'] ?>" tabindex="-1" aria-labelledby="modalEditPesertaLabel<?= $d['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="<?= url('?page=update-peserta-arsip') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPesertaLabel<?= $d['id'] ?>">
                        Ganti Peserta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <input type="hidden" name="arsip_id" value="<?= $data['id'] ?>">

                    <div class="mb-3">
                        <input
                            type="text"
                            class="form-control search-edit-pegawai"
                            placeholder="Cari nama / NIP / jabatan pegawai..."
                            data-target="pegawaiListEdit<?= $d['id'] ?>">
                    </div>

                    <div class="list-group" id="pegawaiListEdit<?= $d['id'] ?>" style="max-height: 400px; overflow-y: auto;">

                        <?php
                        // supaya peserta yang sedang dipakai tetap muncul
                        $pegawaiGabungan = $pegawai;

                        $sudahAda = false;
                        foreach ($pegawaiGabungan as $pg) {
                            if ((int)$pg['id'] === (int)$d['pegawai_id']) {
                                $sudahAda = true;
                                break;
                            }
                        }

                        if (!$sudahAda) {
                            $pegawaiGabungan[] = [
                                'id' => $d['pegawai_id'],
                                'nama' => $d['nama'],
                                'nip' => $d['nip'],
                                'jabatan' => $d['jabatan']
                            ];
                        }
                        ?>

                        <?php foreach ($pegawaiGabungan as $p) : ?>
                            <?php $checked = ((int)$p['id'] === (int)$d['pegawai_id']); ?>

                            <label class="list-group-item pegawai-item-edit cursor-pointer">
                                <div class="d-flex align-items-center">
                                    <input
                                        class="form-check-input me-3"
                                        type="radio"
                                        name="pegawai_id"
                                        value="<?= $p['id'] ?>"
                                        <?= $checked ? 'checked' : '' ?>
                                        required>

                                    <div class="flex-fill">
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($p['nama'] ?? '-') ?>
                                        </div>

                                        <small class="text-muted d-block">
                                            NIP: <?= htmlspecialchars($p['nip'] ?? '-') ?>
                                        </small>

                                        <small class="text-muted d-block">
                                            Jabatan: <?= htmlspecialchars($p['jabatan'] ?? '-') ?>
                                        </small>
                                    </div>

                                    <?php if ($checked): ?>
                                        <i class="ti ti-check text-success fs-4"></i>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-device-floppy"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDeletePeserta(url, id, arsipId, label = '') {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `Peserta <strong>${label}</strong> akan dihapus dari arsip` : 'Data peserta akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;

                const inputArsip = document.createElement('input');
                inputArsip.type = 'hidden';
                inputArsip.name = 'arsip_id';
                inputArsip.value = arsipId;

                form.appendChild(inputId);
                form.appendChild(inputArsip);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchPegawai");
        const items = document.querySelectorAll(".pegawai-item");

        if (searchInput) {
            searchInput.addEventListener("keyup", function() {
                const keyword = this.value.toLowerCase();

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(keyword) ? "" : "none";
                });
            });
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#jenisArsipTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,

            language: {
                search: "Cari:",
                lengthMenu: "_MENU_ &nbsp;data",
                info: "_START_ sampai _END_ dari _TOTAL_ data",
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAllBtn = document.getElementById("checkAllPegawai");
        const uncheckAllBtn = document.getElementById("uncheckAllPegawai");

        if (checkAllBtn) {
            checkAllBtn.addEventListener("click", function() {
                document.querySelectorAll(".pegawai-checkbox").forEach(cb => {
                    if (cb.closest(".pegawai-item").style.display !== "none") {
                        cb.checked = true;
                    }
                });
            });
        }

        if (uncheckAllBtn) {
            uncheckAllBtn.addEventListener("click", function() {
                document.querySelectorAll(".pegawai-checkbox").forEach(cb => {
                    cb.checked = false;
                });
            });
        }
    });
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
