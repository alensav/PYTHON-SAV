<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

$cat = 0;
$product = 0;
$pg = 0;
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $cat = isset($_GET['cat']) ? preg_replace('/\D/', '', $_GET['cat']) : 0;
 $product = isset($_GET['product']) ? preg_replace('/\D/', '', $_GET['product']) : 0;
 $pg = isset($_GET['pg']) ? preg_replace('/\D/', '', $_GET['pg']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $cat = isset($_POST['cat']) ? preg_replace('/\D/', '', $_POST['cat']) : 0;
 }

switch($view){

case 'settings':
include(INC_DIR."/admin/pages/global_settings_p.php");
break;

case 'mainconf':
include(INC_DIR."/admin/pages/mainpage_conf_p.php");
break;

case 'currencies':
include(INC_DIR."/admin/pages/currencies_p.php");
break;

case 'cts':
include(INC_DIR."/admin/pages/categories_p.php");
break;

case 'search_products':
require_once(INC_DIR."/admin/view_cat.php");
$view_category=new view_category;
echo $view_category->search_form();
break;

case 'makecat':
include(INC_DIR."/admin/pages/ed_cat_p.php");
break;

case 'movecat':
include(INC_DIR."/admin/pages/ed_cat_p.php");
break;

case 'delcat':
include(INC_DIR."/admin/pages/del_cat_p.php");
break;

case 'moveproducts':
include(INC_DIR."/admin/pages/moveproducts_p.php");
break;

case 'invisible_items':
include(INC_DIR."/admin/pages/invisible_items_p.php");
break;

default:
$tbl=DB_PREFIX.'categories';
$res=$db->query("SELECT COUNT(*) FROM $tbl");
$chapters_count=$db->result($res,0,0)-1;
$tbl=DB_PREFIX.'items';
$res=$db->query("SELECT COUNT(*) FROM $tbl");
$products_count=$db->result($res,0,0);

 if(defined('SV_MODE') && SV_MODE == 1){
 global $svc_sadpadm;
  if($products_count > $svc_sadpadm->max_user_products()){
  echo $svc_sadpadm->block_user(1);
  }
 }

 if(TDTC == 1){
 echo $admin_lib->fduDvMsg();
 }

 if(isset($_POST['enter']) && isset($_POST['admin_name'])){
 require_once(INC_DIR.'/admin/after_login.php');
 echo after_login::check();
 }

$cc = new_comments_count();

echo <<<HTMLDATA
<div class="mainPageBl">

 <div class="mainPageBlHeader">
 <div>$lang[categories] $chapters_count &nbsp; $lang[products] $products_count</div><div>$cc</div>
 </div>

 <table><tr><td><img src="adm/img/settings.gif" alt=""></td><td><a href="?view=settings">$lang[settings]</a></td></tr></table>

 <table><tr><td><img src="adm/img/cts.gif" alt=""></td><td><a href="?view=cts">$lang[all_categories]</a></td></tr></table>

 <table><tr><td><img src="adm/img/makecat.gif" alt=""></td><td><a href="?view=makecat">$lang[mk_category]</a></td></tr></table>

 <table><tr><td><img src="adm/img/additem.gif" alt=""></td><td><a href="javascript:additem();">$lang[add_product]</a></td></tr></table>

</div>
HTMLDATA;
}


function new_comments_count(){
global $sett;
 if(empty($sett['on_pcomm'])){
 return '';
 }
global $db, $custom, $lang;
$tbl=DB_PREFIX.'item_comments_new';
$res = $db->query("SELECT COUNT(*) FROM $tbl");
$cc = $db->result($res, 0, 0);
 if($cc){
 $custom->get_lang('admin_lang/product_comments_new');
 return <<<HTMLDATA
<img src="adm/img/info1.gif" alt="" style="vertical-align:middle;margin-right:5px;margin-bottom:4px;"><a href="?view=product&amp;act=comments&amp;pcsub=new" style="font-weight:normal">$lang[new_comments_count]: $cc</a>
HTMLDATA;
 }
return '';
}




?>
