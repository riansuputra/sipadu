<?php
// ================================
// LAYOUT UTAMA APLIKASI
// ================================
$headerImage = $headerImage ?? url('public/assets/img/banner.webp');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- Title -->
    <title><?= $title ?> - SIPADU</title>

    <!-- CSS Global  -->
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

        .header-banner {
            background-image: url('<?= $headerImage ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 200px;

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

        }

        /* overlay biar teks kebaca */
        .header-banner::before {
            content: "";
            position: absolute;
            inset: 0;
        }

        /* icon pojok kiri atas */
        .banner-icon {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 3;

            width: 48px;
            height: 48px;

            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-icon img {
            max-width: 70%;
            max-height: 70%;
            object-fit: contain;
        }

        .banner-logo {
            position: absolute;
            top: 15px;
            left: 20px;
            z-index: 3;

            max-width: 260px;
            /* batas lebar logo */
            height: 50px;
            /* tinggi konsisten */

            display: flex;
            align-items: center;
        }

        .banner-logo img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        /* konten tengah */
        .banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .banner-title {
            font-size: 50px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 0 8px rgba(0, 0, 0, 0.35);
        }

        .banner-subtitle {
            font-size: 16px;
            font-weight: 500;
            margin-top: 5px;
            text-shadow: 0 0 8px rgba(0, 0, 0, 0.35);
        }


        .row-evenly {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
        }

        .file-name {
            max-width: 220px;
            /* atur lebar kolom */
            white-space: normal;
            /* boleh turun baris */
            word-break: break-word;
            /* potong kata panjang */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js" integrity="sha512-axXaF5grZBaYl7qiM6OMHgsgVXdSLxqq0w7F4CQxuFyrcPmn0JfnqsOtYHUun80g6mRRdvJDrTCyL8LQqBOt/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.js" integrity="sha512-nNkHPz+lD0Wf0eFGO0ZDxr+lWiFalFutgVeGkPdVgrG4eXDYUnhfEj9Zmg1QkrJFLC0tGs8ZExyU/1mjs4j93w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script src="<?= url('public/assets/dist/js/demo-theme.min.js') ?>"></script>

    <div class="page">

        <!-- Header Banner SIPADU -->

        <?php
        // ----------------------------
        // HEADER (hanya jika login)
        // ----------------------------
        if (isLoggedIn()) {
            require __DIR__ . '/header.php';
        }
        ?>

        <header class="navbar navbar-expand-md d-print-none header-banner">
            <!-- teks tengah -->
            <div class="banner-content">
                <h1 class="banner-title"><?= $bannerTitle ?></h1>
                <hr class="m-0">
                <div class="banner-subtitle"><?= $bannerSubtitle ?></div>
            </div>
        </header>


        <div class="page-wrapper" style="background-image: url(<?= url('public/assets/img/vector.svg') ?>); background-repeat: repeat;">

            <!-- Loader -->
            <div class="container container-slim my-auto" id="spinner" style="display:none;">
                <div class="text-center">
                    <div class=" mb-3">loading</div>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
            </div>

            <!-- Isi konten -->
            <?= $content ?>
        </div>

        <?php
        // ----------------------------
        // FOOTER
        // ----------------------------
        require __DIR__ . '/footer.php';
        ?>
    </div>

    <!-- JS Global -->
    <script src="<?= url('public/assets/dist/libs/list.js/dist/list.min.js') ?>" defer=""></script>
    <script src="<?= url('public/assets/dist/libs/apexcharts/dist/apexcharts.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/tabler.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/datatables.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/datatables.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/dist/libs/tom-select/dist/js/tom-select.base.min.js') ?>" defer></script>
</body>

</html>