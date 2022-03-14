-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 14, 2022 at 08:39 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listitem`
--

CREATE TABLE `listitem` (
  `id` int(11) NOT NULL,
  `listId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listitem`
--

INSERT INTO `listitem` (`id`, `listId`, `name`, `content`, `priority`, `status`, `duration`) VALUES
(27, 13, 'Brainstormen over spel softskills', 'Brainstormen over het bordspel van het vak softskills', 1, 1, 420),
(29, 17, 'ping ping de vis', 'uitleg ping ping', 3, 1, 10),
(30, 17, 'Roghar', 'uitleg roghar', 2, 0, 15),
(32, 19, 'hallo', 'bleh', 1, 1, 77777),
(33, 23, 'cool', 'Airto is Blijkbaar niet koel maar Cool', 1, 1, 100),
(34, 28, 'f', 'fh', 3, 1, 3),
(35, 28, 'f', 'fh', 3, 1, 3),
(36, 28, 'f', 'fh', 3, 1, 3),
(37, 29, 'Ron', 'text', 6, 1, 3),
(38, 29, 'regerg', '4444', 4, 0, 4),
(39, 34, 'Item', 'rfr', 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listitem`
--
ALTER TABLE `listitem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `listitem`
--
ALTER TABLE `listitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
