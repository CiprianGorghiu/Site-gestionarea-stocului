-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 17, 2023 at 01:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_stoc`
--

CREATE TABLE `backup_stoc` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocProdus` int(11) NOT NULL,
  `Pret` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `StocNou` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barmanstoc`
--

CREATE TABLE `barmanstoc` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocProdus` int(11) NOT NULL,
  `Pret` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numebarman` varchar(255) NOT NULL,
  `Validare` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `ID` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `actiune` varchar(255) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `raportbarman`
--

CREATE TABLE `raportbarman` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocInitial` int(11) NOT NULL,
  `StocPredat` int(11) NOT NULL,
  `numebarman` varchar(255) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stoc`
--

CREATE TABLE `stoc` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocProdus` int(11) NOT NULL,
  `StocNou` int(11) NOT NULL,
  `StocPrecedent` int(11) NOT NULL,
  `pret` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocfinal`
--

CREATE TABLE `stocfinal` (
  `ID` int(11) NOT NULL,
  `numebarman` varchar(255) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocPrecedent` int(11) NOT NULL,
  `StocActual` int(11) NOT NULL,
  `PretProdus` int(11) NOT NULL,
  `Pret` int(11) NOT NULL,
  `PretTotal` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `barman` int(11) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_stoc`
--
ALTER TABLE `backup_stoc`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `barmanstoc`
--
ALTER TABLE `barmanstoc`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `raportbarman`
--
ALTER TABLE `raportbarman`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stoc`
--
ALTER TABLE `stoc`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stocfinal`
--
ALTER TABLE `stocfinal`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_stoc`
--
ALTER TABLE `backup_stoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barmanstoc`
--
ALTER TABLE `barmanstoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `raportbarman`
--
ALTER TABLE `raportbarman`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stoc`
--
ALTER TABLE `stoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocfinal`
--
ALTER TABLE `stocfinal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
