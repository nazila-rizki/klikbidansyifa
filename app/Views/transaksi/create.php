<?php

use App\Controllers\TransaksiController;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Transaksi Pasien</title>
    <link rel="stylesheet" href="/assets/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="bg-light">

    <!-- Form Data Kesehatan Pasien -->
    <div class="container my-3">
        <div class="card mx-auto shadow" style="max-width: 600px;">
            <div class="card-header text-center">
                <h3 class="text-center mb-4">Form Data Transaksi Pasien</h3>
            </div>
            <div class="card-body">
                <form  enctype="multipart/form-data" action="<?= base_url('/TransaksiController/store') ?>" method="POST">
                    
                   <!-- Nomor Antrian -->
                   <div class="mb-3">
                        <label for="no_antrian" class="form-label">No Antrian</label>
                        <input type="text" class="form-control" id="no_antrian" name="no_antrian" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_daftar" class="col-sm-3 col-form-label">Tanggal</label>
                        <input type="date" name="tgl_daftar" class="form-control" id="tgl_daftar" required>
                    </div>

                    <!-- ID Pasien (Select Dropdown) -->
                    <div class="mb-3">
                        <label for="id_pasien" class="form-label">ID Pasien</label>
                        <select class="form-control" id="id_pasien" name="id_pasien" required>
                            <option value="">Pilih Pasien</option>
                            <?php foreach($pasien as $p): ?>
                                <option value="<?= $p['id_pasien']; ?>"><?= $p['id_pasien']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nama Pasien -->
                    <div class="mb-3">
                        <label for="nm_pasien" class="form-label">Nama Pasien</label>
                        <select class="form-control" id="nm_pasien" name="nm_pasien" required>
                            <option value="">Pilih Pasien</option>
                            <?php foreach($pasien as $p): ?>
                                <option value="<?= $p['nm_pasien']; ?>"><?= $p['nm_pasien']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                   <!-- Nama Bidan -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Bidan</label>
                        <select class="form-control" id="username" name="nm_user" required>
                            <option value="">Pilih Bidan</option>
                            <?php foreach($riwayat as $b): ?>
                                <option value="<?= $b['nm_user']; ?>"><?= $b['nm_user']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="belum_dibayar" class="form-check-input" id="belum_dibayar" required>
                                <label class="form-check-label" for="belum_dibayar">Belum Dibayar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="sudah_dibayar" class="form-check-input" id="sudah_dibayar">
                                <label class="form-check-label" for="sudah_dibayar">Sudah Dibayar</label>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Card Footer -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Simpan</button>
                <a href="<?= base_url('/TransaksiController/index') ?>" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Kembali
                </a>
            </div>
        </div>
        </form>
    </div>
    </div>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

</body>

</html>