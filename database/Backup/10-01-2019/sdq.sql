-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 10, 2020 at 01:26 AM
-- Server version: 5.6.44-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdq`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pre_test_date` timestamp NULL DEFAULT NULL,
  `post_test_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partner_id` bigint(20) DEFAULT NULL,
  `collector_id` bigint(20) DEFAULT NULL,
  `status` bigint(20) DEFAULT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `code`, `pre_test_date`, `post_test_date`, `created_at`, `updated_at`, `partner_id`, `collector_id`, `status`, `language`) VALUES
(1, 'HI-1578687600-1', '2020-01-10 07:13:19', NULL, '2020-01-10 07:09:35', '2020-01-10 07:13:19', NULL, 22, 5, NULL),
(2, 'HI-1578687600-2', '2020-01-10 07:15:04', '2020-01-10 07:15:04', '2020-01-10 07:13:44', '2020-01-10 07:15:04', NULL, 22, 7, NULL),
(3, 'HI-1578687600-3', '2020-01-10 07:22:10', '2020-01-10 07:22:10', '2020-01-10 07:20:47', '2020-01-10 07:22:10', NULL, 22, 7, NULL),
(4, 'CO-1578687600-4', '2020-01-10 07:56:50', NULL, '2020-01-10 07:55:58', '2020-01-10 07:56:50', NULL, 26, 5, NULL),
(5, 'NA-1578687600-5', '2020-01-10 08:04:47', '2020-01-10 08:10:33', '2020-01-10 08:02:35', '2020-01-10 08:10:33', NULL, 22, 8, NULL),
(6, 'EH-1578687600-6', '2020-01-10 11:21:10', '2020-01-10 11:21:10', '2020-01-10 08:57:03', '2020-01-10 11:21:10', NULL, 23, 7, NULL),
(7, 'EH-1578687600-7', '2020-01-10 11:34:34', '2020-01-10 11:34:34', '2020-01-10 10:28:56', '2020-01-10 11:34:34', NULL, 23, 7, NULL),
(8, 'EH-1578687600-8', '2020-01-10 10:39:44', NULL, '2020-01-10 10:29:34', '2020-01-10 14:41:50', NULL, 23, 6, NULL),
(9, 'EH-1578687600-9', '2020-01-10 10:58:11', NULL, '2020-01-10 10:52:36', '2020-01-10 14:01:37', NULL, 23, 6, 'eng'),
(10, 'EH-1578687600-10', '2020-01-10 11:05:21', NULL, '2020-01-10 11:04:42', '2020-01-10 14:41:15', NULL, 23, 6, NULL),
(11, 'EH-1578687600-11', '2020-01-10 14:46:22', '2020-01-10 15:20:58', '2020-01-10 11:09:30', '2020-01-10 15:20:58', NULL, 23, 7, 'en'),
(12, 'EH-1578687600-12', '2020-01-10 12:08:25', '2020-01-10 12:08:25', '2020-01-10 11:39:41', '2020-01-10 12:08:25', NULL, 23, 7, NULL),
(13, 'EH-1578687600-13', '2020-01-10 12:57:04', '2020-01-10 13:01:41', '2020-01-10 12:53:50', '2020-01-10 13:01:41', NULL, 23, 7, 'eng'),
(14, 'EH-1578687600-14', NULL, NULL, '2020-01-10 13:02:58', '2020-01-10 13:02:58', NULL, 23, 2, NULL),
(15, 'EH-1578687600-15', NULL, NULL, '2020-01-10 13:09:19', '2020-01-10 13:09:19', NULL, 23, 2, NULL),
(16, 'EH-1578687600-16', '2020-01-10 15:02:11', NULL, '2020-01-10 13:13:12', '2020-01-10 15:02:11', NULL, 23, 5, 'ur'),
(17, 'EH-1578687600-17', NULL, NULL, '2020-01-10 13:13:56', '2020-01-10 13:13:56', NULL, 23, 2, NULL),
(18, 'EH-1578687600-18', NULL, NULL, '2020-01-10 13:17:11', '2020-01-10 13:17:11', NULL, 23, 2, NULL),
(19, 'EH-1578687600-19', NULL, NULL, '2020-01-10 13:19:29', '2020-01-10 13:19:29', NULL, 23, 2, NULL),
(20, 'EH-1578687600-20', '2020-01-10 13:21:50', NULL, '2020-01-10 13:21:41', '2020-01-10 13:21:50', NULL, 23, 5, 'eng'),
(21, 'EH-1578687600-21', NULL, NULL, '2020-01-10 13:21:45', '2020-01-10 13:21:45', NULL, 23, 2, NULL),
(22, 'EH-1578687600-22', NULL, NULL, '2020-01-10 13:22:40', '2020-01-10 13:22:40', NULL, 23, 2, NULL),
(23, 'EH-1578687600-23', NULL, NULL, '2020-01-10 13:22:45', '2020-01-10 13:22:46', NULL, 23, 3, NULL),
(24, 'EH-1578687600-24', NULL, NULL, '2020-01-10 13:29:01', '2020-01-10 13:29:01', NULL, 23, 2, NULL),
(25, 'EH-1578687600-25', '2020-01-10 13:31:54', '2020-01-10 15:05:14', '2020-01-10 13:31:54', '2020-01-10 15:05:14', NULL, 23, 7, 'en'),
(26, 'EH-1578687600-26', NULL, NULL, '2020-01-10 13:52:03', '2020-01-10 13:58:03', NULL, 23, 3, 'en'),
(27, 'EH-1578687600-27', NULL, NULL, '2020-01-10 14:28:31', '2020-01-10 14:28:32', NULL, 23, 3, 'en'),
(28, 'EH-1578687600-28', '2020-01-10 14:36:05', NULL, '2020-01-10 14:36:04', '2020-01-10 14:36:05', NULL, 23, 5, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `application_value`
--

CREATE TABLE `application_value` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) NOT NULL,
  `type` enum('pre_test','post_test') COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gouvarnate` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caza` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agency_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `form` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `donor_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interview_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interviewers_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gateway_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `altitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accuracy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `may_i_start_now` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `considerate_of_other_peoples_feelings` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `restless_overactive_cannot_stay_still_for_long` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `often_complains_of_headaches_stomach_aches_or_sickness` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shares_readily_with_other_children_for_example_toys` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `often_loses_temper` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rather_solitary_prefers_to_play_alone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `generally_well_behaved_usually_does_what_adults_request` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `many_worries_or_often_seems_worried` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `helpful_if_someone_is_hurt_upset_or_feeling_ill` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `constantly_fidgeting_or_squirming` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_at_least_one_good_friend` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `often_fights_with_other_hildren_or_bullies_them` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `often_unhappy_depressed_or_tearful` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `generally_liked_by_other_children` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `easily_distracted_concentration_wanders` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nervous_or_clingy_in_new_situations_easily_loses_confidence` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kind_to_younger_children` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `often_lies_or_cheats` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picked_on_or_bullied_by_other_children` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `often_offers_to_help_others` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thinks_things_out_before_acting` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `steals_from_home_school_or_elsewhere` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gets_along_better_with_adults_than_with_other_children` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `many_fears_easily_scared` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `good_attention_span_sees_chores_or_homework_through_to_the_end` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `child_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application_value`
--

INSERT INTO `application_value` (`id`, `application_id`, `type`, `category`, `gouvarnate`, `caza`, `agency_name`, `form`, `donor_name`, `interview_date`, `interviewers_name`, `age`, `gender`, `nationality`, `area`, `gateway_type`, `p_code`, `latitude`, `longitude`, `altitude`, `accuracy`, `may_i_start_now`, `considerate_of_other_peoples_feelings`, `restless_overactive_cannot_stay_still_for_long`, `often_complains_of_headaches_stomach_aches_or_sickness`, `shares_readily_with_other_children_for_example_toys`, `often_loses_temper`, `rather_solitary_prefers_to_play_alone`, `generally_well_behaved_usually_does_what_adults_request`, `many_worries_or_often_seems_worried`, `helpful_if_someone_is_hurt_upset_or_feeling_ill`, `constantly_fidgeting_or_squirming`, `has_at_least_one_good_friend`, `often_fights_with_other_hildren_or_bullies_them`, `often_unhappy_depressed_or_tearful`, `generally_liked_by_other_children`, `easily_distracted_concentration_wanders`, `nervous_or_clingy_in_new_situations_easily_loses_confidence`, `kind_to_younger_children`, `often_lies_or_cheats`, `picked_on_or_bullied_by_other_children`, `often_offers_to_help_others`, `thinks_things_out_before_acting`, `steals_from_home_school_or_elsewhere`, `gets_along_better_with_adults_than_with_other_children`, `many_fears_easily_scared`, `good_attention_span_sees_chores_or_homework_through_to_the_end`, `comment`, `created_at`, `updated_at`, `child_code`) VALUES
(1, 1, 'pre_test', 'Child Labour Activity', '7', '27', 'ABAAD', 'Form 6-11', 'UNICEF', '2020-01-17 02:09', 'Robert', '9', 'male', 'Lebanese', '736', 'Informal Settlement', 'h3h2n9', NULL, NULL, NULL, NULL, 'yes', 'Somewhat true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', NULL, '2020-01-10 07:09:35', '2020-01-10 07:13:19', NULL),
(2, 1, 'post_test', 'Child Labour Activity', '7', '27', 'ABAAD', 'Form 6-11', 'UNICEF', '2020-01-17 02:09', 'Robert', '9', 'male', 'Lebanese', '736', 'Informal Settlement', 'h3h2n9', NULL, NULL, NULL, NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 07:13:19', '2020-01-10 07:13:19', NULL),
(3, 2, 'pre_test', 'Child Labour Activity', '7', '27', 'ABAAD', 'Form 6-11', 'UNICEF', '2020-01-10 01:45:00', 'Robert', '8', 'Male', 'Lebanese', 'Ablah', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'comment', '2020-01-10 07:13:45', '2020-01-10 07:13:45', NULL),
(4, 2, 'pre_test', 'Child Labour Activity', '7', '27', 'ABAAD', 'Form 6-11', 'UNICEF', '2020-01-10 01:45:00', 'Robert', '8', 'Male', 'Lebanese', 'Ablah', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'comment', '2020-01-10 07:13:45', '2020-01-10 07:13:45', NULL),
(5, 2, 'post_test', 'Child Labour Activity', '7', '27', 'ABAAD', 'Form 6-11', 'UNICEF', '2020-01-10 01:45:00', 'Robert', '8', 'Male', 'Lebanese', 'Ablah', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'comment', '2020-01-10 07:15:04', '2020-01-10 07:15:04', 'HI-1578687600-2'),
(6, 3, 'pre_test', 'Child Mariage Activity', '1', '3', 'ARC', 'Form 6-11', 'UNICEF', '2020-01-10 02:15:00', 'Robert', '8', 'Male', 'Lebanese', 'Aaiyat', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Certainly true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Not true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'No answer', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Certainly true', 'Not true', 'Not true', NULL, '2020-01-10 07:20:48', '2020-01-10 07:20:48', NULL),
(7, 3, 'pre_test', 'Child Mariage Activity', '1', '3', 'ARC', 'Form 6-11', 'UNICEF', '2020-01-10 02:15:00', 'Robert', '8', 'Male', 'Lebanese', 'Aaiyat', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 07:20:48', '2020-01-10 07:20:48', NULL),
(8, 3, 'post_test', 'Child Mariage Activity', '1', '3', 'ARC', 'Form 6-11', 'UNICEF', '2020-01-10 02:15:00', 'Robert', '8', 'Male', 'Lebanese', 'Aaiyat', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', 'No answer', NULL, '2020-01-10 07:22:10', '2020-01-10 07:22:10', 'HI-1578687600-3'),
(9, 4, 'pre_test', 'Child Mariage Activity', '10', '11', 'AMEL', 'Form 12-17', 'UNHCR', '2020-01-17 02:55', 'Sami', '12', 'male', 'Syrian', '2064', 'Border crossing, Other', NULL, NULL, NULL, NULL, NULL, 'yes', 'Somewhat true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'aaaaa', '2020-01-10 07:55:58', '2020-01-10 07:56:50', NULL),
(10, 4, 'post_test', 'Child Mariage Activity', '10', '11', 'AMEL', 'Form 12-17', 'UNHCR', '2020-01-17 02:55', 'Sami', '12', 'male', 'Syrian', '2064', 'Border crossing, Other', NULL, NULL, NULL, NULL, NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaaa', '2020-01-10 07:56:50', '2020-01-10 07:56:50', NULL),
(11, 5, 'pre_test', 'Child Mariage Activity', '7', '26', 'ABAAD', 'Form 6-11', 'SiDA', '2020-01-10 03:00', 'Roberto', '8', 'male', 'Lebanese', '676', 'Primary Health Center', NULL, NULL, NULL, NULL, NULL, 'yes', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', 'Not true', NULL, '2020-01-10 08:02:36', '2020-01-10 08:04:47', NULL),
(12, 5, 'post_test', 'Child Mariage Activity', '7', '26', 'ABAAD', 'Form 6-11', 'SiDA', '2020-01-10 03:00', 'Roberto', '8', 'male', 'Lebanese', '676', 'Primary Health Center', NULL, NULL, NULL, NULL, NULL, 'yes', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', 'Certainly true', NULL, '2020-01-10 08:04:47', '2020-01-10 08:10:33', NULL),
(13, 6, 'pre_test', 'Child Mariage Activity', '6', '8', 'AND', 'Form 12-17', 'ERF', '2020-01-10 06:56:00', 'Ghh', '12', 'Other', 'Lebanese', 'Achrafiye', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 08:57:03', '2020-01-10 08:57:03', NULL),
(14, 6, 'pre_test', 'Child Mariage Activity', '6', '8', 'AND', 'Form 12-17', 'ERF', '2020-01-10 06:56:00', 'Ghh', '12', 'Other', 'Lebanese', 'Achrafiye', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 08:57:03', '2020-01-10 08:57:03', NULL),
(15, 7, 'pre_test', 'Child Mariage Activity', '1', '3', 'ASMAE', 'Form 6-11', 'UNDP', '2020-01-10 08:27:00', 'Gg', '12', 'Male', 'Palestinian', 'Aarqa', 'UNHCR registration center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 10:28:57', '2020-01-10 10:28:57', NULL),
(16, 7, 'pre_test', 'Child Mariage Activity', '1', '3', 'ASMAE', 'Form 6-11', 'UNDP', '2020-01-10 08:27:00', 'Gg', '12', 'Male', 'Palestinian', 'Aarqa', 'UNHCR registration center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 10:28:57', '2020-01-10 10:28:57', NULL),
(17, 8, 'pre_test', 'Child Mariage Activity', '-1', '-1', 'CARE International', 'Form 6-11', 'UNDP', 'null', 'Ww', '11', 'Male', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 10:29:34', '2020-01-10 10:29:34', NULL),
(18, 9, 'pre_test', 'Child Mariage Activity', '-1', '-1', 'CARE International', 'Form 6-11', 'UNDP', '2020-01-10 08:52:00', 'Ddd', NULL, 'null', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 10:52:36', '2020-01-10 10:52:36', NULL),
(19, 10, 'pre_test', 'Child Labour Activity', '-1', '-1', 'CARE International', 'Form 12-17', 'UNDP', '2020-01-10 01:04:00', NULL, NULL, 'null', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 11:04:43', '2020-01-10 11:04:43', NULL),
(20, 11, 'pre_test', 'Child Labour Activity', '5', '6', 'CARE International', 'Form 12-17', 'UNICEF', '2020-01-10 12:13:00', 'Dd', '12', 'Female', 'Lebanese', 'Aadous', 'Social Development Center', NULL, '33.61', '73.128', '474.741', '48.477', 'No, permission is not given', 'Not true', 'Certainly true', 'Certainly true', 'Not true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'null', 'Not true', 'Not true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Not true', 'Certainly true', 'Certainly true', 'Somewhat true', 'Not true', 'Not true', 'Somewhat true', 'Somewhat true', NULL, '2020-01-10 11:09:31', '2020-01-10 14:46:22', 'EH-1578687600-11'),
(21, 6, 'post_test', 'Child Mariage Activity', '6', '8', 'AND', 'Form 12-17', 'ERF', '2020-01-10 06:56:00', 'Ghh', '12', 'Other', 'Lebanese', 'Achrafiye', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Somewhat true', NULL, '2020-01-10 11:21:10', '2020-01-10 11:21:10', 'EH-1578687600-6'),
(22, 7, 'post_test', 'Child Mariage Activity', '1', '3', 'ASMAE', 'Form 6-11', 'UNDP', '2020-01-10 08:27:00', 'Gg', '12', 'Male', 'Palestinian', 'Aarqa', 'UNHCR registration center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'No answer', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'Not true', 'Not true', 'Somewhat true', 'No answer', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Not true', NULL, '2020-01-10 11:34:34', '2020-01-10 11:34:34', 'EH-1578687600-7'),
(23, 12, 'pre_test', 'Child Mariage Activity', '8', '16', 'CARE International', 'Form 12-17', 'ECHO', '2020-01-10 09:37:00', 'Dd', '12', 'Male', 'Syrian', 'El Aaqide', 'UNHCR registration center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Certainly true', 'Somewhat true', 'Not true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Not true', 'Not true', 'Somewhat true', 'Not true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Not true', 'Not true', 'Somewhat true', 'Somewhat true', 'Not true', 'Somewhat true', 'Certainly true', 'Not true', NULL, '2020-01-10 11:39:42', '2020-01-10 11:39:42', NULL),
(24, 12, 'pre_test', 'Child Mariage Activity', '8', '16', 'CARE International', 'Form 12-17', 'ECHO', '2020-01-10 09:37:00', 'Dd', '12', 'Male', 'Syrian', 'El Aaqide', 'UNHCR registration center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 11:39:42', '2020-01-10 11:39:42', NULL),
(25, 12, 'post_test', 'Child Mariage Activity', '8', '16', 'CARE International', 'Form 12-17', 'ECHO', '2020-01-10 09:37:00', 'Dd', '12', 'Male', 'Syrian', 'El Aaqide', 'UNHCR registration center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Certainly true', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 11:41:39', '2020-01-10 11:41:39', NULL),
(26, 9, 'post_test', 'Child Mariage Activity', '-1', '-1', 'CARE International', 'Form 6-11', 'UNDP', '2020-01-10 08:52:00', 'Ddd', NULL, 'null', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Certainly true', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 12:16:06', '2020-01-10 12:16:06', 'EH-1578687600-9'),
(27, 13, 'pre_test', 'Child Labour Activity', '1', '3', 'AMEL', 'Form 6-11', 'UNICEF', '2019-12-25 12:12:25', 'vipul', '11', 'male', 'Syrian', '9', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2020-01-10 12:54:56', '2020-01-10 12:55:13', 'EH-1578687600-13'),
(28, 13, 'post_test', 'Child Labour Activity', '1', '3', 'AMEL', 'Form 6-11', 'UNICEF', '2019-12-25 12:12:25', 'vipul', '11', 'male', 'Syrian', '9', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2020-01-10 12:54:56', '2020-01-10 13:01:41', 'EH-1578687600-13'),
(29, 14, 'pre_test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 13:03:44', '2020-01-10 13:03:44', NULL),
(30, 16, 'pre_test', 'Child Mariage Activity', '5', '12', 'AMEL', 'Form 12-17', 'ERF', '2020-01-10 12:05:00', 'Gg', '12', 'Female', 'Syrian', 'عقبة', 'School, Primary Health Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 13:13:13', '2020-01-10 15:02:10', 'EH-1578687600-16'),
(31, 20, 'pre_test', 'Child Labour Activity', '1', '3', 'AMEL', 'Form 6-11', 'UNICEF', '2019-12-25 12:12:25', 'vipul', '11', 'male', 'Syrian', '9', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'yes', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', NULL, '2020-01-10 13:21:50', '2020-01-10 13:21:50', 'EH-1578687600-20'),
(32, 20, 'post_test', 'Child Labour Activity', '1', '3', 'AMEL', 'Form 6-11', 'UNICEF', '2019-12-25 12:12:25', 'vipul', '11', 'male', 'Syrian', '9', 'Informal Settlement', NULL, NULL, NULL, NULL, NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 13:21:50', '2020-01-10 13:21:50', 'EH-1578687600-20'),
(33, 23, 'pre_test', 'Child Mariage Activity', '5', '12', 'AMEL', 'Form 6-11', 'UNHCR', '2020-01-10 11:20:00', 'Sa', '12', 'Male', 'Lebanese', 'Ain al Jadideh', 'School, Primary Health Center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Not true', 'Certainly true', 'Not true', 'Certainly true', 'Not true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Not true', 'Certainly true', 'Certainly true', 'Certainly true', 'Not true', 'Certainly true', 'Not true', 'Certainly true', 'Somewhat true', 'Not true', NULL, '2020-01-10 13:22:46', '2020-01-10 13:22:46', NULL),
(34, 25, 'pre_test', 'Child Mariage Activity', '5', '12', 'AMEL', 'Form 12-17', 'UNICEF', '2020-01-10 06:31:00', 'Sa', '12', 'Female', 'Lebanese', 'Aaqabe', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 13:31:54', '2020-01-10 13:31:54', 'EH-1578687600-25'),
(35, 25, 'post_test', 'Child Mariage Activity', '5', '12', 'AMEL', 'Form 12-17', 'UNICEF', '2020-01-10 06:31:00', 'Sa', '12', 'Female', 'Lebanese', 'Aaqabe', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'Yes, permission is given', 'Not true', 'Somewhat true', 'Not true', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 13:31:54', '2020-01-10 15:05:14', 'EH-1578687600-25'),
(36, 26, 'pre_test', 'Child Labour Activity', '-1', '-1', 'AMEL', 'Form 6-11', 'UNICEF', 'null', NULL, NULL, 'null', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 13:52:04', '2020-01-10 13:52:04', NULL),
(37, 16, 'post_test', 'Child Mariage Activity', '5', '12', 'AMEL', 'Form 12-17', 'ERF', '2020-01-10 12:05:00', 'Gg', '12', 'Female', 'Syrian', 'عقبة', 'School, Primary Health Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 14:05:34', '2020-01-10 15:02:11', 'EH-1578687600-16'),
(38, 11, 'post_test', 'Child Labour Activity', '5', '6', 'CARE International', 'Form 12-17', 'UNICEF', '2020-01-10 12:13:00', 'Dd', '12', 'Female', 'Lebanese', 'Aadous', 'Social Development Center', NULL, '33.61', '73.128', '474.741', '48.477', 'Yes, permission is given', 'Not true', 'Not true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Not true', 'Not true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Certainly true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Somewhat true', 'Certainly true', 'Somewhat true', NULL, '2020-01-10 14:12:31', '2020-01-10 15:20:58', 'EH-1578687600-11'),
(39, 27, 'pre_test', 'Child Mariage Activity', '6', '8', 'AMEL', 'Form 6-11', 'UNICEF', '2020-01-10 12:31:00', 'Gg', '12', 'Female', 'Lebanese', 'Aadlyeh', 'Informal Settlement', NULL, '33.609780436317735', '73.12782059180046', '474.74114990234375', '48.477013', 'No, permission is not given', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 14:28:32', '2020-01-10 14:33:19', 'EH-1578687600-27'),
(40, 27, 'post_test', 'Child Mariage Activity', '6', '8', 'AMEL', 'Form 6-11', 'UNICEF', '2020-01-10 12:31:00', 'Gg', '12', 'Female', 'Lebanese', 'Aadlyeh', 'Informal Settlement', NULL, '33.609780436317735', '73.12782059180046', '474.74114990234375', '48.477013', 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 14:28:32', '2020-01-10 14:33:19', 'EH-1578687600-27'),
(41, 28, 'pre_test', 'Child Mariage Activity', '5', '12', 'ABAAD', 'Form 6-11', 'UNHCR', '2020-01-10 14:35:00', 'Hh', '12', 'Female', 'Lebanese', 'Aaqabe', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', NULL, '2020-01-10 14:36:05', '2020-01-10 14:36:05', 'EH-1578687600-28'),
(42, 28, 'post_test', 'Child Mariage Activity', '5', '12', 'ABAAD', 'Form 6-11', 'UNHCR', '2020-01-10 14:35:00', 'Hh', '12', 'Female', 'Lebanese', 'Aaqabe', 'Social Development Center', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 14:36:05', '2020-01-10 14:36:05', 'EH-1578687600-28'),
(43, 10, 'post_test', 'Child Labour Activity', '-1', '-1', 'CARE International', 'Form 12-17', 'UNDP', '2020-01-10 01:04:00', NULL, NULL, 'null', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 14:41:15', '2020-01-10 14:41:15', 'EH-1578687600-10'),
(44, 8, 'post_test', 'Child Mariage Activity', '-1', '-1', 'CARE International', 'Form 6-11', 'UNDP', 'null', 'Ww', '11', 'Male', 'null', 'null', 'null', NULL, NULL, NULL, NULL, NULL, 'No, permission is not given', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-10 14:41:50', '2020-01-10 14:41:50', 'EH-1578687600-8');

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
  `arabic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gouvernate_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `caza_id`, `name`, `created_at`, `updated_at`, `arabic`, `gouvernate_id`) VALUES
(3, 3, 'Aadouiye', NULL, NULL, 'عدوي', 0),
(4, 3, 'Aaidamoun', NULL, NULL, 'عيدمون', 0),
(5, 3, 'Aaiyat', NULL, NULL, 'عيات', 0),
(6, 3, 'Aakkar El Attiqa', NULL, NULL, 'عكار العتيقة', 0),
(7, 3, 'Aamara', NULL, NULL, 'عماره', 0),
(8, 3, 'Aaouinat', NULL, NULL, 'العوينات', 0),
(9, 3, 'Aarab Jourmnaya', NULL, NULL, 'جرمنايا', 0),
(10, 3, 'Aarida', NULL, NULL, 'عريضا', 0),
(11, 3, 'Aarmeh', NULL, NULL, 'عرمه', 0),
(12, 3, 'Aarqa', NULL, NULL, 'عرقا', 0),
(13, 3, 'Aayoun', NULL, NULL, 'عيون', 0),
(14, 3, 'Aayoun El Ghezlane', NULL, NULL, 'عيون الغزلان', 0),
(15, 3, 'Abde', NULL, NULL, 'العبده', 0),
(16, 3, 'Ain er Rsas', NULL, NULL, 'عين الراس', 0),
(17, 3, 'Ain ez Zeit', NULL, NULL, 'عين الزيت', 0),
(18, 3, 'Ain Faouar', NULL, NULL, 'عين الفوار', 0),
(19, 3, 'Ain Tinta', NULL, NULL, 'عين تنتا', 0),
(20, 3, 'Ain Yaaqoub', NULL, NULL, 'عين يعقوب', 0),
(21, 3, 'Akroum', NULL, NULL, 'اكروم', 0),
(22, 3, 'Al-Massoudieh', NULL, NULL, 'المسعودية', 0),
(23, 3, 'Amaret el Baykat', NULL, NULL, 'عمار البيكات', 0),
(24, 3, 'Amayer', NULL, NULL, 'العماير', 0),
(25, 3, 'Andqat', NULL, NULL, 'عندقت', 0),
(26, 3, 'Ard es Soud', NULL, NULL, 'ارض السود', 0),
(27, 3, 'Awade', NULL, NULL, 'العواده', 0),
(28, 3, 'Baaliye', NULL, NULL, 'بعليا', 0),
(29, 3, 'Baddouaa', NULL, NULL, 'بدويا', 0),
(30, 3, 'Bajaa', NULL, NULL, 'بجعة', 0),
(31, 3, 'Balde', NULL, NULL, 'بلدي', 0),
(32, 3, 'Bani Sakher', NULL, NULL, 'بني صخر', 0),
(33, 3, 'Barcha', NULL, NULL, 'برشا', 0),
(34, 3, 'Bebnine', NULL, NULL, 'ببنين', 0),
(35, 3, 'Beino', NULL, NULL, 'بينو', 0),
(36, 3, 'Beit Ali Adraa', NULL, NULL, 'بيت علي عدرة', 0),
(37, 3, 'Beit Ayoub', NULL, NULL, 'بيت ايوب', 0),
(38, 3, 'Beit Daoud', NULL, NULL, 'بيت داوود', 0),
(39, 3, 'Beit el Haj', NULL, NULL, 'بيت الحاج', 0),
(40, 3, 'Beit el Haouch', NULL, NULL, 'بيت الحوش', 0),
(41, 3, 'Beit Ghattas', NULL, NULL, 'بيت غطاس', 0),
(42, 3, 'Beit Khlaiyel', NULL, NULL, 'بيت خلايل', 0),
(43, 3, 'Beit Mellat', NULL, NULL, 'بيت ملات', 0),
(44, 3, 'Beit Younes', NULL, NULL, 'بيت يونس', 0),
(45, 3, 'Bellanet el Hissa', NULL, NULL, 'بلانة الحيصة', 0),
(46, 3, 'Berbara', NULL, NULL, 'برباره', 0),
(47, 3, 'Berqayel', NULL, NULL, 'برقايل', 0),
(48, 3, 'Bezbina', NULL, NULL, 'بزبينا', 0),
(49, 3, 'Bire Akkar', NULL, NULL, 'البيره عكار', 0),
(50, 3, 'Borj el Arab', NULL, NULL, 'برج العرب', 0),
(51, 3, 'Boustane El Herch', NULL, NULL, 'بستان الحرش', 0),
(52, 3, 'Bqayaa', NULL, NULL, 'البقيعه', 0),
(53, 3, 'Bqerzala', NULL, NULL, 'بقرزلا', 0),
(54, 3, 'Bzaita', NULL, NULL, 'بزيتا', 0),
(55, 3, 'Bzal', NULL, NULL, 'بزال', 0),
(56, 3, 'Chadra', NULL, NULL, 'شدره', 0),
(57, 3, 'Chane', NULL, NULL, 'شان', 0),
(58, 3, 'Chaqdouf', NULL, NULL, 'الشقدوف', 0),
(59, 3, 'Charbila', NULL, NULL, 'شربيلا', 0),
(60, 3, 'Chattaha', NULL, NULL, 'شطاحة', 0),
(61, 3, 'Cheik Mohammad', NULL, NULL, 'الشيخ محمد', 0),
(62, 3, 'Cheikh Aayash', NULL, NULL, 'الشيخ عياش', 0),
(63, 3, 'Cheikh Hmairine', NULL, NULL, 'شيخ حمارين', 0),
(64, 3, 'Cheikh Taba', NULL, NULL, 'الشيخ طابا', 0),
(65, 3, 'Cheikh Taba es Sahl', NULL, NULL, 'الشيخ طابا السهل', 0),
(66, 3, 'Cheikh Zennad Talbibe', NULL, NULL, 'الشيخ زناد', 0),
(67, 3, 'Cheikhlar', NULL, NULL, 'شيخلار', 0),
(68, 3, 'Chir Hmairine', NULL, NULL, 'شير حمارين', 0),
(69, 3, 'Dabadeb', NULL, NULL, 'داباديب', 0),
(70, 3, 'Daghle', NULL, NULL, 'الدغلة', 0),
(71, 3, 'Dahr Aayas', NULL, NULL, 'ضهر عياس', 0),
(72, 3, 'Dahr El Ballane', NULL, NULL, 'ضهر البلانه', 0),
(73, 3, 'Dahr el Houssain', NULL, NULL, 'ضهر الحسين', 0),
(74, 3, 'Dahr Laissineh', NULL, NULL, 'ضهر ليسينه', 0),
(75, 3, 'Danke et El Amriyeh', NULL, NULL, 'دنكة و العامرية', 0),
(76, 3, 'Daousse Baghdadi', NULL, NULL, 'دوسة بغدادي', 0),
(77, 3, 'Darine', NULL, NULL, 'دارين', 0),
(78, 3, 'Dayret Nahr el Kabir', NULL, NULL, 'دائرة النهر الكبير', 0),
(79, 3, 'Deir Dalloum', NULL, NULL, 'دير دلوم', 0),
(80, 3, 'Deir Janine', NULL, NULL, 'دير جنين', 0),
(81, 3, 'Deir Mar Jeryos', NULL, NULL, 'دير مار جريس', 0),
(82, 3, 'Denke', NULL, NULL, 'دنكي', 0),
(83, 3, 'Dibbabiye', NULL, NULL, 'دبابية', 0),
(84, 3, 'Dinbou Ain al zahab', NULL, NULL, 'دنبو عين الذهب', 0),
(85, 3, 'Doueir Aadouiye', NULL, NULL, 'دوير عدويه', 0),
(86, 3, 'Ech Cheikh Maarouf', NULL, NULL, 'الشيخ معروف', 0),
(87, 3, 'Ed Daoura', NULL, NULL, 'الدوره', 0),
(88, 3, 'Ed Daousse', NULL, NULL, 'الدوسة', 0),
(89, 3, 'Ed Debbabiye el Charqiye', NULL, NULL, 'الدبابية الشرقية', 0),
(90, 3, 'Ed Debbabiye el Gharbiye', NULL, NULL, 'الدبابية الغربية', 0),
(91, 3, 'El Aabboudiye', NULL, NULL, 'العبودية', 0),
(92, 3, 'El Aamriye', NULL, NULL, 'العمارية', 0),
(93, 3, 'El Aaouaichat', NULL, NULL, 'العويشات', 0),
(94, 3, 'El Aarida', NULL, NULL, 'العريضة', 0),
(95, 3, 'El Aayoun', NULL, NULL, 'العيون', 0),
(96, 3, 'El Barde', NULL, NULL, 'بردي', 0),
(97, 3, 'El Borj Akkar', NULL, NULL, 'البرج عكار', 0),
(98, 3, 'El Fraidis', NULL, NULL, 'فريديس', 0),
(99, 3, 'El Ghawaya', NULL, NULL, 'القبيات غوايا', 0),
(100, 3, 'El Haissa', NULL, NULL, 'الحيصة', 0),
(101, 3, 'El Hichi', NULL, NULL, 'الهيشه', 0),
(102, 3, 'El Houaich', NULL, NULL, 'الحويش', 0),
(103, 3, 'El Kharnoubeh', NULL, NULL, 'الخرنوبه', 0),
(104, 3, 'El Khirbe', NULL, NULL, 'الخربة', 0),
(105, 3, 'El Khirbe Msalla', NULL, NULL, 'الخربة مصلا', 0),
(106, 3, 'EL Khirbe Qleiaat', NULL, NULL, 'الخربة قليعات', 0),
(107, 3, 'El Khoder', NULL, NULL, 'الخضر اكروم', 0),
(108, 3, 'El Kneisse', NULL, NULL, 'الكنيسة', 0),
(109, 3, 'El Kouraniye', NULL, NULL, 'الكورانية', 0),
(110, 3, 'El Krahne', NULL, NULL, 'الكراهنة', 0),
(111, 3, 'El Kroum', NULL, NULL, 'الكروم', 0),
(112, 3, 'El Majdal', NULL, NULL, 'المجدل العماير', 0),
(113, 3, 'El Majdel', NULL, NULL, 'المجدل عكار', 0),
(114, 3, 'El Mbar kiye', NULL, NULL, 'المباركية', 0),
(115, 3, 'El Melkiye', NULL, NULL, 'الملكي', 0),
(116, 3, 'El Mqaiteaa', NULL, NULL, 'المقيطع', 0),
(117, 3, 'El Qantara', NULL, NULL, 'القنطرة', 0),
(118, 3, 'El Qatlabe', NULL, NULL, 'القبيات القطلبه', 0),
(119, 3, 'El Qlaiaat', NULL, NULL, 'القليعات', 0),
(120, 3, 'El Qorne', NULL, NULL, 'القرنة', 0),
(121, 3, 'El Qsair', NULL, NULL, 'القصير', 0),
(122, 3, 'El Rama', NULL, NULL, 'الرامه', 0),
(123, 3, 'En Nabi Khaled', NULL, NULL, 'النبي خالد', 0),
(124, 3, 'Er Ransiye', NULL, NULL, 'الرانسية', 0),
(125, 3, 'Er Rouaime', NULL, NULL, 'الرويمة', 0),
(126, 3, 'Es Sayeh', NULL, NULL, 'السايح', 0),
(127, 3, 'Es Souaisse', NULL, NULL, 'السويسة', 0),
(128, 3, 'Ez Zouq', NULL, NULL, 'الذوق', 0),
(129, 3, 'Fard', NULL, NULL, 'الفرض', 0),
(130, 3, 'Fnaideq', NULL, NULL, 'فنيدق', 0),
(131, 3, 'Fsiqine et Ain Echma', NULL, NULL, 'فسقين و عين اشما', 0),
(132, 3, 'Ghzaile', NULL, NULL, 'الغزيله', 0),
(133, 3, 'Habchit', NULL, NULL, 'حبشيت', 0),
(134, 3, 'Haider', NULL, NULL, 'حيدر', 0),
(135, 3, 'Haitla', NULL, NULL, 'هيتلا', 0),
(136, 3, 'Haizouq', NULL, NULL, 'حيزوق', 0),
(137, 3, 'Halba', NULL, NULL, 'حلبا', 0),
(138, 3, 'Haouch', NULL, NULL, 'حوش', 0),
(139, 3, 'Haouchab', NULL, NULL, 'هوشب', 0),
(140, 3, 'Haret Beit Kessab', NULL, NULL, 'حارة بيت كساب', 0),
(141, 3, 'Haret ej Jdide', NULL, NULL, 'حارة الجديدة', 0),
(142, 3, 'Haret ej Jdide Mqaiteaa', NULL, NULL, 'حارة الجديدة المقيطع', 0),
(143, 3, 'Hedd', NULL, NULL, 'الهد', 0),
(144, 3, 'Hikr Janine', NULL, NULL, 'حكر جنين', 0),
(145, 3, 'Hissa', NULL, NULL, 'الحيصا', 0),
(146, 3, 'Hmaireh Aakkar', NULL, NULL, 'الحميرة', 0),
(147, 3, 'Hmais', NULL, NULL, 'حميص', 0),
(148, 3, 'Hnaider', NULL, NULL, 'حنيدر', 0),
(149, 3, 'Hokr ech Cheikh Taba', NULL, NULL, 'حكر الشيخ طابا', 0),
(150, 3, 'Hokr ed Dahri', NULL, NULL, 'حكر الضاهري', 0),
(151, 3, 'Hokr el Kousse', NULL, NULL, 'حكر الكوسا', 0),
(152, 3, 'Hokr El Mahmoudiye', NULL, NULL, 'حكر المحمودية', 0),
(153, 3, 'Hokr Etti', NULL, NULL, 'حكر قتة', 0),
(154, 3, 'Hokr Jouret Srar', NULL, NULL, 'حكر جورة سرار', 0),
(155, 3, 'Hrar', NULL, NULL, 'حرار', 0),
(156, 3, 'Idbil', NULL, NULL, 'عدبل', 0),
(157, 3, 'Ilat', NULL, NULL, 'ايلات', 0),
(158, 3, 'Janine', NULL, NULL, 'جنين', 0),
(159, 3, 'Jdaidet Ej Joumeh', NULL, NULL, 'جديدة الجومه', 0),
(160, 3, 'Jdeide', NULL, NULL, 'جديدة', 0),
(161, 3, 'Jdeidet El Qaitaa', NULL, NULL, 'جديدة القيطع', 0),
(162, 3, 'Jebrayel', NULL, NULL, 'جبرائيل', 0),
(163, 3, 'Jichet Aali Houssein', NULL, NULL, 'جيشة علي حسين', 0),
(164, 3, 'Jouret Srar', NULL, NULL, 'جورة سرار', 0),
(165, 3, 'Kafr El Ftouh', NULL, NULL, 'كفر الفتوح', 0),
(166, 3, 'Kafroun', NULL, NULL, 'كفرون', 0),
(167, 3, 'Kalkha', NULL, NULL, 'كلخا', 0),
(168, 3, 'Karm el Aasfour', NULL, NULL, 'كرم عصفور', 0),
(169, 3, 'Karm Zebdine', NULL, NULL, 'كرم زبدين', 0),
(170, 3, 'Kawashra', NULL, NULL, 'الكواشرة', 0),
(171, 3, 'Kfar Harra', NULL, NULL, 'كفرحره', 0),
(172, 3, 'Kfar Melki', NULL, NULL, 'كفرملكي', 0),
(173, 3, 'Kfar Noun', NULL, NULL, 'كفرنون', 0),
(174, 3, 'Kfartoun', NULL, NULL, 'كفرتون', 0),
(175, 3, 'Khalsa', NULL, NULL, 'خالصة', 0),
(176, 3, 'Khane Hayat', NULL, NULL, 'خان الحيات', 0),
(177, 3, 'Khat Petrol', NULL, NULL, 'خط البترول', 0),
(178, 3, 'Khirbet Char', NULL, NULL, 'خربة شار', 0),
(179, 3, 'Khirbet Daoud', NULL, NULL, 'خربة داوود', 0),
(180, 3, 'Khirbet er Roummane', NULL, NULL, 'خربة الرمان', 0),
(181, 3, 'Khirbit Ej Jord', NULL, NULL, 'خربة الجرد', 0),
(182, 3, 'Khorab el Haiyat', NULL, NULL, 'خرب الحيات', 0),
(183, 3, 'Khraibe Akkar', NULL, NULL, 'الخريبة', 0),
(184, 3, 'Khreibet ej Jindi', NULL, NULL, 'خريبة الجندي', 0),
(185, 3, 'Knaisse Hnaider', NULL, NULL, 'كنيسة هنيدر', 0),
(186, 3, 'Knisseh', NULL, NULL, 'كنيسة', 0),
(187, 3, 'Kouikhat', NULL, NULL, 'الكويخات', 0),
(188, 3, 'Kousha', NULL, NULL, 'كوشا', 0),
(189, 3, 'Kroum el Arab', NULL, NULL, 'كروم العرب', 0),
(190, 3, 'Machha', NULL, NULL, 'مشحة', 0),
(191, 3, 'Machta Hammoud', NULL, NULL, 'مشتى حمود', 0),
(192, 3, 'Machta Hassan', NULL, NULL, 'مشتى حسن', 0),
(193, 3, 'Mahmoudiye', NULL, NULL, 'المحمودية', 0),
(194, 3, 'Majdla', NULL, NULL, 'مجدلا', 0),
(195, 3, 'Mar Lia Hdare', NULL, NULL, 'مار ليا حدار', 0),
(196, 3, 'Mar Sahllita', NULL, NULL, 'مار شليطا', 0),
(197, 3, 'Mar Touma', NULL, NULL, 'مار توما', 0),
(198, 3, 'Marlayet Haddara', NULL, NULL, 'مارليات حدارا', 0),
(199, 3, 'Marlayet Melhem', NULL, NULL, 'مار ليا ملحم', 0),
(200, 3, 'Martmoura', NULL, NULL, 'القبيات مرتموره', 0),
(201, 3, 'Mazraat Al Balde', NULL, NULL, 'مزرعة بلدة', 0),
(202, 3, 'Mechaeilha Hakour', NULL, NULL, 'مشيلحة الحاكور', 0),
(203, 3, 'Mechmech', NULL, NULL, 'مشمش', 0),
(204, 3, 'Meghraq', NULL, NULL, 'المغراق', 0),
(205, 3, 'Meghraqa', NULL, NULL, 'مغراقا', 0),
(206, 3, 'Memnaa', NULL, NULL, 'ممنع', 0),
(207, 3, 'Mhamra', NULL, NULL, 'المحمرة', 0),
(208, 3, 'Mhatat Siket el Hadid', NULL, NULL, 'محطة سكة الحديد', 0),
(209, 3, 'Minyara', NULL, NULL, 'منيارة', 0),
(210, 3, 'Mouanse', NULL, NULL, 'المونسه', 0),
(211, 3, 'Mounjez', NULL, NULL, 'منجز', 0),
(212, 3, 'Mqaible', NULL, NULL, 'المقيبلة', 0),
(213, 3, 'Mqaitaa', NULL, NULL, 'مقيطع السماكلي', 0),
(214, 3, 'Mrah Aakkar', NULL, NULL, 'مراه عكار', 0),
(215, 3, 'Mrah Al Khawkh', NULL, NULL, 'مراح الخوخ', 0),
(216, 3, 'Mrah el Aainouni', NULL, NULL, 'مراه العينوني', 0),
(217, 3, 'Mrah el Bsatine', NULL, NULL, 'مراح البساتين', 0),
(218, 3, 'Mrah Qamar ed Dine', NULL, NULL, 'مراح قمر الدين', 0),
(219, 3, 'Msalla', NULL, NULL, 'مصلا', 0),
(220, 3, 'Mzeihmeh', NULL, NULL, 'مزيحمة', 0),
(221, 3, 'Nabaa el Ghzaile', NULL, NULL, 'نبع الغزيلة', 0),
(222, 3, 'Nahr El Bared', NULL, NULL, 'نهر البارد', 0),
(223, 3, 'Nahriye', NULL, NULL, 'النهريه', 0),
(224, 3, 'Nassriye', NULL, NULL, 'ناصرية', 0),
(225, 3, 'Nfaisseh', NULL, NULL, 'النفيسة', 0),
(226, 3, 'Noura', NULL, NULL, 'النوره', 0),
(227, 3, 'Noura el Faouqa et el Tahta', NULL, NULL, 'نورا الفوقا و التحتى', 0),
(228, 3, 'Noura el Tahta', NULL, NULL, 'نورا التحتا', 0),
(229, 3, 'Ouadi Ej jamous', NULL, NULL, 'وادي الجاموس', 0),
(230, 3, 'Qaabrine', NULL, NULL, 'قعبرين', 0),
(231, 3, 'Qabaait', NULL, NULL, 'قبعيت', 0),
(232, 3, 'Qanbar', NULL, NULL, 'القنبر', 0),
(233, 3, 'Qarha Akkar', NULL, NULL, 'قرحه عكار', 0),
(234, 3, 'Qarqaf', NULL, NULL, 'القرقف', 0),
(235, 3, 'Qbaiyat el Gharbiye', NULL, NULL, 'القبيات الغربية', 0),
(236, 3, 'Qbaiyat ez Zouq', NULL, NULL, 'القبيات الذوق', 0),
(237, 3, 'Qboula', NULL, NULL, 'قبولا', 0),
(238, 3, 'Qbour El Bid', NULL, NULL, 'قبور البيد', 0),
(239, 3, 'Qinye', NULL, NULL, 'قنية', 0),
(240, 3, 'Qloud El-Baqieh', NULL, NULL, 'قلود الباقية', 0),
(241, 3, 'Qochloq', NULL, NULL, 'قشلق', 0),
(242, 3, 'Qoubaiyat', NULL, NULL, 'القبيات', 0),
(243, 3, 'Qoubbet Chamra', NULL, NULL, 'قبة شمرا', 0),
(244, 3, 'Qraiyat', NULL, NULL, 'القريات', 0),
(245, 3, 'Rahbe', NULL, NULL, 'رحبة', 0),
(246, 3, 'Rajm Hssein', NULL, NULL, 'رجم حسين', 0),
(247, 3, 'Rajm Issa', NULL, NULL, 'رجم عيسى', 0),
(248, 3, 'Rajm Khalaf', NULL, NULL, 'رجم خلف', 0),
(249, 3, 'Rihaniye', NULL, NULL, 'الريحانية', 0),
(250, 3, 'Rmah En Nahriyeh', NULL, NULL, 'رماح النهريه', 0),
(251, 3, 'Rmoul', NULL, NULL, 'رمول', 0),
(252, 3, 'Saadine', NULL, NULL, 'سعدين', 0),
(253, 3, 'Sadaqa', NULL, NULL, 'صدقة', 0),
(254, 3, 'Sahle', NULL, NULL, 'السهله', 0),
(255, 3, 'Saidnaya', NULL, NULL, 'السنديانة', 0),
(256, 3, 'Saissouq', NULL, NULL, 'سيسوق', 0),
(257, 3, 'Sammouniye', NULL, NULL, 'السمونيه', 0),
(258, 3, 'Saoualha', NULL, NULL, 'ساولها', 0),
(259, 3, 'Sbagha', NULL, NULL, 'صباغا', 0),
(260, 3, 'Semmaqiye', NULL, NULL, 'السماقية', 0),
(261, 3, 'Semmaqli', NULL, NULL, 'سمقالي', 0),
(262, 3, 'Sfaynet El-Qaitaa', NULL, NULL, 'سفينة القيطع', 0),
(263, 3, 'Sfinet ed Dreib', NULL, NULL, 'سفينة الدريب', 0),
(264, 3, 'Shaqdouf Aakkar', NULL, NULL, 'شقدوف عكار', 0),
(265, 3, 'Sindianet Zeidane', NULL, NULL, 'سنديانة زيدان', 0),
(266, 3, 'Srar', NULL, NULL, 'سرار', 0),
(267, 3, 'Takrit', NULL, NULL, 'تكريت', 0),
(268, 3, 'Tal Meaayan', NULL, NULL, 'تلمعيان', 0),
(269, 3, 'Tall Aabbas Ech-Charqi', NULL, NULL, 'تل عباس الشرقي', 0),
(270, 3, 'Tall Aabbas el Gharbi', NULL, NULL, 'تلعباس غربي', 0),
(271, 3, 'Tall Bire', NULL, NULL, 'تلبيرة', 0),
(272, 3, 'Tall Hmayra', NULL, NULL, 'تلحميرة', 0),
(273, 3, 'Tallet el Mjabber', NULL, NULL, 'تلة المجابر', 0),
(274, 3, 'Tallet ez Zefir', NULL, NULL, 'تلة الزفير', 0),
(275, 3, 'Tashea', NULL, NULL, 'تاشع', 0),
(276, 3, 'Tell Bibi', NULL, NULL, 'تلبيبة', 0),
(277, 3, 'Tell Hayat', NULL, NULL, 'تل الحيات', 0),
(278, 3, 'Tell Kindi', NULL, NULL, 'تل كندي', 0),
(279, 3, 'Tell Kiri', NULL, NULL, 'تل كيري', 0),
(280, 3, 'Tell Sebael', NULL, NULL, 'تل سبعل', 0),
(281, 3, 'Tleil', NULL, NULL, 'التليل', 0),
(282, 3, 'Wadi Al Hoor', NULL, NULL, 'وادي الحور', 0),
(283, 3, 'Wadi Khaled', NULL, NULL, 'وادي خالد', 0),
(284, 3, 'Zouaitini Akkar', NULL, NULL, 'الزويتينة عكار', 0),
(285, 3, 'Zouarib', NULL, NULL, 'الزواريب', 0),
(286, 3, 'Zouk Haddara', NULL, NULL, 'ذوق حدارة', 0),
(287, 3, 'Zouq el Hassineh', NULL, NULL, 'ذوق الحصينة', 0),
(288, 3, 'Zouq El Mqachrine', NULL, NULL, 'ذوق المقشرين', 0),
(289, 3, 'Zouq El-Hbalsa', NULL, NULL, 'ذوق الحبالصة\"', 0),
(290, 6, 'Aadous', NULL, NULL, 'عدّوس', 0),
(291, 6, 'Aallaq', NULL, NULL, 'علاق', 0),
(292, 6, 'Aamchki', NULL, NULL, 'عمشكي', 0),
(293, 6, 'Aarsal', NULL, NULL, 'عرسال', 0),
(294, 6, 'Aayoun Orghoush', NULL, NULL, 'عيون ارغش', 0),
(295, 6, 'Ain Bourday', NULL, NULL, 'عين بورداي', 0),
(296, 6, 'Ain Ej Jaouze', NULL, NULL, 'عين الجوزة', 0),
(297, 6, 'Ain El Bnaiye', NULL, NULL, 'عين البنية', 0),
(298, 6, 'Ain es Saouda', NULL, NULL, 'عين السودا', 0),
(299, 6, 'Ainata', NULL, NULL, 'عيناتا', 0),
(300, 6, 'Al Ansar Baalbek', NULL, NULL, 'الأنصار بعلبك', 0),
(301, 6, 'Baalbek', NULL, NULL, 'بعلبك', 0),
(302, 6, 'Baayoun', NULL, NULL, 'قاع بعيون', 0),
(303, 6, 'Barqa', NULL, NULL, 'برقا', 0),
(304, 6, 'Bechouat', NULL, NULL, 'بشوات', 0),
(305, 6, 'Bednayel', NULL, NULL, 'بدنايل', 0),
(306, 6, 'Beit Chama', NULL, NULL, 'بيت شاما', 0),
(307, 6, 'Beit es Satiti', NULL, NULL, 'بيت الستيته', 0),
(308, 6, 'Beit Habchi', NULL, NULL, 'بيت حبشي', 0),
(309, 6, 'Beit Mchik', NULL, NULL, 'مزرعة بيت مشيك', 0),
(310, 6, 'Bejjaje', NULL, NULL, 'بجاجة', 0),
(311, 6, 'Betdaai', NULL, NULL, 'بتدعي', 0),
(312, 6, 'Blaiqa', NULL, NULL, 'بليقة', 0),
(313, 6, 'Boudai', NULL, NULL, 'بوداي', 0),
(314, 6, 'Britel', NULL, NULL, 'بريتال', 0),
(315, 6, 'Bsayleh al Fawka', NULL, NULL, 'بصيلة الفوقا', 0),
(316, 6, 'Bsayleh al Tahta', NULL, NULL, 'بصيلة التحتا', 0),
(317, 6, 'Chaat', NULL, NULL, 'شعت', 0),
(318, 6, 'Chlifa', NULL, NULL, 'شليفا', 0),
(319, 6, 'Chmistar', NULL, NULL, 'شمسطار', 0),
(320, 6, 'Daouret en Naml', NULL, NULL, 'دورة النمل', 0),
(321, 6, 'Dar el Ouassaa', NULL, NULL, 'دار الواسعة', 0),
(322, 6, 'Deir El Ahmar', NULL, NULL, 'دير الاحمر', 0),
(323, 6, 'Deir Mar Maroun Baalbek', NULL, NULL, 'دير مار مارون بعلبك', 0),
(324, 6, 'Douris', NULL, NULL, 'دوريس', 0),
(325, 6, 'El Aaiara', NULL, NULL, 'عيارة', 0),
(326, 6, 'El Ain', NULL, NULL, 'العين', 0),
(327, 6, 'El Barake', NULL, NULL, 'البركة', 0),
(328, 6, 'El Faqrat', NULL, NULL, 'فقرات', 0),
(329, 6, 'El Laouze', NULL, NULL, 'اللوزة', 0),
(330, 6, 'El Maalqa', NULL, NULL, 'معلقة الجديدة', 0),
(331, 6, 'El Marmagha', NULL, NULL, 'مرماغا', 0),
(332, 6, 'El Qaa', NULL, NULL, 'القاع', 0),
(333, 6, 'El Qerrami', NULL, NULL, 'قرامي', 0),
(334, 6, 'En Nouqra', NULL, NULL, 'نقرة', 0),
(335, 6, 'Fakehe', NULL, NULL, 'فاكهة', 0),
(336, 6, 'Flaoui', NULL, NULL, 'فلاوي', 0),
(337, 6, 'Freij', NULL, NULL, 'فريج', 0),
(338, 6, 'Hadet Hermel', NULL, NULL, 'حدت الهرمل', 0),
(339, 6, 'Hai el Mathane', NULL, NULL, 'حي المطحنة', 0),
(340, 6, 'Halbata', NULL, NULL, 'حلباتا', 0),
(341, 6, 'Ham', NULL, NULL, 'حام', 0),
(342, 6, 'Haouch Barada', NULL, NULL, 'حوش بردى', 0),
(343, 6, 'Haouch Ed Dahab', NULL, NULL, 'حوش الدهب', 0),
(344, 6, 'Haouch En Nabi', NULL, NULL, 'حوش النبي', 0),
(345, 6, 'Haouch Snaid', NULL, NULL, 'حوش سنيد', 0),
(346, 6, 'Haouch Tall Safiye', NULL, NULL, 'حوش تل صفية', 0),
(347, 6, 'Haouerte', NULL, NULL, 'حوارته', 0),
(348, 6, 'Haour Taala', NULL, NULL, 'حور تعلا', 0),
(349, 6, 'Harabta', NULL, NULL, 'حربتا', 0),
(350, 6, 'Harfouch', NULL, NULL, 'حرفوش', 0),
(351, 6, 'Hfayer', NULL, NULL, 'حفاير', 0),
(352, 6, 'Hizzine', NULL, NULL, 'حزين', 0),
(353, 6, 'Hosn ech Chadoura', NULL, NULL, 'حصن الشادورا', 0),
(354, 6, 'Houch Er Rafqa', NULL, NULL, 'حوش الرافقة', 0),
(355, 6, 'Iaat', NULL, NULL, 'ايعات', 0),
(356, 6, 'Jabaa', NULL, NULL, 'جبعا', 0),
(357, 6, 'Jabal Ech Chaaibe', NULL, NULL, 'جبل الشعيبة', 0),
(358, 6, 'Jabboule', NULL, NULL, 'جبولة', 0),
(359, 6, 'Janta', NULL, NULL, 'جنتا', 0),
(360, 6, 'Jdaide Fekehe', NULL, NULL, 'جديدة الفاكهة', 0),
(361, 6, 'Joubaniyeh', NULL, NULL, 'جوبانية', 0),
(362, 6, 'Kfar Dabach', NULL, NULL, 'كفر دبش', 0),
(363, 6, 'Kfar Dane', NULL, NULL, 'كفر دان', 0),
(364, 6, 'Kharayeb', NULL, NULL, 'الخرائب', 0),
(365, 6, 'Khermateh', NULL, NULL, 'خورماتا', 0),
(366, 6, 'Khirbet Daoud Baalbek', NULL, NULL, 'خربة داوود بعلبك', 0),
(367, 6, 'Khirbet et Tine', NULL, NULL, 'خربة التينه', 0),
(368, 6, 'Khirbet Haouerte', NULL, NULL, 'خربة حوارته', 0),
(369, 6, 'Khirbet Younine', NULL, NULL, 'خربة يونين', 0),
(370, 6, 'Khodor', NULL, NULL, 'خضر', 0),
(371, 6, 'Khraibe', NULL, NULL, 'خريبة', 0),
(372, 6, 'Knaisse', NULL, NULL, 'كنيسة', 0),
(373, 6, 'Laboue', NULL, NULL, 'لبوة', 0),
(374, 6, 'Maarboun', NULL, NULL, 'معربون', 0),
(375, 6, 'Mahatta', NULL, NULL, 'المحطة', 0),
(376, 6, 'Majdaloun', NULL, NULL, 'مجدلون', 0),
(377, 6, 'Maql el Bouadte', NULL, NULL, 'مقل البوادتي', 0),
(378, 6, 'Maqne', NULL, NULL, 'مقنة', 0),
(379, 6, 'Masnaa', NULL, NULL, 'المصنع', 0),
(380, 6, 'Masnaa es Zohr', NULL, NULL, 'مصنع الزهر', 0),
(381, 6, 'Mathanet Mousrayeh', NULL, NULL, 'مطحنة مصراية', 0),
(382, 6, 'Mazraat al Ramassy', NULL, NULL, 'مزرعة الرماسا', 0),
(383, 6, 'Mazraat Al Souaydane', NULL, NULL, 'مزرعة آل سويدان', 0),
(384, 6, 'Mazraat al Takch', NULL, NULL, 'مزرعة بيت طقش', 0),
(385, 6, 'Mazraat Beit el Ghoussain', NULL, NULL, 'مزرعة بيت الغصين', 0),
(386, 6, 'Mazraat Beit Slaibi', NULL, NULL, 'مزرعة بيت صليبي', 0),
(387, 6, 'Mazraat Ed Dallil', NULL, NULL, 'مزرعة الضليل', 0),
(388, 6, 'Mazraat ed Dhour', NULL, NULL, 'مزرعة الضهور', 0),
(389, 6, 'Mazraat Es Saiyed', NULL, NULL, 'مزرعة السيد', 0),
(390, 6, 'Mazraat Matar', NULL, NULL, 'مزرعة مطر', 0),
(391, 6, 'Mazraat Oumm Aali', NULL, NULL, 'مزرعة ام علي', 0),
(392, 6, 'Mchaitiye', NULL, NULL, 'مشيتية', 0),
(393, 6, 'Mehairfe', NULL, NULL, 'محيرفة', 0),
(394, 6, 'Mhattat Ras Baalbeck', NULL, NULL, 'المحطة راس بعلبك', 0),
(395, 6, 'Mkaybel Al Kala', NULL, NULL, 'مقيال القلعة', 0),
(396, 6, 'Moqraq', NULL, NULL, 'المقرق', 0),
(397, 6, 'Mrah Beit Aassaf', NULL, NULL, 'مراح بيت عساف', 0),
(398, 6, 'Mrah Beit el Qazah', NULL, NULL, 'مراح بيت القزح', 0),
(399, 6, 'Mrah Beit Slim', NULL, NULL, 'مراح بيت سليم', 0),
(400, 6, 'Mrah Bou Brahim', NULL, NULL, 'مراح بو براهيم', 0),
(401, 6, 'Mrah Bou Chahine', NULL, NULL, 'مراح بو شاهين', 0),
(402, 6, 'Mrah ech Chmis', NULL, NULL, 'مراح الشميس', 0),
(403, 6, 'Mrah ech Choaab', NULL, NULL, 'مراح الشعاب', 0),
(404, 6, 'Mrah ej Jamal', NULL, NULL, 'مراح', 0),
(405, 6, 'Mrah ej Jeddaoui', NULL, NULL, 'مراح الجداوي', 0),
(406, 6, 'Mrah El Aabed', NULL, NULL, 'مراه العبد', 0),
(407, 6, 'Mrah El Aaouja', NULL, NULL, 'مراح العوجا', 0),
(408, 6, 'Mrah El Aassi', NULL, NULL, 'مراح العاصي', 0),
(409, 6, 'Mrah el Ahmar', NULL, NULL, 'مراح الاحمر', 0),
(410, 6, 'Mrah el Blata', NULL, NULL, 'مراح البلاطة', 0),
(411, 6, 'Mrah EL Harfouch', NULL, NULL, 'مراح الحرفوش', 0),
(412, 6, 'Mrah es Sirghane', NULL, NULL, 'مراح السرغانه', 0),
(413, 6, 'Mrah Haissoun', NULL, NULL, 'مراح حيصون', 0),
(414, 6, 'Mrah Kloude', NULL, NULL, 'مراح القلود', 0),
(415, 6, 'Mrah Najib', NULL, NULL, 'مراح نجيب', 0),
(416, 6, 'Mrah Rafi', NULL, NULL, 'مراح رافي', 0),
(417, 6, 'Mrah Semaan', NULL, NULL, 'مراح سمعان', 0),
(418, 6, 'Mrah Soukkar', NULL, NULL, 'مراح سكر', 0),
(419, 6, 'Nabha', NULL, NULL, 'نبحا', 0),
(420, 6, 'Nabha Al Mohfara', NULL, NULL, 'نبحا المحفارة', 0),
(421, 6, 'Nabi Chit', NULL, NULL, 'نبي شيت', 0),
(422, 6, 'Nabi Osmane', NULL, NULL, 'نبي عثمان', 0),
(423, 6, 'Nabi Rachade', NULL, NULL, 'نبي رشاده', 0),
(424, 6, 'Nabi Sbat', NULL, NULL, 'النبي سباط', 0),
(425, 6, 'Nahle', NULL, NULL, 'نحله', 0),
(426, 6, 'Qaa Jouar Maqiyeh', NULL, NULL, 'قاع جوار مكية', 0),
(427, 6, 'Qaa Ouadi el Khanzir', NULL, NULL, 'قاع وادي الخنزير', 0),
(428, 6, 'Qalaat Bakdach', NULL, NULL, 'قلعة بكداش', 0),
(429, 6, 'Qalb es Sabaa', NULL, NULL, 'مزرعة قلد السبع', 0),
(430, 6, 'Qarha', NULL, NULL, 'قرحا', 0),
(431, 6, 'Qiddam', NULL, NULL, 'القدام', 0),
(432, 6, 'Qlaile', NULL, NULL, 'قليلة', 0),
(433, 6, 'Qsarnaba', NULL, NULL, 'قصرنابا', 0),
(434, 6, 'Ram', NULL, NULL, 'الرام', 0),
(435, 6, 'Ras al Assy', NULL, NULL, 'راس العاصي', 0),
(436, 6, 'Ras Baalbek', NULL, NULL, 'راس بعلبك', 0),
(437, 6, 'Ras Baalbek ech Charqi', NULL, NULL, 'راس بعلبك الشرقي', 0),
(438, 6, 'Ras Baalbek es Sahel', NULL, NULL, 'راس بعلبك السهل', 0),
(439, 6, 'Rasm El Hadet', NULL, NULL, 'رسم الحدث', 0),
(440, 6, 'Riha', NULL, NULL, 'ريحا', 0),
(441, 6, 'Saaide', NULL, NULL, 'سعيدة', 0),
(442, 6, 'Safra', NULL, NULL, 'صفرا', 0),
(443, 6, 'Saidet ed Dalil', NULL, NULL, 'سيدة الضليل', 0),
(444, 6, 'Saraain el Faouqa', NULL, NULL, 'سرعين الفوقا', 0),
(445, 6, 'Saraain et Tahta', NULL, NULL, 'سرعين التحتا', 0),
(446, 6, 'Sbouba', NULL, NULL, 'صبوبا', 0),
(447, 6, 'Sifri', NULL, NULL, 'سفري', 0),
(448, 6, 'Siret Hanna', NULL, NULL, 'سيرة هنا', 0),
(449, 6, 'Slouqi', NULL, NULL, 'سلوقي', 0),
(450, 6, 'Taibe Baalbek', NULL, NULL, 'طيبة بعلبك', 0),
(451, 6, 'Talia', NULL, NULL, 'طليا', 0),
(452, 6, 'Tall Sougha', NULL, NULL, 'تل سغى', 0),
(453, 6, 'Tallet ed Deir', NULL, NULL, 'تلة الدير', 0),
(454, 6, 'Tammine et Tahta', NULL, NULL, 'تمنين التحتا', 0),
(455, 6, 'Tamnine El Faouqa', NULL, NULL, 'تمنين الفوقا', 0),
(456, 6, 'Taraiya', NULL, NULL, 'طاريا', 0),
(457, 6, 'Tfail', NULL, NULL, 'طفيل', 0),
(458, 6, 'Toufiqiye', NULL, NULL, 'التوفيقية', 0),
(459, 6, 'Wadi el Assouad', NULL, NULL, 'وادي الاسود', 0),
(460, 6, 'Wadi el Oss', NULL, NULL, 'وادي القصص', 0),
(461, 6, 'Yahfoufa', NULL, NULL, 'يحفوفا', 0),
(462, 6, 'Yammoune', NULL, NULL, 'يمونة', 0),
(463, 6, 'Younine', NULL, NULL, 'يونين', 0),
(464, 6, 'Zabboud', NULL, NULL, 'زبود', 0),
(465, 6, 'Zarayeb', NULL, NULL, 'زرايب', 0),
(466, 6, 'Zarayeb Choukr', NULL, NULL, 'زرايب شكر', 0),
(467, 6, 'Zeribet es Sabha', NULL, NULL, 'زريبة الصبحا', 0),
(468, 6, 'Zrazir', NULL, NULL, 'زرازير', 0),
(469, 12, 'Aaqabe', NULL, NULL, 'عقبة', 0),
(470, 12, 'Ain al Jadideh', NULL, NULL, 'عين الجديدة الهرمل', 0),
(471, 12, 'Ain el bayda', NULL, NULL, 'عين البيضاء', 0),
(472, 12, 'Bdita', NULL, NULL, 'بديتا', 0),
(473, 12, 'Beit Aallam', NULL, NULL, 'بيت علام', 0),
(474, 12, 'Beit Aallaou', NULL, NULL, 'بيت علاّو', 0),
(475, 12, 'Beit es Semmaqa', NULL, NULL, 'بيت السماقة', 0),
(476, 12, 'Beit Hira', NULL, NULL, 'بيت حيرا', 0),
(477, 12, 'Berghoch', NULL, NULL, 'برغش', 0),
(478, 12, 'Biyout Aawad', NULL, NULL, 'بيوت عواد', 0),
(479, 12, 'Biyout el Ain', NULL, NULL, 'بيوت العين', 0),
(480, 12, 'Biyout el Hajj Hassan', NULL, NULL, 'بيوت الحاج حسن', 0),
(481, 12, 'Biyout er Rouais', NULL, NULL, 'بيوت الرويس', 0),
(482, 12, 'Biyout es Souh', NULL, NULL, 'بيوت السوح', 0),
(483, 12, 'Bou Sawaya', NULL, NULL, 'بو صوايا', 0),
(484, 12, 'Bouaida', NULL, NULL, 'بويضة', 0),
(485, 12, 'Boustane', NULL, NULL, 'بستان', 0),
(486, 12, 'Breij', NULL, NULL, 'البريج', 0),
(487, 12, 'Brissa', NULL, NULL, 'بريصا', 0),
(488, 12, 'Charbine', NULL, NULL, 'شربين', 0),
(489, 12, 'Chouaghir', NULL, NULL, 'شواغير', 0),
(490, 12, 'Ed Daoura el hermel', NULL, NULL, 'الدورة الهرمل', 0),
(491, 12, 'El Baaoul', NULL, NULL, 'البعول', 0),
(492, 12, 'El Mdawesh', NULL, NULL, 'مداوش', 0),
(493, 12, 'El Ouaqf', NULL, NULL, 'الوقف', 0),
(494, 12, 'El Qraita', NULL, NULL, 'قريتي', 0),
(495, 12, 'Es Souaidiye', NULL, NULL, 'سويدية', 0),
(496, 12, 'Faara', NULL, NULL, 'فعرا', 0),
(497, 12, 'Fissane', NULL, NULL, 'فيسان', 0),
(498, 12, 'Haouch Es Saiyad Aali', NULL, NULL, 'حوش السيد علي', 0),
(499, 12, 'Haouchariye', NULL, NULL, 'هوشرية', 0),
(500, 12, 'Haret El Maasser', NULL, NULL, 'حارة المعاصر', 0),
(501, 12, 'Hariqa el hermel', NULL, NULL, 'حريقة الهرمل', 0),
(502, 12, 'Hawch Beit Ismail', NULL, NULL, 'حوش بيت اسماعيل', 0),
(503, 12, 'Hermel', NULL, NULL, 'هرمل', 0),
(504, 12, 'Hermel Jbab', NULL, NULL, 'هرمل جباب', 0),
(505, 12, 'Hmaire', NULL, NULL, 'حميرة', 0),
(506, 12, 'Jawz', NULL, NULL, 'جوز', 0),
(507, 12, 'Jisr el Aassi', NULL, NULL, 'جسر العاصي', 0),
(508, 12, 'Jouar El Hachich', NULL, NULL, 'جوار الحشيش', 0),
(509, 12, 'Jouret el Mzar', NULL, NULL, 'جورة المزار', 0),
(510, 12, 'Kouakh', NULL, NULL, 'كواخ', 0),
(511, 12, 'Maaisr', NULL, NULL, 'معيصرة', 0),
(512, 12, 'Mansoureh', NULL, NULL, 'منصورة', 0),
(513, 12, 'Marj Hine', NULL, NULL, 'مرجحين', 0),
(514, 12, 'Mazraat Beit el Fqih', NULL, NULL, 'مزرعة بيت الفقيه', 0),
(515, 12, 'Mazraat Beit Et Tachm', NULL, NULL, 'مزرعة بيت الطشم', 0),
(516, 12, 'Mazraat Et Talle', NULL, NULL, 'مراح التلة', 0),
(517, 12, 'Mnaira', NULL, NULL, 'منيرة', 0),
(518, 12, 'Mrah Aabbas', NULL, NULL, 'مراح عباس', 0),
(519, 12, 'Mrah Beit Aalaoui', NULL, NULL, 'مراح بيت علاو', 0),
(520, 12, 'Mrah Bou Kamar al Dine', NULL, NULL, 'مراح بو قمر الدين', 0),
(521, 12, 'Mrah Ech Chaab', NULL, NULL, 'مراح الشعاب الهرمل', 0),
(522, 12, 'Mrah ech Charqi', NULL, NULL, 'مراح الشرقي', 0),
(523, 12, 'Mrah ech Chnain', NULL, NULL, 'مراح شنين', 0),
(524, 12, 'Mrah el Aaqabe', NULL, NULL, 'مراح العقبة', 0),
(525, 12, 'Mrah El Ain', NULL, NULL, 'مراح العين', 0),
(526, 12, 'Mrah el Arab', NULL, NULL, 'مراح العرب', 0),
(527, 12, 'Mrah El Dalil', NULL, NULL, 'مراح الدليل', 0),
(528, 12, 'Mrah el Gharbi', NULL, NULL, 'مراح الغربي', 0),
(529, 12, 'Mrah el Mahlise', NULL, NULL, 'مراح المحليسة', 0),
(530, 12, 'Mrah El Mouchref', NULL, NULL, 'مراح المشرف', 0),
(531, 12, 'Mrah El Mougher', NULL, NULL, 'مراح المغر', 0),
(532, 12, 'Mrah el Qorne', NULL, NULL, 'مراح القرنة', 0),
(533, 12, 'Mrah el Qraita', NULL, NULL, 'مراح القريتا', 0),
(534, 12, 'Mrah es Siyaid', NULL, NULL, 'مراح السياد', 0),
(535, 12, 'Mrah esh Shmis', NULL, NULL, 'مراح الشميس الهرمل', 0),
(536, 12, 'Mrah Ez Zakbe', NULL, NULL, 'مراح الزكبة', 0),
(537, 12, 'Mrah Houssain Taane', NULL, NULL, 'مراح حسين طعان', 0),
(538, 12, 'Mrah Naaouas', NULL, NULL, 'مراح النواس', 0),
(539, 12, 'Mrah Sejoud', NULL, NULL, 'مراح سجد', 0),
(540, 12, 'Mrah Yassine', NULL, NULL, 'مراح ياسين', 0),
(541, 12, 'Nasriye', NULL, NULL, 'ناصرية الهرمل', 0),
(542, 12, 'Ouadi en Nayra', NULL, NULL, 'وادي النيرة', 0),
(543, 12, 'Ouadi Er Ratle', NULL, NULL, 'وادي الرطل', 0),
(544, 12, 'Ouadi et Tourkmane', NULL, NULL, 'وادي التركمان', 0),
(545, 12, 'Qanafez', NULL, NULL, 'قنافذ', 0),
(546, 12, 'Qasr', NULL, NULL, 'القصر', 0),
(547, 12, 'Quadi el Karm', NULL, NULL, 'وادي الكرم', 0),
(548, 12, 'Ras Baalbek el Gharbi', NULL, NULL, 'راس بعلبك الغربي', 0),
(549, 12, 'Ras Baalbek Ouadi Faara', NULL, NULL, 'راس بعلبك وادي فعرا', 0),
(550, 12, 'Salhat El Ma', NULL, NULL, 'سهلات المي', 0),
(551, 12, 'Sharbine el Faouqa', NULL, NULL, 'شربين الفوقا', 0),
(552, 12, 'Souaisse', NULL, NULL, 'السويسة', 0),
(553, 12, 'Tall El far', NULL, NULL, 'تل الفار', 0),
(554, 12, 'Wadi Bnit', NULL, NULL, 'وادي بنيت', 0),
(555, 12, 'Wadi Faara', NULL, NULL, 'وادي فعرا', 0),
(556, 12, 'Zighrine', NULL, NULL, 'زغرين', 0),
(557, 12, 'Zighrine Et Tahta', NULL, NULL, 'زغرين التحتى', 0),
(558, 12, 'Zouaitini Zighrine', NULL, NULL, 'الزويتينه زغرين', 0),
(559, 8, 'Aadlyeh', NULL, NULL, 'العدلية', 0),
(560, 8, 'Achrafiye', NULL, NULL, 'الاشرفية', 0),
(561, 8, 'Ain El Tine', NULL, NULL, 'عين التينة', 0),
(562, 8, 'Ain Mreisse', NULL, NULL, 'عين المريسه', 0),
(563, 8, 'Al Hikmat', NULL, NULL, 'حكمة', 0),
(564, 8, 'Bab Idriss', NULL, NULL, 'باب إدريس', 0),
(565, 8, 'Bachoura', NULL, NULL, 'باشورة', 0),
(566, 8, 'Basta Faouka', NULL, NULL, 'بسطا الفوقا', 0),
(567, 8, 'Basta Tahta', NULL, NULL, 'بسطا التحتا', 0),
(568, 8, 'Beirut', NULL, NULL, 'بيروت', 0),
(569, 8, 'Beirut Central District', NULL, NULL, 'وسط بيروت', 0),
(570, 8, 'Bourj Abi Haidar', NULL, NULL, 'برج أبو حيدر', 0),
(571, 8, 'Champ de courses', NULL, NULL, 'ميدان سباق الخيل', 0),
(572, 8, 'Corniche El Naher', NULL, NULL, 'كورنيش النهر', 0),
(573, 8, 'Dar Al Fatwa', NULL, NULL, 'دارالفتوى', 0),
(574, 8, 'Ej Jeitaoui', NULL, NULL, 'جعيتاوي', 0),
(575, 8, 'El Aamliye', NULL, NULL, 'عاملية', 0),
(576, 8, 'El Ghabe', NULL, NULL, 'غابي', 0),
(577, 8, 'El Hamra', NULL, NULL, 'حمرا', 0),
(578, 8, 'El Horge', NULL, NULL, 'حرش', 0),
(579, 8, 'El Majidiye Beirut', NULL, NULL, 'مجيدية (بيروت)', 0),
(580, 8, 'El Manara', NULL, NULL, 'منارة', 0),
(581, 8, 'El Wata', NULL, NULL, 'الوطى', 0),
(582, 8, 'El Zarif', NULL, NULL, 'ظريف', 0),
(583, 8, 'Fourn el Hayek', NULL, NULL, 'فرن الحايك', 0),
(584, 8, 'Gemmayze', NULL, NULL, 'جميزة', 0),
(585, 8, 'Grand Serail', NULL, NULL, 'سراي الكبير', 0),
(586, 8, 'Hotel Dieu', NULL, NULL, 'اوتيل ديو', 0),
(587, 8, 'Jamia', NULL, NULL, 'الجامعة', 0),
(588, 8, 'Jisr', NULL, NULL, 'جسر', 0),
(589, 8, 'Jounblat', NULL, NULL, 'جنبلاط', 0),
(590, 8, 'Khodr', NULL, NULL, 'الخضر', 0),
(591, 8, 'La Sagesse', NULL, NULL, 'الحكمة', 0),
(592, 8, 'Malaab', NULL, NULL, 'ملعب', 0),
(593, 8, 'Manara', NULL, NULL, 'المنارة', 0),
(594, 8, 'Mar Elias', NULL, NULL, 'مار الياس', 0),
(595, 8, 'Mar Maroun', NULL, NULL, 'مار مارون', 0),
(596, 8, 'Mar Mitr', NULL, NULL, 'مار متر', 0),
(597, 8, 'Mar Mkhayel', NULL, NULL, 'مار مخايل', 0),
(598, 8, 'Mar Nqoula', NULL, NULL, 'مار نقولا', 0),
(599, 8, 'Marfaa', NULL, NULL, 'مرفأ', 0),
(600, 8, 'Mazraa', NULL, NULL, 'المزرعة', 0),
(601, 8, 'Medouar', NULL, NULL, 'مدور', 0),
(602, 8, 'Minet el Hosn', NULL, NULL, 'مينا الحصن', 0),
(603, 8, 'Moussaitbe', NULL, NULL, 'مصيطبة', 0),
(604, 8, 'Moustachfa er Roum', NULL, NULL, 'مستشفى الروم', 0),
(605, 8, 'Najmeh', NULL, NULL, 'النجمة', 0),
(606, 8, 'Nasra', NULL, NULL, 'الناصرة', 0),
(607, 8, 'Palais De Justice', NULL, NULL, 'قصر العدل', 0),
(608, 8, 'Parc', NULL, NULL, 'سباق الخيل', 0),
(609, 8, 'Patriarcat', NULL, NULL, 'بطركية', 0),
(610, 8, 'Place de l\'Etoile', NULL, NULL, 'ساحة النجمة', 0),
(611, 8, 'Qantari', NULL, NULL, 'قنطاري', 0),
(612, 8, 'Qobaiyat', NULL, NULL, 'قبيات', 0),
(613, 8, 'Qoraitem', NULL, NULL, 'قريطم', 0),
(614, 8, 'Ramlet el Bayda', NULL, NULL, 'الرملة البيضا', 0),
(615, 8, 'Raoucheh', NULL, NULL, 'روشه', 0),
(616, 8, 'Ras Beirut', NULL, NULL, 'راس بيروت', 0),
(617, 8, 'Ras El Nabaa', NULL, NULL, 'راس النبع', 0),
(618, 8, 'Remeil', NULL, NULL, 'رميل', 0),
(619, 8, 'Saife', NULL, NULL, 'صيفي', 0),
(620, 8, 'Sanayeh', NULL, NULL, 'الصنائع', 0),
(621, 8, 'Sioufi', NULL, NULL, 'السيوفي', 0),
(622, 8, 'Snoubra', NULL, NULL, 'صنوبره', 0),
(623, 8, 'Tallet Druze', NULL, NULL, 'تلة الدروز', 0),
(624, 8, 'Tallet el Khayat', NULL, NULL, 'تلة الخياط', 0),
(625, 8, 'Tariq El Jdide', NULL, NULL, 'طريق الجديدة', 0),
(626, 8, 'Unesco', NULL, NULL, 'الاونسكو', 0),
(627, 8, 'Universite Americaine', NULL, NULL, 'الجامعة الاميركية', 0),
(628, 8, 'Universite St Joseph', NULL, NULL, 'جامعة القديس يوسف', 0),
(629, 8, 'Zoqaq el Blat', NULL, NULL, 'زقاق البلاط', 0),
(630, 22, 'Aaiha', NULL, NULL, 'عيحا', 0),
(631, 22, 'Aaqbe', NULL, NULL, 'عقبة راشيّا', 0),
(632, 22, 'Aaz el Aarab', NULL, NULL, 'عز العرب', 0),
(633, 22, 'Ain Aarab', NULL, NULL, 'عين عرب', 0),
(634, 22, 'Ain Aata', NULL, NULL, 'عين عطا', 0),
(635, 22, 'Ain Hircha', NULL, NULL, 'عين حرشة', 0),
(636, 22, 'Aita el Foukhar', NULL, NULL, 'عيتا الفخار', 0),
(637, 22, 'Bakka', NULL, NULL, 'بكا', 0),
(638, 22, 'Bakkifa', NULL, NULL, 'بكيفا راشيا', 0),
(639, 22, 'Bayader el Aadas', NULL, NULL, 'بيادر العدس', 0),
(640, 22, 'Beit Lahia', NULL, NULL, 'بيت لهيا', 0),
(641, 22, 'Bire rachaya', NULL, NULL, 'بيرة راشّيا', 0),
(642, 22, 'Dahr el Ahmar', NULL, NULL, 'ضهر الاحمر', 0),
(643, 22, 'Deir el Aachayer', NULL, NULL, 'دير العشاير', 0),
(644, 22, 'El Faqaa', NULL, NULL, 'الفقعة', 0),
(645, 22, 'En Nabi Safa', NULL, NULL, 'نبي صفا', 0),
(646, 22, 'Haloua', NULL, NULL, 'حلوة', 0),
(647, 22, 'Haouch El Qinnabeh', NULL, NULL, 'حوش القنعبة', 0),
(648, 22, 'Haret el Kaouasbe', NULL, NULL, 'حارة الكواسبة', 0),
(649, 22, 'Jebb Farah', NULL, NULL, 'جب فرح', 0),
(650, 22, 'Kaoukaba', NULL, NULL, 'كوكبا', 0),
(651, 22, 'Kfar Danis', NULL, NULL, 'كفر دنيس', 0),
(652, 22, 'Kfar Mechki', NULL, NULL, 'كفر مشكي', 0),
(653, 22, 'Kfar Qouq', NULL, NULL, 'كفرقوق', 0),
(654, 22, 'Khirbet Rouha', NULL, NULL, 'خربة روحا', 0),
(655, 22, 'Majdal Balhis', NULL, NULL, 'مجدل بلهيص', 0),
(656, 22, 'Marj es Simah', NULL, NULL, 'مرج السماح', 0),
(657, 22, 'Mazraat Aazzi', NULL, NULL, 'مزرعة عزِي', 0),
(658, 22, 'Mazraat Ain Qeniye', NULL, NULL, 'مزرعة عين قنية', 0),
(659, 22, 'Mazraat Deir el Aachaiyer', NULL, NULL, 'مزرعة دير العشاير', 0),
(660, 22, 'Mazraat el Qalioun', NULL, NULL, 'مزرعة القليون', 0),
(661, 22, 'Mazraat Jaafar', NULL, NULL, 'مزرعة جعفر', 0),
(662, 22, 'Mazret Al Chmis', NULL, NULL, 'مزرعة الشميسة', 0),
(663, 22, 'Mdoukha', NULL, NULL, 'مدوخا', 0),
(664, 22, 'Mhaidse', NULL, NULL, 'محيدثه', 0),
(665, 22, 'Qnaabe', NULL, NULL, 'قنعبة', 0),
(666, 22, 'Rachaiya', NULL, NULL, 'راشيّا الوادي', 0),
(667, 22, 'Rafid', NULL, NULL, 'الرافد راشيا', 0),
(668, 22, 'Selsata Mazraat Dier el Aachayer', NULL, NULL, 'مزرعة سلساتا', 0),
(669, 22, 'Tannoura', NULL, NULL, 'تنورة', 0),
(670, 22, 'Yanta', NULL, NULL, 'ينطا', 0),
(671, 26, 'Aammiq', NULL, NULL, 'عميق', 0),
(672, 26, 'Aana', NULL, NULL, 'عانا', 0),
(673, 26, 'Ain et Tine West Bekaa', NULL, NULL, 'عين التينة بقاع الغربي', 0),
(674, 26, 'Ain Zebde', NULL, NULL, 'عين زبدة', 0),
(675, 26, 'Aitanit', NULL, NULL, 'عيتنيت', 0),
(676, 26, 'Al-Wakf', NULL, NULL, 'الوقف بقاع الغربي', 0),
(677, 26, 'Baaloul', NULL, NULL, 'بعلول', 0),
(678, 26, 'Bab Maraa', NULL, NULL, 'باب مارع', 0),
(679, 26, 'Chebreqiyet Aammiq', NULL, NULL, ' شبرقية عميق', 0),
(680, 26, 'Dakoue', NULL, NULL, 'دكوة', 0),
(681, 26, 'Deir Ain ej Jaouze', NULL, NULL, 'دير عين الجوزة', 0),
(682, 26, 'Deir Tahnich', NULL, NULL, 'دير طحنيش', 0),
(683, 26, 'El Jezire', NULL, NULL, 'الجزيرة', 0),
(684, 26, 'El Marj', NULL, NULL, 'المرج', 0),
(685, 26, 'Ghazze', NULL, NULL, 'غزة', 0),
(686, 26, 'Hammara', NULL, NULL, 'حمارة', 0),
(687, 26, 'Harime es Soughra', NULL, NULL, 'حريمة الصغرى', 0),
(688, 26, 'Houch Aammiq', NULL, NULL, 'حوش عميق', 0),
(689, 26, 'Houch el Harime', NULL, NULL, 'حوش الحريمة', 0),
(690, 26, 'Houch es Saalouk', NULL, NULL, 'حوش السعلوك', 0),
(691, 26, 'Joub Jannine', NULL, NULL, 'جب جنين', 0),
(692, 26, 'Kafraiya West Bekaa', NULL, NULL, 'كفريا بقاع الغربي', 0),
(693, 26, 'Kamed el Laouz', NULL, NULL, 'كامد اللوز', 0),
(694, 26, 'Khiara', NULL, NULL, 'الخيارة', 0),
(695, 26, 'Khiara el Aatiqa', NULL, NULL, 'خيارة العتيقة', 0),
(696, 26, 'Khirbet Qanafar', NULL, NULL, 'خربة قنافار', 0),
(697, 26, 'Lala', NULL, NULL, 'لالا', 0),
(698, 26, 'Libbaya', NULL, NULL, 'لبايا', 0),
(699, 26, 'Loussia', NULL, NULL, 'لوسيا', 0),
(700, 26, 'Machgara', NULL, NULL, 'مشغرة', 0),
(701, 26, 'Mansoura', NULL, NULL, 'المنصورة', 0),
(702, 26, 'Meidoun', NULL, NULL, 'ميدون', 0),
(703, 26, 'Nabaa el Khraizat', NULL, NULL, 'نبع الخريزات', 0),
(704, 26, 'Qaraoun', NULL, NULL, 'القرعون', 0),
(705, 26, 'Qillaya', NULL, NULL, 'قلايا', 0),
(706, 26, 'Raouda Istabl', NULL, NULL, 'روضة إسطبل', 0),
(707, 26, 'Saghbine', NULL, NULL, 'صغبين', 0),
(708, 26, 'Sohmor', NULL, NULL, 'سحمر', 0),
(709, 26, 'Souairi', NULL, NULL, 'صويري', 0),
(710, 26, 'Soultan Yaaqoub Aradi', NULL, NULL, 'سلطان يعقوب أراضي', 0),
(711, 26, 'Soultane Yaaqoub el Faouqa', NULL, NULL, 'سلطان يعقوب الفوقا', 0),
(712, 26, 'Soultane Yaaqoub el Tahta', NULL, NULL, 'سلطان يعقوب التحتا', 0),
(713, 26, 'Tall ez Zaazeaa', NULL, NULL, 'تل الزعزع', 0),
(714, 26, 'Tall Znoub', NULL, NULL, 'تل زنوب', 0),
(715, 26, 'Tall Znoub ej Jdide', NULL, NULL, 'تل زنوب جديدة', 0),
(716, 26, 'Yohmor West Bekaa', NULL, NULL, 'يحمر بقاع الغربي', 0),
(717, 26, 'Zellaya', NULL, NULL, 'زلايا', 0),
(718, 27, 'Aali en Nahri', NULL, NULL, 'علي النهري', 0),
(719, 27, 'Ablah', NULL, NULL, 'ابلح', 0),
(720, 27, 'Ain el Ghmiqa', NULL, NULL, 'عين الغميقة', 0),
(721, 27, 'Ain Kfar Zabad', NULL, NULL, 'عين كفر زبد', 0),
(722, 27, 'Al Faour', NULL, NULL, 'الفاعور', 0),
(723, 27, 'Anjar', NULL, NULL, 'عنجر', 0),
(724, 27, 'Bar Elias', NULL, NULL, 'بر الياس', 0),
(725, 27, 'Bayyadat', NULL, NULL, 'البياضة', 0),
(726, 27, 'Berbara zahle', NULL, NULL, 'بربارة زحلة', 0),
(727, 27, 'Bouarej', NULL, NULL, 'بوارج', 0),
(728, 27, 'Chamssine', NULL, NULL, 'شمسين', 0),
(729, 27, 'Chebrqiyet Tabet', NULL, NULL, 'شبرقية تابت', 0),
(730, 27, 'Chtaura', NULL, NULL, 'شتورا', 0),
(731, 27, 'Dahr al Harf', NULL, NULL, 'ضهر الحرف', 0),
(732, 27, 'Dahr Blait', NULL, NULL, 'ضهر البلايط', 0),
(733, 27, 'Dahr es Souane', NULL, NULL, 'ضهر الصوان', 0),
(734, 27, 'Dalhamiye', NULL, NULL, 'دلهميه', 0),
(735, 27, 'Deir el Ghazal', NULL, NULL, 'دير الغزال', 0),
(736, 27, 'Deir Zenoun', NULL, NULL, 'دير زنون', 0),
(737, 27, 'Er Ramtaniye', NULL, NULL, 'الرمطانية', 0),
(738, 27, 'Es Sraij', NULL, NULL, 'سريج', 0),
(739, 27, 'Fourzol', NULL, NULL, 'فرزل', 0),
(740, 27, 'Hakl Hammana', NULL, NULL, 'حقل حمانا', 0),
(741, 27, 'Haouch ed Dibs', NULL, NULL, 'حوش الدبس', 0),
(742, 27, 'Haouch el Mendara', NULL, NULL, 'حوش مندره', 0),
(743, 27, 'Haouch el Oumara Aradi', NULL, NULL, 'زحلة حوش الامراء أراضي', 0),
(744, 27, 'Haouch el Sayade', NULL, NULL, 'حوش الصيادي', 0),
(745, 27, 'Haouch Moussa Anjar', NULL, NULL, 'حوش موسى عنجر', 0),
(746, 27, 'Haret el Fikani', NULL, NULL, 'حارة الفيكاني', 0),
(747, 27, 'Hazerta', NULL, NULL, 'حزرتا', 0),
(748, 27, 'Hechmech', NULL, NULL, 'حشمش', 0),
(749, 27, 'Houch El-Ghanam', NULL, NULL, 'حوش الغنم', 0),
(750, 27, 'Houch ez Zaraane', NULL, NULL, 'حوش الزراعنة', 0),
(751, 27, 'Houch Hala', NULL, NULL, 'حوش حالا', 0),
(752, 27, 'Jdita', NULL, NULL, 'جديتا', 0),
(753, 27, 'Jlala', NULL, NULL, 'جلالا', 0),
(754, 27, 'Karak Nouh', NULL, NULL, 'كرك نوح', 0),
(755, 27, 'Kfar Zabad', NULL, NULL, 'كفر زبد', 0),
(756, 27, 'Koussaya', NULL, NULL, 'قوسايا', 0),
(757, 27, 'Ksara', NULL, NULL, 'كسارة', 0),
(758, 27, 'MADINAT AL SINA\'IYAT', NULL, NULL, 'مدينة الصناعية', 0),
(759, 27, 'Majdel Anjar', NULL, NULL, 'مجدل عنجر', 0),
(760, 27, 'Mar Elias Zahle', NULL, NULL, 'مار الياس زحلة', 0),
(761, 27, 'Masnaa Zahle', NULL, NULL, 'المصنع زحلة', 0),
(762, 27, 'Massa', NULL, NULL, 'مسا', 0),
(763, 27, 'Mazraat el Mehqane', NULL, NULL, 'مزرعة المحقان', 0),
(764, 27, 'Mazraat Zahle', NULL, NULL, 'مزرعة زحلة', 0),
(765, 27, 'Meksi', NULL, NULL, 'مكسة', 0),
(766, 27, 'Mreijat', NULL, NULL, 'مريجات', 0),
(767, 27, 'Naassate', NULL, NULL, 'نعصات', 0),
(768, 27, 'Nabi Aila', NULL, NULL, 'نبي ايلا', 0),
(769, 27, 'Nasriyet Rizq', NULL, NULL, 'ناصرية رزق', 0),
(770, 27, 'Nasriyet Zahle', NULL, NULL, 'ناصرية زحلة', 0),
(771, 27, 'Niha zahle', NULL, NULL, 'نيحا زحلة', 0),
(772, 27, 'Ouadi ed Deloum', NULL, NULL, 'وادي الدلم', 0),
(773, 27, 'Ouadi el Aarayech', NULL, NULL, 'وادي العرايش', 0),
(774, 27, 'Qaa er Rim', NULL, NULL, 'قاع الريم', 0),
(775, 27, 'Qabb Elias', NULL, NULL, 'قب الياس', 0),
(776, 27, 'Qarqoud', NULL, NULL, 'قرقود', 0),
(777, 27, 'Qeisser', NULL, NULL, 'قيصر', 0),
(778, 27, 'Qommol', NULL, NULL, 'قمّل', 0),
(779, 27, 'Raait', NULL, NULL, 'رعيت', 0),
(780, 27, 'Ras el Ain Zahle', NULL, NULL, 'راس العين زحلة', 0),
(781, 27, 'Rassiyeh', NULL, NULL, 'الراسية', 0),
(782, 27, 'Rayak', NULL, NULL, 'رياق', 0),
(783, 27, 'Saadnayel', NULL, NULL, 'سعدنايل', 0),
(784, 27, 'Sahret el Qach', NULL, NULL, 'صحرة القش', 0),
(785, 27, 'Taalabaya', NULL, NULL, 'تعلبايا', 0),
(786, 27, 'Taanayel', NULL, NULL, 'تعنايل', 0),
(787, 27, 'Tall el Akhdar', NULL, NULL, 'تل الاخضر', 0),
(788, 27, 'Tcheflik Eddeh Haouch', NULL, NULL, 'تشفلك اده حوش', 0),
(789, 27, 'Tcheflik Qiqano', NULL, NULL, 'تشفلك قيقانو', 0),
(790, 27, 'Tell Chiha', NULL, NULL, 'تل شيحا', 0),
(791, 27, 'Tell el Aamara', NULL, NULL, 'تل العمارة', 0),
(792, 27, 'Terbol', NULL, NULL, 'تربل', 0),
(793, 27, 'Touaite', NULL, NULL, 'تويتي', 0),
(794, 27, 'Zahle', NULL, NULL, 'زحلة', 0),
(795, 27, 'Zahle Mar Antonios', NULL, NULL, 'زحلة مار أنطونيوس', 0),
(796, 27, 'Zahle Mar Gerges', NULL, NULL, 'زحلة مار جرجس', 0),
(797, 27, 'Zahle Saydet En Najat', NULL, NULL, 'زحلة سيدة النجاة', 0),
(798, 27, 'Zahle Aradi', NULL, NULL, 'زحلة أراضي', 0),
(799, 27, 'Zahle Maalaqa Aradi', NULL, NULL, 'زحلة معلقة أراضي', 0),
(800, 27, 'Zebdol', NULL, NULL, 'زبدل', 0),
(845, 9, 'Aainata', NULL, NULL, 'عيناتا بنت جبيل', 0),
(846, 9, 'Aaitaroun', NULL, NULL, 'عيترون', 0),
(847, 9, 'Aayta ej Jabal Zott', NULL, NULL, 'عيتا الجبل الزط', 0),
(848, 9, 'Ain Ebel', NULL, NULL, 'عين ابل', 0),
(849, 9, 'Aita Ech Chaab', NULL, NULL, 'عيتا الشعب', 0),
(850, 9, 'Beit Lif', NULL, NULL, 'بيت ليف', 0),
(851, 9, 'Beit Yahnoun', NULL, NULL, 'بيت ياحون', 0),
(852, 9, 'Bent Jubail', NULL, NULL, 'بنت جبيل', 0),
(853, 9, 'Bir es Sanassel', NULL, NULL, 'بير السناسل', 0),
(854, 9, 'Borj Qalaouiye', NULL, NULL, 'برج قلويه', 0),
(855, 9, 'Braachit', NULL, NULL, 'برعشيت', 0),
(856, 9, 'Chaqra', NULL, NULL, 'شقرا', 0),
(857, 9, 'Debl Oummiya', NULL, NULL, 'دبل امية', 0),
(858, 9, 'Deir Ntar', NULL, NULL, 'دير نطار', 0),
(859, 9, 'Doubiye', NULL, NULL, 'دوبية', 0),
(860, 9, 'El Birke', NULL, NULL, 'البركه بنت جبيل', 0),
(861, 9, 'El Biyad', NULL, NULL, 'البياد', 0),
(862, 9, 'Froun', NULL, NULL, 'فرون', 0),
(863, 9, 'Ghandouriye Bent Jbeil', NULL, NULL, 'غندورية بنت جبيل', 0),
(864, 9, 'Haddatha', NULL, NULL, 'حداثا', 0),
(865, 9, 'Hanine', NULL, NULL, 'حنين', 0),
(866, 9, 'Hariss', NULL, NULL, 'حاريص', 0),
(867, 9, 'Hay el Jameaa', NULL, NULL, 'الجامع بنت جبيل', 0),
(868, 9, 'Jmaijime', NULL, NULL, 'جميجمة', 0),
(869, 9, 'Kafra Bent Jbeil', NULL, NULL, 'كفرا بنت جبيل', 0),
(870, 9, 'Kfar Dounine', NULL, NULL, 'كفر دونين', 0),
(871, 9, 'Khirbit Silim', NULL, NULL, 'خربة سلم', 0),
(872, 9, 'Kounine', NULL, NULL, 'كونين', 0),
(873, 9, 'Maroun er Ras', NULL, NULL, 'مارون الراس', 0),
(874, 9, 'Mazraat Aazze', NULL, NULL, 'مزرعة عزه', 0),
(875, 9, 'Qalaouiye', NULL, NULL, 'قلويه', 0),
(876, 9, 'Qaouzah', NULL, NULL, 'قوزح', 0),
(877, 9, 'Qatmoun', NULL, NULL, 'قطموم', 0),
(878, 9, 'Rachaf', NULL, NULL, 'رشاف', 0),
(879, 9, 'Ramiye', NULL, NULL, 'رامية بنت جبيل', 0),
(880, 9, 'Rmaich', NULL, NULL, 'رميش', 0),
(881, 9, 'Safad el Battikh', NULL, NULL, 'صفد البطيخ', 0),
(882, 9, 'Salhani', NULL, NULL, 'الصلحاني', 0),
(883, 9, 'Soultaniye', NULL, NULL, 'سلطانية', 0),
(884, 9, 'Sribbine', NULL, NULL, 'صربين', 0),
(885, 9, 'Taire', NULL, NULL, 'طيري', 0),
(886, 9, 'Tebnine', NULL, NULL, 'تبنين', 0),
(887, 9, 'Yaroun', NULL, NULL, 'يارون', 0),
(888, 9, 'Yater', NULL, NULL, 'ياطر', 0),
(889, 16, 'Aabba', NULL, NULL, 'عبا', 0),
(890, 16, 'Aadchit ech Chqif', NULL, NULL, 'عدشيت الشقيف', 0),
(891, 16, 'Aali et Taher', NULL, NULL, 'علي الطاهر', 0),
(892, 16, 'Aarnoun', NULL, NULL, 'أرنون', 0),
(893, 16, 'Aazze', NULL, NULL, 'عزه', 0),
(894, 16, 'Ain Qana', NULL, NULL, 'عين قانا', 0),
(895, 16, 'Arab Salim', NULL, NULL, 'عرب صاليم', 0),
(896, 16, 'Braiqaa', NULL, NULL, 'بريقع', 0),
(897, 16, 'Charqiye', NULL, NULL, 'شرقية', 0),
(898, 16, 'Choukine', NULL, NULL, 'شوكين', 0),
(899, 16, 'Deir ez Zahrani', NULL, NULL, 'دير الزهراني', 0),
(900, 16, 'Doueir El Nabatieh', NULL, NULL, 'الدوير النبطية', 0),
(901, 16, 'El Aaqide', NULL, NULL, 'عقيدة', 0),
(902, 16, 'El Bayad', NULL, NULL, 'نبطية البياض', 0),
(903, 16, 'El Midane', NULL, NULL, 'الميدان', 0),
(904, 16, 'Es Serail', NULL, NULL, 'السراي', 0),
(905, 16, 'Habbouch', NULL, NULL, 'حبوش', 0),
(906, 16, 'Hamra En-Nabattiyeh', NULL, NULL, 'الحمرا النبطية', 0),
(907, 16, 'Harouf', NULL, NULL, 'حروف', 0),
(908, 16, 'Hima Aarnoun', NULL, NULL, 'حمى أرنون', 0),
(909, 16, 'Hmaile', NULL, NULL, 'حميلة', 0),
(910, 16, 'Houmine el Faouqa', NULL, NULL, 'حومين الفوقا', 0),
(911, 16, 'Houmine et Tahta', NULL, NULL, 'حومين التحتا', 0),
(912, 16, 'Insar', NULL, NULL, 'إنصار', 0),
(913, 16, 'Jaouhariye', NULL, NULL, 'جوهرية', 0),
(914, 16, 'Jarjouaa', NULL, NULL, 'جرجوع', 0),
(915, 16, 'Jbaa El Nabatieh', NULL, NULL, 'جباع النبطية', 0),
(916, 16, 'Jibchit', NULL, NULL, 'جبشيت', 0),
(917, 16, 'Kafra', NULL, NULL, 'كفرا', 0),
(918, 16, 'Kfar Dajjal', NULL, NULL, 'كفردجال', 0),
(919, 16, 'Kfar Fila', NULL, NULL, 'كفرفيلا', 0),
(920, 16, 'Kfar Roummane', NULL, NULL, 'كفر رمان', 0),
(921, 16, 'Kfar Sir', NULL, NULL, 'كفرصير', 0),
(922, 16, 'Kfar Tebnit', NULL, NULL, 'كفر تبنيت', 0),
(923, 16, 'Kfaroue', NULL, NULL, 'كفروة أو بفروة', 0),
(924, 16, 'Kfour El Nabatieh', NULL, NULL, 'الكفور النبطية', 0),
(925, 16, 'Maifadoun', NULL, NULL, 'ميفدون', 0),
(926, 16, 'Manzleh', NULL, NULL, 'المنزلة', 0),
(927, 16, 'Mazraat Ain Bou Souar', NULL, NULL, 'مزرعة عين بوسوار', 0),
(928, 16, 'Mazraat Bsafour', NULL, NULL, 'مزرعة بصفُور', 0),
(929, 16, 'Mazraat Chelbael', NULL, NULL, 'مزرعة شلبعل', 0),
(930, 16, 'Mazraat Dmoul', NULL, NULL, 'مزرعة دمول', 0),
(931, 16, 'Mazraat el Baiyad', NULL, NULL, 'مزرعة البياض', 0),
(932, 16, 'Mazraat el Khraibe', NULL, NULL, 'مزرعة الخريبة', 0),
(933, 16, 'Mazraat Kfar ej Jouz', NULL, NULL, 'مزرعة كفر جوز', 0),
(934, 16, 'Mazraat Maqsam Aali et Taher', NULL, NULL, 'مزرعة علي الطاهر', 0),
(935, 16, 'Mazraat Qalaat Meis', NULL, NULL, 'مزرعة قلعة ميس', 0),
(936, 16, 'Nabatiye el Faouqa', NULL, NULL, 'نبطية الفوقا', 0),
(937, 16, 'Nabatiye el Tahta', NULL, NULL, 'نبطية التحتا', 0),
(938, 16, 'Nmairiye', NULL, NULL, 'نميرية', 0),
(939, 16, 'Qaaqaait ej Jisr', NULL, NULL, 'قعقعية الجسر', 0),
(940, 16, 'Qsaibe El Nabatieh', NULL, NULL, 'قصيبة النبطية', 0),
(941, 16, 'Roumine', NULL, NULL, 'رومين', 0),
(942, 16, 'Sarba El Nabatieh', NULL, NULL, 'صربا النبطية', 0),
(943, 16, 'Sir el Gharbiye', NULL, NULL, 'صير الغربية', 0),
(944, 16, 'Toul', NULL, NULL, 'تول', 0),
(945, 16, 'Yohmor', NULL, NULL, 'يحمر', 0),
(946, 16, 'Zaoutar ech Charqiye', NULL, NULL, 'زوطر الشرقية', 0),
(947, 16, 'Zaoutar el Gharbiye', NULL, NULL, 'زوطر الغربية', 0),
(948, 16, 'Zebdine El Nabatieh', NULL, NULL, 'زبدين النبطية', 0),
(949, 16, 'Zefta', NULL, NULL, 'زفتا', 0),
(950, 17, 'Abou Qamha', NULL, NULL, 'أبو قمحة', 0),
(951, 17, 'Ain Jerfa', NULL, NULL, 'عين جرفا', 0),
(952, 17, 'Ain Qenya', NULL, NULL, 'عين قنيا', 0),
(953, 17, 'Ain Tanta', NULL, NULL, 'عين تنتا حاصبيا', 0),
(954, 17, 'Ayn et Tine', NULL, NULL, 'عين التينة حاصبيا', 0),
(955, 17, 'Bathaniye', NULL, NULL, 'بيتسنيا', 0),
(956, 17, 'Berghoz', NULL, NULL, 'برغز', 0),
(957, 17, 'Chebaa', NULL, NULL, 'شبعا', 0),
(958, 17, 'Chouaia', NULL, NULL, 'شويّا', 0),
(959, 17, 'Dehayrjate', NULL, NULL, 'الدحيرجات', 0),
(960, 17, 'Dellafi', NULL, NULL, 'دلافة', 0),
(961, 17, 'El Majidiye', NULL, NULL, 'مجيدية حاصبيا', 0),
(962, 17, 'Fardis', NULL, NULL, 'الفرديس', 0),
(963, 17, 'Fashkoul', NULL, NULL, 'فشكول', 0),
(964, 17, 'Halta Hasbaya', NULL, NULL, 'حلتا حاصبيّا', 0),
(965, 17, 'Hasbaiya', NULL, NULL, 'حاصبيّا', 0),
(966, 17, 'Hebbariye', NULL, NULL, 'هبّارية', 0),
(967, 17, 'Kaoukaba Hasbaya', NULL, NULL, 'كوكبا حاصبيّا', 0),
(968, 17, 'Kfair', NULL, NULL, 'كفير الزيت', 0),
(969, 17, 'Kfar Chouba', NULL, NULL, 'كفر شوبا', 0),
(970, 17, 'Kfar Hamam', NULL, NULL, 'كفرحمام', 0),
(971, 17, 'Khallet el Ghazale', NULL, NULL, 'خلة الغزالة', 0),
(972, 17, 'Khalouat el Biyada', NULL, NULL, 'خلوات البياضة', 0),
(973, 17, 'Khalouat Hasbaya', NULL, NULL, 'خلوات حاصبيّا', 0),
(974, 17, 'Khirbet ed Dwayr', NULL, NULL, 'خربة الدوير', 0),
(975, 17, 'Khraibe Hasbaya', NULL, NULL, 'خريبة حاصبيّا', 0),
(976, 17, 'Mari', NULL, NULL, 'ماري', 0),
(977, 17, 'Marj Ez Zouhour Dnaibe', NULL, NULL, 'مرج الزهور الدنيبة', 0),
(978, 17, 'Mazraat Qafoua', NULL, NULL, 'مزرعة قفوى', 0),
(979, 17, 'Mazraat Ras el Baidar', NULL, NULL, 'مزرعة راس البيدر', 0),
(980, 17, 'Mimes', NULL, NULL, 'ميمس', 0),
(981, 17, 'Ouazzani', NULL, NULL, 'وزاني', 0),
(982, 17, 'Rachaiya el Foukhar', NULL, NULL, 'راشيّا الفخار', 0),
(983, 17, 'Slaiyeb', NULL, NULL, 'صلايب', 0),
(984, 17, 'Tallet el Qaaqour', NULL, NULL, 'تلة القعقور', 0),
(985, 17, 'Zaghla', NULL, NULL, 'زغلة', 0),
(986, 21, 'MAZRAAT ZAIYEH', NULL, NULL, 'مزرعة زئية', 0),
(987, 21, 'Aadaisse', NULL, NULL, 'عديسة مرجعيون', 0),
(988, 21, 'Aadchit el Qoussair', NULL, NULL, 'عدشيت القصير', 0),
(989, 21, 'Aalmane', NULL, NULL, 'علمانة', 0),
(990, 21, 'Aamra', NULL, NULL, 'عمرة', 0),
(991, 21, 'Aarab el Louaize', NULL, NULL, 'عرب اللويزة', 0),
(992, 21, 'Ain Aarab Marjaayoun', NULL, NULL, 'عين عرب مرجعيون', 0),
(993, 21, 'Baiyouda', NULL, NULL, 'بويضة مرجعيون', 0),
(994, 21, 'Beni Haiyane', NULL, NULL, 'بني حيان', 0),
(995, 21, 'Blat Marjaayoun', NULL, NULL, 'بلاط مرجعيون', 0),
(996, 21, 'Blida', NULL, NULL, 'بليدا', 0),
(997, 21, 'Borj El Mlouk', NULL, NULL, 'برج الملوك', 0),
(998, 21, 'Deir Mimas', NULL, NULL, 'دير ميماس', 0),
(999, 21, 'Deir Siriane', NULL, NULL, 'دير سريان', 0),
(1000, 21, 'Dibbine', NULL, NULL, 'دبين', 0),
(1001, 21, 'Houla', NULL, NULL, 'حولا', 0),
(1002, 21, 'Houra', NULL, NULL, 'حوره', 0),
(1003, 21, 'Ibl es Saqi', NULL, NULL, 'إبل السقي', 0),
(1004, 21, 'Jlali el Ghozlane', NULL, NULL, 'جلال الغزلان', 0),
(1005, 21, 'Kfar Kila', NULL, NULL, 'كفركيلا', 0),
(1006, 21, 'Khiam', NULL, NULL, 'الخيام', 0),
(1007, 21, 'Khirbe', NULL, NULL, 'خربة برج الملوك', 0),
(1008, 21, 'Maissate', NULL, NULL, 'الميسات', 0),
(1009, 21, 'Majdel Silim', NULL, NULL, 'مجدل سلم', 0),
(1010, 21, 'Marjaayoun', NULL, NULL, 'مرجعيون', 0),
(1011, 21, 'Markaba', NULL, NULL, 'مركبا', 0),
(1012, 21, 'Mazraat Doumiat', NULL, NULL, 'مزرعة دمياط', 0),
(1013, 21, 'Mazraat ej Jreine', NULL, NULL, 'مزرعة الجرين', 0),
(1014, 21, 'Mazraat Sahsahiye', NULL, NULL, 'مزرعة السهسهية', 0),
(1015, 21, 'Meiss ej Jabal', NULL, NULL, 'ميس الجبل', 0),
(1016, 21, 'Mhaibib', NULL, NULL, 'محيبيب', 0),
(1017, 21, 'Qabrikha', NULL, NULL, 'قبريخا', 0),
(1018, 21, 'Qalaat Doubai', NULL, NULL, 'قلعة دبي', 0),
(1019, 21, 'Qantara', NULL, NULL, 'قنطرة', 0),
(1020, 21, 'Qlaiaa', NULL, NULL, 'قليعة', 0),
(1021, 21, 'Qsair', NULL, NULL, 'قصير', 0),
(1022, 21, 'Rabb et Talatine', NULL, NULL, 'رب التلاتين', 0),
(1023, 21, 'Sarda', NULL, NULL, 'مزرعة سردة', 0),
(1024, 21, 'Serail', NULL, NULL, 'سراي', 0),
(1025, 21, 'Souane Marjaayoun', NULL, NULL, 'صوانة مرجعيون', 0),
(1026, 21, 'Taibe Marjaayoun', NULL, NULL, 'طيبة مرجعيون', 0),
(1027, 21, 'Tallouse', NULL, NULL, 'طلوسة', 0);
INSERT INTO `area` (`id`, `caza_id`, `name`, `created_at`, `updated_at`, `arabic`, `gouvernate_id`) VALUES
(1028, 21, 'Touline', NULL, NULL, 'تولين', 0),
(1029, 4, 'Aabey', NULL, NULL, 'عبيه', 0),
(1030, 4, 'Aaley ej Jdide', NULL, NULL, 'عاليه الجديدة', 0),
(1031, 4, 'Aamroussieh Choueifat', NULL, NULL, 'عمروسية الشويفات', 0),
(1032, 4, 'Aaramoun', NULL, NULL, 'عرمون', 0),
(1033, 4, 'Aazzouniye', NULL, NULL, 'العزونيه', 0),
(1034, 4, 'Ain Al Saydeh', NULL, NULL, 'عين السيدة', 0),
(1035, 4, 'Ain Anoub', NULL, NULL, 'عين عنوب', 0),
(1036, 4, 'Ain Dara', NULL, NULL, 'عين داره', 0),
(1037, 4, 'Ain Drafil', NULL, NULL, 'عين درافيل', 0),
(1038, 4, 'Ain ej Jdide', NULL, NULL, 'عين الجديدة', 0),
(1039, 4, 'Ain el Fraidis', NULL, NULL, 'عين الفريديس', 0),
(1040, 4, 'Ain el Halzoun', NULL, NULL, 'عين الحلزون', 0),
(1041, 4, 'Ain el Jaouze', NULL, NULL, 'عين الجوزه', 0),
(1042, 4, 'Ain el Marj', NULL, NULL, 'عين المرج', 0),
(1043, 4, 'Ain er Remmane', NULL, NULL, 'عين الرمانة', 0),
(1044, 4, 'Ain Hala', NULL, NULL, 'عين حالا', 0),
(1045, 4, 'Ain Ksour', NULL, NULL, 'عين كسور', 0),
(1046, 4, 'Ain Trez', NULL, NULL, 'عين تراز', 0),
(1047, 4, 'Ainab', NULL, NULL, 'عيناب', 0),
(1048, 4, 'Aitat', NULL, NULL, 'عيتات', 0),
(1049, 4, 'Aley', NULL, NULL, 'عاليه', 0),
(1050, 4, 'Baaouerta', NULL, NULL, 'بعورته', 0),
(1051, 4, 'Baissour', NULL, NULL, 'بيصور', 0),
(1052, 4, 'Bchamoun', NULL, NULL, 'بشامون', 0),
(1053, 4, 'Bdedoun', NULL, NULL, 'بدادون', 0),
(1054, 4, 'Bedghane', NULL, NULL, 'بدغان', 0),
(1055, 4, 'Bhamdoun ed Dayaa', NULL, NULL, 'بحمدون الضيعة', 0),
(1056, 4, 'Bhamdoun el Mhatta', NULL, NULL, 'بحمدون المحطة', 0),
(1057, 4, 'Bhouara', NULL, NULL, 'بحوارا', 0),
(1058, 4, 'Bihat', NULL, NULL, 'بهات', 0),
(1059, 4, 'Bkhechtay', NULL, NULL, 'بخشتيه', 0),
(1060, 4, 'Blaibel', NULL, NULL, 'بليبل', 0),
(1061, 4, 'Bmahray', NULL, NULL, 'بمهريه', 0),
(1062, 4, 'Bmekkine', NULL, NULL, 'بمكين', 0),
(1063, 4, 'Bnaiye', NULL, NULL, 'البينه', 0),
(1064, 4, 'Botros', NULL, NULL, 'بطرس', 0),
(1065, 4, 'Bou Zraid', NULL, NULL, 'بو زريدة', 0),
(1066, 4, 'Bou Zraide', NULL, NULL, 'بو زريده', 0),
(1067, 4, 'Bourdine', NULL, NULL, 'بردين', 0),
(1068, 4, 'Bsatine', NULL, NULL, 'البساتين', 0),
(1069, 4, 'Bserrine', NULL, NULL, 'بسرين', 0),
(1070, 4, 'Bsous', NULL, NULL, 'بسوس', 0),
(1071, 4, 'Btalloun', NULL, NULL, 'بطلون', 0),
(1072, 4, 'Btater', NULL, NULL, 'بتاتر', 0),
(1073, 4, 'Chamlikh', NULL, NULL, 'شاملخ', 0),
(1074, 4, 'Chanay', NULL, NULL, 'شانيه', 0),
(1075, 4, 'Charoun', NULL, NULL, 'شارون', 0),
(1076, 4, 'Chartoun', NULL, NULL, 'شرتون', 0),
(1077, 4, 'Chemlane', NULL, NULL, 'شملان', 0),
(1078, 4, 'Chqif Btalloun', NULL, NULL, 'شقيف بطلون', 0),
(1079, 4, 'Dahr El Ouahch', NULL, NULL, 'ضهر الوحش', 0),
(1080, 4, 'Daqqoun', NULL, NULL, 'دقون', 0),
(1081, 4, 'Deir Qoubil', NULL, NULL, 'دير قوبل', 0),
(1082, 4, 'Dfoun', NULL, NULL, 'دفون', 0),
(1083, 4, 'Doueir er Remmane', NULL, NULL, 'دوير الرمان', 0),
(1084, 4, 'El Blat', NULL, NULL, 'بلاط سلفايا', 0),
(1085, 4, 'El Ftaihat', NULL, NULL, 'الفتيحات', 0),
(1086, 4, 'El Ouata', NULL, NULL, 'الوطا', 0),
(1087, 4, 'En Njassa', NULL, NULL, 'النجاصة', 0),
(1088, 4, 'Es Shwayfate', NULL, NULL, 'الشويفات', 0),
(1089, 4, 'Fsaqine', NULL, NULL, 'فساقين', 0),
(1090, 4, 'Ghaboun', NULL, NULL, 'الغابون', 0),
(1091, 4, 'Ghadir', NULL, NULL, 'غادير', 0),
(1092, 4, 'Habramoun', NULL, NULL, 'حبرمون', 0),
(1093, 4, 'Haret Chbib', NULL, NULL, 'حارة شبيب', 0),
(1094, 4, 'Haret el Mir', NULL, NULL, 'حارة المير', 0),
(1095, 4, 'Haret Salem', NULL, NULL, 'حارة سالم', 0),
(1096, 4, 'Hay el Aarab', NULL, NULL, 'حي العرب', 0),
(1097, 4, 'Hay es Sellom', NULL, NULL, 'حي السلم', 0),
(1098, 4, 'Hay es Sindiane', NULL, NULL, 'حي السنديانة', 0),
(1099, 4, 'Homs Oua Hama', NULL, NULL, 'حمص وحمى', 0),
(1100, 4, 'Houmal', NULL, NULL, 'حومال', 0),
(1101, 4, 'Ighmid', NULL, NULL, 'اغميد', 0),
(1102, 4, 'Jabal El Aarid', NULL, NULL, 'جبل العريض', 0),
(1103, 4, 'Jisr el Qadi', NULL, NULL, 'جسر القاضي', 0),
(1104, 4, 'Kahale', NULL, NULL, 'الكحاله', 0),
(1105, 4, 'Kaifoun', NULL, NULL, 'كيفون', 0),
(1106, 4, 'Kfar Aamaiy', NULL, NULL, 'كفرعميه', 0),
(1107, 4, 'Kfar Matta', NULL, NULL, 'كفرمتى', 0),
(1108, 4, 'Khalde', NULL, NULL, 'خلدة', 0),
(1109, 4, 'Kliliye', NULL, NULL, 'كليلة', 0),
(1110, 4, 'Maaroufiye', NULL, NULL, 'معروفية', 0),
(1111, 4, 'Maasraiti', NULL, NULL, 'معصريتي', 0),
(1112, 4, 'Majdalaya', NULL, NULL, 'مجدليا', 0),
(1113, 4, 'Mansouriye bhamdoun', NULL, NULL, 'منصورية بحمدون', 0),
(1114, 4, 'Mantra', NULL, NULL, 'المنطرة', 0),
(1115, 4, 'Marj Chartoun', NULL, NULL, 'مرج شرتون', 0),
(1116, 4, 'Mazraat el Boueit', NULL, NULL, 'مزرعة البويت', 0),
(1117, 4, 'Mazraat en Nahr', NULL, NULL, 'مزرعة النهر', 0),
(1118, 4, 'Mechakhti', NULL, NULL, 'مشاقتي', 0),
(1119, 4, 'Mechrefe', NULL, NULL, 'مشرفه', 0),
(1120, 4, 'Mejdel Baana', NULL, NULL, 'مجدل بعنا', 0),
(1121, 4, 'Mounsa Aaley', NULL, NULL, 'المونسه عاليه', 0),
(1122, 4, 'Mreijat Aley', NULL, NULL, 'مريجات عاليه', 0),
(1123, 4, 'Oumara Choueifat', NULL, NULL, 'الشويفات الامراء', 0),
(1124, 4, 'Qabr Chamoun', NULL, NULL, 'قبر شمون', 0),
(1125, 4, 'Qmatiye', NULL, NULL, 'قماطية', 0),
(1126, 4, 'Qoubbe Choueifat', NULL, NULL, 'قبة الشويفات', 0),
(1127, 4, 'Ram Bchamoun', NULL, NULL, 'رام بشامون', 0),
(1128, 4, 'Ramliye', NULL, NULL, 'رملية', 0),
(1129, 4, 'Rechmaiya', NULL, NULL, 'رشميا', 0),
(1130, 4, 'Rejme', NULL, NULL, 'رجمة', 0),
(1131, 4, 'Remhala', NULL, NULL, 'رمحالا', 0),
(1132, 4, 'Rjoum', NULL, NULL, 'رجوم', 0),
(1133, 4, 'Rouissat Sofar', NULL, NULL, 'رويسات صوفر', 0),
(1134, 4, 'Rouisset en Naamane', NULL, NULL, 'رويسة النعمان', 0),
(1135, 4, 'Sarahmoul', NULL, NULL, 'سرحمول', 0),
(1136, 4, 'Sibaal', NULL, NULL, 'سبعل', 0),
(1137, 4, 'Sil', NULL, NULL, 'سيل', 0),
(1138, 4, 'Silfaya', NULL, NULL, 'سلفايا', 0),
(1139, 4, 'Sofar', NULL, NULL, 'صوفر', 0),
(1140, 4, 'Souq el Gharb', NULL, NULL, 'سوق الغرب', 0),
(1141, 4, 'Taazniye', NULL, NULL, 'تعزانية', 0),
(1142, 4, 'Touayte Ain Dara', NULL, NULL, 'تويته عين داره', 0),
(1143, 4, 'Watiye', NULL, NULL, 'واطية', 0),
(1144, 4, 'Yinnar', NULL, NULL, 'ينار', 0),
(1145, 5, 'Aabadiye', NULL, NULL, 'عبادية', 0),
(1146, 5, 'Aarbaniye', NULL, NULL, 'عربانية', 0),
(1147, 5, 'Abbdiyeh al Jadideh', NULL, NULL, 'عبادية الجديدة', 0),
(1148, 5, 'Ain er Roummane', NULL, NULL, 'عين الرمانة بعبدا', 0),
(1149, 5, 'Ain es Sihha', NULL, NULL, 'عين الصحة', 0),
(1150, 5, 'Ain Mouaffaq', NULL, NULL, 'عين موفق', 0),
(1151, 5, 'Arayia', NULL, NULL, 'عاريا', 0),
(1152, 5, 'Arsoun', NULL, NULL, 'ارصون', 0),
(1153, 5, 'Baabda', NULL, NULL, 'بعبدا', 0),
(1154, 5, 'Baajour', NULL, NULL, 'بعجور', 0),
(1155, 5, 'Baalchmay', NULL, NULL, 'بعلشميه', 0),
(1156, 5, 'Baalchmay ej Jdide', NULL, NULL, 'بعلشميه الجديدة', 0),
(1157, 5, 'Bhala', NULL, NULL, 'بحالا', 0),
(1158, 5, 'Bir el AAbed', NULL, NULL, 'بئر العبد', 0),
(1159, 5, 'Bir Hassan', NULL, NULL, 'بئر حسن', 0),
(1160, 5, 'Bmariam', NULL, NULL, 'بمريم', 0),
(1161, 5, 'Borj el Brajne', NULL, NULL, 'برج البراجنة', 0),
(1162, 5, 'Boutchai', NULL, NULL, 'بطشيه', 0),
(1163, 5, 'Brazilia', NULL, NULL, 'برازيليا', 0),
(1164, 5, 'Bsaba &amp; Ouadi Dlab', NULL, NULL, 'بسابا وادي الدلب', 0),
(1165, 5, 'Btaaline', NULL, NULL, 'بتعلين', 0),
(1166, 5, 'Btebyat', NULL, NULL, 'بتبيات', 0),
(1167, 5, 'Btekhnay', NULL, NULL, 'بتخناي', 0),
(1168, 5, 'Bzebdine', NULL, NULL, 'بزبدين', 0),
(1169, 5, 'Chatila', NULL, NULL, 'شاتيلا', 0),
(1170, 5, 'Chbaniye', NULL, NULL, 'شبانية', 0),
(1171, 5, 'Chiayah', NULL, NULL, 'شياح', 0),
(1172, 5, 'Chmaissa', NULL, NULL, 'شميسة', 0),
(1173, 5, 'Chouit', NULL, NULL, 'شويت', 0),
(1174, 5, 'Cite Sportive', NULL, NULL, 'المدينة الرياضية', 0),
(1175, 5, 'Dahr el Baidar', NULL, NULL, 'ضهر البيدر', 0),
(1176, 5, 'Deir el Harf', NULL, NULL, 'دير الحرف', 0),
(1177, 5, 'Deir Khouna', NULL, NULL, 'دير خونة', 0),
(1178, 5, 'Deir Mar Elias', NULL, NULL, 'دير مار الياس', 0),
(1179, 5, 'Deir Mar Youhanna', NULL, NULL, 'دير مار يوحنا', 0),
(1180, 5, 'Deir Saiya', NULL, NULL, 'دير سيا', 0),
(1181, 5, 'Dhour Al Aabaydiyeh', NULL, NULL, 'ضهور العبادية', 0),
(1182, 5, 'Dlaibe', NULL, NULL, 'دليبه', 0),
(1183, 5, 'El Baqle', NULL, NULL, 'بقلة', 0),
(1184, 5, 'El Maadan', NULL, NULL, 'المعادن', 0),
(1185, 5, 'El Marmah', NULL, NULL, 'مرمح', 0),
(1186, 5, 'El Mdaoura', NULL, NULL, 'مدورا', 0),
(1187, 5, 'El Ouzaai', NULL, NULL, 'اوزاعي', 0),
(1188, 5, 'Er Rihaniye', NULL, NULL, 'ريحانية', 0),
(1189, 5, 'Er Rouais', NULL, NULL, 'الرويس', 0),
(1190, 5, 'Es Sheime', NULL, NULL, 'الشيمة', 0),
(1191, 5, 'Et Tahouita', NULL, NULL, 'التحويطة', 0),
(1192, 5, 'Ez Zire', NULL, NULL, 'زيره', 0),
(1193, 5, 'Faiyadiye', NULL, NULL, 'فياضية', 0),
(1194, 5, 'Falougha', NULL, NULL, 'فالوغا', 0),
(1195, 5, 'Fsakin', NULL, NULL, 'فساقين ترشيش', 0),
(1196, 5, 'Furn ech Chebak', NULL, NULL, 'فرن الشباك', 0),
(1197, 5, 'Ghobeire', NULL, NULL, 'غبيري', 0),
(1198, 5, 'Hadet', NULL, NULL, 'حدث', 0),
(1199, 5, 'Hammana', NULL, NULL, 'حمانا', 0),
(1200, 5, 'Haql Hassan', NULL, NULL, 'حقل حسن', 0),
(1201, 5, 'Haret El Botm', NULL, NULL, 'حارة البطم', 0),
(1202, 5, 'Haret el Mjadle', NULL, NULL, 'حارة المجادلة', 0),
(1203, 5, 'Haret er Roum', NULL, NULL, 'حارة الروم', 0),
(1204, 5, 'Haret es Set', NULL, NULL, 'حارة الست', 0),
(1205, 5, 'Haret Hamze', NULL, NULL, 'حارة حمزة', 0),
(1206, 5, 'Haret Hraik', NULL, NULL, 'حارة حريك', 0),
(1207, 5, 'Hasbaiya el Metn', NULL, NULL, 'حاصبيّا المتن', 0),
(1208, 5, 'Hazmiye', NULL, NULL, 'حازمية', 0),
(1209, 5, 'Hlaliye', NULL, NULL, 'هلالية', 0),
(1210, 5, 'Jamhour', NULL, NULL, 'جمهور', 0),
(1211, 5, 'Jnah', NULL, NULL, 'جناح', 0),
(1212, 5, 'Jouar el Haouz', NULL, NULL, 'جوار الحوز', 0),
(1213, 5, 'Jouret Arsoun', NULL, NULL, 'جورة ارصون', 0),
(1214, 5, 'Kahlouniye', NULL, NULL, 'كحلونية', 0),
(1215, 5, 'Kfar Selouane', NULL, NULL, 'كفرسلوان', 0),
(1216, 5, 'Kfarchima', NULL, NULL, 'كفرشيما', 0),
(1217, 5, 'Khalouat', NULL, NULL, 'خلوات', 0),
(1218, 5, 'Khraibe Baabda', NULL, NULL, 'خريبة بعبدا', 0),
(1219, 5, 'Knisse', NULL, NULL, 'كنيسة بعبدا', 0),
(1220, 5, 'Lailake', NULL, NULL, 'ليلكي', 0),
(1221, 5, 'Louaize', NULL, NULL, 'لويزة', 0),
(1222, 5, 'Mar Taqla', NULL, NULL, 'مار تقلا', 0),
(1223, 5, 'Mazzraat Maaissra', NULL, NULL, 'مزرعة المعيصرة', 0),
(1224, 5, 'Mdeyrej', NULL, NULL, 'مديرج', 0),
(1225, 5, 'Merdache', NULL, NULL, 'مرداشة', 0),
(1226, 5, 'Mraije', NULL, NULL, 'مريجة', 0),
(1227, 5, 'Mzayraa', NULL, NULL, 'مزيرعة بعبدا', 0),
(1228, 5, 'Ouadi Chahrour el Olia', NULL, NULL, 'وادي شحرور العليا', 0),
(1229, 5, 'Ouadi Chahrour el Soufla', NULL, NULL, 'وادي شحرور السفلى', 0),
(1230, 5, 'Qalaa', NULL, NULL, 'القلعة', 0),
(1231, 5, 'Qirtada', NULL, NULL, 'قرطادة', 0),
(1232, 5, 'Qornayel', NULL, NULL, 'قرنايل', 0),
(1233, 5, 'Qoubbeiaa', NULL, NULL, 'قبيع', 0),
(1234, 5, 'Qraiye', NULL, NULL, 'قرية', 0),
(1235, 5, 'Qsaibe', NULL, NULL, 'قصيبة', 0),
(1236, 5, 'Qtale', NULL, NULL, 'قتالة', 0),
(1237, 5, 'Ras el Harf', NULL, NULL, 'راس الحرف', 0),
(1238, 5, 'Ras el Metn', NULL, NULL, 'راس المتن', 0),
(1239, 5, 'Rouaisset Salima', NULL, NULL, 'رويسات صليما', 0),
(1240, 5, 'Rouisset el Ballout', NULL, NULL, 'رويسة البلوط', 0),
(1241, 5, 'Sabra', NULL, NULL, 'صبرا', 0),
(1242, 5, 'Salima Baabda', NULL, NULL, 'صليما بعبدا', 0),
(1243, 5, 'Saqi Ain el Hadath', NULL, NULL, 'سقي عين الحدث', 0),
(1244, 5, 'Sibnay', NULL, NULL, 'سبنيه', 0),
(1245, 5, 'Tahouitet el Ghadir', NULL, NULL, 'تحويطة الغدير', 0),
(1246, 5, 'Tarchich', NULL, NULL, 'ترشيش', 0),
(1247, 5, 'Warware', NULL, NULL, 'الوروار', 0),
(1248, 5, 'Yarzeh', NULL, NULL, 'اليرزة', 0),
(1249, 5, 'Zandouqa', NULL, NULL, 'زندوقة', 0),
(1250, 5, 'Zouaitini', NULL, NULL, 'زويتينة', 0),
(1251, 10, 'Aalmane Ech Chouf', NULL, NULL, 'علمان الشوف', 0),
(1252, 10, 'Aammatour', NULL, NULL, 'عمّاطور', 0),
(1253, 10, 'Aammiq chouf', NULL, NULL, 'عميق الشوف', 0),
(1254, 10, 'Aanout', NULL, NULL, 'عانوت', 0),
(1255, 10, 'Aaqline', NULL, NULL, 'عقلين', 0),
(1256, 10, 'Aatrine', NULL, NULL, 'عترين', 0),
(1257, 10, 'Aazibett tahta', NULL, NULL, 'عزبيات التحتا', 0),
(1258, 10, 'Ain Aazime', NULL, NULL, 'عين عزيمة', 0),
(1259, 10, 'Ain Bal', NULL, NULL, 'عينبال', 0),
(1260, 10, 'Ain El Assad', NULL, NULL, 'عين الاسد', 0),
(1261, 10, 'Ain el Haour', NULL, NULL, 'عين الحور', 0),
(1262, 10, 'Ain Ouzain', NULL, NULL, 'عين وزين', 0),
(1263, 10, 'Ain Qeni', NULL, NULL, 'عين قني', 0),
(1264, 10, 'Ain Zhalta', NULL, NULL, 'عين زحلتا', 0),
(1265, 10, 'Almane ed Daiaa', NULL, NULL, 'علمان الضيعة', 0),
(1266, 10, 'Baadarane', NULL, NULL, 'بعدران', 0),
(1267, 10, 'Baal en Naame', NULL, NULL, 'بعل الناعمه', 0),
(1268, 10, 'Baaqline', NULL, NULL, 'بعقلين', 0),
(1269, 10, 'Baasir', NULL, NULL, 'بعاصير', 0),
(1270, 10, 'Bachqiye', NULL, NULL, 'باشقية', 0),
(1271, 10, 'Baiqoun', NULL, NULL, 'بيقون', 0),
(1272, 10, 'Baqaoun', NULL, NULL, 'بقعون', 0),
(1273, 10, 'Baqse', NULL, NULL, 'بقسه', 0),
(1274, 10, 'Barja', NULL, NULL, 'برجا', 0),
(1275, 10, 'Barouk', NULL, NULL, 'الباروك', 0),
(1276, 10, 'Bater', NULL, NULL, 'باتر', 0),
(1277, 10, 'Batloun', NULL, NULL, 'بتلون', 0),
(1278, 10, 'Bchatfine', NULL, NULL, 'بشتفين', 0),
(1279, 10, 'Bchella Ech Chouf', NULL, NULL, 'بشله الشوف', 0),
(1280, 10, 'Beit ed Dine', NULL, NULL, 'بيت الدين', 0),
(1281, 10, 'Benoeti', NULL, NULL, 'بنواتي', 0),
(1282, 10, 'Bire', NULL, NULL, 'بيرة', 0),
(1283, 10, 'Bkechtine', NULL, NULL, 'بكشتين', 0),
(1284, 10, 'Bkifa', NULL, NULL, 'بكيفا', 0),
(1285, 10, 'Boqaata', NULL, NULL, 'بقعاتا', 0),
(1286, 10, 'Borjein', NULL, NULL, 'البرجين', 0),
(1287, 10, 'Boudine', NULL, NULL, 'بودين', 0),
(1288, 10, 'Boutme', NULL, NULL, 'بطمة', 0),
(1289, 10, 'Bqaiaa', NULL, NULL, 'بقيعة', 0),
(1290, 10, 'Brih', NULL, NULL, 'بريح', 0),
(1291, 10, 'Bsaba', NULL, NULL, 'بسابا', 0),
(1292, 10, 'Bsennay', NULL, NULL, 'بصّني', 0),
(1293, 10, 'Bzina', NULL, NULL, 'بزينا', 0),
(1294, 10, 'Chhim', NULL, NULL, 'شحيم', 0),
(1295, 10, 'Chmaarine', NULL, NULL, 'شمعرين', 0),
(1296, 10, 'Chmis chouf', NULL, NULL, 'شميس', 0),
(1297, 10, 'Choualiq Deir El Qamar', NULL, NULL, 'شواليق دير القمر', 0),
(1298, 10, 'Chourit', NULL, NULL, 'شوريت', 0),
(1299, 10, 'Dabche', NULL, NULL, 'دبشه', 0),
(1300, 10, 'Dahr ech Chqif', NULL, NULL, 'ضهر الشقيف', 0),
(1301, 10, 'Dahr el Aaqline', NULL, NULL, 'ضهر عقلين', 0),
(1302, 10, 'Dahr el Mghara', NULL, NULL, 'ضهر المغارة', 0),
(1303, 10, 'Dalhoun', NULL, NULL, 'دلهون', 0),
(1304, 10, 'Damour', NULL, NULL, 'الدامور', 0),
(1305, 10, 'Daraiya', NULL, NULL, 'داريا الشوف', 0),
(1306, 10, 'Dawha', NULL, NULL, 'الدوحة', 0),
(1307, 10, 'Deir Baba', NULL, NULL, 'دير بابا', 0),
(1308, 10, 'Deir Dourite', NULL, NULL, 'دير دوريت', 0),
(1309, 10, 'Deir El MKhales', NULL, NULL, 'دير المخلص الشوف', 0),
(1310, 10, 'Deir el Qamar', NULL, NULL, 'دير القمر', 0),
(1311, 10, 'Deir er Rahbat', NULL, NULL, 'دير الراهبات', 0),
(1312, 10, 'Deir es Saide', NULL, NULL, 'دير السيدة', 0),
(1313, 10, 'Deir Qouche', NULL, NULL, 'دير كوشه', 0),
(1314, 10, 'Delghani', NULL, NULL, 'دلغاني', 0),
(1315, 10, 'Dhour Ain Al Haour', NULL, NULL, 'ضهور عين الحور', 0),
(1316, 10, 'Dibbiye', NULL, NULL, 'دبية', 0),
(1317, 10, 'Dmit', NULL, NULL, 'دميت', 0),
(1318, 10, 'Douair Ed Dibbiye', NULL, NULL, 'دوير الدبية', 0),
(1319, 10, 'Douair El Hara', NULL, NULL, 'دوير الحارة', 0),
(1320, 10, 'Ech Charbine', NULL, NULL, 'شربين', 0),
(1321, 10, 'Ed Dalhamiye', NULL, NULL, 'دلهميه الدبيه', 0),
(1322, 10, 'Ej Jreid', NULL, NULL, 'جريد', 0),
(1323, 10, 'El Aaqbe joun', NULL, NULL, 'عقبة جون', 0),
(1324, 10, 'El Battal', NULL, NULL, 'بطال', 0),
(1325, 10, 'El Kherbe', NULL, NULL, 'الخربة الشوف', 0),
(1326, 10, 'El Khraibe', NULL, NULL, 'خريبة بيرة الشوف', 0),
(1327, 10, 'El Meghraiqa', NULL, NULL, 'مغريقا', 0),
(1328, 10, 'El Msayed', NULL, NULL, 'المصايد', 0),
(1329, 10, 'El Qateaa', NULL, NULL, 'قتيعا', 0),
(1330, 10, 'Eskandarouna', NULL, NULL, 'إسكندرونة', 0),
(1331, 10, 'Et Taamir', NULL, NULL, 'تعمير', 0),
(1332, 10, 'Faouarat Jaafar', NULL, NULL, 'فوارة جعفر', 0),
(1333, 10, 'Fraidiss', NULL, NULL, 'فريديس الشوف', 0),
(1334, 10, 'Ghabet Jaafar', NULL, NULL, 'غابة جعفر', 0),
(1335, 10, 'Ghandouriye', NULL, NULL, 'غندورية', 0),
(1336, 10, 'Gharife', NULL, NULL, 'غريفة', 0),
(1337, 10, 'Haffet el Hajal', NULL, NULL, 'حافة الحجل', 0),
(1338, 10, 'Halioune el Faouqa', NULL, NULL, 'حليونة الفوقا', 0),
(1339, 10, 'Halioune et Tahta', NULL, NULL, 'حليونة التحتا', 0),
(1340, 10, 'Hamra Ed Damour', NULL, NULL, 'حمرا الدامور', 0),
(1341, 10, 'Hardouch', NULL, NULL, 'حردوش', 0),
(1342, 10, 'Haret Aalmane', NULL, NULL, 'حارة علمان', 0),
(1343, 10, 'Haret Baasir', NULL, NULL, 'حارة بعاصير', 0),
(1344, 10, 'Haret Beit Madi', NULL, NULL, 'حارة بيت ماضي', 0),
(1345, 10, 'Haret el Ouasta', NULL, NULL, 'حارة الواسطة', 0),
(1346, 10, 'Haret en Naame', NULL, NULL, 'حارة الناعمه', 0),
(1347, 10, 'Haret Jandal', NULL, NULL, 'حارة جندل', 0),
(1348, 10, 'Hasrout', NULL, NULL, 'حصروت', 0),
(1349, 10, 'Hjaijiye', NULL, NULL, 'حجاجية', 0),
(1350, 10, 'Jadra', NULL, NULL, 'جدرا', 0),
(1351, 10, 'Jahliye', NULL, NULL, 'جاهلية', 0),
(1352, 10, 'Jall Bou Haidar', NULL, NULL, 'جل بو حيدر', 0),
(1353, 10, 'Jamailiye', NULL, NULL, 'جميلية', 0),
(1354, 10, 'Jbaa', NULL, NULL, 'جباع', 0),
(1355, 10, 'Jdaide chouf', NULL, NULL, 'جديدة الشوف', 0),
(1356, 10, 'Je\'ayel', NULL, NULL, 'جعايل', 0),
(1357, 10, 'Jiblaye', NULL, NULL, 'جبلايا', 0),
(1358, 10, 'Jiye', NULL, NULL, 'جية', 0),
(1359, 10, 'Jlailiye', NULL, NULL, 'جليلية', 0),
(1360, 10, 'Joun', NULL, NULL, 'جون', 0),
(1361, 10, 'Kahlouniye chouf', NULL, NULL, 'كحلونية الشوف', 0),
(1362, 10, 'Ketermaya', NULL, NULL, 'كترمايا', 0),
(1363, 10, 'Kfar Faqoud', NULL, NULL, 'كفرفاقود', 0),
(1364, 10, 'Kfar Hai', NULL, NULL, 'كفر حي', 0),
(1365, 10, 'Kfar Hamal', NULL, NULL, 'كفر حمل', 0),
(1366, 10, 'Kfar Him', NULL, NULL, 'كفرحيم', 0),
(1367, 10, 'Kfar Nabrakh', NULL, NULL, 'كفرنبرخ', 0),
(1368, 10, 'Kfar Niss', NULL, NULL, 'كفرنيس', 0),
(1369, 10, 'Kfar Qatra', NULL, NULL, 'كفرقطرة', 0),
(1370, 10, 'Khalouat Jernaya', NULL, NULL, 'خلوات جرنايا', 0),
(1371, 10, 'Khiam Ed Damour', NULL, NULL, 'خيام الدامور', 0),
(1372, 10, 'Khirbet Dabach', NULL, NULL, 'خربة دبش', 0),
(1373, 10, 'Khirbit Bisri', NULL, NULL, 'خربة بسري', 0),
(1374, 10, 'Khraibe chouf', NULL, NULL, 'خريبة الشوف', 0),
(1375, 10, 'Knisse chouf', NULL, NULL, 'كنيسة الشوف', 0),
(1376, 10, 'Lahbiye', NULL, NULL, 'لهبية', 0),
(1377, 10, 'Maaniye', NULL, NULL, 'معنيه', 0),
(1378, 10, 'Maaser Beit ed Dine', NULL, NULL, 'معاصر بيت الدين', 0),
(1379, 10, 'Maasser ech Chouf', NULL, NULL, 'معاصر الشوف', 0),
(1380, 10, 'Majdalouna', NULL, NULL, 'مجدلونا', 0),
(1381, 10, 'Majdel el Meouch', NULL, NULL, 'مجدل المعوش', 0),
(1382, 10, 'Maqsabe', NULL, NULL, 'مقصبة', 0),
(1383, 10, 'Mar Mikheyel Ed Damour', NULL, NULL, 'مار مخايل الدامور', 0),
(1384, 10, 'Mar Taqla En Naame', NULL, NULL, 'مار تقلا الناعمه', 0),
(1385, 10, 'Marj Aali', NULL, NULL, 'مرج علي', 0),
(1386, 10, 'Marj Barja', NULL, NULL, 'مرج برجا', 0),
(1387, 10, 'Marj Ketermaya', NULL, NULL, 'مرج كترمايا', 0),
(1388, 10, 'Marjiat', NULL, NULL, 'مرجيات', 0),
(1389, 10, 'Marjiat Borjein', NULL, NULL, 'برجين', 0),
(1390, 10, 'Mazboud', NULL, NULL, 'مزبود', 0),
(1391, 10, 'Mazmoura', NULL, NULL, 'مزمورة', 0),
(1392, 10, 'Mazraat ech Chouf', NULL, NULL, 'مزرعة', 0),
(1393, 10, 'Mazraat ed Dahr', NULL, NULL, 'مزرعة الضهر', 0),
(1394, 10, 'Mazraat ed Doueir', NULL, NULL, 'مزرعة الدوير', 0),
(1395, 10, 'Mazraat El Barghoutiye', NULL, NULL, 'مزرعة البرغوتية', 0),
(1396, 10, 'Mazraat er Rzaniye', NULL, NULL, 'مزرعة الرزَانية', 0),
(1397, 10, 'Mazraat ez Zaitounniyeh', NULL, NULL, 'مزرعة الزيتونه', 0),
(1398, 10, 'Mazraat Khafiche', NULL, NULL, 'مزرعة الخفيش', 0),
(1399, 10, 'Mechref', NULL, NULL, 'مشرف', 0),
(1400, 10, 'Mermata', NULL, NULL, 'مرماتا', 0),
(1401, 10, 'Mghaire', NULL, NULL, 'مغيره', 0),
(1402, 10, 'Mghairiye Chouf', NULL, NULL, 'مغيرية الشوف', 0),
(1403, 10, 'Mouhtaqara', NULL, NULL, 'محتقره', 0),
(1404, 10, 'Moukhtara', NULL, NULL, 'مختارة', 0),
(1405, 10, 'Mristi', NULL, NULL, 'مرستى', 0),
(1406, 10, 'Mtaile', NULL, NULL, 'مطيلة', 0),
(1407, 10, 'Mtairiyat', NULL, NULL, 'مطيرية', 0),
(1408, 10, 'Mtoulle', NULL, NULL, 'مطله', 0),
(1409, 10, 'Naame', NULL, NULL, 'ناعمه', 0),
(1410, 10, 'Nabaa es Safa', NULL, NULL, 'نبع الصفا', 0),
(1411, 10, 'Nabi Younos', NULL, NULL, 'نبي يونس', 0),
(1412, 10, 'Niha', NULL, NULL, 'نيحا', 0),
(1413, 10, 'Ouadi Abou Youssef', NULL, NULL, 'وادي ابو يوسف', 0),
(1414, 10, 'Ouadi Bnahle', NULL, NULL, 'وادي بنحليه', 0),
(1415, 10, 'Ouadi Deir Dourit', NULL, NULL, 'وادي دير دوريت', 0),
(1416, 10, 'Ouadi ed Deir', NULL, NULL, 'وادي الدير', 0),
(1417, 10, 'Ouadi es Sitt', NULL, NULL, 'وادي الست', 0),
(1418, 10, 'Ouadi Ez Zeyni', NULL, NULL, 'وادي الزينة', 0),
(1419, 10, 'Ouarhaniye', NULL, NULL, 'ورهانية', 0),
(1420, 10, 'Qalaat el Hosn', NULL, NULL, 'قلعة الحصن', 0),
(1421, 10, 'Qalaat En Nimiri', NULL, NULL, 'قلعة النمري', 0),
(1422, 10, 'Qassoube', NULL, NULL, 'قصوبة', 0),
(1423, 10, 'Qraiaa', NULL, NULL, 'قريعة', 0),
(1424, 10, 'Quardaniye', NULL, NULL, 'وردانيه', 0),
(1425, 10, 'Ras Aalous', NULL, NULL, 'راس علوس', 0),
(1426, 10, 'Rmaile', NULL, NULL, 'رميلة', 0),
(1427, 10, 'Saadiyat', NULL, NULL, 'السعديات', 0),
(1428, 10, 'Sabouniye', NULL, NULL, 'صابونية', 0),
(1429, 10, 'Sahl Ej Jiye', NULL, NULL, 'سهل الجية', 0),
(1430, 10, 'Samqaniye', NULL, NULL, 'سمقانية', 0),
(1431, 10, 'Saraouniye', NULL, NULL, 'سرعونية', 0),
(1432, 10, 'Sibline', NULL, NULL, 'سبلين', 0),
(1433, 10, 'Sirjbal', NULL, NULL, 'سرجبال', 0),
(1434, 10, 'Souane Bsaba', NULL, NULL, 'صوانة بسابا', 0),
(1435, 10, 'Traile', NULL, NULL, 'تريله', 0),
(1436, 10, 'Zaarour', NULL, NULL, 'زعرور', 0),
(1437, 10, 'Zaarouriye', NULL, NULL, 'زعرورية', 0),
(1438, 14, 'Aabdine', NULL, NULL, 'عبدين نقاش', 0),
(1439, 14, 'Aafs', NULL, NULL, 'عفص', 0),
(1440, 14, 'Aairoun', NULL, NULL, 'عيرون', 0),
(1441, 14, 'Aammariye', NULL, NULL, 'عمّارية', 0),
(1442, 14, 'Aaqbe Zalqa', NULL, NULL, 'عقبة الزلقا', 0),
(1443, 14, 'Aaraar', NULL, NULL, 'عرعار', 0),
(1444, 14, 'Aatchane', NULL, NULL, 'عطشانة', 0),
(1445, 14, 'Abou Mizane', NULL, NULL, 'أبو ميزان', 0),
(1446, 14, 'Ain Aalaq', NULL, NULL, 'عين علق', 0),
(1447, 14, 'Ain Aar', NULL, NULL, 'عين عار', 0),
(1448, 14, 'Ain El Kharroube', NULL, NULL, 'عين الخروبة', 0),
(1449, 14, 'Ain El Qabou', NULL, NULL, 'عين القبو', 0),
(1450, 14, 'Ain el Qassis', NULL, NULL, 'عين القسيس', 0),
(1451, 14, 'Ain el-Kach', NULL, NULL, 'عين القش', 0),
(1452, 14, 'Ain Er Rihane el meten', NULL, NULL, 'عين الريحان المتن', 0),
(1453, 14, 'Ain Es Safsaf el meten', NULL, NULL, 'عين الصفصاف المتن', 0),
(1454, 14, 'Ain Es Sindiane', NULL, NULL, 'عين السنديانة', 0),
(1455, 14, 'Ain et Toufaha', NULL, NULL, 'عين التفاحة', 0),
(1456, 14, 'Ain Najm', NULL, NULL, 'عين نجم', 0),
(1457, 14, 'Ain Saade', NULL, NULL, 'عين سعادة', 0),
(1458, 14, 'Ain Zaitoune', NULL, NULL, 'عين الزيتونة', 0),
(1459, 14, 'Aintoura el meten', NULL, NULL, 'عينطورة المتن', 0),
(1460, 14, 'Aiyoun', NULL, NULL, 'عيون المتن', 0),
(1461, 14, 'Antelias', NULL, NULL, 'انطلياس', 0),
(1462, 14, 'Baabdat', NULL, NULL, 'بعبدات', 0),
(1463, 14, 'Baaqrif', NULL, NULL, 'بعقريف', 0),
(1464, 14, 'Balouaa', NULL, NULL, 'بالوع', 0),
(1465, 14, 'Baouchriye', NULL, NULL, 'بوشرية', 0),
(1466, 14, 'Baskinta', NULL, NULL, 'بسكنتا', 0),
(1467, 14, 'Bchellama', NULL, NULL, 'بشلامة', 0),
(1468, 14, 'Beit Chebab', NULL, NULL, 'بيت شباب', 0),
(1469, 14, 'Beit El Koukko', NULL, NULL, 'بيت الككو', 0),
(1470, 14, 'Beit Meri', NULL, NULL, 'بيت مري', 0),
(1471, 14, 'Belle Vue', NULL, NULL, 'بلّفو', 0),
(1472, 14, 'Beqaata En Nahr', NULL, NULL, 'بقعاتا النهر', 0),
(1473, 14, 'Bhannes', NULL, NULL, 'بحنس', 0),
(1474, 14, 'Bhersaf', NULL, NULL, 'بحرصاف', 0),
(1475, 14, 'Biaqout', NULL, NULL, 'بياقوت', 0),
(1476, 14, 'Bikfayia', NULL, NULL, 'بكفيا', 0),
(1477, 14, 'Bnabil', NULL, NULL, 'بنابيل', 0),
(1478, 14, 'Bolonia', NULL, NULL, 'بولونيا', 0),
(1479, 14, 'Borj Hammoud', NULL, NULL, 'برج حمّود', 0),
(1480, 14, 'Bqennaya', NULL, NULL, 'بقنايا', 0),
(1481, 14, 'Broumana', NULL, NULL, 'برمانا المتن', 0),
(1482, 14, 'Bsalim', NULL, NULL, 'بصاليم', 0),
(1483, 14, 'Bsatine Ain Saade', NULL, NULL, 'بساتين عين سعادة', 0),
(1484, 14, 'Bsifrine', NULL, NULL, 'بسفرين', 0),
(1485, 14, 'Bteghrine', NULL, NULL, 'بتغرين', 0),
(1486, 14, 'Chaouiye', NULL, NULL, 'شاوية', 0),
(1487, 14, 'Chbouq', NULL, NULL, 'شبوق', 0),
(1488, 14, 'Cherchar', NULL, NULL, 'شرشار', 0),
(1489, 14, 'Cherin', NULL, NULL, 'شرين', 0),
(1490, 14, 'Chmis Antelias', NULL, NULL, 'شميس أنطلياس', 0),
(1491, 14, 'Chouaiya', NULL, NULL, 'شويا', 0),
(1492, 14, 'Choueir', NULL, NULL, 'شوير', 0),
(1493, 14, 'Dahr Broummana', NULL, NULL, 'ضهر برمانا', 0),
(1494, 14, 'Dahr el Bacheq', NULL, NULL, 'ضهر الباشق', 0),
(1495, 14, 'Dahr el Hossein', NULL, NULL, 'ضهر الحسين المتن', 0),
(1496, 14, 'Dahr Es Souane Meten', NULL, NULL, 'ضهر الصوان المتن', 0),
(1497, 14, 'Daoura', NULL, NULL, 'دورة', 0),
(1498, 14, 'Daychouniye', NULL, NULL, 'ديشونية', 0),
(1499, 14, 'Dbaiye', NULL, NULL, 'ضبية', 0),
(1500, 14, 'Deir Chamra', NULL, NULL, 'دير شمرا', 0),
(1501, 14, 'Deir el Qalaa', NULL, NULL, 'دير القلعة', 0),
(1502, 14, 'Deir es Salib', NULL, NULL, 'دير الصليب', 0),
(1503, 14, 'Deir Ma Yohanna El Khenchara', NULL, NULL, 'ديرمار يوحنا الخنشارة', 0),
(1504, 14, 'Deir Mar Chaaya', NULL, NULL, 'دير مار شعيا', 0),
(1505, 14, 'Deir Mar Jergos', NULL, NULL, 'دير مار جرجس', 0),
(1506, 14, 'Deir Mar Simaane', NULL, NULL, 'دير مار سمعان', 0),
(1507, 14, 'Deir Tamich', NULL, NULL, 'دير طاميش', 0),
(1508, 14, 'Deir-er-Raai es Saleh', NULL, NULL, 'دير الراعي الصالح', 0),
(1509, 14, 'Dekouane', NULL, NULL, 'دكوانة', 0),
(1510, 14, 'Delb', NULL, NULL, 'دلب', 0),
(1511, 14, 'Dhour Ech Choueir', NULL, NULL, 'ضهور الشوير', 0),
(1512, 14, 'Dik El Mehdi', NULL, NULL, 'ديك المحدي', 0),
(1513, 14, 'Douar', NULL, NULL, 'دوار', 0),
(1514, 14, 'Ej Jouaniye', NULL, NULL, 'الجوانية', 0),
(1515, 14, 'El Borj El Khenchara', NULL, NULL, 'برج الخنشارة', 0),
(1516, 14, 'El Braij Qornet Chahouane', NULL, NULL, 'بريج قرنة شهوان', 0),
(1517, 14, 'El Firdaous', NULL, NULL, 'فردوس', 0),
(1518, 14, 'El Habach', NULL, NULL, 'حباش', 0),
(1519, 14, 'El Loueize', NULL, NULL, 'لويزة نقاش', 0),
(1520, 14, 'El Machrah', NULL, NULL, 'مشرح', 0),
(1521, 14, 'El Manazil', NULL, NULL, 'منازل', 0),
(1522, 14, 'El Qalaa', NULL, NULL, 'قلعة', 0),
(1523, 14, 'El Qalaa Sin el fil', NULL, NULL, 'قلعة سن الفيل', 0),
(1524, 14, 'En Naas', NULL, NULL, 'نعص', 0),
(1525, 14, 'En Nabaa', NULL, NULL, 'النبعه', 0),
(1526, 14, 'Er Rabie', NULL, NULL, 'رابيه', 0),
(1527, 14, 'Er Raouda', NULL, NULL, 'روضة', 0),
(1528, 14, 'Er Rouaisse', NULL, NULL, 'رويسة برمانا', 0),
(1529, 14, 'Et Tabche', NULL, NULL, 'طبشة', 0),
(1530, 14, 'Fanar', NULL, NULL, 'الفنار', 0),
(1531, 14, 'Fanar ej Jdid', NULL, NULL, 'فنار الجديدة', 0),
(1532, 14, 'Faouar', NULL, NULL, 'فوار', 0),
(1533, 14, 'Faouar el meten', NULL, NULL, 'فوار المتن', 0),
(1534, 14, 'Fraike', NULL, NULL, 'فريكه', 0),
(1535, 14, 'Ghabe', NULL, NULL, 'غابة المسقى', 0),
(1536, 14, 'Ghabet Bolonia', NULL, NULL, 'غابة بولونيا', 0),
(1537, 14, 'Gharouch', NULL, NULL, 'غاروش', 0),
(1538, 14, 'Hamlaya', NULL, NULL, 'حملايا', 0),
(1539, 14, 'Haret el Bellane', NULL, NULL, 'حارة البلان', 0),
(1540, 14, 'Haret el Cheikh', NULL, NULL, 'حارة الشيخ', 0),
(1541, 14, 'Haret El Ghouarni', NULL, NULL, 'حارة الغوارني', 0),
(1542, 14, 'Hbous', NULL, NULL, 'حبوس', 0),
(1543, 14, 'Horch Tabet', NULL, NULL, 'حرش تابت', 0),
(1544, 14, 'Jall Ed Dib', NULL, NULL, 'جل الديب', 0),
(1545, 14, 'Jdaide el Meten', NULL, NULL, 'جديدة المتن', 0),
(1546, 14, 'Jisr El Bacha', NULL, NULL, 'جسر الباشا', 0),
(1547, 14, 'Jouar', NULL, NULL, 'جوار المتن', 0),
(1548, 14, 'Jouret El Ballout', NULL, NULL, 'جورة البلوط', 0),
(1549, 14, 'Kafra El Meten', NULL, NULL, 'كفرا المتن', 0),
(1550, 14, 'Kfar Aaqab', NULL, NULL, 'كفرعقاب', 0),
(1551, 14, 'Kfartay', NULL, NULL, 'كفرتيه', 0),
(1552, 14, 'Khalle', NULL, NULL, 'خلة المتين', 0),
(1553, 14, 'Khenchara', NULL, NULL, 'خنشارة', 0),
(1554, 14, 'Khirbit el Aadass', NULL, NULL, 'خربة العدس', 0),
(1555, 14, 'Ksayfiyeh', NULL, NULL, 'قصيفية', 0),
(1556, 14, 'Machraa', NULL, NULL, 'مشرع', 0),
(1557, 14, 'Majdel Tarchich', NULL, NULL, 'مجدل ترشيش', 0),
(1558, 14, 'Majzoub', NULL, NULL, 'مجذوب', 0),
(1559, 14, 'Makhadet Nahr el Kalb', NULL, NULL, 'مخاضة نهر الكلب', 0),
(1560, 14, 'Mamboukh', NULL, NULL, 'الممبوخ', 0),
(1561, 14, 'Mansouriye', NULL, NULL, 'منصورية', 0),
(1562, 14, 'Mar Aabda el Mshammar', NULL, NULL, 'دير مار عبدا المشمر', 0),
(1563, 14, 'Mar Boutrous Karm El- Tine', NULL, NULL, 'مار بطرس كرم التين', 0),
(1564, 14, 'Mar Mkhayel Bnabil', NULL, NULL, 'مار مخايل بنابيل', 0),
(1565, 14, 'Mar Mousa Ed Daouar', NULL, NULL, 'مار موسى الدوار', 0),
(1566, 14, 'Mar Roukoz', NULL, NULL, 'مار روكز', 0),
(1567, 14, 'Marj Baskinta', NULL, NULL, 'مرج بسكنتا', 0),
(1568, 14, 'Marjaba', NULL, NULL, 'مرجبا', 0),
(1569, 14, 'Masqa', NULL, NULL, 'المسقى', 0),
(1570, 14, 'Mayasse', NULL, NULL, 'مياسة', 0),
(1571, 14, 'Mazraat Beit Ech Chaar', NULL, NULL, 'مزرعة بيت الشعّار', 0),
(1572, 14, 'Mazraat Deir Aaoukar', NULL, NULL, 'مزرعة دير عوكر', 0),
(1573, 14, 'Mazraat El Hdaira', NULL, NULL, 'مزرعة الحضيرة', 0),
(1574, 14, 'Mazraat Yachoua', NULL, NULL, 'مزرعة يشوع', 0),
(1575, 14, 'Mchaymcheh', NULL, NULL, 'مشيمشة', 0),
(1576, 14, 'Mcheikha', NULL, NULL, 'مشيخا', 0),
(1577, 14, 'Mezher', NULL, NULL, 'مزهر', 0),
(1578, 14, 'Mhaydse', NULL, NULL, 'محيدثة المتن', 0),
(1579, 14, 'Mkalless', NULL, NULL, 'مكلس', 0),
(1580, 14, 'Montiverdi', NULL, NULL, 'منتفردي', 0),
(1581, 14, 'Mountazah', NULL, NULL, 'منتزه', 0),
(1582, 14, 'Mrah Ghanem', NULL, NULL, 'مراح غانم', 0),
(1583, 14, 'Mrouj', NULL, NULL, 'المروج', 0),
(1584, 14, 'Mtaileb', NULL, NULL, 'مطيلب', 0),
(1585, 14, 'Mtein', NULL, NULL, 'المتين', 0),
(1586, 14, 'Mzakke', NULL, NULL, 'مزكة', 0),
(1587, 14, 'Nabay', NULL, NULL, 'نابيه', 0),
(1588, 14, 'Naqqach', NULL, NULL, 'نقاش', 0),
(1589, 14, 'Ouadi Chahine', NULL, NULL, 'وادي شاهين', 0),
(1590, 14, 'Ouadi ed Delb', NULL, NULL, 'وادي الدلب', 0),
(1591, 14, 'Ouadi El Amine', NULL, NULL, 'وادي الامين', 0),
(1592, 14, 'Ouadi El Karm', NULL, NULL, 'وادي الكرم المتن', 0),
(1593, 14, 'Ouata El Mrouj', NULL, NULL, 'وطى المروج', 0),
(1594, 14, 'Qaaqour', NULL, NULL, 'القعقور', 0),
(1595, 14, 'Qanat Bakich', NULL, NULL, 'قناة باكيش', 0),
(1596, 14, 'Qennabet Broummana', NULL, NULL, 'قنابة برمانا', 0),
(1597, 14, 'Qennabet Salima', NULL, NULL, 'قنابة صليما', 0),
(1598, 14, 'Qnaitra El Meten', NULL, NULL, 'قنيطرة المتن', 0),
(1599, 14, 'Qornet Chahouane', NULL, NULL, 'قرنة شهوان', 0),
(1600, 14, 'Qornet El Hamra', NULL, NULL, 'قرنة الحمرا', 0),
(1601, 14, 'Qottara Aintouret', NULL, NULL, 'قطارة عينطورة المتن', 0),
(1602, 14, 'Raboue', NULL, NULL, 'ربوة', 0),
(1603, 14, 'Ramie', NULL, NULL, 'رامية', 0),
(1604, 14, 'Raqayeq', NULL, NULL, 'رقايق', 0),
(1605, 14, 'Ras el Jdaide', NULL, NULL, 'راس الجديدة', 0),
(1606, 14, 'Roumie', NULL, NULL, 'روميه المتن', 0),
(1607, 14, 'Sabtiye', NULL, NULL, 'سبتيه', 0),
(1608, 14, 'Sad el Baouchriye', NULL, NULL, 'سد البوشرية', 0),
(1609, 14, 'Sannine', NULL, NULL, 'صنين', 0),
(1610, 14, 'Saqeit El Misk', NULL, NULL, 'ساقية المسك', 0),
(1611, 14, 'Sfaile', NULL, NULL, 'سفيلة', 0),
(1612, 14, 'sfaileh Bikfaya', NULL, NULL, 'سفيلة بكفيا', 0),
(1613, 14, 'Sijn ej Jdid', NULL, NULL, 'سجن الجديد', 0),
(1614, 14, 'Sinn el Fil', NULL, NULL, 'سن الفيل', 0),
(1615, 14, 'Tall ez Zaatar', NULL, NULL, 'تل الزعتر', 0),
(1616, 14, 'Wata Amaret Chalhoub', NULL, NULL, 'الوطى عمارة شلهوب', 0),
(1617, 14, 'Zaaitriye', NULL, NULL, 'زعيتريه', 0),
(1618, 14, 'Zabbougha', NULL, NULL, 'زبوغا', 0),
(1619, 14, 'Zaghrine El Meten', NULL, NULL, 'زغرين المتن', 0),
(1620, 14, 'Zahriye El Meten', NULL, NULL, 'زاهرية المتن', 0),
(1621, 14, 'Zalqa', NULL, NULL, 'الزلقا', 0),
(1622, 14, 'Zaraaoun', NULL, NULL, 'زرعون', 0),
(1623, 14, 'Zikrit', NULL, NULL, 'زكريت', 0),
(1624, 14, 'Zouk el Kharab', NULL, NULL, 'ذوق الخراب', 0),
(1625, 18, 'Aabeidat', NULL, NULL, 'عبيدات', 0),
(1626, 18, 'Aaboud', NULL, NULL, 'عبود', 0),
(1627, 18, 'Aafs jbeil', NULL, NULL, 'عفص', 0),
(1628, 18, 'Aainat', NULL, NULL, 'عينات', 0),
(1629, 18, 'Aalita', NULL, NULL, 'عاليتا', 0),
(1630, 18, 'Aamchit', NULL, NULL, 'عمشيت', 0),
(1631, 18, 'Aannaya', NULL, NULL, 'عنَايا', 0),
(1632, 18, 'Aaouaini', NULL, NULL, 'عويني', 0),
(1633, 18, 'Aaqoura', NULL, NULL, 'عاقورة', 0),
(1634, 18, 'Aarab el Lahib', NULL, NULL, 'عرب اللهيب', 0),
(1635, 18, 'Aarasta', NULL, NULL, 'عرستا', 0),
(1636, 18, 'Aayoun el Aalaq', NULL, NULL, 'عيون العلاق', 0),
(1637, 18, 'Adonis', NULL, NULL, 'ادونيس', 0),
(1638, 18, 'Afqa', NULL, NULL, 'افقا', 0),
(1639, 18, 'Ain Bqechqoch', NULL, NULL, 'عين بقشقش', 0),
(1640, 18, 'Ain ed Deir', NULL, NULL, 'عين الدير', 0),
(1641, 18, 'Ain Ed Delbe Jbeil', NULL, NULL, 'عين الدلبة جبيل', 0),
(1642, 18, 'Ain el Ghouaibe', NULL, NULL, 'عين الغويبة', 0),
(1643, 18, 'Ain el Qadah', NULL, NULL, 'عين القدح', 0),
(1644, 18, 'Ain es Salib', NULL, NULL, 'عين الصليب', 0),
(1645, 18, 'Ain Ghalboun', NULL, NULL, 'عين غلبون', 0),
(1646, 18, 'Ain Jrain', NULL, NULL, 'عين جرين', 0),
(1647, 18, 'Ain Kfaa', NULL, NULL, 'عين كفاع', 0),
(1648, 18, 'Almat ech Chemaliye', NULL, NULL, 'علمات الشمالية', 0),
(1649, 18, 'Almat Ej Jnoubiye', NULL, NULL, 'علمات الجنوبية', 0),
(1650, 18, 'Aydamoun', NULL, NULL, 'عيدامون', 0),
(1651, 18, 'Baachta', NULL, NULL, 'بعشتا', 0),
(1652, 18, 'Balhoss', NULL, NULL, 'بلحص', 0),
(1653, 18, 'Barbara', NULL, NULL, 'بربارة', 0),
(1654, 18, 'Barij', NULL, NULL, 'بريج', 0),
(1655, 18, 'Bchelli', NULL, NULL, 'بشلّلي', 0),
(1656, 18, 'Bechtelida', NULL, NULL, 'بشتليدا', 0),
(1657, 18, 'Behdaidat', NULL, NULL, 'بحديدات', 0),
(1658, 18, 'Beit El Boume', NULL, NULL, 'بيت البومة', 0),
(1659, 18, 'Beit Hbaq', NULL, NULL, 'بيت حبّاق', 0),
(1660, 18, 'Bejje', NULL, NULL, 'بجه', 0),
(1661, 18, 'Bekhaaz', NULL, NULL, 'بخعاز', 0),
(1662, 18, 'Bekouane', NULL, NULL, 'بكونا', 0),
(1663, 18, 'Bentaael', NULL, NULL, 'بنتاعل', 0),
(1664, 18, 'Berket Hejoula', NULL, NULL, 'بركة حجولا', 0),
(1665, 18, 'Beziyoun', NULL, NULL, 'بزيون', 0),
(1666, 18, 'Bhassis', NULL, NULL, 'بحسيس', 0),
(1667, 18, 'Bir El Hait', NULL, NULL, 'بير الهيت', 0),
(1668, 18, 'Bkourkaz', NULL, NULL, 'بكركز', 0),
(1669, 18, 'Blat', NULL, NULL, 'بلاط', 0),
(1670, 18, 'Bmehrine', NULL, NULL, 'بمهرين', 0),
(1671, 18, 'Boaatara', NULL, NULL, 'بعتارا', 0),
(1672, 18, 'Bqarta', NULL, NULL, 'بقرتا', 0),
(1673, 18, 'Broqta', NULL, NULL, 'برقتا', 0),
(1674, 18, 'Chaabiyat el Fawqa', NULL, NULL, 'شعبيات الفوقا', 0),
(1675, 18, 'Chaloumas', NULL, NULL, 'شلوماس', 0),
(1676, 18, 'Chamat', NULL, NULL, 'شامات', 0),
(1677, 18, 'Charbine Mazraat Es Siyad', NULL, NULL, 'شربين مزرعة السياد', 0),
(1678, 18, 'Chekhnaya', NULL, NULL, 'شخنايا', 0),
(1679, 18, 'Chikhane', NULL, NULL, 'شيخان', 0),
(1680, 18, 'Chmout', NULL, NULL, 'شموت', 0),
(1681, 18, 'Chouata', NULL, NULL, 'شواتا', 0),
(1682, 18, 'Daouret Edde Jbayl', NULL, NULL, 'دورة إده جبيل', 0),
(1683, 18, 'Deir el Qattara', NULL, NULL, 'دير القطارة', 0),
(1684, 18, 'Deir Mar Maroun', NULL, NULL, 'دير مار مارون', 0),
(1685, 18, 'Deir Mar Sarkis', NULL, NULL, 'دير مار سركيس', 0),
(1686, 18, 'Dmalsa', NULL, NULL, 'دملصا', 0),
(1687, 18, 'Douar Bou chahine', NULL, NULL, 'دوار بو شاهين', 0),
(1688, 18, 'Doueir', NULL, NULL, 'الدوير', 0),
(1689, 18, 'Ed Darje', NULL, NULL, 'درجه', 0),
(1690, 18, 'Edde', NULL, NULL, 'إده', 0),
(1691, 18, 'Ehmej', NULL, NULL, 'اهمج', 0),
(1692, 18, 'El Aambra', NULL, NULL, 'العمبرا', 0),
(1693, 18, 'El Aarich', NULL, NULL, 'عريش', 0),
(1694, 18, 'El Barraniye', NULL, NULL, 'برانية', 0),
(1695, 18, 'El Bhayri', NULL, NULL, 'بحيري', 0),
(1696, 18, 'El Biyade', NULL, NULL, 'البياضة جبيل', 0),
(1697, 18, 'El Borj', NULL, NULL, 'برج', 0),
(1698, 18, 'El Boustane', NULL, NULL, 'بستان يانوح', 0),
(1699, 18, 'El Houssoun', NULL, NULL, 'حصون', 0),
(1700, 18, 'El Hraifat', NULL, NULL, 'الحريفات', 0),
(1701, 18, 'El Marj Lassa', NULL, NULL, 'مرج لاسا', 0),
(1702, 18, 'El Mtolle', NULL, NULL, 'مطله جبيل', 0),
(1703, 18, 'El Owaynate', NULL, NULL, 'عوينات', 0),
(1704, 18, 'El-Harf', NULL, NULL, 'حرف قرطبون', 0),
(1705, 18, 'Ernaya', NULL, NULL, 'ارنايا', 0),
(1706, 18, 'Es Saqi', NULL, NULL, 'سقي', 0),
(1707, 18, 'Es Sare', NULL, NULL, 'سار', 0),
(1708, 18, 'Fatre', NULL, NULL, 'فتري', 0),
(1709, 18, 'Ferhet', NULL, NULL, 'فرحت', 0),
(1710, 18, 'Fghal', NULL, NULL, 'فغال', 0),
(1711, 18, 'Fidar', NULL, NULL, 'الفيدار', 0),
(1712, 18, 'Fidar el Faouqa', NULL, NULL, 'فدار الفوقا', 0),
(1713, 18, 'Fidar Et Tahta', NULL, NULL, 'فدار التحتا', 0),
(1714, 18, 'Frat', NULL, NULL, 'فرات', 0),
(1715, 18, 'Ghabate', NULL, NULL, 'غابات', 0),
(1716, 18, 'Ghabline', NULL, NULL, 'غبالين', 0),
(1717, 18, 'Ghalboun', NULL, NULL, 'غلبون', 0),
(1718, 18, 'Gharfine', NULL, NULL, 'غرفين', 0),
(1719, 18, 'Gharzouz', NULL, NULL, 'غرزوز', 0),
(1720, 18, 'Habboub', NULL, NULL, 'حبوب', 0),
(1721, 18, 'Habil', NULL, NULL, 'هابيل', 0),
(1722, 18, 'Halat', NULL, NULL, 'حالات', 0),
(1723, 18, 'Haqel', NULL, NULL, 'حقل', 0),
(1724, 18, 'Haqlet et Tine', NULL, NULL, 'حقلة التينة', 0),
(1725, 18, 'Hara Jbeil', NULL, NULL, 'حارة', 0),
(1726, 18, 'Harsha', NULL, NULL, 'هرشا', 0),
(1727, 18, 'Hay El Aarbe', NULL, NULL, 'حي العربي', 0),
(1728, 18, 'Hay El Baalbakiye', NULL, NULL, 'حي البعلبكية', 0),
(1729, 18, 'Hbalin', NULL, NULL, 'حبالين', 0),
(1730, 18, 'Hedayne', NULL, NULL, 'هدينة', 0),
(1731, 18, 'Heloue', NULL, NULL, 'حلوة', 0),
(1732, 18, 'Hima Er Rehbane', NULL, NULL, 'حمى الرهبان', 0),
(1733, 18, 'Hima Mar Maroun Aannaya', NULL, NULL, 'حمى مار مارون عنَايا', 0),
(1734, 18, 'Hjoula', NULL, NULL, 'حجولا', 0),
(1735, 18, 'Hosn Aar', NULL, NULL, 'حصن العر', 0),
(1736, 18, 'Hosna', NULL, NULL, 'حصنا', 0),
(1737, 18, 'Hosrayel', NULL, NULL, 'حصرايل', 0),
(1738, 18, 'Hourata', NULL, NULL, 'حوراتا', 0),
(1739, 18, 'Hrazmin', NULL, NULL, 'حرازمين', 0),
(1740, 18, 'Hsarat', NULL, NULL, 'حصارات', 0),
(1741, 18, 'Jaj', NULL, NULL, 'جاج', 0),
(1742, 18, 'Janne', NULL, NULL, 'جنة', 0),
(1743, 18, 'Jbail', NULL, NULL, 'جبيل', 0),
(1744, 18, 'Jdayel', NULL, NULL, 'جدايل', 0),
(1745, 18, 'Jengel', NULL, NULL, 'جونجل', 0),
(1746, 18, 'Jlaisse', NULL, NULL, 'جليسه', 0),
(1747, 18, 'Jouret El Qattine', NULL, NULL, 'جورة القطين', 0),
(1748, 18, 'Jrebta Jbeil', NULL, NULL, 'جربتا جبيل', 0),
(1749, 18, 'Kafr', NULL, NULL, 'كفر', 0),
(1750, 18, 'Kelesh', NULL, NULL, 'كلش', 0),
(1751, 18, 'Kfar Chakha', NULL, NULL, 'كفر شخي', 0),
(1752, 18, 'Kfar Chilli', NULL, NULL, 'كفر شلي', 0),
(1753, 18, 'Kfar Hitta', NULL, NULL, 'كفر حتى', 0),
(1754, 18, 'Kfar Kahli', NULL, NULL, 'كفر كخلة', 0),
(1755, 18, 'Kfar Kidda', NULL, NULL, 'كفر كده', 0),
(1756, 18, 'Kfar Mashoun', NULL, NULL, 'كفر مسحون', 0),
(1757, 18, 'Kfar Qaouass', NULL, NULL, 'كفر قواص', 0),
(1758, 18, 'Kfar Sal', NULL, NULL, 'كفر سالا', 0),
(1759, 18, 'Kfar Shabbouh', NULL, NULL, 'كفر شبوح', 0),
(1760, 18, 'Kfar Zbouna', NULL, NULL, 'كفرزبونا', 0),
(1761, 18, 'Kfarbaal', NULL, NULL, 'كفر بعال', 0),
(1762, 18, 'Kfoun', NULL, NULL, 'كفون', 0),
(1763, 18, 'Khaab', NULL, NULL, 'خعب', 0),
(1764, 18, 'Khaabiya', NULL, NULL, 'خاعبية', 0),
(1765, 18, 'Kharbe', NULL, NULL, 'خاربة جبيل', 0),
(1766, 18, 'Kour El Hooua', NULL, NULL, 'كور الهوا', 0),
(1767, 18, 'Laqlouq', NULL, NULL, 'اللقلوق', 0),
(1768, 18, 'Lassa', NULL, NULL, 'لاسا', 0),
(1769, 18, 'Lehfed', NULL, NULL, 'لحفد', 0),
(1770, 18, 'Maad', NULL, NULL, 'معاد', 0),
(1771, 18, 'Maaytiq', NULL, NULL, 'معيتيق', 0),
(1772, 18, 'Mahmarat Bejje', NULL, NULL, 'محمرة بجّه', 0),
(1773, 18, 'Maifouq', NULL, NULL, 'ميفوق', 0),
(1774, 18, 'Majdel', NULL, NULL, 'المجدل', 0),
(1775, 18, 'Malhoun', NULL, NULL, 'ملحون', 0),
(1776, 18, 'Mar Meqna', NULL, NULL, 'مار مقانة', 0),
(1777, 18, 'Marbaa', NULL, NULL, 'مربعه', 0),
(1778, 18, 'Marj Mokhtara', NULL, NULL, 'مرج مختارة', 0),
(1779, 18, 'Mazraa Lassa', NULL, NULL, 'مزرعة لاسا', 0),
(1780, 18, 'Mazraat ej Jmaiyel', NULL, NULL, 'مزرعة الجميل', 0),
(1781, 18, 'Mazraat el Hajj Khalil', NULL, NULL, 'مزرعة الحاج خليل', 0),
(1782, 18, 'Mazraat El Maadene', NULL, NULL, 'مزرعة المعادن', 0),
(1783, 18, 'Mazraat Es Siyad', NULL, NULL, 'مزرعة السياد', 0),
(1784, 18, 'Mdamit', NULL, NULL, 'مداميت', 0),
(1785, 18, 'Mechane', NULL, NULL, 'مشان', 0),
(1786, 18, 'Mechhellene', NULL, NULL, 'مشحلان', 0),
(1787, 18, 'MechMech Jbeil', NULL, NULL, 'مشمش جبيل', 0),
(1788, 18, 'Meftah es Sellom', NULL, NULL, 'مفتاح السلم', 0),
(1789, 18, 'Mestita', NULL, NULL, 'مستيتا', 0),
(1790, 18, 'Mghaira', NULL, NULL, 'مغيره', 0),
(1791, 18, 'Mnaitra', NULL, NULL, 'منيطرة', 0),
(1792, 18, 'Monsef', NULL, NULL, 'المنصف', 0),
(1793, 18, 'Mouftah el Mir', NULL, NULL, 'مفتاح المير', 0),
(1794, 18, 'Moukhada', NULL, NULL, 'مخاضة', 0),
(1795, 18, 'Mzarib', NULL, NULL, 'المزاريب', 0),
(1796, 18, 'Nabaa Tourzaiya', NULL, NULL, 'نبع طورزيا', 0),
(1797, 18, 'Nahrh Ibrahim', NULL, NULL, 'نهر ابراهيم', 0),
(1798, 18, 'Naqour', NULL, NULL, 'نقور', 0),
(1799, 18, 'Ouata El Bane', NULL, NULL, 'وطى البان', 0),
(1800, 18, 'Ouata el bourj', NULL, NULL, 'وطى البرج', 0),
(1801, 18, 'Ouata el Khirbe', NULL, NULL, 'وطى الخربة', 0),
(1802, 18, 'Qartaba', NULL, NULL, 'قرطبا', 0),
(1803, 18, 'Qartaboun', NULL, NULL, 'قرطبون', 0),
(1804, 18, 'Qass', NULL, NULL, 'القص', 0),
(1805, 18, 'Qateaa', NULL, NULL, 'القاطعة', 0),
(1806, 18, 'Qattara', NULL, NULL, 'قطارة', 0),
(1807, 18, 'Qehmez', NULL, NULL, 'قهمز', 0),
(1808, 18, 'Qerqraiya', NULL, NULL, 'قرقريا', 0),
(1809, 18, 'Qeryaqous', NULL, NULL, 'قرياقس', 0),
(1810, 18, 'Ramiet el Hsoun', NULL, NULL, 'رامية الحصون', 0),
(1811, 18, 'Ramout', NULL, NULL, 'الراموط', 0),
(1812, 18, 'Ras Osta', NULL, NULL, 'راس اسطا', 0),
(1813, 18, 'Rihani', NULL, NULL, 'ريحانة', 0),
(1814, 18, 'Rouaiss', NULL, NULL, 'رويس', 0),
(1815, 18, 'Saqi Lassa', NULL, NULL, 'سقي لاسا', 0),
(1816, 18, 'Saqi Rechmaiya', NULL, NULL, 'سقي رشميا', 0),
(1817, 18, 'Saqiet ed Delb', NULL, NULL, 'ساقية الدلب', 0),
(1818, 18, 'Saqiet el Khait', NULL, NULL, 'ساقية الخيط', 0),
(1819, 18, 'Sariita', NULL, NULL, 'سرعيتا', 0),
(1820, 18, 'Sbail', NULL, NULL, 'سبايل', 0),
(1821, 18, 'Sebrine', NULL, NULL, 'سربين', 0),
(1822, 18, 'Serghol', NULL, NULL, 'سرغل', 0),
(1823, 18, 'Sinnawr', NULL, NULL, 'سنور', 0),
(1824, 18, 'Sirine', NULL, NULL, 'سيران', 0),
(1825, 18, 'Slaiyeb Ghalboun', NULL, NULL, 'صلايب غلبون', 0),
(1826, 18, 'Souane', NULL, NULL, 'صوانة', 0),
(1827, 18, 'Souq el Firi', NULL, NULL, 'سوق الفارة', 0),
(1828, 18, 'Taht el Qalaa', NULL, NULL, 'تحت القلعة', 0),
(1829, 18, 'Talbita', NULL, NULL, 'تلبيتا', 0),
(1830, 18, 'Tartij', NULL, NULL, 'ترتج', 0),
(1831, 18, 'Tedmor', NULL, NULL, 'تدمر', 0),
(1832, 18, 'Terouil', NULL, NULL, 'ترويل', 0),
(1833, 18, 'Tourzaiya', NULL, NULL, 'طورزيا', 0),
(1834, 18, 'Wadi el Kalb', NULL, NULL, 'وادي الكلب', 0),
(1835, 18, 'Yanouh', NULL, NULL, 'يانوح', 0),
(1836, 18, 'Zaayber', NULL, NULL, 'زعيبر', 0),
(1837, 18, 'Zebdine', NULL, NULL, 'زبدين', 0),
(1838, 18, 'Zelhmaya', NULL, NULL, 'زلحمايا', 0),
(1839, 18, 'Zmar', NULL, NULL, 'زمار', 0),
(1840, 20, 'Aabri', NULL, NULL, 'عبري', 0),
(1841, 20, 'Aachqout', NULL, NULL, 'عشقوت', 0),
(1842, 20, 'Aafs kesrwane', NULL, NULL, 'عفص كسروان', 0),
(1843, 20, 'Aajaltoun', NULL, NULL, 'عجلتون', 0),
(1844, 20, 'Aarabe Ghosta', NULL, NULL, 'عربة غوسطا', 0),
(1845, 20, 'Aaramoun Kesrwane', NULL, NULL, 'عرمون كسروان', 0),
(1846, 20, 'Aayoun es Simane', NULL, NULL, 'عيون السيمان', 0),
(1847, 20, 'Aazrane', NULL, NULL, 'عزرانة', 0),
(1848, 20, 'Adonis Kesserwan', NULL, NULL, 'أدونيس كسروان', 0),
(1849, 20, 'Aghbe', NULL, NULL, 'إغبة', 0),
(1850, 20, 'Ain Abaal', NULL, NULL, 'عين ابعل', 0),
(1851, 20, 'Ain Ed Delbe', NULL, NULL, 'عين الدلبة', 0),
(1852, 20, 'Ain Ej Jorn', NULL, NULL, 'عين الجرن', 0),
(1853, 20, 'Ain Er Rihane', NULL, NULL, 'عين الريحان', 0),
(1854, 20, 'Ain Et Tannour', NULL, NULL, 'عين التنور', 0),
(1855, 20, 'Ain Jouaiya', NULL, NULL, 'عين جويا', 0),
(1856, 20, 'Aintoura', NULL, NULL, 'عينطورة', 0),
(1857, 20, 'Ayn Es Safra', NULL, NULL, 'عين الصفرا', 0),
(1858, 20, 'Bahhara', NULL, NULL, 'بحارة', 0),
(1859, 20, 'Balloune', NULL, NULL, 'بلونة', 0),
(1860, 20, 'Batha', NULL, NULL, 'بطحا', 0),
(1861, 20, 'Bayader Fatqa', NULL, NULL, 'بيادر فتقا', 0),
(1862, 20, 'Beit Eid', NULL, NULL, 'بيت عيد', 0),
(1863, 20, 'Beit El Kreidi', NULL, NULL, 'بيت كريدي', 0),
(1864, 20, 'Beit Khachbou', NULL, NULL, 'بيت خشبو', 0),
(1865, 20, 'Beqaatet Aachqout', NULL, NULL, 'بقعاتة عشقوت', 0),
(1866, 20, 'Biqaatet Kannane', NULL, NULL, 'بقعاتة كنعان', 0),
(1867, 20, 'Bizhel', NULL, NULL, 'بزحل', 0),
(1868, 20, 'Bkirke', NULL, NULL, 'بكركي', 0),
(1869, 20, 'Blat Mazraat Kfar Dibiane', NULL, NULL, 'بلاط كفر ذبيان', 0),
(1870, 20, 'Bouar', NULL, NULL, 'بوار', 0),
(1871, 20, 'Bqaatouta', NULL, NULL, 'بقعتوتا', 0),
(1872, 20, 'Bqaq Ed Dine', NULL, NULL, 'بقاق الدين', 0),
(1873, 20, 'Broummana Kfar Dibian', NULL, NULL, 'برمانا كفر ذبيان', 0),
(1874, 20, 'Bzoummar', NULL, NULL, 'بزمار', 0),
(1875, 20, 'Chaab', NULL, NULL, 'شعب', 0),
(1876, 20, 'Chahtoul', NULL, NULL, 'شحتول', 0),
(1877, 20, 'Chehhara', NULL, NULL, 'شحارة', 0),
(1878, 20, 'Chnanaair', NULL, NULL, 'شننعير', 0),
(1879, 20, 'Chouaya', NULL, NULL, 'شويا يحشوش', 0),
(1880, 20, 'Chouene', NULL, NULL, 'شوان', 0),
(1881, 20, 'Christ Roi', NULL, NULL, 'يسوع الملك', 0),
(1882, 20, 'Daasse', NULL, NULL, 'دعسه', 0),
(1883, 20, 'Dahr Badris', NULL, NULL, 'ضهر بدريس', 0),
(1884, 20, 'Dahr el Qattine', NULL, NULL, 'ضهر القطين', 0),
(1885, 20, 'Daraaoun', NULL, NULL, 'درعون', 0),
(1886, 20, 'Darayia Kesrwane', NULL, NULL, 'داريا كسروان', 0),
(1887, 20, 'Dayr Saydet el Haqle', NULL, NULL, 'دير سيدة الحقلة', 0),
(1888, 20, 'Deir Baklouche', NULL, NULL, 'دير بقلوش', 0),
(1889, 20, 'Deir Hrach', NULL, NULL, 'دير حراش', 0),
(1890, 20, 'Deir Nisbey', NULL, NULL, 'دير نسبيه', 0),
(1891, 20, 'Deir Ram Bou Daqen', NULL, NULL, 'دير رام بو دقن', 0),
(1892, 20, 'Deir saydet Louaize', NULL, NULL, 'دير سيدة اللويزة', 0),
(1893, 20, 'Deir Ziraaya', NULL, NULL, 'دير زرعيا', 0),
(1894, 20, 'Delbta', NULL, NULL, 'دلبتا', 0),
(1895, 20, 'Deraali', NULL, NULL, 'درعليه', 0),
(1896, 20, 'Dqarine', NULL, NULL, 'دقارين', 0),
(1897, 20, 'Ech Chqif Bqaatouta', NULL, NULL, 'شقيف بقعتوتا', 0),
(1898, 20, 'Ed Dahr', NULL, NULL, 'الضهر', 0),
(1899, 20, 'Ed Dahr Ghbale', NULL, NULL, 'ضهر غبالة', 0),
(1900, 20, 'Ed Daoura Shaile', NULL, NULL, 'دورة سهيلة', 0),
(1901, 20, 'Edma et Dafne', NULL, NULL, 'أدما والدفنه', 0),
(1902, 20, 'Ej Jaayel', NULL, NULL, 'جعايل غبالة', 0),
(1903, 20, 'El Aaqaybe Kesrouane', NULL, NULL, 'عقيبة', 0),
(1904, 20, 'El Aazra et el Aazr', NULL, NULL, 'عذره والعذر', 0),
(1905, 20, 'El Ghouabi', NULL, NULL, 'غوابي', 0),
(1906, 20, 'El Hara Mairouba', NULL, NULL, 'حارة ميروبا', 0),
(1907, 20, 'El Kharayeb', NULL, NULL, 'خرايب', 0),
(1908, 20, 'El Kharayeb Dlebta', NULL, NULL, 'الخرايب دلبتا', 0),
(1909, 20, 'El Maaden', NULL, NULL, 'معادن', 0),
(1910, 20, 'El Marji', NULL, NULL, 'مرج', 0),
(1911, 20, 'El Massiaf', NULL, NULL, 'مصيف', 0),
(1912, 20, 'El Qacha', NULL, NULL, 'قشا', 0),
(1913, 20, 'El Qarqouf', NULL, NULL, 'قرقوف', 0),
(1914, 20, 'Es Salhiye Bezhel', NULL, NULL, 'صالحية بزحل', 0),
(1915, 20, 'Es Shoum Kfar Debiane', NULL, NULL, 'شوم كفر ذبيان', 0),
(1916, 20, 'Es Slayekh', NULL, NULL, 'السلايخ', 0),
(1917, 20, 'Es Souhoum', NULL, NULL, 'سوحوم الغينة', 0),
(1918, 20, 'Esh Shahoute', NULL, NULL, 'الشاحوط', 0),
(1919, 20, 'Et Tarouaa', NULL, NULL, 'التروع', 0),
(1920, 20, 'Ez Zaaytriye', NULL, NULL, 'زعيترية', 0),
(1921, 20, 'Faitroun', NULL, NULL, 'فيطرون', 0),
(1922, 20, 'Fanyoun', NULL, NULL, 'فنيوان', 0),
(1923, 20, 'Faqra', NULL, NULL, 'فقرا', 0),
(1924, 20, 'Faraiya', NULL, NULL, 'فاريا', 0),
(1925, 20, 'Fatqa', NULL, NULL, 'فتقا', 0),
(1926, 20, 'Ftah Ech Chouha', NULL, NULL, 'فتاح الشوحا', 0),
(1927, 20, 'Ftahate', NULL, NULL, 'فتاحات جورة الترمس', 0),
(1928, 20, 'Ghadir jounieh', NULL, NULL, 'غادير جونيه', 0),
(1929, 20, 'Ghadras', NULL, NULL, 'غدراس', 0),
(1930, 20, 'Ghazir', NULL, NULL, 'غزير', 0),
(1931, 20, 'Ghbale', NULL, NULL, 'غبالة', 0),
(1932, 20, 'Ghine', NULL, NULL, 'غينة', 0),
(1933, 20, 'Ghoshraiya', NULL, NULL, 'غيشرايه', 0),
(1934, 20, 'Ghosta', NULL, NULL, 'غوسطا', 0),
(1935, 20, 'Hakl Er Raiyess', NULL, NULL, 'حقل الريس', 0),
(1936, 20, 'Hamassiyat', NULL, NULL, 'حماسيات', 0),
(1937, 20, 'Haret El Mir Zouk Mkayel', NULL, NULL, 'حارة المير ذوق مكايل', 0),
(1938, 20, 'Haret Halane', NULL, NULL, 'حارة حلان', 0),
(1939, 20, 'Haret Sakher', NULL, NULL, 'حارة صخر', 0),
(1940, 20, 'Harharaya', NULL, NULL, 'هرهريا', 0),
(1941, 20, 'Hariqa', NULL, NULL, 'حريقة', 0),
(1942, 20, 'Hariqa Chahtoul', NULL, NULL, 'حريق شحتول', 0),
(1943, 20, 'Harissa', NULL, NULL, 'حريصا', 0),
(1944, 20, 'Hayata', NULL, NULL, 'حياطة', 0),
(1945, 20, 'Hilane', NULL, NULL, 'حلان', 0),
(1946, 20, 'Hrajel', NULL, NULL, 'حراجل', 0),
(1947, 20, 'Hsayn', NULL, NULL, 'حصين', 0),
(1948, 20, 'Jdaidet Ghazir', NULL, NULL, 'جديدة غزير', 0),
(1949, 20, 'Jitta', NULL, NULL, 'جعيتا', 0),
(1950, 20, 'Jouar El Baouechiq', NULL, NULL, 'جوار البواشق', 0),
(1951, 20, 'Jouar El Hachich chahtoul', NULL, NULL, 'جوار الحشيش شحتول', 0),
(1952, 20, 'Jounieh', NULL, NULL, 'جونيه', 0),
(1953, 20, 'Jounieh Kaslik', NULL, NULL, 'جونيه كسليك', 0),
(1954, 20, 'Jouret Bedrane', NULL, NULL, 'جورة بدران', 0),
(1955, 20, 'Jouret Ed Dardour', NULL, NULL, 'جورة الدردور', 0),
(1956, 20, 'Jouret Et Tormoss', NULL, NULL, 'جورة الترمس', 0),
(1957, 20, 'Jouret Mghad', NULL, NULL, 'جورة مهاد', 0),
(1958, 20, 'Kfar Hbab', NULL, NULL, 'كفرحباب', 0),
(1959, 20, 'Kfar Jrif', NULL, NULL, 'كفر جريف', 0),
(1960, 20, 'Kfardibiane', NULL, NULL, 'كفر دبيان', 0),
(1961, 20, 'Kfarshihham', NULL, NULL, 'كفر شيحام', 0),
(1962, 20, 'Kfaryassine', NULL, NULL, 'كفر ياسين', 0),
(1963, 20, 'Kfour', NULL, NULL, 'الكفور', 0),
(1964, 20, 'Khalal', NULL, NULL, 'خلال', 0),
(1965, 20, 'Khdayra', NULL, NULL, 'خضيره', 0),
(1966, 20, 'Ksayer', NULL, NULL, 'كساير', 0),
(1967, 20, 'Maamelteine', NULL, NULL, 'معاملتين', 0),
(1968, 20, 'Maarab', NULL, NULL, 'معراب', 0),
(1969, 20, 'Maaysra', NULL, NULL, 'المعيصرة', 0),
(1970, 20, 'Mairouba', NULL, NULL, 'ميروبا', 0),
(1971, 20, 'Mar Nouhra', NULL, NULL, 'مار نهرا', 0),
(1972, 20, 'Mashhat', NULL, NULL, 'مشحات', 0),
(1973, 20, 'Mazzarat Er Ras', NULL, NULL, 'مزرعة الراس', 0),
(1974, 20, 'Mchaa El Ftouh', NULL, NULL, 'مشاع الفتوح', 0),
(1975, 20, 'Mchaa Faraya', NULL, NULL, 'مشاع فاريا', 0),
(1976, 20, 'Mchaa Kfar Dibian', NULL, NULL, 'مشاع كفر ذبيان', 0),
(1977, 20, 'Mchati', NULL, NULL, 'مشاته', 0),
(1978, 20, 'Mehqane el Mazloum', NULL, NULL, 'محقان المظلوم', 0),
(1979, 20, 'Mghayer', NULL, NULL, 'المغاير', 0),
(1980, 20, 'Mradiye', NULL, NULL, 'مرادية', 0),
(1981, 20, 'Mrah El Mir', NULL, NULL, 'مراح المير', 0),
(1982, 20, 'Mreijet Kesserwan', NULL, NULL, 'مريجة كسروان', 0),
(1983, 20, 'Nabaa el Mghara', NULL, NULL, 'نبع المغارة', 0),
(1984, 20, 'Nahr Ed Dahab', NULL, NULL, 'نهر الدهب', 0),
(1985, 20, 'Nahr El Hussein', NULL, NULL, 'نهر الحصين', 0),
(1986, 20, 'Nahr el Kalb', NULL, NULL, 'نهر الكلب', 0),
(1987, 20, 'Nammoura', NULL, NULL, 'النموره', 0),
(1988, 20, 'Nmoura', NULL, NULL, 'نمورة', 0),
(1989, 20, 'Ouata Ej Jaouz', NULL, NULL, 'وطى الجوز', 0),
(1990, 20, 'Ouata el Laouz', NULL, NULL, 'وطى اللوز', 0),
(1991, 20, 'Ouata Nahr El Kelb', NULL, NULL, 'وطى نهر الكلب', 0),
(1992, 20, 'Ouata Slam', NULL, NULL, 'وطى سلام', 0),
(1993, 20, 'Qalaa Kfardibiane', NULL, NULL, 'قلعة كفر ذبيان', 0),
(1994, 20, 'Qalaat Maarab', NULL, NULL, 'قلعة معراب', 0),
(1995, 20, 'Qarqara', NULL, NULL, 'قرقرا', 0),
(1996, 20, 'Qarqouf', NULL, NULL, 'القرقوف', 0),
(1997, 20, 'Qarsa', NULL, NULL, 'قرصة', 0),
(1998, 20, 'Qattine', NULL, NULL, 'القطين', 0),
(1999, 20, 'Qlaiaat', NULL, NULL, 'قليعات كسروان', 0),
(2000, 20, 'Qmayrze', NULL, NULL, 'قميزرة', 0),
(2001, 20, 'Qouwale', NULL, NULL, 'قواله', 0),
(2002, 20, 'Raashine', NULL, NULL, 'رعشين', 0),
(2003, 20, 'Raifoun', NULL, NULL, 'ريفون', 0),
(2004, 20, 'Ramiet Kfaryasin', NULL, NULL, 'رامية كفر ياسين', 0),
(2005, 20, 'Rihane Kesrwane', NULL, NULL, 'ريحان كسروان', 0),
(2006, 20, 'Safra kesrwane', NULL, NULL, 'صفرا كسروان', 0),
(2007, 20, 'Sahel Aalma', NULL, NULL, 'ساحل علما', 0),
(2008, 20, 'Saidet Bzoummar', NULL, NULL, 'دير سيدة بزمار', 0);
INSERT INTO `area` (`id`, `caza_id`, `name`, `created_at`, `updated_at`, `arabic`, `gouvernate_id`) VALUES
(2009, 20, 'Sarba', NULL, NULL, 'صربا', 0),
(2010, 20, 'Shaile', NULL, NULL, 'سهيلة', 0),
(2011, 20, 'Sirje', NULL, NULL, 'سيرجه', 0),
(2012, 20, 'Snoubar', NULL, NULL, 'صنوبر يحشوش', 0),
(2013, 20, 'Tabarja', NULL, NULL, 'طبرجا', 0),
(2014, 20, 'Talle', NULL, NULL, 'تلة', 0),
(2015, 20, 'Wata Tabriye', NULL, NULL, 'وطى طبرية', 0),
(2016, 20, 'Yahchouch', NULL, NULL, 'يحشوش', 0),
(2017, 20, 'Zaaitra', NULL, NULL, 'زعيتره', 0),
(2018, 20, 'Zayer', NULL, NULL, 'زاير', 0),
(2019, 20, 'Zeitoun', NULL, NULL, 'زيتون', 0),
(2020, 20, 'Zleikat', NULL, NULL, 'زليكات', 0),
(2021, 20, 'Zouk Mosbeh', NULL, NULL, 'ذوق مصبح', 0),
(2022, 20, 'Zouq Mkayel', NULL, NULL, 'ذوق مكايل', 0),
(2023, 7, 'Aabdine Bcharre', NULL, NULL, 'عبدين بشري', 0),
(2024, 7, 'Ariz', NULL, NULL, 'أرز', 0),
(2025, 7, 'Bane', NULL, NULL, 'بان', 0),
(2026, 7, 'Barhalioun', NULL, NULL, 'برحليون', 0),
(2027, 7, 'Bazaoun', NULL, NULL, 'بزعون', 0),
(2028, 7, 'Bcharre', NULL, NULL, 'بشري', 0),
(2029, 7, 'Beit Menzer', NULL, NULL, 'بيت منذر', 0),
(2030, 7, 'Billa', NULL, NULL, 'بلا', 0),
(2031, 7, 'Blaouza', NULL, NULL, 'بلوزا', 0),
(2032, 7, 'Bqaa Kafra', NULL, NULL, 'بقاع كفرا', 0),
(2033, 7, 'Bqerqacha', NULL, NULL, 'بقرقاشا', 0),
(2034, 7, 'Braissat', NULL, NULL, 'بريسات', 0),
(2035, 7, 'Chira', NULL, NULL, 'شيرا', 0),
(2036, 7, 'Dimane', NULL, NULL, 'ديمان', 0),
(2037, 7, 'Hadchit', NULL, NULL, 'حدشيت', 0),
(2038, 7, 'Hadet Ej jebbe', NULL, NULL, 'حدث الجبه', 0),
(2039, 7, 'Hasroun', NULL, NULL, 'حصرون', 0),
(2040, 7, 'Kfar Saroun dimane', NULL, NULL, 'كفر صارون الديمان', 0),
(2041, 7, 'Mazraat Assaf', NULL, NULL, 'مزرعة عساف', 0),
(2042, 7, 'Mazraat Beni Saab', NULL, NULL, 'مزرعة بني صعب', 0),
(2043, 7, 'Mchaa ej Joubbeh', NULL, NULL, 'مشاع الجبه', 0),
(2044, 7, 'Moghr El Ahoual', NULL, NULL, 'مغر الاحول', 0),
(2045, 7, 'Qnaiouer', NULL, NULL, 'قنيور', 0),
(2046, 7, 'Qnat', NULL, NULL, 'قناة', 0),
(2047, 7, 'Tourza', NULL, NULL, 'طورزا', 0),
(2048, 7, 'Wadi Qannoubine', NULL, NULL, 'وادي قنوبين', 0),
(2049, 11, 'Aabdelle', NULL, NULL, 'عبدللي', 0),
(2050, 11, 'Aabrine', NULL, NULL, 'عبرين', 0),
(2051, 11, 'Aalali', NULL, NULL, 'علالي', 0),
(2052, 11, 'Aaoura', NULL, NULL, 'عورا البترون', 0),
(2053, 11, 'Aartez', NULL, NULL, 'عرطز', 0),
(2054, 11, 'Ain el Batie', NULL, NULL, 'عين البطيه', 0),
(2055, 11, 'Ain el Blat', NULL, NULL, 'عين البلاط', 0),
(2056, 11, 'Ain er Raha', NULL, NULL, 'عين الراحا', 0),
(2057, 11, 'Assia', NULL, NULL, 'اسيا', 0),
(2058, 11, 'Balaa', NULL, NULL, 'بلعة', 0),
(2059, 11, 'Barzakine', NULL, NULL, 'برزقين', 0),
(2060, 11, 'Basbina', NULL, NULL, 'بسبينا', 0),
(2061, 11, 'Batroun', NULL, NULL, 'بترون', 0),
(2062, 11, 'Bcheale', NULL, NULL, 'بشعلة', 0),
(2063, 11, 'Bechtoudar-Aoura', NULL, NULL, 'بشتودار', 0),
(2064, 11, 'Beit Chlala', NULL, NULL, 'بيت شلالا', 0),
(2065, 11, 'Beit Kassab', NULL, NULL, 'بيت كسّاب', 0),
(2066, 11, 'Bijdarfel', NULL, NULL, 'بجدرفل', 0),
(2067, 11, 'Borj', NULL, NULL, 'البرج كفر عبيدا', 0),
(2068, 11, 'Boustane El Aassi', NULL, NULL, 'بساتين العصي', 0),
(2069, 11, 'Bqaiaa et Dahr Abi Yaghi', NULL, NULL, 'بقيعة البترون', 0),
(2070, 11, 'Bqosmaiya', NULL, NULL, 'بقسميا', 0),
(2071, 11, 'Chabtine', NULL, NULL, 'شبطين', 0),
(2072, 11, 'Chatine', NULL, NULL, 'شاتين', 0),
(2073, 11, 'Chawi', NULL, NULL, 'شاوي', 0),
(2074, 11, 'Chekka', NULL, NULL, 'شكَا', 0),
(2075, 11, 'Chnata', NULL, NULL, 'شناتا', 0),
(2076, 11, 'Daael', NULL, NULL, 'داعل', 0),
(2077, 11, 'Dahr Abi Yaghi', NULL, NULL, 'ضهر ابي ياغي', 0),
(2078, 11, 'Dahr el Ghbare', NULL, NULL, 'ضهر الغبار', 0),
(2079, 11, 'Dahr El Qotlob', NULL, NULL, 'ضهر القطلب', 0),
(2080, 11, 'Dahr Mar Risha', NULL, NULL, 'ضهر مار ريشا', 0),
(2081, 11, 'Dawrat', NULL, NULL, 'دورة كفر عبيدا', 0),
(2082, 11, 'Dayr Shouwah', NULL, NULL, 'دير شواح', 0),
(2083, 11, 'Deir Billa', NULL, NULL, 'ديربلا', 0),
(2084, 11, 'Deir Kfifane', NULL, NULL, 'دير كفيفان', 0),
(2085, 11, 'Deir Mar Youhanna Douma', NULL, NULL, 'دير مار يوحنا دوما', 0),
(2086, 11, 'Deir Mar Youssef Jrabta', NULL, NULL, 'دير مار يوسف جربتا', 0),
(2087, 11, 'Derya', NULL, NULL, 'دريا', 0),
(2088, 11, 'Douma', NULL, NULL, 'دوما', 0),
(2089, 11, 'Douq', NULL, NULL, 'دوق', 0),
(2090, 11, 'Edde el Batroun', NULL, NULL, 'إده البترون', 0),
(2091, 11, 'El Aazeqa', NULL, NULL, 'عزيقه', 0),
(2092, 11, 'El Hamra JRANE', NULL, NULL, 'حمرا جران', 0),
(2093, 11, 'El Harf', NULL, NULL, 'حرف', 0),
(2094, 11, 'El Heri', NULL, NULL, 'هري', 0),
(2095, 11, 'El Khraize', NULL, NULL, 'خريزه', 0),
(2096, 11, 'El Midane Kfifane', NULL, NULL, 'ميدان كفيفان', 0),
(2097, 11, 'El Qabaah', NULL, NULL, 'قبع كفيفان', 0),
(2098, 11, 'En Nahriye', NULL, NULL, 'نهريه', 0),
(2099, 11, 'Fadaous', NULL, NULL, 'فدعوس', 0),
(2100, 11, 'Fehta', NULL, NULL, 'فحتا', 0),
(2101, 11, 'Ftahat', NULL, NULL, 'فتاحات', 0),
(2102, 11, 'Ghouma', NULL, NULL, 'غوما', 0),
(2103, 11, 'Hadtoun', NULL, NULL, 'حدتون', 0),
(2104, 11, 'Hai el Birke', NULL, NULL, 'حي البركة', 0),
(2105, 11, 'Halta', NULL, NULL, 'حلتا', 0),
(2106, 11, 'Hamat', NULL, NULL, 'حامات', 0),
(2107, 11, 'Hannouch', NULL, NULL, 'حنٌوش', 0),
(2108, 11, 'Harbouna', NULL, NULL, 'حربونا', 0),
(2109, 11, 'Hardine', NULL, NULL, 'حردين', 0),
(2110, 11, 'Harissa el batroun', NULL, NULL, 'حريصا البترون', 0),
(2111, 11, 'Hazrita', NULL, NULL, 'حزريتا', 0),
(2112, 11, 'Hourata el batroun', NULL, NULL, 'حوراتا البترون', 0),
(2113, 11, 'Hrayek', NULL, NULL, 'حرايق', 0),
(2114, 11, 'Ijdabra', NULL, NULL, 'اجدبرا', 0),
(2115, 11, 'Jibla', NULL, NULL, 'جبلا', 0),
(2116, 11, 'Joundi', NULL, NULL, 'جندي', 0),
(2117, 11, 'Jrane', NULL, NULL, 'جران', 0),
(2118, 11, 'Jrebta', NULL, NULL, 'جربتا', 0),
(2119, 11, 'Kandoula', NULL, NULL, 'قندولا', 0),
(2120, 11, 'Kfar Aabida', NULL, NULL, 'كفر عبيدا', 0),
(2121, 11, 'Kfar Chlaimane', NULL, NULL, 'كفر شليمان', 0),
(2122, 11, 'Kfar Hatna', NULL, NULL, 'كفرحتنا', 0),
(2123, 11, 'Kfar Hay', NULL, NULL, 'كفرحي', 0),
(2124, 11, 'Kfar Helda', NULL, NULL, 'كفر حلدا', 0),
(2125, 11, 'Kfarhollos', NULL, NULL, 'كفر خلص', 0),
(2126, 11, 'Kfifane', NULL, NULL, 'كفيفان', 0),
(2127, 11, 'Kfour El Aarbi', NULL, NULL, 'كفور العربي', 0),
(2128, 11, 'Koubba', NULL, NULL, 'كوبا', 0),
(2129, 11, 'Kour', NULL, NULL, 'كور', 0),
(2130, 11, 'Madfoun', NULL, NULL, 'مدفون', 0),
(2131, 11, 'Mahmerch', NULL, NULL, 'محمرش', 0),
(2132, 11, 'Mar Mama', NULL, NULL, 'مار ماما', 0),
(2133, 11, 'Mar Youhanna Maroun', NULL, NULL, 'مار يوحنا مارون', 0),
(2134, 11, 'Mar Youssef', NULL, NULL, 'مار يوسف', 0),
(2135, 11, 'Masrah', NULL, NULL, 'مسرح', 0),
(2136, 11, 'Mazraat Biyade', NULL, NULL, 'مزرعة بياض', 0),
(2137, 11, 'Meghrak', NULL, NULL, 'مغراق', 0),
(2138, 11, 'Mrah Chdid', NULL, NULL, 'مراح شديد', 0),
(2139, 11, 'Mrah El Haj', NULL, NULL, 'مراح الحاج', 0),
(2140, 11, 'Mrah Ez Zaiat', NULL, NULL, 'مراح الزيات', 0),
(2141, 11, 'Myle', NULL, NULL, 'ميل', 0),
(2142, 11, 'Nabaa ej Jdid', NULL, NULL, 'نبع الجديد', 0),
(2143, 11, 'Nahle batroun', NULL, NULL, 'نحلا البترون', 0),
(2144, 11, 'Najmet es Sobh', NULL, NULL, 'نجمة الصبح', 0),
(2145, 11, 'Niha El Batroun', NULL, NULL, 'نيحا البترون', 0),
(2146, 11, 'Ouadi ej Jord', NULL, NULL, 'وادي الجرد', 0),
(2147, 11, 'Ouadi Tanourine Et Tahta', NULL, NULL, 'وادي تنورين التحتا', 0),
(2148, 11, 'Ouata Haub', NULL, NULL, 'وطى حوب', 0),
(2149, 11, 'Qarnaoun', NULL, NULL, 'قرنعون', 0),
(2150, 11, 'Qornet el Marj', NULL, NULL, 'قرنة المرج', 0),
(2151, 11, 'Quajh El - Hajar', NULL, NULL, 'وجه الحجر', 0),
(2152, 11, 'Racha', NULL, NULL, 'راشا', 0),
(2153, 11, 'Rachana', NULL, NULL, 'راشانا', 0),
(2154, 11, 'Rachkida', NULL, NULL, 'راشكيدا', 0),
(2155, 11, 'Rachkidde', NULL, NULL, 'راشكِدّه', 0),
(2156, 11, 'Ram el batroun', NULL, NULL, 'الرام البترون', 0),
(2157, 11, 'Ramate', NULL, NULL, 'رمات', 0),
(2158, 11, 'Ras Bnaiya', NULL, NULL, 'راس بنيه', 0),
(2159, 11, 'Ras Ed Daouali', NULL, NULL, 'راس الدوالي', 0),
(2160, 11, 'Ras Nahhach', NULL, NULL, 'راس نحاش', 0),
(2161, 11, 'Selaata', NULL, NULL, 'سلعاتا', 0),
(2162, 11, 'Sghar', NULL, NULL, 'صغار', 0),
(2163, 11, 'Smar Jbail', NULL, NULL, 'سمار جبيل', 0),
(2164, 11, 'Sourat', NULL, NULL, 'صورات', 0),
(2165, 11, 'Ssel\'aal', NULL, NULL, 'سلع', 0),
(2166, 11, 'Tannourine el Faouqa', NULL, NULL, 'تنورين الفوقا', 0),
(2167, 11, 'Tanourine Et Tahta', NULL, NULL, 'تنورين التحتا', 0),
(2168, 11, 'Thoum', NULL, NULL, 'تحوم', 0),
(2169, 11, 'Toula', NULL, NULL, 'تولا', 0),
(2170, 11, 'Yarita', NULL, NULL, 'ياريتا', 0),
(2171, 11, 'Zane', NULL, NULL, 'زان', 0),
(2172, 13, 'DEIR EL BALAMAND', NULL, NULL, 'دير البلمند', 0),
(2173, 13, 'KELBATA', NULL, NULL, 'كلباتا', 0),
(2174, 13, 'MJEYDIL KFAR HAZIR', NULL, NULL, 'مجيدل كفر حزير', 0),
(2175, 13, 'Aaba', NULL, NULL, 'عبا الكورة', 0),
(2176, 13, 'Aafsdiq', NULL, NULL, 'عفصديق', 0),
(2177, 13, 'Ain Aakrine', NULL, NULL, 'عين عكرين', 0),
(2178, 13, 'Al-Hraiche', NULL, NULL, 'حريشه', 0),
(2179, 13, 'Amioun', NULL, NULL, 'اميون', 0),
(2180, 13, 'Bahbouch', NULL, NULL, 'بحبوش', 0),
(2181, 13, 'Barghoun', NULL, NULL, 'برغون', 0),
(2182, 13, 'Barsa', NULL, NULL, 'برصا', 0),
(2183, 13, 'Batroumine', NULL, NULL, 'بترومين', 0),
(2184, 13, 'Bdeihoun', NULL, NULL, 'بدبهون', 0),
(2185, 13, 'Bdibba', NULL, NULL, 'بدبا', 0),
(2186, 13, 'Bechmizzine', NULL, NULL, 'بشمزين', 0),
(2187, 13, 'Bednayel el koura', NULL, NULL, 'بدنايل الكورة', 0),
(2188, 13, 'Bkeftine', NULL, NULL, 'بكفتين', 0),
(2189, 13, 'Bnehrane', NULL, NULL, 'بنهران', 0),
(2190, 13, 'Bsarma', NULL, NULL, 'بصرما', 0),
(2191, 13, 'Btaaboura', NULL, NULL, 'بتعبورة', 0),
(2192, 13, 'Btouratij', NULL, NULL, 'بتوراتيج', 0),
(2193, 13, 'Btourram', NULL, NULL, 'بطرام', 0),
(2194, 13, 'Bziza', NULL, NULL, 'بزيزا', 0),
(2195, 13, 'Dahr AlAin', NULL, NULL, 'ضهر العين', 0),
(2196, 13, 'Dar Baachtar', NULL, NULL, 'دار بعشتار', 0),
(2197, 13, 'Dar Chmizzine', NULL, NULL, 'دار شمزين', 0),
(2198, 13, 'Dedde', NULL, NULL, 'دده', 0),
(2199, 13, 'El Aaqbe', NULL, NULL, 'عقبة', 0),
(2200, 13, 'El Bahsas', NULL, NULL, 'بحصاص', 0),
(2201, 13, 'El Bqaiaa', NULL, NULL, 'البقيعة', 0),
(2202, 13, 'En Nakhle', NULL, NULL, 'نخلة', 0),
(2203, 13, 'Enfe', NULL, NULL, 'أنفه', 0),
(2204, 13, 'Fiaa', NULL, NULL, 'فيع', 0),
(2205, 13, 'Haret El KHASSEH', NULL, NULL, 'حارة الخسة', 0),
(2206, 13, 'Ijdabrine', NULL, NULL, 'اجدعبرين', 0),
(2207, 13, 'Jdeideh Berkacha', NULL, NULL, 'جديدة برقاشا', 0),
(2208, 13, 'Kaftoun', NULL, NULL, 'كفتون', 0),
(2209, 13, 'Kefraiya', NULL, NULL, 'كفريا الكورة', 0),
(2210, 13, 'Kfar Aaqqa', NULL, NULL, 'كفر عقا', 0),
(2211, 13, 'Kfar Hata', NULL, NULL, 'كفرحاتا', 0),
(2212, 13, 'Kfar Hazir', NULL, NULL, 'كفرحزير', 0),
(2213, 13, 'Kfar Qahel', NULL, NULL, 'كفرقاهل', 0),
(2214, 13, 'Kfar Saroun', NULL, NULL, 'كفرصارون', 0),
(2215, 13, 'Kousba', NULL, NULL, 'كوسبا', 0),
(2216, 13, 'Majdel el Koura', NULL, NULL, 'مجدل الكورة', 0),
(2217, 13, 'Metrit', NULL, NULL, 'متريت', 0),
(2218, 13, 'Oueta Fares', NULL, NULL, 'وطى فارس', 0),
(2219, 13, 'Qalhat', NULL, NULL, 'قلحات', 0),
(2220, 13, 'Ras Maska', NULL, NULL, 'راس مسقا', 0),
(2221, 13, 'Ras Masqa Ech Chmaliye', NULL, NULL, 'راس مسقا الشمالية', 0),
(2222, 13, 'Ras Masqa Ej Jnoubiye', NULL, NULL, 'راس مسقا الجنوبية', 0),
(2223, 13, 'Rechdibbine', NULL, NULL, 'رشدبين', 0),
(2224, 13, 'Zakroun', NULL, NULL, 'زكرون', 0),
(2225, 13, 'Zakzouk', NULL, NULL, 'زكزوك', 0),
(2226, 13, 'Zgharta el Mtaouleh', NULL, NULL, 'زغرتا المتاولة', 0),
(2227, 15, 'MAZRAAT KETRANE', NULL, NULL, 'مزرعة كتران', 0),
(2228, 15, 'Aadoui', NULL, NULL, 'عدوة', 0),
(2229, 15, 'Aassaimout', NULL, NULL, 'عصيموت', 0),
(2230, 15, 'Aassoun', NULL, NULL, 'عاصون', 0),
(2231, 15, 'Abou Hamad', NULL, NULL, 'ابو حمد', 0),
(2232, 15, 'Afqa El Minieh', NULL, NULL, 'افقا المنيه', 0),
(2233, 15, 'Ain es Safsaf', NULL, NULL, 'عين الصفصاف', 0),
(2234, 15, 'Ain Et Tine', NULL, NULL, 'عين التينه المنيه', 0),
(2235, 15, 'Amar', NULL, NULL, 'عيمر', 0),
(2236, 15, 'Azqey', NULL, NULL, 'عزقي', 0),
(2237, 15, 'Baazqoun', NULL, NULL, 'بعزقون', 0),
(2238, 15, 'Bahsa', NULL, NULL, 'البحصة', 0),
(2239, 15, 'Bakhaoun', NULL, NULL, 'بخعون', 0),
(2240, 15, 'Bchennata', NULL, NULL, 'بشناتا', 0),
(2241, 15, 'Bechhara', NULL, NULL, 'بشحارة', 0),
(2242, 15, 'Bechtayel', NULL, NULL, 'بشتايل', 0),
(2243, 15, 'Behouaita', NULL, NULL, 'بحويتا', 0),
(2244, 15, 'Beit Bakkour', NULL, NULL, 'بيت بكور', 0),
(2245, 15, 'Beit Daoud Izal', NULL, NULL, 'بيت داوود عزال', 0),
(2246, 15, 'Beit El Faqs', NULL, NULL, 'بيت الفقس', 0),
(2247, 15, 'Beit Haouik', NULL, NULL, 'بيت حاويك', 0),
(2248, 15, 'Beit Hasna', NULL, NULL, 'بيت حسنة', 0),
(2249, 15, 'Beit jida', NULL, NULL, 'بيت جدا', 0),
(2250, 15, 'Beit Kanj', NULL, NULL, 'بيت كنج', 0),
(2251, 15, 'Beit Moumne', NULL, NULL, 'بيت مومنة', 0),
(2252, 15, 'Beit Radouane', NULL, NULL, 'بيت رضوان', 0),
(2253, 15, 'Beit Zoud', NULL, NULL, 'بيت زود', 0),
(2254, 15, 'Bhannine El Minieh', NULL, NULL, 'بحنين المنيه', 0),
(2255, 15, 'Borj El Yahoudiye', NULL, NULL, 'برج اليهودية', 0),
(2256, 15, 'Bqaa Safrin', NULL, NULL, 'بقاع صفرين', 0),
(2257, 15, 'Bqarsouna', NULL, NULL, 'بقرصونه', 0),
(2258, 15, 'Btahline', NULL, NULL, 'بتحلين', 0),
(2259, 15, 'Btellaiye', NULL, NULL, 'بتلايه', 0),
(2260, 15, 'Btermaz', NULL, NULL, 'بطرماز', 0),
(2261, 15, 'Chmis', NULL, NULL, 'الشميس', 0),
(2262, 15, 'Dairaiya', NULL, NULL, 'داريا المنيه', 0),
(2263, 15, 'Debaal El Minieh', NULL, NULL, 'دبعل المنيه', 0),
(2264, 15, 'Deir Amar', NULL, NULL, 'دير عمار', 0),
(2265, 15, 'Deir Nbouh', NULL, NULL, 'دير نبوح', 0),
(2266, 15, 'Ech Chalout', NULL, NULL, 'شالوط', 0),
(2267, 15, 'El Beddaoui', NULL, NULL, 'بداوي', 0),
(2268, 15, 'El Hazmiye', NULL, NULL, 'حازمية المنيه', 0),
(2269, 15, 'El Kharnoub', NULL, NULL, 'خرنوب المنيه', 0),
(2270, 15, 'El Medine ej jdide', NULL, NULL, 'مدينة الجديدة', 0),
(2271, 15, 'El Minie', NULL, NULL, 'المنيه', 0),
(2272, 15, 'En Nabi Kzaiber', NULL, NULL, 'النبي كزيبر', 0),
(2273, 15, 'En Nabi Youchaa', NULL, NULL, 'النبي يوشع', 0),
(2274, 15, 'Er Rihaniye El Minieh', NULL, NULL, 'ريحانيه المنيه', 0),
(2275, 15, 'Es Snoubar', NULL, NULL, 'صنوبر', 0),
(2276, 15, 'Haoura', NULL, NULL, 'حوارة', 0),
(2277, 15, 'Haql El Aazime', NULL, NULL, 'حقل العزيمة', 0),
(2278, 15, 'Haqlit', NULL, NULL, 'حقلة', 0),
(2279, 15, 'Harf es siyad', NULL, NULL, 'حرف السياد', 0),
(2280, 15, 'Izal', NULL, NULL, 'إيزال', 0),
(2281, 15, 'Jairoun', NULL, NULL, 'جيرون', 0),
(2282, 15, 'Jarjour', NULL, NULL, 'جرجور', 0),
(2283, 15, 'Kahf El - Malloul', NULL, NULL, 'كفَ الملول', 0),
(2284, 15, 'Karm El - Mohr', NULL, NULL, 'كرم المهر', 0),
(2285, 15, 'Karm El Akhras', NULL, NULL, 'كرم الاخرس', 0),
(2286, 15, 'Kfar Bebnine', NULL, NULL, 'كفر ببنين', 0),
(2287, 15, 'Kfar Chillane', NULL, NULL, 'كفر شلان', 0),
(2288, 15, 'Kfar Habou', NULL, NULL, 'كفر حبو', 0),
(2289, 15, 'Kharnoub', NULL, NULL, 'خرنوب', 0),
(2290, 15, 'Maassarati', NULL, NULL, 'معصراتي', 0),
(2291, 15, 'Markabta', NULL, NULL, 'مركبتا', 0),
(2292, 15, 'Mazraat Aartoussi', NULL, NULL, 'مزرعة عرطوسي', 0),
(2293, 15, 'MAZRAAT EL KREYM', NULL, NULL, 'مزرعة الكريم', 0),
(2294, 15, 'Mgharet ech Cheikh', NULL, NULL, 'مغارة الشيخ', 0),
(2295, 15, 'Moulid', NULL, NULL, 'موليد', 0),
(2296, 15, 'Mrah Es Sfire', NULL, NULL, 'مراح السفيرة', 0),
(2297, 15, 'Mrah Es Sreij', NULL, NULL, 'مراح السريج', 0),
(2298, 15, 'Mrebbine', NULL, NULL, 'مربين', 0),
(2299, 15, 'Nemrine', NULL, NULL, 'نمرين', 0),
(2300, 15, 'Ouadi En Nahle', NULL, NULL, 'وادي النحلة', 0),
(2301, 15, 'Ouatiye', NULL, NULL, 'واطيه', 0),
(2302, 15, 'Qarhaiya', NULL, NULL, 'قرحيا', 0),
(2303, 15, 'Qarn', NULL, NULL, 'القرن', 0),
(2304, 15, 'Qarsita', NULL, NULL, 'قرصيتا', 0),
(2305, 15, 'Qattine El Minieh', NULL, NULL, 'القطين المنيه', 0),
(2306, 15, 'Qemmamine', NULL, NULL, 'قمامين', 0),
(2307, 15, 'Qraine', NULL, NULL, 'قرين', 0),
(2308, 15, 'Raouda', NULL, NULL, 'روضه المنيه', 0),
(2309, 15, 'Sertouka', NULL, NULL, 'سرتوكا', 0),
(2310, 15, 'Sfire', NULL, NULL, 'سفيرة', 0),
(2311, 15, 'Sir Ed Danniye', NULL, NULL, 'سير الضنية', 0),
(2312, 15, 'Souaqi', NULL, NULL, 'السواقي', 0),
(2313, 15, 'Tarane', NULL, NULL, 'طاران', 0),
(2314, 15, 'Terbol El Minieh', NULL, NULL, 'تربل المنيه', 0),
(2315, 15, 'Wadi en Njass', NULL, NULL, 'وادي النجاص', 0),
(2316, 15, 'Zghartighrine', NULL, NULL, 'زغرتغرين', 0),
(2317, 15, 'Zouq Bhannine', NULL, NULL, 'ذوق بحنين', 0),
(2318, 25, 'Abou Samra', NULL, NULL, 'ابو سمرا', 0),
(2319, 25, 'Bab Al Ramel', NULL, NULL, 'باب الرمل', 0),
(2320, 25, 'Bahsas', NULL, NULL, 'البحصاص', 0),
(2321, 25, 'Dam Wal Farz', NULL, NULL, 'الضم و الفرز', 0),
(2322, 25, 'Ed Debbagha', NULL, NULL, 'الدباغة', 0),
(2323, 25, 'El Maloula', NULL, NULL, 'الملولة', 0),
(2324, 25, 'El Mina', NULL, NULL, 'المينا', 0),
(2325, 25, 'Hadid', NULL, NULL, 'الحديد', 0),
(2326, 25, 'Hdadine', NULL, NULL, 'الحدادين', 0),
(2327, 25, 'Jessrine', NULL, NULL, 'جسرين', 0),
(2328, 25, 'Mankoubin', NULL, NULL, 'منكوبين', 0),
(2329, 25, 'Mhatreh', NULL, NULL, 'المهاترة', 0),
(2330, 25, 'MINA 1', NULL, NULL, 'مينا طرابلس 1', 0),
(2331, 25, 'MINA 2', NULL, NULL, 'مينا طرابلس 2', 0),
(2332, 25, 'Mina Jardin', NULL, NULL, 'بساتين المينا', 0),
(2333, 25, 'Noury', NULL, NULL, 'النوري', 0),
(2334, 25, 'Qalamoun', NULL, NULL, 'القلمون', 0),
(2335, 25, 'Qoubbe', NULL, NULL, 'القبة', 0),
(2336, 25, 'Rammanet', NULL, NULL, 'الرمانة', 0),
(2337, 25, 'Shok', NULL, NULL, 'شق', 0),
(2338, 25, 'Souayqa', NULL, NULL, 'السويقة', 0),
(2339, 25, 'Tabbaneh', NULL, NULL, 'التبانة', 0),
(2340, 25, 'Tal', NULL, NULL, 'التل', 0),
(2341, 25, 'Trablous Jardins', NULL, NULL, 'بساتين طرابلس', 0),
(2342, 25, 'Trablous Zeitoun', NULL, NULL, 'طرابلس الزيتون', 0),
(2343, 25, 'Tripoli', NULL, NULL, 'طرابلس', 0),
(2344, 25, 'Zahrieh', NULL, NULL, 'الزاهرية', 0),
(2345, 28, 'IAAL', NULL, NULL, 'إيعال', 0),
(2346, 28, 'Aachach', NULL, NULL, 'عشاش', 0),
(2347, 28, 'Aalma', NULL, NULL, 'علما', 0),
(2348, 28, 'Aaqbet Sibaal', NULL, NULL, 'عقبة سبعل', 0),
(2349, 28, 'Aarbet Qozhaiya', NULL, NULL, 'عربة قزحيا', 0),
(2350, 28, 'Aardat', NULL, NULL, 'عردات', 0),
(2351, 28, 'Aarjess', NULL, NULL, 'عرجس', 0),
(2352, 28, 'Ain Tourine', NULL, NULL, 'عينطورين', 0),
(2353, 28, 'Aitou', NULL, NULL, 'أيطو', 0),
(2354, 28, 'Al Aaqbe', NULL, NULL, 'عقبة علما', 0),
(2355, 28, 'Arde', NULL, NULL, 'أرده', 0),
(2356, 28, 'Aslout', NULL, NULL, 'اسلوت', 0),
(2357, 28, 'Asnoun', NULL, NULL, 'اصنون', 0),
(2358, 28, 'Baslouqit', NULL, NULL, 'بسلوقيت', 0),
(2359, 28, 'Bayader Rachaaine', NULL, NULL, 'بيادر رشعين', 0),
(2360, 28, 'Bchama', NULL, NULL, 'بشاما', 0),
(2361, 28, 'Bchannine', NULL, NULL, 'بشنين', 0),
(2362, 28, 'Beit Aabeid', NULL, NULL, 'بيت عبيد', 0),
(2363, 28, 'Beit Aaoukar', NULL, NULL, 'بيت عوكر', 0),
(2364, 28, 'Beit Barakat', NULL, NULL, 'بيت بركات', 0),
(2365, 28, 'Beit el Hraqsa', NULL, NULL, 'بيت الحرقصى', 0),
(2366, 28, 'Beit Knaty', NULL, NULL, 'بيت قناطي', 0),
(2367, 28, 'Bnechaai', NULL, NULL, 'بنشعي', 0),
(2368, 28, 'Bouhairet Toula', NULL, NULL, 'بحيرة تولا', 0),
(2369, 28, 'Bousit', NULL, NULL, 'بوسيط', 0),
(2370, 28, 'Bsebaal', NULL, NULL, 'بسبعل', 0),
(2371, 28, 'Danha', NULL, NULL, 'دنها', 0),
(2372, 28, 'Darayia', NULL, NULL, 'داريا', 0),
(2373, 28, 'Ehden', NULL, NULL, 'اهدن', 0),
(2374, 28, 'Ejbeaa', NULL, NULL, 'اجبع', 0),
(2375, 28, 'El Hariq', NULL, NULL, 'حريق', 0),
(2376, 28, 'El Houakir', NULL, NULL, 'حواكير', 0),
(2377, 28, 'El Khaldiye', NULL, NULL, 'خالدية', 0),
(2378, 28, 'El Qadriye', NULL, NULL, 'قادريه', 0),
(2379, 28, 'Er Rmaile', NULL, NULL, 'رميله أرده', 0),
(2380, 28, 'Et Talle', NULL, NULL, 'تلة زغرتا', 0),
(2381, 28, 'Fouwar zgharta', NULL, NULL, 'فوار زغرتا', 0),
(2382, 28, 'Fradis', NULL, NULL, 'الفراديس', 0),
(2383, 28, 'Haouqa Et En Naher', NULL, NULL, 'حوقا النهر', 0),
(2384, 28, 'Haret al Fouwar', NULL, NULL, 'حارة الفوار', 0),
(2385, 28, 'Haret Ej Jdide Zgharta', NULL, NULL, 'حارة الجديدة زغرتا', 0),
(2386, 28, 'Haret el Baklik', NULL, NULL, 'حارة البكليك', 0),
(2387, 28, 'Harfe Arde', NULL, NULL, 'حرف أرده', 0),
(2388, 28, 'Hariq Zgharta', NULL, NULL, 'حريق زغرتا', 0),
(2389, 28, 'Harsoun Ej Jdide', NULL, NULL, 'حصرون الجديدة', 0),
(2390, 28, 'Hilane zgharta', NULL, NULL, 'حيلان زغرتا', 0),
(2391, 28, 'Hmais zgharta', NULL, NULL, 'حميص', 0),
(2392, 28, 'Hraykess', NULL, NULL, 'حريقص', 0),
(2393, 28, 'Jdeide zgharta', NULL, NULL, 'الجديدة زغرتا', 0),
(2394, 28, 'Kaabouch', NULL, NULL, 'كبوش', 0),
(2395, 28, 'Kafar Zeina', NULL, NULL, 'كفر زينا', 0),
(2396, 28, 'Kafraiya zgharta', NULL, NULL, 'كفريا زغرتا', 0),
(2397, 28, 'Karbribe', NULL, NULL, 'كربريب', 0),
(2398, 28, 'Karm Sadde', NULL, NULL, 'كرم سده', 0),
(2399, 28, 'Kfar Chakhna', NULL, NULL, 'كفر شخنا', 0),
(2400, 28, 'Kfar Dlaqous', NULL, NULL, 'كفردلاقوس', 0),
(2401, 28, 'Kfar Fou', NULL, NULL, 'كفر فو', 0),
(2402, 28, 'Kfar Haoura', NULL, NULL, 'كفر حورا', 0),
(2403, 28, 'Kfar Hata', NULL, NULL, 'كفر حاتا', 0),
(2404, 28, 'Kfar Sghab', NULL, NULL, 'كفر صغاب', 0),
(2405, 28, 'Kfar Yachit', NULL, NULL, 'كفر ياشيت', 0),
(2406, 28, 'Majdalaya zgharta', NULL, NULL, 'مجدليا زغرتا', 0),
(2407, 28, 'Mar Semaane', NULL, NULL, 'مار سمعان', 0),
(2408, 28, 'Mazraat Ejbeh', NULL, NULL, 'مزرعة إجبع', 0),
(2409, 28, 'Mazraat Et Toufah', NULL, NULL, 'مزرعة التفاح', 0),
(2410, 28, 'Mazraat Hraqs', NULL, NULL, 'مزرعة حريقص', 0),
(2411, 28, 'Mazraat Jnaid', NULL, NULL, 'مزرعة جنيد', 0),
(2412, 28, 'Mazret al Nahr', NULL, NULL, 'مزرعة النهر', 0),
(2413, 28, 'Miryata', NULL, NULL, 'مرياطا', 0),
(2414, 28, 'Miziara', NULL, NULL, 'مزيارة', 0),
(2415, 28, 'Qarah Bach', NULL, NULL, 'قره باش', 0),
(2416, 28, 'Qareit Sakhra', NULL, NULL, 'قرعية صخرا', 0),
(2417, 28, 'Rachaaine', NULL, NULL, 'رشعين', 0),
(2418, 28, 'Raskifa', NULL, NULL, 'راس كيفا', 0),
(2419, 28, 'Sahl Danha', NULL, NULL, 'سهل دنها', 0),
(2420, 28, 'Sakhra', NULL, NULL, 'صخرة', 0),
(2421, 28, 'Sanaallah', NULL, NULL, 'صنع الله', 0),
(2422, 28, 'Sebaal', NULL, NULL, 'سبعل زغرتا', 0),
(2423, 28, 'Seraal', NULL, NULL, 'سرعيل', 0),
(2424, 28, 'Toula zgharta', NULL, NULL, 'تولا زغرتا', 0),
(2425, 28, 'Zgharta', NULL, NULL, 'زغرتا', 0),
(2426, 19, 'Aadour', NULL, NULL, 'عاضور', 0),
(2427, 19, 'Aaichiye', NULL, NULL, 'عيشية', 0),
(2428, 19, 'Aaqmata', NULL, NULL, 'عقماتا', 0),
(2429, 19, 'Aaramta', NULL, NULL, 'عرمتى', 0),
(2430, 19, 'Aariye', NULL, NULL, 'عاريه', 0),
(2431, 19, 'Aarqoub', NULL, NULL, 'العرقوب', 0),
(2432, 19, 'Aazour', NULL, NULL, 'عازور', 0),
(2433, 19, 'Ain el Mir el Estabel', NULL, NULL, 'عين المير إسطبل', 0),
(2434, 19, 'Ain et Taghra', NULL, NULL, 'عين التغرى', 0),
(2435, 19, 'Ain Majdalain', NULL, NULL, 'عين مجدلين', 0),
(2436, 19, 'Anane', NULL, NULL, 'أنان', 0),
(2437, 19, 'Azibeh', NULL, NULL, 'عزيبة', 0),
(2438, 19, 'Baanoub', NULL, NULL, 'بعانوب', 0),
(2439, 19, 'Baba', NULL, NULL, 'بيبه', 0),
(2440, 19, 'Baissour Jezzine', NULL, NULL, 'بيصور جزين', 0),
(2441, 19, 'Benouati', NULL, NULL, 'بنواتي جزين', 0),
(2442, 19, 'Bhannine', NULL, NULL, 'بحنين', 0),
(2443, 19, 'Bisri', NULL, NULL, 'بسري', 0),
(2444, 19, 'Biyad', NULL, NULL, 'البياض', 0),
(2445, 19, 'Bkassine', NULL, NULL, 'بكاسين', 0),
(2446, 19, 'Bouslaya', NULL, NULL, 'بوصلايا', 0),
(2447, 19, 'Bteddine el Loqch', NULL, NULL, 'بتدين اللقش', 0),
(2448, 19, 'Chamkha', NULL, NULL, 'شامخة', 0),
(2449, 19, 'Chbeil', NULL, NULL, 'شبيل', 0),
(2450, 19, 'Choualiq', NULL, NULL, 'شواليق جزين', 0),
(2451, 19, 'Dahr ed Deir', NULL, NULL, 'ضهر الدير', 0),
(2452, 19, 'Dahr er Ramle', NULL, NULL, 'ضهر الرملة', 0),
(2453, 19, 'Darayia Jezzine', NULL, NULL, 'داريا جزين', 0),
(2454, 19, 'Deir Chkedif', NULL, NULL, 'شقاديف', 0),
(2455, 19, 'Deir El Qattine', NULL, NULL, 'دير قطِين', 0),
(2456, 19, 'Deir Machmouche', NULL, NULL, 'دير مشموشه', 0),
(2457, 19, 'Deir Moukhalles', NULL, NULL, 'دير المخلص', 0),
(2458, 19, 'Dimechqiye', NULL, NULL, 'دمشقية', 0),
(2459, 19, 'El Harf Jezzine', NULL, NULL, 'الحرف جزين', 0),
(2460, 19, 'El Houraniye', NULL, NULL, 'حورانية', 0),
(2461, 19, 'El Msous', NULL, NULL, 'مصوص', 0),
(2462, 19, 'El Qabaa', NULL, NULL, 'قبع', 0),
(2463, 19, 'Ghbatiye', NULL, NULL, 'غبَاطية', 0),
(2464, 19, 'Haidab', NULL, NULL, 'حيداب', 0),
(2465, 19, 'Haitoule', NULL, NULL, 'حيتوله', 0),
(2466, 19, 'Haitoura', NULL, NULL, 'حيطورة', 0),
(2467, 19, 'Haret el Bayder', NULL, NULL, 'حارة البيادر', 0),
(2468, 19, 'Harf', NULL, NULL, 'الحرف', 0),
(2469, 19, 'Hassaniye', NULL, NULL, 'حسانية', 0),
(2470, 19, 'Homsiye', NULL, NULL, 'حمصية', 0),
(2471, 19, 'Jabal Toura', NULL, NULL, 'جبل طوره', 0),
(2472, 19, 'Jall Nachi', NULL, NULL, 'جل ناشي', 0),
(2473, 19, 'Jarmaq', NULL, NULL, 'الجرمق', 0),
(2474, 19, 'Jdaidet el Ouadi', NULL, NULL, 'الجديدة وادي جزين', 0),
(2475, 19, 'Jensnaya', NULL, NULL, 'جنسنايا', 0),
(2476, 19, 'Jernaya', NULL, NULL, 'جرنايا', 0),
(2477, 19, 'Jezzine', NULL, NULL, 'جزين', 0),
(2478, 19, 'Karkha', NULL, NULL, 'كرخا', 0),
(2479, 19, 'Kfar Falous', NULL, NULL, 'كفرفالوس', 0),
(2480, 19, 'Kfar Houne', NULL, NULL, 'كفرحون', 0),
(2481, 19, 'Kfar Jarra', NULL, NULL, 'كفرجرا', 0),
(2482, 19, 'Kfar Taala', NULL, NULL, 'كفرتعلا', 0),
(2483, 19, 'Khallet Khazen', NULL, NULL, 'خلة خازن', 0),
(2484, 19, 'Khirkhaya', NULL, NULL, 'خرخيا', 0),
(2485, 19, 'Lebaa', NULL, NULL, 'لبعا', 0),
(2486, 19, 'Louaiziye', NULL, NULL, 'لويزة جزين', 0),
(2487, 19, 'Maarous el Branieh', NULL, NULL, 'ماروس البرانية', 0),
(2488, 19, 'Maarous el Jouanieh', NULL, NULL, 'ماروس الجوانية', 0),
(2489, 19, 'Machmouche', NULL, NULL, 'مشموشة', 0),
(2490, 19, 'Mahmoudiye Jezzine', NULL, NULL, 'محمودية جزين', 0),
(2491, 19, 'Maknouniye', NULL, NULL, 'مكنونية', 0),
(2492, 19, 'Mazraat Aarqoub', NULL, NULL, 'مزرعة العرقوب', 0),
(2493, 19, 'Mazraat Jabal Toura', NULL, NULL, 'مزرعة جبل طوره', 0),
(2494, 19, 'Mazraat Tamra', NULL, NULL, 'مزرعة طمره', 0),
(2495, 19, 'Mazraat Aaqmata', NULL, NULL, 'مزرعة عقماتا', 0),
(2496, 19, 'Mazraat Aaraji', NULL, NULL, 'مزرعة عراجي', 0),
(2497, 19, 'Mazraat Al Souairi', NULL, NULL, 'مزرعة الصويري', 0),
(2498, 19, 'Mazraat el Btadiniye', NULL, NULL, 'مزرعة البتدينية', 0),
(2499, 19, 'Mazraat el Khaoukh', NULL, NULL, 'مزرعة الخوخ', 0),
(2500, 19, 'Mazraat el Mathane', NULL, NULL, 'مزرعة المطحنة', 0),
(2501, 19, 'Mazraat er Rohbane', NULL, NULL, 'مزرعة الرهبان', 0),
(2502, 19, 'Mazraat Louzyde', NULL, NULL, 'مزرعة لوزيد', 0),
(2503, 19, 'Mharbiye', NULL, NULL, 'محاربية', 0),
(2504, 19, 'Midane', NULL, NULL, 'ميدان', 0),
(2505, 19, 'Mjaydel', NULL, NULL, 'مجيدل', 0),
(2506, 19, 'Mlikh', NULL, NULL, 'مليخ', 0),
(2507, 19, 'Mrah Abdu Chedid', NULL, NULL, 'مراح أبو شديد', 0),
(2508, 19, 'Mrah El Hbas', NULL, NULL, 'مراح الحباس', 0),
(2509, 19, 'Mrah Mghaibe', NULL, NULL, 'مراح مغبيه', 0),
(2510, 19, 'Mzairaa', NULL, NULL, 'مزيرعة', 0),
(2511, 19, 'Nabaa', NULL, NULL, 'نبعه', 0),
(2512, 19, 'Nabi Sejoud', NULL, NULL, 'نبي سجد', 0),
(2513, 19, 'Ouadi Baanqoudine', NULL, NULL, 'وادي بعنقودين', 0),
(2514, 19, 'Ouadi el Leimoun', NULL, NULL, 'وادي الليمون', 0),
(2515, 19, 'Ouardiye', NULL, NULL, 'وردية', 0),
(2516, 19, 'Ouazaaiye', NULL, NULL, 'اوزاعية', 0),
(2517, 19, 'Qaitoule', NULL, NULL, 'قيتولي', 0),
(2518, 19, 'Qotrani', NULL, NULL, 'قطراني', 0),
(2519, 19, 'Qrouh', NULL, NULL, 'قروح', 0),
(2520, 19, 'Qtale Jezzine', NULL, NULL, 'قتالة جزين', 0),
(2521, 19, 'Raimat', NULL, NULL, 'ريمات', 0),
(2522, 19, 'Rihane Jezzine', NULL, NULL, 'ريحانة جزين', 0),
(2523, 19, 'Roum', NULL, NULL, 'روم', 0),
(2524, 19, 'Roummane Jezzine', NULL, NULL, 'رمانة', 0),
(2525, 19, 'Rous El Franj', NULL, NULL, 'راس الوادي الحوة', 0),
(2526, 19, 'Sabah', NULL, NULL, 'صّباح', 0),
(2527, 19, 'Salima', NULL, NULL, 'صليما', 0),
(2528, 19, 'Sejoud', NULL, NULL, 'سجد', 0),
(2529, 19, 'Sfarai', NULL, NULL, 'صفاريه', 0),
(2530, 19, 'Sidoun', NULL, NULL, 'صيدون', 0),
(2531, 19, 'Sniye', NULL, NULL, 'سنيَا', 0),
(2532, 19, 'Sriri', NULL, NULL, 'سريرة', 0),
(2533, 19, 'Taaid', NULL, NULL, 'تعيد', 0),
(2534, 19, 'Tamra', NULL, NULL, 'طمره', 0),
(2535, 19, 'Wadi Jezzine', NULL, NULL, 'وادي جزين', 0),
(2536, 19, 'Zaghrine Jezzine', NULL, NULL, 'زغرين جزين', 0),
(2537, 19, 'Zhalta', NULL, NULL, 'زحلتا', 0),
(2538, 23, 'Aabra', NULL, NULL, 'عبرا', 0),
(2539, 23, 'Aaddoussiye', NULL, NULL, 'عدّوسية', 0),
(2540, 23, 'Aadloun', NULL, NULL, 'عدلون', 0),
(2541, 23, 'Aanqoun', NULL, NULL, 'عنقون', 0),
(2542, 23, 'Aaqbiye', NULL, NULL, 'العاقبية', 0),
(2543, 23, 'Aaqtanit', NULL, NULL, 'عقتنيت', 0),
(2544, 23, 'Aarnaba', NULL, NULL, 'عرنابة', 0),
(2545, 23, 'Abou el Assouad', NULL, NULL, 'ابو الاسود', 0),
(2546, 23, 'Ain Ed Delb', NULL, NULL, 'عين الدلب', 0),
(2547, 23, 'Ain el Hiloue', NULL, NULL, 'عين الحلوة', 0),
(2548, 23, 'Arkey', NULL, NULL, 'اركي', 0),
(2549, 23, 'Arzay', NULL, NULL, 'أرزي', 0),
(2550, 23, 'Babliye', NULL, NULL, 'بابلية', 0),
(2551, 23, 'Barti', NULL, NULL, 'برتي', 0),
(2552, 23, 'Bissariyeh', NULL, NULL, 'بيسارية', 0),
(2553, 23, 'Bnaafoul', NULL, NULL, 'بنعفول', 0),
(2554, 23, 'Bqosta', NULL, NULL, 'بقسطا', 0),
(2555, 23, 'Brak et Tall', NULL, NULL, 'براك التل', 0),
(2556, 23, 'Bramiye', NULL, NULL, 'برامية', 0),
(2557, 23, 'Daoudiye', NULL, NULL, 'الداودية', 0),
(2558, 23, 'Darb es Sim', NULL, NULL, 'درب السيم', 0),
(2559, 23, 'Deir Taqla', NULL, NULL, 'دير تقلا', 0),
(2560, 23, 'Dekerman', NULL, NULL, 'الدكرمان', 0),
(2561, 23, 'Dhour Darb es Sim', NULL, NULL, 'ضهور درب السيم', 0),
(2562, 23, 'El Achrafiye', NULL, NULL, 'أشرفية المية ومية', 0),
(2563, 23, 'El Mahmoudiye', NULL, NULL, 'محمودية', 0),
(2564, 23, 'Er Rouayess', NULL, NULL, 'روايس', 0),
(2565, 23, 'Ez Zahrani', NULL, NULL, 'الزهراني', 0),
(2566, 23, 'Ghassaniye', NULL, NULL, 'غسانية', 0),
(2567, 23, 'Ghaziye', NULL, NULL, 'غازية', 0),
(2568, 23, 'Hababiye', NULL, NULL, 'حبابية', 0),
(2569, 23, 'Hajje', NULL, NULL, 'حجة', 0),
(2570, 23, 'Haret Saida', NULL, NULL, 'حارة صيدا', 0),
(2571, 23, 'Hartai', NULL, NULL, 'حارتية', 0),
(2572, 23, 'Hlaliye Saida', NULL, NULL, 'هلالية صيدا', 0),
(2573, 23, 'Insariye', NULL, NULL, 'إنصارية', 0),
(2574, 23, 'Jazire', NULL, NULL, 'جزيرة صيدا', 0),
(2575, 23, 'Jdaide Arzai', NULL, NULL, 'جديدة أرزي', 0),
(2576, 23, 'Jinjlaya', NULL, NULL, 'جنجلاية', 0),
(2577, 23, 'Kafraiya', NULL, NULL, 'كفريا', 0),
(2578, 23, 'Kaouthariyet es Siyad', NULL, NULL, 'كوثرية السياد', 0),
(2579, 23, 'Kfar Badde', NULL, NULL, 'كفر بدَه', 0),
(2580, 23, 'Kfar Beit', NULL, NULL, 'كفربيت', 0),
(2581, 23, 'Kfar Chellal', NULL, NULL, 'كفر شلال', 0),
(2582, 23, 'Kfar Hatta', NULL, NULL, 'كفرحتى', 0),
(2583, 23, 'Kfar Melki Saida', NULL, NULL, 'كفرملكي صيدا', 0),
(2584, 23, 'Khannoussiye', NULL, NULL, 'خنوسية', 0),
(2585, 23, 'Kharayeb Saida', NULL, NULL, 'الخرائب صيدا', 0),
(2586, 23, 'Khartoum', NULL, NULL, 'خرطوم', 0),
(2587, 23, 'Khaziz', NULL, NULL, 'خزيز', 0),
(2588, 23, 'Khirbet Ain el Qanater', NULL, NULL, 'خربة عين القناطر', 0),
(2589, 23, 'Khirbet Bassal', NULL, NULL, 'خربة البصل', 0),
(2590, 23, 'Khirbet ed Daoueir', NULL, NULL, 'خربة الدوير صيدا', 0),
(2591, 23, 'Loubiye', NULL, NULL, 'لوبية', 0),
(2592, 23, 'Maamriye', NULL, NULL, 'معمارية', 0),
(2593, 23, 'Maamriyet el Kharab', NULL, NULL, 'معمرية الخراب', 0),
(2594, 23, 'Maghdouche', NULL, NULL, 'مغدوشة', 0),
(2595, 23, 'Majdelyoun', NULL, NULL, 'مجدليون', 0),
(2596, 23, 'Maqsam El JAOUHARI', NULL, NULL, 'مقسم الجوهري', 0),
(2597, 23, 'Matariyet ech Choumar', NULL, NULL, 'مطرية الشومر', 0),
(2598, 23, 'Mazraat Aabboudiye', NULL, NULL, 'مزرعة العبودية', 0),
(2599, 23, 'Mazraat Aarab ej Jall', NULL, NULL, 'مزرعة عرب الجل', 0),
(2600, 23, 'Mazraat Ain el Qantara', NULL, NULL, 'مزرعة عين القنطرة', 0),
(2601, 23, 'Mazraat Arab Soukkar', NULL, NULL, 'مزرعة عرب سكر', 0),
(2602, 23, 'Mazraat Arab Tobbaya', NULL, NULL, 'مزرعة عرب طبَايا', 0),
(2603, 23, 'Mazraat ej Joudaye', NULL, NULL, 'مزرعة الجودية', 0),
(2604, 23, 'Mazraat el Aite Niye', NULL, NULL, 'مزرعة العيتانية', 0),
(2605, 23, 'Mazraat el Daoudiye', NULL, NULL, 'مزرعة الداودية', 0),
(2606, 23, 'Mazraat el Hsainiye', NULL, NULL, 'مزرعة الحسينية', 0),
(2607, 23, 'Mazraat el Ouasta', NULL, NULL, 'مزرعة الواسطة', 0),
(2608, 23, 'Mazraat el Yahoudiye', NULL, NULL, 'مزرعة اليهودية', 0),
(2609, 23, 'Mazraat Iskandarouna', NULL, NULL, 'مزرعة إسكندرونة', 0),
(2610, 23, 'Mazraat Jemjim', NULL, NULL, 'مزرعة جمجيم', 0),
(2611, 23, 'Mazraat Khaizarane', NULL, NULL, 'مزرعة خيزران', 0),
(2612, 23, 'Mazraat Khoutaryet er Rezz', NULL, NULL, 'مزرعة كوثرية الرز', 0),
(2613, 23, 'Mazraat Matariyet Jbaa', NULL, NULL, 'مزرعة مطيرية جباع', 0),
(2614, 23, 'Mazraat Sekkaniye', NULL, NULL, 'مزرعة السكنية', 0),
(2615, 23, 'Mazraat Sinai', NULL, NULL, 'مزرعة سيناي', 0),
(2616, 23, 'Mazraat Zaita', NULL, NULL, 'مزرعة زيتا', 0),
(2617, 23, 'Merouaniye', NULL, NULL, 'مروانية', 0),
(2618, 23, 'Mghairiye', NULL, NULL, 'مغيرية', 0),
(2619, 23, 'Mhaidle', NULL, NULL, 'المحيدلة', 0),
(2620, 23, 'Miyeh ou Miyeh', NULL, NULL, 'مية ومية', 0),
(2621, 23, 'Mrah Kiouane', NULL, NULL, 'مراح كيوان', 0),
(2622, 23, 'Msaileh', NULL, NULL, 'المصيلح', 0),
(2623, 23, 'Najjaryie', NULL, NULL, 'نجارية', 0),
(2624, 23, 'Oussamiyat', NULL, NULL, 'الاوساميات', 0),
(2625, 23, 'Qaaqaaii es Snoubar', NULL, NULL, 'قعقعية الصنوبر', 0),
(2626, 23, 'Qennarit', NULL, NULL, 'قناريت', 0),
(2627, 23, 'Qiyaa', NULL, NULL, 'قياعة', 0),
(2628, 23, 'Qnaitra', NULL, NULL, 'القنيطرة', 0),
(2629, 23, 'Qraiye Saida', NULL, NULL, 'قرية صيدا', 0),
(2630, 23, 'Saida', NULL, NULL, 'صيدا', 0),
(2631, 23, 'Saida Ed Dekermane', NULL, NULL, 'صيدا الدكرمان', 0),
(2632, 23, 'Saksakiye', NULL, NULL, 'سكسكية', 0),
(2633, 23, 'Salhiye', NULL, NULL, 'صالحية', 0),
(2634, 23, 'Sarafand', NULL, NULL, 'صرفند', 0),
(2635, 23, 'Sari', NULL, NULL, 'ساري', 0),
(2636, 23, 'Sfenti', NULL, NULL, 'سفنتا', 0),
(2637, 23, 'Sinai', NULL, NULL, 'سيناي', 0),
(2638, 23, 'Snaiber', NULL, NULL, 'مزرعة سنيبر', 0),
(2639, 23, 'Tanbourit', NULL, NULL, 'طنبوريت', 0),
(2640, 23, 'Tebna', NULL, NULL, 'تبنا', 0),
(2641, 23, 'Toufahta', NULL, NULL, 'تفاحتا', 0),
(2642, 23, 'Wastani', NULL, NULL, 'الوسطاني', 0),
(2643, 23, 'Zaghdraiya', NULL, NULL, 'زغدرايا', 0),
(2644, 23, 'Zaita', NULL, NULL, 'زيتا', 0),
(2645, 23, 'Zrariye', NULL, NULL, 'زرارية', 0),
(2646, 24, 'Aabbassiye', NULL, NULL, 'عباسية', 0),
(2647, 24, 'Aaitit', NULL, NULL, 'عيتيت', 0),
(2648, 24, 'Aalma ech Chaab', NULL, NULL, 'علما الشعب', 0),
(2649, 24, 'Aamrane', NULL, NULL, 'عمران', 0),
(2650, 24, 'Aazziye', NULL, NULL, 'عزِّيه', 0),
(2651, 24, 'Abou Chach', NULL, NULL, 'أبو شاش', 0),
(2652, 24, 'Ain Abu Aabdalla', NULL, NULL, 'عين أبو عبدالله', 0),
(2653, 24, 'Ain Baal', NULL, NULL, 'عين بعل', 0),
(2654, 24, 'Arzoun', NULL, NULL, 'ارزون', 0),
(2655, 24, 'Bafliye', NULL, NULL, 'بافليه', 0),
(2656, 24, 'Barich', NULL, NULL, 'باريش', 0),
(2657, 24, 'Batouliye', NULL, NULL, 'باتوليه', 0),
(2658, 24, 'Bazouriye', NULL, NULL, 'بازورية', 0),
(2659, 24, 'Bedias', NULL, NULL, 'بدياس', 0),
(2660, 24, 'Bestiyat', NULL, NULL, 'بستيات', 0),
(2661, 24, 'Biyad Sour', NULL, NULL, 'البياض صور', 0),
(2662, 24, 'Borj ech Chmali', NULL, NULL, 'برج الشمالي', 0),
(2663, 24, 'Borj el Haoua', NULL, NULL, 'برج الهوا', 0),
(2664, 24, 'Borj el Qibli', NULL, NULL, 'برج قبلي', 0),
(2665, 24, 'Borj Rahhal', NULL, NULL, 'برج رحال', 0),
(2666, 24, 'Bourghliye', NULL, NULL, 'برغلية', 0),
(2667, 24, 'Boustane Sour', NULL, NULL, 'بستان صور', 0),
(2668, 24, 'Btaichiye', NULL, NULL, 'بطيشية', 0),
(2669, 24, 'Chaaitiyeh', NULL, NULL, 'شعيتية', 0),
(2670, 24, 'Chabriha', NULL, NULL, 'شبريحا', 0),
(2671, 24, 'Chahour', NULL, NULL, 'شحور', 0),
(2672, 24, 'Chamaa', NULL, NULL, 'شمع', 0),
(2673, 24, 'Charnaiye', NULL, NULL, 'شارنية', 0),
(2674, 24, 'Chehabiye', NULL, NULL, 'شهابية', 0),
(2675, 24, 'Chihine', NULL, NULL, 'شيحين', 0),
(2676, 24, 'Debaal', NULL, NULL, 'دبعل', 0),
(2677, 24, 'Deir Aamess', NULL, NULL, 'ديرعامص', 0),
(2678, 24, 'Deir Kifa', NULL, NULL, 'دير كيفا', 0),
(2679, 24, 'Deir Qanoun', NULL, NULL, 'دير قانون', 0),
(2680, 24, 'Deir Qanoun en Nahr', NULL, NULL, 'دير قانون النهر', 0),
(2681, 24, 'Derdghaiya', NULL, NULL, 'دردغايا', 0),
(2682, 24, 'Dhaira', NULL, NULL, 'ظهيرة', 0),
(2683, 24, 'Ech Choumara', NULL, NULL, 'الشومارا', 0),
(2684, 24, 'Ed Dikiye', NULL, NULL, 'الديكية', 0),
(2685, 24, 'El Bass', NULL, NULL, 'البصَ', 0),
(2686, 24, 'El Biyada', NULL, NULL, 'بياضة', 0),
(2687, 24, 'El Borj En-Naqoura', NULL, NULL, 'برج الناقورة', 0),
(2688, 24, 'El Kleile', NULL, NULL, 'قليلة', 0),
(2689, 24, 'El Ouardani', NULL, NULL, 'ورداني', 0),
(2690, 24, 'Er Rafid', NULL, NULL, 'الرافد', 0),
(2691, 24, 'Hallousiyet el Faouqa', NULL, NULL, 'حلوسية الفوقا', 0),
(2692, 24, 'Halloussiye', NULL, NULL, 'حلوسية', 0),
(2693, 24, 'Hammadiye', NULL, NULL, 'حمَادية', 0),
(2694, 24, 'Hamoul', NULL, NULL, 'حامول', 0),
(2695, 24, 'Hannaouiye', NULL, NULL, 'حناوي', 0),
(2696, 24, 'Hanniye', NULL, NULL, 'حنية', 0),
(2697, 24, 'Haumeiri', NULL, NULL, 'حميري', 0),
(2698, 24, 'Iskandarouna Sour', NULL, NULL, 'إسكندرونة', 0),
(2699, 24, 'Jannata', NULL, NULL, 'جناتا', 0),
(2700, 24, 'Jbal el Botm', NULL, NULL, 'جبال البطم', 0),
(2701, 24, 'Jebbain', NULL, NULL, 'جبين', 0),
(2702, 24, 'Jijim', NULL, NULL, 'ججيم', 0),
(2703, 24, 'Jouaiya', NULL, NULL, 'جويا', 0),
(2704, 24, 'Jour en Nakhl', NULL, NULL, 'جوار النخل', 0),
(2705, 24, 'Kfarnay', NULL, NULL, 'كفرنية', 0),
(2706, 24, 'Knisse Sour', NULL, NULL, 'كنيسة صور', 0),
(2707, 24, 'Labboune', NULL, NULL, 'لبونة', 0),
(2708, 24, 'Maachouq', NULL, NULL, 'معشوق', 0),
(2709, 24, 'Maaliye', NULL, NULL, 'معليَة', 0),
(2710, 24, 'Maarake', NULL, NULL, 'معركة', 0),
(2711, 24, 'Maaroub', NULL, NULL, 'معروب', 0),
(2712, 24, 'Machta El Aaziye', NULL, NULL, 'مشتى العزِية', 0),
(2713, 24, 'Mahrouneh', NULL, NULL, 'محرونه', 0),
(2714, 24, 'Majdel Zoun', NULL, NULL, 'مجدل زون', 0),
(2715, 24, 'Malkeit es Sahel', NULL, NULL, 'مالكية الساحل', 0),
(2716, 24, 'Mansouri', NULL, NULL, 'المنصوري', 0),
(2717, 24, 'Marnaba', NULL, NULL, 'مرنبا', 0),
(2718, 24, 'Marouahine', NULL, NULL, 'مروحين', 0),
(2719, 24, 'Matmoura', NULL, NULL, 'المطمورة', 0),
(2720, 24, 'Mazraat Aaiye', NULL, NULL, 'مزرعة عيا', 0),
(2721, 24, 'Mazraat Ain ez Zarqa', NULL, NULL, 'مزرعة عين الزرقا', 0),
(2722, 24, 'Mazraat Biout es Siyad', NULL, NULL, 'مزرعة بيوت السياد', 0),
(2723, 24, 'Mazraat Bsaile', NULL, NULL, 'مزرعة بسيلة', 0),
(2724, 24, 'Mazraat Deir Hanna', NULL, NULL, 'مزرعة دير حنا', 0),
(2725, 24, 'Mazraat Mechref', NULL, NULL, 'مزرعة المشرف', 0),
(2726, 24, 'Mheilib', NULL, NULL, 'محيليب', 0),
(2727, 24, 'Mjadel', NULL, NULL, 'المجادل', 0),
(2728, 24, 'Nabi Qassem', NULL, NULL, 'نبي قاسم', 0),
(2729, 24, 'Naffakhiye', NULL, NULL, 'نفاخية', 0),
(2730, 24, 'Naqoura', NULL, NULL, 'الناقورة', 0),
(2731, 24, 'Niha Sour', NULL, NULL, 'نيحا صور', 0),
(2732, 24, 'Ouadi Jilou', NULL, NULL, 'وادي جيلو', 0),
(2733, 24, 'Oum Toute', NULL, NULL, 'ام التوت', 0),
(2734, 24, 'Qalaat Maroun', NULL, NULL, 'قلعة مارون', 0),
(2735, 24, 'Qana', NULL, NULL, 'قانا', 0),
(2736, 24, 'Qasmiye', NULL, NULL, 'قاسمية', 0),
(2737, 24, 'Rachidiye', NULL, NULL, 'الرشيدية', 0),
(2738, 24, 'Ras el Ain', NULL, NULL, 'راس العين', 0),
(2739, 24, 'Rechkananey', NULL, NULL, 'رشكنانيه', 0),
(2740, 24, 'Rmadiyeh', NULL, NULL, 'رمادية', 0),
(2741, 24, 'Salaa', NULL, NULL, 'سلعا', 0),
(2742, 24, 'Sammaaiye', NULL, NULL, 'سماعية', 0),
(2743, 24, 'Siddiqine', NULL, NULL, 'صديقين', 0),
(2744, 24, 'Sour', NULL, NULL, 'صور', 0),
(2745, 24, 'Srifa', NULL, NULL, 'صريفا', 0),
(2746, 24, 'Taibe Sour', NULL, NULL, 'الطيبة صور', 0),
(2747, 24, 'Tair Debba', NULL, NULL, 'طير دبّه', 0),
(2748, 24, 'Tair Filsay', NULL, NULL, 'طير فلسيه', 0),
(2749, 24, 'Tair Harfa', NULL, NULL, 'طير حرفا', 0),
(2750, 24, 'Tair Semhat', NULL, NULL, 'طير سمحات', 0),
(2751, 24, 'Tair Zebna', NULL, NULL, 'طير زبنا', 0),
(2752, 24, 'Touairi', NULL, NULL, 'طويري', 0),
(2753, 24, 'Toura', NULL, NULL, 'طورا', 0),
(2754, 24, 'Yarine', NULL, NULL, 'يارين', 0),
(2755, 24, 'Ynouh', NULL, NULL, 'يانوح صور', 0),
(2756, 24, 'Zabqine', NULL, NULL, 'زبقين', 0),
(2757, 24, 'Zahriye', NULL, NULL, 'زهيرية', 0),
(2758, 24, 'Zalloutiye', NULL, NULL, 'مزرعة الزلوطية', 0);

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
(3, 1, 'Akkar', NULL, NULL, 'عكار'),
(4, 9, 'Aley', NULL, NULL, 'عاليه'),
(5, 9, 'Baabda', NULL, NULL, 'بعبدا'),
(6, 5, 'Baalbek', NULL, NULL, 'بعلبك'),
(7, 10, 'Bcharre', NULL, NULL, 'بشري'),
(8, 6, 'Beirut', NULL, NULL, 'بيروت'),
(9, 8, 'Bent Jbeil', NULL, NULL, 'بنت جبيل'),
(10, 9, 'Chouf', NULL, NULL, 'الشوف'),
(11, 10, 'El Batroun', NULL, NULL, 'البترون'),
(12, 5, 'El Hermel', NULL, NULL, 'الهرمل'),
(13, 10, 'El Koura', NULL, NULL, 'الكورة'),
(14, 9, 'El Meten', NULL, NULL, 'المتن'),
(15, 10, 'El Minieh-Dennie', NULL, NULL, 'المنية الضنية'),
(16, 8, 'El Nabatieh', NULL, NULL, 'النبطية'),
(17, 8, 'Hasbaya', NULL, NULL, 'حاصبيا'),
(18, 9, 'Jbeil', NULL, NULL, 'جبيل'),
(19, 11, 'Jezzine', NULL, NULL, 'جزين'),
(20, 9, 'Kesrwane', NULL, NULL, 'كسروان'),
(21, 8, 'Marjaayoun', NULL, NULL, 'مرجعيون'),
(22, 7, 'Rachaya', NULL, NULL, 'راشيا'),
(23, 11, 'Saida', NULL, NULL, 'صيدا'),
(24, 11, 'Sour', NULL, NULL, 'صور'),
(25, 10, 'Tripoli', NULL, NULL, 'طرابلس'),
(26, 7, 'West Bekaa', NULL, NULL, 'البقاع الغربي'),
(27, 7, 'Zahle', NULL, NULL, 'زحلة'),
(28, 10, 'Zgharta', NULL, NULL, 'زغرتا');

-- --------------------------------------------------------

--
-- Table structure for table `collectors`
--

CREATE TABLE `collectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `partner_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_subpartner` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_partner` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `collectors`
--

INSERT INTO `collectors` (`id`, `user_id`, `partner_id`, `name`, `city`, `is_subpartner`, `created_at`, `updated_at`, `sub_partner`) VALUES
(4, 11, 1, NULL, 'gandhidham', 1, '2019-12-20 07:19:05', '2019-12-23 04:44:39', 'sdfsdf'),
(5, 22, 21, NULL, 'Montreal', 0, '2020-01-03 22:15:34', '2020-01-03 22:15:34', NULL),
(6, 23, 21, NULL, 'test', 0, '2020-01-06 21:06:31', '2020-01-06 21:06:31', NULL),
(7, 26, 25, NULL, 'Montreal', 0, '2020-01-10 07:52:19', '2020-01-10 07:52:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'Akkar', '2019-12-23 03:40:22', '2020-01-06 04:35:27', 'عكار'),
(5, 'Baalbek-El Hermel', NULL, NULL, 'بعلبك - الهرمل'),
(6, 'Beirut', NULL, NULL, 'بيروت'),
(7, 'Bekaa', NULL, NULL, 'البقاع'),
(8, 'El Nabatieh', NULL, NULL, 'النبطية'),
(9, 'Mount Lebanon', NULL, NULL, 'جبل لبنان'),
(10, 'North', NULL, NULL, 'الشمال'),
(11, 'South', NULL, NULL, 'الجنوب');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(33, '2019_12_27_065046_create_status_table', 11),
(34, '2019_12_27_052207_create_application_value_table', 12),
(36, '2019_12_23_084011_create_caza_table', 13),
(37, '2019_12_23_084031_create_gouvernate_table', 13),
(39, '2019_12_23_053336_create_application_table', 14),
(40, '2019_12_30_130516_create_area_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(2, 'App\\User', 12),
(2, 'App\\User', 13),
(2, 'App\\User', 14),
(2, 'App\\User', 15),
(2, 'App\\User', 16),
(2, 'App\\User', 17),
(2, 'App\\User', 18),
(2, 'App\\User', 19),
(1, 'App\\User', 20),
(2, 'App\\User', 21),
(3, 'App\\User', 22),
(3, 'App\\User', 23),
(2, 'App\\User', 24),
(2, 'App\\User', 25),
(3, 'App\\User', 26);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_app_per_year` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `user_id`, `name`, `logo`, `max_app_per_year`, `created_at`, `updated_at`) VALUES
(13, 19, 'Test User', '1577955532.jpeg', 18, '2020-01-02 15:58:52', '2020-01-02 16:14:46'),
(14, 21, 'ESCWA', '1578063763.png', 240, '2020-01-03 22:02:43', '2020-01-08 12:41:08'),
(16, 25, 'Elsy', '1578616991.jpg', 1, '2020-01-10 07:43:11', '2020-01-10 07:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Pre Test', '2019-12-27 01:32:52', '2019-12-27 01:32:52'),
(3, 'Pre Test Pending', '2019-12-27 01:36:22', '2019-12-27 01:36:22'),
(4, 'Pre Test Completed', '2019-12-27 01:36:32', '2019-12-27 01:36:32'),
(5, 'Post Test', '2019-12-27 01:36:42', '2019-12-27 01:36:42'),
(6, 'Post Test Pending', '2019-12-27 01:36:51', '2019-12-27 01:36:51'),
(7, 'Post Test Completed', '2019-12-27 01:36:58', '2019-12-27 01:36:58'),
(8, 'Done', '2020-01-08 13:06:24', '2020-01-08 13:06:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `zone`, `address`, `fax`, `is_active`, `email_verified_at`, `password`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Michael', 'Saliba', 'vipul@cosmonautgroup.com', '8141688482', 'India', '302 Saman 2', '8141688482', '1', '2019-12-09 18:30:00', '$2y$10$qUjeiu5dDr/zd.STksY.4.oLEFtjTYV81r5jj9MrACZbrIaFJzQWO', 'bofCJum9Yw4OKna2vKe299lEb5lxuMoumLvGlCDj8PeXuE2qmB', 'H0cf2VuwWGsa64gw3xxA2PwXEbmw2wbbGKlmJiK6nIwMg1GVVtwU6sKCruXZ', NULL, '2020-01-07 20:31:36'),
(6, 'test', 'collector', 'test1234@gmail.com', '01234567898', '3', '308 saman 2', NULL, NULL, NULL, NULL, NULL, 'Yhba3PYAGPnDw1LeRT6EvdaNZbXohh7IUvGEMyQ8YwhizRt9vG', '2019-12-20 03:07:43', '2019-12-20 03:07:43'),
(9, 'testing', 'collector', 'test123456@gmail.com', '1234567898', '1', '302 saman 2', NULL, '1', '2019-12-09 18:30:00', '$2y$10$qUjeiu5dDr/zd.STksY.4.oLEFtjTYV81r5jj9MrACZbrIaFJzQWO', '7ciiK5uTd4KPcfyxc0KclnWPm9A07EBFRCseCQ9Xr2gEENmf4c', 'lbvDP4k9ivr0ArMCP3yjnOSGCINqNSZUG8UjniamlGDpBVS8aXFoOSkDnKZA', '2019-12-20 04:46:42', '2019-12-26 23:20:19'),
(11, 'Account', '1', 'vipul123@cosmonautgroup.com', '01234567898', '1', '308 saman 2', NULL, '1', NULL, NULL, NULL, 'ezNQNr1Q9rqWaIjn0z4mnfoCFFQqpcGEBWSKSCOPK5shWxlG5I', '2019-12-20 07:19:05', '2019-12-26 23:32:21'),
(19, 'Account', 'test', 'test15.cosmonautgroup@gmail.com', '1234567898', 'India', '308 saman 2', '01234567890', '1', NULL, '$2y$10$0I8y/5p.RBh1bLJDwn81g.a2FvD/FsNY/XDo0ifiywlHZgn7GUUdO', 'ZAkdnns9wXHf85M5eNXmJYdi7sHiScTlXbdSmWzzqPMnzTqh25', '8RRkyC74K2pucjtEREDE6m2kfynBWICS7mm01h9VOxfTgOcTS14dL2VC7i0I', '2020-01-02 15:58:52', '2020-01-08 12:43:16'),
(20, 'Robert', 'Saliba', 'robert.saliba@hotmail.com', '71358006', NULL, 'Hadath Lebanon', NULL, '1', NULL, '$2y$10$UNVBhY9Ae6weNaub3qcCWOus7pfs7r2cdNLeMsT/KNKTPf0g1K846', 'pCZJxmxGQdhUUJ67XoQ11UQoPYqWnGfnum0ClUo4vxb8gV9o7e', 'pPk8e1wrAuhihHSFRWu4QmbJ5dN2QCZAKUpjb0b6inKeMSkOfqk5hkFPsR18', '2020-01-03 21:57:26', '2020-01-04 21:45:56'),
(21, 'Robert', 'Partner', 'robert@robertsaliba.ca', '5146494048', NULL, 'Downtown', NULL, '1', NULL, '$2y$10$ppmT6HAWqoRpbDsktlAwqeV4mjej7DB6YeAdHbs0emsvyLjDLhZ6S', 'OqAsVDrmFXDqgROBsemy1GBdcUPM7WJINIDGaW5jPYD8JP98GU', '', '2020-01-03 22:02:43', '2020-01-09 05:57:30'),
(22, 'Nathalie', 'Taha', 'info@agilebeirut.org', '5146494048', '1', '2250 guy\r\napp 807', NULL, '1', NULL, '$2y$10$hh8aJ.l56wL3BPf0IoXe1eKzMTjt1tzxQsoCDrCBaGgvuLm/6GMd2', 'U0g4a30tdhKfuptx9Vyh6VEIh4MkUFhHe4BWV55jg7d0XVQXOG', 'RwpjS2KGpXbto7n6qyeYwHJP3jJQlbjY0lwoP1bjQ9UXApl7RRgAADbBcwmf', '2020-01-03 22:15:34', '2020-01-10 07:13:42'),
(23, 'Ehtisham', 'Ehtisham', 'ahteshamshani618@gmail.com', '12345672', '1', 'Pakistan', NULL, '1', NULL, '$2y$10$mdxoymwo3jdaVreKUrwqx.BDOh6M5xaN2tXfoXhdEsF8uhT/1mvcy', 'ophospOTUsxhPyl18wusAfxxfehr8bLyahwODbN1Q2Ec1V1qpN', '', '2020-01-06 21:06:31', '2020-01-10 13:01:50'),
(25, 'Elsy', 'Abi Khalil', 'experiweb.solutions@gmail.com', '12345678', NULL, 'Zahle', NULL, NULL, NULL, '$2y$10$U2VIyNUkcBnowX0PjWOoge7xHteja72yw3Jsl.k.Jpb0NASUkFamW', 'IIzLruFTujo3HOSlaKEgwIGof7BDhmwjqd0jygj24oiID6R8Sd', 'BjqWntiEtPs50cCrlNYlC7mdqZerbbEANg2YPeublU2kSezX6sXvl0uR6qbo', '2020-01-10 07:43:11', '2020-01-10 07:46:14'),
(26, 'Collector', 'of Elsy', 'collector1@agilebeirut.com', '5146494048', NULL, '2000 SAINT MARC\r\nAPT# 1506', NULL, '1', '2019-12-09 18:30:00', '$2y$10$U2VIyNUkcBnowX0PjWOoge7xHteja72yw3Jsl.k.Jpb0NASUkFamW', 'r2DQ4eBBPsnR4wKX4TC4kKdoyXLVZIcbuiJUamTcgSEQf3pSXm', 'r2DQ4eBBPsnR4wKX4TC4kKdoyXLVZIcbuiJUamTcgSEQf3pSXm', '2020-01-10 07:52:19', '2020-01-10 07:52:19');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `application_value`
--
ALTER TABLE `application_value`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2759;

--
-- AUTO_INCREMENT for table `caza`
--
ALTER TABLE `caza`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `collectors`
--
ALTER TABLE `collectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gouvernate`
--
ALTER TABLE `gouvernate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
