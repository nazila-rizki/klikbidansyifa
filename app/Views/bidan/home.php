<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Data Kesehatan Pasien</title>
  <link rel="stylesheet" href="/assets/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <!-- Form Data Kesehatan Pasien -->
  <div class="container my-3">
    <div class="card mx-auto shadow" style="max-width: 600px;">
      <div class="card-header text-center">
        <h3 class="text-center mb-4">Form Data Kesehatan Pasien
          <div><?= isset($pasien['nm_pasien']) ? $pasien['nm_pasien'] : '' ?> </div>
        </h3>
      </div>
      <div class="card-body">
        <form action="<?= base_url('BidanController/home');
                      base_url('BidanController/data_rekam') ?>" method="post">

          <div class="mb-3">
            <label for="nm_user" class="form-label">Bidan</label>
            <input type="text" class="form-control" id="nm_user" name="nm_user"
              value="<?= isset($pasien['nm_user']) ? $pasien['nm_user'] : '' ?>" readonly>
          </div>

          <!-- Tanggal Berobat -->
          <div class="mb-3">
            <label for="tgl_daftar" class="form-label">Tanggal Berobat</label>
            <input type="date" class="form-control" id="tgl_daftar" name="tgl_daftar"
              value="<?= date('Y-m-d H:i:s') ?>" readonly>
          </div>

          <!-- Nomor Antrian -->
          <div class="mb-3">
            <label for="no_antrian" class="form-label">No Antrian</label>
            <input type="text" class="form-control" id="no_antrian" name="no_antrian" required>
          </div>

          <!-- ID Pasien -->
          <div class="mb-3">
            <label for="id_pasien" class="form-label">ID Pasien</label>
            <input type="text" class="form-control" id="id_pasien" name="id_pasien"
              value="<?= isset($pasien['id_pasien']) ? $pasien['id_pasien'] : '' ?>" readonly>
          </div>

          <!-- Nama Pasien -->
          <div class="mb-3">
            <label for="nm_pasien" class="form-label">Nama Pasien</label>
            <input type="text" class="form-control" id="nm_pasien" name="nm_pasien"
              value="<?= isset($pasien['nm_pasien']) ? $pasien['nm_pasien'] : '' ?>" readonly>
          </div>

          <!-- Keluhan -->
          <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan</label>
            <textarea class="form-control" id="keluhan" name="keluhan" required>
          </textarea>
          </div>

          <!-- Diagnosa -->
          <div class="mb-3">
            <label for="diagnosa" class="form-label">Diagnosa</label>
            <textarea class="form-control" id="diagnosa" name="diagnosa" required>
            </textarea>
          </div>
          <!-- Obat -->
          <h4 class="mb-4">Obat</h4>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="nm_obat" class="form-label">Id Obat</label>
              <select class="form-select" id="id_obat" name="id_obat" required>
                <option value="" selected>Pilih Id</option>
                <option value="o1">o1</option>
                <option value="o2">o2</option>
                <option value="o3">o3</option>
                <option value="o4">o4</option>
              </select>
            </div>


            <div class="row mb-3">
              <div class="col-md-4">
                <label for="nm_obat" class="form-label">Nama Obat</label>
                <select class="form-select" id="nm_obat" name="nm_obat" required>
                  <option value="" selected>Pilih Obat</option>
                  <option value="Amocxilin">Amocxilin</option>
                  <option value="Mefentan">Mefentan</option>
                  <option value="Voltadex">Voltadex</option>
                  <option value="Sanmol">Sanmol</option>

                </select>
              </div>
              <div class="col-md-4">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" required>
              </div>
              <div class="col-md-4">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan">
              </div>
            </div>

            <!-- Tindakan -->
            <h4 class="mb-3">Tindakan</h4>
            <div class="row mb-3">
              <div class="col-md-6">
                <!-- Kolom pertama -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="persalinan" name="tindakan[]" value="persalinan">
                  <label class="form-check-label" for="persalinan">Persalinan</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="kb" name="tindakan[]" value="KB">
                  <label class="form-check-label" for="kb">KB</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="imunisasi" name="tindakan[]" value="Imunisasi">
                  <label class="form-check-label" for="imunisasi">Imunisasi</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="khitan" name="tindakan[]" value="khitan">
                  <label class="form-check-label" for="khitan">Khitan</label>
                </div>
              </div>
              <div class="col-md-6">
                <!-- Kolom kedua -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="massage" name="tindakan[]" value="Massage">
                  <label class="form-check-label" for="massage">Massage</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="terapi_ruqyah" name="tindakan[]" value="terapi_ruqyah">
                  <label class="form-check-label" for="terapi_ruqyah">Terapi Ruqyah</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="terapi_herbal" name="tindakan[]" value="terapi_herbal">
                  <label class="form-check-label" for="terapi_herbal">Terapi Herbal</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="USG" name="tindakan[]" value="USG">
                  <label class="form-check-label" for="USG">USG</label>
                </div>

                <!-- Buttons -->

                <div class="card-body d-flex justify-content-between">
                  <a href="<?= base_url('/BidanController/index') ?>" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Kembali
                  </a>

                  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    </form>
  </div>
  </div>

   <!-- Rekam Medis Pasien -->
   <div class="container my-3">
    <div class="card mx-auto shadow" style="max-width: 900px;">
      <div class="card-header text-center">
        <h3>Rekam Medis Pasien</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="width: 5%">No</th>
              <th style="width: 20%">Tanggal Berobat</th>
              <th style="width: 35%">Bidan</th>
              <th style="width: 25%">Diagnosa</th>
              <th style="width: 25%">Nama Obat</th>
              <th style="width: 15%">Proses</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($riwayat)): ?>
              <?php $no = 1; ?>
              <?php foreach ($riwayat as $item): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $item['tgl_daftar'] ?></td>
                  <td><?= $item['nm_user'] ?></td>
                  <td><?= $item['diagnosa'] ?></td>
                  <td><?= $item['nm_obat'] ?> (<?= $item['jumlah'] ?>)</td>


                  <!-- Tombol Detail -->
                  <td>
                      <a href="<?= base_url('/BidanController/detail/' . $pasien['id_pasien'] . '/' . $pasien['tgl_daftar']) ?>" 
                      class="btn btn-sm btn-primary">
                      <i class="fas fa-info-circle"></i> Detail
                      </a>
                  </td>

                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Tidak ada data rekam medis.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
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

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
