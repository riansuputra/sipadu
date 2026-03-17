<?php

// Judul
$title = "Edit Pegawai";





// Mulai buffer konten
ob_start();
?>


<?php
// $files = [];

// foreach ($files as $f) {
//     $files[$f['jenis_dokumen']] = $f;
// }
// dd($files);
// echo '<pre>';
// print_r($user);  
// echo '</pre>';
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];

// 🔥 HAPUS SETELAH DIPAKAI
unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Pegawai</div>
                <h2 class="page-title">Edit Pegawai</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">

            <div class="col-12">
                <form class="card" method="POST" action="<?= url('?page=pegawai-update&id' . $data['id']) ?>" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Pegawai</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div>
                                    <h4>Data Pribadi</h4>
                                </div>
                                <div class="form-fieldset">

                                    <div class="mb-3 row">
                                        <div class="col-lg-auto col-sm-12 me-3">
                                            <?php
                                            $dokumen = [];

                                            foreach ($files as $f) {
                                                $dokumen[$f['jenis_dokumen']] = $f;
                                            }

                                            $fotoPath = $dokumen['file_foto']['path_file'] ?? null;
                                            $kkPath = $dokumen['file_kk']['path_file'] ?? null;
                                            $ktpPath = $dokumen['file_ktp']['path_file'] ?? null;
                                            $skPath = $dokumen['file_sk_pengangkatan']['path_file'] ?? null;
                                            $spmtPath = $dokumen['file_sk_spmt']['path_file'] ?? null;
                                            ?>

                                            <div
                                                onclick="document.getElementById('file_foto').click()"
                                                class="<?= isset($errors['file_foto']) ? 'border-danger' : '' ?>"
                                                style="
                                                width:110px;
                                                height:146px;
                                                border:1px dashed #aaa;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                cursor:pointer;
                                                position:relative;
                                                background:#f9f9f9;
                                            ">
                                                <span
                                                    id="textPlaceholder"
                                                    style="
                                                    color:#666;
                                                    font-size:13px;
                                                    text-align:center;
                                                    <?= $fotoPath ? 'display:none;' : '' ?>
                                                ">
                                                    Klik untuk<br>menambahkan foto
                                                </span>

                                                <img
                                                    id="previewFoto"
                                                    src="<?= $fotoPath ? url($fotoPath) : '' ?>"
                                                    style="<?= $fotoPath ? 'display:block;' : 'display:none;' ?>width:100%;height:100%;object-fit:cover;position:absolute;top:0;left:0;">
                                                <?php if ($fotoPath): ?>
                                                    <a
                                                        href="<?= url($fotoPath) ?>"
                                                        class="btn btn-sm"
                                                        download
                                                        onclick="event.stopPropagation()"
                                                        style="
                                                            position:absolute;
                                                            bottom:5px;
                                                            right:5px;
                                                            background:rgba(0, 255, 0, 1);
                                                            color:white;
                                                            padding:4px 6px;
                                                            border-radius:4px;
                                                            font-size:12px;
                                                            text-decoration:none;
                                                        ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-sm m-0 p-0 text-black icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <input
                                                type="file"
                                                id="file_foto"
                                                name="file_foto"
                                                accept="image/*"
                                                hidden
                                                onchange="previewImage(this)">
                                            <?php if (isset($errors['file_foto'])) : ?>
                                                <div class="invalid-feedback d-block">
                                                    <?= $errors['file_foto'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col">
                                            <label class="form-label required">Nama Lengkap</label>
                                            <input
                                                type="text"
                                                name="nama"
                                                id="nama"
                                                placeholder="Nama lengkap..."
                                                value="<?= $data['nama'] ?? $old['nama'] ?? '' ?>"
                                                class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                            <div class="invalid-feedback">
                                                <?= $errors['nama'] ?? '' ?>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <label class="form-label">Tempat Lahir</label>
                                                    <input
                                                        type="text"
                                                        name="tempat_lahir"
                                                        id="tempat_lahir"
                                                        placeholder="Tempat lahir..."
                                                        value="<?= $data['tempat_lahir'] ?? $old['tempat_lahir'] ?? '' ?>"
                                                        class="form-control <?= isset($errors['tempat_lahir']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                                    <div class="invalid-feedback">
                                                        <?= $errors['tempat_lahir'] ?? '' ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label required">Tanggal Lahir</label>
                                                    <input
                                                        type="date"
                                                        name="tanggal_lahir"
                                                        id="tanggal_lahir"
                                                        value="<?= $data['tanggal_lahir'] ?? $old['tanggal_lahir'] ?? '' ?>"
                                                        class="form-control <?= isset($errors['tanggal_lahir']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                                    <div class="invalid-feedback">
                                                        <?= $errors['tanggal_lahir'] ?? '' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input
                                            type="text"
                                            name="nik"
                                            id="nik"
                                            placeholder="NIK..."
                                            value="<?= $data['nik'] ?? $old['nik'] ?? '' ?>"
                                            class="form-control <?= isset($errors['nik']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                        <div class="invalid-feedback">
                                            <?= $errors['nik'] ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Jenis Kelamin</label>
                                                    <select class="form-select <?= isset($errors['jenis_kelamin']) ? 'is-invalid' : '' ?>" name="jenis_kelamin" id="jenis_kelamin">
                                                        <option value="" disabled <?= empty($data['jenis_kelamin']) ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                                                        <option value="L" <?= ($data['jenis_kelamin'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                                                        <option value="P" <?= ($data['jenis_kelamin'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['jenis_kelamin'] ?? '' ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label required">Agama</label>
                                                    <select class="form-select <?= isset($errors['agama']) ? 'is-invalid' : '' ?>" name="agama" id="agama">
                                                        <option value="" disabled <?= empty($data['agama']) ? 'selected' : '' ?>>-- Pilih Agama --</option>
                                                        <option value="Islam" <?= ($data['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                                        <option value="Kristen Protestan" <?= ($data['agama'] ?? '') == 'Kristen Protestan' ? 'selected' : '' ?>>Kristen Protestan</option>
                                                        <option value="Katolik" <?= ($data['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                                        <option value="Hindu" <?= ($data['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                                        <option value="Buddha" <?= ($data['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                                        <option value="Konghucu" <?= ($data['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['agama'] ?? '' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">No. Telepon</label>
                                                    <input
                                                        type="text"
                                                        name="no_telepon"
                                                        id="no_telepon"
                                                        placeholder="No. Telepon..."
                                                        value="<?= $data['no_telepon'] ?? $old['no_telepon'] ?? '' ?>"
                                                        class="form-control <?= isset($errors['no_telepon']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                                    <div class="invalid-feedback">
                                                        <?= $errors['no_telepon'] ?? '' ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Alamat Email</label>
                                                    <input
                                                        type="email"
                                                        name="email"
                                                        id="email"
                                                        placeholder="Alamat email..."
                                                        value="<?= $data['email'] ?? $old['email'] ?? '' ?>"
                                                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                                    <div class="invalid-feedback">
                                                        <?= $errors['email'] ?? '' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Alamat</label>
                                        <input
                                            type="alamat_domisili"
                                            name="alamat_domisili"
                                            id="alamat_domisili"
                                            placeholder="Alamat..."
                                            value="<?= $data['alamat_domisili'] ?? $old['alamat_domisili'] ?? '' ?>"
                                            class="form-control <?= isset($errors['alamat_domisili']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                        <div class="invalid-feedback">
                                            <?= $errors['alamat_domisili'] ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File KK</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="file" class="form-control <?= isset($errors['file_kk']) ? 'is-invalid' : '' ?>" name="file_kk" id="file_kk" accept=".pdf, .jpg, .png">
                                                <small class="form-hint">
                                                    Format: pdf maks 5MB
                                                </small>
                                                <div class="invalid-feedback">
                                                    <?= $errors['file_kk'] ?? '' ?>
                                                </div>
                                            </div>
                                            <?php if ($kkPath) : ?>
                                                <div class="col-auto">
                                                    <a href="<?= url($kkPath) ?>" download class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File KTP</label>
                                        <div class="row g-2">

                                            <div class="col">
                                                <input type="file" class="form-control <?= isset($errors['file_ktp']) ? 'is-invalid' : '' ?>" name="file_ktp" id="file_ktp" accept=".pdf, .jpg, .png">
                                                <small class="form-hint">
                                                    Format: pdf maks 5MB
                                                </small>
                                                <div class="invalid-feedback">
                                                    <?= $errors['file_ktp'] ?? '' ?>
                                                </div>
                                            </div>
                                            <?php if ($ktpPath) : ?>
                                                <div class="col-auto">
                                                    <a href="<?= url($ktpPath) ?>" download class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div>
                                    <h4>Data Kepegawaian</h4>
                                </div>
                                <div class="form-fieldset">
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Status ASN</label>
                                                    <select class="form-select <?= isset($errors['status_asn']) ? 'is-invalid' : '' ?>" name="status_asn" id="status_asn">
                                                        <option value="" disabled <?= empty($data['status_asn']) ? 'selected' : '' ?>>-- Pilih Status --</option>
                                                        <option value="PNS" <?= ($data['status_asn'] ?? '') == 'PNS' ? 'selected' : '' ?>>PNS</option>
                                                        <option value="PPPK" <?= ($data['status_asn'] ?? '') == 'PPPK' ? 'selected' : '' ?>>PPPK</option>
                                                        <option value="PPNPN/OUTSOURCING" <?= ($data['status_asn'] ?? '') == 'PPNPN/OUTSOURCING' ? 'selected' : '' ?>>PPNPN/Outsourcing</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['status_asn'] ?? '' ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">NIP / NIPPPK</label>
                                                    <input
                                                        type="text"
                                                        name="nip"
                                                        id="nip"
                                                        placeholder="NIP/NIPPPK..."
                                                        value="<?= $data['nip'] ?? $old['nip'] ?? '' ?>"
                                                        class="form-control <?= isset($errors['nip']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                                    <div class="invalid-feedback">
                                                        <?= $errors['nip'] ?? '' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Pendidikan</label>
                                                    <select class="form-select <?= isset($errors['pendidikan']) ? 'is-invalid' : '' ?>" name="pendidikan" id="pendidikan">
                                                        <option value="" disabled <?= empty($data['pendidikan']) ? 'selected' : '' ?>>-- Pilih Pendidikan --</option>
                                                        <option value="S3" <?= ($data['pendidikan'] ?? '') == 'S3' ? 'selected' : '' ?>>S3</option>
                                                        <option value="S2" <?= ($data['pendidikan'] ?? '') == 'S2' ? 'selected' : '' ?>>S2</option>
                                                        <option value="S1" <?= ($data['pendidikan'] ?? '') == 'S1' ? 'selected' : '' ?>>S1</option>
                                                        <option value="SMA" <?= ($data['pendidikan'] ?? '') == 'SMA' ? 'selected' : '' ?>>SMA</option>
                                                        <option value="SMP" <?= ($data['pendidikan'] ?? '') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['pendidikan'] ?? '' ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Jurusan</label>
                                                    <input
                                                        type="text"
                                                        name="jurusan"
                                                        id="jurusan"
                                                        placeholder="Jurusan..."
                                                        value="<?= $data['jurusan'] ?? $old['jurusan'] ?? '' ?>"
                                                        class="form-control <?= isset($errors['jurusan']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                                    <div class="invalid-feedback">
                                                        <?= $errors['jurusan'] ?? '' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <?php
                                        $pangkat = $data['pangkat_golongan'] ?? '';
                                        ?>
                                        <label class="form-label">Pangkat, Gol/Ruang</label>
                                        <select class="form-select <?= isset($errors['pangkat_golongan_pns']) ? 'is-invalid' : '' ?>" name="pangkat_golongan_pns" id="pangkat_golongan_pns" style="<?= ($data['status_asn'] ?? '') == 'PPPK' ? 'display:block' : 'display:none' ?>">
                                            <option value="" disabled <?= empty($pangkat) ? 'selected' : '' ?>>-- Pilih Pangkat/Gol, Ruang --</option>
                                            <option value="Juru Muda, I/a" <?= ($pangkat ?? '') == 'Juru Muda, I/a' ? 'selected' : '' ?>>Juru Muda, I/a</option>
                                            <option value="Juru Muda Tingkat I, I/a" <?= ($pangkat ?? '') == 'Juru Muda Tingkat I, I/a' ? 'selected' : '' ?>>Juru Muda Tingkat I, I/a</option>
                                            <option value="Juru, I/c" <?= ($pangkat ?? '') == 'Juru, I/c' ? 'selected' : '' ?>>Juru, I/c</option>
                                            <option value="Juru Tingkat I, I/d" <?= ($pangkat ?? '') == 'Juru Tingkat I, I/d' ? 'selected' : '' ?>>Juru Tingkat I, I/d</option>
                                            <option value="Pengatur Muda, II/a" <?= ($pangkat ?? '') == 'Pengatur Muda, II/a' ? 'selected' : '' ?>>Pengatur Muda, II/a</option>
                                            <option value="Pengatur Muda Tingkat I, II/b" <?= ($pangkat ?? '') == 'Pengatur Muda Tingkat I, II/b' ? 'selected' : '' ?>>Pengatur Muda Tingkat I, II/b</option>
                                            <option value="Pengatur Muda, II/c" <?= ($pangkat ?? '') == 'Pengatur Muda, II/c' ? 'selected' : '' ?>>Pengatur Muda, II/c</option>
                                            <option value="Pengatur Muda, II/d" <?= ($pangkat ?? '') == 'Pengatur Muda, II/d' ? 'selected' : '' ?>>Pengatur Muda, II/d</option>
                                            <option value="Penata Muda, III/a" <?= ($pangkat ?? '') == 'Penata Muda, III/a' ? 'selected' : '' ?>>Penata Muda, III/a</option>
                                            <option value="Penata Muda Tingkat I, III/b" <?= ($pangkat ?? '') == 'Penata Muda Tingkat I, III/b' ? 'selected' : '' ?>>Penata Muda Tingkat I, III/b</option>
                                            <option value="Penata, III/c" <?= ($pangkat ?? '') == 'Penata, III/c' ? 'selected' : '' ?>>Penata, III/c</option>
                                            <option value="Penata Tingkat I, III/d" <?= ($pangkat ?? '') == 'Penata Tingkat I, III/d' ? 'selected' : '' ?>>Penata Tingkat I, III/d</option>
                                            <option value="Pembina, IV/a" <?= ($pangkat ?? '') == 'Pembina, IV/a' ? 'selected' : '' ?>>Pembina, IV/a</option>
                                            <option value="Pembina Tingkat I, IV/b" <?= ($pangkat ?? '') == 'Pembina Tingkat I, IV/b' ? 'selected' : '' ?>>Pembina Tingkat I, IV/b</option>
                                            <option value="Pembina Utama Muda, IV/c" <?= ($pangkat ?? '') == 'Pembina Utama Muda, IV/c' ? 'selected' : '' ?>>Pembina Utama Muda, IV/c</option>
                                            <option value="Pembina Utama Madya, IV/d" <?= ($pangkat ?? '') == 'Pembina Utama Madya, IV/d' ? 'selected' : '' ?>>Pembina Utama Madya, IV/d</option>
                                            <option value="Pembina Utama, IV/e" <?= ($pangkat ?? '') == 'Pembina Utama, IV/e' ? 'selected' : '' ?>>Pembina Utama, IV/e</option>
                                        </select>
                                        <select class="form-select <?= isset($errors['pangkat_golongan_pppk']) ? 'is-invalid' : '' ?>" name="pangkat_golongan_pppk" id="pangkat_golongan_pppk" style="<?= ($data['status_asn'] ?? '') == 'PPPK' ? 'display:block' : 'display:none' ?>">
                                            <option value="" disabled <?= empty($pangkat) ? 'selected' : '' ?>>-- Pilih Golongan P3K --</option>
                                            <option value="P3K/V" <?= ($pangkat ?? '') == 'P3K/V' ? 'selected' : '' ?>>P3K/V</option>
                                            <option value="P3K/VI" <?= ($pangkat ?? '') == 'P3K/VI' ? 'selected' : '' ?>>P3K/VI</option>
                                            <option value="P3K/VII" <?= ($pangkat ?? '') == 'P3K/VII' ? 'selected' : '' ?>>P3K/VII</option>
                                            <option value="P3K/VIII" <?= ($pangkat ?? '') == 'P3K/VIII' ? 'selected' : '' ?>>P3K/VIII</option>
                                            <option value="P3K/IX" <?= ($pangkat ?? '') == 'P3K/IX' ? 'selected' : '' ?>>P3K/IX</option>
                                            <option value="P3K/X" <?= ($pangkat ?? '') == 'P3K/X' ? 'selected' : '' ?>>P3K/X</option>
                                            <option value="P3K/XI" <?= ($pangkat ?? '') == 'P3K/XI' ? 'selected' : '' ?>>P3K/XI</option>
                                            <option value="P3K/XII" <?= ($pangkat ?? '') == 'P3K/XII' ? 'selected' : '' ?>>P3K/XII</option>
                                            <option value="P3K/XIII" <?= ($pangkat ?? '') == 'P3K/XIII' ? 'selected' : '' ?>>P3K/XIII</option>
                                            <option value="P3K/XIV" <?= ($pangkat ?? '') == 'P3K/XIV' ? 'selected' : '' ?>>P3K/XIV</option>
                                            <option value="P3K/XV" <?= ($pangkat ?? '') == 'P3K/XV' ? 'selected' : '' ?>>P3K/XV</option>
                                            <option value="P3K/XVI" <?= ($pangkat ?? '') == 'P3K/XVI' ? 'selected' : '' ?>>P3K/XVI</option>
                                            <option value="P3K/XVII" <?= ($pangkat ?? '') == 'P3K/XVII' ? 'selected' : '' ?>>P3K/XVII</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $errors['pangkat_golongan_pns']
                                                ?? $errors['pangkat_golongan_pppk']
                                                ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label required">Jabatan</label>
                                                    <select class="form-select <?= isset($errors['jabatan']) ? 'is-invalid' : '' ?>" name="jabatan" id="jabatan" placehdataer="-- Pilih Jabatan --" autocomplete="off">
                                                        <option value="" disabled <?= empty($data['jabatan']) ? 'selected' : '' ?>>-- Pilih Jabatan --</option>
                                                        <option value="Analis Kemitraan" <?= ($data['jabatan'] ?? '') == 'Analis Kemitraan' ? 'selected' : '' ?>>Analis Kemitraan</option>
                                                        <option value="Analis Sumber Daya Manusia Aparatur Ahli Pertama" <?= ($data['jabatan'] ?? '') == 'Analis Sumber Daya Manusia Aparatur Ahli Pertama' ? 'selected' : '' ?>>Analis Sumber Daya Manusia Aparatur Ahli Pertama</option>
                                                        <option value="Arsiparis Ahli Pertama" <?= ($data['jabatan'] ?? '') == 'Arsiparis Ahli Pertama' ? 'selected' : '' ?>>Arsiparis Ahli Pertama</option>
                                                        <option value="Arsiparis Mahir" <?= ($data['jabatan'] ?? '') == 'Arsiparis Mahir' ? 'selected' : '' ?>>Arsiparis Mahir</option>
                                                        <option value="Cleaning Service" <?= ($data['jabatan'] ?? '') == 'Cleaning Service' ? 'selected' : '' ?>>Cleaning Service</option>
                                                        <option value="Kepala BPMP Provinsi Bali" <?= ($data['jabatan'] ?? '') == 'Kepala BPMP Provinsi Bali' ? 'selected' : '' ?>>Kepala BPMP Provinsi Bali</option>
                                                        <option value="Kepala Sub Bagian Umum" <?= ($data['jabatan'] ?? '') == 'Kepala Sub Bagian Umum' ? 'selected' : '' ?>>Kepala Sub Bagian Umum</option>
                                                        <option value="Penelaah Informasi dan Komunikasi Publik" <?= ($data['jabatan'] ?? '') == 'Penelaah Informasi dan Komunikasi Publik' ? 'selected' : '' ?>>Penelaah Informasi dan Komunikasi Publik</option>
                                                        <option value="Penelaah Teknis Kebijakan" <?= ($data['jabatan'] ?? '') == 'Penelaah Teknis Kebijakan' ? 'selected' : '' ?>>Penelaah Teknis Kebijakan</option>
                                                        <option value="Pengadministrasi Keuangan" <?= ($data['jabatan'] ?? '') == 'Pengadministrasi Keuangan' ? 'selected' : '' ?>>Pengadministrasi Keuangan</option>
                                                        <option value="Pengadministrasi Perkantoran" <?= ($data['jabatan'] ?? '') == 'Pengadministrasi Perkantoran' ? 'selected' : '' ?>>Pengadministrasi Perkantoran</option>
                                                        <option value="Pengelola Sistem dan Teknologi Informasi" <?= ($data['jabatan'] ?? '') == 'Pengelola Sistem dan Teknologi Informasi' ? 'selected' : '' ?>>Pengelola Sistem dan Teknologi Informasi</option>
                                                        <option value="Pengolah Data dan Informasi" <?= ($data['jabatan'] ?? '') == 'Pengolah Data dan Informasi' ? 'selected' : '' ?>>Pengolah Data dan Informasi</option>
                                                        <option value="Pranata Komputer Ahli Pertama" <?= ($data['jabatan'] ?? '') == 'Pranata Komputer Ahli Pertama' ? 'selected' : '' ?>>Pranata Komputer Ahli Pertama</option>
                                                        <option value="Satpam" <?= ($data['jabatan'] ?? '') == 'Satpam' ? 'selected' : '' ?>>Satpam</option>
                                                        <option value="Sopir" <?= ($data['jabatan'] ?? '') == 'Sopir' ? 'selected' : '' ?>>Sopir</option>
                                                        <option value="Teknisi Sarana dan Prasarana" <?= ($data['jabatan'] ?? '') == 'Teknisi Sarana dan Prasarana' ? 'selected' : '' ?>>Teknisi Sarana dan Prasarana</option>
                                                        <option value="Tenaga Administrasi" <?= ($data['jabatan'] ?? '') == 'Tenaga Administrasi' ? 'selected' : '' ?>>Tenaga Administrasi</option>
                                                        <option value="Tukang Kebun" <?= ($data['jabatan'] ?? '') == 'Tukang Kebun' ? 'selected' : '' ?>>Tukang Kebun</option>
                                                        <option value="Widyaprada Ahli Madya" <?= ($data['jabatan'] ?? '') == 'Widyaprada Ahli Madya' ? 'selected' : '' ?>>Widyaprada Ahli Madya</option>
                                                        <option value="Widyaprada Ahli Muda" <?= ($data['jabatan'] ?? '') == 'Widyaprada Ahli Muda' ? 'selected' : '' ?>>Widyaprada Ahli Muda</option>
                                                        <option value="Widyaprada Ahli Pertama" <?= ($data['jabatan'] ?? '') == 'Widyaprada Ahli Pertama' ? 'selected' : '' ?>>Widyaprada Ahli Pertama</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['jabatan'] ?? '' ?>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label">Grade</label>
                                                    <select class="form-select <?= isset($errors['grade']) ? 'is-invalid' : '' ?>" name="grade" id="grade">
                                                        <option value="" disabled <?= empty($data['grade']) ? 'selected' : '' ?>>Pilih</option>
                                                        <option value="1" <?= ($data['grade'] ?? '') == '1' ? 'selected' : '' ?>>1</option>
                                                        <option value="2" <?= ($data['grade'] ?? '') == '2' ? 'selected' : '' ?>>2</option>
                                                        <option value="3" <?= ($data['grade'] ?? '') == '3' ? 'selected' : '' ?>>3</option>
                                                        <option value="4" <?= ($data['grade'] ?? '') == '4' ? 'selected' : '' ?>>4</option>
                                                        <option value="5" <?= ($data['grade'] ?? '') == '5' ? 'selected' : '' ?>>5</option>
                                                        <option value="6" <?= ($data['grade'] ?? '') == '6' ? 'selected' : '' ?>>6</option>
                                                        <option value="7" <?= ($data['grade'] ?? '') == '7' ? 'selected' : '' ?>>7</option>
                                                        <option value="8" <?= ($data['grade'] ?? '') == '8' ? 'selected' : '' ?>>8</option>
                                                        <option value="9" <?= ($data['grade'] ?? '') == '9' ? 'selected' : '' ?>>9</option>
                                                        <option value="10" <?= ($data['grade'] ?? '') == '10' ? 'selected' : '' ?>>10</option>
                                                        <option value="11" <?= ($data['grade'] ?? '') == '11' ? 'selected' : '' ?>>11</option>
                                                        <option value="12" <?= ($data['grade'] ?? '') == '12' ? 'selected' : '' ?>>12</option>
                                                        <option value="13" <?= ($data['grade'] ?? '') == '13' ? 'selected' : '' ?>>13</option>
                                                        <option value="14" <?= ($data['grade'] ?? '') == '14' ? 'selected' : '' ?>>14</option>
                                                        <option value="15" <?= ($data['grade'] ?? '') == '15' ? 'selected' : '' ?>>15</option>
                                                        <option value="16" <?= ($data['grade'] ?? '') == '16' ? 'selected' : '' ?>>16</option>
                                                        <option value="17" <?= ($data['grade'] ?? '') == '17' ? 'selected' : '' ?>>17</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['grade'] ?? '' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. SK Pengangkatan</label>
                                        <input
                                            type="text"
                                            name="nomor_sk_pengangkatan"
                                            id="nomor_sk_pengangkatan"
                                            placeholder="No. SK Pengangkatan..."
                                            value="<?= $data['nomor_sk_pengangkatan'] ?? $old['nomor_sk_pengangkatan'] ?? '' ?>"
                                            class="form-control <?= isset($errors['nomor_sk_pengangkatan']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                        <div class="invalid-feedback">
                                            <?= $errors['nomor_sk_pengangkatan'] ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. SK SPMT</label>
                                        <input
                                            type="text"
                                            name="nomor_sk_spmt"
                                            id="nomor_sk_spmt"
                                            placeholder="No. SK SPMT..."
                                            value="<?= $data['nomor_sk_spmt'] ?? $old['nomor_sk_spmt'] ?? '' ?>"
                                            class="form-control <?= isset($errors['nomor_sk_spmt']) ? 'is-invalid' : '' ?>" autocomplete="off">
                                        <div class="invalid-feedback">
                                            <?= $errors['nomor_sk_spmt'] ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File SK Pengangkatan</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="file" class="form-control <?= isset($errors['file_sk_pengangkatan']) ? 'is-invalid' : '' ?>" name="file_sk_pengangkatan" id="file_sk_pengangkatan" accept=".pdf, .jpg, .png">
                                                <small class="form-hint">
                                                    Format: pdf maks 5MB
                                                </small>
                                                <div class="invalid-feedback">
                                                    <?= $errors['file_sk_pengangkatan'] ?? '' ?>
                                                </div>
                                            </div>
                                            <?php if ($skPath) : ?>
                                                <div class="col-auto">
                                                    <a href="<?= url($skPath) ?>" download class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File SK SPMT</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="file" class="form-control <?= isset($errors['file_sk_spmt']) ? 'is-invalid' : '' ?>" name="file_sk_spmt" id="file_sk_spmt" accept=".pdf, .jpg, .png">
                                                <small class="form-hint">
                                                    Format: pdf maks 5MB
                                                </small>
                                                <div class="invalid-feedback">
                                                    <?= $errors['file_sk_spmt'] ?? '' ?>
                                                </div>
                                            </div>
                                            <?php if ($spmtPath) : ?>
                                                <div class="col-auto">
                                                    <a href="<?= url($spmtPath) ?>" download class="btn btn-2 btn-icon btn-success" aria-label="Button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" name="id" id="id" value="<?= $data['id'] ?>" hidden>
                        <div class="">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="card" id="preview-card" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Preview File</h3>
                    </div>

                    <div class="card-body">
                        <div id="preview-list"></div>
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
require __DIR__ . '/../layouts/admin.php';
