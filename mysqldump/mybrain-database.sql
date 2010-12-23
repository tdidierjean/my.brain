-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 20 Décembre 2010 à 06:55
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
  `name` varchar(40) NOT NULL,
  `url` varchar(256) DEFAULT NULL,
  `details` longtext,
  `creation_date` date NOT NULL,
  `update_date` date NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=333 ;

-- --------------------------------------------------------

--
-- Structure de la table `entry2tag`
--

CREATE TABLE IF NOT EXISTS `entry2tag` (
  `id_entry` int(10) unsigned NOT NULL,
  `id_tag` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_entry`,`id_tag`),
  KEY `tag_id` (`id_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `memo`
--

CREATE TABLE IF NOT EXISTS `memo` (
  `id_memo` int(10) NOT NULL,
  `content` longtext,
  `update_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

INSERT INTO `memo` (`id_memo`, `content`, `update_date`) VALUES
(0, '', '0000-00-00 00:00:00');


--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_text` text NOT NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE KEY `tag_text` (`tag_text`(50))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `cookie` char(32) NOT NULL,
  `session` char(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
