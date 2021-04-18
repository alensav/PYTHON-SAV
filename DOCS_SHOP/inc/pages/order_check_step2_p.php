<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(! empty($_SESSION['arwshop_mk']['user']['userid']) || $sett['order_without_register']){

 $custom->get_lang('register');
 $_POST=$custom->trim_array($_POST);

 require_once(INC_DIR."/shop_order.php");
 $shop_order=new shop_order;
 $err_msg = '';


   if(! $_POST['order_currency']){
   $err_msg="$lang[not_sel_currency]<br>";
   }


 $paymethod_specialinfo = $shop_order->get_paymethod_specialinfo($_SESSION['arwshop_mk']['order']['pay_method']);



  if($shop_order->deliverymethods_count() > 0){
   if(empty($_POST['delivery_method'])){
   $err_msg.="$lang[not_sel_delivery_method]<br>";
   }
  }

 require_once(INC_DIR."/profile.php");
 $profile=new profile;
 global $fields;
 $err_msg .= $profile->check_profile_form($_POST, '', 1);
 $err_msg .= $add_fields->check_fields('order', '', 0, $_SESSION['arwshop_mk']['order']['pay_method']);


  if($sett['antibot_order']){
  $_POST['protect_code']=trim($_POST['protect_code']);
   if(! $_POST['protect_code']){
   $err_msg.="$lang[not_protect_code]<br>";
   }
   elseif($_POST['protect_code'] != $_SESSION['arwshop_mk']['rnd_botcode']){
   $err_msg.="$lang[invalid_protect_code]<br>";
   }
   else{
   unset($_SESSION['arwshop_mk']['rnd_botcode']);
   }
  }


  if(! empty($fields['agreement']['required'])){
  if(! $_POST['agreement']){$err_msg.="$lang[agreement_must_agree]<br>";}
  }

  if($err_msg){
  include(INC_DIR."/pages/order_step2_p.php");
  }
  else{
  include(INC_DIR."/pages/order_step3_p.php");
  }



 }
 else{
 include(INC_DIR."/pages/order_step1_p.php");
 }

?>