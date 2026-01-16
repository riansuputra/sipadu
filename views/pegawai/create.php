<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Pegawai";





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
                <div class="page-pretitle">Pegawai</div>
                <h2 class="page-title">Tambah Pegawai</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <form class="card" method="POST" action="?page=pegawai-store" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Pegawai</h3>
                        <div class="card-actions">
                            <a class="btn btn-outline-primary" href="?page=pegawai"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
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
                                    <div class="col-lg-auto col-sm-12 me-3">
                                        <div
                                            onclick="document.getElementById('foto').click()"
                                            style="
                                                width:110px;
                                                height:146px;
                                                border:1px dashed #aaa;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                cursor:pointer;
                                                position:relative;
                                                background:#f9f9f9;
                                            ">
                                            <span
                                                id="textPlaceholder"
                                                style="
                                                    color:#666;
                                                    font-size:13px;
                                                    text-align:center;
                                                ">
                                                Klik untuk<br>menambahkan foto
                                            </span>

                                            <img
                                                id="previewFoto"
                                                style="
                                                    display:none;
                                                    width:100%;
                                                    height:100%;
                                                    object-fit:cover;
                                                    position:absolute;
                                                    top:0;
                                                    left:0;
                                                ">
                                        </div>

                                        <input
                                            type="file"
                                            id="foto"
                                            name="foto"
                                            accept="image/*"
                                            hidden
                                            onchange="previewImage(this)">

                                    </div>

                                    <div class="col">
                                        <label class="form-label required">Nama Lengkap</label>
                                        <input type="text" name="judul" id="judul" class="form-control mb-3" placeholder="">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Tempat Lahir</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Tanggal Lahir</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Jenis Kelamin</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Agama</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">No. Telepon</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Alamat Email</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <label class="form-label required">Alamat</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">

                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Status ASN</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label class="form-label">NIP / NIPPPK</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Pendidikan</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Jurusan</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pangkat, Gol/Ruang</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Jabatan</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Grade</label>
                                                <input type="text" name="judul" id="judul" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. SK Pengangkatan</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. SK SPMT</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">File KK</label>
                                    <div class="col">
                                        <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                        <small class="form-hint">
                                            Format: PDF
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">File KTP</label>
                                    <div class="col">
                                        <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                        <small class="form-hint">
                                            Format: PDF
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">File SK Pengangkatan</label>
                                    <div class="col">
                                        <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                        <small class="form-hint">
                                            Format: PDF
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">File SK SPMT</label>
                                    <div class="col">
                                        <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                        <small class="form-hint">
                                            Format: PDF
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
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

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
                document.getElementById('previewFoto').style.display = 'block';
                document.getElementById('textPlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>



<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
