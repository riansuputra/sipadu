<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Edit DIP";

// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($user);  
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
                <div class="page-pretitle">DIP</div>
                <h2 class="page-title">Edit DIP</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="?page=dip-update&id=<?= $dip['id'] ?>" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit DIP</h3>
                        <div class="card-actions">
                            <a class="btn btn-primary" href="?page=dip"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Lihat Daftar DIP
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">
                            <div class="mb-3">
                                <label class="form-label required">Nama Informasi :</label>
                                <textarea
                                    name="nama_informasi"
                                    id="nama_informasi"
                                    placeholder="Nama Informasi..."
                                    rows="3"
                                    class="form-control <?= isset($errors['nama_informasi']) ? 'is-invalid' : '' ?>"><?= $dip['nama_informasi'] ?? $old['nama_informasi'] ?? '' ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $errors['nama_informasi'] ?? '' ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Unit Kerja yang Menyediakan :</label>
                                <input type="text"
                                    name="unit_penyedia"
                                    id="unit_penyedia"
                                    value="<?= $dip['unit_penyedia'] ?? $old['unit_penyedia'] ?? '' ?>"
                                    placeholder="Unit Kerja yang Menyediakan..."
                                    class="form-control <?= isset($errors['unit_penyedia']) ? 'is-invalid' : '' ?>">
                                <div class="invalid-feedback">
                                    <?= $errors['unit_penyedia'] ?? '' ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penanggung Jawab Informasi :</label>
                                <input type="text"
                                    name="penanggung_jawab"
                                    id="penanggung_jawab"
                                    value="<?= $dip['penanggung_jawab'] ?? $old['penanggung_jawab'] ?? '' ?>"
                                    placeholder="Penanggung Jawab Informasi..."
                                    class="form-control <?= isset($errors['penanggung_jawab']) ? 'is-invalid' : '' ?>">
                                <div class="invalid-feedback">
                                    <?= $errors['penanggung_jawab'] ?? '' ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label required">Waktu dan Tempat Pembuatan :</label>
                                    <div class="col-auto">
                                        <select name="tahun_pembuatan" id="tahun_pembuatan" class="form-select <?= isset($errors['tahun_pembuatan']) ? 'is-invalid' : '' ?>">
                                            <option value="" disabled <?= empty($dip['tahun_pembuatan']) ? 'selected' : '' ?>>-- Pilih Tahun --</option>
                                            <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                                <option value="<?= $i ?>" <?= ($dip['tahun_pembuatan'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['tahun_pembuatan'] ?? '' ?>
                                        </div>
                                    </div>,
                                    <div class="col">
                                        <input type="text"
                                            name="tempat_pembuatan"
                                            id="tempat_pembuatan"
                                            value="<?= $dip['tempat_pembuatan'] ?? $old['tempat_pembuatan'] ?? '' ?>"
                                            placeholder="Tempat Pembuatan..."
                                            class="form-control <?= isset($errors['tempat_pembuatan']) ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $errors['tempat_pembuatan'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label required">Jenis Informasi :</label>
                                        <select class="form-select <?= isset($errors['jenis_informasi']) ? 'is-invalid' : '' ?>"
                                            name="jenis_informasi"
                                            id="jenis_informasi">
                                            <option value="" disabled <?= empty($dip['jenis_informasi']) ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                                            <option value="BERKALA" <?= ($dip['jenis_informasi'] ?? '') == 'BERKALA' ? 'selected' : '' ?>>Berkala</option>
                                            <option value="SERTA MERTA" <?= ($dip['jenis_informasi'] ?? '') == 'SERTA MERTA' ? 'selected' : '' ?>>Serta Merta</option>
                                            <option value="SETIAP SAAT" <?= ($dip['jenis_informasi'] ?? '') == 'SETIAP SAAT' ? 'selected' : '' ?>>Setiap Saat</option>
                                            <option value="DIKECUALIKAN" <?= ($dip['jenis_informasi'] ?? '') == 'DIKECUALIKAN' ? 'selected' : '' ?>>Dikecualikan</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['jenis_informasi'] ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label required">Bentuk Informasi :</label>
                                        <select class="form-select <?= isset($errors['bentuk_informasi']) ? 'is-invalid' : '' ?>"
                                            name="bentuk_informasi"
                                            id="bentuk_informasi">
                                            <option value="" disabled <?= empty($dip['bentuk_informasi']) ? 'selected' : '' ?>>-- Pilih Bentuk --</option>
                                            <option value="HARDCOPY" <?= ($dip['bentuk_informasi'] ?? '') == 'HARDCOPY' ? 'selected' : '' ?>>Hardcopy</option>
                                            <option value="SOFTCOPY" <?= ($dip['bentuk_informasi'] ?? '') == 'SOFTCOPY' ? 'selected' : '' ?>>Softcopy</option>
                                            <option value="HARDCOPY+SOFTCOPY" <?= ($dip['bentuk_informasi'] ?? '') == 'HARDCOPY+SOFTCOPY' ? 'selected' : '' ?>>Hardcopy + Softcopy</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['bentuk_informasi'] ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label">Retensi Arsip :</label>
                                        <select class="form-select <?= isset($errors['retensi_arsip']) ? 'is-invalid' : '' ?>"
                                            name="retensi_arsip"
                                            id="retensi_arsip">
                                            <option value="" disabled <?= empty($dip['retensi_arsip']) ? 'selected' : '' ?>>-- Pilih Retensi --</option>
                                            <option value="Aktif" <?= ($dip['retensi_arsip'] ?? '') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                            <option value="1 Tahun" <?= ($dip['retensi_arsip'] ?? '') == '1 Tahun' ? 'selected' : '' ?>>1 Tahun</option>
                                            <option value="2 Tahun" <?= ($dip['retensi_arsip'] ?? '') == '2 Tahun' ? 'selected' : '' ?>>2 Tahun</option>
                                            <option value="3 Tahun" <?= ($dip['retensi_arsip'] ?? '') == '3 Tahun' ? 'selected' : '' ?>>3 Tahun</option>
                                            <option value="5 Tahun" <?= ($dip['retensi_arsip'] ?? '') == '5 Tahun' ? 'selected' : '' ?>>5 Tahun</option>
                                            <option value="10 Tahun" <?= ($dip['retensi_arsip'] ?? '') == '10 Tahun' ? 'selected' : '' ?>>10 Tahun</option>
                                            <option value="Musnah" <?= ($dip['retensi_arsip'] ?? '') == 'Musnah' ? 'selected' : '' ?>>Musnah</option>
                                            <option value="Permanen" <?= ($dip['bentuk_informasi'] ?? '') == 'Permanen' ? 'selected' : '' ?>>Permanen</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['retensi_arsip'] ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">File :</label>
                                        <input type="file"
                                            name="file[]"
                                            id="file"
                                            accept=".pdf, .jpg, .png"
                                            multiple
                                            class="form-control <?= isset($errors['file']) ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $errors['file'] ?? '' ?>
                                        </div>
                                        <small class="form-hint">
                                            Format: PDF, JPG, PNG
                                        </small>
                                    </div>
                                    <input type="text" name="id" id="id" value="<?= $dip['id'] ?>" hidden>
                                    <input type="text" name="hapus_file" id="hapus_file" hidden>
                                </div>
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
                            <div class="card-header">File Tersimpan</div>
                            <div class="card-body" id="old-file-list">

                                <?php foreach ($files as $f): ?>
                                    <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center"
                                        id="old-file-<?= $f["id"] ?>">

                                        <a href="<?= BASE_URL .
                                                        "/" .
                                                        $f["path_file"] ?>" target="_blank">
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
                        style="width:100%; height:512px;">
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

<?php if (isset($_SESSION["flash"])): ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let status = <?= json_encode($_SESSION["flash"]["status"]) ?>;
            let message = <?= json_encode($_SESSION["flash"]["message"]) ?>;

            if (status === 'success') {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                    confirmButtonText: 'Lihat Daftar',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        window.location = "?page=dip";
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

    <?php unset($_SESSION["flash"]); ?>
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


<script>
    document.querySelector("form").addEventListener("submit", function(e) {

        const judul = document.getElementById("judul_informasi");
        const ringkasan = document.getElementById("ringkasan");
        const jenis = document.getElementById("jenis_informasi");
        const bentuk = document.getElementById("bentuk_informasi");
        const tanggal = document.getElementById("tanggal_pembuatan");
        const file = document.getElementById("file");

        let errors = [];

        if (errors.length > 0) {

            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errors.join("<br>")
            });

        }

    });
</script>


<?php // Simpan konten ke variabel


$content = ob_get_clean(); // Load layout utama
require __DIR__ . "/../layouts/admin.php";
