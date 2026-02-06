-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql12.freesqldatabase.com
-- Generation Time: 05 Feb 2026 pada 23.37
-- Versi Server: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql12815967`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip`
--

CREATE TABLE `arsip` (
  `id` int(11) NOT NULL,
  `no_arsip` varchar(100) NOT NULL,
  `kode_klasifikasi` varchar(50) NOT NULL,
  `indeks` varchar(100) DEFAULT NULL,
  `no_item_arsip` varchar(100) DEFAULT NULL,
  `uraian_informasi` text NOT NULL,
  `jenis_arsip` varchar(100) DEFAULT NULL,
  `kurun_waktu` varchar(50) DEFAULT NULL,
  `tanggal_arsip` date DEFAULT NULL,
  `tingkat_perkembangan` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT '1',
  `keterangan` text,
  `status_arsip` enum('aktif','inaktif','usul_musnah','musnah','permanen') NOT NULL DEFAULT 'aktif',
  `klasifikasi_keamanan` enum('biasa','terbatas','rahasia','sangat_terbatas') DEFAULT 'biasa',
  `hak_akses` varchar(100) DEFAULT NULL,
  `akses_publik` tinyint(1) DEFAULT '0',
  `no_filling_cabinet` varchar(50) DEFAULT NULL,
  `no_laci` varchar(50) DEFAULT NULL,
  `no_folder` varchar(50) DEFAULT NULL,
  `no_boks` varchar(50) DEFAULT NULL,
  `lokasi_simpan` varchar(100) DEFAULT NULL,
  `nomor_definitif` varchar(100) DEFAULT NULL,
  `pencipta_arsip` varchar(150) DEFAULT NULL,
  `jangka_simpan` varchar(50) DEFAULT NULL,
  `nasib_akhir` varchar(100) DEFAULT NULL,
  `status_usul_musnah` tinyint(1) DEFAULT '0',
  `boks_usul_musnah` varchar(50) DEFAULT NULL,
  `kota_kabupaten` varchar(100) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `arsip`
--

INSERT INTO `arsip` (`id`, `no_arsip`, `kode_klasifikasi`, `indeks`, `no_item_arsip`, `uraian_informasi`, `jenis_arsip`, `kurun_waktu`, `tanggal_arsip`, `tingkat_perkembangan`, `jumlah`, `keterangan`, `status_arsip`, `klasifikasi_keamanan`, `hak_akses`, `akses_publik`, `no_filling_cabinet`, `no_laci`, `no_folder`, `no_boks`, `lokasi_simpan`, `nomor_definitif`, `pencipta_arsip`, `jangka_simpan`, `nasib_akhir`, `status_usul_musnah`, `boks_usul_musnah`, `kota_kabupaten`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '1', '1', '1', '1', '1', '2026-01-26', 'PNS', 1, 'PNS', 'aktif', 'biasa', '1', 1, '1', 'PNS', '1', '1', 'Pembina Utama, IV/e', '1', '1', '1', '1', 1, '1', '1', 40, '2026-01-26 01:15:17', '2026-01-26 01:15:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip_file`
--

CREATE TABLE `arsip_file` (
  `id` int(11) NOT NULL,
  `arsip_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dip`
--

CREATE TABLE `dip` (
  `id` int(11) NOT NULL,
  `jenis_informasi` enum('BERKALA','SERTA MERTA','SETIAP SAAT','DIKECUALIKAN') NOT NULL,
  `nama_informasi` text NOT NULL,
  `unit_penyedia` varchar(200) NOT NULL,
  `penanggung_jawab` varchar(150) DEFAULT NULL,
  `tahun_pembuatan` year(4) NOT NULL,
  `tempat_pembuatan` varchar(250) NOT NULL,
  `bentuk_informasi` enum('HARDCOPY','SOFTCOPY','HARDCOPY+SOFTCOPY') NOT NULL,
  `retensi_arsip` varchar(250) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dip`
--

INSERT INTO `dip` (`id`, `jenis_informasi`, `nama_informasi`, `unit_penyedia`, `penanggung_jawab`, `tahun_pembuatan`, `tempat_pembuatan`, `bentuk_informasi`, `retensi_arsip`, `is_active`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(4, 'BERKALA', 'Renstra BPMP Provinsi Bali 2025-2029', 'Bagian Perencanaan BPMP Provinsi Bali', 'Bagian Perencanaan BPMP Provinsi Bali', 2025, 'Denpasar', 'HARDCOPY+SOFTCOPY', '5 Tahun', 1, 40, '2026-02-05 14:26:56', NULL),
(5, 'BERKALA', 'SE Direktur Jenderal Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah', 'Bagian Kementerian Pendidikan Dasar dan Menengah', 'Bagian Direktur Jenderal Pendidikan Dasar dan Menengah', 2026, 'Jakarta', 'SOFTCOPY', 'Aktif', 1, 40, '2026-02-05 14:29:16', NULL),
(6, 'SETIAP SAAT', 'Peraturan/Kebijakan tentang Budaya Sekolah Aman dan Nyaman', 'Bagian Kementerian Pendidikan Dasar dan Menengah', 'Bagian Menteri Pendidikan Dasar dan Menengah', 2026, 'Jakarta', 'SOFTCOPY', NULL, 1, 40, '2026-02-05 14:31:32', NULL),
(7, 'SERTA MERTA', 'SE Penyelenggaraan Pembelajaran pada Satuan Pendidikan Terdampak Bencana', 'Bagian Kementerian Pendidikan Dasar dan Menengah', 'Bagian Menteri Pendidikan Dasar dan Menengah', 2026, 'Jakarta', 'HARDCOPY+SOFTCOPY', NULL, 1, 40, '2026-02-05 14:33:19', NULL),
(8, 'SETIAP SAAT', 'Pendampingan Pelaksanaan MBG', 'Tim Kerja BPMP Provinsi Bali', 'Tim Kerja Prioritas', 2025, 'Denpasar', 'HARDCOPY+SOFTCOPY', NULL, 1, 40, '2026-02-05 14:36:51', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dip_file`
--

CREATE TABLE `dip_file` (
  `id` int(11) NOT NULL,
  `dip_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen`
--

CREATE TABLE `dokumen` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text,
  `jenis_id` int(11) NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen`
--

INSERT INTO `dokumen` (`id`, `judul`, `deskripsi`, `jenis_id`, `tahun`, `is_published`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(1, 'test', 'sets', 1, 2025, 0, NULL, '2026-01-26 02:38:20', '2026-01-26 02:38:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_file`
--

CREATE TABLE `dokumen_file` (
  `id` int(11) NOT NULL,
  `dokumen_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_file`
--

INSERT INTO `dokumen_file` (`id`, `dokumen_id`, `nama_file`, `path_file`, `tipe_file`, `ukuran_file`, `uploaded_at`) VALUES
(1, 1, 'Perjanjian Kerja Made Rian 1.pdf', 'uploads/dokumen/1769395100_0_Perjanjian_Kerja_Made_Rian_1.pdf', 'application/pdf', 2729925, '2026-01-26 02:38:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_dokumen`
--

CREATE TABLE `jenis_dokumen` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_dokumen`
--

INSERT INTO `jenis_dokumen` (`id`, `nama`, `deskripsi`, `is_active`, `created_at`) VALUES
(1, 'dokumen', 'dokumen', NULL, '2026-01-26 02:32:43'),
(2, 'test', 'test', NULL, '2026-01-26 02:33:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_peraturan`
--

CREATE TABLE `jenis_peraturan` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_peraturan`
--

INSERT INTO `jenis_peraturan` (`id`, `kode`, `nama`, `keterangan`, `is_active`) VALUES
(1, 'Permen', 'Peraturan Menteri', '', 1),
(2, 'PP', 'Peraturan Pemerintah', '', 1),
(3, 'UU', 'Undang-Undang', '', 1),
(4, 'UUD', 'Undang-Undang Dasar', '', 1),
(5, 'Pergub', 'Peraturan Gubernur', '', 0),
(6, 'Kepmen', 'Keputusan Menteri', '', 1),
(7, 'Inpres', 'Instruksi Presiden', '', 1),
(8, 'SE', 'Surat Edaran', '', 0),
(9, '', '', '', 0),
(10, 'Perpres', 'Peraturan Presiden', '', 1),
(11, 'SE Menteri', 'Surat Edaran Menteri', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_publikasi`
--

CREATE TABLE `jenis_publikasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_publikasi`
--

INSERT INTO `jenis_publikasi` (`id`, `nama`, `keterangan`, `is_active`) VALUES
(1, 'Berita', '', 1),
(2, 'Artikel', '', 1),
(3, 'Laporan', '', 1),
(4, 'Videosfad', '', 0),
(5, 'Poster', '', 0),
(6, 'edit', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_global` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`id`, `judul`, `deskripsi`, `link`, `gambar`, `urutan`, `is_active`, `is_global`, `created_at`, `updated_at`) VALUES
(1, 'Tim Kerja PAUD', 'Tim Kerja PAUD', 'paud', 'paud.png', 1, 1, 0, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(2, 'Tim Kerja SD', 'Tim Kerja SD', 'sd', 'sd.png', 2, 1, 0, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(3, 'Tim Kerja SMP', 'Tim Kerja SMP', 'smp', 'smp.png', 3, 1, 0, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(4, 'Tim Kerja SMA', 'Tim Kerja SMA', 'sma', 'sma.png', 4, 1, 0, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(5, 'Tim Widyaprada', 'Tim Widyaprada', 'widyaprada', 'widyaprada.png', 5, 1, 0, '2026-01-08 02:54:01', '2026-01-29 02:03:21'),
(6, 'Data Kepegawaian', 'Data Kepegawaian', 'kepegawaian', 'kepegawaian.png', 6, 1, 1, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(7, 'SiPPeDE', 'SiPPeDE', 'https://sippede.lpmpbali.id/', 'sippede.png', 7, 1, 1, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(8, 'Peraturan', 'Peraturan', 'peraturan-publik', 'peraturan.png', 8, 1, 1, '2026-01-08 02:54:01', '2026-01-21 01:17:36'),
(9, 'Arsip', 'Arsip', 'arsip', 'arsip.png', 9, 1, 1, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(10, 'ZI-WBBM', 'ZI-WBBM', 'zi-wbbm', 'zi-wbbm.png', 10, 1, 1, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(11, 'DIP', 'Daftar Informasi Publik', 'dip-publik', 'dip.png', 11, 1, 1, '2026-01-08 02:54:01', '2026-01-08 02:54:01'),
(12, 'Pimpinan', 'Pimpinan', 'pimpinan', '', 1, 0, 0, '2026-01-08 02:54:01', '2026-01-12 00:42:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_pokja`
--

CREATE TABLE `modul_pokja` (
  `id` int(11) NOT NULL,
  `modul_id` int(11) NOT NULL,
  `pokja_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `modul_pokja`
--

INSERT INTO `modul_pokja` (`id`, `modul_id`, `pokja_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_role`
--

CREATE TABLE `modul_role` (
  `id` int(11) NOT NULL,
  `modul_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `can_view` tinyint(1) DEFAULT '1',
  `can_create` tinyint(1) DEFAULT '0',
  `can_edit` tinyint(1) DEFAULT '0',
  `can_delete` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `modul_role`
--

INSERT INTO `modul_role` (`id`, `modul_id`, `role_id`, `can_view`, `can_create`, `can_edit`, `can_delete`) VALUES
(97, 1, 1, 1, 0, 0, 0),
(98, 1, 2, 1, 0, 0, 0),
(99, 1, 3, 1, 0, 0, 0),
(100, 1, 4, 1, 0, 0, 0),
(101, 2, 1, 1, 0, 0, 0),
(102, 2, 2, 1, 0, 0, 0),
(103, 2, 3, 1, 0, 0, 0),
(104, 2, 4, 1, 0, 0, 0),
(105, 3, 1, 1, 0, 0, 0),
(106, 3, 2, 1, 0, 0, 0),
(107, 3, 3, 1, 0, 0, 0),
(108, 3, 4, 1, 0, 0, 0),
(109, 4, 1, 1, 0, 0, 0),
(110, 4, 2, 1, 0, 0, 0),
(111, 4, 3, 1, 0, 0, 0),
(112, 4, 4, 1, 0, 0, 0),
(113, 5, 1, 1, 0, 0, 0),
(114, 5, 2, 1, 0, 0, 0),
(115, 5, 3, 1, 0, 0, 0),
(116, 5, 4, 1, 0, 0, 0),
(117, 6, 1, 1, 0, 0, 0),
(118, 6, 2, 1, 0, 0, 0),
(119, 6, 3, 1, 0, 0, 0),
(120, 6, 4, 1, 0, 0, 0),
(121, 7, 1, 1, 0, 0, 0),
(122, 7, 2, 1, 0, 0, 0),
(123, 7, 3, 1, 0, 0, 0),
(124, 7, 4, 1, 0, 0, 0),
(125, 8, 1, 1, 0, 0, 0),
(126, 8, 2, 1, 0, 0, 0),
(127, 8, 3, 1, 0, 0, 0),
(128, 8, 4, 1, 0, 0, 0),
(129, 9, 1, 1, 0, 0, 0),
(130, 9, 2, 1, 0, 0, 0),
(131, 9, 3, 1, 0, 0, 0),
(132, 9, 4, 1, 0, 0, 0),
(133, 10, 1, 1, 0, 0, 0),
(134, 10, 2, 1, 0, 0, 0),
(135, 10, 3, 1, 0, 0, 0),
(136, 10, 4, 1, 0, 0, 0),
(137, 11, 1, 1, 0, 0, 0),
(138, 11, 2, 1, 0, 0, 0),
(139, 11, 3, 1, 0, 0, 0),
(140, 11, 4, 1, 0, 0, 0),
(141, 12, 1, 1, 0, 0, 0),
(142, 12, 2, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(50) NOT NULL,
  `alamat_domisili` text,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_asn` enum('PNS','PPPK','PPNPN/OUTSOURCING') NOT NULL,
  `pangkat_golongan` varchar(50) DEFAULT NULL,
  `grade` int(3) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `pendidikan` varchar(100) NOT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `nomor_sk_pengangkatan` varchar(100) DEFAULT NULL,
  `nomor_sk_spmt` varchar(100) DEFAULT NULL,
  `proyeksi_pensiun` year(4) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_file`
--

CREATE TABLE `pegawai_file` (
  `id` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `jenis_dokumen` varchar(50) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `is_global` tinyint(1) DEFAULT '1',
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peraturan`
--

CREATE TABLE `peraturan` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `nomor` varchar(100) DEFAULT NULL,
  `teu` varchar(100) DEFAULT NULL,
  `jenis_id` int(11) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `tempat_penetapan` varchar(150) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `penandatangan` varchar(150) DEFAULT NULL,
  `jumlah_unduhan` int(11) DEFAULT '0',
  `jumlah_dilihat` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peraturan`
--

INSERT INTO `peraturan` (`id`, `judul`, `nomor`, `teu`, `jenis_id`, `tahun_terbit`, `tempat_penetapan`, `kategori`, `penandatangan`, `jumlah_unduhan`, `jumlah_dilihat`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 'Peraturan Menteri Pendidikan Dasar dan Menengah Nomor 4 Tahun 2026 tentang Perlindungan bagi Pendidik dan Tenaga Kependidikan', '4', 'Indonesia. Kementerian Pendidikan Dasar dan Menengah', 1, 2026, ' Jakarta', NULL, 'Abdul Muti', 1, 3, 1, '2026-02-05 14:00:47', NULL),
(7, 'Surat Edaran Menteri Pendidikan Dasar dan Menengah Nomor 14 Tahun 2025 tentang Kegiatan Muridd Selama Libur Natal 2025 dan Tahun Baru 2026', '14', 'Indonesia. Kementerian Pendidikan Dasar dan Menengah', 11, 2025, 'Jakarta', NULL, 'Abdul Muti', 0, 3, 1, '2026-02-05 14:09:09', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peraturan_file`
--

CREATE TABLE `peraturan_file` (
  `id` int(11) NOT NULL,
  `peraturan_id` int(11) NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peraturan_file`
--

INSERT INTO `peraturan_file` (`id`, `peraturan_id`, `nama_file`, `path_file`, `tipe_file`, `ukuran_file`, `uploaded_at`) VALUES
(5, 6, 'Peraturan Menteri Pendidikan Dasar dan Menengah Nomor 4 Tahun 2026 tentang Perlindungan bagi Pendidik dan Tenaga Kependidikan.pdf', 'uploads/peraturan/1770299946_0_Peraturan_Menteri_Pendidikan_Dasar_dan_Menengah_Nomor_4_Tahun_2026_tentang_Perlindungan_bagi_Pendidik_dan_Tenaga_Kependidikan.pdf', 'application/pdf', 191086, '2026-02-05 14:00:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pokja`
--

CREATE TABLE `pokja` (
  `id` int(11) NOT NULL,
  `pokja_tipe` enum('Tim','Unit') NOT NULL,
  `pokja_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pokja`
--

INSERT INTO `pokja` (`id`, `pokja_tipe`, `pokja_nama`) VALUES
(1, 'Tim', 'PAUD'),
(2, 'Tim', 'SD'),
(3, 'Tim', 'SMP'),
(4, 'Tim', 'SMA'),
(5, 'Tim', 'Widyaprada'),
(6, 'Unit', 'Kepegawaian'),
(7, 'Unit', 'Perencanaan'),
(8, 'Unit', 'Keuangan'),
(9, 'Unit', 'Publikasi'),
(10, 'Unit', 'Arsiparis'),
(11, 'Unit', 'Pustakawan'),
(12, 'Unit', 'Perlengkapan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `publikasi`
--

CREATE TABLE `publikasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text,
  `tanggal_kegiatan` date DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `jenis_id` int(11) DEFAULT NULL,
  `penulis` varchar(150) DEFAULT NULL,
  `kabupaten` varchar(150) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `kategori` varchar(150) DEFAULT NULL,
  `jumlah_dilihat` int(11) DEFAULT '0',
  `pokja_id` int(11) NOT NULL,
  `is_published` tinyint(1) DEFAULT '1',
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `publikasi`
--

INSERT INTO `publikasi` (`id`, `judul`, `deskripsi`, `tanggal_kegiatan`, `lokasi`, `jenis_id`, `penulis`, `kabupaten`, `link`, `kategori`, `jumlah_dilihat`, `pokja_id`, `is_published`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(5, 'Kunjungan BPMP Bali ke BPMP NTB: Strategi Implementasi Program Prioritas Kemendikdasmen', 'Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Bali melakukan kunjungan kerja ke BPMP Provinsi NTB pada Senin, 22 Desember 2025. Kunjungan ini dilaksanakan dalam rangka Studi Tiru Praktik Baik Strategi Implementasi Program Prioritas.', '2025-12-22', 'BPMP NTB', 3, 'Tim Publikasi BPMP Bali', 'Mataram', '', NULL, 0, 1, 1, 16, '2026-02-05 14:48:10', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `publikasi_file`
--

CREATE TABLE `publikasi_file` (
  `id` int(11) NOT NULL,
  `publikasi_id` int(11) NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `kode_role` varchar(20) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `kode_role`, `nama_role`) VALUES
(1, 'Superadmin', 'Super Admin'),
(2, 'Admin', 'Admin Tim Kerja'),
(3, 'Pimpinan', 'Pimpinan'),
(4, 'Staff', 'Staff');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `pokja_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `nama_lengkap`, `role_id`, `pokja_id`, `is_active`, `created_at`) VALUES
(15, 'timpaud', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Tim PAUD', 4, 1, 1, '2026-01-08 06:52:38'),
(16, 'adminpaud', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin PAUD', 2, 1, 1, '2026-01-08 06:52:38'),
(17, 'timsd', '$2y$10$8kU2AqPZJ9D8L5N8V4B3YOFVJtH3z4Xq2pY1FJ8mE6wA2q', 'Tim SD', 4, 2, 1, '2026-01-08 06:52:38'),
(18, 'adminsd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin SD', 2, 2, 1, '2026-01-08 06:52:38'),
(19, 'timsmp', '$2y$10$5Hq4E9N1RZ7K0P3U1xB4p2O0KZkq6YF7F2T1P8V7QK', 'Tim SMP', 4, 3, 1, '2026-01-08 06:52:38'),
(20, 'adminsmp', '$2y$10$1J9P8N6Z0T3E7pU1kR2XQx4V8mY7F9D1Z6U5L8A', 'Admin SMP', 2, 3, 1, '2026-01-08 06:52:38'),
(21, 'timsma', '$2y$10$P8R1k5D6JZQ7X1Z0C9E2H8qO4x6F5T7L9U3Z', 'Tim SMA', 4, 4, 1, '2026-01-08 06:52:38'),
(22, 'adminsma', '$2y$10$4E2H5R6P7Z0FJ1N8V9YkQxT3C6D8K1A7', 'Admin SMA', 2, 4, 1, '2026-01-08 06:52:38'),
(23, 'timwp', '$2y$10$Z6P4R1F7K8D5T9Q0HNY3J', 'Tim Widyaprada', 4, 5, 1, '2026-01-08 06:52:38'),
(24, 'admintimwp', '$2y$10$K9F4D7Z6R1P8T0QHNY3J', 'Admin Tim Widyaprada', 2, 5, 1, '2026-01-08 06:52:38'),
(25, 'kepegawaian', '$2y$10$8D7P1T6VJ4ZK0Y5Q2H9F3R8A6N', 'Unit Kepegawaian', 4, 6, 1, '2026-01-08 06:52:38'),
(26, 'adminkepegawaian', '$2y$10$J4QZ5T6F9A3R2K0H8P7Y1VXN', 'Admin Kepegawaian', 2, 6, 1, '2026-01-08 06:52:38'),
(27, 'perencanaan', '$2y$10$Z4R7Y8D5P1A0J6H3TQ9NFK2', 'Unit Perencanaan', 4, 7, 1, '2026-01-08 06:52:38'),
(28, 'adminperencanaan', '$2y$10$7ZQ8T5F1N9JH0D3K4P6RAY2', 'Admin Perencanaan', 2, 7, 1, '2026-01-08 06:52:38'),
(29, 'keuangan', '$2y$10$F1T0K4ZP5Q6J3H7N2Y8R9D', 'Unit Keuangan', 4, 8, 1, '2026-01-08 06:52:38'),
(30, 'adminkeuangan', '$2y$10$PZ5R9J1D2T4H0K6F7N8YQ3', 'Admin Keuangan', 2, 8, 1, '2026-01-08 06:52:38'),
(31, 'publikasi', '$2y$10$N5Z1H4QJ8T6P7D0Y9R3K2F', 'Unit Publikasi', 4, 9, 1, '2026-01-08 06:52:38'),
(32, 'adminpublikasi', '$2y$10$H6P0T3KZ8R1J7F9D5NQ2Y4', 'Admin Publikasi', 2, 9, 1, '2026-01-08 06:52:38'),
(33, 'arsiparis', '$2y$10$Q7D5F1ZK9H6P4T8R0JNY3', 'Arsiparis', 4, 10, 1, '2026-01-08 06:52:38'),
(34, 'adminarsiparis', '$2y$10$Z9K7P5F1D4T8R6H0JNY3Q', 'Admin Arsiparis', 2, 10, 1, '2026-01-08 06:52:38'),
(35, 'pustakawan', '$2y$10$R6ZK5F4H9D7P1T8Q0JNY3', 'Pustakawan', 4, 11, 1, '2026-01-08 06:52:38'),
(36, 'adminpustakawan', '$2y$10$D8Z4K7R6F5P1T0H9JNY3Q', 'Admin Pustakawan', 2, 11, 1, '2026-01-08 06:52:38'),
(37, 'perlengkapan', '$2y$10$R7D4T8H9P6K1Z0FJ5QNY3', 'Unit Perlengkapan', 4, 12, 1, '2026-01-08 06:52:38'),
(38, 'adminperlengkapan', '$2y$10$T4K8PZ6R0F7D1Q5J9N3HY', 'Admin Perlengkapan', 2, 12, 1, '2026-01-08 06:52:38'),
(39, 'pimpinan', '$2y$10$Q1P8R6JZ9D4H7F5T0N3KY', 'Pimpinan', 3, NULL, 1, '2026-01-08 06:52:38'),
(40, 'superadmin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Admin', 1, NULL, 1, '2026-01-08 06:52:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `arsip_file`
--
ALTER TABLE `arsip_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_id` (`arsip_id`);

--
-- Indexes for table `dip`
--
ALTER TABLE `dip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `dip_file`
--
ALTER TABLE `dip_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dip_id` (`dip_id`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_id` (`jenis_id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `dokumen_file`
--
ALTER TABLE `dokumen_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_id` (`dokumen_id`);

--
-- Indexes for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_peraturan`
--
ALTER TABLE `jenis_peraturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_kode` (`kode`);

--
-- Indexes for table `jenis_publikasi`
--
ALTER TABLE `jenis_publikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul_pokja`
--
ALTER TABLE `modul_pokja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modul_id` (`modul_id`),
  ADD KEY `pokja_id` (`pokja_id`);

--
-- Indexes for table `modul_role`
--
ALTER TABLE `modul_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `modul_id` (`modul_id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_nik` (`nik`),
  ADD UNIQUE KEY `uk_nip` (`nip`),
  ADD KEY `idx_status_asn` (`status_asn`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `fk_pegawai_user` (`id_user`);

--
-- Indexes for table `pegawai_file`
--
ALTER TABLE `pegawai_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`);

--
-- Indexes for table `peraturan`
--
ALTER TABLE `peraturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peraturan_file`
--
ALTER TABLE `peraturan_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peraturan_id` (`peraturan_id`);

--
-- Indexes for table `pokja`
--
ALTER TABLE `pokja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publikasi`
--
ALTER TABLE `publikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publikasi_file`
--
ALTER TABLE `publikasi_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `arsip_file`
--
ALTER TABLE `arsip_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dip`
--
ALTER TABLE `dip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `dip_file`
--
ALTER TABLE `dip_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jenis_peraturan`
--
ALTER TABLE `jenis_peraturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `jenis_publikasi`
--
ALTER TABLE `jenis_publikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `modul_pokja`
--
ALTER TABLE `modul_pokja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `modul_role`
--
ALTER TABLE `modul_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pegawai_file`
--
ALTER TABLE `pegawai_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `peraturan`
--
ALTER TABLE `peraturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `peraturan_file`
--
ALTER TABLE `peraturan_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pokja`
--
ALTER TABLE `pokja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `publikasi`
--
ALTER TABLE `publikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `publikasi_file`
--
ALTER TABLE `publikasi_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_pegawai_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
