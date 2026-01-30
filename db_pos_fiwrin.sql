-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 06:39 PM
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
-- Database: `db_pos_fiwrin`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1769582382),
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1769582382;', 1769582382),
('laravel-cache-ml_prediction_data', 'a:6:{s:15:\"prediction_type\";s:6:\"weekly\";s:9:\"num_weeks\";i:4;s:10:\"chart_data\";a:2:{s:6:\"labels\";a:4:{i:0;s:8:\"Minggu 1\";i:1;s:8:\"Minggu 2\";i:2;s:8:\"Minggu 3\";i:3;s:8:\"Minggu 4\";}s:6:\"values\";a:4:{i:0;i:9;i:1;i:16;i:2;i:27;i:3;i:24;}}s:12:\"restock_data\";a:8:{i:0;a:3:{s:8:\"kategori\";s:12:\"Celana Kulot\";s:3:\"qty\";i:12;s:10:\"weekly_avg\";d:3;}i:1;a:3:{s:8:\"kategori\";s:13:\"Celana Skinny\";s:3:\"qty\";i:11;s:10:\"weekly_avg\";d:2.8;}i:2;a:3:{s:8:\"kategori\";s:10:\"Rok A-Line\";s:3:\"qty\";i:10;s:10:\"weekly_avg\";d:2.5;}i:3;a:3:{s:8:\"kategori\";s:9:\"Rok Kargo\";s:3:\"qty\";i:10;s:10:\"weekly_avg\";d:2.5;}i:4;a:3:{s:8:\"kategori\";s:12:\"Celana Baggy\";s:3:\"qty\";i:9;s:10:\"weekly_avg\";d:2.2;}i:5;a:3:{s:8:\"kategori\";s:9:\"Rok Serut\";s:3:\"qty\";i:9;s:10:\"weekly_avg\";d:2.2;}i:6;a:3:{s:8:\"kategori\";s:8:\"Rok Span\";s:3:\"qty\";i:9;s:10:\"weekly_avg\";d:2.2;}i:7;a:3:{s:8:\"kategori\";s:14:\"Celana Cutbray\";s:3:\"qty\";i:6;s:10:\"weekly_avg\";d:1.5;}}s:13:\"weekly_detail\";a:4:{i:0;a:6:{s:10:\"week_label\";s:8:\"Minggu 1\";s:4:\"year\";i:2026;s:11:\"week_number\";i:6;s:10:\"start_date\";s:10:\"2026-02-04\";s:5:\"total\";i:9;s:11:\"by_category\";a:8:{s:12:\"Celana Kulot\";i:2;s:14:\"Celana Cutbray\";i:1;s:10:\"Rok A-Line\";i:1;s:13:\"Celana Skinny\";i:1;s:12:\"Celana Baggy\";i:1;s:9:\"Rok Serut\";i:1;s:8:\"Rok Span\";i:1;s:9:\"Rok Kargo\";i:1;}}i:1;a:6:{s:10:\"week_label\";s:8:\"Minggu 2\";s:4:\"year\";i:2026;s:11:\"week_number\";i:7;s:10:\"start_date\";s:10:\"2026-02-11\";s:5:\"total\";i:16;s:11:\"by_category\";a:8:{s:12:\"Celana Kulot\";i:2;s:14:\"Celana Cutbray\";i:1;s:10:\"Rok A-Line\";i:2;s:13:\"Celana Skinny\";i:3;s:12:\"Celana Baggy\";i:2;s:9:\"Rok Serut\";i:2;s:8:\"Rok Span\";i:2;s:9:\"Rok Kargo\";i:2;}}i:2;a:6:{s:10:\"week_label\";s:8:\"Minggu 3\";s:4:\"year\";i:2026;s:11:\"week_number\";i:8;s:10:\"start_date\";s:10:\"2026-02-18\";s:5:\"total\";i:27;s:11:\"by_category\";a:8:{s:12:\"Celana Kulot\";i:4;s:14:\"Celana Cutbray\";i:2;s:10:\"Rok A-Line\";i:4;s:13:\"Celana Skinny\";i:4;s:12:\"Celana Baggy\";i:3;s:9:\"Rok Serut\";i:3;s:8:\"Rok Span\";i:3;s:9:\"Rok Kargo\";i:4;}}i:3;a:6:{s:10:\"week_label\";s:8:\"Minggu 4\";s:4:\"year\";i:2026;s:11:\"week_number\";i:9;s:10:\"start_date\";s:10:\"2026-02-25\";s:5:\"total\";i:24;s:11:\"by_category\";a:8:{s:12:\"Celana Kulot\";i:4;s:14:\"Celana Cutbray\";i:2;s:10:\"Rok A-Line\";i:3;s:13:\"Celana Skinny\";i:3;s:12:\"Celana Baggy\";i:3;s:9:\"Rok Serut\";i:3;s:8:\"Rok Span\";i:3;s:9:\"Rok Kargo\";i:3;}}}s:16:\"model_evaluation\";a:9:{s:11:\"mae_xgboost\";d:1;s:12:\"rmse_xgboost\";d:1.224744871391589;s:13:\"smape_xgboost\";d:42.884820889964885;s:12:\"mae_baseline\";d:1.875;s:13:\"rmse_baseline\";d:2.1866069605669876;s:14:\"smape_baseline\";d:183.00653594771242;s:15:\"improvement_mae\";d:46.666666666666664;s:16:\"improvement_rmse\";d:43.988796638879606;s:17:\"improvement_smape\";d:76.56650858512634;}}', 1769668706);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` varchar(30) NOT NULL,
  `transaksi_id` varchar(30) NOT NULL,
  `produk_id` varchar(20) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga_satuan_deal` decimal(12,0) NOT NULL,
  `harga_modal` decimal(12,0) DEFAULT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `nominal_diskon` decimal(12,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `jumlah_beli`, `harga_satuan_deal`, `harga_modal`, `subtotal`, `nominal_diskon`, `created_at`, `updated_at`) VALUES
('DTL2igHUJrqsAJJbTK', 'TRX20251226017', 'PRD009', 1, 170000, 90000, 170000, 0, '2025-12-26 12:37:15', '2025-12-26 12:37:15'),
('DTL2RIU36opxVqHxrZ', 'TRX20260106001', 'PRD010', 1, 165000, 100000, 165000, 0, '2026-01-06 04:51:37', '2026-01-06 04:51:37'),
('DTL2Xob3x9k96Ibod1', 'TRX20251226001', 'PRD015', 1, 110000, 75000, 110000, 5000, '2025-12-25 18:44:04', '2025-12-25 18:44:04'),
('DTL4HCtorQRctm8nHN', 'TRX20251226010', 'PRD010', 1, 150000, 100000, 150000, 15000, '2025-12-26 12:06:57', '2025-12-26 12:06:57'),
('DTL5tlhg7vcehqooRG', 'TRX20260118001', 'PRD005', 1, 120000, 70000, 120000, 0, '2026-01-18 11:10:56', '2026-01-18 11:10:56'),
('DTL5y0BAw2vXVJgGP8', 'TRX20251222004', 'PRD001', 1, 130000, 75000, 130000, 0, '2025-12-22 08:57:47', '2025-12-22 08:57:47'),
('DTL6vB5G9FFLqbm9uY', 'TRX20251226016', 'PRD013', 1, 130000, 70000, 130000, 0, '2025-12-26 12:37:03', '2025-12-26 12:37:03'),
('DTL7dF91km7FGzkw8W', 'TRX20260106003', 'PRD011', 1, 130000, 80000, 130000, 5000, '2026-01-06 07:27:25', '2026-01-06 07:27:25'),
('DTL9pF4xGKjWUbLvOi', 'TRX20251222002', 'PRD005', 1, 120000, 70000, 120000, 0, '2025-12-22 08:08:05', '2025-12-22 08:08:05'),
('DTLaLuB9igBeNcmtTN', 'TRX20260123001', 'PRD013', 1, 120000, 70000, 120000, 10000, '2026-01-23 07:13:54', '2026-01-23 07:13:54'),
('DTLaqAE9VbgLORKSaU', 'TRX20251222001', 'PRD001', 1, 130000, 75000, 130000, 0, '2025-12-22 08:07:14', '2025-12-22 08:07:14'),
('DTLbj4O36fVyezopAu', 'TRX20260106002', 'PRD014', 1, 145000, 90000, 145000, 0, '2026-01-06 04:52:27', '2026-01-06 04:52:27'),
('DTLBut34XgfyE4bFC0', 'TRX20251226002', 'PRD015', 1, 115000, 75000, 115000, 0, '2025-12-25 19:52:56', '2025-12-25 19:52:56'),
('DTLC9vBQAfzf1ZUzKb', 'TRX20251226009', 'PRD006', 1, 110000, 75000, 110000, 0, '2025-12-26 12:05:21', '2025-12-26 12:05:21'),
('DTLcbkQpxwW8RbHZ2J', 'TRX20251226004', 'PRD009', 1, 170000, 90000, 170000, 0, '2025-12-26 07:29:40', '2025-12-26 07:29:40'),
('DTLDRfhC202wvF9JLp', 'TRX20251226022', 'PRD013', 1, 130000, 70000, 130000, 0, '2025-12-26 12:53:24', '2025-12-26 12:53:24'),
('DTLEZTAojii6BNgUYl', 'TRX20251226013', 'PRD006', 1, 110000, 75000, 110000, 0, '2025-12-26 12:33:21', '2025-12-26 12:33:21'),
('DTLG6D4nNtNZ2TMfXe', 'TRX20251226019', 'PRD007', 1, 130000, 80000, 130000, 0, '2025-12-26 12:38:35', '2025-12-26 12:38:35'),
('DTLgxlxrHJgeD1P8Ri', 'TRX20260126002', 'PRD007', 1, 130000, 80000, 130000, 0, '2026-01-26 16:54:57', '2026-01-26 16:54:57'),
('DTLHgvZC5T1YsOuJxa', 'TRX20251223001', 'PRD004', 1, 150000, 100000, 150000, 0, '2025-12-23 04:43:38', '2025-12-23 04:43:38'),
('DTLiApb4l7iUI0HfP2', 'TRX20251222003', 'PRD005', 1, 100000, 70000, 100000, 20000, '2025-12-22 08:08:31', '2025-12-22 08:08:31'),
('DTLj0RW2aWQmRhEvNV', 'TRX20260128001', 'PRD006', 1, 110000, 75000, 110000, 0, '2026-01-28 06:39:15', '2026-01-28 06:39:15'),
('DTLK1Hev3Idq65hoNb', 'TRX20251226014', 'PRD008', 1, 115000, 70000, 115000, 0, '2025-12-26 12:33:34', '2025-12-26 12:33:34'),
('DTLkNaQKmI1LQ8ya3E', 'TRX20260126001', 'PRD006', 1, 110000, 75000, 110000, 0, '2026-01-26 16:54:44', '2026-01-26 16:54:44'),
('DTLkNVKvhzcBhTpooe', 'TRX20251226021', 'PRD005', 2, 120000, 70000, 240000, 0, '2025-12-26 12:52:29', '2025-12-26 12:52:29'),
('DTLLAigU1YyW383h5W', 'TRX20251226020', 'PRD015', 1, 115000, 75000, 115000, 0, '2025-12-26 12:47:25', '2025-12-26 12:47:25'),
('DTLmdWosE2WKWf4qUV', 'TRX20251226011', 'PRD016', 1, 130000, 90000, 130000, 5000, '2025-12-26 12:08:35', '2025-12-26 12:08:35'),
('DTLmEXML32yu6PiPC1', 'TRX20251226005', 'PRD016', 1, 135000, 90000, 135000, 0, '2025-12-26 10:52:11', '2025-12-26 10:52:11'),
('DTLMGoQOSOWkW9DlWo', 'TRX20251226007', 'PRD009', 2, 150000, 90000, 300000, 40000, '2025-12-26 11:43:37', '2025-12-26 11:43:37'),
('DTLmnbfXhDdOYP6fdR', 'TRX20251226012', 'PRD011', 1, 130000, 80000, 130000, 5000, '2025-12-26 12:27:48', '2025-12-26 12:27:48'),
('DTLNjCyYDagj8kYxPG', 'TRX20251226002', 'PRD010', 1, 165000, 100000, 165000, 0, '2025-12-25 19:52:56', '2025-12-25 19:52:56'),
('DTLODjJqa172MivXHG', 'TRX20251223002', 'PRD009', 1, 170000, 90000, 170000, 0, '2025-12-23 08:42:19', '2025-12-23 08:42:19'),
('DTLOUWIDwYxfT0d7fI', 'TRX20251226002', 'PRD001', 1, 100000, 75000, 100000, 30000, '2025-12-25 19:52:56', '2025-12-25 19:52:56'),
('DTLPYOc2ldIqIpI9lH', 'TRX20251226002', 'PRD004', 1, 150000, 100000, 150000, 0, '2025-12-25 19:52:56', '2025-12-25 19:52:56'),
('DTLqijp3XLK3Z5ltby', 'TRX20251226022', 'PRD012', 1, 140000, 90000, 140000, 0, '2025-12-26 12:53:24', '2025-12-26 12:53:24'),
('DTLQVRNjSbxmyszedf', 'TRX20251226012', 'PRD004', 1, 150000, 100000, 150000, 0, '2025-12-26 12:27:48', '2025-12-26 12:27:48'),
('DTLr8FNMn2WphSs03v', 'TRX20260106003', 'PRD005', 1, 120000, 70000, 120000, 0, '2026-01-06 07:27:25', '2026-01-06 07:27:25'),
('DTLsePLfLTwyAmKqxi', 'TRX20260120001', 'PRD004', 1, 150000, 100000, 150000, 0, '2026-01-20 08:51:03', '2026-01-20 08:51:03'),
('DTLsnL5Uifol3uM4ij', 'TRX20251223003', 'PRD010', 1, 165000, 100000, 165000, 0, '2025-12-23 09:04:13', '2025-12-23 09:04:13'),
('DTLTa3aeKe4G0KLiJ7', 'TRX20251226015', 'PRD001', 1, 130000, 75000, 130000, 0, '2025-12-26 12:35:52', '2025-12-26 12:35:52'),
('DTLtlGmh93WrUZryqp', 'TRX20251222004', 'PRD005', 2, 110000, 70000, 220000, 20000, '2025-12-22 08:57:47', '2025-12-22 08:57:47'),
('DTLTLKsq52GDGwGF4l', 'TRX20251222004', 'PRD004', 1, 150000, 100000, 150000, 0, '2025-12-22 08:57:47', '2025-12-22 08:57:47'),
('DTLUcPaGz8QxyWxhLQ', 'TRX20251226008', 'PRD017', 1, 100000, 70000, 100000, 5000, '2025-12-26 11:59:21', '2025-12-26 11:59:21'),
('DTLvCDnMVcTuNQHwI1', 'TRX20251226006', 'PRD013', 1, 130000, 70000, 130000, 0, '2025-12-26 10:59:22', '2025-12-26 10:59:22'),
('DTLvPsRQwX2bCqDmIk', 'TRX20251222003', 'PRD004', 1, 150000, 100000, 150000, 0, '2025-12-22 08:08:31', '2025-12-22 08:08:31'),
('DTLW3txThtfKt7ZWho', 'TRX20251226018', 'PRD015', 1, 115000, 75000, 115000, 0, '2025-12-26 12:38:18', '2025-12-26 12:38:18'),
('DTLWP51TnjEL5OiWGE', 'TRX20260126003', 'PRD006', 1, 110000, 75000, 110000, 0, '2026-01-26 16:58:48', '2026-01-26 16:58:48'),
('DTLxIuh19S66gLlrHH', 'TRX20260120001', 'PRD009', 1, 170000, 90000, 170000, 0, '2026-01-20 08:51:03', '2026-01-20 08:51:03'),
('DTLyANM5WC7VdlaxKA', 'TRX20251226002', 'PRD009', 1, 170000, 90000, 170000, 0, '2025-12-25 19:52:56', '2025-12-25 19:52:56'),
('DTLyQUrWxqHvq32HXu', 'TRX20251222002', 'PRD001', 1, 130000, 75000, 130000, 0, '2025-12-22 08:08:05', '2025-12-22 08:08:05'),
('DTLZr8aMjNXze1Y696', 'TRX20251226003', 'PRD009', 1, 170000, 90000, 170000, 0, '2025-12-26 07:24:49', '2025-12-26 07:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` varchar(20) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `created_at`, `updated_at`, `deleted_at`) VALUES
('KAT001', 'Rok Panjang', '2025-12-20 06:57:17', '2025-12-23 05:01:40', '2025-12-23 05:01:40'),
('KAT002', 'Celana Cutbray', '2025-12-20 11:36:41', '2025-12-23 04:28:12', NULL),
('KAT003', 'Celana Kulot', '2025-12-23 04:33:31', '2025-12-23 04:33:31', NULL),
('KAT004', 'Celana Skinny', '2025-12-23 04:33:56', '2025-12-23 04:33:56', NULL),
('KAT005', 'Celana Baggy', '2025-12-23 04:34:15', '2025-12-23 04:34:15', NULL),
('KAT006', 'Rok Span', '2025-12-23 04:36:54', '2025-12-23 04:36:54', NULL),
('KAT007', 'Rok A-Line', '2025-12-23 04:37:11', '2025-12-23 04:37:11', NULL),
('KAT008', 'Rok Serut', '2025-12-23 04:37:37', '2025-12-23 04:37:37', NULL),
('KAT009', 'Rok Celana', '2025-12-23 04:38:27', '2025-12-23 04:38:27', NULL),
('KAT010', 'Rok Plisket', '2025-12-23 04:38:54', '2025-12-23 04:38:54', NULL),
('KAT011', 'Rok Lilit', '2025-12-23 04:39:51', '2025-12-23 04:39:51', NULL),
('KAT012', 'Rok Kargo', '2025-12-23 04:40:04', '2025-12-23 04:40:04', NULL),
('KAT013', 'test', '2026-01-26 16:57:18', '2026-01-26 16:57:35', '2026-01-26 16:57:35'),
('KAT014', 'lala', '2026-01-26 16:57:46', '2026-01-26 16:57:56', '2026-01-26 16:57:56'),
('KAT015', 'aa', '2026-01-26 17:05:13', '2026-01-26 17:05:21', '2026-01-26 17:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_12_20_125227_create_master_pos_tables', 1),
(2, '2025_12_20_132234_create_cache_table', 2),
(3, '2025_12_20_191323_add_soft_deletes_to_pengguna_table', 3),
(4, '2025_12_22_050918_add_deleted_at_to_transaksi_table', 4),
(5, '2025_12_22_145916_add_bayar_kembali_to_transaksi', 5),
(6, '2025_12_23_113233_add_deleted_at_to_kategoris_table', 6),
(7, '2025_12_30_015321_add_pengguna_id_to_request_pelanggan_table', 7),
(8, '2026_01_18_195044_add_tipe_size_to_produk_table', 8),
(9, '2026_01_23_150144_add_deleted_at_to_request_pelanggan_table', 9),
(10, '2026_01_26_232900_add_harga_modal_and_payment_methods', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` enum('pemilik','karyawan') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `password`, `peran`, `created_at`, `updated_at`, `deleted_at`) VALUES
('USR001', 'Kamal Admin', 'admin@fiwrin.com', '$2y$12$ESC63S3UzsiFU6M7oDtH4.XO7kO.RzTFnyX043r52yROOW6Z18bre', 'pemilik', '2025-12-20 06:15:47', '2025-12-20 12:08:31', NULL),
('USR002', 'kasir 1', 'kasir@fiwrin.com', '$2y$12$wsegoUSDp0jp04upuabi8.J9FWHljraDwdluuc3lgYihQBvSBZoZC', 'karyawan', '2025-12-20 12:13:55', '2026-01-26 17:22:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prediksi_penjualan`
--

CREATE TABLE `prediksi_penjualan` (
  `id` varchar(20) NOT NULL,
  `kategori_id` varchar(20) NOT NULL,
  `tanggal_target` date NOT NULL,
  `jumlah_prediksi` int(11) NOT NULL,
  `status_stok` enum('aman','waspada','kritis') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` varchar(20) NOT NULL,
  `kategori_id` varchar(20) NOT NULL,
  `tipe_size` enum('normal','jumbo') NOT NULL DEFAULT 'normal',
  `nama_barang` varchar(255) NOT NULL,
  `stok_saat_ini` int(11) NOT NULL DEFAULT 0,
  `harga_modal` decimal(12,0) NOT NULL,
  `harga_bandrol` decimal(12,0) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `tipe_size`, `nama_barang`, `stok_saat_ini`, `harga_modal`, `harga_bandrol`, `gambar`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PRD001', 'KAT006', 'normal', 'Rok Span Rempel', 9, 75000, 130000, 'produk/01KDNS3TVVQMWAH9D039G5QZK3.jpg', '2025-12-20 07:36:07', '2025-12-29 19:24:43', NULL),
('PRD004', 'KAT002', 'normal', 'Cutbray Jeans Highwaist', 10, 100000, 150000, 'produk/01KCYH2WNWKC25V28M6D4H27GY.jpeg', '2025-12-20 11:41:52', '2026-01-20 08:51:03', NULL),
('PRD005', 'KAT005', 'normal', 'Celana Skena', 12, 70000, 120000, 'produk/01KD2E6Z7C42HRGFJMCHERR6HQ.jpg', '2025-12-22 07:08:38', '2026-01-18 11:10:56', NULL),
('PRD006', 'KAT006', 'normal', 'Rok Span Panjang', 15, 75000, 110000, 'produk/01KD4P4M4JTGPZ8VNGJVKR0ZAC.jpg', '2025-12-23 04:05:38', '2026-01-28 06:39:15', NULL),
('PRD007', 'KAT006', 'normal', 'Rok Span Midi', 8, 80000, 130000, 'produk/01KD4RWJ4C5F6FR34SXWBXRT65.png', '2025-12-23 04:53:40', '2026-01-26 16:54:57', NULL),
('PRD008', 'KAT006', 'normal', 'Rok Span Pendek', 5, 70000, 115000, 'produk/01KD4S02KKA2GXVD5GQVKW43AQ.jpg', '2025-12-23 04:55:35', '2025-12-26 12:33:34', NULL),
('PRD009', 'KAT005', 'normal', 'Boyfriend Baggy Jeans', 3, 90000, 170000, 'produk/01KD4SPRPZDAM6A8NDQAGH8YT0.jpeg', '2025-12-23 05:07:58', '2026-01-20 08:51:03', NULL),
('PRD010', 'KAT005', 'jumbo', 'Street Baggy Cargo', 9, 100000, 170000, 'produk/01KD4THNJS060ZKVJ3BVHY33ST.jpeg', '2025-12-23 05:22:40', '2026-01-18 13:09:24', NULL),
('PRD011', 'KAT002', 'normal', 'Cutbray Scuba', 10, 80000, 135000, 'produk/01KD4TYMAP5S06W553KRPDVC7Y.jpg', '2025-12-23 05:29:45', '2026-01-06 07:27:25', NULL),
('PRD012', 'KAT003', 'jumbo', 'Kulot Linen Highwaist', 12, 90000, 150000, 'produk/01KD4V3M0TNH9R4K81J1B3HDRX.jpg', '2025-12-23 05:32:28', '2026-01-18 13:09:04', NULL),
('PRD013', 'KAT003', 'jumbo', 'Kulot Crinkle Airflow', 6, 70000, 130000, 'produk/01KD4V73V6FVC7QVX310QWQYGN.JPEG', '2025-12-23 05:34:23', '2026-01-23 07:13:54', NULL),
('PRD014', 'KAT004', 'normal', 'Skinny Jeans Stretch', 14, 90000, 145000, 'produk/01KD4VA29HB2RF67BEETME9575.jpg', '2025-12-23 05:35:59', '2026-01-06 04:52:27', NULL),
('PRD015', 'KAT008', 'normal', 'QUEENTIN 0125 Katun Crinkle Polos', 7, 75000, 115000, 'produk/01KDBD5B6NTQ75ZDPM6JDS9KPC.jpeg', '2025-12-25 18:43:26', '2025-12-26 12:47:25', NULL),
('PRD016', 'KAT012', 'normal', 'QUEENTIN Rok Kargo Casual 0178', 7, 90000, 135000, 'produk/01KDBHPTTNQWFK4F3DR9QVGJ0B.jpeg', '2025-12-25 20:02:53', '2025-12-26 12:08:35', NULL),
('PRD017', 'KAT008', 'normal', 'LEENBENKA Sylvie', 4, 70000, 105000, 'produk/01KDBHSE2MQPB0J4F5C3HFTQN0.jpg', '2025-12-25 20:04:18', '2025-12-26 11:59:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request_pelanggan`
--

CREATE TABLE `request_pelanggan` (
  `id` varchar(20) NOT NULL,
  `pengguna_id` varchar(20) DEFAULT NULL,
  `nama_barang_dicari` varchar(255) NOT NULL,
  `jumlah_pencari` int(11) NOT NULL DEFAULT 1,
  `status` enum('menunggu','proses','sudah_restock','diabaikan') NOT NULL DEFAULT 'menunggu',
  `tanggal_request` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_pelanggan`
--

INSERT INTO `request_pelanggan` (`id`, `pengguna_id`, `nama_barang_dicari`, `jumlah_pencari`, `status`, `tanggal_request`, `created_at`, `updated_at`, `deleted_at`) VALUES
('REQ001', 'USR001', 'Celana skena ', 3, 'sudah_restock', '2025-12-19', '2025-12-20 08:25:16', '2025-12-29 18:57:02', NULL),
('REQ002', 'USR001', 'Celana Jeans cutbray', 1, 'menunggu', '2026-01-23', '2026-01-23 08:06:07', '2026-01-23 08:06:07', NULL),
('REQ003', 'USR001', 'test', 1, 'menunggu', '2026-01-26', '2026-01-26 16:48:08', '2026-01-26 16:53:15', '2026-01-26 16:53:15'),
('REQ004', 'USR001', 'wadad', 1, 'menunggu', '2026-01-26', '2026-01-26 16:53:25', '2026-01-26 16:53:49', '2026-01-26 16:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('tF9KyoGYVZBTHEh6iN8OQk0H1iIdLCZzox8bPN0A', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM2JqbG9lOTNKNk9rNFJjZmVDdGlhQkEzSWdGRlV0R2t3RG55aVFLRyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoyNToiZmlsYW1lbnQuYWRtaW4uYXV0aC5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766237060);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` varchar(30) NOT NULL,
  `pengguna_id` varchar(20) NOT NULL,
  `waktu_transaksi` datetime NOT NULL,
  `total_bayar` decimal(12,0) NOT NULL,
  `bayar_diterima` decimal(15,0) NOT NULL DEFAULT 0,
  `kembalian` decimal(15,0) NOT NULL DEFAULT 0,
  `metode_pembayaran` enum('tunai','transfer','qris','transfer_bca','transfer_bri','transfer_mandiri') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `pengguna_id`, `waktu_transaksi`, `total_bayar`, `bayar_diterima`, `kembalian`, `metode_pembayaran`, `created_at`, `updated_at`, `deleted_at`) VALUES
('TRX20251222001', 'USR001', '2025-11-20 15:07:14', 130000, 150000, 20000, 'tunai', '2025-12-22 08:07:14', '2025-12-26 11:36:37', '2025-12-26 11:36:37'),
('TRX20251222002', 'USR001', '2025-12-22 15:08:05', 250000, 250000, 0, 'tunai', '2025-12-22 08:08:05', '2025-12-26 11:36:59', '2025-12-26 11:36:59'),
('TRX20251222003', 'USR001', '2025-12-22 15:08:31', 250000, 250000, 0, 'transfer_bca', '2025-12-22 08:08:31', '2025-12-26 11:37:11', '2025-12-26 11:37:11'),
('TRX20251222004', 'USR001', '2025-12-22 15:57:47', 500000, 500000, 0, 'tunai', '2025-12-22 08:57:47', '2025-12-26 11:37:18', '2025-12-26 11:37:18'),
('TRX20251223001', 'USR001', '2025-12-23 11:43:38', 150000, 150000, 0, 'tunai', '2025-12-23 04:43:38', '2025-12-26 11:37:24', '2025-12-26 11:37:24'),
('TRX20251223002', 'USR001', '2025-12-23 15:42:19', 170000, 170000, 0, 'tunai', '2025-12-23 08:42:19', '2025-12-26 11:37:30', '2025-12-26 11:37:30'),
('TRX20251223003', 'USR001', '2025-12-23 16:04:13', 165000, 165000, 0, 'qris', '2025-12-23 09:04:13', '2025-12-26 11:37:36', '2025-12-26 11:37:36'),
('TRX20251226001', 'USR001', '2025-12-26 01:44:04', 110000, 110000, 0, 'transfer_bca', '2025-12-25 18:44:04', '2025-12-26 11:37:42', '2025-12-26 11:37:42'),
('TRX20251226002', 'USR001', '2025-12-26 02:52:56', 700000, 700000, 0, 'tunai', '2025-12-25 19:52:56', '2025-12-26 11:37:48', '2025-12-26 11:37:48'),
('TRX20251226003', 'USR001', '2025-12-26 14:24:49', 170000, 170000, 0, 'tunai', '2025-12-26 07:24:49', '2025-12-26 07:25:25', '2025-12-26 07:25:25'),
('TRX20251226004', 'USR001', '2025-12-26 14:29:40', 170000, 170000, 0, 'tunai', '2025-12-26 07:29:40', '2025-12-26 07:30:41', '2025-12-26 07:30:41'),
('TRX20251226005', 'USR001', '2025-12-26 17:52:11', 135000, 135000, 0, 'qris', '2025-12-26 10:52:11', '2025-12-26 11:37:55', '2025-12-26 11:37:55'),
('TRX20251226006', 'USR001', '2025-12-26 17:59:22', 130000, 130000, 0, 'tunai', '2025-12-26 10:59:22', '2025-12-26 11:38:01', '2025-12-26 11:38:01'),
('TRX20251226007', 'USR001', '2025-12-21 09:43:37', 300000, 300000, 0, 'tunai', '2025-12-26 11:43:37', '2025-12-26 12:31:18', NULL),
('TRX20251226008', 'USR001', '2025-12-21 10:59:21', 100000, 100000, 0, 'transfer_bca', '2025-12-26 11:59:21', '2025-12-26 12:30:23', NULL),
('TRX20251226009', 'USR001', '2025-12-21 11:05:21', 110000, 110000, 0, 'tunai', '2025-12-26 12:05:21', '2025-12-26 12:31:37', NULL),
('TRX20251226010', 'USR001', '2025-12-21 14:06:57', 150000, 200000, 50000, 'tunai', '2025-12-26 12:06:57', '2025-12-26 12:07:21', NULL),
('TRX20251226011', 'USR001', '2025-12-21 19:08:35', 130000, 150000, 20000, 'tunai', '2025-12-26 12:08:35', '2025-12-26 12:08:56', NULL),
('TRX20251226012', 'USR001', '2025-12-21 19:27:48', 280000, 300000, 20000, 'tunai', '2025-12-26 12:27:48', '2025-12-26 12:28:57', NULL),
('TRX20251226013', 'USR001', '2025-12-22 19:33:21', 110000, 110000, 0, 'tunai', '2025-12-26 12:33:21', '2025-12-26 12:36:19', NULL),
('TRX20251226014', 'USR001', '2025-12-22 19:33:34', 115000, 115000, 0, 'tunai', '2025-12-26 12:33:34', '2025-12-26 12:36:29', NULL),
('TRX20251226015', 'USR001', '2025-12-22 19:35:52', 130000, 130000, 0, 'tunai', '2025-12-26 12:35:52', '2025-12-26 12:36:39', NULL),
('TRX20251226016', 'USR001', '2025-12-23 19:37:03', 130000, 130000, 0, 'tunai', '2025-12-26 12:37:03', '2025-12-26 12:37:47', NULL),
('TRX20251226017', 'USR001', '2025-12-23 19:37:15', 170000, 170000, 0, 'tunai', '2025-12-26 12:37:15', '2025-12-26 12:37:58', NULL),
('TRX20251226018', 'USR001', '2025-12-24 19:38:18', 115000, 115000, 0, 'tunai', '2025-12-26 12:38:18', '2025-12-26 12:48:34', NULL),
('TRX20251226019', 'USR001', '2025-12-24 19:38:35', 130000, 130000, 0, 'tunai', '2025-12-26 12:38:35', '2025-12-26 12:48:45', NULL),
('TRX20251226020', 'USR001', '2025-12-24 19:47:25', 115000, 115000, 0, 'tunai', '2025-12-26 12:47:25', '2025-12-26 12:48:54', NULL),
('TRX20251226021', 'USR001', '2025-12-25 19:52:29', 240000, 250000, 10000, 'tunai', '2025-12-26 12:52:29', '2025-12-26 12:52:55', NULL),
('TRX20251226022', 'USR001', '2025-12-26 19:53:24', 270000, 300000, 30000, 'tunai', '2025-12-26 12:53:24', '2025-12-26 12:53:24', NULL),
('TRX20260106001', 'USR001', '2026-01-06 11:51:37', 165000, 165000, 0, 'tunai', '2026-01-06 04:51:37', '2026-01-06 04:51:37', NULL),
('TRX20260106002', 'USR001', '2026-01-06 11:52:27', 145000, 145000, 0, 'qris', '2026-01-06 04:52:27', '2026-01-06 04:52:27', NULL),
('TRX20260106003', 'USR001', '2026-01-06 14:27:25', 250000, 300000, 50000, 'tunai', '2026-01-06 07:27:25', '2026-01-06 07:27:25', NULL),
('TRX20260118001', 'USR001', '2026-01-18 18:10:56', 120000, 150000, 30000, 'tunai', '2026-01-18 11:10:56', '2026-01-18 11:10:56', NULL),
('TRX20260120001', 'USR001', '2026-01-20 15:51:03', 320000, 320000, 0, 'qris', '2026-01-20 08:51:03', '2026-01-20 08:51:03', NULL),
('TRX20260123001', 'USR001', '2026-01-23 14:13:54', 120000, 150000, 30000, 'tunai', '2026-01-23 07:13:54', '2026-01-23 07:13:54', NULL),
('TRX20260126001', 'USR001', '2026-01-26 23:54:44', 110000, 110000, 0, 'transfer_bri', '2026-01-26 16:54:44', '2026-01-26 16:54:44', NULL),
('TRX20260126002', 'USR001', '2026-01-26 23:54:57', 130000, 130000, 0, 'transfer_mandiri', '2026-01-26 16:54:57', '2026-01-26 16:54:57', NULL),
('TRX20260126003', 'USR001', '2026-01-26 23:58:48', 110000, 110000, 0, 'transfer_bri', '2026-01-26 16:58:48', '2026-01-26 16:58:48', NULL),
('TRX20260128001', 'USR001', '2026-01-28 13:39:15', 110000, 110000, 0, 'transfer_bri', '2026-01-28 06:39:15', '2026-01-28 06:39:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksi_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `detail_transaksi_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_email_unique` (`email`);

--
-- Indexes for table `prediksi_penjualan`
--
ALTER TABLE `prediksi_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prediksi_penjualan_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `request_pelanggan`
--
ALTER TABLE `request_pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_pelanggan_pengguna_id_foreign` (`pengguna_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_pengguna_id_foreign` (`pengguna_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`),
  ADD CONSTRAINT `detail_transaksi_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prediksi_penjualan`
--
ALTER TABLE `prediksi_penjualan`
  ADD CONSTRAINT `prediksi_penjualan_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_pelanggan`
--
ALTER TABLE `request_pelanggan`
  ADD CONSTRAINT `request_pelanggan_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
