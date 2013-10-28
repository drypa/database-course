-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Окт 26 2013 г., 11:25
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_kitty`(IN `name` VARCHAR(255) CHARSET cp1251, IN `birth_date` DATE, IN `breed_id` INT)
    NO SQL
insert into kitties (name,birth_date,breed_id) values (name,birth_date,breed_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_kitties_with_breed`()
    NO SQL
SELECT k.id,k.name,k.birth_date, b.name as breed 
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
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `breeds`
--

INSERT INTO `breeds` (`id`, `name`) VALUES
(1, 'Скоттиш-страйт (шотландская прямоухая кошка)'),
(2, 'Мейн-кун');

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id`, `name`) VALUES
(1, 'белый'),
(2, 'голубой'),
(3, 'чёрный'),
(4, 'полосатый'),
(5, 'шоколад');

-- --------------------------------------------------------

--
-- Структура таблицы `kitties`
--

CREATE TABLE IF NOT EXISTS `kitties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `breed_id` (`breed_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `kitties`
--

INSERT INTO `kitties` (`id`, `name`, `breed_id`, `birth_date`) VALUES
(1, 'Мурзик', 1, '2013-10-02'),
(2, 'Барсик', 2, '2013-09-04'),
(3, 'Борис', 1, '2013-08-01');

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
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `kitties_colors`
--

INSERT INTO `kitties_colors` (`id`, `kitty_id`, `color_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 4);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `kitties`
--
ALTER TABLE `kitties`
  ADD CONSTRAINT `kitties_ibfk_1` FOREIGN KEY (`breed_id`) REFERENCES `breeds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `kitties_colors`
--
ALTER TABLE `kitties_colors`
  ADD CONSTRAINT `kitties_colors_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kitties_colors_ibfk_1` FOREIGN KEY (`kitty_id`) REFERENCES `kitties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
