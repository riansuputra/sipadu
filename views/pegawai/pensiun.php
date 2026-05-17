<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Data Pegawai Pensiun";


// Mulai buffer konten
ob_start();
?>


<?php
// dd($daftarPensiun);
$tahunMulai   = $_GET['tahun_mulai'] ?? date('Y');
$tahunSampai  = $_GET['tahun_sampai'] ?? date('Y');

$isFiltered = !empty($_GET['tahun_mulai']) || !empty($_GET['tahun_sampai']);

$deskripsi = 'Menampilkan data pensiun tahun berjalan.';
$jumlah = array_sum($ringkasanPensiun);

if ($isFiltered) {
    if ($tahunMulai == $tahunSampai) {
        $deskripsi = 'Filter aktif: Menampilkan data pegawai yang pensiun pada tahun <strong>' . htmlspecialchars($tahunMulai) . '</strong> sejumlah <strong>' . htmlspecialchars($jumlah) . '</strong> orang.';
    } else {
        $deskripsi = 'Filter aktif: Menampilkan data pegawai yang pensiun dari tahun <strong>' . htmlspecialchars($tahunMulai) . '</strong> s/d <strong>' . htmlspecialchars($tahunSampai) . '</strong> sejumlah <strong>' . htmlspecialchars($jumlah) . '</strong> orang.';
    }
}
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Pegawai</div>
                <h2 class="page-title">Data Pegawai Pensiun</h2>
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
                        <div class="col-sm-12">

                            <form method="get">
                                <div class="row">

                                    <input type="hidden" name="page" value="pegawai-pensiun">

                                    <div class="col-lg-2">
                                        <label class="form-label">Tahun Mulai</label>
                                        <input type="number"
                                            name="tahun_mulai"
                                            class="form-control"
                                            min="2000"
                                            max="2100"
                                            value="<?= htmlspecialchars($_GET['tahun_mulai'] ?? date('Y')) ?>">
                                    </div>

                                    <div class="col-lg-2">
                                        <label class="form-label">Tahun Selesai</label>
                                        <input type="number"
                                            name="tahun_sampai"
                                            class="form-control"
                                            min="2000"
                                            max="2100"
                                            value="<?= htmlspecialchars($_GET['tahun_sampai'] ?? date('Y')) ?>">
                                    </div>

                                    <div class="col-auto ms-auto">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <button class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>
                                            Filter
                                        </button>
                                        <a href="<?= url('?page=pegawai-pensiun') ?>" class="btn btn-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                            </svg>
                                            Reset
                                        </a>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php if ($isFiltered): ?>
                            <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 9h.01" />
                                        <path d="M11 12h1v4h1" />
                                        <path d="M12 3a9 9 0 1 0 9 9a9 9 0 0 0 -9 -9" />
                                    </svg>
                                    <?= $deskripsi ?>
                                </div>
                                <a href="<?= url('?page=pegawai-pensiun') ?>" class="btn btn-sm btn-info">
                                    Reset Filter
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-muted small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 9h.01" />
                                    <path d="M11 12h1v4h1" />
                                </svg>
                                <em><?= $deskripsi ?></em>
                            </div>
                        <?php endif; ?>

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
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($daftarPensiun as $dt => $d): ?>

                                        <?php
                                        $usiaPensiun = usiaPensiunPegawai($d['pangkat_golongan']);
                                        $infoPensiun = infoPensiunPegawai($d['tanggal_lahir'], $usiaPensiun);
                                        ?>

                                        <tr>
                                            <td class=" text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['nama_pegawai'] ?? '-') ?>
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
