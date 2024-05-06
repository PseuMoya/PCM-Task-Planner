-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 10:06 AM
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
  `proof` varchar(255) NOT NULL,
  `task_img` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `task_info`
--

INSERT INTO `task_info` (`task_id`, `t_title`, `t_description`, `t_start_time`, `t_end_time`, `t_user_id`, `status`, `role`, `proof`, `task_img`) VALUES
(267, 'dsadasd', 'asdfsad', '2024-04-21 11:41:00', '2024-04-30 12:00:00', 74, 0, '', '', 'task_image/photo_6226686029616757666_w.jpg'),
(268, 'sadasd', 'asdas', '2024-04-21 11:46:00', '2024-05-08 11:46:00', 27, 0, '', 'uploads/taskplanner.sql', 'uploads/taskplanner (3).sql'),
(264, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 68, 0, '', '', 'task_image/Weekly Journal (Midterm).pdf'),
(263, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 32, 0, '', '', 'task_image/Weekly Journal (Midterm).pdf'),
(262, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 35, 0, '', 'uploads/miyazakibluey3_HD.png', 'task_image/Weekly Journal (Midterm).pdf'),
(261, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 27, 0, '', '', 'task_image/Weekly Journal (Midterm).pdf'),
(260, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 66, 0, '', '', 'task_image/Weekly Journal (Midterm).pdf'),
(259, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 62, 1, '', 'uploads/Weekly Journal NACO (Midterm).docx', 'uploads/APPRAISAL-NACO (1).doc'),
(256, 'Joshua 2', 'Joshua task 2 remake this logo', '2024-04-21 10:56:00', '2024-04-27 10:56:00', 27, 2, '', 'uploads/Weekly Journal (Midterm).pdf', 'uploads/LISTTOAPPLY.xlsx'),
(257, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 67, 0, '', '', 'task_image/Weekly Journal (Midterm).pdf'),
(251, 'dwa', 'dwa', '2024-04-18 17:09:00', '2024-04-29 17:09:00', 27, 0, '', 'uploads/Phosclaysales.png', ''),
(258, 'Task Proj', 'Joshua brian', '2024-04-21 11:35:00', '2024-04-30 11:35:00', 64, 0, '', '', 'task_image/Weekly Journal (Midterm).pdf'),
(254, 'dsad', 'sadsadsa', '2024-04-21 10:35:00', '2024-04-30 10:35:00', 27, 0, '', 'uploads/photo_6226686029616757666_w.jpg', 'uploads/OPTION 1.png'),
(255, 'Joshua Task mo to', 'Joshua Task mo to', '2024-04-21 10:41:00', '2024-04-25 10:41:00', 27, 2, '', 'uploads/bg-login.png', 'uploads/photo_6226686029616757666_w.jpg'),
(269, 'test', 'testtest', '2024-04-22 14:54:00', '2024-04-30 14:54:00', 35, 0, '', '', 'uploads/TSHIRT LOGO (1000 x 1900 px) (1).pdf'),
(270, 'erwerwe', 'werefwefwecwef', '2024-04-23 16:54:00', '2024-04-30 16:54:00', 35, 2, '', 'uploads/a-quick-photoshop-session-3840x2160-v0-lr0f8awbw9vc1.jpeg', 'task_image/taskplanner (4).sql'),
(271, 'ayusin yung PC sa baba', 'OS error', '2024-04-23 17:18:00', '2024-04-23 18:00:00', 35, 2, '', 'uploads/TSHIRT LOGO (1000 x 1900 px) (1).pdf', ''),
(272, 'Ipagtimpla ng kape', 'kape', '2024-04-23 17:21:00', '2024-04-23 18:00:00', 35, 3, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `user_id` int(20) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `school` varchar(255) NOT NULL,
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

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `school`, `email`, `password`, `temp_password`, `user_role`, `position`, `profileimg`) VALUES
(1, 'Admin', 'admin', '', 'admin@gmail.com', 'eb31505f5a6ce824ecfadb34bd082df2', NULL, 1, 'Super Admin', 'uploads/admin-pro.png'),
(27, 'Joshua Brian Naco', 'owa25', 'STI', 'joshua@gmail.com', 'bf9b62aa00e7986fa75ef400f06d57e5', '', 2, 'IT Department', 'uploads/amogus-sus.gif'),
(73, 'uwa1', 'uwa1', '???', 'uwa1@gmail.com', '296899708fb8008a563e28258bddb81d', '', 2, 'IT Department', 'uploads/logo-stona.png'),
(68, 'testing', 'testing', '???', 'test@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/admin-pro.png'),
(32, 'Shena De Villa', 'Shena De Villa', 'STI', 'shena@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/327263586_1377776209658173_7531008158225813132_n.jpg'),
(35, 'Mark John Escalona', 'sanecola', 'STI', 'mj@gmail.com', 'f6a161408d8bf58cf46f6f218a9f9713', '', 2, 'IT Department', 'uploads/Screenshot 2024-04-11 115711.png'),
(67, 'Neggi Catsu', 'Neggi', 'PCM', 'neggi@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'Hr Department', 'uploads/make me ai man  d1617e83-24c9-44cb-be92-e4f49e7ac92f.png'),
(66, 'Ken Angelo Villaflor', 'Ken Angelo Villaflor', 'STI', 'ken@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/165332_140385546019759_2777306_n.jpg'),
(62, 'Perry Moya', 'Perry Moya', 'STI', 'moya@gmail.com', '202cb962ac59075b964b07152d234b70', '', 2, 'IT Department', 'uploads/344084020_900713994349774_6446866760258364420_n.jpg'),
(64, 'Tricia Cabias', 'Tricia Cabias', 'STI', 'tricia@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'IT Department', 'uploads/Screenshot 2024-04-11 115620.png'),
(70, 'PIETRO MARTINO', 'pieto', '???', 'pier@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '', 2, 'Marketing Department', 'uploads/admin-pro.png'),
(74, 'pcm', 'pcm', 'STI', 'pcm@gmail.com', 'aee67d9bb569ad1562f7b67cfccbd2ef', '', 2, 'Admin Department', 'uploads/miyazakibluey3.png');

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
  MODIFY `task_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
