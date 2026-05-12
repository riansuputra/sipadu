<?php
// ================================
// LAYOUT UTAMA APLIKASI
// ================================
$title = "Masuk";

$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

// dd($pokjaList);

// 🔥 HAPUS SETELAH DIPAKAI
unset($_SESSION['errors'], $_SESSION['old']);

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
            font-size: 30px;
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

<body class="d-flex flex-column bg-white" style="background-image: url(public/assets/img/vector.svg); background-repeat: repeat;">
    <script src="<?= url('public/assets/dist/js/demo-theme.min.js') ?>"></script>
    <div class="row g-0 flex-fill">

        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <div class="login-photo">
                <!-- background foto -->
                <div class="login-bg"
                    style="background-image: url(public/assets/img/tests.webp)">
                </div>
                <!-- overlay bawah -->
                <div class="login-overlay">
                    <p class="login-subtitle mb-1">
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
            <div class="container container-tight mb-7">
                <div class="text-center mb-4">
                    <img src="public/assets/img/bpmp-tengah.webp" alt="" style="height: 150px; width: auto;">
                </div>
                <div class="card">
                    <div class="card-body text-center">

                        <h2 class="h3 text-center mb-0">Selamat datang, <?= htmlspecialchars($_SESSION['user']['nama']) ?> !</h2>
                        <span class="mb-3">Silakan pilih akses untuk melanjutkan ke sistem.</span>

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
    </div>

    <!-- JS Global -->
    <script src="<?= url('public/assets/dist/libs/list.js/dist/list.min.js') ?>" defer=""></script>
    <script src="<?= url('public/assets/dist/libs/apexcharts/dist/apexcharts.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/js/tabler.min.js') ?>" defer></script>
    <script src="<?= url('public/assets/dist/libs/tom-select/dist/js/tom-select.base.min.js') ?>" defer></script>

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