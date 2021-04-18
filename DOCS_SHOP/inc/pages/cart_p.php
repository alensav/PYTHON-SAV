<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $page_tags, $template, $product, $custom, $sett, $lang;

$independ_param = '';
$get_params = '';
 if( (isset($_GET['independ']) && $_GET['independ'] == 1) || (isset($_POST['independ']) && $_POST['independ'] == 1) ){
 $get_params = '&independ=1';
  if(isset($_GET['scarttype'])){
  $get_params.='&scarttype='.intval($_GET['scarttype']);
  }
  elseif(isset($_POST['scarttype'])){
  $get_params.='&scarttype='.intval($_POST['scarttype']);
  }
 }
 
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 $product = isset($_GET['product']) ? intval($_GET['product']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = isset($_POST['act']) ? $_POST['act'] : '';
 $product = isset($_POST['product']) ? intval($_POST['product']) : 0;
 }

$custom->get_lang('cart');
require_once(INC_DIR."/cart_c.php");
$cart=new cart;
$page_tags['meta_title']="$lang[cart] - $sett[pages_title]";

switch($act){

case 'add':
$options = '';
 if(isset($_POST['product_options']) && is_array($_POST['product_options'])){
  if(count($_POST['product_options'])){
  $options = array();
   foreach($_POST['product_options'] as $name => $value){
   $options["$name"] = $value;
   }
  }
 }
$cart->add_product($product, intval($_POST['product_quantity']), $options);
 if(ob_get_contents()){
 ob_end_clean();
 }
header("Location: $sett[relative_url]cart.php?show$get_params");
exit;

case 'del':
$cart->delete_product($product, $_GET['variant']);
$cart_text=$cart->get_cart();
break;

case 'recalculate':
$cart->recalculate();
 if(ob_get_contents()){
 ob_end_clean();
 }
header("Location: $sett[relative_url]cart.php?show$get_params");
exit;



default:
$cart_text=$cart->get_cart();
}

echo $cart_text;

?>