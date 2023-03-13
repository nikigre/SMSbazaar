-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2023 at 06:07 PM
-- Server version: 10.6.12-MariaDB-cll-lve-log
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nikigre_PetrovceBazar`
--

-- --------------------------------------------------------

--
-- Table structure for table `ArtikelArtikel`
--

CREATE TABLE `ArtikelArtikel` (
  `ID` int(11) NOT NULL,
  `DatumVpisa` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ArtikelArtikel`
--

INSERT INTO `ArtikelArtikel` (`ID`, `DatumVpisa`) VALUES
(1, '2022-11-22 10:32:12'),
(2, '2022-11-22 10:32:12'),
(3, '2022-11-22 10:32:12'),
(4, '2022-11-22 10:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `RezervacijaArtikel`
--

CREATE TABLE `RezervacijaArtikel` (
  `ID_rezervacija` int(11) NOT NULL,
  `IDArtikel` int(11) NOT NULL,
  `TelefonskaStevilka` varchar(15) NOT NULL,
  `DatumRezervacije` timestamp NOT NULL DEFAULT current_timestamp(),
  `JePrevzet` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Indexes for dumped tables
--


--
-- Indexes for table `ArtikelArtikel`
--
ALTER TABLE `ArtikelArtikel`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `RezervacijaArtikel`
--
ALTER TABLE `RezervacijaArtikel`
  ADD PRIMARY KEY (`ID_rezervacija`),
  ADD KEY `IDArtikel` (`IDArtikel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `RezervacijaArtikel`
--
ALTER TABLE `RezervacijaArtikel`
  ADD CONSTRAINT `RezervacijaArtikel_ibfk_2` FOREIGN KEY (`IDArtikel`) REFERENCES `ArtikelArtikel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
