<?php

require_once __DIR__ . '/../models/JenisDokumenModel.php';
require_once __DIR__ . '/../core/auth.php';

class JenisDokumenController
{
    public function index()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisDokumenModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/jenis_dokumen/index.php';
    }

    public function create()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisDokumenModel($pdo);
        $data  = $model->getAll();
        require __DIR__ . '/../views/jenis_dokumen/create.php';
    }

    public function store()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['nama']))
            $errors[] = "Nama wajib diisi";

        if ($errors) {
            $_SESSION['flash'] = [
                'status' => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-jenis-dokumen");
            exit;
        }

        $model = new JenisDokumenModel($pdo);
        $data = $_POST;
        $jenis = $model->insert($data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis dokumen berhasil disimpan'
        ];

        header("Location: ?page=tambah-jenis-dokumen");
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisDokumenModel($pdo);

        $id = $_GET['id'];

        $jenis = $model->getById($id);

        require __DIR__ . '/../views/jenis_dokumen/create.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisDokumenModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);

        require __DIR__ . '/../views/jenis_dokumen/edit.php';
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

            header("Location: ?page=tambah-jenis-dokumen&id=" . $_POST['id']);
            exit;
        }

        $model = new JenisDokumenModel($pdo);
        $data = $_POST;
        $model->update($_POST['id'], $data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis dokumen berhasil diperbarui'
        ];

        header("Location: ?page=tambah-jenis-dokumen");
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new JenisDokumenModel($pdo);

        $id = $_GET['id'];

        // CEK DIPAKAI ATAU TIDAK
        if ($model->isUsed($id)) {

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'Jenis tidak dapat dihapus karena masih digunakan di data dokumen'
            ];

            header("Location: ?page=tambah-jenis-dokumen");
            exit;
        }

        $model->delete($id);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Jenis dokumen berhasil dinonaktifkan'
        ];

        header("Location: ?page=tambah-jenis-dokumen");
    }
}
