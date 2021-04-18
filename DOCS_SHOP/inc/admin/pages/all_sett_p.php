<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $sett, $admset, $admin_lib, $view;
$custom->get_lang('admin_lang/all_sett');

$settype = '';
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $settype = isset($_GET['settype']) ? preg_replace('/\W/', '', $_GET['settype']) : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $settype = isset($_POST['settype']) ? preg_replace('/\W/', '', $_POST['settype']) : '';
 }

$settype = preg_replace("([^a-z0-9\_\-])", '', $settype);

 if($settype){

  switch($settype){

  case 'global':
  include(INC_DIR."/admin/pages/global_settings_p.php");
  break;

  case 'adminconfig':
  include(INC_DIR."/admin/pages/adm_settings_p.php");
  break;

  case 'changepass':
  include(INC_DIR."/admin/pages/changepass_p.php");
  break;

  case 'mainpage_conf':
  include(INC_DIR."/admin/pages/mainpage_conf_p.php");
  break;

  case 'currencies':
  include(INC_DIR."/admin/pages/currencies_p.php");
  break;

  case 'pay_methods':
  include(INC_DIR."/admin/pages/pay_methods_p.php");
  break;

  case 'items_options':
  include(INC_DIR."/admin/pages/items_options_p.php");
  break;

  case 'delivery_methods':
  include(INC_DIR."/admin/pages/delivery_methods_p.php");
  break;

  case 'users_groups':
  include(INC_DIR."/admin/pages/users_groups_p.php");
  break;

  case 'order_fields':
  include(INC_DIR."/admin/pages/order_fields_p.php");
  break;

  case 'agreement':
  include(INC_DIR."/admin/pages/agreement_p.php");
  break;

  case 'menu':
  include(INC_DIR."/admin/pages/menu_p.php");
  break;

  case 'vertical_blocks':
  include(INC_DIR."/admin/pages/vertical_blocks_p.php");
  break;

  case 'tune_styles':
  include(INC_DIR."/admin/pages/tune_styles_p.php");
  break;

  case 'smtp':
  include(INC_DIR."/admin/pages/smtp_sett_p.php");
  break;

  case 'payment_blanks':
  include(INC_DIR."/admin/pages/payment_blanks_p.php");
  break;

  case 'order_statuses':
  include(INC_DIR."/admin/pages/order_statuses_p.php");
  break;

  case 'add_fields':
  include(INC_DIR."/admin/pages/add_fields_p.php");
  break;
  
  case 'product_comments':
  include(INC_DIR."/admin/pages/product_comments_sett_p.php");
  break;

  case 'reg_allow_groups':
  include(INC_DIR."/admin/pages/reg_allow_groups_p.php");
  break;

  case 'cache':
  include(INC_DIR."/admin/pages/cache_p.php");
  break;

  case 'changepass':
  include(INC_DIR."/admin/pages/changepass_p.php");
  break;

  case 'static_urls':
  include(INC_DIR."/admin/pages/static_urls_p.php");
  break;

  }

 }
 else{
 echo show_slinks();
 }


function show_slinks(){
global $admin_lib, $lang;

$tune_styles = array('', '');
 $tune_styles = array('?view=settings&settype=tune_styles&independ=1', $lang['tune_styles']);

$slinks = array(
 array('?view=settings&settype=global', $lang['basic_config']),
 array('?view=settings&settype=adminconfig', $lang['admin_config']),
 array('?view=settings&settype=mainpage_conf', $lang['mainpage_conf']),
 array('?view=settings&settype=currencies', $lang['currencies']),
 array('?view=settings&settype=pay_methods', $lang['pay_methods']),
 array('?view=settings&settype=delivery_methods', $lang['delivery_methods']),
 array('?view=settings&settype=items_options', $lang['products_options']),
 array('?view=settings&settype=product_comments', $lang['product_comments']),
 array('?view=settings&settype=order_fields', $lang['order_fields']),
 array('?view=settings&settype=add_fields', "$lang[additional_fields]<br>$lang[reg_order_feedback]"),
 array('?view=settings&settype=order_statuses', $lang['order_statuses']),
 array('?view=settings&settype=vertical_blocks', $lang['vertical_blocks']),
 array('?view=settings&settype=menu&menuid=1', $lang['horizontal_menu']),
 array('?view=settings&settype=menu&menuid=2', $lang['vertical_menu']),
 array('?view=settings&settype=users_groups', $lang['users_groups']),
 array('?view=manufacturers', $lang['manufacturers']),
 $tune_styles,
 array('?view=settings&settype=smtp', $lang['smtp_settings']),
 array('?view=settings&settype=payment_blanks', $lang['payment_blanks']),
 array('?view=settings&settype=agreement', $lang['agreement']),
 array('?view=settings&settype=cache', $lang['cache']),
 array('?view=settings&settype=changepass', $lang['changepass'])
);

require_once(INC_DIR.'/admin/after_login.php');
$ret = after_login::check();
$ret .= "<h1>$lang[settings]</h1><ul class=\"allSettings\">";
 foreach($slinks as $arr){
  if($arr[0]){
  $ret.="<li><a href=\"$arr[0]\">$arr[1]</a></li>";
  }
 }
$ret .= '</ul>';
return $ret;
}

?>