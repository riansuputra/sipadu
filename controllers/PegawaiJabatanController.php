<?php

require_once __DIR__ . '/../core/BaseController.php';

class PegawaiJabatanController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('PegawaiJabatanModel');
    }

    public function index()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('jabatan_pegawai/index', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function create()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('jabatan_pegawai/create', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=pegawai');
        }

        $errors = $this->validate($_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-jabatan-pegawai');
        }

        try {
            $this->model->beginTransaction();

            $data = $_POST;
            $nama = trim($data['nama']);

            $existing = $this->model->findByName($nama);

            // kalau ada tapi nonaktif, aktifkan lagi
            if ($existing && (int)$existing['is_active'] === 0) {
                $this->model->reactivate($existing['id']);
                $id = $existing['id'];
            } else {
                $id = $this->model->insert($data);

                if (!$id) {
                    throw new Exception("Insert gagal");
                }
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'store',
                'entity_type' => 'pegawai_jabatan',
                'entity_id' => $id,
                'description' => 'Menambah data jabatan pegawai'
            ]);

            $this->flash('success', 'Jabatan pegawai berhasil disimpan');
        } catch (Throwable $e) {
            $this->model->rollback();

            if ($e instanceof PDOException && $e->getCode() == 23000) {
                $this->flash('error', 'Nama jabatan sudah ada');
            } else {
                debug_log($e->getMessage(), 'STORE ERROR');
                $this->flash('error', 'Gagal menyimpan data');
            }
        }

        return $this->redirect('?page=tambah-jabatan-pegawai');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);

        $this->view('jabatan_pegawai/edit', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function update()
    {
        // dd($_POST);
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=pegawai');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=pegawai');
        }

        $errors = $this->validate($_POST, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-jabatan-pegawai&id=' . $_POST['id']);
        }

        try {

            $this->model->beginTransaction();

            $data = $_POST;

            if (!$this->model->update($_POST['id'], $data)) {
                throw new Exception("Update gagal");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'update',
                'entity_type' => 'pegawai_jabatan',
                'entity_id' => $data['id'],
                'description' => 'Mengubah data jabatan pegawai'
            ]);

            $this->flash('success', 'Jabatan pegawai berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            if ($e instanceof PDOException && $e->getCode() == 23000) {

                $this->flash('error', 'Jenis sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal update data');
            }
        }
        return $this->redirect('?page=tambah-jabatan-pegawai');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=tambah-jabatan-pegawai');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=tambah-jabatan-pegawai');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if ($this->model->isUsed($id)) {
                throw new Exception("Jabatan pegawai masih digunakan");
            }

            if (!$this->model->delete($id)) {
                throw new Exception("Gagal menghapus jenis");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'pegawai_jabatan',
                'entity_id' => $id,
                'description' => 'Menghapus data jabatan pegawai'
            ]);

            $this->flash('success', 'Jabatan pegawai berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE JENIS ERROR');

            $this->flash('error', 'Jabatan pegawai tidak dapat dihapus karena masih digunakan');
        }

        return $this->redirect('?page=tambah-jabatan-pegawai');
    }

    private function validate($data, $isUpdate = false, $id = null)
    {
        $errors = [];

        $nama = trim($data['nama'] ?? '');

        if ($nama === '') {
            $errors['nama'] = "Jabatan pegawai wajib diisi";
            return $errors;
        }

        $existing = $this->model->findByName($nama);

        if ($existing) {
            // kalau update, abaikan data dirinya sendiri
            if ($isUpdate && (int)$existing['id'] === (int)$id) {
                return $errors;
            }

            // kalau data yang ketemu masih aktif, baru error
            if ((int)$existing['is_active'] === 1) {
                $errors['nama'] = "Nama jabatan sudah ada";
            }
        }

        return $errors;
    }
}
