-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 10:08 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adapt`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` bigint(100) UNSIGNED NOT NULL,
  `patient_fname` text NOT NULL,
  `patient_lname` text NOT NULL,
  `patient_bday` date NOT NULL,
  `patient_desc` text NOT NULL,
  `patient_address` text NOT NULL,
  `patient_city` text NOT NULL,
  `patient_province` text NOT NULL,
  `patient_postalcode` int(100) NOT NULL,
  `patient_country` text NOT NULL,
  `patient_maxdistance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `firstname`, `lastname`, `email`, `user_id`, `code`) VALUES
(1, 'Admin', 'Admin', 'aeinsgaming@gmail.com', 1, 0),
(2, 'Kirk Xavier', 'Potenciano', 'kxpotenciano@gmail.com', 2, 0),
(3, 'Cristina', 'Agravante', 'ninaagravantewol@gmail.com', 3, 388498);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$zpk0Zz3kGLIaDXc0OwBrLOlV5rN3Gs6k.oZlZXiGzV4NU4fi3bzgi'),
(2, 'kxpotenciano', '$2y$10$C9CyyCUzMCm2b.gUx6YGxOU3asgomYVhpUougXkDk.b0SLg4FJUeG'),
(3, 'cristina', '$2y$10$BBTi9DjcacCSyfpAC.DsVuM7U6SUM0Fvh71fDIkho4pIiaQf/PDPq');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_data`
-- (See below for the actual view)
--
CREATE TABLE `user_data` (
`id` bigint(20) unsigned
,`username` varchar(16)
,`firstname` varchar(60)
,`lastname` varchar(60)
,`email` varchar(60)
);

-- --------------------------------------------------------

--
-- Structure for view `user_data`
--
DROP TABLE IF EXISTS `user_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_data`  AS SELECT `users`.`id` AS `id`, `users`.`username` AS `username`, `profile`.`firstname` AS `firstname`, `profile`.`lastname` AS `lastname`, `profile`.`email` AS `email` FROM (`users` join `profile` on(`users`.`id` = `profile`.`user_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` bigint(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `profile_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
