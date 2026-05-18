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
            u.secret_code,
            u.is_2fa_enabled,

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
        // SIMPAN PENDING LOGIN
        // =========================
        $_SESSION['pending_login'] = [
            'user' => (array)$user,
            'akses_pokja' => $aksesPokja,
            'expired_at' => time() + 300
        ];

        // =========================
        // BELUM SETUP 2FA
        // =========================
        if (
            empty($user['secret_code']) ||
            !$user['is_2fa_enabled']
        ) {

            $this->redirect('?page=setup-2fa');
        }

        // =========================
        // SUDAH SETUP 2FA
        // =========================
        $this->redirect('?page=verify-2fa');
        // dd($_SESSION['user']);

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

    public function setup2FA()
    {
        $pending = $_SESSION['pending_login'] ?? null;

        if (!$pending) {
            $this->redirect('?page=login');
        }

        require_once __DIR__ . '/../core/GoogleAuthenticator.php';

        $ga = new PHPGangsta_GoogleAuthenticator();

        // jika belum ada secret di session
        if (empty($_SESSION['2fa_setup_secret'])) {

            $_SESSION['2fa_setup_secret'] = $ga->createSecret();
        }

        $secret = $_SESSION['2fa_setup_secret'];

        $appName = 'SIPADU';

        $username = $pending['user']['username'];

        // format TOTP standar
        $otpauth = 'otpauth://totp/' .
            rawurlencode($appName . ':' . $username) .
            '?secret=' . $secret .
            '&issuer=' . rawurlencode($appName);

        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data="
            . urlencode($otpauth);

        $this->view('auth/setup-2fa', [
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    public function verifySetup2FA()
    {
        $pending = $_SESSION['pending_login'] ?? null;

        if (!$pending) {
            $this->redirect('?page=login');
        }

        require_once __DIR__ . '/../core/GoogleAuthenticator.php';

        $otp = trim($_POST['otp_code'] ?? '');

        $secret = $_SESSION['2fa_setup_secret'] ?? null;

        if (!$secret) {
            $this->redirect('?page=setup-2fa');
        }

        $ga = new PHPGangsta_GoogleAuthenticator();

        $check = $ga->verifyCode($secret, $otp, 2);

        if (!$check) {

            $this->flash('error', 'Kode OTP tidak valid.');

            $this->redirect('?page=setup-2fa');
        }

        $stmt = $this->db->prepare("
        UPDATE users
        SET
            secret_code = ?,
            is_2fa_enabled = 1
        WHERE id = ?
    ");

        $stmt->execute([
            $secret,
            $pending['user']['id']
        ]);


        $user = $pending['user'];

        Auth::login($user);

        $_SESSION['akses_pokja'] = $pending['akses_pokja'];

        // hapus session sementara
        unset($_SESSION['pending_login']);
        unset($_SESSION['2fa_setup_secret']);

        $this->flash('success', 'Google Authenticator berhasil diaktifkan.');

        // =========================
        // FLOW POKJA
        // =========================
        if (count($_SESSION['akses_pokja']) === 0) {

            $this->redirect('?page=dashboard');
        }

        if (count($_SESSION['akses_pokja']) === 1) {

            $_SESSION['active_pokja'] = [
                'id'   => $_SESSION['akses_pokja'][0]['pokja_id'],
                'nama' => $_SESSION['akses_pokja'][0]['nama'],
                'slug' => $_SESSION['akses_pokja'][0]['slug'],
                'tipe' => $_SESSION['akses_pokja'][0]['tipe'],
            ];

            $this->redirect('?page=dashboard');
        }

        $this->redirect('?page=pilih-pokja');
    }

    public function verify2FA()
    {
        $pending = $_SESSION['pending_login'] ?? null;

        if (!$pending) {
            $this->redirect('?page=login');
        }

        // expired
        if (time() > $pending['expired_at']) {

            unset($_SESSION['pending_login']);

            $this->flash('error', 'Session login expired.');

            $this->redirect('?page=login');
        }

        $this->view('auth/verify-2fa');
    }

    public function verify2FAProcess()
    {
        require_once __DIR__ . '/../core/GoogleAuthenticator.php';

        $pending = $_SESSION['pending_login'] ?? null;

        if (!$pending) {
            $this->redirect('?page=login');
        }

        // expired
        if (time() > $pending['expired_at']) {

            unset($_SESSION['pending_login']);

            $this->flash('error', 'Session login expired.');

            $this->redirect('?page=login');
        }

        $otp = trim($_POST['otp_code'] ?? '');

        $user = $pending['user'];

        $ga = new PHPGangsta_GoogleAuthenticator();

        $check = $ga->verifyCode(
            $user['secret_code'],
            $otp,
            2
        );

        if (!$check) {

            $this->flash('error', 'Kode OTP salah.');

            $this->redirect('?page=verify-2fa');
        }

        // =========================
        // LOGIN FINAL
        // =========================
        Auth::login($user);

        $_SESSION['akses_pokja'] = $pending['akses_pokja'];

        unset($_SESSION['pending_login']);

        // =========================
        // FLOW POKJA
        // =========================
        if (count($_SESSION['akses_pokja']) === 0) {

            $this->redirect('?page=dashboard');
        }

        if (count($_SESSION['akses_pokja']) === 1) {

            $_SESSION['active_pokja'] = [
                'id'   => $_SESSION['akses_pokja'][0]['pokja_id'],
                'nama' => $_SESSION['akses_pokja'][0]['nama'],
                'slug' => $_SESSION['akses_pokja'][0]['slug'],
                'tipe' => $_SESSION['akses_pokja'][0]['tipe'],
            ];

            $this->redirect('?page=dashboard');
        }

        $this->redirect('?page=pilih-pokja');
    }
}
