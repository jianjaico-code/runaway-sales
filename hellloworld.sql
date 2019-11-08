CREATE DATABASE  IF NOT EXISTS `ecommerce-dev` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ecommerce-dev`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ecommerce-dev
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.33-MariaDB

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
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `CustomerId` int(10) NOT NULL,
  `CFirstname` char(25) NOT NULL,
  `CLastname` char(25) NOT NULL,
  `CPassword` varchar(255) NOT NULL,
  `CCellphoneNo` double NOT NULL,
  `CDeliveryAddress` varchar(45) NOT NULL,
  PRIMARY KEY (`CustomerId`),
  UNIQUE KEY `CellphoneNo_UNIQUE` (`CCellphoneNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1540280643,'Renz','Rafal','$2y$10$4opipLSjF13s74WmMqxLFeCFatLAuVHY0WBqLmn5yO1YYkiz9Bh/O',9154098032,'Somewhere in CDO'),(1540282465,'jose','ederango','$2y$10$86jRQHevvWWAfAzg3/ExcuaB0mwrIEDUg9xy6DO07cisJKC7EZF/y',9154098031,'Bulua Zone 1, Cagayan de Oro City Because why'),(1540480380,'James','Al','$2y$10$.fCsH8o/hiVR71fCAqi4IeyAGPZHKFF.GoF/yZQxS9S4ZGmMvFp6m',794148784,'Bulua'),(1541015344,'Pepe','on the mix','$2y$10$bPa0W1lecWpHV.xj9eZG4OdRYDu4c7u7I/w6cQarsfODHuldGGYZu',915454545,'Bulua Zone 1'),(1541015670,'Jian','Jaico','$2y$10$Y73icMk5rlRi7abTc6aQV.GCqCQbjJqq8s5W3KE0QADdm8ORJedk.',79879445678745,'PNR Subdivision, Jandorf St, Barra Opol Misam');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customerdelivery`
--

DROP TABLE IF EXISTS `customerdelivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customerdelivery` (
  `DeliveryId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `DeliveryStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`DeliveryId`),
  KEY `FKOrderIdCD_idx` (`OrderId`),
  CONSTRAINT `FKOrderIdCD` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customerdelivery`
--

LOCK TABLES `customerdelivery` WRITE;
/*!40000 ALTER TABLE `customerdelivery` DISABLE KEYS */;
INSERT INTO `customerdelivery` VALUES (1540310681,1540310681,'pending'),(1540311610,1540311610,'pending'),(1540329091,1540329091,'delivered'),(1540332306,1540332306,'onfulfillment'),(1540407553,1540407553,'pending'),(1540905205,1540905205,'pending'),(1540905794,1540905794,'delivered'),(1540905921,1540905921,'pending'),(1540905928,1540905928,'delivered'),(1540905996,1540905996,'pending'),(1540906142,1540906142,'delivered'),(1540906278,1540906278,'delivered'),(1540906300,1540906300,'delivered'),(1540906308,1540906308,'pending'),(1540906313,1540906313,'delivered'),(1540906333,1540906333,'delivered'),(1540906527,1540906527,'pending'),(1540906904,1540906904,'pending'),(1540910928,1540910928,'delivered'),(1540910952,1540910952,'pending'),(1541013229,1541013229,'pending'),(1541015385,1541015385,'pending'),(1541015755,1541015755,'delivered'),(1541365865,1541365865,'pending'),(1541457106,1541457106,'pending'),(1541457136,1541457136,'pending'),(1541457170,1541457170,'delivered'),(1541522953,1541522953,'delivered'),(1541523534,1541523534,'pending');
/*!40000 ALTER TABLE `customerdelivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customerdeliverydetails`
--

DROP TABLE IF EXISTS `customerdeliverydetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customerdeliverydetails` (
  `DeliveryId` int(11) NOT NULL,
  `PlateNo` char(10) NOT NULL,
  `DeliveryDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CustomerPayment` double NOT NULL,
  KEY `FKDeliveryIdCDD_idx` (`DeliveryId`),
  KEY `FKPlateNoCDD_idx` (`PlateNo`),
  CONSTRAINT `FKDeliveryIdCDD` FOREIGN KEY (`DeliveryId`) REFERENCES `customerdelivery` (`DeliveryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKPlateNoCDD` FOREIGN KEY (`PlateNo`) REFERENCES `vehicle` (`PlateNo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customerdeliverydetails`
--

LOCK TABLES `customerdeliverydetails` WRITE;
/*!40000 ALTER TABLE `customerdeliverydetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `customerdeliverydetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `EmployeeId` int(11) NOT NULL,
  `EmployeePositionId` int(11) NOT NULL,
  `EFirstname` char(25) NOT NULL,
  `ELastname` char(25) NOT NULL,
  `EPassword` char(255) NOT NULL,
  `EContactNo` bigint(11) NOT NULL,
  PRIMARY KEY (`EmployeeId`),
  UNIQUE KEY `ContactNo_UNIQUE` (`EContactNo`),
  KEY `FKEmployeePositionIdE_idx` (`EmployeePositionId`),
  CONSTRAINT `FKEmployeePositionIdE` FOREIGN KEY (`EmployeePositionId`) REFERENCES `employeeposition` (`EmployeePositionId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1540281901,0,'reynaldo','tambiga','$2y$10$DxOsvpwk/3BmcVx38oH8pue3GfshJ9GknMmxrbm.TmIJIBfOEPMny',9150784408),(1540282092,1,'ace','macarandan','$2y$10$s8ER92CdihDw0gh8.3Dvm.yD2ofiOHDPB1/oDOT86yDyTV2P0KW5O',9150784401),(1540490389,1,'James','Doe','$2y$10$wyhO3tDchRD3ocIbRn9Ct.FnQi7U8o9FZgqWJaqNRafmy9YMJuQfu',12346123123),(1540490626,0,'James','Jessa','$2y$10$MvIkE8fyMH.UQi3cxCXIee9kWF/vNkQ9R3J8DLFCE6/qIlssFdo9m',12353142531132),(1540490662,1,'Jane','Doe','$2y$10$Ii8JAu9FuN2oS8arrKOENOB1QEGWLTj7Bscv28/VCppWJewT0iBE.',213131320271398208);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employeeposition`
--

DROP TABLE IF EXISTS `employeeposition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employeeposition` (
  `EmployeePositionId` int(11) NOT NULL,
  `Position` char(15) NOT NULL,
  PRIMARY KEY (`EmployeePositionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employeeposition`
--

LOCK TABLES `employeeposition` WRITE;
/*!40000 ALTER TABLE `employeeposition` DISABLE KEYS */;
INSERT INTO `employeeposition` VALUES (0,'admin'),(1,'delivery');
/*!40000 ALTER TABLE `employeeposition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderdetails` (
  `OrderId` int(10) NOT NULL,
  `ProductId` int(10) NOT NULL,
  `OrderQuantity` int(6) NOT NULL,
  KEY `FKProductIdOD_idx` (`ProductId`),
  KEY `FKOrderIdOD` (`OrderId`),
  CONSTRAINT `FKOrderIdOD` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FKProductIdOD` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderdetails`
--

LOCK TABLES `orderdetails` WRITE;
/*!40000 ALTER TABLE `orderdetails` DISABLE KEYS */;
INSERT INTO `orderdetails` VALUES (1540310681,1540309657,1),(1540310681,1540309749,1),(1540311610,1540309657,5),(1540329091,1540306573,3),(1540329091,1540309749,1),(1540332306,1540306573,2),(1540332306,1540309657,1),(1540407553,1540309657,3),(1540905205,1540309749,2),(1540905794,1540306573,2),(1540905921,1540306573,3),(1540905928,1540306573,3),(1540905996,1540306573,2),(1540906142,1540306573,2),(1540906142,1540309749,3),(1540906278,1540306573,2),(1540906300,1540306573,2),(1540906308,1540306573,2),(1540906313,1540306573,2),(1540906333,1540309749,2),(1540906527,1540309749,1),(1540906904,1540309749,1),(1540910928,1540306573,1),(1540910952,1540306573,2),(1541013229,1540309657,1),(1541015385,1540306573,1),(1541015755,1540309749,10),(1541365865,1540306573,2),(1541457106,1541366604,1),(1541457136,1540309749,20),(1541457170,1540921083,3),(1541522953,1540921083,2),(1541523534,1540309749,8);
/*!40000 ALTER TABLE `orderdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `OrderId` int(10) NOT NULL,
  `CustomerId` int(10) NOT NULL,
  `EmployeeId` int(10) DEFAULT NULL,
  `OrderDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Amount` double NOT NULL,
  PRIMARY KEY (`OrderId`),
  KEY `FKCustomerIdO_idx` (`CustomerId`),
  KEY `FKEmployeeIdO_idx` (`EmployeeId`),
  CONSTRAINT `FKCustomerIdO` FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`CustomerId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKEmployeeIdO` FOREIGN KEY (`EmployeeId`) REFERENCES `employee` (`EmployeeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1540310681,1540282465,NULL,'2018-10-24 00:04:41',734),(1540311610,1540282465,NULL,'2018-10-24 00:20:10',1835),(1540329091,1540282465,NULL,'2018-10-24 05:11:31',2766.97),(1540332306,1540282465,NULL,'2018-10-24 06:05:06',2149.63),(1540407553,1540282465,NULL,'2018-10-29 23:55:12',1648.95),(1540905205,1540282465,1540490626,'2018-10-30 21:13:25',734),(1540905794,1540282465,1540490626,'2018-10-30 21:23:14',1599.98),(1540905921,1540480380,1540490626,'2018-10-30 21:25:21',2399.9700000000003),(1540905928,1540480380,1540490626,'2018-10-30 21:25:28',2399.9700000000003),(1540905996,1540480380,1540490626,'2018-10-30 21:26:36',1599.98),(1540906142,1540280643,1540490626,'2018-10-30 21:29:02',2700.98),(1540906278,1540480380,1540490626,'2018-10-30 21:31:18',1599.98),(1540906300,1540480380,1540490626,'2018-10-30 21:31:40',1599.98),(1540906308,1540280643,1540490626,'2018-10-30 21:31:48',1599.98),(1540906313,1540280643,1540490626,'2018-10-30 21:31:53',1599.98),(1540906333,1540282465,1540490626,'2018-10-30 21:32:13',734),(1540906527,1540280643,1540490626,'2018-10-30 21:35:27',367),(1540906904,1540280643,1540490626,'2018-10-30 21:41:44',367),(1540910928,1540480380,1540490626,'2018-10-30 22:48:48',799.99),(1540910952,1540280643,1540490626,'2018-10-30 22:49:12',1599.98),(1541013229,1540480380,1540490626,'2018-11-01 03:13:49',549.65),(1541015385,1541015344,1540490626,'2018-11-01 03:49:45',799.99),(1541015755,1541015670,1540490626,'2018-11-01 03:55:55',3670),(1541365865,1541015344,1540490626,'2018-11-05 05:11:05',1599.98),(1541457106,1540480380,1540490626,'2018-11-06 06:31:46',999.99),(1541457136,1540480380,1540490626,'2018-11-06 06:32:16',7340),(1541457170,1540280643,1540490626,'2018-11-06 06:32:50',1500),(1541522953,1540480380,1540490626,'2018-11-07 00:49:13',1000),(1541523534,1540480380,1540490626,'2018-11-07 00:58:54',2936);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `ProductId` int(10) NOT NULL,
  `PBrand` char(20) NOT NULL,
  PRIMARY KEY (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1540306573,'Bench'),(1540309657,'Bench'),(1540309749,'Bench'),(1540921083,'Penshoppee'),(1541366604,'Ederango'),(1541525080,'Hatdog');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productcategory`
--

DROP TABLE IF EXISTS `productcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productcategory` (
  `ProductId` int(10) NOT NULL,
  `PName` char(25) NOT NULL,
  `PQuantity` int(6) NOT NULL,
  `PPrice` double NOT NULL,
  `PSizes` char(255) DEFAULT NULL,
  `PColors` char(255) DEFAULT NULL,
  `PImage` varchar(255) NOT NULL,
  PRIMARY KEY (`PName`),
  UNIQUE KEY `PName_UNIQUE` (`PName`),
  KEY `FKProductIdPC_idx` (`ProductId`),
  CONSTRAINT `FKProductIdPC` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productcategory`
--

LOCK TABLES `productcategory` WRITE;
/*!40000 ALTER TABLE `productcategory` DISABLE KEYS */;
INSERT INTO `productcategory` VALUES (1541366604,'Akong ate',0,999.99,'Small','Brown','1541366604-29541840_2058239971122357_145661548531025792_n.jpg'),(1540309657,'Baby Boy Hat',19,549.65,'','Black, Gray, White','1540998059-pexels-photo-1308886.jpeg'),(1541525080,'Everypme',100,12345.3,'','','1541525080-13920644_1102189339835973_4279470589987939606_n.jpg'),(1540306573,'First Product',0,799.99,'Small, Medium, Large, Extra Large','Black, Gray, White','1541522852-42215691_2171521273102109_4375332662458449920_n.jpg'),(1540309749,'placeholder image',0,367,'Small, Medium, Large, Extra Large','Black, Gray, White','1540309749-placeholder.png'),(1540921083,'Somebody to love',20,500,'Small, Medium, Large, Extra Large','White, Black, Red','1540998027-pexels-photo-354953.jpeg');
/*!40000 ALTER TABLE `productcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchasedetails`
--

DROP TABLE IF EXISTS `purchasedetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchasedetails` (
  `PurchaseOrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `SupplierDeliveryId` int(11) DEFAULT NULL,
  `POPrice` double DEFAULT NULL,
  `POQuantity` int(6) NOT NULL,
  KEY `FKPurchaseOrderIdPD_idx` (`PurchaseOrderId`),
  KEY `FKProductIdPD_idx` (`ProductId`),
  KEY `FKSupplierDeliveryIdPD_idx` (`SupplierDeliveryId`),
  CONSTRAINT `FKProductIdPD` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKPurchaseOrderIdPD` FOREIGN KEY (`PurchaseOrderId`) REFERENCES `purchaseorder` (`PurchaseOrderId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKSupplierDeliveryIdPD` FOREIGN KEY (`SupplierDeliveryId`) REFERENCES `supplierdelivery` (`SupplierDeliveryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchasedetails`
--

LOCK TABLES `purchasedetails` WRITE;
/*!40000 ALTER TABLE `purchasedetails` DISABLE KEYS */;
INSERT INTO `purchasedetails` VALUES (1541364062,1540306573,NULL,NULL,1),(1541364157,1540306573,NULL,NULL,1),(1541364195,1540306573,NULL,NULL,1),(1541364672,1540921083,NULL,NULL,1),(1541364858,1540306573,NULL,NULL,10),(1541364878,1540309749,NULL,NULL,11),(1541365270,1540309749,NULL,NULL,1),(1541365277,1540309749,NULL,NULL,9),(1541521388,1540309749,NULL,NULL,1),(1541525035,1540309657,NULL,NULL,8),(1541525035,1540921083,NULL,NULL,8);
/*!40000 ALTER TABLE `purchasedetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchaseorder`
--

DROP TABLE IF EXISTS `purchaseorder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchaseorder` (
  `PurchaseOrderId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `PODate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PODeliveryAddress` varchar(30) NOT NULL,
  `POStatus` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`PurchaseOrderId`),
  KEY `FKEmployeeIdPO_idx` (`EmployeeId`),
  KEY `FKSupplierIdPO_idx` (`SupplierId`),
  CONSTRAINT `FKEmployeeIdPO` FOREIGN KEY (`EmployeeId`) REFERENCES `employee` (`EmployeeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKSupplierIdPO` FOREIGN KEY (`SupplierId`) REFERENCES `supplier` (`SupplierId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchaseorder`
--

LOCK TABLES `purchaseorder` WRITE;
/*!40000 ALTER TABLE `purchaseorder` DISABLE KEYS */;
INSERT INTO `purchaseorder` VALUES (1541364062,1540281901,1541192617,'2018-11-05 04:41:02','asdsadasdsdasdas','pending'),(1541364157,1540281901,1234,'2018-11-05 04:42:37','asdsadsad\"','pending'),(1541364195,1540281901,1234,'2018-11-05 04:43:15','asdsadsad\" DELETE * FROM custo','pending'),(1541364672,1540281901,1234,'2018-11-05 04:51:12','bisag asa','pending'),(1541364858,1540281901,1234,'2018-11-05 04:54:18','Carmen hgahah','pending'),(1541364878,1540281901,1233,'2018-11-05 04:54:38','asdsadsadsadasdsa','pending'),(1541365270,1540281901,1234,'2018-11-05 05:01:10','asdsadasda','pending'),(1541365277,1540281901,1234,'2018-11-05 05:01:17','asdsadasdaadasdasd','pending'),(1541521388,1540281901,1541192617,'2018-11-07 00:23:08','Patag','pending'),(1541525035,1540281901,1233,'2018-11-07 01:23:55','adadasd','pending');
/*!40000 ALTER TABLE `purchaseorder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `returns`
--

DROP TABLE IF EXISTS `returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `returns` (
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `ItemCount` int(11) NOT NULL,
  `ReturnDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Reason` varchar(255) NOT NULL,
  KEY `FKOrderIdReturns_idx` (`OrderId`),
  KEY `FKProductId_idx` (`ProductId`),
  CONSTRAINT `FKOrderIdReturns` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKProductId` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` VALUES (1540329091,1540306573,1,'2018-11-05 07:24:21','Some reason'),(1540906142,1540309749,1,'2018-11-06 06:22:53','basta guba'),(1541457170,1540921083,1,'2018-11-06 06:35:20','hahhaha');
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `SupplierId` int(11) NOT NULL,
  `SCompanyName` char(15) NOT NULL,
  `SContactNo` bigint(11) NOT NULL,
  `SAddress` varchar(30) NOT NULL,
  `SPassword` varchar(255) NOT NULL,
  PRIMARY KEY (`SupplierId`),
  UNIQUE KEY `ContactNo_UNIQUE` (`SContactNo`),
  UNIQUE KEY `SCompanyName_UNIQUE` (`SCompanyName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES (1233,'Bench',915409831,'Davao, Philippines',''),(1234,'Avon',9154098032,'Cagayan de Oro City',''),(1541192617,'Hello World',879764645678,'Carmen','$2y$10$iSVb1hlnQziUVOw.jHkBveCqRi7m7yBLjELnVg/ROidD1xs/EbmqC'),(1541525130,'abog',12341231,'asdadads','$2y$10$eGcCPvt9CZEoCfZJpU7Nzujy91drrns/ySjxASNGiUlfYNXSa7Flq');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplierdelivery`
--

DROP TABLE IF EXISTS `supplierdelivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplierdelivery` (
  `SupplierDeliveryId` int(11) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `PaymentToSupplier` double NOT NULL,
  `SupplyDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PurchaseOrderId` int(11) NOT NULL,
  PRIMARY KEY (`SupplierDeliveryId`),
  KEY `FKSupplierIdSD_idx` (`SupplierId`),
  KEY `FKPurchaseOrderIdSD_idx` (`PurchaseOrderId`),
  CONSTRAINT `FKPurchaseOrderIdSD` FOREIGN KEY (`PurchaseOrderId`) REFERENCES `purchaseorder` (`PurchaseOrderId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKSupplierIdSD` FOREIGN KEY (`SupplierId`) REFERENCES `supplier` (`SupplierId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplierdelivery`
--

LOCK TABLES `supplierdelivery` WRITE;
/*!40000 ALTER TABLE `supplierdelivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplierdelivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplierdeliverydetails`
--

DROP TABLE IF EXISTS `supplierdeliverydetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplierdeliverydetails` (
  `ProductId` int(11) NOT NULL,
  `SupplierDeliveryId` int(10) NOT NULL,
  `SupplyStatus` char(10) NOT NULL,
  `SupplyQuantity` int(10) NOT NULL,
  `Unit` varchar(10) DEFAULT NULL,
  KEY `FKProductIdSDD_idx` (`ProductId`),
  KEY `FKSupplierDeliveryId_idx` (`SupplierDeliveryId`),
  CONSTRAINT `FKProductIdSDD` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKSupplierDeliveryId` FOREIGN KEY (`SupplierDeliveryId`) REFERENCES `supplierdelivery` (`SupplierDeliveryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplierdeliverydetails`
--

LOCK TABLES `supplierdeliverydetails` WRITE;
/*!40000 ALTER TABLE `supplierdeliverydetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplierdeliverydetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle` (
  `PlateNo` char(10) NOT NULL,
  `Description` char(15) NOT NULL,
  `VehicleTypeId` int(11) NOT NULL,
  PRIMARY KEY (`PlateNo`),
  KEY `FKVehicleTypeIdV_idx` (`VehicleTypeId`),
  CONSTRAINT `FKVehicleTypeIdV` FOREIGN KEY (`VehicleTypeId`) REFERENCES `vehicletype` (`VehicleTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicletype`
--

DROP TABLE IF EXISTS `vehicletype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicletype` (
  `VehicleTypeId` int(11) NOT NULL,
  `Type` char(15) NOT NULL,
  PRIMARY KEY (`VehicleTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicletype`
--

LOCK TABLES `vehicletype` WRITE;
/*!40000 ALTER TABLE `vehicletype` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicletype` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-07  3:45:54
