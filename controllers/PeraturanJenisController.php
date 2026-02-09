<?php

require_once __DIR__ . '/../models/PeraturanJenisModel.php';
require_once __DIR__ . '/../core/auth.php';

class PeraturanJenisController
{
    public function index()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanJenisModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/jenis_peraturan/index.php';
    }

    public function create()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanJenisModel($pdo);
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

        if (empty($_POST['kode'])) {
            $errors['kode'] = "Singkatan jenis wajib diisi";
        }
        if (empty($_POST['nama'])) {
            $errors['nama'] = "Jenis peraturan wajib diisi";
        }
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: " . url('?page=tambah-jenis-peraturan'));
            exit();
        }

        $model = new PeraturanJenisModel($pdo);
        $data = $_POST;
        $jenis = $model->insert($data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis peraturan berhasil disimpan'
        ];

        header("Location: " . url('?page=tambah-jenis-peraturan'));
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanJenisModel($pdo);

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

        $model = new PeraturanJenisModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);

        require __DIR__ . '/../views/jenis_peraturan/edit.php';
    }

    public function update()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();

        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['kode'])) {
            $errors['kode'] = "Singkatan jenis wajib diisi";
        }
        if (empty($_POST['nama'])) {
            $errors['nama'] = "Jenis peraturan wajib diisi";
        }
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: " . url('?page=tambah-jenis-peraturan&id=' . $_POST['id']));
            exit();
        }

        $model = new PeraturanJenisModel($pdo);
        $data = $_POST;
        $model->update($_POST['id'], $data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis peraturan berhasil diperbarui'
        ];

        header("Location: " . url('?page=tambah-jenis-peraturan'));
        exit();
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanJenisModel($pdo);

        $id = $_GET['id'];

        // CEK DIPAKAI ATAU TIDAK
        if ($model->isUsed($id)) {

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'Jenis tidak dapat dihapus karena masih digunakan di data peraturan'
            ];

            header("Location: " . url('?page=tambah-jenis-peraturan'));
            exit;
        }

        $model->delete($id);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Jenis peraturan berhasil dinonaktifkan'
        ];

        header("Location: " . url('?page=tambah-jenis-peraturan'));
        exit;
    }
}
