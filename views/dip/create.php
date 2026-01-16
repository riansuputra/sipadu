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
                            <a class="btn btn-outline-primary" href="?page=dip"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Daftar DIP
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Judul Informasi</label>
                            <div class="col">
                                <input type="text" name="judul_informasi" id="judul_informasi" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Ringkasan Informasi</label>
                            <div class="col">
                                <textarea class="form-control" name="ringkasan" id="ringkasan" rows="3" placeholder="Ringkasan.."></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Unit Penguasaan</label>
                            <div class="col">
                                <input type="text" name="unit_penguasaan" id="unit_penguasaan" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Penanggung Jawab</label>
                            <div class="col">
                                <input type="text" name="penanggung_jawab" id="penanggung_jawab" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Jenis Informasi</label>
                            <div class="col">
                                <select class="form-select" name="jenis_informasi" id="jenis_informasi">
                                    <option value="" disabled selected>-- Pilih Jenis --</option>
                                    <option value="BERKALA">Berkala</option>
                                    <option value="SERTA MERTA">Serta Merta</option>
                                    <option value="SETIAP SAAT">Setiap Saat</option>
                                    <option value="DIKECUALIKAN">Dikecualikan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Bentuk Informasi</label>
                            <div class="col">
                                <select class="form-select" name="bentuk_informasi" id="bentuk_informasi">
                                    <option value="" disabled selected>-- Pilih Bentuk --</option>
                                    <option value="HARDCOPY">Hardcopy</option>
                                    <option value="SOFTCOPY">Softcopy</option>
                                    <option value="HARDCOPY+SOFTCOPY">Hardcopy + Softcopy</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Tempat Pembuatan</label>
                            <div class="col">
                                <input type="text" name="tempat_pembuatan" id="tempat_pembuatan" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Tanggal Pembuatan</label>
                            <div class="col">
                                <input type="date" name="tanggal_pembuatan" id="tanggal_pembuatan" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Retensi Arsip</label>
                            <div class="col">
                                <select class="form-select" name="retensi_arsip" id="retensi_arsip">
                                    <option value="" disabled selected>-- Pilih Retensi --</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="1 Tahun">1 Tahun</option>
                                    <option value="2 Tahun">2 Tahun</option>
                                    <option value="3 Tahun">3 Tahun</option>
                                    <option value="5 Tahun">5 Tahun</option>
                                    <option value="10 Tahun">10 Tahun</option>
                                    <option value="Musnah">Musnah</option>
                                    <option value="Permanen">Permanen</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">File</label>
                            <div class="col">
                                <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                <small class="form-hint">
                                    Format: PDF, JPG, PNG
                                </small>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                    reverseButtons: true
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
