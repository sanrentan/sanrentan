-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2015 年 12 月 04 日 18:03
-- サーバのバージョン： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sanrentan`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `expectations`
--

CREATE TABLE `expectations` (
  `id` int(11) NOT NULL,
  `race_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item1` int(11) NOT NULL,
  `item2` int(11) NOT NULL,
  `item3` int(11) NOT NULL,
  `item4` int(11) NOT NULL,
  `item5` int(11) NOT NULL,
  `result` int(11) DEFAULT '0',
  `cancel_flg` int(11) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `expectations`
--

INSERT INTO `expectations` (`id`, `race_id`, `user_id`, `item1`, `item2`, `item3`, `item4`, `item5`, `result`, `cancel_flg`, `created`, `modified`) VALUES
(1, 1, 1, 5, 6, 7, 8, 9, 0, 0, '2015-12-04 09:01:58', '0000-00-00 00:00:00'),
(2, 1, 1, 5, 6, 7, 8, 9, 0, 0, '2015-12-04 09:02:46', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expectations`
--
ALTER TABLE `expectations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `race_id` (`race_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `race_user_id` (`user_id`,`race_id`) USING BTREE,
  ADD KEY `created` (`created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expectations`
--
ALTER TABLE `expectations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;