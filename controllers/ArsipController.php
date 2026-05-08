<?php

require_once __DIR__ . '/../core/BaseController.php';

class ArsipController extends BaseController
{
    private $model;
    private $modelJenis;
    private $modelPeserta;
    private $modelPesertaFile;
    private $modelPegawai;

    public function __construct()
    {
        $this->model = $this->model('ArsipModel');
        $this->modelJenis = $this->model('ArsipJenisModel');
        $this->modelPeserta = $this->model('ArsipPesertaModel');
        $this->modelPesertaFile = $this->model('ArsipPesertaFileModel');
        $this->modelPegawai = $this->model('PegawaiModel');
    }

    public function index()
    {
        $this->auth();

        $tanggalMulai   = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenisFilter    = $_GET['jenis'] ?? null;

        $data = (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenisFilter))
            ? $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenisFilter)
            : $this->model->getAll();

        $jenisList = $this->modelJenis->getAll();

        $jenis = $this->modelJenis->getAll();
        $pegawai = $this->modelPegawai->getAll();

        $totalArsip = count($data);
        $totalSudah = count(array_filter($data, fn($d) => (int)($d['upload_selesai'] ?? 0) === 1));
        $totalBelum = $totalArsip - $totalSudah;

        $this->view('arsip/index', [
            'data' => $data,
            'jenisList' => $jenisList,
            'jenis' => $jenis,
            'totalArsip' => $totalArsip,
            'totalSudah' => $totalSudah,
            'totalBelum' => $totalBelum,
            'pegawai' => $pegawai,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function create()
    {
        $this->auth();

        $jenis = $this->modelJenis->getAll();
        $pegawai = $this->modelPegawai->getAll();

        $this->view('arsip/createPeserta', [
            'jenis' => $jenis,
            'pegawai' => $pegawai,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip');
        }

        $errors = $this->validate($_POST, $_FILES);

        // dd($errors, $_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-arsip');
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
                'entity_type' => 'arsip',
                'entity_id' => $id,
                'description' => 'Menambah data arsip'
            ]);

            $this->flash('success', 'Arsip berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();

            debug_log($e->getMessage(), 'STORE ERROR');

            $this->flash('error', 'Gagal menyimpan data');
            return $this->redirect('?page=tambah-arsip');
        }
        return $this->redirect('?page=detail-arsip&id=' . $id);
    }

    public function show()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $peserta = $this->modelPeserta->getByArsip($id);
        $data = $this->model->getById($id);

        $files = $this->model->getFiles($id);
        $pegawai = $this->model->getAvailablePegawai($id);
        // dd($peserta);
        $jenis = $this->modelJenis->getAll();

        $this->view('arsip/detail', [
            'data' => $data,
            'peserta' => $peserta,
            'files' => $files,
            'pegawai' => $pegawai,
            'jenis' => $jenis,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);
        $files = $this->model->getFiles($id);
        $jenis = $this->modelJenis->getAll();

        $this->view('arsip/edit', [
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
            return $this->redirect('?page=arsip');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=arsip');
        }

        $id = (int) $_POST['id'];

        $errors = $this->validate($_POST, $_FILES, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-arsip&id=' . $id);
        }

        try {
            $this->model->beginTransaction();

            $data = $_POST;
            $data['updated_by'] = $this->user['id'];

            if (!$this->model->update($id, $data)) {
                throw new Exception("Update data arsip gagal");
            }

            // Hapus file yang dipilih
            if (!empty($_POST['hapus_file'])) {
                foreach (explode(",", $_POST['hapus_file']) as $fileId) {

                    $fileId = trim($fileId);

                    if (!ctype_digit($fileId)) continue;

                    if (!$this->model->deleteFileById($fileId)) {
                        throw new Exception("Gagal menghapus file arsip");
                    }
                }
            }

            // Upload file baru jika ada
            $this->handleUpload($id, $_FILES);

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'update',
                'entity_type' => 'arsip',
                'entity_id' => $id,
                'description' => 'Mengubah data arsip'
            ]);

            $this->flash('success', 'Arsip berhasil diperbarui');
        } catch (Throwable $e) {
            $this->model->rollback();

            debug_log($e->getMessage(), 'UPDATE ARSIP ERROR');

            $this->flash('error', 'Gagal memperbarui data arsip');
        }

        return $this->redirect('?page=arsip');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=arsip');
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
                'entity_type' => 'arsip',
                'entity_id' => $id,
                'description' => 'Menghapus data arsip'
            ]);

            $this->flash('success', 'Arsip berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal menghapus data');
        }

        return $this->redirect('?page=arsip');
    }

    public function createPeserta()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);
        $pegawai = $this->modelPegawai->getAll();
        $peserta = $this->modelPeserta->getAll();

        $this->view('arsip/create', [
            'data' => $data,
            'peserta' => $peserta,
            'pegawai' => $pegawai,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function storePeserta()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip');
        }

        $errors = $this->validate($_POST, $_FILES);

        // dd($errors, $_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-arsip');
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
                'entity_type' => 'arsip',
                'entity_id' => $id,
                'description' => 'Menambah data arsip'
            ]);

            $this->flash('success', 'Arsip berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();

            debug_log($e->getMessage(), 'STORE ERROR');

            $this->flash('error', 'Gagal menyimpan data');
            return $this->redirect('?page=tambah-arsip');
        }
        return $this->redirect('?page=detail-arsip&id=' . $id);
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

        $this->view('arsip/publicIndex', [
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

        $this->model->incrementDownload($file['peraturan_id']);

        $fullPath = __DIR__ . '/../' . $file['path_file'];

        if (!file_exists($fullPath)) {
            exit('File tidak ada di server');
        }

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

        $data  = $this->model->getById($id);
        $files = $this->model->getFiles($id);

        $this->view('arsip/publicDetail', [
            'data' => $data,
            'files' => $files,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    private function validate($data, $files, $isUpdate = false)
    {
        $errors = [];

        if (empty($data['judul']) || strlen($data['judul']) < 2)
            $errors['judul'] = "Judul minimal 2 karakter";

        if (empty($data['lokasi']))
            $errors['lokasi'] = "Lokasi wajib diisi";

        if (empty($data['tanggal_mulai']))
            $errors['tanggal_mulai'] = "Tanggal mulai wajib diisi";

        if (empty($data['tanggal_selesai']))
            $errors['tanggal_selesai'] = "Tanggal selesai wajib diisi";

        if (empty($data['jenis_id']))
            $errors['jenis_id'] = "Jenis wajib diisi";

        return $errors;
    }

    private function handleUpload($arsipId, $files)
    {
        if (empty($files['file']['name'][0])) return;

        $dir = realpath(__DIR__ . '/../uploads') . '/arsip/';

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

            $this->model->insertFile($arsipId, [
                'nama_file' => $nama,
                'path_file' => 'uploads/arsip/' . $namaBaru,
                'tipe_file' => $ext,
                'ukuran_file' => $size
            ]);
        }
    }
}
