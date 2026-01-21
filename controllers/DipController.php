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
        $role = currentRole();

        $model = new DipModel($pdo);
        $data = $model->getAll();

        require __DIR__ . "/../views/dip/index.php";
    }

    public function create()
    {
        authOnly();

        $user = currentUser();
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
        $role = currentRole();

        $errors = [];
        if (empty($_POST['judul_informasi'])) {
            $errors['judul_informasi'] = "Judul informasi wajib diisi";
        } elseif (strlen($_POST['judul_informasi']) < 3) {
            $errors['judul_informasi'] = "Judul informasi minimal 3 karakter";
        } elseif (strlen($_POST['judul_informasi']) > 200) {
            $errors['judul_informasi'] = "Judul informasi maksimal 200 karakter";
        }
        if (!empty($_POST['ringkasan']) && strlen($_POST['ringkasan']) < 1) {
            $errors['ringkasan'] = "Ringkasan minimal 1 karakter jika diisi";
        }
        if (empty($_POST['unit_penguasaan'])) {
            $errors['unit_penguasaan'] = "Unit penguasaan wajib diisi";
        } elseif (strlen($_POST['unit_penguasaan']) < 1) {
            $errors['unit_penguasaan'] = "Unit penguasaan minimal 1 karakter";
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
        if (empty($_POST['tanggal_pembuatan'])) {
            $errors['tanggal_pembuatan'] = "Tanggal pembuatan wajib diisi";
        } elseif (strtotime($_POST['tanggal_pembuatan']) > time()) {
            $errors['tanggal_pembuatan'] = "Tanggal pembuatan tidak boleh di masa depan";
        }
        if (empty($_POST['retensi_arsip'])) {
            $errors['retensi_arsip'] = "Retensi arsip wajib diisi";
        }
        if (empty($_FILES["file"]["name"][0])) {
            $errors['file'] = "Minimal upload 1 file";
        } else {
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

            header("Location: ?page=tambah-dip");
            exit();
        }

        $model = new DipModel($pdo);

        $data = $_POST;
        $data["dibuat_oleh"] = currentUser()["id"];

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
        $role = currentRole();

        $model = new DipModel($pdo);

        $id = $_GET["id"];

        $dip = $model->getById($id);
        $files = $model->getFiles($id);

        require __DIR__ . "/../views/dip/edit.php";
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

        // ================================
        // VALIDASI INPUT
        // ================================

        // 1. Judul
        // if (empty($_POST['judul_informasi'])) {
        //     $errors[] = "Judul informasi wajib diisi";
        // } elseif (strlen($_POST['judul_informasi']) < 5) {
        //     $errors[] = "Judul minimal 5 karakter";
        // }

        // // 2. Ringkasan
        // if (empty($_POST['ringkasan'])) {
        //     $errors[] = "Ringkasan wajib diisi";
        // } elseif (strlen($_POST['ringkasan']) < 10) {
        //     $errors[] = "Ringkasan minimal 10 karakter";
        // }

        // // 3. Unit
        // if (empty($_POST['unit_penguasaan'])) {
        //     $errors[] = "Unit penguasaan wajib diisi";
        // }

        // // 4. Penanggung jawab
        // if (empty($_POST['penanggung_jawab'])) {
        //     $errors[] = "Penanggung jawab wajib diisi";
        // }

        // // 5. Jenis informasi
        // $jenisValid = ['BERKALA', 'SERTA MERTA', 'SETIAP SAAT', 'DIKECUALIKAN'];
        // if (empty($_POST['jenis_informasi'])) {
        //     $errors[] = "Jenis informasi wajib dipilih";
        // } elseif (!in_array($_POST['jenis_informasi'], $jenisValid)) {
        //     $errors[] = "Jenis informasi tidak valid";
        // }

        // // 6. Bentuk informasi
        // $bentukValid = ['HARDCOPY', 'SOFTCOPY', 'HARDCOPY+SOFTCOPY'];
        // if (empty($_POST['bentuk_informasi'])) {
        //     $errors[] = "Bentuk informasi wajib dipilih";
        // } elseif (!in_array($_POST['bentuk_informasi'], $bentukValid)) {
        //     $errors[] = "Bentuk informasi tidak valid";
        // }

        // // 7. Tempat pembuatan
        // if (empty($_POST['tempat_pembuatan'])) {
        //     $errors[] = "Tempat pembuatan wajib diisi";
        // }

        // // 8. Tanggal
        // if (empty($_POST['tanggal_pembuatan'])) {
        //     $errors[] = "Tanggal pembuatan wajib diisi";
        // } elseif ($_POST['tanggal_pembuatan'] > date('Y-m-d')) {
        //     $errors[] = "Tanggal tidak boleh lebih dari hari ini";
        // }

        // // 9. Retensi
        // if (empty($_POST['retensi_arsip'])) {
        //     $errors[] = "Retensi arsip wajib diisi";
        // }

        // ================================
        // VALIDASI FILE
        // ================================

        // if (empty($_FILES['file']['name'][0])) {
        //     $errors[] = "Minimal upload 1 file";
        // } else {

        //     $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

        //     foreach ($_FILES['file']['name'] as $i => $name) {

        //         $size = $_FILES['file']['size'][$i];
        //         $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        //         if (!in_array($ext, $allowed)) {
        //             $errors[] = "File {$name} tidak diizinkan";
        //         }

        //         if ($size > 2 * 1024 * 1024) {
        //             $errors[] = "File {$name} lebih dari 2MB";
        //         }
        //     }
        // }

        // ================================
        // JIKA ADA ERROR → BALIK
        // ================================

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;

            $_SESSION["flash"] = [
                "status" => "error",
                "message" => implode("<br>", $errors),
            ];

            header("Location: ?page=edit-dip&id=" . $_POST["id"]);
            exit();
        }

        $model = new DipModel($pdo);

        $data = $_POST;
        $data["dibuat_oleh"] = currentUser()["id"];

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

        $_SESSION["flash"] = [
            "status" => "success",
            "message" => "Data DIP berhasil disimpan",
        ];

        header("Location: ?page=dip");
        exit();
    }

    // hapus
    public function delete()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new DipModel($pdo);
        $model->delete($_GET["id"]);

        header("Location: ?page=dip");
    }

    public function publicIndex()
    {
        authOnly();

        global $pdo;

        $user = currentUser();
        $role = currentRole();

        $model = new DipModel($pdo);
        $data = $model->getAll();

        require __DIR__ . "/../views/dip/publicIndex.php";
    }
}
