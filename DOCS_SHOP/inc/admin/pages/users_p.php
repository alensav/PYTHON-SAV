<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/users');
require_once(INC_DIR."/admin/users.php");
$users=new users;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 }

 if($act == 'edit'){
 include(INC_DIR."/admin/pages/user_form_p.php");
 }
 else{
 if($act == 'del_user'){echo $users->delete_user($_GET['userid']);}
 echo "<h3>$lang[users]</h3>";
 echo "<img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=users_groups\">$lang[users_groups]</a><br><br>";
 echo $users->get_users_list();
 echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=users_groups\">$lang[users_groups]</a></p>";

 }

?>
