# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.20-log)
# Database: matchr
# Generation Time: 2012-03-01 21:29:52 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

CREATE DATABASE `matchr`;

USE 'matchr';

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`category_id`, `name`)
VALUES
	(1,'Appearance'),
	(2,'Entertainment'),
	(3,'Food'),
	(4,'People'),
	(5,'Activities');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table responses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `responses`;

CREATE TABLE `responses` (
  `response_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `topic_id` int(11) unsigned DEFAULT NULL,
  `response` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`response_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;

INSERT INTO `responses` (`response_id`, `user_id`, `topic_id`, `response`)
VALUES
	(1,2,1,10),
	(2,2,2,1),
	(3,2,3,3),
	(4,2,4,1),
	(5,2,5,1),
	(6,2,6,10),
	(7,2,7,1),
	(8,2,8,1),
	(9,2,9,1),
	(10,2,10,1),
	(11,2,11,10),
	(12,2,12,3),
	(13,2,13,10),
	(14,2,14,10),
	(15,2,15,10),
	(16,2,16,1),
	(17,2,17,3),
	(18,2,18,1),
	(19,2,19,1),
	(20,2,20,10),
	(21,2,21,10),
	(22,2,22,3),
	(23,2,23,1),
	(24,2,24,1),
	(25,2,25,10),
	(26,1,1,10),
	(27,1,2,3),
	(28,1,3,3),
	(29,1,4,1),
	(30,1,5,3),
	(31,1,6,10),
	(32,1,7,1),
	(33,1,8,10),
	(34,1,9,3),
	(35,1,10,1),
	(36,1,11,10),
	(37,1,12,10),
	(38,1,13,10),
	(39,1,14,10),
	(40,1,15,10),
	(41,1,16,1),
	(42,1,17,3),
	(43,1,18,3),
	(44,1,19,3),
	(45,1,20,3),
	(46,1,21,10),
	(47,1,22,10),
	(48,1,23,1),
	(49,1,24,1),
	(50,1,25,10),
	(51,3,1,10),
	(52,3,2,1),
	(53,3,3,3),
	(54,3,4,10),
	(55,3,5,3),
	(56,3,6,1),
	(57,3,7,10),
	(58,3,8,3),
	(59,3,9,10),
	(60,3,10,10),
	(61,3,11,10),
	(62,3,12,10),
	(63,3,13,10),
	(64,3,14,10),
	(65,3,15,10),
	(66,3,16,1),
	(67,3,17,3),
	(68,3,18,10),
	(69,3,19,10),
	(70,3,20,10),
	(71,3,21,10),
	(72,3,22,3),
	(73,3,23,1),
	(74,3,24,10),
	(75,3,25,1),
	(76,4,1,1),
	(77,4,2,10),
	(78,4,3,10),
	(79,4,4,1),
	(80,4,5,10),
	(81,4,6,1),
	(82,4,7,1),
	(83,4,8,1),
	(84,4,9,10),
	(85,4,10,10),
	(86,4,11,10),
	(87,4,12,1),
	(88,4,13,10),
	(89,4,14,3),
	(90,4,15,1),
	(91,4,16,1),
	(92,4,17,1),
	(93,4,18,10),
	(94,4,19,10),
	(95,4,20,10),
	(96,4,21,10),
	(97,4,22,1),
	(98,4,23,10),
	(99,4,24,10),
	(100,4,25,1),
	(101,5,1,1),
	(102,5,2,1),
	(103,5,3,1),
	(104,5,4,1),
	(105,5,5,10),
	(106,5,6,10),
	(107,5,7,1),
	(108,5,8,3),
	(109,5,9,1),
	(110,5,10,1),
	(111,5,11,10),
	(112,5,12,10),
	(113,5,13,3),
	(114,5,14,3),
	(115,5,15,1),
	(116,5,16,10),
	(117,5,17,3),
	(118,5,18,10),
	(119,5,19,10),
	(120,5,20,10),
	(121,5,21,10),
	(122,5,22,1),
	(123,5,23,10),
	(124,5,24,10),
	(125,5,25,10),
	(126,6,1,1),
	(127,6,2,1),
	(128,6,3,1),
	(129,6,4,10),
	(130,6,5,1),
	(131,6,6,10),
	(132,6,7,1),
	(133,6,8,10),
	(134,6,9,10),
	(135,6,10,10),
	(136,6,11,10),
	(137,6,12,1),
	(138,6,13,1),
	(139,6,14,3),
	(140,6,15,1),
	(141,6,16,10),
	(142,6,17,3),
	(143,6,18,10),
	(144,6,19,10),
	(145,6,20,10),
	(146,6,21,10),
	(147,6,22,3),
	(148,6,23,3),
	(149,6,24,1),
	(150,6,25,1),
	(151,7,1,10),
	(152,7,2,1),
	(153,7,3,3),
	(154,7,4,1),
	(155,7,5,10),
	(156,7,6,1),
	(157,7,7,3),
	(158,7,8,1),
	(159,7,9,10),
	(160,7,10,1),
	(161,7,11,3),
	(162,7,12,1),
	(163,7,13,10),
	(164,7,14,1),
	(165,7,15,3),
	(166,7,16,1),
	(167,7,17,10),
	(168,7,18,1),
	(169,7,19,3),
	(170,7,20,1),
	(171,7,21,10),
	(172,7,22,1),
	(173,7,23,3),
	(174,7,24,1),
	(175,7,25,10);

/*!40000 ALTER TABLE `responses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics` (
  `topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(48) DEFAULT NULL,
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;

INSERT INTO `topics` (`topic_id`, `name`, `category_id`)
VALUES
	(1,'Tattoos',1),
	(2,'Body piercings',1),
	(3,'Gold chains',1),
	(4,'Cowboy boots',1),
	(5,'Long hair',1),
	(6,'Reality TV',2),
	(7,'Professional wrestling',2),
	(8,'Horror movies',2),
	(9,'Easy listening music',2),
	(10,'The opera',2),
	(11,'Sushi',3),
	(12,'Spam',3),
	(13,'Spicy food',3),
	(14,'Cilantro',3),
	(15,'Martinis',3),
	(16,'Howard Stern',4),
	(17,'Bill Gates',4),
	(18,'Barbara Streisand',4),
	(19,'Hugh Hefner',4),
	(20,'Martha Stewart',4),
	(21,'Yoga',5),
	(22,'Weightlifting',5),
	(23,'Cube puzzles',5),
	(24,'Karaoke',5),
	(25,'Hiking',5);

/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL DEFAULT '',
  `pass` varchar(40) NOT NULL DEFAULT '',
  `join_date` datetime NOT NULL,
  `first_name` varchar(32) NOT NULL DEFAULT '',
  `last_name` varchar(32) NOT NULL DEFAULT '',
  `gender` varchar(1) NOT NULL DEFAULT '',
  `birthdate` date NOT NULL,
  `city` varchar(32) NOT NULL DEFAULT '',
  `state` varchar(2) NOT NULL DEFAULT '',
  `picture` varchar(32) NOT NULL DEFAULT '',
  `here_for` varchar(1) NOT NULL DEFAULT '',
  `same_sex` int(1) unsigned zerofill DEFAULT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `email`, `pass`, `join_date`, `first_name`, `last_name`, `gender`, `birthdate`, `city`, `state`, `picture`, `here_for`, `same_sex`, `bio`)
VALUES
	(1,'larry.ross54@example.com','13a760f11be2108b4e6dfb75dd67ed90a9659989','2012-03-01 08:11:22','Larry','Ross','M','1973-07-01','San Francisco','CA','1_borat2.jpg','F',0,'I am Larry!'),
	(2,'beth.lawrence22@example.com','4a48f4493687862de95ff7f24ad063c6ef209784','2012-03-01 08:13:09','Beth','Lawrence','F','1983-03-06','Burbank','CA','2_3_Idiots.jpg','M',0,'I am Beth!'),
	(3,'sulu@startrek.com','420fea93ab7d2790d9481531749433e1b22b2e53','2012-03-01 09:15:10','George','Takei','M','1937-04-20','Los Angeles','CA','3_georgetakei.jpg','M',1,'Although primarily known for playing Hikaru Sulu in the television series Star Trek and the first six features, George Takei has had a varied career acting in television, feature films, live theater and radio. He also is a successful writer and community activist.'),
	(4,'alambert@ai.com','9b8f9c6e76560ed79fc2cb82e6e4b27018a329ec','2012-03-01 09:17:05','Adam','Lambert','M','1982-01-29','Los Angeles','CA','4_Adam-Lambert.jpg','M',1,'Citing influence from various artists, Lambert has become recognized for his flamboyant, theatrical and androgynous performance style, and his powerful and technically skilled tenor voice with multi-octave range.'),
	(5,'ellen@ellen.com','5f04eb164685f0aa07334b1f50e9707f3de35164','2012-03-01 09:53:21','Ellen','Degeneres','F','1958-01-26','Los Angeles','CA','5_Ellen2.jpg','F',2,'As a film actress, she starred in Mr. Wrong, appeared in EDtv and The Love Letter, and provided the voice of Dory in the Disney-Pixar animated film Finding Nemo, for which she was awarded a Saturn Award for Best Supporting Actress, the first and only time a voice performance won a Saturn Award.'),
	(6,'portia@ellen.com','3d6fad714086e3bfcfceac54ff39bd616980abc9','2012-03-01 09:56:32','Portia','de Rossi','F','1973-01-31','Los Angeles','CA','6_portia-de-rossi.jpg','F',2,'An Australian-American actress, best known for her roles as lawyer Nelle Porter on the television series Ally McBeal and Lindsay Bluth F&#252;nke on the sitcom Arrested Development.[1][2] She also portrayed Veronica Palmer on the ABC sitcom Better Off Ted and Olivia Lord on Nip/Tuck.'),
	(7,'demo@adamyagiz.com','89e495e7941cf9e40e6980d14a16bf023ccd4c91','2012-03-01 13:55:37','Demo','Demo','M','1994-12-31','Anywhere','AL','','F',0,'Welcome to the demo account.');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
