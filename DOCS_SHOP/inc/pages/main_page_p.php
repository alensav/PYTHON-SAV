<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

echo get_main_page();

function get_main_page(){
global $db, $custom, $sett, $lang, $page_tags, $shop;
$custom->get_lang('category');
$template = new template('main.tpl');

$tbl_items=DB_PREFIX.'items';
$tbl_mainitems=DB_PREFIX.'mainitems';
$tbl_categories=DB_PREFIX.'categories';
$tbl_manufacturers=DB_PREFIX.'manufacturers';

main_categories($template);

$res = $db->query("SELECT $tbl_mainitems.*, $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.mnf_id, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.old_price, $tbl_items.quantity,  $tbl_items.quantity_txt, $tbl_items.short_descript, $tbl_items.small_img, $tbl_items.big_img, $tbl_categories.fcatname, $tbl_categories.fulltitle, $tbl_manufacturers.mnfname, $tbl_manufacturers.title as manufacturer_title FROM $tbl_mainitems, $tbl_items, $tbl_categories, $tbl_manufacturers WHERE $tbl_items.itemid = $tbl_mainitems.main_itemid AND $tbl_items.visible = 1 AND $tbl_categories.catid = $tbl_items.catid AND $tbl_manufacturers.mnf_id = $tbl_items.mnf_id ORDER BY $tbl_mainitems.main_sortid, $tbl_items.upd_date DESC") or die($db->error());


 if($db->num_rows($res) > 0){

 $template->condition('products');

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

 $template->get_cycle('products');
 $template->get_cycle('product_options', 'products');

 $shop->list_products($res, $template, 'prLstNoMain');

 $template->out_cycle();


 }
 else{
 $template->not_condition('products');
 }

$template->assign('main_description', $page_tags['description']);
$template->assign('special_text', $page_tags['special']);

return $template->out_content();
}



function main_categories(&$template){
global $sett, $shop, $custom;
$sett['maincat_qcolumns'] = intval($sett['maincat_qcolumns']);

 if($sett['maincat_qcolumns'] < 1){
 $template->not_condition('main_categories');
 return;
 }
 else{
 $template->condition('main_categories');
 }

$parent='0';
$q_columns=0;

$template->get_cycle('categories');
$template->get_cycle('subcategories', 'categories');

 foreach($shop->categories as $catid => $row){

  if($row['parent'] == $parent && $catid){

  $template->assign_cycle('maincat_qcolumns', $sett['maincat_qcolumns'], 'categories');
  $template->assign_cycle('category_url', @stdi2("cat=$catid", $custom->statlink($row['fcat'], '', "cat$catid/", 'c')));
   if($sett['show_quantity_main']){
   $template->assign_cycle('category_title', "$row[title]&nbsp;($row[count])");
   }
   else{
   $template->assign_cycle('category_title', $row['title']);
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

 $subcats_count=main_subcategories($catid, $template);

  if($subcats_count){
  $template->condition_cycle('subcategories', 'categories');
  }
  else{
  $template->not_condition_cycle('subcategories', 'categories');
  }


 $q_columns++;
   if($q_columns >= $sett['maincat_qcolumns']){
   $q_columns=0;
   }

 $template->between_cycles('categories');
 $template->next_loop('categories');
 }

}

$q_columns=($sett['maincat_qcolumns']-$q_columns)*2;

$template->out_cycle('categories');
}


function main_subcategories($parent, &$template){
global $sett, $lang, $shop, $custom;
$subcats_count = 0;
$sett['main_maxsubcats'] = intval($sett['main_maxsubcats']);
 if($sett['main_maxsubcats'] < 0){
 $sett['main_maxsubcats'] = 0;
 }
$cnt_subchapters=0;

 foreach($shop->categories as $catid => $row){

  if($sett['main_maxsubcats'] < 1){
  break;
  }

  if($row['parent'] == $parent){
  $subcats_count++;

  $template->assign_cycle('subcategory_url', @stdi2("cat=$catid", $custom->statlink($row['fcat'], '', "cat$catid/", 'c')), 'subcategories');
   if($sett['show_quantity_main']){
   $template->assign_cycle('subcategory_title', "$row[title]&nbsp;($row[count])");
   }
   else{
   $template->assign_cycle('subcategory_title', $row['title']);
   }

   if(! empty($row['menu_img'])){
   $template->assign_cycle('submenu_image', "<img src=\"$sett[relative_url]img/small/$row[menu_img]\" alt=\"\">");
   }
   else{
   $template->assign_cycle('submenu_image', '');
   }

   if(! empty($row['main_img'])){
   $template->assign_cycle('submain_image', "<img src=\"$sett[relative_url]img/small/$row[main_img]\" alt=\"\">");
   }
   else{
   $template->assign_cycle('submain_image', '');
   }

  $cnt_subchapters++;

   if($sett['main_maxsubcats'] > $cnt_subchapters){
   $template->assign_cycle('more_cat_link', '');
   }
   else{
   $template->next_loop('subcategories');
   break;
   }

  $template->next_loop('subcategories');
  }

 }

$template->out_cycle('subcategories');
return $subcats_count;
}



?>