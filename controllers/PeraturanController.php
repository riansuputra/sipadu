<?php

require_once __DIR__ . '/../models/PeraturanModel.php';
require_once __DIR__ . '/../core/auth.php';

class PeraturanController
{
    public function index()
    {
        authOnly();

        global $pdo;

        $model = new PeraturanModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/peraturan/index.php';
    }

    public function create()
    {
        authOnly();

        global $pdo;

        $model = new PeraturanModel($pdo);
        $jenis = $model->getJenis();

        require __DIR__ . '/../views/peraturan/create.php';
    }

    // ====================================
    // STORE (mirip DIP)
    // ====================================
    public function store()
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

            header("Location: ?page=tambah-peraturan");
            exit;
        }

        $model = new PeraturanModel($pdo);

        $data = [
            'judul'                => $_POST['judul'],
            'nomor'                => $_POST['nomor'],
            'teu'                  => $_POST['teu'],
            'jenis_id'             => $_POST['jenis_id'],
            'tahun_terbit'         => $_POST['tahun_terbit'],
            'tempat_penetapan'     => $_POST['tempat_penetapan'],
            'tanggal_penetapan'    => $_POST['tanggal_penetapan'],
            'tanggal_pengundangan' => $_POST['tanggal_pengundangan'],
            'sumber'               => $_POST['sumber'],
            'bahasa'               => $_POST['bahasa'],
            'status'               => $_POST['status'],
            'lokasi'               => $_POST['lokasi'],
            'bidang_hukum'         => $_POST['bidang_hukum'],
            'subjek'               => $_POST['subjek'],
            'pemrakarsa'           => $_POST['pemrakarsa'],
            'kata_kunci'           => $_POST['kata_kunci'],
            'penandatangan'        => $_POST['penandatangan']
        ];

        $id = $model->store($data);

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

                $model->uploadFile($id, [
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
    }

    public function detail()
    {
        authOnly();
        global $pdo;

        $model = new PeraturanModel($pdo);

        $data  = $model->find($_GET['id']);
        $files = $model->getFiles($_GET['id']);

        require __DIR__ . '/../views/peraturan/detail.php';
    }

    public function delete()
    {
        authOnly();
        global $pdo;

        $model = new PeraturanModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=peraturan");
    }
}
