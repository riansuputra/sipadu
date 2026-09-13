<?php
// dd(Auth::pokja());
// dd($user);
// dd($userModel->getUserPokjaList($this->user['id']));
// dd($_SESSION['user']['foto_profile']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= $title ?> - SIPADU</title>

    <link href="<?= url('public/assets/css/tabler.min.css') ?>" rel="stylesheet" />
    <link href="<?= url('public/assets/css/tabler-vendors.min.css') ?>" rel="stylesheet" />
    <link href="<?= url('public/assets/css/datatables.css') ?>" rel="stylesheet" />
    <link href="<?= url('public/assets/css/datatables.min.css') ?>" rel="stylesheet" />
    <link href="<?= url('public/assets/dist/css/demo.min.css') ?>" rel="stylesheet" />
    <link href="<?= url('public/assets/dist/css/tabler-flags.min.css') ?>" rel="stylesheet" />

    <!-- Icon -->
    <link rel="icon" type="image/png" href="<?= url('public/assets/img/logo-bpmp.webp') ?>" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        #filterRow input,
        #filterRow select {
            width: 100%;
        }

        #filterRow select option {
            white-space: pre-line;
        }

        .file-icons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .file-icon {
            font-size: 16px;
        }

        .more-files {
            font-size: 14px;
            color: #666;
        }



        dd {
            margin: 0;
            /* supaya rapi */
        }

        .step-indicator {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-bottom: 3px solid #ccc;
            cursor: pointer;
            transition: 0.2s;
        }


        .step-indicator:hover {
            background: #f8f9fa;
        }

        .step-indicator.active {
            border-color: #0d6efd;
            color: #0d6efd;
            font-weight: 600;
        }

        .step-indicator.disabled {
            color: #aaa;
            cursor: not-allowed;
        }

        .foto-upload {
            width: 100%;
            aspect-ratio: 3 / 4;
            /* ukuran portrait seperti KTP */
            border: 1px dashed #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            background: #f9f9f9;
            overflow: hidden;
            border-radius: 8px;
        }

        .foto-upload:hover {
            background: #f1f1f1;
        }

        .foto-upload span {
            color: #666;
            font-size: 13px;
            text-align: center;
            padding: 10px;
        }

        .foto-upload img {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        #btnHapusFoto {
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }

        .notif-dropdown {
            width: 360px;
            max-width: calc(100vw - 20px);
            overflow: hidden;
        }

        /* MOBILE */
        @media (max-width: 576px) {

            .notif-dropdown {
                position: fixed !important;

                top: 60px !important;
                left: 10px !important;
                right: 10px !important;

                width: auto !important;
                max-width: unset !important;
                min-width: unset !important;

                transform: none !important;
            }

            .notif-dropdown .card {
                width: 100%;
            }
        }

        .notif-dropdown .list-group-item,
        .notif-dropdown .text-body,
        .notif-dropdown .text-secondary {
            white-space: normal !important;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .notif-dropdown .col {
            min-width: 0;
        }

        .notif-list-scroll {
            max-height: 400px;
            overflow-y: auto;
        }

        @media (max-width: 576px) {
            .notif-list-scroll {
                max-height: 60vh;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js" integrity="sha512-axXaF5grZBaYl7qiM6OMHgsgVXdSLxqq0w7F4CQxuFyrcPmn0JfnqsOtYHUun80g6mRRdvJDrTCyL8LQqBOt/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.js" integrity="sha512-nNkHPz+lD0Wf0eFGO0ZDxr+lWiFalFutgVeGkPdVgrG4eXDYUnhfEj9Zmg1QkrJFLC0tGs8ZExyU/1mjs4j93w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body class="layout-fluid">
    <script src="<?= url('public/assets/dist/js/demo-theme.min.js') ?>"></script>

    <div class="page">
        <aside class="navbar navbar-vertical navbar-expand-lg sticky-top" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand">
                    S I P A D U
                </h1>
                <?php if ($_SESSION["user"]["role"] === "Admin") {
                    $bgRole = "bg-yellow text-yellow-fg";
                } elseif ($_SESSION["user"]["role"] === "Superadmin") {
                    $bgRole = "bg-red text-red-fg";
                } elseif ($_SESSION["user"]["role"] === "Pimpinan") {
                    $bgRole = "bg-orange text-orange-fg";
                } else {
                    $bgRole = "bg-secondary text-secondary-fg";
                } ?>
                <div class="navbar-nav flex-row d-lg-none">
                    <div class="nav-item dropdown d-lg-none  me-3">
                        <a href="#"
                            class="btn btn-icon text-black bg-white"
                            data-bs-toggle="dropdown"
                            aria-label="Show notifications">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                            </svg>
                            <span class="notif-count badge bg-red text-red-fg badge-notification badge-pill mt-2">0</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow p-0 notif-dropdown">
                            <div class="card">

                                <div class="card-header d-flex">
                                    <h3 class="card-title">Notifikasi</h3>
                                    <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                                </div>

                                <div class="notif-list notif-list-scroll list-group list-group-flush list-group-hoverable">
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
                    <div class="nav-item dropdown">
                        <a href="" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span
                                class="avatar avatar-sm"
                                style="background-image: url('<?= !empty($_SESSION['user']['foto_profile'])
                                                                    ? url($_SESSION['user']['foto_profile'])
                                                                    : url('public/assets/img/icon-profile.webp') ?>')">
                            </span>

                            <div class="d-none d-xl-block ps-2 text-white">
                                <div><?= htmlspecialchars($user['nama']) ?></div>
                                <div class="mt-1 small"><?= htmlspecialchars($user['username']) ?></div>
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
                            <?php if (
                                in_array($user['role'], ['Superadmin', 'Pimpinan', 'Admin'])
                            ): ?>
                                <a class="dropdown-item" href="<?= url('?page=dashboard&mode=staff') ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-inline me-1">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M16 3l4 4l-4 4" />
                                        <path d="M10 7l10 0" />
                                        <path d="M8 13l-4 4l4 4" />
                                        <path d="M4 17l9 0" />
                                    </svg>
                                    Dashboard Staff
                                </a>
                            <?php endif; ?>
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
                <?php
                // ----------------------------
                // Sidebar
                // ----------------------------
                require __DIR__ . '/sidebar.php';
                ?>
            </div>
        </aside>

        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none sticky-top bg-primary">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav flex-row order-md-first">
                    <div class="nav-item dropdown">

                    </div>
                </div>
                <div class="navbar-nav flex-row order-md-last me-2">
                    <div class="nav-item dropdown  me-3">
                        <a href="#"
                            class="btn btn-icon text-blue bg-white"
                            data-bs-toggle="dropdown"
                            aria-label="Show notifications">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                            </svg>
                            <span class="notif-count badge bg-red text-red-fg badge-notification badge-pill mt-2">0</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">

                                <div class="card-header d-flex">
                                    <h3 class="card-title">Notifikasi</h3>
                                    <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                                </div>

                                <div class="notif-list notif-list-scroll list-group list-group-flush list-group-hoverable">
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

                    <div class="nav-item dropdown">
                        <a href="" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span
                                class="avatar avatar-sm"
                                style="background-image: url('<?= !empty($_SESSION['user']['foto_profile'])
                                                                    ? url($_SESSION['user']['foto_profile'])
                                                                    : url('public/assets/img/icon-profile.webp') ?>')">
                            </span>

                            <div class="d-none d-xl-block ps-2 text-white">
                                <div><?= htmlspecialchars($user['nama']) ?></div>
                                <div class="mt-1 ">@<?= htmlspecialchars($user['username']) ?></div>
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
                            <?php if (
                                in_array($user['role'], ['Superadmin', 'Pimpinan', 'Admin'])
                            ): ?>
                                <a class="dropdown-item" href="<?= url('?page=dashboard&mode=staff') ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-inline me-1">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M16 3l4 4l-4 4" />
                                        <path d="M10 7l10 0" />
                                        <path d="M8 13l-4 4l4 4" />
                                        <path d="M4 17l9 0" />
                                    </svg>
                                    Dashboard Staff
                                </a>
                            <?php endif; ?>
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
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div>
                    </div>
                </div>
        </header>

        <div class="page-wrapper" style="background-image: url(<?= url('public/assets/img/vector.svg') ?>); background-repeat: repeat;">
            <div class="container container-slim my-auto" id="spinner" style="display:none;">
                <div class="text-center">
                    <div class=" mb-3">layout.loading</div>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
            </div>

            <?= $content ?>
        </div>

        <div class="modal fade" id="modalPilihRole" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Ganti Akses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <span class="mb-3 mt-0">Silakan pilih akses untuk diganti.</span>

                        <div class="row mt-3">
                            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                                <?php foreach ($pokjaList as $pokja): ?>

                                    <?php
                                    $active = ($currentPokja == $pokja['id']);
                                    ?>

                                    <?php if ($pokja["kode_role"] === "Admin") {
                                        $bgRole = "bg-yellow text-yellow-fg";
                                    } elseif ($pokja["kode_role"] === "Superadmin") {
                                        $bgRole = "bg-red text-red-fg";
                                    } elseif ($pokja["kode_role"] === "Pimpinan") {
                                        $bgRole = "bg-orange text-orange-fg";
                                    } else {
                                        $bgRole = "bg-secondary text-secondary-fg";
                                    } ?>

                                    <a href="<?= url('?page=switch-pokja&id=' . $pokja['id']) ?>"
                                        class="btn w-100 text-start <?= $active ? 'btn-primary' : 'btn-light border' ?>">

                                        <div class="fw-bold me-1">
                                            <?= htmlspecialchars($pokja['pokja_nama']) ?>
                                        </div>

                                        <small class="badge <?= $bgRole ?> ms-auto me-1">
                                            <?= htmlspecialchars($pokja['kode_role']) ?>
                                        </small>

                                    </a>

                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['flash'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    Swal.fire({
                        icon: '<?= $_SESSION['flash']['status'] ?>',
                        title: <?= $_SESSION['flash']['status'] === 'success'
                                    ? "'Berhasil!'"
                                    : "'Gagal!'" ?>,
                        text: <?= json_encode($_SESSION['flash']['message']) ?>,
                        timer: 3000,
                    });

                });
            </script>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <script>
            let lastCount = 0;

            function loadNotifCount() {
                fetch('index.php?page=notifikasi-unread-count')
                    .then(res => res.json())
                    .then(data => {

                        const current = parseInt(data.total);

                        document.querySelectorAll('.notif-count').forEach(el => {
                            el.innerText = current;

                            if (current == 0) {
                                el.style.display = 'none';
                            } else {
                                el.style.display = 'inline-block';
                            }
                        });

                        if (current == 0) {
                            document.getElementById('notif-count').style.display = 'none';
                        } else {
                            document.getElementById('notif-count').style.display = 'inline-block';
                        }

                        // Kalau ada perubahan → reload list
                        if (current !== lastCount) {
                            loadNotifList();
                            lastCount = current;
                        }
                    });
            }

            function loadNotifList() {
                fetch('index.php?page=notifikasi-list')
                    .then(res => res.json())
                    .then(data => {

                        let html = '';

                        if (data.length === 0) {
                            html = `
                    <div class="list-group-item text-center text-muted">
                        Tidak ada notifikasi
                    </div>
                `;
                        } else {
                            data.forEach(function(item) {

                                html += `
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            ${item.is_read == 0 
                                                ? '<span class="status-dot status-dot-animated bg-red d-block"></span>' 
                                                : '<span class="status-dot d-block"></span>'}
                                        </div>

                                        <div class="col text-truncate">
                                            <a href="${item.url || '#'}"
                                            class="text-body d-block"
                                            onclick="handleNotifClick(
                                                event,
                                                ${item.notif_id},
                                                '${item.url || '#'}'
                                            )">
                                                ${item.judul}
                                            </a>
                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                ${item.pesan}
                                            </div>
                                            <div class="text-secondary small">
                                                ${item.created_at}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            });
                        }

                        document.querySelectorAll('.notif-list').forEach(el => {
                            el.innerHTML = html;
                        });
                    });
            }

            function markAsRead(id) {
                fetch('index.php?page=notifikasi-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id
                }).then(() => {
                    loadNotifCount();
                    loadNotifList();
                });
            }

            function markAllRead() {
                fetch('index.php?page=notifikasi-read-all', {
                    method: 'POST'
                }).then(() => {
                    loadNotifCount();
                    loadNotifList();
                });
            }

            function handleNotifClick(e, id, url) {
                e.preventDefault(); // STOP redirect dulu

                fetch('index.php?page=notifikasi-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id
                }).then(() => {
                    window.location.href = url; // redirect setelah update
                });
            }

            // reload setiap 10 detik
            setInterval(loadNotifCount, 10000);

            // load awal
            loadNotifCount();
            loadNotifList();
        </script>




        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </div>

    <script src="<?= url('public/assets/dist/libs/list.js/dist/list.min.js') ?>" defer=""></script>
    <script src="<?= url('public/assets/dist/libs/apexcharts/dist/apexcharts.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/tabler.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/datatables.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/datatables.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/dist/libs/tom-select/dist/js/tom-select.base.min.js') ?>" defer></script>

</body>

</html>