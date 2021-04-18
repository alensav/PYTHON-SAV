<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}


$tbl=DB_PREFIX.'cache';
$query = <<<HTMLDATA
CREATE TABLE `$tbl` (
 `reqid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
 `request` TEXT NOT NULL,
 `mdate` INT(11) UNSIGNED NOT NULL,
 `http_code` SMALLINT(3) UNSIGNED NOT NULL,
PRIMARY KEY (`reqid`)
) $sql_engine_myisam $sql_default_charset AUTO_INCREMENT=1;
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'visitlog';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` CHANGE `ip` `ip` CHAR(15) NOT NULL, CHANGE `forwarded` `forwarded` VARCHAR(255) NOT NULL
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'cntlastip';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` CHANGE `lastip` `lastip` CHAR(15) NOT NULL
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tst_sett=get_test_settings2_3(2);
$tbl=DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES('7','period','4320'),";
 if(! isset($tst_sett['vcatname'])){
 $query .= "('2', 'vcatname', 'catalog/'),";
 }
 if(! isset($tst_sett['lptype'])){
 $query .= "('2', 'lptype', '0'),";
 }
 if(! isset($tst_sett['lctype'])){
 $query .= "('2', 'lctype', '0'),";
 }
$query = substr($query, 0, strlen($query)-1).';';
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
unset($tst_sett);





function get_test_settings2_3($type){
global $db;
$table=DB_PREFIX.'settings';
$query=$db->query("SELECT setname, setvalue FROM $table WHERE type = $type") or die(header("HTTP/1.1 503 Service Unavailable")."Can't sql_query!");
$settings=array();
while($row=$db->fetch_array($query)){$settings["$row[setname]"]=$row['setvalue'];}
return $settings;
}


?>