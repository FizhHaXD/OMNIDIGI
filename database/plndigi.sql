-- OMNIDIGI (PLN DIGI) Database Dump
-- Compatible with MySQL 5.7+ / MySQL 8.0+ / MariaDB 10.3+

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin PLN', 'admin@plndigi.com', NOW(), '$2y$12$e6mZ85d/2gqYyMeqV9J3v.l3Kk1XUqS0L1HjS1q8pYw5u0mO1qL6W', 'admin', NULL, NOW(), NOW()),
(2, 'Hafizh Wijdan', 'hafizh@mail.com', NOW(), '$2y$12$e6mZ85d/2gqYyMeqV9J3v.l3Kk1XUqS0L1HjS1q8pYw5u0mO1qL6W', 'user', NULL, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `sessions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `tariff_categories`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `tariff_categories`;
CREATE TABLE `tariff_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tariff_categories_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `tariff_categories`
INSERT INTO `tariff_categories` (`id`, `kode`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'R', 'Rumah Tangga', 'Tarif untuk keperluan rumah tangga', NOW(), NOW()),
(2, 'B', 'Bisnis', 'Tarif untuk keperluan bisnis dan komersial', NOW(), NOW()),
(3, 'I', 'Industri', 'Tarif untuk keperluan industri besar', NOW(), NOW()),
(4, 'S', 'Sosial', 'Tarif untuk keperluan sosial (sekolah, rumah sakit, dll)', NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `tariffs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `tariffs`;
CREATE TABLE `tariffs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tariff_category_id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `daya_va` int(11) NOT NULL,
  `harga_per_kwh` decimal(10,2) NOT NULL,
  `biaya_beban` decimal(10,2) NOT NULL DEFAULT 0.00,
  `biaya_pasang` decimal(12,2) NOT NULL DEFAULT 0.00,
  `biaya_admin` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_subsidi` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tariffs_kode_unique` (`kode`),
  KEY `tariffs_tariff_category_id_foreign` (`tariff_category_id`),
  CONSTRAINT `tariffs_tariff_category_id_foreign` FOREIGN KEY (`tariff_category_id`) REFERENCES `tariff_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `tariffs`
INSERT INTO `tariffs` (`id`, `tariff_category_id`, `kode`, `nama`, `daya_va`, `harga_per_kwh`, `biaya_beban`, `biaya_pasang`, `biaya_admin`, `is_subsidi`, `created_at`, `updated_at`) VALUES
(1, 1, 'R1-450', 'Rumah Tangga 450VA', 450, 415.00, 11000.00, 385000.00, 50000.00, 1, NOW(), NOW()),
(2, 1, 'R1-900', 'Rumah Tangga 900VA', 900, 605.00, 20000.00, 590000.00, 50000.00, 1, NOW(), NOW()),
(3, 1, 'R1-1300', 'Rumah Tangga 1300VA', 1300, 1444.70, 40500.00, 960000.00, 75000.00, 0, NOW(), NOW()),
(4, 1, 'R1-2200', 'Rumah Tangga 2200VA', 2200, 1444.70, 67500.00, 1500000.00, 75000.00, 0, NOW(), NOW()),
(5, 1, 'R2-3500', 'Rumah Tangga 3500VA', 3500, 1699.53, 105000.00, 2500000.00, 100000.00, 0, NOW(), NOW()),
(6, 1, 'R3-6600', 'Rumah Tangga 6600VA', 6600, 1699.53, 189000.00, 4500000.00, 100000.00, 0, NOW(), NOW()),
(7, 2, 'B1-6600', 'Bisnis 6600VA', 6600, 1444.70, 189000.00, 4200000.00, 150000.00, 0, NOW(), NOW()),
(8, 2, 'B2-10K', 'Bisnis 10.600VA', 10600, 1699.53, 304200.00, 6500000.00, 150000.00, 0, NOW(), NOW()),
(9, 4, 'S2-900', 'Sosial 900VA', 900, 605.00, 18000.00, 590000.00, 50000.00, 1, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `payment_methods`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `payment_methods`
INSERT INTO `payment_methods` (`id`, `kode`, `nama`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'qris', 'QRIS', 'qris', 1, NOW(), NOW()),
(2, 'gopay', 'GoPay', 'gopay', 1, NOW(), NOW()),
(3, 'ovo', 'OVO', 'ovo', 1, NOW(), NOW()),
(4, 'dana', 'DANA', 'dana', 1, NOW(), NOW()),
(5, 'bca', 'Transfer BCA', 'bca', 1, NOW(), NOW()),
(6, 'mandiri', 'Transfer Mandiri', 'mandiri', 1, NOW(), NOW()),
(7, 'bni', 'Transfer BNI', 'bni', 1, NOW(), NOW()),
(8, 'cash', 'Tunai', 'cash', 0, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `customers`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tariff_id` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_id_pelanggan_unique` (`id_pelanggan`),
  KEY `customers_user_id_foreign` (`user_id`),
  KEY `customers_tariff_id_foreign` (`tariff_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customers_tariff_id_foreign` FOREIGN KEY (`tariff_id`) REFERENCES `tariffs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `customers`
INSERT INTO `customers` (`id`, `user_id`, `tariff_id`, `id_pelanggan`, `nama`, `alamat`, `nomor_telepon`, `email`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '531200012345', 'Hafizh Wijdan', 'Jl. Merdeka No. 10, Jakarta Pusat', '081234567890', 'hafizh@mail.com', NOW(), NOW()),
(2, NULL, 4, '531200026789', 'Budi Santoso', 'Jl. Sudirman No. 25, Bandung', '082345678901', NULL, NOW(), NOW()),
(3, NULL, 2, '531200031122', 'Siti Rahayu', 'Jl. Gatot Subroto No. 5, Surabaya', '083456789012', NULL, NOW(), NOW()),
(4, NULL, 7, '531200043344', 'Ahmad Fauzi', 'Jl. Diponegoro No. 15, Semarang', '084567890123', 'ahmad@bisnis.com', NOW(), NOW()),
(5, NULL, 3, '531200055566', 'Dewi Lestari', 'Jl. Ahmad Yani No. 30, Medan', '085678901234', NULL, NOW(), NOW()),
(6, NULL, 1, '531200066677', 'Rizky Pratama', 'Jl. Pahlawan No. 8, Yogyakarta', '086789012345', NULL, NOW(), NOW()),
(7, NULL, 5, '531200077788', 'Anita Susanti', 'Jl. Pemuda No. 50, Makassar', '087890123456', NULL, NOW(), NOW()),
(8, NULL, 9, '531200088899', 'SDN Merdeka 01', 'Jl. Pendidikan No. 1, Bandung', '088901234567', 'sdn.merdeka@mail.com', NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `meter_readings`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `meter_readings`;
CREATE TABLE `meter_readings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `meteran_awal` decimal(10,2) NOT NULL,
  `meteran_akhir` decimal(10,2) NOT NULL,
  `status` enum('draft','submitted','verified','billed') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meter_readings_customer_id_foreign` (`customer_id`),
  CONSTRAINT `meter_readings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `meter_readings`
INSERT INTO `meter_readings` (`id`, `customer_id`, `bulan`, `tahun`, `meteran_awal`, `meteran_akhir`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 2026, 1250.00, 1447.00, 'billed', NOW(), NOW()),
(2, 1, 8, 2026, 1447.00, 1645.00, 'billed', NOW(), NOW()),
(3, 1, 9, 2026, 1645.00, 1843.00, 'billed', NOW(), NOW()),
(4, 2, 8, 2026, 3200.00, 3512.00, 'billed', NOW(), NOW()),
(5, 2, 9, 2026, 3512.00, 3820.00, 'verified', NOW(), NOW()),
(6, 3, 8, 2026, 890.00, 1022.00, 'billed', NOW(), NOW()),
(7, 3, 9, 2026, 1022.00, 1150.00, 'verified', NOW(), NOW()),
(8, 4, 8, 2026, 7800.00, 8350.00, 'billed', NOW(), NOW()),
(9, 4, 9, 2026, 8350.00, 8900.00, 'verified', NOW(), NOW()),
(10, 5, 9, 2026, 2100.00, 2320.00, 'verified', NOW(), NOW()),
(11, 1, 10, 2026, 1843.00, 2050.00, 'billed', NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `bills`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `meter_reading_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `total_kwh` decimal(10,2) NOT NULL,
  `total_biaya` decimal(12,2) NOT NULL,
  `denda` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('unpaid','paid','overdue') NOT NULL DEFAULT 'unpaid',
  `tanggal_jatuh_tempo` date NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bills_customer_id_foreign` (`customer_id`),
  KEY `bills_meter_reading_id_foreign` (`meter_reading_id`),
  CONSTRAINT `bills_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bills_meter_reading_id_foreign` FOREIGN KEY (`meter_reading_id`) REFERENCES `meter_readings` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `bills`
INSERT INTO `bills` (`id`, `customer_id`, `meter_reading_id`, `bulan`, `tahun`, `total_kwh`, `total_biaya`, `denda`, `status`, `tanggal_jatuh_tempo`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 7, 2026, 197.00, 284606.90, 0.00, 'paid', '2026-07-31', '2026-07-26', NOW(), NOW()),
(2, 1, 2, 8, 2026, 198.00, 286050.60, 0.00, 'paid', '2026-08-31', '2026-08-25', NOW(), NOW()),
(3, 2, 4, 8, 2026, 312.00, 518237.40, 0.00, 'unpaid', '2026-08-31', NULL, NOW(), NOW()),
(4, 3, 6, 8, 2026, 132.00, 99860.00, 0.00, 'paid', '2026-08-31', '2026-08-28', NOW(), NOW()),
(5, 4, 8, 8, 2026, 550.00, 983908.50, 50000.00, 'overdue', '2026-07-31', NULL, NOW(), NOW()),
(6, 1, 3, 9, 2026, 198.00, 286050.60, 0.00, 'unpaid', '2026-09-30', NULL, NOW(), NOW()),
(7, 1, 11, 10, 2026, 207.00, 299052.90, 0.00, 'unpaid', '2026-10-31', NULL, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `transactions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('tagihan','token','pasang_baru') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `nominal` varchar(50) DEFAULT NULL,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `no_meter` varchar(50) DEFAULT NULL,
  `ref_number` varchar(50) DEFAULT NULL,
  `token_listrik` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_ref_number_unique` (`ref_number`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_customer_id_foreign` (`customer_id`),
  KEY `transactions_bill_id_foreign` (`bill_id`),
  KEY `transactions_payment_method_id_foreign` (`payment_method_id`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `transactions`
INSERT INTO `transactions` (`id`, `user_id`, `customer_id`, `bill_id`, `payment_method_id`, `type`, `amount`, `nominal`, `status`, `no_meter`, `ref_number`, `token_listrik`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 1, 'tagihan', 284606.90, NULL, 'success', '531200012345', 'TRX-20260918-00001', NULL, NOW(), NOW()),
(2, 2, 3, 4, 2, 'tagihan', 99860.00, NULL, 'success', '531200031122', 'TRX-20260918-00002', NULL, NOW(), NOW()),
(3, 2, 1, NULL, 3, 'token', 50000.00, '50000', 'success', '531200012345', 'TRX-20260918-00003', '1234 5678 9012 3456 7890', NOW(), NOW()),
(4, 2, NULL, NULL, 5, 'token', 100000.00, '100000', 'failed', '999900001111', 'TRX-20260918-00004', NULL, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `news`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `kategori` enum('info','promo','gangguan','tips') NOT NULL DEFAULT 'info',
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `news`
INSERT INTO `news` (`id`, `judul`, `slug`, `konten`, `thumbnail`, `kategori`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'PLN Hadirkan Layanan Digital Terintegrasi untuk Pelanggan', 'pln-hadirkan-layanan-digital-terintegrasi', 'PT PLN (Persero) terus berinovasi dalam menghadirkan layanan digital yang terintegrasi untuk kemudahan pelanggan. Melalui aplikasi PLN DIGI, pelanggan kini dapat mengakses berbagai layanan kelistrikan seperti pembayaran tagihan, pembelian token, pelaporan gangguan, hingga monitoring pemakaian listrik secara real-time.\n\nInovasi ini merupakan bagian dari transformasi digital PLN yang bertujuan untuk meningkatkan kualitas pelayanan dan kepuasan pelanggan.', NULL, 'info', 1, NOW() - INTERVAL 1 DAY, NOW(), NOW()),
(2, 'Promo Cashback 10% untuk Pembelian Token Listrik', 'promo-cashback-10-persen-token', 'Dapatkan cashback 10% untuk setiap pembelian token listrik melalui PLN DIGI! Promo berlaku mulai 1 hingga 30 September 2026.\n\nSyarat dan ketentuan:\n- Minimal pembelian token Rp 50.000\n- Maksimal cashback Rp 25.000 per transaksi\n- Berlaku untuk semua metode pembayaran\n- Cashback akan dikreditkan dalam 3x24 jam', NULL, 'promo', 1, NOW() - INTERVAL 3 DAY, NOW(), NOW()),
(3, 'Pemeliharaan Jaringan Listrik Area Jakarta Selatan', 'pemeliharaan-jaringan-jakarta-selatan', 'Informasi penting untuk pelanggan PLN di wilayah Jakarta Selatan. PLN akan melaksanakan pemeliharaan jaringan listrik pada:\n\nTanggal: 20 September 2026\nWaktu: 08:00 - 14:00 WIB\nArea: Kebayoran Baru, Cilandak, Pasar Minggu\n\nSelama pemeliharaan berlangsung, pasokan listrik di area tersebut akan terganggu sementara.', NULL, 'gangguan', 1, NOW() - INTERVAL 2 DAY, NOW(), NOW()),
(4, '5 Tips Hemat Listrik di Rumah yang Mudah Diterapkan', '5-tips-hemat-listrik-rumah', 'Menghemat listrik bukan hanya baik untuk pengeluaran rumah tangga, tetapi juga untuk efisiensi energi. Gunakan lampu LED hemat daya, atur suhu AC pada 24-26 derajat Celsius, matikan peralatan elektronik saat tidak digunakan, dan optimalkan pencahayaan alami di siang hari.', NULL, 'tips', 1, NOW() - INTERVAL 5 DAY, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `outage_reports`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `outage_reports`;
CREATE TABLE `outage_reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kategori` enum('padam_total','padam_sebagian','tegangan_rendah','meteran_rusak','lainnya') NOT NULL DEFAULT 'padam_total',
  `deskripsi` text NOT NULL,
  `lokasi` text NOT NULL,
  `status` enum('dilaporkan','diproses','selesai') NOT NULL DEFAULT 'dilaporkan',
  `catatan_petugas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `outage_reports_user_id_foreign` (`user_id`),
  KEY `outage_reports_customer_id_foreign` (`customer_id`),
  CONSTRAINT `outage_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `outage_reports_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `outage_reports`
INSERT INTO `outage_reports` (`id`, `user_id`, `customer_id`, `kategori`, `deskripsi`, `lokasi`, `status`, `catatan_petugas`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'padam_total', 'Listrik padam total sejak jam 20:00 WIB malam ini. Seluruh rumah di RT 03 mengalami hal yang sama. Sudah cek MCB dan tidak ada yang trip.', 'Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat', 'selesai', 'Gangguan telah diperbaiki. Penyebab: kabel putus di gardu distribusi terdekat.', NOW(), NOW()),
(2, 2, 1, 'tegangan_rendah', 'Tegangan listrik tidak stabil sejak 2 hari terakhir. Lampu redup dan AC tidak bisa menyala normal.', 'Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat', 'diproses', 'Petugas sedang melakukan pengecekan di gardu induk area.', NOW(), NOW()),
(3, 2, NULL, 'meteran_rusak', 'Display meteran digital menampilkan error dan angka tidak berubah meski listrik terpakai.', 'Jl. Sudirman No. 25, Bandung', 'dilaporkan', NULL, NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
