<?php
// ================================
// SIDEBAR DINAMIS BERDASARKAN ROLE
// ================================
$page = $_GET['page'] ?? '';
$arsipPages = ['arsip', 'tambah-arsip', 'arsip-tim'];
?>

<div class="collapse navbar-collapse" id="sidebar-menu">
    <hr class="mt-2 mb-0">
    <ul class="navbar-nav pt-lg-3">
        <li class="nav-item <?= $page === 'dashboard' ? 'active' : '' ?> mb-2">
            <a class="nav-link" href="<?= BASE_URL ?>/?page=dashboard">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-files">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M11 2l3 .001v5.999a1 1 0 0 0 .883 .993l.117 .007h6v6a3 3 0 0 1 -3 3h-1v1a3 3 0 0 1 -3 3h-7a3 3 0 0 1 -3 -3v-10a3 3 0 0 1 3 -3h1v-1a3 3 0 0 1 3 -3m-3 6h-1a1 1 0 0 0 -1 1v10a1 1 0 0 0 1 1h7a1 1 0 0 0 1 -1v-1h-4a3 3 0 0 1 -3 -3zm12.415 -1h-4.415v-4.415z" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Arsip
                </span>
            </a>
            <div class="dropdown-menu <?= in_array($page, $arsipPages) ? 'show' : '' ?>">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item <?= $page === 'arsip' ? 'active' : '' ?>" href="<?= BASE_URL ?>/?page=arsip">
                            Daftar Arsip
                        </a>
                        <a class="dropdown-item <?= $page === 'tambah-arsip' ? 'active' : '' ?>" href="<?= BASE_URL ?>/?page=tambah-arsip">
                            Tambah Arsip
                        </a>
                        <a class="dropdown-item <?= $page === 'arsip' ? 'tim' : '' ?>" href="<?= BASE_URL ?>/?page=logout">
                            Arsip Tim
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown {{ request()->routeIs('admin.permintaan.kategori') ? 'active' : '' }} mb-2">
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
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Daftar Publikasi
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Tambah Publikasi
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Publikasi Tim
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown {{ request()->routeIs('admin.permintaan.kategori') ? 'active' : '' }} mb-2">
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
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Daftar Pegawai
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Tambah Pegawai
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown {{ request()->routeIs('admin.permintaan.kategori') ? 'active' : '' }} mb-2">
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
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Daftar DIP
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Tambah DIP
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown {{ request()->routeIs('admin.permintaan.kategori') ? 'active' : '' }} mb-2">
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
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Daftar Peraturan
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Tambah Peraturan
                        </a>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown {{ request()->routeIs('admin.permintaan.kategori') ? 'active' : '' }} mb-2">
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
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Dashboard Staff
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Profil
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Manajemen File
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permintaan.kategori') }}">
                            Backup Data
                        </a>
                    </div>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
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