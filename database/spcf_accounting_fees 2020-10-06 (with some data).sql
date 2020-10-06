-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2020 at 02:11 PM
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
(1, 'id_laces', 'SPCF ID LACES', -4, 4, 'Includes ID Holder and ID Lanyard', '100.00', '10.00'),
(4, 'eng_book_1', 'Book English 1', 81, 4, 'Book for English Elementary 1', '600.00', '500.00'),
(5, 'MTA Cert', 'MTA Certification Voicher', -343, 4, 'MTA Voucher for CCIS', '700.00', '500.00'),
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
(1, 'Transaction - Initiate Order', '2020-10-06 20:01:08', 'Ronie Bituin', 'Initiate Order. Transaction ID:1, Student ID: 119301862, Full Name: BARREDO, JAYSENMARIANO, Transaction Date: 2020-10-06 20:01:08'),
(2, 'Transaction - Add Item', '2020-10-06 20:01:11', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:1, Item ID: 5, Transaction Date: 2020-10-06 20:01:11, Sub Total: 700'),
(3, 'Transaction - Finish Order', '2020-10-06 20:01:16', 'Ronie Bituin', 'Transaction - Finish Order. Transaction ID:1, Full Name: BARREDO, JAYSENMARIANO, Transaction Date: 2020-10-06 20:01:16, Total: ?700, Amount Paid: ?700 Change: ?0'),
(4, 'Transaction - Initiate Order', '2020-10-06 20:02:35', 'Ronie Bituin', 'Initiate Order. Transaction ID:2, Student ID: 115300069, Full Name: JOHNSON, JOHN ELMONANG, Transaction Date: 2020-10-06 20:02:35'),
(5, 'Transaction - Add Item', '2020-10-06 20:02:38', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:2, Item ID: 5, Transaction Date: 2020-10-06 20:02:38, Sub Total: 700'),
(6, 'Transaction - Add Item', '2020-10-06 20:02:41', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:2, Item ID: 4, Transaction Date: 2020-10-06 20:02:41, Sub Total: 600'),
(7, 'Transaction - Finish Order', '2020-10-06 20:02:44', 'Ronie Bituin', 'Transaction - Finish Order. Transaction ID:2, Full Name: JOHNSON, JOHN ELMONANG, Transaction Date: 2020-10-06 20:02:44, Total: ?1300, Amount Paid: ?1300 Change: ?0'),
(8, 'Transaction - Initiate Order', '2020-10-06 20:04:50', 'Ronie Bituin', 'Initiate Order. Transaction ID:3, Student ID: 120301680, Full Name: DE GUZMAN, MICHAEL ANGELOT. , Transaction Date: 2020-10-06 20:04:50'),
(9, 'Transaction - Add Item', '2020-10-06 20:04:54', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:3, Item ID: 5, Transaction Date: 2020-10-06 20:04:54, Sub Total: 700'),
(10, 'Transaction - Add Item', '2020-10-06 20:04:59', 'Ronie Bituin', 'Transaction - Add Item. Transaction ID:3, Item ID: 5, Transaction Date: 2020-10-06 20:04:59, Sub Total: 700'),
(11, 'Transaction - Void Item In Order', '2020-10-06 20:05:24', 'Ronie Bituin', 'Void Item In Order. Transaction ID:3 Item ID:5 Item Name: MTA Certification Voicher Price: ?700.00 Sub Total: ?700.00'),
(12, 'Transaction - Finish Order', '2020-10-06 20:05:29', 'Ronie Bituin', 'Transaction - Finish Order. Transaction ID:3, Full Name: DE GUZMAN, MICHAEL ANGELOT. , Transaction Date: 2020-10-06 20:05:29, Total: ?700, Amount Paid: ?700 Change: ?0');

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
(1, 5, 'ccis', '2', '2020-2021'),
(2, 5, 'ccis', '1', '2020-2021');

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
(1, '119301864', 'AMARGO, RHANILRIVERA', '2', 'COB', '2020-2021', '1', '160198562918923'),
(2, '118301894', 'AMISOLA, LYIANDE GUZMAN', '3', 'COB', '2020-2021', '1', '160198562918923'),
(3, '119301144', 'CARREON, ANNA MEZZY BENEDICTO', '2', 'COB', '2020-2021', '1', '160198562918923'),
(4, '118301785', 'DELIM, ROGELIO JR.PANAO', '3', 'COB', '2020-2021', '1', '160198562918923'),
(5, '119301858', 'DONES, AIRALAPORE', '2', 'COB', '2020-2021', '1', '160198562918923'),
(6, '118301589', 'ENFESTAN , JOHN LENARDT. ', '3', 'COB', '2020-2021', '1', '160198562918923'),
(7, '119301518', 'FERNANDO, PAULO', '2', 'COB', '2020-2021', '1', '160198562918923'),
(8, '119301523', 'JOCSON, AEDRIAN ACEV ', '2', 'COB', '2020-2021', '1', '160198562918923'),
(9, '119301776', 'LACAP, RONA MARIEDAVID', '2', 'COB', '2020-2021', '1', '160198562918923'),
(10, '118302034', 'LAMPA, ELLACALMA', '3', 'COB', '2020-2021', '1', '160198562918923'),
(11, '118301330', 'LOPEZ, MA. ALYSSADALUSUNG', '3', 'COB', '2020-2021', '1', '160198562918923'),
(12, '119301687', 'MENDOZA, SHAIRAMUNOZ', '2', 'COB', '2020-2021', '1', '160198562918923'),
(13, '120301066', 'OCAMPO, ERIZ ZENONBANTA', '1', 'COB', '2020-2021', '1', '160198562918923'),
(14, '119301661', 'QAYUM, ANDREAM', '2', 'COB', '2020-2021', '1', '160198562918923'),
(15, '118301844', 'QUIAMBAO, CHRISTIAN LHOWELLCUNANAN', '3', 'COB', '2020-2021', '1', '160198562918923'),
(16, '119302063', 'RESENK, LUCINDAFABIA', '2', 'COB', '2020-2021', '1', '160198562918923'),
(17, '120300375', 'RODRIGUEZ, ROSCELBAUTISTA', '1', 'COB', '2020-2021', '1', '160198562918923'),
(18, '118301393', 'SALAS, HANIE MAECABALLERO', '3', 'COB', '2020-2021', '1', '160198562918923'),
(19, '120301436', 'SALVADICO, JENELYNCASTRO', '2', 'COB', '2020-2021', '1', '160198562918923'),
(20, '120301437', 'SANTOS, JUSTINRIVERA', '2', 'COB', '2020-2021', '1', '160198562918923'),
(21, '119301607', 'SARMIENTO, KIANA RIANHENSON', '2', 'COB', '2020-2021', '1', '160198562918923'),
(22, '119300883', 'SMITH, ADAM PAULRUNAS', '2', 'COB', '2020-2021', '1', '160198562918923'),
(23, '120300575', 'SPEERS, ANDREW WAYNESABEJON', '1', 'COB', '2020-2021', '1', '160198562918923'),
(24, '118301430', 'TIAMZON, RYANB', '3', 'COB', '2020-2021', '1', '160198562918923'),
(25, '120301461', 'TICSAY, MARIZCOLLADO', '1', 'COB', '2020-2021', '1', '160198562918923'),
(26, '120300392', 'WIJANGCO, KELVIN MEEKOLAXAMANA', '1', 'COB', '2020-2021', '1', '160198562918923'),
(27, '118301040', 'ABRAZADO, PATRICKBALINGIT', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(28, '120300826', 'BACAN, DAVE JACOBANDRES', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(29, '118300874', 'BALUIS, KYRON JAYAGUSTIN', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(30, '119301862', 'BARREDO, JAYSENMARIANO', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(31, '119302130', 'BASUNBUL, AWADHABBOD', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(32, '120300889', 'BASUNBUL, SAEEDAWADH', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(33, '119301630', 'BEZA, FERNANDO JR. MENDOZA', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(34, '119301604', 'CALAYAG, RANSELL JOSEPHCARPIO', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(35, '120301558', 'CALVO, JAYNIELPAJARILLO', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(36, '118301190', 'CANASA, BARNETTRIVERA', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(37, '118301515', 'CARLOS, EVITA MARGAUXOLEDAN', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(38, '120301760', 'CEPRINO, GEMB.', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(39, '120301201', 'CLEMENTE, PRINCE CHARLESMIRANDA', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(40, '119301323', 'DAWISAN, TEE JAYESTERNON', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(41, '119301317', 'DE GUZMAN, ARON JAMESTARIMAN', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(42, '120301680', 'DE GUZMAN, MICHAEL ANGELOT. ', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(43, '119301571', 'DE JESUS , LOUIE ANDREIQUINTO', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(44, '119301005', 'DEL ROSARIO, CLEODUNGCA', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(45, '120300413', 'ESCRAMOSA, FITZGERALDB.', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(46, '118300645', 'ESTRADA, ROSALIEZ', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(47, '115300340', 'GARCIA, DELFINGONZALES', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(48, '118301060', 'GARCIA, PAULOD.', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(49, '119301662', 'GIBBS, CLEVELANDALEXANDER', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(50, '120301498', 'GINDOY, MHELWINCABUS', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(51, '118301503', 'ILUSTRISIMO, JECELBASBAS', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(52, '115300069', 'JOHNSON, JOHN ELMONANG', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(53, '118301183', 'LACSINA, RANA MAEDIZON', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(54, '119301496', 'LIM, JOSHUAGARCIA', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(55, '120301137', 'MACALINO, ALLEN JAYC. ', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(56, '120300687', 'MANALESE, REYMONDTIGLAO', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(57, '120301701', 'MANDAP, LYDONP.', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(58, '120300267', 'MANGAHAS, MERCEDES-', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(59, '118301288', 'MERCADO, RENCE LUIS REICUENCO', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(60, '118301058', 'MESA, JIM KIERLISING', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(61, '120300890', 'MOHAMMED, YUSUFSAJJAD', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(62, '120301300', 'NICOLAS, JOHN AARONDE LEON', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(63, '120301445', 'NISHIMURA, ARISAGUIBO', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(64, '120301037', 'NODA, MIKO RAPHAELSALALILA', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(65, '120300675', 'OCAMPO, GABRIEL BENNEESGUERRA', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(66, '119301274', 'PACETE, EZRA JOSHUAOTOMAN', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(67, '119300934', 'PAGOBO, CLEO CYRADAABAY', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(68, '120300773', 'PAMILAGAS, NATHANIELELCHICO', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(69, '118300958', 'PERILLO, ART ZENDRICHDE ASIS', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(70, '118301453', 'PINEDA, AIRA VANESSAHALILI', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(71, '115300506', 'PINEDA, JOHNREYBAZAR', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(72, '118301335', 'RASHID, GABRIELAIMBONG', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(73, '119300622', 'RODRIGUEZ, JEANIELLENAVARRO', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(74, '120301515', 'ROQUE, RONALD SHELTENFLORES', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(75, '118301891', 'SAGUM, RUSSELL JAMESG', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(76, '118301101', 'SANGALANG, JAMES LENNINC.', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(77, '118301457', 'SANTOS, MARLAALMAYDA', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(78, '120300834', 'SIMO, KENNETHL', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(79, '119302060', 'SINGIAN, BRANIELESPIRITU', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(80, '120300372', 'SUBA, JOHN DAVIDIGNACIO', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(81, '120300374', 'SUBA, KHAT LENARDSAN JOSE', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(82, '120300567', 'SUDARIO, MICHAEL-', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(83, '119301007', 'SUZUQUI, FERNANDO VANDREAGUILAR', '2', 'CCIS', '2020-2021', '1', '160198562918923'),
(84, '120301214', 'TAMAYO, HECTOR JR.A.', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(85, '118300960', 'TAPION, KING JOB CASTRO', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(86, '119301802', 'TIODIN, ROSELEESANTOS', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(87, '120301174', 'TOLENTINO, ANDREI KRISTOPHERZEN-', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(88, '120301422', 'TUAZON, AIRON PAULPANGANIBAN', '1', 'CCIS', '2020-2021', '1', '160198562918923'),
(89, '113300407', 'VELASQUEZ, KRISHNAO.', '3', 'CCIS', '2020-2021', '1', '160198562918923'),
(90, '119301117', 'YANGCO, DARWINREGALA', '2', 'CCIS', '2020-2021', '1', '160198562918923');

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
(1, '119301862', 'BARREDO, JAYSENMARIANO', '2020-09-06 20:01:08', NULL, NULL, '700.00', '700.00', '0.0000', 'Ronie Bituin', 1),
(2, '115300069', 'JOHNSON, JOHN ELMONANG', '2020-08-06 20:02:35', NULL, NULL, '1300.00', '1300.00', '0.0000', 'Ronie Bituin', 1),
(3, '120301680', 'DE GUZMAN, MICHAEL ANGELOT. ', '2020-10-06 20:04:50', NULL, NULL, '700.00', '700.00', '0.0000', 'Ronie Bituin', 1);

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
(1, 1, 5, 1, '700.00', '2020-09-06 20:01:08', '700.00', 0),
(2, 2, 5, 1, '700.00', '2020-08-06 20:02:38', '700.00', 0),
(3, 2, 4, 1, '600.00', '2020-08-06 20:02:38', '600.00', 0),
(4, 3, 5, 1, '700.00', '2020-10-06 20:04:54', '700.00', 0),
(5, 3, 5, 1, '700.00', '2020-10-06 20:04:59', '700.00', 1);

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
(12, 'Sample Upload by Ronie', '20-10-06 08:00:29pm', '160198562918923');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payable`
--
ALTER TABLE `payable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction_lists`
--
ALTER TABLE `transaction_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
