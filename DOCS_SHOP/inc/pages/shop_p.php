<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $sett, $cat, $fcat, $product, $prname, $view, $pg, $custom, $lang, $shop, $lastpage, $page_tags;

$lastpage = get_lastpage();


 if(($cat || $fcat || $view == 'main') && (! $product && ! $prname)){
 $shop->get_page_tags($cat, $fcat);
 }

switch($view){

case 'category':
include(INC_DIR."/pages/category_p.php");
break;

case 'detail':
include(INC_DIR."/pages/detail_p.php");
break;

case 'main':
include(INC_DIR."/pages/main_page_p.php");
break;

case 'manufacturers':
$custom->get_lang('manufacturers');
 if(! empty($_GET['mnf']) || ! empty($_GET['mnfname'])){
 include(INC_DIR."/pages/manufacturer_products_p.php");
 }
 else{
 include(INC_DIR."/pages/manufacturers_p.php");
 }
break;

case 'news':
include(INC_DIR."/pages/news_p.php");
break;

case 'cart':
include(INC_DIR."/pages/cart_p.php");
break;


case 'order':
include(INC_DIR."/pages/order_p.php");
break;

case 'pay_methods':
include(INC_DIR."/pages/shop_paymethods_p.php");
break;

case 'delivery_methods':
include(INC_DIR."/pages/shop_delivery_methods_p.php");
break;

case 'content':
include(INC_DIR."/pages/content_p.php");
break;

case 'register':
include(INC_DIR."/pages/register_p.php");
break;

case 'login':
include(INC_DIR."/pages/login_p.php");
break;

case 'agreement':
include(INC_DIR."/pages/agreement_p.php");
break;

case 'profile':
include(INC_DIR."/pages/profile_p.php");
break;

case 'user_orders':
include(INC_DIR."/pages/user_orders_p.php");
break;

case 'order_detail':
include(INC_DIR."/pages/order_detail_p.php");
break;

case 'forgot_password':
include(INC_DIR."/pages/forgot_password_p.php");
break;

case 'discounts':
include(INC_DIR."/pages/discounts_p.php");
break;

case 'pay_order':
include(INC_DIR."/pages/pay_order_p.php");
break;

case 'payment_module':
include(INC_DIR."/pages/payment_module_p.php");
break;

case 'logout':
unset($_SESSION['arwshop_mk']['user']);
unset($_SESSION['arwshop_mk']['cart_products']);
unset($_SESSION['arwshop_mk']['order']);
unset($_SESSION['arwshop_mk']['order_complete']);
header("Location: $sett[relative_url]$sett[index_file]");
exit;
break;

case 'search':
 require_once(INC_DIR."/search_lib.php");
 $search_lib = new search_lib;
 echo $search_lib->search_items();
break;

default:
echo header404();

}


function generate_lastpage(){
global $custom;
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 return urlencode($custom->replace_tags_and_quotes($_SERVER['REQUEST_URI']));
 }
return get_lastpage();
}


function get_lastpage(){
global $custom;
$lastpage = '';
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $lastpage = isset($_GET['lastpage']) ? $_GET['lastpage'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $lastpage = isset($_POST['lastpage']) ? $_POST['lastpage'] : '';
 }
$lastpage = urldecode($lastpage);
 if(substr($lastpage, 0, 1) != '/'){
 $lastpage='';
 }
 if(substr($lastpage, 0, 2) == '//'){
 $lastpage = '';
 }
return $custom->replace_tags_and_quotes($lastpage);
}

?>