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

// Konfigurasi database server
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'db_sipadu');
// define('DB_USER', 'root');
// define('DB_PASS', '');


// // Konfigurasi database server
// // $host = 'db.bpmpbali.id';
// // $db   = 'db_sipadu';
// // $user = 'root';
// // $pass = 'Denpasar14';
// // $charset = 'utf8mb4';