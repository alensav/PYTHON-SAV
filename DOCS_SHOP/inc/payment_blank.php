<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class pm_blank{

function show_pm_blank($is_admin){
global $db, $shop_order, $sett;
$max_link_life = 60 ;

@header("Pragma: no-cache");
@header("Cache-Control: no-cache, must-revalidate");
@header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");

 if(! is_object($shop_order)){
 require_once(INC_DIR."/shop_order.php");
 $shop_order=new shop_order;
 }

$blank_id = intval($_GET['blank_id']);
 if(! $blank_id){
 return 'No blank_id parameter.';
 }

$pmid = isset($_GET['pmid']) ? intval($_GET['pmid']) : 0;
$orderid = intval($_GET['orderid']);

$tbl=DB_PREFIX.'orders';
$res=$db->query("SELECT * FROM $tbl WHERE orderid = $orderid") or die($db->error());
$order_dt = $db->fetch_array($res);

 if(! $order_dt['orderid']){
 return '';
 }

 if(! $is_admin){
  if(! $this->check_order_secret_key($order_dt, $_GET['osk'])){
  return 'No valid parameters.';
  }
 }

$max_link_life = $max_link_life * 86400;
 if( ($order_dt['date'] + $max_link_life < time() ) && ! $is_admin){
 return 'Order expired.';
 }

require_once(INC_DIR."/number_in_words_c.php");
$number_in_words=new number_in_words;

$and_where = '';
 if(! $is_admin){
 $and_where = "AND paymethod_id = $pmid";
 }

$tbl=DB_PREFIX.'payment_blanks';
$res=$db->query("SELECT blank_text FROM $tbl WHERE blank_id = $blank_id $and_where") or die($db->error());
$row=$db->fetch_array($res);
 if(! $row['blank_text']){
 return '';
 }

$tpl_arr = $this->get_block($row['blank_text']);
 if(strstr(' ' . $row['blank_text'], '<!--begin:products-->') && strstr(' ' . $row['blank_text'], '<!--end:products-->')){

 $tpl = $this->process_products($orderid, $tpl_arr['body']);
 $row['blank_text'] = $tpl_arr['header'] . $tpl . $tpl_arr['footer'];
 }

unset($tpl_arr);
 
$row['blank_text'] = str_replace('{date}', date("d.m.Y", $order_dt['date'] + $sett['time_diff'] * 3600), $row['blank_text']);
$row['blank_text'] = str_replace('{time}', date("H:i:s", $order_dt['date'] + $sett['time_diff'] * 3600), $row['blank_text']);
$row['blank_text'] = str_replace('{order_number}', $orderid, $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_integer}', substr($order_dt['final_total'], 0, strpos($order_dt['final_total'], '.')), $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_fractional}', substr($order_dt['final_total'], strpos($order_dt['final_total'], '.')+1), $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_pc_integer}', substr($order_dt['final_total_pc'], 0, strpos($order_dt['final_total_pc'], '.')), $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_pc_fractional}', substr($order_dt['final_total_pc'], strpos($order_dt['final_total_pc'], '.')+1), $row['blank_text']);

  $row['blank_text'] = str_replace('{total_integer}', substr($order_dt['final_total'], 0, strpos($order_dt['final_total'], '.')), $row['blank_text']);
  $row['blank_text'] = str_replace('{total_fractional}', substr($order_dt['final_total'], strpos($order_dt['final_total'], '.')+1), $row['blank_text']);

$row['blank_text'] = str_replace('{total_with_delivery}', $order_dt['final_total'], $row['blank_text']);
$row['blank_text'] = str_replace('{total_with_delivery_pc}', $order_dt['final_total_pc'], $row['blank_text']);

 foreach($order_dt as $name => $value){
  if(! is_numeric($name)){
  $row['blank_text'] = str_replace('{'.$name.'}', $value, $row['blank_text']);
  }
 }

$amount_in_words_arr=$number_in_words->amount_in_words($order_dt['final_total']);
$row['blank_text'] = str_replace('{final_total_words_integer}', $amount_in_words_arr[0], $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_words_int_symbol}', $amount_in_words_arr[1], $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_words_fractional}', $amount_in_words_arr[2], $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_words_fract_symbol}', $amount_in_words_arr[3], $row['blank_text']);

$amount_in_words_arr=$number_in_words->amount_in_words($order_dt['final_total_pc']);
$row['blank_text'] = str_replace('{final_total_pc_words_integer}', $amount_in_words_arr[0], $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_pc_words_int_symbol}', $amount_in_words_arr[1], $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_pc_words_fractional}', $amount_in_words_arr[2], $row['blank_text']);
$row['blank_text'] = str_replace('{final_total_pc_words_fract_symbol}', $amount_in_words_arr[3], $row['blank_text']);


$tbl=DB_PREFIX.'orders_add_fields_values';
$res2=$db->query("SELECT * FROM $tbl WHERE orderid = $orderid") or die($db->error());
 while($row2=$db->fetch_array($res2)){
 $row2['field_name'] = trim($row2['field_name']);
  if($row2['field_name']){
  $row['blank_text'] = str_replace('{add.'.$row2['field_name'].'}', $row2['field_values'], $row['blank_text']);
  }
 }
$row['blank_text'] = preg_replace('((\{add\.)([a-zA-Z0-9\_]{1,255})(\}))', '', $row['blank_text']);

$row['blank_text'] = str_replace('{charset}', $sett['charset'], $row['blank_text']);
$row['blank_text'] = str_replace('{shop_url}', $sett['url'], $row['blank_text']);
$row['blank_text'] = str_replace('{relative_url}', $sett['relative_url'], $row['blank_text']);
$row['blank_text'] = str_replace('{shop_index}', "$sett[relative_url]$sett[index_file]", $row['blank_text']);
$row['blank_text'] = str_replace('{design_url}', "$sett[relative_url]design/$sett[design]/", $row['blank_text']);
$row['blank_text'] = str_replace('{shop_email}', $sett['email'], $row['blank_text']);
$row['blank_text'] = str_replace('{shop_name}', $sett['shop_name'], $row['blank_text']);

return $row['blank_text'];
}


function process_products($orderid, $body_template){
global $db;
$orderid = intval($orderid);
$tpl = '';
$tbl=DB_PREFIX.'orders_items';
$res=$db->query("SELECT * FROM `$tbl` WHERE `orderid` = $orderid") or die($db->error());
$order_products = array();
 while($row=$db->fetch_array($res)){
 $order_products["$row[oiid]"] = $row;
 }


 foreach($order_products as $row){
 $body = $body_template;
 $body = str_replace('{oiid}', $row['oiid'], $body);
 $body = str_replace('{product_id}', $row['itemid'], $body);
 $body = str_replace('{product_sku}', $row['sku'], $body);
 $body = str_replace('{product_title}', $row['title'], $body);
 $body = str_replace('{product_price}', $row['price'], $body);
 $body = str_replace('{product_price_pc}', $row['price_pc'], $body);
 $body = str_replace('{product_quantity}', $row['quantity'], $body);
 $body = str_replace('{product_sum}', pricef($row['price'] * $row['quantity']), $body);
 $body = str_replace('{product_sum_pc}', pricef($row['price_pc'] * $row['quantity']), $body);
 $row['options'] = custom::rn_to_n($row['options']);
 $row['options'] = str_replace("\n", '<br>', $row['options']);
 $body = str_replace('{product_options}', $row['options'], $body);
 $tpl .= $body;
 }

return $tpl;
}


function prices_considering_discount($order_products, $final_total_sel_currency){

$sum1_def_currency=0;
$total_cost_def_currency=0;

 foreach($order_products as $tmpid => $product){
 $sum1_def_currency+=$product['price'];
 $total_cost_def_currency += $product['price'] * $product['quantity'];
 }

 foreach($order_products as $tmpid => $product){
 $order_products["$tmpid"]["price_coefficient"] = $sum1_def_currency / $product['price'];
 }



$difference_coefficient_def_currency = $total_cost_def_currency / $sum1_def_currency;

$sum1_sel_currency = $final_total_sel_currency / $difference_coefficient_def_currency;

 foreach($order_products as $tmpid => $product){
 $order_products["$tmpid"]["price_pc"] = pricef($sum1_sel_currency / $product['price_coefficient']);
 $order_products["$tmpid"]["price"] = pricef($sum1_sel_currency / $product['price_coefficient']);
 }


return $order_products;
}



function check_order_secret_key($order_dt, $order_secret_key){
global $shop_order;
$osk=$shop_order->get_osk($order_dt);
$osk_old1=$shop_order->get_osk_old1($order_dt);
 if($order_secret_key === $osk || $order_secret_key === $osk_old1){
 return true;
 }
return false;
}


function get_block($data){
$ret=array();
$ret['body']=' '.$data;
$pos=strpos($ret['body'], '<!--begin:products-->');
 if($pos){
 $ret['header']=substr($ret['body'], 0, $pos);
 $ret['body']=substr($ret['body'], $pos+21);
 }
$pos=strpos($ret['body'], '<!--end:products-->');
 if($pos){
 $ret['footer']=substr($ret['body'], $pos+19);
 $ret['body']=substr($ret['body'], 0, $pos);
 }
return $ret;
}


}
?>