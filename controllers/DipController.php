<?php

require_once __DIR__ . '/../core/BaseController.php';

class DipController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('DipModel');
    }

    public function index()
    {
        $this->auth();

        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $data = (!empty($tahun) || !empty($jenis))
            ? $this->model->getFiltered($tahun, $jenis)
            : $this->model->getAll();

        $this->view('dip/index', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function create()
    {
        $this->auth();

        $this->view('dip/create', [
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=dip');
        }

        $errors = $this->validate($_POST, $_FILES);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-dip');
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
                'entity_type' => 'dip',
                'entity_id' => $id,
                'description' => 'Menambah data DIP'
            ]);

            $this->flash('success', 'DIP berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();

            debug_log($e->getMessage(), 'STORE ERROR');

            $this->flash('error', 'Gagal menyimpan data');
        }
        return $this->redirect('?page=tambah-dip');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);
        $files = $this->model->getFiles($id);

        // dd($data);

        $this->view('dip/edit', [
            'data' => $data,
            'files' => $files,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function update()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=dip');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=dip');
        }

        $errors = $this->validate($_POST, $_FILES, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-dip&id=' . $_POST['id']);
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
                'entity_type' => 'dip',
                'entity_id' => $data['id'],
                'description' => 'Mengubah data DIP'
            ]);

            $this->flash('success', 'DIP berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'UPDATE ERROR');

            $this->flash('error', 'Gagal update data');
        }
        return $this->redirect('?page=dip');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=dip');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=dip');
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
                'entity_type' => 'dip',
                'entity_id' => $id,
                'description' => 'Menghapus data DIP'
            ]);

            $this->flash('success', 'DIP berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal menghapus data');
        }

        return $this->redirect('?page=dip');
    }

    public function printFilter()
    {
        $this->auth();

        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? []; // bisa array

        if (!is_array($jenis)) {
            $jenis = [$jenis];
        }

        $data = [];
        if ($tahun || !empty($jenis)) {
            $data = $this->model->getFiltered($tahun, $jenis);
        }

        $this->view('dip/printFilter', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function print()
    {
        $this->auth();

        $tahun_data  = $_POST['tahun'] ?? null;
        $jenis       = $_POST['jenis'] ?? [];

        if (!is_array($jenis)) {
            $jenis = [$jenis];
        }

        $nomor_surat   = $_POST['nomor_surat'] ?? '';
        $tanggal_surat = $_POST['tanggal_surat'] ?? '';
        $tentang       = $_POST['tentang'] ?? '';
        $tahun_judul   = $_POST['tahun_judul'] ?? date('Y');

        $jabatan_ttd   = $_POST['jabatan_ttd'] ?? '';
        $nama_ttd      = $_POST['nama_ttd'] ?? '';
        $nip_ttd       = $_POST['nip_ttd'] ?? '';

        $data = $this->model->getFiltered($tahun_data, $jenis);
        $dataGrouped = [];

        foreach ($data as $d) {
            $dataGrouped[$d['jenis_informasi']][] = $d;
        }

        $this->view('dip/print', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role,
            'nomor_surat' => $nomor_surat,
            'tanggal_surat' => $tanggal_surat,
            'tentang' => $tentang,
            'tahun_judul' => $tahun_judul,
            'jabatan_ttd' => $jabatan_ttd,
            'nama_ttd' => $nama_ttd,
            'nip_ttd' => $nip_ttd,
            'dataGrouped' => $dataGrouped,
        ]);
    }

    public function publicIndex()
    {
        $this->auth();

        $tahun = $_GET['tahun'] ?? null;
        $jenis = $_GET['jenis'] ?? null;

        $data = (!empty($tahun) || !empty($jenis))
            ? $this->model->getFiltered($tahun, $jenis)
            : $this->model->getAll();

        $this->view('dip/publicIndex', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function downloadFile()
    {
        $this->auth();


        $fileId = $_GET['file'];
        $dipId = $_GET['id'];


        $file  = $this->model->getFileById($fileId);

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

    private function validate($data, $files, $isUpdate = false)
    {
        $errors = [];
        if (empty($data['nama_informasi'])) {
            $errors['nama_informasi'] = "Nama informasi wajib diisi";
        } elseif (strlen($data['nama_informasi']) < 3) {
            $errors['nama_informasi'] = "Nama informasi minimal 3 karakter";
        }
        if (empty($data['unit_penyedia'])) {
            $errors['unit_penyedia'] = "Unit penguasaan wajib diisi";
        } elseif (strlen($data['unit_penyedia']) < 1) {
            $errors['unit_penyedia'] = "Unit penguasaan minimal 1 karakter";
        }
        if (!empty($data['penanggung_jawab']) && strlen($data['penanggung_jawab']) < 1) {
            $errors['penanggung_jawab'] = "Penanggung jawab minimal 1 karakter";
        }
        $allowedJenis = ['berkala', 'serta_merta', 'setiap_saat', 'dikecualikan'];
        if (empty($data['jenis_informasi']) || !in_array($data['jenis_informasi'], $allowedJenis)) {
            $errors['jenis_informasi'] = "Jenis informasi tidak valid";
        }
        $allowedBentuk = ['hardcopy', 'softcopy', 'hardcopy_softcopy'];
        if (empty($data['bentuk_informasi']) || !in_array($data['bentuk_informasi'], $allowedBentuk)) {
            $errors['bentuk_informasi'] = "Bentuk informasi tidak valid";
        }
        if (empty($data['tempat_pembuatan'])) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan wajib diisi";
        } elseif (strlen($data['tempat_pembuatan']) < 1) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan minimal 1 karakter";
        } elseif (strlen($data['tempat_pembuatan']) > 200) {
            $errors['tempat_pembuatan'] = "Tempat pembuatan maksimal 200 karakter";
        }
        $currentYear = (int) date('Y');
        $inputYear   = (int) $data['tahun_pembuatan'];

        if (empty($data['tahun_pembuatan'])) {
            $errors['tahun_pembuatan'] = "Tahun pembuatan wajib diisi";
        } elseif ($inputYear > $currentYear) {
            $errors['tahun_pembuatan'] = "Tahun pembuatan tidak boleh di masa depan";
        }
        // if (empty($data['retensi_arsip'])) {
        //     $errors['retensi_arsip'] = "Retensi arsip wajib diisi";
        // }

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

    private function handleUpload($dipId, $files)
    {
        if (empty($files['file']['name'][0])) return;

        $dir = realpath(__DIR__ . '/../uploads') . '/dip/';

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

            $this->model->insertFile($dipId, [
                'nama_file' => $nama,
                'path_file' => 'uploads/dip/' . $namaBaru,
                'tipe_file' => $ext,
                'ukuran_file' => $size
            ]);
        }
    }
}
