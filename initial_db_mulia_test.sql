CREATE DATABASE `mulia_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

-- mulia_test.attachment definition

CREATE TABLE `attachment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inv_id` int(11) DEFAULT NULL,
  `attachment_img` longtext DEFAULT NULL,
  `attachment_ext` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- mulia_test.invoice definition

CREATE TABLE `invoice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inv_number` varchar(255) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `period` varchar(7) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `total_qty` int(100) DEFAULT NULL,
  `total_cost` int(100) DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- mulia_test.items definition

CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inv_id` int(11) NOT NULL,
  `inv_number` varchar(255) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(100) DEFAULT NULL,
  `price` int(100) DEFAULT NULL,
  `total` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- mulia_test.roles definition

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- mulia_test.users definition

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_vendor` tinyint(1) DEFAULT NULL,
  `role_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- mulia_test.vendor definition

CREATE TABLE `vendor` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `vendor_code` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `user_id` int(25) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO mulia_test.users
(id, fullname, email, username, password, is_vendor, role_id, created_at, updated_at)
VALUES(1, 'superadmin', 'superadmin@mail.com', 'superadmin', '$2a$12$RhQ0Py1KKJ.KdBq4EXdmbOnAPByYy.MO5iiCjB8XVnV0tw5/AhRPi', NULL, 1, '2025-07-04 01:06:16.000', NULL);

INSERT INTO mulia_test.roles
(id, name)
VALUES(1, 'superadmin');
INSERT INTO mulia_test.roles
(id, name)
VALUES(2, 'admin');
INSERT INTO mulia_test.roles
(id, name)
VALUES(3, 'user');