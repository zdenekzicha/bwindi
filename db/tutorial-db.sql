-- Adminer 3.6.2 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `kids`;
CREATE TABLE `kids` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `vs` int(6) NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `school` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `paymentsPaied` int(5) NOT NULL,
  `paymentsAll` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `web` tinyint(1) NOT NULL,
  `foto` tinyint(1) NOT NULL,
  `sponzor` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `kids` (`id`, `vs`, `name`, `sex`, `school`, `paymentsPaied`, `paymentsAll`, `status`, `web`, `foto`, `sponzor`) VALUES
(1,	1111,	'Abel Byamugisha',	1,	'Trinity college - S4',	4800,	9800,	1,	1,	1,	'Bouček Jiří'),
(2,	2222,	'Benjamin Friday',	1,	'Buhoma High School-S4',	4000,	9800,	1,	1,	0,	'Martin Navrátil'),
(3,	3333,	'Brenda Atwijukire',	0,	'Buhoma High School-S3',	3000,	9800,	0,	0,	1,	'');

-- 2013-02-03 13:37:26