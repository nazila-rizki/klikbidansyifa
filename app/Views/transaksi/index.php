<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi Pasien</title>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brogo -->
            <a href="#" class="brand-link">
                <img src="<?= base_url('dist/img/bidan.png'); ?>"
                    alt="Logo Klinik"
                    class="brand-image img-circle elevation-3"
                    style="width: 50px; height: 50px; object-fit: cover;">
                <span class="brand-text font-weight-light">Klinik Bidan Syifa</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Master Data -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Master Data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('ObatController/index') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Obat</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Transactions -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Transactions
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('/TransaksiController/index') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaksi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Reports -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('/ObatController/generatePdfReport') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Data Obat</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Logout -->
                        <li class="nav-item">
                            <a href="<?= base_url('/AdminController/logout') ?>" class="btn btn-danger btn-block">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Data Pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center mb-0 p-2">
                                <i class="fas fa-users"></i> Data Antrian Pasien
                        </div>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert" style="animation: fadeInRight 0.5s ease-out;">
                                <strong>Success!</strong> <?= session()->getFlashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="animation: shake 0.5s ease-out;">
                                <strong>Error!</strong> <?= session()->getFlashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <style>
                            /* Animation for success notification (fade-in from right) */
                            @keyframes fadeInRight {
                                from {
                                    transform: translateX(100%);
                                    opacity: 0;
                                }

                                to {
                                    transform: translateX(0);
                                    opacity: 1;
                                }
                            }

                            /* Animation for error notification (shake effect) */
                            @keyframes shake {
                                0% {
                                    transform: translateX(-10px);
                                }

                                50% {
                                    transform: translateX(10px);
                                }

                                100% {
                                    transform: translateX(0);
                                }
                            }
                        </style>

                        <div class="card-body">
                            <a href="<?= base_url('/TransaksiController/create') ?>" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">Antrian</th>
                                        <th style="width: 10%">Tanggal</th>
                                        <th style="width: 15%">ID Pasien</th>
                                        <th style="width: 30%">Nama Pasien</th>
                                        <th style="width: 20%">Bidan</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 15%">Proses</th>
                                    </tr>
                                </thead>
                                
                                    <?php if (!empty($transaksi)) :?>
                                        <?php foreach ($transaksi as $index => $data) : ?>
                                            <tr>
                                                <td><?= esc($data['no_antrian'] )?></td>
                                                <td><?= esc($data['tgl_daftar'] )?></td>
                                                <td><?= esc($data['id_pasien']) ?></td>
                                                <td><?= esc($data['nm_pasien']) ?></td>
                                                <td><?= esc($data['nm_user'] )?></td>
                                                <td><?= esc($data['status']) ?></td>
                                                <td>
                                                <a href="<?= base_url('BidanController/data_rekam/' . $data['id_pasien'] . '/' . $data['tgl_daftar']) ?>" class="btn btn-primary btn-sm">
    <i class="fas fa-money-bill-alt"></i> Bayar
</a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </section>
        </div>
    </div>
    </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>

    <!-- Inisialisasi Treeview -->
    <script>
        $(document).ready(function() {
            // Sidebar dropdown initialization
            $('[data-widget="treeview"]').Treeview();
        });
    </script>
</body>

</html>