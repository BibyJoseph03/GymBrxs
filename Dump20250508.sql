-- MySQL dump 10.13  Distrib 8.0.41, for macos15 (x86_64)
--
-- Host: 127.0.0.1    Database: gymbrxs_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gym_id` int(11) NOT NULL,
  PRIMARY KEY (`favorite_id`),
  UNIQUE KEY `user_id` (`user_id`,`gym_id`),
  KEY `gym_id` (`gym_id`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`gym_id`) REFERENCES `gyms` (`gym_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (4,1,1),(3,1,6),(1,1,7),(5,1,8),(6,1,9),(10,3,9),(11,3,10),(9,3,11);
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gyms`
--

DROP TABLE IF EXISTS `gyms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gyms` (
  `gym_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`gym_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gyms`
--

LOCK TABLES `gyms` WRITE;
/*!40000 ALTER TABLE `gyms` DISABLE KEYS */;
INSERT INTO `gyms` VALUES (1,'BMCC Fitness Center','199 Chambers St, NY, NY','Weights, Cardio',4.30,40.7128000,-74.0060000,0),(2,'NYSC YMCA Tribeca','75 Murray St, NY, NY','Pool, Classes',4.50,NULL,NULL,0),(3,'Equinox Tribeca','97 Leonard St, NY, NY','Spa, Yoga, Cycling',4.70,NULL,NULL,0),(4,'Planet Fitness Tribeca','12 Harrison St, NY, NY','Cardio, Weights',4.00,NULL,NULL,0),(5,'Retro Fitness','166 John St, NY, NY','Classes, Free Weights',4.20,NULL,NULL,0),(6,'Planet Fitness','370 Canal St, New York, NY 10013, USA','',4.00,40.7206893,-74.0043600,0),(7,'Blink Fitness Noho','16 E 4th St, New York, NY 10012, USA','',2.30,40.7286195,-73.9938757,0),(8,'Blink Fitness East Village','98 Avenue A, New York, NY 10009, USA','',4.50,40.7256681,-73.9835690,0),(9,'Blink Fitness Williamsburg','287 Broadway, Brooklyn, NY 11211, USA','',0.00,40.7087446,-73.9583246,0),(10,'Planet Fitness','777 Broadway, Brooklyn, NY 11206, USA','',4.10,40.7003127,-73.9407652,NULL),(11,'Blink Fitness Queens Village','220-05 Hillside Ave., Queens, NY 11427, USA','',3.60,40.7311665,-73.7442878,NULL);
/*!40000 ALTER TABLE `gyms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `occupancy`
--

DROP TABLE IF EXISTS `occupancy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `occupancy` (
  `occ_id` int(11) NOT NULL AUTO_INCREMENT,
  `gym_id` int(11) NOT NULL,
  `current_occupancy` int(11) NOT NULL,
  `time_checked` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`occ_id`),
  KEY `gym_id` (`gym_id`),
  CONSTRAINT `occupancy_ibfk_1` FOREIGN KEY (`gym_id`) REFERENCES `gyms` (`gym_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `occupancy`
--

LOCK TABLES `occupancy` WRITE;
/*!40000 ALTER TABLE `occupancy` DISABLE KEYS */;
INSERT INTO `occupancy` VALUES (1,1,25,'2025-05-06 16:19:19'),(2,2,68,'2025-05-06 16:19:19'),(3,3,45,'2025-05-06 16:19:19'),(4,4,80,'2025-05-06 16:19:19'),(5,5,55,'2025-05-06 16:19:19');
/*!40000 ALTER TABLE `occupancy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `available_hours` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Matthew','mmoctezuma101@gmail.com','$2y$10$OqYGLyZQa1BmYanH/mi3MuyQvwBUpqEo2kOMrZ1iVBW1qcYUnDlD2','12-2','bcc'),(2,'Mark','markm101@gmail.com','$2y$10$D.Dldoz1a4CeZkYfatFvX.U1p98oDfGjD1AXp/HBZRiGbIwdf5icS',NULL,NULL),(3,'Jeff Joseph','jjeffjoseph@gmail.com','$2y$10$Al460PZPZvKc/3Vex0UGb.uZQRTE.ryVemNeSXsK0epEJWZistToq','7pm','Brooklyn'),(4,'Darrell Moreno','dmoreno@gmail.com','$2y$10$ZC/VVJQ5.aiB3Ru3vsd5YexbY3/k.0QjMwrmcTLs22CnSmQI2SapK',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-08 18:12:49
