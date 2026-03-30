<?php

require_once __DIR__ . '/../core/BaseController.php';

class ArsipPesertaController extends BaseController
{
    private $model;
    private $modelArsip;
    private $modelPegawai;

    public function __construct()
    {
        $this->model = $this->model('ArsipPesertaModel');
        $this->modelArsip = $this->model('ArsipModel');
        $this->modelPegawai = $this->model('PegawaiModel');
    }

    public function index()
    {
        $this->auth();

        $arsip_id = $_GET['id'] ?? null;

        if (!$arsip_id || !ctype_digit($arsip_id)) {
            die("ID arsip tidak valid");
        }

        $arsip = $this->modelArsip->getById($arsip_id);
        $peserta = $this->model->getByArsip($arsip_id);
        $pegawai = $this->model->getAvailablePegawai($arsip_id);

        $this->view('arsip/peserta', [
            'arsip' => $arsip,
            'peserta' => $peserta,
            'pegawai' => $pegawai,
            'arsip_id' => $arsip_id,
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

        $arsip_id = $_POST['arsip_id'] ?? null;
        $pegawai_ids = $_POST['pegawai_id'] ?? [];

        if (!$arsip_id || !ctype_digit($arsip_id)) {
            $this->flash('error', 'ID arsip tidak valid');
            return $this->redirect('?page=arsip');
        }

        if (empty($pegawai_ids) || !is_array($pegawai_ids)) {
            $this->flash('error', 'Pilih minimal satu peserta');
            return $this->redirect('?page=detail-arsip&id=' . $arsip_id);
        }

        try {
            $this->model->beginTransaction();

            $berhasil = 0;
            $dilewati = 0;
            $diaktifkan = 0;

            foreach ($pegawai_ids as $pegawai_id) {

                if (!ctype_digit((string)$pegawai_id)) continue;

                $existing = $this->model->findByArsipPegawai($arsip_id, $pegawai_id);

                if ($existing) {
                    if ((int)$existing['is_active'] === 0) {
                        $this->model->reactivate($existing['id']);
                        $diaktifkan++;
                    } else {
                        $dilewati++;
                    }
                    continue;
                }

                $this->model->insert([
                    'arsip_id' => $arsip_id,
                    'pegawai_id' => $pegawai_id,
                    'status' => 'diundang'
                ]);

                $berhasil++;
            }

            $this->model->commit();

            $pesan = [];

            if ($berhasil > 0) $pesan[] = "$berhasil peserta ditambahkan";
            if ($diaktifkan > 0) $pesan[] = "$diaktifkan peserta diaktifkan kembali";
            if ($dilewati > 0) $pesan[] = "$dilewati peserta sudah terdaftar";

            $this->flash('success', implode(', ', $pesan) ?: 'Peserta berhasil diproses');
        } catch (Throwable $e) {
            $this->model->rollback();
            debug_log($e->getMessage(), 'STORE PESERTA ARSIP ERROR');
            $this->flash('error', 'Gagal menambahkan peserta');
        }

        return $this->redirect('?page=detail-arsip&id=' . $arsip_id);
    }

    public function update()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip');
        }

        $id = $_POST['id'] ?? null;
        $arsip_id = $_POST['arsip_id'] ?? null;
        $pegawai_id = $_POST['pegawai_id'] ?? null;

        if (!$id || !ctype_digit($id)) {
            $this->flash('error', 'ID peserta tidak valid');
            return $this->redirect('?page=arsip');
        }

        if (!$arsip_id || !ctype_digit($arsip_id)) {
            $this->flash('error', 'ID arsip tidak valid');
            return $this->redirect('?page=arsip');
        }

        if (!$pegawai_id || !ctype_digit($pegawai_id)) {
            $this->flash('error', 'Pegawai tidak valid');
            return $this->redirect('?page=detail-arsip&id=' . $arsip_id);
        }

        try {
            $current = $this->model->getById($id);

            if (!$current) {
                throw new Exception("Peserta tidak ditemukan");
            }

            // cegah duplikat saat ganti pegawai
            if ((int)$current['pegawai_id'] !== (int)$pegawai_id) {
                if ($this->model->exists($arsip_id, $pegawai_id)) {
                    $this->flash('error', 'Pegawai tersebut sudah menjadi peserta');
                    return $this->redirect('?page=detail-arsip&id=' . $arsip_id);
                }
            }

            if (!$this->model->update($id, [
                'pegawai_id' => $pegawai_id
            ])) {
                throw new Exception("Gagal update peserta");
            }

            $this->flash('success', 'Peserta berhasil diperbarui');
        } catch (Throwable $e) {
            debug_log($e->getMessage(), 'UPDATE PESERTA ARSIP ERROR');
            $this->flash('error', 'Gagal memperbarui peserta');
        }

        return $this->redirect('?page=detail-arsip&id=' . $arsip_id);
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip');
        }

        $id = $_POST['id'] ?? null;
        $arsip_id = $_POST['arsip_id'] ?? null;

        if (!$id || !ctype_digit($id)) {
            $this->flash('error', 'ID peserta tidak valid');
            return $this->redirect('?page=arsip');
        }

        try {
            $this->model->delete($id);

            $this->flash('success', 'Peserta berhasil dihapus');
        } catch (Throwable $e) {
            debug_log($e->getMessage(), 'DELETE PESERTA ARSIP ERROR');
            $this->flash('error', 'Gagal menghapus peserta');
        }

        return $this->redirect('?page=detail-arsip&id=' . $arsip_id);
    }

    public function indexPeserta()
    {
        $this->auth();

        $pegawaiId = $this->user['pegawai_id'] ?? null;

        // dd($pegawaiId);

        if (!$pegawaiId) {
            $this->flash('error', 'Akun Anda belum terhubung ke data pegawai');
            return $this->redirect('?page=dashboard');
        }

        $filters = [
            'judul' => $_GET['judul'] ?? '',
            'tahun' => $_GET['tahun'] ?? ''
        ];

        $data = $this->model->getArsipSaya($pegawaiId, $filters);

        $this->view('arsip_peserta/index', [
            'data' => $data,
            'filters' => $filters,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function showPeserta()
    {
        $this->auth();

        $pegawaiId = $this->user['pegawai_id'] ?? null;
        $arsipId = $_GET['id'] ?? null;


        if (!$pegawaiId) {
            $this->flash('error', 'Akun Anda belum terhubung ke data pegawai');
            return $this->redirect('?page=dashboard');
        }

        if (!$arsipId || !ctype_digit($arsipId)) {
            $this->flash('error', 'ID arsip tidak valid');
            return $this->redirect('?page=arsip-saya');
        }

        $data = $this->model->getDetailArsipSaya($arsipId, $pegawaiId);
        // dd($data);

        if (!$data) {
            $this->flash('error', 'Data arsip tidak ditemukan atau Anda bukan peserta arsip ini');
            return $this->redirect('?page=arsip-saya');
        }

        $files = $this->model->getFilesByArsipPeserta($data['arsip_peserta_id']);
        // dd($files);


        $this->view('arsip_peserta/detail', [
            'data' => $data,
            'files' => $files,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function uploadBukti()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip-saya');
        }

        $pegawaiId = $this->user['pegawai_id'] ?? null;

        if (!$pegawaiId) {
            $this->flash('error', 'Akun Anda belum terhubung ke data pegawai');
            return $this->redirect('?page=dashboard');
        }

        $arsipPesertaId = $_POST['arsip_peserta_id'] ?? null;
        $arsipId = $_POST['arsip_id'] ?? null;

        if (!$arsipPesertaId || !ctype_digit($arsipPesertaId)) {
            $this->flash('error', 'Data peserta arsip tidak valid');
            return $this->redirect('?page=arsip-saya');
        }

        if (!$arsipId || !ctype_digit($arsipId)) {
            $this->flash('error', 'Data arsip tidak valid');
            return $this->redirect('?page=arsip-saya');
        }

        $arsipPeserta = $this->model->getArsipPesertaByIdAndPegawai($arsipPesertaId, $pegawaiId);

        if (!$arsipPeserta) {
            $this->flash('error', 'Anda tidak memiliki akses ke arsip ini');
            return $this->redirect('?page=arsip-saya');
        }

        if (empty($_FILES['file']['name'][0])) {
            $this->flash('error', 'Silakan pilih minimal 1 file');
            return $this->redirect('?page=detail-arsip-saya&id=' . $arsipId);
        }

        try {
            $this->model->beginTransaction();

            $this->handleUploadBukti($arsipPesertaId, $_FILES);

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'upload',
                'entity_type' => 'arsip_peserta_file',
                'entity_id' => $arsipPesertaId,
                'description' => 'Mengunggah bukti arsip oleh peserta'
            ]);

            $this->flash('success', 'Bukti berhasil diunggah');
        } catch (Throwable $e) {
            $this->model->rollback();
            debug_log($e->getMessage(), 'UPLOAD BUKTI ARSIP ERROR');
            $this->flash('error', 'Gagal mengunggah bukti');
        }

        return $this->redirect('?page=detail-arsip-saya&id=' . $arsipId);
    }

    public function deleteBukti()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=arsip-saya');
        }

        $pegawaiId = $this->user['pegawai_id'] ?? null;

        if (!$pegawaiId) {
            $this->flash('error', 'Akun Anda belum terhubung ke data pegawai');
            return $this->redirect('?page=dashboard');
        }

        $fileId = $_POST['id'] ?? null;
        $arsipId = $_POST['arsip_id'] ?? null;

        if (!$fileId || !ctype_digit($fileId)) {
            $this->flash('error', 'ID file tidak valid');
            return $this->redirect('?page=arsip-saya');
        }

        if (!$arsipId || !ctype_digit($arsipId)) {
            $this->flash('error', 'ID arsip tidak valid');
            return $this->redirect('?page=arsip-saya');
        }

        $file = $this->model->getFileById($fileId);

        if (!$file) {
            $this->flash('error', 'File tidak ditemukan');
            return $this->redirect('?page=detail-arsip-saya&id=' . $arsipId);
        }

        $cekAkses = $this->model->isFileMilikPegawai($fileId, $pegawaiId);

        if (!$cekAkses) {
            $this->flash('error', 'Anda tidak memiliki akses ke file ini');
            return $this->redirect('?page=detail-arsip-saya&id=' . $arsipId);
        }

        try {
            $this->model->beginTransaction();

            if (!$this->model->deleteFileById($fileId)) {
                throw new Exception("Gagal menghapus file");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'arsip_peserta_file',
                'entity_id' => $fileId,
                'description' => 'Menghapus bukti arsip oleh peserta'
            ]);

            $this->flash('success', 'File bukti berhasil dihapus');
        } catch (Throwable $e) {
            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE BUKTI ARSIP ERROR');
            $this->flash('error', 'Gagal menghapus file bukti');
        }

        return $this->redirect('?page=detail-arsip-saya&id=' . $arsipId);
    }

    // Upload file bukti arsip peserta
    private function handleUploadBukti($arsipPesertaId, $files)
    {
        if (empty($files['file']['name'][0])) return;

        $dir = realpath(__DIR__ . '/../uploads') . '/arsip_peserta/';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'webp'];

        foreach ($files['file']['name'] as $i => $nama) {

            if (!$nama) continue;

            $tmp  = $files['file']['tmp_name'][$i];
            $size = $files['file']['size'][$i];
            $ext  = strtolower(pathinfo($nama, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                throw new Exception("Format file tidak diizinkan");
            }

            if ($size > 5 * 1024 * 1024) {
                throw new Exception("Ukuran file maksimal 5MB");
            }

            $namaBaru = time() . '_' . $i . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);
            $path = $dir . $namaBaru;

            if (!move_uploaded_file($tmp, $path)) {
                throw new Exception("Upload file gagal");
            }

            $this->model->insertFileBukti([
                'arsip_peserta_id' => $arsipPesertaId,
                'nama_file' => $nama,
                'path_file' => 'uploads/arsip_peserta/' . $namaBaru,
                'tipe_file' => $ext,
                'ukuran_file' => $size
            ]);
        }
    }
}
