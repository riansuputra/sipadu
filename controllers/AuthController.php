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

        if (!$username) {
            $errors['username'] = "Username wajib diisi.";
        }

        if (!$password) {
            $errors['password'] = "Password wajib diisi.";
        }

        if ($errors) {

            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            $this->redirect('?page=login');
        }

        // =========================
        // LOGIN USER
        // =========================
        $stmt = $this->db->prepare("
        SELECT 
            u.id,
            u.username,
            u.password_hash,
            u.nama_lengkap,

            pe.id AS pegawai_id,

            pf.path_file AS foto_profile

        FROM users u

        LEFT JOIN pegawai pe 
            ON u.pegawai_id = pe.id

        LEFT JOIN pegawai_file pf
            ON pf.id = (
                SELECT pff.id
                FROM pegawai_file pff
                WHERE pff.pegawai_id = pe.id
                AND pff.jenis_dokumen = 'file_foto'
                AND pff.is_active = 1
                ORDER BY pff.id DESC
                LIMIT 1
            )

        WHERE u.username = ?
        AND u.is_active = 1

        LIMIT 1
    ");

        $stmt->execute([$username]);

        $user = $stmt->fetch();

        // =========================
        // VALIDASI LOGIN
        // =========================
        if (!$user || !password_verify($password, $user['password_hash'])) {

            $_SESSION['errors'] = [
                '_global' => 'Username atau password salah.'
            ];

            $_SESSION['old'] = [
                'username' => $username
            ];

            $this->redirect('?page=login');
        }

        // =========================
        // FOTO PROFILE
        // =========================
        $pegawaiModel = $this->model('PegawaiModel');

        $user['foto_profile'] = $pegawaiModel->getFotoProfile(
            $user['pegawai_id']
        );

        // =========================
        // AMBIL AKSES POKJA USER
        // =========================
        $userModel = $this->model('UserModel');

        $aksesPokja = $userModel->getUserPokja($user['id']);

        // =========================
        // CARI DEFAULT POKJA
        // =========================
        $defaultPokja = null;

        foreach ($aksesPokja as $ap) {

            if ($ap['is_default']) {

                $defaultPokja = $ap;
                break;
            }
        }

        // fallback kalau tidak ada default
        if (!$defaultPokja && !empty($aksesPokja)) {

            $defaultPokja = $aksesPokja[0];
        }

        // =========================
        // SET ROLE + POKJA AKTIF
        // =========================
        if ($defaultPokja) {

            $user['pokja_id']   = $defaultPokja['pokja_id'];
            $user['pokja_nama'] = $defaultPokja['nama'];
            $user['pokja_tipe'] = $defaultPokja['tipe'];

            $user['role_id'] = $defaultPokja['role_id'];
            $user['role']    = $defaultPokja['kode_role'];
        } else {

            // fallback kalau user belum punya pokja
            $user['pokja_id']   = null;
            $user['pokja_nama'] = null;
            $user['pokja_tipe'] = null;

            $user['role_id'] = null;
            $user['role']    = null;
        }

        // =========================
        // LOGIN SESSION
        // =========================

        // dd($user);
        Auth::login($user);

        // =========================
        // SIMPAN LIST POKJA
        // =========================
        $_SESSION['akses_pokja'] = $aksesPokja;

        // =========================
        // TIDAK PUNYA POKJA
        // =========================
        if (count($aksesPokja) === 0) {

            $this->redirect('?page=dashboard');
        }

        // =========================
        // HANYA 1 POKJA
        // =========================
        if (count($aksesPokja) === 1) {

            $_SESSION['active_pokja'] = [
                'id'   => $aksesPokja[0]['pokja_id'],
                'nama' => $aksesPokja[0]['nama'],
                'slug' => $aksesPokja[0]['slug'],
                'tipe' => $aksesPokja[0]['tipe'],
            ];

            $this->redirect('?page=dashboard');
        }

        // =========================
        // MULTI POKJA
        // =========================
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
        foreach ($pokjaList as $pokja) {

            if ((int)$pokja['id'] === $pokjaId) {

                // =========================
                // UPDATE SESSION POKJA
                // =========================
                $_SESSION['user']['pokja_id']   = $pokja['id'];
                $_SESSION['user']['pokja_nama'] = $pokja['pokja_nama'];
                $_SESSION['user']['pokja_tipe'] = $pokja['pokja_tipe'];

                // =========================
                // UPDATE SESSION ROLE
                // =========================
                $_SESSION['user']['role_id'] = $pokja['role_id'];
                $_SESSION['user']['role']    = $pokja['kode_role'];

                // dd($_SESSION['user']);


                break;
            }
        }

        foreach ($pokjaList as $pokja) {
            if ((int)$pokja['id'] === $pokjaId) {
                $_SESSION['user']['pokja_nama'] = $pokja['pokja_nama'];
                $_SESSION['user']['pokja_tipe'] = $pokja['pokja_tipe'];
                break;
            }
        }

        Auth::init();

        $this->flash('success', 'Berhasil berpindah akses sebagai ' . $pokja['pokja_nama'] . '.');

        $this->redirect('?page=dashboard');
    }
}
