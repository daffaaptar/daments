-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Sep 2023 pada 07.42
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
-- Struktur dari tabel `activity`
--

CREATE TABLE `activity` (
  `id_akun` int(11) NOT NULL,
  `tipe_activity` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `durasi` int(11) NOT NULL,
  `status_activity` varchar(255) NOT NULL,
  `detail_activity` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `activity`
--

INSERT INTO `activity` (`id_akun`, `tipe_activity`, `start_date`, `end_date`, `durasi`, `status_activity`, `detail_activity`) VALUES
(12, 'discuss', '1111-11-11', '2222-02-22', 0, 'discuss', 'sddddsadas'),
(12, '<p>hallo</p>', '2023-09-26', '0000-00-00', 0, 'discuss', 'dsaddasdsdsadsa'),
(12, '<p>sdadasdas</p>', '0000-00-00', '1111-11-11', 0, 'discuss', 'dsadsadas'),
(12, '<p>dsadasdassdadsadas</p>', '1222-12-11', '2222-02-22', 0, 'discuss', 'dsadasdsadas');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
