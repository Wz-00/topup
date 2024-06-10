-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 04:01 PM
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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
