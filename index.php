<?php
// ================================
// ENTRY POINT APLIKASI SIPADU
// ================================

// Jalankan session sekali di awal aplikasi
session_start();

// -------------------------------
// LOAD KONFIGURASI & KONEKSI
// -------------------------------
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/koneksi.php';

// -------------------------------
// LOAD CORE SYSTEM
// -------------------------------
require_once __DIR__ . '/core/auth.php';

require_once __DIR__ . '/core/router.php';
Auth::init();


// -------------------------------
// JALANKAN ROUTER
// -------------------------------
// Semua request akan diproses oleh router
routeRequest();
