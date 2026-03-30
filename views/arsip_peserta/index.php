<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Arsip";
$bannerTitle = "Arsip";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";


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
$tanggalMulai   = $_GET['tanggal_mulai'] ?? null;
$tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
$jenis          = $_GET['jenis'] ?? null;

$deskripsi = 'Menampilkan seluruh data';

if ($tanggalMulai || $tanggalSelesai || $jenis) {

    $parts = [];

    if ($tanggalMulai && $tanggalSelesai) {
        $parts[] = "tanggal <strong>" . htmlspecialchars($tanggalMulai) .
            "</strong> sampai <strong>" . htmlspecialchars($tanggalSelesai) . "</strong>";
    } elseif ($tanggalMulai) {
        $parts[] = "tanggal <strong>" . htmlspecialchars($tanggalMulai) . "</strong>";
    }

    if ($jenis) {
        $parts[] = "jenis informasi '<strong>" .
            htmlspecialchars(ucwords(strtolower($jenis))) .
            "</strong>'";
    }

    $deskripsi = 'Filter data publikasi ' . implode(' dan ', $parts);
}

?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Arsip</div>
                <h2 class="page-title">Daftar Arsip</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">

                            <form method="get">
                                <div class="row">

                                    <input type="hidden" name="page" value="publikasi">

                                    <div class="col-lg-2">
                                        <label class="form-label">Tanggal Mulai : </label>
                                        <input type="date"
                                            name="tanggal_mulai"
                                            class="form-control"
                                            value="<?= htmlspecialchars($_GET['tanggal_mulai'] ?? '') ?>">
                                    </div>

                                    <div class="col-lg-2">
                                        <label class="form-label">Tanggal Selesai : </label>
                                        <input type="date"
                                            name="tanggal_selesai"
                                            class="form-control"
                                            value="<?= htmlspecialchars($_GET['tanggal_selesai'] ?? '') ?>">
                                    </div>


                                    <div class="col-auto ms-auto">
                                        <label class="form-label">&nbsp;</label>
                                        <button class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>
                                            Filter
                                        </button>
                                        <a href="<?= url('?page=publikasi') ?>" class="btn btn-secondary">
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

                        <div class="table-responsive">
                            <table id="publikasiTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center w-1">No</th>
                                        <th class="text-center">Judul Arsip<br> & Lokasi</th>
                                        <th class="text-center w-1">Jenis</th>
                                        <th class="text-center" style="width: 20%;">Tanggal</th>
                                        <th class="text-center w-1">Status<br> Upload</th>
                                        <th class="text-center w-1">Bukti</th>
                                        <th class="text-center w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php foreach ($data as $i => $d): ?>
                                            <tr>
                                                <td class="text-center"><?= $i + 1 ?></td>
                                                <td>
                                                    <div class="fw-semibold"><?= htmlspecialchars($d['judul'] ?? '-') ?></div>
                                                    <div class="text-muted small"><?= htmlspecialchars($d['lokasi'] ?? '-') ?></div>
                                                </td>
                                                <td><?= htmlspecialchars($d['jenis_nama'] ?? '-') ?></td>
                                                <td class="text-center">
                                                    <?= formatTanggalRangeTable($d['tanggal_mulai'] ?? null, $d['tanggal_selesai'] ?? null) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (($d['status_otomatis'] ?? '') === 'bukti_diunggah'): ?>
                                                        <span class="badge bg-green text-green-fg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                            Sudah
                                                        </span>

                                                    <?php else: ?>
                                                        <span class="badge bg-red text-red-fg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M18 6l-12 12" />
                                                                <path d="M6 6l12 12" />
                                                            </svg>
                                                            Belum
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary-lt">
                                                        <?= (int) ($d['total_file'] ?? 0) ?> file
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= url('?page=detail-arsip-saya&id=' . $d['arsip_id']) ?>" class="btn btn-sm btn-primary">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Belum ada arsip yang ditugaskan kepada Anda
                                            </td>
                                        </tr>
                                    <?php endif; ?>
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

        const table = new DataTable('#publikasiTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,
            layout: {
                topStart: {
                    pageLength: {},
                    div: {
                        html: `
                        <a href="<?= url('?page=publikasi') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
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

            initComplete: function() {
                const api = this.api();

                // =============================
                // TEXT SEARCH - NAMA INFORMASI
                // =============================
                const namaInput = document.querySelector("#filterRow th:nth-child(2) input");

                namaInput.addEventListener("keyup", function() {
                    api.column(1).search(this.value).draw();
                });

                // =============================
                // HELPER BUAT DROPDOWN FILTER
                // =============================
                function createSelectFilter(colIndex, labelMap = null) {

                    const column = api.column(colIndex);
                    const cell = document.querySelector(
                        "#filterRow th:nth-child(" + (colIndex + 1) + ")"
                    );

                    const select = document.createElement("select");
                    select.className = "form-select h5 w-auto m-0";
                    select.innerHTML = `<option value="">Semua</option>`;
                    cell.appendChild(select);

                    const uniqueValues = new Set();

                    // ambil value dari data-search attribute
                    column.nodes().each(function(node) {
                        const val = node.getAttribute("data-search") || node.textContent.trim();
                        if (val) uniqueValues.add(val);
                    });

                    Array.from(uniqueValues).sort().forEach(function(val) {

                        const label = labelMap && labelMap[val] ?
                            labelMap[val] :
                            val;

                        select.innerHTML += `<option value="${val}">${label}</option>`;
                    });

                    select.addEventListener("change", function() {
                        const value = this.value;

                        column.search(
                            value ? '^' + value + '$' : '',
                            true, // regex
                            false // smart search off
                        ).draw();
                    });
                }

                // =============================
                // MAPPING LABEL BENTUK
                // =============================
                const bentukMap = {
                    'hardcopy': 'Hardcopy',
                    'softcopy': 'Softcopy',
                    'hardcopy_softcopy': 'HC + SC'
                };

                const jenisMap = {
                    'berkala': 'Berkala',
                    'serta_merta': 'Serta Merta',
                    'setiap_saat': 'Setiap Saat',
                    'dikecualikan': 'Dikecualikan'
                };

                // =============================
                // PASANG FILTER SELECT
                // =============================
                createSelectFilter(2); // Tahun
                createSelectFilter(3); // Jenis Informasi

            }
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

                // buat form POST dinamis
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

<?php if (isset($_SESSION['flash'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: '<?= $_SESSION['flash']['status'] ?>',
                title: <?= $_SESSION['flash']['status'] === 'success'
                            ? "'Berhasil!'"
                            : "'Gagal!'" ?>,
                text: <?= json_encode($_SESSION['flash']['message']) ?>,
                timer: 1000,
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
