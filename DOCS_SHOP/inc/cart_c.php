<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class cart{

public $totalwithdiscount=0;

function add_product($productid, $quantity = 1, $options = ''){
global $sett;
$productid=intval($productid);
$quantity=intval($quantity);
if(! isset($_SESSION['arwshop_mk']['cart_products'])){$_SESSION['arwshop_mk']['cart_products'] = array();}
if(! isset($_SESSION['arwshop_mk']["cart_products"]["$productid"])){$_SESSION['arwshop_mk']["cart_products"]["$productid"] = array();}

 if(is_array($_SESSION['arwshop_mk']["cart_products"]["$productid"])){
  if(count($_SESSION['arwshop_mk']["cart_products"]["$productid"])){
  $product_variants = array();
  $i = 0;
   foreach($_SESSION['arwshop_mk']["cart_products"]["$productid"] as $name => $value){
   $product_variants["$i"] = $value;
   $i++;
   }
  $_SESSION['arwshop_mk']["cart_products"]["$productid"] = $product_variants;
  }
 }

$variant = sizeof($_SESSION['arwshop_mk']["cart_products"]["$productid"]);
 if($variant){
  foreach($_SESSION['arwshop_mk']["cart_products"]["$productid"] as $name => $value){
   if($value["options"] == $options){
   $variant = $name;
   break;
   }
  }
 }

$_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["options"] = '';
 if(is_array($options)){
  if(count($options)){
  $_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["options"] = $options;
  }
 }

 if(! empty($_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["quantity"])){
 $_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["quantity"] += $quantity;
 }
 else{
 $_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["quantity"] = $quantity;
 }

$_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["quantity"] = intval(str_replace('-', '', $_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["quantity"]));

 if(isset($_SESSION['arwshop_mk']['order_complete'])){
 unset($_SESSION['arwshop_mk']['order_complete'], $_SESSION['arwshop_mk']['order']);
 }
 
}



function set_product_quantity($productid, $variant, $quantity){
$productid=intval($productid);
if(! isset($_SESSION['arwshop_mk']['cart_products'])){$_SESSION['arwshop_mk']['cart_products'] = array();}
if(! isset ($_SESSION['arwshop_mk']["cart_products"]["$productid"])) {$_SESSION['arwshop_mk']["cart_products"]["$productid"] = array();}
 if($quantity<1){
 $this->delete_product($productid, $variant);
 }
 else{
 $_SESSION['arwshop_mk']["cart_products"]["$productid"]["$variant"]["quantity"]=$quantity;
 }
}


function delete_product($productid, $variant){
$productid=intval($productid);
unset($_SESSION['arwshop_mk']['cart_products'][$productid][$variant]);
 if(isset($_SESSION['arwshop_mk']['cart_products'][$productid]) && is_array($_SESSION['arwshop_mk']['cart_products'][$productid])){
  if(! count($_SESSION['arwshop_mk']['cart_products'][$productid])){
  unset($_SESSION['arwshop_mk']['cart_products'][$productid]);
  }
 }
}


function get_cart(){
global $cart_items, $sett, $shop, $lang, $db, $page_tags, $view, $custom;
$independ = false;
 if(! isset($page_tags['metatags'])){
 $page_tags['metatags'] = '';
 }
$scarttype = 0;
 if( (isset($_GET['independ']) && $_GET['independ'] == 1) || (isset($_POST['independ']) && $_POST['independ'] == 1) ){
 $independ = true;
  if(! empty($_GET['scarttype'])){
  $scarttype=intval($_GET['scarttype']);
  }
  elseif(! empty($_POST['scarttype'])){
  $scarttype=intval($_POST['scarttype']);
  }
 }

$additional_report=$shop->check_cookie();

 if(isset($_SESSION['arwshop_mk']['cart_products']) && sizeof($_SESSION['arwshop_mk']['cart_products']) > 0){
  if($independ){
   if($scarttype==2){
   $template = new template('cart_independ2.tpl');
   }
   else{
   $template = new template('cart_independ.tpl');
   }
  }  
  else{
  $template = new template('cart.tpl');
  }
 }
 else{
  if($independ){
   if($scarttype == 2){
   $template = new template('cart_independ2.tpl');
   }
   else{
   $template = new template('empty_cart_independ.tpl');
   }
  }
  else{
  $template = new template('empty_cart.tpl');
  }
 $template->assign('charset', $sett['charset']);
 $template->assign('title', $page_tags['meta_title']);
  if($independ){
  tunable_css($template);
  }
 $template->assign('metatags', $page_tags['metatags']);
 $template->assign('shop_url', $sett['url']);
 $template->assign('relative_url', $sett['relative_url']);
 $template->assign('shop_index', "$sett[relative_url]$sett[index_file]");
 $template->assign('design_url', "$sett[relative_url]design/$sett[design]/");
 $template->assign('additional_report', $additional_report);
 $template->assign('lang', $lang);
 return $template->out_content();
 }


$page_tags['metatags'] .= <<<HTMLDATA
<script type="text/javascript">
function delq(){if(! confirm('$lang[want_del_product]')){return false;}else{return true;}}
</script>
HTMLDATA;

$tbl_items=DB_PREFIX.'items';
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_match=DB_PREFIX.'item_options_match';

 if($view==='cart'){
 $form_action='cart.php';
 $additionally_fields='';
 }
 elseif($view==='order'){
 $form_action='pages.php';
 $additionally_fields='<input type="hidden" name="view" value="order">';
 }

$total_cost=0;
$def_class='ttr';
$total_products_quantity=0;

$options = $shop->get_product_options();

$template->get_cycle('cart_products');
$template->get_cycle('product_options', 'cart_products');

$products_count=0;

 foreach($_SESSION['arwshop_mk']['cart_products'] as $product_id => $var_arr){

 $product_id = intval($product_id);

  foreach($var_arr as $variant => $prod){

  $res = $db->query("SELECT `itemname`, `catid`, `sku`, `title`, `price`, `quantity` FROM `$tbl_items` WHERE `itemid` = '$product_id'") or die($db->error());
  $row = $db->fetch_array($res);
  $prod['quantity']=intval($prod['quantity']);
  $row['price']=$shop->calc_price($row['price']);
  $row['fcatname'] = isset($shop->categories["$row[catid]"]['fcat']) ? $shop->categories["$row[catid]"]['fcat'] : '';



   $product_options = 0;
   $options_str = '';

    if(is_array($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"])){

     if(count($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"])){

     $options_id = '';
     $values_id = '';
      foreach($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"] as $name => $value){
      $name = intval($name);
      $value = intval($value);
      $options_id .= ", $name";
      $values_id .= ", $value";
      }
     if(substr($options_id, 0, 2) === ', '){$options_id = substr($options_id, 2);}
     if(substr($values_id, 0, 2) === ', '){$values_id = substr($values_id, 2);}

     $res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference FROM $tbl_options, $tbl_options_match WHERE $tbl_options_match.itemid = $product_id AND $tbl_options_match.option_id IN ($options_id) AND $tbl_options_match.option_value_id IN ($values_id) AND $tbl_options.option_id = $tbl_options_match.option_id ORDER BY $tbl_options.sortid, $tbl_options.option_name")or die($db->error());

      while($row2 = $db->fetch_array($res2)){
      $product_options = 1;
      $row['price'] += $shop->calc_price($row2['price_difference']);
      $template->assign_cycle('product_option_name', $options["$row2[option_id]"]["option_name"], 'product_options');
      $template->assign_cycle('product_option_value', $options["$row2[option_id]"]["$row2[option_value_id]"], 'product_options');
      $template->next_loop('product_options');
      }

     $template->out_cycle('product_options');

     }

    }


    if($product_options){
    $template->condition_cycle('product_options', 'cart_products');
    }
    else{
    $template->not_condition_cycle('product_options', 'cart_products');
    }





   $products_count++;
    if(TDTC == 1){
     if($products_count > 4){
     $this->delete_product($product_id, $variant);
      if(! $demo_msg){
      $additional_report .= mdmogrn("$lang[338] 4 $lang[143]");
      $demo_msg = 1;
      }
     }
    }


    if($prod['quantity'] > $row['quantity'] && ! $sett['cart_add_q0']){
    $prod['quantity'] =  $row['quantity'];
    $this->set_product_quantity($product_id, $variant, $prod['quantity']);
    $additional_report.="$lang[many_quantity]<br>";
    }


    if($prod['quantity'] > 0 && empty($demo_msg)){
    $cost=pricef($row['price'] * $prod['quantity']);
    $total_cost+=$cost;
    if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
    $total_products_quantity++;
    $template->assign_cycle('def_class', $def_class);
    $template->assign_cycle('product_url', @stdi2("product=$product_id", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$product_id.html", 'p')));
    $template->assign_cycle('product_sku', $row['sku']);
    $template->assign_cycle('product_title', $row['title']);
    $template->assign_cycle('product_price', $shop->format_price($row['price']));
    $template->assign_cycle('product_id', $product_id);
    $template->assign_cycle('def_product_quantity', $prod['quantity']);
    $template->assign_cycle('cost', $shop->format_price($cost));
    $template->assign_cycle('variant_id', $variant);
    $template->assign_cycle('currency_brief', $sett['show_curr_brief']);
    $template->next_loop();
    }
    else{
    $this->delete_product($product_id, $variant);
    }


  }

 }

$template->out_cycle();


 if($total_products_quantity<1){
 $template = new template('empty_cart.tpl');
 $template->assign('additional_report', $additional_report);
 $template->assign('lang', $lang);
 return $template->out_content();
 }

$groupid = isset($_SESSION['arwshop_mk']['user']['groupid']) ? $_SESSION['arwshop_mk']['user']['groupid'] : 0;

$discount_percents = preg_replace("([^0-9\x2E])", '', $this->get_group_discount($groupid, $total_cost, 0));
$discount=pricef($total_cost * $discount_percents / 100);
$total_cost_with_discount = pricef($total_cost - $discount);

$total_cost=pricef($total_cost);
$this->totalwithdiscount=$total_cost_with_discount;

$template->assign('additional_report', $additional_report);
$template->assign('def_action', $form_action);
$template->assign('additionally_fields', $additionally_fields);

 if($independ){
 $template->assign('total_cost', number_format($total_cost, 2, '.', ''));
 $template->assign('total_cost_with_discount', number_format($total_cost_with_discount, 2, '.', ''));
 }
 else{
 $template->assign('total_cost', $shop->format_price($total_cost));
 $template->assign('total_cost_with_discount', $shop->format_price($total_cost_with_discount));
 }
$template->assign('discount_percents', $discount_percents);
$template->assign('discount', $shop->format_price($discount));
$template->assign('currency_brief', $sett['show_curr_brief']);

 if($discount > 0){
 $template->condition('discount');
 }
 else{
 $template->not_condition('discount');
 }

 if($view==='cart'){
 $template->condition('only_cart');
 }
 else{
 $template->not_condition('only_cart');
 }
  
$template->assign('charset', $sett['charset']);
$template->assign('title', $page_tags['meta_title']);
 if($independ){
 tunable_css($template);
 }
$template->assign('metatags', $page_tags['metatags']);
$template->assign('shop_url', $sett['url']);
$template->assign('relative_url', $sett['relative_url']);
$template->assign('shop_index', "$sett[relative_url]$sett[index_file]");
$template->assign('design_url', "$sett[relative_url]design/$sett[design]/");
$template->assign('lang', $lang);

return $template->out_content();
}


function recalculate(){
global $sett;
if(! isset($_POST['product_quantity'])){return false;}
if(! is_array($_POST['product_quantity'])){return false;}
if(! count($_POST['product_quantity'])){return false;}
if(! isset($_SESSION['arwshop_mk']['cart_products'])){$_SESSION['arwshop_mk']['cart_products']=array();}


 foreach($_POST['product_quantity'] as $product_id => $var_arr){

  if(is_array($var_arr)){

   foreach($var_arr as $variant => $quantity){
   $product_id = intval($product_id);
   $quantity = intval($quantity);
   $variant = intval($variant);
    if($quantity > 0){
    $_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["quantity"] = $quantity;
    }
    else{
    $this->delete_product($product_id, $variant);
    }
   }

  }

 }
}


function get_group_discount($groupid, $order_sum, $currency_id){
global $db, $currencies, $sett;
$groupid = intval($groupid);
 if(! $groupid ){
 $groupid  = 1;
 }
$order_sum = pricef($order_sum);
$currency_id = intval($currency_id);

 if(! $currency_id){
 $currency_id = def_show_curr_id();
 }

$order_sum = pricef($order_sum  * $currencies["$currency_id"]["course"]);


$tbl=DB_PREFIX.'users_groups_discounts';
$res=$db->query("SELECT did, order_sum, discount FROM $tbl WHERE groupid = $groupid AND order_sum <= $order_sum") or die($db->error());
$max = array('order_sum' => 0, 'discount' => 0);
 while($row = $db->fetch_array($res)){
  if($row['order_sum'] >= $max['order_sum']){
  $max = $row;
  }
 }
 
 
return $max['discount'];
}



}
?>