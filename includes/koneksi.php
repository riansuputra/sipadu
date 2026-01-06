<?php
// ================================
// KONEKSI DATABASE (PDO)
// ================================

// Konfigurasi database
$host = 'localhost';
$db   = 'sipadu';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

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
