<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/products_options');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 }

$all = false;

 switch($act){

 case 'edit_option':
 include(INC_DIR."/admin/pages/items_option_edit_p.php");
 break;

 case 'delete_option':
 include(INC_DIR."/admin/pages/delete_items_option_p.php");
 break;

 default:
 $all = true;
 }


 if($all){

  if($act=='add_option'){
  echo add_items_option();
  }
  elseif($act=='del_option'){
  echo delete_items_option();
  }

 echo "<h3>$lang[products_options]</h3><center>" . get_items_options() . '</center>';

?><form action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="items_options">
<input type="hidden" name="act" value="add_option">
<center>
<table width="100%" class="settbl" border="0">
<tr class="htr">
<td colspan="2"><?php echo $lang['add_products_option']; ?></td>
</tr>
<tr class="str">
<td><?php echo $lang['option_name']; ?></td>
<td><input type="text" name="option_name"></td>
</tr>
<tr class="ttr">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="sortid" value="0" size="10"></td>
</tr>
<tr class="ftr"><td colspan="2" align="center"><br><input type="submit" value="<?php echo $lang['add_products_option']; ?>" class="button1"></td></tr>
</table>
</center>
</form>

 <?php } 


function get_items_options(){
global $db, $lang;
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_values=DB_PREFIX.'item_options_values';
$res = $db->query("SELECT option_id, option_name FROM $tbl_options ORDER BY sortid, option_name") or die($db->error());

$ret="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>&nbsp;$lang[option_name]&nbsp;</td><td>&nbsp;$lang[possible_values]&nbsp;</td><td align=\"center\">&nbsp;$lang[delete]&nbsp;</td></tr>";

$def_class = 'ttr';

 while($row=$db->fetch_array($res)){
 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

 $res2 = $db->query("SELECT COUNT(*) FROM $tbl_options_values WHERE option_id = $row[option_id]") or die($db->error());
 $count = $db->result($res2,0,0);

 $ret.="<tr class=\"$def_class\"><td><a href=\"?view=settings&settype=items_options&act=edit_option&option_id=$row[option_id]\">$row[option_name]</a>&nbsp;</td><td><a href=\"?view=settings&settype=items_options&act=edit_option&option_id=$row[option_id]\">$lang[view_change]&nbsp;&nbsp;($count)</a></td><td align=\"center\"><a href=\"?view=settings&settype=items_options&act=del_option&option_id=$row[option_id]\" onclick=\"return q('$lang[delete_option]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
 }

$ret.="<tr class=\"ftr\"><td colspan=\"3\">&nbsp;</td></tr></table>";

return $ret;
}



function add_items_option(){
global $db, $lang, $admin_lib;
$_POST['option_name'] = trim($_POST['option_name']);
if(! $_POST['option_name']){return "<font class=\"red\">$lang[no_option_name]</font>";}

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl=DB_PREFIX.'item_options';

 if(TDTC == 1){
 $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
  if($db->result($res,0,0) >= 5){
  return mdmogrn("$lang[130] 5 $lang[234]");
  }
 }

$_POST['sortid'] = intval($_POST['sortid']);
$res = $db->query("INSERT INTO $tbl (option_id, option_name, sortid) VALUES(NULL, '$_POST[option_name]', $_POST[sortid])") or die($db->error());
if($res){return "<h3>$lang[changes_success]</h3>";}
}



function delete_items_option(){
global $db, $lang, $admin_lib;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$option_id = intval($_GET['option_id']);
if(! $option_id){return '';}

$tbl=DB_PREFIX.'item_options';
$res1 = $db->query("DELETE FROM $tbl WHERE option_id = $option_id") or die($db->error());

$tbl=DB_PREFIX.'item_options_values';
$res2 = $db->query("DELETE FROM $tbl WHERE option_id = $option_id") or die($db->error());

$tbl=DB_PREFIX.'item_options_match';
$res3 = $db->query("DELETE FROM $tbl WHERE option_id = $option_id") or die($db->error());

if($res1 && $res2 && $res3){return "<h3>$lang[changes_success]</h3>";}
}
?>