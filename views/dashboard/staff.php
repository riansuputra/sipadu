<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Dashboard";
$bannerTitle = "Halaman Utama";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// dd($user);

// Load model akses halaman
require_once __DIR__ . '/../../models/ModulModel.php';
$moduleModel = new ModulModel();

// Daftar card dashboard statis
$cards = [
    [
        'title' => 'Tim Kerja PAUD',
        'slug' => 'paud',
        'image' => 'paud.webp',
    ],
    [
        'title' => 'Tim Kerja SD',
        'slug' => 'sd',
        'image' => 'sd.webp',
    ],
    [
        'title' => 'Tim Kerja SMP',
        'slug' => 'smp',
        'image' => 'smp.webp',
    ],
    [
        'title' => 'Tim Kerja SMA',
        'slug' => 'sma',
        'image' => 'sma.webp',
    ],
    [
        'title' => 'Tim Widyaprada',
        'slug' => 'widyaprada',
        'image' => 'widyaprada.webp',
    ],
    [
        'title' => 'Link Aplikasi',
        'slug' => 'link-aplikasi',
        'image' => 'link-aplikasi.webp',
    ],
    // [
    //     'title' => 'Data Kepegawaian',
    //     'slug' => 'pegawai-publik',
    //     'image' => 'kepegawaian.webp',
    // ],
    [
        'title' => 'Peraturan',
        'slug' => 'peraturan-publik',
        'image' => 'peraturan.webp',
    ],
    [
        'title' => 'Arsip',
        'slug' => 'arsip-saya',
        'image' => 'arsip.webp',
    ],
    [
        'title' => 'DIP',
        'slug' => 'dip-publik',
        'image' => 'dip.webp',
    ],
    [
        'title' => 'Kegiatan',
        'slug' => 'kegiatan',
        'image' => 'default.webp',
    ],
];

// Mulai buffer konten
ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">



        <div class="row row-cards">
            <div class="col-12 mb-0">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item active">
                                <a href="tests" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <?php if (
                in_array($user['role'], ['Superadmin', 'Pimpinan']) ||
                (in_array($user['role'], ['Admin', 'Staff']) && !in_array($user['pokja_nama'], ['Publikasi'], true))
            ): ?>
                <?php foreach ($cards as $card): ?>
                    <?php
                    $hasAccess = $moduleModel->canAccessPage(
                        $user['role'],
                        $user['pokja_nama'] ?? null,
                        $card['slug']
                    );

                    $href = $hasAccess ? url('?page=' . $card['slug']) : '#';
                    ?>

                    <div class="col-sm-6 col-lg-3 p-1">
                        <a href="<?= $href ?>"
                            class="card card-link card-link-pop"
                            <?= !$hasAccess ? 'onclick="noAccessAlert(); return false;"' : '' ?>>

                            <div class="img-responsive img-responsive-21x9 card-img-top"
                                style="background-image: url('public/assets/img/<?= htmlspecialchars($card['image']) ?>')">
                            </div>

                            <div class="card-body text-center fw-bold mb-0">
                                <?= htmlspecialchars($card['title']) ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (
                in_array($user['role'], ['Superadmin', 'Pimpinan']) ||
                (in_array($user['role'], ['Admin', 'Staff']) && in_array($user['pokja_nama'], ['Kepegawaian'], true))
            ): ?>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=kepegawaian')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/kepegawaian.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Data Kepegawaian
                        </div>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (
                (in_array($user['role'], ['Admin', 'Staff']) && in_array($user['pokja_nama'], ['Publikasi'], true))
            ): ?>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=timpublikasi')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/publikasi.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Publikasi
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="https://sippede.lpmpbali.id/"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/sippede.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            SIPPeDE
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=arsip-saya')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/arsip.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Arsip
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=dip-publik')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/dip.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Daftar Informasi Publik
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=peraturan-publik')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/peraturan.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Peraturan
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 p-1">
                    <a href="<?= url('?page=kegiatan')  ?>"
                        class="card card-link card-link-pop">

                        <div class="img-responsive img-responsive-21x9 card-img-top"
                            style="background-image: url('public/assets/img/default.webp')">
                        </div>

                        <div class="card-body text-center fw-bold mb-0">
                            Kegiatan
                        </div>
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    function noAccessAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: 'Anda tidak memiliki akses ke modul ini.',
            confirmButtonText: 'Mengerti'
        });
    }
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

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
