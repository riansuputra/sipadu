<?php

require_once __DIR__ . '/../models/JenisPeraturanModel.php';
require_once __DIR__ . '/../core/auth.php';

class JenisPeraturanController
{
    public function index()
    {
        authOnly();
        global $pdo;

        $model = new JenisPeraturanModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/jenis_peraturan/index.php';
    }

    public function create()
    {
        authOnly();
        require __DIR__ . '/../views/jenis_peraturan/create.php';
    }

    public function store()
    {
        authOnly();
        global $pdo;

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

            header("Location: ?page=tambah-jenis-peraturan");
            exit;
        }

        $model = new JenisPeraturanModel($pdo);

        $model->store([
            'kode'       => $_POST['kode'],
            'nama'       => $_POST['nama'],
            'keterangan' => $_POST['keterangan'],
            'is_active'  => $_POST['is_active'] ?? 1
        ]);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Jenis peraturan berhasil disimpan'
        ];

        header("Location: ?page=jenis-peraturan");
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $model = new JenisPeraturanModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=jenis-peraturan");
    }
}
