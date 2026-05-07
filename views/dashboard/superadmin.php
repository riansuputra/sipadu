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
// dd($user);
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
/** @var array $arsip_chart */
/** @var array $publikasi_chart */
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
                                    <div class="text-white h3 m-0">Total Arsip</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($card['total_arsip'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=arsip') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Arsip -></a>
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
                                    <div class="text-white h3 m-0">Total Publikasi</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($card['total_publikasi'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=publikasi') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Publikasi -></a>
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
                                <div class="h1 m-0"><?= htmlspecialchars($card['total_peraturan'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=peraturan') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Peraturan -></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card bg-lime text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">Total Pegawai</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($card['total_pegawai'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=pegawai') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Pegawai -></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Statistik Arsip</h3>
                            <div class="ms-auto mb-3 text-muted">
                                <?= date('Y') ?>
                            </div>
                        </div>
                        <div id="chart-arsip" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Statistik Publikasi</h3>
                            <div class="ms-auto mb-3 text-muted">
                                <?= date('Y') ?>
                            </div>
                        </div>
                        <div id="chart-publikasi" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Komposisi Pegawai Aktif</h3>
                        </div>
                        <div id="chart-pegawai" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aktivitas Sistem</h3>
                    </div>
                    <div class="card-body pt-0 pb-0">
                        <table id="logTable" class="table table-vcenter table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($logs)): ?>
                                    <?php foreach ($logs as $log): ?>
                                        <tr>
                                            <td title="<?= date('d M Y H:i', strtotime($log['created_at'])) ?>">
                                                <?= timeAgo($log['created_at']) ?>
                                            </td>
                                            <td>
                                                <?= $log['username'] ?? '-' ?>
                                            </td>
                                            <td>
                                                <?= $log['description'] ?? '-' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada aktivitas
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Komposisi Publikasi</h3>
                            <div class="ms-auto mb-3 text-muted">
                                <?= date('Y') ?>
                            </div>
                        </div>
                        <div id="chart-komposisi-publikasi" class="position-relative" style="min-height: 240px;"></div>
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
        const labels = <?= json_encode($arsip_chart['labels']) ?>;
        const data = <?= json_encode($arsip_chart['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-arsip"), {
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
                    name: "Jumlah Arsip",
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

        const labels = <?= json_encode($publikasi_chart['labels']) ?>;
        const data = <?= json_encode($publikasi_chart['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-publikasi"), {
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
                    name: "Jumlah Publikasi",
                    data: data,
                }, ],
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function(val) {
                            return val + " publikasi";
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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const labels = <?= json_encode($pegawai_chart['labels']) ?>;
        const data = <?= json_encode($pegawai_chart['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-pegawai"), {
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
                            return val + " pegawai";
                        }
                    }
                },
                colors: [
                    "color-mix(in srgb, transparent, var(--tblr-primary) 100%)", // PNS
                    "color-mix(in srgb, transparent, var(--tblr-primary) 70%)", // PPPK
                    "color-mix(in srgb, transparent, var(--tblr-primary) 40%)", // Outsourcing
                ],
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
                    position: "bottom",
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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const labels = <?= json_encode($publikasi_pokja_chart['labels']) ?>;
        const data = <?= json_encode($publikasi_pokja_chart['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-komposisi-publikasi"), {
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
                        barHeight: "50%",
                        horizontal: true, // 🔥 penting
                        borderRadius: 4,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: "Jumlah Publikasi",
                    data: data,
                }, ],
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function(val) {
                            return val + " publikasi";
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
                    type: "category", // 🔥 bukan datetime
                    labels: {
                        padding: 0,
                        formatter: function(val) {
                            return val.toFixed(0); // 🔥 no decimal
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                },
                yaxis: {
                    labels: {
                        padding: 4,
                    },
                },
                labels: labels,
                colors: ["color-mix(in srgb, transparent, var(--tblr-primary) 100%)"],
                legend: {
                    show: false
                },
            }).render();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#logTable', {
            pageLength: 10,
            orderCellsTop: true,

            searching: false, // ❌ hilangkan search
            paging: false, // ❌ hilangkan pagination
            info: false, // ❌ hilangkan "Showing 1 to X"
            lengthChange: false, // ❌ hilangkan dropdown 10, 20, dll
        });

    });
</script>



<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
