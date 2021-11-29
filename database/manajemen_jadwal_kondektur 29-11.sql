-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Nov 2021 pada 15.55
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

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
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `tanggal_jadwal` date DEFAULT NULL,
  `jam_mulai` varchar(5) DEFAULT NULL,
  `jam_selesai` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_pegawai`, `hari`, `tanggal_jadwal`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(6, 82, 'Selasa', '2021-11-02', '10:00', '17:00', '2021-11-11 07:50:30', '2021-11-11 07:50:30'),
(7, 80, 'Selasa', '2021-11-02', '10:00', '17:00', '2021-11-11 07:54:07', '2021-11-11 07:54:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2021_02_23_021334__table_user_', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
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
-- Dumping data untuk tabel `settings`
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
-- Struktur dari tabel `tukar_jadwal`
--

CREATE TABLE `tukar_jadwal` (
  `id_tukar_jadwal` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
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
-- Dumping data untuk tabel `tukar_jadwal`
--

INSERT INTO `tukar_jadwal` (`id_tukar_jadwal`, `id_jadwal`, `id_pegawai`, `hari_tukar`, `tanggal_jadwal_tukar`, `jam_mulai_tukar`, `jam_selesai_tukar`, `alasan`, `file_pendukung`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 82, 'Jumat', '2021-11-05', '10:00', '17:00', NULL, NULL, 'Ditolak', '2021-10-28 01:45:51', '2021-10-30 09:32:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `foto`, `phone`, `nip`, `pangkat`, `jabatan`, `token`, `remember_token`, `jenis_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(27, 'admin@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Admin Utama', 'admin.jpg', '+6281392339773', NULL, NULL, NULL, '5RBVUp6MRdN7Pkz8HFdI2g3dJrhVdw1K5VTUF5x4EeucUAAsgqLFysdoROHimlrvN19cM0tcHIXdpB48', '', 'admin', '2021-03-17 11:16:58', '2021-04-13 06:36:33', NULL),
(80, 'kondektur@gmail.com', '$2y$10$fok0uM6ja/ml6WF8SABwA.N99qgWdvbwngysNR2ukCq2LxA/cdWM2', 'Sucipto Mangunkusumo', '1634972403660.jpg', '089666262', '0001', 'PT1', 'KDR', NULL, NULL, 'user', '2021-10-23 00:00:03', '2021-10-23 00:25:28', NULL),
(81, 'kondektur2@gmail.com', '$2y$10$fok0uM6ja/ml6WF8SABwA.N99qgWdvbwngysNR2ukCq2LxA/cdWM2', 'Zoro', '1634972403660.jpg', '089666262', '0001', 'PT2', 'KDR', NULL, NULL, 'user', '2021-10-23 00:00:03', '2021-10-23 00:30:47', '2021-10-23 07:30:47'),
(82, 'dekker@gmail.com', '$2y$10$R5XVGECFj40JxgsEgLvUROw/Kd5/KPG8XXC88MFy87wIwvTvpd2IS', 'Douwes Dekker', '1635175914612.jpg', '081292929292', '0002', 'PND1', 'KDR', NULL, NULL, 'user', '2021-10-25 08:31:54', '2021-10-25 08:31:54', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tukar_jadwal`
--
ALTER TABLE `tukar_jadwal`
  ADD PRIMARY KEY (`id_tukar_jadwal`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tukar_jadwal`
--
ALTER TABLE `tukar_jadwal`
  MODIFY `id_tukar_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
