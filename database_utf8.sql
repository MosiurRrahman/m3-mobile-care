-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: m3-mobile-care
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `m3-mobile-care`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `m3-mobile-care` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `m3-mobile-care`;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `loggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loggable_id` bigint unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changes` json DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_loggable_type_loggable_id_index` (`loggable_type`,`loggable_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'App\\Models\\Repair',1,'updated','{\"status\": {\"new\": \"repairing\", \"old\": \"pending\"}}','updated Job Card (Ticket: M3-202607-TEST): Status from \'Pending\' to \'Repairing\'','127.0.0.1','2026-07-13 05:04:17','2026-07-13 05:04:17'),(2,1,'App\\Models\\SocialPost',1,'created',NULL,'created a new post for Facebook','127.0.0.1','2026-07-13 05:04:17','2026-07-13 05:04:17'),(3,5,'App\\Models\\Repair',2,'updated','{\"actual_cost\": {\"new\": \"3600.00\", \"old\": \"3500.00\"}}','updated Job Card (Ticket: M3-202607-0002): Actual Cost from \'3,500.00 BDT\' to \'3,600.00 BDT\'','127.0.0.1','2026-07-13 05:08:39','2026-07-13 05:08:39'),(4,5,'App\\Models\\Sale',5,'created','[]','created Sale Invoice #INV-20260713-RAQK with total 450.00 BDT','127.0.0.1','2026-07-13 05:17:56','2026-07-13 05:17:56'),(5,5,'App\\Models\\InventoryItem',77,'updated','{\"quantity\": {\"new\": 28, \"old\": 29}}','updated Inventory Item \'Anker Galaxy S23 Power Management IC Chip PM8953\' (SKU: PART-IC-0077): Stock Quantity from \'29\' to \'28\'','127.0.0.1','2026-07-13 05:17:56','2026-07-13 05:17:56'),(6,4,'App\\Models\\Sale',6,'created','[]','created Sale Invoice #INV-20260713-ESUH with total 450.00 BDT','127.0.0.1','2026-07-13 05:20:24','2026-07-13 05:20:24'),(7,4,'App\\Models\\InventoryItem',77,'updated','{\"quantity\": {\"new\": 27, \"old\": 28}}','updated Inventory Item \'Anker Galaxy S23 Power Management IC Chip PM8953\' (SKU: PART-IC-0077): Stock Quantity from \'28\' to \'27\'','127.0.0.1','2026-07-13 05:20:24','2026-07-13 05:20:24'),(8,4,'App\\Models\\Sale',7,'created','[]','created Sale Invoice #INV-20260713-IRZW with total 5,300.00 BDT','127.0.0.1','2026-07-13 05:21:15','2026-07-13 05:21:15'),(9,4,'App\\Models\\InventoryItem',87,'updated','{\"quantity\": {\"new\": 15, \"old\": 16}}','updated Inventory Item \'Anker 9D Tempered Glass Screen Protector\' (SKU: ACCS-GLAS-0087): Stock Quantity from \'16\' to \'15\'','127.0.0.1','2026-07-13 05:21:15','2026-07-13 05:21:15'),(10,4,'App\\Models\\InventoryItem',77,'updated','{\"quantity\": {\"new\": 26, \"old\": 27}}','updated Inventory Item \'Anker Galaxy S23 Power Management IC Chip PM8953\' (SKU: PART-IC-0077): Stock Quantity from \'27\' to \'26\'','127.0.0.1','2026-07-13 05:21:15','2026-07-13 05:21:15'),(11,4,'App\\Models\\InventoryItem',37,'updated','{\"quantity\": {\"new\": 34, \"old\": 35}}','updated Inventory Item \'Anker iPhone 14 USB-C Charging Port Flex Ribbon\' (SKU: PART-CHAR-0037): Stock Quantity from \'35\' to \'34\'','127.0.0.1','2026-07-13 05:21:15','2026-07-13 05:21:15'),(12,4,'App\\Models\\InventoryItem',57,'updated','{\"quantity\": {\"new\": 31, \"old\": 32}}','updated Inventory Item \'Anker iPhone 15 Pro Max Replacement High Capacity Battery\' (SKU: PART-BATT-0057): Stock Quantity from \'32\' to \'31\'','127.0.0.1','2026-07-13 05:21:15','2026-07-13 05:21:15'),(13,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":false,\\\"repairs\\\":true,\\\"inventory\\\":false,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false}\", \"old\": null}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 05:27:13','2026-07-13 05:27:13'),(14,1,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":null,\\\"name\\\":\\\"dispalu\\\",\\\"buying_price\\\":\\\"1000\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": null}, \"commission_rate\": {\"new\": 10, \"old\": \"0.00\"}, \"commission_type\": {\"new\": \"percentage\", \"old\": null}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}, \"commission_amount\": {\"new\": 260, \"old\": \"0.00\"}}','updated Job Card (Ticket: M3-202607-0002): Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Type from \'\' to \'percentage\', Commission Rate from \'0.00\' to \'10\', Commission Amount from \'0.00 BDT\' to \'260.00 BDT\', Installed Spare Parts from \'\' to \'[{\"inventory_id\":null,\"name\":\"dispalu\",\"buying_price\":\"1000\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 05:40:08','2026-07-13 05:40:08'),(15,1,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":null,\\\"name\\\":\\\"dispalu\\\",\\\"buying_price\\\":\\\"1000\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":null,\\\"name\\\":\\\"sad\\\",\\\"buying_price\\\":\\\"200\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":null,\\\"name\\\":\\\"sda\\\",\\\"buying_price\\\":\\\"3000\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"dispalu\", \"quantity\": \"1\", \"buying_price\": \"1000\", \"inventory_id\": null}]}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}, \"commission_amount\": {\"new\": 0, \"old\": \"260.00\"}}','updated Job Card (Ticket: M3-202607-0002): Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Amount from \'260.00 BDT\' to \'0.00 BDT\', Installed Spare Parts from \'[{\"name\":\"dispalu\",\"quantity\":\"1\",\"buying_price\":\"1000\",\"inventory_id\":null}]\' to \'[{\"inventory_id\":null,\"name\":\"dispalu\",\"buying_price\":\"1000\",\"quantity\":\"1\"},{\"inventory_id\":null,\"name\":\"sad\",\"buying_price\":\"200\",\"quantity\":\"1\"},{\"inventory_id\":null,\"name\":\"sda\",\"buying_price\":\"3000\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 05:40:52','2026-07-13 05:40:52'),(16,4,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":null,\\\"name\\\":\\\"dispalu\\\",\\\"buying_price\\\":\\\"1000\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":null,\\\"name\\\":\\\"sad\\\",\\\"buying_price\\\":\\\"200\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":null,\\\"name\\\":\\\"sda\\\",\\\"buying_price\\\":\\\"3000\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"dispalu\", \"quantity\": \"1\", \"buying_price\": \"1000\", \"inventory_id\": null}, {\"name\": \"sad\", \"quantity\": \"1\", \"buying_price\": \"200\", \"inventory_id\": null}, {\"name\": \"sda\", \"quantity\": \"1\", \"buying_price\": \"3000\", \"inventory_id\": null}]}, \"estimated_cost\": {\"new\": \"500.00\", \"old\": \"3500.00\"}, \"commission_rate\": {\"new\": 5, \"old\": \"10.00\"}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}}','updated Job Card (Ticket: M3-202607-0002): Estimated Cost from \'3,500.00 BDT\' to \'500.00 BDT\', Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Rate from \'10.00\' to \'5\', Installed Spare Parts from \'[{\"name\":\"dispalu\",\"quantity\":\"1\",\"buying_price\":\"1000\",\"inventory_id\":null},{\"name\":\"sad\",\"quantity\":\"1\",\"buying_price\":\"200\",\"inventory_id\":null},{\"name\":\"sda\",\"quantity\":\"1\",\"buying_price\":\"3000\",\"inventory_id\":null}]\' to \'[{\"inventory_id\":null,\"name\":\"dispalu\",\"buying_price\":\"1000\",\"quantity\":\"1\"},{\"inventory_id\":null,\"name\":\"sad\",\"buying_price\":\"200\",\"quantity\":\"1\"},{\"inventory_id\":null,\"name\":\"sda\",\"buying_price\":\"3000\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 05:42:25','2026-07-13 05:42:25'),(17,1,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[]\", \"old\": [{\"name\": \"dispalu\", \"quantity\": \"1\", \"buying_price\": \"1000\", \"inventory_id\": null}, {\"name\": \"sad\", \"quantity\": \"1\", \"buying_price\": \"200\", \"inventory_id\": null}, {\"name\": \"sda\", \"quantity\": \"1\", \"buying_price\": \"3000\", \"inventory_id\": null}]}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}, \"commission_amount\": {\"new\": 180, \"old\": \"0.00\"}}','updated Job Card (Ticket: M3-202607-0002): Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Amount from \'0.00 BDT\' to \'180.00 BDT\', Installed Spare Parts from \'[{\"name\":\"dispalu\",\"quantity\":\"1\",\"buying_price\":\"1000\",\"inventory_id\":null},{\"name\":\"sad\",\"quantity\":\"1\",\"buying_price\":\"200\",\"inventory_id\":null},{\"name\":\"sda\",\"quantity\":\"1\",\"buying_price\":\"3000\",\"inventory_id\":null}]\' to \'[]\'','127.0.0.1','2026-07-13 05:47:15','2026-07-13 05:47:15'),(18,4,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":null,\\\"name\\\":\\\"dispalu\\\",\\\"buying_price\\\":\\\"200\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": []}, \"repair_charge\": {\"new\": 3400, \"old\": \"0.00\"}, \"estimated_cost\": {\"new\": 200, \"old\": \"500.00\"}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}, \"commission_amount\": {\"new\": 170, \"old\": \"180.00\"}}','updated Job Card (Ticket: M3-202607-0002): Repair Charge from \'0.00\' to \'3400\', Estimated Cost from \'500.00 BDT\' to \'200.00 BDT\', Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Amount from \'180.00 BDT\' to \'170.00 BDT\', Installed Spare Parts from \'[]\' to \'[{\"inventory_id\":null,\"name\":\"dispalu\",\"buying_price\":\"200\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 06:03:43','2026-07-13 06:03:43'),(19,1,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":null,\\\"name\\\":\\\"dispalu\\\",\\\"buying_price\\\":\\\"200\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"dispalu\", \"quantity\": \"1\", \"buying_price\": \"200\", \"inventory_id\": null}]}, \"commission_rate\": {\"new\": 40, \"old\": \"5.00\"}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}, \"commission_amount\": {\"new\": 1360, \"old\": \"170.00\"}}','updated Job Card (Ticket: M3-202607-0002): Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Rate from \'5.00\' to \'40\', Commission Amount from \'170.00 BDT\' to \'1,360.00 BDT\', Installed Spare Parts from \'[{\"name\":\"dispalu\",\"quantity\":\"1\",\"buying_price\":\"200\",\"inventory_id\":null}]\' to \'[{\"inventory_id\":null,\"name\":\"dispalu\",\"buying_price\":\"200\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 06:08:22','2026-07-13 06:08:22'),(20,1,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":null,\\\"name\\\":\\\"dispalu\\\",\\\"buying_price\\\":\\\"200\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"dispalu\", \"quantity\": \"1\", \"buying_price\": \"200\", \"inventory_id\": null}]}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}}','updated Job Card (Ticket: M3-202607-0002): Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Installed Spare Parts from \'[{\"name\":\"dispalu\",\"quantity\":\"1\",\"buying_price\":\"200\",\"inventory_id\":null}]\' to \'[{\"inventory_id\":null,\"name\":\"dispalu\",\"buying_price\":\"200\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 06:08:58','2026-07-13 06:08:58'),(21,5,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":\\\"61\\\",\\\"name\\\":\\\"Apple Super Fast Charging Cable\\\",\\\"buying_price\\\":\\\"300.00\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"dispalu\", \"quantity\": \"1\", \"buying_price\": \"200\", \"inventory_id\": null}]}, \"repair_charge\": {\"new\": 2800, \"old\": \"3400.00\"}, \"commission_rate\": {\"new\": 0, \"old\": \"40.00\"}, \"commission_type\": {\"new\": null, \"old\": \"percentage\"}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}, \"commission_amount\": {\"new\": 0, \"old\": \"1360.00\"}}','updated Job Card (Ticket: M3-202607-0002): Repair Charge from \'3400.00\' to \'2800\', Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Commission Type from \'percentage\' to \'\', Commission Rate from \'40.00\' to \'0\', Commission Amount from \'1,360.00 BDT\' to \'0.00 BDT\', Installed Spare Parts from \'[{\"name\":\"dispalu\",\"quantity\":\"1\",\"buying_price\":\"200\",\"inventory_id\":null}]\' to \'[{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"1\"},{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"1\"},{\"inventory_id\":\"61\",\"name\":\"Apple Super Fast Charging Cable\",\"buying_price\":\"300.00\",\"quantity\":\"1\"}]\'','127.0.0.1','2026-07-13 06:14:00','2026-07-13 06:14:00'),(22,5,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":\\\"61\\\",\\\"name\\\":\\\"Apple Super Fast Charging Cable\\\",\\\"buying_price\\\":\\\"300.00\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"1\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"1\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Super Fast Charging Cable\", \"quantity\": \"1\", \"buying_price\": \"300.00\", \"inventory_id\": \"61\"}]}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}}','updated Job Card (Ticket: M3-202607-0002): Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Installed Spare Parts from \'[{\"name\":\"Apple Premium Silicone Protective Case\",\"quantity\":\"1\",\"buying_price\":\"250.00\",\"inventory_id\":\"31\"},{\"name\":\"Apple Premium Silicone Protective Case\",\"quantity\":\"1\",\"buying_price\":\"250.00\",\"inventory_id\":\"31\"},{\"name\":\"Apple Super Fast Charging Cable\",\"quantity\":\"1\",\"buying_price\":\"300.00\",\"inventory_id\":\"61\"}]\' to \'[{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"1\"},{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"1\"},{\"inventory_id\":\"61\",\"name\":\"Apple Super Fast Charging Cable\",\"buying_price\":\"300.0...','127.0.0.1','2026-07-13 06:14:34','2026-07-13 06:14:34'),(23,1,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"3\\\"},{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":\\\"61\\\",\\\"name\\\":\\\"Apple Super Fast Charging Cable\\\",\\\"buying_price\\\":\\\"300.00\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"1\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"1\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Super Fast Charging Cable\", \"quantity\": \"1\", \"buying_price\": \"300.00\", \"inventory_id\": \"61\"}]}, \"estimated_cost\": {\"new\": 4100, \"old\": \"200.00\"}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}}','updated Job Card (Ticket: M3-202607-0002): Estimated Cost from \'200.00 BDT\' to \'4,100.00 BDT\', Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Installed Spare Parts from \'[{\"name\":\"Apple Premium Silicone Protective Case\",\"quantity\":\"1\",\"buying_price\":\"250.00\",\"inventory_id\":\"31\"},{\"name\":\"Apple Premium Silicone Protective Case\",\"quantity\":\"1\",\"buying_price\":\"250.00\",\"inventory_id\":\"31\"},{\"name\":\"Apple Super Fast Charging Cable\",\"quantity\":\"1\",\"buying_price\":\"300.00\",\"inventory_id\":\"61\"}]\' to \'[{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"3\"},{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"1\"},{\"inventory_id\":\"61\",\"name\":\"Ap...','127.0.0.1','2026-07-13 06:19:24','2026-07-13 06:19:24'),(24,5,'App\\Models\\Repair',2,'updated','{\"used_parts\": {\"new\": \"[{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"3\\\"},{\\\"inventory_id\\\":\\\"31\\\",\\\"name\\\":\\\"Apple Premium Silicone Protective Case\\\",\\\"buying_price\\\":\\\"250.00\\\",\\\"quantity\\\":\\\"1\\\"},{\\\"inventory_id\\\":\\\"61\\\",\\\"name\\\":\\\"Apple Super Fast Charging Cable\\\",\\\"buying_price\\\":\\\"300.03\\\",\\\"quantity\\\":\\\"1\\\"}]\", \"old\": [{\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"3\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"1\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Super Fast Charging Cable\", \"quantity\": \"1\", \"buying_price\": \"300.00\", \"inventory_id\": \"61\"}]}, \"estimated_cost\": {\"new\": 4100.03, \"old\": \"4100.00\"}, \"device_checklist\": {\"new\": \"{\\\"scratches\\\":\\\"yes\\\",\\\"display_ok\\\":\\\"yes\\\",\\\"touch_ok\\\":\\\"yes\\\",\\\"camera_ok\\\":\\\"yes\\\",\\\"audio_ok\\\":\\\"yes\\\",\\\"buttons_ok\\\":\\\"yes\\\"}\", \"old\": {\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}}}','updated Job Card (Ticket: M3-202607-0002): Estimated Cost from \'4,100.00 BDT\' to \'4,100.03 BDT\', Device Checklist from \'{\"audio_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"scratches\":\"yes\",\"buttons_ok\":\"yes\",\"display_ok\":\"yes\"}\' to \'{\"scratches\":\"yes\",\"display_ok\":\"yes\",\"touch_ok\":\"yes\",\"camera_ok\":\"yes\",\"audio_ok\":\"yes\",\"buttons_ok\":\"yes\"}\', Installed Spare Parts from \'[{\"name\":\"Apple Premium Silicone Protective Case\",\"quantity\":\"3\",\"buying_price\":\"250.00\",\"inventory_id\":\"31\"},{\"name\":\"Apple Premium Silicone Protective Case\",\"quantity\":\"1\",\"buying_price\":\"250.00\",\"inventory_id\":\"31\"},{\"name\":\"Apple Super Fast Charging Cable\",\"quantity\":\"1\",\"buying_price\":\"300.00\",\"inventory_id\":\"61\"}]\' to \'[{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"3\"},{\"inventory_id\":\"31\",\"name\":\"Apple Premium Silicone Protective Case\",\"buying_price\":\"250.00\",\"quantity\":\"1\"},{\"inventory_id\":\"61\",\"name\":\"...','127.0.0.1','2026-07-13 06:48:50','2026-07-13 06:48:50'),(25,1,'App\\Models\\Expense',6,'created','[]','created Expense of category \'Other\' with amount 50.00 BDT','127.0.0.1','2026-07-13 06:54:33','2026-07-13 06:54:33'),(26,1,'App\\Models\\InventoryItem',37,'updated','{\"quantity\": {\"new\": 33, \"old\": 34}}','updated Inventory Item \'Anker iPhone 14 USB-C Charging Port Flex Ribbon\' (SKU: PART-CHAR-0037): Stock Quantity from \'34\' to \'33\'','127.0.0.1','2026-07-13 06:55:01','2026-07-13 06:55:01'),(27,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":true,\\\"repairs\\\":true,\\\"inventory\\\":true,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false}\", \"old\": {\"pos\": false, \"repairs\": true, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:00:54','2026-07-13 07:00:54'),(28,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":true,\\\"repairs\\\":false,\\\"inventory\\\":false,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false}\", \"old\": {\"pos\": true, \"repairs\": true, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": true, \"purchases\": false, \"social_media\": false}}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:01:19','2026-07-13 07:01:19'),(29,1,'App\\Models\\Expense',7,'created','[]','created Expense of category \'Cash Outflow\' with amount 500.00 BDT','127.0.0.1','2026-07-13 07:01:48','2026-07-13 07:01:48'),(30,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":true,\\\"repairs\\\":false,\\\"inventory\\\":false,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false}\", \"old\": {\"pos\": true, \"repairs\": false, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:03:50','2026-07-13 07:03:50'),(31,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":true,\\\"repairs\\\":false,\\\"inventory\\\":false,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false}\", \"old\": {\"pos\": true, \"repairs\": false, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:04:06','2026-07-13 07:04:06'),(32,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":true,\\\"repairs\\\":true,\\\"inventory\\\":false,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false}\", \"old\": {\"pos\": true, \"repairs\": false, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:04:27','2026-07-13 07:04:27'),(33,1,'App\\Models\\User',5,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":false,\\\"repairs\\\":false,\\\"inventory\\\":true,\\\"purchases\\\":false,\\\"expenses\\\":true,\\\"reports\\\":true,\\\"settings\\\":false,\\\"social_media\\\":false,\\\"cash\\\":true}\", \"old\": null}}','updated User account \'Manager Admin\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:05:36','2026-07-13 07:05:36'),(34,1,'App\\Models\\User',4,'updated','{\"permissions\": {\"new\": \"{\\\"pos\\\":true,\\\"repairs\\\":true,\\\"inventory\\\":false,\\\"purchases\\\":false,\\\"expenses\\\":false,\\\"reports\\\":false,\\\"settings\\\":false,\\\"social_media\\\":false,\\\"cash\\\":true}\", \"old\": {\"pos\": true, \"repairs\": true, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}}}','updated User account \'Kamal Salesman\': Permissions from \'None\' to \'None\'','127.0.0.1','2026-07-13 07:06:17','2026-07-13 07:06:17'),(35,4,'App\\Models\\Expense',8,'created','[]','created Expense of category \'Cash Outflow\' with amount 500.00 BDT','127.0.0.1','2026-07-13 07:07:00','2026-07-13 07:07:00');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Display','display','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(2,'Battery','battery','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(3,'Charging Port','charging-port','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(4,'Back Glass','back-glass','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(5,'IC','ic','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(6,'Charger','charger','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(7,'Cable','cable','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(8,'Earphone','earphone','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(9,'Power Bank','power-bank','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(10,'Cover','cover','active','2026-07-13 04:48:39','2026-07-13 04:48:39'),(11,'Glass Protector','glass-protector','active','2026-07-13 04:48:39','2026-07-13 04:48:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Rahim Ali','01711223344','01811223344','rahim@gmail.com','12/A, Dhanmondi','Dhaka','2026-07-13 04:48:39','2026-07-13 04:48:39'),(2,'Karim Ahmed','01922334455',NULL,'karim@yahoo.com','Mirpur 10, Block C','Dhaka','2026-07-13 04:48:39','2026-07-13 04:48:39'),(3,'Sultana Begum','01633445566',NULL,NULL,'Oxygen, Bayezid Bostami','Chittagong','2026-07-13 04:48:39','2026-07-13 04:48:39'),(4,'Tanvir Rahman','01544556677',NULL,NULL,'Zindabazar','Sylhet','2026-07-13 04:48:39','2026-07-13 04:48:39');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `expense_date` date NOT NULL,
  `register_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,'Rent',15000.00,'Multiplan Center Shop Rent for June 2026','2026-07-06',NULL,'2026-07-06 04:48:39','2026-07-06 04:48:39'),(2,'Salary',12000.00,'Salary advance to Abir Tech','2026-07-08',NULL,'2026-07-08 04:48:39','2026-07-08 04:48:39'),(3,'Utility',2300.00,'Electricity bill Shop 14','2026-07-09',NULL,'2026-07-09 04:48:39','2026-07-09 04:48:39'),(4,'Purchase',12500.00,'Purchased Display & Battery stock - PUR-202607-0001','2026-07-03',NULL,'2026-07-03 04:48:39','2026-07-03 04:48:39'),(5,'Rent',3600.00,'shop rent of juny','2026-07-13',NULL,'2026-07-13 05:10:56','2026-07-13 05:11:12'),(6,'Other',50.00,'tea','2026-07-13',NULL,'2026-07-13 06:54:33','2026-07-13 06:54:33'),(7,'Cash Outflow',500.00,'cash','2026-07-13',NULL,'2026-07-13 07:01:48','2026-07-13 07:01:48'),(8,'Cash Outflow',500.00,'currentbil','2026-07-13','pos','2026-07-13 07:07:00','2026-07-13 07:07:00');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_items`
--

DROP TABLE IF EXISTS `inventory_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `alert_quantity` int NOT NULL DEFAULT '5',
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `sub_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'single',
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  `warranties` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `variants` text COLLATE utf8mb4_unicode_ci,
  `discount_value` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventory_items_sku_unique` (`sku`),
  KEY `inventory_items_barcode_index` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
INSERT INTO `inventory_items` VALUES (1,'Apple iPhone 13 OLED Screen Display Assembly','PART-DISP-0001','69402681001','spare_part','Display',39,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 05:07:48',1,1,NULL,'Apples',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-DISP-0001-OR\",\"quantity\":\"20\",\"price\":\"12000\"},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-DISP-0001-OE\",\"quantity\":\"5\",\"price\":\"7500\"},{\"variation\":\"Quality\",\"value\":\"Copy\",\"sku\":\"PART-DISP-0001-CO\",\"quantity\":\"14\",\"price\":\"4500\"}]',0.00),(2,'Samsung iPhone 13 Pro Replacement High Capacity Battery','PART-BATT-0002','69402681002','spare_part','Battery',26,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(3,'Google iPhone 14 Back Glass Housing Cover Panel','PART-BACK-0003','69402681003','spare_part','Back Glass',47,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,NULL,0.00),(4,'Xiaomi iPhone 14 Pro Max USB-C Charging Port Flex Ribbon','PART-CHAR-0004','69402681004','spare_part','Charging Port',44,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Xiaomi',NULL,'variable',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-CHAR-0004-OR\",\"quantity\":21,\"price\":1800},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-CHAR-0004-OE\",\"quantity\":23,\"price\":1000}]',0.00),(5,'OnePlus PD Fast Charging Wall Adapter','ACCS-CHAR-0005','69402681005','accessory','Charger',19,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,NULL,0.00),(6,'Realme Super Fast Charging Cable','ACCS-CABL-0006','69402681006','accessory','Cable',16,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,NULL,0.00),(7,'Anker TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0007','69402681007','accessory','Earphone',25,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Anker',NULL,'variable',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"White\",\"sku\":\"ACCS-EARP-0007-WH\",\"quantity\":13,\"price\":2450},{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-EARP-0007-BL\",\"quantity\":12,\"price\":2450}]',0.00),(8,'Baseus Fast Charging Power Bank','ACCS-POWE-0008','69402681008','accessory','Power Bank',36,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(9,'Joyroom Premium Silicone Protective Case','ACCS-COVE-0009','69402681009','accessory','Cover',38,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(10,'Remax 9D Tempered Glass Screen Protector','ACCS-GLAS-0010','69402681010','accessory','Glass Protector',20,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Remax',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Pack Size\",\"value\":\"Single Pack\",\"sku\":\"ACCS-GLAS-0010-SI\",\"quantity\":11,\"price\":250},{\"variation\":\"Pack Size\",\"value\":\"Double Pack\",\"sku\":\"ACCS-GLAS-0010-DO\",\"quantity\":9,\"price\":450}]',0.00),(11,'Apple Galaxy S24 Power Management IC Chip PM8953','PART-IC-0011','69402681011','spare_part','IC',30,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Apple',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(12,'Samsung Pixel 6 Pro OLED Screen Display Assembly','PART-DISP-0012','69402681012','spare_part','Display',16,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(13,'Google Pixel 7 Pro Replacement High Capacity Battery','PART-BATT-0013','69402681013','spare_part','Battery',36,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Google',NULL,'variable',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-BATT-0013-OR\",\"quantity\":6,\"price\":2800},{\"variation\":\"Quality\",\"value\":\"Premium Copy\",\"sku\":\"PART-BATT-0013-PR\",\"quantity\":30,\"price\":1500}]',0.00),(14,'Xiaomi Pixel 8 Pro Back Glass Housing Cover Panel','PART-BACK-0014','69402681014','spare_part','Back Glass',12,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Xiaomi',NULL,'single',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,NULL,0.00),(15,'OnePlus Redmi Note 11 USB-C Charging Port Flex Ribbon','PART-CHAR-0015','69402681015','spare_part','Charging Port',29,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,NULL,0.00),(16,'Realme PD Fast Charging Wall Adapter','ACCS-CHAR-0016','69402681016','accessory','Charger',29,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Realme',NULL,'variable',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"White\",\"sku\":\"ACCS-CHAR-0016-WH\",\"quantity\":24,\"price\":1850},{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-CHAR-0016-BL\",\"quantity\":5,\"price\":1850}]',0.00),(17,'Anker Super Fast Charging Cable','ACCS-CABL-0017','69402681017','accessory','Cable',25,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Anker',NULL,'single',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,NULL,0.00),(18,'Baseus TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0018','69402681018','accessory','Earphone',37,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,NULL,0.00),(19,'Joyroom Fast Charging Power Bank','ACCS-POWE-0019','69402681019','accessory','Power Bank',48,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Joyroom',NULL,'variable',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Capacity\",\"value\":\"10000mAh\",\"sku\":\"ACCS-POWE-0019-10\",\"quantity\":18,\"price\":1250},{\"variation\":\"Capacity\",\"value\":\"20000mAh\",\"sku\":\"ACCS-POWE-0019-20\",\"quantity\":30,\"price\":1950}]',0.00),(20,'Remax Premium Silicone Protective Case','ACCS-COVE-0020','69402681020','accessory','Cover',34,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Remax',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(21,'Apple 9D Tempered Glass Screen Protector','ACCS-GLAS-0021','69402681021','accessory','Glass Protector',42,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Apple',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(22,'Samsung iPhone 15 Power Management IC Chip PM8953','PART-IC-0022','69402681022','spare_part','IC',47,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Samsung',NULL,'variable',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-IC-0022-OR\",\"quantity\":25,\"price\":450},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-IC-0022-OE\",\"quantity\":22,\"price\":300}]',0.00),(23,'Google iPhone 15 Pro Max OLED Screen Display Assembly','PART-DISP-0023','69402681023','spare_part','Display',16,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(24,'Xiaomi Galaxy S22 Replacement High Capacity Battery','PART-BATT-0024','69402681024','spare_part','Battery',37,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Xiaomi',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(25,'OnePlus Galaxy S22 Ultra Back Glass Housing Cover Panel','PART-BACK-0025','69402681025','spare_part','Back Glass',52,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'OnePlus',NULL,'variable',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"Titanium Gray\",\"sku\":\"PART-BACK-0025-TI\",\"quantity\":20,\"price\":4500},{\"variation\":\"Color\",\"value\":\"Titanium Black\",\"sku\":\"PART-BACK-0025-TI\",\"quantity\":26,\"price\":4500},{\"variation\":\"Color\",\"value\":\"Titanium Silver\",\"sku\":\"PART-BACK-0025-TI\",\"quantity\":6,\"price\":4500}]',0.00),(26,'Realme Galaxy S23 USB-C Charging Port Flex Ribbon','PART-CHAR-0026','69402681026','spare_part','Charging Port',24,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,NULL,0.00),(27,'Anker PD Fast Charging Wall Adapter','ACCS-CHAR-0027','69402681027','accessory','Charger',33,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Anker',NULL,'single',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,NULL,0.00),(28,'Baseus Super Fast Charging Cable','ACCS-CABL-0028','69402681028','accessory','Cable',39,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Baseus',NULL,'variable',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Length\",\"value\":\"1 Meter\",\"sku\":\"ACCS-CABL-0028-1M\",\"quantity\":18,\"price\":500},{\"variation\":\"Length\",\"value\":\"2 Meter\",\"sku\":\"ACCS-CABL-0028-2M\",\"quantity\":21,\"price\":650}]',0.00),(29,'Joyroom TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0029','69402681029','accessory','Earphone',15,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,NULL,0.00),(30,'Remax Fast Charging Power Bank','ACCS-POWE-0030','69402681030','accessory','Power Bank',24,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Remax',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(31,'Apple Premium Silicone Protective Case','ACCS-COVE-0031','69402681031','accessory','Cover',37,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Apple',NULL,'variable',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"Midnight Black\",\"sku\":\"ACCS-COVE-0031-MI\",\"quantity\":24,\"price\":450},{\"variation\":\"Color\",\"value\":\"Navy Blue\",\"sku\":\"ACCS-COVE-0031-NA\",\"quantity\":8,\"price\":450},{\"variation\":\"Color\",\"value\":\"Forest Green\",\"sku\":\"ACCS-COVE-0031-FO\",\"quantity\":5,\"price\":450}]',0.00),(32,'Samsung 9D Tempered Glass Screen Protector','ACCS-GLAS-0032','69402681032','accessory','Glass Protector',42,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(33,'Google Redmi Note 12 Pro Power Management IC Chip PM8953','PART-IC-0033','69402681033','spare_part','IC',32,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(34,'Xiaomi Realme GT 3 OLED Screen Display Assembly','PART-DISP-0034','69402681034','spare_part','Display',49,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Xiaomi',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-DISP-0034-OR\",\"quantity\":13,\"price\":12000},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-DISP-0034-OE\",\"quantity\":28,\"price\":7500},{\"variation\":\"Quality\",\"value\":\"Copy\",\"sku\":\"PART-DISP-0034-CO\",\"quantity\":8,\"price\":4500}]',0.00),(35,'OnePlus iPhone 13 Replacement High Capacity Battery','PART-BATT-0035','69402681035','spare_part','Battery',41,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(36,'Realme iPhone 13 Pro Back Glass Housing Cover Panel','PART-BACK-0036','69402681036','spare_part','Back Glass',36,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,NULL,0.00),(37,'Anker iPhone 14 USB-C Charging Port Flex Ribbon','PART-CHAR-0037','69402681037','spare_part','Charging Port',33,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 06:55:01',1,3,NULL,'Anker',NULL,'variable',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-CHAR-0037-OR\",\"quantity\":14,\"price\":1800},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-CHAR-0037-OE\",\"quantity\":21,\"price\":1000}]',0.00),(38,'Baseus PD Fast Charging Wall Adapter','ACCS-CHAR-0038','69402681038','accessory','Charger',48,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,NULL,0.00),(39,'Joyroom Super Fast Charging Cable','ACCS-CABL-0039','69402681039','accessory','Cable',12,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,NULL,0.00),(40,'Remax TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0040','69402681040','accessory','Earphone',37,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Remax',NULL,'variable',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"White\",\"sku\":\"ACCS-EARP-0040-WH\",\"quantity\":15,\"price\":2450},{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-EARP-0040-BL\",\"quantity\":22,\"price\":2450}]',0.00),(41,'Apple Fast Charging Power Bank','ACCS-POWE-0041','69402681041','accessory','Power Bank',38,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Apple',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(42,'Samsung Premium Silicone Protective Case','ACCS-COVE-0042','69402681042','accessory','Cover',23,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(43,'Google 9D Tempered Glass Screen Protector','ACCS-GLAS-0043','69402681043','accessory','Glass Protector',38,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Google',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Pack Size\",\"value\":\"Single Pack\",\"sku\":\"ACCS-GLAS-0043-SI\",\"quantity\":14,\"price\":250},{\"variation\":\"Pack Size\",\"value\":\"Double Pack\",\"sku\":\"ACCS-GLAS-0043-DO\",\"quantity\":24,\"price\":450}]',0.00),(44,'Xiaomi Galaxy S23 Ultra Power Management IC Chip PM8953','PART-IC-0044','69402681044','spare_part','IC',14,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Xiaomi',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(45,'OnePlus Galaxy S24 OLED Screen Display Assembly','PART-DISP-0045','69402681045','spare_part','Display',33,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(46,'Realme Pixel 6 Pro Replacement High Capacity Battery','PART-BATT-0046','69402681046','spare_part','Battery',43,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Realme',NULL,'variable',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-BATT-0046-OR\",\"quantity\":18,\"price\":2800},{\"variation\":\"Quality\",\"value\":\"Premium Copy\",\"sku\":\"PART-BATT-0046-PR\",\"quantity\":25,\"price\":1500}]',0.00),(47,'Anker Pixel 7 Pro Back Glass Housing Cover Panel','PART-BACK-0047','69402681047','spare_part','Back Glass',18,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:50:28',1,4,NULL,'Anker',NULL,'single',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,NULL,0.00),(48,'Baseus Pixel 8 Pro USB-C Charging Port Flex Ribbon','PART-CHAR-0048','69402681048','spare_part','Charging Port',27,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,NULL,0.00),(49,'Joyroom PD Fast Charging Wall Adapter','ACCS-CHAR-0049','69402681049','accessory','Charger',34,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Joyroom',NULL,'variable',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"White\",\"sku\":\"ACCS-CHAR-0049-WH\",\"quantity\":10,\"price\":1850},{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-CHAR-0049-BL\",\"quantity\":24,\"price\":1850}]',0.00),(50,'Remax Super Fast Charging Cable','ACCS-CABL-0050','69402681050','accessory','Cable',22,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Remax',NULL,'single',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,NULL,0.00),(51,'Apple TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0051','69402681051','accessory','Earphone',48,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Apple',NULL,'single',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,NULL,0.00),(52,'Samsung Fast Charging Power Bank','ACCS-POWE-0052','69402681052','accessory','Power Bank',26,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Samsung',NULL,'variable',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Capacity\",\"value\":\"10000mAh\",\"sku\":\"ACCS-POWE-0052-10\",\"quantity\":12,\"price\":1250},{\"variation\":\"Capacity\",\"value\":\"20000mAh\",\"sku\":\"ACCS-POWE-0052-20\",\"quantity\":14,\"price\":1950}]',0.00),(53,'Google Premium Silicone Protective Case','ACCS-COVE-0053','69402681053','accessory','Cover',25,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(54,'Xiaomi 9D Tempered Glass Screen Protector','ACCS-GLAS-0054','69402681054','accessory','Glass Protector',36,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Xiaomi',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(55,'OnePlus iPhone 14 Pro Max Power Management IC Chip PM8953','PART-IC-0055','69402681055','spare_part','IC',42,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'OnePlus',NULL,'variable',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-IC-0055-OR\",\"quantity\":17,\"price\":450},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-IC-0055-OE\",\"quantity\":25,\"price\":300}]',0.00),(56,'Realme iPhone 15 OLED Screen Display Assembly','PART-DISP-0056','69402681056','spare_part','Display',13,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(57,'Anker iPhone 15 Pro Max Replacement High Capacity Battery','PART-BATT-0057','69402681057','spare_part','Battery',31,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 05:21:15',1,2,NULL,'Anker',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(58,'Baseus Galaxy S22 Back Glass Housing Cover Panel','PART-BACK-0058','69402681058','spare_part','Back Glass',53,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Baseus',NULL,'variable',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"Titanium Gray\",\"sku\":\"PART-BACK-0058-TI\",\"quantity\":14,\"price\":4500},{\"variation\":\"Color\",\"value\":\"Titanium Black\",\"sku\":\"PART-BACK-0058-TI\",\"quantity\":30,\"price\":4500},{\"variation\":\"Color\",\"value\":\"Titanium Silver\",\"sku\":\"PART-BACK-0058-TI\",\"quantity\":9,\"price\":4500}]',0.00),(59,'Joyroom Galaxy S22 Ultra USB-C Charging Port Flex Ribbon','PART-CHAR-0059','69402681059','spare_part','Charging Port',39,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,NULL,0.00),(60,'Remax PD Fast Charging Wall Adapter','ACCS-CHAR-0060','69402681060','accessory','Charger',12,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Remax',NULL,'single',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,NULL,0.00),(61,'Apple Super Fast Charging Cable','ACCS-CABL-0061','69402681061','accessory','Cable',12,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Apple',NULL,'variable',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Length\",\"value\":\"1 Meter\",\"sku\":\"ACCS-CABL-0061-1M\",\"quantity\":7,\"price\":500},{\"variation\":\"Length\",\"value\":\"2 Meter\",\"sku\":\"ACCS-CABL-0061-2M\",\"quantity\":5,\"price\":650}]',0.00),(62,'Samsung TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0062','69402681062','accessory','Earphone',28,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,NULL,0.00),(63,'Google Fast Charging Power Bank','ACCS-POWE-0063','69402681063','accessory','Power Bank',25,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(64,'Xiaomi Premium Silicone Protective Case','ACCS-COVE-0064','69402681064','accessory','Cover',67,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Xiaomi',NULL,'variable',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"Midnight Black\",\"sku\":\"ACCS-COVE-0064-MI\",\"quantity\":25,\"price\":450},{\"variation\":\"Color\",\"value\":\"Navy Blue\",\"sku\":\"ACCS-COVE-0064-NA\",\"quantity\":27,\"price\":450},{\"variation\":\"Color\",\"value\":\"Forest Green\",\"sku\":\"ACCS-COVE-0064-FO\",\"quantity\":15,\"price\":450}]',0.00),(65,'OnePlus 9D Tempered Glass Screen Protector','ACCS-GLAS-0065','69402681065','accessory','Glass Protector',13,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(66,'Realme Redmi Note 11 Power Management IC Chip PM8953','PART-IC-0066','69402681066','spare_part','IC',42,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(67,'Anker Redmi Note 12 Pro OLED Screen Display Assembly','PART-DISP-0067','69402681067','spare_part','Display',57,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Anker',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-DISP-0067-OR\",\"quantity\":21,\"price\":12000},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-DISP-0067-OE\",\"quantity\":13,\"price\":7500},{\"variation\":\"Quality\",\"value\":\"Copy\",\"sku\":\"PART-DISP-0067-CO\",\"quantity\":23,\"price\":4500}]',0.00),(68,'Baseus Realme GT 3 Replacement High Capacity Battery','PART-BATT-0068','69402681068','spare_part','Battery',27,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(69,'Joyroom iPhone 13 Back Glass Housing Cover Panel','PART-BACK-0069','69402681069','spare_part','Back Glass',13,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,NULL,0.00),(70,'Remax iPhone 13 Pro USB-C Charging Port Flex Ribbon','PART-CHAR-0070','69402681070','spare_part','Charging Port',20,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Remax',NULL,'variable',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-CHAR-0070-OR\",\"quantity\":8,\"price\":1800},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-CHAR-0070-OE\",\"quantity\":12,\"price\":1000}]',0.00),(71,'Apple PD Fast Charging Wall Adapter','ACCS-CHAR-0071','69402681071','accessory','Charger',49,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Apple',NULL,'single',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,NULL,0.00),(72,'Samsung Super Fast Charging Cable','ACCS-CABL-0072','69402681072','accessory','Cable',39,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,NULL,0.00),(73,'Google TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0073','69402681073','accessory','Earphone',27,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Google',NULL,'variable',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"White\",\"sku\":\"ACCS-EARP-0073-WH\",\"quantity\":9,\"price\":2450},{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-EARP-0073-BL\",\"quantity\":18,\"price\":2450}]',0.00),(74,'Xiaomi Fast Charging Power Bank','ACCS-POWE-0074','69402681074','accessory','Power Bank',37,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Xiaomi',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(75,'OnePlus Premium Silicone Protective Case','ACCS-COVE-0075','69402681075','accessory','Cover',30,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(76,'Realme 9D Tempered Glass Screen Protector','ACCS-GLAS-0076','69402681076','accessory','Glass Protector',17,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Realme',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Pack Size\",\"value\":\"Single Pack\",\"sku\":\"ACCS-GLAS-0076-SI\",\"quantity\":8,\"price\":250},{\"variation\":\"Pack Size\",\"value\":\"Double Pack\",\"sku\":\"ACCS-GLAS-0076-DO\",\"quantity\":9,\"price\":450}]',0.00),(77,'Anker Galaxy S23 Power Management IC Chip PM8953','PART-IC-0077','69402681077','spare_part','IC',26,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 05:21:15',1,5,NULL,'Anker',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(78,'Baseus Galaxy S23 Ultra OLED Screen Display Assembly','PART-DISP-0078','69402681078','spare_part','Display',17,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(79,'Joyroom Galaxy S24 Replacement High Capacity Battery','PART-BATT-0079','69402681079','spare_part','Battery',34,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Joyroom',NULL,'variable',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-BATT-0079-OR\",\"quantity\":21,\"price\":2800},{\"variation\":\"Quality\",\"value\":\"Premium Copy\",\"sku\":\"PART-BATT-0079-PR\",\"quantity\":13,\"price\":1500}]',0.00),(80,'Remax Pixel 6 Pro Back Glass Housing Cover Panel','PART-BACK-0080','69402681080','spare_part','Back Glass',25,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Remax',NULL,'single',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,NULL,0.00),(81,'Apple Pixel 7 Pro USB-C Charging Port Flex Ribbon','PART-CHAR-0081','69402681081','spare_part','Charging Port',49,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Apple',NULL,'single',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,NULL,0.00),(82,'Samsung PD Fast Charging Wall Adapter','ACCS-CHAR-0082','69402681082','accessory','Charger',17,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Samsung',NULL,'variable',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"White\",\"sku\":\"ACCS-CHAR-0082-WH\",\"quantity\":5,\"price\":1850},{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-CHAR-0082-BL\",\"quantity\":12,\"price\":1850}]',0.00),(83,'Google Super Fast Charging Cable','ACCS-CABL-0083','69402681083','accessory','Cable',33,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,NULL,0.00),(84,'Xiaomi TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0084','69402681084','accessory','Earphone',29,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'Xiaomi',NULL,'single',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,NULL,0.00),(85,'OnePlus Fast Charging Power Bank','ACCS-POWE-0085','69402681085','accessory','Power Bank',39,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'OnePlus',NULL,'variable',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Capacity\",\"value\":\"10000mAh\",\"sku\":\"ACCS-POWE-0085-10\",\"quantity\":25,\"price\":1250},{\"variation\":\"Capacity\",\"value\":\"20000mAh\",\"sku\":\"ACCS-POWE-0085-20\",\"quantity\":14,\"price\":1950}]',0.00),(86,'Realme Premium Silicone Protective Case','ACCS-COVE-0086','69402681086','accessory','Cover',22,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(87,'Anker 9D Tempered Glass Screen Protector','ACCS-GLAS-0087','69402681087','accessory','Glass Protector',15,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 05:21:15',2,11,NULL,'Anker',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(88,'Baseus iPhone 14 Power Management IC Chip PM8953','PART-IC-0088','69402681088','spare_part','IC',35,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Baseus',NULL,'variable',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-IC-0088-OR\",\"quantity\":27,\"price\":450},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-IC-0088-OE\",\"quantity\":8,\"price\":300}]',0.00),(89,'Joyroom iPhone 14 Pro Max OLED Screen Display Assembly','PART-DISP-0089','69402681089','spare_part','Display',33,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(90,'Remax iPhone 15 Replacement High Capacity Battery','PART-BATT-0090','69402681090','spare_part','Battery',12,5,1800.00,2800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,2,NULL,'Remax',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(91,'Apple iPhone 15 Pro Max Back Glass Housing Cover Panel','PART-BACK-0091','69402681091','spare_part','Back Glass',57,5,3000.00,4500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,4,NULL,'Apple',NULL,'variable',NULL,'[\"inventory\\/iphone15pm_back_glass.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"Titanium Gray\",\"sku\":\"PART-BACK-0091-TI\",\"quantity\":19,\"price\":4500},{\"variation\":\"Color\",\"value\":\"Titanium Black\",\"sku\":\"PART-BACK-0091-TI\",\"quantity\":16,\"price\":4500},{\"variation\":\"Color\",\"value\":\"Titanium Silver\",\"sku\":\"PART-BACK-0091-TI\",\"quantity\":22,\"price\":4500}]',0.00),(92,'Samsung Galaxy S22 USB-C Charging Port Flex Ribbon','PART-CHAR-0092','69402681092','spare_part','Charging Port',26,5,1100.00,1800.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,3,NULL,'Samsung',NULL,'single',NULL,'[\"inventory\\/ipad_pro_charging_port.png\"]',NULL,NULL,NULL,NULL,0.00),(93,'Google PD Fast Charging Wall Adapter','ACCS-CHAR-0093','69402681093','accessory','Charger',12,5,1200.00,1850.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,6,NULL,'Google',NULL,'single',NULL,'[\"inventory\\/anker_nano_charger.png\"]',NULL,NULL,NULL,NULL,0.00),(94,'Xiaomi Super Fast Charging Cable','ACCS-CABL-0094','69402681094','accessory','Cable',22,5,300.00,500.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,7,NULL,'Xiaomi',NULL,'variable',NULL,'[\"inventory\\/baseus_typec_cable.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Length\",\"value\":\"1 Meter\",\"sku\":\"ACCS-CABL-0094-1M\",\"quantity\":15,\"price\":500},{\"variation\":\"Length\",\"value\":\"2 Meter\",\"sku\":\"ACCS-CABL-0094-2M\",\"quantity\":7,\"price\":650}]',0.00),(95,'OnePlus TWS Bluetooth ANC Wireless Earbuds','ACCS-EARP-0095','69402681095','accessory','Earphone',49,5,1600.00,2450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,8,NULL,'OnePlus',NULL,'single',NULL,'[\"inventory\\/joyroom_t03s_earbuds.png\"]',NULL,NULL,NULL,NULL,0.00),(96,'Realme Fast Charging Power Bank','ACCS-POWE-0096','69402681096','accessory','Power Bank',20,5,800.00,1250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,9,NULL,'Realme',NULL,'single',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,NULL,0.00),(97,'Anker Premium Silicone Protective Case','ACCS-COVE-0097','69402681097','accessory','Cover',33,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,10,NULL,'Anker',NULL,'variable',NULL,'[\"inventory\\/remax_powerbank.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Color\",\"value\":\"Midnight Black\",\"sku\":\"ACCS-COVE-0097-MI\",\"quantity\":13,\"price\":450},{\"variation\":\"Color\",\"value\":\"Navy Blue\",\"sku\":\"ACCS-COVE-0097-NA\",\"quantity\":7,\"price\":450},{\"variation\":\"Color\",\"value\":\"Forest Green\",\"sku\":\"ACCS-COVE-0097-FO\",\"quantity\":13,\"price\":450}]',0.00),(98,'Baseus 9D Tempered Glass Screen Protector','ACCS-GLAS-0098','69402681098','accessory','Glass Protector',38,5,120.00,250.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',2,11,NULL,'Baseus',NULL,'single',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,NULL,0.00),(99,'Joyroom Pixel 8 Pro Power Management IC Chip PM8953','PART-IC-0099','69402681099','spare_part','IC',17,5,250.00,450.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,5,NULL,'Joyroom',NULL,'single',NULL,'[\"inventory\\/pixel7_pro_battery.png\"]',NULL,NULL,NULL,NULL,0.00),(100,'Remax Redmi Note 11 OLED Screen Display Assembly','PART-DISP-0100','69402681100','spare_part','Display',71,5,9000.00,12000.00,NULL,'2026-07-13 04:48:39','2026-07-13 04:48:39',1,1,NULL,'Remax',NULL,'variable',NULL,'[\"inventory\\/s23u_display_assembly.png\"]',NULL,NULL,NULL,'[{\"variation\":\"Quality\",\"value\":\"Original\",\"sku\":\"PART-DISP-0100-OR\",\"quantity\":26,\"price\":12000},{\"variation\":\"Quality\",\"value\":\"OEM\",\"sku\":\"PART-DISP-0100-OE\",\"quantity\":26,\"price\":7500},{\"variation\":\"Quality\",\"value\":\"Copy\",\"sku\":\"PART-DISP-0100-CO\",\"quantity\":19,\"price\":4500}]',0.00);
/*!40000 ALTER TABLE `inventory_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_07_050000_create_customers_table',1),(5,'2026_07_07_051000_create_suppliers_table',1),(6,'2026_07_07_052000_create_inventory_items_table',1),(7,'2026_07_07_053000_create_purchases_table',1),(8,'2026_07_07_054000_create_sales_table',1),(9,'2026_07_07_055000_create_expenses_table',1),(10,'2026_07_07_060106_create_repairs_table',1),(11,'2026_07_07_060106_create_services_table',1),(12,'2026_07_08_051820_add_avatar_to_users_table',1),(13,'2026_07_08_055427_create_settings_table',1),(14,'2026_07_08_055704_add_branch_to_tables',1),(15,'2026_07_08_060719_add_permissions_to_users_table',1),(16,'2026_07_08_062500_create_social_posts_table',1),(17,'2026_07_08_103101_create_categories_and_update_inventory_items_table',1),(18,'2026_07_08_105448_add_discount_value_to_inventory_items_table',1),(19,'2026_07_09_125857_add_checklist_and_commission_to_repairs_table',1),(20,'2026_07_13_071605_add_paid_and_due_amount_to_sales_table',1),(21,'2026_07_13_180000_create_activity_logs_table',2),(22,'2026_07_13_190000_add_used_parts_to_repairs_table',3),(23,'2026_07_13_200000_add_repair_charge_to_repairs_table',4),(24,'2026_07_13_210000_add_payment_details_to_repairs_table',5),(25,'2026_07_13_220000_add_register_type_to_expenses_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_details`
--

DROP TABLE IF EXISTS `purchase_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `inventory_item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_details_inventory_item_id_foreign` (`inventory_item_id`),
  CONSTRAINT `purchase_details_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_details`
--

LOCK TABLES `purchase_details` WRITE;
/*!40000 ALTER TABLE `purchase_details` DISABLE KEYS */;
INSERT INTO `purchase_details` VALUES (1,1,2,1,14000.00,'2026-07-13 04:48:39','2026-07-13 04:48:39'),(2,1,3,1,1800.00,'2026-07-13 04:48:39','2026-07-13 04:48:39');
/*!40000 ALTER TABLE `purchase_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchase_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_purchase_no_unique` (`purchase_no`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,'PUR-202607-0001',1,NULL,15800.00,'2026-07-03','2026-07-13 04:48:39','2026-07-13 04:48:39');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repairs`
--

DROP TABLE IF EXISTS `repairs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `repairs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `device_brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_imei` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_pattern` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repair_charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `estimated_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `advance_payment` decimal(10,2) NOT NULL DEFAULT '0.00',
  `advance_payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_received` decimal(10,2) DEFAULT NULL,
  `change_returned` decimal(10,2) DEFAULT NULL,
  `technician_notes` text COLLATE utf8mb4_unicode_ci,
  `assigned_technician_id` bigint unsigned DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `device_checklist` json DEFAULT NULL,
  `device_photos` json DEFAULT NULL,
  `commission_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `used_parts` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `repairs_ticket_id_unique` (`ticket_id`),
  KEY `repairs_customer_id_foreign` (`customer_id`),
  KEY `repairs_assigned_technician_id_foreign` (`assigned_technician_id`),
  CONSTRAINT `repairs_assigned_technician_id_foreign` FOREIGN KEY (`assigned_technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `repairs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repairs`
--

LOCK TABLES `repairs` WRITE;
/*!40000 ALTER TABLE `repairs` DISABLE KEYS */;
INSERT INTO `repairs` VALUES (1,'M3-202607-0001',1,'Apple','iPhone 13 Pro','357283920193847','Dropped in water, display flickering, touch not working.','Pattern: L-shape starting top-left, Pin: 4829',0.00,'repairing',6500.00,1000.00,NULL,NULL,NULL,NULL,NULL,'Opened phone. Found water residue. Board ultrasonic cleaning complete. Replacing display panel to test screen flicker.',2,NULL,'2026-07-16','2026-07-11 04:48:39','2026-07-12 04:48:39',NULL,NULL,NULL,0.00,0.00,NULL),(2,'M3-202607-0002',2,'Samsung','Galaxy S22','351938472918374','Back glass cracked, battery draining fast.','Pattern: None. Pin: 0000',2800.00,'delivered',4100.03,500.00,NULL,3600.00,NULL,NULL,0.00,'Assigned to diagnose battery degradation. Initial battery health reading: 68%. Waiting to approve battery replacement.asad',2,NULL,'2026-07-16','2026-07-12 23:48:39','2026-07-13 06:48:50','{\"audio_ok\": \"yes\", \"touch_ok\": \"yes\", \"camera_ok\": \"yes\", \"scratches\": \"yes\", \"buttons_ok\": \"yes\", \"display_ok\": \"yes\"}','[]',NULL,0.00,0.00,'[{\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"3\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Premium Silicone Protective Case\", \"quantity\": \"1\", \"buying_price\": \"250.00\", \"inventory_id\": \"31\"}, {\"name\": \"Apple Super Fast Charging Cable\", \"quantity\": \"1\", \"buying_price\": \"300.03\", \"inventory_id\": \"61\"}]'),(3,'M3-202607-0003',3,'Xiaomi','Redmi Note 10','863920193847291','USB port broken, doesn\'t charge at all.','No locks on device.',0.00,'delivered',800.00,0.00,NULL,800.00,NULL,NULL,NULL,'Replaced charging flex cable assembly. Tested draws 1.8A. Device delivered to customer and paid cash.',3,NULL,'2026-07-12','2026-07-09 04:48:39','2026-07-12 04:48:39',NULL,NULL,NULL,0.00,0.00,NULL),(4,'M3-202607-0004',4,'Realme','Realme GT',NULL,'Cracked screen.','Pattern: Diagonal slash top-left to bottom-right.',0.00,'waiting_for_approval',3000.00,1500.00,NULL,NULL,NULL,NULL,NULL,'Screen panel is cracked. Customer wants original display, but we only have OEM in stock. Waiting for approval to order original part.',3,NULL,'2026-07-18','2026-07-10 04:48:39','2026-07-11 04:48:39',NULL,NULL,NULL,0.00,0.00,NULL);
/*!40000 ALTER TABLE `repairs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payable_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_received` decimal(10,2) NOT NULL DEFAULT '0.00',
  `change_returned` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `salesman_id` bigint unsigned DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_invoice_no_unique` (`invoice_no`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  KEY `sales_salesman_id_foreign` (`salesman_id`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'INV-202607-0001',1,4300.00,300.00,4000.00,4000.00,0.00,0.00,0.00,'Cash',4,NULL,'2026-07-10 04:48:39','2026-07-13 04:48:39'),(2,'INV-202607-0002',NULL,1300.00,100.00,1200.00,1200.00,0.00,0.00,0.00,'bKash',4,NULL,'2026-07-13 00:48:39','2026-07-13 04:48:39'),(3,'INV-20260713-M9JH',NULL,4500.00,0.00,4500.00,4500.00,0.00,5000.00,500.00,'Cash',1,'Dhaka Main','2026-07-13 04:50:28','2026-07-13 04:50:28'),(4,'INV-20260713-RMLJ',NULL,250.00,0.00,250.00,250.00,0.00,250.00,0.00,'Cash',4,'Dhaka Main','2026-07-13 05:07:03','2026-07-13 05:07:03'),(5,'INV-20260713-RAQK',NULL,450.00,0.00,450.00,450.00,0.00,450.00,0.00,'Cash',5,'Dhaka Main','2026-07-13 05:17:56','2026-07-13 05:17:56'),(6,'INV-20260713-ESUH',NULL,450.00,0.00,450.00,450.00,0.00,500.00,50.00,'Cash',4,'Dhaka Main','2026-07-13 05:20:24','2026-07-13 05:20:24'),(7,'INV-20260713-IRZW',NULL,5300.00,0.00,5300.00,5300.00,0.00,5300.00,0.00,'bKash',4,'Dhaka Main','2026-07-13 05:21:15','2026-07-13 05:21:15'),(8,'INV-20260713-KM9P',NULL,1800.00,0.00,1800.00,1800.00,0.00,1800.00,0.00,'Cash',1,'Dhaka Main','2026-07-13 06:55:01','2026-07-13 06:55:01');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_details`
--

DROP TABLE IF EXISTS `sales_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `inventory_item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_details_sale_id_foreign` (`sale_id`),
  KEY `sales_details_inventory_item_id_foreign` (`inventory_item_id`),
  CONSTRAINT `sales_details_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_details`
--

LOCK TABLES `sales_details` WRITE;
/*!40000 ALTER TABLE `sales_details` DISABLE KEYS */;
INSERT INTO `sales_details` VALUES (1,1,5,1,1850.00,'2026-07-13 04:48:39','2026-07-13 04:48:39'),(2,1,7,1,2450.00,'2026-07-13 04:48:39','2026-07-13 04:48:39'),(3,2,6,2,650.00,'2026-07-13 04:48:39','2026-07-13 04:48:39'),(4,3,47,1,4500.00,'2026-07-13 04:50:28','2026-07-13 04:50:28'),(5,4,87,1,250.00,'2026-07-13 05:07:03','2026-07-13 05:07:03'),(6,5,77,1,450.00,'2026-07-13 05:17:56','2026-07-13 05:17:56'),(7,6,77,1,450.00,'2026-07-13 05:20:24','2026-07-13 05:20:24'),(8,7,87,1,250.00,'2026-07-13 05:21:15','2026-07-13 05:21:15'),(9,7,77,1,450.00,'2026-07-13 05:21:15','2026-07-13 05:21:15'),(10,7,37,1,1800.00,'2026-07-13 05:21:15','2026-07-13 05:21:15'),(11,7,57,1,2800.00,'2026-07-13 05:21:15','2026-07-13 05:21:15'),(12,8,37,1,1800.00,'2026-07-13 06:55:01','2026-07-13 06:55:01');
/*!40000 ALTER TABLE `sales_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('72GXrEfnzZ8WkAnigQ14EfTz9NOLVUvI98MgCdUR',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWxZUUFSeXNYT1BkRmZqYkdNSjhmN0JmSDF6WVJvcHQ1bTg2bmt1WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vbTMtbW9iaWxlLWNhcmUudGVzdC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1784008611),('v0bOZ11ZycCV6Ai8MlKwxUUiRCwzatuROeTkv4et',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0V6amthcXZUQmlhbHpKTGpneU1XbkNtaDNQY2cyY3F3MEh5Wm5pNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9tMy1tb2JpbGUtY2FyZS50ZXN0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1784008539);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'shop_name','M3 Mobile Care','2026-07-13 04:48:39','2026-07-13 04:48:39'),(2,'shop_slogan','Premium Mobile Repair & Retail','2026-07-13 04:48:39','2026-07-13 04:48:39'),(3,'phone','+880 1712-345678','2026-07-13 04:48:39','2026-07-13 04:48:39'),(4,'email','info@m3mobilecare.com','2026-07-13 04:48:39','2026-07-13 04:48:39'),(5,'address','Shop 14, Level 3, Multiplan Center, Elephant Road, Dhaka','2026-07-13 04:48:39','2026-07-13 04:48:39'),(6,'receipt_footer','TERMS & CONDITIONS:\n1. 30 Days warranty on replaced spare parts (Except liquid/physical damage).\n2. No warranty on software flash or touch calibration adjustment.\n3. Please collect device within 30 days of repair completion.\n4. Show repair slip for pickup.','2026-07-13 04:48:39','2026-07-13 04:48:39');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_posts`
--

DROP TABLE IF EXISTS `social_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `reach` int NOT NULL DEFAULT '0',
  `engagement` int NOT NULL DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_posts`
--

LOCK TABLES `social_posts` WRITE;
/*!40000 ALTER TABLE `social_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Dhaka Parts Depot','01988888888','Motijheel C/A, Dhaka','2026-07-13 04:48:39','2026-07-13 04:48:39'),(2,'Smart Accessories Co.','01877777777','Chawkbazar, Dhaka','2026-07-13 04:48:39','2026-07-13 04:48:39');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'technician',
  `permissions` json DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'M3 Super Admin','admin@m3mobile.com',NULL,'$2y$12$f3lq1oFMHUzgEJhRFQfe5uZOlY9tu1pN5iijJXi2MTBkKLaWs95lq','super_admin',NULL,'01700000001','Master Technician','8 years','Dhaka Main',NULL,NULL,'2026-07-13 04:48:38','2026-07-13 04:48:38'),(2,'John Technician','tech@m3mobile.com',NULL,'$2y$12$XUE/mFBbsbnkecL.tRHcYeguJZ0v8VGSxfjsC7jB6F5m7FtmFRSgm','technician',NULL,'01700000002','Senior Technician (Level 2)','4 years','Dhaka Main',NULL,NULL,'2026-07-13 04:48:38','2026-07-13 04:48:38'),(3,'Abir Tech','abir@m3mobile.com',NULL,'$2y$12$aa1dr6haThazr3e2otRL2OJ4PbA8z0oFMgdH98OpejLkom7IruK1y','technician',NULL,'01700000003','Junior Technician (Level 1)','1.5 years','Dhaka Main',NULL,NULL,'2026-07-13 04:48:38','2026-07-13 04:48:38'),(4,'Kamal Salesman','sales@m3mobile.com',NULL,'$2y$12$czUL2b/JrqlXW2RiqMFNIu5y.C1h0QfnhWshcthCpvPB3aDWN6Phu','salesman','{\"pos\": true, \"cash\": true, \"repairs\": true, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}','01700000004',NULL,NULL,'Dhaka Main',NULL,NULL,'2026-07-13 04:48:38','2026-07-13 07:06:17'),(5,'Manager Admin','manager@m3mobile.com',NULL,'$2y$12$dvL1WnU/NkiH1dAG2ABTi.c3bkgUU8Eh/Hb5BSml35AosAWtOEFb2','admin','{\"pos\": false, \"cash\": true, \"repairs\": false, \"reports\": true, \"expenses\": true, \"settings\": false, \"inventory\": true, \"purchases\": false, \"social_media\": false}','01700000005',NULL,NULL,'Dhaka Main',NULL,NULL,'2026-07-13 04:48:39','2026-07-13 07:05:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-14 12:15:29
