-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 13 2010 г., 22:16
-- Версия сервера: 5.1.40
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `detailersparadise`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_cart`
--

CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ct_qty` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `ct_session_id` char(32) NOT NULL DEFAULT '',
  `ct_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ct_id`),
  KEY `pd_id` (`pd_id`),
  KEY `ct_session_id` (`ct_session_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=114 ;

--
-- Дамп данных таблицы `tbl_cart`
--

INSERT INTO `tbl_cart` (`ct_id`, `pd_id`, `ct_qty`, `ct_session_id`, `ct_date`) VALUES
(113, 24, 1, 'fcb95e6820f8aed0e21acb58bd010631', '2010-05-20 22:23:57'),
(112, 22, 5, 'e3ff661fb008c458655cae07371bde46', '2010-05-19 12:27:31'),
(111, 25, 1, '10c3ec0197d6f1987f1aa5dd47c79a98', '2010-05-19 11:45:07');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `cat_name` varchar(50) NOT NULL DEFAULT '',
  `cat_image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`),
  KEY `cat_parent_id` (`cat_parent_id`),
  KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=32 ;

--
-- Дамп данных таблицы `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_parent_id`, `cat_name`, `cat_image`) VALUES
(25, 0, 'Воски', '426c4f6de07bbfd049ec504f6c0eec08.jpg'),
(24, 0, 'Абразивные пасты', '211bbec82f04b1579e5d05c492d198fd.jpg'),
(26, 0, 'Шампуни и очистители', 'b2786a368724585ce0bfebcfd77f4a63.jpg'),
(27, 0, 'Салон', '740604e6510b52935c61c7db8ae28a67.jpg'),
(28, 0, 'Диски', 'd874b441703fcb29c9dab385178308eb.jpg'),
(29, 0, 'Пластик и резина', 'beb1296c64ba71b064660254aa5dce5d.jpg'),
(30, 0, 'Стекло', 'deb88a5510c517580eab17e7c0b67520.jpg'),
(31, 0, 'Аксессуары', 'ec7f2531ae90e6cd13b9b4fbe6554100.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_currency`
--

CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `cy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cy_code` char(3) NOT NULL DEFAULT '',
  `cy_symbol` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`cy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_currency`
--

INSERT INTO `tbl_currency` (`cy_id`, `cy_code`, `cy_symbol`) VALUES
(1, 'EUR', '&#8364;'),
(4, 'USD', '$');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `od_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `od_date` datetime DEFAULT NULL,
  `od_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `od_status` enum('New','Paid','Shipped','Completed','Cancelled') NOT NULL DEFAULT 'New',
  `od_memo` varchar(255) NOT NULL DEFAULT '',
  `od_shipping_first_name` varchar(50) NOT NULL DEFAULT '',
  `od_shipping_last_name` varchar(50) NOT NULL DEFAULT '',
  `od_shipping_address1` varchar(100) NOT NULL DEFAULT '',
  `od_shipping_address2` varchar(100) NOT NULL DEFAULT '',
  `od_shipping_phone` varchar(32) NOT NULL DEFAULT '',
  `od_shipping_city` varchar(100) NOT NULL DEFAULT '',
  `od_shipping_state` varchar(32) NOT NULL DEFAULT '',
  `od_shipping_postal_code` varchar(10) NOT NULL DEFAULT '',
  `od_shipping_cost` decimal(5,2) DEFAULT '0.00',
  `od_payment_first_name` varchar(50) NOT NULL DEFAULT '',
  `od_payment_last_name` varchar(50) NOT NULL DEFAULT '',
  `od_payment_address1` varchar(100) NOT NULL DEFAULT '',
  `od_payment_address2` varchar(100) NOT NULL DEFAULT '',
  `od_payment_phone` varchar(32) NOT NULL DEFAULT '',
  `od_payment_city` varchar(100) NOT NULL DEFAULT '',
  `od_payment_state` varchar(32) NOT NULL DEFAULT '',
  `od_payment_postal_code` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`od_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1004 ;

--
-- Дамп данных таблицы `tbl_order`
--

INSERT INTO `tbl_order` (`od_id`, `od_date`, `od_last_update`, `od_status`, `od_memo`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`) VALUES
(1001, '2010-05-17 01:31:26', '2010-05-19 12:52:16', 'Cancelled', '', 'Aleksandra', 'Velomojkina', 'Adrese 5 iela 7', '', '22115544', 'Рига', '', 'LV-1021', 5.00, 'Aleksandra', 'Velomojkina', 'Adrese 5 iela 7', '', '22115544', 'Рига', '', 'LV-1021'),
(1002, '2010-05-18 21:02:49', '2010-05-19 12:51:35', 'Completed', '', 'Aleksandra', 'Velomojkina', 'Adrese 5 iela 7', '', '22115544', 'Рига', '', 'LV-1021', 15.00, 'Aleksandra', 'Velomojkina', 'Adrese 5 iela 7', '', '22115544', 'Рига', '', 'LV-1021'),
(1003, '2010-05-19 11:43:04', '2010-05-19 11:43:54', 'Paid', '', 'Aleksandra', 'Velomojkina', 'Adrese 5 iela 7', '', '22115544', 'Рига', '', 'LV-1021', 15.00, 'Aleksandra', 'Velomojkina', 'Adrese 5 iela 7', '', '22115544', 'Рига', '', 'LV-1021');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_order_item`
--

CREATE TABLE IF NOT EXISTS `tbl_order_item` (
  `od_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pd_id` int(10) unsigned NOT NULL DEFAULT '0',
  `od_qty` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`od_id`,`pd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `tbl_order_item`
--

INSERT INTO `tbl_order_item` (`od_id`, `pd_id`, `od_qty`) VALUES
(1001, 22, 1),
(1002, 22, 1),
(1002, 27, 1),
(1003, 23, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `pd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pd_name` varchar(100) NOT NULL DEFAULT '',
  `pd_description` text NOT NULL,
  `pd_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `pd_qty` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pd_image` varchar(200) DEFAULT NULL,
  `pd_thumbnail` varchar(200) DEFAULT NULL,
  `pd_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pd_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pd_id`),
  KEY `cat_id` (`cat_id`),
  KEY `pd_name` (`pd_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `tbl_product`
--

INSERT INTO `tbl_product` (`pd_id`, `cat_id`, `pd_name`, `pd_description`, `pd_price`, `pd_qty`, `pd_image`, `pd_thumbnail`, `pd_date`, `pd_last_update`) VALUES
(22, 24, 'Einszett Extra Lack Reiniger', 'Интенсивное средство для тусклой, старой краски с агрессивным действием полировки. Удаляет окисленные слои краски, восстанавливая первоначальную глубину цвета, скрывая мелкие царапины. Очищает и защищает от атмосферных неблагоприятных воздействий поверхность не оставляя полос. Яркий блеск достигается благодаря содержанию специального силикона. Не рекомендуется для применения на новых автомобилях. Для достижения высокого блеска мы вам рекомендуем завершить обработку полиролем для придания глянца.', 4.90, 10, 'f6122ce94cce37b4d13637b71a30ada8.jpg', '2c86695f9862f1d80c0722b25c1e67e3.jpg', '2010-05-05 13:27:13', '0000-00-00 00:00:00'),
(23, 24, 'Einszett Lack Politur', 'Полироль, восстанавливающий сияние лака, для слегка окисленной и тусклой краски в хорошем состоянии. Чистит, полирует и защищает за одно прикосновение. Не оставляет на поверхности полос. Обладает водоотталкивающими свойствами. Создает стойкий защитный слой, защищающий от атмосферного воздействия. Возвращает поверхности оригинальный блеск, который длится в течение нескольких месяцев. Для ручной полировки и со специальным оборудованием.', 4.85, 11, '04c6a469aab8b9aad1982a99c30c82f7.jpg', 'aeaf44aadbf3f07af2a400d3b6af756d.jpg', '2010-05-05 13:29:03', '0000-00-00 00:00:00'),
(24, 25, 'Einszett Hart Glanz', 'Высокоэффективный защитный воск длительного действия, придающий поверхности яркий глянец. Не содержит агрессивные абразивы. Синтетическая формула воска обладает водоотталкивающими и защитными свойствами, что позволяет защитить лакокрасочное покрытие от вредного воздействия окружающей среды, грязи и соли. Силикон и твердый воск образуют устойчивую к воздействию шампуней пленку. Силикон придает поверхности устойчивый глянец. Не оставляет на поверхности полос.', 5.10, 9, '2ac597befc633719919d702951c69c47.jpg', '52dcbdfed487f0a318f0459f291924f0.jpg', '2010-05-05 13:29:54', '0000-00-00 00:00:00'),
(25, 25, 'Einszett Metallic PolishWax', 'Специальный полироль, предназначенный для обработки новых и почти новых поверхностей окрашенных металлическими лаками. Мягко очищает и создает защитную и водоотталкивающую пленку длительного действия за одно прикосновение. Мельчайшие полировочные компоненты очищают поверхность, придавая ей обновленный вид. Силикон придает поверхности устойчивый глянец. Очень легок в использовании, быстро сохнет.', 5.05, 10, 'c8aba416843d7b955cd80286b8c1318d.jpg', '6798404e2c4392dd935cda05ff37be51.jpg', '2010-05-05 13:30:37', '0000-00-00 00:00:00'),
(26, 26, 'Einszett Anti-Insekt + Vorreiniger', 'Концентрированная жидкость для легкого и безопасного удаления насекомых и мошек с лакокрасочной, хромированной, стеклянной, резиновой и пластиковой поверхности. Не содержит формалинов. Не оказывает вредного воздействия на кожу. Биоразлагаем.', 3.70, 11, 'e146b5db1a4c4154076884e546123a0f.jpg', 'ce3d94d62cc61304e9fdf956ef3db91f.jpg', '2010-05-05 13:31:47', '0000-00-00 00:00:00'),
(27, 26, 'Einszett Raindance Wash + Wax', 'Высококонцентрированное пенное средство для мойки и придания блеска. Обладает тройным действием: легко и быстро удаляет загрязнения, благодаря полимерным компонентам обеспечивает длительную защиту от неблагоприятного влияния окружающей среды, надолго сохраняет зеркально-сверкающей поверхность автомобиля. Регулярное использование позволит надолго сохранить лакокрасочное покрытие.', 3.90, 5, '5ff782339259d847211f792f23d5f36c.jpg', '0690e5d4d5cb129380ce8133097daed1.jpg', '2010-05-05 13:32:49', '0000-00-00 00:00:00'),
(28, 27, 'Einszett Cockpit Premium', 'Средство для очистки, обновления и защиты пластика интерьера. Придает поверхности матовый блеск, защищает от выцветания. Антистатик. Обладает приятным цитрусовым ароматом и устраняет неприятные запахи. Безопасен для окружающей среды. Имеет водную основу. Разлагается микроорганизмами. Не содержит формалин.\r\nОбласть применения: для всех пластиковых, а также окрашенных пластиковых поверхностей интерьера. Идеально подходит для чистки гладких поверхностей из стекла, оргстекла, окрашенных металлов.', 4.00, 4, 'c7ec84952c3d615a90d80313ee66196c.jpg', 'f178eb122775af151053b8262413598b.jpg', '2010-05-05 13:34:10', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_shop_config`
--

CREATE TABLE IF NOT EXISTS `tbl_shop_config` (
  `sc_name` varchar(50) NOT NULL DEFAULT '',
  `sc_address` varchar(100) NOT NULL DEFAULT '',
  `sc_phone` varchar(30) NOT NULL DEFAULT '',
  `sc_email` varchar(30) NOT NULL DEFAULT '',
  `sc_shipping_cost` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sc_currency` int(10) unsigned NOT NULL DEFAULT '1',
  `sc_order_email` enum('y','n') NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `tbl_shop_config`
--

INSERT INTO `tbl_shop_config` (`sc_name`, `sc_address`, `sc_phone`, `sc_email`, `sc_shipping_cost`, `sc_currency`, `sc_order_email`) VALUES
('Detailer''s Paradise', 'Salaspils iela 23', '22115522', 'test@mail.lv', 3.00, 1, 'y');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL DEFAULT '',
  `user_password` varchar(32) NOT NULL DEFAULT '',
  `user_regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_password`, `user_regdate`, `user_last_login`) VALUES
(6, 'admin', 'admin', '0000-00-00 00:00:00', '2010-05-20 22:30:22');
