-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2020 at 10:18 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laundry`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `countMember` (OUT `totalMember` INT)  BEGIN
	SELECT COUNT(*) INTO totalMember FROM tb_member;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `statusDeadline` (`id_tanggal` CHAR(20)) RETURNS CHAR(20) CHARSET utf8mb4 BEGIN
	DECLARE stat char(20);
    SELECT COUNT(*) as status_deadline INTO stat FROM tb_transaksi WHERE  tb_transaksi.status = 'baru' OR tb_transaksi.status = 'proses' AND tb_transaksi.batas_waktu <= id_tanggal;
    RETURN stat;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_transaksi`
--

CREATE TABLE `tb_detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_detail_transaksi`
--

INSERT INTO `tb_detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES
(10, 9, 3, 1, 'bed cover iron man\r\n-pelembut\r\n-pewangi'),
(21, 14, 5, 1, 'pewangi'),
(22, 14, 3, 1, 'sprei biru'),
(23, 15, 3, 1, 'pelembut'),
(24, 15, 2, 2, 'pelembut'),
(25, 16, 5, 1, 'blue jeans'),
(26, 17, 1, 2, 'seragam sekolah smk\r\n-pewangi'),
(28, 19, 2, 1, 'selimut doraemon\r\n-pelembut'),
(30, 21, 1, 1, 'baju olahraga\r\n- 1 hari\r\n- pewangi'),
(31, 21, 5, 1, 'blue jeans\r\n- 1 hari\r\n- pewangi'),
(32, 22, 5, 1, 'red jeans\r\n- pewangi'),
(33, 23, 2, 1, 'selimut nobita\r\n- pewangi'),
(35, 20, 6, 1, 'kaos hitam gambar beruang\r\n- pewangi\r\n- pelembut'),
(38, 27, 3, 1, 'Sprei Minion\r\n- Pelembut'),
(39, 27, 5, 1, 'Jeans Dream Bird\r\n- Pewangi'),
(40, 27, 2, 1, 'Selimut Minion\r\n- Pewangi'),
(44, 30, 6, 1, 'kaos F\r\n- Pelembut\r\n- Pewangi'),
(49, 35, 6, 1, 'kaos supreme\r\n- pelembut\r\n- pewangi'),
(50, 36, 1, 1, 'kaos pull and bear\r\ncelana pendek'),
(51, 37, 2, 1, 'selimut doraemon\r\n-pewangi'),
(52, 38, 1, 2, 'kaos\r\ncelana\r\nkemeja\r\n- pewangi'),
(54, 40, 6, 1, 'kaos supreme\r\n- pewangi\r\n- pelembut');

--
-- Triggers `tb_detail_transaksi`
--
DELIMITER $$
CREATE TRIGGER `InsertDataDetailTransaksi` AFTER INSERT ON `tb_detail_transaksi` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_detail_transaksi, "Inserted", NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_history`
--

CREATE TABLE `tb_history` (
  `id_history` int(11) NOT NULL,
  `id_table_ref` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `id_member` int(11) NOT NULL,
  `nama_member` varchar(100) NOT NULL,
  `alamat_member` text NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp_member` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`id_member`, `nama_member`, `alamat_member`, `jenis_kelamin`, `telp_member`) VALUES
(1, 'Habib Al Huda Abdullah', 'PERUM GRAND AKASIA RESIDENCE, BLOK A36 RT 01/02 PONDOK BENDA, PAMULANG', 'L', '0895343371291'),
(3, 'Jaya Saputra', 'KP. CITEREP NO. 17 RT 01/06 PABUARAN, GUNUNG SINDUR', 'L', '081315708722'),
(5, 'Ahmad Rasyid', 'JL. SALAK RAYA BLOK I NO 25 RT 05/21 PONDOK BENDA, PAMULANG', 'L', '081382698470'),
(6, 'Faisal Achramsyah', 'Batan indah RT12/RW04 No. 43', 'L', '081510030416'),
(7, 'Dimas Ramadhan', 'JL. AMD BABAKAN POCIS NO. 09 115 RT 04/01 BAKTI JAYA SETU', 'L', '081517321228'),
(8, 'Epri Maulana', 'JL. PUSPITEK RT 14/04 SETU TANGSEL', 'L', '089502451575'),
(9, 'Firman Hasan', 'JL. AMD BABAKAN POCIS RT 02/02 NO. 69 BAKTI JAYA SETU TANGSEL', 'L', '081517088069'),
(11, 'Tsar Ahmad', 'Komp. Puspiptek Blok 1 A 7 Setu Tangerang Selatan', 'L', '0895332850688');

--
-- Triggers `tb_member`
--
DELIMITER $$
CREATE TRIGGER `InsertData` BEFORE INSERT ON `tb_member` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_member, "Inserted", NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_outlet`
--

CREATE TABLE `tb_outlet` (
  `id_outlet` int(11) NOT NULL,
  `nama_outlet` varchar(100) NOT NULL,
  `alamat_outlet` text NOT NULL,
  `telp_outlet` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_outlet`
--

INSERT INTO `tb_outlet` (`id_outlet`, `nama_outlet`, `alamat_outlet`, `telp_outlet`) VALUES
(1, 'Laundry Sejahtera', 'JL. AMD BABAKAN POCIS NO. 100 RT 02/02 BAKTI JAYA SETU', '087733932416'),
(2, 'Laundry Smart', 'JL. LURAH RT 05/03 NO 83 PONDOK BENDA PAMULANG', '085695598958'),
(4, 'Laundry Mimpi', 'JL. CIATER BARAT NO. 19 RT 01/01 CIATER, SERPONG ', '089649368837');

--
-- Triggers `tb_outlet`
--
DELIMITER $$
CREATE TRIGGER `InsertDataOutlet` AFTER INSERT ON `tb_outlet` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_outlet, "Inserted", NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paket`
--

CREATE TABLE `tb_paket` (
  `id_paket` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `jenis` enum('kiloan','selimut','bed cover','kaos','lain') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_paket`
--

INSERT INTO `tb_paket` (`id_paket`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
(1, 1, 'kiloan', 'Kiloan Clings', 7000),
(2, 1, 'selimut', 'Selimut Semerbak', 15000),
(3, 1, 'bed cover', 'Sprei Lembut', 25000),
(5, 1, 'lain', 'Jeans', 15000),
(6, 1, 'kaos', 'Kaos Supreme', 20000);

--
-- Triggers `tb_paket`
--
DELIMITER $$
CREATE TRIGGER `InsertDataPaket` AFTER INSERT ON `tb_paket` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_paket, "Inserted", NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `total_pembayaran` int(11) DEFAULT NULL,
  `uang_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pembayaran`, `total_pembayaran`, `uang_bayar`, `kembalian`, `id_user`, `id_transaksi`) VALUES
(2, 84000, 100000, 11800, 1, 2),
(3, 30000, 50000, 20000, 29, 9),
(4, 192000, 222222, 30222, 29, 10),
(5, 40000, 50000, 10000, 29, 14),
(6, 55000, 60000, 5000, 29, 15),
(7, 15000, 20000, 5000, 29, 16),
(8, 7000, 10000, 3000, 29, 18),
(9, 22000, 20000, 200, 11, 21),
(10, 15000, 20000, 5000, 11, 23),
(11, 14000, 15000, 1000, 29, 17),
(12, 15000, 20000, 5000, 29, 19),
(13, 20000, 20000, 0, 29, 20),
(14, 15000, 15000, 0, 29, 22),
(15, 55000, 60000, 5000, 10, 27),
(16, 20000, 20000, 0, 10, 30),
(17, 15000, 20000, 5000, 29, 37),
(18, 20000, 50000, 30000, 29, 39),
(19, 20000, 20000, 0, 10, 40);

--
-- Triggers `tb_pembayaran`
--
DELIMITER $$
CREATE TRIGGER `InsertDataPembayaran` AFTER INSERT ON `tb_pembayaran` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_pembayaran, "Inserted", NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `kode_invoice` varchar(100) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `biaya_tambahan` int(11) DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `pajak` int(11) DEFAULT NULL,
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('dibayar','belum dibayar') NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `id_outlet`, `kode_invoice`, `id_member`, `tanggal`, `batas_waktu`, `tanggal_bayar`, `biaya_tambahan`, `diskon`, `pajak`, `status`, `dibayar`, `id_user`) VALUES
(9, 1, 'INV032323274045', 6, '2020-03-23 23:27:00', '2020-03-25 23:27:00', '2020-03-24 00:01:00', 10000, 10, 10, 'diambil', 'dibayar', 29),
(14, 1, 'INV032401164212', 3, '2020-03-24 01:16:35', '2020-03-24 01:16:35', '2020-03-24 05:25:23', 10000, 10, 10, 'diambil', 'dibayar', 29),
(15, 1, 'INV032405283531', 1, '2020-03-24 05:28:26', '2020-03-24 05:28:26', '2020-03-24 05:29:29', 1000, 10, 10, 'diambil', 'dibayar', 29),
(16, 1, 'INV032413480558', 5, '2020-03-24 13:47:58', '2020-03-24 13:47:58', '2020-03-24 13:48:26', 10000, 10, 10, 'diambil', 'dibayar', 29),
(17, 1, 'INV032413560935', 7, '2020-03-24 13:55:56', '2020-03-26 13:55:56', '2020-03-27 07:06:09', 5000, 10, 10, 'diambil', 'dibayar', 29),
(19, 1, 'INV032414505011', 6, '2020-03-24 14:50:34', '2020-03-26 14:50:34', '2020-03-27 07:08:49', 10000, 10, 10, 'diambil', 'dibayar', 29),
(20, 1, 'INV032614113357', 8, '2020-03-26 14:11:16', '2020-03-28 12:00:16', '2020-03-27 07:11:14', 10000, 10, 10, 'diambil', 'dibayar', 11),
(21, 1, 'INV032614125198', 1, '2020-03-26 14:12:36', '2020-03-27 14:12:36', '2020-03-26 14:15:56', 12000, 20, 10, 'diambil', 'dibayar', 11),
(22, 1, 'INV032614173986', 8, '2020-03-26 14:17:00', '2020-03-27 14:17:00', '2020-03-27 07:13:00', 10000, 10, 10, 'selesai', 'dibayar', 29),
(23, 1, 'INV032614225441', 7, '2020-03-26 14:22:46', '2020-03-27 14:22:46', '2020-03-26 14:23:28', 10000, 10, 10, 'selesai', 'dibayar', 11),
(27, 1, 'INV032707280025', 9, '2020-03-27 07:27:00', '2020-03-30 07:27:00', '2020-03-28 17:03:21', 5000, 10, 10, 'diambil', 'dibayar', 29),
(30, 1, 'INV032801512064', 8, '2020-03-28 01:51:00', '2020-03-29 01:51:00', '2020-03-28 17:05:52', 1000, 10, 10, 'diambil', 'dibayar', 29),
(35, 2, 'INV032817325852', 11, '2020-03-28 17:32:50', '2020-03-29 17:32:50', NULL, 1000, 10, 10, 'baru', 'belum dibayar', 7),
(36, 1, 'INV032819382084', 11, '2020-03-28 19:38:08', '2020-03-29 19:38:08', NULL, 10000, 10, 10, 'proses', 'belum dibayar', 29),
(37, 1, 'INV032819393990', 8, '2020-03-28 19:39:24', '2020-03-29 19:39:24', '2020-03-28 22:22:23', 10000, 10, 10, 'proses', 'dibayar', 29),
(38, 1, 'INV032908061081', 5, '2020-03-29 08:06:00', '2020-03-30 08:06:00', NULL, 10000, 10, 10, 'baru', 'belum dibayar', 29),
(40, 1, 'INV03291317563', 3, '2020-03-29 13:17:43', '2020-03-30 13:17:43', '2020-03-29 14:21:20', 10000, 10, 10, 'proses', 'dibayar', 11);

--
-- Triggers `tb_transaksi`
--
DELIMITER $$
CREATE TRIGGER `InsertDataTransaksi` AFTER INSERT ON `tb_transaksi` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_transaksi, "Inserted", NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `username`, `password`, `id_outlet`, `role`) VALUES
(3, 'Reiga Fryanditya', 'reiga', '$2y$10$rgUjftwMW.XlJ8BdusfgDeaihWzS6pCv8RVxmmZLbbY/C7wEnyPmq', 2, 'kasir'),
(7, 'Andri Firman Saputra', 'andri', '$2y$10$Giz76qqNj9P.X.L60qGqVe0HXKlcd8iZXW2KTpCHignGs9C5wWDsm', 2, 'admin'),
(10, 'super user', 'superuser', '$2y$10$M1rP0cARYm3xhj4F1Dv1Fu9ADrC08l0OnrDDXAfgg28iaLIIfHkF6', 0, 'admin'),
(11, 'Tubagus Fahri', 'fahri', '$2y$10$PmeUxIeZXQlYYwZmhI1rmOXa80atHPErguamEph7oB7Zsl8/.92rm', 1, 'kasir'),
(28, 'Syahrul Ramadhan', 'syahrul', '$2y$10$tv1RiWIFhf9Tew3uQqfLiO8IisB0eZl.okinGq6EOcDi8psVhYcZe', 1, 'owner'),
(29, 'andre farhan saputra', 'andre', '$2y$10$Giz76qqNj9P.X.L60qGqVe0HXKlcd8iZXW2KTpCHignGs9C5wWDsm', 1, 'admin'),
(30, 'Thoriq Haikal Fadli', 'thoriq', '$2y$10$XnHhX.ZGpE56.DnC6tiSv.H.QH5piWMVCsAz9ETUNTRjuBNBd/N5G', 1, 'owner'),
(31, 'Tarmiji Herman', 'tarmiji', '$2y$10$D/.tMeplpgPvDepM6Nx6IO.6SlFUpaOojDNObjbk3HaXfyPqlMhAu', 2, 'owner'),
(32, 'Epri Maulana', 'epri', '$2y$10$w73p9PqpiBh3eSrdPwSKQurFH4GAom3aeeTfEHUo3JsUnZ7FJf/7q', 1, 'owner');

--
-- Triggers `tb_user`
--
DELIMITER $$
CREATE TRIGGER `InsertDataUser` AFTER INSERT ON `tb_user` FOR EACH ROW INSERT INTO tb_history VALUES(NULL, NEW.id_user, "Inserted", NOW())
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_paket` (`id_paket`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tb_history`
--
ALTER TABLE `tb_history`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `tb_outlet`
--
ALTER TABLE `tb_outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indexes for table `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD PRIMARY KEY (`id_paket`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_outlet` (`id_outlet`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tb_history`
--
ALTER TABLE `tb_history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_outlet`
--
ALTER TABLE `tb_outlet`
  MODIFY `id_outlet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_paket`
--
ALTER TABLE `tb_paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD CONSTRAINT `tb_detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detail_transaksi_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `tb_paket` (`id_paket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD CONSTRAINT `tb_paket_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id_outlet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id_outlet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `tb_member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
