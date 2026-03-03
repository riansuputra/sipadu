<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Edit User";





// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';

// $plain = "halo123"; // password asli
// $hash = $data['password_hash'];

// if (password_verify("123456", $hash)) {
//     echo "Password cocok!";
// } else {
//     echo "Password salah.";
// }

// echo '</pre>';


$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">User</div>
                <h2 class="page-title">Edit User</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="?page=user-update" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit User</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-fieldset">
                                <input type="text" id="id" name="id" hidden value="<?= $data['id'] ?>">

                                <div class="mb-3">
                                    <label class="form-label required">Nama Lengkap : </label>
                                    <input
                                        type="text"
                                        name="nama_lengkap"
                                        id="nama_lengkap"
                                        placeholder="Nama Lengkap..."
                                        value="<?= $data['nama_lengkap'] ?? $old['nama_lengkap'] ?? '' ?>"
                                        class="form-control <?= isset($errors['nama_lengkap']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['nama_lengkap'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Username : </label>
                                    <input
                                        type="text"
                                        name="username"
                                        id="username"
                                        placeholder="Username..."
                                        value="<?= $data['username'] ?? $old['username'] ?? '' ?>"
                                        class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" autocomplete="off" readonly>
                                    <div class="invalid-feedback">
                                        <?= $errors['username'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Password :</label>
                                    <div class="input-group input-group-flat">
                                        <input type="password" id="password_baru" name="password_baru" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Masukkan kata sandi..." autocomplete="off">
                                        <span class="input-group-text" id="togglePassword">
                                            <a class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Lihat sandi"><!-- Download SVG icon from http://tabler.io/icons/icon/eye -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                                </svg></a>
                                        </span>
                                        <div class="invalid-feedback">
                                            <?= $errors['password'] ?? '' ?>
                                        </div>
                                    </div>
                                    <small class="form-hint">
                                        Kosongkan jika tidak ingin diubah.
                                    </small>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label required">Role :</label>
                                                <select class="form-select <?= isset($errors['role_id']) ? 'is-invalid' : '' ?>" name="role_id" id="role_id">

                                                    <?php $selectedRole = $old['role_id'] ?? $data['role_id'] ?? ''; ?>

                                                    <option value="" disabled <?= empty($selectedRole) ? 'selected' : '' ?>>
                                                        -- Pilih Role --
                                                    </option>

                                                    <?php foreach ($roles as $j): ?>

                                                        <?php
                                                        // skip superadmin
                                                        if ($j['kode_role'] === 'Superadmin') continue;
                                                        ?>

                                                        <option value="<?= $j['id'] ?>"
                                                            data-kode="<?= $j['kode_role'] ?>"
                                                            <?= $selectedRole == $j['id'] ? 'selected' : '' ?>>
                                                            <?= $j['nama_role'] ?>
                                                        </option>

                                                    <?php endforeach; ?>

                                                </select>


                                                <div class="invalid-feedback">
                                                    <?= $errors['role_id'] ?? '' ?>
                                                </div>

                                            </div>
                                            <div class="col">
                                                <label class="form-label">Tim / Unit :</label>
                                                <select class="form-select <?= isset($errors['pokja_id']) ? 'is-invalid' : '' ?>" name="pokja_id" id="pokja_id">

                                                    <?php $selectedPokja = $old['pokja_id'] ?? $data['pokja_id'] ?? ''; ?>

                                                    <option value="" disabled <?= empty($selectedPokja) ? 'selected' : '' ?>>
                                                        -- Pilih Tim/Unit --
                                                    </option>

                                                    <?php foreach ($pokja as $j): ?>
                                                        <option value="<?= $j['id'] ?>"
                                                            <?= $selectedPokja == $j['id'] ? 'selected' : '' ?>>
                                                            <?= $j['pokja_tipe'] ?> <?= $j['pokja_nama'] ?>
                                                        </option>
                                                    <?php endforeach; ?>

                                                </select>

                                                <div class="invalid-feedback">
                                                    <?= $errors['pokja_id'] ?? '' ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="card" id="preview-card" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Preview File</h3>
                    </div>

                    <div class="card-body">
                        <div id="preview-list"></div>
                    </div>
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
    document.addEventListener("DOMContentLoaded", function() {

        const roleSelect = document.getElementById("role_id");
        const pokjaSelect = document.getElementById("pokja_id");

        function togglePokja() {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const kodeRole = selectedOption.getAttribute("data-kode");

            if (kodeRole === "Pimpinan") {
                pokjaSelect.disabled = true;
                pokjaSelect.value = ""; // reset pilihan
            } else {
                pokjaSelect.disabled = false;
            }
        }

        // Jalankan saat load (edit mode)
        togglePokja();

        // Jalankan saat role berubah
        roleSelect.addEventListener("change", togglePokja);
    });
</script>

<?php if (isset($_SESSION['flash'])): ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let status = <?= json_encode($_SESSION['flash']['status']) ?>;
            let message = <?= json_encode($_SESSION['flash']['message']) ?>;

            if (status === 'success') {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                    timer: 1000,
                    showConfirmButton: false,
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    timer: 1500,
                    html: message
                });

            }

        });
    </script>

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordInput = $('#password_baru');
            if (passwordInput.attr('type') === 'password_baru') {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password_baru');
            }
        });
    });
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
