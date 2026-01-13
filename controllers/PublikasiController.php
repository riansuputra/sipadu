<?php

require_once __DIR__ . '/../models/PublikasiModel.php';
require_once __DIR__ . '/../core/auth.php';

class PublikasiController
{
    public function index()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiModel($pdo);
        $data = $model->getAll();

        require __DIR__ . '/../views/publikasi/index.php';
    }

    public function create()
    {
        authOnly();

        $user = currentUser();
        $role = currentRole();

        require __DIR__ . '/../views/publikasi/create.php';
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

        if (empty($_FILES['file']['name'][0])) {
            $errors[] = "Minimal upload 1 file";
        } else {

            $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

            foreach ($_FILES['file']['name'] as $i => $name) {

                $size = $_FILES['file']['size'][$i];
                $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $errors[] = "File {$name} tidak diizinkan";
                }

                if ($size > 2 * 1024 * 1024) {
                    $errors[] = "File {$name} lebih dari 2MB";
                }
            }
        }

        $model = new PublikasiModel($pdo);

        $data = $_POST;
        $data['dibuat_oleh'] = currentUser()['id'];

        $publikasiId = $model->insert($data);

        // proses upload file jika ada
        if (!empty($_FILES['file']['name'])) {

            $dir = __DIR__ . '/../uploads/publikasi/';

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            foreach ($_FILES['file']['name'] as $i => $namaAsli) {

                // skip kalau kosong
                if (!$namaAsli) continue;

                $tmp   = $_FILES['file']['tmp_name'][$i];
                $type  = $_FILES['file']['type'][$i];
                $size  = $_FILES['file']['size'][$i];

                // nama aman
                $namaBaru = time() . '_' . $i . '_' .
                    preg_replace('/[^a-zA-Z0-9._-]/', '_', $namaAsli);

                $path = $dir . $namaBaru;

                // filter tipe
                $allowed = [
                    'application/pdf',
                    'image/png',
                    'image/jpeg'
                ];

                if (!in_array($type, $allowed)) {
                    continue;
                }

                $upload = move_uploaded_file($tmp, $path);

                if ($upload) {

                    // simpan ke tabel dip_file
                    $model->insertFile($publikasiId, [
                        'nama_file'   => $namaAsli,
                        'path_file'   => 'uploads/publikasi/' . $namaBaru,
                        'tipe_file'   => $type,
                        'ukuran_file' => $size
                    ]);
                }
            }
        }

        $_SESSION['flash'] = [
            'status' => 'success',
            'errors' => array_values($errors),
            'message' => 'Data Publikasi berhasil disimpan'
        ];

        header("Location: ?page=tambah-publikasi");
        exit;
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/publikasi/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/publikasi/edit.php';
    }

    public function update()
    {
        authOnly();
        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $errors = [];

        // ==============================
        // VALIDASI FILE (jika ada)
        // ==============================
        if (!empty($_FILES['file']['name'][0])) {

            $allowedExt  = ['pdf', 'jpg', 'jpeg', 'png'];
            $allowedMime = [
                'application/pdf',
                'image/png',
                'image/jpeg'
            ];

            foreach ($_FILES['file']['name'] as $i => $name) {

                if (!$name) continue;

                $size = $_FILES['file']['size'][$i];
                $type = $_FILES['file']['type'][$i];
                $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowedExt)) {
                    $errors[] = "File {$name} tidak diizinkan";
                }

                if (!in_array($type, $allowedMime)) {
                    $errors[] = "Tipe file {$name} tidak sesuai";
                }

                if ($size > 2 * 1024 * 1024) {
                    $errors[] = "File {$name} lebih dari 2MB";
                }
            }
        }

        // ==============================
        // JIKA ADA ERROR
        // ==============================
        if (!empty($errors)) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'errors'  => array_values($errors),
                'message' => 'Gagal update data'
            ];

            header("Location: ?page=edit-publikasi&id=" . $_POST['id']);
            exit;
        }

        $model = new PublikasiModel($pdo);

        // ==============================
        // UPDATE DATA UTAMA
        // ==============================
        $data = $_POST;
        $data['diubah_oleh'] = currentUser()['id'];

        $model->update($_POST['id'], $data);

        // ==============================
        // PROSES UPLOAD FILE BARU
        // ==============================
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/publikasi/';

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            foreach ($_FILES['file']['name'] as $i => $namaAsli) {

                if (!$namaAsli) continue;

                $tmp  = $_FILES['file']['tmp_name'][$i];
                $type = $_FILES['file']['type'][$i];
                $size = $_FILES['file']['size'][$i];

                $namaBaru = time() . '_' . $i . '_' .
                    preg_replace('/[^a-zA-Z0-9._-]/', '_', $namaAsli);

                $path = $dir . $namaBaru;

                $upload = move_uploaded_file($tmp, $path);

                if ($upload) {

                    $model->insertFile($_POST['id'], [
                        'nama_file'   => $namaAsli,
                        'path_file'   => 'uploads/publikasi/' . $namaBaru,
                        'tipe_file'   => $type,
                        'ukuran_file' => $size
                    ]);
                }
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Data Publikasi berhasil diperbarui'
        ];

        header("Location: ?page=publikasi");
        exit;
    }


    public function delete()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PublikasiModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=publikasi");
    }
}
