-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 04 jan. 2021 à 15:01
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bougies`
--






-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id_bougie` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  KEY `id_bougie` (`id_bougie`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id_recette` int(11) NOT NULL AUTO_INCREMENT,
  `id_bougie` int(11) NOT NULL,
  `id_odeur` int(11) NOT NULL,
  `quantité` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_recette`),
  KEY `id_odeur` (`id_odeur`),
  KEY `id_bougie` (`id_bougie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `odeur`
--

DROP TABLE IF EXISTS `odeur`;
CREATE TABLE IF NOT EXISTS `odeur` (
  `id_odeur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_odeur` varchar(20) NOT NULL,
  `statut_odeur` enum('possess','wish','idea') NOT NULL DEFAULT 'possess',
  PRIMARY KEY (`id_odeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Structure de la table `bougie`
--

DROP TABLE IF EXISTS `bougie`;
CREATE TABLE IF NOT EXISTS `bougie` (
  `id_bougie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_bougie` varchar(50) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_collection` int(11) DEFAULT NULL,
  `statut_bougie` enum('validée','neutre','rejetée') NOT NULL DEFAULT 'neutre',
  PRIMARY KEY (`id_bougie`),
  KEY `id_collection` (`id_collection`),
  KEY `id_livre` (`id_livre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `collection`
--

DROP TABLE IF EXISTS `collection`;
CREATE TABLE IF NOT EXISTS `collection` (
  `id_collection` int(11) NOT NULL AUTO_INCREMENT,
  `nom_collection` varchar(40) NOT NULL,
  PRIMARY KEY (`id_collection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `id_livre` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(30) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  PRIMARY KEY (`id_livre`),
  KEY `id_auteur` (`id_auteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

DROP TABLE IF EXISTS `auteur`;
CREATE TABLE IF NOT EXISTS `auteur` (
  `id_auteur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_auteur` varchar(40) NOT NULL,
  PRIMARY KEY (`id_auteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bougie`
--
ALTER TABLE `bougie`
  ADD CONSTRAINT `collection_bougie` FOREIGN KEY (`id_collection`) REFERENCES `collection` (`id_collection`),
  ADD CONSTRAINT `livre_bougie` FOREIGN KEY (`id_livre`) REFERENCES `livre` (`id_livre`);

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_bougie` FOREIGN KEY (`id_bougie`) REFERENCES `bougie` (`id_bougie`),
  ADD CONSTRAINT `events_event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_auteur` FOREIGN KEY (`id_auteur`) REFERENCES `auteur` (`id_auteur`);

--
-- Contraintes pour la table `recette`
--
ALTER TABLE `recette`
  ADD CONSTRAINT `recette_bougie` FOREIGN KEY (`id_bougie`) REFERENCES `bougie` (`id_bougie`),
  ADD CONSTRAINT `recette_odeur` FOREIGN KEY (`id_odeur`) REFERENCES `odeur` (`id_odeur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;