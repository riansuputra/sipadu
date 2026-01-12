/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.43 : Database - sipadu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `sipadu`;

/*Table structure for table `arsip` */

DROP TABLE IF EXISTS `arsip`;

CREATE TABLE `arsip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_arsip` varchar(50) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `pokja_id` int(11) NOT NULL,
  `dibuat_oleh` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_arsip` (`kode_arsip`),
  KEY `kategori_id` (`kategori_id`),
  KEY `pokja_id` (`pokja_id`),
  KEY `dibuat_oleh` (`dibuat_oleh`),
  CONSTRAINT `arsip_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `arsip_kategori` (`id`),
  CONSTRAINT `arsip_ibfk_2` FOREIGN KEY (`pokja_id`) REFERENCES `pokja` (`id`),
  CONSTRAINT `arsip_ibfk_3` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `arsip_file` */

DROP TABLE IF EXISTS `arsip_file`;

CREATE TABLE `arsip_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arsip_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `arsip_id` (`arsip_id`),
  CONSTRAINT `arsip_file_ibfk_1` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `arsip_kategori` */

DROP TABLE IF EXISTS `arsip_kategori`;

CREATE TABLE `arsip_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  `is_global` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dip` */

DROP TABLE IF EXISTS `dip`;

CREATE TABLE `dip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_informasi` varchar(200) NOT NULL,
  `ringkasan` text,
  `unit_penguasaan` varchar(200) NOT NULL,
  `penanggung_jawab` varchar(150) DEFAULT NULL,
  `jenis_informasi` enum('BERKALA','SERTA MERTA','SETIAP SAAT','DIKECUALIKAN') NOT NULL,
  `bentuk_informasi` enum('HARDCOPY','SOFTCOPY','HARDCOPY+SOFTCOPY') NOT NULL,
  `tanggal_pembuatan` date DEFAULT NOT NULL,
  `tempat_pembuatan` varchar(250) NOT NULL,
  `retensi_arsip` varchar(250) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dibuat_oleh` (`dibuat_oleh`),
  CONSTRAINT `dip_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dip_file` */

DROP TABLE IF EXISTS `dip_file`;

CREATE TABLE `dip_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dip_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dip_id` (`dip_id`),
  CONSTRAINT `dip_file_ibfk_1` FOREIGN KEY (`dip_id`) REFERENCES `dip` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `modul` */

DROP TABLE IF EXISTS `modul`;

CREATE TABLE `modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_global` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `modul_pokja` */

DROP TABLE IF EXISTS `modul_pokja`;

CREATE TABLE `modul_pokja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul_id` int(11) NOT NULL,
  `pokja_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modul_id` (`modul_id`),
  KEY `pokja_id` (`pokja_id`),
  CONSTRAINT `modul_pokja_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`id`),
  CONSTRAINT `modul_pokja_ibfk_2` FOREIGN KEY (`pokja_id`) REFERENCES `pokja` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `modul_role` */

DROP TABLE IF EXISTS `modul_role`;

CREATE TABLE `modul_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `modul_id` (`modul_id`),
  CONSTRAINT `modul_role_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`id`),
  CONSTRAINT `modul_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_global` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(30) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `status_pegawai` enum('ASN','NON ASN','HONORER') DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `unit_kerja` varchar(100) DEFAULT NULL,
  `pokja_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`),
  KEY `pokja_id` (`pokja_id`),
  CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`pokja_id`) REFERENCES `pokja` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Table structure for table `pegawai_file` */

DROP TABLE IF EXISTS `pegawai_file`;

CREATE TABLE `pegawai_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pegawai_id` int(11) NOT NULL,
  `jenis_dokumen` varchar(50) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `is_global` tinyint(1) DEFAULT '1',
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pegawai_id` (`pegawai_id`),
  CONSTRAINT `pegawai_file_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `peraturan` */

DROP TABLE IF EXISTS `peraturan`;

CREATE TABLE `peraturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(255) NOT NULL,
  `nomor` VARCHAR(100) DEFAULT NULL,
  `teu` VARCHAR(100) DEFAULT NULL, 
  `jenis_id` int(11) NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `tempat_penetapan` VARCHAR(150) DEFAULT NULL,
  `tanggal_penetapan` DATE DEFAULT NULL,
  `tanggal_pengundangan` DATE DEFAULT NULL,
  `sumber` VARCHAR(255) DEFAULT NULL,
  `bahasa` VARCHAR(50) DEFAULT 'Indonesia',
  `status` ENUM('BERLAKU','DICABUT','DIUBAH') DEFAULT 'BERLAKU',
  `lokasi` VARCHAR(150) DEFAULT NULL,
  `bidang_hukum` VARCHAR(150) DEFAULT NULL,
  `subjek` TEXT DEFAULT NULL,
  `pemrakarsa` VARCHAR(150) DEFAULT NULL,
  `kata_kunci` VARCHAR(255) DEFAULT NULL,
  `penandatangan` VARCHAR(150) DEFAULT NULL,
  `jumlah_unduhan` INT DEFAULT 0,
  `jumlah_dilihat` INT DEFAULT 0,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tahun` (`tahun_terbit`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `peraturan_file` */

DROP TABLE IF EXISTS `peraturan_file`;

CREATE TABLE `peraturan_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `peraturan_id` int(11) NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `peraturan_id` (`peraturan_id`),
  CONSTRAINT `peraturan_file_ibfk_1` FOREIGN KEY (`peraturan_id`) REFERENCES `peraturan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pokja` */

DROP TABLE IF EXISTS `pokja`;

CREATE TABLE `pokja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_grup` enum('Tim','Unit') NOT NULL,
  `nama_grup` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `publikasi` */

DROP TABLE IF EXISTS `publikasi`;

CREATE TABLE `publikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text,
  `tanggal_kegiatan` date DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `pokja_id` int(11) NOT NULL,
  `is_published` tinyint(1) DEFAULT '1',
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `publikasi_file` */

DROP TABLE IF EXISTS `publikasi_file`;

CREATE TABLE `publikasi_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publikasi_id` int(11) NOT NULL,
  `tipe` enum('FOTO','VIDEO','DOKUMEN') NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `publikasi_id` (`publikasi_id`),
  CONSTRAINT `publikasi_file_ibfk_1` FOREIGN KEY (`publikasi_id`) REFERENCES `publikasi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_role` varchar(20) NOT NULL,
  `nama_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_role` (`kode_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `sekolah` */

DROP TABLE IF EXISTS `sekolah`;

CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `npsn` varchar(20) NOT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `bentuk_pendidikan` varchar(50) DEFAULT NULL,
  `status_sekolah` enum('NEGERI','SWASTA') DEFAULT 'NEGERI',
  `akreditasi` varchar(5) DEFAULT NULL,
  `alamat_jalan` varchar(255) DEFAULT NULL,
  `nama_dusun` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kabupaten` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `nama_yayasan` varchar(150) DEFAULT NULL,
  `lintang` decimal(10,6) DEFAULT NULL,
  `bujur` decimal(10,6) DEFAULT NULL,
  `nama_kepala_sekolah` varchar(150) DEFAULT NULL,
  `no_telp_kepala_sekolah` varchar(20) DEFAULT NULL,
  `nama_operator_sekolah` varchar(150) DEFAULT NULL,
  `no_telp_operator_sekolah` varchar(20) DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `npsn` (`npsn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `pokja_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`),
  KEY `pokja_id` (`pokja_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`pokja_id`) REFERENCES `pokja` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
