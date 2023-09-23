-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Sep 2023 pada 09.26
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `nama`, `username`, `email`, `password`, `level`) VALUES
(1, 'Daffa Apta Pratama', 'daffa', 'daffaaptapratama@gmail.com', '$2y$10$iU4cCOAfv6Rg/QubpthPEum17.9hmPeIKUPUFLi7WttGb6pu9GFI.', 'super-admin'),
(2, 'Operator Barang', 'opmbarang', 'opmbarang@gmail.com', '$2y$10$9p4vVp70RZb1K2tT/Xy6N.9J0VZ7j83dHzX3udo4SCe1UKoF9ALoW', 'admin'),
(3, 'Operator Mahasiswa', 'karyawan', 'opmahasiswa@gmail.com', '$2y$10$tuxOq2cB86bpg8aBe/iSR.TQgccfu943g0a0x7U7FjK7l48IrquB2', 'karyawan'),
(10, 'anjas', 'anjas', 'anja@gmail.com', '$2y$10$Sj66YgEMYTwDtFMQFtmcjer1eROBuyVgujIileMhEaKyO9wOlZubm', 'karyawan'),
(12, 'galang', 'galang', 'galang@gmail.com', '$2y$10$aT6L1qETkz3oI4y/swRl1e76ZQseE08brytVG5DCpJ7igk7nMe/yS', 'karyawan'),
(13, 'Maul', 'maul', 'maul@gmail.com', '$2y$10$5/ihV7KYB6dWG30dnoIV4u8zj5G0i2L36A6eQRe8H5B2x2InvUmg.', 'karyawan'),
(16, 'dapa', 'dapa', 'dapa@gmail.com', '$2y$10$eN2uLP/ej8sherE.ANnzve3tFWUY1kz0EewF.opNlpA23WWU05nt.', 'karyawan'),
(25, 'karyawan edan', 'edan', 'edankeun@gmail.com', '$2y$10$8M95tahFYL3K3AuOUeUzp.k899GRKn5BiRQKzg7isIcjRwLwc7F22', 'karyawan'),
(26, 'user', 'user', 'user@gmail.com', '$2y$10$GrN9LBPbuZSo28po.rO.nuSiqemQC3O9aDmJ/q7xWk9VFqc68AfYS', 'karyawan'),
(27, 'userbaru', 'userbaru', 'userbaru@gmail.com', '$2y$10$8Hd2HcaWZ5fxUDTM4a91ZO1Cap/QTy5T6IGk6LOr0xi5TlB/mlNeq', 'karyawan'),
(28, 'karyawan', 'barulagi', 'baru@gmail.com', '$2y$10$mFGn7fYCM087G0ssO7YRfevpspN/6a2RMsyjrWOfinQ6GxvZMcfBO', 'karyawan'),
(29, 'useredan', 'useredan', 'useredan@gmail.com', '$2y$10$OhN7ntCbFx1F0FZf.pZhC.kKanz.f2gRGyaQ1jcmbOL3z9BLcvLX2', 'karyawan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulan`
--

CREATE TABLE `bulan` (
  `id_bln` int(10) NOT NULL,
  `nama_bln` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bulan`
--

INSERT INTO `bulan` (`id_bln`, `nama_bln`) VALUES
(1, 'Januari'),
(2, 'Februari'),
(3, 'Maret'),
(4, 'April'),
(5, 'Mei'),
(6, 'Juni'),
(7, 'Juli'),
(8, 'Agustus'),
(9, 'September'),
(10, 'Oktober'),
(11, 'November'),
(12, 'Desember');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_absen`
--

CREATE TABLE `data_absen` (
  `id_absen` int(11) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `id_bln` int(10) NOT NULL,
  `id_hri` int(10) NOT NULL,
  `id_tgl` int(10) NOT NULL,
  `jam_msk` varchar(50) NOT NULL,
  `st_jam_msk` varchar(123) NOT NULL,
  `jam_klr` varchar(50) NOT NULL,
  `st_jam_klr` varchar(123) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `data_absen`
--

INSERT INTO `data_absen` (`id_absen`, `id_user`, `id_bln`, `id_hri`, `id_tgl`, `jam_msk`, `st_jam_msk`, `jam_klr`, `st_jam_klr`, `keterangan`) VALUES
(1, '10', 9, 3, 20, '09.28 WIB', '', '09.32 WIB', '', ''),
(2, '3', 9, 3, 20, '09.28 WIB', '', '09.30 WIB', '', ''),
(3, '12', 9, 3, 20, '14.12 WIB', 'Menunggu', '14.12 WIB', 'Menunggu', ''),
(4, '13', 9, 3, 20, '14.44 WIB', 'Menunggu', '14.44 WIB', 'Menunggu', ''),
(5, '16', 9, 3, 20, '14.52 WIB', 'Menunggu', '14.52 WIB', 'Menunggu', ''),
(6, '3', 9, 4, 21, '11:08', 'Menunggu', '11:08', 'Menunggu', ''),
(7, '25', 9, 4, 21, '11:28', 'Menunggu', '11:29', 'Menunggu', ''),
(8, '12', 9, 4, 21, '11:31', 'Menunggu', '11:31', 'Menunggu', ''),
(9, '26', 9, 4, 21, '13:57', 'Menunggu', '13:57', 'Menunggu', ''),
(10, '27', 9, 4, 21, '15:17', 'Menunggu', '15:57', 'Menunggu', ''),
(11, '28', 9, 4, 21, '16:52', 'Menunggu', '16:53', 'Menunggu', ''),
(12, '29', 9, 4, 21, '16:56', 'Menunggu', '16:56', 'Menunggu', ''),
(13, '12', 9, 5, 22, '10:01', 'Menunggu', '11:15', 'Menunggu', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari`
--

CREATE TABLE `hari` (
  `id_hri` int(10) NOT NULL,
  `nama_hri` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hari`
--

INSERT INTO `hari` (`id_hri`, `nama_hri`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jum\'at'),
(6, 'Sabtu'),
(7, 'Minggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggal`
--

CREATE TABLE `tanggal` (
  `id_tgl` int(10) NOT NULL,
  `nama_tgl` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tanggal`
--

INSERT INTO `tanggal` (`id_tgl`, `nama_tgl`) VALUES
(1, '01'),
(2, '02'),
(3, '03'),
(4, '04'),
(5, '05'),
(6, '06'),
(7, '07'),
(8, '08'),
(9, '09'),
(10, '10'),
(11, '11'),
(12, '12'),
(13, '13'),
(14, '14'),
(15, '15'),
(16, '16'),
(17, '17'),
(18, '18'),
(19, '19'),
(20, '20'),
(21, '21'),
(22, '22'),
(23, '23'),
(24, '24'),
(25, '25'),
(26, '26'),
(27, '27'),
(28, '28'),
(29, '29'),
(30, '30'),
(31, '31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indeks untuk tabel `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`id_bln`);

--
-- Indeks untuk tabel `data_absen`
--
ALTER TABLE `data_absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indeks untuk tabel `hari`
--
ALTER TABLE `hari`
  ADD PRIMARY KEY (`id_hri`);

--
-- Indeks untuk tabel `tanggal`
--
ALTER TABLE `tanggal`
  ADD PRIMARY KEY (`id_tgl`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `bulan`
--
ALTER TABLE `bulan`
  MODIFY `id_bln` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `data_absen`
--
ALTER TABLE `data_absen`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `hari`
--
ALTER TABLE `hari`
  MODIFY `id_hri` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tanggal`
--
ALTER TABLE `tanggal`
  MODIFY `id_tgl` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
