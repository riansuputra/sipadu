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

            <a href="<?= BASE_URL ?>/?page=dashboard">
                <img src="http://localhost/sipadu/public/assets/img/bpmp-samping.webp" alt="" style="height: 32px; width: auto;">
            </a>
        </div>
        <!-- END NAVBAR LOGO -->
        <div class="navbar-nav flex-row order-md-last me-2">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="true">
                    <span class="avatar avatar-sm" style="background-image: url(http://localhost/sipadu/public/assets/img/icon-profile.webp)"> </span>
                    <div class="d-none d-xl-block ps-2">
                        <div class="fw-bold"><?= htmlspecialchars($user['nama']) ?></div>
                        <div class="mt-1 small text-primary fw-bold">
                            <?php if (!empty($user['pokja_nama'])): ?>
                                <?= htmlspecialchars($_SESSION['user']['pokja_tipe']) ?> <?= htmlspecialchars($_SESSION['user']['pokja_nama']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-popper="static">
                    <a href="#" class="dropdown-item">Status</a>
                    <a href="./profile.html" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Feedback</a>
                    <div class="dropdown-divider"></div>
                    <a href="./settings.html" class="dropdown-item">Settings</a>
                    <a href="<?= BASE_URL ?>/?page=logout" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>