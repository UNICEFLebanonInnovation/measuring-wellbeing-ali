-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 24, 2019 at 10:10 AM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leb_statistics`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_test_date` date DEFAULT NULL,
  `post_test_date` date DEFAULT NULL,
  `gouvarnate` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caza` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donor_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interview_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interviewers_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `altitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accuracy` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `may_i_start_now` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `considerate_of_other_peoples_feelings` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restless_overactive_cannot_stay_still_for_long` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `often_complains_of_headaches_stomach_aches_or_sickness` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shares_readily_with_other_children_for_example_toys` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `often_loses_temper` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rather_solitary_prefers_to_play_alone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generally_well_behaved_usually_does_what_adults_request` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `many_worries_or_often_seems_worried` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helpful_if_someone_is_hurt_upset_or_feeling_ill` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `constantly_fidgeting_or_squirming` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_at_least_one_good_friend` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `often_fights_with_other_hildren_or_bullies_them` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `often_unhappy_depressed_or_tearful` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generally_liked_by_other_children` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `easily_distracted_concentration_wanders` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nervous_or_clingy_in_new_situations_easily_loses_confidence` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kind_to_younger_children` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `often_lies_or_cheats` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picked_on_or_bullied_by_other_children` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `often_offers_to_help_others` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thinks_things_out_before_acting` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `steals_from_home_school_or_elsewhere` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gets_along_better_with_adults_than_with_other_children` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `many_fears_easily_scared` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `good_attention_span_sees_chores_or_homework_through_to_the_end` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caza`
--

CREATE TABLE `caza` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gouvernate_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collectors`
--

CREATE TABLE `collectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `partner_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_subpartner` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_partner` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collectors`
--

INSERT INTO `collectors` (`id`, `user_id`, `partner_id`, `name`, `city`, `is_subpartner`, `created_at`, `updated_at`, `sub_partner`) VALUES
(3, 9, 5, 'MY Collector', 'ahmedabad', 0, '2019-12-20 04:46:42', '2019-12-20 04:57:31', NULL),
(4, 11, 1, NULL, 'gandhidham', 1, '2019-12-20 07:19:05', '2019-12-23 04:44:39', 'sdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Form 6-11', NULL, NULL),
(2, 'Form 12-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gouvernate`
--

CREATE TABLE `gouvernate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gouvernate`
--

INSERT INTO `gouvernate` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'asser', '2019-12-23 03:40:22', '2019-12-23 03:40:22'),
(3, 'caza', '2019-12-23 03:41:44', '2019-12-23 03:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_12_18_054921_create_permission_tables', 1),
(16, '2019_12_19_053927_create_partners_table', 1),
(19, '2019_12_19_054247_create_forms_table', 2),
(21, '2019_12_23_084011_create_caza_table', 4),
(22, '2019_12_23_084031_create_gouvernate_table', 4),
(25, '2019_12_19_053958_create_collectors_table', 5),
(26, '2019_12_23_053336_create_application_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(2, 'App\\User', 3),
(2, 'App\\User', 4),
(2, 'App\\User', 5),
(3, 'App\\User', 6),
(3, 'App\\User', 7),
(3, 'App\\User', 8),
(3, 'App\\User', 9),
(2, 'App\\User', 10),
(3, 'App\\User', 11);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_app_per_year` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `user_id`, `name`, `logo`, `max_app_per_year`, `created_at`, `updated_at`) VALUES
(1, 2, 'Testing', '1576821945.jpeg', 11, '2019-12-20 00:35:45', '2019-12-20 00:35:45'),
(2, 3, 'test1', '1576822633.jpeg', 100, '2019-12-20 00:47:13', '2019-12-20 00:47:13'),
(3, 4, 'test1', '1576822799.jpeg', 100, '2019-12-20 00:47:36', '2019-12-20 00:49:59'),
(4, 5, 'vipul', '1576823353.jpeg', 50, '2019-12-20 00:59:13', '2019-12-20 01:09:04'),
(5, 10, 'testing pratner', '1576845811.jpeg', 22, '2019-12-20 07:13:31', '2019-12-20 07:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', NULL, NULL),
(2, 'partner', 'admin', NULL, NULL),
(3, 'collector', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `zone`, `address`, `fax`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Vipul', 'Prajapati', 'vipul@cosmonautgroup.com', '8141688482', 'India', '302 Saman 2', '8141688482', '1', '2019-12-09 18:30:00', '$2y$10$ouv0JwBwshu8M86Prv4ujeq5/0T8oAQRuQxyIDnUWRMY./21qxlZe', 'tOPQCNGku9QV7EM4LevTrj97eJGfYL9uCvvB2ihfq0vtnIb9KhxT7nrziKZc', NULL, '2019-12-20 00:34:19'),
(2, 'test', 'Partner', 'test.cosmonautgroup@gmail.com', '8141688485', 'India', '302', '8141688485', NULL, NULL, NULL, NULL, '2019-12-20 00:35:45', '2019-12-20 00:37:40'),
(3, 'partner', 'testing2', 'test7.cosmonautgroup@gmail.com', '1234567898', 'India', '308 saman 2', '1234567898', NULL, NULL, NULL, 'EEBIXgKEpfSHFgZoeRHUjXDeWRfic3TrJK44q40gkQUrXhUfcj', '2019-12-20 00:47:13', '2019-12-20 00:47:13'),
(4, 'partner', 'testing2', 'test6.cosmonautgroup@gmail.com', '1234567898', 'India', '308 saman 2', '1234567898', NULL, NULL, NULL, '8JZULcHs5LSnO0ERhEfM9A5kuprMUj8thYzqpS0n0b1GsFOMHa', '2019-12-20 00:47:36', '2019-12-20 00:50:43'),
(5, 'Account', '1', 'test123@cosmonautgroup.com', '01234567898', 'India', '308 saman 2', '01234567898', NULL, NULL, '$2y$10$pEPOJB8owPy7WqhLng/erOFcn8OqTQH5ePNUw/63pdsxBb1KgfUvG', '0rGwiecZFjD9QvVG7XTmUaQk9z9C6GllJRC2rzmxEH6V5R8Pxsm5C3JLpMvj', '2019-12-20 00:59:13', '2019-12-20 01:09:04'),
(6, 'test', 'collector', 'test1234@gmail.com', '01234567898', '3', '308 saman 2', NULL, NULL, NULL, NULL, 'Yhba3PYAGPnDw1LeRT6EvdaNZbXohh7IUvGEMyQ8YwhizRt9vG', '2019-12-20 03:07:43', '2019-12-20 03:07:43'),
(9, 'testing', 'collector', 'test123456@gmail.com', '1234567898', '1', '302 saman 2', NULL, NULL, NULL, NULL, 'xZR3fO5gCWrGLYuyrLWjl3Bl3wD03JKdW2rxXHljef9TYlhfIW', '2019-12-20 04:46:42', '2019-12-20 04:56:47'),
(10, 'partner', 'testing', 'test345@gmail.com', '1234567898', 'India', '302 saman 2', '1234567898', NULL, NULL, '$2y$10$lKlvalWPplZBn.dWT.Gb.eVRGF588q5STQnfyva/3G8tGaR7fgSui', 'FLc1quCxvrlCkH6OyMTOPZddPCfNkOQX9iervqec3ESYDg0JpHeROroTwtIt', '2019-12-20 07:13:31', '2019-12-20 07:14:46'),
(11, 'Account', '1', 'vipul123@cosmonautgroup.com', '01234567898', '1', '308 saman 2', NULL, NULL, NULL, NULL, 'ezNQNr1Q9rqWaIjn0z4mnfoCFFQqpcGEBWSKSCOPK5shWxlG5I', '2019-12-20 07:19:05', '2019-12-20 07:19:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caza`
--
ALTER TABLE `caza`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collectors`
--
ALTER TABLE `collectors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gouvernate`
--
ALTER TABLE `gouvernate`
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
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caza`
--
ALTER TABLE `caza`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `collectors`
--
ALTER TABLE `collectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gouvernate`
--
ALTER TABLE `gouvernate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
