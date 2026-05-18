<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Daftar User";


// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// dd($data);
// echo '</pre>';
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">User</div>
                <h2 class="page-title">Daftar User</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= url('?page=tambah-user') ?>" class="btn btn-primary btn-5 d-none d-sm-inline-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah User
                    </a>
                    <a href="<?= url('?page=tambah-user') ?>" class="btn btn-primary btn-6 d-sm-none btn-icon">

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
                            <table id="userTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th class="w-1">Akses</th>
                                        <th class="w-1">Status</th>
                                        <th class="w-1">Aksi</th>
                                    </tr>

                                </thead>
                                <tbody class="table-tbody">
                                    <?php foreach ($data as $dt => $d): ?>
                                        <tr>
                                            <td class=" text-center">
                                                <?= $dt + 1 ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars(!empty($d['pegawai_nama']) ? $d['pegawai_nama'] : ($d['nama_lengkap'] ?? '-')) ?>
                                            </td>
                                            <td class="">
                                                <?= htmlspecialchars($d['username'] ?? '-') ?>
                                            </td>
                                            <td>

                                                <?php
                                                $aksesDetail = !empty($d['akses_detail'])
                                                    ? explode(';;', $d['akses_detail'])
                                                    : [];
                                                ?>

                                                <?php foreach ($aksesDetail as $item): ?>

                                                    <?php

                                                    [$pokja, $role, $kodeRole, $isDefault]
                                                        = explode('|', $item);

                                                    $badge = 'bg-secondary';

                                                    switch ($kodeRole) {

                                                        case 'Superadmin':
                                                            $badge = 'bg-red text-red-fg';
                                                            break;

                                                        case 'Admin':
                                                            $badge = 'bg-yellow text-yellow-fg';
                                                            break;

                                                        case 'Pimpinan':
                                                            $badge = 'bg-orange text-orange-fg';
                                                            break;

                                                        case 'Staff':
                                                            $badge = 'bg-secondary text-secondary-fg';
                                                            break;
                                                    }

                                                    ?>

                                                    <div class="badge badge-outline w-100 bg-secondary-lt rounded p-1 mb-1">

                                                        <div class="fw-bold text-center text-dark mb-1">
                                                            <?= htmlspecialchars($pokja) ?>
                                                        </div>

                                                        <span class="badge w-100 <?= $badge ?>">
                                                            <?= htmlspecialchars($kodeRole) ?>
                                                        </span>


                                                    </div>

                                                <?php endforeach; ?>

                                            </td>

                                            <td class="">
                                                <?php if ($d["is_active"] === 1) {
                                                    $bg = "bg-success w-100 text-blue-fg";
                                                    $text = 'Aktif';
                                                } else {
                                                    $bg = "bg-danger w-100 text-secondary-fg";
                                                    $text = 'Nonaktif';
                                                } ?>
                                                <span class="badge <?= $bg ?>"><?= $text ?></span>
                                            </td>

                                            <td>
                                                <?php
                                                if ($d["is_active"] === 1) {
                                                    $bgIcon = "text-danger";
                                                    $function = "confirmOff('" . url('?page=user-delete') . "', '" . $d['id'] . "')";
                                                } else {
                                                    $bgIcon = "text-success";
                                                    $function = "confirmOn('" . url('?page=user-active') . "', '" . $d['id'] . "')";
                                                }
                                                ?>
                                                <div class="btn-group w-100">
                                                    <a href="<?= url('?page=edit-user&id=' . $d["id"]) ?>" class="text-yellow me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <a class="<?= $bgIcon ?>"
                                                        onclick="<?= $function ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-power">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 6a7.75 7.75 0 1 0 10 0" />
                                                            <path d="M12 4l0 8" />
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

        const table = new DataTable('#userTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,
            layout: {
                topStart: {
                    pageLength: {},
                    div: {
                        html: `
                        <a href="<?= url('?page=user') ?>" class="btn btn-primary btn-sm btn-6 btn-icon">
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
    function confirmOff(url, id, label = '') {

        Swal.fire({
            title: 'Yakin ingin nonaktifkan?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'User akan dinonaktifkan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
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

<script>
    function confirmOn(url, id, label = '') {

        Swal.fire({
            title: 'Yakin ingin aktifkan?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'User akan diaktifkan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
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
require __DIR__ . '/../layouts/admin.php';
