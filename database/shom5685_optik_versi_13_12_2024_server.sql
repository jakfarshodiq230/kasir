-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Des 2024 pada 06.02
-- Versi server: 10.6.20-MariaDB-cll-lve-log
-- Versi PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shom5685_optik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
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
-- Struktur dari tabel `op_barang`
--

CREATE TABLE `op_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` char(50) NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `keterangan_produk` text NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_barang`
--

INSERT INTO `op_barang` (`id`, `kode_produk`, `id_kategori`, `id_gudang`, `id_user`, `nama_produk`, `keterangan_produk`, `barcode`, `created_at`, `updated_at`) VALUES
(20, 'BRG20240001', 3, 7, 3, '6', '6', '', '2024-12-12 11:20:05', '2024-12-12 11:20:05'),
(21, 'BRG20240002', 3, 7, 3, '1', '1', '', '2024-12-12 11:20:21', '2024-12-12 11:20:21'),
(25, 'BRG20240003', 3, 7, 3, 'qwwwerr', 'aws', 'barcode_barang/BRG20240003.png', '2024-12-12 14:11:43', '2024-12-12 14:11:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_barang_cabang_stock`
--

CREATE TABLE `op_barang_cabang_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_suplaier` bigint(20) UNSIGNED DEFAULT NULL,
  `id_gudang` int(10) UNSIGNED NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `stock_masuk` int(11) DEFAULT 0,
  `stock_keluar` int(11) DEFAULT 0,
  `stock_akhir` int(11) DEFAULT 0,
  `jenis_transaksi_stock` varchar(255) DEFAULT NULL,
  `keterangan_stock_cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_barang_cabang_stock`
--

INSERT INTO `op_barang_cabang_stock` (`id`, `id_barang`, `id_suplaier`, `id_gudang`, `id_toko`, `id_cabang`, `id_user`, `stock_masuk`, `stock_keluar`, `stock_akhir`, `jenis_transaksi_stock`, `keterangan_stock_cabang`, `created_at`, `updated_at`) VALUES
(4, 16, 2, 7, 1, 1, 6, 150, 2, 148, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241212-1-0001', '2024-12-11 05:40:57', '2024-12-12 07:14:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_barang_cabang_stock_log`
--

CREATE TABLE `op_barang_cabang_stock_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_suplaier` bigint(20) UNSIGNED DEFAULT NULL,
  `id_gudang` int(10) UNSIGNED NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `stock_masuk` int(11) NOT NULL DEFAULT 0,
  `stock_keluar` int(11) NOT NULL DEFAULT 0,
  `stock_akhir` int(11) NOT NULL DEFAULT 0,
  `jenis_transaksi_stock` varchar(255) DEFAULT NULL,
  `keterangan_stock_cabang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_barang_cabang_stock_log`
--

INSERT INTO `op_barang_cabang_stock_log` (`id`, `id_barang`, `id_suplaier`, `id_gudang`, `id_toko`, `id_cabang`, `id_user`, `stock_masuk`, `stock_keluar`, `stock_akhir`, `jenis_transaksi_stock`, `keterangan_stock_cabang`, `created_at`, `updated_at`) VALUES
(42, 16, 2, 7, 1, 1, 6, 100, 0, 100, 'masuk', 'Masuk stock barang masuk: 100', '2024-12-11 05:40:57', '2024-12-11 05:40:57'),
(43, 16, 2, 7, 1, 1, 6, 50, 0, 150, 'masuk', 'Masuk stock barang masuk: 50', '2024-12-11 05:41:31', '2024-12-11 05:41:31'),
(44, 16, 2, 7, 1, 1, 5, 150, 1, 149, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241112-1-0001', '2024-12-11 07:44:22', '2024-12-11 07:44:22'),
(45, 16, 2, 7, 1, 1, 5, 149, 1, 148, 'Penjualan', 'Penjualan barang dengan nomor transaksi 20241212-1-0001', '2024-12-12 07:14:09', '2024-12-12 07:14:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_barang_detail`
--

CREATE TABLE `op_barang_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_jenis` bigint(20) UNSIGNED NOT NULL,
  `id_type` bigint(20) UNSIGNED NOT NULL,
  `R_SPH` varchar(8) DEFAULT NULL,
  `L_SPH` varchar(8) DEFAULT NULL,
  `R_CYL` varchar(8) DEFAULT NULL,
  `L_CYL` varchar(8) DEFAULT NULL,
  `R_AXS` varchar(8) DEFAULT NULL,
  `L_AXS` varchar(8) DEFAULT NULL,
  `R_ADD` varchar(8) DEFAULT NULL,
  `L_ADD` varchar(8) DEFAULT NULL,
  `PD` varchar(8) DEFAULT NULL,
  `PD2` varchar(8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_barang_detail`
--

INSERT INTO `op_barang_detail` (`id`, `id_barang`, `id_jenis`, `id_type`, `R_SPH`, `L_SPH`, `R_CYL`, `L_CYL`, `R_AXS`, `L_AXS`, `R_ADD`, `L_ADD`, `PD`, `PD2`, `created_at`, `updated_at`) VALUES
(17, 20, 4, 2, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-12 11:20:05', '2024-12-12 11:20:05'),
(18, 21, 4, 2, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-12 11:20:21', '2024-12-12 11:20:59'),
(22, 25, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:11:43', '2024-12-12 14:11:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_barang_gudang_stock`
--

CREATE TABLE `op_barang_gudang_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_suplaier` bigint(20) UNSIGNED DEFAULT NULL,
  `id_gudang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `stock_masuk` int(11) NOT NULL DEFAULT 0,
  `stock_keluar` int(11) NOT NULL DEFAULT 0,
  `stock_akhir` int(11) NOT NULL DEFAULT 0,
  `jenis_transaksi_stock` varchar(255) DEFAULT NULL,
  `keterangan_stock_gudang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_barang_gudang_stock_log`
--

CREATE TABLE `op_barang_gudang_stock_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_suplaier` bigint(20) UNSIGNED DEFAULT NULL,
  `id_gudang` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `stock_masuk` int(11) NOT NULL DEFAULT 0,
  `stock_keluar` int(11) NOT NULL DEFAULT 0,
  `stock_akhir` int(11) NOT NULL DEFAULT 0,
  `jenis_transaksi_stock` varchar(255) DEFAULT NULL,
  `keterangan_stock_gudang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_barang_harga`
--

CREATE TABLE `op_barang_harga` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `harga_modal` decimal(10,0) NOT NULL,
  `harga_jual` decimal(10,0) NOT NULL,
  `harga_grosir_1` decimal(10,0) NOT NULL,
  `harga_grosir_2` decimal(10,0) NOT NULL,
  `harga_grosir_3` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_barang_harga`
--

INSERT INTO `op_barang_harga` (`id`, `id_barang`, `harga_modal`, `harga_jual`, `harga_grosir_1`, `harga_grosir_2`, `harga_grosir_3`, `created_at`, `updated_at`) VALUES
(20, 20, 6, 6, 6, 6, 6, '2024-12-12 11:20:05', '2024-12-12 11:20:05'),
(21, 21, 1, 1, 1, 1, 1, '2024-12-12 11:20:21', '2024-12-12 11:20:59'),
(25, 25, 5, 4, 1, 2, 3, '2024-12-12 14:11:43', '2024-12-12 14:11:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_gudang`
--

CREATE TABLE `op_gudang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_gudang` varchar(100) NOT NULL,
  `lokasi_gudang` varchar(255) NOT NULL,
  `deskripsi_gudang` text DEFAULT NULL,
  `status_gudang` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_gudang`
--

INSERT INTO `op_gudang` (`id`, `nama_gudang`, `lokasi_gudang`, `deskripsi_gudang`, `status_gudang`, `created_at`, `updated_at`) VALUES
(7, 'Gudang Utama', 'pekan', 'aa', '1', '2024-12-10 12:08:05', '2024-12-10 12:08:05'),
(8, 'Gudang Pusat', 'Optik Mandiri 1', 'Paset dan stock', '1', '2024-12-12 06:42:27', '2024-12-12 06:42:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_jenis`
--

CREATE TABLE `op_jenis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `status_jenis` enum('1','0') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_jenis`
--

INSERT INTO `op_jenis` (`id`, `jenis`, `status_jenis`, `created_at`, `updated_at`) VALUES
(4, 'Progressive', '1', '2024-12-11 01:48:46', '2024-12-11 01:48:46'),
(5, 'Single Vision', '1', '2024-12-11 01:49:21', '2024-12-11 01:49:21'),
(6, 'Lensa Pesan', '1', '2024-12-11 01:49:30', '2024-12-11 01:49:30'),
(7, 'Kriptok', '1', '2024-12-12 06:44:14', '2024-12-12 06:44:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_kas`
--

CREATE TABLE `op_kas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `debit` decimal(15,0) NOT NULL DEFAULT 0,
  `kredit` decimal(15,0) NOT NULL DEFAULT 0,
  `saldo` decimal(15,0) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_kas`
--

INSERT INTO `op_kas` (`id`, `id_user`, `id_cabang`, `kode_transaksi`, `tanggal`, `keterangan`, `debit`, `kredit`, `saldo`, `created_at`, `updated_at`) VALUES
(22, 5, 1, '20241112-1-0001', '2024-12-11 14:44:22', 'Saldo tambahan dari transaksi penjualan tunai dengan nomor transaksi 20241112-1-0001', 150000, 0, 150000, '2024-12-11 07:44:22', '2024-12-11 07:44:22'),
(23, 5, 1, '20241212-1-0001', '2024-12-12 14:14:09', 'Saldo tambahan dari transaksi penjualan tunai dengan nomor transaksi 20241212-1-0001', 150000, 0, 300000, '2024-12-12 07:14:09', '2024-12-12 07:14:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_kategori`
--

CREATE TABLE `op_kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `pesanan` enum('Ya','Tidak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_kategori`
--

INSERT INTO `op_kategori` (`id`, `nama_kategori`, `status`, `pesanan`, `created_at`, `updated_at`) VALUES
(3, 'Lensa', '1', 'Ya', '2024-12-10 12:02:10', '2024-12-10 12:02:10'),
(4, 'Frame', '1', 'Ya', '2024-12-10 12:02:22', '2024-12-10 12:02:22'),
(5, 'Softlens', '1', 'Ya', '2024-12-11 01:46:35', '2024-12-12 06:43:41'),
(6, 'Air Soflent', '1', 'Ya', '2024-12-11 01:46:48', '2024-12-12 06:43:26'),
(8, 'Sunglass', '1', 'Ya', '2024-12-12 06:43:15', '2024-12-12 06:43:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_pemesanan`
--

CREATE TABLE `op_pemesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` bigint(20) UNSIGNED NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `phone_transaksi` varchar(255) NOT NULL,
  `diameter` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_ambil` date NOT NULL,
  `pembayaran` varchar(255) NOT NULL,
  `jenis_transaksi` varchar(255) NOT NULL,
  `total_beli` decimal(15,0) NOT NULL,
  `diskon` decimal(15,0) NOT NULL,
  `jumlah_bayar` decimal(15,0) NOT NULL,
  `sisa_bayar` decimal(15,0) NOT NULL,
  `jumlah_bayar_dp` decimal(15,0) DEFAULT NULL,
  `jumlah_sisa_dp` decimal(15,0) DEFAULT NULL,
  `jumlah_lunas_dp` decimal(15,0) DEFAULT NULL,
  `R_SPH` varchar(8) DEFAULT NULL,
  `L_SPH` varchar(8) DEFAULT NULL,
  `R_CYL` varchar(8) DEFAULT NULL,
  `L_CYL` varchar(8) DEFAULT NULL,
  `R_AXS` varchar(8) DEFAULT NULL,
  `L_AXS` varchar(8) DEFAULT NULL,
  `R_ADD` varchar(8) DEFAULT NULL,
  `L_ADD` varchar(8) DEFAULT NULL,
  `PD` varchar(8) DEFAULT NULL,
  `PD2` varchar(8) DEFAULT NULL,
  `status_pemesanan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_pemesanan`
--

INSERT INTO `op_pemesanan` (`id`, `nomor_transaksi`, `nama`, `alamat`, `id_user`, `id_cabang`, `id_gudang`, `phone_transaksi`, `diameter`, `warna`, `tanggal_transaksi`, `tanggal_selesai`, `tanggal_ambil`, `pembayaran`, `jenis_transaksi`, `total_beli`, `diskon`, `jumlah_bayar`, `sisa_bayar`, `jumlah_bayar_dp`, `jumlah_sisa_dp`, `jumlah_lunas_dp`, `R_SPH`, `L_SPH`, `R_CYL`, `L_CYL`, `R_AXS`, `L_AXS`, `R_ADD`, `L_ADD`, `PD`, `PD2`, `status_pemesanan`, `created_at`, `updated_at`) VALUES
(6, '20241212-1-0001', 'Tttt', 'Hgg', 5, 1, 7, '081616165151', '08', 'Nerah', '2024-12-12', '2024-12-12', '2024-12-12', 'tunai', 'non_hutang', 300000, 0, 300000, 0, NULL, NULL, NULL, '5', '1', '2', '1', '2', '1', '2', '1', '1', '1', 'pesan', '2024-12-12 07:16:20', '2024-12-12 07:16:20'),
(7, '20241212-1-0002', 'Hsh', 'Mmaa', 5, 1, 7, '082626', '1', 'Nsnsbs', '2024-12-12', '2024-12-12', '2024-12-12', 'tunai', 'non_hutang', 300000, 0, 300000, 0, NULL, NULL, NULL, '11', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'pesan', '2024-12-12 07:17:44', '2024-12-12 07:17:44'),
(8, '20241212-1-0003', 'Ari', '-', 5, 1, 7, '081210635630', '0', '-', '2024-12-12', '2024-12-12', '2024-12-12', 'tunai', 'non_hutang', 150000, 0, 150000, 0, NULL, NULL, NULL, '1.00', '1.00', '0', '0', '0', '0', '0', '0', '0', '0', 'pesan', '2024-12-12 07:21:35', '2024-12-12 07:21:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_pemesanan_cart`
--

CREATE TABLE `op_pemesanan_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `harga` decimal(15,0) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `sub_total` decimal(15,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_pemesanan_cart`
--

INSERT INTO `op_pemesanan_cart` (`id`, `id_barang`, `id_cabang`, `id_user`, `kode_produk`, `harga`, `jumlah_beli`, `sub_total`, `created_at`, `updated_at`) VALUES
(31, 16, 1, 5, 'BRG20240001', 150000, 1, 150000, '2024-12-12 07:23:06', '2024-12-12 07:23:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_pemesanan_detail`
--

CREATE TABLE `op_pemesanan_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `harga_barang` decimal(15,0) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `sub_total_transaksi` decimal(15,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_pemesanan_detail`
--

INSERT INTO `op_pemesanan_detail` (`id`, `nomor_transaksi`, `id_barang`, `id_cabang`, `id_user`, `kode_produk`, `harga_barang`, `jumlah_barang`, `sub_total_transaksi`, `created_at`, `updated_at`) VALUES
(8, '20241212-1-0001', 16, 1, 5, 'BRG20240001', 150000, 1, 150000, '2024-12-12 07:16:20', '2024-12-12 07:16:20'),
(9, '20241212-1-0001', 16, 1, 5, 'BRG20240001', 150000, 1, 150000, '2024-12-12 07:16:20', '2024-12-12 07:16:20'),
(10, '20241212-1-0002', 16, 1, 5, 'BRG20240001', 150000, 1, 150000, '2024-12-12 07:17:44', '2024-12-12 07:17:44'),
(11, '20241212-1-0002', 16, 1, 5, 'BRG20240001', 150000, 1, 150000, '2024-12-12 07:17:44', '2024-12-12 07:17:44'),
(12, '20241212-1-0003', 16, 1, 5, 'BRG20240001', 150000, 1, 150000, '2024-12-12 07:21:35', '2024-12-12 07:21:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_pemesanan_log`
--

CREATE TABLE `op_pemesanan_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `status_log` varchar(255) DEFAULT NULL,
  `keterangan_log` text DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_pemesanan_log`
--

INSERT INTO `op_pemesanan_log` (`id`, `nomor_transaksi`, `status_log`, `keterangan_log`, `id_user`, `created_at`, `updated_at`) VALUES
(26, '20241212-1-0001', 'pesan', 'pemesanan berhasil', 5, '2024-12-12 07:16:20', '2024-12-12 07:16:20'),
(27, '20241212-1-0002', 'pesan', 'pemesanan berhasil', 5, '2024-12-12 07:17:44', '2024-12-12 07:17:44'),
(28, '20241212-1-0003', 'pesan', 'pemesanan berhasil', 5, '2024-12-12 07:21:35', '2024-12-12 07:21:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_penjualan`
--

CREATE TABLE `op_penjualan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `phone_transaksi` varchar(255) DEFAULT NULL,
  `diameter` int(11) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `tanggal_ambil` date DEFAULT NULL,
  `pembayaran` varchar(255) NOT NULL,
  `jenis_transaksi` varchar(255) NOT NULL,
  `total_beli` decimal(15,0) NOT NULL,
  `diskon` decimal(15,0) DEFAULT NULL,
  `jumlah_bayar` decimal(15,0) DEFAULT NULL,
  `sisa_bayar` decimal(15,0) DEFAULT NULL,
  `jumlah_bayar_dp` decimal(15,0) DEFAULT NULL,
  `jumlah_sisa_dp` decimal(15,0) DEFAULT NULL,
  `jumlah_lunas_dp` decimal(15,0) DEFAULT NULL,
  `status_penjualan` enum('lunas','belum_lunas') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_penjualan`
--

INSERT INTO `op_penjualan` (`id`, `nomor_transaksi`, `nama`, `alamat`, `id_user`, `id_cabang`, `phone_transaksi`, `diameter`, `warna`, `tanggal_transaksi`, `tanggal_selesai`, `tanggal_ambil`, `pembayaran`, `jenis_transaksi`, `total_beli`, `diskon`, `jumlah_bayar`, `sisa_bayar`, `jumlah_bayar_dp`, `jumlah_sisa_dp`, `jumlah_lunas_dp`, `status_penjualan`, `created_at`, `updated_at`) VALUES
(41, '20241112-1-0001', 'asd', 'Home', 5, 1, '083193447383', 22, 'merah', '2024-12-11', '2024-12-11', '2024-12-12', 'tunai', 'non_hutang', 150000, 0, 150000, 0, NULL, NULL, NULL, 'lunas', '2024-12-11 07:44:22', '2024-12-11 07:44:22'),
(42, '20241212-1-0001', 'Arif', '-', 5, 1, '08121063560', 0, '-', '2024-12-12', '2024-12-12', '2024-12-12', 'tunai', 'non_hutang', 150000, 0, 150000, 0, NULL, NULL, NULL, 'lunas', '2024-12-12 07:14:09', '2024-12-12 07:14:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_penjualan_cart`
--

CREATE TABLE `op_penjualan_cart` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_penjualan_detail`
--

CREATE TABLE `op_penjualan_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_produk` char(50) NOT NULL,
  `harga_barang` decimal(15,0) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `sub_total_transaksi` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_seting_lensa`
--

CREATE TABLE `op_seting_lensa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sph_dari` varchar(10) NOT NULL,
  `sph_sampai` varchar(10) NOT NULL,
  `cyl_dari` varchar(10) NOT NULL,
  `cyl_sampai` varchar(10) NOT NULL,
  `axs_dari` varchar(10) NOT NULL,
  `axs_sampai` varchar(10) NOT NULL,
  `add_dari` varchar(10) NOT NULL,
  `add_sampai` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_seting_lensa`
--

INSERT INTO `op_seting_lensa` (`id`, `sph_dari`, `sph_sampai`, `cyl_dari`, `cyl_sampai`, `axs_dari`, `axs_sampai`, `add_dari`, `add_sampai`, `created_at`, `updated_at`) VALUES
(1, '-8.00', '8.00', '-8.00', '0.00', '0', '359', '0.25', '3.00', '2024-12-01 23:54:37', '2024-12-10 06:22:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_suplaier`
--

CREATE TABLE `op_suplaier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_suplaier` varchar(100) NOT NULL,
  `nama_instansi_suplaier` varchar(100) NOT NULL,
  `kontak_suplaier` varchar(50) DEFAULT NULL,
  `alamat_suplaier` varchar(255) DEFAULT NULL,
  `keterangan_suplaier` text DEFAULT NULL,
  `status_suplaier` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_suplaier`
--

INSERT INTO `op_suplaier` (`id`, `nama_suplaier`, `nama_instansi_suplaier`, `kontak_suplaier`, `alamat_suplaier`, `keterangan_suplaier`, `status_suplaier`, `created_at`, `updated_at`) VALUES
(2, 'CV. Domba MAS', 'CV. Domba MAS', '121212121212', 'Pekanbaru', 'testes', '1', '2024-12-11 05:38:24', '2024-12-11 05:38:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_toko`
--

CREATE TABLE `op_toko` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `phone_toko` varchar(15) DEFAULT NULL,
  `email_toko` varchar(100) NOT NULL,
  `alamat_toko` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_toko`
--

INSERT INTO `op_toko` (`id`, `nama_toko`, `nama_pemilik`, `phone_toko`, `email_toko`, `alamat_toko`, `created_at`, `updated_at`) VALUES
(1, 'IRENE OPTIK', 'Jhon Yahya', '08222123123123', 'jhonyahya1969@gmail.com', 'Pekanbaru', '2024-12-01 23:54:37', '2024-12-11 01:01:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_toko_cabang`
--

CREATE TABLE `op_toko_cabang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_toko_cabang` varchar(100) NOT NULL,
  `alamat_cabang` text NOT NULL,
  `phone_cabang` varchar(15) DEFAULT NULL,
  `email_cabang` varchar(100) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `id_toko` bigint(20) UNSIGNED NOT NULL,
  `status_cabang` enum('1','0') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_toko_cabang`
--

INSERT INTO `op_toko_cabang` (`id`, `nama_toko_cabang`, `alamat_cabang`, `phone_cabang`, `email_cabang`, `latitude`, `longitude`, `id_toko`, `status_cabang`, `created_at`, `updated_at`) VALUES
(1, 'Irene Optik', 'Jl. Hr. Subrantas No.40, Panam, Pekanbaru', '082108222208', 'mainbranch@example.com', '0.526246', '101.451573', 1, '1', '2024-12-01 23:54:37', '2024-12-10 17:14:20'),
(7, 'Optik Mandiri', 'Jl. Subrantas', '08125624156156', 'optikmandiripku@gmail.com', '0.984944', '101.337891', 1, '1', '2024-12-12 06:48:14', '2024-12-12 06:48:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `op_type`
--

CREATE TABLE `op_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `status_type` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `op_type`
--

INSERT INTO `op_type` (`id`, `type`, `status_type`, `created_at`, `updated_at`) VALUES
(2, 'CR', '1', '2024-12-10 06:20:32', '2024-12-10 06:20:32'),
(3, 'Blueray', '1', '2024-12-10 06:20:40', '2024-12-10 06:20:40'),
(4, 'Photochromic', '1', '2024-12-11 01:50:16', '2024-12-12 06:44:29'),
(5, 'Drive', '1', '2024-12-11 01:50:28', '2024-12-11 01:50:28'),
(6, 'Blue Chromic', '1', '2024-12-11 01:50:40', '2024-12-11 01:50:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('shodiqsolution@gmail.com', '$2y$12$LRYxnZKU9QtnrfOvypZdbOTilRnbpkR5zxS7qKUnlSVfawf5E47oS', '2024-12-08 23:08:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('mKFacONkmoj7mjKBUHSL7N1CMJHDG3SQH2uzhgB3', NULL, '178.62.54.89', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajJ1dmZwNDVzVEhWRHNFTVhXc2pXN2RJanpJWndIcmhQQ0RYUjVWbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LmRldi5vcHRpay5zaG9kaXFzb2x1dGlvbi5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1734007981),
('mYz8AtprbADumnppVC56RYDUjcLrSZXSjhb95qO6', NULL, '178.62.54.89', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkd6Z0VEUWdpY0I4ZXhnREV3NkNrWEFzQUpxQ3pRSjA0UWtJVjdOeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly93d3cuZGV2Lm9wdGlrLnNob2RpcXNvbHV0aW9uLnNpdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734007980),
('mZtDORnt83yRZDZ0MnT7Hs5EZv50qN1eUEpO9xRT', 3, '36.70.154.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IkRSWGc3UXI2d013STR5WHIzUm9sakNSU0VVdmEyUWluajA2WmZTZHIiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUxOiJodHRwczovL2Rldi5vcHRpay5zaG9kaXFzb2x1dGlvbi5zaXRlL2d1ZGFuZy1iYXJhbmciO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6OToiY2FiYW5nX2lkIjtpOjE7czoxMToiY2FiYW5nX25hbWEiO3M6MTE6IklyZW5lIE9wdGlrIjtzOjc6InRva29faWQiO2k6MTtzOjk6InRva29fbmFtYSI7czoxMToiSVJFTkUgT1BUSUsiO3M6OToiZ3VkYW5nX2lkIjtpOjc7czoxMToiZ3VkYW5nX25hbWEiO3M6MTI6Ikd1ZGFuZyBVdGFtYSI7fQ==', 1734019636),
('nhkY3N1aZikX7d9PIb7u1vBkKNjIurUwuHApeVqp', NULL, '36.73.69.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzhNelRaN0JJdE1Md2wwRGNPNzhDNmRoMVl6OXVNT0oya2VEZEFoSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vZGV2Lm9wdGlrLnNob2RpcXNvbHV0aW9uLnNpdGUvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734017925),
('o8cLWePs4gsc5W5xpjsEb3uZVfSSlvZo1uNCAKRe', NULL, '103.158.102.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3o0SU5pbElyTXI3RkVVZ2V3QXpyMmVGRjQxNjBUZmNQWVV5TlhiMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vZGV2Lm9wdGlrLnNob2RpcXNvbHV0aW9uLnNpdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734018485),
('wRlGu2tDMLHcTNuPKWCMXRHYUcQqNyIozcwaP1zd', NULL, '104.166.80.111', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEdyTk52SHUyRFlFa2wxRW40SjAydE9QN3QxSWVHeUxudTFzdGdSdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LmRldi5vcHRpay5zaG9kaXFzb2x1dGlvbi5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1734012246);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_toko` int(11) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `id_gudang` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `level_user` enum('owner','admin','kasir','gudang') NOT NULL,
  `status_user` enum('1','0') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_toko`, `id_cabang`, `id_gudang`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `level_user`, `status_user`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, NULL, 'Jakfar', 'jakfarshodiq1496@gmail.com', '2024-12-02 08:09:57', '$2y$12$iAAs2SOzxlhGY6OgfhWQsO0.D5IQ.rjncBRCNVkeLktK31Q0loLb2', NULL, 'owner', '1', '2024-12-02 05:54:25', '2024-12-02 05:54:25'),
(3, 1, 1, 7, 'Gudang', 'gudang@gmail.com', '2024-12-02 13:53:01', '$2y$12$4rDl4E1GjdWTX9uls4vY9Ot94IoxCiOQU.VYU7zeXn5oFzkjOTDiq', NULL, 'gudang', '1', '2024-12-02 13:32:23', '2024-12-12 06:58:01'),
(5, 1, 1, NULL, 'Kasir', 'kasir@gmail.com', '2024-12-01 17:00:00', '$2y$12$rjZ/roXirYlOs7dHNwNjiOQ0Z7y3cPTFfAgOiLXSOjtw1LVbyNxUe', NULL, 'kasir', '1', '2024-12-02 13:52:02', '2024-12-11 05:32:14'),
(6, 1, 1, 1, 'admin', 'admin@gmail.com', '2024-12-02 13:53:43', '$2y$12$0KRQAX4ImxGIckXRET4jVeyA4b53/LPOc2kFUcV4zWHdFvsdcW8v2', NULL, 'admin', '1', '2024-12-02 13:52:18', '2024-12-09 14:21:18'),
(10, 1, NULL, NULL, 'irene optik', 'ireneoptikpku@gmail.com', '2024-12-09 11:45:58', '$2y$12$iAAs2SOzxlhGY6OgfhWQsO0.D5IQ.rjncBRCNVkeLktK31Q0loLb2', NULL, 'owner', '1', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_barang`
--
ALTER TABLE `op_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_barang_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `op_barang_cabang_stock`
--
ALTER TABLE `op_barang_cabang_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_barang_cabang_stock_log`
--
ALTER TABLE `op_barang_cabang_stock_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_barang_detail`
--
ALTER TABLE `op_barang_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_barang_gudang_stock`
--
ALTER TABLE `op_barang_gudang_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_barang_gudang_stock_id_barang_foreign` (`id_barang`),
  ADD KEY `op_barang_gudang_stock_id_suplaier_foreign` (`id_suplaier`);

--
-- Indeks untuk tabel `op_barang_gudang_stock_log`
--
ALTER TABLE `op_barang_gudang_stock_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_barang_gudang_stock_log_id_barang_foreign` (`id_barang`),
  ADD KEY `op_barang_gudang_stock_log_id_suplaier_foreign` (`id_suplaier`);

--
-- Indeks untuk tabel `op_barang_harga`
--
ALTER TABLE `op_barang_harga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `op_gudang`
--
ALTER TABLE `op_gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_jenis`
--
ALTER TABLE `op_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_kas`
--
ALTER TABLE `op_kas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `op_kas_kode_transaksi_unique` (`kode_transaksi`);

--
-- Indeks untuk tabel `op_kategori`
--
ALTER TABLE `op_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_pemesanan`
--
ALTER TABLE `op_pemesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_pemesanan_cart`
--
ALTER TABLE `op_pemesanan_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_pemesanan_detail`
--
ALTER TABLE `op_pemesanan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_pemesanan_log`
--
ALTER TABLE `op_pemesanan_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_penjualan`
--
ALTER TABLE `op_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_transaksi` (`nomor_transaksi`);

--
-- Indeks untuk tabel `op_penjualan_cart`
--
ALTER TABLE `op_penjualan_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_penjualan_detail`
--
ALTER TABLE `op_penjualan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor_transaksi` (`nomor_transaksi`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `op_seting_lensa`
--
ALTER TABLE `op_seting_lensa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_suplaier`
--
ALTER TABLE `op_suplaier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `op_toko`
--
ALTER TABLE `op_toko`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `op_toko_email_toko_unique` (`email_toko`);

--
-- Indeks untuk tabel `op_toko_cabang`
--
ALTER TABLE `op_toko_cabang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_toko_cabang_id_toko_foreign` (`id_toko`);

--
-- Indeks untuk tabel `op_type`
--
ALTER TABLE `op_type`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `op_barang`
--
ALTER TABLE `op_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `op_barang_cabang_stock`
--
ALTER TABLE `op_barang_cabang_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `op_barang_cabang_stock_log`
--
ALTER TABLE `op_barang_cabang_stock_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `op_barang_detail`
--
ALTER TABLE `op_barang_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `op_barang_gudang_stock`
--
ALTER TABLE `op_barang_gudang_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `op_barang_gudang_stock_log`
--
ALTER TABLE `op_barang_gudang_stock_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `op_barang_harga`
--
ALTER TABLE `op_barang_harga`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `op_gudang`
--
ALTER TABLE `op_gudang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `op_jenis`
--
ALTER TABLE `op_jenis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `op_kas`
--
ALTER TABLE `op_kas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `op_kategori`
--
ALTER TABLE `op_kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `op_pemesanan`
--
ALTER TABLE `op_pemesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `op_pemesanan_cart`
--
ALTER TABLE `op_pemesanan_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `op_pemesanan_detail`
--
ALTER TABLE `op_pemesanan_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `op_pemesanan_log`
--
ALTER TABLE `op_pemesanan_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `op_penjualan`
--
ALTER TABLE `op_penjualan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `op_penjualan_cart`
--
ALTER TABLE `op_penjualan_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `op_penjualan_detail`
--
ALTER TABLE `op_penjualan_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `op_seting_lensa`
--
ALTER TABLE `op_seting_lensa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `op_suplaier`
--
ALTER TABLE `op_suplaier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `op_toko`
--
ALTER TABLE `op_toko`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `op_toko_cabang`
--
ALTER TABLE `op_toko_cabang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `op_type`
--
ALTER TABLE `op_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `op_barang`
--
ALTER TABLE `op_barang`
  ADD CONSTRAINT `op_barang_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `op_kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `op_barang_gudang_stock`
--
ALTER TABLE `op_barang_gudang_stock`
  ADD CONSTRAINT `op_barang_gudang_stock_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `op_barang_gudang_stock_id_suplaier_foreign` FOREIGN KEY (`id_suplaier`) REFERENCES `op_suplaier` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `op_barang_gudang_stock_log`
--
ALTER TABLE `op_barang_gudang_stock_log`
  ADD CONSTRAINT `op_barang_gudang_stock_log_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `op_barang_gudang_stock_log_id_suplaier_foreign` FOREIGN KEY (`id_suplaier`) REFERENCES `op_suplaier` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `op_barang_harga`
--
ALTER TABLE `op_barang_harga`
  ADD CONSTRAINT `op_barang_harga_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `op_penjualan_detail`
--
ALTER TABLE `op_penjualan_detail`
  ADD CONSTRAINT `op_penjualan_detail_ibfk_1` FOREIGN KEY (`nomor_transaksi`) REFERENCES `op_penjualan` (`nomor_transaksi`) ON DELETE CASCADE,
  ADD CONSTRAINT `op_penjualan_detail_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `op_barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `op_toko_cabang`
--
ALTER TABLE `op_toko_cabang`
  ADD CONSTRAINT `op_toko_cabang_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `op_toko` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
