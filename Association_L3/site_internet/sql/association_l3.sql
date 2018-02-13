-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 13 fév. 2018 à 13:30
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `association_l3`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

DROP TABLE IF EXISTS `actualites`;
CREATE TABLE IF NOT EXISTS `actualites` (
  `idActualites` int(11) NOT NULL AUTO_INCREMENT,
  `titreActualites` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateActualites` date NOT NULL,
  `texteActualites` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idActualites`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `aeffectue`
--

DROP TABLE IF EXISTS `aeffectue`;
CREATE TABLE IF NOT EXISTS `aeffectue` (
  `idAeffectue` int(11) NOT NULL AUTO_INCREMENT,
  `etudiantAeffectue` int(11) NOT NULL,
  `stageAeffectue` int(11) NOT NULL,
  `tuteurAeffectue` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `dateDebutAeffectue` date NOT NULL,
  `dateFinAeffectue` date NOT NULL,
  `embaucheAeffectue` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAeffectue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `association`
--

DROP TABLE IF EXISTS `association`;
CREATE TABLE IF NOT EXISTS `association` (
  `nomAssociation` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `sloganAssociation` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionAssociation` text COLLATE utf8_unicode_ci NOT NULL,
  `coordonnesAssociation` int(11) NOT NULL,
  PRIMARY KEY (`nomAssociation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `association`
--

INSERT INTO `association` (`nomAssociation`, `sloganAssociation`, `descriptionAssociation`, `coordonnesAssociation`) VALUES
('The association', 'Un slogan plutôt sympa ! patatipatata patatapatati', 'Blabla Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0);

-- --------------------------------------------------------

--
-- Structure de la table `asuivi`
--

DROP TABLE IF EXISTS `asuivi`;
CREATE TABLE IF NOT EXISTS `asuivi` (
  `idAsuivi` int(11) NOT NULL AUTO_INCREMENT,
  `etudiantAsuivi` int(11) NOT NULL,
  `formationAsuivi` int(11) NOT NULL COMMENT 'id table propose',
  `dateDebutAsuivi` date NOT NULL,
  `dateFinAsuivi` date NOT NULL,
  `certificationAsuivi` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAsuivi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

DROP TABLE IF EXISTS `candidature`;
CREATE TABLE IF NOT EXISTS `candidature` (
  `idCandidature` int(11) NOT NULL AUTO_INCREMENT,
  `compteCandidature` int(11) NOT NULL,
  `typeCandidature` int(1) NOT NULL COMMENT '0 : inscription, 1 : formation, 2 : stage',
  `experienceCandidature` int(11) DEFAULT NULL COMMENT 'id du stage/formation',
  `lettreMotivCandidature` text COLLATE utf8_unicode_ci NOT NULL,
  `traiteeCandidature` tinyint(1) NOT NULL,
  `accepteeCandidature` tinyint(1) NOT NULL,
  PRIMARY KEY (`idCandidature`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`idCandidature`, `compteCandidature`, `typeCandidature`, `experienceCandidature`, `lettreMotivCandidature`, `traiteeCandidature`, `accepteeCandidature`) VALUES
(1, 3, 0, NULL, 'meh', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `certificationrequise`
--

DROP TABLE IF EXISTS `certificationrequise`;
CREATE TABLE IF NOT EXISTS `certificationrequise` (
  `idCertificationRequise` int(11) NOT NULL AUTO_INCREMENT,
  `stageCertificationRequise` int(11) NOT NULL,
  `formationCertificationRequise` int(11) NOT NULL,
  PRIMARY KEY (`idCertificationRequise`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `idCompte` int(11) NOT NULL AUTO_INCREMENT,
  `inscriptionCompte` date NOT NULL,
  `nomCompte` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `mdpCompte` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `lettreMotivCompte` text COLLATE utf8_unicode_ci NOT NULL,
  `questionCompte` char(200) COLLATE utf8_unicode_ci NOT NULL,
  `reponseCompte` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `nomEntrepriseCompte` char(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `typeCompte` int(1) NOT NULL COMMENT '0 : admin, 1 : entreprise, 2 : étiduant, 3 : bénévole',
  `actifCompte` tinyint(1) NOT NULL DEFAULT '0',
  `coordonneesCompte` int(11) NOT NULL,
  PRIMARY KEY (`idCompte`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`idCompte`, `inscriptionCompte`, `nomCompte`, `mdpCompte`, `lettreMotivCompte`, `questionCompte`, `reponseCompte`, `nomEntrepriseCompte`, `typeCompte`, `actifCompte`, `coordonneesCompte`) VALUES
(1, '2018-02-10', 'TestEntreprise', 'entrep42', 'Oui je suis une entreprise, bonsoir', 'Qui veut gagner des millions ?', 'Moi', 'Une Entreprise', 1, 1, 0),
(2, '2018-02-11', 'test', 'test', 'oui', 'Oui ?', 'Oui !', NULL, 2, 1, 1),
(3, '2018-02-12', 'mehmeh', '3be14dc77eaf10c9a42d11e60bf75cf8', 'meh', 'mehmeh', 'mehmeh', NULL, 2, 0, 2),
(4, '2018-02-12', 'admin', '3be14dc77eaf10c9a42d11e60bf75cf8', 'Je suis un admin je fais ce que je veux', 'Puteuh', 'J\'ai dit puteuh', NULL, 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `coordonnees`
--

DROP TABLE IF EXISTS `coordonnees`;
CREATE TABLE IF NOT EXISTS `coordonnees` (
  `idCoordonnees` int(11) NOT NULL AUTO_INCREMENT,
  `nomCoordonnees` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenomCoordonnees` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `emailCoordonnees` char(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephoneCoordonnees` int(12) NOT NULL,
  `adresseCoordonnees` char(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'rue + numéro',
  `codePostalCoordonnees` int(10) NOT NULL,
  `villeCoordonnees` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `paysCoordonnees` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `gpsLongitudeCoordonnes` float DEFAULT NULL,
  `gpsLatitudeCoordonnees` float DEFAULT NULL,
  PRIMARY KEY (`idCoordonnees`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `coordonnees`
--

INSERT INTO `coordonnees` (`idCoordonnees`, `nomCoordonnees`, `prenomCoordonnees`, `emailCoordonnees`, `telephoneCoordonnees`, `adresseCoordonnees`, `codePostalCoordonnees`, `villeCoordonnees`, `paysCoordonnees`, `gpsLongitudeCoordonnes`, `gpsLatitudeCoordonnees`) VALUES
(1, 'Crapaud', 'Jean-Michel', 'oui@oui.fr', 666777888, '2 rue de la river', 25000, 'FailleDeLinvocateur', 'Runeterra', NULL, NULL),
(2, 'meh', 'meh', 'meh@meh.fr', 1122334455, '2, rue meh', 22222, 'meh', 'meh', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `donations`
--

DROP TABLE IF EXISTS `donations`;
CREATE TABLE IF NOT EXISTS `donations` (
  `idDonations` int(11) NOT NULL AUTO_INCREMENT,
  `montantDonations` int(11) NOT NULL,
  `nomDonateurDonations` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Anonyme',
  PRIMARY KEY (`idDonations`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignement`
--

DROP TABLE IF EXISTS `enseignement`;
CREATE TABLE IF NOT EXISTS `enseignement` (
  `idEnseignement` int(11) NOT NULL AUTO_INCREMENT,
  `formationEnseignement` int(11) NOT NULL,
  `poleFormationEnseignement` int(11) NOT NULL,
  `benevoleEnseignement` int(11) NOT NULL,
  PRIMARY KEY (`idEnseignement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `idFormation` int(11) NOT NULL AUTO_INCREMENT,
  `titreFormation` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionFormation` text COLLATE utf8_unicode_ci NOT NULL,
  `documentFormation` char(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Url fichier',
  `tailleDocumentFormation` float NOT NULL,
  `dureeFormation` int(11) NOT NULL COMMENT 'Nombre de jours',
  `dispoFormation` tinyint(1) NOT NULL,
  PRIMARY KEY (`idFormation`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`idFormation`, `titreFormation`, `descriptionFormation`, `documentFormation`, `tailleDocumentFormation`, `dureeFormation`, `dispoFormation`) VALUES
(1, 'Petite formation', 'Rapide description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'meh', 888888, 6, 1),
(2, 'Formation non dispo', 'On a dit non tamer', 'meh', 888888, 2, 0),
(3, 'Formation du sel', 'Rapide description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'gne', 88888, 8, 1),
(4, 'Oui formation', 'Rapide description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'meh', 88888, 5, 1),
(5, 'La formation chiante', 'Rapide description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'meh', 88888, 12, 1),
(6, 'Tamer', 'oui', 'PROJET-L3.pdf', 147555, 5, 1),
(7, 'La formation du cul', 'bonsoir', 'PROJET-L3.pdf', 147555, 5, 1),
(8, 'Meh formation', 'zehzr', 'php_3.pdf', 1077430, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `poleformation`
--

DROP TABLE IF EXISTS `poleformation`;
CREATE TABLE IF NOT EXISTS `poleformation` (
  `idPoleFormation` int(11) NOT NULL AUTO_INCREMENT,
  `coordonneesPoleFormation` int(11) NOT NULL,
  `nbBenevolesPoleFormation` int(11) NOT NULL,
  PRIMARY KEY (`idPoleFormation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `propose`
--

DROP TABLE IF EXISTS `propose`;
CREATE TABLE IF NOT EXISTS `propose` (
  `idPropose` int(11) NOT NULL AUTO_INCREMENT,
  `formationPropose` int(11) NOT NULL,
  `polePropose` int(11) NOT NULL,
  PRIMARY KEY (`idPropose`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `idStage` int(11) NOT NULL AUTO_INCREMENT,
  `titreStage` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionStage` text COLLATE utf8_unicode_ci NOT NULL,
  `coordonneesStage` int(11) NOT NULL,
  `dureeStage` int(11) NOT NULL COMMENT 'Nombre de semaines',
  PRIMARY KEY (`idStage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `temoignages`
--

DROP TABLE IF EXISTS `temoignages`;
CREATE TABLE IF NOT EXISTS `temoignages` (
  `idTemoignages` int(11) NOT NULL AUTO_INCREMENT,
  `compteTemoignages` int(11) NOT NULL,
  `texteTemoignages` text COLLATE utf8_unicode_ci NOT NULL,
  `dateTemoignages` date NOT NULL,
  `anonymeTemoignages` tinyint(1) NOT NULL,
  PRIMARY KEY (`idTemoignages`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `temoignages`
--

INSERT INTO `temoignages` (`idTemoignages`, `compteTemoignages`, `texteTemoignages`, `dateTemoignages`, `anonymeTemoignages`) VALUES
(1, 1, 'Essai d\'un témoignage par une entreprise', '2018-02-11', 0),
(2, 2, 'Test d\'un témoignage par un étudiant', '2018-02-11', 0),
(3, 1, 'Test anonyme d\'une entreprise', '2018-02-11', 1),
(6, 2, 'Test anonyme d\'un témoignage d\'étudiant', '2018-02-11', 1),
(7, 2, 'Nouvel essai d\'étudiant qui témoigne', '2018-02-11', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
