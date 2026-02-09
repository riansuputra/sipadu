<?php

require_once __DIR__ . '/../models/PublikasiJenisModel.php';
require_once __DIR__ . '/../core/auth.php';

class PublikasiJenisController
{
    public function index()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiJenisModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/jenis_publikasi/index.php';
    }

    public function create()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiJenisModel($pdo);
        $data  = $model->getAll();
        require __DIR__ . '/../views/jenis_publikasi/create.php';
    }

    public function store()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors['nama'] = "Jenis publikasi wajib diisi";
        }
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: " . url('?page=tambah-jenis-publikasi'));
            exit();
        }

        $model = new PublikasiJenisModel($pdo);
        $data = $_POST;
        $jenis = $model->insert($data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis publikasi berhasil disimpan'
        ];

        header("Location: " . url('?page=tambah-jenis-publikasi'));
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiJenisModel($pdo);

        $id = $_GET['id'];

        $jenis = $model->getById($id);

        require __DIR__ . '/../views/jenis_publikasi/create.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiJenisModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);

        require __DIR__ . '/../views/jenis_publikasi/edit.php';
    }

    public function update()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors['nama'] = "Jenis publikasi wajib diisi";
        }
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: " . url('?page=tambah-jenis-publikasi&id=' . $_POST['id']));
            exit();
        }

        $model = new PublikasiJenisModel($pdo);
        $data = $_POST;
        $model->update($_POST['id'], $data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis publikasi berhasil diperbarui'
        ];

        header("Location: " . url('?page=tambah-jenis-publikasi'));
        exit();
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiJenisModel($pdo);

        $id = $_GET['id'];

        // CEK DIPAKAI ATAU TIDAK
        if ($model->isUsed($id)) {

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'Jenis tidak dapat dihapus karena masih digunakan di data publikasi'
            ];

            header("Location: " . url('?page=tambah-jenis-publikasi'));
            exit;
        }

        $model->delete($id);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Jenis publikasi berhasil dinonaktifkan'
        ];

        header("Location: " . url('?page=tambah-jenis-publikasi'));
    }
}
