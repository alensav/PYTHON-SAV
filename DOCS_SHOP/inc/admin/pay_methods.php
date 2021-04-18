<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class pay_methods{

function get_pay_methods(){
global $db, $lang;
$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT * FROM `$tbl` ORDER BY `sortid`, `pmtitle`") or die($db->error());

$ret="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>&nbsp;$lang[name]&nbsp;</td><td>&nbsp;$lang[short_descript]&nbsp;</td><td align=\"center\">&nbsp;$lang[on]&nbsp;</td><td align=\"center\">&nbsp;$lang[delete]&nbsp;</td></tr>";

$def_class = 'ttr';

 while($row=$db->fetch_array($res)){
 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}
 if($row['enabled']){$enabled="$lang[yes]";}else{$enabled="$lang[no]";}

 $delete = "<a href=\"?view=settings&settype=pay_methods&act=del_paymethod&pmid=$row[pmid]\" onclick=\"return q('$lang[delete_pay_method]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a>";

 $ret.="<tr class=\"$def_class\"><td><a href=\"?view=settings&settype=pay_methods&act=edit&pmid=$row[pmid]\">$row[pmtitle]</a>&nbsp;</td><td>$row[short_descript]</td><td align=\"center\">$enabled</td><td align=\"center\">$delete</td></tr>";
 }

$ret.="<tr class=\"ftr\"><td colspan=\"4\">&nbsp;</td></tr></table>";
return $ret;
}


function get_available_currencies_list($pmid){
global $db;
$pmid = intval($pmid);
$tbl = DB_PREFIX.'currencies';
$res = $db->query("SELECT currency_id, brief, title FROM $tbl") or die($db->error());
$ret = '';

 while($row=$db->fetch_array($res)){
  if( (isset($_GET['act']) && $_GET['act'] == 'add_paymethod') || $this->is_available_currency($pmid, $row['currency_id'])){
  $selected=' selected';
  }
  else{
  $selected='';
  }
 $ret .= "<option value=\"$row[currency_id]\"$selected>$row[title] ($row[brief])</option>";
 }

return $ret;
}


function is_available_currency($pmid, $currency_id){
 if(! empty($_POST['save'])){
  if(isset($_POST['paymethod_currencies'])){
  if(in_array($currency_id, $_POST['paymethod_currencies'])){return 1;}else{return 0;}
  }
 }
 else{
 global $db;
 $tbl=DB_PREFIX.'paymethods_currencies';
 $res=$db->query("SELECT COUNT(*) FROM $tbl WHERE pmid = $pmid AND currency_id = $currency_id") or die($db->error());
 if($db->result($res,0,0)>0){return 1;}else{return 0;}
 }
}


function is_available_deliverymethod($pmid, $dmid){
 if(! empty($_POST['save'])){
  if(isset($_POST['paymethod_deliverymethods'])){
  if(in_array($dmid, $_POST['paymethod_deliverymethods'])){return 1;}else{return 0;}
  }
 }
 else{
 global $db;
 $tbl=DB_PREFIX.'paymethods_deliverymethods';
 $res=$db->query("SELECT COUNT(*) FROM $tbl WHERE pmid = $pmid AND dmid = $dmid") or die($db->error());
 if($db->result($res,0,0)>0){return 1;}else{return 0;}
 }
}


function get_available_deliverymethods_list($pmid){
global $db;
$pmid=intval($pmid);
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT dmid, dmname FROM $tbl") or die($db->error());
$ret = '';

 while($row=$db->fetch_array($res)){
  if( (isset($_GET['act']) && $_GET['act'] == 'add_paymethod') || $this->is_available_deliverymethod($pmid, $row['dmid'])){
  $selected=' selected';
  }
  else{
  $selected='';
  }
 $ret .= "<option value=\"$row[dmid]\"$selected>$row[dmname]</option>";
 }

return $ret;
}


function get_pminfo($pmid){
global $db;
$pmid=intval($pmid);
$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT * FROM $tbl WHERE pmid = '$pmid'") or die($db->error());
return $db->fetch_array($res);
}


function save_pminfo(){
global $db, $lang, $admin_lib, $custom;
$tbl=DB_PREFIX.'paymethods';

$_POST['pmtitle'] = trim($_POST['pmtitle']);
if(! $_POST['pmtitle']){return "$lang[please_enter_pmtitle]";}
$_POST['pmid'] = intval($_POST['pmid']);

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if($_POST['save']==='add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
   if($db->result($res,0,0) >= 3){
   return mdmogrn("$lang[156] 3 $lang[260]");
   }
  }
 }

 if(! empty($_POST['auto_br_short_descript'])){
 $_POST['short_descript'] = nl2br($_POST['short_descript'], false);
 }

 if(! empty($_POST['auto_br_long_descript'])){
 $_POST['long_descript'] = nl2br($_POST['long_descript'], false);
 }

 if(! empty($_POST['auto_br_adv_descript'])){
 $_POST['adv_descript'] = nl2br($_POST['adv_descript'], false);
 }

$_POST['pmtitle'] = $db->cutstr($_POST['pmtitle'], 255);
$_POST['advname'] = substr(preg_replace("([^a-z0-9\_])", '', $_POST['advname']), 0, 32);
$_POST['short_descript'] = $db->cutstr($_POST['short_descript'], 65535, true);
$_POST['long_descript'] = $db->cutstr($_POST['long_descript'], 16777215, true);
$_POST['adv_descript'] = $db->cutstr($_POST['adv_descript'], 16777215, true);
$_POST['adv_descript_mail'] = $db->cutstr($_POST['adv_descript_mail'], 65535, true);

$_POST['sortid'] = intval($_POST['sortid']);

 if($_POST['save']==='edit' && $_POST['pmid']){
 $db->query("UPDATE $tbl SET pmtitle='$_POST[pmtitle]', advname = '$_POST[advname]', short_descript='$_POST[short_descript]', long_descript='$_POST[long_descript]', adv_descript='$_POST[adv_descript]', adv_descript_mail='$_POST[adv_descript_mail]', enabled='$_POST[enabled]', sortid=$_POST[sortid] WHERE pmid = '$_POST[pmid]'") or die($db->error());
 }
 elseif($_POST['save']==='add'){
 $db->query("INSERT INTO $tbl (pmid, pmtitle, short_descript, long_descript, adv_descript, adv_descript_mail, advname, enabled, sortid) VALUES('$_POST[pmid]', '$_POST[pmtitle]', '$_POST[short_descript]', '$_POST[long_descript]', '$_POST[adv_descript]', '$_POST[adv_descript_mail]', '$_POST[advname]', '$_POST[enabled]', $_POST[sortid])") or die($db->error());
 $_POST['pmid']=$db->insert_id();
 }
 else{
 return 'Invalid POST data!';
 }


$tbl=DB_PREFIX.'paymethods_currencies';
 if($_POST['pmid']){
 $db->query("DELETE FROM $tbl WHERE pmid = $_POST[pmid]") or die($db->error());
 }

 if(is_array($_POST['paymethod_currencies'])){
  if(count($_POST['paymethod_currencies'])){
   foreach($_POST['paymethod_currencies'] as $def_currency_id){
   $def_currency_id = intval($def_currency_id);
   $db->query("INSERT INTO $tbl (pmid, currency_id) VALUES ($_POST[pmid], $def_currency_id)") or die($db->error());
   }
  }
 }


$tbl=DB_PREFIX.'paymethods_deliverymethods';
 if($_POST['pmid']){
 $db->query("DELETE FROM $tbl WHERE pmid = $_POST[pmid]") or die($db->error());
 }

 if(is_array($_POST['paymethod_deliverymethods'])){
  if(count($_POST['paymethod_deliverymethods'])){
   foreach($_POST['paymethod_deliverymethods'] as $def_dmid){
   $def_dmid = intval($def_dmid);
   $db->query("INSERT INTO $tbl (pmid, dmid) VALUES ($_POST[pmid], $def_dmid)") or die($db->error());
   }
  }
 }


return 1;
}


function delete_pay_method($pmid){
global $db, $lang, $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$pmid=intval($pmid);
if(! $pmid){return '';}
$tbl=DB_PREFIX.'paymethods';
$db->query("DELETE FROM $tbl WHERE pmid = '$pmid'") or die($db->error());
$tbl=DB_PREFIX.'paymethods_currencies';
$db->query("DELETE FROM $tbl WHERE pmid = '$pmid'") or die($db->error());
return "<h3>$lang[pm_deleted]</h3>";
}


}
?>
