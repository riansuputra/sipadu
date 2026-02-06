<!DOCTYPE html>
<html>

<head>
    <title>Cetak DIP</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        .kop img {
            width: 100%;
            max-height: 120px;
            object-fit: contain;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .jenis-title {
            margin-top: 30px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- KOP SURAT -->
    <div class="kop">
        <img src="<?= BASE_URL ?>/public/images/kop.png" alt="Kop Surat">
    </div>

    <div class="judul">
        DAFTAR INFORMASI PUBLIK<br>
        <?php if (!empty($_GET['tahun'])): ?>
            TAHUN <?= htmlspecialchars($_GET['tahun']) ?>
        <?php endif; ?>
    </div>

    <?php foreach ($grouped as $jenis => $rows): ?>
        <div class="jenis-title">
            Jenis Informasi: <?= htmlspecialchars($jenis) ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama Informasi</th>
                    <th width="20%">Unit Penyedia</th>
                    <th width="20%">Penanggung Jawab</th>
                    <th width="10%">Tahun</th>
                    <th width="20%">Bentuk Informasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $i => $d): ?>
                    <tr>
                        <td align="center"><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($d['nama_informasi']) ?></td>
                        <td><?= htmlspecialchars($d['unit_penyedia']) ?></td>
                        <td><?= htmlspecialchars($d['penanggung_jawab']) ?></td>
                        <td align="center"><?= $d['tahun_pembuatan'] ?></td>
                        <td><?= htmlspecialchars($d['bentuk_informasi']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

</body>

</html>