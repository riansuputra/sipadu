<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Data Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .print-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20mm 15mm;
            box-sizing: border-box;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 13px;
            border-bottom: 1px solid #000;

        }

        .profile-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .profile-left {
            display: table-cell;
            width: 220px;
            vertical-align: top;
            padding-right: 20px;
        }

        .profile-right {
            display: table-cell;
            vertical-align: top;
        }

        .photo-box {
            text-align: center;
        }

        .photo-box img {
            width: 160px;
            height: 210px;
            object-fit: cover;
            border: 1px solid #999;
            padding: 4px;
            background: #fff;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin: 0 0 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
        }

        .section-title2 {
            font-size: 15px;
            font-weight: bold;
            margin: 20px 0 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
        }

        table.info-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.info-table tr td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 13px;
        }

        table.info-table tr td:first-child {
            width: 220px;
        }

        table.info-table tr td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        .footer-sign {
            margin-top: 50px;
            width: 100%;
            text-align: right;
        }

        .footer-sign .ttd {
            display: inline-block;
            text-align: center;
            width: 250px;
        }

        .footer-sign .space-sign {
            height: 80px;
        }

        @media print {
            body {
                margin: 0;
                background: #fff;
            }

            .print-container {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 15mm;
                box-shadow: none;
            }

            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>

<body>

    <?php
    $foto = 'public/assets/img/default-profile.jpg';

    if (!empty($files) && is_array($files)) {
        foreach ($files as $file) {
            if (($file['jenis_dokumen'] ?? '') === 'file_foto' && !empty($file['path_file'])) {
                $foto = $file['path_file'];
                break;
            }
        }
    }
    ?>

    <div class="print-container">

        <div class="header">
            <h2 style="margin-bottom: 5px;">Data Pegawai</h2>
            INFORMASI KEPEGAWAIAN DAN DATA PRIBADI
            <p>SIPADU BPMP PROVINSI BALI</p>
        </div>

        <div class="profile-section">
            <!-- KIRI -->
            <div class="profile-left">
                <div class="photo-box">
                    <img src="<?= url($foto) ?>" alt="Foto Pegawai">
                </div>


            </div>

            <!-- KANAN -->
            <div class="profile-right">

                <div class="section-title">Data Kepegawaian</div>
                <table class="info-table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['nama'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['nip'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><?= htmlspecialchars(($data['pegawai']['status_asn'] ?? '-') === 'PPNPN/OUTSOURCING'
                                ? 'OS'
                                : ($data['pegawai']['status_asn'] ?? '-')) ?> / <?= htmlspecialchars($data['statusPegawai'] ?? 'Aktif') ?></td>
                    </tr>
                    <tr>
                        <td>Pangkat, Gol/Ruang</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['pangkat_golongan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['nama_jabatan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Grade</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['grade'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['pendidikan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['jurusan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>No. SK Pengangkatan</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['nomor_sk_pengangkatan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>No. SK SPMT</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['nomor_sk_spmt'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Masuk</td>
                        <td>:</td>
                        <td><?= !empty($data['pegawai']['tmt_masuk']) ? date('d-m-Y', strtotime($data['pegawai']['tmt_masuk'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td>Masa Kerja</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['masaKerja'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['umur'] ?? '-') ?> th</td>
                    </tr>
                    <tr>
                        <td>Umur Pensiun</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['usiaPensiun'] ?? '-') ?> th</td>
                    </tr>
                    <tr>
                        <td>Proyeksi Pensiun</td>
                        <td>:</td>
                        <td>
                            <?= htmlspecialchars($data['infoPensiun']['text'] ?? '-') ?>
                            <?php if (!empty($data['tanggalPensiun'])): ?>
                                (<?= date('d-m-Y', strtotime($data['tanggalPensiun'])) ?>)
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <div class="section-title2">Data Pribadi</div>
                <table class="info-table">
                    <tr>
                        <td>Tempat, Tgl. Lahir</td>
                        <td>:</td>
                        <td>
                            <?= htmlspecialchars($data['pegawai']['tempat_lahir'] ?? '-') ?>,
                            <?= !empty($data['pegawai']['tanggal_lahir']) ? date('d-m-Y', strtotime($data['pegawai']['tanggal_lahir'])) : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['nik'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <?= ($data['pegawai']['jenis_kelamin'] ?? '-') === 'P'
                                ? 'Perempuan'
                                : (($data['pegawai']['jenis_kelamin'] ?? '-') === 'L' ? 'Laki-laki' : '-') ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['agama'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['no_telepon'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Email</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['email'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= htmlspecialchars($data['pegawai']['alamat_domisili'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    <script>
        window.print();
    </script>

</body>

</html>