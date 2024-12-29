-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 06:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webbanghang`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'Trang Điểm Mắt'),
(3, 'Trang Điểm Mặt'),
(4, 'Son Môi'),
(8, 'Skincare');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `subject_name` varchar(350) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `thumbnail` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 0,
  `total_money` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `email`, `phone_number`, `address`, `note`, `order_date`, `status`, `total_money`) VALUES
(1, 1, 'Nguyễn Thị Tú', 'tunguyen@gmail.com', '41252745', 'Thành Phố Hồ Chí Minh', '', '2024-12-04 01:19:35', 1, 550000);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `total_money` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `num`, `total_money`) VALUES
(1, 1, 3, 550000, 1, 550000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT 0,
  `thumbnail` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `title`, `price`, `discount`, `thumbnail`, `description`, `created_at`, `updated_at`, `deleted`) VALUES
(3, 2, 'Bảng Phấn Mắt 9 Ô Màu Dasique Ice Cream Shadow Palette', 710000, 550000, 'Asset/Image/dasique__1__5c4850d42722497fb232f51746b188ce_a3560d18a5fb432f9558ef224280f4b8_master.png', '<p><span style=\"margin: 0px; padding: 0px; font-weight: 700; color: rgb(78, 74, 75); font-family: \"Nunito Sans\", sans-serif; font-size: 14px; letter-spacing: -0.2px; text-align: justify;\">Dasique Ice Cream Shadow Palette</span><span style=\"color: rgb(78, 74, 75); font-family: \"Nunito Sans\", sans-serif; font-size: 14px; letter-spacing: -0.2px; text-align: justify;\"> phấn mắt 9 ô với thiết kế bắt mắt cùng bảng màu dịu nhẹ đa dạng từ đậm đến nhạt kết hợp những gam màu ấm, trung tính và sắc nhũ, là lựa chọn dành riêng cho những cô nàng yêu thích nét tự nhiên hoặc dịu dàng. Đồng hành tạo điểm nhấn cho nàng thỏa sức là chính mình ở nhiều phiên bản, từ công sở đến những bữa tiệc sôi nổi.</span></p>', '2024-11-28 18:26:58', '2024-12-10 20:55:50', 0),
(4, 4, 'Son Kem Lỳ Bbia Last Velvet Lip Tint', 150000, 139000, 'Asset/Image/3992_a3004c29141943f2b4e834f14210de3b_d6e59588ece945f0b5ef3a23284c883e_03bfcea25f5043b1abdd4fea3000ddbf_master.png', '<p><span style=\"margin: 0px; padding: 0px; font-weight: 700; color: rgb(78, 74, 75); font-family: &quot;Nunito Sans&quot;, sans-serif; font-size: 14px; letter-spacing: -0.2px; text-align: justify;\">Son Kem Lỳ Bbia Last Velvet Lip Tint</span><span style=\"color: rgb(78, 74, 75); font-family: &quot;Nunito Sans&quot;, sans-serif; font-size: 14px; letter-spacing: -0.2px; text-align: justify;\">&nbsp;có kết cấu son mịn như nhung, lướt trên môi cực nhẹ và mướt, không làm khô môi hay lộ vân môi, lớp finish lì tuyệt đối nhưng sau khi ăn sẽ để lại lớp màu hồng đỏ tiệp lại trên môi cực xinh.</span></p>', '2024-11-28 19:08:06', '2024-11-28 19:08:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `user_id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`user_id`, `token`, `created_at`) VALUES
(1, '1bb0d7e3ba500fa2a5810b6a1fb6df9a', '2024-11-28 15:58:30'),
(1, '21f8200260ad4c0a433d7cb298e9d8f3', '2024-11-26 18:22:11'),
(1, '58057edd5521fb81b40a645e7c24151b', '2024-11-28 15:58:43'),
(1, '7ea949920ef85a6a8cbf1ac31805569a', '2024-12-04 03:16:59'),
(1, 'a11cb345ac38015d4f70a6185ecf7890', '2024-11-26 18:56:19'),
(1, 'aae9eb3b7fbe399f26be6785cd3f2c6d', '2024-11-28 16:01:03'),
(1, 'bda473889a366b474d1362d5896ecf0a', '2024-11-26 19:15:42'),
(1, 'c48a3aa171d065a5d901766b8304220e', '2024-11-28 17:08:35'),
(1, 'd1fc12b699bbe05385fc591058e88320', '2024-11-26 18:54:11'),
(1, 'dd83c2f6c43811f968544dc87018e9c0', '2024-12-10 20:41:18'),
(1, 'f26f460edcb96b5d2fdb53e1f47381e0', '2024-11-26 18:55:46'),
(1, 'f4ef3bb6bfb16e15c5b83514095abd15', '2024-12-14 02:15:06'),
(1, 'fc2aedfde2de1c9557947c3054d8187a', '2024-11-26 18:56:15'),
(6, '27e28eda02a73062ce377b884450cddd', '2024-11-26 20:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `phone_number`, `address`, `password`, `role_id`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'La Tuyết Huệ', 'tuyethuetv@gmail.com', '0776825215', 'Điện Biên Phủ phường 6 Thành phố Trà Vinh', '3437d1963b99f4fb83bcb41f38699566', 1, '2024-11-26 14:40:24', '2024-11-28 17:05:47', 0),
(6, 'user', 'user@gmail.com', '0123456789', 'Thành Phố Hồ Chí Minh', '3437d1963b99f4fb83bcb41f38699566', 2, '2024-11-26 20:28:24', '2024-11-28 23:07:56', 0),
(7, 'Hoàng Anh', 'hoanganh@gmail.com', '0945256708', 'Nguyễn Thiện Thành Phường 5 TPTV', '3437d1963b99f4fb83bcb41f38699566', 2, '2024-11-28 16:49:35', '2024-11-28 22:51:03', 0),
(9, 'Nguyễn Thị Tú', 'tunguyen@gmail.com', '041252745', 'Thành Phố Hồ Chí Minh', '3437d1963b99f4fb83bcb41f38699566', 2, '2024-11-28 16:59:01', '2024-11-28 23:21:50', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`user_id`,`token`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
