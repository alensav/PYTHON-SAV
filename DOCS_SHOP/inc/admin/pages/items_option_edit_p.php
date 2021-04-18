<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
 $option_id = $_GET['option_id'];
 }
 elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
 $option_id = $_POST['option_id'];
 }

$option_id = intval($option_id);

 if(! empty($_POST['update'])){
 echo update_option($option_id);
 }
 elseif(isset($_GET['del']) && $_GET['del'] == 1){
 echo delete_option_value($_GET['option_value_id']);
 }

echo "<h3>$lang[edit_products_option]</h3>";
echo <<<HTMLDATA
<form action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="items_options">
<input type="hidden" name="act" value="edit_option">
<input type="hidden" name="option_id" value="$option_id">
<input type="hidden" name="update" value="1">
HTMLDATA;

echo get_items_option_values($option_id);

echo <<<HTMLDATA
<table width="100%" class="settbl" border="0">
<tr class="htr">
 <td colspan="2">$lang[add_value]</td>
</tr>
<tr class="htr">
 <td>$lang[value]</td>
 <td>$lang[sort_index]</td>
</tr>
<tr class="str">
 <td><input type="text" name="new_option_value"></td>
 <td><input type="text" name="new_sortid" size="10" value="0"></td>
</tr>
</table><br><br>
<input type="submit" value="$lang[submit]" class="button1">
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=items_options">$lang[all_products_options]</a></p>
HTMLDATA;

function get_items_option_values($option_id){
global $db, $lang;
$tbl=DB_PREFIX.'item_options';
$res = $db->query("SELECT option_name, sortid FROM $tbl WHERE option_id = $option_id") or die($db->error());
$row = $db->fetch_array($res);

$ret = <<<HTMLDATA
<table width="100%" class="settbl" border="0">
<tr class="str">
<td>$lang[option_name]</td>
<td><input type="text" name="main_option_name" value="$row[option_name]"></td>
</tr>
<tr class="ttr">
<td>$lang[sort_index]</td>
<td><input type="text" name="main_sortid" size="10" value="$row[sortid]"></td>
</tr>
</table><br>
HTMLDATA;


$tbl=DB_PREFIX.'item_options_values';
$res = $db->query("SELECT * FROM $tbl WHERE option_id = $option_id ORDER BY sortid, option_value") or die($db->error());

 $ret .= <<<HTMLDATA
<table width="100%" class="settbl" border="0">
<tr class="htr">
 <td colspan="3">$lang[possible_values]</td>
</tr>
<tr class="htr">
 <td>$lang[value]</td>
 <td>$lang[sort_index]</td>
 <td>$lang[delete]</td>
</tr>
HTMLDATA;

$def_class='ttr';

 while($row=$db->fetch_array($res)){
 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

 $ret .= <<<HTMLDATA
<tr class="$def_class">
 <td><input type="text" name="option_value[$row[option_value_id]]" value="$row[option_value]"></td>
 <td><input type="text" name="sortid[$row[option_value_id]]" size="10" value="$row[sortid]"></td>
 <td align="center"><a href="?view=settings&settype=items_options&act=edit_option&option_id=$option_id&option_value_id=$row[option_value_id]&del=1" onclick="return q('$lang[delete_value]')"><img src="adm/img/del.gif" border="0" alt="$lang[delete]"></a></td>
</tr>
HTMLDATA;

 }

$ret.="</table><br></center>";
return $ret;
}


function update_option($option_id){
global $db, $lang, $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$_POST['main_option_name'] = mb_substr(trim($_POST['main_option_name']), 0, 255);
$_POST['main_sortid'] = intval($_POST['main_sortid']);

if(! $_POST['main_option_name']){return "<font class=\"red\">$lang[no_option_name]</font>";}

$tbl=DB_PREFIX.'item_options';
$db->query("UPDATE $tbl SET option_name = '$_POST[main_option_name]', sortid = '$_POST[main_sortid]' WHERE option_id = $option_id") or die($db->error());

$tbl=DB_PREFIX.'item_options_values';

 if(isset($_POST['option_value']) && is_array($_POST['option_value'])){
  if(sizeof($_POST['option_value'])){
   foreach($_POST['option_value'] as $def_option_id => $value){
   $_POST["sortid"]["$def_option_id"] = intval($_POST["sortid"]["$def_option_id"]);
   $db->query("UPDATE $tbl SET option_value = '$value', sortid = " . intval($_POST['sortid']["$def_option_id"]) . " WHERE option_value_id = '$def_option_id'") or die($db->error());
   }
  }
 }


$_POST['new_option_value'] = trim($_POST['new_option_value']);

 if(TDTC == 1 && $_POST['new_option_value']){
 $res = $db->query("SELECT COUNT(*) FROM $tbl WHERE option_id = $option_id") or die($db->error());
  if($db->result($res,0,0) >= 10){
  return mdmogrn("$lang[130] 10 $lang[455]");
  }
 }

$add_optval_msg = '';
 if($_POST['new_option_value']){
 $add_optval_msg = add_item_option_value($option_id);
 }

return "$add_optval_msg<h3>$lang[changes_success]</h3>";
}


function add_item_option_value($option_id){
global $db;
$_POST['new_option_value'] = mb_substr($_POST['new_option_value'], 0, 255);
$_POST['new_sortid'] = intval($_POST['new_sortid']);
$tbl=DB_PREFIX.'item_options_values';
$db->query("INSERT INTO $tbl (option_value_id, option_id, option_value, sortid) VALUES (NULL, $option_id, '$_POST[new_option_value]', $_POST[new_sortid])") or die($db->error());
return '';
}


function delete_option_value($option_value_id){
global $db, $lang, $admin_lib;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$option_value_id = intval($option_value_id);

$tbl=DB_PREFIX.'item_options_values';
$res1 = $db->query("DELETE FROM $tbl WHERE option_value_id = $option_value_id") or die($db->error());

$tbl=DB_PREFIX.'item_options_match';
$res2 = $db->query("DELETE FROM $tbl WHERE option_value_id = $option_value_id") or die($db->error());

if($res1 && $res2){return "<h3>$lang[changes_success]</h3>";}
}
?>