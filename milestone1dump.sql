-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 24, 2016 at 11:59 PM
-- Server version: 5.6.28
-- PHP Version: 7.0.10


CREATE DATABASE `HighSide`;
USE `HighSide`;
--
-- Database: `HighSide`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--
DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `QUEST_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ANSWER` text CHARACTER SET latin1 NOT NULL,
  `POINTS` int(11) NOT NULL DEFAULT '0',
  `DATE_ANSWERED` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--
DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ASKER_ID` int(11) NOT NULL,
  `QUESTION_PHRASE` text CHARACTER SET latin1 NOT NULL,
  `DATE_ASKED` datetime NOT NULL,
  `TAG1` text CHARACTER SET latin1 NOT NULL,
  `TAG2` text CHARACTER SET latin1,
  `TAG3` text CHARACTER SET latin1,
  `ANSWERED` tinyint(1) NOT NULL,
  `POINTS` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16,
  `USERNAME` text NOT NULL,
  `PASSWORD` text NOT NULL,
  `KARMA_POINTS` int(11) NOT NULL DEFAULT '0',
  `LAST_ACTIVE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `KARMA_POINTS`, `LAST_ACTIVE`) VALUES
(1, 'admin', 'cs518pa$$', 0, '2016-09-24 16:44:13'),
(2, 'jbrunelle', 'M0n@rch$', 0, '2016-09-24 16:45:15'),
(3, 'pvenkman', 'imadoctor', 0, '2016-09-24 16:45:44'),
(4, 'rstantz', '"; INSERT INTO Customers (CustomerName,Address,City) Values(@0,@1,@2); --', 0, '2016-09-24 16:46:20'),
(5, 'dbarrett', 'fr1ed3GGS', 0, '2016-09-24 16:46:55'),
(6, 'ltully', '<!--<i>', 0, '2016-09-24 16:47:13'),
(7, 'espengler', 'don\'t cross the streams', 0, '2016-09-24 16:48:15'),
(8, 'janine', '--!drop tables;', 0, '2016-09-24 16:48:15'),
(9, 'winston', 'zeddM0r3', 0, '2016-09-24 16:48:57'),
(10, 'gozer', 'd3$truct0R', 0, '2016-09-24 16:48:57'),
(11, 'slimer', 'f33dM3', 0, '2016-09-24 16:49:32'),
(12, 'zuul', '105"; DROP TABLE', 0, '2016-09-24 16:49:32'),
(13, 'keymaster', 'n0D@na', 0, '2016-09-24 16:50:15'),
(14, 'gatekeeper', '$l0r', 0, '2016-09-24 16:50:15'),
(15, 'staypuft', 'm@r$hM@ll0w', 0, '2016-09-24 16:50:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

