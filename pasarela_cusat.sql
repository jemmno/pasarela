# ************************************************************
# Sequel Pro SQL dump
# Version 5426
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.12)
# Database: pasarela_cusat
# Generation Time: 2019-01-25 20:57:39 +0000
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16le;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(250) NOT NULL,
  `authKey` varchar(250) CHARACTER SET utf16 COLLATE utf16_general_ci DEFAULT '',
  `password_reset_token` varchar(250) CHARACTER SET utf16 COLLATE utf16_general_ci DEFAULT '',
  `user_level` enum('Admin','Normal') NOT NULL DEFAULT 'Admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `username`, `email`, `password`, `authKey`, `password_reset_token`, `user_level`)
VALUES
	(4,'Admin','','','admin','admin@example.com','$2y$13$NaZ.txRasU6lYu7kMWw9duPTDuRLdpqPfT72/jiKUIErMnBT/QOwi','','','Admin');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vehiculos
# ------------------------------------------------------------

CREATE TABLE `vehiculos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patente` varchar(12) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL DEFAULT '',
  `imei` varchar(15) NOT NULL DEFAULT '',
  `descripcion` text,
  `gps` varchar(12) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL DEFAULT '',
  `id_satelital` char(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf16;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
