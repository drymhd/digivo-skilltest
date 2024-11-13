DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int DEFAULT '299000',
  `sku` varchar(10) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'Produk 1',299000,'KFIG','pending','2024-11-13 05:52:26'),(2,2,'Produk 2',299000,'OMSHU7A992','pending','2024-11-13 05:52:26'),(3,3,'Produk 3',299000,'SK','pending','2024-11-13 05:52:26'),(4,4,'Produk 4',299000,'CDYBKML','pending','2024-11-13 05:52:26'),(5,5,'Produk 5',299000,'J','pending','2024-11-13 05:52:26'),(6,6,'Produk 6',299000,'6E20','pending','2024-11-13 05:52:26'),(7,7,'Produk 7',299000,'5JM','pending','2024-11-13 05:52:26'),(8,8,'Produk 8',299000,'Y3UG','pending','2024-11-13 05:52:26'),(9,9,'Produk 9',299000,'SRT','pending','2024-11-13 05:52:26'),(10,10,'Produk 10',299000,'7FXXURAAU','pending','2024-11-13 05:52:26'),(11,11,'Produk 11',299000,'5XL38L','pending','2024-11-13 05:52:26'),(12,12,'Produk 12',299000,'EV6Y9S3G','pending','2024-11-13 05:52:26'),(13,13,'Produk 13',299000,'FRRKWQQ8Y','pending','2024-11-13 05:52:26'),(14,14,'Produk 14',299000,'HD2PZXVSM','pending','2024-11-13 05:52:26'),(15,15,'Produk 15',299000,'L','pending','2024-11-13 05:52:26'),(16,16,'Produk 16',299000,'Q8XUFHZ65','pending','2024-11-13 05:52:26'),(17,17,'Produk 17',299000,'ZNCVS5','pending','2024-11-13 05:52:26'),(18,18,'Produk 18',299000,'MZE5MN57N','pending','2024-11-13 05:52:26'),(19,19,'Produk 19',299000,'BVXR27','pending','2024-11-13 05:52:26'),(20,20,'Produk 20',299000,'NCTC1RMDU','pending','2024-11-13 05:52:26'),(21,21,'Produk 21',299000,'HSF','pending','2024-11-13 05:52:26'),(22,22,'Produk 22',299000,'KS9CFWH','pending','2024-11-13 05:52:26'),(23,23,'Produk 23',299000,'6OB8V','pending','2024-11-13 05:52:26'),(24,24,'Produk 24',299000,'UDBG8A1PK','pending','2024-11-13 05:52:26'),(25,25,'Produk 25',299000,'3L490Y','pending','2024-11-13 05:52:26'),(26,26,'Produk 26',299000,'R0U6Z7','pending','2024-11-13 05:52:26'),(27,27,'Produk 27',299000,'BTM2H4F36','pending','2024-11-13 05:52:26'),(29,29,'Produk 29',299000,'71','pending','2024-11-13 05:52:26'),(30,30,'Produk 30',299000,'8ZW1H6','pending','2024-11-13 05:52:26'),(31,31,'Produk 31',299000,'A4TPWAGK','pending','2024-11-13 05:52:26'),(32,32,'Produk 32',299000,'E9','pending','2024-11-13 05:52:26'),(33,33,'Produk 33',299000,'YA20B','pending','2024-11-13 05:52:26'),(34,34,'Produk 34',299000,'KK64C','pending','2024-11-13 05:52:26'),(35,35,'Produk 35',299000,'E3','pending','2024-11-13 05:52:26'),(36,36,'Produk 36',299000,'98S6NPHCVT','pending','2024-11-13 05:52:26'),(37,37,'Produk 37',299000,'XOBXS73','pending','2024-11-13 05:52:26'),(38,38,'Produk 38',299000,'FPC10H5QI5','pending','2024-11-13 05:52:26'),(39,39,'Produk 39',299000,'3W8','pending','2024-11-13 05:52:26'),(40,40,'Produk 40',299000,'I6S1RAG6JJ','pending','2024-11-13 05:52:26'),(41,41,'Produk 41',299000,'QV7MKL0L','pending','2024-11-13 05:52:26'),(42,42,'Produk 42',299000,'WW','pending','2024-11-13 05:52:26'),(43,43,'Produk 43',299000,'S09F65JT','pending','2024-11-13 05:52:26'),(44,44,'Produk 44',299000,'A9','pending','2024-11-13 05:52:26'),(45,45,'Produk 45',299000,'RX1','pending','2024-11-13 05:52:26'),(46,46,'Produk 46',299000,'VBMGFD','pending','2024-11-13 05:52:26'),(47,47,'Produk 47',299000,'PQ4MVNG1T3','pending','2024-11-13 05:52:26'),(48,48,'Produk 48',299000,'4D','pending','2024-11-13 05:52:26'),(49,49,'Produk 49',299000,'3J4C5Y50','pending','2024-11-13 05:52:26'),(50,50,'Produk 50',299000,'DM7628W','pending','2024-11-13 05:52:26');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'digivo_jawaban2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13 12:53:25
