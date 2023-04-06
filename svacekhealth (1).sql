-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 06. dub 2023, 14:57
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
-- Struktura tabulky `contact`
--

CREATE TABLE `contact` (
  `identification_number` int(10) UNSIGNED NOT NULL,
  `telefon_number` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip_code` int(10) UNSIGNED NOT NULL,
  `street` varchar(100) NOT NULL,
  `house_number` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `contact`
--

INSERT INTO `contact` (`identification_number`, `telefon_number`, `email`, `country`, `city`, `zip_code`, `street`, `house_number`) VALUES
(603154464, 724816777, 'jan.svacek@student.gyarab.cz', 'Česká republika', 'Praha', 13000, 'V Horním Žďáru', 2457),
(603154475, 158, 'honza@svacek.eu', 'Česká republika', 'Brno', 1122, 'Kouřimská', 222),
(4294967295, 111254215, 'petr@pavel.cz', 'Česká republika', 'Praha', 13000, 'Londýnská', 12),
(0, 0, '', '', '', 0, '', 0);

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
-- Struktura tabulky `medical_detail`
--

CREATE TABLE `medical_detail` (
  `identification_number` int(10) UNSIGNED NOT NULL,
  `weight` double(10,2) UNSIGNED NOT NULL,
  `height` double(10,2) UNSIGNED NOT NULL,
  `bloodtype` varchar(30) NOT NULL,
  `chronic_diseases` varchar(100) NOT NULL DEFAULT 'none',
  `allergic_diseases` varchar(100) NOT NULL DEFAULT 'none',
  `genetic_diseases` varchar(100) NOT NULL DEFAULT 'none',
  `hereditary_diseases` varchar(100) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `medical_detail`
--

INSERT INTO `medical_detail` (`identification_number`, `weight`, `height`, `bloodtype`, `chronic_diseases`, `allergic_diseases`, `genetic_diseases`, `hereditary_diseases`) VALUES
(603154464, 68.00, 183.00, '0', '', 'břízy,távy,pyl', '', ''),
(603154464, 68.00, 183.00, '0', '', 'břízy,távy,pyl', '', ''),
(603154464, 68.00, 183.00, '0', '', 'břízy,távy,pyl', '', ''),
(603154464, 68.00, 183.00, '0', '', 'břízy,távy,pyl', '', ''),
(603154475, 30.00, 160.00, '0', '', '', 'Downův syndrom', ''),
(4294967295, 80.00, 185.00, '0', '', '', '', ''),
(0, 0.00, 0.00, '0', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `medical_records`
--

CREATE TABLE `medical_records` (
  `identification_number` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `physical_examination` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `patient_account`
--

CREATE TABLE `patient_account` (
  `identification_number` int(10) UNSIGNED NOT NULL,
  `surname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `patient_account`
--

INSERT INTO `patient_account` (`identification_number`, `surname`, `lastname`, `date`) VALUES
(0, '', '', '0000-00-00'),
(603154464, 'jan', 'svacek', '0000-00-00'),
(603154475, 'Petr', 'Konečný', '0000-00-00'),
(4294967295, 'Petr', 'Pavel', '0000-00-00');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `contact`
--
ALTER TABLE `contact`
  ADD KEY `identification_number` (`identification_number`);

--
-- Indexy pro tabulku `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexy pro tabulku `medical_detail`
--
ALTER TABLE `medical_detail`
  ADD KEY `identification_number` (`identification_number`);

--
-- Indexy pro tabulku `medical_records`
--
ALTER TABLE `medical_records`
  ADD KEY `identification_number` (`identification_number`);

--
-- Indexy pro tabulku `patient_account`
--
ALTER TABLE `patient_account`
  ADD PRIMARY KEY (`identification_number`);

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
-- Omezení pro tabulku `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`identification_number`) REFERENCES `patient_account` (`identification_number`);

--
-- Omezení pro tabulku `medical_detail`
--
ALTER TABLE `medical_detail`
  ADD CONSTRAINT `medical_detail_ibfk_1` FOREIGN KEY (`identification_number`) REFERENCES `patient_account` (`identification_number`);

--
-- Omezení pro tabulku `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`identification_number`) REFERENCES `patient_account` (`identification_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
