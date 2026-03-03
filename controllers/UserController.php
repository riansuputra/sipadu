<?php

require_once __DIR__ . '/../core/BaseController.php';

class UserController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('UserModel');
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

        $this->view('user/create', [
            'roles' => $roles,
            'pokja' => $pokja,
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

        // echo "<pre>";
        // print_r($errors);
        // echo "</pre>";
        // die();

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ?page=tambah-user');
            exit;
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

        header('Location: ?page=tambah-user');
        exit;
    }

    // ================================
    // UPDATE USER
    // ================================
    public function update()
    {
        // dd($_POST);
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();
        $this->auth();



        $id = $_POST['id'];

        $errors = [];

        if (empty($_POST['nama_lengkap'])) {
            $errors['nama_lengkap'] = "Nama wajib diisi";
        }

        if (empty($_POST['role_id'])) {
            $errors['role_id'] = "Role wajib dipilih";
        }

        // echo "<pre>";
        // print_r($errors);
        // echo "</pre>";
        // die();

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            header("Location: ?page=user-edit&id=" . $id);
            exit;
        }

        $model = new UserModel();

        $model->update($id, $_POST);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'User berhasil diperbarui'
        ];

        header("Location: ?page=user");
        exit;
    }


    public function editPassword()
    {

        $user = $this->user;
        $role = $this->role;

        $model = new UserModel();
        $user = $model->findById($_GET['id']);

        if (!$user) {
            http_response_code(404);
            echo 'User tidak ditemukan';
            exit;
        }

        require __DIR__ . '/../views/user/edit-password.php';
    }

    // ================================
    // FORM EDIT USER
    // ================================
    public function edit()
    {
        $this->auth();


        $user = $this->user;
        $role = $this->role;

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: ?page=user");
            exit;
        }

        $model = new UserModel();

        $data = $model->findById($id);

        if (!$data) {
            $_SESSION['flash'] = [
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ];

            header("Location: ?page=user");
            exit;
        }

        // untuk dropdown
        $roles = $model->getRoles();
        $pokja = $model->getPokja();

        require __DIR__ . '/../views/user/edit.php';
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
}
