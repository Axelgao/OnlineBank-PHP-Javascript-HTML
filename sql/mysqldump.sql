-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for a2
CREATE DATABASE IF NOT EXISTS `a2` /*!40100 DEFAULT CHARACTER SET latin1 */;
GRANT ALL PRIVILEGES ON a2.* TO 'a2'@'%' IDENTIFIED BY 'a2' WITH GRANT OPTION;
USE `a2`;


-- Dumping structure for table a2.tbl_account
CREATE TABLE IF NOT EXISTS `tbl_account` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCOUNT_NUMBER` varchar(18) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `BALANCE` decimal(12,2) NOT NULL,
  `DATE_OPEN` date NOT NULL,
  `STATUS` char(1) NOT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `INDEX_ACCOUNT_NUMBER` (`ACCOUNT_NUMBER`),
  KEY `INDEX_USER` (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table a2.tbl_account: ~17 rows (approximately)
DELETE FROM `tbl_account`;
/*!40000 ALTER TABLE `tbl_account` DISABLE KEYS */;
INSERT INTO `tbl_account` (`ID`, `ACCOUNT_NUMBER`, `USER_ID`, `BALANCE`, `DATE_OPEN`, `STATUS`, `DESCRIPTION`) VALUES
	(1, '12-3456-7890123-01', 1, 0.00, '2016-10-04', '1', 'My Basic Account'),
	(2, '12-3456-7890123-03', 1, 0.00, '2016-10-04', '1', 'My Second Account'),
	(3, '12-3456-7891231-01', 2, 0.00, '2016-10-04', '1', 'My Basic Account'),
	(4, '12-3456-7891231-99', 2, 0.00, '2016-10-04', '1', 'My Second Account'),
	(5, '12-3456-7892312-01', 3, 0.00, '2016-10-04', '1', 'My Basic Account'),
	(6, '12-3456-7892312-99', 3, 0.00, '2016-10-04', '1', 'My Second Account'),
	(7, '12-5335-8482971-00', 4, 0.00, '2016-10-04', '0', 'Basic account'),
	(8, '12-5125-6970214-00', 5, 0.00, '2016-10-04', '1', 'Basic account'),
	(9, '12-7379-7223815-00', 6, 0.00, '2016-10-04', '1', 'Basic account'),
	(10, '12-2036-5459899-00', 7, 10.00, '2016-10-04', '0', 'Basic account'),
	(11, '12-0616-4208984-00', 8, 0.00, '2016-10-04', '1', 'Basic account'),
	(12, '12-8700-4941101-00', 9, 0.00, '2016-10-04', '1', 'Basic account'),
	(13, '12-2036-5459899-02', 7, 79.00, '2016-10-05', '0', 'asdas'),
	(14, '12-2036-5459899-03', 7, 999.00, '2016-10-05', '1', 'third'),
	(15, '12-8541-2766723-00', 10, 0.00, '2016-10-05', '1', 'Basic account'),
	(16, '12-2036-5459899-04', 7, 0.00, '2016-10-06', '1', 'asd'),
	(17, '12-2036-5459899-05', 7, 1.00, '2016-10-06', '1', 'asd'),
	(18, '12-2036-5459899-06', 7, 0.00, '2016-10-06', '1', 'afqw'),
	(19, '12-2036-5459899-07', 7, 0.00, '2016-10-06', '1', 'asdas');
/*!40000 ALTER TABLE `tbl_account` ENABLE KEYS */;


-- Dumping structure for table a2.tbl_transaction
CREATE TABLE IF NOT EXISTS `tbl_transaction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCOUNT_ID` int(11) NOT NULL,
  `TRANSACTION_TYPE` char(1) NOT NULL,
  `AMOUNT` decimal(12,2) NOT NULL,
  `BALANCE` decimal(12,2) NOT NULL,
  `TRANSACTION_TIME` datetime NOT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `INDEX_TIME` (`TRANSACTION_TIME`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table a2.tbl_transaction: ~17 rows (approximately)
DELETE FROM `tbl_transaction`;
/*!40000 ALTER TABLE `tbl_transaction` DISABLE KEYS */;
INSERT INTO `tbl_transaction` (`ID`, `ACCOUNT_ID`, `TRANSACTION_TYPE`, `AMOUNT`, `BALANCE`, `TRANSACTION_TIME`, `DESCRIPTION`) VALUES
	(1, 2, 'D', 3.00, 3.00, '2016-10-04 16:37:40', 'My deposit tranz'),
	(2, 2, 'W', 1.00, 2.00, '2016-10-04 16:37:40', 'My withdraw tranz'),
	(3, 2, 'T', 30.00, 32.00, '2016-10-04 16:37:40', 'My transfer tranz'),
	(4, 2, 'P', 3.00, 29.00, '2016-10-04 16:37:40', 'My payment tranz'),
	(5, 10, 'D', 12.00, 0.00, '2016-10-04 22:02:33', 'a'),
	(6, 10, 'P', 2.00, 12.00, '2016-10-04 22:34:52', '12-2036-5459899-02: ss'),
	(7, 13, 'D', 100.00, 0.00, '2016-10-05 13:51:05', 'sample'),
	(8, 13, 'F', 10.00, 100.00, '2016-10-05 13:51:27', 'transfer to third'),
	(9, 14, 'T', 10.00, 0.00, '2016-10-05 13:51:27', 'transfer to third'),
	(10, 13, 'P', 11.00, 90.00, '2016-10-05 14:03:09', '12-8541-2766723-00: 11'),
	(11, 14, 'F', 7.00, 10.00, '2016-10-06 01:19:21', ''),
	(12, 17, 'T', 7.00, 0.00, '2016-10-06 01:19:22', ''),
	(13, 17, 'F', 5.00, 7.00, '2016-10-06 01:21:16', ''),
	(14, 14, 'T', 5.00, 3.00, '2016-10-06 01:21:16', ''),
	(15, 17, 'P', 1.00, 2.00, '2016-10-06 01:27:10', 'sdfg: '),
	(16, 14, 'P', 1.00, 8.00, '2016-10-06 01:27:34', '234567: '),
	(17, 14, 'P', 1.00, 7.00, '2016-10-06 01:29:00', '1: '),
	(18, 14, 'D', 1000.00, 6.00, '2016-10-06 01:35:34', ''),
	(19, 14, 'W', 6.00, 1006.00, '2016-10-06 01:37:37', ''),
	(20, 14, 'P', 1.00, 1000.00, '2016-10-06 01:41:29', '234567: ');
/*!40000 ALTER TABLE `tbl_transaction` ENABLE KEYS */;


-- Dumping structure for table a2.tbl_user
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LOGIN_NAME` varchar(20) NOT NULL,
  `FIRST_NAME` varchar(20) NOT NULL,
  `LAST_NAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `SALT` varchar(20) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(100) NOT NULL,
  `DATE_OF_BIRTH` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `INDEX_LOGIN_NAME` (`LOGIN_NAME`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table a2.tbl_user: ~8 rows (approximately)
DELETE FROM `tbl_user`;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` (`ID`, `LOGIN_NAME`, `FIRST_NAME`, `LAST_NAME`, `PASSWORD`, `SALT`, `ADDRESS`, `PHONE_NUMBER`, `DATE_OF_BIRTH`) VALUES
	(1, 'peter', 'Pei', 'Wang', '123', '456', '105 Albany Highway, North Shore, Auckland', '021022023024', '1990-01-01'),
	(2, 'axel', 'Shenchuan', 'Gao', '123', '789', '120 Albany Highway, North Shore, Auckland', '022023024025', '1990-01-02'),
	(3, 'yun', 'Yunseong', 'Choi', '123', '012', '151 Albany Highway, North Shore, Auckland', '023024025026', '1990-01-03'),
	(4, 'yunseong', 'yunseong', 'choi', 'd6ee71e3ad0a043294d449db4a841f19', '722625', '31a tetrarch place', '021 055 1350', '1993-01-08'),
	(5, 'yun1', 'yunseong', 'asda', '8df501615144aee10241d0242e051fc9', '638000', 'asd', '0123', '1993-01-08'),
	(6, 'ys', 'Yunseong', 'choi', 'f43003b4cfcb2495d6a717de50268433', '477081', '12312asd asd asd ', 'asklnadsldk', '1993-01-08'),
	(7, 'cys7029', 'yunsenao', 'afdasf', '8573e24b40754d6cb22a7b24a3b05e6a', '918853', 'adfafd', '0201010102030', '1993-01-08'),
	(8, 'adfa', 'a', 'a', '2d49309f3462e7396c794762ebe846c8', '281799', 'aaaaa', '0202020202', '1993-02-01'),
	(9, 'jbnvkl bnkdb', 'a', 'a', 'efe5d27941ae4d7fe8b7fbc89f20faca', '754669', 'adnkflanlfkd', '020202919', '1993-12-20'),
	(10, 'cys4654', 'adfa', 'adfad', 'c675285202249823e2295dee4c279894', '625366', 'alklfahljk', '02110202022', '1992-01-23');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
