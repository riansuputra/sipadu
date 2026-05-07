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
// dd($_SESSION['user']);
// dd($arsiparis);
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
/** @var array $arsiparis */
/** @var array $publikasi_chart */
/** @var array $pegawai_chart */
/** @var array $publikasi_pokja_chart */
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">SIPADU</div>
                <h2 class="page-title">Dashboard Arsiparis</h2>
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

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-files">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2" />
                                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">Total DIP</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($arsiparis['total_dip'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=dip') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek DIP -></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-green text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-analytics">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                        <path d="M9 17l0 -5" />
                                        <path d="M12 17l0 -1" />
                                        <path d="M15 17l0 -3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">Total Peraturan</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($arsiparis['total_peraturan'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=peraturan') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Peraturan -></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-teal text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-tv-old">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -9" />
                                        <path d="M16 3l-4 4l-4 -4" />
                                        <path d="M15 7v13" />
                                        <path d="M18 15v.01" />
                                        <path d="M18 12v.01" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">DIP Size</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($arsiparis['size_dip'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=tambah-dip') ?>" class="">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-lime text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-invoice">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                        <path d="M9 7l1 0" />
                                        <path d="M9 13l6 0" />
                                        <path d="M13 17l2 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">Peraturan Size</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($arsiparis['size_peraturan'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=tambah-peraturan') ?>" class="">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Statistik DIP</h3>

                        </div>
                        <div id="chart-dip" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Statistik Peraturan</h3>

                        </div>
                        <div id="chart-peraturan" class="position-relative" style="min-height: 240px;"></div>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = <?= json_encode($arsiparis['dip_chart']['labels']) ?>;
        const data = <?= json_encode($arsiparis['dip_chart']['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-dip"), {
                chart: {
                    type: "area",
                    fontFamily: "inherit",
                    height: 240,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    colors: ["color-mix(in srgb, transparent, var(--tblr-primary) 16%)", "color-mix(in srgb, transparent, var(--tblr-primary) 16%)"],
                    type: "solid",
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "Jumlah DIP",
                    data: data,
                }, ],
                tooltip: {
                    theme: "dark",
                },
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: 0,
                        bottom: -4,
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: "category",
                },
                yaxis: {
                    min: 0,
                    decimalsInFloat: 0,
                    labels: {
                        formatter: val => val.toFixed(0)
                    }
                },
                labels: labels,
                colors: ["color-mix(in srgb, transparent, var(--tblr-primary) 100%)"],
                legend: {
                    show: false,
                },
            }).render();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const labels = <?= json_encode($arsiparis['peraturan_chart']['labels']) ?>;
        const data = <?= json_encode($arsiparis['peraturan_chart']['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-peraturan"), {
                chart: {
                    type: "bar",
                    fontFamily: "inherit",
                    height: 240,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: false
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                        borderRadius: 4,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: "Jumlah Peraturan",
                    data: data,
                }, ],
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function(val) {
                            return val + "";
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: 0,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    type: "category", // 🔥 karena label sudah "21 Apr"
                    labels: {
                        padding: 0
                    },
                    axisBorder: {
                        show: false
                    },
                },
                yaxis: {
                    min: 0,
                    decimalsInFloat: 0, // 🔥 hilangkan desimal
                    labels: {
                        padding: 4,
                        formatter: function(val) {
                            return val.toFixed(0);
                        }
                    }
                },
                labels: labels,
                colors: ["color-mix(in srgb, transparent, var(--tblr-primary) 100%)"],
                legend: {
                    show: false
                },
            }).render();
    });
</script>



<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
