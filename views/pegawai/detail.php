<?php

// Judul
$title = "Edit Pegawai";





// Mulai buffer konten
ob_start();
?>


<?php
// $files = [];

// foreach ($files as $f) {
//     $files[$f['jenis_dokumen']] = $f;
// }
// dd($files);
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
                <div class="page-pretitle">Pegawai</div>
                <h2 class="page-title">Edit Pegawai</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">

        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="row row-0">
                        <div class="col-3">
                            <!-- Photo -->
                            <img src="./static/photos/beautiful-blonde-woman-relaxing-with-a-can-of-coke-on-a-tree-stump-by-the-beach.jpg" class="w-100 h-100 object-cover card-img-start" alt="Beautiful blonde woman relaxing with a can of coke on a tree stump by the beach">
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <h3 class="card-title">Card with left side image</h3>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deleniti fugit incidunt, iste, itaque minima neque pariatur
                                    perferendis sed suscipit velit vitae voluptatem.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="card">
                    <div class="card-body text-center">

                        <img src="foto.jpg" class="avatar avatar-xl mb-3">

                        <h3>I Made Rian Suputra</h3>
                        <div class="text-muted">NIP: 123456789</div>

                        <div class="mt-3">

                            <span class="badge bg-blue-lt">PNS</span>
                            <span class="badge bg-green-lt">Juru Muda I/a</span>

                        </div>

                        <div class="mt-4">

                            <a href="#" class="btn btn-primary btn-sm">
                                Edit Pegawai
                            </a>

                            <a href="#" class="btn btn-outline-primary btn-sm">
                                Download Dokumen
                            </a>

                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Data Kepegawaian</h3>
                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>
                                <td width="200">Jabatan</td>
                                <td>: Kepala BPMP Provinsi Bali</td>
                            </tr>

                            <tr>
                                <td>Pangkat</td>
                                <td>: Juru Muda I/a</td>
                            </tr>

                            <tr>
                                <td>Pendidikan</td>
                                <td>: S3</td>
                            </tr>

                            <tr>
                                <td>Jurusan</td>
                                <td>: Informatika</td>
                            </tr>

                            <tr>
                                <td>Umur</td>
                                <td>: 24 Tahun</td>
                            </tr>

                            <tr>
                                <td>Proyeksi Pensiun</td>
                                <td>
                                    <span class="badge bg-red-lt">
                                        > 5 Tahun (2060)
                                    </span>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
                <div class="card mt-3">

                    <div class="card-header">
                        <h3 class="card-title">Dokumen Pegawai</h3>
                    </div>

                    <div class="card-body">

                        <table class="table">

                            <tr>
                                <th>Dokumen</th>
                                <th width="150">Aksi</th>
                            </tr>

                            <tr>
                                <td>KTP</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary">Lihat</a>
                                    <a class="btn btn-sm btn-outline-success">Download</a>
                                </td>
                            </tr>

                            <tr>
                                <td>KK</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary">Lihat</a>
                                    <a class="btn btn-sm btn-outline-success">Download</a>
                                </td>
                            </tr>

                            <tr>
                                <td>SK Pengangkatan</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary">Lihat</a>
                                    <a class="btn btn-sm btn-outline-success">Download</a>
                                </td>
                            </tr>

                        </table>

                    </div>

                    <div class="card-footer text-end">

                        <a class="btn btn-primary">
                            Download Semua Dokumen
                        </a>

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

        function handleStatusASN(val) {

            // reset disable
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

                // RESET VALUE
                pangkatPNS.value = "";
                pangkatPPPK.value = "";

                pangkatPNS.disabled = true;
                pangkatPPPK.disabled = true;

            } else {

                pangkatPNS.style.display = "none";
                pangkatPPPK.style.display = "none";

                pangkatPNS.value = "";
                pangkatPPPK.value = "";
            }
        }

        // saat user ganti status
        statusASN.addEventListener("change", function() {
            handleStatusASN(this.value);
        });

        // saat halaman pertama kali load (untuk old value)
        handleStatusASN(statusASN.value);

    });
</script>

<script>
    function previewImage(input) {

        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {

            const img = document.getElementById('previewFoto');
            const text = document.getElementById('textPlaceholder');

            img.src = e.target.result;
            img.style.display = 'block';

            text.style.display = 'none';
        }

        reader.readAsDataURL(file);
    }
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
