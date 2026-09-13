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

        $data = $this->model->getLatest(
            $this->user['id']
        );

        // Pokja / akses yang sedang aktif
        $currentPokja = $this->user['pokja_id'] ?? null;

        // Cari role dari akses yang sedang aktif
        $activeRole = null;

        if ($currentPokja) {
            $activeRole = $this->model->getActiveRole(
                $this->user['id'],
                $currentPokja
            );
        }

        foreach ($data as &$item) {

            if (
                $item['type'] === 'arsip_peserta'
                && !empty($item['ref_id'])
            ) {

                $arsipId = (int)$item['ref_id'];

                // Staff
                if ($activeRole === 'Staff') {

                    $item['url'] =
                        '?page=detail-arsip-saya&id=' .
                        $arsipId;

                    // Admin / Superadmin / Pimpinan
                } elseif (in_array(
                    $activeRole,
                    ['Admin', 'Superadmin', 'Pimpinan'],
                    true
                )) {

                    $item['url'] =
                        '?page=admin-detail-arsip-saya&id=' .
                        $arsipId;
                }
            }
        }

        unset($item);

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
