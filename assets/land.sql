-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 01:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agriculture`
--

-- --------------------------------------------------------

--
-- Table structure for table `land`
--

CREATE TABLE `land` (
  `LID` int(11) NOT NULL,
  `RID` int(11) NOT NULL,
  `LNUMBER` varchar(50) NOT NULL,
  `LSIZE` decimal(10,0) NOT NULL,
  `LSOILTYPE` varchar(100) DEFAULT NULL,
  `LWATER` decimal(10,0) DEFAULT NULL,
  `LDESC` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `land`
--

INSERT INTO `land` (`LID`, `RID`, `LNUMBER`, `LSIZE`, `LSOILTYPE`, `LWATER`, `LDESC`) VALUES
(1, 1, 'CA123', 150, 'Sandy Loam', 60, 'Coastal'),
(2, 2, 'NY456', 121, 'Clay', 46, 'Rural'),
(3, 3, 'TX789', 200, 'Black Soil', 76, 'Fertile'),
(4, 4, 'FL101', 181, 'Silt', 55, 'Everglades'),
(5, 5, 'IL202', 91, 'Loamy Sand', 40, 'Prairie'),
(6, 6, 'AZ303', 250, 'Red Clay', 80, 'Desert'),
(7, 7, 'CO404', 131, 'Rocky', 70, 'Mountainou'),
(8, 8, 'WA505', 175, 'Peat', 66, 'Forest'),
(9, 9, 'GA606', 160, 'Chalky', 56, 'Plantation'),
(10, 10, 'OH707', 110, 'Limestone', 50, 'Rolling Hi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `land`
--
ALTER TABLE `land`
  ADD PRIMARY KEY (`LID`),
  ADD KEY `FK_LOCATEDIN` (`RID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `land`
--
ALTER TABLE `land`
  MODIFY `LID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `land`
--
ALTER TABLE `land`
  ADD CONSTRAINT `FK_LOCATEDIN` FOREIGN KEY (`RID`) REFERENCES `region` (`RID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
