-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: banco
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuenta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idPersona` int NOT NULL,
  `tipoCuenta` varchar(50) NOT NULL,
  `numeroCuenta` int NOT NULL,
  `ultimoMovimiento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaRegistro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigoSeguridad` int NOT NULL,
  `saldoDisponible` float NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numeroCuenta` (`numeroCuenta`),
  KEY `fk_persona` (`idPersona`),
  CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`id`),
  CONSTRAINT `fk_persona` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta`
--

LOCK TABLES `cuenta` WRITE;
/*!40000 ALTER TABLE `cuenta` DISABLE KEYS */;
INSERT INTO `cuenta` VALUES (1,1,'Ahorros',123456789,'2020-05-19 07:45:15','2017-01-01 00:00:00',1234,60500,'franma.martinez19@gmail.com'),(2,1,'Corriente',987654321,'2020-05-19 07:45:15','2022-09-21 00:00:00',1212,12000,'franma.martinez19@gmail.com'),(3,2,'Corriente',192837465,'2022-09-25 10:05:00','2022-09-25 00:00:00',1111,45670,'jorge@mail.com'),(4,6,'Ahorros',129834765,'2022-09-25 10:05:00','2015-03-21 00:00:00',2222,143250,'nataly@gmail.com');
/*!40000 ALTER TABLE `cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` int NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identificacion` (`identificacion`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,1003189162,'Francisco','Martinez Torreglosa'),(2,1003189160,'Jorge Mario','Martinez Torreglosa'),(4,189189189,'Alfonso','Campos Rodriguez'),(5,162162162,'Maria Elena','Diaz Dominguez'),(6,1007198178,'Nataly Andrea','Bedoya Arroyo'),(12,10011001,'nombres de','prueba insertar');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'banco'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-01 13:52:24
