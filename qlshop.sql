-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 27, 2024 lúc 09:38 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `role_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`customer_id`, `phone_number`, `customer_name`, `address`, `point`, `role_id`) VALUES
(22, '+841312314', 'anh Hải', '20', 367, 1),
(24, '+8486926945', NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `note`
--

CREATE TABLE `note` (
  `note_id` int(5) NOT NULL,
  `note_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `note_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oder`
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
-- Đang đổ dữ liệu cho bảng `oder`
--

INSERT INTO `oder` (`oder_id`, `address`, `oder_date`, `description`, `status_id`, `customer_id`, `total_price`) VALUES
(52, '20', '2024-12-26 01:29:36', '', 1, 22, 1114),
(53, 'Ninh Hoa,Khánh Hòa', '2024-12-26 01:30:52', '', 1, 22, 2046),
(54, '20', '2024-12-26 01:43:19', 'khong nhan hang', 1, 22, 323),
(55, '20', '2024-12-26 01:44:25', '', 1, 22, 3357),
(56, '20', '2024-12-27 02:10:08', '', 1, 22, 4512),
(57, '20', '2024-12-27 02:10:38', '', 1, 22, 0),
(58, 'Ninh Hoa,Khánh Hòa', '2024-12-27 06:43:11', '', 1, 22, 2228),
(59, 'Ninh Hoa,Khánh Hòa', '2024-12-27 07:34:50', '', 1, 22, 3342),
(60, '20', '2024-12-27 08:35:11', '', 1, 22, 1114);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oder_detail`
--

CREATE TABLE `oder_detail` (
  `detail_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `oder_id` int(5) NOT NULL,
  `quantity_oder` int(11) NOT NULL,
  `price_oder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `oder_detail`
--

INSERT INTO `oder_detail` (`detail_id`, `product_id`, `oder_id`, `quantity_oder`, `price_oder`) VALUES
(34, 25, 52, 1, 1114),
(35, 25, 53, 1, 1114),
(36, 29, 53, 1, 233),
(37, 33, 53, 3, 233),
(38, 24, 54, 1, 90),
(39, 26, 54, 1, 233),
(40, 24, 55, 14, 90),
(41, 26, 55, 9, 233),
(42, 25, 56, 3, 1114),
(43, 24, 56, 13, 90),
(44, 25, 58, 2, 1114),
(45, 25, 59, 3, 1114),
(46, 25, 60, 1, 1114);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
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
-- Đang đổ dữ liệu cho bảng `product`
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
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `role_id` int(5) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Người dùng'),
(2, 'Nhân viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `saleoff`
--

CREATE TABLE `saleoff` (
  `saleoff_id` int(5) NOT NULL,
  `discount_rate` int(5) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `saleoff`
--

INSERT INTO `saleoff` (`saleoff_id`, `discount_rate`, `point`, `discount`) VALUES
(15, 20, NULL, 0),
(16, NULL, 100, 50000),
(17, NULL, 200, 100000),
(18, NULL, 1000, 1000000),
(19, NULL, 2000, 2000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slide`
--

CREATE TABLE `slide` (
  `slide_id` int(11) NOT NULL,
  `slide_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `status_id` int(5) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'chuẩn bị hàng'),
(2, 'đang vận chuyển'),
(3, 'đang giao hàng'),
(4, 'đã giao');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type`
--

CREATE TABLE `type` (
  `type_id` int(5) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `type`
--

INSERT INTO `type` (`type_id`, `type_name`, `type_img`) VALUES
(23, 'yến', 'Copy of H 1  hồng sâm đông trùng hạ thảo-01.png');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Chỉ mục cho bảng `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`note_id`);

--
-- Chỉ mục cho bảng `oder`
--
ALTER TABLE `oder`
  ADD PRIMARY KEY (`oder_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `oder_detail_ibfk_1` (`product_id`),
  ADD KEY `oder_detail_ibfk_2` (`oder_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `saleoff_id` (`saleoff_id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Chỉ mục cho bảng `saleoff`
--
ALTER TABLE `saleoff`
  ADD PRIMARY KEY (`saleoff_id`);

--
-- Chỉ mục cho bảng `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`slide_id`);

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Chỉ mục cho bảng `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `note`
--
ALTER TABLE `note`
  MODIFY `note_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `oder`
--
ALTER TABLE `oder`
  MODIFY `oder_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  MODIFY `detail_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `saleoff`
--
ALTER TABLE `saleoff`
  MODIFY `saleoff_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `slide`
--
ALTER TABLE `slide`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Các ràng buộc cho bảng `oder`
--
ALTER TABLE `oder`
  ADD CONSTRAINT `oder_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `order_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Các ràng buộc cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  ADD CONSTRAINT `oder_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `oder_detail_ibfk_2` FOREIGN KEY (`oder_id`) REFERENCES `oder` (`oder_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`saleoff_id`) REFERENCES `saleoff` (`saleoff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
