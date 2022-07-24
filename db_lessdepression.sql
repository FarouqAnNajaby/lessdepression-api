-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jan 2021 pada 16.50
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbdepresi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_artikel`
--

CREATE TABLE `tb_artikel` (
  `id` int(11) NOT NULL,
  `kode_artikel` varchar(225) NOT NULL,
  `judul_artikel` varchar(225) NOT NULL,
  `isi_artikel` text NOT NULL,
  `tingkat_depresi` varchar(225) NOT NULL,
  `gambar_artikel` varchar(225) NOT NULL,
  `lokasi_gambar` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_gejala`
--

CREATE TABLE `tb_data_gejala` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_gejala` varchar(225) NOT NULL,
  `nama_gejala` varchar(225) NOT NULL,
  `bobot_gejala` double NOT NULL,
  `bobot_teta_gejala` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_data_gejala`
--

INSERT INTO `tb_data_gejala` (`id`, `kode_gejala`, `nama_gejala`, `bobot_gejala`, `bobot_teta_gejala`) VALUES
(1, 'G001', 'Wajah Sedih', 0.9, 0.1),
(2, 'G002', 'Kehilangan Minat atau Kegembiraan', 0.7, 0.3),
(3, 'G003', 'Mudah lelah dan menurunnya aktivitas', 0.7, 0.3),
(4, 'G004', 'Kurangnya Konsentrasi', 0.8, 0.2),
(5, 'G005', 'Kepercayaan Berkurang', 0.7, 0.3),
(6, 'G006', 'Merasa Bersalah dan Tidak Berguna', 0.8, 0.2),
(7, 'G007', 'Pesimistis', 0.7, 0.3),
(8, 'G008', 'Nafsu Makan Berkurang', 0.8, 0.2),
(9, 'G009', 'Tidur Terganggu', 0.8, 0.2),
(10, 'G010', 'Perbuatan Membahayakan Diri', 0.8, 0.2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_history`
--

CREATE TABLE `tb_history` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `kode_history` varchar(100) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_history_hasil`
--

CREATE TABLE `tb_history_hasil` (
  `id` int(11) NOT NULL,
  `kode_history` varchar(100) NOT NULL,
  `indikasi` enum('ringan','sedang','berat','tidak_depresi') NOT NULL,
  `nilai_akhir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_history_pilihan`
--

CREATE TABLE `tb_history_pilihan` (
  `id` int(11) NOT NULL,
  `kode_history` varchar(100) NOT NULL,
  `kode_gejala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id` int(11) NOT NULL,
  `email` varchar(225) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `sandi` varchar(100) NOT NULL,
  `kelamin` varchar(1) DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL,
  `lokasi_foto` varchar(225) NOT NULL,
  `umur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tingkatan_gejala`
--

CREATE TABLE `tb_tingkatan_gejala` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_gejala` varchar(255) NOT NULL,
  `depresi_ringan` tinyint(1) NOT NULL,
  `depresi_sedang` tinyint(1) NOT NULL,
  `depresi_berat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_tingkatan_gejala`
--

INSERT INTO `tb_tingkatan_gejala` (`id`, `kode_gejala`, `depresi_ringan`, `depresi_sedang`, `depresi_berat`) VALUES
(1, 'G001', 1, 1, 1),
(2, 'G002', 1, 0, 0),
(3, 'G003', 1, 0, 0),
(4, 'G004', 1, 1, 0),
(5, 'G005', 0, 1, 1),
(6, 'G006', 0, 1, 1),
(7, 'G007', 1, 1, 0),
(8, 'G008', 0, 1, 1),
(9, 'G009', 1, 1, 0),
(10, 'G010', 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_artikel`
--
ALTER TABLE `tb_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_artikel` (`kode_artikel`);

--
-- Indeks untuk tabel `tb_data_gejala`
--
ALTER TABLE `tb_data_gejala`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_gejala` (`kode_gejala`);

--
-- Indeks untuk tabel `tb_history`
--
ALTER TABLE `tb_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `kode_history` (`kode_history`);

--
-- Indeks untuk tabel `tb_history_hasil`
--
ALTER TABLE `tb_history_hasil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_history` (`kode_history`);

--
-- Indeks untuk tabel `tb_history_pilihan`
--
ALTER TABLE `tb_history_pilihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_gejala` (`kode_gejala`),
  ADD KEY `kode_history` (`kode_history`);

--
-- Indeks untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_tingkatan_gejala`
--
ALTER TABLE `tb_tingkatan_gejala`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_gejala` (`kode_gejala`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_artikel`
--
ALTER TABLE `tb_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_data_gejala`
--
ALTER TABLE `tb_data_gejala`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_history`
--
ALTER TABLE `tb_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_history_hasil`
--
ALTER TABLE `tb_history_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_history_pilihan`
--
ALTER TABLE `tb_history_pilihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_tingkatan_gejala`
--
ALTER TABLE `tb_tingkatan_gejala`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_history`
--
ALTER TABLE `tb_history`
  ADD CONSTRAINT `tb_history_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_history_hasil`
--
ALTER TABLE `tb_history_hasil`
  ADD CONSTRAINT `tb_history_hasil_ibfk_1` FOREIGN KEY (`kode_history`) REFERENCES `tb_history` (`kode_history`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_history_pilihan`
--
ALTER TABLE `tb_history_pilihan`
  ADD CONSTRAINT `tb_history_pilihan_ibfk_1` FOREIGN KEY (`kode_gejala`) REFERENCES `tb_data_gejala` (`kode_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_history_pilihan_ibfk_2` FOREIGN KEY (`kode_history`) REFERENCES `tb_history` (`kode_history`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_tingkatan_gejala`
--
ALTER TABLE `tb_tingkatan_gejala`
  ADD CONSTRAINT `tb_tingkatan_gejala_ibfk_3` FOREIGN KEY (`kode_gejala`) REFERENCES `tb_data_gejala` (`kode_gejala`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
