<?php

require_once __DIR__ . '/../models/PublikasiJenisModel.php';
require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../core/BaseController.php';

class PublikasiJenisController extends BaseController
{
    public function index()
    {
        $this->auth();


        $user = $this->user;
        $role = $this->role;

        $model = new PublikasiJenisModel();
        $data  = $model->getAll();

        require __DIR__ . '/../views/jenis_publikasi/index.php';
    }

    public function create()
    {
        $this->auth();


        $user = $this->user;
        $role = $this->role;

        $model = new PublikasiJenisModel();
        $data  = $model->getAll();
        require __DIR__ . '/../views/jenis_publikasi/create.php';
    }

    public function store()
    {
        $this->auth();

        $user = $this->user;
        $role = $this->role;

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

        $model = new PublikasiJenisModel();
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
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        $model = new PublikasiJenisModel();

        $id = $_GET['id'];

        $jenis = $model->getById($id);

        require __DIR__ . '/../views/jenis_publikasi/create.php';
    }

    public function edit()
    {
        $this->auth();



        $user = $this->user;
        $role = $this->role;

        $model = new PublikasiJenisModel();

        $id = $_GET['id'];

        $publikasi = $model->getById($id);

        require __DIR__ . '/../views/jenis_publikasi/edit.php';
    }

    public function update()
    {
        $this->auth();

        $user = $this->user;
        $role = $this->role;

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

        $model = new PublikasiJenisModel();
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
        $this->auth();


        $user = $this->user;
        $role = $this->role;

        $model = new PublikasiJenisModel();

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
