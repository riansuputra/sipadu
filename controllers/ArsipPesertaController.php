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
}
