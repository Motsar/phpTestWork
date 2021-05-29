-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2021 at 11:59 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stargazing`
--

-- --------------------------------------------------------

--
-- Table structure for table `stargazers`
--

CREATE TABLE `stargazers` (
  `ID` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Town` varchar(50) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stargazers`
--

INSERT INTO `stargazers` (`ID`, `Name`, `Email`, `Town`, `DateTime`, `Comment`) VALUES
(1, 'Martin Motsar', 'martin.motsar@gmail.com', 'Tallinn', '2021-06-02 02:00:00', ''),
(3, 'Martin Motsar', 'martin.motsar@gmail.com', 'Tallinn', '2021-06-03 02:00:00', ''),
(5, 'Martin Motsar', 'martin.motsar@gmail.com', 'Tallinn', '2021-06-02 05:00:00', ''),
(6, 'Martin Motsar', 'martin.motsar@gmail.com', 'Jõgeva', '2021-06-03 02:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stargazers`
--
ALTER TABLE `stargazers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`,`DateTime`,`Town`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stargazers`
--
ALTER TABLE `stargazers`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
