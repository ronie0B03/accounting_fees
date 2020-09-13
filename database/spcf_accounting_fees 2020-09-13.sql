-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2020 at 01:37 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(1, 'id_laces', 'SPCF ID LACES', 5, 4, 'Includes ID Holder and ID Lanyard', '100.00', '10.00'),
(4, 'eng_book_1', 'Book English 1', 91, 4, 'Book for English Elementary 1', '600.00', '500.00'),
(5, 'MTA Cert', 'MTA Certification Voicher', -339, 4, 'MTA Voucher for CCIS', '700.00', '500.00'),
(6, '011', 'Oven', 103, 20, 'Oven Basta yun haha', '120.00', '100.00'),
(7, 'Tinape hehehe', 'Tinapay', 5, 5, 'Tinapay hehe', '500.00', '100.00'),
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
(1, 1, '2020-09-13 09:54:09', 'SPCF Cashier 1'),
(2, 2, '2020-09-13 09:54:43', 'SPCF Cashier 1'),
(3, 2, '2020-09-13 15:44:43', 'Ronie Bituin'),
(4, 1, '2020-09-13 16:00:54', 'SPCF Cashier 1'),
(5, 3, '2020-09-13 19:18:32', 'Ronie Bituin');

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
(1, 'Transaction - Initiate Order', '2020-09-13 09:53:45', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:1, Student ID: -1, full_name: Roy Dayrit, transaction_date: 2020-09-13 09:53:45'),
(2, 'Transaction - Add Item', '2020-09-13 09:53:58', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:1, item_id: 5, transaction_date: 2020-09-13 09:53:58, subTotal: 350000'),
(3, 'Transaction - Finish Order', '2020-09-13 09:54:07', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:1, full_name: Roy Dayrit, transaction_date: 2020-09-13 09:54:07, total: 350000, amount_paid: 350000'),
(4, 'Transaction - Generate Receipt', '2020-09-13 09:54:09', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:1'),
(5, 'Transaction - Initiate Order', '2020-09-13 09:54:30', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:2, Student ID: 0001, full_name: Ronie Bituin, transaction_date: 2020-09-13 09:54:30'),
(6, 'Transaction - Add Item', '2020-09-13 09:54:40', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:2, item_id: 7, transaction_date: 2020-09-13 09:54:40, subTotal: 2500'),
(7, 'Transaction - Finish Order', '2020-09-13 09:54:41', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:2, full_name: Ronie Bituin, transaction_date: 2020-09-13 09:54:41, total: 2500, amount_paid: 2500'),
(8, 'Transaction - Generate Receipt', '2020-09-13 09:54:43', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:2'),
(9, 'Transaction - Generate Receipt', '2020-09-13 15:44:43', 'Ronie Bituin', 'Generate Receipt. Transaction ID:2'),
(10, 'Transaction - Generate Receipt', '2020-09-13 16:00:54', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:1'),
(11, 'Transaction - Initiate Order', '2020-09-13 19:18:10', 'Ronie Bituin', 'Initiate Order. Transaction ID:3, Student ID: 0002, full_name: Sin Naidas, transaction_date: 2020-09-13 19:18:10'),
(12, 'Transaction - Add Item', '2020-09-13 19:18:29', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:3, item_id: 7, transaction_date: 2020-09-13 19:18:29, subTotal: 5000'),
(13, 'Transaction - Finish Order', '2020-09-13 19:18:31', 'Ronie Bituin', 'Transaction - Finish Order. Transaction ID:3, full_name: Sin Naidas, transaction_date: 2020-09-13 19:18:31, total: 5000, amount_paid: 5000'),
(14, 'Transaction - Generate Receipt', '2020-09-13 19:18:32', 'Ronie Bituin', 'Generate Receipt. Transaction ID:3'),
(15, 'Transaction - Initiate Order', '2020-09-13 19:32:48', 'SPCF Admin', 'Initiate Order. Transaction ID:4, Student ID: -1, full_name: Reynald, transaction_date: 2020-09-13 19:32:48'),
(16, 'Transaction - Add Item', '2020-09-13 19:32:52', 'SPCF Admin', 'Transaction - Add Item. Transaction ID:4, item_id: 4, transaction_date: 2020-09-13 19:32:52, subTotal: 1200'),
(17, 'Transaction - Finish Order', '2020-09-13 19:32:54', 'SPCF Admin', 'Transaction - Finish Order. Transaction ID:4, full_name: Reynald, transaction_date: 2020-09-13 19:32:54, total: 1200, amount_paid: 1200'),
(18, 'Transaction - Initiate Order', '2020-09-13 19:33:06', 'SPCF Admin', 'Initiate Order. Transaction ID:5, Student ID: -1, full_name: Matthew, transaction_date: 2020-09-13 19:33:06'),
(19, 'Transaction - Add Item', '2020-09-13 19:33:10', 'SPCF Admin', 'Transaction - Add Item. Transaction ID:5, item_id: 1, transaction_date: 2020-09-13 19:33:10, subTotal: 500'),
(20, 'Transaction - Finish Order', '2020-09-13 19:33:14', 'SPCF Admin', 'Transaction - Finish Order. Transaction ID:5, full_name: Matthew, transaction_date: 2020-09-13 19:33:14, total: 500, amount_paid: 500');

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
(1, '-1', 'Roy Dayrit', '2020-08-13 09:53:45', NULL, NULL, '8000.00', '8000.00', '0.0000', 'SPCF Cashier 1', 1),
(2, '0001', 'Ronie Bituin', '2020-09-13 09:54:30', NULL, NULL, '2500.00', '2500.00', '0.0000', 'SPCF Cashier 1', 1),
(3, '0002', 'Sin Naidas', '2020-09-13 19:18:10', NULL, NULL, '5000.00', '5000.00', '0.0000', 'Ronie Bituin', 1),
(4, '-1', 'Reynald', '2020-09-13 19:32:48', NULL, NULL, '1200.00', '1200.00', '0.0000', 'SPCF Admin', 1),
(5, '-1', 'Matthew', '2020-09-13 19:33:06', NULL, NULL, '500.00', '500.00', '0.0000', 'SPCF Admin', 1);

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
(1, 1, 5, 500, '700.00', '2020-09-13 09:53:58', '8000.00', 0),
(2, 2, 7, 5, '500.00', '2020-09-13 09:54:40', '2500.00', 0),
(3, 3, 7, 10, '500.00', '2020-09-13 19:18:29', '5000.00', 0),
(4, 4, 4, 2, '600.00', '2020-09-13 19:32:52', '1200.00', 0),
(5, 5, 1, 5, '100.00', '2020-09-13 19:33:10', '500.00', 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

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
  ADD KEY `item_id` (`item_id`),
  ADD KEY `transaction_id` (`transaction_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_cost`
--
ALTER TABLE `inventory_cost`
  ADD CONSTRAINT `inventory_cost_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issue_receipt`
--
ALTER TABLE `issue_receipt`
  ADD CONSTRAINT `issue_receipt_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  ADD CONSTRAINT `transaction_lists_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_lists_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
