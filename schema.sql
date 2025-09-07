SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `contact_messages` (
  `contact_messages_id` int NOT NULL,
  `full_name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `replied` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `event` (
  `event_id` int NOT NULL,
  `title` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `organisation_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `organisation` (
  `organisation_id` int NOT NULL,
  `organisation_name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_person_full_name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','volunteer') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admin',
  `volunteer_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `volunteer` (
  `volunteer_id` int NOT NULL,
  `full_name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `skills` text COLLATE utf8mb4_general_ci,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `volunteer_event` (
  `event_id` int NOT NULL,
  `volunteer_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`contact_messages_id`);

ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `organisation_id` (`organisation_id`);

ALTER TABLE `organisation`
  ADD PRIMARY KEY (`organisation_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `volunteer_id` (`volunteer_id`);

ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `volunteer_event`
  ADD PRIMARY KEY (`event_id`,`volunteer_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);


ALTER TABLE `contact_messages`
  MODIFY `contact_messages_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `event`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `organisation`
  MODIFY `organisation_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `volunteer`
  MODIFY `volunteer_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`organisation_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteer` (`volunteer_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `volunteer_event`
  ADD CONSTRAINT `volunteer_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_event_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteer` (`volunteer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
