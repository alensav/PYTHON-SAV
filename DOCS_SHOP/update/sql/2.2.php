<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}



$tbl=DB_PREFIX.'categories';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `fcatname` VARCHAR(255) NOT NULL AFTER `catid`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

upd2_2_cat_names();




$tbl=DB_PREFIX.'items';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `itemname` VARCHAR(255) NOT NULL AFTER `itemid`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'items';
$query = <<<HTMLDATA
UPDATE `$tbl` SET `itemname` =  `itemid`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'manufacturers';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `mnfname` VARCHAR(255) NOT NULL AFTER `mnf_id`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'manufacturers';
$query = <<<HTMLDATA
UPDATE `$tbl` SET `mnfname` =  `mnf_id`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'news';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `newsname` VARCHAR(255) NOT NULL AFTER `newsid`, ADD `menu_text` TEXT NOT NULL AFTER `title`, ADD `meta_title` VARCHAR(255) NOT NULL, ADD `meta_description` VARCHAR(255) NOT NULL, ADD `meta_keywords` VARCHAR(255) NOT NULL, ADD `meta_tags` TEXT NOT NULL
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'news';
$query = <<<HTMLDATA
UPDATE `$tbl` SET `newsname` = CONCAT('nid', `newsid`)
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'settings';
$query = <<<HTMLDATA
INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES
('2', 'reg_def_group', '1'),
('2', 'old_static', '1');
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'txtsettings';
$query = <<<HTMLDATA
INSERT INTO `$tbl` (`setname`, `setvalue`) VALUES('reg_allow_groups', '')
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }





$tbl=DB_PREFIX.'orders';
$query = <<<HTMLDATA
ALTER TABLE `$tbl`
ADD `def_currency_id` MEDIUMINT(6) UNSIGNED NOT NULL AFTER `currency_course`,
ADD `country_id` SMALLINT(4) UNSIGNED NOT NULL AFTER `company`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }





$tbl=DB_PREFIX.'orders_items';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `oiid` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`oiid`)
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'orders_add_fields_values';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `oafvid` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`oafvid`)
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'add_fields';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `def_value` TEXT NOT NULL AFTER `height`, ADD `pay_methods` TEXT NOT NULL AFTER `add_attributes`
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'payment_blanks';
$query = <<<HTMLDATA
ALTER TABLE `$tbl` ADD `sortid` INT(11) NOT NULL
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }






function upd2_2_cat_names(){
global $db;
$tbl=DB_PREFIX.'categories';
$categories=array();
upd2_2_get_categories_arr($categories);
 if(sizeof($categories)){
  foreach($categories as $catid => $cat_arr){
  $fullcatname=upd2_2_gen_fullcatname($catid, $categories);
  $db->query("UPDATE `$tbl` SET `fcatname` = '$fullcatname' WHERE `catid` = $catid ") or die($db->error());
  }
 }
unset($categories);
}


function upd2_2_get_categories_arr(&$categories){
global $db;
$tbl=DB_PREFIX.'categories';
$res = $db->query("SELECT catid, fcatname, parent FROM $tbl WHERE catid <> 0 ORDER BY sortid, title") or die($db->error());
 while($row=$db->fetch_array($res)){
 $categories["$row[catid]"]['parent']=$row['parent'];
 }
}


function upd2_2_gen_fullcatname($catid, $categories){
$parents_arr=array();
upd2_2_get_all_parents($catid, $parents_arr, $categories);
$ret='';
 if(sizeof($parents_arr)){
  foreach($parents_arr as $parent){
  $ret="$parent/".$ret;
  }
 }
$ret.="$catid";
return $ret;
}


function upd2_2_get_all_parents($cat, &$parents_arr, $categories){
$def_parent=0;
$row=array();
$row['parent']=$cat;

 while($row['parent']> 0){
 $row=$categories["$row[parent]"];

  if($row['parent'] > 0){
  array_push($parents_arr, $row['parent']);
  $def_parent=$row['parent'];
  $row['parent']=upd2_2_get_all_parents($row['parent'], $parents_arr, $categories);
  }

  if($row['parent'] > 0){
  $def_parent=$row['parent'];
  }

 }

 if($def_parent > 0){
 return $def_parent;
 }
 else{
 return $cat;
 }
}



?>