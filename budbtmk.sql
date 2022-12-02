-- MariaDB dump 10.19  Distrib 10.6.8-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: tmk
-- ------------------------------------------------------
-- Server version	10.6.8-MariaDB

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
-- Table structure for table `tm_comments`
--

DROP TABLE IF EXISTS `tm_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_comments` (
  `rowid` bigint(20) NOT NULL AUTO_INCREMENT,
  `st` varchar(100) NOT NULL,
  `k` varchar(20) NOT NULL,
  `txt` text NOT NULL,
  `n` varchar(50) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(50) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_comments`
--

LOCK TABLES `tm_comments` WRITE;
/*!40000 ALTER TABLE `tm_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_forumd`
--

DROP TABLE IF EXISTS `tm_forumd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_forumd` (
  `rowid` bigint(20) NOT NULL AUTO_INCREMENT,
  `forumid` int(11) NOT NULL,
  `notes` text NOT NULL,
  `attc` int(11) NOT NULL,
  `lastupd` timestamp NOT NULL DEFAULT current_timestamp(),
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`),
  KEY `forumid` (`forumid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_forumd`
--

LOCK TABLES `tm_forumd` WRITE;
/*!40000 ALTER TABLE `tm_forumd` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_forumd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_forums`
--

DROP TABLE IF EXISTS `tm_forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_forums` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `h` varchar(255) NOT NULL,
  `d` text NOT NULL,
  `s` varchar(10) NOT NULL DEFAULT 'open',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(20) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_forums`
--

LOCK TABLES `tm_forums` WRITE;
/*!40000 ALTER TABLE `tm_forums` DISABLE KEYS */;
INSERT INTO `tm_forums` VALUES (1,'a','a','open','2022-10-02 22:40:08','a','2022-10-03 05:40:08','a');
/*!40000 ALTER TABLE `tm_forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_ips`
--

DROP TABLE IF EXISTS `tm_ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_ips` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` varchar(20) NOT NULL,
  `sid` varchar(20) NOT NULL,
  `layanan` varchar(20) NOT NULL,
  `iplan` varchar(20) NOT NULL,
  `ipwan` varchar(20) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`),
  UNIQUE KEY `sid` (`sid`),
  UNIQUE KEY `oid_layanan` (`oid`,`layanan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_ips`
--

LOCK TABLES `tm_ips` WRITE;
/*!40000 ALTER TABLE `tm_ips` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_ips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_kanwils`
--

DROP TABLE IF EXISTS `tm_kanwils`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_kanwils` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `locid` varchar(20) NOT NULL,
  `locname` varchar(100) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`),
  UNIQUE KEY `locid` (`locid`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_kanwils`
--

LOCK TABLES `tm_kanwils` WRITE;
/*!40000 ALTER TABLE `tm_kanwils` DISABLE KEYS */;
INSERT INTO `tm_kanwils` VALUES (41,'Ged Serbaguna','Ged Serbaguna L1','2022-10-02 22:03:54','a'),(44,'G.Disinfolahta L2 DC','Gedung Disinfolahta L2 DC','2022-10-02 22:55:37','a'),(45,'G.Disinfolahta L1','Gedung Disinfolahta L1','2022-10-02 22:55:22','a'),(46,'G.Disinfolahta L3','Gedung Disinfolahta L3','2022-10-02 22:55:47','a'),(47,'G.Disinfolahta L2','Gedung Disinfolahta L2','2022-10-02 22:56:17','a');
/*!40000 ALTER TABLE `tm_kanwils` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_kanwilusers`
--

DROP TABLE IF EXISTS `tm_kanwilusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_kanwilusers` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `kanwil` varchar(20) NOT NULL,
  `user` varchar(20) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_kanwilusers`
--

LOCK TABLES `tm_kanwilusers` WRITE;
/*!40000 ALTER TABLE `tm_kanwilusers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_kanwilusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_notes`
--

DROP TABLE IF EXISTS `tm_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_notes` (
  `rowid` bigint(20) NOT NULL AUTO_INCREMENT,
  `ticketid` bigint(20) NOT NULL,
  `attc` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  `s` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`rowid`),
  KEY `ticketid` (`ticketid`)
) ENGINE=InnoDB AUTO_INCREMENT=11127 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_notes`
--

LOCK TABLES `tm_notes` WRITE;
/*!40000 ALTER TABLE `tm_notes` DISABLE KEYS */;
INSERT INTO `tm_notes` VALUES (11117,20220829025700,'','ohaii','2022-08-29 11:53:31','a','new'),(11118,20220829025700,'','proggg','2022-08-29 11:53:51','a','progress'),(11119,20221002053915,'','progress','2022-10-02 12:39:50','a','progress'),(11120,20221002220557,'','a','2022-10-02 22:07:43','a','new'),(11121,20221002220557,'','done','2022-10-02 22:45:26','tniad','closed'),(11122,20221002230157,'','router to switch prob','2022-10-02 23:04:08','a','new'),(11123,20221007132937,'','on check','2022-10-07 13:31:45','a','progress'),(11124,20221007132937,'','modem loss','2022-10-07 13:32:33','a','pending'),(11125,20221007132937,'','silahkan cek kembali','2022-10-07 13:33:25','a','solved'),(11126,20221002230157,'','a','2022-10-18 09:54:18','a','closed');
/*!40000 ALTER TABLE `tm_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_outlets`
--

DROP TABLE IF EXISTS `tm_outlets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_outlets` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` varchar(20) NOT NULL,
  `oname` varchar(50) NOT NULL,
  `cabang` varchar(50) DEFAULT NULL,
  `kanwil` varchar(20) NOT NULL,
  `area` varchar(50) DEFAULT NULL,
  `ipwan` varchar(20) NOT NULL,
  `iplan` varchar(20) NOT NULL,
  `sid` varchar(30) NOT NULL,
  `pic` varchar(50) DEFAULT NULL,
  `pic2` varchar(50) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `contact2` varchar(100) DEFAULT NULL,
  `lnk` varchar(50) DEFAULT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(50) DEFAULT NULL,
  `bw` varchar(10) NOT NULL,
  `ket` varchar(254) NOT NULL,
  PRIMARY KEY (`rowid`),
  UNIQUE KEY `oid` (`oid`)
) ENGINE=InnoDB AUTO_INCREMENT=1179 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_outlets`
--

LOCK TABLES `tm_outlets` WRITE;
/*!40000 ALTER TABLE `tm_outlets` DISABLE KEYS */;
INSERT INTO `tm_outlets` VALUES (1169,'88888','sjdf',NULL,'1',NULL,'klsjdf','kljsdf','lksjdflksdf','','','','',NULL,'2022-08-26 16:56:25','a','ljsdlkf','sdfj'),(1170,'3333','1',NULL,'1',NULL,'2','1','1111','','','','',NULL,'2022-10-02 12:38:01','a','1','1'),(1171,'434234','234',NULL,'3',NULL,'23423','234','234','','','','',NULL,'2022-10-02 12:39:03','a','23423','4'),(1172,'AP Gedung Serbaguan','Ged Serbaguna AP1 L1',NULL,'Ged Serbaguna',NULL,'','','','','','','',NULL,'2022-10-02 22:05:28','a','',''),(1173,'SW CORE NORTH','SW CORE NORTH',NULL,'G.Disinfolahta L2 DC',NULL,'','','','','','','',NULL,'2022-10-02 22:57:55','a','',''),(1175,'SW CORE SOUTH','SW CORE SOUTH',NULL,'G.Disinfolahta L2 DC',NULL,'','','','','','','',NULL,'2022-10-02 22:58:29','a','',''),(1176,'ROUTER NORTH','ROUTER NORTH',NULL,'G.Disinfolahta L2 DC',NULL,'','','','','','','',NULL,'2022-10-02 22:59:13','a','',''),(1177,'SERVER','SERVER NMS',NULL,'G.Disinfolahta L2 DC',NULL,'','','','','','','',NULL,'2022-10-02 22:59:44','a','',''),(1178,'G1QH6E9000606','G.Disinfo L1/AP1',NULL,'G.Disinfolahta L1',NULL,'','','','','','','',NULL,'2022-10-02 23:01:24','a','','');
/*!40000 ALTER TABLE `tm_outlets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_problems`
--

DROP TABLE IF EXISTS `tm_problems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_problems` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `probid` varchar(20) NOT NULL,
  `probname` varchar(50) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`),
  UNIQUE KEY `problem` (`probid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_problems`
--

LOCK TABLES `tm_problems` WRITE;
/*!40000 ALTER TABLE `tm_problems` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_problems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_survey`
--

DROP TABLE IF EXISTS `tm_survey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_survey` (
  `rowid` bigint(20) NOT NULL AUTO_INCREMENT,
  `survid` int(11) NOT NULL,
  `srt` varchar(10) NOT NULL,
  `g` varchar(50) NOT NULL,
  `q` text NOT NULL,
  `score` varchar(20) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`),
  KEY `survid` (`survid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_survey`
--

LOCK TABLES `tm_survey` WRITE;
/*!40000 ALTER TABLE `tm_survey` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_survey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_surveyresult`
--

DROP TABLE IF EXISTS `tm_surveyresult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_surveyresult` (
  `rowid` bigint(20) NOT NULL AUTO_INCREMENT,
  `survid` int(11) NOT NULL,
  `qid` bigint(20) NOT NULL,
  `v` varchar(2) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_surveyresult`
--

LOCK TABLES `tm_surveyresult` WRITE;
/*!40000 ALTER TABLE `tm_surveyresult` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_surveyresult` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_surveys`
--

DROP TABLE IF EXISTS `tm_surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_surveys` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `n` varchar(100) NOT NULL,
  `df` date NOT NULL,
  `dt` date NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_surveys`
--

LOCK TABLES `tm_surveys` WRITE;
/*!40000 ALTER TABLE `tm_surveys` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tickets`
--

DROP TABLE IF EXISTS `tm_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tickets` (
  `rowid` bigint(20) NOT NULL,
  `ticketno` bigint(20) NOT NULL,
  `createdby` varchar(20) NOT NULL,
  `dtm` datetime NOT NULL,
  `dt` datetime NOT NULL,
  `h` varchar(100) NOT NULL,
  `d` text NOT NULL,
  `i` varchar(20) NOT NULL,
  `k` varchar(20) NOT NULL,
  `grp` varchar(20) DEFAULT 'link',
  `typ` varchar(20) DEFAULT 'offline',
  `st` varchar(20) NOT NULL DEFAULT '',
  `p` varchar(20) DEFAULT '',
  `s` varchar(20) NOT NULL DEFAULT 'new',
  `o` varchar(1) NOT NULL DEFAULT '1',
  `solving` text DEFAULT NULL,
  `blink` varchar(30) NOT NULL DEFAULT '-',
  `bdtm` datetime DEFAULT NULL,
  `solved` datetime DEFAULT NULL,
  `closed` datetime DEFAULT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  `l` varchar(100) DEFAULT '',
  `jp` varchar(250) NOT NULL DEFAULT '',
  `sn` varchar(100) DEFAULT '',
  `tp` varchar(100) DEFAULT '',
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tickets`
--

LOCK TABLES `tm_tickets` WRITE;
/*!40000 ALTER TABLE `tm_tickets` DISABLE KEYS */;
INSERT INTO `tm_tickets` VALUES (20221002053915,20221002053915,'a','2022-10-02 12:39:15','2022-10-02 12:39:15','234','12','434234','3','aplikasi','psb','','','progress','0',NULL,'-',NULL,NULL,NULL,'2022-10-02 12:39:50','a','','','',''),(20221002220557,20221002220557,'a','2022-10-02 22:05:57','2022-10-02 22:05:57','Ged Serbaguna AP1 L1','offline','AP Gedung Serbaguan','Ged Serbaguna','cpe','offline','','','closed','0',NULL,'-',NULL,NULL,'2022-10-02 22:45:26','2022-10-02 22:45:26','tniad','','','',''),(20221002230157,20221002230157,'a','2022-10-02 23:01:57','2022-10-02 23:01:57','SW CORE SOUTH','offline','SW CORE SOUTH','G.Disinfolahta L2 DC','cpe','pengecekan router','router/switch/ip-phn','','closed','0',NULL,'-',NULL,NULL,'2022-10-18 09:54:18','2022-10-18 09:54:18','a','','','',''),(20221007132937,20221007132937,'a','2022-10-07 13:29:37','2022-10-07 13:29:37','G.Disinfo L1/AP1','Tidak bisa login','G1QH6E9000606','G.Disinfolahta L1','link','fo reposisi','wifi station','','solved','1',NULL,'-',NULL,'2022-10-07 13:33:25',NULL,'2022-10-07 13:33:25','a','','','','');
/*!40000 ALTER TABLE `tm_tickets` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `bu_tickets` BEFORE UPDATE ON `tm_tickets` FOR EACH ROW BEGIN 
IF NEW.s<>OLD.s AND NEW.s='solved' THEN 
SET NEW.solved=NOW(); 
END IF; 
IF NEW.s<>OLD.s AND NEW.s='closed' THEN 
SET NEW.closed=NOW(); 
END IF;
IF (NEW.s<>OLD.s AND (NEW.s='solved' OR NEW.s='open')) OR NEW.s='new' THEN
SET NEW.o='1';
ELSE
SET NEW.o='0';
END IF;
IF NEW.blink<>'-' AND NEW.blink<>OLD.blink AND OLD.bdtm IS NULL THEN
SET NEW.bdtm = NOW();
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tm_timers`
--

DROP TABLE IF EXISTS `tm_timers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_timers` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `grp` varchar(20) NOT NULL,
  `typ` varchar(20) NOT NULL,
  `mnt` int(11) NOT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_timers`
--

LOCK TABLES `tm_timers` WRITE;
/*!40000 ALTER TABLE `tm_timers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_timers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_users`
--

DROP TABLE IF EXISTS `tm_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_users` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) CHARACTER SET latin1 NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `userpwd` varchar(100) CHARACTER SET latin1 NOT NULL,
  `userlevel` smallint(6) NOT NULL,
  `usergrp` varchar(20) NOT NULL,
  `usermail` varchar(100) NOT NULL,
  `userloc` varchar(20) DEFAULT NULL,
  `userphone` varchar(30) DEFAULT NULL,
  `lastupd` datetime NOT NULL,
  `updby` varchar(20) NOT NULL,
  `isactive` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`rowid`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_users`
--

LOCK TABLES `tm_users` WRITE;
/*!40000 ALTER TABLE `tm_users` DISABLE KEYS */;
INSERT INTO `tm_users` VALUES (107,'a','default','0cc175b9c0f1b6a831c399e269772661',0,'','','','','2022-08-26 11:26:02','sys','Y');
/*!40000 ALTER TABLE `tm_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-02 15:12:36
