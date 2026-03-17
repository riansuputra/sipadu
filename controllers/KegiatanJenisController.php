<?php

require_once __DIR__ . '/../core/BaseController.php';

class KegiatanJenisController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('KegiatanJenisModel');
    }

    public function index()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('jenis_kegiatan/index', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function create()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('jenis_kegiatan/create', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=kegiatan');
        }

        $errors = $this->validate($_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-jenis-kegiatan');
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
                'entity_type' => 'kegiatan_jenis',
                'entity_id' => $id,
                'description' => 'Menambah data Jenis kegiatan'
            ]);

            $this->flash('success', 'Jenis kegiatan berhasil disimpan');
        } catch (Throwable $e) {
            $this->model->rollback();

            if ($e instanceof PDOException && $e->getCode() == 23000) {
                $this->flash('error', 'Kode sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal menyimpan data');
            }
        }
        return $this->redirect('?page=tambah-jenis-kegiatan');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);

        $this->view('jenis_kegiatan/edit', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function update()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=jenis-kegiatan');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=jenis-kegiatan');
        }

        $errors = $this->validate($_POST, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-jenis-peraturan&id=' . $_POST['id']);
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
                'entity_type' => 'kegiatan_jenis',
                'entity_id' => $data['id'],
                'description' => 'Mengubah data Jenis kegiatan'
            ]);

            $this->flash('success', 'Jenis kegiatan berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            if ($e instanceof PDOException && $e->getCode() == 23000) {

                $this->flash('error', 'Kode sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal update data');
            }
        }
        return $this->redirect('?page=tambah-jenis-kegiatan');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=tambah-jenis-kegiatan');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=tambah-jenis-kegiatan');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];

            if ($this->model->isUsed($id)) {
                throw new Exception("Jenis kegiatan masih digunakan");
            }

            if (!$this->model->delete($id)) {
                throw new Exception("Gagal menghapus jenis");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'kegiatan_jenis',
                'entity_id' => $id,
                'description' => 'Menghapus data Jenis kegiatan'
            ]);

            $this->flash('success', 'Jenis kegiatan berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE JENIS ERROR');

            $this->flash('error', 'Jenis kegiatan tidak dapat dihapus karena masih digunakan');
        }

        return $this->redirect('?page=tambah-jenis-kegiatan');
    }

    private function validate($data, $isUpdate = false)
    {
        $errors = [];

        if (empty($data['nama']))
            $errors['nama'] = "Lembaga wajib diisi";

        return $errors;
    }
}
