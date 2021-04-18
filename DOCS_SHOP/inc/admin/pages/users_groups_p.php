<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/users_groups');
require_once(INC_DIR."/admin/users_groups.php");
$users_groups=new users_groups;


 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 }

 switch($act){
 case 'edit':
 include(INC_DIR."/admin/pages/users_group_form_p.php");
 break;

 case 'add_group':
 include(INC_DIR."/admin/pages/users_group_form_p.php");
 break;

 default:

  if($act=='del_group'){
  echo $users_groups->delete_group($_GET['grid']);
  }

 echo "<h3>$lang[users_groups]</h3>";
 echo "<img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=users_groups&act=add_group\">$lang[add_group]</a> &nbsp; <img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=users\">$lang[users]</a><br><br>";
 echo $users_groups->get_groups();
 echo "<p>$lang[set_orders_statuses] <a href=\"?view=settings&settype=order_statuses\">$lang[in_order_statuses]</a>.</p>"; 
 }

?>
