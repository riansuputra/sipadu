<?php
// ================================
// HALAMAN TIM / MODUL DINAMIS
// ================================

$title = $pageTitle ?? "Halaman Modul";
$bannerTitle = $pageTitle ?? "Halaman Modul";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

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
                                <span class="h3 mb-0"><?= htmlspecialchars($pageTitle) ?></span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <?php if (!empty($modules)): ?>
                <?php foreach ($modules as $module): ?>
                    <?php
                    $hasAccess = $moduleModel->canAccessByModulId(
                        $user['role'],
                        $user['pokja_id'],
                        (int)$module['id']
                    );

                    $link = $module['link'];
                    $isExternal = filter_var($link, FILTER_VALIDATE_URL);

                    if (!$hasAccess) {
                        $href = '#';
                    } elseif ($isExternal) {
                        $href = $link;
                    } else {
                        $href = BASE_URL . '/?page=' . $link;
                    }

                    $target = ($module['target'] ?? '_self') === '_blank' ? '_blank' : '_self';
                    ?>

                    <div class="col-sm-6 col-lg-3 p-1">
                        <a href="<?= $href ?>"
                            class="card card-link card-link-pop"
                            <?= !$hasAccess ? "onclick=\"noAccessAlert()\"" : "" ?>
                            <?= $hasAccess && $isExternal && $target === '_blank' ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>

                            <div class="img-responsive img-responsive-21x9 card-img-top"
                                style="background-image: url('public/assets/img/<?= htmlspecialchars($module['gambar'] ?? 'default.webp') ?>')">
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
                        <p class="empty-subtitle text-secondary">
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
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
