-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: h901105040.mysql
-- Время создания: Дек 19 2020 г., 13:41
-- Версия сервера: 5.6.41-84.1
-- Версия PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `h901105040_s1`
--
CREATE DATABASE IF NOT EXISTS `h901105040_s1` DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE `h901105040_s1`;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_add_fields`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_add_fields`;
CREATE TABLE `arwm_add_fields` (
  `field_id` int(11) UNSIGNED NOT NULL,
  `field_name` varchar(64) NOT NULL,
  `type` tinyint(2) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `use_in_order` tinyint(1) NOT NULL,
  `use_in_feedback` tinyint(1) NOT NULL,
  `width` int(11) UNSIGNED NOT NULL,
  `height` int(11) UNSIGNED NOT NULL,
  `def_value` text NOT NULL,
  `def_from_last_order` tinyint(1) UNSIGNED NOT NULL,
  `placeholder` text NOT NULL,
  `contexthelp` text NOT NULL,
  `add_attributes` text NOT NULL,
  `pay_methods` text NOT NULL,
  `sortid` mediumint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_add_fields`
--

INSERT INTO `arwm_add_fields` (`field_id`, `field_name`, `type`, `title`, `required`, `enabled`, `use_in_order`, `use_in_feedback`, `width`, `height`, `def_value`, `def_from_last_order`, `placeholder`, `contexthelp`, `add_attributes`, `pay_methods`, `sortid`) VALUES
(1, 'example', 1, 'Пример дополнительного поля', 0, 0, 1, 1, 39, 0, '', 0, '', '', '', '', 0),
(2, 'how_about', 1, 'Откуда Вы о нас узнали?', 0, 0, 1, 1, 39, 0, '', 0, '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_add_fields_variants`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_add_fields_variants`;
CREATE TABLE `arwm_add_fields_variants` (
  `value_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `def` tinyint(1) UNSIGNED NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_admin`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_admin`;
CREATE TABLE `arwm_admin` (
  `adminid` mediumint(11) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_admin`
--

INSERT INTO `arwm_admin` (`adminid`, `name`, `password`, `status`) VALUES
(1, '4f11ad9c6802a7c5df56b933ced9a7f2', '976e17cfaadf5773663f4333efd7b752', 'main_admin');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_cache`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_cache`;
CREATE TABLE `arwm_cache` (
  `reqid` int(11) UNSIGNED NOT NULL,
  `request` text NOT NULL,
  `mdate` int(11) UNSIGNED NOT NULL,
  `http_code` smallint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_categories`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_categories`;
CREATE TABLE `arwm_categories` (
  `catid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `fcatname` varchar(255) NOT NULL,
  `parent` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `menu_img` varchar(255) NOT NULL,
  `main_img` varchar(255) NOT NULL,
  `count` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `metatags` text NOT NULL,
  `special` mediumtext NOT NULL,
  `fulltitle` text NOT NULL,
  `sortid` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_categories`
--

INSERT INTO `arwm_categories` (`catid`, `fcatname`, `parent`, `title`, `description`, `image`, `menu_img`, `main_img`, `count`, `meta_title`, `meta_description`, `keywords`, `metatags`, `special`, `fulltitle`, `sortid`) VALUES
(0, '', 0, '', '<h2><span style=\"font-size: 14pt; color: #0000ff;\">&nbsp; <br /><a href=\"http://www.arhiv-proekt.ru\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов <span style=\"color: red; font-size: large;\"> www.arhiv-proekt.ru</span>;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги. Добро пожаловать в наш магазин проектов!<br /></span></h2>', '', '', '', 0, 'DOCS_SHOP Интернет-магазин проектов', 'Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги. Здесь можно купить проектную документацию.', 'Разработка, проекта, Проект, документация, водотведение, коллектор,  строительство, жилые дома. коттеджи, объекты, здравохранения, дошкольные учреждения. школы, купить, проектную документацию', '<!-- Yandex.Metrika counter -->\r\n<script type=\"text/javascript\" >\r\n   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};\r\n   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})\r\n   (window, document, \"script\", \"https://mc.yandex.ru/metrika/tag.js\", \"ym\");\r\n\r\n   ym(57336001, \"init\", {\r\n        clickmap:true,\r\n        trackLinks:true,\r\n        accurateTrackBounce:true,\r\n        webvisor:true,\r\n        ecommerce:\"dataLayer\"\r\n   });\r\n</script>\r\n<noscript><div><img src=\"https://mc.yandex.ru/watch/57336001\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript>\r\n<!-- /Yandex.Metrika counter -->', '', 'Warning! This is special line for main page. Do not delete this record with catid = 0!', 0),
(1, 'Водоснабжение', 0, 'Проекты водоснабжения', '<h2>Архив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>\r\n<h3>Для разработчиков проектной документации, строителей и студентов, а также для всех заинтересованных лиц</h3>\r\n<p><span style=\"font-size: 14pt;\"><strong>ВОДОСНАБЖЕНИЕ</strong></span></p>', '', '', '', 7, 'Проекты водоснабжения', 'Проекты водоснабжения', 'проект, документация, водоснабжение, водопровод', '', '', 'Проекты водоснабжения', 0),
(2, 'Проекты водоотведения', 0, 'Проекты водоотведения', '<h2>Архив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>\r\n<p><span style=\"font-size: 14pt;\"><strong>ВОДООТВЕДЕНИЕ</strong></span></p>', '', '', '', 9, 'Проекты водоотведения', 'Проекты водоотведения', 'Проект, документация, водотведение, коллектор, разработка', '', '', 'Проекты водоотведения', 0),
(3, 'Proekti-avtomobilnih-dorog', 0, 'Проекты автомобильных дорог', '', '', '', '', 6, '', '', 'Проект, документация, разработка, автомобильные. дороги', '', '', 'Проекты автомобильных дорог', 0),
(4, 'Proekti-zhilih-domov', 0, 'Проекты жилых домов', '', '', '', '', 4, '', '', 'Проект, документация, разработка, жилые. дома', '', '', 'Проекты жилых домов', 0),
(5, 'zhilihe-doma', 0, 'Проекты на линейные инженерные сети', '', '', '', '', 1, '', '', 'Проект, документация, разработка, линейные,  инженерные,  сети', '', '', 'Проекты на линейные инженерные сети', 0),
(6, 'Proekti-doshkolnih-uchrezhdenij', 0, 'Проекты дошкольных учреждений', '', '', '', '', 3, '', '', 'Проект, документация,  разработка, дошкольные,  учреждения', '', '', 'Проекты дошкольных учреждений', 0),
(7, 'Proekti-uchrezhdenij-kulturi', 0, 'Проекты учреждений культуры', '', '', '', '', 3, '', '', 'Проект, документация,  разработка, учреждения. культуры', '', '', 'Проекты учреждений культуры', 0),
(8, 'Proekti-lechebnih-uchrezhdenij', 0, 'Проекты лечебных учреждений', '', '', '', '', 8, '', '', 'Проект, документация,  разработка, лечебные, учреждения', '', '', 'Проекты лечебных учреждений', 0),
(12, 'Proekti-obektov-obshhestvennogo-pitaniya', 0, 'Проекты объектов общественного питания', '', '', '', '', 1, '', '', 'Проекты,  объектов,  общественного,  питания', '', '', 'Проекты объектов общественного питания', 0),
(13, 'Proekti-administrativnih-obektov', 0, 'Проекты административных и торговых объектов', '', '', '', '', 2, '', '', '', '', '', 'Проекты административных и торговых объектов', 0),
(10, 'Proekti-na-proizvodstvennie-obekti', 0, 'Проекты производственных объектов', '', '', '', '', 8, '', '', 'Проект, документация, водотведение, разработка, производственные,  объекты', '', '', 'Проекты производственных объектов', 0),
(11, 'Proekti-uchebnih-uchrezhdenij', 0, 'Проекты учреждений образования', '<p>Проекты учреждений образования</p>', '', '', '', 1, '', '', 'проект. учебный, учреждение', '', '', 'Проекты учреждений образования', 0),
(14, 'POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV', 0, 'ПОЛНЫЙ ДОСТУП К АРХИВУ ПРОЕКТОВ', '', '', '', '', 5, '', '', 'ПОЛНЫЙ,  ДОСТУП,  К АРХИВУ,   ПРОЕКТОВ', '', '', 'ПОЛНЫЙ ДОСТУП К АРХИВУ ПРОЕКТОВ', 0),
(15, 'BIBLIOTEKA-normi-pravila-dokumenti-knigi', 0, 'БИБЛИОТЕКА(нормы, правила, документы, книги)', '', '', '', '', 1, '', '', '', '', '', 'БИБЛИОТЕКА(нормы, правила, документы, книги)', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_cntlastip`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Дек 15 2020 г., 16:30
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_cntlastip`;
CREATE TABLE `arwm_cntlastip` (
  `lastip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_cntlastip`
--

INSERT INTO `arwm_cntlastip` (`lastip`) VALUES
('209.17.96.66');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_content`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_content`;
CREATE TABLE `arwm_content` (
  `pname` varchar(255) NOT NULL,
  `menutitle` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `metatags` text NOT NULL,
  `special` mediumtext NOT NULL,
  `text` mediumtext NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_content`
--

INSERT INTO `arwm_content` (`pname`, `menutitle`, `title`, `description`, `keywords`, `metatags`, `special`, `text`, `sortid`) VALUES
('about', 'О компании', 'О компании', '', '', '', '', '<p style=\"text-align: center;\"><span style=\"color: #0000ff;\"><strong><span style=\"font-size: 18pt;\">Интернет-магазин DOCS_SHOP.</span></strong></span> <span style=\"font-size: 14pt; color: #ff0000;\">Сайт www.docs-proekt.shop.&nbsp;</span></p>\r\n<p style=\"text-align: left;\"><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; В магазине представлен&nbsp; а</span><span style=\"font-size: 14pt;\">рхив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</span></strong></p>\r\n<h3><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; &nbsp;Предлагаемая документация представляет интерес для разработчиков проектной документации, строителей и студентов, а также для всех заинтересованных лиц.</span></strong></h3>\r\n<p><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; Архивные материалы могут быть использованы в качестве аналогов при разработке проектов на строительство,проектов организации строительства и дипломных проектов.</span></strong></p>\r\n<p><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; Подробнее в&nbsp; <br /><a href=\"http://www.arhiv-proekt.ru\" target=\"_blank\" rel=\"noopener\">АРХИВЕ проектов <span style=\"color: red; font-size: large;\"> www.arhiv-proekt.ru</span>;</a></span></strong></p>', 0),
('contacts', 'Контакты', 'Контакты', '', '', '', '', '<p><span style=\"font-size: 14pt; color: #0000ff;\">Администрация интернет-магазина DOCS_SHOP</span></p>\r\n<p><span style=\"font-size: 14pt; color: #0000ff;\">Электронная почта&nbsp;<span style=\"background-color: #ffffff;\"> &nbsp;<span style=\"color: #ff0000;\">docs_shop@arhiv-proekt.ru</span></span></span></p>', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_counter`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Дек 15 2020 г., 16:30
--

DROP TABLE IF EXISTS `arwm_counter`;
CREATE TABLE `arwm_counter` (
  `allvisits` bigint(11) UNSIGNED NOT NULL DEFAULT '0',
  `allhosts` bigint(11) UNSIGNED NOT NULL DEFAULT '0',
  `todayvisits` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `todayhosts` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `day` char(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_counter`
--

INSERT INTO `arwm_counter` (`allvisits`, `allhosts`, `todayvisits`, `todayhosts`, `day`) VALUES
(18725, 6975, 1, 1, '15');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_countries`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_countries`;
CREATE TABLE `arwm_countries` (
  `country_id` smallint(4) UNSIGNED NOT NULL,
  `country_name` varchar(64) NOT NULL,
  `iso_numeric` char(3) NOT NULL,
  `iso_alpha3` char(3) NOT NULL,
  `iso_alpha2` char(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_countries`
--

INSERT INTO `arwm_countries` (`country_id`, `country_name`, `iso_numeric`, `iso_alpha3`, `iso_alpha2`) VALUES
(1, 'Afghanistan', '004', 'AFG', 'AF'),
(2, 'Aland Islands', '248', 'ALA', 'AX'),
(3, 'Albania', '008', 'ALB', 'AL'),
(4, 'Algeria', '012', 'DZA', 'DZ'),
(5, 'American Samoa', '016', 'ASM', 'AS'),
(6, 'Andorra', '020', 'AND', 'AD'),
(7, 'Angola', '024', 'AGO', 'AO'),
(8, 'Anguilla', '660', 'AIA', 'AI'),
(9, 'Antarctica', '010', 'ATA', 'AQ'),
(10, 'Antigua and Barbuda', '028', 'ATG', 'AG'),
(11, 'Argentina', '032', 'ARG', 'AR'),
(12, 'Armenia', '051', 'ARM', 'AM'),
(13, 'Aruba', '533', 'ABW', 'AW'),
(14, 'Australia', '036', 'AUS', 'AU'),
(15, 'Austria', '040', 'AUT', 'AT'),
(16, 'Azerbaijan', '031', 'AZE', 'AZ'),
(17, 'Bahamas', '044', 'BHS', 'BS'),
(18, 'Bahrain', '048', 'BHR', 'BH'),
(19, 'Bangladesh', '050', 'BGD', 'BD'),
(20, 'Barbados', '052', 'BRB', 'BB'),
(21, 'Belarus', '112', 'BLR', 'BY'),
(22, 'Belgium', '056', 'BEL', 'BE'),
(23, 'Belize', '084', 'BLZ', 'BZ'),
(24, 'Benin', '204', 'BEN', 'BJ'),
(25, 'Bermuda', '060', 'BMU', 'BM'),
(26, 'Bhutan', '064', 'BTN', 'BT'),
(27, 'Bolivia', '068', 'BOL', 'BO'),
(28, 'Bosnia and Herzegovina', '070', 'BIH', 'BA'),
(29, 'Botswana', '072', 'BWA', 'BW'),
(30, 'Bouvet Island', '074', 'BVT', 'BV'),
(31, 'Brazil', '076', 'BRA', 'BR'),
(32, 'British Indian Ocean Territory', '086', 'IOT', 'IO'),
(33, 'Brunei Darussalam', '096', 'BRN', 'BN'),
(34, 'Bulgaria', '100', 'BGR', 'BG'),
(35, 'Burkina Faso', '854', 'BFA', 'BF'),
(36, 'Burundi', '108', 'BDI', 'BI'),
(37, 'Cambodia', '116', 'KHM', 'KH'),
(38, 'Cameroon', '120', 'CMR', 'CM'),
(39, 'Canada', '124', 'CAN', 'CA'),
(40, 'Cape Verde', '132', 'CPV', 'CV'),
(41, 'Cayman Islands', '136', 'CYM', 'KY'),
(42, 'Central African Republic', '140', 'CAF', 'CF'),
(43, 'Chad', '148', 'TCD', 'TD'),
(44, 'Chile', '152', 'CHL', 'CL'),
(45, 'China', '156', 'CHN', 'CN'),
(46, 'Christmas Island', '162', 'CXR', 'CX'),
(47, 'Cocos (Keeling) Islands', '166', 'CCK', 'CC'),
(48, 'Colombia', '170', 'COL', 'CO'),
(49, 'Comoros', '174', 'COM', 'KM'),
(50, 'Congo', '178', 'COG', 'CG'),
(51, 'Congo, Democratic Republic of the', '180', 'COD', 'CD'),
(52, 'Cook Islands', '184', 'COK', 'CK'),
(53, 'Costa Rica', '188', 'CRI', 'CR'),
(54, 'Cote d\'Ivoire', '384', 'CIV', 'CI'),
(55, 'Croatia', '191', 'HRV', 'HR'),
(56, 'Cuba', '192', 'CUB', 'CU'),
(57, 'Cyprus', '196', 'CYP', 'CY'),
(58, 'Czech Republic', '203', 'CZE', 'CZ'),
(59, 'Denmark', '208', 'DNK', 'DK'),
(60, 'Djibouti', '262', 'DJI', 'DJ'),
(61, 'Dominica', '212', 'DMA', 'DM'),
(62, 'Dominican Republic', '214', 'DOM', 'DO'),
(63, 'Ecuador', '218', 'ECU', 'EC'),
(64, 'Egypt', '818', 'EGY', 'EG'),
(65, 'El Salvador', '222', 'SLV', 'SV'),
(66, 'Equatorial Guinea', '226', 'GNQ', 'GQ'),
(67, 'Eritrea', '232', 'ERI', 'ER'),
(68, 'Estonia', '233', 'EST', 'EE'),
(69, 'Ethiopia', '231', 'ETH', 'ET'),
(70, 'Falkland Islands (Malvinas)', '238', 'FLK', 'FK'),
(71, 'Faroe Islands', '234', 'FRO', 'FO'),
(72, 'Fiji', '242', 'FJI', 'FJ'),
(73, 'Finland', '246', 'FIN', 'FI'),
(74, 'France', '250', 'FRA', 'FR'),
(75, 'French Guiana', '254', 'GUF', 'GF'),
(76, 'French Polynesia', '258', 'PYF', 'PF'),
(77, 'French Southern Territories', '260', 'ATF', 'TF'),
(78, 'Gabon', '266', 'GAB', 'GA'),
(79, 'Gambia', '270', 'GMB', 'GM'),
(80, 'Georgia', '268', 'GEO', 'GE'),
(81, 'Germany', '276', 'DEU', 'DE'),
(82, 'Ghana', '288', 'GHA', 'GH'),
(83, 'Gibraltar', '292', 'GIB', 'GI'),
(84, 'Greece', '300', 'GRC', 'GR'),
(85, 'Greenland', '304', 'GRL', 'GL'),
(86, 'Grenada', '308', 'GRD', 'GD'),
(87, 'Guadeloupe', '312', 'GLP', 'GP'),
(88, 'Guam', '316', 'GUM', 'GU'),
(89, 'Guatemala', '320', 'GTM', 'GT'),
(90, 'Guernsey', '831', 'GGY', 'GG'),
(91, 'Guinea', '324', 'GIN', 'GN'),
(92, 'Guinea-Bissau', '624', 'GNB', 'GW'),
(93, 'Guyana', '328', 'GUY', 'GY'),
(94, 'Haiti', '332', 'HTI', 'HT'),
(95, 'Heard Island and McDonald Islands', '334', 'HMD', 'HM'),
(96, 'Holy See (Vatican City State)', '336', 'VAT', 'VA'),
(97, 'Honduras', '340', 'HND', 'HN'),
(98, 'Hong Kong', '344', 'HKG', 'HK'),
(99, 'Hungary', '348', 'HUN', 'HU'),
(100, 'Iceland', '352', 'ISL', 'IS'),
(101, 'India', '356', 'IND', 'IN'),
(102, 'Indonesia', '360', 'IDN', 'ID'),
(103, 'Iran, Islamic Republic of', '364', 'IRN', 'IR'),
(104, 'Iraq', '368', 'IRQ', 'IQ'),
(105, 'Ireland', '372', 'IRL', 'IE'),
(106, 'Isle of Man', '833', 'IMN', 'IM'),
(107, 'Israel', '376', 'ISR', 'IL'),
(108, 'Italy', '380', 'ITA', 'IT'),
(109, 'Jamaica', '388', 'JAM', 'JM'),
(110, 'Japan', '392', 'JPN', 'JP'),
(111, 'Jersey', '832', 'JEY', 'JE'),
(112, 'Jordan', '400', 'JOR', 'JO'),
(113, 'Kazakhstan', '398', 'KAZ', 'KZ'),
(114, 'Kenya', '404', 'KEN', 'KE'),
(115, 'Kiribati', '296', 'KIR', 'KI'),
(116, 'Korea, Democratic People\'s Republic of', '408', 'PRK', 'KP'),
(117, 'Korea, Republic of', '410', 'KOR', 'KR'),
(118, 'Kuwait', '414', 'KWT', 'KW'),
(119, 'Kyrgyzstan', '417', 'KGZ', 'KG'),
(120, 'Lao People\'s Democratic Republic', '418', 'LAO', 'LA'),
(121, 'Latvia', '428', 'LVA', 'LV'),
(122, 'Lebanon', '422', 'LBN', 'LB'),
(123, 'Lesotho', '426', 'LSO', 'LS'),
(124, 'Liberia', '430', 'LBR', 'LR'),
(125, 'Libyan Arab Jamahiriya', '434', 'LBY', 'LY'),
(126, 'Liechtenstein', '438', 'LIE', 'LI'),
(127, 'Lithuania', '440', 'LTU', 'LT'),
(128, 'Luxembourg', '442', 'LUX', 'LU'),
(129, 'Macao', '446', 'MAC', 'MO'),
(130, 'Macedonia, the former Yugoslav Republic of', '807', 'MKD', 'MK'),
(131, 'Madagascar', '450', 'MDG', 'MG'),
(132, 'Malawi', '454', 'MWI', 'MW'),
(133, 'Malaysia', '458', 'MYS', 'MY'),
(134, 'Maldives', '462', 'MDV', 'MV'),
(135, 'Mali', '466', 'MLI', 'ML'),
(136, 'Malta', '470', 'MLT', 'MT'),
(137, 'Marshall Islands', '584', 'MHL', 'MH'),
(138, 'Martinique', '474', 'MTQ', 'MQ'),
(139, 'Mauritania', '478', 'MRT', 'MR'),
(140, 'Mauritius', '480', 'MUS', 'MU'),
(141, 'Mayotte', '175', 'MYT', 'YT'),
(142, 'Mexico', '484', 'MEX', 'MX'),
(143, 'Micronesia, Federated States of', '583', 'FSM', 'FM'),
(144, 'Moldova', '498', 'MDA', 'MD'),
(145, 'Monaco', '492', 'MCO', 'MC'),
(146, 'Mongolia', '496', 'MNG', 'MN'),
(147, 'Montenegro', '499', 'MNE', 'ME'),
(148, 'Montserrat', '500', 'MSR', 'MS'),
(149, 'Morocco', '504', 'MAR', 'MA'),
(150, 'Mozambique', '508', 'MOZ', 'MZ'),
(151, 'Myanmar', '104', 'MMR', 'MM'),
(152, 'Namibia', '516', 'NAM', 'NA'),
(153, 'Nauru', '520', 'NRU', 'NR'),
(154, 'Nepal', '524', 'NPL', 'NP'),
(155, 'Netherlands', '528', 'NLD', 'NL'),
(156, 'Netherlands Antilles', '530', 'ANT', 'AN'),
(157, 'New Caledonia', '540', 'NCL', 'NC'),
(158, 'New Zealand', '554', 'NZL', 'NZ'),
(159, 'Nicaragua', '558', 'NIC', 'NI'),
(160, 'Niger', '562', 'NER', 'NE'),
(161, 'Nigeria', '566', 'NGA', 'NG'),
(162, 'Niue', '570', 'NIU', 'NU'),
(163, 'Norfolk Island', '574', 'NFK', 'NF'),
(164, 'Northern Mariana Islands', '580', 'MNP', 'MP'),
(165, 'Norway', '578', 'NOR', 'NO'),
(166, 'Oman', '512', 'OMN', 'OM'),
(167, 'Pakistan', '586', 'PAK', 'PK'),
(168, 'Palau', '585', 'PLW', 'PW'),
(169, 'Palestinian Territory, Occupied', '275', 'PSE', 'PS'),
(170, 'Panama', '591', 'PAN', 'PA'),
(171, 'Papua New Guinea', '598', 'PNG', 'PG'),
(172, 'Paraguay', '600', 'PRY', 'PY'),
(173, 'Peru', '604', 'PER', 'PE'),
(174, 'Philippines', '608', 'PHL', 'PH'),
(175, 'Pitcairn', '612', 'PCN', 'PN'),
(176, 'Poland', '616', 'POL', 'PL'),
(177, 'Portugal', '620', 'PRT', 'PT'),
(178, 'Puerto Rico', '630', 'PRI', 'PR'),
(179, 'Qatar', '634', 'QAT', 'QA'),
(180, 'Reunion', '638', 'REU', 'RE'),
(181, 'Romania', '642', 'ROU', 'RO'),
(182, 'Russian Federation', '643', 'RUS', 'RU'),
(183, 'Rwanda', '646', 'RWA', 'RW'),
(184, 'Saint Barthelemy', '652', 'BLM', 'BL'),
(185, 'Saint Helena', '654', 'SHN', 'SH'),
(186, 'Saint Kitts and Nevis', '659', 'KNA', 'KN'),
(187, 'Saint Lucia', '662', 'LCA', 'LC'),
(188, 'Saint Martin (French part)', '663', 'MAF', 'MF'),
(189, 'Saint Pierre and Miquelon', '666', 'SPM', 'PM'),
(190, 'Saint Vincent and the Grenadines', '670', 'VCT', 'VC'),
(191, 'Samoa', '882', 'WSM', 'WS'),
(192, 'San Marino', '674', 'SMR', 'SM'),
(193, 'Sao Tome and Principe', '678', 'STP', 'ST'),
(194, 'Saudi Arabia', '682', 'SAU', 'SA'),
(195, 'Senegal', '686', 'SEN', 'SN'),
(196, 'Serbia', '688', 'SRB', 'RS'),
(197, 'Seychelles', '690', 'SYC', 'SC'),
(198, 'Sierra Leone', '694', 'SLE', 'SL'),
(199, 'Singapore', '702', 'SGP', 'SG'),
(200, 'Slovakia', '703', 'SVK', 'SK'),
(201, 'Slovenia', '705', 'SVN', 'SI'),
(202, 'Solomon Islands', '090', 'SLB', 'SB'),
(203, 'Somalia', '706', 'SOM', 'SO'),
(204, 'South Africa', '710', 'ZAF', 'ZA'),
(205, 'South Georgia and the South Sandwich Islands', '239', 'SGS', 'GS'),
(206, 'Spain', '724', 'ESP', 'ES'),
(207, 'Sri Lanka', '144', 'LKA', 'LK'),
(208, 'Sudan', '736', 'SDN', 'SD'),
(209, 'Suriname', '740', 'SUR', 'SR'),
(210, 'Svalbard and Jan Mayen', '744', 'SJM', 'SJ'),
(211, 'Swaziland', '748', 'SWZ', 'SZ'),
(212, 'Sweden', '752', 'SWE', 'SE'),
(213, 'Switzerland', '756', 'CHE', 'CH'),
(214, 'Syrian Arab Republic', '760', 'SYR', 'SY'),
(215, 'Taiwan, Province of China', '158', 'TWN', 'TW'),
(216, 'Tajikistan', '762', 'TJK', 'TJ'),
(217, 'Tanzania, United Republic of', '834', 'TZA', 'TZ'),
(218, 'Thailand', '764', 'THA', 'TH'),
(219, 'Timor-Leste', '626', 'TLS', 'TL'),
(220, 'Togo', '768', 'TGO', 'TG'),
(221, 'Tokelau', '772', 'TKL', 'TK'),
(222, 'Tonga', '776', 'TON', 'TO'),
(223, 'Trinidad and Tobago', '780', 'TTO', 'TT'),
(224, 'Tunisia', '788', 'TUN', 'TN'),
(225, 'Turkey', '792', 'TUR', 'TR'),
(226, 'Turkmenistan', '795', 'TKM', 'TM'),
(227, 'Turks and Caicos Islands', '796', 'TCA', 'TC'),
(228, 'Tuvalu', '798', 'TUV', 'TV'),
(229, 'Uganda', '800', 'UGA', 'UG'),
(230, 'Ukraine', '804', 'UKR', 'UA'),
(231, 'United Arab Emirates', '784', 'ARE', 'AE'),
(232, 'United Kingdom', '826', 'GBR', 'GB'),
(233, 'United States', '840', 'USA', 'US'),
(234, 'United States Minor Outlying Islands', '581', 'UMI', 'UM'),
(235, 'Uruguay', '858', 'URY', 'UY'),
(236, 'Uzbekistan', '860', 'UZB', 'UZ'),
(237, 'Vanuatu', '548', 'VUT', 'VU'),
(238, 'Venezuela', '862', 'VEN', 'VE'),
(239, 'Viet Nam', '704', 'VNM', 'VN'),
(240, 'Virgin Islands, British', '092', 'VGB', 'VG'),
(241, 'Virgin Islands, U.S.', '850', 'VIR', 'VI'),
(242, 'Wallis and Futuna', '876', 'WLF', 'WF'),
(243, 'Western Sahara', '732', 'ESH', 'EH'),
(244, 'Yemen', '887', 'YEM', 'YE'),
(245, 'Zambia', '894', 'ZMB', 'ZM'),
(246, 'Zimbabwe', '716', 'ZWE', 'ZW');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_currencies`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_currencies`;
CREATE TABLE `arwm_currencies` (
  `currency_id` mediumint(6) UNSIGNED NOT NULL,
  `brief` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `course` varchar(35) NOT NULL DEFAULT '1.00',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `iso_alpha` char(3) NOT NULL,
  `iso_numeric` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_currencies`
--

INSERT INTO `arwm_currencies` (`currency_id`, `brief`, `title`, `course`, `enabled`, `iso_alpha`, `iso_numeric`) VALUES
(1, 'руб', 'Российский рубль', '1', 1, 'RUR', '643'),
(2, 'у.е.', 'Условная единица', '30', 1, '', ''),
(3, 'WMZ', 'WebMoney Z', '30', 1, '', ''),
(6, 'WMR', 'WebMoney R', '1', 1, '', ''),
(50, '$', 'Доллар США', '23.8482', 1, 'USD', '840'),
(51, 'EUR', 'Евро', '37.0339', 1, 'EUR', '978'),
(52, 'грн', 'Украинская гривна', '4.3456', 1, 'UAH', '980');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_deliverymethods`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_deliverymethods`;
CREATE TABLE `arwm_deliverymethods` (
  `dmid` mediumint(6) UNSIGNED NOT NULL,
  `dmname` varchar(255) NOT NULL,
  `short_descript` text NOT NULL,
  `long_descript` mediumtext NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_cost` decimal(15,2) UNSIGNED NOT NULL,
  `free_delivery_sum` decimal(15,2) UNSIGNED NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_deliverymethods`
--

INSERT INTO `arwm_deliverymethods` (`dmid`, `dmname`, `short_descript`, `long_descript`, `enabled`, `delivery_cost`, `free_delivery_sum`, `sortid`) VALUES
(11, 'Электронная доставка', '<p><strong><span style=\"font-size: 12pt;\">Электронная доставка осуществляется по вашему адресу электронной почты, заявленному при оформлении заказа.&nbsp;</span></strong></p>', '<p><strong><span style=\"font-size: 12pt;\">Электронная доставка осуществляется по вашему адресу электронной почты, заявленному при оформлении заказа. На Ваш почтовый адрес будет отправлена ссылка, которую необходимо скопировать в адресную строку браузера для скачивания приобретенных материалов.</span></strong></p>', 1, '0.00', '0.00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_forgotpassword`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Авг 12 2020 г., 11:58
--

DROP TABLE IF EXISTS `arwm_forgotpassword`;
CREATE TABLE `arwm_forgotpassword` (
  `confirmkey` varchar(18) NOT NULL,
  `userid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `new_pwd` varchar(32) NOT NULL,
  `date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_forgotpassword`
--

INSERT INTO `arwm_forgotpassword` (`confirmkey`, `userid`, `new_pwd`, `date`, `status`) VALUES
('869619841029462733', 2, 'dab610ca8efa3d7391c69cdb5c36e88f', 1597233457, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_gallery`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_gallery`;
CREATE TABLE `arwm_gallery` (
  `imgid` int(11) UNSIGNED NOT NULL,
  `itemid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `small_img` varchar(255) NOT NULL,
  `big_img` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_gallery`
--

INSERT INTO `arwm_gallery` (`imgid`, `itemid`, `small_img`, `big_img`, `alt`) VALUES
(1, 37, '172-08_2-Pr-t_Kap-Rem_Bolnica_.jpg', '172-08_2-Pr-t_Kap-Rem_Bolnica_.jpg', ''),
(2, 37, '172-08_3-Pr-t_Kap-Rem_Bolnica_.jpg', '172-08_3-Pr-t_Kap-Rem_Bolnica_.jpg', ''),
(3, 38, '', '173-08_2-Kap_REM_DK.jpg', ''),
(4, 38, '', '173-08_3-Kap_REM_DK.jpg', ''),
(5, 38, '766431.jpg', '766431.jpg', ''),
(6, 38, '803881.jpg', '803881.jpg', ''),
(7, 39, '175-08_2-Pr-t_Rekonstr_Vodoprovod.jpg', '175-08_2-Pr-t_Rekonstr_Vodoprovod.jpg', ''),
(8, 39, '175-08_3-Pr-t_Rekonstr_Vodoprovod.jpg', '175-08_3-Pr-t_Rekonstr_Vodoprovod.jpg', ''),
(9, 40, '175-09_2-Pr-t_Rekonstr_Kanalizacin_sety.jpg', '175-09_2-Pr-t_Rekonstr_Kanalizacin_sety.jpg', ''),
(10, 40, '175-09_3-Pr-t_Rekonstr_Kanalizacin_sety.jpg', '175-09_3-Pr-t_Rekonstr_Kanalizacin_sety.jpg', ''),
(11, 41, '176-08_2-Pr-t_zamena_vodoprovoda.jpg', '176-08_2-Pr-t_zamena_vodoprovoda.jpg', ''),
(12, 42, '178-09_2-Pr-t_zamena_kollektora.jpg', '178-09_2-Pr-t_zamena_kollektora.jpg', ''),
(13, 44, '195-10_2-Pr-t_Razborki_Otvala.jpg', '195-10_2-Pr-t_Razborki_Otvala.jpg', ''),
(14, 44, '195-10_3-Pr-t_Razborki_Otvala.jpg', '195-10_3-Pr-t_Razborki_Otvala.jpg', ''),
(15, 45, '197-10_2-Pr-t_REM_Vodovoda.jpg', '197-10_2-Pr-t_REM_Vodovoda.jpg', ''),
(16, 45, '763942.jpg', '763942.jpg', ''),
(17, 5, '219-11_2-KOTTEDZ_DOM.jpg', '219-11_2-KOTTEDZ_DOM.jpg', ''),
(18, 46, '22-05_2-Pr-t_Zamena_Vodovoda.jpg', '22-05_2-Pr-t_Zamena_Vodovoda.jpg', ''),
(19, 48, '787283.jpg', '787283.jpg', ''),
(20, 50, '449503.jpg', '449503.jpg', ''),
(21, 50, '164960.jpg', '164960.jpg', ''),
(22, 51, '233-12_2-Pr-t_Avt-Dorogi-Shevchenko.jpg', '233-12_2-Pr-t_Avt-Dorogi-Shevchenko.jpg', ''),
(23, 51, '233-12_3-Pr-t_Avt-Dorogi-Shevchenko.jpg', '233-12_3-Pr-t_Avt-Dorogi-Shevchenko.jpg', ''),
(24, 52, '235-12_2-Pr-t_Avto-Doroga.jpg', '235-12_2-Pr-t_Avto-Doroga.jpg', ''),
(26, 52, '235-12_3-Pr-t_Avto-Doroga.jpg', '235-12_3-Pr-t_Avto-Doroga.jpg', ''),
(27, 52, '607817.jpg', '607817.jpg', ''),
(29, 53, '237-12_2-Pr-t-Avt-dorog_Lug.jpg', '237-12_2-Pr-t-Avt-dorog_Lug.jpg', ''),
(30, 53, '237-12_3-Pr-t-Avt-dorog_Lug.jpg', '237-12_3-Pr-t-Avt-dorog_Lug.jpg', ''),
(31, 54, '248-12_2-Pr-t_Avt-Doroga.jpg', '248-12_2-Pr-t_Avt-Doroga.jpg', ''),
(32, 54, '248-12_3-Pr-t_Avt-Doroga.jpg', '248-12_3-Pr-t_Avt-Doroga.jpg', ''),
(33, 59, '99-06_2-Pr-t_Rem_Vodosnabzeniye.jpg', '99-06_2-Pr-t_Rem_Vodosnabzeniye.jpg', ''),
(34, 59, '99-06_3-Pr-t_Rem_Vodosnabzeniye.jpg', '99-06_3-Pr-t_Rem_Vodosnabzeniye.jpg', ''),
(35, 59, '99-06_4-Pr-t_Rem_Vodosnabzeniye.jpg', '99-06_4-Pr-t_Rem_Vodosnabzeniye.jpg', ''),
(36, 60, '735469.jpg', '735469.jpg', ''),
(37, 60, '249-12_3-Avto_Doroga.jpg', '249-12_3-Avto_Doroga.jpg', ''),
(38, 61, '', '0-1_2-Teh-Biblioteka.jpg', ''),
(39, 61, '', '0-1_3-Teh-Biblioteka.jpg', ''),
(40, 61, '', '0-1_4-Teh-Biblioteka.jpg', ''),
(41, 61, '', '0-1_5-Teh-Biblioteka.jpg', ''),
(42, 61, '442864.jpg', '442864.jpg', ''),
(43, 61, '699128.jpg', '699128.jpg', ''),
(44, 61, '520949.jpg', '520949.jpg', ''),
(45, 61, '348463.jpg', '348463.jpg', ''),
(46, 61, '0-1_6-Teh-Biblioteka.jpg', '0-1_6-Teh-Biblioteka.jpg', '');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_items`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Июн 29 2020 г., 15:15
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_items`;
CREATE TABLE `arwm_items` (
  `itemid` int(11) UNSIGNED NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `catid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `mnf_id` int(11) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `quantity_txt` varchar(255) NOT NULL,
  `short_descript` text NOT NULL,
  `long_descript` mediumtext NOT NULL,
  `small_img` varchar(255) NOT NULL,
  `big_img` varchar(255) NOT NULL,
  `add_date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `upd_date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `meta_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `metatags` text NOT NULL,
  `special` text NOT NULL,
  `visible` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_items`
--

INSERT INTO `arwm_items` (`itemid`, `itemname`, `catid`, `mnf_id`, `sku`, `title`, `price`, `old_price`, `quantity`, `quantity_txt`, `short_descript`, `long_descript`, `small_img`, `big_img`, `add_date`, `upd_date`, `meta_title`, `description`, `keywords`, `metatags`, `special`, `visible`) VALUES
(1, 'Проек капитального ремонта  Больница №5 шх Южная', 8, 0, '113-07', 'Проект капитального ремонта  Больница №5 шх. Южная', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/uScH-oG5xaLqpA', '<p>Проект капитального ремонта Больница №5 шх. Южная</p>', '<p>Проект капитального ремонта Больница №5 шх. Южная</p>\r\n<p>Проектом капитального ремонта предусматривается выполнение следующих видов работ:</p>\r\n<p>1. Частичная перепланировка помещений здания литер &laquo;А&raquo;, в соответствии с техническим заданием и требованиями нормативных документов:</p>\r\n<p>На первом этаже терапевтического отделения:</p>\r\n<p>- разместить электрощитовую - перенести из сырого подвального помещения;</p>\r\n<p>- приемное отделение оборудовать евро-душевой кабиной, санузлом, раковиной, биде;</p>\r\n<p>- комнату гигиены оборудовать евро-душевой кабиной, душевым поддоном, раковиной, биде;</p>\r\n<p>-в мужском туалете установить писсуар, чашу напольную, унитаз и две раковины;</p>\r\n<p>- разместить приемную главного врача с подсобными помещениями (туалет, душ) в</p>', '113-07.png', '113-07.png', 1577728035, 1580887463, '', 'Проект капитального ремонта  Больница №5 шх. Южная. Купить проектную документацию.', 'Проект, документация, водотведение, коллектор, разработка', '<center><h2>Частичная перепланировка помещений здания литер «А», в соответствии с техническим заданием и требованиями нормативных документов</h2></center>', '', 1),
(2, 'Proekt-rastvorobetonnogo-uzla', 10, 0, '104-06', 'Проект растворобетонного  узла', '300.00', '450.00', 4294967295, 'https://yadi.sk/d/reW8m6N00isbgw  https://yadi.sk/d/8eq3eoCvwOzL1A', '<p>Проект растворобетонного узла</p>', '<p>Проект растворобетонного узла.</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 342px; top: -13px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '104-06-2-MBSU.jpg', '104-06-2-MBSU.jpg', 1577902287, 1580901056, 'Проект бетонорастворного узла', 'Проект бетонорастворного узла. Купить проектную документацию.', 'бетонорастворный, узел, бетон. раствор', '<center><h2>Производительность бетонорастворного узла на базе МБСУ-0,5-40 – 40 м³/час</h2></center>', '', 1),
(3, 'Proekt-zubotehnicheskoj-laboratorii', 8, 0, '126-07', 'Проект зуботехнической лаборатории', '150.00', '0.00', 4294967295, 'https://yadi.sk/d/gZY3X7KeR9SBFw', '<p>Проект зуботехнической лаборатории</p>', '<p align=\"justify\"><span style=\"font-family: Arial, sans-serif;\"><span style=\"font-size: large;\"><span style=\"font-size: medium;\"><span lang=\"ru-RU\"><strong>Данный проект по водопроводу и канализации зуботехнической лаборатории&nbsp; разработан на основании:</strong></span></span></span></span></p>\r\n<ol>\r\n<li>\r\n<p align=\"justify\"><span style=\"font-family: Arial, sans-serif;\"><span style=\"font-size: medium;\"><strong>Задания на проектирование. Приложение №1 к Муниципальному контракту №88 от 5 июля 2007г.</strong></span></span></p>\r\n</li>\r\n<li>\r\n<p align=\"justify\"><span style=\"font-family: Arial, sans-serif;\"><span style=\"font-size: medium;\"><strong>Технического задания от 5июля 2007г.</strong></span></span></p>\r\n</li>\r\n<li>\r\n<p align=\"justify\"><span style=\"font-family: Arial, sans-serif;\"><span style=\"font-size: medium;\"><strong>Архитектурно &ndash; строительных чертежей.</strong></span></span></p>\r\n</li>\r\n<li>\r\n<p align=\"justify\"><span style=\"font-family: Arial, sans-serif;\"><span style=\"font-size: medium;\"><strong>Требований СНиП 2.04.01-85* &laquo;Внутренний водопровод и канализация</strong></span></span></p>\r\n</li>\r\n</ol>\r\n<p align=\"justify\"><span style=\"font-family: Arial, sans-serif;\"><span style=\"font-size: medium;\"><strong>зданий&raquo;, СП 40-102-2000 &laquo;Проектирование и монтаж трубопроводов систем водоснабжения и канализации из полимерных материалов&raquo;.</strong></span></span></p>', '', '126-07_Zub_teh_laborat_.jpg', 1577903488, 1580887188, '', 'Проект зуботехнической лаборатории. Купить проектную документацию.', 'зуботехническая, лаборатория, архив, разработка, проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов, дома,  коттеджи, коттеджа, линейные,  инженерные,  сети, автомобильные, дороги', '<center><h2>Проект по водопроводу и канализации зуботехнической лаборатории </h2></center>', '', 1),
(4, 'Proekt-medsanchasti', 8, 0, '134-07', 'Проект медсанчасти', '1000.00', '0.00', 4294967295, 'https://yadi.sk/d/Oty0XORly8zIOg', '<p>Проект медсанчасти.</p>', '<p><span data-contrast=\"auto\">Проект медсанчасти.</span></p>\r\n<p><span data-contrast=\"auto\">Данным проектом принято:&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:555,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">- главный корпус (стационар на 46 коек);&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:555,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">- поликлиника на 270 посещений в сутки;&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:555,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">- хозяйственный корпус и другие вспомогательные объекты.&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:555,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">Главный корпус медсанчасти выполнен двухэтажным:</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:540,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">- 1 этаж: терапевтическое отделение на 28 коек; левое крыло отделения&nbsp; граничит с приемным отделением, правое &ndash; с поликлиникой;&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">- 2 этаж: хирургическое отделение на 18 коек; левое крыло связано с операционным блоком, правое с поликлиникой.&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559737&quot;:-2,&quot;335559740&quot;:360,&quot;469777462&quot;:[720,360],&quot;469777927&quot;:[0,0],&quot;469777928&quot;:[0,1]}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">Здание поликлиники двухэтажное. На 1-м этаже размещается детская поликлиника, клиническая лаборатория и скорая помощь. На 2-ом этаже - взрослая поликлиника, рентген кабинет, физиотерапевтический кабинет.&nbsp;&nbsp;</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:540,&quot;335559737&quot;:-2,&quot;335559740&quot;:360,&quot;469777462&quot;:[720,360],&quot;469777927&quot;:[0,0],&quot;469777928&quot;:[0,1]}\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:540,&quot;335559737&quot;:-2,&quot;335559740&quot;:360,&quot;469777462&quot;:[720,360],&quot;469777927&quot;:[0,0],&quot;469777928&quot;:[0,1]}\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">В подвале главного корпуса и поликлиники размещаются технические помещения.</span><span data-ccp-props=\"{&quot;335551550&quot;:6,&quot;335551620&quot;:6,&quot;335559731&quot;:540,&quot;335559737&quot;:-2,&quot;335559740&quot;:360}\">&nbsp;</span></p>', '43046.jpg', '43046.jpg', 1577903919, 1580844017, '', 'Проект медицинской санитарной части. купить проектную документацию.', 'медицинская. санитарная, часть, архив, проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов,  включая,  дома,  коттеджи, коттеджа, линейные,  инженерные,  сети, автомобильные, дороги', '<center><h2>Данным проектом принято:  \r\n\r\n- главный корпус (стационар на 46 коек);  \r\n\r\n- поликлиника на 270 посещений в сутки;  \r\n\r\n- хозяйственный корпус и другие вспомогательные объекты.  \r\n\r\n</h2></center>', '', 1),
(5, 'Proekt-kottedzha', 4, 0, '219-11', 'Проект коттеджа', '1000.00', '0.00', 4294967295, 'https://yadi.sk/d/lR--I_nQ4DnmKA', '<p>Проект коттеджа</p>', '<p><span style=\"font-size: 14pt;\">Проект коттеджа.</span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; line-height: 150%;\"><span style=\"font-size: 14pt;\"><strong>5. Архитектурно-планировочные решения(выписка).</strong></span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\"><span style=\"font-size: 14pt;\">Жилой дом двухэтажный с цокольным этажом сложной формы в плане.</span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\"><span style=\"font-size: 14pt;\">Высота помещений 3,0 м.</span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\"><span style=\"font-size: 14pt;\">В проектируемом жилом доме будут располагаться:</span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\"><span style=\"font-size: 14pt;\">- цокольный этаж на отметке -3,300м: коридор, мастерская, котельная, подвал, комната отдыха, холл, раздевалка, сауна, душевая;</span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\"><span style=\"font-size: 14pt;\">- 1 этаж на отм. 0,000м: гостинная, кухня, столовая, прихожая, кабинет;</span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\"><span style=\"font-size: 14pt;\">- 2 этаж на отм. : гостевая, 4 спальни, ванная.</span></p>\r\n<p><span style=\"font-size: 14pt;\"><strong>4.3. Технико-экономические показатели</strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">Общая площадь жилого дома &ndash; 361,53 м<sup>2 </sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;в том числе;</span></p>\r\n<p><span style=\"font-size: 14pt;\">-цокольный этаж - 150,5м<sup>2</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">- 1-ый этаж - 113,35 м<sup>2</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">- 2-ой этаж - 97,68 м<sup>2</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">Площадь подвала - 19,6 м<sup>2</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">Площадь застройки - &nbsp;281,93 м<sup>2</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">Строительный объем &nbsp;здания &nbsp;-</span></p>\r\n<p><span style=\"font-size: 14pt;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;в т.ч.</span></p>\r\n<p><span style=\"font-size: 14pt;\">- &nbsp;крыша &nbsp; - 245,2м<sup>3</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">Строительный объем цокольного этажа - 780,0м<sup>3</sup></span></p>\r\n<p><span style=\"font-size: 14pt;\">Строительный объем подвала - &nbsp;68,86 м<sup>3</sup></span></p>\r\n<p style=\"margin-left: -0.01cm; margin-right: -0.01cm; text-indent: 0.9cm; font-style: normal; font-weight: normal; line-height: 150%;\" align=\"justify\">&nbsp;</p>', '219-11_KOTTEDZ_DOM.jpg', '219-11_KOTTEDZ_DOM.jpg', 1577904555, 1580830042, '', 'Проект коттеджа. Документация для строительства. Купить проектную документацию.', 'Проект,  коттеджа,  Купить,  проектную,  документацию, документация', '<center><h2>Проект коттеджа.Документация для строительства.Общая площадь жилого дома – 361,53 м2 </h2></center>', '', 1),
(6, 'Proekt-avtomobilnie-vesi', 10, 0, '267-13', 'Проект автомобильные весы', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/Pk7DhuINm83ClA', '<p>Проект автомобильные весы</p>', '<p>Проект автомобильные весы</p>', '267-13_Proekt_avt-vesi.jpg', '267-13_Proekt_avt-vesi.jpg', 1577904979, 1580900250, '', 'Проект автомобильные весы. Купить проектную документацию.', 'проект. автомобильные. весы', '<center><h2>Автомобильные весы</h2></center>', '', 1),
(8, 'Proekt-detskogo-sada', 6, 0, '179-09', 'Проект детского сада', '500.00', '0.00', 4294967295, 'https://yadi.sk/d/Uc-DnGqTOQ7QUg              https://yadi.sk/d/2ZSOJui-vRjgQw             https://yadi.sk/d/UjG6UairK8P3rw                        https://yadi.sk/d/QwyVGGo6ngHmew', '<p>Проект детского сада</p>', '<p>Дошкольное учреждение располагается в существующем, подлежащем <br />реконструкции, одноэтажном административном здании и предназначено для <br />содержания в нём 15 детей (одна группа дошкольного возраста от 2-х до 7-ми <br />лет).</p>\r\n<p>Установочная мощность технологического оборудования устанавливаемого в данном <br />проекте &ndash; 40,9 кВт.</p>', '445412.png', '445412.png', 1577947849, 1578726439, '', '', '', '', '', 1),
(9, 'Proekt-shkola-iskustv', 11, 0, '152-08', 'Проект школы искусств.', '350.00', '0.00', 4294967295, 'https://yadi.sk/d/Z7IH9DFDx4-LDg', '<p>Проект школа искусств</p>', '<p>Объемно-планировочные решения</p>\r\n<p>Согласно технического задания и технического заключения 152/08-ТЗ, проектом предусматривается капитальный ремонт здания Муниципального образова-тельного учреждения дополнительного образования детей детской школы искусств.</p>\r\n<p>Здание детской школы искусств одноэтажное, с чердаком, без подвала, с размерами отдельных частей здания:</p>\r\n<p>в осях 2-7; А-Д &ndash; 27,75х8,7м</p>\r\n<p>в осях 1-5; Д-Е &ndash; 20,95х6,4м</p>\r\n<p>в осях 7-8; Д-Е &ndash; 7,55х6,4м</p>\r\n<p>Высота помещений 3,0м.</p>\r\n<p>Проектом капитального ремонта предусматриваются следующие виды работ:</p>\r\n<p>Произвести усиление фундаментов по осям А; 2; 7 (см. чертеж 1АС лист 2).</p>\r\n<p>Произвести демонтаж старого санузла и выполнение нового согласно чертежа 1АС лист 2.</p>\r\n<p>Произвести благоустройство участка, обеспечив, таким образом, отвод поверхностных вод от здания, путем засыпки образовавшихся выемок и подсыпки грунта, создав уклон в сторону от здания не менее i=0,02.</p>\r\n<p>Выполнить по всему периметру здания новое асфальтовое покрытие отмостки шириной 1,5м с уклоном i=0,03 от здания.</p>\r\n<p>Произвести замену разрушенных участков кладки новой кладкой; участки размытой кирпичной кладки оштукатурить по сетке цементным раствором. Новый кирпич, используемый для ремонта, должен иметь марку не ниже существующей.</p>\r\n<p>Произвести разборку разрушенного карниза с последующим его наращиванием новой кирпичной кладкой.</p>\r\n<p>Отремонтировать наружную часть кирпичной кладки стен, подвергшихся замоканию и размораживанию.</p>\r\n<p>Трещины в стенах очистить от мусора струей воды или сжатого воздуха, затем заполнить слоем жирного цементного теста из цемента марки не ниже 400.</p>\r\n<p>Произвести лечение внутренних поверхностей стен, перегородок и плит перекрытия, пораженных грибком.</p>\r\n<p>Выполнить дополнительно ряд стропильных ног (30%).</p>\r\n<p>Отремонтировать ряд стропильных ног (20%).</p>\r\n<p>Заменить обрешетку кровли.</p>\r\n<p>Заменить гидроизоляцию кровли.</p>\r\n<p>Выполнить новые слуховые окна.</p>\r\n<p>Выполнить новую кровлю из металлопластиковой черепицы.</p>\r\n<p>В осях Д-Е; 4-2 демонтировать крышу и выполнить новую стропильную систему с последующим выполнением новой кровли из металлопластиковой черепицы.</p>\r\n<p>Выполнить организованный водосток.</p>\r\n<p>Выполнить утепление стен с наружной стороны.</p>\r\n<p>Заменить оконные и дверные блоки на металлопластиковые.</p>\r\n<p>Полностью заменить полы.</p>\r\n<p>Выполнить входные тамбуры по осям Б, Д.</p>\r\n<p>По оси Д выполнить пандус и новые входные ступени.</p>\r\n<p>Деревянные конструкции стропильной крыши обработать огнебиозащитным составом.</p>', '852205.png', '852205.png', 1577961979, 1580912335, '', 'Проект школы искусств. Купить проекную документацию.', 'купить. проектную, документацию. разработка, проекта. канализации. водоснабжения, дом, культуры, школа. искусств', '<center><h2>Здание детской школы искусств одноэтажное, с чердаком, без подвала, с размерами отдельных частей здания:\r\n\r\nв осях 2-7; А-Д – 27,75х8,7м\r\n\r\nв осях 1-5; Д-Е – 20,95х6,4м\r\n\r\nв осях 7-8; Д-Е – 7,55х6,4м\r\n\r\nВысота помещений 3,0м.</h2></center>', '', 1),
(10, 'Proekt-doma-kulturi', 7, 0, '174-08', 'Проект дома культуры', '200.00', '0.00', 4294967295, 'https://yadi.sk/d/GHyX63vRjwEsmA', '<p>Проект дома культуры</p>', '<p>Объемно &ndash; планировочные решения (выписка)</p>\r\n<p>Здание клуба&nbsp; - одноэтажное, высота этажа &ndash; hср=5,0м, прямоугольной <br />формы в плане с размерами 14,60х33,63м. Здание с подвалом, подвал в осях 5 <br />-7; А-Б с высотой 3,2 и 4, 2м.</p>\r\n<p>Для повышения эксплуатационной надежности здания рекомендуется выполнить <br />следующее:</p>\r\n<p>1. Произвести усиление фундамента: по оси &laquo;А&raquo; в осях 1-5, по оси &laquo;1&raquo; в осях <br />А-Б; по оси &laquo;Б&raquo; в осях 1-4.</p>\r\n<p>2. Выполнить по всему периметру здания новое асфальтовое покрытие отмостки <br />шириной 1,5м с уклоном i=0,03 от здания.</p>\r\n<p>3. Переложить участок кладки на фасаде 1-6 по оси &laquo;2&raquo; со сквозной трещиной с <br />раскрытием до 10мм.</p>\r\n<p>4. Выполнить инъектирование трещин с раскрытием от 1 до 2мм в кирпичной <br />кладке.</p>\r\n<p>5. Заменить пароизоляцию и утеплитель чердачного перекрытия.</p>\r\n<p>6. Выполнить цементную стяжку по утеплителю.</p>\r\n<p>7. Выполнить замену кровли.</p>\r\n<p>8. Восстановить вырезанный раскос в металлической ферме крыши.</p>\r\n<p>9. Частично заменить обрешетку с рубероидом (по оси Б шириной 1м).</p>\r\n<p>10. Выполнить антикоррозийную и огнезащиту металлических конструкций ферм.</p>\r\n<p>11. Выполнить огнебиозащиту деревянных конструкций чердачного перекрытия и <br />крыши составом Фенилакс.</p>\r\n<p>12. Выполнить организованный водосток.</p>\r\n<p>13. Выполнить ремонт карниза по оси Б и по фасадам А-Б; Б-А.</p>\r\n<p>14. Выполнить отделку верха карнизов оцинкованной провельной сталью по оси Б и <br />по фасадам А-Б; Б-а.</p>\r\n<p>15.Выполнить новые полы.</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 176px; top: 19px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '825672.jpg', '825672.jpg', 1577965168, 1580912040, '', 'Проект дома культуры. Купить проектную документацию.', 'купить. проектную, документацию. разработка, проекта. канализации. водоснабжения, дом, культуры', '<center><h2>Здание клуба  - одноэтажное, высота этажа – hср=5,0м, прямоугольной \r\nформы в плане с размерами 14,60х33,63м.</h2></center>', '', 1),
(11, 'Proekt-dom-kulturi', 7, 0, '143-07', 'Проект дома культуры', '250.00', '0.00', 4294967295, 'https://yadi.sk/d/D5uECQNm8XA8WA                                    https://yadi.sk/d/qa_vWAhsbCZ8Bw', '<p>Проект дома культуры</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 495px; top: 32px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '<p>Объемно &ndash; планировочные решения.</p>\r\n<p>Здание в осях 4-7; Б-В одноэтажное, с антресолью (в осях 4-5) на кирпичных <br />колоннах, в осях 1-5; А-Г &ndash; двухэтажное. Высота первого этажа 2,8м, второго <br />2,9м. В осях 6-7; Б-В. на отм.- 0,95 (под сценой) имеется подвал.</p>\r\n<p>Проектом капитального ремонта предусматривается выполнение следующих видов <br />работ:</p>\r\n<p>Выполнить по всему периметру здания новое асфальтовое покрытие отмостки <br />шириной 1,5м с уклоном i=0,03 от здания.</p>\r\n<p>Заменить оконные и дверные блоки на металлопластиковые.</p>\r\n<p>Заменить дощатые полы в тамбуре главного входа на мозаичные.</p>\r\n<p>Заменить асбестоцементные листы кровли на металлопластиковую черепицу.</p>\r\n<p>Заменить 50% обрешетки.</p>\r\n<p>Заменить дощатые полы в фойе на мозаичные.</p>\r\n<p>Выполнить наружную отделку стен, предварительно сняв существующую плитку.</p>\r\n<p>Заменить щитовой накат чердачного перекрытия на новый со сменой шлакового <br />утеплителя на более легкий из минераловатных плит толщиной 15см.</p>\r\n<p>Произвести внутреннюю отделку.</p>\r\n<p>Произвести ремонт бетонных ступеней и площадок входов в здание с установкой <br />ограждения лестниц.</p>\r\n<p>Выполнить пандус для маломобильного населения в главном входе в здание.</p>\r\n<p>Выполнить козырек над главным входом в здание.</p>\r\n<p>Заменить несущие конструкции сценической площадки.</p>\r\n<p>Заменить дощатое покрытие сцены.</p>', '75256.jpg', '75256.jpg', 1577975022, 1580911735, '', 'Проект дома культуры. Купить проектную документацию.', 'разработка. проекта. проект, дом. культуры. разработка, канализации', '<center><h2>Проект дома культуры</h2></center>', '', 1),
(12, 'Proekt-kanalizatsionnoj-nasosnoj-stantsii', 2, 0, '146-07', 'Проект канализационной насосной станции(КНС-1)', '1250.00', '0.00', 4294967295, 'https://yadi.sk/d/NsLyJkCbnTOG2w', '<p>Проект КНС (канализационная насосная станция)</p>', '<p>Основные технологические решения(выписка)<br />общая площадь КНС №1 &ndash; 372.6 м&sup2;, в том числе производственная &ndash; 204.2м&sup2;. <br />Канализационная насосная станция №1, производительностью <br />20.0 тыс. м3/сут предназначена для перекачки хозяйственно-бытовых и близких к <br />ним по составу производственных сточных вод города, имеющих нейтральную и <br />слабощелочную реакцию.</p>\r\n<p>Станция эксплуатируется с автоматическим управлением насосных агрегатов и <br />вспомогательных механизмов.</p>\r\n<p>Насосная станция имеет подземную часть круглой в плане формы диаметром 16м и <br />надземную часть прямоугольной формы размером 12.0х15.0.</p>\r\n<p>Подземная часть разделена на два отсека глухой водонепроницаемой перегородкой: <br />в одном отсеке расположен приемный резервуар и грабельное помещение; в другом <br />&ndash; машинное помещение. В машинном помещении расположены основные <br />технологические насосы, насосы для подачи воды на уплотнение сальников, <br />дренажный насос и необходимая арматура; в грабельном помещении &ndash; решетки <br />механизированные и дробилки.</p>\r\n<p>В надземной части расположены щиты управления электродвигателями, приборы <br />автоматики, вентиляционно-отопительное оборудование, душевая, санузел, <br />служебное помещение, монтажные площадки и грузоподъемные устройства, <br />электропункт.</p>\r\n<p>Глубина заложения лотка подводящего коллектора 6.350м от поверхности земли.</p>\r\n<p>В ходе визуального обследования насосной станции и анализа работы <br />технологического оборудования была выявлена необходимость замены существующего <br />и установки нового технологического оборудования в машинном и грабельном <br />помещении. Необходимость замены и установки нового технологического <br />оборудования вызвана износом существующего технологического оборудования, <br />арматуры, их аварийным состоянием, а также отсутствием некоторых комплектов <br />технологического оборудования (см. рабочие чертежи 146/07-ТХ)</p>', '', '', 1577977015, 1580809968, '', 'Проект канализационной насосной станции(КНС-1). Купить проектную документацию.', 'купить, проектная, документация, проект, разработка. канализационная . насосная, станция', '<center><h2>общая площадь КНС №1 – 372.6 м², в том числе производственная – 204.2м². </h2></center>', '', 1),
(13, 'Proekt-zameni-kanalizatsionnogo-kollektora', 2, 0, '153-08', 'Проект замены канализационного коллектора', '250.00', '0.00', 4294967295, 'https://yadi.sk/d/iL3JTa1gLz3zqQ', '<p>Проект замены канализационного коллектора</p>', '<p>Технические решения (выписка)</p>\r\n<p>Проектом предусматривается замена аварийного напорного стального <br />канализационного коллектора &Oslash;400мм на &Oslash;160Т &laquo;Техническая&raquo; <br />ГОСТ 18599-2001, протяженностью 2237м с подключением в насосной <br />станции школы № 34 и к существующей камере гашения около насосной ш. <br />Самбековская.</p>\r\n<p>Количество сточных вод уменьшилось с 1400м&sup3;/сут. до 290м&sup3;/сут., что связано с <br />ликвидацией шахты &laquo;Самбековская&raquo;. По коллектору будут отводиться только <br />сточные воды поселка Самбек.</p>\r\n<p>Сети проходят по застроенной территории.</p>\r\n<p>На проектируемой сети предусмотрены колодцы на углах поворота с установкой в <br />них ревизий и в местах изменения уклона для измерения в них напряженного <br />состояния труб.</p>', '153-08_Proekt_ollektor.jpg', '153-08_Proekt_ollektor.jpg', 1577993135, 1580809595, '', 'Проект замены канализационного коллектора. Купить проектную документацию.', 'купить, проектная, документация, замена, канализационного, коллектора', '<center><h2>Проектом предусматривается замена аварийного напорного стального\r\nканализационного коллектора Ø400мм</h2></center>', '', 1),
(14, 'Proekt-detskij-sad', 6, 0, '169-08', 'Проект детского сада', '250.00', '200.00', 4294967295, 'https://yadi.sk/d/0IBPIUb4SOA7DQ', '<p>Проект детского сада</p>', '<p>Основные решения</p>\r\n<p>Проектом предусмотрено:</p>\r\n<p>-усиление фундамента, в связи с его просадкой при подработке &ndash; 9,0м3;</p>\r\n<p>- замена кровли- 863 м2;</p>\r\n<p>- облицовка фасада - 620 м2 ;</p>\r\n<p>- ремонт чердачного перекрытия- 65м3;</p>\r\n<p>- внутренняя отделка помещений-2469,0 м2;</p>\r\n<p>Основные выводы по рабочему проекту:</p>\r\n<p>- рабочий проект выполнен в соответствии с рекомендациями, изложенными в горно-геологическом обосновании, с учетом инженерно-геологических изысканий, выполненных фирмой &laquo;Ингео&raquo; и актом обследования здания</p>', '169-08_et_sad2_.jpg', '169-08_et_sad2_.jpg', 1577994486, 1580827529, '', 'Проект детского сада. купить проектную документацию.', 'купить, проектную. документацию, проект, детский, сад', '<center><h2>Рабочий проект выполнен в соответствии с рекомендациями, изложенными в горно-геологическом обосновании, с учетом инженерно-геологических изысканий и актом обследования здания</h2></center>', '', 1),
(15, 'Proekt-setej-vodosnabzheniya', 1, 0, '150-08', 'Проект сетей водоснабжения', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/CUJgzJ06sdyZ5w', '<p>Проект сетей водоснабжения</p>', '<p>Проект сетей водоснабжения</p>', '150-08_Seti-vodonab_.jpg', '150-08_Seti-vodonab_.jpg', 1578038477, 1580827360, '', 'Проект сетей водоснабжения. Купить проектную документацию.', 'Купить, проектную документацию, документация, проект. сети. водоснабжения', '<center><h2></h2></center>', '', 1),
(16, 'Proekt-pererabotki-otvala', 10, 0, '107-06', 'Проект переработки отвала', '900.00', '1200.00', 4294967295, 'https://yadi.sk/d/sZ1BcHlu1A5XcQ            https://yadi.sk/d/OSWTdyAjBQuiwQ', '<p>Проект переработки породного отвала</p>', '<p><span style=\"font-size: 12pt;\"><strong>Проект переработки породного отвала.</strong></span></p>\r\n<p><span style=\"font-size: 12pt;\"><strong>Оборудование комплекса переработки горной массы породного отвала и </strong></span><br /><span style=\"font-size: 12pt;\"><strong>технологический процесс</strong></span></p>\r\n<p>Комплекс переработки горной массы представляет собой оборудование</p>\r\n<p>связанное между собой в технологическую цепочку (линию) для выполнения рассева <br />горной массы отвала на различные классы по крупности, пригодные для <br />строительства и складирование готовой продукции на склад.</p>\r\n<p>Схема цепи аппаратов 107/06-402-ТХ, л. 2, 3 комплекса переработки горной массы <br />включает в себя следующие сборочные единицы (позиции):</p>\r\n<p>................................................................................................................................................................</p>\r\n<p>..................................................................................................................................................................</p>\r\n<p>&nbsp;</p>', '107-06_Pererab_Otvala_.jpg', '107-06_Pererab_Otvala_.jpg', 1578040027, 1580899594, '', 'Проект переработки отвала. Купить проектную документацию.', 'проект. переработки. породного, отвала', '<center><h2>Проект переработки отвала</h2></center>', '', 1),
(17, 'Proekt-federalnoj-avtomobilnoj-dorogi', 3, 0, '268-13', 'Проект федеральной автомобильной дороги', '1900.00', '2500.00', 4294967295, 'https://yadi.sk/d/Rk65_6B8kAzpvg', '<p>Проект федеральной автомобильной дороги</p>', '<p><strong><em><span data-contrast=\"auto\">2.Технические нормативы</span></em></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">В соответствии с заданием в проекте предусмотрен капитальный ремонт автомобильной дороги&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">II</span><span data-contrast=\"auto\">&nbsp;технической категории со следующими техническими показателями:</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><strong><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<table data-tablestyle=\"MsoNormalTable\" data-tablelook=\"1696\">\r\n<tbody>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">Показатели</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">По нормативам</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">По проекту</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- протяженность дороги, км</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">6,96</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">6,96</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- категория дороги</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">II</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">II</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- расчетная скорость, км/ч</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">120</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">120</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наименьший радиус кривой в плане, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">800</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">1 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наибольший продольный уклон, %</span><span data-contrast=\"auto\">о</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">40</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">40</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наименьший радиус выпуклой вертикальной кривой, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">10 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">5 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наименьший радиус вогнутой вертикальной кривой, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3 018</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">- ширина земляного полотна, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">23,0 &ndash; 30,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">23,0 &ndash; 30,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">- ширина проезжей части, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">4 х 3,5</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">4 х 3,5&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">- ширина разделительной полосы, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">5,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">3,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">-ширина краевой укрепительной полосы&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"none\">&nbsp;</span><span data-contrast=\"none\">обочины, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">0,5</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">0,5</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">-&nbsp;ширина&nbsp; обочины, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- дорожная одежда</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">капитального типа с асфальтобетонным покрытием</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">капитального типа с асфальтобетонным покрытием</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- расчетные нагрузки</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">А11,5, Н14</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">А11.5, Н14</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">-число полос движения</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">4</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">4</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '105697.jpg', '105697.jpg', 1578041355, 1580550280, '', 'Проектная документация на капитальный ремонт федеральной автомобильной дороги. В составе чертежей и пояснительной', 'проект, федеральной. автомобильной, дороги', '<h2>Проектирование выполнено в программном комплексе топоматик «ROBUR» версии 7.5 по цифровой модели местности. Сметные расчеты выполнены ресурсным методом с использованием сметного программного комплекса «РИК».<h2>', '', 1),
(18, 'Proekt-kanalizatsionnogo-kollektora', 2, 0, '168-08', 'Проект канализационного коллектора', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/H8yM8SU4hHI3wA', '<p>Проект канализационного коллектора</p>', '<p>Проект канализационного коллектора(выписка)</p>\r\n<p>Основные технические решения.<br />В соответствии с актом выбора трассы, проектом предусматривается <br />самотечная канализация из труб &Oslash;400мм общей протяженностью 3986м от колодца <br />КК-1 (ул.Чехова) до канализационного колодца № 137 по ул. Веселая и самотечная <br />канализация &Oslash;315мм протяженностью 560м, от колодца № 51 по ул.Крупской, до <br />колодца №67 (т.7) по улице Седова.</p>\r\n<p>Самотечная канализация запроектирована из пластмассовых канализационных труб <br />ПНД 400С (ПЭ 80 SDR 21, Р=6,3 атм.), и ПНД 315С (ПЭ 80 SDR 21, Р=6,3 <br />атм.) \"Техническая\", ГОСТ 18599-2001.</p>\r\n<p>Также проектом предусмотрена напорная канализация &Oslash;400мм протяженностью 2275 м <br />от КНС Новая Соколовка через железную дорогу по ул.Вернигоренко до <br />существующего колодца гасителя в районе ул.Щаденко и ул.Короленко, 15.</p>\r\n<p>Напорная канализация запроектирована из пластмассовых канализационных труб ПНД <br />400Т (ПЭ 80 SDR 13,6, Р=10 атм.)\"Техническая\", ГОСТ 18599-2001.</p>\r\n<p>При переходе канализации через ж/дорогу выполнена электрохимическая защита <br />стальных футляров, см. часть 168/08-ЭХЗ (план электрических проводок станции <br />катодной защиты ИСТ-750М).</p>\r\n<p>При пересечении трубопровода канализации автомобильных дорог открытым способом <br />предусмотрены футляры из пластмассовых труб ПНД 630Т (ПЭ 80 SDR 13,6, Р=10 <br />атм) \"Техническая\", ГОСТ 18599-2001, см. спецификацию и чертежи.</p>', '168-08_Kanal_Kollector_.jpg', '168-08_Kanal_Kollector_.jpg', 1578048012, 1578725726, '', '', 'проект, канализационный,  коллектор', '', '', 1),
(19, 'Proekt-vodovoda', 1, 0, '166-08', 'Проект водовода', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/kRsfimIgWeDCdw', '<p>Проект водовода</p>', '<p><strong><span data-contrast=\"auto\">3.1&nbsp;Технические&nbsp; решения&nbsp;</span></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">Настоящим проектом предусматривается замена аварийного участка подводящего водопровода , протяженностью 2520м из металлических труб &Oslash;</span><span data-contrast=\"auto\">у</span><span data-contrast=\"auto\">200мм</span><span data-contrast=\"auto\">&nbsp;</span><span data-contrast=\"auto\">на пластиковые трубы &Oslash;225 мм. Подключение предусматривается в существующем колодце (СК-1) к существующему водопроводу &Oslash;200мм.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">Категория системы водоснабжения по степени обеспеченности подачи воды и класс ответственности &ndash; I. Качество воды на&nbsp;хоз-питьевые нужды должно соответствовать ГОСТ 2874-82 &laquo;Вода питьевая&raquo;.&nbsp;&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;</span><span data-contrast=\"auto\">Водопровод запроектирован из труб ПНД 225Т, ГОСТ18599-2001 &laquo;Питьевая&raquo;,&nbsp;Р</span><span data-contrast=\"auto\">у</span><span data-contrast=\"auto\">=10кгс/см</span><span data-contrast=\"auto\">2</span><span data-contrast=\"auto\">.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;</span><span data-contrast=\"auto\">Преимущества&nbsp;определяемые свойствами полиэтиленовых труб следующие:</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">Сети проходят по незастроенной территории, участок от ПК-1 до ПК2+39,0 и от ПК22+ПК25+20 по застроенной территории. По трассе строительства проектом предусматриваются колодцы с запорной арматурой. В повышенных точках трассы&nbsp;водопровода&nbsp; в&nbsp;колодцах&nbsp; монтируются вантузы для выпуска воздуха, в целях недопущения гидравлического удара. В низших точках системы водопроводов устраиваются выпуски в проектируемые мокрые колодцы.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">Санитарно-защитная зона для водопровода &ndash; 10м. В пределах санитарно-защитной полосы запрещается устройство уборных, выгребов (помойных ям), сборников мусора, попадающие (существующие) в санитарно-защитную зону - вынести за ее пределы.&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">Прокладка участка водопровода, проходящего под автодорогой,&nbsp; предусмотрена проектом закрытым методом прокола по&nbsp;ул.Степной&nbsp; &ndash; открытым способом.&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">Для наружного пожаротушения проектом предусматривается установка&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">пожарных гидрантов в&nbsp;колодцах&nbsp; на&nbsp;участках застроенной территории. </span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>', '166-08_Proekt_vodovod_.jpg', '166-08_Proekt_vodovod_.jpg', 1578119975, 1580814651, '', 'Проект водовода(166-08). Купить проектную документацию.', 'купить, проектная, документация, проект, разработка, водовод, водовода', '<center><h2>Настоящим проектом предусматривается замена аварийного участка подводящего водопровода , протяженностью 2520м из металлических труб Øу200мм</h2></center>', '', 1),
(20, 'Proekt-deskogo-sada-kap-rem', 6, 0, '90-06', 'Проект деского сада(кап.рем)', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/Tz_OvLualCHD2g', '<p>Капитальный ремонт детского сада</p>', '<p>Капитальный ремонт детского сада</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; Дошкольное учреждение располагается в существующем здании, подлежащем капитальному ремонту, двухэтажном здании и предназначено для содержания в нем 180 детей, в том числе 2 группы по 15 детей &ndash; ясельного возраста и 6 групп по 25 детей дошкольного возраста.<br />Здание также имеет подвал</p>', '90-06_Det_SAD.jpg', '90-06_Det_SAD.jpg', 1578130766, 1580826562, '', 'Проект деского сада(кап.рем)', 'купить, проектную, документацию, проект, детский , сад, капмтальный, ремонт', '       <center><h2> Дошкольное учреждение  предназначено для содержания в нем 180 детей, в том числе 2 группы по 15 детей – ясельного возраста и 6 групп по 25 детей дошкольного возраста.</h2></center>', '', 1),
(21, 'Proekt-Kirpichnij-zavod-ekonstruktsiya-i-pileudalenie', 10, 0, '12-05', 'Проект -  Кирпичный завод(реконструкция и пылеудаление)', '500.00', '750.00', 4294967295, 'https://yadi.sk/d/Y3boaYu_5J2v6w', '<p>Проект Кирпичный завод(еконструкция и пылеудаление)</p>', '<p>Проект Кирпичный завод(реконструкция и пылеудаление)</p>\r\n<p>Проект Кирпичный завод(пылеудаление) <br />Содержание.<br />1. Состав проекта<br />2. Запись о соблюдении действующих норм, правил.<br />3. Пояснительная записка.<br />3.1 Общие положения<br />3.2 Основание для разработки проекта<br />3.3 Цели реализации проекта.<br />4. Место размещения предприятия<br />4.1 Сведения о размещении производства и инфраструктуре<br />4.2 Климатические условия <br />5. Решение по генеральному плану<br />5.1 Решение по генеральному плану. Благоустройство; вертикаль-<br />ная планировка.<br />6. Архитектурно-строительные решения.<br />6.1 Климатическая характеристика района.<br />6.2 Конструктивная характеристика дымовой трубы.<br />6.3 Основные конструктивные элементы.<br />6.4 Антикоррозийная защита<br />7. Радиационный контроль<br />7.1 Радиационный контроль<br />-------------------------------------------------------------<br />Реконструкция технологической схемы подачи шихты на технологическую линию кирпичного завода<br />4.1. Общие положения</p>\r\n<p>Рабочий проект &laquo;Реконструкция технологической схемы подачи шихты на технологическую линию кирпичного завода ООО &laquo;Гуковский кирпич&raquo; разработан проектной организацией ООО &laquo;Росинвестпроект&raquo; <br />г. Шахты<br />Цель проекта &ndash; устранение узких мест в технологической схеме, а именно:<br /> дополнительные затраты при дозировке смерзшейся шихты в зимнее время;<br /> дополнительные внешние транспортные затраты по подаче шихты в связи с отсутствием аккамулирующих емкостей.<br />Для исключения перечисленных проблем данным проектом предусматривается строительство бункера объемом 25м3, что позволяет в течении суток при его разовой заправке в первую дневную смену. Бункер оборудован крышей для защиты от атмосферных осадков. Бункер оснащен также дозатором для точной подачи шихты. Предусмотрен обогрев нижней части бункера, что исключает промерзание шихты.<br />Ритмичная точная дозировка шихты, обеспечивает высокое качество выпускаемой продукции и снижение ее себестоимости.</p>', '12-05_Kirp_zd_Pileudal.jpg', '12-05_Kirp_zd_Pileudal.jpg', 1578132541, 1580898294, '', 'Проект -  Кирпичный завод(реконструкция и пылеудаление). Купить проектную документацию.', 'разработка, проект, кирпичный, завод, пылеудаление, реконструкция', '<center><h2>Цель проекта – устранение узких мест в технологической схеме</h2></center>', '', 1),
(22, 'Proekt-kapitalnog-remonta-travmatologii', 8, 0, '141-07', 'Проект капитального ремонта травматологии', '2950.00', '3500.00', 4294967295, 'https://yadi.sk/d/fwk0nFau97BhpA', '<p>Проект капитальног ремонта травматологии</p>', '<p>Проект капитальног ремонта травматологии<br />Проектом капитального ремонта предусматриваются следующие <br />виды работ:<br />1. На первом этаже (оси 13-14, Б-Г) отделить от холла помещение процедурной, оборудованное раковиной.<br />На втором этаже предусмотреть устройство душевой на 2 душевые сетки для больных, в помещении ванной; устройство евро-душевой кабины и санузла для медперсонала (в осях 1-3); устройство душевой на 1 душевую сетку для больных (в осях 12-14).<br />На третьем этаже в осях 1-3 устраивается душевая для больных на 2 душевые сетки, евро-душевая кабина и санузел для медперсонала. В осях 12-14 устраивается душевая для больных на 1 душевую сетку и кладовые чистого и грязного белья.<br />Кабинеты и палаты на 1-м, 2-м и 3-м оборудуются раковинами, согласно СанПиН.<br />2. Произвести благоустройство участка, обеспечив, таким образом, отвод поверхностных вод от здания, путем засыпки образовавшихся выемок и подсыпки грунта, создав уклон в сторону от здания не менее i=0,02.<br />1. Демонтировать пандус (подъездную эстакаду) в главный вход в здание, выполнить новый пандус (подъездную эстакаду) согласно рабочим чертежам.<br />2. Выполнить навес над пандусом согласно рабочим чертежам.<br />3. Демонтировать старый контейнер для хранения кислородных баллонов и решить вопрос с хранением их согласно технологического чертежа и нормативной документации.<br />4. Произвести ремонт конструкций вентиляционной системы (вентшахт, коробов, каналов и т. п.).<br />5. Деревянные конструкции стропильной системы крыши обработать огнебиозащитным составом.<br />6. Выполнить ремонт разрушенных стенок приямков, оштукатурить стенки, перекрыть их профлистом.<br />7. Произвести внутреннюю и наружную отделку.</p>', '141-07_Travmatologia.jpg', '141-07_Travmatologia.jpg', 1578140816, 1580838731, '', 'Проект капитального ремонта травматологии. Купить проектную документацию.', 'Купить,  проектную, проектная,  документацию, разработка, проект. травматология, душевая. кислородоснабжение, стропильная система, благоустройство. участка', '<center><h2>Капитальный ремонт травматологии</h2></center>', '', 1);
INSERT INTO `arwm_items` (`itemid`, `itemname`, `catid`, `mnf_id`, `sku`, `title`, `price`, `old_price`, `quantity`, `quantity_txt`, `short_descript`, `long_descript`, `small_img`, `big_img`, `add_date`, `upd_date`, `meta_title`, `description`, `keywords`, `metatags`, `special`, `visible`) VALUES
(23, 'Proekt-kapremrnta-gorbolnitsi-inzh-seti', 8, 0, '114-07', 'Проект капремрнта горбольницы(инж.сети)', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/yo8OvW_DJv52dQ', '<p>Проект капремрнта горбольницы(инж.сети)</p>', '<p>роект капремрнта горбольницы(инж.сети)<br />Водоснабжение.</p>\r\n<p>Согласно техническим условиям водоснабжение городской больницы №2 в <br />осуществляется от существующих сетей водопровода &Oslash;225мм <br />по ул. Молодогвардейцев. Располагаемый напор 30 метров.<br />Ввод водопровода холодной воды &Oslash;50мм &ndash; существующий.<br />Внутренние сети водопровода монтируются из полиэтиленовых труб диаметром <br />32-50мм ПНД по ГОСТ 18599-2001 \"Питьевая\" и из полипропиленовых труб \"Рандом <br />Сополимер\" (РРRS РN 10) с наружным диаметром 16-25мм.<br />Строительный объем здания составляет 4217,2м3; ст. огн. II, поэтому проектом <br />не предусмотрено внутреннее пожаротушение (СниП 2.04.01-85 &laquo;Внутренний <br />водопровод и канализация зданий&raquo;, табл. 1 п.4)<br />======================================================================<br />Водоотведение<br />Согласно техническим условиям внутренние сети канализации <br />подключить к существующим сетям канализации &Oslash;350мм по ул. Р-Крестьянская. <br />Внутренние сети канализации запроектированы из пластмассовых канализационных <br />труб &Oslash;110&divide;50мм ГОСТ 22689-89. </p>', '114-07_Kap-rem_bolnica_.jpg', '114-07_Kap-rem_bolnica_.jpg', 1578233706, 1580838453, '', 'Проект капремрнта горбольницы(инж.сети). Купить проектную документацию.', 'Купить.  проектную, проектная,  документацию, докуметация, проект, капитальный, ремонт, городская. больница, инженерные. сети', '<center><h2>Капитальный ремонт городской больницы</h2></center>', '', 1),
(24, 'Proekt-kapremonta-kafe-vnutrennie-inzh-seti', 12, 0, '118-07', 'Проект капремонта кафе (внутренние инж. сети)', '250.00', '300.00', 4294967295, 'https://yadi.sk/d/A0VpF3kduWGx4g', '<p>Проект капремонта кафе (внутренние инж. сети)</p>', '<p>Проект капремонта кафе (внутренние инж. сети)</p>\r\n<p>Санитарно-техническая часть</p>\r\n<p>Внутренние сети.</p>\r\n<p>Отопление. Вентиляция.<br />В данной части проекта разработаны системы отопления, вентиляции и <br />теплоснабжения.</p>', '118-07_Kap-rem_kaf_.jpg', '118-07_Kap-rem_kaf_.jpg', 1578234783, 1580888000, '', 'Проект капремонта кафе (внутренние инж. сети). Купить проектную документацию.', 'проект, кафе, внутренние. инженерные. сети', '<center><h2>В данной части проекта разработаны системы отопления, вентиляции и \r\nтеплоснабжения.</h2></center>', '', 1),
(25, 'Proekt-mnogokvartirnogo-zhilogo-doma-dostrojka', 4, 0, '84-06', 'Проект многоквартирного жилого дома(достройка)', '500.00', '750.00', 4294967295, 'https://yadi.sk/d/zBhgTD03xOx7mw', '<p>Проект многоквартирного жилого дома(достройка)</p>', '<p>Проект многоквартирного жилого дома(достройка)<br />5.1. Архитектурно-строительные решения</p>\r\n<p><br />- перепланировка сущетвующего недостроенного здания под жилые квартиры. <br />Проектом предусматривается устройство следующего количества <br />квартир:<br />двухкомнатных квартир &ndash; 20.<br />трехкомнатных квартир &ndash; 20.<br />Всего: 40 квартир.<br />Общая площадь квартир 2516,0 м2 , в том числе жилая площадь &ndash; <br />1096,0м2, площадь застройки &ndash; 689,8 м2.<br />Существующее здание 5-ти этажное с подвалом, имеющее сложную <br />форму в плане с общими размерами 34,1х24,15м.<br />Высота этажей составляет 2,5 м. Высота подвала 2,3 м.</p>', '84-06_roekt_ziloy_dom_.jpg', '84-06_roekt_ziloy_dom_.jpg', 1578235932, 1580828355, '', 'Проект многоквартирного жилого дома(достройка). Купить проектную документацию.', 'Купить,проектную,  документацию, Проект,  многоквартирного,  жилого,  дома,  достройка', '<center><h2>Общая площадь квартир 2516,0 м2 , в том числе жилая площадь –1096,0м2, площадь застройки – 689,8 м2.</h2></center>', '', 1),
(26, 'Proekt-avtozapravochnoj-stantsii-AZS', 10, 0, '62-06', 'Проект автозаправочной станции(АЗС)', '450.00', '0.00', 4294967295, 'https://yadi.sk/d/Ct5b_w-FCTXuzg', '<p>Проект автозаправочной станции(АЗС)</p>', '<p>Проект автозаправочной станции(АЗС)<br />4.2. Основные технологические показатели АЗС.</p>\r\n<p>Величина средней разовой заправки топливом легковых автомобилей &ndash; <br />35 литров, грузовых &ndash; 60 литров.<br />Количество топливораздаточных колонок - 2 штуки: <br />- четырехпистолетная <br />- двухпистолетная<br />Количество заправочных мест &ndash; 4.<br />Время занятости (заправки) заправочного места одним легковым <br />автомобилем &ndash; 3 мин, грузовым - 4 мин.<br />Максимальная пропускная способность АЗС в час пик составляет 90 <br />автомобилей, в том числе 40 грузовых и 50 легковых.<br />Коэффициент использования топливораздаточной колонки (заправочного <br />места) - 0.5.<br />Расчетная пропускная способность АЗС в час (с учетом КПД колонки) - <br />45 автомобилей, в том числе 20 грузовых и 25 легковых.<br />Количество топливных резервуаров &ndash; 3 шт. емкостью по 50 м3 каждый.<br />Запас топлива по номинальному расходу составляет 12 суток. <br />Максимальная пропускная способность автотранспортных средств в сутки <br />&ndash; 380. нормальная 250.</p>', '270508.jpg', '270508.jpg', 1578240122, 1580898095, '', 'Проект автозаправочной станции(АЗС). Купить проектную документацию.', 'Проект,  автозаправочной,  станции(АЗС)', '<center><h2>Расчетная пропускная способность АЗС в час (с учетом КПД колонки) - \r\n45 автомобилей, в том числе 20 грузовых и 25 легковых.</h2></center>', '', 1),
(27, 'Proekt-nevrologicheskogo-otdeleniya-rekonstr-rodilnogo', 8, 0, '264-13', 'Проект неврологического отделения(реконстр родильного)', '1500.00', '2100.00', 4294967295, 'https://yadi.sk/d/eERRROJQAt4Ajw', '<p>Проект неврологического отделения(реконстр. родильного)</p>', '<p>Проект неврологического отделения(реконстр. родильного)</p>\r\n<p><strong><span data-contrast=\"auto\">Медицинское задание</span></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">на разработку проектной документации по объекту &laquo;Капитальный ремонт здания неврологического отделения МБУЗ ГБСМП </span></p>\r\n<p><span data-contrast=\"auto\">Проектом&nbsp;&nbsp; предусмотреть:</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">1 этаж -&nbsp;&nbsp;&nbsp;</span><strong><span data-contrast=\"auto\">Терапевтическое отделение на 21 койку.</span></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<ol>\r\n<li data-leveltext=\"%1\" data-font=\"\" data-listid=\"1\" aria-setsize=\"-1\" data-aria-posinset=\"1\" data-aria-level=\"1\"><span data-contrast=\"auto\">Палаты 2-х местные с индивидуальными санузлами-9шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1\" data-font=\"\" data-listid=\"1\" aria-setsize=\"-1\" data-aria-posinset=\"2\" data-aria-level=\"1\"><span data-contrast=\"auto\">Палаты 3-х местные с индивидуальными санузлами-1шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"3\" data-aria-level=\"1\"><span data-contrast=\"auto\">Кабинет Зав. отделением</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"4\" data-aria-level=\"1\"><span data-contrast=\"auto\">Кабинет старшей медсестры&nbsp;&nbsp;&nbsp; -</span><span data-contrast=\"auto\">1шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"5\" data-aria-level=\"1\"><span data-contrast=\"auto\">Кабинет Ф.Т.О.</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">2шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"6\" data-aria-level=\"1\"><span data-contrast=\"auto\">Кабинет Л.Ф.К</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"7\" data-aria-level=\"1\"><span data-contrast=\"auto\">Ординаторская</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"8\" data-aria-level=\"1\"><span data-contrast=\"auto\">Процедурный кабинет</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"2\" aria-setsize=\"-1\" data-aria-posinset=\"9\" data-aria-level=\"1\"><span data-contrast=\"auto\">Приемный покой</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"10\" data-aria-level=\"1\"><span data-contrast=\"auto\">Кладовая чистого белья</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"11\" data-aria-level=\"1\"><span data-contrast=\"auto\">Кладовая грязного белья</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"12\" data-aria-level=\"1\"><span data-contrast=\"auto\">Буфетная - раздаточная на 24 посадочных мест.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"13\" data-aria-level=\"1\"><span data-contrast=\"auto\">Библиотека</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"14\" data-aria-level=\"1\"><span data-contrast=\"auto\">Прогулочная&nbsp;&nbsp;&nbsp; веранда</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"15\" data-aria-level=\"1\"><span data-contrast=\"auto\">Санитарно-бытовые помещения медперсонала.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"16\" data-aria-level=\"1\"><span data-contrast=\"auto\">Комната уборочного инвентаря&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"17\" data-aria-level=\"1\"><span data-contrast=\"auto\">Санитарная комната больных&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"18\" data-aria-level=\"1\"><span data-contrast=\"auto\">Ожидальная</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"19\" data-aria-level=\"1\"><span data-contrast=\"auto\">Связь, телефон.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<ol>\r\n<li data-leveltext=\"%1.\" data-font=\"\" data-listid=\"3\" aria-setsize=\"-1\" data-aria-posinset=\"20\" data-aria-level=\"1\"><span data-contrast=\"auto\">Пост дежурной медсестры&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n</ol>\r\n<p><span data-contrast=\"auto\">2 этаж -&nbsp;&nbsp;&nbsp;</span><strong><span data-contrast=\"auto\">Неврологическое отделение на 36 коек.</span></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">1 Палаты 2-х местные с индивидуальными санузлами:</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">1.1 одноместные&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">1.2 двухместные&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">1.3 трехместные&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">1.4 четырехместные&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">2 Кабинет Зав. Отделением</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">3 Пост дежурной медсестры&nbsp;&nbsp;&nbsp; -</span><span data-contrast=\"auto\">2шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">4 Ординаторская&nbsp;</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">5 Кабинет старшей медсестры</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">6 Процедурная</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">7 Санитарно-бытовые помещения персонала.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">8 Буфетная раздаточная на 32 посадочных места</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">&nbsp;&nbsp;</span><span data-contrast=\"auto\">9 Кладовая чистого белья&nbsp;</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">10 Кладовая грязного белья</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">-</span><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<ol start=\"11\">\r\n<li><span data-contrast=\"auto\"> Клизменная&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1шт.</span></li>\r\n<li><span data-contrast=\"auto\"> Комната отдыха сотрудников&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n<li><span data-contrast=\"auto\">Ожидальная</span><span data-contrast=\"auto\">&nbsp;</span><span data-contrast=\"auto\">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n<li><span data-contrast=\"auto\"> Комната уборочного инвентаря -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">1</span><span data-contrast=\"auto\">шт.</span><span data-ccp-props=\"{\">&nbsp;</span></li>\r\n<li><span data-contrast=\"auto\"> Санитарная комната больных&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1шт.</span></li>\r\n</ol>\r\n<p><span data-contrast=\"auto\">&nbsp;&nbsp;</span><span data-contrast=\"auto\">16.Связь, телефон.</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p>&nbsp;</p>', '264-13_Nevr_Rodilnoye_.jpg', '264-13_Nevr_Rodilnoye_.jpg', 1578303075, 1580838021, '', 'Проект неврологического отделения(реконстр родильного). Купить проектную документацию.', 'Купить, проектную,  документацию, Проект,  неврологического,  отделения, реконструкция,  родильного.', ' <center><h2>Проектом предусмотрено терапевтическое отделение на 21 койку и неврологическое отделение на 36 коек.</h2></center> ', '', 1),
(28, 'Proekt-razborki-otvala-aspiratsiya', 10, 0, '70-06', 'Проект разборки отвала(аспирация)', '200.00', '350.00', 4294967295, 'https://yadi.sk/d/3T72_-ENXJt1mw', '<p>Проект разборки отвала(аспирация)</p>', '<p>Проект разборки отвала(аспирация)</p>\r\n<p>Технические решения.</p>\r\n<p>2.1. В данной части проекта предусматривается пылеудаление от <br />производственного процесса комплекса переработки. Производственной вредностью <br />при технологическом процессе является угольная пыль, для локализации которой <br />предусматривается вытяжная система В1. В местах пылеобразования устраивается <br />вытяжная система с местным отсосами, с механическим побуждением. Приток <br />неорганизованный. Точек отсоса шесть.</p>', '70-06_Proekt_Otval_Aspiracia_.jpg', '70-06_Proekt_Otval_Aspiracia_.jpg', 1578304287, 1580897795, '', 'Проект разборки отвала(аспирация). Купить проектную документацию.', 'Проект, разборки, отвал, аспирация, циклон, вентилятор, вытяжная. система', '<center><h2> Проектом предусматривается пылеудаление от \r\nпроизводственного процесса комплекса переработки</h2></center>', '', 1),
(29, 'Proekt-kap-rem-FSS-vn-inzhenernie-seti', 13, 0, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '150.00', '50.00', 4294967295, ' https://yadi.sk/d/SUFQactGpxy-hw', '<p>Проект кап рем ФСС(вн. инженерные сети)</p>', '<p>Проект кап рем ФСС(вн. инженерные сети)</p>\r\n<p>Санитарно-техническая часть</p>\r\n<p>В данной части проекта разработаны системы отопления и <br />вентиляции здания ФСС по ул. Ионова, 112 г. Шахты.<br />1. Основной комплект рабочих чертежей по санитарно-технической части &laquo;ОВ&raquo; <br />выполнен на основании:<br />1.1. Технического задания;<br />1.2 Требований:<br />&bull; СНиП 41-01-2003 &ndash; &laquo;Отопление, вентиляция, кондиционирование&raquo;,<br />&bull; СНиП 2.08.02-89* &ndash; &laquo;Общественные здания и сооружения&raquo;<br />&bull; СНиП 23.01-99 &ndash; &laquo;Строительная климатология&raquo;,<br />&bull; СНиП 21.01-97* &ndash; &laquo;Пожарная безопасность зданий и сооружений&raquo;<br />В связи с устройством санузла и душевой на 3-м этаже здания, проектом <br />решаются вопросы жизнеобеспечения, а именно вентиляции, отопления.<br />При визуальном обследовании существующей системы отопления выявлено, <br />что система эксплуатируется, в нормальном состоянии. Система вентиляции и <br />отопления требует дополнительного решения.<br />Технические решения:</p>', '119-07_Proekt_kap-rem_FSS_.jpg', '119-07_Proekt_kap-rem_FSS_.jpg', 1578388736, 1578725653, '', '', 'проект, внутренние, инженерные. сети', '', '', 1),
(30, 'Polnij-dostup-k-katalogu-1-j-uroven-i-nizhe', 14, 0, '1-1', 'Полный доступ к каталогу архива (1-й уровень и ниже) в течении 4-х часов;', '2000.00', '0.00', 4294967295, 'https://yadi.sk/d/vpcZYbRQ6QVCuA', '<p>Полный доступ к каталогу (1-й уровень и ниже) на одни сутки;</p>', '<h2>Полный доступ к каталогу архива(1-й уровень и ниже) в течении 4-х часов;</h2>\r\n<h2><a href=\"http://www.arhiv-proekt.ru/\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов&nbsp;www.arhiv-proekt.ru;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>', '', '', 1578770927, 1580935117, '', 'Полный доступ к каталогу архива (1-й уровень и ниже) в течении 4-х часов;', 'разработка, проекта. канализации. водоснабженияпроект, архив, проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов, дома, коттеджи, линейные,  инженерные,  сети, автомобильные, дороги', '<center><h2> Проектная документация на строительство (реконструкцию, капремонт)</h2></center>', '', 1),
(31, 'Polnij-dostup-ko-vsemu-arhivu-vse-urovni-3000-rub-za-odni-sutki', 14, 0, '1-2', 'Полный доступ ко всему архиву (все уровни) в течении 4-х часов;', '3000.00', '0.00', 4294967295, 'https://yadi.sk/d/FvDT62QT9RhOoA', '<p>Полный доступ ко всему архиву (все уровни) на одни сутки;</p>', '<h2>Полный доступ ко всему архиву (все уровни) - в течении 4-х часов;</h2>\r\n<h2><a href=\"http://www.arhiv-proekt.ru/\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов&nbsp;www.arhiv-proekt.ru;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>', '', '', 1578771562, 1580916681, '', 'Полный доступ ко всему архиву (все уровни) в течении 4-х часов.', 'разработка, проекта. канализации. водоснабжения, проект, архив, проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов, дома, коттеджи, коттеджа, инженерные,  сети, автомобильные, дороги', '<center><h2> Проектная документация на строительство (реконструкцию, капремонт)</h2></center>', '', 1),
(32, 'Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu', 14, 0, '1-3', 'Аренда электронного архива с архивариусом в удаленном режиме(с 9до 18,раб.день) на два месяца', '45200.00', '0.00', 4294967295, 'Направьте на email: docs_shop@arhiv-proekt.ru реквизиты контактного лица для исполнения договоренности по аренде архива.', '<p>Аренда электронного архива с архивариусом в удаленном режиме(с 9до 18,раб.день) на два месяца;</p>', '<h2>Аренда электронного архива с архивариусом в удаленном режиме(с 9до 18,раб.день) на два месяца;</h2>\r\n<h2><a href=\"http://www.arhiv-proekt.ru/\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов&nbsp;www.arhiv-proekt.ru;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>\r\n<p style=\"-qt-block-indent: 0; text-indent: 0px; margin: 0px;\"><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">В стоимость услуги \"Аренда\" входит:</span></p>\r\n<p style=\"-qt-paragraph-type: empty; -qt-block-indent: 0; text-indent: 0px; font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600; margin: 0px;\">&nbsp;</p>\r\n<p style=\"-qt-block-indent: 0; text-indent: 0px; margin: 0px;\"><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">1. Передача любого документа архива по электронной почте заказчика, по результатам просмотра архива&nbsp; </span><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">с помощью программы Teamviewer;</span></p>\r\n<p style=\"-qt-block-indent: 0; text-indent: 0px; margin: 0px;\"><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">2. Три подключения архива к программе Teamviewer по одному часу в течении смены;</span></p>\r\n<p style=\"-qt-block-indent: 0; text-indent: 0px; margin: 0px;\"><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">3. Передача заказчику по электронной почте до 3-х </span><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">каталогов 2-го уровня и ниже (см. www.arhiv-proekt.ru) </span><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">в сутки;</span></p>\r\n<p style=\"-qt-block-indent: 0; text-indent: 0px; margin: 0px;\"><span style=\"font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600;\">4. Любые тематические запросы с передачей до 5 файлов к одному запросу;</span></p>\r\n<p style=\"-qt-paragraph-type: empty; -qt-block-indent: 0; text-indent: 0px; font-family: \'DejaVu Sans\'; font-size: 11pt; font-weight: 600; margin: 0px;\">&nbsp;</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 301px; top: 43.4219px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '', '', 1578772123, 1585677050, '', 'Аренда электронного архива с архивариусом в удаленном режиме(с 9до 18,раб.день) на одну неделю;', 'разработка, проекта. канализации. водоснабжения, проект, архив, проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов, дома,  коттеджи,  линейные,  инженерные,  сети, автомобильные. дороги', '<center><h2>Аренда электронного архива</h2></center>', '', 1),
(33, 'Сообщите', 14, 0, '1-4', 'Удаленный просмотр архива(все уровни) с помощью программы Teamview, c участием архивариуса', '300.00', '0.00', 4294967295, 'Собщите рамочно, предварительное время просмотра архива(9-11; 11-13; 15-17;   17-19) на эл.почту -  docs_shop@arhiv-proekt.ru и мы назнчим время просмотра и   передадим реквизиты для связи. Администратор.', '<p>Удаленный просмотр архива(все уровни) с помощью программы Teamview, c участием архивариуса</p>', '<h2>&nbsp; Удаленный просмотр архива(все уровни) с помощью программы Teamview, c участием архивариуса<br /><a href=\"http://www.arhiv-proekt.ru/\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов&nbsp;www.arhiv-proekt.ru;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>', '', '', 1578831206, 1580916027, '', 'Удаленный просмотр архива(все уровни) с помощью программы Teamview, c участием архивариуса', 'разработка, проекта. канализации,  проект, архив,  проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов, дома,  коттеджи, коттеджа, линейные,  инженерные,  сети, автомобильные, дороги', '<center><h2>Проектная документация </h2></center>\r\n', '', 1),
(34, 'Proekt-kap-remonta-tubdispansera', 8, 0, '116-07', 'Проект кап. ремонта тубдиспансера', '450.00', '600.00', 4294967295, 'https://yadi.sk/d/i62uUKtfb0UmWg', '<p>Проект кап. ремонта тубдиспансера</p>', '<p>Проект кап. ремонта тубдиспансера</p>\r\n<p>ВК1, ОВ1, ТС1, НВК1 Противотубер. дисп II-этап;</p>', '116-07_Kap-Rem_Tubdispanser.jpg', '116-07_Kap-Rem_Tubdispanser.jpg', 1578857343, 1580837544, '', 'Проект кап. ремонта тубдиспансера. Купить проектную документацию.', 'проект. водоотведение, водоснабжение, теплоснабжение, отопление, вентиляция,  капитальный,  ремонта тубдиспансера. Купить.  проектную, документацию', '<center><h2>Разделы проекта: ВК1, ОВ1, ТС1, НВК1</h2></center>', '', 1),
(35, 'Proekt-zameni-kanalizatsion-kollektora', 2, 0, '154-08', 'Проект замены канализационного коллектора', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/oZyuJsZxyb5yrA', '<p>Проект замены канализационного коллектора</p>', '<p>Проект замены канализационного коллектора(выписка)</p>\r\n<p>&nbsp; На основании задания на проектирование рабочего проекта , технических условий предусмотрена замена аварийного самотечного канализационного коллектора &Oslash; 200мм на &Oslash;225мм, протяженностью 244,5м с подключением по трассе абонентов и врезкой в существующий канализационный коллектор &Oslash;300 по ул.Р.Люксембург. <br />&nbsp; &nbsp;Сети проходят по застроенной территории. На проектируемой сети предусмотрены колодцы.</p>', '', '', 1578859377, 1578859377, '', '', 'проект, замена, канализационный, коллектор', '', '', 1),
(36, 'Proekt-vodoprovoda', 1, 0, '167-08', 'Проект водовода', '400.00', '0.00', 4294967295, 'https://yadi.sk/d/m9zDbPXITEh7dg   https://yadi.sk/d/m9zDbPXITEh7dg', '<p>Проект водовода</p>', '<p>Проект водовода</p>\r\n<p>&nbsp; Согласно техническим условиям предусматривается реконструкция существующих аварийных участков водопроводов:<br />&ndash; проложенный по ул. Центральная &Oslash;150, протяженностью 1850м;<br />&ndash; распределительный водопровод &Oslash;100мм, проложенный по ул. Школьная, <br />протяженностью 500м;<br />&ndash; распределительный водопровод &Oslash;100мм, проложенный по ул. Центральная и <br />переулку от ул. Центральная, протяженностью 200м.<br />Трубопроводы коррозированы, имеют течи, в колодцах отсутствует запорная <br />арматура</p>', '167-08_Pr-t_Vodovoda_.jpg', '167-08_Pr-t_Vodovoda_.jpg', 1578860691, 1580814053, '', 'Проект водовода. Купить проектную документацию.', 'купить, проектная, документация, проект, водопровод, колодцы', '<center><h2>согласно техническим условиям предусматривается реконструкция существующих аварийных участков водопроводов, общей протяженностью 2550 п.м.</h2></center>', '', 1),
(37, 'Proekt-kapitalnogo-remonta-uchastkovoj-bolnitsi', 8, 0, '172-08', 'Проект капитального ремонта участковой больницы.', '700.00', '850.00', 4294967295, 'https://yadi.sk/d/2sRryqgiwXWJKw          https://yadi.sk/d/z9G3oOx9TADVlA   ', '<p>Проект капитального ремонта участковой больницы.</p>', '<p>Проект капитального ремонта участковой больницы.</p>\r\n<p>5.1 Объемно-планировочная характеристика здания (выписка)</p>\r\n<p>Согласно технического задания и технического заключения, проектом <br />предусматривается капитальный ремонт здания участковой больницы. <br />Здание участковой больницы одноэтажное, сложной конфигурации с <br />размерами в осях: <br />Г-И, 3-5 &ndash; 23,54х15,4м <br />А-Г, 1-6 &ndash; 9,68х41,9м <br />В-Д, 6-7 &ndash; 13,72х21,8м <br />Здание без подвала, над всем зданием &ndash; чердак. Высота помещений в <br />здании - 3,5м; в помещениях в осях Е-Г, 3-4 &ndash; 2,9м. <br />Проектом предусматривается выполнение следующих работ: <br />1. Выполнить благоустройство участка, обеспечив, таким образом, отвод <br />поверхностных вод от здания, путем засыпки образовавшихся выемок и подсыпки <br />грунта, создав уклон в сторону от здания не менее i=0,02, очистить территорию, <br />прилегающую к зданию от разросшегося кустарника. <br />2. Выполнить по всему периметру здания асфальто-бетонную отмостку с уклоном <br />i=0,03 от здания шириной 1,5м, с устройством щебеночного основания. <br />3. Выполнить усиление и ремонт бутового ленточного фундамента по осям &laquo;7&raquo;, <br />&laquo;А&raquo;, &laquo;Б&raquo;. <br />4. Выполнить ремонт кирпичной кладки наружных стен методом инъектирования по <br />осям &laquo;7&raquo;, &laquo;Б&raquo; и частично перекладкой. <br />5. Выполнить усиление перемычек оконных и дверных проемов в наружных кирпичных <br />стенах.<br />6. Выполнить замену и усиление отдельных элементов чердачного перекрытия.<br />7. Выполнить пароизоляцию и замену разложившегося утеплителя из шлака на <br />утеплитель из плит ППЖ-200.<br />8. ...............</p>', '172-08_Pr-t_Kap-Rem_Bolnica_.jpg', '172-08_Pr-t_Kap-Rem_Bolnica_.jpg', 1578901292, 1580830678, '', 'Проект капитального ремонта участковой больницы. Купить проектную документацию.', 'Проект,  капитального, капитальный,  ремонт, ремонт,  участковой,  больницы, больница, Купить,  проектную документацию, проект. капитальный, ремонт, ов. вк. тс', '<center><h2>Согласно технического задания и технического заключения, проектом предусматривается капитальный ремонт здания участковой больницы</h2></cente<center>', '', 1),
(38, 'Proekt-kapitalnogo-remonta-doma-kulturi', 7, 0, '173-08', 'Проект капитального ремонта дома культуры.', '500.00', '0.00', 4294967295, 'https://yadi.sk/d/tOzUGw-zR2WFUA', '<p>Проект капитального ремонта дома культуры.</p>', '<p>Проект капитального ремонта дома культуры.</p>\r\n<p>&nbsp; Для повышения эксплуатации здания дома культуры рекомендуется выполнить следующее:<br />- выполнить комплекс мероприятий по предотвращению подтопления территории, прилегающей к Дому культуры;<br />- выполнить вертикальную обмазочную гидроизоляцию всех стен фундаментов гидроизоляционным составом &laquo;Вандекс ВВ-75&raquo;;<br />- выполнить усиление фундаментов путем бетонирования, связав бетон с существующей каменной кладкой фундаментов анкерами;<br />- выполнить пристенный дренаж подвалов, заложив перфорированные трубы по периметру подвалов, выводя их в пониженные места, в колодцы;<br />- выполнить по всему периметру здания новое асфальтовое покрытие отмостки шириной 1,5м с уклоном i=0,03 от здания;<br />- выполнить гидроизоляцию стен подвала составом &laquo;Вандекс ВВ-75&raquo; и предусмотреть гидроизоляцию пола подвала с устройством пластового дренажа &laquo;Delta-MS 20&raquo;;<br />- переложить разрушенную часть цоколя здания. Зачистить поверхность цоколя пескоструйным способом, расшить трещины &laquo;Структуритом&raquo; и оштукатурить торосилом;<br />- ......................<br />- ......................</p>', '173-08_Kap_REM_DK.jpg', '173-08_Kap_REM_DK.jpg', 1578903175, 1580911524, '', 'Проект капитального ремонта дома культуры. Купить проектную документацию.', 'проект, капитальный, ремонт. дом. культуры', '<center><h2>Проект капитального ремонта дома культуры.</h2></center>', '', 1),
(39, 'Proekt-rekonstruktsii-vodoprovodnih-setej', 1, 0, '175-08', 'Проект реконструкции водопроводных сетей.', '300.00', '0.00', 4294967295, 'https://yadi.sk/d/l48FdWEpVkNnQg', '<p>Проект реконструкции водопроводных сетей.</p>', '<p>Проект реконструкции водопроводных сетей.</p>\r\n<p>Технические решения (выписка)<br />&nbsp; &nbsp;В соответствии с техническими условиями № 387 проектом предусматривается <br />реконструкция водопроводных сетей:<br />по улицам Кирова, Степная, Садовая с заменой существующих: по ул.Кирова &ndash; <br />стального водопровода &Oslash;50мм, полиэтиленового &Oslash;40мм, чугунного &Oslash;50мм на <br />полиэтиленовые из ПНД ПЭ 80SDR 13,6-110х8,1 (Т) питьевая ГОСТ 18599-2001, <br />протяженностью 767м; <br />по ул.Степная &ndash; стального водопровода &Oslash;150мм, &Oslash;80мм, чугунного &Oslash;80мм на <br />полиэтиленовые из ПНД ПЭ 80SDR 13,6 &ndash; 110х8,1(Т) питьевая ГОСТ18599-2001, <br />протяженностью 616м; <br />по ул.Садовая &ndash; стального водопровода &Oslash;50мм на полиэтиленовые из ПНД ПЭ 80SDR <br />13,6 &ndash; 110х8,1 (Т) питьевая ГОСТ 18599-2001, протяженностью 297м. Замена <br />выполнена на основании акта выбора трассы.<br />......................................................................<br />......................................................................</p>', '175-08_r-t_Rekonstr_Vodoprovod.jpg', '175-08_r-t_Rekonstr_Vodoprovod.jpg', 1578942195, 1580813495, '', 'Проект реконструкции водопроводных сетей. Купить проектную документацию.', 'купить, проектная, документация, проект, водопровод. реконструкция', '<center><h2>В соответствии с техническими условиями № 387 проектом предусматривается\r\nреконструкция водопроводных сетей, с заменой существующих, общей протяженностью 1680 п.м</h2></center>', '', 1),
(40, 'Proekt-rekonstruktsii-obektov-kanalizatsionnih-setej-korrektirovka', 2, 0, '175-09', 'Проект реконструкции объектов канализационных сетей(корректировка).', '800.00', '0.00', 4294967295, 'https://yadi.sk/d/45NbY0xKwZhzGA', '<p>Проект реконструкции объектов канализационных сетей(корректировка).</p>', '<p>Проект реконструкции объектов канализационных сетей(корректировка).</p>\r\n<p>&nbsp; &nbsp;</p>\r\n<p>1. Введение</p>\r\n<p>1.1 Основание для разработки проектной документации(выписка)</p>\r\n<p><br />Донским институтом науки и проектирования &laquo;Донпроект&raquo; выполнен проект <br />&laquo;Реконструкция объектов канализационных сетей в пос.Соколово-Кундрюченский и <br />Юбилейный&raquo;. По выполненному проекту разработана система канализации для отвода <br />хоз-бытовых сточных вод в пос. Соколово-Кундрюченский и Юбилейный в которых <br />проживают работники ликвидируемого филиала ОАО &laquo;Ростовуголь&raquo; шахта <br />(&laquo;Степановская&raquo;). Канализационные сети запроектированы в пос. Соколово- <br />Кундрюченском по улицам: И.Франко, Писарева, Лаптева, Жукова, Ак. Королева, <br />Железнякова, Антипова; в пос.Юбилейном &ndash; по улицам Рижская и Громовой. <br />Проектом предусмотрено строительство канализационной насосной станции и <br />реконструкция существующей КНС по ул.Франко и строительство КНС 2 по <br />ул.Королева.<br />При этом, ранее разработанным проектом, не решены следующие вопросы:<br />- водоотведение от жилых домов по улицам: И.Франко, Писарева, Лаптева, <br />Погодина, Антипова, Жукова, Пирогова, Брестская, У.Громовой;<br />- ввод в эксплуатацию, ранее построенных траснпортабельных канализационных <br />насосных станций и очистных сооружений;<br />- электроснабжение траснпортабельных канализационных насосных станций и <br />очистных сооружений;<br />........................................................................<br />........................................................................</p>', '175-09_Pr-t_Rekonstr_Kanalizacin_sety.jpg', '175-09_Pr-t_Rekonstr_Kanalizacin_sety.jpg', 1578943907, 1580808980, '', 'Проект реконструкции объектов канализационных сетей(корректировка). Купить проектную документацию.', 'Проект реконструкции объектов канализационных сетей, корректировка.  проект, реконструкции, кнс. насосные. станции, кододцы', '<center><h2>Проектом предусмотрено строительство канализационной насосной станции и\r\nреконструкция существующей КНС</h2></center>', '', 1),
(41, 'Proekt-zameni-avarijnih-vodoprovodnih-setej', 1, 0, '176-08', 'Проект замены аварийных водопроводных сетей.', '700.00', '950.00', 4294967295, 'https://yadi.sk/d/Q5jkgFO-GoP_wA', '<p>Проект замены аварийных водопроводных сетей.</p>', '<p>Проект замены аварийных водопроводных сетей.</p>\r\n<p>3.1 Технические решения (выписка)</p>\r\n<p>Настоящим проектом предусматривается замена аварийных существующих <br />водопроводных сетей :<br />- &Oslash;160 мм, протяженностью 1511м по ул.Центральная от автодороги Шахты- <br />Раздорская ВК-1 (ГК0) до ВК-12/ПГ-9 (ГК15+11,0) с врезкой в существующий <br />водопровод &Oslash;150 мм (сталь) с помощью фасонных частей;<br />- &Oslash;110мм, протяженностью 319,0м по ул.Центральная от ВК-12/ПГ-9 (ГК <br />15+11,0) до ВК-16 (ГК18+30,0) с врезкой в существующий водопровод &Oslash;110 мм <br />(сталь) с помощью фасонных частей; <br />- &Oslash;110 мм, протяженностью 518,5м по ул.Школьная от ВЛ-9/ПГ-6/УГ-6 (ГК15&prime;) до <br />СВК (ГК 20&prime;+18,5) с врезкой в существующий водопровод &Oslash;100 мм (сталь) с помощью <br />фасонных частей; <br />- &Oslash;110 мм, протяженностью 181м по переулку от ул.Центральная от ВК- <br />10/ПГ-7/УГ-7 (ГК 13&prime;) до ВК-10&prime; (ГК 14&prime;+81,0) с врезкой в существующий <br />водопровод &Oslash;100 мм (сталь) с помощью фасонных частей. ................<br />........................................................................</p>\r\n<p>&nbsp;</p>', '176-08_Pr-t_zamena_vodoprovoda.jpg', '176-08_Pr-t_zamena_vodoprovoda.jpg', 1578985632, 1580813101, '', 'Проект замены аварийных водопроводных сетей. Купить проектную документацию.', 'купить, проектная, документация, проект, водопровод, водоснабжение, колодцы, чертежи колодцев', '<center><h2>Настоящим проектом предусматривается замена аварийных существующих\r\nводопроводных сетей :\r\n- Ø160,110 мм,общей протяженностью 2530 п.м</h2></center>', '', 1),
(42, 'Proekt-zameni-samotechnogo-kollektora', 2, 0, '178-09', 'Проект замены самотечного коллектора', '800.00', '0.00', 4294967295, 'https://yadi.sk/d/WoTX62IELGBfYg   https://yadi.sk/d/PK3tPK9e_P24dg', '<p>Проект замены самотечного коллектора</p>\r\n<p>3.1 Технические решения (выписка).</p>\r\n<p><br />В соответствии с техническими условиями № 175 проектом предусматривается <br />замена самотечного коллектора &Oslash;200-300мм от Кадетского корпуса, по ул. <br />Нагорная с переходом через балку, по ул. Кошевого, далее до КНС №9. Замена <br />выполнена на основании акта выбора трассы. Проектируемый канализационный <br />коллектор выполняется из полиэтиленовых труб с двухслойной профилированной <br />стенкой &laquo;КОРСИС&raquo; диаметром 315мм, протяженностью 861,6м и из стальных <br />электросварных труб диаметром 325х6 протяженностью 50м по металлической <br />эстакаде. Общая протяженность коллектора составляет 911,6м.<br />В соответствии с п.4.8 СНиП 2.04.03-85 min глубина заложения лотка <br />не менее 0,3 м глубины промерзания грунта и не менее 0,7м до верха трубы, <br />считая от отметок поверхности земли. Пересечения проезжей части улицы с <br />усовершенствованным покрытием выполнено открытым способом в футляре из труб <br />ПНД 500Т ГОСТ 18599-2001 &laquo;техническая&raquo;.</p>\r\n<p>................................................................................................................</p>\r\n<p>...............................................................................................................</p>', '<p>Проект замены самотечного коллектора</p>', '178-09_Pr-t_zamena_kollektora.jpg', '178-09_Pr-t_zamena_kollektora.jpg', 1578987954, 1580808488, '', 'Проект замены самотечного коллектора. Купить проектную документацию.', 'купить, проектная, документация, проект, замена. канализационный , коллектор, самотечный', '', '', 1),
(43, 'Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov', 4, 0, '180-09', 'Проект производства работ (ППР) на снос жилых домов.', '150.00', '250.00', 4294967295, 'https://yadi.sk/d/xkL8OAOV-sS8xw', '<p>Проект производства работ (ППР) на снос жилых домов.</p>', '<p>Проект производства работ (ППР) на снос жилых домов.</p>\r\n<p>ОПЗ (выписка)</p>\r\n<p><br />В результате визуального обследования и оценки технического состояния жилого <br />здания выявлено:<br />жилой дом представляет собой одноэтажное здание, в плане с размерами <br />- 11,35х9,10м, в ветхом состоянии. Высота помещений в здании &ndash; 3,3м. <br />Материал основных конструктивных элементов:<br />Фундамент здания &ndash; каменный ленточный.<br />Наружные стены &ndash; деревянные каркасные, оштукатуренные. <br />Внутренние стены &ndash; деревянные оштукатуренные.<br />Перегородки &ndash; деревянные.<br />Крыша &ndash; скатная по сплошной обрешетке.<br />Кровля &ndash; рубероид.<br />Окна, двери &ndash; деревянные. <br />............................................................................<br />............................................................................</p>', '180-09_PPR.jpg', '180-09_PPR.jpg', 1578990248, 1578990248, '', '', '', '', '', 1),
(44, 'Proekt-razborki-i-pererabotki-porodnogo-otvala', 10, 0, '195-10', 'Проект разборки и переработки породного отвала', '1500.00', '0.00', 4294967295, 'https://yadi.sk/d/U2jrK1qYWa6VpA', '<p>Проект разборки и переработки породного отвала</p>', '<p>Проект разборки и переработки породного отвала</p>\r\n<p>...................................................................................................................</p>\r\n<p>3. Основные технологические решения, принятые в рабочем проекте</p>\r\n<p>В настоящем проекте отражена необходимость соблюдения <br />условий и основных технических решений с реализацией их по следующим отдельным <br />элементам: <br />- подъездные дороги;<br />- нарезка въездной полутраншеи, рабочая площадка, пандус - въезд;<br />- водоотводная канава;<br />- ограждающий (предохранительный) вал. <br />Форма указанных элементов, необходимее размеры, метод расчет, значение <br />отдельных составляющих деталей элементов технологических схем, их профиль <br />приняты в соответствии с нормами технологического проектирования.<br />Детальное описание технологических решений и последовательность <br />выполнения работ приведена в соответствующих разделах. <br />............................................................................<br />............................................................................<br />3.6 Технологическая схема разборки породного отвала <br />Технологическая схема разборки предусматривает понижение высоты <br />хребта №2 до отметки 246,0 (до 13,5м) бульдозером (схема рас. 5.10, стр. 80 <br />справочное пособие А.Е.Агапова). Разборка отвала начинается с хребта №1, <br />имеющего достаточную рабочую площадку для работы экскаватора, бульдозера и <br />автотранспорта S=1627м2. <br />С въездной полутраншеи, вскрывшей полезные ископаемые отвала, <br />бульдозером производится подготовка запасов к отработке, устройство уступа <br />для работы экскаватора и разворота автотранспорта не менее 20х20м. <br />..........................................................................<br />..........................................................................<br />4. Технология переработки горной массы породного отвала<br />4.1 Общие сведения<br />Данным разделом приняты решения по переработке горной массы породного отвала <br />на фракции классов 0&divide;13 мм; 13&divide;25 мм; 0&divide;25 мм и 25&divide;100 мм. Полученная горная <br />масса различных классов по гранулометрическому составу используется в качестве <br />строительного материала (щебня).<br />Проектируемое производство состоит из двух основных комплексов:<br />- комплекса разработки породного отвала (см. раздел 3 ПЗ);<br />- комплекса переработки горной массы породного отвала по фракциям</p>\r\n<p>&nbsp;</p>', '195-10_Pr-t_Razborki_Otvala.jpg', '195-10_Pr-t_Razborki_Otvala.jpg', 1578992209, 1580897324, '', 'Проект разборки и переработки породного отвала. Купить проектную документацию.', 'проект. разборка, переработка, отвал, электроснабжение, отопление, породный', '<center><h2>Данным проектом приняты решения по переработке горной массы породного отвала \r\nна фракции классов 0÷13 мм; 13÷25 мм; 0÷25 мм и 25÷100 мм</h2></center>', '', 1);
INSERT INTO `arwm_items` (`itemid`, `itemname`, `catid`, `mnf_id`, `sku`, `title`, `price`, `old_price`, `quantity`, `quantity_txt`, `short_descript`, `long_descript`, `small_img`, `big_img`, `add_date`, `upd_date`, `meta_title`, `description`, `keywords`, `metatags`, `special`, `visible`) VALUES
(45, 'Proekt-kapitalnogo-remonta-vodovoda', 1, 0, '197-10', 'Проект капитального ремонта водовода.', '850.00', '0.00', 4294967295, 'https://yadi.sk/d/BLMz90IG8-ojKQ              https://yadi.sk/d/ggDnWdAPD3LGzg', '<p>Проект капитального ремонта водовода.</p>', '<p>Проект капитального ремонта водовода.</p>\r\n<p>4.2 Технологические и конструктивные решения линейного объекта <br />на выборочный капитальный ремонт водовода</p>\r\n<p>Настоящим проектом заменяется существующий участок водовода &Oslash;219мм <br />из стальных труб протяженностью 594,5м на водопроводные сети диаметром 200мм <br />из труб ПНД 200 (ПЭ-80, Ру=6.3 кгс/см2, SDR 21, 200х9.6) с врезкой в <br />существующий водопровод &Oslash;219мм (сталь) с помощью фасонных частей. <br />Протяженность трассы проектируемого напорного трубопровода - 594.5м. <br /><br />Категория системы водоснабжения по степени обеспеченности подачи воды <br />и класс ответственности - I. Качество воды на хоз-питьевые нужды должно <br />соответствовать ГОСТ 2874-82 &laquo;Вода питьевая&raquo;.<br />..........................................................................<br />..........................................................................</p>', '197-10_Pr-t_REM_Vodovoda.jpg', '197-10_Pr-t_REM_Vodovoda.jpg', 1578994678, 1580812565, '', 'Проект капитального ремонта водовода. Купит проектную документацию.', 'купить, проектная, документация, проект, капитальный, ремонт, водовода', '<center><h2>Настоящим проектом заменяется существующий участок водовода Ø219мм\r\nиз стальных труб протяженностью 594,5м на водопроводные сети диаметром 200мм\r\nиз труб ПНД 200</h2></center>', '', 1),
(46, 'Proekt-zameni-vodovoda-napornogo-kollektora-i-rekonstruktsiya-KNS', 2, 0, '22-05', 'Проект замены водовода, напорного коллектора и реконструкция КНС', '1500.00', '0.00', 4294967295, 'https://yadi.sk/d/l00S3j51Zt0HiA', '<p>Проект замены водовода, напорного коллектора и реконструкция КНС</p>\r\n<p>&nbsp;</p>', '<p>Проект замены водовода, напорного коллектора и реконструкция КНС.</p>\r\n<p>3.2 Технические решения.</p>\r\n<p>Согласно техническим условиям №1192, №2700 ОАО &laquo;Донбассводоснабжение&raquo;, предусмотрена замена аварийных участков водоводов &Oslash;500 мм из стальных труб по ул. Халтурина и ул. Холодова на трубы из ПНД 500Т, ГОСТ 18599-2001 (согласно расчета) с увеличенной толщиной трубы (выполнены основные требования <br />&delta;тр/dн= 0,074&gt;0,015).<br />...........................................................................<br />...........................................................................<br />Проектом предусматривается реконструкция технологической части насосной станции с демонтажем существующих насосов и установкой в машинном помещении пяти основных технологических насосов марки <br />СМ-200-150-500/4, Q=400м3/час, Н=80м. Три насоса являются рабочими, два резервными. Насос и электродвигатель монтируются на общей плите. <br />Насосы устанавливаются под заливом.</p>\r\n<p>........................................................................<br />.......................................................................<br />4.2 Технические решения. <br />Согласно техническим условиям №44 и №43 ЗАО &laquo;Водоканал&raquo; предусмотрена замена существующего аварийного напорного канализационного коллектора на &Oslash;630мм. по ул. Халтурина, протяженностью 1072,0м с подключением к камере переключения расположенной около насосной станции (КНС №4) к существующей камере гашения по пер. Комиссаровский</p>', '22-05_Pr-t_Zamena_Vodovoda.jpg', '22-05_Pr-t_Zamena_Vodovoda.jpg', 1579011904, 1580808369, '', 'Проект замены водовода, напорного коллектора и реконструкция КНС. Купить проектную документацию.', 'купить, проектная, документация,проект, насосная, канализационная, коллектор. водовод. замена', '', '', 1),
(47, 'Proekt-zameni-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij', 2, 0, '23-05', 'Проект замены водоводов, напорного коллектора и реконструкции канализационных насосных станций;', '1500.00', '2000.00', 4294967295, 'https://yadi.sk/d/CTyEBa-WcMSPkg', '<p>Проект замены водоводов, напорного коллектора и реконструкции<br />канализационных насосных станций;</p>', '<p>Проект замены водоводов, напорного коллектора и реконструкции<br />канализационных насосных станций;</p>\r\n<p>Настоящий рабочий проект &laquo;Реконструкция сетей водоснабжения, канализации, КНС № 8а, №2а&raquo;, состоит из следующих разделов:<br />-&laquo;Водопровод по пер. Дундича, пер. Дубинина, ул. Нефедова, <br />ул. Административная&raquo; (23-05-НВ, л.1&divide;10), выполненного согласно технических <br />условий ОАО &laquo;Донбассводоснабжение&raquo; №1192 от 18.05.2004г.; №2700 от <br />19.08.2005г. ;<br />-&laquo;Напорный канализационный коллектор по ул.Революционная, ул.Обуховой, <br />ул. Копровая &raquo; (23-05НК, л. 1&divide;10), выполненных согласно технических условий <br />ЗАО &laquo;Водоканал&raquo; №43 от 18.05.2004г., №34 от 8.02.2005г. Приложения №1, №2, №3 <br />от 08.08.2005 г. <br />-&laquo;Реконструкция канализационных насосных станций № 8а, № 2а&raquo; (23-05-1- <br />ТЗ, л. 1&divide;4; 23-05-1-ТХ, л. 1&divide;8; 23-05-1-ОВ, л. 1&divide;7; 23-05-1-ЭМ, л. 1&divide;14; 23- <br />05-2-ТЗ, л. 1&divide;5; 23-05-2-ТХ, л. 1&divide;12; 23-05-2-ОВ, л. 1&divide;3; 23-05-1-ЭМ, л. <br />1&divide;15), выполненных согласно технических условий ЗАО &laquo;Водоканал&raquo; №43 от <br />18.05.2004г., №34 от 8.02.2005г. Приложения №1, №2, №3 от 08.08.2005 г.</p>', '23-05_2-Pr-t_zamena_Vodovod.jpg', '23-05_2-Pr-t_zamena_Vodovod.jpg', 1579015496, 1580808189, '', 'Проект замены водоводов, напорного коллектора и реконструкции канализационных насосных станций;', 'Проект,  замены, замена,  водоводов, водовод  напорноый,  коллектора, коллектор,   реконструкции,  канализационных,  насосных,  станций;', '', '', 1),
(48, 'Proekt-zamen-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij', 2, 0, '23-05', 'Проект замены водоводов, напорного коллектора и реконструкции канализационных насосных станций;', '1500.00', '2000.00', 4294967295, 'https://yadi.sk/d/CTyEBa-WcMSPkg', '<p>Проект замены водоводов, напорного коллектора и реконструкции<br />канализационных насосных станций;</p>', '<p>Проект замены водоводов, напорного коллектора и реконструкции<br />канализационных насосных станций;</p>\r\n<p>Настоящий рабочий проект &laquo;Реконструкция сетей водоснабжения, канализации, КНС № 8а, №2а&raquo;, состоит из следующих разделов:<br />-&laquo;Водопровод по пер. Дундича, пер. Дубинина, ул. Нефедова, <br />ул. Административная&raquo; (23-05-НВ, л.1&divide;10), выполненного согласно технических <br />условий ОАО &laquo;Донбассводоснабжение&raquo; №1192 от 18.05.2004г.; №2700 от <br />19.08.2005г. ;<br />-&laquo;Напорный канализационный коллектор по ул.Революционная, ул.Обуховой, <br />ул. Копровая &raquo; (23-05НК, л. 1&divide;10), выполненных согласно технических условий <br />ЗАО &laquo;Водоканал&raquo; №43 от 18.05.2004г., №34 от 8.02.2005г. Приложения №1, №2, №3 <br />от 08.08.2005 г. <br />-&laquo;Реконструкция канализационных насосных станций № 8а, № 2а&raquo; (23-05-1- <br />ТЗ, л. 1&divide;4; 23-05-1-ТХ, л. 1&divide;8; 23-05-1-ОВ, л. 1&divide;7; 23-05-1-ЭМ, л. 1&divide;14; 23- <br />05-2-ТЗ, л. 1&divide;5; 23-05-2-ТХ, л. 1&divide;12; 23-05-2-ОВ, л. 1&divide;3; 23-05-1-ЭМ, л. <br />1&divide;15), выполненных согласно технических условий ЗАО &laquo;Водоканал&raquo; №43 от <br />18.05.2004г., №34 от 8.02.2005г. Приложения №1, №2, №3 от 08.08.2005 г.</p>', '23-05_Pr-t_zamena_Vodovod.jpg', '23-05_Pr-t_zamena_Vodovod.jpg', 1579015736, 1580807891, '', 'Проект замены водоводов, напорного коллектора и реконструкции канализационных насосных станций', 'купить, проектная, документация, проект, водовода, канализационная. насосная. станция', '', '', 1),
(51, 'Proekt-munitsipalnoj-avtodorogi-ul-shevchenko', 3, 0, '233-12', 'Проект   муниципальной автодороги(ул.шевченко)', '1700.00', '0.00', 4294967295, 'https://yadi.sk/d/iR-HOHXxgoSfkg', '<p>Проект муниципальной автодороги(ул.шевченко)</p>', '<p>Проект муниципальной автодороги(ул.шевченко)</p>\r\n<p>...........................................................................<br />...........................................................................<br />При разработке проекта использовались материалы топографической <br />съемки,выполненнООО&raquo;Квадро М&raquo;- свидетельство о допуске к определенному виду <br />или видам работ, которые оказывают влияние на безопасность объектов <br />капитального строительства по выполнению инженерных изысканий №01-И-№0909-2 от <br />28 марта 2011г. Выданная &laquo;Ассоциация Инженерные изыскания в строительстве&raquo;,и <br />материалы инженерно-геологических изысканий выполненых-ООО &laquo;Ингео&raquo;- <br />свидетельство о допуске к определенному виду или видам работ, которые <br />оказывают влияние на безопасность объектов капитального строительства №01-И- <br />№0927-3 от 11 апреля 2011г. Основание выдачи: решение Координационного совета <br />(протокол №65 от 11.04.2011г.) <br />Проектирование выполнено в программном комплексе топоматик &laquo;ROBUR&raquo; версии 7.5 <br />по цифровой модели местности. Сметные расчеты выполнены ресурсным методом с <br />использованием сметного программного комплекса &laquo;РИК&raquo;. Сметная стоимость <br />строительства определена в текущем уровне цен по сборникам на основании ТСНБ- <br />2001 Ростовской области (эталон) в базисных ценах на 2000г с пересчетом в <br />текущие цены на 4 квартал 2012г<br />..........................................................................<br />3. Проектные решения<br />..........................................................................<br />3.4. Дорожная одежда</p>\r\n<p>На участках капитального ремонта расчет дорожной одежды производился по ОДН <br />218.1.052-2002. Минимальный требуемый расчетный модуль упругости конструкции <br />проектируемой дорожной одежды составляет 150 МПа при коэффициенте надежности <br />0,85. <br />Согласно данным инженерно-геологических изысканий cуществующая дорожная одежда <br />имеет следующую конструкцию: <br />- а.б. покрытие толщиной 7см;<br />- щебеночное основание 60см;<br />Учитывая опыт строительства и эксплуатации дорог в данном районе, а также <br />наличие источников дорожно-строительных материалов, было разработано 2 <br />варианта конструкции дорожной одежды при капитальном ремонте дороги (смотри <br />лист &laquo;Варианты конструкции дорожной одежды&raquo;):</p>', '233-12_Pr-t_Avt-Dorogi-Shevchenko.jpg', '233-12_Pr-t_Avt-Dorogi-Shevchenko.jpg', 1579028228, 1580549965, '', 'Проектная документация на капитальный ремонт муниципальной автомобильной дороги. В составе чертежей и пояснительной записки.', 'проект, автомобильная, дорога, дорожные, одежды, покрытие', '<h2>Проектирование выполнено в программном комплексе топоматик «ROBUR» версии 7.5\r\nпо цифровой модели местности. Сметные расчеты выполнены ресурсным методом с\r\nиспользованием сметного программного комплекса «РИК».</h2>', '', 1),
(50, 'Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra', 13, 0, '228-11', 'Технический проект экскалатора универсама.        Дизайн проект торгового центра.', '200.00', '0.00', 4294967295, 'https://yadi.sk/d/LAG82yNmZXYP4A                     https://yadi.sk/d/Pyxyh0QKBBwqvQ           https://yadi.sk/d/UT4jHEYpqr2l9g                    https://yadi.sk/d/nIVnOpfCw_CRMg           https://yadi.sk/d/lGLAnUl9YLEkvA', '<p>Технический проект экскалатора универсама.<br />Дизайн проект торгового центра.</p>', '<p>Технический проект эскалатора универсама.<br />Дизайн проект торгового центра.</p>\r\n<p>Обоснование отдельных проектных решений.</p>\r\n<p>Отступ эскалатора от здания торгового центра позволяет:<br />-устроить вход в торговый зал в трех вариантах;<br />-площадка примыкания к эскалатору здания пристройки может быть использована<br />более рационально за счет объединения с торговой площадью основного здания;<br />Размещение входа у &laquo;Мегафон&raquo; может быть решено за счет устройства <br />консольной<br />площадки на отметке -0,04, съемных ступенек(каркасного типа), что решит <br />проблему водовода в районе &laquo;Мегафон&raquo; При этом, согласно представленной съемки, <br />водовод заложен в 7,0 м от западной стены основного здания, что устраивает <br />предложенные варианты.<br />Также на отметке +4,320 предлагается консольная часть (в сторону <br />&laquo;Мегафон&raquo;), что<br />позволит:<br />-увелить торговую площадь 2-го этажа;<br />-устроить дополнительный пожарный выход с устройством пожарной лестницы и <br />ходового<br />трапа по крыше пристройки в районе &laquo;Мегафон&raquo; Наличие открытой, центральной <br />лестницы с подвала на уровень +4,32 создает определенную напряженность в <br />вопросе противопожарных безопасности.</p>', '36972.jpg', '36972.jpg', 1579018531, 1579018901, '', '', 'технический. проект. дизайн. эскалатор, универсам', '', '', 1),
(52, 'Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi', 3, 0, '235-12', 'Проект капитального ремонта автомобильной дороги', '1500.00', '0.00', 4294967295, 'https://yadi.sk/d/dA4xuFqMdvPrEA', '<p>Проект капитального ремонта автомобильной дороги</p>', '<p>Проект капитального ремонта автомобильной дороги</p>\r\n<p>......................................................................................................................</p>\r\n<p>3.3. Земляное полотно.<br />Продольный профиль земляного полотна.<br />Продольный профиль запроектирован по нормативам для дорог второстепенная улица в жилой застройке с учетом СНиП 2.07.01-89. Основные технические показатели продольного профиля по пер. Кооперативный следующие:<br />- наибольший продольный уклон - 11,6&permil;;<br />- наименьший радиус вертикальной кривой: <br />- выпуклой - 350,85 м;<br />- вогнутой - 2548,45 м.<br />Проектирование продольного профиля произведено в увязке с поперечными профилями существующей дороги на рассматриваемом участке.<br />Поперечный профиль земляного полотна<br />Поперечные профили земляного полотна разработаны согласно типовым материалам для проектирования серии 503-0-48.87 &laquo;Земляное полотно автомобильных дорог общего пользования&raquo; и требованиям СНиП 2.05.02-85.<br />Сооружение земляного полотна предусмотрено из грунта от разборки существующей насыпи, срезки обочин. Трасса дороги от ПК0+00 &ndash; ПК2+00 проходит по оси земляного полотна в существующих бровках, требуется небольшая подсыпка земляного полотна с доведением параметров до нормативных.<br />Работы по земляному полотну заключаются в предварительной срезке присыпных обочин земляного полотна с перемещением в валы на расстояние до 5м. Далее после строительства дорожной одежды возвращаем ранее разработанный грунт, с последующим уплотнением катками при 8 проходах по одному следу. Для достижения оптимальной влажности уплотняемого грунта предусматривается его полив.</p>\r\n<p>..............................................................................................................</p>', '235-12_Pr-t_Avto-Doroga.jpg', '235-12_Pr-t_Avto-Doroga.jpg', 1579030290, 1580549605, '', 'Проектная документация на капитальный ремонт муниципальной автомобильной дороги. В составе чертежей и пояснительной записки.', 'проект, автомобильная, дорога. дорожное, полотно, одежды', '<h2>Основные технические показатели продольного профиля по пер. Кооперативный следующие:\r\n- наибольший продольный уклон - 11,6‰;\r\n- наименьший радиус вертикальной кривой:\r\n- выпуклой - 350,85 м;\r\n- вогнутой - 2548,45 м.</h2>', '', 1),
(53, 'Proekt-munitsipalnoj-avtomobilnoj-dorogi', 3, 0, '237-12', 'Проект муниципальной автомобильной дороги.', '1500.00', '0.00', 4294967295, ' https://yadi.sk/d/gmTDnvDCvCXHNw', '<p>Проект муниципальной автомобильной дороги.</p>', '<p>Проект муниципальной автомобильной дороги.</p>\r\n<p>1.2. Технические нормативы</p>\r\n<p>Согласно заданию на разработку проектной документации , при проектировании рассматриваемого участка дороги приняты следующие основные технические параметры:<br />- категория участка дороги &ndash; улица в жилой застройке;<br />- протяженность проектируемого участка &ndash; 993 м;<br />- число полос движения &ndash; 2;<br />- ширина земляного полотна &ndash; 9 м;<br />- ширина проезжей части &ndash; 6.0 м;<br />- ширина обочины &ndash; 1,5 м;<br />- дорожная одежда &ndash; облегченного типа &ndash; асфальтобетон;<br />- искусственные сооружения &ndash; согласно ГОСТ Р 52748-2007 под расчетные нагрузки А11; НК-80.</p>', '237-12_1-Pr-t-Avt-dorog_Lug.jpg', '237-12_1-Pr-t-Avt-dorog_Lug.jpg', 1579073126, 1579077068, '', '', 'Проект, документация, разработка, автомобильные. дороги, дорожное, покрытие, корыто', '', '', 1),
(54, 'Proekt-munitsipalnoj-avtomobilno-dorogi', 3, 0, '248-12', 'Проект муниципальной автомобильной дороги', '1500.00', '0.00', 4294967295, ' https://yadi.sk/d/JoyzVvoG0Yaezw', '<p>Проект муниципальной автомобильной дороги</p>\r\n<p>.................................................................................................................</p>\r\n<p>1.2. Технические нормативы<br />Согласно заданию на разработку проектной документации и ведомости дефектов и намечаемых работ, утвержденными директором МКУ ЖКХ , при проектировании рассматриваемого участка дороги приняты следующие основные технические параметры:<br />- категория участка дороги &ndash; Магистральная улица &ndash; непрерывного движения;<br />- число полос движения &ndash; 4;<br />- ширина проезжей части &ndash; 4х3,75+4х0,75 м (в бордюрном профиле);</p>\r\n<p>&nbsp;</p>\r\n<p><br />- разделительная полоса &ndash; 4,5м;<br />- наименьшие радиусы вертикальных кривых:<br />выпуклой &ndash; 1500 м;<br />вогнутой - 500 м;<br />- наименьший радиус кривой в плане - 400 м;<br />- дорожная одежда &ndash;асфальтобетон.</p>\r\n<p>.........................................................................................................</p>', '', '248-12_Pr-t_Avt-Doroga.jpg', '248-12_Pr-t_Avt-Doroga.jpg', 1579077382, 1580549315, '', 'Проектная документация на капитальный ремонт муниципальной автомобильной дороги. В составе чертежей и пояснительной записки.', 'проект, автомобильной, дороги,  разделительные,  полосы, движения. ширина. проезжей. части', '<h2>основные технические параметры:\r\n- категория участка дороги – Магистральная улица – непрерывного движения;\r\n- число полос движения – 4;\r\n- ширина проезжей части – 4х3,75+4х0,75 м (в бордюрном профиле);</h2>', '', 1),
(55, 'Proekt-kottedzha-Raschet-fundamenta', 4, 0, '256-12', 'Проект коттеджа (Расчет фундамента).', '200.00', '0.00', 4294967295, '', '<p>Проект коттеджа (Расчет фундамента).</p>', '<p>Проект коттеджа (Расчет фундамента).</p>\r\n<p>3. Расчет и конструирование фундамента.</p>\r\n<p>При отсутствии инженерно-геологических изысканий принимаем грунты основания &ndash; насыпные.</p>\r\n<p>3.1 По оси А:</p>\r\n<p>Nп=1680,82 кг/м2 = 16,8 кН/м.п. <br />Nв=2255,25 кг/м2 = 10,11 кН/м.п.<br />Принимаем расчетное сопротивление грунта R=1,1 кг/см2.<br />Yср= 20 кН/м3.<br />Глубина заложения фундамента d=1,5 м.<br />Принимаем нагрузку от пола подвала =2 кН/м.п.<br />N2= 1*(Nп+ Nв)=1*(16,8+10,11+2)=28,91 кН/м.п.<br />Принимаем ширину фундамента b=1,0м.<br />Определяем нагрузку на основание от 1 п.м. фундамента<br />................................</p>', '256-12_Raschet-fundament.jpg', '256-12_Raschet-fundament.jpg', 1579082669, 1580827784, '', 'Проект коттеджа (Расчет фундамента). Купить проектную документацию.', 'купить. проектную. докуметацию, проект, жилой. дом. коттедж, расчет. фундамент, сбор. нагруок', '<center><h2>Проект коттеджа (Расчет фундамента).</h2></center>', '', 1),
(56, 'Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj', 5, 0, '255-12', 'Проект прокола под федеральной железной дорогой.', '1200.00', '0.00', 4294967295, '', '<p>Проект прокола под федеральной железной дорогой.</p>', '<p><br />Проект прокола под федеральной железной дорогой.<br />..........................................................................<br />Проектом предусматривается:<br />-. монтаж нового металлического футляра диаметром 720 мм, толщина 10 мм с изоляцией &laquo; ВУС&raquo; в существующий металлический футляр диаметром 820 мм; выполнить противокоррозионную изоляцию футляра и протекторную его защиту от электрохимической коррозии.<br />- пространство между новым и существующим футляром бетонируется методом тампонажа;<br />- протаскивание труб ПЭ-100 SDR 17 &Oslash; 500х29,7 напорного канализационного коллектора в футляр диаметром 720 мм;<br />- устройство колодцев, прокладка труб на участке от ПК07+42.00 до ПК08+48.20 устройство запорной арматуры.<br />При этом коллектор пересекает две кабельные линии связи: КЛ 7&times;4 и КЛ 14&times;4, принадлежащие ОАО &laquo;РЖД&raquo;, а также линию питьевого водопровода. <br />Для защиты кабелей связи проектом предусматриваются металлические швеллеры №20.<br />...........................................................................<br />...........................................................................</p>', '163762.jpg', '163762.jpg', 1579084513, 1580887825, '', 'Проект прокола под федеральной железной дорогой. Купить проектную документацию.', 'проект, прокол,   железная дорога,   футляр,  электрохимзашита', '<center><h2>Проектом предусматривается\r\n монтаж нового металлического футляра диаметром 720 мм, толщина 10 мм с изоляцией  \"ВУС\"</h2></center>', '', 1),
(58, 'Proekt-metallicheskoj-fermi-18m', 10, 0, '272-13', 'Проект металлической фермы(18м)', '250.00', '0.00', 4294967295, ' https://yadi.sk/d/WEDIn50n4lk9Wg', '<p>Проект металлической фермы(18м)</p>', '<p>Проект металлической фермы(18м)</p>', '272-13_Pr-t_FERMA.jpg', '272-13_Pr-t_FERMA.jpg', 1579085920, 1580888964, '', 'Проект металлической фермы(18м). Купить проектную документацию.', 'проект, металлическая , ферма, косынки, стержни', '<center><h2>Ферма рассчитана с учетом шага установки - 1,5 м</h2></center>', '', 1),
(59, 'Proekt-remonta-i-zameni-setej-vodosnabzheniya', 1, 0, '99-06', 'Проект ремонта и замены сетей водоснабжения', '300.00', '0.00', 4294967295, ' https://yadi.sk/d/W3gjfqLGr9OHMw', '<p>Проект ремонта и замены сетей водоснабжения</p>', '<p>Проект ремонта и замены сетей водоснабжения</p>\r\n<p>3.1. Технические решения.<br />Проектом предусматривается ремонт и замена разводящих аварийных участков <br />водопроводных сетей из стальных труб:<br />&ndash; &Oslash;100мм по ул. К. Маркса от ул. Октябрьская до пер. Щаденко, <br />протяженностью 1230 м; <br />&ndash; &Oslash;100мм по ул. Октябрьская от ул. Калинина до ул. К. Маркса, <br />протяженностью 1200 м; <br />- &Oslash;100мм по ул. Мира, протяженностью 425,0м; <br />&ndash; &Oslash;100мм по ул. Красноармейская от ул. Октябрьская до пер. Щаденко, <br />протяженностью 1065м;<br />&ndash; &Oslash;100мм по ул. Трудовая, от пер. Глухой до пер. Щаденко, <br />протяженностью 400 м; <br />&ndash; &Oslash;100мм по пер. Глухой от ул. Красноармейская до ул. М. Горького 1200 <br />м; <br />&ndash; &Oslash;100мм по ул. Горького от пер. Глухой до пер. Щаденко,<br />протяженностью 900 м; <br />&ndash; &Oslash;100мм по пер. Щаденко от ул. М. Горького до ул. К. Маркса<br />протяженностью 687,5;<br />&ndash; &Oslash;100мм по ул. Некрасова, протяженностью 700 м;</p>\r\n<p>на водопроводные сети из труб ПНД 110Т :<br />&ndash; по ул. К. Маркса протяженностью 935,0м с врезкой с помощью фасонных <br />частей в проектируемых колодцах;<br />&ndash; по ул. Октябрьская протяженностью 1120,0м с врезкой с помощью фасонных <br />частей; <br />&ndash; по ул. Мира протяженностью 425,0м с врезкой с помощью фасонных <br />частей; <br />&ndash; по ул. Красноармейская протяженностью 702,0м с врезкой с помощью <br />фасонных частей; <br />&ndash; по ул. Трудовая протяженностью 403,5м с врезкой с помощью фасонных <br />частей;<br />&ndash; по пер. Глухой протяженностью 476,5м с врезкой с помощью фасонных <br />частей;</p>\r\n<p><br />99-06-ПЗ.3 Лист<br />2</p>\r\n<p>&ndash; по ул. Горького протяженностью 430,5м с врезкой с помощью фасонных <br /><br />частей;<br />&ndash; по пер. Щаденко протяженностью 687,5м с врезкой в строящийся <br />водопровод <br />&Oslash;300 с помощью седелки; <br />&ndash; по ул. Некрасова протяженностью 686,5м с врезкой в водовод &Oslash;500 в <br />начале и<br />в конце трассы с помощью седелки.<br />Категория системы водоснабжения по степени обеспеченности подачи воды <br />и класс ответственности &ndash; I. Качество воды на хоз-питьевые нужды должно <br />соответствовать ГОСТ 2874-82 &laquo;Вода питьевая&raquo;.</p>', '99-06_Pr-t_Rem_Vodosnabzeniye.jpg', '99-06_Pr-t_Rem_Vodosnabzeniye.jpg', 1579101320, 1580812286, '', 'Проект ремонта и замены сетей водоснабжения. Купить проектную документацию.', 'купить, проектная, документация, проект, замена, ремонт, водопровод. сети, водоснабжения', '<center><h2>Проектом предусматривается ремонт и замена разводящих аварийных участков\r\nводопроводных сетей из стальных труб</h2></center>', '', 1),
(60, 'Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi', 3, 0, '249-12', 'Проект капитального ремонта муниципальной автомобильной дороги.', '1500.00', '0.00', 4294967295, 'https://yadi.sk/d/VcaOf4Hxsb7gJA', '<p>Проект капитального ремонта муниципальной автомобильной дороги.</p>', '<p>Проект капитального ремонта муниципальной автомобильной дороги.</p>\r\n<p>1.2. Технические нормативы<br />Согласно заданию на разработку проектной документации и ведомости дефектов и <br />намечаемых работ, утвержденными директором МКУ ЖКХ, при проектировании <br />рассматриваемого участка дороги приняты следующие основные технические <br />параметры:<br />- категория участка дороги &ndash; Магистральная улица &ndash; непрерывного движения;<br />- число полос движения &ndash; 4;<br />- ширина проезжей части &ndash; 4х3,5+4х0,5 м (в бордюрном профиле);<br />- разделительная полоса &ndash; 5,0 &ndash; 8,0м (по существующей ширине);</p>\r\n<p>- наименьшие радиусы вертикальных кривых:<br />выпуклой &ndash; 1500 м;<br />вогнутой - 500 м;<br />- наименьший радиус кривой в плане - 400 <br />м;<br />- дорожная одежда &ndash;асфальтобетон.</p>\r\n<p>&nbsp;</p>', '249-12_Avto_Doroga.jpg', '249-12_Avto_Doroga.jpg', 1579102838, 1580548556, '', 'Проектная документация на капитальный ремонт муниципальной автомобильной дороги. В составе чертежей и пояснительной записки.', 'проект, капитальный, ремонт, автомобильной. дороги. корыто. дорожные одежды', '<h2>основные технические\r\nпараметры:\r\n- категория участка дороги – Магистральная улица – непрерывного движения;\r\n- число полос движения – 4;\r\n- ширина проезжей части – 4х3,5+4х0,5 м (в бордюрном профиле);\r\n- разделительная полоса – 5,0 – 8,0м (по существующей ширине);</h2>', '', 1),
(61, 'Tehnicheskaya-biblioteka', 15, 0, '0-1', 'Техническая библиотека', '1000.00', '0.00', 4294967295, '', '<p>Техническая библиотека</p>\r\n<p>&nbsp;</p>', '<p>Архив образован&nbsp;<img src=\"http://arhiv-proekt.ru/%D0%A4%D0%9E%D0%9D1.jpg\" width=\"47%\" height=\"65%\" align=\"right\" />на протяжении 10 летней деятельности проектной&nbsp;организации. Здесь собран коллективный интеллектуальный потенциал. В архиве представлены проекты на строительство (реконструкцию,&nbsp;капремонт) гражданских, и&nbsp;производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги. В архиве имеются проекты на строительство двухэтажных коттеджей. Также здесь представлены проекты на капитальный ремонт лечебных, дошкольных учреждений и учреждений культуры,<span style=\"font-size: 14pt;\"><strong> а также справочная и нормативная документация, образцы писем и документов общим объемом более 50 Гбайт.&nbsp;</strong></span>&nbsp; Представленные материалы могут быть полезны проектировщикам, строителям и студентам, а также всем заинтересованным лицам.Архивные материалы могут быть использованы в качестве аналогов при разработке проектов на строительство,проектов организации строительства и дипломных проектов. Анатолий Серов, ГИП</p>', '0-1_Teh-Biblioteka.jpg', '0-1_Teh-Biblioteka.jpg', 1579103831, 1580915106, '', 'Техническая библиотека.Здесь представлена справочная и нормативная документация, образцы писем и документов общим объемом более 50 Гбайт. Архивные материалы могут быть использованы в качестве аналогов при разработке проектов.', 'разработка, проекта. канализации. водоснабжения, строительство, водопровод, водоотведение, водоснабжение, архитектура, анти террор, медучреждения', '<center><h2>Представленные материалы могут быть полезны проектировщикам, строителям и студентам, а также всем заинтересованным лицам</h2></center>\r\n', '', 1),
(62, 'Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu', 14, 0, '1-5', 'Услуги архивариуса - поиск каталога по тематическому запросу', '150.00', '0.00', 4294967295, 'Сообщите Ваш тематический запрос на email:  docs_shop@arhiv-proekt.ru', '<p>Услуги архивариуса - поиск каталога по тематическому запросу.</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 327px; top: 32px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '<p><span style=\"font-size: 14pt;\"><strong>Услуги архивариуса - поиск каталога по тематическому запросу(все уровни),как дополнение к оплаченной услуге(просмотр,доступ)&nbsp;</strong></span></p>\r\n<h2><span style=\"font-size: 14pt; color: #0000ff;\">&nbsp; <br /><a href=\"http://www.arhiv-proekt.ru\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов <span style=\"color: red; font-size: large;\"> www.arhiv-proekt.ru</span>;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги. Добро пожаловать в наш магазин проектов!</span></h2>', '', '', 1579113355, 1593443711, '', ' Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.', 'архив, разработка, проектной, проектная документации, строительство, реконструкцию, капремонт, гражданских,  производственных,  объектов, дома,  коттеджи, коттеджа, линейные,  инженерные,  сети, автомобильные, дороги', '<center><h2>Услуги архивариуса - поиск каталога по тематическому запросу.</h2></center>', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_categories`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Июн 29 2020 г., 15:15
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_categories`;
CREATE TABLE `arwm_item_categories` (
  `catid` mediumint(8) UNSIGNED NOT NULL,
  `itemid` int(11) UNSIGNED NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_item_categories`
--

INSERT INTO `arwm_item_categories` (`catid`, `itemid`, `sortid`) VALUES
(8, 1, 0),
(10, 2, 0),
(8, 3, 0),
(8, 4, 0),
(4, 5, 0),
(10, 6, 0),
(14, 30, 0),
(6, 8, 0),
(11, 9, 0),
(7, 10, 0),
(7, 11, 0),
(2, 12, 0),
(2, 13, 0),
(6, 14, 0),
(1, 15, 0),
(10, 16, 0),
(3, 17, 0),
(2, 18, 0),
(1, 19, 0),
(6, 20, 0),
(10, 21, 0),
(8, 22, 0),
(8, 23, 0),
(12, 24, 0),
(4, 25, 0),
(10, 26, 0),
(8, 27, 0),
(10, 28, 0),
(13, 29, 0),
(14, 31, 0),
(14, 32, 0),
(14, 33, 0),
(8, 34, 0),
(2, 35, 0),
(1, 36, 0),
(8, 37, 0),
(7, 38, 0),
(1, 39, 0),
(2, 40, 0),
(1, 41, 0),
(2, 42, 0),
(4, 43, 0),
(10, 44, 0),
(1, 45, 0),
(2, 46, 0),
(2, 47, 0),
(2, 48, 0),
(3, 51, 0),
(13, 50, 0),
(3, 52, 0),
(3, 53, 0),
(3, 54, 0),
(4, 55, 0),
(5, 56, 0),
(10, 58, 0),
(1, 59, 0),
(3, 60, 0),
(15, 61, 0),
(14, 62, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_comments`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Ноя 12 2020 г., 07:05
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_comments`;
CREATE TABLE `arwm_item_comments` (
  `comid` int(11) UNSIGNED NOT NULL,
  `itemid` int(11) UNSIGNED NOT NULL,
  `userid` int(11) UNSIGNED NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `cpdate` int(11) UNSIGNED NOT NULL,
  `scomment` text NOT NULL,
  `ardate` int(11) UNSIGNED NOT NULL,
  `admin_reply` text NOT NULL,
  `visible` tinyint(1) UNSIGNED NOT NULL,
  `sortid` tinyint(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_item_comments`
--

INSERT INTO `arwm_item_comments` (`comid`, `itemid`, `userid`, `sender_email`, `sender_name`, `cpdate`, `scomment`, `ardate`, `admin_reply`, `visible`, `sortid`) VALUES
(1, 8, 0, 'edem@vovlad.ru', 'MscKek', 1579197648, 'Оказываем полный комплекс услуг по таможенной очистке товаров прибывающих из Азии на территорию РФ через морские порты Владивостока и Восточного порта. <br>\n <br>\n-- <br>\nKind regards, <br>\nInternational freight forwarding and customs clearance <br>\nMAESTRO SHIPPING COMPANY <br>\nRussia, 692918, Primorsky Krai, Nakhodka, street. Michurina 11a, floor 3, office 36 <br>\np. 8 800 600-58-54 | e. mtmd2-nhk@msc.com.ru | w. www.msc.com.ru', 0, '', 1, 0),
(2, 62, 0, '808caeed9f9e2424c6c74404cff0df4bprx@ssemarketing.net', 'nzvaaebhmm', 1605164731, 'Muchas gracias. ?Como puedo iniciar sesion?', 0, '', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_comments_new`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Ноя 12 2020 г., 07:05
--

DROP TABLE IF EXISTS `arwm_item_comments_new`;
CREATE TABLE `arwm_item_comments_new` (
  `comid` int(11) UNSIGNED NOT NULL,
  `itemid` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_item_comments_new`
--

INSERT INTO `arwm_item_comments_new` (`comid`, `itemid`) VALUES
(1, 8),
(2, 62);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_options`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_options`;
CREATE TABLE `arwm_item_options` (
  `option_id` int(11) UNSIGNED NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_item_options`
--

INSERT INTO `arwm_item_options` (`option_id`, `option_name`, `sortid`) VALUES
(1, 'Цвет', 0),
(2, 'Размер', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_options_match`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_options_match`;
CREATE TABLE `arwm_item_options_match` (
  `itemid` int(11) UNSIGNED NOT NULL,
  `option_id` int(11) UNSIGNED NOT NULL,
  `option_value_id` int(11) UNSIGNED NOT NULL,
  `price_difference` decimal(15,2) NOT NULL,
  `def` tinyint(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_options_values`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_options_values`;
CREATE TABLE `arwm_item_options_values` (
  `option_value_id` int(11) UNSIGNED NOT NULL,
  `option_id` int(11) UNSIGNED NOT NULL,
  `option_value` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_item_options_values`
--

INSERT INTO `arwm_item_options_values` (`option_value_id`, `option_id`, `option_value`, `sortid`) VALUES
(1, 1, 'Красный', 0),
(2, 1, 'Зелёный', 0),
(3, 1, 'Синий', 0),
(4, 1, 'Жёлтый', 0),
(5, 1, 'Оранжевый', 0),
(6, 1, 'Фиолетовый', 0),
(7, 1, 'Розовый', 0),
(8, 1, 'Серебристый', 0),
(9, 1, 'Белый', 0),
(10, 1, 'Чёрный', 0),
(11, 1, 'Серый', 0),
(12, 1, 'Коричневый', 0),
(13, 1, 'Бежевый', 0),
(14, 2, '38', 0),
(15, 2, '39', 0),
(16, 2, '40', 0),
(17, 2, '41', 0),
(18, 2, '42', 0),
(19, 2, '43', 0),
(20, 2, '44', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_similar`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_similar`;
CREATE TABLE `arwm_item_similar` (
  `itemid` int(11) UNSIGNED NOT NULL,
  `similar_itemid` int(11) UNSIGNED NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_item_special`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_item_special`;
CREATE TABLE `arwm_item_special` (
  `sp_itemid` int(11) UNSIGNED NOT NULL,
  `sp_sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_mainitems`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_mainitems`;
CREATE TABLE `arwm_mainitems` (
  `main_itemid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `main_sortid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_manufacturers`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_manufacturers`;
CREATE TABLE `arwm_manufacturers` (
  `mnf_id` int(11) UNSIGNED NOT NULL,
  `mnfname` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_tags` text NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_manufacturers`
--

INSERT INTO `arwm_manufacturers` (`mnf_id`, `mnfname`, `title`, `description`, `image`, `url`, `meta_title`, `meta_description`, `meta_keywords`, `meta_tags`, `sortid`) VALUES
(0, '', '', 'Warning! This is special line. Do not delete this record with mnf_id = 0!', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_menu`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_menu`;
CREATE TABLE `arwm_menu` (
  `itemid` int(11) UNSIGNED NOT NULL,
  `menuid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `img_width` int(11) NOT NULL,
  `img_height` int(11) NOT NULL,
  `sortid` mediumint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_menu`
--

INSERT INTO `arwm_menu` (`itemid`, `menuid`, `url`, `title`, `img`, `img_width`, `img_height`, `sortid`) VALUES
(1, 1, '{relative_url}', 'Главная', 'hm-home.gif', 0, 0, 0),
(2, 1, '{relative_url}pages.php?view=order', 'Оформить заказ', 'hm-order.gif', 0, 0, 1),
(3, 1, '{about_url}', 'О компании', 'hm-about.gif', 0, 0, 2),
(4, 1, '{contacts_url}', 'Контакты', 'hm-contacts.gif', 0, 0, 3),
(5, 1, '{relative_url}price.php', 'Прайс-лист', 'hm-price.gif', 0, 0, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_news`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_news`;
CREATE TABLE `arwm_news` (
  `newsid` int(11) UNSIGNED NOT NULL,
  `newsname` varchar(255) NOT NULL,
  `date` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `menu_text` text NOT NULL,
  `text` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_tags` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_news`
--

INSERT INTO `arwm_news` (`newsid`, `newsname`, `date`, `title`, `menu_text`, `text`, `meta_title`, `meta_description`, `meta_keywords`, `meta_tags`) VALUES
(1, 'DOCS_SHOP Интернет-магазин Аннотация', '2020-04-07', 'DOCS_SHOP Интернет-магазин. Аннотация', '<h3 class=\"western\" style=\"font-weight: normal;\"><span style=\"font-family: arial black, sans-serif;\"><span style=\"font-size: 10pt;\">Архив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</span></span></h3>\r\n<h3><span style=\"font-family: arial black, sans-serif;\"><span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span><br /></span></h3>', '<h2>&nbsp;</h2>\r\n<h2>&nbsp;</h2>\r\n<h3>В интернет-магазине DOCS_SHOP представлен архив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h3>\r\n<h3>ARHIV-PROEKT.ru</h3>\r\n<h3>Для разработчиков проектной документации, строителей и студентов, а также для всех заинтересованных лиц</h3>\r\n<h4 class=\"western\" style=\"font-weight: normal;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: medium;\">Добро пожаловать на сайт! Архив образован <img src=\"data:image/jpeg;base64,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\" width=\"47%\" height=\"65%\" name=\"Изображение1\" align=\"right\" border=\"0\" /> на протяжении 10 летней деятельности проектной&nbsp;организации. Здесь собран коллективный интеллектуальный потенциал. В архиве представлены проекты на строительство (реконструкцию,&nbsp;капремонт) гражданских, и&nbsp;производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги. В архиве имеются проекты на строительство двухэтажных коттеджей. Также здесь представлены проекты на капитальный ремонт лечебных, дошкольных учреждений и учреждений культуры, а также справочная и нормативная документация, образцы писем и документов общим объемом более 50 Гбайт.&nbsp;&nbsp; Представленные материалы могут быть полезны проектировщикам, строителям и студентам, а также всем заинтересованным лицам.Архивные материалы могут быть использованы в качестве аналогов при разработке проектов на строительство,проектов организации строительства и дипломных проектов. Анатолий Серов, ГИП </span></span></h4>\r\n<h4 class=\"western\">&nbsp;</h4>\r\n<p style=\"margin-bottom: 0cm; line-height: 100%;\">&nbsp;</p>\r\n<h4>&nbsp;</h4>\r\n<h4>&nbsp;</h4>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '', 'В архиве представлены проекты на строительство (реконструкцию, капремонт) гражданских, и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги', 'архив, проект, проектной, документация, строительства, коттедж, ремонт, лечебные, дошкольные, учреждения', '');
INSERT INTO `arwm_news` (`newsid`, `newsname`, `date`, `title`, `menu_text`, `text`, `meta_title`, `meta_description`, `meta_keywords`, `meta_tags`) VALUES
(2, 'Сайт Proektant', '2020-04-08', 'Сайт Proektant', '<pre class=\" language-html\"><code class=\" language-html\"><span class=\"token tag\"><span class=\"token punctuation\">Сайт https://www.proektant.ru<br /><span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span></span></span><span class=\"token tag\"><span class=\"token punctuation\">Работа проектировщикам</span></span></code></pre>\r\n<p>&nbsp;</p>', '<pre class=\" language-html\"><code class=\" language-html\"><span class=\"token tag\"><span class=\"token punctuation\">Сайт </span><span class=\"token attr-value\"> https://www.proektant.ru</span><span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span><br /><!--?a ><span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span><br ?--><!--?a ><span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span><br ?-->Работа проектировщикам<br /></span></code></pre>\r\n<div class=\"allnews_item_content\"><a class=\"main_job_razdel\" title=\"Посмотреть все вакансии для проектировщиков\" href=\"https://www.proektant.ru/job/vacancy.html\">Вакансии</a>\r\n<div class=\"jobs-list\">\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/smetnoe-delo/283310.html\">Постоянная удаленная подработка</a><br /><span class=\"date_region_text\"> 06 апреля </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/gip/283309.html\">Главный технолог (проектирование мостов)</a><br /><span class=\"date_region_text\"> 06 апреля, Москва </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/other/283305.html\">Постоянная удаленная подработка</a><br /><span class=\"date_region_text\"> 04 апреля, Москва </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/other/283298.html\">Поиск инженеров ВК,ОВ,СС,ЭС,ЭМ,НВК,НСС,ТС, конструкторов </a><br /><span class=\"date_region_text\"> 02 апреля, Ростовская область </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/stroitelstvo/283294.html\">Инженер ПОС</a><br /><span class=\"date_region_text\"> 31 марта, Москва </span></div>\r\n</div>\r\n</div>\r\n<pre class=\" language-html\"><code class=\" language-html\"></code></pre>\r\n<div class=\"allnews_item_content\"><a class=\"main_job_razdel\" title=\"Посмотреть все резюме проектировщиков\" href=\"https://www.proektant.ru/job/resume.html\">Резюме</a>\r\n<div class=\"jobs-list\">\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/other/249806.html\">ИП. Выполню проектирование контактной сети троллейбуса, трамвая. Согласования.</a><br /><span class=\"date_region_text\"> Сегодня, Москва </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/stroitelstvo/283312.html\">Инженер-проектировщик</a><br /><span class=\"date_region_text\"> Вчера, Республика Башкортостан </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/vodosnabzhenie-kanalizacija/283060.html\">Инженер проектировщик ВК</a><br /><span class=\"date_region_text\"> 04 апреля, Республика Башкортостан </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/other/283304.html\">Инженер проектировщик пожарной безопасности и ГОЧС</a><br /><span class=\"date_region_text\"> 03 апреля, Московская область </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/elektrosnabzhenie/249740.html\">Разработаю проекты систем электроснабжения,автоматизации,подстанций 10-220 кВ</a><br /><span class=\"date_region_text\"> 02 апреля </span></div>\r\n</div>\r\n</div>\r\n<pre class=\" language-html\"><code class=\" language-html\"></code></pre>\r\n<div class=\"allnews_item_content\"><a class=\"main_job_razdel\" title=\"Проекты для подработки\" href=\"https://www.proektant.ru/job/need-project.html\">Требуется выполнить проекты</a>\r\n<div class=\"jobs-list\">\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/other/283307.html\">Заключение по разделу 10\"Мероприятия по обеспечению доступа инвалидов\"</a><br /><span class=\"date_region_text\"> 05 апреля </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/teplosnabzhenie/283302.html\">Проект котельной на древесных отходах</a><br /><span class=\"date_region_text\"> 03 апреля, Республика Карелия </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/teplosnabzhenie/283300.html\">раздел ОВ (стадия Р) многоквартирный дом</a><br /><span class=\"date_region_text\"> 03 апреля, Республика Карелия </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/tehnologii/283292.html\">Оформление чертежей по СПДС</a><br /><span class=\"date_region_text\"> 02 апреля, Москва </span></div>\r\n<div class=\"job_info\"><a href=\"https://www.proektant.ru/job/tehnologii/283290.html\">Проект скалодрома </a><br /><span class=\"date_region_text\"> 30 марта, Санкт-Петербург </span></div>\r\n</div>\r\n</div>\r\n<pre class=\" language-html\"><code class=\" language-html\"></code></pre>', '', 'Работа проектировщиккам', 'Работа, проектировщикам, котельная, спдс, скалодром', ''),
(3, 'Sajt-inzhenera-proektirovshhika', '2020-04-08', 'Сайт инженера-проектировщика', '<p>Сайт инженера-проектировщика&nbsp;&nbsp; http://saitinpro.ru/<span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span id=\"easybtn_t\" style=\"position: fixed; left: 360px; top: 31px; z-index: 999999999999; font-size: 12px; padding: 0 4px; display: inline-block; cursor: pointer; margin: 0px; color: white; border: 1px solid white; box-shadow: 1px 1px 1px rgba(0,0,0,.3); -moz-box-shadow: 1px 1px 1px rgba(0,0,0,.3); background-color: #167ac6;\">T</span></p>', '<p>Сайт инженера-проектировщика&nbsp;&nbsp; http://saitinpro.ru/</p>\r\n<center>НОВОСТИ ПРОЕКТИРОВАНИЯ</center>\r\n<div id=\"post-24606\" class=\"post-24606 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"contenttitle\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">29.03.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-aprele-2020-goda/\" rel=\"bookmark\">Документы, вступающие в силу в апреле 2020 года&nbsp;</a></span></p>\r\n</div>\r\n<div class=\"post-content\">\r\n<p>СП 451.1325800.2019.&nbsp;Здания общественные с применением деревянных конструкций. Правила проектирования. Утвержден:&nbsp;Министерство строительства и жилищно-коммунального хозяйства Российской Федерации, 22.10.2019. Вводится с:&nbsp;23.04.2020. Свод правил распространяется на проектирование вновь строящихся и реконструируемых общественных зданий высотой до 28 м с применением деревянных конструкций в виде Несущих, самонесущих или ограждающих конструкций и устанавливает требования к объемно-планировочным и конструктивным решениям, материалам, инженерному [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-aprele-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">29.03.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-aprelya-2020-goda/\" rel=\"bookmark\">Документы прекратившие действовать с апреля 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24604\" class=\"post-24604 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>СП 19.13330.2011. Генеральные планы сельскохозяйственных предприятий. Утвержден: Министерство регионального развития Российской Федерации, 27.12.2010. Отменен с: 15.04.2020. Документ распространяется на разработку проектов планировочной организации территории новых, расширяемых и реконструируемых сельскохозяйственных предприятий, а также на разработку схем планировочной организации территорий производственных зон сельских поселений в целях обеспечения требований Градостроительного кодекса Российской Федерации. СП 19.13330.2019. Сельскохозяйственные предприятия. Планировочная [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-aprelya-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">09.03.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-marte-2020-goda/\" rel=\"bookmark\">Документы, вступающие в силу в марте 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24561\" class=\"post-24561 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>СП 444.1326000.2019.&nbsp; Нормы проектирования морских каналов, фарватеров и зон маневрирования. Утвержден:&nbsp;Министерство транспорта Российской Федерации, 30.05.2019. Введен с:&nbsp;01.03.2020. Свод правил устанавливает минимально необходимые требования к процессу проектирования элементов акваторий морских портов и водных подходов к ним (морских каналов, фарватеров, зон маневрирования), в том числе для портов, расположенных на участках рек с морским режимом судоходства. СП 450.1325800.2019&nbsp; [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-marte-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">09.03.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-marta-2020-goda/\" rel=\"bookmark\">Документы прекратившие действовать с марта 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24559\" class=\"post-24559 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>ГОСТ 3808.1-80.&nbsp; Пиломатериалы хвойных пород. Атмосферная сушка и хранение. Утвержден:&nbsp;Государственный комитет СССР по стандартам, 12.03.1980. Отменен с:&nbsp;01.03.2020. Стандарт распространяется на пиломатериалы хвойных пород и устанавливает правила их атмосферной сушки и хранения. ГОСТ 6133-99.&nbsp; Камни бетонные стеновые. Технические условия. Утвержден:&nbsp; Госстрой России, 03.08.2001. Отменен с:&nbsp;01.03.2020. Стандарт распространяется на стеновые бетонные камни, изготовленные вибропрессованием, прессованием, формованием или [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-marta-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">22.02.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/bez-rubriki/dokumenty-vstupayushhie-v-silu-v-fevrale-2020-goda/\" rel=\"bookmark\">Документы, вступающие в силу в феврале 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24521\" class=\"post-24521 post type-post status-publish format-standard has-post-thumbnail hentry category-bez-rubriki\">\r\n<div class=\"post-content\">\r\n<p>ГОСТ Р 2.002-2019.&nbsp; Единая система конструкторской документации. Требования к моделям, макетам и темплетам, применяемым при проектировании Утвержден:&nbsp;Федеральное агентство по техническому регулированию и метрологии, 29.04.2019. Введен с:&nbsp;01.02.2020. Стандарт распространяется на материальные макеты, модели, применяемые в процессе макетного метода проектирования, и на темплеты, применяемые при методе плоскостного макетирования проектных решений. К проектированию с применением темплетов и моделей [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/bez-rubriki/dokumenty-vstupayushhie-v-silu-v-fevrale-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">22.02.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-fevralya-2020-goda/\" rel=\"bookmark\">Документы прекратившие действовать с февраля 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24517\" class=\"post-24517 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>ГОСТ 2.002-72.&nbsp; Единая система конструкторской документации. Требования к моделям, макетам и темплетам, применяемым при проектировании. Утвержден:&nbsp;Государственный комитет стандартов Совета Министров СССР, 30.03.1972. Отменен с:&nbsp;01.02.2020. Стандарт распространяется на макеты, модели, применяемые в процессе макетного метода проектирования, и на темплеты, применяемые при методе плоскостного макетирования проектных решений, и устанавливает основные термины и их определения, масштабы и правила [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-fevralya-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">01.02.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-yanvare-2020-goda/\" rel=\"bookmark\">Документы, вступающие в силу в январе 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24515\" class=\"post-24515 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>ГОСТ 25485-2019.&nbsp; Бетоны ячеистые. Общие технические условия. Утвержден:&nbsp;Федеральное агентство по техническому регулированию и метрологии, 16.07.2019. Введен с:&nbsp;01.01.2020. Стандарт распространяется на ячеистый бетон неавтоклавного твердения (далее &mdash; бетон), предназначенный для изготовления сборных изделий или монолитных конструкций. ГОСТ 27006-2019. Бетоны. Правила подбора состава. Утвержден:&nbsp;Федеральное агентство по техническому регулированию и метрологии, 06.06.2019. Введен с:&nbsp;01.01.2020. Стандарт распространяется на тяжелый [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-yanvare-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">01.02.2020 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-yanvarya-2020-goda/\" rel=\"bookmark\">Документы прекратившие действовать с января 2020 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24513\" class=\"post-24513 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>ГОСТ Р 57335-2016. Блоки бетонные строительные. Технические условия. Утвержден:&nbsp;Федеральное агентство по техническому регулированию и метрологии, 08.12.2016. Отменен с:&nbsp;14.01.2020. Стандарт устанавливает характеристики, технологические нормы и правила на строительные бетонные блоки (далее &mdash; блоки). ГОСТ Р 57336-2016.&nbsp; Растворы строительные штукатурные. Технические условия Утвержден:&nbsp;Федеральное агентство по техническому регулированию и метрологии, 08.12.2016. Отменен с:&nbsp;14.01.2020. Стандарт распространяется на заводские штукатурные [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-yanvarya-2020-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\">10.12.2019 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-dekabre-2019-goda/\" rel=\"bookmark\">Документы, вступающие в силу в декабре 2019 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24485\" class=\"post-24485 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>СП 446.1325800.2019. Инженерно-геологические изыскания для строительства. Общие правила производства работ. Утвержден:&nbsp;Министерство строительства и жилищно-коммунального хозяйства Российской Федерации, 05.06.2019. Вводится с:&nbsp;06.12.2019. Свод правил устанавливает общие правила производства работ, выполняемых в составе инженерно-геологических изысканий для подготовки документов территориального планирования, документации по планировке территории и выбора площадок (трасс) строительства, проектной документации объектов капитального строительства, для строительства и реконструкции [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-vstupayushhie-v-silu-v-dekabre-2019-goda/#respond\">Комментарии</a> </span>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"edit-link\">\r\n<p><span style=\"color: orangered; font-family: Calibri; font-size: small;\"><span id=\"transmark\" style=\"display: none; width: 0px; height: 0px;\"></span>10.12.2019 &nbsp; </span> <span style=\"color: #4682b4; font-family: Calibri; font-size: large;\"><a href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-dekabrya-2019-goda/\" rel=\"bookmark\">Документы прекратившие действовать с декабря 2019 года&nbsp;</a></span></p>\r\n</div>\r\n</div>\r\n<div id=\"post-24483\" class=\"post-24483 post type-post status-publish format-standard has-post-thumbnail hentry category-stroitelnye-novosti\">\r\n<div class=\"post-content\">\r\n<p>ГОСТ 12393-2013. Арматура контактной сети железной дороги линейная. Общие технические условия. Утвержден:&nbsp;Федеральное агентство по техническому регулированию и метрологии, 29.04.2014. Отменен с:&nbsp;01.12.2019. Стандарт распространяется на линейную арматуру контактной сети железной дороги климатического исполнения УХЛ категории размещения I по ГОСТ 15150. Стандарт не распространяется на изделия армирования опор контактной сети (закладные детали, хомуты, фиксаторы, кронштейны и детали [&hellip;]</p>\r\n</div>\r\n<div class=\"contenttitle\"><span style=\"color: orangered; font-family: Calibri; font-size: medium;\"> <a class=\"Комментарии закрыты\" href=\"http://saitinpro.ru/stroitelnye-novosti/dokumenty-prekrativshie-dejstvovat-s-dekabrya-2019-goda/#respond\">Комментарии</a></span></div>\r\n</div>', '', 'документы, проект, проектировщики, инженерно-геологические, изыскания', 'документы, проект, проектировщики, инженерно-геологические, изыскания, строительство, сп', '');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_orderfields`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_orderfields`;
CREATE TABLE `arwm_orderfields` (
  `name` varchar(32) NOT NULL,
  `placeholder` text NOT NULL,
  `contexthelp` text NOT NULL,
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `sortid` tinyint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_orderfields`
--

INSERT INTO `arwm_orderfields` (`name`, `placeholder`, `contexthelp`, `required`, `enabled`, `sortid`) VALUES
('email', '', '', 1, 1, 1),
('last_name', '', '', 0, 1, 2),
('first_name', '', '', 1, 1, 3),
('patronymic', '', '', 0, 1, 4),
('company', '', '', 0, 1, 5),
('country', '', '', 0, 1, 6),
('city', '', '', 0, 1, 7),
('address', '', '', 0, 1, 8),
('zip_code', '', '', 0, 1, 9),
('phone', '', '', 0, 1, 10),
('agreement', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_orders`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Май 09 2020 г., 05:46
--

DROP TABLE IF EXISTS `arwm_orders`;
CREATE TABLE `arwm_orders` (
  `orderid` int(11) UNSIGNED NOT NULL,
  `date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `pmid` mediumint(6) UNSIGNED NOT NULL,
  `paymethod_advname` varchar(32) NOT NULL,
  `paymethod` varchar(255) NOT NULL DEFAULT '0',
  `currency_id` mediumint(6) UNSIGNED NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT '0',
  `currency_brief` varchar(64) NOT NULL,
  `currency_course` varchar(35) NOT NULL,
  `def_currency_id` mediumint(6) UNSIGNED NOT NULL,
  `def_currency` varchar(255) NOT NULL,
  `def_currency_brief` varchar(64) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_percents` varchar(5) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_with_discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_with_discount_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `delivery_cost` decimal(15,2) UNSIGNED NOT NULL,
  `delivery_cost_pc` decimal(15,2) UNSIGNED NOT NULL,
  `final_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `final_total_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dmid` mediumint(6) UNSIGNED NOT NULL,
  `deliverymethod` varchar(255) NOT NULL DEFAULT '0',
  `userid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `country_id` smallint(4) UNSIGNED NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `adm_pub_comment` text NOT NULL,
  `admin_comment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_orders`
--

INSERT INTO `arwm_orders` (`orderid`, `date`, `status`, `pmid`, `paymethod_advname`, `paymethod`, `currency_id`, `currency`, `currency_brief`, `currency_course`, `def_currency_id`, `def_currency`, `def_currency_brief`, `total`, `total_pc`, `discount_percents`, `discount`, `discount_pc`, `total_with_discount`, `total_with_discount_pc`, `delivery_cost`, `delivery_cost_pc`, `final_total`, `final_total_pc`, `dmid`, `deliverymethod`, `userid`, `username`, `first_name`, `last_name`, `patronymic`, `company`, `country_id`, `country`, `city`, `address`, `zip_code`, `phone`, `email`, `comment`, `adm_pub_comment`, `admin_comment`) VALUES
(1, 1577734695, 0, 5, '', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '100.00', '100.00', '0', '0.00', '0.00', '100.00', '100.00', '0.00', '0.00', '100.00', '100.00', 2, 'Доставка курьером', 1, 'Анатолий', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(2, 1577735048, 0, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 1, 'Анатолий', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(3, 1577736232, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 1, 'Анатолий', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(4, 1577736379, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 1, 'Анатолий', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(5, 1577814569, 0, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(6, 1577818318, 0, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(7, 1577861553, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(8, 1577862320, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(9, 1577862435, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(10, 1577862836, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(11, 1577863079, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(12, 1577864000, 0, 5, '', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(13, 1577875116, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '50.00', '50.00', '0', '0.00', '0.00', '50.00', '50.00', '0.00', '0.00', '50.00', '50.00', 2, 'Доставка курьером', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', '', '', ''),
(14, 1578322741, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '300.00', '300.00', '0', '0.00', '0.00', '300.00', '300.00', '0.00', '0.00', '300.00', '300.00', 11, 'Электронная доставка', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', 'Имеются ли чертежи', '', ''),
(15, 1578324849, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '200.00', '200.00', '0', '0.00', '0.00', '200.00', '200.00', '0.00', '0.00', '200.00', '200.00', 11, 'Электронная доставка', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', 'Тестовый платеж', '', ''),
(16, 1578388914, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@gmail.com', 'Тестовый платеж2', '', ''),
(17, 1578390940, 0, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@mail.ru', '', '', ''),
(18, 1578394594, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '40.00', '40.00', '0', '0.00', '0.00', '40.00', '40.00', '0.00', '0.00', '40.00', '40.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', '', '', ''),
(19, 1578394702, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', '', '', ''),
(20, 1578472416, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж', '', ''),
(21, 1578475101, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж.', '', ''),
(22, 1578478285, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', '', '', ''),
(23, 1578557983, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж от 9-01-2020', '', ''),
(24, 1578560155, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж через Webmoney', '', ''),
(25, 1578560406, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж после замены файлов и настройки log ошибок', '', ''),
(26, 1578581661, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж:rn-время: 17:54', '', ''),
(27, 1578583239, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж:rn- файлы возвращены базовые;rn-время 18-20', '', ''),
(28, 1578586809, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '20.00', '20.00', '0', '0.00', '0.00', '20.00', '20.00', '0.00', '0.00', '20.00', '20.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж:rn-метка{quantity_txt} возвращенаrn-время -19-19', '', ''),
(29, 1578651198, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '10.00', '10.00', '0', '0.00', '0.00', '10.00', '10.00', '0.00', '0.00', '10.00', '10.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платежrn-настройки Robokassa POST', '', ''),
(30, 1578652519, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '10.00', '10.00', '0', '0.00', '0.00', '10.00', '10.00', '0.00', '0.00', '10.00', '10.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж после изменения в robokassa на email', '', ''),
(31, 1578654892, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '10.00', '10.00', '0', '0.00', '0.00', '10.00', '10.00', '0.00', '0.00', '10.00', '10.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж после тестовой mail', '', ''),
(32, 1578672221, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '10.00', '10.00', '0', '0.00', '0.00', '10.00', '10.00', '0.00', '0.00', '10.00', '10.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', '', '', ''),
(33, 1578724980, 8, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '10.00', '10.00', '0', '0.00', '0.00', '10.00', '10.00', '0.00', '0.00', '10.00', '10.00', 11, 'Электронная доставка', 2, 'alensav', 'Анатолий', '', '', '', 182, 'Russian Federation', '', 'sav27951@gmail.com', '', '', 'sav27951@mail.ru', 'Тестовый платеж посл изменения настроек Robokassa:rn-время 9-42', '', ''),
(34, 1579171359, 0, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '3000.00', '3000.00', '0', '0.00', '0.00', '3000.00', '3000.00', '0.00', '0.00', '3000.00', '3000.00', 11, 'Электронная доставка', 0, '', 'Q', 'Q', 'Q', 'Q', 182, 'Russian Federation', 'Q', 'Q', 'Q', 'Q', '1@1.ru', 'Тест', '', ''),
(35, 1585234413, 8, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '100.00', '100.00', '0', '0.00', '0.00', '100.00', '100.00', '0.00', '0.00', '100.00', '100.00', 11, 'Электронная доставка', 0, '', 'Анатолий', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@mail.ru', '', '', ''),
(36, 1585306238, 0, 2, 'robokassa', 'Robokassa', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '100.00', '100.00', '0', '0.00', '0.00', '100.00', '100.00', '0.00', '0.00', '100.00', '100.00', 11, 'Электронная доставка', 0, '', 'Alensav', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@yandex.ru', '', '', ''),
(596, 1588662867, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '1000.00', '1000.00', '0', '0.00', '0.00', '1000.00', '1000.00', '0.00', '0.00', '1000.00', '1000.00', 11, 'Электронная доставка', 0, '', 'Anatoliy', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@mail.ru', 'Arhiv', '', ''),
(597, 1588758065, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '1000.00', '1000.00', '0', '0.00', '0.00', '1000.00', '1000.00', '0.00', '0.00', '1000.00', '1000.00', 11, 'Электронная доставка', 0, '', 'Ален', 'Анатолий', '', '', 182, 'Russian Federation', '', 'Проект', '', '', 'sav27951@yandex.ru', '', '', ''),
(598, 1588842817, 0, 5, 'robokassa', 'Банковский перевод', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '250.00', '250.00', '0', '0.00', '0.00', '250.00', '250.00', '0.00', '0.00', '250.00', '250.00', 11, 'Электронная доставка', 0, '', 'Анатоли й', '', '', '', 182, 'Russian Federation', '', '', '', '', 'Sav27951@gmail.com', 'Наш архив', '', ''),
(599, 1588874240, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '1500.00', '1500.00', '0', '0.00', '0.00', '1500.00', '1500.00', '0.00', '0.00', '1500.00', '1500.00', 11, 'Электронная доставка', 0, '', 'Alen', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@hotmail.com', 'Zakaz3', '', ''),
(600, 1588950678, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '3000.00', '3000.00', '0', '0.00', '0.00', '3000.00', '3000.00', '0.00', '0.00', '3000.00', '3000.00', 11, 'Электронная доставка', 0, '', 'Anatoliy', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@mail.ru', 'Rt', '', ''),
(601, 1589003219, 0, 3, 'wm_merchant', 'WebMoney Merchant', 1, 'Российский рубль', 'руб', '1', 1, 'Российский рубль', 'руб', '1500.00', '1500.00', '0', '0.00', '0.00', '1500.00', '1500.00', '0.00', '0.00', '1500.00', '1500.00', 11, 'Электронная доставка', 0, '', 'Alen', '', '', '', 182, 'Russian Federation', '', '', '', '', 'sav27951@hotmail.com', 'Ztd', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_orders_add_fields_values`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_orders_add_fields_values`;
CREATE TABLE `arwm_orders_add_fields_values` (
  `oafvid` int(11) UNSIGNED NOT NULL,
  `orderid` int(11) UNSIGNED NOT NULL,
  `field_name` varchar(64) NOT NULL,
  `field_title` varchar(255) NOT NULL,
  `field_values` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_orders_items`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Май 09 2020 г., 05:46
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_orders_items`;
CREATE TABLE `arwm_orders_items` (
  `oiid` int(11) UNSIGNED NOT NULL,
  `orderid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `itemid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `sku` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `price_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `options` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_orders_items`
--

INSERT INTO `arwm_orders_items` (`oiid`, `orderid`, `itemid`, `sku`, `title`, `price`, `price_pc`, `quantity`, `options`) VALUES
(1, 1, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 2, ''),
(2, 2, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(3, 3, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(4, 4, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(5, 5, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(6, 6, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(7, 7, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(8, 8, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(9, 9, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(10, 10, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(11, 11, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(12, 12, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(13, 13, 1, '113-07', 'Проек капитального ремонта  Больница №5 шх. Южная', '50.00', '50.00', 1, ''),
(14, 14, 20, '90-06', 'Проект деского сада(кап.рем)', '300.00', '300.00', 1, ''),
(15, 15, 10, '174-08', 'Проект дома культуры', '200.00', '200.00', 1, ''),
(16, 16, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(17, 17, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(18, 18, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 2, ''),
(19, 19, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(20, 20, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(21, 21, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(22, 22, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(23, 23, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(24, 24, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(25, 25, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(26, 26, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(27, 27, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(28, 28, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '20.00', '20.00', 1, ''),
(29, 29, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '10.00', '10.00', 1, ''),
(30, 30, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '10.00', '10.00', 1, ''),
(31, 31, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '10.00', '10.00', 1, ''),
(32, 32, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '10.00', '10.00', 1, ''),
(33, 33, 29, '119-07', 'Проект кап рем ФСС (вн. инженерные сети)', '10.00', '10.00', 1, ''),
(34, 34, 31, '1-2', 'Полный доступ ко всему архиву (все уровни) в течении 4-х часов;', '3000.00', '3000.00', 1, ''),
(35, 35, 62, '1-5', 'Услуги архивариуса - поиск каталога по тематическому запросу', '100.00', '100.00', 1, ''),
(36, 36, 62, '1-5', 'Услуги архивариуса - поиск каталога по тематическому запросу', '100.00', '100.00', 1, ''),
(37, 596, 61, '0-1', 'Техническая библиотека', '1000.00', '1000.00', 1, ''),
(38, 597, 61, '0-1', 'Техническая библиотека', '1000.00', '1000.00', 1, ''),
(39, 598, 58, '272-13', 'Проект металлической фермы(18м)', '250.00', '250.00', 1, ''),
(40, 599, 60, '249-12', 'Проект капитального ремонта муниципальной автомобильной дороги.', '1500.00', '1500.00', 1, ''),
(41, 600, 31, '1-2', 'Полный доступ ко всему архиву (все уровни) в течении 4-х часов;', '3000.00', '3000.00', 1, ''),
(42, 601, 54, '248-12', 'Проект муниципальной автомобильной дороги', '1500.00', '1500.00', 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_order_statuses`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_order_statuses`;
CREATE TABLE `arwm_order_statuses` (
  `status_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `auto_change_group` tinyint(1) NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_order_statuses`
--

INSERT INTO `arwm_order_statuses` (`status_id`, `name`, `auto_change_group`, `sortid`) VALUES
(1, 'Не оплачен', 0, 0),
(2, 'Обрабатывается', 0, 0),
(3, 'Оплачен, но не доставлен', 1, 0),
(4, 'Доставлен, но не оплачен', 0, 0),
(5, 'Доставлен и оплачен', 1, 0),
(6, 'Отменён', 0, 0),
(7, 'В процессе доставки', 0, 0),
(8, 'Оплачен', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_payment_blanks`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_payment_blanks`;
CREATE TABLE `arwm_payment_blanks` (
  `blank_id` int(11) UNSIGNED NOT NULL,
  `paymethod_id` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `blank_title` varchar(255) NOT NULL,
  `blank_text` mediumtext NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_paymethods`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_paymethods`;
CREATE TABLE `arwm_paymethods` (
  `pmid` mediumint(6) UNSIGNED NOT NULL,
  `pmtitle` varchar(255) NOT NULL,
  `short_descript` text NOT NULL,
  `long_descript` mediumtext NOT NULL,
  `adv_descript` mediumtext NOT NULL,
  `adv_descript_mail` text NOT NULL,
  `advname` varchar(32) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_paymethods`
--

INSERT INTO `arwm_paymethods` (`pmid`, `pmtitle`, `short_descript`, `long_descript`, `adv_descript`, `adv_descript_mail`, `advname`, `enabled`, `sortid`) VALUES
(1, 'Оплата наличными', '', '', '', '', '', 0, 0),
(2, 'Robokassa', '<p>Оплата через сервис приема платежей Robokassa</p>', '<h4>Оплата через сервис приема платежей Robokassa.</h4>\r\n<p>Много разных способов оплаты: с помощью банковских карт, в любой электронной валюте, с помощью сервисов МТС и Билайн, платежи через интернет-банк, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone.</p>', '', '', 'robokassa', 1, 0),
(3, 'WebMoney Merchant', '<p>Мгновенная онлайн-оплата через платежную систему WebMoney.</p>', '<p>Мгновенная онлайн-оплата через платежную систему WebMoney.</p>', '', '', 'wm_merchant', 1, 0),
(5, 'Банковский перевод', '', '', '', '', 'robokassa', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_paymethods_currencies`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_paymethods_currencies`;
CREATE TABLE `arwm_paymethods_currencies` (
  `pmid` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `currency_id` mediumint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_paymethods_currencies`
--

INSERT INTO `arwm_paymethods_currencies` (`pmid`, `currency_id`) VALUES
(1, 1),
(5, 1),
(3, 6),
(3, 1),
(2, 1),
(2, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_paymethods_deliverymethods`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_paymethods_deliverymethods`;
CREATE TABLE `arwm_paymethods_deliverymethods` (
  `pmid` mediumint(6) UNSIGNED NOT NULL,
  `dmid` mediumint(6) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_paymethods_deliverymethods`
--

INSERT INTO `arwm_paymethods_deliverymethods` (`pmid`, `dmid`) VALUES
(1, 2),
(1, 1),
(3, 11),
(2, 2),
(3, 2),
(3, 1),
(2, 11),
(5, 2),
(5, 11),
(1, 11),
(2, 12),
(3, 12),
(5, 12),
(1, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_pm_data`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_pm_data`;
CREATE TABLE `arwm_pm_data` (
  `mod_name` varchar(32) NOT NULL,
  `orderid` int(11) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_pm_settings`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_pm_settings`;
CREATE TABLE `arwm_pm_settings` (
  `mod_name` varchar(32) NOT NULL,
  `sname` varchar(64) NOT NULL,
  `svalue` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_pm_settings`
--

INSERT INTO `arwm_pm_settings` (`mod_name`, `sname`, `svalue`) VALUES
('robokassa', 'login', 'Proekti_documents'),
('robokassa', 'pass1', 'SPyc4oqYm0TtmK43coOXqX1PaS8='),
('robokassa', 'pass2', 'QYeDjIas/i6d+roXVpKw5i8fQWo='),
('robokassa', 'lang', 'ru'),
('robokassa', 'test_srv', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_settings`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
-- Последняя проверка: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_settings`;
CREATE TABLE `arwm_settings` (
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `setname` varchar(64) NOT NULL,
  `setvalue` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_settings`
--

INSERT INTO `arwm_settings` (`type`, `setname`, `setvalue`) VALUES
(1, 'users_recordsonpage', '20'),
(1, 'orders_recordsonpage', '20'),
(1, 'visitlog_recordsonpage', '300'),
(1, 'set_img_chmod', '1'),
(1, 'img_chmod', '0644'),
(1, 'set_rfiles_chmod', '1'),
(1, 'rfiles_chmod', '0644'),
(1, 'gen_smimg_width', '288'),
(1, 'gen_smimg_width_gal', '288'),
(1, 'notify_ch_status', '1'),
(1, 'wysiwyg', 'tinymce'),
(1, 'stat_ordersonpage', '100'),
(1, 'pre_delete_img', '1'),
(1, 'simg_smoothing', '0'),
(1, 'qpnewpcom', '10'),
(1, 'sess_ip', '0'),
(1, 'csv_export_charset', 'windows-1251'),
(1, 'csv_import_charset', 'windows-1251'),
(1, 'chpu_auto_translit', '1'),
(2, 'url', 'https://docs-proekt.shop/'),
(2, 'design', 'neutral'),
(2, 'quantity_columns', '3'),
(2, 'pages_title', 'Интернет-магазин'),
(2, 'products_onpage', '20'),
(2, 'static_urls', '1'),
(2, 'counter', '1'),
(2, 'visitlog', '1'),
(2, 'time_diff', '0'),
(2, 'def_currency', '1'),
(2, 'curr_brief', 'руб'),
(2, 'lang', 'rus'),
(2, 'def_country', '182'),
(2, 'new_products_type', ''),
(2, 'index_file', ''),
(2, 'order_without_register', '1'),
(2, 'email', 'docs_shop@arhiv-proekt.ru'),
(2, 'q_new_products', '8'),
(2, 'search_type', '2'),
(2, 'shop_name', 'DOCS_SHOP  -  Интернет-магазин проектов'),
(2, 'sSiteName', 'Интернет-магазин'),
(2, 'smallimg_width', ''),
(2, 'q_new_news', '10'),
(2, 'mail_order_admin', '1'),
(2, 'mail_order_shopper', '1'),
(2, 'order_subject', 'Ваш заказ в интернет-магазине'),
(2, 'max_contentmenuitems', '50'),
(2, 'import_format', '84134864072F6256778B755AB747EBDC'),
(2, 'export_format', '18EB7CAA712F4CFE7E4C370B788C90CB'),
(2, 'gallery_q_columns', '2'),
(2, 'gal_smimg_width', ''),
(2, 'antibot_register', '0'),
(2, 'antibot_order', '0'),
(2, 'antibot_feedback', '0'),
(2, 'show_quantity', '1'),
(2, 'use_smtp', '0'),
(2, 'submenu_level', '5'),
(2, 'sortpr_desc', '1'),
(2, 'sort_products', 'id'),
(2, 'item_title_cat', '1'),
(2, 'index_text', 'YWU1OGI2Njg='),
(2, 'email2', 'sav27951@gmail.com'),
(2, 'pr_cnt_reduction', '0'),
(2, 'admin_order_subj', 'Новый заказ {order_number} в интернет-магазине'),
(2, 'shop_sender_only', '1'),
(2, 'pd_big_img', '0'),
(2, 'bigimg_width', ''),
(2, 'mnf_sort_products', 'price'),
(2, 'mnf_sortpr_desc', '0'),
(2, 'not_show_auth_links', '0'),
(2, 'maincat_qcolumns', '0'),
(2, 'main_maxsubcats', '5'),
(2, 'q_mmnf', '500'),
(2, 'mnu_smimg_width', ''),
(2, 'imgin_newpr', '1'),
(2, 'imgin_special', '1'),
(2, 'q_mcat', '500'),
(2, 'on_mcart', '1'),
(2, 'paid_order_status', '8'),
(2, 'sort_onlycatmnf', '1'),
(2, 'similar', '1'),
(2, 'show_quantity_main', '1'),
(2, 'on_pcomm', '1'),
(2, 'reg_def_group', '1'),
(2, 'sbcpr', '0'),
(2, 'lptype', '0'),
(2, 'lctype', '0'),
(2, 'vcatname', 'catalog/'),
(2, 'cache', '0'),
(2, 'autopay_status_only', '-1'),
(2, 's_mVertAdv', 'no'),
(2, 'mail_delay', '0.4'),
(2, 'prLstNoMain', 'nSDescr'),
(2, 'prLstNoCat', 'nSDescr'),
(2, 'prLstNoMnf', 'nSDescr'),
(2, 'prLstNoSrch', 'nSDescr'),
(2, 'def_show_currency', '0'),
(2, 's_mMnf', ''),
(2, 's_mCat', ''),
(2, 'mnu_onlycatmnf', '0'),
(2, 's_mNewProd', ''),
(2, 's_mContent', ''),
(2, 's_mNews', ''),
(2, 's_mSpecOff', ''),
(2, 's_mLoginFrm', ''),
(2, 'cart_add', '0'),
(2, 'nmtext_om', '0'),
(2, 'currency_selection', '1'),
(2, 'show_all_lnk', '1'),
(2, 'logo_image_neutral', '/design/neutral/img/logo.png'),
(4, 'host', 'localhost'),
(4, 'port', '25'),
(4, 'helo', 'localhost'),
(4, 'auth', '0'),
(4, 'user', ''),
(4, 'pass', ''),
(4, 'timeout', '20'),
(6, 'email_req', '0'),
(6, 'pubreg_only', '0'),
(6, 'add_comm', 'all'),
(6, 'name_req', '0'),
(6, 'productonpg', '0'),
(6, 'qpcomm', '40'),
(6, 'reverse_sort', '0'),
(6, 'pub_email', '0'),
(6, 'name_empty', 'Гость'),
(6, 'admin_name', 'Администратор'),
(6, 'com_minlen', '0'),
(6, 'com_maxlen', '32767'),
(6, 'cut_com', '1'),
(6, 'premoderate', '0'),
(6, 'notifi_admin', '1'),
(6, 'antibot', '0'),
(7, 'period', '4320'),
(7, 'nocacheAdmin', '0'),
(7, 'nocacheModules', ''),
(2, 'sm_config', '4D5455334E7A63774E7A63334E413D3D'),
(2, 'db_version', '3.3'),
(2, 'nonames_mailheaders', '0'),
(2, 'sort_nostock_last', '0'),
(2, 'no_price_fraction', '0'),
(2, 'null_price_text', ''),
(2, 'pub_group_discounts', '0'),
(2, 'pub_all_discounts', '0'),
(2, 'cart_add_q0', '0'),
(2, 'nocart_add_price0', '0'),
(2, 'header_text', 'DOCS_SHOP - Интернет-магазин проектов'),
(2, 'footer_text', 'АРХИВ ПРОЕКТОВ  www.arhiv-proekt.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_txtsettings`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_txtsettings`;
CREATE TABLE `arwm_txtsettings` (
  `setname` varchar(32) NOT NULL,
  `setvalue` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_txtsettings`
--

INSERT INTO `arwm_txtsettings` (`setname`, `setvalue`) VALUES
('agreement', ''),
('yml_items', ''),
('pr_comm_stop_words', ''),
('reg_allow_groups', '');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_users`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Авг 12 2020 г., 11:58
--

DROP TABLE IF EXISTS `arwm_users`;
CREATE TABLE `arwm_users` (
  `userid` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `pwd` char(32) NOT NULL,
  `groupid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `regdate` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `country` smallint(4) NOT NULL DEFAULT '0',
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_users`
--

INSERT INTO `arwm_users` (`userid`, `username`, `pwd`, `groupid`, `email`, `regdate`, `first_name`, `last_name`, `patronymic`, `company`, `country`, `city`, `address`, `zip_code`, `phone`) VALUES
(1, 'Анатолий', 'cc816145fa84b4b6e02cff0df2026914', 1, 'sav27951@gmail.com', 1577711784, 'Анатолий', '', '', '', 182, '', '', '', ''),
(2, 'alensav', 'dab610ca8efa3d7391c69cdb5c36e88f', 1, 'sav27951@mail.ru', 1578070223, 'Анатолий', '', '', '', 182, '', 'sav27951@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_users_groups`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_users_groups`;
CREATE TABLE `arwm_users_groups` (
  `groupid` mediumint(5) UNSIGNED NOT NULL,
  `groupname` varchar(64) NOT NULL,
  `min_order_sum` decimal(15,2) NOT NULL,
  `descript` text NOT NULL,
  `autochgroup` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autochgroup_sum` decimal(15,2) NOT NULL DEFAULT '9999999999999.99',
  `sortid` mediumint(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_users_groups`
--

INSERT INTO `arwm_users_groups` (`groupid`, `groupname`, `min_order_sum`, `descript`, `autochgroup`, `autochgroup_sum`, `sortid`) VALUES
(1, 'Покупатели', '0.00', 'В данную группу входят все пользователи, которые не состоят в других группах, а также не зарегистрированные покупатели.', 0, '9999999999999.99', 0),
(2, 'Постоянные покупатели', '0.00', '', 0, '9999999999999.99', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_users_groups_discounts`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_users_groups_discounts`;
CREATE TABLE `arwm_users_groups_discounts` (
  `did` int(11) UNSIGNED NOT NULL,
  `groupid` mediumint(5) UNSIGNED NOT NULL,
  `order_sum` decimal(15,2) NOT NULL,
  `discount` char(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_visitlog`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Дек 15 2020 г., 16:30
--

DROP TABLE IF EXISTS `arwm_visitlog`;
CREATE TABLE `arwm_visitlog` (
  `date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `forwarded` varchar(255) NOT NULL,
  `request` varchar(255) NOT NULL,
  `referer` varchar(4096) NOT NULL,
  `useragent` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_visitlog`
--

INSERT INTO `arwm_visitlog` (`date`, `ip`, `forwarded`, `request`, `referer`, `useragent`) VALUES
(1605550288, '54.191.234.149', '54.191.234.149, 54.191.234.149', 'docs-proekt.shop/', '', ''),
(1605559878, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605733090, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/cart.php', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605724456, '207.46.13.71', '207.46.13.71, 207.46.13.71', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605722186, '13.66.139.146', '13.66.139.146, 13.66.139.146', 'www.docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605709668, '89.187.168.175', '89.187.168.175, 89.187.168.175', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.64'),
(1605709669, '89.187.168.175', '89.187.168.175, 89.187.168.175', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.64'),
(1605706940, '158.222.11.26', '158.222.11.26, 158.222.11.26', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605706941, '158.222.11.26', '158.222.11.26, 158.222.11.26', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605708239, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605709668, '89.187.168.175', '89.187.168.175, 89.187.168.175', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.64'),
(1605706317, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605693543, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1605696111, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605703262, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605688354, '35.203.251.48', '35.203.251.48, 35.203.251.48', 'docs-proekt.shop/', '', 'node-fetch/1.0 (+https://github.com/bitinn/node-fetch)'),
(1605680012, '84.17.47.17', '84.17.47.17, 84.17.47.17', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36'),
(1605680012, '84.17.47.17', '84.17.47.17, 84.17.47.17', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36'),
(1605680011, '84.17.47.17', '84.17.47.17, 84.17.47.17', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36'),
(1605662161, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/magazin/buy/12/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605662939, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilno-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605672324, '66.249.64.164', '66.249.64.164, 66.249.64.164', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605658682, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605658685, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605662156, '5.255.253.106', '5.255.253.106, 5.255.253.106', 'docs-proekt.shop/magazin/buy/12/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605650606, '207.46.13.225', '207.46.13.225, 207.46.13.225', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-dom-kulturi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605646527, '5.62.62.54', '5.62.62.54, 5.62.62.54', 'docs-proekt.shop//content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605646527, '5.62.62.54', '5.62.62.54, 5.62.62.54', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop//content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605637662, '178.175.130.254', '178.175.130.254, 178.175.130.254', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.99'),
(1605637662, '178.175.130.254', '178.175.130.254, 178.175.130.254', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.99'),
(1605637662, '178.175.130.254', '178.175.130.254, 178.175.130.254', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.99'),
(1605635481, '66.249.66.200', '66.249.66.200, 66.249.66.200', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605634996, '5.45.207.174', '5.45.207.174, 5.45.207.174', 'docs-proekt.shop/account/advertise/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605634991, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/account/advertise/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605633698, '78.129.221.11', '78.129.221.11, 78.129.221.11', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1605633699, '78.129.221.11', '78.129.221.11, 78.129.221.11', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36'),
(1605633833, '62.210.82.133', '62.210.82.133, 62.210.82.133', 'www.docs-proekt.shop/wp-json/wp/v2/users/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1605633698, '78.129.221.11', '78.129.221.11, 78.129.221.11', 'docs-proekt.shop/magento_version/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1605629178, '103.139.32.69', '103.139.32.69, 103.139.32.69', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(1605629259, '13.66.139.146', '13.66.139.146, 13.66.139.146', 'www.docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605633698, '78.129.221.11', '78.129.221.11, 78.129.221.11', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1605633698, '78.129.221.11', '78.129.221.11, 78.129.221.11', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1605624110, '13.66.139.146', '13.66.139.146, 13.66.139.146', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605619298, '62.210.82.133', '62.210.82.133, 62.210.82.133', 'docs-proekt.shop/wp-json/wp/v2/users/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1605612204, '103.139.32.69', '103.139.32.69, 103.139.32.69', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50'),
(1605613373, '13.66.139.146', '13.66.139.146, 13.66.139.146', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605615405, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1605616613, '62.210.82.133', '62.210.82.133, 62.210.82.133', 'www.docs-proekt.shop/wp-json/wp/v2/users/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1605604098, '62.210.82.133', '62.210.82.133, 62.210.82.133', 'docs-proekt.shop/wp-json/wp/v2/users/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1605612196, '103.139.32.69', '103.139.32.69, 103.139.32.69', 'docs-proekt.shop/', '', 'python-requests/2.24.0'),
(1605587909, '109.235.163.153', '109.235.163.153, 109.235.163.153', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 YaBrowser/18.6.1.772 Yowser/2.5 Safari/537.36'),
(1605598450, '66.249.66.157', '66.249.66.157, 66.249.66.157', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605560237, '213.180.203.76', '213.180.203.76, 213.180.203.76', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605560237, '5.45.207.177', '5.45.207.177, 5.45.207.177', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605569847, '37.9.118.24', '37.9.118.24, 37.9.118.24', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1605560116, '84.17.61.144', '84.17.61.144, 84.17.61.144', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36'),
(1605560116, '84.17.61.144', '84.17.61.144, 84.17.61.144', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36'),
(1605560117, '84.17.61.144', '84.17.61.144, 84.17.61.144', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36'),
(1605560237, '5.255.253.186', '5.255.253.186, 5.255.253.186', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605560233, '5.255.231.95', '5.255.231.95, 5.255.231.95', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605559880, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605545634, '138.197.194.27', '138.197.194.27, 138.197.194.27', 'www.docs-proekt.shop///?author=1', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1605545634, '138.197.194.27', '138.197.194.27, 138.197.194.27', 'www.docs-proekt.shop///wp-json/wp/v2/users/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1605474214, '217.182.15.150', '217.182.15.150, 217.182.15.150', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(1605475117, '66.249.64.163', '66.249.64.163, 66.249.64.163', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapremrnta-gorbolnitsi-inzh-seti.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605480532, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/new.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605480533, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/new.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605495988, '62.210.92.175', '62.210.92.175, 62.210.92.175', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0'),
(1605498841, '37.146.113.50', '37.146.113.50, 37.146.113.50', 'docs-proekt.shop/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36 OPR/72.0.3815.186'),
(1605503329, '5.255.231.126', '5.255.231.126, 5.255.231.126', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605503357, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-ko-vsemu-arhivu-vse-urovni-3000-rub-za-odni-sutki.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605507752, '1.20.184.238', '1.20.184.238, 1.20.184.238', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36'),
(1605507980, '1.20.184.238', '1.20.184.238, 1.20.184.238', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36'),
(1605511095, '34.235.233.220', '34.235.233.220, 34.235.233.220', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36'),
(1605511542, '66.249.64.164', '66.249.64.164, 66.249.64.164', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605513009, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1607329535, '37.204.254.39', '37.204.254.39, 37.204.254.39', 'docs-proekt.shop/content/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 Edg/86.0.622.63'),
(1607339455, '40.77.167.27', '40.77.167.27, 40.77.167.27', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-i-pererabotki-porodnogo-otvala.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607342002, '212.83.146.233', '212.83.146.233, 212.83.146.233', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0'),
(1607342751, '62.4.14.206', '62.4.14.206, 62.4.14.206', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0'),
(1607342856, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342860, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342862, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342863, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342864, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342865, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/cart.php', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342866, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342867, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342868, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342869, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/content/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342870, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/news/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607342871, '51.222.43.142', '51.222.43.142, 51.222.43.142', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-G925F Build/LMY47X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.94 Mobile Safari/537.36'),
(1607343128, '51.91.61.117', '51.91.61.117, 51.91.61.117', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Dataprovider.com)'),
(1607343189, '62.4.14.198', '62.4.14.198, 62.4.14.198', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0'),
(1607343985, '178.175.130.243', '178.175.130.243, 178.175.130.243', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(1607343985, '178.175.130.243', '178.175.130.243, 178.175.130.243', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(1607343986, '178.175.130.243', '178.175.130.243, 178.175.130.243', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(1607344250, '62.4.14.198', '62.4.14.198, 62.4.14.198', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0'),
(1607347083, '157.55.39.152', '157.55.39.152, 157.55.39.152', 'www.docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607351744, '157.55.39.93', '157.55.39.93, 157.55.39.93', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-k-katalogu-1-j-uroven-i-nizhe.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607357546, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607357546, '213.180.203.115', '213.180.203.115, 213.180.203.115', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607357546, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607365876, '106.52.240.60', '106.52.240.60, 106.52.240.60', 'docs-proekt.shop/', '', 'Go-http-client/1.1'),
(1607365878, '106.52.240.60', '106.52.240.60, 106.52.240.60', 'www.docs-proekt.shop/', '', 'Go-http-client/1.1'),
(1607369667, '157.55.39.253', '157.55.39.253, 157.55.39.253', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607370950, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607377271, '5.255.231.207', '5.255.231.207, 5.255.231.207', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607380246, '40.77.167.11', '40.77.167.11, 40.77.167.11', 'www.docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607387026, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607410422, '5.255.231.71', '5.255.231.71, 5.255.231.71', 'docs-proekt.shop/magazin/show/17/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607422503, '5.255.253.90', '5.255.253.90, 5.255.253.90', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607507953, '209.17.97.106', '209.17.97.106, 209.17.97.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1607760889, '209.17.97.2', '209.17.97.2, 209.17.97.2', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1607765925, '209.17.96.178', '209.17.96.178, 209.17.96.178', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1607878146, '209.17.96.82', '209.17.96.82, 209.17.96.82', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1608049818, '209.17.96.66', '209.17.96.66, 209.17.96.66', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1607257591, '54.221.27.173', '54.221.27.173, 54.221.27.173', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1607261937, '207.46.13.163', '207.46.13.163, 207.46.13.163', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607265991, '107.178.237.15', '107.178.237.15, 107.178.237.15', 'docs-proekt.shop/', '', 'node-fetch/1.0 (+https://github.com/bitinn/node-fetch)'),
(1607267000, '188.166.242.78', '188.166.242.78, 188.166.242.78', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(1607270920, '5.62.56.50', '5.62.56.50, 5.62.56.50', 'docs-proekt.shop//content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1607270921, '5.62.56.50', '5.62.56.50, 5.62.56.50', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop//content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1607279871, '64.227.2.2', '64.227.2.2, 64.227.2.2', 'docs-proekt.shop///?author=1', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1607279871, '64.227.2.2', '64.227.2.2, 64.227.2.2', 'docs-proekt.shop///wp-json/wp/v2/users/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1607285120, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607292566, '95.163.255.203', '95.163.255.203, 95.163.255.203', 'docs-proekt.shop/catalog/Biblioteka-spravochnoj-i-normativnoj-dokumentatsii/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1607297267, '66.249.64.163', '66.249.64.163, 66.249.64.163', 'docs-proekt.shop/news/%D0%A1%D0%B0%D0%B9%D1%82%20Proektant.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1607300472, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607304698, '116.202.112.215', '116.202.112.215, 116.202.112.215', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/79.0.3945.0 Safari/537.36'),
(1607311582, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607317317, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607319441, '206.81.12.65', '206.81.12.65, 206.81.12.65', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36'),
(1607319450, '206.81.12.65', '206.81.12.65, 206.81.12.65', 'docs-proekt.shop/cart.php', 'http://docs-proekt.shop', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36'),
(1607322105, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1607231412, '95.142.112.20', '95.142.112.20, 95.142.112.20', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop//content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1607233192, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607235349, '89.163.242.241', '89.163.242.241, 89.163.242.241', 'docs-proekt.shop/', '', 'Dy robot 1.0'),
(1607241961, '77.222.115.97', '77.222.115.97, 77.222.115.97', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.24 Safari/537.36'),
(1607231411, '95.142.112.20', '95.142.112.20, 95.142.112.20', 'docs-proekt.shop//content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1607243244, '176.9.169.59', '176.9.169.59, 176.9.169.59', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0'),
(1607244754, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607241962, '77.222.115.97', '77.222.115.97, 77.222.115.97', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.24 Safari/537.36'),
(1607241961, '77.222.115.97', '77.222.115.97, 77.222.115.97', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.24 Safari/537.36'),
(1607227081, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607212333, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/content/about.html', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607223608, '66.249.64.167', '66.249.64.167, 66.249.64.167', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1607223629, '66.249.64.160', '66.249.64.160, 66.249.64.160', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1607197300, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607212293, '5.255.231.126', '5.255.231.126, 5.255.231.126', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607212293, '5.45.207.106', '5.45.207.106, 5.45.207.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607212294, '5.255.253.97', '5.255.253.97, 5.255.253.97', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607212294, '213.180.203.30', '213.180.203.30, 213.180.203.30', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607212324, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607212325, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607212332, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/cart.php', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607212333, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/pages.php?view=order', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607196231, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607194137, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607194823, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607195832, '54.166.207.15', '54.166.207.15, 54.166.207.15', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'),
(1607161206, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607179976, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/price.php', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607182807, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607184965, '157.55.39.134', '157.55.39.134, 157.55.39.134', 'www.docs-proekt.shop/content/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607189115, '157.55.39.93', '157.55.39.93, 157.55.39.93', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-dom-kulturi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607090471, '5.255.253.123', '5.255.253.123, 5.255.253.123', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607090471, '5.255.253.107', '5.255.253.107, 5.255.253.107', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607090471, '5.45.207.108', '5.45.207.108, 5.45.207.108', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607090473, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607093654, '95.163.255.123', '95.163.255.123, 95.163.255.123', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1607099782, '95.163.255.199', '95.163.255.199, 95.163.255.199', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskij-sad.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1607105135, '35.225.63.153', '35.225.63.153, 35.225.63.153', 'docs-proekt.shop/', '', 'python-requests/2.25.0'),
(1607108124, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-remonta-i-zameni-setej-vodosnabzheniya.html', 'https://docs-proekt.shop/news/DOCS_SHOP%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%20%D0%90%D0%BD%D0%BD%D0%BE%D1%82%D0%B0%D1%86%D0%B8%D1%8F.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Mobile/15E148 Safari/604.1'),
(1607109746, '209.17.96.66', '209.17.96.66, 209.17.96.66', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1607132880, '13.66.139.107', '13.66.139.107, 13.66.139.107', 'www.docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-kap-rem-FSS-vn-inzhenernie-seti.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607133987, '89.187.168.182', '89.187.168.182, 89.187.168.182', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.99'),
(1607133987, '89.187.168.182', '89.187.168.182, 89.187.168.182', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.99'),
(1607133987, '89.187.168.182', '89.187.168.182, 89.187.168.182', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.99'),
(1607136464, '207.46.13.201', '207.46.13.201, 207.46.13.201', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607138585, '95.163.255.231', '95.163.255.231, 95.163.255.231', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1607138966, '156.146.63.114', '156.146.63.114, 156.146.63.114', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1607138966, '156.146.63.114', '156.146.63.114, 156.146.63.114', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1607142725, '95.108.129.200', '95.108.129.200, 95.108.129.200', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1607155566, '95.163.255.123', '95.163.255.123, 95.163.255.123', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1607142399, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607138966, '156.146.63.114', '156.146.63.114, 156.146.63.114', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1607085768, '157.55.39.128', '157.55.39.128, 157.55.39.128', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607087921, '207.46.13.107', '207.46.13.107, 207.46.13.107', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607072348, '5.45.207.106', '5.45.207.106, 5.45.207.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607074517, '175.44.42.229', '175.44.42.229, 175.44.42.229', 'docs-proekt.shop/', 'http://gdvgz.tpgx.net/blog/84814925/view/', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0'),
(1607075034, '40.77.167.28', '40.77.167.28, 40.77.167.28', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607081890, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'www.docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnog-remonta-travmatologii.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1607071273, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'docs-proekt.shop/content/about.html', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607063080, '107.170.2.161', '107.170.2.161, 107.170.2.161', 'docs-proekt.shop///wp-json/wp/v2/users/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1607071241, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'docs-proekt.shop/', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607071250, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'docs-proekt.shop/', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607071258, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'docs-proekt.shop/cart.php', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607071265, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'docs-proekt.shop/pages.php?view=order', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1607063079, '107.170.2.161', '107.170.2.161, 107.170.2.161', 'docs-proekt.shop///?author=1', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1607061521, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/news/DOCS_SHOP%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%20%D0%90%D0%BD%D0%BD%D0%BE%D1%82%D0%B0%D1%86%D0%B8%D1%8F.html', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607061509, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', 'https://docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607061552, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-remonta-i-zameni-setej-vodosnabzheniya.html', 'https://docs-proekt.shop/news/DOCS_SHOP%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%20%D0%90%D0%BD%D0%BD%D0%BE%D1%82%D0%B0%D1%86%D0%B8%D1%8F.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607061499, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/news/%D0%A1%D0%B0%D0%B9%D1%82%20Proektant.html', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060471, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', 'https://docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060434, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha.html', 'https://docs-proekt.shop/search.php?srchtext=%D0%94%D0%BE%D0%BC', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060565, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-mnogokvartirnogo-zhilogo-doma-dostrojka.html', 'https://docs-proekt.shop/catalog/Proekti-zhilih-domov/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060561, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/', 'https://docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060396, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', 'https://docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060419, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', 'http://www.arhiv-proekt.ru/SAV22-1_12index.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060428, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/search.php?srchtext=%D0%94%D0%BE%D0%BC', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060242, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060251, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060351, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu.html', 'https://docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607060367, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', 'https://docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1607050551, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607048860, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607044189, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607041592, '5.45.207.174', '5.45.207.174, 5.45.207.174', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1607040870, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607040875, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/sort.php?view=price&sort=title&independ=1', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607040671, '77.35.62.96', '77.35.62.96, 77.35.62.96', 'www.docs-proekt.shop/pages.php', 'http://www.docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4093.3 Safari/537.36'),
(1607040670, '77.35.62.96', '77.35.62.96, 77.35.62.96', 'www.docs-proekt.shop/', 'http://www.docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4093.3 Safari/537.36'),
(1607040670, '77.35.62.96', '77.35.62.96, 77.35.62.96', 'www.docs-proekt.shop/content/contacts.html', 'http://www.docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4093.3 Safari/537.36'),
(1607040630, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-ko-vsemu-arhivu-vse-urovni-3000-rub-za-odni-sutki.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607040403, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607040239, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapremrnta-gorbolnitsi-inzh-seti.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039955, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-zubotehnicheskoj-laboratorii.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039940, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/sort.php?view=price&sort=sku&independ=1', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039757, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kap-remonta-tubdispansera.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)');
INSERT INTO `arwm_visitlog` (`date`, `ip`, `forwarded`, `request`, `referer`, `useragent`) VALUES
(1607039617, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-rastvorobetonnogo-uzla.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039603, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039531, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039356, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/pages.php?view=register&lastpage=', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039200, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/design/neutral/trident/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607039093, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-doma-kulturi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607038926, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/pages.php', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607038636, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-Kirpichnij-zavod-ekonstruktsiya-i-pileudalenie.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607038325, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/sort.php?view=price&sort=quantity&independ=1', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607037899, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-mnogokvartirnogo-zhilogo-doma-dostrojka.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607038056, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtozapravochnoj-stantsii-AZS.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607038220, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/pages.php?view=forgot_password', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607035961, '13.66.139.107', '13.66.139.107, 13.66.139.107', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607035995, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskogo-sada.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607037775, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-dom-kulturi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607035926, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607037476, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-k-katalogu-1-j-uroven-i-nizhe.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607037473, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskij-sad.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607036829, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnogo-remonta-uchastkovoj-bolnitsi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607036356, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-nevrologicheskogo-otdeleniya-rekonstr-rodilnogo.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607036329, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607036053, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-otvala-aspiratsiya.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607035939, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607035800, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607035076, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032804, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607034877, '34.209.232.209', '34.209.232.209, 34.209.232.209', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-kap-rem-FSS-vn-inzhenernie-seti.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032783, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032469, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032762, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/content/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032508, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/news/Sajt-inzhenera-proektirovshhika.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031947, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilno-dorogi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032010, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032061, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032063, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/cart.php', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032215, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607032425, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031796, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/price.php', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031823, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031854, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031860, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031430, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031450, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607031480, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/pages.php', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031554, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031634, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031645, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/news/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031691, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031699, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/pages.php?view=register', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031291, '34.222.170.133', '34.222.170.133, 34.222.170.133', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031312, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031347, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/pages.php?view=order', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031404, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/pages.php?view=login', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031105, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031107, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031205, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607030656, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607030993, '54.189.63.32', '54.189.63.32, 54.189.63.32', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031052, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/search.php', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607031079, '18.237.149.42', '18.237.149.42, 18.237.149.42', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', '', 'Mozilla/5.0 ((Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36)'),
(1607008295, '3.94.21.209', '3.94.21.209, 3.94.21.209', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-kanalizatsionnogo-kollektora.html', '', 'CCBot/2.0 (https://commoncrawl.org/faq/)'),
(1607015406, '174.127.135.130', '174.127.135.130, 174.127.135.130', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20120427 Firefox/15.0a1'),
(1607015407, '174.127.135.130', '174.127.135.130, 174.127.135.130', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20120427 Firefox/15.0a1'),
(1607016488, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1607016591, '95.163.255.212', '95.163.255.212, 95.163.255.212', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskij-sad.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1607022903, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607030526, '51.15.184.118', '51.15.184.118, 51.15.184.118', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1607007933, '3.94.21.209', '3.94.21.209, 3.94.21.209', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'CCBot/2.0 (https://commoncrawl.org/faq/)'),
(1607003617, '13.66.139.152', '13.66.139.152, 13.66.139.152', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1607005577, '3.94.21.209', '3.94.21.209, 3.94.21.209', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-rekonstruktsii-obektov-kanalizatsionnih-setej-korrektirovka.html', '', 'CCBot/2.0 (https://commoncrawl.org/faq/)'),
(1607005661, '3.94.21.209', '3.94.21.209, 3.94.21.209', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-kanalizatsionnoj-nasosnoj-stantsii.html', '', 'CCBot/2.0 (https://commoncrawl.org/faq/)'),
(1607001178, '34.229.18.179', '34.229.18.179, 34.229.18.179', 'www.docs-proekt.shop/', '', 'ia_archiver'),
(1607002601, '3.94.21.209', '3.94.21.209, 3.94.21.209', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zamen-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'CCBot/2.0 (https://commoncrawl.org/faq/)'),
(1606990383, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/old-wp/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990383, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/web/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990383, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/old-site/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990384, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/temp/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990384, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/2018/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990384, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/2019/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990385, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/bk/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990385, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/wp1/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990385, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/wp2/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990386, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/v1/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990386, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/v2/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990386, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/bak/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990387, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/install/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990387, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/2020/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990387, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/new-site/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606999151, '95.163.255.228', '95.163.255.228, 95.163.255.228', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606990378, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/blog/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990378, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/wp/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990379, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/wordpress/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990379, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/new/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990379, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/old/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990380, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/test/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990380, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/main/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990380, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/site/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990382, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/cms/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990382, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/dev/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990381, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/home/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990381, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/backup/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606990381, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/demo/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606980055, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606983499, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1606988714, '13.66.139.152', '13.66.139.152, 13.66.139.152', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606988849, '95.163.255.204', '95.163.255.204, 95.163.255.204', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606990377, '45.56.66.176', '45.56.66.176, 45.56.66.176', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606964375, '13.66.139.152', '13.66.139.152, 13.66.139.152', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606964177, '174.127.135.130', '174.127.135.130, 174.127.135.130', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 6.0; en-US)'),
(1606962113, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606949329, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1606949507, '207.46.13.153', '207.46.13.153, 207.46.13.153', 'www.docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-remonta-i-zameni-setej-vodosnabzheniya.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606962110, '66.249.64.170', '66.249.64.170, 66.249.64.170', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606938870, '207.46.13.16', '207.46.13.16, 207.46.13.16', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilno-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606947038, '13.66.139.134', '13.66.139.134, 13.66.139.134', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606934070, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606929369, '78.129.221.86', '78.129.221.86, 78.129.221.86', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1606929369, '78.129.221.86', '78.129.221.86, 78.129.221.86', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36'),
(1606931315, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606934059, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606892924, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606899276, '40.77.167.2', '40.77.167.2, 40.77.167.2', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606905676, '62.210.92.175', '62.210.92.175, 62.210.92.175', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0'),
(1606920331, '87.252.226.79', '87.252.226.79, 87.252.226.79', 'docs-proekt.shop///?author=1', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1606920331, '87.252.226.79', '87.252.226.79, 87.252.226.79', 'docs-proekt.shop///wp-json/wp/v2/users/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1606925293, '13.66.139.134', '13.66.139.134, 13.66.139.134', 'www.docs-proekt.shop/news/DOCS_SHOP%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%20%D0%90%D0%BD%D0%BD%D0%BE%D1%82%D0%B0%D1%86%D0%B8%D1%8F.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606926221, '213.159.213.137', '213.159.213.137, 213.159.213.137', 'docs-proekt.shop/', '', 'Internet-structure-research-project-bot'),
(1606929368, '78.129.221.86', '78.129.221.86, 78.129.221.86', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1606929369, '78.129.221.86', '78.129.221.86, 78.129.221.86', 'docs-proekt.shop/magento_version/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'),
(1606891359, '157.55.39.134', '157.55.39.134, 157.55.39.134', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606886998, '66.249.64.163', '66.249.64.163, 66.249.64.163', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606885040, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606870847, '207.46.13.107', '207.46.13.107, 207.46.13.107', 'www.docs-proekt.shop/cart.php', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606881584, '207.46.13.16', '207.46.13.16, 207.46.13.16', 'www.docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606864132, '38.122.112.147', '38.122.112.147, 38.122.112.147', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.47 Safari/537.36'),
(1606850885, '37.9.118.29', '37.9.118.29, 37.9.118.29', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1606854137, '107.178.239.214', '107.178.239.214, 107.178.239.214', 'docs-proekt.shop/', '', 'node-fetch/1.0 (+https://github.com/bitinn/node-fetch)'),
(1606855545, '95.163.255.234', '95.163.255.234, 95.163.255.234', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606862948, '157.55.39.134', '157.55.39.134, 157.55.39.134', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-kanalizatsionnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606831346, '212.102.57.95', '212.102.57.95, 212.102.57.95', 'docs-proekt.shop/pages.php?view=register', 'http://docs-proekt.shop/pages.php?view=register', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1606831346, '212.102.57.95', '212.102.57.95, 212.102.57.95', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/pages.php?view=register', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1606831347, '212.102.57.95', '212.102.57.95, 212.102.57.95', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1606838456, '157.55.39.76', '157.55.39.76, 157.55.39.76', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606848416, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606828150, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606831346, '212.102.57.95', '212.102.57.95, 212.102.57.95', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36'),
(1606817828, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606819201, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606816186, '66.249.64.163', '66.249.64.163, 66.249.64.163', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606819970, '209.17.96.218', '209.17.96.218, 209.17.96.218', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1606819540, '46.242.10.146', '46.242.10.146, 46.242.10.146', 'docs-proekt.shop/', '', 'Scrapy/2.4.1 (+https://scrapy.org)'),
(1606819205, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606819203, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606819202, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606819201, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606819201, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606819201, '3.139.73.147', '3.139.73.147, 3.139.73.147', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'),
(1606802322, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-zubotehnicheskoj-laboratorii.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606806213, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606806215, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606806215, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606806215, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606810801, '31.171.152.106', '31.171.152.106, 31.171.152.106', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'),
(1606810802, '31.171.152.106', '31.171.152.106, 31.171.152.106', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'),
(1606810804, '31.171.152.106', '31.171.152.106, 31.171.152.106', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'),
(1606810967, '192.162.102.26', '192.162.102.26, 192.162.102.26', 'www.docs-proekt.shop/', 'http://arhiv-proekt.ru', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),
(1606812983, '40.77.167.27', '40.77.167.27, 40.77.167.27', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-kap-rem-FSS-vn-inzhenernie-seti.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606815278, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606789791, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606797366, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606799726, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606773872, '157.55.39.7', '157.55.39.7, 157.55.39.7', 'docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606773872, '13.66.139.134', '13.66.139.134, 13.66.139.134', 'www.docs-proekt.shop/news/Sajt-inzhenera-proektirovshhika.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606777822, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606778545, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606782109, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/content/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606788330, '114.119.143.25', '10.179.80.244, 114.119.143.25, 114.119.143.25', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (Linux; Android 7.0;) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; PetalBot;+https://aspiegel.com/petalbot)'),
(1606762577, '13.66.139.107', '13.66.139.107, 13.66.139.107', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606766810, '40.77.167.2', '40.77.167.2, 40.77.167.2', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606772056, '66.249.64.170', '66.249.64.170, 66.249.64.170', 'www.docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606749282, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606755930, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606760902, '192.71.42.108', '192.71.42.108, 192.71.42.108', 'docs-proekt.shop/', '', 'Go-http-client/1.1'),
(1606733381, '95.163.255.203', '95.163.255.203, 95.163.255.203', 'docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606721397, '95.163.255.1', '95.163.255.1, 95.163.255.1', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606735067, '54.221.27.173', '54.221.27.173, 54.221.27.173', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1606666734, '66.249.66.136', '66.249.66.136, 66.249.66.136', 'www.docs-proekt.shop/news/%D0%A1%D0%B0%D0%B9%D1%82%20Proektant.html', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606681943, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606683132, '95.163.255.207', '95.163.255.207, 95.163.255.207', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606686836, '128.199.212.194', '128.199.212.194, 128.199.212.194', 'docs-proekt.shop///?author=1', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1606686841, '128.199.212.194', '128.199.212.194, 128.199.212.194', 'docs-proekt.shop///wp-json/wp/v2/users/', '', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0'),
(1606688715, '181.215.74.14', '181.215.74.14, 181.215.74.14', 'docs-proekt.shop/', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1'),
(1606693192, '138.59.7.112', '138.59.7.112, 138.59.7.112', 'docs-proekt.shop/', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1'),
(1606695119, '95.163.255.212', '95.163.255.212, 95.163.255.212', 'docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606696678, '66.249.66.157', '66.249.66.157, 66.249.66.157', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606701299, '64.246.165.180', '64.246.165.180, 64.246.165.180', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:59.0) Gecko/20100101 Firefox/59.0'),
(1606702901, '66.249.66.156', '66.249.66.156, 66.249.66.156', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606711440, '40.77.167.25', '40.77.167.25, 40.77.167.25', 'www.docs-proekt.shop/news/DOCS_SHOP%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%20%D0%90%D0%BD%D0%BD%D0%BE%D1%82%D0%B0%D1%86%D0%B8%D1%8F.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606711703, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606711712, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606719070, '157.55.39.7', '157.55.39.7, 157.55.39.7', 'www.docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606721201, '114.119.140.170', '114.119.140.170, 114.119.140.170', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 7.0;) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; PetalBot;+https://aspiegel.com/petalbot)'),
(1606631858, '95.163.255.222', '95.163.255.222, 95.163.255.222', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606633718, '5.62.60.53', '5.62.60.53, 5.62.60.53', 'docs-proekt.shop//content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606633719, '5.62.60.53', '5.62.60.53, 5.62.60.53', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop//content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606645365, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606646557, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606648902, '40.77.167.2', '40.77.167.2, 40.77.167.2', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606650752, '157.55.39.191', '157.55.39.191, 157.55.39.191', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606665362, '40.77.167.5', '40.77.167.5, 40.77.167.5', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606575180, '5.45.207.162', '5.45.207.162, 5.45.207.162', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606582212, '37.9.118.29', '37.9.118.29, 37.9.118.29', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1606590393, '95.105.65.0', '95.105.65.0, 95.105.65.0', 'docs-proekt.shop/news/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 YaBrowser/20.9.3.136 Yowser/2.5 Safari/537.36'),
(1606590490, '5.255.253.106', '5.255.253.106, 5.255.253.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606595618, '5.255.231.141', '5.255.231.141, 5.255.231.141', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606595620, '213.180.203.5', '213.180.203.5, 213.180.203.5', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606595621, '5.45.207.106', '5.45.207.106, 5.45.207.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606595621, '5.255.253.151', '5.255.253.151, 5.255.253.151', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606597998, '95.163.255.208', '95.163.255.208, 95.163.255.208', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606604974, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)');
INSERT INTO `arwm_visitlog` (`date`, `ip`, `forwarded`, `request`, `referer`, `useragent`) VALUES
(1606609771, '95.163.255.220', '95.163.255.220, 95.163.255.220', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606615455, '95.163.255.235', '95.163.255.235, 95.163.255.235', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606620205, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/Proekt-shkola-iskustv.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606620504, '95.163.255.232', '95.163.255.232, 95.163.255.232', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapremrnta-gorbolnitsi-inzh-seti.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606626567, '95.163.255.237', '95.163.255.237, 95.163.255.237', 'docs-proekt.shop/price.php', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606626930, '95.163.255.222', '95.163.255.222, 95.163.255.222', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-otvala-aspiratsiya.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606574994, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnog-remonta-travmatologii.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606574408, '5.255.231.95', '5.255.231.95, 5.255.231.95', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskogo-sada.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606574851, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-dom-kulturi.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606574870, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskij-sad.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606574973, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-ko-vsemu-arhivu-vse-urovni-3000-rub-za-odni-sutki.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606556109, '38.145.91.129', '38.145.91.129, 38.145.91.129', 'docs-proekt.shop/', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1'),
(1606556363, '207.46.13.107', '207.46.13.107, 207.46.13.107', 'www.docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606558900, '209.17.96.130', '209.17.96.130, 209.17.96.130', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Nimbostratus-Bot/v1.3.2; http://cloudsystemnetworks.com)'),
(1606566939, '13.66.139.134', '13.66.139.134, 13.66.139.134', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606567289, '13.66.139.134', '13.66.139.134, 13.66.139.134', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606571123, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606572021, '5.45.207.174', '5.45.207.174, 5.45.207.174', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606572023, '5.45.207.174', '5.45.207.174, 5.45.207.174', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606572035, '213.180.203.115', '213.180.203.115, 213.180.203.115', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606572041, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606574231, '5.45.207.133', '5.45.207.133, 5.45.207.133', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-zubotehnicheskoj-laboratorii.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606574234, '5.45.207.132', '5.45.207.132, 5.45.207.132', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-zubotehnicheskoj-laboratorii.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606551163, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/news/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551163, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/news/Sajt-inzhenera-proektirovshhika.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551163, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551164, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551164, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551164, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551165, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551165, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551166, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilno-dorogi.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606554812, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606555967, '114.119.138.249', '114.119.138.249, 114.119.138.249', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 7.0;) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; PetalBot;+https://aspiegel.com/petalbot)'),
(1606551163, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/content/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551162, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551161, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551162, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551158, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551159, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551159, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551160, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551160, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551160, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551161, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551161, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606520847, '66.249.66.155', '66.249.66.155, 66.249.66.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606525203, '191.96.84.81', '191.96.84.81, 191.96.84.81', 'docs-proekt.shop/', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1'),
(1606551158, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/price.php', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551158, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551157, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551157, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551156, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606551157, '62.210.172.211', '62.210.172.211, 62.210.172.211', 'docs-proekt.shop/cart.php', '', 'Mozilla/5.0 (X11; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0'),
(1606537931, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1606537923, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', 'https://docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1606537922, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1606537908, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', 'http://www.arhiv-proekt.ru/SAV22-1_4index.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1606525906, '40.77.167.20', '40.77.167.20, 40.77.167.20', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-pererabotki-otvala.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606535933, '192.71.12.140', '192.71.12.140, 192.71.12.140', 'docs-proekt.shop/', '', 'Go-http-client/1.1'),
(1606483904, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/cart.php?show', 'https://docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606483907, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/pages.php', 'https://docs-proekt.shop/cart.php?show', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606505919, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606500811, '66.249.66.198', '66.249.66.198, 66.249.66.198', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606499588, '35.226.163.18', '35.226.163.18, 35.226.163.18', 'docs-proekt.shop/', '', 'python-requests/2.25.0'),
(1606497131, '66.249.92.93', '66.249.92.93, 66.249.92.93', 'docs-proekt.shop/googlefbb51306e252822e.html', '', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)'),
(1606488635, '65.155.30.101', '65.155.30.101, 65.155.30.101', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.71 Safari/537.36'),
(1606490485, '40.77.167.27', '40.77.167.27, 40.77.167.27', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606488164, '173.72.158.110', '173.72.158.110, 173.72.158.110', 'docs-proekt.shop/admin/', '', 'httpx - Open-source project (github.com/projectdiscovery/httpx)'),
(1606483948, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/Proekt-shkola-iskustv.html', 'https://docs-proekt.shop/price.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606483917, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/price.php', 'https://docs-proekt.shop/pages.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606458986, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/v2/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458986, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/bak/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458987, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/install/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458987, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/2020/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458987, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/new-site/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606464715, '40.77.167.2', '40.77.167.2, 40.77.167.2', 'www.docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606465107, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606465107, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606465107, '5.45.207.162', '5.45.207.162, 5.45.207.162', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606465107, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606465214, '207.46.13.107', '207.46.13.107, 207.46.13.107', 'www.docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606478449, '54.221.27.173', '54.221.27.173, 54.221.27.173', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(1606479099, '37.9.13.68', '37.9.13.68, 37.9.13.68', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0'),
(1606481966, '95.217.207.28', '95.217.207.28, 95.217.207.28', 'docs-proekt.shop/', '', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)'),
(1606483128, '188.40.32.134', '188.40.32.134, 188.40.32.134', 'docs-proekt.shop/', '', ''),
(1606483864, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606483902, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', 'https://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606483904, '178.66.237.103', '178.66.237.103, 178.66.237.103', 'docs-proekt.shop/cart.php', 'https://docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36'),
(1606458984, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/web/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458984, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/old-site/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458984, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/temp/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458985, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/2018/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458985, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/2019/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458985, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/bk/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458985, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/wp1/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458986, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/wp2/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458986, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/v1/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458982, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/backup/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458983, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/demo/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458983, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/home/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458983, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/cms/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458983, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/dev/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458984, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/old-wp/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458982, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/site/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458982, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/main/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458981, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/wordpress/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458981, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/new/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458981, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/old/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458982, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/test/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458980, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458980, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/blog/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606458981, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/wp/', '', 'Mozilla/5.0 (Linux; Android 5.1.1; SM-J111F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.90 Mobile Safari/537.36'),
(1606445604, '107.178.238.31', '107.178.238.31, 107.178.238.31', 'docs-proekt.shop/', '', 'node-fetch/1.0 (+https://github.com/bitinn/node-fetch)'),
(1606451704, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606451868, '100.26.135.239', '100.26.135.239, 100.26.135.239', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1606434669, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606440585, '65.154.226.109', '65.154.226.109, 65.154.226.109', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.71 Safari/537.36'),
(1606413217, '95.163.255.199', '95.163.255.199, 95.163.255.199', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606430697, '143.244.57.233', '143.244.57.233, 143.244.57.233', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4100.3 Safari/537.36'),
(1606430697, '143.244.57.233', '143.244.57.233, 143.244.57.233', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4100.3 Safari/537.36'),
(1606418679, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606413578, '207.46.13.85', '207.46.13.85, 207.46.13.85', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606413446, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606413152, '18.159.34.180', '18.159.34.180, 18.159.34.180', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko; compatible; BW/1.1; bit.ly/2W6Px8S) Chrome/84.0.4147.105 Safari/537.36'),
(1606408843, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606409121, '157.55.39.59', '157.55.39.59, 157.55.39.59', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606407962, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606402025, '95.163.255.203', '95.163.255.203, 95.163.255.203', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606401082, '3.238.81.86', '3.238.81.86, 3.238.81.86', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36'),
(1606392463, '103.225.168.81', '103.225.168.81, 103.225.168.81', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50'),
(1606391124, '5.45.207.162', '5.45.207.162, 5.45.207.162', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606390283, '129.88.54.26', '129.88.54.26, 129.88.54.26', 'docs-proekt.shop/', 'https://itunes.apple.com', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'),
(1606389188, '40.77.167.25', '40.77.167.25, 40.77.167.25', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-ko-vsemu-arhivu-vse-urovni-3000-rub-za-odni-sutki.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606373785, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606373643, '95.163.255.207', '95.163.255.207, 95.163.255.207', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606360448, '157.55.39.221', '157.55.39.221, 157.55.39.221', 'www.docs-proekt.shop/cart.php', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606363799, '207.46.13.84', '207.46.13.84, 207.46.13.84', 'www.docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-remonta-i-zameni-setej-vodosnabzheniya.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606370193, '66.249.66.138', '66.249.66.138, 66.249.66.138', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606370199, '66.249.66.136', '66.249.66.136, 66.249.66.136', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606357387, '207.46.13.85', '207.46.13.85, 207.46.13.85', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-nevrologicheskogo-otdeleniya-rekonstr-rodilnogo.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606358858, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1606359930, '157.55.39.102', '157.55.39.102, 157.55.39.102', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zamen-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606340290, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606341353, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606354018, '95.163.255.222', '95.163.255.222, 95.163.255.222', 'docs-proekt.shop/price.php', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606354430, '95.163.255.225', '95.163.255.225, 95.163.255.225', 'docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606339202, '40.77.167.9', '40.77.167.9, 40.77.167.9', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-federalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606329210, '40.77.167.2', '40.77.167.2, 40.77.167.2', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606329435, '157.55.39.221', '157.55.39.221, 157.55.39.221', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-mnogokvartirnogo-zhilogo-doma-dostrojka.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606337678, '95.163.255.210', '95.163.255.210, 95.163.255.210', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606338153, '95.163.255.124', '95.163.255.124, 95.163.255.124', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-otvala-aspiratsiya.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606325577, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606324752, '13.66.139.7', '13.66.139.7, 13.66.139.7', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606311449, '37.9.118.29', '37.9.118.29, 37.9.118.29', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1606301280, '95.163.255.122', '95.163.255.122, 95.163.255.122', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606294697, '40.77.167.25', '40.77.167.25, 40.77.167.25', 'www.docs-proekt.shop/news/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606295661, '95.163.255.226', '95.163.255.226, 95.163.255.226', 'docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606290423, '37.9.13.135', '37.9.13.135, 37.9.13.135', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:82.0) Gecko/20100101 Firefox/82.0'),
(1606258625, '13.66.139.120', '13.66.139.120, 13.66.139.120', 'www.docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606274161, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1606284159, '95.163.255.17', '95.163.255.17, 95.163.255.17', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606284573, '95.163.255.208', '95.163.255.208, 95.163.255.208', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapremrnta-gorbolnitsi-inzh-seti.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606253552, '66.249.64.163', '66.249.64.163, 66.249.64.163', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606254404, '191.102.151.249', '191.102.151.249, 191.102.151.249', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606254406, '191.102.151.249', '191.102.151.249, 191.102.151.249', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606257978, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/news/%D0%A1%D0%B0%D0%B9%D1%82%20Proektant.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606202144, '66.249.65.93', '66.249.65.93, 66.249.65.93', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606211089, '194.110.115.204', '194.110.115.204, 194.110.115.204', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'),
(1606211090, '194.110.115.204', '194.110.115.204, 194.110.115.204', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'),
(1606211090, '194.110.115.204', '194.110.115.204, 194.110.115.204', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'),
(1606211691, '51.158.103.247', '51.158.103.247, 51.158.103.247', 'www.docs-proekt.shop/', '', ''),
(1606217492, '5.128.67.145', '5.128.67.145, 5.128.67.145', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Safari/605.1.15'),
(1606223086, '5.255.231.141', '5.255.231.141, 5.255.231.141', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606223091, '5.45.207.162', '5.45.207.162, 5.45.207.162', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606223091, '5.45.207.162', '5.45.207.162, 5.45.207.162', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606223091, '5.255.253.106', '5.255.253.106, 5.255.253.106', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606224155, '195.154.182.72', '195.154.182.72, 195.154.182.72', 'docs-proekt.shop/?author=1', '', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36 OPR/32.0.1948.45'),
(1606225942, '207.46.13.243', '207.46.13.243, 207.46.13.243', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606226528, '104.237.154.118', '104.237.154.118, 104.237.154.118', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(1606230290, '95.163.255.219', '95.163.255.219, 95.163.255.219', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606238398, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606239842, '40.77.167.2', '40.77.167.2, 40.77.167.2', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-rastvorobetonnogo-uzla.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606243473, '207.46.13.14', '207.46.13.14, 207.46.13.14', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606246657, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-federalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606200990, '207.46.13.31', '207.46.13.31, 207.46.13.31', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-samotechnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606184536, '95.163.255.218', '95.163.255.218, 95.163.255.218', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606183496, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606183493, '5.45.207.159', '5.45.207.159, 5.45.207.159', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606183490, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-kanalizatsionnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606183486, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-Kirpichnij-zavod-ekonstruktsiya-i-pileudalenie.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606183483, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-otvala-aspiratsiya.html', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606182994, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1606183447, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/price.php', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606182253, '157.55.39.87', '157.55.39.87, 157.55.39.87', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-rekonstruktsii-obektov-kanalizatsionnih-setej-korrektirovka.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606182224, '40.77.167.25', '40.77.167.25, 40.77.167.25', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtomobilnie-vesi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606172508, '95.163.255.199', '95.163.255.199, 95.163.255.199', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtozapravochnoj-stantsii-AZS.html', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1606174273, '207.46.13.14', '207.46.13.14, 207.46.13.14', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovoda-napornogo-kollektora-i-rekonstruktsiya-KNS.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606163641, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606164129, '5.166.176.46', '5.166.176.46, 5.166.176.46', 'docs-proekt.shop/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36 OPR/72.0.3815.186'),
(1606158587, '66.249.65.93', '66.249.65.93, 66.249.65.93', 'www.docs-proekt.shop/news/Sajt-inzhenera-proektirovshhika.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606150041, '46.17.203.253', '46.17.203.253, 46.17.203.253', 'docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; Konturbot/1.0; +http://kontur.ru; cargo@kontur.ru)'),
(1606152752, '51.15.195.246', '51.15.195.246, 51.15.195.246', 'docs-proekt.shop/', '', ''),
(1606154865, '66.249.64.163', '66.249.64.163, 66.249.64.163', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-remonta-i-zameni-setej-vodosnabzheniya.html', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606127305, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606144309, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/cart.php', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606126711, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606149876, '46.17.203.253', '46.17.203.253, 46.17.203.253', 'docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (compatible; Konturbot/1.0; +http://kontur.ru; cargo@kontur.ru)'),
(1606149611, '46.17.203.253', '46.17.203.253, 46.17.203.253', 'www.docs-proekt.shop/content/about.html', '', 'Mozilla/5.0 (compatible; Konturbot/1.0; +http://kontur.ru; cargo@kontur.ru)'),
(1606149510, '46.17.203.253', '46.17.203.253, 46.17.203.253', 'www.docs-proekt.shop/content/contacts.html', '', 'Mozilla/5.0 (compatible; Konturbot/1.0; +http://kontur.ru; cargo@kontur.ru)'),
(1606149490, '46.17.203.253', '46.17.203.253, 46.17.203.253', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Konturbot/1.0; +http://kontur.ru; cargo@kontur.ru)'),
(1606149230, '46.17.203.253', '46.17.203.253, 46.17.203.253', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Konturbot/1.0; +http://kontur.ru; cargo@kontur.ru)'),
(1606125970, '157.55.39.78', '157.55.39.78, 157.55.39.78', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-kapitalnogo-remonta-vodovoda.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606126562, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606124777, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606124255, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606122990, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606122546, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606107164, '5.255.231.28', '5.255.231.28, 5.255.231.28', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606107170, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1606111139, '118.27.78.15', '118.27.78.15, 118.27.78.15', 'www.docs-proekt.shop/', '', 'python-requests/2.25.0'),
(1606114840, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)');
INSERT INTO `arwm_visitlog` (`date`, `ip`, `forwarded`, `request`, `referer`, `useragent`) VALUES
(1606118382, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606119157, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606122026, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606071269, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', 'http://docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606101484, '157.55.39.69', '157.55.39.69, 157.55.39.69', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/%D0%A1%D0%BE%D0%BE%D0%B1%D1%89%D0%B8%D1%82%D0%B5.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606099115, '114.119.139.107', '114.119.139.107, 114.119.139.107', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 7.0;) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; PetalBot;+https://aspiegel.com/petalbot)'),
(1606091838, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/news/Sajt-inzhenera-proektirovshhika.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606076025, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1606075926, '207.46.13.14', '207.46.13.14, 207.46.13.14', 'www.docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606071332, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/', 'http://www.arhiv-proekt.ru/SAV22-1index.html', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606071299, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', 'http://docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606071287, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', 'http://docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606071272, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', 'http://docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606033467, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-mnogokvartirnogo-zhilogo-doma-dostrojka.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033471, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-mnogokvartirnogo-zhilogo-doma-dostrojka.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033473, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033483, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-proizvodstva-rabot-PPR-na-snos-zhilih-domov.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606034753, '37.9.118.29', '37.9.118.29, 37.9.118.29', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1606040651, '40.77.167.28', '40.77.167.28, 40.77.167.28', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnogo-remonta-uchastkovoj-bolnitsi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606057521, '157.55.39.109', '157.55.39.109, 157.55.39.109', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606057648, '35.203.245.117', '35.203.245.117, 35.203.245.117', 'docs-proekt.shop/', '', 'node-fetch/1.0 (+https://github.com/bitinn/node-fetch)'),
(1606066872, '40.77.167.9', '40.77.167.9, 40.77.167.9', 'www.docs-proekt.shop/news/%D0%A1%D0%B0%D0%B9%D1%82%20Proektant.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606070890, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606070911, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606070918, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606070920, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', 'http://docs-proekt.shop/catalog/Proekti-administrativnih-obektov/', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606071107, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', 'http://docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', 'Mozilla/5.0 (X11; Linux i686; rv:78.0) Gecko/20100101 Firefox/78.0'),
(1606033462, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033426, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033439, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033446, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033454, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033459, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033415, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-dom-kulturi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033406, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-dom-kulturi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033403, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/Proekt-shkola-iskustv.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033396, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-uchebnih-uchrezhdenij/Proekt-shkola-iskustv.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033392, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033387, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/Proekt-kapremonta-kafe-vnutrennie-inzh-seti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033384, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-otvala-aspiratsiya.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033355, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-i-pererabotki-porodnogo-otvala.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033371, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-otvala-aspiratsiya.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033348, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-razborki-i-pererabotki-porodnogo-otvala.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033331, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-rastvorobetonnogo-uzla.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033340, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-rastvorobetonnogo-uzla.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033326, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-pererabotki-otvala.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033315, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtozapravochnoj-stantsii-AZS.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033318, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-pererabotki-otvala.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033304, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtozapravochnoj-stantsii-AZS.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033293, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtomobilnie-vesi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033260, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-nevrologicheskogo-otdeleniya-rekonstr-rodilnogo.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033262, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-zubotehnicheskoj-laboratorii.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033271, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-zubotehnicheskoj-laboratorii.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033280, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-Kirpichnij-zavod-ekonstruktsiya-i-pileudalenie.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033285, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-Kirpichnij-zavod-ekonstruktsiya-i-pileudalenie.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033289, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-avtomobilnie-vesi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033243, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-medsanchasti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033251, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-medsanchasti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033254, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-nevrologicheskogo-otdeleniya-rekonstr-rodilnogo.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033227, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapremrnta-gorbolnitsi-inzh-seti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033207, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnogo-remonta-uchastkovoj-bolnitsi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033210, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnogo-remonta-uchastkovoj-bolnitsi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033224, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapremrnta-gorbolnitsi-inzh-seti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033184, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnog-remonta-travmatologii.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033194, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kapitalnog-remonta-travmatologii.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033158, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%20%D0%BA%D0%B0%D0%BF%D0%B8%D1%82%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B3%D0%BE%20%D1%80%D0%B5%D0%BC%D0%BE%D0%BD%D1%82%D0%B0%20%D0%91%D0%BE%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033167, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kap-remonta-tubdispansera.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033174, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/Proekt-kap-remonta-tubdispansera.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033142, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskogo-sada.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033154, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%20%D0%BA%D0%B0%D0%BF%D0%B8%D1%82%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B3%D0%BE%20%D1%80%D0%B5%D0%BC%D0%BE%D0%BD%D1%82%D0%B0%20%D0%91%D0%BE%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033120, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskij-sad.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033135, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskogo-sada.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033099, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-deskogo-sada-kap-rem.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033116, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-detskij-sad.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033074, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtodorogi-ul-shevchenko.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033078, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033084, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033089, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/Proekt-deskogo-sada-kap-rem.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033058, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-munitsipalnoj-avtodorogi-ul-shevchenko.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033045, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033048, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-kapitalnogo-remonta-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033038, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-federalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033009, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033013, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-kap-rem-FSS-vn-inzhenernie-seti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033026, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-kap-rem-FSS-vn-inzhenernie-seti.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033036, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-federalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606033002, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/Proekti-administrativnih-obektov/Proekt-ekskalatora-universama-Dizajn-proekt-torgovogo-tsentra.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032989, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-k-katalogu-1-j-uroven-i-nizhe.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032993, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Polnij-dostup-ko-vsemu-arhivu-vse-urovni-3000-rub-za-odni-sutki.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032964, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032983, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032973, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/%D0%A1%D0%BE%D0%BE%D0%B1%D1%89%D0%B8%D1%82%D0%B5.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032968, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032961, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovoda-napornogo-kollektora-i-rekonstruktsiya-KNS.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032943, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-samotechnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032947, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-samotechnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032956, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-vodovoda-napornogo-kollektora-i-rekonstruktsiya-KNS.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032938, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-kanalizatsionnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032935, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-kanalizatsionnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032923, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-kanalizatsion-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032916, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zameni-kanalizatsion-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032912, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zamen-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032909, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-zamen-vodovodov-napornogo-kollektora-i-rekonstruktsii-kanalizatsionnih-nasosnih-stantsij.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032903, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-rekonstruktsii-obektov-kanalizatsionnih-setej-korrektirovka.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032894, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-rekonstruktsii-obektov-kanalizatsionnih-setej-korrektirovka.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032884, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-kanalizatsionnoj-nasosnoj-stantsii.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032880, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-kanalizatsionnoj-nasosnoj-stantsii.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032875, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-kanalizatsionnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032852, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-zameni-avarijnih-vodoprovodnih-setej.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032868, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/Proekt-kanalizatsionnogo-kollektora.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032862, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-zameni-avarijnih-vodoprovodnih-setej.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032848, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-vodovoda.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032825, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-vodoprovoda.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032834, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-vodoprovoda.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032840, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-vodovoda.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032820, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-setej-vodosnabzheniya.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032815, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-setej-vodosnabzheniya.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032800, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-rekonstruktsii-vodoprovodnih-setej.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032809, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-rekonstruktsii-vodoprovodnih-setej.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032796, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-kapitalnogo-remonta-vodovoda.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606032786, '94.130.52.155', '94.130.52.155, 94.130.52.155', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-kapitalnogo-remonta-vodovoda.html', '', 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup-crawler.com/)'),
(1606030743, '31.177.65.28', '31.177.65.28, 31.177.65.28', 'docs-proekt.shop/', '', 'index (+http://www.nic.ru)'),
(1606017532, '5.255.253.97', '5.255.253.97, 5.255.253.97', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606017532, '5.255.231.28', '5.255.231.28, 5.255.231.28', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606017531, '5.45.207.101', '5.45.207.101, 5.45.207.101', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606017531, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1606013240, '157.55.39.69', '157.55.39.69, 157.55.39.69', 'www.docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1606000176, '209.127.38.5', '209.127.38.5, 209.127.38.5', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606000171, '209.127.38.5', '209.127.38.5, 209.127.38.5', 'docs-proekt.shop/content/about.html', 'http://DOCS-PROEKT.SHOP', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606000169, '107.152.140.215', '107.152.140.215, 107.152.140.215', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1606000170, '209.127.38.5', '209.127.38.5, 209.127.38.5', 'docs-proekt.shop/content/contacts.html', 'http://DOCS-PROEKT.SHOP', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605994676, '66.249.69.155', '66.249.69.155, 66.249.69.155', 'www.docs-proekt.shop/catalog/Proekti-obektov-obshhestvennogo-pitaniya/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605987654, '207.46.13.87', '207.46.13.87, 207.46.13.87', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/Proekt-kapitalnogo-remonta-doma-kulturi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605983840, '5.255.253.106', '5.255.253.106, 5.255.253.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605969885, '191.102.153.240', '191.102.153.240, 191.102.153.240', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605969890, '191.102.153.240', '191.102.153.240, 191.102.153.240', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605980122, '213.180.203.30', '213.180.203.30, 213.180.203.30', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605980124, '5.255.253.151', '5.255.253.151, 5.255.253.151', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605962858, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605966958, '104.248.135.136', '104.248.135.136, 104.248.135.136', 'docs-proekt.shop/', '', 'SEOlizer/1.1 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13 (+https://www.seolizer.de/bot.html)'),
(1605969882, '191.102.153.240', '191.102.153.240, 191.102.153.240', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605957352, '79.111.162.15', '79.111.162.15, 79.111.162.15', 'docs-proekt.shop/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36'),
(1605947757, '66.249.69.229', '66.249.69.229, 66.249.69.229', 'docs-proekt.shop/news/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605950507, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', 'http://www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Mobile/15E148 Safari/604.1'),
(1605947682, '66.249.69.227', '66.249.69.227, 66.249.69.227', 'docs-proekt.shop/catalog/Proekti-zhilih-domov/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605946095, '66.249.69.229', '66.249.69.229, 66.249.69.229', 'docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605940752, '66.249.69.230', '66.249.69.230, 66.249.69.230', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605940792, '66.249.69.224', '66.249.69.224, 66.249.69.224', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605940428, '37.204.43.145', '37.204.43.145, 37.204.43.145', 'docs-proekt.shop/', 'https://yandex.ru/', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36'),
(1605923986, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605939591, '40.77.167.9', '40.77.167.9, 40.77.167.9', 'docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/Proekt-vodoprovoda.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605921161, '89.163.242.241', '89.163.242.241, 89.163.242.241', 'docs-proekt.shop/', '', 'Dy robot 1.0'),
(1605921822, '180.163.220.5', '180.163.220.5, 180.163.220.5', 'docs-proekt.shop/', 'http://baidu.com/', 'Mozilla/5.0 (Linux; U; Android 8.1.0; zh-CN; EML-AL00 Build/HUAWEIEML-AL00) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.108 baidu.sogo.uc.UCBrowser/11.9.4.974 UWS/2.13.1.48 Mobile Safari/537.36 AliApp(DingTalk/4.5.11) com.alibaba.a'),
(1605913082, '207.46.13.14', '207.46.13.14, 207.46.13.14', 'www.docs-proekt.shop/catalog/Proekti-avtomobilnih-dorog/Proekt-federalnoj-avtomobilnoj-dorogi.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605914408, '13.66.139.123', '13.66.139.123, 13.66.139.123', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605908246, '66.249.69.153', '66.249.69.153, 66.249.69.153', 'www.docs-proekt.shop/catalog/Proekti-lechebnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605904985, '5.62.56.49', '5.62.56.49, 5.62.56.49', 'docs-proekt.shop//content/contacts.html', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605904986, '5.62.56.49', '5.62.56.49, 5.62.56.49', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop//content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605903406, '174.127.135.130', '174.127.135.130, 174.127.135.130', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20120427 Firefox/15.0a1'),
(1605903408, '174.127.135.130', '174.127.135.130, 174.127.135.130', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20120427 Firefox/15.0a1'),
(1605902568, '85.249.161.143', '85.249.161.143, 85.249.161.143', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', 'http://www.docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902570, '85.249.161.143', '85.249.161.143, 85.249.161.143', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', 'http://www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902367, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/Tehnicheskaya-biblioteka.html', 'http://www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902534, '85.249.161.143', '85.249.161.143, 85.249.161.143', 'www.docs-proekt.shop/catalog/zhilihe-doma/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902537, '85.249.161.143', '85.249.161.143, 85.249.161.143', 'www.docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', 'http://www.docs-proekt.shop/catalog/zhilihe-doma/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902364, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/catalog/BIBLIOTEKA-normi-pravila-dokumenti-knigi/', 'http://www.docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902294, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/Proekt-kottedzha-Raschet-fundamenta.html', 'http://www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902288, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/catalog/Proekti-zhilih-domov/', 'http://www.docs-proekt.shop/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605902283, '80.254.127.1', '80.254.127.1, 80.254.127.1', 'www.docs-proekt.shop/', 'http://www.arhiv-proekt.ru/', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15'),
(1605901220, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605900361, '207.46.13.247', '207.46.13.247, 207.46.13.247', 'www.docs-proekt.shop/catalog/%D0%92%D0%BE%D0%B4%D0%BE%D1%81%D0%BD%D0%B0%D0%B1%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605901580, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-metallicheskoj-fermi-18m.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605893932, '35.232.168.222', '35.232.168.222, 35.232.168.222', 'docs-proekt.shop/', '', 'python-requests/2.22.0'),
(1605896909, '207.46.13.109', '207.46.13.109, 207.46.13.109', 'docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/Proekt-Kirpichnij-zavod-ekonstruktsiya-i-pileudalenie.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605878811, '157.55.39.69', '157.55.39.69, 157.55.39.69', 'docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Arenda-elektronnogo-arhiva-s-arhivariusom-v-udalennom-rezhime-s-9do-18-rab-den-na-odnu-nedelyu.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605874498, '13.66.139.123', '13.66.139.123, 13.66.139.123', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605874655, '91.144.130.24', '91.144.130.24, 91.144.130.24', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.35 (KHTML, like Gecko) Chrome/27.0.1453.0 Safari/537.35'),
(1605843831, '66.249.64.166', '66.249.64.166, 66.249.64.166', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605841408, '31.171.152.137', '31.171.152.137, 31.171.152.137', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.64'),
(1605841409, '31.171.152.137', '31.171.152.137, 31.171.152.137', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.64'),
(1605841408, '31.171.152.137', '31.171.152.137, 31.171.152.137', 'docs-proekt.shop/', 'http://docs-proekt.shop/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.64'),
(1605824630, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/competition/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605840278, '95.163.255.222', '95.163.255.222, 95.163.255.222', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1605840652, '114.119.147.91', '114.119.147.91, 114.119.147.91', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 7.0;) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; PetalBot;+https://aspiegel.com/petalbot)'),
(1605841260, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/catalog/POLNIJ-DOSTUP-K-ARHIVU-PROEKTOV/Uslugi-arhivariusa-poisk-kataloga-po-tematicheskomu-zaprosu.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605824617, '213.180.203.83', '213.180.203.83, 213.180.203.83', 'docs-proekt.shop/competition/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605824470, '5.255.253.151', '5.255.253.151, 5.255.253.151', 'docs-proekt.shop/competition/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605823698, '136.0.16.221', '136.0.16.221, 136.0.16.221', 'docs-proekt.shop/pages.php', 'http://docs-proekt.shop/content/contacts.html', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605815416, '168.119.114.164', '168.119.114.164, 168.119.114.164', 'docs-proekt.shop/wp-admin/', '', 'python-requests/2.25.0'),
(1605820763, '5.45.207.162', '5.45.207.162, 5.45.207.162', 'docs-proekt.shop/catalog/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%20%D0%B2%D0%BE%D0%B4%D0%BE%D0%BE%D1%82%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605823697, '136.0.16.221', '136.0.16.221, 136.0.16.221', 'docs-proekt.shop/content/contacts.html', 'http://docs-proekt.shop', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605823696, '136.0.16.221', '136.0.16.221, 136.0.16.221', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0,gzip(gfe)'),
(1605812345, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/news/DOCS_SHOP%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%20%D0%90%D0%BD%D0%BD%D0%BE%D1%82%D0%B0%D1%86%D0%B8%D1%8F.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605811119, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/support/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605792617, '1.20.184.238', '1.20.184.238, 1.20.184.238', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(1605793426, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-na-proizvodstvennie-obekti/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605795556, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-doshkolnih-uchrezhdenij/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605798477, '66.249.64.161', '66.249.64.161, 66.249.64.161', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605811117, '5.255.253.155', '5.255.253.155, 5.255.253.155', 'docs-proekt.shop/support/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268');
INSERT INTO `arwm_visitlog` (`date`, `ip`, `forwarded`, `request`, `referer`, `useragent`) VALUES
(1605797871, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/Proekti-uchrezhdenij-kulturi/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605781005, '5.255.253.185', '5.255.253.185, 5.255.253.185', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605781005, '5.255.253.106', '5.255.253.106, 5.255.253.106', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605781005, '213.180.203.115', '213.180.203.115, 213.180.203.115', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605765256, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605767996, '47.254.68.12', '47.254.68.12, 47.254.68.12', 'docs-proekt.shop/', '', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:61.0) Gecko/20100101 Firefox/73.0'),
(1605781005, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605761167, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605761173, '66.249.64.168', '66.249.64.168, 66.249.64.168', 'www.docs-proekt.shop/', '', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'),
(1605759670, '37.9.118.29', '37.9.118.29, 37.9.118.29', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)'),
(1605751439, '5.255.231.6', '5.255.231.6, 5.255.231.6', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'),
(1605755030, '13.66.139.87', '13.66.139.87, 13.66.139.87', 'www.docs-proekt.shop/news/Sajt-inzhenera-proektirovshhika.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605745439, '176.31.252.167', '176.31.252.167, 176.31.252.167', 'docs-proekt.shop/', '', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)'),
(1605748581, '95.163.255.203', '95.163.255.203, 95.163.255.203', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'),
(1605751029, '42.236.10.78', '42.236.10.78, 42.236.10.78', 'docs-proekt.shop/', 'http://baidu.com/', 'Mozilla/5.0 (Linux; U; Android 8.1.0; zh-CN; EML-AL00 Build/HUAWEIEML-AL00) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.108 baidu.sogo.uc.UCBrowser/11.9.4.974 UWS/2.13.1.48 Mobile Safari/537.36 AliApp(DingTalk/4.5.11) com.alibaba.a'),
(1605742774, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/content/about.html', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1605742766, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1605742773, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1605742773, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/cart.php', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1605742773, '167.114.175.39', '167.114.175.39, 167.114.175.39', 'www.docs-proekt.shop/pages.php?view=order', 'https://www.google.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0'),
(1605740535, '5.45.207.105', '5.45.207.105, 5.45.207.105', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605740539, '5.45.207.112', '5.45.207.112, 5.45.207.112', 'docs-proekt.shop/', '', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.268'),
(1605739541, '175.44.42.58', '175.44.42.58, 175.44.42.58', 'docs-proekt.shop/', 'http://rgwr.sjjksy.org/blog/84814925/view/', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0'),
(1605733361, '88.150.240.189', '88.150.240.189, 88.150.240.189', 'docs-proekt.shop/', '', 'Foregenix Web Scan 1.100000 (www.foregenix.com/scan)'),
(1605736233, '13.66.139.8', '13.66.139.8, 13.66.139.8', 'www.docs-proekt.shop/catalog/zhilihe-doma/Proekt-prokola-pod-federalnoj-zheleznoj-dorogoj.html', '', 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)'),
(1605733362, '88.150.240.189', '88.150.240.189, 88.150.240.189', 'docs-proekt.shop/', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36'),
(1605733361, '88.150.240.189', '88.150.240.189, 88.150.240.189', 'docs-proekt.shop/magento_version/', '', 'Foregenix Web Scan 1.100000 (www.foregenix.com/scan)'),
(1605733361, '88.150.240.189', '88.150.240.189, 88.150.240.189', 'docs-proekt.shop/', '', 'Foregenix Web Scan 1.100000 (www.foregenix.com/scan)'),
(1605733361, '88.150.240.189', '88.150.240.189, 88.150.240.189', 'docs-proekt.shop/', '', 'Foregenix Web Scan 1.100000 (www.foregenix.com/scan)');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_wm_merchant`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_wm_merchant`;
CREATE TABLE `arwm_wm_merchant` (
  `orderid` int(11) UNSIGNED NOT NULL,
  `wmm_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_wm_merchant_conf`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_wm_merchant_conf`;
CREATE TABLE `arwm_wm_merchant_conf` (
  `sname` varchar(64) NOT NULL,
  `svalue` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_wm_merchant_conf`
--

INSERT INTO `arwm_wm_merchant_conf` (`sname`, `svalue`) VALUES
('test_mode', '0'),
('msk', 'N9Z5/u+kNYcc4o8='),
('ck', 'NDk4YzVkZWQ=');

-- --------------------------------------------------------

--
-- Структура таблицы `arwm_wm_purses`
--
-- Создание: Апр 19 2020 г., 23:08
-- Последнее обновление: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `arwm_wm_purses`;
CREATE TABLE `arwm_wm_purses` (
  `pursetype` char(1) NOT NULL,
  `currency_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `pursenumber` char(13) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arwm_wm_purses`
--

INSERT INTO `arwm_wm_purses` (`pursetype`, `currency_id`, `pursenumber`) VALUES
('Z', 3, ''),
('E', 0, ''),
('R', 1, 'P139828524241'),
('U', 0, ''),
('B', 0, ''),
('Y', 0, ''),
('K', 0, ''),
('V', 0, ''),
('G', 0, ''),
('H', 0, ''),
('X', 0, ''),
('D', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_commentmeta`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_commentmeta`;
CREATE TABLE `cms_wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_commentmeta`
--

INSERT INTO `cms_wp_commentmeta` (`meta_id`, `comment_id`, `meta_key`, `meta_value`) VALUES
(1, 2, 'akismet_error', '1588939641'),
(2, 2, 'akismet_history', 'a:3:{s:4:\"time\";d:1588939641.298668;s:5:\"event\";s:11:\"check-error\";s:4:\"meta\";a:1:{s:8:\"response\";s:7:\"invalid\";}}'),
(4, 2, 'akismet_delayed_moderation_email', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_comments`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_comments`;
CREATE TABLE `cms_wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_comments`
--

INSERT INTO `cms_wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Mr WordPress', '', 'https://wordpress.org/', '', '2019-12-30 10:34:21', '2019-12-30 10:34:21', 'Hi, this is a comment.\nTo delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.', 0, '1', '', '', 0, 0),
(2, 1, 'Irenlwjz', 'an.t.o.n.ov.vital.iy.9.44@gmail.com', 'https://drive.google.com/file/d/1mq1pFhgixRuaotmr5A5IAQ0czSfRG--d/view?usp=sharing', '195.181.170.88', '2020-05-08 15:07:21', '2020-05-08 12:07:21', 'Доброго времени суток господа \r\nНаша предприятие мы занимаем первое место по качеству и цене производства аква продукции в Киеве. Вас может заинтерсовать: \r\n<a href=\"https://drive.google.com/file/d/1mq1pFhgixRuaotmr5A5IAQ0czSfRG--d/view?usp=sharing\" rel=\"nofollow ugc\">Водопады по стеклу</a> – сделаете Ваше помещение уютнее и привлекательнее, создаст теплую релаксирующую обстановку. \r\nhttps://drive.google.com/file/d/1mq1pFhgixRuaotmr5A5IAQ0czSfRG--d/view?usp=sharing - узнать подробнее здесь.', 0, '0', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_links`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_links`;
CREATE TABLE `cms_wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_options`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_options`;
CREATE TABLE `cms_wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_options`
--

INSERT INTO `cms_wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://docs-proekt.shop', 'yes'),
(2, 'home', 'http://docs-proekt.shop', 'yes'),
(3, 'blogname', 'docs-proekt.shop', 'yes'),
(4, 'blogdescription', 'Just another WordPress site', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'sav27951@yandex.ru', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '1', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'd.m.Y', 'yes'),
(24, 'time_format', 'H:i', 'yes'),
(25, 'links_updated_date_format', 'd.m.Y H:i', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:90:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:4:{i:0;s:19:\"akismet/akismet.php\";i:1;s:33:\"classic-editor/classic-editor.php\";i:2;s:29:\"health-check/health-check.php\";i:3;s:9:\"hello.php\";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '3', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'twentysixteen', 'yes'),
(41, 'stylesheet', 'twentysixteen', 'yes'),
(42, 'comment_whitelist', '1', 'yes'),
(43, 'blacklist_keys', '', 'no'),
(44, 'comment_registration', '0', 'yes'),
(45, 'html_type', 'text/html', 'yes'),
(46, 'use_trackback', '0', 'yes'),
(47, 'default_role', 'subscriber', 'yes'),
(48, 'db_version', '45805', 'yes'),
(49, 'uploads_use_yearmonth_folders', '1', 'yes'),
(50, 'upload_path', '', 'yes'),
(51, 'blog_public', '1', 'yes'),
(52, 'default_link_category', '2', 'yes'),
(53, 'show_on_front', 'posts', 'yes'),
(54, 'tag_base', '', 'yes'),
(55, 'show_avatars', '1', 'yes'),
(56, 'avatar_rating', 'G', 'yes'),
(57, 'upload_url_path', '', 'yes'),
(58, 'thumbnail_size_w', '150', 'yes'),
(59, 'thumbnail_size_h', '150', 'yes'),
(60, 'thumbnail_crop', '1', 'yes'),
(61, 'medium_size_w', '300', 'yes'),
(62, 'medium_size_h', '300', 'yes'),
(63, 'avatar_default', 'mystery', 'yes'),
(64, 'large_size_w', '1024', 'yes'),
(65, 'large_size_h', '1024', 'yes'),
(66, 'image_default_link_type', 'none', 'yes'),
(67, 'image_default_size', '', 'yes'),
(68, 'image_default_align', '', 'yes'),
(69, 'close_comments_for_old_posts', '0', 'yes'),
(70, 'close_comments_days_old', '14', 'yes'),
(71, 'thread_comments', '1', 'yes'),
(72, 'thread_comments_depth', '5', 'yes'),
(73, 'page_comments', '0', 'yes'),
(74, 'comments_per_page', '50', 'yes'),
(75, 'default_comments_page', 'newest', 'yes'),
(76, 'comment_order', 'asc', 'yes'),
(77, 'sticky_posts', 'a:0:{}', 'yes'),
(78, 'widget_categories', 'a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(79, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(80, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(81, 'uninstall_plugins', 'a:1:{s:33:\"classic-editor/classic-editor.php\";a:2:{i:0;s:14:\"Classic_Editor\";i:1;s:9:\"uninstall\";}}', 'no'),
(82, 'timezone_string', '', 'yes'),
(83, 'page_for_posts', '0', 'yes'),
(84, 'page_on_front', '0', 'yes'),
(85, 'default_post_format', '0', 'yes'),
(86, 'link_manager_enabled', '0', 'yes'),
(87, 'finished_splitting_shared_terms', '1', 'yes'),
(88, 'site_icon', '5', 'yes'),
(89, 'medium_large_size_w', '768', 'yes'),
(90, 'medium_large_size_h', '0', 'yes'),
(91, 'wp_page_for_privacy_policy', '3', 'yes'),
(92, 'show_comments_cookies_opt_in', '1', 'yes'),
(93, 'initial_db_version', '44719', 'yes'),
(94, 'cms_wp_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(95, 'fresh_site', '0', 'yes'),
(96, 'WPLANG', 'ru_RU', 'yes'),
(97, 'widget_search', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(98, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(99, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(100, 'widget_archives', 'a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(101, 'widget_meta', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(102, 'sidebars_widgets', 'a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}', 'yes'),
(103, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(104, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(105, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(107, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(108, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(112, 'cron', 'a:9:{i:1607340012;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1607340026;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1607340027;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1607341275;a:1:{s:40:\"health-check-scheduled-site-status-check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1607342841;a:1:{s:24:\"akismet_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1607345923;a:1:{s:29:\"akismet_schedule_cron_recheck\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:2:{s:8:\"schedule\";b:0;s:4:\"args\";a:0:{}}}}i:1607383212;a:3:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1607423662;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}', 'yes'),
(113, 'theme_mods_twentynineteen', 'a:1:{s:18:\"custom_css_post_id\";i:-1;}', 'yes'),
(129, '_site_transient_timeout_community-events-df9d181f89f6e4cb291858d113d9eafb', '1556666428', 'no'),
(169, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:18:\"sav27951@yandex.ru\";s:7:\"version\";s:5:\"5.3.3\";s:9:\"timestamp\";i:1588938105;}', 'no'),
(170, 'recovery_keys', 'a:0:{}', 'yes'),
(172, 'admin_email_lifespan', '1593439593', 'yes'),
(173, 'db_upgraded', '', 'yes'),
(176, 'can_compress_scripts', '0', 'no'),
(193, 'recently_activated', 'a:0:{}', 'yes'),
(194, 'widget_akismet_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(196, '_transient_health-check-site-status-result', '{\"good\":9,\"recommended\":6,\"critical\":2}', 'yes'),
(230, 'theme_mods_twentysixteen', 'a:1:{s:18:\"custom_css_post_id\";i:-1;}', 'yes'),
(387, '_transient_timeout_feed_126d1ca39d75da07beec8b892738427b', '1578602330', 'no'),
(390, '_transient_timeout_feed_d117b5738fbd35bd8c0391cda1f2b5d9', '1578602331', 'no'),
(1114, '_transient_is_multi_author', '0', 'yes'),
(1115, '_transient_twentysixteen_categories', '1', 'yes'),
(1146, 'category_children', 'a:0:{}', 'yes'),
(1155, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:6:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:7:\"upgrade\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.5.3.zip\";s:6:\"locale\";s:5:\"ru_RU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.5.3.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.3\";s:7:\"version\";s:5:\"5.5.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";}i:1;O:8:\"stdClass\":10:{s:8:\"response\";s:7:\"upgrade\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.3.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.3.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.5.3-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.5.3-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.3\";s:7:\"version\";s:5:\"5.5.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";}i:2;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.5.3.zip\";s:6:\"locale\";s:5:\"ru_RU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.5.3.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.3\";s:7:\"version\";s:5:\"5.5.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:3;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.5.2.zip\";s:6:\"locale\";s:5:\"ru_RU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.5.2.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.2\";s:7:\"version\";s:5:\"5.5.2\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:4;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.4.4.zip\";s:6:\"locale\";s:5:\"ru_RU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.4.4.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.4.4\";s:7:\"version\";s:5:\"5.4.4\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:5;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.3.6.zip\";s:6:\"locale\";s:5:\"ru_RU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.3.6.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.3.6\";s:7:\"version\";s:5:\"5.3.6\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}}s:12:\"last_checked\";i:1607365570;s:15:\"version_checked\";s:5:\"5.3.2\";s:12:\"translations\";a:0:{}}', 'no'),
(1156, '_site_transient_update_themes', 'O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1607365570;s:7:\"checked\";a:4:{s:13:\"twentyfifteen\";s:3:\"2.5\";s:15:\"twentyseventeen\";s:3:\"2.2\";s:13:\"twentysixteen\";s:3:\"2.0\";s:12:\"twentytwenty\";s:3:\"1.1\";}s:8:\"response\";a:4:{s:13:\"twentyfifteen\";a:6:{s:5:\"theme\";s:13:\"twentyfifteen\";s:11:\"new_version\";s:3:\"2.7\";s:3:\"url\";s:43:\"https://wordpress.org/themes/twentyfifteen/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/theme/twentyfifteen.2.7.zip\";s:8:\"requires\";b:0;s:12:\"requires_php\";s:5:\"5.2.4\";}s:15:\"twentyseventeen\";a:6:{s:5:\"theme\";s:15:\"twentyseventeen\";s:11:\"new_version\";s:3:\"2.4\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentyseventeen/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentyseventeen.2.4.zip\";s:8:\"requires\";s:3:\"4.7\";s:12:\"requires_php\";s:5:\"5.2.4\";}s:13:\"twentysixteen\";a:6:{s:5:\"theme\";s:13:\"twentysixteen\";s:11:\"new_version\";s:3:\"2.2\";s:3:\"url\";s:43:\"https://wordpress.org/themes/twentysixteen/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/theme/twentysixteen.2.2.zip\";s:8:\"requires\";s:3:\"4.4\";s:12:\"requires_php\";s:5:\"5.2.4\";}s:12:\"twentytwenty\";a:6:{s:5:\"theme\";s:12:\"twentytwenty\";s:11:\"new_version\";s:3:\"1.5\";s:3:\"url\";s:42:\"https://wordpress.org/themes/twentytwenty/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/theme/twentytwenty.1.5.zip\";s:8:\"requires\";s:3:\"4.7\";s:12:\"requires_php\";s:5:\"5.2.4\";}}s:12:\"translations\";a:0:{}}', 'no'),
(1157, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1588938106;s:7:\"checked\";a:4:{s:19:\"akismet/akismet.php\";s:5:\"4.1.2\";s:33:\"classic-editor/classic-editor.php\";s:3:\"1.5\";s:29:\"health-check/health-check.php\";s:5:\"1.4.2\";s:9:\"hello.php\";s:5:\"1.7.2\";}s:8:\"response\";a:2:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"4.1.5\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.4.1.5.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:5:\"5.4.1\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:29:\"health-check/health-check.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:26:\"w.org/plugins/health-check\";s:4:\"slug\";s:12:\"health-check\";s:6:\"plugin\";s:29:\"health-check/health-check.php\";s:11:\"new_version\";s:5:\"1.4.4\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/health-check/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/health-check.1.4.4.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:65:\"https://ps.w.org/health-check/assets/icon-256x256.png?rev=1823210\";s:2:\"1x\";s:57:\"https://ps.w.org/health-check/assets/icon.svg?rev=1828244\";s:3:\"svg\";s:57:\"https://ps.w.org/health-check/assets/icon.svg?rev=1828244\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/health-check/assets/banner-1544x500.png?rev=1823210\";s:2:\"1x\";s:67:\"https://ps.w.org/health-check/assets/banner-772x250.png?rev=1823210\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:5:\"5.4.1\";s:12:\"requires_php\";s:3:\"5.2\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:2:{s:33:\"classic-editor/classic-editor.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/classic-editor\";s:4:\"slug\";s:14:\"classic-editor\";s:6:\"plugin\";s:33:\"classic-editor/classic-editor.php\";s:11:\"new_version\";s:3:\"1.5\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/classic-editor/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/classic-editor.1.5.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671\";s:2:\"1x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671\";s:2:\"1x\";s:69:\"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676\";}s:11:\"banners_rtl\";a:0:{}}s:9:\"hello.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}}}}', 'no'),
(1158, 'akismet_spam_count', '1', 'yes'),
(1587, '_transient_doing_cron', '1607365569.1969079971313476562500', 'yes'),
(1588, '_site_transient_timeout_theme_roots', '1607367369', 'no'),
(1589, '_site_transient_theme_roots', 'a:4:{s:13:\"twentyfifteen\";s:7:\"/themes\";s:15:\"twentyseventeen\";s:7:\"/themes\";s:13:\"twentysixteen\";s:7:\"/themes\";s:12:\"twentytwenty\";s:7:\"/themes\";}', 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_postmeta`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_postmeta`;
CREATE TABLE `cms_wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_postmeta`
--

INSERT INTO `cms_wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 5, '_wp_attached_file', '2020/01/favicon.jpeg'),
(3, 5, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:128;s:6:\"height\";i:128;s:4:\"file\";s:20:\"2020/01/favicon.jpeg\";s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_posts`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_posts`;
CREATE TABLE `cms_wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(255) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_posts`
--

INSERT INTO `cms_wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2019-05-10 03:48:21', '2019-05-10 03:48:21', 'Welcome to WordPress. This is your first post. Edit or delete it, then start writing!', 'Hello world!', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2019-05-10 03:48:21', '2019-05-10 03:48:21', '', 0, 'http://docs-proekt.shop/?p=1', 0, 'post', '', 1),
(2, 1, '2019-05-10 03:48:21', '2019-05-10 03:48:21', 'This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\n\n<blockquote>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</blockquote>\n\n...or something like this:\n\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>\n\nAs a new WordPress user, you should go to <a href=\"http://docs-proekt.shop/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2019-05-10 03:48:21', '2019-05-10 03:48:21', '', 0, 'http://docs-proekt.shop?page_id=2', 0, 'page', '', 0),
(5, 1, '2020-01-09 11:41:19', '2020-01-09 08:41:19', '', 'favicon', '', 'inherit', 'open', 'closed', '', 'favicon', '', '', '2020-01-09 11:41:19', '2020-01-09 08:41:19', '', 0, 'http://docs-proekt.shop/wp-content/uploads/2020/01/favicon.jpeg', 0, 'attachment', 'image/jpeg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_termmeta`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_termmeta`;
CREATE TABLE `cms_wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_terms`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_terms`;
CREATE TABLE `cms_wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_terms`
--

INSERT INTO `cms_wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_term_relationships`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_term_relationships`;
CREATE TABLE `cms_wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_term_relationships`
--

INSERT INTO `cms_wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_term_taxonomy`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_term_taxonomy`;
CREATE TABLE `cms_wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_term_taxonomy`
--

INSERT INTO `cms_wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_usermeta`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_usermeta`;
CREATE TABLE `cms_wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_usermeta`
--

INSERT INTO `cms_wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'alensav'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'comment_shortcuts', 'false'),
(7, 1, 'admin_color', 'fresh'),
(8, 1, 'use_ssl', '0'),
(9, 1, 'show_admin_bar_front', 'true'),
(10, 1, 'cms_wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(11, 1, 'cms_wp_user_level', '10'),
(12, 1, 'dismissed_wp_pointers', ''),
(13, 1, 'show_welcome_panel', '1'),
(14, 1, 'syntax_highlighting', 'true'),
(15, 1, 'locale', ''),
(16, 1, 'session_tokens', 'a:2:{s:64:\"f07a8c2b54be56d767c9db5702795d7afa561c125a542577e15b01c5f58d4599\";a:4:{s:10:\"expiration\";i:1579097177;s:2:\"ip\";s:12:\"80.254.127.1\";s:2:\"ua\";s:74:\"Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:71.0) Gecko/20100101 Firefox/71.0\";s:5:\"login\";i:1577887577;}s:64:\"5614cb61dc42114aa959559c4f02db609be3182d207ef311ef51fe7e0adda3d2\";a:4:{s:10:\"expiration\";i:1579768723;s:2:\"ip\";s:12:\"80.254.127.1\";s:2:\"ua\";s:135:\"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 YaBrowser/19.12.2.252 Yowser/2.5 Safari/537.36\";s:5:\"login\";i:1578559123;}}'),
(17, 1, 'cms_wp_dashboard_quick_press_last_post_id', '4'),
(18, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:12:\"80.254.127.0\";}'),
(19, 1, 'cms_wp_user-settings', 'libraryContent=browse'),
(20, 1, 'cms_wp_user-settings-time', '1577887887');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_wp_users`
--
-- Создание: Апр 19 2020 г., 23:08
--

DROP TABLE IF EXISTS `cms_wp_users`;
CREATE TABLE `cms_wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_wp_users`
--

INSERT INTO `cms_wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'alensav', '$P$BWFKkVSY2kU1eXoYcR3DOSMkJIDig81', 'alensav', 'sav27951@yandex.ru', '', '2019-12-30 10:34:22', '', 0, 'alensav');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `arwm_add_fields`
--
ALTER TABLE `arwm_add_fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Индексы таблицы `arwm_add_fields_variants`
--
ALTER TABLE `arwm_add_fields_variants`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Индексы таблицы `arwm_admin`
--
ALTER TABLE `arwm_admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Индексы таблицы `arwm_cache`
--
ALTER TABLE `arwm_cache`
  ADD PRIMARY KEY (`reqid`),
  ADD KEY `request` (`request`(255));

--
-- Индексы таблицы `arwm_categories`
--
ALTER TABLE `arwm_categories`
  ADD PRIMARY KEY (`catid`),
  ADD KEY `parent` (`parent`);

--
-- Индексы таблицы `arwm_cntlastip`
--
ALTER TABLE `arwm_cntlastip`
  ADD KEY `lastip` (`lastip`);

--
-- Индексы таблицы `arwm_content`
--
ALTER TABLE `arwm_content`
  ADD PRIMARY KEY (`pname`);

--
-- Индексы таблицы `arwm_countries`
--
ALTER TABLE `arwm_countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Индексы таблицы `arwm_currencies`
--
ALTER TABLE `arwm_currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Индексы таблицы `arwm_deliverymethods`
--
ALTER TABLE `arwm_deliverymethods`
  ADD PRIMARY KEY (`dmid`);

--
-- Индексы таблицы `arwm_gallery`
--
ALTER TABLE `arwm_gallery`
  ADD PRIMARY KEY (`imgid`),
  ADD KEY `itemid` (`itemid`);

--
-- Индексы таблицы `arwm_items`
--
ALTER TABLE `arwm_items`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `catid` (`catid`,`visible`),
  ADD KEY `mnf_id` (`mnf_id`),
  ADD KEY `upd_date` (`upd_date`);
ALTER TABLE `arwm_items` ADD FULLTEXT KEY `search` (`sku`,`title`,`short_descript`,`long_descript`);

--
-- Индексы таблицы `arwm_item_categories`
--
ALTER TABLE `arwm_item_categories`
  ADD KEY `catid` (`catid`),
  ADD KEY `itemid` (`itemid`),
  ADD KEY `sortid` (`sortid`);

--
-- Индексы таблицы `arwm_item_comments`
--
ALTER TABLE `arwm_item_comments`
  ADD PRIMARY KEY (`comid`),
  ADD KEY `itemid` (`itemid`);

--
-- Индексы таблицы `arwm_item_options`
--
ALTER TABLE `arwm_item_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Индексы таблицы `arwm_item_options_match`
--
ALTER TABLE `arwm_item_options_match`
  ADD KEY `itemid` (`itemid`);

--
-- Индексы таблицы `arwm_item_options_values`
--
ALTER TABLE `arwm_item_options_values`
  ADD PRIMARY KEY (`option_value_id`);

--
-- Индексы таблицы `arwm_mainitems`
--
ALTER TABLE `arwm_mainitems`
  ADD PRIMARY KEY (`main_itemid`),
  ADD KEY `itemid` (`main_itemid`);

--
-- Индексы таблицы `arwm_manufacturers`
--
ALTER TABLE `arwm_manufacturers`
  ADD PRIMARY KEY (`mnf_id`),
  ADD KEY `sortid` (`sortid`);

--
-- Индексы таблицы `arwm_menu`
--
ALTER TABLE `arwm_menu`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `menuid` (`menuid`);

--
-- Индексы таблицы `arwm_news`
--
ALTER TABLE `arwm_news`
  ADD PRIMARY KEY (`newsid`),
  ADD KEY `date` (`date`);

--
-- Индексы таблицы `arwm_orders`
--
ALTER TABLE `arwm_orders`
  ADD PRIMARY KEY (`orderid`);

--
-- Индексы таблицы `arwm_orders_add_fields_values`
--
ALTER TABLE `arwm_orders_add_fields_values`
  ADD PRIMARY KEY (`oafvid`),
  ADD KEY `orderid` (`orderid`);

--
-- Индексы таблицы `arwm_orders_items`
--
ALTER TABLE `arwm_orders_items`
  ADD PRIMARY KEY (`oiid`),
  ADD KEY `orderid` (`orderid`);

--
-- Индексы таблицы `arwm_order_statuses`
--
ALTER TABLE `arwm_order_statuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Индексы таблицы `arwm_payment_blanks`
--
ALTER TABLE `arwm_payment_blanks`
  ADD PRIMARY KEY (`blank_id`),
  ADD KEY `paymethod_id` (`paymethod_id`);

--
-- Индексы таблицы `arwm_paymethods`
--
ALTER TABLE `arwm_paymethods`
  ADD PRIMARY KEY (`pmid`);

--
-- Индексы таблицы `arwm_paymethods_currencies`
--
ALTER TABLE `arwm_paymethods_currencies`
  ADD KEY `pmid` (`pmid`);

--
-- Индексы таблицы `arwm_paymethods_deliverymethods`
--
ALTER TABLE `arwm_paymethods_deliverymethods`
  ADD KEY `pmid` (`pmid`);

--
-- Индексы таблицы `arwm_pm_data`
--
ALTER TABLE `arwm_pm_data`
  ADD KEY `mod_name` (`mod_name`);

--
-- Индексы таблицы `arwm_pm_settings`
--
ALTER TABLE `arwm_pm_settings`
  ADD KEY `mod_name` (`mod_name`);

--
-- Индексы таблицы `arwm_settings`
--
ALTER TABLE `arwm_settings`
  ADD KEY `type` (`type`);

--
-- Индексы таблицы `arwm_txtsettings`
--
ALTER TABLE `arwm_txtsettings`
  ADD PRIMARY KEY (`setname`);

--
-- Индексы таблицы `arwm_users`
--
ALTER TABLE `arwm_users`
  ADD PRIMARY KEY (`userid`);

--
-- Индексы таблицы `arwm_users_groups`
--
ALTER TABLE `arwm_users_groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Индексы таблицы `arwm_users_groups_discounts`
--
ALTER TABLE `arwm_users_groups_discounts`
  ADD PRIMARY KEY (`did`);

--
-- Индексы таблицы `arwm_wm_merchant`
--
ALTER TABLE `arwm_wm_merchant`
  ADD PRIMARY KEY (`orderid`);

--
-- Индексы таблицы `cms_wp_commentmeta`
--
ALTER TABLE `cms_wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `cms_wp_comments`
--
ALTER TABLE `cms_wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Индексы таблицы `cms_wp_links`
--
ALTER TABLE `cms_wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Индексы таблицы `cms_wp_options`
--
ALTER TABLE `cms_wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Индексы таблицы `cms_wp_postmeta`
--
ALTER TABLE `cms_wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `cms_wp_posts`
--
ALTER TABLE `cms_wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Индексы таблицы `cms_wp_termmeta`
--
ALTER TABLE `cms_wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `cms_wp_terms`
--
ALTER TABLE `cms_wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Индексы таблицы `cms_wp_term_relationships`
--
ALTER TABLE `cms_wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Индексы таблицы `cms_wp_term_taxonomy`
--
ALTER TABLE `cms_wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Индексы таблицы `cms_wp_usermeta`
--
ALTER TABLE `cms_wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `cms_wp_users`
--
ALTER TABLE `cms_wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `arwm_add_fields`
--
ALTER TABLE `arwm_add_fields`
  MODIFY `field_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `arwm_add_fields_variants`
--
ALTER TABLE `arwm_add_fields_variants`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `arwm_admin`
--
ALTER TABLE `arwm_admin`
  MODIFY `adminid` mediumint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `arwm_cache`
--
ALTER TABLE `arwm_cache`
  MODIFY `reqid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `arwm_currencies`
--
ALTER TABLE `arwm_currencies`
  MODIFY `currency_id` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `arwm_deliverymethods`
--
ALTER TABLE `arwm_deliverymethods`
  MODIFY `dmid` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `arwm_gallery`
--
ALTER TABLE `arwm_gallery`
  MODIFY `imgid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `arwm_items`
--
ALTER TABLE `arwm_items`
  MODIFY `itemid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT для таблицы `arwm_item_comments`
--
ALTER TABLE `arwm_item_comments`
  MODIFY `comid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `arwm_item_options`
--
ALTER TABLE `arwm_item_options`
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `arwm_item_options_values`
--
ALTER TABLE `arwm_item_options_values`
  MODIFY `option_value_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT для таблицы `arwm_menu`
--
ALTER TABLE `arwm_menu`
  MODIFY `itemid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `arwm_news`
--
ALTER TABLE `arwm_news`
  MODIFY `newsid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `arwm_orders`
--
ALTER TABLE `arwm_orders`
  MODIFY `orderid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=602;

--
-- AUTO_INCREMENT для таблицы `arwm_orders_add_fields_values`
--
ALTER TABLE `arwm_orders_add_fields_values`
  MODIFY `oafvid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `arwm_orders_items`
--
ALTER TABLE `arwm_orders_items`
  MODIFY `oiid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `arwm_order_statuses`
--
ALTER TABLE `arwm_order_statuses`
  MODIFY `status_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `arwm_payment_blanks`
--
ALTER TABLE `arwm_payment_blanks`
  MODIFY `blank_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `arwm_paymethods`
--
ALTER TABLE `arwm_paymethods`
  MODIFY `pmid` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `arwm_users`
--
ALTER TABLE `arwm_users`
  MODIFY `userid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `arwm_users_groups`
--
ALTER TABLE `arwm_users_groups`
  MODIFY `groupid` mediumint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `arwm_users_groups_discounts`
--
ALTER TABLE `arwm_users_groups_discounts`
  MODIFY `did` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cms_wp_commentmeta`
--
ALTER TABLE `cms_wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cms_wp_comments`
--
ALTER TABLE `cms_wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `cms_wp_links`
--
ALTER TABLE `cms_wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cms_wp_options`
--
ALTER TABLE `cms_wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1590;

--
-- AUTO_INCREMENT для таблицы `cms_wp_postmeta`
--
ALTER TABLE `cms_wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `cms_wp_posts`
--
ALTER TABLE `cms_wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `cms_wp_termmeta`
--
ALTER TABLE `cms_wp_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cms_wp_terms`
--
ALTER TABLE `cms_wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `cms_wp_term_taxonomy`
--
ALTER TABLE `cms_wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `cms_wp_usermeta`
--
ALTER TABLE `cms_wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `cms_wp_users`
--
ALTER TABLE `cms_wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
