<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/order_fields');
require_once(INC_DIR."/admin/order_fields.php");
$order_fields=new order_fields;

 if(! empty($_POST['save'])){
 echo save_reg_allowed_groups();
 }

?><!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['allowed_groups']; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#ffffff">
<table width="100%" bgcolor="#ffffff"><tr><td>
<h4 style="margin:3px">
<form name="frmagr" action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="reg_allow_groups">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="save" value="1">
<?php echo $lang['allowed_groups']; ?></h4><?php echo get_reg_allowed_groups(); ?>
<br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1">
</form>
</td></tr></table><br>
</center>
</body>
</html><?php

function get_reg_allowed_groups(){
global $db;
require_once(INC_DIR."/register.php");
$register=new register;
$tbl_users_groups=DB_PREFIX.'users_groups';
$regallowgroups=$register->reg_allowed_groups();
$res=$db->query("SELECT `groupid`, `groupname` FROM `$tbl_users_groups` ORDER BY `sortid`") or die($db->error());
$ret='';
 while($row=$db->fetch_array($res)){
  if(in_array($row['groupid'], $regallowgroups)){
  $checked=' checked="checked"';
  }
  else{
  $checked='';
  }
 $ret.="<input type=\"checkbox\" name=\"allowed_groups[$row[groupid]]\"$checked>$row[groupname]<br>";
 }
return $ret;
}


function save_reg_allowed_groups(){
global $admin_lib, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$data='';
 if(is_array($_POST['allowed_groups'])){
  if(sizeof($_POST['allowed_groups'])){
   foreach($_POST['allowed_groups'] as $groupid => $value){
   $groupid=intval($groupid);
    if($groupid && $value){
    $data.="$groupid;";
    }
   }
  }
 }
$admin_lib->save_txtsettings(array('reg_allow_groups' => $data));
return "<h3>$lang[changes_success]</h3>";
}


?>