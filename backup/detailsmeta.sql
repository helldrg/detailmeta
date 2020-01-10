-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 10 2020 г., 07:32
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `detailsmeta`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=340 ;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`id`, `file`) VALUES
(331, '5e050be005b2c'),
(264, '5d6fa4de12692'),
(325, '5e050a02bf542'),
(326, '5e050a4bc7446'),
(328, '5e050a6cf2656'),
(335, '5e07add797430'),
(330, '5e050a910981e');

-- --------------------------------------------------------

--
-- Структура таблицы `catalogs`
--

CREATE TABLE IF NOT EXISTS `catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `catalogs`
--

INSERT INTO `catalogs` (`id`, `title`, `file`) VALUES
(1, 'Пластмассы', '5e0899941c22c'),
(6, 'fsdfdsf', '5e0899e161a79'),
(7, 'fsfsdf', '5e0899eaccd7b'),
(8, 'fsdf', '5e0899f4f3f7c'),
(12, 'fdsfdsff', '5e089a1ff0505'),
(14, 'fdsfdsfff', '5e089af1b13b4'),
(15, 'fds', '5e089afb394ef'),
(16, 'adsf', '5e089b0564ad8'),
(17, 'dsadda', '5e089b15b5f39'),
(18, 'ASE', '5e089b2202912'),
(19, 'dasd', '5e089b2dac52f'),
(22, 'fsdffsdfdsf', '5e08ad096bff6'),
(23, 'tyyr', '5e08ad126ccce'),
(26, '11111', ''),
(27, 'fdssff', 'gdfgdgddfgd');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCatalog` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` text NOT NULL,
  `materials` text NOT NULL,
  `specifications` text NOT NULL,
  `delivery` text NOT NULL,
  `amount` text NOT NULL,
  `file1` text NOT NULL,
  `file2` text NOT NULL,
  `file3` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCatalog` (`idCatalog`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `idCatalog`, `title`, `price`, `materials`, `specifications`, `delivery`, `amount`, `file1`, `file2`, `file3`) VALUES
(24, 1, 'Трубка', '100', 'Пластик', 'Водостойкая', 'по всей России', '500', '5e0a70377d4fd', '5e0a703781ca4', '5e0a703785b91'),
(25, 1, 'Шайба', '100', 'Пластик', 'Эластичная', 'по всей России', '500', '5e0a7089658bd', '', ''),
(26, 1, 'Прокладка', '30', 'Пластик', 'Эластичная', 'по всей России', '500', '5e0a70a194e77', '', ''),
(27, 1, 'Трубаd', '100', 'Пластик', 'Водостойкая', 'по всей России', '500', '5e0a70bb99e86', '5e0a70bb9ae1a', ''),
(32, 1, 'Звездочка мягкая к снегоходу Буран', '85', 'термопластичный полиуретан.', 'эластичная, износостойкая, морозостойкая.', 'по всей России', '500 шт', '5e0a784e55551', '5e0a784e55bf4', '5e0a784e5619f'),
(33, 1, 'black', 'fsdf', 'fsdf', 'fsdf', 'по всей России', '500', '5e0abe9fd28e3', '', ''),
(34, 1, 'BBB', 'gdfg', 'gdfg', 'gdfg', 'по всей России', '500', '5e0ac5b160044', '', ''),
(37, 6, 'трууууу', 'пвап', 'вап', 'пвап', 'по всей России', '500', '5e0b58f259933', '', ''),
(38, 1, 'Труаааааар', 'пвап', 'впап', 'пваппв', 'по всей России', '500', '5e0b5c52aaab4', '', '');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idCatalog`) REFERENCES `catalogs` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
