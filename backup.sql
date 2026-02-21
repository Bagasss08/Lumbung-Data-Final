-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: lumbungdata
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `config_id` bigint unsigned NOT NULL,
  `tgl_agenda` date NOT NULL,
  `koordinator_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_config_id_foreign` (`config_id`),
  CONSTRAINT `agenda_config_id_foreign` FOREIGN KEY (`config_id`) REFERENCES `agenda_config` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda_config`
--

DROP TABLE IF EXISTS `agenda_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda_config` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desa_id` bigint unsigned NOT NULL,
  `nama_pengaturan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_pengaturan` text COLLATE utf8mb4_unicode_ci,
  `tipe_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_config_desa_id_foreign` (`desa_id`),
  CONSTRAINT `agenda_config_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_config`
--

LOCK TABLES `agenda_config` WRITE;
/*!40000 ALTER TABLE `agenda_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `agenda_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anggaran`
--

DROP TABLE IF EXISTS `anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggaran`
--

LOCK TABLES `anggaran` WRITE;
/*!40000 ALTER TABLE `anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `anggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apbdes`
--

DROP TABLE IF EXISTS `apbdes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apbdes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun_id` bigint unsigned NOT NULL,
  `kegiatan_id` bigint unsigned NOT NULL,
  `sumber_dana_id` bigint unsigned NOT NULL,
  `anggaran` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apbdes_tahun_id_foreign` (`tahun_id`),
  KEY `apbdes_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `apbdes_sumber_dana_id_foreign` (`sumber_dana_id`),
  CONSTRAINT `apbdes_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan_anggaran` (`id`),
  CONSTRAINT `apbdes_sumber_dana_id_foreign` FOREIGN KEY (`sumber_dana_id`) REFERENCES `sumber_dana` (`id`),
  CONSTRAINT `apbdes_tahun_id_foreign` FOREIGN KEY (`tahun_id`) REFERENCES `tahun_anggaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apbdes`
--

LOCK TABLES `apbdes` WRITE;
/*!40000 ALTER TABLE `apbdes` DISABLE KEYS */;
/*!40000 ALTER TABLE `apbdes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arsip_surat`
--

DROP TABLE IF EXISTS `arsip_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arsip_surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `surat_keluar_id` bigint unsigned NOT NULL,
  `lokasi_arsip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `arsip_surat_surat_keluar_id_foreign` (`surat_keluar_id`),
  CONSTRAINT `arsip_surat_surat_keluar_id_foreign` FOREIGN KEY (`surat_keluar_id`) REFERENCES `surat_keluar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arsip_surat`
--

LOCK TABLES `arsip_surat` WRITE;
/*!40000 ALTER TABLE `arsip_surat` DISABLE KEYS */;
/*!40000 ALTER TABLE `arsip_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artikel`
--

DROP TABLE IF EXISTS `artikel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artikel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikel`
--

LOCK TABLES `artikel` WRITE;
/*!40000 ALTER TABLE `artikel` DISABLE KEYS */;
/*!40000 ALTER TABLE `artikel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aset_desa`
--

DROP TABLE IF EXISTS `aset_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aset_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desa_id` bigint unsigned NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aset_desa_desa_id_foreign` (`desa_id`),
  CONSTRAINT `aset_desa_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aset_desa`
--

LOCK TABLES `aset_desa` WRITE;
/*!40000 ALTER TABLE `aset_desa` DISABLE KEYS */;
/*!40000 ALTER TABLE `aset_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bantuan`
--

DROP TABLE IF EXISTS `bantuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bantuan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_bantuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber_dana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `kriteria` text COLLATE utf8mb4_unicode_ci,
  `nominal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bantuan`
--

LOCK TABLES `bantuan` WRITE;
/*!40000 ALTER TABLE `bantuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `bantuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bidang_anggaran`
--

DROP TABLE IF EXISTS `bidang_anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bidang_anggaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bidang_anggaran`
--

LOCK TABLES `bidang_anggaran` WRITE;
/*!40000 ALTER TABLE `bidang_anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `bidang_anggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desa`
--

DROP TABLE IF EXISTS `desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `desa_kode_desa_unique` (`kode_desa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desa`
--

LOCK TABLES `desa` WRITE;
/*!40000 ALTER TABLE `desa` DISABLE KEYS */;
/*!40000 ALTER TABLE `desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identitas_desa`
--

DROP TABLE IF EXISTS `identitas_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `identitas_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
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
  `gambar_kantor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `identitas_desa_user_id_foreign` (`user_id`),
  CONSTRAINT `identitas_desa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identitas_desa`
--

LOCK TABLES `identitas_desa` WRITE;
/*!40000 ALTER TABLE `identitas_desa` DISABLE KEYS */;
INSERT INTO `identitas_desa` VALUES (1,NULL,'Serayu Larangan','1000000000','1000000000','53352','Mrebet','1000000000','Anonim','643563','Purbalingga','1000000000','Jawa Tengah',NULL,'Serayu Larangan',NULL,'serayularangan@gmail.com','085812345678','085812345678','https://serayu-larangan.com/','Fajar Prasetyo Utomo','197001011990011001',NULL,NULL,NULL,NULL,NULL,'AuhWDfZlGvwJ1slteUFEjVxcJkvQxXbpKo6ON45b.jpg','2026-02-12 01:57:31','2026-02-12 01:59:13','sktixXtFMjcBfbCbFq1RjXjNgkSJ52cVaHb7dZhr.png');
/*!40000 ALTER TABLE `identitas_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaris`
--

DROP TABLE IF EXISTS `inventaris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventaris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaris`
--

LOCK TABLES `inventaris` WRITE;
/*!40000 ALTER TABLE `inventaris` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_surat`
--

DROP TABLE IF EXISTS `jenis_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `aktif` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_surat`
--

LOCK TABLES `jenis_surat` WRITE;
/*!40000 ALTER TABLE `jenis_surat` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kas_desa`
--

DROP TABLE IF EXISTS `kas_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kas_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun_id` bigint unsigned NOT NULL,
  `saldo_awal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_akhir` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kas_desa_tahun_id_foreign` (`tahun_id`),
  CONSTRAINT `kas_desa_tahun_id_foreign` FOREIGN KEY (`tahun_id`) REFERENCES `tahun_anggaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kas_desa`
--

LOCK TABLES `kas_desa` WRITE;
/*!40000 ALTER TABLE `kas_desa` DISABLE KEYS */;
/*!40000 ALTER TABLE `kas_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_konten`
--

DROP TABLE IF EXISTS `kategori_konten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori_konten` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `urutan` int NOT NULL DEFAULT '0',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_konten_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_konten`
--

LOCK TABLES `kategori_konten` WRITE;
/*!40000 ALTER TABLE `kategori_konten` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategori_konten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan_anggaran`
--

DROP TABLE IF EXISTS `kegiatan_anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kegiatan_anggaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bidang_id` bigint unsigned NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kegiatan_anggaran_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `kegiatan_anggaran_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang_anggaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan_anggaran`
--

LOCK TABLES `kegiatan_anggaran` WRITE;
/*!40000 ALTER TABLE `kegiatan_anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `kegiatan_anggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keluarga`
--

DROP TABLE IF EXISTS `keluarga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keluarga` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_kk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `wilayah_id` bigint unsigned NOT NULL,
  `tgl_terdaftar` date NOT NULL,
  `klasifikasi_ekonomi` enum('miskin','rentan','mampu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_bantuan_aktif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keluarga_no_kk_unique` (`no_kk`),
  KEY `keluarga_wilayah_id_foreign` (`wilayah_id`),
  CONSTRAINT `keluarga_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keluarga`
--

LOCK TABLES `keluarga` WRITE;
/*!40000 ALTER TABLE `keluarga` DISABLE KEYS */;
/*!40000 ALTER TABLE `keluarga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keluarga_anggota`
--

DROP TABLE IF EXISTS `keluarga_anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keluarga_anggota` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `penduduk_id` bigint unsigned NOT NULL,
  `keluarga_id` bigint unsigned NOT NULL,
  `hubungan_keluarga` enum('kepala_keluarga','istri','suami','anak','orang_tua','saudara','famili_lain') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'famili_lain',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keluarga_anggota_penduduk_id_keluarga_id_unique` (`penduduk_id`,`keluarga_id`),
  KEY `keluarga_anggota_keluarga_id_foreign` (`keluarga_id`),
  CONSTRAINT `keluarga_anggota_keluarga_id_foreign` FOREIGN KEY (`keluarga_id`) REFERENCES `keluarga` (`id`) ON DELETE CASCADE,
  CONSTRAINT `keluarga_anggota_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keluarga_anggota`
--

LOCK TABLES `keluarga_anggota` WRITE;
/*!40000 ALTER TABLE `keluarga_anggota` DISABLE KEYS */;
/*!40000 ALTER TABLE `keluarga_anggota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klasifikasi_surats`
--

DROP TABLE IF EXISTS `klasifikasi_surats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `klasifikasi_surats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_klasifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retensi_aktif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retensi_inaktif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `klasifikasi_surats_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klasifikasi_surats`
--

LOCK TABLES `klasifikasi_surats` WRITE;
/*!40000 ALTER TABLE `klasifikasi_surats` DISABLE KEYS */;
/*!40000 ALTER TABLE `klasifikasi_surats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `komentar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `konten_id` bigint unsigned NOT NULL,
  `penduduk_id` bigint unsigned DEFAULT NULL,
  `nama_pengirim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `komentar_konten_id_foreign` (`konten_id`),
  KEY `komentar_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `komentar_konten_id_foreign` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`id`) ON DELETE CASCADE,
  CONSTRAINT `komentar_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komentar`
--

LOCK TABLES `komentar` WRITE;
/*!40000 ALTER TABLE `komentar` DISABLE KEYS */;
/*!40000 ALTER TABLE `komentar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konten`
--

DROP TABLE IF EXISTS `konten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konten` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desa_id` bigint unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` text COLLATE utf8mb4_unicode_ci,
  `isi_konten` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_id` bigint unsigned DEFAULT NULL,
  `jenis_konten` enum('berita','pengumuman','layanan','regulasi','galeri') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draf','review','publish','arsip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draf',
  `tanggal_publish` timestamp NULL DEFAULT NULL,
  `tanggal_kadaluarsa` timestamp NULL DEFAULT NULL,
  `penulis_id` bigint unsigned NOT NULL,
  `editor_id` bigint unsigned DEFAULT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahasa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'id',
  `jumlah_view` int NOT NULL DEFAULT '0',
  `komentar_aktif` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `konten_slug_unique` (`slug`),
  KEY `konten_desa_id_foreign` (`desa_id`),
  KEY `konten_media_id_foreign` (`media_id`),
  KEY `konten_penulis_id_foreign` (`penulis_id`),
  KEY `konten_editor_id_foreign` (`editor_id`),
  CONSTRAINT `konten_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `konten_editor_id_foreign` FOREIGN KEY (`editor_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `konten_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `konten_penulis_id_foreign` FOREIGN KEY (`penulis_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konten`
--

LOCK TABLES `konten` WRITE;
/*!40000 ALTER TABLE `konten` DISABLE KEYS */;
/*!40000 ALTER TABLE `konten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konten_log`
--

DROP TABLE IF EXISTS `konten_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konten_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `konten_id` bigint unsigned NOT NULL,
  `aksi` enum('buat','edit','publish','arsip') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `konten_log_konten_id_foreign` (`konten_id`),
  KEY `konten_log_user_id_foreign` (`user_id`),
  CONSTRAINT `konten_log_konten_id_foreign` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`id`) ON DELETE CASCADE,
  CONSTRAINT `konten_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konten_log`
--

LOCK TABLES `konten_log` WRITE;
/*!40000 ALTER TABLE `konten_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `konten_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konten_media`
--

DROP TABLE IF EXISTS `konten_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konten_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `konten_id` bigint unsigned NOT NULL,
  `media_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `konten_media_konten_id_foreign` (`konten_id`),
  KEY `konten_media_media_id_foreign` (`media_id`),
  CONSTRAINT `konten_media_konten_id_foreign` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`id`) ON DELETE CASCADE,
  CONSTRAINT `konten_media_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konten_media`
--

LOCK TABLES `konten_media` WRITE;
/*!40000 ALTER TABLE `konten_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `konten_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desa_id` bigint unsigned NOT NULL,
  `jenis_media` enum('gambar','video','dokumen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_file` bigint DEFAULT NULL,
  `tipe_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint unsigned NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_desa_id_foreign` (`desa_id`),
  KEY `media_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `media_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_03_034538_create_desa_table',1),(5,'2026_02_03_034612_create_wilayah_table',1),(6,'2026_02_03_034637_create_keluarga_table',1),(7,'2026_02_03_034702_create_penduduk_table',1),(8,'2026_02_03_034829_add_fk_kepala_keluarga_to_keluarga_table',1),(9,'2026_02_03_034852_create_role_table',1),(10,'2026_02_03_034944_create_user_table',1),(11,'2026_02_03_035012_create_perangkat_desa_table',1),(12,'2026_02_03_035642_create_media_table',1),(13,'2026_02_03_035722_create_kategori_konten_table',1),(14,'2026_02_03_035818_create_tag_table',1),(15,'2026_02_03_035846_create_konten_table',1),(16,'2026_02_03_035910_create_konten_media_table',1),(17,'2026_02_03_040002_create_komentar_table',1),(18,'2026_02_03_040023_create_konten_log_table',1),(19,'2026_02_03_040047_create_pengaturan_web_table',1),(20,'2026_02_03_040115_create_agenda_config_table',1),(21,'2026_02_03_040136_create_agenda_table',1),(22,'2026_02_03_040228_create_artikel_table',1),(23,'2026_02_03_040743_create_surat_table',1),(24,'2026_02_03_040814_create_jenis_surat_table',1),(25,'2026_02_03_040836_create_template_surat_table',1),(26,'2026_02_03_040901_create_surat_permohonan_table',1),(27,'2026_02_03_040931_create_surat_keluar_table',1),(28,'2026_02_03_040959_create_penomoran_surat_table',1),(29,'2026_02_03_041018_create_arsip_surat_table',1),(30,'2026_02_03_041046_create_pengaduan_surat_table',1),(31,'2026_02_03_041614_create_tahun_anggaran_table',1),(32,'2026_02_03_041637_create_sumber_dana_table',1),(33,'2026_02_03_041658_create_bidang_anggaran_table',1),(34,'2026_02_03_041718_create_kegiatan_anggaran_table',1),(35,'2026_02_03_041741_create_anggaran_table',1),(36,'2026_02_03_041806_create_apbdes_table',1),(37,'2026_02_03_041823_create_kas_desa_table',1),(38,'2026_02_03_041851_create_realisasi_anggaran_table',1),(39,'2026_02_03_041918_create_transaksi_kas_table',1),(40,'2026_02_03_041953_create_aset_desa_table',1),(41,'2026_02_03_042027_create_bantuan_table',1),(42,'2026_02_03_042044_create_penerima_bantuan_table',1),(43,'2026_02_03_052445_create_identitas_desa_table',1),(44,'2026_02_03_052555_add_email_verified_at_and_remember_token_to_users_table',1),(45,'2026_02_03_055537_add_defaults_to_identitas_desa_table',1),(46,'2026_02_04_065023_create_rumah_tangga_table',1),(47,'2026_02_04_080118_add_rumah_tangga_id_to_penduduk_table',1),(48,'2026_02_04_081002_fix_penduduk_structure',1),(49,'2026_02_04_081018_fix_keluarga_structure',1),(50,'2026_02_04_081049_fix_rumah_tangga_structure',1),(51,'2026_02_04_081107_create_keluarga_anggota_table',1),(52,'2026_02_04_081200_fix_keluarga_anggota_pivot',1),(53,'2026_02_04_081220_create_rumah_tangga_penduduk_table',1),(54,'2026_02_04_081230_fix_keluarga_structure_final',1),(55,'2026_02_04_110350_fix_rumah_tangga_structure_final',1),(56,'2026_02_05_082913_add_gambar_kantor_to_identitas_desa_table',1),(57,'2026_02_06_024334_add_laki_laki_perempuan_to_wilayah_table',1),(58,'2026_02_06_034137_fix_keluarga_wilayah_foreign_key',1),(59,'2026_02_09_052709_create_sekretariat_informasi_publik_table',1),(60,'2026_02_09_061225_create_inventaris_table',1),(61,'2026_02_09_062955_create_klasifikasi_surat_table',1),(62,'2026_02_10_043609_create_pendataan_kesehatan_table',1),(63,'2026_02_10_043637_create_vaksin_table',1),(64,'2026_02_10_043653_create_stunting_table',1),(65,'2026_02_10_043700_create_pemantauan_kesehatan_table',1),(66,'2026_02_10_085824_add_lingkar_kepala_to_stuntings_table',1),(67,'2026_02_10_090227_add_status_stunting_to_pemantauan_kesehatans_table_v2',2),(68,'2026_02_10_091659_add_kelurahan_to_pendataan_kesehatans_table',2),(69,'2026_02_12_090807_make_kas_id_nullable_in_transaksi_kas_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemantauan_kesehatans`
--

DROP TABLE IF EXISTS `pemantauan_kesehatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pemantauan_kesehatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penduduk_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pemeriksaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `status_gizi` enum('normal','kurang','lebih','obesitas') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_stunting` enum('normal','stunting','risiko_stunting') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pemantauan_kesehatans_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `pemantauan_kesehatans_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemantauan_kesehatans`
--

LOCK TABLES `pemantauan_kesehatans` WRITE;
/*!40000 ALTER TABLE `pemantauan_kesehatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemantauan_kesehatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendataan_kesehatans`
--

DROP TABLE IF EXISTS `pendataan_kesehatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendataan_kesehatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penduduk_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pemeriksaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `tekanan_darah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_gizi` enum('normal','kurang','lebih','obesitas') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `kelurahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pendataan_kesehatans_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `pendataan_kesehatans_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendataan_kesehatans`
--

LOCK TABLES `pendataan_kesehatans` WRITE;
/*!40000 ALTER TABLE `pendataan_kesehatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pendataan_kesehatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penduduk`
--

DROP TABLE IF EXISTS `penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penduduk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `wilayah_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penduduk_nik_unique` (`nik`),
  KEY `penduduk_wilayah_id_foreign` (`wilayah_id`),
  CONSTRAINT `penduduk_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penduduk`
--

LOCK TABLES `penduduk` WRITE;
/*!40000 ALTER TABLE `penduduk` DISABLE KEYS */;
/*!40000 ALTER TABLE `penduduk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerima_bantuan`
--

DROP TABLE IF EXISTS `penerima_bantuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penerima_bantuan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bantuan_id` bigint unsigned NOT NULL,
  `penduduk_id` bigint unsigned NOT NULL,
  `status` enum('ditetapkan','disalurkan','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ditetapkan',
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penerima_bantuan_bantuan_id_foreign` (`bantuan_id`),
  KEY `penerima_bantuan_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `penerima_bantuan_bantuan_id_foreign` FOREIGN KEY (`bantuan_id`) REFERENCES `bantuan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penerima_bantuan_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerima_bantuan`
--

LOCK TABLES `penerima_bantuan` WRITE;
/*!40000 ALTER TABLE `penerima_bantuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerima_bantuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduan`
--

DROP TABLE IF EXISTS `pengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaduan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penduduk_id` bigint unsigned NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('baru','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baru',
  `tanggapan` text COLLATE utf8mb4_unicode_ci,
  `petugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengaduan_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `pengaduan_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduan`
--

LOCK TABLES `pengaduan` WRITE;
/*!40000 ALTER TABLE `pengaduan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengaduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaturan_web`
--

DROP TABLE IF EXISTS `pengaturan_web`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaturan_web` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desa_id` bigint unsigned NOT NULL,
  `nama_pengaturan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_pengaturan` text COLLATE utf8mb4_unicode_ci,
  `tipe_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengaturan_web_desa_id_foreign` (`desa_id`),
  CONSTRAINT `pengaturan_web_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan_web`
--

LOCK TABLES `pengaturan_web` WRITE;
/*!40000 ALTER TABLE `pengaturan_web` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengaturan_web` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penomoran_surat`
--

DROP TABLE IF EXISTS `penomoran_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penomoran_surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis_surat_id` bigint unsigned NOT NULL,
  `tahun` year NOT NULL,
  `nomor_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penomoran_surat_jenis_surat_id_tahun_unique` (`jenis_surat_id`,`tahun`),
  CONSTRAINT `penomoran_surat_jenis_surat_id_foreign` FOREIGN KEY (`jenis_surat_id`) REFERENCES `jenis_surat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penomoran_surat`
--

LOCK TABLES `penomoran_surat` WRITE;
/*!40000 ALTER TABLE `penomoran_surat` DISABLE KEYS */;
/*!40000 ALTER TABLE `penomoran_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perangkat_desa`
--

DROP TABLE IF EXISTS `perangkat_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perangkat_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penduduk_id` bigint unsigned NOT NULL,
  `jabatan` enum('kades','sekdes','kasi','kaur','kadus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `periode_mulai` date NOT NULL,
  `periode_selesai` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perangkat_desa_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `perangkat_desa_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perangkat_desa`
--

LOCK TABLES `perangkat_desa` WRITE;
/*!40000 ALTER TABLE `perangkat_desa` DISABLE KEYS */;
/*!40000 ALTER TABLE `perangkat_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `realisasi_anggaran`
--

DROP TABLE IF EXISTS `realisasi_anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `realisasi_anggaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `apbdes_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `realisasi_anggaran_apbdes_id_foreign` (`apbdes_id`),
  CONSTRAINT `realisasi_anggaran_apbdes_id_foreign` FOREIGN KEY (`apbdes_id`) REFERENCES `apbdes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `realisasi_anggaran`
--

LOCK TABLES `realisasi_anggaran` WRITE;
/*!40000 ALTER TABLE `realisasi_anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `realisasi_anggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_akses` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_nama_role_unique` (`nama_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rumah_tangga`
--

DROP TABLE IF EXISTS `rumah_tangga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rumah_tangga` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_rumah_tangga` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `wilayah_id` bigint unsigned DEFAULT NULL,
  `jumlah_anggota` int NOT NULL DEFAULT '0',
  `klasifikasi_ekonomi` enum('miskin','rentan','mampu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_terdaftar` date DEFAULT NULL,
  `jenis_bantuan_aktif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rumah_tangga_no_rumah_tangga_unique` (`no_rumah_tangga`),
  KEY `rumah_tangga_wilayah_id_foreign` (`wilayah_id`),
  CONSTRAINT `rumah_tangga_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rumah_tangga`
--

LOCK TABLES `rumah_tangga` WRITE;
/*!40000 ALTER TABLE `rumah_tangga` DISABLE KEYS */;
/*!40000 ALTER TABLE `rumah_tangga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rumah_tangga_penduduk`
--

DROP TABLE IF EXISTS `rumah_tangga_penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rumah_tangga_penduduk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penduduk_id` bigint unsigned NOT NULL,
  `rumah_tangga_id` bigint unsigned NOT NULL,
  `hubungan_rumah_tangga` enum('kepala_rumah_tangga','istri','suami','anak','orang_tua','saudara','pembantu','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rumah_tangga_penduduk_penduduk_id_rumah_tangga_id_unique` (`penduduk_id`,`rumah_tangga_id`),
  KEY `rumah_tangga_penduduk_rumah_tangga_id_foreign` (`rumah_tangga_id`),
  CONSTRAINT `rumah_tangga_penduduk_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rumah_tangga_penduduk_rumah_tangga_id_foreign` FOREIGN KEY (`rumah_tangga_id`) REFERENCES `rumah_tangga` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rumah_tangga_penduduk`
--

LOCK TABLES `rumah_tangga_penduduk` WRITE;
/*!40000 ALTER TABLE `rumah_tangga_penduduk` DISABLE KEYS */;
/*!40000 ALTER TABLE `rumah_tangga_penduduk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekretariat_informasi_publik`
--

DROP TABLE IF EXISTS `sekretariat_informasi_publik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekretariat_informasi_publik` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekretariat_informasi_publik_tipe_dokumen_index` (`tipe_dokumen`),
  KEY `sekretariat_informasi_publik_kategori_info_publik_index` (`kategori_info_publik`),
  KEY `sekretariat_informasi_publik_status_terbit_index` (`status_terbit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekretariat_informasi_publik`
--

LOCK TABLES `sekretariat_informasi_publik` WRITE;
/*!40000 ALTER TABLE `sekretariat_informasi_publik` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekretariat_informasi_publik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('bi7Xw7bl3Zgsa8jtgYMvqGT4ZKJCO8ldMHQGbAGb',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYmxSYkpEbVhibWduNUNubmxpTmNKNTlhRjJERHpKeTluZFRDUTBJNCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4va2V1YW5nYW4vbGFwb3JhbiI7czo1OiJyb3V0ZSI7czoyMjoiYWRtaW4ua2V1YW5nYW4ubGFwb3JhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1770888857);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stuntings`
--

DROP TABLE IF EXISTS `stuntings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stuntings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penduduk_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `lingkar_kepala` decimal(5,2) DEFAULT NULL,
  `status_stunting` enum('normal','stunting','risiko_stunting') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stuntings_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `stuntings_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stuntings`
--

LOCK TABLES `stuntings` WRITE;
/*!40000 ALTER TABLE `stuntings` DISABLE KEYS */;
/*!40000 ALTER TABLE `stuntings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sumber_dana`
--

DROP TABLE IF EXISTS `sumber_dana`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sumber_dana` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_sumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sumber_dana`
--

LOCK TABLES `sumber_dana` WRITE;
/*!40000 ALTER TABLE `sumber_dana` DISABLE KEYS */;
/*!40000 ALTER TABLE `sumber_dana` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat`
--

DROP TABLE IF EXISTS `surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_kode_surat_unique` (`kode_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat`
--

LOCK TABLES `surat` WRITE;
/*!40000 ALTER TABLE `surat` DISABLE KEYS */;
/*!40000 ALTER TABLE `surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_keluar`
--

DROP TABLE IF EXISTS `surat_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_keluar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permohonan_id` bigint unsigned NOT NULL,
  `template_id` bigint unsigned NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `penandatangan_id` bigint unsigned NOT NULL,
  `file_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_keluar_nomor_surat_unique` (`nomor_surat`),
  KEY `surat_keluar_permohonan_id_foreign` (`permohonan_id`),
  KEY `surat_keluar_template_id_foreign` (`template_id`),
  KEY `surat_keluar_penandatangan_id_foreign` (`penandatangan_id`),
  CONSTRAINT `surat_keluar_penandatangan_id_foreign` FOREIGN KEY (`penandatangan_id`) REFERENCES `perangkat_desa` (`id`),
  CONSTRAINT `surat_keluar_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `surat_permohonan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `surat_keluar_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `template_surat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_keluar`
--

LOCK TABLES `surat_keluar` WRITE;
/*!40000 ALTER TABLE `surat_keluar` DISABLE KEYS */;
/*!40000 ALTER TABLE `surat_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_permohonan`
--

DROP TABLE IF EXISTS `surat_permohonan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_permohonan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `surat_id` bigint unsigned NOT NULL,
  `penduduk_id` bigint unsigned NOT NULL,
  `jenis_surat_id` bigint unsigned NOT NULL,
  `tanggal_permohonan` date NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `data_isian` json DEFAULT NULL,
  `status` enum('diajukan','diproses','ditolak','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `catatan_petugas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `surat_permohonan_surat_id_foreign` (`surat_id`),
  KEY `surat_permohonan_penduduk_id_foreign` (`penduduk_id`),
  KEY `surat_permohonan_jenis_surat_id_foreign` (`jenis_surat_id`),
  CONSTRAINT `surat_permohonan_jenis_surat_id_foreign` FOREIGN KEY (`jenis_surat_id`) REFERENCES `jenis_surat` (`id`),
  CONSTRAINT `surat_permohonan_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`),
  CONSTRAINT `surat_permohonan_surat_id_foreign` FOREIGN KEY (`surat_id`) REFERENCES `surat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_permohonan`
--

LOCK TABLES `surat_permohonan` WRITE;
/*!40000 ALTER TABLE `surat_permohonan` DISABLE KEYS */;
/*!40000 ALTER TABLE `surat_permohonan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahun_anggaran`
--

DROP TABLE IF EXISTS `tahun_anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tahun_anggaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year NOT NULL,
  `status` enum('aktif','arsip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tahun_anggaran_tahun_unique` (`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahun_anggaran`
--

LOCK TABLES `tahun_anggaran` WRITE;
/*!40000 ALTER TABLE `tahun_anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `tahun_anggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template_surat`
--

DROP TABLE IF EXISTS `template_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `template_surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template_surat`
--

LOCK TABLES `template_surat` WRITE;
/*!40000 ALTER TABLE `template_surat` DISABLE KEYS */;
/*!40000 ALTER TABLE `template_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi_kas`
--

DROP TABLE IF EXISTS `transaksi_kas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_kas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kas_id` bigint unsigned DEFAULT NULL,
  `realisasi_id` bigint unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `tipe` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_kas_kas_id_foreign` (`kas_id`),
  KEY `transaksi_kas_realisasi_id_foreign` (`realisasi_id`),
  CONSTRAINT `transaksi_kas_kas_id_foreign` FOREIGN KEY (`kas_id`) REFERENCES `kas_desa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_kas_realisasi_id_foreign` FOREIGN KEY (`realisasi_id`) REFERENCES `realisasi_anggaran` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_kas`
--

LOCK TABLES `transaksi_kas` WRITE;
/*!40000 ALTER TABLE `transaksi_kas` DISABLE KEYS */;
INSERT INTO `transaksi_kas` VALUES (1,NULL,NULL,'2026-02-12','masuk',6700000.00,'2026-02-12 02:09:04','2026-02-12 02:09:04');
/*!40000 ALTER TABLE `transaksi_kas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`),
  KEY `user_role_id_foreign` (`role_id`),
  CONSTRAINT `user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin@gmail.com',NULL,'$2y$12$3VcJ1RM5w.S3iHawAFHnOuxo8OnncpHpaBN/mqC.ZSsg.HqsrTcpC',NULL,'operator',NULL,NULL),(3,'Admin User','adminuser','admin@example.com',NULL,'$2y$12$zjjOIsBmtt54ZxU1j92u4OLo28xQyfe3nKhp3LIRjD7l36KSDkSC2',NULL,'admin','2026-02-12 01:57:18','2026-02-12 01:57:18');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaksins`
--

DROP TABLE IF EXISTS `vaksins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaksins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penduduk_id` bigint unsigned NOT NULL,
  `jenis_vaksin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_vaksinasi` date NOT NULL,
  `tempat_vaksinasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `petugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('sudah','belum','jadwal_ulang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `efek_samping` text COLLATE utf8mb4_unicode_ci,
  `tanggal_jadwal_ulang` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vaksins_penduduk_id_foreign` (`penduduk_id`),
  CONSTRAINT `vaksins_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaksins`
--

LOCK TABLES `vaksins` WRITE;
/*!40000 ALTER TABLE `vaksins` DISABLE KEYS */;
/*!40000 ALTER TABLE `vaksins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wilayah`
--

DROP TABLE IF EXISTS `wilayah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wilayah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desa_id` bigint unsigned NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wilayah_desa_id_foreign` (`desa_id`),
  CONSTRAINT `wilayah_desa_id_foreign` FOREIGN KEY (`desa_id`) REFERENCES `desa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wilayah`
--

LOCK TABLES `wilayah` WRITE;
/*!40000 ALTER TABLE `wilayah` DISABLE KEYS */;
/*!40000 ALTER TABLE `wilayah` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-12 21:38:28
