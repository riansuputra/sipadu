<?php

require_once __DIR__ . '/../models/PublikasiModel.php';
require_once __DIR__ . '/../models/PublikasiJenisModel.php';
require_once __DIR__ . '/../core/auth.php';

class PublikasiController
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

        $pokjaId = $user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        // echo "<pre>";
        // print_r($_POST);
        // print_r($_GET['jenis']);
        // echo "</pre>";
        // die();

        $modeljenis = new PublikasiJenisModel($pdo);
        $jenisInput = $modeljenis->getAll();

        $model = new PublikasiModel($pdo);

        $data = $model->getByRole(
            $role,
            $pokjaId,
            $tanggalMulai,
            $tanggalSelesai,
            $jenis
        );

        // if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
        //     $data = $model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        // } else {
        //     $data = $model->getAll();
        // }

        require __DIR__ . '/../views/publikasi/index.php';
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

        $model = new PublikasiModel($pdo);
        if (!empty($tahun) || !empty($jenis)) {
            $data = $model->getFiltered($tahun, $jenis);
        } else {
            // default
            $data = $model->getAll();
        }

        // kirim ke view
        header('Location: ' . url('?page=publikasi'));
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

        $modeljenis = new PublikasiJenisModel($pdo);
        $jenis = $modeljenis->getAll();

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
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();
        $pokja = currentPokja();

        $errors = [];

        if (empty($_POST['judul'])) {
            $errors['judul'] = "Judul wajib diisi";
        } elseif (strlen($_POST['judul']) < 2) {
            $errors['judul'] = "Judul minimal 2 karakter";
        }
        if (!empty($_POST['deskripsi']) && strlen($_POST['deskripsi']) < 1) {
            $errors['deskripsi'] = "Deskripsi minimal 1 karakter";
        }
        $currentDate = date('Y-m-d');
        $inputDate   = $_POST['tanggal_kegiatan'] ?? '';

        if (empty($inputDate)) {
            $errors['tanggal_kegiatan'] = "Tanggal kegiatan wajib diisi";
        } elseif ($inputDate > $currentDate) {
            $errors['tanggal_kegiatan'] = "Tanggal kegiatan tidak boleh di masa depan";
        }

        if (empty($_POST['lokasi'])) {
            $errors['lokasi'] = "Lokasi kegiatan wajib diisi";
        }
        if (empty($_POST['jenis_id'])) {
            $errors['jenis_id'] = "Jenis wajib diisi";
        }
        if (empty($_POST['penulis'])) {
            $errors['penulis'] = "Penulis wajib diisi";
        }
        if (empty($_POST['kabupaten'])) {
            $errors['kabupaten'] = "Kabupaten/Kota wajib diisi";
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

            header("Location: " . url('?page=tambah-publikasi'));
            exit();
        }

        $model = new PublikasiModel($pdo);

        $data = $_POST;
        $data['created_by'] = $user['id'];
        $data['pokja_id'] = $pokja;

        $publikasiId = $model->insert($data);

        // proses upload file jika ada
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

                $model->insertFile($publikasiId, [
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
            'entity_type'  => 'publikasi',
            'entity_id'    => $publikasiId,
            'description'  => 'Menambahkan data Publikasi'
        ]);

        $_SESSION['flash'] = [
            'status' => 'success',
            'errors' => array_values($errors),
            'message' => 'Data Publikasi berhasil disimpan'
        ];

        header("Location: " . url('?page=tambah-publikasi'));
        exit;
    }

    public function show()
    {
        echo "<pre>";
        print_r($_POST);
        print_r($_FILES);
        echo "</pre>";
        die();

        authOnly();

        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
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
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new PublikasiModel($pdo);

        $id = $_GET['id'];

        $publikasi = $model->getById($id);
        $files = $model->getFiles($id);

        $modeljenis = new PublikasiJenisModel($pdo);
        $jenis = $modeljenis->getAll();

        require __DIR__ . '/../views/publikasi/edit.php';
    }

    public function update()
    {
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
        if (!empty($_POST['deskripsi']) && strlen($_POST['deskripsi']) < 1) {
            $errors['deskripsi'] = "Deskripsi minimal 1 karakter";
        }
        $currentDate = date('Y-m-d');
        $inputDate   = $_POST['tanggal_kegiatan'] ?? '';

        if (empty($inputDate)) {
            $errors['tanggal_kegiatan'] = "Tanggal kegiatan wajib diisi";
        } elseif ($inputDate > $currentDate) {
            $errors['tanggal_kegiatan'] = "Tanggal kegiatan tidak boleh di masa depan";
        }

        if (empty($_POST['lokasi'])) {
            $errors['lokasi'] = "Lokasi kegiatan wajib diisi";
        }
        if (empty($_POST['jenis_id'])) {
            $errors['jenis_id'] = "Jenis wajib diisi";
        }
        if (empty($_POST['penulis'])) {
            $errors['penulis'] = "Penulis wajib diisi";
        }
        if (empty($_POST['kabupaten'])) {
            $errors['kabupaten'] = "Kabupaten/Kota wajib diisi";
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

        // if (!empty($errors)) {
        //     echo "<pre>";
        //     print_r($errors);
        //     echo "</pre>";
        //     die();
        // } else {
        //     echo "<pre>";
        //     print_r($_POST);
        //     echo "</pre>";
        //     die();
        // }


        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: " . url('?page=edit-publikasi&id=' . $_POST['id']));
            exit();
        }

        $model = new PublikasiModel($pdo);

        // ==============================
        // UPDATE DATA UTAMA
        // ==============================
        $data = $_POST;
        $data['updated_by'] = $user['id'];

        $model->update($_POST['id'], $data);

        if (!empty($_POST["hapus_file"])) {
            $ids = explode(",", $_POST["hapus_file"]);
            foreach ($ids as $id) {
                $model->deleteFileById($id);
            }
        }

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

        logActivity([
            'user_id'      => $user['id'],
            'role_id'      => $user['role_id'],
            'action'       => 'update',
            'entity_type'  => 'publikasi',
            'entity_id'    => $_POST["id"],
            'description'  => 'Mengubah data Publikasi'
        ]);

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Data Publikasi berhasil diperbarui'
        ];

        header("Location: " . url('?page=publikasi'));
        exit;
    }


    public function delete()
    {
        authOnly();

        global $pdo;

        if (empty($_GET['id'])) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'ID tidak ditemukan'
            ];
            header('Location: ' . url('?page=publikasi'));
            exit;
        }

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new PublikasiModel($pdo);
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
                'entity_type'  => 'publikasi',
                'entity_id'    => $_GET["id"],
                'description'  => 'Menghapus data Publikasi'
            ]);

            $_SESSION['flash'] = [
                'status'  => 'success',
                'message' => 'Data berhasil dihapus'
            ];
        }

        header("Location: " . url("?page=publikasi"));
        exit;
    }

    public function publicIndex()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $model = new PublikasiModel($pdo);

        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            // default
            $data = $model->getAll();
        }

        require __DIR__ . '/../views/publikasi/publicIndex.php';
    }
}
