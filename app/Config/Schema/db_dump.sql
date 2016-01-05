-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2016 年 1 月 05 日 21:25
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `races`
--

INSERT INTO `races` (`id`, `name`, `full_name`, `place`, `grade`, `distance`, `type`, `turn`, `note`, `note2`, `note3`, `race_date`, `view_flg`, `html_id`, `is_deleted`, `created`, `modified`) VALUES
(1, '中山金杯', '第65回 日刊スポーツ賞中山金杯', '中山11R', 3, 2000, 0, 0, 'サラ系4歳以上 オープン （国際）［指定］ ハンデ', NULL, NULL, '2016-01-05 06:30:00', 0, 1606010111, 0, '2016-01-05 11:50:56', NULL),
(2, '京都金杯', '第54回 スポーツニッポン賞京都金杯', '京都', 3, 1600, 0, 0, 'サラ系4歳以上 オープン （国際） ハンデ', NULL, NULL, '2016-01-05 06:45:00', 0, 1608010111, 0, '2016-01-05 11:54:38', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `race_cards`
--

CREATE TABLE `race_cards` (
  `id` int(11) NOT NULL,
  `race_id` int(11) NOT NULL,
  `wk` int(11) NOT NULL,
  `uma` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sexage` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `plus` varchar(255) NOT NULL,
  `j_name` varchar(255) NOT NULL,
  `j_weight` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `race_cards`
--

INSERT INTO `race_cards` (`id`, `race_id`, `wk`, `uma`, `name`, `sexage`, `weight`, `plus`, `j_name`, `j_weight`, `is_deleted`, `created`, `modified`) VALUES
(1, 1, 1, 1, 'ロンギングダンサー', '牡7', 494, '\r\n(+2) ', '吉田 豊', '53.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(2, 1, 2, 2, 'スピリッツミノル', '牡4', 494, '\r\n(-4) ', '酒井 学', '53.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(3, 1, 3, 3, 'ステラウインド', '牡7', 490, '\r\n(+4) ', '蛯名 正義', '56.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(4, 1, 3, 4, 'ネオリアリズム', '牡5', 496, '\r\n(-4) ', '戸崎 圭太', '55.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(5, 1, 4, 5, 'ヤマカツエース', '牡4', 492, '\r\n(+6) ', '池添 謙一', '56.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(6, 1, 4, 6, 'ブライトエンブレム', '牡4', 492, '\r\n(+4) ', 'C.ルメール', '56.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(7, 1, 5, 7, 'マイネルフロスト', '牡5', 488, '\r\n(+4) ', '松岡 正海', '57.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(8, 1, 5, 8, 'フラアンジェリコ', '牡8', 516, '\r\n(+6) ', '柴山 雄一', '55.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(9, 1, 6, 9, 'ベルーフ', '競走除外 ', 478, '\r\n(-6) ', 'F.ベリー', '56.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(10, 1, 6, 10, 'フルーキー', '牡6', 490, '\r\n(+6) ', 'M.デムーロ', '57.5 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(11, 1, 7, 11, 'メイショウカンパク', '牡9', 484, '\r\n(0) ', '大野 拓弥', '53.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(12, 1, 7, 12, 'バロンドゥフォール', '牡6', 490, '\r\n(+6) ', '横山 典弘', '54.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(13, 1, 8, 13, 'マイネルディーン', '牡7', 464, '\r\n(+20) ', '柴田 大知', '54.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(14, 1, 8, 14, 'ライズトゥフェイム', '牡6', 488, '\r\n(+4) ', '石川 裕紀人', '56.0 ', 0, '2016-01-05 12:09:47', '0000-00-00 00:00:00'),
(15, 2, 1, 1, 'ニンジャ', '牡7', 476, '\r\n(-2) ', '熊沢 重文', '53.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(16, 2, 1, 2, 'バッドボーイ', '牡6', 514, '\r\n(0) ', '幸 英明', '53.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(17, 2, 2, 3, 'シベリアンスパーブ', '牡7', 512, '\r\n(+6) ', '藤岡 康太', '54.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(18, 2, 2, 4, 'ケイティープライド', '牡6', 496, '\r\n(+4) ', '秋山 真一郎', '53.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(19, 2, 3, 5, 'メイショウマンボ', '牝6', 496, '\r\n(+4) ', '武 幸四郎', '55.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(20, 2, 3, 6, 'ミッキーラブソング', '牡5', 468, '\r\n(+4) ', '小牧 太', '54.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(21, 2, 4, 7, 'ウインプリメーラ', '牝6', 452, '\r\n(-2) ', '川田 将雅', '53.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(22, 2, 4, 8, 'エイシンブルズアイ', '牡5', 468, '\r\n(-2) ', '和田 竜二', '56.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(23, 2, 5, 9, 'オメガヴェンデッタ', 'せん5', 514, '\r\n(+8) ', '岩田 康誠', '55.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(24, 2, 5, 10, 'マジェスティハーツ', '牡6', 496, '\r\n(-4) ', '森 一馬', '56.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(25, 2, 6, 11, 'ダイワマッジョーレ', '牡7', 442, '\r\n(+4) ', '松若 風馬', '57.5 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(26, 2, 6, 12, 'エキストラエンド', '牡7', 478, '\r\n(+8) ', '吉田 隼人', '57.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(27, 2, 7, 13, 'マーティンボロ', '牡7', 456, '\r\n(+16) ', 'S.フォーリー', '57.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(28, 2, 7, 14, 'テイエムタイホー', '牡7', 498, '\r\n(-2) ', '浜中 俊', '57.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(29, 2, 8, 15, 'タガノエスプレッソ', '牡4', 454, '\r\n(+12) ', '菱田 裕二', '54.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(30, 2, 8, 16, 'トーセンスターダム', '牡5', 504, '\r\n(+8) ', '武 豊', '57.5 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00'),
(31, 2, 8, 17, 'ドリームバスケット', '牡9', 464, '\r\n(-2) ', '川須 栄彦', '52.0 ', 0, '2016-01-05 12:22:41', '0000-00-00 00:00:00');

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
-- Indexes for table `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `race_cards`
--
ALTER TABLE `race_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `race_id` (`race_id`),
  ADD KEY `race_id_2` (`race_id`),
  ADD KEY `created` (`created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expectations`
--
ALTER TABLE `expectations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `races`
--
ALTER TABLE `races`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `race_cards`
--
ALTER TABLE `race_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;