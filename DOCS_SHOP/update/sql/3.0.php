<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}




$tbl=DB_PREFIX.'cache';
$query = "ALTER TABLE `$tbl` ADD INDEX (`request`(255))";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }





$tbl=DB_PREFIX.'cntlastip';
$query = "ALTER TABLE `$tbl` CHANGE `lastip` `lastip` VARCHAR(255) NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }





$tbl=DB_PREFIX.'visitlog';
$query = "ALTER TABLE `$tbl` CHANGE `ip` `ip` VARCHAR(255) NOT NULL, CHANGE `forwarded` `forwarded` VARCHAR(255) NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }





$tbl=DB_PREFIX.'items';
$query = "ALTER TABLE `$tbl` CHANGE `long_descript` `long_descript` MEDIUMTEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }





global $sett;
$new_sett = array();

 if(empty($sett['on_mspecial'])){
 $new_sett['s_mSpecOff'] = 'no';
 }

 if(empty($sett['on_mlogin'])){
 $new_sett['s_mLoginFrm'] = 'no';
 }

 if(empty($sett['on_mver'])){
 $new_sett['s_mVertAdv'] = 'no';
 }

 if(! empty($sett['wysiwyg'])){
 $new_sett['wysiwyg'] = 'tinymce';
 }

$new_sett['mail_delay'] = '0.4';

require_once(INC_DIR."/admin/admin_lib.php");
$admin_lib = new admin_lib;
$admin_lib->save_settings(2, $new_sett, false);
$admin_lib->delete_settings(2, array('on_mspecial', 'on_mlogin', 'on_mver', 'charset'));







?>