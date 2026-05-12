<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah User";





// Mulai buffer konten
ob_start();
?>


<?php
// dd($pegawai);
// echo '<pre>';
// print_r($roles);
// print_r($pokja);
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
                <h2 class="page-title">Tambah User</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" method="POST" action="?page=user-store" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah User</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-fieldset">

                                <div class="mb-3">
                                    <label class="form-label">Pilih Pegawai :</label>

                                    <!-- hidden value -->
                                    <input
                                        type="hidden"
                                        name="pegawai_id"
                                        id="pegawai_id"
                                        value="<?= $old['pegawai_id'] ?? $data['pegawai_id'] ?? '' ?>">

                                    <!-- tampilan -->
                                    <input
                                        type="text"
                                        id="pegawai_display"
                                        class="form-control <?= isset($errors['pegawai_id']) ? 'is-invalid' : '' ?>"
                                        placeholder="Pilih Pegawai..."
                                        readonly
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPilihPegawai"
                                        value="<?= $data['pegawai_nama'] ?? '' ?>">

                                    <div class="invalid-feedback">
                                        <?= $errors['pegawai_id'] ?? '' ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Nama Lengkap : </label>
                                    <input
                                        type="text"
                                        name="nama_lengkap"
                                        id="nama_lengkap"
                                        placeholder="Nama Lengkap..."
                                        value="<?= $old['nama_lengkap'] ?? '' ?>"
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
                                        value="<?= $old['username'] ?? '' ?>"
                                        class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= $errors['username'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Password :</label>
                                    <div class="input-group input-group-flat">
                                        <input type="password" id="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Masukkan kata sandi..." autocomplete="off">
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
                                </div>

                                <div class="">
                                    <label class="form-label mb-0">
                                        Akses Pokja & Role
                                    </label>

                                    <div class="table-responsive">
                                        <table id="pokjaTable"
                                            class="table table-bordered table-hover bg-white">

                                            <thead>
                                                <tr>
                                                    <th class="w-1">
                                                        <input type="checkbox" id="checkAll">
                                                    </th>

                                                    <th>Pokja</th>

                                                    <th width="220">
                                                        Role
                                                    </th>

                                                    <th class="w-1 text-center">
                                                        Default
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php foreach ($pokja as $p): ?>

                                                    <?php
                                                    $checked = in_array(
                                                        $p['id'],
                                                        $old['pokja_ids'] ?? []
                                                    );

                                                    $selectedRole =
                                                        $old['role_per_pokja'][$p['id']]
                                                        ?? '';
                                                    ?>

                                                    <tr>

                                                        <!-- CHECKBOX -->
                                                        <td>
                                                            <input
                                                                class="form-check-input pokja-checkbox"
                                                                type="checkbox"
                                                                name="pokja_ids[]"
                                                                value="<?= $p['id'] ?>"
                                                                id="pokja_<?= $p['id'] ?>"
                                                                <?= $checked ? 'checked' : '' ?>>
                                                        </td>

                                                        <!-- NAMA -->
                                                        <td>
                                                            <label
                                                                for="pokja_<?= $p['id'] ?>"
                                                                class="mb-0">

                                                                <?= $p['pokja_tipe'] ?>
                                                                <?= $p['pokja_nama'] ?>

                                                            </label>
                                                        </td>

                                                        <!-- ROLE -->
                                                        <td>

                                                            <select
                                                                class="form-select role-select"
                                                                name="role_per_pokja[<?= $p['id'] ?>]"
                                                                data-pokja="<?= $p['id'] ?>">

                                                                <option value="">
                                                                    -- Pilih Role --
                                                                </option>

                                                                <?php foreach ($roles as $r): ?>



                                                                    <option
                                                                        value="<?= $r['id'] ?>"
                                                                        <?= ($selectedRole == $r['id']) ? 'selected' : '' ?>>

                                                                        <?= $r['nama_role'] ?>

                                                                    </option>

                                                                <?php endforeach; ?>

                                                            </select>

                                                            <?php if (!empty($errors['role_' . $p['id']])): ?>
                                                                <small class="text-danger">
                                                                    <?= $errors['role_' . $p['id']] ?>
                                                                </small>
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- DEFAULT -->
                                                        <td class="text-center">

                                                            <input
                                                                class="form-check-input pokja-default"
                                                                type="radio"
                                                                name="pokja_default"
                                                                value="<?= $p['id'] ?>"
                                                                <?= (($old['pokja_default'] ?? '') == $p['id']) ? 'checked' : '' ?>>

                                                        </td>

                                                    </tr>

                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <small class="text-muted">
                                        Pilih pokja, tentukan role pada masing-masing pokja,
                                        lalu pilih salah satu sebagai default.
                                    </small>

                                    <?php if (!empty($errors['pokja_ids'])): ?>
                                        <div class="text-danger mt-1">
                                            <?= $errors['pokja_ids'] ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($errors['pokja_default'])): ?>
                                        <div class="text-danger mt-1">
                                            <?= $errors['pokja_default'] ?>
                                        </div>
                                    <?php endif; ?>

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

<div class="modal fade" id="modalPilihPegawai" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pilih Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- search -->
                <input
                    type="text"
                    class="form-control mb-3"
                    id="searchPegawai"
                    placeholder="Cari nama / NIP / jabatan...">

                <!-- list -->
                <div class="list-group" id="listPegawai" style="max-height: 400px; overflow-y:auto;">

                    <?php foreach ($pegawai as $p): ?>
                        <label class="list-group-item pegawai-item cursor-pointer">
                            <div class="d-flex align-items-center">

                                <!-- RADIO (fix bug disini) -->
                                <input
                                    class="form-check-input me-3 pegawai-radio"
                                    type="radio"
                                    name="pegawai_radio"
                                    value="<?= $p['id'] ?>"
                                    data-nama="<?= htmlspecialchars($p['nama']) ?>"
                                    data-nip="<?= htmlspecialchars($p['nip']) ?>">

                                <div class="flex-fill">
                                    <div class="fw-semibold">
                                        <?= htmlspecialchars($p['nama'] ?? '-')  ?>
                                    </div>

                                    <small class="text-muted d-block">
                                        NIP: <?= htmlspecialchars($p['nip'] ?? '-')  ?>
                                    </small>

                                    <small class="text-muted d-block">
                                        Jabatan: <?= htmlspecialchars($p['nama_jabatan'] ?? '-')  ?>
                                    </small>
                                </div>

                            </div>
                        </label>
                    <?php endforeach; ?>

                </div>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const hiddenInput = document.getElementById('pegawai_id');
        const displayInput = document.getElementById('pegawai_display');

        // pilih pegawai
        document.querySelectorAll('.pegawai-radio').forEach(radio => {
            radio.addEventListener('change', function() {

                let id = this.value;
                let nama = this.dataset.nama;

                hiddenInput.value = id;
                displayInput.value = nama;

                // tutup modal otomatis
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalPilihPegawai'));
                modal.hide();
            });
        });

        // search
        document.getElementById('searchPegawai').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            let items = document.querySelectorAll('#listPegawai .pegawai-item');

            items.forEach(item => {
                let text = item.innerText.toLowerCase();
                item.style.display = text.includes(keyword) ? '' : 'none';
            });
        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        new DataTable('#pokjaTable', {
            paging: false,
            searching: false,
            info: false,
            lengthChange: false,
            ordering: false
        });

    });
</script>

<script>
    document.getElementById("checkAll").addEventListener("click", function() {

        const checkboxes = document.querySelectorAll("input[name='pokja_ids[]']");

        checkboxes.forEach(cb => {
            cb.checked = this.checked;

            const radio = document.querySelector("input[name='pokja_default'][value='" + cb.value + "']");

            if (!this.checked) {
                radio.checked = false;
            }
        });

        // kalau check all → set default ke pertama
        if (this.checked) {
            const first = checkboxes[0];
            const firstRadio = document.querySelector("input[name='pokja_default'][value='" + first.value + "']");
            firstRadio.checked = true;
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const checkboxes =
            document.querySelectorAll(".pokja-checkbox");

        const radios =
            document.querySelectorAll(".pokja-default");

        const roleSelects =
            document.querySelectorAll(".role-select");

        const checkAll =
            document.getElementById("checkAll");

        // =====================================
        // INIT
        // =====================================

        function syncState() {

            checkboxes.forEach(cb => {

                const pokjaId = cb.value;

                const radio =
                    document.querySelector(
                        ".pokja-default[value='" + pokjaId + "']"
                    );

                const role =
                    document.querySelector(
                        ".role-select[data-pokja='" + pokjaId + "']"
                    );

                // disable jika tidak dicentang
                radio.disabled = !cb.checked;
                role.disabled = !cb.checked;

                // jika uncheck
                if (!cb.checked) {

                    radio.checked = false;
                    role.value = '';
                }
            });

            // auto pilih default pertama
            const activeDefault =
                document.querySelector(".pokja-default:checked");

            const checked =
                document.querySelectorAll(".pokja-checkbox:checked");

            if (!activeDefault && checked.length > 0) {

                const first = checked[0];

                const firstRadio =
                    document.querySelector(
                        ".pokja-default[value='" + first.value + "']"
                    );

                firstRadio.checked = true;
            }
        }

        // =====================================
        // CHECKBOX EVENT
        // =====================================

        checkboxes.forEach(cb => {

            cb.addEventListener("change", syncState);

        });

        // =====================================
        // CHECK ALL
        // =====================================

        if (checkAll) {

            checkAll.addEventListener("change", function() {

                checkboxes.forEach(cb => {

                    cb.checked = checkAll.checked;

                });

                syncState();
            });
        }

        // init pertama
        syncState();

    });
</script>

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
    document.addEventListener('DOMContentLoaded', function() {
        const pegawaiSelect = document.getElementById('pegawai_id');
        const namaLengkapInput = document.getElementById('nama_lengkap');
        const usernameInput = document.getElementById('username');

        if (!pegawaiSelect) return;

        function isiDataPegawai() {
            const selectedOption = pegawaiSelect.options[pegawaiSelect.selectedIndex];

            if (!selectedOption) return;

            const nama = selectedOption.dataset.nama || '';
            const nip = selectedOption.dataset.nip || '';

            if (namaLengkapInput) {
                namaLengkapInput.value = nama;
            }

            if (usernameInput) {
                usernameInput.value = nip;
            }
        }

        // saat user ganti pilihan
        pegawaiSelect.addEventListener('change', isiDataPegawai);

        // saat halaman load kalau sudah ada selected
        isiDataPegawai();
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

<script>
    document.querySelectorAll("input[name='pokja_ids[]']").forEach(cb => {
        cb.addEventListener("change", function() {

            const radios = document.querySelectorAll("input[name='pokja_default']");
            const checkedCheckboxes = Array.from(document.querySelectorAll("input[name='pokja_ids[]']:checked"));

            const currentRadio = document.querySelector("input[name='pokja_default'][value='" + this.value + "']");

            if (!this.checked) {
                // ❌ jika uncheck → matikan radio terkait
                if (currentRadio.checked) {
                    currentRadio.checked = false;
                }
            }

            // 🔥 CEK: apakah masih ada default?
            const activeDefault = document.querySelector("input[name='pokja_default']:checked");

            if (!activeDefault && checkedCheckboxes.length > 0) {
                // ✅ set default ke checkbox pertama yang masih aktif
                const first = checkedCheckboxes[0];
                const firstRadio = document.querySelector("input[name='pokja_default'][value='" + first.value + "']");
                firstRadio.checked = true;
            }

            // 🔥 disable radio kalau checkbox tidak aktif
            radios.forEach(r => {
                const relatedCheckbox = document.querySelector("input[name='pokja_ids[]'][value='" + r.value + "']");
                r.disabled = !relatedCheckbox.checked;
            });

        });
    });
</script>

<script>
    function initPokjaState() {

        const radios = document.querySelectorAll("input[name='pokja_default']");

        radios.forEach(r => {
            const cb = document.querySelector("input[name='pokja_ids[]'][value='" + r.value + "']");
            r.disabled = !cb.checked;
        });

        const activeDefault = document.querySelector("input[name='pokja_default']:checked");
        const checkedCheckboxes = document.querySelectorAll("input[name='pokja_ids[]']:checked");

        if (!activeDefault && checkedCheckboxes.length > 0) {
            const first = checkedCheckboxes[0];
            document.querySelector("input[name='pokja_default'][value='" + first.value + "']").checked = true;
        }
    }

    document.addEventListener("DOMContentLoaded", initPokjaState);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const hiddenInput = document.getElementById('pegawai_id');
        const displayInput = document.getElementById('pegawai_display');

        const namaLengkapInput = document.getElementById('nama_lengkap');
        const usernameInput = document.getElementById('username');

        // =========================
        // PILIH PEGAWAI
        // =========================
        document.querySelectorAll('.pegawai-radio').forEach(radio => {
            radio.addEventListener('change', function() {

                let id = this.value;
                let nama = this.dataset.nama || '';
                let nip = this.dataset.nip || '';

                // isi hidden
                hiddenInput.value = id;

                // tampilkan di input
                displayInput.value = nama;

                // isi otomatis field lain
                if (namaLengkapInput) {
                    namaLengkapInput.value = nama;
                }

                if (usernameInput) {
                    usernameInput.value = nip;
                }

                // tutup modal
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalPilihPegawai'));
                modal.hide();
            });
        });

        // =========================
        // SEARCH
        // =========================
        const searchInput = document.getElementById('searchPegawai');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                let keyword = this.value.toLowerCase();
                let items = document.querySelectorAll('#listPegawai .pegawai-item');

                items.forEach(item => {
                    let text = item.innerText.toLowerCase();
                    item.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        }

        // =========================
        // AUTO LOAD (EDIT MODE)
        // =========================
        function loadSelectedPegawai() {
            let selectedId = hiddenInput.value;

            if (!selectedId) return;

            let selectedRadio = document.querySelector('.pegawai-radio[value="' + selectedId + '"]');

            if (selectedRadio) {
                selectedRadio.checked = true;

                let nama = selectedRadio.dataset.nama || '';
                let nip = selectedRadio.dataset.nip || '';

                if (displayInput) {
                    displayInput.value = nama;
                }

                if (namaLengkapInput) {
                    namaLengkapInput.value = nama;
                }

                if (usernameInput) {
                    usernameInput.value = nip;
                }
            }
        }

        loadSelectedPegawai();

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const pokjaIdInput =
            document.getElementById("pokja_id");

        const radios =
            document.querySelectorAll("input[name='pokja_default']");

        function syncPokjaDefault() {

            const active =
                document.querySelector("input[name='pokja_default']:checked");

            if (active && pokjaIdInput) {
                pokjaIdInput.value = active.value;
            } else if (pokjaIdInput) {
                pokjaIdInput.value = '';
            }
        }

        // saat radio berubah
        radios.forEach(radio => {
            radio.addEventListener("change", syncPokjaDefault);
        });

        // init pertama
        syncPokjaDefault();

    });
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
