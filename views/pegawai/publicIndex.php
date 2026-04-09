<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Kepegawaian";
$bannerTitle = "Kepegawaian";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// dd($data);
// foreach ($data as $dt => $d):
//     if ($d['files']) {

//         $files = explode('##', $d['files']);

//         foreach ($files as $f) {

//             list($id, $nama, $path) = explode('|', $f);

//             echo "<a href='$path'>$nama</a><br>";
//         }
//     }
// dd($data);
// endforeach;

// echo '</pre>';
?>


<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=dashboard') ?>" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="<?= url('?page=kepegawaian') ?>" class="h3 mb-0">
                                    Kepegawaian
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">

                            <div class="row">
                                <span class="bg-primary text-white avatar me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                                <div class="col">
                                    <div class="subheader">PNS</div>
                                    <div class="d-flex align-items-baseline">
                                        <div class="h3 me-2 mb-0"><?= $statistikStatusAsn['PNS'] ?></div>

                                    </div>

                                </div>
                                <div class="col">
                                    <div class="subheader">PPPK</div>
                                    <div class="d-flex align-items-baseline">
                                        <div class="h3 me-2 mb-0"><?= $statistikStatusAsn['PPPK'] ?></div>

                                    </div>

                                </div>
                                <div class="col-auto">
                                    <div class="subheader">Outsourcing</div>
                                    <div class="d-flex align-items-baseline">
                                        <div class="h3 me-2 mb-0"><?= $statistikStatusAsn['PPNPN/OUTSOURCING'] ?></div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-percentage">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M16 17a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M6 7a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M6 18l12 -12" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="subheader">Rata-Rata Umur</div>
                                <div class="fs-2 fw-bold"><?= $rataRataUmur ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-secondary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-off">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="subheader">Pensiun Tahun Ini</div>
                                <div class="fs-2 fw-bold"><?= array_sum($ringkasanPensiun) ?></div>
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-sm btn-primary text-white" href="<?= url('?page=kepegawaian-pensiun') ?>">Detail</a>

                                <div class="fs-2 fw-bold">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="pegawaiTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center w-1">Nama</th>
                                        <th class="text-center">NIP/<br>NIPPPK</th>
                                        <th class="text-center">Tanggal<br>Lahir</th>
                                        <th class="w-1">Umur</th>
                                        <th class="text-center">Masa Kerja</th>
                                        <th class="w-1 text-center">Proyeksi <br>Pensiun</th>
                                        <th class="w-1 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($data as $dt => $d): ?>

                                        <?php
                                        $usiaPensiun = usiaPensiunPegawai(!empty($d['is_widyaprada']));
                                        $infoPensiun = infoPensiunPegawai($d['tanggal_lahir'], $usiaPensiun);
                                        ?>

                                        <tr>
                                            <td class=" text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['nama'] ?? '-') ?>
                                            </td>
                                            <td class="text-center">
                                                <?= htmlspecialchars(($d['status_asn'] ?? '-') === 'PPNPN/OUTSOURCING' ? 'OS' : ($d['status_asn'] ?? '-')) ?>
                                            </td>
                                            <td class="" style="text-align: left;">
                                                <?= htmlspecialchars($d['nip'] ?? '-') ?>
                                            </td>
                                            <td class="text-center">
                                                <?= !empty($d['tanggal_lahir']) ? date('d-m-Y', strtotime($d['tanggal_lahir'])) : '-' ?>
                                            </td>
                                            <td class="text-center">
                                                <?= htmlspecialchars($d['umur'] ?? '-') ?>
                                            </td>

                                            <td class="text-center"><?= masaKerjaPegawai($d['tmt_masuk']) ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?= $infoPensiun['badge'] ?>">
                                                    <?= $infoPensiun['text'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group w-100">
                                                    <a href="<?= url('?page=detail-kepegawaian&id=' . $d["id"]) ?>" class="text-primary me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
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
                        <a href="<?= url('?page=pegawai') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
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
    function confirmDelete(url, id, label = '') {

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {

            if (result.isConfirmed) {

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
            timer: 5000;

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

<?php if (isset($_SESSION['flash'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: '<?= $_SESSION['flash']['status'] ?>',
                title: <?= $_SESSION['flash']['status'] === 'success'
                            ? "'Berhasil!'"
                            : "'Gagal!'" ?>,
                text: <?= json_encode($_SESSION['flash']['message']) ?>,
                timer: 1000
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
