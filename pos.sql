-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 06:52 AM
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
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_phone`) VALUES
(1, 'Junard Ahong Cares', 'ahongchan@gmail.com', '638952985556'),
(2, 'd4vd', 'pedo@gmail.com', '639977882530'),
(3, 'Alice Guo', 'chinesespy@gmail.com', '12306829904'),
(4, 'Ellis Co', 'corrupttatayko@yahoo.com', '999888323'),
(5, 'Zaldy Co', 'corruptako@yahoo.com', '651415461'),
(7, 'BongBong Marcos', 'bongbongmarcos@gmail.com', '123467289'),
(8, 'Tyler Diddyeon', 'tylerthegreat@gmail.com', '2314613434');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_quantity`) VALUES
(2, 'Buldak Noodles', 85.00, 46),
(3, 'Labubu', 1000.00, 10),
(4, 'Sports Car', 1100100.00, 5),
(5, 'Apple', 13.00, 200),
(6, 'Sardinas', 25.00, 100),
(8, 'Tinowa', 30.00, 67);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `customer_id`, `sale_date`, `total_amount`) VALUES
(1, 2, '2025-10-01 21:21:14', 1085.00),
(2, 1, '2025-10-01 21:21:36', 119.00),
(3, 4, '2025-10-01 21:26:20', 1105100.00),
(4, 1, '2025-10-01 21:26:48', 1510.00),
(5, 8, '2025-10-02 06:28:59', 5500500.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `price_at_sale` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`sale_item_id`, `sale_id`, `product_id`, `quantity_sold`, `price_at_sale`) VALUES
(1, 1, 3, 1, 1000.00),
(2, 1, 2, 1, 85.00),
(3, 2, 1, 2, 17.00),
(4, 2, 2, 1, 85.00),
(5, 3, 4, 1, 1100100.00),
(6, 3, 3, 5, 1000.00),
(7, 4, 5, 90, 13.00),
(8, 4, 2, 2, 85.00),
(9, 4, 1, 10, 17.00),
(10, 5, 4, 2, 1100100.00),
(11, 5, 4, 3, 1100100.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`sale_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
