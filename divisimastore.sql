-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 25 2022 г., 12:46
-- Версия сервера: 8.0.24
-- Версия PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `divisimastore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mini_img_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `category_group_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`id`, `title`, `seo_name`, `description`, `image_url`, `mini_img_url`, `active`, `category_group_id`, `created_at`, `updated_at`) VALUES
(2, 'ЗНИЖКИ ДО -50%', 'sales-50-precent', 'Цієї п\'ятниці діють знижки на товари усіх категорій для жінок! Знижки діятимуть усі вихідні. Встигніть придбати бажаний товар по низькій ціні!', 'new-women-collection.jpg', 'banner-sale.png', 1, 2, '2022-02-15 06:57:22', '2022-03-10 17:08:59'),
(3, 'Нова колекція', 'new-collection', '28.02 буде представлена нова колекція від бренду D&G. Також на нову колекцію буде діяти знижка -15% у перші три дні.', 'new-collection.jpg', 'pricing.png', 1, 2, '2022-02-15 06:58:14', '2022-03-23 06:48:36'),
(9, 'НОВА КОЛЕКЦІЯ ДЛЯ ЧОЛОВІКІВ', 'new-men-collection', 'Вже у наявності нова колекція для чоловіків! У перші 4 дні, а саме з 10.03 до 14.03 буде діяти знижка на цю колекцію у розмірі -15% від вартості товару колекції.', 'new-men-collection.jpg', 'pricing.png', 1, 1, '2022-03-10 16:43:27', '2022-04-04 14:21:05'),
(29, 'Нова колекція вишиванок', 'kolektsyya-vishivanok', 'Вже у наявності нова колекція вишиванок для дівчавток', 'imgonline-com-ua-Mirror-yB8NmkJAm8Q.png', '', 1, 4, '2022-05-16 05:11:44', '2022-05-16 05:19:44'),
(30, 'Нова колекція для хлопчиків', 'nova-kolektsyia-hlopchiki', 'Вже у наявності нова колекція для хлопчиків', 'malen-kiy-khlopchik-shpalery-1920x1080_48.jpg', '', 1, 3, '2022-05-16 05:49:43', '2022-05-16 05:49:43');

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`, `token`) VALUES
(4, 10, '2022-02-28 20:37:21', '2022-05-16 07:17:35', NULL),
(7, 15, '2022-02-21 12:59:04', '2022-04-17 16:55:26', NULL),
(200, 24, '2022-04-11 17:40:55', '2022-04-11 17:55:57', NULL),
(231, NULL, '2022-05-15 17:35:06', '2022-05-15 17:35:06', 'PkNvaj0Yj69iqgEdMD9xE6TH1QU1SVhaIrbRDgkQ'),
(232, NULL, '2022-05-15 17:40:01', '2022-05-15 17:40:01', 'SPOcvTxMmrijRo6qe518UR2GgshWLFXWy95qI3Db'),
(233, NULL, '2022-05-16 03:45:12', '2022-05-16 03:45:12', 'ylqbVIbCQIutagrEvkBgmKhrmGBGvow08xUb2oxa'),
(234, NULL, '2022-05-16 04:08:25', '2022-05-16 04:08:25', 'KPoi9XeG2kd3GPLjjHhQdeiSOaTs3ejLPNsA41DQ'),
(235, NULL, '2022-05-16 06:08:03', '2022-05-16 06:08:03', 'FqzOqX5a0XSVT7X7rTIhhNAKOBo99b3cSYrWZ1W3'),
(236, NULL, '2022-05-16 06:09:50', '2022-05-16 06:09:50', 'EflGCYKo7qEW3cnLSycfySRmDMIUWHyjDiL0OE6e'),
(237, NULL, '2022-05-16 06:12:01', '2022-05-16 06:12:01', 'm8NwIWASHXFLe70mqrWO03rhXcQsxy6TYVVwrCYg'),
(238, NULL, '2022-05-16 06:12:17', '2022-05-16 06:12:17', 'jiHMlAYEc1P2UOhVwN8svL67U3wqIkvtd2K1Rbv4'),
(239, NULL, '2022-05-16 06:21:36', '2022-05-16 07:16:35', 'X5zS9G9jBPNDJJDnpIFJTxaEc9UupCVd1XkYwbDd'),
(240, NULL, '2022-05-16 06:59:25', '2022-05-16 06:59:25', 'nMprQQ2xOtaez09j4TpBJAbGTfIHDBO0CPR5NBKt'),
(241, NULL, '2022-05-16 07:10:48', '2022-05-16 07:10:48', 'P7lDJ5xpPlmJAm7GEX18O1WfkyKqfSJkTys5CVnT'),
(242, NULL, '2022-05-16 07:11:47', '2022-05-16 07:11:47', 'HsoSofUl7UqBxfbzkOVe2cPWVjoEK6PjgBHF0qmY'),
(243, NULL, '2022-05-16 07:31:22', '2022-05-16 07:31:22', 'SspX6LEcVAYSytWKeTMjNotzOYz3Uo1DqvePENxh'),
(244, NULL, '2022-05-16 07:45:21', '2022-05-16 07:45:21', 'qFPg4G6rYFMmNta2K8ofo3UpDlEPom80sGtexV7w'),
(245, NULL, '2022-05-17 11:36:29', '2022-05-17 11:36:29', 'OKUoZaYxEMOyxALS6gPBxrP4XEdyDqrX7PR20gh3');

-- --------------------------------------------------------

--
-- Структура таблицы `cart_product`
--

CREATE TABLE `cart_product` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_count` int NOT NULL,
  `size` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cart_product`
--

INSERT INTO `cart_product` (`id`, `cart_id`, `product_id`, `product_count`, `size`, `created_at`, `updated_at`) VALUES
(368, 239, 98, 2, 46, NULL, NULL),
(369, 239, 98, 3, 44, NULL, NULL),
(370, 239, 104, 2, 38, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Одяг жіночий', 'Одяг', 'women-clothes', 1, NULL, '2022-05-15 17:47:58'),
(2, 'Взуття жіноче', 'Взуття', 'women-shoes', 1, NULL, '2022-03-17 15:58:58'),
(3, 'Аксесуари жіночі', 'Аксесуари', 'women-accessories', 1, NULL, NULL),
(4, 'Одяг чоловічий', 'Одяг', 'men-clothes', 1, NULL, NULL),
(5, 'Взуття чоловіче', 'Взуття', 'men-shoes', 1, NULL, NULL),
(6, 'Аксесуари чоловічі', 'Аксесуари', 'men-accessories', 1, NULL, '2022-03-17 11:25:19'),
(16, 'Одяг для хлопчиків', 'Одяг', 'boys-clothes', 1, '2022-02-21 18:04:00', '2022-02-21 18:04:00'),
(17, 'Одяг для дівчаток', 'Одяг', 'girls-clothes', 1, '2022-02-21 18:09:37', '2022-05-01 06:25:47'),
(25, 'Взуття для дівчаток', 'Взуття', 'vzuttia-dlya-divchatok', 1, '2022-05-16 05:27:45', '2022-05-16 05:27:45'),
(26, 'Взуття для хлопчиків', 'Взуття', 'vzuttya-hlopchiki', 1, '2022-05-16 05:50:29', '2022-05-16 05:50:29');

-- --------------------------------------------------------

--
-- Структура таблицы `category_category_group`
--

CREATE TABLE `category_category_group` (
  `id` bigint UNSIGNED NOT NULL,
  `category_group_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category_category_group`
--

INSERT INTO `category_category_group` (`id`, `category_group_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, NULL),
(2, 2, 3, NULL, NULL),
(3, 2, 2, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(9, 1, 6, NULL, NULL),
(11, 3, 16, NULL, NULL),
(12, 4, 17, NULL, NULL),
(20, 4, 25, NULL, NULL),
(21, 3, 26, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `category_groups`
--

CREATE TABLE `category_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category_groups`
--

INSERT INTO `category_groups` (`id`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Чоловіки', 'men', 1, NULL, '2022-04-12 15:16:11'),
(2, 'Жінки', 'women', 1, NULL, '2022-03-22 07:37:54'),
(3, 'Хлопчики', 'boys', 1, NULL, '2022-02-15 16:52:37'),
(4, 'Дівчатки', 'girls', 1, NULL, '2022-04-16 12:58:03');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `elastic_products`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `elastic_products` (
`active` tinyint(1)
,`banner_id` bigint unsigned
,`c_name` varchar(255)
,`c_seo_name` varchar(255)
,`c_title` varchar(255)
,`cg_name` varchar(255)
,`cg_seo_name` varchar(255)
,`count` int
,`created_at` timestamp
,`description` text
,`discount` int
,`id` bigint unsigned
,`in_stock` tinyint(1)
,`name` varchar(255)
,`pb_id` bigint unsigned
,`pb_name` varchar(255)
,`pb_seo_name` varchar(255)
,`pc_id` bigint unsigned
,`pc_name` varchar(255)
,`pc_seo_name` varchar(255)
,`pm_id` bigint unsigned
,`pm_name` varchar(255)
,`pm_seo_name` varchar(255)
,`popularity` int
,`preview_img_url` varchar(255)
,`price` int
,`product_brand` bigint unsigned
,`product_category` bigint unsigned
,`product_category_group` bigint unsigned
,`product_category_sub` bigint unsigned
,`product_color` bigint unsigned
,`product_season` bigint unsigned
,`ps_id` bigint unsigned
,`ps_name` varchar(255)
,`ps_seo_name` varchar(255)
,`psize_id` bigint unsigned
,`psize_name` varchar(255)
,`psize_seo_name` varchar(255)
,`rating` double(8,2)
,`sc_name` varchar(255)
,`sc_seo_name` varchar(255)
,`sc_title` varchar(255)
,`seo_name` varchar(255)
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(29, '2014_10_12_000000_create_users_table', 1),
(30, '2014_10_12_100000_create_password_resets_table', 1),
(31, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(32, '2022_01_16_094349_create_products_table', 1),
(33, '2022_01_16_094507_create_categories_table', 1),
(36, '2022_01_16_123434_create_category_groups_table', 2),
(37, '2022_01_16_123540_create_sub_categories_table', 2),
(38, '2022_01_16_124236_add_fields_to_products_table', 3),
(86, '2022_01_16_141740_create_product_images_table', 4),
(87, '2022_01_16_141900_create_product_materials_table', 4),
(88, '2022_01_16_141917_create_product_colors_table', 4),
(89, '2022_01_16_141932_create_product_sizes_table', 4),
(90, '2022_01_16_141944_create_product_brands_table', 4),
(91, '2022_01_16_141958_create_product_seasons_table', 4),
(92, '2022_01_16_145319_create_product_product_sizes_table', 4),
(93, '2022_01_16_161351_add_product_id_to_product_images_table', 4),
(94, '2022_01_17_102301_add_characteristics_fields_to_products_table', 5),
(95, '2022_01_17_113948_add_foreign_keys_to_products_table', 5),
(96, '2022_01_17_115143_create_product_product_size_table', 6),
(97, '2022_01_17_115155_create_product_product_material_table', 6),
(98, '2022_01_17_120204_add_product_brand_id_to_products_table', 7),
(99, '2022_01_19_153041_add_title_to_categories_table', 8),
(100, '2022_01_19_175827_add_title_to_sub_categories_table', 9),
(104, '2022_02_09_122014_create_carts_table', 10),
(105, '2022_02_09_194617_create_cart_product_table', 10),
(106, '2022_02_13_090859_create_orders_lists_table', 11),
(109, '2022_02_13_093616_create_order_list_items_table', 12),
(110, '2022_02_13_110705_add_orders_list_id_to_order_list_items_table', 12),
(111, '2022_02_13_185847_add_count_to_product_product_size_table', 13),
(112, '2022_02_14_072508_create_status_lists_table', 14),
(113, '2022_02_14_073848_add_status_to_orders_lists_table', 15),
(114, '2022_02_14_093150_add_size_title_to_order_list_items_table', 16),
(115, '2022_02_15_081852_create_user_messages_table', 17),
(117, '2022_02_15_083113_create_banners_table', 18),
(119, '2022_02_21_182824_add_discount_to_products_table', 19),
(120, '2022_03_01_090023_add_token_field_to_carts_table', 20),
(121, '2022_03_01_095923_add_token_field_to_orders_lists_table', 21),
(122, '2022_03_04_174652_add_banner_id_to_products_table', 22),
(123, '2022_03_04_175831_add_seo_name_to_banners_table', 23),
(124, '2022_03_04_181759_add_category_group_id_to_banners_table', 24),
(129, '2022_03_06_180221_create_elastic_products_view', 25),
(130, '2022_03_13_101618_add_rating_field_to_products_table', 26),
(131, '2022_03_13_101829_create_user_reviews_table', 27),
(132, '2022_03_20_122426_add_popularity_field_to_products_table', 28),
(133, '2022_03_25_172339_add_post_department_field_to_orders_lists_table', 29),
(134, '2022_03_25_173001_add_city_field_to_orders_lists_table', 30),
(135, '2022_03_25_174524_add_pay_now_field_to_orders_lists_table', 31),
(136, '2022_03_31_204529_create_ukraine_cities_table', 32),
(137, '2022_04_10_122608_create_user_promocodes_table', 33),
(140, '2022_04_10_123008_create_user_user_promocode_table', 34),
(142, '2022_04_10_133157_add_min_total_field_to_user_promocodes_table', 35),
(143, '2022_04_10_145908_add_promocode_field_to_orders_lists_table', 36),
(144, '2022_04_11_174359_add_active_field_to_user_promocodes_table', 37),
(145, '2022_04_11_193056_add_orders_amount_to_users_table', 38),
(148, '2022_04_13_202123_create_password_resets_table', 39),
(149, '2022_04_16_081906_add_session_code_to_password_resets_table', 40),
(150, '2022_05_12_202520_create_user_roles_table', 41),
(151, '2022_05_12_202844_create_user_user_role_table', 42);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_lists`
--

CREATE TABLE `orders_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_now` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_department` int DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` int UNSIGNED NOT NULL,
  `promocode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` bigint UNSIGNED DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders_lists`
--

INSERT INTO `orders_lists` (`id`, `user_id`, `token`, `name`, `email`, `pay_now`, `phone`, `city`, `address`, `post_department`, `comment`, `total_cost`, `promocode`, `status`, `created_at`, `updated_at`) VALUES
(75, 10, NULL, 'Олександр Бойчук', 'boychuk334@gmail.com', 0, '380963254237', '', 'вул. Івана Богуна 70', NULL, NULL, 324, NULL, 3, '2022-03-12 10:18:32', '2022-03-12 10:19:43'),
(92, 10, NULL, 'Олександр Бойчук', 'boychuk334@gmail.com', 0, '380963254237', '', 'вул. Івана Богуна 70', NULL, NULL, 6361, NULL, 6, '2022-03-16 08:17:39', '2022-03-20 10:15:30'),
(96, 10, NULL, 'Олександр Бойчук', 'boychuk334@gmail.com', 0, '380963254237', '', 'вул. Івана Богуна 70', NULL, NULL, 4707, NULL, 2, '2022-03-16 20:13:48', '2022-03-20 18:27:49'),
(98, 10, NULL, 'Олександр1 Бойчук', 'boychuk334@gmail.com', 0, '380963254237', '', 'вул. Івана Богуна 70', NULL, 'sdfsdf', 1084, NULL, 5, '2022-03-17 08:15:46', '2022-03-20 10:09:25'),
(120, 10, NULL, 'Олександр Бойчук', NULL, 1, '380963254237', 'Херсон', NULL, NULL, NULL, 627, NULL, 5, '2022-04-11 14:46:52', '2022-04-11 16:43:39'),
(123, 10, NULL, 'Олександр Бойчук', NULL, 1, '380963254237', 'Херсон', NULL, NULL, NULL, 1062, NULL, 3, '2022-04-11 16:58:22', '2022-05-16 07:28:57'),
(131, 10, NULL, 'Олександр Бойчук', NULL, 1, '0930553785', 'Херсон', NULL, 23, NULL, 1514, NULL, 1, '2022-05-16 06:07:42', '2022-05-16 06:07:42'),
(132, NULL, 'FqzOqX5a0XSVT7X7rTIhhNAKOBo99b3cSYrWZ1W3', 'Ігор Іванов', NULL, 1, '065455511', 'Глухів', NULL, NULL, 'ВІдправте будь ласка  через 5 днів або пізніше', 2146, NULL, 1, '2022-05-16 06:09:33', '2022-05-16 06:21:07'),
(133, 10, NULL, 'Олександр Бойчук', NULL, 1, '0930553785', 'Херсон', NULL, 23, NULL, 1839, 'special-for-reg-user', 1, '2022-05-16 07:19:55', '2022-05-16 07:19:55');

-- --------------------------------------------------------

--
-- Структура таблицы `order_list_items`
--

CREATE TABLE `order_list_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int UNSIGNED NOT NULL,
  `count` int NOT NULL DEFAULT '1',
  `size` int NOT NULL,
  `total_cost` int UNSIGNED NOT NULL,
  `orders_list_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_list_items`
--

INSERT INTO `order_list_items` (`id`, `order_id`, `product_id`, `name`, `price`, `count`, `size`, `total_cost`, `orders_list_id`, `created_at`, `updated_at`) VALUES
(63, 75, 4, 'Майка', 324, 1, 36, 324, 75, '2022-03-12 10:18:32', '2022-03-12 10:18:32'),
(83, 92, 3, 'Плаття', 523, 1, 20, 523, 92, '2022-03-16 08:17:39', '2022-03-16 08:17:39'),
(84, 92, 4, 'Майка', 324, 8, 37, 2592, 92, '2022-03-16 08:17:39', '2022-03-16 08:17:39'),
(85, 92, 2, 'Светр класичний', 266, 3, 18, 798, 92, '2022-03-16 08:17:39', '2022-03-16 08:17:39'),
(86, 92, 4, 'Майка', 324, 5, 38, 1620, 92, '2022-03-16 08:17:39', '2022-03-16 08:17:39'),
(89, 96, 3, 'Плаття', 523, 9, 20, 4707, 96, '2022-03-16 20:13:48', '2022-03-16 20:13:48'),
(91, 98, 2, 'Светр класичний', 266, 2, 18, 532, 98, '2022-03-17 08:15:46', '2022-03-17 08:15:46'),
(119, 120, 30, 'Джинси чорні', 1062, 1, 28, 1062, 120, '2022-04-11 14:46:52', '2022-04-11 14:46:52'),
(122, 123, 30, 'Джинси чорні', 1062, 1, 28, 1062, 123, '2022-04-11 16:58:22', '2022-04-11 16:58:22'),
(142, 131, 98, 'Плаття блакитне', 615, 1, 44, 615, 131, '2022-05-16 06:07:42', '2022-05-16 06:07:42'),
(143, 131, 99, 'Плаття зелене Arber', 549, 1, 42, 549, 131, '2022-05-16 06:07:42', '2022-05-16 06:07:42'),
(144, 131, 100, 'Футболка біла з принтом', 350, 1, 42, 350, 131, '2022-05-16 06:07:42', '2022-05-16 06:07:42'),
(145, 132, 98, 'Плаття блакитне', 615, 1, 44, 615, 132, '2022-05-16 06:09:33', '2022-05-16 06:09:33'),
(146, 132, 98, 'Плаття блакитне', 615, 1, 46, 615, 132, '2022-05-16 06:09:33', '2022-05-16 06:09:33'),
(147, 132, 100, 'Футболка біла з принтом', 350, 1, 42, 350, 132, '2022-05-16 06:09:33', '2022-05-16 06:09:33'),
(148, 132, 95, 'Джинси блакитні Arber', 566, 1, 30, 566, 132, '2022-05-16 06:09:33', '2022-05-16 06:09:33'),
(149, 133, 98, 'Плаття блакитне', 615, 1, 50, 1845, 133, '2022-05-16 07:19:55', '2022-05-16 07:19:55'),
(150, 133, 100, 'Футболка біла з принтом', 350, 1, 42, 700, 133, '2022-05-16 07:19:55', '2022-05-16 07:19:55');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `confirm_code`, `session_code`, `created_at`, `updated_at`) VALUES
(7, 'boychuk334@gmail.com', '921946', '', '2022-04-13 18:10:59', NULL),
(8, 'boychuk334@gmail.com', '932943', '', '2022-04-13 18:12:15', NULL),
(9, 'boychuk334@gmail.com', '599398', '', '2022-04-13 18:12:19', NULL),
(10, 'boychuk334@gmail.com', '809112', 'VMsKaM48rdqSMh55quTlhvnewwkPBwLzYNZLKK4i', '2022-04-16 05:29:44', NULL),
(11, 'boychuk334@gmail.com', '836027', 'VMsKaM48rdqSMh55quTlhvnewwkPBwLzYNZLKK4i', '2022-04-16 05:32:20', NULL),
(12, 'boychuk334@gmail.com', '760371', 'VMsKaM48rdqSMh55quTlhvnewwkPBwLzYNZLKK4i', '2022-04-16 06:00:42', NULL),
(13, 'boychuk334@gmail.com', '980467', 'VMsKaM48rdqSMh55quTlhvnewwkPBwLzYNZLKK4i', '2022-04-16 06:02:17', NULL),
(14, 'boychuk334@gmail.com', '195824', 'VMsKaM48rdqSMh55quTlhvnewwkPBwLzYNZLKK4i', '2022-04-16 06:04:21', NULL),
(15, 'boychuk334@gmail.com', '250805', 'VMsKaM48rdqSMh55quTlhvnewwkPBwLzYNZLKK4i', '2022-04-16 06:24:14', NULL),
(16, 'boychuk334@gmail.com', '512503', '7GyfIclQ128yAX4jTpC1ylNO83j6OOg6ZKkQcjf3', '2022-05-12 16:41:13', NULL),
(17, 'boychuk334@gmail.com', '915899', '7GyfIclQ128yAX4jTpC1ylNO83j6OOg6ZKkQcjf3', '2022-05-12 16:51:01', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `preview_img_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int NOT NULL,
  `discount` int DEFAULT '0',
  `count` int DEFAULT NULL,
  `in_stock` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `rating` double(8,2) DEFAULT NULL,
  `popularity` int NOT NULL DEFAULT '0',
  `banner_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_group_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `category_sub_id` bigint UNSIGNED NOT NULL,
  `product_color_id` bigint UNSIGNED NOT NULL,
  `product_season_id` bigint UNSIGNED NOT NULL,
  `product_brand_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `seo_name`, `preview_img_url`, `description`, `price`, `discount`, `count`, `in_stock`, `active`, `rating`, `popularity`, `banner_id`, `created_at`, `updated_at`, `category_group_id`, `category_id`, `category_sub_id`, `product_color_id`, `product_season_id`, `product_brand_id`) VALUES
(1, 'Кросівки Black', 'sneakers-men-black', '20210629171156_005801543_1.jpg', 'Кросівки чорного кольору для чоловіків', 599, 0, 444, 1, 1, NULL, 555, NULL, '2022-02-16 08:19:20', '2022-05-16 05:06:22', 1, 5, 3, 3, 2, 1),
(2, 'Светр класичний', 'sweater-classic-green', 'sweater-woman-green.jpg', 'Светр класичний чоловічий виконаний з якісних матеріалів', 542, 51, 380, 1, 1, 3.00, 316, 2, '2022-02-15 09:39:08', '2022-05-15 17:47:58', 2, 1, 2, 5, 1, 5),
(3, 'Плаття чорне', 'dress', '20190312132803_004920315_1.jpg', 'Плаття жіноче чорного кольору ', 523, 0, 1376, 1, 1, 3.30, 141, NULL, '2022-02-16 08:19:15', '2022-05-16 04:17:18', 2, 1, 4, 3, 3, 5),
(4, 'Футболка сіра GJ', 'futbolka-seraya-gj', '20191125120218_005281096_1.jpg', 'Футболка сірого кольору від бренду Gloria Jeans', 449, 10, 57013, 1, 1, 4.50, 234, 2, '2022-02-16 08:19:16', '2022-05-16 04:30:15', 2, 1, 6, 6, 3, 4),
(5, 'Кросівки білі', 'sneakers-woman-white', 'sneakers-woman-white.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 315, 0, 319, 1, 1, NULL, 324, NULL, '2022-02-16 08:19:21', '2022-03-17 15:58:58', 2, 2, 7, 2, 2, 1),
(7, 'Браслет жіночий', 'braclet-women-white', 'braclet-woman-white.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 423, 0, 342, 1, 1, NULL, 242, NULL, '2022-02-16 08:19:17', '2022-02-21 17:22:01', 2, 3, 5, 2, 2, 3),
(8, 'Светр гірчичного кольору', 'sviter-gorchichnogo-tsveta-marse', 'sviter-gorchichnogo-tsveta-marse.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 314, 0, 119, 1, 1, NULL, 242, NULL, '2022-02-16 08:19:16', '2022-05-15 17:47:58', 2, 1, 2, 7, 1, 4),
(9, 'Светр сірий', 'sviter-seryy-love-vita', 'sviter-seryy-love-vita.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 862, 0, 3231, 1, 1, NULL, 415, NULL, '2022-02-16 08:19:17', '2022-05-15 17:47:58', 2, 1, 2, 6, 4, 3),
(10, 'Светр трикольоровий', 'sweater-marse-three-colors', 'sweater-marse-three-colors.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 342, 0, 1231, 1, 1, NULL, 215, NULL, '2022-02-16 08:19:21', '2022-05-15 17:47:58', 2, 1, 2, 2, 2, 1),
(11, 'Бежеві кросівки', 'bege-nila-nila-sneakers-women', 'bege-nila-nila-sneakers-women.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 345, 0, 1231, 1, 1, NULL, 143, NULL, '2022-02-16 08:19:19', '2022-03-17 15:58:58', 2, 2, 7, 5, 3, 2),
(12, 'Білі кросівки Allshoes', 'white-allshoes-sneakers-women', 'white-allshoes-sneakers-women.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 342, 0, 3123, 1, 1, NULL, 423, NULL, '2022-02-16 08:19:20', '2022-03-17 15:58:58', 2, 2, 7, 2, 2, 2),
(13, 'Кросівки білі England', 'white-england-sneakers-women', 'white-england-sneakers-women.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2222, 0, 43, 1, 1, NULL, 234, NULL, '2022-02-16 08:19:18', '2022-03-17 15:58:58', 2, 2, 7, 2, 3, 3),
(22, 'Джинси чоловічі Gracia', 'men-jeans-gracia', 'men-jeans-gracia.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2311, 0, 225, 1, 1, NULL, 234, NULL, '2022-02-16 10:51:12', '2022-02-16 10:55:31', 1, 4, 10, 1, 2, 4),
(27, 'Сорочка Alpama', 'rubashka-alpama', 'rubashka-alpama.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2341, 0, 2620, 1, 1, NULL, 234, 3, '2022-02-16 16:46:17', '2022-05-15 17:47:58', 2, 1, 14, 1, 2, 9),
(28, 'Сорочка у смужку', 'rubashka-rozovaya-v-kletku-old-navy', 'rubashka-rozovaya-v-kletku-old-navy.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3554, 24, 3422, 1, 1, 4.00, 234, 2, '2022-02-16 16:50:54', '2022-05-15 17:47:58', 2, 1, 14, 16, 4, 8),
(29, 'Джинси Блакитні', 'dzhinsy-golubye-vero-moda', 'dzhinsy-golubye-vero-moda.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3411, 0, 314, 1, 1, NULL, 234, NULL, '2022-02-16 16:59:38', '2022-05-15 17:47:58', 2, 1, 1, 17, 2, 7),
(30, 'Джинси чорні', 'dzhinsy-chernye-hm', 'dzhinsy-chernye-hm.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3541, 70, 6454, 1, 1, 4.00, 422, 2, '2022-02-16 17:00:33', '2022-05-15 17:47:58', 2, 1, 1, 3, 5, 11),
(31, 'Светр синій', 'sviter-siniy-svtr', 'sviter-siniy-svtr.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2341, 10, 421, 1, 1, 4.00, 234, 9, '2022-02-21 17:42:07', '2022-03-18 16:23:23', 1, 4, 11, 1, 2, 11),
(32, 'Джинси темно-сині', 'men-jeans-dark-blue', 'men-jeans-dark-blue.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 351, 5, 443, 1, 1, NULL, 324, 9, '2022-02-21 17:44:15', '2022-05-16 05:01:59', 1, 4, 10, 1, 4, 12),
(33, 'Зонт чоловічий', 'zont-zest', 'zont-zest.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 411, 0, 0, 1, 1, NULL, 131, NULL, '2022-02-21 17:49:01', '2022-05-16 04:54:10', 1, 6, 15, 3, 5, 8),
(35, 'Футболка синя з принтом', 'futbolka-biryuzovaya-s-printom-flash', 'futbolka-biryuzovaya-s-printom-flash.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 312, 12, 34321, 1, 1, NULL, 234, 2, '2022-02-21 18:06:22', '2022-02-21 18:06:22', 3, 16, 16, 1, 1, 9),
(36, 'Плаття червоне з малюнком', 'plate-krasnoe-s-risunkom-flash', 'plate-krasnoe-s-risunkom-flash.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1312, 0, 2894, 1, 1, NULL, 321, NULL, '2022-02-21 18:10:50', '2022-03-24 16:46:08', 4, 17, 17, 4, 3, 7),
(95, 'Джинси блакитні Arber', 'dzhinsy-golubye-arber-3241', '20210818150128_005853666_2.jpg', 'Джинси блакитного кольору від бренду Arber', 629, 10, 9899, 1, 1, NULL, 0, 3, '2022-05-16 03:57:56', '2022-05-16 03:57:57', 2, 1, 1, 17, 6, 8),
(96, 'Джинси мом сині  GJ', 'jinsi-mom-sini-gj-3113', '20220110141921_005953483_2.jpg', 'Джинси типу мом синього кольору від бренду Gloria Jeans', 779, 0, 3052, 1, 1, NULL, 0, 3, '2022-05-16 04:02:36', '2022-05-16 04:02:36', 2, 1, 1, 1, 9, 4),
(97, 'Джинси сині D&G', 'djinsy-sinie-d-and-g-421', '20220110141921_005953499_1.jpg', 'Джинси синього кольору від бренду D&G', 479, 0, 1491, 1, 1, NULL, 0, 3, '2022-05-16 04:14:58', '2022-05-16 04:14:59', 2, 1, 1, 1, 9, 9),
(98, 'Плаття блакитне', 'plattia-blakytne-3211', '20211027165910_005915222_1.jpg', 'Плаття балкитного кольору від бренда Lacoste', 769, 20, 14233, 1, 1, 3.50, 0, 2, '2022-05-16 04:55:50', '2022-05-16 07:14:51', 2, 1, 4, 17, 7, 11),
(99, 'Плаття зелене Arber', 'plattia-zelene-arber-321', '20210604140658_005778189_1.jpg', 'Плаття зеленого кольору від бренду Arber', 549, 0, 4568, 1, 1, NULL, 0, 3, '2022-05-16 04:54:38', '2022-05-16 04:26:38', 2, 1, 4, 5, 3, 8),
(100, 'Футболка біла з принтом', 'futbolka-bila-z-pryntom-31', '20220329152820_006019583_1.jpg', 'Футболка білого кольору з принтом, виконана якісно, приємна на дотик', 350, 0, 1568, 1, 1, NULL, 0, NULL, '2022-05-16 04:53:36', '2022-05-16 04:32:36', 2, 1, 6, 2, 3, 7),
(101, 'Футболка чорна', 'futbolka-chorna-312', '20140813141019_001281550_1.jpg', 'Футболка чорного кольору', 149, 0, 6304, 1, 1, NULL, 0, NULL, '2022-05-16 04:53:35', '2022-05-16 04:34:35', 2, 1, 6, 3, 3, 11),
(102, 'Браслет D&G', 'braslet-dg-41', '20190614162046_005112331_1.jpg', 'Браслет срібний від бренду D&G', 501, 0, 1085, 1, 1, NULL, 0, NULL, '2022-05-15 04:33:22', '2022-05-16 04:37:43', 2, 3, 5, 6, 9, 9),
(103, 'Зонт червоний', 'zont-chervonyy', '20211005171901_005904922_1.jpg', 'Зонт червоного кольору, напівавтомтичний', 452, 0, 0, 1, 1, NULL, 0, NULL, '2022-05-16 01:14:10', '2022-05-16 04:40:10', 2, 3, 20, 4, 9, 11),
(104, 'Чоботи чорні Lacoste', 'choboty-chorny-lacoste', '20210222102656_005650057_1.jpg', 'Чоботи чорного кольору від бренду Lacoste. Мають розкішний дизайн та вироблені з натуральної шкіри.', 1790, 0, 7071, 1, 1, NULL, 0, 3, '2022-05-16 04:45:08', '2022-05-16 04:45:08', 2, 2, 21, 3, 8, 11),
(105, 'Чоботи коричневі Airboss', 'choboty-korychnevi-31', '20190725141819_005150396_1.jpg', 'Чоботи коричневого кольору, виконані з якісних матеріалів.', 3082, 0, 12412, 1, 1, NULL, 0, NULL, '2022-05-15 04:09:35', '2022-05-16 04:48:35', 2, 2, 21, 15, 5, 7),
(106, 'Туфлі чорні Lacoste', 'tyfli-chorni-lacoste-31', '20210222104928_005649042_1.jpg', 'Туфлі чорного кольору, вироблені з натуральної шкіри від бренду Lacoste', 1521, 0, 21758, 1, 1, NULL, 0, 9, '2022-05-16 04:53:08', '2022-05-16 04:53:08', 1, 5, 22, 3, 6, 11),
(107, 'Сорочка чорна', 'sorochka-chorna', '20211203131749_005930342_1.jpg', 'Сорочка чорного кольору для чоловіків', 1532, 15, 3563, 1, 1, NULL, 0, 9, '2022-05-16 04:57:37', '2022-05-16 05:01:48', 1, 4, 13, 3, 3, 2),
(108, 'Кросівки зеленого кольору', 'krosivky-zelenogo-kolory', '20220127175038_005982785_1.jpg', 'Чоловічі кросівки зеленого кольору', 1249, 15, 24737, 1, 1, NULL, 0, 9, '2022-05-16 05:04:57', '2022-05-16 05:04:57', 1, 5, 3, 5, 1, 1),
(109, 'Вишиванка біла', 'vyshyvanka-bila-21', '20161111232912_002800725_1.jpg', 'Вишиванка білого кольору для дівчаток, виконана з дуже якісних матеріалів.', 569, 12, 4265, 1, 1, NULL, 0, 29, '2022-05-16 05:23:10', '2022-05-16 05:23:10', 4, 17, 23, 2, 6, 5),
(110, 'Вишиванка біла волинська', 'vyshyvanka-bila-volynska', '20211213171343_005934052_1.jpg', 'Вишиванка білого кольору волинська', 489, 15, 1107, 1, 1, NULL, 0, 29, '2022-05-16 05:25:17', '2022-05-16 05:25:17', 4, 17, 23, 2, 6, 4),
(111, 'Плаття синє у клітинку', 'plattia-sinee-v-klitynku--22', '20210719155852_005823747_2.jpg', 'Плаття синього кольору у клітинку для дівчаток', 769, 0, 2330, 1, 1, NULL, 0, NULL, '2022-05-16 05:32:12', '2022-05-16 05:32:12', 4, 17, 17, 1, 2, 8),
(112, 'Чоботи рожеві', 'choboty-rozhevi0-53', '20220218190025_005959217_3.jpg', 'Чоботи рожевого кольору для дівчаток', 789, 12, 7176, 1, 1, NULL, 0, NULL, '2022-05-16 05:35:54', '2022-05-16 05:35:54', 4, 25, 24, 22, 8, 5),
(113, 'Сандалі сині', 'sandali-sini-532', '20220218190027_005959382_3.jpg', 'Сандалі сині для хлопчиків', 431, 12, 2054, 1, 1, NULL, 0, 30, '2022-05-16 05:54:54', '2022-05-16 05:54:55', 3, 26, 25, 1, 3, 2),
(114, 'Сандалі чорні', 'sandali-chorni-4121', '20210322101921_005701572_4.jpg', 'Сандалі чорні для хлопчиків, виконані з дуже якісних матеріалів', 650, 20, 1133, 1, 1, NULL, 0, 30, '2022-05-16 05:57:01', '2022-05-16 05:57:01', 3, 26, 25, 3, 2, 12),
(115, 'Футболка червона', 'futbolka-chervona-453', '20211018195633_005908454_1.jpg', 'Футболка червона для хлопчиків', 345, 15, 1311, 1, 1, NULL, 0, 30, '2022-05-16 05:58:51', '2022-05-16 05:58:51', 3, 16, 16, 4, 6, 8),
(116, 'Гольф чорний', 'golf-chornii-342', '20180809130249_004480261_1.jpg', 'Гольф чорний для хлопичків', 432, 15, 1122, 1, 1, NULL, 0, 30, '2022-05-16 06:01:24', '2022-05-16 06:01:24', 3, 16, 26, 3, 8, 11),
(117, 'Гольф зелений', 'golf-zelenyy', '20220119192012_005964898_13.jpg', 'Гольф зелений для хлопчиків', 567, 0, 807, 1, 1, NULL, 0, NULL, '2022-05-16 06:02:37', '2022-05-16 06:02:37', 3, 16, 26, 5, 5, 10),
(118, 'Гольф синій', 'golf-snii-23', '20220119192014_005965150_13.jpg', 'Гольф синій для хлопчиків', 562, 0, 765, 1, 1, NULL, 0, NULL, '2022-05-16 06:03:39', '2022-05-16 06:03:39', 3, 16, 26, 1, 5, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `product_brands`
--

CREATE TABLE `product_brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_brands`
--

INSERT INTO `product_brands` (`id`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Nike', 'nike', 1, NULL, '2022-02-14 13:04:30'),
(2, 'Adidas', 'adidas', 1, NULL, NULL),
(3, 'Puma', 'puma', 1, NULL, NULL),
(4, 'Gloria Jeans', 'gloria-jeans', 1, NULL, NULL),
(5, 'House Brand', 'house-brand', 1, NULL, NULL),
(7, 'Airboss', 'airboss', 1, NULL, NULL),
(8, 'Arber', 'arber', 1, NULL, NULL),
(9, 'D&G', 'd-and-g', 1, NULL, NULL),
(10, 'Jeep', 'jeep', 1, NULL, NULL),
(11, 'Lacoste', 'lacoste', 1, NULL, NULL),
(12, 'Zeus', 'zeus', 1, NULL, '2022-04-12 14:58:54');

-- --------------------------------------------------------

--
-- Структура таблицы `product_colors`
--

CREATE TABLE `product_colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_colors`
--

INSERT INTO `product_colors` (`id`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Синій', 'blue', 1, NULL, '2022-02-14 12:00:33'),
(2, 'Білий', 'white', 1, NULL, NULL),
(3, 'Чорний', 'black', 1, NULL, NULL),
(4, 'Червоний', 'red', 1, NULL, NULL),
(5, 'Зелений', 'green', 1, NULL, NULL),
(6, 'Сірий', 'gray', 1, '2022-01-17 11:44:30', NULL),
(7, 'Жовтий', 'yellow', 1, NULL, NULL),
(15, 'Гірчичний', 'mustard', 1, NULL, NULL),
(16, 'Бежевий', 'beige', 1, NULL, NULL),
(17, 'Голубий', 'azure', 1, NULL, NULL),
(18, 'Бордовий', 'burgundy', 1, NULL, NULL),
(19, 'Оранжевий', 'orange', 1, NULL, '2022-05-01 06:30:09'),
(22, 'Рожевий', 'pink', 1, '2022-05-16 05:33:40', '2022-05-16 05:33:40');

-- --------------------------------------------------------

--
-- Структура таблицы `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_images`
--

INSERT INTO `product_images` (`id`, `url`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'sweater-green1.jpg', 2, NULL, NULL),
(2, 'sweater-green2.jpg', 2, NULL, NULL),
(3, 'sweater-green3.jpg', 2, NULL, NULL),
(4, 'sweater-green4.jpg', 2, NULL, NULL),
(5, 'bege-nila-nila-sneakers-women1.jpg', 11, NULL, NULL),
(6, 'bege-nila-nila-sneakers-women2.jpg', 11, NULL, NULL),
(7, 'bege-nila-nila-sneakers-women3.jpg', 11, NULL, NULL),
(8, 'sviter-seryy-love-vita1.jpg', 9, NULL, NULL),
(9, 'sviter-seryy-love-vita2.jpg', 9, NULL, NULL),
(10, 'sviter-seryy-love-vita3.jpg', 9, NULL, NULL),
(14, 'white-allshoes-sneakers-women1.jpg', 12, NULL, NULL),
(15, 'white-allshoes-sneakers-women2.jpg', 12, NULL, NULL),
(17, 'white-england-sneakers-women1.jpg', 13, NULL, NULL),
(18, 'white-england-sneakers-women2.jpg', 13, NULL, NULL),
(19, 'white-england-sneakers-women3.jpg', 13, NULL, NULL),
(25, 'men-jeans-gracia1.jpg', 22, NULL, NULL),
(26, 'men-jeans-gracia2.jpg', 22, NULL, NULL),
(29, 'rubashka-alpama1.jpg', 27, NULL, NULL),
(30, 'rubashka-alpama2.jpg', 27, NULL, NULL),
(32, 'rubashka-rozovaya-v-kletku-old-navy1.jpg', 28, NULL, NULL),
(33, 'rubashka-rozovaya-v-kletku-old-navy2.jpg', 28, NULL, NULL),
(35, 'dzhinsy-golubye-vero-moda1.jpg', 29, NULL, NULL),
(36, 'dzhinsy-golubye-vero-moda2.jpg', 29, NULL, NULL),
(38, 'dzhinsy-chernye-hm1.jpg', 30, NULL, NULL),
(39, 'dzhinsy-chernye-hm2.jpg', 30, NULL, NULL),
(42, 'sviter-siniy-svtr2.jpg', 31, NULL, NULL),
(45, 'men-jeans-dark-blue1.jpg', 32, NULL, NULL),
(46, 'men-jeans-dark-blue2.jpg', 32, NULL, NULL),
(50, 'futbolka-biryuzovaya-s-printom-flash1.jpg', 35, NULL, NULL),
(52, 'plate-krasnoe-s-risunkom-flash1.jpg', 36, NULL, NULL),
(160, '20210818150128_005853666_1.jpg', 95, '2022-05-16 03:57:57', '2022-05-16 03:57:57'),
(161, '20210818150128_005853666_3.jpg', 95, '2022-05-16 03:57:57', '2022-05-16 03:57:57'),
(162, '20210818150128_005853666_4.jpg', 95, '2022-05-16 03:57:57', '2022-05-16 03:57:57'),
(163, '20220110141921_005953483_3.jpg', 96, '2022-05-16 04:02:36', '2022-05-16 04:02:36'),
(164, '20220110141921_005953483_4.jpg', 96, '2022-05-16 04:02:36', '2022-05-16 04:02:36'),
(165, '20220110141921_005953483_6.jpg', 96, '2022-05-16 04:02:36', '2022-05-16 04:02:36'),
(166, '20220110141921_005953499_2.jpg', 97, '2022-05-16 04:14:58', '2022-05-16 04:14:58'),
(167, '20220110141921_005953499_3.jpg', 97, '2022-05-16 04:14:58', '2022-05-16 04:14:58'),
(168, '20190312132803_004920315_2.jpg', 3, '2022-05-16 04:17:18', '2022-05-16 04:17:18'),
(169, '20190312132803_004920315_3.jpg', 3, '2022-05-16 04:17:18', '2022-05-16 04:17:18'),
(170, '20211027165910_005915222_3.jpg', 98, '2022-05-16 04:21:50', '2022-05-16 04:21:50'),
(171, '20211027165910_005915222_2.jpg', 98, '2022-05-16 04:21:50', '2022-05-16 04:21:50'),
(172, '20210604134758_005778189_2.jpg', 99, '2022-05-16 04:26:38', '2022-05-16 04:26:38'),
(173, '20210604140658_005778189_3.jpg', 99, '2022-05-16 04:26:38', '2022-05-16 04:26:38'),
(174, '20210604140658_005778189_4.jpg', 99, '2022-05-16 04:26:38', '2022-05-16 04:26:38'),
(175, '20191125120218_005281096_2.jpg', 4, '2022-05-16 04:30:15', '2022-05-16 04:30:15'),
(176, '20191125120218_005281096_3.jpg', 4, '2022-05-16 04:30:15', '2022-05-16 04:30:15'),
(177, '20140813141019_001281550_2.jpg', 101, '2022-05-16 04:34:35', '2022-05-16 04:34:35'),
(178, '20140813141019_001281550_3.jpg', 101, '2022-05-16 04:34:35', '2022-05-16 04:34:35'),
(179, '20190614162046_005112331_2.jpg', 102, '2022-05-16 04:37:22', '2022-05-16 04:37:22'),
(180, '20211005171901_005904922_2.jpg', 103, '2022-05-16 04:40:10', '2022-05-16 04:40:10'),
(181, '20211005171901_005904922_3.jpg', 103, '2022-05-16 04:40:10', '2022-05-16 04:40:10'),
(182, '20210222102656_005650057_2.jpg', 104, '2022-05-16 04:45:08', '2022-05-16 04:45:08'),
(183, '20210222102656_005650057_3.jpg', 104, '2022-05-16 04:45:08', '2022-05-16 04:45:08'),
(184, '20190725141819_005150396_2.jpg', 105, '2022-05-16 04:48:35', '2022-05-16 04:48:35'),
(185, '20210222104928_005649042_2.jpg', 106, '2022-05-16 04:53:08', '2022-05-16 04:53:08'),
(186, '20210222104928_005649042_3.jpg', 106, '2022-05-16 04:53:08', '2022-05-16 04:53:08'),
(187, '20210222104928_005649042_4.jpg', 106, '2022-05-16 04:53:08', '2022-05-16 04:53:08'),
(188, '20211203131749_005930342_3.jpg', 107, '2022-05-16 04:57:37', '2022-05-16 04:57:37'),
(189, '20211203131749_005930342_2.jpg', 107, '2022-05-16 04:57:37', '2022-05-16 04:57:37'),
(190, '20211203131749_005930342_4.jpg', 107, '2022-05-16 04:57:37', '2022-05-16 04:57:37'),
(191, '20220127175038_005982785_2.jpg', 108, '2022-05-16 05:04:57', '2022-05-16 05:04:57'),
(192, '20220127175038_005982785_3.jpg', 108, '2022-05-16 05:04:57', '2022-05-16 05:04:57'),
(193, '20210629171156_005801543_3.jpg', 1, '2022-05-16 05:05:59', '2022-05-16 05:05:59'),
(194, '20210629171156_005801543_4.jpg', 1, '2022-05-16 05:05:59', '2022-05-16 05:05:59'),
(195, '20210629171156_005801543_9.jpg', 1, '2022-05-16 05:05:59', '2022-05-16 05:05:59'),
(196, '20161111232912_002800725_2.jpg', 109, '2022-05-16 05:23:10', '2022-05-16 05:23:10'),
(197, '20211213171343_005934052_3.jpg', 110, '2022-05-16 05:25:17', '2022-05-16 05:25:17'),
(198, '20211213171343_005934052_4.jpg', 110, '2022-05-16 05:25:17', '2022-05-16 05:25:17'),
(199, '20210719155852_005823747_3.jpg', 111, '2022-05-16 05:32:12', '2022-05-16 05:32:12'),
(200, '20210719155852_005823747_4.jpg', 111, '2022-05-16 05:32:12', '2022-05-16 05:32:12'),
(201, '20210322101921_005701572_5.jpg', 114, '2022-05-16 05:57:01', '2022-05-16 05:57:01'),
(202, '20210322101921_005701572_6.jpg', 114, '2022-05-16 05:57:01', '2022-05-16 05:57:01'),
(203, '20211018195633_005908454_2.jpg', 115, '2022-05-16 05:58:51', '2022-05-16 05:58:51'),
(204, '20211018195633_005908454_3.jpg', 115, '2022-05-16 05:58:51', '2022-05-16 05:58:51'),
(205, '20180809130249_004480261_2.jpg', 116, '2022-05-16 06:01:24', '2022-05-16 06:01:24');

-- --------------------------------------------------------

--
-- Структура таблицы `product_materials`
--

CREATE TABLE `product_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_materials`
--

INSERT INTO `product_materials` (`id`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Натуральна шкіра', 'genuine-leather', 1, NULL, '2022-02-14 16:56:05'),
(2, 'ПВХ', 'pvh', 1, NULL, '2022-02-13 18:30:56'),
(3, 'Штучна замша', 'faux-suede', 1, NULL, NULL),
(4, 'Поліестер', 'polyester', 1, NULL, '2022-02-13 18:30:56'),
(5, 'Хлопок', 'cotton', 1, NULL, NULL),
(6, 'Акрил', 'acryl', 1, NULL, '2022-02-13 18:30:56'),
(7, 'Пух', 'fluff ', 1, NULL, NULL),
(8, 'Натуральна замша', 'natural-suede ', 1, NULL, NULL),
(9, 'Шковк', 'silk', 1, NULL, NULL),
(10, 'Шерсть', 'wool', 1, NULL, NULL),
(11, 'Бархат', 'velvet', 1, NULL, NULL),
(12, 'Штучна шкіра', 'artificial-leather', 1, NULL, '2022-04-12 15:30:31'),
(13, 'Еластан', 'elastane', 1, NULL, '2022-05-01 06:35:27');

-- --------------------------------------------------------

--
-- Структура таблицы `product_product_material`
--

CREATE TABLE `product_product_material` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_material_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_product_material`
--

INSERT INTO `product_product_material` (`id`, `product_id`, `product_material_id`, `created_at`, `updated_at`) VALUES
(38, 8, 2, NULL, NULL),
(39, 8, 3, NULL, NULL),
(81, 22, 2, NULL, NULL),
(82, 22, 4, NULL, NULL),
(120, 28, 2, NULL, NULL),
(121, 28, 3, NULL, NULL),
(122, 28, 4, NULL, NULL),
(143, 11, 4, NULL, NULL),
(144, 11, 5, NULL, NULL),
(145, 11, 6, NULL, NULL),
(146, 9, 10, NULL, NULL),
(147, 9, 11, NULL, NULL),
(148, 9, 12, NULL, NULL),
(149, 13, 4, NULL, NULL),
(150, 13, 5, NULL, NULL),
(151, 13, 6, NULL, NULL),
(165, 35, 2, NULL, NULL),
(166, 35, 3, NULL, NULL),
(183, 29, 2, NULL, NULL),
(184, 29, 4, NULL, NULL),
(185, 5, 1, NULL, NULL),
(186, 5, 2, NULL, NULL),
(187, 5, 6, NULL, NULL),
(253, 2, 4, NULL, NULL),
(254, 2, 6, NULL, NULL),
(261, 27, 2, NULL, NULL),
(262, 27, 4, NULL, NULL),
(323, 31, 4, NULL, NULL),
(324, 31, 5, NULL, NULL),
(325, 31, 8, NULL, NULL),
(404, 36, 4, NULL, NULL),
(405, 36, 5, NULL, NULL),
(495, 30, 2, NULL, NULL),
(496, 30, 3, NULL, NULL),
(497, 30, 4, NULL, NULL),
(500, 95, 5, NULL, NULL),
(501, 95, 13, NULL, NULL),
(502, 96, 4, NULL, NULL),
(503, 96, 5, NULL, NULL),
(504, 96, 13, NULL, NULL),
(505, 97, 4, NULL, NULL),
(506, 97, 5, NULL, NULL),
(507, 97, 8, NULL, NULL),
(508, 3, 3, NULL, NULL),
(509, 3, 4, NULL, NULL),
(510, 3, 5, NULL, NULL),
(511, 98, 4, NULL, NULL),
(512, 98, 11, NULL, NULL),
(513, 98, 13, NULL, NULL),
(514, 99, 4, NULL, NULL),
(515, 99, 5, NULL, NULL),
(516, 99, 6, NULL, NULL),
(517, 100, 4, NULL, NULL),
(518, 100, 5, NULL, NULL),
(519, 101, 5, NULL, NULL),
(521, 102, 13, NULL, NULL),
(522, 103, 1, NULL, NULL),
(523, 104, 1, NULL, NULL),
(524, 104, 2, NULL, NULL),
(525, 105, 1, NULL, NULL),
(526, 105, 2, NULL, NULL),
(527, 105, 6, NULL, NULL),
(528, 106, 1, NULL, NULL),
(529, 106, 6, NULL, NULL),
(530, 33, 5, NULL, NULL),
(535, 107, 4, NULL, NULL),
(536, 107, 9, NULL, NULL),
(537, 32, 5, NULL, NULL),
(538, 32, 9, NULL, NULL),
(539, 32, 10, NULL, NULL),
(544, 108, 2, NULL, NULL),
(545, 108, 6, NULL, NULL),
(546, 108, 8, NULL, NULL),
(551, 1, 2, NULL, NULL),
(552, 1, 4, NULL, NULL),
(553, 1, 5, NULL, NULL),
(554, 1, 6, NULL, NULL),
(555, 109, 4, NULL, NULL),
(556, 109, 5, NULL, NULL),
(557, 110, 4, NULL, NULL),
(558, 110, 11, NULL, NULL),
(559, 110, 13, NULL, NULL),
(560, 111, 4, NULL, NULL),
(561, 111, 8, NULL, NULL),
(562, 111, 13, NULL, NULL),
(563, 112, 2, NULL, NULL),
(564, 112, 4, NULL, NULL),
(565, 112, 8, NULL, NULL),
(566, 113, 2, NULL, NULL),
(567, 113, 4, NULL, NULL),
(568, 113, 6, NULL, NULL),
(569, 114, 2, NULL, NULL),
(570, 114, 4, NULL, NULL),
(571, 114, 5, NULL, NULL),
(572, 115, 5, NULL, NULL),
(573, 115, 13, NULL, NULL),
(574, 116, 4, NULL, NULL),
(575, 116, 5, NULL, NULL),
(576, 117, 4, NULL, NULL),
(577, 117, 5, NULL, NULL),
(578, 117, 6, NULL, NULL),
(579, 118, 5, NULL, NULL),
(580, 118, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `product_product_size`
--

CREATE TABLE `product_product_size` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_size_id` bigint UNSIGNED NOT NULL,
  `count` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_product_size`
--

INSERT INTO `product_product_size` (`id`, `product_id`, `product_size_id`, `count`, `created_at`, `updated_at`) VALUES
(30, 8, 14, 11, NULL, NULL),
(86, 22, 3, 14, NULL, NULL),
(135, 28, 16, 234, NULL, NULL),
(136, 28, 38, 342, NULL, NULL),
(166, 7, 9, 21, NULL, NULL),
(167, 7, 10, 33, NULL, NULL),
(168, 11, 29, 222, NULL, NULL),
(169, 11, 30, 444, NULL, NULL),
(170, 11, 31, 555, NULL, NULL),
(171, 12, 30, 2321, NULL, NULL),
(172, 12, 31, 23, NULL, NULL),
(173, 12, 32, 213, NULL, NULL),
(174, 12, 33, 241, NULL, NULL),
(175, 12, 35, 231, NULL, NULL),
(176, 10, 32, 333, NULL, NULL),
(177, 10, 35, 3333, NULL, NULL),
(178, 10, 36, 123, NULL, NULL),
(179, 10, 37, 1231, NULL, NULL),
(180, 9, 28, 131, NULL, NULL),
(181, 9, 29, 1231, NULL, NULL),
(182, 9, 31, 3112, NULL, NULL),
(183, 9, 33, 123, NULL, NULL),
(186, 13, 33, 123, NULL, NULL),
(198, 35, 12, 231, NULL, NULL),
(199, 35, 13, 2311, NULL, NULL),
(200, 35, 14, 2311, NULL, NULL),
(201, 35, 15, 3312, NULL, NULL),
(234, 29, 22, 213, NULL, NULL),
(235, 29, 28, 312, NULL, NULL),
(236, 29, 33, 1111, NULL, NULL),
(237, 29, 34, 231, NULL, NULL),
(238, 5, 25, 310, NULL, NULL),
(239, 5, 26, 311, NULL, NULL),
(240, 5, 27, 312, NULL, NULL),
(352, 2, 13, 205, NULL, NULL),
(353, 2, 3, 175, NULL, NULL),
(364, 27, 3, 321, NULL, NULL),
(365, 27, 28, 1111, NULL, NULL),
(366, 27, 29, 231, NULL, NULL),
(367, 27, 31, 316, NULL, NULL),
(368, 27, 32, 320, NULL, NULL),
(369, 27, 34, 321, NULL, NULL),
(432, 31, 22, 10, NULL, NULL),
(433, 31, 29, 411, NULL, NULL),
(511, 36, 11, 1311, NULL, NULL),
(512, 36, 12, 131, NULL, NULL),
(513, 36, 13, 1321, NULL, NULL),
(514, 36, 14, 131, NULL, NULL),
(612, 30, 18, 223, NULL, NULL),
(613, 30, 23, 241, NULL, NULL),
(614, 30, 24, 423, NULL, NULL),
(615, 30, 25, 5333, NULL, NULL),
(616, 30, 29, 234, NULL, NULL),
(620, 95, 20, 4234, NULL, NULL),
(621, 95, 22, 342, NULL, NULL),
(622, 95, 24, 234, NULL, NULL),
(623, 95, 26, 4234, NULL, NULL),
(624, 95, 28, 423, NULL, NULL),
(625, 95, 30, 432, NULL, NULL),
(626, 96, 30, 432, NULL, NULL),
(627, 96, 32, 423, NULL, NULL),
(628, 96, 34, 1342, NULL, NULL),
(629, 96, 36, 432, NULL, NULL),
(630, 96, 38, 423, NULL, NULL),
(631, 97, 30, 313, NULL, NULL),
(632, 97, 32, 321, NULL, NULL),
(633, 97, 34, 333, NULL, NULL),
(634, 97, 36, 312, NULL, NULL),
(635, 97, 38, 212, NULL, NULL),
(636, 3, 34, 520, NULL, NULL),
(637, 3, 36, 331, NULL, NULL),
(638, 3, 38, 312, NULL, NULL),
(639, 3, 40, 213, NULL, NULL),
(640, 98, 34, 432, NULL, NULL),
(641, 98, 36, 5612, NULL, NULL),
(642, 98, 38, 413, NULL, NULL),
(643, 98, 40, 3461, NULL, NULL),
(644, 98, 43, 4315, NULL, NULL),
(645, 99, 32, 3412, NULL, NULL),
(646, 99, 34, 421, NULL, NULL),
(647, 99, 36, 314, NULL, NULL),
(648, 99, 38, 421, NULL, NULL),
(649, 4, 26, 2335, NULL, NULL),
(650, 4, 27, 52337, NULL, NULL),
(651, 4, 28, 2341, NULL, NULL),
(652, 100, 32, 312, NULL, NULL),
(653, 100, 34, 312, NULL, NULL),
(654, 100, 36, 321, NULL, NULL),
(655, 100, 38, 312, NULL, NULL),
(656, 100, 40, 311, NULL, NULL),
(657, 101, 34, 412, NULL, NULL),
(658, 101, 36, 453, NULL, NULL),
(659, 101, 38, 4563, NULL, NULL),
(660, 101, 40, 876, NULL, NULL),
(661, 102, 2, 542, NULL, NULL),
(662, 102, 7, 543, NULL, NULL),
(663, 104, 28, 321, NULL, NULL),
(664, 104, 29, 3541, NULL, NULL),
(665, 104, 30, 412, NULL, NULL),
(666, 104, 31, 453, NULL, NULL),
(667, 104, 33, 213, NULL, NULL),
(668, 104, 35, 2131, NULL, NULL),
(669, 105, 28, 641, NULL, NULL),
(670, 105, 29, 342, NULL, NULL),
(671, 105, 30, 4231, NULL, NULL),
(672, 105, 31, 423, NULL, NULL),
(673, 105, 32, 6775, NULL, NULL),
(674, 106, 30, 6534, NULL, NULL),
(675, 106, 31, 242, NULL, NULL),
(676, 106, 32, 634, NULL, NULL),
(677, 106, 33, 6223, NULL, NULL),
(678, 106, 34, 673, NULL, NULL),
(679, 106, 35, 7452, NULL, NULL),
(690, 107, 34, 452, NULL, NULL),
(691, 107, 36, 867, NULL, NULL),
(692, 107, 38, 745, NULL, NULL),
(693, 107, 40, 745, NULL, NULL),
(694, 107, 42, 754, NULL, NULL),
(695, 32, 20, 311, NULL, NULL),
(696, 32, 23, 132, NULL, NULL),
(699, 108, 30, 522, NULL, NULL),
(700, 108, 31, 23434, NULL, NULL),
(701, 108, 32, 123, NULL, NULL),
(702, 108, 33, 423, NULL, NULL),
(703, 108, 34, 235, NULL, NULL),
(706, 1, 33, 231, NULL, NULL),
(707, 1, 37, 213, NULL, NULL),
(708, 109, 10, 3432, NULL, NULL),
(709, 109, 12, 412, NULL, NULL),
(710, 109, 14, 421, NULL, NULL),
(711, 110, 10, 341, NULL, NULL),
(712, 110, 12, 343, NULL, NULL),
(713, 110, 16, 423, NULL, NULL),
(714, 111, 9, 423, NULL, NULL),
(715, 111, 10, 535, NULL, NULL),
(716, 111, 12, 654, NULL, NULL),
(717, 111, 14, 64, NULL, NULL),
(718, 111, 16, 654, NULL, NULL),
(719, 112, 11, 5434, NULL, NULL),
(720, 112, 12, 453, NULL, NULL),
(721, 112, 13, 543, NULL, NULL),
(722, 112, 14, 423, NULL, NULL),
(723, 112, 15, 323, NULL, NULL),
(724, 113, 14, 432, NULL, NULL),
(725, 113, 16, 12, NULL, NULL),
(726, 113, 17, 76, NULL, NULL),
(727, 113, 18, 867, NULL, NULL),
(728, 113, 20, 667, NULL, NULL),
(729, 114, 17, 234, NULL, NULL),
(730, 114, 18, 342, NULL, NULL),
(731, 114, 19, 23, NULL, NULL),
(732, 114, 20, 534, NULL, NULL),
(733, 115, 10, 123, NULL, NULL),
(734, 115, 12, 423, NULL, NULL),
(735, 115, 14, 423, NULL, NULL),
(736, 115, 16, 342, NULL, NULL),
(737, 116, 14, 423, NULL, NULL),
(738, 116, 16, 423, NULL, NULL),
(739, 116, 18, 234, NULL, NULL),
(740, 116, 20, 42, NULL, NULL),
(741, 117, 10, 423, NULL, NULL),
(742, 117, 12, 342, NULL, NULL),
(743, 117, 14, 42, NULL, NULL),
(744, 118, 14, 342, NULL, NULL),
(745, 118, 16, 423, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `product_seasons`
--

CREATE TABLE `product_seasons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_seasons`
--

INSERT INTO `product_seasons` (`id`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Зима', 'winter', 1, NULL, NULL),
(2, 'Весна', 'spring', 1, NULL, NULL),
(3, 'Літо', 'summer', 1, NULL, NULL),
(4, 'Осінь', 'autumn', 1, NULL, NULL),
(5, 'Зима-весна', 'winter-spring', 1, NULL, NULL),
(6, 'Весна-літо', 'spring-summer', 1, NULL, NULL),
(7, 'ЛІто-осінь', 'summer-autumn', 1, NULL, NULL),
(8, 'Осінь-зима', 'autumn-winter', 1, NULL, NULL),
(9, 'Мультисезон', 'multiseason', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `name`, `seo_name`, `active`, `created_at`, `updated_at`) VALUES
(2, '1', 'size-1', 1, NULL, '2022-05-16 04:37:43'),
(3, '2', 'size-2', 1, NULL, '2022-05-01 06:58:24'),
(7, '3', 'size-3', 1, '2022-02-16 10:08:25', '2022-05-16 04:37:43'),
(8, '4', 'size-4', 1, '2022-02-16 10:08:32', '2022-05-01 06:58:24'),
(9, '18', 'size-18', 1, '2022-02-16 10:08:39', '2022-05-01 06:56:17'),
(10, '20', 'size-20', 1, '2022-02-16 10:08:46', '2022-05-01 06:58:24'),
(11, '21', 'size-21', 1, '2022-02-16 10:09:19', '2022-03-24 16:46:08'),
(12, '22', 'size-22', 1, '2022-02-16 10:09:26', '2022-03-24 16:46:08'),
(13, '23', 'size-23', 1, '2022-02-16 10:09:34', '2022-03-24 16:46:08'),
(14, '24', 'size-24', 1, '2022-02-16 10:09:44', '2022-03-24 16:46:08'),
(15, '25', 'size-25', 1, '2022-02-16 10:09:51', '2022-05-15 17:46:49'),
(16, '26', 'size-26', 1, '2022-02-16 10:09:58', '2022-02-16 10:09:58'),
(17, '27', 'size-27', 1, '2022-02-16 10:10:09', '2022-05-15 17:46:49'),
(18, '28', 'size-28', 1, '2022-02-16 10:10:22', '2022-05-15 17:46:50'),
(19, '29', 'size-29', 1, '2022-02-16 12:13:22', NULL),
(20, '30', 'size-30', 1, '2022-02-16 12:13:21', '2022-05-16 05:01:59'),
(21, '31', 'size-31', 1, '2022-02-16 12:13:22', NULL),
(22, '32', 'size-32', 1, '2022-02-16 12:13:23', '2022-03-18 16:23:23'),
(23, '33', 'size-33', 1, '2022-02-16 12:13:23', '2022-05-16 05:01:59'),
(24, '34', 'size-34', 1, '2022-02-16 12:13:24', '2022-05-15 17:44:07'),
(25, '35', 'size-35', 1, NULL, '2022-05-15 17:44:07'),
(26, '36', 'size-36', 1, '2022-02-16 12:13:24', '2022-05-16 04:30:15'),
(27, '37', 'size-37', 1, NULL, '2022-05-16 04:30:15'),
(28, '38', 'size-38', 1, NULL, '2022-05-16 04:30:15'),
(29, '39', 'size-39', 1, NULL, '2022-05-15 17:44:07'),
(30, '40', 'size-40', 1, NULL, '2022-02-21 17:23:09'),
(31, '41', 'size-41', 1, NULL, '2022-03-17 07:57:13'),
(32, '42', 'size-42', 1, NULL, '2022-03-17 07:57:13'),
(33, '43', 'size-43', 1, NULL, '2022-05-16 05:06:22'),
(34, '44', 'size-44', 1, NULL, '2022-05-16 05:01:48'),
(35, '45', 'size-45', 1, NULL, '2022-02-21 17:23:34'),
(36, '46', 'size-46', 1, NULL, '2022-05-16 05:01:48'),
(37, '47', 'size-47', 1, NULL, '2022-05-16 05:06:22'),
(38, '48', 'size-48', 1, NULL, '2022-05-16 05:01:48'),
(39, '49', 'size-49', 1, NULL, NULL),
(40, '50', 'size-50', 1, NULL, '2022-05-16 05:01:48'),
(42, '52', 'size-52', 1, '2022-05-16 04:18:53', '2022-05-16 05:01:48'),
(43, '54', 'size-54', 1, '2022-05-16 04:19:02', '2022-05-16 04:19:02');

-- --------------------------------------------------------

--
-- Структура таблицы `status_lists`
--

CREATE TABLE `status_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status_lists`
--

INSERT INTO `status_lists` (`id`, `name`, `seo_name`, `created_at`, `updated_at`) VALUES
(1, 'Новий', 'new', NULL, NULL),
(2, 'Оброблений', 'processed', NULL, NULL),
(3, 'Оплачений', 'paid', NULL, NULL),
(4, 'Доставляється', 'delivering', NULL, NULL),
(5, 'Доставлений', 'delivered', NULL, NULL),
(6, 'Завершений', 'completed', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `title`, `name`, `seo_name`, `category_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Джинси жіночі', 'Джинси', 'jeans-women', 1, 1, NULL, '2022-05-15 17:47:58'),
(2, 'Светри жіночі', 'Светри', 'sweaters-women', 1, 1, NULL, '2022-05-15 17:47:58'),
(3, 'Кросівки чоловічі', 'Кросівки', 'sneakers-men', 5, 1, NULL, NULL),
(4, 'Плаття жіночі', 'Плаття', 'dresses-women', 1, 1, NULL, '2022-05-15 17:47:58'),
(5, 'Браслети жіночі', 'Браслети', 'braclet-women', 3, 1, NULL, '2022-02-16 10:32:30'),
(6, 'Футболки жіночі', 'Футболки', 't-shirt-women', 1, 1, NULL, '2022-05-15 17:47:58'),
(7, 'Кросівки жіночі ', 'Кросівки', 'sneakers-women', 2, 1, NULL, '2022-03-17 15:58:58'),
(10, 'Джинси чоловічі', 'Джинси', 'jeans-men', 4, 1, '2022-02-16 10:36:05', '2022-02-16 10:44:52'),
(11, 'Светри чоловічі', 'Светри', 'sweaters-men', 4, 1, '2022-02-16 10:41:27', '2022-02-16 10:41:27'),
(12, 'Футболки чоловічі', 'Футболки', 't-shirt-men', 4, 0, '2022-02-16 10:42:01', '2022-03-17 11:56:16'),
(13, 'Сорочки чоловічі', 'Сорочки', 'shirt-men', 4, 1, '2022-02-16 10:43:26', '2022-05-16 04:55:28'),
(14, 'Сорочки жіночі', 'Сорочки', 'shirt-women', 1, 1, '2022-02-16 10:43:48', '2022-05-16 04:54:50'),
(15, 'Зонти чоловічі', 'Зонти', 'umbrella-men', 6, 1, '2022-02-16 16:32:00', '2022-04-16 12:58:54'),
(16, 'Футболки для хлопчиків', 'Футболки', 'boys-tshirts', 16, 1, '2022-02-21 18:04:56', '2022-02-21 18:04:56'),
(17, 'Плаття для дівчаток', 'Плаття', 'dress-girls', 17, 1, '2022-02-21 18:09:57', '2022-05-01 07:16:00'),
(20, 'Зонти жіночі', 'Зонти', 'zonty-zhinochi', 3, 1, '2022-05-16 04:38:32', '2022-05-16 04:51:48'),
(21, 'Чоботи жіночі', 'Чоботи', 'choboty-zhinochi', 2, 1, '2022-05-16 04:44:17', '2022-05-16 04:51:54'),
(22, 'Туфлі чоловічі', 'Туфлі', 'tyfli-cholovichi', 5, 1, '2022-05-16 04:51:24', '2022-05-16 04:51:59'),
(23, 'Вишиванки для дівчаток', 'Вишиванки', 'vyshyvanky-dlya-divchatok', 17, 1, '2022-05-16 05:21:32', '2022-05-16 05:21:32'),
(24, 'Чоботи для дівчаток', 'Чоботи', 'choboty-dlya-divchatok', 25, 1, '2022-05-16 05:29:11', '2022-05-16 05:29:11'),
(25, 'Сандалі для хлопчиків', 'Сандалі', 'sandali-dlya-hlopchykiv', 26, 1, '2022-05-16 05:52:18', '2022-05-16 05:52:18'),
(26, 'Гольфи для хлопчиків', 'Гольфи', 'golfi-hlopchiki', 16, 1, '2022-05-16 05:53:14', '2022-05-16 05:53:14');

-- --------------------------------------------------------

--
-- Структура таблицы `ukraine_cities`
--

CREATE TABLE `ukraine_cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ukraine_cities`
--

INSERT INTO `ukraine_cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Авдіївка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(2, 'Алмазна', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(3, 'Алупка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(5, 'Алушта', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(7, 'Алчевськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(8, 'Ананьїв', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(9, 'Андрушівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(10, 'Антрацит', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(11, 'Апостолове', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(12, 'Армянськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(14, 'Артемівськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(15, 'Арциз', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(16, 'Бібрка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(17, 'Біла', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(18, 'Церква', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(19, 'Білгород-Дністровський', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(20, 'Білогірськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(22, 'Білопілля', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(23, 'Балаклія', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(24, 'Балта', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(25, 'Бар', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(26, 'Баранівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(27, 'Барвінкове', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(28, 'Баришівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(29, 'Бахмач', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(30, 'Бахчисарай', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(32, 'Баштанка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(33, 'Белз', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(34, 'Бердичів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(35, 'Бердянськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(36, 'Берегово', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(37, 'Бережани', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(38, 'Березань', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(39, 'Березне', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(40, 'Берестечко', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(41, 'Берислав', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(42, 'Бершадь', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(43, 'Бобринець', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(44, 'Бобровиця', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(45, 'Богодухів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(46, 'Богуслав', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(47, 'Болград', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(48, 'Болехів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(49, 'Борзна', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(50, 'Борислав', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(51, 'Бориспіль', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(52, 'Бородянка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(53, 'Борщів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(54, 'Боярка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(55, 'Бровари', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(56, 'Броди', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(57, 'Брянка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(58, 'Буринь', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(59, 'Бурштин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(60, 'Буськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(61, 'Буча', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(62, 'Бучач', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(63, 'Вільногірськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(64, 'Вільнянськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(65, 'Вільшанка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(66, 'Вінниця', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(67, 'Валки', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(68, 'Вараш', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(69, 'Варва', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(70, 'Василівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(71, 'Васильків', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(72, 'Ватутіне', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(73, 'Вахрушеве', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(74, 'Вашківці', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(75, 'Великі', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(76, 'Мости', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(77, 'Великий', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(78, 'Бурлук', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(79, 'Верхньодніпровськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(80, 'Вижниця', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(81, 'Виноградов', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(82, 'Вишгород', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(83, 'Вишневе', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(84, 'Вовчанськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(86, 'Вознесенськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(87, 'Волноваха', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(88, 'Володарка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(89, 'Володимир-Волинський', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(90, 'Волочиськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(91, 'Вугледар', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(92, 'Гірське', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(93, 'Гадяч', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(94, 'Гайворон', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(95, 'Гайсин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(96, 'Галич', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(98, 'Генічеськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(99, 'Герца', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(100, 'Глиняни', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(101, 'Глобине', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(102, 'Глухів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(103, 'Гола', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(104, 'Пристань', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(105, 'Голованівськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(106, 'Горішні', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(107, 'Плавні', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(108, 'Горлівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(109, 'Городенка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(110, 'Городище', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(112, 'Городня', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(113, 'Городок', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(114, 'Горохів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(115, 'Гребінка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(116, 'Гуляйполе', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(117, 'Гусятин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(118, 'Дебальцеве', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(119, 'Деражня', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(120, 'Дергачі', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(121, 'Десна', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(122, 'Джанкой', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(124, 'Дзержинськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(126, 'Димитров', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(127, 'Дніпро', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(128, 'Добровеличківка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(129, 'Добромиль', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(130, 'Добропілля', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(131, 'Докучаєвськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(132, 'Долина', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(133, 'Долинська', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(134, 'Донецьк', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(136, 'Дрогобич', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(137, 'Дружківка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(138, 'Дубляни', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(139, 'Дубно', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(140, 'Дубровиця', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(141, 'Дунаївці', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(142, 'Енергодар', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(143, 'Жашків', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(144, 'Жданівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(145, 'Жидачів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(146, 'Житомир', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(147, 'Жмеринка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(148, 'Жовква', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(149, 'Жовті', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(150, 'Води', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(151, 'Зіньків', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(152, 'Заліщики', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(153, 'Запоріжжя', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(154, 'Заставна', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(155, 'Збараж', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(156, 'Зборів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(157, 'Звенигородка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(158, 'Згурівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(159, 'Здолбунів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(160, 'Зимогір\'я', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(161, 'Зміїв', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(162, 'Знам\'янка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(163, 'Золоте', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(164, 'Золотоноша', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(165, 'Золочів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(166, 'Зоринськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(167, 'Зугрес', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(168, 'Ківерці', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(169, 'Кілія', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(170, 'Кіровоград', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(171, 'Кіровське', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(172, 'Кіцмань', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(173, 'Кагарлик', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(174, 'Калинівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(175, 'Калуш', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(176, 'Кам\'янець-Подільський', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(177, 'Кам\'янка-Бузька', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(178, 'Кам\'янка-Дніпровська', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(179, 'Кам\'янське', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(180, 'Камінь-Каширський', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(181, 'Канів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(182, 'Каргалык', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(183, 'Карлівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(184, 'Каховка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(185, 'Керч', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(187, 'Києво-Святий', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(188, 'Кодима', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(189, 'Козовій', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(190, 'Козятин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(191, 'Коломия', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(192, 'Компаніївка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(193, 'Конотоп', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(194, 'Корець', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(195, 'Короп', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(196, 'Коростень', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(197, 'Коростишів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(198, 'Корсунь-Шевченківський', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(199, 'Корюківка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(200, 'Косів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(201, 'Костопіль', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(202, 'Костянтинівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(203, 'Котовськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(205, 'Краматорськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(206, 'Красилів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(207, 'Красноармійськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(209, 'Красногвардійське', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(210, 'Красноград', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(211, 'Краснодон', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(212, 'Красноперекопськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(214, 'Красятичі', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(215, 'Кременець', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(216, 'Кременчук', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(217, 'Кривий Ріг', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(219, 'Кролевець', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(220, 'Куликівка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(221, 'Купянск', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(222, 'Ладижин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(223, 'Ланівці', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(224, 'Лебедин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(225, 'Леніне', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(226, 'Лисичанськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(227, 'Лозова', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(228, 'Лохвиця', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(229, 'Лубни', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(230, 'Луганськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(231, 'Лутугине', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(232, 'Луцьк', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(233, 'Львів', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(234, 'Любашевка', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(235, 'Любомль', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(236, 'Люботин', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(237, 'Міусинськ', '2022-03-31 17:47:58', '2022-03-31 17:47:58'),
(238, 'Майорських', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(239, 'Макіївка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(240, 'Мала', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(241, 'Виска', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(242, 'Малин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(243, 'Маріуполь', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(244, 'Марганець', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(245, 'Мелітополь', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(246, 'Мена', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(247, 'Мерефа', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(248, 'Миколаїв', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(249, 'Миргород', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(250, 'Миронівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(251, 'Могилів-Подільський', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(252, 'Молодогвардійськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(253, 'Молочанськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(254, 'Монастириська', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(255, 'Монастирище', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(256, 'Мостиська', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(257, 'Мукачево', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(258, 'Ніжин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(259, 'Нікополь', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(260, 'Надвірна', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(261, 'Немирів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(262, 'Нетішин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(263, 'Нижньогірський', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(264, 'Нова Каховка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(265, 'Каховка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(267, 'Одеса', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(268, 'Новгород-Сіверський', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(269, 'Новгородка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(270, 'Новий Буг', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(271, 'Буг', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(272, 'Новий', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(273, 'Розділ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(274, 'Новоархангельськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(275, 'Нововолинськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(276, 'Новоград-Волинський', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(277, 'Новогродівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(278, 'Новодністровськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(279, 'Новодружеськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(280, 'Новомиргород', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(281, 'Новомосковськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(283, 'Новопсков', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(284, 'Новоселиця', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(285, 'Новоукраїнка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(286, 'Носівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(287, 'Обухів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(288, 'Овруч', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(289, 'Одеса', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(290, 'Олевск', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(291, 'Олександрівськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(293, 'Олександрія', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(294, 'Олешки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(295, 'Онуфріївка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(296, 'Орєхов', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(297, 'Орджонікідзе', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(298, 'Остер', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(299, 'Острог', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(300, 'Охтирка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(301, 'Очаків', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(302, 'П\'ятихатки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(303, 'Південне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(304, 'Підволочиськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(305, 'Підгайці', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(306, 'Підгородне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(307, 'Павлоград', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(308, 'Первомайськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(310, 'Первомайський', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(311, 'Перевальськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(312, 'Перемишляни', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(313, 'Перечин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(314, 'Перещепине', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(315, 'Переяслав-Хмельницький', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(316, 'Переяслав-Хмельницький', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(317, 'Першотравенськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(318, 'Петрівське', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(319, 'Петрове', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(320, 'Пирятин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(321, 'Погребище', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(322, 'Подволочинск', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(323, 'Пологи', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(324, 'Полонне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(325, 'Полтава', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(326, 'Попасна', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(327, 'Почаїв', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(328, 'Привілля', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(329, 'Прилуки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(330, 'Приморськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(332, 'Прип\'ять', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(333, 'Пустомити', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(334, 'Путивль', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(335, 'Рівне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(336, 'Ріпки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(337, 'Рава', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(339, 'Руська', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(340, 'Радехів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(341, 'Радивилів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(342, 'Радомишль', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(343, 'Рахів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(344, 'Ржищів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(345, 'Ровеньки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(346, 'Рогатин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(347, 'Рожище', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(348, 'Роздольне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(349, 'Рокитне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(350, 'Ромни', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(351, 'Рубіжне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(352, 'Рудки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(353, 'Сєвєродонецьк', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(354, 'Сімферополь', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(356, 'Саки', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(358, 'Самбір', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(359, 'Сарни', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(360, 'Світловодськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(361, 'Свалява', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(362, 'Сватове', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(363, 'Свердловськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(364, 'Севастополь', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(366, 'Седнєв', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(367, 'Селидове', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(368, 'Семенівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(369, 'Середина', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(371, 'Буда', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(372, 'Синельникове', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(373, 'Скадовськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(374, 'Скалат', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(375, 'Сквира', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(376, 'Сколе', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(377, 'Славута', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(378, 'Славутич', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(379, 'Слов\'янськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(380, 'Сміла', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(381, 'Снігурівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(382, 'Сніжне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(383, 'Снятин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(384, 'Сокаль', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(385, 'Сокиряни', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(395, 'Старобільськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(396, 'Старокостянтинів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(397, 'Стаханов', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(398, 'Сторожинець', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(399, 'Стрий', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(400, 'Судак', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(402, 'Суми', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(403, 'Суходільськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(404, 'Таврійськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(405, 'Талалаївка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(406, 'Тальне', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(407, 'Тараща', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(408, 'Татарбунари', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(409, 'Теплогірськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(410, 'Теплодар', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(411, 'Теребовля', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(412, 'Тернівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(413, 'Тернопіль', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(414, 'Тетіїв', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(415, 'Тисмениця', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(416, 'Тлумач', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(417, 'Токмак', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(418, 'Торез', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(419, 'Тростянець', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(420, 'Трускавець', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(421, 'Тульчин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(422, 'Тячів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(423, 'Угнів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(424, 'Ужгород', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(425, 'Узин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(426, 'Українка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(427, 'Ульяновка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(428, 'Умань', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(429, 'Устилуг', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(430, 'Устинівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(431, 'Фастів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(432, 'Феодосія', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(434, 'Харків', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(435, 'Харцизьк', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(436, 'Херсон', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(437, 'Хирів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(438, 'Хмільник', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(439, 'Хмельницький', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(440, 'Хорол', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(441, 'Хотин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(442, 'Христинівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(443, 'Хуст', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(444, 'Червоний', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(445, 'Лиман', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(446, 'Червоний', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(448, 'Червоноград', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(449, 'Червонозаводське', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(450, 'Червонопартизанськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(451, 'Черкаси', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(452, 'Чернівці', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(453, 'Чернігів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(454, 'Чигирин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(455, 'Чоп', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(456, 'Чорнобиль', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(457, 'Чорноморське', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(458, 'Чортків', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(459, 'Чугуїв', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(460, 'Шаргород', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(461, 'Шахтарськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(462, 'Шепетівка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(463, 'Шостка', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(464, 'Шпола', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(465, 'Шумськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(466, 'Щастя', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(467, 'Щолкіно', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(468, 'Щорс', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(469, 'Южноукраїнськ', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(470, 'Яворів', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(471, 'Яготин', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(472, 'Ялта', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(474, 'Ямпіль', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(475, 'Яремче', '2022-03-31 17:47:59', '2022-03-31 17:47:59'),
(476, 'Ясинувата', '2022-03-31 17:47:59', '2022-03-31 17:47:59');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `superuser` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orders_amount` int NOT NULL DEFAULT '0',
  `orders_sum` int NOT NULL DEFAULT '0',
  `session_token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_session_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `superuser`, `first_name`, `last_name`, `sex`, `city`, `phone`, `orders_amount`, `orders_sum`, `session_token`, `active`, `user_session_token`, `last_logged_in`) VALUES
(10, 'boychuk334@gmail.com', '$2y$10$I2Ix3kaRMtQVKRHjVFJM/uXG7AX6gAt9AMNI8r1VpFI/IsvpZVpn2', 'c5sOkpSDbMHbEcnujxfZsZVrPADiTO7IwWpzboQ7hhn8h9WtXYyKwVEUxeA0', '2022-02-09 16:39:42', '2022-05-16 07:53:21', 1, 'Олександр', 'Бойчук', 'Чоловічий', 'Херсон', '0930553785', 6, 3208, 'pjjERdUcqIJTPhyzZC7BGudVrs6I6MoQfnthi6wIKXgrAchEnTtFAm5hTShx', 1, NULL, '2022-05-16 10:53:21'),
(15, '123@mail.ru', '$2y$10$vPtD3PNyrWhpf8OQj1bxU.CptQeberLyRBZof5.4vgtF.1ZUTjQe2', 'DAf6ZX1qpFYuB7jdozQt3AezTS9ecTf3XJ9T9iljrsY2carOrB8LXhq0fLKS', '2022-02-21 12:59:04', '2022-05-16 07:26:54', 1, 'Иван', 'Иванов', '', 'Херсон', '4324234', 0, 0, '9M2sOHWfS0l9kKeAyHWR9qv7PA2qEdRNwiGY09y3PFCqCgEy29oWcCWW4Lmq', 1, NULL, '2022-05-16 10:23:27'),
(24, 'igorkovalenko@gmail.com', '$2y$10$mOmekpwXUMcG8LIZns5A8.BjYFe.YhEu.w4SdaCWOBORjL70Ue10G', NULL, '2022-04-11 17:40:55', '2022-05-16 06:12:40', 0, 'Ігор', 'Коваленко', '', NULL, NULL, 0, 0, 'fZMXEnvEECuyMiXmQKlyCckZo66tSlyOT5jDfgPbFvEmHrz3zTQDxaAFdnXM', 1, NULL, '2022-04-11 20:40:55');

-- --------------------------------------------------------

--
-- Структура таблицы `user_messages`
--

CREATE TABLE `user_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_messages`
--

INSERT INTO `user_messages` (`id`, `user_id`, `email`, `theme`, `message`, `created_at`, `updated_at`) VALUES
(1, 10, 'boychuk334@gmail.com', 'Неякісні товари', 'Купив декалька товарів з чоловічого асортименту та був вражений якістю, вона дуже погана', '2022-02-15 06:29:35', '2022-02-15 06:29:35'),
(5, 10, 'boychuk334@gmail.com', 'Дякую вам', 'Дуже вдячний за гарну роботу', '2022-03-17 14:49:07', '2022-03-17 14:49:07'),
(6, 10, 'boychuk334@gmail.com', 'Стосовно замовлення', 'За вказаний термін замовлення не надійшло', '2022-03-17 14:49:12', '2022-03-17 14:49:12'),
(7, 10, 'boychuk334@gmail.com', 'Подяка', 'дуже чудовий магазин', '2022-03-22 07:03:14', '2022-03-22 07:03:14'),
(9, NULL, 'admin@mail.ua', 'Тема', 'якесь повідомлення', '2022-05-16 07:14:38', '2022-05-16 07:14:38');

-- --------------------------------------------------------

--
-- Структура таблицы `user_promocodes`
--

CREATE TABLE `user_promocodes` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int DEFAULT NULL,
  `min_cart_total` int DEFAULT NULL,
  `min_cart_products` int DEFAULT NULL,
  `promocode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_promocodes`
--

INSERT INTO `user_promocodes` (`id`, `title`, `description`, `discount`, `min_cart_total`, `min_cart_products`, `promocode`, `active`, `created_at`, `updated_at`) VALUES
(8, 'Знижка 23%', 'Знижка у розмірі 23% на усі товари у кошику. Для застосування промокоду необхідно мати не менше 2-х товарів у кошику та їх загальна вартість повинна бути не менше ₴500.', 23, 500, 2, 'many-orders-code', 1, '2022-04-11 15:43:45', '2022-04-11 16:59:29'),
(9, 'Знижка 15%', 'Знижка у розмірі 15% на усі товари у кошику. Для застосування промокоду необхідно мати не менше 5-ти товарів у кошику та їх загальна вартість повинна бути не менше ₴1000.', 15, 1000, 1, 'special-for-reg-user', 1, '2022-04-11 15:44:58', '2022-05-01 07:05:50');

-- --------------------------------------------------------

--
-- Структура таблицы `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `grade` int NOT NULL DEFAULT '5',
  `review` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_reviews`
--

INSERT INTO `user_reviews` (`id`, `product_id`, `user_id`, `grade`, `review`, `created_at`, `updated_at`) VALUES
(1, 2, 10, 3, 'Чудовий товар! рекомендую до покупки. Мені дуже сподобався і підійшов', '2022-03-13 08:55:49', '2022-03-13 08:55:49'),
(7, 2, 10, 1, 'Фігня повна, якість дуже погана,. Доставляли дуже довго, більше тут не купуватиму', '2022-03-13 08:59:44', '2022-03-13 08:59:44'),
(8, 3, 10, 5, 'Супер!', '2022-03-13 09:30:07', '2022-03-13 09:30:07'),
(9, 3, 10, 3, 'Не дуже', '2022-03-13 09:30:23', '2022-03-13 09:30:23'),
(10, 3, 10, 2, 'Ну такое...', '2022-03-13 09:30:51', '2022-03-13 09:30:51'),
(11, 2, 10, 3, 'Не сподобалось', '2022-03-13 20:02:14', '2022-03-13 20:02:14'),
(12, 2, 10, 5, 'О, клас', '2022-03-13 20:06:01', '2022-03-13 20:06:01'),
(13, 4, 10, 5, 'Норм', '2022-03-16 08:10:06', '2022-03-16 08:10:06'),
(14, 31, 10, 4, 'Сойдет', '2022-03-16 20:15:15', '2022-03-16 20:15:15'),
(15, 4, 10, 4, 'Good', '2022-03-17 11:14:57', '2022-03-17 11:14:57'),
(17, 28, 10, 4, 'Дуже добре', '2022-03-31 18:15:44', '2022-03-31 18:15:44'),
(18, 30, 10, 4, 'Нормально', '2022-03-31 18:37:42', '2022-03-31 18:37:42'),
(21, 98, 10, 5, 'Дуже чудова якість', '2022-05-16 07:11:17', '2022-05-16 07:11:17'),
(22, 98, 10, 2, 'Мені не підійшов розмір', '2022-05-16 07:11:36', '2022-05-16 07:11:36');

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`, `seo_name`, `created_at`, `updated_at`) VALUES
(1, 'Головний Адмін', 'main-admin', NULL, NULL),
(2, 'Адмін замовлень', 'orders-admin', NULL, NULL),
(3, 'Контент-менеджер', 'content-manager', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_user_promocode`
--

CREATE TABLE `user_user_promocode` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_promocode_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_user_promocode`
--

INSERT INTO `user_user_promocode` (`id`, `user_id`, `user_promocode_id`, `created_at`, `updated_at`) VALUES
(10, 10, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_user_role`
--

CREATE TABLE `user_user_role` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_user_role`
--

INSERT INTO `user_user_role` (`id`, `user_id`, `user_role_id`, `created_at`, `updated_at`) VALUES
(26, 10, 1, NULL, NULL),
(30, 15, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура для представления `elastic_products`
--
DROP TABLE IF EXISTS `elastic_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `elastic_products`  AS SELECT DISTINCT `p`.`id` AS `id`, `p`.`name` AS `name`, `p`.`seo_name` AS `seo_name`, `p`.`preview_img_url` AS `preview_img_url`, `p`.`description` AS `description`, `p`.`banner_id` AS `banner_id`, `p`.`price` AS `price`, `p`.`discount` AS `discount`, `p`.`count` AS `count`, `p`.`rating` AS `rating`, `p`.`popularity` AS `popularity`, `p`.`in_stock` AS `in_stock`, `p`.`active` AS `active`, `p`.`created_at` AS `created_at`, `p`.`updated_at` AS `updated_at`, `p`.`category_group_id` AS `product_category_group`, `p`.`category_id` AS `product_category`, `p`.`category_sub_id` AS `product_category_sub`, `p`.`product_color_id` AS `product_color`, `p`.`product_season_id` AS `product_season`, `p`.`product_brand_id` AS `product_brand`, `cg`.`name` AS `cg_name`, `cg`.`seo_name` AS `cg_seo_name`, `c`.`title` AS `c_title`, `c`.`name` AS `c_name`, `c`.`seo_name` AS `c_seo_name`, `sc`.`title` AS `sc_title`, `sc`.`name` AS `sc_name`, `sc`.`seo_name` AS `sc_seo_name`, `pc`.`id` AS `pc_id`, `pc`.`name` AS `pc_name`, `pc`.`seo_name` AS `pc_seo_name`, `ps`.`id` AS `ps_id`, `ps`.`name` AS `ps_name`, `ps`.`seo_name` AS `ps_seo_name`, `pb`.`id` AS `pb_id`, `pb`.`name` AS `pb_name`, `pb`.`seo_name` AS `pb_seo_name`, `pm`.`id` AS `pm_id`, `pm`.`name` AS `pm_name`, `pm`.`seo_name` AS `pm_seo_name`, `psize`.`id` AS `psize_id`, `psize`.`name` AS `psize_name`, `psize`.`seo_name` AS `psize_seo_name` FROM ((((((((((`products` `p` left join `category_groups` `cg` on((`cg`.`id` = `p`.`category_group_id`))) left join `categories` `c` on((`c`.`id` = `p`.`category_id`))) left join `sub_categories` `sc` on((`sc`.`id` = `p`.`category_sub_id`))) left join `product_colors` `pc` on((`pc`.`id` = `p`.`product_color_id`))) left join `product_seasons` `ps` on((`ps`.`id` = `p`.`product_season_id`))) left join `product_brands` `pb` on((`pb`.`id` = `p`.`product_brand_id`))) left join `product_product_size` `ppsi` on((`p`.`id` = `ppsi`.`product_id`))) left join `product_sizes` `psize` on((`psize`.`id` = `ppsi`.`product_size_id`))) left join `product_product_material` `ppm` on((`p`.`id` = `ppm`.`product_id`))) left join `product_materials` `pm` on((`pm`.`id` = `ppm`.`product_material_id`))) WHERE (`p`.`active` <> false) ORDER BY `p`.`id` DESC ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_category_group_id_foreign` (`category_group_id`);

--
-- Индексы таблицы `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_product_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_product_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category_category_group`
--
ALTER TABLE `category_category_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_category_groups_category_group_id_foreign` (`category_group_id`),
  ADD KEY `category_category_groups_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `category_groups`
--
ALTER TABLE `category_groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_lists`
--
ALTER TABLE `orders_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_lists_user_id_foreign` (`user_id`),
  ADD KEY `orders_lists_status_foreign` (`status`);

--
-- Индексы таблицы `order_list_items`
--
ALTER TABLE `order_list_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_list_items_order_id_foreign` (`order_id`),
  ADD KEY `order_list_items_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_foreign` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_group_id_foreign` (`category_group_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_category_sub_id_foreign` (`category_sub_id`),
  ADD KEY `products_product_color_id_foreign` (`product_color_id`),
  ADD KEY `products_product_season_id_foreign` (`product_season_id`),
  ADD KEY `products_product_brand_id_foreign` (`product_brand_id`),
  ADD KEY `products_banner_id_foreign` (`banner_id`);

--
-- Индексы таблицы `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `product_materials`
--
ALTER TABLE `product_materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_product_material`
--
ALTER TABLE `product_product_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_product_material_product_id_foreign` (`product_id`),
  ADD KEY `product_product_material_product_material_id_foreign` (`product_material_id`);

--
-- Индексы таблицы `product_product_size`
--
ALTER TABLE `product_product_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_product_size_product_id_foreign` (`product_id`),
  ADD KEY `product_product_size_product_size_id_foreign` (`product_size_id`);

--
-- Индексы таблицы `product_seasons`
--
ALTER TABLE `product_seasons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status_lists`
--
ALTER TABLE `status_lists`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `ukraine_cities`
--
ALTER TABLE `ukraine_cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_messages_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `user_promocodes`
--
ALTER TABLE `user_promocodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_promocodes_promocode_unique` (`promocode`);

--
-- Индексы таблицы `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_reviews_product_id_foreign` (`product_id`),
  ADD KEY `user_reviews_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_user_promocode`
--
ALTER TABLE `user_user_promocode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_user_promocode_user_id_foreign` (`user_id`),
  ADD KEY `user_user_promocode_user_promocode_id_foreign` (`user_promocode_id`);

--
-- Индексы таблицы `user_user_role`
--
ALTER TABLE `user_user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_user_role_user_id_foreign` (`user_id`),
  ADD KEY `user_user_role_user_role_id_foreign` (`user_role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT для таблицы `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `category_category_group`
--
ALTER TABLE `category_category_group`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `category_groups`
--
ALTER TABLE `category_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT для таблицы `orders_lists`
--
ALTER TABLE `orders_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT для таблицы `order_list_items`
--
ALTER TABLE `order_list_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT для таблицы `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT для таблицы `product_brands`
--
ALTER TABLE `product_brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT для таблицы `product_materials`
--
ALTER TABLE `product_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `product_product_material`
--
ALTER TABLE `product_product_material`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=581;

--
-- AUTO_INCREMENT для таблицы `product_product_size`
--
ALTER TABLE `product_product_size`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=746;

--
-- AUTO_INCREMENT для таблицы `product_seasons`
--
ALTER TABLE `product_seasons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `status_lists`
--
ALTER TABLE `status_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `ukraine_cities`
--
ALTER TABLE `ukraine_cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=477;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `user_promocodes`
--
ALTER TABLE `user_promocodes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user_user_promocode`
--
ALTER TABLE `user_user_promocode`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user_user_role`
--
ALTER TABLE `user_user_role`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_category_group_id_foreign` FOREIGN KEY (`category_group_id`) REFERENCES `category_groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `category_category_group`
--
ALTER TABLE `category_category_group`
  ADD CONSTRAINT `category_category_groups_category_group_id_foreign` FOREIGN KEY (`category_group_id`) REFERENCES `category_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_category_groups_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders_lists`
--
ALTER TABLE `orders_lists`
  ADD CONSTRAINT `orders_lists_status_foreign` FOREIGN KEY (`status`) REFERENCES `status_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `order_list_items`
--
ALTER TABLE `order_list_items`
  ADD CONSTRAINT `order_list_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_list_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_email_foreign` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_group_id_foreign` FOREIGN KEY (`category_group_id`) REFERENCES `category_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_sub_id_foreign` FOREIGN KEY (`category_sub_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_brand_id_foreign` FOREIGN KEY (`product_brand_id`) REFERENCES `product_brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `product_colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_season_id_foreign` FOREIGN KEY (`product_season_id`) REFERENCES `product_seasons` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_product_material`
--
ALTER TABLE `product_product_material`
  ADD CONSTRAINT `product_product_material_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_product_material_product_material_id_foreign` FOREIGN KEY (`product_material_id`) REFERENCES `product_materials` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_product_size`
--
ALTER TABLE `product_product_size`
  ADD CONSTRAINT `product_product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_product_size_product_size_id_foreign` FOREIGN KEY (`product_size_id`) REFERENCES `product_sizes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD CONSTRAINT `user_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_user_promocode`
--
ALTER TABLE `user_user_promocode`
  ADD CONSTRAINT `user_user_promocode_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_user_promocode_user_promocode_id_foreign` FOREIGN KEY (`user_promocode_id`) REFERENCES `user_promocodes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_user_role`
--
ALTER TABLE `user_user_role`
  ADD CONSTRAINT `user_user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_user_role_user_role_id_foreign` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
