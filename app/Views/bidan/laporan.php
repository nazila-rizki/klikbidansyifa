<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Pasien</title>
    <link rel="stylesheet" href="/assets/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .header-report {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-report img {
            width: 80px;
            margin-bottom: 10px;
        }

        .header-report h1 {
            font-size: 24px;
            margin: 5px 0;
        }

        .header-report p {
            margin: 3px 0;
            font-size: 14px;
        }

        .table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f4f6f9;
            font-weight: bold;
        }

        .footer-signature {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
        }

        .footer-signature .signature {
            margin-top: 60px;
        }

        .footer-signature .signature .name {
            border-top: 1px solid #000;
            width: 200px;
            margin: 10px auto 0;
            padding-top: 5px;
        }

        @media print {
            body {
                margin: 20mm;
            }

            .header-report {
                margin-bottom: 10mm;
            }

            .table {
                page-break-inside: avoid;
            }

            .footer-signature {
                margin-top: 20mm;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-report">
            <!-- <img src="<?= base_url('public/dist/img/bidan.png') ?>" alt="Logo Klinik"> -->
            <h1>Klinik Bidan Syifa</h1>
            <p>Jalan Celepuk II, Jatimakmur, Pondok Gede - Kota Bekasi</p>
            <p>Telp: 0817-1788-2700</p>
            <hr>

            <h2>Detail Laporan Pasien:

                <?= isset($riwayat[0]['nm_pasien']) ? $riwayat[0]['nm_pasien'] : 'Nama Tidak Ditemukan'; ?>
            </h2>
            </h2>
        </div>


        <div class="details">
            <p><strong>Tanggal Berobat:</strong> <?= isset($riwayat[0]['tgl_daftar']) ? $riwayat[0]['tgl_daftar'] : '' ?></p>
            <p><strong>No Antrian:</strong> <?= isset($riwayat[0]['no_antrian']) ? $riwayat[0]['no_antrian'] : '' ?></p>
            <p><strong>ID Pasien:</strong> <?= isset($riwayat[0]['id_pasien']) ? $riwayat[0]['id_pasien'] : '' ?></p>
            <p><strong>Diagnosa:</strong> <?= isset($riwayat[0]['diagnosa']) ? $riwayat[0]['diagnosa'] : '' ?></p>
        </div>
        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bidan</th>
                    <th>Nama Obat</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $grandTotal = 0;
                $no = 1;
                ?>
                <?php if (!empty($riwayat)): ?>
                    <?php foreach ($riwayat as $item): ?>
                        <?php
                        // Debugging untuk memastikan data valid

                        // Ambil data obat

                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $item['nm_user'] ?></td>
                            <td><?= $item['nm_obat'] ?></td>
                            <td><?= $item['keterangan'] ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td><?= !empty($item['harga']) ? number_format($item['harga'], 0, ',', '.') : 'N/A' ?></td>
                            <td><?= !empty($item['harga']) && !empty($item['jumlah'])
                                    ? number_format($item['jumlah'] * $item['harga'], 0, ',', '.')
                                    : 'Data Tidak Lengkap' ?></td>

                        </tr>
                        <?php
                        // Periksa validitasitem data sebelum menghitung grand total
                        if (!empty($item['harga']) && !empty($item['jumlah'])) {
                            $grandTotal += $item['jumlah'] * $item['harga'];
                        }

                        ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Data tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold;">Total</td>
                    <td>Rp. <?= number_format($grandTotal, 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>

        <div style="text-align: right; font-family: 'Georgia', serif; margin-top: 50px;">
            <p style="font-size: 18px; margin-bottom: 50px; color: #4b4b4b; letter-spacing: 1px;">
                <strong>Bekasi, 29-August-2022</strong>
            </p>
            <div style="margin-bottom: 100px; font-style: italic; font-size: 16px; color: #7a7a7a;">
                Hormat Kami,<br>
                <span style="font-size: 20px; font-weight: bold;">TTD</span>
            </div>
            <p style="font-size: 16px; font-weight: bold; margin-top: 0; border-top: 2px solid #000; width: 300px; text-align: center; margin-left: auto; padding-top: 10px;">
            <strong><?= $nm_user ?></strong>
            </p>
        </div>
    </div>
</body>

</html>