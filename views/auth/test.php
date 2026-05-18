<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi 2 Langkah - Aplikasi Pesona</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        }

        .card-login {
            width: 100%;
            max-width: 450px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="card card-login bg-white">
        <div class="card-body p-5 text-center">

            <h1 class="h4 text-gray-900 mb-4">Keamanan 2 Langkah (2FA)</h1>

            <div class="alert alert-warning small">
                <b>Setup Pertama Kali:</b> Buka aplikasi Google Authenticator di HP Anda, lalu Scan QR Code di bawah ini.
            </div>
            <img src="<?= $qrCodeUrl ?>" alt="QR Code" class="mb-3 border p-2 rounded">
            <p class="small text-muted">Atau masukkan kunci ini secara manual:<br><b><?= $secret ?></b></p>
            <i class="fas fa-mobile-alt fa-4x text-primary mb-4"></i>
            <p class="text-muted small">Buka aplikasi Google Authenticator di HP Anda dan masukkan 6 digit kode yang muncul.</p>

            <div class="alert alert-danger small">Kode tidak valid atau sudah kedaluwarsa.</div>

            <form method="POST">
                <div class="form-group">
                    <input type="text" name="otp_code" class="form-control text-center text-lg" placeholder="Masukkan 6 Digit Kode" maxlength="6" required autofocus autocomplete="off" style="font-size: 1.5rem; letter-spacing: 5px;">
                </div>
                <button type="submit" name="verify" class="btn btn-primary btn-block shadow-sm py-2">
                    Verifikasi Kode
                </button>
            </form>

            <hr>
            <a href="login.php" class="small text-danger">Batal & Kembali ke Login</a>

        </div>
    </div>

</body>

</html>