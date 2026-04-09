<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Tim";





// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// dd($data);
// echo '</pre>';
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

// 🔥 HAPUS SETELAH DIPAKAI
unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Kelola User</div>
                <h2 class="page-title">Tambah Tim</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="<?= url('?page=tim-store')  ?>" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Tim</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">
                            <div class="mb-3">
                                <label class="form-label required">Pilih Tim / Unit</label>
                                <select class="form-select <?= isset($errors['pokja_tipe']) ? 'is-invalid' : '' ?>" name="pokja_tipe" id="pokja_tipe">
                                    <option value="" disabled <?= empty($old['pokja_tipe']) ? 'selected' : '' ?>>-- Pilih Tim / Unit --</option>
                                    <option value="Tim" <?= ($old['pokja_tipe'] ?? '') == 'Tim' ? 'selected' : '' ?>>Tim</option>
                                    <option value="Unit" <?= ($old['pokja_tipe'] ?? '') == 'Unit' ? 'selected' : '' ?>>Unit</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $errors['pokja_tipe'] ?? '' ?>
                                </div>
                            </div>
                            <div class="">
                                <label class="form-label required">Nama Tim :</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="pokja_nama"
                                        id="pokja_nama"
                                        placeholder="Nama Tim..."
                                        value="<?= $old['pokja_nama'] ?? '' ?>"
                                        class="form-control <?= isset($errors['pokja_nama']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['pokja_nama'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row w-full">
                            <div class="col">
                                <h3 class="card-title mb-0">Tabel Nama Tim / Unit</h3>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="jenisPublikasiTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Tim / Unit</th>
                                        <th class="w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($data as $dt => $d): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['pokja_nama'] ?? '-') ?>
                                            </td>
                                            <td>
                                                <div class="btn-group w-100">
                                                    <a href="" class="text-yellow me-2" data-bs-toggle="modal" data-bs-target="#modal-edit-<?= $d['id'] ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <a type="button" class="text-red" onclick="confirmDelete(
                                                                '<?= url('?page=tim-delete') ?>',
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

                                        <div class="modal modal-blur fade" id="modal-edit-<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Edit Tim / Unit</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-fieldset">
                                                            <form method="POST" action="<?= url('?page=tim-update&id=' . $d['id']) ?>" enctype="multipart/form-data">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Nama Tim / Unit :</label>
                                                                    <div class="col">
                                                                        <input
                                                                            type="text"
                                                                            name="pokja_nama"
                                                                            id="pokja_nama"
                                                                            placeholder="pokja_nama Tim / Unit..."
                                                                            value="<?= $d['pokja_nama'] ?? $old['pokja_nama'] ?? '' ?>"
                                                                            class="form-control <?= isset($errors['pokja_nama']) ? 'is-invalid' : '' ?>">
                                                                        <div class="invalid-feedback">
                                                                            <?= $errors['pokja_nama'] ?? '' ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Pilih Tim / Unit</label>
                                                                    <select class="form-select <?= isset($errors['pokja_tipe']) ? 'is-invalid' : '' ?>" name="pokja_tipe" id="pokja_tipe">
                                                                        <option value="" disabled <?= empty($d['pokja_tipe']) ? 'selected' : '' ?>>-- Pilih Tim / Unit --</option>
                                                                        <option value="Tim" <?= ($d['pokja_tipe'] ?? '') == 'Tim' ? 'selected' : '' ?>>Tim</option>
                                                                        <option value="Unit" <?= ($d['pokja_tipe'] ?? '') == 'Unit' ? 'selected' : '' ?>>Unit</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        <?= $errors['pokja_tipe'] ?? '' ?>
                                                                    </div>
                                                                </div>
                                                                <input type="text" name="id" id="id" value="<?= $d['id'] ?>" hidden>
                                                                <div class="">
                                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        const table = new DataTable('#jenisPublikasiTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,

            language: {
                search: "Cari:",
                lengthMenu: "_MENU_ &nbsp;data",
                info: "_START_ sampai _END_ dari _TOTAL_ data",
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

<?php if (isset($_SESSION['flash'])): ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let status = <?= json_encode($_SESSION['flash']['status']) ?>;
            let message = <?= json_encode($_SESSION['flash']['message']) ?>;

            if (status === 'success') {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                    timer: 1000,
                    showConfirmButton: false,
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    timer: 1500,
                    html: message
                });

            }

        });
    </script>

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<script>
    const advancedTable = {
        headers: [{
                "data-sort": "sort-no",
                name: "No"
            },
            {
                "data-sort": "sort-nama",
                name: "Jenis Publikasi"
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
                timer: 1500
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
