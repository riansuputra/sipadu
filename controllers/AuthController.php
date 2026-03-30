<?php

require_once __DIR__ . '/../core/BaseController.php';

class AuthController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function login()
    {
        $this->guest();

        $this->view('auth/login', [
            'guest' => $this->guest(),
        ]);
    }

    public function authenticate()
    {
        if (Auth::check()) {
            $this->redirect('?page=dashboard');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (!$username) $errors['username'] = "Username wajib diisi.";
        if (!$password) $errors['password'] = "Password wajib diisi.";

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('?page=login');
        }

        $stmt = $this->db->prepare("
            SELECT 
                u.id,
                u.username,
                u.password_hash,
                u.nama_lengkap,
                r.id as role_id,
                r.kode_role,
                p.id AS pokja_id,
                pe.id AS pegawai_id,
                p.pokja_nama,
                p.pokja_tipe
            FROM users u
            JOIN role r ON u.role_id = r.id
            LEFT JOIN pokja p ON u.pokja_id = p.id
            LEFT JOIN pegawai pe ON u.pegawai_id = pe.id
            WHERE u.username = ?
            AND u.is_active = 1
            LIMIT 1
        ");

        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['errors'] = [
                '_global' => 'Username atau password salah.'
            ];
            $_SESSION['old'] = ['username' => $username];

            $this->redirect('?page=login');
        }

        Auth::login($user);

        $this->redirect('?page=dashboard');
    }
}
