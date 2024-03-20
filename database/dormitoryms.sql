-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2023 at 03:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dormitoryms`
--

-- --------------------------------------------------------

--
-- Table structure for table `dorm_list`
--

CREATE TABLE `dorm_list` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `intended` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_updated` varchar(50) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dorm_list`
--

INSERT INTO `dorm_list` (`id`, `name`, `intended`, `status`, `date_updated`, `date_created`) VALUES
(52, 'International House II', 'Female', 'Active', '2023-06-06 08:33:01 PM', '2023-05-29 10:29:41 PM'),
(55, 'Student Housing', 'Female', 'Active', '0', '2023-05-29 10:45:03 PM'),
(56, 'Mens Dorm', 'Male', 'Active', '2023-05-30 03:59:17 PM', '2023-05-29 10:46:27 PM');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `dorm_name` varchar(100) NOT NULL,
  `room` varchar(100) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `electricity_fee` varchar(100) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `or_number` varchar(100) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `tenant_id`, `student_number`, `academic_year`, `semester`, `dorm_name`, `room`, `amount`, `electricity_fee`, `payment`, `or_number`, `date_created`) VALUES
(161, 131, '201810716', '2022-2023', 'First Semester', 'International House II', '103', '7500', '', 'Dorm Rental Fee', '190435', '2023-05-30 05:33:21 PM'),
(163, 131, '201810716', '2022-2023', 'First Semester', 'International House II', '103', '', '500', 'Electricity Fee', '19021', '2023-05-30 05:38:28 PM'),
(166, 102, '201515530', '2022-2023', 'First Semester', 'International House II', '101', '', '500', 'Electricity Fee', '1906245', '2023-05-30 05:42:09 PM'),
(170, 101, '201912476', '2022-2023', 'First Semester', 'Mens Dorm', '101', '500', '500', 'Electricity Fee', '1905834', '2023-05-30 05:43:11 PM'),
(171, 103, '201912452', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '1903825', '2023-05-30 05:43:26 PM'),
(172, 103, '201912452', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '1908934', '2023-05-30 05:43:42 PM'),
(173, 105, '201911939', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '1905834', '2023-05-30 05:43:59 PM'),
(174, 105, '201911939', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '190438', '2023-05-30 05:44:11 PM'),
(175, 106, '201912543', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '190345', '2023-05-30 05:44:37 PM'),
(176, 106, '201912543', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '190348', '2023-05-30 05:44:54 PM'),
(177, 107, '201912590', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '1908354', '2023-05-30 05:45:25 PM'),
(178, 107, '201912590', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '1908731', '2023-05-30 05:45:39 PM'),
(179, 108, '201912898', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '190845', '2023-05-30 05:46:04 PM'),
(180, 108, '201912898', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '190873', '2023-05-30 05:46:32 PM'),
(181, 110, '201912478', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '192320', '2023-05-30 05:46:52 PM'),
(182, 110, '201912478', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '190854', '2023-05-30 05:47:02 PM'),
(183, 112, '201912325', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '190343', '2023-05-30 05:47:18 PM'),
(184, 112, '201912325', '2022-2023', 'First Semester', 'Mens Dorm', '101', '', '500', 'Electricity Fee', '190845', '2023-05-30 05:47:29 PM'),
(185, 104, '201911913', '2022-2023', 'First Semester', 'International House II', '101', '', '500', 'Electricity Fee', '199823', '2023-05-30 05:47:42 PM'),
(186, 104, '201911913', '2022-2023', 'First Semester', 'International House II', '101', '7500', '', 'Dorm Rental Fee', '19165', '2023-05-30 05:48:04 PM'),
(187, 109, '201912373', '2022-2023', 'First Semester', 'International House II', '101', '7500', '', 'Dorm Rental Fee', '192762', '2023-05-30 05:48:45 PM'),
(188, 109, '201912373', '2022-2023', 'First Semester', 'International House II', '101', '', '500', 'Electricity Fee', '191238', '2023-05-30 05:48:59 PM'),
(189, 111, '201912445', '2022-2023', 'First Semester', 'International House II', '101', '7500', '', 'Dorm Rental Fee', '198324', '2023-05-30 05:49:14 PM'),
(190, 111, '201912445', '2022-2023', 'First Semester', 'International House II', '101', '', '500', 'Electricity Fee', '199234', '2023-05-30 05:49:26 PM'),
(191, 114, '201912417', '2022-2023', 'First Semester', 'International House II', '102', '7500', '', 'Dorm Rental Fee', '192304', '2023-05-30 05:49:53 PM'),
(192, 114, '201912417', '2022-2023', 'First Semester', 'International House II', '102', '', '500', 'Electricity Fee', '193023', '2023-05-30 05:50:06 PM'),
(193, 117, '201912379', '2022-2023', 'First Semester', 'International House II', '102', '7500', '', 'Dorm Rental Fee', '194023', '2023-05-30 05:51:15 PM'),
(194, 117, '201912379', '2022-2023', 'First Semester', 'International House II', '102', '', '500', 'Electricity Fee', '192032', '2023-05-30 05:51:39 PM'),
(195, 119, '201911865', '2022-2023', 'First Semester', 'International House II', '102', '7500', '', 'Dorm Rental Fee', '192342', '2023-05-30 05:51:56 PM'),
(196, 119, '201911865', '2022-2023', 'First Semester', 'International House II', '102', '', '500', 'Electricity Fee', '195023', '2023-05-30 05:52:22 PM'),
(197, 120, '201911895', '2022-2023', 'First Semester', 'International House II', '102', '7500', '', 'Dorm Rental Fee', '196032', '2023-05-30 05:52:36 PM'),
(198, 120, '201911895', '2022-2023', 'First Semester', 'International House II', '102', '', '500', 'Electricity Fee', '198723', '2023-05-30 05:52:50 PM'),
(199, 121, '201911893', '2022-2023', 'First Semester', 'International House II', '103', '7500', '', 'Dorm Rental Fee', '192304', '2023-05-30 05:53:03 PM'),
(200, 121, '201911893', '2022-2023', 'First Semester', 'International House II', '103', '', '500', 'Electricity Fee', '192354', '2023-05-30 05:53:17 PM'),
(201, 126, '201912419', '2022-2023', 'First Semester', 'International House II', '103', '7500', '', 'Dorm Rental Fee', '196023', '2023-05-30 05:53:39 PM'),
(202, 126, '201912419', '2022-2023', 'First Semester', 'International House II', '103', '', '500', 'Electricity Fee', '190823', '2023-05-30 05:53:56 PM'),
(203, 113, '201912133', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '199634', '2023-05-30 05:54:24 PM'),
(204, 113, '201912133', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '198453', '2023-05-30 05:54:45 PM'),
(205, 115, '202016737', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '198723', '2023-05-30 05:55:28 PM'),
(206, 115, '202016737', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '192353', '2023-05-30 05:55:44 PM'),
(207, 118, '201912484', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '199834', '2023-05-30 05:56:01 PM'),
(208, 118, '201912484', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '198273', '2023-05-30 05:56:35 PM'),
(209, 116, '201911837', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '198723', '2023-05-30 05:56:59 PM'),
(210, 116, '201911837', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '198723', '2023-05-30 05:57:12 PM'),
(211, 122, '201911937', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '197723', '2023-05-30 06:09:59 PM'),
(212, 122, '201911937', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '195345', '2023-05-30 06:10:17 PM'),
(213, 123, '201912517', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '1987453', '2023-05-30 06:10:34 PM'),
(214, 123, '201912517', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '198345', '2023-05-30 06:10:53 PM'),
(215, 124, '201912344', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '199456', '2023-05-30 06:11:09 PM'),
(216, 124, '201912344', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '198345', '2023-05-30 06:11:27 PM'),
(217, 125, '201912483', '2022-2023', 'First Semester', 'Mens Dorm', '102', '2500', '', 'Dorm Rental Fee', '198456', '2023-05-30 06:11:40 PM'),
(219, 125, '201912483', '2022-2023', 'First Semester', 'Mens Dorm', '102', '', '500', 'Electricity Fee', '198845', '2023-05-30 06:12:19 PM'),
(221, 129, '201912573', '2022-2023', 'First Semester', 'International House II', '103', '', '500', 'Electricity Fee', '197342', '2023-05-30 06:13:13 PM'),
(222, 129, '201912573', '2022-2023', 'First Semester', 'International House II', '103', '7500', '', 'Dorm Rental Fee', '197834', '2023-05-30 06:13:38 PM'),
(223, 130, '201912072', '2022-2023', 'First Semester', 'Mens Dorm', '103', '2500', '', 'Dorm Rental Fee', '197452', '2023-05-30 06:13:55 PM'),
(224, 130, '201912072', '2022-2023', 'First Semester', 'Mens Dorm', '103', '', '500', 'Electricity Fee', '197842', '2023-05-30 06:14:06 PM'),
(225, 127, '201912480', '2022-2023', 'First Semester', 'Mens Dorm', '103', '2500', '', 'Dorm Rental Fee', '195634', '2023-05-30 06:14:18 PM'),
(226, 127, '201912480', '2022-2023', 'First Semester', 'Mens Dorm', '103', '', '500', 'Electricity Fee', '197424', '2023-05-30 06:14:39 PM'),
(227, 128, '201912320', '2022-2023', 'First Semester', 'Mens Dorm', '103', '2500', '', 'Dorm Rental Fee', '188342', '2023-05-30 06:14:51 PM'),
(228, 128, '201912320', '2022-2023', 'First Semester', 'Mens Dorm', '103', '', '500', 'Electricity Fee', '197435', '2023-05-30 06:15:03 PM'),
(229, 133, '201811895', '2022-2023', 'First Semester', 'International House II', '104', '7500', '', 'Dorm Rental Fee', '187642', '2023-06-01 09:06:34 AM'),
(311, 101, '201912476', '2022-2023', 'First Semester', 'Mens Dorm', '101', '2500', '', 'Dorm Rental Fee', '18675', '2023-06-07 03:58:46 PM'),
(315, 102, '201515530', '2022-2023', 'First Semester', 'International House II', '101', '3750', '', 'Dorm Rental Fee', '1908324', '2023-06-07 03:59:47 PM');

-- --------------------------------------------------------

--
-- Table structure for table `room_assignments`
--

CREATE TABLE `room_assignments` (
  `id` int(11) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `room_id` varchar(50) NOT NULL,
  `dormname` varchar(50) NOT NULL,
  `balance` varchar(50) NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_assignments`
--

INSERT INTO `room_assignments` (`id`, `student_number`, `room_id`, `dormname`, `balance`, `academic_year`, `semester`) VALUES
(125, '201515530', '101', 'International House II', '3750', '2022-2023', 'First Semester'),
(126, '201912476', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(127, '201912452', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(128, '201911939', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(129, '201912543', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(130, '201912590', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(131, '201912898', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(132, '201912478', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(133, '201912325', '101', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(134, '201911913', '101', 'International House II', '0', '2022-2023', 'First Semester'),
(135, '201912373', '101', 'International House II', '0', '2022-2023', 'First Semester'),
(136, '201912445', '101', 'International House II', '0', '2022-2023', 'First Semester'),
(137, '201912417', '102', 'International House II', '0', '2022-2023', 'First Semester'),
(138, '201912379', '102', 'International House II', '0', '2022-2023', 'First Semester'),
(139, '201911865', '102', 'International House II', '0', '2022-2023', 'First Semester'),
(140, '201911895', '102', 'International House II', '0', '2022-2023', 'First Semester'),
(141, '201911893', '103', 'International House II', '0', '2022-2023', 'First Semester'),
(142, '201912419', '103', 'International House II', '0', '2022-2023', 'First Semester'),
(143, '201810716', '103', 'International House II', '0', '2022-2023', 'First Semester'),
(144, '201912133', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(145, '202016737', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(146, '201912484', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(147, '201911837', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(148, '201911937', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(149, '201912517', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(150, '201912344', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(151, '201912483', '102', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(152, '201912573', '103', 'International House II', '0', '2022-2023', 'First Semester'),
(153, '201912072', '103', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(154, '201912480', '103', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(155, '201912320', '103', 'Mens Dorm', '0', '2022-2023', 'First Semester'),
(158, '201811895', '104', 'International House II', '0', '2022-2023', 'First Semester');

-- --------------------------------------------------------

--
-- Table structure for table `room_list`
--

CREATE TABLE `room_list` (
  `id` int(11) NOT NULL,
  `dorm_name` varchar(50) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `beds` int(11) NOT NULL,
  `available_beds` int(11) NOT NULL,
  `price` float(12,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `room_img` varchar(1000) NOT NULL,
  `date_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_list`
--

INSERT INTO `room_list` (`id`, `dorm_name`, `room_number`, `description`, `beds`, `available_beds`, `price`, `status`, `room_img`, `date_updated`, `date_created`) VALUES
(68, 'International House II', '101', 'Air-conditioned room, Girls only', 4, 4, 7500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 10:55:15'),
(69, 'International House II', '102', 'Air-conditioned room, Girls only', 4, 4, 7500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 10:55:51'),
(70, 'International House II', '103', 'Air-conditioned room, Girls only', 4, 4, 7500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 10:56:07'),
(71, 'International House II', '104', 'Air-conditioned room, Girls only', 1, 4, 30000.00, 'Active', '0', '2023-06-01 09:23:57', '2023-05-29 10:56:53'),
(72, 'International House II', '105', 'Air-conditioned room, Girls only', 4, 4, 7500.00, 'Active', '0', '2023-05-30 04:43:41', '2023-05-29 10:57:40'),
(73, 'International House II', '106', 'Air-conditioned room, Girls only', 6, 6, 5000.00, 'Active', 'room_img/image3-3.jpeg', '2023-06-04 09:37:33', '2023-05-29 10:58:44'),
(74, 'International House II', '201', 'Air-conditioned room, Girls only', 3, 3, 10000.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 10:59:21'),
(75, 'International House II', '202', 'Air-conditioned room, Girls only', 6, 6, 5000.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 10:59:56'),
(76, 'International House II', '203', 'Air-conditioned room, Girls only', 5, 5, 6000.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:00:16'),
(77, 'International House II', '204', 'Air-conditioned room, Girls only', 2, 2, 15000.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:11:54'),
(78, 'Student Housing', '101', 'Girls only', 4, 4, 3600.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:23:27'),
(79, 'Student Housing', '102', 'Girls only', 4, 4, 3600.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:24:03'),
(80, 'Student Housing', '103', 'Girls only', 5, 5, 3300.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:24:48'),
(81, 'Student Housing', '104', 'Girls only', 3, 3, 4800.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:25:11'),
(82, 'Student Housing', '105', 'Girls only', 2, 2, 7200.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:25:53'),
(83, 'Student Housing', '106', 'Girls only', 5, 5, 3300.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:27:15'),
(84, 'Mens Dorm', '101', 'Boys only', 8, 8, 2500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:29:42'),
(85, 'Mens Dorm', '102', 'Boys only', 8, 8, 2500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:29:55'),
(86, 'Mens Dorm', '103', 'Boys only', 8, 8, 2500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:30:08'),
(87, 'Mens Dorm', '104', 'Boys only', 8, 8, 2500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:30:23'),
(88, 'Mens Dorm', '105', 'Boys only', 8, 8, 2500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:30:35'),
(89, 'Mens Dorm', '106', 'Boys only', 8, 8, 2500.00, 'Active', '0', '0000-00-00 00:00:00', '2023-05-29 11:31:07'),
(90, 'International House II', '205', 'Air-conditioned room, Girls only', 6, 6, 5000.00, 'Active', 'room_img/image3-3.jpeg', '2023-06-04 02:29:09', '2023-06-04 01:31:43'),
(91, 'International House II', '206', 'Air-conditioned room, Girls only', 6, 6, 5000.00, 'Active', 'room_img/image3-3.jpeg', '0000-00-00 00:00:00', '2023-06-04 02:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `id` int(11) NOT NULL,
  `tenant_studnum` varchar(50) NOT NULL,
  `tenant_name` varchar(50) NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `origin` varchar(50) NOT NULL,
  `time_out` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `logdate` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`id`, `tenant_studnum`, `tenant_name`, `time_in`, `origin`, `time_out`, `destination`, `logdate`, `status`) VALUES
(209, '201912379', 'Mary Rose Magdaraog', '07:37:54 PM', 'Class', '07:37:40 PM', 'Class', '2023-05-30', 1),
(210, '201912379', 'Mary Rose Magdaraog', '07:38:31 PM', 'Class', '07:38:18 PM', 'Class', '2023-05-30', 1),
(211, '201912417', 'Mayvel Landicho', '07:38:41 PM', 'Class', '07:38:37 PM', 'Class', '2023-05-30', 1),
(212, '201911913', 'Nicole  Beltrano', '07:38:54 PM', 'Class', '07:38:50 PM', 'Class', '2023-05-30', 1),
(213, '201912452', 'Justine Baguion', '07:39:02 PM', 'Class', '07:38:58 PM', 'Class', '2023-05-30', 1),
(214, '201912379', 'Mary Rose Magdaraog', '10:18:53 PM', 'Class', '10:18:51 PM', 'Class', '2023-05-30', 1),
(215, '201912417', 'Mayvel Landicho', '10:19:34 PM', 'Class', '10:19:32 PM', 'Class', '2023-05-30', 1),
(216, '201912379', 'Mary Rose Magdaraog', '10:20:15 PM', 'Class', '10:20:12 PM', 'Class', '2023-05-30', 1),
(217, '201912417', 'Mayvel Landicho', '10:20:21 PM', 'Class', '10:20:19 PM', 'Class', '2023-05-30', 1),
(218, '201911913', 'Nicole  Beltrano', '10:20:30 PM', 'Class', '10:20:26 PM', 'Class', '2023-05-30', 1),
(219, '201912452', 'Justine Baguion', '10:20:42 PM', 'Class', '10:20:40 PM', 'Class', '2023-05-30', 1),
(220, '201912452', 'Justine Baguion', '10:21:33 PM', 'Class', '10:21:30 PM', 'Class', '2023-05-30', 1),
(221, '201911913', 'Nicole  Beltrano', '10:21:48 PM', 'Class', '10:21:43 PM', 'Class', '2023-05-30', 1),
(222, '201912417', 'Mayvel Landicho', '10:21:58 PM', 'Class', '10:21:55 PM', 'Class', '2023-05-30', 1),
(223, '201912379', 'Mary Rose Magdaraog', '10:22:23 PM', 'Class', '10:22:20 PM', 'Class', '2023-05-30', 1),
(224, '201911837', 'Mark Lumongsod', '10:23:28 PM', 'Class', '10:23:24 PM', 'Class', '2023-05-30', 1),
(225, '201911837', 'Mark Lumongsod', '10:25:37 PM', 'Class', '10:25:29 PM', 'Class', '2023-05-30', 1),
(226, '201911837', 'Mark Lumongsod', '10:25:46 PM', 'Class', '10:25:42 PM', 'Class', '2023-05-30', 1),
(227, '201911837', 'Mark Lumongsod', '10:26:29 PM', 'Class', '10:26:25 PM', 'Class', '2023-05-30', 1),
(228, '201912452', 'Justine Baguion', '07:49:49 AM', 'Class', '07:49:45 AM', 'Class', '2023-06-01', 1),
(229, '201911913', 'Nicole  Beltrano', '07:49:57 AM', 'Class', '07:49:54 AM', 'Class', '2023-06-01', 1),
(230, '201912417', 'Mayvel Landicho', '07:50:07 AM', 'Class', '07:50:01 AM', 'Class', '2023-06-01', 1),
(231, '201912379', 'Mary Rose Magdaraog', '07:50:14 AM', 'Class', '07:50:11 AM', 'Class', '2023-06-01', 1),
(232, '201811895', 'elle Fernandez', '09:30:02 AM', 'Class', '09:29:36 AM', 'Class', '2023-06-01', 1),
(233, '201811895', 'elle Fernandez', '09:35:17 AM', 'Class', '09:34:07 AM', 'Class', '2023-06-01', 1),
(234, '201912379', 'Mary Rose Magdaraog', '12:26:30 PM', 'Class', '12:26:17 PM', 'Class', '2023-06-04', 1),
(235, '201912379', 'Mary Rose Magdaraog', '12:53:04 AM', 'Umall', '12:49:17 AM', 'Other', '2023-06-11', 1),
(236, '201912379', 'Mary Rose Magdaraog', '12:53:24 AM', 'Umall', '12:53:18 AM', 'Umall', '2023-06-11', 1),
(237, '201912379', 'Mary Rose Magdaraog', '12:53:44 AM', 'Home', '12:53:41 AM', 'Home', '2023-06-11', 1),
(238, '201912417', 'Mayvel Landicho', '12:54:17 AM', 'Umall', '12:54:07 AM', 'Umall', '2023-06-11', 1),
(239, '201912417', 'Mayvel Landicho', '12:54:50 AM', 'Part-time job', '12:54:47 AM', 'Part-time job', '2023-06-11', 1),
(240, '201912417', 'Mayvel Landicho', '12:55:15 AM', 'Go to Umall', '12:55:09 AM', 'Go to Umall', '2023-06-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `tenants_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthdate` varchar(100) NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `contactnumber` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `studnum` int(20) NOT NULL,
  `year` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `guardianname` varchar(50) NOT NULL,
  `guardianoccupation` varchar(100) NOT NULL,
  `guardianemail` varchar(100) NOT NULL,
  `guardianaddress` varchar(100) NOT NULL,
  `guardiancontact` varchar(20) NOT NULL,
  `relation` varchar(50) NOT NULL,
  `room` varchar(50) NOT NULL,
  `dorm_name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`tenants_id`, `fname`, `mname`, `lname`, `gender`, `birthdate`, `birthplace`, `contactnumber`, `email`, `address`, `studnum`, `year`, `course`, `department`, `guardianname`, `guardianoccupation`, `guardianemail`, `guardianaddress`, `guardiancontact`, `relation`, `room`, `dorm_name`, `status`, `date_created`) VALUES
(101, 'Ivan Raisen', '', 'Abad', 'Male', '2000-01-01', 'General Trias, Cavite', '09123456789', 'abad@gmail.com', 'General Trias, Cavite', 201912476, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'Jaime Abad', 'None', 'jaime@gmail.com', 'General Trias, Cavite', '09123456789', 'Father', '101', 'Mens Dorm', 'Active', '2023-05-29 11:36:09 PM'),
(102, 'Reynalyn', '', 'Avilla', 'Female', '2000-01-05', 'Trece Martires, Cavite', '09123456789', 'reynalyn@gmail.com', 'Trece Martires, Cavite', 201515530, 'BSN4-1', 'Bachelor of Science in Nursing (BSN)', '', 'Reylan Avilla', 'None', 'reylan@gmail.com', 'Trece Martires, Cavite', '09123456789', 'Father', '101', 'International House II', 'Active', '2023-05-29 11:42:36 PM'),
(103, 'Justine', '', 'Baguion', 'Male', '2000-02-08', 'Imus, Cavite', '09123456789', 'justine@gmail.com', 'Imus, Cavite', 201912452, 'BSIE4-1', 'Bachelor of Science in Industrial Engineering (BSIE)', '', 'Janice Baguion', 'None', 'janice@gmail.com', 'Imus, Cavite', '09123456789', 'Father', '101', 'Mens Dorm', 'Active', '2023-05-29 11:45:18 PM'),
(104, 'Nicole ', '', 'Beltrano', 'Female', '1998-01-15', 'Dasmarinas, Cavite', '09123456789', 'nicole@gmail.com', 'Dasmarinas, Cavite', 201911913, 'BSHM4-3', 'Bachelor of Science in Hospitality Management (BSHM)', '', 'Anne Beltrano', 'None', 'anne@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Mother', '101', 'International House II', 'Active', '2023-05-29 11:47:32 PM'),
(105, 'Michael', '', 'Blanco', 'Male', '1999-06-08', 'Las Pinas City', '09123456789', 'michael@gmail.com', 'Las Pinas City', 201911939, 'BSAM4-2', 'Bachelor of Science in Applied Mathematics (BSAM)', '', 'Dante Blanco', 'None', 'dante@gmail.com', 'Las Pinas City', '09123456789', 'Father', '101', 'Mens Dorm', 'Active', '2023-05-29 11:51:21 PM'),
(106, 'Renz', '', 'Campos', 'Male', '1998-05-12', 'Dasmarinas, Cavite', '09123456789', 'renz@gmail.com', 'Dasmarinas, Cavite', 201912543, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'Loiue Campos', 'None', 'louie@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Father', '101', 'Mens Dorm', 'Active', '2023-05-29 11:53:25 PM'),
(107, 'John Rey', '', 'Cempron', 'Male', '2001-07-17', 'Dasmarinas, Cavite', '09123456789', 'john@gmail.com', 'Dasmarinas, Cavite', 201912590, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'JC Cempron', 'None', 'jc@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Sister', '101', 'Mens Dorm', 'Active', '2023-05-29 11:55:12 PM'),
(108, 'Jandale', '', 'Dahab', 'Male', '2000-06-05', 'Tagaytay City', '09123456789', 'jandale@gmail.com', 'Tagaytay City', 201912898, 'BSMT4-1', 'Bachelor of Science in Medical Technology (BSMT)', '', 'Dale Dahab', 'None', 'dale@gmail.com', 'Tagaytay City', '09123456789', 'Father', '101', 'Mens Dorm', 'Active', '2023-05-29 11:57:22 PM'),
(109, 'Shandy', '', 'Dino', 'Female', '2000-10-11', 'Trece Marteris, Cavite', '09123456789', 'shandy@gmail.com', 'Trece Marteris, Cavite', 201912373, 'BSCE4-5', 'Bachelor of Science in Civil Engineering (BSCE)', '', 'Jhen Dino', 'None', 'jen@gmail.com', 'Trece Martires, Cavite', '09123456789', 'Mother', '101', 'International House II', 'Active', '2023-05-29 11:59:46 PM'),
(110, 'John Rafael', '', 'Eleserio', 'Male', '2000-06-01', 'Trece Marteris, Cavite', '09123456789', 'eleserio@gmail.com', 'Trece Marteris, Cavite', 201912478, 'BSCS4-1', 'Bachelor of Science in Computer Science (BS CS)', '', 'Jona Eleserio', 'None', 'jona@gmail.com', 'Trece Martires, Cavite', '09123456789', 'Mother', '101', 'Mens Dorm', 'Active', '2023-05-30 12:02:15 AM'),
(111, 'Maribel ', '', 'Estaris', 'Female', '1996-06-05', 'Bancod, Indang Cavite', '09123456789', 'maribel@gmail.com', 'Bancod, Indang Cavite', 201912445, 'BSCE4-2', 'Bachelor of Science in Civil Engineering (BSCE)', '', 'Marie Estaris', 'None', 'marie@gmail.com', 'Bancod, Indang Cavite', '09123456789', 'Mother', '101', 'International House II', 'Active', '2023-05-30 12:04:12 AM'),
(112, 'Lois', '', 'Floro', 'Male', '1999-11-17', 'Dasmarinas, Cavite', '09123456789', 'lois@gmail.com', 'Dasmarinas, Cavite', 201912325, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'John Floro', 'None', 'john@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Father', '101', 'Mens Dorm', 'Active', '2023-05-30 12:06:05 AM'),
(113, 'Josh Carl', '', 'Javier', 'Male', '2001-06-15', 'Silang, Cavite', '09123456789', 'josh@gmail.com', 'Silang, Cavite', 201912133, 'BPED4-1', 'Bachelor of Physical Education (BPEd)', '', 'Anthony Javier', 'None', 'anthony@gmail.com', 'Silang, Cavite', '09123456789', 'Father', '102', 'Mens Dorm', 'Active', '2023-05-30 12:07:43 AM'),
(114, 'Mayvel', '', 'Landicho', 'Female', '1999-07-19', 'Trece Marteris, Cavite', '09123456789', 'mayvel@gmail.com', 'Trece Marteris, Cavite', 201912417, 'BEE4-5', 'Bachelor of Elementary Education (BEE)', '', 'May Landicho', 'None', 'may@gmail.com', 'Trece Marteris, Cavite', '09123456789', 'Mother', '102', 'International House II', 'Active', '2023-05-30 12:09:35 AM'),
(115, 'Richard', '', 'Lanuza', 'Male', '2000-06-12', 'General Trias, Cavite', '09123456789', 'richard@gmail.com', 'General Trias, Cavite', 202016737, 'BSCE4-5', 'Bachelor of Science in Civil Engineering (BSCE)', '', 'Elle Lanuza', 'None', 'elle@gmail.com', 'General Trias, Cavite', '09123456789', 'Mother', '102', 'Mens Dorm', 'Active', '2023-05-30 12:12:18 AM'),
(116, 'Mark', '', 'Lumongsod', 'Male', '2000-12-11', 'Surigao Del Norte', '09651284882', 'marklumongsod78@gmail.com', 'Block 57 lot 18 westpoint st. metropolis subdivision manggahan General Trias, Cavite', 201911837, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'Ellen Lumongsod', 'None', 'ellenlumongsod@gmail.com', 'General Trias, Cavite', '09123456789', 'Mother', '102', 'Mens Dorm', 'Active', '2023-05-30 12:15:14 AM'),
(117, 'Mary Rose', '', 'Magdaraog', 'Female', '2001-06-06', 'Trece Marteris, Cavite', '09123456789', 'maryrose@gmail.com', 'Trece Marteris, Cavite', 201912379, 'BEE4-5', 'Bachelor of Elementary Education (BEE)', '', 'Rose Magdaraog', 'None', 'rose@gmail.com', 'Trece Martires, Cavite', '09123456789', 'Mother', '102', 'International House II', 'Active', '2023-05-30 12:16:54 AM'),
(118, 'Florenz ', '', 'Manjares', 'Male', '1998-07-17', 'Silang, Cavite', '09123456789', 'florenz@gmail.com', 'Silang, Cavite', 201912484, 'BSESS3-2', 'Bachelor of Exercise and Sports Sciences (BSESS)', '', 'Renz Manjares', 'None', 'renz@gmail.com', 'Silang, Cavite', '09123456789', 'Father', '102', 'Mens Dorm', 'Active', '2023-05-30 12:18:50 AM'),
(119, 'Miriam ', '', 'Medina', 'Male', '2000-07-19', 'General Trias, Cavite', '09123456789', 'miriam@gmail.com', 'General Trias, Cavite', 201911865, 'BAPS4-3', 'Bachelor of Arts in Political Science (BAPS)', '', 'Faith Medina', 'None', 'faith@gmail.com', 'General Trias, Cavite', '09123456789', 'Mother', '102', 'International House II', 'Active', '2023-05-30 12:20:04 AM'),
(120, 'Erica', '', 'Muncada', 'Female', '2000-09-05', 'Naic, Cavite', '09123456789', 'erica@gmail.com', 'Naic, Cavite', 201911895, 'BA', 'Bachelor of Arts in Political Science (BAPS)', '', 'Joyce Muncada', 'None', 'joyce@gmail.com', 'Naic, Cavite', '09123456783', 'Mother', '102', 'International House II', 'Active', '2023-05-30 12:22:08 AM'),
(121, 'Lyza', '', 'Nano', 'Female', '2000-08-02', 'Silang, Cavite', '09123456789', 'lyza@gmail.com', 'Silang, Cavite', 201911893, 'BSCS4-1', 'Bachelor of Science in Computer Science (BS CS)', '', 'Czam Nano', 'None', 'czam@gmail.com', 'Silang, Cavite', '09123456789', 'Mother', '103', 'International House II', 'Active', '2023-05-30 12:24:40 AM'),
(122, 'John Zedric', '', 'Papa', 'Male', '2001-07-17', 'Dasmarinas, Cavite', '09123456789', 'johnzed@gmail.com', 'Dasmarinas, Cavite', 201911937, 'BSESS4-2', 'Bachelor of Exercise and Sports Sciences (BSESS)', '', 'john Papa', 'None', 'johnpapa@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Mother', '102', 'Mens Dorm', 'Active', '2023-05-30 12:26:59 AM'),
(123, 'Gene ', '', 'Portades', 'Male', '1999-01-14', 'Trece Martires, Cavite', '09123456789', 'gene@gmail.com', 'Trece Martires, Cavite', 201912517, 'BECE4-2', 'Bachelor of Early Childhood Education BECE)', '', 'Austin Portades', 'None', 'austin@gmail.com', 'Trece Martires, Cavite', '09123456789', 'Father', '102', 'Mens Dorm', 'Active', '2023-05-30 12:28:37 AM'),
(124, 'Arianne', '', 'Quimpo', 'Male', '2000-02-15', 'Dasmarinas, Cavite', '09123456789', 'arianne@gmail.com', 'Dasmarinas, Cavite', 201912344, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'Janeth Quimpo', 'None', 'janeth@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Mother', '102', 'Mens Dorm', 'Active', '2023-05-30 12:30:06 AM'),
(125, 'John Mark', '', 'Romero', 'Male', '2000-10-20', 'Silang, Cavite', '09123456789', 'johnmark@gmail.com', 'Silang, Cavite', 201912483, 'BAPS4-3', 'Bachelor of Arts in Political Science (BAPS)', '', 'John Raf Romero', 'None', 'raf@gmail.com', 'Silang, Cavite', '09123456789', 'Father', '102', 'Mens Dorm', 'Active', '2023-05-30 12:31:23 AM'),
(126, 'Rachel ', '', 'Salera', 'Female', '1998-10-15', 'Silang, Cavite', '09123456789', 'rachel@gmail.com', 'Silang, Cavite', 201912419, 'BSNE4-1', 'Bachelor of Special Needs Education (BSNE)', '', 'Mae Salera', 'None', 'mae@gmail.com', 'Silang, Cavite', '09123456784', 'Mother', '103', 'International House II', 'Active', '2023-05-30 12:33:10 AM'),
(127, 'Ahmille John', '', 'Saludar', 'Male', '2000-10-26', 'Trece Marteris, Cavite', '09123456789', 'ahmille@gmail.com', 'Trece Marteris, Cavite', 201912480, 'BSESS4-2', 'Bachelor of Exercise and Sports Sciences (BSESS)', '', 'Ahmilly Saludar', 'None', 'ahmilly@gmail.com', 'Silang, Cavite', '09123456789', 'Mother', '103', 'Mens Dorm', 'Active', '2023-05-30 12:34:37 AM'),
(128, 'Cesar', '', 'Samson', 'Male', '1998-11-25', 'Las Pinas City', '09123456789', 'cesar@gmail.com', 'Las Pinas City', 201912320, 'BSBM4-3', 'Bachelor of Science in Business Management (BSBM)', '', 'Adrianne Samson', 'None', 'adriaanne@gmail.com', 'Las Pinas City', '09123456789', 'Father', '103', 'Mens Dorm', 'Active', '2023-05-30 12:35:55 AM'),
(129, 'Dennise', '', 'Siona', 'Female', '2000-02-10', 'Las Pinas City', '09123456789', 'siona@gmail.com', 'Las Pinas City', 201912573, 'BSCE4-3', 'Bachelor of Science in Civil Engineering (BSCE)', '', 'Denden Siona', 'None', 'denden@gmail.com', 'Las Pinas City', '09123456789', 'Mother', '103', 'International House II', 'Active', '2023-05-30 12:37:40 AM'),
(130, 'Jan Mc Rae', '', 'Soriano', 'Male', '2000-07-04', 'Dasmarinas, Cavite', '09123456789', 'mcrae@gmail.com', 'Dasmarinas, Cavite', 201912072, 'BSESS4-2', 'Bachelor of Exercise and Sports Sciences (BSESS)', '', 'Jana Soriano', 'None', 'jana@gmail.com', 'Dasmarinas, Cavite', '09123456789', 'Mother', '103', 'Mens Dorm', 'Active', '2023-05-30 12:38:52 AM'),
(131, 'Tricia', '', 'Terrado', 'Male', '2000-03-09', 'Silang, Cavite', '09123456789', 'tricia@gmail.com', 'Silang, Cavite', 201810716, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'Trish Terrado', 'None', 'trish@gmail.com', 'Silang, Cavite', '09123456789', 'Mother', '103', 'International House II', 'Active', '2023-05-30 12:40:21 AM'),
(133, 'Elle', '', 'Fernandez', 'Female', '2000-01-12', 'General Trias Cavite', '09134567897', 'elle@gmail.com', 'General Trias Cavite', 201811895, 'BSIT4-2', 'Bachelor of Science in Information Technology (BSIT)', '', 'Ellie Lanuza', 'None', 'ellie@gmail.com', 'General Trias, Cavite', '09123456789', 'Mother', '104', 'International House II', 'Active', '2023-06-01 08:51:17 AM');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `acc_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`acc_id`, `username`, `password`, `fullname`, `role`, `email`, `contact_number`, `date_created`, `date_updated`) VALUES
(8, 'superadmin', 'superadmin', 'CvSu Administrator', 'Super Administrator', 'cvsuadministrator@cvsu.edu.ph', '09123456789', '', ''),
(9, 'admin1', 'admin1', 'Mark Lumsy', 'Dormitory Manager', 'mark_lums@cvsu.edu.ph', '09123456789', '2023-06-10 02:47:45 PM', '2023-06-11 09:31:14 AM'),
(10, 'admin', 'admin', 'Marte Babaan', 'Dormitory Manager', 'marte_babaan@cvsu.edu.ph', '09123456789', '2023-06-10 03:19:55 PM', '2023-06-10 03:20:16 PM');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `visit_person` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `time_out` varchar(50) NOT NULL,
  `logdate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `name`, `room_number`, `visit_person`, `purpose`, `time_in`, `time_out`, `logdate`) VALUES
(78, 'Yeseo Fernandez', 'Mens Dorm 102', '201911837', 'Parent family visit', '07:56:01 PM', '07:56:26 PM', '2023-05-30'),
(79, 'Jon rey', 'Mens Dorm 103', '201912320', 'Parent family visit', '09:37:50 AM', '09:38:01 AM', '2023-06-01'),
(80, 'Paolo Velasques', 'International House II 102', '201911865', 'To meet', '12:47:54 AM', '12:47:56 AM', '2023-06-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dorm_list`
--
ALTER TABLE `dorm_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_list`
--
ALTER TABLE `room_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`tenants_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dorm_list`
--
ALTER TABLE `dorm_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

--
-- AUTO_INCREMENT for table `room_assignments`
--
ALTER TABLE `room_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `room_list`
--
ALTER TABLE `room_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `tenants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
