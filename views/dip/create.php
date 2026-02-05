<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah DIP";





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
                <h2 class="page-title">Tambah DIP</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">
            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="?page=dip-store" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah DIP</h3>
                        <div class="card-actions">
                            <a class="btn btn-primary" href="?page=dip"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Daftar DIP
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
                                    class="form-control <?= isset($errors['nama_informasi']) ? 'is-invalid' : '' ?>"><?= $old['nama_informasi'] ?? '' ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $errors['nama_informasi'] ?? '' ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Unit Kerja yang Menyediakan :</label>
                                <input type="text"
                                    name="unit_penyedia"
                                    id="unit_penyedia"
                                    value="<?= $old['unit_penyedia'] ?? '' ?>"
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
                                    value="<?= $old['penanggung_jawab'] ?? '' ?>"
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
                                            <option value="" disabled <?= empty($old['tahun_pembuatan']) ? 'selected' : '' ?>>-- Pilih Tahun --</option>
                                            <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                                <option value="<?= $i ?>" <?= ($old['tahun_pembuatan'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
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
                                            value="<?= $old['tempat_pembuatan'] ?? '' ?>"
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
                                            <option value="" disabled <?= empty($old['jenis_informasi']) ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                                            <option value="BERKALA" <?= ($old['jenis_informasi'] ?? '') == 'BERKALA' ? 'selected' : '' ?>>Berkala</option>
                                            <option value="SERTA MERTA" <?= ($old['jenis_informasi'] ?? '') == 'SERTA MERTA' ? 'selected' : '' ?>>Serta Merta</option>
                                            <option value="SETIAP SAAT" <?= ($old['jenis_informasi'] ?? '') == 'SETIAP SAAT' ? 'selected' : '' ?>>Setiap Saat</option>
                                            <option value="DIKECUALIKAN" <?= ($old['jenis_informasi'] ?? '') == 'DIKECUALIKAN' ? 'selected' : '' ?>>Dikecualikan</option>
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
                                            <option value="" disabled <?= empty($old['bentuk_informasi']) ? 'selected' : '' ?>>-- Pilih Bentuk --</option>
                                            <option value="HARDCOPY" <?= ($old['bentuk_informasi'] ?? '') == 'HARDCOPY' ? 'selected' : '' ?>>Hardcopy</option>
                                            <option value="SOFTCOPY" <?= ($old['bentuk_informasi'] ?? '') == 'SOFTCOPY' ? 'selected' : '' ?>>Softcopy</option>
                                            <option value="HARDCOPY+SOFTCOPY" <?= ($old['bentuk_informasi'] ?? '') == 'HARDCOPY+SOFTCOPY' ? 'selected' : '' ?>>Hardcopy + Softcopy</option>
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
                                            <option value="" disabled <?= empty($old['retensi_arsip']) ? 'selected' : '' ?>>-- Pilih Retensi --</option>
                                            <option value="Aktif" <?= ($old['retensi_arsip'] ?? '') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                            <option value="1 Tahun" <?= ($old['retensi_arsip'] ?? '') == '1 Tahun' ? 'selected' : '' ?>>1 Tahun</option>
                                            <option value="2 Tahun" <?= ($old['retensi_arsip'] ?? '') == '2 Tahun' ? 'selected' : '' ?>>2 Tahun</option>
                                            <option value="3 Tahun" <?= ($old['retensi_arsip'] ?? '') == '3 Tahun' ? 'selected' : '' ?>>3 Tahun</option>
                                            <option value="5 Tahun" <?= ($old['retensi_arsip'] ?? '') == '5 Tahun' ? 'selected' : '' ?>>5 Tahun</option>
                                            <option value="10 Tahun" <?= ($old['retensi_arsip'] ?? '') == '10 Tahun' ? 'selected' : '' ?>>10 Tahun</option>
                                            <option value="Musnah" <?= ($old['retensi_arsip'] ?? '') == 'Musnah' ? 'selected' : '' ?>>Musnah</option>
                                            <option value="Permanen" <?= ($old['bentuk_informasi'] ?? '') == 'Permanen' ? 'selected' : '' ?>>Permanen</option>
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
                }).then((result) => {

                    if (result.isConfirmed) {
                        window.location = "?page=tambah-dip";
                    } else {
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

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>





<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
