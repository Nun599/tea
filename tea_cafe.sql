-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 10:22 AM
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
-- Database: `tea_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('toppings','sweetness','sinkers','extra') DEFAULT 'toppings',
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`id`, `name`, `price`, `category`, `is_available`, `created_at`) VALUES
(1, 'Pearl', 10.00, 'toppings', 1, '2025-10-08 05:12:09'),
(2, 'Nata', 10.00, 'toppings', 1, '2025-10-08 05:12:09'),
(3, 'Cream Cheese', 10.00, 'toppings', 1, '2025-10-08 05:12:09'),
(4, 'Coffee Jelly', 10.00, 'toppings', 1, '2025-10-08 05:12:09'),
(5, '25% Sweet', 0.00, 'sweetness', 1, '2025-10-08 05:12:09'),
(6, '50% Sweet', 0.00, 'sweetness', 1, '2025-10-08 05:12:09'),
(7, '75% Sweet', 0.00, 'sweetness', 1, '2025-10-08 05:12:09'),
(8, '100% Sweet', 0.00, 'sweetness', 1, '2025-10-08 05:12:09'),
(9, 'No Sugar', 0.00, 'sweetness', 1, '2025-10-08 05:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','preparing','ready','completed','cancelled') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `customer_name`, `customer_phone`, `customer_address`, `payment_method`, `subtotal`, `tax`, `total_amount`, `status`, `order_date`) VALUES
(13, NULL, 'jay nunez', '987654321', 'dwad', 'cash', 43.00, 0.00, 43.00, 'pending', '2025-10-10 07:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `size`, `quantity`, `price`) VALUES
(14, 13, 'Matcha', 'regular', 1, 43.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_item_addons`
--

CREATE TABLE `order_item_addons` (
  `id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  `addon_name` varchar(255) NOT NULL,
  `addon_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price_regular` decimal(10,2) DEFAULT NULL,
  `price_large` decimal(10,2) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price_regular`, `price_large`, `image_path`, `description`, `is_available`, `created_at`, `image_url`) VALUES
(1, 'Okinawa', 'milktea', 28.00, 38.00, 'img_milktea/okinawa.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(2, 'Winter Melon', 'milktea', 28.00, 38.00, 'img_milktea/wintermelon.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(3, 'Redvelvet', 'milktea', 28.00, 38.00, 'img_milktea/redvelvet.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(4, 'Matcha Cheesecake', 'cheesecake', 43.00, 53.00, 'img_cheesecake/matcha.jpeg', NULL, 1, '2025-10-06 06:32:54', NULL),
(5, 'Java Chip', 'frappe', 55.00, 65.00, 'img_frappe/javachip.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(6, 'Almond Matcha', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/almondmatcha.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(7, 'Americano', 'icecoffee', 50.00, 60.00, 'img_icecoffee/americano.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(8, 'Caramel Machiatto', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(9, 'Blueberries & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/blueberries&milk.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(10, 'Blueberry', 'fruittea', 28.00, 38.00, 'img_fruittea/blueberry.jpg', NULL, 1, '2025-10-06 06:32:54', NULL),
(11, 'Blue Apple', 'soda', 28.00, 38.00, 'img_sodarefresher/blueapple.png', NULL, 1, '2025-10-06 06:32:54', NULL),
(12, 'Okinawa', 'milktea', 28.00, 38.00, 'img_milktea/okinawa.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(13, 'Winter Melon', 'milktea', 28.00, 38.00, 'img_milktea/wintermelon.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(14, 'Red Velvet', 'milktea', 28.00, 38.00, 'img_milktea/redvelvet.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(15, 'Taro', 'milktea', 28.00, 38.00, 'img_milktea/taro.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(16, 'Salted Caramel', 'milktea', 28.00, 38.00, 'img_milktea/saltedcaramel.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(17, 'Matcha', 'milktea', 28.00, 38.00, 'img_milktea/matcha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(18, 'Choco Strawberry', 'milktea', 28.00, 38.00, 'img_milktea/chocostrawberry.png', NULL, 0, '2025-10-10 07:45:54', NULL),
(19, 'Cookies & Cream', 'milktea', 28.00, 38.00, 'img_milktea/cookies&cream.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(20, 'Okinawa', 'cheesecake', 43.00, 53.00, 'img_cheesecake/okinawa.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(21, 'Matcha', 'cheesecake', 43.00, 53.00, 'img_cheesecake/matcha.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(22, 'Dark Choco', 'cheesecake', 43.00, 53.00, 'img_cheesecake/dark_choco.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(23, 'Red Velvet', 'cheesecake', 43.00, 53.00, 'img_cheesecake/red_velvet.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(24, 'Cookies & Cream', 'cheesecake', 43.00, 53.00, 'img_cheesecake/cookies_and_cream.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(25, 'Salted Caramel', 'cheesecake', 43.00, 53.00, 'img_cheesecake/salted_caramel.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(26, 'Wintermelon', 'cheesecake', 43.00, 53.00, 'img_cheesecake/wintemelon.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(27, 'Double Oreo', 'cheesecake', 43.00, 53.00, 'img_cheesecake/double_oreo.jpeg', NULL, 1, '2025-10-10 07:45:54', NULL),
(28, 'Java Chip', 'frappe', 55.00, 65.00, 'img_frappe/javachip.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(29, 'Dark Mocha', 'frappe', 55.00, 65.00, 'img_frappe/darkmocha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(30, 'Mix Berries', 'frappe', 55.00, 65.00, 'img_frappe/mixberries.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(31, 'Triple Chocolate', 'frappe', 55.00, 65.00, 'img_frappe/triplechocolate.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(32, 'Matcha', 'frappe', 55.00, 65.00, 'img_frappe/matcha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(33, 'Dark Chocoberry', 'frappe', 55.00, 65.00, 'img_frappe/darkchocoberry.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(34, 'Strawberry & Cream', 'frappe', 55.00, 65.00, 'img_frappe/strawberry&cream.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(35, 'Dark Caramel', 'frappe', 55.00, 65.00, 'img_frappe/darkcaramel.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(36, 'Blue Berries & Cream', 'frappe', 55.00, 65.00, 'img_frappe/blueberries&cream.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(37, 'Almond Matcha', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/almondmatcha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(38, 'Dark Choco Creamcheese', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/darkchococreamcheese.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(39, 'Dark Choco Lava', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/darkchocolava.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(40, 'Dark Forest', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/darkforest.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(41, 'Kopi Caramel', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/kopicaramel.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(42, 'Lava Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/lavacheesecake.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(43, 'Mango Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/mangocheesecake.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(44, 'Oreo Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/oreocheesecake.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(45, 'Red Velvet Creamcheese', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/redvelveltcreamcheese.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(46, 'Strawberry Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/strawberrycheesecake.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(47, 'Ube Creamcheese', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/ubecreamcheese.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(48, 'White Choco Mocha', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/whitechocomocha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(49, 'Americano', 'icecoffee', 50.00, 60.00, 'img_icecoffee/americano.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(50, 'Caramel Machiatto', 'icecoffee', 50.00, 60.00, 'img_icecoffee/caramelmachiatto.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(51, 'Dirty Matcha', 'icecoffee', 50.00, 60.00, 'img_icecoffee/dirtymatcha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(52, 'French Vanilla', 'icecoffee', 50.00, 60.00, 'img_icecoffee/frenchvanilla.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(53, 'Mocha Latte', 'icecoffee', 50.00, 60.00, 'img_icecoffee/mochalatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(54, 'Salted Caramel Latte', 'icecoffee', 50.00, 60.00, 'img_icecoffee/saltedcaramellatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(55, 'Spanish Latte', 'icecoffee', 50.00, 60.00, 'img_icecoffee/spanishlatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(56, 'White Chocolate', 'icecoffee', 50.00, 60.00, 'img_icecoffee/whitechocolate.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(57, 'White Mocha', 'icecoffee', 50.00, 60.00, 'img_icecoffee/whitemocha.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(58, 'Caramel Machiatto', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(59, 'Salted Caramel Latte', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(60, 'Spanish Latte', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(61, 'White Chocolate', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(62, 'Mocha Latte', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(63, 'French Vanilla', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(64, 'White Mocha', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(65, 'Hot Chocolate', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(66, 'Hot Americano', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(67, 'Blue Berries & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/blueberries&milk.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(68, 'Chocolate Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/chocolatelatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(69, 'Mango & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/mango&milk.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(70, 'Matcha Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/matchalatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(71, 'Strawberry & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/strawberry&milk.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(72, 'Ube Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/ubelatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(73, 'Ube Matcha Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/ubematchalatte.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(74, 'Blue Berry', 'fruittea', 28.00, 38.00, 'img_fruittea/blueberry.jpg', NULL, 1, '2025-10-10 07:45:54', NULL),
(75, 'Green Apple Tea', 'fruittea', 28.00, 38.00, 'img_fruittea/greenapple.jpg', NULL, 1, '2025-10-10 07:45:54', NULL),
(76, 'Lemon', 'fruittea', 28.00, 38.00, 'img_fruittea/lemon.jpg', NULL, 1, '2025-10-10 07:45:54', NULL),
(77, 'Strawberry', 'fruittea', 28.00, 38.00, 'img_fruittea/strawberry.jpg', NULL, 1, '2025-10-10 07:45:54', NULL),
(78, 'Blue Apple', 'soda', 28.00, 38.00, 'img_sodarefresher/blueapple.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(79, 'Blue Lemonade', 'soda', 28.00, 38.00, 'img_sodarefresher/bluelemonade.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(80, 'Mint Strawberry', 'soda', 28.00, 38.00, 'img_sodarefresher/mintstrrawberry.png', NULL, 1, '2025-10-10 07:45:54', NULL),
(81, 'Pink Mango', 'soda', 28.00, 38.00, 'img_sodarefresher/pinkmango.png', NULL, 1, '2025-10-10 07:45:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_availability_log`
--

CREATE TABLE `product_availability_log` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `old_status` tinyint(1) NOT NULL,
  `new_status` tinyint(1) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'Admin', 'User', 'admin@teacafe.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-10-06 06:32:54'),
(2, 'mark rhanie', 'alcover', 'alcovermark.28@gmail.com', '$2y$10$88Pu46geAkyoqg2eV3qsXudpozd7rjit/YvxdCEUHtLUvjJJ5If0m', 'customer', '2025-10-08 08:40:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_item_addons`
--
ALTER TABLE `order_item_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `addon_id` (`addon_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_availability_log`
--
ALTER TABLE `product_availability_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_item_addons`
--
ALTER TABLE `order_item_addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `product_availability_log`
--
ALTER TABLE `product_availability_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item_addons`
--
ALTER TABLE `order_item_addons`
  ADD CONSTRAINT `order_item_addons_ibfk_1` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_addons_ibfk_2` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`);

--
-- Constraints for table `product_availability_log`
--
ALTER TABLE `product_availability_log`
  ADD CONSTRAINT `product_availability_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_availability_log_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`);

--
-- Additional views and procedures for availability management
--

--
-- View for available products only
--

CREATE VIEW available_products AS
SELECT * FROM products WHERE is_available = 1;

--
-- Stored procedure to toggle product availability
--

DELIMITER $$
CREATE PROCEDURE ToggleProductAvailability(
    IN p_product_id INT,
    IN p_user_id INT
)
BEGIN
    DECLARE current_status TINYINT;
    
    -- Get current status
    SELECT is_available INTO current_status 
    FROM products WHERE id = p_product_id;
    
    -- Toggle status
    UPDATE products 
    SET is_available = NOT current_status 
    WHERE id = p_product_id;
    
    -- Log the change
    INSERT INTO product_availability_log 
    (product_id, old_status, new_status, changed_by) 
    VALUES (p_product_id, current_status, NOT current_status, p_user_id);
    
END$$
DELIMITER ;

--
-- Stored procedure to get unavailable products
--

DELIMITER $$
CREATE PROCEDURE GetUnavailableProducts()
BEGIN
    SELECT * FROM products WHERE is_available = 0 ORDER BY category, name;
END$$
DELIMITER ;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;