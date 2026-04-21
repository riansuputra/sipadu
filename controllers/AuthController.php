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

        $userModel = $this->model('UserModel');
        $aksesPokja = $userModel->getUserPokja($user['id']);

        $_SESSION['akses_pokja'] = $aksesPokja;

        if (count($aksesPokja) === 1) {

            // langsung set active
            $_SESSION['active_pokja'] = [
                'id'   => $aksesPokja[0]['pokja_id'],
                'nama' => $aksesPokja[0]['nama'],
                'slug' => $aksesPokja[0]['slug'],
                'tipe' => $aksesPokja[0]['tipe'],
            ];

            $this->redirect('?page=dashboard');
        }

        // 🔥 kalau lebih dari 1 → ke halaman pilih
        $this->redirect('?page=pilih-pokja');
    }

    // ================================
    // HALAMAN SWITCH POKJA
    // ================================
    public function switchPokjaPage()
    {
        $this->auth();

        $userModel = $this->model('UserModel');

        $pokjaList = $userModel->getUserPokjaList($this->user['id']);

        $this->view('auth/switch-pokja', [
            'pokjaList' => $pokjaList,
            'currentPokja' => $this->user['pokja_id']
        ]);
    }

    // ================================
    // PROSES SWITCH POKJA
    // ================================
    public function switchPokja()
    {
        $this->auth();

        $pokjaId = (int)($_GET['id'] ?? 0);

        if (!$pokjaId) {
            $this->abort403();
        }

        $userModel = $this->model('UserModel');
        $pokjaList = $userModel->getUserPokjaList($this->user['id']);

        $valid = false;

        foreach ($pokjaList as $pokja) {
            if ((int)$pokja['id'] === $pokjaId) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            $this->abort403();
        }

        // 🔥 INI INTI SISTEM
        $_SESSION['user']['pokja_id'] = $pokjaId;

        foreach ($pokjaList as $pokja) {
            if ((int)$pokja['id'] === $pokjaId) {
                $_SESSION['user']['pokja_nama'] = $pokja['pokja_nama'];
                $_SESSION['user']['pokja_tipe'] = $pokja['pokja_tipe'];
                break;
            }
        }

        Auth::init();

        $this->flash('success', 'Berhasil pindah pokja.');

        $this->redirect('?page=dashboard');
    }
}
