<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "PAUD";

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
            <div class="col-12 ms-2 mb-0">
                <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="#">Paud</a>
                    </li>
                </ol>
            </div>


            <div class="col-sm-6 col-lg-3 p-3">
                <a href="<?= BASE_URL ?>/?page=publikasi-paud"
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/img-template.jpg')">
                    </div>

                    <div class="card-body text-center mb-0">
                        Publikasi
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 p-3">
                <a href=""
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/img-template.jpg')">
                    </div>

                    <div class="card-body text-center mb-0">
                        Test
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 p-3">
                <a href=""
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/img-template.jpg')">
                    </div>

                    <div class="card-body text-center mb-0">
                        Test
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 p-3">
                <a href=""
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/img-template.jpg')">
                    </div>

                    <div class="card-body text-center mb-0">
                        Test
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 p-3">
                <a href=""
                    class="card card-link card-link-pop">

                    <div class="img-responsive img-responsive-21x9 card-img-top"
                        style="background-image: url('public/assets/img/img-template.jpg')">
                    </div>

                    <div class="card-body text-center mb-0">
                        Test
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
