-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2025 at 01:52 AM
-- Server version: 8.0.32
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personal-blog-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `icon`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'heroicon-o-heart', 'Life', 'life', 'Kategori yang berisi artikel dan konten terkait kehidupan, gaya hidup, dan inspirasi sehari-hari.', '2025-01-28 06:31:31', '2025-01-28 06:53:06'),
(2, 'heroicon-o-star', 'Review', 'review', 'Kategori untuk artikel atau video yang mengulas berbagai produk atau layanan.', '2025-01-28 07:18:41', '2025-01-28 07:18:41'),
(3, 'heroicon-o-cpu-chip', 'Tech ', 'tech', 'Teknologi adalah benda atau entitas yang diciptakan untuk mencapai suatu nilai.', '2025-02-05 20:54:10', '2025-02-05 20:54:10'),
(4, 'heroicon-o-wrench-screwdriver', 'Civil', 'civil', 'sipil, cabang ilmu teknik yang mempelajari perencanaan, perancangan, pembangunan, dan pemeliharaan infrastruktur.', '2025-02-13 03:53:31', '2025-02-13 03:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `post_user_id` bigint UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 'wiuwiuwiu', '2025-02-03 19:24:46', '2025-02-03 19:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_01_10_005444_create_sessions_table', 1),
(7, '2025_01_20_021005_create_roles_table', 2),
(8, '2025_01_20_021551_create_role_users_table', 2),
(9, '2025_01_21_123818_create_posts_table', 3),
(10, '2025_01_28_033741_create_thumbnails_table', 4),
(11, '2025_01_28_034359_create_post_thumbnails_table', 4),
(12, '2025_01_28_111656_create_categories_table', 5),
(13, '2025_01_28_112028_create_post_categories_table', 5),
(14, '2025_01_30_104729_create_post_users_table', 6),
(15, '2025_02_04_015925_create_comments_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `youtube_url`, `created_at`, `updated_at`) VALUES
(1, 'impact ijo', 'impact ijo dari zper dengan harga 400 ribuan, seperti apa keandalannya', 'https://www.instagram.com/reel/DFEteWIT1HI/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', '2025-01-21 05:45:14', '2025-01-21 05:45:14'),
(2, 'Pembahasan Modul Praktikum Part2 Bagian 2 : Login', 'praktikum part 2 login', 'https://youtu.be/SlODW877HCQ?si=YafoyeovWeiVUDBO', '2025-01-21 06:09:20', '2025-01-21 06:09:20'),
(3, 'crystal melting', 'crystal melting and annealing process', 'https://www.instagram.com/reel/DFpR9NhyPGi/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', '2025-02-05 06:57:45', '2025-02-05 06:57:45'),
(4, 'semua orang punya komputer', 'tapi apakah dari semua orang punya komputer, mereka dapat kehidupan yang layak, atau malah sebaliknya.', 'https://www.instagram.com/reel/DFxxAxgyIVk/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', '2025-02-07 21:11:19', '2025-02-07 21:11:19'),
(5, 'mini calculator project ', 'calculator project using arduino, or esp32', 'https://www.instagram.com/reel/DFzCas6qjvv/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', '2025-02-07 21:20:25', '2025-02-07 21:20:25'),
(6, 'bambu lab', 'achieve next level organization with 3D printing on the bambu lab p15', 'https://www.instagram.com/reel/DF2TiOAK6Ls/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', '2025-02-13 07:54:37', '2025-02-13 07:54:37'),
(7, 'internet speed test', 'diy internet speed test using nodemcu', 'https://www.instagram.com/reel/DF2UUiSKZJO/', '2025-02-13 07:55:18', '2025-02-13 07:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`id`, `post_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-01-28 07:19:22', '2025-01-28 07:19:22'),
(2, 2, 1, '2025-02-05 20:54:45', '2025-02-05 20:54:45'),
(3, 3, 1, '2025-02-05 20:55:15', '2025-02-05 20:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `post_thumbnails`
--

CREATE TABLE `post_thumbnails` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `thumbnail_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_thumbnails`
--

INSERT INTO `post_thumbnails` (`id`, `post_id`, `thumbnail_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-01-27 21:45:54', '2025-01-27 21:45:54'),
(2, 2, 2, '2025-01-27 21:52:55', '2025-01-27 21:52:55'),
(3, 3, 4, '2025-02-05 20:33:48', '2025-02-05 20:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `post_users`
--

CREATE TABLE `post_users` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `role_user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_users`
--

INSERT INTO `post_users` (`id`, `post_id`, `role_user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, '2025-02-05 20:55:51', '2025-02-05 20:55:51'),
(3, 3, 1, '2025-02-05 20:56:20', '2025-02-05 21:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', '2025-01-19 19:45:11', '2025-01-21 04:43:38'),
(2, 'user', '2025-01-19 20:10:36', '2025-01-19 20:10:36'),
(3, 'editor', '2025-01-20 20:07:59', '2025-01-20 20:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 4, 2, '2025-01-21 05:27:36', '2025-01-21 05:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RyAC24KPqwY5P6olhyFamLQGza95VZovXYHLaMYS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiM2M1ZlBsNG1aVjRLSlpRUFNWdWYxRDNrRThKNWF5bnA0ZE01NEpPMCI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vdXNlcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkakluWnNUeUZiWnAzWGJjTXllaFlHZVUuVGtMSnJRVWFmWTZoODMvNHluY0NaanZRai9mb0MiO30=', 1740448022);

-- --------------------------------------------------------

--
-- Table structure for table `thumbnails`
--

CREATE TABLE `thumbnails` (
  `id` bigint UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thumbnails`
--

INSERT INTO `thumbnails` (`id`, `url`, `created_at`, `updated_at`) VALUES
(1, 'https://i.pinimg.com/736x/97/00/60/9700602e0a37db9dcbe3cef6948040e5.jpg', '2025-01-27 20:54:25', '2025-01-27 20:54:25'),
(2, 'https://i.pinimg.com/736x/78/29/d2/7829d243248d721ccb8099d6073f3641.jpg', '2025-01-27 20:55:56', '2025-01-27 20:55:56'),
(3, 'https://i.pinimg.com/736x/3b/a8/04/3ba8040d055d897b1581949eedf29b73.jpg', '2025-01-27 21:59:59', '2025-01-27 21:59:59'),
(4, 'https://i.pinimg.com/736x/d8/fd/57/d8fd57f763262d0cf0de8be1cc6d00c9.jpg', '2025-01-31 21:04:54', '2025-01-31 21:04:54'),
(5, 'https://i.pinimg.com/736x/1e/c9/5b/1ec95b3f6f8f8ddc1e0fd8334f6e8ffb.jpg', '2025-02-05 20:33:14', '2025-02-05 20:33:14'),
(6, 'https://i.pinimg.com/736x/47/e4/b7/47e4b7552c78555b0c3d24c8d585dca0.jpg', '2025-02-13 03:42:04', '2025-02-13 03:42:04'),
(7, 'https://i.pinimg.com/736x/c9/92/78/c99278fce61a7366cca1385742901c04.jpg', '2025-02-13 03:43:02', '2025-02-13 03:43:02'),
(8, 'https://i.pinimg.com/736x/b1/a1/e3/b1a1e37a634a0ebadbe166e9819ffb02.jpg', '2025-02-13 03:43:47', '2025-02-13 03:43:47'),
(9, 'https://i.pinimg.com/736x/bf/b8/fe/bfb8fe7fce502957637c92de32ebaf6a.jpg', '2025-02-13 03:44:34', '2025-02-13 03:44:34'),
(10, 'https://i.pinimg.com/736x/3a/7f/d6/3a7fd63e5ea56e2993765662e5cfd820.jpg', '2025-02-13 03:45:22', '2025-02-13 03:45:22'),
(11, 'https://i.pinimg.com/736x/0c/38/b4/0c38b4f82672e7e6eb406694bce32aec.jpg', '2025-02-13 03:56:04', '2025-02-13 03:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'test1@mail.com', NULL, '$2y$10$jInZsTyFbZp3XbcMyehYGeU.TkLJrQUafY6h83/4yncCZjvQj/foC', NULL, NULL, NULL, NULL, NULL, 'profile-photos/UYZQQzqQbAR5CYlId1YLNeLWmdlGrEtbHZ3YIWd5.jpg', '2025-01-09 18:00:39', '2025-01-14 04:57:06'),
(2, 'homhem', 'adhohem@mail.com', NULL, '$2y$10$lyAVwxyTGXGgxGqBRJ9omO/vm6.rcPff/pv5U7BHLPNEBT2GVM5s.', NULL, NULL, NULL, NULL, NULL, 'profile-photos/I6Z64RINAoOh1F64oAkI1Epx4CRcrbfToLBH7eM7.png', '2025-01-14 04:50:38', '2025-01-24 06:30:21'),
(4, 'berkley', 'berkley@mail.com', NULL, '$2y$10$5YAFK4HJjLhlVZZ.KSJLHuvqCSlZi36WcxQVKGYNVp.l6wYLzHalS', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-19 19:30:59', '2025-01-19 19:30:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_user_id_foreign` (`post_user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_categories_post_id_foreign` (`post_id`),
  ADD KEY `post_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `post_thumbnails`
--
ALTER TABLE `post_thumbnails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_thumbnails_post_id_foreign` (`post_id`),
  ADD KEY `post_thumbnails_thumbnail_id_foreign` (`thumbnail_id`);

--
-- Indexes for table `post_users`
--
ALTER TABLE `post_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_users_post_id_foreign` (`post_id`),
  ADD KEY `post_users_role_user_id_foreign` (`role_user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_users_user_id_foreign` (`user_id`),
  ADD KEY `role_users_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_thumbnails`
--
ALTER TABLE `post_thumbnails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_users`
--
ALTER TABLE `post_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_user_id_foreign` FOREIGN KEY (`post_user_id`) REFERENCES `post_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_thumbnails`
--
ALTER TABLE `post_thumbnails`
  ADD CONSTRAINT `post_thumbnails_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_thumbnails_thumbnail_id_foreign` FOREIGN KEY (`thumbnail_id`) REFERENCES `thumbnails` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_users`
--
ALTER TABLE `post_users`
  ADD CONSTRAINT `post_users_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_users_role_user_id_foreign` FOREIGN KEY (`role_user_id`) REFERENCES `role_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
