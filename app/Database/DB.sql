DROP DATABASE IF EXISTS ixenit;

CREATE DATABASE IF NOT EXISTS ixenit 
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_general_ci;

USE ixenit;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS user_address;
DROP TABLE IF EXISTS user_contact;

CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_address` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `zip_code` int NOT NULL,
  `address_line` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,  
  `temp_zip_code` int DEFAULT 0,
  `temp_address_line` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `temp_city` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,  
  PRIMARY KEY (`address_id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_contact` (
  `contact_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `contact_data` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_type` int DEFAULT '0',
  PRIMARY KEY (`contact_id`),  
  CONSTRAINT `user_contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;