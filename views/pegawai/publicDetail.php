<?php

// Judul
$title = "Detail Pegawai";
$bannerTitle = "Detail Pegawai";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";




// Mulai buffer konten
ob_start();
?>


<?php
// $files = [];

// foreach ($files as $f) {
//     $files[$f['jenis_dokumen']] = $f;
// }
// dd($data);
// dd($files);
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

// 🔥 HAPUS SETELAH DIPAKAI
unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">

        <div class="row ">

            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=dashboard') ?>" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=kepegawaian') ?>" class="h3 mb-0">
                                    Kepegawaian
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="<?= url('?page=kepegawaian') ?>" class="h3 mb-0">
                                    Detail Pegawai
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="col-md-4">

                <div class="card">
                    <div class="card-body text-center">

                        <?php
                        $defaultFoto = 'public/assets/img/default-profile.jpg';

                        // jenis file yang boleh didownload
                        $downloadableJenis = [
                            'file_kk',
                            'file_ktp',
                            'file_foto',
                            'file_sk_spmt',
                            'file_sk_pengangkatan'
                        ];

                        // mapping file berdasarkan jenis_dokumen
                        $fileMap = [];
                        $adaFileDownload = false;

                        // default foto
                        $foto = $defaultFoto;

                        if (!empty($files) && is_array($files)) {
                            foreach ($files as $file) {
                                if (!empty($file['jenis_dokumen']) && !empty($file['path_file'])) {
                                    // simpan ke mapping
                                    $fileMap[$file['jenis_dokumen']] = $file;

                                    // cek apakah ada file yang bisa didownload
                                    if (in_array($file['jenis_dokumen'], $downloadableJenis)) {
                                        $adaFileDownload = true;
                                    }
                                }
                            }
                        }

                        // ambil foto profil jika ada
                        if (!empty($fileMap['file_foto']['path_file'])) {
                            $foto = $fileMap['file_foto']['path_file'];
                        }
                        ?>

                        <img
                            src="<?= url($foto) ?>"
                            class="mt-3 mb-3"
                            style="
                                width: 120px;
                                height: 160px;
                                object-fit: cover;
                                border-radius: 6px;
                            ">



                        <h3 class="mb-0 "><u><?= htmlspecialchars($data['pegawai']['nama'] ?? '-') ?></u></h3>
                        <div class="">NIP. <?= htmlspecialchars($data['pegawai']['nip'] ?? '-') ?></div>

                        <div class="mt-3">

                            <span class="badge bg-green-lt"><?= htmlspecialchars($data['statusPegawai'] ?? '-') ?></span>
                            <span class="badge bg-blue-lt">
                                <?= htmlspecialchars(($data['pegawai']['status_asn'] ?? '-') === 'PPNPN/OUTSOURCING' ? 'OS' : ($data['pegawai']['status_asn'] ?? '-')) ?>
                            </span>
                            <span class="badge bg-yellow-lt"><?= htmlspecialchars($data['pegawai']['pangkat_golongan'] ?? '-') ?></span>

                        </div>

                        <div class="mt-4">

                            <a href="<?= url('?page=edit-pegawai&id=' . $data['pegawai']["id"]) ?>" class="btn btn-warning btn-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Edit
                            </a>

                            <a href="<?= url('?page=print-pegawai&id=' . $data['pegawai']["id"]) ?>" class="btn btn-success btn-3 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <path d="M7 15a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2l0 -4" />
                                </svg>
                                Print
                            </a>

                        </div>

                    </div>
                </div>
                <div class="card mt-3 mb-3">

                    <div class="card-header">
                        <h3 class="card-title">Dokumen Pegawai</h3>
                    </div>

                    <div class="card-body pt-0">

                        <table class="table pt-0 pb-0 mb-0">

                            <tr class="p-0">
                                <th class="p-0" style="border-bottom: none;"></th>
                                <th class="p-0 text-center" width="150" style="border-bottom: none;"></th>
                            </tr>


                            <tr>
                                <td>Foto</td>
                                <td style="text-align:end;">
                                    <?php if (!empty($fileMap['file_foto']['path_file'])): ?>

                                        <a href="<?= url($fileMap['file_foto']['path_file']) ?>" class="btn btn-sm btn-icon btn-primary" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                        <a href="<?= url($fileMap['file_foto']['path_file']) ?>" class="btn btn-sm btn-icon btn-success" download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum ada file</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>KK</td>
                                <td style="text-align:end;">
                                    <?php if (!empty($fileMap['file_kk']['path_file'])): ?>

                                        <a href="<?= url($fileMap['file_kk']['path_file']) ?>" class="btn btn-sm btn-icon btn-primary" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                        <a href="<?= url($fileMap['file_kk']['path_file']) ?>" class="btn btn-sm btn-icon btn-success" download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum ada file</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>KTP</td>
                                <td style="text-align:end;">
                                    <?php if (!empty($fileMap['file_ktp']['path_file'])): ?>

                                        <a href="<?= url($fileMap['file_ktp']['path_file']) ?>" class="btn btn-sm btn-icon btn-primary" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                        <a href="<?= url($fileMap['file_ktp']['path_file']) ?>" class="btn btn-sm btn-icon btn-success" download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum ada file</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>SK. SPMT</td>
                                <td style="text-align:end;">
                                    <?php if (!empty($fileMap['file_sk_spmt']['path_file'])): ?>

                                        <a href="<?= url($fileMap['file_sk_spmt']['path_file']) ?>" class="btn btn-sm btn-icon btn-primary" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                        <a href="<?= url($fileMap['file_sk_spmt']['path_file']) ?>" class="btn btn-sm btn-icon btn-success" download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum ada file</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-bottom: none;">SK. Pengangkatan</td>
                                <td style="text-align:end; border-bottom: none;">
                                    <?php if (!empty($fileMap['file_sk_pengangkatan']['path_file'])): ?>

                                        <a href="<?= url($fileMap['file_sk_pengangkatan']['path_file']) ?>" class="btn btn-sm btn-icon btn-primary" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                        <a href="<?= url($fileMap['file_sk_pengangkatan']['path_file']) ?>" class="btn btn-sm btn-icon btn-success" download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum ada file</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        </table>

                        <div class="mt-2">
                            <?php if ($adaFileDownload): ?>
                                <a href="<?= url('?page=download-pegawai&id=' . $data['pegawai']['id']) ?>" class="btn btn-primary btn-3 w-100"> Download Semua </a>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Data Kepegawaian</h3>
                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr class="p-0">
                                <td class="p-0" width="200">Jabatan</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['nama_jabatan'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Grade</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['grade'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Pendidikan</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['pendidikan'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Jurusan</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['jurusan'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">No. SK Pengangkatan</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['nomor_sk_pengangkatan'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">No. SK SPMT</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['nomor_sk_spmt'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Tgl. Masuk</td>
                                <td class="p-0">: <?= !empty($data['pegawai']['tmt_masuk']) ? date('d-m-Y', strtotime($data['pegawai']['tmt_masuk'])) : '-' ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Masa Kerja</td>
                                <td class="p-0">: <?= htmlspecialchars($data['masaKerja'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Umur</td>
                                <td class="p-0">: <?= htmlspecialchars($data['umur'] ?? '-') ?> th</td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Umur Pensiun</td>
                                <td class="p-0">: <?= htmlspecialchars($data['usiaPensiun'] ?? '-') ?> th</td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Proyeksi Pensiun</td>
                                <td class="p-0">: <span class="badge w-auto bg-<?= $data['infoPensiun']['badge'] ?>">
                                        <?= $data['infoPensiun']['text'] ?>
                                    </span>
                                    <span class="badge bg-secondary">
                                        <?= !empty($data['tanggalPensiun']) ? date('d-m-Y', strtotime($data['tanggalPensiun'])) : '-' ?>
                                    </span>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
                <div class="card mt-3">

                    <div class="card-header">
                        <h3 class="card-title">Data Pribadi</h3>
                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr class="p-0">
                                <td class="p-0" width="200">Tempat, Tgl. Lahir</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['tempat_lahir'] ?? '-') ?>, <?= !empty($data['pegawai']['tanggal_lahir']) ? date('d-m-Y', strtotime($data['pegawai']['tanggal_lahir'])) : '-' ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">NIK</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['nik'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Jenis Kelamin</td>
                                <td class="p-0">
                                    : <?= ($data['pegawai']['jenis_kelamin'] ?? '-') === 'P'
                                            ? 'Perempuan'
                                            : (($data['pegawai']['jenis_kelamin'] ?? '-') === 'L' ? 'Laki-laki' : '-') ?>
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Agama</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['agama'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">No. Telepon</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['no_telepon'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Alamat Email</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['email'] ?? '-') ?></td>
                            </tr>
                            <tr class="p-0">
                                <td class="p-0" width="200">Alamat</td>
                                <td class="p-0">: <?= htmlspecialchars($data['pegawai']['alamat_domisili'] ?? '-') ?></td>
                            </tr>

                        </table>

                    </div>

                </div>



            </div>
        </div>
    </div>
</div>

<script>
    let dt = new DataTransfer(); // ← kunci utama

    const inputFile = document.getElementById('file');
    const previewCard = document.getElementById('preview-card');
    const previewList = document.getElementById('preview-list');

    inputFile.addEventListener('change', function(e) {

        // Tambahkan file ke DataTransfer
        for (let file of e.target.files) {
            dt.items.add(file);
        }

        // Update input file
        inputFile.files = dt.files;

        renderPreview();
    });

    // ==========================
    // FUNGSI RENDER PREVIEW
    // ==========================
    function renderPreview() {

        previewList.innerHTML = '';

        if (dt.files.length === 0) {
            previewCard.style.display = 'none';
            return;
        }

        previewCard.style.display = 'block';

        Array.from(dt.files).forEach((file, index) => {

            const url = URL.createObjectURL(file);
            const ext = file.name.split('.').pop().toLowerCase();

            let previewElement = '';

            if (['jpg', 'jpeg', 'png'].includes(ext)) {

                previewElement = `
                <img src="${url}"
                     style="max-width:100%; height:auto;" />
            `;

            } else if (ext === 'pdf') {

                previewElement = `
                <iframe src="${url}"
                        style="width:100%; height:350px;">
                </iframe>
            `;

            } else {

                previewElement = `
                <div class="alert alert-warning">
                    Tidak dapat preview file ini
                </div>
            `;
            }

            previewList.innerHTML += `
            <div class="border rounded p-2 mb-3">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>${file.name}</strong>
                        <br>
                        <small>${(file.size / 1024).toFixed(2)} KB</small>
                    </div>

                    <button type="button"
                            class="btn btn-danger btn-sm"
                            onclick="hapusFile(${index})">
                        Hapus
                    </button>
                </div>

                ${previewElement}

            </div>
        `;
        });
    }

    // ==========================
    // FUNGSI HAPUS FILE
    // ==========================
    function hapusFile(index) {

        let newDt = new DataTransfer();

        Array.from(dt.files).forEach((file, i) => {
            if (i !== index) {
                newDt.items.add(file);
            }
        });

        dt = newDt;

        // Update input asli
        inputFile.files = dt.files;

        renderPreview();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const spinner = document.getElementById("spinner");
        const pageContent = document.getElementById("page-content");

        window.addEventListener("load", function() {
            spinner.style.display = "none";
            pageContent.style.display = "block";
        });
    });
</script>

<?php if (isset($_SESSION['flash'])): ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let status = <?= json_encode($_SESSION['flash']['status']) ?>;
            let message = <?= json_encode($_SESSION['flash']['message']) ?>;

            if (status === 'success') {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                    timer: 1000,
                    showConfirmButton: false,
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    timer: 1500,
                    html: message
                });

            }

        });
    </script>

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
                document.getElementById('previewFoto').style.display = 'block';
                document.getElementById('textPlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const statusASN = document.getElementById("status_asn");
        const nip = document.getElementById("nip");
        const grade = document.getElementById("grade");

        const pangkatPNS = document.getElementById("pangkat_golongan_pns");
        const pangkatPPPK = document.getElementById("pangkat_golongan_pppk");

        function handleStatusASN(val) {

            // reset disable
            nip.disabled = false;
            grade.disabled = false;

            pangkatPNS.disabled = false;
            pangkatPPPK.disabled = false;

            if (val === "PNS") {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

            } else if (val === "PPPK") {

                pangkatPNS.style.display = "none";
                pangkatPPPK.style.display = "block";

            } else if (val === "PPNPN/OUTSOURCING") {

                pangkatPNS.style.display = "block";
                pangkatPPPK.style.display = "none";

                nip.disabled = true;
                grade.disabled = true;

                // RESET VALUE
                pangkatPNS.value = "";
                pangkatPPPK.value = "";

                pangkatPNS.disabled = true;
                pangkatPPPK.disabled = true;

            } else {

                pangkatPNS.style.display = "none";
                pangkatPPPK.style.display = "none";

                pangkatPNS.value = "";
                pangkatPPPK.value = "";
            }
        }

        // saat user ganti status
        statusASN.addEventListener("change", function() {
            handleStatusASN(this.value);
        });

        // saat halaman pertama kali load (untuk old value)
        handleStatusASN(statusASN.value);

    });
</script>

<script>
    function previewImage(input) {

        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {

            const img = document.getElementById('previewFoto');
            const text = document.getElementById('textPlaceholder');

            img.src = e.target.result;
            img.style.display = 'block';

            text.style.display = 'none';
        }

        reader.readAsDataURL(file);
    }
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
