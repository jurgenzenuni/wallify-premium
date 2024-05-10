-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 03:45 PM
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
-- Table structure for table `search_logs`
--

CREATE TABLE `search_logs` (
  `id` int(11) NOT NULL,
  `search_term` varchar(255) NOT NULL,
  `search_count` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_logs`
--

INSERT INTO `search_logs` (`id`, `search_term`, `search_count`) VALUES
(1, 'mercedes', 41),
(3, 'mountains night time', 1),
(5, 'mountains', 30),
(6, 'dog', 10),
(8, 'bmw', 16),
(9, 'new york', 20),
(13, 'beach', 6),
(33, 'italy', 8),
(34, 'free wallpapers', 415),
(38, 'boat on lake', 1),
(41, 'nature images', 1),
(42, 'nature', 1),
(73, 'italu', 1),
(82, 'sports car', 27),
(85, 'dodge viper', 1),
(87, 'supra', 1),
(93, 'supercar', 1),
(95, 'ford mustang gt', 1),
(96, 'mustang', 1),
(98, 'cars', 1),
(99, 'sportscars', 1),
(100, 'sportscar', 1),
(101, 'sports cars', 1),
(106, 'dodge', 1),
(108, 'red cars', 3),
(222, 'hacker', 1),
(225, 'manhattan', 1),
(255, 'black dog', 2),
(259, '4k wallpapers', 43),
(265, 'porsche', 3),
(279, 'china', 1),
(280, 'india', 1),
(281, 'greece', 1),
(282, 'albania', 1),
(283, 'los angeles', 1),
(294, 'audi', 1),
(297, '4k wallpaper', 15),
(299, 'green leaves', 1),
(309, 'black and whites trees', 1),
(310, 'black and white trees', 1),
(311, 'trees', 1),
(432, 'new york city', 3),
(439, 'kitty', 1),
(440, 'cat ', 1),
(443, 'anime', 1),
(444, 'naruto', 1),
(471, 'ita', 1),
(490, 'toys', 1),
(491, 'sunrise', 1),
(492, 'sunset', 2),
(497, 'lambo', 77),
(577, 'red car', 1),
(580, 'black ocean', 1),
(611, 'muscle car', 37),
(705, 'AI generated', 12),
(712, 'ai', 2),
(714, 'number 7', 1),
(740, 'valorant', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `search_logs`
--
ALTER TABLE `search_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `search_term` (`search_term`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `search_logs`
--
ALTER TABLE `search_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=812;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
