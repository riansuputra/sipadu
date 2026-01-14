<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "DIP";


// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($data);
// echo '</pre>';
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">DIP</div>
                <h2 class="page-title">Daftar DIP</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= BASE_URL ?>/?page=tambah-dip" class="btn btn-primary btn-5 d-none d-sm-inline-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah DIP
                    </a>
                    <a href="<?= BASE_URL ?>/?page=tambah-dip" class="btn btn-primary btn-6 d-sm-none btn-icon">

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
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">
                                    <h3 class="card-title mb-0">Tabel DIP</h3>
                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </span>
                                            <input id="advanced-table-search" type="text" class="form-control" autocomplete="off">
                                        </div>
                                        <select id="filter-jenis" class="form-select w-auto">
                                            <option value="" disabled selected>-- Pilih Jenis --</option>
                                            <option value="">Semua</option>
                                            <option value="Berkala">Berkala</option>
                                            <option value="Serta Merta">Serta Merta</option>
                                            <option value="Setiap Saat">Setiap Saat</option>
                                            <option value="Dikecualikan">Dikecualikan</option>
                                        </select>

                                        <a href="#" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-history">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 8l0 4l2 2" />
                                                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
                                            </svg>
                                            Riwayat DIP
                                        </a>
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
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-judul">Judul Informasi</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-tgl">Tgl Pembuatan</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-retensi">Retensi</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-bentuk">Bentuk</button>
                                            </th>
                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-jenis">Jenis Informasi</button>
                                            </th>

                                            <th class="w-auto">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-file">File</button>
                                            </th>

                                            <th class="w-1">
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-aksi">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        <?php foreach ($data as $dt => $d): ?>
                                            <tr>
                                                <td class="sort-no text-center">
                                                    <?= $dt + 1 ?>
                                                </td>
                                                <td class="sort-judul">
                                                    <?= htmlspecialchars($d['judul_informasi']) ?>
                                                </td>
                                                <td class="sort-tgl">
                                                    <?= htmlspecialchars(date('d-m-Y', strtotime($d['tanggal_pembuatan']))) ?>
                                                </td>
                                                <td class="sort-retensi">
                                                    <?= htmlspecialchars($d['retensi_arsip']) ?>
                                                </td>
                                                <td class="sort-bentuk">
                                                    <?php
                                                    if ($d['bentuk_informasi'] === 'HARDCOPY') {
                                                        $badge = '<span class="badge">Hardcopy</span>';
                                                    } else if ($d['bentuk_informasi'] === 'SOFTCOPY') {
                                                        $badge = '<span class="badge">Softcopy</span>';
                                                    } else {
                                                        $badge = '<span class="badge">Hardcopy + Softcopy</span>';
                                                    }
                                                    ?>
                                                    <div class="badges-list">
                                                        <?= $badge ?>
                                                    </div>
                                                </td>
                                                <td class="sort-jenis">
                                                    <?php
                                                    if ($d['jenis_informasi'] === 'BERKALA') {
                                                        $bg = 'bg-primary-lt';
                                                    } else if ($d['jenis_informasi'] === 'SERTA MERTA') {
                                                        $bg = 'bg-danger-lt';
                                                    } else if ($d['jenis_informasi'] === 'SETIAP SAAT') {
                                                        $bg = 'bg-success-lt';
                                                    } else {
                                                        $bg = 'bg-secondary-lt';
                                                    }
                                                    ?>
                                                    <span class="badge <?= $bg ?>"><?= htmlspecialchars(ucwords(strtolower($d['jenis_informasi']))) ?></span>
                                                </td>


                                                <td class="sort-file">
                                                    <?php
                                                    $listFile = [];

                                                    if (!empty($d['files'])) {

                                                        $files = explode('##', $d['files']);

                                                        foreach ($files as $f) {

                                                            $part = explode('|', $f);

                                                            if (count($part) === 4) {

                                                                list($id, $nama, $path, $tipe) = $part;

                                                                $listFile[] = [
                                                                    'nama' => htmlspecialchars($nama),
                                                                    'path' => htmlspecialchars($path),
                                                                    'tipe' => htmlspecialchars($tipe)
                                                                ];
                                                            }
                                                        }
                                                    }

                                                    // tampilkan
                                                    foreach ($listFile as $f):
                                                        $ext = strtolower(pathinfo($f['nama'], PATHINFO_EXTENSION));

                                                        // SVG inline
                                                        if ($ext === 'pdf') {
                                                            $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M17 18h2" />
                                                                <path d="M20 15h-3v6" />
                                                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                            </svg>';
                                                        } else if ($ext === 'jpg') {
                                                            // image
                                                            $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" />
                                                            </svg>';
                                                        } else {
                                                            $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 21v-6l3 6v-6" />
                                                            </svg>';
                                                        }

                                                    ?>
                                                        <a href='/sipadu/<?= $path ?>' target='_blank'>



                                                            <?= $icon ?>
                                                            <?= shortname($f['nama'], 50) ?>
                                                        </a>
                                                        <br>
                                                    <?php endforeach; ?>

                                                </td>

                                                <td>
                                                    <div class="btn-group w-100">
                                                        <a href="" class="text-green me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                <path d="M7 11l5 5l5 -5" />
                                                                <path d="M12 4l0 12" />
                                                            </svg>
                                                        </a>
                                                        <a href="" class="text-yellow me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <a href="" class="text-red" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <div class="dropdown">
                                    <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                                        <span id="page-count" class="me-1">10</span>
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

        </div>
    </div>
</div>

<script>
    const advancedTable = {
        headers: [{
                "data-sort": "sort-no",
                name: "No"
            },
            {
                "data-sort": "sort-judul",
                name: "Judul"
            },
            {
                "data-sort": "sort-tgl",
                name: "Tgl Pembuatan"
            },
            {
                "data-sort": "sort-retensi",
                name: "Retensi"
            },
            {
                "data-sort": "sort-jenis",
                name: "Jenis"
            },
            {
                "data-sort": "sort-file",
                name: "File"
            },
            {
                "data-sort": "sort-bentuk",
                name: "bentuk"
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
            page: parseInt("10"),
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
    document.querySelector('#filter-jenis').addEventListener('change', function() {
        const val = this.value;
        const list = window.tabler_list["advanced-table"];

        if (val === '') {
            list.search('');
        } else {
            list.search(val, ['sort-jenis']);
        }
    });
</script>



<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
