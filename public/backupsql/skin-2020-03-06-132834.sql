DROP TABLE backup_settings;

CREATE TABLE `backup_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `backup_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO backup_settings VALUES("10","skin-2020-03-06-115521.sql","2020-03-06","11:55:21","2020-03-06 03:55:21","2020-03-06 03:55:21");



DROP TABLE billings;

CREATE TABLE `billings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `box_id` int(11) DEFAULT NULL,
  `cheque_number` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month_covered` date DEFAULT NULL,
  `amount` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO billings VALUES("1","20","","","2020-03-30","600.00","2020-03-06 01:55:37","2020-03-06 01:55:37");



DROP TABLE box_managements;

CREATE TABLE `box_managements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `renter_id` int(11) DEFAULT NULL,
  `branch` int(11) DEFAULT NULL,
  `box_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_contract` date DEFAULT NULL,
  `end_of_contract` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `description` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rental_cost` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO box_managements VALUES("2","2","1","2","2018-07-21","2019-01-21","2018-08-21","","500.00","2020-02-06 04:53:42","2020-02-06 04:53:42");
INSERT INTO box_managements VALUES("3","3","1","3","2018-07-21","2019-01-21","2018-08-21","","500.00","2020-02-06 04:54:15","2020-02-06 04:54:15");
INSERT INTO box_managements VALUES("4","4","1","4","2018-07-21","2019-01-21","2018-08-21","","500.00","2020-02-06 05:01:55","2020-02-06 05:01:55");
INSERT INTO box_managements VALUES("5","5","1","4","2019-01-08","2019-07-08","2019-02-08","","550.00","2020-02-06 05:02:45","2020-02-06 05:11:39");
INSERT INTO box_managements VALUES("7","6","1","5","2019-03-25","2019-09-25","2019-04-25","","550.00","2020-02-06 05:11:29","2020-02-06 05:11:29");
INSERT INTO box_managements VALUES("8","7","1","5","2018-07-28","2019-01-28","2018-08-21","","500.00","2020-02-06 05:12:18","2020-02-06 05:12:18");
INSERT INTO box_managements VALUES("9","8","1","6","2018-07-24","2019-01-24","2018-08-24","","500.00","2020-02-06 05:13:24","2020-02-06 05:13:24");
INSERT INTO box_managements VALUES("10","9","1","7","2018-08-18","2018-02-18","2018-09-18","","500.00","2020-02-06 05:24:01","2020-02-06 05:24:01");
INSERT INTO box_managements VALUES("11","10","1","8","2018-08-02","2019-02-02","2018-09-02","","600.00","2020-02-06 05:24:44","2020-02-06 05:24:44");
INSERT INTO box_managements VALUES("12","11","1","9","2018-07-21","2019-01-21","2018-08-21","","600.00","2020-02-06 05:25:44","2020-02-06 05:25:44");
INSERT INTO box_managements VALUES("13","12","1","10","2018-07-21","2019-01-21","2018-08-21","","600.00","2020-02-06 05:31:16","2020-02-06 05:31:16");
INSERT INTO box_managements VALUES("14","13","1","9","2019-01-25","2019-07-25","2019-02-25","","550.00","2020-02-06 05:32:02","2020-02-06 05:32:02");
INSERT INTO box_managements VALUES("15","14","1","10","2019-04-03","2019-10-03","2019-05-03","","600.00","2020-02-06 05:32:50","2020-02-06 05:32:50");
INSERT INTO box_managements VALUES("16","15","1","10","2018-11-20","2019-05-10","2018-12-20","","600.00","2020-02-06 05:33:21","2020-02-06 05:33:21");
INSERT INTO box_managements VALUES("17","16","1","11","2018-08-19","2019-02-19","2018-09-12","","600.00","2020-02-06 05:34:01","2020-02-06 05:34:01");
INSERT INTO box_managements VALUES("18","17","1","11","2018-12-06","2019-06-06","2019-01-06","","600.00","2020-02-06 05:34:42","2020-02-06 05:34:42");
INSERT INTO box_managements VALUES("19","18","1","12","2018-08-30","2019-02-28","2018-09-30","","500.00","2020-02-06 05:35:44","2020-02-06 05:35:44");
INSERT INTO box_managements VALUES("20","19","1","13","2018-10-28","2019-04-25","2018-11-25","","600.00","2020-02-06 05:36:19","2020-02-06 05:36:19");
INSERT INTO box_managements VALUES("21","20","1","14","2018-08-09","2019-02-09","2018-09-09","","550.00","2020-02-06 05:37:03","2020-02-06 05:37:03");
INSERT INTO box_managements VALUES("22","21","1","11","2019-08-09","2020-02-09","2019-09-09","","550.00","2020-02-06 05:38:15","2020-02-07 03:07:38");
INSERT INTO box_managements VALUES("23","22","1","15","2019-09-25","2020-12-05","2020-10-25","","550.00","2020-02-06 05:39:13","2020-02-19 01:50:49");
INSERT INTO box_managements VALUES("24","30","1","20","2018-08-31","2020-03-28","2020-09-30","","500.00","2020-02-06 05:45:06","2020-02-06 05:45:06");
INSERT INTO box_managements VALUES("25","30","1","21","2018-08-31","2020-03-28","2020-09-30","","500.00","2020-02-06 05:45:50","2020-03-05 09:04:04");
INSERT INTO box_managements VALUES("26","32","1","23","2019-08-09","2020-02-09","2019-09-09","","550.00","2020-02-06 06:06:27","2020-02-07 04:08:03");



DROP TABLE boxes;

CREATE TABLE `boxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `box_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO boxes VALUES("1","LSU#1","","1","2020-02-06 02:01:15","2020-03-06 02:01:57");
INSERT INTO boxes VALUES("2","LSU#2","","4","2020-02-06 02:01:22","2020-02-06 02:01:22");
INSERT INTO boxes VALUES("3","LSU#3","","4","2020-02-06 02:19:02","2020-02-06 02:19:02");
INSERT INTO boxes VALUES("4","LSU#4","","4","2020-02-06 02:19:08","2020-02-06 02:19:08");
INSERT INTO boxes VALUES("5","LSU#5","","4","2020-02-06 02:19:16","2020-02-06 02:19:16");
INSERT INTO boxes VALUES("6","LSU#6","","4","2020-02-06 02:22:43","2020-02-06 02:22:43");
INSERT INTO boxes VALUES("7","LSU#7","","4","2020-02-06 02:22:52","2020-02-06 02:22:52");
INSERT INTO boxes VALUES("8","LSE#1","","4","2020-02-06 02:23:01","2020-02-06 02:23:01");
INSERT INTO boxes VALUES("9","LSE#2","","0","2020-02-06 02:23:07","2020-02-06 02:23:07");
INSERT INTO boxes VALUES("10","LSE#3","","0","2020-02-06 02:23:13","2020-02-06 02:23:13");
INSERT INTO boxes VALUES("11","LSE#4","","0","2020-02-06 02:23:23","2020-02-06 02:23:23");
INSERT INTO boxes VALUES("12","LSE#5","","0","2020-02-06 02:23:28","2020-02-06 02:23:28");
INSERT INTO boxes VALUES("13","LSE#6","","0","2020-02-06 02:23:35","2020-02-06 02:23:35");
INSERT INTO boxes VALUES("14","LSL#1","","0","2020-02-06 02:23:55","2020-02-06 02:23:55");
INSERT INTO boxes VALUES("15","LSL#2","","0","2020-02-06 02:24:01","2020-02-06 02:24:01");
INSERT INTO boxes VALUES("16","LSL#3","","0","2020-02-06 02:24:08","2020-02-06 02:24:08");
INSERT INTO boxes VALUES("17","LSL#4","","0","2020-02-06 02:24:14","2020-02-06 02:24:14");
INSERT INTO boxes VALUES("18","LSL#5","","0","2020-02-06 02:24:21","2020-02-06 02:24:21");
INSERT INTO boxes VALUES("19","LSL#6","","0","2020-02-06 02:24:29","2020-02-06 02:24:29");
INSERT INTO boxes VALUES("20","LSLD#1A","","0","2020-02-06 02:25:03","2020-02-06 02:25:03");
INSERT INTO boxes VALUES("21","LSLD#1B","","0","2020-02-06 02:25:08","2020-02-06 02:25:08");
INSERT INTO boxes VALUES("22","LSLD#1C","","0","2020-02-06 02:25:15","2020-02-06 02:25:15");
INSERT INTO boxes VALUES("23","LSLD#1D","","0","2020-02-06 02:25:21","2020-02-06 02:25:21");
INSERT INTO boxes VALUES("24","LSLD#2A","","0","2020-02-06 02:25:28","2020-02-06 02:25:28");
INSERT INTO boxes VALUES("25","LSLD#2B","","0","2020-02-06 02:25:33","2020-02-06 02:25:33");
INSERT INTO boxes VALUES("26","LSLD#2C","0","0","2020-02-06 02:25:38","2020-02-06 02:25:38");
INSERT INTO boxes VALUES("27","LSLD#2D","0","0","2020-02-06 02:25:44","2020-02-06 02:25:44");
INSERT INTO boxes VALUES("28","LSLD#3A","0","0","2020-02-06 02:26:01","2020-02-06 02:26:01");
INSERT INTO boxes VALUES("29","LSLD#3B","0","0","2020-02-06 02:26:07","2020-02-06 02:26:07");
INSERT INTO boxes VALUES("30","LSLD#3C","0","0","2020-02-06 02:26:12","2020-02-06 02:26:12");
INSERT INTO boxes VALUES("32","LSLD#3D","0","0","2020-02-06 05:09:54","2020-02-06 05:09:54");



DROP TABLE branches;

CREATE TABLE `branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO branches VALUES("1","DCLA","Door 16-17, Gate 8, DCLA, Uyanguren, Davao City","09478478526","Jason","2020-02-04 22:23:38","2020-02-04 22:23:38");
INSERT INTO branches VALUES("4","MATINA","Matina Aplaya","09478478526","Jason","2020-02-29 01:47:27","2020-03-05 09:00:57");



DROP TABLE categories;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories VALUES("3","Soap","","2020-02-06 03:21:52","2020-02-06 03:28:38");
INSERT INTO categories VALUES("4","Food","","2020-02-06 03:22:08","2020-02-06 03:22:08");
INSERT INTO categories VALUES("5","Whitening","","2020-02-06 03:25:33","2020-02-06 03:25:33");
INSERT INTO categories VALUES("6","Cream","","2020-02-06 03:25:46","2020-02-06 03:28:21");
INSERT INTO categories VALUES("7","Sunblock","","2020-02-06 03:25:56","2020-02-06 03:31:12");
INSERT INTO categories VALUES("8","Vitamins","","2020-02-06 03:31:45","2020-02-06 03:31:45");
INSERT INTO categories VALUES("9","Hair","","2020-02-06 03:31:58","2020-02-06 03:31:58");
INSERT INTO categories VALUES("10","Oil","","2020-02-06 03:32:05","2020-02-06 03:32:05");
INSERT INTO categories VALUES("11","Toner","","2020-02-06 03:32:14","2020-02-06 03:32:14");
INSERT INTO categories VALUES("12","Mask","","2020-02-06 03:32:29","2020-02-06 03:32:29");
INSERT INTO categories VALUES("13","Shampoo","","2020-02-06 03:32:43","2020-02-06 03:32:43");
INSERT INTO categories VALUES("14","Skin care","","2020-02-06 03:32:56","2020-02-06 03:32:56");
INSERT INTO categories VALUES("15","Eye","","2020-02-06 03:33:22","2020-02-06 03:33:22");
INSERT INTO categories VALUES("16","Lotion","","2020-02-06 03:33:36","2020-02-06 03:33:36");
INSERT INTO categories VALUES("17","Containers","","2020-02-06 03:33:44","2020-02-06 03:33:44");
INSERT INTO categories VALUES("18","Perfume","","2020-02-06 03:34:05","2020-02-06 03:34:05");
INSERT INTO categories VALUES("19","Make up","","2020-02-06 03:34:16","2020-02-06 03:34:16");
INSERT INTO categories VALUES("20","Set","","2020-02-06 03:34:34","2020-02-06 03:34:34");
INSERT INTO categories VALUES("21","Lipstick","","2020-02-06 03:34:50","2020-02-06 03:34:50");
INSERT INTO categories VALUES("22","Liptint","","2020-02-06 03:34:55","2020-02-06 03:34:55");
INSERT INTO categories VALUES("23","Nail","","2020-02-06 03:35:24","2020-02-06 03:35:24");
INSERT INTO categories VALUES("24","Underarm","","2020-02-06 03:35:42","2020-02-06 03:35:42");
INSERT INTO categories VALUES("25","Serum","","2020-02-06 03:35:58","2020-02-06 03:35:58");
INSERT INTO categories VALUES("26","Body wash","","2020-02-06 03:36:07","2020-02-06 03:36:07");
INSERT INTO categories VALUES("27","Rejuvenating","","2020-02-06 03:58:13","2020-02-06 03:58:13");
INSERT INTO categories VALUES("28","Powder","","2020-02-06 05:56:33","2020-02-06 05:56:33");
INSERT INTO categories VALUES("29","Face","","2020-02-06 05:56:37","2020-02-06 05:56:37");



DROP TABLE failed_jobs;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE inventories;

CREATE TABLE `inventories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `note` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO inventories VALUES("1","23","3","120","2020-02-06","","","2020-02-06 06:15:18","2020-02-06 06:15:18");
INSERT INTO inventories VALUES("2","23","4","200","2020-02-06","","","2020-02-06 06:15:46","2020-02-06 06:15:46");
INSERT INTO inventories VALUES("3","23","5","210","2020-02-06","","","2020-02-06 06:16:02","2020-02-06 06:16:02");
INSERT INTO inventories VALUES("4","23","6","230","2020-02-06","","","2020-02-06 06:16:17","2020-02-06 06:16:17");
INSERT INTO inventories VALUES("5","23","7","300","2020-02-06","","","2020-02-06 06:16:30","2020-02-06 06:16:30");
INSERT INTO inventories VALUES("6","26","8","50","2020-02-06","","","2020-02-06 06:16:46","2020-02-06 06:16:46");
INSERT INTO inventories VALUES("7","26","9","50","2020-02-06","","","2020-02-06 06:16:58","2020-02-06 06:16:58");
INSERT INTO inventories VALUES("8","26","10","100","2020-02-06","","","2020-02-06 06:17:10","2020-02-06 06:17:10");
INSERT INTO inventories VALUES("9","26","11","150","2020-02-06","","","2020-02-06 06:17:22","2020-02-06 06:17:22");
INSERT INTO inventories VALUES("10","26","12","180","2020-02-06","","","2020-02-06 06:17:39","2020-02-06 06:17:39");
INSERT INTO inventories VALUES("11","23","7","3","2020-02-06","","","2020-02-06 09:53:40","2020-02-06 09:53:40");
INSERT INTO inventories VALUES("14","28","3","2","2020-02-29","","","2020-02-29 05:28:51","2020-02-29 05:28:51");
INSERT INTO inventories VALUES("15","28","20","5","2020-02-29","","test","2020-02-29 06:48:40","2020-02-29 06:48:40");



DROP TABLE migrations;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO migrations VALUES("2","2014_10_12_100000_create_password_resets_table","1");
INSERT INTO migrations VALUES("3","2016_06_01_000001_create_oauth_auth_codes_table","1");
INSERT INTO migrations VALUES("4","2016_06_01_000002_create_oauth_access_tokens_table","1");
INSERT INTO migrations VALUES("5","2016_06_01_000003_create_oauth_refresh_tokens_table","1");
INSERT INTO migrations VALUES("6","2016_06_01_000004_create_oauth_clients_table","1");
INSERT INTO migrations VALUES("7","2016_06_01_000005_create_oauth_personal_access_clients_table","1");
INSERT INTO migrations VALUES("8","2019_08_19_000000_create_failed_jobs_table","1");
INSERT INTO migrations VALUES("9","2020_01_20_052646_create_branches_table","1");
INSERT INTO migrations VALUES("10","2020_01_20_053144_create_renters_table","1");
INSERT INTO migrations VALUES("11","2020_01_20_053157_create_boxes_table","1");
INSERT INTO migrations VALUES("12","2020_01_21_020917_create_categories_table","1");
INSERT INTO migrations VALUES("13","2020_01_21_024817_create_rents_table","1");
INSERT INTO migrations VALUES("14","2020_01_21_025032_create_billings_table","1");
INSERT INTO migrations VALUES("15","2020_01_21_051608_create_products_table","1");
INSERT INTO migrations VALUES("16","2020_01_21_052421_create_product_categories_table","1");
INSERT INTO migrations VALUES("17","2020_01_21_052822_create_product_pictures_table","1");
INSERT INTO migrations VALUES("19","2020_01_23_082613_create_return_products_table","1");
INSERT INTO migrations VALUES("20","2020_01_24_033034_create_inventories_table","1");
INSERT INTO migrations VALUES("21","2020_01_31_015727_create_sales_table","1");
INSERT INTO migrations VALUES("22","2020_01_31_015750_create_sale_products_table","1");
INSERT INTO migrations VALUES("23","2020_02_04_032323_create_return_sales_table","1");
INSERT INTO migrations VALUES("25","2020_01_23_053804_create_box_managements_table","2");
INSERT INTO migrations VALUES("34","2020_02_07_085821_create_voucher_products_table","3");
INSERT INTO migrations VALUES("36","2020_02_07_084512_create_voucher_coupons_table","4");
INSERT INTO migrations VALUES("37","2014_10_12_000000_create_users_table","5");
INSERT INTO migrations VALUES("38","2020_03_06_021717_create_settings_table","6");
INSERT INTO migrations VALUES("39","2020_03_06_032754_create_backup_settings_table","7");



DROP TABLE oauth_access_tokens;

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE oauth_auth_codes;

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE oauth_clients;

CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE oauth_personal_access_clients;

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE oauth_refresh_tokens;

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE password_resets;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE product_categories;

CREATE TABLE `product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO product_categories VALUES("51","16","3","2020-02-10 07:43:47","2020-02-10 07:43:47");
INSERT INTO product_categories VALUES("92","5","21","2020-03-05 03:11:51","2020-03-05 03:11:51");
INSERT INTO product_categories VALUES("93","6","5","2020-03-05 03:11:56","2020-03-05 03:11:56");
INSERT INTO product_categories VALUES("94","6","29","2020-03-05 03:11:56","2020-03-05 03:11:56");
INSERT INTO product_categories VALUES("95","6","28","2020-03-05 03:11:56","2020-03-05 03:11:56");
INSERT INTO product_categories VALUES("96","7","21","2020-03-05 03:12:01","2020-03-05 03:12:01");
INSERT INTO product_categories VALUES("97","8","3","2020-03-05 03:12:06","2020-03-05 03:12:06");
INSERT INTO product_categories VALUES("98","9","20","2020-03-05 03:12:13","2020-03-05 03:12:13");
INSERT INTO product_categories VALUES("99","10","29","2020-03-05 03:12:18","2020-03-05 03:12:18");
INSERT INTO product_categories VALUES("100","10","6","2020-03-05 03:12:18","2020-03-05 03:12:18");
INSERT INTO product_categories VALUES("101","11","3","2020-03-05 03:12:25","2020-03-05 03:12:25");
INSERT INTO product_categories VALUES("102","11","5","2020-03-05 03:12:25","2020-03-05 03:12:25");
INSERT INTO product_categories VALUES("103","11","14","2020-03-05 03:12:25","2020-03-05 03:12:25");
INSERT INTO product_categories VALUES("104","12","3","2020-03-05 03:12:30","2020-03-05 03:12:30");
INSERT INTO product_categories VALUES("105","12","5","2020-03-05 03:12:30","2020-03-05 03:12:30");
INSERT INTO product_categories VALUES("106","12","14","2020-03-05 03:12:30","2020-03-05 03:12:30");
INSERT INTO product_categories VALUES("107","3","3","2020-03-05 03:25:19","2020-03-05 03:25:19");
INSERT INTO product_categories VALUES("108","4","3","2020-03-05 03:25:27","2020-03-05 03:25:27");
INSERT INTO product_categories VALUES("109","4","5","2020-03-05 03:25:27","2020-03-05 03:25:27");
INSERT INTO product_categories VALUES("110","4","14","2020-03-05 03:25:27","2020-03-05 03:25:27");
INSERT INTO product_categories VALUES("112","20","3","2020-03-05 03:25:48","2020-03-05 03:25:48");



DROP TABLE product_pictures;

CREATE TABLE `product_pictures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `picture` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO product_pictures VALUES("42","5","Female Beauty.jpg","2020-03-05 03:11:51","2020-03-05 03:11:51");
INSERT INTO product_pictures VALUES("43","6","Female Beauty.jpg","2020-03-05 03:11:56","2020-03-05 03:11:56");
INSERT INTO product_pictures VALUES("44","7","Female Beauty.jpg","2020-03-05 03:12:01","2020-03-05 03:12:01");
INSERT INTO product_pictures VALUES("45","9","Female Beauty.jpg","2020-03-05 03:12:13","2020-03-05 03:12:13");
INSERT INTO product_pictures VALUES("46","11","Female Beauty.jpg","2020-03-05 03:12:25","2020-03-05 03:12:25");
INSERT INTO product_pictures VALUES("47","4","Female Beauty.jpg","2020-03-05 03:25:27","2020-03-05 03:25:27");



DROP TABLE products;

CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_price` double(15,2) DEFAULT NULL,
  `sell_price` double(15,2) DEFAULT NULL,
  `stock_level` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `renter_id` int(11) DEFAULT NULL,
  `brand` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products VALUES("4","4800131592209","Kojic","180.00","250.00","instock","23","Elyk Kojic","soap, whitening, skin, kojic","","1","2020-02-06 05:53:39","2020-03-05 03:25:27");
INSERT INTO products VALUES("5","4800131592201","Liquid Lip Stick","150.00","180.00","instock","23","Elyk Lippy","lip stick, lips","","1","2020-02-06 05:54:47","2020-03-05 03:11:51");
INSERT INTO products VALUES("6","4800131592202","Powder Tint","130.00","150.00","instock","23","Elyk Powder Tint","powder, tint, face, blush","","1","2020-02-06 05:56:09","2020-03-05 03:11:56");
INSERT INTO products VALUES("7","4800131592203","Lip Stick","280.00","300.00","instock","23","Elyk Lip Stick","lip stick, lips","","1","2020-02-06 05:59:54","2020-03-05 03:12:01");
INSERT INTO products VALUES("8","4800131592204","Set A","650.00","850.00","instock","23","Brently Set A","set, beauty","","1","2020-02-06 06:09:23","2020-03-05 03:12:06");
INSERT INTO products VALUES("9","4800131592205","Set B","1250.00","1400.00","instock","26","Brently Set B","set, beauty","","1","2020-02-06 06:10:27","2020-03-05 03:12:13");
INSERT INTO products VALUES("10","4800131592206","Facial Foam","350.00","450.00","instock","26","Brently Facial Foam","facial foam, face, skin care","","1","2020-03-06 06:11:14","2020-03-05 03:12:18");



DROP TABLE renters;

CREATE TABLE `renters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_registered` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO renters VALUES("1","Marycel","","09105421467","","2018-08-09","2020-02-04 22:24:15","2020-02-04 22:24:15");
INSERT INTO renters VALUES("2","Zenaida","","09307468410","","2018-07-21","2020-02-04 22:24:38","2020-02-04 22:24:38");
INSERT INTO renters VALUES("3","Mayumi","","09468272178","","2018-07-21","2020-02-04 22:24:58","2020-02-04 22:24:58");
INSERT INTO renters VALUES("4","Jans","","0928390899","","2018-07-21","2020-02-04 22:25:19","2020-02-04 22:25:19");
INSERT INTO renters VALUES("5","Mary Ken","","","","2019-01-08","2020-02-04 22:26:03","2020-02-04 22:35:03");
INSERT INTO renters VALUES("6","Carl Peanuts","","09982974297","","2019-03-25","2020-02-04 22:26:28","2020-02-04 22:26:28");
INSERT INTO renters VALUES("7","Vanity Corner","","0917340993","","2018-07-28","2020-02-04 22:26:57","2020-02-04 22:26:57");
INSERT INTO renters VALUES("8","Cuber","","09956052703","","2018-07-24","2020-02-04 22:27:36","2020-02-04 22:27:36");
INSERT INTO renters VALUES("9","Delis Peanut","","09758063546","","2018-08-18","2020-02-04 22:28:04","2020-02-04 22:28:04");
INSERT INTO renters VALUES("10","Healthy","","","","2018-08-02","2020-02-04 22:28:25","2020-02-04 22:28:25");
INSERT INTO renters VALUES("11","Joshin","","09061333439","","2018-07-21","2020-02-04 22:28:52","2020-02-04 22:28:52");
INSERT INTO renters VALUES("12","Christa","","09952224780","","2018-07-21","2020-02-04 22:29:07","2020-02-04 22:29:07");
INSERT INTO renters VALUES("13","Zaphira","","09089724873","","2019-01-25","2020-02-04 22:29:30","2020-02-04 22:29:30");
INSERT INTO renters VALUES("14","Placenta","","09061236340","","2019-04-03","2020-02-04 22:29:57","2020-02-04 22:29:57");
INSERT INTO renters VALUES("15","Joann Te","","","","2018-11-10","2020-02-04 22:30:13","2020-02-04 22:30:13");
INSERT INTO renters VALUES("16","Chicville","","09099349059","","2018-08-19","2020-02-04 22:30:47","2020-02-04 22:30:47");
INSERT INTO renters VALUES("17","Yanie","","09338650499","","2018-12-06","2020-02-04 22:31:21","2020-02-04 22:31:21");
INSERT INTO renters VALUES("18","Theb","","09213376020","","2018-08-30","2020-02-04 22:31:40","2020-02-04 22:31:40");
INSERT INTO renters VALUES("19","RK","","09279114678","","2018-10-25","2020-02-04 22:31:57","2020-02-04 22:31:57");
INSERT INTO renters VALUES("20","Jen Yap","","09176743843","","2018-08-09","2020-02-04 22:32:15","2020-02-04 22:32:15");
INSERT INTO renters VALUES("21","Darlen","","09303357777","","2019-08-09","2020-02-04 22:32:34","2020-02-04 22:32:34");
INSERT INTO renters VALUES("22","Elyk","","09297286861","","2019-09-25","2020-02-04 22:32:53","2020-02-04 22:32:53");
INSERT INTO renters VALUES("23","Joey","","","","2018-11-17","2020-02-04 22:33:15","2020-02-04 22:33:15");
INSERT INTO renters VALUES("24","Jane","","09499925439","","2018-07-28","2020-02-04 22:33:33","2020-02-04 22:33:33");
INSERT INTO renters VALUES("25","Ann","","","","2019-03-04","2020-02-04 22:33:45","2020-02-04 22:33:45");
INSERT INTO renters VALUES("26","LoveUrSkin","","09284913436","","2018-08-22","2020-02-04 22:34:09","2020-02-04 22:34:09");
INSERT INTO renters VALUES("27","Thea Mae  / Millineal","","","","2019-05-05","2020-02-04 22:39:36","2020-02-04 22:39:36");
INSERT INTO renters VALUES("28","Sialiliaph","","09213376020","","2018-08-23","2020-02-04 22:40:11","2020-02-04 22:40:11");
INSERT INTO renters VALUES("29","Amay Banosan","","09213376020","","2018-08-24","2020-02-04 22:40:34","2020-02-04 22:40:34");
INSERT INTO renters VALUES("30","Claire\'s Closet","","09993163797","","2018-08-31","2020-02-04 22:41:08","2020-02-04 22:41:08");
INSERT INTO renters VALUES("31","Carina","","","","2019-02-16","2020-02-04 22:41:58","2020-02-04 22:41:58");
INSERT INTO renters VALUES("32","Brently","","09664622874","","2019-08-09","2020-02-04 22:42:25","2020-02-04 22:42:25");
INSERT INTO renters VALUES("33","Beauty Treats PH","","09284913436","","2018-08-27","2020-02-04 22:44:18","2020-02-04 22:44:18");



DROP TABLE rents;

CREATE TABLE `rents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `renter_id` int(11) DEFAULT NULL,
  `box_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO rents VALUES("1","22","15","2020-03-25","Unpaid","2020-03-05 09:14:24","2020-03-05 09:14:24");
INSERT INTO rents VALUES("2","30","20","2020-03-30","Paid","2020-03-05 09:14:24","2020-03-05 09:14:24");
INSERT INTO rents VALUES("3","30","21","2020-03-30","Unpaid","2020-03-05 09:14:24","2020-03-05 09:14:24");
INSERT INTO rents VALUES("4","22","15","2020-04-25","Unpaid","2020-03-05 09:14:34","2020-03-05 09:14:34");
INSERT INTO rents VALUES("5","22","15","2020-05-25","Unpaid","2020-03-05 09:14:43","2020-03-05 09:14:43");
INSERT INTO rents VALUES("6","22","15","2020-08-25","Unpaid","2020-03-05 09:14:53","2020-03-05 09:14:53");
INSERT INTO rents VALUES("7","22","15","2020-06-25","Unpaid","2020-03-05 09:15:16","2020-03-05 09:15:16");



DROP TABLE return_products;

CREATE TABLE `return_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `note` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO return_products VALUES("1","23","7","1","2020-02-07","1","","2020-02-06 09:14:59","2020-02-06 09:50:06");
INSERT INTO return_products VALUES("2","26","10","1","2020-02-07","","","2020-02-06 09:33:58","2020-02-06 09:33:58");
INSERT INTO return_products VALUES("3","23","7","2","2020-02-06","","","2020-02-06 09:49:15","2020-02-06 09:49:15");
INSERT INTO return_products VALUES("4","28","3","20","2020-02-29","","test","2020-02-29 06:01:24","2020-02-29 06:01:24");



DROP TABLE return_sales;

CREATE TABLE `return_sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `saleprod_id` int(11) DEFAULT NULL,
  `quantity` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_return` date DEFAULT NULL,
  `notes` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO return_sales VALUES("1","4","8","2","2020-02-29","","1","2020-02-29 06:04:29","2020-02-29 06:42:45");
INSERT INTO return_sales VALUES("2","2","4","1","2020-02-29","","1","2020-02-29 06:10:11","2020-02-29 06:10:11");



DROP TABLE sale_products;

CREATE TABLE `sale_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE sales;

CREATE TABLE `sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` double(15,2) DEFAULT NULL,
  `total_items` double(15,2) DEFAULT NULL,
  `tax` double(15,2) DEFAULT NULL,
  `total_payment` double(15,2) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE settings;

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tax` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings VALUES("1","12.00","2020-03-06 01:00:00","2020-03-06 03:04:11");



DROP TABLE users;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `renter_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobileno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users VALUES("1","admin","Admin","1","","Admin@gmail.com","Davao city","09481663230","admin","$2y$10$vPfDM6YMyge9n0r8MhVEUeWB9szUVDH9EUnKvddvrW6iwuUU4skYu","","2020-02-29 01:42:36","2020-02-29 01:42:36");
INSERT INTO users VALUES("2","elyk","Elyk","22","1","elyk@gmail.com","Davao city","09485658522","renter","$2y$10$Bwpzl7gVXOaTcDFG6ajZaeUk.Mt9PxuyibRHT53aOwRJRZ42m4opy","","2020-02-29 01:55:23","2020-03-02 02:01:26");
INSERT INTO users VALUES("3","Anna","Anna","","1","demo@gmail.com","Narra Davao City","0912345679","admin","$2y$10$/L2geYiYpHjr10RNTsTxTOWT0c3ptuodjcvwuMxqqaKeiQXehGX52","","2020-02-29 02:22:57","2020-02-29 03:16:50");
INSERT INTO users VALUES("4","Mitch","Michelle","1","4","demo@gmail.com","Narra","0912345679","admin","$2y$10$qeHQqBiYXllLAqlFFfmmJujPt3TSIZ8/t2TMNLCIbc76XT8GPoy6K","","2020-02-29 03:16:25","2020-03-03 02:29:15");
INSERT INTO users VALUES("5","elykmatina","elykmatina","22","4","sample@gmail.com","Davao city","8278241","renter","$2y$10$GluhlQb.qwmX3oxY3StC2OF1rS/A3nZKYjB4WegpynP2EXWNCDsb.","","2020-02-29 03:16:56","2020-03-02 02:01:33");



DROP TABLE voucher_coupons;

CREATE TABLE `voucher_coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_type` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fix_price` double(15,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO voucher_coupons VALUES("1","425HGD","product","fixed price","2","200.00","1","1","2020-02-18 09:46:51","2020-02-18 10:17:15");
INSERT INTO voucher_coupons VALUES("2","425HGD","product","percent","8","","","1","2020-02-18 10:54:07","2020-02-18 11:00:22");



DROP TABLE voucher_products;

CREATE TABLE `voucher_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO voucher_products VALUES("15","2","25","2020-02-18 11:00:54","2020-02-18 11:00:54");
INSERT INTO voucher_products VALUES("22","1","24","2020-02-18 11:18:38","2020-02-18 11:18:38");
INSERT INTO voucher_products VALUES("23","1","26","2020-02-18 11:18:38","2020-02-18 11:18:38");



