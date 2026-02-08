<?php

require_once __DIR__ . "/../models/DipModel.php";
require_once __DIR__ . "/../core/auth.php";

class DipController
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

        $model = new DipModel($pdo);
        if (!empty($tahun) || !empty($jenis)) {
            $data = $model->getFiltered($tahun, $jenis);
        } else {
            $data = $model->getAll();
        }

        require __DIR__ . "/../views/dip/index.php";
    }

    public function create()
    {
        authOnly();

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        require __DIR__ . "/../views/dip/create.php";
    }

    public function store()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
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
        if (empty($_POST['nama_informasi'])) {
            $errors['nama_informasi'] = "Nama informasi wajib diisi";
        } elseif (strlen($_POST['nama_informasi']) < 3) {
            $errors['nama_informasi'] = "Nama informasi minimal 3 karakter";
        }
        if (empty($_POST['unit_penyedia'])) {
            $errors['unit_penyedia'] = "Unit penguasaan wajib diisi";
        } elseif (strlen($_POST['unit_penyedia']) < 1) {
            $errors['unit_penyedia'] = "Unit penguasaan minimal 1 karakter";
        }
        if (!empty($_POST['penanggung_jawab']) && strlen($_POST['penanggung_jawab']) < 1) {
            $errors['penanggung_jawab'] = "Penanggung jawab minimal 1 karakter";
        }
        $allowedJenis = ['BERKALA', 'SERTA MERTA', 'SETIAP SAAT', 'DIKECUALIKAN'];
        if (empty($_POST['jenis_informasi']) || !in_array($_POST['jenis_informasi'], $allowedJenis)) {
            $errors['jenis_informasi'] = "Jenis informasi tidak valid";
        }
        $allowedBentuk = ['HARDCOPY', 'SOFTCOPY', 'HARDCOPY+SOFTCOPY'];
        if (empty($_POST['bentuk_informasi']) || !in_array($_POST['bentuk_informasi'], $allowedBentuk)) {
            $errors['bentuk_informasi'] = "Bentuk informasi tidak valid";
        }
        if (empty($_POST['tempat_pembuatan'])) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan wajib diisi";
        } elseif (strlen($_POST['tempat_pembuatan']) < 1) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan minimal 1 karakter";
        } elseif (strlen($_POST['tempat_pembuatan']) > 200) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan maksimal 200 karakter";
        }
        $currentYear = (int) date('Y');
        $inputYear   = (int) $_POST['tahun_pembuatan'];

        if (empty($_POST['tahun_pembuatan'])) {
            $errors['tahun_pembuatan'] = "Tahun pembuatan wajib diisi";
        } elseif ($inputYear > $currentYear) {
            $errors['tahun_pembuatan'] = "Tahun pembuatan tidak boleh di masa depan";
        }
        // if (empty($_POST['retensi_arsip'])) {
        //     $errors['retensi_arsip'] = "Retensi arsip wajib diisi";
        // }
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

            header("Location: ?page=tambah-dip");
            exit();
        }

        $model = new DipModel($pdo);

        $data = $_POST;
        $data["created_by"] = $user['id'];

        $dipId = $model->insert($data);

        // proses upload file jika ada
        if (!empty($_FILES["file"]["name"])) {
            $dir = __DIR__ . "/../uploads/dip/";

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            foreach ($_FILES["file"]["name"] as $i => $namaAsli) {
                // skip kalau kosong
                if (!$namaAsli) {
                    continue;
                }

                $tmp = $_FILES["file"]["tmp_name"][$i];
                $type = $_FILES["file"]["type"][$i];
                $size = $_FILES["file"]["size"][$i];

                // nama aman
                $namaBaru =
                    time() .
                    "_" .
                    $i .
                    "_" .
                    preg_replace("/[^a-zA-Z0-9._-]/", "_", $namaAsli);

                $path = $dir . $namaBaru;

                // filter tipe
                $allowed = ["application/pdf", "image/png", "image/jpeg"];

                if (!in_array($type, $allowed)) {
                    continue;
                }

                $upload = move_uploaded_file($tmp, $path);

                if ($upload) {
                    // simpan ke tabel dip_file
                    $model->insertFile($dipId, [
                        "nama_file" => $namaAsli,
                        "path_file" => "uploads/dip/" . $namaBaru,
                        "tipe_file" => $type,
                        "ukuran_file" => $size,
                    ]);
                }
            }
        }

        logActivity([
            'user_id'      => $user['id'],
            'role_id'      => $user['role_id'],
            'action'       => 'create',
            'entity_type'  => 'dip',
            'entity_id'    => $dipId,
            'description'  => 'Menambahkan data DIP'
        ]);

        $_SESSION["flash"] = [
            "status" => "success",
            "message" => "Data DIP berhasil disimpan",
        ];

        header("Location: ?page=tambah-dip");
        exit();
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

        $model = new DipModel($pdo);

        $id = $_GET["id"];

        $dip = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . "/../views/dip/detail.php";
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

        $model = new DipModel($pdo);

        $id = $_GET["id"];

        $dip = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . "/../views/dip/edit.php";
    }

    public static function printFilter()
    {


        authOnly();
        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new DipModel($pdo);

        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? []; // bisa array

        if (!is_array($jenis)) {
            $jenis = [$jenis];
        }

        $data = [];
        if ($tahun || !empty($jenis)) {
            $data = $model->getFiltered($tahun, $jenis);
        }

        require __DIR__ . '/../views/dip/printFilter.php';
    }

    public static function print()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";
        // die();
        authOnly();
        global $pdo;

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new DipModel($pdo);

        // ==========================
        // AMBIL FILTER DATA
        // ==========================
        $tahun_data  = $_POST['tahun'] ?? null;
        $jenis       = $_POST['jenis'] ?? [];

        if (!is_array($jenis)) {
            $jenis = [$jenis];
        }

        // ==========================
        // AMBIL DATA SURAT
        // ==========================
        $nomor_surat   = $_POST['nomor_surat'] ?? '';
        $tanggal_surat = $_POST['tanggal_surat'] ?? '';
        $tentang       = $_POST['tentang'] ?? '';
        $tahun_judul   = $_POST['tahun_judul'] ?? date('Y');

        $jabatan_ttd   = $_POST['jabatan_ttd'] ?? '';
        $nama_ttd      = $_POST['nama_ttd'] ?? '';
        $nip_ttd       = $_POST['nip_ttd'] ?? '';

        // ==========================
        // AMBIL DATA DIP
        // ==========================
        $data = $model->getFiltered($tahun_data, $jenis);

        // ==========================
        // GROUPING DATA PER JENIS
        // ==========================
        $dataGrouped = [];

        foreach ($data as $d) {
            $dataGrouped[$d['jenis_informasi']][] = $d;
        }

        // ==========================
        // LOAD VIEW CETAK
        // ==========================
        require __DIR__ . '/../views/dip/print.php';
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
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $errors = [];
        if (empty($_POST['nama_informasi'])) {
            $errors['nama_informasi'] = "Nama informasi wajib diisi";
        } elseif (strlen($_POST['nama_informasi']) < 3) {
            $errors['nama_informasi'] = "Nama informasi minimal 3 karakter";
        }
        if (empty($_POST['unit_penyedia'])) {
            $errors['unit_penyedia'] = "Unit penguasaan wajib diisi";
        } elseif (strlen($_POST['unit_penyedia']) < 1) {
            $errors['unit_penyedia'] = "Unit penguasaan minimal 1 karakter";
        }
        if (!empty($_POST['penanggung_jawab']) && strlen($_POST['penanggung_jawab']) < 1) {
            $errors['penanggung_jawab'] = "Penanggung jawab minimal 1 karakter";
        }
        $allowedJenis = ['BERKALA', 'SERTA MERTA', 'SETIAP SAAT', 'DIKECUALIKAN'];
        if (empty($_POST['jenis_informasi']) || !in_array($_POST['jenis_informasi'], $allowedJenis)) {
            $errors['jenis_informasi'] = "Jenis informasi tidak valid";
        }
        $allowedBentuk = ['HARDCOPY', 'SOFTCOPY', 'HARDCOPY+SOFTCOPY'];
        if (empty($_POST['bentuk_informasi']) || !in_array($_POST['bentuk_informasi'], $allowedBentuk)) {
            $errors['bentuk_informasi'] = "Bentuk informasi tidak valid";
        }
        if (empty($_POST['tempat_pembuatan'])) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan wajib diisi";
        } elseif (strlen($_POST['tempat_pembuatan']) < 1) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan minimal 1 karakter";
        } elseif (strlen($_POST['tempat_pembuatan']) > 200) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan maksimal 200 karakter";
        }
        $currentYear = (int) date('Y');
        $inputYear   = (int) $_POST['tahun_pembuatan'];

        if (empty($_POST['tahun_pembuatan'])) {
            $errors['tahun_pembuatan'] = "Tahun pembuatan wajib diisi";
        } elseif ($inputYear > $currentYear) {
            $errors['tahun_pembuatan'] = "Tahun pembuatan tidak boleh di masa depan";
        }
        // if (empty($_POST['retensi_arsip'])) {
        //     $errors['retensi_arsip'] = "Retensi arsip wajib diisi";
        // }
        if (!empty($_FILES["file"]["name"][0])) {

            $allowed = ["pdf", "jpg", "jpeg", "png"];

            foreach ($_FILES["file"]["name"] as $i => $name) {
                $size = $_FILES["file"]["size"][$i];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $errors['file'] = "File {$name} tidak diizinkan";
                }

                if ($size > 2 * 1024 * 1024) {
                    $errors['file'] = "File {$name} lebih dari 2MB";
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            header("Location: ?page=edit-dip&id=" . $_POST["id"]);
            exit();
        }

        $model = new DipModel($pdo);

        $data = $_POST;
        $data["updated_by"] = $user['id'];

        // echo "<pre>";
        // print_r($data);
        // print_r($model->update($_POST["id"], $data));
        // echo "</pre>";
        // die();

        $model->update($_POST["id"], $data);

        // 1. Hapus file lama
        if (!empty($_POST["hapus_file"])) {
            $ids = explode(",", $_POST["hapus_file"]);
            foreach ($ids as $id) {
                $model->deleteFileById($id);
            }
        }

        // proses upload file jika ada
        if (!empty($_FILES["file"]["name"])) {
            $dir = __DIR__ . "/../uploads/dip/";

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            foreach ($_FILES["file"]["name"] as $i => $namaAsli) {
                // skip kalau kosong
                if (!$namaAsli) {
                    continue;
                }

                $tmp = $_FILES["file"]["tmp_name"][$i];
                $type = $_FILES["file"]["type"][$i];
                $size = $_FILES["file"]["size"][$i];

                // nama aman
                $namaBaru =
                    time() .
                    "_" .
                    $i .
                    "_" .
                    preg_replace("/[^a-zA-Z0-9._-]/", "_", $namaAsli);

                $path = $dir . $namaBaru;

                // filter tipe
                $allowed = ["application/pdf", "image/png", "image/jpeg"];

                if (!in_array($type, $allowed)) {
                    continue;
                }

                $upload = move_uploaded_file($tmp, $path);

                if ($upload) {
                    // simpan ke tabel dip_file
                    $model->insertFile($_POST["id"], [
                        "nama_file" => $namaAsli,
                        "path_file" => "uploads/dip/" . $namaBaru,
                        "tipe_file" => $type,
                        "ukuran_file" => $size,
                    ]);
                }
            }
        }

        logActivity([
            'user_id'      => $user['id'],
            'role_id'      => $user['role_id'],
            'action'       => 'update',
            'entity_type'  => 'dip',
            'entity_id'    => $_POST["id"],
            'description'  => 'Mengubah data DIP'
        ]);

        $_SESSION["flash"] = [
            "status" => "success",
            "message" => "Data DIP berhasil diperbarui",
        ];

        header("Location: ?page=edit-dip&id=" . $_POST["id"]);
        exit();
    }

    public function delete()
    {
        // echo "<pre>";
        // print_r($_GET["id"]);
        // echo "</pre>";
        // die();
        // authOnly();

        authOnly();
        global $pdo;

        if (empty($_GET['id'])) {
            $_SESSION['flash'] = [
                'status'  => 'error',
                'message' => 'ID tidak ditemukan'
            ];
            header('Location: ?page=dip');
            exit;
        }

        $user = currentUser();
        if (!$user || empty($user['id'])) {
            die("User tidak valid");
        }
        $role = currentRole();

        $model = new DipModel($pdo);
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
                'entity_type'  => 'dip',
                'entity_id'    => $_GET["id"],
                'description'  => 'Menghapus data DIP'
            ]);

            $_SESSION['flash'] = [
                'status'  => 'success',
                'message' => 'Data berhasil dihapus'
            ];
        }

        header('Location: ?page=dip');
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

        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $model = new DipModel($pdo);
        if (!empty($tahun) || !empty($jenis)) {
            $data = $model->getFiltered($tahun, $jenis);
        } else {
            // default
            $data = $model->getAll();
        }

        require __DIR__ . "/../views/dip/publicIndex.php";
    }

    public function downloadFile()
    {
        authOnly();
        global $pdo;

        $fileId = $_GET['file'];
        $dipId = $_GET['id'];

        $model = new DipModel($pdo);
        $file  = $model->getFileById($fileId);

        if (!$file) {
            exit('File tidak ditemukan');
        }

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
}
