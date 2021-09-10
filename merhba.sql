-- Adminer 4.8.0 MySQL 5.7.31-0ubuntu0.18.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `new`;
CREATE TABLE `new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cityID` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `source` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `ProductReference` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `productID` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `duplicated_at` timestamp NULL DEFAULT NULL,
  `statue` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `options` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1,	'settings_form',	'true',	'2021-01-26 11:44:19',	'2021-01-26 11:44:19'),
(2,	'color',	'#ffae00',	'2021-01-26 11:44:19',	'2021-01-26 11:44:19'),
(3,	'whatsapp',	'off',	'2021-01-26 11:44:19',	'2021-01-26 11:44:19'),
(4,	'footer_img',	'on',	'2021-01-26 11:44:19',	'2021-01-26 12:05:11'),
(5,	'banner_footer',	'q5QJ99ZgjCCMzCOVt0k8.jpg',	'2021-01-26 11:46:20',	'2021-01-26 11:46:20'),
(6,	'contact_form',	'true',	'2021-01-26 11:51:44',	'2021-01-26 11:51:44'),
(7,	'contact_icon',	'on',	'2021-01-26 11:51:44',	'2021-01-26 11:51:44'),
(8,	'whatsapp_number',	'0661472815',	'2021-01-26 11:51:44',	'2021-01-26 11:51:44'),
(9,	'phone_number',	'0661472815',	'2021-01-26 11:51:44',	'2021-01-26 11:51:44'),
(10,	'messenger_link',	'https://www.facebook.com/Merhba-101247705318725/inbox',	'2021-01-26 11:51:44',	'2021-01-26 11:51:44'),
(11,	'fb_link',	'https://www.facebook.com/Merhba-101247705318725/',	'2021-01-26 11:53:40',	'2021-01-26 11:53:40'),
(12,	'instagram_link',	'https://www.facebook.com/Merhba-101247705318725/',	'2021-01-26 11:53:40',	'2021-01-26 11:53:40'),
(13,	'name',	'merhba',	'2021-01-26 11:54:04',	'2021-01-26 11:54:04'),
(14,	'tagline',	'مرحبا بكم في أحسن متجر الكتروني بالمغرب من ناخية جودة المنتجات يمكنكم الاتصال بنا ',	'2021-01-26 11:54:04',	'2021-01-26 11:54:04'),
(15,	'phone',	'0661472815',	'2021-01-26 11:54:04',	'2021-01-26 11:54:04'),
(16,	'pixel',	'',	'2021-04-17 11:19:39',	'2021-04-17 11:28:32');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` text,
  `stock` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `prix_jmla` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `description` text,
  `thumbnail` varchar(500) DEFAULT NULL,
  `gallery` text,
  `discount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `categoryID` varchar(500) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `price_2` varchar(255) DEFAULT NULL,
  `show_home` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `productscategories`;
CREATE TABLE `productscategories` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `productscategories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`, `active`) VALUES
(2,	'الضروريات ',	'urgant',	'PFEUYhd6YqG7n1pQuqAD.jpg',	'2021-01-26 12:19:48',	'2021-01-26 12:19:48',	'1'),
(3,	'الموضة والاناقة',	'moda',	'mIwc7EYBjB9ZUGyO2oqc.jpg',	'2021-01-26 12:20:29',	'2021-01-26 12:21:33',	'1'),
(4,	'مطبخ',	'cuisine',	'IVuT3hGCfen62LmRVvrB.png',	'2021-01-26 12:20:47',	'2021-01-26 12:20:47',	'1'),
(5,	'اكسيسوار السيارت ',	'voiture',	'J6EofnzMZSy5UjVoFG4I.jpg',	'2021-01-26 12:21:13',	'2021-01-26 12:21:13',	'1'),
(6,	'الجمال والصحة',	'jamalok ',	'BneXckU2GUEcb7FPt3L1.jpg',	'2021-01-26 12:22:00',	'2021-01-26 12:22:00',	'1');

DROP TABLE IF EXISTS `slider`;
CREATE TABLE `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `slider` (`id`, `image`, `created_at`, `updated_at`, `link`) VALUES
(2,	'2JQRWkioYUpX5JGhlG6f.jpg',	'2021-01-26 11:55:02',	'2021-01-26 11:55:02',	'');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `statue` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `deliver_price` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `statue`, `username`, `full_name`, `email`, `password`, `created_at`, `phone`, `role`, `code`, `deliver_price`, `city`, `updated_at`) VALUES
(10000,	'supper',	'admin',	'admin',	'admin@admin.com',	'123456ae',	'2018-08-20 19:59:10',	'0624097078',	'admin',	'',	'',	'',	'2020-11-22 22:15:07');

-- 2021-04-27 11:40:25