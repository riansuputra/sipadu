<?php

require_once __DIR__ . '/../core/BaseController.php';

class PegawaiController extends BaseController
{
    private $model;
    private $modelJabatan;

    public function __construct()
    {
        $this->model = $this->model('PegawaiModel');
        $this->modelJabatan = $this->model('PegawaiJabatanModel');
    }

    public function index()
    {
        $this->auth();

        $data = $this->model->getAll();

        foreach ($data as &$dt) {
            $dt['umur'] = umurTahun($dt['tanggal_lahir']) . ' th';
            $dt['status_pensiun'] = statusPensiunSingkat($dt['tanggal_lahir'], 58);
        }
        unset($dt);

        // Statistik status ASN
        $statistikStatusAsn = $this->model->getStatistikStatusAsn();

        // Rata-rata umur pegawai
        $rataRataUmur = $this->model->getRataRataUmur();

        // Tahun filter pensiun (default tahun sekarang)
        $tahunPensiun = $_GET['tahun_pensiun'] ?? date('Y');

        // Daftar pensiun tahunan
        $pensiunTahunan = $this->model->getPensiunTahunan($tahunPensiun);

        // Ringkasan pensiun beberapa tahun ke depan
        $ringkasanPensiun = $this->model->getRingkasanPensiunPerTahun(date('Y'), date('Y'));

        $this->view('pegawai/index', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role,

            'statistikStatusAsn' => $statistikStatusAsn,
            'rataRataUmur' => $rataRataUmur,
            'tahunPensiun' => $tahunPensiun,
            'pensiunTahunan' => $pensiunTahunan,
            'ringkasanPensiun' => $ringkasanPensiun,
        ]);
    }

    public function create()
    {
        $this->auth();

        $jabatan = $this->modelJabatan->getAll();

        $this->view('pegawai/create', [
            'user' => $this->user,
            'role' => $this->role,
            'jabatan' => $jabatan,
        ]);
    }

    public function store()
    {
        $this->auth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=pegawai');
        }

        $errors = $this->validate($_POST, $_FILES);

        // dd($_POST, $_FILES, $errors);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=tambah-pegawai');
        }

        try {

            $this->model->beginTransaction();

            $data = $_POST;
            $data['created_by'] = $this->user['id'];
            $data['pangkat_golongan'] =
                !empty($_POST['pangkat_golongan_pns'])
                ? $_POST['pangkat_golongan_pns']
                : ($_POST['pangkat_golongan_pppk'] ?? null);

            $id = $this->model->insert($data);

            if (!$id) {
                throw new Exception("Insert gagal");
            }

            $this->handleUpload($id, $_FILES);

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'store',
                'entity_type' => 'pegawai',
                'entity_id' => $id,
                'description' => 'Menambah data Pegawai'
            ]);

            $this->flash('success', 'Pegawai berhasil disimpan');
        } catch (Throwable $e) {

            $this->model->rollback();

            $_SESSION['old'] = $_POST;

            if ($e instanceof PDOException && $e->getCode() == 23000) {
                $this->flash('error', 'NIK atau NIP sudah terdaftar');
            } else {
                debug_log($e->getMessage());
                $this->flash('error', 'Terjadi kesalahan sistem');
            }
        }

        return $this->redirect('?page=tambah-pegawai');
    }

    public function show()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $pegawai = $this->model->getById($id);
        $files = $this->model->getFiles($id);

        if (!$pegawai) die("Data pegawai tidak ditemukan");

        // Tentukan usia pensiun berdasarkan pokja
        $usiaPensiun = usiaPensiunPegawai($pegawai['pangkat_golongan']);

        // Ambil info pensiun lengkap
        $infoPensiun = infoPensiunPegawaiDetail($pegawai['tanggal_lahir'], $usiaPensiun);

        $data = [
            'title' => 'Detail Pegawai',
            'pegawai' => $pegawai,
            'usiaPensiun' => $usiaPensiun,
            'infoPensiun' => $infoPensiun,
            'umur' => umurTahun($pegawai['tanggal_lahir']),
            'masaKerja' => masaKerjaPegawai($pegawai['tmt_masuk']),
            'statusPegawai' => statusPegawai($pegawai['tanggal_lahir'], $usiaPensiun),
            'tanggalPensiun' => tanggalPensiunPegawai($pegawai['tanggal_lahir'], $usiaPensiun),
        ];

        $this->view('pegawai/detail', [
            'data' => $data,
            'files' => $files,
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function edit()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $data = $this->model->getById($id);
        $files = $this->model->getFiles($id);
        $jabatan = $this->modelJabatan->getAll();

        // dd($data, $files);

        $this->view('pegawai/edit', [
            'data' => $data,
            'files' => $files,
            'jabatan' => $jabatan,
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function update()
    {
        $this->auth();

        // dd($_POST, $_FILES);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=pegawai');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=pegawai');
        }

        $errors = $this->validate($_POST, $_FILES, true, $_POST['id']);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            return $this->redirect('?page=edit-pegawai&id=' . $_POST['id']);
        }

        try {

            $this->model->beginTransaction();

            $data = $_POST;
            $data['updated_by'] = $this->user['id'];
            $data['pangkat_golongan'] =
                !empty($_POST['pangkat_golongan_pns'])
                ? $_POST['pangkat_golongan_pns']
                : ($_POST['pangkat_golongan_pppk'] ?? null);

            if (!$this->model->update($_POST['id'], $data)) {
                throw new Exception("Update gagal");
            }

            if (!empty($_POST["hapus_file"])) {

                foreach (explode(",", $_POST["hapus_file"]) as $fileId) {

                    if (!ctype_digit($fileId)) continue;

                    if (!$this->model->deleteFileById($fileId)) {
                        throw new Exception("Gagal hapus file");
                    }
                }
            }

            $this->handleUpload($_POST['id'], $_FILES);

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'update',
                'entity_type' => 'pegawai',
                'entity_id' => $data['id'],
                'description' => 'Mengubah data Pegawai'
            ]);

            $_SESSION['user']['foto_profile'] =
                $this->model->getFotoProfile($_SESSION['user']['pegawai_id']);

            $this->flash('success', 'Pegawai berhasil diperbarui');
        } catch (Throwable $e) {

            $this->model->rollback();
            if ($e instanceof PDOException && $e->getCode() == 23000) {
                $this->flash('error', 'NIK atau NIP sudah terdaftar');
            } else {
                debug_log($e->getMessage());
                $this->flash('error', 'Terjadi kesalahan sistem');
            }
        }
        return $this->redirect('?page=pegawai');
    }

    public function delete()
    {
        $this->auth();


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('?page=pegawai');
        }

        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            $this->flash('error', 'ID tidak valid');
            return $this->redirect('?page=pegawai');
        }

        try {

            $this->model->beginTransaction();

            $id = $_POST['id'];


            if (!$this->model->delete($id, $this->user['id'])) {
                throw new Exception("Gagal menghapus data");
            }

            $this->model->commit();

            $this->log([
                'user_id' => $this->user['id'],
                'role_id' => $this->user['role_id'],
                'action' => 'delete',
                'entity_type' => 'pegawai',
                'entity_id' => $id,
                'description' => 'Menghapus data pegawai'
            ]);

            $this->flash('success', 'Pegawai berhasil dihapus');
        } catch (Throwable $e) {

            $this->model->rollback();
            debug_log($e->getMessage(), 'DELETE ERROR');

            $this->flash('error', 'Gagal menghapus data');
        }

        return $this->redirect('?page=pegawai');
    }

    private function validate($data, $files, $isUpdate = false, $id = null)
    {
        $errors = [];

        // ================= WAJIB =================
        if (empty($data['nama'])) {
            $errors['nama'] = 'Nama wajib diisi';
        } elseif (strlen($data['nama']) < 3) {
            $errors['nama'] = 'Nama minimal 3 karakter';
        }

        if (empty($data['tanggal_lahir'])) {
            $errors['tanggal_lahir'] = 'Tanggal lahir wajib diisi';
        } elseif (strtotime($data['tanggal_lahir']) > time()) {
            $errors['tanggal_lahir'] = 'Tanggal lahir tidak valid';
        }

        if (
            empty($data['jenis_kelamin']) ||
            !in_array($data['jenis_kelamin'], ['L', 'P'])
        ) {
            $errors['jenis_kelamin'] = 'Jenis kelamin tidak valid';
        }

        if (empty($data['agama'])) {
            $errors['agama'] = 'Agama wajib diisi';
        }

        if (empty($data['no_telepon'])) {
            $errors['no_telepon'] = 'No. telepon wajib diisi';
        }

        if (empty($data['alamat_domisili'])) {
            $errors['alamat_domisili'] = 'Alamat wajib diisi';
        }

        if (empty($data['jabatan_id'])) {
            $errors['jabatan_id'] = 'Jabatan wajib diisi';
        }

        if ($data['status_asn'] === 'PNS') {

            if (empty($data['pangkat_golongan_pns'])) {
                $errors['pangkat_golongan_pns'] = 'Pangkat golongan wajib diisi';
            }
        } elseif ($data['status_asn'] === 'PPPK') {

            if (empty($data['pangkat_golongan_pppk'])) {
                $errors['pangkat_golongan_pppk'] = 'Pangkat golongan wajib diisi';
            }
        }

        if (!$isUpdate && (!isset($files['file_foto']) || $files['file_foto']['error'] === UPLOAD_ERR_NO_FILE)) {
            $errors['file_foto'] = 'File foto wajib diisi';
        }

        if (!empty($data['status_asn'])) {

            if ($data['status_asn'] === 'PNS') {

                if (empty($data['pangkat_golongan_pns'])) {
                    $errors['pangkat_golongan_pns'] = 'Pangkat golongan wajib diisi';
                }
            } elseif ($data['status_asn'] === 'PPPK') {

                if (empty($data['pangkat_golongan_pppk'])) {
                    $errors['pangkat_golongan_pppk'] = 'Golongan P3K wajib diisi';
                }
            }
        }

        if (empty($data['pendidikan'])) {
            $errors['pendidikan'] = 'Pendidikan wajib diisi';
        }

        if (empty($data['tmt_masuk'])) {
            $errors['tmt_masuk'] = 'Tgl. masuk wajib diisi';
        }

        // ================= NIK =================
        if (!empty($data['nik'])) {
            if (!ctype_digit($data['nik']) || strlen($data['nik']) != 16) {
                $errors['nik'] = 'NIK harus 16 digit angka';
            } elseif ($this->model->existsNik($data['nik'], $isUpdate ? $id : null)) {
                $errors['nik'] = 'NIK sudah digunakan';
            }
        }

        // ================= NIP =================
        if (!empty($data['nip'])) {
            if (!ctype_digit($data['nip']) || strlen($data['nip']) != 18) {
                $errors['nip'] = 'NIP harus 18 digit angka';
            } elseif ($this->model->existsNip($data['nip'], $isUpdate ? $id : null)) {
                $errors['nip'] = 'NIP sudah digunakan';
            }
        }

        // ================= EMAIL =================
        if (
            !empty($data['email']) &&
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $errors['email'] = 'Format email tidak valid';
        }

        // ================= GRADE =================
        if (!empty($data['grade']) && !is_numeric($data['grade'])) {
            $errors['grade'] = 'Grade harus angka';
        }

        // ================= PROYEKSI PENSIUN =================
        if (!empty($data['proyeksi_pensiun'])) {
            if (
                !is_numeric($data['proyeksi_pensiun']) ||
                $data['proyeksi_pensiun'] < date('Y')
            ) {
                $errors['proyeksi_pensiun'] = 'Tahun pensiun tidak valid';
            }
        }

        // ======================================================
        // ================= VALIDASI FILE ======================
        // ======================================================

        $dokumenMap = [
            'file_ktp'             => 'KTP',
            'file_foto'            => 'Foto',
            'file_kk'              => 'KK',
            'file_sk_pengangkatan' => 'SK Pengangkatan',
            'file_sk_spmt'         => 'SK SPMT'
        ];

        $allowedExt  = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedMime = [
            'application/pdf',
            'image/png',
            'image/jpeg'
        ];

        $adaFile = false;

        foreach ($dokumenMap as $input => $label) {

            if (!isset($files[$input])) continue;

            if ($files[$input]['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $adaFile = true;

            if ($files[$input]['error'] !== UPLOAD_ERR_OK) {
                $errors[$input] = "Gagal upload file {$label}";
                continue;
            }

            $name = $files[$input]['name'];
            $size = $files[$input]['size'];
            $type = $files[$input]['type'];

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt)) {
                $errors[$input] = "File {$label} tidak diizinkan";
            }

            if (!in_array($type, $allowedMime)) {
                $errors[$input] = "Tipe file {$label} tidak sesuai";
            }

            if ($size > 2 * 1024 * 1024) {
                $errors[$input] = "File {$label} maksimal 2MB";
            }
        }

        // Untuk STORE wajib minimal 1 file
        if (!$isUpdate && !$adaFile) {
            $errors['file'] = "Minimal upload 1 dokumen";
        }

        return $errors;
    }

    private function handleUpload($pegawaiId, $files)
    {
        $dir = realpath(__DIR__ . '/../uploads') . '/pegawai/';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach ($files as $input => $file) {

            if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Upload gagal: {$input}");
            }

            $nama = $file['name'];
            $tmp  = $file['tmp_name'];
            $size = $file['size'];
            $ext  = strtolower(pathinfo($nama, PATHINFO_EXTENSION));

            $namaBaru = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);
            $path = $dir . $namaBaru;

            if (!move_uploaded_file($tmp, $path)) {
                throw new Exception("Gagal upload {$nama}");
            }

            $this->model->insertFile($pegawaiId, [
                'jenis_dokumen' => $input,
                'nama_file' => $nama,
                'path_file' => 'uploads/pegawai/' . $namaBaru,
                'tipe_file' => $ext,
                'ukuran_file' => $size
            ]);
        }
    }

    public function print()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $pegawai = $this->model->getById($id);
        $files = $this->model->getFiles($id);

        if (!$pegawai) die("Data pegawai tidak ditemukan");

        // Tentukan usia pensiun berdasarkan pokja
        $usiaPensiun = usiaPensiunPegawai($pegawai['pangkat_golongan']);

        // Ambil info pensiun lengkap
        $infoPensiun = infoPensiunPegawaiDetail($pegawai['tanggal_lahir'], $usiaPensiun);

        $data = [
            'title' => 'Print Data Pegawai',
            'pegawai' => $pegawai,
            'usiaPensiun' => $usiaPensiun,
            'infoPensiun' => $infoPensiun,
            'umur' => umurTahun($pegawai['tanggal_lahir']),
            'masaKerja' => masaKerjaPegawai($pegawai['tmt_masuk']),
            'statusPegawai' => statusPegawai($pegawai['tanggal_lahir'], $usiaPensiun),
            'tanggalPensiun' => tanggalPensiunPegawai($pegawai['tanggal_lahir'], $usiaPensiun),
        ];

        $this->view('pegawai/print', [
            'data' => $data,
            'files' => $files,
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function download()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $pegawai = $this->model->getById($id);
        if (!$pegawai) die("Data pegawai tidak ditemukan");

        $files = $this->model->getFiles($id);

        if (empty($files)) {
            die("Tidak ada file yang bisa diunduh");
        }

        // Jenis dokumen yang ingin dimasukkan ke ZIP
        $allowedJenis = [
            'file_kk',
            'file_ktp',
            'file_foto',
            'file_sk_spmt',
            'file_sk_pengangkatan'
        ];

        // Mapping nama file di dalam ZIP
        $namaMap = [
            'file_kk' => 'KK',
            'file_ktp' => 'KTP',
            'file_foto' => 'Foto',
            'file_sk_spmt' => 'SK_SPMT',
            'file_sk_pengangkatan' => 'SK_Pengangkatan'
        ];

        $zip = new ZipArchive();

        // Amankan nama file zip
        $safeNama = preg_replace('/[^A-Za-z0-9_\-]/', '_', $pegawai['nama'] ?? 'pegawai');
        $zipFileName = 'berkas_pegawai_' . $safeNama . '_' . date('Ymd_His') . '.zip';
        $zipFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipFileName;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            die("Gagal membuat file ZIP");
        }

        $jumlahFileMasuk = 0;

        foreach ($files as $file) {
            if (
                empty($file['jenis_dokumen']) ||
                empty($file['path_file']) ||
                !in_array($file['jenis_dokumen'], $allowedJenis)
            ) {
                continue;
            }

            // Ubah path database menjadi path fisik server
            $relativePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file['path_file']);
            $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $relativePath;

            if (!file_exists($fullPath) || !is_file($fullPath)) {
                continue;
            }

            $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
            $namaDalamZip = $namaMap[$file['jenis_dokumen']] ?? $file['jenis_dokumen'];

            if (!empty($extension)) {
                $namaDalamZip .= '.' . $extension;
            }

            $zip->addFile($fullPath, $namaDalamZip);
            $jumlahFileMasuk++;
        }

        $zip->close();

        // Kalau tidak ada file valid
        if ($jumlahFileMasuk === 0) {
            if (file_exists($zipFilePath)) {
                unlink($zipFilePath);
            }

            die("Tidak ada file valid yang bisa diunduh");
        }

        // Download ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
        header('Content-Length: ' . filesize($zipFilePath));
        header('Pragma: no-cache');
        header('Expires: 0');

        readfile($zipFilePath);

        // Hapus file temp setelah didownload
        unlink($zipFilePath);
        exit;
    }

    public function indexPublic()
    {
        $this->auth();

        $data = $this->model->getAll();

        foreach ($data as &$dt) {
            $dt['umur'] = umurTahun($dt['tanggal_lahir']) . ' th';
            $dt['status_pensiun'] = statusPensiunSingkat($dt['tanggal_lahir'], 58);
        }
        unset($dt);
        // Statistik status ASN
        $statistikStatusAsn = $this->model->getStatistikStatusAsn();

        // Rata-rata umur pegawai
        $rataRataUmur = $this->model->getRataRataUmur();

        // Tahun filter pensiun (default tahun sekarang)
        $tahunPensiun = $_GET['tahun_pensiun'] ?? date('Y');

        // Daftar pensiun tahunan
        $pensiunTahunan = $this->model->getPensiunTahunan($tahunPensiun);

        // Ringkasan pensiun beberapa tahun ke depan
        $ringkasanPensiun = $this->model->getRingkasanPensiunPerTahun(date('Y'), date('Y'));

        $this->view('pegawai/publicIndex', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role,

            'statistikStatusAsn' => $statistikStatusAsn,
            'rataRataUmur' => $rataRataUmur,
            'tahunPensiun' => $tahunPensiun,
            'pensiunTahunan' => $pensiunTahunan,
            'ringkasanPensiun' => $ringkasanPensiun,
        ]);
    }

    public function detailPublic()
    {
        $this->auth();

        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak valid");

        $pegawai = $this->model->getById($id);
        $files = $this->model->getFiles($id);

        if (!$pegawai) die("Data pegawai tidak ditemukan");

        // Tentukan usia pensiun berdasarkan pokja
        $usiaPensiun = usiaPensiunPegawai($pegawai['pangkat_golongan']);

        // Ambil info pensiun lengkap
        $infoPensiun = infoPensiunPegawaiDetail($pegawai['tanggal_lahir'], $usiaPensiun);

        $data = [
            'title' => 'Detail Pegawai',
            'pegawai' => $pegawai,
            'usiaPensiun' => $usiaPensiun,
            'infoPensiun' => $infoPensiun,
            'umur' => umurTahun($pegawai['tanggal_lahir']),
            'masaKerja' => masaKerjaPegawai($pegawai['tmt_masuk']),
            'statusPegawai' => statusPegawai($pegawai['tanggal_lahir'], $usiaPensiun),
            'tanggalPensiun' => tanggalPensiunPegawai($pegawai['tanggal_lahir'], $usiaPensiun),
        ];

        $this->view('pegawai/publicDetail', [
            'data' => $data,
            'files' => $files,
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function pensiun()
    {
        $this->auth();

        // Data umum pegawai
        $data = $this->model->getAll();

        foreach ($data as &$dt) {
            $dt['umur'] = umurTahun($dt['tanggal_lahir']) . ' th';
            $dt['status_pensiun'] = statusPensiunSingkat($dt['tanggal_lahir'], 58);
        }
        unset($dt);

        // Statistik umum
        $statistikStatusAsn = $this->model->getStatistikStatusAsn();
        $rataRataUmur = $this->model->getRataRataUmur();

        // ==========================
        // FILTER INFORMASI PENSIUN
        // ==========================
        $tahunMulai = isset($_GET['tahun_mulai']) ? (int) $_GET['tahun_mulai'] : (int) date('Y');
        $tahunSampai = isset($_GET['tahun_sampai']) ? (int) $_GET['tahun_sampai'] : (int) date('Y');

        // Validasi: jika tahun sampai lebih kecil dari mulai
        if ($tahunSampai < $tahunMulai) {
            $tahunSampai = $tahunMulai;
        }

        // Ambil daftar pegawai pensiun berdasarkan rentang tahun
        $daftarPensiun = $this->model->getDaftarPensiun($tahunMulai, $tahunSampai);

        // Ambil ringkasan jumlah pensiun per tahun
        $ringkasanPensiun = $this->model->getRingkasanPensiunPerTahun($tahunMulai, $tahunSampai);

        $this->view('pegawai/pensiun', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role,

            // Statistik umum
            'statistikStatusAsn' => $statistikStatusAsn,
            'rataRataUmur' => $rataRataUmur,

            // Filter pensiun
            'tahunMulai' => $tahunMulai,
            'tahunSampai' => $tahunSampai,

            // Hasil pensiun
            'daftarPensiun' => $daftarPensiun,
            'ringkasanPensiun' => $ringkasanPensiun,
        ]);
    }

    public function pensiunPublic()
    {
        $this->auth();

        // Data umum pegawai
        $data = $this->model->getAll();

        foreach ($data as &$dt) {
            $dt['umur'] = umurTahun($dt['tanggal_lahir']) . ' th';
            $dt['status_pensiun'] = statusPensiunSingkat($dt['tanggal_lahir'], 58);
        }
        unset($dt);

        // Statistik umum
        $statistikStatusAsn = $this->model->getStatistikStatusAsn();
        $rataRataUmur = $this->model->getRataRataUmur();

        // ==========================
        // FILTER INFORMASI PENSIUN
        // ==========================
        $tahunMulai = isset($_GET['tahun_mulai']) ? (int) $_GET['tahun_mulai'] : (int) date('Y');
        $tahunSampai = isset($_GET['tahun_sampai']) ? (int) $_GET['tahun_sampai'] : (int) date('Y');

        // Validasi: jika tahun sampai lebih kecil dari mulai
        if ($tahunSampai < $tahunMulai) {
            $tahunSampai = $tahunMulai;
        }

        // Ambil daftar pegawai pensiun berdasarkan rentang tahun
        $daftarPensiun = $this->model->getDaftarPensiun($tahunMulai, $tahunSampai);

        // Ambil ringkasan jumlah pensiun per tahun
        $ringkasanPensiun = $this->model->getRingkasanPensiunPerTahun($tahunMulai, $tahunSampai);

        $this->view('pegawai/publicPensiun', [
            'data' => $data,
            'user' => $this->user,
            'role' => $this->role,

            // Statistik umum
            'statistikStatusAsn' => $statistikStatusAsn,
            'rataRataUmur' => $rataRataUmur,

            // Filter pensiun
            'tahunMulai' => $tahunMulai,
            'tahunSampai' => $tahunSampai,

            // Hasil pensiun
            'daftarPensiun' => $daftarPensiun,
            'ringkasanPensiun' => $ringkasanPensiun,
        ]);
    }
}
