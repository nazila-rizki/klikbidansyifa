<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pasien dan Pemeriksaan</title>
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
              <h1 class="m-0 text-center">Detail Pasien dan Pemeriksaan <?= isset($pasien['nm_pasien']) ? $pasien['nm_pasien'] : '' ?></h1>
            </div>
          </div>
        </div>
      </div>

      <div class="content">
        <div class="container">
          <div class="card">
            <div class="card-body">

              <form>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <?php if (isset($riwayat) && !empty($riwayat)) : ?>
                      <label for="no_antrian" class="form-label">No Antrian</label>
                      <input type="text" class="form-control" id="no_antrian" name="no_antrian"
                        value="<?= isset($riwayat[0]['no_antrian']) ? esc($riwayat[0]['no_antrian']) : '' ?>" readonly>
                    <?php endif; ?>
                  </div>
                  <!-- <?php 
                  echo '<pre>';
print_r('tgl_daftar');
echo '</pre>';
?> -->

                  <div class="form-group col-md-6">
                    <label for="tgl_daftar" class="form-label">Tanggal Berobat</label>
                    <input type="date" class="form-control" id="tgl_daftar" name="tgl_daftar"
                      value="<?= isset($pasien['tgl_daftar']) ? date('Y-m-d', strtotime($pasien['tgl_daftar'])) : '' ?>"
                      readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="id_pasien" class="form-label">ID Pasien</label>
                    <input type="text" class="form-control" id="id_pasien" name="id_pasien"
                      value="<?= isset($pasien['id_pasien']) ? $pasien['id_pasien'] : '' ?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="nm_pasien" class="form-label">Nama Pasien</label>
                    <input type="text" class="form-control" id="nm_pasien" name="nm_pasien"
                      value="<?= isset($pasien['nm_pasien']) ? $pasien['nm_pasien'] : '' ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-md-12 mb-3">
                  <label for="diagnosa">Diagnosa</label>
                  <textarea
                    class="form-control"
                    id="diagnosa"
                    name="diagnosa"
                    rows="3"
                    readonly><?= isset($riwayat[0]['diagnosa']) ? esc($riwayat[0]['diagnosa']) : '' ?></textarea>
                </div>
              </form>
            </div>

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
            </div>

            <div class="form-group text-right">
              <a href="<?= base_url('BidanController/index') ?>" class="btn btn-secondary btn-sm px-4">
                <i class="fas fa-redo"></i> Kembali
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Ambil elemen input dengan id 'tgl_daftar'
    const tglDaftarInput = document.getElementById('tgl_daftar');
    if (tglDaftarInput) {
      // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
      const today = new Date().toISOString().split('T')[0];
      // Set nilai input ke tanggal hari ini
      tglDaftarInput.value = today;
    }
  </script>

  <!-- Tambahkan JS AdminLTE -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>