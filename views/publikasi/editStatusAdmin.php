<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Publikasi";
$bannerTitle = "Publikasi";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($dataata);
// foreach ($dataata as $datat => $data):
//     if ($data['files']) {

//         $files = explode('##', $data['files']);

//         foreach ($files as $f) {

//             list($id, $nama, $path) = explode('|', $f);

//             echo "<a href='$path'>$nama</a><br>";
//         }
//     }

// endforeach;

// echo '</pre>';
$tanggalMulai   = $_GET['tanggal_mulai'] ?? null;
$tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
$jenis          = $_GET['jenis'] ?? null;

$dataeskripsi = 'Menampilkan seluruh data';

if ($tanggalMulai || $tanggalSelesai || $jenis) {

    $parts = [];

    if ($tanggalMulai && $tanggalSelesai) {
        $parts[] = "tanggal <strong>" . htmlspecialchars($tanggalMulai) .
            "</strong> sampai <strong>" . htmlspecialchars($tanggalSelesai) . "</strong>";
    } elseif ($tanggalMulai) {
        $parts[] = "tanggal <strong>" . htmlspecialchars($tanggalMulai) . "</strong>";
    }

    if ($jenis) {
        $parts[] = "jenis informasi '<strong>" .
            htmlspecialchars(ucwords(strtolower($jenis))) .
            "</strong>'";
    }

    $dataeskripsi = 'Filter data publikasi ' . implode(' dan ', $parts);
}

?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Publikasi</div>
                <h2 class="page-title">Status Publikasi</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-cards ">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Status Publikasi</h4>
                    </div>
                    <div class="card-body">
                        <form id="form-approve-<?= $data['id'] ?>"
                            method="POST"
                            action="<?= url('?page=approve-publikasi') ?>">

                            <div class="form-fieldset">
                                <div class="mb-3 row">
                                    <div class="col-auto form-label">Judul Publikasi :</div>
                                    <div class="col-auto form-label fw-bold"><?= htmlspecialchars($data['judul']) ?></div>

                                </div>
                                <div class="mb-3 row">
                                    <div class="col-auto form-label">Status Publikasi :</div>

                                    <label class="col form-check form-switch form-switch-3">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="is_published"
                                            value="1"
                                            <?= !empty($data['is_published']) ? 'checked' : '' ?>>
                                        <span class="form-check-label form-check-label-on">Sudah</span>
                                        <span class="form-check-label form-check-label-off">Belum</span>

                                    </label>
                                </div>

                                <div class="mb-3">

                                    <!-- LABEL + BUTTON -->
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label">Link Publikasi : </label>

                                        <button type="button"
                                            class="btn btn-primary btn-sm"
                                            onclick="addLink(<?= $data['id'] ?>)">
                                            + Tambah Link
                                        </button>
                                    </div>
                                    <small class="form-hint"><i>(contoh: https://www.instagram.com/bpmpbali)</i></small>
                                    <!-- CONTAINER KHUSUS INPUT (INI PENTING) -->
                                    <div id="link-wrapper-<?= $data['id'] ?>">

                                        <?php
                                        $links = !empty($data['publish_links'])
                                            ? json_decode($data['publish_links'], true)
                                            : [];
                                        ?>

                                        <?php if (!empty($links)): ?>
                                            <?php foreach ($links as $i => $link): ?>
                                                <div class="input-group mb-2">

                                                    <select name="publish_links[<?= $i ?>][platform]" class="form-select">
                                                        <option value="">-- Platform --</option>
                                                        <option value="youtube" <?= ($link['platform'] ?? '') == 'youtube' ? 'selected' : '' ?>>YouTube</option>
                                                        <option value="facebook" <?= ($link['platform'] ?? '') == 'facebook' ? 'selected' : '' ?>>Facebook</option>
                                                        <option value="instagram" <?= ($link['platform'] ?? '') == 'instagram' ? 'selected' : '' ?>>Instagram</option>
                                                        <option value="website" <?= ($link['platform'] ?? '') == 'website' ? 'selected' : '' ?>>Website</option>
                                                        <option value="drive" <?= ($link['platform'] ?? '') == 'drive' ? 'selected' : '' ?>>Google Drive</option>
                                                    </select>

                                                    <input
                                                        type="url"
                                                        name="publish_links[<?= $i ?>][url]"
                                                        value="<?= htmlspecialchars($link['url'] ?? '') ?>"
                                                        class="form-control w-50"
                                                        placeholder="Link publikasi...">

                                                    <button type="button"
                                                        class="btn btn-danger"
                                                        onclick="removeLink(this)">
                                                        Hapus
                                                    </button>

                                                </div>
                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <div class="input-group mb-2">

                                                <select name="publish_links[0][platform]" class="form-select">
                                                    <option value="">-- Platform --</option>
                                                    <option value="youtube">YouTube</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="instagram">Instagram</option>
                                                    <option value="website">Website</option>
                                                    <option value="drive">Google Drive</option>
                                                </select>

                                                <input type="url"
                                                    name="publish_links[0][url]"
                                                    class="form-control w-50"
                                                    placeholder="Link publikasi...">

                                                <button type="button"
                                                    class="btn btn-danger"
                                                    onclick="removeLink(this)">
                                                    Hapus
                                                </button>

                                            </div>

                                        <?php endif; ?>

                                    </div>


                                </div>

                            </div>
                            <input type="text" name="id" id="id" value="<?= $data['id'] ?>" hidden>
                            <div class="">
                                <button type="button"
                                    class="btn btn-success"
                                    onclick="submitApprove(<?= $data['id'] ?>)">
                                    Simpan
                                </button>

                            </div>
                        </form>
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
    function confirmDelete(url, label = '') {

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `Data <strong>${label}</strong> akan dihapus permanen` : 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = url;
            }

        });
    }
</script>
<?php if (isset($_SESSION['flash'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: '<?= $_SESSION['flash']['status'] ?>',
                title: <?= $_SESSION['flash']['status'] === 'success'
                            ? "'Berhasil!'"
                            : "'Gagal!'" ?>,
                text: <?= json_encode($_SESSION['flash']['message']) ?>
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<script>
    let linkIndex = 1;

    function addLink(id) {
        const wrapper = document.getElementById("link-wrapper-" + id);

        const div = document.createElement("div");
        div.className = "input-group mb-2";

        div.innerHTML = `
        <select name="publish_links[${linkIndex}][platform]" class="form-select">
            <option value="">-- Platform --</option>
            <option value="youtube">YouTube</option>
            <option value="facebook">Facebook</option>
            <option value="instagram">Instagram</option>
            <option value="website">Website</option>
            <option value="drive">Google Drive</option>
        </select>

        <input type="url"
            name="publish_links[${linkIndex}][url]"
            class="form-control w-50"
            placeholder="Link publikasi...">

        <button type="button"
            class="btn btn-danger"
            onclick="removeLink(this)">
            Hapus
        </button>
    `;

        wrapper.appendChild(div);
        linkIndex++;
    }


    function removeLink(button) {
        button.closest('.input-group').remove();
    }

    document.querySelectorAll('form').forEach((f, i) => {
        f.addEventListener("submit", function() {
            console.log("FORM KE", i);
            console.log(this.querySelectorAll('[name="publish_links[]"]').length);
        });
    });
</script>

<script>
    function submitApprove(id) {
        const form = document.getElementById("form-approve-" + id);

        console.log(
            "input dalam form:",
            form.querySelectorAll('[name="publish_links[]"]').length
        );

        form.submit();
    }
</script>


<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/admin.php';
