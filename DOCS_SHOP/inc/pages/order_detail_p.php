<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(empty($_SESSION['arwshop_mk']['user']['username']) || ! intval($_SESSION['arwshop_mk']['user']['userid'])){
 include(INC_DIR."/pages/login_p.php");
 }
 else{

 global $page_tags;

 $custom->get_lang('profile');
 $custom->get_lang('register');
 $custom->get_lang("admin_lang/orders");
 $page_tags['meta_title']="$lang[order_info] - $sett[pages_title]";

 require_once(INC_DIR."/profile.php");
 $profile = new profile;
 $order_detail = $profile->get_order_detail($_GET['orderid'], $_SESSION['arwshop_mk']['user']['userid']);

  if($order_detail){
  echo $order_detail;
  }
  else{
  echo $lang['not_permissions'];
  }

 }

?>