<?php

require_once __DIR__ . '/../models/PeraturanModel.php';
require_once __DIR__ . '/../models/PeraturanJenisModel.php';
require_once __DIR__ . '/../core/auth.php';

class PeraturanController
{
    public function index()
    {
        authOnly();

        global $pdo;
        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $modeljenis = new PeraturanJenisModel($pdo);
        $jenisPeraturan = $modeljenis->getAll();

        $model = new PeraturanModel($pdo);
        if (!empty($tahun) || !empty($jenis)) {
            $data = $model->getFiltered($tahun, $jenis);
        } else {
            // default
            $data = $model->getAll();
        }

        require __DIR__ . '/../views/peraturan/index.php';
    }

    public function getFiltered()
    {
        // ambil filter dari GET
        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        // jika ada filter → pakai getFiltered
        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();



        $model = new PeraturanModel($pdo);
        if (!empty($tahun) || !empty($jenis)) {
            $data = $model->getFiltered($tahun, $jenis);
        } else {
            // default
            $data = $model->getAll();
        }

        // kirim ke view
        header('Location: ?page=peraturan');
        exit;
    }

    public function create()
    {
        authOnly();

        global $pdo;
        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $modeljenis = new PeraturanJenisModel($pdo);
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
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();
        $errors = [];

        if (empty($_POST['judul'])) {
            $errors['judul'] = "Judul wajib diisi";
        } elseif (strlen($_POST['judul']) < 2) {
            $errors['judul'] = "Judul minimal 2 karakter";
        }
        if (empty($_POST['nomor'])) {
            $errors['nomor'] = "Nomor wajib diisi";
        }
        if (empty($_POST['teu'])) {
            $errors['teu'] = "T.E.U. wajib diisi";
        }
        if (empty($_POST['jenis_id'])) {
            $errors['jenis_id'] = "Jenis wajib diisi";
        }
        $currentYear = (int) date('Y');
        $inputYear   = (int) $_POST['tahun_terbit'];

        if (empty($_POST['tahun_terbit'])) {
            $errors['tahun_terbit'] = "Tahun terbit wajib diisi";
        } elseif ($inputYear > $currentYear) {
            $errors['tahun_terbit'] = "Tahun terbit tidak boleh di masa depan";
        }
        if (empty($_POST['tempat_penetapan'])) {
            $errors['tempat_penetapan'] = "Tempat penetapan wajib diisi";
        }
        if (empty($_POST['penandatangan'])) {
            $errors['penandatangan'] = "Penandatangan wajib diisi";
        }
        if (!empty($_FILES["file"]["name"][0])) {

            $allowed = ["pdf", "jpg", "jpeg", "png"];

            foreach ($_FILES["file"]["name"] as $i => $name) {
                $size = $_FILES["file"]["size"][$i];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $errors['file'] = "File {$name} tidak diizinkan";
                }

                if ($size > 5 * 1024 * 1024) {
                    $errors['file'] = "File {$name} lebih dari 5MB";
                }
            }
        }
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: ?page=tambah-peraturan");
            exit();
        }


        $model = new PeraturanModel($pdo);

        $data = $_POST;
        $data["created_by"] = $user['id'];

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

        logActivity([
            'user_id'      => $user['id'],
            'role_id'      => $user['role_id'],
            'action'       => 'create',
            'entity_type'  => 'peraturan',
            'entity_id'    => $id,
            'description'  => 'Menambahkan data Peraturan'
        ]);

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
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new PeraturanModel($pdo);

        $id = $_GET['id'];

        $model->incrementView($id);

        $peraturan = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/peraturan/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new PeraturanModel($pdo);

        $id = $_GET['id'];

        $peraturan = $model->getById($id);
        $files = $model->getFiles($id);

        $modeljenis = new PeraturanJenisModel($pdo);
        $jenis = $modeljenis->getAll();

        require __DIR__ . '/../views/peraturan/edit.php';
    }

    public function update()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();

        authOnly();
        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $errors = [];

        if (empty($_POST['judul'])) {
            $errors['judul'] = "Judul wajib diisi";
        } elseif (strlen($_POST['judul']) < 2) {
            $errors['judul'] = "Judul minimal 2 karakter";
        }
        if (empty($_POST['nomor'])) {
            $errors['nomor'] = "Nomor wajib diisi";
        }
        if (empty($_POST['teu'])) {
            $errors['teu'] = "T.E.U. wajib diisi";
        }
        if (empty($_POST['jenis_id'])) {
            $errors['jenis_id'] = "Jenis wajib diisi";
        }
        $currentYear = (int) date('Y');
        $inputYear   = (int) $_POST['tahun_terbit'];

        if (empty($_POST['tahun_terbit'])) {
            $errors['tahun_terbit'] = "Tahun terbit wajib diisi";
        } elseif ($inputYear > $currentYear) {
            $errors['tahun_terbit'] = "Tahun terbit tidak boleh di masa depan";
        }
        if (empty($_POST['tempat_penetapan'])) {
            $errors['tempat_penetapan'] = "Tempat penetapan wajib diisi";
        }
        if (empty($_POST['penandatangan'])) {
            $errors['penandatangan'] = "Penandatangan wajib diisi";
        }
        if (!empty($_FILES["file"]["name"][0])) {

            $allowed = ["pdf", "jpg", "jpeg", "png"];

            foreach ($_FILES["file"]["name"] as $i => $name) {
                $size = $_FILES["file"]["size"][$i];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $errors['file'] = "File {$name} tidak diizinkan";
                }

                if ($size > 5 * 1024 * 1024) {
                    $errors['file'] = "File {$name} lebih dari 5MB";
                }
            }
        }
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: ?page=edit-peraturan&id=" . $_POST["id"]);
            exit();
        }

        $model = new PeraturanModel($pdo);

        $data = $_POST;
        $data["updated_by"] = $user['id'];


        $model->update($_POST['id'], $data);

        if (!empty($_POST["hapus_file"])) {
            $ids = explode(",", $_POST["hapus_file"]);
            foreach ($ids as $id) {
                $model->deleteFileById($id);
            }
        }

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

        logActivity([
            'user_id'      => $user['id'],
            'role_id'      => $user['role_id'],
            'action'       => 'update',
            'entity_type'  => 'peraturan',
            'entity_id'    => $_POST["id"],
            'description'  => 'Mengubah data Peraturan'
        ]);

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
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new PeraturanModel($pdo);
        $result = $model->delete($_GET['id'], $user['id']);


        if (!$result) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'Gagal menghapus data'
            ];
        } else {
            logActivity([
                'user_id'      => $user['id'],
                'role_id'      => $user['role_id'],
                'action'       => 'delete',
                'entity_type'  => 'peraturan',
                'entity_id'    => $_GET["id"],
                'description'  => 'Menghapus data Peraturan'
            ]);

            $_SESSION['flash'] = [
                'status'  => 'success',
                'message' => 'Data berhasil dihapus'
            ];
        }

        header("Location: ?page=peraturan");
        exit;
    }

    public function publicIndex()
    {
        global $pdo;
        $model = new PeraturanModel($pdo);

        $modeljenis = new PeraturanJenisModel($pdo);
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

        require __DIR__ . '/../views/peraturan/publicIndex.php';
    }

    public function downloadFile()
    {
        authOnly();
        global $pdo;

        $fileId = $_GET['file'];
        $peraturanId = $_GET['id'];

        $model = new PeraturanModel($pdo);
        $file  = $model->getFileById($fileId);

        if (!$file) {
            exit('File tidak ditemukan');
        }

        // hitung download (di tabel peraturan)
        $model->incrementDownload($peraturanId);

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

        $model = new PeraturanModel($pdo);
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

        $model = new PeraturanModel($pdo);

        $model->incrementView($id);


        // Ambil data peraturan
        $data  = $model->getById($id);

        // Ambil file terkait
        $files = $model->getFiles($id);
        require __DIR__ . '/../views/peraturan/publicDetail.php';
    }
}
