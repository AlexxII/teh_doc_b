-- MySQL dump 10.13  Distrib 8.0.13, for Linux (x86_64)
--
-- Host: localhost    Database: tehdoc
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` int(11) DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,'Суперадмин','sAdmin','ZGtnoRBi2HXxH2pZZLUPqgE0qtQEJPKF','$2y$13$30KtS6YN3BR9l.vyC8fcEudxG4/4DAxpQ/Mx53FmyGm7E5Lq0eRE2',NULL,'super@admin.ru',10,1547536202,1547536202),(2,NULL,'Врачев Д.С.','VrachevDS','1imph-r_4d_6lcyv-HD8X6xZySKsvgPO','$2y$13$iZa.4O8honqlTHmBv1PN1O6y2QhQXLaii1EmuDOEO0v6Bq.xuonXa',NULL,'VrachevDS@localhost.ru',10,1547536412,1547536412),(3,NULL,'Малышев В.Ю.','MalyshevVU','z9E_i7MNi6i20Cjb1mWDwyl0hxGc3Kfz','$2y$13$4SFZqp.0tKmERqJxVsuIBO8LgkfYermroDJcDAiNSLdG2xY5WPKkm',NULL,'MalyshevVU@localhost.ru',10,1547536938,1547563094),(4,NULL,'Лесин С.Н.','LesinSN','qpHcAYnqZRnBiBNh-bhyimV2STCShoal','$2y$13$3pqicQb6Y1LMp5DvZs1b8uomwt3FVpZ17k0s9lZYXklXh5Of93DAC',NULL,'LesinSN@localhost.ru',10,1547536972,1547536972),(5,NULL,'Игнатенко А.М.','IgnatenkoAM','ku1S7o5qq3jOJJPsHrt5voQeha-lNhtn','$2y$13$VXqR5psc6gebXzJfbkBlD.sf0o48COveiNPNItKDTlCqdOWFWROgK',NULL,'IgnatenkoAM@localhost.ru',10,1547537018,1547537018),(6,NULL,'Иванов С.Г.','IvanovSG','e-3zmHzuwSvkVonVCkXOZBL-UJs7_ipU','$2y$13$NAE/fOWdzXY4gKgFM0ekDeFqTKZi3nQLs9uWOeYu0Em5dh6N7FYvC',NULL,'IvanovSG@localhost.ru',10,1547537057,1547537057),(7,NULL,'Веснина Ю.В.','VesninaJV','zjkm7bF_6vbcFnEhiLCeyYWOXgWnbN-h','$2y$13$LpaDVIH5tZlSU1B7eXqrn.GsNbLdk0sDOh31rGjL7QhCVFSlP.KEe',NULL,'VesninaJV@localhost.ru',10,1547537108,1547537108),(8,NULL,'Казаков А.С.','KazakovAS','qC3ZJfp10RpdhOVPwjHPzA-Vh0FaIi6b','$2y$13$M7FDuKeQSZomKWs.73GofuHwNtbcQNHDLMb7pdCcgvrA4D.BJNpRm',NULL,'KazakovAS@localhost.ru',10,1547537146,1547537146),(9,NULL,'Иватина Е.А.','IvatinaEA','hCu_p7g1T2B0ldVAkQhs1wddMehEZCG_','$2y$13$sCjqWlj7ze/4eBFvecXR5uxMuNjxWiJaR1Y8QJ1b1CGu/uvfluGx2',NULL,'IvatinaEA@localhost.ru',10,1547537176,1547537176),(10,NULL,'Загородкина Д.И.','ZagorodkinaDI','8ZBN77wrAa80E4y2gs66WUn-O_LA-HrH','$2y$13$fkOXCekqRa6nQSrlUMk3ZudgjTxo3lCtmzYPl6eSidWKKaer/.liy',NULL,'ZagorodkinaDI@localhost.ru',10,1547537225,1547537225),(11,NULL,'Игнатенко Е.В.','IgnatenkoEV','3tnxvbuEZG5H9M7GuFlPCyUDXTM88yTr','$2y$13$/jK1jm9NtcoCX/XsCCcJtO8u3eS4VhEXM/5NXMXBnopTsvzGfPEoG',NULL,'IgnatenkoEV@localhost.ru',10,1547537794,1547537794);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-22 21:10:38
