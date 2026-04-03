<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Edit Jenis Kegiatan";





// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($dataata);
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
                <div class="page-pretitle">Arsip</div>
                <h2 class="page-title">Edit Jenis Kegiatan</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="<?= url('?page=jenis-arsip-update&id=' . $data['id']) ?>" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Jenis Kegiatan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">
                            <div class="mb-3">
                                <label class="form-label required">Jenis Kegiatan :</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="nama"
                                        id="nama"
                                        placeholder="Jenis Kegiatan..."
                                        value="<?= $data['nama'] ?? $old['nama'] ?? '' ?>"
                                        class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>">
                                    <div class="invalid-feedback">
                                        <?= $errors['nama'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan :</label>
                                <div class="col">
                                    <textarea
                                        name="keterangan"
                                        id="keterangan"
                                        rows="3"
                                        placeholder="Keterangan..."
                                        class="form-control <?= isset($errors['keterangan']) ? 'is-invalid' : '' ?>"><?= $data['keterangan'] ?? $old['keterangan'] ?? '' ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $errors['keterangan'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" hidden>
                                <label class="form-label required">Tampilkan :</label>
                                <?php $is_active = $old['is_active'] ?? $data['is_active']; ?>
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
                            <input type="text" name="id" id="id" value="<?= $data['id'] ?>" hidden>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#jenisArsipTable', {
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
