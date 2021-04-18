<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }
 

global $engineconf, $wmmerchant;
$engineconf = engine_conf();
require_once(PM_MODULES_DIR."/wm_merchant/wm_merchant.php");
$wmmerchant=new wmmerchant;
$wmmerchant->loadlng();

 if(! isset($_GET['act'])){
 $_GET['act'] = '';
 }

 switch($_GET['act']){

 case 'result':
 echo $wmmerchant->payment_result();
 break;

 case 'fail':
 echo $wmmerchant->payment_fail();
 break;
 
 case 'success':
 echo $wmmerchant->payment_success();
 break;

 default:
 $order_id = get_order_id();
  if($order_id){
  echo $wmmerchant->payment_form($order_id);
  }

 }

?>