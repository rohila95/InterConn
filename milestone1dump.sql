-- phpMyAdmin SQL Dump
-- version 4.4.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2017 at 09:39 PM
-- Server version: 10.0.19-MariaDB-1~trusty-log
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `InterConn` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `InterConn`;
--
-- Database: `InterConn`
--

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
  `channel_id` bigint(20) NOT NULL,
  `channel_name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`channel_id`, `channel_name`, `type`, `purpose`, `created_by`, `created_at`) VALUES
(1, 'general', 'public', 'General discussions', 11, '2017-10-12 22:52:23'),
(2, 'random', 'public', '', 11, '2017-10-03 01:40:37'),
(3, 'general', 'public', 'General discussions', 1, '2017-10-16 22:52:23'),
(4, 'random', 'public', 'Random discussions', 1, '2017-10-16 00:49:17'),
(5, 'Rust-eze', 'private', 'Private group talks', 7, '2017-10-16 00:53:54'),
(6, 'Piston Cup competitors', 'private', 'For participants only!!!!', 7, '2017-10-16 00:55:13'),
(7, 'Radiator Springs', 'private', 'In town guys gossips', 1, '2017-10-16 00:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `channel_invitation`
--

CREATE TABLE IF NOT EXISTS `channel_invitation` (
  `channel_id` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emoji`
--

CREATE TABLE IF NOT EXISTS `emoji` (
  `emoji_id` bigint(20) NOT NULL,
  `emoji_code` varchar(50) NOT NULL,
  `emoji_pic` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emoji`
--

INSERT INTO `emoji` (`emoji_id`, `emoji_code`, `emoji_pic`) VALUES
(1, ':)', '');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` bigint(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message_place` bigint(20) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `is_threaded` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '0',
  `edited_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `has_shared_content` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `created_by`, `created_at`, `message_place`, `content`, `is_threaded`, `is_active`, `edited_at`, `has_shared_content`) VALUES
(5, 9, '2017-10-04 17:28:34', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0),
(6, 10, '2017-10-04 17:29:34', 0, 'hi how are u', 0, 0, '0000-00-00 00:00:00', 0),
(7, 11, '2017-10-04 17:35:27', 0, 'good', 0, 0, '0000-00-00 00:00:00', 0),
(8, 9, '2017-10-04 17:34:48', 0, 'hi direct message', 0, 0, '0000-00-00 00:00:00', 0),
(9, 10, '2017-10-04 17:35:48', 0, 'true,direct message', 0, 0, '0000-00-00 00:00:00', 0),
(10, 10, '2017-10-04 17:47:17', 0, 'hi another private message', 0, 0, '0000-00-00 00:00:00', 0),
(11, 11, '2017-10-04 17:48:17', 0, 'yup', 0, 0, '0000-00-00 00:00:00', 0),
(16, 9, '2017-10-05 21:21:38', 0, 'hiii', 0, 0, '0000-00-00 00:00:00', 0),
(17, 10, '2017-10-05 21:22:44', 0, 'welcome', 0, 0, '0000-00-00 00:00:00', 0),
(18, 10, '2017-10-05 21:24:20', 0, '<!--jzsdhfj-->', 0, 0, '0000-00-00 00:00:00', 0),
(19, 10, '2017-10-05 21:24:30', 0, '><:"#%$(#$)%^_$E_', 0, 0, '0000-00-00 00:00:00', 0),
(20, 10, '2017-10-05 21:24:57', 0, 'hiii', 0, 0, '0000-00-00 00:00:00', 0),
(21, 10, '2017-10-05 21:25:10', 0, 'good job', 0, 0, '0000-00-00 00:00:00', 0),
(22, 11, '2017-10-05 21:28:07', 0, 'fgdfg', 0, 0, '0000-00-00 00:00:00', 0),
(23, 11, '2017-10-05 21:28:56', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(24, 10, '2017-10-05 21:32:23', 0, 'hiii', 0, 0, '0000-00-00 00:00:00', 0),
(25, 10, '2017-10-05 21:32:29', 0, 'hiii', 0, 0, '0000-00-00 00:00:00', 0),
(26, 10, '2017-10-06 00:18:11', 0, 'hey sup people ', 0, 0, '0000-00-00 00:00:00', 0),
(27, 9, '2017-10-06 18:19:40', 0, 'erg', 0, 0, '0000-00-00 00:00:00', 0),
(28, 9, '2017-10-06 18:19:43', 0, 'tyhrt', 0, 0, '0000-00-00 00:00:00', 0),
(29, 9, '2017-10-06 18:19:46', 0, 'rtyrt', 0, 0, '0000-00-00 00:00:00', 0),
(30, 9, '2017-10-06 18:19:54', 0, 'erterterwt', 0, 0, '0000-00-00 00:00:00', 0),
(31, 9, '2017-10-06 18:20:46', 0, 'rtj', 0, 0, '0000-00-00 00:00:00', 0),
(32, 9, '2017-10-06 18:20:49', 0, 'ertre', 0, 0, '0000-00-00 00:00:00', 0),
(33, 9, '2017-10-06 18:20:51', 0, '45y54y', 0, 0, '0000-00-00 00:00:00', 0),
(34, 9, '2017-10-06 18:21:27', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(35, 9, '2017-10-06 18:36:52', 0, 'Hey Handsome ', 0, 0, '0000-00-00 00:00:00', 0),
(36, 9, '2017-10-06 18:37:04', 0, 'whats going on ??', 0, 0, '0000-00-00 00:00:00', 0),
(37, 9, '2017-10-06 18:56:51', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(38, 9, '2017-10-06 19:10:33', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0),
(39, 9, '2017-10-06 19:10:34', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0),
(40, 9, '2017-10-06 19:10:37', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0),
(41, 9, '2017-10-06 19:10:48', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(42, 9, '2017-10-06 19:10:52', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(43, 9, '2017-10-06 20:15:52', 0, '35y45yjhopi54yoi54oyu54iyuoi[45uy[45uyw45oyu45[oiyuio[54uy[oi45uyoi[45wuyoi[w45uyoi[w45uio[yuw54oi[yuw45o[iyu4w5[yu45o[iyu45oi[yu45io[yu[4oi5uy[i4o5uy[o4i5wuy[o4iuy[oi45uyoi[45uy45', 0, 0, '0000-00-00 00:00:00', 0),
(44, 10, '2017-10-07 04:12:31', 0, 'Hello people ', 0, 0, '0000-00-00 00:00:00', 0),
(45, 9, '2017-10-10 03:51:03', 0, '32', 0, 0, '0000-00-00 00:00:00', 0),
(46, 1, '2017-10-10 19:47:23', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(47, 1, '2017-10-10 19:49:23', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(48, 9, '2017-10-10 19:56:32', 0, 'dkfjigi', 0, 0, '0000-00-00 00:00:00', 0),
(49, 9, '2017-10-10 19:56:35', 0, 'dfzh', 0, 0, '0000-00-00 00:00:00', 0),
(50, 9, '2017-10-11 20:16:11', 0, '', 0, 0, '0000-00-00 00:00:00', 0),
(51, 9, '2017-10-12 04:10:58', 0, 'Suo baby ', 0, 0, '0000-00-00 00:00:00', 0),
(52, 9, '2017-10-12 20:09:52', 0, 'hg', 0, 0, '0000-00-00 00:00:00', 0),
(53, 9, '2017-10-12 21:28:03', 0, 'wrgmwk', 0, 0, '0000-00-00 00:00:00', 0),
(54, 9, '2017-10-12 21:28:08', 0, 'ewtwe', 0, 0, '0000-00-00 00:00:00', 0),
(55, 9, '2017-10-12 21:28:13', 0, 'fwe', 0, 0, '0000-00-00 00:00:00', 0),
(56, 9, '2017-10-12 21:28:28', 0, 'rgel;ghke', 0, 0, '0000-00-00 00:00:00', 0),
(57, 9, '2017-10-12 21:30:26', 0, 'sddwd', 0, 0, '0000-00-00 00:00:00', 0),
(58, 9, '2017-10-12 21:31:19', 0, 'dhdg\r\ndrhesheshhr\r\nrhesth\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(59, 9, '2017-10-14 01:28:44', 0, 'dhdg drhesheshhr rhesth', 0, 0, '0000-00-00 00:00:00', 0),
(60, 9, '2017-10-14 01:30:19', 0, '$channelstr='''';    	$directMessagestr='''';', 0, 0, '0000-00-00 00:00:00', 0),
(61, 9, '2017-10-15 00:55:17', 0, 'hsgrfjg\r\ngedfut\r\negjtfj\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(62, 9, '2017-10-15 00:55:38', 0, 'hgfhb\r\nsdrhefgh\r\ndjhskwh\r\n\r\n\r\n\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(63, 9, '2017-10-16 01:06:18', 0, 'endi idii?? idi chat ahh? asal em language idi?\r\nasal evarkanna ardham aythadaaa  LOL ;)\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(64, 7, '2017-10-16 01:07:20', 0, 'whoz dis?\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(65, 7, '2017-10-16 01:08:48', 0, '123456\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(66, 7, '2017-10-16 01:10:10', 0, 'Hi', 0, 0, '0000-00-00 00:00:00', 0),
(67, 9, '2017-10-16 01:16:27', 0, 'Hello', 0, 0, '0000-00-00 00:00:00', 0),
(68, 9, '2017-10-16 01:17:00', 0, 'haha :)', 0, 0, '0000-00-00 00:00:00', 0),
(69, 9, '2017-10-16 01:17:27', 0, 'Rohila Adhi Rithu i gues ', 0, 0, '0000-00-00 00:00:00', 0),
(70, 9, '2017-10-16 01:18:10', 0, 'And ee text area on enter submit avvali, I shouldnt be pressing another send button for that ', 0, 0, '0000-00-00 00:00:00', 0),
(71, 7, '2017-10-16 01:39:34', 0, 'ooh..\r\nvll try dat', 0, 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_channel`
--

CREATE TABLE IF NOT EXISTS `message_channel` (
  `message_id` bigint(20) NOT NULL,
  `channel_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_channel`
--

INSERT INTO `message_channel` (`message_id`, `channel_id`) VALUES
(5, 1),
(6, 1),
(7, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 2),
(21, 2),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 2),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 2),
(36, 2),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 2),
(50, 2),
(51, 2),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 3),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_direct`
--

CREATE TABLE IF NOT EXISTS `message_direct` (
  `message_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_direct`
--

INSERT INTO `message_direct` (`message_id`, `receiver_id`) VALUES
(8, 10),
(9, 9),
(10, 11),
(11, 10);

-- --------------------------------------------------------

--
-- Table structure for table `message_reaction`
--

CREATE TABLE IF NOT EXISTS `message_reaction` (
  `message_id` bigint(20) NOT NULL,
  `emoji_id` bigint(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message_reaction_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shared_message`
--

CREATE TABLE IF NOT EXISTS `shared_message` (
  `id` bigint(20) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `shared_message_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `threaded_message`
--

CREATE TABLE IF NOT EXISTS `threaded_message` (
  `id` bigint(20) NOT NULL,
  `parent_message_id` bigint(20) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `profile_pic` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `what_i_do` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL,
  `status_emoji` bigint(20) DEFAULT NULL,
  `skype` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `first_name`, `last_name`, `email_id`, `profile_pic`, `password`, `phone_number`, `what_i_do`, `status`, `status_emoji`, `skype`) VALUES
(1, '@mater', 'Tow', 'Mater', 'mater@rsprings.gov', '', 'mater', '', '', '', 1, ''),
(2, '@sally', 'Sally', 'Carrera', 'porsche@rsprings.gov', '', 'sally', '', '', '', 1, ''),
(3, '@doc', 'Doc', 'Hudson', 'hornet@rsprings.gov', '', 'doc', '', '', '', NULL, ''),
(6, '@mcmissile', 'Finn', 'McMissile', 'topsecret@agent.org', '', 'mcmissile', '', '', '', NULL, ''),
(7, '@mcqueen', 'Lightning', 'McQueen', 'kachow@rusteze.com', '', 'mcqueen', '', '', '', NULL, ''),
(8, '@chick', 'Chick', 'Hicks', 'chinga@cars.com', '', 'chick', '', '', '', NULL, ''),
(9, '@rohila', 'Rohila', 'Gudipati', 'rgudi001@odu.edu', '', 'rohila', '', '', '', NULL, ''),
(10, '@maheedhar', 'Maheedhar', 'Gunnam', 'mgunn001@odu.edu', '', 'maheedhar', '', '', '', NULL, ''),
(11, '@mahesh', 'Mahesh', 'Kukunooru', 'mkuku002@odu.edu', '', 'mahesh', '', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_channel`
--

CREATE TABLE IF NOT EXISTS `user_channel` (
  `user_id` bigint(20) NOT NULL,
  `channel_id` bigint(20) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `left_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `starred` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_channel`
--

INSERT INTO `user_channel` (`user_id`, `channel_id`, `joined_at`, `left_at`, `starred`) VALUES
(1, 3, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(1, 4, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(1, 7, '2017-10-16 01:01:18', '0000-00-00 00:00:00', 0),
(2, 3, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(2, 4, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(2, 7, '2017-10-16 01:01:39', '0000-00-00 00:00:00', 0),
(3, 3, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(3, 4, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(3, 5, '2017-10-16 01:04:12', '0000-00-00 00:00:00', 0),
(3, 7, '2017-10-16 01:01:39', '0000-00-00 00:00:00', 0),
(6, 3, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(6, 4, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(7, 3, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(7, 4, '2017-10-16 00:59:02', '0000-00-00 00:00:00', 0),
(7, 5, '2017-10-16 01:04:12', '0000-00-00 00:00:00', 0),
(7, 6, '2017-10-16 01:03:45', '0000-00-00 00:00:00', 0),
(7, 7, '2017-10-16 01:01:49', '0000-00-00 00:00:00', 0),
(8, 3, '2017-10-16 00:59:12', '0000-00-00 00:00:00', 0),
(8, 4, '2017-10-16 00:59:12', '0000-00-00 00:00:00', 0),
(8, 6, '2017-10-16 01:03:45', '0000-00-00 00:00:00', 0),
(9, 1, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(9, 2, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(10, 1, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(10, 2, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(11, 1, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(11, 2, '2017-10-03 01:41:39', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_workspace`
--

CREATE TABLE IF NOT EXISTS `user_workspace` (
  `user_id` bigint(20) NOT NULL,
  `workspace_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_workspace`
--

INSERT INTO `user_workspace` (`user_id`, `workspace_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 1),
(10, 1),
(11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `workspace`
--

CREATE TABLE IF NOT EXISTS `workspace` (
  `workspace_id` bigint(20) NOT NULL,
  `workspace_name` varchar(50) NOT NULL,
  `workspace_domain` varchar(50) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workspace`
--

INSERT INTO `workspace` (`workspace_id`, `workspace_name`, `workspace_domain`, `created_by`, `created_at`) VALUES
(1, 'InterConn_Dev', 'interconn', 11, '2017-10-03 01:35:12'),
(2, 'Carz', 'carz', 1, '2017-10-16 00:46:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`channel_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `channel_invitation`
--
ALTER TABLE `channel_invitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `channel_id` (`channel_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emoji`
--
ALTER TABLE `emoji`
  ADD PRIMARY KEY (`emoji_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `message_channel`
--
ALTER TABLE `message_channel`
  ADD PRIMARY KEY (`message_id`,`channel_id`),
  ADD KEY `channel_id` (`channel_id`);

--
-- Indexes for table `message_direct`
--
ALTER TABLE `message_direct`
  ADD PRIMARY KEY (`message_id`,`receiver_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `message_reaction`
--
ALTER TABLE `message_reaction`
  ADD PRIMARY KEY (`message_reaction_id`),
  ADD KEY `emoji_id` (`emoji_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `shared_message`
--
ALTER TABLE `shared_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `shared_message_id` (`shared_message_id`);

--
-- Indexes for table `threaded_message`
--
ALTER TABLE `threaded_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_message_id` (`parent_message_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `status_emoji` (`status_emoji`);

--
-- Indexes for table `user_channel`
--
ALTER TABLE `user_channel`
  ADD PRIMARY KEY (`user_id`,`channel_id`),
  ADD KEY `channel_id` (`channel_id`);

--
-- Indexes for table `user_workspace`
--
ALTER TABLE `user_workspace`
  ADD PRIMARY KEY (`user_id`,`workspace_id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Indexes for table `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`workspace_id`),
  ADD KEY `created_by` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `channel_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `channel_invitation`
--
ALTER TABLE `channel_invitation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emoji`
--
ALTER TABLE `emoji`
  MODIFY `emoji_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `message_reaction`
--
ALTER TABLE `message_reaction`
  MODIFY `message_reaction_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shared_message`
--
ALTER TABLE `shared_message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `threaded_message`
--
ALTER TABLE `threaded_message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `workspace`
--
ALTER TABLE `workspace`
  MODIFY `workspace_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `channel`
--
ALTER TABLE `channel`
  ADD CONSTRAINT `channel_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `channel_invitation`
--
ALTER TABLE `channel_invitation`
  ADD CONSTRAINT `channel_invitation_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`),
  ADD CONSTRAINT `channel_invitation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `message_channel`
--
ALTER TABLE `message_channel`
  ADD CONSTRAINT `message_channel_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`),
  ADD CONSTRAINT `message_channel_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `message` (`message_id`);

--
-- Constraints for table `message_direct`
--
ALTER TABLE `message_direct`
  ADD CONSTRAINT `message_direct_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `message` (`message_id`),
  ADD CONSTRAINT `message_direct_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `message_reaction`
--
ALTER TABLE `message_reaction`
  ADD CONSTRAINT `message_reaction_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `message` (`message_id`),
  ADD CONSTRAINT `message_reaction_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `message_reaction_ibfk_3` FOREIGN KEY (`emoji_id`) REFERENCES `emoji` (`emoji_id`);

--
-- Constraints for table `shared_message`
--
ALTER TABLE `shared_message`
  ADD CONSTRAINT `shared_message_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `message` (`message_id`),
  ADD CONSTRAINT `shared_message_ibfk_2` FOREIGN KEY (`shared_message_id`) REFERENCES `message` (`message_id`);

--
-- Constraints for table `threaded_message`
--
ALTER TABLE `threaded_message`
  ADD CONSTRAINT `threaded_message_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `threaded_message_ibfk_2` FOREIGN KEY (`parent_message_id`) REFERENCES `message` (`message_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`status_emoji`) REFERENCES `emoji` (`emoji_id`);

--
-- Constraints for table `user_channel`
--
ALTER TABLE `user_channel`
  ADD CONSTRAINT `user_channel_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_channel_ibfk_2` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`);

--
-- Constraints for table `user_workspace`
--
ALTER TABLE `user_workspace`
  ADD CONSTRAINT `user_workspace_ibfk_1` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`workspace_id`),
  ADD CONSTRAINT `user_workspace_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `workspace`
--
ALTER TABLE `workspace`
  ADD CONSTRAINT `workspace_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
