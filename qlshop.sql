-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 18, 2024 lúc 09:46 AM
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
  `customer_id` varchar(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmail` varchar(50) NOT NULL,
  `role_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `address`, `gmail`, `role_id`) VALUES
('0123456789', '', '', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `note`
--

CREATE TABLE `note` (
  `note_id` int(5) NOT NULL,
  `note_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `note_img` varchar(50) NOT NULL,
  `type_status_id` int(5) NOT NULL
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
  `customer_id` varchar(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(24, 'yến 1', 'czcxzcdaferteryeryerter', 2, 90, 'Copy of Sua non to yen cho nguoi gia 1.png', '2024-12-18 00:50:21', 23, 15),
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
(37, 'rong nho 1', 'dsadsa', 2, 233, 'Copy of GÓI 100G IN FULL - T.jpg', '2024-12-18 06:24:49', 24, 15);

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
(15, 20);

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
(23, 'yến', 'Copy of H 1  hồng sâm đông trùng hạ thảo-01.png'),
(24, 'rong nho', 'Copy of box Vmax-01.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_status`
--

CREATE TABLE `type_status` (
  `type_status_id` int(5) NOT NULL,
  `type_status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `type_status_id` (`type_status_id`);

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
-- Chỉ mục cho bảng `type_status`
--
ALTER TABLE `type_status`
  ADD PRIMARY KEY (`type_status_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `note`
--
ALTER TABLE `note`
  MODIFY `note_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `oder`
--
ALTER TABLE `oder`
  MODIFY `oder_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  MODIFY `detail_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `saleoff_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `type_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `type_status`
--
ALTER TABLE `type_status`
  MODIFY `type_status_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Các ràng buộc cho bảng `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`type_status_id`) REFERENCES `type_status` (`type_status_id`);

--
-- Các ràng buộc cho bảng `oder`
--
ALTER TABLE `oder`
  ADD CONSTRAINT `oder_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `oder_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

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
