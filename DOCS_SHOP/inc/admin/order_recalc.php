<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class order_recalc{


function recalc_order($orderid, $order_data, $recalc_all_products, $products_oiid_for_recalc, $no_update_final_total){
global $orders, $sett;
$orderid=intval($orderid);

 if(! sizeof($order_data)){
 $order_data=$orders->get_order_info($orderid);
 }

 if(! $order_data['orderid']){
 return false;
 }

$this->or_pay_method($order_data);
$this->or_currency($order_data);
$this->or_delivery_method($order_data);
$this->or_country($order_data);
$this->recalc_products($order_data, $recalc_all_products, $products_oiid_for_recalc);

 if($order_data['discount_percents'] > 0){
 $order_data['discount'] = pricef($order_data['total'] * $order_data['discount_percents'] / 100);
 $order_data['discount_pc'] = pricef($order_data['total_pc'] * $order_data['discount_percents'] / 100);
 $order_data['total_with_discount'] = pricef($order_data['total'] - $order_data['discount']);
 $order_data['total_with_discount_pc'] = pricef($order_data['total_pc'] - $order_data['discount_pc']);
 }
 else{
 $order_data['discount_percents'] = 0;
 $order_data['discount'] = 0;
 $order_data['discount_pc'] = 0;
 $order_data['total_with_discount'] = $order_data['total'];
 $order_data['total_with_discount_pc'] = $order_data['total_pc'];
 }

$order_data['total']=pricef($order_data['total']);
$order_data['total_pc']=pricef($order_data['total_pc']);
$order_data['discount'] = pricef($order_data['discount']);
$order_data['discount_pc'] = pricef($order_data['discount_pc']);
$order_data['total_with_discount'] = pricef($order_data['total_with_discount']);
$order_data['total_with_discount_pc'] = pricef($order_data['total_with_discount_pc']);

$order_data['delivery_cost_pc'] = $orders->adm_calc_price($order_data['delivery_cost'], $order_data['currency_course']);

 if(! $no_update_final_total){
 $order_data['final_total'] = pricef($order_data['total_with_discount'] + $order_data['delivery_cost']);
 $order_data['final_total_pc'] = pricef($order_data['total_with_discount_pc'] + $order_data['delivery_cost_pc']);
 }

return $this->or_update_order($order_data);
}


function or_pay_method(&$order_data){
global $db;
$tbl=DB_PREFIX.'paymethods';
$order_data['pmid']=intval($order_data['pmid']);
$res=$db->query("SELECT `pmid`, `pmtitle`, `advname` FROM `$tbl` WHERE `pmid` = '$order_data[pmid]'") or die($db->error());
$row=$db->fetch_array($res);
$order_data['paymethod']=$row['pmtitle'];
$order_data['paymethod_advname']=$row['advname'];
}


function or_currency(&$order_data){
global $db, $sett;
$order_data['currency_id']=intval($order_data['currency_id']);
$tbl=DB_PREFIX.'currencies';
$res=$db->query("SELECT `currency_id`, `brief`, `title` FROM `$tbl` WHERE `currency_id` = '$order_data[currency_id]'") or die($db->error());
$row=$db->fetch_array($res);
$order_data['currency']=$row['title'];
$order_data['currency_brief']=$row['brief'];
$order_data['def_currency_id']=intval($sett['def_currency']);
$order_data['def_currency']=$this->get_default_currency_title();
$order_data['def_currency_brief']=$sett['curr_brief'];
}


function get_default_currency_title(){
global $db, $sett;
$tbl=DB_PREFIX.'currencies';
$res=$db->query("SELECT title FROM $tbl WHERE currency_id = '$sett[def_currency]'") or die($db->error());
return @$db->result($res,0,'title');
}


function or_delivery_method(&$order_data){
global $db;
$order_data['dmid']=intval($order_data['dmid']);
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT `dmname` FROM `$tbl` WHERE `dmid` = '$order_data[dmid]'") or die($db->error());
$row=$db->fetch_array($res);
$order_data['deliverymethod']=$row['dmname'];
}


function or_country(&$order_data){
global $db;
$order_data['country_id']=intval($order_data['country_id']);
$tbl=DB_PREFIX.'countries';
$res=$db->query("SELECT `country_name` FROM `$tbl` WHERE `country_id` = '$order_data[country_id]'") or die($db->error());
$row=$db->fetch_array($res);
$order_data['country']=$row['country_name'];
}


function recalc_products(&$order_data, $recalc_all_products, $products_oiid_for_recalc){
global $db, $orders;
$tbl_orders_items=DB_PREFIX.'orders_items';
$order_data['total'] = 0;
$order_data['total_pc'] = 0;
$order_products=array();
$res=$db->query("SELECT `oiid`, `price`, `price_pc`, `quantity` FROM `$tbl_orders_items` WHERE `orderid` = '$order_data[orderid]'") or die($db->error());
 while($row=$db->fetch_array($res)){
  if($recalc_all_products || in_array($row['oiid'], $products_oiid_for_recalc)){
  $row['price_pc']=$orders->adm_calc_price($row['price'], $order_data['currency_course']);
  }
 array_push($order_products, $row);
 }

 if(sizeof($order_products)){
  foreach($order_products as $row){
   if($recalc_all_products || in_array($row['oiid'], $products_oiid_for_recalc)){
   $db->query("UPDATE `$tbl_orders_items` SET `price_pc` = '$row[price_pc]' WHERE `oiid` = $row[oiid]") or die($db->error());
   }
  $cost = pricef($row['price'] * $row['quantity']);
  $cost_pc = pricef($row['price_pc'] * $row['quantity']);
  $order_data['total'] += $cost;
  $order_data['total_pc'] += $cost_pc;
  }
 }

$order_data['total']=pricef($order_data['total']);
$order_data['total_pc']=pricef($order_data['total_pc']);
}



function or_update_order($order_data){
global $db;
$tbl_name=DB_PREFIX.'orders';
$update_data='';
$begin_data=false;

 foreach($order_data as $name => $value){

  if(! is_numeric($name)){
   if($begin_data){
   $update_data.=', ';
   }
  $value=$db->secstr($value);
   if(! is_numeric($value)){
   $value = '\''.$value.'\'';
   }
  $update_data.='`'.$name.'` = '. $value;
  $begin_data=true;
  }

 }

return $db->query("UPDATE `$tbl_name` SET $update_data WHERE orderid = $order_data[orderid]") or die($db->error());
}





}
?>