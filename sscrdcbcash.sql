--------------------------
--    `sscrdcbcash`     --
--------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";





------------------------
-- PARA SA CREATE TABLES
------------------------

CREATE TABLE `tbl_activitylogs` (
  `ActivityLogs_Id` int(11) NOT NULL,
  `Account_Address` varchar(15) NOT NULL,
  `Task` varchar(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_webaccounts` (
  `WebAccounts_Address` varchar(15) NOT NULL,
  `ActorCategory_Id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `PinCode` varchar(255) DEFAULT NULL,
  `IsAccountActive` bit(1) DEFAULT b'1',
  `Campus_Id` int(11) DEFAULT NULL,
  `DateRegistered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_whitelist` (
  `Account_Address` varchar(15) NOT NULL,
  `Whitelisted_Address` varchar(15) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_usersdata` (
  `UsersAccount_Address` varchar(15) NOT NULL,
  `GuardianAccount_Address` varchar(15) DEFAULT NULL,
  `SchoolPersonalId` varchar(15) DEFAULT NULL,
  `Balance` float DEFAULT 0,
  `CanDoTransfers` bit(1) DEFAULT b'1',
  `CanDoTransactions` bit(1) DEFAULT b'1',
  `CanUseCard` bit(1) DEFAULT b'1',
  `CanModifySettings` bit(1) DEFAULT b'1',
  `IsTransactionAutoConfirm` bit(1) NOT NULL DEFAULT b'0',
  `DateRegistered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_card` (
  `Card_Id` int(11) NOT NULL,
  `Card_Address` varchar(15) DEFAULT NULL,
  `UsersAccount_Address` varchar(15) DEFAULT NULL,
  `Campus_Id` int(11) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `Notes` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_campus` (
  `Campus_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Abbreviation` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_actorcategory` (
  `ActorCategory_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_authentications` (
  `Account_Address` varchar(15) NOT NULL,
  `AuthToken` varchar(30) DEFAULT NULL,
  `AuthExpirationTime` timestamp NULL DEFAULT NULL,
  `AuthCreationTime` timestamp NULL DEFAULT NULL,
  `OtpCode` varchar(6) DEFAULT NULL,
  `OtpCreationTime` timestamp NULL DEFAULT NULL,
  `OtpExpirationTime` timestamp NULL DEFAULT NULL,
  `IpAddress` varchar(20) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Device` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_merchantitems` (
  `MerchantItems_Id` int(11) NOT NULL,
  `ItemsCategory_Id` int(11) NOT NULL,
  `MerchantsCategory_Id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Price` float NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `CreatedTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifiedTimestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_loginhistory` (
  `Account_Address` varchar(15) NOT NULL,
  `IpAddress` varchar(20) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Device` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_itemscategory` (
  `ItemsCategory_Id` int(11) NOT NULL,
  `MerchantsCategory_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_guardianaccount` (
  `GuardianAccount_Address` varchar(15) NOT NULL,
  `UsersAccount_Address` varchar(15) DEFAULT NULL,
  `ActorCategory_Id` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `PinCode` varchar(255) DEFAULT NULL,
  `Campus_Id` int(11) DEFAULT NULL,
  `IsAccountActive` bit(1) DEFAULT b'1',
  `DateRegistered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_transactionitems` (
  `Transaction_Address` varchar(20) NOT NULL,
  `MerchantItems_Id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_remittance` (
  `Remittance_Id` int(11) NOT NULL,
  `Submitted_By` varchar(15) NOT NULL,
  `TotalOrders` varchar(11) NOT NULL,
  `TotalAmount` varchar(11) NOT NULL,
  `DateResponse` timestamp NULL DEFAULT NULL,
  `Status` varchar(25) NOT NULL DEFAULT 'Waiting',
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_notifications` (
  `Notification_ID` int(11) NOT NULL,
  `Creator_Account_Address` varchar(15) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `IsNew` bit(1) DEFAULT b'1',
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_merchantscategory` (
  `MerchantsCategory_Id` int(11) NOT NULL,
  `Campus_Id` int(11) NOT NULL,
  `ShopName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_merchants` (
  `WebAccounts_Address` varchar(15) NOT NULL,
  `MerchantsCategory_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_configurations` (
  `Configuration_Id` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_usersaccount` (
  `UsersAccount_Address` varchar(15) NOT NULL,
  `ActorCategory_Id` int(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `PinCode` varchar(255) DEFAULT NULL,
  `IsAccountActive` bit(1) DEFAULT b'1',
  `Campus_Id` int(11) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_transactiontype` (
  `TransactionType_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_transactionsinfo` (
  `Transaction_Address` varchar(20) NOT NULL,
  `TransactionType_Id` int(11) NOT NULL,
  `Sender_Address` varchar(15) NOT NULL,
  `Receiver_Address` varchar(15) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Amount` float NOT NULL,
  `Discount` float NOT NULL,
  `DiscountReason` varchar(255) DEFAULT NULL,
  `TotalAmount` float NOT NULL,
  `PostedBy` varchar(15) NOT NULL,
  `Notes` text DEFAULT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_transactions` (
  `Transaction_Address` varchar(20) NOT NULL,
  `Account_Address` varchar(15) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Debit` float NOT NULL,
  `Credit` float NOT NULL,
  `Remittance_Id` int(11) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





------------------------------------
-- PARA SA PAG ADD NG DATA SA TABLES
------------------------------------

INSERT INTO `tbl_activitylogs` (`ActivityLogs_Id`, `Account_Address`, `Task`, `Timestamp`) VALUES
(1, 'ACT000000000000', 'Updated its own Lastname to Test.', '2023-10-14 11:00:56'),
(2, 'ACT000000000000', 'Updated its own Lastname to 123.', '2023-10-14 11:04:33'),
(3, 'ACT000000000000', 'Updated its own Lastname to 1111.', '2023-10-14 11:09:02'),
(4, 'ACT000000000000', 'Updated its own PIN Code.', '2023-10-14 11:25:50'),
(5, 'ACT000000000000', 'Updated its own Lastname to new last.', '2023-10-14 11:26:49'),
(6, 'ACT000000000000', 'Updated its own PIN Code.', '2023-10-14 11:28:14'),
(11, 'ACT000000000000', 'Updated [USR111111111111] Email settings to .', '2023-10-14 22:00:48'),
(12, 'ACT000000000000', 'Updated [USR111111111111] Firstname settings to test.', '2023-10-14 22:00:48'),
(13, 'ACT000000000000', 'Updated [USR111111111111] Lastname settings to test.', '2023-10-14 22:00:48'),
(14, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:00:48'),
(15, 'ACT000000000000', 'Updated [USR111111111111] SchoolPersonalId settings to .', '2023-10-14 22:00:48'),
(16, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:00:57'),
(17, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:01:01'),
(18, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:01:15'),
(19, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:02:18'),
(20, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:02:20'),
(21, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:02:40'),
(22, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:02:43'),
(23, 'ACT000000000000', 'Updated [USR111111111111] CanDoTransactions settings to 0.', '2023-10-14 22:02:43'),
(24, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:02:48'),
(25, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:28'),
(26, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:31'),
(27, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:32'),
(28, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:34'),
(29, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:34'),
(30, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:34'),
(31, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:34'),
(32, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:05:34'),
(33, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:08:03'),
(34, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 1.', '2023-10-14 22:08:12'),
(35, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:08:16'),
(36, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 1.', '2023-10-14 22:17:00'),
(37, 'ACT000000000000', 'Updated [USR111111111111] CanDoTransfers settings to 0.', '2023-10-14 22:17:00'),
(38, 'ACT000000000000', 'Updated [USR111111111111] CanDoTransactions settings to 0.', '2023-10-14 22:17:00'),
(39, 'ACT000000000000', 'Updated [USR111111111111] CanDoTransfers settings to 1.', '2023-10-14 22:17:09'),
(40, 'ACT000000000000', 'Updated [USR111111111111] CanDoTransactions settings to 1.', '2023-10-14 22:17:09'),
(41, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-14 22:17:11'),
(42, 'ACT000000000000', 'Updated [USR111111111111] Lastname settings to testtesttest.', '2023-10-14 22:17:19'),
(43, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 1.', '2023-10-15 13:11:27'),
(44, 'ACT000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-15 13:11:31'),
(45, 'ACT000000000000', '[ACT000000000000] Approved remittance id [1].', '2023-10-16 19:46:41'),
(46, 'ACT000000000000', '[ACT000000000000] Approved remittance id [1].', '2023-10-16 19:48:15'),
(47, 'ACT000000000000', '[ACT000000000000] Approved remittance id [1].', '2023-10-16 19:49:16'),
(48, 'ADM000000000000', 'Updated [USR111111111111] IsAccountActive settings to 1.', '2023-10-17 17:38:47'),
(49, 'ADM000000000000', 'Updated [USR111111111111] IsAccountActive settings to 0.', '2023-10-17 17:39:02'),
(50, 'ADM000000000000', 'Updated [GST000000000000] Email settings to .', '2023-10-17 17:52:22'),
(51, 'ADM000000000000', 'Updated [GST000000000000] IsAccountActive settings to 0.', '2023-10-17 17:52:32'),
(52, 'ADM000000000000', 'Updated [GST000000000000] IsAccountActive settings to 1.', '2023-10-17 17:52:44'),
(53, 'ADM000000000000', 'Updated [GST000000000000] CanDoTransactions settings to 0.', '2023-10-17 19:14:01'),
(54, 'ADM000000000000', 'Updated [GST000000000000] CanDoTransactions settings to 1.', '2023-10-17 19:14:06'),
(55, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 0.', '2023-10-17 22:37:25'),
(56, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 1.', '2023-10-17 22:39:30'),
(57, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 0.', '2023-10-17 22:39:32'),
(58, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 1.', '2023-10-17 22:39:34'),
(59, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 0.', '2023-10-17 22:39:37'),
(60, 'ADM000000000000', 'Updated [MTA000000000000] Lastname settings to MerchantAdminss.', '2023-10-17 22:42:14'),
(61, 'ADM000000000000', 'Updated [MTA000000000000] Email settings to jameslayson.0@gmail.comss.', '2023-10-17 22:42:20'),
(62, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 0.', '2023-10-17 22:43:09'),
(63, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 1.', '2023-10-17 22:43:12'),
(64, 'ADM000000000000', 'Updated [MTS000000000000] Lastname settings to MerchantStaffdd.', '2023-10-17 22:43:15'),
(65, 'ADM000000000000', 'Updated [ACT000000000000] IsAccountActive settings to 0.', '2023-10-17 22:44:11'),
(66, 'ADM000000000000', 'Updated [ACT000000000000] IsAccountActive settings to 1.', '2023-10-17 22:44:17'),
(67, 'ADM000000000000', 'Updated [ACT000000000000] Lastname settings to Layson1.', '2023-10-17 22:44:20'),
(68, 'ADM000000000000', 'Updated [ADM000000000000] Lastname settings to Administrator1.', '2023-10-17 22:44:33'),
(69, 'ADM000000000000', 'Updated [ADM000000000000] IsAccountActive settings to 0.', '2023-10-18 15:04:53'),
(70, 'ADM000000000000', 'Updated [ADM000000000000] IsAccountActive settings to 1.', '2023-10-18 15:05:09'),
(71, 'ADM000000000000', 'Updated [ADM000000000000] Firstname settings to Administrator11.', '2023-10-18 15:06:03'),
(72, 'ADM000000000000', 'Updated [ADM000000000000] PinCode.', '2023-10-18 15:06:12'),
(73, 'ADM000000000000', 'Updated [ADM000000000000] PinCode.', '2023-10-18 15:06:28'),
(74, 'ADM000000000000', 'Updated [ACT000000000000] Firstname settings to SRJ1.', '2023-10-18 15:06:44'),
(75, 'ADM000000000000', 'Updated [ACT000000000000] Lastname settings to Layson1111.', '2023-10-18 15:06:48'),
(76, 'ADM000000000000', 'Updated [ACT000000000000] Email settings to jameslayson.0@gmail.com1.', '2023-10-18 15:06:51'),
(77, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:22:03'),
(78, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:22:07'),
(79, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:22:10'),
(80, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:22:11'),
(81, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to accountwww.', '2023-10-18 15:22:25'),
(82, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to accountwww.', '2023-10-18 15:22:27'),
(83, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to accountwww.', '2023-10-18 15:22:28'),
(84, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to accountwww.', '2023-10-18 15:22:30'),
(85, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to accountwww.', '2023-10-18 15:22:30'),
(86, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to accountwww.', '2023-10-18 15:22:31'),
(87, 'ADM000000000000', 'Updated [ADM000000000000] IsAccountActive settings to 0.', '2023-10-18 15:23:19'),
(88, 'ADM000000000000', 'Updated [ADM000000000000] IsAccountActive settings to 1.', '2023-10-18 15:23:23'),
(89, 'ADM000000000000', 'Updated [ACT000000000000] IsAccountActive settings to 0.', '2023-10-18 15:23:34'),
(90, 'ADM000000000000', 'Updated [ACT000000000000] IsAccountActive settings to 1.', '2023-10-18 15:23:37'),
(91, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 0.', '2023-10-18 15:23:48'),
(92, 'ADM000000000000', 'Updated [MTS000000000000] Firstname settings to MerchantStaff4.', '2023-10-18 15:23:53'),
(93, 'ADM000000000000', 'Updated [MTS000000000000] Lastname settings to MerchantStaffdd4.', '2023-10-18 15:23:53'),
(94, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 1.', '2023-10-18 15:23:53'),
(95, 'ADM000000000000', 'Updated [MTS000000000000] Email settings to jameslayson.0@gmail.com1.', '2023-10-18 15:23:58'),
(96, 'ADM000000000000', 'Updated [MTA000000000000] Firstname settings to MerchantAdmin1.', '2023-10-18 15:24:12'),
(97, 'ADM000000000000', 'Updated [MTA000000000000] Lastname settings to MerchantAdminss1.', '2023-10-18 15:24:12'),
(98, 'ADM000000000000', 'Updated [MTA000000000000] Email settings to jameslayson.0@gmail.comss1.', '2023-10-18 15:24:12'),
(99, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 1.', '2023-10-18 15:24:12'),
(112, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 0.', '2023-10-18 15:26:10'),
(113, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 1.', '2023-10-18 15:26:14'),
(114, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:29:49'),
(115, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:29:50'),
(116, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:29:51'),
(117, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:32:20'),
(118, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:32:21'),
(119, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:33:10'),
(120, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:34:10'),
(121, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:34:12'),
(122, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:34:17'),
(123, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:38:30'),
(124, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:40:47'),
(125, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:40:49'),
(126, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:40:55'),
(127, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:43:14'),
(128, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:44:03'),
(129, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:44:38'),
(130, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:44:39'),
(131, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 0.', '2023-10-18 15:45:18'),
(132, 'ADM000000000000', 'Updated [MTS000000000000] IsAccountActive settings to 1.', '2023-10-18 15:45:51'),
(133, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:46:22'),
(134, 'ADM000000000000', 'Updated [GDN000000000000] IsAccountActive settings to 0.', '2023-10-18 15:48:04'),
(135, 'ADM000000000000', 'Updated [GDN000000000000] Firstname settings to guardian23.', '2023-10-18 15:48:11'),
(136, 'ADM000000000000', 'Updated [GDN000000000000] Lastname settings to account2.', '2023-10-18 15:48:11'),
(137, 'ADM000000000000', 'Updated [GDN000000000000] Email settings to jameslayson.0@gmail.com3.', '2023-10-18 15:48:14'),
(140, 'ADM000000000000', 'Updated [MTA000000000000] IsAccountActive settings to 0.', '2023-10-18 16:07:41'),
(142, 'ADM000000000000', 'Updated [GST000000000000] CanUseCard settings to 0.', '2023-10-18 16:14:57'),
(143, 'ADM000000000000', 'Updated [GST000000000000] CanModifySettings settings to 0.', '2023-10-18 16:15:20'),
(144, 'ADM000000000000', 'Updated [GST000000000000] CanModifySettings settings to 1.', '2023-10-18 16:15:24'),
(145, 'ADM000000000000', 'Updated [GST000000000000] CanUseCard settings to 1.', '2023-10-18 16:15:24'),
(146, 'ADM000000000000', 'Updated [USR000000000000] GuardianAccountAddress settings to GDN000000000000.', '2023-10-18 16:28:02'),
(147, 'ADM000000000000', 'Added a new Administrator Account.', '2023-10-18 21:58:18'),
(148, 'ADM000000000000', 'Added a new Accounting Account.', '2023-10-18 22:01:44'),
(149, 'ADM000000000000', 'Added a new Merchant Admin Account.', '2023-10-18 22:04:18'),
(150, 'ADM000000000000', 'Added a new Merchant Staff Account.', '2023-10-18 22:05:52'),
(151, 'ADM000000000000', 'Added a new Guardian Account.', '2023-10-18 22:07:27'),
(152, 'ADM000000000000', 'Updated [MTAaCXoQNtVedBO] IsAccountActive settings to 0.', '2023-10-18 22:08:09'),
(153, 'ADM000000000000', 'Updated its own Lastname to Administrator122.', '2023-10-19 13:17:42'),
(154, 'ADM000000000000', 'Updated its own Lastname to Administrator122.', '2023-10-19 13:18:21'),
(155, 'ADM000000000000', 'Updated its own Lastname to Administrator1223.', '2023-10-19 13:18:36'),
(156, 'ADM000000000000', 'Uploaded a new card [].', '2023-10-19 17:36:01'),
(157, 'ADM000000000000', 'Uploaded a new card [].', '2023-10-19 17:37:14'),
(158, 'ADM000000000000', 'Uploaded a new card [asdasdasd].', '2023-10-19 17:37:48'),
(159, 'ADM000000000000', 'Uploaded a new card [test1].', '2023-10-19 17:37:54'),
(160, 'ADM000000000000', 'Uploaded a new card [test123].', '2023-10-19 17:38:02'),
(161, 'ADM000000000000', 'Uploaded a new card [testestsets].', '2023-10-19 17:38:17'),
(162, 'ADM000000000000', 'Updated Notes of [test1] to [4545].', '2023-10-19 19:06:25'),
(163, 'ADM000000000000', 'Updated IsActive of [test1] to [0].', '2023-10-19 19:07:51'),
(164, 'ADM000000000000', 'Updated IsActive of [test1] to [0].', '2023-10-19 19:07:55'),
(165, 'ADM000000000000', 'Updated IsActive of [test1] to [0].', '2023-10-19 19:07:59'),
(166, 'ADM000000000000', 'Updated IsActive of [test1] to [0].', '2023-10-19 19:08:40'),
(167, 'ADM000000000000', 'Updated IsActive of [test1] to [0].', '2023-10-19 19:08:44'),
(168, 'ADM000000000000', 'Updated IsActive of [test1] to [0].', '2023-10-19 19:09:32'),
(169, 'ACT000000000000', 'Updated [USR000000000000] IsAccountActive settings to 0.', '2023-10-19 19:36:19');

INSERT INTO `tbl_actorcategory` (`ActorCategory_Id`, `Name`, `Code`) VALUES
(1, 'Administrator', 'ADM'),
(2, 'Accounting', 'ACC'),
(3, 'Merchant Admin', 'MTA'),
(4, 'Merchant Staff', 'MTS'),
(5, 'User', 'USR'),
(6, 'Guest', 'GST'),
(7, 'Guardian', 'GDN');

INSERT INTO `tbl_authentications` (`Account_Address`, `AuthToken`, `AuthExpirationTime`, `AuthCreationTime`, `OtpCode`, `OtpCreationTime`, `OtpExpirationTime`, `IpAddress`, `Location`, `Device`) VALUES
('MTA000000000000', '$2y$10$I.J6AJnitZ/inWsbAVb8kup', '2023-10-19 13:43:15', '2023-10-19 13:38:15', NULL, NULL, NULL, '::1', 'Unknown', 'Windows NT 10.0; Win64; x64');

INSERT INTO `tbl_campus` (`Campus_Id`, `Name`, `Abbreviation`) VALUES
(1, 'Cavite Main Campus', NULL),
(2, 'Cavite Cañacao Campus', NULL);

INSERT INTO `tbl_card` (`Card_Id`, `Card_Address`, `UsersAccount_Address`, `Campus_Id`, `IsActive`, `Notes`) VALUES
(1, '234232432224', 'USR111111111111', 1, b'1', NULL),
(2, '34324324r32423', 'USR000000000000', 1, b'1', NULL),
(3, '232423242353225', 'GST000000000000', 1, b'1', NULL),
(5, 'dsadsad', NULL, 1, b'1', NULL),
(7, 'dasdasdadafaf', NULL, 1, b'1', NULL),
(8, 'asdasdasd', NULL, 1, b'1', NULL),
(9, 'test1', NULL, 1, b'0', '4545'),
(10, 'test123', NULL, 1, b'1', NULL),
(11, 'testestsets', NULL, 1, b'1', NULL);

INSERT INTO `tbl_configurations` (`Configuration_Id`, `Title`, `Value`, `Description`) VALUES
(1, 'IsMaintenance', 'FALSE', NULL);

INSERT INTO `tbl_guardianaccount` (`GuardianAccount_Address`, `UsersAccount_Address`, `ActorCategory_Id`, `Email`, `Firstname`, `Lastname`, `PinCode`, `Campus_Id`, `IsAccountActive`, `DateRegistered`) VALUES
('GDN000000000000', 'USR000000000000', 7, 'jameslayson.0@gmail.com3', 'guardian23', 'account2', '000000', 1, b'0', '2023-10-17 18:01:42'),
('GDNx2OyUNfmYzmm', NULL, 7, 'gdn1@gdn1.gdn1', 'gdn1', 'gdn1', NULL, 1, b'1', '2023-10-18 22:07:27');

INSERT INTO `tbl_itemscategory` (`ItemsCategory_Id`, `MerchantsCategory_Id`, `Name`) VALUES
(1, 1, 'Test Category');

INSERT INTO `tbl_loginhistory` (`Account_Address`, `IpAddress`, `Location`, `Device`) VALUES
('ACT000000000000', '::1', 'Unknown', 'Windows NT 10.0; Win64; x64'),
('ADM000000000000', '127.0.0.1', 'Unknown', 'Windows NT 10.0; Win64; x64'),
('ADM000000000000', '::1', 'Unknown', 'Windows NT 10.0; Win64; x64'),
('MTA000000000000', '::1', 'Unknown', 'Windows NT 10.0; Win64; x64');

INSERT INTO `tbl_merchantitems` (`MerchantItems_Id`, `ItemsCategory_Id`, `MerchantsCategory_Id`, `Name`, `Price`, `Image`, `IsActive`, `CreatedTimestamp`, `ModifiedTimestamp`) VALUES
(1, 1, 1, 'Test Item 1', 123, NULL, b'1', '2023-10-16 17:41:23', NULL),
(2, 1, 1, 'Test Item 2', 222, NULL, b'1', '2023-10-16 17:41:48', NULL),
(3, 1, 1, 'Test Item 3', 333, NULL, b'1', '2023-10-16 17:42:08', NULL);

INSERT INTO `tbl_merchants` (`WebAccounts_Address`, `MerchantsCategory_Id`) VALUES
('MTA000000000000', 1),
('MTS000000000000', 1),
('MTAaCXoQNtVedBO', 4),
('MTSYKgQsA0DKLjj', 4);

INSERT INTO `tbl_merchantscategory` (`MerchantsCategory_Id`, `Campus_Id`, `ShopName`) VALUES
(1, 1, 'Tapsilogan'),
(2, 1, 'Canteenan'),
(4, 1, 'newtrest');

INSERT INTO `tbl_notifications` (`Notification_ID`, `Creator_Account_Address`, `Title`, `Content`, `IsNew`, `Timestamp`) VALUES
(1, 'ADM000000000000', 'Test Notification', 'TAKS asfjasf jaf asf aDAFJ fasf afaf', b'1', '2023-10-13 20:02:15'),
(2, 'ADM000000000000', 'Test 2 Notification', 'asdasdsadsa asfjasf jaf asf aDAFJ fasf afaf', b'1', '2023-10-13 20:02:32');

INSERT INTO `tbl_remittance` (`Remittance_Id`, `Submitted_By`, `TotalOrders`, `TotalAmount`, `DateResponse`, `Status`, `Timestamp`) VALUES
(1, 'MTA000000000000', '12', '150', '2023-10-16 13:49:16', 'Approved', '2023-10-16 16:00:06');

INSERT INTO `tbl_transactionitems` (`Transaction_Address`, `MerchantItems_Id`, `Quantity`, `Amount`) VALUES
('20231012222411W', 1, 1, 1223),
('20231012222524B', 2, 2, 222),
('20231012222524B', 3, 3, 333);

INSERT INTO `tbl_transactions` (`Transaction_Address`, `Account_Address`, `Status`, `Debit`, `Credit`, `Remittance_Id`, `Timestamp`) VALUES
('20231012220643E', 'ACT000000000000', 'Completed', 12, 0, NULL, '2023-10-12 20:06:43'),
('20231012220711N', 'ACT000000000000', 'Completed', 23, 0, NULL, '2023-10-12 20:07:11'),
('20231012222133v', 'USR000000000000', 'Completed', 0, 1, NULL, '2023-10-12 20:21:33'),
('20231012222141e', 'USR000000000000', 'Completed', 0, 1, NULL, '2023-10-12 20:21:41'),
('202310122222237', 'USR000000000000', 'Completed', 0, 1, NULL, '2023-10-12 20:22:23'),
('20231012222250w', 'ACT000000000000', 'Completed', 12, 0, NULL, '2023-10-12 20:22:50'),
('202310122223537', 'USR000000000000', 'Completed', 0, 1, NULL, '2023-10-12 20:23:53'),
('20231012222411W', 'ACT000000000000', 'Completed', 34, 0, 1, '2023-10-12 20:24:11'),
('20231012222524B', 'USR000000000000', 'Completed', 0, 222, 1, '2023-10-12 20:25:24'),
('20231013085749w', 'USR000000000000', 'Completed', 0, 2, NULL, '2023-10-13 06:57:49'),
('20231013085923u', 'USR000000000000', 'Completed', 0, 1, NULL, '2023-10-13 06:59:23'),
('20231013184643J2dCtK', 'ACT000000000000', 'Completed', 122, 0, NULL, '2023-10-13 16:46:43'),
('20231015230653CEI6qY', 'ACT000000000000', 'Completed', 12, 0, NULL, '2023-10-15 21:06:53'),
('20231015230653CEI6qY', 'USR000000000000', 'Completed', 0, 12, NULL, '2023-10-15 21:06:53'),
('202310161734285QWoKU', 'ACT000000000000', 'Completed', 1, 0, NULL, '2023-10-16 15:34:28'),
('202310161734285QWoKU', 'USR000000000000', 'Completed', 0, 1, NULL, '2023-10-16 15:34:28');

INSERT INTO `tbl_transactionsinfo` (`Transaction_Address`, `TransactionType_Id`, `Sender_Address`, `Receiver_Address`, `Status`, `Amount`, `Discount`, `DiscountReason`, `TotalAmount`, `PostedBy`, `Notes`, `PaymentMethod`, `Timestamp`) VALUES
('20231012220643E', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 132, 0, '', 132, 'ACT000000000000', NULL, NULL, '2023-10-12 20:06:43'),
('20231012220711N', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 132, 0, '', 132, 'ACT000000000000', NULL, NULL, '2023-10-12 20:07:11'),
('20231012222133v', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-12 20:21:33'),
('20231012222141e', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-12 20:21:41'),
('202310122222237', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-12 20:22:23'),
('20231012222250w', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-12 20:22:50'),
('202310122223537', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-12 20:23:53'),
('20231012222411W', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 0, 0, '', 0, 'ACT000000000000', NULL, NULL, '2023-10-12 20:24:11'),
('20231012222524B', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 222, 0, '', 222, 'ACT000000000000', NULL, NULL, '2023-10-12 20:25:24'),
('20231013085749w', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 2, 0, '', 2, 'ACT000000000000', NULL, NULL, '2023-10-13 06:57:49'),
('20231013085923u', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-13 06:59:23'),
('20231013184643J2dCtK', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 0, 0, '', 0, 'ACT000000000000', NULL, NULL, '2023-10-13 16:46:43'),
('20231015230653CEI6qY', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 12, 0, '', 12, 'ACT000000000000', NULL, NULL, '2023-10-15 21:06:53'),
('202310161734285QWoKU', 1, 'ACT000000000000', 'USR000000000000', 'Completed', 1, 0, '', 1, 'ACT000000000000', NULL, NULL, '2023-10-16 15:34:28');

INSERT INTO `tbl_transactiontype` (`TransactionType_Id`, `Name`) VALUES
(1, 'Cash In'),
(2, 'Transfer'),
(3, 'Purchase'),
(4, 'Cash Out');

INSERT INTO `tbl_usersaccount` (`UsersAccount_Address`, `ActorCategory_Id`, `Email`, `Firstname`, `Lastname`, `PinCode`, `IsAccountActive`, `Campus_Id`, `Password`) VALUES
('GST000000000000', 6, '', 'gust', 'account', NULL, b'1', 1, NULL),
('USR000000000000', 5, 'jameslayson.0@gmail.com', 'Stephen', 'Layson', '000000', b'0', 1, NULL),
('USR111111111111', 5, '', 'test', 'testtesttest', '123456', b'0', 1, NULL);

INSERT INTO `tbl_usersdata` (`UsersAccount_Address`, `GuardianAccount_Address`, `SchoolPersonalId`, `Balance`, `CanDoTransfers`, `CanDoTransactions`, `CanUseCard`, `CanModifySettings`, `IsTransactionAutoConfirm`, `DateRegistered`) VALUES
('GST000000000000', NULL, '2323', 0, b'1', b'1', b'1', b'1', b'0', '2023-10-17 17:52:09'),
('USR000000000000', 'GDN000000000000', '202010170', 241, b'1', b'1', b'1', b'1', b'0', '2023-10-14 16:09:00'),
('USR111111111111', 'GDN000000000000', '', 0, b'1', b'1', b'1', b'1', b'0', '2023-10-14 21:55:28');

INSERT INTO `tbl_webaccounts` (`WebAccounts_Address`, `ActorCategory_Id`, `Username`, `Password`, `Email`, `Firstname`, `Lastname`, `PinCode`, `IsAccountActive`, `Campus_Id`, `DateRegistered`) VALUES
('ACT000000000000', 2, 'Accounting', '$2y$10$R6Sq.XaRAnrozof/p8bA.uWpZiSPia2bJoMXPRYf5vDu2N3L9KvYO', 'jameslayson.0@gmail.com1', 'SRJ1', 'Layson1111', '$2y$10$bJg1AIy6JN9P4pexLTyEfeTNnLOuO4B4D.ZbefLCUydUgeg7sYSBS', b'1', 1, '2023-10-17 16:41:18'),
('ACTbnvaoy82ymUd', 2, '456', '$2y$10$EFfMIck2/uq4T0x2/F/3SeFnTPAmOq8V8TXAK1.kaWPpx.3lNqT42', 'estset@warawr.awawd', '456', '456', NULL, b'1', 1, '2023-10-18 22:01:44'),
('ADM000000000000', 1, 'Administrator', '$2y$10$R6Sq.XaRAnrozof/p8bA.uWpZiSPia2bJoMXPRYf5vDu2N3L9KvYO', 'jameslayson.0@gmail.com', 'Administrator11', 'Administrator1223', '$2y$10$xCekFilC440bK4Tc2T9nX.NkJlCgzpcw3Uu6w5TcXs6./TPykkr4K', b'1', 1, '2023-10-17 16:41:18'),
('ADMgERds5x3dzSh', 1, '123', '$2y$10$qFoJHm/H8FRcqFmWJydmUuZ0ltFtNqBzMTXuHmV9OPPMoBF2eAul.', 'estset@warawr.awawd', 'test', 'etst', NULL, b'1', 1, '2023-10-18 21:58:18'),
('MTA000000000000', 3, 'MerchantAdmin', '$2y$10$R6Sq.XaRAnrozof/p8bA.uWpZiSPia2bJoMXPRYf5vDu2N3L9KvYO', 'jameslayson.0@gmail.comss1', 'MerchantAdmin1', 'MerchantAdminss1', '$2y$10$bJg1AIy6JN9P4pexLTyEfeTNnLOuO4B4D.ZbefLCUydUgeg7sYSBS', b'1', 1, '2023-10-17 16:41:18'),
('MTAaCXoQNtVedBO', 3, 'mta1', '$2y$10$ZawETzd9ZBplVIa1DxH9W.FTrqDy3DHirJPRBe3o5RDqhjpc0i6ym', 'estset@warawr.awawd', 'mta1', 'mta1', NULL, b'0', 1, '2023-10-18 22:04:18'),
('MTS000000000000', 4, 'MerchantStaff', '$2y$10$R6Sq.XaRAnrozof/p8bA.uWpZiSPia2bJoMXPRYf5vDu2N3L9KvYO', 'jameslayson.0@gmail.com1', 'MerchantStaff4', 'MerchantStaffdd4', '$2y$10$bJg1AIy6JN9P4pexLTyEfeTNnLOuO4B4D.ZbefLCUydUgeg7sYSBS', b'1', 1, '2023-10-17 16:41:18'),
('MTSYKgQsA0DKLjj', 4, 'mts1', '$2y$10$deHMVUfMvWTprYnEQOVvMO08vf1w4QKk2HUqdFNuzbOX.aI4FlA5S', 'mts1@mts1.mts1', 'mts1', 'mts1', NULL, b'1', 1, '2023-10-18 22:05:52');







------------------------------
-- PARA SA MGA INDEX NG TABLE
------------------------------

ALTER TABLE `tbl_activitylogs`
  ADD PRIMARY KEY (`ActivityLogs_Id`);

ALTER TABLE `tbl_actorcategory`
  ADD PRIMARY KEY (`ActorCategory_Id`);

ALTER TABLE `tbl_authentications`
  ADD PRIMARY KEY (`Account_Address`);

ALTER TABLE `tbl_campus`
  ADD PRIMARY KEY (`Campus_Id`);

ALTER TABLE `tbl_card`
  ADD PRIMARY KEY (`Card_Id`),
  ADD UNIQUE KEY `Card_Address` (`Card_Address`),
  ADD UNIQUE KEY `UsersAccount_Address` (`UsersAccount_Address`),
  ADD KEY `Campus_Id` (`Campus_Id`);

ALTER TABLE `tbl_configurations`
  ADD PRIMARY KEY (`Configuration_Id`);

ALTER TABLE `tbl_guardianaccount`
  ADD PRIMARY KEY (`GuardianAccount_Address`),
  ADD KEY `UsersAccount_Address` (`UsersAccount_Address`),
  ADD KEY `ActorCategory_Id` (`ActorCategory_Id`),
  ADD KEY `Campus_Id` (`Campus_Id`);

ALTER TABLE `tbl_itemscategory`
  ADD PRIMARY KEY (`ItemsCategory_Id`),
  ADD KEY `MerchantsCategory_Id` (`MerchantsCategory_Id`);

ALTER TABLE `tbl_loginhistory`
  ADD PRIMARY KEY (`Account_Address`,`IpAddress`,`Location`,`Device`) USING BTREE,
  ADD UNIQUE KEY `unique_loginhistory` (`Account_Address`,`IpAddress`,`Location`,`Device`);

ALTER TABLE `tbl_merchantitems`
  ADD PRIMARY KEY (`MerchantItems_Id`),
  ADD KEY `MerchantsCategory_Id` (`MerchantsCategory_Id`),
  ADD KEY `ItemsCategory_Id` (`ItemsCategory_Id`);

ALTER TABLE `tbl_merchants`
  ADD PRIMARY KEY (`WebAccounts_Address`),
  ADD KEY `MerchantsCategory_Id` (`MerchantsCategory_Id`);

ALTER TABLE `tbl_merchantscategory`
  ADD PRIMARY KEY (`MerchantsCategory_Id`),
  ADD KEY `Campus_Id` (`Campus_Id`);

ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Creator_Account_Address` (`Creator_Account_Address`);

ALTER TABLE `tbl_remittance`
  ADD PRIMARY KEY (`Remittance_Id`),
  ADD KEY `Submitted_By` (`Submitted_By`);

ALTER TABLE `tbl_transactionitems`
  ADD PRIMARY KEY (`Transaction_Address`,`MerchantItems_Id`) USING BTREE,
  ADD KEY `MerchantItems_Id` (`MerchantItems_Id`);

ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`Transaction_Address`,`Account_Address`) USING BTREE,
  ADD UNIQUE KEY `Transaction_Address` (`Transaction_Address`,`Account_Address`),
  ADD KEY `Remittance_Id` (`Remittance_Id`);

ALTER TABLE `tbl_transactionsinfo`
  ADD PRIMARY KEY (`Transaction_Address`),
  ADD KEY `TransactionType_Id` (`TransactionType_Id`);

ALTER TABLE `tbl_transactiontype`
  ADD PRIMARY KEY (`TransactionType_Id`);

ALTER TABLE `tbl_usersaccount`
  ADD PRIMARY KEY (`UsersAccount_Address`),
  ADD KEY `ActorCategory_Id` (`ActorCategory_Id`),
  ADD KEY `Campus_Id` (`Campus_Id`);

ALTER TABLE `tbl_usersdata`
  ADD PRIMARY KEY (`UsersAccount_Address`),
  ADD KEY `GuardianAccount_Address` (`GuardianAccount_Address`);

ALTER TABLE `tbl_webaccounts`
  ADD PRIMARY KEY (`WebAccounts_Address`),
  ADD KEY `ActorCategory_Id` (`ActorCategory_Id`),
  ADD KEY `Campus_Id` (`Campus_Id`);

ALTER TABLE `tbl_whitelist`
  ADD PRIMARY KEY (`Account_Address`),
  ADD KEY `Whitelisted_Address` (`Whitelisted_Address`);





-------------------------
-- PARA SA AUTO INCREMENT
-------------------------

ALTER TABLE `tbl_activitylogs`
  MODIFY `ActivityLogs_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

ALTER TABLE `tbl_actorcategory`
  MODIFY `ActorCategory_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `tbl_campus`
  MODIFY `Campus_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tbl_card`
  MODIFY `Card_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `tbl_configurations`
  MODIFY `Configuration_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tbl_itemscategory`
  MODIFY `ItemsCategory_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tbl_merchantitems`
  MODIFY `MerchantItems_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `tbl_merchantscategory`
  MODIFY `MerchantsCategory_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `tbl_notifications`
  MODIFY `Notification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tbl_remittance`
  MODIFY `Remittance_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tbl_transactiontype`
  MODIFY `TransactionType_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;





-------------------------
-- PARA SA FOREIGN KEYS
-------------------------

ALTER TABLE `tbl_card`
  ADD CONSTRAINT `tbl_card_ibfk_1` FOREIGN KEY (`UsersAccount_Address`) REFERENCES `tbl_usersdata` (`UsersAccount_Address`),
  ADD CONSTRAINT `tbl_card_ibfk_2` FOREIGN KEY (`Campus_Id`) REFERENCES `tbl_campus` (`Campus_Id`);

ALTER TABLE `tbl_guardianaccount`
  ADD CONSTRAINT `tbl_guardianaccount_ibfk_1` FOREIGN KEY (`UsersAccount_Address`) REFERENCES `tbl_usersdata` (`UsersAccount_Address`),
  ADD CONSTRAINT `tbl_guardianaccount_ibfk_2` FOREIGN KEY (`ActorCategory_Id`) REFERENCES `tbl_actorcategory` (`ActorCategory_Id`),
  ADD CONSTRAINT `tbl_guardianaccount_ibfk_3` FOREIGN KEY (`Campus_Id`) REFERENCES `tbl_campus` (`Campus_Id`);

ALTER TABLE `tbl_itemscategory`
  ADD CONSTRAINT `tbl_itemscategory_ibfk_1` FOREIGN KEY (`MerchantsCategory_Id`) REFERENCES `tbl_merchantscategory` (`MerchantsCategory_Id`);

ALTER TABLE `tbl_merchantitems`
  ADD CONSTRAINT `tbl_merchantitems_ibfk_1` FOREIGN KEY (`MerchantsCategory_Id`) REFERENCES `tbl_merchantscategory` (`MerchantsCategory_Id`),
  ADD CONSTRAINT `tbl_merchantitems_ibfk_2` FOREIGN KEY (`ItemsCategory_Id`) REFERENCES `tbl_itemscategory` (`ItemsCategory_Id`);

ALTER TABLE `tbl_merchants`
  ADD CONSTRAINT `tbl_merchants_ibfk_1` FOREIGN KEY (`WebAccounts_Address`) REFERENCES `tbl_webaccounts` (`WebAccounts_Address`),
  ADD CONSTRAINT `tbl_merchants_ibfk_2` FOREIGN KEY (`MerchantsCategory_Id`) REFERENCES `tbl_merchantscategory` (`MerchantsCategory_Id`);

ALTER TABLE `tbl_merchantscategory`
  ADD CONSTRAINT `tbl_merchantscategory_ibfk_1` FOREIGN KEY (`Campus_Id`) REFERENCES `tbl_campus` (`Campus_Id`);

ALTER TABLE `tbl_notifications`
  ADD CONSTRAINT `tbl_notifications_ibfk_1` FOREIGN KEY (`Creator_Account_Address`) REFERENCES `tbl_webaccounts` (`WebAccounts_Address`);

ALTER TABLE `tbl_remittance`
  ADD CONSTRAINT `tbl_remittance_ibfk_1` FOREIGN KEY (`Submitted_By`) REFERENCES `tbl_webaccounts` (`WebAccounts_Address`);

ALTER TABLE `tbl_transactionitems`
  ADD CONSTRAINT `tbl_transactionitems_ibfk_1` FOREIGN KEY (`MerchantItems_Id`) REFERENCES `tbl_merchantitems` (`MerchantItems_Id`),
  ADD CONSTRAINT `tbl_transactionitems_ibfk_2` FOREIGN KEY (`Transaction_Address`) REFERENCES `tbl_transactionsinfo` (`Transaction_Address`);

ALTER TABLE `tbl_transactions`
  ADD CONSTRAINT `tbl_transactions_ibfk_1` FOREIGN KEY (`Remittance_Id`) REFERENCES `tbl_remittance` (`Remittance_Id`);

ALTER TABLE `tbl_transactionsinfo`
  ADD CONSTRAINT `tbl_transactionsinfo_ibfk_1` FOREIGN KEY (`TransactionType_Id`) REFERENCES `tbl_transactiontype` (`TransactionType_Id`);

ALTER TABLE `tbl_usersaccount`
  ADD CONSTRAINT `tbl_usersaccount_ibfk_1` FOREIGN KEY (`ActorCategory_Id`) REFERENCES `tbl_actorcategory` (`ActorCategory_Id`),
  ADD CONSTRAINT `tbl_usersaccount_ibfk_2` FOREIGN KEY (`Campus_Id`) REFERENCES `tbl_campus` (`Campus_Id`);

ALTER TABLE `tbl_usersdata`
  ADD CONSTRAINT `tbl_usersdata_ibfk_1` FOREIGN KEY (`GuardianAccount_Address`) REFERENCES `tbl_guardianaccount` (`GuardianAccount_Address`);

ALTER TABLE `tbl_webaccounts`
  ADD CONSTRAINT `tbl_webaccounts_ibfk_1` FOREIGN KEY (`ActorCategory_Id`) REFERENCES `tbl_actorcategory` (`ActorCategory_Id`),
  ADD CONSTRAINT `tbl_webaccounts_ibfk_2` FOREIGN KEY (`Campus_Id`) REFERENCES `tbl_campus` (`Campus_Id`);

ALTER TABLE `tbl_whitelist`
  ADD CONSTRAINT `tbl_whitelist_ibfk_1` FOREIGN KEY (`Account_Address`) REFERENCES `tbl_usersaccount` (`UsersAccount_Address`),
  ADD CONSTRAINT `tbl_whitelist_ibfk_2` FOREIGN KEY (`Whitelisted_Address`) REFERENCES `tbl_usersaccount` (`UsersAccount_Address`);

COMMIT;
