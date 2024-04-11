-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 10 apr 2024 om 11:55
-- Serverversie: 5.7.39
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2324_wittekip`
--
CREATE DATABASE IF NOT EXISTS `2324_wittekip` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `2324_wittekip`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `ordered` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Wedstrijd kippen', '2024-01-26 09:15:47', NULL),
(2, 'Verf', '2024-01-26 09:15:47', NULL),
(3, 'Broedmachines', '2024-01-26 09:16:03', NULL),
(4, 'Hokken', '2024-01-26 09:16:03', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `prefixes` varchar(30) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `street` varchar(150) NOT NULL,
  `house_number` varchar(10) NOT NULL,
  `addition` varchar(10) DEFAULT NULL,
  `zipcode` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `prefixes`, `lastname`, `street`, `house_number`, `addition`, `zipcode`, `city`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Johan', '', 'Strootman', 'Boumaboulevard', '573', '', '9721EG', 'Groningen', 'jj.strootman@alfa-college.nl', '$2y$10$1rHX.scZansoHkVSDb9WE.EL7OU1WQ4aNIZVH7bwpAirJ6iQdNCXS', '2024-01-29 15:34:41', '2024-01-29 15:34:41'),
(2, 'Joop', '', 'Kopstoot', 'Gestote koppen laan', '99', 'a', '9900FG', 'Blauwekoppen', 'joop@kopstoot.com', '$2y$10$3S9Or1yK7sAS64io2z/EsuDLJ6VkGWEbg4ebLeWkS6qIkRDejzGKG', '2024-01-31 10:55:19', '2024-01-31 10:55:19'),
(3, 'Truus', '', 'Molensteen', 'Oude molen', '1', '', '9911ZZ', 'Molen', 'truus@molen.com', '$2y$10$Yaxc/E42y1vGCNv1VmvB0OA.KKuQljgcAjWJ7CT2.AntoJEcsj6Yu', '2024-01-31 11:57:03', '2024-01-31 11:57:03');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `price` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `image` varchar(255) NOT NULL DEFAULT 'https://placehold.co/600x600',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Beginners kip', 'Een ideale kip voor beginnende wedstrijd deelnemer. Lichtgewicht waardoor deze kip de pols tijdens het optillen niet belast.', 19.95, 'img/white-chicken.jpg', '2024-01-26 09:19:27', NULL),
(2, 1, 'Gevorderden kip', 'Kip voor de gevorderde wedstrijd deelnemer. Deze kip is gemakkelijk te draaien door zijn aangepaste nek- en rugwervels.', 29.95, 'img/brown-chicken.jpg', '2024-01-26 09:19:27', NULL),
(3, 1, 'Professional kip', 'Voor de professionele wedstrijd deelnemer die iets meer uitdaging heeft. Deze kip is voorzien van een anti-afstootlaag, waardoor de verf beter blijft beklijven.', 49.95, 'img/black-chicken.jpg', '2024-01-26 09:21:57', NULL),
(4, 2, '2.5L Witte verf', 'Ideale hoeveelheid verf voor de beginner die zich thuis op de wedstrijd wil voorbereiden.', 9.95, 'img/witte-verf-2-5l.jpg', '2024-01-26 09:21:57', NULL),
(5, 2, '5L Witte verf', 'Met deze hoeveelheid kunt u thuis twee keer zoveel oefenen. ', 18.90, 'img/witte-verf-5l.jpg', '2024-01-26 09:24:51', NULL),
(6, 3, 'Thuis broedmachine', 'Klein beginnen? Dan is deze broedmachine iets voor u. Ideaal voor de beginner die thuis z\'n eigen voorraad wedstrijdkippen wil fokken.', 79.95, 'img/broedmachine-small.jpg', '2024-01-26 09:24:51', NULL),
(7, 3, 'Professionele broedmachine', 'Een vol automatische broedmachine en volledig programmeerbaar. Speciaal voor de professionele wedstrijd deelnemer.', 209.95, 'img/broedmachine-large.jpg', '2024-01-26 09:27:26', NULL),
(8, 4, 'Basishok', 'Met deze hok kunt als beginner en gevorderde uw voorraad aan wedstrijdkippen netje huisvesten. Uw kippen blijven droog, zijn beschermd tegen weersinvloeden en roofdieren.', 75.00, 'img/kippenhok-small.jpg', '2024-01-26 09:27:26', NULL),
(9, 4, 'Gevorderden hok', 'Ideaal voor de professional. Uw kippen hebben de gelegenheid tot uitlopen, kunnen zich terugtrekken in een geïsoleerd dichte deel van de hok. Hier zijn ze beschermd tegen weer en roofdieren. Door een speciale coating in het dichte deel blijven de kippen ook geschikt in de veren voor de wedstrijden.', 149.00, 'img/kippenhok-medium.jpg', '2024-01-26 09:29:42', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
