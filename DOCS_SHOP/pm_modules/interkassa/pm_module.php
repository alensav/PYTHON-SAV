<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }


global $engineconf, $interkassa, $pmmod_conf;
$engineconf = engine_conf();
 if(! file_exists(PM_MODULES_DIR."/interkassa/pmmod_conf.php")){
 die('Платежный модуль не настроен. Описание настройки этого модуля в файле '.PM_MODULES_DIR."/interkassa/README.html");
 }
require_once(PM_MODULES_DIR."/interkassa/pmmod_conf.php");
require_once(PM_MODULES_DIR."/interkassa/interkassa.php");
$interkassa=new interkassa;
$interkassa->loadlng();

$act = isset($_GET['act']) ? $_GET['act'] : '';

 switch($act){

 case 'interaction':
 echo $interkassa->payment_interaction();
 break;

 case 'fail':
 echo $interkassa->payment_fail();
 break;
 
 case 'success':
 echo $interkassa->payment_success();
 break;

 case 'pending':
 echo $interkassa->payment_pending();
 break;

 default:
 $order_id = get_order_id();
  if($order_id){
  echo $interkassa->payment_form($order_id);
  }

 }

?>