<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}





$tbl = DB_PREFIX.'visitlog';
$query = "ALTER TABLE `$tbl` CHANGE `referer` `referer` VARCHAR(4096)";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl = DB_PREFIX.'add_fields';
$query = "ALTER TABLE `$tbl` ADD `def_from_last_order` TINYINT(1) UNSIGNED NOT NULL AFTER `def_value`, ADD `placeholder` TEXT NOT NULL AFTER `def_from_last_order`, ADD `contexthelp` TEXT NOT NULL AFTER `placeholder`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl = DB_PREFIX.'add_fields';
$query = "UPDATE `$tbl` SET `field_name` = CONCAT('field', `field_id`) WHERE `field_name` = ''";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl = DB_PREFIX.'orderfields';
$query = "ALTER TABLE `$tbl` ADD `placeholder` TEXT NOT NULL AFTER `name`, ADD `contexthelp` TEXT NOT NULL AFTER `placeholder`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl = DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES('1', 'chpu_auto_translit', '1')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl = DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES('2', 'currency_selection', '1')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




?>