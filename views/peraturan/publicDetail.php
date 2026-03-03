<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Detail Peraturan";
$bannerTitle = "Detail Peraturan";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// echo '<pre>';
// print_r($data);
// print_r($files);
// echo '</pre>';

// Mulai buffer konten
ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">



        <div class="row row-cards">
            <div class="col-12 mb-0">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=dashboard') ?>" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=peraturan-publik') ?>" class="h3 mb-0">
                                    Peraturan
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="tests" class="h3 mb-0">
                                    Detail Peraturan
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h1 class="card-title h2"><?= htmlspecialchars($data['judul']) ?></h1>
                            <div class="mt-1 list-inline list-inline-dots mb-0 text-secondary">
                                <div class="list-inline-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                        <path d="M7 14h.013" />
                                        <path d="M10.01 14h.005" />
                                        <path d="M13.01 14h.005" />
                                        <path d="M16.015 14h.005" />
                                        <path d="M13.015 17h.005" />
                                        <path d="M7.01 17h.005" />
                                        <path d="M10.01 17h.005" />
                                    </svg>
                                    <?= $data['tahun_terbit'] ?>
                                </div>
                                <div class="list-inline-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    <?= $data['jumlah_dilihat'] ?>
                                </div>
                                <div class="list-inline-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 15v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                        <path d="M7 11l5 5l5 -5"></path>
                                        <path d="M12 4l0 12"></path>
                                    </svg>
                                    <?= $data['jumlah_unduhan'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-4 text-muted mb-3">Judul</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['judul'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Lembaga Penerbit</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['lembaga'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Nomor</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['nomor'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Tahun</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['tahun_terbit'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Jenis</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['jenis'] ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Singkatan Jenis</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['kode_jenis'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Tempat Penetapan</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['tempat_penetapan'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted mb-3">Penandatangan</dt>
                            <dt class="col-1 mb-3 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold mb-3"><strong><?= $data['penandatangan'] ?? '-' ?></strong></dd>
                            <dt class="col-4 text-muted">File</dt>
                            <dt class="col-1 col-auto text-end">:</dt>
                            <dd class="col-7 text-bold">
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
                                        <a href="<?= url('?page=peraturan-file&file=' . $fid . '&id=' . $data['id']) ?>" class="icon icon-sm text-end mt-0" aria-label="Button" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
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
    </div>
</div>

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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
