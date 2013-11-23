-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Ноя 23 2013 г., 01:34
-- Версия сервера: 5.5.32
-- Версия PHP: 5.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kitties`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_kitty`(IN `name` VARCHAR(255) CHARSET cp1251, IN `birth_date` DATE, IN `breed_id` INT, IN `sex` BIT(1), IN `toilet_trained` BIT(1))
    NO SQL
insert into kitties (name,birth_date,sex,toilet_trained,breed_id) values (name,birth_date,sex,toilet_trained,breed_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_kitties_with_breed`()
    NO SQL
SELECT k.id,k.name,k.birth_date,k.sex,k.toilet_trained, b.name as breed 
FROM kitties AS k
INNER JOIN breeds AS b ON b.id = k.breed_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `breeds`
--

CREATE TABLE IF NOT EXISTS `breeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `breeds`
--

INSERT INTO `breeds` (`id`, `name`) VALUES
(1, 'Скоттиш-страйт (шотландская прямоухая кошка)'),
(2, 'Мейн-кун'),
(5, 'Дворовый кот'),
(6, 'кот баскервилей'),
(7, 'Абиссинская');

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id`, `name`) VALUES
(1, 'белый'),
(2, 'голубой'),
(3, 'чёрный'),
(4, 'полосатый'),
(5, 'шоколад'),
(6, 'серо-буро-малиновый'),
(7, 'прозрачный'),
(8, 'мимими розовенький'),
(9, 'черный');

-- --------------------------------------------------------

--
-- Структура таблицы `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `food`
--

INSERT INTO `food` (`id`, `name`) VALUES
(1, 'рыба'),
(2, 'молоко'),
(3, 'говядина'),
(4, 'свинина'),
(5, 'сыр');

-- --------------------------------------------------------

--
-- Структура таблицы `kitties`
--

CREATE TABLE IF NOT EXISTS `kitties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `toilet_trained` bit(1) NOT NULL,
  `sex` bit(1) NOT NULL,
  `human_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breed_id` (`breed_id`),
  KEY `adoption_id` (`human_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `kitties`
--

INSERT INTO `kitties` (`id`, `name`, `breed_id`, `birth_date`, `toilet_trained`, `sex`, `human_id`) VALUES
(2, 'Барсик', 2, '2013-09-05', b'1', b'1', NULL),
(3, 'Борис', 1, '2013-08-01', b'0', b'0', NULL),
(5, 'Кыся', 2, '2010-10-20', b'0', b'1', NULL),
(9, 'Мартын', 5, '2010-10-20', b'1', b'1', NULL),
(19, 'Кыся123', 1, '2010-10-20', b'0', b'0', '1234 5050'),
(21, 'Страшила', 6, '2010-10-20', b'0', b'1', NULL),
(23, 'qqqqq', 6, '2010-10-20', b'0', b'1', NULL),
(26, 'Страшила', 6, '2010-10-20', b'1', b'0', NULL),
(27, 'Кыся123', 1, '2010-10-20', b'0', b'0', '1'),
(28, 'ййй', 2, '2013-09-04', b'1', b'0', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `kitties_colors`
--

CREATE TABLE IF NOT EXISTS `kitties_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kitty_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kitty_id` (`kitty_id`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=46 ;

--
-- Дамп данных таблицы `kitties_colors`
--

INSERT INTO `kitties_colors` (`id`, `kitty_id`, `color_id`) VALUES
(16, 19, 1),
(17, 19, 2),
(18, 19, 3),
(19, 19, 4),
(20, 19, 5),
(21, 19, 6),
(26, 26, 7),
(27, 27, 1),
(28, 27, 2),
(29, 27, 3),
(30, 27, 4),
(31, 27, 5),
(32, 27, 6),
(33, 27, 7),
(34, 27, 8),
(41, 2, 1),
(42, 2, 4),
(43, 2, 7),
(44, 2, 8),
(45, 28, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `kitties_food`
--

CREATE TABLE IF NOT EXISTS `kitties_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kitty_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kitty_id` (`kitty_id`),
  KEY `food_id` (`food_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `kitties_food`
--

INSERT INTO `kitties_food` (`id`, `kitty_id`, `food_id`) VALUES
(1, 28, 1),
(2, 28, 2),
(3, 3, 2),
(4, 9, 1),
(5, 9, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `document_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`document_number`),
  KEY `document_number` (`document_number`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `people`
--

INSERT INTO `people` (`document_number`, `name`, `surname`, `address`) VALUES
('1', 'Иван', '', 'Спб'),
('1111 0000', 'Дмитрий', 'Дмитриев', 'Дмитров ул. Ленина д.1'),
('1234 5050', 'петр', 'петров', 'Столица'),
('2', 'Марья', '', 'Москва');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `kitties`
--
ALTER TABLE `kitties`
  ADD CONSTRAINT `kitties_ibfk_2` FOREIGN KEY (`human_id`) REFERENCES `people` (`document_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kitties_ibfk_1` FOREIGN KEY (`breed_id`) REFERENCES `breeds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `kitties_colors`
--
ALTER TABLE `kitties_colors`
  ADD CONSTRAINT `kitties_colors_ibfk_1` FOREIGN KEY (`kitty_id`) REFERENCES `kitties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kitties_colors_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `kitties_food`
--
ALTER TABLE `kitties_food`
  ADD CONSTRAINT `kitties_food_ibfk_1` FOREIGN KEY (`kitty_id`) REFERENCES `kitties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kitties_food_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
