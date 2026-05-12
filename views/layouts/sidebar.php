<?php

/** @var array $user */


$page = $_GET['page'] ?? '';
$arsipPages = ['arsip', 'tambah-arsip', 'tambah-jenis-arsip', 'edit-jenis-arsip', 'detail-arsip', 'edit-arsip'];
$publikasiPages = ['publikasi', 'tambah-publikasi', 'tambah-jenis-publikasi', 'edit-jenis-publikasi', 'edit-publikasi', 'edit-status-publikasi-admin'];
$kegiatanPages = ['kegiatan', 'tambah-kegiatan', 'tambah-jenis-kegiatan', 'edit-jenis-kegiatan', 'edit-kegiatan'];
$dokumenPages = ['dokumen', 'tambah-dokumen', 'tambah-jenis-dokumen'];
$pengaturanPages = ['profil', 'manajemen-file', 'backup-data'];
$dipPages = ['dip', 'tambah-dip', 'detail-dip', 'edit-dip', 'dip-print-filter'];
$peraturanPages = ['peraturan', 'tambah-peraturan', 'detail-peraturan', 'edit-peraturan', 'jenis-peraturan', 'tambah-jenis-peraturan', 'edit-jenis-peraturan'];
$pegawaiPages = ['pegawai', 'tambah-pegawai', 'detail-pegawai', 'edit-pegawai', 'tambah-jabatan-pegawai', 'edit-jabatan-pegawai', 'pegawai-pensiun'];
$modulPages = ['modul', 'tambah-modul', 'edit-modul'];
$userPages = ['user', 'tambah-user', 'edit-user', 'tambah-tim'];
?>

<div class="collapse navbar-collapse" id="sidebar-menu">
    <hr class="mt-2 mb-0">
    <ul class="navbar-nav pt-lg-3">
        <li class="nav-item <?= $page === 'dashboard' ? 'active bg-primary' : '' ?> mb-2">
            <a class="nav-link" href="<?= url('?page=dashboard') ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h1.6" />
                        <path d="M20 11l-8 -8l-9 9h2v7a2 2 0 0 0 2 2h4.159" />
                        <path d="M16 18a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M18 14.5v1.5" />
                        <path d="M18 20v1.5" />
                        <path d="M21.032 16.25l-1.299 .75" />
                        <path d="M16.27 19l-1.3 .75" />
                        <path d="M14.97 16.25l1.3 .75" />
                        <path d="M19.733 19l1.3 .75" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Dashboard
                </span>
            </a>
        </li>
        <?php if (
            in_array($user['role'], ['Superadmin', 'Pimpinan'])
            ||
            (
                in_array($user['role'], ['Admin', 'Staff'])
                && !in_array($user['pokja_nama'], ['Arsiparis', 'DIP', 'Kepegawaian'], true)
            )
        ): ?>

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
                            <a class="dropdown-item <?= ($page === 'publikasi' || $page === 'edit-publikasi' || $page === 'edit-status-publikasi-admin') ? 'active' : '' ?>" href="<?= url('?page=publikasi') ?>">
                                Daftar Publikasi
                            </a>
                            <a class="dropdown-item <?= $page === 'tambah-publikasi' ? 'active' : '' ?>" href="<?= url('?page=tambah-publikasi') ?>">
                                Tambah Publikasi
                            </a>
                            <?php if (
                                in_array($user['role'], ['Superadmin', 'Pimpinan'])
                            ): ?>
                                <a class="dropdown-item <?= ($page === 'tambah-jenis-publikasi' || $page === 'edit-jenis-publikasi') ? 'active' : '' ?>" href="<?= url('?page=tambah-jenis-publikasi') ?>">
                                    Jenis Publikasi
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <?php if (
            in_array($user['role'], ['Superadmin', 'Pimpinan'])
        ): ?>
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
                            <a class="dropdown-item <?= ($page === 'arsip' || $page === 'detail-arsip' || $page === 'edit-arsip') ? 'active' : '' ?>" href="<?= url('?page=arsip') ?>">
                                Daftar Arsip
                            </a>
                            <a class="dropdown-item <?= $page === 'tambah-arsip' ? 'active' : '' ?>" href="<?= url('?page=tambah-arsip') ?>">
                                Tambah Arsip
                            </a>
                            <a class="dropdown-item <?= ($page === 'tambah-jenis-arsip' || $page === 'edit-jenis-arsip') ? 'active' : '' ?>" href="<?= url('?page=tambah-jenis-arsip') ?>">
                                Jenis Kegiatan
                            </a>

                        </div>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <?php if (
            in_array($user['role'], ['Superadmin', 'Pimpinan']) ||
            (in_array($user['role'], ['Admin', 'Staff']) && in_array($user['pokja_nama'], ['Arsiparis'], true))
        ): ?>
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
                            <a class="dropdown-item <?= ($page === 'tambah-jenis-peraturan' || $page === 'edit-jenis-peraturan') ? 'active' : '' ?>" href="<?= url('?page=tambah-jenis-peraturan') ?>">
                                Jenis Peraturan
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        <?php endif; ?>
        <?php if (
            in_array($user['role'], ['Superadmin', 'Pimpinan']) ||
            (in_array($user['role'], ['Admin', 'Staff']) && in_array($user['pokja_nama'], ['DIP', 'Arsiparis'], true))
        ): ?>
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
                            <a class="dropdown-item <?= $page === 'dip-print-filter' ? 'active' : '' ?>" href="<?= url('?page=dip-print-filter') ?>">
                                Cetak DIP
                            </a>
                        </div>
                    </div>
                </div>
            </li>

        <?php endif; ?>

        <?php if (
            in_array($user['role'], ['Superadmin', 'Pimpinan']) ||
            (in_array($user['role'], ['Admin', 'Staff']) && in_array($user['pokja_nama'], ['Kepegawaian'], true))
        ): ?>
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
                            <a class="dropdown-item <?= ($page === 'pegawai' || $page === 'edit-pegawai' || $page === 'detail-pegawai') ? 'active' : '' ?>" href="<?= url('?page=pegawai') ?>">
                                Daftar Pegawai
                            </a>
                            <a class="dropdown-item <?= $page === 'tambah-pegawai' ? 'active' : '' ?>" href="<?= url('?page=tambah-pegawai') ?>">
                                Tambah Pegawai
                            </a>
                            <a class="dropdown-item <?= ($page === 'tambah-jabatan-pegawai' || $page === 'edit-jabatan-pegawai') ? 'active' : '' ?>" href="<?= url('?page=tambah-jabatan-pegawai') ?>">
                                Jabatan Pegawai
                            </a>
                            <a class="dropdown-item <?= $page === 'pegawai-pensiun' ? 'active' : '' ?>" href="<?= url('?page=pegawai-pensiun') ?>">
                                Data Pensiun
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        <?php endif; ?>
        <?php if (
            in_array($user['role'], ['Superadmin', 'Pimpinan'])
        ): ?>

            <li class="nav-item dropdown <?= in_array($page, $modulPages) ? 'active' : '' ?> mb-2">
                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 5.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" />
                            <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                            <path d="M11 7h5" />
                            <path d="M11 10h6" />
                            <path d="M11 13h3" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        Modul
                    </span>
                </a>
                <div class="dropdown-menu <?= in_array($page, $modulPages) ? 'show' : '' ?>">
                    <div class="dropdown-menu-columns">
                        <div class="dropdown-menu-column">
                            <a class="dropdown-item <?= ($page === 'modul' || $page === 'edit-modul') ? 'active' : '' ?>" href="<?= url('?page=modul') ?>">
                                Daftar Modul
                            </a>
                            <a class="dropdown-item <?= $page === 'tambah-modul' ? 'active' : '' ?>" href="<?= url('?page=tambah-modul') ?>">
                                Tambah Modul
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown <?= in_array($page, $userPages) ? 'active' : '' ?> mb-2">
                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                            <path d="M17.001 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M19.001 15.5v1.5" />
                            <path d="M19.001 21v1.5" />
                            <path d="M22.032 17.25l-1.299 .75" />
                            <path d="M17.27 20l-1.3 .75" />
                            <path d="M15.97 17.25l1.3 .75" />
                            <path d="M20.733 20l1.3 .75" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        Kelola User
                    </span>
                </a>
                <div class="dropdown-menu <?= in_array($page, $userPages) ? 'show' : '' ?>">
                    <div class="dropdown-menu-columns">
                        <div class="dropdown-menu-column">
                            <a class="dropdown-item <?= ($page === 'user' || $page === 'edit-user') ? 'active' : '' ?>" href="<?= url('?page=user') ?>">
                                Daftar User
                            </a>
                            <a class="dropdown-item <?= $page === 'tambah-user' ? 'active' : '' ?>" href="<?= url('?page=tambah-user') ?>">
                                Tambah User
                            </a>
                            <a class="dropdown-item <?= $page === 'tambah-tim' ? 'active' : '' ?>" href="<?= url('?page=tambah-tim') ?>">
                                Kelola Tim/Unit
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <!-- <li class="nav-item dropdown <?= in_array($page, $pengaturanPages) ? 'active' : '' ?> mb-2">
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
                            <a class="dropdown-item <?= $page === 'manajemen-file' ? 'active' : '' ?>" href="<?= url('?page=manajemen-file') ?>">
                                Kelola File
                            </a>
                            <a class="dropdown-item <?= $page === 'backup-data' ? 'active' : '' ?>" href="<?= url('?page=backup-data') ?>">
                                Backup Data
                            </a>
                        </div>
                    </div>
                </div>
            </li> -->
        <?php endif; ?>

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