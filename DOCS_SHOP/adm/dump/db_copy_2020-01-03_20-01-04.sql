# ArwShop Market dump v3.3
# DB_PREFIX: arwm_

SET NAMES utf8;


# Structure of table arwm_add_fields
DROP TABLE IF EXISTS `arwm_add_fields`;
CREATE TABLE `arwm_add_fields` (
  `field_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(64) NOT NULL,
  `type` tinyint(2) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `use_in_order` tinyint(1) NOT NULL,
  `use_in_feedback` tinyint(1) NOT NULL,
  `width` int(11) unsigned NOT NULL,
  `height` int(11) unsigned NOT NULL,
  `def_value` text NOT NULL,
  `def_from_last_order` tinyint(1) unsigned NOT NULL,
  `placeholder` text NOT NULL,
  `contexthelp` text NOT NULL,
  `add_attributes` text NOT NULL,
  `pay_methods` text NOT NULL,
  `sortid` mediumint(6) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_add_fields
INSERT INTO arwm_add_fields VALUES('1','example','1','Пример дополнительного поля','0','0','1','1','39','0','','0','','','','','0');
INSERT INTO arwm_add_fields VALUES('2','how_about','1','Откуда Вы о нас узнали?','0','0','1','1','39','0','','0','','','','','0');


# Structure of table arwm_add_fields_variants
DROP TABLE IF EXISTS `arwm_add_fields_variants`;
CREATE TABLE `arwm_add_fields_variants` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `def` tinyint(1) unsigned NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `field_id` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_add_fields_variants


# Structure of table arwm_admin
DROP TABLE IF EXISTS `arwm_admin`;
CREATE TABLE `arwm_admin` (
  `adminid` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_admin
INSERT INTO arwm_admin VALUES('1','4f11ad9c6802a7c5df56b933ced9a7f2','976e17cfaadf5773663f4333efd7b752','main_admin');


# Structure of table arwm_cache
DROP TABLE IF EXISTS `arwm_cache`;
CREATE TABLE `arwm_cache` (
  `reqid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `request` text NOT NULL,
  `mdate` int(11) unsigned NOT NULL,
  `http_code` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`reqid`),
  KEY `request` (`request`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Structure of table arwm_categories
DROP TABLE IF EXISTS `arwm_categories`;
CREATE TABLE `arwm_categories` (
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fcatname` varchar(255) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `menu_img` varchar(255) NOT NULL,
  `main_img` varchar(255) NOT NULL,
  `count` int(6) unsigned NOT NULL DEFAULT '0',
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `metatags` text NOT NULL,
  `special` mediumtext NOT NULL,
  `fulltitle` text NOT NULL,
  `sortid` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_categories
INSERT INTO arwm_categories VALUES('0','','0','','<h2><span style=\"font-size: 14pt; color: #0000ff;\">&nbsp; <br /><a href=\"http://www.arhiv-proekt.ru\" target=\"_blank\" rel=\"noopener\">АРХИВ проектов <span style=\"color: red; font-size: large;\"> www.arhiv-proekt.ru</span>;</a>&nbsp;&nbsp;Проектная документация на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</span></h2>','','','','0','DOCS_SHOP','','Проект, документация, водотведение, коллектор, разработка, строительство, жилые дома. коттеджи, объекты, здравохранения, дошкольные учреждения. школы','','','Warning! This is special line for main page. Do not delete this record with catid = 0!','0');
INSERT INTO arwm_categories VALUES('1','Водоснабжение','0','Проекты водоснабжения','<h2>Архив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>\r\n<h3>Для разработчиков проектной документации, строителей и студентов, а также для всех заинтересованных лиц</h3>\r\n<p><span style=\"font-size: 14pt;\"><strong>ВОДОСНАБЖЕНИЕ</strong></span></p>','','','','1','Проекты водоснабжения','Проекты водоснабжения','проект, документация, водоснабжение, водопровод','','','Проекты водоснабжения','0');
INSERT INTO arwm_categories VALUES('2','Проекты водоотведения','0','Проекты водоотведения','<h2>Архив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</h2>\r\n<p><span style=\"font-size: 14pt;\"><strong>ВОДООТВЕДЕНИЕ</strong></span></p>','','','','3','Проекты водоотведения','Проекты водоотведения','Проект, документация, водотведение, коллектор, разработка','','','Проекты водоотведения','0');
INSERT INTO arwm_categories VALUES('3','Proekti-avtomobilnih-dorog','0','Проекты автомобильных дорог','','','','','2','','','Проект, документация, разработка, автомобильные. дороги','','','Проекты автомобильных дорог','0');
INSERT INTO arwm_categories VALUES('4','Proekti-zhilih-domov','0','Проекты жилых домов','','','','','1','','','Проект, документация, разработка, жилые. дома','','','Проекты жилых домов','0');
INSERT INTO arwm_categories VALUES('5','zhilihe-doma','0','Проекты на линейные инженерные сети','','','','','0','','','Проект, документация, разработка, линейные,  инженерные,  сети','','','Проекты на линейные инженерные сети','0');
INSERT INTO arwm_categories VALUES('6','Proekti-doshkolnih-uchrezhdenij','0','Проекты дошкольных учреждений','','','','','2','','','Проект, документация,  разработка, дошкольные,  учреждения','','','Проекты дошкольных учреждений','0');
INSERT INTO arwm_categories VALUES('7','Proekti-uchrezhdenij-kulturi','0','Проекты учреждений культуры','','','','','2','','','Проект, документация,  разработка, учреждения. культуры','','','Проекты учреждений культуры','0');
INSERT INTO arwm_categories VALUES('8','Proekti-lechebnih-uchrezhdenij','0','Проекты лечебных учреждений','','','','','3','','','Проект, документация,  разработка, лечебные, учреждения','','','Проекты лечебных учреждений','0');
INSERT INTO arwm_categories VALUES('9','Biblioteka-spravochnoj-i-normativnoj-dokumentatsii','0','Библиотека справочной и нормативной документации','','','','','0','','','Проект, документация,  разработка, библиотека, справочная, нормативная, документация','','','Библиотека справочной и нормативной документации','0');
INSERT INTO arwm_categories VALUES('10','Proekti-na-proizvodstvennie-obekti','0','Проекты производственных объектов','','','','','3','','','Проект, документация, водотведение, разработка, производственные,  объекты','','','Проекты производственных объектов','0');
INSERT INTO arwm_categories VALUES('11','Proekti-uchebnih-uchrezhdenij','0','Проекты учебных учреждений','<p>Проекты учебных учреждений</p>','','','','1','','','проект. учебный, учреждение','','','Проекты учебных учреждений','0');


# Structure of table arwm_cntlastip
DROP TABLE IF EXISTS `arwm_cntlastip`;
CREATE TABLE `arwm_cntlastip` (
  `lastip` varchar(255) NOT NULL,
  KEY `lastip` (`lastip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_cntlastip
INSERT INTO arwm_cntlastip VALUES('141.8.142.153');
INSERT INTO arwm_cntlastip VALUES('141.8.142.190');
INSERT INTO arwm_cntlastip VALUES('141.8.142.2');
INSERT INTO arwm_cntlastip VALUES('141.8.142.48');
INSERT INTO arwm_cntlastip VALUES('141.8.183.108');
INSERT INTO arwm_cntlastip VALUES('141.8.183.58');
INSERT INTO arwm_cntlastip VALUES('141.8.183.70');
INSERT INTO arwm_cntlastip VALUES('141.8.188.11');
INSERT INTO arwm_cntlastip VALUES('178.154.171.109');
INSERT INTO arwm_cntlastip VALUES('178.154.171.111');
INSERT INTO arwm_cntlastip VALUES('178.154.171.146');
INSERT INTO arwm_cntlastip VALUES('178.154.171.155');
INSERT INTO arwm_cntlastip VALUES('178.154.171.22');
INSERT INTO arwm_cntlastip VALUES('178.154.171.72');
INSERT INTO arwm_cntlastip VALUES('178.154.171.94');
INSERT INTO arwm_cntlastip VALUES('188.40.92.81');
INSERT INTO arwm_cntlastip VALUES('37.9.113.105');
INSERT INTO arwm_cntlastip VALUES('37.9.113.169');
INSERT INTO arwm_cntlastip VALUES('37.9.113.175');
INSERT INTO arwm_cntlastip VALUES('37.9.113.192');
INSERT INTO arwm_cntlastip VALUES('37.9.113.42');
INSERT INTO arwm_cntlastip VALUES('5.255.253.35');
INSERT INTO arwm_cntlastip VALUES('5.255.253.37');
INSERT INTO arwm_cntlastip VALUES('5.45.207.46');
INSERT INTO arwm_cntlastip VALUES('66.102.9.158');
INSERT INTO arwm_cntlastip VALUES('66.249.64.184');
INSERT INTO arwm_cntlastip VALUES('66.249.70.28');
INSERT INTO arwm_cntlastip VALUES('80.254.127.1');
INSERT INTO arwm_cntlastip VALUES('87.250.224.214');
INSERT INTO arwm_cntlastip VALUES('87.250.224.71');
INSERT INTO arwm_cntlastip VALUES('87.250.224.91');
INSERT INTO arwm_cntlastip VALUES('91.189.112.7');
INSERT INTO arwm_cntlastip VALUES('93.158.166.15');
INSERT INTO arwm_cntlastip VALUES('95.108.181.123');
INSERT INTO arwm_cntlastip VALUES('95.108.213.27');
INSERT INTO arwm_cntlastip VALUES('95.108.213.50');


# Structure of table arwm_content
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
  `sortid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_content
INSERT INTO arwm_content VALUES('about','О компании','О компании','','','','','<p style=\"text-align: center;\"><span style=\"color: #0000ff;\"><strong><span style=\"font-size: 18pt;\">Интернет-магазин DOCS_SHOP.</span></strong></span> <span style=\"font-size: 14pt; color: #ff0000;\">Сайт www.docs-proekt.shop.&nbsp;</span></p>\r\n<p style=\"text-align: left;\"><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; В магазине представлен&nbsp; а</span><span style=\"font-size: 14pt;\">рхив проектной документации на строительство (реконструкцию, капремонт) гражданских и производственных объектов, включая дома, линейные - инженерные сети и автомобильные дороги.</span></strong></p>\r\n<h3><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; &nbsp;Предлагаемая документация представляет интерес для разработчиков проектной документации, строителей и студентов, а также для всех заинтересованных лиц.</span></strong></h3>\r\n<p><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; Архивные материалы могут быть использованы в качестве аналогов при разработке проектов на строительство,проектов организации строительства и дипломных проектов.</span></strong></p>\r\n<p><strong><span style=\"font-size: 14pt;\">&nbsp; &nbsp; Подробнее в&nbsp; <br /><a href=\"http://www.arhiv-proekt.ru\" target=\"_blank\" rel=\"noopener\">АРХИВЕ проектов <span style=\"color: red; font-size: large;\"> www.arhiv-proekt.ru</span>;</a></span></strong></p>','0');
INSERT INTO arwm_content VALUES('contacts','Контакты','Контакты','','','','','<p><span style=\"font-size: 14pt; color: #0000ff;\">Администрация интернет-магазина DOCS_SHOP</span></p>\r\n<p><span style=\"font-size: 14pt; color: #0000ff;\">Электронная почта&nbsp;<span style=\"background-color: #ffffff;\"> &nbsp;<span style=\"color: #ff0000;\">docs_shop@arhiv-proekt.ru</span></span></span></p>','7');


# Structure of table arwm_counter
DROP TABLE IF EXISTS `arwm_counter`;
CREATE TABLE `arwm_counter` (
  `allvisits` bigint(11) unsigned NOT NULL DEFAULT '0',
  `allhosts` bigint(11) unsigned NOT NULL DEFAULT '0',
  `todayvisits` int(11) unsigned NOT NULL DEFAULT '0',
  `todayhosts` int(11) unsigned NOT NULL DEFAULT '0',
  `day` char(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_counter
INSERT INTO arwm_counter VALUES('672','127','166','36','03');


# Structure of table arwm_countries
DROP TABLE IF EXISTS `arwm_countries`;
CREATE TABLE `arwm_countries` (
  `country_id` smallint(4) unsigned NOT NULL,
  `country_name` varchar(64) NOT NULL,
  `iso_numeric` char(3) NOT NULL,
  `iso_alpha3` char(3) NOT NULL,
  `iso_alpha2` char(2) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_countries
INSERT INTO arwm_countries VALUES('1','Afghanistan','004','AFG','AF');
INSERT INTO arwm_countries VALUES('2','Aland Islands','248','ALA','AX');
INSERT INTO arwm_countries VALUES('3','Albania','008','ALB','AL');
INSERT INTO arwm_countries VALUES('4','Algeria','012','DZA','DZ');
INSERT INTO arwm_countries VALUES('5','American Samoa','016','ASM','AS');
INSERT INTO arwm_countries VALUES('6','Andorra','020','AND','AD');
INSERT INTO arwm_countries VALUES('7','Angola','024','AGO','AO');
INSERT INTO arwm_countries VALUES('8','Anguilla','660','AIA','AI');
INSERT INTO arwm_countries VALUES('9','Antarctica','010','ATA','AQ');
INSERT INTO arwm_countries VALUES('10','Antigua and Barbuda','028','ATG','AG');
INSERT INTO arwm_countries VALUES('11','Argentina','032','ARG','AR');
INSERT INTO arwm_countries VALUES('12','Armenia','051','ARM','AM');
INSERT INTO arwm_countries VALUES('13','Aruba','533','ABW','AW');
INSERT INTO arwm_countries VALUES('14','Australia','036','AUS','AU');
INSERT INTO arwm_countries VALUES('15','Austria','040','AUT','AT');
INSERT INTO arwm_countries VALUES('16','Azerbaijan','031','AZE','AZ');
INSERT INTO arwm_countries VALUES('17','Bahamas','044','BHS','BS');
INSERT INTO arwm_countries VALUES('18','Bahrain','048','BHR','BH');
INSERT INTO arwm_countries VALUES('19','Bangladesh','050','BGD','BD');
INSERT INTO arwm_countries VALUES('20','Barbados','052','BRB','BB');
INSERT INTO arwm_countries VALUES('21','Belarus','112','BLR','BY');
INSERT INTO arwm_countries VALUES('22','Belgium','056','BEL','BE');
INSERT INTO arwm_countries VALUES('23','Belize','084','BLZ','BZ');
INSERT INTO arwm_countries VALUES('24','Benin','204','BEN','BJ');
INSERT INTO arwm_countries VALUES('25','Bermuda','060','BMU','BM');
INSERT INTO arwm_countries VALUES('26','Bhutan','064','BTN','BT');
INSERT INTO arwm_countries VALUES('27','Bolivia','068','BOL','BO');
INSERT INTO arwm_countries VALUES('28','Bosnia and Herzegovina','070','BIH','BA');
INSERT INTO arwm_countries VALUES('29','Botswana','072','BWA','BW');
INSERT INTO arwm_countries VALUES('30','Bouvet Island','074','BVT','BV');
INSERT INTO arwm_countries VALUES('31','Brazil','076','BRA','BR');
INSERT INTO arwm_countries VALUES('32','British Indian Ocean Territory','086','IOT','IO');
INSERT INTO arwm_countries VALUES('33','Brunei Darussalam','096','BRN','BN');
INSERT INTO arwm_countries VALUES('34','Bulgaria','100','BGR','BG');
INSERT INTO arwm_countries VALUES('35','Burkina Faso','854','BFA','BF');
INSERT INTO arwm_countries VALUES('36','Burundi','108','BDI','BI');
INSERT INTO arwm_countries VALUES('37','Cambodia','116','KHM','KH');
INSERT INTO arwm_countries VALUES('38','Cameroon','120','CMR','CM');
INSERT INTO arwm_countries VALUES('39','Canada','124','CAN','CA');
INSERT INTO arwm_countries VALUES('40','Cape Verde','132','CPV','CV');
INSERT INTO arwm_countries VALUES('41','Cayman Islands','136','CYM','KY');
INSERT INTO arwm_countries VALUES('42','Central African Republic','140','CAF','CF');
INSERT INTO arwm_countries VALUES('43','Chad','148','TCD','TD');
INSERT INTO arwm_countries VALUES('44','Chile','152','CHL','CL');
INSERT INTO arwm_countries VALUES('45','China','156','CHN','CN');
INSERT INTO arwm_countries VALUES('46','Christmas Island','162','CXR','CX');
INSERT INTO arwm_countries VALUES('47','Cocos (Keeling) Islands','166','CCK','CC');
INSERT INTO arwm_countries VALUES('48','Colombia','170','COL','CO');
INSERT INTO arwm_countries VALUES('49','Comoros','174','COM','KM');
INSERT INTO arwm_countries VALUES('50','Congo','178','COG','CG');
INSERT INTO arwm_countries VALUES('51','Congo, Democratic Republic of the','180','COD','CD');
INSERT INTO arwm_countries VALUES('52','Cook Islands','184','COK','CK');
INSERT INTO arwm_countries VALUES('53','Costa Rica','188','CRI','CR');
INSERT INTO arwm_countries VALUES('54','Cote d\'Ivoire','384','CIV','CI');
INSERT INTO arwm_countries VALUES('55','Croatia','191','HRV','HR');
INSERT INTO arwm_countries VALUES('56','Cuba','192','CUB','CU');
INSERT INTO arwm_countries VALUES('57','Cyprus','196','CYP','CY');
INSERT INTO arwm_countries VALUES('58','Czech Republic','203','CZE','CZ');
INSERT INTO arwm_countries VALUES('59','Denmark','208','DNK','DK');
INSERT INTO arwm_countries VALUES('60','Djibouti','262','DJI','DJ');
INSERT INTO arwm_countries VALUES('61','Dominica','212','DMA','DM');
INSERT INTO arwm_countries VALUES('62','Dominican Republic','214','DOM','DO');
INSERT INTO arwm_countries VALUES('63','Ecuador','218','ECU','EC');
INSERT INTO arwm_countries VALUES('64','Egypt','818','EGY','EG');
INSERT INTO arwm_countries VALUES('65','El Salvador','222','SLV','SV');
INSERT INTO arwm_countries VALUES('66','Equatorial Guinea','226','GNQ','GQ');
INSERT INTO arwm_countries VALUES('67','Eritrea','232','ERI','ER');
INSERT INTO arwm_countries VALUES('68','Estonia','233','EST','EE');
INSERT INTO arwm_countries VALUES('69','Ethiopia','231','ETH','ET');
INSERT INTO arwm_countries VALUES('70','Falkland Islands (Malvinas)','238','FLK','FK');
INSERT INTO arwm_countries VALUES('71','Faroe Islands','234','FRO','FO');
INSERT INTO arwm_countries VALUES('72','Fiji','242','FJI','FJ');
INSERT INTO arwm_countries VALUES('73','Finland','246','FIN','FI');
INSERT INTO arwm_countries VALUES('74','France','250','FRA','FR');
INSERT INTO arwm_countries VALUES('75','French Guiana','254','GUF','GF');
INSERT INTO arwm_countries VALUES('76','French Polynesia','258','PYF','PF');
INSERT INTO arwm_countries VALUES('77','French Southern Territories','260','ATF','TF');
INSERT INTO arwm_countries VALUES('78','Gabon','266','GAB','GA');
INSERT INTO arwm_countries VALUES('79','Gambia','270','GMB','GM');
INSERT INTO arwm_countries VALUES('80','Georgia','268','GEO','GE');
INSERT INTO arwm_countries VALUES('81','Germany','276','DEU','DE');
INSERT INTO arwm_countries VALUES('82','Ghana','288','GHA','GH');
INSERT INTO arwm_countries VALUES('83','Gibraltar','292','GIB','GI');
INSERT INTO arwm_countries VALUES('84','Greece','300','GRC','GR');
INSERT INTO arwm_countries VALUES('85','Greenland','304','GRL','GL');
INSERT INTO arwm_countries VALUES('86','Grenada','308','GRD','GD');
INSERT INTO arwm_countries VALUES('87','Guadeloupe','312','GLP','GP');
INSERT INTO arwm_countries VALUES('88','Guam','316','GUM','GU');
INSERT INTO arwm_countries VALUES('89','Guatemala','320','GTM','GT');
INSERT INTO arwm_countries VALUES('90','Guernsey','831','GGY','GG');
INSERT INTO arwm_countries VALUES('91','Guinea','324','GIN','GN');
INSERT INTO arwm_countries VALUES('92','Guinea-Bissau','624','GNB','GW');
INSERT INTO arwm_countries VALUES('93','Guyana','328','GUY','GY');
INSERT INTO arwm_countries VALUES('94','Haiti','332','HTI','HT');
INSERT INTO arwm_countries VALUES('95','Heard Island and McDonald Islands','334','HMD','HM');
INSERT INTO arwm_countries VALUES('96','Holy See (Vatican City State)','336','VAT','VA');
INSERT INTO arwm_countries VALUES('97','Honduras','340','HND','HN');
INSERT INTO arwm_countries VALUES('98','Hong Kong','344','HKG','HK');
INSERT INTO arwm_countries VALUES('99','Hungary','348','HUN','HU');
INSERT INTO arwm_countries VALUES('100','Iceland','352','ISL','IS');
INSERT INTO arwm_countries VALUES('101','India','356','IND','IN');
INSERT INTO arwm_countries VALUES('102','Indonesia','360','IDN','ID');
INSERT INTO arwm_countries VALUES('103','Iran, Islamic Republic of','364','IRN','IR');
INSERT INTO arwm_countries VALUES('104','Iraq','368','IRQ','IQ');
INSERT INTO arwm_countries VALUES('105','Ireland','372','IRL','IE');
INSERT INTO arwm_countries VALUES('106','Isle of Man','833','IMN','IM');
INSERT INTO arwm_countries VALUES('107','Israel','376','ISR','IL');
INSERT INTO arwm_countries VALUES('108','Italy','380','ITA','IT');
INSERT INTO arwm_countries VALUES('109','Jamaica','388','JAM','JM');
INSERT INTO arwm_countries VALUES('110','Japan','392','JPN','JP');
INSERT INTO arwm_countries VALUES('111','Jersey','832','JEY','JE');
INSERT INTO arwm_countries VALUES('112','Jordan','400','JOR','JO');
INSERT INTO arwm_countries VALUES('113','Kazakhstan','398','KAZ','KZ');
INSERT INTO arwm_countries VALUES('114','Kenya','404','KEN','KE');
INSERT INTO arwm_countries VALUES('115','Kiribati','296','KIR','KI');
INSERT INTO arwm_countries VALUES('116','Korea, Democratic People\'s Republic of','408','PRK','KP');
INSERT INTO arwm_countries VALUES('117','Korea, Republic of','410','KOR','KR');
INSERT INTO arwm_countries VALUES('118','Kuwait','414','KWT','KW');
INSERT INTO arwm_countries VALUES('119','Kyrgyzstan','417','KGZ','KG');
INSERT INTO arwm_countries VALUES('120','Lao People\'s Democratic Republic','418','LAO','LA');
INSERT INTO arwm_countries VALUES('121','Latvia','428','LVA','LV');
INSERT INTO arwm_countries VALUES('122','Lebanon','422','LBN','LB');
INSERT INTO arwm_countries VALUES('123','Lesotho','426','LSO','LS');
INSERT INTO arwm_countries VALUES('124','Liberia','430','LBR','LR');
INSERT INTO arwm_countries VALUES('125','Libyan Arab Jamahiriya','434','LBY','LY');
INSERT INTO arwm_countries VALUES('126','Liechtenstein','438','LIE','LI');
INSERT INTO arwm_countries VALUES('127','Lithuania','440','LTU','LT');
INSERT INTO arwm_countries VALUES('128','Luxembourg','442','LUX','LU');
INSERT INTO arwm_countries VALUES('129','Macao','446','MAC','MO');
INSERT INTO arwm_countries VALUES('130','Macedonia, the former Yugoslav Republic of','807','MKD','MK');
INSERT INTO arwm_countries VALUES('131','Madagascar','450','MDG','MG');
INSERT INTO arwm_countries VALUES('132','Malawi','454','MWI','MW');
INSERT INTO arwm_countries VALUES('133','Malaysia','458','MYS','MY');
INSERT INTO arwm_countries VALUES('134','Maldives','462','MDV','MV');
INSERT INTO arwm_countries VALUES('135','Mali','466','MLI','ML');
INSERT INTO arwm_countries VALUES('136','Malta','470','MLT','MT');
INSERT INTO arwm_countries VALUES('137','Marshall Islands','584','MHL','MH');
INSERT INTO arwm_countries VALUES('138','Martinique','474','MTQ','MQ');
INSERT INTO arwm_countries VALUES('139','Mauritania','478','MRT','MR');
INSERT INTO arwm_countries VALUES('140','Mauritius','480','MUS','MU');
INSERT INTO arwm_countries VALUES('141','Mayotte','175','MYT','YT');
INSERT INTO arwm_countries VALUES('142','Mexico','484','MEX','MX');
INSERT INTO arwm_countries VALUES('143','Micronesia, Federated States of','583','FSM','FM');
INSERT INTO arwm_countries VALUES('144','Moldova','498','MDA','MD');
INSERT INTO arwm_countries VALUES('145','Monaco','492','MCO','MC');
INSERT INTO arwm_countries VALUES('146','Mongolia','496','MNG','MN');
INSERT INTO arwm_countries VALUES('147','Montenegro','499','MNE','ME');
INSERT INTO arwm_countries VALUES('148','Montserrat','500','MSR','MS');
INSERT INTO arwm_countries VALUES('149','Morocco','504','MAR','MA');
INSERT INTO arwm_countries VALUES('150','Mozambique','508','MOZ','MZ');
INSERT INTO arwm_countries VALUES('151','Myanmar','104','MMR','MM');
INSERT INTO arwm_countries VALUES('152','Namibia','516','NAM','NA');
INSERT INTO arwm_countries VALUES('153','Nauru','520','NRU','NR');
INSERT INTO arwm_countries VALUES('154','Nepal','524','NPL','NP');
INSERT INTO arwm_countries VALUES('155','Netherlands','528','NLD','NL');
INSERT INTO arwm_countries VALUES('156','Netherlands Antilles','530','ANT','AN');
INSERT INTO arwm_countries VALUES('157','New Caledonia','540','NCL','NC');
INSERT INTO arwm_countries VALUES('158','New Zealand','554','NZL','NZ');
INSERT INTO arwm_countries VALUES('159','Nicaragua','558','NIC','NI');
INSERT INTO arwm_countries VALUES('160','Niger','562','NER','NE');
INSERT INTO arwm_countries VALUES('161','Nigeria','566','NGA','NG');
INSERT INTO arwm_countries VALUES('162','Niue','570','NIU','NU');
INSERT INTO arwm_countries VALUES('163','Norfolk Island','574','NFK','NF');
INSERT INTO arwm_countries VALUES('164','Northern Mariana Islands','580','MNP','MP');
INSERT INTO arwm_countries VALUES('165','Norway','578','NOR','NO');
INSERT INTO arwm_countries VALUES('166','Oman','512','OMN','OM');
INSERT INTO arwm_countries VALUES('167','Pakistan','586','PAK','PK');
INSERT INTO arwm_countries VALUES('168','Palau','585','PLW','PW');
INSERT INTO arwm_countries VALUES('169','Palestinian Territory, Occupied','275','PSE','PS');
INSERT INTO arwm_countries VALUES('170','Panama','591','PAN','PA');
INSERT INTO arwm_countries VALUES('171','Papua New Guinea','598','PNG','PG');
INSERT INTO arwm_countries VALUES('172','Paraguay','600','PRY','PY');
INSERT INTO arwm_countries VALUES('173','Peru','604','PER','PE');
INSERT INTO arwm_countries VALUES('174','Philippines','608','PHL','PH');
INSERT INTO arwm_countries VALUES('175','Pitcairn','612','PCN','PN');
INSERT INTO arwm_countries VALUES('176','Poland','616','POL','PL');
INSERT INTO arwm_countries VALUES('177','Portugal','620','PRT','PT');
INSERT INTO arwm_countries VALUES('178','Puerto Rico','630','PRI','PR');
INSERT INTO arwm_countries VALUES('179','Qatar','634','QAT','QA');
INSERT INTO arwm_countries VALUES('180','Reunion','638','REU','RE');
INSERT INTO arwm_countries VALUES('181','Romania','642','ROU','RO');
INSERT INTO arwm_countries VALUES('182','Russian Federation','643','RUS','RU');
INSERT INTO arwm_countries VALUES('183','Rwanda','646','RWA','RW');
INSERT INTO arwm_countries VALUES('184','Saint Barthelemy','652','BLM','BL');
INSERT INTO arwm_countries VALUES('185','Saint Helena','654','SHN','SH');
INSERT INTO arwm_countries VALUES('186','Saint Kitts and Nevis','659','KNA','KN');
INSERT INTO arwm_countries VALUES('187','Saint Lucia','662','LCA','LC');
INSERT INTO arwm_countries VALUES('188','Saint Martin (French part)','663','MAF','MF');
INSERT INTO arwm_countries VALUES('189','Saint Pierre and Miquelon','666','SPM','PM');
INSERT INTO arwm_countries VALUES('190','Saint Vincent and the Grenadines','670','VCT','VC');
INSERT INTO arwm_countries VALUES('191','Samoa','882','WSM','WS');
INSERT INTO arwm_countries VALUES('192','San Marino','674','SMR','SM');
INSERT INTO arwm_countries VALUES('193','Sao Tome and Principe','678','STP','ST');
INSERT INTO arwm_countries VALUES('194','Saudi Arabia','682','SAU','SA');
INSERT INTO arwm_countries VALUES('195','Senegal','686','SEN','SN');
INSERT INTO arwm_countries VALUES('196','Serbia','688','SRB','RS');
INSERT INTO arwm_countries VALUES('197','Seychelles','690','SYC','SC');
INSERT INTO arwm_countries VALUES('198','Sierra Leone','694','SLE','SL');
INSERT INTO arwm_countries VALUES('199','Singapore','702','SGP','SG');
INSERT INTO arwm_countries VALUES('200','Slovakia','703','SVK','SK');
INSERT INTO arwm_countries VALUES('201','Slovenia','705','SVN','SI');
INSERT INTO arwm_countries VALUES('202','Solomon Islands','090','SLB','SB');
INSERT INTO arwm_countries VALUES('203','Somalia','706','SOM','SO');
INSERT INTO arwm_countries VALUES('204','South Africa','710','ZAF','ZA');
INSERT INTO arwm_countries VALUES('205','South Georgia and the South Sandwich Islands','239','SGS','GS');
INSERT INTO arwm_countries VALUES('206','Spain','724','ESP','ES');
INSERT INTO arwm_countries VALUES('207','Sri Lanka','144','LKA','LK');
INSERT INTO arwm_countries VALUES('208','Sudan','736','SDN','SD');
INSERT INTO arwm_countries VALUES('209','Suriname','740','SUR','SR');
INSERT INTO arwm_countries VALUES('210','Svalbard and Jan Mayen','744','SJM','SJ');
INSERT INTO arwm_countries VALUES('211','Swaziland','748','SWZ','SZ');
INSERT INTO arwm_countries VALUES('212','Sweden','752','SWE','SE');
INSERT INTO arwm_countries VALUES('213','Switzerland','756','CHE','CH');
INSERT INTO arwm_countries VALUES('214','Syrian Arab Republic','760','SYR','SY');
INSERT INTO arwm_countries VALUES('215','Taiwan, Province of China','158','TWN','TW');
INSERT INTO arwm_countries VALUES('216','Tajikistan','762','TJK','TJ');
INSERT INTO arwm_countries VALUES('217','Tanzania, United Republic of','834','TZA','TZ');
INSERT INTO arwm_countries VALUES('218','Thailand','764','THA','TH');
INSERT INTO arwm_countries VALUES('219','Timor-Leste','626','TLS','TL');
INSERT INTO arwm_countries VALUES('220','Togo','768','TGO','TG');
INSERT INTO arwm_countries VALUES('221','Tokelau','772','TKL','TK');
INSERT INTO arwm_countries VALUES('222','Tonga','776','TON','TO');
INSERT INTO arwm_countries VALUES('223','Trinidad and Tobago','780','TTO','TT');
INSERT INTO arwm_countries VALUES('224','Tunisia','788','TUN','TN');
INSERT INTO arwm_countries VALUES('225','Turkey','792','TUR','TR');
INSERT INTO arwm_countries VALUES('226','Turkmenistan','795','TKM','TM');
INSERT INTO arwm_countries VALUES('227','Turks and Caicos Islands','796','TCA','TC');
INSERT INTO arwm_countries VALUES('228','Tuvalu','798','TUV','TV');
INSERT INTO arwm_countries VALUES('229','Uganda','800','UGA','UG');
INSERT INTO arwm_countries VALUES('230','Ukraine','804','UKR','UA');
INSERT INTO arwm_countries VALUES('231','United Arab Emirates','784','ARE','AE');
INSERT INTO arwm_countries VALUES('232','United Kingdom','826','GBR','GB');
INSERT INTO arwm_countries VALUES('233','United States','840','USA','US');
INSERT INTO arwm_countries VALUES('234','United States Minor Outlying Islands','581','UMI','UM');
INSERT INTO arwm_countries VALUES('235','Uruguay','858','URY','UY');
INSERT INTO arwm_countries VALUES('236','Uzbekistan','860','UZB','UZ');
INSERT INTO arwm_countries VALUES('237','Vanuatu','548','VUT','VU');
INSERT INTO arwm_countries VALUES('238','Venezuela','862','VEN','VE');
INSERT INTO arwm_countries VALUES('239','Viet Nam','704','VNM','VN');
INSERT INTO arwm_countries VALUES('240','Virgin Islands, British','092','VGB','VG');
INSERT INTO arwm_countries VALUES('241','Virgin Islands, U.S.','850','VIR','VI');
INSERT INTO arwm_countries VALUES('242','Wallis and Futuna','876','WLF','WF');
INSERT INTO arwm_countries VALUES('243','Western Sahara','732','ESH','EH');
INSERT INTO arwm_countries VALUES('244','Yemen','887','YEM','YE');
INSERT INTO arwm_countries VALUES('245','Zambia','894','ZMB','ZM');
INSERT INTO arwm_countries VALUES('246','Zimbabwe','716','ZWE','ZW');


# Structure of table arwm_currencies
DROP TABLE IF EXISTS `arwm_currencies`;
CREATE TABLE `arwm_currencies` (
  `currency_id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `brief` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `course` varchar(35) NOT NULL DEFAULT '1.00',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `iso_alpha` char(3) NOT NULL,
  `iso_numeric` char(3) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_currencies
INSERT INTO arwm_currencies VALUES('1','руб','Российский рубль','1','1','RUR','643');
INSERT INTO arwm_currencies VALUES('2','у.е.','Условная единица','30','1','','');
INSERT INTO arwm_currencies VALUES('3','WMZ','WebMoney Z','30','1','','');
INSERT INTO arwm_currencies VALUES('6','WMR','WebMoney R','1','1','','');
INSERT INTO arwm_currencies VALUES('50','$','Доллар США','23.8482','1','USD','840');
INSERT INTO arwm_currencies VALUES('51','EUR','Евро','37.0339','1','EUR','978');
INSERT INTO arwm_currencies VALUES('52','грн','Украинская гривна','4.3456','1','UAH','980');


# Structure of table arwm_deliverymethods
DROP TABLE IF EXISTS `arwm_deliverymethods`;
CREATE TABLE `arwm_deliverymethods` (
  `dmid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `dmname` varchar(255) NOT NULL,
  `short_descript` text NOT NULL,
  `long_descript` mediumtext NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_cost` decimal(15,2) unsigned NOT NULL,
  `free_delivery_sum` decimal(15,2) unsigned NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`dmid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_deliverymethods
INSERT INTO arwm_deliverymethods VALUES('1','Самовывоз','','','0','0.00','0.00','0');
INSERT INTO arwm_deliverymethods VALUES('2','Доставка курьером','<p>Курьер производит электронную отправку заказа на электронный адрес покупателя.</p>','<p>Курьер производит электронную отправку заказа на электронный адрес покупателя.</p>','1','0.00','0.00','0');


# Structure of table arwm_forgotpassword
DROP TABLE IF EXISTS `arwm_forgotpassword`;
CREATE TABLE `arwm_forgotpassword` (
  `confirmkey` varchar(18) NOT NULL,
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `new_pwd` varchar(32) NOT NULL,
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_forgotpassword
INSERT INTO arwm_forgotpassword VALUES('304403950494717330','1','663dfa0c2aa551ed9d3807c51fb4b472','1210967131','0');


# Structure of table arwm_gallery
DROP TABLE IF EXISTS `arwm_gallery`;
CREATE TABLE `arwm_gallery` (
  `imgid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` int(11) unsigned NOT NULL DEFAULT '0',
  `small_img` varchar(255) NOT NULL,
  `big_img` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  PRIMARY KEY (`imgid`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_gallery


# Structure of table arwm_item_categories
DROP TABLE IF EXISTS `arwm_item_categories`;
CREATE TABLE `arwm_item_categories` (
  `catid` mediumint(8) unsigned NOT NULL,
  `itemid` int(11) unsigned NOT NULL,
  `sortid` int(11) NOT NULL,
  KEY `catid` (`catid`),
  KEY `itemid` (`itemid`),
  KEY `sortid` (`sortid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_categories
INSERT INTO arwm_item_categories VALUES('8','1','0');
INSERT INTO arwm_item_categories VALUES('10','2','0');
INSERT INTO arwm_item_categories VALUES('8','3','0');
INSERT INTO arwm_item_categories VALUES('8','4','0');
INSERT INTO arwm_item_categories VALUES('4','5','0');
INSERT INTO arwm_item_categories VALUES('10','6','0');
INSERT INTO arwm_item_categories VALUES('3','7','0');
INSERT INTO arwm_item_categories VALUES('6','8','0');
INSERT INTO arwm_item_categories VALUES('11','9','0');
INSERT INTO arwm_item_categories VALUES('7','10','0');
INSERT INTO arwm_item_categories VALUES('7','11','0');
INSERT INTO arwm_item_categories VALUES('2','12','0');
INSERT INTO arwm_item_categories VALUES('2','13','0');
INSERT INTO arwm_item_categories VALUES('6','14','0');
INSERT INTO arwm_item_categories VALUES('1','15','0');
INSERT INTO arwm_item_categories VALUES('10','16','0');
INSERT INTO arwm_item_categories VALUES('3','17','0');
INSERT INTO arwm_item_categories VALUES('2','18','0');


# Structure of table arwm_item_comments
DROP TABLE IF EXISTS `arwm_item_comments`;
CREATE TABLE `arwm_item_comments` (
  `comid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` int(11) unsigned NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `cpdate` int(11) unsigned NOT NULL,
  `scomment` text NOT NULL,
  `ardate` int(11) unsigned NOT NULL,
  `admin_reply` text NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL,
  `sortid` tinyint(11) NOT NULL,
  PRIMARY KEY (`comid`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_comments


# Structure of table arwm_item_comments_new
DROP TABLE IF EXISTS `arwm_item_comments_new`;
CREATE TABLE `arwm_item_comments_new` (
  `comid` int(11) unsigned NOT NULL,
  `itemid` int(11) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_comments_new


# Structure of table arwm_item_options
DROP TABLE IF EXISTS `arwm_item_options`;
CREATE TABLE `arwm_item_options` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_options
INSERT INTO arwm_item_options VALUES('1','Цвет','0');
INSERT INTO arwm_item_options VALUES('2','Размер','0');


# Structure of table arwm_item_options_match
DROP TABLE IF EXISTS `arwm_item_options_match`;
CREATE TABLE `arwm_item_options_match` (
  `itemid` int(11) unsigned NOT NULL,
  `option_id` int(11) unsigned NOT NULL,
  `option_value_id` int(11) unsigned NOT NULL,
  `price_difference` decimal(15,2) NOT NULL,
  `def` tinyint(1) unsigned NOT NULL,
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_options_match


# Structure of table arwm_item_options_values
DROP TABLE IF EXISTS `arwm_item_options_values`;
CREATE TABLE `arwm_item_options_values` (
  `option_value_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_id` int(11) unsigned NOT NULL,
  `option_value` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_options_values
INSERT INTO arwm_item_options_values VALUES('1','1','Красный','0');
INSERT INTO arwm_item_options_values VALUES('2','1','Зелёный','0');
INSERT INTO arwm_item_options_values VALUES('3','1','Синий','0');
INSERT INTO arwm_item_options_values VALUES('4','1','Жёлтый','0');
INSERT INTO arwm_item_options_values VALUES('5','1','Оранжевый','0');
INSERT INTO arwm_item_options_values VALUES('6','1','Фиолетовый','0');
INSERT INTO arwm_item_options_values VALUES('7','1','Розовый','0');
INSERT INTO arwm_item_options_values VALUES('8','1','Серебристый','0');
INSERT INTO arwm_item_options_values VALUES('9','1','Белый','0');
INSERT INTO arwm_item_options_values VALUES('10','1','Чёрный','0');
INSERT INTO arwm_item_options_values VALUES('11','1','Серый','0');
INSERT INTO arwm_item_options_values VALUES('12','1','Коричневый','0');
INSERT INTO arwm_item_options_values VALUES('13','1','Бежевый','0');
INSERT INTO arwm_item_options_values VALUES('14','2','38','0');
INSERT INTO arwm_item_options_values VALUES('15','2','39','0');
INSERT INTO arwm_item_options_values VALUES('16','2','40','0');
INSERT INTO arwm_item_options_values VALUES('17','2','41','0');
INSERT INTO arwm_item_options_values VALUES('18','2','42','0');
INSERT INTO arwm_item_options_values VALUES('19','2','43','0');
INSERT INTO arwm_item_options_values VALUES('20','2','44','0');


# Structure of table arwm_item_similar
DROP TABLE IF EXISTS `arwm_item_similar`;
CREATE TABLE `arwm_item_similar` (
  `itemid` int(11) unsigned NOT NULL,
  `similar_itemid` int(11) unsigned NOT NULL,
  `sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_similar


# Structure of table arwm_item_special
DROP TABLE IF EXISTS `arwm_item_special`;
CREATE TABLE `arwm_item_special` (
  `sp_itemid` int(11) unsigned NOT NULL,
  `sp_sortid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_item_special


# Structure of table arwm_items
DROP TABLE IF EXISTS `arwm_items`;
CREATE TABLE `arwm_items` (
  `itemid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `itemname` varchar(255) NOT NULL,
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `mnf_id` int(11) unsigned NOT NULL,
  `sku` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) unsigned NOT NULL DEFAULT '0',
  `quantity_txt` varchar(255) NOT NULL,
  `short_descript` text NOT NULL,
  `long_descript` mediumtext NOT NULL,
  `small_img` varchar(255) NOT NULL,
  `big_img` varchar(255) NOT NULL,
  `add_date` int(11) unsigned NOT NULL DEFAULT '0',
  `upd_date` int(11) unsigned NOT NULL DEFAULT '0',
  `meta_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `metatags` text NOT NULL,
  `special` text NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`,`visible`),
  KEY `mnf_id` (`mnf_id`),
  KEY `upd_date` (`upd_date`),
  FULLTEXT KEY `search` (`sku`,`title`,`short_descript`,`long_descript`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_items
INSERT INTO arwm_items VALUES('1','Проек капитального ремонта  Больница №5 шх Южная','8','0','113-07','Проек капитального ремонта  Больница №5 шх. Южная','300.00','0.00','4294967295','','','<p>Проектом капитального ремонта предусматривается выполнение следующих видов работ:</p>\r\n<p>1. Частичная перепланировка помещений здания литер &laquo;А&raquo;, в соответствии с техническим заданием и требованиями нормативных документов:</p>\r\n<p>На первом этаже терапевтического отделения:</p>\r\n<p>- разместить электрощитовую - перенести из сырого подвального помещения;</p>\r\n<p>- приемное отделение оборудовать евро-душевой кабиной, санузлом, раковиной, биде;</p>\r\n<p>- комнату гигиены оборудовать евро-душевой кабиной, душевым поддоном, раковиной, биде;</p>\r\n<p>-в мужском туалете установить писсуар, чашу напольную, унитаз и две раковины;</p>\r\n<p>- разместить приемную главного врача с подсобными помещениями (туалет, душ) в</p>','113-07.png','113-07.png','1577728035','1577948749','','','Проект, документация, водотведение, коллектор, разработка','','','1');
INSERT INTO arwm_items VALUES('2','Proekt-rastvorobetonnogo-uzla','10','0','104-06','Проект растворобетонного  узла','300.00','450.00','4294967295','','','<p>Проект растворобетонного узла</p>','','104-06-2-MBSU.jpg','1577902287','1577902287','Проект бетонорастворного узла','Проект бетонорастворного узла','','','','1');
INSERT INTO arwm_items VALUES('3','Proekt-zubotehnicheskoj-laboratorii','8','0','126-07','Проект зуботехнической лаборатории','150.00','0.00','4294967295','','<p>Проект зуботехнической лаборатории</p>','','','126-07_Zub_teh_laborat_.jpg','1577903488','1577903638','','','','','','1');
INSERT INTO arwm_items VALUES('4','Proekt-medsanchasti','8','0','134-07','Проект медсанчасти','1000.00','0.00','4294967295','','<p>Проект медсанчасти</p>','','43046.jpg','43046.jpg','1577903919','1577904293','','','','','','1');
INSERT INTO arwm_items VALUES('5','Proekt-kottedzha','4','0','219-11','Проект коттеджа','1000.00','0.00','4294967295','','<p>Проект коттеджа</p>','','219-11_KOTTEDZ_DOM.jpg','219-11_KOTTEDZ_DOM.jpg','1577904555','1577904555','','','','','','1');
INSERT INTO arwm_items VALUES('6','Proekt-avtomobilnie-vesi','10','0','267-13','Проект автомобильные весы','300.00','0.00','4294967295','','<p>Проект автомобильные весы</p>','<p>Проект автомобильные весы</p>','267-13_Proekt_avt-vesi.jpg','267-13_Proekt_avt-vesi.jpg','1577904979','1577905076','','','','','','1');
INSERT INTO arwm_items VALUES('7','Proekt-avtomobilnoj-dorogi','3','0','268-13','Проект автомобильной дороги','1200.00','0.00','4294967295','','<p>Проект автомобильной дороги</p>','<p>Проект автомобильной дороги</p>','268-13_Proekt.jpg','268-13_Proekt.jpg','1577905381','1577905466','','','','','','1');
INSERT INTO arwm_items VALUES('8','Proekt-detskogo-sada','6','0','179-09','Проект детского сада','500.00','0.00','4294967295','','<p>Проект детского сада</p>','<p>Дошкольное учреждение располагается в существующем, подлежащем <br />реконструкции, одноэтажном административном здании и предназначено для <br />содержания в нём 15 детей (одна группа дошкольного возраста от 2-х до 7-ми <br />лет).</p>\r\n<p>Установочная мощность технологического оборудования устанавливаемого в данном <br />проекте &ndash; 40,9 кВт.</p>','445412.png','445412.png','1577947849','1577947849','','','','','','1');
INSERT INTO arwm_items VALUES('9','Proekt-shkola-iskustv','11','0','152-08','Проект школа искуств','350.00','0.00','4294967295','','<p>Проект школа искусств</p>','<p>Объемно-планировочные решения</p>\r\n<p>Согласно технического задания и технического заключения 152/08-ТЗ, проектом предусматривается капитальный ремонт здания Муниципального образова-тельного учреждения дополнительного образования детей детской школы искусств.</p>\r\n<p>Здание детской школы искусств одноэтажное, с чердаком, без подвала, с размерами отдельных частей здания:</p>\r\n<p>в осях 2-7; А-Д &ndash; 27,75х8,7м</p>\r\n<p>в осях 1-5; Д-Е &ndash; 20,95х6,4м</p>\r\n<p>в осях 7-8; Д-Е &ndash; 7,55х6,4м</p>\r\n<p>Высота помещений 3,0м.</p>\r\n<p>Проектом капитального ремонта предусматриваются следующие виды работ:</p>\r\n<p>Произвести усиление фундаментов по осям А; 2; 7 (см. чертеж 1АС лист 2).</p>\r\n<p>Произвести демонтаж старого санузла и выполнение нового согласно чертежа 1АС лист 2.</p>\r\n<p>Произвести благоустройство участка, обеспечив, таким образом, отвод поверхностных вод от здания, путем засыпки образовавшихся выемок и подсыпки грунта, создав уклон в сторону от здания не менее i=0,02.</p>\r\n<p>Выполнить по всему периметру здания новое асфальтовое покрытие отмостки шириной 1,5м с уклоном i=0,03 от здания.</p>\r\n<p>Произвести замену разрушенных участков кладки новой кладкой; участки размытой кирпичной кладки оштукатурить по сетке цементным раствором. Новый кирпич, используемый для ремонта, должен иметь марку не ниже существующей.</p>\r\n<p>Произвести разборку разрушенного карниза с последующим его наращиванием новой кирпичной кладкой.</p>\r\n<p>Отремонтировать наружную часть кирпичной кладки стен, подвергшихся замоканию и размораживанию.</p>\r\n<p>Трещины в стенах очистить от мусора струей воды или сжатого воздуха, затем заполнить слоем жирного цементного теста из цемента марки не ниже 400.</p>\r\n<p>Произвести лечение внутренних поверхностей стен, перегородок и плит перекрытия, пораженных грибком.</p>\r\n<p>Выполнить дополнительно ряд стропильных ног (30%).</p>\r\n<p>Отремонтировать ряд стропильных ног (20%).</p>\r\n<p>Заменить обрешетку кровли.</p>\r\n<p>Заменить гидроизоляцию кровли.</p>\r\n<p>Выполнить новые слуховые окна.</p>\r\n<p>Выполнить новую кровлю из металлопластиковой черепицы.</p>\r\n<p>В осях Д-Е; 4-2 демонтировать крышу и выполнить новую стропильную систему с последующим выполнением новой кровли из металлопластиковой черепицы.</p>\r\n<p>Выполнить организованный водосток.</p>\r\n<p>Выполнить утепление стен с наружной стороны.</p>\r\n<p>Заменить оконные и дверные блоки на металлопластиковые.</p>\r\n<p>Полностью заменить полы.</p>\r\n<p>Выполнить входные тамбуры по осям Б, Д.</p>\r\n<p>По оси Д выполнить пандус и новые входные ступени.</p>\r\n<p>Деревянные конструкции стропильной крыши обработать огнебиозащитным составом.</p>','','852205.png','1577961979','1577964221','','','','','','1');
INSERT INTO arwm_items VALUES('10','Proekt-doma-kulturi','7','0','174-08','Проект дома культуры','200.00','0.00','4294967295','','<p>Проект дома культуры</p>','<p>Объемно &ndash; планировочные решения (выписка)</p>\r\n<p>Здание клуба &laquo;Аютинский&raquo; - одноэтажное, высота этажа &ndash; hср=5,0м, прямоугольной <br />формы в плане с размерами 14,60х33,63м. Здание с подвалом, подвал в осях 5 <br />-7; А-Б с высотой 3,2 и 4, 2м.</p>\r\n<p>Для повышения эксплуатационной надежности здания рекомендуется выполнить <br />следующее:</p>\r\n<p>1. Произвести усиление фундамента: по оси &laquo;А&raquo; в осях 1-5, по оси &laquo;1&raquo; в осях <br />А-Б; по оси &laquo;Б&raquo; в осях 1-4.</p>\r\n<p>2. Выполнить по всему периметру здания новое асфальтовое покрытие отмостки <br />шириной 1,5м с уклоном i=0,03 от здания.</p>\r\n<p>3. Переложить участок кладки на фасаде 1-6 по оси &laquo;2&raquo; со сквозной трещиной с <br />раскрытием до 10мм.</p>\r\n<p>4. Выполнить инъектирование трещин с раскрытием от 1 до 2мм в кирпичной <br />кладке.</p>\r\n<p>5. Заменить пароизоляцию и утеплитель чердачного перекрытия.</p>\r\n<p>6. Выполнить цементную стяжку по утеплителю.</p>\r\n<p>7. Выполнить замену кровли.</p>\r\n<p>8. Восстановить вырезанный раскос в металлической ферме крыши.</p>\r\n<p>9. Частично заменить обрешетку с рубероидом (по оси Б шириной 1м).</p>\r\n<p>10. Выполнить антикоррозийную и огнезащиту металлических конструкций ферм.</p>\r\n<p>11. Выполнить огнебиозащиту деревянных конструкций чердачного перекрытия и <br />крыши составом Фенилакс.</p>\r\n<p>12. Выполнить организованный водосток.</p>\r\n<p>13. Выполнить ремонт карниза по оси Б и по фасадам А-Б; Б-А.</p>\r\n<p>14. Выполнить отделку верха карнизов оцинкованной провельной сталью по оси Б и <br />по фасадам А-Б; Б-а.</p>\r\n<p>15.Выполнить новые полы.</p>','','','1577965168','1577965168','','','','','','1');
INSERT INTO arwm_items VALUES('11','Proekt-dom-kulturi','7','0','143-07','Проект дома культуры','250.00','0.00','4294967295','','<p>Проект дома культуры</p>','<p>Объемно &ndash; планировочные решения.</p>\r\n<p>Здание в осях 4-7; Б-В одноэтажное, с антресолью (в осях 4-5) на кирпичных <br />колоннах, в осях 1-5; А-Г &ndash; двухэтажное. Высота первого этажа 2,8м, второго <br />2,9м. В осях 6-7; Б-В. на отм.- 0,95 (под сценой) имеется подвал.</p>\r\n<p>Проектом капитального ремонта предусматривается выполнение следующих видов <br />работ:</p>\r\n<p>Выполнить по всему периметру здания новое асфальтовое покрытие отмостки <br />шириной 1,5м с уклоном i=0,03 от здания.</p>\r\n<p>Заменить оконные и дверные блоки на металлопластиковые.</p>\r\n<p>Заменить дощатые полы в тамбуре главного входа на мозаичные.</p>\r\n<p>Заменить асбестоцементные листы кровли на металлопластиковую черепицу.</p>\r\n<p>Заменить 50% обрешетки.</p>\r\n<p>Заменить дощатые полы в фойе на мозаичные.</p>\r\n<p>Выполнить наружную отделку стен, предварительно сняв существующую плитку.</p>\r\n<p>Заменить щитовой накат чердачного перекрытия на новый со сменой шлакового <br />утеплителя на более легкий из минераловатных плит толщиной 15см.</p>\r\n<p>Произвести внутреннюю отделку.</p>\r\n<p>Произвести ремонт бетонных ступеней и площадок входов в здание с установкой <br />ограждения лестниц.</p>\r\n<p>Выполнить пандус для маломобильного населения в главном входе в здание.</p>\r\n<p>Выполнить козырек над главным входом в здание.</p>\r\n<p>Заменить несущие конструкции сценической площадки.</p>\r\n<p>Заменить дощатое покрытие сцены.</p>','','','1577975022','1577975022','','','проект, дом. культуры. разработка','','','1');
INSERT INTO arwm_items VALUES('12','Proekt-kanalizatsionnoj-nasosnoj-stantsii','2','0','146-07','Проект канализационной насосной станции(КНС-1)','1250.00','0.00','4294967295','','<p>Проект КНС (канализационная насосная станция)</p>','<p>Основные технологические решения(выписка)<br />общая площадь КНС №1 &ndash; 372.6 м&sup2;, в том числе производственная &ndash; 204.2м&sup2;. <br />Канализационная насосная станция №1, производительностью <br />20.0 тыс. м3/сут предназначена для перекачки хозяйственно-бытовых и близких к <br />ним по составу производственных сточных вод города, имеющих нейтральную и <br />слабощелочную реакцию.</p>\r\n<p>Станция эксплуатируется с автоматическим управлением насосных агрегатов и <br />вспомогательных механизмов.</p>\r\n<p>Насосная станция имеет подземную часть круглой в плане формы диаметром 16м и <br />надземную часть прямоугольной формы размером 12.0х15.0.</p>\r\n<p>Подземная часть разделена на два отсека глухой водонепроницаемой перегородкой: <br />в одном отсеке расположен приемный резервуар и грабельное помещение; в другом <br />&ndash; машинное помещение. В машинном помещении расположены основные <br />технологические насосы, насосы для подачи воды на уплотнение сальников, <br />дренажный насос и необходимая арматура; в грабельном помещении &ndash; решетки <br />механизированные и дробилки.</p>\r\n<p>В надземной части расположены щиты управления электродвигателями, приборы <br />автоматики, вентиляционно-отопительное оборудование, душевая, санузел, <br />служебное помещение, монтажные площадки и грузоподъемные устройства, <br />электропункт.</p>\r\n<p>Глубина заложения лотка подводящего коллектора 6.350м от поверхности земли.</p>\r\n<p>В ходе визуального обследования насосной станции и анализа работы <br />технологического оборудования была выявлена необходимость замены существующего <br />и установки нового технологического оборудования в машинном и грабельном <br />помещении. Необходимость замены и установки нового технологического <br />оборудования вызвана износом существующего технологического оборудования, <br />арматуры, их аварийным состоянием, а также отсутствием некоторых комплектов <br />технологического оборудования (см. рабочие чертежи 146/07-ТХ)</p>','','','1577977015','1577992339','','','проект, разработка. канализационная . насосная, станция','','','1');
INSERT INTO arwm_items VALUES('13','Proekt-zameni-kanalizatsionnogo-kollektora','2','0','153-08','Проект замены канализационного коллектора','250.00','0.00','4294967295','','<p>Проект замены канализационного коллектора</p>','<p>Технические решения (выписка)</p>\r\n<p>Проектом предусматривается замена аварийного напорного стального <br />канализационного коллектора &Oslash;400мм на &Oslash;160Т &laquo;Техническая&raquo; <br />ГОСТ 18599-2001, протяженностью 2237м с подключением в насосной <br />станции школы № 34 и к существующей камере гашения около насосной ш. <br />Самбековская.</p>\r\n<p>Количество сточных вод уменьшилось с 1400м&sup3;/сут. до 290м&sup3;/сут., что связано с <br />ликвидацией шахты &laquo;Самбековская&raquo;. По коллектору будут отводиться только <br />сточные воды поселка Самбек.</p>\r\n<p>Сети проходят по застроенной территории.</p>\r\n<p>На проектируемой сети предусмотрены колодцы на углах поворота с установкой в <br />них ревизий и в местах изменения уклона для измерения в них напряженного <br />состояния труб.</p>','153-08_Proekt_ollektor.jpg','153-08_Proekt_ollektor.jpg','1577993135','1577993339','','','замена, канализационного, коллектора','','','1');
INSERT INTO arwm_items VALUES('14','Proekt-detskij-sad','6','0','169-08','Проект детского сада','250.00','200.00','4294967295','','<p>Проект детского сада</p>','<p>Основные решения</p>\r\n<p>Проектом предусмотрено:</p>\r\n<p>-усиление фундамента, в связи с его просадкой при подработке &ndash; 9,0м3;</p>\r\n<p>- замена кровли- 863 м2;</p>\r\n<p>- облицовка фасада - 620 м2 ;</p>\r\n<p>- ремонт чердачного перекрытия- 65м3;</p>\r\n<p>- внутренняя отделка помещений-2469,0 м2;</p>\r\n<p>Основные выводы по рабочему проекту:</p>\r\n<p>- рабочий проект выполнен в соответствии с рекомендациями, изложенными в горно-геологическом обосновании, с учетом инженерно-геологических изысканий, выполненных фирмой &laquo;Ингео&raquo; и актом обследования здания</p>','169-08_et_sad2_.jpg','169-08_et_sad2_.jpg','1577994486','1577994632','','','проект, детский, сад','','','1');
INSERT INTO arwm_items VALUES('15','Proekt-setej-vodosnabzheniya','1','0','150-08','Проект сетей водоснабжения','300.00','0.00','4294967295','','<p>Проект сетей водоснабжения</p>','<p>Проект сетей водоснабжения</p>','150-08_Seti-vodonab_.jpg','150-08_Seti-vodonab_.jpg','1578038477','1578038477','','','проект. сети. водоснабжения','','','1');
INSERT INTO arwm_items VALUES('16','Proekt-pererabotki-otvala','10','0','','Проект переработки отвала','900.00','1200.00','4294967295','','<p>Проект переработки породного отвала</p>','<p><span style=\"font-size: 12pt;\"><strong>Проект переработки породного отвала.</strong></span></p>\r\n<p><span style=\"font-size: 12pt;\"><strong>Оборудование комплекса переработки горной массы породного отвала и </strong></span><br /><span style=\"font-size: 12pt;\"><strong>технологический процесс</strong></span></p>\r\n<p>Комплекс переработки горной массы представляет собой оборудование</p>\r\n<p>связанное между собой в технологическую цепочку (линию) для выполнения рассева <br />горной массы отвала на различные классы по крупности, пригодные для <br />строительства и складирование готовой продукции на склад.</p>\r\n<p>Схема цепи аппаратов 107/06-402-ТХ, л. 2, 3 комплекса переработки горной массы <br />включает в себя следующие сборочные единицы (позиции):</p>\r\n<p>Поз.1. Колосниковое устройство (существующее нестандартизированное <br />оборудование);</p>\r\n<p>Поз.2. Приемный бункер горной массы загружается с автосамосвала КраЗ, объём <br />бункера 20 м&sup3; (существующая металлоконструкция);</p>\r\n<p>Поз.3. Опора бункера (существующая металлоконструкция);</p>\r\n<p>Поз.4. Питатель качающийся ПК-1,2-8А, предназначен для равномерной загрузки <br />горной массы на ленточный конвейер. Производительность 250 т/ч согласно <br />технической характеристике;</p>\r\n<p>Поз.5. Подающее устройство (конвейер) 1Л &ndash; 100 шириной ленты 1000мм <br />предназначено для транспортировки горной массы на конвейер ленточный</p>\r\n<p>1Л-100 (поз.6). Производительность 420т/час, согласно таблицы выбора ленточных <br />конвейеров и приводов к ним. Государственный проектный институт <br />&laquo;Ростовгипрошахт&raquo; МУП СССР, 1973 г. (имеется в наличии у заказчика);</p>\r\n<p>Поз.6. Конвейер ленточный 1Л-100 шириной ленты 1000 мм, предназначен для <br />транспортировки горной массы на грохот ГИЛ-32 от подающего устройства (поз.5). <br />Производительность 358т/час, согласно таблицы выбора ленточных конвейеров и <br />приводов к ним. Государственный проектный институт &laquo;Ростовгипрошахт&raquo; МУП СССР, <br />1973 г. (имеется в наличии у заказчика);</p>\r\n<p>Поз.7. Желоб (существующий, нестандартизированное оборудование);</p>\r\n<p>Поз.8. Грохот ГИЛ-32 предназначен для рассортировки горной массы</p>\r\n<p>(породы) на два класса 0&divide;25 (имеется в наличии у заказчика);</p>\r\n<p>Поз.9. Опорная рама грохота, существующая металлоконструкция с опорой на <br />фундаменты;</p>','107-06_Pererab_Otvala_.jpg','107-06_Pererab_Otvala_.jpg','1578040027','1578040027','','','проект. переработки. породного, отвала','','','1');
INSERT INTO arwm_items VALUES('17','Proekt-federalnoj-avtomobilnoj-dorogi','3','0','268-13','Проект федеральной автомобильной дороги','1900.00','2500.00','4294967295','','<p>Проект федеральной автомобильной дороги</p>','<p><strong><em><span data-contrast=\"auto\">2.Технические нормативы</span></em></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"auto\">В соответствии с заданием в проекте предусмотрен капитальный ремонт автомобильной дороги&nbsp;&nbsp;&nbsp;</span><span data-contrast=\"auto\">II</span><span data-contrast=\"auto\">&nbsp;технической категории со следующими техническими показателями:</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><strong><span data-contrast=\"auto\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<table data-tablestyle=\"MsoNormalTable\" data-tablelook=\"1696\">\r\n<tbody>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">Показатели</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">По нормативам</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">По проекту</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- протяженность дороги, км</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">6,96</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">6,96</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- категория дороги</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">II</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">II</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- расчетная скорость, км/ч</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">120</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">120</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наименьший радиус кривой в плане, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">800</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">1 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наибольший продольный уклон, %</span><span data-contrast=\"auto\">о</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">40</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">40</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наименьший радиус выпуклой вертикальной кривой, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">10 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">5 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- наименьший радиус вогнутой вертикальной кривой, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3 000</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3 018</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">- ширина земляного полотна, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">23,0 &ndash; 30,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">23,0 &ndash; 30,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">- ширина проезжей части, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">4 х 3,5</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">4 х 3,5&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">- ширина разделительной полосы, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">5,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">3,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">-ширина краевой укрепительной полосы&nbsp;</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n<p><span data-contrast=\"none\">&nbsp;</span><span data-contrast=\"none\">обочины, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">0,5</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"none\">0,5</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">-&nbsp;ширина&nbsp; обочины, м</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">3,0</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- дорожная одежда</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">капитального типа с асфальтобетонным покрытием</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">капитального типа с асфальтобетонным покрытием</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">- расчетные нагрузки</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">А11,5, Н14</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">А11.5, Н14</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">-число полос движения</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">4</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n<td data-celllook=\"65536\">\r\n<p><span data-contrast=\"auto\">4</span><span data-ccp-props=\"{\">&nbsp;</span></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>','105697.jpg','105697.jpg','1578041355','1578044810','','','проект, федеральной. автомобильной, дороги','','','1');
INSERT INTO arwm_items VALUES('18','Proekt-kanalizatsionnogo-kollektora','2','0','168-08','Проект канализационного коллектора','300.00','0.00','4294967295','','<p>Проект канализационного коллектора</p>','<p>Проект канализационного коллектора(выписка)</p>\r\n<p>Основные технические решения.<br />В соответствии с актом выбора трассы, проектом предусматривается <br />самотечная канализация из труб &Oslash;400мм общей протяженностью 3986м от колодца <br />КК-1 (ул.Чехова) до канализационного колодца № 137 по ул. Веселая и самотечная <br />канализация &Oslash;315мм протяженностью 560м, от колодца № 51 по ул.Крупской, до <br />колодца №67 (т.7) по улице Седова.</p>\r\n<p>Самотечная канализация запроектирована из пластмассовых канализационных труб <br />ПНД 400С (ПЭ 80 SDR 21, Р=6,3 атм.), и ПНД 315С (ПЭ 80 SDR 21, Р=6,3 <br />атм.) \"Техническая\", ГОСТ 18599-2001.</p>\r\n<p>Также проектом предусмотрена напорная канализация &Oslash;400мм протяженностью 2275 м <br />от КНС Новая Соколовка через железную дорогу по ул.Вернигоренко до <br />существующего колодца гасителя в районе ул.Щаденко и ул.Короленко, 15.</p>\r\n<p>Напорная канализация запроектирована из пластмассовых канализационных труб ПНД <br />400Т (ПЭ 80 SDR 13,6, Р=10 атм.)\"Техническая\", ГОСТ 18599-2001.</p>\r\n<p>При переходе канализации через ж/дорогу выполнена электрохимическая защита <br />стальных футляров, см. часть 168/08-ЭХЗ (план электрических проводок станции <br />катодной защиты ИСТ-750М).</p>\r\n<p>При пересечении трубопровода канализации автомобильных дорог открытым способом <br />предусмотрены футляры из пластмассовых труб ПНД 630Т (ПЭ 80 SDR 13,6, Р=10 <br />атм) \"Техническая\", ГОСТ 18599-2001, см. спецификацию и чертежи.</p>','168-08_Kanal_Kollector_.jpg','168-08_Kanal_Kollector_.jpg','1578048012','1578048012','','','проект, канализационный,  коллектор','','','1');


# Structure of table arwm_mainitems
DROP TABLE IF EXISTS `arwm_mainitems`;
CREATE TABLE `arwm_mainitems` (
  `main_itemid` int(11) unsigned NOT NULL DEFAULT '0',
  `main_sortid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`main_itemid`),
  KEY `itemid` (`main_itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_mainitems


# Structure of table arwm_manufacturers
DROP TABLE IF EXISTS `arwm_manufacturers`;
CREATE TABLE `arwm_manufacturers` (
  `mnf_id` int(11) unsigned NOT NULL,
  `mnfname` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_tags` text NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`mnf_id`),
  KEY `sortid` (`sortid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_manufacturers
INSERT INTO arwm_manufacturers VALUES('0','','','Warning! This is special line. Do not delete this record with mnf_id = 0!','','','','','','','0');


# Structure of table arwm_menu
DROP TABLE IF EXISTS `arwm_menu`;
CREATE TABLE `arwm_menu` (
  `itemid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menuid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `img_width` int(11) NOT NULL,
  `img_height` int(11) NOT NULL,
  `sortid` mediumint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `menuid` (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_menu
INSERT INTO arwm_menu VALUES('1','1','{relative_url}','Главная','hm-home.gif','0','0','0');
INSERT INTO arwm_menu VALUES('2','1','{relative_url}pages.php?view=order','Оформить заказ','hm-order.gif','0','0','1');
INSERT INTO arwm_menu VALUES('3','1','{about_url}','О компании','hm-about.gif','0','0','2');
INSERT INTO arwm_menu VALUES('4','1','{contacts_url}','Контакты','hm-contacts.gif','0','0','3');
INSERT INTO arwm_menu VALUES('5','1','{relative_url}price.php','Прайс-лист','hm-price.gif','0','0','4');


# Structure of table arwm_news
DROP TABLE IF EXISTS `arwm_news`;
CREATE TABLE `arwm_news` (
  `newsid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `newsname` varchar(255) NOT NULL,
  `date` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `menu_text` text NOT NULL,
  `text` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_tags` text NOT NULL,
  PRIMARY KEY (`newsid`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_news


# Structure of table arwm_order_statuses
DROP TABLE IF EXISTS `arwm_order_statuses`;
CREATE TABLE `arwm_order_statuses` (
  `status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `auto_change_group` tinyint(1) NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_order_statuses
INSERT INTO arwm_order_statuses VALUES('1','Не оплачен','0','0');
INSERT INTO arwm_order_statuses VALUES('2','Обрабатывается','0','0');
INSERT INTO arwm_order_statuses VALUES('3','Оплачен, но не доставлен','1','0');
INSERT INTO arwm_order_statuses VALUES('4','Доставлен, но не оплачен','0','0');
INSERT INTO arwm_order_statuses VALUES('5','Доставлен и оплачен','1','0');
INSERT INTO arwm_order_statuses VALUES('6','Отменён','0','0');
INSERT INTO arwm_order_statuses VALUES('7','В процессе доставки','0','0');
INSERT INTO arwm_order_statuses VALUES('8','Оплачен','1','0');


# Structure of table arwm_orderfields
DROP TABLE IF EXISTS `arwm_orderfields`;
CREATE TABLE `arwm_orderfields` (
  `name` varchar(32) NOT NULL,
  `placeholder` text NOT NULL,
  `contexthelp` text NOT NULL,
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sortid` tinyint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_orderfields
INSERT INTO arwm_orderfields VALUES('email','','','1','1','1');
INSERT INTO arwm_orderfields VALUES('last_name','','','0','1','2');
INSERT INTO arwm_orderfields VALUES('first_name','','','1','1','3');
INSERT INTO arwm_orderfields VALUES('patronymic','','','0','1','4');
INSERT INTO arwm_orderfields VALUES('company','','','0','1','5');
INSERT INTO arwm_orderfields VALUES('country','','','0','1','6');
INSERT INTO arwm_orderfields VALUES('city','','','0','1','7');
INSERT INTO arwm_orderfields VALUES('address','','','0','1','8');
INSERT INTO arwm_orderfields VALUES('zip_code','','','0','1','9');
INSERT INTO arwm_orderfields VALUES('phone','','','0','1','10');
INSERT INTO arwm_orderfields VALUES('agreement','','','0','0','0');


# Structure of table arwm_orders
DROP TABLE IF EXISTS `arwm_orders`;
CREATE TABLE `arwm_orders` (
  `orderid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `pmid` mediumint(6) unsigned NOT NULL,
  `paymethod_advname` varchar(32) NOT NULL,
  `paymethod` varchar(255) NOT NULL DEFAULT '0',
  `currency_id` mediumint(6) unsigned NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT '0',
  `currency_brief` varchar(64) NOT NULL,
  `currency_course` varchar(35) NOT NULL,
  `def_currency_id` mediumint(6) unsigned NOT NULL,
  `def_currency` varchar(255) NOT NULL,
  `def_currency_brief` varchar(64) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_percents` varchar(5) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_with_discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_with_discount_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `delivery_cost` decimal(15,2) unsigned NOT NULL,
  `delivery_cost_pc` decimal(15,2) unsigned NOT NULL,
  `final_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `final_total_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dmid` mediumint(6) unsigned NOT NULL,
  `deliverymethod` varchar(255) NOT NULL DEFAULT '0',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `country_id` smallint(4) unsigned NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `adm_pub_comment` text NOT NULL,
  `admin_comment` text NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_orders
INSERT INTO arwm_orders VALUES('1','1577734695','0','5','','Банковский перевод','1','Российский рубль','руб','1','1','Российский рубль','руб','100.00','100.00','0','0.00','0.00','100.00','100.00','0.00','0.00','100.00','100.00','2','Доставка курьером','1','Анатолий','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('2','1577735048','0','2','robokassa','Robokassa','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','1','Анатолий','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('3','1577736232','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','1','Анатолий','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('4','1577736379','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','1','Анатолий','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('5','1577814569','0','2','robokassa','Robokassa','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('6','1577818318','0','2','robokassa','Robokassa','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('7','1577861553','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('8','1577862320','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('9','1577862435','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('10','1577862836','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('11','1577863079','0','3','wm_merchant','WebMoney Merchant','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('12','1577864000','0','5','','Банковский перевод','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');
INSERT INTO arwm_orders VALUES('13','1577875116','0','5','robokassa','Банковский перевод','1','Российский рубль','руб','1','1','Российский рубль','руб','50.00','50.00','0','0.00','0.00','50.00','50.00','0.00','0.00','50.00','50.00','2','Доставка курьером','0','','Анатолий','','','','182','Russian Federation','','','','','sav27951@gmail.com','','','');


# Structure of table arwm_orders_add_fields_values
DROP TABLE IF EXISTS `arwm_orders_add_fields_values`;
CREATE TABLE `arwm_orders_add_fields_values` (
  `oafvid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(11) unsigned NOT NULL,
  `field_name` varchar(64) NOT NULL,
  `field_title` varchar(255) NOT NULL,
  `field_values` text NOT NULL,
  PRIMARY KEY (`oafvid`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_orders_add_fields_values


# Structure of table arwm_orders_items
DROP TABLE IF EXISTS `arwm_orders_items`;
CREATE TABLE `arwm_orders_items` (
  `oiid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(11) unsigned NOT NULL DEFAULT '0',
  `itemid` int(11) unsigned NOT NULL DEFAULT '0',
  `sku` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `price_pc` decimal(15,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) unsigned NOT NULL DEFAULT '0',
  `options` text NOT NULL,
  PRIMARY KEY (`oiid`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_orders_items
INSERT INTO arwm_orders_items VALUES('1','1','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','2','');
INSERT INTO arwm_orders_items VALUES('2','2','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('3','3','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('4','4','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('5','5','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('6','6','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('7','7','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('8','8','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('9','9','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('10','10','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('11','11','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('12','12','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');
INSERT INTO arwm_orders_items VALUES('13','13','1','113-07','Проек капитального ремонта  Больница №5 шх. Южная','50.00','50.00','1','');


# Structure of table arwm_payment_blanks
DROP TABLE IF EXISTS `arwm_payment_blanks`;
CREATE TABLE `arwm_payment_blanks` (
  `blank_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `paymethod_id` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `blank_title` varchar(255) NOT NULL,
  `blank_text` mediumtext NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`blank_id`),
  KEY `paymethod_id` (`paymethod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_payment_blanks


# Structure of table arwm_paymethods
DROP TABLE IF EXISTS `arwm_paymethods`;
CREATE TABLE `arwm_paymethods` (
  `pmid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pmtitle` varchar(255) NOT NULL,
  `short_descript` text NOT NULL,
  `long_descript` mediumtext NOT NULL,
  `adv_descript` mediumtext NOT NULL,
  `adv_descript_mail` text NOT NULL,
  `advname` varchar(32) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`pmid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_paymethods
INSERT INTO arwm_paymethods VALUES('1','Оплата наличными','','','','','','0','0');
INSERT INTO arwm_paymethods VALUES('2','Robokassa','<p>Оплата через сервис приема платежей Robokassa</p>','<h4>Оплата через сервис приема платежей Robokassa.</h4>\r\n<p>Много разных способов оплаты: с помощью банковских карт, в любой электронной валюте, с помощью сервисов МТС и Билайн, платежи через интернет-банк, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone.</p>','','','robokassa','1','0');
INSERT INTO arwm_paymethods VALUES('3','WebMoney Merchant','<p>Мгновенная онлайн-оплата через платежную систему WebMoney.</p>','<p>Мгновенная онлайн-оплата через платежную систему WebMoney.</p>','','','wm_merchant','1','0');
INSERT INTO arwm_paymethods VALUES('5','Банковский перевод','','','','','robokassa','1','0');


# Structure of table arwm_paymethods_currencies
DROP TABLE IF EXISTS `arwm_paymethods_currencies`;
CREATE TABLE `arwm_paymethods_currencies` (
  `pmid` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `currency_id` mediumint(6) NOT NULL DEFAULT '0',
  KEY `pmid` (`pmid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_paymethods_currencies
INSERT INTO arwm_paymethods_currencies VALUES('1','1');
INSERT INTO arwm_paymethods_currencies VALUES('5','1');
INSERT INTO arwm_paymethods_currencies VALUES('3','6');
INSERT INTO arwm_paymethods_currencies VALUES('3','1');
INSERT INTO arwm_paymethods_currencies VALUES('2','1');
INSERT INTO arwm_paymethods_currencies VALUES('2','6');


# Structure of table arwm_paymethods_deliverymethods
DROP TABLE IF EXISTS `arwm_paymethods_deliverymethods`;
CREATE TABLE `arwm_paymethods_deliverymethods` (
  `pmid` mediumint(6) unsigned NOT NULL,
  `dmid` mediumint(6) unsigned NOT NULL,
  KEY `pmid` (`pmid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_paymethods_deliverymethods
INSERT INTO arwm_paymethods_deliverymethods VALUES('1','2');
INSERT INTO arwm_paymethods_deliverymethods VALUES('1','1');
INSERT INTO arwm_paymethods_deliverymethods VALUES('2','2');
INSERT INTO arwm_paymethods_deliverymethods VALUES('3','2');
INSERT INTO arwm_paymethods_deliverymethods VALUES('3','1');
INSERT INTO arwm_paymethods_deliverymethods VALUES('5','2');


# Structure of table arwm_pm_data
DROP TABLE IF EXISTS `arwm_pm_data`;
CREATE TABLE `arwm_pm_data` (
  `mod_name` varchar(32) NOT NULL,
  `orderid` int(11) unsigned NOT NULL,
  `data` text NOT NULL,
  KEY `mod_name` (`mod_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_pm_data


# Structure of table arwm_pm_settings
DROP TABLE IF EXISTS `arwm_pm_settings`;
CREATE TABLE `arwm_pm_settings` (
  `mod_name` varchar(32) NOT NULL,
  `sname` varchar(64) NOT NULL,
  `svalue` varchar(255) NOT NULL,
  KEY `mod_name` (`mod_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_pm_settings
INSERT INTO arwm_pm_settings VALUES('robokassa','login','Proekti_documents');
INSERT INTO arwm_pm_settings VALUES('robokassa','pass1','SPyc4oqYm0TtmK43coOXqX1PaS8=');
INSERT INTO arwm_pm_settings VALUES('robokassa','pass2','QYeDjIas/i6d+roXVpKw5i8fQWo=');
INSERT INTO arwm_pm_settings VALUES('robokassa','lang','ru');
INSERT INTO arwm_pm_settings VALUES('robokassa','test_srv','0');


# Structure of table arwm_settings
DROP TABLE IF EXISTS `arwm_settings`;
CREATE TABLE `arwm_settings` (
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `setname` varchar(64) NOT NULL,
  `setvalue` varchar(255) NOT NULL,
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_settings
INSERT INTO arwm_settings VALUES('1','users_recordsonpage','20');
INSERT INTO arwm_settings VALUES('1','orders_recordsonpage','20');
INSERT INTO arwm_settings VALUES('1','visitlog_recordsonpage','300');
INSERT INTO arwm_settings VALUES('1','set_img_chmod','1');
INSERT INTO arwm_settings VALUES('1','img_chmod','0644');
INSERT INTO arwm_settings VALUES('1','set_rfiles_chmod','1');
INSERT INTO arwm_settings VALUES('1','rfiles_chmod','0644');
INSERT INTO arwm_settings VALUES('1','gen_smimg_width','288');
INSERT INTO arwm_settings VALUES('1','gen_smimg_width_gal','288');
INSERT INTO arwm_settings VALUES('1','notify_ch_status','1');
INSERT INTO arwm_settings VALUES('1','wysiwyg','tinymce');
INSERT INTO arwm_settings VALUES('1','stat_ordersonpage','100');
INSERT INTO arwm_settings VALUES('1','pre_delete_img','1');
INSERT INTO arwm_settings VALUES('1','simg_smoothing','0');
INSERT INTO arwm_settings VALUES('1','qpnewpcom','10');
INSERT INTO arwm_settings VALUES('1','sess_ip','0');
INSERT INTO arwm_settings VALUES('1','csv_export_charset','windows-1251');
INSERT INTO arwm_settings VALUES('1','csv_import_charset','windows-1251');
INSERT INTO arwm_settings VALUES('1','chpu_auto_translit','1');
INSERT INTO arwm_settings VALUES('2','url','http://docs-proekt.shop/');
INSERT INTO arwm_settings VALUES('2','design','neutral');
INSERT INTO arwm_settings VALUES('2','quantity_columns','3');
INSERT INTO arwm_settings VALUES('2','pages_title','Интернет-магазин');
INSERT INTO arwm_settings VALUES('2','products_onpage','20');
INSERT INTO arwm_settings VALUES('2','static_urls','1');
INSERT INTO arwm_settings VALUES('2','counter','1');
INSERT INTO arwm_settings VALUES('2','visitlog','1');
INSERT INTO arwm_settings VALUES('2','time_diff','0');
INSERT INTO arwm_settings VALUES('2','def_currency','1');
INSERT INTO arwm_settings VALUES('2','curr_brief','руб');
INSERT INTO arwm_settings VALUES('2','lang','rus');
INSERT INTO arwm_settings VALUES('2','def_country','182');
INSERT INTO arwm_settings VALUES('2','new_products_type','');
INSERT INTO arwm_settings VALUES('2','index_file','');
INSERT INTO arwm_settings VALUES('2','order_without_register','1');
INSERT INTO arwm_settings VALUES('2','email','docs_shop@arhiv-proekt.ru');
INSERT INTO arwm_settings VALUES('2','q_new_products','8');
INSERT INTO arwm_settings VALUES('2','search_type','2');
INSERT INTO arwm_settings VALUES('2','shop_name','DOCs_SHOP  -  Интернет-магазин');
INSERT INTO arwm_settings VALUES('2','sSiteName','Интернет-магазин');
INSERT INTO arwm_settings VALUES('2','smallimg_width','');
INSERT INTO arwm_settings VALUES('2','q_new_news','10');
INSERT INTO arwm_settings VALUES('2','mail_order_admin','1');
INSERT INTO arwm_settings VALUES('2','mail_order_shopper','1');
INSERT INTO arwm_settings VALUES('2','order_subject','Ваш заказ в интернет-магазине');
INSERT INTO arwm_settings VALUES('2','max_contentmenuitems','50');
INSERT INTO arwm_settings VALUES('2','import_format','2ECCEFE76A20F1C75429BF3E97874E58');
INSERT INTO arwm_settings VALUES('2','export_format','18EB7CAA712F4CFE7E4C370B788C90CB');
INSERT INTO arwm_settings VALUES('2','gallery_q_columns','2');
INSERT INTO arwm_settings VALUES('2','gal_smimg_width','');
INSERT INTO arwm_settings VALUES('2','antibot_register','0');
INSERT INTO arwm_settings VALUES('2','antibot_order','0');
INSERT INTO arwm_settings VALUES('2','antibot_feedback','0');
INSERT INTO arwm_settings VALUES('2','show_quantity','1');
INSERT INTO arwm_settings VALUES('2','use_smtp','0');
INSERT INTO arwm_settings VALUES('2','submenu_level','5');
INSERT INTO arwm_settings VALUES('2','sortpr_desc','1');
INSERT INTO arwm_settings VALUES('2','sort_products','id');
INSERT INTO arwm_settings VALUES('2','item_title_cat','1');
INSERT INTO arwm_settings VALUES('2','index_text','YWU1OGI2Njg=');
INSERT INTO arwm_settings VALUES('2','email2','');
INSERT INTO arwm_settings VALUES('2','pr_cnt_reduction','0');
INSERT INTO arwm_settings VALUES('2','admin_order_subj','Новый заказ {order_number} в интернет-магазине');
INSERT INTO arwm_settings VALUES('2','shop_sender_only','1');
INSERT INTO arwm_settings VALUES('2','pd_big_img','0');
INSERT INTO arwm_settings VALUES('2','bigimg_width','');
INSERT INTO arwm_settings VALUES('2','mnf_sort_products','price');
INSERT INTO arwm_settings VALUES('2','mnf_sortpr_desc','0');
INSERT INTO arwm_settings VALUES('2','not_show_auth_links','0');
INSERT INTO arwm_settings VALUES('2','maincat_qcolumns','0');
INSERT INTO arwm_settings VALUES('2','main_maxsubcats','5');
INSERT INTO arwm_settings VALUES('2','q_mmnf','500');
INSERT INTO arwm_settings VALUES('2','mnu_smimg_width','');
INSERT INTO arwm_settings VALUES('2','imgin_newpr','1');
INSERT INTO arwm_settings VALUES('2','imgin_special','1');
INSERT INTO arwm_settings VALUES('2','q_mcat','500');
INSERT INTO arwm_settings VALUES('2','on_mcart','1');
INSERT INTO arwm_settings VALUES('2','paid_order_status','8');
INSERT INTO arwm_settings VALUES('2','sort_onlycatmnf','1');
INSERT INTO arwm_settings VALUES('2','similar','1');
INSERT INTO arwm_settings VALUES('2','show_quantity_main','1');
INSERT INTO arwm_settings VALUES('2','on_pcomm','1');
INSERT INTO arwm_settings VALUES('2','reg_def_group','1');
INSERT INTO arwm_settings VALUES('2','sbcpr','0');
INSERT INTO arwm_settings VALUES('2','lptype','0');
INSERT INTO arwm_settings VALUES('2','lctype','0');
INSERT INTO arwm_settings VALUES('2','vcatname','catalog/');
INSERT INTO arwm_settings VALUES('2','cache','0');
INSERT INTO arwm_settings VALUES('2','autopay_status_only','-1');
INSERT INTO arwm_settings VALUES('2','s_mVertAdv','no');
INSERT INTO arwm_settings VALUES('2','mail_delay','0.4');
INSERT INTO arwm_settings VALUES('2','prLstNoMain','nSDescr');
INSERT INTO arwm_settings VALUES('2','prLstNoCat','nSDescr');
INSERT INTO arwm_settings VALUES('2','prLstNoMnf','nSDescr');
INSERT INTO arwm_settings VALUES('2','prLstNoSrch','nSDescr');
INSERT INTO arwm_settings VALUES('2','def_show_currency','0');
INSERT INTO arwm_settings VALUES('2','s_mMnf','');
INSERT INTO arwm_settings VALUES('2','s_mCat','');
INSERT INTO arwm_settings VALUES('2','mnu_onlycatmnf','0');
INSERT INTO arwm_settings VALUES('2','s_mNewProd','');
INSERT INTO arwm_settings VALUES('2','s_mContent','');
INSERT INTO arwm_settings VALUES('2','s_mNews','');
INSERT INTO arwm_settings VALUES('2','s_mSpecOff','');
INSERT INTO arwm_settings VALUES('2','s_mLoginFrm','');
INSERT INTO arwm_settings VALUES('2','cart_add','0');
INSERT INTO arwm_settings VALUES('2','nmtext_om','0');
INSERT INTO arwm_settings VALUES('2','currency_selection','1');
INSERT INTO arwm_settings VALUES('2','show_all_lnk','1');
INSERT INTO arwm_settings VALUES('2','logo_image_neutral','{design_url}img/logo.png');
INSERT INTO arwm_settings VALUES('4','host','localhost');
INSERT INTO arwm_settings VALUES('4','port','25');
INSERT INTO arwm_settings VALUES('4','helo','localhost');
INSERT INTO arwm_settings VALUES('4','auth','0');
INSERT INTO arwm_settings VALUES('4','user','');
INSERT INTO arwm_settings VALUES('4','pass','');
INSERT INTO arwm_settings VALUES('4','timeout','20');
INSERT INTO arwm_settings VALUES('6','email_req','0');
INSERT INTO arwm_settings VALUES('6','pubreg_only','0');
INSERT INTO arwm_settings VALUES('6','add_comm','all');
INSERT INTO arwm_settings VALUES('6','name_req','0');
INSERT INTO arwm_settings VALUES('6','productonpg','0');
INSERT INTO arwm_settings VALUES('6','qpcomm','40');
INSERT INTO arwm_settings VALUES('6','reverse_sort','0');
INSERT INTO arwm_settings VALUES('6','pub_email','0');
INSERT INTO arwm_settings VALUES('6','name_empty','Гость');
INSERT INTO arwm_settings VALUES('6','admin_name','Администратор');
INSERT INTO arwm_settings VALUES('6','com_minlen','0');
INSERT INTO arwm_settings VALUES('6','com_maxlen','32767');
INSERT INTO arwm_settings VALUES('6','cut_com','1');
INSERT INTO arwm_settings VALUES('6','premoderate','0');
INSERT INTO arwm_settings VALUES('6','notifi_admin','1');
INSERT INTO arwm_settings VALUES('6','antibot','0');
INSERT INTO arwm_settings VALUES('7','period','4320');
INSERT INTO arwm_settings VALUES('7','nocacheAdmin','0');
INSERT INTO arwm_settings VALUES('7','nocacheModules','');
INSERT INTO arwm_settings VALUES('2','sm_config','4D5455334E7A63774E7A63334E413D3D');
INSERT INTO arwm_settings VALUES('2','db_version','3.3');
INSERT INTO arwm_settings VALUES('2','nonames_mailheaders','0');
INSERT INTO arwm_settings VALUES('2','sort_nostock_last','0');
INSERT INTO arwm_settings VALUES('2','no_price_fraction','0');
INSERT INTO arwm_settings VALUES('2','null_price_text','');
INSERT INTO arwm_settings VALUES('2','pub_group_discounts','0');
INSERT INTO arwm_settings VALUES('2','pub_all_discounts','0');
INSERT INTO arwm_settings VALUES('2','cart_add_q0','0');
INSERT INTO arwm_settings VALUES('2','nocart_add_price0','0');
INSERT INTO arwm_settings VALUES('2','header_text','DOCS_SHOP - интернет магазин');
INSERT INTO arwm_settings VALUES('2','footer_text','АРХИВ ПРОЕКТОВ  www.arhiv-proekt.ru');


# Structure of table arwm_txtsettings
DROP TABLE IF EXISTS `arwm_txtsettings`;
CREATE TABLE `arwm_txtsettings` (
  `setname` varchar(32) NOT NULL,
  `setvalue` mediumtext NOT NULL,
  PRIMARY KEY (`setname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_txtsettings
INSERT INTO arwm_txtsettings VALUES('agreement','');
INSERT INTO arwm_txtsettings VALUES('yml_items','');
INSERT INTO arwm_txtsettings VALUES('pr_comm_stop_words','');
INSERT INTO arwm_txtsettings VALUES('reg_allow_groups','');


# Structure of table arwm_users
DROP TABLE IF EXISTS `arwm_users`;
CREATE TABLE `arwm_users` (
  `userid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `pwd` char(32) NOT NULL,
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `regdate` int(11) unsigned NOT NULL DEFAULT '0',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `country` smallint(4) NOT NULL DEFAULT '0',
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_users
INSERT INTO arwm_users VALUES('1','Анатолий','cc816145fa84b4b6e02cff0df2026914','1','sav27951@gmail.com','1577711784','Анатолий','','','','182','','','','');
INSERT INTO arwm_users VALUES('2','alensav','cc816145fa84b4b6e02cff0df2026914','1','sav27951@mail.ru','1578070223','Анатолий','','','','182','','','','');


# Structure of table arwm_users_groups
DROP TABLE IF EXISTS `arwm_users_groups`;
CREATE TABLE `arwm_users_groups` (
  `groupid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL,
  `min_order_sum` decimal(15,2) NOT NULL,
  `descript` text NOT NULL,
  `autochgroup` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `autochgroup_sum` decimal(15,2) NOT NULL DEFAULT '9999999999999.99',
  `sortid` mediumint(5) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


# Dump Data of table arwm_users_groups
INSERT INTO arwm_users_groups VALUES('1','Покупатели','0.00','В данную группу входят все пользователи, которые не состоят в других группах, а также не зарегистрированные покупатели.','0','9999999999999.99','0');
INSERT INTO arwm_users_groups VALUES('2','Постоянные покупатели','0.00','','0','9999999999999.99','0');


# Structure of table arwm_users_groups_discounts
DROP TABLE IF EXISTS `arwm_users_groups_discounts`;
CREATE TABLE `arwm_users_groups_discounts` (
  `did` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` mediumint(5) unsigned NOT NULL,
  `order_sum` decimal(15,2) NOT NULL,
  `discount` char(5) NOT NULL,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_users_groups_discounts


# Structure of table arwm_visitlog
DROP TABLE IF EXISTS `arwm_visitlog`;
CREATE TABLE `arwm_visitlog` (
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `forwarded` varchar(255) NOT NULL,
  `request` varchar(255) NOT NULL,
  `referer` varchar(4096) NOT NULL,
  `useragent` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Structure of table arwm_wm_merchant
DROP TABLE IF EXISTS `arwm_wm_merchant`;
CREATE TABLE `arwm_wm_merchant` (
  `orderid` int(11) unsigned NOT NULL,
  `wmm_data` text NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_wm_merchant


# Structure of table arwm_wm_merchant_conf
DROP TABLE IF EXISTS `arwm_wm_merchant_conf`;
CREATE TABLE `arwm_wm_merchant_conf` (
  `sname` varchar(64) NOT NULL,
  `svalue` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_wm_merchant_conf
INSERT INTO arwm_wm_merchant_conf VALUES('test_mode','0');
INSERT INTO arwm_wm_merchant_conf VALUES('msk','N9Z5/u+kNYcc4o8=');
INSERT INTO arwm_wm_merchant_conf VALUES('ck','NDk4YzVkZWQ=');


# Structure of table arwm_wm_purses
DROP TABLE IF EXISTS `arwm_wm_purses`;
CREATE TABLE `arwm_wm_purses` (
  `pursetype` char(1) NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pursenumber` char(13) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump Data of table arwm_wm_purses
INSERT INTO arwm_wm_purses VALUES('Z','3','');
INSERT INTO arwm_wm_purses VALUES('E','0','');
INSERT INTO arwm_wm_purses VALUES('R','1','P139828524241');
INSERT INTO arwm_wm_purses VALUES('U','0','');
INSERT INTO arwm_wm_purses VALUES('B','0','');
INSERT INTO arwm_wm_purses VALUES('Y','0','');
INSERT INTO arwm_wm_purses VALUES('K','0','');
INSERT INTO arwm_wm_purses VALUES('V','0','');
INSERT INTO arwm_wm_purses VALUES('G','0','');
INSERT INTO arwm_wm_purses VALUES('H','0','');
INSERT INTO arwm_wm_purses VALUES('X','0','');
INSERT INTO arwm_wm_purses VALUES('D','0','');


