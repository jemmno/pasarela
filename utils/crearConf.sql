# ************************************************************
# Sequel Pro SQL dump
# Version 5426
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.13)
# Database: pasarela_cusat
# Generation Time: 2019-01-17 10:13:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table configs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `configs`;

CREATE TABLE `configs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `port_listen` int(11) DEFAULT NULL,
  `ip_listen` varchar(16) CHARACTER SET utf16le COLLATE utf16le_general_ci DEFAULT NULL,
  `local_ip_forward` varchar(16) DEFAULT NULL,
  `local_port_forward` int(11) DEFAULT NULL,
  `ip_forward` varchar(16) DEFAULT NULL,
  `port_forward` int(11) DEFAULT NULL,
  `access_id` varchar(12) DEFAULT NULL,
  `password` varchar(12) DEFAULT NULL,
  `dif_horaria` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;

INSERT INTO `configs` (`id`, `port_listen`, `ip_listen`, `local_ip_forward`, `local_port_forward`, `ip_forward`, `port_forward`, `access_id`, `password`, `dif_horaria`)
VALUES
	(1,55555,'127.0.0.1','127.0.0.2',65437,'127.0.0.3',76545,'asdmne','23dkf34','-2');

/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
