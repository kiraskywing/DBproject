-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 05 月 09 日 02:30
-- 伺服器版本： 10.4.17-MariaDB
-- PHP 版本： 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `NCTU_maskOrderDB`
--

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `purchase_amount` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `finish_time` timestamp NULL DEFAULT NULL,
  `order_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `city` varchar(17) NOT NULL,
  `per_mask_price` int(11) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `phone_number` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `shops`
--

INSERT INTO `shops` (`shop_id`, `shop_name`, `city`, `per_mask_price`, `stock_quantity`, `phone_number`) VALUES
(3, 'Shop AA', 'Taipei City', 50, 5, '0963714803'),
(4, 'BB shop', 'Taichung City', 500, 1000, '0917466219'),
(5, 'Best Care Pharmacy', 'Keelung City', 242, 613, '0916299311'),
(6, '278 Pharmacy', 'Pingtung City', 36, 406, '0910555488'),
(7, 'Duane Reade', 'Hsinchu County', 81, 105, '0958047416'),
(8, '90th Street Pharmacy', 'New Taipei City', 190, 707, '0910113504'),
(9, 'Avalon Chemists', 'Changhua City', 8, 76, '0931115201'),
(10, 'Ivan Pharmacy', 'Taitung City', 128, 637, '0931896813');

-- --------------------------------------------------------

--
-- 資料表結構 `shop_staffs`
--

CREATE TABLE `shop_staffs` (
  `staff_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `isMaster` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `shop_staffs`
--

INSERT INTO `shop_staffs` (`staff_id`, `shop_id`, `isMaster`) VALUES
(1, 3, 1),
(2, 4, 1),
(3, 7, 1),
(4, 5, 1),
(5, 6, 1),
(6, 8, 1),
(7, 9, 1),
(8, 10, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `account` varchar(40) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(4) NOT NULL,
  `phone_number` char(10) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `city` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`user_id`, `account`, `password`, `salt`, `phone_number`, `full_name`, `city`) VALUES
(1, 'user1', 'f4b933a187a223484bcb239d4645009c28024f88a6de6b0e8c921d2f5207c7ba', '5047', '0913177386', 'TA_1', 'New Taipei City'),
(2, 'user2', '0cb9f6ec29a356565623e7138aaa4e24ff15517df64b3d447f077db0b99682de', '3900', '0971669290', 'TA_2', 'Taichung City'),
(3, 'kiraskywing', '12085e5457f07cf010535edf1e7fa4a8720a71bf390152ff79e786b92fd569f7', '4929', '0988363795', 'Yi-Chang Lin', 'Hsinchu City'),
(4, 'stardustngc1569', '216e965c5f0582a9a761997f3803bd5b1b09b4ebc5dab008204bbee880ca287f', '5275', '0958714248', 'Orpha Brittain', 'Hualien City'),
(5, 'notespioneer10', 'd407aa903c614b225b1db227a0b7786b5804e2a57e59b6d1ced296e6f7c85fbe', '7085', '0963021203', 'Lilibeth Darbinian', 'Yilan County'),
(6, 'redflowerice', 'cd1a043dc68d9cdcaf71c37ec28ca090f275395efa968d85a01749c9b8e9a115', '6772', '0989917122', 'Kassidy Tod', 'Chiayi City'),
(7, 'kumquatngc1569', 'fc8402d7a5cb5b5a058ac340db4b6e479cedae9cb228ad0f2aadc36f0ae2321c', '3463', '0912540927', 'Harriette Traves', 'Kaohsiung City'),
(8, 'hockeyngc5195', 'f650534a6627577e51a2ab0c0b8f1652a37917ce49e19a5e6e475ba2be86a3fb', '5254', '0926035020', 'Kenya Ware', 'Matsu');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- 資料表索引 `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`shop_id`);

--
-- 資料表索引 `shop_staffs`
--
ALTER TABLE `shop_staffs`
  ADD PRIMARY KEY (`staff_id`,`shop_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `shops`
--
ALTER TABLE `shops`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `shop_staffs`
--
ALTER TABLE `shop_staffs`
  ADD CONSTRAINT `shop_staffs_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shop_staffs_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
