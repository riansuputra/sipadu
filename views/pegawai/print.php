<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Biodata Pegawai</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
        }

        .foto {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table td {
            padding: 6px;
        }

        .section {
            margin-top: 25px;
        }

        .section-title {
            font-weight: bold;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .print-btn {
            margin-bottom: 20px;
        }

        @media print {

            .print-btn {
                display: none;
            }

        }
    </style>

</head>

<body>

    <div class="print-btn">
        <button onclick="window.print()">🖨 Cetak</button>
    </div>

    <div class="header">
        <h2>BIODATA PEGAWAI</h2>
    </div>

    <table width="100%">
        <tr>

            <td width="150">
                <img src="<?= $pegawai['foto'] ?>" class="foto">
            </td>

            <td>

                <table class="table">

                    <tr>
                        <td width="200">Nama Lengkap</td>
                        <td>: <?= $pegawai['nama'] ?></td>
                    </tr>

                    <tr>
                        <td>NIP</td>
                        <td>: <?= $pegawai['nip'] ?></td>
                    </tr>

                    <tr>
                        <td>Status ASN</td>
                        <td>: <?= $pegawai['status_asn'] ?></td>
                    </tr>

                    <tr>
                        <td>Jabatan</td>
                        <td>: <?= $pegawai['jabatan'] ?></td>
                    </tr>

                    <tr>
                        <td>Pangkat / Golongan</td>
                        <td>: <?= $pegawai['pangkat'] ?></td>
                    </tr>

                </table>

            </td>

        </tr>
    </table>

    <div class="section">

        <div class="section-title">
            DATA PRIBADI
        </div>

        <table class="table">

            <tr>
                <td width="200">Tempat Lahir</td>
                <td>: <?= $pegawai['tempat_lahir'] ?></td>
            </tr>

            <tr>
                <td>Tanggal Lahir</td>
                <td>: <?= $pegawai['tanggal_lahir'] ?></td>
            </tr>

            <tr>
                <td>Jenis Kelamin</td>
                <td>: <?= $pegawai['jenis_kelamin'] ?></td>
            </tr>

            <tr>
                <td>Agama</td>
                <td>: <?= $pegawai['agama'] ?></td>
            </tr>

            <tr>
                <td>No Telepon</td>
                <td>: <?= $pegawai['no_hp'] ?></td>
            </tr>

            <tr>
                <td>Email</td>
                <td>: <?= $pegawai['email'] ?></td>
            </tr>

            <tr>
                <td>Alamat</td>
                <td>: <?= $pegawai['alamat'] ?></td>
            </tr>

        </table>

    </div>


    <div class="section">

        <div class="section-title">
            DATA KEPEGAWAIAN
        </div>

        <table class="table">

            <tr>
                <td width="200">Pendidikan</td>
                <td>: <?= $pegawai['pendidikan'] ?></td>
            </tr>

            <tr>
                <td>Jurusan</td>
                <td>: <?= $pegawai['jurusan'] ?></td>
            </tr>

            <tr>
                <td>Proyeksi Pensiun</td>
                <td>: <?= $pegawai['proyeksi_pensiun'] ?></td>
            </tr>

        </table>

    </div>


    <div class="section">

        <div class="section-title">
            DOKUMEN PEGAWAI
        </div>

        <table class="table">

            <?php foreach ($files as $f): ?>

                <tr>
                    <td><?= $f['jenis_file'] ?></td>
                    <td>: tersedia</td>
                </tr>

            <?php endforeach; ?>

        </table>

    </div>


</body>

</html>