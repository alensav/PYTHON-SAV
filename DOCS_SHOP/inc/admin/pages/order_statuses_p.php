<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/order_statuses');

echo "<h3>$lang[order_statuses]</h3>";

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $status_id = isset($_GET['status_id']) ? intval($_GET['status_id']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $status_id = intval($_POST['status_id']);
 }
 else{
 $status_id = 0;
 }

$row = array();

 if(! empty($_POST['save'])){
 $save_res = save_status();
  if($save_res == 1){
  $act = 'edit';
  $row = get_status($_POST['status_id']);
  echo "<h4>$lang[changes_success]</h4>";
  }
  else{
  $row = $custom->stripslashes_array($_POST);
  echo "<p><font class=\"red\">$save_res</font></p>";
  }
 echo status_form($row);
 }
 elseif($act === 'edit'){
 $row = get_status($status_id);
 echo status_form($row);
 }
 elseif($act === 'delete'){
 echo delete_status($status_id);
 echo get_all_statuses();
 $row = get_status($status_id);
 echo status_form($row);
 }
 else{
 echo get_all_statuses();
 echo status_form($row);
 }



function get_all_statuses(){
global $db, $admin_lib, $lang;

$ret = <<<HTMLDATA
<table width="100%" class="settbl" border="0">
<tr class="htr">
<td>$lang[status]</td>
<td align="center">$lang[auto_change_group]</td>
<td align="center">$lang[delete]</td>
</tr>
HTMLDATA;

$tbl=DB_PREFIX.'order_statuses';
$res = $db->query("SELECT * FROM $tbl ORDER BY sortid, name, status_id") or die($db->error());

 while($row = $db->fetch_array($res)){
 $def_class=$admin_lib->sett_class();
  if($row['auto_change_group']){
  $auto_change_group = $lang['yes'];
  }
  else{
  $auto_change_group = $lang['no'];
  }
 $ret.="<tr class=\"$def_class\"><td><a href=\"?view=settings&settype=order_statuses&act=edit&status_id=$row[status_id]\">$row[name]</a></td><td align=\"center\">$auto_change_group</td><td align=\"center\"><a href=\"?view=settings&settype=order_statuses&act=delete&status_id=$row[status_id]\" onclick=\"return q('$lang[delete_status]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
 }

$ret.='</table>';

return $ret;
}


function get_status($status_id){
global $db;
$status_id = intval($status_id);
$tbl=DB_PREFIX.'order_statuses';
$res = $db->query("SELECT * FROM $tbl WHERE status_id = $status_id") or die($db->error());
return $db->fetch_array($res);
}


function save_status(){
global $db, $admin_lib, $lang, $act, $custom;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$err = '';

$tbl=DB_PREFIX.'order_statuses';

 if($act==='add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
   if($db->result($res,0,0) >= 3){
   return mdmogrn("$lang[130] 3 $lang[286]");
   }
  }
 }

$_POST = $custom->trim_array($_POST);

if(! $_POST['name']){$err.="$lang[empty_status_name]<br>";}

$_POST['name'] = mb_substr($_POST['name'], 0, 255);
if(! empty($_POST['auto_change_group'])){$_POST['auto_change_group'] = 1;}else{$_POST['auto_change_group'] = 0;}
$_POST['sortid'] = intval($_POST['sortid']);

if($err){return $err;}

 if($act==='add'){
 $add_res = add_status($tbl);
  if($add_res !== '1'){
  return $add_res;
  }
 }
 elseif($act==='edit'){
 $_POST['status_id'] = intval($_POST['status_id']);
 $db->query("UPDATE $tbl SET name = '$_POST[name]', auto_change_group = $_POST[auto_change_group], sortid = $_POST[sortid] WHERE status_id = $_POST[status_id]") or die($db->error());
 }
 else{
 return '';
 }

return 1;
}



function add_status($tbl){
global $db;
$db->query("INSERT INTO $tbl (status_id, name, auto_change_group, sortid) VALUES (NULL, '$_POST[name]', $_POST[auto_change_group], $_POST[sortid])") or die($db->error());
$_POST['status_id'] = $db->insert_id();
return '1';
}



function delete_status($status_id){
global $db, $admin_lib, $lang;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$status_id = intval($status_id);
$tbl=DB_PREFIX.'order_statuses';
$res = $db->query("DELETE FROM $tbl WHERE status_id = $status_id") or die($db->error());
if($res){return "<h3>$lang[status_is_deleted]</h3>";}else{return "Can't write to database!<br>";}
}


function status_form($row){
global $lang, $act;

$row['sortid'] = isset($row['sortid']) ? intval($row['sortid']) : 0;
$checked = '';
 if(! empty($row['auto_change_group'])){
 $checked = ' checked="checked"';
 }

 if($act == 'edit'){
 $status_action=$lang['edit_status'];
 $form_act = 'edit';
 $action_button_text = $lang['submit'];
 }
 else{
 $status_action=$lang['add_status'];
 $form_act = 'add';
 $action_button_text = $lang['add'];
 }

 if(! isset($row['status_id'])){
 $row['status_id'] = 0;
 }

 if(! isset($row['name'])){
 $row['name'] = '';
 }

return <<<HTMLDATA
<form action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="order_statuses">
<input type="hidden" name="act" value="$form_act">
<input type="hidden" name="save" value="1">
<input type="hidden" name="status_id" value="$row[status_id]">
<center>
<table width="100%" class="settbl" border="0">

<tr class="htr">
<td colspan="2">$status_action</td>
</tr>

<tr class="str">
<td>$lang[status_name]</td>
<td><input type="text" name="name" value="$row[name]"></td>
</tr>

<tr class="ttr">
<td>$lang[sort_index]</td>
<td><input type="text" name="sortid" value="$row[sortid]" size="10"></td>
</tr>

<tr class="str">
<td colspan="2"><input type="checkbox" name="auto_change_group"$checked>$lang[use_auto_change_group]</td>
</tr>

<tr class="ftr"><td colspan="2" align="center"><br><input type="submit" value="$action_button_text" class="button1"></td></tr>
</table>
</center>
</form>
HTMLDATA;
}

if($act !== 'delete'){echo "<img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=order_statuses\">$lang[all_order_statuses]</a>";}

?>