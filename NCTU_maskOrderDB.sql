-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 05 月 09 日 11:28
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
(3, 'Shop AA', 'Taipei City', 50, 10, '0963714803'),
(4, 'BB shop', 'Taichung City', 500, 1000, '0917466219'),
(5, 'Best Care Pharmacy', 'Keelung City', 242, 613, '0916299311'),
(6, '278 Pharmacy', 'Pingtung City', 36, 406, '0910555488'),
(7, 'Duane Reade', 'Hsinchu County', 81, 105, '0958047416'),
(8, '90th Street Pharmacy', 'New Taipei City', 190, 707, '0910113504'),
(9, 'Avalon Chemists', 'Changhua City', 8, 76, '0931115201'),
(10, 'Ivan Pharmacy', 'Taitung City', 128, 637, '0931896813'),
(11, '94NiceShop', 'Hsinchu City', 5, 300, '0927734881'),
(12, 'Perfect drug store 87', 'Nantou City', 15, 100, '0915466824'),
(13, 'Drug Loft', 'Miaoli City', 40, 777, '0919026609'),
(14, 'Alpina Pharmacy INC', 'Kaohsiung City', 333, 2000, '0934645597'),
(15, 'Pharmacy Channel', 'Nantou City', 100, 777, '0960875980'),
(16, 'All Health Pharmacy', 'Hualien City', 77, 400, '0982650559'),
(17, 'Royal Care Pharmacy', 'Pingtung County', 4, 900, '0956037350'),
(18, 'Buy-Rite Pharmacy', 'Hualien County', 15, 200, '0911903836'),
(19, 'People Choice Pharmacy', 'Taipei City', 25, 600, '0919153766');

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
(1, 4, 0),
(2, 4, 1),
(3, 3, 0),
(3, 4, 0),
(3, 7, 1),
(3, 12, 0),
(4, 5, 1),
(5, 6, 1),
(6, 8, 1),
(6, 11, 0),
(7, 9, 1),
(8, 4, 0),
(8, 10, 1),
(9, 3, 0),
(9, 12, 1),
(10, 11, 1),
(11, 13, 1),
(12, 14, 1),
(13, 3, 0),
(13, 15, 1),
(14, 16, 1),
(15, 4, 0),
(15, 17, 1),
(16, 18, 1),
(17, 19, 1),
(20, 3, 0);

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
(8, 'hockeyngc5195', 'f650534a6627577e51a2ab0c0b8f1652a37917ce49e19a5e6e475ba2be86a3fb', '5254', '0926035020', 'Kenya Ware', 'Matsu'),
(9, 'vegasergue2', 'f604a9bf8af343a7ca8e055065a50a741ff4e1979241e9c3f5865c40ad79eb2d', '1244', '0938261511', 'Niles Woodham', 'Kinmen County'),
(10, 'pigbeefse7en', '254f44698de7daf06743e4f981786677ffa8cfe8a53abbe7c4f679b6a20fdcc8', '7368', '0956671752', 'Almast Midgley', 'Tainan City'),
(11, 'IAmSoCool9487', '580fa5ead08798167cad69378af872c82129580aacb349efd4b36d398434fff4', '8273', '0915169850', 'Nolene Christians', 'Pingtung City'),
(12, 'ricesaltnet', '0c61a4fdf5732e36ee49c21e251b32f1719ff1d1ef91f54b0a7c6de2a70ffb40', '6107', '0917628347', 'Jeri Archer', 'Taichung City'),
(13, 'neopeaceful', '0f5477bc90341ce639e3f615e77cecf746bdf9aa91c93e98e758e126976da6f0', '4688', '0989011696', 'Lemoine Bloodworth', 'Green Island'),
(14, 'ngc5195voyager2ran', 'b6288431bdf5afbb2e82fa5ca003f9c018e98fba38a347af4faa63115107a2c8', '2627', '0958943043', 'Arvel Randall', 'Taitung County'),
(15, 'tigerdonut', 'da82350cc28869ca343139146a08f5f33293ef1b71e4d666799c17a469c3d30a', '9451', '0971347365', 'Josepha Crisp', 'Changhua City'),
(16, 'antsergue2', '8362346d1c0ae8818d55c039facbe5fc87e5609aa1785a15e47aa41303e79932', '7522', '0937193290', 'Hourig Warrick', 'Yilan City'),
(17, 'sergue2cat', '61cba529b7c809e6b682244e2a3a53f63d58f3e7c67ada4cbd2ad121130cf6cf', '4880', '0923460905', 'Virgie Byrd', 'Keelung City'),
(18, 'sn1987aegg', '574e331d99f085c0be3de304aa75221cd0763227ab9ae2aea27c18b874ee0217', '7416', '0933956816', 'Lyric Seymour', 'Lienchiang County'),
(19, 'delightfulwolf', 'fbe2408d6eec2327ce912b712c5baf2889e5dedab24fb7b1ef811ec6ee4ce208', '9833', '0963003377', 'Shepherd Minett', 'New Taipei City'),
(20, 'violatoast', 'd479cc04021a43c0c1dc1722cc10b2291dae4d2de76cb749cd9d480806816fa5', '3683', '0929163821', 'Payton Willoughby', 'Chiayi County'),
(21, 'lastradapuppy', '76b8170932bf5037784be853bc15c66758b263055fdf477d023ce9a4fdd94e2e', '7940', '0954071960', 'Wilburn Peterson', 'Penghu County'),
(22, 'ostrichsputnik1', '469fbb47f8f6342dd2e40ae22d3be70653dcc0db96114a667eeaab440cc954af', '5204', '0939783818', 'Stafford Statham', 'Yunlin County'),
(23, 'cokeabell1835tea', 'a861082bbfcf5893f62d6786af9fda905a7e2b9482f4d57c8a42865053bf8b97', '5591', '0982253254', 'Ernie Hicks', 'Taoyuan City');

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
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
