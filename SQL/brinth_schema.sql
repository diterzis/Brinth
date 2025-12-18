-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: brinthgame
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `brinth_clubs_ctc`
--
DROP TABLE IF EXISTS `brinth_clubs_ctc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brinth_clubs_ctc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_code` varchar(16) DEFAULT NULL,
  `comb1` char(3) NOT NULL,
  `hint1` varchar(100) DEFAULT NULL,
  `comb2` char(3) NOT NULL,
  `hint2` varchar(100) DEFAULT NULL,
  `comb3` char(3) NOT NULL,
  `hint3` varchar(100) DEFAULT NULL,
  `comb4` char(3) NOT NULL,
  `hint4` varchar(100) DEFAULT NULL,
  `comb5` char(3) NOT NULL,
  `hint5` varchar(100) DEFAULT NULL,
  `correct` char(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_code` (`game_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brinth_clubs_hangman`
--
DROP TABLE IF EXISTS `brinth_clubs_hangman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brinth_clubs_hangman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_code` varchar(16) DEFAULT NULL,
  `hint` varchar(100) DEFAULT NULL,
  `answer` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_code` (`game_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brinth_diamonds`
--
DROP TABLE IF EXISTS `brinth_diamonds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brinth_diamonds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_code` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `clues_images` json DEFAULT NULL,
  `clues_texts` json DEFAULT NULL,
  `fields` json NOT NULL,
  `correct` json NOT NULL,
  `solution` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_code` (`game_code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brinth_hearts`
--
DROP TABLE IF EXISTS `brinth_hearts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brinth_hearts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `door1_image` varchar(255) NOT NULL,
  `door2_image` varchar(255) NOT NULL,
  `correct` enum('door1','door2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brinth_spades`
--
DROP TABLE IF EXISTS `brinth_spades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brinth_spades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_code` varchar(16) DEFAULT NULL,
  `question` text,
  `a` text,
  `b` text,
  `c` text,
  `d` text,
  `correct` char(1) DEFAULT NULL,
  `game_title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `guest_reports`
--
DROP TABLE IF EXISTS `guest_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guest_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `guest_reports_ibfk_1` FOREIGN KEY (`username`) REFERENCES `playerinfo` (`username`),
  CONSTRAINT `guest_reports_ibfk_2` FOREIGN KEY (`username`) REFERENCES `playerinfo` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `played_minigames`
--
DROP TABLE IF EXISTS `played_minigames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `played_minigames` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `game_code` varchar(16) DEFAULT NULL,
  `played_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `game_code` (`game_code`),
  CONSTRAINT `played_minigames_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `playerinfo` (`id`),
  CONSTRAINT `played_minigames_ibfk_2` FOREIGN KEY (`game_code`) REFERENCES `brinth_clubs_ctc` (`game_code`),
  CONSTRAINT `played_minigames_ibfk_3` FOREIGN KEY (`game_code`) REFERENCES `brinth_diamonds` (`game_code`)
) ENGINE=InnoDB AUTO_INCREMENT=488 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `playerinfo`
--
DROP TABLE IF EXISTS `playerinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playerinfo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(25) DEFAULT 'Unclassified',
  `savior_card` int DEFAULT '3',
  `xp` int DEFAULT '0',
  `games_won` int DEFAULT '0',
  `games_lost` int DEFAULT '0',
  `games_played` int DEFAULT '0',
  `email_ver` varchar(20) DEFAULT 'Not Verified',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_reports`
--
DROP TABLE IF EXISTS `user_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `playerinfo` (`id`),
  CONSTRAINT `user_reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `playerinfo` (`id`),
  CONSTRAINT `user_reports_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `playerinfo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-02 11:28:48
