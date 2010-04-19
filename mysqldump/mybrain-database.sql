-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 19 Avril 2010 à 22:01
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `artificiwbrain`
--

-- --------------------------------------------------------

--
-- Structure de la table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
  `id_entry` int(10) NOT NULL AUTO_INCREMENT,
  `id_list` int(10) NOT NULL,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `details` longtext COLLATE latin1_general_ci,
  `creation_date` date NOT NULL,
  `update_date` date NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=266 ;

-- --------------------------------------------------------

--
-- Structure de la table `entry2tag`
--

CREATE TABLE IF NOT EXISTS `entry2tag` (
  `id_entry` int(10) unsigned NOT NULL,
  `id_tag` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_entry`,`id_tag`),
  KEY `tag_id` (`id_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entrylist`
--

CREATE TABLE IF NOT EXISTS `entrylist` (
  `id_list` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `col` smallint(2) NOT NULL,
  `rank` smallint(2) NOT NULL,
  `collapsed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_list`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `list2tag`
--

CREATE TABLE IF NOT EXISTS `list2tag` (
  `id_list` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `id_tag` varchar(10) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` char(32) COLLATE latin1_general_ci NOT NULL,
  `cookie` char(32) COLLATE latin1_general_ci NOT NULL,
  `session` char(32) COLLATE latin1_general_ci NOT NULL,
  `ip` varchar(15) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `memo`
--

CREATE TABLE IF NOT EXISTS `memo` (
  `id_memo` int(10) NOT NULL,
  `content` longtext COLLATE latin1_general_ci,
  `update_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_text` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE KEY `tag_text` (`tag_text`(50))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=70 ;
