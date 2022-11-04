-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2022 at 12:12 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `larakas2`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE `akses` (
  `id` int(3) NOT NULL,
  `fitur` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akses_user`
--

CREATE TABLE `akses_user` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akses` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id_kas` varchar(100) NOT NULL,
  `id_pencatatan` varchar(100) NOT NULL,
  `pos` int(1) NOT NULL,
  `saldo` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id_kas`, `id_pencatatan`, `pos`, `saldo`) VALUES
('kas-064eb0a81d9796ffa1a903f79e47ad57', '3cb973c79c95cfcb3a1b929ac5e14028', 1, '50000.00'),
('kas-3415ec32c97c7b0eedd851fa65f0bf57', '6bc497be7a33e7d9a8234a441aeafd9b', 1, '50000.00'),
('kas-80e4cbf9de671f0fcc1bf43ab4f3fcf6', 'b627f9549e3f33456320854667198d3a', 0, '950000.00'),
('kas-818b4233277d758cf6e02cec34c3c2ce', 'd20c9f96974845dbb93c435eb2314d5d', 1, '200000.00'),
('kas-8457527abcc7de249a1d1f71b491359b', '22502f94797a95cbb0e8ec7f6da0004d', 1, '50000.00'),
('kas-d19541aacabdcf49c418505736f56957', '1f95b97b934574786a0b78fcbdefa9ad', 0, '100000.00'),
('kas-da1cec9a909ba0e79635c80bfdeca174', '527629b80ddc1f68ba553420dff535d6', 1, '200000.00'),
('kas-e2a035ed585fe909fd448e3d7cd99cfc', 'cfed175e53379f58acc75c52801a35e9', 1, '50000000.00');

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
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(25) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_telp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Baktiadi Baktiono Iswahyudi S.Gz', 'Psr. Achmad No. 582, Tidore Kepulauan 52936, Papua', '(+62) 29 2326 190', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(4, 'Sarah Nurul Hartati S.Pd', 'Jln. Ahmad Dahlan No. 867, Bitung 19759, Bengkulu', '0979 1753 6919', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(5, 'Digdaya Wibisono', 'Psr. Moch. Yamin No. 467, Kotamobagu 49836, Jabar', '022 4861 0255', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(6, 'Janet Namaga', 'Dk. BKR No. 351, Gunungsitoli 32721, Bengkulu', '0285 3822 188', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(8, 'Kamaria Palastri', 'Gg. Cikutra Timur No. 265, Batam 34968, Papua', '0591 4665 7531', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(9, 'Hilda Nasyidah', 'Ds. Bazuka Raya No. 297, Serang 34625, Sultra', '028 8323 7377', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(10, 'Fathonah Purwanti', 'Dk. Barasak No. 673, Malang 28559, Kaltim', '(+62) 662 8627 024', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(11, 'Tami Yulianti S.Gz', 'Ds. Supono No. 895, Pasuruan 88175, Jabar', '(+62) 720 2508 5069', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(13, 'Mila Wulandari', 'Gg. Dipatiukur No. 963, Tidore Kepulauan 19337, Sulsel', '(+62) 938 6073 387', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(14, 'Lukita Banawi Tampubolon S.E.I', 'Gg. Pattimura No. 114, Tanjung Pinang 22556, Kaltim', '0772 5901 6405', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(15, 'Warsita Santoso', 'Psr. Bakau No. 693, Bogor 65963, Jambi', '0507 2959 8248', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(16, 'Kamila Rachel Farida', 'Ki. Banceng Pondok No. 834, Magelang 98320, DKI', '022 1566 786', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(17, 'Fitria Astuti S.I.Kom', 'Dk. Wora Wari No. 269, Malang 73055, Sulut', '(+62) 704 3460 932', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(18, 'Caraka Kusumo', 'Ds. Warga No. 628, Pariaman 72663, Sulbar', '0772 4177 246', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(19, 'Endah Fitriani Novitasari M.Kom.', 'Ki. Sutan Syahrir No. 447, Pangkal Pinang 27237, Banten', '(+62) 866 734 549', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(20, 'Halima Pudjiastuti', 'Ki. Dr. Junjunan No. 589, Cirebon 36764, Sulteng', '0213 6808 1754', '2022-08-29 13:23:56', '2022-08-29 13:23:56', NULL),
(21, 'Marliana', 'Jl Pinus 2323423', '140047920207', '2022-08-29 20:59:41', '2022-08-29 20:59:41', NULL),
(22, 'Rudi', 'Jl Kegangsaan', '081324234', '2022-08-29 21:06:22', '2022-08-29 21:06:22', NULL),
(23, 'Titin Usada', 'Jl Papandayan', '08983', '2022-08-29 21:10:04', '2022-08-29 21:10:04', NULL),
(24, 'Tanah deui', 'Jl Tanah', '0834232', '2022-08-29 21:11:51', '2022-08-29 21:11:51', NULL),
(31, 'Digdaya Hutasoit', 'Jl Hutajulu', '282432 234239', '2022-09-01 12:04:21', '2022-09-01 12:04:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemasok`
--

CREATE TABLE `pemasok` (
  `id_pemasok` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(25) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemasok`
--

INSERT INTO `pemasok` (`id_pemasok`, `nama`, `alamat`, `no_telp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Tiara Uyainah S.Ak.', 'Jln. Taman No. 934, Serang 66543, Kalteng', '0347 5906 3636', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(3, 'Bahuwarna Darijan Tampubolon', 'Kpg. Flores No. 147, Bontang 69498, Jateng', '(+62) 809 491 273', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(4, 'Citra Shania Rahayu', 'Ds. W.R. Supratman No. 637, Sabang 84052, Jatim', '(+62) 408 6887 2395', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(5, 'Warsa Saptono', 'Ds. Suprapto No. 646, Bengkulu 43071, Kalsel', '0219 4165 3114', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(6, 'Humaira Uyainah S.Gz', 'Jr. Dahlia No. 603, Bengkulu 31397, Lampung', '(+62) 853 244 716', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(7, 'Halim Saptono S.Gz', 'Jr. Gremet No. 44, Palu 52010, Malut', '(+62) 991 4641 3186', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(8, 'Eva Melani M.TI.', 'Kpg. Bahagia No. 222, Denpasar 31484, Jambi', '(+62) 21 9666 635', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(9, 'Nova Lailasari', 'Jr. Umalas No. 770, Sungai Penuh 18759, Aceh', '(+62) 762 7151 068', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(10, 'Ida Pertiwi', 'Dk. Honggowongso No. 828, Sabang 16441, Babel', '(+62) 577 5404 5050', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(11, 'Diana Tania Uyainah S.Pd', 'Dk. Katamso No. 279, Magelang 76766, Jateng', '(+62) 370 5165 797', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(12, 'Elvin Salahudin', 'Psr. Muwardi No. 833, Medan 86104, Sumsel', '(+62) 465 9804 508', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(13, 'Raihan Budi Permadi', 'Jln. Cemara No. 497, Banda Aceh 18701, Kalbar', '0534 2251 8594', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(14, 'Daniswara Megantara', 'Jln. Cikutra Timur No. 123, Bima 22386, Kalsel', '(+62) 892 4909 4070', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(15, 'Almira Haryanti', 'Kpg. HOS. Cjokroaminoto (Pasirkaliki) No. 631, Pangkal Pinang 70450, Bali', '0847 6620 475', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(16, 'Ratih Wulandari', 'Kpg. R.M. Said No. 517, Administrasi Jakarta Barat 99424, NTB', '0660 9528 1513', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(17, 'Gasti Gilda Riyanti M.Farm', 'Gg. Hasanuddin No. 218, Pagar Alam 12229, NTB', '0622 9050 0404', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(18, 'Septi Prastuti', 'Jr. Casablanca No. 695, Prabumulih 68711, Riau', '0849 5657 337', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(19, 'Wakiman Wacana', 'Psr. Wahidin No. 798, Administrasi Jakarta Utara 69969, NTT', '0642 8555 174', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL),
(20, 'Eka Mayasari', 'Jln. R.E. Martadinata No. 988, Lubuklinggau 30669, Kepri', '0781 6126 970', '2022-09-01 11:49:50', '2022-09-01 11:49:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pencatatan`
--

CREATE TABLE `pencatatan` (
  `id` int(11) NOT NULL,
  `id_pencatatan` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pencatatan`
--

INSERT INTO `pencatatan` (`id`, `id_pencatatan`, `keterangan`, `id_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cfed175e53379f58acc75c52801a35e9', 'setoran awal', 1, '2022-08-28 17:47:00', '2022-08-28 17:49:32', NULL),
(2, '1f95b97b934574786a0b78fcbdefa9ad', 'Pengeluaran Hari ini', 1, '2022-08-28 21:41:00', '2022-08-28 21:41:32', NULL),
(3, 'b627f9549e3f33456320854667198d3a', 'Pembelian bahan', 1, '2022-08-28 22:06:00', '2022-08-28 22:36:41', '2022-08-28 22:52:36'),
(4, '41d708e191ff0671933765175d9129d9', '', 1, '2022-09-02 23:46:11', '2022-09-02 23:46:11', NULL),
(5, '77f7d9e9354738884c073603254f17ad', '', 1, '2022-09-02 23:46:11', '2022-09-02 23:46:11', NULL),
(6, 'd5d9e521947ee9f51f8d84f8deac350a', '', 1, '2022-09-02 23:46:11', '2022-09-02 23:46:11', NULL),
(7, '81ed466521fce7468fc715e0c09965ed', '', 1, '2022-09-02 23:46:11', '2022-09-02 23:46:11', NULL),
(8, '27e29b2c4955c81d3ee7bb4fe34678c0', '', 1, '2022-09-02 23:46:11', '2022-09-02 23:46:11', NULL),
(9, '9d0c6f55d2c919554746051ea2ed9eaf', 'test', 1, '2022-09-06 10:13:00', '2022-09-06 10:22:18', NULL),
(10, '96ca6a5643b21e2e38e0025d5e8cab24', 'test', 1, '2022-08-02 10:00:00', '2022-09-06 10:23:51', NULL),
(11, '403a878ce1f010db5496d14a03a719f1', 'test', 1, '2022-08-24 10:47:00', '2022-09-06 10:47:25', NULL),
(12, 'b9b36af11cc970211a14902adf0ec472', 'Pinjaman modal', 1, '2022-09-07 19:00:00', '2022-09-07 19:02:24', NULL),
(13, '39c922cf6f308d3ca7ff5f9506eb3dfe', 'test', 1, '2022-09-15 00:33:00', '2022-09-15 00:33:58', '2022-09-21 16:24:20'),
(14, '8f8515fa832c92fba5c10babc3b4ea70', 'test', 1, '2022-09-15 10:44:00', '2022-09-15 10:44:51', '2022-09-21 16:24:23'),
(15, '8747c30f4659ef84ff06a4b427084af7', 'test', 1, '2022-09-15 11:46:00', '2022-09-15 11:46:35', NULL),
(16, '22502f94797a95cbb0e8ec7f6da0004d', '[Pembayaran piutang]: test', 1, '2022-09-19 15:55:00', '2022-09-19 15:55:45', NULL),
(17, '527629b80ddc1f68ba553420dff535d6', '[Pembayaran piutang]: test', 1, '2022-09-20 12:23:00', '2022-09-20 12:23:48', '2022-09-20 18:21:17'),
(18, '6bc497be7a33e7d9a8234a441aeafd9b', '[Pembayaran piutang]: Bayar dulu', 1, '2022-09-21 16:21:00', '2022-09-21 16:21:58', NULL),
(19, '26ceb518fe3ef515aed8a0f2f5ea6411', '', 1, '2022-09-21 22:48:48', '2022-09-21 22:48:48', NULL),
(20, '70c0284449f9e56bb01cfb7a2d4160ef', '', 1, '2022-09-21 22:48:48', '2022-09-21 22:48:48', NULL),
(21, '51af7344c9b26209337a993862aa2a97', '', 1, '2022-09-21 22:48:48', '2022-09-21 22:48:48', NULL),
(22, '3cb973c79c95cfcb3a1b929ac5e14028', '[Pembayaran utang]: test', 1, '2022-09-22 12:19:00', '2022-09-22 12:26:08', '2022-09-22 12:33:18'),
(23, 'd20c9f96974845dbb93c435eb2314d5d', '[Pembayaran utang]: Bayar dulu', 1, '2022-10-01 12:01:00', '2022-10-01 12:01:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutang`
--

CREATE TABLE `piutang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_piutang` varchar(100) NOT NULL,
  `id_pencatatan` varchar(100) NOT NULL,
  `id_pelanggan` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `piutang`
--

INSERT INTO `piutang` (`id`, `id_piutang`, `id_pencatatan`, `id_pelanggan`) VALUES
(1, 'rcv-479b66b611bb511b1776d13340b596c7', '41d708e191ff0671933765175d9129d9', 19),
(2, 'rcv-69efa01e1c29d0895081c5e45dffb42b', '77f7d9e9354738884c073603254f17ad', 24),
(3, 'rcv-3aa515593d411da452d233b288c6de41', 'd5d9e521947ee9f51f8d84f8deac350a', 19),
(4, 'rcv-33695c9c14c0a1f797240066962bfe19', '81ed466521fce7468fc715e0c09965ed', 4),
(5, 'rcv-a282f7323538a7c88b26ddcc5b8ab573', '27e29b2c4955c81d3ee7bb4fe34678c0', 8),
(6, 'rcv-4c7a6d4346ffa0ce6cb740f715cb434b', '9d0c6f55d2c919554746051ea2ed9eaf', 2),
(7, 'rcv-482071adcf15978d8e7dd03f8dc25b2e', '96ca6a5643b21e2e38e0025d5e8cab24', 6),
(8, 'rcv-2602fec216de38e46ab91ab2e040b23e', '403a878ce1f010db5496d14a03a719f1', 21),
(9, 'rcv-60759fc80635253032e67549c3ac85ea', 'b9b36af11cc970211a14902adf0ec472', 8);

-- --------------------------------------------------------

--
-- Table structure for table `saldo_piutang`
--

CREATE TABLE `saldo_piutang` (
  `id_pencatatan` varchar(100) NOT NULL,
  `id_piutang` varchar(100) NOT NULL,
  `pos` int(1) NOT NULL,
  `saldo` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saldo_piutang`
--

INSERT INTO `saldo_piutang` (`id_pencatatan`, `id_piutang`, `pos`, `saldo`) VALUES
('22502f94797a95cbb0e8ec7f6da0004d', 'rcv-479b66b611bb511b1776d13340b596c7', 1, '50000.00'),
('27e29b2c4955c81d3ee7bb4fe34678c0', 'rcv-a282f7323538a7c88b26ddcc5b8ab573', 0, '500000.00'),
('39c922cf6f308d3ca7ff5f9506eb3dfe', 'rcv-4c7a6d4346ffa0ce6cb740f715cb434b', 1, '2000.00'),
('403a878ce1f010db5496d14a03a719f1', 'rcv-2602fec216de38e46ab91ab2e040b23e', 0, '250000.00'),
('41d708e191ff0671933765175d9129d9', 'rcv-479b66b611bb511b1776d13340b596c7', 0, '200000.00'),
('527629b80ddc1f68ba553420dff535d6', 'rcv-a282f7323538a7c88b26ddcc5b8ab573', 1, '200000.00'),
('6bc497be7a33e7d9a8234a441aeafd9b', 'rcv-a282f7323538a7c88b26ddcc5b8ab573', 1, '50000.00'),
('77f7d9e9354738884c073603254f17ad', 'rcv-69efa01e1c29d0895081c5e45dffb42b', 0, '50000.00'),
('81ed466521fce7468fc715e0c09965ed', 'rcv-33695c9c14c0a1f797240066962bfe19', 0, '500000.00'),
('8747c30f4659ef84ff06a4b427084af7', 'rcv-482071adcf15978d8e7dd03f8dc25b2e', 1, '50000.00'),
('8f8515fa832c92fba5c10babc3b4ea70', 'rcv-4c7a6d4346ffa0ce6cb740f715cb434b', 1, '5000.00'),
('96ca6a5643b21e2e38e0025d5e8cab24', 'rcv-482071adcf15978d8e7dd03f8dc25b2e', 0, '100000.00'),
('9d0c6f55d2c919554746051ea2ed9eaf', 'rcv-4c7a6d4346ffa0ce6cb740f715cb434b', 0, '20000.00'),
('b9b36af11cc970211a14902adf0ec472', 'rcv-60759fc80635253032e67549c3ac85ea', 0, '20000.00'),
('d5d9e521947ee9f51f8d84f8deac350a', 'rcv-3aa515593d411da452d233b288c6de41', 0, '70000.00');

-- --------------------------------------------------------

--
-- Table structure for table `saldo_utang`
--

CREATE TABLE `saldo_utang` (
  `id_pencatatan` varchar(100) NOT NULL,
  `id_utang` varchar(100) NOT NULL,
  `pos` int(1) NOT NULL,
  `saldo` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saldo_utang`
--

INSERT INTO `saldo_utang` (`id_pencatatan`, `id_utang`, `pos`, `saldo`) VALUES
('26ceb518fe3ef515aed8a0f2f5ea6411', 'rcv-18df776ec8f4c50f05d4c56fa76eb6f7', 0, '500000.00'),
('3cb973c79c95cfcb3a1b929ac5e14028', 'rcv-317474ae067b4b2eb02f5e21e159c6b6', 1, '50000.00'),
('51af7344c9b26209337a993862aa2a97', 'rcv-317474ae067b4b2eb02f5e21e159c6b6', 0, '500000.00'),
('70c0284449f9e56bb01cfb7a2d4160ef', 'rcv-ed52eb528e8e404f08dc639c5643b216', 0, '500000.00'),
('d20c9f96974845dbb93c435eb2314d5d', 'rcv-18df776ec8f4c50f05d4c56fa76eb6f7', 1, '200000.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_telp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `level`, `password`, `remember_token`, `created_at`, `updated_at`, `no_telp`) VALUES
(1, 'Natanael Daurangga', 'natanael_daurangga', 1, '$2y$10$IDSjuAZytzNhuOt1axLokevs5bgIG58VH0MPGVuKrmzMwfVHIGiN2', NULL, '2022-08-27 21:10:18', '2022-08-27 21:10:18', NULL),
(9, 'Steven Marulitua', 'steven_marulihitut', 3, '$2y$10$/6CJbFdqfzqNQyfXAk5P8OrHWFBlucz5GOCxqzsHMXp0BJ4vbTuhO', NULL, '2022-09-27 11:29:05', '2022-10-04 10:18:43', '081224044641');

-- --------------------------------------------------------

--
-- Table structure for table `users_level`
--

CREATE TABLE `users_level` (
  `id` int(11) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_level`
--

INSERT INTO `users_level` (`id`, `level`) VALUES
(1, 'admin'),
(2, 'pemilik'),
(3, 'karyawan');

-- --------------------------------------------------------

--
-- Table structure for table `utang`
--

CREATE TABLE `utang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utang` varchar(100) NOT NULL,
  `id_pencatatan` varchar(100) NOT NULL,
  `id_pemasok` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utang`
--

INSERT INTO `utang` (`id`, `id_utang`, `id_pencatatan`, `id_pemasok`) VALUES
(1, 'rcv-18df776ec8f4c50f05d4c56fa76eb6f7', '26ceb518fe3ef515aed8a0f2f5ea6411', 17),
(2, 'rcv-ed52eb528e8e404f08dc639c5643b216', '70c0284449f9e56bb01cfb7a2d4160ef', 19),
(3, 'rcv-317474ae067b4b2eb02f5e21e159c6b6', '51af7344c9b26209337a993862aa2a97', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akses_user`
--
ALTER TABLE `akses_user`
  ADD KEY `fk_akses_user` (`id_user`),
  ADD KEY `fk_akses_fitur` (`id_akses`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id_kas`),
  ADD KEY `fk_pencatatan_kas` (`id_pencatatan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pemasok`
--
ALTER TABLE `pemasok`
  ADD PRIMARY KEY (`id_pemasok`);

--
-- Indexes for table `pencatatan`
--
ALTER TABLE `pencatatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pencatatan` (`id_pencatatan`),
  ADD KEY `fk_user_pencatatan` (`id_user`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `piutang`
--
ALTER TABLE `piutang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_piutang` (`id_piutang`),
  ADD KEY `fk_pencatatan_piutang` (`id_pencatatan`),
  ADD KEY `fk_pelanggan_piutang` (`id_pelanggan`);

--
-- Indexes for table `saldo_piutang`
--
ALTER TABLE `saldo_piutang`
  ADD UNIQUE KEY `id_pencatatan` (`id_pencatatan`),
  ADD KEY `fk_piutang_saldo_piutang` (`id_piutang`);

--
-- Indexes for table `saldo_utang`
--
ALTER TABLE `saldo_utang`
  ADD UNIQUE KEY `id_pencatatan` (`id_pencatatan`),
  ADD KEY `fk_utang_saldo_utang` (`id_utang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `fk_level_users` (`level`);

--
-- Indexes for table `users_level`
--
ALTER TABLE `users_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utang`
--
ALTER TABLE `utang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_utang` (`id_utang`),
  ADD KEY `fk_pencatatan_utang` (`id_pencatatan`),
  ADD KEY `fk_pemasok_utang` (`id_pemasok`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses`
--
ALTER TABLE `akses`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pemasok`
--
ALTER TABLE `pemasok`
  MODIFY `id_pemasok` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pencatatan`
--
ALTER TABLE `pencatatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutang`
--
ALTER TABLE `piutang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_level`
--
ALTER TABLE `users_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utang`
--
ALTER TABLE `utang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses_user`
--
ALTER TABLE `akses_user`
  ADD CONSTRAINT `fk_akses_fitur` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id`),
  ADD CONSTRAINT `fk_akses_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `kas`
--
ALTER TABLE `kas`
  ADD CONSTRAINT `fk_pencatatan_kas` FOREIGN KEY (`id_pencatatan`) REFERENCES `pencatatan` (`id_pencatatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pencatatan`
--
ALTER TABLE `pencatatan`
  ADD CONSTRAINT `fk_user_pencatatan` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `piutang`
--
ALTER TABLE `piutang`
  ADD CONSTRAINT `fk_pelanggan_piutang` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `fk_pencatatan_piutang` FOREIGN KEY (`id_pencatatan`) REFERENCES `pencatatan` (`id_pencatatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saldo_piutang`
--
ALTER TABLE `saldo_piutang`
  ADD CONSTRAINT `fk_pencatatan_saldo_piutang` FOREIGN KEY (`id_pencatatan`) REFERENCES `pencatatan` (`id_pencatatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_piutang_saldo_piutang` FOREIGN KEY (`id_piutang`) REFERENCES `piutang` (`id_piutang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saldo_utang`
--
ALTER TABLE `saldo_utang`
  ADD CONSTRAINT `fk_pencatatan_saldo_utang` FOREIGN KEY (`id_pencatatan`) REFERENCES `pencatatan` (`id_pencatatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utang_saldo_utang` FOREIGN KEY (`id_utang`) REFERENCES `utang` (`id_utang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_level_users` FOREIGN KEY (`level`) REFERENCES `users_level` (`id`);

--
-- Constraints for table `utang`
--
ALTER TABLE `utang`
  ADD CONSTRAINT `fk_pemasok_utang` FOREIGN KEY (`id_pemasok`) REFERENCES `pemasok` (`id_pemasok`),
  ADD CONSTRAINT `fk_pencatatan_utang` FOREIGN KEY (`id_pencatatan`) REFERENCES `pencatatan` (`id_pencatatan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
