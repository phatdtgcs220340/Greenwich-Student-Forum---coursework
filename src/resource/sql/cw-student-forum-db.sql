-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2024 at 03:20 PM
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
-- Database: `cw-student-forum-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `description`) VALUES
(1, 'Java', 'this is java'),
(3, 'Python', 'Python is a high-level programming language known for its simplicity and readability.'),
(4, 'Algorithm', 'Algorithms are step-by-step procedures or formulas for solving problems.'),
(5, 'Linear Algebra', 'Linear algebra is a branch of mathematics dealing with vector spaces and linear mappings.'),
(6, 'Data Structures', 'Data structures are ways of organizing and storing data in a computer so that it can be accessed and modified efficiently.'),
(8, 'Database Management Systems', 'Database management systems (DBMS) are software applications that interact with end users, applications, and the database itself to capture and analyze data.'),
(9, 'Web Development', 'Web development refers to the tasks associated with developing websites or web applications.'),
(10, 'Computer Networking', 'Computer networking is the practice of interfacing computing devices together to share resources.'),
(11, 'Operating Systems', 'An operating system is system software that manages computer hardware, software resources, and provides common services for computer programs.'),
(15, 'Cloud Computing', 'Cloud computing is the delivery of computing services over the Internet, including servers, storage, databases, networking, software, and analytics.'),
(16, 'Mobile Development', 'Mobile development is the process of creating software applications that run on mobile devices, such as smartphones and tablets.'),
(17, 'Game Development', 'Game development is the process of creating video games for consoles, PCs, mobile devices, and other platforms.'),
(18, 'Computer Graphics', 'Computer graphics is a sub-field of computer science that focuses on the generation, manipulation, and representation of visual images.'),
(20, 'Internet of Things (IoT)', 'The Internet of Things (IoT) is a network of interconnected devices that communicate and exchange data over the internet without human intervention.'),
(21, 'Blockchain', 'Blockchain is a decentralized, distributed ledger technology that records transactions across multiple computers in a way that is tamper-resistant and transparent.');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `content`, `creation_date`, `user_id`, `thread_id`) VALUES
(1, 'hahah', '2024-04-23 11:07:32', 2, 1),
(6, 'a reply\r\n', '2024-04-28 12:29:23', 2, 13),
(7, 'another reply by another student', '2024-04-28 12:31:40', 3, 13),
(9, 'bai nay giai theo cach nay abc...xyz', '2024-05-04 13:07:18', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `thread_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `title`, `content`, `image`, `creation_date`, `user_id`, `module_id`) VALUES
(1, 'hahahah', 'hahhahaha', 'resource/static/images/thread/21699372374639.png', '2024-04-23 09:04:52', 2, 1),
(3, 'a database question', 'content', 'resource/static/images/thread/2Screenshot 2023-06-26 160228.png', '2024-04-23 12:11:22', 2, 8),
(13, 'A question ', 'A content', 'resource/static/images/thread/2Screenshot 2023-10-23 211727.png', '2024-04-28 08:50:32', 2, 8),
(14, 'java question', 'new content', '', '2024-04-28 09:22:05', 2, 1),
(15, 'LA question', 'LA content', '', '2024-04-28 09:24:34', 2, 5),
(16, 'linux question', 'linux question content', 'resource/static/images/thread/3Screenshot 2023-07-12 021835.png', '2024-04-28 13:32:12', 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Student','Admin') NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT 'resource/static/images/user/default_avatar.jpg',
  `is_enabled` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstName`, `lastName`, `password`, `email`, `role`, `creation_date`, `image`, `is_enabled`) VALUES
(1, 'I\'m', 'God', '$2y$10$x2P4yP4.M86OTpa.j4XHSu6MzCwNXs7uhIV8Sqr4ZKXQsNSDtECOC', 'admin@gmail.com', 'Admin', '2024-04-23 09:02:33', 'resource/static/images/user/user1_avatar.png', 1),
(2, 'Phat', 'Do', '$2y$10$13amELMOeYUj9dwYJftSBu6GVFsGaEjZhV7E980wr4PxBDGnyFqzK', 'ddtphat2004@gmail.com', 'Student', '2024-04-23 09:02:44', 'resource/static/images/user/user2_avatar.jpg', 1),
(3, 'Huyen', 'Ngo', '$2y$10$qDczdSxa03T6QGK9D3h3jOOEmYahEJ8SRb/cSrGDGY0T.Jk.Fg.Ka', 'ngothithanhhuyen@gmail.com', 'Student', '2024-04-23 11:58:49', 'resource/static/images/user/default_avatar.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`) ON DELETE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
