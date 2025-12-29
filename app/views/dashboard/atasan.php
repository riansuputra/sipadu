<?php
$title = "Dashboard";
$currentPage = $_GET['page'] ?? '';

$model = new ModuleModel($pdo);
$user  = currentUser();
$role  = currentRole();

// Semua module aktif → card selalu tampil
// $modules = $model->getAllActiveModules();
$modules = $model->getVisibleModulesByRoleCode($role);

// echo '<pre>';
// print_r($model);
// print_r($user);
// print_r($role);
// print_r($modules);
// echo '</pre>';

ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">

        <div class="row align-items-center">
            <div class="col">
                <a href="<?= BASE_URL ?>/?page=dashboard" class="btn btn-icon mb-0 btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </a>
            </div>
            <div class="col text-center">
                <div><?= htmlspecialchars($user['nama']) ?></div>
                <div class="mt-1 small text-secondary">
                    <?php
                    if ($role == 'ATASAN') {
                        echo ($role);
                    } else {
                        htmlspecialchars($_SESSION['user']['group_type']) . htmlspecialchars($_SESSION['user']['group_name']);
                    }
                    ?>
                </div>
            </div>
            <div class="col text-end">
                <a href="<?= BASE_URL ?>/?page=logout" class="btn btn-icon mb-0 btn-danger" data-bs-toggle="tooltip" data-bs-placement="left" title="Keluar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                        <path d="M15 12h-12l3 -3" />
                        <path d="M6 15l-3 -3" />
                    </svg>
                </a>
            </div>
        </div>

        <hr class="my-3">

        <div class="row row-cards row-evenly">
            <?php foreach ($modules as $module): ?>

                <?php
                $hasAccess = $model->userHasAccess(
                    $user['role'],
                    $user['group_id'],
                    $module['link']
                );

                // echo '<pre>';
                // print_r($hasAccess);
                // echo '</pre>';
                ?>

                <div class="col-sm-6 col-lg-3 p-3">
                    <a href="<?= $hasAccess ? BASE_URL . '/?page=' . $module['link'] : '#' ?>"
                        class="card card-link card-link-pop"
                        <?= !$hasAccess ? "onclick=\"noAccessAlert()\"" : "" ?>>

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('assets/img/<?= htmlspecialchars($module['image']) ?>')">
                        </div>

                        <div class="card-body h2 text-center mb-0">
                            <?= htmlspecialchars($module['title']) ?>
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
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
