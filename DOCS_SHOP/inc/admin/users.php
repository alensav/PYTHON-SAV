<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class users{

function get_users_list(){
global $db, $lang, $sett, $admset;

if(! $admset['users_recordsonpage']){$admset['users_recordsonpage']=20;}

$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 0;
if(! $pg){$pg=1;}

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

 switch($sort){
 case 'date':
 $orderby='userid DESC';
 break;

 case 'login':
 $orderby='username';
 break;

 case 'email':
 $orderby='email';
 break;

 case 'firstname':
 $orderby='first_name';
 break;

 case 'lastname':
 $orderby='last_name';
 break;

 case 'lastname':
 $orderby='last_name';
 break;

 case 'group':
 $orderby='groupid DESC';
 break;

 default:
 $orderby='userid DESC';
 $sort='date';
 }

$record=$pg * $admset['users_recordsonpage'] - $admset['users_recordsonpage'];

$groups=$this->get_users_groups_in_array();
$tbl=DB_PREFIX.'users';

$res=$db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
$quantity_users=$db->result($res,0,0);

$res=$db->query("SELECT userid, username, groupid, email, regdate, first_name, last_name FROM $tbl ORDER BY $orderby LIMIT $record, $admset[users_recordsonpage]") or die($db->error());

$ret="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>&nbsp;<a href=\"?view=users&sort=login\">$lang[login]</a>&nbsp;</td><td>&nbsp;<a href=\"?view=users&sort=email\">$lang[email]</a>&nbsp;</td><td>&nbsp;<a href=\"?view=users&sort=firstname\">$lang[first_name]</a>&nbsp;</td><td>&nbsp;<a href=\"?view=users&sort=lastname\">$lang[last_name]</a>&nbsp;</td><td>&nbsp;<a href=\"?view=users&sort=group\">$lang[group]</a>&nbsp;</td><td>&nbsp;<a href=\"?view=users&sort=date\">$lang[reg_date]</a>&nbsp;</td><td align=\"center\">&nbsp;$lang[delete]&nbsp;</td></tr>";

$def_class = 'ttr';
  while($row=$db->fetch_array($res)){

  if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

  $ret.="<tr class=\"$def_class\"><td>&nbsp;<a href=\"?view=users&act=edit&userid=$row[userid]\">$row[username]</a>&nbsp;</td><td>&nbsp;<a href=\"mailto:$row[email]\">$row[email]</a>&nbsp;</td><td>&nbsp;$row[first_name]&nbsp;</td><td>&nbsp;$row[last_name]&nbsp;</td><td>&nbsp;".$groups["$row[groupid]"]."&nbsp;</td><td>&nbsp;" . date("d.m.Y H:i:s", $row['regdate'] + $sett['time_diff'] * 3600) . "&nbsp;</td><td align=\"center\"><a href=\"?view=users&act=del_user&userid=$row[userid]\" onclick=\"return q('$lang[delete_this_user]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
  }

  $ret.="<tr class=\"ftr\"><td colspan=\"7\" align=\"center\">&nbsp;</td></tr></table><br>";

 $quantity_pages = ceil($quantity_users / $admset['users_recordsonpage']);

 if($quantity_pages > 1){
 $ret.="$lang[pages] ";
 $pagenumber=1;
  while($pagenumber<=$quantity_pages){
   if($pagenumber != $pg){
   $ret.="<a href=\"?view=users&pg=$pagenumber&sort=$sort\">$pagenumber</a> &nbsp;";
   }
   else{
   $ret.="$pagenumber &nbsp;";
   }
  $pagenumber++;
  }
 }

return $ret;
}


function get_users_groups_in_array(){
global $db, $lang;
$tbl=DB_PREFIX.'users_groups';
$res=$db->query("SELECT groupid, groupname FROM $tbl ORDER BY sortid") or die($db->error());
$ret=array();
 while($row=$db->fetch_array($res)){
 $ret["$row[groupid]"]=$row['groupname'];
 }
return $ret;
}



function delete_user($userid){
global $db, $lang, $admin_lib;
$userid=intval($userid);
if(! $userid){return '';}

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(empty($db->handler) || empty($db->dbname)){
 die('Invalid db handler or db name (4)!'); 
 }

$tbl=DB_PREFIX.'users';
$db->query("DELETE FROM `$db->dbname`.$tbl WHERE userid = $userid") or die($db->error());
 if(! isset($lang['user_deleted'])){
 $lang['user_deleted'] = '';
 }
return "<h3>$lang[user_deleted]</h3>";
}



function get_user_info($userid){
global $db;
$userid=intval($userid);
if(! $userid){return '';}
$tbl=DB_PREFIX.'users';
$res=$db->query("SELECT * FROM $tbl WHERE userid = $userid") or die($db->error());
return $db->fetch_array($res);
}



function update_user_info(){
global $db, $custom, $admin_lib, $lang, $sett;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$err_msg = '';
$_POST=$custom->trim_array($_POST);
$_POST['userid']=intval($_POST['userid']);
if(! $_POST['userid']){return '';}

if(! $_POST['username']){$err_msg.="$lang[no_login]<br>";}

$tbl=DB_PREFIX.'users';

$res=$db->query("SELECT COUNT(*) FROM $tbl WHERE username = '$_POST[username]' AND userid != $_POST[userid]") or die($db->error());
 if($db->result($res,0,0) > 0){
 $err_msg.="$lang[user_with_login] \"$_POST[username]\" $lang[already_exist_sol]<br>";
 }

 if(preg_match("([^a-zA-Z0-9\x80-\xFF\x20\_\-])", $_POST['username'])){
 $err_msg.="$lang[invalid_username]<br>";
 }

$_POST['new_password1'] = trim($_POST['new_password1']);
$_POST['new_password2'] = trim($_POST['new_password2']);

 if($_POST['new_password1'] !== $_POST['new_password2']){
 $err_msg.="$lang[passwords_not_coincide]<br>";
 }

 if(preg_match("([^a-zA-Z0-9\x80-\xFF\x20\_\-])", $_POST['new_password1'])){
 $err_msg.="$lang[invalid_pass]<br>";
 }

if($err_msg){return $err_msg;}

$_POST['groupid']=intval($_POST['groupid']);
if(! $_POST['groupid']){$_POST['groupid']=1;}
$_POST['country']=intval($_POST['country']);

$query = "UPDATE $tbl SET username = '$_POST[username]', ";

 if($_POST['new_password1']){
 $query .= "pwd = '" . md5($_POST['new_password1'] . 'Shopper User Password') . "', ";
 }

$query .= "groupid = '$_POST[groupid]', email = '$_POST[email]', first_name = '$_POST[first_name]', last_name = '$_POST[last_name]', patronymic = '$_POST[patronymic]', company = '$_POST[company]', country = '$_POST[country]', city = '$_POST[city]', address = '$_POST[address]', zip_code = '$_POST[zip_code]', phone = '$_POST[phone]' WHERE userid = '$_POST[userid]'";

$res=$db->query($query) or die($db->error());
if(! $res){return 'Eroror!';}


 if($_POST['chgroup_mailnotify'] && $_POST['groupid'] != $_POST['old_groupid']){
 $tbl_users_groups=DB_PREFIX.'users_groups';
 $res = $db->query("SELECT groupname, descript FROM $tbl_users_groups WHERE groupid = $_POST[groupid]") or die($db->error());
 $row = $db->fetch_array($res);
 
 require_once(INC_DIR."/mailer.php");
 $mailer = new mailer;
 $mailtext = $mailer->get_tplfile('admin_change_user_group');
  
 $mailtext = str_replace('{discount}%.', '', $mailtext);
 $mailtext = str_replace('{discount}', '', $mailtext);
 $mailtext = str_replace('%', '', $mailtext);
  
 $mailtext = str_replace('{first_name}', $_POST['first_name'], $mailtext);
 $mailtext = str_replace('{user_group}', $row['groupname'], $mailtext);
 $mailtext = str_replace('{group_description}', strip_tags($row['descript']), $mailtext);
 $mailer->sendemail($sett['shop_name'], $sett['email'], $_POST['first_name'], $_POST['email'], $lang['user_group_changed'], $mailtext);
 }

return 1;
}



}
?>
