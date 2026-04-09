<?php
// ================================
// KONFIGURASI GLOBAL APLIKASI
// ================================

// Base URL aplikasi
// Contoh: http://localhost/sipadu/public
define('BASE_URL', 'http://localhost/sipadu');

// Nama aplikasi
define('APP_NAME', 'SIPADU');

// Zona waktu aplikasi
date_default_timezone_set('Asia/Makassar');

define('MAINTENANCE_PAGES', [
    // 'dip-create',
    // 'arsip-create',
    // 'pegawai-create'
    // 'peraturan'
    'arsip-publik',
    'zi-wbbm-publik',
    'pengaturan-profile',
    'pegawai-publik'
]);

// Konfigurasi database lokal
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_sipadu');
define('DB_USER', 'root');
define('DB_PASS', '');

// // Konfigurasi database server free
// define('DB_HOST', 'sql205.infinityfree.com');
// define('DB_NAME', 'if0_40988811_db_sipadu');
// define('DB_USER', 'if0_40988811');
// define('DB_PASS', '1VbK8FVsXK6');
