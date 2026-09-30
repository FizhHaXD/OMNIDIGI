-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2026 at 10:42 AM
-- Server version: 5.7.39
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pln_digi`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `meter_reading_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `tahun` smallint(5) UNSIGNED NOT NULL,
  `total_kwh` decimal(10,2) NOT NULL,
  `total_biaya` decimal(15,2) NOT NULL,
  `denda` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('unpaid','paid','overdue') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `tanggal_jatuh_tempo` date NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `customer_id`, `meter_reading_id`, `bulan`, `tahun`, `total_kwh`, `total_biaya`, `denda`, `status`, `tanggal_jatuh_tempo`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 7, 2026, '197.00', '284606.90', '0.00', 'paid', '2026-07-31', '2026-07-09', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(2, 1, 2, 8, 2026, '198.00', '286050.60', '0.00', 'paid', '2026-08-31', '2026-09-21', '2026-09-13 21:26:54', '2026-09-21 10:10:07'),
(3, 2, 4, 8, 2026, '312.00', '518237.40', '0.00', 'unpaid', '2026-08-31', NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(4, 3, 6, 8, 2026, '132.00', '99860.00', '0.00', 'paid', '2026-08-31', '2026-08-11', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(5, 4, 8, 8, 2026, '550.00', '983908.50', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(6, 1, 3, 9, 2026, '198.00', '286050.60', '0.00', 'paid', '2026-09-30', '2026-09-22', '2026-09-21 10:16:17', '2026-09-22 07:42:53'),
(7, 1, 11, 10, 2026, '207.00', '299052.90', '0.00', 'paid', '2026-10-31', '2026-09-21', '2026-09-21 10:16:30', '2026-09-21 10:40:31'),
(8, 9, 12, 7, 2026, '160.00', '231152.00', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(9, 9, 13, 8, 2026, '168.00', '242709.60', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(10, 9, 14, 9, 2026, '197.00', '284605.90', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(11, 10, 15, 7, 2026, '200.00', '121000.00', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(12, 10, 16, 8, 2026, '212.00', '128260.00', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(13, 10, 17, 9, 2026, '190.00', '114950.00', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(14, 11, 18, 7, 2026, '186.00', '268714.20', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(15, 11, 19, 8, 2026, '160.00', '231152.00', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(16, 11, 20, 9, 2026, '229.00', '330836.30', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(17, 12, 21, 7, 2026, '218.00', '314944.60', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(18, 12, 22, 8, 2026, '198.00', '286050.60', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(19, 12, 23, 9, 2026, '236.00', '340949.20', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(20, 13, 24, 7, 2026, '209.00', '301942.30', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(21, 13, 25, 8, 2026, '201.00', '290384.70', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(22, 13, 26, 9, 2026, '225.00', '325057.50', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(23, 14, 27, 7, 2026, '185.00', '111925.00', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:40:35'),
(24, 14, 28, 8, 2026, '180.00', '108900.00', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(25, 14, 29, 9, 2026, '209.00', '126445.00', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(26, 15, 30, 7, 2026, '199.00', '287495.30', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(27, 15, 31, 8, 2026, '213.00', '307721.10', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(28, 15, 32, 9, 2026, '227.00', '327946.90', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(29, 16, 33, 7, 2026, '183.00', '264380.10', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(30, 16, 34, 8, 2026, '188.00', '271603.60', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(31, 16, 35, 9, 2026, '180.00', '260046.00', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(32, 17, 36, 7, 2026, '193.00', '80095.00', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(33, 17, 37, 8, 2026, '200.00', '83000.00', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(34, 17, 38, 9, 2026, '165.00', '68475.00', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(35, 18, 39, 7, 2026, '208.00', '300497.60', '0.00', 'paid', '2026-07-31', '2026-07-20', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(36, 18, 40, 8, 2026, '215.00', '310610.50', '0.00', 'paid', '2026-08-31', '2026-08-23', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(37, 18, 41, 9, 2026, '171.00', '247043.70', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(38, 19, 42, 7, 2026, '308.00', '444967.60', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(39, 19, 43, 8, 2026, '289.00', '417518.30', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(40, 19, 44, 9, 2026, '289.00', '417518.30', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(41, 20, 45, 7, 2026, '450.00', '650115.00', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(42, 20, 46, 8, 2026, '281.00', '405960.70', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(43, 20, 47, 9, 2026, '400.00', '577880.00', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(44, 21, 48, 7, 2026, '385.00', '654319.05', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(45, 21, 49, 8, 2026, '276.00', '469070.28', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(46, 21, 50, 9, 2026, '493.00', '837868.29', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(47, 22, 51, 7, 2026, '344.00', '208120.00', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(48, 22, 52, 8, 2026, '403.00', '243815.00', '25000.00', 'paid', '2026-08-31', '2026-09-28', '2026-09-28 02:40:35', '2026-09-28 04:19:50'),
(49, 22, 53, 9, 2026, '281.00', '170005.00', '0.00', 'paid', '2026-09-30', '2026-09-28', '2026-09-28 02:40:35', '2026-09-28 04:18:49'),
(50, 23, 54, 7, 2026, '385.00', '556209.50', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(51, 23, 55, 8, 2026, '311.00', '449301.70', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(52, 23, 56, 9, 2026, '271.00', '391513.70', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(53, 24, 57, 7, 2026, '312.00', '450746.40', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(54, 24, 58, 8, 2026, '413.00', '596661.10', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(55, 24, 59, 9, 2026, '455.00', '657338.50', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(56, 25, 60, 7, 2026, '307.00', '521755.71', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(57, 25, 61, 8, 2026, '414.00', '703605.42', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(58, 25, 62, 9, 2026, '388.00', '659417.64', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(59, 26, 63, 7, 2026, '400.00', '577880.00', '50000.00', 'overdue', '2026-07-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(60, 26, 64, 8, 2026, '350.00', '505645.00', '25000.00', 'overdue', '2026-08-31', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(61, 26, 65, 9, 2026, '455.00', '657338.50', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(62, 35, 66, 8, 2026, '180.00', '260046.00', '0.00', 'paid', '2026-08-31', '2026-08-22', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(63, 36, 68, 8, 2026, '180.00', '260046.00', '0.00', 'paid', '2026-08-31', '2026-08-22', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(64, 37, 70, 8, 2026, '180.00', '108900.00', '0.00', 'paid', '2026-08-31', '2026-08-22', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(65, 38, 72, 8, 2026, '180.00', '260046.00', '0.00', 'paid', '2026-08-31', '2026-08-22', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(66, 39, 74, 8, 2026, '180.00', '305915.40', '0.00', 'paid', '2026-08-31', '2026-08-22', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(67, 40, 76, 8, 2026, '180.00', '260046.00', '0.00', 'paid', '2026-08-31', '2026-08-22', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(68, 46, 78, 8, 2026, '1161.00', '1677296.70', '0.00', 'paid', '2026-08-31', '2026-08-24', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(69, 46, 79, 9, 2026, '1246.00', '1800096.20', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(70, 47, 80, 8, 2026, '1535.00', '2608778.55', '0.00', 'paid', '2026-08-31', '2026-08-24', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(71, 47, 81, 9, 2026, '1642.00', '2790628.26', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(72, 48, 82, 8, 2026, '1255.00', '1813098.50', '0.00', 'paid', '2026-08-31', '2026-08-24', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(73, 48, 83, 9, 2026, '1517.00', '2191609.90', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(74, 49, 84, 8, 2026, '1002.00', '606210.00', '0.00', 'paid', '2026-08-31', '2026-08-24', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(75, 49, 85, 9, 2026, '1196.00', '723580.00', '0.00', 'unpaid', '2026-09-30', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tariff_id` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `tariff_id`, `id_pelanggan`, `nama`, `alamat`, `nomor_telepon`, `email`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '531200012345', 'Hafizh Wijdan', 'Jl. Merdeka No. 10, Jakarta Pusat', '081234567890', 'hafizh@mail.com', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(2, NULL, 4, '531200026789', 'Budi Santoso', 'Jl. Sudirman No. 25, Bandung', '082345678901', NULL, 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(3, NULL, 2, '531200031122', 'Siti Rahayu', 'Jl. Gatot Subroto No. 5, Surabaya', '083456789012', NULL, 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(4, NULL, 7, '531200043344', 'Ahmad Fauzi', 'Jl. Diponegoro No. 15, Semarang', '084567890123', 'ahmad@bisnis.com', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(5, NULL, 3, '531200055566', 'Dewi Lestari', 'Jl. Ahmad Yani No. 30, Medan', '085678901234', NULL, 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(6, NULL, 1, '531200066677', 'Rizky Pratama', 'Jl. Pahlawan No. 8, Yogyakarta', '086789012345', NULL, 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(7, NULL, 5, '531200077788', 'Anita Susanti', 'Jl. Pemuda No. 50, Makassar', '087890123456', NULL, 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(8, NULL, 9, '531200088899', 'SDN Merdeka 01', 'Jl. Pendidikan No. 1, Bandung', '088901234567', 'sdn.merdeka@mail.com', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(9, 4, 3, '531100000001', 'Bambang Sudarsono', 'Jl. Mawar No. 108, Komplek PLN, Jakarta Selatan, DKI Jakarta', '08154883893', 'bambang.s@plndigi.com', 1, '2026-09-28 02:39:15', '2026-09-28 02:41:40'),
(10, 5, 2, '532100000002', 'Siti Nurhaliza Putri', 'Jl. Dahlia No. 120, Kelurahan Sukamaju, Bandung, Jawa Barat', '08123581058', 'siti.nur@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(11, 6, 4, '533100000003', 'Hendra Gunawan', 'Jl. Kenanga Indah No. 61, Surabaya, Jawa Timur', '08203647144', 'hendra.g@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(12, 7, 3, '534100000004', 'Rina Agustina', 'Jl. Cempaka Putih Raya No. 136, Semarang, Jawa Tengah', '08121626909', 'rina.agustina@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(13, 8, 3, '534200000005', 'Dimas Arya Pratama', 'Jl. Flamboyan No. 101, Blok B4, Yogyakarta, DI Yogyakarta', '08172401090', 'dimas.arya@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(14, 9, 2, '535100000006', 'Maya Indah Safitri', 'Jl. Garuda No. 71, Perumahan Asri, Medan, Sumatera Utara', '08225409998', 'maya.indah@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(15, 10, 4, '536100000007', 'Joko Tri Wahyudi', 'Jl. Rajawali Barat No. 141, Makassar, Sulawesi Selatan', '08233607080', 'joko.tri@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(16, 11, 3, '537100000008', 'Sri Wahyuni', 'Jl. Diponegoro No. 133, Denpasar, Bali', '08179171703', 'sri.wahyuni@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(17, 12, 1, '533200000009', 'Arif Budiman', 'Jl. Jend. Sudirman Kav. 28, Malang, Jawa Timur', '08148302651', 'arif.budiman@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(18, 13, 3, '538100000010', 'Nurmala Sari', 'Jl. Melati No. 105, RT 02/RW 05, Palembang, Sumatera Selatan', '08211995055', 'nurmala.sari@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(19, 14, 4, '532200000011', 'Agus Priyanto', 'Jl. Mawar No. 104, Komplek PLN, Bekasi, Jawa Barat', '08192758491', 'agus.priyanto@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(20, 15, 3, '531300000012', 'Tri Handayani', 'Jl. Dahlia No. 58, Kelurahan Sukamaju, Jakarta Timur, DKI Jakarta', '08173768793', 'tri.handayani@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(21, 16, 5, '532100000013', 'Wawan Kurniawan', 'Jl. Kenanga Indah No. 128, Bandung, Jawa Barat', '08197679293', 'wawan.kurnia@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(22, NULL, 2, '533100000014', 'Ratna Juwita', 'Jl. Cempaka Putih Raya No. 71, Surabaya, Jawa Timur', '08224683293', 'ratna.juwita@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(23, 18, 4, '531400000015', 'Dedi Iskandar', 'Jl. Flamboyan No. 90, Blok B4, Tangerang, Banten', '08206190538', 'dedi.iskandar@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(24, 19, 3, '532300000016', 'Endang Sulastri', 'Jl. Garuda No. 57, Perumahan Asri, Cimahi, Jawa Barat', '08177141143', 'endang.sulastri@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(25, 20, 5, '535200000017', 'Ferry Andika', 'Jl. Rajawali Barat No. 38, Batam, Kepulauan Riau', '08142675850', 'ferry.andika@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(26, 21, 7, '533100000018', 'CV Abadi Surya Makmur', 'Jl. Diponegoro No. 36, Surabaya, Jawa Timur', '08128422752', 'surya.abadi@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(27, 22, 3, '531500000019', 'Bayu Wicaksono', 'Jl. Jend. Sudirman Kav. 95, Jakarta Barat, DKI Jakarta', '08145572581', 'bayu.wicaksono@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(28, 23, 2, '534300000020', 'Dian Kusuma Wardani', 'Jl. Melati No. 139, RT 02/RW 05, Surakarta, Jawa Tengah', '08232434833', 'dian.kusuma@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(29, 24, 4, '532400000021', 'Fajar Nugroho', 'Jl. Mawar No. 90, Komplek PLN, Depok, Jawa Barat', '08154563027', 'fajar.nugroho@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(30, 25, 3, '532500000022', 'Gita Gutawa Putri', 'Jl. Dahlia No. 39, Kelurahan Sukamaju, Bogor, Jawa Barat', '08233038919', 'gita.putri@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(31, 26, 3, '535300000023', 'Ilham Maulana', 'Jl. Kenanga Indah No. 113, Padang, Sumatera Barat', '08168219921', 'ilham.maulana@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(32, 27, 2, '535400000024', 'Lestari Handoko', 'Jl. Cempaka Putih Raya No. 117, Pekanbaru, Riau', '08111925486', 'lestari.handoko@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(33, 28, 4, '536200000025', 'Reza Fahlevi', 'Jl. Flamboyan No. 31, Blok B4, Balikpapan, Kalimantan Timur', '08131092627', 'reza.fahlevi@plndigi.com', 1, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(34, 29, 3, '536300000026', 'Sinta Maharani', 'Jl. Garuda No. 114, Perumahan Asri, Pontianak, Kalimantan Barat', '08226364661', 'sinta.maharani@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(35, 36, 3, '531700000033', 'Eko Prasetyo', 'Jl. Kenanga Indah No. 109, Tangerang Selatan, Banten', '08209929785', 'eko.prasetyo@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(36, 37, 4, '533400000034', 'Yuni Shara Kusuma', 'Jl. Cempaka Putih Raya No. 88, Batu, Jawa Timur', '08172459290', 'yuni.shara@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(37, 38, 2, '532600000035', 'Gunawan Wibisono', 'Jl. Flamboyan No. 74, Blok B4, Cirebon, Jawa Barat', '08204407087', 'gunawan.w@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(38, 39, 3, '533500000036', 'Dewi Persik Cahyani', 'Jl. Garuda No. 118, Perumahan Asri, Sidoarjo, Jawa Timur', '08131907208', 'dewi.persik@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(39, 40, 5, '532700000037', 'Teguh Firmansyah', 'Jl. Rajawali Barat No. 58, Sukabumi, Jawa Barat', '08138631346', 'teguh.f@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(40, 41, 3, '534400000038', 'Mega Utami Putri', 'Jl. Diponegoro No. 37, Magelang, Jawa Tengah', '08189779264', 'mega.utami@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(41, 42, 4, '531200000039', 'Rizky Billar Pratama', 'Jl. Jend. Sudirman Kav. 80, Jakarta Selatan, DKI Jakarta', '08163771649', 'rizky.billar@plndigi.com', 1, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(42, 43, 3, '532100000040', 'Anisa Rahmawati', 'Jl. Melati No. 106, RT 02/RW 05, Bandung, Jawa Barat', '08158302194', 'anisa.rahma@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(43, 44, 3, '534200000041', 'Bagus Dwi Saputra', 'Jl. Mawar No. 36, Komplek PLN, Yogyakarta, DI Yogyakarta', '08137343457', 'bagus.dwi@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(44, 45, 5, '533100000042', 'Citra Kirana Sari', 'Jl. Dahlia No. 20, Kelurahan Sukamaju, Surabaya, Jawa Timur', '08197099525', 'citra.kirana@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(45, 46, 4, '534100000043', 'Danang Sutrisno', 'Jl. Kenanga Indah No. 120, Semarang, Jawa Tengah', '08211266115', 'danang.s@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(46, 47, 7, '531200000044', 'Farhan Kopi Kenangan', 'Jl. Cempaka Putih Raya No. 56, Jakarta Selatan, DKI Jakarta', '08175104895', 'kopi.kenangan@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(47, 48, 8, '532100000045', 'H. Syukur Resto Minang', 'Jl. Flamboyan No. 20, Blok B4, Bandung, Jawa Barat', '08147020563', 'resto.minang@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(48, 49, 7, '533100000046', 'Erwin Jaya Percetakan', 'Jl. Garuda No. 79, Perumahan Asri, Surabaya, Jawa Timur', '08183839297', 'jaya.grafika@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(49, 50, 9, '535100000047', 'dr. Maya Klinik Pratama', 'Jl. Rajawali Barat No. 122, Medan, Sumatera Utara', '08142251038', 'klinik.sehat@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(50, 51, 3, '536100000048', 'Lukman Hakim', 'Jl. Diponegoro No. 94, Makassar, Sulawesi Selatan', '08151232395', 'lukman.hakim@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(51, 52, 4, '537100000049', 'Widya Ningsih', 'Jl. Jend. Sudirman Kav. 33, Denpasar, Bali', '08208955906', 'widya.ningsih@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(52, 53, 3, '538100000050', 'Hasan Basri', 'Jl. Melati No. 67, RT 02/RW 05, Palembang, Sumatera Selatan', '08189912080', 'hasan.basri@plndigi.com', 1, '2026-09-28 02:41:41', '2026-09-28 02:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meter_readings`
--

CREATE TABLE `meter_readings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `tahun` smallint(5) UNSIGNED NOT NULL,
  `meteran_awal` int(10) UNSIGNED NOT NULL,
  `meteran_akhir` int(10) UNSIGNED NOT NULL,
  `total_kwh` int(10) UNSIGNED GENERATED ALWAYS AS ((`meteran_akhir` - `meteran_awal`)) STORED,
  `status` enum('pending','verified','billed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meter_readings`
--

INSERT INTO `meter_readings` (`id`, `customer_id`, `bulan`, `tahun`, `meteran_awal`, `meteran_akhir`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 2026, 1250, 1447, 'billed', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(2, 1, 8, 2026, 1447, 1645, 'billed', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(3, 1, 9, 2026, 1645, 1843, 'billed', '2026-09-13 21:26:53', '2026-09-21 10:16:17'),
(4, 2, 8, 2026, 3200, 3512, 'billed', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(5, 2, 9, 2026, 3512, 3820, 'verified', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(6, 3, 8, 2026, 890, 1022, 'billed', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(7, 3, 9, 2026, 1022, 1150, 'verified', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(8, 4, 8, 2026, 7800, 8350, 'billed', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(9, 4, 9, 2026, 8350, 8900, 'verified', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(10, 5, 9, 2026, 2100, 2320, 'verified', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(11, 1, 10, 2026, 1843, 2050, 'billed', '2026-09-21 10:16:30', '2026-09-21 10:16:30'),
(12, 9, 7, 2026, 1000, 1160, 'billed', '2026-09-28 02:40:34', '2026-09-28 02:41:40'),
(13, 9, 8, 2026, 1160, 1328, 'billed', '2026-09-28 02:40:34', '2026-09-28 02:41:40'),
(14, 9, 9, 2026, 1328, 1525, 'billed', '2026-09-28 02:40:34', '2026-09-28 02:41:40'),
(15, 10, 7, 2026, 1000, 1200, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(16, 10, 8, 2026, 1200, 1412, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(17, 10, 9, 2026, 1412, 1602, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(18, 11, 7, 2026, 1000, 1186, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(19, 11, 8, 2026, 1186, 1346, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(20, 11, 9, 2026, 1346, 1575, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(21, 12, 7, 2026, 1000, 1218, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(22, 12, 8, 2026, 1218, 1416, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(23, 12, 9, 2026, 1416, 1652, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(24, 13, 7, 2026, 1000, 1209, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(25, 13, 8, 2026, 1209, 1410, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(26, 13, 9, 2026, 1410, 1635, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(27, 14, 7, 2026, 1000, 1185, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:40:35'),
(28, 14, 8, 2026, 1185, 1365, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(29, 14, 9, 2026, 1365, 1574, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(30, 15, 7, 2026, 1000, 1199, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(31, 15, 8, 2026, 1199, 1412, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(32, 15, 9, 2026, 1412, 1639, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(33, 16, 7, 2026, 1000, 1183, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(34, 16, 8, 2026, 1183, 1371, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(35, 16, 9, 2026, 1371, 1551, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(36, 17, 7, 2026, 1000, 1193, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(37, 17, 8, 2026, 1193, 1393, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(38, 17, 9, 2026, 1393, 1558, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(39, 18, 7, 2026, 1000, 1208, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(40, 18, 8, 2026, 1208, 1423, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(41, 18, 9, 2026, 1423, 1594, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(42, 19, 7, 2026, 2000, 2308, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(43, 19, 8, 2026, 2308, 2597, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(44, 19, 9, 2026, 2597, 2886, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(45, 20, 7, 2026, 2000, 2450, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(46, 20, 8, 2026, 2450, 2731, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(47, 20, 9, 2026, 2731, 3131, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(48, 21, 7, 2026, 2000, 2385, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(49, 21, 8, 2026, 2385, 2661, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(50, 21, 9, 2026, 2661, 3154, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(51, 22, 7, 2026, 2000, 2344, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(52, 22, 8, 2026, 2344, 2747, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(53, 22, 9, 2026, 2747, 3028, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(54, 23, 7, 2026, 2000, 2385, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(55, 23, 8, 2026, 2385, 2696, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(56, 23, 9, 2026, 2696, 2967, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(57, 24, 7, 2026, 2000, 2312, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(58, 24, 8, 2026, 2312, 2725, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(59, 24, 9, 2026, 2725, 3180, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(60, 25, 7, 2026, 2000, 2307, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(61, 25, 8, 2026, 2307, 2721, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(62, 25, 9, 2026, 2721, 3109, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(63, 26, 7, 2026, 2000, 2400, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(64, 26, 8, 2026, 2400, 2750, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(65, 26, 9, 2026, 2750, 3205, 'billed', '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(66, 35, 8, 2026, 1500, 1680, 'billed', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(67, 35, 9, 2026, 1680, 1875, 'pending', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(68, 36, 8, 2026, 1500, 1680, 'billed', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(69, 36, 9, 2026, 1680, 1875, 'pending', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(70, 37, 8, 2026, 1500, 1680, 'billed', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(71, 37, 9, 2026, 1680, 1875, 'pending', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(72, 38, 8, 2026, 1500, 1680, 'billed', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(73, 38, 9, 2026, 1680, 1875, 'verified', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(74, 39, 8, 2026, 1500, 1680, 'billed', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(75, 39, 9, 2026, 1680, 1875, 'verified', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(76, 40, 8, 2026, 1500, 1680, 'billed', '2026-09-28 02:40:36', '2026-09-28 02:40:36'),
(77, 40, 9, 2026, 1680, 1875, 'verified', '2026-09-28 02:40:36', '2026-09-30 01:10:05'),
(78, 46, 8, 2026, 10000, 11161, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(79, 46, 9, 2026, 11161, 12407, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(80, 47, 8, 2026, 10000, 11535, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(81, 47, 9, 2026, 11535, 13177, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(82, 48, 8, 2026, 10000, 11255, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(83, 48, 9, 2026, 11255, 12772, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(84, 49, 8, 2026, 10000, 11002, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(85, 49, 9, 2026, 11002, 12198, 'billed', '2026-09-28 02:41:41', '2026-09-28 02:41:41');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_02_000002_create_tariff_categories_table', 1),
(5, '2026_09_02_000003_create_tariffs_table', 1),
(6, '2026_09_02_000004_create_payment_methods_table', 1),
(7, '2026_09_02_000007_create_customers_table', 1),
(8, '2026_09_02_000008_create_meter_readings_table', 1),
(9, '2026_09_02_000009_create_bills_table', 1),
(10, '2026_09_02_000010_create_transactions_table', 1),
(11, '2026_09_14_000001_create_outage_reports_table', 1),
(12, '2026_09_14_000002_create_news_table', 1),
(13, '2026_09_28_000001_create_reward_claims_table', 2),
(14, '2026_09_29_202620_add_avatar_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` enum('info','promo','gangguan','tips') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `judul`, `slug`, `konten`, `gambar`, `kategori`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'PLN Hadirkan Layanan Digital Terintegrasi untuk Pelanggan', 'pln-hadirkan-layanan-digital-terintegrasi', 'PT PLN (Persero) terus berinovasi dalam menghadirkan layanan digital yang terintegrasi untuk kemudahan pelanggan. Melalui aplikasi PLN DIGI, pelanggan kini dapat mengakses berbagai layanan kelistrikan seperti pembayaran tagihan, pembelian token, pelaporan gangguan, hingga monitoring pemakaian listrik secara real-time.\\n\\nInovasi ini merupakan bagian dari transformasi digital PLN yang bertujuan untuk meningkatkan kualitas pelayanan dan kepuasan pelanggan. Dengan PLN DIGI, seluruh kebutuhan kelistrikan dapat dikelola dalam satu platform yang mudah dan efisien.', NULL, 'info', 1, '2026-09-12 21:26:54', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(2, 'Promo Cashback 10% untuk Pembelian Token Listrik', 'promo-cashback-10-persen-token', 'Dapatkan cashback 10% untuk setiap pembelian token listrik melalui PLN DIGI! Promo berlaku mulai 1 hingga 30 September 2026.\\n\\nSyarat dan ketentuan:\\n- Minimal pembelian token Rp 50.000\\n- Maksimal cashback Rp 25.000 per transaksi\\n- Berlaku untuk semua metode pembayaran\\n- Cashback akan dikreditkan dalam 3x24 jam\\n\\nJangan lewatkan kesempatan ini! Beli token listrik sekarang dan nikmati cashback-nya.', NULL, 'promo', 1, '2026-09-10 21:26:54', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(3, 'Pemeliharaan Jaringan Listrik Area Jakarta Selatan', 'pemeliharaan-jaringan-jakarta-selatan', 'Informasi penting untuk pelanggan PLN di wilayah Jakarta Selatan. PLN akan melaksanakan pemeliharaan jaringan listrik pada:\\n\\nTanggal: 20 September 2026\\nWaktu: 08:00 - 14:00 WIB\\nArea: Kebayoran Baru, Cilandak, Pasar Minggu\\n\\nSelama pemeliharaan berlangsung, pasokan listrik di area tersebut akan terganggu sementara. PLN mohon maaf atas ketidaknyamanan yang ditimbulkan. Pemeliharaan ini dilakukan untuk meningkatkan keandalan sistem kelistrikan di wilayah tersebut.', NULL, 'gangguan', 1, '2026-09-11 21:26:54', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(4, '5 Tips Hemat Listrik di Rumah yang Mudah Diterapkan', '5-tips-hemat-listrik-rumah', 'Menghemat listrik bukan hanya baik untuk kantong Anda, tapi juga untuk lingkungan. Berikut 5 tips sederhana yang bisa langsung Anda terapkan:\\n\\n1. Gunakan Lampu LED\\nGanti lampu pijar dengan LED yang lebih hemat energi hingga 80%.\\n\\n2. Cabut Charger yang Tidak Digunakan\\nCharger yang tetap tersambung ke listrik tetap mengonsumsi daya meskipun tidak mengisi perangkat.\\n\\n3. Atur Suhu AC pada 24-26°C\\nSuhu ini adalah suhu optimal yang nyaman dan hemat energi.\\n\\n4. Manfaatkan Cahaya Alami\\nBuka tirai dan gunakan cahaya matahari di siang hari.\\n\\n5. Gunakan Timer pada Peralatan Elektronik\\nAtur timer untuk mematikan peralatan secara otomatis saat tidak diperlukan.', NULL, 'tips', 1, '2026-09-08 21:26:54', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(5, 'PLN Raih Penghargaan Best Digital Innovation 2026', 'pln-raih-penghargaan-digital-innovation', 'PT PLN (Persero) berhasil meraih penghargaan Best Digital Innovation 2026 dalam ajang Indonesia Digital Awards. Penghargaan ini diberikan atas keberhasilan PLN dalam mentransformasi layanan kelistrikan melalui platform digital.\\n\\nDirektur Utama PLN menyampaikan bahwa penghargaan ini menjadi motivasi untuk terus berinovasi dan memberikan layanan terbaik kepada seluruh pelanggan di Indonesia. PLN berkomitmen untuk terus mengembangkan teknologi digital demi kemudahan dan kenyamanan pelanggan.', NULL, 'info', 1, '2026-09-06 21:26:54', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(6, 'Gratis Biaya Admin untuk Pelanggan Baru PLN DIGI', 'gratis-biaya-admin-pelanggan-baru', 'Kabar gembira untuk pelanggan baru PLN DIGI! Dapatkan gratis biaya administrasi untuk 3 transaksi pertama Anda.\\n\\nPromo ini berlaku untuk:\\n- Pembayaran tagihan listrik\\n- Pembelian token listrik\\n\\nDaftar sekarang di PLN DIGI dan nikmati kemudahan mengelola kelistrikan Anda!', NULL, 'promo', 1, '2026-09-03 21:26:54', '2026-09-13 21:26:54', '2026-09-13 21:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `outage_reports`
--

CREATE TABLE `outage_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kategori` enum('padam_total','tegangan_rendah','korsleting','meteran_rusak','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('dilaporkan','diproses','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dilaporkan',
  `catatan_petugas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outage_reports`
--

INSERT INTO `outage_reports` (`id`, `user_id`, `customer_id`, `kategori`, `deskripsi`, `lokasi`, `foto`, `status`, `catatan_petugas`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'padam_total', 'Listrik padam total sejak jam 20:00 WIB malam ini. Seluruh rumah di RT 03 mengalami hal yang sama. Sudah cek MCB dan tidak ada yang trip.', 'Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat', NULL, 'selesai', 'Gangguan telah diperbaiki. Penyebab: kabel putus di gardu distribusi terdekat.', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(2, 2, 1, 'tegangan_rendah', 'Tegangan listrik tidak stabil sejak 2 hari terakhir. Lampu redup dan AC tidak bisa menyala normal.', 'Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat', NULL, 'diproses', 'Petugas sedang melakukan pengecekan di gardu induk area.', '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(3, 2, NULL, 'meteran_rusak', 'Display meteran digital menampilkan error dan angka tidak berubah meski listrik terpakai.', 'Jl. Sudirman No. 25, Bandung', NULL, 'dilaporkan', NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(4, 2, NULL, 'padam_total', 'Listrik di rumah padam sejak tadi malam secara tiba-tiba.', 'Jl. Merdeka No 123', NULL, 'dilaporkan', NULL, '2026-09-28 01:58:39', '2026-09-28 01:58:39'),
(5, 51, 50, 'padam_total', 'Listrik padam tiba-tiba di sekitar blok perumahan sejak sore hari, trafo terdengar mendengung keras.', 'Jl. Diponegoro No. 94, Makassar, Sulawesi Selatan', NULL, 'diproses', 'Petugas sedang menuju lokasi gangguan.', '2026-09-26 02:41:39', '2026-09-28 02:41:41'),
(6, 52, 51, 'padam_total', 'Listrik padam tiba-tiba di sekitar blok perumahan sejak sore hari, trafo terdengar mendengung keras.', 'Jl. Jend. Sudirman Kav. 33, Denpasar, Bali', NULL, 'selesai', 'Petugas PLN Rayon telah melakukan perbaikan sekring trafo distribusi.', '2026-09-25 02:41:39', '2026-09-28 02:41:41'),
(7, 53, 52, 'padam_total', 'Listrik padam tiba-tiba di sekitar blok perumahan sejak sore hari, trafo terdengar mendengung keras.', 'Jl. Melati No. 67, RT 02/RW 05, Palembang, Sumatera Selatan', NULL, 'selesai', 'Petugas PLN Rayon telah melakukan perbaikan sekring trafo distribusi.', '2026-09-23 02:41:39', '2026-09-28 02:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `kode`, `nama`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'qris', 'QRIS', 'qris', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(2, 'gopay', 'GoPay', 'gopay', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(3, 'ovo', 'OVO', 'ovo', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(4, 'dana', 'DANA', 'dana', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(5, 'bca', 'Transfer BCA', 'bca', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(6, 'mandiri', 'Transfer Mandiri', 'mandiri', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(7, 'bni', 'Transfer BNI', 'bni', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(8, 'cash', 'Tunai', 'cash', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `reward_claims`
--

CREATE TABLE `reward_claims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reward_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poin` int(10) UNSIGNED NOT NULL,
  `voucher_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','used','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_claims`
--

INSERT INTO `reward_claims` (`id`, `user_id`, `reward_id`, `nama`, `poin`, `voucher_code`, `status`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'diskon_5', 'Diskon Tagihan 5%', 100, 'PLN-DISC5-USFQXF', 'active', '2026-12-28 02:15:05', '2026-09-28 02:15:05', '2026-09-28 02:15:05'),
(2, 42, '1', 'Diskon Tagihan Listrik Rp 50.000', 250, 'PLN-DISC50-E0C641', 'active', '2026-10-28 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(3, 42, '4', 'Gratis Biaya Layanan PLN Life 1 Bulan', 150, 'PLN-PLP-F85454', 'used', '2026-10-13 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(4, 43, '1', 'Diskon Tagihan Listrik Rp 50.000', 250, 'PLN-DISC50-663682', 'active', '2026-10-28 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(5, 43, '4', 'Gratis Biaya Layanan PLN Life 1 Bulan', 150, 'PLN-PLP-248E84', 'used', '2026-10-13 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(6, 44, '1', 'Diskon Tagihan Listrik Rp 50.000', 250, 'PLN-DISC50-15D4E8', 'active', '2026-10-28 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(7, 44, '4', 'Gratis Biaya Layanan PLN Life 1 Bulan', 150, 'PLN-PLP-C203D8', 'used', '2026-10-13 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(8, 45, '1', 'Diskon Tagihan Listrik Rp 50.000', 250, 'PLN-DISC50-941E1A', 'active', '2026-10-28 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(9, 45, '4', 'Gratis Biaya Layanan PLN Life 1 Bulan', 150, 'PLN-PLP-9431C8', 'used', '2026-10-13 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(10, 46, '1', 'Diskon Tagihan Listrik Rp 50.000', 250, 'PLN-DISC50-0353AB', 'active', '2026-10-28 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(11, 46, '4', 'Gratis Biaya Layanan PLN Life 1 Bulan', 150, 'PLN-PLP-51D92B', 'used', '2026-10-13 02:41:39', '2026-09-28 02:41:41', '2026-09-28 02:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ep8TM7SDr9egrCpywNjHWRM0liRBLFpPhQtuIjbR', NULL, '127.0.0.1', 'curl/8.21.0', 'eyJfdG9rZW4iOiJtcFhRNHl1MTNwRnNMTFA1RDdpNFRiYnVZbnFiNnlrcmN1amFEZGRIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790763976),
('PDU1t7SmR5CCkkJLQW6PldGCD0aTWIT4JdWOJF0q', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ5MXlyeVZ5ZFV1NGtWbEFDV3F1Rmtka2JWVnN5SDBQanRuVXRDSHNBIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9', 1790764119),
('W1fH1YxUifdASDheuovweHG5kkj8eve0GwcsiL1c', NULL, '127.0.0.1', 'curl/8.21.0', 'eyJfdG9rZW4iOiJnY2I0cmZxc0JXaGtwaUdvOWl2T0U4dXh3OU4wbllNOENjMDJEN1NFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790762168);

-- --------------------------------------------------------

--
-- Table structure for table `tariffs`
--

CREATE TABLE `tariffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tariff_category_id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daya_va` int(11) NOT NULL,
  `harga_per_kwh` decimal(10,2) NOT NULL,
  `biaya_beban` decimal(12,2) NOT NULL DEFAULT '0.00',
  `biaya_pasang` decimal(12,2) NOT NULL DEFAULT '0.00',
  `biaya_admin` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_subsidi` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tariffs`
--

INSERT INTO `tariffs` (`id`, `tariff_category_id`, `kode`, `nama`, `daya_va`, `harga_per_kwh`, `biaya_beban`, `biaya_pasang`, `biaya_admin`, `is_subsidi`, `created_at`, `updated_at`) VALUES
(1, 1, 'R1-450', 'Rumah Tangga 450VA', 450, '415.00', '11000.00', '385000.00', '50000.00', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(2, 1, 'R1-900', 'Rumah Tangga 900VA', 900, '605.00', '20000.00', '590000.00', '50000.00', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(3, 1, 'R1-1300', 'Rumah Tangga 1300VA', 1300, '1444.70', '40500.00', '960000.00', '75000.00', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(4, 1, 'R1-2200', 'Rumah Tangga 2200VA', 2200, '1444.70', '67500.00', '1500000.00', '75000.00', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(5, 1, 'R2-3500', 'Rumah Tangga 3500VA', 3500, '1699.53', '105000.00', '2500000.00', '100000.00', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(6, 1, 'R3-6600', 'Rumah Tangga 6600VA', 6600, '1699.53', '189000.00', '4500000.00', '100000.00', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(7, 2, 'B1-6600', 'Bisnis 6600VA', 6600, '1444.70', '189000.00', '4200000.00', '150000.00', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(8, 2, 'B2-10K', 'Bisnis 10.600VA', 10600, '1699.53', '304200.00', '6500000.00', '150000.00', 0, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(9, 4, 'S2-900', 'Sosial 900VA', 900, '605.00', '18000.00', '590000.00', '50000.00', 1, '2026-09-13 21:26:53', '2026-09-13 21:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `tariff_categories`
--

CREATE TABLE `tariff_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tariff_categories`
--

INSERT INTO `tariff_categories` (`id`, `kode`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'R', 'Rumah Tangga', 'Tarif untuk keperluan rumah tangga', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(2, 'B', 'Bisnis', 'Tarif untuk keperluan bisnis dan komersial', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(3, 'I', 'Industri', 'Tarif untuk keperluan industri besar', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(4, 'S', 'Sosial', 'Tarif untuk keperluan sosial (sekolah, rumah sakit, dll)', '2026-09-13 21:26:53', '2026-09-13 21:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('tagihan','token','pasang_baru') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `nominal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `no_meter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_listrik` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `customer_id`, `bill_id`, `payment_method_id`, `type`, `amount`, `nominal`, `status`, `no_meter`, `ref_number`, `token_listrik`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 1, 'tagihan', '284606.90', NULL, 'success', '531200012345', 'TRX-20260914-00001', NULL, NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(2, 2, 3, 4, 2, 'tagihan', '99860.00', NULL, 'success', '531200031122', 'TRX-20260914-00002', NULL, NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(3, 2, 1, NULL, 3, 'token', '50000.00', '50000', 'success', '531200012345', 'TRX-20260914-00003', '1234 5678 9012 3456 7890', NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(4, 2, NULL, NULL, 5, 'token', '100000.00', '100000', 'failed', '999900001111', 'TRX-20260914-00004', NULL, NULL, '2026-09-13 21:26:54', '2026-09-13 21:26:54'),
(5, 2, 1, 2, 1, 'tagihan', '286050.60', NULL, 'success', '531200012345', 'TRX-20260921-K3O9L', NULL, NULL, '2026-09-21 10:10:00', '2026-09-21 10:10:07'),
(6, 2, 1, 7, 1, 'tagihan', '585103.50', NULL, 'pending', '531200012345', 'TRX-20260921-06ING', NULL, NULL, '2026-09-21 10:20:34', '2026-09-21 10:20:34'),
(7, 2, 1, NULL, 1, 'tagihan', '150000.00', NULL, 'pending', '531200012345', 'QRIS-BWWIEZU6MM', NULL, 'Pembayaran via QRIS (Batas waktu 15 menit)', '2026-09-21 10:38:36', '2026-09-21 10:38:36'),
(8, 2, 1, NULL, 1, 'tagihan', '150000.00', NULL, 'success', '531200012345', 'QRIS-9H8G0CMAFP', NULL, 'Pembayaran via QRIS (Batas waktu 15 menit)', '2026-09-21 10:40:09', '2026-09-21 10:40:51'),
(9, 2, 1, 7, 1, 'tagihan', '585103.50', NULL, 'success', '531200012345', 'TRX-20260921-4Y7QG', NULL, NULL, '2026-09-21 10:40:21', '2026-09-21 10:40:31'),
(10, 2, 1, 6, 1, 'tagihan', '286050.60', NULL, 'pending', '531200012345', 'TRX-20260921-BXH5F', NULL, NULL, '2026-09-21 10:56:37', '2026-09-21 10:56:37'),
(11, 2, 1, NULL, 1, 'token', '500000.00', '500000', 'pending', '531200012345', 'TRX-20260921-V6C0L', '0009 0332 0423 3870 8168', NULL, '2026-09-21 10:59:11', '2026-09-21 10:59:11'),
(12, 2, 1, NULL, 1, 'token', '20000.00', '20000', 'pending', '531200012345', 'TRX-20260921-ZG6PN', '0004 5269 1039 0474 1502', NULL, '2026-09-21 10:59:17', '2026-09-21 10:59:17'),
(13, 2, 1, NULL, 1, 'token', '1000000.00', '1000000', 'pending', '531200012345', 'TRX-20260921-VMPDL', '0009 3925 5867 2090 4317', NULL, '2026-09-21 10:59:28', '2026-09-21 10:59:28'),
(14, 2, 1, NULL, 1, 'token', '50000.00', '50000', 'pending', '531200012345', 'TRX-20260921-DSQVS', '0002 8868 3299 9846 0466', NULL, '2026-09-21 11:11:07', '2026-09-21 11:11:07'),
(15, 2, 1, NULL, 1, 'token', '20000.00', '20000', 'success', '531200012345', 'TRX-20260921-JPTED', '0004 1661 9037 3098 1626', NULL, '2026-09-21 11:11:17', '2026-09-21 11:11:24'),
(16, 2, 1, NULL, 1, 'token', '50000.00', '50000', 'pending', '531200012345', 'TRX-20260921-4GBYM', '0001 9825 4573 7659 5119', NULL, '2026-09-21 11:12:11', '2026-09-21 11:12:11'),
(17, 2, 1, NULL, 2, 'token', '50000.00', '50000', 'pending', '531200012345', 'TRX-20260921-0SYUI', '0009 2199 5211 0599 4934', NULL, '2026-09-21 11:12:23', '2026-09-21 11:12:23'),
(18, 2, 1, 6, 5, 'tagihan', '286050.60', NULL, 'pending', '531200012345', 'TRX-20260921-GR3E2', NULL, NULL, '2026-09-21 11:12:39', '2026-09-21 11:12:39'),
(19, 2, 1, 6, 1, 'tagihan', '286050.60', NULL, 'success', '531200012345', 'TRX-20260922-2USHX', NULL, NULL, '2026-09-22 07:42:31', '2026-09-22 07:42:53'),
(20, 2, 1, NULL, 1, 'token', '200000.00', '200000', 'success', '531200012345', 'TRX-20260922-HOD9U', '0007 3454 2141 2211 3263', NULL, '2026-09-22 08:26:05', '2026-09-22 08:26:32'),
(21, 2, 1, NULL, 1, 'tagihan', '150000.00', NULL, 'success', '531200012345', 'TRX-20260928-CGBBA', NULL, NULL, '2026-09-28 02:00:37', '2026-09-28 02:00:37'),
(22, 2, 1, NULL, 1, 'token', '50000.00', '50000', 'success', '531200012345', 'TRX-20260928-8O6AV', '0004 5375 1453 1183 1612', NULL, '2026-09-28 02:00:37', '2026-09-28 02:00:37'),
(23, 4, 9, 8, 1, 'tagihan', '248488.40', NULL, 'success', '531100000001', 'TRX-202607-00011', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(24, 4, 9, 9, 2, 'tagihan', '260046.00', NULL, 'success', '531100000001', 'TRX-202608-00012', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(25, 5, 10, 11, 1, 'tagihan', '92565.00', NULL, 'success', '532100000002', 'TRX-202607-00021', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(26, 5, 10, 12, 2, 'tagihan', '92565.00', NULL, 'success', '532100000002', 'TRX-202608-00022', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(27, 6, 11, 14, 1, 'tagihan', '236930.80', NULL, 'success', '533100000003', 'TRX-202607-00031', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(28, 6, 11, 15, 2, 'tagihan', '234041.40', NULL, 'success', '533100000003', 'TRX-202608-00032', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(29, 7, 12, 17, 1, 'tagihan', '232596.70', NULL, 'success', '534100000004', 'TRX-202607-00041', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(30, 7, 12, 18, 2, 'tagihan', '307721.10', NULL, 'success', '534100000004', 'TRX-202608-00042', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(31, 8, 13, 20, 1, 'tagihan', '306276.40', NULL, 'success', '534200000005', 'TRX-202607-00051', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(32, 8, 13, 21, 2, 'tagihan', '329391.60', NULL, 'success', '534200000005', 'TRX-202608-00052', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(33, 9, 14, 23, 1, 'tagihan', '111925.00', NULL, 'success', '535100000006', 'TRX-202607-00061', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(34, 9, 14, 24, 2, 'tagihan', '131890.00', NULL, 'success', '535100000006', 'TRX-202608-00062', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(35, 10, 15, 26, 1, 'tagihan', '309165.80', NULL, 'success', '536100000007', 'TRX-202607-00071', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(36, 10, 15, 27, 2, 'tagihan', '280271.80', NULL, 'success', '536100000007', 'TRX-202608-00072', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(37, 11, 16, 29, 1, 'tagihan', '249933.10', NULL, 'success', '537100000008', 'TRX-202607-00081', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(38, 11, 16, 30, 2, 'tagihan', '229707.30', NULL, 'success', '537100000008', 'TRX-202608-00082', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(39, 12, 17, 32, 1, 'tagihan', '69720.00', NULL, 'success', '533200000009', 'TRX-202607-00091', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(40, 12, 17, 33, 2, 'tagihan', '71795.00', NULL, 'success', '533200000009', 'TRX-202608-00092', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(41, 13, 18, 35, 1, 'tagihan', '254267.20', NULL, 'success', '538100000010', 'TRX-202607-00101', NULL, NULL, '2026-07-20 02:40:34', '2026-09-28 02:40:35'),
(42, 13, 18, 36, 2, 'tagihan', '287495.30', NULL, 'success', '538100000010', 'TRX-202608-00102', NULL, NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(43, 22, 27, NULL, 1, 'token', '50000.00', '50000', 'success', '531500000019', 'TRX-20260823-00191', '4414 3116 4401 3352 9590', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(44, 22, 27, NULL, 2, 'token', '100000.00', '100000', 'success', '531500000019', 'TRX-20260904-00192', '1384 8948 1919 6904 6472', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(45, 22, 27, NULL, 3, 'token', '200000.00', '200000', 'success', '531500000019', 'TRX-20260916-00193', '2195 8214 6887 1820 7927', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:35'),
(46, 23, 28, NULL, 1, 'token', '50000.00', '50000', 'success', '534300000020', 'TRX-20260823-00201', '9262 2395 9724 5245 5640', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(47, 23, 28, NULL, 2, 'token', '100000.00', '100000', 'success', '534300000020', 'TRX-20260904-00202', '3097 2909 4319 1721 6666', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(48, 23, 28, NULL, 3, 'token', '200000.00', '200000', 'success', '534300000020', 'TRX-20260916-00203', '8025 4498 4755 2708 2460', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:35'),
(49, 24, 29, NULL, 1, 'token', '50000.00', '50000', 'success', '532400000021', 'TRX-20260823-00211', '2461 8008 4668 4149 1554', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(50, 24, 29, NULL, 2, 'token', '100000.00', '100000', 'success', '532400000021', 'TRX-20260904-00212', '9419 2452 9578 4806 8196', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(51, 24, 29, NULL, 3, 'token', '200000.00', '200000', 'success', '532400000021', 'TRX-20260916-00213', '6238 2274 9270 3235 2266', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:35'),
(52, 25, 30, NULL, 1, 'token', '50000.00', '50000', 'success', '532500000022', 'TRX-20260823-00221', '4400 3057 7860 7717 8674', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(53, 25, 30, NULL, 2, 'token', '100000.00', '100000', 'success', '532500000022', 'TRX-20260904-00222', '2098 1127 7218 8849 6764', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(54, 25, 30, NULL, 3, 'token', '200000.00', '200000', 'success', '532500000022', 'TRX-20260916-00223', '9776 1420 4314 2199 8498', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:35'),
(55, 26, 31, NULL, 1, 'token', '50000.00', '50000', 'success', '535300000023', 'TRX-20260823-00231', '4998 2221 6276 1139 3677', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(56, 26, 31, NULL, 2, 'token', '100000.00', '100000', 'success', '535300000023', 'TRX-20260904-00232', '2242 9100 7666 8971 4182', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(57, 26, 31, NULL, 3, 'token', '200000.00', '200000', 'success', '535300000023', 'TRX-20260916-00233', '1620 5566 9252 1892 6426', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:35'),
(58, 27, 32, NULL, 1, 'token', '50000.00', '50000', 'success', '535400000024', 'TRX-20260823-00241', '1155 1674 7408 9876 4957', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(59, 27, 32, NULL, 2, 'token', '100000.00', '100000', 'success', '535400000024', 'TRX-20260904-00242', '5286 2360 6356 7544 2840', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(60, 27, 32, NULL, 3, 'token', '200000.00', '200000', 'success', '535400000024', 'TRX-20260916-00243', '6153 8068 3437 6058 1908', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:35'),
(61, 28, 33, NULL, 1, 'token', '50000.00', '50000', 'success', '536200000025', 'TRX-20260823-00251', '2580 4098 2955 3528 7417', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:35'),
(62, 28, 33, NULL, 2, 'token', '100000.00', '100000', 'success', '536200000025', 'TRX-20260904-00252', '8641 4833 8373 3568 4213', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:35'),
(63, 28, 33, NULL, 3, 'token', '200000.00', '200000', 'success', '536200000025', 'TRX-20260916-00253', '2487 5776 3525 8739 6798', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:36'),
(64, 29, 34, NULL, 1, 'token', '50000.00', '50000', 'success', '536300000026', 'TRX-20260823-00261', '9170 7616 6570 1483 6049', NULL, '2026-08-23 02:40:34', '2026-09-28 02:40:36'),
(65, 29, 34, NULL, 2, 'token', '100000.00', '100000', 'success', '536300000026', 'TRX-20260904-00262', '7202 8100 2513 1496 3603', NULL, '2026-09-04 02:40:34', '2026-09-28 02:40:36'),
(66, 29, 34, NULL, 3, 'token', '200000.00', '200000', 'success', '536300000026', 'TRX-20260916-00263', '6562 2026 3581 7955 9053', NULL, '2026-09-16 02:40:34', '2026-09-28 02:40:36'),
(67, 42, 41, NULL, 1, 'token', '200000.00', '200000', 'success', '531200000039', 'TRX-20260730-00391', '4519 5681 4968 9507 1246', NULL, '2026-07-30 02:40:34', '2026-09-28 02:40:36'),
(68, 42, 41, NULL, 2, 'token', '200000.00', '200000', 'success', '531200000039', 'TRX-20260814-00392', '7636 5832 5967 3664 8091', NULL, '2026-08-14 02:40:34', '2026-09-28 02:40:36'),
(69, 42, 41, NULL, 3, 'token', '200000.00', '200000', 'success', '531200000039', 'TRX-20260829-00393', '7816 4217 6908 1858 9350', NULL, '2026-08-29 02:40:34', '2026-09-28 02:40:36'),
(70, 42, 41, NULL, 4, 'token', '200000.00', '200000', 'success', '531200000039', 'TRX-20260913-00394', '5799 1531 5311 3143 4270', NULL, '2026-09-13 02:40:34', '2026-09-28 02:40:36'),
(71, 43, 42, NULL, 1, 'token', '200000.00', '200000', 'success', '532100000040', 'TRX-20260730-00401', '9853 2493 4167 9091 5556', NULL, '2026-07-30 02:41:39', '2026-09-28 02:41:41'),
(72, 43, 42, NULL, 2, 'token', '200000.00', '200000', 'success', '532100000040', 'TRX-20260814-00402', '4867 8372 3696 2048 4358', NULL, '2026-08-14 02:41:39', '2026-09-28 02:41:41'),
(73, 43, 42, NULL, 3, 'token', '200000.00', '200000', 'success', '532100000040', 'TRX-20260829-00403', '6729 2191 1609 7397 7762', NULL, '2026-08-29 02:41:39', '2026-09-28 02:41:41'),
(74, 43, 42, NULL, 4, 'token', '200000.00', '200000', 'success', '532100000040', 'TRX-20260913-00404', '3534 1406 4551 5122 4729', NULL, '2026-09-13 02:41:39', '2026-09-28 02:41:41'),
(75, 44, 43, NULL, 1, 'token', '200000.00', '200000', 'success', '534200000041', 'TRX-20260730-00411', '1478 3376 1968 5369 8653', NULL, '2026-07-30 02:41:39', '2026-09-28 02:41:41'),
(76, 44, 43, NULL, 2, 'token', '200000.00', '200000', 'success', '534200000041', 'TRX-20260814-00412', '9008 6681 5507 1262 3615', NULL, '2026-08-14 02:41:39', '2026-09-28 02:41:41'),
(77, 44, 43, NULL, 3, 'token', '200000.00', '200000', 'success', '534200000041', 'TRX-20260829-00413', '5588 3783 1913 8031 5909', NULL, '2026-08-29 02:41:39', '2026-09-28 02:41:41'),
(78, 44, 43, NULL, 4, 'token', '200000.00', '200000', 'success', '534200000041', 'TRX-20260913-00414', '2483 3177 3447 8065 8840', NULL, '2026-09-13 02:41:39', '2026-09-28 02:41:41'),
(79, 45, 44, NULL, 1, 'token', '200000.00', '200000', 'success', '533100000042', 'TRX-20260730-00421', '5500 6314 7717 5597 6704', NULL, '2026-07-30 02:41:39', '2026-09-28 02:41:41'),
(80, 45, 44, NULL, 2, 'token', '200000.00', '200000', 'success', '533100000042', 'TRX-20260814-00422', '8770 3814 2135 7041 5272', NULL, '2026-08-14 02:41:39', '2026-09-28 02:41:41'),
(81, 45, 44, NULL, 3, 'token', '200000.00', '200000', 'success', '533100000042', 'TRX-20260829-00423', '7083 4434 5573 2849 2335', NULL, '2026-08-29 02:41:39', '2026-09-28 02:41:41'),
(82, 45, 44, NULL, 4, 'token', '200000.00', '200000', 'success', '533100000042', 'TRX-20260913-00424', '3528 5951 8278 2033 6278', NULL, '2026-09-13 02:41:39', '2026-09-28 02:41:41'),
(83, 46, 45, NULL, 1, 'token', '200000.00', '200000', 'success', '534100000043', 'TRX-20260730-00431', '7413 4417 2313 7709 9648', NULL, '2026-07-30 02:41:39', '2026-09-28 02:41:41'),
(84, 46, 45, NULL, 2, 'token', '200000.00', '200000', 'success', '534100000043', 'TRX-20260814-00432', '4269 9858 5056 5363 8932', NULL, '2026-08-14 02:41:39', '2026-09-28 02:41:41'),
(85, 46, 45, NULL, 3, 'token', '200000.00', '200000', 'success', '534100000043', 'TRX-20260829-00433', '1638 2741 5404 9963 2407', NULL, '2026-08-29 02:41:39', '2026-09-28 02:41:41'),
(86, 46, 45, NULL, 4, 'token', '200000.00', '200000', 'success', '534100000043', 'TRX-20260913-00434', '4109 6245 1542 8217 6163', NULL, '2026-09-13 02:41:39', '2026-09-28 02:41:41'),
(87, 47, 46, 68, 6, 'tagihan', '1677296.70', NULL, 'success', '531200000044', 'TRX-202608-00441', NULL, NULL, '2026-08-24 02:41:39', '2026-09-28 02:41:41'),
(88, 48, 47, 70, 6, 'tagihan', '2608778.55', NULL, 'success', '532100000045', 'TRX-202608-00451', NULL, NULL, '2026-08-24 02:41:39', '2026-09-28 02:41:41'),
(89, 49, 48, 72, 6, 'tagihan', '1813098.50', NULL, 'success', '533100000046', 'TRX-202608-00461', NULL, NULL, '2026-08-24 02:41:39', '2026-09-28 02:41:41'),
(90, 50, 49, 74, 6, 'tagihan', '606210.00', NULL, 'success', '535100000047', 'TRX-202608-00471', NULL, NULL, '2026-08-24 02:41:39', '2026-09-28 02:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin PLN', 'admin@plndigi.com', NULL, NULL, '$2y$12$/S1LBZzP98fi5qnP3Ko0VeWUqbKVi/WEjpyw8SA.tTBvKNVH26..W', 'admin', NULL, '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(2, 'Hafizh Wijdan', 'hafizh@mail.com', NULL, NULL, '$2y$12$.hf7eNXbxI6w6qU.tyT5luVDx6E.HCHAA0s16675T/aPzd52HI3Fq', 'user', 'balk0e9TaWK1KdSVD17WHg9z5VnoDKlhIoBdXPTMM0qAXguaNm2pF3OyDEB9', '2026-09-13 21:26:53', '2026-09-13 21:26:53'),
(3, 'User Tanpa Pelanggan', 'nocustomer@test.com', NULL, NULL, '$2y$12$qGZPfhaVJy5VGF/xWmyV4u5H/io8OTaWn6VtoOtTbXQn/N2OY860O', 'user', NULL, '2026-09-28 01:56:06', '2026-09-28 01:56:06'),
(4, 'Bambang Sudarsono', 'bambang.s@plndigi.com', NULL, '2026-09-12 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:39:14', '2026-09-28 02:41:40'),
(5, 'Siti Nurhaliza Putri', 'siti.nur@plndigi.com', NULL, '2026-09-03 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(6, 'Hendra Gunawan', 'hendra.g@plndigi.com', NULL, '2026-08-07 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(7, 'Rina Agustina', 'rina.agustina@plndigi.com', NULL, '2026-07-04 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(8, 'Dimas Arya Pratama', 'dimas.arya@plndigi.com', NULL, '2026-09-12 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(9, 'Maya Indah Safitri', 'maya.indah@plndigi.com', NULL, '2026-09-10 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(10, 'Joko Tri Wahyudi', 'joko.tri@plndigi.com', NULL, '2026-07-01 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(11, 'Sri Wahyuni', 'sri.wahyuni@plndigi.com', NULL, '2026-06-21 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(12, 'Arif Budiman', 'arif.budiman@plndigi.com', NULL, '2026-07-13 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(13, 'Nurmala Sari', 'nurmala.sari@plndigi.com', NULL, '2026-06-29 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(14, 'Agus Priyanto', 'agus.priyanto@plndigi.com', NULL, '2026-07-23 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(15, 'Tri Handayani', 'tri.handayani@plndigi.com', NULL, '2026-08-27 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(16, 'Wawan Kurniawan', 'wawan.kurnia@plndigi.com', NULL, '2026-06-24 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(18, 'Dedi Iskandar', 'dedi.iskandar@plndigi.com', NULL, '2026-08-16 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(19, 'Endang Sulastri', 'endang.sulastri@plndigi.com', NULL, '2026-07-06 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(20, 'Ferry Andika', 'ferry.andika@plndigi.com', NULL, '2026-07-19 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(21, 'CV Abadi Surya Makmur', 'surya.abadi@plndigi.com', NULL, '2026-08-07 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:40'),
(22, 'Bayu Wicaksono', 'bayu.wicaksono@plndigi.com', NULL, '2026-07-19 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(23, 'Dian Kusuma Wardani', 'dian.kusuma@plndigi.com', NULL, '2026-08-18 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(24, 'Fajar Nugroho', 'fajar.nugroho@plndigi.com', NULL, '2026-06-21 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(25, 'Gita Gutawa Putri', 'gita.putri@plndigi.com', NULL, '2026-08-17 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(26, 'Ilham Maulana', 'ilham.maulana@plndigi.com', NULL, '2026-08-27 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(27, 'Lestari Handoko', 'lestari.handoko@plndigi.com', NULL, '2026-08-10 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(28, 'Reza Fahlevi', 'reza.fahlevi@plndigi.com', NULL, '2026-07-07 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:35', '2026-09-28 02:41:41'),
(29, 'Sinta Maharani', 'sinta.maharani@plndigi.com', NULL, '2026-08-05 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(30, 'Kevin Sanjaya Sukamuljo', 'kevin.sanjaya@plndigi.com', NULL, '2026-07-27 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(31, 'Jessica Mila Agnesia', 'jessica.mila@plndigi.com', NULL, '2026-08-06 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(32, 'Aditya Bagus Panuntun', 'aditya.bagus@plndigi.com', NULL, '2026-07-11 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(33, 'Nadia Syahrini', 'nadia.syahrini@plndigi.com', NULL, '2026-08-02 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(34, 'Randi Ramadhan', 'randi.ramadhan@plndigi.com', NULL, '2026-08-24 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(35, 'Tiara Andini Permata', 'tiara.andini@plndigi.com', NULL, '2026-09-12 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(36, 'Eko Prasetyo', 'eko.prasetyo@plndigi.com', NULL, '2026-07-07 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(37, 'Yuni Shara Kusuma', 'yuni.shara@plndigi.com', NULL, '2026-07-12 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(38, 'Gunawan Wibisono', 'gunawan.w@plndigi.com', NULL, '2026-08-04 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(39, 'Dewi Persik Cahyani', 'dewi.persik@plndigi.com', NULL, '2026-07-20 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(40, 'Teguh Firmansyah', 'teguh.f@plndigi.com', NULL, '2026-08-15 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(41, 'Mega Utami Putri', 'mega.utami@plndigi.com', NULL, '2026-08-22 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(42, 'Rizky Billar Pratama', 'rizky.billar@plndigi.com', NULL, '2026-08-31 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:40:36', '2026-09-28 02:41:41'),
(43, 'Anisa Rahmawati', 'anisa.rahma@plndigi.com', NULL, '2026-07-26 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(44, 'Bagus Dwi Saputra', 'bagus.dwi@plndigi.com', NULL, '2026-07-13 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(45, 'Citra Kirana Sari', 'citra.kirana@plndigi.com', NULL, '2026-06-24 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(46, 'Danang Sutrisno', 'danang.s@plndigi.com', NULL, '2026-07-12 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(47, 'Farhan Kopi Kenangan', 'kopi.kenangan@plndigi.com', NULL, '2026-07-24 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(48, 'H. Syukur Resto Minang', 'resto.minang@plndigi.com', NULL, '2026-08-18 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(49, 'Erwin Jaya Percetakan', 'jaya.grafika@plndigi.com', NULL, '2026-07-21 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(50, 'dr. Maya Klinik Pratama', 'klinik.sehat@plndigi.com', NULL, '2026-08-29 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(51, 'Lukman Hakim', 'lukman.hakim@plndigi.com', NULL, '2026-08-18 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(52, 'Widya Ningsih', 'widya.ningsih@plndigi.com', NULL, '2026-08-01 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41'),
(53, 'Hasan Basri', 'hasan.basri@plndigi.com', NULL, '2026-08-05 02:41:39', '$2y$12$mELIEYtcCrf9OQvGWaipDu8TIthAg37IOVovkOu2mI0ZXThoA5gEO', 'user', NULL, '2026-09-28 02:41:41', '2026-09-28 02:41:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_meter_reading_id_foreign` (`meter_reading_id`),
  ADD KEY `bills_customer_id_status_index` (`customer_id`,`status`),
  ADD KEY `bills_status_tanggal_jatuh_tempo_index` (`status`,`tanggal_jatuh_tempo`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_id_pelanggan_unique` (`id_pelanggan`),
  ADD KEY `customers_user_id_foreign` (`user_id`),
  ADD KEY `customers_tariff_id_foreign` (`tariff_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

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
-- Indexes for table `meter_readings`
--
ALTER TABLE `meter_readings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meter_readings_customer_id_bulan_tahun_unique` (`customer_id`,`bulan`,`tahun`),
  ADD KEY `meter_readings_customer_id_tahun_bulan_index` (`customer_id`,`tahun`,`bulan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Indexes for table `outage_reports`
--
ALTER TABLE `outage_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `outage_reports_user_id_foreign` (`user_id`),
  ADD KEY `outage_reports_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_kode_unique` (`kode`);

--
-- Indexes for table `reward_claims`
--
ALTER TABLE `reward_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reward_claims_voucher_code_unique` (`voucher_code`),
  ADD KEY `reward_claims_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tariffs_kode_unique` (`kode`),
  ADD KEY `tariffs_tariff_category_id_foreign` (`tariff_category_id`);

--
-- Indexes for table `tariff_categories`
--
ALTER TABLE `tariff_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tariff_categories_kode_unique` (`kode`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_ref_number_unique` (`ref_number`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`),
  ADD KEY `transactions_bill_id_foreign` (`bill_id`),
  ADD KEY `transactions_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `transactions_user_id_status_index` (`user_id`,`status`),
  ADD KEY `transactions_type_status_index` (`type`,`status`);

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
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meter_readings`
--
ALTER TABLE `meter_readings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `outage_reports`
--
ALTER TABLE `outage_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reward_claims`
--
ALTER TABLE `reward_claims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tariff_categories`
--
ALTER TABLE `tariff_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bills_meter_reading_id_foreign` FOREIGN KEY (`meter_reading_id`) REFERENCES `meter_readings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_tariff_id_foreign` FOREIGN KEY (`tariff_id`) REFERENCES `tariffs` (`id`),
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `meter_readings`
--
ALTER TABLE `meter_readings`
  ADD CONSTRAINT `meter_readings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `outage_reports`
--
ALTER TABLE `outage_reports`
  ADD CONSTRAINT `outage_reports_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `outage_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reward_claims`
--
ALTER TABLE `reward_claims`
  ADD CONSTRAINT `reward_claims_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD CONSTRAINT `tariffs_tariff_category_id_foreign` FOREIGN KEY (`tariff_category_id`) REFERENCES `tariff_categories` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
