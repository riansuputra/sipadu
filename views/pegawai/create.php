<?php

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
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div>
                                    <h4>Data Prib adi</h4>
                                </div>
                                <div class="form-fieldset">

                                    <div class="mb-3 row">
                                        <div class="col-lg-auto col-sm-12 me-3">
                                            <div
                                                onclick="document.getElementById('file_foto').click()"
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
                                                id="file_foto"
                                                name="file_foto"
                                                accept="image/*"
                                                hidden
                                                onchange="previewImage(this)">
                                        </div>
                                        <div class="col">
                                            <label class="form-label required">Nama Lengkap</label>
                                            <input type="text" name="nama" id="nama" class="form-control mb-3" placeholder="Nama lengkap...">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat lahir...">

                                                </div>
                                                <div class="col">
                                                    <label class="form-label required">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK...">
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Jenis Kelamin</label>
                                                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                                        <option value="" disabled selected>-- Pilih Jenis --</option>
                                                        <option value="L">Laki-Laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label required">Agama</label>
                                                    <select class="form-select" name="agama" id="agama">
                                                        <option value="" disabled selected>-- Pilih Agama --</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                                        <option value="Katolik">Katolik</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Buddha">Buddha</option>
                                                        <option value="Konghucu">Konghucu</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">No. Telepon</label>
                                                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" placeholder="">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Alamat Email</label>
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Alamat</label>
                                        <input type="text" name="alamat_domisili" id="alamat_domisili" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File KK</label>
                                        <div class="col">
                                            <input type="file" class="form-control" name="file_kk" id="file_kk" accept=".pdf, .jpg, .png">
                                            <small class="form-hint">
                                                Format: pdf maks 5MB
                                            </small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File KTP</label>
                                        <div class="col">
                                            <input type="file" class="form-control" name="file_ktp" id="file_ktp" accept=".pdf, .jpg, .png">
                                            <small class="form-hint">
                                                Format: pdf maks 5MB
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div>
                                    <h4>Data Kepegawaian</h4>
                                </div>
                                <div class="form-fieldset">
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Status ASN</label>
                                                    <select class="form-select" name="status_asn" id="status_asn">
                                                        <option value="" disabled selected>-- Pilih Status --</option>
                                                        <option value="PNS">PNS</option>
                                                        <option value="PPPK">PPPK</option>
                                                        <option value="PPNPN/OUTSOURCING">PPNPN/Outsourcing</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">NIP / NIPPPK</label>
                                                    <input type="text" name="nip" id="nip" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Pendidikan</label>
                                                    <select class="form-select" name="pendidikan" id="pendidikan">
                                                        <option value="" disabled selected>-- Pilih Pendidikan --</option>
                                                        <option value="S3">S3</option>
                                                        <option value="S2">S2</option>
                                                        <option value="S1">S1</option>
                                                        <option value="SMA">SMA</option>
                                                        <option value="SMP">SMP</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Jurusan</label>
                                                    <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pangkat, Gol/Ruang</label>
                                        <select class="form-select" name="pangkat_golongan" id="pangkat_golongan_pns">
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
                                        <select class="form-select" name="pangkat_golongan" id="pangkat_golongan_pppk">
                                            <option value="" disabled selected>-- Pilih Golongan P3K --</option>
                                            <option value="P3K/V">P3K/V</option>
                                            <option value="P3K/VI">P3K/VI</option>
                                            <option value="P3K/VII">P3K/VII</option>
                                            <option value="P3K/VIII">P3K/VIII</option>
                                            <option value="P3K/IX">P3K/IX</option>
                                            <option value="P3K/X">P3K/X</option>
                                            <option value="P3K/XI">P3K/XI</option>
                                            <option value="P3K/XII">P3K/XII</option>
                                            <option value="P3K/XIII">P3K/XIII</option>
                                            <option value="P3K/XIV">P3K/XIV</option>
                                            <option value="P3K/XV">P3K/XV</option>
                                            <option value="P3K/XVI">P3K/XVI</option>
                                            <option value="P3K/XVII">P3K/XVII</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Jabatan</label>
                                                    <select class="form-select" name="jabatan" id="jabatan" placeholder="-- Pilih Jabatan --" autocomplete="off">
                                                        <option value="" disabled selected>-- Pilih Jabatan --</option>
                                                        <option value="Analis Kemitraan">Analis Kemitraan</option>
                                                        <option value="Analis Sumber Daya Manusia Aparatur Ahli Pertama">Analis Sumber Daya Manusia Aparatur Ahli Pertama</option>
                                                        <option value="Arsiparis Ahli Pertama">Arsiparis Ahli Pertama</option>
                                                        <option value="Arsiparis Mahir">Arsiparis Mahir</option>
                                                        <option value="Cleaning Service">Cleaning Service</option>
                                                        <option value="Kepala BPMP Provinsi Bali">Kepala BPMP Provinsi Bali</option>
                                                        <option value="Kepala Sub Bagian Umum">Kepala Sub Bagian Umum</option>
                                                        <option value="Penelaah Informasi dan Komunikasi Publik">Penelaah Informasi dan Komunikasi Publik</option>
                                                        <option value="Penelaah Teknis Kebijakan">Penelaah Teknis Kebijakan</option>
                                                        <option value="Pengadministrasi Keuangan">Pengadministrasi Keuangan</option>
                                                        <option value="Pengadministrasi Perkantoran">Pengadministrasi Perkantoran</option>
                                                        <option value="Pengelola Sistem dan Teknologi Informasi">Pengelola Sistem dan Teknologi Informasi</option>
                                                        <option value="Pengolah Data dan Informasi">Pengolah Data dan Informasi</option>
                                                        <option value="Pranata Komputer Ahli Pertama">Pranata Komputer Ahli Pertama</option>
                                                        <option value="Satpam">Satpam</option>
                                                        <option value="Sopir">Sopir</option>
                                                        <option value="Teknisi Sarana dan Prasarana">Teknisi Sarana dan Prasarana</option>
                                                        <option value="Tenaga Administrasi">Tenaga Administrasi</option>
                                                        <option value="Tukang Kebun">Tukang Kebun</option>
                                                        <option value="Widyaprada Ahli Madya">Widyaprada Ahli Madya</option>
                                                        <option value="Widyaprada Ahli Muda">Widyaprada Ahli Muda</option>
                                                        <option value="Widyaprada Ahli Pertama">Widyaprada Ahli Pertama</option>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label">Grade</label>
                                                    <select class="form-select" name="grade" id="grade">
                                                        <option value="" disabled selected>Pilih</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. SK Pengangkatan</label>
                                        <input type="text" name="nomor_sk_pengangkatan" id="nomor_sk_pengangkatan" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. SK SPMT</label>
                                        <input type="text" name="nomor_sk_spmt" id="nomor_sk_spmt" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File SK Pengangkatan</label>
                                        <div class="col">
                                            <input type="file" class="form-control" name="file_sk_pengangkatan" id="file_sk_pengangkatan" accept=".pdf, .jpg, .png">
                                            <small class="form-hint">
                                                Format: pdf maks 5MB
                                            </small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File SK SPMT</label>
                                        <div class="col">
                                            <input type="file" class="form-control" name="file_sk_spmt" id="file_sk_spmt" accept=".pdf, .jpg, .png">
                                            <small class="form-hint">
                                                Format: pdf maks 5MB
                                            </small>
                                        </div>
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
    document.addEventListener("DOMContentLoaded", function() {

        const statusASN = document.getElementById("status_asn");
        const nip = document.getElementById("nip");
        const grade = document.getElementById("grade");

        const pangkatPNS = document.getElementById("pangkat_golongan_pns");
        const pangkatPPPK = document.getElementById("pangkat_golongan_pppk");

        // default saat halaman load
        pangkatPNS.style.display = "block";
        pangkatPPPK.style.display = "none";
        pangkatPNS.disabled = true;

        statusASN.addEventListener("change", function() {

            const val = this.value;

            // reset
            nip.disabled = false;
            grade.disabled = false;
            pangkatPNS.disabled = false;
            pangkatPPPK.disabled = false;

            if (val === "PNS") {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

            } else if (val === "PPPK") {

                pangkatPNS.style.display = "none";
                pangkatPPPK.style.display = "block";

            } else if (val === "PPNPN/OUTSOURCING") {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

                nip.disabled = true;
                grade.disabled = true;
                pangkatPNS.disabled = true;

            } else {

                // jika kembali ke kosong
                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";
                pangkatPNS.disabled = true;

            }

        });

    });
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
