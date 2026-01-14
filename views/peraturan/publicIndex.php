<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Dashboard";

// echo '<pre>';
// print_r($moduleModel);
// print_r($user);
// print_r($modules);
// echo '</pre>';

// Mulai buffer konten
ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">



        <div class="row row-cards">
            <div class="col-12 ms-2 mb-0">
                <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                    <li class="breadcrumb-item active">
                        <a href="#">Dashboard</a>
                    </li>
                </ol>
            </div>
            <form method="get">
                <input type="hidden" name="page" value="peraturan-publik">

                <input type="text" name="judul" placeholder="Judul">
                <input type="text" name="nomor" placeholder="Nomor">
                <input type="number" name="tahun" placeholder="Tahun">

                <select name="jenis">
                    <option value="">-- Jenis --</option>
                    <option value="1">Peraturan Pemerintah</option>
                    <option value="2">Perpres</option>
                </select>

                <select name="status">
                    <option value="">-- Status --</option>
                    <option value="BERLAKU">Berlaku</option>
                    <option value="TIDAK BERLAKU">Tidak Berlaku</option>
                </select>

                <button type="submit">Terapkan Filter</button>
            </form>
            <a href="?page=peraturan-publik">Reset</a>
            <hr>

            <?php foreach ($data as $d): ?>
                <div>
                    <strong><?= htmlspecialchars($d['judul']) ?></strong><br>
                    <?= $d['nomor'] ?> | <?= $d['tahun_terbit'] ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

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
require __DIR__ . '/../layouts/main.php';
