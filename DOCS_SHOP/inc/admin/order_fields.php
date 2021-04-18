<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class order_fields{

function of_get_orderfields(){
global $db;
$tbl=DB_PREFIX.'orderfields';
$res=$db->query("SELECT * FROM $tbl")or die($db->error());
$ret=array();
 while($row=$db->fetch_array($res)){
 $ret["$row[name]"]=$row;
 }
return $ret;
}

function of_get_grouplist(){
global $db, $sett;
$tbl_users_groups=DB_PREFIX.'users_groups';
$res=$db->query("SELECT `groupid`, `groupname` FROM `$tbl_users_groups` ORDER BY `sortid`") or die($db->error());
$ret='';
 while($row=$db->fetch_array($res)){
  if($row['groupid']==$sett['reg_def_group']){
  $selected=' selected="selected"';
  }
  else{
  $selected='';
  }
 $ret.="<option value=\"$row[groupid]\"$selected>$row[groupname]</option>";
 }
return $ret;
}


function save_order_fields(){
global $db, $admin_lib, $lang;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl = DB_PREFIX.'orderfields';

 if(is_array($_POST['new_fields'])){
  foreach($_POST['new_fields'] as $fieldname => $arr){
  $_POST['new_fields']["$fieldname"]['placeholder'] = isset($_POST['new_fields']["$fieldname"]['placeholder']) ? custom::replace_quotes(stripslashes($_POST['new_fields']["$fieldname"]['placeholder'])) : '';
  $_POST['new_fields']["$fieldname"]['contexthelp'] = isset($_POST['new_fields']["$fieldname"]['contexthelp']) ? stripslashes($_POST['new_fields']["$fieldname"]['contexthelp']) : '';
  $arr['placeholder'] = isset($arr['placeholder']) ? $db->secstr(custom::replace_quotes(stripslashes($arr['placeholder']))) : '';
  $arr['contexthelp'] = $db->secstr($arr['contexthelp']);
  $arr['required'] = intval($arr['required']);
  $arr['enabled'] = intval($arr['enabled']);
  $arr['sortid'] = isset($arr['sortid']) ? intval($arr['sortid']) : 0;
  $db->query("UPDATE $tbl SET `placeholder` = '$arr[placeholder]', `contexthelp` = '$arr[contexthelp]', `required` = '$arr[required]', `enabled` = '$arr[enabled]', `sortid` = '$arr[sortid]' WHERE `name` = '$fieldname'")or die($db->error());
  }
 }

return "<h3>$lang[changes_success]</h3>";
}



}
?>
