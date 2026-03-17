<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Link Aplikasi";
$bannerTitle = "Link Aplikasi";
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
                                    Link Aplikasi
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://skp.sdm.kemendikdasmen.go.id/skp/site/login.jsp"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/e-skp.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        E-SKP
                    </div>
                </a>
            </div>


            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://data-sdm.kemdikbud.go.id/login"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/sipdasmen.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        Sipdasmen
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://asndigital.bkn.go.id"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/asn-digital.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        ASN Digital
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://sippede.lpmpbali.id"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/sippede.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        SIPPeDE
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://pesona.bpmpbali.id"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/pesona.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        Pesona
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://portal.kemendikdasmen.go.id"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/portal-kemendikdasmen.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        Portal Kemendikdasmen
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 p-1">
                <a href="https://bpmpbali.kemendikdasmen.go.id"
                    target="_blank"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('<?= url('public/assets/img/bpmpbali.webp') ?>')">
                    </div>

                    <div class="card-body text-center fw-bold mb-0">
                        Laman BPMP Bali
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
