-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2025 at 07:32 PM
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
-- Database: `quiz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `player_form`
--

CREATE TABLE `player_form` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `score` int(11) DEFAULT 0,
  `highest_level` int(11) DEFAULT 1,
  `total_correct` int(11) DEFAULT 0,
  `total_played` int(11) DEFAULT 0,
  `last_played` timestamp NOT NULL DEFAULT current_timestamp(),
  `rank` int(11) NOT NULL,
  `games_played` int(11) NOT NULL DEFAULT 0,
  `games_won` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_form`
--

INSERT INTO `player_form` (`id`, `username`, `password`, `score`, `highest_level`, `total_correct`, `total_played`, `last_played`, `rank`, `games_played`, `games_won`) VALUES
(1, 'dhushy0401@gmail.com', 'a5a44ae688dd206e6dfdcb19c4910de5', 30, 1, 0, 0, '2025-03-15 17:25:08', 1, 11, 0),
(2, 'mohamedinaaz1@gmail.com', '779916eed0027f18a5a4dce50eee5861', 30, 1, 0, 0, '2025-03-15 18:03:05', 2, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `player_form`
--
ALTER TABLE `player_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `player_form`
--
ALTER TABLE `player_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
