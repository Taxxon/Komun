-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 19 dec 2017 kl 14:53
-- Serverversion: 10.1.26-MariaDB
-- PHP-version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `komun`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `anslagstavla`
--

CREATE TABLE `anslagstavla` (
  `id` int(10) UNSIGNED NOT NULL,
  `sammantrade` date NOT NULL,
  `uppsattdatum` date NOT NULL,
  `titel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `organ` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `stub` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ansvarig` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `forvaringsplats` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `anslagstavla`
--

INSERT INTO `anslagstavla` (`id`, `sammantrade`, `uppsattdatum`, `titel`, `organ`, `stub`, `ansvarig`, `pdf`, `forvaringsplats`) VALUES
(5, '2017-01-01', '2017-01-01', 'Taxxon', 'Brattfors', 'HEllo ', 'Emil Käck', 'emil.pdf', 'Nordmaling'),
(6, '2017-01-01', '2017-01-01', 'Taxxon', 'Brattfors', 'HEllo ', 'Emil Käck', 'emil.pdf', 'Nordmaling'),
(7, '2017-01-01', '2017-01-01', 'DWA', 'dwa', 'dwa', 'dw', 'dwadwa', 'dwa'),
(8, '2017-01-01', '2017-01-01', 'DWA', 'dwa', 'dwa', 'dw', 'dwadwa', 'dwa');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `anslagstavla`
--
ALTER TABLE `anslagstavla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sammanträde` (`sammantrade`),
  ADD KEY `titel` (`titel`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `anslagstavla`
--
ALTER TABLE `anslagstavla`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
