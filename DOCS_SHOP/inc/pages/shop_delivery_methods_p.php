<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('delivery_methods');
require_once(INC_DIR."/shop_delivery_methods.php");
$shop_delivery_methods=new shop_delivery_methods;

 if(! empty($_GET['dm'])){
 echo $shop_delivery_methods->get_delivery_method_details($_GET['dm']);
 }
 else{
 $page_tags['meta_title']="$lang[delivery_methods] - $sett[pages_title]";
 echo $shop_delivery_methods->get_delivery_methods();
 }
?>