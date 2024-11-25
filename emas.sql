-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Nov 18, 2024 at 02:39 AM
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
-- Database: `emas`
--

-- --------------------------------------------------------

--
-- Table structure for table `emas_report`
--

CREATE TABLE `emas_report` (
  `emas_report_id` int(11) NOT NULL,
  `emas_report_user` int(10) NOT NULL,
  `emas_report_time` date NOT NULL,
  `emas_report_status` enum('DITOLAK','DITERIMA','DALAM PROSES') DEFAULT 'DALAM PROSES',
  `emas_report_file` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emas_report`
--

INSERT INTO `emas_report` (`emas_report_id`, `emas_report_user`, `emas_report_time`, `emas_report_status`, `emas_report_file`) VALUES
(1, 2022654321, '2024-11-15', 'DITERIMA', 'files/laporan_6737042146a085.76165881.pdf'),
(2, 12345, '2024-11-15', 'DALAM PROSES', 'files/laporan_6737045db22171.06148700.pdf'),
(3, 12345, '2024-11-15', 'DITERIMA', 'files/laporan_673704ebd79c31.58693182.pdf'),
(4, 12345, '2024-11-18', 'DITOLAK', 'files/laporan_673a930f394954.92973074.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `emas_user`
--

CREATE TABLE `emas_user` (
  `emas_user_id` int(10) NOT NULL,
  `emas_user_name` varchar(255) NOT NULL,
  `emas_user_pass` varchar(255) NOT NULL,
  `emas_user_phone` varchar(13) NOT NULL,
  `emas_user_course` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emas_user`
--

INSERT INTO `emas_user` (`emas_user_id`, `emas_user_name`, `emas_user_pass`, `emas_user_phone`, `emas_user_course`) VALUES
(12345, 'ADMINISTRATOR', '12345', '0', 'NONE'),
(2022123456, 'MUHAMAD BIN ALI', '12345', '0123456789', 'CS110'),
(2022654321, 'ALI BIN MUHAMMAD', '54321', '987654321', 'CS110'),
(2022880524, 'MUHAMMAD LOKMAN BIN ABDUL HAMID', '12345', '01135410849', 'CSS110');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emas_report`
--
ALTER TABLE `emas_report`
  ADD PRIMARY KEY (`emas_report_id`);

--
-- Indexes for table `emas_user`
--
ALTER TABLE `emas_user`
  ADD PRIMARY KEY (`emas_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emas_report`
--
ALTER TABLE `emas_report`
  MODIFY `emas_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
