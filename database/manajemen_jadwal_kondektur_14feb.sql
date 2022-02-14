-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2022 at 04:11 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manajemen_jadwal_kondektur`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_kereta` int(11) DEFAULT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `tanggal_jadwal` date DEFAULT NULL,
  `jam_mulai` varchar(5) DEFAULT NULL,
  `jam_selesai` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_pegawai`, `id_kereta`, `hari`, `tanggal_jadwal`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(6, 82, 1, 'Sabtu', '2021-12-11', '10:00', '20:00', '2021-11-11 07:50:30', '2021-12-03 21:08:27'),
(7, 80, 1, 'Selasa', '2022-02-05', '10:00', '17:00', '2021-11-11 07:54:07', '2022-02-04 05:38:21'),
(8, 82, 2, 'Sabtu', '2021-12-25', '11:00', '21:00', '2021-11-11 07:50:30', '2021-12-03 21:57:34'),
(9, 80, 2, 'Jumat', '2021-12-17', '15:02', '21:02', '2021-12-14 07:01:14', '2021-12-14 07:07:25'),
(11, 81, 1, 'Selasa', '2022-02-15', '10:10', '22:10', '2022-02-13 21:13:12', '2022-02-13 21:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `kereta`
--

CREATE TABLE `kereta` (
  `id_kereta` int(11) NOT NULL,
  `nomor_kereta` varchar(100) DEFAULT NULL,
  `nama_kereta` varchar(150) DEFAULT NULL,
  `kelas_kereta` varchar(100) DEFAULT NULL,
  `deskripsi_kereta` text DEFAULT NULL COMMENT 'relasi kereta',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kereta`
--

INSERT INTO `kereta` (`id_kereta`, `nomor_kereta`, `nama_kereta`, `kelas_kereta`, `deskripsi_kereta`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'K-01', 'Kereta Rajabasa', 'Bisnis', 'KA S6 relasi TNK-BTA', '2021-12-14 06:54:38', '2022-02-14 08:08:42', NULL),
(2, 'K-02', 'Kereta Sai Bumi', 'Ekonomi', 'KA S5 relasi BTA-TNK', '2021-12-14 06:55:45', '2022-02-14 08:08:49', NULL),
(3, 'K-03', 'Kereta Sai Sriwijaya', 'Ekonomi', 'SA1 ke TNBK', '2022-02-14 08:09:37', '2022-02-14 08:09:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2021_02_23_021334__table_user_', 1);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_jadwal`
--

CREATE TABLE `riwayat_jadwal` (
  `id_riwayat_jadwal` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `tanggal_jadwal` date DEFAULT NULL,
  `jam_mulai` varchar(5) DEFAULT NULL,
  `jam_selesai` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `riwayat_jadwal`
--

INSERT INTO `riwayat_jadwal` (`id_riwayat_jadwal`, `id_pegawai`, `hari`, `tanggal_jadwal`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(9, 82, 'Selasa', '2021-12-07', '15:00', '22:00', '2021-12-04 04:26:19', NULL),
(15, 82, 'Jumat', '2021-12-03', '09:00', '15:00', '2021-12-03 21:57:34', '2021-12-03 21:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_by` int(10) NOT NULL DEFAULT 1,
  `updated_by` int(10) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'web_name', 'Manajemen Kondektur', 1, 1, NULL, NULL),
(2, 'web_url', 'https://nyantri.net/', 1, 1, NULL, NULL),
(3, 'web_description', 'Aplikasi Manajemen Kondektur KAI', 1, 1, NULL, NULL),
(4, 'web_keyword', 'Manajemen Kondektur', 1, 1, NULL, NULL),
(5, 'web_owner', 'Hermawan', 1, 1, NULL, NULL),
(6, 'email', 'admin@gmail.com', 1, 1, NULL, NULL),
(7, 'telephone', '089662240052', 1, 1, NULL, NULL),
(8, 'fax', '-', 1, 1, NULL, NULL),
(9, 'address', 'Indonesia', 1, 1, NULL, NULL),
(12, 'facebook', '-', 1, 1, NULL, NULL),
(13, 'twitter', '-', 1, 1, NULL, NULL),
(14, 'instagram', '-', 1, 1, NULL, NULL),
(15, 'youtube', '-', 1, 1, NULL, NULL),
(16, '_token', 'JmzEXTDs41zSlU4o6n5Lu9Qf8FeNXBjIoE3pXlim', 1, 1, NULL, NULL),
(17, 'logo', 'img/1616861409198.jpg', 1, 1, NULL, NULL),
(18, 'favicon', 'img/1616861409204.jpg', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tukar_jadwal`
--

CREATE TABLE `tukar_jadwal` (
  `id_tukar_jadwal` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_riwayat_jadwal` int(11) DEFAULT NULL,
  `hari_tukar` varchar(100) DEFAULT NULL,
  `tanggal_jadwal_tukar` date DEFAULT NULL,
  `jam_mulai_tukar` varchar(5) DEFAULT NULL,
  `jam_selesai_tukar` varchar(5) DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `file_pendukung` varchar(150) DEFAULT NULL,
  `status` enum('Diterima','Ditolak','Menunggu') NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tukar_jadwal`
--

INSERT INTO `tukar_jadwal` (`id_tukar_jadwal`, `id_jadwal`, `id_pegawai`, `id_riwayat_jadwal`, `hari_tukar`, `tanggal_jadwal_tukar`, `jam_mulai_tukar`, `jam_selesai_tukar`, `alasan`, `file_pendukung`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 82, NULL, 'Jumat', '2021-11-05', '10:00', '17:00', NULL, NULL, 'Ditolak', '2021-10-28 01:45:51', '2021-10-30 09:32:11'),
(3, 6, 82, 9, 'Sabtu', '2021-12-11', '10:00', '20:00', 'Sakit', '1638589430387.png', 'Diterima', '2021-12-03 20:43:50', '2021-12-03 21:08:27'),
(4, 8, 82, 15, 'Sabtu', '2021-12-25', '11:00', '21:00', 'Males aja sih', NULL, 'Diterima', '2021-12-03 20:44:55', '2021-12-03 21:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pangkat` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_jabatan` int(11) NOT NULL DEFAULT 3 COMMENT '1 : kepala upt, 2: penyelia , 3 : kondektur',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_user` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `foto`, `phone`, `nip`, `pangkat`, `jabatan`, `level_jabatan`, `token`, `remember_token`, `jenis_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(27, 'admin@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'BJ Habibi', '1644850440626.png', '+6281392339773', '0011', 'STR1', 'KUPT', 1, '5RBVUp6MRdN7Pkz8HFdI2g3dJrhVdw1K5VTUF5x4EeucUAAsgqLFysdoROHimlrvN19cM0tcHIXdpB48', '', 'admin', '2021-03-17 11:16:58', '2022-02-14 07:54:00', NULL),
(80, 'kondektur@gmail.com', '$2y$10$fok0uM6ja/ml6WF8SABwA.N99qgWdvbwngysNR2ukCq2LxA/cdWM2', 'Sucipto Mangunkusumo', '1634972403660.jpg', '089666262', '0001', 'PT1', 'LIA', 2, NULL, NULL, 'user', '2021-10-23 00:00:03', '2021-10-23 00:25:28', NULL),
(82, 'dekker@gmail.com', '$2y$10$R5XVGECFj40JxgsEgLvUROw/Kd5/KPG8XXC88MFy87wIwvTvpd2IS', 'Douwes Dekker', '1635175914612.jpg', '081292929292', '0002', 'PND1', 'KDR', 3, NULL, NULL, 'user', '2021-10-25 08:31:54', '2021-10-25 08:31:54', NULL),
(84, 'kondektur2@gmail.com', '$2y$10$jTvFCQoR2EBlqcsRD8FvGOH0aEpUcwJvMftpxK4/O5d460i8iLfCO', 'Sanji', '1644812088351.png', '08928282', '0003', 'KDR', 'KDR', 3, NULL, NULL, 'user', '2022-02-13 21:14:48', '2022-02-13 21:14:48', NULL),
(86, 'nami@gmail.com', '$2y$10$4dcI..uzNjPnfoOHRC2uy.Uki2bapHLvoAnEIFwzvZQPNzyGh78aC', 'Nami', '1644851056996.jpg', '028282929', '0004', 'STR2', 'LIA', 2, NULL, NULL, 'user', '2022-02-14 08:04:17', '2022-02-14 08:04:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `kereta`
--
ALTER TABLE `kereta`
  ADD PRIMARY KEY (`id_kereta`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_jadwal`
--
ALTER TABLE `riwayat_jadwal`
  ADD PRIMARY KEY (`id_riwayat_jadwal`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tukar_jadwal`
--
ALTER TABLE `tukar_jadwal`
  ADD PRIMARY KEY (`id_tukar_jadwal`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kereta`
--
ALTER TABLE `kereta`
  MODIFY `id_kereta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_jadwal`
--
ALTER TABLE `riwayat_jadwal`
  MODIFY `id_riwayat_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tukar_jadwal`
--
ALTER TABLE `tukar_jadwal`
  MODIFY `id_tukar_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
