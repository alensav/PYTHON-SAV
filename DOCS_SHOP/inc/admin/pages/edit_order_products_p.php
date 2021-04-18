<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(! empty($_POST['save'])){
 echo eop_save();
 }

echo eop_form();

function eop_form(){
global $orderid, $orders, $admin_lib, $lang, $sett;
$orderid=intval($orderid);
$order_items = $orders->get_order_items($orderid);

$ret="<h4>$lang[order_products] <a href=\"?view=orders&act=detail&orderid=$orderid\">&#8470; $orderid</a></h4>";

$def_class='ttr';

$ret.=<<<HTMLDATA
<form name="oproducts" action="?" method="POST">
<input type="hidden" name="view" value="orders">
<input type="hidden" name="act" value="edit_order_products">
<input type="hidden" name="orderid" value="$orderid">
<input type="hidden" name="save" value="1">
<table class="settbl" width="100%">
<tr class="htr">
 <td colspan="7">$lang[products_info]</td>
</tr>
<tr class="htr">
 <td>ID</td>
 <td>$lang[product_name]</td>
 <td>$lang[sku]</td>
 <td>$lang[product_options]</td>
 <td>$lang[price]</td>
 <td align="center">$lang[quantity]</td>
 <td align="center">$lang[delete]</td>
</tr>
HTMLDATA;

 if(sizeof($order_items)){

  foreach($order_items as $def_item){

  $def_class=$admin_lib->sett_class();

  $ret.=<<<HTMLDATA
<tr class="$def_class">
 <td>
 $def_item[itemid]
 <input type="hidden" name="edit_products_arr[]" value="$def_item[oiid]">
 <input type="hidden" name="prev_price[$def_item[oiid]]" value="$def_item[price]">
 <input type="hidden" name="prev_quantity[$def_item[oiid]]" value="$def_item[quantity]">
 </td>
 <td><input type="text" name="title[$def_item[oiid]]" size="28" value="$def_item[title]"></td>
 <td><input type="text" name="sku[$def_item[oiid]]" size="28" value="$def_item[sku]"></td>
 <td><textarea name="options[$def_item[oiid]]" cols="28" rows="3">$def_item[options]</textarea></td>
 <td><input type="text" name="price[$def_item[oiid]]" size="12" value="$def_item[price]">&nbsp;$sett[curr_brief]</td>
 <td align="center"><input type="text" name="quantity[$def_item[oiid]]" size="4" value="$def_item[quantity]"></td>
 <td align="center"><input type="checkbox" name="delete[$def_item[oiid]]"></td>
</tr>
HTMLDATA;

  }
 }

$ret.=<<<HTMLDATA
<tr class="ftr"><td colspan="7"><br>&nbsp; <input type="submit" value="$lang[submit]" class="button1"><br></td></tr>
HTMLDATA;

$ret.=<<<HTMLDATA
</table></form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=orders&act=add_products_in_order&orderid=$orderid" onclick="">$lang[add_products_in_order] &#8470; $orderid</a></p>
HTMLDATA;

return $ret;
}



function eop_save(){
global $admin_lib, $db, $lang, $custom;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$tbl_orders_items=DB_PREFIX.'orders_items';
$orderid=intval($_POST['orderid']);
$_POST = $custom->replace_quotes_array($_POST);

 if(! is_array($_POST['edit_products_arr'])){
 return '';
 }

 if(! sizeof($_POST['edit_products_arr'])){
 return '';
 }

$products_oiid_for_recalc=array();

 foreach($_POST['edit_products_arr'] as $name => $oiid){
 $oiid=intval($oiid);
 $quantity=intval($_POST['quantity']["$oiid"]);
  if(! empty($_POST['delete']["$oiid"]) || $quantity < 1){
  $db->query("DELETE FROM `$tbl_orders_items` WHERE `oiid` = $oiid") or die($db->error());
  }
  else{
  $sku=$db->secstr($_POST['sku']["$oiid"]);
  $title=$db->secstr($_POST['title']["$oiid"]);
  $price=pricef(str_replace(',', '.', $_POST['price']["$oiid"]));
  $options=$db->secstr($custom->rn_to_n($_POST['options']["$oiid"]));
   if($price != $_POST['prev_price']["$oiid"] || $quantity != $_POST['prev_quantity']["$oiid"]){
   array_push($products_oiid_for_recalc, $oiid);
   }
  $db->query("UPDATE `$tbl_orders_items` SET `sku` = '$sku', `title` = '$title', `price` = '$price', `options` = '$options', `quantity` = $quantity WHERE `oiid` = $oiid") or die($db->error());
  }
 }

require_once(INC_DIR."/admin/order_recalc.php");
$order_recalc=new order_recalc;
$order_recalc->recalc_order($orderid, array(), 0, $products_oiid_for_recalc, 0);

return "<h3>$lang[changes_success]</h3>";
}


?>