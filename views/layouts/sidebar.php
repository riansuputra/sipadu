<?php
// ================================
// SIDEBAR DINAMIS BERDASARKAN ROLE
// ================================
$page = $_GET['page'] ?? '';
$arsipPages = ['arsip', 'tambah-arsip'];
$publikasiPages = ['publikasi', 'tambah-publikasi', 'tambah-jenis-publikasi'];
$dokumenPages = ['dokumen', 'tambah-dokumen', 'tambah-jenis-dokumen'];
$pengaturanPages = ['profil', 'manajemen-file', 'backup-data'];
$dipPages = ['dip', 'tambah-dip', 'detail-dip', 'edit-dip'];
$peraturanPages = ['peraturan', 'tambah-peraturan', 'detail-peraturan', 'edit-peraturan', 'jenis-peraturan', 'tambah-jenis-peraturan'];
$pegawaiPages = ['pegawai', 'tambah-pegawai', 'detail-pegawai'];
?>

<div class="collapse navbar-collapse" id="sidebar-menu">
    <hr class="mt-2 mb-0">
    <ul class="navbar-nav pt-lg-3">
        <li class="nav-item <?= $page === 'dashboard' ? 'active bg-primary' : '' ?> mb-2">
            <a class="nav-link" href="<?= url('?page=dashboard') ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Dashboard
                </span>
            </a>
        </li>
        <li class="nav-item dropdown <?= in_array($page, $arsipPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-archive">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 6a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2" />
                        <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
                        <path d="M10 12l4 0" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Arsip
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $arsipPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= $page === 'arsip' ? 'active' : '' ?>" href="<?= url('?page=arsip') ?>">
                            Daftar Arsip
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-arsip' ? 'active' : '' ?>" href="<?= url('?page=tambah-arsip') ?>">
                            Tambah Arsip
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown <?= in_array($page, $dipPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-square-rounded">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 9h.01" />
                        <path d="M11 12h1v4h1" />
                        <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    DIP
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $dipPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= ($page === 'dip' || $page === 'edit-dip') ? 'active' : '' ?>" href="<?= url('?page=dip') ?>">
                            Daftar DIP
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-dip' ? 'active' : '' ?>" href="<?= url('?page=tambah-dip') ?>">
                            Tambah DIP
                        </a>
                        <!-- <a class="dropdown-item <?= $page === 'tambah-dip' ? 'active' : '' ?>" href="<?= url('?page=tambah-dip') ?>">
                            Riwayat DIP
                        </a> -->
                        <a class="dropdown-item <?= $page === 'dip-print-filter' ? 'active' : '' ?>" href="<?= url('?page=dip-print-filter') ?>">
                            Cetak DIP
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <!-- <li class="nav-item dropdown <?= in_array($page, $dokumenPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-files">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2" />
                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Dokumen
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $dokumenPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= $page === 'dokumen' ? 'active' : '' ?>" href="<?= url('?page=dokumen') ?>">
                            Daftar Dokumen
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-dokumen' ? 'active' : '' ?>" href="<?= url('?page=tambah-dokumen') ?>">
                            Tambah Dokumen
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-jenis-dokumen' ? 'active' : '' ?>" href="<?= url('?page=tambah-jenis-dokumen') ?>">
                            Tambah Jenis Dokumen
                        </a>
                    </div>
                </div>
            </div>
        </li> -->
        <li class="nav-item dropdown <?= in_array($page, $publikasiPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-tv-old">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -9" />
                        <path d="M16 3l-4 4l-4 -4" />
                        <path d="M15 7v13" />
                        <path d="M18 15v.01" />
                        <path d="M18 12v.01" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Publikasi
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $publikasiPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= $page === 'publikasi' ? 'active' : '' ?>" href="<?= url('?page=publikasi') ?>">
                            Daftar Publikasi
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-publikasi' ? 'active' : '' ?>" href="<?= url('?page=tambah-publikasi') ?>">
                            Tambah Publikasi
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-jenis-publikasi' ? 'active' : '' ?>" href="<?= url('?page=tambah-jenis-publikasi') ?>">
                            Jenis Publikasi
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown <?= in_array($page, $pegawaiPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Pegawai
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $pegawaiPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= $page === 'pegawai' ? 'active' : '' ?>" href="<?= url('?page=pegawai') ?>">
                            Daftar Pegawai
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-pegawai' ? 'active' : '' ?>" href="<?= url('?page=tambah-pegawai') ?>">
                            Tambah Pegawai
                        </a>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown <?= in_array($page, $peraturanPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-gavel">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M13 10l7.383 7.418c.823 .82 .823 2.148 0 2.967a2.11 2.11 0 0 1 -2.976 0l-7.407 -7.385" />
                        <path d="M6 9l4 4" />
                        <path d="M13 10l-4 -4" />
                        <path d="M3 21h7" />
                        <path d="M6.793 15.793l-3.586 -3.586a1 1 0 0 1 0 -1.414l2.293 -2.293l.5 .5l3 -3l-.5 -.5l2.293 -2.293a1 1 0 0 1 1.414 0l3.586 3.586a1 1 0 0 1 0 1.414l-2.293 2.293l-.5 -.5l-3 3l.5 .5l-2.293 2.293a1 1 0 0 1 -1.414 0" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Peraturan
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $peraturanPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= ($page === 'peraturan' || $page === 'edit-peraturan') ? 'active' : '' ?>" href="<?= url('?page=peraturan') ?>">
                            Daftar Peraturan
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-peraturan' ? 'active' : '' ?>" href="<?= url('?page=tambah-peraturan') ?>">
                            Tambah Peraturan
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-jenis-peraturan' ? 'active' : '' ?>" href="<?= url('?page=tambah-jenis-peraturan') ?>">
                            Jenis Peraturan
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown <?= in_array($page, $pengaturanPages) ? 'active' : '' ?> mb-2">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Pengaturan
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $pengaturanPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="<?= url('?page=dashboard&mode=staff') ?>">
                            Dashboard Staff
                        </a>
                        <a class="dropdown-item <?= $page === 'profil' ? 'active' : '' ?>" href="<?= url('?page=profil') ?>">
                            Profil
                        </a>
                        <a class="dropdown-item <?= $page === 'manajemen-file' ? 'active' : '' ?>" href="<?= url('?page=manajemen-file') ?>">
                            Manajemen File
                        </a>
                        <a class="dropdown-item <?= $page === 'backup-data' ? 'active' : '' ?>" href="<?= url('?page=backup-data') ?>">
                            Backup Data
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= url('?page=logout') ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M9 12h12l-3 -3" />
                        <path d="M18 15l3 -3" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Keluar
                </span>
            </a>
        </li>
    </ul>
</div>