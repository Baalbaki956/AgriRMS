-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 01:07 PM
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
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `RID` int(11) NOT NULL,
  `RSTATE` varchar(255) NOT NULL,
  `RADDRESS` varchar(255) NOT NULL,
  `RTEMP` int(11) DEFAULT NULL,
  `RHUMIDITY` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`RID`, `RSTATE`, `RADDRESS`, `RTEMP`, `RHUMIDITY`) VALUES
(1, 'California', '123 Main St, Los Angeles, CA', 75, 51),
(2, 'New York', '456 Broadway, New York, NY', 68, 65),
(3, 'Texas', '789 Oak St, Houston, TX', 82, 56),
(4, 'Florida', '101 Palm St, Miami, FL', 88, 70),
(5, 'Illinois', '202 Maple St, Chicago, IL', 72, 45),
(6, 'Arizona', '303 Pine St, Phoenix, AZ', 95, 31),
(7, 'Colorado', '404 Cedar St, Denver, CO', 78, 41),
(8, 'Washington', '505 Spruce St, Seattle, WA', 65, 60),
(9, 'Georgia', '606 Birch St, Atlanta, GA', 80, 56),
(10, 'Ohio', '707 Elm St, Columbus, OH', 70, 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`RID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
