-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2014 at 03:26 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventName` varchar(25) NOT NULL,
  `division` varchar(2) NOT NULL,
  `scoreMethod` varchar(8) NOT NULL,
  `type` varchar(23) NOT NULL,
  `active` int(2) NOT NULL,
  `completed` int(11) NOT NULL,
  `confirmed` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Table structure for table `rawScores`
--

CREATE TABLE IF NOT EXISTS `rawScores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(22) NOT NULL,
  `scoreArray` varchar(600) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventName` text NOT NULL,
  `eventId` int(20) NOT NULL,
  `teamName` varchar(255) NOT NULL,
  `score` varchar(25) NOT NULL,
  `placeInTie` int(23) NOT NULL,
  `tier` int(23) NOT NULL,
  `place` int(23) NOT NULL,
  `confirmedScore` double NOT NULL,
  `confirmedPlace` int(23) NOT NULL,
  `locked` int(11) NOT NULL,
  `changed` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=453 ;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numberBTeams` int(11) NOT NULL,
  `numberCTeams` int(2) NOT NULL,
  `globalRankingSetting` int(2) NOT NULL,
  `teamsToRankB` int(23) NOT NULL,
  `teamsToRankC` int(23) NOT NULL,
  `numberAwards` int(23) NOT NULL,
  `resultsDisplay` int(11) NOT NULL,
  `statsDisplay` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamName` varchar(255) NOT NULL,
  `teamNumber` varchar(11) NOT NULL,
  `division` varchar(5) NOT NULL,
  `finalScore` int(33) NOT NULL,
  `numberPlaces` int(23) NOT NULL,
  `tieBroken` int(1) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(5) NOT NULL,
  `permissions` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT INTO `users` (`id`, `name`, `password`, `type`, `permissions`) VALUES
(1, 'Admin', '$2y$10$4fwsFSlKv7RnOdA6jrH.t.fyWupd9ZzY5MwRfTAEoD4P4oK22VgKe', 1, '999');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
