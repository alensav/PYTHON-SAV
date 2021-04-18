<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/orders');
require_once(INC_DIR."/admin/orders.php");
$orders=new orders;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 $orderid = isset($_GET['orderid']) ? intval($_GET['orderid']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 $orderid = intval($_POST['orderid']);
 }

 switch($act){

 case 'detail':
 require_once(INC_DIR."/admin/pages/order_detail_p.php");
 break;

 case 'edit_order':
 require_once(INC_DIR."/admin/pages/edit_order_p.php");
 break;

 case 'edit_order_products':
 require_once(INC_DIR."/admin/pages/edit_order_products_p.php");
 break;

 case 'add_products_in_order':
 require_once(INC_DIR."/admin/pages/add_products_in_order_p.php");
 break;

 case 'next_order':
 require_once(INC_DIR."/admin/pages/next_order_p.php");
 break;

 case 'del':
 $err_code=$orders->delete_order($_GET['orderid']);
  if($err_code == 1){
  echo "<h3>$lang[order_is_deleted]</h3>";
  }
  else{
  echo $err_code;
  }
 echo "<h3>$lang[orders]</h3>";
 echo $orders->get_orders();
 break;
 
 default:
 echo "<h3>$lang[orders]</h3>";
 echo $orders->get_orders();
 }

 if($act=='' || $act==='detail' || $act==='del'){
echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=order_statuses\">$lang[order_statuses]</a> &nbsp;  &nbsp;  &nbsp; <img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=orders&act=next_order\">$lang[next_order]</a></p>";
 }

?>

