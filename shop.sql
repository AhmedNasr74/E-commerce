-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2018 at 07:53 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ordering` text NOT NULL,
  `visibilty` tinyint(4) NOT NULL,
  `allow_coment` tinyint(4) NOT NULL,
  `allow_ads` tinyint(4) NOT NULL,
  `Datereg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `name`, `description`, `ordering`, `visibilty`, `allow_coment`, `allow_ads`, `Datereg`) VALUES
(5, 'Vehicles', 'Contain Cars', '32', 1, 1, 1, '2018-02-05'),
(6, 'Electronics', 'Contain Electronics & Home Appliances Home & Garden Fashion & Beauty Pets', '0', 1, 1, 1, '2018-02-05'),
(7, 'Fashion', 'For Clothes', '0', 1, 1, 1, '2018-02-05'),
(8, 'Pets Kids', '', '0', 1, 1, 1, '2018-02-05'),
(9, 'Babies Sporting Goods', 'For any babies needs', '0', 1, 1, 1, '2018-02-05'),
(10, 'Games', '', '0', 1, 1, 1, '2018-02-05'),
(11, 'Computer', '', '0', 1, 1, 1, '2018-02-13'),
(12, 'Mobile Phone & Accessories', '', '', 1, 1, 1, '2018-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `coment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `stat` int(11) NOT NULL DEFAULT '0',
  `coment date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`coment_id`, `comment`, `stat`, `coment date`, `item_id`, `user_id`) VALUES
(3, 'Very Good Labtop ', 1, '2018-02-18', 13, 1),
(5, 'Hello World ', 1, '2018-02-18', 13, 1),
(8, 'Very Good Labtop', 1, '2018-02-18', 13, 2),
(9, 'Very Good', 1, '2018-02-19', 14, 2),
(10, 'Very Good', 1, '2018-02-19', 14, 2),
(13, 'That is the Best Game i have ever seen ', 1, '2018-02-24', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `maker` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'empty.png',
  `stat` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `aprov` tinyint(4) NOT NULL DEFAULT '0',
  `member_ID` int(11) NOT NULL,
  `category_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `name`, `description`, `price`, `add_date`, `maker`, `img`, `stat`, `rate`, `aprov`, `member_ID`, `category_ID`) VALUES
(3, 'Medel Of Honer', 'action game', '30', '2018-02-14', 'USA', '355414_images.jpg', 'New', 0, 1, 2, 10),
(4, 'infinxZero2', 'Mobile phone', '30', '2018-02-14', 'USA', '521839_download.jpg', 'New', 0, 1, 1, 12),
(5, 'PES2018', 'good game', '20', '2018-02-14', 'USA', '121200_images.jpg', 'New', 0, 1, 8, 10),
(7, 'fifa16', 'nice game (football)', '20', '2018-02-14', 'USA', '411300_download.jpg', 'New', 0, 1, 6, 10),
(9, 'fifa18', 'good game', '30', '2018-02-14', 'Egypt', '450341_81jDVG9z4rL._SX342_.jpg', 'New', 0, 1, 5, 10),
(10, 'Al-ahly NootBook', 'NootBook', '5', '2018-02-17', 'China', '34199_download.jpg', 'New', 0, 1, 1, 8),
(11, 'Beats TM-10', 'headphont with blutooth ', '32', '2018-02-17', 'China', '821612_download.jpg', 'New', 0, 1, 1, 12),
(12, 'Galaxy Grand Prime ', 'color is Gold , Ram is 1', '100', '2018-02-17', 'Canada', '611828_download.jpg', 'Like New', 0, 1, 1, 6),
(13, 'acer E71-500', 'Labtop Computer', '200', '2018-02-17', 'Canada', '349324_download.jpg', 'Used', 0, 1, 1, 11),
(14, 'Nokia-Chargrer', 'Good Chargrer For Nokia Mobs ', '13', '2018-02-18', 'China', '776230_download.jpg', 'New', 0, 1, 2, 6),
(16, 'x-BOX', 'Computer accesories', '200', '2018-02-19', 'Canada', '485552_download.jpg', 'New', 0, 1, 6, 6),
(17, 'Leaft 4 Dead', 'killing Zombies in the game', '60', '2018-02-24', 'china', '183962_download.jpg', 'New', 0, 1, 4, 10),
(19, 'PS3', 'Very Good Playstation Divece	', '30', '2018-02-25', 'China', '195787_download.jpg', 'Like New', 0, 1, 1, 10),
(20, 'Blur', 'Racing Game', '10', '2018-02-28', 'Turky', '336414_download.jpg', 'New', 0, 1, 1, 10),
(21, 'HP laptop', '2G-RAM - 500G-HardDisk - 15.5 Bousa', '200', '2018-03-04', 'USA', '323718_download.jpg', 'Used', 0, 1, 1, 11),
(22, 'Lenovo laptop', '2G-RAM - 1T-HardDisk - 15.5 Bousa', '220', '2018-03-04', 'Germany', '159919_download.jpg', 'New', 0, 1, 2, 11);

-- --------------------------------------------------------

--
-- Table structure for table `paid_items`
--

CREATE TABLE `paid_items` (
  `payID` int(11) NOT NULL COMMENT 'opreation Id',
  `customer_id` int(11) DEFAULT NULL COMMENT 'customer id if he has account',
  `customer_name` varchar(255) NOT NULL COMMENT 'customer name',
  `c_phone1` varchar(255) NOT NULL COMMENT 'phone',
  `c_phone2` varchar(255) NOT NULL COMMENT 'phone',
  `card_num` text NOT NULL COMMENT 'Visa or paypal',
  `email` text NOT NULL COMMENT 'email',
  `address` varchar(255) DEFAULT NULL,
  `itemID` int(11) NOT NULL COMMENT 'paid item',
  `owner_id` int(11) NOT NULL COMMENT 'owner of the item'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paid_items`
--

INSERT INTO `paid_items` (`payID`, `customer_id`, `customer_name`, `c_phone1`, `c_phone2`, `card_num`, `email`, `address`, `itemID`, `owner_id`) VALUES
(1, 1, 'Ahmed Nasr', '01150225286', '01064515066', 'ahmed.alaa.cis@gmail.com', '66933342258236', '28-elborg st, Elmarg-Cairo', 19, 1),
(2, 1, 'Saher Nasr', '01122425599', '01153224476', 'sahernasr88@gmail.com', '21344564894752', '66-elborg st, Elmarg-Alex', 17, 4),
(3, 1, 'Nada Nasr', '01150225286', '01153224476', 'ahmed.alaa.cis@gmail.com', '64643210065646', '28-elborg st, Elmarg-Cairo', 11, 1),
(4, NULL, 'Hany Adel', '01150225268', '01152552599', 'hanyadel2014@gmail.com', '58485468465213', 'Cairo', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `usernname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `GroupID` tinyint(4) NOT NULL DEFAULT '0',
  `RegState` tinyint(4) NOT NULL DEFAULT '0',
  `Datereg` date NOT NULL,
  `user_img` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'emptyuser.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `usernname`, `password`, `email`, `fullname`, `GroupID`, `RegState`, `Datereg`, `user_img`) VALUES
(1, 'ahmed', '8cb2237d0679ca88db6464eac60da96345513964', 'ahmednasr258@yahoo.com', 'Ahmed Nasr', 1, 1, '2018-02-01', '563971_IMG_6503.jpg'),
(2, 'asmaa', '8cb2237d0679ca88db6464eac60da96345513964', 'asmaa.sobhy@m.co', 'Asmaa Sobhy', 0, 1, '2018-11-21', '222391_pexels-photo-59657.jpg'),
(4, 'gamal', '8cb2237d0679ca88db6464eac60da96345513964', 'm.gamal@yahoo.com', 'Mohamed gamal', 0, 1, '2018-01-30', 'emptyuser.png'),
(5, 'shrif28', 'dbec48546233795876ca23ffaac1b8235f744909', 'shrif@gmail.com', 'Shrif Elshikh', 0, 1, '2018-01-30', 'emptyuser.png'),
(6, 'Jemmy', '666750260553ce92f4845e43b7e4461abdb18c76', 'jemmey@info.org', 'Jemmy ALaa', 0, 1, '2018-01-30', 'emptyuser.png'),
(7, 'saher25', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'saher@gmail.co', 'Saher Naser', 0, 1, '2018-01-30', 'emptyuser.png'),
(8, 'shereen899', '5e0b928326485b5c2eb9c226503ef014763b7c6d', 'shery@hotmail.com', 'Shereen saber', 0, 1, '2018-01-30', 'emptyuser.png'),
(9, 'shereen', '7a0b02095c59f1024aec42df9c2ec45d266dae92', 'shereen89@rr.co', 'shereen fahmy', 0, 1, '2018-01-30', 'emptyuser.png'),
(10, 'nada88', '676a9bd3d8c2d69e8c6c389ed94c0cfa9f1a507d', 'nada@gmail.com', 'Nada Nasr Hammad', 0, 1, '2018-02-01', 'emptyuser.png'),
(13, 'esraa', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'esraa_said@yahoo.com', 'Esraa Said', 0, 1, '2018-02-16', 'emptyuser.png'),
(14, 'nashwa23', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'nada@gmail.com', 'Nashwa Ismail', 0, 1, '2018-02-20', '690704_28055799_1605419686201858_6063472031366213248_n.jpg'),
(15, 'hosam', 'fc3707fa908df1e82e30ecbdae3d094804a8f87d', 'hosammohamed25@gmail.com', 'Hosam Mohamed', 0, 1, '2018-02-20', '634504_27655491_1937922806218336_3557966011816322127_n.jpg'),
(16, 'shref2', '754d5106c83598d11b1ddc8247264b5f70a54e2a', 'shrefdelsheikh@gmail.com', 'shref mohamed elsheikh', 0, 1, '2018-03-01', '182561_IMG_6503.jpg'),
(17, 'Ahmed98', '7e04a8d2461f4ec051972d09a16b24db603d5237', 'ahmednasr2589@gmail.com', 'Ahmed Nasri', 1, 1, '2018-03-05', '534951_team-bw-1.jpg'),
(18, 'Hambozo_1', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'hambozo88@gmail.com', 'Hassan Mohamed', 1, 1, '2018-03-05', 'emptyuser.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`coment_id`),
  ADD KEY `ITEM33` (`item_id`),
  ADD KEY `USER96` (`user_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `USER1` (`member_ID`),
  ADD KEY `CAT47` (`category_ID`);

--
-- Indexes for table `paid_items`
--
ALTER TABLE `paid_items`
  ADD PRIMARY KEY (`payID`),
  ADD KEY `c_id` (`customer_id`),
  ADD KEY `owner` (`owner_id`),
  ADD KEY `item` (`itemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `usernname` (`usernname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `coment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `paid_items`
--
ALTER TABLE `paid_items`
  MODIFY `payID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'opreation Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `ITEM33` FOREIGN KEY (`item_id`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `USER96` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `CAT47` FOREIGN KEY (`category_ID`) REFERENCES `category` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `USER1` FOREIGN KEY (`member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paid_items`
--
ALTER TABLE `paid_items`
  ADD CONSTRAINT `c_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `item` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`userID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
