-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2019 at 09:48 AM
-- Server version: 5.7.25-0ubuntu0.16.04.2
-- PHP Version: 7.2.13-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kpu`
--

-- --------------------------------------------------------

--
-- Table structure for table `kabkota`
--

CREATE TABLE `kabkota` (
  `id` int(11) NOT NULL,
  `id_prov` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `dapil` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `id_kab` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `dapil` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL,
  `id_kec` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `dapil` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `status_komplit` int(11) NOT NULL DEFAULT '0',
  `status_temp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `dapil` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suara`
--

CREATE TABLE `suara` (
  `id` int(11) NOT NULL,
  `id_tps` int(11) NOT NULL,
  `jumlah_pemilih` int(11) NOT NULL,
  `jumlah_pengguna` int(11) NOT NULL,
  `suara_sah` int(11) NOT NULL,
  `suara_tidak_sah` int(11) NOT NULL,
  `suara_total` int(11) NOT NULL,
  `suara_1` int(11) NOT NULL,
  `suara_2` int(11) NOT NULL,
  `c1_1` varchar(300) DEFAULT NULL,
  `c1_2` varchar(300) DEFAULT NULL,
  `status_c1` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tps`
--

CREATE TABLE `tps` (
  `id` int(11) NOT NULL,
  `id_kel` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `dapil` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kabkota`
--
ALTER TABLE `kabkota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prov` (`id_prov`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kab` (`id_kab`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kec` (`id_kec`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suara`
--
ALTER TABLE `suara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tps` (`id_tps`),
  ADD KEY `suara_1` (`suara_1`),
  ADD KEY `suara_2` (`suara_2`);

--
-- Indexes for table `tps`
--
ALTER TABLE `tps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kel` (`id_kel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `suara`
--
ALTER TABLE `suara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kabkota`
--
ALTER TABLE `kabkota`
  ADD CONSTRAINT `kabkota_ibfk_1` FOREIGN KEY (`id_prov`) REFERENCES `provinsi` (`id`);

--
-- Constraints for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`id_kab`) REFERENCES `kabkota` (`id`);

--
-- Constraints for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`id_kec`) REFERENCES `kecamatan` (`id`);

--
-- Constraints for table `suara`
--
ALTER TABLE `suara`
  ADD CONSTRAINT `suara_ibfk_1` FOREIGN KEY (`id_tps`) REFERENCES `tps` (`id`);

--
-- Constraints for table `tps`
--
ALTER TABLE `tps`
  ADD CONSTRAINT `tps_ibfk_1` FOREIGN KEY (`id_kel`) REFERENCES `kelurahan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
