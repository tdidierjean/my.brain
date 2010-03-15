-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Serveur: mysql5-18.60gp
-- Généré le : Dim 14 Mars 2010 à 16:16
-- Version du serveur: 5.0.90
-- Version de PHP: 5.2.6-1+lenny4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `artificiwbrain`
--

-- --------------------------------------------------------

--
-- Structure de la table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
  `id_entry` int(10) NOT NULL auto_increment,
  `id_list` int(10) NOT NULL,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `url` varchar(256) collate latin1_general_ci default NULL,
  `details` longtext collate latin1_general_ci,
  `creation_date` date NOT NULL,
  `update_date` date NOT NULL,
  PRIMARY KEY  (`id_entry`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=244 ;

-- --------------------------------------------------------

--
-- Structure de la table `entry2tag`
--

CREATE TABLE IF NOT EXISTS `entry2tag` (
  `id_entry` int(10) unsigned NOT NULL,
  `id_tag` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_entry`,`id_tag`),
  KEY `tag_id` (`id_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entrylist`
--

CREATE TABLE IF NOT EXISTS `entrylist` (
  `id_list` int(10) NOT NULL auto_increment,
  `title` varchar(30) collate latin1_general_ci NOT NULL,
  `col` smallint(2) NOT NULL,
  `rank` smallint(2) NOT NULL,
  `collapsed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_list`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `list2tag`
--

CREATE TABLE IF NOT EXISTS `list2tag` (
  `id_list` varchar(10) collate latin1_general_ci NOT NULL,
  `id_tag` varchar(10) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) collate latin1_general_ci NOT NULL,
  `password` char(32) collate latin1_general_ci NOT NULL,
  `cookie` char(32) collate latin1_general_ci NOT NULL,
  `session` char(32) collate latin1_general_ci NOT NULL,
  `ip` varchar(15) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `memo`
--

CREATE TABLE IF NOT EXISTS `memo` (
  `id_memo` int(10) NOT NULL,
  `content` longtext collate latin1_general_ci,
  `update_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(10) unsigned NOT NULL auto_increment,
  `tag_text` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id_tag`),
  UNIQUE KEY `tag_text` (`tag_text`(50))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=50 ;
