<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(isset($_POST['next_order'])){
 echo no_set_next_order($_POST['next_order']);
 }

echo no_next_order_form();

function no_next_order_form(){
global $lang;
$next_order = no_get_next_order();
return <<<HTMLDATA
<h1>$lang[next_order]</h1>
<p>$lang[next_order_info]</p>
<form action="?" method="POST">
<input type="hidden" name="view" value="orders">
<input type="hidden" name="act" value="next_order">
<input type="text" name="next_order" value="$next_order"><br><br>
<input type="submit" value="$lang[submit]">
</form>
HTMLDATA;
}

function no_get_next_order(){
global $db;
$tbl = DB_PREFIX.'orders';
$res = $db->query("SHOW TABLE STATUS LIKE '$tbl'") or die($db->error());
$row = $db->fetch_array($res);
return $row['Auto_increment'];
}

function no_set_next_order($next_order){
global $db, $admin_lib, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$tbl = DB_PREFIX.'orders';
$next_order = intval($next_order);
$db->query("ALTER TABLE `$tbl` AUTO_INCREMENT = $next_order") or die($db->error());
return $admin_lib->good_msg($lang['changes_success']);
}

?>