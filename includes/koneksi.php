<?php
// ================================
// KONEKSI DATABASE (PDO)
// ================================

// Konfigurasi database lokal
$host = 'localhost';
$db   = 'db_sipadu';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Konfigurasi database termux ke server db infinityfree
// $host = 'sql12.freesqldatabase.com';
// $db   = 'sql12815967';
// $user = 'sql12815967';
// $pass = 'CrDhIVdFUn';
// $charset = 'utf8mb4';

try {
    // Membuat koneksi PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset",
        $user,
        $pass,
        [
            // Menampilkan error PDO sebagai exception
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            // Fetch default sebagai associative array
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan aplikasi
    die('Koneksi database gagal: ' . $e->getMessage());
}
