<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Dashboard";


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
                <!-- <div class="page-pretitle">Overview</div> -->
                <h2 class="page-title">Dashboard</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="#" class="btn btn-1"> New view </a>
                    </span>
                    <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Create new report
                    </a>
                    <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
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
                <div class="row row-cards">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-cyan text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="h1 m-0">75%</div>
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3">Sales</div>
                                </div>
                                <div class="d-flex">
                                    <div></div>
                                    <div class="ms-auto">Conversion rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-teal text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="h1 m-0">75%</div>
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3">Sales</div>
                                </div>
                                <div class="d-flex">
                                    <div></div>
                                    <div class="ms-auto">Conversion rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-green text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="h1 m-0">75%</div>
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3">Sales</div>
                                </div>
                                <div class="d-flex">
                                    <div></div>
                                    <div class="ms-auto">Conversion rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-lime text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="h1 m-0">75%</div>
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3">Sales</div>
                                </div>
                                <div class="d-flex">
                                    <div></div>
                                    <div class="ms-auto">Conversion rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shortcut Aksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6 col-xl-3">
                                <a class="card card-link" href="#">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="font-weight-medium">Kellie Skingley</div>
                                                <div class="text-secondary">Teacher</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="avatar avatar-2 rounded" style="background-image: url(./static/avatars/002f.jpg)"> </span>
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
                                                <div class="font-weight-medium">Kellie Skingley</div>
                                                <div class="text-secondary">Teacher</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="avatar avatar-2 rounded" style="background-image: url(./static/avatars/002f.jpg)"> </span>
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
                                                <div class="font-weight-medium">Kellie Skingley</div>
                                                <div class="text-secondary">Teacher</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="avatar avatar-2 rounded" style="background-image: url(./static/avatars/002f.jpg)"> </span>
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
                                                <div class="font-weight-medium">Kellie Skingley</div>
                                                <div class="text-secondary">Teacher</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="avatar avatar-2 rounded" style="background-image: url(./static/avatars/002f.jpg)"> </span>
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
