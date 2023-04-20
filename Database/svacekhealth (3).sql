-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 15. dub 2023, 13:21
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
  `identification_number` bigint(10) UNSIGNED NOT NULL,
  `telefon_number` bigint(10) UNSIGNED NOT NULL,
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
(1007180394, 771466686, 'Vaclav.Krcmar@centrum.cz', 'Česká republika', 'Valašské Meziříčí', 47502, 'Vásostná', 55),
(1911296167, 705972571, 'odolen_kuklova@centrum.cz', 'Česká republika', 'Cheb', 66704, 'Pavlišovská', 21),
(1512192770, 606851669, 'vlastimir52@centrum.cz', 'Česká republika', 'Valašské Meziříčí', 47502, 'K Háji', 2),
(1309041745, 793507685, 'zoran68@gmail.com', 'Česká republika', 'Karlovy Vary', 2497, 'Chlumínská', 89),
(801250351, 607417019, 'Lukas.Bodlak@centrum.cz', 'Česká republika', 'Praha 3', 13000, 'Vinohradská', 125),
(7804248782, 607563853, 'mikulas.ambrozova@centrum.cz', 'Česká republika', 'Praha 3', 13000, 'V Horní Stromce', 2457),
(7011049397, 601737017, 'adin_micka@volny.cz', 'Česká republika', 'Jihlava', 22466, 'Kvestorská', 82),
(8703233275, 605195477, 'naneta7@gmail.com', 'Česká republika', 'Plzeň', 14188, 'Pilovská', 6),
(901180797, 608744094, 'rupert10@gmail.com', 'Česká republika', 'Most', 66585, 'Dělnická', 4),
(708150949, 705375767, 'timoteus37@seznam.cz', 'Česká republika', 'Praha 3', 12000, 'Praha 2', 0),
(1002177517, 797173889, 'bozislav_sadilek11 @seznam.cz', 'Česká republika', 'Praha 6', 16000, 'Evropská', 15),
(1912105283, 607289714, 'kurt_zouharova64@seznam.cz', 'Česká republika', 'Havlíčkův Brod', 35070, 'Ve Vrších', 22),
(907147901, 722187162, 'skarlet50@seznam.cz', 'Česká republika', ' Frýdek-Místek', 45293, 'U Pekáren', 12),
(7310273993, 606744788, 'zbynka.curdova@atlas.cz', 'Česká republika', 'Litoměřice', 83309, 'K Vystrkovu', 2),
(8105070875, 608157087, 'slavomil.pavlicek97@atlas.cz', 'Česká republika', 'Orlová', 47933, 'Mečíková', 3),
(6354287445, 730615694, 'inocenc78@atlas.cz', 'Česká republika', 'Kladno', 48661, 'Čelkovická', 11),
(658063791, 605000371, 'zoja_manakova@atlas.cz', 'Česká republika', ' Valašské Meziříčí', 80216, 'N. A. Někrasova', 87),
(1858214402, 909821531, 'kornelius.kalousek@gmail.com', 'Slovenská republika', 'Prešov', 8001, 'Mukačevská', 4818),
(9757134057, 940270015, 'benedikta38@gmail.com', 'Slovenská republika', 'Košice', 4001, 'Tajovského', 749),
(7505241634, 601485300, 'pribyslav87@gmail.com', 'Česká republika', 'Karviná', 2230, 'Hečkova', 6);

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
  `identification_number` bigint(10) UNSIGNED NOT NULL,
  `sex` tinyint(3) UNSIGNED NOT NULL,
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

INSERT INTO `medical_detail` (`identification_number`, `sex`, `weight`, `height`, `bloodtype`, `chronic_diseases`, `allergic_diseases`, `genetic_diseases`, `hereditary_diseases`) VALUES
(1007180394, 1, 80.00, 162.00, 'A', '', '', '', ''),
(1911296167, 1, 58.00, 178.00, 'A', '', '', '', ''),
(1512192770, 1, 58.00, 188.00, 'A', '', '', '', ''),
(1309041745, 1, 68.00, 170.00, 'A', '', '', '', ''),
(801250351, 1, 75.00, 172.00, 'AB', '', '', '', ''),
(7804248782, 1, 80.00, 136.00, 'AB', '', '', '', ''),
(7011049397, 1, 78.00, 158.00, 'AB', '', '', '', ''),
(8703233275, 1, 68.00, 136.00, 'AB', '', '', '', ''),
(7505241634, 1, 65.00, 182.00, 'AB', '', '', '', ''),
(901180797, 1, 47.00, 159.00, '0', '', '', '', ''),
(708150949, 1, 87.00, 138.00, '0', '', '', '', ''),
(1002177517, 1, 71.00, 150.00, '0', '', '', '', ''),
(1912105283, 1, 96.00, 177.00, 'B', '', '', '', ''),
(907147901, 1, 65.00, 174.00, 'B', '', '', '', ''),
(7310273993, 0, 40.00, 142.00, 'B', '', '', '', ''),
(8105070875, 0, 34.00, 186.00, 'B', '', '', '', ''),
(6354287445, 0, 56.00, 138.00, 'B', '', '', '', ''),
(658063791, 0, 40.00, 148.00, 'A', '', '', '', ''),
(1858214402, 0, 43.00, 163.00, '0', '', '', '', ''),
(9757134057, 0, 52.00, 164.00, '0', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `medical_records`
--

CREATE TABLE `medical_records` (
  `identification_number` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `physical_examination` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `patient_account`
--

CREATE TABLE `patient_account` (
  `identification_number` bigint(10) UNSIGNED NOT NULL,
  `surname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `patient_account`
--

INSERT INTO `patient_account` (`identification_number`, `surname`, `lastname`, `date`) VALUES
(658063791, 'Hana', 'Svobodová', '2023-04-14'),
(708150949, 'Bořek', 'Linhart', '2023-04-14'),
(801250351, 'Lukáš', 'Bodlák', '2023-04-14'),
(901180797, 'Oldřich', 'Osvald', '2023-04-14'),
(907147901, 'Ondřej', 'Sloup', '2023-04-14'),
(1002177517, 'Tomáš', 'Veselý', '2023-04-14'),
(1007180394, 'Václav', 'Krčmář', '2023-04-14'),
(1309041745, 'Jiří', 'Stix', '2023-04-14'),
(1512192770, 'Zdeněk', 'Oliva', '2023-04-14'),
(1858214402, 'Lydie', 'Rysková', '2023-04-14'),
(1911296167, 'Jan', 'Prchal', '2023-04-14'),
(1912105283, 'Petr', 'Procházka', '2023-04-14'),
(6354287445, 'Svitlana', 'Kvasničková', '2023-04-14'),
(7011049397, 'Josef', 'Sobek', '2023-04-14'),
(7310273993, 'Michaela', 'Štípská', '2023-04-14'),
(7505241634, 'Jamal Ali', 'Khalefa Kalina', '2023-04-14'),
(7804248782, 'Roman', 'Nábělek', '2023-04-14'),
(8105070875, 'Věra', 'Plocková', '2023-04-14'),
(8703233275, 'Alois', 'Ševčík', '2023-04-14'),
(9757134057, 'Eva', 'Vágnerová', '2023-04-14');

-- --------------------------------------------------------

--
-- Struktura tabulky `patient_account_error`
--

CREATE TABLE `patient_account_error` (
  `identification_number` int(10) UNSIGNED NOT NULL,
  `surname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexy pro tabulku `patient_account_error`
--
ALTER TABLE `patient_account_error`
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
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`identification_number`) REFERENCES `patient_account_error` (`identification_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
