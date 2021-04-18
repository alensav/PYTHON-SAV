<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(! isset($_GET['mnf'])){
 $_GET['mnf'] = 0;
 }

 if(! isset($_GET['mnfname'])){
 $_GET['mnfname'] = '';
 }

 if(! isset($_GET['pg'])){
 $_GET['pg'] = 0;
 }


echo get_manufacturer_products($_GET['mnf'], $_GET['mnfname'], $_GET['pg']);

function get_manufacturer_products($mnf_id, $mnfname, $pg){
global $sett, $pg, $page_tags, $db, $lang, $shop;
$_GET['sort'] = isset($_GET['sort']) ? preg_replace("([^a-z\_])", '', $_GET['sort']) : '';
$_GET['desc'] = isset($_GET['desc']) ? intval($_GET['desc']) : 0;

$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$tbl_item_categories=DB_PREFIX.'item_categories';
$tbl_manufacturers=DB_PREFIX.'manufacturers';

$mnf_id=intval($mnf_id);
$mnfname=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $_GET['mnfname']);

 if($mnf_id){
 $where="`mnf_id` = $mnf_id";
 }
 elseif($mnfname){
 $where="`mnfname` = '$mnfname'";
 }
 else{
 return '';
 }

$res = $db->query("SELECT * FROM `$tbl_manufacturers` WHERE $where") or die($db->error());
$row_manufacturer = $db->fetch_array($res);

 if(! $row_manufacturer['mnf_id']){
 return header404();
 }

$mnf_id=$row_manufacturer['mnf_id'];

$template = new template('manufacturer.tpl');
$template->assign('special_text', $page_tags['special']);
$template->assign('manufacturer_id', $mnf_id);
$template->assign('sort_options', $shop->get_sort_options());
$template->assign('desc_options', $shop->get_desc_options());

 if($row_manufacturer['meta_title']){
 $page_tags['meta_title'] = $row_manufacturer['meta_title'];
 }
 else{
 $page_tags['meta_title'] = "$row_manufacturer[title] - $sett[pages_title]";
 }

 if($row_manufacturer['meta_description']){
 $page_tags['metatags'] .= "<meta name=\"description\" content=\"$row_manufacturer[meta_description]\">\n";
 }

 if($row_manufacturer['meta_keywords']){
 $page_tags['metatags'] .= "<meta name=\"keywords\" content=\"$row_manufacturer[meta_keywords]\">\n";
 }

$page_tags['metatags'] .= $row_manufacturer['meta_tags'];

$template->assign('manufacturer_name', $row_manufacturer['title']);
$template->assign('manufacturer_description', $row_manufacturer['description']);
$template->assign('manufacturer_image', $row_manufacturer['image']);
$template->assign('manufacturer_url', $row_manufacturer['url']);

 if($row_manufacturer['url']){
 $template->condition('manufacturer_url');
 }
 else{
 $template->not_condition('manufacturer_url');
 }

 if($row_manufacturer['image']){
 $template->condition('manufacturer_image');
 }
 else{
 $template->not_condition('manufacturer_image');
 }

$res = $db->query("SELECT COUNT(*) FROM $tbl_items WHERE mnf_id = $mnf_id AND visible = 1") or die($db->error());

$quantity_products = $db->result($res,0,0);


 if($quantity_products<1){
 $pg=preg_replace('/\D/', '', $pg);
 $template->not_condition('products');
 return $template->out_content();
 }
 else{
 $template->condition('products');
 }

if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(! $pg){$pg=1;}

$tstfirst_line=$pg * $sett['products_onpage'] - $sett['products_onpage'];
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){return header404();}

if($first_line < 0 ){return '';}

 if($sett['smallimg_width']){
 $smallimg_width=" width=\"$sett[smallimg_width]\" ";
 }
 else{
 $smallimg_width='';
 }

 if($sett['bigimg_width']){
 $bigimg_width=" width=\"$sett[bigimg_width]\" ";
 }
 else{
 $bigimg_width='';
 }

 if($_GET['sort']){
   switch($_GET['sort']){
   case 'id': $orderby="$tbl_items.itemid"; break;
   case 'udate': $orderby="$tbl_items.upd_date"; break;
   case 'price': $orderby="$tbl_items.price"; break;
   case 'title': $orderby="$tbl_items.title"; break;
   case 'sku': $orderby="$tbl_items.sku"; break;
   case 'cat': $orderby="$tbl_categories.fulltitle"; break;
   default: $orderby="$tbl_items.itemid";
   }
  if($_GET['desc']){$orderby.=' DESC';}
 }
 elseif(! empty($sett['mnf_sort_products'])){
   switch($sett['mnf_sort_products']){
   case 'id': $orderby="$tbl_item_categories.sortid, $tbl_items.itemid"; break;
   case 'udate': $orderby="$tbl_item_categories.sortid, $tbl_items.upd_date"; break;
   case 'price': $orderby="$tbl_item_categories.sortid, $tbl_items.price"; break;
   case 'title': $orderby="$tbl_item_categories.sortid, $tbl_items.title"; break;
   case 'sku': $orderby="$tbl_item_categories.sortid, $tbl_items.sku"; break;
   case 'cat': $orderby="$tbl_item_categories.sortid, $tbl_categories.fulltitle"; break;
   default: $orderby="$tbl_item_categories.sortid, $tbl_items.itemid";
   }
  if($sett['mnf_sortpr_desc']){$orderby.=' DESC';}
 }
 else{
 $orderby="$tbl_item_categories.sortid, $tbl_items.itemid DESC";
 }

$template->get_cycle('products');
$template->get_cycle('product_options', 'products');

$limit = '';
 if(empty($_GET['show_all'])){
 $limit = " LIMIT $first_line, $sett[products_onpage]";
 }

 if(! empty($sett['sort_nostock_last'])){
 $order_nostock_last = "`$tbl_items`.`quantity` > 0 DESC, ";
 }
 else{
 $order_nostock_last = '';
 }

$res = $db->query("SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.old_price, $tbl_items.quantity, $tbl_items.quantity_txt, $tbl_items.short_descript, $tbl_items.small_img, $tbl_items.big_img, $tbl_categories.catid, $tbl_categories.fcatname, $tbl_categories.fulltitle FROM $tbl_items, $tbl_categories, $tbl_item_categories WHERE $tbl_items.mnf_id = $mnf_id AND $tbl_items.visible = 1 AND $tbl_categories.catid = $tbl_items.catid AND $tbl_item_categories.itemid = $tbl_items.itemid AND $tbl_item_categories.catid = $tbl_items.catid ORDER BY $order_nostock_last$orderby$limit")or die($db->error());

$shop->list_products($res, $template, 'prLstNoMnf');

$template->out_cycle();


$kolvopagesconst=ceil($quantity_products / $sett['products_onpage']);

 if($pg>1 && $pg>$kolvopagesconst){
 return header404();
 }



$full_pagebar = '';
$pagebar = '';

if($kolvopagesconst>1 && empty($_GET['show_all']))				{

$kolvopages=$kolvopagesconst;
$pagenumber=1;

 while($kolvopages>0){
  if($pagenumber == $pg){
  $pagebar.="<span class=\"PgOpen\">$pagenumber</span> &nbsp;";
  }
  else{
   if($pagenumber==1){
   $pagebar.='<a href="' . $shop->rparams("view=manufacturers&amp;mnf=$mnf_id", "manufacturers/$mnfname/") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
   }
   else{
   $pagebar.='<a href="' . $shop->rparams("view=manufacturers&amp;mnf=$mnf_id&amp;pg=$pagenumber", "manufacturers/$mnfname/pg$pagenumber.html") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
   }
  }
$kolvopages--;
$pagenumber++;
 }

if($pg>=$kolvopagesconst){$nextpage='';}else{$nextpage=$lang['next'];}
if($pg<=1){$prevpage='';}else{$prevpage=$lang['previous'];}

$nextpagenumber=$pg+1;
$prevpagenumber=$pg-1;

 if($prevpagenumber==1 && $prevpage){
 $full_pagebar.='<a href="' . $shop->rparams("view=manufacturers&amp;mnf=$mnf_id", "manufacturers/$mnfname/") . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
 }
 elseif($prevpage){
  $full_pagebar.='<a href="' . $shop->rparams("view=manufacturers&amp;mnf=$mnf_id&amp;pg=$prevpagenumber", "manufacturers/$mnfname/pg$prevpagenumber.html")  . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

$full_pagebar.=$pagebar;

  if($nextpage){
  $full_pagebar.='<a href="' . $shop->rparams("view=manufacturers&amp;mnf=$mnf_id&amp;pg=$nextpagenumber", "manufacturers/$mnfname/pg$nextpagenumber.html") . "\" rel=\"next\" class=\"PglNext\">$nextpage</a>";
  }

  if(! empty($sett['show_all_lnk'])){
   if(empty($_GET['sort'])){
   $_GET['sort'] = $shop->get_sort();
   }
  $full_pagebar .= ' <a href="'.$shop->rparams("view=manufacturers&amp;mnf=$mnf_id", 'show_all').'" class="show_all">'.$lang['show_all'].'</a>';
  }

						}


$template->assign('pages_links', $full_pagebar);
$template->assign('manufacturer_id', $mnf_id);

return $template->out_content();
}
?>