-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Sep 2023 pada 09.14
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
-- Struktur dari tabel `overtime`
--

CREATE TABLE `overtime` (
  `id_lembur` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `datang` time NOT NULL,
  `pulang` time NOT NULL,
  `agenda` varchar(255) DEFAULT NULL,
  `nota` varchar(221) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `overtime`
--

INSERT INTO `overtime` (`id_lembur`, `tanggal`, `datang`, `pulang`, `agenda`, `nota`) VALUES
(6, '1111-11-11', '11:11:00', '11:11:00', 'dsddassdaasd', '<p>dsadsadsadssda</p>'),
(7, '1111-11-11', '11:11:00', '11:22:00', 'sdadsadasdas', '<ul><li>dsadsadasda</li><li>dsadsadasd</li><li>dsadsadasda</li></ul>'),
(8, '2023-02-11', '13:00:00', '13:22:00', 'ddsadsdsadsadsdadsdas', '<p>dddddddddddddddddd</p>'),
(9, '0000-00-00', '13:50:00', '13:53:00', 'sdsadsadasdas', '<ul><li>dsadsaddsdsd</li><li>dsaasddasd</li><li>dsadas</li></ul>'),
(10, '2023-09-30', '11:22:00', '11:34:00', 'sdsa', '<p>dsdssd</p>'),
(11, '2023-09-26', '12:22:00', '22:13:00', 'sdadasdas', '<p>dsadasdas</p>'),
(12, '2023-09-26', '11:11:00', '12:22:00', 'sdadasd', '<p>dsadasdas</p>'),
(13, '2023-09-13', '11:22:00', '22:11:00', 'sdadasdsadsa', '<p>dsadsadsadsa</p>'),
(14, '2023-09-30', '11:00:00', '11:22:00', 'sdadsadas', '<p>dsadasda</p>'),
(15, '2023-09-23', '11:11:00', '12:22:00', 'dsadas', '<p>dsadasd</p>'),
(16, '2023-09-28', '00:00:00', '00:00:00', 'sdcadsad', '<p>dadsa</p>'),
(17, '2023-09-23', '11:22:00', '11:22:00', 'dsadasdas', '<p>dsadasdas</p>');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id_lembur`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id_lembur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
