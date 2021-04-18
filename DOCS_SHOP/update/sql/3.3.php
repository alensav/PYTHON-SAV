<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

$tbl = DB_PREFIX.'deliverymethods';
$query = "ALTER TABLE `$tbl` ADD `free_delivery_sum` DECIMAL(15,2) UNSIGNED NOT NULL AFTER `delivery_cost`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

$tbl = DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES('2', 'logo_image_neutral', '{design_url}img/logo.png')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

?>