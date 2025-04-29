-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 08:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `me_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(2, 'Gaming', 'Funny moments and expertise in gaming are here.'),
(3, 'Technology', 'Fancy tech news and information.'),
(4, 'Travel', 'Out-of-town experiences and beautiful stories in foreign land.'),
(5, 'Art', 'Beautiful and stunning illustrations.');

-- --------------------------------------------------------

--
-- Table structure for table `featured_post`
--

CREATE TABLE `featured_post` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `featured_post`
--

INSERT INTO `featured_post` (`id`, `post_id`) VALUES
(1, 26);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `author_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `thumbnail`, `time_created`, `category_id`, `author_id`) VALUES
(10, 'Test the meter.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eleifend libero quis metus finibus, non blandit elit tincidunt. Vivamus arcu urna, vulputate vel venenatis sed, sagittis a purus. Sed porta commodo dui, nec vestibulum mi consequat at. Donec laoreet purus vitae sapien vehicula sollicitudin. Proin imperdiet purus nisi, in volutpat tellus consectetur ac. Praesent ut velit vel dolor fringilla rhoncus et ac nisl. Nunc tellus massa, porttitor id ipsum id, lacinia dignissim lorem. Sed vitae lectus in quam malesuada dictum. Ut lacinia sed sapien ut pulvinar.', 'http://localhost/projects/blog-app/images/posts/5/1745390793_1000_F_601211158_bu0EaLaEqZwLyweHdtsxJf8GfDkMO7hI.jpg', '2025-04-23 06:46:33', 3, 5),
(14, 'Alone in a road', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lorem blandit, elementum orci vitae, placerat ante. Cras pulvinar fermentum luctus. Maecenas faucibus eros enim, ut gravida nisl posuere vel. Ut ultrices sit amet nisl pretium maximus. Sed dictum, magna quis pellentesque facilisis, turpis tortor tempor massa, at auctor augue magna id ex.', 'http://localhost/projects/blog-app/images/posts/5/1745752263_peter-thomas-FbYZAV_0VuU-unsplash.jpg', '2025-04-25 01:46:52', 4, 5),
(16, 'Espresso!!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ultrices tellus et justo tempus eleifend. Nunc nec laoreet mi. Morbi vitae turpis dolor. Cras blandit laoreet lectus, eu blandit orci hendrerit sed. Nam dignissim mi laoreet sem placerat, eu semper elit hendrerit. Sed bibendum, massa rhoncus posuere sodales, libero augue pulvinar dui, at sagittis tellus ante a diam. Vestibulum ut magna ac urna facilisis sollicitudin. Donec nec feugiat odio, at auctor velit. ', 'http://localhost/projects/blog-app/images/posts/5/1745752282_ethan-rougon-ormCASpY44Q-unsplash.jpg', '2025-04-25 02:18:40', 4, 5),
(18, 'Red Moon', 'Aenean ultrices a nibh blandit luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam condimentum viverra ligula, id viverra sem. Vestibulum consectetur lacus eget lacus viverra tempor. Phasellus placerat magna sed sapien suscipit, et vulputate orci iaculis. Morbi imperdiet, nunc sed posuere cursus, felis nulla imperdiet mi, quis fermentum odio nisi eleifend magna. Vivamus suscipit, purus ut malesuada sodales, urna tortor efficitur nibh, sed fringilla felis justo dignissim turpis. Sed bibendum sodales est quis maximus. ', 'http://localhost/projects/blog-app/images/posts/5/1745548420_allec-gomes-X2JQrjrlenM-unsplash.jpg', '2025-04-25 02:33:40', 4, 5),
(19, 'Old(ish) Tech....', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce iaculis arcu in urna dictum, ac tempor nisi rutrum. Ut leo tortor, cursus eget arcu sed, blandit suscipit ipsum. Sed non mauris sit amet lorem ullamcorper mollis sit amet et ex. Phasellus lorem diam, porta quis faucibus vel, sodales at est. Cras quam odio, congue ac dolor eu, aliquet suscipit tellus. Pellentesque at purus euismod, pharetra nunc sed, sollicitudin lectus. ', 'http://localhost/projects/blog-app/images/posts/5/1745550283_bernd-dittrich-n0iZRPiYWuA-unsplash.jpg', '2025-04-25 03:04:43', 3, 5),
(24, 'Old Tech, Good Collection', 'Donec tristique nisi a nisi luctus vulputate. Donec vehicula ligula quis consequat eleifend. Nulla vel velit ut libero bibendum blandit. Donec vitae vestibulum turpis. Mauris vehicula pharetra nibh. Ut eu vehicula mi, in mattis libero. Curabitur volutpat sem quis venenatis efficitur. Donec tincidunt nunc quis nibh varius, ac sollicitudin lacus feugiat. Suspendisse sed nibh sed ligula sodales faucibus sit amet a arcu. Curabitur in rhoncus eros. Phasellus sit amet tristique mi. Suspendisse dapibus tristique odio quis efficitur. Nullam quis nisi orci. Vivamus pretium sem ut elementum viverra. ', 'http://localhost/projects/blog-app/images/posts/5/1745813899_theodore-poncet-QZePhoGqD7w-unsplash.jpg', '2025-04-28 04:18:19', 3, 5),
(25, 'Alone Elephant in the field', 'Aenean pretium tempor iaculis. Nunc quis luctus augue. Sed dictum fermentum posuere. Donec diam risus, mollis eu hendrerit ut, auctor eget risus. Maecenas efficitur leo nibh, vitae convallis ligula vehicula et. Mauris ultrices nec turpis vel rhoncus. Praesent et velit fermentum, consequat risus a, eleifend est. Nullam mi magna, lacinia ut tincidunt et, mollis sed nibh. Donec sit amet consectetur purus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam ac turpis eros. Vivamus in dolor sit amet odio rutrum dignissim. ', 'http://localhost/projects/blog-app/images/posts/5/1745813975_peter-thomas-hcBVdd2leJs-unsplash.jpg', '2025-04-28 04:19:35', 4, 5),
(26, '&#039;Crater&#039; Art', 'Duis ut posuere turpis. Proin malesuada nulla vitae arcu vulputate aliquet. Donec eros risus, auctor sit amet odio at, consequat pretium elit. Proin egestas eros aliquam dapibus rhoncus. In blandit sed dolor id laoreet. In hac habitasse platea dictumst. Quisque velit dui, placerat a lobortis eget, ullamcorper a mauris. Sed hendrerit urna id urna accumsan, quis condimentum nunc interdum. Nunc volutpat, nunc fermentum sodales tincidunt, ex est accumsan tellus, convallis lacinia lacus enim et erat. ', 'http://localhost/projects/blog-app/images/posts/5/1745814214_usgs-zqX9icQfc2I-unsplash.jpg', '2025-04-28 04:23:34', 5, 5),
(32, 'Sunflower Art', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra vel est ac facilisis. Curabitur molestie erat sed mauris tincidunt, id convallis lorem maximus. Aliquam nec nunc consequat, scelerisque enim ut, aliquam ex. Nunc sagittis odio in orci porttitor egestas. Donec et lectus non nisi dapibus feugiat eu et erat. Curabitur auctor imperdiet fringilla. Phasellus vestibulum urna sed erat convallis, sed lobortis ipsum cursus. Donec felis felis, varius vel ante ac, condimentum cursus odio. Curabitur lacinia et massa non posuere. Aliquam metus urna, molestie nec lacus a, volutpat elementum sem. Maecenas sed ligula quis massa maximus dapibus in sed eros. Cras congue hendrerit leo ut pellentesque. Nam non dui et turpis euismod convallis id quis metus. Praesent dignissim vitae orci at condimentum. ', 'http://localhost/projects/blog-app/images/posts/10/1745822097_evie-s-9wpLwUm4KOo-unsplash.jpg', '2025-04-28 06:34:57', 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'author'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `role`) VALUES
(5, 'John', 'Doe', 'john_doe', 'john_doe@yahoo.com', '$2y$10$pLrt017McKgzK5eOSEF/M.UAtj6QdPJPDQqrYbKLL7B./gVmdIvgi', 'http://localhost/projects/blog-app/images/avatar/1744641926_52685143.jpg', 'admin'),
(10, 'Jane', 'Doe', 'jane_doe', 'jane_doe@yahoo.com', '$2y$10$/uMzmm8zHMdYbulGqeZnXuMZULZxWBim7J1TnuohlPClXXJIli6gG', 'http://localhost/projects/blog-app/images/avatar/1745822057_Zombatar_1.jpg', 'author');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_indx` (`title`(100));

--
-- Indexes for table `featured_post`
--
ALTER TABLE `featured_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_categories` (`category_id`),
  ADD KEY `FK_author` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `featured_post`
--
ALTER TABLE `featured_post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `featured_post`
--
ALTER TABLE `featured_post`
  ADD CONSTRAINT `FK_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
