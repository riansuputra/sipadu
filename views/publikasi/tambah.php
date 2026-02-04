<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Publikasi";


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
                <div class="page-pretitle">Publikasi</div>
                <h2 class="page-title">Tambah Publikasi</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Publikasi</h3>
                        <div class="card-actions">
                            <a class="btn btn-primary"><!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M15 6l-6 6l6 6"></path>
                                </svg>
                                Daftar Publikasi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Judul</label>
                            <div class="col">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    aria-describedby="emailHelp" 
                                    placeholder="Enter email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 form-label">Deskripsi</label>
                            <div class="col">
                                <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Content..">Oh! Come and see the violence inherent in the system! Help, help, I'm being repressed! We shall say 'Ni' again to you, if you do not appease us. I'm not a witch. I'm not a witch. Camelot!</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Lokasi</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Tanggal</label>
                            <div class="col">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">File</label>
                            <div class="col">
                                <input type="file" class="form-control" id="file" accept=".pdf, .jpg, .png">
                                <small class="form-hint">
                                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or
                                    emoji.
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label"></label>
                            <div class="col">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" readonly>
                                    <a href="#" class="btn btn-icon bg-red text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M18 6l-12 12" />
                                            <path d="M6 6l12 12" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-lg-6">
                <form class="card" id="preview-card" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Preview File</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col">
                                <iframe id="preview" style="width:100%; height:500px; display:none;"></iframe>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const preview = document.getElementById('preview');
        const previewCard = document.getElementById('preview-card');
        previewCard.style.display = 'block';
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    });
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



<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
