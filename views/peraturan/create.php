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
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Peraturan</div>
                <h2 class="page-title">Tambah Jenis Peraturan</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <form class="card" method="POST" action="?page=peraturan-store" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Peraturan</h3>
                        <div class="card-actions">
                            <a class="btn btn-outline-primary" href="?page=peraturan"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Daftar Peraturan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-fieldset col-sm-12 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Judul</label>
                                    <div class="col">
                                        <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Nomor</label>
                                    <div class="col">
                                        <input type="text" name="nomor" id="nomor" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">T.E.U.</label>
                                    <div class="col">
                                        <input type="text" name="teu" id="teu" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Jenis</label>
                                    <div class="col">
                                        <select class="form-select" name="jenis_id" id="jenis_id">
                                            <option value="" disabled selected>-- Pilih Jenis --</option>
                                            <?php foreach ($jenis as $j): ?>
                                                <option value="<?= $j['id'] ?>">
                                                    <?= $j['kode'] ?> (<?= $j['nama'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tahun Terbit</label>
                                    <div class="col">
                                        <select name="tahun_terbit" id="tahun_terbit" class="form-select">
                                            <option value="" disabled selected>-- Pilih Tahun Terbit --</option>

                                            <?php for ($i = date('Y'); $i >= 1990; $i--): ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>

                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tempat Penetapan</label>
                                    <div class="col">
                                        <input type="text" name="tempat_penetapan" id="tempat_penetapan" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tanggal Penetapan</label>
                                    <div class="col">
                                        <input type="date" name="tanggal_penetapan" id="tanggal_penetapan" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tanggal Pengundangan</label>
                                    <div class="col">
                                        <input type="date" name="tanggal_pengundangan" id="tanggal_pengundangan" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Sumber</label>
                                    <div class="col">
                                        <input type="text" name="sumber" id="sumber" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Bahasa</label>
                                    <div class="col">
                                        <input type="text" name="bahasa" id="bahasa" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Status</label>
                                    <div class="col">
                                        <select class="form-select" name="status" id="status">
                                            <option value="" disabled selected>-- Pilih Jenis --</option>
                                            <option value="BERLAKU">Berlaku</option>
                                            <option value="TIDAK BERLAKU">Tidak Berlaku</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Lokasi</label>
                                    <div class="col">
                                        <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Bidang Hukum</label>
                                    <div class="col">
                                        <input type="text" name="bidang_hukum" id="bidang_hukum" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Subjek</label>
                                    <div class="col">
                                        <select class="form-select" name="subjek" id="subjek">
                                            <option value="" disabled selected>-- Pilih Subjek --</option>
                                            <option value="Administrasi">Administrasi</option>
                                            <option value="Bahasa">Bahasa</option>
                                            <option value="Bantuan/Pendanaan Pendidikan">Bantuan/Pendanaan Pendidikan</option>
                                            <option value="Buku">Buku</option>
                                            <option value="Kebudayaan">Kebudayaan</option>
                                            <option value="Organisasi">Organisasi</option>
                                            <option value="Pengawasan">Pengawasan</option>
                                            <option value="Pengelolaan Satuan Pendidikan">Pengelolaan Satuan Pendidikan</option>
                                            <option value="Pendidik dan Tenaga Kependidikan">Pendidik dan Tenaga Kependidikan</option>
                                            <option value="Pendidikan Tinggi">Pendidikan Tinggi</option>
                                            <option value="Perizinan">Perizinan</option>
                                            <option value="Urusan Pemerintah dan Pemerintah Daerah">Urusan Pemerintah dan Pemerintah Daerah</option>
                                            <option value="Riset dan Teknologi">Riset dan Teknologi</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Pemrakarsa</label>
                                    <div class="col">
                                        <input type="text" name="pemrakarsa" id="pemrakarsa" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Penandatangan</label>
                                    <div class="col">
                                        <input type="text" name="penandatangan" id="penandatangan" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-fieldset col-sm-12">
                                <div class="mb-3 row">
                                    <label class="col-auto col-form-label required">File</label>
                                    <div class="col">
                                        <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                        <small class="form-hint">
                                            Format: PDF, JPG, PNG (maks 5MB)
                                        </small>
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


<script>
    document.querySelector("form").addEventListener("submit", function(e) {

        const judul = document.getElementById("judul_informasi");
        const ringkasan = document.getElementById("ringkasan");
        const jenis = document.getElementById("jenis_informasi");
        const bentuk = document.getElementById("bentuk_informasi");
        const tanggal = document.getElementById("tanggal_pembuatan");
        const file = document.getElementById("file");

        let errors = [];

        if (!judul.value.trim())
            errors.push("Judul wajib diisi");

        if (ringkasan.value.trim().length < 10)
            errors.push("Ringkasan minimal 10 karakter");

        if (!jenis.value)
            errors.push("Pilih jenis informasi");

        if (!bentuk.value)
            errors.push("Pilih bentuk informasi");

        if (!tanggal.value)
            errors.push("Tanggal wajib diisi");

        if (file.files.length === 0)
            errors.push("Minimal upload 1 file");

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


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
