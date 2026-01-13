<?php

require_once __DIR__ . '/../models/PeraturanModel.php';
require_once __DIR__ . '/../models/JenisPeraturanModel.php';
require_once __DIR__ . '/../core/auth.php';

class PeraturanController
{
    public function index()
    {
        authOnly();

        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/peraturan/index.php';
    }

    public function create()
    {
        authOnly();

        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $modeljenis = new JenisPeraturanModel($pdo);
        $jenis = $modeljenis->getAll();

        require __DIR__ . '/../views/peraturan/create.php';
    }

    public function store()
    {
        authOnly();
        global $pdo;

        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";
        // die();

        $user = currentUser();
        $role = currentRole();

        $errors = [];

        if (empty($_POST['judul']))
            $errors[] = "Judul wajib diisi";

        if (empty($_POST['jenis_id']))
            $errors[] = "Jenis peraturan wajib dipilih";

        if (!empty($errors)) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-peraturan");
            exit;
        }

        $model = new PeraturanModel($pdo);

        $data = $_POST;
        $id = $model->insert($data);

        // ============= UPLOAD FILE ==============
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/peraturan/';

            if (!is_dir($dir))
                mkdir($dir, 0777, true);

            foreach ($_FILES['file']['name'] as $i => $nama) {

                if (!$nama) continue;

                $tmp  = $_FILES['file']['tmp_name'][$i];
                $type = $_FILES['file']['type'][$i];
                $size = $_FILES['file']['size'][$i];

                $namaBaru = time() . '_' . $i . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);

                move_uploaded_file($tmp, $dir . $namaBaru);

                $model->insertFile($id, [
                    'nama_file'   => $nama,
                    'path_file'   => 'uploads/peraturan/' . $namaBaru,
                    'tipe_file'   => $type,
                    'ukuran_file' => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Peraturan berhasil disimpan'
        ];

        header("Location: ?page=tambah-peraturan");
        exit;
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanModel($pdo);

        $id = $_GET['id'];

        $peraturan = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/peraturan/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanModel($pdo);

        $id = $_GET['id'];

        $peraturan = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/peraturan/edit.php';
    }

    public function update()
    {
        authOnly();
        global $pdo;

        $errors = [];

        if (empty($_POST['judul']))
            $errors[] = "Judul wajib diisi";

        if (empty($_POST['jenis_id']))
            $errors[] = "Jenis peraturan wajib dipilih";

        if (!empty($errors)) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=edit-peraturan&id=" . $_POST['id']);
            exit;
        }

        $model = new PeraturanModel($pdo);

        $data = $_POST;

        $model->update($_POST['id'], $data);

        // ============= HANDLE UPLOAD FILE BARU ==============
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/peraturan/';

            if (!is_dir($dir))
                mkdir($dir, 0777, true);

            foreach ($_FILES['file']['name'] as $i => $nama) {

                if (!$nama) continue;

                $tmp  = $_FILES['file']['tmp_name'][$i];
                $type = $_FILES['file']['type'][$i];
                $size = $_FILES['file']['size'][$i];

                $namaBaru = time() . '_' . $i . '_' .
                    preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);

                move_uploaded_file($tmp, $dir . $namaBaru);

                $model->insertFile($_POST['id'], [
                    'nama_file'   => $nama,
                    'path_file'   => 'uploads/peraturan/' . $namaBaru,
                    'tipe_file'   => $type,
                    'ukuran_file' => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Peraturan berhasil diperbarui'
        ];

        header("Location: ?page=peraturan");
    }

    public function delete()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $model = new PeraturanModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=peraturan");
    }
}
