-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2025 at 04:11 AM
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
-- Database: `kasir_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('jakafarshodiq1496@gmail.com|127.0.0.1', 'i:4;', 1736305249),
('jakafarshodiq1496@gmail.com|127.0.0.1:timer', 'i:1736305249;', 1736305249);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(27, '0001_01_01_000000_create_users_table', 1),
(28, '0001_01_01_000001_create_cache_table', 1),
(29, '0001_01_01_000002_create_jobs_table', 1),
(30, '2024_11_30_102325_create_op_jenis_table', 1),
(31, '2024_11_30_120825_create_op_kategori_table', 1),
(32, '2024_11_30_231604_create_op_seting_lensa_table', 1),
(33, '2024_12_01_071326_create_op_barang_table', 1),
(34, '2024_12_01_162622_create_op_gudang_table', 1),
(35, '2024_12_01_173911_create_op_suplaier_table', 1),
(36, '2024_12_01_184159_create_op_barang_detail_table', 1),
(37, '2024_12_01_184656_create_op_type_table', 1),
(38, '2024_12_02_053542_create_op_toko_table', 1),
(39, '2024_12_02_053904_create_op_toko_cabang_table', 1),
(40, '2024_12_02_074856_create_personal_access_tokens_table', 2),
(41, '2024_12_03_053352_create_op_barang_gudang_stock_table', 3),
(42, '2024_12_06_085022_create_op_pemesanan_table', 4),
(43, '2024_12_06_085047_create_op_pemesanan_detail_table', 5),
(44, '2024_12_06_085037_create_op_pemesanan_cart_table', 6),
(45, '2024_12_06_191948_create_op_pemesanan_log_table', 7),
(46, '2024_12_07_091403_create_op_kas_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `op_barang`
--

CREATE TABLE `op_barang` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_produk` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` bigint UNSIGNED NOT NULL,
  `id_gudang` int NOT NULL,
  `id_user` int NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_produk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang`
--

INSERT INTO `op_barang` (`id`, `kode_produk`, `id_kategori`, `id_gudang`, `id_user`, `nama_produk`, `keterangan_produk`, `barcode`, `created_at`, `updated_at`) VALUES
(29, 'BRG20240001', 3, 7, 3, 'Lensa SV.CR PL', 'Lensa SV.CR PL', 'barcode_barang/BRG20240001.png', '2024-12-13 17:55:30', '2024-12-13 17:55:30'),
(30, 'BRG20240002', 3, 7, 3, 'Lensa SV.CR s–1.00', 'aa', 'barcode_barang/BRG20240002.png', '2024-12-13 17:58:56', '2024-12-13 17:58:56'),
(31, 'BRG20240003', 3, 7, 3, 'Lensa SV.CR s+1.00', 'ff', 'barcode_barang/BRG20240003.png', '2024-12-13 18:00:03', '2024-12-13 18:00:03'),
(32, 'BRG20240004', 3, 7, 3, 'Lensa SV.CR s-1.00 c-0.25', 'Lensa SV.CR s-1.00 c-0.25', 'barcode_barang/BRG20240004.png', '2024-12-13 18:01:16', '2024-12-13 18:01:16'),
(33, 'BRG20240005', 3, 7, 3, 'Lensa KR.CR PL a+1.00', 'Lensa KR.CR PL a+1.00', 'barcode_barang/BRG20240005.png', '2024-12-13 18:02:19', '2024-12-13 18:02:19'),
(34, 'BRG20240006', 3, 7, 3, 'Lensa Order', 'Lensa Order', 'barcode_barang/BRG20240006.png', '2024-12-13 18:02:55', '2024-12-13 18:02:55'),
(35, 'BRG20240007', 3, 7, 3, 'Frame Nike Premium', 'Frame Nike Premium', 'barcode_barang/BRG20240007.png', '2024-12-13 18:06:52', '2024-12-13 18:06:52'),
(36, 'BRG20240008', 4, 7, 3, 'Frame Promo', 'Frame', 'barcode_barang/BRG20240008.png', '2024-12-13 18:08:14', '2024-12-13 18:08:14'),
(37, 'BRG20240009', 3, 7, 3, 'KMB +1.00', 'KMB', 'barcode_barang/BRG20240009.png', '2024-12-13 18:09:20', '2024-12-13 18:09:20'),
(38, 'BRG20240010', 5, 7, 3, 'Matake Brown -2.00', 'ff', 'barcode_barang/BRG20240010.png', '2024-12-14 06:25:57', '2024-12-14 06:25:57'),
(39, 'BRG20240011', 3, 7, 3, 'SV.CR -0.25', 'SV.cr -0.25', 'barcode_barang/BRG20240011.png', '2024-12-14 10:33:42', '2024-12-14 10:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `op_barang_cabang_stock`
--

CREATE TABLE `op_barang_cabang_stock` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `id_suplaier` bigint UNSIGNED DEFAULT NULL,
  `id_gudang` int UNSIGNED NOT NULL,
  `id_toko` int NOT NULL,
  `id_cabang` int NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `stock_masuk` int DEFAULT '0',
  `stock_keluar` int DEFAULT '0',
  `stock_akhir` int DEFAULT '0',
  `jenis_transaksi_stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_stock_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang_cabang_stock`
--

INSERT INTO `op_barang_cabang_stock` (`id`, `id_barang`, `id_suplaier`, `id_gudang`, `id_toko`, `id_cabang`, `id_user`, `stock_masuk`, `stock_keluar`, `stock_akhir`, `jenis_transaksi_stock`, `keterangan_stock_cabang`, `created_at`, `updated_at`) VALUES
(1, 29, 2, 7, 1, 1, 6, 100, 20, 80, 'Dibatalkan', 'Pembatalan transaksi barang dengan nomor transaksi 20242812-1-0009', '2024-12-14 05:31:51', '2024-12-28 14:35:50'),
(2, 30, 2, 7, 1, 1, 6, 100, 28, 72, 'Dibatalkan', 'Pembatalan transaksi barang dengan nomor transaksi 20242912-1-0002', '2024-12-14 05:32:16', '2024-12-29 16:44:35'),
(3, 31, 2, 7, 1, 1, 6, 100, 9, 91, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0004', '2024-12-14 05:32:35', '2024-12-15 23:07:41'),
(4, 32, 2, 7, 1, 1, 6, 100, 9, 91, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-14 05:32:54', '2024-12-15 22:58:53'),
(5, 33, 2, 7, 1, 1, 6, 100, 20, 80, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0004', '2024-12-14 05:33:14', '2024-12-15 23:07:42'),
(6, 34, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:33:35', '2024-12-14 05:33:35'),
(7, 35, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:33:54', '2024-12-14 05:33:54'),
(8, 36, 2, 7, 1, 1, 6, 100, 3, 97, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0003', '2024-12-14 05:34:11', '2024-12-14 11:05:27'),
(9, 38, 2, 7, 1, 1, 6, 5, 3, 2, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0005', '2024-12-14 06:28:50', '2024-12-14 11:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `op_barang_cabang_stock_log`
--

CREATE TABLE `op_barang_cabang_stock_log` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `id_suplaier` bigint UNSIGNED DEFAULT NULL,
  `id_gudang` int UNSIGNED NOT NULL,
  `id_toko` int NOT NULL,
  `id_cabang` int NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `stock_masuk` int NOT NULL DEFAULT '0',
  `stock_keluar` int NOT NULL DEFAULT '0',
  `stock_akhir` int NOT NULL DEFAULT '0',
  `jenis_transaksi_stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_stock_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang_cabang_stock_log`
--

INSERT INTO `op_barang_cabang_stock_log` (`id`, `id_barang`, `id_suplaier`, `id_gudang`, `id_toko`, `id_cabang`, `id_user`, `stock_masuk`, `stock_keluar`, `stock_akhir`, `jenis_transaksi_stock`, `keterangan_stock_cabang`, `created_at`, `updated_at`) VALUES
(1, 29, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:31:51', '2024-12-14 05:31:51'),
(2, 30, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:32:16', '2024-12-14 05:32:16'),
(3, 31, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:32:35', '2024-12-14 05:32:35'),
(4, 32, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:32:54', '2024-12-14 05:32:54'),
(5, 33, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:33:14', '2024-12-14 05:33:14'),
(6, 34, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:33:35', '2024-12-14 05:33:35'),
(7, 35, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:33:54', '2024-12-14 05:33:54'),
(8, 36, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 05:34:11', '2024-12-14 05:34:11'),
(9, 38, 2, 7, 1, 1, 6, 5, 0, 5, 'masuk', 'Masuk stock barang masuk: 5', '2024-12-14 06:28:50', '2024-12-14 06:28:50'),
(10, 38, 2, 7, 1, 1, 5, 5, 1, 4, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0001', '2024-12-14 06:59:44', '2024-12-14 06:59:44'),
(11, 36, 2, 7, 1, 1, 5, 100, 1, 99, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0002', '2024-12-14 09:44:30', '2024-12-14 09:44:30'),
(12, 36, 2, 7, 1, 1, 5, 99, 1, 98, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0002', '2024-12-14 09:44:30', '2024-12-14 09:44:30'),
(13, 36, 2, 7, 1, 1, 5, 98, 1, 97, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0003', '2024-12-14 11:05:27', '2024-12-14 11:05:27'),
(14, 38, 2, 7, 1, 1, 5, 4, 1, 3, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0004', '2024-12-14 11:40:21', '2024-12-14 11:40:21'),
(15, 38, 2, 7, 1, 1, 5, 3, 1, 2, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0005', '2024-12-14 11:45:03', '2024-12-14 11:45:03'),
(16, 30, 2, 7, 1, 1, 5, 100, 2, 98, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0006', '2024-12-14 14:35:28', '2024-12-14 14:35:28'),
(17, 31, 2, 7, 1, 1, 5, 100, 2, 98, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0007', '2024-12-14 14:37:11', '2024-12-14 14:37:11'),
(18, 29, 2, 7, 1, 1, 5, 100, 1, 99, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241412-1-0008', '2024-12-14 14:39:04', '2024-12-14 14:39:04'),
(19, 31, 2, 7, 1, 1, 5, 98, 4, 94, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-15 22:52:46', '2024-12-15 22:52:46'),
(20, 32, 2, 7, 1, 1, 5, 100, 5, 95, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-15 22:52:46', '2024-12-15 22:52:46'),
(21, 30, 2, 7, 1, 1, 5, 98, 5, 93, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-15 22:58:53', '2024-12-15 22:58:53'),
(22, 32, 2, 7, 1, 1, 5, 95, 4, 91, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-15 22:58:53', '2024-12-15 22:58:53'),
(23, 30, 2, 7, 1, 1, 5, 93, 5, 88, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-15 23:00:13', '2024-12-15 23:00:13'),
(24, 33, 2, 7, 1, 1, 5, 100, 12, 88, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0001', '2024-12-15 23:00:13', '2024-12-15 23:00:13'),
(25, 30, 2, 7, 1, 1, 5, 88, 4, 84, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0002', '2024-12-15 23:02:28', '2024-12-15 23:02:28'),
(26, 33, 2, 7, 1, 1, 5, 88, 3, 85, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0002', '2024-12-15 23:02:28', '2024-12-15 23:02:28'),
(27, 30, 2, 7, 1, 1, 5, 84, 2, 82, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0003', '2024-12-15 23:04:50', '2024-12-15 23:04:50'),
(28, 33, 2, 7, 1, 1, 5, 85, 3, 82, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0003', '2024-12-15 23:04:50', '2024-12-15 23:04:50'),
(29, 31, 2, 7, 1, 1, 5, 94, 3, 91, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0004', '2024-12-15 23:07:42', '2024-12-15 23:07:42'),
(30, 33, 2, 7, 1, 1, 5, 82, 2, 80, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241612-1-0004', '2024-12-15 23:07:42', '2024-12-15 23:07:42'),
(31, 30, 2, 7, 1, 1, 5, 82, 1, 81, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241712-1-0001', '2024-12-16 23:03:01', '2024-12-16 23:03:01'),
(32, 30, 2, 7, 1, 1, 5, 81, 2, 79, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242712-1-0004', '2024-12-27 02:51:51', '2024-12-27 02:51:51'),
(33, 29, 2, 7, 1, 1, 5, 99, 2, 97, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0001', '2024-12-28 12:28:40', '2024-12-28 12:28:40'),
(34, 30, 2, 7, 1, 1, 5, 79, 7, 72, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0002', '2024-12-28 12:59:49', '2024-12-28 12:59:49'),
(35, 29, 2, 7, 1, 1, 5, 97, 4, 93, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0003', '2024-12-28 13:01:09', '2024-12-28 13:01:09'),
(36, 29, 2, 7, 1, 1, 5, 93, 3, 90, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0004', '2024-12-28 13:38:18', '2024-12-28 13:38:18'),
(37, 29, 2, 7, 1, 1, 5, 90, 5, 85, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0005', '2024-12-28 13:45:18', '2024-12-28 13:45:18'),
(38, 29, 2, 7, 1, 1, 5, 85, 4, 81, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0006', '2024-12-28 14:22:23', '2024-12-28 14:22:23'),
(39, 29, 2, 7, 1, 1, 5, 81, 1, 80, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0007', '2024-12-28 14:29:16', '2024-12-28 14:29:16'),
(40, 29, 2, 7, 1, 1, 5, 80, 2, 78, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0008', '2024-12-28 14:30:48', '2024-12-28 14:30:48'),
(41, 29, 2, 7, 1, 1, 5, 80, 1, 79, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0009', '2024-12-28 14:33:09', '2024-12-28 14:33:09'),
(42, 29, 2, 7, 1, 1, 5, 79, 1, 78, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242812-1-0009', '2024-12-28 14:33:09', '2024-12-28 14:33:09'),
(43, 30, 2, 7, 1, 1, 5, 72, 2, 70, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20242912-1-0002', '2024-12-29 16:12:08', '2024-12-29 16:12:08'),
(44, 30, 2, 7, 1, 1, 6, 100, 28, 72, 'update', 'Stock updated due to Penjualan cencelion', '2024-12-29 16:44:35', '2024-12-29 16:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `op_barang_detail`
--

CREATE TABLE `op_barang_detail` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `id_jenis` bigint UNSIGNED NOT NULL,
  `id_type` bigint UNSIGNED NOT NULL,
  `R_SPH` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_SPH` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `R_CYL` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_CYL` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `R_AXS` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_AXS` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `R_ADD` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_ADD` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PD` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PD2` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang_detail`
--

INSERT INTO `op_barang_detail` (`id`, `id_barang`, `id_jenis`, `id_type`, `R_SPH`, `L_SPH`, `R_CYL`, `L_CYL`, `R_AXS`, `L_AXS`, `R_ADD`, `L_ADD`, `PD`, `PD2`, `created_at`, `updated_at`) VALUES
(26, 29, 4, 3, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 17:55:30', '2025-01-08 03:36:22'),
(27, 30, 4, 2, '-1.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 17:58:56', '2024-12-13 17:58:56'),
(28, 31, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:00:03', '2024-12-14 06:24:21'),
(29, 32, 4, 2, '-1.00', NULL, '-0.25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:01:16', '2024-12-13 18:01:16'),
(30, 33, 4, 2, '0', NULL, '+1.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:02:19', '2024-12-13 18:02:19'),
(31, 34, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:02:55', '2024-12-13 18:02:55'),
(32, 35, 8, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:06:52', '2024-12-13 18:06:52'),
(33, 36, 9, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:08:14', '2024-12-13 18:08:14'),
(34, 37, 7, 2, '+1.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 18:09:20', '2024-12-13 18:09:20'),
(35, 38, 5, 2, '-2.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-14 06:25:57', '2024-12-14 06:25:57'),
(36, 39, 5, 2, '-0.25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-14 10:33:42', '2024-12-14 10:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `op_barang_gudang_stock`
--

CREATE TABLE `op_barang_gudang_stock` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `id_suplaier` bigint UNSIGNED DEFAULT NULL,
  `id_gudang` int NOT NULL,
  `id_user` int NOT NULL,
  `stock_masuk` int NOT NULL DEFAULT '0',
  `stock_keluar` int NOT NULL DEFAULT '0',
  `stock_akhir` int NOT NULL DEFAULT '0',
  `jenis_transaksi_stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_stock_gudang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang_gudang_stock`
--

INSERT INTO `op_barang_gudang_stock` (`id`, `id_barang`, `id_suplaier`, `id_gudang`, `id_user`, `stock_masuk`, `stock_keluar`, `stock_akhir`, `jenis_transaksi_stock`, `keterangan_stock_gudang`, `created_at`, `updated_at`) VALUES
(6, 29, 2, 7, 3, 100, -54, 154, 'Dibatalkan', 'Pembatalan transaksi barang dengan nomor transaksi 20242912-1-0001', '2024-12-13 18:10:30', '2024-12-29 13:14:44'),
(7, 30, 2, 7, 3, 100, -17, 117, 'Dibatalkan', 'Pembatalan transaksi barang dengan nomor transaksi 20242912-1-0001', '2024-12-13 18:10:51', '2024-12-29 12:27:04'),
(8, 31, 2, 7, 3, 200, -3, 203, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-13 18:11:15', '2024-12-27 04:07:36'),
(9, 38, 2, 7, 3, 50, 0, 50, 'masuk', 'Masuk stock barang masuk: 50', '2024-12-14 06:27:34', '2024-12-14 06:27:34'),
(10, 36, 2, 7, 3, 100, 2, 98, 'pesanan', 'Stock keluar untuk pesanan 20241412-1-0002', '2024-12-14 09:34:06', '2024-12-14 09:46:45'),
(11, 39, 2, 7, 3, 12, 0, 12, 'masuk', 'Masuk stock barang masuk: 12', '2024-12-14 10:35:49', '2024-12-14 10:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `op_barang_gudang_stock_log`
--

CREATE TABLE `op_barang_gudang_stock_log` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `id_suplaier` bigint UNSIGNED DEFAULT NULL,
  `id_gudang` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `stock_masuk` int NOT NULL DEFAULT '0',
  `stock_keluar` int NOT NULL DEFAULT '0',
  `stock_akhir` int NOT NULL DEFAULT '0',
  `jenis_transaksi_stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_stock_gudang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang_gudang_stock_log`
--

INSERT INTO `op_barang_gudang_stock_log` (`id`, `id_barang`, `id_suplaier`, `id_gudang`, `id_user`, `stock_masuk`, `stock_keluar`, `stock_akhir`, `jenis_transaksi_stock`, `keterangan_stock_gudang`, `created_at`, `updated_at`) VALUES
(41, 29, 2, 7, 3, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-13 18:10:30', '2024-12-13 18:10:30'),
(42, 30, 2, 7, 3, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-13 18:10:51', '2024-12-13 18:10:51'),
(43, 31, 2, 7, 3, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-13 18:11:15', '2024-12-13 18:11:15'),
(44, 31, 2, 7, 3, 100, 0, 200, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-13 18:11:41', '2024-12-13 18:11:41'),
(45, 38, 2, 7, 3, 50, 0, 50, 'masuk', 'Masuk stock barang masuk: 50', '2024-12-14 06:27:34', '2024-12-14 06:27:34'),
(46, 36, 2, 7, 3, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-14 09:34:06', '2024-12-14 09:34:06'),
(47, 36, 2, 7, 3, 0, 1, 99, 'pesanan', 'Stock keluar untuk pesanan 20241412-1-0001', '2024-12-14 09:45:25', '2024-12-14 09:45:25'),
(48, 29, 2, 7, 3, 0, 2, 98, 'pesanan', 'Stock keluar untuk pesanan 20241412-1-0001', '2024-12-14 09:45:25', '2024-12-14 09:45:25'),
(49, 36, 2, 7, 3, 0, 1, 98, 'pesanan', 'Stock keluar untuk pesanan 20241412-1-0002', '2024-12-14 09:46:45', '2024-12-14 09:46:45'),
(50, 30, 2, 7, 3, 0, 2, 98, 'pesanan', 'Stock keluar untuk pesanan 20241412-1-0002', '2024-12-14 09:46:45', '2024-12-14 09:46:45'),
(51, 39, 2, 7, 3, 12, 0, 12, 'masuk', 'Masuk stock barang masuk: 12', '2024-12-14 10:35:49', '2024-12-14 10:35:49'),
(52, 29, 2, 7, 3, 0, 2, 114, 'pesanan', 'Stock keluar untuk pesanan 20242912-1-0001', '2024-12-29 08:34:13', '2024-12-29 08:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `op_barang_harga`
--

CREATE TABLE `op_barang_harga` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `harga_modal` decimal(10,0) NOT NULL,
  `harga_jual` decimal(10,0) NOT NULL,
  `harga_grosir_1` decimal(10,0) NOT NULL,
  `harga_grosir_2` decimal(10,0) NOT NULL,
  `harga_grosir_3` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_barang_harga`
--

INSERT INTO `op_barang_harga` (`id`, `id_barang`, `harga_modal`, `harga_jual`, `harga_grosir_1`, `harga_grosir_2`, `harga_grosir_3`, `created_at`, `updated_at`) VALUES
(29, 29, '150000', '30000', '150000', '150000', '150000', '2024-12-13 17:55:30', '2025-01-08 03:36:22'),
(30, 30, '150000', '30000', '150000', '150000', '150000', '2024-12-13 17:58:56', '2024-12-13 17:58:56'),
(31, 31, '150000', '30000', '150000', '150000', '150000', '2024-12-13 18:00:03', '2024-12-14 06:24:21'),
(32, 32, '30000', '150000', '150000', '150000', '150000', '2024-12-13 18:01:16', '2024-12-13 18:01:16'),
(33, 33, '40000', '200000', '200000', '200000', '200000', '2024-12-13 18:02:19', '2024-12-13 18:02:19'),
(34, 34, '0', '0', '0', '0', '0', '2024-12-13 18:02:55', '2024-12-13 18:02:55'),
(35, 35, '1150000', '1150000', '1150000', '1150000', '1150000', '2024-12-13 18:06:52', '2024-12-13 18:06:52'),
(36, 36, '0', '0', '0', '0', '0', '2024-12-13 18:08:14', '2024-12-13 18:08:14'),
(37, 37, '80000', '80000', '80000', '80000', '80000', '2024-12-13 18:09:20', '2024-12-13 18:09:20'),
(38, 38, '30000', '80000', '80000', '80000', '80000', '2024-12-14 06:25:57', '2024-12-14 06:25:57'),
(39, 39, '15000', '75000', '75000', '75000', '75000', '2024-12-14 10:33:42', '2024-12-14 10:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `op_gudang`
--

CREATE TABLE `op_gudang` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_gudang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_gudang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_gudang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_gudang` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_gudang`
--

INSERT INTO `op_gudang` (`id`, `nama_gudang`, `lokasi_gudang`, `deskripsi_gudang`, `status_gudang`, `created_at`, `updated_at`) VALUES
(7, 'Gudang Utama', 'pekan', 'aa', '1', '2024-12-10 12:08:05', '2024-12-10 12:08:05'),
(8, 'Gudang Pusat', 'Optik Mandiri 1', 'Paset dan stock', '1', '2024-12-12 06:42:27', '2024-12-12 06:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `op_jenis`
--

CREATE TABLE `op_jenis` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_jenis` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_jenis`
--

INSERT INTO `op_jenis` (`id`, `jenis`, `status_jenis`, `created_at`, `updated_at`) VALUES
(4, 'Progressive', '1', '2024-12-11 01:48:46', '2024-12-11 01:48:46'),
(5, 'Single Vision', '1', '2024-12-11 01:49:21', '2024-12-11 01:49:21'),
(6, 'Lensa Pesan', '1', '2024-12-11 01:49:30', '2024-12-11 01:49:30'),
(7, 'Kriptok', '1', '2024-12-12 06:44:14', '2024-12-12 06:44:14'),
(8, 'Nike', '1', '2024-12-13 18:05:25', '2024-12-13 18:05:25'),
(9, 'Promo', '1', '2024-12-13 18:07:27', '2024-12-13 18:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `op_kas`
--

CREATE TABLE `op_kas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` int NOT NULL,
  `id_cabang` int NOT NULL,
  `kode_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` decimal(15,0) NOT NULL DEFAULT '0',
  `kredit` decimal(15,0) NOT NULL DEFAULT '0',
  `saldo` decimal(15,0) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_kas`
--

INSERT INTO `op_kas` (`id`, `id_user`, `id_cabang`, `kode_transaksi`, `tanggal`, `keterangan`, `debit`, `kredit`, `saldo`, `created_at`, `updated_at`) VALUES
(10, 5, 1, '20242912-1-0001', '2024-12-29 20:48:03', 'Saldo tambahan dari transaksi penjualan tunai dengan nomor transaksi 20242912-1-0001', '500000', '0', '500000', '2024-12-29 13:48:03', '2024-12-29 13:48:03'),
(11, 5, 1, '20242912-1-0001', '2024-12-29 20:55:58', 'Saldo berkurang dari transaksi dibatalkan sebesar 500.000,00 dengan nomor transaksi 20242912-1-0001', '0', '500000', '0', '2024-12-29 13:55:58', '2024-12-29 13:55:58'),
(12, 5, 1, '20242912-1-0002', '2024-12-29 23:12:08', 'Saldo tambahan dari transaksi penjualan tunai dengan nomor transaksi 20242912-1-0002', '300000', '0', '300000', '2024-12-29 16:12:08', '2024-12-29 16:12:08'),
(13, 6, 1, '20242912-1-0002', '2024-12-29 23:44:35', 'Saldo berkurang dari transaksi dibatalkan sebesar 300.000,00 dengan nomor transaksi 20242912-1-0002', '0', '300000', '-300000', '2024-12-29 16:44:35', '2024-12-29 16:44:35'),
(14, 5, 1, '20250801-1-0001', '2025-01-08 10:39:39', 'Saldo tambahan dari transaksi penjualan tunai dengan nomor transaksi 20250801-1-0001', '300000', '0', '600000', '2025-01-08 03:39:39', '2025-01-08 03:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `op_kategori`
--

CREATE TABLE `op_kategori` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesanan` enum('Ya','Tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_kategori`
--

INSERT INTO `op_kategori` (`id`, `nama_kategori`, `status`, `pesanan`, `created_at`, `updated_at`) VALUES
(3, 'Lensa', '1', 'Ya', '2024-12-10 12:02:10', '2024-12-10 12:02:10'),
(4, 'Frame', '1', 'Ya', '2024-12-10 12:02:22', '2024-12-10 12:02:22'),
(5, 'Softlens', '1', 'Ya', '2024-12-11 01:46:35', '2024-12-12 06:43:41'),
(6, 'Air Soflent', '1', 'Ya', '2024-12-11 01:46:48', '2024-12-12 06:43:26'),
(8, 'Sunglass', '1', 'Ya', '2024-12-12 06:43:15', '2024-12-12 06:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `op_seting_lensa`
--

CREATE TABLE `op_seting_lensa` (
  `id` bigint UNSIGNED NOT NULL,
  `sph_dari` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sph_sampai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cyl_dari` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cyl_sampai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `axs_dari` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `axs_sampai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_dari` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_sampai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_seting_lensa`
--

INSERT INTO `op_seting_lensa` (`id`, `sph_dari`, `sph_sampai`, `cyl_dari`, `cyl_sampai`, `axs_dari`, `axs_sampai`, `add_dari`, `add_sampai`, `created_at`, `updated_at`) VALUES
(1, '-8.00', '8.00', '-8.00', '8.00', '0', '359', '0.25', '3.00', '2024-12-01 23:54:37', '2024-12-13 17:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `op_suplaier`
--

CREATE TABLE `op_suplaier` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_suplaier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_instansi_suplaier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_suplaier` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_suplaier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_suplaier` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_suplaier` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_suplaier`
--

INSERT INTO `op_suplaier` (`id`, `nama_suplaier`, `nama_instansi_suplaier`, `kontak_suplaier`, `alamat_suplaier`, `keterangan_suplaier`, `status_suplaier`, `created_at`, `updated_at`) VALUES
(2, 'CV. Domba MAS', 'CV. Domba MAS', '121212121212', 'Pekanbaru', 'testes', '1', '2024-12-11 05:38:24', '2024-12-11 05:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `op_toko`
--

CREATE TABLE `op_toko` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_toko` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pemilik` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_toko` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_toko` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_toko` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_toko`
--

INSERT INTO `op_toko` (`id`, `nama_toko`, `nama_pemilik`, `phone_toko`, `email_toko`, `alamat_toko`, `created_at`, `updated_at`) VALUES
(1, 'OPTIK Q', 'SHODIQ', '08222123123123', 'shodiq1969@gmail.com', 'Pekanbaru', '2024-12-01 23:54:37', '2025-01-08 02:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `op_toko_cabang`
--

CREATE TABLE `op_toko_cabang` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_toko_cabang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_cabang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_cabang` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_cabang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_toko` bigint UNSIGNED NOT NULL,
  `status_cabang` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_toko_cabang`
--

INSERT INTO `op_toko_cabang` (`id`, `nama_toko_cabang`, `alamat_cabang`, `phone_cabang`, `email_cabang`, `latitude`, `longitude`, `id_toko`, `status_cabang`, `created_at`, `updated_at`) VALUES
(1, 'Irene Optik', 'Jl. Hr. Subrantas No.40, Panam, Pekanbaru', '082108222208', 'mainbranch@example.com', '0.526246', '101.451573', 1, '1', '2024-12-01 23:54:37', '2024-12-10 17:14:20'),
(7, 'Optik Mandiri', 'Jl. Subrantas', '08125624156156', 'optikmandiripku@gmail.com', '0.984944', '101.337891', 1, '1', '2024-12-12 06:48:14', '2024-12-12 06:48:14');

-- --------------------------------------------------------

--
-- Table structure for table `op_transaksi`
--

CREATE TABLE `op_transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_cabang` bigint UNSIGNED NOT NULL,
  `phone_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diameter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warna` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_ambil` date NOT NULL,
  `pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_beli` decimal(15,0) NOT NULL,
  `diskon` decimal(15,0) NOT NULL,
  `jumlah_bayar` decimal(15,0) NOT NULL,
  `sisa_bayar` decimal(15,0) NOT NULL,
  `jumlah_bayar_dp` decimal(15,0) DEFAULT NULL,
  `jumlah_sisa_dp` decimal(15,0) DEFAULT NULL,
  `jumlah_lunas_dp` decimal(15,0) DEFAULT NULL,
  `R_SPH` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_SPH` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `R_CYL` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_CYL` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `R_AXS` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_AXS` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `R_ADD` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_ADD` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PD` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PD2` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_transaksi` enum('lunas','belum_lunas','dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_transaksi`
--

INSERT INTO `op_transaksi` (`id`, `nomor_transaksi`, `nama`, `alamat`, `id_user`, `id_cabang`, `phone_transaksi`, `diameter`, `warna`, `tanggal_transaksi`, `tanggal_selesai`, `tanggal_ambil`, `pembayaran`, `jenis_transaksi`, `total_beli`, `diskon`, `jumlah_bayar`, `sisa_bayar`, `jumlah_bayar_dp`, `jumlah_sisa_dp`, `jumlah_lunas_dp`, `R_SPH`, `L_SPH`, `R_CYL`, `L_CYL`, `R_AXS`, `L_AXS`, `R_ADD`, `L_ADD`, `PD`, `PD2`, `status_transaksi`, `created_at`, `updated_at`) VALUES
(42, '20242912-1-0001', 'JAKFAR SHODIQ', 'awss', 5, 1, '12333', NULL, NULL, '2024-12-29', '2024-12-30', '2024-12-31', 'tunai', 'non_hutang', '100000', '0', '0', '100000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lunas', '2024-12-29 13:48:03', '2024-12-29 13:55:58'),
(43, '20242912-1-0002', 'JAKFAR SHODIQ', 'qwer', 5, 1, '12333', '2', 'wer', '2024-12-29', '2024-12-29', '2024-12-31', 'tunai', 'non_hutang', '300000', '0', '300000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dibatalkan', '2024-12-29 16:12:08', '2024-12-29 16:44:35'),
(44, '20250801-1-0001', 'JAKFAR SHODIQ', 'aws', 5, 1, '12333', '2', 'Hitam', '2025-01-08', '2025-01-09', '2025-01-10', 'tunai', 'non_hutang', '300000', '0', '300000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lunas', '2025-01-08 03:39:39', '2025-01-08 03:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `op_transaksi_detail`
--

CREATE TABLE `op_transaksi_detail` (
  `id` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `id_cabang` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_gudang` bigint UNSIGNED NOT NULL,
  `kode_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_barang` decimal(15,0) NOT NULL,
  `jumlah_barang` int NOT NULL,
  `sub_total_transaksi` decimal(15,0) NOT NULL,
  `pemesanan` enum('ya','tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pemesanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_transaksi_detail`
--

INSERT INTO `op_transaksi_detail` (`id`, `id_transaksi`, `nomor_transaksi`, `id_barang`, `id_cabang`, `id_user`, `id_gudang`, `kode_produk`, `harga_barang`, `jumlah_barang`, `sub_total_transaksi`, `pemesanan`, `status_pemesanan`, `created_at`, `updated_at`) VALUES
(7, 42, '20242912-1-0001', 30, 1, 5, 7, 'BRG20240002', '150000', 4, '600000', 'ya', 'dibatalkan', '2024-12-29 13:48:03', '2024-12-29 13:55:58'),
(8, 43, '20242912-1-0002', 30, 1, 5, 7, 'BRG20240002', '150000', 2, '300000', 'tidak', 'pesan', '2024-12-29 16:12:08', '2024-12-29 16:44:35'),
(9, 44, '20250801-1-0001', 30, 1, 5, 7, 'BRG20240002', '150000', 2, '300000', 'ya', 'pesan', '2025-01-08 03:39:39', '2025-01-08 03:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `op_transaksi_keranjang`
--

CREATE TABLE `op_transaksi_keranjang` (
  `id` int NOT NULL,
  `id_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cabang` int NOT NULL,
  `id_user` int NOT NULL,
  `id_gudang` int NOT NULL,
  `kode_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesanan` enum('ya','tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah_beli` int NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `op_transaksi_log`
--

CREATE TABLE `op_transaksi_log` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `status_log` varchar(255) NOT NULL,
  `keterangan_log` text,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_cabang` bigint UNSIGNED NOT NULL,
  `id_gudang` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `op_transaksi_log`
--

INSERT INTO `op_transaksi_log` (`id`, `nomor_transaksi`, `status_log`, `keterangan_log`, `id_user`, `id_cabang`, `id_gudang`, `created_at`, `updated_at`) VALUES
(3, '20242912-1-0001', 'dibatalkan', 'transaksi anda di batalkan ', 5, 1, 0, '2024-12-29 13:12:44', '2024-12-29 13:12:44'),
(4, '20242912-1-0001', 'dibatalkan', 'transaksi anda di batalkan ', 5, 1, 0, '2024-12-29 13:14:44', '2024-12-29 13:14:44'),
(5, '20242912-1-0002', 'dibatalkan', 'transaksi anda di batalkan ', 5, 1, 7, '2024-12-29 13:38:25', '2024-12-29 13:38:25'),
(6, '20242912-1-0001', 'dibatalkan', 'transaksi anda di batalkan ', 5, 1, 7, '2024-12-29 13:55:58', '2024-12-29 13:55:58'),
(7, '20242912-1-0002', 'pesan', 'pemesanan berhasil', 5, 1, 7, '2024-12-29 16:12:08', '2024-12-29 16:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `op_type`
--

CREATE TABLE `op_type` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_type` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `op_type`
--

INSERT INTO `op_type` (`id`, `type`, `status_type`, `created_at`, `updated_at`) VALUES
(2, 'CR', '1', '2024-12-10 06:20:32', '2024-12-10 06:20:32'),
(3, 'Blueray', '1', '2024-12-10 06:20:40', '2024-12-10 06:20:40'),
(4, 'Photochromic', '1', '2024-12-11 01:50:16', '2024-12-12 06:44:29'),
(5, 'Drive', '1', '2024-12-11 01:50:28', '2024-12-11 01:50:28'),
(6, 'Blue Chromic', '1', '2024-12-11 01:50:40', '2024-12-11 01:50:40'),
(13, 'Premium', '1', '2024-12-13 18:04:41', '2024-12-13 18:05:16'),
(14, 'Promo', '1', '2024-12-13 18:07:34', '2024-12-13 18:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('shodiqsolution@gmail.com', '$2y$12$LRYxnZKU9QtnrfOvypZdbOTilRnbpkR5zxS7qKUnlSVfawf5E47oS', '2024-12-08 23:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('g29va2jRT1DkTsUASWhhoOVVFqolZ4exWuSxT3g8', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoic3BZSHM5Rjl5b3VYNlJsMlZvcGJmTFVlY05xWEd4bFRSSnZURWpUSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo3OiJ0b2tvX2lkIjtpOjE7czo5OiJ0b2tvX25hbWEiO3M6MTE6IklSRU5FIE9QVElLIjt9', 1736304754),
('leiLur9Hnyz9aZm7DLpF3hKynvttPMVVeXkHs7zh', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoibHhSWjBScVJDYjVMbnRKemNPSTRNdkVNYkJ2S0pNaWU4SjlBUGtFQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL293bmVyLWdyYWZpayI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvb3duZXItZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjc6InRva29faWQiO2k6MTtzOjk6InRva29fbmFtYSI7czoxMToiSVJFTkUgT1BUSUsiO30=', 1736302968),
('LhCaILfxjs58XE8dQuw1rPeMB18rZFINbtCmyr80', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYXRueDB4alpWZFpXbWVVOGIzUll1WEYwaVp2b0NBTHRrWHNrQXp1ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi1kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NzoidG9rb19pZCI7aToxO3M6OToidG9rb19uYW1hIjtzOjExOiJJUkVORSBPUFRJSyI7fQ==', 1736304897),
('NIMs0CaYmYy3t1wVkNJ3kJWFSGhGRQ7NiaRgSnO4', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibFk3MFR1Mm1UQXVnVzBmVGlmTXB1TGhTR0s5Skw5M21wbllCM2txTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi1kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NzoidG9rb19pZCI7aToxO3M6OToidG9rb19uYW1hIjtzOjc6Ik9QVElLIFEiO30=', 1736305230),
('tU1s3mWShD7LIlWuKeQ4oATstooZloOWgINOL0eB', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiTjFZSEo1bjI4eFhmV2dZaDlpNm5nSGVHNDRRMmZLM0hGMkVnQ0VadyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluLWRhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4tZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjc6InRva29faWQiO2k6MTtzOjk6InRva29fbmFtYSI7czoxMToiSVJFTkUgT1BUSUsiO30=', 1736305287),
('xG4PIIJqD3lwoy1fg5J4br0FQQAbo2Kxxx2MKN9u', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiN3g4RTJEd1oweXJhamtBUHBIMXZCSEdpRDFrT0NMTFpxVTU5aURKYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXNpci90cmFuc2Frc2ktcGVzYW4tY2V0YWsvMjAyNTA4MDEtMS0wMDAxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjk6ImNhYmFuZ19pZCI7aToxO3M6MTE6ImNhYmFuZ19uYW1hIjtzOjExOiJJcmVuZSBPcHRpayI7czo3OiJ0b2tvX2lkIjtpOjE7czo5OiJ0b2tvX25hbWEiO3M6NzoiT1BUSUsgUSI7fQ==', 1736308553);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `id_toko` int DEFAULT NULL,
  `id_cabang` int DEFAULT NULL,
  `id_gudang` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_user` enum('owner','admin','kasir','gudang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_user` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_toko`, `id_cabang`, `id_gudang`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `level_user`, `status_user`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, NULL, 'Jakfar', 'jakfarshodiq1496@gmail.com', '2024-12-02 08:09:57', '$2y$12$iAAs2SOzxlhGY6OgfhWQsO0.D5IQ.rjncBRCNVkeLktK31Q0loLb2', NULL, 'owner', '1', '2024-12-02 05:54:25', '2024-12-02 05:54:25'),
(3, 1, 1, 7, 'Gudang', 'gudang@gmail.com', '2024-12-02 13:53:01', '$2y$12$4rDl4E1GjdWTX9uls4vY9Ot94IoxCiOQU.VYU7zeXn5oFzkjOTDiq', NULL, 'gudang', '1', '2024-12-02 13:32:23', '2024-12-13 10:39:07'),
(5, 1, 1, NULL, 'Kasir', 'kasir@gmail.com', '2024-12-01 17:00:00', '$2y$12$rjZ/roXirYlOs7dHNwNjiOQ0Z7y3cPTFfAgOiLXSOjtw1LVbyNxUe', NULL, 'kasir', '1', '2024-12-02 13:52:02', '2024-12-11 05:32:14'),
(6, 1, 1, 1, 'admin', 'admin@gmail.com', '2024-12-02 13:53:43', '$2y$12$0KRQAX4ImxGIckXRET4jVeyA4b53/LPOc2kFUcV4zWHdFvsdcW8v2', NULL, 'admin', '1', '2024-12-02 13:52:18', '2024-12-09 14:21:18'),
(10, 1, NULL, NULL, 'irene optik', 'ireneoptikpku@gmail.com', '2024-12-09 11:45:58', '$2y$12$iAAs2SOzxlhGY6OgfhWQsO0.D5IQ.rjncBRCNVkeLktK31Q0loLb2', NULL, 'owner', '1', NULL, NULL);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_barang`
--
ALTER TABLE `op_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_barang_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `op_barang_cabang_stock`
--
ALTER TABLE `op_barang_cabang_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_barang_cabang_stock_log`
--
ALTER TABLE `op_barang_cabang_stock_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_barang_detail`
--
ALTER TABLE `op_barang_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_barang_gudang_stock`
--
ALTER TABLE `op_barang_gudang_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_barang_gudang_stock_id_barang_foreign` (`id_barang`),
  ADD KEY `op_barang_gudang_stock_id_suplaier_foreign` (`id_suplaier`);

--
-- Indexes for table `op_barang_gudang_stock_log`
--
ALTER TABLE `op_barang_gudang_stock_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_barang_gudang_stock_log_id_barang_foreign` (`id_barang`),
  ADD KEY `op_barang_gudang_stock_log_id_suplaier_foreign` (`id_suplaier`);

--
-- Indexes for table `op_barang_harga`
--
ALTER TABLE `op_barang_harga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `op_gudang`
--
ALTER TABLE `op_gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_jenis`
--
ALTER TABLE `op_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_kas`
--
ALTER TABLE `op_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_kategori`
--
ALTER TABLE `op_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_seting_lensa`
--
ALTER TABLE `op_seting_lensa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_suplaier`
--
ALTER TABLE `op_suplaier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_toko`
--
ALTER TABLE `op_toko`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `op_toko_email_toko_unique` (`email_toko`);

--
-- Indexes for table `op_toko_cabang`
--
ALTER TABLE `op_toko_cabang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_toko_cabang_id_toko_foreign` (`id_toko`);

--
-- Indexes for table `op_transaksi`
--
ALTER TABLE `op_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_transaksi_detail`
--
ALTER TABLE `op_transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `op_transaksi_keranjang`
--
ALTER TABLE `op_transaksi_keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `op_transaksi_log`
--
ALTER TABLE `op_transaksi_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `id_gudang` (`id_gudang`);

--
-- Indexes for table `op_type`
--
ALTER TABLE `op_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `op_barang`
--
ALTER TABLE `op_barang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `op_barang_cabang_stock`
--
ALTER TABLE `op_barang_cabang_stock`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `op_barang_cabang_stock_log`
--
ALTER TABLE `op_barang_cabang_stock_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `op_barang_detail`
--
ALTER TABLE `op_barang_detail`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `op_barang_gudang_stock`
--
ALTER TABLE `op_barang_gudang_stock`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `op_barang_gudang_stock_log`
--
ALTER TABLE `op_barang_gudang_stock_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `op_barang_harga`
--
ALTER TABLE `op_barang_harga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `op_gudang`
--
ALTER TABLE `op_gudang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `op_jenis`
--
ALTER TABLE `op_jenis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `op_kas`
--
ALTER TABLE `op_kas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `op_kategori`
--
ALTER TABLE `op_kategori`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `op_seting_lensa`
--
ALTER TABLE `op_seting_lensa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `op_suplaier`
--
ALTER TABLE `op_suplaier`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `op_toko`
--
ALTER TABLE `op_toko`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `op_toko_cabang`
--
ALTER TABLE `op_toko_cabang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `op_transaksi`
--
ALTER TABLE `op_transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `op_transaksi_detail`
--
ALTER TABLE `op_transaksi_detail`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `op_transaksi_keranjang`
--
ALTER TABLE `op_transaksi_keranjang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `op_transaksi_log`
--
ALTER TABLE `op_transaksi_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `op_type`
--
ALTER TABLE `op_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `op_barang`
--
ALTER TABLE `op_barang`
  ADD CONSTRAINT `op_barang_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `op_kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `op_barang_gudang_stock`
--
ALTER TABLE `op_barang_gudang_stock`
  ADD CONSTRAINT `op_barang_gudang_stock_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `op_barang_gudang_stock_id_suplaier_foreign` FOREIGN KEY (`id_suplaier`) REFERENCES `op_suplaier` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `op_barang_gudang_stock_log`
--
ALTER TABLE `op_barang_gudang_stock_log`
  ADD CONSTRAINT `op_barang_gudang_stock_log_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `op_barang_gudang_stock_log_id_suplaier_foreign` FOREIGN KEY (`id_suplaier`) REFERENCES `op_suplaier` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `op_barang_harga`
--
ALTER TABLE `op_barang_harga`
  ADD CONSTRAINT `op_barang_harga_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `op_toko_cabang`
--
ALTER TABLE `op_toko_cabang`
  ADD CONSTRAINT `op_toko_cabang_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `op_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `op_transaksi_detail`
--
ALTER TABLE `op_transaksi_detail`
  ADD CONSTRAINT `op_transaksi_detail_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `op_transaksi` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `op_transaksi_log`
--
ALTER TABLE `op_transaksi_log`
  ADD CONSTRAINT `op_transaksi_log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `op_transaksi_log_ibfk_2` FOREIGN KEY (`id_cabang`) REFERENCES `op_toko_cabang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
