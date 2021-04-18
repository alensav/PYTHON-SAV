<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $page_tags, $template, $custom;
$custom->get_lang('order');

$page_tags['meta_title']="$lang[order_processing] - $sett[pages_title]";



 if(isset($_SESSION['arwshop_mk']['cart_products']) && sizeof($_SESSION['arwshop_mk']['cart_products']) > 0){
 require_once(INC_DIR."/msg.php");
 require_once(INC_DIR."/add_fields.php");
 $add_fields = new add_fields;

 if(! isset($_POST['step'])){
 $_POST['step'] = '';
 }

  switch($_POST['step']){

  case '1':
   if(empty($_POST['pay_method'])){
   $err_msg=$lang['not_pay_method'];
   include(INC_DIR."/pages/order_step1_p.php");
   break;
   }
  include(INC_DIR."/pages/order_step2_p.php");
  break;

  case '2':
  include(INC_DIR."/pages/order_check_step2_p.php");
  break;

  case '3':
  include(INC_DIR."/pages/order_complete_p.php");
  break;

  default:
  include(INC_DIR."/pages/order_step1_p.php");
  }



 }
 elseif(! empty($_SESSION['arwshop_mk']['order_complete'])){
 include(INC_DIR."/pages/order_complete_p.php");
 }
 else{

 $custom->get_lang('cart');
 require_once(INC_DIR."/cart_c.php");
 $cart=new cart;
 echo $cart->get_cart();
 }

?>