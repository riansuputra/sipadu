<?php

require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../models/PegawaiModel.php';

class PegawaiController
{
    // ----------------------------
    // HALAMAN LIST PEGAWAI
    // ----------------------------
    public function index()
    {
        // Cek login
        authOnly();

        global $pdo;

        $pegawaiModel = new PegawaiModel($pdo);
        $pegawai = $pegawaiModel->getAll();

        require __DIR__ . '/../views/pegawai/index.php';
    }

    // ----------------------------
    // HALAMAN TAMBAH PEGAWAI
    // ----------------------------
    public function create()
    {
        authOnly();

        require __DIR__ . '/../views/pegawai/create.php';
    }
}
