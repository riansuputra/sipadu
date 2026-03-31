<?php
$title = "Modul";
$bannerTitle = "Data Modul";
$bannerSubtitle = "Kelola modul SIPADU";

ob_start();
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Modul</div>
                <h2 class="page-title">Daftar Modul</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= url('?page=tambah-modul') ?>" class="btn btn-primary btn-5 d-none d-sm-inline-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah Modul
                    </a>
                    <a href="<?= url('?page=tambah-modul') ?>" class="btn btn-primary btn-6 d-sm-none btn-icon">

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

        <div class="row-row-cards">
            <div class="col-12">


                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="modulTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center w-1">No</th>
                                        <th class="text-center">Judul</th>
                                        <th class="text-center w-1">Tim</th>
                                        <th class="text-center">Link</th>
                                        <th class="text-center w-1">Status</th>
                                        <th class="text-center w-1">Aksi</th>
                                    </tr>
                                    <tr id="filterRow">
                                        <th></th>
                                        <th><input type="text" placeholder="Cari judul..." class="form-control w-100 h5 m-0"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php foreach ($data as $i => $row): ?>
                                            <tr>
                                                <td class="text-center"><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars($row['judul']) ?></td>
                                                <td><?= htmlspecialchars($row['parent_slug'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row['link']) ?></td>
                                                <td class="text-center">
                                                    <?php if ((int)$row['is_active'] === 1): ?>
                                                        <span class="badge bg-success-lt">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger-lt">Nonaktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group w-100">
                                                        <a href="<?= url('?page=edit-modul&id=' . $row['id']) ?>" class="text-yellow me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <a class="text-red"
                                                            onclick="confirmDelete(
                                                                '<?= url('?page=modul-delete') ?>',
                                                                '<?= $row['id'] ?>'
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
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">Belum ada data modul</td>
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

        const table = new DataTable('#modulTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,
            layout: {
                topStart: {
                    pageLength: {},
                    div: {
                        html: `
                        <a href="<?= url('?page=modul') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
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
                createSelectFilter(4); // Tahun

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
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
