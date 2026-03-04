<?php

require_once __DIR__ . '/../core/BaseController.php';

class NotifikasiController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('NotifikasiModel');
    }

    // endpoint untuk hitung unread (AJAX)
    public function unreadCount()
    {
        $this->auth();

        header('Content-Type: application/json');

        $total = $this->model->countUnread($this->role);

        echo json_encode(['total' => $total]);
        exit;
    }

    // endpoint ambil list notifikasi (AJAX)
    public function getList()
    {
        $this->auth();


        $data = $this->model->getLatest($this->role);

        echo json_encode($data);
    }

    // tandai sudah dibaca
    public function markAsRead()
    {
        $this->auth();

        $id = $_POST['id'];
        $this->model->markAsRead($id);
    }
}
