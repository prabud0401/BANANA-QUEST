-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 12:02 PM
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
-- Database: `banana_quest`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'dhushy0401@gmail.com', 'dhushy0401@gmail.com', '$2y$10$Uces0lvuzZOzm7MhWEXtSecOZZjlIImA9QRIzZyezpAZnHDiEcf5q', '2025-03-28 07:11:00'),
(2, 'Admin@gmail.com', 'Admin@gmail.com', '$2y$10$AkpuWDwUS.Qh0OJUL.RnHON1JxtrfkmC1wzVUMA1Rhn9E0YUxGNzW', '2025-03-28 07:15:11'),
(5, 'dmin@gmail.com', 'dmin@gmail.com', '$2y$10$/TknQlO8uey6o20q.sYzw.gWJQzGDQMsQFP9RTMmpO34dIOv6GuiW', '2025-03-28 07:18:32'),
(6, 'prabud0401@gmail.com', 'prabud0401@gmail.com', 'prabud0401@gmail.com', '2025-03-28 07:27:08'),
(7, 'asdmin@gmail.com', 'asdmin@gmail.com', 'asdmin@gmail.com', '2025-03-28 07:30:53'),
(8, 'asddmin@gmail.com', 'asddmin@gmail.com', 'asddmin@gmail.com', '2025-03-28 07:36:17'),
(9, 'asdddmin@gmail.com', 'asdddmin@gmail.com', 'asdddmin@gmail.com', '2025-03-28 07:38:51'),
(10, 'asddddmin@gmail.com', 'asddddmin@gmail.com', 'asddddmin@gmail.com', '2025-03-28 07:42:45'),
(11, 'asddaddddmin@gmail.com', 'asddaddddmin@gmail.com', 'asddaddddmin@gmail.com', '2025-03-28 07:45:35'),
(12, 'asddadddddmin@gmail.com', 'asddadddddmin@gmail.com', '$2y$10$h20bqA4gODUKWd/eHe3G4etz8LmxQ0YYD0VksLMXaAAt5oe5j5xsq', '2025-03-28 07:46:31'),
(13, 'prabu@gmail.com', 'prabu@gmail.com', '$2y$10$6xazO80GVXolj1H5qyheJecVQFnOFbP1KNt5naGoTpiRcwWWSXPXa', '2025-03-28 07:50:00'),
(14, 'bdmin@gmail.com', 'bdmin@gmail.com', '$2y$10$RgS9ufXrhjRUVemMVmASf.lvXItzmIUYWGz6KMXcOgNuW51vJIIiq', '2025-03-28 07:55:47'),
(15, 'hushy0401@gmail.com', 'hushy0401@gmail.com', '$2y$10$k.Yldj3ipabcpJKpWDLQF.q.p6Z9GogxA37TPOS5dXLwjuhqWKh/i', '2025-03-28 08:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE `user_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `score` int(11) DEFAULT 0,
  `details` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`id`, `user_id`, `action`, `score`, `details`, `timestamp`) VALUES
(1, 1, 'Collected Banana', 50, 'Level 1 - Jungle Swing', '2025-03-28 03:45:23'),
(2, 1, 'Defeated Monkey Boss', 200, 'Level 2 - Boss Fight', '2025-03-28 05:00:45'),
(3, 1, 'Found Hidden Treasure', 100, 'Level 3 - Secret Cave', '2025-03-28 06:15:12'),
(4, 1, 'Completed Level', 150, 'Level 1 - Full Clear', '2025-03-28 06:40:30'),
(5, 1, 'Lost a Life', -25, 'Level 2 - Trap Fall', '2025-03-28 07:35:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
