-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2026 at 03:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `radio_aas_fm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'adminaasfm');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT 'default.jpg',
  `waktu_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `deskripsi`, `link`, `gambar`, `waktu_input`) VALUES
(2, 'Menjaga Demokrasi Lewat Udara, Bawaslu Sukoharjo Isi Talkshow di Radio ITB AAS', 'Bawaslu Kabupaten Sukoharjo mengisi talkshow di Radio AAS FM sebagai upaya memberikan edukasi kepada masyarakat mengenai pentingnya menjaga demokrasi and meningkatkan partisipasi publik melalui media penyiaran.', 'https://sukoharjo.bawaslu.go.id/berita/menjaga-demokrasi-lewat-udara-bawaslu-sukoharjo-isi-talkshow-di-radio-itb-aas', '6a520c0e7d792.jpg', '2026-07-11 09:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `crew`
--

CREATE TABLE `crew` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `nama_siar` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT 'images/default-avatar.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crew`
--

INSERT INTO `crew` (`id`, `nama_lengkap`, `nama_siar`, `jabatan`, `foto`) VALUES
(2, 'Nanda Cantikasari', 'Nada', 'Ketua Umum', 'images/nada.jpg'),
(6, 'Ndiko Mirah Riski', 'Ikoo', 'Wakil Ketua ', 'images/iko.png'),
(7, 'Januwar Agung Pamungkas', 'Janu', 'Sekretaris', 'images/janu.png'),
(8, 'Salsabilla Hayu Maharani', 'Zilla', 'Sekretaris', 'images/zilla.png'),
(9, 'Septi Risa Ermawati', 'Mawa', 'Bendahara', 'images/mawa.png'),
(10, 'Aqila Tri Nurjannah', 'Aqeel', 'Bendahara', 'images/aqeel.png'),
(11, 'Alrizqika Julyansah', 'Miru', 'Script Writer', 'images/miru.png'),
(12, 'Muhammad Taqiyan', 'Kian', 'Script Writer', 'images/kian.png'),
(13, 'Anisa Elisawati', 'Nisa', 'On Air', 'images/nisa.png'),
(14, 'Ardhia Paramitha Valia Putri', 'Vale', 'On Air', 'images/vale.png'),
(15, 'Eko Retno Wahyuning Tias', 'Titi', 'Off Air', 'images/titi.png'),
(16, 'Vidi Desty Cahyani Putri', 'Vidi', 'Script Writer', 'images/vidi.jpg'),
(17, 'Yusuf Eka Wijarnoko', 'Ucup', 'Off Air', 'images/ucup.png'),
(18, 'Adryana Tri Rahayu', 'Andre', 'Off Air', 'images/andre.png'),
(19, 'Ardhayana Devi Puspita', 'Yana', 'Off Air', 'images/yana.jpg'),
(20, 'Amran Mahendra Dongoran', 'Mahen', 'Off Air', 'images/mahen.png'),
(21, 'Sarah Alifah Hannan', 'Khana', 'Off Air', 'images/khanna.png'),
(22, 'Tiara Monica Sari', 'Timon', 'Music Director', 'images/timon.png'),
(23, 'Fina Rodidah', 'Piny', 'Music Director', 'images/piny.png'),
(24, 'Naysilla Fahira Khairunisa', 'Nala', 'Music Director', 'images/nala.png'),
(25, 'Adinda Kusuma Wardani', 'Kuma', 'Music Director', 'images/kuma.png'),
(26, 'Sanggar Bayu Saputro', 'Bayu', 'Media', 'images/bayu.png'),
(27, 'Anisa Choeri Lia Isni', 'Aeri', 'Media', 'images/aeri.png'),
(28, 'Maura Cahaya Eka Safitri', 'Raya', 'Media', 'images/raya.png'),
(29, 'Latifah Anjarani', 'Ifah', 'Marketing', 'images/ifah.png'),
(30, 'Nadhifa Zahra Maharani', 'Dhifa', 'Marketing', 'images/dhifa.png'),
(31, 'Adelia Nandar Pasha', 'Asha', 'Marketing', 'images/asha.png'),
(32, 'Juliana Anggraini Santoso', 'Lia', 'On Air', 'images/lia.png');

-- --------------------------------------------------------

--
-- Table structure for table `request_lagu`
--

CREATE TABLE `request_lagu` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `judul_lagu` varchar(150) NOT NULL,
  `penyanyi` varchar(100) NOT NULL,
  `pesan` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_lagu`
--

INSERT INTO `request_lagu` (`id`, `nama`, `judul_lagu`, `penyanyi`, `pesan`, `waktu`) VALUES
(4, 'vidi', '-', '-', 'semangat kaka', '2026-07-10 08:48:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_lagu`
--
ALTER TABLE `request_lagu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `crew`
--
ALTER TABLE `crew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `request_lagu`
--
ALTER TABLE `request_lagu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
