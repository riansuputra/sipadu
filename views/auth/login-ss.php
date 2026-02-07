<?php
// ================================
// LAYOUT UTAMA APLIKASI
// ================================
$headerImage = $headerImage ?? 'http://localhost/sipadu/public/assets/img/banner.svg';
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
    <link href="<?= BASE_URL ?>/public/assets/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="<?= BASE_URL ?>/public/assets/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="<?= BASE_URL ?>/public/assets/dist/css/demo.min.css?1684106062" rel="stylesheet" />
    <link href="<?= BASE_URL ?>/public/assets/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />

    <!-- Icon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/img/logo-bpmp.png" />

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

            color: #fff;
        }

        /* overlay biar teks kebaca */
        .header-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
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
            text-shadow: 0 0 6px rgba(0, 0, 0, 0.35);
        }

        .banner-subtitle {
            font-size: 14px;
            font-weight: 500;
            margin-top: 5px;
            text-shadow: 0 0 6px rgba(0, 0, 0, 0.35);
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
    <div class="page page-center">
        <div class="container container-normal">
            <div class="row align-items-center">
                <div class="row row-deck row-cards">

                    <div class="col-sm-12 col-lg-4 m-0 p-0">
                        <div class="card card-lg">
                            <div class="card-body">
                                <h2 class=" h2 text-center mb-4">Login to your account</h2>
                                <form action="./" method="get" autocomplete="off" novalidate="">
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" placeholder="your@email.com" autocomplete="off">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Password
                                            <span class="form-label-description">
                                                <a href="./forgot-password.html">I forgot password</a>
                                            </span>
                                        </label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" class="form-control" placeholder="Your password" autocomplete="off">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password"><!-- Download SVG icon from http://tabler.io/icons/icon/eye -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                                    </svg></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input">
                                            <span class="form-check-label">Remember me on this device</span>
                                        </label>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-8 m-0 p-0">
                        <img src="http://localhost/sipadu/public/assets/img/images.jpg" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        $(document).ready(function() {
            $('#togglePassword').click(function() {
                var passwordInput = $('#password');
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                } else {
                    passwordInput.attr('type', 'password');
                }
            });
        });
    </script>

    <div class="page-wrapper">

        <!-- Loader -->
        <div class="container container-slim my-auto" id="spinner" style="display:none;">
            <div class="text-center">
                <div class=" mb-3">loading</div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-indeterminate"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Global -->
    <script src="<?= BASE_URL ?>/public/assets/dist/libs/list.js/dist/list.min.js?1759774804" defer=""></script>
    <script src="<?= BASE_URL ?>/public/assets/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/tabler.min.js?1684106062" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062" defer></script>
</body>

</html>