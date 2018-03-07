-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 07 mars 2018 à 23:03
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `actualites`
--

INSERT INTO `actualites` (`idActualites`, `titreActualites`, `dateActualites`, `texteActualites`) VALUES
(1, 'Lancement de l\'Association !', '2018-03-06', 'Aujourd\'hui l\'Association NumAfrique se lance officiellement !'),
(2, 'L\'association compte son premier partenaire', '2018-03-07', 'PA-Industry vient tout juste de rejoindre notre association. Espérons que notre collaboration sera longue et enrichissante. '),
(3, 'Arrivée en masse d\'étudiant et de bénévoles', '2018-03-07', 'Des étudiants et des bénévoles commencent à s’inscrire de manière conséquente   ');

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
('NumAfrique', 'Une association pour lutter contre la fracture numérique.', 'La fracture numérique constitue un véritable frein au développement de l’Afrique et touche l’ensemble des domaines de l’économie et du social. Elle est matérialisée par des  inégalités d’accès à l\'information, aux savoirs, à la connaissance et au développement humain. À l\'avenir, les enjeux numériques sont énormes et devraient jouer un rôle clé dans le développement et l\'intégration socioéconomique du continent. \r\n<br>\r\nL’Afrique est aux prises avec d’importantes difficultés liées à cette fracture, plusieurs études ont montré l’utilité des TIC à contribuer aux développements économiques de l’Afrique. Des initiatives ont été prises ces dernières années comme  la  semaine africaine des TIC, qui a pour objectif de faire l\'état des lieux et de mettre l\'accent sur les progrès réalisés et les mesures à prendre afin de construire une société de l\'information et de la connaissance africaine. A l’état actuel, l\'Afrique, présente  seulement 140 millions d\'internautes, soit un taux de pénétration de l’ordre 13,5% qui reste très faible.  Avec l’éclosion de la téléphonie mobile sur le continent, l’espoir est permis en matière de réduction de la fracture numérique qui pénalise  assez gravement l’économie africaine.\r\nLa fracture numérique est présentée par de nombreuses études et organismes comme un problème intimement lié au sous-développement car elle est le reflet des nombreuses inégalités engendrées par le sous-développement. L’objectif de cette association est de contribuer à affaiblir ces inégalités.\r\n<br>\r\nL\'association a pour objectif d’affaiblir ces inégalités et à  lutter efficacement contre la fracture numérique à travers la mise en place de cours en Informatique en lien avec les besoins des entreprises locales dans différents pays.  \r\nLes apprenants  doivent maitriser les outils numériques afin de faciliter leur insertion et de participer à l’éclosion de l’économie locale.\r\n', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`idCandidature`, `compteCandidature`, `typeCandidature`, `experienceCandidature`, `lettreMotivCandidature`, `traiteeCandidature`, `accepteeCandidature`) VALUES
(1, 6, 0, NULL, 'J\'aimerai aider les jeunes qui sont difficultÃ©s pour s\'insÃ©rer dans la vie active.', 1, 1),
(2, 7, 0, NULL, 'Je veux instruire les jeunes aux nouvelles technologies.', 1, 1),
(3, 8, 0, NULL, 'J\'ai des difficultÃ©s avec les nouvelle technologies et j\'aimerais apprendre Ã  les utiliser.', 1, 1),
(4, 9, 0, NULL, 'parce que nicolas est beau', 1, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `certificationrequise`
--

INSERT INTO `certificationrequise` (`idCertificationRequise`, `stageCertificationRequise`, `formationCertificationRequise`) VALUES
(1, 1, 5);

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`idCompte`, `inscriptionCompte`, `nomCompte`, `mdpCompte`, `lettreMotivCompte`, `questionCompte`, `reponseCompte`, `nomEntrepriseCompte`, `typeCompte`, `actifCompte`, `coordonneesCompte`) VALUES
(5, '2018-03-07', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Je suis le créateur du site.', 'Qu\'est ce qui est petit et marron ?', 'Un marron', NULL, 0, 1, 1),
(6, '2018-03-07', 'entreprise-1', '81dc9bdb52d04dc20036dbd8313ed055', 'J\'aimerai aider les jeunes qui sont difficultÃ©s pour s\'insÃ©rer dans la vie active.', '1 + 1 = ?', '2', 'PA-Industry', 1, 1, 2),
(7, '2018-03-07', 'benevole', '81dc9bdb52d04dc20036dbd8313ed055', 'Je veux instruire les jeunes aux nouvelles technologies.', 'racine carrÃ©e de 81', '9', NULL, 3, 1, 3),
(8, '2018-03-07', 'etudiant', '81dc9bdb52d04dc20036dbd8313ed055', 'J\'ai des difficultÃ©s avec les nouvelle technologies et j\'aimerais apprendre Ã  les utiliser.', 'si la mÃ©moire est Ã  la tÃªte ce que le passÃ© peut-on y accÃ©der Ã  six ? Oui, non, zbradaraldjan ?', 'Oui', NULL, 2, 1, 4),
(9, '2018-03-07', 'etudiant-2', '81dc9bdb52d04dc20036dbd8313ed055', 'parce que nicolas est beau', 'toto', 'tata', NULL, 2, 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `coordonnees`
--

DROP TABLE IF EXISTS `coordonnees`;
CREATE TABLE IF NOT EXISTS `coordonnees` (
  `idCoordonnees` int(11) NOT NULL AUTO_INCREMENT,
  `nomCoordonnees` char(50) CHARACTER SET utf8 NOT NULL,
  `prenomCoordonnees` char(50) CHARACTER SET utf8 NOT NULL,
  `emailCoordonnees` char(150) CHARACTER SET utf8 DEFAULT NULL,
  `telephoneCoordonnees` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `adresseCoordonnees` char(200) CHARACTER SET utf8 NOT NULL COMMENT 'rue + numéro',
  `codePostalCoordonnees` int(10) NOT NULL,
  `villeCoordonnees` char(100) CHARACTER SET utf8 NOT NULL,
  `paysCoordonnees` char(100) CHARACTER SET utf8 NOT NULL,
  `gpsLongitudeCoordonnes` double DEFAULT NULL,
  `gpsLatitudeCoordonnees` double DEFAULT NULL,
  PRIMARY KEY (`idCoordonnees`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `coordonnees`
--

INSERT INTO `coordonnees` (`idCoordonnees`, `nomCoordonnees`, `prenomCoordonnees`, `emailCoordonnees`, `telephoneCoordonnees`, `adresseCoordonnees`, `codePostalCoordonnees`, `villeCoordonnees`, `paysCoordonnees`, `gpsLongitudeCoordonnes`, `gpsLatitudeCoordonnees`) VALUES
(1, 'Mountassir', 'Hassan', 'Hmountas@femto-st.fr', '0381666951', 'Route de Gray', 25000, 'Besançon', 'France', NULL, NULL),
(2, 'Piu', 'Pierre-Alexandre', 'pierre-alexandre.piu@edu.univ-fcomte.fr', '0381000001', '7 rue Pierre Laplace', 25000, 'BesanÃ§on', 'France', NULL, NULL),
(3, 'Idatte', 'Camille', 'camille.idatte@edu.univ-fcomte.fr', '0381000002', '7 rue Pierre Laplace', 25000, 'BesanÃ§on', 'France', NULL, NULL),
(4, 'Deniset', 'Nicolas', 'nicolas.deniset@edu.univ-fcomte.fr', '0381000003', '7 rue pierre laplace', 25000, 'BesanÃ§on', 'France', NULL, NULL),
(5, 'Dupont', 'Martin', 'Martin.dupont@email.fr', '0381000004', '7 rue pierre laplace', 25000, 'Pretoria', 'Afrique du Sud', 28.21837, -25.73134),
(6, 'Dupont', 'Alain', 'Alain.dupont@email.fr', '0381000005', '7 rue pierre laplace', 25000, 'Yaoundé', 'Cameroun', 11.51667, 3.86667),
(7, 'robez-Masson', 'David', 'david@bouh.org', '0684578327', '4 route de baume', 25110, 'luxiol', 'france', NULL, NULL),
(8, 'Bachetti', 'Antoine', 'antoine.bachetti@edu.univ-fcomte.fr', '0381000005', '7 rue pierre laplace', 25000, 'Pretoria', 'Afrique du Sud', NULL, NULL);

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
  `dureeFormation` int(11) NOT NULL COMMENT 'Nombre de semaines',
  `dispoFormation` tinyint(1) NOT NULL,
  PRIMARY KEY (`idFormation`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`idFormation`, `titreFormation`, `descriptionFormation`, `documentFormation`, `tailleDocumentFormation`, `dureeFormation`, `dispoFormation`) VALUES
(1, 'Travailler dans un environnement numérique évolutif', 'Tout au long de sa vie, l\'usager travaille dans un environnement numérique. La virtualisation des ressources, les risques inhérents au numérique et les enjeux de l\'interopérabilité rendent cet environnement complexe. Cela signifie qu\'il doit adapter son comportement aux spécificités des environnements multiples auxquels il est confronté en tenant compte des impératifs d\'échange et de pérennité, ainsi que des risques associés à sa situation.\r\n<br>Organiser un espace de travail  \r\n<br>Sécuriser son espace de travail local et distant\r\n<br>Tenir compte des enjeux de l\'interopérabilité\r\n<br>Pérenniser ses données', 'PROJET_L3', 145000, 6, 1),
(2, 'Être responsable à l\'ère du numérique', 'L\'usager évolue dans un environnement numérique toujours plus prégnant, plus imprévisible, qu\'il met à profit pour exposer non seulement des éléments de sa vie privée, mais aussi des éléments publics en lien avec son projet professionnel.. Dans ce contexte, le droit positif (ensemble des règles juridiques en vigueur) et des principes éthiques régulent l\'échange d\'informations et l\'appropriation de ressources numériques. Cela signifie notamment que l\'usager préserve son identité numérique, prend en compte les règles et les risques liés au partage d\'informations et adopte une attitude responsable. Pour cela, il connaît les réglementations et les règles de bon usage du numérique afin d\'éviter les infractions ou les maladresses, et de faire valoir ses droits.', 'PROJET_L3', 145000, 5, 1),
(3, 'Produire, traiter, exploiter et diffuser des documents numériques', 'L\'usager est amené à produire, traiter, exploiter et diffuser des documents numériques qui combinent des données de natures différentes, avec un objectif de productivité, de \"réutilisabilité\" et d\'accessibilité. Cela signifie qu\'il doit concevoir ses documents en ayant recours à l\'automatisation et les adapter en fonction de leur finalité. Les compétences qu\'il mobilise peuvent s\'exercer en local ou en ligne. Il les met en &#156;uvre en utilisant des logiciels de production de documents d&#146;usage courant (texte, diaporama, classeur, document en ligne).', 'PROJET_L3', 145000, 8, 1),
(4, 'Organiser la recherche d\'informations à l\'ère du numérique', 'Dans le monde numérique, l&#146;usager est confronté à une masse d&#146;informations pléthoriques et peu vérifiées, étant produites et diffusées par tous. Les informations accessibles ne sont pas toujours stables dans le temps, certaines se présentant même comme des flux d&#146;information diffusée en continu. Dans ce contexte, l&#146;usager met en place une démarche de recherche adaptée et évalue avec discernement la qualité des informations qu&#146;il trouve. Il exploite les informations et ressources pour documenter ses propres productions en les référençant conformément aux usages et compte tenu de leur potentielle instabilité. Il met en place une veille au moyen d&#146;outils d&#146;agrégation de flux, et organise ses références de façon à pouvoir y accéder en situation nomade.', 'PROJET_L3', 145000, 12, 0),
(5, 'Travailler en réseau, communiquer et collaborer', 'Lorsquon mène un projet ou une activité dans un cadre personnel ou professionnel, les échanges entre les acteurs se déroulent souvent sous forme numérique. Utiliser à bon escient les outils de communication et de travail collaboratif permet daméliorer lefficacité du travail mené à plusieurs. Dans ce contexte, lusager utilise avec discernement et efficacité les outils de communication numériques individuels ou de groupe pour échanger de linformation et travailler à plusieurs. Dans le cadre dune collaboration à distance, il contribue à la production synchrone ou asynchrone de documents communs en gardant la trace des modifications et des versions successives de ces documents.', 'PROJET_L3', 145000, 3, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `poleformation`
--

INSERT INTO `poleformation` (`idPoleFormation`, `coordonneesPoleFormation`, `nbBenevolesPoleFormation`) VALUES
(1, 5, 5),
(2, 6, 5);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `propose`
--

INSERT INTO `propose` (`idPropose`, `formationPropose`, `polePropose`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 3, 2),
(5, 4, 1),
(6, 4, 2),
(7, 5, 1),
(8, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `idStage` int(11) NOT NULL AUTO_INCREMENT,
  `titreStage` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `entrepriseStage` int(11) NOT NULL COMMENT 'id du compte de l''entreprise correspondante',
  `descriptionStage` text COLLATE utf8_unicode_ci NOT NULL,
  `coordonneesStage` int(11) NOT NULL,
  `dureeStage` int(11) NOT NULL COMMENT 'Nombre de semaines',
  `dispoStage` tinyint(1) NOT NULL,
  PRIMARY KEY (`idStage`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `stage`
--

INSERT INTO `stage` (`idStage`, `titreStage`, `entrepriseStage`, `descriptionStage`, `coordonneesStage`, `dureeStage`, `dispoStage`) VALUES
(1, 'Travailler en réseau, communiquer et collaborer', 6, 'Dans ce contexte, l\'usager utilise avec discernement et efficacité les outils de communication numériques individuels ou de groupe pour échanger de l\'information et travailler à plusieurs. Dans le cadre d\'une collaboration à distance, il contribue à la production synchrone ou asynchrone de documents communs en gardant la trace des modifications et des versions successives de ces documents.', 8, 8, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `temoignages`
--

INSERT INTO `temoignages` (`idTemoignages`, `compteTemoignages`, `texteTemoignages`, `dateTemoignages`, `anonymeTemoignages`) VALUES
(1, 6, 'Nous sommes très contents d\'être en partenariat avec l\'Association. Nous avons l\'impression d\'aider les jeunes à mieux s\'adapter à la société d\'aujourd\'hui.', '2018-03-07', 0),
(2, 7, 'Je suis heureuse de pouvoir partager mes connaissances avec des jeunes qui en ont vraiment besoin. J\'ai l\'impression d\'aider à la création d\'un monde meilleur', '2018-03-07', 0),
(3, 8, 'J\'ai appris énormément avec l\'Association et j\'espère pouvoir rapidement m\'insérer dans la vie active grâce a ce que j\'ai appris.  ', '2018-03-07', 0),
(4, 9, 'A mon arriver je n\'avais quasiment aucune connaissance concernant les nouvelles technologies. Et maintenant je peux me saisir correctement et facilement des nouvelles technologies.', '2018-03-07', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
