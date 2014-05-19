-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2012 at 05:56 PM
-- Server version: 5.0.75
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `skatespots`
--

-- --------------------------------------------------------

--
-- Table structure for table `am_admin`
--

CREATE TABLE IF NOT EXISTS `am_admin` (
  `admin_id` int(11) NOT NULL auto_increment,
  `admin_name` varchar(32) NOT NULL default '',
  `admin_email` varchar(96) NOT NULL default '',
  `admin_pass` varchar(40) NOT NULL default '',
  `admin_level` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`admin_id`),
  KEY `idx_admin_name_zen` (`admin_name`),
  KEY `idx_admin_email_zen` (`admin_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `am_admin`
--

INSERT INTO `am_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_level`) VALUES
(1, 'admin', 'admin@alakmalak.com', '9c616c0ff2ddeba5419442195825308f', 1);
