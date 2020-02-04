-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le : Sam 03 Mars 2018 à 17:47
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gsbconf`
--

-- --------------------------------------------------------

--
-- Structure de la table `animateur`
--

CREATE TABLE IF NOT EXISTS `animateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `adresse` varchar(25) DEFAULT NULL,
  `cp` varchar(25) DEFAULT NULL,
  `ville` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `animateur`
--

INSERT INTO `animateur` (`id`, `nom`, `prenom`, `adresse`, `cp`, `ville`) VALUES
(1, 'Mr Dupont', 'Antoine', 'ches le plus beau ', 'le bg du 91', 'tu veux sortir avec moi ?');

-- --------------------------------------------------------

--
-- Structure de la table `conference`
--

CREATE TABLE IF NOT EXISTS `conference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) NOT NULL,
  `id_salle` int(11) NOT NULL,
  `id_animateur` int(11) NOT NULL,
  `heureD` varchar(25) DEFAULT NULL,
  `dateConf` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_conference_id_theme` (`id_theme`),
  KEY `FK_conference_id_salle` (`id_salle`),
  KEY `FK_conference_id_animateur` (`id_animateur`),
  KEY `FK_conference_heureD` (`heureD`),
  KEY `FK_conference_dateConf` (`dateConf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `conference`
--

INSERT INTO `conference` (`id`, `id_theme`, `id_salle`, `id_animateur`, `heureD`, `dateConf`) VALUES
(1, 1, 1, 1, '17:00', '02/03/2018'),
(2, 2, 2, 1, '17:00', '02/03/2018');

-- --------------------------------------------------------

--
-- Structure de la table `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `dateConf` varchar(25) NOT NULL,
  PRIMARY KEY (`dateConf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `date`
--

INSERT INTO `date` (`dateConf`) VALUES
('02/03/2018');

-- --------------------------------------------------------

--
-- Structure de la table `heure`
--

CREATE TABLE IF NOT EXISTS `heure` (
  `heureD` varchar(25) NOT NULL,
  PRIMARY KEY (`heureD`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `heure`
--

INSERT INTO `heure` (`heureD`) VALUES
('17:00');

-- --------------------------------------------------------

--
-- Structure de la table `inscris`
--

CREATE TABLE IF NOT EXISTS `inscris` (
  `id` int(11) NOT NULL,
  `id_conference` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_conference`),
  KEY `FK_inscris_id_conference` (`id_conference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `inscris`
--

INSERT INTO `inscris` (`id`, `id_conference`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capacite` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`id`, `capacite`) VALUES
(1, 15),
(2, 60);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelleTheme` varchar(25) DEFAULT NULL,
  `duree` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`id`, `libelleTheme`, `duree`) VALUES
(1, 'les singes', '103'),
(2, 'les patates', '106');

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `login` varchar(25) NOT NULL,
  `mdp` varchar(60) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `ville` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`) VALUES
(1, 'melvin', 'kl', 'mjesio', '6f8f57715090da2632453988d9a1501b', 'f', 'ef', 'fe');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `conference`
--
ALTER TABLE `conference`
  ADD CONSTRAINT `FK_conference_dateConf` FOREIGN KEY (`dateConf`) REFERENCES `date` (`dateConf`),
  ADD CONSTRAINT `FK_conference_heureD` FOREIGN KEY (`heureD`) REFERENCES `heure` (`heureD`),
  ADD CONSTRAINT `FK_conference_id_animateur` FOREIGN KEY (`id_animateur`) REFERENCES `animateur` (`id`),
  ADD CONSTRAINT `FK_conference_id_salle` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id`),
  ADD CONSTRAINT `FK_conference_id_theme` FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id`);

--
-- Contraintes pour la table `inscris`
--
ALTER TABLE `inscris`
  ADD CONSTRAINT `FK_inscris_id` FOREIGN KEY (`id`) REFERENCES `visiteur` (`id`),
  ADD CONSTRAINT `FK_inscris_id_conference` FOREIGN KEY (`id_conference`) REFERENCES `conference` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
