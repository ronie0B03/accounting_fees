-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2020 at 12:46 PM
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
(4, 'SPCF Cashier 1', 'cashier1', 'cashier1', 'user'),
(5, 'SPCF Cashier 2', 'cashier2', 'cashier2', 'user');

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
(1, 'id_laces', 'SPCF ID LACES', -3, 4, 'Includes ID Holder and ID Lanyard', '100.00', '10.00'),
(4, 'eng_book_1', 'Book English 1', 81, 4, 'Book for English Elementary 1', '600.00', '500.00'),
(5, 'MTA Cert', 'MTA Certification Voicher', -340, 4, 'MTA Voucher for CCIS', '700.00', '500.00'),
(6, '011', 'Oven', 101, 20, 'Oven Basta yun haha', '120.00', '100.00'),
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
(5, 3, '2020-09-13 19:18:32', 'Ronie Bituin'),
(6, 6, '2020-09-17 14:48:31', 'SPCF Cashier 1'),
(7, 6, '2020-09-17 14:48:41', 'SPCF Cashier 1'),
(8, 6, '2020-09-17 15:05:59', 'SPCF Cashier 1'),
(9, 6, '2020-09-17 15:08:02', 'SPCF Admin'),
(10, 1, '2020-09-22 10:57:50', 'Ronie Bituin'),
(11, 8, '2020-09-26 17:47:03', 'Ronie Bituin'),
(12, 6, '2020-09-26 20:53:28', 'SPCF Admin'),
(14, 14, '2020-09-27 09:53:41', 'SPCF Cashier 1');

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
(20, 'Transaction - Finish Order', '2020-09-13 19:33:14', 'SPCF Admin', 'Transaction - Finish Order. Transaction ID:5, full_name: Matthew, transaction_date: 2020-09-13 19:33:14, total: 500, amount_paid: 500'),
(21, 'Transaction - Initiate Order', '2020-09-17 14:39:40', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:6, Student ID: -1, full_name: Marvin Reyes, transaction_date: 2020-09-17 14:39:40'),
(22, 'Transaction - Add Item', '2020-09-17 14:40:21', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:6, item_id: 1, transaction_date: 2020-09-17 14:40:21, subTotal: 100'),
(23, 'Transaction - Add Item', '2020-09-17 14:40:47', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:6, item_id: 4, transaction_date: 2020-09-17 14:40:47, subTotal: 3000'),
(24, 'Transaction - Void Item In Order', '2020-09-17 14:43:01', 'SPCF Admin', 'Void Item In Order. Transaction ID:6 Item ID:1'),
(25, 'Transaction - Finish Order', '2020-09-17 14:47:57', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:6, full_name: Marvin Reyes, transaction_date: 2020-09-17 14:47:57, total: 3000, amount_paid: 3000'),
(26, 'Transaction - Generate Receipt', '2020-09-17 14:48:31', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:6'),
(27, 'Transaction - Generate Receipt', '2020-09-17 14:48:41', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:6'),
(28, 'Transaction - Generate Receipt', '2020-09-17 15:05:59', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:6'),
(29, 'Transaction - Generate Receipt', '2020-09-17 15:08:02', 'SPCF Admin', 'Generate Receipt. Transaction ID:6'),
(30, 'Transaction - Generate Receipt', '2020-09-22 10:57:50', 'Ronie Bituin', 'Generate Receipt. Transaction ID:1'),
(31, 'Transaction - Initiate Order', '2020-09-26 17:20:26', 'Ronie Bituin', 'Initiate Order. Transaction ID:7, Student ID: -1, full_name: Matthew, transaction_date: 2020-09-26 17:20:26'),
(32, 'Transaction - Add Item', '2020-09-26 17:20:37', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:7, item_id: 5, transaction_date: 2020-09-26 17:20:37, subTotal: 700'),
(33, 'Transaction - Add Item', '2020-09-26 17:28:54', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:7, item_id: 4, transaction_date: 2020-09-26 17:28:54, subTotal: 1200'),
(34, 'Transaction - Void Item In Order', '2020-09-26 17:29:01', 'SPCF Admin', 'Void Item In Order. Transaction ID:7 Item ID:5'),
(35, 'Transaction - Finish Order', '2020-09-26 17:29:13', 'Ronie Bituin', 'Transaction - Finish Order. Transaction ID:7, full_name: Matthew, transaction_date: 2020-09-26 17:29:13, total: 1200, amount_paid: 1200'),
(36, 'Transaction - Initiate Order', '2020-09-26 17:43:26', 'Ronie Bituin', 'Initiate Order. Transaction ID:8, Student ID: -1, full_name: Ronie Bituin, transaction_date: 2020-09-26 17:43:26'),
(37, 'Transaction - Add Item', '2020-09-26 17:43:32', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:8, item_id: 1, transaction_date: 2020-09-26 17:43:32, subTotal: 300'),
(38, 'Transaction - Add Item', '2020-09-26 17:44:43', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:8, item_id: 8, transaction_date: 2020-09-26 17:44:43, subTotal: 1560000'),
(39, 'Transaction - Void Item In Order', '2020-09-26 17:44:54', 'SPCF Admin', 'Void Item In Order. Transaction ID:8 Item ID:8'),
(40, 'Transaction - Finish Order', '2020-09-26 17:45:00', 'Ronie Bituin', 'Transaction - Finish Order. Transaction ID:8, full_name: Ronie Bituin, transaction_date: 2020-09-26 17:45:00, total: 300, amount_paid: 300'),
(41, 'Transaction - Generate Receipt', '2020-09-26 17:47:03', 'Ronie Bituin', 'Generate Receipt. Transaction ID:8'),
(42, 'Transaction - Initiate Order', '2020-09-26 17:56:59', 'Ronie Bituin', 'Initiate Order. Transaction ID:9, Student ID: -1, full_name: SPCF, transaction_date: 2020-09-26 17:56:59'),
(43, 'Transaction - Add Item', '2020-09-26 17:57:05', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:9, item_id: 6, transaction_date: 2020-09-26 17:57:05, subTotal: 120'),
(44, 'Transaction - Void Item In Order', '2020-09-26 18:29:17', 'SPCF Admin', 'Void Item In Order. Transaction ID:9 Item ID:6 Item Name: Oven Price: 120.00 Sub Total: 120.00'),
(45, 'Transaction - Initiate Order', '2020-09-26 20:37:22', 'SPCF Admin', 'Initiate Order. Transaction ID:10, Student ID: -1, full_name: sample, transaction_date: 2020-09-26 20:37:22'),
(46, 'Transaction - Initiate Order', '2020-09-26 20:38:27', 'Ronie Bituin', 'Initiate Order. Transaction ID:11, Student ID: 0001, full_name: Ronie Bituin, transaction_date: 2020-09-26 20:38:27'),
(47, 'Transaction - Generate Receipt', '2020-09-26 20:53:28', 'SPCF Admin', 'Generate Receipt. Transaction ID:6'),
(48, 'Transaction - Initiate Order', '2020-09-26 21:13:14', 'SPCF Admin', 'Initiate Order. Transaction ID:12, Student ID: -1, full_name: Dummy Cancel Transaction, transaction_date: 2020-09-26 21:13:14'),
(49, 'Transaction - Add Item', '2020-09-26 21:13:18', 'SPCF Admin', 'Transaction - Add Item. Transaction ID:12, item_id: 1, transaction_date: 2020-09-26 21:13:18, subTotal: 500'),
(50, 'Transaction - Add Item', '2020-09-26 21:13:23', 'SPCF Admin', 'Transaction - Add Item. Transaction ID:12, item_id: 6, transaction_date: 2020-09-26 21:13:23, subTotal: 240'),
(51, 'Transaction - Finish Order', '2020-09-26 21:14:28', 'SPCF Admin', 'Transaction - Finish Order. Transaction ID:12, full_name: Dummy Cancel Transaction, transaction_date: 2020-09-26 21:14:28, total: 740, amount_paid: 740'),
(52, 'Transaction - Generate Receipt', '2020-09-26 21:14:29', 'SPCF Admin', 'Generate Receipt. Transaction ID:12'),
(53, 'Transaction - Cancel Transaction', '2020-09-27 09:35:08', 'SPCF Admin', 'Transaction - Cancel Transaction. Transaction ID:12 Student ID:-1 Full Name: Dummy Cancel Transaction Total Returned Amount: -740'),
(54, 'Transaction - Initiate Order', '2020-09-27 09:38:38', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:13, Student ID: -1, full_name: Dummy Transaction, transaction_date: 2020-09-27 09:38:38'),
(55, 'Transaction - Add Item', '2020-09-27 09:38:43', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:13, item_id: 1, transaction_date: 2020-09-27 09:38:43, subTotal: 200'),
(56, 'Transaction - Add Item', '2020-09-27 09:38:46', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:13, item_id: 4, transaction_date: 2020-09-27 09:38:46, subTotal: 1200'),
(57, 'Transaction - Finish Order', '2020-09-27 09:38:48', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:13, full_name: Dummy Transaction, transaction_date: 2020-09-27 09:38:48, total: 1400, amount_paid: 1400'),
(58, 'Transaction - Cancel Transaction', '2020-09-27 09:40:12', 'SPCF Admin', 'Transaction - Cancel Transaction. Transaction ID:13 Student ID:-1 Full Name: Dummy Transaction Total Returned Amount: -1400'),
(59, 'Transaction - Cancel Transaction', '2020-09-27 09:43:14', 'SPCF Admin', 'Transaction - Cancel Transaction. Transaction ID:13 Student ID:-1 Full Name: Dummy Transaction Total Returned Amount: 1400.00'),
(60, 'Transaction - Initiate Order', '2020-09-27 09:53:02', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:14, Student ID: -1, full_name: Dummy Transaction 2, transaction_date: 2020-09-27 09:53:02'),
(61, 'Transaction - Add Item', '2020-09-27 09:53:08', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:14, item_id: 4, transaction_date: 2020-09-27 09:53:08, subTotal: 1200'),
(62, 'Transaction - Add Item', '2020-09-27 09:53:22', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:14, item_id: 7, transaction_date: 2020-09-27 09:53:22, subTotal: 2500'),
(63, 'Transaction - Finish Order', '2020-09-27 09:53:25', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:14, full_name: Dummy Transaction 2, transaction_date: 2020-09-27 09:53:25, total: 3700, amount_paid: 3700'),
(64, 'Transaction - Generate Receipt', '2020-09-27 09:53:41', 'SPCF Cashier 1', 'Generate Receipt. Transaction ID:14'),
(65, 'Transaction - Cancel Transaction', '2020-09-27 09:54:09', 'SPCF Admin', 'Transaction - Cancel Transaction. Transaction ID:14 Student ID:-1 Full Name: Dummy Transaction 2 Total Amount Returned: ?3700.00'),
(66, 'Transaction - Initiate Order', '2020-09-27 10:01:57', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:15, Student ID: -1, Full Name: 001, Transaction Date: 2020-09-27 10:01:57'),
(67, 'Transaction - Add Item', '2020-09-27 10:02:04', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:15, Item ID: 5, Transaction Date: 2020-09-27 10:02:04, Subtotal: ?35000'),
(68, 'Transaction - Finish Order', '2020-09-27 10:02:09', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:15, Full Name: 001, Transaction Date: 2020-09-27 10:02:09, Total: ?35000, Amount Paid: ?35000'),
(69, 'Transaction - Cancel Transaction', '2020-09-27 15:45:16', 'SPCF Admin', 'Transaction - Cancel Transaction. Transaction ID:15 Student ID:-1 Full Name: 001 Total Amount Returned: ?35000.00'),
(70, 'Transaction - Initiate Order', '2020-09-27 16:31:46', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:16, Student ID: 160086345345, full_name: Gabriel, Princess Rona M., transaction_date: 2020-09-27 16:31:46'),
(71, 'Transaction - Add Item', '2020-09-27 16:31:52', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:16, Item ID: 4, Transaction Date: 2020-09-27 16:31:52, Subtotal: ?600'),
(72, 'Transaction - Finish Order', '2020-09-27 16:31:54', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:16, Full Name: Gabriel, Princess Rona M., Transaction Date: 2020-09-27 16:31:54, Total: ?600, Amount Paid: ?600'),
(73, 'Transaction - Initiate Order', '2020-09-27 16:32:19', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:17, Student ID: 0003, full_name: Roy Dayrit, transaction_date: 2020-09-27 16:32:19'),
(74, 'Transaction - Add Item', '2020-09-27 16:32:26', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:17, Item ID: 4, Transaction Date: 2020-09-27 16:32:26, Subtotal: ?600'),
(75, 'Transaction - Initiate Order', '2020-09-27 16:44:58', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:18, Student ID: 160086, full_name: Gabriel, Princess Rona M., transaction_date: 2020-09-27 16:44:58'),
(76, 'Transaction - Add Item', '2020-09-27 16:45:01', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:18, Item ID: 4, Transaction Date: 2020-09-27 16:45:01, Subtotal: ?600'),
(77, 'Transaction - Initiate Order', '2020-09-27 17:24:13', 'SPCF Cashier 1', 'Initiate Order. Transaction ID:19, Student ID: 160081, full_name: Gabriel, Princess Rona M., transaction_date: 2020-09-27 17:24:13'),
(78, 'Transaction - Add Item', '2020-09-27 17:24:16', 'SPCF Cashier 1', 'Transaction - Add Item. Transaction ID:19, Item ID: 5, Transaction Date: 2020-09-27 17:24:16, Subtotal: ?700'),
(79, 'Transaction - Finish Order', '2020-09-27 17:24:19', 'SPCF Cashier 1', 'Transaction - Finish Order. Transaction ID:19, Full Name: Gabriel, Princess Rona M., Transaction Date: 2020-09-27 17:24:19, Total: ?700, Amount Paid: ?700');

-- --------------------------------------------------------

--
-- Table structure for table `payable`
--

CREATE TABLE `payable` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `department` varchar(32) NOT NULL,
  `level` varchar(12) NOT NULL,
  `school_year` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payable`
--

INSERT INTO `payable` (`id`, `item_id`, `department`, `level`, `school_year`) VALUES
(1, 4, 'ccis', '1', '2020-2021'),
(2, 5, 'ccis', '1', '2020-2021'),
(3, 5, 'ccis', '3', '2020-2021'),
(4, 5, 'ccis', '4', '2020-2021');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `student_id` varchar(128) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `level` varchar(128) NOT NULL,
  `dept` varchar(128) DEFAULT NULL,
  `school_year` varchar(128) DEFAULT NULL,
  `semester` varchar(12) DEFAULT NULL,
  `upload_id` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `full_name`, `level`, `dept`, `school_year`, `semester`, `upload_id`) VALUES
(1, '0001', 'Ronie Bituin', '1st Year College', NULL, '2020-2021', NULL, NULL),
(2, '0002', 'Sin Naidas', '2nd year College', NULL, '2020-2021', NULL, NULL),
(3, '0003', 'Roy Dayrit', '1', 'ccis', '2020-2021', 'summer', NULL),
(36124, '119301864', 'AMARGO, RHANILRIVERA', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36125, '118301894', 'AMISOLA, LYIANDE GUZMAN', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36126, '119301144', 'CARREON, ANNA MEZZY BENEDICTO', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36127, '118301785', 'DELIM, ROGELIO JR.PANAO', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36128, '119301858', 'DONES, AIRALAPORE', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36129, '118301589', 'ENFESTAN , JOHN LENARDT. ', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36130, '119301518', 'FERNANDO, PAULO', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36131, '119301523', 'JOCSON, AEDRIAN ACEV ', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36132, '119301776', 'LACAP, RONA MARIEDAVID', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36133, '118302034', 'LAMPA, ELLACALMA', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36134, '118301330', 'LOPEZ, MA. ALYSSADALUSUNG', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36135, '119301687', 'MENDOZA, SHAIRAMUNOZ', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36136, '120301066', 'OCAMPO, ERIZ ZENONBANTA', '1', 'COB', '2020-2021', '1', '1601808263586633'),
(36137, '119301661', 'QAYUM, ANDREAM', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36138, '118301844', 'QUIAMBAO, CHRISTIAN LHOWELLCUNANAN', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36139, '119302063', 'RESENK, LUCINDAFABIA', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36140, '120300375', 'RODRIGUEZ, ROSCELBAUTISTA', '1', 'COB', '2020-2021', '1', '1601808263586633'),
(36141, '118301393', 'SALAS, HANIE MAECABALLERO', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36142, '120301436', 'SALVADICO, JENELYNCASTRO', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36143, '120301437', 'SANTOS, JUSTINRIVERA', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36144, '119301607', 'SARMIENTO, KIANA RIANHENSON', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36145, '119300883', 'SMITH, ADAM PAULRUNAS', '2', 'COB', '2020-2021', '1', '1601808263586633'),
(36146, '120300575', 'SPEERS, ANDREW WAYNESABEJON', '1', 'COB', '2020-2021', '1', '1601808263586633'),
(36147, '118301430', 'TIAMZON, RYANB', '3', 'COB', '2020-2021', '1', '1601808263586633'),
(36148, '120301461', 'TICSAY, MARIZCOLLADO', '1', 'COB', '2020-2021', '1', '1601808263586633'),
(36149, '120300392', 'WIJANGCO, KELVIN MEEKOLAXAMANA', '1', 'COB', '2020-2021', '1', '1601808263586633'),
(36150, '118301040', 'ABRAZADO, PATRICKBALINGIT', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36151, '120300826', 'BACAN, DAVE JACOBANDRES', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36152, '118300874', 'BALUIS, KYRON JAYAGUSTIN', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36153, '119301862', 'BARREDO, JAYSENMARIANO', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36154, '119302130', 'BASUNBUL, AWADHABBOD', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36155, '120300889', 'BASUNBUL, SAEEDAWADH', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36156, '119301630', 'BEZA, FERNANDO JR. MENDOZA', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36157, '119301604', 'CALAYAG, RANSELL JOSEPHCARPIO', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36158, '120301558', 'CALVO, JAYNIELPAJARILLO', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36159, '118301190', 'CANASA, BARNETTRIVERA', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36160, '118301515', 'CARLOS, EVITA MARGAUXOLEDAN', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36161, '120301760', 'CEPRINO, GEMB.', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36162, '120301201', 'CLEMENTE, PRINCE CHARLESMIRANDA', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36163, '119301323', 'DAWISAN, TEE JAYESTERNON', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36164, '119301317', 'DE GUZMAN, ARON JAMESTARIMAN', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36165, '120301680', 'DE GUZMAN, MICHAEL ANGELOT. ', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36166, '119301571', 'DE JESUS , LOUIE ANDREIQUINTO', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36167, '119301005', 'DEL ROSARIO, CLEODUNGCA', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36168, '120300413', 'ESCRAMOSA, FITZGERALDB.', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36169, '118300645', 'ESTRADA, ROSALIEZ', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36170, '115300340', 'GARCIA, DELFINGONZALES', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36171, '118301060', 'GARCIA, PAULOD.', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36172, '119301662', 'GIBBS, CLEVELANDALEXANDER', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36173, '120301498', 'GINDOY, MHELWINCABUS', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36174, '118301503', 'ILUSTRISIMO, JECELBASBAS', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36175, '115300069', 'JOHNSON, JOHN ELMONANG', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36176, '118301183', 'LACSINA, RANA MAEDIZON', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36177, '119301496', 'LIM, JOSHUAGARCIA', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36178, '120301137', 'MACALINO, ALLEN JAYC. ', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36179, '120300687', 'MANALESE, REYMONDTIGLAO', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36180, '120301701', 'MANDAP, LYDONP.', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36181, '120300267', 'MANGAHAS, MERCEDES-', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36182, '118301288', 'MERCADO, RENCE LUIS REICUENCO', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36183, '118301058', 'MESA, JIM KIERLISING', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36184, '120300890', 'MOHAMMED, YUSUFSAJJAD', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36185, '120301300', 'NICOLAS, JOHN AARONDE LEON', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36186, '120301445', 'NISHIMURA, ARISAGUIBO', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36187, '120301037', 'NODA, MIKO RAPHAELSALALILA', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36188, '120300675', 'OCAMPO, GABRIEL BENNEESGUERRA', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36189, '119301274', 'PACETE, EZRA JOSHUAOTOMAN', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36190, '119300934', 'PAGOBO, CLEO CYRADAABAY', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36191, '120300773', 'PAMILAGAS, NATHANIELELCHICO', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36192, '118300958', 'PERILLO, ART ZENDRICHDE ASIS', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36193, '118301453', 'PINEDA, AIRA VANESSAHALILI', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36194, '115300506', 'PINEDA, JOHNREYBAZAR', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36195, '118301335', 'RASHID, GABRIELAIMBONG', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36196, '119300622', 'RODRIGUEZ, JEANIELLENAVARRO', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36197, '120301515', 'ROQUE, RONALD SHELTENFLORES', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36198, '118301891', 'SAGUM, RUSSELL JAMESG', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36199, '118301101', 'SANGALANG, JAMES LENNINC.', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36200, '118301457', 'SANTOS, MARLAALMAYDA', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36201, '120300834', 'SIMO, KENNETHL', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36202, '119302060', 'SINGIAN, BRANIELESPIRITU', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36203, '120300372', 'SUBA, JOHN DAVIDIGNACIO', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36204, '120300374', 'SUBA, KHAT LENARDSAN JOSE', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36205, '120300567', 'SUDARIO, MICHAEL-', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36206, '119301007', 'SUZUQUI, FERNANDO VANDREAGUILAR', '2', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36207, '120301214', 'TAMAYO, HECTOR JR.A.', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36208, '118300960', 'TAPION, KING JOB CASTRO', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36209, '119301802', 'TIODIN, ROSELEESANTOS', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36210, '120301174', 'TOLENTINO, ANDREI KRISTOPHERZEN-', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36211, '120301422', 'TUAZON, AIRON PAULPANGANIBAN', '1', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36212, '113300407', 'VELASQUEZ, KRISHNAO.', '3', 'CCIS', '2020-2021', '1', '1601808263586633'),
(36213, '119301117', 'YANGCO, DARWINREGALA', '2', 'CCIS', '2020-2021', '1', '1601808263586633');

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
(5, '-1', 'Matthew', '2020-09-13 19:33:06', NULL, NULL, '500.00', '500.00', '0.0000', 'SPCF Admin', 1),
(6, '-1', 'Marvin Reyes', '2020-09-17 14:39:40', NULL, NULL, '3000.00', '3000.00', '0.0000', 'SPCF Cashier 1', 1),
(7, '-1', 'Matthew', '2020-09-26 17:20:26', NULL, NULL, '1200.00', '1200.00', '0.0000', 'Ronie Bituin', 1),
(8, '-1', 'Ronie Bituin', '2020-09-26 17:43:26', NULL, NULL, '300.00', '300.00', '0.0000', 'Ronie Bituin', 1),
(9, '-1', 'SPCF', '2020-09-26 17:56:59', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(10, '-1', 'sample', '2020-09-27 20:37:22', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Admin', 0),
(11, '0001', 'Ronie Bituin', '2020-09-27 20:38:27', NULL, NULL, '0.00', '0.00', '0.0000', 'Ronie Bituin', 0),
(13, '-1', 'Dummy Transaction', '2020-09-27 09:38:38', NULL, NULL, '1400.00', '1400.00', '0.0000', 'SPCF Cashier 1', -1),
(14, '-1', 'Dummy Transaction 2', '2020-09-27 09:53:02', NULL, NULL, '3700.00', '3700.00', '0.0000', 'SPCF Cashier 1', -1),
(15, '-1', '001', '2020-09-27 10:01:57', NULL, NULL, '35000.00', '35000.00', '0.0000', 'SPCF Cashier 1', -1),
(16, '160086345345', 'Gabriel, Princess Rona M.', '2020-09-27 16:31:46', NULL, NULL, '600.00', '600.00', '0.0000', 'SPCF Cashier 1', 1),
(17, '0003', 'Roy Dayrit', '2020-09-27 16:32:19', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Cashier 1', 0),
(18, '160086', 'Gabriel, Princess Rona M.', '2020-09-27 16:44:58', NULL, NULL, '0.00', '0.00', '0.0000', 'SPCF Cashier 1', 0),
(19, '160081', 'Gabriel, Princess Rona M.', '2020-09-27 17:24:13', NULL, NULL, '700.00', '700.00', '0.0000', 'SPCF Cashier 1', 1);

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
(5, 5, 1, 5, '100.00', '2020-09-13 19:33:10', '500.00', 0),
(6, 6, 1, 1, '100.00', '2020-09-17 14:40:21', '100.00', 1),
(7, 6, 4, 5, '600.00', '2020-09-17 14:40:47', '3000.00', 0),
(8, 7, 5, 1, '700.00', '2020-09-26 17:20:37', '700.00', 1),
(9, 7, 4, 2, '600.00', '2020-09-26 17:28:54', '1200.00', 0),
(10, 8, 1, 3, '100.00', '2020-09-26 17:43:32', '300.00', 0),
(11, 8, 8, 12, '130000.00', '2020-09-26 17:44:43', '1560000.00', 1),
(12, 9, 6, 1, '120.00', '2020-09-26 17:57:05', '120.00', 1),
(15, 13, 1, 2, '100.00', '2020-09-27 09:38:43', '200.00', 1),
(16, 13, 4, 2, '600.00', '2020-09-27 09:38:46', '1200.00', 0),
(17, 14, 4, 2, '600.00', '2020-09-27 09:53:08', '1200.00', 0),
(18, 14, 7, 5, '500.00', '2020-09-27 09:53:22', '2500.00', 0),
(19, 15, 5, 50, '700.00', '2020-09-27 10:02:04', '35000.00', 0),
(20, 16, 4, 1, '600.00', '2020-09-27 16:31:52', '600.00', 0),
(21, 17, 4, 1, '600.00', '2020-09-27 16:32:26', '600.00', 0),
(22, 18, 4, 1, '600.00', '2020-09-27 16:45:01', '600.00', 0),
(23, 19, 5, 1, '700.00', '2020-09-27 17:24:16', '700.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `upload_name` varchar(128) DEFAULT NULL,
  `date` text NOT NULL,
  `upload_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `upload_name`, `date`, `upload_id`) VALUES
(11, 'Sample Upload by Ronie', '20-10-04 06:44:23pm', '1601808263586633');

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
-- Indexes for table `payable`
--
ALTER TABLE `payable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

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
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `payable`
--
ALTER TABLE `payable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36214;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Constraints for table `payable`
--
ALTER TABLE `payable`
  ADD CONSTRAINT `payable_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
