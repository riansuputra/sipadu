<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Daftar Pegawai";


// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($data);
// foreach ($data as $dt => $d):
//     if ($d['files']) {

//         $files = explode('##', $d['files']);

//         foreach ($files as $f) {

//             list($id, $nama, $path) = explode('|', $f);

//             echo "<a href='$path'>$nama</a><br>";
//         }
//     }

// endforeach;

// echo '</pre>';
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Pegawai</div>
                <h2 class="page-title">Daftar Pegawai</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= BASE_URL ?>/?page=tambah-pegawai" class="btn btn-primary btn-5 d-none d-sm-inline-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah Pegawai
                    </a>
                    <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon">

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
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="pegawaiTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">NIP/<br>NIPPPK</th>
                                        <th class="text-center">Pangkat, <br>Gol/Ruang</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="w-1">Umur</th>
                                        <th class="w-1 text-center">Proyeksi <br>Pensiun</th>
                                        <th class="w-1 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($data as $dt => $d): ?>
                                        <tr>
                                            <td class=" text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['nama'] ?? '-') ?>
                                            </td>

                                            <td class="text-center">
                                                <?= htmlspecialchars($d['nip'] ?? '-') ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['pangkat_golongan'] ?? '-') ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['jabatan'] ?? '-') ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['umur'] ?? '-') ?>
                                            </td>
                                            <td class="">
                                                <?php
                                                if ($d['status_pensiun'] === 'BERLAKU') {
                                                    $bg = 'bg-success-lt';
                                                } else {
                                                    $bg = 'bg-danger-lt';
                                                }
                                                ?>
                                                <span class="badge <?= $bg ?>"><?= $d['status_pensiun'] ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group w-100">
                                                    <a href="<?= url('?page=edit-pegawai&id=' . $d["id"]) ?>" class="text-yellow me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <a class="text-red"
                                                        onclick="confirmDelete(
                                                                '<?= url('?page=pegawai-delete') ?>',
                                                                '<?= $d['id'] ?>'
                                                            )">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#pegawaiTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,
            layout: {
                topStart: {
                    pageLength: {},
                    div: {
                        html: `
                        <a href="<?= url('?page=dip') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                            </svg>
                        </a>
                        `
                    }
                },
                topEnd: 'search'
            },

            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Tidak ada data",
            },


        });

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
            list.search(val, ['sort-status-hid']);
        }
    });
</script>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
