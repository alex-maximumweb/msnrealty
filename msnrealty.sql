-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 11 2012 г., 21:11
-- Версия сервера: 5.5.27
-- Версия PHP: 5.3.15

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
-- Структура таблицы `exportfeeds`
--

CREATE TABLE IF NOT EXISTS `exportfeeds` (
  `exportfeed_id` int(11) NOT NULL AUTO_INCREMENT,
  `exportfeed_name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`exportfeed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `exportfeeds`
--

INSERT INTO `exportfeeds` (`exportfeed_id`, `exportfeed_name`) VALUES
(1, 'Фид для слайда на главной недвижимости');

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_feed_id` int(11) NOT NULL,
  `link_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `image_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `link_title` text COLLATE utf8_bin NOT NULL,
  `linkdatetime` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`link_id`, `provider_feed_id`, `link_url`, `image_url`, `link_title`, `linkdatetime`) VALUES
(9, 0, 'http://residential.ru.msn.com/analytics/62967', 'http://residential.ru.msn.com/images/content/msn_realty/analytics/2012/10/10/image001.jpg', 'В США опубликовали список самых жутких городов мира', '2012-10-10T13:37:00'),
(10, 0, 'http://residential.ru.msn.com/analytics/62967/link2/', 'http://residential.ru.msn.com/images/content/msn_realty/analytics/2012/10/10/image001.jpg', 'В Индии опубликовали список самых жутких городов мира', '2012-10-10T13:37:00');

-- --------------------------------------------------------

--
-- Структура таблицы `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `providers`
--

INSERT INTO `providers` (`provider_id`, `provider_name`) VALUES
(1, 'ORSN'),
(2, 'Maximum Web');

-- --------------------------------------------------------

--
-- Структура таблицы `provider_feeds`
--

CREATE TABLE IF NOT EXISTS `provider_feeds` (
  `feed_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `feed_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `feed_title` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`feed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `provider_feeds`
--

INSERT INTO `provider_feeds` (`feed_id`, `provider_id`, `feed_url`, `feed_title`) VALUES
(1, 1, 'http://residential.ru.msn.com/api/day_theme', 'Новости для слайда'),
(2, 1, 'http://realtylinks/feedtest.xml', 'тестовый фид');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
