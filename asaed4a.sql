-- Adminer 4.8.1 MySQL 10.9.6-MariaDB-1:10.9.6+maria~deb10 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_login` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`admin_login`) VALUES
('admin_test'),

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_email` char(100) NOT NULL,
  `message_subject` char(100) NOT NULL,
  `message_message` text NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `message` (`message_id`, `message_email`, `message_subject`, `message_message`) VALUES
(1,	'example@example.fr',	'example_subject',	'example_message'),

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_dateStart` timestamp NOT NULL DEFAULT current_timestamp(),
  `reservation_dateEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reservation_isAccepted` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_login` char(20) NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reservation` (`reservation_id`, `reservation_dateStart`, `reservation_dateEnd`, `reservation_isAccepted`, `room_id`, `user_login`) VALUES
(1,	'2023-06-19 09:13:26',	'2023-06-19 08:00:00',	0,	1,	''),
(2,	'2023-06-20 13:13:41',	'2023-06-20 16:00:00',	1,	5,	''),
(3,	'2023-06-22 06:00:00',	'2023-06-22 08:00:00',	0,	9,	'');

DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` char(30) NOT NULL,
  `room_teacherComputer` bit(1) NOT NULL,
  `room_studentComputer` bit(1) NOT NULL,
  `room_adobe` bit(1) NOT NULL,
  `room_linux` bit(1) NOT NULL,
  `room_ssd` bit(1) NOT NULL,
  `room_projector` bit(1) NOT NULL,
  `room_noComputer` bit(1) NOT NULL,
  `room_drawing` bit(1) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `room` (`room_id`, `room_name`, `room_teacherComputer`, `room_studentComputer`, `room_adobe`, `room_linux`, `room_ssd`, `room_projector`, `room_noComputer`, `room_drawing`) VALUES
(1,	'SSD',	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(2,	'502',	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(3,	'503',	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(4,	'504',	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(5,	'506',	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(6,	'507',	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(7,	'601',	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(8,	'602',	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(9,	'603',	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(10,	'603b',	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(11,	'604',	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(12,	'605',	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(13,	'606',	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0),
(14,	'101',	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0),
(15,	'102',	CONV('1', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0,	CONV('1', 2, 10) + 0);

-- 2023-06-19 08:48:05
