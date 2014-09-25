-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生日期: 2013 年 05 月 29 日 23:50
-- 伺服器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `db_pj3`
--

-- --------------------------------------------------------

--
-- 表的結構 `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `uid` varchar(15) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `uid` varchar(15) NOT NULL,
  `friend_id` varchar(15) NOT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`uid`,`friend_id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `postid` bigint(20) NOT NULL,
  `uid` varchar(15) NOT NULL,
  PRIMARY KEY (`postid`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `responses`
--

CREATE TABLE IF NOT EXISTS `responses` (
  `postid` bigint(20) NOT NULL,
  `r_postid` bigint(20) NOT NULL,
  `uid` varchar(15) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`postid`,`r_postid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 表的結構 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` varchar(15) NOT NULL,
  `password` char(32) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `sex` enum('M','F') NOT NULL DEFAULT 'M',
  `icon` varchar(5) DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
