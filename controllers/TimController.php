<?php

require_once __DIR__ . '/../core/BaseController.php';

class TimController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('TimModel');
    }

    public function create()
    {
        $this->auth();

        $data  = $this->model->getAll();

        $this->view('tim/create', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=user');
        }

        $errors = $this->validate($_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-tim');
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
                'entity_type' => 'pokja',
                'entity_id' => $id,
                'description' => 'Menambah data tim / unit'
            ]);

            $this->flash('success', 'Tim berhasil disimpan');
        } catch (Throwable $e) {
            $this->model->rollback();

            if ($e instanceof PDOException && $e->getCode() == 23000) {
                $this->flash('error', 'Tim sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal menyimpan data');
            }
        }
        return $this->redirect('?page=tambah-tim');
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);

        $this->view('tim/edit', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function update()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=tambah-tim');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=tambah-tim');
        }

        $errors = $this->validate($_POST, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-tim&id=' . $_POST['id']);
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
                'entity_type' => 'pokja',
                'entity_id' => $data['id'],
                'description' => 'Mengubah data Tim/unit'
            ]);

            $this->flash('success', 'Tim/unit berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            if ($e instanceof PDOException && $e->getCode() == 23000) {

                $this->flash('error', 'Kode sudah digunakan');
            } else {

                debug_log($e->getMessage(), 'UPDATE ERROR');
                $this->flash('error', 'Gagal update data');
            }
        }
        return $this->redirect('?page=tambah-tim');
    }

    public function delete()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=tambah-tim');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=tambah-tim');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];


            if ($this->model->isUsed($id)) {
                throw new Exception("Tim/unit masih digunakan");
            }

            // dd(!$this->model->delete($id));

            if (!$this->model->delete($id)) {
                throw new Exception("Gagal menghapus jenis");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'pokja',
                'entity_id' => $id,
                'description' => 'Menghapus data Tim/unit'
            ]);

            $this->flash('success', 'Tim/unit berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE JENIS ERROR');

            $this->flash('error', 'Tim/unit tidak dapat dihapus karena masih digunakan');
        }

        return $this->redirect('?page=tambah-tim');
    }

    private function validate($data, $isUpdate = false)
    {
        $errors = [];

        if (empty($data['pokja_tipe']))
            $errors['pokja_tipe'] = "Tim / Unit wajib diisi";

        if (empty($data['pokja_nama'])) {
            $errors['pokja_nama'] = "Nama tim / unit wajib diisi";
        } else {
            $id = $isUpdate ? ($data['id'] ?? null) : null;

            if ($this->model->kodeExists($data['pokja_nama'], $id)) {
                $errors['pokja_nama'] = "Nama tim / unit sudah digunakan";
            }
        }

        return $errors;
    }
}
