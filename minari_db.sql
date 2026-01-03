-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2025 at 03:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minari_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `secret_key` varchar(255) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `is_super_admin`, `secret_key`, `last_login_at`, `last_login_ip`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin MINARI', 'superadmin', 'superadmin@minari.com', '$2y$12$sZeTYuC85kzNnPHsFGLSuu0HiD8KueBHyoSZ7NHtGDWGY9JMQ/OJC', 1, 'MINARI_SUPER_2025', NULL, NULL, NULL, '2025-12-14 23:59:16', '2025-12-14 23:59:16'),
(2, 'Admin MINARI', 'admin', 'admin@minari.com', '$2y$12$wWGzIhzz4Z6xv8/8XEDbDug/.mvNyA/eFt58tpm3JrCl4DtzFix.m', 0, 'MINARI_ADMIN_2025', '2025-12-22 13:17:36', '127.0.0.1', NULL, '2025-12-14 23:59:16', '2025-12-22 13:17:36'),
(3, 'Manager MINARI', 'manager', 'manager@minari.com', '$2y$12$cZjltDDXvD2QJvBAEREkmeIR8eMYbEgdpmuj26BkfY82rtO5XDAAm', 0, 'MINARI_MANAGER_2025', NULL, NULL, NULL, '2025-12-14 23:59:17', '2025-12-14 23:59:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_id`, `quantity`, `size`, `color`, `created_at`, `updated_at`) VALUES
(9, 6, NULL, 45, 2, NULL, NULL, '2025-12-18 10:20:54', '2025-12-18 10:26:59'),
(10, 6, NULL, 9, 1, NULL, NULL, '2025-12-18 10:26:54', '2025-12-18 10:26:54'),
(13, 1, NULL, 1, 1, NULL, NULL, '2025-12-21 14:39:53', '2025-12-21 14:39:53'),
(18, 7, NULL, 23, 1, NULL, NULL, '2025-12-22 06:02:18', '2025-12-22 06:02:18'),
(25, 7, NULL, 42, 1, NULL, NULL, '2025-12-22 06:38:33', '2025-12-22 06:38:33'),
(26, 7, NULL, 10, 1, NULL, NULL, '2025-12-22 12:24:58', '2025-12-22 12:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `background_image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Shirts and Blouse', 'shirts-and-blouse', 'Shirt and Blouse menghadirkan koleksi atasan dengan desain modern dan timeless. Cocok untuk tampilan kasual hingga formal, dibuat dari bahan nyaman yang mudah dipadukan untuk berbagai aktivitas harian.', 'categories/vTMFvZkmYKpHWegpY7GAGevKRRhRiOwSZsR20GiP.png', 'categories/backgrounds/rLrbeK8DxLyRIZBb2qckvh4FiaX9GZqmBnISj5RC.png', 'active', '2025-12-15 00:41:29', '2025-12-15 00:41:29', NULL),
(3, 'Sweaters, Cardigan, and Fleece', 'sweaters-cardigan-and-fleece', 'Rasakan kenyamanan maksimal dengan koleksi Sweaters, Cardigan, and Fleece kami. Dibuat dari bahan lembut dan hangat, sempurna untuk menemani aktivitas santai, kerja, hingga hangout dengan tampilan tetap modis.', 'categories/dTiU0BBAuiaxxIeTrD0WNCppsZqMYzlUuFJ1t5LL.png', 'categories/backgrounds/9GB5g8h1F7Aecm2lJFLrNH07E6jWRZsOBcCxaLLD.png', 'active', '2025-12-15 00:51:18', '2025-12-15 00:51:18', NULL),
(4, 'T-Shirts and Polo', 't-shirts-and-polo', 'Temukan koleksi T-Shirts and Polo dengan potongan modern dan bahan berkualitas. Mudah dipadukan untuk berbagai aktivitas, dari hangout hingga aktivitas harian dengan tampilan tetap stylish.', 'categories/v4W2JbZq1yleuzuUVfTI3cnjYvOrHGttpsNplFbL.png', 'categories/backgrounds/T09lltdIFIZU86KbpRytVIXQmtXGxNOjNjn6rxo7.png', 'active', '2025-12-15 00:52:34', '2025-12-15 00:52:34', NULL),
(5, 'Pants', 'pants', 'Temukan koleksi Pants dengan potongan yang versatile dan mudah dipadukan. Dirancang untuk menunjang gaya sehari-hari dengan tetap mengutamakan kenyamanan.', 'categories/NhKpKzTpsnLIokvHaHMRIgiZ7b6QQCEPrYdrChJk.png', 'categories/backgrounds/pWQKfj7DTk1Vl9z3iQgKNRs52PrsLlRuoOpwOHXa.png', 'active', '2025-12-15 00:54:32', '2025-12-15 00:54:32', NULL),
(6, 'Skirt and Dress', 'skirt-and-dress', 'Temukan koleksi Skirt and Dress yang dirancang untuk menonjolkan sisi anggun dan percaya diri. Dengan pilihan potongan dan detail yang elegan, sempurna untuk tampilan kasual maupun formal.', 'categories/qLRL5xn943O0MlBUeDyNQpQk0qBG0SZ5KN0pKuWu.png', 'categories/backgrounds/CYh2PXLo4yVMh3fRy0XFy70y6GgPEnImC9IORxC2.png', 'active', '2025-12-15 00:55:35', '2025-12-15 00:55:35', NULL),
(7, 'Accessories', 'accessories', 'Lengkapi penampilanmu dengan koleksi Accessories yang dirancang untuk menambah karakter dan gaya. Cocok dipadukan dengan berbagai outfit, dari kasual hingga elegan.', 'categories/1pvyU1sdJXXqTwDu4ZdVlvABj7qFOpEzjM4qWLPV.png', 'categories/backgrounds/Rn0RO49KPluU04i4ZbfWsZkIMfHPLKavkhnzjI5T.png', 'active', '2025-12-15 00:56:39', '2025-12-15 00:56:39', NULL),
(8, 'tas', 'tas', 'apa aj', 'categories/ub5k3OLC9P0VhfNquWByBfoqUFGqFFPHjVOcPUvq.jpg', 'categories/backgrounds/K3iQ5emw6FgXaEdySa0qD0XsdYHB4VtW9fvfzOte.jpg', 'active', '2025-12-16 04:47:21', '2025-12-18 05:15:59', '2025-12-18 05:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_07_115012_create_categories_table', 1),
(5, '2025_12_07_115310_create_products_table', 1),
(6, '2025_12_07_115405_create_orders_table', 1),
(7, '2025_12_07_115508_create_order_items_table', 1),
(8, '2025_12_07_115559_create_reviews_table', 1),
(9, '2025_12_07_115718_create_promotions_table', 1),
(10, '2025_12_07_115855_create_wishlists_table', 1),
(11, '2025_12_07_120032_create_carts_table', 1),
(12, '2025_12_07_122917_create_permission_tables', 1),
(13, '2025_12_07_131649_add_deleted_at_to_categories_table', 1),
(14, '2025_12_09_023523_add_missing_columns_to_users_table', 1),
(15, '2025_12_09_042317_create_payments_table', 1),
(16, '2025_12_09_042754_create_shippings_table', 1),
(17, '2025_12_13_070335_create_admins_table', 1),
(18, '2025_12_13_120721_create_suggestions_table', 1),
(19, '2025_12_13_132348_create_user_addresses_table', 1),
(20, '2025_12_14_155610_update_product_status_column_to_string', 1),
(21, '2025_12_15_071307_add_background_image_to_categories_table', 2),
(22, '2025_12_15_125110_add_discount_to_orders_table', 3),
(23, '2025_12_16_105226_remove_size_column_from_products_table', 4),
(24, '2025_12_22_125448_update_payment_status_column_in_orders_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_postal_code` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_postal_code`, `notes`, `subtotal`, `discount`, `shipping_cost`, `tax`, `total`, `payment_method`, `payment_status`, `order_status`, `tracking_number`, `shipped_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 'MIN20251216059C7C', 5, 'neinei', 'neinein@gmail.com', '08123456789101', 'jalan cempaka', 'jakarta', '12345', NULL, 550000.00, 0.00, 15000.00, 0.00, 510000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2025-12-16 03:57:20', '2025-12-16 03:57:20'),
(2, 'MIN202512163A29A5', 5, 'neinei', 'neinein@gmail.com', '08123456789101', 'jalan cempaka', 'jakarta', '12345', NULL, 378000.00, 0.00, 15000.00, 0.00, 355200.00, 'e_wallet', 'paid', 'delivered', NULL, NULL, '2025-12-16 05:07:10', '2025-12-16 05:03:15', '2025-12-16 05:07:10'),
(3, 'MIN20251218D4627C', 6, 'ayay', 'ayaytelor@gmail.com', '089765432145', 'jalan matahari no.7, Jakarta Timur', 'jakarta', '4567', NULL, 550000.00, 0.00, 15000.00, 0.00, 510000.00, 'bank_transfer', 'paid', 'delivered', 'TRK535479N7U', NULL, '2025-12-22 05:49:01', '2025-12-18 11:20:29', '2025-12-22 05:49:01'),
(4, 'MIN2025122042DF2F', 1, 'John Doe', 'user@minari.com', '08111222333', 'jalan melati', 'jakarta', '12345', NULL, 175000.00, 0.00, 15000.00, 0.00, 190000.00, 'bank_transfer', 'paid', 'delivered', 'TRK281030SQL', NULL, '2025-12-19 18:34:57', '2025-12-19 18:13:08', '2025-12-19 18:34:57'),
(5, 'MIN202512227C41AB', 1, 'John Doe', 'user@minari.com', '08111222333', 'jalan melati', 'jakarta', '12345', NULL, 189000.00, 0.00, 15000.00, 0.00, 204000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2025-12-21 18:19:35', '2025-12-21 18:19:35'),
(6, 'MIN202512227A5C98', 8, 'amoymoy', 'telor@minari.com', '089765432198', 'jalan rawamangun No.5, Jakarta Timur', 'Jakarta', '1122', NULL, 350000.00, 0.00, 15000.00, 0.00, 330000.00, 'cash_on_delivery', 'paid', 'delivered', 'TRK7991480KE', NULL, '2025-12-22 05:53:32', '2025-12-22 05:09:59', '2025-12-22 05:56:09'),
(7, 'MIN20251222A4A76E', 8, 'amoymoy', 'telor@minari.com', '089765432198', 'jalan rawamangun No.5, Jakarta Timur', 'Jakarta', '1122', NULL, 200000.00, 0.00, 15000.00, 0.00, 195000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2025-12-22 05:16:10', '2025-12-22 05:16:10'),
(8, 'MIN202512221019F9', 7, 'Linlin', 'linlin@minari.com', '081234567890', 'Jalan Cempaka No.3, Lembang', 'Bandung', '4567', NULL, 475000.00, 0.00, 15000.00, 0.00, 442500.00, 'bank_transfer', 'paid', 'delivered', 'TRK674009ZTP', NULL, '2025-12-22 05:34:40', '2025-12-22 05:33:05', '2025-12-22 05:34:40'),
(9, 'MIN202512226072FB', 7, 'Linlin', 'linlin@minari.com', '081234567890', 'Jalan Cempaka No.3, Lembang', 'Bandung', '4567', NULL, 450000.00, 0.00, 15000.00, 0.00, 412500.00, 'e_wallet', 'paid', 'delivered', 'TRK829623EPS', NULL, '2025-12-22 13:07:32', '2025-12-22 12:59:18', '2025-12-22 13:07:32'),
(10, 'MIN20251222FC51C9', 7, 'Linlin', 'linlin@minari.com', '081234567890', 'Jalan Cempaka No.3, Lembang', 'Bandung', '4567', NULL, 800000.00, 0.00, 15000.00, 0.00, 725000.00, 'bank_transfer', 'paid', 'shipped', 'TRK636044X15', '2025-12-22 13:04:11', NULL, '2025-12-22 13:03:11', '2025-12-22 13:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `size`, `color`, `created_at`, `updated_at`) VALUES
(1, 1, 53, 'Asymmetrical ruffle midi denim skirt', 275000.00, 2, 550000.00, NULL, NULL, '2025-12-16 03:57:20', '2025-12-16 03:57:20'),
(2, 2, 13, 'Blue sweater', 189000.00, 2, 378000.00, NULL, NULL, '2025-12-16 05:03:15', '2025-12-16 05:03:15'),
(3, 3, 1, 'Yellow shirt', 175000.00, 2, 350000.00, NULL, NULL, '2025-12-18 11:20:29', '2025-12-18 11:20:29'),
(4, 3, 25, 'Maroon bow sweater', 200000.00, 1, 200000.00, NULL, NULL, '2025-12-18 11:20:29', '2025-12-18 11:20:29'),
(5, 4, 1, 'Yellow shirt', 175000.00, 1, 175000.00, NULL, NULL, '2025-12-19 18:13:08', '2025-12-19 18:13:08'),
(6, 5, 13, 'Blue sweater', 189000.00, 1, 189000.00, NULL, NULL, '2025-12-21 18:19:35', '2025-12-21 18:19:35'),
(7, 6, 1, 'Yellow shirt', 175000.00, 2, 350000.00, NULL, NULL, '2025-12-22 05:09:59', '2025-12-22 05:09:59'),
(8, 7, 27, 'Puppy off-shoulder T-shirt', 200000.00, 1, 200000.00, NULL, NULL, '2025-12-22 05:16:10', '2025-12-22 05:16:10'),
(9, 8, 42, 'Pink sweatpants', 175000.00, 1, 175000.00, NULL, NULL, '2025-12-22 05:33:05', '2025-12-22 05:33:05'),
(10, 8, 76, 'Maroon Mary Jane Shoes', 300000.00, 1, 300000.00, NULL, NULL, '2025-12-22 05:33:05', '2025-12-22 05:33:05'),
(11, 9, 3, 'Choco blouse', 175000.00, 1, 175000.00, NULL, NULL, '2025-12-22 12:59:18', '2025-12-22 12:59:18'),
(12, 9, 46, 'Light blue flare jeans', 275000.00, 1, 275000.00, NULL, NULL, '2025-12-22 12:59:18', '2025-12-22 12:59:18'),
(13, 10, 2, 'Cherry white long sleeve shirt', 300000.00, 1, 300000.00, NULL, NULL, '2025-12-22 13:03:11', '2025-12-22 13:03:11'),
(14, 10, 60, 'Black mid-length dress', 250000.00, 2, 500000.00, NULL, NULL, '2025-12-22 13:03:11', '2025-12-22 13:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view products', 'web', '2025-12-14 23:59:15', '2025-12-14 23:59:15'),
(2, 'place orders', 'web', '2025-12-14 23:59:15', '2025-12-14 23:59:15'),
(3, 'write reviews', 'web', '2025-12-14 23:59:16', '2025-12-14 23:59:16'),
(4, 'manage wishlist', 'web', '2025-12-14 23:59:16', '2025-12-14 23:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `sold_count` int(11) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `discount_price`, `stock`, `sku`, `color`, `material`, `image`, `images`, `category_id`, `status`, `sold_count`, `view_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Yellow shirt', 'yellow-shirt', 'Yellow Shirt hadir dengan desain simpel dan modern yang cocok untuk berbagai aktivitas. Warna kuning yang fresh memberikan kesan cerah dan stylish, mudah dipadukan dengan berbagai bawahan untuk tampilan kasual maupun semi-formal.', 175000.00, NULL, 70, NULL, NULL, NULL, 'products/BApoVHj5vQrqe7nGbFOUg1cNpJ7mRseWpnWINZmg.jpg', NULL, 1, 'active', 0, 4, '2025-12-15 01:04:11', '2025-12-22 05:09:59', NULL),
(2, 'Cherry white long sleeve shirt', 'cherry-white-long-sleeve-shirt', 'Cherry White Long Sleeve Shirt hadir dengan desain clean dan elegan yang memberikan kesan fresh dan timeless. Warna putih yang lembut dipadukan dengan detail cherry yang manis, menciptakan tampilan feminin dan stylish tanpa terlihat berlebihan.', 300000.00, NULL, 33, NULL, NULL, NULL, 'products/Q3gqYJRTXnXfQNax9Lv8pmpOPS6vL7CkaaebEm8O.jpg', NULL, 1, 'active', 0, 1, '2025-12-15 01:09:48', '2025-12-22 13:03:11', NULL),
(3, 'Choco blouse', 'choco-blouse', 'Choco Blouse hadir dengan warna cokelat yang hangat dan elegan, memberikan kesan simple namun tetap stylish. Desainnya yang clean membuat blouse ini mudah dipadukan dengan berbagai bawahan untuk tampilan kasual hingga semi-formal.', 175000.00, NULL, 19, NULL, NULL, NULL, 'products/gnKLavxqmleau4InItapvFs8dJrIjfNCTTsIYKV2.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:11:32', '2025-12-22 12:59:18', NULL),
(4, 'Blue shirt', 'blue-shirt', 'Blue Shirt hadir dengan desain simpel dan timeless yang mudah dipadukan untuk berbagai gaya. Warna biru yang clean memberikan kesan segar dan rapi, cocok untuk tampilan kasual maupun semi-formal.', 175000.00, NULL, 12, NULL, NULL, NULL, 'products/RxmUoyRTd4t5SRSH1KmYwEh4ZPHDjzlI528gLyvq.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:15:16', '2025-12-15 01:15:53', NULL),
(5, 'White blouse', 'white-blouse', 'White Blouse hadir dengan desain simpel dan elegan yang memberikan kesan bersih dan timeless. Warna putih yang klasik membuat blouse ini mudah dipadukan dengan berbagai bawahan, cocok untuk tampilan kasual hingga semi-formal.', 200000.00, NULL, 47, NULL, NULL, NULL, 'products/wdPWKHycQFBUw2ZTuDyCWUPVt97rIA2OXZHumGEb.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:18:08', '2025-12-15 01:18:36', NULL),
(6, 'Blue linen roll-up sleeve shirt', 'blue-linen-roll-up-sleeve-shirt', 'Blue Linen Roll-Up Sleeve Shirt menghadirkan desain kasual yang clean dengan sentuhan natural. Terbuat dari bahan linen yang ringan dan breathable, kemeja ini memberikan kenyamanan maksimal dan cocok digunakan di berbagai aktivitas, terutama di cuaca hangat.', 200000.00, NULL, 50, NULL, NULL, NULL, 'products/g6iYbijM9muBRGnWJybHNBzORBFwc2WcEQuDO4LY.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:19:56', '2025-12-15 01:20:10', NULL),
(7, 'Stripped cream long sleeve shirt', 'stripped-cream-long-sleeve-shirt', 'Striped Cream Long Sleeve Shirt hadir dengan motif garis klasik dan warna cream yang lembut, memberikan kesan clean, elegan, dan timeless. Desainnya cocok untuk kamu yang menyukai gaya simpel namun tetap stylish.', 200000.00, NULL, 125, NULL, NULL, NULL, 'products/bTABnbu0bS31wLfKSPYTwgrAsmZenRAxfCSzix7S.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:23:28', '2025-12-15 01:23:28', NULL),
(8, 'Soft brown long sleeve blouse', 'soft-brown-long-sleeve-blouse', 'Soft Brown Long Sleeve Blouse hadir dengan warna cokelat lembut yang memberikan kesan hangat dan elegan. Desainnya yang simpel dan feminin membuat blouse ini mudah dipadukan untuk berbagai gaya, dari kasual hingga semi-formal.', 300000.00, NULL, 67, NULL, NULL, NULL, 'products/1hKGUDjOfLuO9uBKmT2Ai5IAeRO05hBDHNeQXVY9.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:25:23', '2025-12-15 01:25:23', NULL),
(9, 'Yellow with blue ribbon blouse', 'yellow-with-blue-ribbon-blouse', 'Yellow with Blue Ribbon Blouse hadir dengan warna kuning cerah yang fresh, dipadukan dengan detail pita biru yang manis dan eye-catching. Kombinasi warna ini memberikan kesan playful namun tetap elegan, cocok untuk tampilan yang standout tanpa berlebihan.', 340000.00, NULL, 14, NULL, NULL, NULL, 'products/QxS6gyj7Gr6WhgYbeNZNFqDNLJhYAsSh2nF7ibaK.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:28:37', '2025-12-15 01:28:37', NULL),
(10, 'Pink baloon shirt', 'pink-baloon-shirt', 'Pink Balloon Shirt hadir dengan warna pink lembut dan potongan balloon yang memberikan siluet unik serta feminin. Desainnya menciptakan tampilan yang playful namun tetap stylish, cocok untuk kamu yang ingin tampil standout dengan cara yang effortless.', 220000.00, NULL, 32, NULL, NULL, NULL, 'products/YkkLL3sy4to5rNIvpvVFYfXxweEC4wyJfYFU2V9o.jpg', NULL, 1, 'active', 0, 3, '2025-12-15 01:30:04', '2025-12-19 18:10:08', NULL),
(11, 'Green jeans crop blouse', 'green-jeans-crop-blouse', 'Green Jeans Crop Blouse hadir dengan desain modern dan edgy yang memadukan warna hijau segar dengan material jeans yang trendi. Potongan crop memberikan siluet stylish dan youthful, cocok untuk tampilan kasual yang standout.', 250000.00, NULL, 8, NULL, NULL, NULL, 'products/hmxzKlWHJ7DneqWjvZ4RBcKtxdm02XJ1H4PF5EWR.jpg', NULL, 1, 'active', 0, 2, '2025-12-15 01:31:20', '2025-12-15 01:36:33', NULL),
(12, 'Pink long sleeve blouse', 'pink-long-sleeve-blouse', 'Pink Long Sleeve Blouse hadir dengan warna pink lembut yang memberikan kesan feminin dan anggun. Desainnya yang simpel dan timeless membuat blouse ini mudah dipadukan untuk berbagai tampilan, dari kasual hingga semi-formal.', 370000.00, NULL, 17, NULL, NULL, NULL, 'products/4HMOZrGUINZzcVXnXBnkGL1EOHF8J4BFug9y7Iel.jpg', NULL, 1, 'active', 0, 0, '2025-12-15 01:32:47', '2025-12-15 01:32:47', NULL),
(13, 'Blue sweater', 'blue-sweater', 'Blue Sweater hadir dengan desain simpel dan modern yang memberikan kesan clean dan stylish. Warna biru yang menenangkan membuat sweater ini mudah dipadukan dengan berbagai outfit untuk tampilan kasual hingga smart casual.', 189000.00, NULL, 15, NULL, NULL, NULL, 'products/AIjAFU539Hj0gD2W0IOx3SyPBaun6clP8fbWplP8.jpg', NULL, 3, 'active', 0, 4, '2025-12-15 01:39:54', '2025-12-21 18:19:35', NULL),
(14, 'White crop fleece jacket', 'white-crop-fleece-jacket', 'White Crop Fleece Jacket hadir dengan desain crop yang modern dan stylish, memberikan tampilan clean sekaligus trendy. Warna putih yang minimalis membuat jaket ini mudah dipadukan dengan berbagai outfit untuk gaya kasual yang fresh.', 250000.00, NULL, 23, NULL, NULL, NULL, 'products/voUNyEAISKq8cqyH8C8Qwr0GEe3ZhQq6pTV22E7e.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 01:41:09', '2025-12-15 01:41:09', NULL),
(15, 'Offwhite oversized cardigan', 'offwhite-oversized-cardigan', 'Off-White Oversized Cardigan hadir dengan siluet oversized yang cozy dan stylish, memberikan kesan santai namun tetap modern. Warna off-white yang soft dan netral membuat cardigan ini mudah dipadukan dengan berbagai outfit untuk tampilan effortless.', 250000.00, NULL, 43, NULL, NULL, NULL, 'products/PqDiRMam1o8uN7Xq6yeyJyLqXYqWQkqHv7o2LLzx.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 01:42:21', '2025-12-15 01:42:21', NULL),
(16, 'Stripped cream sweater', 'stripped-cream-sweater', 'Striped Cream Sweater hadir dengan motif garis klasik dan warna cream yang lembut, memberikan kesan hangat, clean, dan timeless. Desainnya cocok untuk tampilan kasual yang tetap stylish dan effortless.', 200000.00, NULL, 34, NULL, NULL, NULL, 'products/aKglgU80TWKj0aUM1llrSe6RTUbUfWbqVuRkHhN5.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 01:43:35', '2025-12-15 01:43:35', NULL),
(18, 'Striped Cream and Grey Sweater', 'striped-cream-and-grey-sweater', 'Striped Cream and Grey Sweater hadir dengan perpaduan warna cream dan grey yang soft serta motif stripe klasik, menciptakan tampilan clean dan timeless. Desainnya memberikan kesan hangat dan modern, cocok untuk gaya kasual yang effortless.', 200000.00, NULL, 26, NULL, NULL, NULL, 'products/lzKMW1L9lfusU0lzayHr9A4i8NGbJgwURlF2fsuu.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 01:52:07', '2025-12-15 02:04:24', '2025-12-15 02:04:24'),
(19, 'Dark blue cardigan', 'dark-blue-cardigan', 'Dark Blue Cardigan hadir dengan desain simpel dan elegan yang memberikan kesan klasik dan versatile. Warna biru tua yang deep membuat cardigan ini mudah dipadukan dengan berbagai outfit, cocok untuk tampilan kasual hingga smart casual.', 300000.00, NULL, 26, NULL, NULL, NULL, 'products/HtfBwvE5JhQmpGj3VBGy1P2HbvanUOdzNKzwmyN0.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 02:01:28', '2025-12-15 02:01:28', NULL),
(20, 'Soft green cardigan', 'soft-green-cardigan', 'Soft Green Cardigan hadir dengan warna hijau lembut yang menenangkan dan memberikan kesan fresh. Desainnya yang simpel dan timeless membuat cardigan ini mudah dipadukan dengan berbagai outfit untuk tampilan kasual yang effortless.', 250000.00, NULL, 21, NULL, NULL, NULL, 'products/qMvqfeWwjeI79OwGCUhQhpSRuzOLSdicbB6Op9IR.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 02:04:08', '2025-12-15 02:04:08', NULL),
(21, 'Dark green fuzzy knit cardigan', 'dark-green-fuzzy-knit-cardigan', 'Dark Green Fuzzy Knit Cardigan hadir dengan warna hijau tua yang elegan dan tekstur fuzzy knit yang lembut, memberikan kesan hangat sekaligus stylish. Desainnya yang cozy dan modern membuat cardigan ini sempurna untuk melengkapi gaya kasual hingga smart casual.', 300000.00, NULL, 30, NULL, NULL, NULL, 'products/pOLZVyu3GR4rkciKQ4scpkj1lkkZuxcGrDP1gEGf.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 02:05:34', '2025-12-15 02:05:34', NULL),
(22, 'Tiger lily fleece jacket', 'tiger-lily-fleece-jacket', 'Tiger Lily Fleece Jacket hadir dengan warna tiger lily yang hangat dan bold, memberikan tampilan standout namun tetap cozy. Desainnya yang modern membuat jaket ini cocok untuk gaya kasual sehari-hari dengan sentuhan statement yang stylish.', 270000.00, NULL, 22, NULL, NULL, NULL, 'products/HUO7itIHWcbwTTS4BMkpkFDgIOltxNtkxz0vxrzv.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 02:07:20', '2025-12-15 02:07:20', NULL),
(23, 'Cherry white fleece jacket', 'cherry-white-fleece-jacket', 'Cherry White Fleece Jacket hadir dengan warna putih bersih yang dipadukan dengan sentuhan cherry yang manis, menciptakan tampilan fresh dan playful. Desainnya memberikan kesan cozy namun tetap stylish, cocok untuk melengkapi gaya kasual sehari-hari.', 250000.00, NULL, 17, NULL, NULL, NULL, 'products/Z3BMbqUcSNqIA3zs9R4AcAGf8JKaG97SJ5zmAlPd.jpg', NULL, 3, 'active', 0, 1, '2025-12-15 02:08:32', '2025-12-15 16:49:13', NULL),
(24, 'Baby pink bow oversized sweater', 'baby-pink-bow-oversized-sweater', 'Baby Pink Bow Oversized Sweater hadir dengan warna baby pink yang lembut dan detail pita (bow) yang manis, menciptakan tampilan feminin dan cozy. Siluet oversized memberikan kesan santai namun tetap stylish, cocok untuk kamu yang menyukai gaya cute dan effortless.', 220000.00, NULL, 24, NULL, NULL, NULL, 'products/JM6fmLetxti9H68Cx4RBxzsOtiWPVBmsJEk4vJPP.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 02:09:25', '2025-12-15 02:09:25', NULL),
(25, 'Maroon bow sweater', 'maroon-bow-sweater', 'Maroon Bow Sweater hadir dengan warna maroon yang elegan dan detail pita (bow) yang manis, menciptakan perpaduan antara kesan classy dan feminin. Desainnya memberikan tampilan stylish yang tetap hangat dan nyaman.', 200000.00, NULL, 31, NULL, NULL, NULL, 'products/BXY7hhRpXePss0KXpdspGMGRjcuDRoOpCjO1hO0j.jpg', NULL, 3, 'active', 0, 5, '2025-12-15 02:10:26', '2025-12-22 12:21:29', NULL),
(26, 'Heart rabit fleece jacket', 'heart-rabit-fleece-jacket', 'Heart Rabbit Fleece Jacket hadir dengan desain manis dan playful, menampilkan detail heart dan rabbit yang menggemaskan. Jaket ini memberikan tampilan cute dan cozy, cocok untuk kamu yang menyukai gaya kasual dengan sentuhan fun.', 300000.00, NULL, 14, NULL, NULL, NULL, 'products/nO8vfuP1HEgZin3YwBaNZ6LP6NSrsUVpfUfYnYN5.jpg', NULL, 3, 'active', 0, 0, '2025-12-15 02:11:23', '2025-12-15 02:11:23', NULL),
(27, 'Puppy off-shoulder T-shirt', 'puppy-off-shoulder-t-shirt', 'Puppy Off-Shoulder T-Shirt hadir dengan desain off-shoulder yang trendy dan detail puppy yang menggemaskan. Perpaduan ini menciptakan tampilan playful namun tetap stylish, cocok untuk kamu yang ingin tampil santai dengan sentuhan cute.', 200000.00, NULL, 11, NULL, NULL, NULL, 'products/ewXebTM7YkzNYjmZ6WF6x4Ix5d8oBr9EJFvE6RYe.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:13:11', '2025-12-22 05:16:10', NULL),
(28, 'Black cat striped pink oversized T-shirt', 'black-cat-striped-pink-oversized-t-shirt', 'Black Cat Striped Pink Oversized T-Shirt hadir dengan desain playful yang memadukan warna pink lembut, motif stripe, dan ilustrasi black cat yang menggemaskan. Potongan oversized memberikan tampilan santai dan trendy, cocok untuk gaya kasual yang fun dan effortless.', 220000.00, NULL, 17, NULL, NULL, NULL, 'products/r4IoOc6gJ1bPvLRKyV0ggUwGluhKYQa9xPUiYWqm.jpg', NULL, 4, 'active', 0, 1, '2025-12-15 02:14:25', '2025-12-16 03:43:15', NULL),
(29, 'Grandma pups pink T-shirt', 'grandma-pups-pink-t-shirt', 'Grandma Pups Pink T-Shirt hadir dengan warna pink lembut dan ilustrasi pups bergaya grandma yang unik dan menggemaskan. Desainnya memberikan kesan playful dan nostalgic, cocok untuk kamu yang suka tampil cute dengan sentuhan karakter.', 167000.00, NULL, 56, NULL, NULL, NULL, 'products/bWSwBZuIaM3Pj838nL3a7Ahizj7Ms9dzUQXSUYrf.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:15:59', '2025-12-15 02:15:59', NULL),
(30, 'Green apple long sleeve T-shirt', 'green-apple-long-sleeve-t-shirt', 'Green Apple Long Sleeve T-Shirt hadir dengan warna hijau segar dan desain simpel yang memberikan kesan fresh dan youthful. Potongan lengan panjang membuat T-shirt ini cocok untuk tampilan kasual yang nyaman sekaligus stylish.', 135000.00, NULL, 42, NULL, NULL, NULL, 'products/eheZYPQAwIhhnZNvJZTQdCzezHeL4CbDQGLX9HY0.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:17:14', '2025-12-15 02:17:14', NULL),
(31, 'White pearl crop T-shirt', 'white-pearl-crop-t-shirt', 'White Pearl Crop T-Shirt hadir dengan desain crop yang modern dan sentuhan detail pearl yang elegan. Warna putih yang clean dipadukan dengan aksen mutiara memberikan kesan feminin dan chic, cocok untuk tampilan kasual yang tetap standout.', 270000.00, NULL, 28, NULL, NULL, NULL, 'products/E6pSy96YEafkKyycl75w4Sn6XxFgAF8SeZujq2Qz.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:18:11', '2025-12-15 02:18:11', NULL),
(32, 'Stripped green polo fitted shirt', 'stripped-green-polo-fitted-shirt', 'Striped Green Polo Fitted Shirt hadir dengan motif garis klasik dan warna hijau segar yang memberikan tampilan sporty sekaligus rapi. Potongan fitted menonjolkan siluet tubuh dengan pas, cocok untuk kamu yang menyukai gaya clean dan modern.', 200000.00, NULL, 21, NULL, NULL, NULL, 'products/hq0XRL2ud6I0IOTLI9WKE0W0aGc1taywBxZZYh1S.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:20:05', '2025-12-15 02:20:05', NULL),
(33, 'Cream polo shirt', 'cream-polo-shirt', 'Cream Polo Shirt hadir dengan warna cream yang lembut dan desain klasik yang timeless. Memberikan tampilan rapi namun tetap santai, polo shirt ini cocok untuk berbagai aktivitas, dari kasual hingga smart casual.', 150000.00, NULL, 12, NULL, NULL, NULL, 'products/WmWnTAOOIFROfIGBwJw8WnQWVT4Zhv2XDaCSqTvw.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:21:27', '2025-12-15 02:21:27', NULL),
(34, 'Baby pink polo shirt', 'baby-pink-polo-shirt', 'Baby Pink Polo Shirt hadir dengan warna baby pink yang lembut dan memberikan kesan fresh serta modern. Desain polo yang klasik dipadukan dengan warna pastel menciptakan tampilan rapi namun tetap santai.', 150000.00, NULL, 40, NULL, NULL, NULL, 'products/eeRiSKi4py477FbGKgEZ01JrtriGnmlXzTVQL19v.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:23:03', '2025-12-15 02:23:03', NULL),
(35, 'White knitted polo shirt', 'white-knitted-polo-shirt', 'White Knitted Polo Shirt hadir dengan desain klasik yang dipadukan dengan tekstur rajut yang elegan. Warna putih yang clean memberikan kesan rapi dan timeless, cocok untuk tampilan kasual hingga smart casual.', 250000.00, NULL, 33, NULL, NULL, NULL, 'products/tGkHq3lER2KITW9vsGkpyfC3aZLTDIycTxC4oG5b.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:24:11', '2025-12-15 02:24:11', NULL),
(36, 'Cream long sleeve T-shirt', 'cream-long-sleeve-t-shirt', 'Cream Long Sleeve T-Shirt hadir dengan warna cream yang lembut dan desain simpel yang timeless. Potongan lengan panjang memberikan tampilan kasual yang clean sekaligus nyaman untuk berbagai aktivitas.', 200000.00, NULL, 12, NULL, NULL, NULL, 'products/mFkLpAsFEFCA1pDDNWPLYHrczlasOSZCCYUArK5j.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:25:17', '2025-12-15 02:25:17', NULL),
(37, 'Dark blue babydoll T-shirt', 'dark-blue-babydoll-t-shirt', 'Dark Blue Babydoll T-Shirt hadir dengan potongan babydoll yang feminin dan nyaman, memberikan siluet flowy yang manis dan effortless. Warna dark blue yang elegan membuat T-shirt ini terlihat clean dan mudah dipadukan untuk berbagai gaya kasual.', 175000.00, NULL, 10, NULL, NULL, NULL, 'products/LOKo3IOkU0OgKn8jFJLnZ7ZfOg9ZIgzA5mkik1ut.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:26:16', '2025-12-15 02:26:16', NULL),
(38, 'Stripped pink long sleeve polo', 'stripped-pink-long-sleeve-polo', 'Striped Pink Long Sleeve Polo hadir dengan motif garis klasik dan warna pink lembut yang memberikan kesan fresh dan feminin. Model polo berlengan panjang menciptakan tampilan rapi namun tetap santai, cocok untuk gaya kasual hingga smart casual.', 145000.00, NULL, 14, NULL, NULL, NULL, 'products/iJBOkWSZUF3qbwz52rpbheC8a6Ut4Pu2JeDGR75T.jpg', NULL, 4, 'active', 0, 0, '2025-12-15 02:27:14', '2025-12-15 02:27:14', NULL),
(39, 'High-Waist Brown', 'high-waist-brown', 'High-Waist Brown Culottes hadir dengan potongan high-waist yang memberikan siluet ramping dan tampilan elegan. Warna cokelat yang hangat dan netral membuat celana ini mudah dipadukan dengan berbagai atasan untuk gaya kasual hingga semi-formal.', 250000.00, NULL, 40, NULL, NULL, NULL, 'products/uV4kNUl5iu2jVAQHdIWVx1UteQkjDaG4gmjrizQX.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:28:39', '2025-12-15 02:28:39', NULL),
(40, 'Cream trousers', 'cream-trousers', 'Cream Trousers hadir dengan warna cream yang lembut dan elegan, memberikan tampilan clean dan timeless. Potongan yang rapi membuat trousers ini cocok untuk berbagai gaya, dari kasual hingga semi-formal.', 200000.00, NULL, 32, NULL, NULL, NULL, 'products/4UTxeV8jivwABhS2ZGLs4oprO7crZeqHePEGzRGZ.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:29:51', '2025-12-15 02:29:51', NULL),
(41, 'Bone white stripped jeans', 'bone-white-stripped-jeans', 'Bone White Striped Jeans hadir dengan warna bone white yang clean dan motif stripe yang memberikan sentuhan modern. Desainnya menciptakan tampilan kasual yang fresh namun tetap stylish, cocok untuk berbagai gaya sehari-hari.', 250000.00, NULL, 23, NULL, NULL, NULL, 'products/JX2z69faCxK6oXDhzR42fJwZajNSjdLTqAYYXp3M.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:31:08', '2025-12-15 02:31:08', NULL),
(42, 'Pink sweatpants', 'pink-sweatpants', 'Pink Sweatpants hadir dengan warna pink yang lembut dan memberikan kesan fun serta cozy. Desainnya yang santai menjadikan sweatpants ini pilihan tepat untuk aktivitas kasual, homewear, maupun hangout dengan gaya yang nyaman.', 175000.00, NULL, 53, NULL, NULL, NULL, 'products/tCZpnmbYrBgPzIMqoX9udj7hMKLTVoKuOawVGlLV.jpg', NULL, 5, 'active', 0, 2, '2025-12-15 02:32:20', '2025-12-22 06:38:27', NULL),
(43, 'Cream Dream T-shirt', 'cream-dream-t-shirt', 'Cream Dream T-Shirt hadir dengan warna cream yang lembut dan desain minimalis, memberikan kesan calm, clean, dan timeless. T-shirt ini cocok untuk kamu yang menyukai gaya kasual yang simple namun tetap stylish.', 200000.00, NULL, 0, NULL, NULL, NULL, 'products/67kRxZ5ZgvRpH3T6HsLSBFK066vbTMvvJifbSuPV.png', NULL, 4, 'active', 0, 0, '2025-12-15 02:34:18', '2025-12-15 02:34:18', NULL),
(44, 'Culotte Pants', 'culotte-pants', 'Culotte Pants hadir dengan potongan lebar yang memberikan siluet modern dan nyaman. Desainnya yang versatile membuat celana ini mudah dipadukan untuk berbagai gaya, dari kasual hingga semi-formal.', 220000.00, NULL, 1, NULL, NULL, NULL, 'products/Bko7lfSEJfx58wxWJO50lENPQOJsqHIrqBbdhhLJ.png', NULL, 5, 'active', 0, 6, '2025-12-15 02:35:53', '2025-12-18 07:21:35', '2025-12-18 07:21:35'),
(45, 'White jeans', 'white-jeans', 'White Jeans hadir dengan warna putih yang clean dan timeless, memberikan tampilan segar dan modern. Desainnya yang simpel membuat jeans ini mudah dipadukan dengan berbagai atasan untuk gaya kasual hingga semi-formal.', 200000.00, NULL, 17, NULL, NULL, NULL, 'products/JL1UmOUD73Wzi4CTlEEvjlhEAfkGTXy6ObQQZJTt.jpg', NULL, 5, 'active', 0, 1, '2025-12-15 02:41:35', '2025-12-18 10:20:40', NULL),
(46, 'Light blue flare jeans', 'light-blue-flare-jeans', 'Light Blue Flare Jeans hadir dengan warna biru muda yang fresh dan potongan flare yang stylish. Desainnya memberikan siluet kaki yang lebih jenjang dan tampilan retro-modern yang tetap trendi.', 275000.00, NULL, 33, NULL, NULL, NULL, 'products/bUrRH2FSLCOIrJthkU7AZxRgQCVDA1wg41RODbm0.jpg', NULL, 5, 'active', 0, 2, '2025-12-15 02:42:51', '2025-12-22 13:10:17', NULL),
(47, 'Dark blue low rise flare jeans', 'dark-blue-low-rise-flare-jeans', 'Dark Blue Low-Rise Flare Jeans hadir dengan warna biru tua yang bold dan potongan flare yang memberikan kesan retro namun tetap modern. Desain low-rise menciptakan tampilan edgy dan trendy, cocok untuk kamu yang ingin tampil standout dengan gaya kasual.', 300000.00, NULL, 22, NULL, NULL, NULL, 'products/QtXvPj6arwZxDuswUQ8gIo144hkTudpDxsxJUMXS.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:44:09', '2025-12-15 02:44:09', NULL),
(48, 'Light blue straight jeans', 'light-blue-straight-jeans', 'Light Blue Straight Jeans hadir dengan warna biru muda yang fresh dan potongan straight yang timeless. Desainnya memberikan tampilan clean dan versatile, cocok untuk berbagai gaya kasual hingga smart casual.', 225000.00, NULL, 7, NULL, NULL, NULL, 'products/WZ7t1x7JBtCLExKjDlLTrF4OXnASyuAdKp4Hn7jB.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:45:08', '2025-12-15 02:45:08', NULL),
(49, 'Dark blue short jeans', 'dark-blue-short-jeans', 'Dark Blue Short Jeans hadir dengan warna biru tua yang klasik dan desain simpel yang timeless. Potongan pendek memberikan tampilan kasual yang fresh dan nyaman, cocok untuk aktivitas santai maupun hangout.', 250000.00, NULL, 19, NULL, NULL, NULL, 'products/PNeJtvVqcgtGrViLNNnId62oDP6l303ZibPwVpTC.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:46:18', '2025-12-15 02:46:18', NULL),
(50, 'Black short pants', 'black-short-pants', 'Black Short Pants hadir dengan warna hitam yang klasik dan desain simpel yang versatile. Potongan pendek memberikan kenyamanan dan tampilan kasual yang clean, cocok untuk berbagai aktivitas santai.', 175000.00, NULL, 11, NULL, NULL, NULL, 'products/CckHKblr1EXa9RtmgManOMXjQS8acktskkoogeDt.jpg', NULL, 5, 'active', 0, 1, '2025-12-15 02:47:23', '2025-12-22 05:28:04', NULL),
(51, 'White sweatpants', 'white-sweatpants', 'White Sweatpants hadir dengan warna putih yang clean dan memberikan kesan fresh serta cozy. Desainnya yang santai membuat sweatpants ini cocok untuk aktivitas kasual, homewear, hingga hangout dengan tampilan yang nyaman dan stylish.', 175000.00, NULL, 45, NULL, NULL, NULL, 'products/wiMhgAkGnydlgXBKXuJ2cjZgXp5MqTaE6TF41C2M.jpg', NULL, 5, 'active', 0, 0, '2025-12-15 02:48:40', '2025-12-15 02:48:40', NULL),
(52, 'Highwaist black trousers', 'highwaist-black-trousers', 'High-Waist Black Trousers hadir dengan potongan high-waist yang memberikan siluet ramping dan tampilan elegan. Warna hitam yang klasik membuat trousers ini mudah dipadukan dengan berbagai atasan untuk gaya kasual hingga formal.', 200000.00, NULL, 5, NULL, NULL, NULL, 'products/XQBS271maO7LsK2pG6ujFexx1EcKg4H9XZAlQeAc.jpg', NULL, 5, 'active', 0, 1, '2025-12-15 02:49:45', '2025-12-15 02:52:33', NULL),
(53, 'Asymmetrical ruffle midi denim skirt', 'asymmetrical-ruffle-midi-denim-skirt', 'Asymmetrical Ruffle Midi Denim Skirt hadir dengan desain unik yang memadukan potongan asimetris dan detail ruffle feminin. Bahan denim memberikan kesan kasual yang modern, sementara siluet midi menciptakan tampilan elegan dan stylish.', 275000.00, NULL, 42, NULL, NULL, NULL, 'products/MakSh9pATqnB17RTxBFJ95E9KbhoDZegFVkDlgEc.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 02:54:39', '2025-12-16 03:57:20', NULL),
(54, 'Polka brown midi dress', 'polka-brown-midi-dress', 'Polka Brown Midi Dress hadir dengan motif polka dot klasik yang dipadukan dengan warna cokelat hangat, menciptakan tampilan feminin dan timeless. Panjang midi memberikan kesan anggun dan elegan, cocok untuk berbagai kesempatan.', 220000.00, NULL, 26, NULL, NULL, NULL, 'products/T6wrJSQR0Aig08cxIwuBhKAsYWCuVlzZFvgSOVrb.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 02:55:24', '2025-12-15 02:56:08', NULL),
(55, 'Ivory tweed flare maxi skirt', 'ivory-tweed-flare-maxi-skirt', 'Ivory Tweed Flare Maxi Skirt hadir dengan material tweed bertekstur elegan dan warna ivory yang lembut, menciptakan tampilan classy dan timeless. Siluet flare dengan panjang maxi memberikan kesan anggun sekaligus flowy saat dikenakan.', 300000.00, NULL, 77, NULL, NULL, NULL, 'products/3SU4gSMU0g86Q4ZWwM5ZRhfjvybPJ93dJnRxyUZq.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 03:00:23', '2025-12-15 03:00:23', NULL),
(56, 'White Woven Pleated Midaxi Skirt', 'white-woven-pleated-midaxi-skirt', 'White Woven Pleated Midaxi Skirt hadir dengan desain pleated yang rapi dan material woven berkualitas, menciptakan tampilan clean dan elegan. Warna putih yang timeless memberikan kesan anggun dan mudah dipadukan untuk berbagai gaya.', 200000.00, NULL, 9, NULL, NULL, NULL, 'products/x8O0mso520P1fhj02FZzCQkg0Xu7mROg0p22J9A2.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 03:01:55', '2025-12-15 03:01:55', NULL),
(57, 'Tartan maxi skirt', 'tartan-maxi-skirt', 'Tartan Maxi Skirt hadir dengan motif tartan klasik yang timeless dan penuh karakter. Panjang maxi memberikan siluet anggun, sementara pola kotak menambah sentuhan statement yang stylish dan modern.', 200000.00, NULL, 35, NULL, NULL, NULL, 'products/F4VbV8JC5wRrPG0AaVVEacVog0OOoKWdpJuKoCIV.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 03:57:11', '2025-12-15 03:57:11', NULL),
(58, 'Floral white maxi skirt', 'floral-white-maxi-skirt', 'Floral White Maxi Skirt hadir dengan warna putih yang bersih dan motif floral yang lembut, menciptakan tampilan feminin dan anggun. Panjang maxi memberikan siluet flowy yang cantik dan nyaman saat dikenakan.', 200000.00, NULL, 15, NULL, NULL, NULL, 'products/yLMB8vw7UqrnfgU6NdigP3WPw4CifFDUfVI1sTzj.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 03:59:35', '2025-12-15 03:59:35', NULL),
(59, 'Puff sleeve floral dress', 'puff-sleeve-floral-dress', 'Puff Sleeve Floral Dress hadir dengan motif floral yang manis dan detail puff sleeve yang feminin. Desainnya memberikan kesan anggun dan romantic, cocok untuk kamu yang ingin tampil stylish dengan sentuhan klasik.', 250000.00, NULL, 8, NULL, NULL, NULL, 'products/I5rdFlyzKqo1wnduXMnBkaaCY14eevdgDmrjp0iW.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 04:01:17', '2025-12-15 04:01:17', NULL),
(60, 'Black mid-length dress', 'black-mid-length-dress', 'Black Mid-Length Dress hadir dengan desain simpel dan elegan yang timeless. Warna hitam klasik memberikan kesan anggun dan mudah dipadukan untuk berbagai kesempatan, dari kasual hingga semi-formal.', 250000.00, NULL, 43, NULL, NULL, NULL, 'products/Z58XNgH4jkX3LEWEYvdodER5Xlf7ixz2khrjg1Un.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 04:02:46', '2025-12-22 13:03:11', NULL),
(61, 'A-line denim maxi skirt', 'a-line-denim-maxi-skirt', 'A-Line Denim Maxi Skirt hadir dengan siluet A-line yang klasik dan flattering, memberikan tampilan ramping sekaligus nyaman. Bahan denim menambah kesan kasual yang timeless, sementara panjang maxi menciptakan look yang elegan dan modern.', 250000.00, NULL, 68, NULL, NULL, NULL, 'products/xFof2mL0rAcclbyhYz8IS1DnmBgBCU8nyptC5R9A.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 04:07:26', '2025-12-15 04:07:26', NULL),
(62, 'Pinafore cream dress', 'pinafore-cream-dress', 'Pinafore Cream Dress hadir dengan warna cream yang lembut dan desain pinafore yang timeless. Memberikan tampilan manis dan clean, dress ini cocok untuk gaya kasual yang tetap feminin dan stylish.', 275000.00, NULL, 47, NULL, NULL, NULL, 'products/e5kCVylh5uwP5QIAH5udiWXnOmpKj0H0zlBB9gwd.jpg', NULL, 6, 'active', 0, 1, '2025-12-15 04:09:01', '2025-12-15 16:52:08', NULL),
(63, 'Rose linen dress', 'rose-linen-dress', 'Rose Linen Dress hadir dengan warna rose yang lembut dan feminin, dipadukan dengan bahan linen yang ringan dan breathable. Desainnya memberikan tampilan fresh dan elegan, cocok untuk cuaca hangat maupun aktivitas sehari-hari.', 275000.00, NULL, 19, NULL, NULL, NULL, 'products/CbjeOLM52I7L37NKmzgP194QupvE7j1UPI5SHJsm.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 04:10:13', '2025-12-15 04:10:13', NULL),
(64, 'Yellow floral dress', 'yellow-floral-dress', 'Yellow Floral Dress hadir dengan warna kuning cerah dan motif floral yang manis, menciptakan tampilan fresh dan feminin. Desainnya memberikan kesan ceria dan anggun, cocok untuk berbagai suasana.', 250000.00, NULL, 17, NULL, NULL, NULL, 'products/96b7w97X3z5yrlqbVOJ0y2FlMUbnlWyYmJSugvvR.jpg', NULL, 6, 'active', 0, 0, '2025-12-15 04:11:13', '2025-12-15 04:11:13', NULL),
(65, 'Crochet lace bonnet', 'crochet-lace-bonnet', 'Crochet Lace Bonnet hadir dengan detail rajut crochet dan lace yang halus, menciptakan tampilan klasik, feminin, dan elegan. Desainnya memberikan sentuhan vintage yang manis, cocok sebagai aksesori pelengkap outfit.', 75000.00, NULL, 14, NULL, NULL, NULL, 'products/kTyNPsydfmyXf0ED9e0vbYO0RooJPxcGZqJ0VWeq.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:25:27', '2025-12-15 04:25:27', NULL),
(66, 'Floral pink organza shawl', 'floral-pink-organza-shawl', 'Floral Pink Organza Shawl hadir dengan warna pink lembut dan motif floral yang anggun, memberikan sentuhan feminin dan elegan pada setiap tampilan. Material organza yang ringan dan transparan menciptakan efek flowy yang cantik saat dikenakan.', 150000.00, NULL, 72, NULL, NULL, NULL, 'products/M5r5rRdbQtsnHuAs1x9gnrav34Hq8E4eeon0REga.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:26:54', '2025-12-15 04:26:54', NULL),
(67, 'Floral baby pink scarf', 'floral-baby-pink-scarf', 'Floral Baby Pink Scarf hadir dengan warna baby pink yang lembut dan motif floral yang manis, menciptakan tampilan feminin dan fresh. Desainnya memberikan sentuhan anggun yang mudah melengkapi berbagai outfit.', 175000.00, NULL, 28, NULL, NULL, NULL, 'products/Q42jx62jI0zHVXdevdTBlLxtbRzNsa3Vdj0vutSS.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:29:07', '2025-12-15 04:29:07', NULL),
(68, 'Floral drop pearl earrings', 'floral-drop-pearl-earrings', 'Floral Drop Pearl Earrings menghadirkan perpaduan detail floral yang feminin dengan aksen mutiara yang elegan. Desain drop memberikan kesan anggun dan memanjang, sempurna untuk melengkapi tampilan yang manis namun tetap classy.', 200000.00, NULL, 45, NULL, NULL, NULL, 'products/LAfhx2aIW5Wa7muD1lldNfNooOfF1u0I6qmNIMTr.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:30:27', '2025-12-15 04:30:27', NULL),
(69, 'Enamel Flower Drop Earrings', 'enamel-flower-drop-earrings', 'Enamel Flower Drop Earrings hadir dengan detail bunga berlapis enamel yang halus dan warna yang cantik, memberikan sentuhan feminin dan modern. Desain drop yang elegan menciptakan tampilan anggun dan stylish, cocok untuk melengkapi berbagai outfit.', 200000.00, NULL, 65, NULL, NULL, NULL, 'products/0WN8A5z8yo20kb70KaFe2pWXQbN2sZ74aIzuLH2T.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:31:52', '2025-12-15 04:31:52', NULL),
(70, 'Enamel Floral Bangles', 'enamel-floral-bangles', 'Enamel Floral Bangles menghadirkan desain bunga yang cantik dengan lapisan enamel halus, memberikan sentuhan feminin dan elegan. Detail floral yang lembut dipadukan dengan finishing yang rapi menjadikan bangle ini aksesoris yang eye-catching namun tetap classy.', 150000.00, NULL, 27, NULL, NULL, NULL, 'products/Ij2hTQu72YKmZEjIG5mt0eeYT4DIdDNpZUAmiNBR.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:32:45', '2025-12-15 04:32:45', NULL),
(71, 'Pink Floral Shoulder Bag', 'pink-floral-shoulder-bag', 'Pink Floral Shoulder Bag hadir dengan warna pink lembut dan motif floral yang manis, memberikan sentuhan feminin dan fresh pada penampilan. Desain shoulder bag yang praktis membuatnya nyaman digunakan untuk aktivitas sehari-hari.', 300000.00, NULL, 17, NULL, NULL, NULL, 'products/3i3VsjTyD2T2rDdY3dCWh79Zh9vU8NiycVobIwiA.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:33:45', '2025-12-15 04:33:45', NULL),
(72, 'Baker Boy Hat', 'baker-boy-hat', 'Baker Boy Hat hadir dengan desain klasik dan stylish yang memberikan sentuhan vintage pada penampilan. Modelnya yang timeless menjadikan topi ini aksesori serbaguna untuk melengkapi berbagai gaya, dari kasual hingga smart casual.', 15000000.00, NULL, 15, NULL, NULL, NULL, 'products/iRJv8vzkECiPeHoCv7GQJb1JQ2hG6mMsPGpqFKK8.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:35:15', '2025-12-22 06:52:51', NULL),
(73, 'Scarf with Apple Appliqué', 'scarf-with-apple-applique', 'Scarf with Apple Appliqué hadir dengan desain unik dan playful, menampilkan detail appliqué apel yang manis sebagai aksen utama. Memberikan sentuhan fun dan fresh, scarf ini cocok untuk kamu yang ingin tampil berbeda namun tetap stylish.', 150000.00, NULL, 18, NULL, NULL, NULL, 'products/CjODTsR4mqFAkAg2C3s0OaNzAh9PLRabZacSF57s.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:36:15', '2025-12-15 04:36:15', NULL),
(74, 'White Low-Heel Mary Jane Shoes', 'white-low-heel-mary-jane-shoes', 'White Low-Heel Mary Jane Shoes hadir dengan desain klasik yang manis dan elegan. Warna putih yang clean dipadukan dengan strap khas Mary Jane memberikan kesan feminin, timeless, dan rapi untuk berbagai kesempatan.', 200000.00, NULL, 19, NULL, NULL, NULL, 'products/gYgzf51DbkDtBAVBkLbZMN6yPfaVwMs6hTlg9VcK.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:37:09', '2025-12-15 04:37:09', NULL),
(75, 'Pink Platform Mary Jane Heels', 'pink-platform-mary-jane-heels', 'Pink Platform Mary Jane Heels hadir dengan desain klasik Mary Jane yang dipadukan dengan platform modern dan warna pink yang manis. Memberikan tampilan feminin, playful, sekaligus stylish untuk berbagai kesempatan.', 300000.00, NULL, 10, NULL, NULL, NULL, 'products/wDkYAo3x32jr2nWK8gETjH6hpuJ8zsI8n3mahbHU.jpg', NULL, 7, 'active', 0, 0, '2025-12-15 04:38:05', '2025-12-15 04:38:05', NULL),
(76, 'Maroon Mary Jane Shoes', 'maroon-mary-jane-shoes', 'Maroon Mary Jane Shoes hadir dengan desain klasik Mary Jane yang dipadukan dengan warna maroon yang elegan dan bold. Memberikan kesan feminin sekaligus sophisticated, sepatu ini cocok untuk melengkapi berbagai gaya, dari kasual hingga semi-formal.', 300000.00, NULL, 17, NULL, NULL, NULL, 'products/s0CCu3BDx6QKXDIWTjUvlRtm1brSb8Ehgxl97mVI.jpg', NULL, 7, 'active', 0, 1, '2025-12-15 04:39:01', '2025-12-22 06:39:43', NULL),
(77, 'selempang', 'selempang', 'tas ini bagus', 23000000.00, NULL, 3, NULL, NULL, NULL, 'products/Rz2WnEe3PetZGHlOFJPpSs7PCi9fmDTN75spAa0o.jpg', NULL, 8, 'active', 0, 0, '2025-12-16 04:50:54', '2025-12-16 04:51:38', '2025-12-16 04:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('percentage','fixed','free_shipping') NOT NULL,
  `value` decimal(12,2) DEFAULT NULL,
  `min_purchase` decimal(12,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `applicable_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_categories`)),
  `applicable_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_products`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `name`, `description`, `type`, `value`, `min_purchase`, `usage_limit`, `used_count`, `start_date`, `end_date`, `is_active`, `applicable_categories`, `applicable_products`, `created_at`, `updated_at`) VALUES
(2, 'MINARI10', 'MINARI10', 'Dapatkan diskon 10% untuk semua produk', 'percentage', 10.00, 200000.00, 100, 0, '2025-12-15', '2026-02-15', 1, NULL, '[\"all\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\"]', '2025-12-15 06:13:14', '2025-12-15 06:13:14'),
(4, 'NEWYEARSALEEEEEEEEEEE', 'NEWYEARSALEEEEEEEEEEE', 'beli dungs biar dapet diskon banyak', 'percentage', 30.00, 700000.00, 100, 0, '2025-12-31', '2026-01-05', 1, NULL, '[\"all\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\"]', '2025-12-15 06:17:56', '2025-12-22 06:52:22'),
(7, 'LASTYEARRR', 'LASTYEARRR', 'Nikmati Diskon Akhir Tahun hingga 30% untuk berbagai produk favoritmu. \r\nJangan lewatkan kesempatan ini, promo terbatas hanya di akhir tahun!', 'percentage', 30.00, 400000.00, 40, 0, '2025-12-21', '2025-12-29', 1, NULL, '[\"2\",\"3\",\"4\"]', '2025-12-22 05:44:40', '2025-12-22 05:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_id`, `rating`, `comment`, `is_anonymous`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 3, 4, 'pengen yang lengan panjang plisssss!!!', 1, 'approved', '2025-12-18 11:43:17', '2025-12-18 11:43:17'),
(2, 6, 25, 3, 5, 'aduh anget nyoooo dan bagus banget bahannya!', 0, 'approved', '2025-12-18 11:48:53', '2025-12-18 11:48:53'),
(3, 1, 1, 4, 5, 'cantik bangettt', 0, 'approved', '2025-12-19 18:13:32', '2025-12-19 18:13:32'),
(4, 7, 42, 8, 5, 'bagus bangettt aku suka dan nyaman banget', 0, 'approved', '2025-12-22 06:34:52', '2025-12-22 06:34:52'),
(5, 7, 76, 8, 4, 'cantik sih untuk ootd an tapi agak sakit kalau dipakai', 1, 'approved', '2025-12-22 06:35:27', '2025-12-22 06:35:27'),
(6, 7, 3, 9, 5, 'cantik banget, pas banget buat dipake ke kampus', 0, 'approved', '2025-12-22 13:09:10', '2025-12-22 13:09:10'),
(7, 7, 46, 9, 3, 'jahitannya kurang rapih', 1, 'approved', '2025-12-22 13:09:52', '2025-12-22 13:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user', 'web', '2025-12-14 23:59:15', '2025-12-14 23:59:15'),
(2, 'admin', 'web', '2025-12-14 23:59:15', '2025-12-14 23:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jLX2XLfefpAMBeffdxJDi8o8toXnRUUUWX4RSPgT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjVtdGVZZTZvZG5PM1dmeThKYVlRcmEyYlRBV09wZ1JkSFBtZ0docyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvdXNlci9jb3VudHMiO3M6NToicm91dGUiO3M6MTU6ImFwaS51c2VyLmNvdW50cyI7fX0=', 1766409511);

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `address_type` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `courier` varchar(255) NOT NULL DEFAULT 'JNE',
  `tracking_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'processing',
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `name`, `email`, `message`, `ip_address`, `read_at`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Test suggestion from guest - manual test', '127.0.0.1', NULL, '2025-12-15 09:11:32', '2025-12-15 09:11:32'),
(2, NULL, NULL, 'Final test - sekarang harusnya beneran masuk database!', '127.0.0.1', NULL, '2025-12-15 09:26:13', '2025-12-15 09:26:13'),
(3, NULL, NULL, 'makasih ya', '127.0.0.1', NULL, '2025-12-15 09:28:41', '2025-12-15 09:28:41'),
(4, 'John Doe', 'user@minari.com', 'halooooooo', '127.0.0.1', NULL, '2025-12-15 09:30:19', '2025-12-15 09:30:19'),
(5, NULL, NULL, 'canteeek', '127.0.0.1', NULL, '2025-12-15 16:38:50', '2025-12-15 16:38:50'),
(6, NULL, NULL, 'yowww', '127.0.0.1', NULL, '2025-12-18 09:29:49', '2025-12-18 09:29:49'),
(7, 'Linlin', 'linlin@minari.com', 'jujur e-commerce ini bagus banget dan model\"nya okee banget', '127.0.0.1', NULL, '2025-12-22 06:39:17', '2025-12-22 06:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `birth_date`, `address`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'johndoe', 'user@minari.com', '08111222333', '1995-05-15', 'Jl. Contoh No. 123, Jakarta', '2025-12-14 23:59:17', '$2y$12$yB/bl0njcgPQUyFoQopB3.oDC9lfRrjC7ghKta45fk2KpVjDs7LHG', 'AGQ4Q4MHaH5cN7bSCQWg2HAL1itxzwtkdhVEG9lfIrDo3NZJdTAnZsa3AzZ7', '2025-12-14 23:59:17', '2025-12-14 23:59:17'),
(2, 'Aliyah Rahma', 'aliyah', 'aliyah@minari.com', '08123456789', '1998-08-20', 'Jl. Mawar No. 10, Bandung', '2025-12-14 23:59:18', '$2y$12$kVTjDkfo.ik/KtS1RNwe9.xIq1ehwHPfwSVnog3VXOTQt2XGH/d7C', 'nMttfHmrhV', '2025-12-14 23:59:18', '2025-12-14 23:59:18'),
(3, 'Budi Santoso', 'budi', 'budi@minari.com', '08234567890', '1992-03-12', 'Jl. Melati No. 5, Surabaya', '2025-12-14 23:59:18', '$2y$12$V2SiGasqvZDWrZPEqAdr9OsGA7KzYeLuL7QZs9Y8DQo7ZSfUf/Xou', 'aYKVBzOGTy', '2025-12-14 23:59:18', '2025-12-14 23:59:18'),
(4, 'Aliyah Rahma', 'ayay', 'aliyah@gmail.com', '081198769935', '2006-03-11', 'jalan melati', NULL, '$2y$12$qbNUQCUxW2XGZOzkPGfEo.biySqEwaFLVJd0hBuV/r138A9soUSQS', NULL, '2025-12-15 00:47:03', '2025-12-15 00:47:03'),
(5, 'neinei', 'neineinei', 'neinein@gmail.com', '08123456789101', '2006-05-23', 'yaitulah', NULL, '$2y$12$AKb4ndMTVsjYLCN1eFdyv.a/teZ8RkGKhnvrLiJlyup1SgW9dNY0a', NULL, '2025-12-16 03:45:41', '2025-12-16 03:45:41'),
(6, 'ayay', 'ayaytelor', 'ayaytelor@gmail.com', '089765432145', '2006-03-11', 'jalan rawamangun', NULL, '$2y$12$2gFd9uF3s5FNYVhKaXsBje4WBQVQaJvOJOdXqfafhu7QIjqYXz98.', NULL, '2025-12-18 09:31:36', '2025-12-18 09:31:36'),
(7, 'Linlin', 'linlinyuw', 'linlin@minari.com', '081234567890', '2005-06-07', 'Komplek Widya Dubai', NULL, '$2y$12$0sf/jjXIQ/Xa3sMmP6cqLOuDh7yjra29oRRHPPn7yOENXxSAVPW5G', NULL, '2025-12-22 04:35:20', '2025-12-22 04:35:20'),
(8, 'amoymoy', 'amoytelor', 'telor@minari.com', '089765432198', '2006-03-11', 'jalan rawamangun No.5', NULL, '$2y$12$ewzFKAEa4HO23diNyBinD.Yd5PSQvQou5zwAhcenAP8TfpHrItRIq', NULL, '2025-12-22 04:41:51', '2025-12-22 04:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Home',
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line1` text NOT NULL,
  `address_line2` text DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `title`, `recipient_name`, `phone`, `address_line1`, `address_line2`, `city`, `postal_code`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 5, 'home', 'neinei', '08123456789101', 'jalan cempaka', NULL, 'jakarta', '12345', 1, '2025-12-16 03:57:10', '2025-12-16 03:57:10'),
(2, 6, 'Home', 'ayay', '089765432145', 'Jalan Rawamangun no.2, Jakarta Timur', NULL, 'jakarta', '4567', 1, '2025-12-18 10:19:54', '2025-12-18 10:19:54'),
(3, 6, 'Office', 'Alya', '089765432145', 'jalan matahari no.7, Jakarta Timur', NULL, 'jakarta', '4567', 0, '2025-12-18 11:07:32', '2025-12-18 11:07:32'),
(4, 1, 'home', 'aya', '08111011072', 'jalan melati', NULL, 'jakarta', '12345', 1, '2025-12-19 18:12:39', '2025-12-19 18:12:39'),
(5, 1, 'office', 'aya', '08111011072', 'jalan jalan', NULL, 'bandoeng', '9876', 0, '2025-12-21 13:10:36', '2025-12-21 13:10:36'),
(6, 8, 'Home', 'amoy', '089765432198', 'jalan rawamangun No.5, Jakarta Timur', NULL, 'Jakarta', '1122', 1, '2025-12-22 05:06:29', '2025-12-22 05:06:29'),
(7, 8, 'Office', 'amoy', '089765432198', 'Jalan kamboja No.8, Jakarta Selatan', NULL, 'Jakarta', '4466', 0, '2025-12-22 05:07:27', '2025-12-22 05:07:27'),
(8, 7, 'Home', 'linlin', '081234567890', 'Jalan Cempaka No.3, Lembang', NULL, 'Bandung', '4567', 1, '2025-12-22 05:32:37', '2025-12-22 05:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 5, 54, '2025-12-16 03:54:42', '2025-12-16 03:54:42'),
(3, 5, 55, '2025-12-16 03:54:44', '2025-12-16 03:54:44'),
(5, 5, 53, '2025-12-16 03:54:48', '2025-12-16 03:54:48'),
(6, 6, 1, '2025-12-18 09:41:22', '2025-12-18 09:41:22'),
(7, 6, 45, '2025-12-18 10:20:47', '2025-12-18 10:20:47'),
(9, 6, 64, '2025-12-18 12:10:45', '2025-12-18 12:10:45'),
(10, 1, 1, '2025-12-19 18:11:47', '2025-12-19 18:11:47'),
(13, 8, 1, '2025-12-22 04:47:59', '2025-12-22 04:47:59'),
(14, 8, 27, '2025-12-22 05:15:31', '2025-12-22 05:15:31'),
(20, 7, 60, '2025-12-22 05:30:25', '2025-12-22 05:30:25'),
(21, 7, 2, '2025-12-22 06:07:00', '2025-12-22 06:07:00'),
(22, 7, 41, '2025-12-22 06:19:38', '2025-12-22 06:19:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotions_code_unique` (`code`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shippings_order_id_foreign` (`order_id`);

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shippings`
--
ALTER TABLE `shippings`
  ADD CONSTRAINT `shippings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
