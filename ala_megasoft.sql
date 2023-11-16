-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 01:33 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ala_megasoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `ID` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `nr` int(11) NOT NULL,
  `add` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`ID`, `street`, `nr`, `add`, `zip`, `place`, `country`) VALUES
(1, 'streetname', 12, 'Where am i?', '1111AA', 'Groningen', 'Netherlands'),
(2, 'Szwwetmaan', 23, 'Here is where?', '2222AA', 'Zweman', 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `ID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `infix` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `ismale` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`ID`, `firstname`, `infix`, `lastname`, `ismale`) VALUES
(1, 'John', '', 'Doe', 1),
(2, 'Johnny', 'van', 'Doe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `personsadresses`
--

CREATE TABLE `personsadresses` (
  `ID` int(11) NOT NULL,
  `personsID` int(11) NOT NULL,
  `addressesID` int(11) NOT NULL,
  `ismain` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `personsadresses`
--

INSERT INTO `personsadresses` (`ID`, `personsID`, `addressesID`, `ismain`) VALUES
(1, 1, 1, 0),
(2, 2, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `personsadresses`
--
ALTER TABLE `personsadresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `personsadresses_ibfk_1` (`addressesID`),
  ADD KEY `personsadresses_ibfk_2` (`personsID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personsadresses`
--
ALTER TABLE `personsadresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `personsadresses`
--
ALTER TABLE `personsadresses`
  ADD CONSTRAINT `personsadresses_ibfk_1` FOREIGN KEY (`addressesID`) REFERENCES `addresses` (`ID`),
  ADD CONSTRAINT `personsadresses_ibfk_2` FOREIGN KEY (`personsID`) REFERENCES `persons` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
