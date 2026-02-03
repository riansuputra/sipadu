<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Peraturan";

// echo '<pre>';
// print_r($data);
// echo '</pre>';

// Mulai buffer konten
ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">



        <div class="row row-cards">
            <div class="col-12 ms-2 mb-0">
                <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="#">Peraturan</a>
                    </li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">

                    <div class="card-body mb-0">
                        <form method="get">
                            <input type="hidden" name="page" value="peraturan-publik">
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="judul" value="<?= htmlspecialchars($_GET['judul'] ?? '') ?>" class="form-control" placeholder="Judul...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label">Nomor</label>
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-number-123">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 10l2 -2v8" />
                                                <path d="M9 8h3a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h3" />
                                                <path d="M17 8h2.5a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1 -1.5 1.5h-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1 -1.5 1.5h-2.5" />
                                            </svg>
                                        </span>
                                        <input type="text" name="nomor" value="<?= htmlspecialchars($_GET['nomor'] ?? '') ?>" class="form-control" placeholder="Nomor...">
                                    </div>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label">Tahun</label>
                                    <div class="input-icon mb-3">
                                        <select name="tahun" id="tahun" class="form-select">
                                            <option value="" disabled <?= empty($_GET['tahun']) ? 'selected' : '' ?>>-- Pilih Tahun --</option>
                                            <?php for ($i = date('Y'); $i >= 1990; $i--): ?>
                                                <option value="<?= $i ?>" <?= (($_GET['tahun'] ?? '') == $i) ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 col-4">
                                    <label class="form-label">Jenis Peraturan</label>
                                    <div class="input-icon mb-3">
                                        <select class="form-select" name="jenis" id="jenis">
                                            <option value="" disabled <?= empty($_GET['jenis']) ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                                            <?php foreach ($jenis as $j): ?>
                                                <option value="<?= $j['id'] ?>" <?= (($_GET['jenis'] ?? '') == $j['id']) ? 'selected' : '' ?>>
                                                    <?= $j['kode'] ?> (<?= $j['nama'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>Cari
                                </button>
                                <a href="?page=peraturan-publik" class="btn btn-1 btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>Reset </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <?php foreach ($data as $d): ?>
                            <div class="space-y mb-2">
                                <div class="card card-link card-link-pop">
                                    <div class="row g-0">
                                        <div class="col-auto">
                                            <a href="">
                                                <div class="card-body">
                                                    <div class="avatar avatar-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-file-description">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 2l.117 .007a1 1 0 0 1 .876 .876l.007 .117v4l.005 .15a2 2 0 0 0 1.838 1.844l.157 .006h4l.117 .007a1 1 0 0 1 .876 .876l.007 .117v9a3 3 0 0 1 -2.824 2.995l-.176 .005h-10a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-14a3 3 0 0 1 2.824 -2.995l.176 -.005zm3 14h-6a1 1 0 0 0 0 2h6a1 1 0 0 0 0 -2m0 -4h-6a1 1 0 0 0 0 2h6a1 1 0 0 0 0 -2" />
                                                            <path d="M19 7h-4l-.001 -4.001z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <div class="card-body ps-0">
                                                <div class="row">
                                                    <div class="col">
                                                        <a class="mb-0" href="?page=peraturan-detail&id=<?= $d['id'] ?>"><span class="text-primary"><?= $d['jenis'] ?></span></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="mb-0 h3"><?= htmlspecialchars($d['judul']) ?></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <div class="mt-1 list-inline list-inline-dots mb-0 text-secondary d-sm-block d-none">
                                                            <div class="list-inline-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                                                    <path d="M16 3v4" />
                                                                    <path d="M8 3v4" />
                                                                    <path d="M4 11h16" />
                                                                    <path d="M7 14h.013" />
                                                                    <path d="M10.01 14h.005" />
                                                                    <path d="M13.01 14h.005" />
                                                                    <path d="M16.015 14h.005" />
                                                                    <path d="M13.015 17h.005" />
                                                                    <path d="M7.01 17h.005" />
                                                                    <path d="M10.01 17h.005" />
                                                                </svg>
                                                                <?= $d['tahun_terbit'] ?>
                                                            </div>
                                                            <div class="list-inline-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                </svg>
                                                                <?= $d['jumlah_dilihat'] ?>
                                                            </div>
                                                            <div class="list-inline-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M4 15v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                                    <path d="M7 11l5 5l5 -5"></path>
                                                                    <path d="M12 4l0 12"></path>
                                                                </svg>
                                                                <?= $d['jumlah_unduhan'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="ist mb-0 text-secondary d-block d-sm-none">
                                                            <div class="list-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                                                    <path d="M16 3v4" />
                                                                    <path d="M8 3v4" />
                                                                    <path d="M4 11h16" />
                                                                    <path d="M7 14h.013" />
                                                                    <path d="M10.01 14h.005" />
                                                                    <path d="M13.01 14h.005" />
                                                                    <path d="M16.015 14h.005" />
                                                                    <path d="M13.015 17h.005" />
                                                                    <path d="M7.01 17h.005" />
                                                                    <path d="M10.01 17h.005" />
                                                                </svg>
                                                                <?= $d['tahun_terbit'] ?>
                                                            </div>
                                                            <div class="list-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                </svg>
                                                                <?= $d['jumlah_dilihat'] ?>
                                                            </div>
                                                            <div class="list-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M4 15v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                                    <path d="M7 11l5 5l5 -5"></path>
                                                                    <path d="M12 4l0 12"></path>
                                                                </svg>
                                                                <?= $d['jumlah_unduhan'] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <?php if ($totalPage > 1): ?>
                                <ul class="pagination m-0 ms-auto">
                                    <!-- Previous -->
                                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['p' => max(1, $page - 1)])) ?>" tabindex="-1" aria-disabled="<?= ($page <= 1) ? 'true' : 'false' ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path d="M15 6l-6 6l6 6"></path>
                                            </svg>
                                        </a>
                                    </li>

                                    <!-- Page numbers -->
                                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Next -->
                                    <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['p' => min($totalPage, $page + 1)])) ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path d="M9 6l6 6l-6 6"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>

                        </div>
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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
