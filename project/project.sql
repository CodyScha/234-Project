-- MySQL dump 10.13  Distrib 5.7.24, for Win32 (AMD64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `movie`
--

DROP TABLE IF EXISTS `movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movie` (
  `movieId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `releaseYear` int(11) DEFAULT NULL,
  `director` varchar(50) DEFAULT NULL,
  `rating` varchar(5) DEFAULT NULL,
  `poster` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`movieId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie`
--

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;
INSERT INTO `movie` VALUES (1,'Godzilla vs. Kong',2021,'Adam Wingard','PG-13','godzilla_vs_kong_poster.jpg'),(2,'Mortal Kombat',2021,'Simon McQuoid','R','mortal_kombat_poster.jpg'),(3,'Zack Snyder\'s Justice League',2021,'Zack Snyder','R','ZSJL_poster.png');
/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `moderator` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES ('admin','$2y$10$kdA30qD8EzGkWVicea5UsuMyi7kEuTpFkRbf9gaBl4A3HVrbgINIm',1),('codscha','$2y$10$t78ZhIGz5th3jBBJGpLf1ea1IlxF.BNnJZh3AxlYbGI69M1EsK8g.',1),('cody2','$2y$10$CF8eS1L79f4L1ZmfLp1a7uwUMCYSP1.b/fBFUJdMDDIdnsw2IGr0K',0),('cody3','$2y$10$jDUog6DVVlJhONfpykEmOu5CNwQrula9/7qIRxYHFh2DzdNhyHkx.',0),('cody4','$2y$10$bfg8rcC7uoEps75.Qdi8V.JCbVcTb9Gevwa/BbIeNseCPVMSP8NNG',0),('dschaefer','$2y$10$XjPEBoZPYvjtAe7oxLxzNOGa15dznEUJySgwkFl/k8Hf8PY2fS3ri',0),('jeffs','$2y$10$Zhmn29zjcZ3xUffu4MYzmu5D4tcJ38uQ/gYnLsBrx9RMHgeI9WjTW',0),('scorpionfan88','$2y$10$M34KoE20RVQvb2v97ya3Bu7nz7eVUhOtsEMb289OlxBPg.1V1O6v.',0),('test1','$2y$10$FnAo.2SJpQ4m2.PyAuDqA.ERmCpJ49q7DpRhZdtw7H3AZKpGSfSTW',0);
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `reviewId` int(11) NOT NULL AUTO_INCREMENT,
  `numStars` int(11) DEFAULT NULL,
  `typedReview` varchar(240) DEFAULT NULL,
  `movie$Id` int(11) DEFAULT NULL,
  `reviewer` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`reviewId`),
  KEY `movie$Id` (`movie$Id`),
  KEY `reviewer` (`reviewer`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`movie$Id`) REFERENCES `movie` (`movieId`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`reviewer`) REFERENCES `registration` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (32,2,'Bad movie!!!',1,'admin'),(35,1,'This is the worst Mortal Kombat movie they have ever made. I cannot believe they decided to make this. Another franchise lost to a terrible cash grab.',2,'scorpionfan88'),(36,4,'Epic monsters. Epic fights.',1,'scorpionfan88'),(37,3,'Awesome fight scenes. The movie is a little too long, but I was happy with myself for taking the time to watch it.',3,'scorpionfan88'),(38,5,'awesome',1,'dschaefer'),(39,5,'best of the series by far!!',3,'jeffs');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-29 18:27:26
