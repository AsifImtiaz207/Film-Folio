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
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `adaptation`
--

LOCK TABLES `adaptation` WRITE;
/*!40000 ALTER TABLE `adaptation` DISABLE KEYS */;
INSERT INTO `adaptation` VALUES (1,1,11),(2,2,12),(3,3,13),(4,4,14),(5,5,15),(6,6,16),(7,7,17),(8,8,18),(9,9,19),(10,10,20);
/*!40000 ALTER TABLE `adaptation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `adaptationrating`
--

LOCK TABLES `adaptationrating` WRITE;
/*!40000 ALTER TABLE `adaptationrating` DISABLE KEYS */;
INSERT INTO `adaptationrating` VALUES (1,1,5,5,5),(2,1,5,4,5),(3,1,4,5,5),(1,2,4,5,4),(4,2,4,4,4),(2,3,4,5,4),(5,3,4,4,4),(1,4,5,5,5),(3,4,5,5,5),(2,5,4,5,4),(4,5,4,4,4),(3,6,4,4,4),(5,6,4,5,4),(1,7,5,5,5),(4,7,5,5,5),(2,8,5,5,5),(3,9,4,5,5),(5,9,4,5,5),(1,10,5,5,5),(4,10,5,5,5);
/*!40000 ALTER TABLE `adaptationrating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `book_author`
--

LOCK TABLES `book_author` WRITE;
/*!40000 ALTER TABLE `book_author` DISABLE KEYS */;
INSERT INTO `book_author` VALUES (1,'J.K. Rowling'),(2,'Suzanne Collins'),(3,'J.R.R. Tolkien'),(4,'Jane Austen'),(5,'John Green'),(6,'James Dashner'),(7,'Louisa May Alcott'),(8,'William Goldman'),(9,'Frank Herbert'),(10,'Neil Gaiman');
/*!40000 ALTER TABLE `book_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `collection`
--

LOCK TABLES `collection` WRITE;
/*!40000 ALTER TABLE `collection` DISABLE KEYS */;
INSERT INTO `collection` VALUES (1,'Favorites',1),(2,'Want to Read',1),(3,'Favorites',2),(4,'Want to Watch',2),(5,'Currently Reading',3),(6,'Watched',3),(7,'Favorites',4),(8,'Want to Read',4),(9,'Want to Watch',5),(10,'Favorites',5);
/*!40000 ALTER TABLE `collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `contains`
--

LOCK TABLES `contains` WRITE;
/*!40000 ALTER TABLE `contains` DISABLE KEYS */;
INSERT INTO `contains` VALUES (1,1),(1,10),(2,3),(3,5),(4,1),(5,8),(6,8),(7,5),(8,7),(9,2),(10,2),(11,1),(11,10),(12,3),(13,6),(14,9),(15,9),(16,10),(17,6),(18,7),(19,4),(20,4);
/*!40000 ALTER TABLE `contains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `filter`
--

LOCK TABLES `filter` WRITE;
/*!40000 ALTER TABLE `filter` DISABLE KEYS */;
INSERT INTO `filter` VALUES (1,2),(1,6),(2,2),(2,4),(3,2),(3,3),(3,10),(4,2),(5,2),(6,2),(8,8),(9,1),(10,1),(10,6),(11,1),(11,3),(11,8),(12,1),(12,3),(12,8),(13,1),(13,5),(14,6),(15,9),(16,9),(18,10),(19,4),(19,5),(21,4),(22,4),(23,10),(24,7);
/*!40000 ALTER TABLE `filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `has`
--

LOCK TABLES `has` WRITE;
/*!40000 ALTER TABLE `has` DISABLE KEYS */;
INSERT INTO `has` VALUES (1,1),(1,3),(1,9),(1,10),(1,14),(1,15),(1,16),(1,17),(2,3),(2,4),(2,11),(2,12),(2,18),(2,24),(3,1),(3,3),(3,9),(3,10),(3,15),(3,16),(3,23),(4,2),(4,6),(4,13),(4,19),(4,21),(4,22),(5,2),(5,6),(5,13),(5,19),(5,20),(5,21),(6,3),(6,4),(6,11),(6,12),(6,18),(6,20),(7,2),(7,6),(7,9),(7,13),(7,15),(7,17),(7,19),(8,1),(8,2),(8,3),(8,10),(8,19),(8,21),(8,23),(9,3),(9,5),(9,11),(9,12),(9,18),(9,20),(9,24),(10,1),(10,7),(10,8),(10,11),(10,12),(10,14),(10,20),(11,1),(11,3),(11,9),(11,10),(11,14),(11,15),(11,16),(11,17),(12,3),(12,4),(12,11),(12,12),(12,18),(12,24),(13,1),(13,3),(13,9),(13,10),(13,15),(13,16),(13,23),(14,2),(14,6),(14,13),(14,19),(14,21),(14,22),(15,2),(15,6),(15,13),(15,19),(15,20),(15,21),(16,3),(16,4),(16,11),(16,12),(16,18),(16,20),(17,2),(17,6),(17,9),(17,13),(17,15),(17,17),(17,19),(18,1),(18,2),(18,3),(18,10),(18,19),(18,21),(18,23),(19,3),(19,5),(19,11),(19,12),(19,18),(19,20),(19,24),(20,1),(20,7),(20,8),(20,11),(20,12),(20,14),(20,20);
/*!40000 ALTER TABLE `has` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'Harry Potter and the Philosopher\'s Stone','A young wizard discovers his magical heritage and begins his first year at Hogwarts.',1997,223,'9780747532699',NULL,NULL,'Book'),(2,'The Hunger Games','Katniss Everdeen volunteers to compete in a televised survival competition.',2008,374,'9780439023481',NULL,NULL,'Book'),(3,'The Hobbit','Bilbo Baggins joins a group of dwarves on a quest to reclaim their homeland.',1937,310,'9780261102217',NULL,NULL,'Book'),(4,'Pride and Prejudice','Elizabeth Bennet navigates family, society, and her complicated relationship with Mr Darcy.',1813,432,'9780141439518',NULL,NULL,'Book'),(5,'The Fault in Our Stars','Two teenagers meet at a cancer support group and form a meaningful relationship.',2012,313,'9780062024039',NULL,NULL,'Book'),(6,'The Maze Runner','A teenage boy wakes up in a mysterious maze with no memory of his past.',2009,374,'9780385737944',NULL,NULL,'Book'),(7,'Little Women','Four sisters grow up together while navigating family, love, ambition, and adulthood.',1868,449,'9780147514011',NULL,NULL,'Book'),(8,'The Princess Bride','A romantic adventure involving true love, pirates, revenge, and fantastical danger.',1973,352,'9780345340520',NULL,NULL,'Book'),(9,'Dune','A young nobleman becomes involved in a struggle over a desert planet and its valuable resource.',1965,412,'9780441172719',NULL,NULL,'Book'),(10,'Coraline','A young girl discovers a mysterious alternate world behind a hidden door.',2002,176,'9780385739787',NULL,NULL,'Book'),(11,'Harry Potter and the Philosopher\'s Stone','Harry Potter begins his magical education at Hogwarts.',2001,NULL,NULL,'Chris Columbus',152,'Movie'),(12,'The Hunger Games','Katniss volunteers to compete in the Hunger Games.',2012,NULL,NULL,'Gary Ross',142,'Movie'),(13,'The Hobbit: An Unexpected Journey','Bilbo joins a company of dwarves on an adventure to reclaim their homeland.',2012,NULL,NULL,'Peter Jackson',169,'Movie'),(14,'Pride & Prejudice','Elizabeth Bennet and Mr Darcy struggle with first impressions and social expectations.',2005,NULL,NULL,'Joe Wright',129,'Movie'),(15,'The Fault in Our Stars','Hazel and Augustus meet and develop a relationship while facing difficult circumstances.',2014,NULL,NULL,'Josh Boone',126,'Movie'),(16,'The Maze Runner','Thomas wakes up in a mysterious maze with a group of other teenagers.',2014,NULL,NULL,'Wes Ball',113,'Movie'),(17,'Little Women','The March sisters grow up while pursuing love, family, and their individual dreams.',2019,NULL,NULL,'Greta Gerwig',135,'Movie'),(18,'The Princess Bride','A romantic fantasy adventure about true love, pirates, and a daring rescue.',1987,NULL,NULL,'Rob Reiner',98,'Movie'),(19,'Dune','Paul Atreides is drawn into a conflict over the desert planet Arrakis.',2021,NULL,NULL,'Denis Villeneuve',155,'Movie'),(20,'Coraline','Coraline discovers a strange parallel world that seems perfect at first.',2009,NULL,NULL,'Henry Selick',100,'Movie');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
INSERT INTO `quiz` VALUES (1,'What mood are you in right now?','Single Choice'),(2,'What kind of story do you want?','Single Choice'),(3,'How fast-paced should the story be?','Single Choice'),(4,'Do you want romance?','Single Choice'),(5,'What kind of ending do you prefer?','Single Choice'),(6,'Would you prefer something magical?','Single Choice'),(7,'Do you want a strong female lead?','Single Choice'),(8,'How dark should the story be?','Single Choice'),(9,'Do you want a story about friendship or family?','Single Choice'),(10,'What kind of adventure are you looking for?','Single Choice');
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'Fantasy','Genre'),(2,'Romance','Genre'),(3,'Adventure','Genre'),(4,'Dystopian','Genre'),(5,'Science Fiction','Genre'),(6,'Drama','Genre'),(7,'Mystery','Genre'),(8,'Horror','Genre'),(9,'Cozy','Mood'),(10,'Whimsical','Mood'),(11,'Dark','Mood'),(12,'Psychological','Mood'),(13,'Bittersweet','Mood'),(14,'Magical','Mood'),(15,'Friendship','Theme'),(16,'Found Family','Theme'),(17,'Coming of Age','Theme'),(18,'Survival','Theme'),(19,'Love','Theme'),(20,'Identity','Theme'),(21,'Slow Burn','Trope'),(22,'Enemies to Lovers','Trope'),(23,'Quest','Trope'),(24,'Strong Female Lead','Trope');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'saima','saima@example.com','demo_hash_001','2026-08-01'),(2,'reader_girl','reader@example.com','demo_hash_002','2026-08-02'),(3,'bookworm','bookworm@example.com','demo_hash_003','2026-08-03'),(4,'moviebuff','moviebuff@example.com','demo_hash_004','2026-08-04'),(5,'storylover','storylover@example.com','demo_hash_005','2026-08-05');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-11  1:24:19
