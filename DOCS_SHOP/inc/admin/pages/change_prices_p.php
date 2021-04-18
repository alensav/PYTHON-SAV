<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/change_prices');

 if($act === 'select_categories'){
 echo select_categories();
 }
 elseif($act === 'select_manufacturers'){
 echo select_manufacturers();
 }
 else{
  if($act === 'change'){
  echo change_prices();
  }
 echo change_prices_form();
 }



function change_prices(){
global $admin_lib, $db, $lang;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl_items=DB_PREFIX.'items';
$tbl_item_options_match=DB_PREFIX.'item_options_match';
$def_tbl = $tbl_items;
$update_tables = $tbl_items;

$err_msg='';

 if($_POST['price_type'] === 'price'){
 $_POST['price_type'] = 'price';
 }
 elseif($_POST['price_type'] === 'old_price'){
 $_POST['price_type'] = 'old_price';
 }
 elseif($_POST['price_type'] === 'price_difference'){
 $_POST['price_type'] = 'price_difference';
 $def_tbl = $tbl_item_options_match;
 $update_tables = "$tbl_item_options_match, $tbl_items";
 }
 else{
 return 'Invalid price_type!<br>';
 }

$_POST['change_value'] = trim($_POST['change_value']);
$_POST['change_value'] = str_replace(',', '.', $_POST['change_value']);
$_POST['change_value'] = str_replace('-', '', $_POST['change_value']);

 if(! is_numeric($_POST['change_value'])){
 $err_msg.="$lang[incorrect_value]!<br>";
 }

 if($_POST['change_side'] == 'reduce' && $_POST['change_value'] != 0){
 $_POST['change_value'] = 0 - $_POST['change_value'];
 }

 if($_POST['change_type'] == 'percent'){
 $formula = "$def_tbl.$_POST[price_type] = $def_tbl.$_POST[price_type] + ($def_tbl.$_POST[price_type] * $_POST[change_value] / 100)";
 }
 else{
 $formula = "$def_tbl.$_POST[price_type] = $def_tbl.$_POST[price_type] + $_POST[change_value]";
 }

 if($_POST['how_to_change'] == 'by_categories'){
  if(! $_POST['selected_categories']){
  $err_msg.="$lang[no_categories_selected]!<br>";
  }
 $_POST['selected_categories']=sec_clear($_POST['selected_categories']);
 $where = " WHERE $tbl_items.catid IN ($_POST[selected_categories])";
 }
 elseif($_POST['how_to_change'] == 'by_manufacturers'){
  if(! $_POST['selected_manufacturers']){
  $err_msg.="$lang[no_manufacturers_selected]!<br>";
  }
 $_POST['selected_manufacturers']=sec_clear($_POST['selected_manufacturers']);
 $where = " WHERE $tbl_items.mnf_id IN ($_POST[selected_manufacturers])";
 }
 else{
 $where = '';
 }

 if($_POST['price_type'] == 'price_difference' && $where){
 $where .= " AND $tbl_item_options_match.itemid = $tbl_items.itemid";
 }

 if($err_msg){
 return "<p class=\"red\">$err_msg</p>";
 }

 if(! empty($_POST['round'])){
 $formula = preg_replace('/([^=]+=\x20)/', '$1ROUND(', $formula) . ')';
 }

$db->query("UPDATE $update_tables SET $formula $where") or die($db->error());

 if($_POST['price_type'] == 'price' || $_POST['price_type'] === 'old_price'){
 require_once(INC_DIR."/admin/items.php");
 $items=new items;
 $items->update_negative_prices($_POST['price_type']);
 }

return "<h3>$lang[changes_success]</h3>";
}




function sec_clear($str){
$arr=explode(',', $str);
$str='';
 if(sizeof($arr)){
  foreach($arr as $value){
  $value=intval($value);
   if($value){
   $str.=$value.',';
   }
  }
 }
 if($str){
 $str=substr($str, 0, strlen($str)-1);
 }
return $str;
}



function change_prices_form(){
global $lang, $sett;

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
 $_POST['change_value'] = '0.00';
 }
$_POST['change_value'] = str_replace(',', '.', $_POST['change_value']);
$_POST['change_value'] = str_replace('-', '', $_POST['change_value']);

$selected_categories = isset($_POST['selected_categories']) ? $_POST['selected_categories'] : '';
$selected_manufacturers = isset($_POST['selected_manufacturers']) ? $_POST['selected_manufacturers'] : '';

$ret=<<<HTMLDATA
<script type="text/javascript">
var scts='$selected_categories'.split(',');
del_empty_el(scts);
var smnf='$selected_manufacturers'.split(',');
del_empty_el(smnf);
function del_empty_el(arr){
 for(var i=0;i<arr.length;i++){
  if(! arr[i]){
  arr.splice(i,1);
  }
 }
}
function submitFrm(){
 if(! q('$lang[whant_change_prices]')){
 return false;
 }
document.chpfrm.selected_categories.value='';
document.chpfrm.selected_manufacturers.value='';
 if(document.chpfrm.how_to_change[1].checked){
  for(var i=0;i<scts.length;i++){
  document.chpfrm.selected_categories.value=document.chpfrm.selected_categories.value+scts[i]+',';
  }
  if(document.chpfrm.selected_categories.value){
  document.chpfrm.selected_categories.value=document.chpfrm.selected_categories.value.substring(0, document.chpfrm.selected_categories.value.length-1);
  }
 }
 else if(document.chpfrm.how_to_change[2].checked){
  for(var i=0;i<smnf.length;i++){
  document.chpfrm.selected_manufacturers.value=document.chpfrm.selected_manufacturers.value+smnf[i]+',';
  }
  if(document.chpfrm.selected_manufacturers.value){
  document.chpfrm.selected_manufacturers.value=document.chpfrm.selected_manufacturers.value.substring(0, document.chpfrm.selected_manufacturers.value.length-1);
  }
 }
}
function main_init(){
sel_cat_qu.innerHTML=scts.length;
sel_mnf_qu.innerHTML=smnf.length;
}
</script>
<form name="chpfrm" action="?" method="POST" onsubmit="return submitFrm();">
<h3>$lang[change_prices]</h3>
<input type="hidden" name="view" value="tools">
<input type="hidden" name="tname" value="change_prices">
<input type="hidden" name="act" value="change">
<input type="hidden" name="selected_categories" value="">
<input type="hidden" name="selected_manufacturers" value="">
HTMLDATA;
 if(empty($_POST['how_to_change']) || $_POST['how_to_change'] == 'on_all_products'){
 $checked=' checked="checked"';
 }
 else{
 $checked='';
 }
$ret.=<<<HTMLDATA
<p><input type="radio" name="how_to_change" value="on_all_products"$checked>$lang[on_all_products]</p>
HTMLDATA;
 if(isset($_POST['how_to_change']) && $_POST['how_to_change'] == 'by_categories'){
 $checked=' checked="checked"';
 }
 else{
 $checked='';
 }
$ret.=<<<HTMLDATA
<p>
<input type="radio" name="how_to_change" value="by_categories"$checked>$lang[by_categories] <a href="javascript:window.open('?view=tools&tname=change_prices&act=select_categories&independ=1','chp_selcat','status,scrollbars,resizable,width=640,height=500');document.chpfrm.how_to_change[1].checked=true;void(0);">($lang[selected]&nbsp;<span id="sel_cat_qu">0</span>&nbsp;$lang[sel_categories])</a>
</p>
HTMLDATA;
 if(isset($_POST['how_to_change']) && $_POST['how_to_change'] == 'by_manufacturers'){
 $checked=' checked="checked"';
 }
 else{
 $checked='';
 }
$ret.=<<<HTMLDATA
<p><input type="radio" name="how_to_change" value="by_manufacturers"$checked>$lang[by_manufacturers] <a href="javascript:window.open('?view=tools&tname=change_prices&act=select_manufacturers&independ=1','chp_selmnf','status,scrollbars,resizable,width=640,height=500');document.chpfrm.how_to_change[2].checked=true;void(0);">($lang[selected]&nbsp;<span id="sel_mnf_qu">0</span>&nbsp;$lang[sel_manufacturers])</a>
</p>
HTMLDATA;

 if(isset($_POST['price_type']) && $_POST['price_type'] == 'price'){
 $price_selected = ' selected="selected"';
 }
 else{
 $price_selected = '';
 }

 if(isset($_POST['price_type']) && $_POST['price_type'] == 'old_price'){
 $old_price_selected = ' selected="selected"';
 }
 else{
 $old_price_selected = '';
 }
 
 if(isset($_POST['price_type']) && $_POST['price_type'] == 'price_difference'){
 $price_difference_selected = ' selected="selected"';
 }
 else{
 $price_difference_selected = '';
 }

$ret.=<<<HTMLDATA
<p>
<select name="price_type">
<option value="price"$price_selected>$lang[price]</option>
<option value="old_price"$old_price_selected>$lang[old_price]</option>
<option value="price_difference"$price_difference_selected>$lang[price_difference]</option>
</select>&nbsp;
HTMLDATA;

 if(isset($_POST['change_side']) && $_POST['change_side'] == 'enlarge'){
 $enlarge_selected = ' selected="selected"';
 }
 else{
 $enlarge_selected = '';
 }

 if(isset($_POST['change_side']) && $_POST['change_side'] == 'reduce'){
 $reduce_selected = ' selected="selected"';
 }
 else{
 $reduce_selected = '';
 }

$ret.=<<<HTMLDATA
<select name="change_side">
<option value="enlarge"$enlarge_selected>$lang[enlarge]</option>
<option value="reduce"$reduce_selected>$lang[reduce]</option>
</select>
$lang[on]
<input type="text" name="change_value" value="$_POST[change_value]" size="12">
HTMLDATA;

$percent_selected = '';
 if(isset($_POST['change_type']) && $_POST['change_type'] == 'percent'){
 $percent_selected = ' selected="selected"';
 }
 else{
 $enlarge_selected = '';
 }

$currency_selected = '';
 if(isset($_POST['change_type']) && $_POST['change_type'] == 'currency'){
 $currency_selected = ' selected="selected"';
 }
 else{
 $reduce_selected = '';
 }

$round_checked = '';
 if(! empty($_POST['round'])){
 $round_checked = ' checked="checked"';
 }

$ret.=<<<HTMLDATA
<select name="change_type">
<option value="percent"$percent_selected>%</option>
<option value="currency"$currency_selected>$sett[curr_brief]</option>
</select><br>
<input type="checkbox" name="round"$round_checked>$lang[round]
</p>
<p>$lang[backup_recommended] <a href="?view=tools&tname=dbcopy">$lang[make_backup]</a>.</p>
<input type="submit" value="$lang[apply_changes]" class="button1">
</form>
<script type="text/javascript">
main_init();
</script>
HTMLDATA;
return $ret;
}


function html_page($title, $body, $onload){
global $sett;
return <<<HTMLDATA
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=$sett[charset]">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>$title</title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<style type="text/css"> 
.prtd{padding-bottom:7px;}
ul{
list-style-type: none;
}
</style>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#ffffff"$onload>
<table width="100%" bgcolor="#ffffff"><tr><td>
<h4 style="margin:3px">$title</h4>
$body
</td></tr></table><br>
</body>
</html>
HTMLDATA;
}


function get_chp_categories_arr(){
global $db, $chp_categories;
$tbl=DB_PREFIX.'categories';
$chp_categories=array();
$res = $db->query("SELECT catid, parent, title, count FROM $tbl WHERE catid <> 0 ORDER BY sortid, title") or die($db->error());
 while($row=$db->fetch_array($res)){
 $chp_categories["$row[catid]"]['parent']=$row['parent'];
 $chp_categories["$row[catid]"]['title']=$row['title'];
 $chp_categories["$row[catid]"]['count']=$row['count'];
 }
}


function select_categories(){
global $chp_categories, $lang, $cats_count;
get_chp_categories_arr();
 if(sizeof($chp_categories) < 1){
 return html_page($lang['select_categories'], $lang['no_categories'], '');
 }

$ret='';
$ret.='<form name="cfrm" onsubmit="return false;"><ul>';
$cats_count=0;
 foreach($chp_categories as $def_catid => $row){
  if($row['parent'] == 0 && $def_catid != 0){
  $ret.="<li><input type=\"checkbox\" name=\"cats[$cats_count]\" value=\"$def_catid\" onclick=\"chkSub($cats_count, $def_catid);\">$row[title]";
  $ret.="<input type=\"hidden\" name=\"parents[$cats_count]\" value=\"$row[parent]\">";
  $cats_count++;
  $ret.=get_chp_subcategories($def_catid, $chp_categories);
  $ret.='</li>';
  }
 }
$ret.='</ul></form>';

$ret.=<<<HTMLDATA
<script type="text/javascript">
var cats_count=$cats_count;
function in_array(str,arr){
 for(var i=0;i<arr.length;i++){
 if(arr[i]==str){return true;}
 }
return false;
}
function setCats(){
 for(var i=0;i<cats_count;i++){
  if(in_array(document.cfrm['cats['+i+']'].value, opener.scts)){
  document.cfrm['cats['+i+']'].checked=true;
  }
 }
}
function chkSub(index, catid){
 if(! document.cfrm['cats['+index+']'].checked){
 return false;
 }
 for(var i=0;i<cats_count;i++){
  if(document.cfrm['parents['+i+']'].value==catid){
  document.cfrm['cats['+i+']'].checked=true;
  chkSub(i, document.cfrm['cats['+i+']'].value);
  }
 }
return true;
}
function set_parentwin_cats(){
var total=0;
opener.scts.length=0;
 for(var i=0;i<cats_count;i++){
  if(document.cfrm['cats['+i+']'].checked){
  opener.scts.push(document.cfrm['cats['+i+']'].value);
  total++;
  }
 }
opener.sel_cat_qu.innerHTML=total;
opener.document.chpfrm.how_to_change[1].checked=true;
self.close();
return true;
}
</script>
<button class="button1" onclick="set_parentwin_cats();">$lang[select_highlighted]</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="button1" onclick="window.close();">$lang[cancel]</button>
HTMLDATA;
return html_page($lang['select_categories'], $ret, 'onload="setCats();"');
}




function get_chp_subcategories($cat_id, $chp_cats){
global $cats_count;
$ret='';
 foreach($chp_cats as $def_catid => $row){
  if($row['parent'] == $cat_id){
  $ret.="<li><input type=\"checkbox\" name=\"cats[$cats_count]\" value=\"$def_catid\" onclick=\"chkSub($cats_count, $def_catid);\">$row[title]";
  $ret.="<input type=\"hidden\" name=\"parents[$cats_count]\" value=\"$row[parent]\">";
  $cats_count++;
  $ret.=get_chp_subcategories($def_catid, $chp_cats);
  $ret.='</li>';
  }
 }

 if($ret){
 return '<ul>'.$ret.'</ul>';
 }
 else{
 return '';
 }
}


function get_chp_manufacturers_arr(){
global $db;
$tbl=DB_PREFIX.'manufacturers';
$chp_manufacturers=array();
$res = $db->query("SELECT mnf_id, title FROM $tbl WHERE mnf_id <> 0 ORDER BY sortid, title") or die($db->error());
 while($row=$db->fetch_array($res)){
 $chp_manufacturers["$row[mnf_id]"]['title']=$row['title'];
 }
return $chp_manufacturers;
}


function select_manufacturers(){
global $lang, $mnf_count;
$chp_manufacturers=get_chp_manufacturers_arr();
 if(sizeof($chp_manufacturers) < 1){
 return html_page($lang['select_manufacturers'], $lang['no_manufacturers'], '');
 }

$ret='';
$ret.='<form name="mfrm" onsubmit="return false;"><ul>';
$mnf_count=0;
 foreach($chp_manufacturers as $def_mnf_id => $row){
  if(! isset($row['parent'])){
  $row['parent'] = 0;
  }
  if($row['parent'] == 0 && $def_mnf_id != 0){
  $ret.="<li><input type=\"checkbox\" name=\"mnfs[$mnf_count]\" value=\"$def_mnf_id\">$row[title]";
  $ret.="<input type=\"hidden\" name=\"parents[$mnf_count]\" value=\"$row[parent]\">";
  $mnf_count++;
  $ret.='</li>';
  }
 }
$ret.='</ul></form>';

$ret.=<<<HTMLDATA
<script type="text/javascript">
var mnf_count=$mnf_count;
function in_array(str,arr){
 for(var i=0;i<arr.length;i++){
 if(arr[i]==str){return true;}
 }
return false;
}
function setMnfs(){
 for(var i=0;i<mnf_count;i++){
  if(in_array(document.mfrm['mnfs['+i+']'].value, opener.smnf)){
  document.mfrm['mnfs['+i+']'].checked=true;
  }
 }
}
function set_parentwin_mnfs(){
var total=0;
opener.smnf.length=0;
 for(var i=0;i<mnf_count;i++){
  if(document.mfrm['mnfs['+i+']'].checked){
  opener.smnf.push(document.mfrm['mnfs['+i+']'].value);
  total++;
  }
 }
opener.sel_mnf_qu.innerHTML=total;
opener.document.chpfrm.how_to_change[2].checked=true;
self.close();
return true;
}
</script>
<button class="button1" onclick="set_parentwin_mnfs();">$lang[select_highlighted]</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="button1" onclick="window.close();">$lang[cancel]</button>
HTMLDATA;
return html_page($lang['select_manufacturers'], $ret, 'onload="setMnfs();"');
}




?>