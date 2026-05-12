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
                <div class="nav-item dropdown me-2">
                    <a href="#"
                        class="btn btn-icon btn-action text-black"
                        data-bs-toggle="dropdown"
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
                                <h3 class="card-title">Notifikasi</h3>
                                <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                            </div>

                            <div id="notif-list" class="list-group list-group-flush list-group-hoverable">
                                <!-- Notifikasi akan dimuat di sini -->
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a href="#" class="btn btn-2 w-100" onclick="markAllRead()">Tandai semua sudah dibaca</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION["user"]["role"] === "Admin") {
                $bgRole = "bg-yellow text-yellow-fg";
            } elseif ($_SESSION["user"]["role"] === "Superadmin") {
                $bgRole = "bg-red text-red-fg";
            } elseif ($_SESSION["user"]["role"] === "Pimpinan") {
                $bgRole = "bg-orange text-orange-fg";
            } else {
                $bgRole = "bg-secondary text-secondary-fg";
            } ?>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="true">
                    <span
                        class="avatar avatar-sm"
                        style="background-image: url('<?= !empty($_SESSION['user']['foto_profile'])
                                                            ? url($_SESSION['user']['foto_profile'])
                                                            : url('public/assets/img/icon-profile.webp') ?>')">
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div class="fw-bold"><?= htmlspecialchars($user['nama']) ?></div>
                        <div class="mt-1 small fw-bold">
                            @<?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item">
                        <div class="col mb-0">

                            <span class="fw-bold"><?= htmlspecialchars($user['nama']) ?></span>
                            <div class="">@<?= htmlspecialchars($user['username']) ?></div>

                            <p class="mb-0 mt-1">
                                <?php if (!empty($user['pokja_nama'])): ?>
                                    <?= htmlspecialchars($_SESSION['user']['pokja_nama']) ?> <span class="badge <?= $bgRole ?>"><?= htmlspecialchars($_SESSION['user']['role']) ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider mb-0 mt-0"></div>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPilihRole">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-inline me-1">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M21 11v-3c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-6m0 0l3 3m-3 -3l3 -3" />
                            <path d="M3 13.013v3c0 .53 .211 1.039 .586 1.414c.375 .375 .884 .586 1.414 .586h6m0 0l-3 -3m3 3l-3 3" />
                            <path d="M16 16.502c0 .53 .211 1.039 .586 1.414c.375 .375 .884 .586 1.414 .586c.53 0 1.039 -.211 1.414 -.586c.375 -.375 .586 -.884 .586 -1.414c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414" />
                            <path d="M4 4.502c0 .53 .211 1.039 .586 1.414c.375 .375 .884 .586 1.414 .586c.53 0 1.039 -.211 1.414 -.586c.375 -.375 .586 -.884 .586 -1.414c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414" />
                            <path d="M21 21.499c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414" />
                            <path d="M9 9.499c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414" />
                        </svg>
                        Ganti Akses
                    </a>
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