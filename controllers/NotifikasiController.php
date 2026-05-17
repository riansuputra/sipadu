<?php

require_once __DIR__ . '/../core/BaseController.php';

class NotifikasiController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('NotifikasiModel');
    }

    public function unreadCount()
    {
        $this->auth();
        header('Content-Type: application/json');

        // generate notif ulang tahun otomatis
        $this->model->generateBirthdayNotif();

        $total = $this->model->countUnread($this->user['id']);

        echo json_encode(['total' => $total]);
        exit;
    }

    public function getList()
    {
        $this->auth();
        header('Content-Type: application/json');

        $data = $this->model->getLatest($this->user['id']);

        echo json_encode($data);
        exit;
    }

    public function markAsRead()
    {
        $this->auth();
        header('Content-Type: application/json');

        $notif_id = $_POST['id'];

        $this->model->markAsRead($notif_id, $this->user['id']);

        echo json_encode(['status' => 'ok']);
        exit;
    }

    public function markAllRead()
    {
        $this->auth();
        header('Content-Type: application/json');

        $this->model->markAllRead($this->user['id']);

        echo json_encode(['status' => 'ok']);
        exit;
    }
}
