<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Dashboard";
$bannerTitle = "Halaman Utama";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// echo '<pre>';
// print_r($user);
// print_r($user['role']);
// print_r($user['pokja_id']);
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
                            <li class="breadcrumb-item active">
                                <a href="tests" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>

            </div>
            <?php foreach ($modules as $module): ?>

                <?php
                $hasAccess = $moduleModel->canAccess(
                    $user['role'],
                    $user['pokja_id'],
                    $module['link']
                );

                $link = $module['link'];
                $isExternal = filter_var($link, FILTER_VALIDATE_URL);

                // tentukan href
                if (!$hasAccess) {
                    $href = '#';
                } elseif ($isExternal) {
                    $href = $link;
                } else {
                    $href = BASE_URL . '/?page=' . $link;
                }


                // echo '<pre>';
                // print_r($hasAccess);
                // print_r($user['role_id']);
                // print_r($module['link']);
                // print_r($module['gambar']);
                // echo '</pre>';
                ?>

                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= $href ?>"
                        class="card card-link card-link-pop"
                        <?= !$hasAccess ? "onclick=\"noAccessAlert()\"" : "" ?>
                        <?= $hasAccess && $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/<?= htmlspecialchars($module['gambar']) ?>')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            <?= htmlspecialchars($module['judul']) ?>
                        </div>
                    </a>
                </div>


            <?php endforeach; ?>
            <?php if (
                in_array($user['role'], ['Superadmin', 'Pimpinan']) ||
                (in_array($user['role'], ['Admin', 'Staff']) && in_array($user['pokja_id'], [9], true))
            ): ?>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=timpublikasi')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/publikasi.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Publikasi
                        </div>
                    </a>
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
