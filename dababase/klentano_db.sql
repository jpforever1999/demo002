-- MySQL dump 10.16  Distrib 10.1.45-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: klentano_db
-- ------------------------------------------------------
-- Server version	10.1.45-MariaDB

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (19,'jay1','jay1',1),(20,'test1','test1',1),(35,'test2','test2',1),(36,'aaa','aaa',1),(37,'dddd','dddd',1),(38,'test5','test5',1),(39,'testq','testq',1),(40,'testqqq','testqqq',1),(41,'EEEqqq','eeeqqq',1),(42,'amit001','amit001',1),(43,'amit003','amit003',1),(44,'new_cat001','new_cat001',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_admin`
--

DROP TABLE IF EXISTS `ec_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_uid` char(13) NOT NULL,
  `super_admin` int(11) DEFAULT '0',
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password` varchar(34) NOT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_uid` (`admin_uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_admin`
--

LOCK TABLES `ec_admin` WRITE;
/*!40000 ALTER TABLE `ec_admin` DISABLE KEYS */;
INSERT INTO `ec_admin` VALUES (1,'5ece4797eaf5e',1,'Neeraj','Diwakar','neerajdiwakar@gmail.com','9868659088','c4ca4238a0b923820dcc509a6f75849b','1','2020-11-20 15:00:53','2020-11-27 13:09:56'),(2,'',0,'panga1','kumar12','neeraj@move2inbox.in','9876543210','c4ca4238a0b923820dcc509a6f75849b','1','2020-11-27 18:14:57','2020-12-07 16:16:30');
/*!40000 ALTER TABLE `ec_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_admin_password_reset`
--

DROP TABLE IF EXISTS `ec_admin_password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_admin_password_reset` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `reset_key` char(40) NOT NULL,
  `ip_address` char(15) DEFAULT NULL,
  `status` char(15) NOT NULL DEFAULT 'active',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`request_id`),
  KEY `admin_id` (`admin_id`),
  KEY `reset_key` (`reset_key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_admin_password_reset`
--

LOCK TABLES `ec_admin_password_reset` WRITE;
/*!40000 ALTER TABLE `ec_admin_password_reset` DISABLE KEYS */;
INSERT INTO `ec_admin_password_reset` VALUES (1,1,'cc9d89bdd4a5eef0eb5fcd345d6572ea','192.168.1.98','reset','2020-11-23 11:25:16','2020-11-23 11:59:30'),(2,1,'8e4e3de1d35e40c32c7bc1a5bf319ce1','192.168.1.98','reset','2020-11-23 11:25:49','2020-11-23 11:59:30');
/*!40000 ALTER TABLE `ec_admin_password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_admin_session`
--

DROP TABLE IF EXISTS `ec_admin_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_admin_session` (
  `id` varchar(40) NOT NULL,
  `login_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `timestamp` (`timestamp`),
  KEY `login_id` (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_admin_session`
--

LOCK TABLES `ec_admin_session` WRITE;
/*!40000 ALTER TABLE `ec_admin_session` DISABLE KEYS */;
INSERT INTO `ec_admin_session` VALUES ('rnts5f43om3nrr63ko0rcu016b43of14',1,'192.168.1.109',1608542720,'__ci_last_regenerate|i:1608542720;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('g664jb0c291p92e5juav4ehjrpt7lqgf',1,'192.168.1.109',1608543044,'__ci_last_regenerate|i:1608543044;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('fmk2qjnobf0ssp72nh379u0a9orhjcsk',1,'192.168.1.109',1608543379,'__ci_last_regenerate|i:1608543379;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('i5mh07m5edaorrn37bti88iufp5thofc',1,'192.168.1.109',1608543881,'__ci_last_regenerate|i:1608543881;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('bdfndjklo9u1popa0efjsk3oubo6jk0d',1,'192.168.1.109',1608544223,'__ci_last_regenerate|i:1608544223;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('74grg4hb0euqjv0g35n69db9jhvdh6m2',1,'192.168.1.109',1608544721,'__ci_last_regenerate|i:1608544721;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('tfsqg838l9md7s2k2mk883g2neb4fb0d',1,'192.168.1.109',1608545316,'__ci_last_regenerate|i:1608545316;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('arl6rh5mopf7dh4vbkvpeolu62106u1c',1,'192.168.1.109',1608545674,'__ci_last_regenerate|i:1608545674;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('qvnhqec19kmh4062oao3sfefj2rod7dk',1,'192.168.1.109',1608546079,'__ci_last_regenerate|i:1608546079;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('3unciri4flhrd87dusepjpf6o0h8uj3g',1,'192.168.1.109',1608547623,'__ci_last_regenerate|i:1608547623;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('9k14suo0ct2997gqft10ol6jc4lrvc5f',1,'192.168.1.109',1608547960,'__ci_last_regenerate|i:1608547960;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('2cp4dp83sv3ivtnb6kgtf6rperqb0502',1,'192.168.1.109',1608548611,'__ci_last_regenerate|i:1608548611;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('9l180dadhgc1gahut87d6qc7ufgl05s0',1,'192.168.1.109',1608549671,'__ci_last_regenerate|i:1608549671;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('a2mf8q94b3mnv86mb1tuh2ea8t5nkq2u',1,'192.168.1.97',1608549423,'__ci_last_regenerate|i:1608549423;type|s:5:\"admin\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";'),('j3bbdpjljpq97mm7dmmuaea00jck9t5f',1,'192.168.1.97',1608549615,'__ci_last_regenerate|i:1608549423;type|s:5:\"admin\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";'),('snb7fdq9778d0hciuu9ojev7bqu5tsi0',1,'192.168.1.109',1608549996,'__ci_last_regenerate|i:1608549996;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('pqnksqm283kgkfbke1sc88daleukcsuk',1,'192.168.1.109',1608550979,'__ci_last_regenerate|i:1608550979;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('cfkb8cu06cvoelfhtnrs1bnatt70us7h',1,'192.168.1.109',1608555547,'__ci_last_regenerate|i:1608555547;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/75\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('igguep44dfj03h9j2dhcb2i7hgo47hrb',1,'192.168.1.95',1608556266,'__ci_last_regenerate|i:1608556266;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/75\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('06amma9aaqp7hihsv46kec4pqhan763d',1,'192.168.1.95',1608556700,'__ci_last_regenerate|i:1608556700;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/75\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('n92f6vqvjp6koorvviade3f42aclifhh',1,'192.168.1.95',1608557100,'__ci_last_regenerate|i:1608557100;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/75\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('mhn178a9t2ub9n1i5eqkf210ka49ouuv',1,'192.168.1.95',1608557584,'__ci_last_regenerate|i:1608557584;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/75\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('u9fa064slhon9lsbmvj3incuv44vts1u',1,'192.168.1.95',1608557887,'__ci_last_regenerate|i:1608557887;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('eksaui27htenld8qurie7qca4ufaljo3',1,'192.168.1.95',1608558324,'__ci_last_regenerate|i:1608558324;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('76vb1mhrb9i7ebcorquvjf5fa6ohnabk',1,'192.168.1.95',1608558647,'__ci_last_regenerate|i:1608558647;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('r55e5etasi5ba1ubcilg7ge69o0na162',1,'192.168.1.109',1608558769,'__ci_last_regenerate|i:1608558647;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('p8jagan1148rbddsp13097d2m0np8hkt',1,'192.168.1.95',1608614143,'__ci_last_regenerate|i:1608614143;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('uknt827hktj2d4t5vlf6e0jpsfkfvgek',1,'192.168.1.95',1608614445,'__ci_last_regenerate|i:1608614445;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('q32bmevlrpt544brslg1f9nrphlslh1l',1,'192.168.1.95',1608614790,'__ci_last_regenerate|i:1608614790;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('0s5llfc30uk5oh470jpgspgenpor4j4j',1,'192.168.1.95',1608615125,'__ci_last_regenerate|i:1608615125;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/77\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('gc7inaf4ivledjsh2aeo2o7phqnl0fdd',1,'192.168.1.95',1608615628,'__ci_last_regenerate|i:1608615628;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('sg9egd8o1hqs2p3dpa1nidmdk0vog7hh',1,'192.168.1.95',1608615941,'__ci_last_regenerate|i:1608615941;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('j64lgi9jakec90im1p47gjliuaopdrsk',1,'192.168.1.95',1608616417,'__ci_last_regenerate|i:1608616417;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/78\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('3d6ikhn5bn55oege7s2m3nfrm37p982j',1,'192.168.1.95',1608616867,'__ci_last_regenerate|i:1608616867;type|s:5:\"admin\";previous_url|s:42:\"http://klentano.msdev.in/admin/product/add\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('qekdv1ai99u8ekhlet5clv4rmelvk6bc',1,'192.168.1.95',1608617183,'__ci_last_regenerate|i:1608617183;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/78\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('k3i1j258sj9ndfdi0v8uuahelmuq7604',1,'192.168.1.95',1608617488,'__ci_last_regenerate|i:1608617488;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/78\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('phs18elhncdq91v7nr8lsavsg6t52l56',1,'192.168.1.95',1608617863,'__ci_last_regenerate|i:1608617863;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/78\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('v3pg0jkpf5nc3an4tljj54e3aeto0r8u',1,'192.168.1.95',1608618181,'__ci_last_regenerate|i:1608618181;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('5kqr68jqstgo7a54i2t8mmqmnet7k6ed',1,'192.168.1.95',1608618505,'__ci_last_regenerate|i:1608618505;type|s:5:\"admin\";previous_url|s:47:\"http://klentano.msdev.in/admin/Product/get_attr\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('ujh3c0jpieqdu8143s91ig85pu1tme23',1,'192.168.1.95',1608619033,'__ci_last_regenerate|i:1608619033;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('o8c87thm85hhb5utnodptdg7b889dh2j',1,'192.168.1.95',1608620027,'__ci_last_regenerate|i:1608620027;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('imbevdi1c8se9vm2r8v94nc32kolv9ss',1,'192.168.1.95',1608620358,'__ci_last_regenerate|i:1608620358;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('v9hfa1s3vs6c29411ksbihq7se46e1t2',1,'192.168.1.95',1608620665,'__ci_last_regenerate|i:1608620665;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('mdg1dh13dfm8fp3137sr1bja82od9n53',1,'192.168.1.95',1608621581,'__ci_last_regenerate|i:1608621581;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('0u021mumgkrv25vi50b1k8kc4rd6fi5a',1,'192.168.1.95',1608621886,'__ci_last_regenerate|i:1608621886;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('l8l0f09eej1clbi3j5jdl6ecc9j4hi56',1,'192.168.1.95',1608622240,'__ci_last_regenerate|i:1608622240;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('8d6ecnk4lrvr948uflqrlae5p8rj9hel',1,'192.168.1.95',1608622653,'__ci_last_regenerate|i:1608622653;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('c4fihsd7aolvo37qvp3t0c0v2tfd8mrt',1,'192.168.1.95',1608622984,'__ci_last_regenerate|i:1608622984;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('775i3330bcfal1n7t8a91g1m6oo1mi6d',1,'192.168.1.95',1608623332,'__ci_last_regenerate|i:1608623332;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('88gckdjtise4s8utp2ll59pd482oul0t',1,'192.168.1.95',1608623497,'__ci_last_regenerate|i:1608623332;type|s:5:\"admin\";previous_url|s:48:\"http://klentano.msdev.in/admin/product/update/79\";admin|a:5:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:6:\"Neeraj\";s:8:\"login_id\";s:1:\"1\";s:11:\"super_admin\";s:1:\"1\";s:9:\"logged_in\";b:1;}');
/*!40000 ALTER TABLE `ec_admin_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_attribute`
--

DROP TABLE IF EXISTS `ec_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_attribute`
--

LOCK TABLES `ec_attribute` WRITE;
/*!40000 ALTER TABLE `ec_attribute` DISABLE KEYS */;
INSERT INTO `ec_attribute` VALUES (1,'Colour','colour','','1','2020-11-26 16:04:41','2020-11-26 16:04:41'),(2,'Size','size','','1','2020-11-26 16:04:53','2020-12-14 15:36:00'),(3,'Weight','weight','Weight','1','2020-12-17 19:04:01','2020-12-17 19:04:01');
/*!40000 ALTER TABLE `ec_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_attribute_item`
--

DROP TABLE IF EXISTS `ec_attribute_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_attribute_item` (
  `attribute_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`attribute_item_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_attribute_item`
--

LOCK TABLES `ec_attribute_item` WRITE;
/*!40000 ALTER TABLE `ec_attribute_item` DISABLE KEYS */;
INSERT INTO `ec_attribute_item` VALUES (1,1,'Red','red','','1','2020-11-27 12:37:51','2020-11-27 12:59:27'),(2,1,'Black','black','','1','2020-11-27 12:46:07','2020-11-27 12:46:07'),(3,1,'Yellow','yellow','','1','2020-11-27 12:46:29','2020-11-27 12:46:29'),(4,1,'Blue','blue','','1','2020-11-27 12:46:47','2020-11-27 12:46:47'),(5,1,'White','white','','1','2020-11-27 12:47:13','2020-11-27 12:47:13'),(6,2,'Samll','S','','1','2020-11-27 13:00:57','2020-11-27 13:00:57'),(7,2,'Medium','M','','1','2020-11-27 13:01:42','2020-11-27 13:01:42'),(8,2,'Large','L','','1','2020-11-27 13:02:07','2020-11-27 13:02:07'),(9,2,'Extra Large','XL','','1','2020-11-27 13:02:26','2020-11-27 13:02:26'),(10,2,'xxxlarge','xxxlarge','','1','2020-12-14 17:06:43','2020-12-14 17:06:43'),(11,2,'qqqqq','qqqqq','ffffffffffff','1','2020-12-15 16:20:54','2020-12-15 16:20:54'),(12,3,'10','10','10','1','2020-12-17 19:13:51','2020-12-17 19:13:51');
/*!40000 ALTER TABLE `ec_attribute_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_attribute_relationship`
--

DROP TABLE IF EXISTS `ec_attribute_relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_attribute_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_categories_categories1` (`attribute_item_id`),
  KEY `fk_posts_categories_posts1` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_attribute_relationship`
--

LOCK TABLES `ec_attribute_relationship` WRITE;
/*!40000 ALTER TABLE `ec_attribute_relationship` DISABLE KEYS */;
INSERT INTO `ec_attribute_relationship` VALUES (58,76,4),(59,76,9),(60,77,3),(61,77,4),(62,77,12),(63,77,7),(64,77,10),(65,78,2),(66,78,3),(67,79,7),(68,79,9),(69,79,10),(70,79,2);
/*!40000 ALTER TABLE `ec_attribute_relationship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_categories_prod`
--

DROP TABLE IF EXISTS `ec_categories_prod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_categories_prod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_categories_prod`
--

LOCK TABLES `ec_categories_prod` WRITE;
/*!40000 ALTER TABLE `ec_categories_prod` DISABLE KEYS */;
INSERT INTO `ec_categories_prod` VALUES (19,'test1','test1',1),(20,'test2-1','test2-1',1);
/*!40000 ALTER TABLE `ec_categories_prod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_company_session`
--

DROP TABLE IF EXISTS `ec_company_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_company_session` (
  `id` varchar(40) NOT NULL,
  `login_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `timestamp` (`timestamp`),
  KEY `login_id` (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_company_session`
--

LOCK TABLES `ec_company_session` WRITE;
/*!40000 ALTER TABLE `ec_company_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_company_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_country`
--

DROP TABLE IF EXISTS `ec_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_country`
--

LOCK TABLES `ec_country` WRITE;
/*!40000 ALTER TABLE `ec_country` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_coupon`
--

DROP TABLE IF EXISTS `ec_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_coupon`
--

LOCK TABLES `ec_coupon` WRITE;
/*!40000 ALTER TABLE `ec_coupon` DISABLE KEYS */;
INSERT INTO `ec_coupon` VALUES (1,'diwali','hiiiiiiiiiiiiiiiiiiiiii','11','2020-11-24 13:00:00','2020-11-26 13:00:00',2,'1','2020-11-24 12:51:33','2020-11-24 12:51:53'),(2,'qwert','','12','2020-11-24 16:00:00','2020-11-27 16:00:00',1,'1','2020-11-24 15:55:10','2020-11-24 15:55:10'),(3,'ertyy','sss','11','2020-11-24 16:00:00','2020-11-28 16:00:00',2,'1','2020-11-24 15:55:31','2020-11-26 13:20:48'),(4,'fgfgfg','','55','2020-11-24 16:00:00','2020-11-28 16:00:00',1,'1','2020-11-24 15:57:18','2020-11-24 15:57:18'),(5,'hello','hello hello','1212','2020-12-30 13:30:00','2020-11-27 13:30:00',2,'1','2020-11-26 13:22:05','2020-11-26 15:13:18'),(6,'danda','fddssssssssssssssssssss','12','2020-11-26 15:15:00','2020-11-30 15:15:00',2,'1','2020-11-26 15:14:03','2020-11-26 15:14:03');
/*!40000 ALTER TABLE `ec_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_currency`
--

DROP TABLE IF EXISTS `ec_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `iso_code` varchar(256) DEFAULT NULL,
  `symbol` varchar(256) DEFAULT NULL,
  `description` text,
  `rate` varchar(256) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_currency`
--

LOCK TABLES `ec_currency` WRITE;
/*!40000 ALTER TABLE `ec_currency` DISABLE KEYS */;
INSERT INTO `ec_currency` VALUES (1,'United States dollar','USD','&#36;',NULL,'1.00','1','2020-11-27 11:35:27','2020-11-27 11:35:27'),(2,'Indian rupee','INR','&#8377;',NULL,'73.77','1','2020-11-27 11:35:27','2020-11-27 11:35:27'),(3,'Saudi Arabian riyal','SAR','&#65020;',NULL,'3.75','1','2020-11-27 11:35:27','2020-11-27 11:35:27');
/*!40000 ALTER TABLE `ec_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer`
--

DROP TABLE IF EXISTS `ec_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_uid` char(13) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `user_description` varchar(255) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `password` varchar(34) NOT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `role` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_uid` (`customer_uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer`
--

LOCK TABLES `ec_customer` WRITE;
/*!40000 ALTER TABLE `ec_customer` DISABLE KEYS */;
INSERT INTO `ec_customer` VALUES (1,0,'5ece4797eaf5e','Dheeru','Singh','dheerusingh59@gmail.com','1234567890','','','c4ca4238a0b923820dcc509a6f75849b','1','','','2020-12-01 15:16:59','2020-12-07 13:52:53'),(65,0,'5fcf2a8f69316','Atul Mohindru',NULL,'atulmohindru@gmail.com','9810656842','','','e10adc3949ba59abbe56e057f20f883e','1','','192.168.1.92','2020-12-08 12:56:07','2020-12-08 12:56:07');
/*!40000 ALTER TABLE `ec_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer_password_reset`
--

DROP TABLE IF EXISTS `ec_customer_password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_customer_password_reset` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `reset_key` char(40) NOT NULL,
  `ip_address` char(15) DEFAULT NULL,
  `status` char(15) NOT NULL DEFAULT 'active',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`request_id`),
  KEY `customer_id` (`customer_id`),
  KEY `reset_key` (`reset_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer_password_reset`
--

LOCK TABLES `ec_customer_password_reset` WRITE;
/*!40000 ALTER TABLE `ec_customer_password_reset` DISABLE KEYS */;
INSERT INTO `ec_customer_password_reset` VALUES (1,1,'97f5ab687f310226b5cfecfdf9272b04','192.168.1.98','reset','2020-12-01 18:09:59','2020-12-07 11:51:28'),(2,1,'a5de0664a082b360976803cba69922dc','192.168.1.98','reset','2020-12-07 11:22:46','2020-12-07 11:51:28'),(3,1,'e290b6f6f7d0dc2ffcc426ac05db76c7','192.168.1.98','reset','2020-12-07 11:29:34','2020-12-07 11:51:28'),(4,1,'6e08de114e2073f8d0d4a668808b875a','192.168.1.98','reset','2020-12-07 11:31:41','2020-12-07 11:51:28'),(5,1,'c1554347003a5da6fb384dffd590be9c','192.168.1.98','reset','2020-12-07 11:33:10','2020-12-07 11:51:28'),(6,1,'4cd494308133cc54b6b5af8f7cd70b3d','192.168.1.98','active','2020-12-07 15:29:51','2020-12-07 15:29:51');
/*!40000 ALTER TABLE `ec_customer_password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer_session`
--

DROP TABLE IF EXISTS `ec_customer_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_customer_session` (
  `id` varchar(40) NOT NULL,
  `login_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `timestamp` (`timestamp`),
  KEY `login_id` (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer_session`
--

LOCK TABLES `ec_customer_session` WRITE;
/*!40000 ALTER TABLE `ec_customer_session` DISABLE KEYS */;
INSERT INTO `ec_customer_session` VALUES ('rln0qvuhk3milsuuqnlf6nukj1pq507m',NULL,'192.168.1.95',1606970600,'__ci_last_regenerate|i:1606970600;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/contact/ajax-form-data\";'),('riat4e5cqo69kgv3sgrap4nho8fi34hc',NULL,'192.168.1.95',1606971530,'__ci_last_regenerate|i:1606971530;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/contact/ajax-form-data\";'),('pasrfgk8d7ju3jkjv6494oomkm340g37',NULL,'192.168.1.95',1606971873,'__ci_last_regenerate|i:1606971873;type|s:8:\"customer\";previous_url|s:54:\"http://klentano.msdev.in/customer/contact/ajax_subform\";'),('ci60g6cs68246oiae0kta211r85v8k8a',NULL,'192.168.1.95',1606972303,'__ci_last_regenerate|i:1606972303;type|s:8:\"customer\";previous_url|s:54:\"http://klentano.msdev.in/customer/contact/ajax_subform\";'),('h3tr535s8uh70fo2o30oclp970ivccv0',NULL,'192.168.1.95',1606972706,'__ci_last_regenerate|i:1606972706;type|s:8:\"customer\";previous_url|s:53:\"http://klentano.msdev.in/customer/contact/ajaxsubform\";'),('7igorbn48i5pi365dogegqh7h8ikro05',NULL,'192.168.1.95',1606973017,'__ci_last_regenerate|i:1606973017;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('763k8pkiobht2e67tljnnff6vqs03nft',NULL,'192.168.1.95',1606973601,'__ci_last_regenerate|i:1606973601;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('34f844raqf0ir3s8fba6ucben7aoulnv',NULL,'192.168.1.95',1606973950,'__ci_last_regenerate|i:1606973950;type|s:8:\"customer\";previous_url|s:53:\"http://klentano.msdev.in/customer/contact/ajaxsubform\";'),('i25ou8et8j796hqgcimb1je6s2u2b2s3',NULL,'192.168.1.95',1606974281,'__ci_last_regenerate|i:1606974281;type|s:8:\"customer\";previous_url|s:53:\"http://klentano.msdev.in/customer/contact/ajaxsubform\";'),('mln01fc0g53hbbuvqnni6usc4imotr6e',NULL,'192.168.1.95',1606974277,'__ci_last_regenerate|i:1606974277;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/customer/contact/ajaxform\";'),('2ufb0idv9i655n9osgsv2dnh86437mq3',49,'192.168.1.95',1606974769,'__ci_last_regenerate|i:1606974769;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/customer/contact/ajaxform\";customer|a:2:{s:5:\"email\";N;s:10:\"current_id\";i:43;}'),('ev4om0246s6guht2bq8k32ovmlnimnvt',NULL,'192.168.1.95',1606974924,'__ci_last_regenerate|i:1606974924;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('tnkeiacp392e5usrloerlev1rd81dr35',NULL,'192.168.1.97',1606974346,'__ci_last_regenerate|i:1606974346;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('lclomtmmbn2qatepdh2n2pv9539t0a7c',NULL,'192.168.1.97',1606974493,'__ci_last_regenerate|i:1606974384;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/customer/contact/ajaxform\";'),('gqhmcrciou5s8am7kbeg4rep090gggf7',NULL,'192.168.1.95',1606975090,'__ci_last_regenerate|i:1606975090;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/welcome/ajaxform\";customer|a:2:{s:5:\"email\";N;s:10:\"current_id\";i:46;}'),('c1v3io06cm3vgnbo1f4v7mab5l50jugs',NULL,'192.168.1.95',1606975265,'__ci_last_regenerate|i:1606975265;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/welcome/ajaxsubscribeform\";customer|a:2:{s:5:\"email\";N;s:10:\"current_id\";i:49;}'),('nitaremimt52g6m751efp2ii68kbo6v1',NULL,'192.168.1.95',1606976840,'__ci_last_regenerate|i:1606976840;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";customer|a:2:{s:5:\"email\";N;s:10:\"current_id\";i:48;}'),('l2cucphc634ct2ap041rf80fqnv1hbss',NULL,'192.168.1.95',1606977198,'__ci_last_regenerate|i:1606977198;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/welcome/ajaxsubscribeform\";customer|a:2:{s:5:\"email\";N;s:10:\"current_id\";i:50;}'),('srh8erie53k49t2id9546bd9a2pactu0',NULL,'192.168.1.95',1606977289,'__ci_last_regenerate|i:1606977289;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/welcome/ajaxsubscribeform\";customer|a:3:{s:5:\"email\";a:1:{i:0;s:0:\"\";}s:5:\"fname\";s:0:\"\";s:10:\"current_id\";i:51;}'),('vb166ktncmk2sj7q8dl9f2ja48jkgp76',NULL,'192.168.1.95',1606977235,'__ci_last_regenerate|i:1606977198;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/welcome/ajaxsubscribeform\";customer|a:3:{s:5:\"email\";a:1:{i:0;s:0:\"\";}s:5:\"fname\";s:0:\"\";s:10:\"current_id\";i:53;}'),('ragriise8lv9jkpaj44trqcgkfnkpnsr',NULL,'192.168.1.95',1606977809,'__ci_last_regenerate|i:1606977809;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/welcome/ajaxsubscribeform\";customer|a:3:{s:5:\"email\";s:14:\"opsingh@ff.com\";s:5:\"fname\";s:7:\"opsingh\";s:10:\"current_id\";i:57;}'),('2un26hh2dfr7c2acp5kamt5s18746m45',NULL,'192.168.1.95',1606977586,'__ci_last_regenerate|i:1606977537;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";customer|a:3:{s:5:\"email\";s:12:\"hello@kk.com\";s:5:\"fname\";s:5:\"hello\";s:10:\"current_id\";i:58;}'),('tqm4aspdae9tbjobg7kbpv4vntm6gu58',NULL,'192.168.1.95',1606977627,'__ci_last_regenerate|i:1606977604;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";customer|a:3:{s:5:\"email\";s:11:\"vvvv@vv.com\";s:5:\"fname\";s:4:\"vvvv\";s:10:\"current_id\";i:59;}'),('8fogppls67s8ofebil4pno9l2r2iarcp',NULL,'192.168.1.95',1606977826,'__ci_last_regenerate|i:1606977809;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";customer|a:3:{s:5:\"email\";s:11:\"aaa@ddd.com\";s:5:\"fname\";s:3:\"aaa\";s:10:\"current_id\";i:61;}'),('iuntokt8klhk4a0cq99rjim1h2h4bu1m',NULL,'192.168.1.4',1606979316,'__ci_last_regenerate|i:1606979316;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('5h5ibo3ihf282vn4d21hrucm8vclqkpj',NULL,'192.168.1.95',1606991353,'__ci_last_regenerate|i:1606991353;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('ge09bnrelohl9pvsdb6pu3iingjl8ph8',NULL,'192.168.1.95',1606995793,'__ci_last_regenerate|i:1606995793;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('9frkjs1jq2emgk286qac6d00407gdkf6',NULL,'192.168.1.95',1606999854,'__ci_last_regenerate|i:1606999854;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('gdenohcn5f7aljd63qe77pcrf80p857u',NULL,'192.168.1.95',1606999854,'__ci_last_regenerate|i:1606999854;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('5bhnkv2h7gpjij0nok8vv3c756sf7ns8',NULL,'192.168.1.109',1607001299,'__ci_last_regenerate|i:1607001299;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('7i83rn5crairi1fpbi7j3vuai86g3pl9',NULL,'192.168.1.95',1607059822,'__ci_last_regenerate|i:1607059822;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('fr4trocvqvs91ivfu10c2fh3eduld08j',NULL,'192.168.1.95',1607061264,'__ci_last_regenerate|i:1607061264;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/customer/product/detail\";'),('75lhmsrjtlcqe21qvauv3niqa81endro',NULL,'192.168.1.95',1607061142,'__ci_last_regenerate|i:1607061142;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('ijuji7t7tmqe1rn60bgv0uesrdvr3vlb',NULL,'192.168.1.95',1607061538,'__ci_last_regenerate|i:1607061538;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('kv38i21d517tn71qidv47ej5d8no6a26',NULL,'192.168.1.95',1607062344,'__ci_last_regenerate|i:1607062344;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('uesrhtm7lot976hvt908017sm7b9014r',NULL,'192.168.1.95',1607063283,'__ci_last_regenerate|i:1607063283;type|s:8:\"customer\";previous_url|s:55:\"http://klentano.msdev.in/customer/product/detail/afdsdf\";'),('etcfkotglr314u1vr9vplen794m2akqi',NULL,'192.168.1.95',1607062656,'__ci_last_regenerate|i:1607062656;type|s:8:\"customer\";previous_url|s:65:\"http://klentano.msdev.in/customer/product/detail/why-do-we-use-it\";'),('qcit8e0mit889henhq5i2kedvirl9bhq',NULL,'192.168.1.95',1607063188,'__ci_last_regenerate|i:1607063188;type|s:8:\"customer\";previous_url|s:59:\"http://klentano.msdev.in/customer/product/detail/xxjay-here\";'),('t7p856jrpekq8i191noi9sen22fi8f99',NULL,'192.168.1.95',1607063609,'__ci_last_regenerate|i:1607063609;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('kma2bnl09hg59vv47cvas6urcg87rd22',NULL,'192.168.1.95',1607063604,'__ci_last_regenerate|i:1607063604;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('dnasvmisnuo5n4bk2stvuog49ahdatst',NULL,'192.168.1.95',1607063997,'__ci_last_regenerate|i:1607063997;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('semcdejgid0migttvhtn9d19l4lnn1up',NULL,'192.168.1.95',1607063927,'__ci_last_regenerate|i:1607063927;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('6te4rvm3hmlj461fibkv7u0fgapffcn6',NULL,'192.168.1.95',1607064294,'__ci_last_regenerate|i:1607064294;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('2ldbf1adir3hfcogimsuc5lagcviuq09',NULL,'192.168.1.95',1607066908,'__ci_last_regenerate|i:1607066908;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('n4tgtpqd0spj4cvb179isp1deirped37',NULL,'192.168.1.95',1607065872,'__ci_last_regenerate|i:1607065872;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('glvfqa0rbdg4i0ho5h84e6q8f4fljabf',NULL,'192.168.1.98',1607069359,'__ci_last_regenerate|i:1607069359;type|s:8:\"customer\";'),('eca65rchh6enqmf9d6ubddm8v645qu6v',NULL,'192.168.1.98',1607065836,'__ci_last_regenerate|i:1607065836;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('dckdppo71f48t0eppio2jbeb1vb5324l',NULL,'192.168.1.95',1607066550,'__ci_last_regenerate|i:1607066550;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('qo706hbhaoc5ickbvjbj0hhri81l1t6p',NULL,'192.168.1.95',1607066911,'__ci_last_regenerate|i:1607066911;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('or2mc98a0gkic7jpi6tj2hlemji144cq',NULL,'192.168.1.95',1607067391,'__ci_last_regenerate|i:1607067391;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('ssosmgsst2m15ss0ornb7juoqq7hldl7',NULL,'192.168.1.95',1607067247,'__ci_last_regenerate|i:1607067247;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('igqgd6m99e2ua874vhii8vh64id87g1r',NULL,'192.168.1.95',1607067763,'__ci_last_regenerate|i:1607067763;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('kcquo3hne5uuku31htvjqs56db2lm6hd',NULL,'192.168.1.95',1607067704,'__ci_last_regenerate|i:1607067704;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('25iij2v8jjgivgniul2sk5sv96q22i93',NULL,'192.168.1.95',1607068270,'__ci_last_regenerate|i:1607068270;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('aitc056joqn0sjidfv8ii9v1tf7nrnkc',NULL,'192.168.1.95',1607068573,'__ci_last_regenerate|i:1607068573;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('t6nk87u3mpp9oiakrqul99nnsig6ph07',NULL,'192.168.1.95',1607068576,'__ci_last_regenerate|i:1607068576;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('g06rbgc97got7k7vfbu8u5afu590sa2p',NULL,'192.168.1.95',1607069910,'__ci_last_regenerate|i:1607069910;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('lcauurctj2oskme1o463u17c3to04jsn',NULL,'192.168.1.95',1607068907,'__ci_last_regenerate|i:1607068907;type|s:8:\"customer\";previous_url|s:68:\"http://klentano.msdev.in/customer/product/detail/what-is-lorem-ipsum\";'),('r1lh7g503f70nbv7nlogdd12g6iq29n4',NULL,'192.168.1.95',1607069891,'__ci_last_regenerate|i:1607069891;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('nfiup9o04rmnoda8tte1mbd5teavke9n',NULL,'192.168.1.98',1607069359,'__ci_last_regenerate|i:1607069359;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('akaslf7cefeh9bk6cebieqd4j01ens6k',NULL,'192.168.1.95',1607070192,'__ci_last_regenerate|i:1607070192;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('qqbeti74ep0p02jn7op5mk2v8esb2g9e',NULL,'192.168.1.95',1607074160,'__ci_last_regenerate|i:1607074160;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('0g7c861klqdfq5rsetdppu2odtc9kib7',NULL,'192.168.1.95',1607070522,'__ci_last_regenerate|i:1607070522;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('8db5aoaovf6np2m3d99lga0bqt8ssg10',NULL,'192.168.1.95',1607070853,'__ci_last_regenerate|i:1607070853;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('sts3lf6hdko4ddbm5rpe2f6e5ipb45fq',NULL,'192.168.1.95',1607073697,'__ci_last_regenerate|i:1607073697;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/product/detail/xxtest1\";'),('iafuh7r3ti1gp0gkk0o03pp8617kvul4',NULL,'192.168.1.95',1607074076,'__ci_last_regenerate|i:1607074076;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/product/detail/xxtest1\";'),('0et98tj6iudc4fcpga1p72s5329udtu2',NULL,'192.168.1.95',1607074403,'__ci_last_regenerate|i:1607074403;type|s:8:\"customer\";previous_url|s:68:\"http://klentano.msdev.in/customer/product/detail/what-is-lorem-ipsum\";'),('us51popve33evip38n2sa5gu7tu1knbf',NULL,'192.168.1.95',1607076687,'__ci_last_regenerate|i:1607076687;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('olr1gj5r72g3s6dv20jb8rbipsrnu0lc',NULL,'192.168.1.95',1607074706,'__ci_last_regenerate|i:1607074706;type|s:8:\"customer\";previous_url|s:68:\"http://klentano.msdev.in/customer/product/detail/what-is-lorem-ipsum\";'),('s2meq1kqk756kbg4cd2nna2omfvd1vrt',NULL,'192.168.1.95',1607075021,'__ci_last_regenerate|i:1607075021;type|s:8:\"customer\";previous_url|s:66:\"http://klentano.msdev.in/customer/product/detail/this-is-test-here\";'),('em6mr6otpkiust86us98l16uv8ov81nt',NULL,'192.168.1.95',1607076768,'__ci_last_regenerate|i:1607076768;type|s:8:\"customer\";previous_url|s:69:\"http://klentano.msdev.in/customer/product/detail/the-standard-lorem-i\";'),('l79gi74s9h4pej3mc3g9dmg1aj9rshvd',NULL,'192.168.1.95',1607077723,'__ci_last_regenerate|i:1607077723;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/customer/page\";'),('9redsbl7afca9st87ms2bham20agri9d',NULL,'192.168.1.95',1607077078,'__ci_last_regenerate|i:1607077078;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/customer/page\";'),('picpkrggjlm12o7t96kf3nr0870ea1ue',NULL,'192.168.1.95',1607077398,'__ci_last_regenerate|i:1607077398;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/customer/page/index/asd\";'),('sdto3s6r1vps3d43sp47ct2p19ibojnj',NULL,'192.168.1.95',1607077818,'__ci_last_regenerate|i:1607077818;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/customer/page/index/asd\";'),('bjs15vretm18khh1868agpva81qacju5',NULL,'192.168.1.95',1607078930,'__ci_last_regenerate|i:1607078930;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/customer/page\";'),('1poa3dkts3firivhvrbtjckjecalmi39',NULL,'192.168.1.95',1607078124,'__ci_last_regenerate|i:1607078124;type|s:8:\"customer\";previous_url|s:65:\"http://klentano.msdev.in/customer/page/index/the-standard-lorem-i\";'),('uqnehso535k9nak7vcnjnod2407f1t55',NULL,'192.168.1.4',1607077952,'__ci_last_regenerate|i:1607077952;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('1kqkhuc914t7aak6oojpnkbcn6v2qpjd',NULL,'192.168.1.95',1607078496,'__ci_last_regenerate|i:1607078496;type|s:8:\"customer\";previous_url|s:49:\"http://klentano.msdev.in/customer/page/index/help\";'),('rgkpdu487b4ni9unncmogj3m2q1hoia9',NULL,'192.168.1.95',1607078923,'__ci_last_regenerate|i:1607078923;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/page/index/help-center\";'),('6r28tanmv5aaohp3ej37157qpf39rdt0',NULL,'192.168.1.95',1607079489,'__ci_last_regenerate|i:1607079489;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/page/services\";'),('5drru57q6m6fhn6p0bmerdsrl0jdqgoa',NULL,'192.168.1.95',1607079539,'__ci_last_regenerate|i:1607079539;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/page/help-center\";'),('7lhsmpdkgldni23b9sohkms5rbilrl55',NULL,'192.168.1.95',1607080150,'__ci_last_regenerate|i:1607080150;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/product/detail/test333\";'),('f3f4kh01oltcq6hgmkfnd62jccepciij',NULL,'192.168.1.95',1607079714,'__ci_last_regenerate|i:1607079539;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/product/detail/test333\";'),('fmlpp1066ri0ncrf3jb7l0oco1uk94df',NULL,'192.168.1.95',1607080451,'__ci_last_regenerate|i:1607080451;type|s:8:\"customer\";previous_url|s:56:\"http://klentano.msdev.in/customer/product/detail/xxtest1\";'),('snhcdp0kd0cpvop384s3v9c492c9hkfu',NULL,'192.168.1.95',1607080813,'__ci_last_regenerate|i:1607080813;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";'),('3ckemg4savnhbt7pv4ikglvsenkf244q',NULL,'192.168.1.95',1607081987,'__ci_last_regenerate|i:1607081987;type|s:8:\"customer\";previous_url|s:57:\"http://klentano.msdev.in/product/detail/this-is-test-here\";'),('acdq1iro48grjr8p9k8jbmnpkg0kkvvh',NULL,'192.168.1.95',1607082451,'__ci_last_regenerate|i:1607082451;type|s:8:\"customer\";previous_url|s:45:\"http://klentano.msdev.in/posts/detail/test333\";'),('2rreodb4asfa4l925jriljdhlrndtt7b',NULL,'192.168.1.95',1607082792,'__ci_last_regenerate|i:1607082792;type|s:8:\"customer\";previous_url|s:44:\"http://klentano.msdev.in/post-detail/test333\";'),('oe1shif58i5a1hjidltivpecub641db1',NULL,'192.168.1.95',1607082908,'__ci_last_regenerate|i:1607082792;type|s:8:\"customer\";previous_url|s:57:\"http://klentano.msdev.in/product/detail/this-is-test-here\";'),('foa1t3ticrbkcg9afks8cb5p24m8ike3',NULL,'192.168.1.2',1607084372,'__ci_last_regenerate|i:1607084372;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('vhvin10vinnj7b7u6nnpvfehjtb7s72e',NULL,'192.168.1.2',1607084389,'__ci_last_regenerate|i:1607084372;type|s:8:\"customer\";previous_url|s:53:\"http://klentano.msdev.in/customer/auth/ajax_form_data\";customer|a:8:{s:5:\"email\";s:22:\"atulmohindru@gmail.com\";s:5:\"fname\";s:13:\"Atul Mohindru\";s:6:\"mobile\";s:10:\"9810656842\";s:4:\"type\";s:9:\"subscribe\";s:10:\"ip_address\";s:11:\"192.168.1.2\";s:12:\"customer_uid\";s:13:\"5fca29640946b\";s:10:\"current_id\";i:50;s:9:\"logged_in\";b:1;}'),('lam6kac61d3lvp4rhb56vls281ve5ppf',50,'192.168.1.92',1607084523,'__ci_last_regenerate|i:1607084392;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";customer|a:4:{s:5:\"email\";s:22:\"atulmohindru@gmail.com\";s:5:\"fname\";s:13:\"Atul Mohindru\";s:8:\"login_id\";s:2:\"50\";s:9:\"logged_in\";b:1;}'),('2bi05iggkcl4edgcvhfu9rt7se5o0rhl',NULL,'192.168.1.95',1607091040,'__ci_last_regenerate|i:1607091040;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/product/detail/pppppppppp\";'),('tl6u1u9nc8kb4csummbo5drk6d6k8bd8',NULL,'192.168.1.2',1607090929,'__ci_last_regenerate|i:1607090929;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('jmg5iununlug2to451v9etlm3i1adhrl',NULL,'192.168.1.95',1607091040,'__ci_last_regenerate|i:1607091040;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('b1tf1qgdth6pvacb3qf1nnh0tpk63d91',NULL,'192.168.1.2',1607099997,'__ci_last_regenerate|i:1607099997;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('asri1tru3cji2uffck2mqkvdlb41hnfu',NULL,'192.168.1.2',1607100156,'__ci_last_regenerate|i:1607100156;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('hhnmslkoinso90k92141fq64tkfcv2e1',NULL,'192.168.1.2',1607100237,'__ci_last_regenerate|i:1607100237;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('s63cgeabkm8vspt0ippp7npv8kre76d8',NULL,'192.168.1.2',1607100272,'__ci_last_regenerate|i:1607100272;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('q3oof3phehscujg944q63ujh8olp4sd5',NULL,'192.168.1.2',1607101142,'__ci_last_regenerate|i:1607101142;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('gna3et5f3qe9jitirrmgummajn646jih',NULL,'192.168.1.2',1607100306,'__ci_last_regenerate|i:1607100306;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('ugkjc0qsko2b0akepvmhatqr9v56c0ur',NULL,'192.168.1.2',1607100323,'__ci_last_regenerate|i:1607100323;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('toi9hsigbqe5uquaf7a6pocr3dqsr6sf',NULL,'192.168.1.2',1607100434,'__ci_last_regenerate|i:1607100434;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('l003h9kr07paa7naegm2212pclf0pht5',NULL,'192.168.1.2',1607101638,'__ci_last_regenerate|i:1607101638;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('g3tatbv71dsll2gmcdi2svt7risfju3d',NULL,'192.168.1.2',1607100686,'__ci_last_regenerate|i:1607100640;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('qo1in6221mtmro3n4joqe524v6if1g6q',NULL,'192.168.1.2',1607100757,'__ci_last_regenerate|i:1607100757;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('uicg68nck8m5tqkmg5rqcf76pm1vjeen',NULL,'192.168.1.2',1607100826,'__ci_last_regenerate|i:1607100826;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('jffp40pgmg7hiq6nmaemkjae3t500fnl',NULL,'192.168.1.2',1607100828,'__ci_last_regenerate|i:1607100828;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('igh5qas4uglnjlkf1ha1fqav93cc5dq7',NULL,'192.168.1.2',1607101142,'__ci_last_regenerate|i:1607101142;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('2tjrsqmtgdn7era3qjpjjv7026ovoona',NULL,'192.168.1.2',1607101729,'__ci_last_regenerate|i:1607101638;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('quul6q6q7ef927dppnsgm21c8pqmmkqc',NULL,'192.168.1.2',1607102502,'__ci_last_regenerate|i:1607102502;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('pquhhb4h5ho88h1v02rpq8u4ce281pn4',NULL,'192.168.1.2',1607102920,'__ci_last_regenerate|i:1607102920;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('c9rf5pvcmq9r2cr3i60d348g13chhc2t',NULL,'192.168.1.2',1607106978,'__ci_last_regenerate|i:1607106978;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('hg2obv4ji1ineftc2q4irueo4q9ee2t6',NULL,'192.168.1.2',1607107008,'__ci_last_regenerate|i:1607106978;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('iq8tiklo3p6of5j38mvsuautjjs2cm28',NULL,'192.168.1.2',1607130306,'__ci_last_regenerate|i:1607130306;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('d814lo4fj9sjccapevj49nch2ub2mjg2',NULL,'192.168.1.2',1607140564,'__ci_last_regenerate|i:1607140564;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('sq0qb9l2m7om46r1t7jq85gbi69cvjc5',NULL,'192.168.1.2',1607146601,'__ci_last_regenerate|i:1607146562;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('qdvql11q1cj1imq1mbue1luukt0ds59r',NULL,'192.168.1.2',1607185891,'__ci_last_regenerate|i:1607185891;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('28995ofehi0lm5h81ncl3j06bp31a8rg',NULL,'192.168.1.2',1607186993,'__ci_last_regenerate|i:1607186993;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('cj9fbmrnclt1tpts85pvs6j8o9a602us',NULL,'192.168.1.2',1607192792,'__ci_last_regenerate|i:1607192630;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('cnn16q8emld5vn1hl85h3ktgd5a499td',NULL,'192.168.1.2',1607204826,'__ci_last_regenerate|i:1607204826;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('7k5o7ilud22fkmot1r3vmi0vo7klplks',NULL,'192.168.1.2',1607220599,'__ci_last_regenerate|i:1607220599;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('2cbuug8vqk2op2gerom0rqf32v3osq13',NULL,'192.168.1.2',1607220648,'__ci_last_regenerate|i:1607220599;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('n3ff97hr8pnlh5e6678e2rhjq4dcil1s',NULL,'192.168.1.2',1607242853,'__ci_last_regenerate|i:1607242853;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('rv8suisck7djiioeq29qgd3a8n6qtqtf',NULL,'192.168.1.2',1607256826,'__ci_last_regenerate|i:1607256826;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('oo184ceh5dc4ql1vi63l5lr4gu6g66te',NULL,'192.168.1.2',1607308029,'__ci_last_regenerate|i:1607308029;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('fhp3dabbsre9v68f1tc20tgd0tl5j49g',NULL,'192.168.1.2',1607308839,'__ci_last_regenerate|i:1607308839;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('kdt69384hen3ngu3sj4kj038scrkc1vn',NULL,'192.168.1.2',1607308049,'__ci_last_regenerate|i:1607308049;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('0tp2uo0sd5u01k6oipfmar3fe1qcks5r',NULL,'192.168.1.2',1607308146,'__ci_last_regenerate|i:1607308146;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('cd99ea6jrsrl5gqmbbi0mm54g4bp8hh6',NULL,'192.168.1.2',1607308555,'__ci_last_regenerate|i:1607308555;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('nviojnbq306bp533cl2abe6mgn8voe0j',NULL,'192.168.1.2',1607308839,'__ci_last_regenerate|i:1607308839;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('v6kd6el26508le2rshelm80o52kqqvfo',NULL,'192.168.1.2',1607309868,'__ci_last_regenerate|i:1607309868;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('eupf35jo6mlvdls6t23lc4f5m3s4hvqg',NULL,'192.168.1.98',1607319933,'__ci_last_regenerate|i:1607319933;type|s:8:\"customer\";'),('hn25o4ib95v54o0f4qlmvv0rev25k6m2',NULL,'192.168.1.108',1607320299,'__ci_last_regenerate|i:1607320299;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('vndlfud8l1eu1navil6osl7a91cegv40',NULL,'192.168.1.98',1607321215,'__ci_last_regenerate|i:1607321215;type|s:8:\"customer\";'),('2r3sjjo428mnvs8esm6uu029phq98iru',NULL,'192.168.1.98',1607319954,'__ci_last_regenerate|i:1607319954;type|s:8:\"customer\";'),('ds2ljqfsrqm9k2rl8c7u60j7gupsrba2',NULL,'192.168.1.108',1607320700,'__ci_last_regenerate|i:1607320299;type|s:8:\"customer\";previous_url|s:50:\"http://klentano.msdev.in/welcome/ajaxsubscribeform\";customer|a:3:{s:5:\"email\";s:18:\"zhr46228@bcaoo.com\";s:5:\"fname\";s:8:\"zhr46228\";s:10:\"current_id\";i:62;}'),('r2so78baiuelvq4pejglhc9lvpa1r4hf',NULL,'192.168.1.108',1607327358,'__ci_last_regenerate|i:1607327358;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";customer|a:3:{s:5:\"email\";s:18:\"zov79649@bcaoo.com\";s:5:\"fname\";s:8:\"zov79649\";s:10:\"current_id\";i:63;}'),('n8ejktuntghqpvo597q7bro0tntkpsur',NULL,'192.168.1.98',1607321562,'__ci_last_regenerate|i:1607321562;type|s:8:\"customer\";message|s:0:\"\";__ci_vars|a:1:{s:7:\"message\";s:3:\"new\";}'),('32no7bmjpl0qfds19j787228ftpq5m6f',NULL,'192.168.1.98',1607322056,'__ci_last_regenerate|i:1607322056;type|s:8:\"customer\";message|s:0:\"\";__ci_vars|a:1:{s:7:\"message\";s:3:\"new\";}previous_url|s:44:\"http://klentano.msdev.in/customer/auth/reset\";'),('caomdc3j220bm2nj9lj9jho0guaroteg',1,'192.168.1.98',1607325917,'__ci_last_regenerate|i:1607325917;type|s:8:\"customer\";previous_url|s:44:\"http://klentano.msdev.in/customer/auth/reset\";customer|a:4:{s:5:\"email\";s:23:\"dheerusingh59@gmail.com\";s:5:\"fname\";s:6:\"Dheeru\";s:8:\"login_id\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('p2cel97tl3veiednmhf72ms7lilm8lli',1,'192.168.1.98',1607327230,'__ci_last_regenerate|i:1607327230;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";'),('7iigt391u15co6dtia7t5q1v6ih6d3e3',NULL,'192.168.1.98',1607327704,'__ci_last_regenerate|i:1607327704;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";'),('bi3mb2f09ud9t1b4fijp337c6q5fjnql',NULL,'192.168.1.95',1607327442,'__ci_last_regenerate|i:1607327358;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";customer|a:3:{s:5:\"email\";s:18:\"zov79649@bcaoo.com\";s:5:\"fname\";s:8:\"zov79649\";s:10:\"current_id\";i:63;}'),('8afdc543jmq24lbilas4lhl6qak5n7t4',NULL,'192.168.1.98',1607328006,'__ci_last_regenerate|i:1607328006;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";'),('aalfq97sj0gd11e6c9997v1nulvbfcjm',54,'192.168.1.98',1607328322,'__ci_last_regenerate|i:1607328322;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";customer|a:4:{s:5:\"email\";s:15:\"ssfd@sdsfdf.com\";s:5:\"fname\";s:4:\"sfdf\";s:8:\"login_id\";i:54;s:9:\"logged_in\";b:1;}'),('13uhvjqj02e83ivb24durrthrgsnv4sm',54,'192.168.1.98',1607329268,'__ci_last_regenerate|i:1607329268;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";customer|a:4:{s:5:\"email\";s:15:\"ssfd@sdsfdf.com\";s:5:\"fname\";s:4:\"sfdf\";s:8:\"login_id\";i:54;s:9:\"logged_in\";b:1;}'),('q5selsj3275mucut8o4e0eltq1u225v2',58,'192.168.1.98',1607329584,'__ci_last_regenerate|i:1607329584;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";customer|a:4:{s:5:\"email\";s:15:\"ryty@sdfdgf.com\";s:5:\"fname\";s:5:\"sfggg\";s:8:\"login_id\";i:58;s:9:\"logged_in\";b:1;}'),('1i8h97u1s6430u8980cknksna5l251c2',NULL,'192.168.1.98',1607329300,'__ci_last_regenerate|i:1607329300;type|s:8:\"customer\";'),('jdsr7g1prf7449cjnkogesbil1lns4rt',NULL,'192.168.1.98',1607329424,'__ci_last_regenerate|i:1607329424;type|s:8:\"customer\";'),('64o4ch4cajmc834kd0m8abt1nmahjnbb',60,'192.168.1.98',1607334934,'__ci_last_regenerate|i:1607334934;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";customer|a:4:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:4:\"sdsf\";s:8:\"login_id\";i:60;s:9:\"logged_in\";b:1;}'),('46vnpu3od6vmm77vvbtlajg85usafbap',61,'192.168.1.98',1607335426,'__ci_last_regenerate|i:1607335426;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";'),('750okd60ge7ccir845b83ot72oln5725',63,'192.168.1.98',1607335760,'__ci_last_regenerate|i:1607335760;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";customer|a:4:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:2:\"qq\";s:8:\"login_id\";i:63;s:9:\"logged_in\";b:1;}'),('7vrenbste31jf11q6jkeruu6qgr837a4',64,'192.168.1.98',1607337173,'__ci_last_regenerate|i:1607337173;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";customer|a:4:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:4:\"sfsf\";s:8:\"login_id\";i:64;s:9:\"logged_in\";b:1;}'),('9rq9tn0291nd19bligrsk7d21h23r60i',64,'192.168.1.98',1607337715,'__ci_last_regenerate|i:1607337715;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";customer|a:4:{s:5:\"email\";s:23:\"neerajdiwakar@gmail.com\";s:5:\"fname\";s:4:\"sfsf\";s:8:\"login_id\";i:64;s:9:\"logged_in\";b:1;}'),('tdb83v7ikpnggmo02ukvufbcrejn67ok',1,'192.168.1.98',1607339838,'__ci_last_regenerate|i:1607339838;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/customer/product\";customer|a:4:{s:5:\"email\";s:23:\"dheerusingh59@gmail.com\";s:5:\"fname\";s:6:\"Dheeru\";s:8:\"login_id\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('lfu31a30h27ecq21v224t50oijs497s5',NULL,'192.168.1.98',1607339838,'__ci_last_regenerate|i:1607339838;type|s:8:\"customer\";previous_url|s:35:\"http://klentano.msdev.in/page/about\";customer|a:4:{s:5:\"email\";s:23:\"dheerusingh59@gmail.com\";s:5:\"fname\";s:6:\"Dheeru\";s:8:\"login_id\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),('904khu1ddgogpg7hofn8c1r5024q82q7',NULL,'192.168.1.108',1607348076,'__ci_last_regenerate|i:1607348076;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('udcqn8un9c86iekudha5m045crdsu1cj',NULL,'192.168.1.95',1607345913,'__ci_last_regenerate|i:1607345913;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('7cftlibd4lomlvo0mabvafgeha157o18',NULL,'192.168.1.95',1607348076,'__ci_last_regenerate|i:1607348076;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('pc16pmgoimlpjfajsse9j8kqoms9d5ps',NULL,'192.168.1.2',1607386617,'__ci_last_regenerate|i:1607386617;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('jgdcgvbqrbahnaitec5b9eh08nrhnjnc',65,'192.168.1.92',1607412656,'__ci_last_regenerate|i:1607412656;type|s:8:\"customer\";previous_url|s:43:\"http://klentano.msdev.in/customer/dashboard\";'),('dar6v930qnvn41q74u3n6dfe6crcuaog',NULL,'192.168.1.92',1607412656,'__ci_last_regenerate|i:1607412656;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('lm5fo92o8pmervmsp41ipqfgneragboa',NULL,'192.168.1.95',1607412887,'__ci_last_regenerate|i:1607412709;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('ad44d39o34f6n7rng1b7r7urt5idjcb2',NULL,'192.168.1.98',1607412960,'__ci_last_regenerate|i:1607412747;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('b2vh8mrh4vjr91esv4ehjt6fkrhugasu',NULL,'192.168.1.95',1607424106,'__ci_last_regenerate|i:1607424106;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('n3ef2ahlr1t7j6gj6sivi64uqinba8cr',NULL,'192.168.1.95',1607424181,'__ci_last_regenerate|i:1607424178;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('jdmsksm25hl1t7070v1jg755gvci8a39',NULL,'192.168.1.2',1607478697,'__ci_last_regenerate|i:1607478697;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('0cbnogk1g8lfk9qj24l87n14uiieqked',NULL,'192.168.1.2',1607482359,'__ci_last_regenerate|i:1607482359;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('6ih5ec0c8rld539doof0fv06s7ig442d',NULL,'192.168.1.95',1607495903,'__ci_last_regenerate|i:1607495903;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('8k73jvv32o82b2p0kmfddjjiq44s0q72',NULL,'192.168.1.95',1607495903,'__ci_last_regenerate|i:1607495903;type|s:8:\"customer\";previous_url|s:35:\"http://klentano.msdev.in/page/kkk11\";'),('5e6nk10m1sfsrqea2k4j0pbote4punjb',NULL,'192.168.1.95',1607515465,'__ci_last_regenerate|i:1607515465;type|s:8:\"customer\";previous_url|s:35:\"http://klentano.msdev.in/page/bbb11\";'),('3p2kgq64qrr91k9i8f0thosa0q9aud8p',NULL,'192.168.1.95',1607513075,'__ci_last_regenerate|i:1607513075;type|s:8:\"customer\";previous_url|s:35:\"http://klentano.msdev.in/page/ppp-1\";'),('cn7mmrufhtbdeumgvskgjje7tdtb0tjm',NULL,'192.168.1.95',1607515900,'__ci_last_regenerate|i:1607515900;type|s:8:\"customer\";previous_url|s:34:\"http://klentano.msdev.in/post/qqq1\";'),('p39qj0ug27dn3pro9r6ka1i1ajfgt11g',NULL,'192.168.1.95',1607515900,'__ci_last_regenerate|i:1607515900;type|s:8:\"customer\";previous_url|s:36:\"http://klentano.msdev.in/post/test12\";'),('6tllto83tff1k9opf52qekelkaehee2f',NULL,'192.168.1.2',1607560126,'__ci_last_regenerate|i:1607560082;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('479u1nc3n12oeklqii1a0j7q3rvf7uug',NULL,'192.168.1.2',1607560170,'__ci_last_regenerate|i:1607560170;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('kgc57fm6oml3ahg4ur42c9fm7f2ck4ar',NULL,'192.168.1.2',1607560394,'__ci_last_regenerate|i:1607560394;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('p7jd1lq5e73nclo5u31n3j91f1chjln7',NULL,'192.168.1.2',1607561202,'__ci_last_regenerate|i:1607561202;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('1du24vbctdg51tv332chg912gbuo6jll',NULL,'192.168.1.95',1607588285,'__ci_last_regenerate|i:1607588285;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('m8qqdjflhbek22akfs7v5gmjq57ef6rt',NULL,'192.168.1.95',1607588500,'__ci_last_regenerate|i:1607588285;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('0gpl3i9qhnor5ahfkc0odckom74610fc',NULL,'192.168.1.98',1607588615,'__ci_last_regenerate|i:1607588615;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('rd9ig9shaqb5ndoqhmf859n8t4jdr3b3',NULL,'192.168.1.98',1607606801,'__ci_last_regenerate|i:1607606801;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('3qgke7vslvv042nfac824snrkgi0ujad',NULL,'192.168.1.92',1607608058,'__ci_last_regenerate|i:1607608058;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('atfgooev3kq6qgcoftc84kbv89oksid1',NULL,'192.168.1.2',1607654421,'__ci_last_regenerate|i:1607654421;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('8cjkjsivlbkmi1l719h3qo46nkcdov1i',NULL,'192.168.1.95',1607671590,'__ci_last_regenerate|i:1607671590;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('ig0ltaatksna6qiitl7oc6c91tj7b2c0',NULL,'192.168.1.2',1607667761,'__ci_last_regenerate|i:1607667761;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('960t9erdpo80jtfhbfpnd9ve61dv49bk',NULL,'192.168.1.95',1607672658,'__ci_last_regenerate|i:1607672658;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('pr9pi2tqo9pgjtr07ulutgeljr5u2t5h',NULL,'192.168.1.95',1607679360,'__ci_last_regenerate|i:1607679360;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('7icg30imeeu5kh922c39tilv32180ml7',NULL,'192.168.1.95',1607672675,'__ci_last_regenerate|i:1607672675;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('ttk9or48s69oke5lbi1o5jgvhhn72r12',NULL,'192.168.1.110',1607685741,'__ci_last_regenerate|i:1607685741;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('bh328ppc6cvrpn2rb6m3mf92ntl8hhc3',NULL,'192.168.1.4',1607680347,'__ci_last_regenerate|i:1607680347;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('4677ejvbc71mei9oddt5gq11ptij0nbd',NULL,'192.168.1.95',1607685741,'__ci_last_regenerate|i:1607685741;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('uj5gr865pjm1n0u1aks9qpio10k6pbo2',NULL,'192.168.1.98',1607688733,'__ci_last_regenerate|i:1607688733;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('7v57862f2kuls0868iljrvb9732nisrd',NULL,'192.168.1.4',1607688843,'__ci_last_regenerate|i:1607688843;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('e0n89l9pef3kel0k7t7ku47l0pgdk50a',NULL,'192.168.1.98',1607929119,'__ci_last_regenerate|i:1607929119;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('h7vnha6jn657h9hprh5tl2thfstr8ti9',NULL,'192.168.1.95',1607929946,'__ci_last_regenerate|i:1607929946;type|s:8:\"customer\";previous_url|s:45:\"http://klentano.msdev.in/product/detail/geo11\";'),('9r6r5tsc8auhgpso08daib4udvom5qbq',NULL,'192.168.1.95',1607942543,'__ci_last_regenerate|i:1607942543;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/product/detail/sp-singh\";'),('80q6oc5g6en2m95rglijkmafk23ekomq',NULL,'192.168.1.95',1607949124,'__ci_last_regenerate|i:1607949124;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/product/detail/sp-singh\";'),('lg7ln8b2j34fdeag3t5f9qvpqri76ck4',NULL,'192.168.1.95',1607942782,'__ci_last_regenerate|i:1607942782;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/product/detail/sp-singh\";'),('k60udvrsoei9go2vhdpejr588t8d5okk',NULL,'192.168.1.95',1607951168,'__ci_last_regenerate|i:1607951168;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('01dqo1top84gpmg7320ivl4o73bvh1e1',NULL,'192.168.1.95',1607951168,'__ci_last_regenerate|i:1607951168;type|s:8:\"customer\";previous_url|s:48:\"http://klentano.msdev.in/product/detail/sp-singh\";'),('kmuq5sf3fmv30ossmuf4rcafedrqvapd',NULL,'192.168.1.95',1608007944,'__ci_last_regenerate|i:1608007944;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('giqh15kra9gv92ujfqiisd23ubge59dj',NULL,'192.168.1.98',1608011023,'__ci_last_regenerate|i:1608011023;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('qcm4c7alngjq9i8m41051qslu4kol6nu',NULL,'192.168.1.98',1608027379,'__ci_last_regenerate|i:1608027379;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('i8o1iee3q5lh4tb79kkgt0sqqbu785kq',NULL,'192.168.1.95',1608125330,'__ci_last_regenerate|i:1608125330;type|s:8:\"customer\";previous_url|s:57:\"http://klentano.msdev.in/product/detail/this-is-test-here\";'),('3j75q2uv4o6852qaf0flqg9lsd7jung1',NULL,'192.168.1.95',1608125751,'__ci_last_regenerate|i:1608125751;type|s:8:\"customer\";previous_url|s:57:\"http://klentano.msdev.in/product/detail/this-is-test-here\";'),('n7nosddqhf1pqso2nacfq1ejd4gl61a7',NULL,'192.168.1.95',1608125844,'__ci_last_regenerate|i:1608125751;type|s:8:\"customer\";previous_url|s:57:\"http://klentano.msdev.in/product/detail/this-is-test-here\";'),('n1hsntf07a92vnmtrn8gc9lla7fmshgh',NULL,'192.168.1.95',1608183597,'__ci_last_regenerate|i:1608183597;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('4hsp4tiuuq9eu9nv79vv7qk66eg1d97i',NULL,'192.168.1.95',1608183902,'__ci_last_regenerate|i:1608183902;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/page/about-us\";'),('70ud5o1gc1nhlupo7mkm3bnb25ngffc0',NULL,'192.168.1.95',1608184241,'__ci_last_regenerate|i:1608184241;type|s:8:\"customer\";previous_url|s:40:\"http://klentano.msdev.in/page/help--faqs\";'),('lbc87e8nak1c5vstcb806tpjcpsvvuet',NULL,'192.168.1.95',1608184655,'__ci_last_regenerate|i:1608184655;type|s:8:\"customer\";previous_url|s:41:\"http://klentano.msdev.in/page/help-center\";'),('m6kdakovj77vb42pvj7ov1tage7kg82p',NULL,'192.168.1.95',1608185477,'__ci_last_regenerate|i:1608185477;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('i7rqsdjps21i7ukfh0i1njhqpfol737c',NULL,'192.168.1.95',1608185477,'__ci_last_regenerate|i:1608185477;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('25aiabknv7a04u9n0s0jr3mqsrffpanl',NULL,'192.168.1.95',1608267121,'__ci_last_regenerate|i:1608267121;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('mjtbb0q5t8upac2mm50ikk8mh5h82urq',NULL,'192.168.1.95',1608267817,'__ci_last_regenerate|i:1608267817;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('k5gn1r6km05kfkrk4qpua1dno1iauqvt',NULL,'192.168.1.4',1608267817,'__ci_last_regenerate|i:1608267817;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('g69mqb70e2fucbdgvvqtub2sp8spim81',NULL,'192.168.1.95',1608526588,'__ci_last_regenerate|i:1608526588;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('niuv61qv4md77p16jp57s9jpai2688bi',NULL,'192.168.1.97',1608530587,'__ci_last_regenerate|i:1608530587;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('n4jg9ncisgnv7udqme7j93kshtuujl4s',NULL,'192.168.1.4',1608531799,'__ci_last_regenerate|i:1608531799;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('lhahfs6uum80spi9mcg6fglgbephq7q3',NULL,'192.168.1.109',1608550628,'__ci_last_regenerate|i:1608550628;type|s:8:\"customer\";previous_url|s:44:\"http://klentano.msdev.in/product/detail/dfsd\";'),('q8ubq2un90cp0smnnb2oqou1s2qob56g',NULL,'192.168.1.109',1608550989,'__ci_last_regenerate|i:1608550989;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('fogd85dj2fn8n7qsr04ssmfsquh4bhcn',NULL,'192.168.1.109',1608551708,'__ci_last_regenerate|i:1608551708;type|s:8:\"customer\";previous_url|s:44:\"http://klentano.msdev.in/product/detail/dfsd\";'),('el3s1512tq8djuh6clcvn1jb1q7fc686',NULL,'192.168.1.109',1608558046,'__ci_last_regenerate|i:1608558046;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('k1941rndaeajq9374fbm59rgsgnorm13',NULL,'192.168.1.4',1608552990,'__ci_last_regenerate|i:1608552990;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('2lg3ptg0ms4i9hrfhqaa36dqp5t6kqi3',NULL,'192.168.1.96',1608555665,'__ci_last_regenerate|i:1608555665;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('t460kc1vlsl2jr7o3o4tbr4ekemog0di',NULL,'192.168.1.27',1608558097,'__ci_last_regenerate|i:1608558037;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('6in5da9pk49iq037u89a34fgufledald',NULL,'192.168.1.95',1608558386,'__ci_last_regenerate|i:1608558386;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('n1vem7btoocaa7l1mpguvhp7bnbcs9g3',NULL,'192.168.1.109',1608558430,'__ci_last_regenerate|i:1608558386;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('8eennlvassmhki10khmrltrhk49o3d42',NULL,'192.168.1.95',1608612508,'__ci_last_regenerate|i:1608612508;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/page/about-us\";'),('ee9vtd4qmiec3p8nthk9q1vm1vtmmfqt',NULL,'192.168.1.95',1608615134,'__ci_last_regenerate|i:1608615134;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('j2og634ho8ec616hibdgla6nucshospd',NULL,'192.168.1.95',1608620305,'__ci_last_regenerate|i:1608620305;type|s:8:\"customer\";previous_url|s:45:\"http://klentano.msdev.in/product/detail/sdasd\";'),('igq4ruudesnk2shfa7l8l22imrknpf62',NULL,'192.168.1.98',1608620170,'__ci_last_regenerate|i:1608620170;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('hstout5rdval15j773o102h21i6h1s8i',NULL,'192.168.1.4',1608619291,'__ci_last_regenerate|i:1608619109;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('7gag2r5ror603gagfth1om3us3o89a8j',NULL,'192.168.1.98',1608621065,'__ci_last_regenerate|i:1608621065;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('fktbqsln4etsks15tdidbn8ah9ikutde',NULL,'192.168.1.95',1608620305,'__ci_last_regenerate|i:1608620305;type|s:8:\"customer\";previous_url|s:25:\"http://klentano.msdev.in/\";'),('pifgtb6c0fdi1drc4rretavmf4a6tfcf',NULL,'192.168.1.98',1608621093,'__ci_last_regenerate|i:1608621065;type|s:8:\"customer\";previous_url|s:38:\"http://klentano.msdev.in/customer/auth\";');
/*!40000 ALTER TABLE `ec_customer_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_enquiry`
--

DROP TABLE IF EXISTS `ec_enquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_enquiry` (
  `enquiry_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `custype` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`enquiry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_enquiry`
--

LOCK TABLES `ec_enquiry` WRITE;
/*!40000 ALTER TABLE `ec_enquiry` DISABLE KEYS */;
INSERT INTO `ec_enquiry` VALUES (59,'vvvv',NULL,'vvvv@vv.com',NULL,'subscribe','2020-12-03 06:40:20','192.168.1.95'),(58,'hello',NULL,'hello@kk.com',NULL,'subscribe','2020-12-03 06:39:07','192.168.1.95'),(57,'opsingh',NULL,'opsingh@ff.com',NULL,'subscribe','2020-12-03 06:38:38','192.168.1.95'),(56,'jay44',NULL,'jay44@kk.com',NULL,'subscribe','2020-12-03 06:36:46','192.168.1.95'),(55,'spsingt',NULL,'spsingt@hh.com',NULL,'subscribe','2020-12-03 06:36:08','192.168.1.95'),(60,'aaa',NULL,'aaa@ddd.com',NULL,'subscribe','2020-12-03 06:43:40','192.168.1.95'),(61,'aaa',NULL,'aaa@ddd.com',NULL,'subscribe','2020-12-03 06:43:42','192.168.1.95'),(62,'zhr46228',NULL,'zhr46228@bcaoo.com',NULL,'subscribe','2020-12-07 05:58:19','192.168.1.108'),(63,'zov79649',NULL,'zov79649@bcaoo.com',NULL,'subscribe','2020-12-07 05:59:33','192.168.1.108');
/*!40000 ALTER TABLE `ec_enquiry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_gallery`
--

DROP TABLE IF EXISTS `ec_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_gallery`
--

LOCK TABLES `ec_gallery` WRITE;
/*!40000 ALTER TABLE `ec_gallery` DISABLE KEYS */;
INSERT INTO `ec_gallery` VALUES (1,0,'','Priscilla_(Testimonial).png','2020-12-16 15:06:53','2020-12-16 15:06:53',1),(33,52,'','71654377_708668726280159_2402002138650640384_o1.jpg','2020-12-16 18:30:52','2020-12-16 18:30:52',1),(34,52,'','amazonead-min1.jpg','2020-12-16 18:30:52','2020-12-16 18:30:52',1),(35,53,'','71654377_708668726280159_2402002138650640384_o2.jpg','2020-12-17 12:25:26','2020-12-17 12:25:26',1),(36,53,'','amazonead-min2.jpg','2020-12-17 12:25:26','2020-12-17 12:25:26',1),(37,54,'','71654377_708668726280159_2402002138650640384_o3.jpg','2020-12-17 12:45:46','2020-12-17 12:45:46',1),(38,54,'','amazonead-min3.jpg','2020-12-17 12:45:46','2020-12-17 12:45:46',1),(41,56,'','71654377_708668726280159_2402002138650640384_o5.jpg','2020-12-17 12:51:04','2020-12-17 12:51:04',1),(45,57,'','amazonead-min6.jpg','2020-12-17 12:57:19','2020-12-17 12:57:19',1),(47,58,'','71654377_708668726280159_2402002138650640384_o7.jpg','2020-12-17 13:06:31','2020-12-17 13:06:31',1),(48,58,'','amazonead-min7.jpg','2020-12-17 13:06:31','2020-12-17 13:06:31',1),(49,58,'','bgservices2.jpg','2020-12-17 13:06:31','2020-12-17 13:06:31',1),(51,59,'','71654377_708668726280159_2402002138650640384_o12.jpg','2020-12-17 13:48:12','2020-12-17 13:48:12',1),(56,59,'','sign-up-page-for-viral-bake1.png','2020-12-17 17:04:18','2020-12-17 17:04:18',1),(59,60,'','75h1.jpg','2020-12-18 12:41:21','2020-12-18 12:41:21',1),(60,60,'','sign-up-page-for-viral-bake3.png','2020-12-18 12:44:12','2020-12-18 12:44:12',1);
/*!40000 ALTER TABLE `ec_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_language`
--

DROP TABLE IF EXISTS `ec_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` text,
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_language`
--

LOCK TABLES `ec_language` WRITE;
/*!40000 ALTER TABLE `ec_language` DISABLE KEYS */;
INSERT INTO `ec_language` VALUES (1,'Arabic',NULL,'1','2020-11-27 11:19:30','2020-11-27 11:19:30'),(2,'Chinese',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(3,'English',NULL,'1','2020-11-27 11:19:30','2020-11-27 11:19:30'),(4,'French',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(5,'German',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(6,'Hindi',NULL,'1','2020-11-27 11:19:30','2020-11-27 11:19:30'),(7,'Italian',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(8,'Japanese',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(9,'Polish',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(10,'Portuguese',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(11,'Russian',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(12,'Spanish',NULL,'0','2020-11-27 11:19:30','2020-11-27 11:20:29'),(13,'Turkish',NULL,'0','2020-11-27 11:19:31','2020-11-27 11:20:29');
/*!40000 ALTER TABLE `ec_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_page`
--

DROP TABLE IF EXISTS `ec_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_content` text,
  `post_type` varchar(100) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_page`
--

LOCK TABLES `ec_page` WRITE;
/*!40000 ALTER TABLE `ec_page` DISABLE KEYS */;
INSERT INTO `ec_page` VALUES (1,1,'xhere are many variations of passage','xhere-are-many-variations-of-passage','ccchere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. ','page',NULL,'1','2020-12-03 17:56:10','2020-12-03 17:58:23'),(2,1,'Where does it come from?','where-does-it-come-from','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.','page',NULL,'0','2020-12-03 17:58:53','2020-12-03 17:59:01'),(3,1,'There are many variations of passages of Lorem','there-are-many-variations-of-passages-of-lorem','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a','page',NULL,'1','2020-12-03 17:59:16','2020-12-03 17:59:16'),(4,1,'The standard Lorem I','the-standard-lorem-i','<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<ul class=\"mt-2 ml-5 mb-2\">\r\n <li><i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Any Product types that You want - Simple, Configurable</li>\r\n <li><i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Downloadable/Digital Products, Virtual Products</li>\r\n <li><i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Inventory Management with Backordered items</li>\r\n</ul>\r\n<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>                                       \r\n','page',NULL,'1','2020-12-03 17:59:40','2020-12-04 16:02:52'),(5,1,'About','about','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br><br> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br> \r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br> \r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br> \r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','page',NULL,'1','2020-12-04 16:06:37','2020-12-04 16:07:27'),(6,1,'Our Stores','our-stores','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><br>','page',NULL,'1','2020-12-04 16:08:30','2020-12-04 16:08:30'),(7,1,'Help & FAQs','help--faqs','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br>','page',NULL,'1','2020-12-04 16:09:17','2020-12-04 16:09:17'),(8,1,'Help Center','help-center','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><br>','page',NULL,'1','2020-12-04 16:10:10','2020-12-17 11:21:32'),(9,1,' Services','services','<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><br><br>\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><br><br><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><br><br><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><br><br><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><br><br>','page',NULL,'1','2020-12-04 16:10:54','2020-12-04 16:10:54'),(10,1,'Help Centar','help-centar','<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><br></br><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><br></br><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><br></br><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><br></br>','page',NULL,'1','2020-12-04 16:11:32','2020-12-17 11:22:27'),(11,1,'asd','asd','asdasdasd','page',NULL,'1','2020-12-04 16:26:50','2020-12-04 16:26:50'),(12,1,'bbbb','bbbb','bbbbbbbbbbbbbbb','page',NULL,'1','2020-12-04 16:27:02','2020-12-04 16:28:51'),(13,1,'hhhh','hhhh','hhhh hhhh','page',NULL,'1','2020-12-09 11:52:46','2020-12-09 11:52:46'),(14,1,'kkk11','kkk11','kkk kkkkkk kkkkkk kkkkkk kkk11','page',NULL,'1','2020-12-09 12:08:06','2020-12-09 12:08:17'),(15,1,'asdsda','asdsda','sasdasd','page',NULL,'1','2020-12-09 15:27:39','2020-12-09 15:27:39'),(16,1,'as','as','asd','page',NULL,'1','2020-12-09 15:27:49','2020-12-09 15:27:49'),(17,1,'asd','asd','as','page',NULL,'1','2020-12-09 15:30:14','2020-12-09 15:30:14'),(18,1,'zxc','zxc','zxc','page',NULL,'0','2020-12-09 15:33:32','2020-12-09 15:33:32'),(19,1,'bbbbbbb','bbbbbbb','fg','page','bbb1607512608.png','1','2020-12-09 15:33:42','2020-12-09 16:46:48'),(20,1,'gggggggggg','gggggggggg','kkkkkkkk kkkkkkk kkkkkkkk kkkkkkkkkkkkkkk kkkkkkkkkkkkkkk kkkkkkk','page','ggg1607512618.jpg','1','2020-12-09 16:12:08','2020-12-09 16:46:58'),(25,1,'wwww-1','wwww-1','wwww-1ww ww-1wwww -1wwww-1','page',NULL,'1','2020-12-09 16:54:51','2020-12-09 16:54:51'),(28,1,'Contact Us','contact-us','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.','page',NULL,'1','2020-12-17 11:17:52','2020-12-17 11:17:52');
/*!40000 ALTER TABLE `ec_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_posts`
--

DROP TABLE IF EXISTS `ec_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_content` text,
  `post_type` varchar(100) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_posts`
--

LOCK TABLES `ec_posts` WRITE;
/*!40000 ALTER TABLE `ec_posts` DISABLE KEYS */;
INSERT INTO `ec_posts` VALUES (83,1,'What is Lorem Ipsum?','what-is-lorem-ipsum','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. ','posts',NULL,'1','2020-12-03 14:01:14','2020-12-03 14:01:14'),(84,1,'Why do we use it?','why-do-we-use-it','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident','posts',NULL,'1','2020-12-03 14:01:27','2020-12-03 14:01:27'),(85,1,'Where does it come from?','where-does-it-come-from','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. ','posts',NULL,'1','2020-12-03 14:01:43','2020-12-03 14:01:43'),(87,1,'vvThe standard Lorem Ipsum passage, used since the 1500s','vvthe-standard-lorem-ipsum-passage-used-since-the-1500s','xLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum','posts',NULL,'0','2020-12-03 14:02:22','2020-12-03 15:29:07'),(88,1,'xIt is a long established fact that a reader will be distracted','xit-is-a-long-established-fact-that-a-reader-will-be-distracted','xIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text','posts',NULL,'0','2020-12-03 14:56:08','2020-12-03 15:20:43'),(95,1,'amit 0012','amit-0012','amit001amit001ami t001amit 0012','posts',NULL,'1','2020-12-11 19:13:25','2020-12-11 19:17:35');
/*!40000 ALTER TABLE `ec_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_posts_categories`
--

DROP TABLE IF EXISTS `ec_posts_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_posts_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_categories_categories1` (`category_id`),
  KEY `fk_posts_categories_posts1` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_posts_categories`
--

LOCK TABLES `ec_posts_categories` WRITE;
/*!40000 ALTER TABLE `ec_posts_categories` DISABLE KEYS */;
INSERT INTO `ec_posts_categories` VALUES (1,11,19),(2,12,19),(3,16,19),(5,17,19),(6,17,37),(7,95,36);
/*!40000 ALTER TABLE `ec_posts_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_posts_tags`
--

DROP TABLE IF EXISTS `ec_posts_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_posts_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_tags_tags1` (`tag_id`),
  KEY `fk_posts_tags_posts1` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_posts_tags`
--

LOCK TABLES `ec_posts_tags` WRITE;
/*!40000 ALTER TABLE `ec_posts_tags` DISABLE KEYS */;
INSERT INTO `ec_posts_tags` VALUES (1,12,16),(2,16,18),(3,17,17),(5,16,17),(6,17,18),(8,95,18);
/*!40000 ALTER TABLE `ec_posts_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product`
--

DROP TABLE IF EXISTS `ec_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_content` text,
  `sale_price` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `regular_price` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `quantity_range` varchar(255) NOT NULL,
  `price_range` varchar(255) NOT NULL,
  `post_type` varchar(100) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product`
--

LOCK TABLES `ec_product` WRITE;
/*!40000 ALTER TABLE `ec_product` DISABLE KEYS */;
INSERT INTO `ec_product` VALUES (2,1,'What is Lorem Ipsum?','what-is-lorem-ipsum','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries','0','0','',0,'','','product',NULL,'1','2020-12-03 17:35:52','2020-12-03 17:35:52'),(3,1,'Why do we use it?','why-do-we-use-it','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. ','11','12','sku001',100,'a:1:{i:0;s:3:\"222\";}','a:1:{i:0;s:2:\"22\";}','product',NULL,'1','2020-12-03 17:36:05','2020-12-17 12:23:39'),(55,1,'aaaaaaa','aaaaaaa','aaaaaaaa','1','111','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-17 12:46:15','2020-12-17 12:46:15'),(56,1,'aa','aa','asd','','11','aa',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-17 12:51:04','2020-12-17 12:51:04'),(57,1,'ggg','ggg','ggggggggg','11','111','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-17 12:57:19','2020-12-17 12:57:19'),(58,1,'xxxx','xxxx','xxxxxxxxx','','11','11',111,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-17 13:06:31','2020-12-17 13:06:31'),(59,1,'zzzxxqqq','zzzxxqqq','zzzxxxqqq','101','1121','13312',14,'a:2:{i:0;s:2:\"11\";i:1;s:3:\"112\";}','a:2:{i:0;s:2:\"11\";i:1;s:1:\"3\";}','product',NULL,'1','2020-12-17 13:11:58','2020-12-17 18:32:14'),(60,1,'sp yadav','sp-yadav','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum','10','11','1sdas',21222,'a:1:{i:0;s:2:\"11\";}','a:1:{i:0;s:1:\"1\";}','product',NULL,'1','2020-12-18 10:35:13','2020-12-18 10:35:13'),(61,1,'aa','aa','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-18 17:22:35','2020-12-18 17:22:35'),(62,1,'f','f','vbcbv','11','11','11',12,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-18 18:23:17','2020-12-18 18:23:17'),(63,1,'adasd','adasd','sadasd','22','22','22',123,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-18 18:28:07','2020-12-18 18:28:07'),(64,1,'aaa','aaa','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-18 18:32:07','2020-12-18 18:32:07'),(65,1,'aa','aa','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-18 18:34:30','2020-12-18 18:34:30'),(66,1,'aaaa','aaaa','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 10:27:13','2020-12-21 10:27:13'),(67,1,'ss','ss','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 11:08:28','2020-12-21 11:08:28'),(68,1,'aa','aa','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 11:11:39','2020-12-21 11:11:39'),(69,1,'ss','ss','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 11:15:42','2020-12-21 11:15:42'),(70,1,'sadas','sadas','','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 11:17:04','2020-12-21 11:17:04'),(71,1,'jjj','jjj','jj','','','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 11:25:46','2020-12-21 11:25:46'),(72,1,'asds','asds','asd','11','11','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 12:50:47','2020-12-21 12:50:47'),(73,1,'11','11','kkk','11','11','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 13:34:52','2020-12-21 13:34:52'),(74,1,'a','a','asd','','1','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 13:50:08','2020-12-21 13:50:08'),(75,1,'dfsd','dfsd','sdf','','11','',0,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 13:50:27','2020-12-21 13:50:27'),(76,1,'3esdf','3esdf','sdf','234','34234','23',2323,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-21 19:08:07','2020-12-21 19:08:07'),(77,1,'sdasd','sdasd','','','11','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-22 10:16:41','2020-12-22 10:16:41'),(78,1,'jay001','jay001','jay001','','11','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-22 11:15:41','2020-12-22 11:15:41'),(79,1,'jay002','jay002','jay002','11','11','11',11,'a:1:{i:0;s:0:\"\";}','a:1:{i:0;s:0:\"\";}','product',NULL,'1','2020-12-22 11:53:01','2020-12-22 11:53:01');
/*!40000 ALTER TABLE `ec_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_categories`
--

DROP TABLE IF EXISTS `ec_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_categories_categories1` (`category_id`),
  KEY `fk_posts_categories_posts1` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_categories`
--

LOCK TABLES `ec_product_categories` WRITE;
/*!40000 ALTER TABLE `ec_product_categories` DISABLE KEYS */;
INSERT INTO `ec_product_categories` VALUES (56,18,37),(58,19,36),(59,19,19),(61,20,20),(62,21,20),(63,21,19),(64,22,19),(65,25,20),(66,26,19),(67,27,20),(68,33,19),(69,40,19),(70,47,20),(71,48,20),(72,52,20),(73,59,19),(74,60,19),(75,63,20),(76,63,19),(77,70,19),(78,70,20),(79,72,20),(80,78,19),(81,79,19);
/*!40000 ALTER TABLE `ec_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_tags`
--

DROP TABLE IF EXISTS `ec_product_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_product_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_tags_tags1` (`tag_id`),
  KEY `fk_posts_tags_posts1` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_tags`
--

LOCK TABLES `ec_product_tags` WRITE;
/*!40000 ALTER TABLE `ec_product_tags` DISABLE KEYS */;
INSERT INTO `ec_product_tags` VALUES (42,19,18),(45,20,17),(46,20,16),(47,21,17),(48,22,16),(49,22,17),(50,26,17),(51,27,17),(52,40,17),(53,47,17),(54,48,17),(55,59,17),(56,60,17),(57,63,17),(58,70,17),(59,72,17);
/*!40000 ALTER TABLE `ec_product_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_tags_prod`
--

DROP TABLE IF EXISTS `ec_tags_prod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_tags_prod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_tags_prod`
--

LOCK TABLES `ec_tags_prod` WRITE;
/*!40000 ALTER TABLE `ec_tags_prod` DISABLE KEYS */;
INSERT INTO `ec_tags_prod` VALUES (16,'atag001','atag001',1),(17,'atag002-2','atag002-2',1);
/*!40000 ALTER TABLE `ec_tags_prod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_tax`
--

DROP TABLE IF EXISTS `ec_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ec_tax` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `rate` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `status` enum('0','1','2') DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_tax`
--

LOCK TABLES `ec_tax` WRITE;
/*!40000 ALTER TABLE `ec_tax` DISABLE KEYS */;
INSERT INTO `ec_tax` VALUES (1,'No Tax','No Tax','0',1,'1','2020-11-26 15:00:20','2020-11-26 15:01:34'),(2,'GST @6%','GST @6%','6',2,'1','2020-11-26 15:01:55','2020-11-26 15:01:55'),(3,'GST @12%','GST @12%','12',2,'1','2020-11-26 15:02:10','2020-11-26 15:02:10'),(4,'GST @18%','GST @18%','18',2,'1','2020-11-26 15:02:28','2020-11-26 15:02:28');
/*!40000 ALTER TABLE `ec_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uploaded_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (16,'jaytag1','jaytag1',1),(17,'jay245','jay245',1),(18,'hello12','hello12',1),(19,'rtet','rtet',1),(20,'amit001tag','amit001tag',1);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-22 13:21:52
