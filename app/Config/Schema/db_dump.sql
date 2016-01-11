-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2016 年 1 月 11 日 11:49
-- サーバのバージョン： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sanrentan`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nickname` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `span` varchar(255) DEFAULT NULL,
  `favorite` varchar(255) DEFAULT NULL,
  `message` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `nickname`, `password`, `role`, `span`, `favorite`, `message`, `created`, `modified`) VALUES
(1, 'yamaoka', '', '$2a$10$RLnPjDZKm/XSyDDgFDiC8e5l.JZg3pe2958GNZlBHp.MkWL5kcecq', 'admin', NULL, NULL, NULL, '2016-01-08 23:44:06', '2016-01-09 21:10:02'),
(2, 'yamaty', '', '$2a$10$.4JuZ7er22PmXPOB7s0jQOoN1JzZ4mZhysGnEmecMRIEeMaZPVdfe', 'admin', NULL, NULL, NULL, '2016-01-09 21:01:03', '2016-01-09 21:01:03'),
(3, 'kojiharu', '', '$2a$10$iIUthrOef7vH2mFfbD.z3e7pLznptFy9MEWWPlQ/5GipSJySI0wUG', 'admin', NULL, NULL, NULL, '2016-01-10 13:05:42', '2016-01-10 13:05:42'),
(7, 'yamap2', 'やまぴー２', '$2a$10$IFn1wQafZ6jaJFnEKuWbxOx/XSVPKQqwmYd7Yed866ZXtJ/VNVCW.', NULL, '１年', 'ディープインパクト', '３連単当てるぞー！', '2016-01-10 23:40:30', '2016-01-10 23:40:30'),
(8, 'yamap3', 'yamap3', '$2a$10$koUPC4j8gr9jKW8gdNaD7OFhNQjETW0g4QnnH4P7wNbCzn7tuCuPK', NULL, '', '', '', '2016-01-10 23:45:14', '2016-01-10 23:45:14'),
(9, 'yamap4', 'やまぴー４', '$2a$10$W14ZIMAfsxUxeFbeWxjcfOJY.PqDE9RC4i5cgJZfeR1Sxp1KSB.hi', NULL, '', 'オルフェーブル', 'こんにちわ', '2016-01-11 09:31:45', '2016-01-11 09:31:45'),
(10, 'yamap5', 'やまぴー5', '$2a$10$TanZm6McIdhxnIhkEsRBLOMuee9IiAuvmCS6OCjAjnSpp1nOFnyqu', NULL, 'test', 'オルフェーブル', 'こんにちわ', '2016-01-11 09:40:28', '2016-01-11 09:40:28'),
(11, 'yamap6', 'yamap6', '$2a$10$Hou8tYAdCfNV8/e84/5VMeLKu8UF2onxlJj98PgSVykISZMe/KvqS', NULL, '', '', '', '2016-01-11 09:44:03', '2016-01-11 09:44:03'),
(12, 'yamap7', 'yamap7', '$2a$10$KO/fQ6GxFvEWyNtfEHjTT.wPa0Oogr9pLr0Y9zQZSzasmReTyxbXK', NULL, '', '', '', '2016-01-11 09:46:11', '2016-01-11 09:46:11'),
(13, 'yamap8', 'yamap8', '$2a$10$zeGKfcVaJopERadkI6YNTO8FnAdBPrD4J65gRo8XKBBHpNxnS1oJm', NULL, '', '', '', '2016-01-11 09:46:54', '2016-01-11 09:46:54'),
(14, 'yamap9', 'yamap9', '$2a$10$YuZkYDeGOdknxUTEhppHquBa06u./1UBpAnRS0qXQcyrN7Af9DeB.', NULL, '', '', '', '2016-01-11 09:49:00', '2016-01-11 09:49:00'),
(15, 'yamap10', 'yamap10', '$2a$10$IuyLX6exJ2/6udhxSY83/eHZZ4X9hiNJbKSxHV9XgkQDGvaXKljF6', NULL, '', '', '', '2016-01-11 09:49:51', '2016-01-11 09:49:51'),
(16, 'yamap11', 'yamap11', '$2a$10$mJeATRGAMjigcVqJf/50cOBbkRhYMXRovkDtF28eQ6KkppoRWjRf2', NULL, '', '', '', '2016-01-11 09:50:16', '2016-01-11 09:50:16'),
(17, 'yamap12', 'yamap12', '$2a$10$xmg/rtUiDQu.1N9rxj/.jObQ.a4lXwicy8v5FLJGeak3IS33zdvTq', NULL, '', '', '', '2016-01-11 09:54:25', '2016-01-11 09:54:25'),
(18, 'yamapa13', 'yamap13', '$2a$10$QiY9T609UeWiFlYjlGgNq.gXc8wKlmfo8YSL9Na7Q1ZnFikDia0oW', NULL, '', '', '', '2016-01-11 09:55:18', '2016-01-11 09:55:18'),
(19, 'yamap14', 'yamap14', '$2a$10$eFHiSQBvd6Pe6A.lRvWiK.qVIZ8qgHm2k5zAKLyNMWMHb9sfiQS0O', NULL, '', '', '', '2016-01-11 09:56:10', '2016-01-11 09:56:10'),
(20, 'yamap15', 'yamap15', '$2a$10$hZ/Mk7HefZoXcEapksGg8uZjiQzSfWg06B0z4GTG1mQBegJBVmfbe', NULL, '', '', '', '2016-01-11 09:57:32', '2016-01-11 09:57:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nickname` (`nickname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;