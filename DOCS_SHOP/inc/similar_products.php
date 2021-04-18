<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class similar_products{

function get_similar_products($itemid, &$template){
global $db, $sett, $shop, $custom;
$tbl_items=DB_PREFIX.'items';
$tbl_item_similar=DB_PREFIX.'item_similar';
$itemid=intval($itemid);

$template->get_cycle('similar_products');

$res = $db->query("SELECT $tbl_items.* FROM $tbl_item_similar, $tbl_items WHERE $tbl_item_similar.itemid = $itemid AND $tbl_items.itemid = $tbl_item_similar.similar_itemid AND $tbl_items.visible = 1 ORDER BY $tbl_item_similar.sortid") or die($db->error());

$qw_items=0;
 while($row=$db->fetch_array($res)){
 $row['fcatname']=$shop->categories["$row[catid]"]['fcat'];

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

  if($row['small_img']){
  $template->condition_cycle('similar_small_image');
  }
  else{
  $template->not_condition_cycle('similar_small_image');
  }

 if($row['old_price'] > 0){
 $template->condition_cycle('similar_old_price');
 }
 else{
 $template->not_condition_cycle('similar_old_price');
 }

$similar_url = @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'));

 if($row['small_img']){
 $image = "<a href=\"$similar_url\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" alt=\"$row[title]\" title=\"$row[title]\" $smallimg_width></a>";
 }
 else{
 $image = '';
 }

 $template->assign_cycle('similar_small_img_width', $smallimg_width);
 $template->assign_cycle('similar_small_img_numeric_width', intval($sett['smallimg_width']));
 $template->assign_cycle('similar_big_img_width', $bigimg_width);
 $template->assign_cycle('similar_big_img_numeric_width', intval($sett['bigimg_width']));
 $template->assign_cycle('similar_small_image', $image);
 $template->assign_cycle('similar_url', $similar_url);
 $template->assign_cycle('similar_sku', $row['sku']);
 $template->assign_cycle('similar_title', $row['title']);
 $template->assign_cycle('similar_price', $shop->format_price($shop->calc_price($row['price'])));
 $template->assign_cycle('similar_old_price', $shop->format_price($shop->calc_price($row['old_price'])));
 $template->assign_cycle('similar_short_descript', $row['short_descript']);
 $template->assign_cycle('similar_small_img', $row['small_img']);
 $template->assign_cycle('similar_big_img', $row['big_img']);
 $template->between_cycles();
 $template->next_loop();
 $qw_items++;
 }

 if($qw_items){
 $template->condition('similar_products');
 }
 else{
 $template->not_condition('similar_products');
 }

$template->out_cycle();
}



}
?>