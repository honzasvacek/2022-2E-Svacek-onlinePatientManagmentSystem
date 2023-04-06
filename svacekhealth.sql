-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 24. bře 2023, 17:03
-- Verze serveru: 10.4.27-MariaDB
-- Verze PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `svacekhealth`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `adresa`
--

CREATE TABLE `adresa` (
  `rodnecislo` int(20) NOT NULL,
  `mesto` char(50) NOT NULL,
  `psc` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `adresa`
--

INSERT INTO `adresa` (`rodnecislo`, `mesto`, `psc`) VALUES
(603154464, 'Praha', 13000),
(603111155, 'Suchdol', 15600),
(601193322, 'Mimo Praha', 13500),
(1111552481, 'Praha', 14000);

-- --------------------------------------------------------

--
-- Struktura tabulky `doctors`
--

CREATE TABLE `doctors` (
  `UserID` int(10) UNSIGNED NOT NULL,
  `Username` char(50) NOT NULL,
  `Password` char(100) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `doctors`
--

INSERT INTO `doctors` (`UserID`, `Username`, `Password`, `Date`) VALUES
(1, 'Petr Novák', 'Chorobopis1', '0000-00-00 00:00:00'),
(7, 'James Bond', 'heslo7', '2023-03-16 19:56:17'),
(8, 'Petr Psvel', 'heslo48', '2023-03-16 19:56:17'),
(9, 'Ivan Hurt', 'heslo15', '2023-03-16 19:56:17'),
(10, 'Jan Lana', 'heslo1', '2023-03-16 19:56:17'),
(11, 'Hozáno Sváčkos', '2398', '2023-03-20 16:53:54'),
(12, 'null testový', '00', '2023-03-20 16:55:12'),
(13, 'Hozáno Sváčkos', '2398', '2023-03-20 17:00:44'),
(14, 'Hozáno Sváčkos', '2398', '2023-03-20 17:00:56');

-- --------------------------------------------------------

--
-- Struktura tabulky `ucet`
--

CREATE TABLE `ucet` (
  `rodnecislo` int(100) NOT NULL,
  `jmeno` varchar(100) NOT NULL,
  `prijmeni` varchar(100) NOT NULL,
  `datum` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `ucet`
--

INSERT INTO `ucet` (`rodnecislo`, `jmeno`, `prijmeni`, `datum`) VALUES
(23002257, 'bezdomovec', 'obecny', '2023-03-20'),
(601193322, 'Klara', 'Prokopova', '2023-03-20'),
(603111155, 'Petr', 'Novak', '2023-03-20'),
(603154464, 'Jan', 'Svacek', '2023-03-20'),
(1111552481, 'Pavel', 'Petr', '2023-03-20');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `adresa`
--
ALTER TABLE `adresa`
  ADD KEY `rodnecislo` (`rodnecislo`);

--
-- Indexy pro tabulku `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexy pro tabulku `ucet`
--
ALTER TABLE `ucet`
  ADD PRIMARY KEY (`rodnecislo`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `doctors`
--
ALTER TABLE `doctors`
  MODIFY `UserID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `adresa`
--
ALTER TABLE `adresa`
  ADD CONSTRAINT `adresa_ibfk_1` FOREIGN KEY (`rodnecislo`) REFERENCES `ucet` (`rodnecislo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
