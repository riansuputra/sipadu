<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Arsip";





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
                <div class="page-pretitle">Arsip</div>
                <h2 class="page-title">Tambah Arsip</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <form class="card" method="POST" action="?page=arsip-store" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Arsip</h3>
                        <div class="card-actions">
                            <a class="btn btn-outline-primary" href="?page=arsip"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Daftar Arsip
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-fieldset col-sm-12 col-lg-6">

                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">No. Arsip</label>
                                                <input type="text" name="no_arsip" id="no_arsip" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Kode Klasifikasi</label>
                                                <input type="text" name="kode_klasifikasi" id="kode_klasifikasi" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Uraian Informasi</label>
                                    <div class="col">
                                        <textarea class="form-control" name="uraian_informasi" id="uraian_informasi" rows="3" placeholder="Ringkasan.."></textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Arsip</label>
                                    <div class="col">
                                        <textarea class="form-control" name="jenis_arsip" id="jenis_arsip" rows="3" placeholder="Ringkasan.."></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Indeks</label>
                                                <input type="text" name="indeks" id="indeks" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">No. Item Arsip</label>
                                                <input type="text" name="no_item_arsip" id="no_item_arsip" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Tanggal Arsip</label>
                                                <input type="date" name="tanggal_arsip" id="tanggal_arsip" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Kurun Waktu</label>
                                                <input type="text" name="kurun_waktu" id="kurun_waktu" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Tk. Perkembangan</label>
                                                <select class="form-select" name="tingkat_perkembangan" id="tingkat_perkembangan">
                                                    <option value="" disabled selected>-- Pilih Status --</option>
                                                    <option value="PNS">PNS</option>
                                                    <option value="PPPK">PPPK</option>
                                                    <option value="PPNPN/OUTSOURCING">PPNPN/Outsourcing</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Jumlah</label>
                                                <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Keterangan</label>
                                                <select class="form-select" name="keterangan" id="keterangan">
                                                    <option value="" disabled selected>-- Pilih Status --</option>
                                                    <option value="PNS">PNS</option>
                                                    <option value="PPPK">PPPK</option>
                                                    <option value="PPNPN/OUTSOURCING">PPNPN/Outsourcing</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Status Arsip</label>
                                                <input type="text" name="status_arsip" id="status_arsip" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Hak Akses</label>
                                                <input type="text" name="hak_akses" id="hak_akses" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Klasifikasi Keamanan</label>
                                                <input type="text" name="klasifikasi_keamanan" id="klasifikasi_keamanan" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label">Akses Publik</label>
                                                <input type="text" name="akses_publik" id="akses_publik" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">No. Laci</label>
                                                <select class="form-select" name="no_laci" id="no_laci">
                                                    <option value="" disabled selected>-- Pilih Status --</option>
                                                    <option value="PNS">PNS</option>
                                                    <option value="PPPK">PPPK</option>
                                                    <option value="PPNPN/OUTSOURCING">PPNPN/Outsourcing</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">No Folder</label>
                                                <input type="text" name="no_folder" id="no_folder" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label class="form-label">No Boks</label>
                                                <input type="text" name="no_boks" id="no_boks" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. Filling Cabinet</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="no_filling_cabinet" id="no_filling_cabinet" placeholder="Ringkasan.."></input>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi Simpan</label>
                                    <select class="form-select" name="lokasi_simpan" id="lokasi_simpan">
                                        <option value="" disabled selected>-- Pilih Pangkat/Gol, Ruang --</option>
                                        <option value="Juru Muda, I/a">Juru Muda, I/a</option>
                                        <option value="Juru Muda Tingkat I, I/a">Juru Muda Tingkat I, I/a</option>
                                        <option value="Juru, I/c">Juru, I/c</option>
                                        <option value="Juru Tingkat I, I/d">Juru Tingkat I, I/d</option>
                                        <option value="Pengatur Muda, II/a">Pengatur Muda, II/a</option>
                                        <option value="Pengatur Muda Tingkat I, II/b">Pengatur Muda Tingkat I, II/b</option>
                                        <option value="Pengatur Muda, II/c">Pengatur Muda, II/c</option>
                                        <option value="Pengatur Muda, II/d">Pengatur Muda, II/d</option>
                                        <option value="Penata Muda, III/a">Penata Muda, III/a</option>
                                        <option value="Penata Muda Tingkat I, III/b">Penata Muda Tingkat I, III/b</option>
                                        <option value="Penata, III/c">Penata, III/c</option>
                                        <option value="Penata Tingkat I, III/d">Penata Tingkat I, III/d</option>
                                        <option value="Pembina, IV/a">Pembina, IV/a</option>
                                        <option value="Pembina Tingkat I, IV/b">Pembina Tingkat I, IV/b</option>
                                        <option value="Pembina Utama Muda, IV/c">Pembina Utama Muda, IV/c</option>
                                        <option value="Pembina Utama Madya, IV/d">Pembina Utama Madya, IV/d</option>
                                        <option value="Pembina Utama, IV/e">Pembina Utama, IV/e</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">

                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Jangka Simpan</label>
                                                <input type="text" name="jangka_simpan" id="jangka_simpan" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Nasib Akhir</label>
                                                <input type="text" name="nasib_akhir" id="nasib_akhir" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Boks Usul Musnah</label>
                                                <input type="text" name="boks_usul_musnah" id="boks_usul_musnah" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Status Usul Musnah</label>
                                                <input type="text" name="status_usul_musnah" id="status_usul_musnah" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-fieldset col-sm-12 col-lg-6">

                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Pencipta Arsip</label>
                                                <input type="text" name="pencipta_arsip" id="pencipta_arsip" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label required">Kota Kabupaten</label>
                                                <input type="text" name="kota_kabupaten" id="kota_kabupaten" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">No. Definitif</label>
                                                <input type="text" name="nomor_definitif" id="nomor_definitif" class="form-control" placeholder="">

                                            </div>
                                            <div class="col">
                                                <label class="form-label">File Arsip</label>
                                                <input type="file" class="form-control" name="file[]" id="file" accept=".pdf, .jpg, .png" multiple>
                                                <small class="form-hint">
                                                    Format: PDF
                                                </small>
                                            </div>
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
                        window.location = "?page=tambah-pegawai";
                    } else {
                        window.location = "?page=pegawai";
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

<script>
    new TomSelect("#jabatan", {
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
