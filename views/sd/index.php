<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "SD";
$bannerTitle = "Tim Kerja SD";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";
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
            <div class="col-12 mb-0">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=dashboard') ?>" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="tests" class="h3 mb-0">
                                    SD
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>


            <?php if (!empty($modules)): ?>
                <?php foreach ($modules as $module): ?>
                    <?php
                    $link = $module['link'];
                    $isExternal = filter_var($link, FILTER_VALIDATE_URL);

                    $href = $isExternal
                        ? $link
                        : url('?page=' . $link);
                    ?>

                    <div class="col-sm-6 col-lg-3 p-1">
                        <a href="<?= $href ?>"
                            class="card card-link card-link-pop"
                            <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>

                            <?php
                            $gambar = trim($module['gambar'] ?? '');

                            $path = "public/assets/img/" . $gambar;
                            $hasImage = !empty($gambar) && file_exists($path);
                            ?>

                            <div class="img-responsive img-responsive-21x9 card-img-top position-relative overflow-hidden"
                                style="<?= $hasImage
                                            ? "background-image: url('$path'); background-size: cover; background-position: center;"
                                            : "background-image: url('public/assets/img/default.webp'); background-size: cover; background-position: center;" ?>">
                            </div>

                            <div class="card-body text-center fw-bold mb-0">
                                <?= htmlspecialchars($module['judul']) ?>
                            </div>


                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty">
                        <div class="empty-header">📂</div>
                        <p class="empty-title">Belum ada modul</p>
                        <p class="empty-subtitle text-muted">
                            Modul untuk halaman ini belum tersedia.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    function noAccessAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: 'Anda tidak memiliki akses ke modul ini.',
            confirmButtonText: 'Mengerti'
        });
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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
