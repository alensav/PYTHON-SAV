<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/delivery_methods');
require_once(INC_DIR."/admin/delivery_methods.php");
$delivery_methods=new delivery_methods;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act=$_POST['act'];
 }

 switch($act){
 case 'edit':
 include(INC_DIR."/admin/pages/deliverymethod_form_p.php");
 break;

 case 'add_deliverymethod':
 include(INC_DIR."/admin/pages/deliverymethod_form_p.php");
 break;

 default:

  if($act=='del_deliverymethod'){
  echo $delivery_methods->delete_delivery_method($_GET['dmid']);
  }

 echo "<h3>$lang[delivery_methods]</h3>";
 echo $delivery_methods->get_delivery_methods() . "<br><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=delivery_methods&act=add_deliverymethod\">$lang[add_delivery_method]</a>";
 }

?>
