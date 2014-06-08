-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2014 at 03:24 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zend_mailing_theme`
--

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `auth_code` varchar(5) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`id`, `email`, `auth_code`, `status`) VALUES
(1, 'zendtheme@gmail.com', 'examp', 1),
(3, 'zendtheme@gmail.com', 'WtcH6', 0),
(4, 'peterzen72@gmail.com', 'WtcM6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text,
  `name` varchar(50) DEFAULT 'name not found',
  `slogan` varchar(75) DEFAULT 'slogan not found',
  `subject` varchar(50) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `message`, `name`, `slogan`, `subject`, `theme_id`, `date`) VALUES
(1, 'Message could not be found\n\nClick <b><u><a href="/school/zendMailingTheme/public/Index/showmessagelist">here</a></b></u> to go the mails overview', 'name not found', '404 Message not found', 'Unknown message', NULL, '2014-06-08'),
(2, '<p>asdasd</p>', 'zzpeterzz', 'test mail met default theme', 'test mail met default theme', 2, '2014-06-08'),
(3, '<p>asdasdasd</p>', 'peter', 'test', 'asdasd', 1, '2014-06-08'),
(4, '<p>asdasd</p>', 'zzpeterzz', 'Test Slogan!', 'test mail met default theme', 2, '2014-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `description`) VALUES
(1, 'colordirect', 'zend mailing thema template bestanden'),
(2, 'default', 'This is the theme that will be used on default.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
