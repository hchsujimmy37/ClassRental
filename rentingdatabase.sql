-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 
-- 伺服器版本： 5.7.17
-- PHP 版本： 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `rentingdatabase`
--

-- --------------------------------------------------------

--
-- 資料表結構 `approver`
--

CREATE TABLE `approver` (
  `aID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '審核者ID',
  `apassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '審核者密碼',
  `fName` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理員姓氏',
  `lName` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理員名字',
  `aPhoneNumber` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理員手機'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `approver`
--

INSERT INTO `approver` (`aID`, `apassword`, `fName`, `lName`, `aPhoneNumber`) VALUES
('A10000000', '00000000', 'NCKU', 'IIM', '0912345678'),
('A10000001', '8kdekfefds', 'NCKU', 'IIMC', '0987654321');

-- --------------------------------------------------------

--
-- 資料表結構 `classroom`
--

CREATE TABLE `classroom` (
  `cID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室編號',
  `cName` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室名稱',
  `cCapacity` int(11) NOT NULL COMMENT '教室容量(學生數)',
  `cPrice` int(11) NOT NULL COMMENT '租金'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `classroom`
--

INSERT INTO `classroom` (`cID`, `cName`, `cCapacity`, `cPrice`) VALUES
('61101', '階梯講堂', 102, 3000),
('61102', '小階梯教室', 78, 3000),
('61103', '多功能講堂', 63, 3000),
('61104', '61104 教室', 68, 1500),
('61200', '階梯講堂', 136, 6000),
('61200s', '貴賓室', 12, 4000),
('61201', '電腦教室', 45, 5000),
('61202', '61202 教室', 24, 1000),
('61204', '61204 教室', 35, 1000),
('61206', '多功能講堂', 38, 4000),
('61210', '61210 教室', 21, 1000),
('61306', '大型會議室', 30, 5000),
('61321', '小型會議室', 12, 3000);

-- --------------------------------------------------------

--
-- 資料表結構 `equipment`
--

CREATE TABLE `equipment` (
  `eID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '設備編號',
  `eName` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '設備名稱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `equipment`
--

INSERT INTO `equipment` (`eID`, `eName`) VALUES
('1', '單槍投影機'),
('2', '投影筆'),
('3', '電腦'),
('4', 'VGA Cable'),
('5', 'Power Cable'),
('6', '手提擴音機'),
('7', '錄影機');

-- --------------------------------------------------------

--
-- 資料表結構 `equipment_renting`
--

CREATE TABLE `equipment_renting` (
  `rID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '租借流水號',
  `eID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '租借設備名稱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `equipment_renting`
--

INSERT INTO `equipment_renting` (`rID`, `eID`) VALUES
('0000002', '001'),
('0000005', '001'),
('0000002', '002'),
('0000005', '002'),
('0000001', '1'),
('0000002', '1'),
('0000003', '1'),
('0000004', '1'),
('0000005', '1'),
('0000006', '1'),
('0000007', '1'),
('0000010', '1'),
('0000011', '1'),
('0000022', '1'),
('0000023', '1'),
('0000024', '1'),
('0000029', '1'),
('0000043', '1'),
('0000044', '1'),
('0000037', '2'),
('0000038', '2'),
('0000043', '2'),
('0000044', '2'),
('0000045', '3'),
('0000046', '3'),
('0000008', '4'),
('0000009', '4'),
('0000041', '4'),
('0000042', '4'),
('0000045', '4'),
('0000046', '4'),
('0000047', '5'),
('0000048', '5'),
('0000001', '6'),
('0000002', '6'),
('0000003', '6'),
('0000004', '6'),
('0000020', '6'),
('0000021', '6'),
('0000025', '6'),
('0000026', '6'),
('0000027', '6'),
('0000028', '6'),
('0000035', '6'),
('0000036', '6'),
('0000005', '7'),
('0000006', '7'),
('0000007', '7'),
('0000014', '7'),
('0000015', '7'),
('0000016', '7'),
('0000045', '7'),
('0000046', '7'),
('0000047', '7'),
('0000048', '7');

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `mID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '學生編號',
  `mpassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '學生密碼',
  `fName` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '學生姓氏',
  `lName` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '學生名字',
  `mPhoneNumber` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '學生手機',
  `mMajor` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '學生主修系所',
  `mGrade` int(1) DEFAULT NULL COMMENT '學生年級'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`mID`, `mpassword`, `fName`, `lName`, `mPhoneNumber`, `mMajor`, `mGrade`) VALUES
('S00001', 'abc123456', '宮姿', '陳', '0987878787', '工資系', 2),
('S00002', 'ifuxku8787', '殿基', '王', '0926262266', '電機系', 3),
('S00003', 'holyshxt74', '邰紋', '張', '0909090909', '台文系', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `notes`
--

CREATE TABLE `notes` (
  `nID` int(11) NOT NULL COMMENT '注意事項編號',
  `nDescription` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '注意事項描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `notes`
--

INSERT INTO `notes` (`nID`, `nDescription`) VALUES
(1, '收費標準：全日以8小時計;半日以4小時計，不足半日以半日計費，不足一日以全日計算之。'),
(2, '本校各單位所舉辦之活動使用一次以七折收費。'),
(3, '除上班時間外，例假日晚上使用應另支付工讀生費用。工讀生計標準，以行政院勞工委員會最新基本工資規定為原則，不足1小時以1小時計【外加場地（含廁所）清潔費半日500元，全900元】。'),
(4, '若各單位主辦，協辦活動或其他特殊狀況足以提升本系（所）教學及研究績效得經系主任（所長）同意後酌以減免。'),
(5, '收取之場地使用費已包含管管理維護費及水電管理費，唯若因特殊理由免收者，仍需另外酌收管理維護費及水電管理費，收費標準另訂。'),
(6, '若有使用電腦等相關設備，將另外酌收整備費。'),
(7, '申請借用者，應向本系所辦公室及電腦室辦理借用手續，非定期使用場地應七天前提出申請，繳費，否則不予受理。');

-- --------------------------------------------------------

--
-- 資料表結構 `precautions`
--

CREATE TABLE `precautions` (
  `pID` int(11) NOT NULL COMMENT '規範編號',
  `pDescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '規範內容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `precautions`
--

INSERT INTO `precautions` (`pID`, `pDescription`) VALUES
(1, '本系（所）公共場所之使用以處理公事，學術單位借用為。'),
(2, '申請借用需經系主任（所長）核准後為原則登記使用。'),
(3, '非經管理者同意，請勿將設備攜出，違者照價賠償原則。'),
(4, '申請借用後不得攜帶食物或飲料進入使用。'),
(5, '借用場地須保持場地之整潔，如有髒亂須負責清掃，使用完畢請將冷氣，電燈及門窗關閉。'),
(6, '其他未注意事項依照學校場地借用規定為準則規範。');

-- --------------------------------------------------------

--
-- 資料表結構 `rental_agreement`
--

CREATE TABLE `rental_agreement` (
  `rID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '租借流水號',
  `mID` char(9) COLLATE utf8_unicode_ci NOT NULL COMMENT '租借學生編號',
  `cID` char(9) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '租借教室編號',
  `rAppricationDate` date NOT NULL COMMENT '租借日期',
  `rDateTimeFrom` datetime NOT NULL COMMENT '租借開始時間',
  `rDateTimeTo` datetime NOT NULL COMMENT '租借結束時間',
  `aID` char(9) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '審核人ID',
  `rApproval` tinyint(1) DEFAULT NULL COMMENT '是否已檢核(1:是 0:否)',
  `rApprovalDate` date DEFAULT NULL COMMENT '檢核日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `rental_agreement`
--

INSERT INTO `rental_agreement` (`rID`, `mID`, `cID`, `rAppricationDate`, `rDateTimeFrom`, `rDateTimeTo`, `aID`, `rApproval`, `rApprovalDate`) VALUES
('0000001', 'S00001', '61101', '2019-06-08', '2019-06-09 08:10:00', '2019-06-09 09:00:00', 'A000000', 1, '2019-06-09'),
('0000002', 'S00001', '61101', '2019-06-08', '2019-06-09 09:10:00', '2019-06-09 10:00:00', 'A10000000', 1, '2019-06-15'),
('0000003', 'S00001', '61101', '2019-06-08', '2019-06-09 10:10:00', '2019-06-09 11:00:00', 'A10000000', 1, '2019-06-15'),
('0000004', 'S00001', '61101', '2019-06-08', '2019-06-09 11:10:00', '2019-06-09 12:00:00', 'A10000000', 1, '2019-06-15'),
('0000005', 'S00001', '61101', '2019-06-08', '2019-06-11 10:10:00', '2019-06-11 11:00:00', 'A10000000', 1, '2019-06-11'),
('0000006', 'S00001', '61101', '2019-06-08', '2019-06-11 11:10:00', '2019-06-11 12:00:00', 'A10000000', 1, '2019-06-11'),
('0000007', 'S00001', '61101', '2019-06-08', '2019-06-11 12:10:00', '2019-06-11 13:00:00', 'A10000000', 1, '2019-06-15'),
('0000008', 'S00001', '61101', '2019-06-08', '2019-06-13 09:10:00', '2019-06-13 10:00:00', 'A10000000', 1, '2019-06-15'),
('0000009', 'S00001', '61101', '2019-06-08', '2019-06-13 10:10:00', '2019-06-13 11:00:00', 'A10000000', 1, '2019-06-15'),
('0000010', 'S00001', '61101', '2019-06-08', '2019-06-12 13:10:00', '2019-06-12 14:00:00', 'A10000000', 1, '2019-06-15'),
('0000011', 'S00001', '61101', '2019-06-08', '2019-06-12 14:10:00', '2019-06-12 15:00:00', 'A10000000', 1, '2019-06-15'),
('0000012', 'S00001', '61102', '2019-06-08', '2019-06-22 11:10:00', '2019-06-22 12:00:00', 'A10000000', 1, '2019-06-15'),
('0000013', 'S00001', '61101', '2019-06-09', '2019-06-16 11:10:00', '2019-06-16 12:00:00', 'A10000000', 1, '2019-06-15'),
('0000014', 'S00001', '61101', '2019-06-12', '2019-06-19 12:10:00', '2019-06-19 13:00:00', 'A10000000', 1, '2019-06-15'),
('0000015', 'S00001', '61101', '2019-06-12', '2019-06-19 13:10:00', '2019-06-19 14:00:00', 'A10000000', 1, '2019-06-15'),
('0000016', 'S00001', '61101', '2019-06-12', '2019-06-19 14:10:00', '2019-06-19 15:00:00', 'A10000000', 1, '2019-06-15'),
('0000017', 'S00001', '61102', '2019-06-12', '2019-06-15 12:10:00', '2019-06-15 13:00:00', 'A10000000', 1, '2019-06-15'),
('0000018', 'S00001', '61102', '2019-06-12', '2019-06-15 13:10:00', '2019-06-15 14:00:00', 'A10000000', 1, '2019-06-15'),
('0000019', 'S00001', '61101', '2019-06-12', '2019-06-15 12:10:00', '2019-06-15 13:00:00', 'A10000000', 1, '2019-06-15'),
('0000032', 'S00001', '61101', '2019-06-15', '2019-06-17 17:10:00', '2019-06-17 18:00:00', 'A10000000', 1, '2019-06-15'),
('0000033', 'S00001', '61101', '2019-06-15', '2019-06-17 17:10:00', '2019-06-17 18:00:00', 'A10000000', 1, '2019-06-15'),
('0000034', 'S00001', '61101', '2019-06-15', '2019-06-17 17:10:00', '2019-06-17 18:00:00', 'A10000000', 1, '2019-06-15'),
('0000035', 'S00001', '61101', '2019-06-15', '2019-06-18 14:10:00', '2019-06-18 15:00:00', 'A10000000', 1, '2019-06-15'),
('0000036', 'S00001', '61101', '2019-06-15', '2019-06-19 15:10:00', '2019-06-19 16:00:00', 'A10000000', 1, '2019-06-16'),
('0000037', 'S00002', '61101', '2019-06-16', '2019-06-20 11:10:00', '2019-06-20 12:00:00', 'A10000000', 1, '2019-06-16'),
('0000038', 'S00002', '61101', '2019-06-16', '2019-06-20 12:10:00', '2019-06-20 13:00:00', 'A10000000', 1, '2019-06-16'),
('0000039', 'S00001', '61200', '2019-06-16', '2019-06-18 07:10:00', '2019-06-18 08:00:00', 'A10000000', 1, '2019-06-16'),
('0000040', 'S00001', '61200', '2019-06-16', '2019-06-19 07:10:00', '2019-06-19 08:00:00', 'A10000000', 1, '2019-06-16'),
('0000041', 'S00001', '61200s', '2019-06-19', '2019-06-19 08:10:00', '2019-06-19 09:00:00', 'A10000000', 1, '2019-06-19'),
('0000042', 'S00001', '61200s', '2019-06-19', '2019-06-19 09:10:00', '2019-06-19 10:00:00', 'A10000000', 0, '2019-06-20'),
('0000043', 'S00001', '61210', '2019-06-19', '2019-06-19 10:10:00', '2019-06-19 11:00:00', 'A10000000', 1, '2019-06-19'),
('0000044', 'S00001', '61210', '2019-06-19', '2019-06-19 11:10:00', '2019-06-19 12:00:00', 'A10000000', 1, '2019-06-19'),
('0000045', 'S00001', '61104', '2019-06-20', '2019-06-20 15:10:00', '2019-06-20 16:00:00', 'A10000000', 0, '2019-06-20'),
('0000046', 'S00001', '61104', '2019-06-20', '2019-06-20 16:10:00', '2019-06-20 17:00:00', NULL, NULL, NULL),
('0000047', 'S00001', '61101', '2021-12-13', '2021-12-14 08:10:00', '2021-12-14 09:00:00', 'A10000000', 1, '2021-12-13'),
('0000048', 'S00001', '61101', '2021-12-13', '2021-12-14 09:10:00', '2021-12-14 10:00:00', 'A10000000', 1, '2021-12-13');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `approver`
--
ALTER TABLE `approver`
  ADD PRIMARY KEY (`aID`);

--
-- 資料表索引 `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`cID`);

--
-- 資料表索引 `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`eID`);

--
-- 資料表索引 `equipment_renting`
--
ALTER TABLE `equipment_renting`
  ADD PRIMARY KEY (`rID`,`eID`),
  ADD KEY `eID` (`eID`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mID`);

--
-- 資料表索引 `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`nID`);

--
-- 資料表索引 `precautions`
--
ALTER TABLE `precautions`
  ADD PRIMARY KEY (`pID`);

--
-- 資料表索引 `rental_agreement`
--
ALTER TABLE `rental_agreement`
  ADD PRIMARY KEY (`rID`),
  ADD KEY `mID` (`mID`),
  ADD KEY `aID` (`aID`),
  ADD KEY `cID` (`cID`);

--
-- 在傾印的資料表使用自動增長(AUTO_INCREMENT)
--

--
-- 使用資料表自動增長(AUTO_INCREMENT) `notes`
--
ALTER TABLE `notes`
  MODIFY `nID` int(11) NOT NULL AUTO_INCREMENT COMMENT '注意事項編號', AUTO_INCREMENT=8;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `precautions`
--
ALTER TABLE `precautions`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT COMMENT '規範編號', AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
