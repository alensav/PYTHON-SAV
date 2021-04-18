<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class adm_currencies{

function currencies_form(){
global $sett, $lang;
require_once(INC_DIR."/shop.php");
$shop=new shop;
$currencies=$shop->get_currencies(1);
$ret = '';
$clname = 'ttr';

 foreach($currencies as $currency){

  if($currency['currency_id'] == $sett['def_currency']){
  $def_curr_checked = ' checked';
  }
  else{
  $def_curr_checked = '';
  }

 if($currency['enabled']){$enabled_checked=' checked';}else{$enabled_checked='';}

  if($currency['currency_id'] != $sett['def_currency']){
  $del_link="<a href=\"?view=currencies&act=del_currency&curr_id=$currency[currency_id]\" onclick=\"return q('$lang[delete_currency]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a>";
  }
  else{
  $del_link='';
  }

 if($clname=='str'){$clname='ttr';}else{$clname='str';}

 $ret .= <<<HTMLDATA
<tr class="$clname">

<td align="center"><input type="hidden" name="currencies_id[$currency[currency_id]]" value="$currency[currency_id]"><input type="text" name="currencies_title[$currency[currency_id]]" value="$currency[title]" size="20"></td>

<td align="center"><input type="text" name="currencies_brief[$currency[currency_id]]" value="$currency[brief]" size="12" maxlength="10"></td>

<td align="center" nowrap>&nbsp;1: <input type="text" name="currencies_course[$currency[currency_id]]" value="$currency[course]"></td>

<td align="center"><input type="text" name="currencies_iso_alpha[$currency[currency_id]]" value="$currency[iso_alpha]" size="5" maxlength="3"></td>

<td align="center"><input type="text" name="currencies_iso_numeric[$currency[currency_id]]" value="$currency[iso_numeric]" size="5" maxlength="3"></td>

<td align="center"><input type="radio" name="new_sett[def_currency]" value="$currency[currency_id]"$def_curr_checked></td>

<td align="center"><input type="checkbox" name="currencies_enabled[$currency[currency_id]]"$enabled_checked></td>

<td align="center">$del_link</td>

</tr>
HTMLDATA;
 }

return $ret;
}


function save_currencies(){
global $db, $admin_lib, $admin, $custom, $lang, $sett;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$table = DB_PREFIX.'currencies';
$_POST = $custom->replace_quotes_array($custom->trim_array($_POST));

if(! $_POST['new_sett']['def_currency']){return "<p class=\"red\">$lang[choose_def_currency]</p>";}

if(! $_POST["currencies_enabled"][$_POST['new_sett']['def_currency']]){return "<p class=\"red\">$lang[disabled_currency_cant_def]</p>";}

 foreach($_POST['currencies_id'] as $curr_id){
 
 $curr_id = intval($curr_id);

 $_POST['currencies_brief']["$curr_id"] = mb_substr($_POST['currencies_brief']["$curr_id"], 0, 64);

 $_POST['currencies_title']["$curr_id"] = mb_substr($_POST['currencies_title']["$curr_id"], 0, 255);

 $_POST['currencies_course']["$curr_id"] = substr($_POST['currencies_course']["$curr_id"], 0, 35);
 $_POST['currencies_course']["$curr_id"] = str_replace(',', '.', $_POST['currencies_course']["$curr_id"]);
 $_POST['currencies_course']["$curr_id"] = preg_replace('([^0-9\x2E])', '', $_POST['currencies_course']["$curr_id"]);

 if($_POST['new_sett']['def_currency'] == $curr_id){$_POST['currencies_course']["$curr_id"]=1;}

 if($_POST['currencies_course']["$curr_id"] == 0){$_POST['currencies_course']["$curr_id"]=1;}

 $_POST['currencies_iso_alpha']["$curr_id"] = substr(strtoupper($_POST['currencies_iso_alpha']["$curr_id"]), 0, 3);
 $_POST['currencies_iso_numeric']["$curr_id"] = substr($_POST['currencies_iso_numeric']["$curr_id"], 0, 3);

  if(! empty($_POST["currencies_enabled"]["$curr_id"])){
  $enabled = 1;
  }
  else{
  $enabled = 0;
  }

 $res = $db->query("UPDATE `$table` SET `brief` = '".$_POST['currencies_brief'][$curr_id]."', `title` = '".$_POST['currencies_title'][$curr_id]."', `course` = '".$_POST['currencies_course'][$curr_id]."', `enabled` = $enabled, `iso_alpha` = '".$_POST['currencies_iso_alpha'][$curr_id]."', `iso_numeric` = '".$_POST['currencies_iso_numeric'][$curr_id]."' WHERE `currency_id` = '$curr_id'") or die($db->error());
 }

$sett['curr_brief'] = $_POST['currencies_brief'][$_POST['new_sett']['def_currency']];
$_POST['new_sett']['curr_brief'] = $sett['curr_brief'];

$admin_lib->save_settings(2, $_POST['new_sett']);

if($_POST['new_sett']['def_currency']){$sett['def_currency']=$_POST['new_sett']['def_currency'];}

return "<h3>$lang[changes_success]</h3>";
}


function add_currency(){
global $db, $admin_lib, $admin, $custom, $lang;
$table=DB_PREFIX.'currencies';

$_POST=$custom->replace_quotes_array($custom->trim_array($_POST));

if(! $_POST['new_currency_title'] || ! $_POST['new_currency_brief']){return "<p class=\"red\">$lang[fill_all_fields]</p>";}

$_POST['new_currency_brief'] = mb_substr($_POST['new_currency_brief'], 0, 64);

$_POST['new_currency_title'] = mb_substr($_POST['new_currency_title'], 0, 255);

$_POST['new_currency_course'] = substr($_POST['new_currency_course'], 0, 35);
$_POST['new_currency_course'] = str_replace(',', '.', $_POST['new_currency_course']);
$_POST['new_currency_course'] = preg_replace('([^0-9\x2E])', '', $_POST['new_currency_course']);
if($_POST['new_currency_course']==0){$_POST['new_currency_course']=1;}
$_POST['new_currency_iso_alpha'] = substr($_POST['new_currency_iso_alpha'], 0, 3);
$_POST['new_currency_iso_numeric'] = substr($_POST['new_currency_iso_numeric'], 0, 3);

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$res=$db->query("INSERT INTO $table (currency_id, brief, title, course, enabled, iso_alpha, iso_numeric) VALUES(NULL, '$_POST[new_currency_brief]', '$_POST[new_currency_title]', '$_POST[new_currency_course]', 1, '$_POST[new_currency_iso_alpha]', '$_POST[new_currency_iso_numeric]')") or die($db->error());

$currency_id=$db->insert_id();

$tbl_paymethods_currencies=DB_PREFIX.'paymethods_currencies';
$paymethods_id=$this->paymethods_id_arr();
 if(sizeof($paymethods_id)){
  foreach($paymethods_id as $pmid){
  $db->query("INSERT INTO `$tbl_paymethods_currencies` (`pmid`, `currency_id`) VALUES ($pmid, $currency_id)") or die($db->error());
  }
 }

return "<h3>$lang[currency_added]</h3>";
}


function delete_currency($currency_id){
global $db, $admin_lib, $admin, $sett, $lang;
$tbl=DB_PREFIX.'currencies';
$currency_id=intval($currency_id);
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$err='';

 if($currency_id == $sett['def_currency']){
 $err.="$lang[nodelete_def_currency]<br>";
 }

$res=$db->query("SELECT COUNT(*) FROM `$tbl` WHERE `enabled` = 1") or die($db->error());
 if($db->result($res,0,0)<2){
 $err.="$lang[nodelete_only_currency]<br>";
 }

 if($err){
 $err="<p class=\"red\">$err</p>";
 return $err;
 }

$db->query("DELETE FROM `$tbl` WHERE `currency_id` = $currency_id") or die($db->error());

 if($currency_id == $sett['def_show_currency']){
 $_POST['new_sett']['def_show_currency']='0';
 $admin_lib->save_settings(2, $_POST['new_sett']);
 }

return "<h3>$lang[currency_deleted]</h3>";
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
