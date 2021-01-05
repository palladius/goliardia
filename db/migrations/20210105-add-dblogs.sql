-- ok sto copiando lidea da rails lo ammetto

DROP TABLE IF EXISTS `dblogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dblogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `severity` varchar(20) NOT NULL,
  `facility` varchar(20) NOT NULL,
  `log` longtext CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `docker_context` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

