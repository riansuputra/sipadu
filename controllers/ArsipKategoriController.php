<?php

require_once __DIR__ . '/../models/ArsipKategoriModel.php';
require_once __DIR__ . '/../core/auth.php';


class ArsipKategoriController
{
    public function index()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipKategoriModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/arsip_kategori/index.php';
    }

    public function create()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipKategoriModel($pdo);
        $data  = $model->getAll();
        require __DIR__ . '/../views/arsip_kategori/create.php';
    }

    public function store()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['nama_kategori']))
            $errors[] = "Nama wajib diisi";

        if ($errors) {
            $_SESSION['flash'] = [
                'status' => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-arsip-kategori");
            exit;
        }

        $model = new ArsipKategoriModel($pdo);
        $data = $_POST;
        $jenis = $model->insert($data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Kategori Arsip berhasil disimpan'
        ];

        header("Location: ?page=tambah-arsip-kategori");
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipKategoriModel($pdo);

        $id = $_GET['id'];

        $jenis = $model->getById($id);

        require __DIR__ . '/../views/arsip_kategori/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipKategoriModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);

        require __DIR__ . '/../views/arsip_kategori/edit.php';
    }

    public function update()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['nama_kategori']))
            $errors[] = "Nama wajib diisi";

        if ($errors) {
            $_SESSION['flash'] = [
                'status' => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-arsip-kategori&id=" . $_POST['id']);
            exit;
        }

        $model = new ArsipKategoriModel($pdo);
        $data = $_POST;
        $model->update($_POST['id'], $data);

        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Kategori Arsip berhasil diperbarui'
        ];

        header("Location: ?page=tambah-arsip-kategori");
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipKategoriModel($pdo);

        $id = $_GET['id'];

        // CEK DIPAKAI ATAU TIDAK
        if ($model->isUsed($id)) {

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'Kategori tidak dapat dihapus karena masih digunakan di data arsip'
            ];

            header("Location: ?page=tambah-arsip-kategori");
            exit;
        }

        $model->delete($id);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Kategori arsip berhasil dinonaktifkan'
        ];

        header("Location: ?page=tambah-arsip-kategori");
    }
}
