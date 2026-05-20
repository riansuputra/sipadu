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
// dd($ringkasanPensiun);
// dd($pensiunTahunan);
// dd($tahunPensiun);
// dd($rataRataUmur);
// dd($statistikStatusAsn);
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
            <?php if (
                !in_array($user['role'], ['Pimpinan'])

            ): ?>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

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
                                <a class="" href="<?= url('?page=pegawai-pensiun') ?>">

                                    <span class="bg-primary text-white avatar" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" class="icon icon-tabler icons-tabler-filled icon-tabler-list">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M21 6a1 1 0 0 1 -1 1h-10a1 1 0 1 1 0 -2h10a1 1 0 0 1 1 1" />
                                            <path d="M21 12a1 1 0 0 1 -1 1h-10a1 1 0 0 1 0 -2h10a1 1 0 0 1 1 1" />
                                            <path d="M21 18a1 1 0 0 1 -1 1h-10a1 1 0 0 1 0 -2h10a1 1 0 0 1 1 1" />
                                            <path d="M7 5.995v.02c0 1.099 -.895 1.99 -2 1.99s-2 -.891 -2 -1.99v-.02c0 -1.099 .895 -1.99 2 -1.99s2 .891 2 1.99" />
                                            <path d="M7 11.995v.02c0 1.099 -.895 1.99 -2 1.99s-2 -.891 -2 -1.99v-.02c0 -1.099 .895 -1.99 2 -1.99s2 .891 2 1.99" />
                                            <path d="M7 17.995v.02c0 1.099 -.895 1.99 -2 1.99s-2 -.891 -2 -1.99v-.02c0 -1.099 .895 -1.99 2 -1.99s2 .891 2 1.99" />
                                        </svg>
                                    </span>
                                </a>
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
                                        <th class="text-center w-1">Status</th>
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
                                        $usiaPensiun = usiaPensiunPegawai($d['pangkat_golongan']);
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
                                                <?= !empty($d['tanggal_lahir']) ? date('d/m/Y', strtotime($d['tanggal_lahir'])) : '-' ?>
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
                                                    <a href="<?= url('?page=detail-pegawai&id=' . $d["id"]) ?>" class="text-primary me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                    </a>
                                                    <?php if (
                                                        !in_array($user['role'], ['Pimpinan'])

                                                    ): ?>
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
                                                    <?php endif; ?>
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
require __DIR__ . '/../layouts/admin.php';
