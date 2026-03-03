<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Edit Publikasi";





// Mulai buffer konten
ob_start();
?>


<?php
// echo "<pre>";
// print_r($data);
// print_r($_FILES);
// echo "</pre>";
// die();
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
                <h2 class="page-title">Edit Publikasi</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="<?= url('?page=publikasi-update&id=' . $data['id']) ?>" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Publikasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Judul Publikasi</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="judul"
                                        id="judul"
                                        placeholder="Judul Publikasi..."
                                        value="<?= $data['judul'] ?? $old['judul'] ?? '' ?>"
                                        class="form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['judul'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label">Deskripsi</label>
                                <div class="col">
                                    <textarea
                                        name="deskripsi"
                                        id="deskripsi"
                                        rows="3"
                                        placeholder="Deskripsi.."
                                        class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>" autocomplete="off"><?= $data['deskripsi'] ?? $old['deskripsi'] ?? '' ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $errors['deskripsi'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Tanggal :</label>
                                <div class="col">
                                    <input
                                        type="date"
                                        name="tanggal_kegiatan"
                                        id="tanggal_kegiatan"
                                        value="<?= $data['tanggal_kegiatan'] ?? $old['tanggal_kegiatan'] ?? date('Y-m-d') ?>"
                                        class="form-control <?= isset($errors['tanggal_kegiatan']) ? 'is-invalid' : '' ?>">
                                    <div class="invalid-feedback">
                                        <?= $errors['tanggal_kegiatan'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Lokasi</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="lokasi"
                                        id="lokasi"
                                        placeholder="Lokasi..."
                                        value="<?= $data['lokasi'] ?? $old['lokasi'] ?? '' ?>"
                                        class="form-control <?= isset($errors['lokasi']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['lokasi'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Jenis</label>
                                <div class="col">
                                    <select class="form-select <?= isset($errors['jenis_id']) ? 'is-invalid' : '' ?>" name="jenis_id" id="jenis_id">
                                        <option value="" disabled <?= empty($data['jenis_id']) ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                                        <?php foreach ($jenis as $j): ?>
                                            <option value="<?= $j['id'] ?>" <?= ($data['jenis_id'] ?? '') == $j['id'] ? 'selected' : '' ?>>
                                                <?= $j['nama'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['jenis_id'] ?? '' ?>
                                        </div>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Penulis</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="penulis"
                                        id="penulis"
                                        placeholder="Penulis..."
                                        value="<?= $data['penulis'] ?? $old['penulis'] ?? '' ?>"
                                        class="form-control <?= isset($errors['penulis']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['penulis'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Kabupaten / Kota</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="kabupaten"
                                        id="kabupaten"
                                        placeholder="Kabupaten/Kota..."
                                        value="<?= $data['kabupaten'] ?? $old['kabupaten'] ?? '' ?>"
                                        class="form-control <?= isset($errors['kabupaten']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['kabupaten'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label">File</label>
                                <div class="col">
                                    <input type="file" class="form-control <?= isset($errors['file']) ? 'is-invalid' : '' ?>" name="file[]" id="file" accept=".pdf, .jpg, .png, .jpeg, .gif, .doc, .docx, .xls, .xlsx, .ppt, .pptx" multiple>
                                    <small class="form-hint">
                                        Format: jpg, jpeg, png, doc, pdf, xls, ppt (maks 5MB, untuk video silakan masukkan link video di bawah)
                                    </small>
                                    <div class="invalid-feedback">
                                        <?= $errors['file'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label">Link Media</label>
                                <div class="col">
                                    <input
                                        type="text"
                                        name="link"
                                        id="link"
                                        placeholder="Link..."
                                        value="<?= $data['link'] ?? $old['link'] ?? '' ?>"
                                        class="form-control <?= isset($errors['link']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['link'] ?? '' ?>
                                    </div>
                                </div>
                                <input type="text" name="id" id="id" value="<?= $data['id'] ?>" hidden>
                                <input type="text" name="hapus_file" id="hapus_file" hidden>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <?php if (!empty($files)): ?>
                        <div class="card mb-2" id="old-file-card">
                            <div class="card-header h3">File Tersimpan</div>
                            <div class="card-body" id="old-file-list">

                                <?php foreach ($files as $f): ?>
                                    <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center"
                                        id="old-file-<?= $f["id"] ?>">

                                        <a href="<?= url($f["path_file"]) ?>" target="_blank">
                                            <?= $f["nama_file"] ?>
                                        </a>

                                        <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="hapusFileLama(<?= $f["id"] ?>)">
                                            Hapus
                                        </button>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    <?php endif; ?>
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
</div>

<script>
    let fileLamaDihapus = [];

    function hapusFileLama(id) {

        if (!confirm('Hapus file ini?')) return;

        if (!fileLamaDihapus.includes(id)) {
            fileLamaDihapus.push(id);
        }

        document.getElementById('hapus_file').value =
            fileLamaDihapus.join(',');

        // hapus elemen file
        const fileEl = document.getElementById('old-file-' + id);
        if (fileEl) fileEl.remove();

        // ==========================
        // JIKA FILE HABIS → HILANGKAN CARD
        // ==========================
        const list = document.getElementById('old-file-list');

        if (list.children.length === 0) {
            const card = document.getElementById('old-file-card');
            if (card) card.remove();
        }
    }
</script>


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
    function hapusFileLama(id) {

        Swal.fire({
            title: 'Hapus file?',
            text: 'File akan dihapus saat data disimpan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (!result.isConfirmed) return;

            fileLamaDihapus.push(id);
            document.getElementById('hapus_file').value =
                fileLamaDihapus.join(',');

            const el = document.getElementById('old-file-' + id);
            if (el) el.remove();

            // jika kosong → card hilang
            const list = document.getElementById('old-file-list');
            if (list.children.length === 0) {
                document.getElementById('old-file-card')?.remove();
            }
        });
    }
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
