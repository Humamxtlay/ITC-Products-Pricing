-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2022 at 07:08 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sanjeevpandit23_itc`
--

-- --------------------------------------------------------

--
-- Table structure for table `chart_data`
--

CREATE TABLE `chart_data` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chart_data`
--

INSERT INTO `chart_data` (`id`, `product_id`, `store_id`, `price`, `date`) VALUES
(140524, 96, 1, '105', '2022-02-13 18:04:16'),
(140525, 97, 2, '', '2022-02-13 18:06:01'),
(140526, 97, 3, '392', '2022-02-13 18:06:03'),
(140527, 97, 4, '', '2022-02-13 18:06:05'),
(140528, 98, 2, '', '2022-02-13 18:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amazon` varchar(400) NOT NULL,
  `flipkart` varchar(400) NOT NULL,
  `bigbasket` varchar(400) NOT NULL,
  `grofers` varchar(400) NOT NULL,
  `amazonPrice` varchar(255) NOT NULL,
  `flipkartPrice` varchar(255) NOT NULL,
  `bigbasketPrice` varchar(255) NOT NULL,
  `grofersPrice` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `amazon`, `flipkart`, `bigbasket`, `grofers`, `amazonPrice`, `flipkartPrice`, `bigbasketPrice`, `grofersPrice`, `price`, `date`) VALUES
(96, 'Vedaka Premium Chana Dal, 1 kg', 'https://www.amazon.in/gp/product/B07BL6DHMQ/ref=pd_alm_fs_merch_1_2_fs_dsk_mrk_mw_img_bbsvd?fpw=alm&almBrandId=ctnow&pf_rd_r=N4XQXMV9PHAZ3B3N27J7&pf_rd_p=bcde6bd5-19bd-4a80-8504-a63f3420526f', '', '', '', '105', '', '', '', 104, '2022-02-13 18:04:16'),
(97, 'AASHIRVAAD Superior MP Atta  (10 kg)', '', 'https://www.flipkart.com/aashirvaad-superior-mp-atta/p/itm2138546a91477?pid=FLREUC5PJYTYFBE2&lid=LSTFLREUC5PJYTYFBE2LHWMMN&marketplace=GROCERY&spotlightTagId=BestsellerId_eat%2Fe6o&srno=s_1_1&otracker=search&otracker1=search&fm=SEARCH&iid=67fbee5c-922c-41d2-b28c-86218216caaa.FLREUC5PJYTYFBE2.SEARCH&ppt=sp&ppn=sp&ssid=b15koyggzk0000001604128949167&qH=6b71450e763913f7', 'https://www.bigbasket.com/pd/126906/aashirvaad-atta-whole-wheat-10-kg-pouch/?nc=cl-prod-list&t_pg=&t_p=&t_s=cl-prod-list&t_pos=1&t_ch=desktop', 'https://grofers.com/prn/aashirvaad-shudh-chakki-whole-wheat-atta/prid/333324', '', '', '392', '', 200, '2022-02-13 18:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `password`, `email`, `phone`, `role`) VALUES
(3, 'humam', '$2y$10$MEnM2inFuaYms.ee2f76h.YKtdXf5Uv/trjbTcUDrUPr76huAAc7a', 'ho7711181@gmail.com', '0932432508', 1),
(9, 'Demo', '$2y$10$/OP1d9o1BlbHwj2eWjQuXuvZoOEUCW5foJctOTlrrV42NhN7Z..TG', 'Demo@gmail.com', '0123456789', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chart_data`
--
ALTER TABLE `chart_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chart_data`
--
ALTER TABLE `chart_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140529;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
