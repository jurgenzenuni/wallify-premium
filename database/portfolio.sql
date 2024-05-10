-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 03:44 PM
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
-- Database: `wallify`
--

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `image_id`, `username`) VALUES
(1, 36, 'user1'),
(2, 21132, 'jurgenzenuni'),
(3, 5694, 'jurgenzenuni'),
(4, 60, 'jurgenzenuni'),
(5, 103, 'jurgenzenuni'),
(6, 109972, 'jurgenzenuni'),
(10, 12, 'Mikelin814'),
(11, 25, 'Mikelin814'),
(12, 1320, 'Mikelin814'),
(13, 109972, 'Mikelin814'),
(14, 12, 'Mikelin814'),
(16, 99, 'Mikelin814'),
(17, 79, 'Mikelin814'),
(18, 67, 'Mikelin814'),
(19, 103, 'Mikelin814'),
(21, 37, 'Mikelin814'),
(23, 107, 'jurgenzenuni'),
(25, 109975, 'jurgenzenuni'),
(26, 65, 'jurgenzenuni'),
(27, 109977, 'jurgenzenuni'),
(28, 12, ''),
(29, 1584, 'jurgenzenuni'),
(31, 111024, 'jurgenzenuni'),
(32, 185, 'jurgenzenuni'),
(33, 17, 'Mikelin814'),
(35, 2179, 'jurgenzenuni'),
(39, 111026, 'jurgenzenuni'),
(40, 9796, 'jurgenzenuni'),
(41, 11, 'jurgenzenuni'),
(45, 111057, 'jurgenzenuni'),
(49, 1992, 'jurgenzenuni'),
(50, 1414, 'jurgenzenuni'),
(52, 111032, 'jurgenzenuni'),
(54, 111043, 'jurgenzenuni'),
(55, 6726, 'Mikelin814'),
(57, 111031, 'Mikelin814'),
(59, 111032, 'Mikelin814'),
(62, 111053, 'Mikelin814'),
(63, 17786, 'Mikelin814'),
(64, 111047, 'Mikelin814'),
(66, 25227, 'Mikelin814'),
(67, 8345, 'Mikelin814'),
(69, 7926, 'Mikelin814'),
(70, 111050, 'Mikelin814'),
(71, 111026, 'Mikelin814'),
(74, 111037, 'jurgenzenuni'),
(77, 111061, 'jurgenzenuni'),
(79, 111055, 'JurgenZenuni7'),
(80, 111052, 'JurgenZenuni7'),
(81, 111064, 'kon97'),
(82, 111062, 'kon97'),
(83, 111060, 'kon97'),
(84, 111061, 'kon97'),
(85, 746, 'kon97'),
(86, 1030, 'kon97'),
(87, 111052, 'jurgenzenuni'),
(88, 11047, 'jurgenzenuni7'),
(89, 1972, 'jurgenzenuni7'),
(90, 15961, 'jurgenzenuni7'),
(91, 1993, 'jurgenzenuni7'),
(92, 1417, 'jurgenzenuni7'),
(93, 9595, 'jurgenzenuni7'),
(94, 1369, 'jurgenzenuni'),
(95, 1276, 'jurgenzenuni'),
(97, 6502, 'jurgenzenuni'),
(98, 22029, 'jurgenzenuni'),
(99, 111050, 'soonchun1'),
(100, 111059, 'soonchun1'),
(101, 914, 'jurgenzenuni'),
(102, 111068, 'Mikelin814'),
(103, 111074, 'jurgenzenuni'),
(104, 111076, 'Kon97');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_id` (`image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `free_img` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
