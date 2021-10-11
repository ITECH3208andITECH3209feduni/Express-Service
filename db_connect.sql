-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2021 at 12:52 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `customer` varchar(250) DEFAULT NULL,
  `driver` varchar(150) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `pickup` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `date`, `customer`, `driver`, `status`, `total`, `pickup`) VALUES
(1, '2021-08-11 15:34:03', '1', '1', 'Pending', '250.45', '2021-07-16 15:00:33'),
(2, '2021-08-11 15:42:15', 'Jeffry wage', 'Hemp', 'Completed', '250.45', '2021-07-16 15:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fullname` varchar(300) DEFAULT NULL,
  `address` varchar(400) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fullname`, `address`, `contact`, `email`, `username`, `image`) VALUES
(1, 'Kamal', 'Ausi', '88342343', 'kamal95@gmail.com', 'Kamal95', NULL),
(2, 'Kamal', 'Aus', '88342343', 'kamal95@gmail.com', 'Kamal95', NULL),
(3, 'Jeffry wage', '2021-07-16 15:00:33', 'Pending', 'Kamal Perera', 'uname', NULL),
(4, 'Manu', 'no 45', '0775917990', 'manu@gmail.com', 'manu', NULL),
(5, 'manu', 'no 45', '0779834123', 'rahulk99w@gmail.com', 'rahul', NULL),
(6, 'josh', 'no 44', '2123412456', 'josh@gmail.com', 'josh', NULL),
(7, 'Jeffry wage', '2021-07-16 15:00:33', 'Pending', 'Kamal Perera', 'uname', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `utype` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `username`, `password`, `utype`) VALUES
(1, 'ruvin', '123', 'admin'),
(2, 'Kamal95', '123', 'customer'),
(3, 'Kamal95', '123', 'customer'),
(6, 'rahul', '123', 'customer'),
(7, 'josh', '123', 'customer'),
(8, 'uname', '250.45', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE `system_users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `isadmin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`id`, `fullname`, `email`, `username`, `contact`, `address`, `isadmin`) VALUES
(1, 'text', 'hqh', 'ruvin', 'no', 'ywwy', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_users`
--
ALTER TABLE `system_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `system_users`
--
ALTER TABLE `system_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
