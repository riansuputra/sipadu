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
