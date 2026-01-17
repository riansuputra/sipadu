<?php

require_once __DIR__ . '/../models/PegawaiModel.php';
require_once __DIR__ . '/../core/auth.php';

class PegawaiController
{
    public function index()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PegawaiModel($pdo);
        $data = $model->getAll();

        require __DIR__ . '/../views/pegawai/index.php';
    }

    public function create()
    {
        authOnly();

        $user = currentUser();
        $role = currentRole();

        require __DIR__ . '/../views/pegawai/create.php';
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

        // mapping input → jenis dokumen → folder
        $dokumenMap = [
            'file_ktp'    => 'KTP',
            'file_foto'    => 'Foto',
            'file_kk'     => 'KK',
            'file_sk_pengangkatan'   => 'SK Pengangkatan',
            'file_sk_spmt' => 'SK SPMT'
        ];

        $allowedExt  = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedMime = [
            'application/pdf',
            'image/png',
            'image/jpeg'
        ];

        // ================= VALIDASI =================
        $adaFile = false;

        foreach ($dokumenMap as $input => $jenis) {

            if (!empty($_FILES[$input]['name'])) {

                $adaFile = true;

                $name = $_FILES[$input]['name'];
                $size = $_FILES[$input]['size'];
                $type = $_FILES[$input]['type'];

                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowedExt)) {
                    $errors[] = "File {$jenis} tidak diizinkan";
                }

                if (!in_array($type, $allowedMime)) {
                    $errors[] = "Tipe file {$jenis} tidak sesuai";
                }

                if ($size > 2 * 1024 * 1024) {
                    $errors[] = "File {$jenis} lebih dari 2MB";
                }
            }
        }

        if (!$adaFile) {
            $errors[] = "Minimal upload 1 dokumen";
        }

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=tambah-pegawai");
            exit;
        }

        // ================ SIMPAN DATA PEGAWAI ================
        $model = new PegawaiModel($pdo);

        $data = $_POST;
        $data['dibuat_oleh'] = currentUser()['id'];

        $pegawaiId = $model->insert($data);

        // ================ UPLOAD PER JENIS ================
        foreach ($dokumenMap as $input => $jenis) {

            if (empty($_FILES[$input]['name'])) continue;

            $dir = __DIR__ . '/../uploads/pegawai/' . $jenis . '/';

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $namaAsli = $_FILES[$input]['name'];
            $tmp      = $_FILES[$input]['tmp_name'];
            $type     = $_FILES[$input]['type'];
            $size     = $_FILES[$input]['size'];

            $namaBaru = time() . '_' . $jenis . '_' .
                preg_replace('/[^a-zA-Z0-9._-]/', '_', $namaAsli);

            $path = $dir . $namaBaru;

            $upload = move_uploaded_file($tmp, $path);

            if ($upload) {

                $model->insertFile($pegawaiId, [
                    'jenis_dokumen' => strtoupper($jenis),
                    'nama_file'     => $namaAsli,
                    'path_file'     => 'uploads/pegawai/' . $jenis . '/' . $namaBaru,
                    'tipe_file'     => $type,
                    'ukuran_file'   => $size
                ]);
            }
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Data Pegawai berhasil disimpan'
        ];

        header("Location: ?page=tambah-pegawai");
        exit;
    }


    public function show()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PegawaiModel($pdo);

        $id = $_GET['id'];

        $pegawai = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/pegawai/detail.php';
    }

    public function edit()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PegawaiModel($pdo);

        $id = $_GET['id'];

        $pegawai = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . '/../views/pegawai/edit.php';
    }

    public function update()
    {
        authOnly();
        global $pdo;

        $errors = [];

        $user = currentUser();
        $role = currentRole();

        $dokumenMap = [
            'file_ktp'    => 'KTP',
            'file_foto'    => 'Foto',
            'file_kk'     => 'KK',
            'file_sk_pengangkatan'   => 'SK Pengangkatan',
            'file_sk_spmt' => 'SK SPMT'
        ];

        $allowedExt  = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedMime = [
            'application/pdf',
            'image/png',
            'image/jpeg'
        ];

        // VALIDASI JIKA ADA FILE BARU
        foreach ($dokumenMap as $input => $jenis) {

            if (empty($_FILES[$input]['name'])) continue;

            $name = $_FILES[$input]['name'];
            $size = $_FILES[$input]['size'];
            $type = $_FILES[$input]['type'];

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt)) {
                $errors[] = "File {$jenis} tidak diizinkan";
            }

            if (!in_array($type, $allowedMime)) {
                $errors[] = "Tipe file {$jenis} tidak sesuai";
            }

            if ($size > 2 * 1024 * 1024) {
                $errors[] = "File {$jenis} lebih dari 2MB";
            }
        }

        if (!empty($errors)) {

            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => implode("<br>", $errors)
            ];

            header("Location: ?page=edit-pegawai&id=" . $_POST['id']);
            exit;
        }

        $model = new PegawaiModel($pdo);

        // UPDATE DATA UTAMA
        $data = $_POST;
        $data['diubah_oleh'] = currentUser()['id'];

        $model->update($_POST['id'], $data);

        // UPLOAD FILE BARU (jika ada)
        foreach ($dokumenMap as $input => $jenis) {

            if (empty($_FILES[$input]['name'])) continue;

            $dir = __DIR__ . '/../uploads/pegawai/' . $jenis . '/';

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $namaAsli = $_FILES[$input]['name'];
            $tmp      = $_FILES[$input]['tmp_name'];
            $type     = $_FILES[$input]['type'];
            $size     = $_FILES[$input]['size'];

            $namaBaru = time() . '_' . $jenis . '_' .
                preg_replace('/[^a-zA-Z0-9._-]/', '_', $namaAsli);

            move_uploaded_file($tmp, $dir . $namaBaru);

            $model->insertFile($_POST['id'], [
                'jenis_dokumen' => strtoupper($jenis),
                'nama_file'     => $namaAsli,
                'path_file'     => 'uploads/pegawai/' . $jenis . '/' . $namaBaru,
                'tipe_file'     => $type,
                'ukuran_file'   => $size
            ]);
        }

        $_SESSION['flash'] = [
            'status'  => 'success',
            'message' => 'Data Pegawai berhasil diperbarui'
        ];

        header("Location: ?page=pegawai");
        exit;
    }


    // hapus
    public function delete()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new PegawaiModel($pdo);
        $model->delete($_GET['id']);

        header("Location: ?page=pegawai");
    }
}
