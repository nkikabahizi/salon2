-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 12:06 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminId` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `AccountStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminId`, `FullName`, `Location`, `Contact`, `Email`, `Username`, `Password`, `AccountStatus`) VALUES
(1, 'NKIKABAHIZI Kenny', 'Kigali-Kicukiro-Sonatube', '0789876553', 'kenny@gmail.com', 'kenny', '202cb962ac59075b964b07152d234b70', '1');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `BillingId` int(11) NOT NULL,
  `ServiceId` int(11) NOT NULL,
  `ServiceFee` int(11) NOT NULL,
  `TotalProducts` double DEFAULT NULL,
  `EmployeeId` int(11) DEFAULT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `Description` varchar(45) DEFAULT NULL,
  `SalonId` int(11) NOT NULL,
  `Dates` varchar(255) NOT NULL,
  `Day` varchar(255) NOT NULL,
  `Mon` varchar(255) NOT NULL,
  `Year` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL,
  `DateBill` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`BillingId`, `ServiceId`, `ServiceFee`, `TotalProducts`, `EmployeeId`, `CustomerId`, `Description`, `SalonId`, `Dates`, `Day`, `Mon`, `Year`, `Status`, `DateBill`) VALUES
(15, 1, 1000, 2200, 2, 4, ' Bill descriptions                           ', 1, '07-04-2023', '07', '04', '2023', 1, '2023-04-07 18:51:12'),
(16, 1, 1000, 1200, 0, 0, ' ', 1, '09-04-2023', '09', '04', '2023', 0, '2023-04-09 11:32:59'),
(17, 1, 1000, 1200, 0, 0, ' ', 1, '09-04-2023', '09', '04', '2023', 0, '2023-04-09 11:35:13'),
(18, 1, 1000, 1000, 8, 1, 'Describe about the bill                      ', 1, '09-04-2023', '09', '04', '2023', 0, '2023-04-09 11:42:33'),
(19, 1, 1000, 1200, 0, 0, ' ', 1, '09-04-2023', '09', '04', '2023', 0, '2023-04-09 11:59:21'),
(20, 1, 1000, 1200, 0, 0, ' ', 1, '09-04-2023', '09', '04', '2023', 0, '2023-04-09 11:59:45'),
(21, 1, 1000, 1200, 8, 1, '                                             ', 1, '09-04-2023', '09', '04', '2023', 0, '2023-04-09 11:59:54'),
(22, 1, 1000, 2200, 8, 4, '  Test bills                                 ', 1, '09-04-2023', '10', '04', '2023', 0, '2023-04-09 12:49:56'),
(23, 1, 1000, 1200, 1, 3, 'Some description about new bill              ', 1, '09-04-2023', '10', '04', '2023', 1, '2023-04-09 12:51:08'),
(24, 5, 2000, 2200, 9, 3, 'New bill here                                ', 1, '10-04-2023', '10', '04', '2023', 1, '2023-04-10 14:16:29'),
(25, 2, 4000, 2200, 8, 6, ' new bill                                    ', 1, '11-04-2023', '11', '04', '2023', 1, '2023-04-11 14:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `billinginfo`
--

CREATE TABLE `billinginfo` (
  `BillinginfoId` int(11) NOT NULL,
  `BillingId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billinginfo`
--

INSERT INTO `billinginfo` (`BillinginfoId`, `BillingId`, `ProductId`, `Quantity`) VALUES
(28, 15, 1, 1),
(29, 15, 2, 1),
(30, 16, 1, 1),
(31, 17, 1, 2),
(32, 18, 2, 10),
(33, 21, 1, 1),
(34, 22, 1, 1),
(35, 22, 2, 1),
(36, 23, 1, 1),
(37, 24, 1, 1),
(38, 24, 2, 3),
(39, 25, 1, 2),
(40, 25, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `ContractId` int(11) NOT NULL,
  `Tittle` varchar(45) DEFAULT NULL,
  `Length` varchar(45) DEFAULT NULL,
  `PaymentFrequency` int(11) NOT NULL,
  `StartingDate` date NOT NULL,
  `EndingDates` date NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `JobPercentage` decimal(10,0) NOT NULL,
  `cancelreason` text DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`ContractId`, `Tittle`, `Length`, `PaymentFrequency`, `StartingDate`, `EndingDates`, `EmployeeId`, `JobPercentage`, `cancelreason`, `status`) VALUES
(3, 'New contract for one year', '', 15, '2023-04-13', '2023-04-29', 8, '12', '', 1),
(4, 'NEW CONTRACT', '', 15, '2023-04-13', '2023-04-12', 1, '10', '', 1),
(5, 'New contract for testing', '1', 15, '2023-04-08', '2023-04-09', 8, '10', '', 1),
(6, 'NEW CONTRACT HERE WE GO', '21', 30, '2023-04-09', '2023-04-30', 8, '23', '', 1),
(7, 'NEW CONTRACT HERE WE GO', '21', 30, '2023-04-09', '2023-04-30', 8, '23', '', 1),
(8, 'Contract', '50', 15, '2023-04-09', '2023-05-29', 2, '20', 'no specifi reason', 0),
(9, 'New contract ', '81', 30, '2023-04-10', '2023-06-30', 1, '12', '', 1),
(10, 'New nail designer contract', '111', 15, '2023-04-10', '2023-07-30', 9, '13', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerId` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `PhoneNumber` varchar(255) NOT NULL,
  `SalonId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreationDates` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerId`, `fullName`, `PhoneNumber`, `SalonId`, `Status`, `CreationDates`) VALUES
(1, 'MANZI Quen', '07886546787', 1, 1, '2023-04-11 10:58:31'),
(2, 'MANZI Quen', '07886546787', 1, 1, '2023-04-11 10:58:31'),
(3, 'MANZI Quen', '07886546787', 1, 1, '2023-04-11 10:58:31'),
(4, 'MANZI Quen', '07886546787', 1, 1, '2023-04-11 10:58:31'),
(5, 'MANZI Quen', '07886546787', 1, 1, '2023-04-11 11:09:16'),
(6, 'ISHIMWE Fabrice', '0789863474', 1, 1, '2023-04-11 14:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `DeductionId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Day` varchar(255) NOT NULL,
  `Mon` varchar(255) NOT NULL,
  `Year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`DeductionId`, `EmployeeId`, `Amount`, `Description`, `Day`, `Mon`, `Year`) VALUES
(1, 9, '0', 'Coming late to job', '08', '04', '2023'),
(2, 2, '0', 'Deduction just', '08', '04', '2023'),
(3, 4, '2000', 'Description of the fault', '08', '04', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeId` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Contacts` varchar(45) NOT NULL,
  `IdNumber` varchar(255) NOT NULL,
  `Poste` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `UserId` int(11) NOT NULL,
  `SalonId` int(11) NOT NULL,
  `CreationDates` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeId`, `FullName`, `Location`, `Contacts`, `IdNumber`, `Poste`, `Description`, `UserId`, `SalonId`, `CreationDates`) VALUES
(1, 'NKIKABAHIZI Kenny', 'Kicukiro - kagaramaaaa', '078987647', '120008008765456', 'Hair dresser', 'Permanent employee\r\n                                                                                                                                                                                                                                                                                                                                                ', 1, 1, '2023-03-31 09:51:22'),
(2, 'NKIKABAHIZI Kenny', 'Kicukiro - kagaramaaaa', '078987647', '120008008765456', 'Hair dresser', 'Permanent employee\r\n                                                                                                                                                                                                                                                                                                                                                ', 1, 1, '2023-03-31 10:05:07'),
(3, 'NKIKABAHIZI Kenny', 'Kicukiro - kagaramaaaa', '078987647', '120008008765456', 'Hair dresser', 'Permanent employee\r\n                                                                                                                                                                                                                                                                                                                                                ', 1, 1, '2023-03-31 10:05:48'),
(4, 'NKIKABAHIZI Kenny', 'Kicukiro - kagaramaaaa', '078987647', '120008008765456', 'Hair dresser', 'Permanent employee\r\n                                                                                                                                                                                                                                                                                                                                                ', 1, 1, '2023-03-31 10:31:06'),
(5, 'NKIKABAHIZI Kenny', 'Kicukiro - kagaramaaaa', '078987647', '120008008765456', 'Hair dresser', 'Permanent employee\r\n                                                                                                                                                                                                                                                                                                                                                ', 1, 1, '2023-03-31 11:38:53'),
(8, 'KABANDA Gregory', 'Kicukiro - sonatube', '07898746532', '112000886567445', 'Make up specialist', 'New employee for make up designs', 1, 1, '2023-04-08 11:24:27'),
(9, 'MUGISHA Gedeon', 'Kigali - Kinyinya', '07865543343', '120009847485444', 'Nail dresser', 'New nail designer ', 1, 1, '2023-04-10 14:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `LoanId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `PercentagePayment` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Day` varchar(255) NOT NULL,
  `Mon` varchar(255) NOT NULL,
  `Year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`LoanId`, `EmployeeId`, `Amount`, `PercentagePayment`, `Description`, `Day`, `Mon`, `Year`) VALUES
(1, 9, '4500', '10', 'Salary in advance', '12', '04', '2023'),
(2, 5, '200', '15', 'New loan', '08', '04', '2023'),
(3, 5, '200', '10', 'New loan for starting the job', '08', '04', '2023'),
(4, 3, '5000', '12', 'Avance sur salaire', '08', '04', '2023'),
(5, 3, '5000', '5', 'Avance sur salaire', '08', '04', '2023'),
(6, 3, '5000', '10', 'Avance sur salaire', '08', '04', '2023'),
(7, 1, '5000', '12', 'Loan for renting a house while at job', '11', '04', '2023'),
(8, 1, '4400', '12', 'Loan for renting a house while at job', '11', '04', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `PayId` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Dates` varchar(255) NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `EmployeesNumber` varchar(255) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Month` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`PayId`, `Description`, `Dates`, `Amount`, `EmployeesNumber`, `UserId`, `Month`) VALUES
(14, 'something over here', '2023-04-11', '1000', '', 0, ''),
(15, 'First payouts in a while', '2023-04-11', '1000', '4', 1, ''),
(16, 'Secondpayouts in a while', '2023-04-11', '500', '2', 1, '04'),
(17, 'New salary with no deductions and loand computed', '2023-04-11', '500', '2', 1, '04'),
(18, 'New salary with no deductions and loand computed', '2023-04-11', '0', '4', 1, '04'),
(19, '', '2023-04-11', '120240', '2', 1, '04'),
(20, 'last month salary', '2023-04-11', '120240', '2', 1, '04');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Manufacture` varchar(255) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `ExampleProfile` varchar(45) NOT NULL,
  `Quantity` varchar(45) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `SalonId` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `UpdationDates` varchar(255) NOT NULL,
  `CreationDates` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `Name`, `Category`, `Manufacture`, `Price`, `ExampleProfile`, `Quantity`, `Description`, `SalonId`, `Status`, `UpdationDates`, `CreationDates`) VALUES
(1, 'Kerast', 'Make up', 'Kerasta ltd', 1200, 'kerastase_main.jpg', '10', '																																																																Best black champo from makdamia ltd																																																																							', 1, 'In Stock', '02-04-2023 11:09:21 PM', '2023-03-31 17:48:46'),
(2, 'Massage Rotion', 'Oils', 'Jiggle', 1000, 'schwarzkopf_main.jpg', '19', '												Muscle relaxing rotion for massage																				', 1, 'In Stock', '02-04-2023 11:05:01 PM', '2023-04-02 07:59:03'),
(3, '', '', '', 0, '', '', '', 1, '', '11-04-2023 01:15:26 PM', '2023-04-11 11:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `PurchaseId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `UnitPrice` double NOT NULL,
  `Description` text NOT NULL,
  `SalonId` int(11) NOT NULL,
  `PurchaseDates` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`PurchaseId`, `ProductId`, `Quantity`, `UnitPrice`, `Description`, `SalonId`, `PurchaseDates`) VALUES
(1, 4, 1, 300, 'description', 1, '2023-04-02 19:40:12'),
(2, 5, 2, 300, 'description', 1, '2023-04-02 19:40:12'),
(3, 3, 1, 300, 'description', 1, '2023-04-02 19:40:55'),
(4, 2, 2, 300, 'description', 1, '2023-04-02 19:40:55'),
(5, 1, 5, 300, 'description', 1, '2023-04-02 19:41:40'),
(6, 2, 1, 300, 'description', 1, '2023-04-02 19:41:40'),
(7, 1, 1, 0, 'description', 1, '2023-04-02 19:42:43'),
(8, 2, 1, 0, 'description', 1, '2023-04-02 19:42:43'),
(9, 1, 4, 1000, 'description', 1, '2023-04-02 19:43:40'),
(10, 2, 4, 1000, 'description', 1, '2023-04-02 19:43:40'),
(11, 11200, 1, 1000, 'description', 1, '2023-04-02 19:48:23'),
(12, 21000, 1, 1000, 'description', 1, '2023-04-02 19:48:23'),
(13, 1, 1, 1000, 'description', 1, '2023-04-02 19:49:15'),
(14, 2, 1, 1000, 'description', 1, '2023-04-02 19:49:15'),
(15, 1, 1, 0, 'description', 1, '2023-04-02 19:52:16'),
(16, 2, 1, 0, 'description', 1, '2023-04-02 19:52:16'),
(17, 1, 1, 0, 'description', 1, '2023-04-02 19:52:38'),
(18, 2, 5, 0, 'description', 1, '2023-04-02 19:52:38'),
(19, 1, 1, 0, 'description', 1, '2023-04-02 20:10:13'),
(20, 2, 1, 0, 'description', 1, '2023-04-02 20:10:13'),
(21, 1, 10, 0, 'No more description', 1, '2023-04-02 21:21:48'),
(22, 2, 1, 0, 'No more description', 1, '2023-04-02 21:21:48'),
(23, 2, 10, 0, 'fgh', 1, '2023-04-02 21:22:45'),
(24, 1, 10, 1200, 'hhhh', 1, '2023-04-02 21:26:03'),
(25, 2, 1, 1000, 'hhhh', 1, '2023-04-02 21:26:03'),
(26, 1, 10, 1200, 'mmmm', 1, '2023-04-02 21:28:12'),
(27, 2, 1, 1000, 'mmmm', 1, '2023-04-02 21:28:12'),
(28, 1, 10, 1200, 'new stock upgrade', 1, '2023-04-02 21:29:08'),
(29, 2, 1, 1000, 'new stock upgrade', 1, '2023-04-02 21:29:08'),
(30, 1, 1, 1200, 'dddd', 1, '2023-04-02 21:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Id` int(11) NOT NULL,
  `Dates` date NOT NULL,
  `Description` varchar(255) NOT NULL,
  `BillinginfoId` int(11) NOT NULL,
  `BillingId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `SalaryId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `FromDate` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`SalaryId`, `EmployeeId`, `Amount`, `FromDate`, `Status`) VALUES
(1, 2, '0', '', 0),
(2, 3, '0', '', 0),
(3, 5, '150', '', 0),
(4, 5, '150', '', 0),
(5, 2, '0', '', 0),
(6, 8, '120', '', 0),
(7, 8, '120', '', 0),
(8, 8, '120', '', 0),
(9, 8, '1500', '', 0),
(12, 1, '240', '2023-03-20', 0),
(13, 9, '120000', '2023-03-20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `salon`
--

CREATE TABLE `salon` (
  `SalonId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Contacts` varchar(255) NOT NULL,
  `CreationTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salon`
--

INSERT INTO `salon` (`SalonId`, `Name`, `Location`, `Description`, `Contacts`, `CreationTime`) VALUES
(1, 'KEZA Salon', 'Kicukiro - Sonatube', '', '', '2023-03-31 09:22:05'),
(2, 'LA FRESHEUR SALON', 'Kigali - Kinyinya', 'New salon registered on sytem																								', '0789846452', '2023-04-11 21:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceId` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Category` varchar(255) DEFAULT NULL,
  `Price` double NOT NULL,
  `Description` text DEFAULT NULL,
  `ExampleProfile` varchar(255) NOT NULL,
  `SalonId` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceId`, `Name`, `Category`, `Price`, `Description`, `ExampleProfile`, `SalonId`, `Status`) VALUES
(1, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(2, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(3, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(4, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(5, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'afrocut.jpg', 1, 'Available'),
(6, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(7, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(8, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(9, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(10, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(11, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available'),
(12, 'Makdamia', 'Champo', 1000, '                                                                         Description of the service here                                                                                                                                                                       ', 'download.jpg', 1, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Contact` varchar(45) DEFAULT NULL,
  `Location` varchar(255) NOT NULL,
  `Role` varchar(45) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `SalonId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreationDates` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `FullName`, `Email`, `Contact`, `Location`, `Role`, `UserName`, `Password`, `SalonId`, `Status`, `CreationDates`) VALUES
(1, 'UMUKUNZI Elysee', 'elysee@gmail.com', '0789817969', 'Muhanga', 'Manager', 'elysee', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, '2023-03-31 08:23:59'),
(2, 'ISHIMWE Kabayiza Jimm', 'jimmy@gmail.com', '07898765563', 'Kicukiro - Sonatube', 'System Admin', 'jimmy', '202cb962ac59075b964b07152d234b70', 1, 1, '2023-04-11 21:38:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminId`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`BillingId`);

--
-- Indexes for table `billinginfo`
--
ALTER TABLE `billinginfo`
  ADD PRIMARY KEY (`BillinginfoId`),
  ADD KEY `ProductId` (`ProductId`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`ContractId`),
  ADD KEY `EmployeeId` (`EmployeeId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerId`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`DeductionId`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`LoanId`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`PayId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PurchaseId`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `BillingId` (`BillingId`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`SalaryId`);

--
-- Indexes for table `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`SalonId`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `BillingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `billinginfo`
--
ALTER TABLE `billinginfo`
  MODIFY `BillinginfoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `ContractId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `DeductionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `LoanId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `PayId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `PurchaseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `SalaryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `salon`
--
ALTER TABLE `salon`
  MODIFY `SalonId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billinginfo`
--
ALTER TABLE `billinginfo`
  ADD CONSTRAINT `billinginfo_ibfk_3` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`);

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`EmployeeId`) REFERENCES `employees` (`EmployeeId`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`BillingId`) REFERENCES `billing` (`BillingId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
