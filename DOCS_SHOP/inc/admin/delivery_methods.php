<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class delivery_methods{

function get_delivery_methods(){
global $db, $lang, $sett;
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT * FROM $tbl ORDER BY sortid, dmname") or die($db->error());

$ret="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>&nbsp;$lang[name]&nbsp;</td><td>&nbsp;$lang[short_descript]&nbsp;</td><td align=\"center\">&nbsp;$lang[delivery_cost]&nbsp;</td><td align=\"center\">&nbsp;$lang[on]&nbsp;</td><td align=\"center\">&nbsp;$lang[delete]&nbsp;</td></tr>";

$def_class = 'ttr';

 while($row=$db->fetch_array($res)){
 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}
 if($row['enabled']){$enabled="$lang[yes]";}else{$enabled="$lang[no]";}

 $ret.="<tr class=\"$def_class\"><td>&nbsp;<a href=\"?view=settings&settype=delivery_methods&act=edit&dmid=$row[dmid]\">$row[dmname]</a>&nbsp;</td><td>$row[short_descript]</td><td align=\"right\">$row[delivery_cost]&nbsp;$sett[curr_brief]</td><td align=\"center\">$enabled</td><td align=\"center\"><a href=\"?view=settings&settype=delivery_methods&act=del_deliverymethod&dmid=$row[dmid]\" onclick=\"return q('$lang[delete_delivery_method]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
 }

$ret.="<tr class=\"ftr\"><td colspan=\"5\">&nbsp;</td></tr></table>";
return $ret;
}


function get_dminfo($dmid){
global $db;
$dmid=intval($dmid);
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT * FROM $tbl WHERE dmid = '$dmid'") or die($db->error());
return $db->fetch_array($res);
}


function save_dminfo(){
global $db, $lang, $admin_lib;
$tbl_deliverymethods=DB_PREFIX.'deliverymethods';

$_POST['dmname'] = trim($_POST['dmname']);
if(! $_POST['dmname']){return "$lang[please_enter_dmname]";}
$_POST['dmid'] = intval($_POST['dmid']);

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if($_POST['save']=='add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl_deliverymethods") or die($db->error());
   if($db->result($res,0,0) >= 2){
   return mdmogrn("$lang[156] 2 $lang[273]");
   }
  }
 }

 if(! empty($_POST['auto_br_short_descript'])){
 $_POST['short_descript'] = nl2br($_POST['short_descript'], false);
 }

 if(! empty($_POST['auto_br_long_descript'])){
 $_POST['long_descript'] = nl2br($_POST['long_descript'], false);
 }

$_POST['dmname'] = $db->cutstr($_POST['dmname'], 255);
$_POST['short_descript'] = $db->cutstr($_POST['short_descript'], 65535, true);
$_POST['long_descript'] = $db->cutstr($_POST['long_descript'], 16777215, true);

require_once(INC_DIR."/admin/items.php");
$items=new items;
$_POST['delivery_cost'] = $items->correct_price($_POST['delivery_cost']);
$_POST['free_delivery_sum'] = $items->correct_price($_POST['free_delivery_sum']);
$_POST['sortid'] = intval($_POST['sortid']);
$add_msg = '';

 if($_POST['save']=='edit' && $_POST['dmid']){
 $db->query("UPDATE $tbl_deliverymethods SET dmname='$_POST[dmname]', short_descript='$_POST[short_descript]', long_descript='$_POST[long_descript]', enabled='$_POST[enabled]', delivery_cost='$_POST[delivery_cost]', free_delivery_sum='$_POST[free_delivery_sum]', sortid='$_POST[sortid]' WHERE dmid = '$_POST[dmid]'") or die($db->error());
 }
 elseif($_POST['save']=='add'){
 $add_msg=$this->add_delivery_method();
 }
 else{
 return 'Invalid POST data!';
 }

 if($add_msg){
 return $add_msg;
 }

return '1';
}


function add_delivery_method(){
global $db;
$tbl_deliverymethods=DB_PREFIX.'deliverymethods';
$db->query("INSERT INTO $tbl_deliverymethods (dmid, dmname, short_descript, long_descript, enabled, delivery_cost, free_delivery_sum, sortid) VALUES (NULL, '$_POST[dmname]', '$_POST[short_descript]', '$_POST[long_descript]', '$_POST[enabled]', '$_POST[delivery_cost]', '$_POST[free_delivery_sum]', '$_POST[sortid]')") or die($db->error());
$_POST['dmid']=$db->insert_id();
$this->bind_to_paymethods($_POST['dmid']);
return '';
}


function delete_delivery_method($dmid){
global $db, $lang, $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$dmid=intval($dmid);
if(! $dmid){return '';}
$tbl=DB_PREFIX.'deliverymethods';
$res = $db->query("SELECT COUNT(*) FROM `$tbl`") or die($db->error());
 if($db->result($res,0,0) < 2){
 return "<p class=\"red\">$lang[nodelete_1_dmethod]</p>";
 }
$db->query("DELETE FROM `$tbl` WHERE dmid = '$dmid'") or die($db->error());
return "<h3>$lang[dm_deleted]</h3>";
}



function bind_to_paymethods($dmid){
global $db;
$dmid=intval($dmid);
$tbl=DB_PREFIX.'paymethods_deliverymethods';
$paymethods_id=$this->paymethods_id_arr();
 if(sizeof($paymethods_id)){
  foreach($paymethods_id as $pmid){
  $db->query("INSERT INTO `$tbl` (`pmid`, `dmid`) VALUES ($pmid, $dmid)") or die($db->error());
  }
 }
}



function paymethods_id_arr(){
global $db;
$tbl_paymethods=DB_PREFIX.'paymethods';
$ret=array();
$res=$db->query("SELECT `pmid` FROM `$tbl_paymethods` ORDER BY `sortid`, `pmtitle`") or die($db->error());
 while($row=$db->fetch_array($res)){
 array_push($ret, $row['pmid']);
 }
return $ret;
}


}
?>