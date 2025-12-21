-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 21, 2025 at 12:32 AM
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
-- Database: `app_manajemen_keuangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id_notif` int NOT NULL,
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('sent','failed') DEFAULT 'failed',
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id_notif`, `user_id`, `email`, `subject`, `message`, `status`, `is_read`, `created_at`) VALUES
(6, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'UKT jatuh tempo dalam 3 hari', 'sent', 1, '2025-12-12 03:51:38'),
(7, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'H-3 bayar UKT', 'sent', 1, '2025-12-12 11:45:03'),
(8, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'H-3', 'sent', 1, '2025-12-12 11:49:25'),
(9, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'H-3 WOIII.', 'sent', 1, '2025-12-12 12:22:26'),
(10, 11, 'irfan.fathurrohman2006@gmail.com', 'Bayaran Kos', 'H-2 bayar koss', 'sent', 1, '2025-12-17 07:38:44'),
(12, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'Tagihan UKT mu jatuh tempo dalam 3 hari.', 'sent', 1, '2025-12-18 13:33:44'),
(13, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'H-3 WOII', 'sent', 1, '2025-12-19 11:48:58'),
(15, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'H-3 BAYAR UKT.', 'sent', 1, '2025-12-20 05:33:52'),
(16, 11, 'irfan.fathurrohman2006@gmail.com', 'Bayaran Kos', 'Halo Irfan Fathurrohman.\r\n\r\nTagihan bayaran kost kamu akan jatuh tempo dalam 3 hari lagi.SEgera bayar kost mu sebelum jatuh tempo.', 'failed', 1, '2025-12-20 13:34:18'),
(17, 11, 'irfan.fathurrohman2006@gmail.com', 'Tagihan UKT', 'H-3', 'sent', 0, '2025-12-20 14:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expired_at`, `created_at`) VALUES
(8, 11, '3364d0de3b60fb6979e18f5a75d5b6d03973b221260ff1346f47655ab5ac772c', '2025-12-19 20:22:58', '2025-12-19 12:22:58'),
(9, 11, '2482cd3298a01a69cca5dd04cf651ba72c3c58d16f9d78977795a0231c9346e3', '2025-12-19 20:44:17', '2025-12-19 12:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_rutin`
--

CREATE TABLE `pengeluaran_rutin` (
  `id_pr` int NOT NULL,
  `user_id` int NOT NULL,
  `nama_pengeluaran` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nominal` int NOT NULL,
  `tgl_jatuh_tempo` date NOT NULL,
  `frekuensi` enum('bulanan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengeluaran_rutin`
--

INSERT INTO `pengeluaran_rutin` (`id_pr`, `user_id`, `nama_pengeluaran`, `nominal`, `tgl_jatuh_tempo`, `frekuensi`) VALUES
(5, 11, 'Bayar UKT', 1550000, '2025-12-10', 'bulanan'),
(10, 11, 'Bayar UKT', 15, '2025-03-22', 'bulanan'),
(11, 11, 'Bayar UKT', 15, '2006-07-22', 'bulanan'),
(12, 11, 'Bayar UKT', 10000, '2006-02-20', 'bulanan');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int NOT NULL,
  `nim` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Program_studi` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `nim`, `username`, `Email`, `Program_studi`, `password`, `role`) VALUES
(9, '20241222', 'admin', 'admin@gmail.com', '-', '$2y$10$TuNZstUyest75j3NkRp.ouB58eMKH3nXaOoQx5KAp/NMDTAuUfBdO', 'admin'),
(11, '24416255201187', 'Irfan Fathurrohman', 'irfan.fathurrohman2006@gmail.com', 'Bisnis Digital', '$2y$10$p6sY.4Zu7/dfV45LDDdECOJbAWHwbr04or10BXtj1QzfcwvB4yYU2', 'mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `user_id` int NOT NULL,
  `nama_transaksi` varchar(100) NOT NULL,
  `nominal` int NOT NULL,
  `mata_uang` varchar(10) DEFAULT 'IDR',
  `kurs_rate` double DEFAULT '1',
  `nominal_idr` double NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `user_id`, `nama_transaksi`, `nominal`, `mata_uang`, `kurs_rate`, `nominal_idr`, `kategori`, `tanggal`, `keterangan`) VALUES
(8, 11, 'bensin', 1, 'USD', 1, 1, 'Transportasi', '2025-12-08', '-'),
(9, 11, 'bensin', 1, 'SGD', 1, 1, 'Transportasi', '2025-12-07', '-'),
(10, 11, 'makan', 5, 'SGD', 12850.6336, 64253.168, 'Makanan', '2025-12-08', '-'),
(11, 11, 'print tugas', 1, 'SGD', 12871.3495, 12871.3495, 'Lainnya', '2025-12-13', '-'),
(12, 11, 'uang saku', 20, 'SGD', 12871.3495, 257426.99, 'Pemasukan', '2025-12-13', '-'),
(13, 11, 'jajan', 2, 'USD', 16635.3237, 33270.6474, 'Lainnya', '2025-12-13', '-'),
(14, 11, 'bensin', 1, 'SGD', 12886.6763, 12886.6763, 'Transportasi', '2025-12-15', '-'),
(15, 11, 'uang saku', 1000000, 'IDR', 1, 1000000, 'Pemasukan', '2025-10-15', '-'),
(16, 11, 'Sarapan', 1, 'SGD', 12964.1562, 12964.1562, 'Makanan', '2025-12-17', '-'),
(17, 11, 'bensin', 1, 'SGD', 12974.791, 12974.791, 'Transportasi', '2025-12-19', '-'),
(18, 11, 'bensin', 2, 'JPY', 107.5453, 215.0906, 'Transportasi', '2025-12-19', '-'),
(19, 11, 'UKT', 20, 'EUR', 19629.2656, 392585.312, 'Pendidikan', '2025-12-19', '-'),
(20, 11, 'Sarapan', 1, 'THB', 532.41, 532.41, 'Makanan', '2025-12-19', '-'),
(21, 11, 'Print Tugas', 2, 'KRW', 11.3383, 22.6766, 'Lainnya', '2025-12-19', ''),
(22, 11, 'Print Laporan', 3, 'AUD', 11060.88, 33182.64, 'Lainnya', '2025-12-19', '-'),
(23, 11, 'Print Laporan', 5, 'USD', 16729.202, 83646.01, 'Lainnya', '2025-12-19', '-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `notifications` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengeluaran_rutin`
--
ALTER TABLE `pengeluaran_rutin`
  ADD PRIMARY KEY (`id_pr`),
  ADD KEY `pengeluaran_rutin` (`user_id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengeluaran_rutin`
--
ALTER TABLE `pengeluaran_rutin`
  MODIFY `id_pr` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications` FOREIGN KEY (`user_id`) REFERENCES `profil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets` FOREIGN KEY (`user_id`) REFERENCES `profil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengeluaran_rutin`
--
ALTER TABLE `pengeluaran_rutin`
  ADD CONSTRAINT `pengeluaran_rutin` FOREIGN KEY (`user_id`) REFERENCES `profil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi` FOREIGN KEY (`user_id`) REFERENCES `profil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
