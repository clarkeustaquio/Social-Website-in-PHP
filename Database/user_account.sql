-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2020 at 09:45 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_account`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` char(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` char(6) DEFAULT NULL,
  `phoneNumber` bigint(20) DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `coverPhoto` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `firstName`, `lastName`, `email`, `password`, `birthday`, `gender`, `phoneNumber`, `urlImage`, `coverPhoto`, `profileName`) VALUES
(60, 'Clark', 'Eustaquio', 'clark.eustaquio@gmail.com', 'password', '2015-09-28', 'Male', 123456789, 'editedImages/defaultMale.png', 'images/defaultCover.jfif', 'Clark Eustaquio'),
(61, 'Boy', 'Account', 'sample@gmail.com', '123', '2014-10-27', 'Male', 123, 'editedImages/mysql.png', 'images/defaultCover.jfif', 'Boy Account'),
(62, 'Edit', 'Edit', 'edit@gmail.com', '123', '2012-05-24', 'Male', 123, 'editedImages/defaultMale.png', 'images/defaultCover.jfif', 'Edit Edit'),
(63, 'Female', 'Account', 'female@gmail.com', '123', '2010-12-28', 'Female', 12345, 'editedImages/defaultFemale.png', 'images/defaultCover.jfif', 'Female Account'),
(64, 'Account', 'Create', 'account@gmail.com', '123', '2012-09-02', 'Male', 123, 'images/defaultMale.png', 'images/defaultCover.jfif', 'Account Create');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `theComment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `feed` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(50) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `postImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `email` varchar(255) DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL,
  `whoAdd` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `sessionName` varchar(255) DEFAULT NULL,
  `sessionImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `email` varchar(255) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `emailBy` varchar(255) DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `theMessage` text DEFAULT NULL,
  `whoSend` varchar(255) DEFAULT NULL,
  `toWhom` varchar(255) DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `sessionImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `untilnot`
--

CREATE TABLE `untilnot` (
  `toWhom` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL,
  `sessionImage` varchar(255) DEFAULT NULL,
  `sessionProfile` varchar(255) DEFAULT NULL,
  `whoSend` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `whoimessage`
--

CREATE TABLE `whoimessage` (
  `whoSend` varchar(255) DEFAULT NULL,
  `toWhom` varchar(255) DEFAULT NULL,
  `urlImage` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL,
  `sessionImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
