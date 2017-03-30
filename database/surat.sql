-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2015 at 04:33 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsipkeluar`
--

CREATE TABLE IF NOT EXISTS `arsipkeluar` (
  `id_arsipkeluar` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `kepada` varchar(100) DEFAULT NULL,
  `keperluan` text,
  `keterangan` varchar(255) DEFAULT NULL,
  `surat_id` int(11) DEFAULT NULL,
  `kategori_id` int(11) NOT NULL,
  PRIMARY KEY (`id_arsipkeluar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arsipmasuk`
--

CREATE TABLE IF NOT EXISTS `arsipmasuk` (
  `id_arsipmasuk` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `pengirim` varchar(100) DEFAULT NULL,
  `keperluan` text,
  `keterangan` varchar(255) DEFAULT NULL,
  `surat_id` int(11) DEFAULT NULL,
  `kategori_id` int(11) NOT NULL,
  PRIMARY KEY (`id_arsipmasuk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `filesurat`
--

CREATE TABLE IF NOT EXISTS `filesurat` (
  `id_filesurat` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `namafile` varchar(100) DEFAULT NULL,
  `tgl_pembuatan` datetime DEFAULT NULL,
  `tgl_perubahan` datetime DEFAULT NULL,
  PRIMARY KEY (`id_filesurat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `pilihan` char(7) DEFAULT NULL,
  `tgl_pembuatan` datetime DEFAULT NULL,
  `tgl_perubahan` datetime DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_content`
--

CREATE TABLE IF NOT EXISTS `kategori_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) DEFAULT NULL,
  `nama_content` varchar(100) DEFAULT NULL,
  `nama_string` varchar(100) DEFAULT NULL,
  `tipe` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE IF NOT EXISTS `surat` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_surat` varchar(100) DEFAULT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `filesurat_id` int(11) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `tipe_arsip` tinyint(1) NOT NULL,
  `tgl_pembuatan` datetime DEFAULT NULL,
  `tgl_perubahan` datetime DEFAULT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `tgl_pembuatan` timestamp NULL DEFAULT NULL,
  `tgl_perubahan` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `tgl_pembuatan`, `tgl_perubahan`) VALUES
(1, 'Administrator', 'admin@surat.com', 's/wEVG2gXsWghjHv47hFkcGWiMANV3yi2q/+6pkiXPE=', '2015-06-29 13:56:49', '2015-06-29 13:56:49');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
