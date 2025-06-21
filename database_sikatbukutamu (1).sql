-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2025 at 02:18 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_sikatbukutamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_duduk`
--

CREATE TABLE `area_duduk` (
  `id` int NOT NULL,
  `nama_area` varchar(100) NOT NULL,
  `keperluan_id` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `area_duduk`
--

INSERT INTO `area_duduk` (`id`, `nama_area`, `keperluan_id`) VALUES
(1, 'Meja Keluarga Wanita', 4),
(2, 'Meja Keluarga Pria', 4),
(3, 'Meja VIP', 4),
(4, 'Area Umum', 4),
(5, 'Meja Tamu Jauh', 1),
(6, 'Meja Komunitas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `keperluan_kunjungan`
--

CREATE TABLE `keperluan_kunjungan` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text,
  `area_id` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `keperluan_kunjungan`
--

INSERT INTO `keperluan_kunjungan` (`id`, `nama`, `deskripsi`, `area_id`) VALUES
(1, 'Keluarga mempelai wanita', NULL, 4),
(2, 'Keluarga mempelai pria', NULL, 4),
(3, 'Teman mempelai wanita', NULL, 4),
(4, 'Teman mempelai pria', NULL, 4),
(5, 'Rekan kerja mempelai wanita', NULL, 4),
(6, 'Rekan kerja mempelai pria', NULL, 4),
(7, 'Tetangga mempelai wanita', NULL, 4),
(8, 'Tetangga mempelai pria', NULL, 4),
(9, 'Guru/Dosen/Kolega', NULL, 3),
(10, 'Tokoh masyarakat/Pejabat', NULL, 3),
(11, 'Teman organisasi/komunitas', NULL, 6),
(12, 'Tamu undangan umum', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama`, `kontak`) VALUES
(1, 'Adudu', '081234567890'),
(2, 'Dewi Anggraini', '082345678901'),
(3, 'Sinta Dedew', '083456789012');

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keperluan` enum('Keluarga','Teman','Rekan') NOT NULL,
  `area` varchar(50) NOT NULL,
  `luar_provinsi` enum('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id`, `nama`, `keperluan`, `area`, `luar_provinsi`, `waktu`) VALUES
(1, 'Oryza Surya Hapsari', 'Keluarga', 'Area Umum', 'Ya', '2025-06-10 10:30:49'),
(2, 'Oryza Surya Hapsari', 'Keluarga', 'Area Umum', 'Ya', '2025-06-10 10:30:50'),
(3, 'Oryza Surya Hapsari', 'Keluarga', 'Area Umum', 'Ya', '2025-06-10 10:30:50'),
(4, 'Oryza Surya Hapsari', 'Keluarga', 'Area Umum', 'Ya', '2025-06-10 10:54:01'),
(5, 'Oryza Surya Hapsari', 'Keluarga', 'Area Umum', 'Ya', '2025-06-10 10:55:07'),
(6, 'Oryza Surya Hapsari', 'Keluarga', 'Area Umum', 'Ya', '2025-06-10 10:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `tamu_prio`
--

CREATE TABLE `tamu_prio` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamu_prio`
--

INSERT INTO `tamu_prio` (`id`, `name`, `kategori`, `waktucreate`, `waktuupdate`) VALUES
(2, 'Siska Marlina', 'Keluarga mempelai wanita', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(3, 'Rini Susanti', 'Keluarga mempelai wanita', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(5, 'Agus Purnomo', 'Keluarga mempelai pria', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(6, 'Dewi Anggraini', 'Keluarga mempelai pria', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(8, 'Rina Oktaviani', 'Teman dekat mempelai', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(10, 'Fadhil Ramadhan', 'Rekan kerja prioritas', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(15, 'Ms. Catherine Smith', 'Tamu luar provinsi', '2025-06-11 16:16:59', '2025-06-11 16:16:59'),
(16, 'yayayyaaaaaaaa', 'Tokoh masyarakat', '2025-06-11 17:19:53', '2025-06-11 17:21:12'),
(18, 'qwertyuiop', 'Keluarga mempelai wanita', '2025-06-13 00:26:49', '2025-06-13 00:26:49'),
(20, 'ballerina', 'Tokoh masyarakat', '2025-06-13 00:37:24', '2025-06-13 00:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','tamu','pengantin') NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'tamu_baru', '$2y$10$Vid1aQp1o0paUPCy9OjjP.sCXxhGIGLN/Nj/LNQf27sUpZ1SO/ALu', 'tamu', 1, '2025-06-11 04:19:02', '2025-06-11 04:19:02'),
(4, 'admin', '$2y$10$/2kNk/RVXyftPQoMsNFKe.mzzMaUftJ/NuL.TTbU8v1Wc3r/ts732', 'admin', 1, '2025-06-11 04:35:41', '2025-06-11 04:35:41'),
(6, 'admin', '$2y$10$PyWgqvo1rOeFc.Ym8wUWN.gq7k3m9YTpgJru54udsJhBzA7tdLVDW', 'admin', 1, '2025-06-11 18:14:25', '2025-06-11 18:14:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_duduk`
--
ALTER TABLE `area_duduk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_area_keperluan` (`keperluan_id`);

--
-- Indexes for table `keperluan_kunjungan`
--
ALTER TABLE `keperluan_kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tamu_prio`
--
ALTER TABLE `tamu_prio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_duduk`
--
ALTER TABLE `area_duduk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `keperluan_kunjungan`
--
ALTER TABLE `keperluan_kunjungan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tamu_prio`
--
ALTER TABLE `tamu_prio`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area_duduk`
--
ALTER TABLE `area_duduk`
  ADD CONSTRAINT `fk_area_keperluan` FOREIGN KEY (`keperluan_id`) REFERENCES `keperluan_kunjungan` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `keperluan_kunjungan`
--
ALTER TABLE `keperluan_kunjungan`
  ADD CONSTRAINT `keperluan_kunjungan_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `area_duduk` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
