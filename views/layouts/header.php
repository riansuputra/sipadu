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
            <div class="mt-1">
                <div class="nav-item dropdown  me-2">
                    <a href="#"
                        class="btn btn-icon"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="outside"
                        aria-label="Show notifications">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                        </svg>
                        <span id="notif-count" class="badge bg-red text-red-fg badge-notification badge-pill mt-2">0</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">

                            <div class="card-header d-flex">
                                <h3 class="card-title">Notifications</h3>
                                <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                            </div>

                            <div id="notif-list" class="list-group list-group-flush list-group-hoverable">
                                <!-- Notifikasi akan dimuat di sini -->
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a href="#" class="btn btn-2 w-100" onclick="markAllRead()">Mark all as read</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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