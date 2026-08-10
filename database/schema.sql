-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: film_folio
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adaptation`
--

DROP TABLE IF EXISTS `adaptation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adaptation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BookID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `BookID` (`BookID`),
  KEY `MovieID` (`MovieID`),
  CONSTRAINT `adaptation_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `media` (`MediaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adaptation_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `media` (`MediaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adaptationrating`
--

DROP TABLE IF EXISTS `adaptationrating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adaptationrating` (
  `UserID` int(11) DEFAULT NULL,
  `AdaptationID` int(11) DEFAULT NULL,
  `loyaltyscore` int(11) DEFAULT NULL,
  `castingscore` int(11) DEFAULT NULL,
  `overallscore` int(11) DEFAULT NULL,
  KEY `UserID` (`UserID`),
  KEY `AdaptationID` (`AdaptationID`),
  CONSTRAINT `adaptationrating_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `adaptationrating_ibfk_2` FOREIGN KEY (`AdaptationID`) REFERENCES `adaptation` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `book_author`
--

DROP TABLE IF EXISTS `book_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_author` (
  `MediaID` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  PRIMARY KEY (`MediaID`,`author`),
  CONSTRAINT `book_author_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `collection`
--

DROP TABLE IF EXISTS `collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection` (
  `CollectionID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`CollectionID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contains`
--

DROP TABLE IF EXISTS `contains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contains` (
  `MediaID` int(11) NOT NULL,
  `CollectionID` int(11) NOT NULL,
  PRIMARY KEY (`MediaID`,`CollectionID`),
  KEY `CollectionID` (`CollectionID`),
  CONSTRAINT `contains_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`) ON DELETE CASCADE,
  CONSTRAINT `contains_ibfk_2` FOREIGN KEY (`CollectionID`) REFERENCES `collection` (`CollectionID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filter`
--

DROP TABLE IF EXISTS `filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filter` (
  `TagID` int(11) NOT NULL,
  `QuizID` int(11) NOT NULL,
  PRIMARY KEY (`TagID`,`QuizID`),
  KEY `QuizID` (`QuizID`),
  CONSTRAINT `filter_ibfk_1` FOREIGN KEY (`TagID`) REFERENCES `tag` (`TagID`) ON DELETE CASCADE,
  CONSTRAINT `filter_ibfk_2` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `has`
--

DROP TABLE IF EXISTS `has`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `has` (
  `MediaID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL,
  PRIMARY KEY (`MediaID`,`TagID`),
  KEY `TagID` (`TagID`),
  CONSTRAINT `has_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`) ON DELETE CASCADE,
  CONSTRAINT `has_ibfk_2` FOREIGN KEY (`TagID`) REFERENCES `tag` (`TagID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `MediaID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `releaseyear` int(11) DEFAULT NULL,
  `pgcount` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `runtime` int(11) DEFAULT NULL,
  `mediatype` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MediaID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz` (
  `QuizID` int(11) NOT NULL AUTO_INCREMENT,
  `quiztext` text NOT NULL,
  `choicetype` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`QuizID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `TagID` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` varchar(50) NOT NULL,
  `tagtype` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`TagID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joindate` date NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-11  1:24:09
