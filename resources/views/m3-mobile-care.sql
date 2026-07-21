-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2026 at 12:26 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m3-mobile-care`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(2, 'charger', 'charger', 'active', '2026-07-08 04:43:42', '2026-07-08 04:43:42');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `alt_phone`, `email`, `address`, `district`, `created_at`, `updated_at`) VALUES
(1, 'Rahim Ali', '01711223344', '01811223344', 'rahim@gmail.com', '12/A, Dhanmondi', 'Dhaka', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 'Karim Ahmed', '01922334455', NULL, 'karim@yahoo.com', 'Mirpur 10, Block C', 'Dhaka', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(3, 'Sultana Begum', '01633445566', NULL, NULL, 'Oxygen, Bayezid Bostami', 'Chittagong', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(4, 'Tanvir Rahman', '01544556677', NULL, NULL, 'Zindabazar', 'Sylhet', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(5, 'mosiur', '01752121196', NULL, '', NULL, NULL, '2026-07-08 03:55:23', '2026-07-08 03:55:23'),
(7, 'Mosiur Rahman2', '01767188743', NULL, NULL, 'Jahangir Tower, Building M5, Kafrul', NULL, '2026-07-08 04:12:19', '2026-07-08 04:12:19'),
(21, 'Sophia Barrett', '+1 (639) 726-4022', NULL, NULL, 'Unde dignissimos id', NULL, '2026-07-08 22:56:20', '2026-07-08 22:56:20'),
(22, 'Hilda Wolfe', '+1 (596) 877-5257', NULL, NULL, 'Doloribus animi fug', NULL, '2026-07-08 22:56:59', '2026-07-08 22:56:59'),
(36, 'Uriel Head', '+1 (155) 364-5062', NULL, NULL, 'Nobis nostrud volupt', NULL, '2026-07-09 04:55:42', '2026-07-09 04:55:42'),
(37, 'Brittany Navarro', '+1 (945) 288-9297', NULL, NULL, 'Sit dolore sed minu', NULL, '2026-07-09 05:00:12', '2026-07-09 05:00:12'),
(38, 'Michelle Downs', '+1 (569) 772-4927', NULL, NULL, 'Duis totam tempore', NULL, '2026-07-09 05:00:22', '2026-07-09 05:00:22'),
(40, 'Mara Beach', '+1 (822) 971-1861', NULL, NULL, 'Anim et nihil neque', NULL, '2026-07-09 05:04:15', '2026-07-09 05:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `category`, `amount`, `description`, `expense_date`, `created_at`, `updated_at`) VALUES
(1, 'Rent', 15000.00, 'Multiplan Center Shop Rent for June 2026', '2026-07-01', '2026-06-30 23:54:57', '2026-06-30 23:54:57'),
(2, 'Salary', 12000.00, 'Salary advance to Abir Tech', '2026-07-03', '2026-07-02 23:54:57', '2026-07-02 23:54:57'),
(3, 'Utility', 2300.00, 'Electricity bill Shop 14', '2026-07-04', '2026-07-03 23:54:57', '2026-07-03 23:54:57'),
(4, 'Purchase', 12500.00, 'Purchased Display & Battery stock - PUR-202607-0001', '2026-06-28', '2026-06-27 23:54:57', '2026-06-27 23:54:57'),
(5, 'Other', 50000.00, 'dasdas', '2026-07-08', '2026-07-08 00:39:27', '2026-07-08 00:39:27'),
(6, 'Purchase', 360.00, 'Stock-In purchase ledger entry: PUR-20260708-8UPU', '2026-07-08', '2026-07-08 05:31:47', '2026-07-08 05:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint UNSIGNED NOT NULL,
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
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
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
  `discount_value` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `name`, `sku`, `barcode`, `type`, `category`, `quantity`, `alert_quantity`, `purchase_price`, `sale_price`, `branch`, `created_at`, `updated_at`, `supplier_id`, `category_id`, `sub_category`, `brand`, `description`, `product_type`, `discount_type`, `images`, `warranties`, `manufacturer`, `expiry`, `variants`, `discount_value`) VALUES
(1, 'iPhone 13 Display Assembly (OEM)', 'PART-DISP-IP13-OEM', '8801938201', 'spare_part', 'Display', 11, 3, 3800.00, 5000.00, NULL, '2026-07-07 23:54:57', '2026-07-08 22:49:00', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(2, 'Samsung S22 Ultra Battery', 'PART-BATT-S22U-ORG', '8801938202', 'spare_part', 'Battery', 15, 4, 1200.00, 1800.00, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(3, 'Xiaomi Redmi Note 10 Charging Port Flex', 'PART-CHRG-RN10-FLX', '8801938203', 'spare_part', 'Charging Port', 2, 5, 250.00, 500.00, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(4, 'iPhone 12 Back Glass (Black)', 'PART-GLAS-IP12-BLK', '8801938204', 'spare_part', 'Back Glass', 8, 2, 600.00, 1200.00, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(5, 'Universal Power IC PM8953', 'PART-IC-PM8953', '8801938205', 'spare_part', 'IC', 25, 10, 150.00, 300.00, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(6, 'Anker PowerPort 20W USB-C Charger', 'ACCS-CHRG-ANK-20W', '6940268101', 'accessory', 'charger', 29, 5, 120.00, 1200.00, NULL, '2026-07-07 23:54:57', '2026-07-08 22:49:00', 1, 2, NULL, NULL, NULL, 'single', NULL, '[]', NULL, NULL, NULL, NULL, 0.00),
(7, 'Baseus USB-C to USB-C Cable 2M', 'ACCS-CABL-BAS-2M', '6940268102', 'accessory', 'Cable', 45, 8, 280.00, 450.00, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(8, 'Joyroom T03S Pro TWS Earphones', 'ACCS-EAR-JR-T03S', '6940268103', 'accessory', 'charger', 50000, 3, 1400.00, 2200.00, NULL, '2026-07-07 23:54:57', '2026-07-09 03:51:17', NULL, 2, NULL, NULL, NULL, 'single', NULL, '[]', NULL, NULL, NULL, NULL, 0.00),
(9, 'Remax 20000mAh Power Bank', 'ACCS-PB-RMX-20K', '6940268104', 'accessory', 'Power Bank', 10, 2, 1100.00, 1650.00, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(10, 'Premium Silicone iPhone 14 Cover', 'ACCS-COVR-IP14-SIL', '6940268105', 'accessory', 'Cover', 19, 5, 150.00, 350.00, NULL, '2026-07-07 23:54:57', '2026-07-08 22:49:00', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(11, '9D Curved Glass for Samsung S21', 'ACCS-GLAS-S21-9D', '6940268106', 'accessory', 'Glass Protector', 48, 10, 120.00, 180.00, NULL, '2026-07-07 23:54:57', '2026-07-08 22:49:00', NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(12, 'asas', 'ACCS-OTHE-FQCVK', NULL, 'accessory', 'charger', 1520, 5, 50.00, 0.00, 'Dhaka Main', '2026-07-08 00:38:15', '2026-07-09 03:51:55', NULL, 2, NULL, NULL, NULL, 'single', NULL, '[]', NULL, NULL, NULL, NULL, 0.00),
(19, 'carger', 'ACCS-CHAR-6QFXT', 'Ex consequatur Exce', 'accessory', 'charger', 1497, 5, 120.00, 1200.00, 'Dhaka Main', '2026-07-08 05:01:05', '2026-07-08 22:49:00', 1, 2, 'adasd', 'olo', 'dasdasd', 'single', NULL, '[\"inventory\\/ojA1KWkhkfWZ7trnF8NJX1e9eTDM3N7gbFa6GXFt.jpg\"]', '6', NULL, '2026-07-10', NULL, 0.00),
(40, 'Demetrius Matthews', 'PART-CHAR-WEGCA', 'Incididunt quod volu', 'spare_part', 'charger', 49, 71, 762.00, 699.00, 'Dhaka Main', '2026-07-09 02:50:38', '2026-07-09 02:50:38', 1, 2, 'Ea nesciunt eum dol', 'Melodie Hensley', 'Adipisicing tempor n', 'single', 'flat', '[]', 'Expedita quia commod', 'Voluptas ad beatae a', '1989-06-12', NULL, 58.00),
(41, 'Jerome Slater', 'PART-CHAR-XVWMA', 'Nulla magnam quo ull', 'spare_part', 'charger', 158, 541, 246.00, 765.00, 'Dhaka Main', '2026-07-09 02:50:48', '2026-07-09 02:50:48', 2, 2, 'Consequat Facere qu', 'Lynn Vance', 'Irure aut mollit quo', 'single', 'flat', '[]', 'Amet sint facere e', 'Eaque sint in culpa', '1995-06-24', NULL, 13.00),
(42, 'Jorden Travis', 'PART-CHAR-YZQM9', 'Consequatur Sunt es', 'spare_part', 'charger', 8, 978, 303.00, 147.00, 'Dhaka Main', '2026-07-09 02:50:57', '2026-07-09 02:50:57', 2, 2, 'Maxime aut inventore', 'Shelley Velazquez', 'Est adipisci quidem', 'single', 'flat', '[]', 'Eum molestias elit', 'Consequatur Quo sit', '2026-06-30', NULL, 82.00),
(43, 'Ryan Roberts', 'PART-CHAR-ME0EQ', 'Dicta in consequuntu', 'spare_part', 'charger', 896, 952, 458.00, 775.00, 'Dhaka Main', '2026-07-09 02:51:06', '2026-07-09 02:51:06', 1, 2, 'Ipsa sequi veritati', 'Stephen Carroll', 'Quis cumque culpa a', 'single', 'flat', '[]', 'Libero aut suscipit', 'Aliquip perspiciatis', '1998-05-08', NULL, 32.00),
(44, 'Kim Greene', 'PART-CHAR-XVVXK', 'Odit omnis deleniti', 'spare_part', 'charger', 40, 387, 433.00, 374.00, 'Dhaka Main', '2026-07-09 02:51:17', '2026-07-09 02:51:17', 2, 2, 'Et tempore atque ne', 'Shad Weber', 'Sint deserunt paria', 'single', 'percentage', '[]', 'Officia tempora qui', 'Deserunt beatae ab e', '2011-02-15', NULL, 70.00),
(45, 'Wade Tyson', 'ACCS-CHAR-NEDGJ', 'Ea quibusdam non non', 'accessory', 'charger', 5, 568, 503.00, 1500.00, 'Dhaka Main', '2026-07-09 02:52:08', '2026-07-09 02:52:08', 2, 2, 'Consequat Vel rerum', 'Clarke Franklin', 'Et autem totam assum', 'variable', NULL, '[]', 'Laborum Quo atque m', 'Et voluptas illo sun', '1990-03-06', '[{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-BLK\",\"quantity\":\"5\",\"price\":\"1500\"}]', 0.00),
(46, 'Leila Koch', 'ACCS-CHAR-QFBRU', 'Fuga Et dicta totam', 'accessory', 'charger', 5, 822, 779.00, 15000.00, 'Dhaka Main', '2026-07-09 02:52:23', '2026-07-09 02:52:23', 2, 2, 'Anim aliquip cupidit', 'Chava Forbes', 'Quas rerum dolores e', 'variable', NULL, '[]', 'Aut praesentium culp', 'Unde consequatur Al', '1995-05-01', '[{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-BLK\",\"quantity\":\"5\",\"price\":\"15000\"}]', 0.00),
(49, 'Dominic Dennis', 'ACCS-CHAR-6QNZV', 'Ratione minim mollit', 'accessory', 'charger', 162, 10, 948.00, 2000.00, 'Dhaka Main', '2026-07-09 02:52:46', '2026-07-09 03:52:32', 2, 2, 'Qui quisquam consequ', 'Tyrone Madden', 'Et fugiat rerum qua', 'variable', NULL, '[]', 'Quia eligendi tempor', 'Nihil repellendus V', '1973-07-04', '[{\"variation\":\"Color\",\"value\":\"Black\",\"sku\":\"ACCS-BLK\",\"quantity\":\"162\",\"price\":\"2000\"}]', 0.00),
(52, 'April Cox', 'PART-CHAR-AHHAC', 'Minim ut id est aliq', 'spare_part', 'charger', 230, 625, 378.00, 986.00, 'Dhaka Main', '2026-07-09 02:56:03', '2026-07-09 02:56:03', 1, 2, 'Eveniet in libero d', 'Kadeem Padilla', 'Illo ducimus totam', 'single', 'percentage', '[]', 'Harum quas vel a nis', 'Vitae sed aspernatur', '1987-10-31', NULL, 47.00);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_07_050000_create_customers_table', 1),
(5, '2026_07_07_051000_create_suppliers_table', 1),
(6, '2026_07_07_052000_create_inventory_items_table', 1),
(7, '2026_07_07_053000_create_purchases_table', 1),
(8, '2026_07_07_054000_create_sales_table', 1),
(9, '2026_07_07_055000_create_expenses_table', 1),
(10, '2026_07_07_060106_create_repairs_table', 1),
(11, '2026_07_07_060106_create_services_table', 1),
(12, '2026_07_08_051820_add_avatar_to_users_table', 1),
(13, '2026_07_08_055427_create_settings_table', 1),
(14, '2026_07_08_055704_add_branch_to_tables', 2),
(15, '2026_07_08_060719_add_permissions_to_users_table', 3),
(16, '2026_07_08_062500_create_social_posts_table', 4),
(17, '2026_07_08_103101_create_categories_and_update_inventory_items_table', 5),
(18, '2026_07_08_105448_add_discount_value_to_inventory_items_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchase_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `purchase_no`, `supplier_id`, `branch`, `total_amount`, `purchase_date`, `created_at`, `updated_at`) VALUES
(1, 'PUR-202607-0001', 1, NULL, 12500.00, '2026-06-28', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 'PUR-20260708-8UPU', 2, NULL, 360.00, '2026-07-08', '2026-07-08 05:31:47', '2026-07-08 05:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_id` bigint UNSIGNED NOT NULL,
  `inventory_item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `inventory_item_id`, `quantity`, `cost_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 3800.00, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 1, 2, 1, 1100.00, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(3, 2, 11, 1, 120.00, '2026-07-08 05:31:47', '2026-07-08 05:31:47'),
(4, 2, 6, 1, 120.00, '2026-07-08 05:31:47', '2026-07-08 05:31:47'),
(5, 2, 19, 1, 120.00, '2026-07-08 05:31:47', '2026-07-08 05:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `device_brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_imei` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_pattern` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `estimated_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `advance_payment` decimal(10,2) NOT NULL DEFAULT '0.00',
  `actual_cost` decimal(10,2) DEFAULT NULL,
  `technician_notes` text COLLATE utf8mb4_unicode_ci,
  `assigned_technician_id` bigint UNSIGNED DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`id`, `ticket_id`, `customer_id`, `device_brand`, `device_model`, `serial_imei`, `issue_description`, `password_pattern`, `status`, `estimated_cost`, `advance_payment`, `actual_cost`, `technician_notes`, `assigned_technician_id`, `branch`, `expected_delivery_date`, `created_at`, `updated_at`) VALUES
(1, 'M3-202607-0001', 1, 'Apple', 'iPhone 13 Pro', '357283920193847', 'Dropped in water, display flickering, touch not working.', 'Pattern: L-shape starting top-left, Pin: 4829', 'repairing', 6500.00, 1000.00, NULL, 'Opened phone. Found water residue. Board ultrasonic cleaning complete. Replacing display panel to test screen flicker.', 2, NULL, '2026-07-11', '2026-07-05 23:54:57', '2026-07-06 23:54:57'),
(2, 'M3-202607-0002', 2, 'Samsung', 'Galaxy S22', '351938472918374', 'Back glass cracked, battery draining fast.', 'Pattern: None. Pin: 0000', 'quality_check', 3500.00, 500.00, NULL, 'Assigned to diagnose battery degradation. Initial battery health reading: 68%. Waiting to approve battery replacement.', 2, NULL, '2026-07-10', '2026-07-07 18:54:57', '2026-07-08 00:59:45'),
(3, 'M3-202607-0003', 3, 'Xiaomi', 'Redmi Note 10', '863920193847291', 'USB port broken, doesn\'t charge at all.', 'No locks on device.', 'delivered', 800.00, 0.00, 800.00, 'Replaced charging flex cable assembly. Tested draws 1.8A. Device delivered to customer and paid cash.', 3, NULL, '2026-07-07', '2026-07-03 23:54:57', '2026-07-06 23:54:57'),
(4, 'M3-202607-0004', 4, 'Realme', 'Realme GT', NULL, 'Cracked screen.', 'Pattern: Diagonal slash top-left to bottom-right.', 'waiting_for_approval', 3000.00, 1500.00, NULL, 'Screen panel is cracked. Customer wants original display, but we only have OEM in stock. Waiting for approval to order original part.', 3, NULL, '2026-07-13', '2026-07-04 23:54:57', '2026-07-05 23:54:57'),
(5, 'M3-202607-YJ2X', 5, 'Apple', 'Galaxy S22', '351938472918374', 'test', NULL, 'repairing', 0.00, 0.00, NULL, NULL, 2, NULL, NULL, '2026-07-08 03:55:23', '2026-07-09 03:09:04'),
(7, 'M3-202607-NXZ2', 7, 'Samsung', 'gdfgdfg', '351938472918374', 'nosto', '13345', 'delivered', 1500.00, 200.00, 2500.00, 'almost done', 2, 'Dhaka Main', '2026-07-16', '2026-07-08 04:12:19', '2026-07-09 03:06:00'),
(21, 'M3-202607-1HKD', 21, 'Samsung', 'Mara Kline', '493', 'In aliquip occaecat', 'Et consectetur quis', 'delivered', 75.00, 95.00, 75.00, 'Sed assumenda nisi a', 2, 'Dhaka Main', '2023-10-26', '2026-07-08 22:56:20', '2026-07-09 03:08:02'),
(22, 'M3-202607-KOWW', 22, 'Google', 'Christine Huber', '901', 'Totam iure commodo p', 'Illo quis laboris nu', 'delivered', 54.00, 65.00, 54.00, 'Dignissimos alias qu', 3, 'Dhaka Main', '2002-05-04', '2026-07-08 22:56:59', '2026-07-09 03:03:30'),
(36, 'M3-202607-KSQP', 36, 'Realme', 'Yeo Sosa', '246', 'Inventore magnam hic', 'Aperiam non dolore e', 'waiting_for_approval', 69.00, 78.00, NULL, 'Ea odio voluptatem f', 2, 'Dhaka Main', '1971-01-27', '2026-07-09 04:55:42', '2026-07-09 04:57:36'),
(37, 'M3-202607-JQDT', 37, 'Xiaomi', 'Sydney Mcdonald', '345', 'Fugiat aut eaque re', 'Nulla iusto qui aliq', 'pending', 42.00, 66.00, NULL, 'Non doloremque disti', NULL, 'Dhaka Main', '2010-05-02', '2026-07-09 05:00:12', '2026-07-09 05:00:12'),
(38, 'M3-202607-GWON', 38, 'OnePlus', 'Uriah Bass', '369', 'Consectetur quia sun', 'Nam nihil sint velit', 'pending', 87.00, 26.00, NULL, 'Voluptatem officia i', NULL, 'Dhaka Main', '1972-04-07', '2026-07-09 05:00:22', '2026-07-09 05:00:22'),
(39, 'M3-202607-L5M9', 7, 'Apple', 'gdfgdfg', '351938472918374', 'asdasd', NULL, 'pending', 0.00, 0.00, NULL, 'dasdasd', NULL, 'ranisankail', '2026-07-12', '2026-07-09 05:02:12', '2026-07-09 05:02:12'),
(41, 'M3-202607-VBNQ', 40, 'OnePlus', 'Daquan Buckner', '966', 'Dolorem nostrum ad q', 'Sit deserunt quia u', 'pending', 38.00, 71.00, NULL, 'Error fugiat molest', NULL, 'Dhaka Main', '2015-03-21', '2026-07-09 05:04:15', '2026-07-09 05:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payable_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `salesman_id` bigint UNSIGNED DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `customer_id`, `total_amount`, `discount`, `payable_amount`, `payment_method`, `salesman_id`, `branch`, `created_at`, `updated_at`) VALUES
(1, 'INV-202607-0001', 1, 2850.00, 150.00, 2700.00, 'Cash', 4, NULL, '2026-07-04 23:54:57', '2026-07-07 23:54:57'),
(2, 'INV-202607-0002', NULL, 360.00, 0.00, 360.00, 'bKash', 4, NULL, '2026-07-07 19:54:57', '2026-07-07 23:54:57'),
(3, 'INV-20260708-CBOP', NULL, 180.00, 0.00, 180.00, 'Cash', 4, 'Dhaka Main', '2026-07-08 00:58:20', '2026-07-08 00:58:20'),
(4, 'INV-20260708-BBWL', NULL, 1380.00, 0.00, 1380.00, 'Cash', 4, 'Dhaka Main', '2026-07-08 03:52:56', '2026-07-08 03:52:56'),
(5, 'INV-20260708-B1SG', NULL, 3600.00, 0.00, 3600.00, 'Cash', 1, 'Dhaka Main', '2026-07-08 05:01:27', '2026-07-08 05:01:27'),
(6, 'INV-20260709-IEEO', NULL, 10130.00, 0.00, 10130.00, 'Card', 5, 'Dhaka Main', '2026-07-08 22:49:00', '2026-07-08 22:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_id` bigint UNSIGNED NOT NULL,
  `inventory_item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`id`, `sale_id`, `inventory_item_id`, `quantity`, `sale_price`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 1, 1200.00, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 1, 8, 1, 1650.00, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(3, 2, 11, 2, 180.00, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(4, 3, 11, 1, 180.00, '2026-07-08 00:58:20', '2026-07-08 00:58:20'),
(5, 4, 11, 1, 180.00, '2026-07-08 03:52:56', '2026-07-08 03:52:56'),
(6, 4, 6, 1, 1200.00, '2026-07-08 03:52:56', '2026-07-08 03:52:56'),
(7, 5, 19, 3, 1200.00, '2026-07-08 05:01:27', '2026-07-08 05:01:27'),
(8, 6, 11, 1, 180.00, '2026-07-08 22:49:00', '2026-07-08 22:49:00'),
(9, 6, 6, 1, 1200.00, '2026-07-08 22:49:00', '2026-07-08 22:49:00'),
(10, 6, 19, 1, 1200.00, '2026-07-08 22:49:00', '2026-07-08 22:49:00'),
(11, 6, 1, 1, 5000.00, '2026-07-08 22:49:00', '2026-07-08 22:49:00'),
(12, 6, 10, 1, 350.00, '2026-07-08 22:49:00', '2026-07-08 22:49:00'),
(13, 6, 8, 1, 2200.00, '2026-07-08 22:49:00', '2026-07-08 22:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1I81xV7ZPEYqec5tPXocAxSm20sqROFQo59MlpD7', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWdnY050NndWNUo5ajlkZTd0aEhjSTM1eFRTOWVJMjRYTFZXeGFUcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783595009),
('27uzBe8VKaVCnn46sKjB3Ekm68PiHN0gYmeE0KcC', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDlxMUxjTkVLeDNNU2VsWkNnU3ZrQ2owMkYzS1VWQ0N5ZVhtZk0wbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783589119),
('2W0GceHNbPSYU56mKZdhf0gLWvfRwC6XPPngxJJr', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT3pNYm9Yd25kUEI0MEs2cGF2dXY5V01WRE5iZDhBbEI2c3BPbTRKWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783594417),
('3GA6VeJI6291l70bYWApQg9muYXUjIahVt8oH55A', 37, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNEE4azdWWWE3Yk1yTnl4S09ZVnBOdE1TOTFLTVp4MkQ1TG5EUkkxYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozNzt9', 1783595010),
('3lDFX4by9MZ9qEG6lXK1eadyT8tpGbaZD9FrYoMm', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib29LdGhuZTJibnFBUDNCUUhjOEM2R3VwSFp2MG04bG1XcHdwZ1lhQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783592122),
('4RYwpmfKhDMJe8eC2c012KTdw2bOMQGxzhELkbnz', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidU0zdW5ZbU11dmRUaUR1N3Q5U2Nibk5UTURCTG9HT1FSd3RwZ3ozZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783592099),
('6jxfDhdsSZjzViVXwc7ZKarONOBshqCoV4iGe4SB', 33, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic3NWVDFITWxLVDF1ME5PbjVVSGlIaEZDczd1Y0V0cExGQTJWQWt4UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMzt9', 1783592123),
('6xV4mQ4qHLijEkHyZZlJKR2BpDaMQ0e9T8BLrcSl', 35, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTEsyZVVveVJabjlXUkY3WlFOeHhUSjlmUXRzcHBFaDZRN3ZVbjBmZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozNTt9', 1783594001),
('8lfUhKY2VZC92XIZ7fnU5K7qcobGXoflQ5O0P6yd', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZndMakMxUDJSc05QN2ZxTVQ2bGxkV2U4OFBLd0RPcUxkeXQxeW5seSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vbTMtbW9iaWxlLWNhcmUudGVzdC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udXNlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1783596134),
('ACPxViNyDQKGDXbprzf4ZpQIOrTCs75AyC9mnkLV', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicWNhOU5GVFlxaGJDM3pkekF1MklacVlIYzJ0SFkxOXdKYmpUZzRGVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783592123),
('APBFFS5rdlcWflKIYfo8vUCL6ZGbLwMrajNCVyyE', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM1NLc2FPUnJDR2tZd2p1aGh0dmlIZXd0QllMNjF6UWVvZ2VKYkxpeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783594001),
('baEqJsPYTXviGgfqa0Z01QMo6Bk7HnZfB99gQaCK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVWx6SWZrWlVkZXJiNVJFT2FvazVNejB5cXRUNEFqZDcyRnFJcXRPNyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cHM6Ly9tMy1tb2JpbGUtY2FyZS50ZXN0L2FkbWluL2NhdGVnb3JpZXMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly9tMy1tb2JpbGUtY2FyZS50ZXN0L2FkbWluL2NhdGVnb3JpZXMiO3M6NToicm91dGUiO3M6MjI6ImFkbWluLmNhdGVnb3JpZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783594162),
('BCiXmAPx9lteIBQoLiwkaMGEYwc4s1dXh3UR1NQx', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYzNZOXJPUjBwcldaRlpQaXh6VDBjYlowbXJ3cUtYZndSazVTQWp5OSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783595010),
('BJL6yduNeRkCn9CJsdJN0vZjBAEl6Bz7jSATCKnq', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic095M3lSMDFWMXBHN1FDb1NDWGNTdUlEUzFlUlg1VTFxT1lKVEVIaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783596082),
('Ce3S9gSGp1oONJNariQYMv6svVKrYEieHTXoS5jf', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ2k2bEFiZVhSaWlkWTZyQm1pWEpTRTY2Ykc5NW1QNnlVbHpoaGFnYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783589119),
('dfp9Xj4WNtmhaID79K2xxGBBxtC7WLUBBGflkYSf', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOHNyNmFBYXRteWFPbkRhRDB5MXA0MWZnMW1oZTFUNXVqR3RPT2djWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783589119),
('dhd7vsZvqDnEEM5sy3vNnE9EfB99xSZ6CCEr7lSW', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiY05jQzgzQ2NaV1FhaW9lbDF0YldmUzhScXdtZEN1RWNIaldiUzNOTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783594418),
('dQE60rbnWmDunLylwBUeWwyeHvcBkGAtXFobTZhZ', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTE9BZTg1dnQwS0Q5Q0I2WlhHbmRtNlYweGFpckJEOVNhZzNmVndhZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783592565),
('dru1dmpjBMdwhqWycY2X7PZwkvOSXdUCx2VX1mfW', 36, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ1BLZk9Sem5rQUdZUXl1eTM5bzM4bFNEcVd0UFZ1dTgwN3ZYT0duMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozNjt9', 1783594418),
('ED3OP0qSjfBLX5Hp5SfpSwLJxoaDyHCFUNZQWrSl', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRUFOMG1HV3p1OFNaSHRKUXdvdndqR1FyeVZpcnlsR2MyV0F0cmhCbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783592123),
('EgvqIQHR1l0zJDWMW3FzWUUeSBo6pYgGqnvzRFGf', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicUZiQTl4UHZMZDZmVmVvaHdnWU9WZ1JkRGxLSlF3T25Gdm02bkxRMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783592565),
('fg9YfXblObkDPXkhy6eAD6AaUMigUMdJPewuZ4RM', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib3pZZzI0ZXIwRU1RaThXSmlMOXhwQ056QnVZbVB3aWFzVEhETUxPbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783595009),
('FWFHgdLn5KOoU8ZGLrcMv4MW39eA2hz1zhSzCbPE', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTmRJR1dLOFNZaGR0OExBdTFJV1k3QXBRVGtneTNsdEtIbzdyTWR4RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783590926),
('g8fsvZwgHdsaFUiiZk6QknBEZZm8SFRss3A6CKVL', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiam9OODFoajZQQ2toRHpvVElWTEdSRnZ0N3hLWWxMQWpMNGhZRzltNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783592099),
('GVy9rXMhAeK47FbQJAWTuExnioDcvTWSQRU5HqBT', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidkZuTWxPdmV2c25UcmJyTlpsMVV2VGd5cFBqNGE4UDR6Vzl0SVZDYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783592099),
('hByKus74k8G5tXOzTm3dvLWxHVol2JgKJoR74YaB', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidE5QTVQzQWhNWGtvd0hpbnBnT1c3TExibk1mOVZTaEowMXV3ZUtsdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783589434),
('ia9DJw9wnjhEiqvxEY5b4f33FuQYDK5EqPedoF7I', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieG84a3NpaXBnRkZBQWE3enZSSFRQUTAxMGFxbVJTbTZEY000OUJ0WSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783594417),
('ifFZMqeYn742uStfSw6pAqGTmhbGlacvrLvSbXG4', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickViaVBLb1MxaXd6VVA3ZUt5b3ZjTUwwUk5yWUFXc3JaRGpqamxTNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783594417),
('IOd3soZ7lGER5XPnGdX8yMKtKO39NjybCGTwpN3b', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGcxdUR6cXNxQWhJMzQxSmlYTEhjVktZeHN1aDBZeWMyN1AyMG90VCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783590926),
('jqjIySYWWja1dyohKegVWIDp9ckskJ8ib4xvNo5K', 32, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZHY4elR1Q0gxRmFka1llQkppWDRjU0ZTNjA4OU1qUXR4R0N1aDlXWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMjt9', 1783592099),
('jRisaYVu0D4sDqcNNb7rRfx6RQ2v1ZvlxO4ruGeU', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2tHYzhEa3pmVnR2bnlJYkdZamk5SDdVQlVMblY1TVkwUjU0ZmQ4UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783590926),
('Kdjloh2nAlhohEawiZHoAAfSMp0bMJLqhVZpe1PP', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWZKWks0RUNCb0k2and0ejlwckJtUXE2cGM3VURNbWM1WEh4WDB6UyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783592565),
('L5AC56Pdy9Q3qvnrgIBfH2fYq1fBng56EPRdpBcU', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZlF2ZUIwaGlkSDk1cVNMS3B2dW02NXVXbkZyNktQV3FsdlptZ3RVdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783595010),
('lFNpqECZ5sZk2JpjEh2HXK4Npil3PzXk0Tx9JB9o', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRW9pQjNIU1l0aEJqeDg2NW8ycUNuT0lYa003Um9UOGZZZFVqcFRMNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783589434),
('M9Dgs4Y3cTvykQvopBTki43BGQM8BeJcMGgypyCA', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielI3QWZpaU5YanZRZEFwYXZyaDZhMW1BWXlEeThkZVhjZ2pZQVpReCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783589119),
('MgHVvIWxGHI5VjPO4QtxMXg7sCm9Ar3o3WFi8MRu', 31, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicmQ0Z3FSbUx3OFFuckhueG9pQU5xemNZNmZtcnBLc1U5aE85THAzcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMTt9', 1783590927),
('MnRq0HVyEeDGnNqsLWdkZjshAIzX6RCxQzFmLQ2W', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWVdLTGpYS0U1akdSMmRBdHdaT29nQzdYV1dHZ1I4Q0c2dFRJMXFvSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783594000),
('mrbsksOrmSyNOiybGcRoTlBJYVSwyzdhmDMR2ADP', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMHpTaDFqVVpsRlJRM3UzZ3g3QzNYcHVDOTM0OEtRQTY4WWtmWVU4MSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783592123),
('n3xhjqNVn2ToZiTAPX9IS8po4ob2rD3HgfxIqsfs', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV2VFWXRxN3Y1dk40OU9FSzNYa2pNQjQwRTh2OFlsWWNaWktia0p1QSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783592099),
('n5TOHaIcIOUYhQMeEm0tasr9Ulf7jhDz3Xr2SAZt', 34, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnM2Z0Vsd3B6djVkc2d0eUF4QW93TmYyOEpjZU5zMGYweGdPMFkwMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozNDt9', 1783592565),
('pqV1BqXltSfZt11R0dsyrZgsDf99u1fcDTOT5W72', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM3NCc3plMHJQNWFualpXeVR6VkhyUTAzdXczQ3JEc09Lb1ZXUEtPWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783590927),
('Qgct9VOi4uS51rJX0WaZyN44PNbGu1X2AhA2geNf', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidjRmd2l4SkxzdHkyVFhuM2RVbVcwcTJROXIxS3d4T2pUWDFYd3pxSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783596081),
('qvKF3PzFKrCqtH7vmDpG07746kZGjDswlmxW2Kia', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzJudVl2b2p3c2prOVVqQmtrVFZGTlQ3OEN0QXg4dFdQZE05N243RiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783589434),
('rliC4g1PiNxWieRx2LHUvqzAq8DNbdnqr5Yj3od3', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVEt3ZlFaU0ttM2N6bDdlaXpmZEV5Tm1zNFJiZ0Y3VFUwZndpQzFkTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783594000),
('SB6JrpDmMzU0hB5Da3sVPP8MtuiIFBTKFJb6AOlU', 1, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYU9PdlJBNnFsajQ5a3Y5M0JVRU9rSDVlSmxQNU1LS0FMaUg2S2lDSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783594000),
('Sfp32WFhQ6WcPkgvMx1KZGZFKlBiZiSjn2fs1ksp', 1, '127.0.0.1', 'Symfony', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQkVUcUlmazBzTXNnSDI3SlFZdDZQSEtCVHVZTTdKSk52SUtVRFFVdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vc29jaWFsIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5zb2NpYWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czozNzoiSm9iIENhcmQgdGlja2V0IGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5ISI7fQ==', 1783589434),
('SkoyibBKltizCUnEdI3Qo2LfpidBrTZS0Y0sh5oh', 30, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU05tcTBPY2JuY0U3aXhJVFg2aVBDSUdMSU92MmMyM0t1c1E2enlhbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMDt9', 1783589434),
('sOuNOf2XqobhS4O4tC87hQIsyVyCeqIWvUtOIZ9M', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGhUMm5ZT3hnVTIxd3c1bDB6WlE0UlVhQ0FBWFJPR2k3U2hMemptMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vbTMtbW9iaWxlLWNhcmUudGVzdC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1783592808),
('TCfyBUulojXGWMM6V9ebK27kvmSIf9TKDpwrGNMY', 29, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0duMlk5TlZqMWFBYTJtand5WEdCT25oQnFES0tLUmFFN1R2VjhKViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyOTt9', 1783589119),
('trANzMYnoXwGWNTBWzoopgjUhP2p3HmFGs268Xta', 38, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWHJrMFNaRHNtOHphV05wQUd3UDhrelhERXI4TFdXdWxaSExocmV1QiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5wb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozODt9', 1783596082),
('ukmxO4EwDucZsfdYCYBnP8Cg19UyJIpVzi4fFMs6', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSEFYQm0wVllFT2tuSFZLTE5WZXh1SHZqSjVpU0lZZ2x5QWNlZVhIVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783592565),
('VnNUd7CyltKtiXPRuPxsfc0ywrdn60txgZTuNLyU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia2UwYzRacGFjZHNVOWlSTm9Ia3d2SUphVzZoczQzMTI5YTNSRDA5aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbTMtbW9iaWxlLWNhcmUudGVzdC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783594162),
('WECVPUJ6aTR5OdPXUq3DjmVSIaV50ACi6xbDojfg', 2, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYVdjRzNtTEk0eEFVazFlT2JrTUozeWtEWWNORlRNYXllZ1RvNlVyUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783596082),
('z2yinHyR3UlOLJfEbS2MDKVXqXxswmof8lfRznm0', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU2wzZGRVUDF6aTB1OTgwcEhmMEQ5WFBkdWVxcVlxVHRLbW53TDRnciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vbTMtbW9iaWxlLWNhcmUudGVzdC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1783595631),
('Zt3tIHKqGqg21acAGDKOFCTfBZbhukZcQsOkC1kr', 5, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTzkyOU93MHVKZExzYUNZRnh1OUxmOWx3cWx1UEtnc2xTVGlWZ2g2ZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1783596082);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'shop_name', 'M3 Mobile Care', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 'shop_slogan', 'Premium Mobile Repair & Retail', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(3, 'phone', '+880 1712-345678', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(4, 'email', 'info@m3mobilecare.com', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(5, 'address', 'Shop 14, Level 3, Multiplan Center, Elephant Road, Dhaka', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(6, 'receipt_footer', 'TERMS & CONDITIONS:\n1. 30 Days warranty on replaced spare parts (Except liquid/physical damage).\n2. No warranty on software flash or touch calibration adjustment.\n3. Please collect device within 30 days of repair completion.\n4. Show repair slip for pickup.', '2026-07-07 23:54:57', '2026-07-07 23:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `social_posts`
--

CREATE TABLE `social_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `reach` int NOT NULL DEFAULT '0',
  `engagement` int NOT NULL DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_posts`
--

INSERT INTO `social_posts` (`id`, `platform`, `content`, `media_path`, `scheduled_at`, `status`, `reach`, `engagement`, `published_at`, `created_at`, `updated_at`) VALUES
(2, 'Facebook', 'frwerwe', NULL, '2026-07-10 02:15:00', 'draft', 0, 0, NULL, '2026-07-08 02:14:19', '2026-07-08 02:14:19'),
(3, 'Instagram', 'sdasda', NULL, '2026-07-02 14:14:00', 'draft', 0, 0, NULL, '2026-07-08 02:14:39', '2026-07-08 02:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka Parts Depot', '01988888888', 'Motijheel C/A, Dhaka', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 'Smart Accessories Co.', '01877777777', 'Chawkbazar, Dhaka', '2026-07-07 23:54:57', '2026-07-07 23:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `permissions`, `phone`, `skill_level`, `experience`, `branch`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'M3 Super Admin', 'admin@m3mobile.com', NULL, '$2y$12$IZs4LN3KPGdH5TckCTB2UOd2ctv9OReC9ytyWqLNSnyG3Z1TkE4bG', 'super_admin', NULL, '01700000001', 'Master Technician', '8 years', 'Dhaka Main', NULL, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(2, 'John Technician', 'tech@m3mobile.com', NULL, '$2y$12$aTKnjoVWjv5JaYiRGDwzqOCY1vGkU4/uCIUjvm9jCLHhUonPiPR6W', 'technician', NULL, '01700000002', 'Senior Technician (Level 2)', '4 years', 'Dhaka Main', NULL, 'ueG5rRrodMz1AZ6F9DPdV2e9khmXyUAkt0JWElFFKEdXO9KnFsvlPVeGOSw8', '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(3, 'Abir Tech', 'abir@m3mobile.com', NULL, '$2y$12$GwxnJeSv7Xc1BgbXJOn3Zuq0D8bQEwbSNN9u1rZWPi9di6UeRBd.a', 'technician', NULL, '01700000003', 'Junior Technician (Level 1)', '1.5 years', 'Dhaka Main', NULL, NULL, '2026-07-07 23:54:57', '2026-07-07 23:54:57'),
(4, 'Murad', 'sales@m3mobile.com', NULL, '$2y$12$soogUvtR8SHQ9HXGropP5OlrhKZ1MLBaMnDme6DUQR8ybxvl6bAfO', 'salesman', '{\"pos\": true, \"repairs\": true, \"reports\": false, \"expenses\": false, \"settings\": false, \"inventory\": false, \"purchases\": false, \"social_media\": false}', '01700000004', NULL, NULL, 'ranisankail', 'avatars/wrISB68Ei9CvBOrnIRhouO9oaHrseppjNIb7oczZ.jpg', NULL, '2026-07-07 23:54:57', '2026-07-09 04:26:45'),
(5, 'Munna', 'manager@m3mobile.com', NULL, '$2y$12$aV.FQ0VlrM6S4yKS4j5l3./ylpNM2J9X7AhFmg/iDypKLgwZWEZLW', 'admin', '{\"pos\": true, \"repairs\": true, \"reports\": true, \"expenses\": true, \"settings\": false, \"inventory\": true, \"purchases\": true, \"social_media\": true}', '01700000005', NULL, NULL, 'ranisankail', 'avatars/GfZJnJzJJm9W8ti3NRSo9UaJs83tbO3N1inOZDXl.png', NULL, '2026-07-07 23:54:57', '2026-07-09 04:27:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_items_sku_unique` (`sku`),
  ADD KEY `inventory_items_barcode_index` (`barcode`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_purchase_no_unique` (`purchase_no`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_inventory_item_id_foreign` (`inventory_item_id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `repairs_ticket_id_unique` (`ticket_id`),
  ADD KEY `repairs_customer_id_foreign` (`customer_id`),
  ADD KEY `repairs_assigned_technician_id_foreign` (`assigned_technician_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_no_unique` (`invoice_no`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_salesman_id_foreign` (`salesman_id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_details_sale_id_foreign` (`sale_id`),
  ADD KEY `sales_details_inventory_item_id_foreign` (`inventory_item_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `social_posts`
--
ALTER TABLE `social_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `social_posts`
--
ALTER TABLE `social_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `repairs`
--
ALTER TABLE `repairs`
  ADD CONSTRAINT `repairs_assigned_technician_id_foreign` FOREIGN KEY (`assigned_technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `repairs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
