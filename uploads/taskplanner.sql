-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 08:57 AM
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
-- Database: `taskplanner`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_info`
--

CREATE TABLE `attendance_info` (
  `aten_id` int(20) NOT NULL,
  `atn_user_id` int(20) NOT NULL,
  `in_time` varchar(200) DEFAULT NULL,
  `out_time` varchar(150) DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attendance_info`
--

INSERT INTO `attendance_info` (`aten_id`, `atn_user_id`, `in_time`, `out_time`, `total_duration`) VALUES
(42, 1, '22-03-2021 22:01:43', '03-04-2024 13:35:41', '15:33:58'),
(43, 27, '30-03-2024 10:08:27', '03-04-2024 13:35:40', '03:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `task_info`
--

CREATE TABLE `task_info` (
  `task_id` int(50) NOT NULL,
  `t_title` varchar(120) NOT NULL,
  `t_description` text DEFAULT NULL,
  `t_start_time` datetime DEFAULT NULL,
  `t_end_time` datetime DEFAULT NULL,
  `t_user_id` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = In progress, 2 = complete',
  `role` varchar(100) NOT NULL,
  `proof` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `task_info`
--

INSERT INTO `task_info` (`task_id`, `t_title`, `t_description`, `t_start_time`, `t_end_time`, `t_user_id`, `status`, `role`, `proof`) VALUES
(52, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 31, 3, '', ''),
(53, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 33, 3, '', ''),
(72, 'dscsd', 'dcdsc', '2024-04-11 13:53:00', '2024-04-11 13:55:00', 27, 3, '', 'proof/165332_140385546019759_2777306_n.jpg'),
(43, 'erwrwerwe', 'wwwwerw', '2024-04-09 11:34:00', '2024-04-09 11:34:00', 30, 3, '', ''),
(44, 'erwrwerwe', 'wwwwerw', '2024-04-09 11:34:00', '2024-04-09 11:34:00', 31, 3, '', ''),
(45, 'new task to do', 'GROUP', '2024-04-09 11:39:00', '2024-04-09 11:39:00', 0, 3, '', ''),
(46, 'new task to do', 'GROUP', '2024-04-09 11:39:00', '2024-04-09 11:39:00', 0, 3, '', ''),
(48, 'GROUP PROJ', 'GROUP PROJ', '2024-04-09 11:46:00', '2024-04-09 11:46:00', 30, 3, '', ''),
(49, 'GROUP PROJ', 'GROUP PROJ', '2024-04-09 11:46:00', '2024-04-09 11:46:00', 31, 3, '', ''),
(51, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 30, 3, '', ''),
(55, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 53, 3, '', ''),
(56, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 54, 3, '', ''),
(57, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 60, 3, '', ''),
(58, 'NEW GROUP PROJ', 'wqewqeqw', '2024-04-09 12:02:00', '2024-04-09 12:02:00', 61, 3, '', ''),
(61, 'newwwwwwwwwwwww1', 'lkwrtlkwn', '2024-04-09 13:04:00', '2024-04-09 13:04:00', 33, 3, '', ''),
(62, 'newwwwwwwwwwwww1', 'lkwrtlkwn', '2024-04-09 13:04:00', '2024-04-09 13:04:00', 34, 3, '', ''),
(65, 'new task april 10', 'kdklvns', '2024-04-10 10:24:00', '2024-04-10 10:24:00', 30, 3, '', ''),
(66, 'NEW TASK MARKETING', 'nlkvnwklnevlk', '2024-04-10 10:44:00', '2024-04-10 10:44:00', 31, 3, '', ''),
(68, 'kjweglkwej', 'fgsdfgfdgdf', '2024-04-10 11:21:00', '2024-04-10 11:21:00', 27, 3, '', 'proof/admin-pro.png'),
(69, 'new task for owa 2', 'essfes', '2024-04-10 12:07:00', '2024-04-20 12:07:00', 27, 0, '', 'proof/344084020_900713994349774_6446866760258364420_n.jpg'),
(70, 'new task ni owa 222222', 'efkhlqwhfkwe', '2024-04-10 16:01:00', '2024-04-11 13:46:00', 27, 3, '', ''),
(71, 'Video Edit', 'Description ........', '2024-04-11 13:04:00', '2024-04-11 13:08:00', 62, 3, '', ''),
(73, 'new task', 'hdlfksklhfkshld', '2024-04-11 14:31:00', '2024-04-17 14:31:00', 27, 0, '', ''),
(74, 'wefwef', 'ewfew', '2024-04-11 14:39:00', '2024-04-17 14:39:00', 27, 1, '', ''),
(75, 'newwwww', 'newww', '2024-04-11 14:42:00', '2024-05-23 12:42:00', 27, 2, '', ''),
(76, 'new task mo owa', 'kenlkfnwlk', '2024-04-11 15:33:00', '2024-04-18 15:33:00', 27, 2, '', 'proof/admin-pro.png'),
(77, 'joshua owa', 'owa', '2024-04-11 15:38:00', '2024-04-18 15:38:00', 27, 2, '', 'proof/Version 2 (2).png'),
(78, 'task new kay owa', 'ionwevcwoivno', '2024-04-12 09:48:00', '2024-04-12 09:50:00', 27, 3, '', ''),
(79, 'NEW TASK 25', 'kngdslkgkls', '2024-04-12 09:51:00', '2024-04-20 09:51:00', 27, 2, '', 'proof/Screenshot 2024-04-11 115620.png'),
(80, 'new task', 'lkevhdlkh', '2024-04-12 10:53:00', '2024-04-12 10:53:00', 67, 3, '', ''),
(90, 'rgergeger', 'egege', '2024-04-12 14:24:00', '2024-04-12 14:24:00', 0, 3, '', ''),
(88, 'wev', 'ewv', '2024-04-12 14:17:00', '2024-04-12 14:17:00', 67, 3, '', ''),
(94, 'ewcw', 'ecwc', '2024-04-15 12:00:00', '2024-04-17 12:00:00', 27, 0, '', ''),
(93, 'joshua task', 'righwlkhgw', '2024-04-16 10:36:00', '2024-04-25 10:38:00', 27, 2, '', ''),
(95, 'asdas', 'sads', '2024-04-16 11:29:00', '2024-04-24 11:29:00', 27, 0, '', ''),
(96, 'kldfjsklflksd', 'dsfdsf', '2024-04-15 14:53:00', '2024-04-17 14:53:00', 0, 0, '', ''),
(97, 'ewfewfewfew', 'wefewfew', '2024-04-16 14:55:00', '2024-04-18 14:55:00', 0, 0, '', ''),
(98, 'joshua task now', 'klhefwlkhl', '2024-04-15 14:56:00', '2024-04-15 14:56:00', 0, 3, '', ''),
(99, 'ewlfkhwelk', 'lkefwhlkf', '2024-04-15 14:58:00', '2024-04-15 14:58:00', 0, 3, '', ''),
(100, 'ewfewf', 'ewfwef', '2024-04-15 14:59:00', '2024-04-15 14:59:00', 27, 3, '', ''),
(101, 'joshua new task', 'jdspodjso', '2024-04-15 14:59:00', '2024-04-15 14:59:00', 27, 3, '', ''),
(200, 'dfdsfdsf', 'jkhjhsdfkjs', '2024-04-16 11:25:00', '2024-04-24 12:00:00', 27, 1, '', ''),
(199, 'new task ko sa side ko', 'jbwnvjkbv', '2024-04-16 11:28:00', '2024-04-23 12:00:00', 27, 1, '', ''),
(191, 'massive posting', 'posting', '2024-04-16 11:23:00', '2024-04-30 12:00:00', 62, 2, '', ''),
(202, 'trewte', 'ewttewtew', '2024-04-16 12:00:00', '2024-04-30 12:00:00', 27, 0, '', ''),
(201, 'weqe', 'weqweqw', '2024-04-16 12:00:00', '2024-04-17 12:00:00', 27, 0, '', ''),
(195, 'pERRY', 'FKJDSFJIORE', '2024-04-08 09:13:00', '2024-04-30 12:00:00', 27, 1, '', ''),
(194, 'new task joshua', 'hlksdhflk', '2024-04-16 11:23:00', '2024-04-30 12:00:00', 27, 1, '', ''),
(192, 'massive posting', 'posting', '2024-04-16 11:23:00', '2024-04-30 12:00:00', 64, 1, '', ''),
(190, 'massive posting', 'posting', '2024-04-16 11:24:00', '2024-05-01 12:00:00', 66, 1, '', ''),
(198, 'new task ni uwa', 'dnvkljsnvjkbs', '2024-04-16 11:23:00', '2024-04-30 12:00:00', 27, 1, '', ''),
(174, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 67, 3, '', ''),
(189, 'massive posting', 'posting', '2024-04-16 11:24:00', '2024-05-07 12:00:00', 35, 2, '', ''),
(188, 'massive posting', 'posting', '2024-04-16 11:24:00', '2024-04-16 11:24:00', 32, 3, '', ''),
(187, 'massive posting', 'posting', '2024-04-16 11:24:00', '2024-04-16 11:24:00', 68, 3, '', ''),
(186, 'massive posting', 'posting', '2024-04-16 11:28:00', '2024-04-16 11:28:00', 27, 3, '', ''),
(185, 'massive posting', 'posting', '2024-04-16 11:31:00', '2024-04-17 11:31:00', 67, 0, '', ''),
(184, 'sacskalckKLAELKkla', 'kwdhvklhkldv', '2024-04-15 16:11:00', '2024-04-15 16:11:00', 27, 3, '', ''),
(181, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 64, 3, '', ''),
(180, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 62, 3, '', ''),
(179, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 66, 3, '', ''),
(178, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 35, 3, '', ''),
(177, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 32, 3, '', ''),
(176, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 68, 3, '', ''),
(175, 'new task', 'new task', '2024-04-15 16:07:00', '2024-04-15 16:07:00', 27, 3, '', ''),
(173, 'joshua new task mo yern', 'lkjhvklsf', '2024-04-16 11:29:00', '2024-04-16 11:29:00', 27, 3, '', ''),
(146, 'Stop', '1 task', '2024-04-15 15:37:00', '2024-04-15 15:37:00', 66, 3, '', ''),
(147, 'Stop', '1 task', '2024-04-15 15:37:00', '2024-04-15 15:37:00', 62, 3, '', ''),
(148, 'Stop', '1 task', '2024-04-15 15:37:00', '2024-04-15 15:37:00', 64, 3, '', ''),
(172, 'sdmndkskjdkl', 'lkjslkjskl', '2024-04-16 11:29:00', '2024-04-16 11:29:00', 27, 3, '', ''),
(171, 'fewfewf', 'wefew', '2024-04-15 16:05:00', '2024-04-15 16:05:00', 27, 3, '', ''),
(170, 'dscsdc', 'cdscs', '2024-04-15 16:04:00', '2024-04-15 16:04:00', 27, 3, '', ''),
(169, 'efwewfwe', 'ewfwef', '2024-04-15 16:03:00', '2024-04-15 16:03:00', 0, 3, '', ''),
(196, 'mag resign', 'yoko na', '2024-04-01 09:18:00', '2024-04-30 12:00:00', 70, 1, '', ''),
(150, 'e', 'e', '2024-04-15 15:44:00', '2024-04-15 15:44:00', 27, 3, '', ''),
(151, 'hi', 'hi', '2024-04-15 15:47:00', '2024-04-15 15:47:00', 27, 3, '', ''),
(152, 'h', 'h', '2024-04-15 15:50:00', '2024-04-15 15:50:00', 0, 3, '', ''),
(153, 'e', 'e', '2024-04-15 15:52:00', '2024-04-15 15:52:00', 27, 3, '', ''),
(154, 'ecece', 'ec', '2024-04-15 15:52:00', '2024-04-15 15:52:00', 0, 3, '', ''),
(155, 'vrever', 'verver', '2024-04-15 15:53:00', '2024-04-15 15:53:00', 0, 3, '', ''),
(156, 'btrbr', 'rbtb', '2024-04-15 15:53:00', '2024-04-15 15:53:00', 0, 3, '', ''),
(157, 'wecwec', 'ewcwecewce', '2024-04-15 15:53:00', '2024-04-15 15:53:00', 27, 3, '', ''),
(158, 'sdcds', 'dcscs', '2024-04-15 15:54:00', '2024-04-15 15:54:00', 0, 3, '', ''),
(159, 'fewfwefwe', 'ewf', '2024-04-15 15:55:00', '2024-04-15 15:55:00', 0, 3, '', ''),
(160, 'fewf', 'efwwew', '2024-04-15 15:55:00', '2024-04-15 15:55:00', 0, 3, '', ''),
(161, 'fewkfjwkl', 'lkrwkljgljk', '2024-04-15 15:55:00', '2024-04-17 15:55:00', 0, 0, '', ''),
(162, 'fwefwe', 'ewfwef', '2024-04-15 15:55:00', '2024-04-15 15:55:00', 0, 3, '', ''),
(163, 'rvervre', 'revervrev', '2024-04-15 15:56:00', '2024-04-15 15:56:00', 27, 3, '', ''),
(164, 'wce', 'ceec', '2024-04-15 15:56:00', '2024-04-15 15:56:00', 27, 3, '', ''),
(165, 'dglkgjdskljgl', 'kljdglkjskd', '2024-04-15 15:57:00', '2024-04-23 15:57:00', 0, 0, '', ''),
(166, 'regeregeg', 'regegeg', '2024-04-15 15:58:00', '2024-04-16 15:58:00', 0, 0, '', ''),
(167, 'erewrwrrwrwe', 'ewrw', '2024-04-15 15:59:00', '2024-04-15 15:59:00', 0, 3, '', ''),
(168, 'dewdew', 'ewdew', '2024-04-15 16:01:00', '2024-04-15 16:01:00', 0, 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `user_id` int(20) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `user_role` int(10) NOT NULL,
  `position` varchar(100) NOT NULL,
  `profileimg` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `email`, `password`, `temp_password`, `user_role`, `position`, `profileimg`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', 'eb31505f5a6ce824ecfadb34bd082df2', NULL, 1, 'Super Admin', 'uploads/admin-pro.png'),
(27, 'Joshua Brian Naco', 'owa25', 'joshua@gmail.com', 'bf9b62aa00e7986fa75ef400f06d57e5', '', 2, 'IT Department', 'uploads/standard (1).gif'),
(68, 'testing', 'testing', 'test@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/admin-pro.png'),
(32, 'Shena De Villa', 'Shena De Villa', 'shena@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/327263586_1377776209658173_7531008158225813132_n.jpg'),
(35, 'Mj Escalona', 'Mj Escalona', 'mj@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/Screenshot 2024-04-11 115711.png'),
(67, 'Neggi Catsu', 'Neggi', 'neggi@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'Hr Department', 'uploads/make me ai man  d1617e83-24c9-44cb-be92-e4f49e7ac92f.png'),
(66, 'Ken Angelo Villaflor', 'Ken Angelo Villaflor', 'ken@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/165332_140385546019759_2777306_n.jpg'),
(62, 'Perry Moya', 'Perry Moya', 'moya@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/344084020_900713994349774_6446866760258364420_n.jpg'),
(64, 'Tricia Cabias', 'Tricia Cabias', 'tricia@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/Screenshot 2024-04-11 115620.png'),
(70, 'PIETRO MARTINO', 'pieto', 'pier@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'Marketing Department', 'uploads/admin-pro.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_info`
--
ALTER TABLE `attendance_info`
  ADD PRIMARY KEY (`aten_id`);

--
-- Indexes for table `task_info`
--
ALTER TABLE `task_info`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_info`
--
ALTER TABLE `attendance_info`
  MODIFY `aten_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `task_info`
--
ALTER TABLE `task_info`
  MODIFY `task_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
