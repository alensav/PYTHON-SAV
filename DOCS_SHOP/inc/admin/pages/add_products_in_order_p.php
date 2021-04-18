<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
echo "<h4>$lang[add_products_in_order] <a href=\"?view=orders&act=detail&orderid=$orderid\">&#8470; $orderid</a></h4>";
echo search_products_form($orderid);

 if(isset($_POST['operation'])){
  if($_POST['operation'] == 'search'){
  echo search_results($orderid);
  }
  elseif($_POST['operation']==='add'){
  echo add_products_in_order($orderid);
  }
 }

echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=orders&act=edit_order_products&orderid=$orderid\">$lang[return_edit_products]</a></p>";

function search_products_form($orderid){
global $lang;
$orderid=intval($orderid);
$_POST['product_srch'] = isset($_POST['product_srch']) ? format_srch($_POST['product_srch']) : '';
$ret='';
$ret.=<<<HTMLDATA
<form name="searchfrm" action="?" method="POST">
<input type="hidden" name="view" value="orders">
<input type="hidden" name="act" value="add_products_in_order">
<input type="hidden" name="orderid" value="$orderid">
<input type="hidden" name="operation" value="search">
<h4>$lang[search_products]</h4>
<select name="search_for">
HTMLDATA;
$ret.='<option value="title"';
 if(isset($_POST['search_for']) && $_POST['search_for'] == 'title'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['for_title'].'</option>';
$ret.='<option value="sku"';
 if(isset($_POST['search_for']) && $_POST['search_for'] == 'sku'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['for_sku'].'</option>';
$ret.='<option value="itemid"';
 if(isset($_POST['search_for']) && $_POST['search_for'] == 'itemid'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['for_id'].'</option>';
$ret.=<<<HTMLDATA
</select>
<input type="text" name="product_srch" value="$_POST[product_srch]" size="48" maxlength="255">
<input type="submit" value="$lang[search]" class="button1">
</form>
HTMLDATA;
return $ret;
}



function search_results($orderid){
global $db, $custom, $lang, $admin_lib, $sett, $shop;
require_once(INC_DIR."/shop.php");
$shop=new shop;

$srch=format_srch($_POST['product_srch']);
$_POST['product_srch'] = $srch;
$srch = $db->secstr($srch);

$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$query='';
$limit = 100 ;

 switch($_POST['search_for']){

 case 'title':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.title LIKE '%".$db->secstr($srch)."%' AND $tbl_categories.catid = $tbl_items.catid LIMIT $limit";
 $lng_srch_for = $lang['for_title'];
 $lng_srch_results = "$lang[shows_first] $limit $lang[search_results] $lang[for_title]:";
 break;

 case 'sku':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.sku LIKE '%".$db->secstr($srch)."%' AND $tbl_categories.catid = $tbl_items.catid LIMIT $limit";
 $lng_srch_for = $lang['for_sku'];
 $lng_srch_results = "$lang[shows_first] $limit $lang[search_results] $lang[for_sku]:";
 break;

 case 'itemid':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.title, $tbl_items.price, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.itemid = '".intval($srch)."' AND $tbl_categories.catid = $tbl_items.catid";
 $lng_srch_for = $lang['for_id'];
 break;

 default: $query=''; 
 }

$err='';

 if(! $query){
 $err .= "$lang[not_search_for]!<br>";
 }

 if(! $srch){
 $err .= "$lang[not_search_value]!<br>";
 }

 if($err){
 return "<p class=\"red\">$err</p>";
 }

$options = $shop->get_product_options();

$ret='';
$res = $db->query($query) or die($db->error());
 while($row=$db->fetch_array($res)){

  if($row['visible']){
  $link = '<a href="' . @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p')) . '" target="_blank">' . $row['title'] . '</a><br>';
  }
  else{
  $link = $row['title'];
  }

 $product_options=product_options_selects($row['itemid'], $options);

 $def_class = $admin_lib->sett_class();
 $ret.="<tr class=\"$def_class\"><td>$link</td><td>$row[sku]</td><td>$row[price]&nbsp;$sett[curr_brief]</td><td>$product_options</td><td align=\"center\"><input type=\"text\" name=\"quantity[$row[itemid]]\" size=\"4\" value=\"1\"><td align=\"center\"><input type=\"checkbox\" name=\"add_products_arr[$row[itemid]]\"></td></tr>";
 }

 if(! $ret){
 return "<p>$lang[product] $lng_srch_for \"$srch\" $lang[not_found].</p>";
 }

$ret=<<<HTMLDATA
<br>
<form name="addfrm" action="?" method="POST" style="margin:0px;">
<input type="hidden" name="view" value="orders">
<input type="hidden" name="act" value="add_products_in_order">
<input type="hidden" name="orderid" value="$orderid">
<input type="hidden" name="operation" value="add">
$lng_srch_results
<table width="100%" class="settbl">
<tr class="htr"><td>$lang[product_name]</td><td>$lang[sku]</td><td>$lang[price]</td><td>$lang[product_options]</td><td align="center">$lang[quantity]</td><td align="center">$lang[add]</td></tr>
$ret
</table><br>
<input type="submit" value="$lang[add_selected]" class="button1">
</form>
HTMLDATA;

return $ret;
}


function format_srch($srch){
global $custom;
 if($_POST['search_for'] === 'itemid'){
 $srch = intval(trim($srch));
 }
 else{
 $srch = stripslashes($srch);
 $srch = $custom->replace_tags_and_quotes($srch);
 $srch = trim(mb_substr($srch, 0, 255));
 $srch = preg_replace("([^\x09\x20\!\#\$\%\&\(\)\*\+\,\.\/0-9\:\;\=\?\@A-Z\[\]\^\_a-z\{\}\x7E-\xFF\-])", ' ', $srch);
 }
return $srch;
}


function product_options_selects($itemid, $options){
global $db, $sett, $currencies, $orders, $shop;
$currencies=$shop->get_currencies(0);
$itemid=intval($itemid);
$tbl_options_match=DB_PREFIX.'item_options_match';
$ret='';
$res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference, $tbl_options_match.def FROM $tbl_options_match WHERE $tbl_options_match.itemid = $itemid") or die($db->error());

$options_match = array();

 while($row2=$db->fetch_array($res2)){
 $options_match["$row2[option_id]"]["$row2[option_value_id]"]["price_difference"] = $row2['price_difference'];
 $options_match["$row2[option_id]"]["$row2[option_value_id]"]["def"] = $row2['def'];
 }

  foreach($options as $name => $value){

   if(isset($options_match[$name]) && is_array($options_match[$name])){

   $ret.="<tr><td align=\"right\">{$options[$name]['option_name']}:</td><td><select name=\"product_options[$itemid][$name]\">";
   $options_out = '';

    foreach($options["$name"] as $name2 => $value2){

     if(isset($options_match[$name][$name2]) && is_array($options_match[$name][$name2])){

      if($options_match["$name"]["$name2"]["def"]){
      $selected = ' selected';
      }
      else{
      $selected = '';
      }

      if($options_match["$name"]["$name2"]["price_difference"] > 0){
      $price_difference = " (+".$shop->calc_price($options_match["$name"]["$name2"]["price_difference"], $sett['def_currency'])." $sett[curr_brief])";
      }
      elseif($options_match["$name"]["$name2"]["price_difference"] < 0){
      $price_difference = " (".$shop->calc_price($options_match["$name"]["$name2"]["price_difference"], $sett['def_currency'])." $sett[curr_brief])";
      }
      else{
      $price_difference = '';
      }

     $options_out .= "<option value=\"$name2\"$selected>$value2$price_difference</option>";

     }

    }

   $ret.="$options_out</td></tr>";

   }

  }

 if($ret){
 $ret="<table cellspacing=\"0\" cellpadding=\"0\">$ret</table>";
 }
return $ret;
}



function add_products_in_order($orderid){
global $admin_lib, $lang, $orders, $shop;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$vcart_products=virt_cartproducts_frompost();
 if(! sizeof($vcart_products)){
 return $lang['no_products_selected'];
 }

require_once(INC_DIR."/shop.php");
$shop=new shop;

$currencies=$shop->get_currencies(0);
$order_data=$orders->get_order_info($orderid);


$order_data['total']=0;
$order_data['total_pc']=0;
$order_products=apio_order_products_arr($vcart_products, $order_data);


insert_products($order_data['orderid'], $order_products);
require_once(INC_DIR."/admin/order_recalc.php");
$order_recalc=new order_recalc;
$order_recalc->recalc_order($order_data['orderid'], $order_data, 0, array(), 0);

return "<h3>$lang[changes_success]</h3>";
}




function virt_cartproducts_frompost(){
$vcart_products=array();
 if(! is_array($_POST['add_products_arr'])){
 return $vcart_products;
 }
 if(! sizeof($_POST['add_products_arr'])){
 return $vcart_products;
 }

 foreach($_POST['add_products_arr'] as $itemid => $checked){
 $_POST['quantity']["$itemid"]=intval($_POST['quantity']["$itemid"]);
 
  if($checked && $_POST['quantity']["$itemid"]>0){

  $vcart_products["$itemid"]['0']['quantity']=$_POST['quantity']["$itemid"];

   if(isset($_POST['product_options'][$itemid]) && is_array($_POST['product_options'][$itemid])){
    if(sizeof($_POST['product_options'][$itemid])){
    $vcart_products[$itemid]['0']['options']=$_POST['product_options'][$itemid];
    }
   }

  }

 }
return $vcart_products;
}




function insert_products($orderid, $order_products){
global $db, $custom;
$orderid=intval($orderid);
$tbl=DB_PREFIX.'orders_items';

 foreach($order_products as $product_id => $var_arr){

  foreach($var_arr as $variant => $prod){
  $prod = $db->secstr_array($custom->replace_tags_and_quotes_array($prod));

  $options = '';

   if(isset($prod['options']) && is_array($prod['options'])){
    if(sizeof($prod['options'])){
     foreach($prod['options'] as $option_id => $option_arr){

      if(is_array($option_arr)){
       if(sizeof($option_arr)){
        $options .= "$option_arr[option_name]: $option_arr[option_value]\x0A";
       }
      }

     }
    }
   }
   
  $options = $db->secstr($options);


  $db->query("INSERT INTO $tbl (oiid, orderid, itemid, sku, title, price, price_pc, quantity, options) VALUES(NULL, $orderid, $product_id, '$prod[sku]', '$prod[title]', '$prod[price]', '$prod[price_pc]', $prod[quantity], '$options')") or die($db->error());
  }

 }
 
return true;
}




function apio_order_products_arr($cart_products, &$order_info){
global $db, $shop, $orders;
$tbl_items=DB_PREFIX.'items';
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_match=DB_PREFIX.'item_options_match';
$order_products=array();
$options=$shop->get_product_options();
$total_products_quantity = 0;

 foreach($cart_products as $product_id => $var_arr){

 $product_id = intval($product_id);

  foreach($var_arr as $variant => $prod){

  $res = $db->query("SELECT `sku`, `title`, `price`, `quantity` FROM `$tbl_items` WHERE `itemid` = $product_id")or die($db->error());
  $row = $db->fetch_array($res);
  $prod['quantity'] = intval($prod['quantity']);
  $row['price_pc'] = $orders->adm_calc_price($row['price'], $order_info['currency_course']);




   $options_str = '';

    if(isset($cart_products["$product_id"]["$variant"]["options"]) && is_array($cart_products["$product_id"]["$variant"]["options"])){

     if(sizeof($cart_products["$product_id"]["$variant"]["options"])){

     $options_id = '';
     $values_id = '';
      foreach($cart_products["$product_id"]["$variant"]["options"] as $name => $value){
      $name = intval($name);
      $value = intval($value);
      $options_id .= ", $name";
      $values_id .= ", $value";
      }
     if(substr($options_id, 0, 2) === ', '){$options_id = substr($options_id, 2);}
     if(substr($values_id, 0, 2) === ', '){$values_id = substr($values_id, 2);}

     $order_products["$product_id"]["$variant"]["options"] = array();

     $res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference FROM $tbl_options, $tbl_options_match WHERE $tbl_options_match.itemid = $product_id AND $tbl_options_match.option_id IN ($options_id) AND $tbl_options_match.option_value_id IN ($values_id) AND $tbl_options.option_id = $tbl_options_match.option_id ORDER BY $tbl_options.sortid, $tbl_options.option_name")or die($db->error());

      while($row2 = $db->fetch_array($res2)){
      $row2['price_difference_pc'] = $orders->adm_calc_price($row2['price_difference'], $order_info['currency_course']);
      $row['price'] += $row2['price_difference'];
      $row['price_pc'] += $row2['price_difference_pc'];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"] = array();
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["option_name"] = $options["$row2[option_id]"]["option_name"];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["option_value"] = $options["$row2[option_id]"]["$row2[option_value_id]"];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["price_difference"] = $row2["price_difference"];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["price_difference_pc"] = $row2["price_difference_pc"];
      }


     }

    }





    if($prod['quantity']>0){
    $cost = pricef($row['price'] * $prod['quantity']);
    $cost_pc = pricef($row['price_pc'] * $prod['quantity']);
    $order_info['total'] += $cost;
    $order_info['total_pc'] += $cost_pc;
    
    $order_products["$product_id"]["$variant"]["sku"]=$row['sku'];
    $order_products["$product_id"]["$variant"]["title"]=$row['title'];
    $order_products["$product_id"]["$variant"]["price"]=$row['price'];
    $order_products["$product_id"]["$variant"]["price_pc"]=$row['price_pc'];
    $order_products["$product_id"]["$variant"]["quantity"] = $prod['quantity'];

    $total_products_quantity++;
    }


  }

 }

$order_info['total']=pricef($order_info['total']);
$order_info['total_pc']=pricef($order_info['total_pc']);
return $order_products;
}


?>