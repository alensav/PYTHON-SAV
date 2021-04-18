<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

echo get_products($cat);

function get_products($cat){
global $sett, $pg, $page_tags, $db, $custom, $lang, $shop, $fcat;
 if(! $page_tags['chain_title_link']){
 return header404();
 }

$custom->get_lang('category');

$_GET['sort'] = isset($_GET['sort']) ? preg_replace("([^a-z\_])", '', $_GET['sort']) : '';
$_GET['desc'] = isset($_GET['desc']) ? intval($_GET['desc']) : 0;
$_GET['only_mnf'] = isset($_GET['only_mnf']) ? intval($_GET['only_mnf']) : 0;

$tbl_items=DB_PREFIX.'items';
$tbl_item_categories=DB_PREFIX.'item_categories';
$tbl_manufacturers=DB_PREFIX.'manufacturers';

$check_def_cat=preg_replace('/\D/', '', $cat);
if($check_def_cat != $cat){return '';}
$cat=intval($cat);

$cat_where1="$tbl_item_categories.catid = $cat";
$item_goup1='';
 if($sett['sbcpr']){
 $sql_cats=c_child_categories($cat);
 $cat_where1="$tbl_item_categories.catid IN($sql_cats)";
 $item_goup1="GROUP BY $tbl_items.itemid";
 unset($sql_cats);
 }

 if($sett['sort_onlycatmnf'] || ! empty($sett['mnu_onlycatmnf'])){
 $res = $db->query("SELECT $tbl_items.mnf_id FROM $tbl_item_categories, $tbl_items WHERE $cat_where1 AND $tbl_items.itemid = $tbl_item_categories.itemid AND $tbl_items.visible = 1 $item_goup1") or die($db->error());
  while($row=$db->fetch_array($res)){
   if($row['mnf_id'] && ! in_array($row['mnf_id'], $shop->onlycatmnfs)){
    if(isset($shop->manufacturers["$row[mnf_id]"])){
    array_push($shop->onlycatmnfs, $row['mnf_id']);
    }
   }
  }
 }

$template = new template('category.tpl');

$subcats_count = get_subcategories($cat, $template);

 if($subcats_count < 1){
 $template->not_condition('subcategories_exists');
 }
 else{
 $template->condition('subcategories_exists');
 }

$template->assign('category_chain_link', "$page_tags[chain_title_link]");
$template->assign('special_text', $page_tags['special']);
$template->assign('category_id', $cat);
$template->assign('sort_options', $shop->get_sort_options());
$template->assign('desc_options', $shop->get_desc_options());
$template->assign('manufacturer_options', get_manufacturer_options());

$template->assign('category_description', $page_tags['description']);

$template->assign('sel_currencies_options', $shop->get_sel_currencies_options());
$template->assign('request_uri_encoded', urlencode($_SERVER['REQUEST_URI']));

 if($page_tags['image']){
 $template->condition('category_image');
 $template->assign('category_image', "<img src=\"$sett[relative_url]img/small/$page_tags[image]\" alt=\"$page_tags[chain_title]\">");
 }
 else{
 $template->not_condition('category_image');
 $template->assign('category_image', '');
 }

 if(! empty($shop->categories["$cat"]['menu_img'])){
 $template->assign('category_menu_image', "<img src=\"$sett[relative_url]img/small/".$shop->categories[$cat]['menu_img'].'">');
 }
 else{
 $template->assign('category_menu_image', '');
 }

 if(! empty($shop->categories["$cat"]['main_img'])){
 $template->assign('category_main_image', "<img src=\"$sett[relative_url]img/small/{$shop->categories[$cat][main_img]}\">");
 }
 else{
 $template->assign('category_main_image', '');
 }

 if($_GET['only_mnf']){
 $mnf_where=" AND $tbl_items.mnf_id = $_GET[only_mnf] ";
 }
 else{
 $mnf_where='';
 }

$res = $db->query("SELECT $tbl_items.itemid FROM $tbl_item_categories, $tbl_items WHERE $cat_where1 AND $tbl_items.itemid = $tbl_item_categories.itemid AND $tbl_items.visible = 1 $mnf_where $item_goup1") or die($db->error());
$quantity_products = $db->num_rows($res);

$pg=intval($pg);
if(! $pg){$pg=1;}

 if($quantity_products<1){
 $template->not_condition('products');
 return $template->out_content();
 }
 else{
 $template->condition('products');
 }


$sett['products_onpage']=intval($sett['products_onpage']);
 if($sett['products_onpage'] < 1){
 $sett['products_onpage'] = 10;
 }

$tstfirst_line=$pg * $sett['products_onpage'] - $sett['products_onpage'];
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){return header404();}

if($first_line < 0 ){return '';}

 if($_GET['sort']){
   switch($_GET['sort']){
   case 'id': $orderby = "$tbl_items.itemid"; break;
   case 'udate': $orderby = "$tbl_items.upd_date"; break;
   case 'price': $orderby = "$tbl_items.price"; break;
   case 'title': $orderby = "$tbl_items.title"; break;
   case 'sku': $orderby = "$tbl_items.sku"; break;
   case 'mnf': $orderby = "$tbl_manufacturers.title"; break;

   default: $orderby = "$tbl_items.itemid";
   }
  if($_GET['desc']){$orderby.=' DESC';}
 }
 elseif(! empty($sett['sort_products'])){
   switch($sett['sort_products']){
   case 'id': $orderby = "$tbl_item_categories.sortid, $tbl_items.itemid"; break;
   case 'udate': $orderby = "$tbl_item_categories.sortid, $tbl_items.upd_date"; break;
   case 'price': $orderby = "$tbl_item_categories.sortid, $tbl_items.price"; break;
   case 'title': $orderby = "$tbl_item_categories.sortid, $tbl_items.title"; break;
   case 'sku': $orderby = "$tbl_item_categories.sortid, $tbl_items.sku"; break;
   case 'mnf': $orderby = "$tbl_item_categories.sortid, $tbl_manufacturers.title"; break;
   default: $orderby = "$tbl_item_categories.sortid, $tbl_items.itemid";
   }
  if($sett['sortpr_desc']){$orderby.=' DESC';}
 }
 else{
 $orderby = "$tbl_item_categories.sortid, $tbl_items.itemid DESC";
 }


$template->get_cycle('products');
$template->get_cycle('product_options', 'products');

$limit='';
 if(empty($_GET['show_all'])){
 $limit=" LIMIT $first_line, $sett[products_onpage]";
 }

 if(! empty($sett['sort_nostock_last'])){
 $order_nostock_last = "`$tbl_items`.`quantity` > 0 DESC, ";
 }
 else{
 $order_nostock_last = '';
 }

$res = $db->query("SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.mnf_id, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.old_price, $tbl_items.quantity, $tbl_items.quantity_txt, $tbl_items.short_descript, $tbl_items.small_img, $tbl_items.big_img, $tbl_manufacturers.mnfname, $tbl_manufacturers.title as manufacturer_title FROM $tbl_item_categories, $tbl_items, $tbl_manufacturers WHERE $cat_where1 AND $tbl_items.itemid = $tbl_item_categories.itemid AND $tbl_items.visible = 1 AND $tbl_manufacturers.mnf_id = $tbl_items.mnf_id $mnf_where $item_goup1 ORDER BY $order_nostock_last$orderby$limit") or die($db->error());

$shop->list_products($res, $template, 'prLstNoCat');

$template->out_cycle();



$kolvopagesconst=ceil($quantity_products / $sett['products_onpage']);

 if($pg>1 && $pg>$kolvopagesconst){
 return header404();
 }



$full_pagebar='';

 if($kolvopagesconst > 1 && empty($_GET['show_all'])){

 $kolvopages = $kolvopagesconst;
 $pagenumber = 1;
 $pagebar = '';

  while($kolvopages>0){
   if($pagenumber == $pg){
   $pagebar .= "<span class=\"PgOpen\">$pagenumber</span> &nbsp;";
   }
   else{
    if($pagenumber==1){
    $pagebar.='<a href="' . $shop->rparams("cat=$cat", $custom->statlink($fcat, '', "cat$cat/", 'c')) . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
    }
    else{
    $pagebar.='<a href="' . $shop->rparams("cat=$cat&amp;pg=$pagenumber", $custom->statlink($fcat, "pg$pagenumber.html", "cat$cat/pg$pagenumber.html", 'c')) . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
    }
   }
  $kolvopages--;
  $pagenumber++;
  }

  if($pg >= $kolvopagesconst){
  $nextpage = '';
  }
  else{
  $nextpage=$lang['next'];
  }

  if($pg<=1){
  $prevpage='';
  }
  else{
  $prevpage=$lang['previous'];
  }

 $nextpagenumber=$pg+1;
 $prevpagenumber=$pg-1;

  if($prevpagenumber==1 && $prevpage){
  $full_pagebar.='<a href="' . $shop->rparams("cat=$cat", $custom->statlink($fcat, '', "cat$cat/", 'c')) . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }
  elseif($prevpage){
  $full_pagebar.='<a href="' . $shop->rparams("cat=$cat&amp;pg=$prevpagenumber", $custom->statlink($fcat, "pg$prevpagenumber.html", "cat$cat/pg$prevpagenumber.html", 'c'))  . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

 $full_pagebar .= $pagebar;

  if($nextpage){
  $full_pagebar.='<a href="' . $shop->rparams("cat=$cat&amp;pg=$nextpagenumber", $custom->statlink($fcat, "pg$nextpagenumber.html", "cat$cat/pg$nextpagenumber.html", 'c')) . "\" rel=\"next\" class=\"PglNext\">$nextpage</a>";
  }

  if(! empty($sett['show_all_lnk'])){
   if(empty($_GET['sort'])){
   $_GET['sort'] = $shop->get_sort();
   }
  $full_pagebar .= ' <a href="'.$shop->rparams("cat=$cat", 'show_all').'" class="show_all">'.$lang['show_all'].'</a>';
  }

 }

$template->assign('pages_links', $full_pagebar);
$template->assign('category_id', $cat);

return $template->out_content();
}



function get_manufacturer_options(){
global $lang, $shop, $sett;
 if($sett['sort_onlycatmnf']){
 $manufacturers=array();
  if(sizeof($shop->onlycatmnfs)){
   foreach($shop->onlycatmnfs as $mnf_id){
   $manufacturers["$mnf_id"]=$shop->manufacturers["$mnf_id"];
   }
  }
 }
 else{
 $manufacturers=$shop->manufacturers;
 }
 
$ret="<option value=\"\">$lang[all_manufacturers]</option>";
 if(sizeof($manufacturers)){
  foreach($manufacturers as $mnf_id => $mnf_row){
  $ret.="<option value=\"$mnf_id\"";
  if($mnf_id == $_GET['only_mnf']){$ret.=' selected';}
  $ret.=">$mnf_row[title]</option>";
  }
 }
return $ret;
}


function get_subcategories($parent, &$template){
global $sett, $custom, $lang, $shop;
$subcategories = array();
$subcats_count = 0;
 foreach($shop->categories as $catid => $row){
  if($row['parent'] == $parent){
  $subcats_count++;
  $subcategories["$catid"] = $row;
  }
 }

$quantitycat_incolumn = ceil($subcats_count / $sett['quantity_columns']);

$template->get_cycle('subcategories');

 foreach($subcategories as $catid => $row){

 $template->assign_cycle('category_url', @stdi2("cat=$catid", $custom->statlink($row['fcat'], '', "cat$catid/", 'c')), 'subcategories');
 $template->assign_cycle('category_title', $row['title']);
 $template->assign_cycle('category_products_count', $row['count']);

  if(! empty($row['image'])){
  $template->assign_cycle('image', "<img src=\"$sett[relative_url]img/small/$row[image]\">");
  }
  else{
  $template->assign_cycle('image', '');
  }

  if(! empty($row['menu_img'])){
  $template->assign_cycle('menu_image', "<img src=\"$sett[relative_url]img/small/$row[menu_img]\" alt=\"\">");
  }
  else{
  $template->assign_cycle('menu_image', '');
  }

  if(! empty($row['main_img'])){
  $template->assign_cycle('main_image', "<img src=\"$sett[relative_url]img/small/$row[main_img]\" alt=\"\">");
  }
  else{
  $template->assign_cycle('main_image', '');
  }

 $template->assign_cycle('quantitycat_incolumn', $quantitycat_incolumn);

  if($sett['show_quantity']){
  $template->condition_cycle('show_quantity');
  }
  else{
  $template->not_condition_cycle('show_quantity');
  }

 $template->between_cycles();
 $template->next_loop();

 }

$template->out_cycle();
return $subcats_count;
}


function c_child_categories($cat){
global $shop;
 if(! sizeof($shop->categories)){
 return $cat;
 }
$ret=$cat.',';
 foreach($shop->categories as $def_catid => $row){
  if($row['parent']==$cat){
  $ret.=c_child_categories($def_catid).',';
  }
 }
return substr($ret, 0, strlen($ret)-1);
}

?>