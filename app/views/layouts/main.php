<?php
$headerImage = $headerImage ?? 'assets/img/banner.jpg';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= $title ?> | SIPADU</title>
    <link href="assets/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="assets/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="assets/dist/css/demo.min.css?1684106062" rel="stylesheet" />
    <link href="assets/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/img/logo-bpmp.png" />
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
            /* penting */
            background-position: center;
            /* penting */
            background-repeat: no-repeat;
            height: 220px;
            /* sesuaikan */
        }

        .row-evenly {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js" integrity="sha512-axXaF5grZBaYl7qiM6OMHgsgVXdSLxqq0w7F4CQxuFyrcPmn0JfnqsOtYHUun80g6mRRdvJDrTCyL8LQqBOt/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.js" integrity="sha512-nNkHPz+lD0Wf0eFGO0ZDxr+lWiFalFutgVeGkPdVgrG4eXDYUnhfEj9Zmg1QkrJFLC0tGs8ZExyU/1mjs4j93w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="layout-fluid">
    <script src="assets/dist/js/demo-theme.min.js?1684106062"></script>

    <div class="page">
        <header class="navbar navbar-expand-md d-print-none header-banner">

        </header>


        <div class="page-wrapper">
            <div class="container container-slim my-auto" id="spinner" style="display:none;">
                <div class="text-center">
                    <div class=" mb-3">loading</div>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
            </div>
            <?= $content ?>
        </div>

        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Copyright © 2026
                                <a href="https://bpmpbali.kemendikdasmen.go.id/" target="_blank" rel="noopener noreferrer" class="link-primary">BPMP Provinsi Bali</a>. All rights reserved.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="assets/dist/libs/list.js/dist/list.min.js?1759774804" defer=""></script>
    <script src="assets/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
    <script src="assets/js/tabler.min.js?1684106062" defer></script>
    <script src="assets/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062" defer></script>

</body>

</html>