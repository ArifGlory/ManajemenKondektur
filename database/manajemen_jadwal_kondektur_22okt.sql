-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2021 at 05:37 PM
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
(6, 'email', 'tapisdev@gmail.com', 1, 1, NULL, NULL),
(7, 'telephone', '089662240052', 1, 1, NULL, NULL),
(8, 'fax', '-', 1, 1, NULL, NULL),
(9, 'address', 'Indonesia', 1, 1, NULL, NULL),
(12, 'facebook', '-', 1, 1, NULL, NULL),
(13, 'twitter', '-', 1, 1, NULL, NULL),
(14, 'instagram', '-', 1, 1, NULL, NULL),
(15, 'youtube', '-', 1, 1, NULL, NULL),
(16, '_token', 'KjGQIrMjVwwiLkzxbhSnNg83984A9e4LPCNBeiaV', 1, 1, NULL, NULL),
(17, 'logo', 'img/1616861409198.jpg', 1, 1, NULL, NULL),
(18, 'favicon', 'img/1616861409204.jpg', 1, 1, NULL, NULL);

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

INSERT INTO `users` (`id`, `email`, `password`, `name`, `foto`, `phone`, `nip`, `pangkat`, `jabatan`, `token`, `remember_token`, `jenis_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(27, 'tapisdev@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Admin Utama', '1616087708748.bmp', '+6281392339773', NULL, NULL, NULL, '5RBVUp6MRdN7Pkz8HFdI2g3dJrhVdw1K5VTUF5x4EeucUAAsgqLFysdoROHimlrvN19cM0tcHIXdpB48', '', 'admin', '2021-03-17 11:16:58', '2021-04-13 06:36:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
