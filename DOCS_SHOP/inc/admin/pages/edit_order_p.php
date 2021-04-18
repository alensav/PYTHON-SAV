<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(! empty($_POST['save'])){
 echo eo_save();
 }

echo eo_form();


function eo_form(){
global $orderid, $lang, $orders, $orderid, $admin_lib, $sett, $def_class, $currencies;
$ret = '';
$orderid = intval($orderid);
$order_info = $orders->get_order_info($orderid);
if(! $order_info['orderid']){return "$lang[order_not_found] &#8470; $orderid";}

$ret .= "<h4>$lang[order_edit] <a href=\"?view=orders&act=detail&orderid=$orderid\">&#8470; $orderid</a></h4>";

$def_class='ttr';

$ret.=<<<HTMLDATA
<form name="oeditfrm" action="?" method="POST">
<input type="hidden" name="view" value="orders">
<input type="hidden" name="act" value="edit_order">
<input type="hidden" name="orderid" value="$order_info[orderid]">
<input type="hidden" name="save" value="1">

<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="2">$lang[order_info]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$str_order_date = date("Y-m-d H:i:s", $order_info['date'] + $sett['time_diff'] * 3600);

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[order_date]</td>
 <td><input type="text" name="order_dt[date]" value="$str_order_date" size="19" maxlength="19">&nbsp;($lang[date_format])</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[discount]</td>
 <td><input type="text" name="order_dt[discount_percents]" value="$order_info[discount_percents]" size="5" maxlength="5">&nbsp;%</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$pmlist=paymethods_list($order_info['pmid']);

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[pay_method]</td>
 <td><select name="order_dt[pmid]"><option value="0"></option>$pmlist</select></td>
</tr>
HTMLDATA;
unset($pmlist);

$def_class=$admin_lib->sett_class();

$dmlist=deliverymethods_list($order_info['dmid']);

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[delivery_method]</td>
 <td><select name="order_dt[dmid]"><option value="0"></option>$dmlist</select></td>
</tr>
HTMLDATA;
unset($dmlist);

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
 <tr class="$def_class">
  <td>$lang[delivery_cost]:</td>
  <td><input type="text" name="order_dt[delivery_cost]" value="$order_info[delivery_cost]" size="15">&nbsp;$sett[curr_brief]</td>
 </tr>
HTMLDATA;


$def_class=$admin_lib->sett_class();
require_once(INC_DIR."/shop.php");
$shop=new shop;
$currencies=$shop->get_currencies(1);
$currlist=currencies_list($order_info['currency_id']);
$curr_courses_js=currencies_courses_js();

$ret.=<<<HTMLDATA
 <tr class="$def_class">
  <td>$lang[selected_currency]</td>
  <td><script type="text/javascript">$curr_courses_js</script><select name="order_dt[currency_id]" onchange="document.oeditfrm['order_dt[currency_course]'].value=courses[this.value];alert('$lang[course_changed] '+courses[this.value]);"><option value="0"></option>$currlist</select></td>
 </tr>
HTMLDATA;
unset($currlist);

$def_class=$admin_lib->sett_class();

 $ret.=<<<HTMLDATA
 <tr class="$def_class">
  <td>$lang[selected_currency_course]<br><span style="font-size:9px">($lang[against_db_currency])</span></td>
  <td>
  <input type="hidden" name="old_order_dt[currency_course]" value="$order_info[currency_course]">
  <input type="text" name="order_dt[currency_course]" value="$order_info[currency_course]"></td>
 </tr>
HTMLDATA;


$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[order_comment]</td>
 <td><textarea name="order_dt[comment]" cols="40" rows="4">$order_info[comment]</textarea></td>
</tr>
HTMLDATA;


$def_class=$admin_lib->sett_class();

$checked = isset($checked) ? array($checked) : array('');
$checked['auto']='';
$checked['manually']='';
$manually_total_style='';
 if(isset($_POST['calc_total']) && $_POST['calc_total'] == 'manually'){
 $checked['manually']=' checked="checked"';
 }
 else{
 $checked['auto']=' checked="checked"';
 $manually_total_style='display:none;';
 }

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[final_total]</td>
 <td>
<input type="radio" name="calc_total" value="auto" size="15"$checked[auto] onclick="manually_total.style.display='none';">$lang[calc_total_auto]<br>
<input type="radio" name="calc_total" value="manually" size="15"$checked[manually] onclick="manually_total.style.display='block';">$lang[calc_total_manually]
<div id="manually_total" style="$manually_total_style">
<table cellspacing="0" cellpadding="0" style="padding-left:20px;">
<tr><td>$lang[in_db_currency]:&nbsp</td><td><input type="text" name="order_dt[final_total]" value="$order_info[final_total]" size="15">&nbsp;$sett[curr_brief]</td></tr>
<tr><td>$lang[in_payment_currency]:&nbsp</td><td><input type="text" name="order_dt[final_total_pc]" value="$order_info[final_total_pc]" size="15">&nbsp;$order_info[currency_brief]</td></tr>
</table>
</div>
 </td>
</tr>
HTMLDATA;
unset($checked);



$ret.="</table><br>";


$def_class='ttr';

$ret.=<<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="2">$lang[shopper_info]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[username]</td>
 <td><input type="text" name="order_dt[username]" value="$order_info[username]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[first_name]</td>
 <td><input type="text" name="order_dt[first_name]" value="$order_info[first_name]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[last_name]</td>
 <td><input type="text" name="order_dt[last_name]" value="$order_info[last_name]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[patronymic]</td>
 <td><input type="text" name="order_dt[patronymic]" value="$order_info[patronymic]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[company]</td>
 <td><input type="text" name="order_dt[company]" value="$order_info[company]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();
require_once(INC_DIR."/register.php");
$register=new register;
$countries_list=$register->get_countries_list($order_info['country_id']);
$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[country]</td>
 <td><select name="order_dt[country_id]"><option value="0"></option>$countries_list</select></td>
</tr>
HTMLDATA;
unset($countries_list);

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[city]</td>
 <td><input type="text" name="order_dt[city]" value="$order_info[city]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[address]</td>
 <td><textarea name="order_dt[address]" cols="40" rows="4">$order_info[address]</textarea></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[zip_code]</td>
 <td><input type="text" name="order_dt[zip_code]" value="$order_info[zip_code]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[phone]</td>
 <td><input type="text" name="order_dt[phone]" value="$order_info[phone]"></td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>$lang[email]</td>
 <td><input type="text" name="order_dt[email]" value="$order_info[email]"></td>
</tr>
HTMLDATA;

$ret.="</table><br>";


$additional_fields=$orders->get_additional_fields($orderid);
 if(sizeof($additional_fields)){
 $ret.=<<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="4">$lang[additional_fields]</td>
</tr>
<tr class="htr">
 <td>$lang[field_title]</td>
 <td>$lang[field_values]</td>
 <td>$lang[field_name]</td>
 <td>$lang[delete]</td>
</tr>
HTMLDATA;
 $def_class='ttr';
  foreach($additional_fields as $addfield){
  $def_class=$admin_lib->sett_class();
  $ret.=<<<HTMLDATA
<tr class="$def_class">
 <td><input type="text" name="addfields[$addfield[oafvid]][field_title]" value="$addfield[field_title]"></td>
 <td><textarea name="addfields[$addfield[oafvid]][field_values]" cols="36" rows="4">$addfield[field_values]</textarea></td>
 <td><input type="text" name="addfields[$addfield[oafvid]][field_name]" value="$addfield[field_name]" size="18"></td>
 <td align="center"><input type="checkbox" name="addfields[$addfield[oafvid]][delete]"></td>
</tr>
HTMLDATA;
  }
 $ret.='</table><br>';
 unset($additional_fields, $addfield);
 }


 $ret.=<<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="3">$lang[add_additional_field]</td>
</tr>
<tr class="htr">
 <td>$lang[field_title]</td>
 <td>$lang[field_values]</td>
 <td>$lang[field_name]</td>
</tr>
<tr class="str">
 <td><input type="text" name="new_addfield[field_title]"></td>
 <td><textarea name="new_addfield[field_values]" cols="36" rows="4"></textarea></td>
 <td><input type="text" name="new_addfield[field_name]" size="18"></td>
</tr>
</table><br>

<input type="submit" value="$lang[submit]" class="button1">
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=orders&act=edit_order_products&orderid=$order_info[orderid]">$lang[edit_order_products]</a></p>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=orders">$lang[to_orders_list]</a></p>
HTMLDATA;

return $ret;
}


function paymethods_list($selected_pmid){
global $db;
$tbl=DB_PREFIX.'paymethods';
$ret='';
$res=$db->query("SELECT `pmid`, `pmtitle` FROM `$tbl`") or die($db->error());
 while($row=$db->fetch_array($res)){
  if($row['pmid']==$selected_pmid){
  $selected=' selected="selected"';
  }
  else{
  $selected='';  
  }
 $ret.="<option value=\"$row[pmid]\"$selected>$row[pmtitle]</option>";
 }
return $ret;
}



function deliverymethods_list($selected_dmid){
global $db;
$tbl=DB_PREFIX.'deliverymethods';
$ret='';
$res=$db->query("SELECT `dmid`, `dmname` FROM `$tbl`") or die($db->error());
 while($row=$db->fetch_array($res)){
  if($row['dmid']==$selected_dmid){
  $selected=' selected="selected"';
  }
  else{
  $selected='';  
  }
 $ret.="<option value=\"$row[dmid]\"$selected>$row[dmname]</option>";
 }
return $ret;
}

function currencies_list($selected_currency_id){
global $currencies;
$ret='';
 foreach($currencies as $row){
  if($row['currency_id']==$selected_currency_id){
  $selected=' selected="selected"';
  }
  else{
  $selected='';  
  }
 $ret.="<option value=\"$row[currency_id]\"$selected>$row[title] ($row[brief])</option>";
 }
return $ret;
}


function currencies_courses_js(){
global $currencies;
$ret='var courses=new Array();courses[0]=\'1\';';
 foreach($currencies as $row){
 $ret.="courses[$row[currency_id]]='$row[course]';";
 }
return $ret;
}



function eo_save(){
global $admin_lib, $lang, $sett, $db, $custom;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$tbl_orders=DB_PREFIX.'orders';

$warning='';

$_POST = $custom->replace_quotes_array($_POST);
$new_order_dt = $custom->trim_array($_POST['order_dt']);

$new_order_dt['orderid']=intval($_POST['orderid']);
if(! $new_order_dt['orderid']){return '';}

$new_order_dt['date']=intval(strtotime($new_order_dt['date']));
  if($new_order_dt['date']>0){
  $new_order_dt['date'] -= $sett['time_diff'] * 3600;
  }

$new_order_dt['discount_percents'] = str_replace(',', '.', $new_order_dt['discount_percents']);
 if(! is_numeric($new_order_dt['discount_percents'])){
 $new_order_dt['discount_percents'] = 0;
 }
$new_order_dt['pmid']=intval($new_order_dt['pmid']);
$new_order_dt['currency_id']=intval($new_order_dt['currency_id']);
$new_order_dt['dmid']=intval($new_order_dt['dmid']);
$new_order_dt['country_id']=intval($new_order_dt['country_id']);

$new_order_dt['currency_course'] = str_replace(',', '.', $new_order_dt['currency_course']);
 if(! is_numeric($new_order_dt['currency_course'])){
 $new_order_dt['currency_course']=1;
 }
 if($new_order_dt['currency_course']==0){
 $new_order_dt['currency_course']=1;
 }

$new_order_dt['delivery_cost'] = pricef(str_replace(',', '.', $new_order_dt['delivery_cost']));
$new_order_dt['final_total'] = pricef(str_replace(',', '.', $new_order_dt['final_total']));
$new_order_dt['final_total_pc'] = pricef(str_replace(',', '.', $new_order_dt['final_total_pc']));

$new_order_dt['userid']=er_userid_from_username($new_order_dt['username']);
 if($new_order_dt['username'] && ! $new_order_dt['userid']){
 $warning.="$lang[user_not_found] &quot;$new_order_dt[username]&quot;.<br>";
 $new_order_dt['username']='';
 }

$new_order_dt=$db->secstr_array($new_order_dt);

$db->query("UPDATE `$tbl_orders` SET `date` = '$new_order_dt[date]', `pmid` = '$new_order_dt[pmid]', `currency_id` = '$new_order_dt[currency_id]', `currency_course` = '$new_order_dt[currency_course]', `discount_percents` = '$new_order_dt[discount_percents]', delivery_cost = '$new_order_dt[delivery_cost]', `final_total` = '$new_order_dt[final_total]', `final_total_pc` = '$new_order_dt[final_total_pc]', `dmid` = '$new_order_dt[dmid]', `userid` = '$new_order_dt[userid]', `username` = '$new_order_dt[username]', `first_name` = '$new_order_dt[first_name]', `last_name` = '$new_order_dt[last_name]', `patronymic` = '$new_order_dt[patronymic]', `company` = '$new_order_dt[company]', `country_id` = '$new_order_dt[country_id]', `city` = '$new_order_dt[city]', `address` = '$new_order_dt[address]', `zip_code` = '$new_order_dt[zip_code]', `phone` = '$new_order_dt[phone]', `email` = '$new_order_dt[email]', `comment` = '$new_order_dt[comment]' WHERE `orderid` = $new_order_dt[orderid]") or die($db->error());

$recalc_all_products=false;
 if($new_order_dt['currency_course'] != $_POST['old_order_dt']['currency_course']){
 $recalc_all_products=true;
 }

$no_update_final_total=false;
 if($_POST['calc_total']==='manually'){
 $no_update_final_total=true;
 }

require_once(INC_DIR."/admin/order_recalc.php");
$order_recalc=new order_recalc;
$order_recalc->recalc_order($new_order_dt['orderid'], array(), $recalc_all_products, array(), $no_update_final_total);

er_save_addfields();

 if($warning){
 $warning="<p class=\"warn\">$warning</p>";
 }

return "<h3>$lang[changes_success]</h3>$warning";
}




function er_save_addfields(){
global $db, $custom;
$orderid=intval($_POST['orderid']);
$tbl=DB_PREFIX.'orders_add_fields_values';

 if(is_array($_POST['addfields']) && sizeof($_POST['addfields'])){
 $addfields=$custom->trim_array($_POST['addfields']);
  foreach($addfields as $field_id => $field){
  $field_id=intval($field_id);
   if(! empty($field['delete'])){
   $db->query("DELETE FROM `$tbl` WHERE `oafvid` = $field_id") or die($db->error());
   }
   else{
   $field=$db->secstr_array($field);
   $db->query("UPDATE `$tbl` SET `field_name` = '$field[field_name]', `field_title` = '$field[field_title]',  `field_values` = '$field[field_values]' WHERE `oafvid` = $field_id") or die($db->error());
   }
  }
 }

 if(is_array($_POST['new_addfield']) && sizeof($_POST['new_addfield'])){
 $new_addfield=$custom->trim_array($_POST['new_addfield']);
  if($new_addfield['field_title'] || $new_addfield['field_values'] || $new_addfield['field_name']){
  $new_addfield=$db->secstr_array($new_addfield);
  $db->query("INSERT INTO `$tbl` (`oafvid`, `orderid`, `field_name`, `field_title`, `field_values`) VALUES (NULL, $orderid, '$new_addfield[field_name]', '$new_addfield[field_title]', '$new_addfield[field_values]')") or die($db->error());
  }
 }

return true;
}



function er_userid_from_username($username){
global $db, $custom;
$tbl_users=DB_PREFIX.'users';
$username=$db->secstr($username);
$res=$db->query("SELECT `userid` FROM `$tbl_users` WHERE `username` = '$username'") or die($db->error());
$row=$db->fetch_array($res);
return intval($row['userid']);
}


?>