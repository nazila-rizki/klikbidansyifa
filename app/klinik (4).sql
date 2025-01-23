-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jan 2025 pada 13.29
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id_obat` varchar(10) NOT NULL,
  `nm_obat` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `stok` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id_obat`, `nm_obat`, `kategori`, `harga`, `stok`) VALUES
('o1', 'Amocxilin', 'tablet', '1500', 0),
('o2', 'Mefentan', 'tablet', '1500', 4),
('o3', 'Voltadex', 'tablet', '2000', 44),
('o4', 'Sanmol', 'tablet', '1000', 36);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` varchar(10) NOT NULL,
  `nm_pasien` varchar(50) NOT NULL,
  `jenis_kelamin` enum('perempuan','laki-laki','','') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nm_pasien`, `jenis_kelamin`, `tgl_lahir`, `alamat`) VALUES
('PNS000001', 'Ardiansyah Perkasa', 'laki-laki', '2025-01-01', 'kesesi'),
('PNS000002', 'Dasniati Nia', 'perempuan', '2025-01-07', 'Bekasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(10) NOT NULL,
  `id_pasien` varchar(10) NOT NULL,
  `nm_pasien` varchar(50) NOT NULL,
  `no_antrian` varchar(10) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `status` enum('belum_dibayar','sudah_dibayar','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_pasien`, `nm_pasien`, `no_antrian`, `nm_user`, `status`) VALUES
(1, 'PNS000001', 'Ardiansyah Perkasa', '1', 'Siti Fajar STr.Keb.', 'sudah_dibayar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_kesehatan`
--

CREATE TABLE `riwayat_kesehatan` (
  `id` int(11) NOT NULL,
  `no_antrian` varchar(10) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `id_pasien` varchar(10) NOT NULL,
  `nm_pasien` varchar(50) NOT NULL,
  `keluhan` text NOT NULL,
  `diagnosa` text NOT NULL,
  `tindakan` enum('persalinan','KB','imunisasi','khitan','massage','terapi_ruqyah','terapi_herbal','USG') NOT NULL,
  `tgl_daftar` date DEFAULT curdate(),
  `id_obat` varchar(10) NOT NULL,
  `nm_obat` varchar(50) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `riwayat_kesehatan`
--

INSERT INTO `riwayat_kesehatan` (`id`, `no_antrian`, `nm_user`, `id_pasien`, `nm_pasien`, `keluhan`, `diagnosa`, `tindakan`, `tgl_daftar`, `id_obat`, `nm_obat`, `jumlah`, `keterangan`) VALUES
(1, '1', 'Siti Fajar STr.Keb.', 'PNS000001', 'Ardiansyah Perkasa', 'sakit perut   ', ' magh           ', 'persalinan', '2025-01-23', 'o1', 'Amocxilin', 2, '3X1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` varchar(10) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','apoteker','bidan','') NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nm_user`, `password`, `role`, `foto`) VALUES
('A1', 'admin', '$2y$10$eusjw9shboPQGM9AEiOIn.sbo4WGb/5tL7qfzbpbLVNsaUYQxOW/C', 'admin', ''),
('A2', 'Anggun', '$2y$10$YBwzIhiu9oJyzu53B8Nn1uJEW6TuKgK7S4CzlrQHYb6ASDzq8rWNO', 'admin', ''),
('B1', 'rizki', '$2y$10$LrtY2QJvWv7GgdnQ1QZ8/ePJzf8ImwfHmU5YP/2wvai.nDU2CWLHm', 'bidan', ''),
('B2', 'Siti Fajar STr.Keb.', '$2y$10$gehj3mLaFSP9h7KGG5dErOW2xHkrnYkaaujIeZVX9Qf25gnePRO6e', 'bidan', ''),
('P1', 'syafila', '$2y$10$b0OKu9X2t3iYu1NlCDp.n.Ijxu5QRjpmOAbxc3.htWs1RjwPoW9Ze', 'apoteker', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `riwayat_kesehatan`
--
ALTER TABLE `riwayat_kesehatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `idx_nm_user` (`nm_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `riwayat_kesehatan`
--
ALTER TABLE `riwayat_kesehatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`);

--
-- Ketidakleluasaan untuk tabel `riwayat_kesehatan`
--
ALTER TABLE `riwayat_kesehatan`
  ADD CONSTRAINT `riwayat_kesehatan_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `riwayat_kesehatan_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
