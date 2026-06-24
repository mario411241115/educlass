-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2026 at 01:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educlass`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas_virtual`
--

CREATE TABLE `kelas_virtual` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_virtual`
--

INSERT INTO `kelas_virtual` (`id_kelas`, `nama_kelas`, `deskripsi`, `status_aktif`) VALUES
(3, 'Pemograman Web', 'Kelas Sabtu Siang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id_modul` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `judul_modul` varchar(255) NOT NULL,
  `url_youtube` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id_modul`, `id_kelas`, `judul_modul`, `url_youtube`) VALUES
(2, 3, 'Belajar HTML Dasar', 'https://www.youtube.com/watch?v=0oA1Z6UKM5M&list=PL0A06OwyXeD2095arthcQy5TEw1Ce-g3H');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_kuis`
--

CREATE TABLE `nilai_kuis` (
  `id_nilai` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `username_siswa` varchar(50) DEFAULT NULL,
  `skor` int(11) DEFAULT NULL,
  `waktu_kerja` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_kuis`
--

INSERT INTO `nilai_kuis` (`id_nilai`, `id_kelas`, `username_siswa`, `skor`, `waktu_kerja`) VALUES
(1, 3, 'April_Siswa', 100, '2026-06-14 14:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('Admin','Instruktur','Siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password_hash`, `role`) VALUES
(1, 'Mario_Siswa', '$2y$10$.x39SjfpWPiV.wZM.WQc7.Qri9fwPZzLA64gM7SBbOCAVOPxv7OMe', 'Siswa'),
(2, 'Pak_Budi', '$2y$10$VG8jozKLpWwp0aAhXsHfHu/QBo6JwOSRgDAZ/sDj0PoVhY0cZ4WPO', 'Instruktur'),
(5, 'April_Siswa', '$2y$10$B0dYDSxfhx88A9mYcFUGWOsPGlhE5L8MTHCKf2U1wnxKfneCkLsNy', 'Siswa'),
(7, 'pak_anis', '$2y$10$YyZ/h7DBYqmhdMVzaD7RFOAo1.gPLq6P7AI36BmUjyN03B1..arsC', 'Instruktur');

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `username_siswa` varchar(50) DEFAULT NULL,
  `link_tugas` text DEFAULT NULL,
  `waktu_kumpul` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas_virtual`
--
ALTER TABLE `kelas_virtual`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `nilai_kuis`
--
ALTER TABLE `nilai_kuis`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas_virtual`
--
ALTER TABLE `kelas_virtual`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nilai_kuis`
--
ALTER TABLE `nilai_kuis`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_virtual` (`id_kelas`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_kuis`
--
ALTER TABLE `nilai_kuis`
  ADD CONSTRAINT `nilai_kuis_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_virtual` (`id_kelas`) ON DELETE CASCADE;

--
-- Constraints for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_virtual` (`id_kelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
