<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('register');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $show_currency = isset($_GET['show_currency']) ? $_GET['show_currency'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $show_currency=$_POST['show_currency'];
 }

 if($show_currency !== 'dbdef'){
 $show_currency='';
 }

 if(! empty($_POST['save'])){
 $err_code=$orders->update_order_info();
  if($err_code==1){
  echo "<h3>$lang[changes_success]</h3>";
  }
  else{
  echo "<h3>$err_code</h3>";
  }
 }

$order_info = $orders->get_order_info($orderid);
if(! $order_info['orderid']){die("$lang[order_not_found] &#8470; $orderid");}

$order_info = selected_currency_sp_names($order_info);
 if($show_currency==='dbdef'){
 $show_currency_brief = $order_info['def_currency_brief'];
 }
 else{
 $show_currency_brief = $order_info['currency_brief'];
 }


echo <<<HTMLDATA
<script type="text/javascript">var lang=new Array();lang['print']='$lang[print]';lang['title']='$lang[order] &#8470; $orderid';</script>
<script type="text/javascript" src="adm/print-order.js"></script>
<table width="100%"><tr><td><span style="font-size:16px;font-weight:bold;">$lang[order_info] &#8470; $order_info[orderid]</span></td><td align="right"><img src="adm/img/edit.gif" border="0" style="vertical-align:middle">&nbsp;<a href="?view=orders&act=edit_order&orderid=$order_info[orderid]">$lang[edit_order]</a>&nbsp; &nbsp; <img src="adm/img/print.gif" border="0" style="vertical-align:middle">&nbsp;<a href="javascript:printpage(lang)">$lang[print]</a></td></tr></table>
HTMLDATA;

 if($order_info['currency_id'] !== $order_info['def_currency_id']){

 echo <<<HTMLDATA
<form name="frmchcurrency" action="?" method="GET">
<input type="hidden" name="view" value="$view">
<input type="hidden" name="act" value="$act">
<input type="hidden" name="orderid" value="$orderid">
$lang[display_currency]
<select name="show_currency" onchange="this.form.submit();">
<option value="">$lang[selected_currency] ($order_info[currency])</option>
<option value="dbdef"
HTMLDATA;

  if($show_currency==='dbdef'){
  echo ' selected="selected"';
  }

 echo <<<HTMLDATA
>$lang[default_currency] ($order_info[def_currency])</option>
</select>
</form>
HTMLDATA;

 }
 



$def_class='ttr';


echo <<<HTMLDATA
<div id="dPrint" style="margin-bottom:15px"><form action="?" method="POST">
<input type="hidden" name="view" value="orders">
<input type="hidden" name="act" value="detail">
<input type="hidden" name="orderid" value="$order_info[orderid]">
<input type="hidden" name="save" value="1">
<input type="hidden" name="show_currency" value="$show_currency">

<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="2">$lang[order_info]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[order_number]</td>
 <td>&#8470; $order_info[orderid]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

 if($order_info['date']){
 $str_order_date = date("d.m.Y H:i:s", $order_info['date'] + $sett['time_diff'] * 3600);
 }

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[order_date]</td>
 <td>$str_order_date</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[status]</td>
 <td>
<input type="hidden" name="old_status" value="$order_info[status]">
<select name="status">
HTMLDATA;


 foreach($orders->statuses as $status_id => $status_arr){
 if($status_id == $order_info['status']){$selected=' selected="selected"';}else{$selected='';}
 echo "<option value=\"$status_id\"$selected>$status_arr[name]</option>";
 }


echo <<<HTMLDATA
</select>
</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

 if($order_info['paymethod_advname'] && $admin_lib->is_valid_pmmod_name($order_info['paymethod_advname']) && is_file(PM_MODULES_DIR."/$order_info[paymethod_advname]/admin/pm_module.php")){
 $paymethod_adv_link="<br>(<a href=\"?pmmod=$order_info[paymethod_advname]&act=order_info&orderid=$order_info[orderid]&pmid=$order_info[pmid]\">$lang[pmmod_sys_info]</a>)";
 }
 else{
 $paymethod_adv_link='';
 }

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[pay_method]</td>
 <td>$order_info[paymethod]$paymethod_adv_link</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[delivery_method]</td>
 <td>$order_info[deliverymethod]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$def_currency_course = 1 / $order_info['currency_course'];
echo <<<HTMLDATA
 <tr class="$def_class">
  <td>$lang[selected_currency]</td>
  <td>$order_info[currency] ($order_info[currency_brief])</td>
 </tr>
HTMLDATA;

 if($def_currency_course != $order_info['currency_course']){
 $def_class=$admin_lib->sett_class();
 echo <<<HTMLDATA
 <tr class="$def_class">
  <td>$lang[selected_currency_course]<br><font style="font-size:9px">($lang[to_the_default_currency])</font></td>
  <td>1 $order_info[currency_brief] = $order_info[currency_course] $order_info[def_currency_brief]<br>
  1 $order_info[def_currency_brief] = $def_currency_course $order_info[currency_brief]
  </td>
 </tr>
HTMLDATA;
 }

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[order_comment]</td>
 <td>$order_info[comment]</td>
</tr>
HTMLDATA;

echo "</table><br>";




 


require_once(INC_DIR."/shop.php");
$shop=new shop;

$order_items = $orders->get_order_items($orderid);
$order_items = selected_currency_sp_names($order_items);

$def_class='ttr';

echo <<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="5">$lang[products_info] <a href="?view=orders&act=edit_order_products&orderid=$order_info[orderid]" id="editPrLnk">($lang[edit])</a></td>
</tr>
<tr class="htr">
 <td>$lang[product_name]</td>
 <td>$lang[sku]</td>
 <td>$lang[price]</td>
 <td>$lang[quantity]</td>
 <td>$lang[cost]</td>
</tr>
HTMLDATA;

 if(is_array($order_items)){
  foreach($order_items as $def_item){

   if($show_currency==='dbdef'){
   $cost=pricef($def_item['price'] * $def_item['quantity']);
   }
   else{
   $cost=pricef($def_item['price_pc'] * $def_item['quantity']);
   }

  if($def_item['options']){
  $def_item['options'] = custom::rn_to_n($def_item['options']);
  $def_item['options'] = '<br>' . str_replace("\n", '<br>', $def_item['options']);
  }

  $def_class=$admin_lib->sett_class();

  echo <<<HTMLDATA
<tr class="$def_class">
 <td><a href="javascript:editem($def_item[itemid])">$def_item[title]</a>$def_item[options]</td>
 <td>$def_item[sku]</td>
 <td>$def_item[show_price] $show_currency_brief</td>
 <td>$def_item[quantity]</td>
 <td>$cost $show_currency_brief</td>
</tr>
HTMLDATA;

  }
 }


$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr>
<tr class="$def_class">
 <td colspan="5"><hr></td>
</tr>

<tr>
 <td colspan="5">



<table class="OrderTotal">
 <tr>
  <td>$lang[total_cost]:</td>
  <td>&nbsp;&nbsp;&nbsp;$order_info[show_total] $show_currency_brief</td>
 </tr>
 <tr>
HTMLDATA;

 if($order_info['discount'] > 0){
 echo <<<HTMLDATA
  <td>$lang[discount]: $order_info[discount_percents] %</td>
  <td>&nbsp;&nbsp;&nbsp;$order_info[show_discount] $show_currency_brief</td>
 </tr>
 <tr>
  <td>$lang[total_with_discount]:</td>
  <td>&nbsp;&nbsp;&nbsp;$order_info[show_total_with_discount] $show_currency_brief</td>
 </tr>
HTMLDATA;
 }

 if($order_info['delivery_cost'] > 0){
 echo <<<HTMLDATA
 <tr>
  <td>$lang[delivery_cost]:</td>
  <td>&nbsp;&nbsp;&nbsp;$order_info[show_delivery_cost] $show_currency_brief</td>
 </tr>
HTMLDATA;
 }

echo <<<HTMLDATA
 <tr>
  <td><b>$lang[final_total]:</b></td>
  <td>&nbsp;&nbsp;&nbsp;<b>$order_info[show_final_total] $show_currency_brief</b></td>
 </tr>
</table><br>


 </td>
</tr>
HTMLDATA;

echo "</table><br>";



 if(! empty($order_info['paymethod_advname']) && $order_info['status'] != intval($sett['paid_order_status'])){
 require_once(INC_DIR."/shop_order.php");
 $shop_order = new shop_order;
 echo '<div><a href="'.str_replace('&', '&amp;', $shop_order->get_payment_link($order_info)).'" target="_blank" id="pml">'.$lang['payment_link'].'</a><img src="adm/img/plus.gif" alt="" style="vertical-align:middle;cursor:pointer;margin-left:10px;" onclick="pmls.innerHTML=pml.href;this.style.display='."'none'".';"></div><div id="pmls"></div><br>';
 }




$def_class='ttr';

echo <<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="2">$lang[shopper_info]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

 if($order_info['username']){
 $order_info['username'] = "<a href=\"?view=users&act=edit&userid=$order_info[userid]\">$order_info[username]</a>";
 }
 else{
 $order_info['username']=$lang['not_authorized'];
 }

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[username]</td>
 <td>$order_info[username]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[first_name]</td>
 <td>$order_info[first_name]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[last_name]</td>
 <td>$order_info[last_name]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[patronymic]</td>
 <td>$order_info[patronymic]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[company]</td>
 <td>$order_info[company]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[country]</td>
 <td>$order_info[country]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[city]</td>
 <td>$order_info[city]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[address]</td>
 <td>$order_info[address]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[zip_code]</td>
 <td>$order_info[zip_code]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[phone]</td>
 <td>$order_info[phone]</td>
</tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class">
 <td>$lang[email]</td>
 <td><a href="mailto:$order_info[email]">$order_info[email]</a></td>
</tr>
HTMLDATA;

echo "</table><br>";


$additional_fields=$orders->get_additional_fields($orderid);
 if(sizeof($additional_fields)){
 echo <<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="2">$lang[additional_fields]</td>
</tr>
HTMLDATA;
 $def_class='ttr';
  foreach($additional_fields as $addfield){
  $def_class=$admin_lib->sett_class();
  echo <<<HTMLDATA
<tr class="$def_class">
 <td>$addfield[field_title]</td>
 <td>$addfield[field_values]</td>
</tr>
HTMLDATA;
  }
 echo '</table>';
 unset($additional_fields, $addfield);
 }

echo '</div>';

echo <<<HTMLDATA
<table width="100%" class="settbl">
 <tr class="str">
  <td>$lang[admin_public_comment]</td>
  <td><textarea name="admin_public_comment" cols="46" rows="8">$order_info[adm_pub_comment]</textarea></td>
 </tr>
 <tr class="ttr">
  <td>$lang[admin_hidden_comment]</td>
  <td><textarea name="admin_comment" cols="46" rows="4">$order_info[admin_comment]</textarea></td>
 </tr>
</table>
<br>
HTMLDATA;

echo $lang['change_products_count'];
?>
<br><select name="change_products_count">
<option value=""><?php echo $lang['no_change']; ?></option>
<option value="-"><?php echo $lang['change_minus']; ?></option>
<option value="+"><?php echo $lang['change_plus']; ?></option>
</select><br><br>
<input type="submit" value="<?php echo $lang['submit']; ?>" class="button1">
</form>

<form action="?" method="GET" target="_blank">
<input type="hidden" name="view" value="payment_blank">
<input type="hidden" name="orderid" value="<?php echo $order_info['orderid']; ?>">
<input type="hidden" name="independ" value="1">
<?php echo $lang['show_payment_blank']; ?><br>
<select name="blank_id"><?php echo pmblanks_options($order_info['pmid']); ?></select>
<input type="submit" value="<?php echo $lang['show']; ?>" class="button1">
</form>

<img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=orders"><?php echo $lang['to_orders_list']; ?></a>

<?php

function selected_currency_sp_names($arr){
global $show_currency;
 foreach($arr as $key => $value){
 
  if(is_array($value)){
  $arr["$key"]=selected_currency_sp_names($value);
  }
  else{
  
   if(substr($key, strlen($key)-3)==='_pc'){
   $dn=substr($key, 0, strlen($key)-3);
    if($show_currency==='dbdef'){
    $arr["show_$dn"]=$arr["$dn"];
    }
    else{
    $arr["show_$dn"]=$arr["$key"];
    }
   }
   
  }
  
 }
return $arr;
}


function pmblanks_options($def_pmid){
global $db;
$tbl=DB_PREFIX.'payment_blanks';
$ret='';
$res = $db->query("SELECT blank_id, paymethod_id, blank_title FROM $tbl") or die($db->error());
 while($row=$db->fetch_array($res)){
  if($row['paymethod_id'] == $def_pmid){
  $selected=' selected="selected"';
  }
  else{
  $selected='';
  }
 $ret.="<option value=\"$row[blank_id]\"$selected>$row[blank_title]</option>";
 }
return $ret;
}

?>