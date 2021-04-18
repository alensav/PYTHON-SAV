<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}



$tbl=DB_PREFIX.'pm_data';
$query = <<<HTMLDATA
CREATE TABLE `$tbl` (
  `mod_name` varchar(32) NOT NULL,
  `orderid` int(11) unsigned NOT NULL,
  `data` text NOT NULL,
  KEY `mod_name` (`mod_name`)
) $sql_engine_myisam $sql_default_charset;
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'pm_settings';
$query = <<<HTMLDATA
CREATE TABLE `$tbl` (
  `mod_name` varchar(32) NOT NULL,
  `sname` varchar(64) NOT NULL,
  `svalue` varchar(255) NOT NULL,
  KEY `mod_name` (`mod_name`)
) $sql_engine_myisam $sql_default_charset;
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'pm_settings';
$query = <<<HTMLDATA
INSERT INTO `$tbl` (`mod_name`, `sname`, `svalue`) VALUES
('robokassa', 'login', ''),
('robokassa', 'pass1', ''),
('robokassa', 'pass2', ''),
('robokassa', 'currency_label', 'BANKR'),
('robokassa', 'lang', 'ru'),
('robokassa', 'test_srv', '1');
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




?>