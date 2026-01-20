<?php

require_once __DIR__ . '/../models/DokumenModel.php';
require_once __DIR__ . '/../models/JenisDokumenModel.php';
require_once __DIR__ . '/../core/auth.php';

class DokumenController
{
    public function index()
    {
        authOnly();

        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $model = new DokumenModel($pdo);
        $data  = $model->getAll();

        require __DIR__ . '/../views/dokumen/index.php';
    }

    public function create()
    {
        authOnly();

        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $modeljenis = new JenisDokumenModel($pdo);
        $jenis = $modeljenis->getAll();

        require __DIR__ . '/../views/dokumen/create.php';
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

            header("Location: ?page=tambah-dokumen");
            exit;
        }

        $model = new DokumenModel($pdo);

        $data = $_POST;
        $id = $model->insert($data);

        // ============= UPLOAD FILE ==============
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/dokumen/';

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
                    'path_file'   => 'uploads/dokumen/' . $namaBaru,
                    'tipe_file'   => $type,
                    'ukuran_file' => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Dokumen berhasil disimpan'
        ];

        header("Location: ?page=tambah-dokumen");
        exit;
    }

    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new DokumenModel($pdo);

        $id = $_GET['id'];

        $model->incrementView($id);

        $dokumen = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/dokumen/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new DokumenModel($pdo);

        $id = $_GET['id'];

        $dokumen = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/dokumen/edit.php';
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

        $model = new DokumenModel($pdo);

        $data = $_POST;

        $model->update($_POST['id'], $data);

        // ============= HANDLE UPLOAD FILE BARU ==============
        if (!empty($_FILES['file']['name'][0])) {

            $dir = __DIR__ . '/../uploads/dokumen/';

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
                    'path_file'   => 'uploads/dokumen/' . $namaBaru,
                    'tipe_file'   => $type,
                    'ukuran_file' => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Peraturan berhasil diperbarui'
        ];

        header("Location: ?page=dokumen");
    }

    public function delete()
    {
        authOnly();
        global $pdo;
        $user = currentUser();
        $role = currentRole();

        $model = new DokumenModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=dokumen");
    }

    public function publicIndex()
    {
        global $pdo;
        $model = new DokumenModel($pdo);

        $modeljenis = new JenisDokumenModel($pdo);
        $jenis = $modeljenis->getAll();

        $limit = 5; // data per halaman
        $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Ambil filter dari GET
        $params = [
            'judul'   => $_GET['judul'] ?? '',
            'nomor'   => $_GET['nomor'] ?? '',
            'tahun'   => $_GET['tahun'] ?? '',
            'subjek'  => $_GET['subjek'] ?? '',
            'jenis'   => $_GET['jenis'] ?? '',
            'status'  => $_GET['status'] ?? ''
        ];

        // Jika semua filter kosong, tetap tampil 5 data terbaru
        $allEmpty = array_filter($params) ? false : true;

        $data  = $model->filterWithPagination($params, $limit, $offset);
        $total = $allEmpty
            ? $model->countAll()
            : $model->countFiltered($params);

        $totalPage = ceil($total / $limit);

        require __DIR__ . '/../views/dokumen/publicIndex.php';
    }

    public function downloadFile()
    {
        authOnly();
        global $pdo;

        $fileId = $_GET['file'];
        $dokumenId = $_GET['id'];

        $model = new DokumenModel($pdo);
        $file  = $model->getFileById($fileId);

        if (!$file) {
            exit('File tidak ditemukan');
        }

        // hitung download (di tabel peraturan)
        $model->incrementDownload($dokumenId);

        $fullPath = __DIR__ . '/../' . $file['path_file'];

        if (!file_exists($fullPath)) {
            exit('File tidak ada di server');
        }

        // paksa download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file['tipe_file']);
        header('Content-Disposition: attachment; filename="' . basename($file['nama_file']) . '"');
        header('Content-Length: ' . filesize($fullPath));

        readfile($fullPath);
        exit;
    }

    public function download()
    {
        authOnly();
        global $pdo;

        $fileId = $_GET['file'];

        $model = new DokumenModel($pdo);
        $file  = $model->getFileById($fileId);

        if (!$file) {
            exit('File tidak ditemukan');
        }

        // hitung download (di tabel peraturan)
        $model->incrementDownload($file['peraturan_id']);

        $fullPath = __DIR__ . '/../' . $file['path_file'];

        if (!file_exists($fullPath)) {
            exit('File tidak ada di server');
        }

        // paksa download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file['tipe_file']);
        header('Content-Disposition: attachment; filename="' . basename($file['nama_file']) . '"');
        header('Content-Length: ' . filesize($fullPath));

        readfile($fullPath);
        exit;
    }


    public function detail($id)
    {
        authOnly();
        global $pdo;

        $model = new DokumenModel($pdo);

        $model->incrementView($id);


        // Ambil data peraturan
        $data  = $model->getById($id);

        // Ambil file terkait
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/dokumen/publicDetail.php';
    }
}
