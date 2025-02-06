<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Form Pembayaran Pasien</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Include Font Awesome CDN for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0 text-center">
                Form Pembayaran Pasien
                <?= isset($pasien['nm_pasien']) ? $pasien['nm_pasien'] : 'Pasien Tidak Ditemukan' ?>
              </h1>
            </div>
          </div>
        </div>
      </div> <!-- /.content-header -->

      <div class="content">
        <div class="container">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="no_antrian">No Antrian</label>
                    <input type="text" class="form-control" id="no_antrian" name="no_antrian"
                      value="<?= $pasien['no_antrian'] ?? '' ?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="tgl_daftar">Tanggal Berobat</label>
                    <input type="date" class="form-control" id="tgl_daftar" name="tgl_daftar"
                      value="<?= isset($pasien['tgl_daftar']) ? date('Y-m-d', strtotime($pasien['tgl_daftar'])) : '' ?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="id_pasien">ID Pasien</label>
                    <input type="text" class="form-control" id="id_pasien" name="id_pasien"
                      value="<?= $pasien['id_pasien'] ?? '' ?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nm_pasien">Nama Pasien</label>
                    <input type="text" class="form-control" id="nm_pasien" name="nm_pasien"
                      value="<?= $pasien['nm_pasien'] ?? '' ?>" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="diagnosa">Diagnosa</label>
                  <textarea class="form-control" id="diagnosa" name="diagnosa" readonly>
                    <?= $pasien['diagnosa'] ?? 'Diagnosa tidak tersedia' ?>
                  </textarea>
                </div>
              </form>
            </div><!-- /.card-body -->

            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bidan / User</th>
                    <th>Nama Obat</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Hasil</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $grandTotal = 0;
                  ?>
                  <?php if (!empty($riwayat)): ?>
                    <?php foreach ($riwayat as $rekam): ?>
                      <?php
                      $jumlah = floatval($rekam['jumlah'] ?? 0);
                      $harga = floatval($rekam['harga'] ?? 0);
                      $subtotal = $jumlah * $harga;
                      $grandTotal += $subtotal;
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($rekam['nm_user']) ?></td>
                        <td><?= esc($rekam['nm_obat']) ?></td>
                        <td><?= esc($rekam['keterangan']) ?></td>
                        <td><?= $jumlah ?></td>
                        <td><?= number_format($harga, 0, ',', '.') ?></td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="7" class="text-center">Data riwayat tidak ditemukan</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="6" class="text-right">Total</th>
                    <th><?= number_format($grandTotal, 0, ',', '.') ?></th>
                  </tr>
                </tfoot>
              </table>
            </div><!-- /.table-responsive -->

            <div class="form-group text-right">
            <a href="<?= base_url('/BidanController/generatePdfReport/'. $rekam['id_pasien']. '/' . $rekam['tgl_daftar']) ?>" class="btn btn-primary btn-sm px-4">
                <i class="fas fa-print"></i> Cetak Resep Obat
              </a>
              <a href="<?= base_url('/TransaksiController/bayar/' . $rekam['id_pasien']) ?>" class="btn btn-success btn-sm px-4">
                <i class="fas fa-money-bill-alt"></i> Bayar
              </a>

              <a href="<?= base_url('/TransaksiController/index') ?>" class="btn btn-secondary btn-sm px-4">
                <i class="fas fa-redo"></i> Kembali
              </a>
            </div>

          </div><!-- /.card -->
        </div><!-- /.container -->
      </div><!-- /.content -->
    </div><!-- /.content-wrapper -->
  </div><!-- /.wrapper -->

  <!-- AdminLTE JS -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>