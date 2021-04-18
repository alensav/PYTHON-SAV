<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class users_groups{

function get_groups(){
global $db, $lang, $sett;
$tbl_users_groups=DB_PREFIX.'users_groups';

require_once(INC_DIR."/profile.php");
$profile = new profile;

$res=$db->query("SELECT * FROM $tbl_users_groups ORDER BY sortid") or die($db->error());

$ret="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>&nbsp;$lang[group_name]&nbsp;</td><td>&nbsp;$lang[min_order_sum_abbr]&nbsp;</td><td>&nbsp;$lang[discount]&nbsp;</td><td>&nbsp;$lang[auto_change_group]&nbsp;</td><td align=\"center\">&nbsp;$lang[delete]&nbsp;</td></tr>";

$def_class = 'ttr';

  while($row=$db->fetch_array($res)){

  if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

   if($row['groupid'] != 1){$delete="<a href=\"?view=settings&settype=users_groups&act=del_group&grid=$row[groupid]\" onclick=\"return q('$lang[delete_this_group]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\">";}else{$delete='&nbsp;';}

   if($row['autochgroup']){
   $autochgroup = "$lang[from] $row[autochgroup_sum]&nbsp;$sett[curr_brief]";
   }
   else{
   $autochgroup = $lang['no'];
   }
   
  $min_max_discounts = $profile->get_min_max_group_discounts($row['groupid']);
   if($min_max_discounts[0] != $min_max_discounts[1]){
   $min_max_discounts_str = "$lang[from] $min_max_discounts[0] $lang[to] $min_max_discounts[1]";
   }
   else{
   $min_max_discounts_str = $min_max_discounts[0];
   }

  $ret.="<tr class=\"$def_class\"><td>&nbsp;<a href=\"?view=settings&settype=users_groups&act=edit&grid=$row[groupid]\">$row[groupname]</a>&nbsp;</td><td>&nbsp;$row[min_order_sum]&nbsp;$sett[curr_brief]&nbsp;</td><td>&nbsp;$min_max_discounts_str&nbsp;%&nbsp;</td><td>&nbsp;$autochgroup&nbsp;</td><td align=\"center\">$delete</a></td></tr>";
  }

  $ret.="<tr class=\"ftr\"><td colspan=\"5\" align=\"center\">&nbsp;</td></tr></table>";

return $ret;
}


function get_group_info($grid){
global $db;
$grid=intval($grid);
$tbl=DB_PREFIX.'users_groups';
$res=$db->query("SELECT * FROM $tbl WHERE groupid = $grid") or die($db->error());
return $db->fetch_array($res);
}


function get_groupdiscounts_form($grid){
global $db, $admin_lib, $sett, $lang;
$grid=intval($grid);
$tbl=DB_PREFIX.'users_groups_discounts';
$ret='';
$ret.=<<<HTMLDATA
<table class="settbl">
<tr class="htr"><td colspan="3"><h5 style="margin:0px;">$lang[group_discounts]</h5></td></tr>
<tr class="htr">
 <td>$lang[if_order_sum_from]</td>
 <td>$lang[discount]</td>
 <td class="alignCenter">$lang[delete]</td>
</tr>
HTMLDATA;
$res=$db->query("SELECT * FROM `$tbl` WHERE `groupid` = $grid ORDER BY `order_sum`, `discount`") or die($db->error());
 while($row=$db->fetch_array($res)){
 $def_class=$admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class">
 <td><input type="text" name="order_sum[$row[did]]" size="13" value="$row[order_sum]" maxlength="13">$sett[curr_brief]</td>
 <td><input type="text" name="discount[$row[did]]" size="6" value="$row[discount]" maxlength="5">%</td>
 <td class="alignCenter"><input type="checkbox" name="delete[$row[did]]"></td>
</tr>
HTMLDATA;
 }
 
$ret.='</table><br>';


$ret.=<<<HTMLDATA
<table class="settbl">
<tr class="htr"><td colspan="2"><h5 style="margin:0px;">$lang[add_discount]</h5></td></tr>
<tr class="htr">
 <td>$lang[if_order_sum_from]</td>
 <td>$lang[discount]</td>
</tr>
<tr class="str">
 <td><input type="text" name="add_order_sum" size="13" value="0.00" maxlength="13">$sett[curr_brief]</td>
 <td><input type="text" name="add_discount" size="6" value="0" maxlength="5">%</td>
</tr>
</table><br>
HTMLDATA;

return $ret;
}


function save_group(){
global $db, $lang, $admin_lib, $custom;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl_users_groups=DB_PREFIX.'users_groups';
$tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';

 if($_POST['save']=='add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl_users_groups") or die($db->error());
   if($db->result($res,0,0) >= 2){
   return mdmogrn("$lang[156] 2 $lang[182]");
   }
  }
 }

$_POST['groupname'] = trim($_POST['groupname']);
if(! $_POST['groupname']){return "$lang[please_enter_groupname]";}
$_POST['grid'] = intval($_POST['grid']);

require_once(INC_DIR."/admin/items.php");
$items=new items;
$_POST['min_order_sum'] = $items->correct_price($_POST['min_order_sum']);

 if(! empty($_POST['autochgroup'])){
 $_POST['autochgroup']=1;
 }
 else{
 $_POST['autochgroup']=0;
 }

 if(! isset($_POST['autochgroup_sum'])){
 $_POST['autochgroup_sum'] = '9999999999999.99';
 }

$_POST['autochgroup_sum'] = $items->correct_price($_POST['autochgroup_sum']);

 if($_POST['autochgroup']){
 $autochgroupsum = ", autochgroup_sum = '$_POST[autochgroup_sum]'";
  if($this->is_used_autochgroupsum($_POST['autochgroup_sum'], $_POST['grid'])){
  return $lang['group_sum_already_used'];
  }
 }
 else{
 $autochgroupsum = '';
 }



$_POST['sortid']=intval($_POST['sortid']);
$add_msg = '';

 if($_POST['save']==='edit' && $_POST['grid']){
 $db->query("UPDATE $tbl_users_groups SET groupname = '$_POST[groupname]', min_order_sum =  '$_POST[min_order_sum]', descript = '$_POST[descript]', autochgroup = $_POST[autochgroup]$autochgroupsum, sortid = $_POST[sortid] WHERE groupid = '$_POST[grid]'") or die($db->error());
 }
 elseif($_POST['save']==='add'){
 $add_msg=$this->add_group();
 }
 else{
 return 'Invalid POST data!';
 }
 

 if(isset($_POST['discount']) && is_array($_POST['discount'])){
  foreach($_POST['discount'] as $did => $not_used){
  $did = intval($did);
   if(! empty($_POST['delete']["$did"])){
   $db->query("DELETE FROM $tbl_users_groups_discounts WHERE did = $did") or die($db->error());
   }
   else{
   $order_sum = $items->correct_price($_POST['order_sum']["$did"]);
   $discount = $this->correct_discount($_POST['discount']["$did"]);
   $db->query("UPDATE $tbl_users_groups_discounts SET order_sum = '$order_sum', discount = '$discount' WHERE did = $did") or die($db->error());
   }
  }  
 }
  
  
 if($_POST['grid'] > 0){
  if($_POST['add_order_sum'] > 0 || $_POST['add_discount'] != 0){
  $_POST['add_order_sum'] = $items->correct_price($_POST['add_order_sum']);
  $_POST['add_discount'] = $this->correct_discount($_POST['add_discount']);
  $db->query("INSERT INTO $tbl_users_groups_discounts (did, groupid, order_sum, discount) VALUES (NULL, $_POST[grid], '$_POST[add_order_sum]', '$_POST[add_discount]')") or die($db->error());
  }
 }

 if($add_msg){
 return $add_msg;
 }

return 1;
}


function add_group(){
global $db;
$tbl_users_groups=DB_PREFIX.'users_groups';
$db->query("INSERT INTO $tbl_users_groups (groupid, groupname, min_order_sum, descript, autochgroup, autochgroup_sum, sortid) VALUES(NULL, '$_POST[groupname]', '$_POST[min_order_sum]', '$_POST[descript]', $_POST[autochgroup], '$_POST[autochgroup_sum]', '$_POST[sortid]')") or die($db->error());
$_POST['grid']=$db->insert_id();
return '';
}


function delete_group($grid){
global $db, $lang, $admin_lib;
$grid=intval($grid);
if(! $grid){return '';}
if($grid==1){return "<center><font class=\"red\">$lang[impossible_delete_group]</font></center>";}

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl=DB_PREFIX.'users_groups_discounts';
$db->query("DELETE FROM $tbl WHERE groupid = $grid") or die($db->error());

$tbl=DB_PREFIX.'users_groups';
$db->query("DELETE FROM $tbl WHERE groupid = $grid") or die($db->error());

$tbl=DB_PREFIX.'users';
$db->query("UPDATE $tbl SET groupid = 1 WHERE groupid = $grid") or die($db->error());

return "<h3>$lang[group_deleted]</h3>";
}


function is_used_autochgroupsum($sum, $groupid){
global $db;
$groupid=intval($groupid);
$tbl=DB_PREFIX.'users_groups';

if($groupid){$groupid_sql=" AND groupid <> $groupid";}else{$groupid_sql='';}

$res = $db->query("SELECT autochgroup_sum FROM $tbl WHERE autochgroup = 1$groupid_sql") or die($db->error());
 while($row = $db->fetch_array($res)){
 if($row['autochgroup_sum'] == $sum){return true;}
 }
return false;
}


function correct_discount($discount){
$discount = str_replace(',', '.', $discount);
 if(strlen($discount) > 5){
 $discount = substr($discount, 0, 5);
 }
$discount = preg_replace('([^0-9\x2E])', '', $discount);
 if(substr($discount, 0, 1) === '.'){
 $discount = '0'.$discount;
 }
 if(substr($discount, strlen($discount)-1) === '.'){
 $discount = substr($discount, 0, strlen($discount)-1);
 }
 if(! is_numeric($discount)){
 $discount = 0;
 }
return $discount;
}



}
?>
