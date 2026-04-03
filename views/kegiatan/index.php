<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Kegiatan";
$bannerTitle = "Kegiatan";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// echo '<pre>';
// print_r($moduleModel);
// print_r($user);
// print_r($modules);
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
                            <li class="breadcrumb-item active">
                                <a href="tests" class="h3 mb-0">
                                    Kegiatan
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="<?= url('?page=kegiatan-paud')  ?>"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/paud.webp')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        PAUD
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="<?= url('?page=kegiatan-sd')  ?>"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/sd.webp')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        SD
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="<?= url('?page=kegiatan-smp')  ?>"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/smp.webp')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        SMP
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="<?= url('?page=kegiatan-sma')  ?>"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/sma.webp')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        SMA
                    </div>
                </a>
            </div>


        </div>
    </div>
</div>

<script>
    function noAccessAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: 'Anda tidak memiliki akses ke modul ini.',
            confirmButtonText: 'Mengerti'
        });
    }
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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
