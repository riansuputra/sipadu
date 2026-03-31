<?php

require_once __DIR__ . '/../core/BaseController.php';

class ModulController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('ModulModel');
    }

    public function index()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $data = $this->model->getAllWithRelations();

        $this->view('modul/index', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function create()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $pokja = $this->model->getAllPokja();
        $roles = $this->model->getAllRole();

        $this->view('modul/create', [
            'pokja' => $pokja,
            'roles' => $roles,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function store()
    {
        // dd($_POST);
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=modul');
        }

        $errors = $this->validate($_POST, $_FILES);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-modul');
        }

        try {
            $this->model->beginTransaction();

            $gambar = null;

            if (!empty($_FILES['gambar']['name'])) {
                $gambar = $this->uploadGambar($_FILES['gambar']);
            }

            $data = $_POST;
            $data['gambar'] = $gambar;

            // auto urutan berdasarkan parent_slug
            $data['urutan'] = $this->model->getNextUrutan($_POST['parent_slug'] ?? null);

            // target default
            $data['target'] = $_POST['target'] ?? '_self';

            // checkbox
            $data['is_active'] = isset($_POST['is_active']) ? 1 : 0;
            $data['is_global'] = isset($_POST['is_global']) ? 1 : 0;

            $id = $this->model->insert($data);

            if (!$id) {
                throw new Exception("Insert gagal");
            }

            // simpan role
            if (!empty($_POST['role_ids'])) {
                $this->model->syncRoles($id, $_POST['role_ids']);
            }

            // simpan pokja
            if (!empty($_POST['pokja_ids'])) {
                $this->model->syncPokjas($id, $_POST['pokja_ids']);
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'store',
                'entity_type' => 'modul',
                'entity_id' => $id,
                'description' => 'Menambah modul'
            ]);

            $this->flash('success', 'Modul berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'STORE ERROR');

            $this->flash('error', 'Gagal menyimpan modul');
        }

        return $this->redirect('?page=modul');
    }

    public function edit()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        $id = $_GET['id'] ?? null;
        if (!$id || !ctype_digit($id)) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=modul');
        }

        $data = $this->model->getById($id);
        if (!$data) {
            $this->flash('error', 'Data modul tidak ditemukan');
            return $this->redirect('?page=modul');
        }

        $pokja = $this->model->getAllPokja();
        $roles = $this->model->getAllRole();
        $selectedPokja = $this->model->getPokjaIdsByModul($id);
        $selectedRoles = $this->model->getRoleIdsByModul($id);

        $this->view('modul/edit', [
            'data' => $data,
            'pokja' => $pokja,
            'roles' => $roles,
            'selectedPokja' => $selectedPokja,
            'selectedRoles' => $selectedRoles,
            'user' => $this->user,
            'role' => $this->role
        ]);
    }

    public function update()
    {
        $this->auth();

        // dd($_POST);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=modul');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=modul');
        }

        $errors = $this->validate($_POST, $_FILES, true);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-modul&id=' . $_POST['id']);
        }

        try {
            $this->model->beginTransaction();

            $id = (int) $_POST['id'];
            $data = $_POST;

            if (!empty($_FILES['gambar']['name'])) {
                $data['gambar'] = $this->uploadGambar($_FILES['gambar']);
            } else {
                $data['gambar'] = $_POST['gambar_lama'] ?? null;
            }

            // dd($data['gambar']);

            // ambil data lama
            $oldData = $this->model->getById($id);

            if (!$oldData) {
                throw new Exception("Data modul tidak ditemukan");
            }

            // target default
            $data['target'] = $_POST['target'] ?? '_self';

            // checkbox
            $data['is_active'] = isset($_POST['is_active']) ? 1 : 0;
            $data['is_global'] = isset($_POST['is_global']) ? 1 : 0;

            // urutan default = tetap
            $data['urutan'] = $oldData['urutan'];

            // jika parent_slug berubah, ambil urutan baru otomatis
            $oldParent = $oldData['parent_slug'] ?? null;
            $newParent = $_POST['parent_slug'] ?? null;

            if ($oldParent !== $newParent) {
                $data['urutan'] = $this->model->getNextUrutan($newParent);
            }

            if (!$this->model->update($id, $data)) {
                throw new Exception("Update gagal");
            }

            // reset role lalu simpan ulang
            if (method_exists($this->model, 'syncRoles')) {
                $this->model->syncRoles($id, $_POST['role_ids'] ?? []);
            }

            // reset pokja lalu simpan ulang
            if (method_exists($this->model, 'syncPokjas')) {
                $this->model->syncPokjas($id, $_POST['pokja_ids'] ?? []);
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'update',
                'entity_type' => 'modul',
                'entity_id' => $id,
                'description' => 'Mengubah modul'
            ]);

            $this->flash('success', 'Modul berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'UPDATE ERROR');

            $this->flash('error', 'Gagal memperbarui modul');
        }

        return $this->redirect('?page=modul');
    }

    public function delete()
    {
        $this->auth();
        $this->roleOnly(['Superadmin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=modul');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=modul');
        }

        try {
            $this->model->beginTransaction();

            if (!$this->model->delete($_POST['id'])) {
                throw new Exception("Gagal hapus modul");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'modul',
                'entity_id' => $_POST['id'],
                'description' => 'Menghapus modul'
            ]);

            $this->flash('success', 'Modul berhasil dihapus');
        } catch (Throwable $e) {
            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE MODUL ERROR');
            $this->flash('error', 'Gagal menghapus modul');
        }

        return $this->redirect('?page=modul');
    }

    private function validate($post, $files = [], $isEdit = false)
    {
        $errors = [];

        if (empty(trim($post['judul'] ?? ''))) {
            $errors['judul'] = 'Judul wajib diisi';
        }

        if (empty(trim($post['link'] ?? ''))) {
            $errors['link'] = 'Link wajib diisi';
        }

        if (empty($post['target']) || !in_array($post['target'], ['_self', '_blank'])) {
            $errors['target'] = 'Target link wajib dipilih.';
        }

        if (empty($post['parent_slug'])) {
            $errors['parent_slug'] = 'Halaman wajib dipilih.';
        }

        return $errors;
    }

    private function uploadGambar($file)
    {
        if (empty($file['name'])) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Gagal upload gambar.');
        }

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            throw new Exception('Format gambar tidak didukung.');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception('Ukuran gambar maksimal 2MB.');
        }

        $fileName = 'modul_' . time() . '_' . uniqid() . '.' . $ext;
        $uploadPath = __DIR__ . '/../public/assets/img/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Gagal menyimpan gambar.');
        }

        return $fileName;
    }
}
