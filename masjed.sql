-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 30, 2019 at 07:42 AM
-- Server version: 10.3.12-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masjed`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'User uploaded the file.\r\nNULL is system files.',
  `dyna` blob DEFAULT NULL COMMENT 'ItemID\r\nPath\r\nFilename\r\nType',
  `created` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Deleted\r\n0: Suspended\r\n1: Active',
  PRIMARY KEY (`id`),
  KEY `Created` (`created`) USING BTREE,
  KEY `Status` (`status`) USING BTREE,
  KEY `UserID` (`userID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='All files uploaded to system are logged here';

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '42', 1577688787),
('admin', '9', 1554365919),
('operator', '7', 1552897543),
('superAdmin', '1', 1508416990),
('superAdmin', '8', 1508416990);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`) USING BTREE,
  KEY `idx-auth_item-type` (`type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'مدیر', NULL, NULL, 1507555215, 1515502636),
('clinicAddDoctor', 2, NULL, NULL, NULL, 1557905416, 1557905416),
('clinicCreate', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('clinicDelete', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('clinicImportCsvProgram', 2, NULL, NULL, NULL, 1557905416, 1557905416),
('clinicImportExcelProgram', 2, NULL, NULL, NULL, 1557905416, 1557905416),
('clinicIndex', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('clinicUpdate', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('clinicView', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('operator', 1, 'اپراتور', NULL, NULL, 1552897506, 1557906709),
('personCreate', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('personDelete', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('personIndex', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('personList', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('personUpdate', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('personView', 2, NULL, NULL, NULL, 1552897506, 1552897506),
('receptionClinicRequest', 2, NULL, NULL, NULL, 1557906701, 1557906701),
('receptionHospitalization', 2, NULL, NULL, NULL, 1557906701, 1557906701),
('receptionParaClinic', 2, NULL, NULL, NULL, 1557906702, 1557906702),
('superAdmin', 1, 'مدیر کل', NULL, NULL, 1507643138, 1507643138),
('user', 1, 'کاربر', NULL, NULL, 1507555215, 1515502636);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('operator', 'clinicAddDoctor'),
('operator', 'clinicCreate'),
('operator', 'clinicDelete'),
('operator', 'clinicImportCsvProgram'),
('operator', 'clinicImportExcelProgram'),
('operator', 'clinicIndex'),
('operator', 'clinicUpdate'),
('operator', 'clinicView'),
('operator', 'personCreate'),
('operator', 'personDelete'),
('operator', 'personIndex'),
('operator', 'personUpdate'),
('operator', 'personView'),
('operator', 'receptionClinicRequest'),
('operator', 'receptionHospitalization');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentID` int(10) DEFAULT NULL,
  `type` enum('cat','tag','lst','mnu','dep') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `dyna` blob DEFAULT NULL,
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-1: Suspended\r\n0: Unpublished\r\n1: Published',
  `left` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `tree` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ParentID` (`parentID`) USING BTREE,
  KEY `Type` (`type`) USING BTREE,
  KEY `Name` (`name`(255)) USING BTREE,
  KEY `Created` (`created`) USING BTREE,
  KEY `Status` (`status`) USING BTREE,
  KEY `lft` (`left`,`right`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nested records to store tree structures.\r\nIt includes categories, tags, persons.\r\n! This table is based on what Yii has designed.\r\nIf nothing exists, we will use "Nested sets" structure.';

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parentID`, `type`, `name`, `dyna`, `extra`, `created`, `status`, `left`, `right`, `depth`, `tree`) VALUES
(1, NULL, 'dep', 'مدیریت', 0x0407003b0000000000040013000b0023001200d3001b00f300240010012f001001736f727461725f6e616d65656e5f6e616d6561725f737461747573656e5f73746174757373686f775f616c7761797373686f775f696e5f686f6d650221214d616e6167656d656e7421312131, NULL, '1566741351', 1, 1, 2, 0, 1),
(4, NULL, 'mnu', 'خانه', 0x040c00710000000000040013000b0083001200a3001900f300220013012b003301340053013f0000024a0000025600030263001002736f727461725f6e616d65636f6e74656e74656e5f6e616d6561725f737461747573656e5f7374617475736d656e755f74797065616374696f6e5f6e616d6573686f775f616c7761797373686f775f696e5f686f6d6565787465726e616c5f6c696e6b73686f775f696e5f666f6f7465720421d8a8db8cd8aa213121486f6d65213121312132217369746540696e64657821, NULL, '1577689810', 1, 1, 2, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `catitem`
--

DROP TABLE IF EXISTS `catitem`;
CREATE TABLE IF NOT EXISTS `catitem` (
  `itemID` int(10) NOT NULL,
  `catID` int(10) NOT NULL,
  `type` enum('cat','tax') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Some types are defined in list like: ''cat'', ''tax''',
  `status` tinyint(1) NOT NULL COMMENT '-1: Suspended\r\n0: Unpublished\r\n1: Published',
  PRIMARY KEY (`itemID`,`catID`,`type`),
  KEY `CatID` (`catID`) USING BTREE,
  KEY `Type` (`type`) USING BTREE,
  KEY `Status` (`status`) USING BTREE,
  KEY `ItemID` (`itemID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'Book creator',
  `modelID` int(11) NOT NULL,
  `type` decimal(1,0) DEFAULT NULL,
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL COMMENT 'عنوان',
  `dyna` blob DEFAULT NULL COMMENT 'All fields',
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON array keeps all other options',
  `created` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Deleted\r\n0: Disabled\r\n1: Published\r\n5: Suggestion',
  PRIMARY KEY (`id`),
  KEY `UserID` (`userID`) USING BTREE,
  KEY `Created` (`created`) USING BTREE,
  KEY `Status` (`status`) USING BTREE,
  KEY `Name` (`name`(255)) USING BTREE,
  KEY `modelID` (`modelID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores list of items.';

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `userID`, `modelID`, `type`, `name`, `dyna`, `extra`, `created`, `status`) VALUES
(1, 42, 5, NULL, 'مسجد جامع کربلا', 0x0421005f01000003000400130009002300100083011700a3021e00b3022500d3022d00e3023500f3023d000303450013034e003303570043036000530369007303730083037d0093038700a3039100b3039c00c303a700d303b200e303bd00f303c8000304d4001304e0002304ec004304fa005304080163041701730426018304370193044a01a30476696577757361676561725f6e616d65656e5f6e616d657061726b696e677370656369616c62675f636f6c6f72656c657661746f726c6f636174696f6e7375627469746c6561725f737461747573617265615f73697a65646972656374696f6e656e5f737461747573626567696e5f64617465667265655f636f756e74736f6c645f636f756e74756e69745f636f756e7461725f6c6f636174696f6e61725f7375627469746c656465736372697074696f6e656e5f6c6f636174696f6e656e5f7375627469746c65666c6f6f725f6e756d6265726c6f636174696f6e5f74776f70726f6a6563745f7479706561725f6465736372697074696f6e656e5f6465736372697074696f6e61725f6c6f636174696f6e5f74776f656e5f6c6f636174696f6e5f74776f636f6e737472756374696f6e5f74696d656167655f6f665f7468655f6275696c64696e67756e69745f7065725f666c6f6f725f6e756d626572212121d985d8b3d8acd8af20d983d8b1d8a8d984d8a7d8a1214d6f73717565206f66204b617262616c61212130212121212131212121312121212121212121212121213121212121212121, NULL, '1577691450', 1);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'User who did the action.\r\nNull is system actions',
  `code` smallint(5) NOT NULL COMMENT 'Action code.\r\nCodes are defined in excel file',
  `action` tinyint(1) NOT NULL COMMENT '\n1: Insert\r\n2: Update\r\n3: Delete',
  `model` char(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Table of item.\r\nNULL is reserved.',
  `modelID` int(10) DEFAULT NULL COMMENT 'Item ID\r\nNULL is reserved for system activities.',
  `values` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON decoded values of old and new values.\r\n{''old'':[], ''new'':[]}',
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserID` (`userID`) USING BTREE,
  KEY `Code` (`code`) USING BTREE,
  KEY `Action` (`action`) USING BTREE,
  KEY `Model` (`model`) USING BTREE,
  KEY `ModelID` (`modelID`) USING BTREE,
  KEY `Date` (`date`) USING BTREE,
  KEY `Time` (`time`) USING BTREE,
  KEY `FKLog440613` (`userID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Audit table.\r\n! This is only about actions are done by operators or auto-system, it is not the search log.';

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL COMMENT 'نام و نام خانوادگی',
  `type` enum('cnt','sgn','cmp') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'cnt' COMMENT 'Enum: cnt: contact us, sgn: suggestions, cmp: complaints',
  `tel` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'شماره تماس',
  `body` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'متن',
  `dyna` blob DEFAULT NULL COMMENT 'All fields',
  `created` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON array to store fields, order of fields and aliases\r\n\r\nStores fields options as JSON:\r\n{\r\n  [\r\n    fieldID: 5,\r\n    name: //Field name in language (ISO 639-1). Overrides default value in "Field" table\r\n      [\r\n        ''ar'':''myField'',\r\n        ''fa'':''yourField''\r\n      ],\r\n    width:15\r\n  ],\r\n  [\r\n    fieldID: 7,\r\n    name:\r\n      [\r\n        ''ar'':''...'',...\r\n      ]\r\n  ]\r\n}',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Alias` (`alias`) USING BTREE,
  KEY `Name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id`, `name`, `alias`, `extra`) VALUES
(1, 'slide', 'اسلاید', NULL),
(2, 'post', 'مطلب', NULL),
(3, 'page', 'صفحات', NULL),
(4, 'project', 'پروژه', NULL),
(5, 'block', 'بلاک', NULL),
(6, 'gallery', 'گالری', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ugroup`
--

DROP TABLE IF EXISTS `ugroup`;
CREATE TABLE IF NOT EXISTS `ugroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `members` blob DEFAULT NULL COMMENT 'JSON array:\r\nU[userID] => [Status:0,1]',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User groups';

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Hashed\r\nIt maybe 512',
  `roleID` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dyna` blob DEFAULT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Suspended\r\n0: Inactive\r\n1: Active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`username`) USING BTREE,
  KEY `Name` (`name`) USING BTREE,
  KEY `Status` (`status`) USING BTREE,
  KEY `ruleID` (`roleID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table of users';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `roleID`, `dyna`, `created`, `status`) VALUES
(8, 'Rahbod', 'rahbod', '$2y$13$LzbDws024iCbvece6kIsSOuoiVQj.6cETL7bgrRuKgZpa.Dul/dqW', 'superAdmin', NULL, '2018-02-13 21:46:22', 1),
(42, 'مدیر سایت', 'admin', '$2y$13$TzkKj/Y7WvRayuSf0idhK.GlEzUHIXHeYC.2jdlzSjPTv/IEgFckG', 'admin', 0x0402000c000000030005007301656d61696c7570646174656421616c692e6a6177616865726940676d61696c2e636f6d21323031392d31322d33302031303a32333a3037, '2019-12-30 10:23:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userugroup`
--

DROP TABLE IF EXISTS `userugroup`;
CREATE TABLE IF NOT EXISTS `userugroup` (
  `userID` int(11) NOT NULL,
  `ugroupID` int(11) NOT NULL,
  PRIMARY KEY (`userID`,`ugroupID`),
  KEY `ugroupID` (`ugroupID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category` ADD FULLTEXT KEY `name_2` (`name`);

--
-- Indexes for table `item`
--
ALTER TABLE `item` ADD FULLTEXT KEY `name_2` (`name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `catitem`
--
ALTER TABLE `catitem`
  ADD CONSTRAINT `catitem_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `catitem_ibfk_2` FOREIGN KEY (`catID`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`modelID`) REFERENCES `model` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `auth_item` (`name`);

--
-- Constraints for table `userugroup`
--
ALTER TABLE `userugroup`
  ADD CONSTRAINT `userugroup_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `userugroup_ibfk_2` FOREIGN KEY (`ugroupID`) REFERENCES `ugroup` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
