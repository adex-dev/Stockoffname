-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2022 at 04:41 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `localaudit`
--
CREATE DATABASE IF NOT EXISTS `localaudit` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `localaudit`;

-- --------------------------------------------------------

--
-- Table structure for table `dummydata`
--

CREATE TABLE `dummydata` (
  `tanggal` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `kode_store` varchar(20) DEFAULT NULL,
  `ean` varchar(30) DEFAULT NULL,
  `flor` varchar(10) DEFAULT NULL,
  `onhand_scan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventorisdata`
--

CREATE TABLE `inventorisdata` (
  `ean` varchar(30) NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `kode_store` varchar(20) NOT NULL,
  `flor` varchar(20) NOT NULL,
  `onganscan` varchar(20) NOT NULL,
  `nik` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prm_auditor`
--

CREATE TABLE `prm_auditor` (
  `periode_audit` date NOT NULL,
  `kode_store` varchar(50) DEFAULT NULL,
  `pihak_1` varchar(50) DEFAULT NULL,
  `pihak_2` varchar(100) DEFAULT NULL,
  `status_audit` enum('BELUM SELESAI','SELESAI') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prm_stock`
--

CREATE TABLE `prm_stock` (
  `periode` date NOT NULL,
  `ean` varchar(50) NOT NULL,
  `kode_store` varchar(20) DEFAULT NULL,
  `nama_store` varchar(50) DEFAULT NULL,
  `item_id` varchar(100) DEFAULT NULL,
  `waist` varchar(100) DEFAULT NULL,
  `inseam` varchar(100) DEFAULT NULL,
  `item_description` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `subkelas` varchar(50) DEFAULT NULL,
  `bin` varchar(50) DEFAULT NULL,
  `onhand_qty` varchar(50) DEFAULT NULL,
  `onhand_scan` varchar(50) DEFAULT NULL,
  `status` enum('BELUM','SELESAI') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prm_store`
--

CREATE TABLE `prm_store` (
  `kode_store` varchar(20) NOT NULL,
  `nama_store` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
