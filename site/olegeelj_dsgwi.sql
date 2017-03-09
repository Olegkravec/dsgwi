-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Час створення: Бер 09 2017 р., 16:14
-- Версія сервера: 10.1.18-MariaDB-cll-lve
-- Версія PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База даних: `olegeelj_dsgwi`
--

-- --------------------------------------------------------

--
-- Структура таблиці `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `station` int(8) NOT NULL,
  `time` varchar(24) DEFAULT NULL,
  `data` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `station` (`station`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп даних таблиці `data`
--

INSERT INTO `data` (`id`, `station`, `time`, `data`) VALUES
(3, 7, '2017-02-14 13:00:37', '22.38.20.485.1.0'),
(4, 6, '2017-02-14 13:01:19', '26.42.23.578.1.0'),
(5, 5, '2017-02-14 13:01:59', '19.31.17.342.1.0'),
(6, 8, '2017-02-14 13:03:08', '28.46.26.145.1.0'),
(7, 5, '2017-02-14 15:44:39', '33.45.30.180.137.1.1'),
(8, 8, '2017-02-14 15:45:15', '33.45.30.180.137.1.1'),
(9, 7, '2017-02-14 15:45:42', '33.45.30.180.137.1.1'),
(10, 6, '2017-02-14 15:46:22', '33.45.30.180.137.1.1'),
(11, 5, '2017-02-16 03:07:07', '2147483647.2147483647.2147483647.300.300.1.0'),
(12, 5, '2017-02-16 03:07:56', '2147483647.2147483647.2147483647.227.227.1.0'),
(13, 5, '2017-02-16 03:09:30', '2147483647.2147483647.2147483647.72.72.1.1'),
(14, 5, '2017-02-16 03:10:25', '17.40.15.81.82.1.1'),
(15, 5, '2017-02-16 03:11:27', '17.41.15.96.96.1.1'),
(16, 5, '2017-02-16 03:12:29', '17.42.15.1004.105.1.1'),
(17, 5, '2017-02-16 03:13:31', '17.42.15.1024.916.1.1'),
(18, 5, '2017-02-16 03:14:32', '17.41.15.91.90.1.1');

-- --------------------------------------------------------

--
-- Структура таблиці `station`
--

CREATE TABLE IF NOT EXISTS `station` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL,
  `city` varchar(22) NOT NULL,
  `adress` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп даних таблиці `station`
--

INSERT INTO `station` (`id`, `name`, `city`, `adress`) VALUES
(5, 'VOL0001', 'Lutsk', 'Koniakina 5'),
(6, 'MOSCOW0001', 'Moskow', 'Krasnaia 18'),
(7, 'ROW0001', 'Rivne', 'Zaliznichnaia 4'),
(8, 'KIEV0001', 'Kiev', 'Miru 3');

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`station`) REFERENCES `station` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
