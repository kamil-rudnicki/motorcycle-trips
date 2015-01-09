-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2015 at 04:48 PM
-- Server version: 5.5.27
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `samowla_wypady`
--

-- --------------------------------------------------------

--
-- Table structure for table `applies`
--

CREATE TABLE IF NOT EXISTS `applies` (
  `ride_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `name` (`city_name`(20))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `session_data` text,
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `motorcycles`
--

CREATE TABLE IF NOT EXISTS `motorcycles` (
  `motorcycle_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `motorcycle_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`motorcycle_id`),
  KEY `name` (`motorcycle_name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `place_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `place_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`place_id`),
  KEY `name` (`place_name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE IF NOT EXISTS `rides` (
  `ride_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `duration_days` int(11) DEFAULT NULL,
  `sleep` int(11) DEFAULT NULL,
  `departure_city_id` int(11) DEFAULT NULL,
  `departure_state_id` int(11) DEFAULT NULL,
  `destination_place_id` int(11) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `detour_days` int(11) DEFAULT NULL,
  `maximum_motorcycles` int(11) DEFAULT NULL,
  `distance_km` int(11) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `publish_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ride_id`),
  KEY `departure_date` (`departure_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `ride_motorcycle_type`
--

CREATE TABLE IF NOT EXISTS `ride_motorcycle_type` (
  `ride_id` int(11) DEFAULT NULL,
  `motorcycle_type` int(11) DEFAULT NULL,
  KEY `ride_id` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ride_user`
--

CREATE TABLE IF NOT EXISTS `ride_user` (
  `ride_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  KEY `ride_id` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `state_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `state_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`state_id`),
  KEY `state_name` (`state_name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_address` varchar(300) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `confirm_string` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `user_description` varchar(500) DEFAULT NULL,
  `motorcycle_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `register_time` timestamp NULL DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `login_count` int(11) DEFAULT '0',
  `user_name` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_address` (`email_address`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
