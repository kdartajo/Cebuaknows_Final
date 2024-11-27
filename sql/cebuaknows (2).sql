-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 03:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cebuaknows`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `advertisement_id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `advertisement_image` varchar(40) DEFAULT NULL,
  `gmail_message` varchar(255) NOT NULL,
  `advertisement_package` int(11) NOT NULL,
  `mode` varchar(10) NOT NULL DEFAULT 'deactivate',
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expiration_date` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`advertisement_id`, `company_name`, `advertisement_image`, `gmail_message`, `advertisement_package`, `mode`, `user_id`, `created_at`, `expiration_date`, `updated_at`) VALUES
(1, 'Journey', 'uploads/img/Journey.jpg', 'Reply when received please', 1, 'deactivate', 1, '2024-11-17 21:12:30', '2024-11-17 21:12:30', '2024-11-17 21:32:02'),
(2, 'Sinulog', 'uploads/img/sinulog.jpg', 'I have several questions', 1, 'deactivate', 4, '2024-11-17 21:12:30', '2024-11-17 21:12:30', '2024-11-17 21:32:02'),
(3, 'Celebrate Cebu!', 'uploads/img/celebrateCebu.jpg', 'Hope this advertisement gets activated in your website', 2, 'deactivate', 9, '2024-11-17 21:12:30', '2024-12-01 22:09:19', '2024-11-17 22:17:24'),
(4, 'DiriTa!', 'uploads/img/celebrateCebu.jpg', 'DiriTa!', 2, 'activate', 1, '2024-11-17 21:28:33', '2024-12-03 10:18:59', '2024-11-19 10:18:59'),
(5, 'Advertisement Test', 'uploads/img/download.jpg', 'Testing the advertisement expiration', 4, 'deactivate', 9, '2024-11-17 22:35:48', '2024-11-20 10:17:57', '2024-11-19 10:18:04');

--
-- Triggers `advertisement`
--
DELIMITER $$
CREATE TRIGGER `set_expiration_date_on_mode_update` BEFORE UPDATE ON `advertisement` FOR EACH ROW BEGIN
    -- Declare a variable to store the interval dynamically
    DECLARE interval_days INT;

    -- Determine the number of days based on the advertisement_package
    SET interval_days = 
        CASE 
        	WHEN NEW.advertisement_package = 4 THEN 1 
            WHEN NEW.advertisement_package = 1 THEN 7       -- 1 week = 7 days
            WHEN NEW.advertisement_package = 2 THEN 14      -- 2 weeks = 14 days
            WHEN NEW.advertisement_package = 3 THEN 21      -- 3 weeks = 21 days
            ELSE 0                                          -- Default to 0 days for invalid packages
        END;

    -- Set the expiration_date dynamically
    IF NEW.mode = 'activate' THEN
        SET NEW.expiration_date = DATE_ADD(NOW(), INTERVAL interval_days DAY);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `choices_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`choices_id`, `description`, `question_id`) VALUES
(1, '', 1),
(2, '', 1),
(3, '', 1),
(4, '', 1),
(5, '', 2),
(6, '', 2),
(7, '', 2),
(8, '', 2),
(9, 'dfsfd', 3),
(10, 'vtds', 3),
(11, 'sre', 3),
(12, 'tsgs', 3),
(13, 'dsfg', 4),
(14, 'sdfg', 4),
(15, 'sfdg', 4),
(16, 'sdfg', 4),
(17, 'dsf', 5),
(18, '', 5),
(19, 'sadf', 5),
(20, 'asdf', 5),
(21, 'Pending Test', 6),
(22, 'Pending Test', 6),
(23, 'Pending Test', 6),
(24, 'Pending Test', 6),
(25, '1731', 7),
(26, '1923', 7),
(27, '1823', 7),
(28, '1782', 7),
(29, '', 8),
(30, '', 8),
(31, '', 8),
(32, '', 8),
(33, 'asdf', 9),
(34, 'dsa', 9),
(35, 'c', 9),
(36, 'dca', 9),
(37, 'dsf', 10),
(38, 'dfg', 10),
(39, 'vcb', 10),
(40, 'cvbn', 10),
(41, 'dfnkihj', 11),
(42, 'loi', 11),
(43, 'ili', 11),
(44, 'hytui', 11),
(45, '', 12),
(46, '', 12),
(47, '', 12),
(48, '', 12),
(49, 'dsf', 13),
(50, 'asdf', 13),
(51, 'choice1c', 13),
(52, 'test', 13),
(53, 'test', 14),
(54, 'test', 14),
(55, 'test', 14),
(56, 'xcvb', 14),
(57, '', 15),
(58, '', 15),
(59, '', 15),
(60, '', 15),
(61, '', 16),
(62, '', 16),
(63, '', 16),
(64, '', 16),
(65, '', 17),
(66, '', 17),
(67, '', 17),
(68, '', 17),
(69, 'a', 18),
(70, 'b', 18),
(71, 'c', 18),
(72, 'd', 18),
(73, 'test', 19),
(74, 'test', 19),
(75, 'test', 19),
(76, 'test', 19),
(77, '', 20),
(78, '', 20),
(79, '', 20),
(80, '', 20),
(81, 'You ', 21),
(82, 'Me ', 21),
(83, 'Him ', 21),
(84, 'Her', 21),
(85, 'Them', 22),
(86, 'She', 22),
(87, 'He', 22),
(88, 'They', 22),
(89, 'Garcia', 23),
(90, 'Duterte', 23),
(91, 'Arroyo', 23),
(92, 'Robredo', 23),
(93, 'A Saint', 24),
(94, 'Savior', 24),
(95, 'Child', 24),
(96, 'God', 24),
(97, 'Artajo', 25),
(98, 'Mixdon', 25),
(99, 'Bragat', 25),
(100, 'Lim', 25);

-- --------------------------------------------------------

--
-- Table structure for table `choice_answer`
--

CREATE TABLE `choice_answer` (
  `choice_answer_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choice_answer`
--

INSERT INTO `choice_answer` (`choice_answer_id`, `question_id`) VALUES
(11, 3),
(16, 4),
(18, 5),
(22, 6),
(25, 7),
(34, 9),
(39, 10),
(44, 11),
(50, 13),
(56, 14),
(72, 18),
(76, 19),
(83, 21),
(88, 22),
(89, 23),
(93, 24),
(97, 25);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `comment`, `created_at`) VALUES
(10, 1, 'arev', '2024-11-06 02:48:55'),
(11, 1, 'this is a comment', '2024-11-06 02:49:45'),
(12, 1, 'you say he murdered 3?', '2024-11-06 02:50:57'),
(13, 1, 'testing ', '2024-11-06 02:51:42'),
(14, 1, 'this is another comment', '2024-11-06 03:05:16'),
(15, 2, 'I am user 2 admin', '2024-11-06 03:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL,
  `content_title` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'PENDING',
  `feedback` varchar(255) NOT NULL DEFAULT 'No feedback from Admin or Historian'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_title`, `description`, `created_at`, `updated_at`, `location_id`, `quiz_id`, `media_id`, `user_id`, `status`, `feedback`) VALUES
(1, 'Yap House', 'This is the Oldest House in Cebu City.', '2024-10-22 15:28:45', '2024-10-22 15:28:45', 1, 1, 1, 1, 'PENDING', 'You need to have an image'),
(4, 'Ancestral House', 'Ancestral House is the house of the ancestors of our kind', '2024-10-22 17:17:29', '2024-10-22 17:17:29', 5, 5, 5, 1, 'ACCEPTED', ''),
(6, 'Guadalupe Church', 'Guadalupe Church is a historic Catholic church located in La Villita, San Antonio, Texas. It was built in 1731 and is one of the oldest parish churches in the United States. The church is dedicated to Our Lady of Guadalupe, a popular Catholic saint. The b', '2024-10-23 05:02:48', '2024-10-23 05:02:48', 7, 7, 7, 2, 'ACCEPTED', ''),
(7, 'Basilica Minore del Santo Niño', 'Cebus holiest church houses a revered Flemish statuette of the Christ child (Santo Niño) that dates to Magellans time. The church is no stranger to hardship: established in 1565 (the first church in the Philippines), three earlier structures were destroyed by fire, before the existing baroque structure was built in 1737. Its facade and belfry were badly damaged by the 2013 earthquake but have been restored.\n\nPerhaps the church owes its incendiary past to the perennial bonfire of candles in its courtyard, stoked by an endless procession of pilgrims and other worshippers. The object of their veneration is an image of the infant Jesus, sequestered in a chapel to the left of the altar. It dates back to Magellans time and is said to be miraculous (which it probably had to be to survive all those fires). Every year, the image is the centrepiece of Cebus largest annual event, the Sinulog Festival.\n\nOn Sundays and Fridays, the street outside the church is closed to vehicular traffic, all-day outdoor masses are held and the basilica turns into a sea of pilgrims, water sellers and replica Santo Niño salespeople.', '2024-10-23 05:34:47', '2024-10-23 05:34:47', 9, 9, 9, 2, 'ACCEPTED', ''),
(8, 'Museo Sugbo', 'This excellent museum comprises several galleries in a sturdy old coral-stone building that was Cebus provincial jail from 1870 to 2004. Rooms are dedicated to eras in Cebus history. The American-era gallery contains an interesting collection of letters and memorabilia from Thomas Sharpe, one of 1065 teachers known as Thomasites who arrived in the early days of the American period to fulfil President McKinleys pledge to educate the Filipinos.\r\n\r\nUpstairs a WWII gallery contains an American bomb that was dropped in Cebu, Japanese propaganda newspapers and a Purple Heart and Bronze Star earned by local Uldrico Cabahug. Theres a cafe and a gift shop in the museum compound.', '2024-10-23 11:50:27', '2024-10-23 11:50:27', 11, 11, 11, 3, 'WAITING', ''),
(9, 'Museo Sugbo', 'This excellent museum comprises several galleries in a sturdy old coral-stone building that was Cebus provincial jail from 1870 to 2004. Rooms are dedicated to eras in Cebus history. The American-era gallery contains an interesting collection of letters and memorabilia from Thomas Sharpe, one of 1065 teachers known as Thomasites who arrived in the early days of the American period to fulfil President McKinleys pledge to educate the Filipinos.\r\n\r\nUpstairs a WWII gallery contains an American bomb that was dropped in Cebu, Japanese propaganda newspapers and a Purple Heart and Bronze Star earned by local Uldrico Cabahug. Theres a cafe and a gift shop in the museum compound.', '2024-10-23 11:51:57', '2024-10-23 11:51:57', 12, 12, 12, 3, 'ACCEPTED', ''),
(10, 'Magellans Cross', 'craesd', '2024-10-23 11:53:00', '2024-10-23 11:53:00', 13, 13, 13, 3, 'PENDING', ''),
(11, 'asdf', 'asdf', '2024-10-23 12:23:37', '2024-10-23 12:23:37', 14, 14, 14, 3, 'PENDING', ''),
(12, 'ad', 'vra', '2024-10-23 12:31:24', '2024-10-23 12:31:24', 15, 15, 15, 3, 'PENDING', ''),
(13, 'asdf', 'asdf', '2024-10-23 12:32:35', '2024-10-23 12:32:35', 16, 16, 16, 3, 'PENDING', ''),
(16, 'Lahug Campu', 'Stories of Lahug Campu ', '2024-10-23 14:54:10', '2024-11-10 17:31:59', 21, 21, 21, 1, 'PENDING', ''),
(19, 'Magellan\'s Cross', 'Magellan\'s corss', '2024-10-24 02:10:04', '2024-10-24 02:10:04', 24, 24, 24, 1, 'WAITING', ''),
(20, 'Yap House', 'adsf\'asdf\'asdf', '2024-11-04 00:37:51', '2024-11-04 00:37:51', 25, 25, 25, 1, 'PENDING', ''),
(21, 'UC-Main', 'This is the story of the historical UC-Main Building', '2024-11-09 06:36:23', '2024-11-09 06:36:23', 26, 27, 26, 1, 'PENDING', ''),
(22, 'UC-Banilad', 'This is the historical building of UC-Banilad', '2024-11-09 06:52:02', '2024-11-09 06:52:02', 27, 28, 27, 1, 'PENDING', ''),
(23, 'Cebu Normal University', 'This is the historical place of the Cebu Normal University', '2024-11-09 06:55:28', '2024-11-09 06:55:28', 28, 29, 28, 1, 'ACCEPTED', ''),
(24, 'Lyceum Of Cebu', 'The Story of how Lyceum of Cebu was founded', '2024-11-09 13:50:52', '2024-11-09 13:50:52', 29, 30, 29, 1, 'PENDING', ''),
(26, 'Kalunasan', 'This is the historical story of Kalunasan', '2024-11-09 14:09:39', '2024-11-09 14:09:39', 31, 32, 31, 1, 'ACCEPTED', ''),
(27, 'Southwestern University', 'This is another story of the historical Southwestern University', '2024-11-10 15:42:55', '2024-11-10 15:42:55', 32, NULL, 32, 1, 'PENDING', ''),
(29, 'Fuente Circle', 'This is the story of Fuente Circle', '2024-11-12 17:37:08', '2024-11-12 17:37:08', 34, NULL, 34, 1, 'PENDING', 'No feedback from Admin or Historian'),
(30, 'Video Test', 'This is for Video Test', '2024-11-16 16:47:29', '2024-11-16 16:47:29', 35, NULL, 35, 1, 'PENDING', 'No feedback from Admin or Historian'),
(31, 'another video testing', 'This is to prove that the video works', '2024-11-16 16:53:44', '2024-11-16 16:53:44', 36, NULL, 36, 1, 'PENDING', 'No feedback from Admin or Historian');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` int(11) NOT NULL,
  `forum_topic` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `forum_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_topic`, `user_id`, `content_id`, `forum_description`) VALUES
(7, 'My experience in sugbo', 1, 6, 'What an experience!!					\r\n					'),
(8, 'This is outragous', 3, 4, 'I will never visit this place again					\r\n					'),
(9, 'I had a great Time!', 3, 4, 'When I walked into the place I felt the whole history brushed against my skin!					\r\n					'),
(10, 'This place has been my healing space', 3, 4, 'Everytime I visit this place, it somehow makes me feel I am accepted					\r\n					'),
(11, 'Will I ever visit a place like this again?', 1, 4, 'I am ecstatic!!!					\r\n					');

-- --------------------------------------------------------

--
-- Table structure for table `forum_discussion`
--

CREATE TABLE `forum_discussion` (
  `comment_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_discussion`
--

INSERT INTO `forum_discussion` (`comment_id`, `forum_id`) VALUES
(13, 9),
(14, 9),
(15, 9);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location`) VALUES
(1, 'Cebu City'),
(2, 'Lapu-Lapu City'),
(3, 'Lapu-Lapu City'),
(5, 'Mandaue City'),
(6, 'Lapu-Lapu City'),
(7, 'Mandaue City'),
(8, 'Cebu City'),
(9, 'Cebu City'),
(10, 'Cebu City'),
(11, 'Cebu City'),
(12, 'Cebu City'),
(13, 'Lapu-Lapu City'),
(14, 'Cebu City'),
(15, 'Lapu-Lapu City'),
(16, 'Lapu-Lapu City'),
(17, 'Lapu-Lapu City'),
(18, 'Lapu-Lapu City'),
(19, 'Lapu-Lapu City'),
(20, 'Lapu-Lapu City'),
(21, 'Cebu City'),
(22, 'Cebu City'),
(23, 'Cebu City'),
(24, 'Lapu-Lapu City'),
(25, ''),
(26, 'Cebu City'),
(27, 'Cebu City'),
(28, 'Cebu City'),
(29, 'Talisay City'),
(30, 'Cebu City'),
(31, 'Cebu City'),
(32, 'Cebu City'),
(33, 'Cebu City'),
(34, 'Cebu City'),
(35, 'Cebu City'),
(36, 'Cebu City');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`media_id`, `url`, `video`, `image`, `created_at`, `last_update`) VALUES
(1, '', 'uploads/vid/', 'uploads/img/', '2024-10-22 15:28:45', '2024-10-22 15:28:45'),
(2, '', 'uploads/vid/', 'uploads/img/', '2024-10-22 15:39:11', '2024-10-22 15:39:11'),
(3, '', 'uploads/vid/', 'uploads/img/', '2024-10-22 15:39:27', '2024-10-22 15:39:27'),
(4, '', 'uploads/vid/', 'uploads/img/', '2024-10-22 17:14:25', '2024-10-22 17:14:25'),
(5, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/EduTrack - Pr', '2024-10-22 17:17:29', '2024-10-22 17:17:29'),
(6, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/EduTrack - Pr', '2024-10-22 17:27:28', '2024-10-22 17:27:28'),
(7, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/images.jpg', '2024-10-23 05:02:48', '2024-10-23 05:02:48'),
(8, 'https://www.youtube.com/watch?v=iaUXjTL_F9U&t=178s', 'uploads/vid/', 'uploads/img/xcv.jpg', '2024-10-23 05:33:56', '2024-10-23 05:33:56'),
(9, 'https://www.youtube.com/watch?v=iaUXjTL_F9U&t=178s', 'uploads/vid/', 'uploads/img/xcv.jpg', '2024-10-23 05:34:47', '2024-10-23 05:34:47'),
(10, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-10-23 11:49:47', '2024-10-23 11:49:47'),
(11, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-10-23 11:50:27', '2024-10-23 11:50:27'),
(12, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-10-23 11:51:57', '2024-10-23 11:51:57'),
(13, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/logo.png', '2024-10-23 11:53:00', '2024-10-23 11:53:00'),
(14, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/banner.png', '2024-10-23 12:23:37', '2024-10-23 12:23:37'),
(15, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image2.jpg', '2024-10-23 12:31:24', '2024-10-23 12:31:24'),
(16, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/banner.png', '2024-10-23 12:32:35', '2024-10-23 12:32:35'),
(17, '', 'uploads/vid/', 'uploads/img/', '2024-10-23 14:43:53', '2024-10-23 14:43:53'),
(18, '', 'uploads/vid/', 'uploads/img/', '2024-10-23 14:44:34', '2024-10-23 14:44:34'),
(19, '', 'uploads/vid/', 'uploads/img/', '2024-10-23 14:45:56', '2024-10-23 14:45:56'),
(20, '', 'uploads/vid/', 'uploads/img/', '2024-10-23 14:46:29', '2024-10-23 14:46:29'),
(21, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', NULL, '2024-10-23 14:54:10', '2024-11-10 17:31:59'),
(22, 'https://www.youtube.com/watch?v=iaUXjTL_F9U&t=178s', 'uploads/vid/', NULL, '2024-10-23 14:55:09', '2024-10-23 14:55:09'),
(23, '', 'uploads/vid/', 'uploads/img/', '2024-10-23 14:55:37', '2024-10-23 14:55:37'),
(24, 'https://www.youtube.com/watch?v=iaUXjTL_F9U&t=178s', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-10-24 02:10:04', '2024-10-24 02:10:04'),
(25, '', 'uploads/vid/', 'uploads/img/', '2024-11-04 00:37:51', '2024-11-04 00:37:51'),
(26, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-11-09 06:36:23', '2024-11-09 06:36:23'),
(27, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/xcv.jpg', '2024-11-09 06:52:02', '2024-11-09 06:52:02'),
(28, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-11-09 06:55:28', '2024-11-09 06:55:28'),
(29, 'https://www.youtube.com/watch?v=iaUXjTL_F9U&t=178s', 'uploads/vid/', 'uploads/img/image2.jpg', '2024-11-09 13:50:52', '2024-11-09 13:50:52'),
(30, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image3.jpg', '2024-11-09 13:55:10', '2024-11-09 13:55:10'),
(31, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/images.jpg', '2024-11-09 14:09:39', '2024-11-09 14:09:39'),
(32, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/image1.jpg', '2024-11-10 15:42:55', '2024-11-10 15:42:55'),
(33, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/download.jpg', '2024-11-12 13:27:44', '2024-11-12 13:27:44'),
(34, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/', 'uploads/img/download (2).', '2024-11-12 17:37:08', '2024-11-12 17:37:08'),
(35, 'https://www.youtube.com/watch?v=iaUXjTL_F9U&t=178s', 'uploads/vid/466777506_896', 'uploads/img/462571598_239', '2024-11-16 16:47:29', '2024-11-16 16:47:29'),
(36, 'https://www.youtube.com/watch?v=ekr2nIex040&list=RDE5SFgaCNpIo&index=2', 'uploads/vid/466777506_8962343977157544_227634184953424663_n.mp4', 'uploads/img/download.jpg', '2024-11-16 16:53:44', '2024-11-16 16:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `question`, `created_at`) VALUES
(1, '', '2024-10-22 15:28:45'),
(2, '', '2024-10-22 15:39:27'),
(3, 'asjdfkl', '2024-10-22 17:14:25'),
(4, 'quesiton2', '2024-10-22 17:14:25'),
(5, 'Who is the owner', '2024-10-22 17:17:29'),
(6, 'Pending Test', '2024-10-22 17:27:28'),
(7, 'What year was Guadalupe Church Built?', '2024-10-23 05:02:48'),
(8, '', '2024-10-23 05:34:47'),
(9, 'who is who', '2024-10-23 11:53:00'),
(10, 'vrs', '2024-10-23 12:23:37'),
(11, 'adsfrg', '2024-10-23 12:23:37'),
(12, '', '2024-10-23 12:31:24'),
(13, 'asdf', '2024-10-23 12:32:35'),
(14, 'quesiton2', '2024-10-23 12:32:35'),
(15, '', '2024-10-23 14:54:10'),
(16, '', '2024-10-23 14:55:09'),
(17, '', '2024-10-23 14:55:37'),
(18, 'question1', '2024-10-24 02:10:04'),
(19, 'quesiton2', '2024-10-24 02:10:04'),
(20, '', '2024-11-04 00:37:51'),
(21, 'Who died?', '2024-11-09 08:11:39'),
(22, 'Who is the president', '2024-11-09 08:11:39'),
(23, 'Who Founded Lyceum of Cebu', '2024-11-09 13:52:47'),
(24, 'Who Santo Nino to the Cebuanos?', '2024-11-09 13:56:09'),
(25, 'who is the founder of Barangay kalunasan?', '2024-11-09 14:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(25) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_title`, `created_at`) VALUES
(1, '', '2024-10-22 15:28:45'),
(2, '', '2024-10-22 15:39:11'),
(3, '', '2024-10-22 15:39:27'),
(4, 'Almost', '2024-10-22 17:14:25'),
(5, 'Yap House', '2024-10-22 17:17:29'),
(6, 'Pending Test', '2024-10-22 17:27:28'),
(7, 'Guadalupe Church', '2024-10-23 05:02:48'),
(8, '', '2024-10-23 05:33:56'),
(9, '', '2024-10-23 05:34:47'),
(10, 'Museo Sugbo(Part 1)', '2024-10-23 11:49:47'),
(11, 'Museo Sugbo(Part 1)', '2024-10-23 11:50:27'),
(12, 'Museo Sugbo(Part 1)', '2024-10-23 11:51:57'),
(13, 'Trivia quiz fort', '2024-10-23 11:53:00'),
(14, 'adsf', '2024-10-23 12:23:37'),
(15, '', '2024-10-23 12:31:24'),
(16, 'test', '2024-10-23 12:32:35'),
(17, '', '2024-10-23 14:43:53'),
(18, '', '2024-10-23 14:44:34'),
(19, '', '2024-10-23 14:45:56'),
(20, '', '2024-10-23 14:46:29'),
(21, '', '2024-10-23 14:54:10'),
(22, '', '2024-10-23 14:55:09'),
(23, '', '2024-10-23 14:55:37'),
(24, 'question title', '2024-10-24 02:10:04'),
(25, '', '2024-11-04 00:37:51'),
(27, 'UC-Main', '2024-11-09 08:01:51'),
(28, 'UC-Banilad', '2024-11-09 08:03:02'),
(29, 'Cebu Normal University', '2024-11-09 08:11:39'),
(30, 'Lyceum Of Cebu History', '2024-11-09 13:52:47'),
(31, 'Santo Nino', '2024-11-09 13:56:09'),
(32, 'Kalunasan', '2024-11-09 14:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_leaderboard`
--

CREATE TABLE `quiz_leaderboard` (
  `leaderboard_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_leaderboard`
--

INSERT INTO `quiz_leaderboard` (`leaderboard_id`, `score`, `total_questions`, `user_id`, `quiz_id`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 4, 29, '2024-11-10 16:52:19', '2024-11-10 16:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questionnaire`
--

CREATE TABLE `quiz_questionnaire` (
  `quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questionnaire`
--

INSERT INTO `quiz_questionnaire` (`quiz_id`, `question_id`) VALUES
(1, 1),
(3, 2),
(4, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(9, 8),
(13, 9),
(14, 10),
(14, 11),
(15, 12),
(16, 13),
(16, 14),
(21, 15),
(22, 16),
(23, 17),
(24, 18),
(24, 19),
(25, 20),
(29, 21),
(29, 22),
(30, 23),
(31, 24),
(32, 25);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `confirm_password` varchar(50) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(60) NOT NULL,
  `profile_picture` varchar(60) NOT NULL,
  `role` varchar(25) NOT NULL DEFAULT 'Learner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `confirm_password`, `firstname`, `lastname`, `bio`, `mobile`, `address`, `profile_picture`, `role`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$jFkcrm4mBFEL8o7glelu7unGPPENIsL5M4uB0j95TCIa4oZSWmUKq', 'test', 'Test', 'Test', 'I am the best.', '09150141501', 'Kalunasan, Cebu City', 'img/default_profile.jpg', 'Learner'),
(2, 'test2', 'test2@gmail.com', '$2y$10$kvEH7Qnwvxzpd3JcsZ59XuwxgGJL.6UvG1Ms5S8Sjxf0VtkRNKCri', 'test2', 'Klien Dominic', 'Artajo', 'Don\'t Panic', '091501348922', 'Mountain View Village, Blk 28, Lot 06 Kalunasan Cebu City', 'img/subhome-ai.jpg', 'Admin'),
(3, 'test3', 'test3@gmail.com', '$2y$10$RpdrgimfWi7vpK98yMIMHOlwCgmKRgTW38Kw3DpfzNP0hcg41JpvK', 'test3', 'test3', 'test3', 'Please send me legit information!', '091501415023', 'Mountain View Village, Blk 28, Lot 06 Kalunasan Cebu City', 'img/459418071_1195021635089716_4054749095685787177_n.jpg', 'Historian'),
(4, 'testing', 'testing@gmail.com', '$2y$10$YTGy7ptX9N2mvaU.Zvhc.u/ALCAdemh0uvMEFXEqmCjIPiLM77FZa', 'testing', 'Klien Dominic', 'Artajo', 'Another Bio', '09150141501', 'Labangon, Tisa, blk 32 lot 03', 'img/images.jpg', 'Learner'),
(9, 'Klien Artajo', 'klienartajo@gmail.com', '$2y$10$3HzGBQId0Ds5zVX3WanVVuE25Y01ZvQXimwoiUcSVii8goSUBT6KC', 'klien', 'Klien', 'Artajo', 'This is my Bio', '0987654321', 'Labangon, Tisa, blk 32 lot 03', 'img/460520320_3930041640655859_9100623742436925906_n.jpg', 'Learner');

-- --------------------------------------------------------

--
-- Table structure for table `user_quiz_details`
--

CREATE TABLE `user_quiz_details` (
  `user_quiz_detail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choices_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_quiz_details`
--

INSERT INTO `user_quiz_details` (`user_quiz_detail_id`, `user_id`, `quiz_id`, `question_id`, `choices_id`, `created_at`) VALUES
(1, 1, 29, 21, 81, '2024-11-09 17:02:18'),
(2, 1, 29, 21, 82, '2024-11-09 17:02:18'),
(3, 1, 29, 21, 83, '2024-11-09 17:02:18'),
(4, 1, 29, 21, 84, '2024-11-09 17:02:18'),
(5, 1, 29, 22, 85, '2024-11-09 17:02:18'),
(6, 1, 29, 22, 86, '2024-11-09 17:02:18'),
(7, 1, 29, 22, 87, '2024-11-09 17:02:18'),
(8, 1, 29, 22, 88, '2024-11-09 17:02:18'),
(9, 1, 30, 23, 89, '2024-11-09 21:52:47'),
(11, 1, 32, 25, 97, '2024-11-09 22:10:25'),
(12, 1, 32, 25, 98, '2024-11-09 22:10:25'),
(13, 1, 32, 25, 99, '2024-11-09 22:10:25'),
(14, 1, 32, 25, 100, '2024-11-09 22:10:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`advertisement_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`choices_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `choice_answer`
--
ALTER TABLE `choice_answer`
  ADD KEY `choice_answer_id` (`choice_answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `content_id` (`content_id`);

--
-- Indexes for table `forum_discussion`
--
ALTER TABLE `forum_discussion`
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_leaderboard`
--
ALTER TABLE `quiz_leaderboard`
  ADD PRIMARY KEY (`leaderboard_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_questionnaire`
--
ALTER TABLE `quiz_questionnaire`
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_quiz_details`
--
ALTER TABLE `user_quiz_details`
  ADD PRIMARY KEY (`user_quiz_detail_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `choices_id` (`choices_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `advertisement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `choices_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `quiz_leaderboard`
--
ALTER TABLE `quiz_leaderboard`
  MODIFY `leaderboard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_quiz_details`
--
ALTER TABLE `user_quiz_details`
  MODIFY `user_quiz_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `choice_answer`
--
ALTER TABLE `choice_answer`
  ADD CONSTRAINT `choice_answer_ibfk_1` FOREIGN KEY (`choice_answer_id`) REFERENCES `choices` (`choices_id`),
  ADD CONSTRAINT `choice_answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`),
  ADD CONSTRAINT `content_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`),
  ADD CONSTRAINT `content_ibfk_3` FOREIGN KEY (`media_id`) REFERENCES `media` (`media_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `forum_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `content` (`content_id`);

--
-- Constraints for table `forum_discussion`
--
ALTER TABLE `forum_discussion`
  ADD CONSTRAINT `forum_discussion_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`),
  ADD CONSTRAINT `forum_discussion_ibfk_2` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`forum_id`);

--
-- Constraints for table `quiz_leaderboard`
--
ALTER TABLE `quiz_leaderboard`
  ADD CONSTRAINT `quiz_leaderboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `quiz_leaderboard_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `quiz_questionnaire`
--
ALTER TABLE `quiz_questionnaire`
  ADD CONSTRAINT `quiz_questionnaire_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`),
  ADD CONSTRAINT `quiz_questionnaire_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `user_quiz_details`
--
ALTER TABLE `user_quiz_details`
  ADD CONSTRAINT `user_quiz_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_quiz_details_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`),
  ADD CONSTRAINT `user_quiz_details_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `user_quiz_details_ibfk_4` FOREIGN KEY (`choices_id`) REFERENCES `choices` (`choices_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
