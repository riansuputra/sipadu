<?php
// ================================
// AUTH CONTROLLER
// ================================

require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../core/auth.php';

class AuthController
{
    // ----------------------------
    // TAMPILKAN HALAMAN LOGIN
    // ----------------------------
    public function login()
    {
        // Menampilkan form login
        require __DIR__ . '/../views/auth/login.php';
    }

    // ----------------------------
    // PROSES LOGIN USER
    // ----------------------------
    public function authenticate()
    {
        // Jika sudah login, langsung ke dashboard
        if (isLoggedIn()) {
            redirectByRole();
        }

        global $pdo;

        // Ambil input
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $errors = [];

        // Validasi sederhana
        if (empty($username)) {
            $errors['username'] = "Username wajib diisi.";
        }

        if (empty($password)) {
            $errors['password'] = 'Password wajib diisi.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            header('Location: ' . url('?page=login'));
            exit;
        }

        // ----------------------------
        // QUERY USER
        // ----------------------------
        $stmt = $pdo->prepare("
            SELECT 
                u.id,
                u.username,
                u.password_hash,
                u.nama_lengkap,
                r.id as role_id,
                r.kode_role,
                p.id AS pokja_id,
                p.pokja_nama AS pokja_nama,
                p.pokja_tipe AS pokja_tipe
            FROM users u
            JOIN role r ON u.role_id = r.id
            LEFT JOIN pokja p ON u.pokja_id = p.id
            WHERE u.username = ?
              AND u.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // ----------------------------
        // CEK USER & PASSWORD
        // ----------------------------
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['errors'] = [
                '_global' => 'Username atau password salah.'
            ];
            $_SESSION['old'] = ['username' => $username];

            header('Location: ' . url('?page=login'));
            exit;
        }

        // ----------------------------
        // LOGIN BERHASIL
        // ----------------------------
        loginUser($user);

        // Redirect ke dashboard
        redirectByRole();
    }
}
