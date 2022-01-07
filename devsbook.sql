-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 05, 2022 at 03:30 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devsbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postcomments`
--

INSERT INTO `postcomments` (`id`, `id_user`, `id_post`, `created_at`, `body`) VALUES
(1, 2, 1, '2022-01-04 18:02:33', 'teste'),
(2, 2, 1, '2022-01-04 19:08:33', 'comentando atráves do treco'),
(3, 2, 1, '2022-01-04 19:19:10', 'este'),
(4, 2, 1, '2022-01-04 19:37:30', 'testando, vai popr facorr'),
(5, 2, 1, '2022-01-04 19:43:00', 'juuj'),
(6, 2, 8, '2022-01-04 19:44:33', 'vai pvf'),
(7, 2, 3, '2022-01-04 19:50:12', 'comenta'),
(8, 2, 3, '2022-01-04 20:54:03', 'undefined'),
(9, 2, 8, '2022-01-04 21:11:36', 'comentando no botão'),
(10, 2, 6, '2022-01-04 21:12:29', 'comentando com enter'),
(11, 2, 6, '2022-01-04 21:12:36', 'comentando com botão'),
(12, 2, 10, '2022-01-04 22:01:50', 'hahaha o pai tem o messi'),
(13, 2, 10, '2022-01-04 23:01:12', 'janete feia');

-- --------------------------------------------------------

--
-- Table structure for table `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postlikes`
--

INSERT INTO `postlikes` (`id`, `id_user`, `id_post`, `created_at`) VALUES
(1, NULL, 1, '2022-01-04 17:52:45'),
(2, NULL, 1, '2022-01-04 17:52:52'),
(3, 2, 1, '2022-01-04 17:56:35'),
(5, 2, 10, '2022-01-04 23:01:16'),
(6, 2, 9, '2022-01-04 23:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `id_author` int(11) DEFAULT NULL,
  `typ` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `id_author`, `typ`, `created_at`, `body`) VALUES
(1, 2, 'text', '2022-01-01 23:28:56', 'Fazendo o primeiro post do sistema'),
(2, 2, 'text', '2022-01-01 19:32:15', 'Fazendo o segundo post'),
(3, 2, 'text', '2022-01-01 19:34:04', 'a'),
(6, 2, 'photo', '2022-01-01 21:27:00', '1.jpg'),
(8, 5, 'text', '2022-01-01 21:32:18', 'Primeiro teste'),
(9, 2, 'photo', '2022-01-04 21:54:04', '2f2484773f083eb38779320a1da01ead.jpg'),
(10, 2, 'photo', '2022-01-04 21:55:02', '758326c99284e40bfc84eb6052c55baf.jpg'),
(14, 2, 'photo', '2022-01-04 23:10:39', 'e34865a2db60637d3e1e8f25413a31ed.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `userrelations`
--

CREATE TABLE `userrelations` (
  `id` int(11) NOT NULL,
  `user_from` int(11) DEFAULT NULL,
  `user_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(3, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `pass`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
(2, 'Diego Jacober', 'diegoalencar.jacober@gmail.com', '$2y$10$2IUaReaza/MaDMiDPTQJauce29K.m/CGYD3kNBPIeG1W5otpMCS7m', '2004-12-29', 'Monte Mor', '', '6d16a8ddf46163036416e9e3b81d60c3.jpg', '936c2d27a0c41ae234c818c562f5c3b2.jpg', 'd5bfff35b3a7bee5b9c3c4dc16252620'),
(5, 'José  miguel', 'alencar.miguel@gmail.com', '$2y$10$f6BHLQ6eiBdO/ZuT9KNOeeHNK/KTJBWGXT8sP9HluXiewHywdVHua', '1983-06-17', '', '', 'avatar.jpg', 'cover.jpg', '4643b7093c42d994fa57e5e47e8487e2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Indexes for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_author` (`id_author`);

--
-- Indexes for table `userrelations`
--
ALTER TABLE `userrelations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_from` (`user_from`),
  ADD KEY `fk_user_to` (`user_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `userrelations`
--
ALTER TABLE `userrelations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD CONSTRAINT `postcomments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `postcomments_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD CONSTRAINT `postlikes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `postlikes_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`);

--
-- Constraints for table `userrelations`
--
ALTER TABLE `userrelations`
  ADD CONSTRAINT `fk_user_from` FOREIGN KEY (`user_from`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_to` FOREIGN KEY (`user_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
