<?php
require_once __DIR__ . '/../models/PegawaiModel.php';

class PegawaiController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new PegawaiModel($pdo);
    }

    public function index()
    {
        // ambil semua pegawai aktif
        $pegawai = $this->model->getAll();

        // kirim ke view
        require __DIR__ . '/../views/modules/kepegawaian.php';
    }
}
