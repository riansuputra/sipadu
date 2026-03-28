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
                <h2 class="page-title">Tambah Pegawai</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-md-6 col-lg-4">
                <!-- Cards with tabs component -->
                <div class="card-tabs">
                    <!-- Cards navigation -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a href="#tab-top-1" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Tab 1</a></li>
                        <li class="nav-item" role="presentation"><a href="#tab-top-2" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Tab 2</a></li>
                        <li class="nav-item" role="presentation"><a href="#tab-top-3" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Tab 3</a></li>
                        <li class="nav-item" role="presentation"><a href="#tab-top-4" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Tab 4</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Content of card #1 -->
                        <div id="tab-top-1" class="card tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="card-title">Content of tab #1</div>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni
                                    molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                        <!-- Content of card #2 -->
                        <div id="tab-top-2" class="card tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="card-title">Content of tab #2</div>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni
                                    molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                        <!-- Content of card #3 -->
                        <div id="tab-top-3" class="card tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="card-title">Content of tab #3</div>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni
                                    molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                        <!-- Content of card #4 -->
                        <div id="tab-top-4" class="card tab-pane active show" role="tabpanel">
                            <div class="card-body">
                                <div class="card-title">Content of tab #4</div>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni
                                    molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body bg-gray-300">
                        <div class="d-flex flex-nowrap step-container">

                            <div class="step-indicator active" data-step="1">1. Biodata</div>
                            <div class="step-indicator" data-step="2">2. Kepegawaian</div>
                            <div class="step-indicator" data-step="3">3. File</div>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- STEP INDICATOR -->


                        <form method="POST" enctype="multipart/form-data" id="formPegawai">

                            <!-- ================= STEP 1 ================= -->
                            <div class="step" id="step-1">
                                <div class="row">

                                    <!-- FOTO -->
                                    <div class="col-md-3 text-center">

                                        <div class="foto-upload <?= isset($errors['file_foto']) ? 'border-danger' : '' ?>"
                                            onclick="triggerFotoUpload(event)">

                                            <span id="textPlaceholder">
                                                Klik untuk<br>menambahkan foto
                                            </span>

                                            <img id="previewFoto">

                                            <!-- Tombol Hapus -->
                                            <button type="button" id="btnHapusFoto"
                                                onclick="hapusFoto(event)"
                                                class="btn btn-danger btn-sm"
                                                style="position:absolute; top:5px; right:5px; display:none;">
                                                ✕
                                            </button>

                                        </div>

                                        <input type="file" id="file_foto" name="file_foto" hidden onchange="previewImage(this)">

                                    </div>

                                    <!-- BIODATA -->
                                    <div class="col-md-9">

                                        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>

                                        <div class="row">
                                            <div class="col">
                                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                                            </div>
                                            <div class="col">
                                                <input type="date" name="tanggal_lahir" class="form-control" required>
                                            </div>
                                        </div>

                                        <input type="text" name="nik" class="form-control mt-2" placeholder="NIK">

                                        <div class="row mt-2">
                                            <div class="col">
                                                <select name="jenis_kelamin" class="form-control" required>
                                                    <option value="">Jenis Kelamin</option>
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="agama" class="form-control" placeholder="Agama">
                                            </div>
                                        </div>

                                        <input type="text" name="no_telepon" class="form-control mt-2" placeholder="No Telepon">
                                        <input type="email" name="email" class="form-control mt-2" placeholder="Email">
                                        <textarea name="alamat_domisili" class="form-control mt-2" placeholder="Alamat"></textarea>

                                    </div>
                                </div>

                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-primary next">Next</button>
                                </div>
                            </div>

                            <!-- ================= STEP 2 ================= -->
                            <div class="step d-none" id="step-2">
                                <div class="row">

                                    <div class="col-md-6">

                                        <select name="status_asn" class="form-control mb-2" required>
                                            <option value="">Status ASN</option>
                                            <option value="PNS">PNS</option>
                                            <option value="PPPK">PPPK</option>
                                            <option value="PPNPN/OUTSOURCING">PPNPN</option>
                                        </select>

                                        <input type="text" name="nip" class="form-control mb-2" placeholder="NIP/NIPPPK">

                                        <input type="text" name="pendidikan" class="form-control mb-2" placeholder="Pendidikan">
                                        <input type="text" name="jurusan" class="form-control mb-2" placeholder="Jurusan">

                                        <input type="text" name="pangkat_golongan" class="form-control mb-2" placeholder="Pangkat / Golongan">

                                    </div>

                                    <div class="col-md-6">

                                        <select name="jabatan_id" class="form-control mb-2">
                                            <option value="">Pilih Jabatan</option>
                                            <!-- loop jabatan -->
                                        </select>

                                        <input type="number" name="grade" class="form-control mb-2" placeholder="Grade">

                                        <input type="text" name="nomor_sk_pengangkatan" class="form-control mb-2" placeholder="No SK Pengangkatan">
                                        <input type="text" name="nomor_sk_spmt" class="form-control mb-2" placeholder="No SK SPMT">

                                        <input type="date" name="tmt_masuk" class="form-control mb-2">

                                        <input type="number" name="proyeksi_pensiun" class="form-control" placeholder="Tahun Pensiun">

                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary prev">Back</button>
                                    <button type="button" class="btn btn-primary next">Next</button>
                                </div>
                            </div>

                            <!-- ================= STEP 3 ================= -->
                            <div class="step d-none" id="step-3">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>File KK</label>
                                        <input type="file" name="file_kk" class="form-control mb-2">

                                        <label>File KTP</label>
                                        <input type="file" name="file_ktp" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>File SK Pengangkatan</label>
                                        <input type="file" name="file_sk_pengangkatan" class="form-control mb-2">

                                        <label>File SK SPMT</label>
                                        <input type="file" name="file_sk_spmt" class="form-control">
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary prev">Back</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
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
    document.addEventListener("DOMContentLoaded", function() {

        let currentStep = 1;
        const totalStep = 3;

        function showStep(step) {
            document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
            document.getElementById('step-' + step).classList.remove('d-none');

            document.querySelectorAll('.step-indicator').forEach(el => {
                el.classList.remove('active');
            });

            document.querySelector(`.step-indicator[data-step="${step}"]`).classList.add('active');

            currentStep = step;
        }

        // NEXT BUTTON
        document.querySelectorAll('.next').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep < totalStep) {
                    showStep(currentStep + 1);
                }
            });
        });

        // PREV BUTTON
        document.querySelectorAll('.prev').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });
        });

        // CLICK STEP INDICATOR
        document.querySelectorAll('.step-indicator').forEach(el => {
            el.addEventListener('click', function() {

                const targetStep = parseInt(this.getAttribute('data-step'));

                showStep(targetStep); // langsung saja

            });
        });

    });
</script>


<script>
    function triggerFotoUpload(e) {
        // kalau klik tombol hapus → jangan buka file
        if (e.target.id === 'btnHapusFoto') return;

        document.getElementById('file_foto').click();
    }

    function previewImage(input) {

        const file = input.files[0];
        if (!file) return;

        const preview = document.getElementById('previewFoto');
        const text = document.getElementById('textPlaceholder');
        const btnHapus = document.getElementById('btnHapusFoto');

        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            text.style.display = 'none';
            btnHapus.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

    function hapusFoto(e) {
        e.stopPropagation(); // ⬅️ penting supaya tidak trigger upload

        const input = document.getElementById('file_foto');
        const preview = document.getElementById('previewFoto');
        const text = document.getElementById('textPlaceholder');
        const btnHapus = document.getElementById('btnHapusFoto');

        // reset input file
        input.value = "";

        // reset tampilan
        preview.src = "";
        preview.style.display = 'none';
        text.style.display = 'block';
        btnHapus.style.display = 'none';
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

            nip.disabled = false;
            grade.disabled = false;

            if (val === "PNS") {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

                pangkatPNS.disabled = false;
                pangkatPPPK.disabled = true;

            } else if (val === "PPPK") {

                pangkatPNS.style.display = "none";
                pangkatPPPK.style.display = "block";

                pangkatPNS.disabled = true;
                pangkatPPPK.disabled = false;

            } else if (val === "PPNPN/OUTSOURCING") {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

                pangkatPNS.disabled = true;
                pangkatPPPK.disabled = true;

                nip.disabled = true;
                grade.disabled = true;

            } else {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

                pangkatPNS.disabled = true;
                pangkatPPPK.disabled = true;

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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
