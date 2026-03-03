<?php

require_once __DIR__ . '/../core/BaseController.php';

class PeraturanController extends BaseController
{
    private $model;
    private $modelJenis;

    public function __construct()
    {
        $this->model = $this->model('PeraturanModel');
        $this->modelJenis = $this->model('PeraturanJenisModel');
    }

    public function index()
    {
        $this->auth();

        $tahun = $_GET['tahun'] ?? null;
        $jenis_filter = $_GET['jenis'] ?? null;

        $jenis = $this->modelJenis->getAll();

        $data = (!empty($tahun) || !empty($jenis_filter))
            ? $this->model->getFiltered($tahun, $jenis_filter)
            : $this->model->getAll();

        $this->view('peraturan/index', [
            'data' => $data,
            'jenis' => $jenis,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function create()
    {
        $this->auth();

        $jenis = $this->modelJenis->getAll();

        $this->view('peraturan/create', [
            'jenis' => $jenis,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=peraturan');
        }

        $errors = $this->validate($_POST, $_FILES);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-peraturan');
        }

        try {
            $this->model->beginTransaction();

            $data = $_POST;
            $data['created_by'] = $this->user['id'];

            $id = $this->model->insert($data);

            if (!$id) {
                throw new Exception("Insert gagal");
            }

            $this->handleUpload($id, $_FILES);

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'store',
                'entity_type' => 'peraturan',
                'entity_id' => $_POST['id'],
                'description' => 'Menambah data Peraturan'
            ]);

            $this->flash('success', 'Peraturan berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();

            debug_log($e->getMessage(), 'STORE ERROR');

            $this->flash('error', 'Gagal menyimpan data');
        }
        return $this->redirect('?page=tambah-peraturan');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);
        $files = $this->model->getFiles($id);
        $jenis = $this->modelJenis->getAll();

        $this->view('peraturan/edit', [
            'data' => $data,
            'files' => $files,
            'jenis' => $jenis,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function update()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=peraturan');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=peraturan');
        }

        $errors = $this->validate($_POST, $_FILES, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-peraturan&id=' . $_POST['id']);
        }

        try {
            $this->model->beginTransaction();

            $data = $_POST;
            $data['updated_by'] = $this->user['id'];

            if (!$this->model->update($_POST['id'], $data)) {
                throw new Exception("Update gagal");
            }

            if (!empty($_POST["hapus_file"])) {

                foreach (explode(",", $_POST["hapus_file"]) as $fileId) {

                    if (!ctype_digit($fileId)) continue;

                    if (!$this->model->deleteFileById($fileId)) {
                        throw new Exception("Gagal hapus file");
                    }
                }
            }

            $this->handleUpload($_POST['id'], $_FILES);

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'update',
                'entity_type' => 'peraturan',
                'entity_id' => $_POST['id'],
                'description' => 'Mengubah data Peraturan'
            ]);

            $this->flash('success', 'Peraturan berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'UPDATE ERROR');

            $this->flash('error', 'Gagal update data');
        }
        return $this->redirect('?page=peraturan');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=peraturan');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=peraturan');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if (!$this->model->delete($id, $this->user['id'])) {
                throw new Exception("Gagal menghapus data");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'peraturan',
                'entity_id' => $id,
                'description' => 'Menghapus data Peraturan'
            ]);

            $this->flash('success', 'Peraturan berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal menghapus data');
        }

        return $this->redirect('?page=peraturan');
    }

    // =================================== Belum dicek ========================================

    public function publicIndex()
    {
        $this->auth();

        $jenis = $this->modelJenis->getAll();

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

        $data  = $this->model->filterWithPagination($params, $limit, $offset);
        $total = $allEmpty
            ? $this->model->countAll()
            : $this->model->countFiltered($params);

        $totalPage = ceil($total / $limit);

        $this->view('peraturan/publicIndex', [
            'data' => $data,
            'jenis' => $jenis,
            'totalPage' => $totalPage,
            'page' => $page,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function downloadFile()
    {
        $this->auth();


        $fileId = $_GET['file'];
        $peraturanId = $_GET['id'];


        $file  = $this->model->getFileById($fileId);

        if (!$file) {
            exit('File tidak ditemukan');
        }

        // hitung download (di tabel peraturan)
        $this->model->incrementDownload($peraturanId);

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
        $this->auth();


        $fileId = $_GET['file'];


        $file  = $this->model->getFileById($fileId);

        if (!$file) {
            exit('File tidak ditemukan');
        }

        // hitung download (di tabel peraturan)
        $this->model->incrementDownload($file['peraturan_id']);

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
        $this->auth();




        $this->model->incrementView($id);


        // Ambil data peraturan
        $data  = $this->model->getById($id);

        // Ambil file terkait
        $files = $this->model->getFiles($id);
        require __DIR__ . '/../views/peraturan/publicDetail.php';
    }

    private function validate($data, $files, $isUpdate = false)
    {
        $errors = [];

        if (empty($data['judul']) || strlen($data['judul']) < 2)
            $errors['judul'] = "Judul minimal 2 karakter";

        if (empty($data['nomor']))
            $errors['nomor'] = "Nomor wajib diisi";

        if (empty($data['lembaga']))
            $errors['lembaga'] = "Lembaga wajib diisi";

        if (empty($data['jenis_id']))
            $errors['jenis_id'] = "Jenis wajib diisi";

        if (!empty($files['file']['name'][0])) {
            $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'webp'];

            foreach ($files['file']['name'] as $i => $name) {
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $size = $files['file']['size'][$i];

                if (!in_array($ext, $allowed))
                    $errors['file'] = "File tidak diizinkan";

                if ($size > 5 * 1024 * 1024)
                    $errors['file'] = "File maksimal 5MB";
            }
        }

        return $errors;
    }

    private function handleUpload($peraturanId, $files)
    {
        if (empty($files['file']['name'][0])) return;

        $dir = realpath(__DIR__ . '/../uploads') . '/peraturan/';

        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            throw new Exception("Folder upload gagal dibuat");
        }

        foreach ($files['file']['name'] as $i => $nama) {

            if (!$nama) continue;

            $tmp  = $files['file']['tmp_name'][$i];
            $size = $files['file']['size'][$i];
            $ext  = strtolower(pathinfo($nama, PATHINFO_EXTENSION));

            $namaBaru = time() . '_' . $i . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);
            $path = $dir . $namaBaru;

            if (!move_uploaded_file($tmp, $path)) {
                throw new Exception("Upload file gagal");
            }

            $this->model->insertFile($peraturanId, [
                'nama_file' => $nama,
                'path_file' => 'uploads/peraturan/' . $namaBaru,
                'tipe_file' => $ext,
                'ukuran_file' => $size
            ]);
        }
    }
}
