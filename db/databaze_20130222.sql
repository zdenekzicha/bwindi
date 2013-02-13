-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úterý 12. února 2013, 18:46
-- Verze MySQL: 5.1.36
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `novadb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `benefit`
--

CREATE TABLE IF NOT EXISTS `benefit` (
  `idBenefit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) DEFAULT NULL,
  `aktivniZaznam` tinyint(1) DEFAULT NULL,
  `castka` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idBenefit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `benefit`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `dite`
--

CREATE TABLE IF NOT EXISTS `dite` (
  `idDite` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `skolaIdSkola` int(10) unsigned DEFAULT NULL,
  `jmeno` varchar(255) NOT NULL,
  `pohlavi` varchar(20) NOT NULL,
  `datumNarozeni` varchar(45) DEFAULT NULL,
  `vsym` int(10) unsigned NOT NULL,
  `vystavene` tinyint(1) DEFAULT NULL,
  `aktivniZaznam` tinyint(1) DEFAULT NULL,
  `datumVzniku` date DEFAULT NULL,
  `datumZaniku` date DEFAULT NULL,
  `rocnik` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idDite`),
  KEY `dite_FKIndex1` (`skolaIdSkola`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=436 ;

--
-- Vypisuji data pro tabulku `dite`
--

INSERT INTO `dite` (`idDite`, `skolaIdSkola`, `jmeno`, `pohlavi`, `datumNarozeni`, `vsym`, `vystavene`, `aktivniZaznam`, `datumVzniku`, `datumZaniku`, `rocnik`) VALUES
(219, 0, 'Abel Byamugisha', 'M', NULL, 1061, 1, NULL, NULL, NULL, NULL),
(220, 0, 'Abraham Ecoku', 'M', NULL, 2034, 1, NULL, NULL, NULL, NULL),
(221, 0, 'Agenatio Ongima', 'M', NULL, 2070, 1, NULL, NULL, NULL, NULL),
(222, 0, 'Aggrey Musinguzi', 'M', NULL, 1058, 1, NULL, NULL, NULL, NULL),
(223, 0, 'Agnes Akiteng', 'F', NULL, 2022, 1, NULL, NULL, NULL, NULL),
(224, 0, 'Aidah Tumushabe', 'F', NULL, 1004, 1, NULL, NULL, NULL, NULL),
(225, 0, 'Alberta Alulo', 'F', NULL, 2074, 1, NULL, NULL, NULL, NULL),
(226, 0, 'Alfred Ekaju', 'M', NULL, 2035, 1, NULL, NULL, NULL, NULL),
(227, 0, 'Allan Masiko', 'M', NULL, 1074, 1, NULL, NULL, NULL, NULL),
(228, 0, 'Ambrose Ampeire', 'M', NULL, 1097, 1, NULL, NULL, NULL, NULL),
(229, 0, 'Amon Ampumuza', 'M', NULL, 1106, 1, NULL, NULL, NULL, NULL),
(230, 0, 'Amos Mugarura', 'M', NULL, 1144, 1, NULL, NULL, NULL, NULL),
(231, 0, 'Andrew Okiria', 'M', NULL, 2004, 1, NULL, NULL, NULL, NULL),
(232, 0, 'Anitah Atuhaire', 'F', NULL, 1005, 1, NULL, NULL, NULL, NULL),
(233, 0, 'Ann Margrit Acume', 'F', NULL, 2081, 1, NULL, NULL, NULL, NULL),
(234, 0, 'Anna Grace Agojo', 'F', NULL, 2030, 1, NULL, NULL, NULL, NULL),
(235, 0, 'Anna Grace Ikwilu', 'F', NULL, 2059, 1, NULL, NULL, NULL, NULL),
(236, 0, 'Annet Kyorikunda', 'F', NULL, 1006, 1, NULL, NULL, NULL, NULL),
(237, 0, 'Apofia Kenyangi', 'F', NULL, 1007, 1, NULL, NULL, NULL, NULL),
(238, 0, 'Arnold Amutuheire', 'M', NULL, 1105, 1, NULL, NULL, NULL, NULL),
(239, 0, 'Asheri Ampeire', 'F', NULL, 1078, 1, NULL, NULL, NULL, NULL),
(240, 0, 'Barbra Akamo', 'F', NULL, 2013, 1, NULL, NULL, NULL, NULL),
(241, 0, 'Benjamin Friday', 'M', NULL, 1009, 1, NULL, NULL, NULL, NULL),
(242, 0, 'Benjamin Orago', 'M', NULL, 2086, 1, NULL, NULL, NULL, NULL),
(243, 0, 'Bless Ainembabazi', 'F', NULL, 1010, 1, NULL, NULL, NULL, NULL),
(244, 0, 'Boaz Twinomujumi', 'M', NULL, 1145, 1, NULL, NULL, NULL, NULL),
(245, 0, 'Boniface Nahabwe', 'M', NULL, 1116, 1, NULL, NULL, NULL, NULL),
(246, 0, 'Brenda Akansarira', 'F', NULL, 1118, 1, NULL, NULL, NULL, NULL),
(247, 0, 'Brenda Atwijukire', 'F', NULL, 1127, 1, NULL, NULL, NULL, NULL),
(248, 0, 'Brenda Nahabwe', 'F', NULL, 1094, 1, NULL, NULL, NULL, NULL),
(249, 0, 'Caroline Amutuheire', 'F', NULL, 1057, 1, NULL, NULL, NULL, NULL),
(250, 0, 'Caroline Ayebare', 'F', NULL, 1060, 1, NULL, NULL, NULL, NULL),
(251, 0, 'Caroline Kiconco', 'F', NULL, 1070, 1, NULL, NULL, NULL, NULL),
(252, 0, 'Charles Okiria', 'M', NULL, 2102, 1, NULL, NULL, NULL, NULL),
(253, 0, 'Chris Atumanya', 'M', NULL, 1011, 1, NULL, NULL, NULL, NULL),
(254, 0, 'Chrispuse Mukombe', 'M', NULL, 1098, 1, NULL, NULL, NULL, NULL),
(255, 0, 'Christmas Orikiriza', 'M', NULL, 1077, 1, NULL, NULL, NULL, NULL),
(256, 0, 'Collins Muhumuza', 'M', NULL, 1133, 1, NULL, NULL, NULL, NULL),
(257, 0, 'Constance Ahabwe', 'F', NULL, 1151, 1, NULL, NULL, NULL, NULL),
(258, 0, 'Constance Turindwamukama', 'F', NULL, 1012, 1, NULL, NULL, NULL, NULL),
(259, 0, 'Cyril Tumwine', 'M', NULL, 1034, 1, NULL, NULL, NULL, NULL),
(260, 0, 'Daniel Engadu', 'M', NULL, 2014, 1, NULL, NULL, NULL, NULL),
(261, 0, 'David Omuron', 'M', NULL, 2095, 1, NULL, NULL, NULL, NULL),
(262, 0, 'Deborah Akiro', 'F', NULL, 2067, 1, NULL, NULL, NULL, NULL),
(263, 0, 'Denis Amutuheire', 'M', NULL, 1135, 1, NULL, NULL, NULL, NULL),
(264, 0, 'Denis Tusiime', 'M', NULL, 1014, 1, NULL, NULL, NULL, NULL),
(265, 0, 'Desire Akansasira', 'F', NULL, 1149, 1, NULL, NULL, NULL, NULL),
(266, 0, 'Diana Ampurira', 'F', NULL, 1114, 1, NULL, NULL, NULL, NULL),
(267, 0, 'Diana Ikima', 'F', NULL, 2094, 1, NULL, NULL, NULL, NULL),
(268, 0, 'Diana Kyakunzire', 'F', NULL, 1056, 1, NULL, NULL, NULL, NULL),
(269, 0, 'Diana Natukunda', 'F', NULL, 1015, 1, NULL, NULL, NULL, NULL),
(270, 0, 'Dickson Namanya', 'M', NULL, 1087, 1, NULL, NULL, NULL, NULL),
(271, 0, 'Doreen Ainembabazi', 'F', NULL, 1109, 1, NULL, NULL, NULL, NULL),
(272, 0, 'Edita Ampumuza', 'F', NULL, 1115, 1, NULL, NULL, NULL, NULL),
(273, 0, 'Edson Agaba', 'M', NULL, 1146, 1, NULL, NULL, NULL, NULL),
(274, 0, 'Edson Ndyamuhaki', 'M', NULL, 1091, 1, NULL, NULL, NULL, NULL),
(275, 0, 'Elly Nahurira', 'M', NULL, 1055, 1, NULL, NULL, NULL, NULL),
(276, 0, 'Emanuel Amanu', 'M', NULL, 2089, 1, NULL, NULL, NULL, NULL),
(277, 0, 'Emmanuel Egitu', 'M', NULL, 2028, 1, NULL, NULL, NULL, NULL),
(278, 0, 'Emmanuel Kasigyire', 'M', NULL, 1016, 1, NULL, NULL, NULL, NULL),
(279, 0, 'Emmanuel Namanya', 'M', NULL, 1126, 1, NULL, NULL, NULL, NULL),
(280, 0, 'Emmanuel Ojelel', 'M', NULL, 2003, 1, NULL, NULL, NULL, NULL),
(281, 0, 'Emmanuel Okiria', 'M', NULL, 2039, 1, NULL, NULL, NULL, NULL),
(282, 0, 'Erian Silver Ocen', 'M', NULL, 2085, 1, NULL, NULL, NULL, NULL),
(283, 0, 'Esther Alako', 'F', NULL, 2065, 1, NULL, NULL, NULL, NULL),
(284, 0, 'Eudo Lazaro', 'M', NULL, 2017, 1, NULL, NULL, NULL, NULL),
(285, 0, 'Eveline Adiao', 'F', NULL, 2047, 1, NULL, NULL, NULL, NULL),
(286, 0, 'Eveline Musiimire', 'F', NULL, 1002, 1, NULL, NULL, NULL, NULL),
(287, 0, 'Evelyne Akol', 'F', NULL, 2096, 1, NULL, NULL, NULL, NULL),
(288, 0, 'Foibe Barta Alio', 'F', NULL, 2097, 1, NULL, NULL, NULL, NULL),
(289, 0, 'Francis Onaba', 'M', NULL, 2088, 1, NULL, NULL, NULL, NULL),
(290, 0, 'Gad Twinamatsiko', 'M', NULL, 1111, 1, NULL, NULL, NULL, NULL),
(291, 0, 'Geofrey Etunyu', 'M', NULL, 2036, 1, NULL, NULL, NULL, NULL),
(292, 0, 'Geraldine Tumuramye', 'F', NULL, 1037, 1, NULL, NULL, NULL, NULL),
(293, 0, 'Gershom Niwamanya', 'M', NULL, 1141, 1, NULL, NULL, NULL, NULL),
(294, 0, 'Gift Ainembabazi', 'F', NULL, 1071, 1, NULL, NULL, NULL, NULL),
(295, 0, 'Gilian Nanyijuka', 'F', NULL, 1121, 1, NULL, NULL, NULL, NULL),
(296, 0, 'Grace Akejo', 'F', NULL, 2009, 1, NULL, NULL, NULL, NULL),
(297, 0, 'Grace Chance', 'F', NULL, 1017, 1, NULL, NULL, NULL, NULL),
(298, 0, 'Grace Naomi Aujo', 'F', NULL, 2071, 1, NULL, NULL, NULL, NULL),
(299, 0, 'Helda Akweso', 'F', NULL, 2083, 1, NULL, NULL, NULL, NULL),
(300, 0, 'Husein Wednesday', 'M', NULL, 1093, 1, NULL, NULL, NULL, NULL),
(301, 0, 'Ian Katushabe', 'M', NULL, 1131, 1, NULL, NULL, NULL, NULL),
(302, 0, 'Ignatius Ampeire', 'M', NULL, 1122, 1, NULL, NULL, NULL, NULL),
(303, 0, 'Immaculate Ayebare', 'F', NULL, 1092, 1, NULL, NULL, NULL, NULL),
(304, 0, 'Irene Betty Akutui', 'F', NULL, 2091, 1, NULL, NULL, NULL, NULL),
(305, 0, 'Isaac Acibu', 'M', NULL, 2006, 1, NULL, NULL, NULL, NULL),
(306, 0, 'Isaac Egeng', 'M', NULL, 2055, 1, NULL, NULL, NULL, NULL),
(307, 0, 'Isaac Erianu', 'M', NULL, 2063, 1, NULL, NULL, NULL, NULL),
(308, 0, 'Isaac John   Eilu', 'M', NULL, 2061, 1, NULL, NULL, NULL, NULL),
(309, 0, 'Isaac Otilo', 'M', NULL, 2021, 1, NULL, NULL, NULL, NULL),
(310, 0, 'Isabella Nkamushaba', 'F', NULL, 1001, 1, NULL, NULL, NULL, NULL),
(311, 0, 'Isack Ecemu', 'M', NULL, 2100, 1, NULL, NULL, NULL, NULL),
(312, 0, 'Isack Orena', 'M', NULL, 2093, 1, NULL, NULL, NULL, NULL),
(313, 0, 'Isack Twesigye', 'M', NULL, 1138, 1, NULL, NULL, NULL, NULL),
(314, 0, 'Ivan Ekalu', 'M', NULL, 2090, 1, NULL, NULL, NULL, NULL),
(315, 0, 'Ivan Niwagaba', 'M', NULL, 1018, 1, NULL, NULL, NULL, NULL),
(316, 0, 'Jacob Mbonigaba', 'M', NULL, 1086, 1, NULL, NULL, NULL, NULL),
(317, 0, 'Jen Beatrice Apiso', 'F', NULL, 2023, 1, NULL, NULL, NULL, NULL),
(318, 0, 'Jenifer Alupo', 'F', NULL, 2078, 1, NULL, NULL, NULL, NULL),
(319, 0, 'Jenifer Lona Apio', 'F', NULL, 2084, 1, NULL, NULL, NULL, NULL),
(320, 0, 'Jennifer Loy Apolo', 'F', NULL, 2045, 1, NULL, NULL, NULL, NULL),
(321, 0, 'Jessica Apolot', 'F', NULL, 2062, 1, NULL, NULL, NULL, NULL),
(322, 0, 'Jessica Ariokot', 'F', NULL, 2072, 1, NULL, NULL, NULL, NULL),
(323, 0, 'Jet Kato', 'M', NULL, 1035, 1, NULL, NULL, NULL, NULL),
(324, 0, 'Joakim Twinamatsiko', 'M', NULL, 1123, 1, NULL, NULL, NULL, NULL),
(325, 0, 'Joan Atuheire', 'F', NULL, 1136, 1, NULL, NULL, NULL, NULL),
(326, 0, 'Joanita Tushabe', 'F', NULL, 1142, 1, NULL, NULL, NULL, NULL),
(327, 0, 'Job Ekolu', 'M', NULL, 2007, 1, NULL, NULL, NULL, NULL),
(328, 0, 'John Andrew Eilu', 'M', NULL, 2046, 1, NULL, NULL, NULL, NULL),
(329, 0, 'John Kokas Edoan', 'M', NULL, 2054, 1, NULL, NULL, NULL, NULL),
(330, 0, 'John Michael Ariong', 'M', NULL, 2076, 1, NULL, NULL, NULL, NULL),
(331, 0, 'John Stephen Egoliam', 'M', NULL, 2053, 1, NULL, NULL, NULL, NULL),
(332, 0, 'Jonan Twinomugisha', 'M', NULL, 1036, 1, NULL, NULL, NULL, NULL),
(333, 0, 'Jonathan Omiat', 'M', NULL, 2018, 1, NULL, NULL, NULL, NULL),
(334, 0, 'Joseph Ainembabazi', 'M', NULL, 1053, 1, NULL, NULL, NULL, NULL),
(335, 0, 'Joshua Natukunda', 'M', NULL, 1059, 1, NULL, NULL, NULL, NULL),
(336, 0, 'Joshua Okelo', 'M', NULL, 2073, 1, NULL, NULL, NULL, NULL),
(337, 0, 'Joy Aluo', 'F', NULL, 2008, 1, NULL, NULL, NULL, NULL),
(338, 0, 'Judith Ajalo', 'F', NULL, 2025, 1, NULL, NULL, NULL, NULL),
(339, 0, 'Judith Asingwire', 'F', NULL, 1082, 1, NULL, NULL, NULL, NULL),
(340, 0, 'Judith Barbra Akelo', 'F', NULL, 2082, 1, NULL, NULL, NULL, NULL),
(341, 0, 'Judith Komugisha', 'F', NULL, 1019, 1, NULL, NULL, NULL, NULL),
(342, 0, 'Judith Ndyamuhaki', 'F', NULL, 1110, 1, NULL, NULL, NULL, NULL),
(343, 0, 'Julien Atulinda', 'F', NULL, 1124, 1, NULL, NULL, NULL, NULL),
(344, 0, 'Justice Niwamanya', 'M', NULL, 1132, 1, NULL, NULL, NULL, NULL),
(345, 0, 'Katherine Tumukunde', 'F', NULL, 1128, 1, NULL, NULL, NULL, NULL),
(346, 0, 'Ketula Abio', 'F', NULL, 2068, 1, NULL, NULL, NULL, NULL),
(347, 0, 'Laban Kyomukama', 'M', NULL, 1112, 1, NULL, NULL, NULL, NULL),
(348, 0, 'Lawrence Otuba', 'M', NULL, 2099, 1, NULL, NULL, NULL, NULL),
(349, 0, 'Livingstone Ngabirano', 'M', NULL, 1021, 1, NULL, NULL, NULL, NULL),
(350, 0, 'Lovis Muhwezi', 'M', NULL, 1139, 1, NULL, NULL, NULL, NULL),
(351, 0, 'Loyce Kyokusiima', 'F', NULL, 1152, 1, NULL, NULL, NULL, NULL),
(352, 0, 'Lucky Ainembabazi', 'F', NULL, 1095, 1, NULL, NULL, NULL, NULL),
(353, 0, 'Magidu Abdumariki', 'M', NULL, 1079, 1, NULL, NULL, NULL, NULL),
(354, 0, 'Martin Emorut', 'M', NULL, 2044, 1, NULL, NULL, NULL, NULL),
(355, 0, 'Martin Oriokot', 'M', NULL, 2052, 1, NULL, NULL, NULL, NULL),
(356, 0, 'Mary Ilego', 'F', NULL, 2101, 1, NULL, NULL, NULL, NULL),
(357, 0, 'Mary Loyce Apolot', 'F', NULL, 2024, 1, NULL, NULL, NULL, NULL),
(358, 0, 'Mary Twongyerwe', 'F', NULL, 1081, 1, NULL, NULL, NULL, NULL),
(359, 0, 'Matia Atwijukire', 'M', NULL, 1119, 1, NULL, NULL, NULL, NULL),
(360, 0, 'Matilda Adielo', 'F', NULL, 2002, 1, NULL, NULL, NULL, NULL),
(361, 0, 'Medard Arineitwe', 'M', NULL, 1089, 1, NULL, NULL, NULL, NULL),
(362, 0, 'Medard Ashaba', 'M', NULL, 1022, 1, NULL, NULL, NULL, NULL),
(363, 0, 'Merable Kamusiime', 'F', NULL, 1062, 1, NULL, NULL, NULL, NULL),
(364, 0, 'Michael Ebiju', 'M', NULL, 2056, 1, NULL, NULL, NULL, NULL),
(365, 0, 'Michael Olaboro', 'M', NULL, 2048, 1, NULL, NULL, NULL, NULL),
(366, 0, 'Moreen Akampurira', 'F', NULL, 1130, 1, NULL, NULL, NULL, NULL),
(367, 0, 'Moreen Kyasiimire', 'F', NULL, 1051, 1, NULL, NULL, NULL, NULL),
(368, 0, 'Nabon Natukunda', 'F', NULL, 1024, 1, NULL, NULL, NULL, NULL),
(369, 0, 'Naomi Kembabazi', 'F', NULL, 1025, 1, NULL, NULL, NULL, NULL),
(370, 0, 'Nelson Ewatu Elimo', 'M', NULL, 2019, 1, NULL, NULL, NULL, NULL),
(371, 0, 'Nicholas Natulinda', 'M', NULL, 1072, 1, NULL, NULL, NULL, NULL),
(372, 0, 'Nickson Naweta', 'M', NULL, 1108, 1, NULL, NULL, NULL, NULL),
(373, 0, 'Nowel Egasu', 'M', NULL, 2033, 1, NULL, NULL, NULL, NULL),
(374, 0, 'Onesmas Agaba', 'M', NULL, 1026, 1, NULL, NULL, NULL, NULL),
(375, 0, 'Onesmas Tumwesigye', 'M', NULL, 1027, 1, NULL, NULL, NULL, NULL),
(376, 0, 'Owen Ariho', 'M', NULL, 1073, 1, NULL, NULL, NULL, NULL),
(377, 0, 'Paul Adongo', 'M', NULL, 2098, 1, NULL, NULL, NULL, NULL),
(378, 0, 'Perepetua Agwang', 'F', NULL, 2012, 1, NULL, NULL, NULL, NULL),
(379, 0, 'Peter Arineitwe', 'M', NULL, 1147, 1, NULL, NULL, NULL, NULL),
(380, 0, 'Peter David Omunyal', 'M', NULL, 2042, 1, NULL, NULL, NULL, NULL),
(381, 0, 'Peter Ekadu', 'M', NULL, 2050, 1, NULL, NULL, NULL, NULL),
(382, 0, 'Peter Martin Oriokot', 'M', NULL, 2079, 1, NULL, NULL, NULL, NULL),
(383, 0, 'Peter Okuda', 'M', NULL, 2031, 1, NULL, NULL, NULL, NULL),
(384, 0, 'Phiona Ampeire', 'F', NULL, 1028, 1, NULL, NULL, NULL, NULL),
(385, 0, 'Pias Olinga', 'M', NULL, 2075, 1, NULL, NULL, NULL, NULL),
(386, 0, 'Precious Ariho', 'M', NULL, 1076, 1, NULL, NULL, NULL, NULL),
(387, 0, 'Precious Nkashaba', 'F', NULL, 1029, 1, NULL, NULL, NULL, NULL),
(388, 0, 'Precious Turinawe', 'F', NULL, 1113, 1, NULL, NULL, NULL, NULL),
(389, 0, 'Prize Akankwasa', 'F', NULL, 1030, 1, NULL, NULL, NULL, NULL),
(390, 0, 'Prose Ampumuza', 'F', NULL, 1134, 1, NULL, NULL, NULL, NULL),
(391, 0, 'Rachel Arineitwe', 'F', NULL, 1075, 1, NULL, NULL, NULL, NULL),
(392, 0, 'Rafael Stephen Akotu', 'M', NULL, 2077, 1, NULL, NULL, NULL, NULL),
(393, 0, 'Rebecca Niwandinda', 'F', NULL, 1031, 1, NULL, NULL, NULL, NULL),
(394, 0, 'Rebecca Tushabe', 'F', NULL, 1150, 1, NULL, NULL, NULL, NULL),
(395, 0, 'Rhoda Apeduno', 'F', NULL, 2027, 1, NULL, NULL, NULL, NULL),
(396, 0, 'Richard Ecoku', 'M', NULL, 2040, 1, NULL, NULL, NULL, NULL),
(397, 0, 'Richard Emeru', 'M', NULL, 2020, 1, NULL, NULL, NULL, NULL),
(398, 0, 'Richard Enyonu', 'M', NULL, 2032, 1, NULL, NULL, NULL, NULL),
(399, 0, 'Roland Akampurira', 'M', NULL, 1129, 1, NULL, NULL, NULL, NULL),
(400, 0, 'Rose Iliamu', 'F', NULL, 2038, 1, NULL, NULL, NULL, NULL),
(401, 0, 'Rosette Ndyamuhakyi', 'F', NULL, 1140, 1, NULL, NULL, NULL, NULL),
(402, 0, 'Sam Osege', 'M', NULL, 2026, 1, NULL, NULL, NULL, NULL),
(403, 0, 'Samson Oile', 'M', NULL, 2057, 1, NULL, NULL, NULL, NULL),
(404, 0, 'Samuel Egadu', 'M', NULL, 2060, 1, NULL, NULL, NULL, NULL),
(405, 0, 'Sarah Amokol', 'F', NULL, 2041, 1, NULL, NULL, NULL, NULL),
(406, 0, 'Saulo Engebi', 'M', NULL, 2005, 1, NULL, NULL, NULL, NULL),
(407, 0, 'Scovia Katoko', 'F', NULL, 2016, 1, NULL, NULL, NULL, NULL),
(408, 0, 'Sedrick Kuka', 'M', NULL, 1096, 1, NULL, NULL, NULL, NULL),
(409, 0, 'Sharon Orishaba', 'F', NULL, 1032, 1, NULL, NULL, NULL, NULL),
(410, 0, 'Simeo Nahabwe', 'M', NULL, 1104, 1, NULL, NULL, NULL, NULL),
(411, 0, 'Simon Amutuheire', 'M', NULL, 1137, 1, NULL, NULL, NULL, NULL),
(412, 0, 'Simon Ogudo', 'M', NULL, 2066, 1, NULL, NULL, NULL, NULL),
(413, 0, 'Simon Peter Otim', 'M', NULL, 2015, 1, NULL, NULL, NULL, NULL),
(414, 0, 'Sonia Muriisa', 'F', NULL, 1125, 1, NULL, NULL, NULL, NULL),
(415, 0, 'Sospateri Okirima', 'M', NULL, 2029, 1, NULL, NULL, NULL, NULL),
(416, 0, 'Steven Epianu', 'M', NULL, 2001, 1, NULL, NULL, NULL, NULL),
(417, 0, 'Susan Akampurira', 'F', NULL, 1080, 1, NULL, NULL, NULL, NULL),
(418, 0, 'Susan Asimwe', 'F', NULL, 1107, 1, NULL, NULL, NULL, NULL),
(419, 0, 'Sylvia Akampurira', 'F', NULL, 1148, 1, NULL, NULL, NULL, NULL),
(420, 0, 'Tabisa Abeja', 'F', NULL, 2010, 1, NULL, NULL, NULL, NULL),
(421, 0, 'Tabisa Adojo', 'F', NULL, 2080, 1, NULL, NULL, NULL, NULL),
(422, 0, 'Tabisa Apolot', 'F', NULL, 2069, 1, NULL, NULL, NULL, NULL),
(423, 0, 'Tabisa Ilaborot', 'F', NULL, 2092, 1, NULL, NULL, NULL, NULL),
(424, 0, 'Timothy Okiror', 'M', NULL, 2043, 1, NULL, NULL, NULL, NULL),
(425, 0, 'Tom Nasasira', 'M', NULL, 1117, 1, NULL, NULL, NULL, NULL),
(426, 0, 'Uzobias Musiimenta', 'F', NULL, 1083, 1, NULL, NULL, NULL, NULL),
(427, 0, 'Victor Ankunda', 'M', NULL, 1088, 1, NULL, NULL, NULL, NULL),
(428, 0, 'Washington Obiasi', 'M', NULL, 2064, 1, NULL, NULL, NULL, NULL),
(429, 0, 'Willex Muhumuza', 'M', NULL, 1084, 1, NULL, NULL, NULL, NULL),
(430, 0, 'William Edeu', 'M', NULL, 2087, 1, NULL, NULL, NULL, NULL),
(431, 0, 'William Emolu', 'M', NULL, 2058, 1, NULL, NULL, NULL, NULL),
(432, 0, 'Winnie Ajwang', 'F', NULL, 1143, 1, NULL, NULL, NULL, NULL),
(433, 0, 'Yokosopati Ecwatu', 'M', NULL, 2011, 1, NULL, NULL, NULL, NULL),
(434, 0, 'Yona Orute', 'M', NULL, 2037, 1, NULL, NULL, NULL, NULL),
(435, 0, 'Yoweri Ekou', 'M', NULL, 2051, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `ditelog`
--

CREATE TABLE IF NOT EXISTS `ditelog` (
  `idDiteLog` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diteIdDite` int(10) unsigned NOT NULL,
  `datumOperace` date NOT NULL,
  `typOperace` int(10) unsigned DEFAULT NULL,
  `menenePole` varchar(255) DEFAULT NULL,
  `staraHodnota` varchar(255) DEFAULT NULL,
  `novaHodnota` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idDiteLog`),
  KEY `diteLog_FKIndex1` (`diteIdDite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `ditelog`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `platba`
--

CREATE TABLE IF NOT EXISTS `platba` (
  `idPlatba` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `benefitIdBenefit` int(10) unsigned NOT NULL,
  `sponzorIdSponzor` int(10) unsigned NOT NULL,
  `diteIdDite` int(10) unsigned NOT NULL,
  `datum` date DEFAULT NULL,
  `castka` int(10) unsigned DEFAULT NULL,
  `mena` varchar(255) DEFAULT NULL,
  `ucet` varchar(255) DEFAULT NULL,
  `poznamka` varchar(255) DEFAULT NULL,
  `rok` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idPlatba`),
  KEY `platba_FKIndex1` (`diteIdDite`),
  KEY `platba_FKIndex2` (`sponzorIdSponzor`),
  KEY `platba_FKIndex3` (`benefitIdBenefit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `platba`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `poznamka`
--

CREATE TABLE IF NOT EXISTS `poznamka` (
  `idpoznamka` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sponzorIdSponzor` int(10) unsigned NOT NULL,
  `diteIdDite` int(10) unsigned NOT NULL,
  `datum` date DEFAULT NULL,
  `nadpis` varchar(255) DEFAULT NULL,
  `hodnota` varchar(255) DEFAULT NULL,
  `vystavit` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idpoznamka`),
  KEY `poznamka_FKIndex2` (`diteIdDite`),
  KEY `poznamka_FKIndex1` (`sponzorIdSponzor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `poznamka`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `relaceditebenefit`
--

CREATE TABLE IF NOT EXISTS `relaceditebenefit` (
  `idRelaceDiteBenefit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `benefitIdBenefit` int(10) unsigned NOT NULL,
  `diteIdDite` int(10) unsigned NOT NULL,
  `datumVzniku` datetime DEFAULT NULL,
  `datumZaniku` datetime DEFAULT NULL,
  `zaplacenaCastka` int(10) unsigned DEFAULT NULL,
  `poznamka` varchar(255) DEFAULT NULL,
  `rok` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idRelaceDiteBenefit`),
  KEY `relaceDiteBenefit_FKIndex2` (`diteIdDite`),
  KEY `relaceDiteBenefit_FKIndex1` (`benefitIdBenefit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `relaceditebenefit`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `relaceditesponzor`
--

CREATE TABLE IF NOT EXISTS `relaceditesponzor` (
  `idRelaceDiteSponzor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sponzorIdSponzor` int(10) unsigned NOT NULL,
  `diteIdDite` int(10) unsigned NOT NULL,
  `aktivniZaznam` tinyint(1) DEFAULT NULL,
  `datumVzniku` date DEFAULT NULL,
  `datumZaniku` date DEFAULT NULL,
  PRIMARY KEY (`idRelaceDiteSponzor`),
  KEY `relaceDiteSponzor_FKIndex2` (`diteIdDite`),
  KEY `relaceDiteSponzor_FKIndex1` (`sponzorIdSponzor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `relaceditesponzor`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `skola`
--

CREATE TABLE IF NOT EXISTS `skola` (
  `idSkola` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) DEFAULT NULL,
  `castka` int(10) unsigned DEFAULT NULL,
  `maxRok` int(10) unsigned DEFAULT NULL,
  `predpona` char(1) DEFAULT NULL,
  PRIMARY KEY (`idSkola`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `skola`
--

INSERT INTO `skola` (`idSkola`, `nazev`, `castka`, `maxRok`, `predpona`) VALUES
(0, 'Škola není zadaná', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `sourozenzi`
--

CREATE TABLE IF NOT EXISTS `sourozenzi` (
  `idSourozenzi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diteIdDite2` int(10) unsigned NOT NULL,
  `diteIdDite1` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idSourozenzi`),
  KEY `sourozenzi_FKIndex1` (`diteIdDite1`),
  KEY `sourozenzi_FKIndex2` (`diteIdDite2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `sourozenzi`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `sponzor`
--

CREATE TABLE IF NOT EXISTS `sponzor` (
  `idSponzor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(255) NOT NULL,
  `ulice` varchar(255) DEFAULT NULL,
  `psc` varchar(255) DEFAULT NULL,
  `ssym` int(10) unsigned DEFAULT NULL,
  `mesto` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `telefon` varchar(255) DEFAULT NULL,
  `aktivniZaznam` tinyint(1) DEFAULT NULL,
  `datumVzniku` date DEFAULT NULL,
  `datumZaniku` date DEFAULT NULL,
  PRIMARY KEY (`idSponzor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=381 ;

--
-- Vypisuji data pro tabulku `sponzor`
--

INSERT INTO `sponzor` (`idSponzor`, `jmeno`, `ulice`, `psc`, `ssym`, `mesto`, `mail`, `telefon`, `aktivniZaznam`, `datumVzniku`, `datumZaniku`) VALUES
(210, 'Hašková Alena', 'Úlehle 21', '612 00', 5001, 'Brno', 'ahaskova@konfirm.cz', '(+420) 602 537 02', NULL, NULL, NULL),
(211, 'Hlavacova Helena', 'Roklanská 1263', '251 01', 5002, '?í?any', 'hlavacova@ms-stavebni.cz', '(+420) 723 333 939', NULL, NULL, NULL),
(212, '?ížek Jaroslav', 'Petrohradská 29', '100 00', 5003, 'Praha 10', 'jaroslav@siskin.cz', NULL, NULL, NULL, NULL),
(213, 'Danková Helenka', 'Krkonošská 2', '120 00', 5004, 'Praha 2', 'heda@ikem.cz', '(+420) 608 508 344 ', NULL, NULL, NULL),
(214, 'Kellerová Jaroslava', 'Karlovarská 42', '300 00', 5005, 'Plze?', 'JaroslavaKellerova@seznam.cz', NULL, NULL, NULL, NULL),
(215, 'Novotný Dušan', 'Budovatelu 21', '466 01', 5006, 'Jablonec n/Nisou', 'dusnovo@atlas.cz', '(+420) 776 219 542 ', NULL, NULL, NULL),
(216, 'K?ížková V?ra', 'Rabštejnská 20', '323 32', 5007, 'Plze?', 'Vera.Krizkova@lfp.cuni.cz', '(+420) 731 470 104 ', NULL, NULL, NULL),
(217, 'Abrhámová Šárka', 'Sitteho 741/6', '140 00', 5008, 'Praha 4', 'abrhamova.sarka@gmail.com', '(+420) 776 386 117 ', NULL, NULL, NULL),
(218, 'Hakrová Kate?ina', 'Jaromira Vejvody 1397', '156 00', 5009, 'Praha 5', 'khakrova@seznam.cz', NULL, NULL, NULL, NULL),
(219, 'Kolá? Pavel a Blanka', 'Hrani?ní 6', '736 01', 5010, 'Haví?ov - Životice', 'kolarpav@atlas.cz', NULL, NULL, NULL, NULL),
(220, 'Bártovi Bed?ich a Yvona', 'Chomutovice 40', '25101', 5011, '?í?any u Prahy', 'bedrich.barta@centrum.cz', '(+420) 602 426 798 - Bed?ich; (+420) 607 513 085 - Yvona', NULL, NULL, NULL),
(221, 'Šindlerová Dagmar', 'Steinerova 606', '149 00', 5013, 'Praha 11', 'stanislav.sindler@zpmvcr.cz', '(+420) 603 787 690 ', NULL, NULL, NULL),
(222, 'Málkovi Jarmila a Karel', 'Šmejkalova 96', '616 00', 5014, 'Brno', 'jarmilamalkova@email.cz', '(+420) 549 259 814; (+420) 732 718 831', NULL, NULL, NULL),
(223, 'Blažková Hana', 'Manetínská 71', '323 00', 5016, 'Plze?', 'blazkova.hanina@seznam.cz', '(+420) 377 535 291 ', NULL, NULL, NULL),
(224, 'Kokošková Lída', 'Studijní a v?decká knihovna Smetanovy sady ?. 2', '305 48', 5017, 'Plze?', 'KokoskovaL@seznam.cz', NULL, NULL, NULL, NULL),
(225, 'Strý?ková Rybia?ová Jana', 'Dolní Domaslavice 402', '739 38', 5019, 'Dolní Domaslavice', 'J.Rybiarova@seznam.cz', NULL, NULL, NULL, NULL),
(226, 'Seifertová Daniela', 'Komorní Dv?r ?. 37', '350 01', 5020, 'Cheb', 'dsei@seznam.cz', '(+607) 559 054 ---', NULL, NULL, NULL),
(227, 'Šindlerová Michaela', 'Steinerova 606', '149 00', 5023, 'Praha 11', 'misule64@email.cz', '(+420) 605 553 095 ', NULL, NULL, NULL),
(228, 'Vítkovi Pavla a Ond?ej', 'Dobronická 986/35', '142 00', 5024, 'Praha 4 - Libuš', 'pvitkova@kpmg.cz', NULL, NULL, NULL, NULL),
(229, 'Suchá Martina', 'Názovská 16', '100 00', 5026, 'Praha 10', 'martina.sucha@centrum.cz', NULL, NULL, NULL, NULL),
(230, 'Bruhová So?a', 'Petrovice ?. 12, obec M??ín', '340 12', 5028, 'Švihov', 'BruhovaS@seznam.cz', NULL, NULL, NULL, NULL),
(231, 'Nový Vladimír', 'V Lužánkách 6', '301 00', 5029, 'Plze?', 'novyvl@atlas.cz', NULL, NULL, NULL, NULL),
(232, 'Štréblová V?ra', 'U.C.F.I. Koubkova 13', '120 00', 5032, 'Praha 2', 'ucfi@iqnet.cz', NULL, NULL, NULL, NULL),
(233, 'Šafránková Tereza', 'Petržílkova 35/1436', '153 00', 5033, 'Praha 13', 'tterry@email.cz', '(+420) 777 851 858', NULL, NULL, NULL),
(234, 'Dostálová Libuše', 'Újezd 131', '783 96', 5034, 'Újezd u Uni?ova', 'Libuse.Dostalova@ol.mpsv.cz', '(+420) 728 103 442', NULL, NULL, NULL),
(235, 'Pali?ka Michal', '?ímská 41', '779 00', 5035, 'Olomouc', 'mpalicka@hotmail.com', NULL, NULL, NULL, NULL),
(236, 'Vavro Milan', '?ímskokatolická farnost', '684 01', 5036, 'Slavkov u Brna', '?ímskokatolická farnost Slavkov u Brna [rkf.slavkov@biskupstvi.cz]', NULL, NULL, NULL, NULL),
(237, 'Musilová Lída', 'Budínská 30', '627 00', 5037, 'Brno', 'musilova.lida@seznam.cz', '(+420) 548 211 053, (+420) 731 616 439', NULL, NULL, NULL),
(238, 'Špád Martin', 'Borkovského 1761', '252 63', 5038, 'Roztoky', 'MartinSpad@seznam.cz', '(+420) 605 708 136', NULL, NULL, NULL),
(239, 'Mácová Miroslava', 'Sládkova 438/II', '377 01', 5039, 'Jind?ich?v Hradec', 'miroslava.macova@macovi.cz', '(+420) 608 923 232', NULL, NULL, NULL),
(240, 'Hubálková Petra', 'Lomená 330/31', '162 00', 5041, 'Praha 6', 'petra.hubalkova@seznam.cz', '(+420) 737 210 716', NULL, NULL, NULL),
(241, 'Charita Slavkov', 'Bucovicka 156', '684 01', 5042, 'Slavkov u Brna', 'hanastarkova@seznam.cz', '723708125', NULL, NULL, NULL),
(242, 'Bu?ek Ji?í', 'Glocova 12', '620 00', 5043, 'Brno', 'bohunka_jirka@volny.cz, bucek@fem.cz', '(+420) 545 220 633', NULL, NULL, NULL),
(243, 'Funková Martina', 'Rosovice 284', '26211', 5045, 'Rosovice', 'martina.funkova@email.cz', '(+420) 777 192 512', NULL, NULL, NULL),
(244, 'P?íhoda Jaroslav, ing.', 'D?dická 19', '627 00', 5050, 'Brno - Slatina', 'jarpri@volny.cz', '(+420) 604 213 438', NULL, NULL, NULL),
(245, 'Žá?ek Lubomír', 'Pon?tovská ?. 245', '664 58', 5051, 'Prace', 'Lubomir.Zacek@rwe.cz, radypecha@seznam.cz', '(+420) 776 183 270; (+420) 606 733 762', NULL, NULL, NULL),
(246, 'Baková Janka', 'Jižní 342', '471 27', 5052, 'Stráž pod Ralskem', NULL, '(+420) 722 928 434', NULL, NULL, NULL),
(247, 'Hanušová Jana', 'Kpt. Jaroše  39c', '602 00', 5053, 'Brno', 'jana-hanusova@seznam.cz', '(+420) 774 330 401', NULL, NULL, NULL),
(248, 'Wintrová Vladimíra', 'Pohrani?ní stráže ?.116', '345 22', 5054, 'Pob?žovice', 'vladimira.wintrova@cz.lasselsberger.com', '(+420) 724 246 249', NULL, NULL, NULL),
(249, 'Bureš Petr', 'V Lomech 10', '301 00', 5055, 'Plze?', 'ingburespetr@volny.cz', '(+420) 377 528 180', NULL, NULL, NULL),
(250, 'Hrubá Vla?ka', 'Jos. Faimonové 28', '628 00', 5056, 'Brno', 'vladossss@seznam.cz', '(+420) 736 536 506', NULL, NULL, NULL),
(251, 'Šedová Edita a Opava Marek', 'Nazovská 16', '100 00', 5057, 'Praha 10', 'sedovae@mpo.cz, marek.opava@mymail.cz', '(+420) 602 934 227', NULL, NULL, NULL),
(252, 'Chvalová Monika', 'Horní 3', '140 00', 5058, 'Praha 4', 'monika.chvalova@seznam.cz', '(+420) 602 286 513', NULL, NULL, NULL),
(253, 'Patera Tomáš', 'Horní 3', '140 00', 5059, 'Praha 4', 'tomas.patera@seznam.cz', '(+420) 720 705 340', NULL, NULL, NULL),
(254, 'Bížová Renáta', 'Jeseniova 37', '130 00', 5060, 'Praha 3', 'renata_bizova@kb.cz', '(+420) 723 508 006', NULL, NULL, NULL),
(255, 'Pochylá Zuzana', 'Drobného 50', '602 00', 5061, 'Brno', 'zulik13@seznam.cz', '(+420) 603 901 973    ', NULL, NULL, NULL),
(256, 'Sehnalová Lenka', 'Nová 580', '798 03', 5062, 'Plumlov', 'SehnalovaLenka@seznam.cz', '(+420) 732 635 36 ', NULL, NULL, NULL),
(257, 'Lišaníková Šárka', 'Náb?eží 559', '739 44', 5067, 'Brušperk', 'lisanikova@seznam.cz', '(+420) 777 278 472', NULL, NULL, NULL),
(258, 'Rybnikárová Lucie', 'Nový Malín 614', '788 03', 5069, 'Nový Malín', 'lu.alfama@seznam.cz', '(+420) 737 326 629', NULL, NULL, NULL),
(259, 'Vinklerová Magdalena', 'Legioná?ská 1', '779 00', 5070, 'Olomouc', 'mvinklerova@vsoud.olc.justice.cz', '(+420) 606 461 854', NULL, NULL, NULL),
(260, 'Gemmelová Sv?tlana', 'Adamusova 1254', '735 14', 5071, 'Orlová-Lutyn?', 'svetlana.gemmelova@prosperita.com', '(+420) 737 207 506', NULL, NULL, NULL),
(261, 'Boffio Umberto, Ji?ina', 'odesilat na Bizova Renata', NULL, 5073, NULL, 'umbertoboffi@seznam.cz', '(+420) 222 328 278', NULL, NULL, NULL),
(262, 'Hrdová Marie', 'Jiráskova 405', '684 01', 5076, 'Slavkov u Brna', 'hrdova405@seznam.cz', '544221715', NULL, NULL, NULL),
(263, 'Proksová Martina', 'Pod?bradova 32', '612 00', 5080, 'Brno', 'martina.proksova@centrum.cz', '(+420) 602 932 624', NULL, NULL, NULL),
(264, 'Vozka Martin', 'Žižkova 63', '664 01', 5081, 'Bílovice n.S.', 'martin.vozka@seznam.cz', '(+420) 603 813 831', NULL, NULL, NULL),
(265, 'Rosecká Lucie', 'Družstevní 15', '289 24', 5082, 'Milovice', 'lucie.chroustova@email.cz', '(+420) 737 481 882', NULL, NULL, NULL),
(266, 'Edr Daniel', 'Sportovní 358', '394 03', 5083, 'Horní Cerekev', 'danieledr@seznam.cz', '353-863 533 704', NULL, NULL, NULL),
(267, 'Kavková Kate?ina', 'Francouzská 50', '101 00', 5084, 'Praha 10', 'katerina.kavkova@catalpa.cz', '(+420) 777 557 988', NULL, NULL, NULL),
(268, 'Vá?a Karel', 'Dolni Mesto 150', '582 33', 5085, 'Dolni Mesto', 'dolnimesto150@centrum.cz', NULL, NULL, NULL, NULL),
(269, 'Molková Jana', 'P?edm??ice nad Jizerou 206', '294 74', 5086, 'P?edm??ice nad Jizerou', 'Halisek@centrum.cz', '(+420) 777 837 136', NULL, NULL, NULL),
(270, 'Se?ovi Ivo a Iva', 'Podstránská 39', '627 00', 5087, 'Brno - Slatina', 'iseda@seznam.cz, Iva.Sedova@cssz.cz', '(+420) 603 106 157', NULL, NULL, NULL),
(271, '?eský rozhlas Region', 'Masarykovo nám?stí 42', '586 01', 5091, 'Jihlava', 'tamara.peckova@rozhlas.cz;ondrej.novacek@rozhlas.cz', '(+420) 724 019 180, (+420) 724 019 181', NULL, NULL, NULL),
(272, 'Weidnerová Kate?ina', 'Vrchlického 899', '753 01', 5094, 'Hranice', 'dopra.vka@seznam.cz', '(+420) 606 549 143', NULL, NULL, NULL),
(273, 'Náplavová Eva', 'Brigádnická 60', '621 00', 5095, 'Brno', 'EvaNapl@seznam.cz', '(+420) 603 106 158', NULL, NULL, NULL),
(274, 'Valní?ková Dana', 'Velké Lipky 243', '664 07', 5097, 'Pozo?ice', 'dana.valnickova@seznam.cz', '(+420) 606 789 277', NULL, NULL, NULL),
(275, 'Treglerová Lucie', 'Lu?anská 6a/4640', '466 02', 5098, 'Jablonec nad Nisou', 'ltreglerova@osoud.jbc.justice.cz', '(+420) 733 327 111', NULL, NULL, NULL),
(276, 'Pascale Fenaux', '1 bis bd Palaiseau', '911 20', 5102, 'Palaiseau', NULL, NULL, NULL, NULL, NULL),
(277, 'Hoškovi Jan a Marcela', 'Šmilovského 4', '627 00', 5103, 'Brno - Slatina', 'hosek.7@seznam.cz, marcela.hoskova@seznam.cz', '(+420) 604 848 695', NULL, NULL, NULL),
(278, 'Havlík Josef', 'Bezru?ova 1402', '769 01', 5104, 'Holešov', 'joshavlik@centrum.cz', '(+420) 603 147 061', NULL, NULL, NULL),
(279, 'Švédová Marcela', 'Smetanova 8', '750 02', 5105, 'P?erov', 'svedovamarcela@seznam.cz, svedova@caterius.cz', '(+420) 602 796 794', NULL, NULL, NULL),
(280, 'Dá?ová Petra', 'Chelcickeho 38', '678 01', 5106, 'Blansko', 'yssei@centrum.cz', '(+420) 737 101 104', NULL, NULL, NULL),
(281, 'Kr?alová Michaela', 'Sobotovice 145', '664 67', 5108, 'Syrovice', 'krcalova.michaela@seznam.cz', '(+420) 606 811 641; (+420) 543 160 250', NULL, NULL, NULL),
(282, 'Parkošová Marie', 'Lidická 564', '386 01', 5109, 'Strakonice', 'MarieParkosova@seznam.cz', '(+420) 777 190 719', NULL, NULL, NULL),
(283, 'Mu?inovi Josef a Hana', 'Arbesova 1581/7', '415 01', 5110, 'Teplice', 'josef.mucina@seznam.cz', '(+420) 608 981 397; (+420) 777 160 251', NULL, NULL, NULL),
(284, 'T?mová Hana, mgr.', 'Irská 796/5', '160 00', 5111, 'Praha 6 - Vokovice', 'martina.funkova@email.cz', NULL, NULL, NULL, NULL),
(285, 'Provazník Zden?k', 'Pod Pet?inami 454/21', '162 00', 5112, 'Praha 6', 'zdenek.provaznik@seznam.cz', '(+420) 603 554 465', NULL, NULL, NULL),
(286, 'Lédlová Vlastimila', 'Malátova 7', '400 11', 5113, 'Ústí nad Labem', 'jozkaa@seznam.cz', '(+420) 721 725 251', NULL, NULL, NULL),
(287, 'Housková Zuzana', 'Dvo?eckého 11', '169 00', 5114, 'Praha 6', 'barbusinka@seznam.cz', '(+420) 775 270 383', NULL, NULL, NULL),
(288, '?ímskokatolická farnost Unín u Tišnova, Jansa Ervín', 'nám.Palackého 73', '679 23', 5115, 'Lomnice', 'ejansa@tiscali.cz', '737452421', NULL, NULL, NULL),
(289, 'Smutná Lydie', 'Jiráskova 906', '295 01', 5116, 'Mnichovo Hradišt?', 'Lydie.smutna@seznam.cz', '(+420) 731 448 580', NULL, NULL, NULL),
(290, 'Mat?jí?ková Lenka', 'Na konci sv?ta 527', '250 64', 5117, 'Hovor?ovice', 'lenka.matejickova@tiscali.cz', '(+420) 606 357 676', NULL, NULL, NULL),
(291, 'Frá?ová Libuše', 'Kmochova 21', '779 00', 5119, 'Olomouc', 'franova@franaolomouc.cz', '(+420) 777 975 845', NULL, NULL, NULL),
(292, 'Hlavi?ka Miroslav', 'Pístecká 1423/4', '288 02', 5120, 'Nymburk', 'scalex@scalex.cz', NULL, NULL, NULL, NULL),
(293, 'Blažejová Tá?a', 'Kostická 118', '691 53', 5121, 'Tvrdonice', 'tanablazejova@seznam.cz', '(+420) 731 606 001', NULL, NULL, NULL),
(294, 'Svobodová Martina', 'J. Palacha 28', '690 02', 5122, 'B?eclav', 'm.w.svobodova@post.cz', '(+420) 608 617 257', NULL, NULL, NULL),
(295, 'Newag spol. s r.o.', 'Vestecká 104', '252 41', 5123, 'Hodkovice, Zlatníky', 'petra.jarolimova@husky.cz', '(+420) 777 091 777', NULL, NULL, NULL),
(296, 'Janíková Hana', 'Košíká?ská 2587', '756 61', 5124, 'Rožnov pod Radhošt?m', 'janikova.hana@seznam.cz', '(+420) 739 453 789', NULL, NULL, NULL),
(297, 'Št?pánek Pavel', 'Na Výsluní 74', '417 12', 5125, 'Proboštov u Teplic', 'pavel_stepanek@volny.cz', '(+420) 602 452 015', NULL, NULL, NULL),
(298, 'Št?pánková Jitka', 'Na Výsluní 74', '417 12', 5126, 'Proboštov u Teplic', 'pavel_stepanek@volny.cz', '(+420) 602 452 015', NULL, NULL, NULL),
(299, 'Fiantokova Katarina', 'U krizku 10', '140 00', 5127, 'Praha 4', 'kejt77@yahoo.com', '(+420) 608 127 776', NULL, NULL, NULL),
(300, 'Brychta Pavel', 'Alešova 22', '613 00', 5128, 'Brno', 'Pavel.Brychta@seznam.cz', '(+420) 602 217 224', NULL, NULL, NULL),
(301, 'Prášková Gabriela', 'Jana P?ibíka 953/15', '190 00', 5129, 'Praha 9', 'Gabriela.Praskova@glatzova.com', '(+420) 777 047 720', NULL, NULL, NULL),
(302, 'Karasová V?ra', 'Sýko?ice 216', '270 24', 5131, NULL, 'sykorka.vera@seznam.cz', '(+420) 606 690 118', NULL, NULL, NULL),
(303, 'Fišerová V?ra', 'Mládežnická 3059', '106 00', 5132, 'Praha 10', 'fiserova@step-praha.cz', '(+420) 602 202 613', NULL, NULL, NULL),
(304, 'Chroustová Kv?ta', 'B?ežany II 191', '282 01', 5134, '?eský Brod', 'kveta.brouckova@centrum.cz', '(+420) 605 933 234', NULL, NULL, NULL),
(305, 'Zelenková Martina', 'Oub?nice 55', '263 01', 5137, 'Dob?íš', 'martina.zelenkova@centrum.cz, jirina.divis@seznam.cz', '(+420) 724 834 309', NULL, NULL, NULL),
(306, 'Pátková Alexandra Anna', 'Ulrychova 81', '624 00', 5138, 'Brno', 'aa.patkova@centrum.cz; aa.patkova@gmail.com', '(+420) 733 579 577', NULL, NULL, NULL),
(307, 'Vystav?lová Zuzana', 'Teyschlova 5', '63500', 5139, 'Brno-Bystrc', 'susana.anna@gmail.com', '(+420) 732 276 259', NULL, NULL, NULL),
(308, 'Zembol Daniel', 'Gruzínská 7', '625 00', 5140, 'Brno', 'kefear@seznam.cz', '(+420) 777 682 246', NULL, NULL, NULL),
(309, 'Donátová Nora, MUDr.', 'Piletická 49', '500 03', 5141, 'Hradec Králové', 'n.donatova@centrum.cz', '(+420) 608 247 049', NULL, NULL, NULL),
(310, 'Hrubá Veronika', 'Vodárenská 2376', ' 272 01', 5143, 'Kladno', 'hruba.verca@seznam.cz', '(+420) 732 707 772', NULL, NULL, NULL),
(311, 'Farnost Lomnice u Tišnova', 'Nám. Palackého 73', '679 23', 5144, 'Lomnice', 'vechetice@centrum.cz', '(+420) 777 237 968', NULL, NULL, NULL),
(312, 'Soukup Eduard - Infosys BPO s.r.o.', 'Holandska 9', '639 00', 5145, 'Brno', 'Marta Kotonova [m.kotonova@yahoo.com]', '(+420) 777 202 685', NULL, NULL, NULL),
(313, 'Königová Eliška MUDr', 'Sv?tlov 22', '785 01', 5146, 'Šternberk', 'ella.k@email.cz', '(+420) 604 257 913', NULL, NULL, NULL),
(314, 'Sedláková Jana', 'Komenského 38', '785 01', 5147, 'Šternberk', 'sedlakova61@seznam.cz', '(+420) 736 678 292', NULL, NULL, NULL),
(315, 'Calo?ová Radmila', 'Vít?zná 1744', '756 61', 5149, 'Rožnov pod Radhošt?m', 'kytqa@email.cz', '(+420) 776 895 706', NULL, NULL, NULL),
(316, 'Oborský Lukáš a Pavla', 'U bozi muky 1201', '66501', 5150, 'Rosice', 'lukas@oborsky.cz', '(+420) 731 435 502', NULL, NULL, NULL),
(317, 'Trojáková Šárka', 'Jesenická 512', '788 33', 5152, 'Hanušovice', 'sarca66@seznam.cz', '(+420) 602 969 297', NULL, NULL, NULL),
(318, 'ZŠ Nám?stí Svobody', 'nám.Svobody 3', '785 01', 5153, 'Šternberk', 'skola@zsns-stbk.cz', '585013770', NULL, NULL, NULL),
(319, 'Fiala Jaroslav', 'J.Opletala 15', '370 05', 5154, '?eské Bud?jovice', 'jar-fiala@centrum.cz', '(+420) 607 590 546', NULL, NULL, NULL),
(320, 'V?r?ák Tadeáš, Magdalena Nemcova', 'Kubelikova 42', '130 00', 5156, 'Praha 3', 'tadun@me.com', '777 21 26 21', NULL, NULL, NULL),
(321, 'Mužík Ivo', 'Veselí 82', '74235', 5157, 'Odry', 'ivo.muzik@centrum.cz', '602514655', NULL, NULL, NULL),
(322, 'Ml?kovský Ji?í', 'Buková 18', '130 00', 5159, 'Praha 3', 'jirka.mlckovsky@c-box.cz', '720 141 552', NULL, NULL, NULL),
(323, 'Melicharová Marta', 'Jiráskova 565', '684 01', 5160, 'Slavkov u Brna', 'martamelicharova@seznam.cz', NULL, NULL, NULL, NULL),
(324, 'Zadina Josef', 'Petrohradská 28', '101 00', 5161, 'Praha 10', 'josef.zadina@gmail.com', '603 895 721', NULL, NULL, NULL),
(325, 'Georgiev Nikolaj', 'Dubová 1011', '530 06', 5162, 'Pardubice', 'georgiev@szg.cz', '724248446', NULL, NULL, NULL),
(326, 'Würflová Lenka', 'Bolevecká 2', '301 00', 5163, 'Plze?', 'moggie@seznam.cz', '602 652 526', NULL, NULL, NULL),
(327, 'Semencová Eliška', 'Bratronice 213', '273 63', 5164, 'okres Kladno', 'semencova.ela@seznam.cz', '721 610 105', NULL, NULL, NULL),
(328, 'Kynclová Jana', 'U Korábka 14/107', '779 00', 5165, 'Samotišky', 'vevrk@seznam.cz; hana.kovarikova@hnutiduha.cz', '776028016', NULL, NULL, NULL),
(329, 'Šarochová Andrea', '28. pluku 39', '100 00', 5166, 'Praha 10', 'andrea_sarochova@kb.cz', '602 223 791', NULL, NULL, NULL),
(330, 'Prokopová Lucie - Jan Prokop, Tara International s.r.o.', 'Na Staré pošt? 508', '53002', 5167, 'Pardubice', 'Lucie Prokopová [luciepro7@gmail.com]', '777 633 953', NULL, NULL, NULL),
(331, 'Pánková Eva', 'Na Rybárn? 382', '403 21', 5168, 'Ústí nad Labem', 'pankova.eva@centrum.cz', NULL, NULL, NULL, NULL),
(332, 'Koudelková Markéta', 'Nesovice 301', '683 33', 5169, NULL, 'makoudelkova@seznam.cz', '724 226 690', NULL, NULL, NULL),
(333, 'Peša Ji?í', 'Hlávkova 5', '602 00', 5170, 'Brno', 'pesa@rockovaskola.cz', '604233577', NULL, NULL, NULL),
(334, 'Tuzová Ludmila', 'Achtelky 1', '642 00', 5171, 'Brno', 'Ludmila.Tuzova@aplus.cz', '+420 602 567 242', NULL, NULL, NULL),
(335, '?ernošek Zden?k', 'Polní 202', '67801', 5172, 'Klepa?ov, Blansko', 'cernosek@tatsuno-europe.com', '+420724038425', NULL, NULL, NULL),
(336, 'Šnajbergová Helena Mudr', 'Na Klaudiánce 18', '14700', 5173, 'Praha 4', 'snajbergova@seznam.cz', '602844590', NULL, NULL, NULL),
(337, 'Hadam?íkovi Pavel a Bohuslava', 'Gagarinova 36', NULL, 5174, 'Opava', 'info@dery.cz', ' 602775934', NULL, NULL, NULL),
(338, 'Jahnová Marie', 'Písecká 919', '391 65', 5175, 'Bechyn?', ' marie.jahnova@gmail.com', '608510819', NULL, NULL, NULL),
(339, 'Fiala Petr', '5.kv?tna 63', NULL, 5176, 'Praha 4', ' fiala-petr@volny.cz; mliterova@gmail.com', '+420 603 221 157; +420 777 848 220', NULL, NULL, NULL),
(340, 'Gabrielová Zdena', 'Botanická 24', '602 00', 5177, 'Brno', 'gzdena@seznam.cz', '737764868', NULL, NULL, NULL),
(341, 'Valová Anna', 'Kotlanova 3', '62800', 5178, 'Brno', 'valova@aposbrno.cz', ' 541217516', NULL, NULL, NULL),
(342, 'Škva?ilová Kate?ina', 'Matzenauerova 9', '61600', 5179, 'Brno', 'kskvarilova@centrum.cz', ' 776555025', NULL, NULL, NULL),
(343, 'Samková Jana', 'Poštovská 5', '190 00', 5181, 'Praha 9', 'jana.samkova@seznam.cz;', '+420 605 748 339', NULL, NULL, NULL),
(344, 'Hájková Michaela', 'Arabská 1', '160 00', 5182, 'Praha 6', 'posta@misahajkova.cz', '603187251', NULL, NULL, NULL),
(345, 'Šutáková Ladislava', 'Hermannova 5', '620 00', 5183, 'Brno', 'ladislava.sutakova@seznam.cz', '602517537', NULL, NULL, NULL),
(346, 'Markusová Helena', 'Osadní 41', '170 00', 5184, 'Praha 7 - Holešovice', 'trojskah@seznam.cz', ' 721710214', NULL, NULL, NULL),
(347, 'Kadrnožka Miroslav', 'Strážnická 12', '62700', 5185, 'Brno', 'mirek@kadrnozka.cz', '739219936', NULL, NULL, NULL),
(348, 'Dosko?il Miroslav', 'Letní 847', '566 01', 5186, 'Vysoké Mýto', 'doskocil@donocykl.cz', '603 827 486', NULL, NULL, NULL),
(349, 'St?ední odborná škola, Blatná', 'V Jezárkách 745', '388 01', 5187, 'Blatná', 'skola@blek.cz', '383 412 211', NULL, NULL, NULL),
(350, 'Marek Miroslav', 'Putimov 94', '393 01', 5188, 'Pelh?imov', 'mira@dobryden.cz', '00420777603303', NULL, NULL, NULL),
(351, 'Novotná Jana', 'V pr?honech 359', NULL, 5189, 'Vysoke Myto', 'novotnamyto@seznam.cz', '775024223', NULL, NULL, NULL),
(352, '?erná Marie', 'Podešvova 266', '664 52', 5190, 'Sokolnice', 'mcerna@tenza.cz, jhanakova@tenza.cz', '608 743 916', NULL, NULL, NULL),
(353, 'Mudr. Jan Šich, Bc. Miloslava Horá?ková', 'Foerstrova 1656', '50002', 5191, 'Hradec Králové', 'horackovamiloslava@seznam.cz', '495 538 342', NULL, NULL, NULL),
(354, 'Nová?ek Ond?ej', 'U Dlouhé st?ny 13', NULL, 5192, NULL, 'ondrej.novacek@rozhlas.cz', '724019180', NULL, NULL, NULL),
(355, 'Ku?ová Simona', 'Labská kotlina 984', '50002', 5193, 'Hradec Králové 2', 'simonakucova@seznam.cz', '602167357', NULL, NULL, NULL),
(356, 'Hájek Jan a Drahomíra', 'Kolovraty 430', '103 00', 5194, 'Praha 10', 'dajkahjd@centrum.cz', '720 685 583', NULL, NULL, NULL),
(357, 'Samková Alena', 'Škroupovo nám. 3', '130 00', 5195, 'Praha 3', 'samkova.mc@seznam.cz', '+420 607 591 231', NULL, NULL, NULL),
(358, 'Havlásková Mária', 'Sklepní 331', '69185', 5196, 'Dolní Dunajovice', 'majka0@seznam.cz', '606 631 715', NULL, NULL, NULL),
(359, 'Zadražil Martin', 'Fr. Kadlece 849/12', '18000', 5197, 'Praha 8', 'zar@nri.cz', '608539593', NULL, NULL, NULL),
(360, 'Krempa Daniel', '?eskobrodská 574', '190 11', 5198, 'Praha 9', 'dankrempa@googlemail.com', '731627084', NULL, NULL, NULL),
(361, 'Fialová Monika', 'Zahradníkova 14', '60200', 5199, 'Brno', 'mon.fialova@seznam.cz', '602428430', NULL, NULL, NULL),
(362, 'Vyroubalová Hana', 'U M?stského dvora 4', '772 00', 5200, 'Olomouc', 'hana.vyroubalova@upol.cz', '603730672', NULL, NULL, NULL),
(363, 'Pavla Rubí?ková', 'Tvrdonická 9', '62900', 5201, 'Brno', 'pavla.rubickova@email.cz', '774904747', NULL, NULL, NULL),
(364, 'Medvec Daniel', 'Spádová 11', '64300', 5202, 'Brno', 'dan.medvec@centrum.cz', '+420602571327', NULL, NULL, NULL),
(365, 'Sabol?iková Dagmar', 'Štefánikova 293', '566 01', 5203, 'Vysoké Mýto', 'd.sabolcikova@centrum.cz', '731942484', NULL, NULL, NULL),
(366, 'Malasková Dana', 'Lod?nická 633', '78314', 5204, 'Bohu?ovice', 'LadyBird.D@seznam.cz', '775383245', NULL, NULL, NULL),
(367, 'Burian Jan', '?SA 1066', '684 01', 5206, 'Slavkov', 'burian@selfservis.cz', '606740708', NULL, NULL, NULL),
(368, 'Lišková Lenka', 'Blízkov 43', '59442', 5207, 'M??ín', 'lenkatroj@seznam.cz', '608070971', NULL, NULL, NULL),
(369, 'Ta?ána Mochanová, Michaela Hanušová', 'Fibichova 10', '32300', 5208, 'Plze?', 'tmochanova@seznam.cz', '724782482', NULL, NULL, NULL),
(370, 'Kr?ma Daniel', 'Na strži 65', '14000', 5209, 'Praha 4', 'krcma@greenmotion.cz', '+420606645278', NULL, NULL, NULL),
(371, 'Slezákovi Michaela a Leoš', 'Pozna?ská 8', '616 00', 5210, 'Brno', 'uberhuberova@seznam.cz', '732 738 567, 733 599 986', NULL, NULL, NULL),
(372, 'Doležalová Marie', 'Nová 1001/15', '674 01', 5211, 'T?ebí?', 'mary.dol@seznam.cz', '605 442 136', NULL, NULL, NULL),
(373, 'Horákovi Zden?k  a Marie', 'Chmelenec 406', '683 54', 5212, 'Bošovice', 'z.krtek@seznam.cz', '774452708', NULL, NULL, NULL),
(374, 'Martin Zbo?il, Hana Vacková', 'Kachlikova 5', '635 00', 5213, 'Brno', 'marzbor@seznam.cz; vackova@haifa-design.cz', '+420 606748929', NULL, NULL, NULL),
(375, 'Št?pánková Jitka', 'Na Chmelnicích 71', '323 00', 5215, 'Plze?', 'jituska.ruzicka@seznam.cz', '602 12 13 85', NULL, NULL, NULL),
(376, 'Straková Hana', 'Za myslivnou 444', '664 07', 5216, 'Pozo?ice', 'hana.strakova@nsoud.cz', '723748974', NULL, NULL, NULL),
(377, 'Kva?ková Jana', 'Lauterbachova 826', NULL, 5217, 'Chlumec nad Cidlinou', 'kvackovaj@seznam.cz', '774664964', NULL, NULL, NULL),
(378, 'Lopourovi Tereza a Vladimír', 'Nerudova 666', '582 22', 5218, 'P?ibyslav', 'terilopi@seznam.cz', '607528258', NULL, NULL, NULL),
(379, 'Be?o Ivan', 'Kydlinovská  156', NULL, 5219, 'Hradec Králové', 'ivan.beno@seznam.cz', '+420 603 453 188', NULL, NULL, NULL),
(380, 'Martínková Petra', 'Dražická 738', '294 71', 5220, 'Benátky nad Jizerou', 'petra.martinek@email.cz', '731437891', NULL, NULL, NULL);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `dite`
--
ALTER TABLE `dite`
  ADD CONSTRAINT `dite_ibfk_1` FOREIGN KEY (`skolaIdSkola`) REFERENCES `skola` (`idSkola`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `ditelog`
--
ALTER TABLE `ditelog`
  ADD CONSTRAINT `ditelog_ibfk_1` FOREIGN KEY (`diteIdDite`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `platba`
--
ALTER TABLE `platba`
  ADD CONSTRAINT `platba_ibfk_1` FOREIGN KEY (`diteIdDite`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `platba_ibfk_2` FOREIGN KEY (`sponzorIdSponzor`) REFERENCES `sponzor` (`idSponzor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `platba_ibfk_3` FOREIGN KEY (`benefitIdBenefit`) REFERENCES `benefit` (`idBenefit`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `poznamka`
--
ALTER TABLE `poznamka`
  ADD CONSTRAINT `poznamka_ibfk_1` FOREIGN KEY (`diteIdDite`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `poznamka_ibfk_2` FOREIGN KEY (`sponzorIdSponzor`) REFERENCES `sponzor` (`idSponzor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `relaceditebenefit`
--
ALTER TABLE `relaceditebenefit`
  ADD CONSTRAINT `relaceditebenefit_ibfk_1` FOREIGN KEY (`diteIdDite`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relaceditebenefit_ibfk_2` FOREIGN KEY (`benefitIdBenefit`) REFERENCES `benefit` (`idBenefit`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `relaceditesponzor`
--
ALTER TABLE `relaceditesponzor`
  ADD CONSTRAINT `relaceditesponzor_ibfk_1` FOREIGN KEY (`diteIdDite`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relaceditesponzor_ibfk_2` FOREIGN KEY (`sponzorIdSponzor`) REFERENCES `sponzor` (`idSponzor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `sourozenzi`
--
ALTER TABLE `sourozenzi`
  ADD CONSTRAINT `sourozenzi_ibfk_1` FOREIGN KEY (`diteIdDite1`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sourozenzi_ibfk_2` FOREIGN KEY (`diteIdDite2`) REFERENCES `dite` (`idDite`) ON DELETE NO ACTION ON UPDATE NO ACTION;
