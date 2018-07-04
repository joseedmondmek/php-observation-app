-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2018 at 07:15 AM
-- Server version: 5.6.31
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `observations_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `observations`
--

CREATE TABLE IF NOT EXISTS `observations` (
  `id` int(10) unsigned NOT NULL,
  `observation` text NOT NULL,
  `specie` varchar(255) NOT NULL,
  `gps_coord1` decimal(10,6) NOT NULL,
  `gps_coord2` decimal(10,6) NOT NULL,
  `created_on` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `observations`
--

INSERT INTO `observations` (`id`, `observation`, `specie`, `gps_coord1`, `gps_coord2`, `created_on`, `user_id`) VALUES
(1, 'pomm 2', 'Cuttlefish', 12.000000, 48.000000, '2018-07-04 01:35:30', 1),
(2, 'try another one  numer 2', 'Cuttlefish', 45.350000, 54.356900, '2018-07-04 01:36:01', 1),
(3, 'My personal observation is for me alone to modify.', 'Cuttlefish', 12.220000, 12.588800, '2018-07-04 06:55:17', 2),
(5, 'i hate Cuttlefish', 'Cuttlefish', 12.000000, 44.000000, '2018-07-04 06:56:19', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'john', '$2y$10$L.KW04Jmgs.gOmfxpBlbU.HeC8vRiN/lNE9t.FN6ZbflpIsTCc0Ci'),
(2, 'peter', '$2y$10$FM.kIIDFF.V8hqFqDrAjSOSByx6upfZOU2AwPzK7vzC6FEiMflh5O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `observations`
--
ALTER TABLE `observations`
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
-- AUTO_INCREMENT for table `observations`
--
ALTER TABLE `observations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
