-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2018 at 09:21 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sthlive17`
--

-- --------------------------------------------------------

--
-- Table structure for table `debtors_invoice`
--

CREATE TABLE IF NOT EXISTS `debtors_invoice` (
  `auto_number` int(255) NOT NULL,
  `companyanum` int(255) NOT NULL,
  `billnumber` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `itemname` text COLLATE latin1_general_ci NOT NULL,
  `itemdescription` text COLLATE latin1_general_ci NOT NULL,
  `unit_abbreviation` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `rate` decimal(13,2) NOT NULL,
  `quantity` decimal(13,4) NOT NULL,
  `subtotal` decimal(13,2) NOT NULL,
  `totalamount` decimal(13,2) NOT NULL,
  `coa` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `recordstatus` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `locationname` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `locationcode` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ipaddress` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `entrydate` date NOT NULL,
  `accountname` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `accountcode` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `currency` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `fxrate` decimal(13,2) NOT NULL,
  `fxamount` decimal(13,2) NOT NULL,
  `fxpkrate` decimal(13,2) NOT NULL,
  `fxtotamount` decimal(13,2) NOT NULL,
  `remarks` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `debtors_invoice`
--

INSERT INTO `debtors_invoice` (`auto_number`, `companyanum`, `billnumber`, `itemname`, `itemdescription`, `unit_abbreviation`, `rate`, `quantity`, `subtotal`, `totalamount`, `coa`, `recordstatus`, `locationname`, `locationcode`, `username`, `ipaddress`, `entrydate`, `accountname`, `accountcode`, `currency`, `fxrate`, `fxamount`, `fxpkrate`, `fxtotamount`, `remarks`) VALUES
(1, 1, 'DBI-1', 'INTERNET SERVICES ', '', '', '8000.00', '1.0000', '8000.00', '8000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-01-22', 'KATHITA KIIRUA WATER PROJECT', '05-5029', 'KSHS', '1.00', '1.00', '8000.00', '8000.00', ''),
(2, 1, 'DBI-2', 'ANTIRABIES VACCINE 5 AMP', '', '', '5.00', '1100.0000', '5500.00', '5500.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-02-09', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '5.00', '5500.00', ''),
(3, 1, 'DBI-3', 'ANTIRABIES  VACCINE ', '', '', '1100.00', '5.0000', '5500.00', '5500.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'mmunene', '192.168.137.21', '2018-02-09', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '1100.00', '5500.00', ''),
(4, 1, 'DBI-4', 'INTERNET FEE FEB', '', '', '8000.00', '1.0000', '8000.00', '8000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-02-28', 'KATHITA KIIRUA WATER PROJECT', '05-5029', 'KSHS', '1.00', '1.00', '8000.00', '8000.00', ''),
(5, 1, 'DBI-5', 'INTERNET FEE FOR MARCH 2018', '', '', '8000.00', '1.0000', '8000.00', '8000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'KATHITA KIIRUA WATER PROJECT', '05-5029', 'KSHS', '1.00', '1.00', '8000.00', '8000.00', ''),
(6, 1, 'DBI-6', 'SHOP RENT FOR JAN 2018', '', '', '4000.00', '1.0000', '4000.00', '4000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'LITTLE FLOWER SHOP', '07-7709-01', 'KSHS', '1.00', '1.00', '4000.00', '4000.00', ''),
(7, 1, 'DBI-6', 'SHOP RENT FEB 2018', '', '', '4000.00', '1.0000', '4000.00', '4000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'LITTLE FLOWER SHOP', '07-7709-01', 'KSHS', '1.00', '1.00', '4000.00', '4000.00', ''),
(8, 1, 'DBI-7', 'CAFE RENT  - JAN 2018', '', '', '10000.00', '1.0000', '10000.00', '10000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'LITTLE ANGELS CAFE', '05-5137-01', 'KSHS', '1.00', '1.00', '10000.00', '10000.00', ''),
(9, 1, 'DBI-7', 'CAFE RENT - FEB 2018', '', '', '10000.00', '1.0000', '10000.00', '10000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'LITTLE ANGELS CAFE', '05-5137-01', 'KSHS', '1.00', '1.00', '10000.00', '10000.00', ''),
(10, 1, 'DBI-7', 'ELECTRICITY BILL JAN 2018', '', '', '11312.00', '1.0000', '11312.00', '11312.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'LITTLE ANGELS CAFE', '05-5137-01', 'KSHS', '1.00', '1.00', '11312.00', '11312.00', ''),
(11, 1, 'DBI-7', 'ELECTRICITY BILL FEB 2018', '', '', '7872.00', '1.0000', '7872.00', '7872.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-08', 'LITTLE ANGELS CAFE', '05-5137-01', 'KSHS', '1.00', '1.00', '7872.00', '7872.00', ''),
(12, 1, 'DBI-8', 'CAFETERIA RENT FOR JAN AND FEB 2018', '', '', '10000.00', '2.0000', '20000.00', '20000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-03-19', 'LITTLE ANGELS CAFE', '05-5137-01', 'KSHS', '1.00', '1.00', '10000.00', '20000.00', ''),
(13, 1, 'DBI-9', 'MEDICAL BILLS', '', '', '296712.00', '1.0000', '296712.00', '296712.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'mmunene', '192.168.137.11', '2018-02-28', 'WORLD VISION- GALBATURA', '05-5041', 'KSHS', '1.00', '1.00', '296712.00', '296712.00', ''),
(14, 1, 'DBI-10', '2ND  QUARTER YEAR 2018 NATIONAL SCHEME CAPITATION', '', '', '8294300.00', '1.0000', '8294300.00', '8294300.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-04-16', 'NHIF -NATIONAL SCHEME CAPITATION', '05-5160-01', 'KSHS', '1.00', '1.00', '8294300.00', '8294300.00', ''),
(15, 1, 'DBI-11', '2ND  QUARTER YEAR 2018 CIVIL SERVANT  CAPITATION', '', '', '712.50', '1698.0000', '1209825.00', '1209825.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-04-16', 'NHIF -CIVIL SERVANT CAPITATION', '05-5159-01', 'KSHS', '1.00', '1.00', '712.50', '1209825.00', ''),
(16, 1, 'DBI-12', '2ND  QUARTER YEAR 2018 HISP CAPITATION', '', '', '352800.00', '1.0000', '352800.00', '352800.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-04-16', 'NHIF-HISP(HOSPITAL INSURANCE SPONSORED PROGRAMME)', '05-5083-01', 'KSHS', '1.00', '1.00', '352800.00', '352800.00', ''),
(17, 1, 'DBI-13', '1ST QUARTER CIVIL SERVANTS CAPITATION', '', '', '712.50', '1632.0000', '1162800.00', '1162800.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-01-10', 'NHIF -CIVIL SERVANT CAPITATION', '05-5159-01', 'KSHS', '1.00', '1.00', '712.50', '1162800.00', ''),
(18, 1, 'DBI-14', 'PAYROLL FOR JAN 2018', '', '', '414930.00', '1.0000', '414930.00', '414930.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-05-09', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '414930.00', '414930.00', ''),
(19, 1, 'DBI-14', 'PAYROLL FOR FEB 2018', '', '', '461478.00', '1.0000', '461478.00', '461478.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-05-09', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '461478.00', '461478.00', ''),
(20, 1, 'DBI-14', 'PAYROLL FOR MARCH 2018', '', '', '454296.00', '1.0000', '454296.00', '454296.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-05-09', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '454296.00', '454296.00', ''),
(21, 1, 'DBI-14', 'PAYROLL FOR APRIL 2018', '', '', '452023.00', '1.0000', '452023.00', '452023.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.95', '2018-05-09', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '452023.00', '452023.00', ''),
(22, 1, 'DBI-15', 'INTERNET  INCOME - MAY', '', '', '8000.00', '1.0000', '8000.00', '8000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-05-01', 'KATHITA KIIRUA WATER PROJECT', '05-5029', 'KSHS', '1.00', '1.00', '8000.00', '8000.00', ''),
(23, 1, 'DBI-16', 'MAY 2018 SALARIES ', '', '', '271871.00', '1.0000', '271871.00', '271871.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-05-31', 'TIMAU CATHOLIC DISPENSARY', '07-7177', 'KSHS', '1.00', '1.00', '271871.00', '271871.00', ''),
(24, 1, 'DBI-17', 'APRIL 2018 SALARY', '', '', '268666.00', '1.0000', '268666.00', '268666.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-04-30', 'TIMAU CATHOLIC DISPENSARY', '07-7177', 'KSHS', '1.00', '1.00', '268666.00', '268666.00', ''),
(25, 1, 'DBI-18', 'MARCH 2018 SALARY', '', '', '264335.00', '1.0000', '264335.00', '264335.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-03-31', 'TIMAU CATHOLIC DISPENSARY', '07-7177', 'KSHS', '1.00', '1.00', '264335.00', '264335.00', ''),
(26, 1, 'DBI-19', 'FEBRUARY 2018 SALARY', '', '', '275475.00', '1.0000', '275475.00', '275475.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-02-28', 'TIMAU CATHOLIC DISPENSARY', '07-7177', 'KSHS', '1.00', '1.00', '275475.00', '275475.00', ''),
(27, 1, 'DBI-20', 'JANUARY 2018 SALARY', '', '', '272132.00', '1.0000', '272132.00', '272132.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-01-31', 'TIMAU CATHOLIC DISPENSARY', '07-7177', 'KSHS', '1.00', '1.00', '272132.00', '272132.00', ''),
(28, 1, 'DBI-21', 'MAY 2018 SALARY', '', '', '434055.00', '1.0000', '434055.00', '434055.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-05-31', 'TRAME AFRICANE', '05-5031', 'KSHS', '1.00', '1.00', '434055.00', '434055.00', ''),
(29, 1, 'DBI-22', 'MARCH 2018 SALARY', '', '', '157479.00', '1.0000', '157479.00', '157479.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-03-31', 'ST THERESE HOUSE OF HOPE', '05-5163', 'KSHS', '1.00', '1.00', '157479.00', '157479.00', ''),
(30, 1, 'DBI-23', 'APRIL 2018 SALARY ', '', '', '168179.00', '1.0000', '168179.00', '168179.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-04-30', 'ST THERESE HOUSE OF HOPE', '05-5163', 'KSHS', '1.00', '1.00', '168179.00', '168179.00', ''),
(31, 1, 'DBI-24', 'MAY 2018 SALARY', '', '', '186348.00', '1.0000', '186348.00', '186348.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-05-31', 'ST THERESE HOUSE OF HOPE', '05-5163', 'KSHS', '1.00', '1.00', '186348.00', '186348.00', ''),
(32, 1, 'DBI-25', 'MARCH 2018 PAYROLL', '', '', '53399.00', '1.0000', '53399.00', '53399.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-03-31', 'M.M ZANELLI FORMATION HOUSE KAREN', '05-5131-01', 'KSHS', '1.00', '1.00', '53399.00', '53399.00', ''),
(33, 1, 'DBI-26', 'APRIL 2018 PAYROLL', '', '', '40744.00', '1.0000', '40744.00', '40744.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-04-30', 'M.M ZANELLI FORMATION HOUSE KAREN', '05-5131-01', 'KSHS', '1.00', '1.00', '40744.00', '40744.00', ''),
(34, 1, 'DBI-27', 'MAY 2018 PAYROLL', '', '', '40744.00', '1.0000', '40744.00', '40744.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-05-31', 'M.M ZANELLI FORMATION HOUSE KAREN', '05-5131-01', 'KSHS', '1.00', '1.00', '40744.00', '40744.00', ''),
(35, 1, 'DBI-28', 'RENT FOR MARCH, APRIL AND MAY 2018', '', '', '10000.00', '3.0000', '30000.00', '30000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-06-11', 'LITTLE ANGELS CAFE', '05-5137-01', 'KSHS', '1.00', '1.00', '10000.00', '30000.00', ''),
(36, 1, 'DBI-29', 'RENT FOR MARCH, APRIL AND MAY 2018', '', '', '4000.00', '3.0000', '12000.00', '12000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'edith.mutea', '192.168.137.97', '2018-06-11', 'LITTLE FLOWER SHOP', '07-7709-01', 'KSHS', '1.00', '1.00', '4000.00', '12000.00', ''),
(37, 1, 'DBI-30', 'MEDICAL BILLS FOR AN ASSULTED CLIENT IN CASUALTY', '', '', '6320.00', '1.0000', '6320.00', '6320.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'doreen', '192.168.137.93', '2018-06-13', 'PATRICK NAMALE NDUNDE', '07-7368-01', 'KSHS', '1.00', '1.00', '6320.00', '6320.00', ''),
(38, 1, 'DBI-31', ' JAN-2018 SALARY', '', '', '20000.00', '1.0000', '20000.00', '20000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'admin', '192.168.1.14', '2018-08-28', 'CLINICAL OFFICER', '01-1002', 'KSHS', '1.00', '1.00', '20000.00', '20000.00', ''),
(39, 1, 'DBI-31', 'FEB-2018', '', '', '15000.00', '1.0000', '15000.00', '15000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'admin', '192.168.1.14', '2018-08-28', 'CLINICAL OFFICER', '01-1002', 'KSHS', '1.00', '1.00', '15000.00', '15000.00', ''),
(40, 1, 'DBI-31', 'MARCH-2018 SALARY', '', '', '22000.00', '1.0000', '22000.00', '22000.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'admin', '192.168.1.14', '2018-08-28', 'CLINICAL OFFICER', '01-1002', 'KSHS', '1.00', '1.00', '22000.00', '22000.00', ''),
(41, 1, 'DBI-32', 'LAM,C', '', '', '45220.00', '1.0000', '45220.00', '45220.00', '', '', 'ST THERESA MISSION HOSPITAL KIIRUA', 'LTC-1', 'admin', '127.0.0.1', '2018-09-14', 'MEDICAL OFFICER', '01-1003', 'KSHS', '1.00', '1.00', '45220.00', '45220.00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `debtors_invoice`
--
ALTER TABLE `debtors_invoice`
  ADD PRIMARY KEY (`auto_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `debtors_invoice`
--
ALTER TABLE `debtors_invoice`
  MODIFY `auto_number` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
