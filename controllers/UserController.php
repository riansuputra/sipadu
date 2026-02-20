<?php

require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    public function index()
    {
        global $pdo;

        $user = currentUser();
        $role = currentRole();
        $model = new UserModel($pdo);
        $users = $model->getAll();

        require __DIR__ . '/../views/user/index.php';
    }

    public function create()
    {
        authOnly();
        roleOnly(['Superadmin']);

        $user = currentUser();
        $role = currentRole();

        global $pdo;

        $model = new UserModel($pdo);

        // data untuk form
        $roles = $model->getRoles();
        $pokja = $model->getPokja();

        require __DIR__ . '/../views/user/create.php';
    }


    public function store()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";
        // die();
        authOnly();

        $user = currentUser();
        $role = currentRole();
        roleOnly(['Superadmin']);

        global $pdo;
        $model = new UserModel($pdo);

        $errors = [];

        $username     = trim($_POST['username'] ?? '');
        $password     = $_POST['password'] ?? '';
        $nama         = trim($_POST['nama_lengkap'] ?? '');
        $roleId       = $_POST['role_id'] ?? '';
        $pokjaId      = $_POST['pokja_id'] ?? null;

        // ============================
        // VALIDASI
        // ============================
        if ($username === '') {
            $errors['username'] = 'Username wajib diisi';
        } elseif ($model->usernameExists($_POST['username'])) {
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

        /**
         * RULE PENTING:
         * - STAFF / ADMIN TIM → WAJIB PUNYA POKJA
         * - SUPERADMIN / PIMPINAN → POKJA BOLEH NULL
         */
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

        // ============================
        // SIMPAN
        // ============================
        $model->insert([
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
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();
        authOnly();

        global $pdo;

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

        $model = new UserModel($pdo);

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
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $model = new UserModel($pdo);
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
        authOnly();

        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: ?page=user");
            exit;
        }

        $model = new UserModel($pdo);

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


    // public function updatePassword()
    // {
    //     authOnly();
    //     roleOnly(['Superadmin']);
    //     $user = currentUser();
    //     $role = currentRole();

    //     global $pdo;
    //     $errors = [];

    //     $id = (int)$_POST['id'];
    //     $password = $_POST['password'] ?? '';
    //     $confirm  = $_POST['password_confirm'] ?? '';

    //     if ($password === '') {
    //         $errors['password'] = 'Password wajib diisi';
    //     } elseif (strlen($password) < 6) {
    //         $errors['password'] = 'Password minimal 6 karakter';
    //     }

    //     if ($password !== $confirm) {
    //         $errors['password_confirm'] = 'Konfirmasi password tidak sama';
    //     }

    //     if (!empty($errors)) {
    //         $_SESSION['errors'] = $errors;
    //         header('Location: ?page=user-password&id=' . $id);
    //         exit;
    //     }

    //     $model = new UserModel($pdo);
    //     $model->updatePassword($id, $password);

    //     $_SESSION['flash'] = [
    //         'status' => 'success',
    //         'message' => 'Password berhasil diubah'
    //     ];

    //     header('Location: ?page=user');
    //     exit;
    // }
}
