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
// dd($kepegawaian);
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
/** @var array $arsiparis */
/** @var array $publikasi_chart */
/** @var array $kepegawaian['gender_chart'] */
/** @var array $publikasi_pokja_chart */
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">SIPADU</div>
                <h2 class="page-title">Dashboard Kepegawaian</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-sm-6 col-lg-4">
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
                    <div class="col-sm-6 col-lg-4">
                        <div class="card bg-green text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-off">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">Pensiun Tahun Ini</div>
                                </div>
                                <div class="h1 m-0"><?= array_sum($kepegawaian['pensiun'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=pegawai-pensiun') ?>" class="btn btn-light btn-sm ms-auto text-dark">Cek Pensiun -></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card bg-teal text-white">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-white text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-percentage">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M16 17a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M6 7a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M6 18l12 -12" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white h3 m-0">Rata-Rata Umur</div>
                                </div>
                                <div class="h1 m-0"><?= htmlspecialchars($kepegawaian['rata_umur'] ?? '-') ?></div>
                                <div class="d-flex">
                                    <div></div>
                                    <a href="<?= url('?page=tambah-dip') ?>" class="">&nbsp;</a>
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
                            <h3 class="card-title">Komposisi Gender</h3>
                        </div>
                        <div id="chart-gender" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>



            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Komposisi Pendidikan</h3>
                        </div>
                        <div id="chart-pendidikan" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Komposisi Pegawai Aktif</h3>
                        </div>
                        <div id="chart-pegawai" class="position-relative" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Komposisi Gol/Ruang</h3>
                        </div>
                        <div id="chart-golongan" class="position-relative" style="min-height: 240px;"></div>
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

        const generateColors = (length) => {
            let colors = [];

            for (let i = 0; i < length; i++) {
                let opacity = 100 - (i * (60 / length));
                // dari 100% turun ke ~40%

                colors.push(`color-mix(in srgb, transparent, var(--tblr-primary) ${opacity}%)`);
            }

            return colors;
        };

        const labels = <?= json_encode($kepegawaian['golongan_chart']['labels']) ?>;
        const data = <?= json_encode($kepegawaian['golongan_chart']['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-golongan"), {
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
                colors: generateColors(data.length),
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true
                                },
                                value: {
                                    show: true,
                                    formatter: function(val) {
                                        return val + " pegawai";
                                    }
                                },
                                total: {
                                    show: false // 🔥 matikan total default
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
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const generateColors = (length) => {
            let colors = [];

            for (let i = 0; i < length; i++) {
                let opacity = 100 - (i * (60 / length));
                // dari 100% turun ke ~40%

                colors.push(`color-mix(in srgb, transparent, var(--tblr-success) ${opacity}%)`);
            }

            return colors;
        };

        const labels = <?= json_encode($kepegawaian['gender_chart']['labels']) ?>;
        const data = <?= json_encode($kepegawaian['gender_chart']['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-gender"), {
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
                colors: generateColors(data.length),
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true
                                },
                                value: {
                                    show: true,
                                    formatter: function(val) {
                                        return val + " pegawai";
                                    }
                                },
                                total: {
                                    show: false // 🔥 matikan total default
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
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const generateColors = (length) => {
            let colors = [];

            for (let i = 0; i < length; i++) {
                let opacity = 100 - (i * (60 / length));
                // dari 100% turun ke ~40%

                colors.push(`color-mix(in srgb, transparent, var(--tblr-danger) ${opacity}%)`);
            }

            return colors;
        };

        const labels = <?= json_encode($kepegawaian['pendidikan_chart']['labels']) ?>;
        const data = <?= json_encode($kepegawaian['pendidikan_chart']['data']) ?>;

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-pendidikan"), {
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
                colors: generateColors(data.length),
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true
                                },
                                value: {
                                    show: true,
                                    formatter: function(val) {
                                        return val + " pegawai";
                                    }
                                },
                                total: {
                                    show: false // 🔥 matikan total default
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
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const generateColors = (length) => {
            let colors = [];

            for (let i = 0; i < length; i++) {
                let opacity = 100 - (i * (60 / length));
                // dari 100% turun ke ~40%

                colors.push(`color-mix(in srgb, transparent, var(--tblr-purple) ${opacity}%)`);
            }

            return colors;
        };

        const labels = <?= json_encode($kepegawaian['komposisi_chart']['labels']) ?>;
        const data = <?= json_encode($kepegawaian['komposisi_chart']['data']) ?>;

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
                colors: generateColors(data.length),
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true
                                },
                                value: {
                                    show: true,
                                    formatter: function(val) {
                                        return val + " pegawai";
                                    }
                                },
                                total: {
                                    show: false // 🔥 matikan total default
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
