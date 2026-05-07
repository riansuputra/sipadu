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
// dd($timker);
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
/** @var array $jenis_informasi_chart */
/** @var array $arsiparis */
/** @var array $pegawai_chart */
/** @var array $publikasi_pokja_chart */
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">SIPADU</div>
                <h2 class="page-title">Dashboard</h2>
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
                                    <div class="text-white h4 m-0">Total Publikasi</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($timker['total_publikasi'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=publikasi') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Publikasi -></a>
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
                                    <div class="text-white h4 m-0">Publikasi Terpublish</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($timker['terpublikasi'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=tambah-publikasi') ?>" class="btn btn-light btn-sm ms-auto text-dark">Tambah Publikasi +</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-lime text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-chart">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                        <path d="M12 10v4h4" />
                                        <path d="M8 14a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h4 m-0">Total File</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($timker['total_file'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=tambah-dip') ?>" class="">&nbsp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-green text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-cog">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
                                        <path d="M4 6v6c0 1.657 3.582 3 8 3c.21 0 .42 -.003 .626 -.01" />
                                        <path d="M20 11.5v-5.5" />
                                        <path d="M4 12v6c0 1.657 3.582 3 8 3" />
                                        <path d="M17.001 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M19.001 15.5v1.5" />
                                        <path d="M19.001 21v1.5" />
                                        <path d="M22.032 17.25l-1.299 .75" />
                                        <path d="M17.27 20l-1.3 .75" />
                                        <path d="M15.97 17.25l1.3 .75" />
                                        <path d="M20.733 20l1.3 .75" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h4 m-0">Total Size</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($timker['size_publikasi'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=tambah-dip') ?>" class="">&nbsp</a>
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
                            <h3 class="card-title">Statistik Publikasi</h3>
                            <div class="ms-auto mb-3 text-muted">
                                <?= date('Y') ?>
                            </div>
                        </div>
                        <div id="chart-dip" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Publikasi Per Jenis</h3>
                            <div class="ms-auto mb-3 text-muted">
                                <?= date('Y') ?>
                            </div>
                        </div>
                        <div id="chart-jenis" class="position-relative" style="min-height: 240px;"></div>
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
        const labels = <?= json_encode($timker['publikasi_chart']['labels']) ?>;
        const data = <?= json_encode($timker['publikasi_chart']['data']) ?>;

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

        const generateColors = (length) => {
            let colors = [];

            for (let i = 0; i < length; i++) {
                let opacity = 100 - (i * (60 / length));
                // dari 100% turun ke ~40%

                colors.push(`color-mix(in srgb, transparent, var(--tblr-primary) ${opacity}%)`);
            }

            return colors;
        };

        const labels = <?= json_encode($timker['publikasi_jenis']['labels']) ?>;
        const data = <?= json_encode($timker['publikasi_jenis']['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-jenis"), {
                chart: {
                    type: "donut",
                    fontFamily: "inherit",
                    height: 240,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                series: data,
                labels: labels,
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function(val) {
                            return val + "";
                        }
                    }
                },
                colors: generateColors(data.length),
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: "Total",
                                    formatter: function() {
                                        return data.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: "right",
                    offsetY: 12,
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 100,
                    },
                    itemMargin: {
                        horizontal: 8,
                        vertical: 8,
                    },
                },
            }).render();
    });
</script>



<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
