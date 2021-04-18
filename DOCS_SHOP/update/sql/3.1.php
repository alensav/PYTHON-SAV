<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}





$tbl=DB_PREFIX.'categories';
$query = "ALTER TABLE `$tbl` CHANGE `description` `description` MEDIUMTEXT NOT NULL, CHANGE `special` `special` MEDIUMTEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'content';
$query = "ALTER TABLE `$tbl` CHANGE `metatags` `metatags` TEXT NOT NULL, CHANGE `special` `special` MEDIUMTEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'deliverymethods';
$query = "ALTER TABLE `$tbl` CHANGE `long_descript` `long_descript` MEDIUMTEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'news';
$query = "ALTER TABLE `$tbl` CHANGE `text` `text` MEDIUMTEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'paymethods';
$query = "ALTER TABLE `$tbl` CHANGE `long_descript` `long_descript` MEDIUMTEXT NOT NULL, CHANGE `adv_descript` `adv_descript` MEDIUMTEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




?>