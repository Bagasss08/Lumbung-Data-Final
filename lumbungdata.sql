h-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2026 at 03:23 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lumbungdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` bigint UNSIGNED NOT NULL,
  `config_id` bigint UNSIGNED NOT NULL,
  `tgl_agenda` date NOT NULL,
  `koordinator_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agenda_config`
--

CREATE TABLE `agenda_config` (
  `id` bigint UNSIGNED NOT NULL,
  `desa_id` bigint UNSIGNED NOT NULL,
  `nama_pengaturan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_pengaturan` text COLLATE utf8mb4_unicode_ci,
  `tipe_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun` year NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apbdes`
--

CREATE TABLE `apbdes` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_id` bigint UNSIGNED NOT NULL,
  `kegiatan_id` bigint UNSIGNED NOT NULL,
  `sumber_dana_id` bigint UNSIGNED NOT NULL,
  `anggaran` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsip_surat`
--

CREATE TABLE `arsip_surat` (
  `id` bigint UNSIGNED NOT NULL,
  `surat_keluar_id` bigint UNSIGNED NOT NULL,
  `lokasi_arsip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `nama`, `deskripsi`, `gambar`, `publish_at`, `created_at`, `updated_at`) VALUES
(3, 'Artikel Testing', 'Ini adalah artikel test untuk memastikan fungsi view dan edit bekerja.', 'sIjSxaTwDGHPP1Cgf9TPauBrrnteVDaqsBYZXjoC.jpg', '2026-02-05 01:52:00', '2026-02-05 01:52:39', '2026-02-05 08:27:17'),
(4, 'CARA MENDAPATKAN 100 JUTA PERTAMA DI USIA 8 TAHUN', 'CARANYA YA MINTA KE ORANG TUA LAH!', 'wrepKZvKFgytgEnXPV9eVPwvBHoabWreiDFc2SaJ.jpg', NULL, '2026-02-05 01:56:08', '2026-02-05 01:56:08'),
(5, 'ARTIKEL EPSTEIN', 'ISINYA MENGERIKAN', 'QplNeRhMLZvZU18zXxrCxFPnOFhYEgY0Yzv78bUP.jpg', '2026-02-05 09:16:00', '2026-02-05 02:16:56', '2026-02-06 00:26:30'),
(6, 'JOJO PART 7 BENTAR LAGI COYY', 'BERSIAPLAH', 'kQgHaEvcHd1qT1c1Fjp3q8xYSPyRynnJN5zdPRVx.jpg', '2026-02-05 15:52:00', '2026-02-05 08:53:09', '2026-02-06 00:27:32'),
(7, 'Resbob masuk penjaruy', 'Resbob masuk penjaruy gara2 ngehina Surabaya', 'SNAScun55JwlNd1qPjvovo5PHpk8gTRgizNsrXDB.jpg', NULL, '2026-02-06 10:18:23', '2026-02-06 10:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `aset_desa`
--

CREATE TABLE `aset_desa` (
  `id` bigint UNSIGNED NOT NULL,
  `desa_id` bigint UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_aset` enum('tanah','bangunan','kendaraan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas` decimal(10,2) DEFAULT NULL,
  `nilai` decimal(15,2) DEFAULT NULL,
  `tahun_perolehan` year DEFAULT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','rusak','dihapus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bantuan`
--

CREATE TABLE `bantuan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_bantuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber_dana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `kriteria` text COLLATE utf8mb4_unicode_ci,
  `nominal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bidang_anggaran`
--

CREATE TABLE `bidang_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `desa`
--

CREATE TABLE `desa` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pos` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_wilayah` decimal(10,2) DEFAULT NULL,
  `jumlah_penduduk` int NOT NULL DEFAULT '0',
  `jumlah_kk` int NOT NULL DEFAULT '0',
  `klasifikasi_desa` enum('swadaya','swakarya','swasembada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor` text COLLATE utf8mb4_unicode_ci,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `desa`
--

INSERT INTO `desa` (`id`, `kode_desa`, `nama_desa`, `kecamatan`, `kabupaten`, `provinsi`, `kode_pos`, `luas_wilayah`, `jumlah_penduduk`, `jumlah_kk`, `klasifikasi_desa`, `alamat_kantor`, `telp`, `email`, `website`, `logo`, `created_at`, `updated_at`) VALUES
(1, '0001', 'Desa Lumbung', 'Kecamatan Lumbung', 'Kabupaten Lumbung', 'Jawa Barat', NULL, NULL, 0, 0, 'swadaya', NULL, NULL, NULL, NULL, NULL, '2026-02-05 20:02:42', '2026-02-05 20:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identitas_desa`
--

CREATE TABLE `identitas_desa` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kode_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kode_bps_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kode_kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_camat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_camat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kode_kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kode_provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_kantor` text COLLATE utf8mb4_unicode_ci,
  `kantor_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ponsel_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_penanggungjawab_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ppwa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `link_peta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gambar_kantor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `identitas_desa`
--

INSERT INTO `identitas_desa` (`id`, `user_id`, `nama_desa`, `kode_desa`, `kode_bps_desa`, `kode_pos`, `kecamatan`, `kode_kecamatan`, `nama_camat`, `nip_camat`, `kabupaten`, `kode_kabupaten`, `provinsi`, `kode_provinsi`, `alamat_kantor`, `kantor_desa`, `email_desa`, `telepon_desa`, `ponsel_desa`, `website_desa`, `kepala_desa`, `nip_kepala_desa`, `nama_penanggungjawab_desa`, `no_ppwa`, `latitude`, `longitude`, `link_peta`, `logo_desa`, `created_at`, `updated_at`, `gambar_kantor`) VALUES
(6, NULL, 'Serayu Larangan', '1000000000', '1000000000', '53352', 'Mrebet', '1000000000', 'Anonim', '643563', 'Purbalingga', '1000000000', 'Jawa Tengah', NULL, 'Serayu Larangan', NULL, 'serayularangan@gmail.com', '085812345678', '085812345678', 'https://serayu-larangan.com/', 'Fajar Prasetyo Utomo', '643563', NULL, NULL, NULL, NULL, NULL, 'anxfi4Mv4HEi3kvq1ciSNXDKnCss0zBvvUA8GBJP.jpg', '2026-02-06 02:17:33', '2026-02-08 21:14:26', 'NGHv5jL4oKcSXmRJdpb4EENFbBu2j2I4XIKPPJjr.png'),
(7, NULL, 'Desa Contoh', '0001', NULL, '12345', 'Kecamatan Contoh', NULL, NULL, NULL, 'Kabupaten Contoh', NULL, 'Jawa Barat', NULL, 'Jl. Raya Desa No. 1', NULL, 'desa@contoh.id', '021123456', NULL, 'https://desacontoh.id', 'Kepala Desa Contoh', '197001011990011001', NULL, NULL, -6.2000000, 106.8166667, 'https://maps.google.com', NULL, '2026-02-08 23:32:04', '2026-02-08 23:32:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `kondisi` enum('baik','rusak','perlu_perbaikan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_perolehan` decimal(15,2) DEFAULT NULL,
  `tanggal_perolehan` date DEFAULT NULL,
  `sumber_perolehan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `nama_barang`, `deskripsi`, `kategori`, `jumlah`, `kondisi`, `lokasi`, `harga_perolehan`, `tanggal_perolehan`, `sumber_perolehan`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 'Cobaa', 'Coba', 'peralatan', 1, 'baik', 'Kuta, Badung, Bali', 10000.00, '2026-02-09', 'Pembelian', 'Coba', '2026-02-09 00:46:31', '2026-02-09 00:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `aktif` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_desa`
--

CREATE TABLE `kas_desa` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_id` bigint UNSIGNED NOT NULL,
  `saldo_awal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_akhir` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_konten`
--

CREATE TABLE `kategori_konten` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `urutan` int NOT NULL DEFAULT '0',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_anggaran`
--

CREATE TABLE `kegiatan_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `bidang_id` bigint UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE `keluarga` (
  `id` bigint UNSIGNED NOT NULL,
  `no_kk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `wilayah_id` bigint UNSIGNED NOT NULL,
  `tgl_terdaftar` date NOT NULL,
  `klasifikasi_ekonomi` enum('miskin','rentan','mampu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_bantuan_aktif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keluarga`
--

INSERT INTO `keluarga` (`id`, `no_kk`, `alamat`, `wilayah_id`, `tgl_terdaftar`, `klasifikasi_ekonomi`, `jenis_bantuan_aktif`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '1234567890123456', 'Bojongsari', 10, '2026-02-06', 'mampu', NULL, '2026-02-06 01:47:19', '2026-02-07 00:43:07', NULL),
(10, '1234567890123457', 'Jakarta', 10, '2026-02-07', 'mampu', NULL, '2026-02-07 00:37:15', '2026-02-07 00:38:14', '2026-02-07 00:38:14'),
(11, '1234567890123458', 'Wisp', 11, '2026-02-07', 'mampu', NULL, '2026-02-07 00:37:45', '2026-02-07 00:38:19', '2026-02-07 00:38:19'),
(12, '123456789012341', 'Jakarta', 11, '2026-02-07', 'mampu', NULL, '2026-02-07 00:42:44', '2026-02-07 00:42:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keluarga_anggota`
--

CREATE TABLE `keluarga_anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `keluarga_id` bigint UNSIGNED NOT NULL,
  `hubungan_keluarga` enum('kepala_keluarga','istri','suami','anak','orang_tua','saudara','famili_lain') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'famili_lain'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keluarga_anggota`
--

INSERT INTO `keluarga_anggota` (`id`, `created_at`, `updated_at`, `penduduk_id`, `keluarga_id`, `hubungan_keluarga`) VALUES
(13, '2026-02-07 00:39:00', '2026-02-07 00:43:55', 13, 9, 'istri'),
(14, '2026-02-07 00:39:41', '2026-02-07 00:39:41', 11, 9, 'anak'),
(15, '2026-02-07 00:40:00', '2026-02-07 00:40:00', 12, 9, 'anak'),
(16, '2026-02-07 00:42:44', '2026-02-07 00:42:44', 9, 12, 'kepala_keluarga'),
(17, '2026-02-07 00:43:07', '2026-02-07 00:43:07', 10, 9, 'kepala_keluarga'),
(18, '2026-02-07 00:43:38', '2026-02-07 00:43:38', 14, 12, 'saudara');

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_surats`
--

CREATE TABLE `klasifikasi_surats` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_klasifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retensi_aktif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retensi_inaktif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klasifikasi_surats`
--

INSERT INTO `klasifikasi_surats` (`id`, `kode`, `nama_klasifikasi`, `kategori`, `retensi_aktif`, `retensi_inaktif`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '001', 'Surat Keterangan Domisili', 'kependudukan', '5', '10', 0, 'Surat keterangan tempat tinggal penduduk', '2026-02-08 23:40:37', '2026-02-09 01:13:48'),
(2, '002', 'Surat Keterangan Lahirr', 'Lainnya', '5', '10', 1, 'Surat keterangan kelahiran penduduk', '2026-02-08 23:40:37', '2026-02-09 00:56:47'),
(3, '003', 'Surat Keterangan Meninggal', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan kematian penduduk', '2026-02-08 23:40:37', '2026-02-08 23:40:37'),
(4, '004', 'Surat Keterangan Pindah', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan pindah penduduk', '2026-02-08 23:40:37', '2026-02-08 23:40:37'),
(5, '005', 'Surat Keterangan Usaha', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan usaha penduduk', '2026-02-08 23:40:37', '2026-02-08 23:40:37'),
(6, '006', 'Surat Keterangan Tidak Mampu', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan tidak mampu untuk bantuan', '2026-02-08 23:40:37', '2026-02-08 23:40:37'),
(7, '007', 'Surat Keterangan Belum Menikah', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan status belum menikah', '2026-02-08 23:40:37', '2026-02-08 23:40:37'),
(8, '008', 'Surat Keterangan Janda/Duda', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan status janda atau duda', '2026-02-08 23:40:37', '2026-02-08 23:40:37'),
(9, '009', 'Surat Keterangan Ahli Waris', 'kependudukan', '5 tahun', '10 tahun', 1, 'Surat keterangan ahli waris', '2026-02-08 23:40:37', '2026-02-08 23:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id` bigint UNSIGNED NOT NULL,
  `konten_id` bigint UNSIGNED NOT NULL,
  `penduduk_id` bigint UNSIGNED DEFAULT NULL,
  `nama_pengirim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `id` bigint UNSIGNED NOT NULL,
  `desa_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` text COLLATE utf8mb4_unicode_ci,
  `isi_konten` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_id` bigint UNSIGNED DEFAULT NULL,
  `jenis_konten` enum('berita','pengumuman','layanan','regulasi','galeri') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draf','review','publish','arsip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draf',
  `tanggal_publish` timestamp NULL DEFAULT NULL,
  `tanggal_kadaluarsa` timestamp NULL DEFAULT NULL,
  `penulis_id` bigint UNSIGNED NOT NULL,
  `editor_id` bigint UNSIGNED DEFAULT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahasa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'id',
  `jumlah_view` int NOT NULL DEFAULT '0',
  `komentar_aktif` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konten_log`
--

CREATE TABLE `konten_log` (
  `id` bigint UNSIGNED NOT NULL,
  `konten_id` bigint UNSIGNED NOT NULL,
  `aksi` enum('buat','edit','publish','arsip') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konten_media`
--

CREATE TABLE `konten_media` (
  `id` bigint UNSIGNED NOT NULL,
  `konten_id` bigint UNSIGNED NOT NULL,
  `media_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `desa_id` bigint UNSIGNED NOT NULL,
  `jenis_media` enum('gambar','video','dokumen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_file` bigint DEFAULT NULL,
  `tipe_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_03_034538_create_desa_table', 1),
(5, '2026_02_03_034612_create_wilayah_table', 1),
(6, '2026_02_03_034637_create_keluarga_table', 1),
(7, '2026_02_03_034702_create_penduduk_table', 1),
(8, '2026_02_03_034829_add_fk_kepala_keluarga_to_keluarga_table', 1),
(9, '2026_02_03_034852_create_role_table', 1),
(10, '2026_02_03_034944_create_user_table', 1),
(11, '2026_02_03_035012_create_perangkat_desa_table', 1),
(12, '2026_02_03_035642_create_media_table', 1),
(13, '2026_02_03_035722_create_kategori_konten_table', 1),
(14, '2026_02_03_035818_create_tag_table', 1),
(15, '2026_02_03_035846_create_konten_table', 1),
(16, '2026_02_03_035910_create_konten_media_table', 1),
(17, '2026_02_03_040002_create_komentar_table', 1),
(18, '2026_02_03_040023_create_konten_log_table', 1),
(19, '2026_02_03_040047_create_pengaturan_web_table', 1),
(20, '2026_02_03_040115_create_agenda_config_table', 1),
(21, '2026_02_03_040136_create_agenda_table', 1),
(22, '2026_02_03_040228_create_artikel_table', 1),
(23, '2026_02_03_040743_create_surat_table', 1),
(24, '2026_02_03_040814_create_jenis_surat_table', 1),
(25, '2026_02_03_040836_create_template_surat_table', 1),
(26, '2026_02_03_040901_create_surat_permohonan_table', 1),
(27, '2026_02_03_040931_create_surat_keluar_table', 1),
(28, '2026_02_03_040959_create_penomoran_surat_table', 1),
(29, '2026_02_03_041018_create_arsip_surat_table', 1),
(30, '2026_02_03_041046_create_pengaduan_surat_table', 1),
(31, '2026_02_03_041614_create_tahun_anggaran_table', 1),
(32, '2026_02_03_041637_create_sumber_dana_table', 1),
(33, '2026_02_03_041658_create_bidang_anggaran_table', 1),
(34, '2026_02_03_041718_create_kegiatan_anggaran_table', 1),
(35, '2026_02_03_041741_create_anggaran_table', 1),
(36, '2026_02_03_041806_create_apbdes_table', 1),
(37, '2026_02_03_041823_create_kas_desa_table', 1),
(38, '2026_02_03_041851_create_realisasi_anggaran_table', 1),
(39, '2026_02_03_041918_create_transaksi_kas_table', 1),
(40, '2026_02_03_041953_create_aset_desa_table', 1),
(41, '2026_02_03_042027_create_bantuan_table', 1),
(42, '2026_02_03_042044_create_penerima_bantuan_table', 1),
(43, '2026_02_03_052445_create_identitas_desa_table', 1),
(44, '2026_02_03_052555_add_email_verified_at_and_remember_token_to_users_table', 1),
(45, '2026_02_03_055537_add_defaults_to_identitas_desa_table', 1),
(46, '2026_02_04_065023_create_rumah_tangga_table', 1),
(47, '2026_02_04_080118_add_rumah_tangga_id_to_penduduk_table', 1),
(48, '2026_02_04_081002_fix_penduduk_structure', 1),
(49, '2026_02_04_081018_fix_keluarga_structure', 1),
(50, '2026_02_04_081049_fix_rumah_tangga_structure', 1),
(51, '2026_02_04_081107_create_keluarga_anggota_table', 1),
(52, '2026_02_04_081200_fix_keluarga_anggota_pivot', 1),
(53, '2026_02_04_081220_create_rumah_tangga_penduduk_table', 1),
(54, '2026_02_04_081230_fix_keluarga_structure_final', 1),
(55, '2026_02_04_110350_fix_rumah_tangga_structure_final', 1),
(56, '2026_02_05_082913_add_gambar_kantor_to_identitas_desa_table', 2),
(57, '2026_02_06_024334_add_laki_laki_perempuan_to_wilayah_table', 3),
(58, '2026_02_06_034137_fix_keluarga_wilayah_foreign_key', 4),
(59, '2026_02_09_022916_create_sekretariat_informasi_publik_table', 4),
(60, '2026_02_09_052709_create_sekretariat_informasi_publik_table', 5),
(61, '2026_02_09_061225_create_inventaris_table', 6);

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
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `id` bigint UNSIGNED NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `golongan_darah` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` enum('bekerja','tidak bekerja') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tidak bekerja',
  `status_kawin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_hidup` enum('hidup','meninggal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidup',
  `kewarganegaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WNI',
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `wilayah_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penduduk`
--

INSERT INTO `penduduk` (`id`, `nik`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `golongan_darah`, `agama`, `pendidikan`, `pekerjaan`, `status_kawin`, `status_hidup`, `kewarganegaraan`, `no_telp`, `email`, `alamat`, `wilayah_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '3201010101010002', 'Bigmo', 'P', 'Banyumas', '2026-02-06', 'B', 'Islam', 'SMA', 'bekerja', 'Belum Kawin', 'hidup', 'WNI', '0851626163333', 'bigmo@gmail.com', 'Jl. Raya Banyumas No. 1', NULL, '2026-02-05 21:42:55', '2026-02-07 00:40:17', NULL),
(10, '3201010101010006', 'Ramdan Dwi Saputra', 'L', 'Banyumas', '2026-02-06', 'A', 'Islam', 'SMP', 'bekerja', 'Belum Kawin', 'hidup', 'WNI', '0851626163333', 'ramdandsaputra@gmail.id', 'Jl. Raya Konoha No. 1', NULL, '2026-02-06 01:45:35', '2026-02-06 10:13:12', NULL),
(11, '3201010101010007', 'Tv Girl', 'P', 'UK', '2008-09-03', 'A', 'Kristen', 'S3', 'bekerja', 'Belum Kawin', 'hidup', 'WNA', '0851626163334', 'tvgirl@gmail.com', 'UK', NULL, '2026-02-06 21:56:20', '2026-02-07 00:39:41', NULL),
(12, '3201010101010009', 'Wisp', 'P', 'Jakarta', '2008-09-07', 'AB', 'Kristen', 'S1', 'tidak bekerja', 'Kawin', 'hidup', 'WNI', '0851626163335', 'wisp@gmail.com', 'Wisp', NULL, '2026-02-07 00:06:14', '2026-02-07 00:06:14', NULL),
(13, '3201010101010020', 'Kansa Rahmadhani', 'P', 'Bojongsari', '2009-09-30', 'O', 'Islam', 'SMA', 'tidak bekerja', 'Kawin', 'hidup', 'WNI', '0851626163336', 'kansa@gmail.com', 'Bojongsari', 10, '2026-02-07 00:35:50', '2026-02-07 00:43:55', NULL),
(14, '3201010101010021', 'Resbob', 'L', 'Purwokerto', '1990-05-07', 'AB', 'Budha', 'SMA', 'tidak bekerja', 'Belum Kawin', 'hidup', 'WNI', '0851626163337', 'resbob@gmail.com', 'Penjaruy', 11, '2026-02-07 00:42:10', '2026-02-07 00:43:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penerima_bantuan`
--

CREATE TABLE `penerima_bantuan` (
  `id` bigint UNSIGNED NOT NULL,
  `bantuan_id` bigint UNSIGNED NOT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `status` enum('ditetapkan','disalurkan','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ditetapkan',
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` bigint UNSIGNED NOT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('baru','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baru',
  `tanggapan` text COLLATE utf8mb4_unicode_ci,
  `petugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_web`
--

CREATE TABLE `pengaturan_web` (
  `id` bigint UNSIGNED NOT NULL,
  `desa_id` bigint UNSIGNED NOT NULL,
  `nama_pengaturan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_pengaturan` text COLLATE utf8mb4_unicode_ci,
  `tipe_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penomoran_surat`
--

CREATE TABLE `penomoran_surat` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_surat_id` bigint UNSIGNED NOT NULL,
  `tahun` year NOT NULL,
  `nomor_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perangkat_desa`
--

CREATE TABLE `perangkat_desa` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `jabatan` enum('kades','sekdes','kasi','kaur','kadus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `periode_mulai` date NOT NULL,
  `periode_selesai` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `realisasi_anggaran`
--

CREATE TABLE `realisasi_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `apbdes_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_akses` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rumah_tangga`
--

CREATE TABLE `rumah_tangga` (
  `id` bigint UNSIGNED NOT NULL,
  `no_rumah_tangga` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `wilayah_id` bigint UNSIGNED DEFAULT NULL,
  `jumlah_anggota` int NOT NULL DEFAULT '0',
  `klasifikasi_ekonomi` enum('miskin','rentan','mampu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_terdaftar` date DEFAULT NULL,
  `jenis_bantuan_aktif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rumah_tangga_penduduk`
--

CREATE TABLE `rumah_tangga_penduduk` (
  `id` bigint UNSIGNED NOT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `rumah_tangga_id` bigint UNSIGNED NOT NULL,
  `hubungan_rumah_tangga` enum('kepala_rumah_tangga','istri','suami','anak','orang_tua','saudara','pembantu','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sekretariat_informasi_publik`
--

CREATE TABLE `sekretariat_informasi_publik` (
  `id` bigint UNSIGNED NOT NULL,
  `judul_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_dokumen` enum('file','link','teks') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'file',
  `unggah_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retensi_dokumen` int NOT NULL DEFAULT '0',
  `satuan_retensi` enum('hari','bulan','tahun') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hari',
  `kategori_info_publik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tahun` year DEFAULT NULL,
  `tanggal_terbit` date NOT NULL,
  `status_terbit` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sekretariat_informasi_publik`
--

INSERT INTO `sekretariat_informasi_publik` (`id`, `judul_dokumen`, `tipe_dokumen`, `unggah_dokumen`, `retensi_dokumen`, `satuan_retensi`, `kategori_info_publik`, `keterangan`, `tahun`, `tanggal_terbit`, `status_terbit`, `created_at`, `updated_at`) VALUES
(3, 'Epstein File', 'file', 'sekretariat/informasi-publik/sbrUwWlssVweVh2q7wPmpHbSznBHmSFczPzrkCNs.pdf', 0, 'hari', 'Informasi Setiap Saat', NULL, '2026', '2026-02-09', 'ya', '2026-02-08 22:57:59', '2026-02-09 02:37:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Po61Aod6R9GONFYM4c9mtq9VX9ZGYa4fYhnDN5Q3', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic3N3WVp1VFFmdU1KaHBndGZyblJpNzNRWDExTEJIcVljN0kxalczSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZWtyZXRhcmlhdC9pbmZvcm1hc2ktcHVibGlrIjtzOjU6InJvdXRlIjtzOjQwOiJhZG1pbi5zZWtyZXRhcmlhdC5pbmZvcm1hc2ktcHVibGlrLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1770630466),
('wB316Q9HBQyCZDcPPXe5i38VR4V8rsksQdxdbloz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTXB6NlAzbUlqa2JMYlg5anlYSnVJRmdldGxTSEdzdXJNbmVtcHZOVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1770643052);

-- --------------------------------------------------------

--
-- Table structure for table `sumber_dana`
--

CREATE TABLE `sumber_dana` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_sumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `penandatangan_id` bigint UNSIGNED NOT NULL,
  `file_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_permohonan`
--

CREATE TABLE `surat_permohonan` (
  `id` bigint UNSIGNED NOT NULL,
  `surat_id` bigint UNSIGNED NOT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `jenis_surat_id` bigint UNSIGNED NOT NULL,
  `tanggal_permohonan` date NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `data_isian` json DEFAULT NULL,
  `status` enum('diajukan','diproses','ditolak','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `catatan_petugas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_anggaran`
--

CREATE TABLE `tahun_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun` year NOT NULL,
  `status` enum('aktif','arsip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_surat`
--

CREATE TABLE `template_surat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint NOT NULL,
  `status` tinyint(1) NOT NULL,
  `tahun` year NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kas`
--

CREATE TABLE `transaksi_kas` (
  `id` bigint UNSIGNED NOT NULL,
  `kas_id` bigint UNSIGNED NOT NULL,
  `realisasi_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `tipe` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Ramdan', 'ramdan', 'ramdan@gmail.com', NULL, '$2y$12$HT.MSwfDJc/IGOLeX7u57ODiM0s2mo7vy2.5HTo.wAW7/pGHfrWBO', NULL, 'admin', '2026-02-05 01:24:18', '2026-02-08 23:32:04'),
(6, 'Bagas Sekao', 'bagas@gmail.com', 'bagas@gmail.com', NULL, '$2y$12$qy8KzKOh2RiK5wRp/9bktupjmA4CK0zo.QgvSRHxUbAJ5/G5vrmL.', NULL, 'admin', '2026-02-05 21:10:38', '2026-02-05 21:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id` bigint UNSIGNED NOT NULL,
  `desa_id` bigint UNSIGNED NOT NULL,
  `dusun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ketua_rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ketua_rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_kk` int NOT NULL DEFAULT '0',
  `jumlah_penduduk` int NOT NULL DEFAULT '0',
  `laki_laki` int NOT NULL DEFAULT '0',
  `perempuan` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id`, `desa_id`, `dusun`, `rw`, `rt`, `ketua_rt`, `ketua_rw`, `jumlah_kk`, `jumlah_penduduk`, `laki_laki`, `perempuan`, `created_at`, `updated_at`) VALUES
(10, 1, 'Dusun 1', '1', '1', NULL, 'ram', 1, 10, 9, 1, '2026-02-05 21:03:55', '2026-02-06 01:41:09'),
(11, 1, 'coba', '1', '1', NULL, 'coba', 5, 3, 1, 2, '2026-02-06 01:42:22', '2026-02-06 01:42:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda_config_id_foreign` (`config_id`);

--
-- Indexes for table `agenda_config`
--
ALTER TABLE `agenda_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda_config_desa_id_foreign` (`desa_id`);

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apbdes`
--
ALTER TABLE `apbdes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apbdes_tahun_id_foreign` (`tahun_id`),
  ADD KEY `apbdes_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `apbdes_sumber_dana_id_foreign` (`sumber_dana_id`);

--
-- Indexes for table `arsip_surat`
--
ALTER TABLE `arsip_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_surat_surat_keluar_id_foreign` (`surat_keluar_id`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aset_desa`
--
ALTER TABLE `aset_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aset_desa_desa_id_foreign` (`desa_id`);

--
-- Indexes for table `bantuan`
--
ALTER TABLE `bantuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bidang_anggaran`
--
ALTER TABLE `bidang_anggaran`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `desa_kode_desa_unique` (`kode_desa`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `identitas_desa`
--
ALTER TABLE `identitas_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identitas_desa_user_id_foreign` (`user_id`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `kas_desa`
--
ALTER TABLE `kas_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_desa_tahun_id_foreign` (`tahun_id`);

--
-- Indexes for table `kategori_konten`
--
ALTER TABLE `kategori_konten`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_konten_slug_unique` (`slug`);

--
-- Indexes for table `kegiatan_anggaran`
--
ALTER TABLE `kegiatan_anggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_anggaran_bidang_id_foreign` (`bidang_id`);

--
-- Indexes for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `keluarga_no_kk_unique` (`no_kk`),
  ADD KEY `keluarga_wilayah_id_foreign` (`wilayah_id`);

--
-- Indexes for table `keluarga_anggota`
--
ALTER TABLE `keluarga_anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `keluarga_anggota_penduduk_id_keluarga_id_unique` (`penduduk_id`,`keluarga_id`),
  ADD KEY `keluarga_anggota_keluarga_id_foreign` (`keluarga_id`);

--
-- Indexes for table `klasifikasi_surats`
--
ALTER TABLE `klasifikasi_surats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `klasifikasi_surats_kode_unique` (`kode`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentar_konten_id_foreign` (`konten_id`),
  ADD KEY `komentar_penduduk_id_foreign` (`penduduk_id`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `konten_slug_unique` (`slug`),
  ADD KEY `konten_desa_id_foreign` (`desa_id`),
  ADD KEY `konten_media_id_foreign` (`media_id`),
  ADD KEY `konten_penulis_id_foreign` (`penulis_id`),
  ADD KEY `konten_editor_id_foreign` (`editor_id`);

--
-- Indexes for table `konten_log`
--
ALTER TABLE `konten_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konten_log_konten_id_foreign` (`konten_id`),
  ADD KEY `konten_log_user_id_foreign` (`user_id`);

--
-- Indexes for table `konten_media`
--
ALTER TABLE `konten_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konten_media_konten_id_foreign` (`konten_id`),
  ADD KEY `konten_media_media_id_foreign` (`media_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_desa_id_foreign` (`desa_id`),
  ADD KEY `media_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penduduk_nik_unique` (`nik`),
  ADD KEY `penduduk_wilayah_id_foreign` (`wilayah_id`);

--
-- Indexes for table `penerima_bantuan`
--
ALTER TABLE `penerima_bantuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerima_bantuan_bantuan_id_foreign` (`bantuan_id`),
  ADD KEY `penerima_bantuan_penduduk_id_foreign` (`penduduk_id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_penduduk_id_foreign` (`penduduk_id`);

--
-- Indexes for table `pengaturan_web`
--
ALTER TABLE `pengaturan_web`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaturan_web_desa_id_foreign` (`desa_id`);

--
-- Indexes for table `penomoran_surat`
--
ALTER TABLE `penomoran_surat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penomoran_surat_jenis_surat_id_tahun_unique` (`jenis_surat_id`,`tahun`);

--
-- Indexes for table `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perangkat_desa_penduduk_id_foreign` (`penduduk_id`);

--
-- Indexes for table `realisasi_anggaran`
--
ALTER TABLE `realisasi_anggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `realisasi_anggaran_apbdes_id_foreign` (`apbdes_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_nama_role_unique` (`nama_role`);

--
-- Indexes for table `rumah_tangga`
--
ALTER TABLE `rumah_tangga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rumah_tangga_no_rumah_tangga_unique` (`no_rumah_tangga`),
  ADD KEY `rumah_tangga_wilayah_id_foreign` (`wilayah_id`);

--
-- Indexes for table `rumah_tangga_penduduk`
--
ALTER TABLE `rumah_tangga_penduduk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rumah_tangga_penduduk_penduduk_id_rumah_tangga_id_unique` (`penduduk_id`,`rumah_tangga_id`),
  ADD KEY `rumah_tangga_penduduk_rumah_tangga_id_foreign` (`rumah_tangga_id`);

--
-- Indexes for table `sekretariat_informasi_publik`
--
ALTER TABLE `sekretariat_informasi_publik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sekretariat_informasi_publik_tipe_dokumen_index` (`tipe_dokumen`),
  ADD KEY `sekretariat_informasi_publik_kategori_info_publik_index` (`kategori_info_publik`),
  ADD KEY `sekretariat_informasi_publik_status_terbit_index` (`status_terbit`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sumber_dana`
--
ALTER TABLE `sumber_dana`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `surat_kode_surat_unique` (`kode_surat`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `surat_keluar_nomor_surat_unique` (`nomor_surat`),
  ADD KEY `surat_keluar_permohonan_id_foreign` (`permohonan_id`),
  ADD KEY `surat_keluar_template_id_foreign` (`template_id`),
  ADD KEY `surat_keluar_penandatangan_id_foreign` (`penandatangan_id`);

--
-- Indexes for table `surat_permohonan`
--
ALTER TABLE `surat_permohonan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_permohonan_surat_id_foreign` (`surat_id`),
  ADD KEY `surat_permohonan_penduduk_id_foreign` (`penduduk_id`),
  ADD KEY `surat_permohonan_jenis_surat_id_foreign` (`jenis_surat_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_slug_unique` (`slug`);

--
-- Indexes for table `tahun_anggaran`
--
ALTER TABLE `tahun_anggaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun_anggaran_tahun_unique` (`tahun`);

--
-- Indexes for table `template_surat`
--
ALTER TABLE `template_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_kas`
--
ALTER TABLE `transaksi_kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_kas_kas_id_foreign` (`kas_id`),
  ADD KEY `transaksi_kas_realisasi_id_foreign` (`realisasi_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`),
  ADD KEY `user_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wilayah_desa_id_foreign` (`desa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agenda_config`
--
ALTER TABLE `agenda_config`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apbdes`
--
ALTER TABLE `apbdes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsip_surat`
--
ALTER TABLE `arsip_surat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `aset_desa`
--
ALTER TABLE `aset_desa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bantuan`
--
ALTER TABLE `bantuan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bidang_anggaran`
--
ALTER TABLE `bidang_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `desa`
--
ALTER TABLE `desa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `identitas_desa`
--
ALTER TABLE `identitas_desa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_desa`
--
ALTER TABLE `kas_desa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_konten`
--
ALTER TABLE `kategori_konten`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatan_anggaran`
--
ALTER TABLE `kegiatan_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `keluarga_anggota`
--
ALTER TABLE `keluarga_anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `klasifikasi_surats`
--
ALTER TABLE `klasifikasi_surats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konten_log`
--
ALTER TABLE `konten_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konten_media`
--
ALTER TABLE `konten_media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `penerima_bantuan`
--
ALTER TABLE `penerima_bantuan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaturan_web`
--
ALTER TABLE `pengaturan_web`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penomoran_surat`
--
ALTER TABLE `penomoran_surat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `realisasi_anggaran`
--
ALTER TABLE `realisasi_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rumah_tangga`
--
ALTER TABLE `rumah_tangga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rumah_tangga_penduduk`
--
ALTER TABLE `rumah_tangga_penduduk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sekretariat_informasi_publik`
--
ALTER TABLE `sekretariat_informasi_publik`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sumber_dana`
--
ALTER TABLE `sumber_dana`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_permohonan`
--
ALTER TABLE `surat_permohonan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahun_anggaran`
--
ALTER TABLE `tahun_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_surat`
--
ALTER TABLE `template_surat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_kas`
--
ALTER TABLE `transaksi_kas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_config_id_foreign` FOREIGN KEY (`config_id`) REFERENCES `agenda_config` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agenda_config`
--
ALTER TABLE `agenda_config`
  ADD CONSTRAINT `agenda_config_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `apbdes`
--
ALTER TABLE `apbdes`
  ADD CONSTRAINT `apbdes_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan_anggaran` (`id`),
  ADD CONSTRAINT `apbdes_sumber_dana_id_foreign` FOREIGN KEY (`sumber_dana_id`) REFERENCES `sumber_dana` (`id`),
  ADD CONSTRAINT `apbdes_tahun_id_foreign` FOREIGN KEY (`tahun_id`) REFERENCES `tahun_anggaran` (`id`);

--
-- Constraints for table `arsip_surat`
--
ALTER TABLE `arsip_surat`
  ADD CONSTRAINT `arsip_surat_surat_keluar_id_foreign` FOREIGN KEY (`surat_keluar_id`) REFERENCES `surat_keluar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `aset_desa`
--
ALTER TABLE `aset_desa`
  ADD CONSTRAINT `aset_desa_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`);

--
-- Constraints for table `identitas_desa`
--
ALTER TABLE `identitas_desa`
  ADD CONSTRAINT `identitas_desa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kas_desa`
--
ALTER TABLE `kas_desa`
  ADD CONSTRAINT `kas_desa_tahun_id_foreign` FOREIGN KEY (`tahun_id`) REFERENCES `tahun_anggaran` (`id`);

--
-- Constraints for table `kegiatan_anggaran`
--
ALTER TABLE `kegiatan_anggaran`
  ADD CONSTRAINT `kegiatan_anggaran_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang_anggaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD CONSTRAINT `keluarga_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`);

--
-- Constraints for table `keluarga_anggota`
--
ALTER TABLE `keluarga_anggota`
  ADD CONSTRAINT `keluarga_anggota_keluarga_id_foreign` FOREIGN KEY (`keluarga_id`) REFERENCES `keluarga` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keluarga_anggota_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_konten_id_foreign` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentar_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `konten`
--
ALTER TABLE `konten`
  ADD CONSTRAINT `konten_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `konten_editor_id_foreign` FOREIGN KEY (`editor_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `konten_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `konten_penulis_id_foreign` FOREIGN KEY (`penulis_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `konten_log`
--
ALTER TABLE `konten_log`
  ADD CONSTRAINT `konten_log_konten_id_foreign` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `konten_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `konten_media`
--
ALTER TABLE `konten_media`
  ADD CONSTRAINT `konten_media_konten_id_foreign` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `konten_media_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD CONSTRAINT `penduduk_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `penerima_bantuan`
--
ALTER TABLE `penerima_bantuan`
  ADD CONSTRAINT `penerima_bantuan_bantuan_id_foreign` FOREIGN KEY (`bantuan_id`) REFERENCES `bantuan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penerima_bantuan_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`);

--
-- Constraints for table `pengaturan_web`
--
ALTER TABLE `pengaturan_web`
  ADD CONSTRAINT `pengaturan_web_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penomoran_surat`
--
ALTER TABLE `penomoran_surat`
  ADD CONSTRAINT `penomoran_surat_jenis_surat_id_foreign` FOREIGN KEY (`jenis_surat_id`) REFERENCES `jenis_surat` (`id`);

--
-- Constraints for table `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  ADD CONSTRAINT `perangkat_desa_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `realisasi_anggaran`
--
ALTER TABLE `realisasi_anggaran`
  ADD CONSTRAINT `realisasi_anggaran_apbdes_id_foreign` FOREIGN KEY (`apbdes_id`) REFERENCES `apbdes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rumah_tangga`
--
ALTER TABLE `rumah_tangga`
  ADD CONSTRAINT `rumah_tangga_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rumah_tangga_penduduk`
--
ALTER TABLE `rumah_tangga_penduduk`
  ADD CONSTRAINT `rumah_tangga_penduduk_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rumah_tangga_penduduk_rumah_tangga_id_foreign` FOREIGN KEY (`rumah_tangga_id`) REFERENCES `rumah_tangga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_penandatangan_id_foreign` FOREIGN KEY (`penandatangan_id`) REFERENCES `perangkat_desa` (`id`),
  ADD CONSTRAINT `surat_keluar_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `surat_permohonan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_keluar_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `template_surat` (`id`);

--
-- Constraints for table `surat_permohonan`
--
ALTER TABLE `surat_permohonan`
  ADD CONSTRAINT `surat_permohonan_jenis_surat_id_foreign` FOREIGN KEY (`jenis_surat_id`) REFERENCES `jenis_surat` (`id`),
  ADD CONSTRAINT `surat_permohonan_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`),
  ADD CONSTRAINT `surat_permohonan_surat_id_foreign` FOREIGN KEY (`surat_id`) REFERENCES `surat` (`id`);

--
-- Constraints for table `transaksi_kas`
--
ALTER TABLE `transaksi_kas`
  ADD CONSTRAINT `transaksi_kas_kas_id_foreign` FOREIGN KEY (`kas_id`) REFERENCES `kas_desa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_kas_realisasi_id_foreign` FOREIGN KEY (`realisasi_id`) REFERENCES `realisasi_anggaran` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD CONSTRAINT `wilayah_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
