-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2021 at 07:04 PM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konti_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` tinyint(3) UNSIGNED DEFAULT NULL,
  `name` varchar(5) DEFAULT NULL,
  `description` varchar(27) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'jehjkhw'),
(2, 'User', 'this role is for  user only');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `permission_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(2, 1),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `user_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` tinyint(3) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(3) DEFAULT NULL,
  `email` varchar(15) DEFAULT NULL,
  `user_id` varchar(1) DEFAULT NULL,
  `date` varchar(19) DEFAULT NULL,
  `success` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'admin@admin.com', '2', '2021-07-18 13:11:14', 1),
(2, '::1', 'admin@admin.com', '2', '2021-07-18 13:51:46', 1),
(3, '::1', 'admin@admin.com', '', '2021-07-21 06:08:38', 0),
(4, '::1', 'admin@admin.com', '2', '2021-07-21 06:08:44', 1),
(5, '::1', 'admin@admin.com', '2', '2021-07-22 09:36:29', 1),
(6, '::1', 'admin@admin.com', '2', '2021-07-23 19:31:21', 1),
(7, '::1', 'admin@admin.com', '2', '2021-07-25 05:37:34', 1),
(8, '::1', 'admin@admin.com', '2', '2021-07-25 07:05:04', 1),
(9, '::1', 'admin@admin.com', '2', '2021-07-25 10:29:44', 1),
(10, '::1', 'admin@admin.com', '2', '2021-07-26 05:49:07', 1),
(11, '::1', 'admin@admin.com', '2', '2021-07-26 05:53:06', 1),
(12, '::1', 'admin@admin.com', '2', '2021-07-26 13:26:50', 1),
(13, '::1', 'admin@admin.com', '2', '2021-07-26 13:49:12', 1),
(14, '::1', 'admin@admin.com', '2', '2021-07-28 11:54:06', 1),
(15, '::1', 'admin@admin.com', '2', '2021-07-29 10:00:42', 1),
(16, '::1', 'user@gmail.com', '3', '2021-07-30 07:24:21', 1),
(17, '::1', 'user@gmail.com', '3', '2021-07-30 07:26:59', 1),
(18, '::1', 'iiouyoy', '', '2021-07-30 07:51:04', 0),
(19, '::1', 'iuyuoiy', '', '2021-07-30 07:52:02', 0),
(20, '::1', 'user@gmail.com', '3', '2021-07-30 07:52:08', 1),
(21, '::1', 'user@gmail.com', '3', '2021-07-30 07:52:31', 1),
(22, '::1', 'user@gmail.com', '3', '2021-07-30 07:53:23', 1),
(23, '::1', 'user@gmail.com', '3', '2021-07-30 08:00:15', 1),
(24, '::1', 'user@gmail.com', '3', '2021-07-30 08:00:53', 1),
(25, '::1', 'user@gmail.com', '3', '2021-07-30 08:15:59', 1),
(26, '::1', 'admin@admin.com', '2', '2021-07-30 11:40:21', 1),
(27, '::1', 'admin@admin.com', '2', '2021-07-30 11:50:05', 1),
(28, '::1', 'user@gmail.com', '3', '2021-07-30 11:50:42', 1),
(29, '::1', 'admin@admin.com', '2', '2021-07-30 11:50:54', 1),
(30, '::1', 'admin@admin.com', '2', '2021-07-30 11:51:05', 1),
(31, '::1', 'admin@admin.com', '2', '2021-07-30 11:51:36', 1),
(32, '::1', 'admin@admin.com', '2', '2021-07-31 08:07:21', 1),
(33, '::1', 'admin@admin.com', '2', '2021-07-31 21:55:46', 1),
(34, '::1', 'user@gmail.com', '3', '2021-07-31 22:45:10', 1),
(35, '::1', 'admin@admin.com', '2', '2021-08-01 04:08:37', 1),
(36, '::1', 'user@gmail.com', '3', '2021-08-01 04:08:46', 1),
(37, '::1', 'admin@admin.com', '2', '2021-08-05 08:54:56', 1),
(38, '::1', 'admin@admin.com', '2', '2021-08-05 11:25:32', 1),
(39, '::1', 'administrator', '', '2021-08-06 00:27:57', 0),
(40, '::1', 'user@gmail.com', '3', '2021-08-20 10:14:52', 1),
(41, '::1', 'user@gmail.com', '3', '2021-09-23 06:37:37', 1),
(42, '::1', 'user@gmail.com', '3', '2021-09-23 06:37:38', 1),
(43, '::1', 'user@gmail.com', '3', '2021-09-23 06:38:18', 1),
(44, '::1', 'user@gmail.com', '3', '2021-09-23 06:39:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` tinyint(3) UNSIGNED DEFAULT NULL,
  `name` varchar(15) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'Create Forecast', ''),
(4, 'Edit Forecast', ''),
(5, 'Create User', '');

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` tinyint(3) UNSIGNED DEFAULT NULL,
  `email` varchar(15) DEFAULT NULL,
  `ip_address` varchar(3) DEFAULT NULL,
  `user_agent` varchar(115) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  `created_at` varchar(19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_reset_attempts`
--

INSERT INTO `auth_reset_attempts` (`id`, `email`, `ip_address`, `user_agent`, `token`, `created_at`) VALUES
(1, 'admin@admin.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36', '3a446587bdf8112c7e7a264151aa8dd9', '2021-07-21 06:06:58');

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` varchar(20) DEFAULT NULL,
  `selector` varchar(20) DEFAULT NULL,
  `hashedValidator` varchar(20) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `expires` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` varchar(20) DEFAULT NULL,
  `permission_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` tinyint(3) UNSIGNED DEFAULT NULL,
  `version` varchar(17) DEFAULT NULL,
  `class` varchar(46) DEFAULT NULL,
  `mg_group` varchar(7) DEFAULT NULL,
  `namespace` varchar(9) DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL,
  `batch` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `mg_group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'MythAuthDatabaseMigrationsCreateAuthTables', 'default', 'MythAuth', 1626630094, 1);

-- --------------------------------------------------------

--
-- Table structure for table `store_company`
--

CREATE TABLE `store_company` (
  `company_id` int(11) NOT NULL,
  `store_id` tinyint(4) DEFAULT NULL,
  `store_name` varchar(50) DEFAULT NULL,
  `address` varchar(15) DEFAULT NULL,
  `pin_code` int(11) DEFAULT NULL,
  `full_address` text,
  `phone_number` varchar(14) DEFAULT NULL,
  `email_id` varchar(29) DEFAULT NULL,
  `gst_tin` varchar(12) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `logo_sm` varchar(50) DEFAULT NULL,
  `banner` varchar(50) DEFAULT NULL,
  `check_terms` text,
  `about_us` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_company`
--

INSERT INTO `store_company` (`company_id`, `store_id`, `store_name`, `address`, `pin_code`, `full_address`, `phone_number`, `email_id`, `gst_tin`, `logo`, `logo_sm`, `banner`, `check_terms`, `about_us`) VALUES
(1, 1, 'Hitech Billing Software', 'Nagpur MH-India', 441107, 'Block # 103, 1st floor, Balaji Sanyog Apartment, Besa Rd, opp. Petrol Pump, Besa,\r\n                                    Nagpur, Maharashtra 440037', '+91-8569542359', ' info@billingsoftwareindia.in', '27AGHY500MJU', 'logo.png', 'logo-sm.png', 'banner.jpg', '', 'Founded on the principal that good design should be seamless and accessible to all; Studio\r\n                            Proper creates an evolving\r\n                            range of solutions and assessorries that deliver great technology experiences, right to your\r\n                            doorstep.'),
(2, 2, 'E-Shop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_item_register`
--

CREATE TABLE `store_item_register` (
  `item_id` bigint(20) NOT NULL,
  `store_id` bigint(20) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_name` varchar(50) DEFAULT NULL,
  `store_item_name` varchar(50) DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `mrp` double DEFAULT NULL,
  `hot_deal` double DEFAULT NULL,
  `out_of_stock` tinyint(3) UNSIGNED DEFAULT NULL,
  `enabled` tinyint(3) UNSIGNED DEFAULT NULL,
  `deleted` tinyint(3) UNSIGNED DEFAULT NULL,
  `description` longtext,
  `item_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_item_register`
--

INSERT INTO `store_item_register` (`item_id`, `store_id`, `category`, `item_code`, `item_name`, `store_item_name`, `unit`, `sale_price`, `mrp`, `hot_deal`, `out_of_stock`, `enabled`, `deleted`, `description`, `item_image`) VALUES
(1, 1, 'Billing Software', 'G45896', 'GST Billing', 'GST Billing', 10, 3000, 4235, 15, 1, 1, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deleniti fugit incidunt, iste, itaque minima neque pariatur perferendis sed suscipit velit vitae voluptatem.', 'fortune-pos-billing.png'),
(2, 1, 'Billing Software', 'G45890', 'GST Billing', 'GST Billing', 20, 3000, 4500, 13, 0, 1, 0, 'Testing', 'Change-your-business.png'),
(3, 1, 'Billing Software', 'G45679', 'GST Billing', 'GST Billing', 24, 3200, 4700, 12, 0, 1, 0, 'Testing', 'off-billing.png'),
(4, 1, 'Billing Software', 'G45679', 'GST Billing', 'GST Billing', 24, 3200, 4700, 7, 0, 1, 0, 'Testing', 'off-billing.png'),
(5, 1, 'Billing Software', 'G45679', 'GST Billing', 'GST Billing', 24, 3200, 4700, 6, 0, 1, 0, 'Testing', 'off-billing.png'),
(6, 2, 'Billing Software', 'G45679', 'GST Billing', 'GST Billing', 24, 3200, 4700, 5, 0, 1, 0, 'Testing', 'off-billing.png'),
(7, 2, 'Billing Software', 'G45679', 'GST Billing', 'GST Billing', 24, 3200, 4700, 10, 0, 1, 0, 'Testing', 'off-billing.png'),
(8, 2, 'Billing Software', 'G45679', 'GST Billing', 'GST Billing', 24, 3200, 4700, 10, 0, 1, 0, 'Testing', 'off-billing.png'),
(9, 2, 'Billing Software', 'G67883', 'GST Billing', 'GST Billing', 23, 3100, 4100, 20, 0, 1, 0, 'Testing', 'dummy-product.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `store_register`
--

CREATE TABLE `store_register` (
  `store_id` int(10) UNSIGNED NOT NULL,
  `store_username` varchar(20) NOT NULL,
  `store_staus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_register`
--

INSERT INTO `store_register` (`store_id`, `store_username`, `store_staus`) VALUES
(1, 'hitech', 'active'),
(2, 'eshop', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `store_seo_media`
--

CREATE TABLE `store_seo_media` (
  `store_media_id` bigint(20) NOT NULL,
  `store_id` bigint(20) DEFAULT NULL,
  `fb_link` longtext,
  `instal_link` longtext,
  `youtube_link` longtext,
  `twitter_link` longtext,
  `pinterest_link` longtext,
  `seo_title` varchar(50) DEFAULT NULL,
  `seo_description` varchar(200) DEFAULT NULL,
  `seo_keywords` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_seo_media`
--

INSERT INTO `store_seo_media` (`store_media_id`, `store_id`, `fb_link`, `instal_link`, `youtube_link`, `twitter_link`, `pinterest_link`, `seo_title`, `seo_description`, `seo_keywords`) VALUES
(1, 1, 'https://www.facebook.com/', 'https://instagram.com/', 'https://www.youtube.com/', 'https://twitter.com/', 'pinterest.com', 'Store', 'Buy Accounting solutions', 'GST software,accounting solution'),
(2, 2, 'https://www.facebook.com/', 'https://instagram.com/', 'https://www.youtube.com/', 'https://twitter.com/', 'pinterest.com', 'Store', 'Buy Accounting solutions', 'GST software,accounting solution');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(3) UNSIGNED DEFAULT NULL,
  `email` varchar(15) DEFAULT NULL,
  `username` varchar(11) DEFAULT NULL,
  `password_hash` varchar(60) DEFAULT NULL,
  `reset_hash` varchar(32) DEFAULT NULL,
  `reset_at` varchar(20) DEFAULT NULL,
  `reset_expires` varchar(19) DEFAULT NULL,
  `activate_hash` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `profile_img` varchar(28) DEFAULT NULL,
  `status_message` varchar(20) DEFAULT NULL,
  `active` tinyint(3) UNSIGNED DEFAULT NULL,
  `force_pass_reset` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` varchar(19) DEFAULT NULL,
  `updated_at` varchar(19) DEFAULT NULL,
  `deleted_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `profile_img`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'admin@admin.com', 'Admin', '$2y$10$uYBbrYhJV5/ZqRaM2ONZHeGPOlr6AR8GRi7.rXC8r9Nz5ERIoDARW', '3a446587bdf8112c7e7a264151aa8dd9', '', '2021-07-21 07:06:01', '', '', '01627817592-profile_img.jpeg', '', 1, 0, '2021-07-18 13:11:04', '2021-08-01 06:58:23', ''),
(3, 'user@gmail.com', 'Normal User', '$2y$10$JY37ZSPuvn26YgC8ty1zEOg/MbAVmAev2XKr2ou7CVDN6knoz2j8m', '', '', '', '', '', '', '', 1, 0, '2021-07-30 07:24:13', '2021-07-30 07:24:13', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store_company`
--
ALTER TABLE `store_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `store_item_register`
--
ALTER TABLE `store_item_register`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `FK_store_item_register_store_register` (`store_id`);

--
-- Indexes for table `store_register`
--
ALTER TABLE `store_register`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `store_seo_media`
--
ALTER TABLE `store_seo_media`
  ADD PRIMARY KEY (`store_media_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store_register`
--
ALTER TABLE `store_register`
  MODIFY `store_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `store_seo_media`
--
ALTER TABLE `store_seo_media`
  MODIFY `store_media_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
