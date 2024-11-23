-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost
-- Timp de generare: nov. 23, 2024 la 06:50 PM
-- Versiune server: 10.4.28-MariaDB
-- Versiune PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `test`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `Authenticate`
--

CREATE TABLE `Authenticate` (
  `Password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `Authenticate`
--

INSERT INTO `Authenticate` (`Password`) VALUES
('Pa$$w0rd');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `backup_stoc`
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
-- Structură tabel pentru tabel `barmanstoc`
--

CREATE TABLE `barmanstoc` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocProdus` int(11) NOT NULL,
  `Pret` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numebarman` varchar(255) NOT NULL,
  `Validare` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Eliminarea datelor din tabel `barmanstoc`
--

INSERT INTO `barmanstoc` (`ID`, `NumeProdus`, `StocProdus`, `Pret`, `data`, `numebarman`, `Validare`) VALUES
(3, 'Coca-Cola', 100, 9, '2024-11-23 17:39:13', 'Admin', 0),
(4, 'Fanta', 100, 9, '2024-11-23 17:39:21', 'Admin', 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `Inventar`
--

CREATE TABLE `Inventar` (
  `ID` int(11) NOT NULL,
  `Produs` varchar(250) NOT NULL,
  `Cantitate` int(11) NOT NULL,
  `UM` text NOT NULL,
  `DATA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `logs`
--

CREATE TABLE `logs` (
  `ID` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `actiune` varchar(255) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Eliminarea datelor din tabel `logs`
--

INSERT INTO `logs` (`ID`, `nume`, `actiune`, `data`) VALUES
(1, 'test', 'a adaugat 100 bucati din produsul Fanta în stoc', '2024-11-23 16:37:37'),
(2, 'test', 'a adaugat 100 bucati din produsul Pepsi în stoc', '2024-11-23 16:37:57'),
(3, 'test', ' s-a deconectat de pe cont!', '2024-11-23 16:38:12'),
(4, 'barman', ' s-a autentificat!', '2024-11-23 16:38:16'),
(5, 'barman', 'predat stocul', '2024-11-23 17:38:28'),
(6, 'barman', ' s-a deconectat de pe cont!', '2024-11-23 16:38:31'),
(7, 'test', ' s-a autentificat!', '2024-11-23 16:38:37'),
(8, 'test', 'a sters produsul Fanta din stoc', '2024-11-23 16:39:01'),
(9, 'test', 'a sters produsul Pepsi din stoc', '2024-11-23 16:39:04'),
(10, 'test', 'a adaugat 100 bucati din produsul Coca-Cola în stoc', '2024-11-23 16:39:13'),
(11, 'test', 'a adaugat 100 bucati din produsul Fanta în stoc', '2024-11-23 16:39:21'),
(12, 'test', ' s-a deconectat de pe cont!', '2024-11-23 16:39:23'),
(13, 'test', ' s-a autentificat!', '2024-11-23 16:39:27'),
(14, 'test', ' s-a deconectat de pe cont!', '2024-11-23 16:39:29'),
(15, 'barman', ' s-a autentificat!', '2024-11-23 16:39:33'),
(16, 'barman', 'predat stocul', '2024-11-23 17:39:38'),
(17, 'barman', ' s-a deconectat de pe cont!', '2024-11-23 16:39:39'),
(18, 'test', ' s-a autentificat!', '2024-11-23 16:39:44'),
(19, 'test', ' s-a deconectat de pe cont!', '2024-11-23 16:45:36'),
(20, 'barman', ' s-a autentificat!', '2024-11-23 16:45:42'),
(21, 'barman', 'predat stocul', '2024-11-23 17:45:45'),
(22, 'barman', ' s-a deconectat de pe cont!', '2024-11-23 16:45:46'),
(23, 'test', ' s-a autentificat!', '2024-11-23 16:45:49'),
(24, 'test', ' s-a deconectat de pe cont!', '2024-11-23 16:47:57'),
(25, 'barman', ' s-a autentificat!', '2024-11-23 16:48:02'),
(26, 'barman', 'predat stocul', '2024-11-23 17:48:11'),
(27, 'barman', ' s-a deconectat de pe cont!', '2024-11-23 16:48:12'),
(28, 'test', ' s-a autentificat!', '2024-11-23 16:48:16'),
(29, 'test', ' s-a deconectat de pe cont!', '2024-11-23 16:48:38'),
(30, 'barman', ' s-a autentificat!', '2024-11-23 16:48:41'),
(31, 'barman', 'predat stocul', '2024-11-23 17:48:47'),
(32, 'barman', ' s-a deconectat de pe cont!', '2024-11-23 16:48:48'),
(33, 'test', ' s-a autentificat!', '2024-11-23 16:48:56');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `raportbarman`
--

CREATE TABLE `raportbarman` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocInitial` int(11) NOT NULL,
  `StocPredat` int(11) NOT NULL,
  `numebarman` varchar(255) NOT NULL,
  `PretProdus` int(11) NOT NULL,
  `Tura` varchar(255) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Eliminarea datelor din tabel `raportbarman`
--

INSERT INTO `raportbarman` (`ID`, `NumeProdus`, `StocInitial`, `StocPredat`, `numebarman`, `PretProdus`, `Tura`, `data`) VALUES
(1, 'Coca-Cola', 78, 23, 'barman', 9, 'Tura de seara', '2024-11-23 17:45:45'),
(2, 'Fanta', 87, 23, 'barman', 9, 'Tura de seara', '2024-11-23 17:45:45'),
(3, 'Coca-Cola', 23, 99, 'barman', 9, 'Tura de seara', '2024-11-23 17:48:11'),
(4, 'Fanta', 23, 99, 'barman', 9, 'Tura de seara', '2024-11-23 17:48:11'),
(5, 'Coca-Cola', 99, 8, 'barman', 9, 'Tura de seara', '2024-11-23 17:48:47'),
(6, 'Fanta', 99, 8, 'barman', 9, 'Tura de seara', '2024-11-23 17:48:47');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `stoc`
--

CREATE TABLE `stoc` (
  `ID` int(11) NOT NULL,
  `NumeProdus` varchar(255) NOT NULL,
  `StocProdus` int(11) NOT NULL,
  `StocNou` int(11) NOT NULL DEFAULT 0,
  `StocPrecedent` int(11) NOT NULL DEFAULT 0,
  `pret` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Eliminarea datelor din tabel `stoc`
--

INSERT INTO `stoc` (`ID`, `NumeProdus`, `StocProdus`, `StocNou`, `StocPrecedent`, `pret`, `data`) VALUES
(3, 'Coca-Cola', 100, 0, 0, 9, '2024-11-23 17:39:13'),
(4, 'Fanta', 100, 0, 0, 9, '2024-11-23 17:39:21');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `stocfinal`
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

--
-- Eliminarea datelor din tabel `stocfinal`
--

INSERT INTO `stocfinal` (`ID`, `numebarman`, `NumeProdus`, `StocPrecedent`, `StocActual`, `PretProdus`, `Pret`, `PretTotal`, `data`) VALUES
(3, 'barman', 'Coca-Cola', 99, 8, 9, 819, 819, '2024-11-23 17:48:56'),
(4, 'barman', 'Fanta', 99, 8, 9, 819, 1638, '2024-11-23 17:48:56');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `barman` int(11) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `barman`, `admin`) VALUES
(1, 'test', 'test', 0, 1),
(2, 'barman', 'barman', 1, 0);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `backup_stoc`
--
ALTER TABLE `backup_stoc`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `barmanstoc`
--
ALTER TABLE `barmanstoc`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `Inventar`
--
ALTER TABLE `Inventar`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `raportbarman`
--
ALTER TABLE `raportbarman`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `stoc`
--
ALTER TABLE `stoc`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `stocfinal`
--
ALTER TABLE `stocfinal`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `backup_stoc`
--
ALTER TABLE `backup_stoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `barmanstoc`
--
ALTER TABLE `barmanstoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `Inventar`
--
ALTER TABLE `Inventar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `logs`
--
ALTER TABLE `logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pentru tabele `raportbarman`
--
ALTER TABLE `raportbarman`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `stoc`
--
ALTER TABLE `stoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `stocfinal`
--
ALTER TABLE `stocfinal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
