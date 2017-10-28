-- phpMyAdmin SQL Dump
-- version 4.4.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2017 at 03:56 PM
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
  `channel_name` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `purpose` text NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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
(7, 'Radiator Springs', 'private', 'In town guys gossips', 1, '2017-10-16 00:56:46'),
(10, 'mgunn001@odu.edu', 'public', 'maheedhar', 10, '2017-10-26 23:57:27'),
(11, 'mgunn001@odu.edu', 'public', 'maheedhar', 10, '2017-10-26 23:57:27'),
(12, 'ussssshSecret', 'private', 'top secret ', 10, '2017-10-27 01:12:21');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emoji`
--

INSERT INTO `emoji` (`emoji_id`, `emoji_code`, `emoji_pic`) VALUES
(1, ':+1:', 'fa fa-thumbs-o-up'),
(2, ':-1:', 'fa fa-thumbs-o-down');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` bigint(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_place` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `is_threaded` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '0',
  `edited_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `has_shared_content` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `created_by`, `created_at`, `message_place`, `content`, `is_threaded`, `is_active`, `edited_at`, `has_shared_content`) VALUES
(5, 9, '2017-10-27 17:13:47', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0),
(6, 10, '2017-10-27 17:13:50', 0, 'hi how are u', 0, 0, '0000-00-00 00:00:00', 0),
(7, 11, '2017-10-04 17:35:27', 0, 'good', 1, 0, '0000-00-00 00:00:00', 0),
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
(71, 7, '2017-10-16 01:39:34', 0, 'ooh..\r\nvll try dat', 0, 0, '0000-00-00 00:00:00', 0),
(72, 9, '2017-10-16 02:50:32', 0, 'timee\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(73, 9, '2017-10-17 20:50:52', 0, '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaer', 0, 0, '0000-00-00 00:00:00', 0),
(74, 9, '2017-10-17 20:51:08', 0, 'hi', 0, 0, '0000-00-00 00:00:00', 0),
(75, 9, '2017-10-17 20:56:55', 0, '"how do you html?"\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(76, 9, '2017-10-17 20:57:09', 0, 'i\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(77, 9, '2017-10-17 20:57:20', 0, 'vvjhhn', 0, 0, '0000-00-00 00:00:00', 0),
(78, 9, '2017-10-17 20:57:57', 0, 'jabdsjksd', 0, 0, '0000-00-00 00:00:00', 0),
(79, 9, '2017-10-17 20:58:11', 0, '"can you sql inject with ''; -- ''?"', 0, 0, '0000-00-00 00:00:00', 0),
(80, 9, '2017-10-17 20:58:21', 0, '"what happens when I ~!@#$%^&*()_+_)(*&^%$#@!~}{:"><??:{}+}\\|}{P{}|-/*?"', 0, 0, '0000-00-00 00:00:00', 0),
(81, 9, '2017-10-17 20:58:31', 0, '"what does <!-- mean"', 0, 0, '0000-00-00 00:00:00', 0),
(82, 9, '2017-10-17 21:17:14', 0, '"what does <!-- mean"', 0, 0, '0000-00-00 00:00:00', 0),
(83, 9, '2017-10-17 21:17:37', 0, 'what does <!-- mean', 0, 0, '0000-00-00 00:00:00', 0),
(84, 9, '2017-10-17 21:43:23', 0, '"can you sql inject with ''; -- ''?"\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(85, 9, '2017-10-17 23:59:37', 0, ' "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. "\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(86, 9, '2017-10-17 23:59:48', 0, 'jklnjkn', 0, 0, '0000-00-00 00:00:00', 0),
(87, 9, '2017-10-18 00:00:33', 0, '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. ""Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. ""Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. ""Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. ""Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. "', 0, 0, '0000-00-00 00:00:00', 0),
(88, 9, '2017-10-17 13:16:51', 0, 'hellooo\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(89, 9, '2017-10-18 01:18:30', 0, '123456', 0, 0, '0000-00-00 00:00:00', 0),
(90, 9, '2017-10-23 18:28:18', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0),
(91, 9, '2017-10-23 18:28:26', 0, 'hhow are you ', 0, 0, '0000-00-00 00:00:00', 0),
(92, 9, '2017-10-23 18:28:44', 0, 'i am all good ', 0, 0, '0000-00-00 00:00:00', 0),
(93, 34, '2017-10-24 20:09:23', 0, 'Hello I am new here \r\n', 0, 0, '0000-00-00 00:00:00', 0),
(94, 40, '2017-10-24 20:58:42', 0, 'hey\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(95, 41, '2017-10-26 02:29:45', 0, 'hi all...\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(96, 9, '2017-10-26 02:29:58', 0, 'hello ', 0, 0, '0000-00-00 00:00:00', 0),
(97, 9, '2017-10-26 02:31:26', 0, 'what  else ?', 0, 0, '0000-00-00 00:00:00', 0),
(98, 9, '2017-10-26 22:44:32', 0, '#D9534F', 0, 0, '0000-00-00 00:00:00', 0),
(99, 10, '2017-10-27 01:13:52', 0, 'hello\r\n', 0, 0, '0000-00-00 00:00:00', 0),
(100, 9, '2017-10-27 04:14:48', 0, 'http://qav2.cs.odu.edu/Dev_StudentAppointmentSystem/home.php', 0, 0, '0000-00-00 00:00:00', 0),
(101, 10, '2017-10-27 17:10:07', 0, 'hi', 1, 0, '0000-00-00 00:00:00', 0),
(102, 10, '2017-10-27 16:39:08', 0, 'welcome', 1, 0, '0000-00-00 00:00:00', 0),
(103, 10, '2017-10-27 16:20:59', 0, 'vbgjgrf\r\nsuhrtg', 0, 0, '0000-00-00 00:00:00', 0),
(104, 9, '2017-10-27 19:47:17', 0, 'hello', 0, 0, '0000-00-00 00:00:00', 0);

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
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 2),
(89, 2),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 12),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_reaction`
--

INSERT INTO `message_reaction` (`message_id`, `emoji_id`, `created_by`, `created_at`, `message_reaction_id`) VALUES
(5, 1, 11, '2017-10-23 19:26:41', 1),
(67, 1, 9, '2017-10-24 16:52:16', 4),
(63, 1, 9, '2017-10-24 16:52:42', 5),
(43, 1, 9, '2017-10-24 17:00:56', 9),
(40, 1, 9, '2017-10-24 17:09:22', 15),
(74, 1, 9, '2017-10-24 17:45:26', 69),
(74, 2, 9, '2017-10-24 17:45:27', 70),
(71, 1, 9, '2017-10-24 17:45:34', 73),
(71, 2, 9, '2017-10-24 17:45:35', 74),
(70, 1, 9, '2017-10-24 17:48:01', 75),
(70, 2, 9, '2017-10-24 17:48:03', 76),
(91, 1, 9, '2017-10-24 18:01:58', 100),
(58, 1, 9, '2017-10-24 19:01:11', 107),
(75, 1, 9, '2017-10-24 19:37:18', 134),
(75, 2, 9, '2017-10-24 19:37:18', 135),
(19, 2, 9, '2017-10-24 19:58:20', 143),
(79, 1, 9, '2017-10-24 20:00:59', 151),
(86, 1, 9, '2017-10-24 20:03:56', 158),
(86, 2, 9, '2017-10-24 20:03:56', 159),
(85, 2, 9, '2017-10-24 20:05:31', 162),
(87, 1, 10, '2017-10-24 20:05:57', 164),
(84, 1, 9, '2017-10-24 20:54:30', 171),
(96, 2, 41, '2017-10-26 02:30:50', 176),
(96, 1, 9, '2017-10-26 02:50:13', 177),
(93, 2, 9, '2017-10-26 15:55:25', 185),
(85, 1, 9, '2017-10-26 15:55:33', 186),
(92, 1, 9, '2017-10-26 19:12:25', 188),
(81, 1, 9, '2017-10-26 21:47:31', 193),
(90, 2, 9, '2017-10-26 21:50:14', 196),
(90, 1, 9, '2017-10-26 22:02:44', 198),
(96, 1, 10, '2017-10-26 23:21:34', 203),
(90, 2, 10, '2017-10-26 23:21:39', 204),
(90, 1, 10, '2017-10-26 23:21:40', 205),
(94, 1, 9, '2017-10-27 17:04:17', 218),
(94, 2, 9, '2017-10-27 17:04:18', 219),
(7, 1, 9, '2017-10-27 17:28:15', 220),
(7, 2, 9, '2017-10-27 17:28:16', 221),
(103, 1, 9, '2017-10-27 17:30:05', 222),
(102, 1, 9, '2017-10-27 17:30:07', 223),
(101, 1, 9, '2017-10-27 17:30:09', 224);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threaded_message`
--

INSERT INTO `threaded_message` (`id`, `parent_message_id`, `content`, `created_by`, `created_at`) VALUES
(1, 102, 'threadddddd', 9, '2017-10-27 16:40:04'),
(2, 102, 'reply in threadddd', 11, '2017-10-27 16:40:05'),
(3, 101, 'another threadd', 10, '2017-10-27 16:41:21'),
(4, 101, 'yupppp', 11, '2017-10-27 16:41:22'),
(5, 7, 'zsdgbfzdh', 10, '2017-10-27 17:15:25'),
(6, 7, 'dfhtnxf', 11, '2017-10-27 17:15:29'),
(7, 101, 'xgfthnfcgxj', 11, '2017-10-27 16:48:22');

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `first_name`, `last_name`, `email_id`, `profile_pic`, `password`, `phone_number`, `what_i_do`, `status`, `status_emoji`, `skype`) VALUES
(1, '@mater', 'Tow', 'Mater', 'mater@rsprings.gov', '', 'mater', '1234567890', 'student at ODU', '', 1, ''),
(2, '@sally', 'Sally', 'Carrera', 'porsche@rsprings.gov', '', 'sally', '', '', '', 1, ''),
(3, '@doc', 'Doc', 'Hudson', 'hornet@rsprings.gov', '', 'doc', '', '', '', NULL, ''),
(6, '@mcmissile', 'Finn', 'McMissile', 'topsecret@agent.org', '', 'mcmissile', '', '', '', NULL, ''),
(7, '@mcqueen', 'Lightning', 'McQueen', 'kachow@rusteze.com', '', 'mcqueen', '', '', '', NULL, ''),
(8, '@chick', 'Chick', 'Hicks', 'chinga@cars.com', '', 'chick', '', '', '', NULL, ''),
(9, '@rohila', 'Rohila', 'Gudipati', 'rgudi001@odu.edu', '', 'rohila', '', '', '', NULL, ''),
(10, '@maheedhar', 'Maheedhar', 'Gunnam', 'mgunn001@odu.edu', '', 'maheedhar', '', '', '', NULL, ''),
(11, '@mahesh', 'Mahesh', 'Kukunooru', 'mkuku002@odu.edu', '', 'mahesh', '', '', '', NULL, ''),
(13, '@new', 'new', 'user', 'rgudi002@odu.edu', ' ', 'rohila', '', '', '', 1, ''),
(17, '@zfxdbrgd', 'zfxdbrgd', 'dfxhfx', 'rgudi003@odu.edu', ' ', 'rohila', '', '', '', 1, ''),
(34, '@rohit', 'Rohit', 'Kandhi', 'rkand@odu.edu', ' ', '1234', '', 'student', '', 1, ''),
(35, '@', '', '', '', ' ', '', '', '', '', 1, ''),
(40, '@dg', 'dg', 'fh', 'rgudi@odu.edu', ' ', 'rohila', '', '', '', 1, ''),
(41, '@aaaksh', 'Aaaksh', 'Nunna', 'aakashnunna@gmail.com', ' ', 'aakash123', '1112345678', 'Nothing', 'Single - Looking for ....', 1, ''),
(42, '@r', 'r', 'r', 'rgu1@odu.edu', ' ', ' " OR 1=1;', '', '', '', 1, ''),
(45, '@zsdgyr', 'ZSDgyr', 'dszgt', 'mgun1@odu.edu', ' ', 'maheedhar', '', '', '', 1, ''),
(47, '@fcxhn', 'fcxhn', 'dxzg', 'mgu1@odu.edu', ' ', 'maheedhar', '', '', '', 1, '');

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
(9, 10, '2017-10-26 23:57:27', '0000-00-00 00:00:00', 0),
(10, 1, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(10, 2, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(10, 10, '2017-10-26 23:57:27', '0000-00-00 00:00:00', 0),
(10, 12, '2017-10-27 01:12:21', '0000-00-00 00:00:00', 0),
(11, 1, '2017-10-03 01:41:31', '0000-00-00 00:00:00', 0),
(11, 2, '2017-10-03 01:41:39', '0000-00-00 00:00:00', 0),
(11, 10, '2017-10-26 23:57:27', '0000-00-00 00:00:00', 0),
(13, 1, '2017-10-24 16:12:54', '0000-00-00 00:00:00', 0),
(13, 2, '2017-10-24 16:12:54', '0000-00-00 00:00:00', 0),
(17, 1, '2017-10-24 16:21:33', '0000-00-00 00:00:00', 0),
(17, 2, '2017-10-24 16:21:33', '0000-00-00 00:00:00', 0),
(34, 1, '2017-10-24 20:08:52', '0000-00-00 00:00:00', 0),
(34, 2, '2017-10-24 20:08:52', '0000-00-00 00:00:00', 0),
(35, 1, '2017-10-24 20:44:30', '0000-00-00 00:00:00', 0),
(35, 2, '2017-10-24 20:44:30', '0000-00-00 00:00:00', 0),
(40, 1, '2017-10-24 20:56:35', '0000-00-00 00:00:00', 0),
(40, 2, '2017-10-24 20:56:35', '0000-00-00 00:00:00', 0),
(41, 1, '2017-10-26 02:28:52', '0000-00-00 00:00:00', 0),
(41, 2, '2017-10-26 02:28:52', '0000-00-00 00:00:00', 0),
(42, 1, '2017-10-26 04:33:10', '0000-00-00 00:00:00', 0),
(42, 2, '2017-10-26 04:33:10', '0000-00-00 00:00:00', 0),
(45, 1, '2017-10-26 22:24:23', '0000-00-00 00:00:00', 0),
(45, 2, '2017-10-26 22:24:23', '0000-00-00 00:00:00', 0),
(47, 1, '2017-10-26 22:44:20', '0000-00-00 00:00:00', 0),
(47, 2, '2017-10-26 22:44:20', '0000-00-00 00:00:00', 0);

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
(11, 1),
(13, 1),
(17, 1),
(34, 1),
(35, 1),
(40, 1),
(41, 1),
(42, 1),
(45, 1),
(47, 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `workspace_channel`
--

CREATE TABLE IF NOT EXISTS `workspace_channel` (
  `workspace_id` bigint(20) NOT NULL,
  `channel_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workspace_channel`
--

INSERT INTO `workspace_channel` (`workspace_id`, `channel_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7);

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
  ADD UNIQUE KEY `email_id` (`email_id`),
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
-- Indexes for table `workspace_channel`
--
ALTER TABLE `workspace_channel`
  ADD PRIMARY KEY (`workspace_id`,`channel_id`),
  ADD KEY `channel_id` (`channel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `channel_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `channel_invitation`
--
ALTER TABLE `channel_invitation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emoji`
--
ALTER TABLE `emoji`
  MODIFY `emoji_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `message_reaction`
--
ALTER TABLE `message_reaction`
  MODIFY `message_reaction_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT for table `shared_message`
--
ALTER TABLE `shared_message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `threaded_message`
--
ALTER TABLE `threaded_message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
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

--
-- Constraints for table `workspace_channel`
--
ALTER TABLE `workspace_channel`
  ADD CONSTRAINT `workspace_channel_ibfk_1` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`workspace_id`),
  ADD CONSTRAINT `workspace_channel_ibfk_2` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
