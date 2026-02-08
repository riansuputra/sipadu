<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Jenis Publikasi";





// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($data);
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
                <div class="page-pretitle">Publikasi</div>
                <h2 class="page-title">Tambah Jenis Publikasi</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="<?= url('?page=jenis-publikasi-store')  ?>" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Jenis Publikasi</h3>
                        <div class="card-actions">
                            <a class="btn btn-primary" href="<?= url('?page=tambah-publikasi')  ?>"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Tambah Publikasi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Jenis Publikasi :</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="nama"
                                        id="nama"
                                        placeholder="Jenis Publikasi..."
                                        value="<?= $old['nama'] ?? '' ?>"
                                        class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['nama'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label">Keterangan :</label>
                                <div class="col">
                                    <textarea
                                        placeholder="Keterangan..."
                                        name="keterangan"
                                        id="keterangan"
                                        rows="3"
                                        class="form-control <?= isset($errors['keterangan']) ? 'is-invalid' : '' ?>" autocomplete="off"><?= $old['keterangan'] ?? '' ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $errors['keterangan'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Tampilkan</label>
                                <div class="col">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" checked="">
                                        <span class="form-check-label">Ya</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0">
                                        <span class="form-check-label">Tidak</span>
                                    </label>
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
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">
                                    <h3 class="card-title mb-0">Tabel Jenis Publikasi</h3>
                                    <p class="text-secondary m-0">Daftar Jenis Publikasi</p>
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
                                            <input id="advanced-table-search" type="text" class="form-control" autocomplete="off" placeholder="Cari Jenis Publiaksi">
                                        </div>
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
                                                <button class="table-sort d-flex justify-content-between" data-sort="sort-nama">Jenis Publikasi</button>
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
                                                <td class="sort-nama">
                                                    <?= htmlspecialchars($d['nama'] ?? '-') ?>
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
                                                                '<?= url('?page=jenis-publikasi-delete&id=' . $d['id']) ?>'
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
                                                            <h3 class="card-title">Edit Jenis Publikasi</h3>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="card" method="POST" action="<?= url('?page=jenis-publikasi-update&id=' . $d['id']) ?>" enctype="multipart/form-data">
                                                                <div class="form-fieldset">
                                                                    <div class="mb-3 row">
                                                                        <label class="col-3 col-form-label required">Jenis Publikasi :</label>
                                                                        <div class="col">
                                                                            <input
                                                                                type="text"
                                                                                name="nama"
                                                                                id="nama"
                                                                                placeholder="Jenis Publikasi..."
                                                                                value="<?= $d['nama'] ?? $old['nama'] ?? '' ?>"
                                                                                class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>">
                                                                            <div class="invalid-feedback">
                                                                                <?= $errors['nama'] ?? '' ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label class="col-3 col-form-label">Keterangan :</label>
                                                                        <div class="col">
                                                                            <textarea
                                                                                name="keterangan"
                                                                                id="keterangan"
                                                                                rows="3"
                                                                                placeholder="Keterangan..."
                                                                                class="form-control <?= isset($errors['keterangan']) ? 'is-invalid' : '' ?>"><?= $d['keterangan'] ?? $old['keterangan'] ?? '' ?></textarea>
                                                                            <div class="invalid-feedback">
                                                                                <?= $errors['keterangan'] ?? '' ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label class="col-3 col-form-label required">Tampilkan :</label>
                                                                        <?php $is_active = $old['is_active'] ?? $d['is_active']; ?>
                                                                        <div class="col">
                                                                            <label class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" <?= $is_active == 1 ? 'checked' : '' ?>>
                                                                                <span class="form-check-label">Ya</span>
                                                                            </label>
                                                                            <label class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0" <?= $is_active == 0 ? 'checked' : '' ?>>
                                                                                <span class="form-check-label">Tidak</span>
                                                                            </label>
                                                                        </div>
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
                    showCancelButton: true,
                    confirmButtonText: 'Input Lagi',
                    cancelButtonText: 'Lihat Daftar Publikasi',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        window.location.href = "<?= url('?page=tambah-jenis-publikasi') ?>";
                    } else {
                        window.location.href = "<?= url('?page=publikasi') ?>";
                    }

                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
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
require __DIR__ . '/../layouts/admin.php';
