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
                            <div class="mt-1 list-inline list-inline-dots mb-0 text-secondary d-sm-block d-none">
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
                        <div class="row">

                            <div class="col-sm-12">
                                <table class="table table-transparent table-responsive">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:15%">Judul</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['judul'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Lembaga Penerbit</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['lembaga'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Nomor</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['nomor'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Tahun</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['tahun_terbit'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Jenis</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['jenis'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Singkatan Jenis</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['kode'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Tempat Penetapan</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['tempat_penetapan'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Penandatangan</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold"><?= htmlspecialchars($data['penandatangan'] ?? '-') ?></td>
                                        </tr>
                                        <tr style='border-bottom:hidden;'>
                                            <td style="width:15%">File</td>
                                            <td style="width:1%">:</td>
                                            <td class="fw-bold">
                                                <?php foreach ($files as $f): ?>
                                                    <a href='<?= url($f['path_file'])  ?>' target='_blank' class="btn btn-outline-primary btn-5 mb-2">
                                                        <?= shortname($f["nama_file"], 50,) ?>
                                                    </a>
                                                    <a href="<?= url('?page=peraturan-file&file=' . $f['id'] . '&id=' . $d['id']) ?>" class="btn btn-success btn-icon btn-5 mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg>
                                                    </a>
                                                    <br>
                                                <?php endforeach; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
