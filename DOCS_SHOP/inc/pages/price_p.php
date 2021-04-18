<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $custom, $shop, $db, $sett, $lang;
$custom->get_lang('price');

$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';

 if(! isset($_GET['sort'])){
 $_GET['sort'] = '';
 }

 switch($_GET['sort']){
 case 'title': $orderby='title'; break;
 case 'sku': $orderby='sku'; break;
 case 'price': $orderby='price'; break;
 case 'quantity': $orderby='quantity'; break;
 default: $orderby='title';
 }

require_once(INC_DIR."/mem_ec_template.php");
$template = new mem_ec_template('price.tpl');
tunable_css($template);
$tpl_arr = $template->get_block('products', $template->get_tpl());


$tpl_arr['header'] = str_replace('{charset}', $sett['charset'], $tpl_arr['header']);
$ret=$tpl_arr['header'];
$tpl_arr['header'] = str_replace('{pages_title}', $sett['pages_title'], $tpl_arr['header']);
$tpl_arr['header'] = $template->replace_lang($tpl_arr['header']);
$tpl_arr['header'] = str_replace('{shop_url}', "$sett[url]", $tpl_arr['header']);
$tpl_arr['header'] = str_replace('{relative_url}', $sett['relative_url'], $tpl_arr['header']);
$tpl_arr['header'] = str_replace('{shop_index}', "$sett[relative_url]$sett[index_file]", $tpl_arr['header']);
$tpl_arr['header'] = str_replace('{design_url}', "$sett[relative_url]design/$sett[design]/", $tpl_arr['header']);

 if(! empty($sett['currency_selection'])){
 $tpl_arr['header'] = $template->condition('currency_selection', $tpl_arr['header']);
 $tpl_arr['header'] = str_replace('{sel_currencies_options}', $shop->get_sel_currencies_options(), $tpl_arr['header']);
 $tpl_arr['header'] = str_replace('{request_uri_encoded}', urlencode($_SERVER['REQUEST_URI']), $tpl_arr['header']);
 }
 else{
 $tpl_arr['header'] = $template->not_condition('currency_selection', $tpl_arr['header']);
 }

$ret = $tpl_arr['header'];

$tpl_arr['body'] = $template->replace_lang($tpl_arr['body']);

$res = $db->query("SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.quantity, $tbl_items.quantity_txt, $tbl_items.small_img, $tbl_items.big_img, $tbl_categories.fcatname, $tbl_categories.fulltitle FROM $tbl_items, $tbl_categories WHERE $tbl_items.visible = 1 AND $tbl_categories.catid = $tbl_items.catid ORDER BY $tbl_categories.fulltitle, $tbl_items.$orderby")or die($db->error());

$old_cat=0;

 while($row=$db->fetch_array($res)){
 $tpl = $tpl_arr['body'];

  if($row['catid'] != $old_cat){
  $tpl = $template->condition('next_category', $tpl);
  $tpl = str_replace('{category_title}', $row['fulltitle'], $tpl);
  $tpl = str_replace('{category_url}', @stdi2("cat=$row[catid]", $custom->statlink($row['fcatname'], '', "cat$row[catid]/", 'c')), $tpl);
  $def_class='ttr';
  }
  else{
  $tpl = $template->not_condition('next_category', $tpl);
  }

 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
 $tpl = str_replace('{def_class}', $def_class, $tpl);
 $tpl = str_replace('{product_title}', $row['title'], $tpl);
 $tpl = str_replace('{product_url}', @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p')), $tpl);
 $tpl = str_replace('{product_sku}', $row['sku'], $tpl);
 $tpl = str_replace('{product_price}', $shop->format_price($shop->calc_price($row['price'])), $tpl);
 $tpl = str_replace('{currency_brief}', $sett['show_curr_brief'], $tpl);
 if($row['quantity'] >= 4294967295){$row['quantity']=$lang['unlim'];}
 $tpl = str_replace('{product_quantity}', $row['quantity'], $tpl);
 $tpl = str_replace('{quantity_txt}', $row['quantity_txt'], $tpl);
 $tpl = str_replace('{small_img}', $row['small_img'], $tpl);
 $tpl = str_replace('{big_img}', $row['big_img'], $tpl);

  if(! empty($sett['null_price_text'])){
  $tpl = replace_null_pices($tpl, $sett['null_price_text']);
  }

 $ret .= $tpl;

  if(strlen($ret) > 61440){
  echo $ret;
  $ret = '';
  }

 $old_cat = $row['catid'];
 }


$ret.=$tpl_arr['footer'];
$ret = $template->replace_lang($ret);
$ret = str_replace('{shop_url}', "$sett[url]", $ret);
$ret = str_replace('{relative_url}', $sett['relative_url'], $ret);
$ret = str_replace('{shop_index}', "$sett[relative_url]$sett[index_file]", $ret);
$ret = str_replace('{design_url}', "$sett[relative_url]design/$sett[design]/", $ret);

echo $ret;
unset($tpl_arr, $ret, $old_cat, $tpl, $def_class);
?>