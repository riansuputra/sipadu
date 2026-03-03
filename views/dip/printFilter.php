<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Cetak DIP";

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


?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">DIP</div>
                <h2 class="page-title">Cetak DIP</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <form class="" method="POST" action="<?= url('?page=dip-print')  ?>" target="_blank">
            <div class="row row-cards ">
                <div class="col-sm-12 col-lg-6">
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">FIlter Data Cetak DIP</h3>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Pilih Data DIP :</label>
                            <div class="form-fieldset">
                                <div class="mb-3">
                                    <label class="form-label required">Tahun :</label>
                                    <select name="tahun" id="tahun" class="form-select <?= isset($errors['tahun']) ? 'is-invalid' : '' ?>">
                                        <option value="" disabled <?= empty($old['tahun']) ? 'selected' : '' ?>>Semua</option>
                                        <?php for ($i = date('Y'); $i >= 1990; $i--): ?>
                                            <option value="<?= $i ?>" <?= ($old['tahun'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $errors['tahun'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="">
                                    <label class="form-label required">Jenis Informasi :</label>

                                    <?php
                                    $jenisOptions = [
                                        'BERKALA' => 'Berkala',
                                        'SERTA MERTA' => 'Serta Merta',
                                        'SETIAP SAAT' => 'Setiap Saat',
                                        'DIKECUALIKAN' => 'Dikecualikan',
                                    ];

                                    $oldJenis = $old['jenis'] ?? []; // HARUS array
                                    ?>

                                    <?php foreach ($jenisOptions as $value => $label): ?>
                                        <label class="form-check">
                                            <input class="form-check-input <?= isset($errors['jenis']) ? 'is-invalid' : '' ?>"
                                                type="checkbox"
                                                name="jenis[]"
                                                value="<?= $value ?>"
                                                <?= in_array($value, $oldJenis) ? 'checked' : '' ?>>
                                            <span class="form-check-label"><?= $label ?></span>
                                        </label>
                                    <?php endforeach; ?>

                                    <div class="invalid-feedback d-block">
                                        <?= $errors['jenis'] ?? '' ?>
                                    </div>
                                </div>

                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">FIlter Data Cetak DIP</h3>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Form Isian Surat</label>

                            <div class="form-fieldset">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label">Nomor Surat :</label>
                                            <input type="text"
                                                name="nomor_surat"
                                                id="nomor_surat"
                                                value="<?= $old['nomor_surat'] ?? '' ?>"
                                                placeholder="Unit Kerja yang Menyediakan..."
                                                class="form-control <?= isset($errors['nomor_surat']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                            <div class="invalid-feedback">
                                                <?= $errors['nomor_surat'] ?? '' ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Tanggal Surat :</label>
                                            <input type="date"
                                                name="tanggal_surat"
                                                id="tanggal_surat"
                                                value="<?= $old['tanggal_surat'] ?? '' ?>"
                                                placeholder="Penanggung Jawab Informasi..."
                                                class="form-control <?= isset($errors['tanggal_surat']) ? 'is-invalid' : '' ?>">
                                            <div class="invalid-feedback">
                                                <?= $errors['tanggal_surat'] ?? '' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tentang :</label>
                                    <textarea
                                        name="tentang"
                                        id="tentang"
                                        placeholder="Tentang..."
                                        rows="3"
                                        class="form-control <?= isset($errors['tentang']) ? 'is-invalid' : '' ?>"><?= $old['tentang'] ?? '' ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $errors['tentang'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Penandatangan :</label>
                                    <input type="text"
                                        name="nama_ttd"
                                        id="nama_ttd"
                                        value="<?= $old['nama_ttd'] ?? '' ?>"
                                        placeholder="Penanggung Jawab Informasi..."
                                        class="form-control <?= isset($errors['nama_ttd']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['nama_ttd'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NIP Penandatangan :</label>
                                    <input type="text"
                                        name="nip_ttd"
                                        id="nip_ttd"
                                        value="<?= $old['nip_ttd'] ?? '' ?>"
                                        placeholder="Penanggung Jawab Informasi..."
                                        class="form-control <?= isset($errors['nip_ttd']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['nip_ttd'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan :</label>
                                    <input type="text"
                                        name="jabatan_ttd"
                                        id="jabatan_ttd"
                                        value="<?= $old['jabatan_ttd'] ?? '' ?>"
                                        placeholder="Penanggung Jawab Informasi..."
                                        class="form-control <?= isset($errors['jabatan_ttd']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['jabatan_ttd'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="">
                                    <label class="form-label required">Tahun di Judul :</label>
                                    <select name="tahun_judul" id="tahun_judul" class="form-select <?= isset($errors['tahun_judul']) ? 'is-invalid' : '' ?>">
                                        <option value="" disabled <?= empty($old['tahun_judul']) ? 'selected' : '' ?>>-- Pilih Tahun --</option>
                                        <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                            <option value="<?= $i ?>" <?= ($old['tahun_judul'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $errors['tahun_pembuatan'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-success">Cetak</button>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </form>
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
