<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }
 

global $engineconf, $robokassa, $rcconf;
$engineconf = engine_conf();
require_once(PM_MODULES_DIR."/robokassa/robokassa.php");
$robokassa=new robokassa;
$rcconf = $robokassa->getrcconfig();
$robokassa->loadlng();

$act = isset($_GET['act']) ? $_GET['act'] : '';

 switch($act){

 case 'result':
 echo $robokassa->payment_result();
 break;

 case 'fail':
 echo $robokassa->payment_fail();
 break;
 
 case 'success':
 echo $robokassa->payment_success();
 break;

 default:
 $order_id = get_order_id();
  if($order_id){
  echo $robokassa->payment_form($order_id);
  }

 }

?>