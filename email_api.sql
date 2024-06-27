-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 04:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `email_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `recipient`, `subject`, `body`, `sent_at`) VALUES
(1, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 13:56:10'),
(2, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 13:57:44'),
(3, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:10:16'),
(4, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:10:41'),
(5, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:11:29'),
(6, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:11:48'),
(7, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:12:09'),
(8, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:12:24'),
(9, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:13:14'),
(10, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:21:21'),
(11, 'muchamad.arvan27@gmail.com', 'Test Subject', 'HALLO HALLO HALLO HALLO', '2024-06-26 14:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  `expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `revoked` tinyint(1) NOT NULL,
  `scopes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `client_id`, `user_id`, `expiry`, `revoked`, `scopes`) VALUES
('5e0ea313137017cfaf5265f68f6109e7c10fe41d5e1ee2480aad70140a27f824ba92717e7d7d9ac9', '1', NULL, '2024-06-26 08:03:04', 0, ''),
('8a3276a9b4dd24d3a7c39ffbd31bfe3371dea7f52efdc2ad7382a19eaa41aa401504ba56e1afc799', '1', NULL, '2024-06-26 08:07:07', 0, ''),
('b8788a1b2841e9cde65ce7ea9254e1e4bff2f73fc50bdf5bf5861fe754557dd55bf3826719974982', '1', NULL, '2024-06-26 08:17:05', 0, ''),
('bfac629f9b65647d44768f5a1536db86f4bfd6ed50641b8ee20e8ed49266cffe19eee60403aa49a7', '1', NULL, '2024-06-26 08:16:30', 0, ''),
('c51c846127101313a1048fa71f18ccc5b51305f802bd4974a3c2dd9eb859ee8b7e1ecfe4da9b0ef4', '1', NULL, '2024-06-26 08:38:46', 0, ''),
('da73b8dbd823a514bd062a56bd47af31941b107c628f3cb60c3a26098fb650d6135b417b1ea2d57b', '1', NULL, '2024-06-26 08:00:37', 0, ''),
('ed3fb934a65ca98ce8d1786f0b1f319a4769c0f4c62677417bb607e1075385c8810bb2fb62fdb81f', '1', NULL, '2024-06-26 09:54:07', 0, ''),
('f784a50c5b64721b0c4aec06b7b722d46f12a48d7fb4715da99ef38d340cbe0e01c6ed56f7114dd5', '1', NULL, '2024-06-26 08:16:37', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` varchar(80) NOT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(80) NOT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `is_confidential` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `name`, `secret`, `redirect_uri`, `is_confidential`) VALUES
('1', 'Test Client', '$2y$10$cm6vaMogfUeV6e0SUJVgM.Cmq5izUjNKgWuWx4.kT8XidKvXM2B8G', 'http://localhost/callback', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `id` varchar(80) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD CONSTRAINT `oauth_access_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
