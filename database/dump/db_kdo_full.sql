-- MySQL dump 10.13  Distrib 8.0.37, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_kdo
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('kdo-backend-cache-1ae5e55d10af9f69c4aa202764c77bea','i:2;',1794289403),('kdo-backend-cache-1ae5e55d10af9f69c4aa202764c77bea:timer','i:1794289403;',1794289403),('kdo-backend-cache-1e0c4328d1f409bb933b49e68168cc63','i:1;',1794289442),('kdo-backend-cache-1e0c4328d1f409bb933b49e68168cc63:timer','i:1794289442;',1794289442),('kdo-backend-cache-32de306e8721ae9ff29ae9cc70923aa5','i:3;',1794289401),('kdo-backend-cache-32de306e8721ae9ff29ae9cc70923aa5:timer','i:1794289401;',1794289401),('kdo-backend-cache-4f18e029f474a2ad9ee2c1af01b421e4','i:1;',1794288155),('kdo-backend-cache-4f18e029f474a2ad9ee2c1af01b421e4:timer','i:1794288155;',1794288155),('kdo-backend-cache-7c2150d7106073168321f39ec452420d','i:3;',1794289404),('kdo-backend-cache-7c2150d7106073168321f39ec452420d:timer','i:1794289404;',1794289404),('kdo-backend-cache-8e2ab30c262675a03a368430e0d5b9c4','i:1;',1794288011),('kdo-backend-cache-8e2ab30c262675a03a368430e0d5b9c4:timer','i:1794288011;',1794288011),('kdo-backend-cache-9aade5ba66b55535282a70737ba0f178','i:1;',1794287308),('kdo-backend-cache-9aade5ba66b55535282a70737ba0f178:timer','i:1794287308;',1794287308),('kdo-backend-cache-a3d27816a2aea00713d1743a4e5935ce','i:12;',1794289399),('kdo-backend-cache-a3d27816a2aea00713d1743a4e5935ce:timer','i:1794289399;',1794289399),('kdo-backend-cache-a6f155de15268698bea3ed1df3f9aab3','i:3;',1794289399),('kdo-backend-cache-a6f155de15268698bea3ed1df3f9aab3:timer','i:1794289399;',1794289399),('kdo-backend-cache-adb68ace9d3f97336196a15f53546096','i:1;',1794289433),('kdo-backend-cache-adb68ace9d3f97336196a15f53546096:timer','i:1794289433;',1794289433),('kdo-backend-cache-c6be2cf7c13d9a527ee2fe401bbae3c7','i:1;',1794289434),('kdo-backend-cache-c6be2cf7c13d9a527ee2fe401bbae3c7:timer','i:1794289434;',1794289434),('kdo-backend-cache-c984cac88e447003116204e1dd8ef9d6','i:1;',1794287994),('kdo-backend-cache-c984cac88e447003116204e1dd8ef9d6:timer','i:1794287994;',1794287994),('kdo-backend-cache-d6be2b0cae7d3dbe077ea7adcca3a633','i:1;',1794288727),('kdo-backend-cache-d6be2b0cae7d3dbe077ea7adcca3a633:timer','i:1794288727;',1794288727),('kdo-backend-cache-e4830686b2019b544aafb2dbe539489c','i:1;',1794289440),('kdo-backend-cache-e4830686b2019b544aafb2dbe539489c:timer','i:1794289440;',1794289440),('kdo-backend-cache-f1f70ec40aaa556905d4a030501c0ba4','i:38;',1794289400),('kdo-backend-cache-f1f70ec40aaa556905d4a030501c0ba4:timer','i:1794289400;',1794289400);
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
  `expiration` bigint NOT NULL,
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
  `attempts` smallint unsigned NOT NULL,
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
-- Table structure for table `kendaraan_dinas`
--

DROP TABLE IF EXISTS `kendaraan_dinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kendaraan_dinas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_polisi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_kendaraan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_kendaraan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_produksi` smallint unsigned NOT NULL,
  `warna_kendaraan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` enum('baik','rusak_ringan','rusak_berat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `perangkat_daerah_id` bigint unsigned DEFAULT NULL,
  `pegawai_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nomor_polisi_aktif` varchar(20) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (if((`deleted_at` is null),`nomor_polisi`,NULL)) STORED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kendaraan_dinas_nomor_polisi_aktif_unique` (`nomor_polisi_aktif`),
  KEY `kendaraan_dinas_perangkat_daerah_id_foreign` (`perangkat_daerah_id`),
  KEY `kendaraan_dinas_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `kendaraan_dinas_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kendaraan_dinas_perangkat_daerah_id_foreign` FOREIGN KEY (`perangkat_daerah_id`) REFERENCES `perangkat_daerah` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kendaraan_dinas`
--

LOCK TABLES `kendaraan_dinas` WRITE;
/*!40000 ALTER TABLE `kendaraan_dinas` DISABLE KEYS */;
INSERT INTO `kendaraan_dinas` (`id`, `nomor_polisi`, `merk_kendaraan`, `tipe_kendaraan`, `tahun_produksi`, `warna_kendaraan`, `kondisi`, `perangkat_daerah_id`, `pegawai_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (3,'B 1234 SDK','Toyota','Avanza G',2019,'Hitam','baik',1,3,'2026-11-09 21:51:22','2026-11-09 21:51:22',NULL),(4,'D 5678 PKP','Mitsubishi','Pajero Sport',2021,'Putih','baik',2,4,'2026-11-09 21:51:22','2026-11-09 21:51:22',NULL),(5,'AB 9012 KL','Isuzu','Panther',2015,'Silver','rusak_ringan',3,5,'2026-11-09 21:51:22','2026-11-09 21:51:22',NULL),(6,'B 3456 XYZ','Daihatsu','Terios',2017,'Abu-abu','rusak_berat',4,NULL,'2026-11-09 21:51:22','2026-11-09 21:51:22',NULL),(7,'T 7890 DKS','Toyota','Innova Reborn',2022,'Hitam','baik',5,6,'2026-11-09 21:51:22','2026-11-09 21:51:22',NULL),(8,'DK 2468 SOS','Suzuki','Ertiga',2020,'Merah','baik',6,NULL,'2026-11-09 21:51:22','2026-11-09 21:51:22',NULL),(11,'B 155 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 21:57:10','2026-11-09 21:57:11','2026-11-09 21:57:11'),(12,'B 381 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:08:04','2026-11-09 22:08:05','2026-11-09 22:08:05'),(13,'B 874 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:08:39','2026-11-09 22:08:40','2026-11-09 22:08:40'),(14,'B 73 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:18:54','2026-11-09 22:18:56','2026-11-09 22:18:56'),(15,'B 703 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:19:12','2026-11-09 22:19:13','2026-11-09 22:19:13'),(16,'B 719 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:21:36','2026-11-09 22:21:37','2026-11-09 22:21:37'),(17,'B 378 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:31:08','2026-11-09 22:31:09','2026-11-09 22:31:09'),(18,'B 272 TST','Toyota','Avanza G',2020,'Hitam','rusak_ringan',1,NULL,'2026-11-09 22:43:05','2026-11-09 22:43:06','2026-11-09 22:43:06');
/*!40000 ALTER TABLE `kendaraan_dinas` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(5,'2026_10_11_000001_create_perangkat_daerah_table',2),(6,'2026_10_11_000002_create_pegawai_table',2),(7,'2026_10_11_000003_create_kendaraan_dinas_table',2),(8,'2026_11_10_043738_create_personal_access_tokens_table',3),(10,'2026_11_10_100000_make_unique_indexes_ignore_soft_deleted',4),(11,'2026_11_10_110000_add_user_id_to_pegawai_table',5),(12,'2026_11_10_120000_add_role_to_users_table',6),(13,'2026_11_10_130000_add_is_active_to_users_table',7);
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
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nip_aktif` varchar(30) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (if((`deleted_at` is null),`nip`,NULL)) STORED,
  `user_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawai_nip_aktif_unique` (`nip_aktif`),
  UNIQUE KEY `pegawai_user_id_unique` (`user_id`),
  CONSTRAINT `pegawai_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` (`id`, `nama`, `nip`, `jabatan`, `golongan`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES (3,'Budi Santoso','197805122003121001','Kepala Seksi Sarana','III/d','2026-11-09 21:51:22','2026-11-09 22:30:12',NULL,NULL),(4,'Siti Rahayu','198209152006042003','Staf Administrasi','III/a','2026-11-09 21:51:22','2026-11-09 21:51:22',NULL,NULL),(5,'Ahmad Fauzi','198603102010011004','Pengemudi','II/b','2026-11-09 21:51:22','2026-11-09 21:51:22',NULL,NULL),(6,'Dewi Lestari','199001202015032005','Bendahara','III/b','2026-11-09 21:51:22','2026-11-09 21:51:22',NULL,NULL),(7,'Rudi Hermawan','198111052008011006','Kepala Bidang Pengadaan','IV/a','2026-11-09 21:51:22','2026-11-09 21:51:22',NULL,NULL),(8,'Pegawai Uji Postman','19850101391','Kepala Seksi','III/a','2026-11-09 21:57:08','2026-11-09 21:57:09','2026-11-09 21:57:09',NULL),(9,'Pegawai Uji Postman','19850101690','Kepala Seksi','III/a','2026-11-09 22:08:02','2026-11-09 22:08:03','2026-11-09 22:08:03',NULL),(10,'Pegawai Uji Postman','19850101661','Kepala Seksi','III/a','2026-11-09 22:08:37','2026-11-09 22:08:38','2026-11-09 22:08:38',NULL),(11,'Pegawai Uji Postman','19850101974','Kepala Seksi','III/a','2026-11-09 22:18:52','2026-11-09 22:18:53','2026-11-09 22:18:53',NULL),(12,'Pegawai Uji Postman','19850101631','Kepala Seksi','III/a','2026-11-09 22:19:09','2026-11-09 22:19:11','2026-11-09 22:19:11',NULL),(13,'Pegawai Uji Postman','19850101989','Kepala Seksi','III/a','2026-11-09 22:21:32','2026-11-09 22:21:33','2026-11-09 22:21:33',NULL),(14,'Pegawai Akun Uji','198501011794288094','Staf','III/a','2026-11-09 22:21:34','2026-11-09 22:21:35','2026-11-09 22:21:35',NULL),(15,'Pegawai Uji Postman','1985010156','Kepala Seksi','III/a','2026-11-09 22:31:03','2026-11-09 22:31:04','2026-11-09 22:31:04',NULL),(16,'Pegawai Akun Uji','198501011794288665','Staf','III/a','2026-11-09 22:31:04','2026-11-09 22:31:06','2026-11-09 22:31:06',NULL),(17,'Pegawai Uji Postman','19850101471','Kepala Seksi','III/a','2026-11-09 22:42:57','2026-11-09 22:42:57','2026-11-09 22:42:57',NULL),(18,'Pegawai Akun Uji','198501011794289378','Staf','III/a','2026-11-09 22:42:58','2026-11-09 22:43:00','2026-11-09 22:43:00',NULL);
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perangkat_daerah`
--

DROP TABLE IF EXISTS `perangkat_daerah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perangkat_daerah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_pd` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `kode_pd_aktif` varchar(20) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (if((`deleted_at` is null),`kode_pd`,NULL)) STORED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perangkat_daerah_kode_pd_aktif_unique` (`kode_pd_aktif`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perangkat_daerah`
--

LOCK TABLES `perangkat_daerah` WRITE;
/*!40000 ALTER TABLE `perangkat_daerah` DISABLE KEYS */;
INSERT INTO `perangkat_daerah` (`id`, `kode_pd`, `nama`, `alamat`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'PD-001','Dinas Pendidikan',NULL,'2026-11-09 21:30:56','2026-11-09 22:28:30',NULL),(2,'PD-002','Dinas Kesehatan',NULL,'2026-11-09 21:30:56','2026-11-09 22:28:30',NULL),(3,'PD-003','Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)',NULL,'2026-11-09 21:30:56','2026-11-09 22:28:30',NULL),(4,'PD-004','Dinas Sosial',NULL,'2026-11-09 21:30:56','2026-11-09 22:28:30',NULL),(5,'PD-005','Dinas Perhubungan',NULL,'2026-11-09 21:30:56','2026-11-09 22:28:30',NULL),(6,'PD-006','Dinas Pertanian',NULL,'2026-11-09 21:30:56','2026-11-09 22:28:30',NULL),(27,'PD-641','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 21:57:06','2026-11-09 21:57:07','2026-11-09 21:57:07'),(34,'PD-765','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:08:00','2026-11-09 22:08:01','2026-11-09 22:08:01'),(35,'PD-103','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:08:35','2026-11-09 22:08:36','2026-11-09 22:08:36'),(36,'PD-4','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:18:49','2026-11-09 22:18:51','2026-11-09 22:18:51'),(37,'PD-947','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:19:07','2026-11-09 22:19:08','2026-11-09 22:19:08'),(38,'PD-804','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:21:30','2026-11-09 22:21:31','2026-11-09 22:21:31'),(45,'PD-327','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:31:01','2026-11-09 22:31:02','2026-11-09 22:31:02'),(46,'PD-833','Dinas Uji Postman (Revisi)','Jl. Contoh No. 1','2026-11-09 22:42:55','2026-11-09 22:42:56','2026-11-09 22:42:56');
/*!40000 ALTER TABLE `perangkat_daerah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'api','f660013b72b93b55e26a13824f4f4edce7234571b2cdef92f66a37fc2fea9eb1','[\"*\"]',NULL,'2026-11-10 21:44:30','2026-11-09 21:44:30','2026-11-09 21:44:30'),(4,'App\\Models\\User',1,'api','7a90cb611f1806c77edf0b8e52443fb66365090f38590dbe3aca1d9392273acc','[\"*\"]','2026-11-09 21:54:38','2026-11-10 21:54:37','2026-11-09 21:54:37','2026-11-09 21:54:38'),(6,'App\\Models\\User',1,'api','cb7f59b658150206f75110eacfe0df632c190cd990a41aa00fbc0b722044bea5','[\"*\"]',NULL,'2026-11-10 22:05:28','2026-11-09 22:05:28','2026-11-09 22:05:28'),(7,'App\\Models\\User',1,'api','9e77a9eeba12e85d4c4a7527eb99ef2ffe7c2685c659ed31239af85782aa3889','[\"*\"]','2026-11-09 22:07:28','2026-11-10 22:07:27','2026-11-09 22:07:27','2026-11-09 22:07:28'),(14,'App\\Models\\User',1,'api','91c30ff4c6b43fe5a6bba1c27601780f99d955537acf3a151ca3f8d034fe698e','[\"*\"]','2026-11-09 22:29:36','2026-11-10 22:29:35','2026-11-09 22:29:35','2026-11-09 22:29:36'),(15,'App\\Models\\User',8,'api','ea491a6ec5267529542603b97f0fa5c4035631134de17339663202b74aca67f3','[\"*\"]','2026-11-09 22:29:38','2026-11-10 22:29:36','2026-11-09 22:29:36','2026-11-09 22:29:38'),(16,'App\\Models\\User',8,'api','c292bff6a6cac88e4b9bb4432ce575c3957c228ff83ebe974c0417172392b268','[\"*\"]','2026-11-09 22:30:10','2026-11-10 22:30:10','2026-11-09 22:30:10','2026-11-09 22:30:10'),(17,'App\\Models\\User',1,'api','1743f6340eb809c007db01a0ad2dbb37ebbd58f77b45384e692b71a68e5b181d','[\"*\"]','2026-11-09 22:30:12','2026-11-10 22:30:11','2026-11-09 22:30:11','2026-11-09 22:30:12'),(19,'App\\Models\\User',8,'api','7b79ee5d798767e883dfbe9a017bb770e59cba9e4a02536e4001cbf0a974932c','[\"*\"]','2026-11-09 22:31:05','2026-11-10 22:31:05','2026-11-09 22:31:05','2026-11-09 22:31:05'),(20,'App\\Models\\User',1,'api','8d4af0a2e96977396537f00702a40091229571483d8eb50f1913b6330923d7d0','[\"*\"]','2026-11-09 22:42:22','2026-11-10 22:42:20','2026-11-09 22:42:20','2026-11-09 22:42:22'),(22,'App\\Models\\User',8,'api','f7d425c70dfce42136fa522aa10db2f86c7b22aa00f7bf505ef1338b7ec7dcfa','[\"*\"]','2026-11-09 22:42:24','2026-11-10 22:42:23','2026-11-09 22:42:23','2026-11-09 22:42:24'),(24,'App\\Models\\User',8,'api','54e1db3cbc2fbb67fbd503c6500f568c4617f82c005e2279f58c3a8203744fe5','[\"*\"]','2026-11-09 22:43:04','2026-11-10 22:42:58','2026-11-09 22:42:58','2026-11-09 22:43:04');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','admin',1,'2026-11-09 21:43:20','$2y$12$vyDpc1Py.3hEYZv/Wq2JfeI0dBVkYG//27.yPFsnzzW36cUVsnyAu','lVqAaOWgrb','2026-11-09 21:43:21','2026-11-09 22:28:29'),(8,'Operator Uji','operator@example.com','operator',1,NULL,'$2y$12$OHIHCGx6djYfIcLTltG/kugxbug0ayJQuQvRsJ7z8lkU.bgnXJmPe',NULL,'2026-11-09 22:28:30','2026-11-09 22:28:30'),(13,'Pengguna Postman (Revisi)','pengguna.344@example.com','operator',1,NULL,'$2y$12$bVfdudgjabyFSzRZGaLyRuUEP5U46zPbp4UvU8oe.ZjhUVhE14vSK',NULL,'2026-11-09 22:43:01','2026-11-09 22:43:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'db_kdo'
--

--
-- Dumping routines for database 'db_kdo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-10 12:43:34
