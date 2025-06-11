-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2025 at 05:27 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

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
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keperluan` enum('Keluarga','Teman','Rekan') NOT NULL,
  `luar_provinsi` enum('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id`, `nama`, `keperluan`, `luar_provinsi`, `waktu`) VALUES
(1, 'ryu Jihak', 'Teman', 'Tidak', '2025-06-10 20:12:47'),
(2, 'Irfan Marcellino', 'Rekan', 'Tidak', '2025-06-11 11:30:19'),
(4, 'diska', 'Teman', 'Tidak', '2025-06-11 11:56:06'),
(8, 'Aimar Abie Pasah', 'Teman', 'Ya', '2025-06-11 12:21:40'),
(9, 'jejje nitra', 'Teman', 'Ya', '2025-06-11 12:22:16');

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
(4, 'admin', '$2y$10$/2kNk/RVXyftPQoMsNFKe.mzzMaUftJ/NuL.TTbU8v1Wc3r/ts732', 'admin', 1, '2025-06-11 04:35:41', '2025-06-11 04:35:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
