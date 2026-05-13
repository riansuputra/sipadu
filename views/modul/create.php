<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Tambah Modul";





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
                <h2 class="page-title">Tambah Modul</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-sm-12 col-lg-6">
                <form class="card" action="<?= url('?page=modul-store') ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Modul</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-fieldset">


                            <div class="mb-3">
                                <label class="form-label required">Judul :</label>
                                <input type="text" name="judul"
                                    class="form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($old['judul'] ?? '') ?>" autocomplete="off">
                                <?php if (isset($errors['judul'])): ?>
                                    <div class="invalid-feedback"><?= $errors['judul'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Link :</label>
                                <input type="text" name="link"
                                    class="form-control <?= isset($errors['link']) ? 'is-invalid' : '' ?>"
                                    placeholder="https://drive.google.com"
                                    value="<?= htmlspecialchars($old['link'] ?? '') ?>" autocomplete="off">
                                <small class="text-muted d-block mb-1">Gunakan URL lengkap, contoh: https://drive.google.com</small>
                                <?php if (isset($errors['link'])): ?>
                                    <div class="invalid-feedback"><?= $errors['link'] ?></div>
                                <?php endif; ?>
                            </div>

                            <?php
                            $selectedParent = $old['parent_slug'] ?? $form['parent_slug'] ?? '';
                            ?>

                            <div class="mb-3">
                                <label class="form-label required">Halaman :</label>
                                <select name="parent_slug" class="form-select <?= isset($errors['parent_slug']) ? 'is-invalid' : '' ?>">
                                    <option value="">-- Pilih Halaman --</option>
                                    <option value="paud" <?= $selectedParent === 'paud' ? 'selected' : '' ?>>PAUD</option>
                                    <option value="sd" <?= $selectedParent === 'sd' ? 'selected' : '' ?>>SD</option>
                                    <option value="smp" <?= $selectedParent === 'smp' ? 'selected' : '' ?>>SMP</option>
                                    <option value="sma" <?= $selectedParent === 'sma' ? 'selected' : '' ?>>SMA</option>
                                    <option value="widyaprada" <?= $selectedParent === 'widyaprada' ? 'selected' : '' ?>>Widyaprada</option>
                                    <option value="link-aplikasi" <?= $selectedParent === 'link-aplikasi' ? 'selected' : '' ?>>Link Aplikasi</option>
                                    <option value="kegiatan-paud" <?= $selectedParent === 'kegiatan-paud' ? 'selected' : '' ?>>Kegiatan PAUD</option>
                                    <option value="kegiatan-sd" <?= $selectedParent === 'kegiatan-sd' ? 'selected' : '' ?>>Kegiatan SD</option>
                                    <option value="kegiatan-smp" <?= $selectedParent === 'kegiatan-smp' ? 'selected' : '' ?>>Kegiatan SMP</option>
                                    <option value="kegiatan-sma" <?= $selectedParent === 'kegiatan-sma' ? 'selected' : '' ?>>Kegiatan SMA</option>
                                    <option value="kegiatan-lainnya" <?= $selectedParent === 'kegiatan-lainnya' ? 'selected' : '' ?>>Kegiatan Lainnya</option>
                                </select>

                                <?php if (isset($errors['parent_slug'])): ?>
                                    <div class="invalid-feedback"><?= $errors['parent_slug'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Target Link :</label>
                                <select name="target" class="form-select <?= isset($errors['target']) ? 'is-invalid' : '' ?>" required>
                                    <option value="_self" <?= ($old['target'] ?? '_self') === '_self' ? 'selected' : '' ?>>
                                        Buka di tab yang sama
                                    </option>
                                    <option value="_blank" <?= ($old['target'] ?? '') === '_blank' ? 'selected' : '' ?>>
                                        Buka di tab baru
                                    </option>
                                </select>
                                <?php if (isset($errors['target'])): ?>
                                    <div class="invalid-feedback"><?= $errors['target'] ?></div>
                                <?php endif; ?>
                            </div>



                            <div class="mb-3">
                                <label class="form-label">Deskripsi :</label>
                                <textarea name="deskripsi" class="form-control" rows="3" autocomplete="off"><?= htmlspecialchars($old['deskripsi'] ?? '') ?></textarea>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Gambar Modul :</label>
                                <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                <small class="text-muted">
                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                </small>
                            </div>



                            <div class="mb-3">
                                <label class="form-label">Status :</label>

                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        <?= isset($old['is_active']) ? 'checked' : 'checked' ?>>
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
