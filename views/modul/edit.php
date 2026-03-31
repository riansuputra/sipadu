<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Edit Modul";




$form = !empty($old) ? $old : $data;

// Mulai buffer konten
ob_start();
?>


<?php
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

// 🔥 HAPUS SETELAH DIPAKAI
unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Modul</div>
                <h2 class="page-title">Edit Modul</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" action="<?= url('?page=modul-update') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Modul</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">


                            <div class="mb-3">
                                <label class="form-label required">Judul :</label>
                                <input type="text" name="judul"
                                    class="form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($form['judul'] ?? '') ?>">
                                <?php if (isset($errors['judul'])): ?>
                                    <div class="invalid-feedback"><?= $errors['judul'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Link :</label>
                                <input type="text" name="link"
                                    class="form-control <?= isset($errors['link']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($form['link'] ?? '') ?>">
                                <?php if (isset($errors['link'])): ?>
                                    <div class="invalid-feedback"><?= $errors['link'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Halaman :</label>
                                <select name="parent_slug" class="form-select <?= isset($errors['parent_slug']) ? 'is-invalid' : '' ?>">
                                    <option value="">-- Pilih Halaman --</option>
                                    <?php
                                    $parents = ['paud', 'sd', 'smp', 'sma', 'widyaprada', 'link-aplikasi'];
                                    foreach ($parents as $parent):
                                    ?>
                                        <option value="<?= $parent ?>" <?= (($form['parent_slug'] ?? '') === $parent) ? 'selected' : '' ?>>
                                            <?= strtoupper($parent) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['parent_slug'])): ?>
                                    <div class="invalid-feedback"><?= $errors['parent_slug'] ?></div>
                                <?php endif; ?>

                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Target Link :</label>
                                <select name="target" class="form-select <?= isset($errors['target']) ? 'is-invalid' : '' ?>" required>
                                    <option value="_self" <?= ($data['target'] ?? '_self') === '_self' ? 'selected' : '' ?>>
                                        Buka di tab yang sama
                                    </option>
                                    <option value="_blank" <?= ($data['target'] ?? '') === '_blank' ? 'selected' : '' ?>>
                                        Buka di tab baru
                                    </option>
                                </select>
                                <?php if (isset($errors['target'])): ?>
                                    <div class="invalid-feedback"><?= $errors['target'] ?></div>
                                <?php endif; ?>
                            </div>



                            <div class="mb-3">
                                <label class="form-label">Deskripsi :</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($form['deskripsi'] ?? '') ?></textarea>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Gambar Modul :</label>
                                <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                <small class="text-muted">
                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                </small>
                            </div>
                            <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar'] ?? '') ?>">




                            <div class="mb-3">
                                <label class="form-label">Status :</label>

                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        <?= ((int)($form['is_active'] ?? 0) === 1) ? 'checked' : '' ?>>
                                    <span class="form-check-label">Aktif</span>
                                </label>


                            </div>

                            <div class="mb-3">
                                <a href="<?= url('?page=modul') ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>

                        </div>
                    </div>
                </form>
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


<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
