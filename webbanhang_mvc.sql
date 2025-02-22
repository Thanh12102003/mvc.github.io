SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Đồng hồ Nam', 'Đồng hồ Nam'),
(2, 'Đồng hồ Nữ', 'Đồng hồ Nữ');

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `customer_password` varchar(200) NOT NULL,
  `customer_status` int(11) NOT NULL,
  `backup_password` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customers` (`id`, `username`, `customer_password`, `customer_status`, `backup_password`, `created_date`) VALUES
(1, 'hieucustomer', 'e10adc3949ba59abbe56e057f20f883e', 1, 'e10adc3949ba59abbe56e057f20f883e', '2024-12-12 05:48:23'),
(2, 'hieucustomer2', 'e10adc3949ba59abbe56e057f20f883e', 1, 'e10adc3949ba59abbe56e057f20f883e', '2024-12-12 05:53:11'),
(3, 'hieucustomer3', 'e10adc3949ba59abbe56e057f20f883e', 1, 'e10adc3949ba59abbe56e057f20f883e', '2024-12-13 07:03:17');

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `ordercode` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cart_items` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`id`, `ordercode`, `customer_id`, `cart_items`, `status`, `created_at`, `updated_at`, `method`) VALUES
(1, '675A', 2, '[{\"id\":15,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 98\",\"price\":19000,\"quantity\":5,\"image_url\":\"675a88f788ab8_1461254189tissot_t52248131_2.jpg\"},{\"id\":8,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":23000,\"quantity\":3,\"image_url\":\"675a796360387_4bd30d84cdfa0ad7addda9badd18c261.jpg\"},{\"id\":12,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":39000,\"quantity\":5,\"image_url\":\"675a84f0f416c_31.jpg\"},{\"id\":13,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 24\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84fc2fde6_0000682_dong-ho-nu-day-kim-loai-yaqin-y6118-vang_300.jpeg\"}]', '2', '2024-12-12 08:24:34', '2024-12-13 08:05:51', NULL),
(2, '38830974', 2, '[{\"id\":15,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 98\",\"price\":19000,\"quantity\":5,\"image_url\":\"675a88f788ab8_1461254189tissot_t52248131_2.jpg\"},{\"id\":13,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 24\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84fc2fde6_0000682_dong-ho-nu-day-kim-loai-yaqin-y6118-vang_300.jpeg\"}]', '2', '2024-12-12 08:25:06', '2024-12-13 08:05:43', NULL),
(3, '04863191', 2, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a797400602_16p4r177.jpg\"},{\"id\":8,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":23000,\"quantity\":1,\"image_url\":\"675a796360387_4bd30d84cdfa0ad7addda9badd18c261.jpg\"}]', '2', '2024-12-12 08:27:14', '2024-12-13 08:05:23', NULL),
(4, '94446284', 2, '[{\"id\":11,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84e55299f_6-mau-dong-ho-deo-tay-nu-thoi-trang-dep-khong-the-roi-mat-sp2-9747SM02.jpg\"},{\"id\":12,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84f0f416c_31.jpg\"},{\"id\":13,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 24\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84fc2fde6_0000682_dong-ho-nu-day-kim-loai-yaqin-y6118-vang_300.jpeg\"}]', '2', '2024-12-12 08:27:37', '2024-12-13 07:35:16', NULL),
(5, '39937716', 2, '[{\"id\":11,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84e55299f_6-mau-dong-ho-deo-tay-nu-thoi-trang-dep-khong-the-roi-mat-sp2-9747SM02.jpg\"}]', '2', '2024-12-12 08:28:48', '2024-12-12 09:36:00', NULL),
(6, '94861418', 2, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a797400602_16p4r177.jpg\"}]', '2', '2024-12-12 08:49:21', '2024-12-12 09:34:07', NULL),
(7, '675aa5689d058', 2, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a797400602_16p4r177.jpg\"}]', '2', '2024-12-12 08:57:12', '2024-12-12 09:32:05', NULL),
(8, '675bd4d4932ff', 2, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":4,\"image_url\":\"675a797400602_16p4r177.jpg\"}]', '2', '2024-12-13 06:31:48', '2024-12-13 07:54:55', NULL),
(9, '675be34828b4b', 3, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":3,\"image_url\":\"675a797400602_16p4r177.jpg\"},{\"id\":11,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84e55299f_6-mau-dong-ho-deo-tay-nu-thoi-trang-dep-khong-the-roi-mat-sp2-9747SM02.jpg\"},{\"id\":13,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 24\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84fc2fde6_0000682_dong-ho-nu-day-kim-loai-yaqin-y6118-vang_300.jpeg\"}]', '2', '2024-12-13 07:33:28', '2024-12-13 07:35:40', NULL),
(10, '675beaf977ef4', 3, '[{\"id\":8,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":23000,\"quantity\":1,\"image_url\":\"675a796360387_4bd30d84cdfa0ad7addda9badd18c261.jpg\"},{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a797400602_16p4r177.jpg\"},{\"id\":11,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84e55299f_6-mau-dong-ho-deo-tay-nu-thoi-trang-dep-khong-the-roi-mat-sp2-9747SM02.jpg\"}]', '2', '2024-12-13 08:06:17', '2024-12-13 08:06:25', NULL),
(11, '675c0267aab6c', 3, '[{\"tensanpham\":null,\"id\":8,\"soluong\":null,\"giasp\":null,\"hinhanh\":null,\"masp\":null},{\"tensanpham\":null,\"id\":11,\"soluong\":null,\"giasp\":null,\"hinhanh\":null,\"masp\":null},{\"tensanpham\":\"Laptop Lenovo Gaming LOQ 15IAX9 i5 12450HX\\/16GB\\/512GB\\/6GB RTX3050\\/144Hz\\/Win11\",\"id\":\"81\",\"soluong\":1,\"giasp\":\"33590000\",\"hinhanh\":\"1732865756_lenovo-loq-gaming-.jpg\",\"masp\":\"SKU723\"},{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a797400602_16p4r177.jpg\"}]', '1', '2024-12-13 09:46:15', '2024-12-13 09:46:15', NULL),
(12, '675c046cb899c', 3, '[{\"id\":14,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 54\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a850fc6b8e_31.jpg\"}]', '1', '2024-12-13 09:54:52', '2024-12-13 09:54:52', NULL),
(13, '675c0caeebae1', 3, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":2,\"image_url\":\"675a797400602_16p4r177.jpg\"}]', '1', '2024-12-13 10:30:06', '2024-12-13 10:30:06', NULL),
(14, '675c0d9926d45', 3, '[{\"id\":10,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix\",\"price\":29000,\"quantity\":1,\"image_url\":\"675a797400602_16p4r177.jpg\"}]', '1', '2024-12-13 10:34:01', '2024-12-13 10:34:01', 'COD'),
(15, '675c0db81ec02', 3, '[{\"id\":13,\"name\":\"\\u0110\\u1ed3ng h\\u1ed3 n\\u1eef Felix 24\",\"price\":39000,\"quantity\":1,\"image_url\":\"675a84fc2fde6_0000682_dong-ho-nu-day-kim-loai-yaqin-y6118-vang_300.jpeg\"}]', '2', '2024-12-13 10:34:32', '2024-12-13 10:38:05', 'MOMO');

CREATE TABLE `order_statistics` (
  `id` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `total_orders` int(11) DEFAULT 0,
  `total_quantity` int(11) DEFAULT 0,
  `total_profit` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_statistics` (`id`, `date_created`, `total_orders`, `total_quantity`, `total_profit`) VALUES
(1, '2024-12-13', 3, 11, 130000.00),
(2, '2024-12-12', 3, 2, 230000.00),
(3, '2024-12-11', 6, 3, 61000.00),
(4, '2024-12-10', 3, 7, 330000.00),
(5, '2024-12-05', 2, 40, 91400.00),
(6, '2024-12-06', 9, 14, 230500.00),
(7, '2024-12-07', 2, 9, 61400.00),
(8, '2024-12-08', 3, 12, 330000.00);


CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` int(100) NOT NULL,
  `image` text NOT NULL,
  `status` int(11) NOT NULL,
  `description` text NOT NULL,
  `original_price` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `image`, `status`, `description`, `original_price`) VALUES
(8, 'Đồng hồ nữ Felix', 1, 23000, '675a796360387_4bd30d84cdfa0ad7addda9badd18c261.jpg', 0, 'Đồng hồ nữ Felix', '12000'),
(10, 'Đồng hồ nữ Felix', 2, 29000, '675a797400602_16p4r177.jpg', 0, 'Đồng hồ nữ Felix', '15000'),
(11, 'Đồng hồ nữ Felix', 1, 39000, '675a84e55299f_6-mau-dong-ho-deo-tay-nu-thoi-trang-dep-khong-the-roi-mat-sp2-9747SM02.jpg', 0, 'Đồng hồ nữ Felix', '30000'),
(12, 'Đồng hồ nữ Felix', 2, 39000, '675a84f0f416c_31.jpg', 0, 'Đồng hồ nữ Felix', '15000'),
(13, 'Đồng hồ nữ Felix 24', 2, 39000, '675a84fc2fde6_0000682_dong-ho-nu-day-kim-loai-yaqin-y6118-vang_300.jpeg', 0, 'Đồng hồ nữ Felix', '17000'),
(14, 'Đồng hồ nữ Felix 54', 2, 29000, '675a850fc6b8e_31.jpg', 0, 'Đồng hồ nữ Felix', '25000'),
(15, 'Đồng hồ nữ Felix 98', 2, 19000, '675a88f788ab8_1461254189tissot_t52248131_2.jpg', 0, 'Đồng hồ nữ Felix', '13000'),
(16, 'Đồng hồ Nữ 1234', 2, 25000, '675be59b08b6d_675a850fc6b8e_31.jpg', 0, 'Đồng hồ Nữ 1234', '12000');


CREATE TABLE `shippings` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `note` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `shippings` (`id`, `name`, `address`, `phone`, `note`, `user_id`) VALUES
(1, 'Trương Hiếuads', '12/4 Địa chỉs', '0932023002d', 'dasda', 2),
(2, '0932023992', 'Số 1 Lê Duẩn, Bến Nghé, Quận 1', '0932023992', 'dasdas', 3);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`, `created_date`) VALUES
(1, 'hieuadmin4', '25f9e794323b453885f5181f1b624d0b', '2024-12-13 08:41:17'),
(2, 'hieucustomer', 'e10adc3949ba59abbe56e057f20f883e', '2024-12-13 08:41:32'),
(3, 'hieucustomer7', 'e10adc3949ba59abbe56e057f20f883e', '2024-12-13 08:31:46');

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordercode_idx` (`ordercode`);

ALTER TABLE `order_statistics`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `order_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `shippings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;
