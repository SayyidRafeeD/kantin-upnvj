CREATE DATABASE IF NOT EXISTS db_kantin_upnvj CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_kantin_upnvj;

CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `nim` VARCHAR(50) NOT NULL UNIQUE,
  `full_name` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `canteens` (
  `canteen_id` INT AUTO_INCREMENT PRIMARY KEY,
  `canteen_name` VARCHAR(100) NOT NULL,
  `location` VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE `stores` (
  `store_id` INT AUTO_INCREMENT PRIMARY KEY,
  `canteen_id` INT NOT NULL,
  `store_name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `image_url` VARCHAR(255) NULL,
  FOREIGN KEY (`canteen_id`) REFERENCES `canteens`(`canteen_id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `menu_items` (
  `item_id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT NOT NULL,
  `item_name` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`store_id`) REFERENCES `stores`(`store_id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `votes` (
  `vote_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `store_id` INT NOT NULL,
  `vote_date` DATE NOT NULL DEFAULT (CURRENT_DATE),
  `vote_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`store_id`) REFERENCES `stores`(`store_id`) ON DELETE CASCADE,

  UNIQUE KEY `daily_vote_limit` (`user_id`, `store_id`, `vote_date`)
) ENGINE=InnoDB;

CREATE TABLE `comments` (
  `comment_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `store_id` INT NOT NULL,
  `comment_text` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`store_id`) REFERENCES `stores`(`store_id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `login_logs` (
  `log_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `login_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB;