-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 05 mai 2021 à 11:28
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ebanking`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nomComplet` varchar(60) NOT NULL,
  `login` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nomComplet`, `login`, `password`) VALUES
(2, 'jesus kazembe', 'jesus', 'Jesus'),
(4, 'jesus kazembe', 'admin@admin', '@dm!n'),
(5, 'jesus kazembe', 'admin@admin', '@dm!n'),
(6, '', 'Bonjour', ''),
(7, '', 'l1', ''),
(8, '', 'l2', ''),
(9, '', 'l3', ''),
(10, '', 'l4', '');

-- --------------------------------------------------------

--
-- Structure de la table `appro`
--

CREATE TABLE `appro` (
  `idAppro` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `montant` int(11) NOT NULL,
  `dateAppro` varchar(100) NOT NULL,
  `solde` int(11) NOT NULL,
  `operateur` varchar(100) NOT NULL,
  `nomOperateur` varchar(100) NOT NULL,
  `devise` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `appro`
--

INSERT INTO `appro` (`idAppro`, `matricule`, `montant`, `dateAppro`, `solde`, `operateur`, `nomOperateur`, `devise`) VALUES
(198, 'test007', 8000, '04/02/21-13:25:53', 8000, '', '', ''),
(199, 'test007', 1200, '04/02/21-15:25:39', 9200, '', '', ''),
(200, 'test007', 500, '04/02/21-15:28:01', 9700, '', '', ''),
(201, 'test007', 80, '04/02/21-23:16:46', 4780, '', '', ''),
(202, 'test007', 150000, '04/02/21-23:34:36', 154780, '', '', ''),
(203, 'test007', 15000008, '04/02/21-23:39:08', 15154788, '', '', ''),
(204, 'test007', 100, '04/02/21-23:59:30', 15154888, '', '', ''),
(205, 'test007', 120000000, '04/03/21-00:21:20', 135154888, '', '', ''),
(206, 'test007', 120, '04/03/21-00:53:50', 135155008, '', '', ''),
(207, 'test007', 120, '04/07/21-00:46:29', 134689895, '', '', ''),
(208, '12kk12', 120, '04/09/21-03:39:01', 121, '', '', ''),
(209, '12kk12', 10, '2021-04-13 01:33:35', 118, '', '', ''),
(210, '12kk12', 10, '2021-04-13 01:42:30', 128, '', '', ''),
(211, '12kk12', 120, '2021-04-13 01:44:31', 248, '', '', ''),
(212, '12kk12', 100, '2021-04-13 01:52:54', 235, '', '', ''),
(213, '12kk12', 10, '2021-04-13 01:57:17', 245, '', '', ''),
(214, '12kk12', 10, '2021-04-13 01:57:29', 255, '', '', ''),
(215, '12kk12', 1, '2021-04-13 01:59:02', 256, '', '', ''),
(216, '12kk12', 100, '2021-04-13 02:00:18', 356, '', '', ''),
(217, '12kk12', 1, '2021-04-13 02:01:46', 357, '', '', ''),
(218, '12kk12', 1, '2021-04-13 02:05:20', 358, '', '', ''),
(219, '12kk12', 1, '2021-04-13 02:06:07', 359, '', '', ''),
(220, '12kk12', 1, '2021-04-13 02:08:38', 360, '', '', ''),
(221, '12kk12', 10, '2021-04-13 02:08:52', 370, '', '', ''),
(222, '12kk12', 100, '2021-04-16 15:11:15', 330, '', '', ''),
(223, '12kk12', 140, '2021-04-16 15:11:23', 470, '', '', ''),
(224, '12kk12', 10, '2021-04-16 16:29:15', 480, '', '', ''),
(225, '12kk12', 10, '2021-04-16 16:41:31', 490, '', '', ''),
(226, '12kk12', 40, '2021-04-16 16:42:14', 530, '', '', ''),
(227, '12kk12', 12, '2021-04-16 16:42:56', 542, '', '', ''),
(228, '12kk12', 120, '2021-04-16 16:45:17', 662, '', '', ''),
(229, '12kk12', 50, '2021-04-16 16:45:34', 712, '', '', ''),
(230, '12kk12', 12, '2021-04-16 16:46:02', 724, '', '', ''),
(231, '12kk12', 70, '2021-04-16 16:58:24', 794, '', '', ''),
(232, '12kk12', 120, '2021-04-17 23:24:06', 914, '', '', ''),
(233, '12ll12', 700, '2021-04-19 02:17:53', 700, '', '', ''),
(234, '12ll12', 1800, '2021-04-19 02:35:54', 2000, '', '', ''),
(235, '12kk12', 20, '2021-04-19 12:33:51', 934, '', '', ''),
(236, 'UN001', 120, '2021-04-20 01:06:46', 120, '', '', ''),
(237, '12kk12', 1200, '2021-04-24 23:25:33', 2134, '', '', ''),
(238, '12kk12', 500, '2021-04-24 23:25:53', 2634, '', '', ''),
(239, '23kk23', 200, '2021-04-25 20:41:59', 200, '', '', ''),
(240, '12kk12', 4000, '2021-04-27 19:41:01', 4074, '', '', ''),
(241, '12kk12', 100, '2021-04-28 12:25:09', 4174, '', '', ''),
(242, '12kk12', 100, '2021-04-28 12:28:26', 100, '', '', ''),
(243, '12kk12', 100, '2021-04-28 12:35:19', 100, '', '', ''),
(244, '12kk12', 100, '2021-04-28 12:35:36', 200, '', '', ''),
(245, '12kk12', 100, '2021-04-28 12:35:49', 300, '', '', ''),
(246, '12kk12', 200, '2021-04-28 12:47:17', 500, '', '', ''),
(247, '12kk12', 500, '2021-04-28 12:48:59', 1000, '', '', ''),
(248, '12kk12', 500, '2021-04-28 12:51:02', 500, '', '', ''),
(249, 'UN001', 100, '2021-04-28 13:55:13', 100, '', '', ''),
(250, '12kk12', 300, '2021-04-28 18:58:50', 300, '', '', ''),
(251, '12kk12', 50, '2021-04-28 19:48:42', 140, '', '', ''),
(252, '12kk12', 50, '2021-04-28 19:48:54', 190, '', '', ''),
(253, '12kk12', 100, '2021-05-03 17:11:12', 101, '', '', ''),
(254, 'UN0012', 1000, '2021-05-05 05:53:33', 1000, '', '', ''),
(255, 'UN0012', 100, '2021-05-05 10:14:40', 1020, '', '', ''),
(256, 'UN0012', 100, '2021-05-05 10:14:53', 1120, '', '', ''),
(257, '12kk12', 100, '2021-05-05 10:58:02', 100, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `approcdf`
--

CREATE TABLE `approcdf` (
  `id` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `dateAppro` datetime NOT NULL,
  `operateur` varchar(100) NOT NULL,
  `nomOperateur` varchar(100) NOT NULL,
  `solde` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `approcdf`
--

INSERT INTO `approcdf` (`id`, `matricule`, `montant`, `dateAppro`, `operateur`, `nomOperateur`, `solde`) VALUES
(1, '12kk12', 300, '2021-04-18 02:34:59', '', '', 300),
(2, '12kk12', 300, '2021-04-18 02:36:12', '', '', 300),
(3, '13kk12', 300, '2021-04-18 02:40:26', '', '', 300),
(4, '13kk12', 300, '2021-04-18 02:40:28', '', '', 600),
(5, '13kk12', 300, '2021-04-18 02:40:30', '', '', 900),
(6, '13kk12', 300, '2021-04-18 02:40:38', '', '', 1200),
(7, '13kk12', 300, '2021-04-18 02:40:51', '', '', 1500),
(8, '12kk12', 300.6, '2021-04-18 02:44:21', '', '', 300.6),
(9, '12kk12', 600, '2021-04-18 02:50:01', '', '', 900.6),
(10, '12kk12', 600, '2021-04-18 02:53:02', '', '', 1500.6),
(11, '12kk12', 2000, '2021-04-18 02:54:45', '', '', 3500.6),
(12, '12kk12', 4000, '2021-04-18 02:59:11', '', '', 7500.6),
(13, '12ll12', 1000, '2021-04-19 02:02:19', '', '', 1000),
(14, '12ll12', 100, '2021-04-19 02:30:28', '', '', 1100),
(15, '12ll12', 1900, '2021-04-19 02:34:16', '', '', 3000),
(16, '12kk12', 100, '2021-04-19 12:30:43', '', '', 3200.6),
(17, 'UN001', 100, '2021-04-20 01:01:54', '', '', 100),
(18, 'UN001', 200, '2021-04-20 01:03:34', '', '', 300),
(19, '23kk23', 580, '2021-04-25 20:33:13', '', '', 580),
(20, '12kk12', 1200, '2021-04-25 20:46:19', '', '', 1209.6),
(21, '12kk12', 3000, '2021-04-27 19:13:46', '', '', 3739.6),
(22, '12kk12', 500, '2021-04-27 19:33:37', '', '', 4239.6),
(23, '12kk12', 100, '2021-04-28 12:47:53', '', '', 100),
(24, '12kk12', 500, '2021-04-28 12:48:47', '', '', 600),
(25, '12kk12', 100, '2021-04-28 12:50:48', '', '', 100),
(26, '12kk12', 100, '2021-04-28 12:52:23', '', '', 200),
(27, '12kk12', 100, '2021-04-28 13:06:46', '', '', 100),
(28, 'UN001', 100, '2021-04-28 13:36:27', '', '', 100),
(29, 'UN001', 500, '2021-04-28 13:37:01', '', '', 600),
(30, '12kk12', 250, '2021-04-28 18:58:27', '', '', 350),
(31, '12kk12', 1000, '2021-04-28 19:48:30', '', '', 1038),
(32, '12kk12', 100, '2021-04-28 19:56:31', '', '', 138),
(33, '12kk12', 10000, '2021-04-28 19:56:48', '', '', 10138),
(34, '12kk12', 100, '2021-05-03 17:11:49', '', '', 867),
(35, '12kk12', 100, '2021-05-03 17:12:15', '', '', 967),
(36, '12kk12', 20, '2021-05-03 17:13:24', '', '', 987),
(37, '12kk12', 20, '2021-05-03 17:14:30', '', '', 1007),
(38, '12kk12', 10, '2021-05-05 10:25:01', '', '', 1017),
(39, '12kk12', 10, '2021-05-05 10:31:34', '', '', 10),
(40, '12kk12', 10, '2021-05-05 10:52:33', '', '', 20),
(41, '12kk12', 100, '2021-05-05 10:53:35', '', '', 120),
(42, '12kk12', 10, '2021-05-05 10:57:52', '', '', 130);

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

CREATE TABLE `banque` (
  `idBanque` int(11) NOT NULL,
  `denomination` varchar(60) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `banque`
--

INSERT INTO `banque` (`idBanque`, `denomination`, `login`, `password`) VALUES
(37, 'UBA', 'kins', 'kool'),
(38, 'kernel', 'kernel', 'kool'),
(39, 'mbangu', 'mbangu', 'mbangu');

-- --------------------------------------------------------

--
-- Structure de la table `banqueuniv`
--

CREATE TABLE `banqueuniv` (
  `id` int(11) NOT NULL,
  `idBanque` int(11) NOT NULL,
  `idEcole` int(11) NOT NULL,
  `nomBanque` varchar(60) NOT NULL,
  `nonEcole` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `commission`
--

CREATE TABLE `commission` (
  `id` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `nomUniversite` varchar(100) NOT NULL,
  `montantCommission` float NOT NULL,
  `frais` varchar(100) NOT NULL,
  `montantTot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commission`
--

INSERT INTO `commission` (`id`, `matricule`, `nom`, `nomUniversite`, `montantCommission`, `frais`, `montantTot`) VALUES
(22, '12kk12', 'Jésus', 'kasapa', 0.005, 'buff', 1.005),
(23, 'test007', 'test007', 'kasapa', 750, 'Defense', 150750),
(24, 'test007', 'test007', 'kasapa', 2.5, 'Session', 502.5),
(25, 'test007', 'test007', 'kasapa', 2.6, 'Defense', 522.6),
(26, 'test007', 'test007', 'kasapa', 62.9, 'buff', 12642.9),
(27, 'test007', 'test007', 'kasapa', 6.25, 'Defense', 1256.25),
(28, 'test007', 'test007', 'kasapa', 55.555, 'Defense', 11166.6),
(29, 'test007', 'test007', 'kasapa', 606.06, 'Defense', 121818),
(30, 'test007', 'test007', 'kasapa', 0.6, 'Reparation', 120.6),
(31, 'test007', 'test007', 'kasapa', 606.06, 'Reparation', 121818),
(32, 'test007', 'test007', 'kasapa', 0.6, 'Session', 120.6),
(33, 'test007', 'test007', 'kasapa', 6.045, 'Defense', 1215.05),
(34, 'test007', 'test007', 'kasapa', 62.9, 'Defense', 12642.9),
(35, 'test007', 'test007', 'kasapa', 1.25, 'Reparation', 251.25),
(36, 'test007', 'test007', 'kasapa', 4, 'buff', 804),
(37, '12kk12', 'Jésus', 'kasapa', 0.05, 'Defense', 10.05),
(38, '12kk12', 'Jésus', 'kasapa', 1.04, 'excursion', 10.04),
(39, '12kk12', 'Jésus', 'kasapa', 0.005, 'googling', 1.005),
(40, '12kk12', 'Jésus', 'kasapa', 0.04, 'googling', 8.04),
(41, '12kk12', 'Jésus', 'kasapa', 0.005, 'googling', 1.005),
(42, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(43, '12kk12', 'Jésus', 'kasapa', 0.06, 'googling', 12.06),
(44, '12kk12', 'Jésus', 'kasapa', 0.05, 'primature', 10.05),
(45, '12kk12', 'Jésus', 'kasapa', 0.6, 'googling', 120.6),
(46, '12kk12', 'Jésus', 'kasapa', 0.05, 'googling', 10.05),
(47, '12kk12', 'Jésus', 'kasapa', 2.3, 'excursion', 1.2),
(48, '12ll12', 'kazembe', 'kasapa', 2.5, 'googling', 502.5),
(49, '12kk12', 'Jésus', 'kasapa', 2.3, 'excursion', 1.2),
(50, '12ll12', 'kazembe', 'kasapa', 1, 'googling', 201),
(51, '12ll12', 'kazembe', 'kasapa', 0.5, 'Defense', 100.5),
(52, '12ll12', 'kazembe', 'kasapa', 0.5, 'primature', 100.5),
(53, '12kk12', 'Jésus', 'kasapa', 2.3, 'excursion', 1.2),
(54, '12kk12', 'Jésus', 'kasapa', 2.3, 'excursion', 1.2),
(55, '12ll12', 'kazembe', 'kasapa', 1, 'googling', 201),
(56, '12kk12', 'Jésus', 'kasapa', 2.3, 'excursion', 1.2),
(57, '12kk12', 'Jésus', 'kasapa', 2.3, 'excursion', 1.2),
(58, '12ll12', 'kazembe', 'kasapa', 10, 'googling', 2010),
(59, '12ll12', 'kazembe', 'kasapa', 0.5, 'primature', 100.5),
(60, '12ll12', 'kazembe', 'kasapa', 1, 'googling', 201),
(61, '12kk12', 'Jésus', 'kasapa', 10, 'carte etudiant', 2010),
(62, '12kk12', 'Jésus', 'kasapa', 0.25, 'googling', 50.25),
(63, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(64, '12kk12', 'Jésus', 'kasapa', 2.5, 'googling', 502.5),
(65, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(66, '12kk12', 'Jésus', 'kasapa', 2.2, 'googling', 442.2),
(67, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(68, '12kk12', 'Jésus', 'kasapa', 5, 'googling', 1005),
(69, '12kk12', 'Jésus', 'kasapa', 0.5, 'primature', 100.5),
(70, '12kk12', 'Jésus', 'kasapa', 0.5, 'primature', 100.5),
(71, '12kk12', 'Jésus', 'kasapa', 2.5, 'googling', 502.5),
(72, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(73, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(74, '12kk12', 'Jésus', 'kasapa', 1.5, 'googling', 301.5),
(75, '12kk12', 'Jésus', 'kasapa', 0.5, 'googling', 100.5),
(76, '12kk12', 'Jésus', 'kasapa', 0.005, 'googling', 1.005),
(77, '12kk12', 'Jésus', 'kasapa', 0.6, 'gestion', 120.6),
(78, '12kk12', 'Jésus', 'kasapa', 0.75, 'Defense', 150.75),
(79, '12kk12', 'Jésus', 'kasapa', 0.5, 'Defense', 100.5),
(80, '12kk12', 'Jésus', 'kasapa', 0.5, 'gestion', 100.5),
(81, '12kk12', 'Jésus', 'kasapa', 1, 'gestion', 201),
(82, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(83, '12kk12', 'Jésus', 'kasapa', 2.5, 'cantine', 502.5),
(84, '12kk12', 'Jésus', 'kasapa', 5, 'cantine', 1005),
(85, '12kk12', 'Jésus', 'kasapa', 1.75, 'gestion', 351.75),
(86, '12kk12', 'Jésus', 'kasapa', 0.05, 'gestion', 10.05),
(87, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(88, '12kk12', 'Jésus', 'kasapa', 1, 'cantine', 201),
(89, '12kk12', 'Jésus', 'kasapa', 1, 'session', 201),
(90, '12kk12', 'Jésus', 'kasapa', 0.06, 'session', 12.06),
(91, '12kk12', 'Jésus', 'kasapa', 0.05, 'cantine', 10.05),
(92, '12kk12', 'Jésus', 'kasapa', 5, 'session', 1005),
(93, '12kk12', 'Jésus', 'kasapa', 0.5, 'cantine', 100.5),
(94, '12kk12', 'Jésus', 'kasapa', 0.05, 'cantine', 10.05),
(95, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(96, '12kk12', 'Jésus', 'kasapa', 0.19, 'session', 38.19),
(97, '12kk12', 'Jésus', 'kasapa', 0.94, 'session', 188.94),
(98, '12kk12', 'Jésus', 'kasapa', 5, 'session', 1005),
(99, '12kk12', 'Jésus', 'kasapa', 5, 'session', 1005),
(100, '12kk12', 'Jésus', 'kasapa', 0.05, 'session', 10.05),
(101, '12kk12', 'Jésus', 'kasapa', 0.1, 'session', 20.1),
(102, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(103, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(104, '12kk12', 'Jésus', 'kasapa', 0.05, 'gestion', 10.05),
(105, '12kk12', 'Jésus', 'kasapa', 0.05, 'gestion', 10.05),
(106, '12kk12', 'Jésus', 'kasapa', 0.1, 'gestion', 20.1),
(107, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(108, '12kk12', 'Jésus', 'kasapa', 0.5, 'session', 100.5),
(109, '12kk12', 'Jésus', 'kasapa', 0.05, 'session', 10.05),
(110, '12kk12', 'Jésus', 'kasapa', 0.025, 'session', 5.025),
(111, '12kk12', 'Jésus', 'kasapa', 0.1, 'session', 20.1),
(112, '12kk12', 'Jésus', 'kasapa', 0.005, 'gestion', 1.005),
(113, '12kk12', 'Jésus', 'kasapa', 12.75, 'session', 2562.75),
(114, '12kk12', 'Jésus', 'kasapa', 0.11, 'Defense', 22.11),
(115, '12kk12', 'Jésus', 'kasapa', 20, 'session', 4020),
(116, '12kk12', 'Jésus', 'kasapa', 0.005, 'gestion', 1.005),
(117, '12kk12', 'Jésus', 'kasapa', 0.04, 'syllabus', 5.04),
(118, '12kk12', 'Jésus', 'kasapa', 0.025, 'syllabus', 5.025),
(119, '12kk12', 'Jésus', 'kasapa', 0.025, 'syllabus', 5.025),
(120, '12kk12', 'Jésus', 'kasapa', 0.1, 'syllabus', 20.1),
(121, '12kk12', 'Jésus', 'kasapa', 0.05, 'syllabus', 10.05),
(122, '12kk12', 'Jésus', 'kasapa', 0.05, 'syllabus', 10.05),
(123, '12kk12', 'Jésus', 'kasapa', 0.05, 'gestion', 10.05),
(124, '12kk12', 'Jésus', 'kasapa', 0.05, 'gestion', 10.05),
(125, 'UN0012', 'kkkk', 'kasapa', 0.4, 'gestion', 80.4),
(126, '12kk12', 'kazembe', 'kasapa', 0.2, 'syllabus', 2.2),
(127, '12kk12', 'kazembe', 'kasapa', 0.1, 'syllabus', 20.1),
(128, '12kk12', 'kazembe', 'kasapa', 0.1, 'syllabus', 20.1);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `idEleve` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `postNom` varchar(100) NOT NULL,
  `matricule` varchar(30) NOT NULL,
  `idEcole` int(11) NOT NULL,
  `faculte` varchar(100) NOT NULL,
  `promotion` varchar(100) NOT NULL,
  `adresse` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nomEcole` varchar(100) NOT NULL,
  `optionEtudiant` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`idEleve`, `nom`, `prenom`, `postNom`, `matricule`, `idEcole`, `faculte`, `promotion`, `adresse`, `email`, `nomEcole`, `optionEtudiant`) VALUES
(11, 'Kabuya', 'Ngomba', 'Malta', 'test003', 13, 'Geo', 'G1', 'Golf', 'mukunday1@yahoo.fr', 'esis', ''),
(12, 'jesus', 'kazembe', 'kidinda', '16kk169', 13, 'génie Logiciel', 'l3', 'Golf', 'mukunday1@yahoo.fr', 'esis', ''),
(14, 'MUKUNDAY', 'KAPULU ', 'KAPULU ', 'lebeau', 13, 'Geo', 'LEBEAU', 'Golf', 'mukunday1@yahoo.fr', 'esis', ''),
(45, 'kazembe', 'kidinda', 'jesus', '12ll12', 11, '64', 'l2', 'Golf', 'mukunday1@yahoo.fr', 'kasapa', ''),
(46, 'kazembe', 'kazembe', 'kazembe', '12kk12', 11, 'droit', 'G1', 'kazembe', 'kazembe', 'kasapa', 'Humain'),
(47, 'bmw', 'bmw', 'bmw', 'bmw', 0, 'bmw', 'bmw', 'bmw', 'bmw', 'bmw', 'bmw'),
(48, 'bmw', 'bmw', 'bmw', 'bull', 0, 'bmw', 'bmw', 'bmw', 'bmw', 'bmw', 'bmw'),
(49, 'gl', 'gl', 'gl', 'gk', 11, '82', 'G2', 'Golf', 'mukunday1@yahoo.fr', 'kasapa', 'admin'),
(50, 'kkkk', 'kkkkk', 'kkkkkkkk', 'UN0012', 11, '81', 'G1', 'Golf', 'mukunday1@yahoo.fr', 'kasapa', 'Humanitaire');

-- --------------------------------------------------------

--
-- Structure de la table `faculte`
--

CREATE TABLE `faculte` (
  `idFaculte` int(11) NOT NULL,
  `nomFaculte` varchar(60) NOT NULL,
  `idEcole` int(11) NOT NULL,
  `nomEcole` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `faculte`
--

INSERT INTO `faculte` (`idFaculte`, `nomFaculte`, `idEcole`, `nomEcole`) VALUES
(81, 'droit', 11, 'kasapa'),
(82, 'medecin', 11, 'kasapa'),
(83, 'science po', 11, 'kasapa'),
(84, 'systeme info', 13, 'esis'),
(85, 'management si', 13, 'esis'),
(86, 'good', 11, 'kasapa');

-- --------------------------------------------------------

--
-- Structure de la table `frais`
--

CREATE TABLE `frais` (
  `idFrais` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `numeroCompte` varchar(100) NOT NULL,
  `idBanque` int(11) NOT NULL,
  `idUniv` int(11) NOT NULL,
  `nomEcole` varchar(100) NOT NULL,
  `nomBanque` varchar(100) NOT NULL,
  `montant` int(11) NOT NULL,
  `devise` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `frais`
--

INSERT INTO `frais` (`idFrais`, `designation`, `numeroCompte`, `idBanque`, `idUniv`, `nomEcole`, `nomBanque`, `montant`, `devise`) VALUES
(30, 'gestion', '08089090', 38, 11, 'kasapa', 'kernel', 800, 'USD'),
(31, 'session', '909090', 38, 11, 'kasapa', 'kernel', 9800, 'CDF'),
(32, 'Defense', '121212', 38, 11, 'kasapa', 'kernel', 9500, 'USD'),
(33, 'cantine', '40404040', 37, 11, 'kasapa', 'UBA', 5800, 'USD'),
(34, 'excursion', '2233445566000', 37, 11, 'kasapa', 'UBA', 200, 'USD');

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

CREATE TABLE `operation` (
  `idOperation` int(11) NOT NULL,
  `typeOperation` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `idEtudiant` varchar(100) NOT NULL,
  `dateOperation` varchar(100) NOT NULL,
  `frais` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `promotion` varchar(100) NOT NULL,
  `faculte` varchar(100) NOT NULL,
  `compte` varchar(100) NOT NULL,
  `operateur` varchar(100) NOT NULL,
  `nomOperateur` varchar(100) NOT NULL,
  `commission` double NOT NULL,
  `devise` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `operation`
--

INSERT INTO `operation` (`idOperation`, `typeOperation`, `montant`, `idEtudiant`, `dateOperation`, `frais`, `nom`, `postnom`, `code`, `promotion`, `faculte`, `compte`, `operateur`, `nomOperateur`, `commission`, `devise`) VALUES
(456, 'Paiement effectué', 101, '12kk12', '2021-05-03 15:49:23', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-15-49-23.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.5, 'Fc'),
(457, 'Paiement effectué', 100.5, '12kk12', '2021-05-03 15:53:43', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-15-53-43.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.5, 'Fc'),
(458, 'Paiement effectué', 10, '12kk12', '2021-05-03 15:57:32', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-03-21-15-57-32.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.05, '$'),
(459, 'Paiement effectué', 10, '12kk12', '2021-05-03 15:58:35', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-03-21-15-58-35.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.05, '$'),
(460, 'Paiement effectué', 20, '12kk12', '2021-05-03 15:59:00', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-03-21-15-59-00.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.1, '$'),
(461, 'Paiement effectué', 100.5, '12kk12', '2021-05-03 16:04:13', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-04-13.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.5, 'Fc'),
(462, 'Paiement effectué', 100.5, '12kk12', '2021-05-03 16:06:51', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-06-51.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.5, 'Fc'),
(463, 'Paiement effectué', 10.05, '12kk12', '2021-05-03 16:09:32', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-09-32.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.05, '$'),
(464, 'Paiement effectué', 5.025, '12kk12', '2021-05-03 16:09:54', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-09-54.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.025, '$'),
(465, 'Paiement effectué', 20.1, '12kk12', '2021-05-03 16:11:50', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-11-50.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 0.1, 'Fc'),
(466, 'Paiement effectué', 1.005, '12kk12', '2021-05-03 16:15:04', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-15-04.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.005, 'USD'),
(467, 'Paiement effectué', 2562.75, '12kk12', '2021-05-03 16:15:31', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-15-31.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 12.75, 'Fc'),
(468, 'Paiement effectué', 22.11, '12kk12', '2021-05-03 16:27:00', 'Defense', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-27-00.png', 'l2', 'Phylosophie', '121212', 'assets/images/bangulogo.png', 'mbangu', 0.11, 'USD'),
(469, 'Paiement effectué', 4020, '12kk12', '2021-05-03 16:27:23', 'session', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-27-23.png', 'l2', 'Phylosophie', '909090', 'assets/images/bangulogo.png', 'mbangu', 20, 'Fc'),
(470, 'Paiement effectué', 1.005, '12kk12', '2021-05-03 16:59:49', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-03-21-16-59-49.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.005, 'USD'),
(471, 'Dépôt effectué', 100, '12kk12', '2021-05-03 17:11:12', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'USD'),
(481, 'Achat Syllabus', 20.1, '12kk12', '2021-05-04 01:12:08', '', 'Jésus', 'kidinda', 'qrcode-05-04-21-01-12-08.png', 'l2', 'Phylosophie', '', 'assets/images/syllabus.webp', 'Marketing', 0.1, 'USD'),
(482, 'Achat Syllabus', 10.05, '12kk12', '2021-05-04 01:19:00', '', 'Jésus', 'kidinda', 'qrcode-05-04-21-01-19-00.png', 'l2', 'Phylosophie', '', 'assets/images/syllabus.webp', 'Economie Po', 0.05, 'USD'),
(483, 'Achat Syllabus', 10.05, '12kk12', '2021-05-04 01:19:17', '', 'Jésus', 'kidinda', 'qrcode-05-04-21-01-19-17.png', 'l2', 'Phylosophie', '', 'assets/images/syllabus.webp', 'Gest Entreprise', 0.05, 'USD'),
(484, 'Paiement effectué', 10.05, '12kk12', '2021-05-04 03:18:49', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-04-21-03-18-49.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.05, 'USD'),
(485, 'Paiement effectué', 10.05, '12kk12', '2021-05-04 03:19:23', 'gestion', 'Jésus', 'kidinda', 'qrcode-05-04-21-03-19-23.png', 'l2', 'Phylosophie', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.05, 'USD'),
(486, 'Dépôt effectué', 1000, 'UN0012', '2021-05-05 05:53:33', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'USD'),
(487, 'Paiement effectué', 80.4, 'UN0012', '2021-05-05 05:54:40', 'gestion', 'kkkk', 'kkkkkkkk', 'qrcode-05-05-21-05-54-40.png', 'G1', '81', '08089090', 'assets/images/bangulogo.png', 'mbangu', 0.4, 'USD'),
(488, 'Dépôt effectué', 100, 'UN0012', '2021-05-05 10:14:40', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'USD'),
(489, 'Dépôt effectué', 100, 'UN0012', '2021-05-05 10:14:53', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'USD'),
(490, 'Dépôt effectué', 10, '12kk12', '2021-05-05 10:31:34', '', '', '', '', '', '', '', 'rawbank', 'rawbank', 0, 'CDF'),
(491, 'Dépôt effectué', 10, '12kk12', '2021-05-05 10:52:33', '', '', '', '', '', '', '', 'rawbank', 'rawbank', 0, 'CDF'),
(492, 'Dépôt effectué', 100, '12kk12', '2021-05-05 10:53:35', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'CDF'),
(493, 'Dépôt effectué', 10, '12kk12', '2021-05-05 10:57:52', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'CDF'),
(494, 'Dépôt effectué', 100, '12kk12', '2021-05-05 10:58:02', '', '', '', '', '', '', '', 'assets/images/paypal.png', 'rawbank', 0, 'USD'),
(495, 'Achat Syllabus', 2.2, '12kk12', '2021-05-05 11:11:56', '', 'kazembe', 'kazembe', 'qrcode-05-05-21-11-11-56.png', 'G1', 'droit', '', 'assets/images/syllabus.webp', 'cmarketting', 0.2, 'USD'),
(496, 'Achat Syllabus', 20.1, '12kk12', '2021-05-05 11:13:02', '', 'kazembe', 'kazembe', 'qrcode-05-05-21-11-13-02.png', 'G1', 'droit', '', 'assets/images/syllabus.webp', 'Marketing', 0.1, 'USD'),
(497, 'Achat Syllabus', 20.1, '12kk12', '2021-05-05 11:23:39', '', 'kazembe', 'kazembe', 'qrcode-05-05-21-11-23-39.png', 'G1', 'droit', '', 'assets/images/syllabus.webp', 'Marketing', 0.1, 'USD');

-- --------------------------------------------------------

--
-- Structure de la table `option`
--

CREATE TABLE `option` (
  `idOption` int(11) NOT NULL,
  `intituleOption` varchar(100) NOT NULL,
  `intituleFaculte` varchar(100) NOT NULL,
  `ecole` varchar(100) NOT NULL,
  `idEcole` int(11) NOT NULL,
  `idpromotion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `optionpromotion`
--

CREATE TABLE `optionpromotion` (
  `idOption` int(11) NOT NULL,
  `intituleOption` varchar(100) NOT NULL,
  `idEcole` varchar(100) NOT NULL,
  `idPromotion` int(11) NOT NULL,
  `intitulePromotion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `matricule` varchar(60) NOT NULL,
  `datePay` datetime NOT NULL,
  `montantPay` int(11) NOT NULL,
  `idFrais` int(11) NOT NULL,
  `nomEtudiant` varchar(100) NOT NULL,
  `frais` varchar(100) NOT NULL,
  `numeroCompte` varchar(100) NOT NULL,
  `universite` varchar(100) NOT NULL,
  `faculte` varchar(100) NOT NULL,
  `promotion` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `postNom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `matricule`, `datePay`, `montantPay`, `idFrais`, `nomEtudiant`, `frais`, `numeroCompte`, `universite`, `faculte`, `promotion`, `prenom`, `postNom`) VALUES
(267, '12kk12', '2021-04-12 03:16:07', 2, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(268, '12kk12', '2021-04-12 03:18:07', 2, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(269, '12kk12', '2021-04-12 11:58:32', 1, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(270, '12kk12', '2021-04-12 12:05:31', 8, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(271, '12kk12', '2021-04-13 01:49:09', 1, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(272, '12kk12', '2021-04-13 01:50:56', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(273, '12kk12', '2021-04-13 01:52:14', 12, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(274, '12kk12', '2021-04-13 02:10:58', 10, 25, 'Jésus', 'primature', 'goal', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(275, '12kk12', '2021-04-13 13:13:16', 120, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(276, '12kk12', '2021-04-14 15:08:41', 10, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(277, '12ll12', '2021-04-19 02:31:24', 500, 24, 'kazembe', 'googling', 'blabla', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(278, '12ll12', '2021-04-19 02:36:34', 200, 24, 'kazembe', 'googling', 'blabla', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(279, '12ll12', '2021-04-19 02:37:02', 100, 26, 'kazembe', 'Defense', 'YYYY', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(280, '12ll12', '2021-04-19 02:53:31', 100, 25, 'kazembe', 'primature', 'goal', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(281, '12ll12', '2021-04-19 03:01:45', 200, 24, 'kazembe', 'googling', 'blabla', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(282, '12ll12', '2021-04-19 03:14:20', 200, 24, 'kazembe', 'googling', 'blabla', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(283, '12kk12', '2021-04-25 00:03:04', 300, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(284, '12kk12', '2021-04-25 00:03:37', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(285, '12kk12', '2021-04-26 08:26:33', 100, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(286, '12kk12', '2021-04-26 08:29:10', 200, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(287, '12kk12', '2021-04-27 18:21:43', 500, 33, 'Jésus', 'cantine', '40404040', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(288, '12kk12', '2021-04-27 18:23:02', 1000, 33, 'Jésus', 'cantine', '40404040', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(289, '12kk12', '2021-04-27 18:23:39', 350, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(290, '12kk12', '2021-04-27 18:51:18', 10, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(291, '12kk12', '2021-04-28 19:08:02', 200, 33, 'Jésus', 'cantine', '40404040', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(292, '12kk12', '2021-04-28 19:42:46', 10, 33, 'Jésus', 'cantine', '40404040', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(293, '12kk12', '2021-04-28 19:50:12', 100, 33, 'Jésus', 'cantine', '40404040', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(294, '12kk12', '2021-05-03 14:34:02', 10, 33, 'Jésus', 'cantine', '40404040', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(295, '12kk12', '2021-05-03 15:57:32', 10, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(296, '12kk12', '2021-05-03 15:58:35', 10, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(297, '12kk12', '2021-05-03 15:59:00', 20, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(298, '12kk12', '2021-05-03 16:09:32', 10, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(299, '12kk12', '2021-05-03 16:09:54', 5, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(300, '12kk12', '2021-05-03 16:15:04', 1, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(301, '12kk12', '2021-05-03 16:27:00', 22, 32, 'Jésus', 'Defense', '121212', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(302, '12kk12', '2021-05-03 16:59:49', 1, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(303, '12kk12', '2021-05-04 03:18:49', 10, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(304, '12kk12', '2021-05-04 03:19:23', 10, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(305, 'UN0012', '2021-05-05 05:54:40', 80, 30, 'kkkk', 'gestion', '08089090', 'kasapa', '81', 'G1', 'kkkkk', 'kkkkkkkk');

-- --------------------------------------------------------

--
-- Structure de la table `paiementcdf`
--

CREATE TABLE `paiementcdf` (
  `id` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `datePay` datetime NOT NULL,
  `montantPay` float NOT NULL,
  `idFrais` int(11) NOT NULL,
  `nomEtudiant` varchar(100) NOT NULL,
  `frais` varchar(100) NOT NULL,
  `numeroCompte` varchar(100) NOT NULL,
  `universite` varchar(100) NOT NULL,
  `faculte` varchar(100) NOT NULL,
  `promotion` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `paiementcdf`
--

INSERT INTO `paiementcdf` (`id`, `matricule`, `datePay`, `montantPay`, `idFrais`, `nomEtudiant`, `frais`, `numeroCompte`, `universite`, `faculte`, `promotion`, `prenom`, `postnom`) VALUES
(1, '12kk12', '2021-04-18 04:59:51', 400, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(2, '12kk12', '2021-04-19 02:31:50', 400, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(3, '12kk12', '2021-04-19 03:00:45', 400, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(4, '12kk12', '2021-04-19 03:01:29', 400, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(5, '12kk12', '2021-04-19 03:09:31', 400, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(6, '12kk12', '2021-04-19 03:10:46', 400, 5, 'Jésus', 'excursion', 'all', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(7, '12ll12', '2021-04-19 03:13:45', 2000, 24, 'kazembe', 'googling', 'blabla', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(8, '12ll12', '2021-04-19 03:14:03', 100, 25, 'kazembe', 'primature', 'goal', 'kasapa', '64', 'l2', 'kidinda', 'jesus'),
(9, '12kk12', '2021-04-19 12:02:39', 2000, 27, 'Jésus', 'carte etudiant', '1209837', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(10, '12kk12', '2021-04-19 12:36:46', 50, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(11, '12kk12', '2021-04-23 16:29:12', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(12, '12kk12', '2021-04-24 14:30:36', 500, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(13, '12kk12', '2021-04-24 14:40:23', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(14, '12kk12', '2021-04-24 14:42:04', 440, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(15, '12kk12', '2021-04-24 14:42:48', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(16, '12kk12', '2021-04-24 17:19:49', 1000, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(17, '12kk12', '2021-04-24 17:28:50', 100, 25, 'Jésus', 'primature', 'goal', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(18, '12kk12', '2021-04-24 17:39:23', 100, 25, 'Jésus', 'primature', 'goal', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(19, '12kk12', '2021-04-24 17:40:23', 500, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(20, '12kk12', '2021-04-24 17:40:45', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(21, '12kk12', '2021-04-24 17:41:34', 100, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(22, '12kk12', '2021-04-25 00:34:37', 1, 24, 'Jésus', 'googling', 'blabla', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(23, '12kk12', '2021-04-25 21:26:54', 120, 30, 'Jésus', 'gestion', '08089090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(24, '12kk12', '2021-04-25 23:05:54', 150, 32, 'Jésus', 'Defense', '121212', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(25, '12kk12', '2021-04-25 23:07:04', 100, 32, 'Jésus', 'Defense', '121212', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(26, '12kk12', '2021-04-26 08:33:05', 100, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(27, '12kk12', '2021-04-28 19:07:36', 100, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(28, '12kk12', '2021-04-28 19:09:11', 200, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(29, '12kk12', '2021-04-28 19:42:24', 12, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(30, '12kk12', '2021-04-28 19:49:36', 1000, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(31, '12kk12', '2021-05-03 14:54:46', 100, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(32, '12kk12', '2021-05-03 14:55:23', 38, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(33, '12kk12', '2021-05-03 15:21:38', 188, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(34, '12kk12', '2021-05-03 15:37:08', 1005, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(35, '12kk12', '2021-05-03 15:39:08', 1005, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(36, '12kk12', '2021-05-03 15:39:45', 10.05, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(37, '12kk12', '2021-05-03 15:41:15', 20.1, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(38, '12kk12', '2021-05-03 15:49:23', 100.5, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(39, '12kk12', '2021-05-03 15:53:43', 100.5, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(40, '12kk12', '2021-05-03 16:04:13', 100.5, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(41, '12kk12', '2021-05-03 16:06:51', 100.5, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(42, '12kk12', '2021-05-03 16:11:50', 20.1, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(43, '12kk12', '2021-05-03 16:15:31', 2562.75, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda'),
(44, '12kk12', '2021-05-03 16:27:23', 4020, 31, 'Jésus', 'session', '909090', 'kasapa', 'Phylosophie', 'l2', 'kazembe', 'kidinda');

-- --------------------------------------------------------

--
-- Structure de la table `password`
--

CREATE TABLE `password` (
  `id` int(11) NOT NULL,
  `matricule` varchar(60) NOT NULL,
  `code` varchar(60) NOT NULL,
  `confirmCode` varchar(60) NOT NULL,
  `nomEtudiant` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `password`
--

INSERT INTO `password` (`id`, `matricule`, `code`, `confirmCode`, `nomEtudiant`) VALUES
(20, '12kk12', 'jour', 'jour', 'Jésus'),
(21, '23kk23', '23kk23', '23kk23', 'jes'),
(22, '23kk23', '23kk23', '23kk23', 'jes'),
(23, '23kk23', '23kk23', '23kk23', 'jes'),
(24, '23kk23', '12345', '12345', 'jes'),
(25, 'mmm', 'kid', 'kid', 'n'),
(26, 'mm', 'mm', 'mm', 'kid'),
(27, 'all', 'all', 'all', 'jdndnd'),
(28, 'y un ne un', 'gf ng', 'gf ng', 'xbfgcx'),
(29, 'lklk', 'lklk', 'lklk', 'fkg'),
(30, 'anna', 'azertyuiop', 'azertyuiop', 'mukunday'),
(31, 'mat', 'mat', 'mat', 'kid'),
(32, 'bjlvh', 'azel', 'azel', 'ghlhy'),
(33, 'll', 'll', 'll', 'nsnnsjs'),
(34, 'test007', 'azertyuiop', 'azertyuiop', 'test007'),
(35, 'test0015', 'azertyuiop', 'azertyuiop', 'test0015'),
(36, '12ll12', 'kazembe', 'kazembe', 'kazembe'),
(37, '12kk12', 'kazembe', 'kazembe', 'kazembe'),
(38, 'bmw', 'bmw', 'bmw', 'bmw'),
(39, 'bmw', 'bmw', 'bmw', 'bmw'),
(40, 'bmw', 'bmw', 'bmw', 'bmw'),
(41, 'bull', 'bmw', 'bmw', 'bmw'),
(42, 'gk', 'gl', 'gl', 'gl'),
(43, 'UN0012', '12345', '12345', 'kkkk');

-- --------------------------------------------------------

--
-- Structure de la table `paymentsyllabus`
--

CREATE TABLE `paymentsyllabus` (
  `idPayment` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `devise` varchar(100) NOT NULL,
  `faculte` varchar(100) NOT NULL,
  `commission` float NOT NULL,
  `syllabus` varchar(100) NOT NULL,
  `datePay` datetime NOT NULL,
  `universite` varchar(100) NOT NULL,
  `promotion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `paymentsyllabus`
--

INSERT INTO `paymentsyllabus` (`idPayment`, `matricule`, `nom`, `prenom`, `montant`, `devise`, `faculte`, `commission`, `syllabus`, `datePay`, `universite`, `promotion`) VALUES
(9, '12kk12', 'Jésus', 'kazembe', 20.1, '', 'Phylosophie', 0.1, 'Marketing', '2021-05-04 01:12:08', 'kasapa', 'l2'),
(10, '12kk12', 'Jésus', 'kazembe', 10.05, '', 'Phylosophie', 0.05, 'Economie Po', '2021-05-04 01:19:00', 'kasapa', 'l2'),
(11, '12kk12', 'Jésus', 'kazembe', 10.05, '', 'Phylosophie', 0.05, 'Gest Entreprise', '2021-05-04 01:19:17', 'kasapa', 'l2'),
(12, '12kk12', 'kazembe', 'kazembe', 2.2, '', 'droit', 0.2, 'cmarketting', '2021-05-05 11:11:56', 'kasapa', 'G1'),
(13, '12kk12', 'kazembe', 'kazembe', 20.1, '', 'droit', 0.1, 'Marketing', '2021-05-05 11:13:02', 'kasapa', 'G1'),
(14, '12kk12', 'kazembe', 'kazembe', 20.1, '', 'droit', 0.1, 'Marketing', '2021-05-05 11:23:39', 'kasapa', 'G1');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `idProfesseur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL,
  `cours` varchar(100) NOT NULL,
  `idEcole` int(11) NOT NULL,
  `nomEcole` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`idProfesseur`, `nom`, `postnom`, `cours`, `idEcole`, `nomEcole`, `username`, `mdp`) VALUES
(1, 'jesus', 'kazembe', 'intelligence artificielle', 11, 'esis', 'jesus', '0000'),
(2, 'kidinda', 'kazembe', 'mathematique algebrique', 11, 'kasapa', 'kid', 'kid'),
(1, 'jesus', 'kazembe', 'intelligence artificielle', 11, 'esis', 'jesus', '0000'),
(2, 'kidinda', 'kazembe', 'mathematique algebrique', 11, 'kasapa', 'kid', 'kid');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `idPromotion` int(11) NOT NULL,
  `intitulePromotion` varchar(100) NOT NULL,
  `intituleOption` varchar(100) NOT NULL,
  `intituleFaculte` varchar(100) NOT NULL,
  `idEcole` int(11) NOT NULL,
  `idFaculte` int(11) NOT NULL,
  `ecole` varchar(100) NOT NULL,
  `idOption` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`idPromotion`, `intitulePromotion`, `intituleOption`, `intituleFaculte`, `idEcole`, `idFaculte`, `ecole`, `idOption`, `dateCreation`) VALUES
(241, 'G1', 'Humanitaire', 'droit', 11, 81, 'kasapa', 0, '2021-05-05 00:18:21'),
(242, 'G1', 'admin', 'medecin', 11, 82, 'kasapa', 0, '2021-05-05 00:19:15'),
(243, 'G2', 'admin', 'medecin', 11, 82, 'kasapa', 0, '2021-05-05 00:19:15'),
(244, 'G1', 'biologie', 'medecin', 11, 82, 'kasapa', 0, '2021-05-05 00:19:15'),
(245, 'G2', 'biologie', 'medecin', 11, 82, 'kasapa', 0, '2021-05-05 00:19:15'),
(246, 'M1', 'Biologie', 'science po', 11, 83, 'kasapa', 0, '2021-05-05 02:48:42'),
(247, 'M2', 'Biologie', 'science po', 11, 83, 'kasapa', 0, '2021-05-05 02:48:42'),
(248, 'M1', 'Neurologie', 'science po', 11, 83, 'kasapa', 0, '2021-05-05 02:48:42'),
(249, 'M2', 'Neurologie', 'science po', 11, 83, 'kasapa', 0, '2021-05-05 02:48:42'),
(250, 'G1', 'test', 'science po', 11, 83, 'kasapa', 0, '2021-05-05 04:04:07'),
(251, 'G1', 'test2', 'science po', 11, 83, 'kasapa', 0, '2021-05-05 04:04:44');

-- --------------------------------------------------------

--
-- Structure de la table `promotionuniv`
--

CREATE TABLE `promotionuniv` (
  `idPromoUniv` int(11) NOT NULL,
  `intitulePromoUniv` varchar(100) NOT NULL,
  `idUniv` int(11) NOT NULL,
  `nomUniv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `promotionuniv`
--

INSERT INTO `promotionuniv` (`idPromoUniv`, `intitulePromoUniv`, `idUniv`, `nomUniv`) VALUES
(20, 'G1', 11, 'kasapa'),
(21, 'G2', 11, 'kasapa'),
(22, 'G3', 11, 'kasapa'),
(23, 'L1', 11, 'kasapa'),
(24, 'L2', 11, 'kasapa'),
(25, 'M1', 11, 'kasapa'),
(26, 'M2', 11, 'kasapa');

-- --------------------------------------------------------

--
-- Structure de la table `reste`
--

CREATE TABLE `reste` (
  `idReste` int(11) NOT NULL,
  `idFrais` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `frais` varchar(100) NOT NULL,
  `resteMontant` float NOT NULL,
  `devise` varchar(100) NOT NULL,
  `montantPayer` float NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `montantTotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reste`
--

INSERT INTO `reste` (`idReste`, `idFrais`, `matricule`, `nom`, `frais`, `resteMontant`, `devise`, `montantPayer`, `prenom`, `montantTotal`) VALUES
(67, 31, '12kk12', 'Jésus', 'session', 0, 'CDF', 9800, 'kazembe', 9800),
(68, 30, '12kk12', 'Jésus', 'gestion', 703, 'USD', 97, 'kazembe', 800),
(69, 32, '12kk12', 'Jésus', 'Defense', 9478, 'USD', 22, 'kazembe', 9500),
(70, 30, 'UN0012', 'kkkk', 'gestion', 720, 'USD', 80, 'kkkkk', 800);

-- --------------------------------------------------------

--
-- Structure de la table `solde`
--

CREATE TABLE `solde` (
  `idSolde` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `devise` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `solde`
--

INSERT INTO `solde` (`idSolde`, `matricule`, `montant`, `devise`) VALUES
(31, 'UN001', 100, 'USD'),
(32, '12kk12', 57.89, 'USD'),
(33, 'UN0012', 1119.6, 'USD');

-- --------------------------------------------------------

--
-- Structure de la table `soldeCdf`
--

CREATE TABLE `soldeCdf` (
  `idSolde` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `devise` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `soldeCdf`
--

INSERT INTO `soldeCdf` (`idSolde`, `matricule`, `montant`, `devise`) VALUES
(1, '12kk12', 130, 'CDF');

-- --------------------------------------------------------

--
-- Structure de la table `supplementaire`
--

CREATE TABLE `supplementaire` (
  `id` int(11) NOT NULL,
  `sexe` varchar(100) NOT NULL,
  `nationalite` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `carte` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `syllabus`
--

CREATE TABLE `syllabus` (
  `id` int(11) NOT NULL,
  `fichier` varchar(100) NOT NULL,
  `idProf` int(11) NOT NULL,
  `nomProf` varchar(11) NOT NULL,
  `optionSyllabus` varchar(100) NOT NULL,
  `promotionSyllabus` varchar(100) NOT NULL,
  `faculteSyllabus` varchar(100) NOT NULL,
  `prix` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `intituleoption` varchar(100) NOT NULL,
  `intitulepromotion` varchar(100) NOT NULL,
  `intitulefaculte` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `syllabus`
--

INSERT INTO `syllabus` (`id`, `fichier`, `idProf`, `nomProf`, `optionSyllabus`, `promotionSyllabus`, `faculteSyllabus`, `prix`, `titre`, `intituleoption`, `intitulepromotion`, `intitulefaculte`) VALUES
(50, '', 2, 'kid', '41', '34', '82', 12, '12', 'medecine general', 'l1', 'medecin'),
(51, 'upload/03217725638.pdf', 2, 'kid', '39', '22', '81', 300, 'initiation Programmation', 'droit prive', 'g2', 'droit');

-- --------------------------------------------------------

--
-- Structure de la table `tempo`
--

CREATE TABLE `tempo` (
  `idTemp` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `state` varchar(30) NOT NULL,
  `montant` int(11) NOT NULL,
  `reseau` varchar(100) NOT NULL,
  `dateTemp` varchar(30) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tempo`
--

INSERT INTO `tempo` (`idTemp`, `matricule`, `state`, `montant`, `reseau`, `dateTemp`, `message`) VALUES
(35, '12kk12', 'null', 100, 'airtel', '2021-04-28 12:51:23', '436'),
(45, 'test007', 'null', 123456, 'airtel', '04/07/21-02:01:49', 'M-PESA'),
(46, '12ll12', 'echec', 1800, 'airtel', '2021-04-19 02:34:54', '436'),
(47, 'UN001', 'null', 120, 'airtel', '2021-04-20 01:05:46', '1211'),
(48, '23kk23', 'echec', 200, 'airtel', '2021-04-25 20:40:58', '436');

-- --------------------------------------------------------

--
-- Structure de la table `universite`
--

CREATE TABLE `universite` (
  `idEcole` int(11) NOT NULL,
  `denomination` varchar(100) NOT NULL,
  `code` varchar(30) NOT NULL,
  `login` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `universite`
--

INSERT INTO `universite` (`idEcole`, `denomination`, `code`, `login`) VALUES
(11, 'kasapa', '445566', 'log'),
(12, 'isc', 'isc', 'admin'),
(13, 'esis', 'Jesus', 'jesus'),
(14, 'kingstone', 'kingstone', 'kinggstone');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `appro`
--
ALTER TABLE `appro`
  ADD PRIMARY KEY (`idAppro`);

--
-- Index pour la table `approcdf`
--
ALTER TABLE `approcdf`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `banque`
--
ALTER TABLE `banque`
  ADD PRIMARY KEY (`idBanque`);

--
-- Index pour la table `banqueuniv`
--
ALTER TABLE `banqueuniv`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`idEleve`);

--
-- Index pour la table `faculte`
--
ALTER TABLE `faculte`
  ADD PRIMARY KEY (`idFaculte`);

--
-- Index pour la table `frais`
--
ALTER TABLE `frais`
  ADD PRIMARY KEY (`idFrais`);

--
-- Index pour la table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`idOperation`);

--
-- Index pour la table `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`idOption`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiementcdf`
--
ALTER TABLE `paiementcdf`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paymentsyllabus`
--
ALTER TABLE `paymentsyllabus`
  ADD PRIMARY KEY (`idPayment`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`idPromotion`);

--
-- Index pour la table `promotionuniv`
--
ALTER TABLE `promotionuniv`
  ADD PRIMARY KEY (`idPromoUniv`);

--
-- Index pour la table `reste`
--
ALTER TABLE `reste`
  ADD PRIMARY KEY (`idReste`);

--
-- Index pour la table `solde`
--
ALTER TABLE `solde`
  ADD PRIMARY KEY (`idSolde`);

--
-- Index pour la table `soldeCdf`
--
ALTER TABLE `soldeCdf`
  ADD PRIMARY KEY (`idSolde`);

--
-- Index pour la table `supplementaire`
--
ALTER TABLE `supplementaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `syllabus`
--
ALTER TABLE `syllabus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tempo`
--
ALTER TABLE `tempo`
  ADD PRIMARY KEY (`idTemp`);

--
-- Index pour la table `universite`
--
ALTER TABLE `universite`
  ADD PRIMARY KEY (`idEcole`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `appro`
--
ALTER TABLE `appro`
  MODIFY `idAppro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT pour la table `approcdf`
--
ALTER TABLE `approcdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `banque`
--
ALTER TABLE `banque`
  MODIFY `idBanque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `banqueuniv`
--
ALTER TABLE `banqueuniv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commission`
--
ALTER TABLE `commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `idEleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `faculte`
--
ALTER TABLE `faculte`
  MODIFY `idFaculte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT pour la table `frais`
--
ALTER TABLE `frais`
  MODIFY `idFrais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `operation`
--
ALTER TABLE `operation`
  MODIFY `idOperation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;

--
-- AUTO_INCREMENT pour la table `option`
--
ALTER TABLE `option`
  MODIFY `idOption` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT pour la table `paiementcdf`
--
ALTER TABLE `paiementcdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `password`
--
ALTER TABLE `password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `paymentsyllabus`
--
ALTER TABLE `paymentsyllabus`
  MODIFY `idPayment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `idPromotion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT pour la table `promotionuniv`
--
ALTER TABLE `promotionuniv`
  MODIFY `idPromoUniv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `reste`
--
ALTER TABLE `reste`
  MODIFY `idReste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT pour la table `solde`
--
ALTER TABLE `solde`
  MODIFY `idSolde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `soldeCdf`
--
ALTER TABLE `soldeCdf`
  MODIFY `idSolde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `supplementaire`
--
ALTER TABLE `supplementaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `syllabus`
--
ALTER TABLE `syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `tempo`
--
ALTER TABLE `tempo`
  MODIFY `idTemp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `universite`
--
ALTER TABLE `universite`
  MODIFY `idEcole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
