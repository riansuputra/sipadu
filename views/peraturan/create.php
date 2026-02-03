<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Peraturan";





// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Peraturan</div>
                <h2 class="page-title">Tambah Peraturan</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards">

            <div class="col-xl-6 col-sm-6">
                <form class="card" method="POST" action="?page=peraturan-store" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Peraturan</h3>
                        <div class="card-actions">
                            <a class="btn btn-outline-primary" href="?page=peraturan"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Lihat Daftar Peraturan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-fieldset col-sm-12">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Jenis Peraturan</label>
                                    <div class="col">
                                        <select class="form-select <?= isset($errors['jenis_id']) ? 'is-invalid' : '' ?>" name="jenis_id" id="jenis_id">
                                            <option value="" disabled <?= empty($old['jenis_id']) ? 'selected' : '' ?>>-- Pilih Jenis Peraturan --</option>
                                            <?php foreach ($jenis as $j): ?>
                                                <option value="<?= $j['id'] ?>" <?= ($old['jenis_id'] ?? '') == $j['id'] ? 'selected' : '' ?>>
                                                    <?= $j['kode'] ?> (<?= $j['nama'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['jenis_idd'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Judul : </label>
                                    <div class="col">
                                        <textarea
                                            name="judul"
                                            id="judul"
                                            rows="3"
                                            placeholder="Judul..."
                                            class="form-control <?= isset($errors['judul']) ? 'is-invalild' : '' ?>"><?= $old['judul'] ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $errors['judul'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Nomor</label>
                                    <div class="col">
                                        <input
                                            type="text"
                                            name="nomor"
                                            id="nomor"
                                            placeholder="Nomor..."
                                            value="<?= $old['nomor'] ?? '' ?>"
                                            class="form-control <?= isset($errors['nomor']) ? 'is-invalild' : '' ?>">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= $errors['nomor'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">T.E.U.</label>
                                    <div class="col">
                                        <input
                                            type="text"
                                            name="teu"
                                            id="teu"
                                            placeholder="Tajuk Entri Utama..."
                                            value="<?= $old['teu'] ?>"
                                            class="form-control <?= isset($errors['judul']) ? 'is-invalild' : '' ?>">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= $errors['teu'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tahun Terbit</label>
                                    <div class="col">
                                        <select name="tahun_terbit" id="tahun_terbit" class="form-select <?= isset($errors['jenis_id']) ? 'is-invalid' : '' ?>">
                                            <option value="" disabled <?= empty($old['tahun_terbit']) ? 'selected' : '' ?>>-- Pilih Tahun Terbit --</option>
                                            <?php for ($i = date('Y'); $i >= 1990; $i--): ?>
                                                <option value="<?= $i ?>" <?= ($old['tahun_terbit'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['tahun_terbit'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tempat Penetapan</label>
                                    <div class="col">
                                        <input
                                            type="text"
                                            name="tempat_penetapan"
                                            id="tempat_penetapan"
                                            placeholder="Tempat Penetapan..."
                                            value="<?= $old['tempat_penetapan'] ?>"
                                            class="form-control <?= isset($errors['tempat_penetapan']) ? 'is-invalid' : '' ?>">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= $errors['tempat_penetapan'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Penandatangan</label>
                                    <div class="col">
                                        <input
                                            type="text"
                                            name="penandatangan"
                                            id="penandatangan"
                                            placeholder="Penandatangan..."
                                            class="form-control <?= isset($errors['penandatangan']) ? 'is-invalid' : '' ?>">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= $errors['penandatangan'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">File</label>
                                    <div class="col">
                                        <input
                                            type="file"
                                            name="file[]"
                                            id="file"
                                            accept=".pdf, .jpg, .png"
                                            multiple
                                            class="form-control <?= isset($errors['file']) ? 'is-invalid' : '' ?>">
                                        <small class="form-hint">
                                            Format: PDF, JPG, PNG (maks 5MB)
                                        </small>
                                        <div class="invalid-feedback">
                                            <?= $errors['file'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="card" id="preview-card" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Preview File</h3>
                    </div>

                    <div class="card-body">
                        <div id="preview-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    let dt = new DataTransfer(); // ← kunci utama

    const inputFile = document.getElementById('file');
    const previewCard = document.getElementById('preview-card');
    const previewList = document.getElementById('preview-list');

    inputFile.addEventListener('change', function(e) {

        // Tambahkan file ke DataTransfer
        for (let file of e.target.files) {
            dt.items.add(file);
        }

        // Update input file
        inputFile.files = dt.files;

        renderPreview();
    });

    // ==========================
    // FUNGSI RENDER PREVIEW
    // ==========================
    function renderPreview() {

        previewList.innerHTML = '';

        if (dt.files.length === 0) {
            previewCard.style.display = 'none';
            return;
        }

        previewCard.style.display = 'block';

        Array.from(dt.files).forEach((file, index) => {

            const url = URL.createObjectURL(file);
            const ext = file.name.split('.').pop().toLowerCase();

            let previewElement = '';

            if (['jpg', 'jpeg', 'png'].includes(ext)) {

                previewElement = `
                <img src="${url}"
                     style="max-width:100%; height:auto;" />
            `;

            } else if (ext === 'pdf') {

                previewElement = `
                <iframe src="${url}"
                        style="width:100%; height:350px;">
                </iframe>
            `;

            } else {

                previewElement = `
                <div class="alert alert-warning">
                    Tidak dapat preview file ini
                </div>
            `;
            }

            previewList.innerHTML += `
            <div class="border rounded p-2 mb-3">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>${file.name}</strong>
                        <br>
                        <small>${(file.size / 1024).toFixed(2)} KB</small>
                    </div>

                    <button type="button"
                            class="btn btn-danger btn-sm"
                            onclick="hapusFile(${index})">
                        Hapus
                    </button>
                </div>

                ${previewElement}

            </div>
        `;
        });
    }

    // ==========================
    // FUNGSI HAPUS FILE
    // ==========================
    function hapusFile(index) {

        let newDt = new DataTransfer();

        Array.from(dt.files).forEach((file, i) => {
            if (i !== index) {
                newDt.items.add(file);
            }
        });

        dt = newDt;

        // Update input asli
        inputFile.files = dt.files;

        renderPreview();
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
                    cancelButtonText: 'Lihat Daftar',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        window.location = "?page=tambah-peraturan";
                    } else {
                        window.location = "?page=peraturan";
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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
