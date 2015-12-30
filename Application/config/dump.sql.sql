-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2014 at 07:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `planet-local`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_eventos`
--

DROP TABLE IF EXISTS `tempPrefix_setting_manara_business_locator`;
CREATE TABLE IF NOT EXISTS `tempPrefix_setting_manara_business_locator` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime DEFAULT NULL,
  `key` text,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


DROP TABLE IF EXISTS `tempPrefix_latitude_manara_business_locator`;
CREATE TABLE IF NOT EXISTS `tempPrefix_latitude_manara_business_locator` (
  `latitude_id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime DEFAULT NULL,
  `lat` text,
   `lng` text,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
 