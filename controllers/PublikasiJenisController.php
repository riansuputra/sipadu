<?php

require_once __DIR__ . '/../core/BaseController.php';

class PublikasiJenisController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('PublikasiJenisModel');
    }

    public function index()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('jenis_publikasi/index', [
            'user' => $this->user,
            'role' => $this->role,
            'data' => $data
        ]);
    }

    public function create()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('jenis_publikasi/create', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=publikasi');
        }

        $errors = $this->validate($_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-jenis-publikasi');
        }

        try {
            $this->model->beginTransaction();

            $data = $_POST;
            $id = $this->model->insert($data);

            if (!$id) {
                throw new Exception("Insert gagal");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'store',
                'entity_type' => 'publikasi_jenis',
                'entity_id' => $id,
                'description' => 'Menambah data Jenis Publikasi'
            ]);

            $this->flash('success', 'Jenis publikasi berhasil disimpan');
        } catch (Throwable $e) {
            $this->model->rollback();

            if ($e instanceof PDOException && $e->getCode() == 23000) {
                $this->flash('error', 'Jenis publikasi sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal menyimpan data');
            }
        }
        return $this->redirect('?page=tambah-jenis-publikasi');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);

        $this->view('jenis_publikasi/edit', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
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

        $errors = $this->validate($_POST, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-jenis-publikasi&id=' . $_POST['id']);
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
                'entity_type' => 'publikasi_jenis',
                'entity_id' => $data['id'],
                'description' => 'Mengubah data Jenis Publikasi'
            ]);

            $this->flash('success', 'Jenis publikasi berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            if ($e instanceof PDOException && $e->getCode() == 23000) {

                $this->flash('error', 'Jenis sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal update data');
            }
        }
        return $this->redirect('?page=tambah-jenis-publikasi');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=tambah-jenis-publikasi');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=tambah-jenis-publikasi');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if ($this->model->isUsed($id)) {
                throw new Exception("Jenis publikasi masih digunakan");
            }

            if (!$this->model->delete($id)) {
                throw new Exception("Gagal menghapus jenis");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'publikasi_jenis',
                'entity_id' => $id,
                'description' => 'Menghapus data Jenis Publikasi'
            ]);

            $this->flash('success', 'Jenis publikasi berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE JENIS ERROR');

            $this->flash('error', 'Jenis publikasi tidak dapat dihapus karena masih digunakan');
        }

        return $this->redirect('?page=tambah-jenis-publikasi');
    }

    private function validate($data, $isUpdate = false, $id = null)
    {
        $errors = [];

        $nama = trim($data['nama'] ?? '');

        if ($nama === '') {
            $errors['nama'] = "Jenis publikasi wajib diisi";
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
                $errors['nama'] = "Jenis publikasi sudah ada";
            }
        }

        return $errors;
    }
}
