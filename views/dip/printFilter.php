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
// foreach ($data as $dt => $d):
//     if ($d['files']) {

//         $files = explode('##', $d['files']);

//         foreach ($files as $f) {

//             list($id, $nama, $path) = explode('|', $f);

//             echo "<a href='$path'>$nama</a><br>";
//         }
//         print_r($d['files']);
//     }

// endforeach;

// echo '</pre>';


$tahun = $_GET['tahun'] ?? null;
$jenis = $_GET['jenis'] ?? null;

$deskripsi = 'Menampilkan seluruh data';

if ($tahun || $jenis) {

    $parts = [];

    if ($tahun) {
        $parts[] = "tahun '<strong>" . htmlspecialchars($tahun) . "</strong>'";
    }

    if ($jenis) {
        $parts[] = "jenis informasi '<strong>" . htmlspecialchars(ucwords(strtolower($jenis))) . "</strong>'";
    }

    $deskripsi = 'Filter data DIP ' . implode(' dan ', $parts);
}
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

                <form method="GET" action="">
                    <input type="hidden" name="page" value="dip-print">

                    <div class="mb-3">
                        <label>Tahun</label>
                        <select name="tahun" class="form-control">
                            <option value="">-- Semua Tahun --</option>
                            <?php for ($y = date('Y'); $y >= 2015; $y--): ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Jenis Informasi</label>
                        <select name="jenis[]" class="form-control" multiple>
                            <option value="berkala">Berkala</option>
                            <option value="serta merta">Serta Merta</option>
                            <option value="setiap saat">Setiap Saat</option>
                            <option value="dikecualikan">Dikecualikan</option>
                        </select>
                        <small>Tekan CTRL untuk memilih lebih dari satu</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Tampilkan & Cetak
                    </button>
                </form>
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
                "data-sort": "sort-nama",
                name: "Nama Informasi"
            },
            {
                "data-sort": "sort-tahun",
                name: "Tahun"
            },
            {
                "data-sort": "sort-jenis",
                name: "Jenis Informasi"
            },
            {
                "data-sort": "sort-retensi",
                name: "Retensi"
            },
            {
                "data-sort": "sort-bentuk",
                name: "bentuk"
            },
            {
                "data-sort": "sort-file",
                name: "File"
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
    function confirmDelete(url, label = '') {

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = url;
            }

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
                text: <?= json_encode($_SESSION['flash']['message']) ?>
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . "/../layouts/admin.php";
