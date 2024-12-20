-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 09:23 AM
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
-- Database: `qlshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `gmail` varchar(50) DEFAULT NULL,
  `role_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `phone_number`, `customer_name`, `address`, `gmail`, `role_id`) VALUES
(2, '1312314', 'anh Hải', 'Ninh Hoa,Khánh Hòa', '', 1),
(3, '841312314', 'anh Hải', 'Ninh Hoa,Khánh Hòa', '', 1),
(4, '13132314', 'anh Hải', '20', '', 1),
(14, '0962071416', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `note_id` int(5) NOT NULL,
  `note_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `note_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oder`
--

CREATE TABLE `oder` (
  `oder_id` int(5) NOT NULL,
  `address` varchar(50) NOT NULL,
  `oder_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(200) NOT NULL,
  `status_id` int(5) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oder`
--

INSERT INTO `oder` (`oder_id`, `address`, `oder_date`, `description`, `status_id`, `customer_id`, `total_price`) VALUES
(38, 'Ninh Hoa,Khánh Hòa', '2024-12-19 09:06:42', '', 1, 2, 0),
(39, 'Ninh Hoa,Khánh Hòa', '2024-12-19 09:12:55', '', 1, 3, 0),
(40, '20', '2024-12-19 09:14:27', '', 1, 4, 0),
(46, '20', '2024-12-19 09:27:31', '', 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `oder_detail`
--

CREATE TABLE `oder_detail` (
  `detail_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `oder_id` int(5) NOT NULL,
  `quantity_oder` int(11) NOT NULL,
  `price_oder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oder_detail`
--

INSERT INTO `oder_detail` (`detail_id`, `product_id`, `oder_id`, `quantity_oder`, `price_oder`) VALUES
(17, 25, 38, 1, 1114),
(18, 24, 38, 1, 90),
(19, 24, 39, 1, 90),
(20, 26, 39, 1, 233),
(21, 25, 40, 1, 1114),
(22, 33, 40, 1, 233),
(23, 24, 46, 1, 90),
(24, 33, 46, 1, 233);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `describe_product` varchar(2048) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `img` varchar(50) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_id` int(5) NOT NULL,
  `saleoff_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `describe_product`, `quantity`, `price`, `img`, `create_at`, `type_id`, `saleoff_id`) VALUES
(24, 'yến 1', '', 2, 90, 'Copy of Sua non to yen cho nguoi gia 1.png', '2024-12-18 00:50:21', 23, 15),
(25, 'yến 2', '', 2, 1114, 'Copy of KHÔNG-ĐƯỜNG-png-scaled-e1636422295115.png', '2024-12-18 00:50:49', 23, 15),
(26, 'yến 3', '', 1, 233, 'Copy of Nuoc yen nhan sam 1.png', '2024-12-18 00:51:12', 23, 15),
(27, 'yến 4', '', 2, 900, 'Copy of H 1  yến sào hồng sâm-01.png', '2024-12-18 00:52:19', 23, 15),
(28, 'yến 5', '', 2, 233, 'Copy of H 1  sữa tổ yến cho người lớn-01.png', '2024-12-18 00:52:55', 23, 15),
(29, 'yến 6', '', 5, 233, 'Copy of Sua non to yen cho nguoi gia 1.png', '2024-12-18 00:53:57', 23, 15),
(32, 'yến 7', '', 2, 233, 'Copy of H 1  sữa tổ yến cho người lớn-01.png', '2024-12-18 01:02:27', 23, 15),
(33, 'yến 8', '', 1, 233, 'Copy of H 1  yến sào hồng sâm-01.png', '2024-12-18 01:02:44', 23, 15),
(34, 'yến 9', '', 2, 233, 'Copy of KHÔNG-ĐƯỜNG-png-scaled-e1636422295115.png', '2024-12-18 01:02:54', 23, 15),
(35, 'yến 10', '', 2, 321, 'Copy of H 1  hồng sâm đông trùng hạ thảo-01.png', '2024-12-18 01:03:12', 23, 15),
(36, 'yến 11', '', 1, 233, 'Copy of Nuoc yen nhan sam 2.png', '2024-12-18 01:03:25', 23, 15);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(5) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Người dùng'),
(2, 'Nhân viên');

-- --------------------------------------------------------

--
-- Table structure for table `saleoff`
--

CREATE TABLE `saleoff` (
  `saleoff_id` int(5) NOT NULL,
  `sale_name` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saleoff`
--

INSERT INTO `saleoff` (`saleoff_id`, `sale_name`) VALUES
(15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE `slide` (
  `slide_id` int(11) NOT NULL,
  `slide_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(5) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'chuẩn bị hàng'),
(2, 'đang vận chuyển'),
(3, 'đang giao hàng'),
(4, 'đã giao');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(5) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type_name`, `type_img`) VALUES
(23, 'yến', 'Copy of H 1  hồng sâm đông trùng hạ thảo-01.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `oder`
--
ALTER TABLE `oder`
  ADD PRIMARY KEY (`oder_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `oder_detail`
--
ALTER TABLE `oder_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `oder_detail_ibfk_1` (`product_id`),
  ADD KEY `oder_detail_ibfk_2` (`oder_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `saleoff_id` (`saleoff_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `saleoff`
--
ALTER TABLE `saleoff`
  ADD PRIMARY KEY (`saleoff_id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `note_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oder`
--
ALTER TABLE `oder`
  MODIFY `oder_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `oder_detail`
--
ALTER TABLE `oder_detail`
  MODIFY `detail_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `saleoff`
--
ALTER TABLE `saleoff`
  MODIFY `saleoff_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `oder`
--
ALTER TABLE `oder`
  ADD CONSTRAINT `oder_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `order_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `oder_detail`
--
ALTER TABLE `oder_detail`
  ADD CONSTRAINT `oder_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `oder_detail_ibfk_2` FOREIGN KEY (`oder_id`) REFERENCES `oder` (`oder_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`saleoff_id`) REFERENCES `saleoff` (`saleoff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
