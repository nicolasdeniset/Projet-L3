-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 25 jan. 2018 à 22:35
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
-- Base de données :  `projet_l3`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

DROP TABLE IF EXISTS `actualites`;
CREATE TABLE IF NOT EXISTS `actualites` (
  `idActualites` int(11) NOT NULL AUTO_INCREMENT,
  `auteurActualites` int(11) NOT NULL,
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
  `dateDebutAeffectue` date NOT NULL,
  `dateFinAeffectue` date NOT NULL,
  `embauche` tinyint(1) NOT NULL,
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

-- --------------------------------------------------------

--
-- Structure de la table `asuivi`
--

DROP TABLE IF EXISTS `asuivi`;
CREATE TABLE IF NOT EXISTS `asuivi` (
  `idAsuivi` int(11) NOT NULL AUTO_INCREMENT,
  `etudiantAsuivi` int(11) NOT NULL,
  `formationAsuivi` int(11) NOT NULL,
  `poleFormationAsuivi` int(11) NOT NULL,
  `dateDebutAsuivi` date NOT NULL,
  `dateFinAsuivi` date NOT NULL,
  `certificationAsuivi` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAsuivi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `benevole`
--

DROP TABLE IF EXISTS `benevole`;
CREATE TABLE IF NOT EXISTS `benevole` (
  `idBenevole` int(11) NOT NULL AUTO_INCREMENT,
  `coordonneesBenevole` int(11) NOT NULL,
  PRIMARY KEY (`idBenevole`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

DROP TABLE IF EXISTS `candidature`;
CREATE TABLE IF NOT EXISTS `candidature` (
  `idCandidature` int(11) NOT NULL AUTO_INCREMENT,
  `compteCandidature` int(11) NOT NULL,
  `cvCandidature` char(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'lien vers le CV (pas pour les entreprises)',
  `lettreMotivCandidature` char(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'lien vers la LM',
  `typeCandidature` int(1) NOT NULL COMMENT '0 : entreprise, 1 : etudiant, (2 : benevole ?)',
  `traiteeCandidature` tinyint(1) NOT NULL,
  `AccepteeCandidature` tinyint(1) NOT NULL,
  PRIMARY KEY (`idCandidature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `certifiactionrequise`
--

DROP TABLE IF EXISTS `certifiactionrequise`;
CREATE TABLE IF NOT EXISTS `certifiactionrequise` (
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
  `questionCompte` char(200) COLLATE utf8_unicode_ci NOT NULL,
  `reponseCompte` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `typeCompte` int(1) NOT NULL COMMENT '0 : admin, 1 : entreprise, 2 : etudiant',
  `coordonneesCompte` int(11) NOT NULL,
  PRIMARY KEY (`idCompte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Structure de la table `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `idStage` int(11) NOT NULL AUTO_INCREMENT,
  `titreStage` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionStage` text COLLATE utf8_unicode_ci NOT NULL,
  `coordonneesStage` int(11) NOT NULL,
  `dureeStage` int(11) NOT NULL COMMENT 'Nombre de semaines',
  `lienStage` char(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Url vers la proposition de l''entreprise',
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
  PRIMARY KEY (`idTemoignages`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
