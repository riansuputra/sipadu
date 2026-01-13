<?php
require_once __DIR__ . '/../models/ArsipModel.php';
require_once __DIR__ . '/../core/auth.php';

class ArsipController
{
    public function index()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipModel($pdo);
        $data = $model->getAll();

        require __DIR__ . '/../views/arsip/index.php';
    }

    public function create()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $modelkategori = new ArsipKategoriModel($pdo);
        $kategori = $modelkategori->getAll();

        require __DIR__ . '/../views/arsip/create.php';
    }

    // ----------------------------------------------------
    // Store arsip
    // ----------------------------------------------------
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

        if (!empty($errors)) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-arsip");
            exit;
        }

        $model = new ArsipModel($pdo);

        $data = $_POST;
        $id = $model->insert($data);

        // ============= UPLOAD FILE ==============
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/arsip/';

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
                    'path_file'   => 'uploads/arsip/' . $namaBaru,
                    'tipe_file'   => $type,
                    'ukuran_file' => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Arsip berhasil disimpan'
        ];

        header("Location: ?page=tambah-arsip");
        exit;
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipModel($pdo);

        $id = $_GET['id'];

        $arsip = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/arsip/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new ArsipModel($pdo);

        $id = $_GET['id'];

        $arsip = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/arsip/edit.php';
    }

    public function update()
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

        if (!empty($errors)) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=edit-arsip&id=" . $_POST['id']);
            exit;
        }

        $model = new ArsipModel($pdo);

        $data = $_POST;

        $model->update($_POST['id'], $data);

        // ============= UPLOAD FILE ==============
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/arsip/';

            if (!is_dir($dir))
                mkdir($dir, 0777, true);

            foreach ($_FILES['file']['name'] as $i => $nama) {

                if (!$nama) continue;

                $tmp  = $_FILES['file']['tmp_name'][$i];
                $type = $_FILES['file']['type'][$i];
                $size = $_FILES['file']['size'][$i];

                $namaBaru = time() . '_' . $i . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);

                move_uploaded_file($tmp, $dir . $namaBaru);

                $model->insertFile($_POST['id'], [
                    'nama_file'   => $nama,
                    'path_file'   => 'uploads/arsip/' . $namaBaru,
                    'tipe_file'   => $type,
                    'ukuran_file' => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Arsip berhasil disimpan'
        ];

        header("Location: ?page=tambah-arsip");
        exit;
    }

    public function delete()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $model = new ArsipModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=arsip");
    }
}
