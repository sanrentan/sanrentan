-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2016 年 1 月 09 日 22:21
-- サーバのバージョン： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sanrentan`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `races`
--

CREATE TABLE `races` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `distance` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `turn` int(11) NOT NULL,
  `note` text,
  `note2` text,
  `note3` text,
  `race_date` timestamp NULL DEFAULT NULL,
  `view_flg` int(11) NOT NULL DEFAULT '0',
  `html_id` int(11) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `races`
--

INSERT INTO `races` (`id`, `name`, `full_name`, `place`, `grade`, `distance`, `type`, `turn`, `note`, `note2`, `note3`, `race_date`, `view_flg`, `html_id`, `is_deleted`, `created`, `modified`) VALUES
(1, '中山金杯', '第65回 日刊スポーツ賞中山金杯', '中山11R', 3, 2000, 0, 0, 'サラ系4歳以上 オープン （国際）［指定］ ハンデ', NULL, NULL, '2016-01-05 06:30:00', 0, 1606010111, 0, '2016-01-05 11:50:56', NULL),
(2, '京都金杯', '第54回 スポーツニッポン賞京都金杯', '京都', 3, 1600, 0, 0, 'サラ系4歳以上 オープン （国際） ハンデ', NULL, NULL, '2016-01-05 06:45:00', 0, 1608010111, 0, '2016-01-05 11:54:38', NULL),
(3, 'シンザン記念', '第50回日刊スポーツ賞シンザン記念', '京都11R', 3, 1600, 0, 0, 'サラ系3歳 オープン （国際）（特指） 別定', NULL, NULL, '2016-01-10 06:45:00', 0, 1608010311, 0, '2016-01-09 13:07:55', NULL),
(4, 'フェアリーステークス', '第32回 フェアリーステークス', '中山11R', 3, 1600, 0, 0, 'サラ系3歳 オープン （国際）牝（特指） 別定', NULL, NULL, '2016-01-11 06:35:00', 0, 1606010411, 0, '2016-01-09 13:10:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `races`
--
ALTER TABLE `races`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;