<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(TDTC == 1 && fudrDv() <= 0 ){
 echo mdvExpt();
 }
 elseif($mod){
 echo $admin_lib->load_admin_module($mod);
 }
 else{


  switch($view){

  case 'settings':
  include(INC_DIR."/admin/pages/all_sett_p.php");
  break;

  case 'visitlog':
  include(INC_DIR."/admin/pages/visitlog_p.php");
  break;

  case 'orders':
  include(INC_DIR."/admin/pages/orders_p.php");
  break;

  case 'orders_statistics':
  include(INC_DIR."/admin/pages/orders_statistics_p.php");
  break;

  case 'users':
  include(INC_DIR."/admin/pages/users_p.php");
  break;

  case 'news':
  include(INC_DIR."/admin/pages/news_adm_p.php");
  break;

  case 'content':
  include(INC_DIR."/admin/pages/content_adm_p.php");
  break;

  case 'manufacturers':
  include(INC_DIR."/admin/pages/manufacturers_p.php");
  break;
  
  case 'filemgr':
  include(INC_DIR."/admin/pages/filemgr_p.php");
  break;

  case 'tools':
  include(INC_DIR."/admin/pages/tools_p.php");
  break;
  
  case 'product':
  include(INC_DIR."/admin/pages/product_p.php");
  break;

  case 'editor':
  include(INC_DIR."/admin/pages/editor_p.php");
  break;

  case 'help':
  include(INC_DIR."/admin/pages/help_p.php");
  break;
  
  case 'payment_blank':
  require_once(INC_DIR."/payment_blank.php");
  $pm_blank=new pm_blank;
  echo $pm_blank->show_pm_blank(1);
  break;

  case 'payment_module':
  require_once(INC_DIR."/pm_modules.php");
  load_admin_payment_module($pmmod);
  break;

  case 'about':
   if(file_exists(INC_DIR.'/admin/pages/about_p.php')){
   include(INC_DIR.'/admin/pages/about_p.php');
   }
  break;

  case 'phpinfo':
  if(! $admin_lib->check_admin_perms()){echo $admin_lib->nosave_perms_msg(); break;}else{phpinfo();}
  break;

  default:
  include(INC_DIR."/admin/pages/main_p.php");

  }


 }


?>