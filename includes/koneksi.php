<?php

// // Konfigurasi database lokal
// $host = 'localhost';
// $db   = 'db_sipadu';
// $user = 'root';
// $pass = '';
// $charset = 'utf8mb4';

// // Konfigurasi database server
// // $host = 'db.bpmpbali.id';
// // $db   = 'db_sipadu';
// // $user = 'root';
// // $pass = 'Denpasar14';
// // $charset = 'utf8mb4';

// // Konfigurasi database termux ke server db infinityfree
// // $host = 'sql12.freesqldatabase.com';
// // $db   = 'sql12815967';
// // $user = 'sql12815967';
// // $pass = 'CrDhIVdFUn';
// // $charset = 'utf8mb4';

// try {
//     // Membuat koneksi PDO
//     $pdo = new PDO(
//         "mysql:host=$host;dbname=$db;charset=$charset",
//         $user,
//         $pass,
//         [
//             // Menampilkan error PDO sebagai exception
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

//             // Fetch default sebagai associative array
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         ]
//     );
// } catch (PDOException $e) {
//     // Jika koneksi gagal, hentikan aplikasi
//     die('Koneksi database gagal: ' . $e->getMessage());
// }

class Database
{
    private static $instance = null;
    private $conn;

    // constructor private → tidak bisa dibuat dari luar
    private function __construct()
    {
        $host = "localhost";
        $dbname = "db_sipadu";
        $user = "root";
        $pass = "";

        try {
            $this->conn = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }

    // ambil instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->conn;
    }
}
