-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 sep. 2021 à 07:35
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `library`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'Administrateur', 'admin@gmail.com', 'admin', '098f6bcd4621d373cade4e832627b4f6', '2021-09-14 14:26:32');

-- --------------------------------------------------------

--
-- Structure de la table `tblauthors`
--

DROP TABLE IF EXISTS `tblauthors`;
CREATE TABLE IF NOT EXISTS `tblauthors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblauthors`
--

INSERT INTO `tblauthors` (`id`, `AuthorName`, `creationDate`, `UpdationDate`) VALUES
(1, 'Guillaume Musso', '2017-07-08 12:49:09', '2021-07-23 08:41:21'),
(2, 'Michel Bussi', '2017-07-08 14:30:23', '2021-07-23 08:43:21'),
(3, 'Marc Levy', '2017-07-08 14:35:08', '2021-07-23 08:43:40'),
(5, 'Gilles Legardinier', '2017-07-08 14:35:36', '2021-07-23 08:44:25'),
(9, 'Agnès Martin', '2017-07-08 15:22:03', '2021-07-23 08:44:50'),
(39, 'moujahed karim', '2021-09-09 06:47:17', '2021-09-09 06:47:17'),
(40, 'gigirafe', '2021-09-09 06:47:26', '2021-09-13 12:50:49');

-- --------------------------------------------------------

--
-- Structure de la table `tblbooks`
--

DROP TABLE IF EXISTS `tblbooks`;
CREATE TABLE IF NOT EXISTS `tblbooks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `BookName` varchar(255) DEFAULT NULL,
  `CatId` int DEFAULT NULL,
  `AuthorId` int DEFAULT NULL,
  `ISBNNumber` int DEFAULT NULL,
  `BookPrice` int DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `RegDate`, `UpdationDate`) VALUES
(1, 'La jeune fille et la nuit', 4, 1, 222333, 21, '2017-07-08 20:04:55', '2021-08-06 15:37:08'),
(9, 'le long chemin', 5, 3, 12536, 30, '2021-09-09 07:22:10', NULL),
(14, 'karim le devellopeur', 41, 39, 74185263, 50, '2021-09-09 13:50:04', NULL),
(16, 'l\'enfant seul ', 41, 44, 74185263, 25, '2021-09-10 06:37:47', NULL),
(17, 'destin sacrée', 41, 39, 3101981, 145, '2021-09-10 06:38:42', '2021-09-10 06:40:36');

-- --------------------------------------------------------

--
-- Structure de la table `tblcategory`
--

DROP TABLE IF EXISTS `tblcategory`;
CREATE TABLE IF NOT EXISTS `tblcategory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Status`, `CreationDate`, `UpdationDate`) VALUES
(4, 'Romantique2', 1, '2017-07-04 18:35:25', '2021-09-07 06:58:28'),
(5, 'Technologie', 0, '2017-07-04 18:35:39', '2021-08-06 15:31:23'),
(6, 'Science', 0, '2017-07-04 18:35:55', '2021-09-07 07:01:14'),
(7, 'Management', 1, '2017-07-04 18:36:16', '2021-06-23 12:45:41'),
(8, 'Thriller', 1, '2021-07-26 09:08:35', '0000-00-00 00:00:00'),
(41, 'Legende Urbaine', 1, '2021-09-08 07:47:01', '2021-09-08 07:47:01'),
(42, 'biographie', 1, '2021-09-09 06:55:50', '2021-09-09 06:55:50'),
(43, 'professionnel', 1, '2021-09-10 06:36:49', '2021-09-10 06:36:49'),
(45, 'dessert', 1, '2021-09-13 07:59:53', '2021-09-13 07:59:53');

-- --------------------------------------------------------

--
-- Structure de la table `tblissuedbookdetails`
--

DROP TABLE IF EXISTS `tblissuedbookdetails`;
CREATE TABLE IF NOT EXISTS `tblissuedbookdetails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `BookId` int DEFAULT NULL,
  `ReaderID` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ReturnStatus` int DEFAULT NULL,
  `fine` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblissuedbookdetails`
--

INSERT INTO `tblissuedbookdetails` (`id`, `BookId`, `ReaderID`, `IssuesDate`, `ReturnDate`, `ReturnStatus`, `fine`) VALUES
(11, 222333, 'SID009', '2021-07-20 08:51:15', NULL, 0, NULL),
(12, 222333, 'SID009', '2021-07-20 09:53:27', NULL, 0, NULL),
(13, 222333, 'SID014', '2021-07-21 14:49:46', '2021-07-21 22:00:00', 1, NULL),
(14, 222333, 'SID017', '2021-07-29 14:14:15', '2021-09-13 22:00:00', 1, NULL),
(15, 222333, 'SID022', '2021-07-30 07:40:06', NULL, 0, NULL),
(16, 222333, 'SID001', '2021-08-06 15:20:20', NULL, 0, NULL),
(17, 222333, 'SID021', '2021-08-06 15:22:22', NULL, 0, NULL),
(18, 222333, 'SID018', '2021-09-13 14:01:25', '2021-09-13 22:00:00', 1, NULL),
(19, 222333, 'SID018', '2021-09-13 14:24:19', '2021-09-13 22:00:00', 1, NULL),
(20, 222333, 'SID018', '2021-09-13 14:25:25', '2021-09-14 22:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tblreaders`
--

DROP TABLE IF EXISTS `tblreaders`;
CREATE TABLE IF NOT EXISTS `tblreaders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ReaderId` varchar(100) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Status` int DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23;
--
-- Déchargement des données de la table `tblreaders`
--

INSERT INTO `tblreaders` (`id`, `ReaderId`, `FullName`, `EmailId`, `MobileNumber`, `Password`, `Status`, `RegDate`, `UpdateDate`) VALUES
(1, 'SID017', 'Eric Perkins', 'eperkins0@cnbc.com', '06060606', '29988429c481f219b8c5ba8c071440e1', 2, '2021-07-23 12:38:53', '2021-07-26 09:01:39'),
(2, 'SID018', 'Daniel Flores', 'dflores1@so-net.ne.jp', '07070707', 'aa47f8215c6f30a0dcdb2a36a9f4168e', 1, '2021-07-23 12:40:07', '2021-09-23 12:39:45'),
(3, 'SID019', 'Gregory Hayes', 'ghayes2@w3.org', '006080808', 'e73d1f05badaf94997bb3e886144f5f9', 1, '2021-07-23 12:41:18', '2021-09-23 12:39:37'),
(4, 'SID020', 'Michelle Dunn', 'mdunnc@twitter.com', '06123456', '2345f10bb948c5665ef91f6773b3e455', 1, '2021-07-23 12:42:20', '2021-09-23 12:39:41'),
(5, 'SID021', 'Test', 'test@gmail.com', '06060101', '10af1f24a5933164fda5c44b3ac88fab', 1, '2021-07-28 14:12:04', '2021-09-13 07:54:20'),
(19, 'SID034', 'tata', 'tata@gmail.com', '0147852369', '36e351ce8313d1c58820ea9ab32eec01', 1, '2021-09-13 08:34:33', NULL),
(7, 'SID022', 'toto', 'test@gmail.com', '06123456', 'e9619cf7d9a9a2da1fed1f25d32ca3ae', 1, '2021-08-24 08:47:24', NULL),
(8, 'SID023', 'karim', 'moujahedk83@gmail.com', '0620628021', '9d2602a5c43f4b5b969f5d48c90f9b2e', 1, '2021-08-24 09:05:46', NULL),
(9, 'SID024', 'karim', 'moujahedk83@gmail.com', '0620628021', '9d2602a5c43f4b5b969f5d48c90f9b2e', 1, '2021-08-24 09:08:18', NULL),
(10, 'SID025', 'hakim', 'moujahedk54@gmail.com', '0620628021', '6b3db3483fdae7406c2231808af5820b', 1, '2021-08-24 11:49:34', NULL),
(11, 'SID026', 'gendre', 'moujahedk12@gmail.com', '124578796', 'ab4f63f9ac65152575886860dde480a1', 1, '2021-08-24 11:54:05', NULL),
(12, 'SID027', 'genre', 'moujahed96@gmail.com', '0621525465', 'e55b1c81e5a562e40315dabc2c1c5c6c', 1, '2021-08-24 13:30:39', NULL),
(13, 'SID028', 'hakum', 'moujahedk8@gmail.com', '0621525465', '8ace72535e8ea08b22681721a437a6f5', 1, '2021-08-27 07:03:55', NULL),
(14, 'SID029', 'tail', 'tail@tartegmail.com', '01010101', '2a76230ba6c042409e5b010fcb5fc14b', 1, '2021-08-31 11:27:52', '2021-08-31 11:30:42'),
(15, 'SID030', 'atlas', 'atlasterre@gmail.com', '789456', '1fd3c4ef39f3723f137fb9f778be8bef', 1, '2021-08-31 11:41:46', '2021-08-31 11:43:07'),
(16, 'SID031', 'ge', 'jean@gmail.com', '01236547', 'eb62f6b9306db575c2d596b1279627a4', 1, '2021-09-01 11:48:43', NULL),
(17, 'SID032', 'atlas', 'atlaslarge@gmail.com', '0654897630', 'f11a2b42cc16a8f0dd1234852526320b', 1, '2021-09-12 00:36:17', '2021-09-12 01:29:50'),
(18, 'SID033', 'atlas', 'atlaserre@gmail.com', '0654897630', '202cb962ac59075b964b07152d234b70', 1, '2021-09-12 01:34:21', '2021-09-12 18:06:42'),
(20, 'SID035', 'alice', 'alice@gmail.com', '0656322347', '6384e2b2184bcbf58eccf10ca7a6563c', 2, '2021-09-14 09:11:06', '2021-09-14 14:49:27'),
(21, 'SID036', 'tata', 'tata2@gmail.com', '06060102', '202cb962ac59075b964b07152d234b70', 2, '2021-09-22 08:50:50', '2021-09-23 13:55:45'),
(22, 'SID037', 'rara', 'ra@gmail.com', '01472589', '140f6969d5213fd0ece03148e62e461e', 1, '2021-09-25 11:59:16', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
