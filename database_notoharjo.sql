-- TiDB Cloud Compatible SQL Dump for web_notoharjo
SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- MariaDB dump 10.19  Distrib 10.11.16-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: web_notoharjo
-- ------------------------------------------------------
-- Server version	10.11.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda` (
  `id_agenda` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `nama_kegiatan` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(200) NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `penyelenggara` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_agenda`),
  KEY `agenda_id_user_foreign` (`id_user`),
  CONSTRAINT `agenda_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` VALUES
(1,1,'Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan','Pembahasan usulan prioritas pembangunan infrastruktur pertanian dan fasilitas umum tahun anggaran mendatang.','Balai Pertemuan Kelurahan Notoharjo','2026-11-24 09:00:00','2026-11-24 13:00:00','Lurah & BPK Kelurahan Notoharjo','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,1,'Posyandu Balita & Pemeriksaan Kesehatan Lansia Gratis','Layanan imunisasi anak, penimbangan balita, dan cek tensi/gula darah gratis untuk lansia di Bedeng 18 Polos.','Poskesdes Dusun III (Pasar Welit)','2026-11-29 08:30:00','2026-11-29 11:30:00','Kader PKK & Bidan Desa','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita` (
  `id_berita` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `isi_berita` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `views` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_berita`),
  UNIQUE KEY `berita_slug_unique` (`slug`),
  KEY `berita_id_user_foreign` (`id_user`),
  CONSTRAINT `berita_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` VALUES
(1,1,'Sejarah Singkat Kelurahan Notoharjo: Dari Kolonisasi 1937 Hingga Era Digital','sejarah-singkat-kelurahan-notoharjo','Mengenal perjalanan panjang berdirinya Kelurahan Notoharjo dari pembukaan hutan belantara bedeng 17 dan 18 hingga kemajuan saat ini.','<p>Kelurahan Notoharjo semula merupakan hutan belantara yang dibuka pada masa penjajahan Belanda melalui program kolonisasi (transmigrasi) pada tahun 1936-1937. Para penduduk awal didatangkan dari Jawa Tengah dan Jawa Timur yang ditempatkan sementara di Pringsewu sebelum diberangkatkan ke kawasan hutan yang kini menjadi Notoharjo.</p><p>Kawasan ini mulanya terbagi dalam tiga bedeng penampungan: Bedeng 17 Polos (Nambah Rejo), Bedeng 17A (Nunggal Rejo), dan Bedeng 18 Polos (Mengger Rejo/Pasar Welit) dengan luas wilayah mencapai 477,25 Ha serta lahan pertanian seluas 317,43 Ha. Kini di bawah kepemimpinan Kelurahan Notoharjo, transformasi digital dimulai untuk mempercepat pelayanan masyarakat.</p>','images/berita/berita-sejarah.jpg','published',120,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,1,'Peluncuran Website Resmi dan Sistem Informasi Administrasi Kelurahan Notoharjo','peluncuran-website-resmi-kelurahan-notoharjo','Pemerintah Kelurahan Notoharjo kini menyediakan layanan surat-menyurat online mandiri yang dapat diakses warga dari rumah.','<p>Untuk mengatasi antrean dan keterlambatan pengurusan surat fisik, Pemerintah Kelurahan Notoharjo resmi meluncurkan portal sistem informasi terpadu. Warga dapat mengajukan Surat Keterangan Usaha, Domisili, dan Pengantar SKCK secara online dan memantau status secara langsung tanpa harus menunggu lama di kantor desa.</p>','images/berita/berita-digital.jpg','published',95,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(3,1,'Optimalisasi Saluran Irigasi Teknis dan Pendampingan Kelompok Tani Notoharjo','optimalisasi-saluran-irigasi-teknis-kelompok-tani-notoharjo','Dinas Pertanian bersama Kelurahan Notoharjo menggelar peninjauan pintu air dan pembinaan gabungan kelompok tani guna mengantisipasi musim tanam.','<p>Guna menjamin ketersediaan pasokan air bagi ratusan hektar areal persawahan di Bedeng 17 dan 17A, Pemerintah Kelurahan Notoharjo bersama Gapoktan Subur Makmur melakukan peninjauan intensif di sepanjang jalur saluran irigasi sekunder.</p><p>Langkah ini dilakukan untuk memastikan debit air merata ke seluruh petak sawah petani Notoharjo demi mempertahankan status Trimurjo sebagai salah satu lumbung pangan utama Kabupaten Lampung Tengah.</p>','images/berita/berita-pertanian.jpg','published',84,'2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--


--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--


--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--


--
-- Table structure for table `galeri`
--

DROP TABLE IF EXISTS `galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `galeri` (
  `id_galeri` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `judul` varchar(200) NOT NULL,
  `file_media` varchar(255) NOT NULL,
  `jenis_media` enum('foto','video') NOT NULL DEFAULT 'foto',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_galeri`),
  KEY `galeri_id_user_foreign` (`id_user`),
  CONSTRAINT `galeri_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` VALUES
(1,1,'Kegiatan Gotong Royong Pembersihan Saluran Irigasi Persawahan Notoharjo','images/galeri/galeri-gotong-royong.jpg','foto','Partisipasi para petani dan aparat desa merawat saluran pengairan tanaman padi.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,1,'Suasana Pasar Tradisional Welit Menjelang Pagi','images/galeri/galeri-pasar-welit.jpg','foto','Aktivitas jual beli hasil bumi sayur mayur dan pangan di Pasar Welit.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(3,1,'Panen Raya Padi Petani Notoharjo di Hamparan Persawahan Bedeng 17','images/galeri/galeri-panen.jpg','foto','Musim panen padi hasil irigasi teknis oleh para petani Gapoktan Subur Makmur Notoharjo.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(4,1,'Penyerahan Akun Operator & Peluncuran Website Kelurahan Notoharjo','images/berita/berita-digital.jpg','foto','Pelaksanaan program pengabdian kepada masyarakat (PKM) Universitas Muhammadiyah Metro bersama jajaran aparat Kelurahan Notoharjo.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(5,1,'Pemeriksaan Kesehatan Berkala Posyandu Balita & Lansia Dusun II','images/galeri/galeri-posyandu.jpg','foto','Kegiatan rutin kader posyandu bersama tenaga medis puskesmas pembantu Trimurjo.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(6,1,'Rapat Koordinasi Aparatur Kelurahan & Musrenbang Notoharjo','images/galeri/galeri-musrenbang.jpg','foto','Musyawarah perencanaan pembangunan dan evaluasi program kerja aparat kelurahan Notoharjo.','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--


--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--


--
-- Table structure for table `kartu_keluarga`
--

DROP TABLE IF EXISTS `kartu_keluarga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kartu_keluarga` (
  `id_kartu_keluarga` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rt` bigint(20) unsigned NOT NULL,
  `nomor_kk` varchar(20) NOT NULL,
  `nama_kepala_keluarga` varchar(150) DEFAULT NULL,
  `alamat_lengkap` text NOT NULL,
  `kode_pos` varchar(10) NOT NULL DEFAULT '34172',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kartu_keluarga`),
  UNIQUE KEY `kartu_keluarga_nomor_kk_unique` (`nomor_kk`),
  KEY `kartu_keluarga_id_rt_foreign` (`id_rt`),
  CONSTRAINT `kartu_keluarga_id_rt_foreign` FOREIGN KEY (`id_rt`) REFERENCES `wilayah_rt` (`id_rt`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kartu_keluarga`
--

INSERT INTO `kartu_keluarga` VALUES
(1,1,'1802010101010001','Bambang Sungkowo','Jl. Veteran No. 12, RT 001 / RW 001, Dusun 17 Polos, Kelurahan Notoharjo','34172','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,3,'1802050304120009','HERI KURNIAWAN JATI','Dusun I, RT 003 / RW 002, Kelurahan Notoharjo, Kec. Trimurjo','34172','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(3,2,'1802010303030003','Suparno Hadi','Jl. Veteran No. 28, RT 002 / RW 001, Dusun 17 Polos, Kelurahan Notoharjo','34172','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(4,3,'1802010404040004','Hendra Kusuma, S.T.','Jl. Irigasi Bedeng 17A No. 15, RT 003 / RW 002, Kelurahan Notoharjo','34172','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(5,4,'1802010505050005','Slamet Riyadi','Kawasan Pasar Welit No. 04, RT 004 / RW 002, Bedeng 18, Kelurahan Notoharjo','34172','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(6,1,'1802010606060006','Karyo Utomo','Jl. Perintis Kemerdekaan No. 02, RT 001 / RW 001, Bedeng 17 Polos, Kelurahan Notoharjo','34172','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `kode_surat`
--

DROP TABLE IF EXISTS `kode_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kode_surat` (
  `id_kode_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_klasifikasi` varchar(50) NOT NULL,
  `nama_surat` varchar(150) NOT NULL,
  `template_view` varchar(100) DEFAULT NULL,
  `masa_berlaku_hari` int(11) NOT NULL DEFAULT 30,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kode_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_surat`
--

INSERT INTO `kode_surat` VALUES
(1,'503','Surat Keterangan Usaha (SKU)','surat.sku',30,'Surat keterangan kepemilikan dan legalitas tempat usaha untuk keperluan pinjaman bank/KUR atau legalitas perdagangan.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,'470','Surat Keterangan Domisili','surat.domisili',60,'Surat bukti tempat tinggal sah warga di lingkungan Kelurahan Notoharjo.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(3,'331','Surat Pengantar SKCK','surat.skck',30,'Pengantar pengurusan Surat Keterangan Catatan Kepolisian ke Polsek Trimurjo / Polres Lampung Tengah.','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(4,'401','Surat Keterangan Tidak Mampu (SKTM)','surat.sktm',90,'Surat permohonan keringanan biaya pendidikan/sekolah, rumah sakit/BPJS PBI, dan bantuan sosial.','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `lampiran_permohonan`
--

DROP TABLE IF EXISTS `lampiran_permohonan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lampiran_permohonan` (
  `id_lampiran` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_permohonan_surat` bigint(20) unsigned NOT NULL,
  `id_syarat_surat` bigint(20) unsigned NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status_validasi` enum('menunggu','valid','tidak_valid') NOT NULL DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_lampiran`),
  KEY `lampiran_permohonan_id_permohonan_surat_foreign` (`id_permohonan_surat`),
  KEY `lampiran_permohonan_id_syarat_surat_foreign` (`id_syarat_surat`),
  CONSTRAINT `lampiran_permohonan_id_permohonan_surat_foreign` FOREIGN KEY (`id_permohonan_surat`) REFERENCES `permohonan_surat` (`id_permohonan_surat`) ON DELETE CASCADE,
  CONSTRAINT `lampiran_permohonan_id_syarat_surat_foreign` FOREIGN KEY (`id_syarat_surat`) REFERENCES `syarat_surat` (`id_syarat_surat`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lampiran_permohonan`
--


--
-- Table structure for table `layanan_pengaduan`
--

DROP TABLE IF EXISTS `layanan_pengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanan_pengaduan` (
  `id_pengaduan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned NOT NULL,
  `id_dusun` bigint(20) unsigned DEFAULT NULL,
  `judul_laporan` varchar(200) NOT NULL,
  `kategori` enum('Infrastruktur & Jalan','Pertanian & Pengairan','Bantuan Sosial','Pelayanan Kelurahan','Keamanan & Ketertiban','Lainnya') NOT NULL DEFAULT 'Infrastruktur & Jalan',
  `isi_laporan` text NOT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status` enum('diajukan','ditinjau','dalam_tindakan','selesai','ditolak') NOT NULL DEFAULT 'diajukan',
  `tanggapan_petugas` text DEFAULT NULL,
  `tanggal_tanggapan` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengaduan`),
  KEY `layanan_pengaduan_id_user_foreign` (`id_user`),
  KEY `layanan_pengaduan_id_dusun_foreign` (`id_dusun`),
  CONSTRAINT `layanan_pengaduan_id_dusun_foreign` FOREIGN KEY (`id_dusun`) REFERENCES `wilayah_dusun` (`id_dusun`) ON DELETE SET NULL,
  CONSTRAINT `layanan_pengaduan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanan_pengaduan`
--


--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` VALUES
(1,'0001_01_01_000001_create_cache_table',1),
(2,'0001_01_01_000002_create_jobs_table',1),
(3,'2026_11_05_000001_create_wilayah_and_referensi_tables',1),
(4,'2026_11_05_000002_create_kependudukan_tables',1),
(5,'2026_11_05_000003_create_users_and_auth_tables',1),
(6,'2026_11_05_000004_create_mutasi_penduduk_table',1),
(7,'2026_11_05_000005_create_persuratan_master_tables',1),
(8,'2026_11_05_000006_create_permohonan_surat_and_tracking_tables',1),
(9,'2026_11_05_000007_create_publikasi_potensi_anggaran_tables',1),
(10,'2026_11_05_000008_create_pengaduan_and_notifikasi_tables',1);

--
-- Table structure for table `mutasi_penduduk`
--

DROP TABLE IF EXISTS `mutasi_penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mutasi_penduduk` (
  `id_mutasi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_penduduk` bigint(20) unsigned NOT NULL,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `jenis_mutasi` enum('Kelahiran','Kematian','Pindah_Masuk','Pindah_Keluar') NOT NULL,
  `tanggal_kejadian` date NOT NULL,
  `nomor_surat_keterangan` varchar(100) DEFAULT NULL,
  `alasan_tujuan` text DEFAULT NULL,
  `file_berkas_bukti` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_mutasi`),
  KEY `mutasi_penduduk_id_penduduk_foreign` (`id_penduduk`),
  KEY `mutasi_penduduk_id_user_foreign` (`id_user`),
  CONSTRAINT `mutasi_penduduk_id_penduduk_foreign` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`) ON DELETE CASCADE,
  CONSTRAINT `mutasi_penduduk_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi_penduduk`
--


--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `kanal` enum('web','whatsapp','email') NOT NULL DEFAULT 'web',
  `tautan` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_notifikasi`),
  KEY `notifikasi_id_user_foreign` (`id_user`),
  CONSTRAINT `notifikasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--


--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--


--
-- Table structure for table `pekerjaan`
--

DROP TABLE IF EXISTS `pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pekerjaan` (
  `id_pekerjaan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pekerjaan` varchar(100) NOT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pekerjaan`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` VALUES
(1,'Petani / Pekebun',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,'Pedagang',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(3,'Wiraswasta',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(4,'Pegawai Negeri Sipil (PNS)',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(5,'Guru / Dosen',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(6,'Karyawan Swasta',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(7,'Buruh Harian Lepas',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(8,'Ibu Rumah Tangga',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(9,'Pelajar / Mahasiswa',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(10,'Belum / Tidak Bekerja',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(11,'Tenaga Medis / Bidan',NULL,0,'2026-11-18 19:36:59','2026-11-18 19:36:59');

--
-- Table structure for table `pendidikan`
--

DROP TABLE IF EXISTS `pendidikan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendidikan` (
  `id_pendidikan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pendidikan` varchar(100) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pendidikan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` VALUES
(1,'Tidak / Belum Sekolah',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,'SD / Sederajat',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(3,'SMP / Sederajat',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(4,'SMA / Sederajat',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(5,'Diploma (D1 - D3)',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(6,'Sarjana (S1)',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(7,'Magister (S2)',0,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(8,'Doktor (S3)',0,'2026-11-18 19:36:59','2026-11-18 19:36:59');

--
-- Table structure for table `penduduk`
--

DROP TABLE IF EXISTS `penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `penduduk` (
  `id_penduduk` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kartu_keluarga` bigint(20) unsigned NOT NULL,
  `id_pekerjaan` bigint(20) unsigned DEFAULT NULL,
  `id_pendidikan` bigint(20) unsigned DEFAULT NULL,
  `nik` varchar(20) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(30) NOT NULL DEFAULT 'Islam',
  `status_kawin` varchar(30) NOT NULL DEFAULT 'Belum Menikah',
  `status_hubungan_keluarga` varchar(50) NOT NULL DEFAULT 'Kepala Keluarga',
  `kewarganegaraan` varchar(30) NOT NULL DEFAULT 'WNI',
  `nama_ayah` varchar(150) DEFAULT NULL,
  `nama_ibu` varchar(150) DEFAULT NULL,
  `no_telepon` varchar(25) DEFAULT NULL,
  `status_keberadaan` enum('Aktif','Meninggal','Pindah') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penduduk`),
  UNIQUE KEY `penduduk_nik_unique` (`nik`),
  KEY `penduduk_id_kartu_keluarga_foreign` (`id_kartu_keluarga`),
  KEY `penduduk_id_pekerjaan_foreign` (`id_pekerjaan`),
  KEY `penduduk_id_pendidikan_foreign` (`id_pendidikan`),
  CONSTRAINT `penduduk_id_kartu_keluarga_foreign` FOREIGN KEY (`id_kartu_keluarga`) REFERENCES `kartu_keluarga` (`id_kartu_keluarga`) ON DELETE CASCADE,
  CONSTRAINT `penduduk_id_pekerjaan_foreign` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE SET NULL,
  CONSTRAINT `penduduk_id_pendidikan_foreign` FOREIGN KEY (`id_pendidikan`) REFERENCES `pendidikan` (`id_pendidikan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penduduk`
--

INSERT INTO `penduduk` VALUES
(1,1,4,6,'1802011005720001','Bambang Sungkowo','L','Lampung Tengah','1972-05-10','Islam','Menikah','Kepala Keluarga','WNI','Karto Suwiryo','Siti Aminah','081278901234','Aktif','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,2,3,5,'1802052601720003','Heri Kurniawan Jati','L','Metro','1972-01-26','Islam','Menikah','Kepala Keluarga','WNI','Sukiyatno','Daliyah','082188990010','Aktif','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(3,2,11,5,'1802055606740004','Henny Kurniawati','P','Metro','1974-06-16','Islam','Menikah','Istri','WNI','T Ismail','Sumarni','082188990011','Aktif','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(4,2,9,4,'1802052209000005','Billa Fajar Kurnia','L','Notoharjo','2000-09-22','Islam','Belum Menikah','Anak','WNI','Heri Kurniawan Jati','Henny Kurniawati','082188990012','Aktif','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(5,2,9,4,'1802050207060006','Cetta Nafis Kurnia','L','Untoro','2006-07-02','Islam','Belum Menikah','Anak','WNI','Heri Kurniawan Jati','Henny Kurniawati','082188990013','Aktif','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(6,2,10,2,'1802050412130001','Nala Nathan Kurnia','L','Metro','2013-12-04','Islam','Belum Menikah','Anak','WNI','Heri Kurniawan Jati','Henny Kurniawati','082188990014','Aktif','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(7,3,1,4,'1802011204680005','Suparno Hadi','L','Lampung Tengah','1968-04-12','Islam','Menikah','Kepala Keluarga','WNI','Kromo Rejo','Sariyem','081369112233','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(8,3,8,3,'1802012509720006','Sri Wahyuni','P','Trimurjo','1972-09-25','Islam','Menikah','Istri','WNI','Sastro Wiyono','Paini','081369112234','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(9,3,9,4,'1802011406020007','Bayu Setiawan','L','Notoharjo','2002-06-14','Islam','Belum Menikah','Anak','WNI','Suparno Hadi','Sri Wahyuni','081369112235','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(10,4,3,6,'1802011802800008','Hendra Kusuma, S.T.','L','Metro','1980-02-18','Islam','Menikah','Kepala Keluarga','WNI','Mulyono','Sulastri','085273114455','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(11,4,5,6,'1802010911830009','Dewi Lestari, S.Pd.','P','Trimurjo','1983-11-09','Islam','Menikah','Istri','WNI','Suwarto','Warsiti','085273114456','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(12,4,9,3,'1802012108100010','Anisa Rahmadani','P','Notoharjo','2010-08-21','Islam','Belum Menikah','Anak','WNI','Hendra Kusuma','Dewi Lestari','085273114457','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(13,5,2,4,'1802010305750011','Slamet Riyadi','L','Lampung Tengah','1975-05-03','Islam','Menikah','Kepala Keluarga','WNI','Marto Sudarmo','Tukiyem','082281997788','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(14,5,2,3,'1802011707790012','Partini','P','Notoharjo','1979-07-17','Islam','Menikah','Istri','WNI','Djoyo Sukarto','Supatmi','082281997789','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(15,5,6,4,'1802012912000013','Dimas Prasetyo','L','Notoharjo','2000-12-29','Islam','Belum Menikah','Anak','WNI','Slamet Riyadi','Partini','082281997790','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(16,6,1,2,'1802010107500014','Karyo Utomo','L','Kebumen (Jawa Tengah)','1950-07-01','Islam','Duda / Cerai Mati','Kepala Keluarga','WNI','Harjo Pawiro','Rubiyem','081299887766','Aktif','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `permohonan_surat`
--

DROP TABLE IF EXISTS `permohonan_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permohonan_surat` (
  `id_permohonan_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned NOT NULL,
  `id_penduduk` bigint(20) unsigned NOT NULL,
  `id_kode_surat` bigint(20) unsigned NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `keperluan` text NOT NULL,
  `keterangan_tambahan` text DEFAULT NULL,
  `status` enum('menunggu_verifikasi','diverifikasi_kasi','diparaf_sekretaris','disetujui_lurah','selesai','ditolak') NOT NULL DEFAULT 'menunggu_verifikasi',
  `token_qr` varchar(100) DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `tanggal_disahkan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_permohonan_surat`),
  UNIQUE KEY `permohonan_surat_token_qr_unique` (`token_qr`),
  KEY `permohonan_surat_id_user_foreign` (`id_user`),
  KEY `permohonan_surat_id_penduduk_foreign` (`id_penduduk`),
  KEY `permohonan_surat_id_kode_surat_foreign` (`id_kode_surat`),
  CONSTRAINT `permohonan_surat_id_kode_surat_foreign` FOREIGN KEY (`id_kode_surat`) REFERENCES `kode_surat` (`id_kode_surat`) ON DELETE CASCADE,
  CONSTRAINT `permohonan_surat_id_penduduk_foreign` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`) ON DELETE CASCADE,
  CONSTRAINT `permohonan_surat_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permohonan_surat`
--


--
-- Table structure for table `potensi_kelurahan`
--

DROP TABLE IF EXISTS `potensi_kelurahan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `potensi_kelurahan` (
  `id_potensi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_dusun` bigint(20) unsigned DEFAULT NULL,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `nama_potensi` varchar(150) NOT NULL,
  `kategori` enum('Pertanian','Pasar Tradisional / Perdagangan','UMKM & Industri Rumahan','Peternakan','Kuliner & Jasa') NOT NULL DEFAULT 'Pertanian',
  `pemilik` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kontak` varchar(30) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_potensi`),
  KEY `potensi_kelurahan_id_dusun_foreign` (`id_dusun`),
  KEY `potensi_kelurahan_id_user_foreign` (`id_user`),
  CONSTRAINT `potensi_kelurahan_id_dusun_foreign` FOREIGN KEY (`id_dusun`) REFERENCES `wilayah_dusun` (`id_dusun`) ON DELETE SET NULL,
  CONSTRAINT `potensi_kelurahan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `potensi_kelurahan`
--

INSERT INTO `potensi_kelurahan` VALUES
(1,3,1,'Pasar Tradisional Welit (Desa 18 Polos)','Pasar Tradisional / Perdagangan','Pemerintah Kelurahan & Paguyuban Pedagang','Pasar bersejarah yang berdiri sejak awal pembukaan lahan kolonisasi 1937, dinamai dari atap ilalang (Welit). Menjadi denyut nadi ekonomi perdagangan dan sentra sayur mayur se-Kecamatan Trimurjo.','081234567003',NULL,'Bedeng 18 Polos (Mengger Rejo), Kelurahan Notoharjo','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,2,1,'Sentra Lumbung Padi & Jagung Trimurjo','Pertanian','Gapoktan Subur Makmur Notoharjo','Dengan lebih dari 60% warga berprofesi sebagai petani dan luas lahan persawahan irigasi teknis mencapai ratusan hektar, Notoharjo merupakan produsen pangan utama di Trimurjo Lampung Tengah.','082188990011',NULL,'Persawahan Bedeng 17A (Nunggal Rejo), Notoharjo','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(3,1,1,'UMKM Keripik Pisang & Olahan Singkong Notoharjo','UMKM & Industri Rumahan','Kelompok Wanita Tani (KWT) Melati','Produksi aneka camilan khas olahan hasil bumi Notoharjo dengan cita rasa renyah, telah dipasarkan ke Metro, Bandar Lampung, hingga luar pulau.','081399887766',NULL,'Jl. Kenanga No. 8, Dusun I (17 Polos), Notoharjo','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `riwayat_status_surat`
--

DROP TABLE IF EXISTS `riwayat_status_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `riwayat_status_surat` (
  `id_riwayat_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_permohonan_surat` bigint(20) unsigned NOT NULL,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `tahapan` varchar(100) NOT NULL,
  `status_tahap` varchar(50) NOT NULL,
  `catatan_petugas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_riwayat_surat`),
  KEY `riwayat_status_surat_id_permohonan_surat_foreign` (`id_permohonan_surat`),
  KEY `riwayat_status_surat_id_user_foreign` (`id_user`),
  CONSTRAINT `riwayat_status_surat_id_permohonan_surat_foreign` FOREIGN KEY (`id_permohonan_surat`) REFERENCES `permohonan_surat` (`id_permohonan_surat`) ON DELETE CASCADE,
  CONSTRAINT `riwayat_status_surat_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_status_surat`
--


--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` VALUES
('URmfd43H1m5hEIWM4PkS9zbeiG1ywDh9GX84BZ7r',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36 Edg/157.0.0.0','eyJfdG9rZW4iOiJ5TWtkMjhNYTE2R1A3SjRnRGFGNENYazlSckxWUXN5cGc0d3JkNWRPIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjcsInBhc3N3b3JkX2hhc2hfd2ViIjoiNDJkNjliMWEyOWZmYWNhY2M1M2UyMGIwMGY0ZmI2MjRiMmEwYjBiMzdkOWI5ZjJkYWE2YTEyMmEyZTNiZGIwYSJ9',1795057700);

--
-- Table structure for table `surat_masuk`
--

DROP TABLE IF EXISTS `surat_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_masuk` (
  `id_surat_masuk` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `nomor_surat` varchar(100) NOT NULL,
  `nomor_agenda_masuk` varchar(100) DEFAULT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_diterima` date NOT NULL,
  `pengirim` varchar(150) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `file_arsip` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_surat_masuk`),
  KEY `surat_masuk_id_user_foreign` (`id_user`),
  CONSTRAINT `surat_masuk_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_masuk`
--


--
-- Table structure for table `syarat_surat`
--

DROP TABLE IF EXISTS `syarat_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `syarat_surat` (
  `id_syarat_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kode_surat` bigint(20) unsigned NOT NULL,
  `nama_syarat` varchar(150) NOT NULL,
  `is_wajib` tinyint(1) NOT NULL DEFAULT 1,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_syarat_surat`),
  KEY `syarat_surat_id_kode_surat_foreign` (`id_kode_surat`),
  CONSTRAINT `syarat_surat_id_kode_surat_foreign` FOREIGN KEY (`id_kode_surat`) REFERENCES `kode_surat` (`id_kode_surat`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `syarat_surat`
--

INSERT INTO `syarat_surat` VALUES
(1,1,'Scan / Foto Kartu Tanda Penduduk (KTP)',1,'Format JPG/PNG/PDF maks 2MB','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,1,'Scan / Foto Kartu Keluarga (KK)',1,'Format JPG/PNG/PDF maks 2MB','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(3,1,'Foto Tempat / Kegiatan Usaha',1,'Foto fisik kios / warung / lahan pertanian','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(4,2,'Scan / Foto KTP',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(5,2,'Scan / Foto Kartu Keluarga',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(6,2,'Surat Pengantar RT / Kadus Setempat',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(7,3,'Scan / Foto KTP & KK',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(8,3,'Surat Pengantar RT Setempat',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(9,4,'Scan KTP & Kartu Keluarga',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02'),
(10,4,'Surat Pernyataan Tidak Mampu dari RT',1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `transparansi_anggaran`
--

DROP TABLE IF EXISTS `transparansi_anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transparansi_anggaran` (
  `id_anggaran` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `tahun_anggaran` year(4) NOT NULL,
  `jenis` enum('Pendapatan','Belanja','Pembiayaan') NOT NULL,
  `bidang` varchar(150) NOT NULL,
  `uraian` varchar(255) NOT NULL,
  `target_anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `realisasi_anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_anggaran`),
  KEY `transparansi_anggaran_id_user_foreign` (`id_user`),
  CONSTRAINT `transparansi_anggaran_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transparansi_anggaran`
--

INSERT INTO `transparansi_anggaran` VALUES
(1,1,2026,'Pendapatan','Dana Alokasi Umum & APBD Kabupaten','Pagu Anggaran Dana Kelurahan Notoharjo TA 2026',850000000.00,850000000.00,'Pencairan 100% dari APBD Kabupaten Lampung Tengah','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(2,1,2026,'Belanja','Pelaksanaan Pembangunan Kelurahan','Pembangunan Rabat Beton Jalan Usaha Tani Dusun II & III',380000000.00,378500000.00,'Selesai pengerjaan sepanjang 1.200 meter','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(3,1,2026,'Belanja','Penyelenggaraan Pemerintahan','Digitalisasi Pelayanan Surat & Pengadaan Komputer Balai Desa',125000000.00,124200000.00,'Website pelayanan administrasi dan sistem informasi kelurahan','2026-11-18 19:37:02','2026-11-18 19:37:02'),
(4,1,2026,'Belanja','Pembinaan & Pemberdayaan Masyarakat','Program Posyandu Lansia, Bantuan Pangan Stunting & Pelatihan Gapoktan',195000000.00,189000000.00,'Kegiatan rutin bulanan di 3 dusun','2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_penduduk` bigint(20) unsigned DEFAULT NULL,
  `id_dusun` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `no_hp` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','lurah','sekretaris','kasi_pelayanan','kasi_pemerintahan','kasi_kesra','kaur_keuangan','kaur_umum','kadus','warga') NOT NULL DEFAULT 'warga',
  `jabatan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_unique` (`nik`),
  KEY `users_id_penduduk_foreign` (`id_penduduk`),
  KEY `users_id_dusun_foreign` (`id_dusun`),
  CONSTRAINT `users_id_dusun_foreign` FOREIGN KEY (`id_dusun`) REFERENCES `wilayah_dusun` (`id_dusun`) ON DELETE SET NULL,
  CONSTRAINT `users_id_penduduk_foreign` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES
(1,NULL,NULL,'Administrator Notoharjo','admin@notoharjo.desa.id',NULL,'081112223344','$2y$12$S0oirG0M/C9lGXfqr2U0A.x/iWq.k1qmcfu9KeWCrjarPLpou/.FK','admin','Pranata Komputer / IT Support',NULL,1,NULL,'2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,1,1,'Bambang Sungkowo','lurah@notoharjo.desa.id','1802011005720001','081278901234','$2y$12$i7qc6Iu5n3VmzVa7W7AigO9pMciIzNj.A1bfXhqCQlvk8Re9LHmCq','lurah','Kepala Kelurahan (Lurah)',NULL,1,NULL,'2026-11-18 19:37:00','2026-11-18 19:37:00'),
(3,NULL,NULL,'Muhammad Mahfud, S.Pd.I','sekretaris@notoharjo.desa.id',NULL,'081278901235','$2y$12$.Dy0T3Lt8B33.//W84MHK.mlASzX7RGGJVAHnkx26e22WdpQUBiWK','sekretaris','Sekretaris Kelurahan',NULL,1,NULL,'2026-11-18 19:37:00','2026-11-18 19:37:00'),
(4,NULL,NULL,'Karni Hanani, S.E','pelayanan@notoharjo.desa.id',NULL,'081278901236','$2y$12$3pF///ScxEy0C3iS5H1lNuiJldAtHgrYMxgG7KgW1iNUlEDSagANO','kasi_pelayanan','Kepala Seksi Pelayanan',NULL,1,NULL,'2026-11-18 19:37:00','2026-11-18 19:37:00'),
(5,NULL,NULL,'Suparmin, S.E','pemerintahan@notoharjo.desa.id',NULL,'081278901237','$2y$12$YRzQ9uuxlvi12TPsnDkH5.ejwzuDtSpiV2FIBrvcZxPOmV15JB5dm','kasi_pemerintahan','Kepala Seksi Pemerintahan',NULL,1,NULL,'2026-11-18 19:37:01','2026-11-18 19:37:01'),
(6,NULL,3,'Purnomo (Kadus III)','kadus3@notoharjo.desa.id',NULL,'081234567003','$2y$12$G8IG.fSH0IpQ8Hx7Bt.N5.bljIvVKusK6Ye3q5nd.0z9IIGcLf/aW','kadus','Kepala Dusun 18 Polos',NULL,1,NULL,'2026-11-18 19:37:01','2026-11-18 19:37:01'),
(7,5,1,'Cetta Nafis Kurnia','cetta@gmail.com','1802050207060006','082188990013','$2y$12$mnUN4owlo0WMMgO7iTBX/OOmWx39XHezzzzt2P4ztWnv.PpZppKoe','warga',NULL,NULL,1,NULL,'2026-11-18 19:37:02','2026-11-18 19:37:02');

--
-- Table structure for table `wilayah_dusun`
--

DROP TABLE IF EXISTS `wilayah_dusun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wilayah_dusun` (
  `id_dusun` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_dusun` varchar(100) NOT NULL,
  `nama_kadus` varchar(150) DEFAULT NULL,
  `kontak_kadus` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dusun`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wilayah_dusun`
--

INSERT INTO `wilayah_dusun` VALUES
(1,'Dusun I - Bedeng 17 Polos (Nambah Rejo)','Tafsirudin','081234567001','Pusat pemerintahan kelurahan Notoharjo dan kantor balai desa.','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,'Dusun II - Bedeng 17A (Nunggal Rejo)','Dwi Jo Wahono','081234567002','Sentra pertanian pangan dan persawahan produktif.','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(3,'Dusun III - Bedeng 18 Polos (Mengger Rejo / Pasar Welit)','Purnomo','081234567003','Pusat perdagangan masyarakat dan lokasi Pasar Tradisional Welit.','2026-11-18 19:36:59','2026-11-18 19:36:59');

--
-- Table structure for table `wilayah_rt`
--

DROP TABLE IF EXISTS `wilayah_rt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wilayah_rt` (
  `id_rt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_dusun` bigint(20) unsigned NOT NULL,
  `nomor_rt` varchar(10) NOT NULL,
  `nomor_rw` varchar(10) NOT NULL,
  `nama_ketua_rt` varchar(150) DEFAULT NULL,
  `kontak_rt` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rt`),
  KEY `wilayah_rt_id_dusun_foreign` (`id_dusun`),
  CONSTRAINT `wilayah_rt_id_dusun_foreign` FOREIGN KEY (`id_dusun`) REFERENCES `wilayah_dusun` (`id_dusun`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wilayah_rt`
--

INSERT INTO `wilayah_rt` VALUES
(1,1,'001','001','Slamet Riyadi','085234567101','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(2,1,'002','001','Sugeng Prayitno','085234567102','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(3,1,'003','002','Budi Santoso','085234567103','2026-11-18 19:36:59','2026-11-18 19:36:59'),
(4,2,'004','002','Wahyudi','085234567104','2026-11-18 19:36:59','2026-11-18 19:36:59');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-19 10:48:07

SET FOREIGN_KEY_CHECKS = 1;
