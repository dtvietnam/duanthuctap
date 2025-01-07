-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 04, 2025 lúc 08:19 AM
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
  `phone_number` varchar(13) NOT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `point` int(11) NOT NULL,
  `role_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`customer_id`, `phone_number`, `customer_name`, `address`, `point`, `role_id`) VALUES
(2, '1312314', 'anh Hải', 'Ninh Hoa,Khánh Hòa', 1, 1),
(3, '841312314', 'anh Hải', 'Ninh Hoa,Khánh Hòa', 0, 1),
(4, '13132314', 'anh Hải', '20', 0, 1),
(14, '0962071416', NULL, NULL, 0, 1),
(15, '+841312314', 'anh Hải', '20', 0, 1),
(17, '+8486926945', 'anh Hải', 'califonia', 0, 1),
(18, '+8432569865', 'anh Hải', 'Ninh Hoa,Khánh Hòa', 0, 1),
(19, '+8432569854', 'anh Hải', 'Ninh Hoa,Khánh Hòa', 0, 1),
(20, '+8432569854', 'anh Hải', 'Ninh Hoa,Khánh Hòa', 0, 1),
(21, '+8432569854', 'anh Hải', 'Ninh Hoa,Khánh Hòa', 0, 1),
(22, '0123456789', 'Test User', '123 Test Street', 0, 1),
(24, '0773915146', NULL, NULL, 0, 2),
(25, '+8477391514', NULL, NULL, 0, 2);

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

--
-- Đang đổ dữ liệu cho bảng `note`
--

INSERT INTO `note` (`note_id`, `note_name`, `description`, `note_img`) VALUES
(9, 'aa', 'zxcxzvfdsfdsasd', 'about.jpg'),
(10, 'Khánh thành nhà máy kết hợp du lịch sinh thái ở Kh', 'Tối 28.12, tại KCN Đắc Lộc, xã Vĩnh Phương, TP. Nha Trang (Khánh Hòa), Công ty cổ phần Yến sào DTNEST Khánh Hòa (thuộc D&T Group) tổ chức lễ khánh thành nhà máy sản xuất yến sào, rong biển D&T.', 'contact.jpg');

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
(38, 'Ninh Hoa,Khánh Hòa', '2024-12-19 09:06:42', '', 2, 2, 0),
(39, 'Ninh Hoa,Khánh Hòa', '2024-12-19 09:12:55', '', 2, 3, 0),
(40, '20', '2024-12-19 09:14:27', '', 4, 4, 0),
(46, '20', '2024-12-19 09:27:31', '', 2, 2, 0),
(47, 'Ninh Hoa,Khánh Hòa', '2024-12-24 07:13:00', '', 1, 18, 0),
(48, 'Ninh Hoa,Khánh Hòa', '2024-12-24 07:32:52', '', 1, 20, 1580),
(49, 'Ninh Hoa,Khánh Hòa', '2024-12-24 09:05:31', '', 4, 21, 58037),
(52, 'nhà riêng', '2025-01-03 01:40:53', '', 1, 25, 100);

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
(17, 25, 38, 1, 1114),
(18, 24, 38, 1, 90),
(19, 24, 39, 1, 90),
(20, 26, 39, 1, 233),
(21, 25, 40, 1, 1114),
(22, 33, 40, 1, 233),
(23, 24, 46, 1, 90),
(24, 33, 46, 1, 233),
(25, 24, 47, 8, 90),
(26, 26, 47, 1, 233),
(27, 25, 47, 2, 1114),
(28, 25, 48, 1, 1114),
(29, 29, 48, 1, 233),
(30, 32, 48, 1, 233),
(31, 24, 49, 11, 90),
(32, 25, 49, 51, 1114),
(33, 26, 49, 1, 233),
(34, 26, 52, 1, 0),
(35, 27, 52, 1, 111);

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
(36, 'yến 11', '', 1, 233, 'Copy of Nuoc yen nhan sam 2.png', '2024-12-18 01:03:25', 23, 15),
(37, 'bb', 'dsadsa', 2, 234, 'fruit.jpg', '2025-01-02 01:51:28', 24, 15);

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
  `sale_name` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `saleoff`
--

INSERT INTO `saleoff` (`saleoff_id`, `sale_name`) VALUES
(15, 20),
(16, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slide`
--

CREATE TABLE `slide` (
  `slide_id` int(11) NOT NULL,
  `slide_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `slide`
--

INSERT INTO `slide` (`slide_id`, `slide_img`) VALUES
(4, '5_banner (1).jpg'),
(5, '7_banner (2).jpg');

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
(4, 'đã giao'),
(5, 'đã hủy đơn');

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
(23, 'yến', 'Copy of H 1  hồng sâm đông trùng hạ thảo-01.png'),
(24, 'rong nho', 'fruit.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  `note` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `video`
--

INSERT INTO `video` (`video_id`, `link`, `note`) VALUES
(1, '2024-10-28 13-33-26.mkv', 'a');

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
-- Chỉ mục cho bảng `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `note`
--
ALTER TABLE `note`
  MODIFY `note_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `oder`
--
ALTER TABLE `oder`
  MODIFY `oder_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  MODIFY `detail_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `saleoff`
--
ALTER TABLE `saleoff`
  MODIFY `saleoff_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `slide`
--
ALTER TABLE `slide`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
