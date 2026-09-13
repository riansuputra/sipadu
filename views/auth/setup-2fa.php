<?php
// ================================
// LAYOUT UTAMA APLIKASI
// ================================
$title = "Masuk";

$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

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
            <div class="container container-tight">

                <!-- Logo -->
                <div class="text-center mb-2">
                    <img
                        src="public/assets/img/bpmp-tengah.webp"
                        alt="Logo BPMP Bali"
                        style="height: 120px; width: auto;">
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">

                        <!-- Heading -->
                        <div class="text-center mb-2">

                            <h3 class="mb-0">
                                Aktivasi Google Authenticator
                            </h3>
                            <a href="#"
                                class="h6 text-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modalPanduan2FA">
                                Cara Aktivasi ?
                            </a>


                        </div>

                        <!-- QR -->
                        <div class="text-center mb-2">

                            <img
                                src="<?= $qrCodeUrl ?>"
                                alt="QR Code Google Authenticator"
                                class="img-fluid rounded border p-2 bg-white"
                                style="max-width: 190px;">

                        </div>
                        <!-- Secret Manual -->
                        <!-- <div class="mb-2">

                            <label class="form-label fw-bold">
                                Kode Manual
                            </label>

                            <div class="input-group">

                                <input
                                    type="text"
                                    class="form-control"
                                    id="secretCode"
                                    value="<?= $secret ?>"
                                    readonly>

                                <button
                                    type="button"
                                    class="btn btn-outline-primary"
                                    onclick="copySecretCode()">
                                    <i class="ti ti-copy"></i>
                                    Copy
                                </button>

                            </div>

                            <small class="text-secondary">
                                Gunakan kode ini jika QR Code tidak dapat discan.
                            </small>

                        </div> -->
                        <hr class="mb-2 mt-2">

                        <!-- OTP FORM -->
                        <form
                            method="POST"
                            action="<?= url('?page=verify-setup-2fa') ?>">

                            <div class="mb-3">

                                <label class="form-label fw-bold text-center w-100 mb-3">
                                    Masukkan Kode OTP
                                </label>

                                <!-- hidden input untuk submit -->
                                <input
                                    type="hidden"
                                    name="otp_code"
                                    id="otp_code">

                                <div class="my-2">

                                    <div class="row g-4">

                                        <!-- 3 digit kiri -->
                                        <div class="col">

                                            <div class="row g-2">

                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-lg text-center otp-input"
                                                        maxlength="1"
                                                        inputmode="numeric"
                                                        pattern="[0-9]*"
                                                        autocomplete="one-time-code">
                                                </div>

                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-lg text-center otp-input"
                                                        maxlength="1"
                                                        inputmode="numeric"
                                                        pattern="[0-9]*">
                                                </div>

                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-lg text-center otp-input"
                                                        maxlength="1"
                                                        inputmode="numeric"
                                                        pattern="[0-9]*">
                                                </div>

                                            </div>

                                        </div>

                                        <!-- 3 digit kanan -->
                                        <div class="col">

                                            <div class="row g-2">

                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-lg text-center otp-input"
                                                        maxlength="1"
                                                        inputmode="numeric"
                                                        pattern="[0-9]*">
                                                </div>

                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-lg text-center otp-input"
                                                        maxlength="1"
                                                        inputmode="numeric"
                                                        pattern="[0-9]*">
                                                </div>

                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-lg text-center otp-input"
                                                        maxlength="1"
                                                        inputmode="numeric"
                                                        pattern="[0-9]*">
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <small class="text-secondary d-block text-center">
                                    Masukkan 6 digit kode dari Google Authenticator.
                                </small>

                            </div>

                            <div class="btn-list flex-nowrap">
                                <a
                                    href="<?= url('?page=cancel-2fa') ?>"
                                    class="btn btn-outline-secondary w-100">
                                    Batalkan Login
                                </a>
                                <button type="submit" class="btn btn-primary btn-3 w-100"> Aktivasi </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL PANDUAN -->
        <div
            class="modal modal-blur fade"
            id="modalPanduan2FA"
            tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Cara Aktivasi Google Authenticator
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-3">
                            Hubungkan akun SIPADU Anda dengan Google Authenticator
                            untuk meningkatkan keamanan login.
                        </p>

                        <ol class="mb-0 ps-3">

                            <li class="mb-3">
                                Install aplikasi
                                <strong>Google Authenticator</strong>
                                di HP Anda melalui Play Store atau App Store.
                            </li>

                            <li class="mb-3">
                                Buka aplikasi lalu pilih
                                <strong>Tambah Akun</strong>.
                            </li>

                            <li class="mb-3">
                                Scan QR Code yang tersedia pada halaman ini.
                            </li>

                            <li class="mb-3">
                                Jika QR Code tidak dapat discan,
                                gunakan <strong>Kode Manual</strong>.
                            </li>

                            <li>
                                Masukkan 6 digit kode OTP yang muncul
                                untuk menyelesaikan aktivasi.
                            </li>

                        </ol>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal">
                            Saya Mengerti
                        </button>

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

    <?php if (isset($_SESSION['flash'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: '<?= $_SESSION['flash']['status'] ?>',
                    title: <?= $_SESSION['flash']['status'] === 'success'
                                ? "'Berhasil!'"
                                : "'Gagal!'" ?>,
                    text: <?= json_encode($_SESSION['flash']['message']) ?>,
                    timer: 5000,
                });

            });
        </script>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <script>
        function copySecretCode() {

            const input = document.getElementById('secretCode');

            navigator.clipboard.writeText(input.value);

            Swal.fire({
                icon: 'success',
                title: 'Berhasil disalin',
                text: 'Kode manual berhasil disalin.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
    <script>
        // =========================
        // OTP INPUT HANDLER
        // =========================

        const otpInputs = document.querySelectorAll('.otp-input');
        const hiddenOtp = document.getElementById('otp_code');

        otpInputs.forEach((input, index) => {

            // hanya angka
            input.addEventListener('input', (e) => {

                input.value = input.value.replace(/[^0-9]/g, '');

                // pindah otomatis ke next input
                if (input.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                updateOtpValue();
            });

            // backspace pindah ke kiri
            input.addEventListener('keydown', (e) => {

                if (
                    e.key === 'Backspace' &&
                    !input.value &&
                    index > 0
                ) {
                    otpInputs[index - 1].focus();
                }

            });

            // paste full OTP
            input.addEventListener('paste', (e) => {

                e.preventDefault();

                const pastedData = (
                        e.clipboardData || window.clipboardData
                    )
                    .getData('text')
                    .replace(/\D/g, '')
                    .slice(0, 6);

                pastedData.split('').forEach((char, i) => {

                    if (otpInputs[i]) {
                        otpInputs[i].value = char;
                    }

                });

                updateOtpValue();

                // fokus ke terakhir
                const lastIndex = pastedData.length - 1;

                if (otpInputs[lastIndex]) {
                    otpInputs[lastIndex].focus();
                }

            });

        });

        // =========================
        // GABUNGKAN OTP KE HIDDEN INPUT
        // =========================

        function updateOtpValue() {

            let otp = '';

            otpInputs.forEach(input => {
                otp += input.value;
            });

            hiddenOtp.value = otp;
        }
    </script>
</body>

</html>