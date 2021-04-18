<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/add_fields');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 $field_id = isset($_GET['field_id']) ? intval($_GET['field_id']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 $field_id = intval($_POST['field_id']);
 }
 
 if($act != 'variants'){
 echo "<h1>$lang[additional_fields]</h1>";
 }

$all = false;

 switch($act){

 case 'edit':
 include(INC_DIR."/admin/pages/add_field_form_p.php");
 break;

 case 'add':
 include(INC_DIR."/admin/pages/add_field_form_p.php");
 break;

 case 'variants':
 include(INC_DIR."/admin/pages/add_field_variants_p.php");
 break;

 default:
 $all = true;
 }


 if($all){

  if($act == 'delete'){
  echo delete_field($field_id);
  }

 echo get_all_add_fields();

 } 


function get_all_add_fields(){
global $db, $lang;
$tbl_add_fields=DB_PREFIX.'add_fields';
$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';
$res = $db->query("SELECT * FROM $tbl_add_fields ORDER BY sortid, title") or die($db->error());

$ret="<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=add_fields&act=add\">$lang[add_field]</a></p>";

$ret.="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>$lang[field_name]</td><td align=\"center\">$lang[order_form]</td><td align=\"center\">$lang[feedback_form]</td><td align=\"center\">$lang[delete]</td></tr>";

$def_class = 'ttr';
 while($row=$db->fetch_array($res)){
 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

 if($row['use_in_order']){$row['use_in_order']='+';}else{$row['use_in_order']='-';}
 if($row['use_in_feedback']){$row['use_in_feedback']='+';}else{$row['use_in_feedback']='-';}

 $ret.="<tr class=\"$def_class\"><td><a href=\"?view=settings&settype=add_fields&act=edit&field_id=$row[field_id]\">$row[title]</a></td><td align=\"center\">$row[use_in_order]</td><td align=\"center\">$row[use_in_feedback]</td><td align=\"center\"><a href=\"?view=settings&settype=add_fields&act=delete&field_id=$row[field_id]\" onclick=\"return q('$lang[delete_field]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
 }

$ret.="</table>";

return $ret;
}


function get_field($field_id){
global $db;
$tbl_add_fields=DB_PREFIX.'add_fields';
$field_id = intval($field_id);
$res = $db->query("SELECT * FROM $tbl_add_fields WHERE field_id = $field_id") or die($db->error());
return $db->fetch_array($res);
return $ret;
}


function save_field($field_id){
global $db, $admin_lib, $lang, $act, $custom, $field_id;
$field_id = intval($field_id);

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$err = '';
$tbl_add_fields=DB_PREFIX.'add_fields';

 if($act == 'add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl_add_fields") or die($db->error());
   if($db->result($res,0,0) >= 2){
   return mdmogrn("$lang[130] 2 $lang[247]");
   }
  }
 }

$_POST = $custom->trim_array($_POST);

$_POST['title'] = mb_substr($_POST['title'], 0, 255);
$_POST['type'] = intval($_POST['type']);
if(! empty($_POST['required'])){$_POST['required']=1;}else{$_POST['required']=0;}
if(! empty($_POST['enabled'])){$_POST['enabled']=1;}else{$_POST['enabled']=0;}
if(! empty($_POST['use_in_order'])){$_POST['use_in_order']=1;}else{$_POST['use_in_order']=0;}
if(! empty($_POST['use_in_feedback'])){$_POST['use_in_feedback']=1;}else{$_POST['use_in_feedback']=0;}
$_POST['width'] = intval($_POST['width']);
$_POST['height'] = intval($_POST['height']);
$_POST['sortid'] = intval($_POST['sortid']);

if(! $_POST['type']){$err.="$lang[empty_field_type]<br>";}
if(! $_POST['title']){$err.="$lang[empty_field_title]<br>";}


$_POST['field_name'] = trim($_POST['field_name']);
 if($_POST['field_name']){
  if(preg_match('([^a-zA-Z0-9\_])', $_POST['field_name'])){
  $err.="$lang[invalid_field_name]<br>";
  }
 }
 elseif($field_id > 0){
 $_POST['field_name'] = 'field' . $field_id;
 }

 if($_POST['field_name']){
  if(! is_unique_fieldname($field_id, $_POST['field_name'])){
  $err .= "$lang[not_unique_field_name]<br>";
  }
 }

if($err){return $err;}

$pay_methods_str='';
$sel_pm_arr=array();
 if(is_array($_POST['bind_paymethods'])){
  if(sizeof($_POST['bind_paymethods'])){
   foreach($_POST['bind_paymethods'] as $pmid){
   $pmid=intval($pmid);
   $pay_methods_str.=$pmid.',';
   array_push($sel_pm_arr, $pmid);
   }
  }
 }
 if($pay_methods_str){
 $pay_methods_str=substr($pay_methods_str, 0, strlen($pay_methods_str)-1);
  if(sizeof($sel_pm_arr)==$_POST['pm_all_count']){
  $pay_methods_str='';
  }
 }

 if(! empty($_POST['def_from_last_order'])){
 $_POST['def_from_last_order'] = 1;
 }
 else{
 $_POST['def_from_last_order'] = 0;
 }

$_POST['placeholder'] = custom::replace_quotes(stripslashes($_POST['placeholder']));

 if($act == 'add'){
 $add_result = add_field($tbl_add_fields, $pay_methods_str);
  if(is_numeric($add_result)){
  $field_id = $add_result;
  }
  else{
  return $add_result;
  }
 }
 elseif($act == 'edit'){
 $data = $db->secstr_array($_POST);
 $db->query("UPDATE $tbl_add_fields SET field_name = '$data[field_name]', type = $data[type], title = '$data[title]', required = $data[required], enabled = $data[enabled], use_in_order = $data[use_in_order], use_in_feedback = $data[use_in_feedback], width = $data[width], height = $data[height], def_value = '$data[def_value]', def_from_last_order = '$data[def_from_last_order]', placeholder = '$data[placeholder]', contexthelp = '$data[contexthelp]', add_attributes = '$data[add_attributes]', pay_methods = '$pay_methods_str', sortid = $data[sortid] WHERE field_id = $field_id") or die($db->error());
 }
 else{
 return '';
 }

return 1;
}



function add_field($tbl_add_fields, $pay_methods_str){
global $db;
$data = $db->secstr_array($_POST);
$db->query("INSERT INTO $tbl_add_fields (field_id, field_name, type, title, required, enabled, use_in_order, use_in_feedback, width, height, def_value, def_from_last_order, placeholder, contexthelp, add_attributes, pay_methods, sortid) VALUES (NULL, '$data[field_name]', '$data[type]', '$data[title]', '$data[required]', '$data[enabled]', $data[use_in_order], $data[use_in_feedback], '$data[width]', '$data[height]', '$data[def_value]', '$data[def_from_last_order]', '$data[placeholder]', '$data[contexthelp]', '$data[add_attributes]', '$pay_methods_str', '$data[sortid]')") or die($db->error());
$field_id = $db->insert_id();
 if(empty($_POST['field_name'])){
 $_POST['field_name'] = 'field' . $field_id;
  while(! is_unique_fieldname($field_id, $_POST['field_name'])){
  $_POST['field_name'] = 'field' . rand(1000,1000000);
  }
 $db->query("UPDATE `$tbl_add_fields` SET `field_name` = '".$db->secstr($_POST['field_name'])."' WHERE `field_id` = '$field_id'") or die($db->error());
 }
return $field_id;
}



function delete_field($field_id){
global $db, $admin_lib, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$tbl_add_fields=DB_PREFIX.'add_fields';
$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';
$db->query("DELETE FROM $tbl_add_fields WHERE field_id = $field_id") or die($db->error());
$db->query("DELETE FROM $tbl_add_fields_variants WHERE field_id = $field_id") or die($db->error());
return "<h3>$lang[field_is_deleted]</h3>";
}


function is_unique_fieldname($field_id, $field_name){
global $db;
$field_name = $db->secstr($field_name);
$tbl = DB_PREFIX.'add_fields';
$res = $db->query("SELECT COUNT(*) FROM `$tbl` WHERE `field_id` <> '$field_id' AND `field_name` = '$field_name'") or die($db->error());
 if($db->result($res) > 0){
 return false;
 }



return true;
}


function af_available_pm_list($paymethods_str){
global $db;
$ret=array();
$ret['options']='';
$test_arr=explode(',', $paymethods_str);
$paymethods_arr=array();
 if(sizeof($test_arr)){
  foreach($test_arr as $pmid){
   if(is_numeric($pmid)){
   array_push($paymethods_arr, $pmid);
   }
  }
 }
$size=sizeof($paymethods_arr);
$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT `pmid`, `pmtitle` FROM `$tbl`") or die($db->error());
$pm_all_count=0;
 while($row=$db->fetch_array($res)){
 $pm_all_count++;
  if(! $size || in_array($row['pmid'], $paymethods_arr)){
  $selected=' selected';
  }
  else{
  $selected='';
  }
 $ret['options'].="<option value=\"$row[pmid]\"$selected>$row[pmtitle]</option>";
 }
$ret['pm_all_count']=$pm_all_count;
return $ret;
}


?>