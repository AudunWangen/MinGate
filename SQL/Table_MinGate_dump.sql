-- phpMyAdmin SQL Dump
-- version 2.6.1-rc1
-- http://www.phpmyadmin.net
-- 
-- Host: sql02.fastname.no:3306
-- Generation Time: Mar 18, 2010 at 09:33 AM
-- Server version: 4.1.22
-- PHP Version: 4.4.2
-- 
-- Database: `db105037`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `fiksgrafitti`
-- 

CREATE TABLE `fiksgrafitti` (
  `id` int(11) NOT NULL auto_increment,
  `dato` text,
  `sted` text,
  `lat` decimal(10,6) NOT NULL default '0.000000',
  `lon` decimal(10,6) NOT NULL default '0.000000',
  `feil` text,
  `status` text,
  `kommentar` text NOT NULL,
  `problem` text,
  `navn` text,
  `epost` text,
  `tlf` text,
  `ip` text NOT NULL,
  `bilde` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=207 DEFAULT CHARSET=utf8 AUTO_INCREMENT=207 ;
