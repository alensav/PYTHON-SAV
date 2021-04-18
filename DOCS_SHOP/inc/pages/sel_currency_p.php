<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

select_currency($_GET['currency_id'], $_GET['redir']);

function select_currency($currency_id, $redir){
global $lang, $custom;
$currency_id=intval($currency_id);
$redir=trim(urldecode($redir));
 if(substr($redir, 0, 1) !== '/' || strstr($redir, 'sel_currency')){
 die('Invalid redir!');
 }
 if($currency_id > 0 && is_valid_currency($currency_id)){
 $_SESSION['arwshop_mk']['show_currency_id'] = $currency_id;
 $shop=new shop;
 $custom->get_lang('cart');
 $is_not_cookie_enabled=$shop->check_cookie();
  if($is_not_cookie_enabled){
  die($is_not_cookie_enabled);
  }
 }
header("Location: $redir");
exit;
}


function is_valid_currency($currency_id){
global $db;
$currency_id=intval($currency_id);
$table=DB_PREFIX.'currencies';
$res=$db->query("SELECT COUNT(*) FROM $table WHERE currency_id = $currency_id AND enabled = 1");
 if($db->result($res, 0, 0) > 0){
 return true;
 }
return false;
}

?>