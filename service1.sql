-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2024 at 07:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `service1`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertises`
--

CREATE TABLE `advertises` (
  `id` bigint NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `vedio_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `advertises`
--

INSERT INTO `advertises` (`id`, `title`, `link`, `image`, `vedio_link`, `created_at`) VALUES
(2, 'This is daraj', 'fgh', 'Blue Skyriders.PNG', NULL, '2023-11-05 11:17:56');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `included` text COLLATE utf8mb3_unicode_ci,
  `excluded` text COLLATE utf8mb3_unicode_ci,
  `banner_image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `type`, `description`, `included`, `excluded`, `banner_image`, `status`, `created_at`) VALUES
(7, 'Plumbing Services', 'Home', 'Plumbing services cover common repairs and installations for water and drainage systems in homes and businesses.', 'Pipe repair, fixture installation, leak detection, drain cleaning.', 'Major pipe replacement, sewer line excavation.', 'plumbing_service.png', 'Active', '2023-09-11 05:31:40'),
(9, 'Painting Services', 'Home', 'Interior/exterior painting, surface preparation.', 'Wall repairs beyond painting scope.', 'Painting services rejuvenate spaces with fresh coats of paint, enhancing aesthetics.', 'paint-roller.png', 'Active', '2023-09-11 05:50:55'),
(10, 'House Cleaning', 'Home', 'House cleaning ensures a tidy and hygienic living environment.', 'Surface cleaning, vacuuming, bathroom sanitization.', 'Deep cleaning of specialty items.', 'House_cleaning.png', 'Active', '2023-09-11 06:06:48'),
(11, 'Appliance Repair', 'Home', 'Appliance repair restores functionality to household appliances.', 'Diagnosis, repair labor, replacement parts.', 'Appliance replacement, user-induced damage.', 'appliance_repair.png', 'Active', '2023-09-11 08:33:30'),
(12, 'House Shifting', 'Home', 'Drywall repair services,  ', 'Drywall Patching: Fixing small to medium-sized holes, cracks, or dents in the drywall.', 'Full Wall Reconstruction: Extensive damage that requires replacing an entire wall or significant structural work is not included.', 'House_shifting.png', 'Active', '2023-09-11 08:35:14'),
(13, 'AC Repair', 'AC Repair', 'd', 'd', 'd', 'air-conditioner.png', 'Active', '2023-10-22 10:32:36'),
(14, 'qfbnm,.', 'dfgbnm,.', 'sdfghjkl', 'qDAWESRDTYGUH', 'ADSJK', 'Blue Skyriders.PNG', 'Active', '2023-11-02 09:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb3_unicode_ci,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_08_21_072333_create_user_profiles_table', 1),
(6, '2023_08_21_072432_create_categories_table', 1),
(7, '2023_08_21_074137_create_services_table', 1),
(8, '2023_08_21_074403_create_service_requests_table', 1),
(9, '2023_08_21_074442_create_carts_table', 1),
(10, '2023_08_21_075659_create_reviews_table', 1),
(11, '2023_08_21_075711_create_faqs_table', 1),
(12, '2023_08_21_080139_create_servicer_profiles_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb3_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `report` text COLLATE utf8mb3_unicode_ci,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `report_id`, `report`, `status`, `created_at`) VALUES
(9, 159, 153, 'test', 'pending', '2023-10-25 11:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `servicer_id` bigint UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb3_unicode_ci,
  `rating_point` float NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `service_id`, `servicer_id`, `message`, `rating_point`, `created_at`) VALUES
(17, 159, 8, 153, 'good work', 4, '2023-10-25 07:33:15'),
(18, 159, 8, 155, 'good work', 4, '2023-10-29 06:44:35'),
(19, 168, 8, 155, 'Hi', 5, '2023-12-17 07:42:13'),
(20, 168, 8, 153, 'It is very good job. I really happy with you.', 3, '2023-12-18 04:50:20'),
(21, 168, 8, 156, 'It is good work', 4, '2023-12-18 04:53:44'),
(22, 172, 8, 171, 'sfgfdhgfj', 4, '2024-07-10 05:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `servicer_profiles`
--

CREATE TABLE `servicer_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb3_unicode_ci,
  `area` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `experience` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `biography` text COLLATE utf8mb3_unicode_ci,
  `profile_image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `work_image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `servicer_profiles`
--

INSERT INTO `servicer_profiles` (`id`, `user_id`, `service_id`, `category_id`, `address`, `area`, `experience`, `biography`, `profile_image`, `work_image`, `created_at`) VALUES
(88, 153, 8, 13, '5,road 6, Rampura, Dhaka', NULL, '', 'Included Items:\r\n# Repair of common household appliances (e.g., washing machines, refrigerators, ovens).\r\n# Regular maintenance and check-ups for specific appliances.\r\n# Replacement of certain parts or components.\r\n# Labor costs for service calls.\r\n\r\nExcluded Items:\r\n# Appliances older than a specific age.\r\n# Appliances damaged due to user misuse or negligence.\r\n# Replacement of specialized or expensive parts not included in the service.\r\n# Any additional costs that may be incurred beyond the standard service.\r\n', 'profile.png', '', '2023-12-03 05:40:53'),
(89, 155, 8, 13, '1, road 4', NULL, '1 Year', 'Included Items:\r\n# Repair of common household appliances (e.g., washing machines, refrigerators, ovens).\r\n# Regular maintenance and check-ups for specific appliances.\r\n# Replacement of certain parts or components.\r\n# Labor costs for service calls.\r\n\r\nExcluded Items:\r\n# Appliances older than a specific age.\r\n# Appliances damaged due to user misuse or negligence.\r\n# Replacement of specialized or expensive parts not included in the service.\r\n# Any additional costs that may be incurred beyond the standard service.\r\n', 'profile.png', '', '2023-12-03 05:41:06'),
(90, 156, 8, 12, '7, road, Rampura, Dhaka', NULL, '', '', 'profile.png', '', '2023-12-03 05:41:18'),
(91, 164, 8, 13, 'Banashree,Dhanmondi,Dhaka', NULL, '', '', 'profile.png', '', '2023-12-03 05:41:30'),
(92, 169, 8, 11, 'Banashree,Banani,Dhaka', NULL, ' 5', ' ', 'profile.png', '', '2023-12-03 08:32:49'),
(94, 171, 8, 10, 'Banashree,Gulshan,Dhaka', 'Baridhara', ' 5', ' zdgfjhkgh', 'profile_1702357645.png', '', '2023-12-12 05:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `included` text COLLATE utf8mb3_unicode_ci,
  `excluded` text COLLATE utf8mb3_unicode_ci,
  `charge` double(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `title`, `type`, `description`, `included`, `excluded`, `charge`, `status`, `created_at`) VALUES
(8, 10, 'tykjuyt', 'yukuiiu', 'uyilul', 'uiuyilyu', 'uyiliu', 200.00, 'uilyul', '2023-09-04 17:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `servicer_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb3_unicode_ci,
  `confirmation_code` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` date DEFAULT NULL,
  `completed_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `user_id`, `servicer_id`, `message`, `confirmation_code`, `status`, `created_at`, `updated_at`, `completed_at`) VALUES
(52, 158, 153, NULL, NULL, 'pending', '2023-10-25 07:11:47', NULL, NULL),
(53, 159, 153, NULL, NULL, 'completed', '2023-10-25 07:19:11', NULL, NULL),
(54, 159, 155, NULL, NULL, 'completed', '2023-10-29 05:15:37', NULL, NULL),
(55, 159, 155, NULL, NULL, 'completed', '2023-10-29 05:40:03', NULL, NULL),
(56, 159, 155, NULL, NULL, 'accepted', '2023-10-29 07:52:28', NULL, NULL),
(57, 168, 155, 'I have a problem', '', 'cancel', '2023-12-17 04:46:11', '2023-12-17', NULL),
(58, 168, 153, 'sdbgf', '', 'cancel', '2023-12-17 04:46:14', '2023-12-17', NULL),
(63, 168, 156, 'sccds', '817062', 'cancel', '2023-12-17 04:46:16', '2023-12-17', NULL),
(65, 168, 171, 'sdfghj', '251032', 'completed', '2023-12-07 11:34:05', '2023-12-07', '2023-12-07'),
(68, 168, 155, 'Hi I need Help', '364356', 'pending', '2023-12-17 07:41:07', NULL, NULL),
(69, 172, 153, 'xdgdfgdfg', '542263', 'cancel', '2024-07-08 09:35:49', '2024-07-08', NULL),
(70, 172, 171, 'I Need Help', '895015', 'cancel', '2024-07-08 09:28:54', '2024-07-08', NULL),
(71, 172, 156, 'aZXaxdaxda', '716603', 'pending', '2024-07-10 05:13:26', NULL, NULL),
(72, 172, 171, 'safcsdfvsdfsd', '748247', 'pending', '2024-07-10 05:13:49', NULL, NULL),
(73, 172, 153, 'sfsdfsdf', '806764', 'pending', '2024-07-10 05:20:35', NULL, NULL),
(74, 172, 155, 'ok;io;io', '420759', 'pending', '2024-07-10 05:44:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `otp`, `role`, `status`, `created_at`) VALUES
(153, 'Robel Rana', '', '96e79218965eb72c92a549dd5a330112', '01880004225', '446848', 'servicer', 'Active', '2023-10-25 06:00:51'),
(154, 'Korim khan', '', '96e79218965eb72c92a549dd5a330112', '01880004220', '103632', 'user', 'Active', '2023-10-25 06:08:33'),
(155, 'Rakibul Islam', '', '96e79218965eb72c92a549dd5a330112', '01880004230', '892442', 'servicer', 'Active', '2023-10-25 06:23:28'),
(156, 'Shamim khan', '', '96e79218965eb72c92a549dd5a330112', '01880004231', '943047', 'servicer', 'Active', '2023-12-03 09:36:14'),
(158, 'Robiul Islam', '', '96e79218965eb72c92a549dd5a330112', '01880004241', '582691', 'user', 'Active', '2023-10-25 06:57:31'),
(159, 'Sagor das', '', '96e79218965eb72c92a549dd5a330112', '01880004235', '769801', 'user', 'Active', '2023-10-25 07:18:01'),
(160, 'Nadim Bhuiyan', 'admin@gmail.com', '25d55ad283aa400af464c76d713c07ad', '01305795830', NULL, 'admin', 'Active', '2023-11-05 07:35:11'),
(161, 'Masum', '', 'e10adc3949ba59abbe56e057f20f883e', '01943812956', '881208', 'user', 'Active', '2023-11-02 07:24:26'),
(162, 'Nadim Bhuiyan', '', '25d55ad283aa400af464c76d713c07ad', '01880004226', '392520', 'user', 'Unverify', '2023-11-29 10:39:58'),
(163, 'Nadim', '', '25d55ad283aa400af464c76d713c07ad', '01305795831', '120221', 'user', 'Unverify', '2023-11-29 10:48:43'),
(164, 'Nadim Bhuiyan', '', '25d55ad283aa400af464c76d713c07ad', '01880004227', '461312', 'servicer', 'Active', '2023-12-03 09:38:39'),
(165, 'Nadim Bhuiyan', '', '25d55ad283aa400af464c76d713c07ad', '01880004223', '421572', 'user', 'Unverify', '2023-11-29 11:43:56'),
(166, 'Korims', '', '25d55ad283aa400af464c76d713c07ad', '01880004221', '667800', 'user', 'Active', '2023-11-29 11:52:52'),
(167, 'Rahim', '', '25d55ad283aa400af464c76d713c07ad', '+8801305795831', '318667', 'user', 'Unverify', '2023-11-30 06:07:19'),
(168, 'Rayhan Bhuiyan', '', 'e10adc3949ba59abbe56e057f20f883e', '0130579588', '396126', 'user', 'Active', '2023-12-12 06:53:38'),
(169, 'Servicer', '', '25d55ad283aa400af464c76d713c07ad', '01540293864', '901568', 'servicer', 'Active', '2023-12-03 09:29:24'),
(171, 'Sahin Islam', '', 'e10adc3949ba59abbe56e057f20f883e', '0130579581', '243192', 'servicer', 'Active', '2024-07-08 09:24:22'),
(172, 'Nadim Bhuiyan', '', '25d55ad283aa400af464c76d713c07ad', '01305795832', '381946', 'user', 'Active', '2024-07-08 07:02:45'),
(173, 'Nadim Bhuiyan', '', '25d55ad283aa400af464c76d713c07ad', '01305795835', '433978', 'user', 'Unverify', '2024-07-08 10:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `address` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `address`, `profile_image`, `created_at`) VALUES
(15, 154, '7, road 1, Rampura, Dhaka', '', '2023-10-25 06:08:33'),
(17, 158, '1,road 2', '', '2023-10-25 06:57:31'),
(18, 159, '2, road 1, Rampura, Dhaka', '', '2023-10-25 07:18:01'),
(19, 161, 'h2, r6, BB, Banosree, Rampura , Rampura, Dhaka', '', '2023-11-02 07:24:26'),
(20, 160, 'Dhaka', 'Blue Skyriders.PNG', '2023-11-05 07:34:55'),
(21, 162, 'Banashree,Dhanmondi,Dhaka', '', '2023-11-29 10:39:59'),
(22, 163, 'Banashree,Dhanmondi,Dhaka', '', '2023-11-29 10:48:43'),
(23, 165, 'Banashreed,Mirpur,Dhaka', '', '2023-11-29 11:43:56'),
(24, 166, 'Banashree,Dhanmondi,Dhaka', '', '2023-11-29 11:52:11'),
(25, 167, 'Banashree,Banani,Dhaka', '', '2023-11-30 06:07:19'),
(26, 168, 'Banashree,Dhanmondi,Dhaka', 'profile_1702360870.PNG', '2023-12-12 06:01:29'),
(27, 172, 'Bhulta,Dhanmondi,Dhaka', 'profile_1720421912.jpg', '2024-07-08 06:58:33'),
(28, 173, 'Bhulta,Dhanmondi,Chittagong', 'profile_1720433629.jpg', '2024-07-08 10:13:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertises`
--
ALTER TABLE `advertises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_service_id_foreign` (`service_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_user_id_foreign` (`user_id`),
  ADD KEY `faqs_category_id_foreign` (`category_id`),
  ADD KEY `faqs_service_id_foreign` (`service_id`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id_foreign_key` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_user_id_foreign` (`user_id`),
  ADD KEY `report_report_id_foreign` (`report_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_servicer_id_foreign` (`servicer_id`),
  ADD KEY `reviews_service_id_foreign` (`service_id`);

--
-- Indexes for table `servicer_profiles`
--
ALTER TABLE `servicer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicer_profiles_user_id_foreign` (`user_id`),
  ADD KEY `servicer_profiles_category_id_foreign` (`category_id`),
  ADD KEY `servicer_profiles_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_requests_user_id_foreign` (`user_id`),
  ADD KEY `service_requests_servicer_id_foreign` (`servicer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertises`
--
ALTER TABLE `advertises`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `servicer_profiles`
--
ALTER TABLE `servicer_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `faqs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `faqs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `post_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `report_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_servicer_id_foreign` FOREIGN KEY (`servicer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicer_profiles`
--
ALTER TABLE `servicer_profiles`
  ADD CONSTRAINT `servicer_profiles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `servicer_profiles_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `servicer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_servicer_id_foreign` FOREIGN KEY (`servicer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
