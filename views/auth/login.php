<?php
// ================================
// LAYOUT UTAMA APLIKASI
// ================================
$title = "Masuk";

$headerImage = $headerImage ?? 'http://localhost/sipadu/public/assets/img/banner.webp';
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
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/img/logo-bpmp.webp" />

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .login-photo {
            position: relative;
            min-height: 100vh;
        }

        .login-bg {
            background-size: cover;
            background-position: center;
            height: 100%;
            min-height: 100vh;
        }

        /* overlay bawah */
        .login-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;

            height: 18%;
            /* ±30% tinggi gambar */
            padding: 32px;

            background: linear-gradient(to top,
                    rgba(6, 111, 209, 0.85),
                    rgba(6, 111, 209, 0.65));

            display: flex;
            flex-direction: column;
            justify-content: center;

            color: #fff;
        }

        /* judul */
        .login-title {
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 8px;
            font-style: italic;
            letter-spacing: 0.5px;

            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
        }

        /* subtitle */
        .login-subtitle {
            font-size: 20px;
            max-width: 520px;
            line-height: 1.5;

            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.35);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js" integrity="sha512-axXaF5grZBaYl7qiM6OMHgsgVXdSLxqq0w7F4CQxuFyrcPmn0JfnqsOtYHUun80g6mRRdvJDrTCyL8LQqBOt/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.js" integrity="sha512-nNkHPz+lD0Wf0eFGO0ZDxr+lWiFalFutgVeGkPdVgrG4eXDYUnhfEj9Zmg1QkrJFLC0tGs8ZExyU/1mjs4j93w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column bg-white">
    <script src="<?= BASE_URL ?>/public/assets/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="row g-0 flex-fill">

        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <div class="login-photo">
                <!-- background foto -->
                <div class="login-bg"
                    style="background-image: url(http://localhost/sipadu/public/assets/img/login-img.webp)">
                </div>
                <!-- overlay bawah -->
                <div class="login-overlay">
                    <p class="login-subtitle mb-4">
                        Selamat Datang di Laman SIPADU
                    </p>
                    <h1 class="login-title">Sistem Pengarsipan Dokumen Terpadu</h1>
                    <hr class="mb-1 mt-1">
                    <p class="login-subtitle">
                        Balai Penjaminan Mutu Pendidikan Provinsi Bali
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl-4 border-top-wide d-flex flex-column justify-content-center">
            <div class="container container-tight mb-7 px-lg-5">
                <div class="text-center mb-4">
                    <img src="http://localhost/sipadu/public/assets/img/bpmp-tengah.webp" alt="" style="height: 150px; width: auto;">
                </div>
                <hr>
                <h2 class="h3 text-center mb-5">Masuk ke SIPADU</h2>
                <form action="<?= BASE_URL ?>/?page=login-process" method="post" autocomplete="off" novalidate="">
                    <div class="mb-3">
                        <label class="form-label">Nama Pengguna</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan nama pengguna..." autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Kata Sandi
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi..." autocomplete="off">
                            <span class="input-group-text" id="togglePassword">
                                <a class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Lihat sandi"><!-- Download SVG icon from http://tabler.io/icons/icon/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                    </svg></a>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        &nbsp;
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </div>
                </form>
                <hr class="mt-5">
            </div>
        </div>
    </div>

    <!-- JS Global -->
    <script src="<?= BASE_URL ?>/public/assets/dist/libs/list.js/dist/list.min.js?1759774804" defer=""></script>
    <script src="<?= BASE_URL ?>/public/assets/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/tabler.min.js?1684106062" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062" defer></script>

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
</body>

</html>