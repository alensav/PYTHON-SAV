<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}



$tbl=DB_PREFIX.'admin';
$query = "ALTER TABLE `$tbl` DROP PRIMARY KEY, ADD `adminid` MEDIUMINT(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`adminid`)";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
 

$tbl=DB_PREFIX.'paymethods';
$query = "ALTER TABLE `$tbl` DROP `type`, CHANGE `short_descript` `short_descript` TEXT NOT NULL, ADD `adv_descript` TEXT NOT NULL AFTER `long_descript`, ADD `adv_descript_mail` TEXT NOT NULL AFTER `adv_descript`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'deliverymethods';
$query = "ALTER TABLE `$tbl` CHANGE `short_descript` `short_descript` TEXT NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'orders';
$query = "ALTER TABLE `$tbl` DROP `paymethod_type`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'orders';
$query = "ALTER TABLE `$tbl` ";
$query .= "MODIFY COLUMN `paymethod_advname` varchar(32) NOT NULL AFTER status, ";
$query .= "MODIFY COLUMN `currency_id` mediumint(6) unsigned NOT NULL AFTER paymethod";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'orders';
$query = "ALTER TABLE `$tbl` ";
$query .= " CHANGE `final_total` `final_total_pc` decimal(15,2) NOT NULL DEFAULT '0.00', ";
$query .= " CHANGE `total_with_delivery` `final_total` decimal(15,2) NOT NULL DEFAULT '0.00'";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'orders';
$query = "ALTER TABLE `$tbl` ";
$query .= "ADD `pmid` mediumint(6) unsigned NOT NULL AFTER `status`, ";
$query .= "ADD `total_pc` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `total`, ";
$query .= "ADD `discount_pc` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `discount`, ";
$query .= "ADD `total_with_discount_pc` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `total_with_discount`, ";
$query .= "ADD `delivery_cost_pc` decimal(15,2) unsigned NOT NULL AFTER `delivery_cost`, ";
$query .= "ADD `dmid` mediumint(6) unsigned NOT NULL AFTER `final_total_pc`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'orders_items';
$query = "ALTER TABLE `$tbl` ADD `price_pc` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `price`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }






$tbl_orders=DB_PREFIX.'orders';
$tbl_orders_items=DB_PREFIX.'orders_items';
$res = $db->query("SELECT orderid, currency_course, total, discount, total_with_discount, delivery_cost, final_total FROM $tbl_orders") or die($db->error());

 while($order_row=$db->fetch_array($res)){

 $currency_course = $order_row['currency_course'];
  if($currency_course <= 0){
  $currency_course = 1;
  }

 $res2 = $db->query("SELECT * FROM $tbl_orders_items WHERE orderid = $order_row[orderid]") or die($db->error());

  while($order_item_row=$db->fetch_array($res2)){

  $price_pc = calc_pcprice($order_item_row['price'], $currency_course);

  $db->query("UPDATE $tbl_orders_items SET price_pc = '$price_pc' WHERE orderid = $order_item_row[orderid] AND itemid = $order_item_row[itemid] AND sku = '$order_item_row[sku]' AND title = '$order_item_row[title]' AND price = '$order_item_row[price]' AND price_pc = '$order_item_row[price_pc]' AND quantity = $order_item_row[quantity] AND options = '$order_item_row[options]'") or die($db->error());

  }

 $total_pc = calc_pcprice($order_row['total'], $currency_course);
 $discount_pc = calc_pcprice($order_row['discount'], $currency_course);
 $total_with_discount_pc = calc_pcprice($order_row['total_with_discount'], $currency_course);
 $delivery_cost_pc = calc_pcprice($order_row['delivery_cost'], $currency_course);
 $final_total_pc = calc_pcprice($order_row['final_total'], $currency_course);

 $db->query("UPDATE $tbl_orders SET total_pc = '$total_pc', discount_pc = '$discount_pc', total_with_discount_pc = '$total_with_discount_pc', delivery_cost_pc = '$delivery_cost_pc', final_total_pc = '$final_total_pc' WHERE orderid = $order_row[orderid]") or die($db->error());

 }


function calc_pcprice($price, $currency_course){
$new_price = pricef($price / $currency_course);
 if($price > 0 && $new_price < 0.01){
 $new_price = '0.01';
 }
return $new_price;
}





$tbl=DB_PREFIX.'payment_blanks';
$query = "ALTER TABLE `$tbl` ADD `blank_title` VARCHAR(255) NOT NULL AFTER `paymethod_id`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
$paymethods_titles = get_paymethods_titles();



$tbl_payment_blanks=DB_PREFIX.'payment_blanks';
$res = $db->query("SELECT * FROM `$tbl_payment_blanks`") or die($db->error());
 while($row = $db->fetch_array($res)){
 $title = trim($paymethods_titles["$row[paymethod_id]"]);
  if(! $title){
  $title = "Blank $row[blank_id]";
  }
 $title = $db->secstr($title);
 $row['blank_text'] = str_replace('{final_total}', '{final_total_pc}', $row['blank_text']);
 $row['blank_text'] = str_replace('{total_integer}', '{final_total_integer}', $row['blank_text']);
 $row['blank_text'] = str_replace('{total_fractional}', '{final_total_fractional}', $row['blank_text']);
 $row['blank_text'] = str_replace('{total_with_delivery}', '{final_total}', $row['blank_text']);
 $row['blank_text'] = $db->secstr($row['blank_text']);
 $db->query("UPDATE `$tbl_payment_blanks` SET `blank_title` = '$title', `blank_text` = '$row[blank_text]' WHERE `blank_id` = $row[blank_id]") or die($db->error());
 }




$tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';
$query = "CREATE TABLE `$tbl_users_groups_discounts` (`did` INT(11) unsigned NOT NULL AUTO_INCREMENT, `groupid` MEDIUMINT(5) unsigned NOT NULL, `order_sum` DECIMAL(15,2) NOT NULL, `discount` CHAR(5) NOT NULL, PRIMARY KEY (`did`)) $sql_engine_myisam $sql_default_charset AUTO_INCREMENT=1";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
 
$tbl_users_groups=DB_PREFIX.'users_groups';
$res = $db->query("SELECT `groupid`, `discount` FROM `$tbl_users_groups`") or die($db->error());
 while($row=$db->fetch_array($res)){
  if($row['discount'] > 0){
  $query = "INSERT INTO $tbl_users_groups_discounts (`did`, `groupid`, `order_sum`, `discount`) VALUES (NULL, $row[groupid], '0.00', '$row[discount]')";
  $res2 = $db->query($query) or add_sql_err($query);
   if($res2){
   add_sql_success($query);
   }
  }
 }
 
$query = "ALTER TABLE `$tbl_users_groups` DROP `discount`, ADD `min_order_sum` DECIMAL(15,2) NOT NULL AFTER `groupname`, ADD `sortid` mediumint(5) NOT NULL";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
 
$tbl=DB_PREFIX.'settings';
$res = $db->query("SELECT `setvalue` FROM `$tbl` WHERE `type` = 2 AND `setname` = 'minimum_order_sum'") or die($db->error());
$row=$db->fetch_array($res);
$row['setvalue']=pricef($row['setvalue']);
 if($row['setvalue'] > 0){
 $query = "UPDATE `$tbl_users_groups` SET `min_order_sum` = '$row[setvalue]'";
 $res = $db->query($query) or add_sql_err($query);
  if($res){
  add_sql_success($query);
  }
 }
$tbl=DB_PREFIX.'settings';
$query = "DELETE FROM `$tbl` WHERE `type` = 2 AND `setname` = 'minimum_order_sum'";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

 
 


$tbl=DB_PREFIX.'items';
$query = "ALTER TABLE `$tbl` ADD `quantity_txt` VARCHAR(255) NOT NULL AFTER `quantity`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'categories';
$query = "ALTER TABLE `$tbl` ADD `menu_img` VARCHAR(255) NOT NULL AFTER `image`, ADD `main_img` VARCHAR(255) NOT NULL AFTER `menu_img`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (type, setname, setvalue) VALUES(2, 'maincat_qcolumns', '0')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (type, setname, setvalue) VALUES(2, 'main_maxsubcats', '5')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl_item_similar=DB_PREFIX.'item_similar';
$query = "CREATE TABLE `$tbl_item_similar` (`itemid` INT(11) unsigned NOT NULL, `similar_itemid` INT(11) unsigned NOT NULL, `sortid` INT(11) NOT NULL) $sql_engine_myisam $sql_default_charset";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl_item_special=DB_PREFIX.'item_special';
$query = "CREATE TABLE `$tbl_item_special` (`sp_itemid` INT(11) unsigned NOT NULL, `sp_sortid` INT(11) NOT NULL) $sql_engine_myisam $sql_default_charset";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'settings';
$query = "DELETE FROM `$tbl` WHERE `type` = 2 AND `setname` = 'q_mmnf'";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
$query = "INSERT INTO `$tbl` (type, setname, setvalue) VALUES(2, 'q_mmnf', '500')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'settings';
$query = "DELETE FROM `$tbl` WHERE `type` = 2 AND `setname` = 'q_mcat'";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
$query = "INSERT INTO `$tbl` (type, setname, setvalue) VALUES(2, 'q_mcat', '500')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }







$tbl=DB_PREFIX.'settings';
$query = "DELETE FROM `$tbl` WHERE `type` = 2 AND `setname` = 'on_mcart'";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
$query = "INSERT INTO `$tbl` (type, setname, setvalue) VALUES(2, 'on_mcart', '1')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }






$tbl=DB_PREFIX.'settings';
$query = "DELETE FROM `$tbl` WHERE `type` = 2 AND `setname` = 'mnu_smimg_width'";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
$query = "INSERT INTO `$tbl` (type, setname, setvalue) VALUES(2, 'mnu_smimg_width', '140')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }
 




$tbl=DB_PREFIX.'wm_merchant_conf';
$query = "CREATE TABLE `$tbl` (`sname` varchar(64) NOT NULL,  `svalue` varchar(255) NOT NULL) $sql_engine_myisam $sql_default_charset";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'wm_merchant_conf';
$wmmset = custom::get_settings(3);
 if(sizeof($wmmset)){
  foreach($wmmset as $name => $value){
   if($name && $name !== 'paid_order_status' && $name !== 'nopaid_order_status' && $name !== 'mailsuccess_admin' && $name !== 'mailsuccess_shopper'){
   $query = "INSERT INTO `$tbl` (`sname`, `svalue`) VALUES('$name', '$value')";
   $res = $db->query($query) or add_sql_err($query);
    if($res){
    add_sql_success($query);
    }
   }
  }
 }

$tbl=DB_PREFIX.'wm_merchant_conf';
global $sett;
$query = "INSERT INTO `$tbl` (`sname`, `svalue`) VALUES('ck', '$sett[index_text]')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

$tbl=DB_PREFIX.'settings';
$query = "INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES(2, 'paid_order_status', '$wmmset[paid_order_status]')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

$tbl=DB_PREFIX.'settings';
$query = "DELETE FROM `$tbl` WHERE `type` = 3";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }

 



$tbl=DB_PREFIX.'add_fields';
$query = "ALTER TABLE `$tbl` ADD `field_name` VARCHAR(64) NOT NULL AFTER `field_id`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'orders_add_fields_values';
$query = "ALTER TABLE `$tbl` ADD `field_name` VARCHAR(64) NOT NULL AFTER `orderid`";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




$tbl=DB_PREFIX.'item_comments';
$query = <<<HTMLDATA
CREATE TABLE `$tbl` (
`comid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`itemid` INT(11) UNSIGNED NOT NULL,
`userid` INT(11) UNSIGNED NOT NULL,
`sender_email` VARCHAR(255) NOT NULL,
`sender_name` VARCHAR(255) NOT NULL,
`cpdate` INT(11) UNSIGNED NOT NULL,
`scomment` TEXT NOT NULL,
`ardate` INT(11) UNSIGNED NOT NULL,
`admin_reply` TEXT NOT NULL,
`visible` TINYINT (1) UNSIGNED NOT NULL,
`sortid` TINYINT (11) NOT NULL,
PRIMARY KEY (`comid`),
INDEX (`itemid`)
) $sql_engine_myisam $sql_default_charset AUTO_INCREMENT=1;
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }



$tbl=DB_PREFIX.'item_comments_new';
$query = <<<HTMLDATA
CREATE TABLE `$tbl` (
`comid` INT(11) UNSIGNED NOT NULL,
`itemid` INT(11) UNSIGNED NOT NULL
) $sql_engine_myisam $sql_default_charset;
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'txtsettings';
$query = "INSERT INTO `$tbl` (`setname`, `setvalue`) VALUES ('pr_comm_stop_words', '')";
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }


$tbl=DB_PREFIX.'settings';
$query = <<<HTMLDATA
INSERT INTO `$tbl` (`type`, `setname`, `setvalue`) VALUES
(6, 'email_req', '0'),
(6, 'pubreg_only', '0'),
(6, 'add_comm', 'all'),
(6, 'name_req', '0'),
(6, 'productonpg', '0'),
(6, 'qpcomm', '40'),
(6, 'reverse_sort', '0'),
(6, 'pub_email', '0'),
(6, 'name_empty', 'Аноним'),
(6, 'admin_name', 'Администратор'),
(6, 'com_minlen', '0'),
(6, 'com_maxlen', '32767'),
(6, 'cut_com', '1'),
(6, 'premoderate', '0'),
(6, 'notifi_admin', '1'),
(6, 'antibot', '0');
HTMLDATA;
$res = $db->query($query) or add_sql_err($query);
 if($res){
 add_sql_success($query);
 }




function get_paymethods_titles(){
global $db;
$tbl=DB_PREFIX.'paymethods';
$ret=array();
$res = $db->query("SELECT pmid, pmtitle FROM `$tbl`") or die($db->error());
 while($row=$db->fetch_array($res)){
 $ret["$row[pmid]"] = $row['pmtitle'];
 }
return $ret;
}


?>