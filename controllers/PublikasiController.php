<?php

require_once __DIR__ . '/../core/BaseController.php';

class PublikasiController extends BaseController
{
    private $model;
    private $modelJenis;

    public function __construct()
    {
        $this->model = $this->model('PublikasiModel');
        $this->modelJenis = $this->model('PublikasiJenisModel');
    }

    public function index()
    {
        $this->auth();

        $pokjaId = $this->pokja ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenisFilter = $_GET['jenis'] ?? null;

        $jenis = $this->modelJenis->getAll();

        $data = $this->model->getByRole(
            $this->role,
            $pokjaId,
            $tanggalMulai,
            $tanggalSelesai,
            $jenisFilter
        );

        $this->view('publikasi/index', [
            'data' => $data,
            'jenis' => $jenis,
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function create()
    {
        $this->auth();

        $jenis = $this->modelJenis->getAll();

        $this->view('publikasi/create', [
            'user' => $this->user,
            'role' => $this->role,
            'jenis' => $jenis
        ]);
    }

    public function store()
    {
        // dd($_POST);
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=publikasi');
        }

        $errors = $this->validate($_POST, $_FILES);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-publikasi');
        }

        try {
            $this->model->beginTransaction();

            $data = $_POST;
            $data['created_by'] = $this->user['id'];
            $data['pokja_id'] = $this->pokja;

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
                'entity_type' => 'publikasi',
                'entity_id' => $_POST['id'],
                'description' => 'Menambah data Publikasi'
            ]);

            $this->flash('success', 'Publikasi berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();

            debug_log($e->getMessage(), 'STORE ERROR');

            $this->flash('error', 'Gagal menyimpan data');
        }
        return $this->redirect('?page=tambah-publikasi');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'];

        $data = $this->model->getById($id);
        $files = $this->model->getFiles($id);
        $jenis = $this->modelJenis->getAll();

        $this->view('publikasi/edit', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data,
            'files' => $files,
            'jenis' => $jenis
        ]);
    }

    public function update()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=publikasi');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=publikasi');
        }

        $errors = $this->validate($_POST, $_FILES, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-publikasi&id=' . $_POST['id']);
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
                'entity_type' => 'publikasi',
                'entity_id' => $_POST['id'],
                'description' => 'Mengubah data Publikasi'
            ]);

            $this->flash('success', 'Publikasi berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'UPDATE ERROR');

            $this->flash('error', 'Gagal update data');
        }
        return $this->redirect('?page=publikasi');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=publikasi');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=publikasi');
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
                'entity_type' => 'publikasi',
                'entity_id' => $id,
                'description' => 'Menghapus data Publikasi'
            ]);

            $this->flash('success', 'Publikasi berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal menghapus data');
        }

        return $this->redirect('?page=publikasi');
    }

    public function editStatus()
    {
        $this->auth();

        $id = $_GET['id'];

        $data = $this->model->getById($id);
        $files = $this->model->getFiles($id);
        $jenis = $this->modelJenis->getAll();

        $this->view('publikasi/editStatus', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data,
            'files' => $files,
            'jenis' => $jenis
        ]);
    }

    public function approve()
    {
        $this->auth();

        // ======================
        // VALIDASI INPUT
        // ======================
        $errors = [];

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $errors['id'] = "ID publikasi tidak valid";
        }

        $isPublished = isset($_POST['is_published']) ? 1 : 0;
        $linksInput = $_POST['publish_links'] ?? [];
        $cleanLinks = [];

        if ($isPublished) {

            foreach ($linksInput as $link) {

                $platform = trim($link['platform'] ?? '');
                $url      = trim($link['url'] ?? '');

                if (!$platform && !$url) continue;

                if (!$platform) {
                    $errors['publish_links'] = "Platform wajib dipilih";
                    break;
                }

                if (!$url) {
                    $errors['publish_links'] = "Link publikasi wajib diisi";
                    break;
                }

                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    $errors['publish_links'] = "Format URL tidak valid";
                    break;
                }

                $cleanLinks[] = [
                    'platform' => $platform,
                    'url'      => $url
                ];
            }

            if (empty($cleanLinks)) {
                $errors['publish_links'] = "Minimal 1 link publish wajib diisi jika publish aktif";
            }
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = $_POST;
            return $this->redirect('?page=edit-status-publikasi&id=' . $_POST['id']);
        }

        // ======================
        // DATA UPDATE
        // ======================
        $data = [
            'is_published' => $isPublished,
            'published_at' => $isPublished ? date('Y-m-d H:i:s') : null,
            'published_by' => $isPublished ? $this->user['id'] : null,
            'updated_by'   => $this->user['id']
        ];

        if (!empty($cleanLinks)) {
            $data['publish_links'] = json_encode($cleanLinks);
        }

        // ======================
        // TRY TRANSACTION
        // ======================
        try {

            $this->model->beginTransaction();

            if (!$this->model->updatePublish($_POST['id'], $data)) {
                throw new Exception("Gagal update publish");
            }

            $this->model->commit();

            $this->flash(
                'success',
                $isPublished
                    ? 'Publikasi berhasil dipublish'
                    : 'Publikasi di-unpublish'
            );
        } catch (Throwable $e) {

            $this->model->rollback();

            debug_log($e->getMessage(), 'APPROVE ERROR');

            $this->flash('error', 'Gagal mengubah status publikasi');
        }

        return $this->redirect('?page=timpublikasi');
    }

    public function publicIndex()
    {
        $this->auth();



        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;




        $data = $this->model->getByRole(
            $this->role,
            $pokjaId,
            $tanggalMulai,
            $tanggalSelesai,
            $jenis
        );

        $this->view('publikasi/publicIndex', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function publikasiIndex()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_GET['jenis']);
        // echo "</pre>";
        // die();
        $this->auth();



        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;



        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            // default
            $data = $this->model->getAll();
        }

        $this->view('publikasi/timindex', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    private function validate($data, $files, $isUpdate = false)
    {
        $errors = [];

        if (empty($data['judul'])) {
            $errors['judul'] = "Judul wajib diisi";
        } elseif (strlen($data['judul']) < 2) {
            $errors['judul'] = "Judul minimal 2 karakter";
        }
        if (!empty($data['deskripsi']) && strlen($data['deskripsi']) < 1) {
            $errors['deskripsi'] = "Deskripsi minimal 1 karakter";
        }
        $currentDate = date('Y-m-d');
        $inputDate   = $data['tanggal_kegiatan'] ?? '';

        if (empty($inputDate)) {
            $errors['tanggal_kegiatan'] = "Tanggal kegiatan wajib diisi";
        } elseif ($inputDate > $currentDate) {
            $errors['tanggal_kegiatan'] = "Tanggal kegiatan tidak boleh di masa depan";
        }

        if (empty($data['lokasi'])) {
            $errors['lokasi'] = "Lokasi kegiatan wajib diisi";
        }
        if (empty($data['jenis_id'])) {
            $errors['jenis_id'] = "Jenis wajib diisi";
        }
        if (empty($data['penulis'])) {
            $errors['penulis'] = "Penulis wajib diisi";
        }
        if (empty($data['kabupaten'])) {
            $errors['kabupaten'] = "Kabupaten/Kota wajib diisi";
        }

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

    private function handleUpload($publikasiId, $files)
    {
        if (empty($files['file']['name'][0])) return;

        $dir = realpath(__DIR__ . '/../uploads') . '/publikasi/';

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

            $this->model->insertFile($publikasiId, [
                'nama_file' => $nama,
                'path_file' => 'uploads/publikasi/' . $namaBaru,
                'tipe_file' => $ext,
                'ukuran_file' => $size
            ]);
        }
    }

    public function indexPaud()
    {
        $this->auth();

        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $jenisInput = $this->modelJenis->getAll();

        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            $data = $this->model->getPaud();
        }

        $this->view('paud/publikasi', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function indexSd()
    {
        $this->auth();


        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $jenisInput = $this->modelJenis->getAll();

        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            $data = $this->model->getSd();
        }

        $this->view('sd/publikasi', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function indexSmp()
    {
        $this->auth();

        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $jenisInput = $this->modelJenis->getAll();

        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            $data = $this->model->getSmp();
        }

        $this->view('smp/publikasi', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function indexSma()
    {
        $this->auth();

        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $jenisInput = $this->modelJenis->getAll();

        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            $data = $this->model->getSma();
        }

        $this->view('sma/publikasi', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function indexWidyaprada()
    {
        $this->auth();

        $pokjaId = $this->user['pokja_id'] ?? null;

        $tanggalMulai = $_GET['tanggal_mulai'] ?? null;
        $tanggalSelesai = $_GET['tanggal_selesai'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $jenisInput = $this->modelJenis->getAll();

        if (!empty($tanggalMulai) || !empty($tanggalSelesai) || !empty($jenis)) {
            $data = $this->model->getFiltered($tanggalMulai, $tanggalSelesai, $jenis);
        } else {
            $data = $this->model->getWp();
        }

        $this->view('widyaprada/publikasi', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }
}
