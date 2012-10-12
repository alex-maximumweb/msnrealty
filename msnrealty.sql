-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 12 2012 г., 14:54
-- Версия сервера: 5.5.28
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `msnrealty`
--

-- --------------------------------------------------------

--
-- Структура таблицы `export_feeds`
--

CREATE TABLE IF NOT EXISTS `export_feeds` (
  `exportfeed_id` int(11) NOT NULL AUTO_INCREMENT,
  `exportfeed_name` varchar(50) NOT NULL,
  PRIMARY KEY (`exportfeed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `export_feeds`
--

INSERT INTO `export_feeds` (`exportfeed_id`, `exportfeed_name`) VALUES
(1, 'Фид для слайда на главной недвижимости');

-- --------------------------------------------------------

--
-- Структура таблицы `feeds_mapping`
--

CREATE TABLE IF NOT EXISTS `feeds_mapping` (
  `export_feed_id` int(11) NOT NULL,
  `provider_feed_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `feeds_mapping`
--

INSERT INTO `feeds_mapping` (`export_feed_id`, `provider_feed_id`) VALUES
(1, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_feed_id` int(11) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `link_title` text NOT NULL,
  `linkdatetime` varchar(40) NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`link_id`, `provider_feed_id`, `link_url`, `image_url`, `link_title`, `linkdatetime`) VALUES
(9, 1, 'http://residential.ru.msn.com/analytics/62967', 'http://residential.ru.msn.com/images/content/msn_realty/analytics/2012/10/10/image001.jpg', 'В США опубликовали список самых жутких городов мира', '2012-10-10T13:37:00'),
(10, 1, 'http://residential.ru.msn.com/analytics/62967/link2/', 'http://residential.ru.msn.com/images/content/msn_realty/analytics/2012/10/10/image001.jpg', 'В Индии опубликовали список самых жутких городов мира', '2012-10-10T13:37:00');

-- --------------------------------------------------------

--
-- Структура таблицы `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(100) NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `providers`
--

INSERT INTO `providers` (`provider_id`, `provider_name`) VALUES
(1, 'MSN Auto'),
(2, 'MSN Sport'),
(3, 'MSN Commercial Realty');

-- --------------------------------------------------------

--
-- Структура таблицы `provider_feeds`
--

CREATE TABLE IF NOT EXISTS `provider_feeds` (
  `feed_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `feed_url` varchar(255) NOT NULL,
  `feed_title` varchar(100) NOT NULL,
  PRIMARY KEY (`feed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `provider_feeds`
--

INSERT INTO `provider_feeds` (`feed_id`, `provider_id`, `feed_url`, `feed_title`) VALUES
(1, 2, 'http://sport.ru.msn.com/export/rss-js-topslider.aspx', 'Новости спорта'),
(3, 1, 'http://auto.ru.msn.com/core/rss-js-topslider-slides.aspx', 'Авто новости'),
(4, 3, 'http://cre.msn.ru/rss/carousel/', 'Материалы в слайдер для главной недвижимости');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
