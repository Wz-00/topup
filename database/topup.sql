-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 03:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topup`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `gid` char(4) NOT NULL,
  `game` varchar(40) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(465) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`gid`, `game`, `description`, `image`) VALUES
('G001', 'Valorant', 'Cara Top Up <br>\r\n1. Masukkan Riot ID Anda, Contoh : Lapakgaming#1234 <br>\r\n2. Pilih Nominal Points yang kamu inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Points akan ditambahkan ke akun Valorant kamu\r\n5. Pastikan untuk top up dari pukul 08:00 WIB - 23:00 WIB. Memesan diluar jam proses merupakan tanggung jawab pembeli dan transaksi tidak dapat direfund', 'uploads/val-bg.jpg'),
('G002', 'Mobile Legends', 'Cara Top Up <br>\r\n1. Masukkan User ID dan Zone ID Anda, Contoh : 1234567 (1234) <br>\r\n2. Pilih Nominal Diamonds yang kamu inginkan\r\n3. Selesaikan pembayaran <br>\r\n4. Diamonds akan ditambahkan ke akun Mobile Legends kamu <br>', 'uploads/ml-bg.jpg'),
('G003', 'PUBG Mobile', 'Cara Top Up <br>\r\n1. Masukkan ID anda <br>\r\n2. Pilih produk yang anda inginkan. <br>\r\n3. Selesaikan Pembayaran <br>\r\n4. Produk akan ditambahkan pada akun anda. ', 'uploads/pubg-bg.jpg'),
('G004', 'Genshin Impact', 'Cara Top Up <br>\r\n1. Masukkan User ID dan Pilih Server Anda <br>\r\n2. Pilih Nominal Crystals yang kamu inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Crystals akan ditambahkan ke akun Genshin Impact kamu', 'uploads/genshin-bg.jpg'),
('G005', 'COD Mobile', 'Cara Top Up <br>\r\n1. Masukkan Open ID Anda <br>\r\n2. Pilih produk yang kamu inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Produk akan ditambahkan ke akun CODM kamu', 'uploads/codm-bg.jpg'),
('G006', 'Honor of Kings', 'Cara Top Up <br>\r\n1. Pilih Produk yang kamu inginkan <br>\r\n2. Selesaikan pembayaran <br>\r\n3. Produk akan ditambahkan ke akun Honor Of Kings! kamu', 'uploads/hok-bg.jpg'),
('G007', 'League of Legends', 'Cara Top Up <br>\r\n1. Masukkan Riot ID Anda, Contoh : Lapakgaming#1234 <br>\r\n2. Pilih Nominal Points yang kamu inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Points akan ditambahkan ke akun League Of Legends kamu', 'uploads/lol-bg.jpg'),
('G008', 'League of Legends: Wild Rift', 'Cara Top Up <br>\r\n1. Masukkan Riot ID Anda, Contoh : Lapakgaming#1234 <br>\r\n2. Pilih Nominal Points yang kamu inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Points akan ditambahkan ke akun League Of Legends kamu', 'uploads/lolwd-bg.jpg'),
('G009', 'Free Fire', 'Cara Top Up <br>\r\n1. Masukkan User ID Anda <br>\r\n2. Pilih produk yang kamu inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Produk akan ditambahkan ke akun Free Fire kamu', 'uploads/ff-bg.jpg'),
('G010', 'Honkai Star Rail', 'Cara Top Up <br>\r\n1. Masukkan User ID Anda <br>\r\n2. Pilih produk yang Anda inginkan <br>\r\n3. Selesaikan pembayaran <br>\r\n4. Produk akan ditambahkan ke akun Honkai Star Rail kamu', 'uploads/star-rail-bg.jpg');

--
-- Triggers `game`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_game` BEFORE INSERT ON `game` FOR EACH ROW BEGIN
  DECLARE max_id INT(3);
  SET max_id = (SELECT MAX(CAST(SUBSTRING(`gid`, 2) AS UNSIGNED)) FROM `game`);
  SET NEW.`gid` = CONCAT('G', LPAD(COALESCE(max_id + 1, 1), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemid` char(4) NOT NULL,
  `gid` char(4) NOT NULL,
  `item` varchar(40) NOT NULL,
  `price` int(11) NOT NULL,
  `icon` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `gid`, `item`, `price`, `icon`) VALUES
('I001', 'G001', '357 VP', 41000, 'asset/icon/vp-icon.png'),
('I002', 'G001', '650 VP', 68000, 'asset/icon/vp-icon.png'),
('I003', 'G001', '1350 VP', 135000, 'asset/icon/vp-icon.png'),
('I004', 'G001', '2100 VP', 198000, 'asset/icon/vp-icon.png'),
('I005', 'G001', '3600 VP', 324000, 'asset/icon/vp-icon.png'),
('I006', 'G001', '7500 VP', 666000, 'asset/icon/vp-icon.png'),
('I007', 'G002', '170 Diamonds', 43700, 'asset/icon/MLBB_Diamonds.png'),
('I008', 'G002', '240 Diamonds', 62000, 'asset/icon/MLBB_Diamonds.png'),
('I009', 'G002', '296 Diamonds', 76000, 'asset/icon/MLBB_Diamonds.png'),
('I010', 'G002', '408 Diamonds', 104500, 'asset/icon/MLBB_Diamonds.png'),
('I011', 'G002', '568 Diamonds', 142500, 'asset/icon/MLBB_Diamonds.png'),
('I012', 'G002', '875 Diamonds', 218500, 'asset/icon/MLBB_Diamonds.png'),
('I013', 'G003', '325 UC', 80000, 'asset/icon/PUBG_UC.png'),
('I014', 'G003', '660 UC', 158000, 'asset/icon/PUBG_UC.png'),
('I015', 'G003', '1800 UC', 395000, 'asset/icon/PUBG_UC.png'),
('I016', 'G003', '3850 UC', 790000, 'asset/icon/PUBG_UC.png'),
('I017', 'G004', '330 Crystals', 73000, 'asset/icon/Genshin-Impact_Crystals.png'),
('I018', 'G004', '1090 Crystals', 230000, 'asset/icon/Genshin-Impact_Crystals.png'),
('I019', 'G004', '2240 Crystals', 440000, 'asset/icon/Genshin-Impact_Crystals.png'),
('I020', 'G004', '3880 Crystals', 734000, 'asset/icon/Genshin-Impact_Crystals.png'),
('I021', 'G005', '321 CP', 45000, 'asset/icon/CallofDuty_CP.png'),
('I022', 'G005', '645 CP', 90000, 'asset/icon/CallofDuty_CP.png'),
('I023', 'G005', '800 CP', 108000, 'asset/icon/CallofDuty_CP.png'),
('I024', 'G005', '1373 CP', 180180, 'asset/icon/CallofDuty_CP.png'),
('I025', 'G005', '1675 CP', 270270, 'asset/icon/CallofDuty_CP.png'),
('I026', 'G005', '2060 CP', 342000, 'asset/icon/CallofDuty_CP.png'),
('I027', 'G006', '695 Tokens', 97000, 'asset/icon/HOK_Tokens.png'),
('I028', 'G006', '1353 Tokens', 149000, 'asset/icon/HOK_Tokens.png'),
('I029', 'G006', '2724 Tokens', 297000, 'asset/icon/HOK_Tokens.png'),
('I030', 'G006', '4580 Tokens', 489000, 'asset/icon/HOK_Tokens.png'),
('I031', 'G006', '7160 Tokens', 1065000, 'asset/icon/HOK_Tokens.png'),
('I032', 'G006', '4580 Tokens', 1450000, 'asset/icon/HOK_Tokens.png'),
('I033', 'G007', '150 RP', 15200, 'asset/icon/LOL_RP.png'),
('I034', 'G007', '775 RP', 75000, 'asset/icon/LOL_RP.png'),
('I035', 'G007', '1400 RP', 132000, 'asset/icon/LOL_RP.png'),
('I036', 'G007', '2850 RP', 265000, 'asset/icon/LOL_RP.png'),
('I037', 'G007', '5250 RP', 474000, 'asset/icon/LOL_RP.png'),
('I038', 'G007', '10000 RP', 854000, 'asset/icon/LOL_RP.png'),
('I039', 'G008', '105 WildCore', 15000, 'asset/icon/WR_WildCore.png'),
('I040', 'G008', '350 WildCore', 50000, 'asset/icon/WR_WildCore.png'),
('I041', 'G008', '585 WildCore', 80000, 'asset/icon/WR_WildCore.png'),
('I042', 'G008', '1135 WildCore', 150000, 'asset/icon/WR_WildCore.png'),
('I043', 'G008', '1660 WildCore', 210000, 'asset/icon/WR_WildCore.png'),
('I044', 'G008', '3010 WildCore', 360000, 'asset/icon/WR_WildCore.png'),
('I045', 'G008', '6210 WildCore', 750000, 'asset/icon/WR_WildCore.png'),
('I046', 'G009', '140 Diamonds', 18000, 'asset/icon/Freefire_diamonds.png'),
('I047', 'G009', '355 Diamonds', 45000, 'asset/icon/Freefire_diamonds.png'),
('I048', 'G009', '720 Diamonds', 90000, 'asset/icon/Freefire_diamonds.png'),
('I049', 'G009', '1450 Diamonds', 180000, 'asset/icon/Freefire_diamonds.png'),
('I050', 'G009', '2180 Diamonds', 270000, 'asset/icon/Freefire_diamonds.png'),
('I051', 'G009', '3640 Diamonds', 450000, 'asset/icon/Freefire_diamonds.png'),
('I052', 'G010', '60 Oneiric Shard', 14000, 'asset/icon/hsr_shard.png'),
('I053', 'G010', '330 Oneiric Shard', 71000, 'asset/icon/hsr_shard.png'),
('I054', 'G010', '1090 Oneiric Shard', 224000, 'asset/icon/hsr_shard.png'),
('I055', 'G010', '2240 Oneiric Shard', 431000, 'asset/icon/hsr_shard.png'),
('I056', 'G010', '3880 Oneiric Shard', 719000, 'asset/icon/hsr_shard.png');

--
-- Triggers `item`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_item` BEFORE INSERT ON `item` FOR EACH ROW BEGIN
  DECLARE max_id INT(3);
  SET max_id = (SELECT MAX(CAST(SUBSTRING(`itemid`, 2) AS UNSIGNED)) FROM `item`);
  SET NEW.`itemid` = CONCAT('I', LPAD(COALESCE(max_id + 1, 1), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pid` char(4) NOT NULL,
  `method` varchar(40) NOT NULL,
  `number` int(40) NOT NULL,
  `logo` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pid`, `method`, `number`, `logo`) VALUES
('P001', 'BCA Virtual Account', 12345678, 'asset/payment/bca.png'),
('P002', 'BRI Virtual Account', 32145678, 'asset/payment/BRI.png'),
('P003', 'BNI Virtual Account', 12365478, 'asset/payment/bni.png'),
('P004', 'Dana', 12345687, 'asset/payment/dana.png'),
('P005', 'OVO', 87654321, 'asset/payment/ovo.png');

--
-- Triggers `payment`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_payment` BEFORE INSERT ON `payment` FOR EACH ROW BEGIN
  DECLARE max_id INT(3);
  SET max_id = (SELECT MAX(CAST(SUBSTRING(`pid`, 2) AS UNSIGNED)) FROM `payment`);
  SET NEW.`pid` = CONCAT('P', LPAD(COALESCE(max_id + 1, 1), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tid` char(32) NOT NULL,
  `uid` char(4) DEFAULT NULL,
  `pid` char(4) NOT NULL,
  `gid` char(4) NOT NULL,
  `itemid` char(4) NOT NULL,
  `wa number` int(11) DEFAULT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_transaction` BEFORE INSERT ON `transaction` FOR EACH ROW BEGIN
  DECLARE max_id INT(3);
  SET max_id = (SELECT MAX(CAST(SUBSTRING(`tid`, 2) AS UNSIGNED)) FROM `transaction`);
  SET NEW.`tid` = CONCAT('T', LPAD(COALESCE(max_id + 1, 1), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` char(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `role` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `email`, `password`, `role`) VALUES
('U001', 'admin', 'admin@admin.co.id', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
('U002', 'alice', 'alice@example.com', '6384e2b2184bcbf58eccf10ca7a6563c', 'user'),
('U003', 'John Doe', 'Johndoe@example.com', '$2y$10$IUJL9t0yxyOhGFeIs6.dCOOA5', 'user'),
('U004', 'wizz', 'wizz@wizz.co.id', '$2y$10$bwo2yg.Am5GRNTgkNNJvb.ZQh', 'user'),
('U005', 'admin2', 'admin21@admin.co.id', 'c84258e9c39059a89ab77d846ddab909', 'admin');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `role` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    IF NEW.role IS NULL OR NEW.role = '' THEN
        SET NEW.role = 'user';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_before_insert_user` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
  DECLARE max_id INT(3);
  SET max_id = (SELECT MAX(CAST(SUBSTRING(`uid`, 2) AS UNSIGNED)) FROM `user`);
  SET NEW.`uid` = CONCAT('U', LPAD(COALESCE(max_id + 1, 1), 3, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `gid` (`gid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `gid` (`gid`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `game` (`gid`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`gid`) REFERENCES `game` (`gid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`itemid`) REFERENCES `item` (`itemid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`pid`) REFERENCES `payment` (`pid`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
