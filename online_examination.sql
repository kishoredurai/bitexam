-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2020 at 10:34 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_examination`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

DROP TABLE IF EXISTS `admin_table`;
CREATE TABLE IF NOT EXISTS `admin_table` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) NOT NULL,
  `admin_email_address` varchar(150) NOT NULL,
  `admin_password` varchar(150) NOT NULL,
  `admin_gender` varchar(50) NOT NULL,
  `admin_course` varchar(50) NOT NULL,
  `admin_DOB` varchar(50) NOT NULL,
  `admin_contact` varchar(15) NOT NULL,
  `admin_level` varchar(50) NOT NULL,
  `admin_verfication_code` varchar(100) NOT NULL,
  `admin_type` enum('master','sub_master') NOT NULL,
  `admin_created_on` datetime NOT NULL,
  `email_verified` enum('no','yes') NOT NULL,
  PRIMARY KEY (`admin_id`)
);

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email_address`, `admin_password`, `admin_gender`, `admin_course`, `admin_DOB`, `admin_contact`, `admin_level`, `admin_verfication_code`, `admin_type`, `admin_created_on`, `email_verified`) VALUES
(1, 'Kishore D', 'kishore.ct19@bitsathy.ac.in', '$2y$10$uUhIWbMG2yOjk2luklQYI.XywPqsbih3bdEcEY0jGZX3rtYfltYp2', '', '', '0000-00-00', '', '', '16ff672d3717958ce1c56d45e176518b', 'master', '2020-09-03 13:29:30', 'yes'),
(12, 'kishore Durai', 'duraisamy3101@gmail.com', '$2y$10$EYWP849o7SjTVl7dwKY1SO7e.TzL95ojXqiuuZ6vsFCOCsLp9Ahoq', 'Male', 'Computer Science and Engineering', '2001-09-27', '9787688154', 'Professor and Head', 'c75806a4c814fd9cc30cf511646691e2', 'sub_master', '2020-11-26 16:41:20', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `course_table`
--

DROP TABLE IF EXISTS `course_table`;
CREATE TABLE IF NOT EXISTS `course_table` (
  `course_id` int NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `course_table`
--

INSERT INTO `course_table` (`course_id`, `course_name`, `create_date`) VALUES
(1, 'Computer Technology', '2020-11-21 16:32:18'),
(1, 'Computer Science and Engineering', '2020-11-21 16:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `event_table`
--

DROP TABLE IF EXISTS `event_table`;
CREATE TABLE IF NOT EXISTS `event_table` (
  `e_id` int NOT NULL AUTO_INCREMENT,
  `user_year` varchar(50) NOT NULL,
  `user_course` varchar(50) NOT NULL,
  `event_title` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`e_id`)
);

--
-- Dumping data for table `event_table`
--

INSERT INTO `event_table` (`e_id`, `user_year`, `user_course`, `event_title`, `color`, `start`, `end`) VALUES
(15, 'II', 'Computer Science and Engineering', 'Telecommunication complaint app', '#0071c5', '2020-11-22 00:00:00', '2020-11-23 00:00:00'),
(16, 'II', 'Computer Technology\r\n', 'asdasdasdsdfsd', '#008000', '2020-11-17 00:00:00', '2020-11-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_table`
--

DROP TABLE IF EXISTS `feedback_table`;
CREATE TABLE IF NOT EXISTS `feedback_table` (
  `f_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `feed_type` varchar(50) NOT NULL,
  `feed` varchar(100) NOT NULL,
  `feed_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `feed_remark` varchar(100) NOT NULL,
  `staff_id` int NOT NULL,
  `feed_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `feed_image` varchar(150) NOT NULL,
  PRIMARY KEY (`f_id`)
);

--
-- Dumping data for table `feedback_table`
--

INSERT INTO `feedback_table` (`f_id`, `user_id`, `feed_type`, `feed`, `feed_status`, `feed_remark`, `staff_id`, `feed_timestamp`, `feed_image`) VALUES
(5, 5, 'Staff', 'asdasd', '', '', 0, '2020-11-21 13:43:45', 'dp.jpg'),
(14, 5, 'Faculty', '245757521', 'Pending', '', 0, '2020-11-29 13:25:08', ''),
(13, 5, 'Faculty', 'this is an error message', 'solved', 'adsad', 1, '2020-11-29 12:51:05', 'BIT - Copy.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `malpractice_feedback`
--

DROP TABLE IF EXISTS `malpractice_feedback`;
CREATE TABLE IF NOT EXISTS `malpractice_feedback` (
  `mfeed_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `reason` varchar(50) NOT NULL DEFAULT 'malpractice',
  `feedback` varchar(50) NOT NULL,
  PRIMARY KEY (`mfeed_id`)
);

--
-- Dumping data for table `malpractice_feedback`
--

INSERT INTO `malpractice_feedback` (`mfeed_id`, `user_id`, `exam_id`, `reason`, `feedback`) VALUES
(4, 5, 64, 'malpractice', 'suma testing'),
(5, 5, 65, 'malpractice', 'please add it');

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_table`
--

DROP TABLE IF EXISTS `online_exam_table`;
CREATE TABLE IF NOT EXISTS `online_exam_table` (
  `online_exam_id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `user_year` varchar(50) NOT NULL,
  `user_course` varchar(50) NOT NULL,
  `online_exam_title` varchar(250) NOT NULL,
  `online_exam_datetime` datetime NOT NULL,
  `online_exam_duration` varchar(30) NOT NULL,
  `total_question` int NOT NULL,
  `marks_per_right_answer` varchar(30) NOT NULL,
  `marks_per_wrong_answer` varchar(30) NOT NULL,
  `online_exam_created_on` datetime NOT NULL,
  `online_exam_status` enum('Pending','Created','Started','Completed') NOT NULL,
  `online_exam_code` varchar(100) NOT NULL,
  PRIMARY KEY (`online_exam_id`)
);

--
-- Dumping data for table `online_exam_table`
--

INSERT INTO `online_exam_table` (`online_exam_id`, `admin_id`, `user_year`, `user_course`, `online_exam_title`, `online_exam_datetime`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `online_exam_created_on`, `online_exam_status`, `online_exam_code`) VALUES
(67, 1, 'II', 'Computer Science and Engineering', '12', '2020-11-29 15:50:00', '2', 2, '1', '0', '2020-11-29 15:48:12', 'Started', 'e4fc0558324f2c6e4104823ab18dc084');

-- --------------------------------------------------------

--
-- Table structure for table `option_table`
--

DROP TABLE IF EXISTS `option_table`;
CREATE TABLE IF NOT EXISTS `option_table` (
  `option_id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `option_number` int NOT NULL,
  `option_title` varchar(250) NOT NULL,
  PRIMARY KEY (`option_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--

DROP TABLE IF EXISTS `question_table`;
CREATE TABLE IF NOT EXISTS `question_table` (
  `question_id` int NOT NULL AUTO_INCREMENT,
  `online_exam_id` int NOT NULL,
  `question_image` varchar(50) NOT NULL,
  `question_title` text NOT NULL,
  `answer_option` enum('1','2','3','4') NOT NULL,
  PRIMARY KEY (`question_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_enroll_table`
--

DROP TABLE IF EXISTS `user_exam_enroll_table`;
CREATE TABLE IF NOT EXISTS `user_exam_enroll_table` (
  `user_exam_enroll_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `attendance_status` enum('Absent','Present') NOT NULL,
  `exam_intime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exam_outtime` datetime NOT NULL,
  `exam_status` varchar(50) NOT NULL,
  `remark` varchar(50) NOT NULL,
  PRIMARY KEY (`user_exam_enroll_id`)
);

--
-- Dumping data for table `user_exam_enroll_table`
--

INSERT INTO `user_exam_enroll_table` (`user_exam_enroll_id`, `user_id`, `exam_id`, `attendance_status`, `exam_intime`, `exam_outtime`, `exam_status`, `remark`) VALUES
(51, 5, 54, 'Present', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Completed', 'tabswitching'),
(52, 5, 55, 'Present', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Completed', 'tabswitching'),
(60, 5, 63, 'Present', '2020-11-28 23:20:28', '0000-00-00 00:00:00', 'Completed', ''),
(61, 5, 64, 'Present', '2020-11-28 23:24:39', '2020-11-28 23:25:38', 'Completed', 'tabswitching'),
(63, 5, 66, 'Present', '2020-11-29 15:45:47', '0000-00-00 00:00:00', 'Completed', ''),
(64, 5, 67, 'Present', '2020-11-29 15:48:41', '2020-11-29 15:50:53', 'Completed', 'tabswitching');

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_question_answer`
--

DROP TABLE IF EXISTS `user_exam_question_answer`;
CREATE TABLE IF NOT EXISTS `user_exam_question_answer` (
  `user_exam_question_answer_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `question_id` int NOT NULL,
  `user_answer_option` enum('0','1','2','3','4') NOT NULL,
  `marks` varchar(20) NOT NULL,
  PRIMARY KEY (`user_exam_question_answer_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

DROP TABLE IF EXISTS `user_table`;
CREATE TABLE IF NOT EXISTS `user_table` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_email_address` varchar(250) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_verfication_code` varchar(100) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `user_dob` varchar(20) NOT NULL,
  `user_year` varchar(50) NOT NULL,
  `user_course` varchar(50) NOT NULL,
  `user_address` text NOT NULL,
  `user_mobile_no` varchar(30) NOT NULL,
  `user_image` varchar(150) NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_email_verified` enum('no','yes') NOT NULL,
  PRIMARY KEY (`user_id`)
);

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_email_address`, `user_password`, `user_verfication_code`, `user_name`, `user_gender`, `user_dob`, `user_year`, `user_course`, `user_address`, `user_mobile_no`, `user_image`, `user_created_on`, `user_email_verified`) VALUES
(5, 'kishore.ct19@bitsathy.ac.in', '$2y$10$m9Y.vqa9fOr2RFqdyehWFOzHGzfffVanDKXa/y0BdtyqxMl7n7mSS', 'f8e5d1f7de24e72eaeaa8fc8c86fa005', 'Kishore D', 'Male', '2001-09-27', 'II', 'Computer Science and Engineering', 'karur,TamilNadu', '9787688154', '5fb900716b7bd.jpg', '2020-11-21 17:26:33', 'yes'),
(6, 'kishoredurai7@gmail.com', '$2y$10$lP83Lq4Le7zDMPBonLp.7.bBvv9udAB15oQEKkB3T8dx/P/pFujGi', 'a1805af7b208eb91071947e3e1fddaa3', 'Kishore Durai', 'Male', '0000-00-00', 'II', 'Computer Technology', 'dsdfsdf', '9787688154', '5fb774484f669.jpg', '2020-11-20 13:16:16', 'yes');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
