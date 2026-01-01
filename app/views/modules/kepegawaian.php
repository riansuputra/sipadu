<?php
$title = "Dashboard";
$currentPage = $_GET['page'] ?? '';

$model = new ModuleModel($pdo);
$user  = currentUser();
$role  = currentRole();

// Semua module aktif → card selalu tampil
// $modules = $model->getAllActiveModules();
$modules = $model->getVisibleModulesByRoleCode($role);

// echo '<pre>';
// print_r($model);
// print_r($user);
// print_r($role);
// print_r($modules);
// echo '</pre>';

ob_start();
?>
<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <!-- BEGIN NAVBAR LOGO -->
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3 ms-2">
            <a href="<?= BASE_URL ?>/?page=dashboard" class="btn btn-icon mb-0 btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
            </a>
        </div>
        <div class="col text-center">
            <div><?= htmlspecialchars($user['nama']) ?></div>
            <div class="mt-1 small text-secondary"><?= htmlspecialchars($_SESSION['user']['group_type']) ?> <?= htmlspecialchars($_SESSION['user']['group_name']) ?></div>
        </div>
        <!-- END NAVBAR LOGO -->
        <div class="navbar-nav flex-row order-md-last me-2">
            <div class="nav-item dropdown">
                <a href="<?= BASE_URL ?>/?page=logout" class="btn btn-icon mb-0 btn-danger" data-bs-toggle="tooltip" data-bs-placement="left" title="Keluar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                        <path d="M15 12h-12l3 -3" />
                        <path d="M6 15l-3 -3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>
<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">



        <div class="row row-cards">
            <div class="col-12 ms-2 mb-0">
                <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="#">Data Kepegawaian</a>
                    </li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">
                                    <h3 class="card-title mb-0">Tabel Pegawai</h3>
                                    <p class="text-secondary m-0">Daftar Pegawai BPMP Provinsi Bali.</p>
                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">
                                                <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </span>
                                            <input id="advanced-table-search" type="text" class="form-control" autocomplete="off">
                                        </div>
                                        <a href="#" class="btn btn-icon" aria-label="Button">
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/dots -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                            </svg>
                                        </a>
                                        <div class="dropdown">
                                            <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Download</a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Third action</a>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-0"> Button </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="advanced-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-no">No</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-nama">Nama</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-nip">NIP</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-jabatan">Jabatan</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-gol">Gol/Pangkat</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-status">Status</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-mb">Masa Bakti Tersisa</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-aksi">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        <tr>
                                            <td class="sort-no text-center">
                                                1
                                            </td>
                                            <td class="sort-nama">
                                                I Made Rian Suputra, S.Kom
                                            </td>
                                            <td class="sort-nip">200203052026061002</td>
                                            <td class="sort-jabatan">Analis Kepegawaian Ahli Muda</td>
                                            <td class="sort-gol">III/c-Penata</td>
                                            <td class="sort-status">
                                                <span class="badge bg-success-lt">Aktif</span>
                                            </td>
                                            <td class="sort-mb">37 thn 5 bln</td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#"> Action </a>
                                                        <a class="dropdown-item" href="#"> Another action </a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sort-no text-center">
                                                2
                                            </td>
                                            <td class="sort-nama">
                                                I Made Rian Suputra, S.Kom
                                            </td>
                                            <td class="sort-nip">200203052026061002</td>
                                            <td class="sort-jabatan">Analis Kepegawaian Ahli Muda</td>
                                            <td class="sort-gol">III/c-Penata</td>
                                            <td class="sort-status">
                                                <span class="badge bg-success-lt">Aktif</span>
                                            </td>
                                            <td class="sort-mb">37 thn 5 bln</td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#"> Action </a>
                                                        <a class="dropdown-item" href="#"> Another action </a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sort-no text-center">
                                                3
                                            </td>
                                            <td class="sort-nama">
                                                I Made Rian Suputra, S.Kom
                                            </td>
                                            <td class="sort-nip">200203052026061002</td>
                                            <td class="sort-jabatan">Analis Kepegawaian Ahli Muda</td>
                                            <td class="sort-gol">III/c-Penata</td>
                                            <td class="sort-status">
                                                <span class="badge bg-success-lt">Aktif</span>
                                            </td>
                                            <td class="sort-mb">37 thn 5 bln</td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#"> Action </a>
                                                        <a class="dropdown-item" href="#"> Another action </a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sort-no text-center">
                                                4
                                            </td>
                                            <td class="sort-nama">
                                                I Made Rian Suputra, S.Kom
                                            </td>
                                            <td class="sort-nip">200203052026061002</td>
                                            <td class="sort-jabatan">Analis Kepegawaian Ahli Muda</td>
                                            <td class="sort-gol">III/c-Penata</td>
                                            <td class="sort-status">
                                                <span class="badge bg-success-lt">Aktif</span>
                                            </td>
                                            <td class="sort-mb">37 thn 5 bln</td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#"> Action </a>
                                                        <a class="dropdown-item" href="#"> Another action </a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sort-no text-center">
                                                5
                                            </td>
                                            <td class="sort-nama">
                                                I Made Rian Suputra, S.Kom
                                            </td>
                                            <td class="sort-nip">200203052026061002</td>
                                            <td class="sort-jabatan">Analis Kepegawaian Ahli Muda</td>
                                            <td class="sort-gol">III/c-Penata</td>
                                            <td class="sort-status">
                                                <span class="badge bg-success-lt">Aktif</span>
                                            </td>
                                            <td class="sort-mb">37 thn 5 bln</td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#"> Action </a>
                                                        <a class="dropdown-item" href="#"> Another action </a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sort-no text-center">
                                                6
                                            </td>
                                            <td class="sort-nama">
                                                I Made Rian Suputra, S.Kom
                                            </td>
                                            <td class="sort-nip">200203052026061002</td>
                                            <td class="sort-jabatan">Analis Kepegawaian Ahli Muda</td>
                                            <td class="sort-gol">III/c-Penata</td>
                                            <td class="sort-status">
                                                <span class="badge bg-success-lt">Aktif</span>
                                            </td>
                                            <td class="sort-mb">37 thn 5 bln</td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#"> Action </a>
                                                        <a class="dropdown-item" href="#"> Another action </a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <div class="dropdown">
                                    <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                                        <span id="page-count" class="me-1">20</span>
                                        <span>records</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100 records</a>
                                    </div>
                                </div>
                                <ul class="pagination m-0 ms-auto">
                                    <li class="page-item active"><a class="page-link cursor-pointer" data-i="1" data-page="20">1</a></li>
                                    <li class="page-item"><a class="page-link cursor-pointer" data-i="2" data-page="20">2</a></li>
                                    <li class="page-item disabled"><a class="page-link cursor-pointer">...</a></li>
                                    <li class="page-item"><a class="page-link cursor-pointer" data-i="7" data-page="20">7</a></li>
                                </ul>
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
                $(document).ready(function() {
                    $('#togglePassword').click(function() {
                        var passwordInput = $('#password');
                        if (passwordInput.attr('type') === 'password') {
                            passwordInput.attr('type', 'text');
                        } else {
                            passwordInput.attr('type', 'password');
                        }
                    });
                });
            </script>
            <script>
                const advancedTable = {
                    headers: [{
                            "data-sort": "sort-no",
                            name: "No"
                        },
                        {
                            "data-sort": "sort-nama",
                            name: "Nama"
                        },
                        {
                            "data-sort": "sort-nip",
                            name: "NIP"
                        },
                        {
                            "data-sort": "sort-jabatan",
                            name: "Jabatan"
                        },
                        {
                            "data-sort": "sort-gol",
                            name: "Gol/Pangkat"
                        },
                        {
                            "data-sort": "sort-status",
                            name: "Status"
                        },
                        {
                            "data-sort": "sort-mb",
                            name: "Masa Bakti Tersisa"
                        },
                        {
                            "data-sort": "sort-aksi",
                            name: "Aksi"
                        },
                    ],
                };
                const setPageListItems = (e) => {
                    window.tabler_list["advanced-table"].page = parseInt(e.target.dataset.value);
                    window.tabler_list["advanced-table"].update();
                    document.querySelector("#page-count").innerHTML = e.target.dataset.value;
                };
                window.tabler_list = window.tabler_list || {};
                document.addEventListener("DOMContentLoaded", function() {
                    const list = (window.tabler_list["advanced-table"] = new List("advanced-table", {
                        sortClass: "table-sort",
                        listClass: "table-tbody",
                        page: parseInt("20"),
                        pagination: {
                            item: (value) => {
                                return `<li class="page-item"><a class="page-link cursor-pointer">${value.page}</a></li>`;
                            },
                            innerWindow: 1,
                            outerWindow: 1,
                            left: 0,
                            right: 0,
                        },
                        valueNames: advancedTable.headers.map((header) => header["data-sort"]),
                    }));
                    const searchInput = document.querySelector("#advanced-table-search");
                    if (searchInput) {
                        searchInput.addEventListener("input", () => {
                            list.search(searchInput.value);
                        });
                    }
                });
            </script>

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
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
