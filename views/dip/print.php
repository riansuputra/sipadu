<!DOCTYPE html>
<html>

<?php

// echo '<pre>';
// print_r($data);

// echo '</pre>';
?>

<head>
    <meta charset="UTF-8">
    <title>Cetak DIP</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            line-height: 1;
            /* SPASI 1 */
            color: #000;
        }

        .lampiran {
            font-size: 11pt;
        }

        .lampiran p {
            margin: 0 0 4px 0;
        }

        .judul {
            text-align: center;
            font-size: 11pt;
            line-height: 1.15;
            margin-bottom: 10px;

        }

        .judul p {
            margin: 0 0 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: top;
        }

        th {
            font-weight: normal;

            text-align: center;
        }

        .jenis-row td {
            text-align: center;
            background: #ccf9ff;
        }

        .ttd {
            width: 40%;
            margin-left: auto;
            margin-top: 40px;
            text-align: left;
        }

        .no-print {
            margin-bottom: 15px;
        }

        @media print {
            .no-print {
                display: none;
            }

            .jenis-row td {
                background-color: #ccf9ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <!-- =====================
     TOMBOL CETAK
===================== -->
    <div class="no-print">
        <button onclick="window.print()">Cetak</button>
    </div>

    <!-- =====================
     LAMPIRAN (KIRI ATAS)
===================== -->
    <div class="lampiran">
        <p>Lampiran Surat Keputusan</p>
        <p>Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= htmlspecialchars($nomor_surat) ?></p>
        <p>Tanggal &nbsp;&nbsp;&nbsp;: <?= tgl_sekarang($tanggal_surat) ?></p>
        <p>Tentang &nbsp;&nbsp;&nbsp;: <?= htmlspecialchars($tentang) ?></p>
    </div>

    <!-- =====================
     JUDUL
===================== -->
    <div class="judul">
        <p>DAFTAR INFORMASI PUBLIK</p>
        <p>BPMP PROVINSI BALI TAHUN <?= htmlspecialchars($tahun_judul) ?></p>
    </div>

    <!-- =====================
     TABEL DIP
===================== -->
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Informasi</th>
                <th width="15%">Unit Kerja yang Menyediakan</th>
                <th width="15%">Penanggung Jawab Informasi</th>
                <th width="10%">Waktu dan Tempat Pembuatan</th>
                <th width="10%">Bentuk Informasi</th>
                <th width="10%">Jangka Waktu Penyimpanan/Retensi</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($dataGrouped as $jenis => $rows):
            ?>
                <!-- BARIS JENIS -->
                <tr class="jenis-row">
                    <td colspan="7">
                        Informasi <?= htmlspecialchars(ucwords(strtolower($jenis))) ?>
                    </td>
                </tr>

                <?php $no = 1;
                foreach ($rows as $r): ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['nama_informasi']) ?></td>
                        <td><?= htmlspecialchars($r['unit_penyedia']) ?></td>
                        <td><?= htmlspecialchars($r['penanggung_jawab']) ?></td>
                        <td>Tahun <?= $r['tahun_pembuatan'] ?? '-' ?>, <?= $r['tempat_pembuatan'] ?? '-' ?></td>
                        <?php if ($r["bentuk_informasi"] === "HARDCOPY") {
                            $text =
                                'Hardcopy';
                        } elseif ($r["bentuk_informasi"] === "SOFTCOPY") {
                            $text =
                                'Softcopy';
                        } else {
                            $text =
                                'Hardcopy dan Softcopy';
                        }
                        ?>
                        <td>
                            <?= htmlspecialchars($text) ?>
                        </td>
                        <td><?= htmlspecialchars($r['retensi_arsip']) ?></td>
                    </tr>
                <?php endforeach; ?>

            <?php endforeach; ?>

        </tbody>
    </table>

    <!-- =====================
     TTD (KANAN BAWAH, RATA KIRI)
===================== -->
    <div class="ttd">
        <p><?= htmlspecialchars($jabatan_ttd) ?>,</p>
        <br><br><br>
        <p><strong><?= htmlspecialchars($nama_ttd) ?></strong></p>
        <p>NIP. <?= htmlspecialchars($nip_ttd) ?></p>
    </div>

</body>

</html>