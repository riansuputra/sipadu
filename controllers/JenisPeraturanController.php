<?php

require_once __DIR__ . '/../models/JenisPeraturanModel.php';
require_once __DIR__ . '/../core/auth.php';

class JenisPeraturanController
{
    public function index()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisPeraturanModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/jenis_peraturan/index.php';
    }

    public function create()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisPeraturanModel($pdo);
        $data  = $model->getAll();
        require __DIR__ . '/../views/jenis_peraturan/create.php';
    }

    public function store()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";
        // die();

        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        // if (empty($_POST['kode']))
        //     $errors[] = "Kode wajib diisi";

        // if (empty($_POST['nama']))
        //     $errors[] = "Nama wajib diisi";

        // if ($errors) {
        //     $_SESSION['flash'] = [
        //         'status' => 'error',
        //         'message' => implode("<br>", $errors)
        //     ];

        //     header("Location: ?page=tambah-jenis-peraturan");
        //     exit;
        // }

        $model = new JenisPeraturanModel($pdo);
        $data = $_POST;
        $jenis = $model->insert($data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis peraturan berhasil disimpan'
        ];

        header("Location: ?page=tambah-jenis-peraturan");
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisPeraturanModel($pdo);

        $id = $_GET['id'];

        $jenis = $model->getById($id);

        require __DIR__ . '/../views/jenis_peraturan/create.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisPeraturanModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);

        require __DIR__ . '/../views/jenis_peraturan/edit.php';
    }

    public function update()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['kode']))
            $errors[] = "Kode wajib diisi";

        if (empty($_POST['nama']))
            $errors[] = "Nama wajib diisi";

        if ($errors) {
            $_SESSION['flash'] = [
                'status' => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-jenis-peraturan&id=" . $_POST['id']);
            exit;
        }

        $model = new JenisPeraturanModel($pdo);
        $data = $_POST;
        $model->update($_POST['id'], $data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis peraturan berhasil diperbarui'
        ];

        header("Location: ?page=tambah-jenis-peraturan");
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisPeraturanModel($pdo);

        $id = $_GET['id'];

        // CEK DIPAKAI ATAU TIDAK
        if ($model->isUsed($id)) {

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'Jenis tidak dapat dihapus karena masih digunakan di data peraturan'
            ];

            header("Location: ?page=tambah-jenis-peraturan");
            exit;
        }

        $model->delete($id);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Jenis peraturan berhasil dinonaktifkan'
        ];

        header("Location: ?page=tambah-jenis-peraturan");
    }
}
