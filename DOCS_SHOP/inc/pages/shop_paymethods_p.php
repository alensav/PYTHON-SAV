<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('shop_paymethods');
require_once(INC_DIR."/shop_paymethods.php");
$shop_paymethods=new shop_paymethods;

 if(! empty($_GET['pm'])){
 echo $shop_paymethods->get_method_details($_GET['pm']);
 }
 else{
 $page_tags['meta_title']="$lang[pay_methods] - $sett[pages_title]";
 echo $shop_paymethods->get_paymethods();
 }

?>