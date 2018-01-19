-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 19 Janvier 2018 à 20:37
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `actualites` (
  `idActualites` int(11) NOT NULL,
  `auteurActualites` int(11) NOT NULL,
  `texteActualites` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `aeffectue`
--

CREATE TABLE `aeffectue` (
  `idAeffectue` int(11) NOT NULL,
  `etudiantAeffectue` int(11) NOT NULL,
  `stageAeffectue` int(11) NOT NULL,
  `certificationAeffectue` int(11) NOT NULL,
  `dateDebutAeffectue` date NOT NULL,
  `dateFinAeffectue` date NOT NULL,
  `embauche` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `asuivi`
--

CREATE TABLE `asuivi` (
  `idAsuivi` int(11) NOT NULL,
  `etudiantAsuivi` int(11) NOT NULL,
  `formationAsuivi` int(11) NOT NULL,
  `poleFormationAsuivi` int(11) NOT NULL,
  `dateDebutAsuivi` date NOT NULL,
  `dateFinAsuivi` date NOT NULL,
  `certificationAsuivi` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `benevole`
--

CREATE TABLE `benevole` (
  `idBenevole` int(11) NOT NULL,
  `coordonneesBenevole` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE `candidature` (
  `idCandidature` int(11) NOT NULL,
  `compteCandidature` int(11) NOT NULL,
  `cvCandidature` char(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'lien vers le CV (pas pour les entreprises)',
  `lettreMotivCandidature` char(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'lien vers la LM',
  `typeCandidature` int(1) NOT NULL COMMENT '0 : entreprise, 1 : etudiant, (2 : benevole ?)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `certifiactionrequise`
--

CREATE TABLE `certifiactionrequise` (
  `idCertificationRequise` int(11) NOT NULL,
  `stageCertificationRequise` int(11) NOT NULL,
  `formationCertificationRequise` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `idCompte` int(11) NOT NULL,
  `nomCompte` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `mdpCompte` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `questionCompte` char(200) COLLATE utf8_unicode_ci NOT NULL,
  `reponseCompte` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `typeCompte` int(1) NOT NULL COMMENT '0 : admin, 1 : entreprise, 2 : etudiant',
  `coordonneesCompte` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `coordonnees`
--

CREATE TABLE `coordonnees` (
  `idCoordonnees` int(11) NOT NULL,
  `nomCoordonnees` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenomCoordonnees` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `emailCoordonnees` char(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephoneCoordonnees` int(12) NOT NULL,
  `adresseCoordonnees` char(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'rue + numéro',
  `codePostalCoordonnees` int(10) NOT NULL,
  `villeCoordonnees` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `paysCoordonnees` char(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignement`
--

CREATE TABLE `enseignement` (
  `idEnseignement` int(11) NOT NULL,
  `formationEnseignement` int(11) NOT NULL,
  `poleFormationEnseignement` int(11) NOT NULL,
  `benevoleEnseignement` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `idFormation` int(11) NOT NULL,
  `titreFormation` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionFormation` text COLLATE utf8_unicode_ci NOT NULL,
  `documentFormation` char(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Url fichier',
  `dureeFormation` int(11) NOT NULL COMMENT 'Nombre de jours'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poleformation`
--

CREATE TABLE `poleformation` (
  `idPoleFormation` int(11) NOT NULL,
  `coordonneesPoleFormation` int(11) NOT NULL,
  `nbBenevolesPoleFormation` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE `stage` (
  `idStage` int(11) NOT NULL,
  `titreStage` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionStage` text COLLATE utf8_unicode_ci NOT NULL,
  `coordonneesStage` int(11) NOT NULL,
  `dureeStage` int(11) NOT NULL COMMENT 'Nombre de semaines',
  `lienStage` char(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Url vers la proposition de l''entreprise'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `actualites`
--
ALTER TABLE `actualites`
  ADD PRIMARY KEY (`idActualites`);

--
-- Index pour la table `aeffectue`
--
ALTER TABLE `aeffectue`
  ADD PRIMARY KEY (`idAeffectue`);

--
-- Index pour la table `asuivi`
--
ALTER TABLE `asuivi`
  ADD PRIMARY KEY (`idAsuivi`);

--
-- Index pour la table `benevole`
--
ALTER TABLE `benevole`
  ADD PRIMARY KEY (`idBenevole`);

--
-- Index pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD PRIMARY KEY (`idCandidature`);

--
-- Index pour la table `certifiactionrequise`
--
ALTER TABLE `certifiactionrequise`
  ADD PRIMARY KEY (`idCertificationRequise`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`idCompte`);

--
-- Index pour la table `coordonnees`
--
ALTER TABLE `coordonnees`
  ADD PRIMARY KEY (`idCoordonnees`);

--
-- Index pour la table `enseignement`
--
ALTER TABLE `enseignement`
  ADD PRIMARY KEY (`idEnseignement`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`idFormation`);

--
-- Index pour la table `poleformation`
--
ALTER TABLE `poleformation`
  ADD PRIMARY KEY (`idPoleFormation`);

--
-- Index pour la table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`idStage`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `actualites`
--
ALTER TABLE `actualites`
  MODIFY `idActualites` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `aeffectue`
--
ALTER TABLE `aeffectue`
  MODIFY `idAeffectue` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `asuivi`
--
ALTER TABLE `asuivi`
  MODIFY `idAsuivi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `benevole`
--
ALTER TABLE `benevole`
  MODIFY `idBenevole` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `candidature`
--
ALTER TABLE `candidature`
  MODIFY `idCandidature` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `certifiactionrequise`
--
ALTER TABLE `certifiactionrequise`
  MODIFY `idCertificationRequise` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `idCompte` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `coordonnees`
--
ALTER TABLE `coordonnees`
  MODIFY `idCoordonnees` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `enseignement`
--
ALTER TABLE `enseignement`
  MODIFY `idEnseignement` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `idFormation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `poleformation`
--
ALTER TABLE `poleformation`
  MODIFY `idPoleFormation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `stage`
--
ALTER TABLE `stage`
  MODIFY `idStage` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
