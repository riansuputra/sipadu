<?php
// ================================
// HEADER APLIKASI
// ================================
$user = $_SESSION['user'];

// echo '<pre>';
// print_r($user);
// echo '</pre>';
?>

<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <!-- BEGIN NAVBAR LOGO -->
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">

            <a href="<?= url('?page=dashboard') ?>">
                <img src="<?= url('public/assets/img/bpmp-samping.webp') ?>" alt="" style="height: 32px; width: auto;">
            </a>
        </div>
        <!-- END NAVBAR LOGO -->
        <div class="navbar-nav flex-row order-md-last me-2">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="true">
                    <span class="avatar avatar-sm" style="background-image: url(<?= url('public/assets/img/icon-profile.webp') ?>)"> </span>
                    <div class="d-none d-xl-block ps-2">
                        <div class="fw-bold"><?= htmlspecialchars($user['nama']) ?></div>
                        <div class="mt-1 small text-primary fw-bold">
                            <?php if (!empty($user['pokja_nama'])): ?>
                                <?= htmlspecialchars($_SESSION['user']['pokja_tipe']) ?> <?= htmlspecialchars($_SESSION['user']['pokja_nama']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" href="<?= url('?page=logout') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                            <path d="M9 12h12l-3 -3"></path>
                            <path d="M18 15l3 -3"></path>
                        </svg>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>