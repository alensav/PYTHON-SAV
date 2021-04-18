<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

global $custom, $orders;
$custom->get_lang('pm_modules');

 if(! is_object($orders)){
 require_once(INC_DIR."/admin/orders.php");
 $orders = new orders;
 }


define('PM_NOTIFI_ADMIN', 1);
define('PM_NOTIFI_SHOPPER', 1);

function load_payment_module($pmmod){
global $custom, $page_tags, $sett, $lang;
$pmmod = preg_replace("([^a-z0-9\_\-])", '', $pmmod);
 if(! $pmmod){
 return header404();
 }
 if(is_file(PM_MODULES_DIR."/$pmmod/pm_module.php")){
 $page_tags['meta_title'] = $sett['pages_title'];

$orderid=get_order_id();
 if(is_paid_order($orderid)){
 return "<div style=\"font-size:18px; font-weight:bold;\">$lang[order_is_paid]</div>";
 }

  if(! is_numeric($sett['autopay_status_only'])){
  $sett['autopay_status_only']=-1;
  }
  if($sett['autopay_status_only'] != -1){
  $order_data = get_order_data($orderid);
   if($order_data['order']['status'] != $sett['autopay_status_only']){
   return "<div>$lang[no_allowed_order]</div>";
   }
  }
 $template = new template;
 return $template->include_in_var(PM_MODULES_DIR."/$pmmod/pm_module.php");
 }
 else{
 return header404();
 }
}

function load_admin_payment_module($pmmod){
global $custom;
$pmmod = preg_replace("([^a-z0-9\_\-])", '', $pmmod);
 if(! $pmmod){
 return 'Invalid payment module name!';
 }
 if(is_file(PM_MODULES_DIR."/$pmmod/admin/pm_module.php")){
 include(PM_MODULES_DIR."/$pmmod/admin/pm_module.php");
 }
 else{
 return 'Invalid payment module!';
 }
}


function payment_notifi_admin($order_data){
global $sett, $lang, $mailer;
$order_data['order']['orderid'] = intval($order_data['order']['orderid']);
 if(! $order_data['order']['orderid']){
 return false;
 }
$mailtext = $mailer->get_tplfile('payment_notifi_admin');
$mailtext = str_replace('{first_name}', $order_data['order']['first_name'], $mailtext);
$mailtext = str_replace('{order_number}', $order_data['order']['orderid'], $mailtext);
$mailtext = str_replace('{payment_method}', $order_data['order']['paymethod'], $mailtext);
$mailtext = str_replace('{final_total}', $order_data['order']['final_total'], $mailtext);
$mailtext = str_replace('{final_total_pc}', $order_data['order']['final_total_pc'], $mailtext);
$mailtext = str_replace('{currency_brief}', $order_data['order']['currency_brief'], $mailtext);
$mailtext = str_replace('{def_currency_brief}', $order_data['order']['def_currency_brief'], $mailtext);
return $mailer->sendemail($order_data['order']['first_name'], $order_data['order']['email'], $sett['shop_name'], $sett['email'], "$lang[paid_order_n] N{$order_data[order][orderid]}", $mailtext);
}


function payment_notifi_shopper($order_data){
global $sett, $lang, $mailer;
$order_data['order']['orderid'] = intval($order_data['order']['orderid']);
 if(! $order_data['order']['orderid']){
 return false;
 }
 global $order_id;
$order_id = $order_data['order']['orderid'];
$mailtext = $mailer->get_tplfile('payment_notifi_shopper');
$mailtext = str_replace('{first_name}', $order_data['order']['first_name'], $mailtext);
$mailtext = str_replace('{order_number}', $order_data['order']['orderid'], $mailtext);
$mailtext = str_replace('{payment_method}', $order_data['order']['paymethod'], $mailtext);
$mailtext = str_replace('{final_total}', $order_data['order']['final_total'], $mailtext);
$mailtext = str_replace('{final_total_pc}', $order_data['order']['final_total_pc'], $mailtext);
$mailtext = str_replace('{currency_brief}', $order_data['order']['currency_brief'], $mailtext);
$mailtext = str_replace('{def_currency_brief}', $order_data['order']['def_currency_brief'], $mailtext);
return $mailer->sendemail($sett['shop_name'], $sett['email'], $order_data['order']['first_name'], $order_data['order']['email'], "$lang[payment_confirm]", $mailtext);
}









function get_order_id(){
return isset($_SESSION['arwshop_mk']['order']['order_id']) ? intval($_SESSION['arwshop_mk']['order']['order_id']) : 0;
}


function get_order_data($ord_id){
global $db;
$ret=array();
$ret['order']=array();
$ord_id=intval($ord_id);
 if(! $ord_id){
 return $ret;
 }
$tbl=DB_PREFIX.'orders';
$res = $db->query("SELECT * FROM $tbl WHERE orderid = $ord_id") or die($db->error());
$row = $db->fetch_array($res);
 if(is_array($row)){
  if(sizeof($row)){
   foreach($row as $name => $value){
    if(! is_numeric($name)){
    $ret['order']["$name"] = $value;
    }
   }
  }
 }
return $ret;
}


function get_orders_statuses(){
global $orders;
return $orders->statuses;
}


function is_paid_order($ord_id){
global $sett;
$odt = get_order_data($ord_id);
$sett['paid_order_status'] = intval($sett['paid_order_status']);
 if(isset($odt['order']['status']) && $odt['order']['status'] == $sett['paid_order_status']){
 return true;
 }
return false;
}


function paid_status_name(){
global $orders, $sett;
return $orders->statuses["{$sett['paid_order_status']}"]['name'];

}


function set_order_paid($ord_id){
global $sett, $db, $mailer;
$tbl_orders=DB_PREFIX.'orders';
$ord_id = intval($ord_id);
 if(! $ord_id){
 return false;
 }
$sett['paid_order_status'] = intval($sett['paid_order_status']);
$db->query("UPDATE `$tbl_orders` SET `status` = $sett[paid_order_status] WHERE `orderid` = $ord_id") or die($db->error());

$odt = get_order_data($ord_id);

 if(! $odt['order']['orderid']){
 return false;
 }

require_once(INC_DIR."/mailer.php");
$mailer=new mailer;

 if(PM_NOTIFI_ADMIN == 1){
 payment_notifi_admin($odt);
 }

 if(PM_NOTIFI_SHOPPER == 1){
 payment_notifi_shopper($odt);
 }

require_once(INC_DIR."/admin/orders.php");
$orders = new orders;
$orders->auto_change_user_group($odt['order']['userid']);

return true;
}


function send_email($params){
 if(! is_array($params)){
 return false;
 }
require_once(INC_DIR."/mailer.php");
$mailer=new mailer;
return $mailer->sendemail($params['name_from'], $params['email_from'], $params['name_to'], $params['email_to'], $params['subject'], $params['mail_body']);
}


function sys_version(){
global $custom;
return $custom->floatVersion();
}

?>
