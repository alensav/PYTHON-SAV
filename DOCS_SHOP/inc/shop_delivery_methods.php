<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class shop_delivery_methods{

function get_delivery_methods(){
global $db, $lang, $sett, $custom, $template, $shop;
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT * FROM $tbl WHERE enabled = 1 ORDER BY sortid, dmname")or die($db->error());

$num_rows=$db->num_rows($res);

if(! $num_rows){return header404();}

 $def_class='ttr';

 $template = new template('delivery_methods.tpl');
 $template->get_cycle('delivery_methods');

  while($row=$db->fetch_array($res)){
  if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}
  $template->assign_cycle('def_class', $def_class);
  $template->assign_cycle('delivery_method_id', $row['dmid']);
  $template->assign_cycle('delivery_method_url', @stdi2("view=delivery_methods&dm=$row[dmid]", "delivery_methods/dm$row[dmid].html"));
  $template->assign_cycle('delivery_method_name', $row['dmname']);
  $template->assign_cycle('short_descript', $row['short_descript']);
  $template->assign_cycle('delivery_cost', $shop->format_price($shop->calc_price($row['delivery_cost'])));
   if($row['free_delivery_sum'] > 0){
   $template->assign_cycle('free_delivery_sum', $shop->format_price($shop->calc_price($row['free_delivery_sum'])) . ' ' . $sett['show_curr_brief']);
   }
   else{
   $template->assign_cycle('free_delivery_sum', $lang['not_free_delivery']);
   }
  $template->assign_cycle('currency_brief', $sett['show_curr_brief']);

   if($row['delivery_cost'] > 0){
   $template->condition_cycle('delivery_cost');
   }
   else{
   $template->not_condition_cycle('delivery_cost');
   }

  $template->next_loop();
  }

$template->out_cycle();

return $template->out_content();
}


function get_delivery_method_details($dmid){
global $db, $lang, $sett, $page_tags, $custom, $template, $shop;
$dmid=intval($dmid);

$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT dmname, long_descript, delivery_cost, free_delivery_sum FROM $tbl WHERE dmid = $dmid AND enabled = 1") or die($db->error());

$row=$db->fetch_array($res);

 if(! $row['dmname']){
 global $template;
 return header404();
 }

$template = new template('deliverymethod_detail.tpl');

$template->assign('delivery_method_title', $row['dmname']);
$template->assign('long_descript', $row['long_descript']);
$template->assign('delivery_method_url', @stdi2("view=delivery_methods", "delivery_methods/"));
$template->assign('delivery_cost', $shop->format_price($shop->calc_price($row['delivery_cost'])));
 if($row['free_delivery_sum'] > 0){
 $template->assign('free_delivery_sum', $shop->format_price($shop->calc_price($row['free_delivery_sum'])) . ' ' . $sett['show_curr_brief']);
 }
 else{
 $template->assign('free_delivery_sum', $lang['not_free_delivery']);
 }
$template->assign('currency_brief', $sett['show_curr_brief']);

 if($row['delivery_cost'] > 0){
 $template->condition('delivery_cost');
 }
 else{
 $template->not_condition('delivery_cost');
 }

$page_tags['meta_title'] = "$lang[delivery_method] $row[dmname] - $sett[pages_title]";

return $template->out_content();
}


}
?>