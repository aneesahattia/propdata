-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2018 at 08:45 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `special_offers`
--

CREATE TABLE `special_offers` (
  `so_id` int(11) NOT NULL,
  `so_title` varchar(255) NOT NULL,
  `so_desc` varchar(255) NOT NULL,
  `so_image_src` varchar(255) NOT NULL,
  `so_status` int(1) NOT NULL,
  `so_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `special_offers`
--

INSERT INTO `special_offers` (`so_id`, `so_title`, `so_desc`, `so_image_src`, `so_status`, `so_datetime`) VALUES
(1, 'test', 'test', 'images/britain.jpg', 1, '2018-04-15 06:25:14'),
(2, 'test', 'test', 'images/britain.jpg', 1, '2018-04-15 06:30:29'),
(3, 'test', 'test', 'images/britain.jpg', 1, '2018-04-15 06:30:38'),
(4, 'test', 'test', 'images/britain.jpg', 1, '2018-04-15 06:30:44'),
(5, '', '', 'images/Mauritius8.jpg', 1, '2018-04-15 06:36:57'),
(6, 'test', 'test', 'images/sport_tourism4_2.jpg', 1, '2018-04-15 06:37:26'),
(7, 'test', 'test', 'images/britain.jpg', 1, '2018-04-15 06:53:17'),
(8, 'test', 'test', 'images/britain.jpg', 1, '2018-04-15 06:53:32'),
(9, 'test', 'test', 'images/Mauritius8.jpg', 1, '2018-04-15 06:54:20'),
(10, 'test', 'test', 'images/Mozambique2.jpg', 1, '2018-04-15 06:56:23'),
(11, 'test-final', 'TEST-FINAL', '/images/download.jpg', 1, '2018-04-15 07:15:33'),
(12, 'test - final 2', 'test - final 2', '/images/download.jpg', 1, '2018-04-15 07:22:09'),
(13, 'test - final 3 - updated', 'test - final 3- updated', '../images/download.jpg', 1, '2018-04-15 07:27:34'),
(14, 'this is a final test ', 'this is a final test ', '../images/download.jpg', 1, '2018-04-15 08:22:58'),
(15, 'this is a final test - 2', 'this is a final test - 2', '../images/drivers lic.JPG', 1, '2018-04-15 08:29:15'),
(16, 'this is a final test - 3', 'this is a final test - 3', '../images/lic disc.JPG', 1, '2018-04-15 08:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rights` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rights`) VALUES
(1, 'aneesahattia@gmail.com', 'cTF3MmUz', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `special_offers`
--
ALTER TABLE `special_offers`
  ADD PRIMARY KEY (`so_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `special_offers`
--
ALTER TABLE `special_offers`
  MODIFY `so_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
