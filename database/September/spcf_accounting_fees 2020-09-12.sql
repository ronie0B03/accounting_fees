-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2020 at 12:41 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spcf_accounting_fees`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL DEFAULT 'SPCF',
  `username` varchar(256) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `full_name`, `username`, `password`, `role`) VALUES
(1, 'SPCF Admin', 'admin', 'admin', 'admin'),
(2, 'Ronie Bituin', 'ronie', 'ronie', 'admin'),
(3, 'Happie Bustamente', 'happie', 'happie', 'admin'),
(4, 'SPCF Cashier 1', 'cashier1', 'cashier1', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_code` varchar(128) NOT NULL,
  `item_name` varchar(256) NOT NULL,
  `qty` int(12) NOT NULL,
  `threshold` int(11) NOT NULL DEFAULT 4,
  `item_description` text NOT NULL,
  `item_price` decimal(12,2) NOT NULL,
  `market_original_price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_code`, `item_name`, `qty`, `threshold`, `item_description`, `item_price`, `market_original_price`) VALUES
(1, 'id_laces', 'SPCF ID LACES', 10, 4, 'Includes ID Holder and ID Lanyard', '100.00', '10.00'),
(4, 'eng_book_1', 'Book English 1', 93, 4, 'Book for English Elementary 1', '600.00', '500.00'),
(5, 'MTA Cert', 'MTA Certification Voicher', 161, 4, 'MTA Voucher for CCIS', '700.00', '500.00'),
(6, '011', 'Oven', 103, 20, 'Oven Basta yun haha', '120.00', '100.00'),
(7, 'Tinape hehehe', 'Tinapay', 20, 5, 'Tinapay hehe', '500.00', '100.00'),
(8, 'MacBook', 'MacBook', 9, 5, 'MacBook for the win', '130000.00', '120000.00');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_cost`
--

CREATE TABLE `inventory_cost` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `total_cost` int(12) NOT NULL,
  `date_added` date NOT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_cost`
--

INSERT INTO `inventory_cost` (`id`, `item_id`, `total_cost`, `date_added`, `supplier_id`) VALUES
(8, 1, 500, '2020-08-20', 0),
(12, 1, 30, '2020-08-30', 0),
(15, 1, 7000, '2020-09-10', 0),
(16, 4, 5000, '2020-09-10', 0),
(17, 5, 125000, '2020-09-10', 0),
(19, 6, 2000, '2020-09-11', 1),
(20, 1, 1000, '2020-09-12', NULL),
(23, 7, 1000, '2020-09-12', 1),
(24, 1, 10, '2020-09-12', NULL),
(25, 8, 10000000, '2020-09-12', 2),
(26, 8, 130000, '2020-09-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issue_receipt`
--

CREATE TABLE `issue_receipt` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `issue_date` datetime NOT NULL DEFAULT current_timestamp(),
  `account_cashier` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issue_receipt`
--

INSERT INTO `issue_receipt` (`id`, `transaction_id`, `issue_date`, `account_cashier`) VALUES
(1, 17, '2020-09-12 09:11:26', 'Ronie Bituin'),
(2, 19, '2020-09-12 09:59:16', 'Ronie Bituin'),
(3, 20, '2020-09-12 11:55:26', 'Ronie Bituin'),
(4, 21, '2020-09-12 11:56:45', 'Ronie Bituin'),
(5, 26, '2020-09-12 18:34:42', 'SPCF Cashier 1');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `log_type` varchar(128) NOT NULL,
  `log_date` datetime NOT NULL DEFAULT current_timestamp(),
  `account_cashier` varchar(128) DEFAULT NULL,
  `context` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `log_type`, `log_date`, `account_cashier`, `context`) VALUES
(2, 'Inventory - Add', '2020-09-12 18:09:15', 'SPCF Admin', 'Add Inventory ID:7, code: Tinape hehehe, name: Tinapay, qty: 20, price: 500, marketPrice: 100, totalCost: 1000'),
(3, 'Inventory - Update Stock', '2020-09-12 18:12:50', 'SPCF Admin', 'Add Inventory ID:1, code: , newStock: , marketPrice: 10, cost: 10'),
(4, 'Inventory - Add', '2020-09-12 18:14:52', 'Ronie Bituin', 'Add Inventory ID:8, code: MacBook, name: MacBook, qty: 10, price: 130000, marketPrice: 120000, totalCost: 10000000'),
(5, 'Inventory - Update Stock', '2020-09-12 18:16:10', 'SPCF Cashier 1', 'Update Stock ID:8, code: , newStock: , marketPrice: 120000, totalCost: 130000'),
(6, 'Transaction - Add Item', '2020-09-12 18:21:04', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:26, item_id: 8, transaction_date: 2020-09-12 18:21:04, subTotal: 130000'),
(7, 'Transaction - Finish Order', '2020-09-12 18:24:46', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:26, full_name: Juan Cruz, transaction_date: 2020-09-12 18:24:46, total: 260000, amount_paid: 260000'),
(8, 'Transaction - Initiate Order', '2020-09-12 18:29:51', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:27, Student ID: -1, full_name: James LoL, transaction_date: 2020-09-12 18:29:51'),
(9, 'Transaction - Initiate Order', '2020-09-12 18:30:32', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:28, Student ID: 0001, full_name: Ronie Bituin, transaction_date: 2020-09-12 18:30:32'),
(10, 'Transaction - Generate Receipt', '2020-09-12 18:34:42', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:26'),
(11, 'Transaction - Void Item In Order', '2020-09-12 18:39:32', 'SPCF Admin', 'Void Item In Order. Transaction ID:11 Item ID:6');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `student_id` varchar(128) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `level` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `full_name`, `level`) VALUES
(1, '0001', 'Ronie Bituin', '1st Year College'),
(2, '0002', 'Sin Naidas', '2nd year College');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(128) NOT NULL,
  `contact_no` varchar(128) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `other_info` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `contact_no`, `email_address`, `other_info`) VALUES
(1, 'Angelina Bakeryyyyy', '898989898998', 'accounting@spcf.edu.ph', 'This is only a sample'),
(2, 'SPCF-InHouse', '00000', 'accounting@spcf.edu.ph', 'SPCF In House Supply');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `student_id` varchar(128) NOT NULL DEFAULT '0',
  `full_name` varchar(256) DEFAULT NULL,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(256) DEFAULT NULL,
  `phone_num` varchar(256) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(12,2) DEFAULT 0.00,
  `amount_change` decimal(12,4) NOT NULL DEFAULT 0.0000,
  `cashier_account` varchar(128) DEFAULT NULL,
  `status_transact` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `student_id`, `full_name`, `transaction_date`, `address`, `phone_num`, `total_amount`, `amount_paid`, `amount_change`, `cashier_account`, `status_transact`) VALUES
(1, '00012', 'Juan Cruz', '2020-08-31 00:00:00', NULL, NULL, '144.00', '12.00', '0.0000', 'Ronie Bituin', 0),
(2, '000111', 'Juan Cruz', '2020-09-10 00:00:00', NULL, NULL, '700.00', '700.00', '0.0000', 'Ronie Bituin', 1),
(3, '000', 'Juan 5656 g', '2020-09-10 00:00:00', NULL, NULL, '65900.00', '65900.00', '0.0000', 'Ronie Bituin', 0),
(7, '0001', 'Ronie Bituin', '2020-09-11 00:00:00', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(8, '0001', 'Ronie Bituin', '2020-09-11 00:00:00', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(9, '0001', 'Ronie Bituin', '2020-09-11 00:00:00', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(10, '0001', 'Ronie Bituin', '2020-09-11 00:00:00', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(11, '0002', 'Sin Naidas', '2020-09-11 00:00:00', NULL, NULL, '1060.00', '1060.00', '0.0000', 'Ronie Bituin', 0),
(16, '-1', 'SAmple', '2020-09-12 00:00:00', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(17, '-1', 'Matthew', '2020-09-12 08:56:34', NULL, NULL, '6000.00', '6000.00', '0.0000', 'Ronie Bituin', 1),
(18, '0001', 'Ronie Bituin', '2020-09-12 09:53:22', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(19, '-1', 'Roy', '2020-09-12 09:53:44', NULL, NULL, '700.00', '1000.00', '300.0000', 'Ronie Bituin', 1),
(20, '0001', 'Ronie Bituin', '2020-09-12 11:55:16', NULL, NULL, '400.00', '400.00', '0.0000', 'Ronie Bituin', 1),
(21, '-1', 'asdasd', '2020-09-12 11:56:34', NULL, NULL, '1000.00', '1000.00', '0.0000', 'Ronie Bituin', 1),
(22, '-1', 'sample', '2020-09-12 12:02:50', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(23, '-1', 'Matthew', '2020-09-12 13:38:53', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(24, '0001', 'Ronie Bituin', '2020-09-12 15:14:13', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Cashier 1', 0),
(25, '-1', 'asdasdasd', '2020-09-12 15:14:28', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Cashier 1', 0),
(26, '-1', 'Juan Cruz', '2020-09-12 18:20:26', NULL, NULL, '260000.00', '260000.00', '0.0000', 'SPCF Cashier 1', 1),
(27, '-1', 'James LoL', '2020-09-12 18:29:51', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Cashier 1', 0),
(28, '0001', 'Ronie Bituin', '2020-09-12 18:30:32', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Cashier 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_lists`
--

CREATE TABLE `transaction_lists` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(12) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `void` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_lists`
--

INSERT INTO `transaction_lists` (`id`, `transaction_id`, `item_id`, `qty`, `price`, `transaction_date`, `subtotal`, `void`) VALUES
(57, 1, 1, 12, '12.00', '2020-08-31 00:00:00', '144.00', 0),
(58, 2, 4, 1, '600.00', '2020-09-10 00:00:00', '600.00', 0),
(59, 2, 1, 1, '100.00', '2020-09-10 00:00:00', '100.00', 0),
(60, 3, 4, 6, '600.00', '2020-09-10 00:00:00', '3600.00', 0),
(61, 3, 5, 89, '700.00', '2020-09-10 00:00:00', '62300.00', 0),
(64, 11, 1, 1, '100.00', '2020-09-11 00:00:00', '100.00', 1),
(65, 11, 4, 1, '600.00', '2020-09-11 00:00:00', '600.00', 0),
(66, 11, 6, 3, '120.00', '2020-09-11 00:00:00', '360.00', 1),
(68, 15, 1, 1, '100.00', '2020-09-12 00:00:00', '100.00', 0),
(69, 17, 4, 10, '600.00', '2020-09-12 08:57:01', '6000.00', 0),
(70, 19, 1, 7, '100.00', '2020-09-12 09:53:58', '700.00', 0),
(71, 20, 1, 4, '100.00', '2020-09-12 11:55:21', '400.00', 0),
(72, 21, 1, 10, '100.00', '2020-09-12 11:56:42', '1000.00', 0),
(73, 23, 1, 5, '100.00', '2020-09-12 13:39:03', '500.00', 1),
(74, 23, 1, 10, '100.00', '2020-09-12 13:56:13', '1000.00', 1),
(75, 26, 8, 1, '130000.00', '2020-09-12 18:20:31', '130000.00', 0),
(76, 26, 8, 1, '130000.00', '2020-09-12 18:21:04', '130000.00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_cost`
--
ALTER TABLE `inventory_cost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `issue_receipt`
--
ALTER TABLE `issue_receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory_cost`
--
ALTER TABLE `inventory_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `issue_receipt`
--
ALTER TABLE `issue_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_cost`
--
ALTER TABLE `inventory_cost`
  ADD CONSTRAINT `inventory_cost_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  ADD CONSTRAINT `transaction_lists_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
