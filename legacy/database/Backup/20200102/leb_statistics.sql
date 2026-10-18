-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2020 at 05:28 PM
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
  `pre_test_date` date DEFAULT NULL,
  `post_test_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partner_id` bigint(20) DEFAULT NULL,
  `collector_id` bigint(20) DEFAULT NULL,
  `status` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `code`, `pre_test_date`, `post_test_date`, `created_at`, `updated_at`, `partner_id`, `collector_id`, `status`) VALUES
(11, 'PA-1577477940-11', '2019-12-27', NULL, '2019-12-27 00:54:37', '2019-12-27 01:13:00', 10, NULL, NULL),
(12, 'PA-1577477940-12', NULL, NULL, '2019-12-27 01:42:47', '2019-12-27 01:42:47', 10, NULL, NULL),
(13, 'PA-1577477940-13', NULL, NULL, '2019-12-27 01:47:36', '2019-12-27 01:47:36', 10, NULL, NULL),
(14, 'PA-1577477940-14', NULL, NULL, '2019-12-27 01:48:02', '2019-12-27 01:48:02', 10, NULL, NULL),
(15, 'PA-1577477940-15', NULL, NULL, '2019-12-27 01:49:13', '2019-12-27 01:49:13', 10, NULL, 2),
(16, 'PA-1577477940-16', NULL, NULL, '2019-12-27 01:50:22', '2019-12-27 01:50:22', 10, NULL, 2),
(17, 'PA-1577477940-17', '2019-12-27', '2019-12-27', '2019-12-27 01:50:31', '2019-12-27 02:52:44', 10, NULL, 6),
(18, 'TE-1577564340-18', '2019-12-30', '2019-12-30', '2019-12-28 04:03:13', '2019-12-30 01:37:50', NULL, 9, 7),
(19, 'TE-1577564340-19', '2019-12-30', '2019-12-30', '2019-12-28 04:03:17', '2019-12-30 03:24:38', NULL, 9, 7),
(20, 'TE-1577564340-20', '2019-12-30', '2019-12-30', '2019-12-28 04:03:37', '2019-12-30 03:40:21', NULL, 9, 7),
(21, 'PA-1577737140-21', '2019-12-30', NULL, '2019-12-30 00:51:24', '2019-12-30 00:55:02', 10, NULL, 4),
(22, 'PA-1577737140-22', NULL, NULL, '2019-12-30 01:07:09', '2019-12-30 01:07:09', 10, NULL, 2),
(23, 'PA-1577737140-23', NULL, NULL, '2019-12-30 06:33:57', '2019-12-30 06:33:57', 10, NULL, 2),
(24, 'PA-1577737140-24', NULL, NULL, '2019-12-30 06:55:02', '2019-12-30 06:55:40', 10, NULL, 3),
(25, 'AC-1577996400-25', NULL, NULL, '2020-01-02 03:49:44', '2020-01-02 03:50:50', 5, NULL, 3),
(26, 'TE-1577996400-26', NULL, NULL, '2020-01-02 03:57:37', '2020-01-02 05:14:34', NULL, 9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `application_value`
--

CREATE TABLE `application_value` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) NOT NULL,
  `type` enum('pre_test','post_test') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gouvarnate` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caza` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `child_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_value`
--

INSERT INTO `application_value` (`id`, `application_id`, `type`, `category`, `gouvarnate`, `caza`, `agency_name`, `form`, `donor_name`, `interview_date`, `interviewers_name`, `age`, `gender`, `nationality`, `area`, `gateway_type`, `p_code`, `latitude`, `longitude`, `altitude`, `accuracy`, `may_i_start_now`, `considerate_of_other_peoples_feelings`, `restless_overactive_cannot_stay_still_for_long`, `often_complains_of_headaches_stomach_aches_or_sickness`, `shares_readily_with_other_children_for_example_toys`, `often_loses_temper`, `rather_solitary_prefers_to_play_alone`, `generally_well_behaved_usually_does_what_adults_request`, `many_worries_or_often_seems_worried`, `helpful_if_someone_is_hurt_upset_or_feeling_ill`, `constantly_fidgeting_or_squirming`, `has_at_least_one_good_friend`, `often_fights_with_other_hildren_or_bullies_them`, `often_unhappy_depressed_or_tearful`, `generally_liked_by_other_children`, `easily_distracted_concentration_wanders`, `nervous_or_clingy_in_new_situations_easily_loses_confidence`, `kind_to_younger_children`, `often_lies_or_cheats`, `picked_on_or_bullied_by_other_children`, `often_offers_to_help_others`, `thinks_things_out_before_acting`, `steals_from_home_school_or_elsewhere`, `gets_along_better_with_adults_than_with_other_children`, `many_fears_easily_scared`, `good_attention_span_sees_chores_or_homework_through_to_the_end`, `comment`, `created_at`, `updated_at`, `child_code`) VALUES
(1, 11, 'pre_test', 'Child Labour Activity', 'Akkar', 'Akkar', 'ABAAD', '124', 'UNICEF', '20149-12-30', 'Vipul', '23', 'male', 'indian', 'Adouiye', 'Social Development Center', '123456', '23.012677', '72.512381', '0.4', '0.5', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-27 01:03:59', '2019-12-27 01:14:23', NULL),
(6, 17, 'pre_test', 'Child Labour Activity', '1', 'Akkar', 'ABAAD', '124', 'UNICEF', '20149-12-30', 'Vipul', '23', 'male', 'Lebanese', 'Adouiye', 'Social Development Center', '123456', '23.012677', '72.512381', '0.4', '0.5', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-27 02:52:47', '2019-12-27 02:54:03', NULL),
(7, 17, 'post_test', 'Child Labour Activity', '1', 'Akkar', 'ABAAD', '124', 'UNICEF', '20149-12-30', 'Vipul', '23', 'male', 'Lebanese', 'Adouiye', 'Social Development Center', '123456', '23.012677', '72.512381', '0.4', '0.5', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-27 02:57:27', '2019-12-27 02:57:41', NULL),
(8, 20, 'pre_test', 'Child Labour Activity', '1', '1', 'ABAAD', 'Form 6-11', 'UNHCR', '2019-12-30', 'vipul', '11', 'female', 'Syrian', NULL, 'Social Development Center', '380015', '38.25', '38.25', '10', '2', 'yes', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Certainly true', 'No answer', 'Certainly true', 'Certainly true', 'No answer', 'No answer', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-28 04:30:10', '2019-12-30 03:08:02', NULL),
(9, 18, 'pre_test', 'Child Mariage Activity', '1', NULL, 'ABAAD', 'Form 6-11', 'ERF', '2019-12-30', 'vipul', '11', 'male', 'Lebanese', NULL, 'Social Development Center', '380015', '38.25', '38.25', '8', '3', 'yes', 'Somewhat true', 'Certainly true', 'No answer', 'Not true', 'Not true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'No answer', 'Somewhat true', 'Certainly true', 'Certainly true', NULL, '2019-12-29 23:37:35', '2019-12-30 00:13:59', 'nothing'),
(10, 18, 'pre_test', 'Other', NULL, NULL, 'AMEL', 'Form 6-11', 'UNHCR', '2019-12-30', 'vipul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-30 00:24:10', '2019-12-30 00:32:21', 'nothing'),
(11, 18, 'pre_test', 'Violent Discipline  Activity', '1', NULL, 'AND', 'Form 6-11', 'ERF', '2019-12-30', 'vipul', '11', 'female', 'Syrian', NULL, 'School', '380015', '38.25', '38.25', '10', '16', 'yes', 'Somewhat true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'No answer', 'No answer', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Not true', NULL, '2019-12-30 00:32:29', '2019-12-30 01:31:48', 'nothing'),
(12, 21, 'pre_test', 'Child Labour Activity', '1', NULL, 'AND', 'Form 6-11', 'UNHCR', '2019-12-30', 'vipul', '11', 'male', 'Syrian', NULL, 'Social Development Center', '380015', '38.25', '38.25', '11', '17', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Not true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-30 00:51:35', '2019-12-30 00:55:02', 'nothing'),
(13, 21, 'post_test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-30 00:55:40', '2019-12-30 00:55:40', NULL),
(14, 18, 'post_test', NULL, '1', '2', 'ARC', 'Form 12-17', 'UNHCR', '2019-12-30', 'vipul', '11', 'female', 'Lebanese', NULL, 'School', '380015', '38.25', '38.25', '11', '4', 'yes', 'Somewhat true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', NULL, '2019-12-30 01:31:53', '2019-12-30 01:37:51', 'nothing'),
(15, 20, 'post_test', 'Violent Discipline  Activity', '1', '2', 'AMEL', 'Form 6-11', 'UNHCR', '2019-12-30', 'vipul', '11', 'female', 'Syrian', NULL, 'Social Development Center', '380015', '38.25', '38.25', '12', '9', 'yes', 'No answer', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Certainly true', 'Not true', 'Not true', 'Not true', NULL, '2019-12-30 03:08:08', '2019-12-30 03:40:22', NULL),
(16, 19, 'pre_test', 'Child Mariage Activity', '1', '2', 'AMEL', 'Form 6-11', 'ERF', '2019-12-30', 'vipul', '11', 'male', 'Syrian', NULL, 'Social Development Center', '380015', '38.25', '38.25', '12', '10', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'No answer', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'Not true', 'Somewhat true', 'Certainly true', 'No answer', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-30 03:19:12', '2019-12-30 03:21:03', NULL),
(17, 19, 'post_test', 'Child Mariage Activity', '1', '2', 'AMEL', 'Form 6-11', 'ERF', '2019-12-30', 'vipul', '11', 'male', 'Syrian', NULL, 'Social Development Center', '380015', '38.25', '38.25', '12', '10', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'No answer', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'Not true', 'Somewhat true', 'Certainly true', 'No answer', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-30 03:20:10', '2019-12-30 03:24:38', NULL),
(19, 19, 'post_test', 'Child Mariage Activity', '1', '2', 'AMEL', 'Form 6-11', 'ERF', '2019-12-30', 'vipul', '11', 'male', 'Syrian', NULL, 'Social Development Center', '380015', '38.25', '38.25', '12', '10', 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'No answer', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'Not true', 'Somewhat true', 'Certainly true', 'No answer', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2019-12-30 03:22:07', '2019-12-30 03:24:38', NULL),
(20, 22, 'pre_test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-30 03:51:08', '2019-12-30 03:51:08', NULL),
(21, 24, 'pre_test', 'Child Mariage Activity', '1', '2', 'AMEL', 'Form 6-11', 'UNHCR', '2019-12-30', 'vipul', '11', 'male', 'Syrian', '2', 'School', '380015', '38.25', '38.25', '7', '-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-30 06:55:09', '2020-01-02 00:10:53', NULL),
(26, 24, 'post_test', 'Child Mariage Activity', '1', '2', 'AMEL', 'Form 6-11', 'UNHCR', '2019-12-30', 'vipul', '11', 'male', 'Syrian', '2', 'School', '380015', '38.25', '38.25', '7', '-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-02 00:04:21', '2020-01-02 00:10:53', NULL),
(27, 25, 'pre_test', 'Child Mariage Activity', '1', '2', 'AMEL', 'Form 6-11', 'ERF', '2019-12-30', 'vipul', '11', 'female', 'Lebanese', '2', 'Secondary Health Center', '380015', '38.25', '38.25', '25', '47', 'yes', 'Not true', 'Certainly true', 'No answer', 'No answer', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'nothing', '2020-01-02 03:49:48', '2020-01-02 03:50:50', NULL),
(28, 25, 'post_test', 'Child Mariage Activity', '1', '2', 'AMEL', NULL, 'ERF', '2019-12-30', 'vipul', '11', 'female', 'Lebanese', '2', 'Secondary Health Center', '380015', '38.25', '38.25', '25', '47', 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nothing', '2020-01-02 03:50:50', '2020-01-02 03:50:50', NULL),
(29, 26, 'pre_test', NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-15 06:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-02 03:57:40', '2020-01-02 05:14:34', NULL),
(30, 26, 'post_test', NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-15 06:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-02 05:14:34', '2020-01-02 05:14:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caza_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `arabic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `caza_id`, `name`, `created_at`, `updated_at`, `arabic`) VALUES
(2, 2, 'tst', '2019-12-30 07:50:19', '2019-12-30 07:50:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caza`
--

CREATE TABLE `caza` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gouvernate_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `arabic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `caza`
--

INSERT INTO `caza` (`id`, `gouvernate_id`, `name`, `created_at`, `updated_at`, `arabic`) VALUES
(2, 1, 'test2', '2019-12-30 01:03:51', '2019-12-30 01:03:51', NULL);

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
(3, 9, 10, 'MY Collector', 'ahmedabad', 0, '2019-12-20 04:46:42', '2019-12-20 04:57:31', NULL),
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `arabic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gouvernate`
--

INSERT INTO `gouvernate` (`id`, `name`, `created_at`, `updated_at`, `arabic`) VALUES
(1, 'asser', '2019-12-23 03:40:22', '2019-12-23 03:40:22', NULL),
(3, 'caza', '2019-12-23 03:41:44', '2019-12-23 03:45:02', NULL),
(4, 'testing', '2020-01-02 05:03:33', '2020-01-02 05:03:33', 'اختبارات');

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
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_12_18_054921_create_permission_tables', 1),
(16, '2019_12_19_053927_create_partners_table', 1),
(19, '2019_12_19_054247_create_forms_table', 2),
(25, '2019_12_19_053958_create_collectors_table', 5),
(27, '2014_10_12_000000_create_users_table', 7),
(32, '2019_12_23_053336_create_application_table', 10),
(33, '2019_12_27_065046_create_status_table', 11),
(34, '2019_12_27_052207_create_application_value_table', 12),
(36, '2019_12_23_084011_create_caza_table', 13),
(37, '2019_12_23_084031_create_gouvernate_table', 13),
(38, '2019_12_30_130516_create_area_table', 13);

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
(3, 'App\\User', 11),
(2, 'App\\User', 12);

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
(5, 10, 'testing pratner', '1576845811.jpeg', 22, '2019-12-20 07:13:31', '2019-12-20 07:14:46'),
(6, 12, 'testingcollector', '1577954161.jpeg', 20, '2020-01-02 03:06:01', '2020-01-02 03:07:24');

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
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Pre Test', '2019-12-27 01:32:52', '2019-12-27 01:32:52'),
(3, 'Pre Test Pending', '2019-12-27 01:36:22', '2019-12-27 01:36:22'),
(4, 'Pre Test Completed', '2019-12-27 01:36:32', '2019-12-27 01:36:32'),
(5, 'Post Test', '2019-12-27 01:36:42', '2019-12-27 01:36:42'),
(6, 'Post Test Pending', '2019-12-27 01:36:51', '2019-12-27 01:36:51'),
(7, 'Post Test Completed', '2019-12-27 01:36:58', '2019-12-27 01:36:58');

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
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `zone`, `address`, `fax`, `is_active`, `email_verified_at`, `password`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Vipul', 'Prajapati', 'vipul@cosmonautgroup.com', '8141688482', 'India', '302 Saman 2', '8141688482', '1', '2019-12-09 18:30:00', '$2y$10$qUjeiu5dDr/zd.STksY.4.oLEFtjTYV81r5jj9MrACZbrIaFJzQWO', 'bofCJum9Yw4OKna2vKe299lEb5lxuMoumLvGlCDj8PeXuE2qmB', 'ekh86YKcBIEIBQ1FR8x60GHg6X9klP23er8bino3WQObZEYRllNXXIFVMWy3', NULL, '2019-12-25 23:14:19'),
(2, 'test', 'Partner', 'test.cosmonautgroup@gmail.com', '8141688485', 'India', '302', '8141688485', '1', NULL, NULL, NULL, NULL, '2019-12-20 00:35:45', '2019-12-26 23:31:35'),
(3, 'partner', 'testing2', 'test7.cosmonautgroup@gmail.com', '1234567898', 'India', '308 saman 2', '1234567898', '1', NULL, NULL, NULL, 'EEBIXgKEpfSHFgZoeRHUjXDeWRfic3TrJK44q40gkQUrXhUfcj', '2019-12-20 00:47:13', '2019-12-26 23:31:31'),
(4, 'partner', 'testing2', 'test6.cosmonautgroup@gmail.com', '1234567898', 'India', '308 saman 2', '1234567898', '1', NULL, NULL, NULL, '8JZULcHs5LSnO0ERhEfM9A5kuprMUj8thYzqpS0n0b1GsFOMHa', '2019-12-20 00:47:36', '2019-12-26 23:31:26'),
(5, 'Account', '1', 'test123@cosmonautgroup.com', '01234567898', 'India', '308 saman 2', '01234567898', '1', NULL, '$2y$10$pEPOJB8owPy7WqhLng/erOFcn8OqTQH5ePNUw/63pdsxBb1KgfUvG', NULL, 'RRWDaRPH2HzNaYaVTNiShTLWtLIJgk9hYOcjp29Vfnun3guttBM2dck3rHYF', '2019-12-20 00:59:13', '2019-12-26 23:31:21'),
(6, 'test', 'collector', 'test1234@gmail.com', '01234567898', '3', '308 saman 2', NULL, NULL, NULL, NULL, NULL, 'Yhba3PYAGPnDw1LeRT6EvdaNZbXohh7IUvGEMyQ8YwhizRt9vG', '2019-12-20 03:07:43', '2019-12-20 03:07:43'),
(9, 'testing', 'collector', 'test123456@gmail.com', '1234567898', '1', '302 saman 2', NULL, '1', '2019-12-09 18:30:00', '$2y$10$qUjeiu5dDr/zd.STksY.4.oLEFtjTYV81r5jj9MrACZbrIaFJzQWO', '7ciiK5uTd4KPcfyxc0KclnWPm9A07EBFRCseCQ9Xr2gEENmf4c', 'CH726qqymLtGxsxoapmb2VM55kPlzL75UbnCSnWxyHLEml3XNaJH1UoQ8npF', '2019-12-20 04:46:42', '2019-12-26 23:20:19'),
(10, 'partner', 'testing', 'test345@gmail.com', '1234567898', 'India', '302 saman 2', '1234567898', '1', NULL, '$2y$10$qUjeiu5dDr/zd.STksY.4.oLEFtjTYV81r5jj9MrACZbrIaFJzQWO', '4chMGJWR30F6oVoinSuxjWoV10JDtDzDaiyWVaBNwfYJwSQrHb', 'IH0IU1NVoqcvHU7wufZUYO4xnjhENmXi8esKwP1KP178QWR2dheoRCsdfWaO', '2019-12-20 07:13:31', '2019-12-30 01:00:42'),
(11, 'Account', '1', 'vipul123@cosmonautgroup.com', '01234567898', '1', '308 saman 2', NULL, '1', NULL, NULL, NULL, 'ezNQNr1Q9rqWaIjn0z4mnfoCFFQqpcGEBWSKSCOPK5shWxlG5I', '2019-12-20 07:19:05', '2019-12-26 23:32:21'),
(12, 'test', 'collector1', 'testcollector@gmail.com', '1234567898', 'India', '308 saman 2', '1234567898', NULL, NULL, '$2y$10$R.OWkTHt3DC/X/cYm6aeBelNTMHrn4Fe.AMsVwVFyv2APEegQPAbe', 'ID2Y5maRUzjqf5ABCJHMyU4k3AF9cDNrNvh6fGjS01BYQdl124', 'bddDm11jAKgl9kgj6mSpYIRKuwBQyAoM1qJodB4VZdhSHL0iaMpjXMjqbllr', '2020-01-02 03:06:01', '2020-01-02 03:07:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_value`
--
ALTER TABLE `application_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
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
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `application_value`
--
ALTER TABLE `application_value`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `caza`
--
ALTER TABLE `caza`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
