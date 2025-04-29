-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 29. 14:03
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `kaszino`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration_seconds` int(11) NOT NULL,
  `reward_amount` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `media_type` varchar(255) DEFAULT 'image',
  `image_path` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `advertisements`
--

INSERT INTO `advertisements` (`id`, `user_id`, `updated_by`, `title`, `description`, `duration_seconds`, `reward_amount`, `image`, `media_type`, `image_path`, `video_path`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 'Summer Sale', 'Enjoy up to 50% off on selected items!', 5, 5.00, 'summer_sale.jpg', 'image', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-29 09:43:32', NULL, NULL),
(2, 1, 1, 'Tech Launch', 'Discover the latest gadgets in our tech launch.', 45, 1.50, 'tech_launch.jpg', 'video', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(3, 1, 1, 'Fitness Promo', 'Join our fitness program and get in shape!', 60, 2.00, 'fitness_promo.jpg', 'image', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(4, 1, 1, 'Travel Deals', 'Explore the world with our exclusive travel deals.', 40, 1.25, 'travel_deals.jpg', 'video', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(5, 1, 1, 'Gaming Event', 'Participate in our gaming event and win prizes.', 50, 1.75, 'gaming_event.jpg', 'image', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(6, 1, 1, 'Cooking Masterclass', 'Learn to cook like a pro with our masterclass.', 35, 1.10, 'cooking_masterclass.jpg', 'video', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(7, 1, 1, 'Fashion Week', 'Catch the latest trends in our fashion week.', 45, 1.50, 'fashion_week.jpg', 'image', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(8, 1, 1, 'Car Show', 'Experience the latest car models at our car show.', 55, 2.00, 'car_show.jpg', 'video', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(9, 1, 1, 'Health Tips', 'Stay healthy with our daily health tips.', 25, 0.75, 'health_tips.jpg', 'image', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL),
(10, 1, 1, 'Book Fair', 'Discover thousands of books at discounted prices.', 40, 1.20, 'book_fair.jpg', 'video', NULL, NULL, 1, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `balance_uploads`
--

CREATE TABLE `balance_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `advertisement_id` bigint(20) UNSIGNED NOT NULL,
  `duration_watched` int(11) NOT NULL DEFAULT 0,
  `reward` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `balance_uploads`
--

INSERT INTO `balance_uploads` (`id`, `user_id`, `advertisement_id`, `duration_watched`, `reward`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 30, 0.75, 'completed', '2025-04-28 07:46:38', '2025-04-28 07:46:38'),
(2, 2, 2, 25, 0.69, 'partial', '2025-04-28 07:46:38', '2025-04-28 07:46:38'),
(3, 3, 3, 60, 3.00, 'completed', '2025-04-28 07:46:38', '2025-04-28 07:46:38'),
(4, 52, 1, 30, 1.00, 'completed', '2025-04-28 14:55:54', '2025-04-28 14:55:54'),
(5, 1, 1, 5, 5.00, 'completed', '2025-04-29 09:43:45', '2025-04-29 09:43:45');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `body`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'This is a sample comment from the admin.', NULL, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(2, 2, 1, 'Szia!', NULL, '2025-04-28 14:50:28', '2025-04-28 14:50:28', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `friendships`
--

CREATE TABLE `friendships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `friendships`
--

INSERT INTO `friendships` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 52, 1, 'accepted', '2025-04-28 14:42:05', '2025-04-28 14:42:05');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `game_logs`
--

CREATE TABLE `game_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_type` varchar(255) NOT NULL,
  `bet_amount` decimal(10,2) NOT NULL,
  `win_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_win` tinyint(1) NOT NULL,
  `game_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`game_data`)),
  `played_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `game_logs`
--

INSERT INTO `game_logs` (`id`, `user_id`, `game_type`, `bet_amount`, `win_amount`, `is_win`, `game_data`, `played_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 52, 'coinflip', 10.00, 0.00, 0, '\"{\\\"user_choice\\\":\\\"heads\\\",\\\"coin_result\\\":\\\"tails\\\"}\"', '2025-04-28 14:26:12', '2025-04-28 14:26:12', '2025-04-28 14:26:12', NULL),
(2, 52, 'coinflip', 10.00, 20.00, 1, '\"{\\\"user_choice\\\":\\\"tails\\\",\\\"coin_result\\\":\\\"tails\\\"}\"', '2025-04-28 14:26:19', '2025-04-28 14:26:19', '2025-04-28 14:26:19', NULL),
(3, 52, 'coinflip', 10.00, 0.00, 0, '\"{\\\"user_choice\\\":\\\"tails\\\",\\\"coin_result\\\":\\\"heads\\\"}\"', '2025-04-28 14:26:23', '2025-04-28 14:26:23', '2025-04-28 14:26:23', NULL),
(4, 52, 'coinflip', 10.00, 0.00, 0, '\"{\\\"user_choice\\\":\\\"tails\\\",\\\"coin_result\\\":\\\"heads\\\"}\"', '2025-04-28 14:26:28', '2025-04-28 14:26:28', '2025-04-28 14:26:28', NULL),
(5, 52, 'coinflip', 10.00, 20.00, 1, '\"{\\\"user_choice\\\":\\\"tails\\\",\\\"coin_result\\\":\\\"tails\\\"}\"', '2025-04-28 14:26:33', '2025-04-28 14:26:33', '2025-04-28 14:26:33', NULL),
(6, 1, 'mines', 10.00, 19.74, 1, '\"{\\\"mines_count\\\":7,\\\"revealed_cells\\\":4,\\\"multiplier\\\":1.9741376780687176}\"', '2025-04-29 09:44:33', '2025-04-29 09:44:33', '2025-04-29 09:44:33', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `game_stats`
--

CREATE TABLE `game_stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_games_played` int(11) NOT NULL DEFAULT 0,
  `total_wins` int(11) NOT NULL DEFAULT 0,
  `total_losses` int(11) NOT NULL DEFAULT 0,
  `total_winnings` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_losses_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `last_played_at` timestamp NULL DEFAULT NULL,
  `game_statistics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`game_statistics`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `game_stats`
--

INSERT INTO `game_stats` (`id`, `user_id`, `total_games_played`, `total_wins`, `total_losses`, `total_winnings`, `total_losses_amount`, `last_played_at`, `game_statistics`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 0, 9.74, 0.00, '2025-04-29 09:44:33', '{\"mines\":{\"wins\":1,\"losses\":0,\"total_played\":1}}', '2025-04-28 07:46:18', '2025-04-29 09:44:33', NULL),
(2, 2, 74, 23, 51, 9460.77, 8092.62, '2024-11-02 12:39:53', '{\"blackjack\":{\"wins\":9,\"losses\":4,\"total_played\":38},\"roulette\":{\"wins\":20,\"losses\":14,\"total_played\":47}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(3, 3, 101, 65, 36, 1966.31, 4281.44, '2025-04-20 11:43:24', '{\"blackjack\":{\"wins\":39,\"losses\":19,\"total_played\":24},\"roulette\":{\"wins\":40,\"losses\":4,\"total_played\":101}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(4, 4, 67, 59, 8, 5621.85, 9375.31, '2024-07-29 08:33:41', '{\"blackjack\":{\"wins\":45,\"losses\":3,\"total_played\":29},\"roulette\":{\"wins\":8,\"losses\":7,\"total_played\":46}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(5, 5, 88, 53, 35, 9216.82, 4806.40, '2025-04-28 01:13:38', '{\"blackjack\":{\"wins\":21,\"losses\":35,\"total_played\":52},\"roulette\":{\"wins\":14,\"losses\":33,\"total_played\":86}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(6, 6, 59, 49, 10, 7370.27, 8226.04, '2024-05-04 07:45:53', '{\"blackjack\":{\"wins\":33,\"losses\":9,\"total_played\":53},\"roulette\":{\"wins\":36,\"losses\":8,\"total_played\":48}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(7, 7, 37, 23, 14, 1835.79, 4321.48, '2025-03-17 23:25:03', '{\"blackjack\":{\"wins\":11,\"losses\":6,\"total_played\":12},\"roulette\":{\"wins\":9,\"losses\":0,\"total_played\":33}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(8, 8, 62, 51, 11, 5769.29, 7817.43, '2024-09-03 16:17:07', '{\"blackjack\":{\"wins\":40,\"losses\":4,\"total_played\":29},\"roulette\":{\"wins\":39,\"losses\":9,\"total_played\":37}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(9, 9, 142, 62, 80, 4504.55, 4064.79, '2024-09-21 06:37:48', '{\"blackjack\":{\"wins\":30,\"losses\":37,\"total_played\":115},\"roulette\":{\"wins\":48,\"losses\":44,\"total_played\":47}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(10, 10, 21, 18, 3, 9385.03, 1868.81, '2025-02-21 15:08:37', '{\"blackjack\":{\"wins\":10,\"losses\":2,\"total_played\":18},\"roulette\":{\"wins\":8,\"losses\":3,\"total_played\":0}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(11, 11, 23, 17, 6, 6432.04, 9203.84, '2024-12-23 10:35:51', '{\"blackjack\":{\"wins\":3,\"losses\":1,\"total_played\":9},\"roulette\":{\"wins\":0,\"losses\":5,\"total_played\":18}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(13, 13, 56, 34, 22, 6364.74, 6022.88, '2024-12-16 00:42:24', '{\"blackjack\":{\"wins\":4,\"losses\":4,\"total_played\":42},\"roulette\":{\"wins\":29,\"losses\":5,\"total_played\":0}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(14, 14, 163, 94, 69, 1939.64, 9912.71, '2024-11-03 07:21:06', '{\"blackjack\":{\"wins\":66,\"losses\":57,\"total_played\":120},\"roulette\":{\"wins\":16,\"losses\":68,\"total_played\":115}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(15, 15, 126, 93, 33, 1509.73, 5425.69, '2024-09-09 18:56:39', '{\"blackjack\":{\"wins\":81,\"losses\":4,\"total_played\":118},\"roulette\":{\"wins\":3,\"losses\":15,\"total_played\":97}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(16, 16, 47, 42, 5, 849.98, 4985.95, '2025-02-11 13:52:48', '{\"blackjack\":{\"wins\":30,\"losses\":5,\"total_played\":6},\"roulette\":{\"wins\":7,\"losses\":3,\"total_played\":29}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(17, 17, 95, 75, 20, 4770.37, 2685.96, '2024-07-20 12:07:29', '{\"blackjack\":{\"wins\":65,\"losses\":0,\"total_played\":89},\"roulette\":{\"wins\":8,\"losses\":5,\"total_played\":58}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(18, 18, 136, 36, 100, 9567.25, 46.63, '2024-11-23 04:05:40', '{\"blackjack\":{\"wins\":11,\"losses\":87,\"total_played\":135},\"roulette\":{\"wins\":29,\"losses\":45,\"total_played\":102}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(19, 19, 35, 0, 35, 1936.77, 8513.63, '2024-08-22 03:57:24', '{\"blackjack\":{\"wins\":0,\"losses\":3,\"total_played\":24},\"roulette\":{\"wins\":0,\"losses\":29,\"total_played\":0}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(20, 20, 85, 11, 74, 687.57, 5589.03, '2024-11-22 19:14:36', '{\"blackjack\":{\"wins\":8,\"losses\":36,\"total_played\":23},\"roulette\":{\"wins\":10,\"losses\":44,\"total_played\":49}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(21, 21, 67, 27, 40, 2666.30, 3029.01, '2025-01-18 08:48:49', '{\"blackjack\":{\"wins\":4,\"losses\":12,\"total_played\":9},\"roulette\":{\"wins\":10,\"losses\":27,\"total_played\":43}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(22, 22, 35, 28, 7, 6828.83, 4748.49, '2024-09-23 11:45:25', '{\"blackjack\":{\"wins\":5,\"losses\":3,\"total_played\":1},\"roulette\":{\"wins\":13,\"losses\":2,\"total_played\":35}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(23, 23, 43, 7, 36, 5879.61, 3153.58, '2024-09-15 03:06:40', '{\"blackjack\":{\"wins\":7,\"losses\":4,\"total_played\":38},\"roulette\":{\"wins\":7,\"losses\":22,\"total_played\":37}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(24, 24, 152, 67, 85, 4875.38, 8779.30, '2025-02-06 05:25:42', '{\"blackjack\":{\"wins\":40,\"losses\":11,\"total_played\":44},\"roulette\":{\"wins\":45,\"losses\":69,\"total_played\":41}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(25, 25, 50, 35, 15, 3037.51, 9703.47, '2025-02-14 21:46:08', '{\"blackjack\":{\"wins\":35,\"losses\":7,\"total_played\":40},\"roulette\":{\"wins\":27,\"losses\":0,\"total_played\":50}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(26, 26, 103, 33, 70, 8895.16, 6082.21, '2024-08-05 05:03:56', '{\"blackjack\":{\"wins\":4,\"losses\":64,\"total_played\":31},\"roulette\":{\"wins\":27,\"losses\":16,\"total_played\":19}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(27, 27, 128, 35, 93, 6119.20, 8918.29, '2025-01-29 03:04:35', '{\"blackjack\":{\"wins\":4,\"losses\":85,\"total_played\":89},\"roulette\":{\"wins\":19,\"losses\":30,\"total_played\":126}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(28, 28, 79, 35, 44, 8789.29, 9936.43, '2025-01-29 19:02:18', '{\"blackjack\":{\"wins\":33,\"losses\":27,\"total_played\":38},\"roulette\":{\"wins\":1,\"losses\":14,\"total_played\":76}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(29, 29, 145, 97, 48, 7112.70, 9533.13, '2024-10-24 20:03:34', '{\"blackjack\":{\"wins\":35,\"losses\":42,\"total_played\":16},\"roulette\":{\"wins\":90,\"losses\":15,\"total_played\":123}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(30, 30, 44, 11, 33, 1467.83, 3064.59, '2025-03-07 23:16:47', '{\"blackjack\":{\"wins\":7,\"losses\":6,\"total_played\":0},\"roulette\":{\"wins\":8,\"losses\":33,\"total_played\":10}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(31, 31, 128, 98, 30, 9356.61, 5997.08, '2025-04-21 00:35:43', '{\"blackjack\":{\"wins\":35,\"losses\":15,\"total_played\":13},\"roulette\":{\"wins\":80,\"losses\":29,\"total_played\":106}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(32, 32, 170, 73, 97, 3563.10, 4800.17, '2025-01-22 23:38:12', '{\"blackjack\":{\"wins\":2,\"losses\":61,\"total_played\":62},\"roulette\":{\"wins\":8,\"losses\":97,\"total_played\":39}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(33, 33, 108, 75, 33, 3513.69, 1181.22, '2025-02-12 23:22:59', '{\"blackjack\":{\"wins\":44,\"losses\":4,\"total_played\":8},\"roulette\":{\"wins\":1,\"losses\":24,\"total_played\":16}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(34, 34, 161, 65, 96, 5035.94, 1652.41, '2024-09-19 03:39:00', '{\"blackjack\":{\"wins\":1,\"losses\":68,\"total_played\":77},\"roulette\":{\"wins\":32,\"losses\":14,\"total_played\":77}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(35, 35, 91, 9, 82, 9904.68, 13.33, '2024-09-07 00:52:45', '{\"blackjack\":{\"wins\":7,\"losses\":11,\"total_played\":65},\"roulette\":{\"wins\":2,\"losses\":11,\"total_played\":34}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(36, 36, 134, 77, 57, 6133.43, 7230.86, '2025-02-18 08:55:59', '{\"blackjack\":{\"wins\":19,\"losses\":49,\"total_played\":106},\"roulette\":{\"wins\":51,\"losses\":29,\"total_played\":3}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(37, 37, 128, 28, 100, 695.55, 7273.40, '2024-08-05 03:29:31', '{\"blackjack\":{\"wins\":21,\"losses\":68,\"total_played\":66},\"roulette\":{\"wins\":23,\"losses\":25,\"total_played\":100}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(38, 38, 128, 50, 78, 1805.25, 5218.48, '2024-08-23 11:43:08', '{\"blackjack\":{\"wins\":8,\"losses\":75,\"total_played\":33},\"roulette\":{\"wins\":28,\"losses\":13,\"total_played\":19}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(39, 39, 127, 49, 78, 4877.36, 8782.46, '2024-07-28 19:11:00', '{\"blackjack\":{\"wins\":44,\"losses\":52,\"total_played\":20},\"roulette\":{\"wins\":29,\"losses\":20,\"total_played\":33}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(40, 40, 127, 28, 99, 2982.46, 1732.72, '2024-08-28 06:50:27', '{\"blackjack\":{\"wins\":15,\"losses\":54,\"total_played\":81},\"roulette\":{\"wins\":1,\"losses\":53,\"total_played\":14}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(41, 41, 87, 51, 36, 8709.24, 2590.30, '2025-04-04 04:34:10', '{\"blackjack\":{\"wins\":20,\"losses\":23,\"total_played\":25},\"roulette\":{\"wins\":34,\"losses\":13,\"total_played\":34}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(42, 42, 105, 32, 73, 750.97, 5617.97, '2024-06-13 15:30:28', '{\"blackjack\":{\"wins\":21,\"losses\":11,\"total_played\":64},\"roulette\":{\"wins\":3,\"losses\":43,\"total_played\":30}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(43, 43, 69, 29, 40, 1720.32, 9941.50, '2024-09-03 05:29:40', '{\"blackjack\":{\"wins\":10,\"losses\":30,\"total_played\":18},\"roulette\":{\"wins\":26,\"losses\":7,\"total_played\":47}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(44, 44, 61, 35, 26, 159.96, 9804.22, '2025-01-07 18:02:17', '{\"blackjack\":{\"wins\":9,\"losses\":15,\"total_played\":53},\"roulette\":{\"wins\":33,\"losses\":26,\"total_played\":19}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(45, 45, 163, 92, 71, 3264.57, 4313.80, '2024-09-30 23:40:39', '{\"blackjack\":{\"wins\":56,\"losses\":7,\"total_played\":134},\"roulette\":{\"wins\":60,\"losses\":6,\"total_played\":103}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(46, 46, 71, 36, 35, 2504.97, 4594.83, '2025-02-20 05:31:05', '{\"blackjack\":{\"wins\":11,\"losses\":21,\"total_played\":42},\"roulette\":{\"wins\":25,\"losses\":33,\"total_played\":50}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(47, 47, 89, 2, 87, 2266.97, 4673.74, '2024-09-30 16:37:36', '{\"blackjack\":{\"wins\":0,\"losses\":52,\"total_played\":68},\"roulette\":{\"wins\":2,\"losses\":5,\"total_played\":45}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(48, 48, 89, 22, 67, 4503.80, 7306.67, '2024-12-30 00:24:41', '{\"blackjack\":{\"wins\":9,\"losses\":40,\"total_played\":87},\"roulette\":{\"wins\":8,\"losses\":12,\"total_played\":40}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(49, 49, 92, 66, 26, 5824.48, 8598.96, '2024-08-22 18:32:14', '{\"blackjack\":{\"wins\":21,\"losses\":6,\"total_played\":61},\"roulette\":{\"wins\":8,\"losses\":16,\"total_played\":55}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(50, 50, 176, 100, 76, 5308.01, 5690.12, '2024-06-19 04:25:54', '{\"blackjack\":{\"wins\":9,\"losses\":49,\"total_played\":36},\"roulette\":{\"wins\":2,\"losses\":34,\"total_played\":26}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(51, 51, 95, 26, 69, 660.04, 8023.77, '2025-04-13 03:35:00', '{\"blackjack\":{\"wins\":16,\"losses\":42,\"total_played\":51},\"roulette\":{\"wins\":0,\"losses\":51,\"total_played\":24}}', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(52, 52, 5, 2, 3, 20.00, 30.00, '2025-04-28 14:26:33', '{\"coinflip\":{\"wins\":2,\"losses\":3,\"total_played\":5}}', '2025-04-28 14:18:44', '2025-04-28 14:26:33', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 52, 1, 'Szia', 0, '2025-04-28 14:44:28', '2025-04-28 14:44:28'),
(2, 1, 52, 'Hello!', 0, '2025-04-28 14:44:56', '2025-04-28 14:44:56');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_02_10_141003_create_personal_access_tokens_table', 1),
(4, '2025_02_15_183545_create_game_logs_table', 1),
(5, '2025_03_16_200516_create_admins_table', 1),
(6, '2025_04_04_072347_create_friendships_table', 1),
(7, '2025_04_04_073248_create_friend_requests_table', 1),
(8, '2025_04_09_093050_create_advertisements_table', 1),
(9, '2025_04_09_093105_create_balance_uploads_table', 1),
(10, '2025_04_15_071704_create_game_stats_table', 1),
(11, '2025_04_21_072510_create_posts_table', 1),
(12, '2025_04_21_072526_create_comments_table', 1),
(13, '2025_04_22_132936_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 52, 'api-token', '86521cbc8231b5087e0edf7e0e969efdcacef4428874f2ab282825a7ffc3336f', '[\"*\"]', NULL, NULL, '2025-04-28 14:23:23', '2025-04-28 14:23:23'),
(2, 'App\\Models\\User', 52, 'api-token', '0fcb7ef9700cfb3dee134204348b6dec4e04075658d38e0411d26cde52753954', '[\"*\"]', '2025-04-28 14:23:37', NULL, '2025-04-28 14:23:30', '2025-04-28 14:23:37'),
(3, 'App\\Models\\User', 52, 'api-token', 'bdec0e67e9304a744b7a6052aeb00ad33fd01c2e3c15addfdde9abe8374aa59a', '[\"*\"]', NULL, NULL, '2025-04-28 14:24:31', '2025-04-28 14:24:31'),
(4, 'App\\Models\\User', 52, 'api-token', '86c17a56947de9d2f4fa4d052966e6669c10af9d7438e60e32d66340f8f2bc55', '[\"*\"]', '2025-04-28 14:26:33', NULL, '2025-04-28 14:26:03', '2025-04-28 14:26:33'),
(5, 'App\\Models\\User', 1, 'api-token', '451ec782d32cfb82d5d37d7854035127b18d15b1b91781a0b4aa3a96ed9bf82c', '[\"*\"]', '2025-04-29 09:44:33', NULL, '2025-04-29 09:44:15', '2025-04-29 09:44:33');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `is_private`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Welcome to the Forum!', 'This is a sample post created by the admin. Feel free to comment and participate!', 0, NULL, '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL),
(2, 52, 'Sziasztok', 'Üdv minden barátomnak!', 1, NULL, '2025-04-28 14:48:45', '2025-04-28 14:48:45', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('afDsBrHiSgcV9UCcgcjCKY9nJxUQfAbdFvMdG8vs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) kaszino-app/1.0.0 Chrome/124.0.6367.243 Electron/30.5.1 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNUlFZEhyZnBOOFU1MU1ZTElKUGlPbVhvWVFDY0xocDFTT0lvZG0xVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2Vyc3RhdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1745927086),
('oATb2C3Htim2iR5N7vO4ps5YVEy9trxVcmPhcHua', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjc0bkpDeW1pZWZhYzlOQm5qb3Q5Z2tLMlZGdGVVZmw1ck95N05UYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9nYW1lcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1745926882),
('oqh1m6tltw8nNorQkeT6aoikHSHxGWXEFIrzxwpu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0dZRmhQcmVYYWFLbGp2OFhXNHh0Y05TblFIZm55d0c0cnh0U3BwUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1745923421);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `suspended_by` bigint(20) UNSIGNED DEFAULT NULL,
  `restored_by` bigint(20) UNSIGNED DEFAULT NULL,
  `destroyed_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `is_admin`, `name`, `email`, `email_verified_at`, `password`, `balance`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `suspended_by`, `restored_by`, `destroyed_by`) VALUES
(1, 1, 'Test Admin', 'test@example.com', NULL, '$2y$12$Tq2/rvn7AlKdA5DwCY.xTO3p0rvJhontfZcFCRdXP0vRBpOXguo7m', 90000014.74, NULL, '2025-04-28 07:46:18', '2025-04-29 09:44:33', NULL, NULL, NULL, NULL),
(2, 0, 'General Hudson', 'delphine41@example.net', '2025-04-28 07:46:18', '$2y$12$gg7spq6aSz6Z5JSNNg.6Iu4Ehfa9/Cg1ycRNI9WDbhzFPh3wGy1TO', 3644.04, '2vbJLrCSkq', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(3, 0, 'Prof. Jaden Stracke PhD', 'wilkinson.amya@example.org', '2025-04-28 07:46:19', '$2y$12$3WcluVx3uYdtMYuWQkteG.Aa/gOd6NFgX/fNgLYvl93Ld1QQBEGO.', 3688.53, 'SovKlVamq7', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(4, 0, 'Dr. Armando Skiles', 'alangworth@example.net', '2025-04-28 07:46:19', '$2y$12$672RnU0n1DFWMFgHf/FM5OBTFPPYdefhM2X6siC57DbmdFgOpd32a', 622.71, 'roIVlCe2tY', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(5, 0, 'Al Crooks', 'trisha.hettinger@example.net', '2025-04-28 07:46:19', '$2y$12$11xO0NF0r4eTEXHxloj2KO.tEIAmwHTck3UANd7MdXuQWYlGW4dDO', 4098.00, 'U5DrZI7OQI', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(6, 0, 'Elroy Heathcote', 'larkin.jamil@example.com', '2025-04-28 07:46:20', '$2y$12$FR1J7m6MyC/.1C3neB5oZuzRplWDpEIb23vU7Wahy/7Stjz0tO63G', 7025.29, 'dMPnygIg9z', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(7, 0, 'Marilie O\'Connell', 'cartwright.aurore@example.com', '2025-04-28 07:46:20', '$2y$12$4T3YW73FC8up3jFlUz845u7GbTyHhjmXyOwoB5oX8kl7DGRAk.PJO', 4481.73, 'TjsTo2nTcP', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(8, 0, 'Dr. Virgie Conroy I', 'wolf.guillermo@example.org', '2025-04-28 07:46:20', '$2y$12$MpsU91gN8l31CjQkrgqSfuOFXHqaWf0BpzKAvFth/uHwRXV6f4FBi', 5633.58, 'Jf8UJSFMrd', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(9, 0, 'Dr. Xander Hodkiewicz MD', 'qjohnston@example.com', '2025-04-28 07:46:21', '$2y$12$AkLu0VbTQnd0VjTvYndci.gQZWRNCMtS.SqS0HvaOphITTN.j..kK', 6958.19, 'AhbCIhccOU', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(10, 0, 'Miss Onie Robel I', 'klein.reece@example.org', '2025-04-28 07:46:21', '$2y$12$OEI1smW5Q51Iet1vPeE.cueD2KVV4qayZf3NKAR/UATIFOt4dc1U6', 480.53, '4iUAh2N5yK', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(11, 0, 'Keegan Bernier', 'julie.larson@example.com', '2025-04-28 07:46:21', '$2y$12$cHnWcfHmn2g3AHx8jy03JeGXsJpgh9.o089ENzTD1OSeQANSyOF7K', 3360.44, 'vfDcFDT4cQ', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(12, 0, 'Mossie Heidenreich', 'reanna27@example.net', '2025-04-28 07:46:22', '$2y$12$2/qLUm3vPQFVpikRg0noPO9pQ2.CUn7FRnmmPtulITSeaL0OI9ewe', 8707.95, '8PzqcXGcUc', '2025-04-29 09:42:09', '2025-04-29 09:42:09', '2025-04-29 09:42:03', 1, NULL, 1),
(13, 0, 'Dennis Bergstrom', 'wisoky.zack@example.net', '2025-04-28 07:46:22', '$2y$12$zUxWMFuqxIqIleUI06l6Je8r8GQT70t19OWhSKe2vhOmvRp7pYJXu', 3601.93, 'IfnG5VKLtO', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(14, 0, 'Demond Daugherty II', 'altenwerth.damien@example.org', '2025-04-28 07:46:22', '$2y$12$7pHMOmqKm1tBrxBLpf8ZJOIe.7JwHKs5lFUco3CFm/Iutrkz8Zv/K', 2505.51, 'APNGvU5G01', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(15, 0, 'Henri Gorczany', 'schmeler.april@example.net', '2025-04-28 07:46:23', '$2y$12$qDg1NQXpaGAsOPDz2lhazO1yabogApd9wtRd36NcYn3hdNpJFrTWa', 9233.66, 'VNyiBSUKCC', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(16, 0, 'Burley Shields Jr.', 'humberto51@example.com', '2025-04-28 07:46:23', '$2y$12$tqm4w3dLsvQSMUi5bJ0PB.CuQ9yEVn1E4DegMzCIsE3CmWKgngy7.', 431.79, '3n5RwSRI3L', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(17, 0, 'Gerry Crooks', 'jasmin.nienow@example.org', '2025-04-28 07:46:23', '$2y$12$jLHwTnGNbDCJYQRd81HTMeSq3SvlgzauZ3fEQIM3u2XNJe7UOtVbK', 8563.13, 'lgqTuhpKMN', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(18, 0, 'Friedrich Wyman', 'grady.orrin@example.net', '2025-04-28 07:46:24', '$2y$12$268g8FOGvCaZiOV2UNqA9uwGDvw3lW7MdjH6cbYguBYg2.acecXlS', 492.75, 'I1RE3zZRbA', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(19, 0, 'Dr. Devin Beier V', 'graham.wayne@example.org', '2025-04-28 07:46:24', '$2y$12$m4DlYXpCQp85VSS3SwHzbuHnR.AZ/EX9KWhQdePjxg4KESXatxzHO', 726.16, 'rbYeivfCbz', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(20, 0, 'Mr. Prince Bergnaum', 'otorphy@example.net', '2025-04-28 07:46:24', '$2y$12$/IMbk7sTAcReRCDzrZyrQu9seCaepVAuljOq0IzPB2CDYHJ6cgZUm', 556.80, 'lIXEo90ii5', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(21, 0, 'Dr. Adam Herzog', 'rosamond13@example.net', '2025-04-28 07:46:25', '$2y$12$ht7ARUc7MlRKuKUzgZHrC.b896WgEyoJ1He2kSuBBs1vsHPzt0vmK', 948.54, 'KwkvAw2y6E', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(22, 0, 'Reyna Hirthe DVM', 'zkemmer@example.org', '2025-04-28 07:46:25', '$2y$12$6Y7GevOEpxXrtShORHm9neXTQhr11EOS1hAK0rjzBncNMfHV60KVK', 9780.93, 'FbxS4a9voF', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(23, 0, 'Kaya Crist PhD', 'antonina95@example.org', '2025-04-28 07:46:25', '$2y$12$mnAkjp3wctJJVeCeMwBWyec6Dm93ndcaAZerrjVdD1ATU63iFyQfe', 3627.28, 'e2VAIljsRw', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(24, 0, 'Mr. Derrick Goldner DVM', 'nelda82@example.com', '2025-04-28 07:46:26', '$2y$12$0DOsDNrJovD.Kf.KJObCCet9IN8xNDCgUmn9zUJppKWMU/l7q5xr6', 6180.02, 'evYneYJlJp', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(25, 0, 'Gabriel Tillman', 'paris.smith@example.net', '2025-04-28 07:46:26', '$2y$12$ISzVuIEeyGd9nQ6OrecDweqGRBGj7EZZnZYz8hz1lTIHdaOB9lcfq', 333.13, 'PMXMmBw5WN', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(26, 0, 'Arno Thiel', 'hal.baumbach@example.org', '2025-04-28 07:46:26', '$2y$12$xKGBSgGPTEFBCrZ0.op4A.4HgN6vP5DEX5uhKL3P0/8dNUpcAMTma', 888.45, 'QQMAv4YE9G', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(27, 0, 'Jamarcus Schroeder II', 'franz.grady@example.com', '2025-04-28 07:46:27', '$2y$12$sy93NUy6768i/TlJeBANzeyfPQvSn68NhQJSAJsWXTZs.K9tnl/62', 3227.98, 'htQw2API1P', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(28, 0, 'Mafalda Haley', 'jvolkman@example.org', '2025-04-28 07:46:27', '$2y$12$m82kOZ8Rq0GzNx.KdUDSmur/pCtm3yrP7CgmyPeYTy137pRFnq23.', 8312.61, 'btU1vtfzTT', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(29, 0, 'Ms. Mya Haley Sr.', 'wilkinson.noemy@example.com', '2025-04-28 07:46:28', '$2y$12$xhihpzMTH4eCgXs6rKDYje5xroU/hlIYidaivffSMBVSrDxPF0FVK', 6733.79, 'bzCF8WOcln', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(30, 0, 'Furman Schinner', 'ukassulke@example.net', '2025-04-28 07:46:28', '$2y$12$0mm8HinKaJtT8JsFnix/GORPuVNgRQcCWpPaRrzr.56VA6SkOL8Fm', 3500.01, 'xvoLSlgOrF', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(31, 0, 'Hailee Hayes', 'rutherford.laverne@example.org', '2025-04-28 07:46:29', '$2y$12$dAHSQEOhTgpAc2327UCY6O0G6S6mUDgXKtQgWwr0uXLEJgrfJRxKK', 1039.77, 'RoYHhalGaX', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(32, 0, 'Mr. Ethan Schmitt MD', 'hglover@example.org', '2025-04-28 07:46:29', '$2y$12$uYjCIu3ySEpftQnWlRrM6OCg7TCxowcwUVHQLEvOVK7aOgvijtWoK', 2593.91, 'NXMOO7OLBH', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(33, 0, 'Mr. Brooks Kuhn DDS', 'kessler.shyann@example.net', '2025-04-28 07:46:30', '$2y$12$I0kI8yJm6kJv1X4/cTffPu3tn0lYwR6qQBZnMWEVeomzR1oL9rHuO', 4001.28, 'TKij2yW3Qp', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(34, 0, 'Marta Shields PhD', 'beer.jerrell@example.com', '2025-04-28 07:46:30', '$2y$12$VWDo5cgGpbr1SmZEVR/cnuaH.iW8MRhq.WyZRKz9LQVJN8ua6E2bS', 8697.85, '3l6Fx2ZJc6', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(35, 0, 'Destiney Runolfsson', 'kurt77@example.org', '2025-04-28 07:46:30', '$2y$12$qsWvYZmKCVe4t.nqN8IB/eQIZk7/KYYq8YvtEwKVZs//Fwe34Yv6.', 9996.03, 'Izw7c7RiHx', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(36, 0, 'Mittie Weissnat', 'xgislason@example.org', '2025-04-28 07:46:31', '$2y$12$CBa3uK3tPR6OyUPDDOI4wOLyVFcvf3//nxkhpg0XLChp3sT7uOqZm', 8477.93, 'Z1231Ll1SM', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(37, 0, 'Nathen Schowalter I', 'ervin58@example.org', '2025-04-28 07:46:31', '$2y$12$lcfUHweluXwXVVPgTNYtleqMXEDDHRWkLwOBGj/d6xp78DrPkcfOO', 534.99, 'pshgfrcRPl', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(38, 0, 'Dr. Vicente Jacobson Sr.', 'stefan.kutch@example.org', '2025-04-28 07:46:32', '$2y$12$vvccWa.P2rkTEDsS7rTScuzOLAaFeEP/7hH6f9.4FnpAxRBeMKUq.', 3508.97, 'c2SzlsMcJx', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(39, 0, 'Kassandra Littel', 'eino.harris@example.com', '2025-04-28 07:46:32', '$2y$12$v.9gQfd3w0yekPFRS8a5XO1TvSC9t3qwF2/OwTtHOwRV70fFeOcKa', 9480.43, 'Tcq8uVc0No', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(40, 0, 'Mrs. Tanya Stark', 'chloe43@example.com', '2025-04-28 07:46:33', '$2y$12$lSbK.S.EnUWBJrmZLxUrhe5QGnoQ7qJjE9.iDAffIZq5qsDd.XitG', 6960.18, 'ZYRXMevdb6', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(41, 0, 'Alejandrin Heller DVM', 'sschaefer@example.com', '2025-04-28 07:46:33', '$2y$12$ChqILl1el9017XFXZ0t5vOEhwiTsH/t6W9APi4JaCSkrcnpXs0W8m', 890.22, 'kB2Hs0Nixw', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(42, 0, 'Prof. Nicholas Barrows', 'vrunte@example.com', '2025-04-28 07:46:34', '$2y$12$uwLib2eCLIKQ14ZG6RwVZeqWhkcMIGoGDlQqB59yuzSuPHjQvEKbK', 3628.17, 'kDzWwOKKIg', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(43, 0, 'Elenora Mraz', 'jerrod.medhurst@example.org', '2025-04-28 07:46:34', '$2y$12$K678ps1O6rdgs7BB4KX32.bFofu/bW1yP7OuZaKftScjAUrpKIoi6', 3577.95, 'UyxzkcdMvq', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(44, 0, 'Cristina Satterfield', 'ramon51@example.com', '2025-04-28 07:46:34', '$2y$12$3XPym3LTdOzv8CReQ3DVgeFZYOIjMydBSBHK4qPpVftMLq6LOnpbC', 2883.66, 'okPBPXaIAb', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(45, 0, 'Grover Krajcik DDS', 'shyann.walker@example.net', '2025-04-28 07:46:35', '$2y$12$GlVzChJ4gMbRAHaa5iQB7.WZdnF0JcqPg3D5UhX.5sOR1.AdpHN4a', 871.27, 'CZgu9jibBt', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(46, 0, 'Brenna Altenwerth', 'walsh.elyse@example.net', '2025-04-28 07:46:35', '$2y$12$BfvEy.pknT/MKq7Sw4DiYuVVCCykBm98NA9wRIzFAKgJ9oFhOOsWi', 7695.22, 'xmcRmEtm9O', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(47, 0, 'Mekhi Reinger IV', 'selina.lueilwitz@example.com', '2025-04-28 07:46:36', '$2y$12$WkLYZmnaYmBDBLwwS8TnKenzUqUrazlhjv39uN3pK3wU3FdXyBY7.', 1590.16, 'lPVQQnSnWn', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(48, 0, 'Dudley Swift I', 'stiedemann.xavier@example.org', '2025-04-28 07:46:36', '$2y$12$nGkgzJJP/eCV2kG6rrsloOHa/cQTwxK.DNfZVdpejTIKuwXnHoE3u', 8453.69, '9GneBUZkG5', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(49, 0, 'Carlo Huels', 'lbartell@example.com', '2025-04-28 07:46:37', '$2y$12$NPFQN/FbVm5YdSz.zPoBieJ.Ij01T716h1CQlxQJYFgm/uCOPSS6G', 6154.49, '39VghbwT3E', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(50, 0, 'Mr. Micah Kutch', 'medhurst.mylene@example.org', '2025-04-28 07:46:37', '$2y$12$EduNqTwHZNQqNWt6xydpMOhV7paIpeLxm5.OXylKoW4mgCW7l6QXm', 3894.45, 'vISFa2Tn9D', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(51, 0, 'Kristoffer Gibson', 'fahey.celine@example.com', '2025-04-28 07:46:38', '$2y$12$HMGrH3Ay2q6sETPVLv/rTOMAj9AeuaPON0/RpY6Xa4rjvqdiPKgXm', 2416.05, 'cw3VsdmM4n', '2025-04-28 07:46:38', '2025-04-28 07:46:38', NULL, NULL, NULL, NULL),
(52, 0, 'John Doe', 'josh.doe@example.com', NULL, '$2y$12$QyPvhncPm4dOqrPn1l8HTOejWWM98amJxAa4v/q5MGTdbm8Ttrwh.', 4991.00, NULL, '2025-04-28 14:18:44', '2025-04-28 14:55:54', NULL, NULL, NULL, NULL);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advertisements_user_id_foreign` (`user_id`),
  ADD KEY `advertisements_updated_by_foreign` (`updated_by`),
  ADD KEY `advertisements_deleted_by_foreign` (`deleted_by`);

--
-- A tábla indexei `balance_uploads`
--
ALTER TABLE `balance_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balance_uploads_user_id_foreign` (`user_id`),
  ADD KEY `balance_uploads_advertisement_id_foreign` (`advertisement_id`);

--
-- A tábla indexei `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_deleted_by_foreign` (`deleted_by`);

--
-- A tábla indexei `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friendships_sender_id_receiver_id_unique` (`sender_id`,`receiver_id`),
  ADD KEY `friendships_receiver_id_foreign` (`receiver_id`);

--
-- A tábla indexei `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friend_requests_sender_id_foreign` (`sender_id`),
  ADD KEY `friend_requests_receiver_id_foreign` (`receiver_id`);

--
-- A tábla indexei `game_logs`
--
ALTER TABLE `game_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_logs_user_id_foreign` (`user_id`);

--
-- A tábla indexei `game_stats`
--
ALTER TABLE `game_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_stats_user_id_foreign` (`user_id`);

--
-- A tábla indexei `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- A tábla indexei `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_deleted_by_foreign` (`deleted_by`);

--
-- A tábla indexei `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_suspended_by_foreign` (`suspended_by`),
  ADD KEY `users_restored_by_foreign` (`restored_by`),
  ADD KEY `users_destroyed_by_foreign` (`destroyed_by`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `balance_uploads`
--
ALTER TABLE `balance_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `game_logs`
--
ALTER TABLE `game_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `game_stats`
--
ALTER TABLE `game_stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT a táblához `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `advertisements_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `advertisements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `balance_uploads`
--
ALTER TABLE `balance_uploads`
  ADD CONSTRAINT `balance_uploads_advertisement_id_foreign` FOREIGN KEY (`advertisement_id`) REFERENCES `advertisements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `balance_uploads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friendships_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friendships_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `game_logs`
--
ALTER TABLE `game_logs`
  ADD CONSTRAINT `game_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `game_stats`
--
ALTER TABLE `game_stats`
  ADD CONSTRAINT `game_stats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_destroyed_by_foreign` FOREIGN KEY (`destroyed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_restored_by_foreign` FOREIGN KEY (`restored_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_suspended_by_foreign` FOREIGN KEY (`suspended_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
