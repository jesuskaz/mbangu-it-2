-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 01 juil. 2021 à 13:27
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mbangupay`
--
CREATE DATABASE IF NOT EXISTS `mbangupay` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mbangupay`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int(11) NOT NULL AUTO_INCREMENT,
  `nomComplet` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `login` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`idadmin`, `nomComplet`, `login`, `password`) VALUES
(1, 'kazembe ', 'jesus', '0000');

-- --------------------------------------------------------

--
-- Structure de la table `anneeacademique`
--

DROP TABLE IF EXISTS `anneeacademique`;
CREATE TABLE IF NOT EXISTS `anneeacademique` (
  `idanneeAcademique` int(11) NOT NULL AUTO_INCREMENT,
  `iduniversite` int(11) NOT NULL,
  `annee` varchar(100) DEFAULT NULL,
  `actif` int(11) DEFAULT NULL,
  PRIMARY KEY (`idanneeAcademique`),
  KEY `fk_anneeAcademique_universite1_idx` (`iduniversite`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `anneeacademique`
--

INSERT INTO `anneeacademique` (`idanneeAcademique`, `iduniversite`, `annee`, `actif`) VALUES
(13, 1, '2021-05-22 2021-05-15', 1),
(14, 2, '2021-05-19 2021-05-06', 0),
(15, 1, '2021-02-01 2022-01-02', NULL),
(16, 1, '2022-03-02 2022-02-02', NULL),
(17, 1, '2021-06-17 2021-06-11', NULL),
(18, 3, '2021-06-14 2021-06-12', NULL),
(19, 2, '2021-07-01 2022-07-31', 1),
(20, 3, '2021-07-01 2022-07-31', 1);

-- --------------------------------------------------------

--
-- Structure de la table `annee_scolaire_ecole`
--

DROP TABLE IF EXISTS `annee_scolaire_ecole`;
CREATE TABLE IF NOT EXISTS `annee_scolaire_ecole` (
  `idannee_scolaire_ecole` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `idecole` int(11) NOT NULL,
  PRIMARY KEY (`idannee_scolaire_ecole`),
  KEY `fk_annee_scolaire_ecole_ecole1_idx` (`idecole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `appro`
--

DROP TABLE IF EXISTS `appro`;
CREATE TABLE IF NOT EXISTS `appro` (
  `idappro` int(11) NOT NULL AUTO_INCREMENT,
  `idoperateur` int(11) NOT NULL,
  `iddevise` int(11) NOT NULL,
  `idetudiant` int(11) NOT NULL,
  `montant` double DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `typeOperation` text NOT NULL,
  PRIMARY KEY (`idappro`),
  KEY `fk_appro_etudiant1_idx` (`idetudiant`),
  KEY `fk_appro_devise1_idx` (`iddevise`),
  KEY `fk_appro_operateur1_idx` (`idoperateur`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appro`
--

INSERT INTO `appro` (`idappro`, `idoperateur`, `iddevise`, `idetudiant`, `montant`, `date`, `typeOperation`) VALUES
(35, 2, 4, 8, 100, '2021-06-02 16:09:39', ''),
(36, 2, 1, 8, 120, '2021-06-03 01:59:01', ''),
(37, 2, 4, 8, 1000, '2021-06-03 12:48:03', ''),
(38, 2, 1, 8, 200, '2021-06-03 12:48:17', ''),
(39, 2, 1, 8, 20, '2021-06-04 14:08:50', ''),
(40, 2, 4, 11, 1000, '2021-06-04 15:03:27', ''),
(41, 2, 1, 11, 200, '2021-06-04 15:03:38', ''),
(42, 2, 1, 11, 20, '2021-06-04 15:39:43', ''),
(43, 2, 4, 8, 1000, '2021-06-04 17:51:09', ''),
(44, 2, 1, 11, 100, '2021-06-05 23:01:09', ''),
(45, 2, 1, 11, 100, '2021-06-05 23:10:14', ''),
(46, 2, 1, 11, 100, '2021-06-05 23:10:29', ''),
(47, 2, 1, 16, 100, '2021-06-07 09:48:31', ''),
(48, 2, 4, 16, 2000, '2021-06-07 10:38:05', ''),
(49, 1, 1, 8, 100, '2021-06-11 12:45:20', ''),
(50, 2, 1, 8, 10, '2021-06-11 12:46:10', ''),
(51, 2, 1, 8, 1000, '2021-06-11 12:47:30', ''),
(52, 2, 1, 8, 500, '2021-06-11 12:48:38', ''),
(53, 2, 4, 12, 100, '2021-06-11 12:49:06', ''),
(54, 2, 1, 12, 200, '2021-06-11 12:49:19', ''),
(55, 2, 4, 8, 100, '2021-06-14 01:50:19', ''),
(56, 2, 4, 8, 100, '2021-06-16 00:14:14', ''),
(57, 2, 4, 8, 1000, '2021-06-16 00:14:27', ''),
(58, 2, 4, 8, 200, '2021-06-16 00:14:45', ''),
(59, 2, 1, 8, 100, '2021-06-16 00:15:00', ''),
(60, 2, 4, 8, 100, '2021-06-16 00:34:57', ''),
(61, 2, 4, 8, 100, '2021-06-16 00:39:40', ''),
(62, 2, 4, 8, 10, '2021-06-16 01:40:07', ''),
(63, 2, 4, 8, 20, '2021-06-23 09:42:38', '');

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

DROP TABLE IF EXISTS `banque`;
CREATE TABLE IF NOT EXISTS `banque` (
  `idbanque` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `login` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`idbanque`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `banque`
--

INSERT INTO `banque` (`idbanque`, `denomination`, `login`, `password`) VALUES
(1, 'RAWBANK', 'adrawbank', '445566'),
(2, 'TMB', 'kidinda', '123456');

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `idclasse` int(11) NOT NULL AUTO_INCREMENT,
  `intituleclasse` varchar(45) DEFAULT NULL,
  `idoptionecole` int(11) NOT NULL,
  `idannee_scolaire_ecole` int(11) NOT NULL,
  PRIMARY KEY (`idclasse`),
  KEY `fk_classe_optionecole1_idx` (`idoptionecole`),
  KEY `fk_classe_annee_scolaire_ecole1_idx` (`idannee_scolaire_ecole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devise`
--

DROP TABLE IF EXISTS `devise`;
CREATE TABLE IF NOT EXISTS `devise` (
  `iddevise` int(11) NOT NULL AUTO_INCREMENT,
  `nomDevise` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`iddevise`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devise`
--

INSERT INTO `devise` (`iddevise`, `nomDevise`) VALUES
(1, 'USD'),
(4, 'CDF'),
(5, 'EUR');

-- --------------------------------------------------------

--
-- Structure de la table `ecole`
--

DROP TABLE IF EXISTS `ecole`;
CREATE TABLE IF NOT EXISTS `ecole` (
  `idecole` int(11) NOT NULL AUTO_INCREMENT,
  `nomecole` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` text,
  PRIMARY KEY (`idecole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `ideleve` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `postnom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `matricule` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `password` text,
  `idclasse` int(11) NOT NULL,
  PRIMARY KEY (`ideleve`),
  KEY `fk_eleve_classe1_idx` (`idclasse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `idetudiant` int(11) NOT NULL AUTO_INCREMENT,
  `idanneeAcademique` int(11) NOT NULL,
  `idpromotion` int(11) NOT NULL,
  `idville` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `postnom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `matricule` varchar(45) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `nationnalite` varchar(100) DEFAULT NULL,
  `carte` varchar(128) DEFAULT NULL,
  `picture` varchar(128) DEFAULT NULL,
  `password` text,
  PRIMARY KEY (`idetudiant`),
  KEY `fk_etudiant_ville1_idx` (`idville`),
  KEY `fk_etudiant_promotion1_idx` (`idpromotion`),
  KEY `fk_etudiant_anneeAcademique1_idx` (`idanneeAcademique`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`idetudiant`, `idanneeAcademique`, `idpromotion`, `idville`, `nom`, `postnom`, `prenom`, `matricule`, `adresse`, `email`, `telephone`, `sexe`, `nationnalite`, `carte`, `picture`, `password`) VALUES
(8, 13, 6, 8, 'jesus', 'kidinda', 'kazembe', '12kk12', 'makome/40/DuCobalt', 'kid@gmail.com', '+243970719030', 'M', 'Kinoise', 'upload/carte/image_cropper_1624289588054.jpg', 'upload/profile/image_cropper_1624272899967.jpg', '1234567890'),
(9, 13, 6, 1, 'kidinda', 'kidinda', 'kazembe', '12mm12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234567890'),
(10, 14, 18, 1, 'kazadi', 'jordan', 'kidinda', 'k12k', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345'),
(11, 13, 6, 1, 'jesus', 'jesus', 'jesus', 'jesus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kkk'),
(12, 13, 6, 8, 'lll', 'lll', 'lll', 'lll', 'glf', 'glg', NULL, 'M', 'glg', NULL, NULL, 'lll'),
(13, 13, 6, 1, 'king', 'king', 'king', 'king', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345'),
(14, 13, 6, 1, 'jl', 'jl', 'jl', 'jljl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kidinda'),
(15, 13, 6, 9, 'kazembe', 'jesus', 'kidinda', '16kk169', 'Good', 'jesus@gmail.com', NULL, 'M', 'Canadienne', NULL, NULL, 'kid'),
(16, 13, 6, 1, 'kaz', 'kid', 'kiz', 'kid', 'all', 'jesuskazkid@gmail.com', '+243 993 093 010', 'M', 'congolaise', NULL, 'upload/profile/image_cropper_1623915147512.jpg', 'kid'),
(18, 13, 6, 1, 'kidinda', 'kaz', 'kid', 'all12', NULL, NULL, '--', NULL, NULL, NULL, NULL, 'all12'),
(21, 13, 6, 1, 'kl', 'lj', 'kj', 'jl', NULL, NULL, 'tel', NULL, NULL, NULL, NULL, 'pl');

-- --------------------------------------------------------

--
-- Structure de la table `faculte`
--

DROP TABLE IF EXISTS `faculte`;
CREATE TABLE IF NOT EXISTS `faculte` (
  `idfaculte` int(11) NOT NULL AUTO_INCREMENT,
  `iduniversite` int(11) NOT NULL,
  `nomFaculte` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idfaculte`),
  KEY `fk_faculte_universite1_idx` (`iduniversite`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `faculte`
--

INSERT INTO `faculte` (`idfaculte`, `iduniversite`, `nomFaculte`) VALUES
(4, 1, 'Droit'),
(5, 1, 'Medecin'),
(6, 1, 'Economie'),
(7, 1, 'Chimie'),
(8, 1, 'Good'),
(9, 2, 'Informatique'),
(10, 1, 'SEDI'),
(11, 1, 'Geologie'),
(12, 2, 'ff'),
(13, 2, 'fff');

-- --------------------------------------------------------

--
-- Structure de la table `frais`
--

DROP TABLE IF EXISTS `frais`;
CREATE TABLE IF NOT EXISTS `frais` (
  `idfrais` int(11) NOT NULL AUTO_INCREMENT,
  `idanneeAcademique` int(11) NOT NULL,
  `iddevise` int(11) NOT NULL,
  `idbanque` int(11) NOT NULL,
  `iduniversite` int(11) NOT NULL,
  `designation` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `numeroCompte` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `montant` double DEFAULT NULL,
  PRIMARY KEY (`idfrais`),
  KEY `fk_frais_devise1_idx` (`iddevise`),
  KEY `fk_frais_universite1_idx` (`iduniversite`),
  KEY `fk_frais_banque1_idx` (`idbanque`),
  KEY `fk_frais_anneeAcademique1_idx` (`idanneeAcademique`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `frais`
--

INSERT INTO `frais` (`idfrais`, `idanneeAcademique`, `iddevise`, `idbanque`, `iduniversite`, `designation`, `numeroCompte`, `montant`) VALUES
(2, 13, 4, 1, 1, 'mi session', '123456789-55', 2000),
(3, 13, 1, 1, 1, 'Session	', '123456789-55', 250),
(4, 13, 1, 1, 1, 'consommation', '1221-0001-0101', 200),
(5, 13, 1, 1, 1, 'minerval', '123456789-55', 2000),
(6, 13, 1, 1, 1, 'deplacement', '123456789-55', 3000),
(7, 13, 1, 1, 1, 'carte', '123456789-55', 43),
(8, 13, 4, 1, 1, 'minerval', '123456789-55', 12304),
(9, 13, 4, 1, 1, 'concours', '88888', 100000),
(10, 13, 1, 1, 1, 'Minerval', '123456789-55', 20),
(11, 13, 1, 1, 1, 'Minerval', '123456789-55', 20),
(12, 13, 4, 1, 1, 'deplacement 2', '123456789-55', 800),
(13, 13, 1, 1, 1, 'Session	', '123456789-55', 10),
(16, 13, 1, 2, 1, 'all', '123456789-55', 100),
(20, 18, 1, 1, 3, 'minerval', 'all of fame', 12304),
(21, 14, 1, 1, 2, 'Minerval', '15130-01003833000-20', 20),
(22, 14, 1, 1, 2, 'emmenagement', '134232-6789-001', 100);

-- --------------------------------------------------------

--
-- Structure de la table `frais_ecole`
--

DROP TABLE IF EXISTS `frais_ecole`;
CREATE TABLE IF NOT EXISTS `frais_ecole` (
  `idfrais_ecole` int(11) NOT NULL AUTO_INCREMENT,
  `intitulefrais` varchar(45) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `iddevise` int(11) NOT NULL,
  PRIMARY KEY (`idfrais_ecole`),
  KEY `fk_frais_ecole_devise1_idx` (`iddevise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `operateur`
--

DROP TABLE IF EXISTS `operateur`;
CREATE TABLE IF NOT EXISTS `operateur` (
  `idoperateur` int(11) NOT NULL AUTO_INCREMENT,
  `nomOperateur` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`idoperateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `operateur`
--

INSERT INTO `operateur` (`idoperateur`, `nomOperateur`, `image`) VALUES
(1, 'airtel', 'assets/images/airtel.png'),
(2, 'rawbank', 'assets/images/paypal.png');

-- --------------------------------------------------------

--
-- Structure de la table `optionecole`
--

DROP TABLE IF EXISTS `optionecole`;
CREATE TABLE IF NOT EXISTS `optionecole` (
  `idoptionecole` int(11) NOT NULL AUTO_INCREMENT,
  `intituleOption` varchar(45) DEFAULT NULL,
  `section_idsection` int(11) NOT NULL,
  PRIMARY KEY (`idoptionecole`,`section_idsection`),
  KEY `fk_optionecole_section1_idx` (`section_idsection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `idoptions` int(11) NOT NULL AUTO_INCREMENT,
  `intituleOptions` varchar(100) DEFAULT NULL,
  `idfaculte` int(11) NOT NULL,
  `idpromotion` int(11) NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idoptions`),
  KEY `fk_options_faculte1_idx` (`idfaculte`),
  KEY `fk_options_promotion1_idx` (`idpromotion`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`idoptions`, `intituleOptions`, `idfaculte`, `idpromotion`, `dateCreation`) VALUES
(2, 'Droit civique', 4, 4, '2021-05-28 17:18:33'),
(3, 'Droit civique', 4, 4, '2021-05-28 17:18:58'),
(4, 'Droit civique', 4, 5, '2021-05-28 17:18:58'),
(5, 'Droit civique', 4, 6, '2021-05-28 17:18:59'),
(6, 'Droit civique', 5, 4, '2021-05-28 17:21:28'),
(7, 'Droit civique', 5, 5, '2021-05-28 17:21:29'),
(8, 'Droit civique', 5, 4, '2021-05-28 17:21:29'),
(9, 'Droit civique', 5, 6, '2021-05-28 17:21:30'),
(10, 'Droit International Prive', 5, 4, '2021-05-28 17:21:30'),
(11, 'Droit International Prive', 5, 5, '2021-05-28 17:21:30'),
(12, 'Droit International Prive', 5, 4, '2021-05-28 17:21:30'),
(13, 'Droit International Prive', 5, 6, '2021-05-28 17:21:30'),
(14, 'medecine generale', 5, 4, '2021-05-28 17:21:30'),
(15, 'Medecine app', 5, 5, '2021-05-28 17:21:31'),
(16, 'Droit civique', 5, 4, '2021-05-28 17:21:31'),
(17, 'Medecine Laboratoire', 5, 6, '2021-05-28 17:21:31'),
(18, 'Droit International Prive', 5, 4, '2021-05-28 17:21:31'),
(19, 'Droit International Prive', 5, 5, '2021-05-28 17:21:31'),
(20, 'Droit International Prive', 5, 4, '2021-05-28 17:21:32'),
(21, 'Droit International Prive', 5, 6, '2021-05-28 17:21:32'),
(22, 'Droit civique', 5, 4, '2021-05-28 17:25:33'),
(23, 'Droit civique', 5, 5, '2021-05-28 17:25:33'),
(24, 'Droit civique', 5, 4, '2021-05-28 17:25:34'),
(25, 'Droit civique', 5, 6, '2021-05-28 17:25:34'),
(26, 'Droit International Prive', 5, 4, '2021-05-28 17:25:34'),
(27, 'Droit International Prive', 5, 5, '2021-05-28 17:25:34'),
(28, 'Droit International Prive', 5, 4, '2021-05-28 17:25:34'),
(29, 'Droit International Prive', 5, 6, '2021-05-28 17:25:35'),
(30, 'Industrielle', 7, 13, '2021-05-28 17:27:23'),
(31, 'Industrielle', 7, 14, '2021-05-28 17:27:24'),
(32, 'Ondulatoire', 7, 13, '2021-05-28 17:27:24'),
(33, 'Ondulatoire', 7, 14, '2021-05-28 17:27:24'),
(34, 'Industrielle', 7, 13, '2021-05-28 17:29:19'),
(35, 'Industrielle', 7, 14, '2021-05-28 17:29:19'),
(36, 'Ondulatoire', 7, 13, '2021-05-28 17:29:20'),
(37, 'Ondulatoire', 7, 14, '2021-05-28 17:29:20'),
(38, 'MSI', 9, 17, '2021-05-31 11:45:41'),
(39, 'MSI', 9, 18, '2021-05-31 11:45:42'),
(40, 'Genie Logiciel', 9, 17, '2021-05-31 11:45:42'),
(41, 'Genie Logiciel', 9, 18, '2021-05-31 11:45:42'),
(42, 'Reseau Informatique', 9, 17, '2021-05-31 11:45:42'),
(43, 'Reseau Informatique', 9, 18, '2021-05-31 11:45:43'),
(44, 'opt L1 L2', 9, 16, '2021-06-28 07:36:54'),
(45, 'opt L1 L2', 9, 17, '2021-06-28 07:36:54');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `idpaiement` int(11) NOT NULL AUTO_INCREMENT,
  `iddevise` int(11) NOT NULL,
  `idfrais` int(11) NOT NULL,
  `idanneeAcademique` int(11) NOT NULL,
  `idetudiant` int(11) NOT NULL,
  `montant` double DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `operateur` text NOT NULL,
  `nomOperateur` text NOT NULL,
  `commission` double NOT NULL,
  `montantTotal` double NOT NULL,
  `codeQr` text NOT NULL,
  `typeOperation` text NOT NULL,
  PRIMARY KEY (`idpaiement`),
  KEY `fk_paiement_devise1_idx` (`iddevise`),
  KEY `fk_paiement_frais1_idx` (`idfrais`),
  KEY `fk_paiement_etudiant1_idx` (`idetudiant`),
  KEY `fk_paiement_anneeAcademique1_idx` (`idanneeAcademique`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`idpaiement`, `iddevise`, `idfrais`, `idanneeAcademique`, `idetudiant`, `montant`, `date`, `operateur`, `nomOperateur`, `commission`, `montantTotal`, `codeQr`, `typeOperation`) VALUES
(34, 1, 4, 13, 8, 10, '2021-07-25 18:48:48', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-02-21-18-48-48.png', 'Paiement effectue'),
(36, 1, 4, 13, 8, 80, '2021-06-03 02:02:07', 'assets/images/bangulogo.png', 'mbangu', 0.4, 80.4, 'qrcode-06-03-21-02-02-07.png', 'Paiement effectue'),
(37, 1, 4, 13, 8, 1, '2021-06-03 02:02:33', 'assets/images/bangulogo.png', 'mbangu', 0.005, 1.005, 'qrcode-06-03-21-02-02-33.png', 'Paiement effectue'),
(38, 1, 4, 13, 8, 9, '2021-06-03 12:47:46', 'assets/images/bangulogo.png', 'mbangu', 0.045, 9.045, 'qrcode-06-03-21-12-47-46.png', 'Paiement effectue'),
(43, 1, 3, 13, 8, 10, '2021-06-03 15:53:22', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-03-21-15-53-22.png', 'Paiement effectue'),
(44, 4, 2, 13, 8, 10, '2021-07-25 15:53:47', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-03-21-15-53-47.png', 'Paiement effectue'),
(45, 1, 3, 13, 11, 200, '2021-06-25 00:00:00', 'assets/images/bangulogo.png', 'mbangu', 1, 201, 'qrcode-06-04-21-15-39-14.png', 'Paiement effectue'),
(46, 1, 3, 13, 11, 30, '2021-06-04 15:40:01', 'assets/images/bangulogo.png', 'mbangu', 0.15, 30.15, 'qrcode-06-04-21-15-40-01.png', 'Paiement effectue'),
(48, 1, 3, 13, 8, 100, '2021-06-04 17:49:48', 'assets/images/bangulogo.png', 'mbangu', 0.5, 100.5, 'qrcode-06-04-21-17-49-48.png', 'Paiement effectue'),
(49, 1, 3, 13, 8, 10, '2021-06-04 17:50:11', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-04-21-17-50-11.png', 'Paiement effectue'),
(50, 1, 4, 13, 8, 100, '2021-06-04 17:54:05', 'assets/images/bangulogo.png', 'mbangu', 0.5, 100.5, 'qrcode-06-04-21-17-54-05.png', 'Paiement effectue'),
(51, 1, 4, 13, 11, 80, '2021-06-05 23:02:23', 'assets/images/bangulogo.png', 'mbangu', 0.4, 80.4, 'qrcode-06-05-21-23-02-23.png', 'Paiement effectue'),
(52, 1, 4, 13, 11, 100, '2021-06-06 00:06:55', 'assets/images/bangulogo.png', 'mbangu', 0.5, 100.5, 'qrcode-06-06-21-00-06-55.png', 'Paiement effectue'),
(53, 4, 2, 13, 11, 100, '2021-06-06 00:07:21', 'assets/images/bangulogo.png', 'mbangu', 0.5, 100.5, 'qrcode-06-06-21-00-07-21.png', 'Paiement effectue'),
(54, 1, 3, 13, 16, 1.5, '2021-06-07 09:56:05', 'assets/images/bangulogo.png', 'mbangu', 0.0075, 1.5075, 'qrcode-06-07-21-09-56-05.png', 'Paiement effectue'),
(55, 1, 3, 13, 16, 98, '2021-06-07 10:23:49', 'assets/images/bangulogo.png', 'mbangu', 0.49, 98.49, 'qrcode-06-07-21-10-23-49.png', 'Paiement effectue'),
(56, 4, 2, 13, 16, 1000, '2021-06-07 10:38:37', 'assets/images/bangulogo.png', 'mbangu', 5, 1005, 'qrcode-06-07-21-10-38-37.png', 'Paiement effectue'),
(57, 4, 2, 13, 12, 10, '2021-06-11 12:49:48', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-11-21-12-49-48.png', 'Paiement effectue'),
(58, 4, 2, 13, 8, 100, '2021-06-12 03:17:41', 'assets/images/bangulogo.png', 'mbangu', 0.5, 100.5, 'qrcode-06-12-21-03-17-40.png', 'Paiement effectue'),
(59, 4, 9, 13, 8, 1000, '2021-06-12 03:18:10', 'assets/images/bangulogo.png', 'mbangu', 5, 1005, 'qrcode-06-12-21-03-18-10.png', 'Paiement effectue'),
(60, 4, 2, 13, 12, 10, '2021-06-12 03:19:52', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-12-21-03-19-52.png', 'Paiement effectue'),
(61, 1, 10, 13, 12, 10, '2021-06-12 03:20:37', 'assets/images/bangulogo.png', 'mbangu', 0.05, 10.05, 'qrcode-06-12-21-03-20-37.png', 'Paiement effectue'),
(62, 4, 9, 13, 12, 50, '2021-06-12 03:21:08', 'assets/images/bangulogo.png', 'mbangu', 0.25, 50.25, 'qrcode-06-12-21-03-21-08.png', 'Paiement effectue'),
(63, 4, 8, 13, 8, 100, '2021-06-12 03:31:33', 'assets/images/bangulogo.png', 'mbangu', 0.5, 100.5, 'qrcode-06-12-21-03-31-33.png', 'Paiement effectue'),
(64, 4, 8, 13, 8, 20, '2021-06-23 09:43:03', 'assets/images/bangulogo.png', 'mbangu', 0.1, 20.1, 'qrcode-06-23-21-09-43-03.png', 'Paiement effectue'),
(65, 4, 2, 13, 8, 0.9, '2021-06-24 09:52:48', 'assets/images/bangulogo.png', 'mbangu', 0.0045000000000000005, 0.9045, 'qrcode-06-24-21-09-52-48.png', 'Paiement effectue');

-- --------------------------------------------------------

--
-- Structure de la table `paiement_ecole`
--

DROP TABLE IF EXISTS `paiement_ecole`;
CREATE TABLE IF NOT EXISTS `paiement_ecole` (
  `idpaiement_ecole` int(11) NOT NULL AUTO_INCREMENT,
  `date_paiement` varchar(45) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `montantTot` double DEFAULT NULL,
  `eleve_ideleve` int(11) NOT NULL,
  `frais_ecole_idfrais_ecole` int(11) NOT NULL,
  PRIMARY KEY (`idpaiement_ecole`),
  KEY `fk_paiement_ecole_eleve1_idx` (`eleve_ideleve`),
  KEY `fk_paiement_ecole_frais_ecole1_idx` (`frais_ecole_idfrais_ecole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `paiement_syllabus`
--

DROP TABLE IF EXISTS `paiement_syllabus`;
CREATE TABLE IF NOT EXISTS `paiement_syllabus` (
  `idpaiement_syllabus` int(11) NOT NULL AUTO_INCREMENT,
  `idsyllabus` int(11) NOT NULL,
  `idetudiant` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`idpaiement_syllabus`),
  KEY `fk_paiement_syllabus_syllabus1_idx` (`idsyllabus`),
  KEY `fk_paiement_syllabus_etudiant1_idx` (`idetudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parent`
--

DROP TABLE IF EXISTS `parent`;
CREATE TABLE IF NOT EXISTS `parent` (
  `idparent` int(11) NOT NULL AUTO_INCREMENT,
  `nomcomplet` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` text,
  `adresse` varchar(45) DEFAULT NULL,
  `idpiece` int(11) NOT NULL,
  PRIMARY KEY (`idparent`),
  KEY `fk_parent_pieceidentite1_idx` (`idpiece`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parent_has_eleve`
--

DROP TABLE IF EXISTS `parent_has_eleve`;
CREATE TABLE IF NOT EXISTS `parent_has_eleve` (
  `idparent` int(11) NOT NULL,
  `ideleve` int(11) NOT NULL,
  PRIMARY KEY (`idparent`,`ideleve`),
  KEY `fk_parent_has_eleve_eleve1_idx` (`ideleve`),
  KEY `fk_parent_has_eleve_parent1_idx` (`idparent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parent_has_etudiant`
--

DROP TABLE IF EXISTS `parent_has_etudiant`;
CREATE TABLE IF NOT EXISTS `parent_has_etudiant` (
  `idparent` int(11) NOT NULL,
  `idetudiant` int(11) NOT NULL,
  PRIMARY KEY (`idparent`,`idetudiant`),
  KEY `fk_parent_has_etudiant_etudiant1_idx` (`idetudiant`),
  KEY `fk_parent_has_etudiant_parent1_idx` (`idparent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pieceidentite`
--

DROP TABLE IF EXISTS `pieceidentite`;
CREATE TABLE IF NOT EXISTS `pieceidentite` (
  `idpiece` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpiece`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `idprofesseur` int(11) NOT NULL AUTO_INCREMENT,
  `idanneeAcademique` int(11) NOT NULL,
  `iduniversite` int(11) NOT NULL,
  `nom` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `prenom` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `postnom` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `login` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`idprofesseur`),
  KEY `fk_professeur_universite1_idx` (`iduniversite`),
  KEY `fk_professeur_anneeAcademique1_idx` (`idanneeAcademique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `idpromotion` int(11) NOT NULL AUTO_INCREMENT,
  `iduniversite` int(11) NOT NULL,
  `intitulePromotion` varchar(100) DEFAULT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpromotion`),
  KEY `fk_promotion_universite1_idx` (`iduniversite`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`idpromotion`, `iduniversite`, `intitulePromotion`, `dateCreation`) VALUES
(4, 1, 'G1', '2021-05-28 15:14:42'),
(5, 1, 'G2', '2021-05-28 15:14:42'),
(6, 1, 'G3', '2021-05-28 15:14:43'),
(7, 1, 'G1', '2021-05-28 15:16:37'),
(8, 1, 'G2', '2021-05-28 15:16:37'),
(9, 1, 'G3', '2021-05-28 15:16:37'),
(10, 1, 'Master1', '2021-05-28 15:24:37'),
(11, 1, 'Master2', '2021-05-28 15:24:37'),
(12, 1, 'Good', '2021-05-28 17:26:11'),
(13, 1, 'l5', '2021-05-28 17:26:46'),
(14, 1, 'l6', '2021-05-28 17:26:46'),
(15, 2, 'Prepa', '2021-05-31 11:44:42'),
(16, 2, 'L1', '2021-05-31 11:44:43'),
(17, 2, 'L2', '2021-05-31 11:44:43'),
(18, 2, 'L3', '2021-05-31 11:44:43'),
(19, 1, 'G1', '2021-06-07 13:31:03'),
(20, 1, 'G1', '2021-06-07 13:39:55'),
(21, 1, 'master3', '2021-06-08 19:29:26');

-- --------------------------------------------------------

--
-- Structure de la table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `idprovince` int(11) NOT NULL AUTO_INCREMENT,
  `nomProvince` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idprovince`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `province`
--

INSERT INTO `province` (`idprovince`, `nomProvince`) VALUES
(1, 'Haut-Katanga'),
(2, '1'),
(3, '2'),
(4, '3'),
(5, '4'),
(6, 'Lwalaba'),
(7, 'HAut-Lomamie'),
(8, 'Uele'),
(9, 'Kinshasa'),
(10, 'Matadi'),
(11, 'kindu'),
(12, 'Kilwa');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `idsection` int(11) NOT NULL AUTO_INCREMENT,
  `intitulesection` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idsection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `syllabus`
--

DROP TABLE IF EXISTS `syllabus`;
CREATE TABLE IF NOT EXISTS `syllabus` (
  `idsyllabus` int(11) NOT NULL AUTO_INCREMENT,
  `idpromotion` int(11) NOT NULL,
  `iddevise` int(11) NOT NULL,
  `idprofesseur` int(11) NOT NULL,
  `fichier` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `titre` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `prix` double DEFAULT NULL,
  PRIMARY KEY (`idsyllabus`),
  KEY `fk_syllabus_devise1_idx` (`iddevise`),
  KEY `fk_syllabus_professeur1_idx` (`idprofesseur`),
  KEY `fk_syllabus_promotion1_idx` (`idpromotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tempo`
--

DROP TABLE IF EXISTS `tempo`;
CREATE TABLE IF NOT EXISTS `tempo` (
  `idTemp` int(11) NOT NULL AUTO_INCREMENT,
  `matricule` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `state` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `reseau` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `dateTemp` datetime DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`idTemp`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tempo`
--

INSERT INTO `tempo` (`idTemp`, `matricule`, `state`, `montant`, `reseau`, `dateTemp`, `message`) VALUES
(1, '12kk12', 'null', 100, 'airtel', '2021-06-16 10:48:54', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `universite`
--

DROP TABLE IF EXISTS `universite`;
CREATE TABLE IF NOT EXISTS `universite` (
  `iduniversite` int(11) NOT NULL AUTO_INCREMENT,
  `nomUniversite` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `code` text CHARACTER SET utf8mb4,
  `login` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `logo` text,
  PRIMARY KEY (`iduniversite`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `universite`
--

INSERT INTO `universite` (`iduniversite`, `nomUniversite`, `code`, `login`, `logo`) VALUES
(1, 'UNILU', '445566', 'adunilu', 'upload/logo/l.png'),
(2, 'ESISALAMA', '445566', 'adesis', 'upload/logo/1625132966701.PNG'),
(3, 'Michigan', '0000', 'admich', ''),
(4, 'MiamiSchool', 'Miamia', 'ad', '');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `idville` int(11) NOT NULL AUTO_INCREMENT,
  `idprovince` int(11) NOT NULL,
  `nomVille` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idville`),
  KEY `fk_ville_province1_idx` (`idprovince`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`idville`, `idprovince`, `nomVille`) VALUES
(1, 1, 'lubumbashi'),
(2, 1, 'L\'shi'),
(3, 1, 'Likasi'),
(4, 1, 'Kolwezi'),
(5, 1, 'L\'shi'),
(6, 1, 'Likasi'),
(7, 1, 'Kolwezi'),
(8, 2, 'Good'),
(9, 2, 'Burger'),
(10, 2, 'Good'),
(11, 2, 'Burger'),
(12, 3, 'All'),
(13, 3, 'Too'),
(14, 3, 'All'),
(15, 3, 'Too'),
(16, 3, 'All'),
(17, 3, 'Too'),
(18, 3, 'All'),
(19, 3, 'Too'),
(20, 3, 'All'),
(21, 3, 'Too'),
(22, 5, 'googling'),
(23, 5, 'googling'),
(24, 5, 'googling'),
(25, 5, 'googling'),
(26, 4, 'L\'shi'),
(27, 1, 'Kasubalesa'),
(28, 1, 'Lubumbashi'),
(29, 1, 'Likasi'),
(30, 1, 'Kolwezi'),
(31, 11, 'maniema'),
(32, 12, 'Good'),
(33, 12, 'L\'shi'),
(34, 12, 'maniema');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `anneeacademique`
--
ALTER TABLE `anneeacademique`
  ADD CONSTRAINT `fk_anneeAcademique_universite1` FOREIGN KEY (`iduniversite`) REFERENCES `universite` (`iduniversite`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `annee_scolaire_ecole`
--
ALTER TABLE `annee_scolaire_ecole`
  ADD CONSTRAINT `fk_annee_scolaire_ecole_ecole1` FOREIGN KEY (`idecole`) REFERENCES `ecole` (`idecole`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `appro`
--
ALTER TABLE `appro`
  ADD CONSTRAINT `fk_appro_devise1` FOREIGN KEY (`iddevise`) REFERENCES `devise` (`iddevise`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appro_etudiant1` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_appro_operateur1` FOREIGN KEY (`idoperateur`) REFERENCES `operateur` (`idoperateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `fk_classe_annee_scolaire_ecole1` FOREIGN KEY (`idannee_scolaire_ecole`) REFERENCES `annee_scolaire_ecole` (`idannee_scolaire_ecole`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_classe_optionecole1` FOREIGN KEY (`idoptionecole`) REFERENCES `optionecole` (`idoptionecole`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `fk_eleve_classe1` FOREIGN KEY (`idclasse`) REFERENCES `classe` (`idclasse`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `fk_etudiant_anneeAcademique1` FOREIGN KEY (`idanneeAcademique`) REFERENCES `anneeacademique` (`idanneeAcademique`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etudiant_promotion1` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etudiant_ville1` FOREIGN KEY (`idville`) REFERENCES `ville` (`idville`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `faculte`
--
ALTER TABLE `faculte`
  ADD CONSTRAINT `fk_faculte_universite1` FOREIGN KEY (`iduniversite`) REFERENCES `universite` (`iduniversite`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `frais`
--
ALTER TABLE `frais`
  ADD CONSTRAINT `fk_frais_anneeAcademique1` FOREIGN KEY (`idanneeAcademique`) REFERENCES `anneeacademique` (`idanneeAcademique`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_frais_banque1` FOREIGN KEY (`idbanque`) REFERENCES `banque` (`idbanque`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_frais_devise1` FOREIGN KEY (`iddevise`) REFERENCES `devise` (`iddevise`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_frais_universite1` FOREIGN KEY (`iduniversite`) REFERENCES `universite` (`iduniversite`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `frais_ecole`
--
ALTER TABLE `frais_ecole`
  ADD CONSTRAINT `fk_frais_ecole_devise1` FOREIGN KEY (`iddevise`) REFERENCES `devise` (`iddevise`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `optionecole`
--
ALTER TABLE `optionecole`
  ADD CONSTRAINT `fk_optionecole_section1` FOREIGN KEY (`section_idsection`) REFERENCES `section` (`idsection`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `fk_options_faculte1` FOREIGN KEY (`idfaculte`) REFERENCES `faculte` (`idfaculte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_options_promotion1` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `fk_paiement_anneeAcademique1` FOREIGN KEY (`idanneeAcademique`) REFERENCES `anneeacademique` (`idanneeAcademique`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paiement_devise1` FOREIGN KEY (`iddevise`) REFERENCES `devise` (`iddevise`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paiement_etudiant1` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paiement_frais1` FOREIGN KEY (`idfrais`) REFERENCES `frais` (`idfrais`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `paiement_ecole`
--
ALTER TABLE `paiement_ecole`
  ADD CONSTRAINT `fk_paiement_ecole_eleve1` FOREIGN KEY (`eleve_ideleve`) REFERENCES `eleve` (`ideleve`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paiement_ecole_frais_ecole1` FOREIGN KEY (`frais_ecole_idfrais_ecole`) REFERENCES `frais_ecole` (`idfrais_ecole`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `paiement_syllabus`
--
ALTER TABLE `paiement_syllabus`
  ADD CONSTRAINT `fk_paiement_syllabus_etudiant1` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paiement_syllabus_syllabus1` FOREIGN KEY (`idsyllabus`) REFERENCES `syllabus` (`idsyllabus`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `fk_parent_pieceidentite1` FOREIGN KEY (`idpiece`) REFERENCES `pieceidentite` (`idpiece`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `parent_has_eleve`
--
ALTER TABLE `parent_has_eleve`
  ADD CONSTRAINT `fk_parent_has_eleve_eleve1` FOREIGN KEY (`ideleve`) REFERENCES `eleve` (`ideleve`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_parent_has_eleve_parent1` FOREIGN KEY (`idparent`) REFERENCES `parent` (`idparent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `parent_has_etudiant`
--
ALTER TABLE `parent_has_etudiant`
  ADD CONSTRAINT `fk_parent_has_etudiant_etudiant1` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_parent_has_etudiant_parent1` FOREIGN KEY (`idparent`) REFERENCES `parent` (`idparent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `fk_professeur_anneeAcademique1` FOREIGN KEY (`idanneeAcademique`) REFERENCES `anneeacademique` (`idanneeAcademique`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_professeur_universite1` FOREIGN KEY (`iduniversite`) REFERENCES `universite` (`iduniversite`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `fk_promotion_universite1` FOREIGN KEY (`iduniversite`) REFERENCES `universite` (`iduniversite`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `syllabus`
--
ALTER TABLE `syllabus`
  ADD CONSTRAINT `fk_syllabus_devise1` FOREIGN KEY (`iddevise`) REFERENCES `devise` (`iddevise`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_syllabus_professeur1` FOREIGN KEY (`idprofesseur`) REFERENCES `professeur` (`idprofesseur`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_syllabus_promotion1` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `fk_ville_province1` FOREIGN KEY (`idprovince`) REFERENCES `province` (`idprovince`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
