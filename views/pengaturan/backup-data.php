<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Backup Data";


// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Pengaturan</div>
                <h2 class="page-title">Backup Data</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Backup</h3>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">

                            <?php if ($_SESSION['user']['role_id'] === '1'): ?>

                                <div class="col-md-6 col-xl-3">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="font-weight-medium">Backup Database</div>
                                                    <div class="text-secondary">Ekspor dan download database</div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="bg-green text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 6a8 3 0 1 0 16 0a8 3 0 1 0 -16 0" />
                                                            <path d="M4 6v6a8 3 0 0 0 16 0v-6" />
                                                            <path d="M4 12v6a8 3 0 0 0 16 0v-6" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="font-weight-medium">Backup Dokumen</div>
                                                    <div class="text-secondary">Download semua file dokumen</div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="bg-blue text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-file-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 2l.117 .007a1 1 0 0 1 .876 .876l.007 .117v4l.005 .15a2 2 0 0 0 1.838 1.844l.157 .006h4l.117 .007a1 1 0 0 1 .876 .876l.007 .117v9a3 3 0 0 1 -2.824 2.995l-.176 .005h-10a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-14a3 3 0 0 1 2.824 -2.995l.176 -.005zm0 8a1 1 0 0 0 -1 1v3.585l-.793 -.792a1 1 0 0 0 -1.32 -.083l-.094 .083a1 1 0 0 0 0 1.414l2.5 2.5l.044 .042l.068 .055l.11 .071l.114 .054l.105 .035l.15 .03l.116 .006l.117 -.007l.117 -.02l.108 -.033l.081 -.034l.098 -.052l.092 -.064l.094 -.083l2.5 -2.5a1 1 0 0 0 0 -1.414l-.094 -.083a1 1 0 0 0 -1.32 .083l-.793 .791v-3.584a1 1 0 0 0 -.883 -.993zm2.999 -7.001l4.001 4.001h-4z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            <?php endif; ?>
                            <div class="col-md-6 col-xl-3">
                                <a class="card card-link" href="#">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="font-weight-medium">Arsip</div>
                                                <div class="text-secondary">Backup data Arsip</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="bg-red text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-files">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                                        <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2" />
                                                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <a class="card card-link" href="#">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="font-weight-medium">Publikasi</div>
                                                <div class="text-secondary">Backup data Publikasi</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="bg-yellow text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-tv-old">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -9" />
                                                        <path d="M16 3l-4 4l-4 -4" />
                                                        <path d="M15 7v13" />
                                                        <path d="M18 15v.01" />
                                                        <path d="M18 12v.01" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
require __DIR__ . '/../layouts/admin.php';
