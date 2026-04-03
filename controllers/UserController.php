<?php

require_once __DIR__ . '/../core/BaseController.php';

class UserController extends BaseController
{
    private $model;
    private $modelPegawai;

    public function __construct()
    {
        $this->model = $this->model('UserModel');
        $this->modelPegawai = $this->model('PegawaiModel');
    }

    public function index()
    {
        $this->auth();

        $data = $this->model->getAll();

        $this->view('user/index', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function create()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $roles = $this->model->getRoles();
        $pokja = $this->model->getPokja();
        $pegawai = $this->modelPegawai->getAll();

        $this->view('user/create', [
            'roles' => $roles,
            'pokja' => $pokja,
            'pegawai' => $pegawai,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $errors = [];

        $username     = trim($_POST['username'] ?? '');
        $password     = $_POST['password'] ?? '';
        $nama         = trim($_POST['nama_lengkap'] ?? '');
        $roleId       = $_POST['role_id'] ?? '';
        $pokjaId      = $_POST['pokja_id'] ?? null;

        if ($username === '') {
            $errors['username'] = 'Username wajib diisi';
        } elseif ($this->model->usernameExists($_POST['username'])) {
            $errors['username'] = 'Username sudah digunakan';
        }

        if ($password === '') {
            $errors['password'] = 'Password wajib diisi';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password minimal 6 karakter';
        }

        if ($nama === '') {
            $errors['nama_lengkap'] = 'Nama lengkap wajib diisi';
        }

        if ($roleId === '') {
            $errors['role_id'] = 'Role wajib dipilih';
        }

        if (in_array($roleId, getRoleButuhPokja()) && empty($pokjaId)) {
            $errors['pokja_id'] = 'Pokja wajib diisi untuk role ini';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            $this->redirect('?page=tambah-user');
        }

        $this->model->insert([
            'username'     => $username,
            'password'     => $password,
            'nama_lengkap' => $nama,
            'pegawai_id'   => $_POST['pegawai_id'] ?? null,
            'role_id'      => $roleId,
            'pokja_id'     => $pokjaId
        ]);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'User berhasil ditambahkan'
        ];

        $this->redirect('?page=tambah-user');
    }

    public function update()
    {
        $this->auth();

        $id = $_POST['id'];

        $errors = [];

        if (empty($_POST['username'])) {
            $errors['username'] = "Username wajib diisi";
        }

        if (empty($_POST['nama_lengkap'])) {
            $errors['nama_lengkap'] = "Nama wajib diisi";
        }

        if (empty($_POST['role_id'])) {
            $errors['role_id'] = "Role wajib dipilih";
        }

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            $this->redirect('?page=user-edit&id=' . $id);
        }

        $this->model->update($id, $_POST);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'User berhasil diperbarui'
        ];

        $this->redirect('?page=user');
    }


    public function editPassword()
    {
        $this->auth();

        $user = $this->model->findById($_GET['id']);

        if (!$user) {
            http_response_code(404);
            echo 'User tidak ditemukan';
            exit;
        }

        $this->view('user/edit-password', [
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $this->redirect('?page=user');
        }

        $data = $this->model->findById($id);

        if (!$data) {
            $_SESSION['flash'] = [
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ];

            $this->redirect('?page=user');
        }

        $roles = $this->model->getRoles();
        $pokja = $this->model->getPokja();
        $pegawai = $this->modelPegawai->getAll();

        $this->view('user/edit', [
            'data' => $data,
            'roles' => $roles,
            'pokja' => $pokja,
            'pegawai' => $pegawai,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=user');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=user');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if (!$this->model->delete($id, $this->user['id'])) {
                throw new Exception("Gagal nonaktifkan user");
            }

            $this->model->commit();

            $this->flash('success', 'User berhasil dinonaktifkan');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal nonaktifkan user');
        }

        return $this->redirect('?page=user');
    }

    public function active()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=user');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=user');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if (!$this->model->active($id, $this->user['id'])) {
                throw new Exception("Gagal aktifkan user");
            }

            $this->model->commit();

            $this->flash('success', 'User berhasil diaktifkan');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal aktifkan user');
        }

        return $this->redirect('?page=user');
    }

    public function indexTim()
    {
        $this->auth();

        $data = $this->model->getAll();

        $this->view('tim/create', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function createTim()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $roles = $this->model->getRoles();
        $pokja = $this->model->getPokja();

        $this->view('user/create', [
            'roles' => $roles,
            'pokja' => $pokja,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function storeTim()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $errors = [];

        $username     = trim($_POST['username'] ?? '');
        $password     = $_POST['password'] ?? '';
        $nama         = trim($_POST['nama_lengkap'] ?? '');
        $roleId       = $_POST['role_id'] ?? '';
        $pokjaId      = $_POST['pokja_id'] ?? null;

        if ($username === '') {
            $errors['username'] = 'Username wajib diisi';
        } elseif ($this->model->usernameExists($_POST['username'])) {
            $errors['username'] = 'Username sudah digunakan';
        }

        if ($password === '') {
            $errors['password'] = 'Password wajib diisi';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password minimal 6 karakter';
        }

        if ($nama === '') {
            $errors['nama_lengkap'] = 'Nama lengkap wajib diisi';
        }

        if ($roleId === '') {
            $errors['role_id'] = 'Role wajib dipilih';
        }

        if (in_array($roleId, getRoleButuhPokja()) && empty($pokjaId)) {
            $errors['pokja_id'] = 'Pokja wajib diisi untuk role ini';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            $this->redirect('?page=tambah-user');
        }

        $this->model->insert([
            'username'     => $username,
            'password'     => $password,
            'nama_lengkap' => $nama,
            'role_id'      => $roleId,
            'pokja_id'     => $pokjaId
        ]);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'User berhasil ditambahkan'
        ];

        $this->redirect('?page=tambah-user');
    }

    public function updateTim()
    {
        $this->auth();

        $id = $_POST['id'];

        $errors = [];

        if (empty($_POST['username'])) {
            $errors['username'] = "Username wajib diisi";
        }

        if (empty($_POST['nama_lengkap'])) {
            $errors['nama_lengkap'] = "Nama wajib diisi";
        }

        if (empty($_POST['role_id'])) {
            $errors['role_id'] = "Role wajib dipilih";
        }

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            $this->redirect('?page=user-edit&id=' . $id);
        }

        $this->model->update($id, $_POST);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'User berhasil diperbarui'
        ];

        $this->redirect('?page=user');
    }

    public function deleteTim()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=user');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=user');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if (!$this->model->delete($id, $this->user['id'])) {
                throw new Exception("Gagal nonaktifkan user");
            }

            $this->model->commit();

            $this->flash('success', 'User berhasil dinonaktifkan');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal nonaktifkan user');
        }

        return $this->redirect('?page=user');
    }
}
