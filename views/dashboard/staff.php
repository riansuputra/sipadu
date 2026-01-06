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
            <?php foreach ($modules as $module): ?>

                <?php
                $hasAccess = $moduleModel->canAccess(
                    $user['role_id'],
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
                // echo '</pre>';
                ?>

                <div class="col-sm-6 col-lg-3 p-3">
                    <a href="<?= $href ?>"
                        class="card card-link card-link-pop"
                        <?= !$hasAccess ? "onclick=\"noAccessAlert()\"" : "" ?>
                        <?= $hasAccess && $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('assets/img/<?= htmlspecialchars($module['gambar']) ?>')">
                        </div>

                        <div class="card-body h2 text-center mb-0">
                            <?= htmlspecialchars($module['judul']) ?>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
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
