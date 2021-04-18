<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class shop_order{

function get_paymethod_specialinfo($pmid){
global $db;
$pmid=intval($pmid);
if(! $pmid){return array();}
$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT pmtitle, adv_descript, adv_descript_mail, advname FROM $tbl WHERE pmid = $pmid AND enabled = 1")or die($db->error());
return $db->fetch_array($res);
}


function get_orderinfo_table(){
global $lang, $db, $sett, $page_tags, $view, $shop, $custom;
require_once(INC_DIR."/cart_c.php");
$cart = new cart;

$tbl_items=DB_PREFIX.'items';
$tbl_options_match=DB_PREFIX.'item_options_match';

$template = new template('orderinfo_tbl.tpl');

$total_cost=0;
$def_class='ttr';
$total_products_quantity=0;
$user_currency_info = $this->get_currency_info($_SESSION['arwshop_mk']['order']['currency_id']);
$paymethod_specialinfo = $this->get_paymethod_specialinfo($_SESSION['arwshop_mk']['order']['pay_method']);
$paymethod_title = $paymethod_specialinfo['pmtitle'];
unset($paymethod_specialinfo);

$options = $shop->get_product_options();

$template->get_cycle('cart_products');
$template->get_cycle('product_options', 'cart_products');



 foreach($_SESSION['arwshop_mk']['cart_products'] as $product_id => $var_arr){

 $product_id = intval($product_id);

  foreach($var_arr as $variant => $prod){

  $res = $db->query("SELECT sku, title, price, quantity FROM $tbl_items WHERE itemid = $product_id")or die($db->error());
  $row = $db->fetch_array($res);
  $prod['quantity'] = intval($prod['quantity']);
  $row['price'] = $shop->calc_price($row['price'], $user_currency_info['currency_id']);
  




   $is_product_options = 0;
   $options_str = '';

    if(is_array($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"])){

     if(sizeof($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"])){

     $options_id = '';
     $values_id = '';
      foreach($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"] as $name => $value){
      $name = intval($name);
      $value = intval($value);
      $options_id .= ", $name";
      $values_id .= ", $value";
      }
     if(substr($options_id, 0, 2) === ', '){$options_id = substr($options_id, 2);}
     if(substr($values_id, 0, 2) === ', '){$values_id = substr($values_id, 2);}

     $res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference FROM $tbl_options_match WHERE $tbl_options_match.itemid = $product_id AND $tbl_options_match.option_id IN ($options_id) AND $tbl_options_match.option_value_id IN ($values_id)")or die($db->error());

      while($row2 = $db->fetch_array($res2)){
      $is_product_options = 1;
      $row['price'] = $row['price'] + $shop->calc_price($row2['price_difference'], $user_currency_info['currency_id']);
      $template->assign_cycle('product_option_name', $options["$row2[option_id]"]["option_name"], 'product_options');
      $template->assign_cycle('product_option_value', $options["$row2[option_id]"]["$row2[option_value_id]"], 'product_options');
      $template->next_loop('product_options');
      }

     $template->out_cycle('product_options');

     }

    }


    if($is_product_options){
    $template->condition_cycle('product_options', 'cart_products');
    }
    else{
    $template->not_condition_cycle('product_options', 'cart_products');
    }






    if($prod['quantity'] > $row['quantity'] && ! $sett['cart_add_q0']){
    $prod['quantity'] =  $row['quantity'];
    }

    if($prod['quantity']>0){
    $cost=pricef($row['price'] * $prod['quantity']);
    $total_cost+=$cost;
    if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
    $total_products_quantity++;

    $template->assign_cycle('def_class', $def_class);
    $template->assign_cycle('product_url', @stdi2("product=$product_id", "product$product_id.html"));
    $template->assign_cycle('product_title', $row['title']);
    $template->assign_cycle('product_sku', $row['sku']);
    $template->assign_cycle('product_price', $shop->format_price($row['price']));
    $template->assign_cycle('product_id', $product_id);
    $template->assign_cycle('product_quantity', $prod['quantity']);
    $template->assign_cycle('cost', $shop->format_price($cost));
    $template->assign_cycle('variant_id', $variant);
    $template->next_loop();
    }
    else{
    $cart->delete_product($product_id, $variant);
    }

  }

 }

$template->out_cycle();


 if($total_products_quantity<1){
 return "<h3>$lang[empty_cart]</h3>";
 }

require_once(INC_DIR."/cart_c.php");
$cart = new cart;
$groupid = isset($_SESSION['arwshop_mk']['user']['groupid']) ? $_SESSION['arwshop_mk']['user']['groupid'] : 0;
$discount_percents=preg_replace("([^0-9\x2E])", '', $cart->get_group_discount($groupid, $total_cost, $user_currency_info['currency_id']));
$discount=pricef($total_cost * $discount_percents / 100);
$total_cost_with_discount = pricef($total_cost - $discount);

$total_cost=pricef($total_cost);
$delivery_method_info = $this->get_delivery_method($_SESSION['arwshop_mk']['order']['dmid']);
$delivery_cost = $shop->calc_price($delivery_method_info['delivery_cost'], $user_currency_info['currency_id']);

 if($delivery_method_info['free_delivery_sum'] > 0 && $total_cost_with_discount >= $shop->calc_price($delivery_method_info['free_delivery_sum'], $user_currency_info['currency_id'])){
 $delivery_cost = pricef(0);
 }

$final_total = pricef($total_cost_with_discount + $delivery_cost);

 if($discount > 0){
 $template->condition('discount');
 }
 else{
 $template->not_condition('discount');
 }

 if($delivery_cost > 0){
 $template->condition('delivery_cost');
 }
 else{
 $template->not_condition('delivery_cost');
 }



$template->assign('pay_method', $paymethod_title);
$template->assign('currency_title', $user_currency_info['title']);
$template->assign('total_cost', $shop->format_price($total_cost));
$template->assign('discount_percents', $discount_percents);
$template->assign('discount', $shop->format_price($discount));
$template->assign('total_cost_with_discount', $shop->format_price($total_cost_with_discount));
$template->assign('delivery_method', $delivery_method_info['dmname']);
$template->assign('delivery_cost', $shop->format_price($delivery_cost));

$template->assign('currency_brief', $user_currency_info['brief']);
$template->assign('final_total', $shop->format_price($final_total));



return $template->out_content();
}


function deliverymethods_count(){
global $db;
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT COUNT(*) FROM $tbl WHERE enabled = '1'")or die($db->error());
return $db->result($res,0,0);
}


function paymethod_currencies_count($pmid){
global $db;
$pmid=intval($pmid);
if(! $pmid){return '';}
$tbl_paymethods_currencies=DB_PREFIX.'paymethods_currencies';
$tbl_currencies=DB_PREFIX.'currencies';
$res=$db->query("SELECT COUNT(*) FROM $tbl_paymethods_currencies, $tbl_currencies WHERE $tbl_paymethods_currencies.pmid = '$pmid' AND $tbl_currencies.currency_id = $tbl_paymethods_currencies.currency_id AND $tbl_currencies.enabled = 1") or die($db->error());
return $db->result($res,0,0);
}


function is_valid_wmid($wmid){
$wmid=preg_replace("([^0-9])", '', $wmid);
if(strlen($wmid) < 12){return false;}
return true;
}


function get_currency_info($currency_id){
global $currencies;
$currency_id=intval($currency_id);
return $currencies["$currency_id"];
}


function add_order(){
global $db, $lang, $sett, $custom, $order_info, $shop, $order_products, $mailer;

$err_msg = '';

 if(TDTC == 1){
 $tbl=DB_PREFIX.'orders';
 $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
  if($db->result($res,0,0) >= 50){
  return mdmogrn("$lang[351] 50 $lang[364]");
  }
 }

 if(! isset($_SESSION['arwshop_mk']['order'])){
 $_SESSION['arwshop_mk']['order'] = array();
 }

$order_info = $custom->trim_array($_SESSION['arwshop_mk']['order']);
$order_info['pay_method'] = intval($order_info['pay_method']);
$order_info['pmid'] = $order_info['pay_method'];

 if(! $this->is_available_pay_method($order_info['pay_method'])){
 $err_msg.="$lang[not_pay_method]<br>";
 }

$order_info['currency_id'] = intval($order_info['currency_id']);
 if(! $this->is_available_currency($order_info['pay_method'], $order_info['currency_id'])){
 $err_msg.="$lang[not_sel_currency]<br>";
 }

$order_info['dmid'] = intval($order_info['dmid']);
 if(! $this->is_available_delivery_method($order_info['dmid'])){
 $err_msg.="$lang[not_sel_delivery_method]<br>";
 }

 if($order_info['email']){
  if(! $mailer->valid_email($order_info['email'])){
  $err_msg.="$lang[invalid_email]<br>";
  }
 }


 if($err_msg){
 return $err_msg;
 }


$order_info['total']=0;
$order_info['total_pc']=0;
$total_products_quantity=0;

$limit_quantity=true;
 if($sett['cart_add_q0']){
 $limit_quantity=false;
 }

$order_products = $this->order_products_arr($_SESSION['arwshop_mk']['cart_products'], $order_info, $limit_quantity);

 if(sizeof($order_products) == 0){
 return msg::error($lang['empty_cart']);
 }

require_once(INC_DIR."/cart_c.php");
$cart = new cart;
$groupid = isset($_SESSION['arwshop_mk']['user']['groupid']) ? $_SESSION['arwshop_mk']['user']['groupid'] : 0;
$order_info['discount_percents'] = preg_replace("([^0-9\x2E])", '', $cart->get_group_discount($groupid, $order_info['total_pc'], $order_info['currency_id']));


 if($order_info['discount_percents'] > 0){
 $order_info['discount'] = pricef($order_info['total'] * $order_info['discount_percents'] / 100);
 $order_info['discount_pc'] = pricef($order_info['total_pc'] * $order_info['discount_percents'] / 100);
 $order_info['total_with_discount'] = pricef($order_info['total'] - $order_info['discount']);
 $order_info['total_with_discount_pc'] = pricef($order_info['total_pc'] - $order_info['discount_pc']);
 }
 else{
 $order_info['discount_percents'] = 0;
 $order_info['discount'] = 0;
 $order_info['discount_pc'] = 0;
 $order_info['total_with_discount'] = $order_info['total'];
 $order_info['total_with_discount_pc'] = $order_info['total_pc'];
 }

 if($order_info['free_delivery_sum'] > 0 && $order_info['total_with_discount'] >= $order_info['free_delivery_sum']){
 $order_info['delivery_cost'] = pricef(0);
 $order_info['delivery_cost_pc'] = pricef(0);
 }

$order_info['total']=pricef($order_info['total']);
$order_info['total_pc']=pricef($order_info['total_pc']);
$order_info['discount'] = pricef($order_info['discount']);
$order_info['discount_pc'] = pricef($order_info['discount_pc']);
$order_info['total_with_discount'] = pricef($order_info['total_with_discount']);
$order_info['total_with_discount_pc'] = pricef($order_info['total_with_discount_pc']);
$order_info['final_total'] = pricef($order_info['total_with_discount'] + $order_info['delivery_cost']);
$order_info['final_total_pc'] = pricef($order_info['total_with_discount_pc'] + $order_info['delivery_cost_pc']);



$order_info = $custom->replace_tags_and_quotes_array($order_info);

$order_info['def_currency_id']=intval($sett['def_currency']);
$order_info['def_currency']=$this->get_default_currency_title();
$order_info['def_currency_brief'] = $sett['curr_brief'];
$order_info['userid'] = isset($_SESSION['arwshop_mk']['user']['userid']) ? intval($_SESSION['arwshop_mk']['user']['userid']) : 0;
$order_info['username'] = isset($_SESSION['arwshop_mk']['user']['username']) ? $db->secstr($custom->del_notalphanum($_SESSION['arwshop_mk']['user']['username'])) : '';
$order_info['username'] = $db->secstr($order_info['username']);
$order_info['country_id']=intval($order_info['country']);
$order_info['country']=$this->get_country_title($order_info['country']);

if(strlen($order_info['total'])>16){return $lang['large_total'];}
if(strlen($order_info['final_total'])>16){return $lang['large_total'];}
$order_info['first_name'] = isset($order_info['first_name']) ? $db->secstr($order_info['first_name']) : '';
$order_info['first_name'] = $db->cutstr($order_info['first_name'], 255);
$order_info['last_name'] = isset($order_info['last_name']) ? $db->secstr($order_info['last_name']) : '';
$order_info['last_name'] = $db->cutstr($order_info['last_name'], 255);
$order_info['patronymic'] = isset($order_info['patronymic']) ? $db->secstr($order_info['patronymic']) : '';
$order_info['patronymic'] = $db->cutstr($order_info['patronymic'], 255);
$order_info['company'] = isset($order_info['company']) ? $db->secstr($order_info['company']) : '';
$order_info['company'] = $db->cutstr($order_info['company'], 255);
$order_info['country'] = $db->secstr($order_info['country']);
$order_info['country'] = $db->cutstr($order_info['country'], 255);
$order_info['city'] = isset($order_info['city']) ? $db->secstr($order_info['city']) : '';
$order_info['city'] = $db->cutstr($order_info['city'], 255);
$order_info['address'] = isset($order_info['address']) ? $db->secstr($order_info['address']) : '';
$order_info['address'] = $db->cutstr($order_info['address'], 65535, true);
$order_info['zip_code'] = isset($order_info['zip_code']) ? $db->secstr($order_info['zip_code']) : '';
$order_info['zip_code'] = $db->cutstr($order_info['zip_code'], 255);
$order_info['phone'] = isset($order_info['phone']) ? $db->secstr($order_info['phone']) : '';
$order_info['phone'] = $db->cutstr($order_info['phone'], 255);
$order_info['email'] = isset($order_info['email']) ? $db->secstr($order_info['email']) : '';
$order_info['email'] = $db->cutstr($order_info['email'], 255);
$order_info['comment'] = isset($order_info['comment']) ? $db->secstr($order_info['comment']) : '';
$order_info['comment'] = $db->cutstr($order_info['comment'], 65535, true);

$tbl = DB_PREFIX.'orders';
$order_info['date'] = intval(time());
$order_info = $db->secstr_array($order_info);




$db->query("INSERT INTO $tbl (orderid, date, status, pmid, paymethod_advname, paymethod, currency_id, currency, currency_brief, currency_course, def_currency_id, def_currency, def_currency_brief, total, total_pc, discount_percents, discount, discount_pc, total_with_discount, total_with_discount_pc, delivery_cost, delivery_cost_pc, final_total, final_total_pc, dmid, deliverymethod, userid, username, first_name, last_name, patronymic, company, country_id, country, city, address, zip_code, phone, email, comment, adm_pub_comment, admin_comment) VALUES(NULL, $order_info[date], 0, $order_info[pmid], '$order_info[paymethod_advname]', '$order_info[paymethod_title]', '$order_info[currency_id]', '$order_info[currency_title]', '$order_info[currency_brief]', '$order_info[currency_course]', '$order_info[def_currency_id]', '$order_info[def_currency]', '$order_info[def_currency_brief]', '$order_info[total]', '$order_info[total_pc]', '$order_info[discount_percents]', '$order_info[discount]', '$order_info[discount_pc]', '$order_info[total_with_discount]', '$order_info[total_with_discount_pc]', '$order_info[delivery_cost]', '$order_info[delivery_cost_pc]', '$order_info[final_total]', '$order_info[final_total_pc]', '$order_info[dmid]', '$order_info[delivery_method_title]', '$order_info[userid]', '$order_info[username]', '$order_info[first_name]', '$order_info[last_name]', '$order_info[patronymic]', '$order_info[company]', '$order_info[country_id]', '$order_info[country]', '$order_info[city]', '$order_info[address]', '$order_info[zip_code]', '$order_info[phone]', '$order_info[email]', '$order_info[comment]', '', '')") or die($db->error());

$order_info['order_id'] = $db->insert_id();
$order_info['orderid'] = $order_info['order_id'];

$tbl = DB_PREFIX.'orders_items';


 foreach($order_products as $product_id => $var_arr){

  foreach($var_arr as $variant => $prod){
  $prod = $db->secstr_array($custom->replace_tags_and_quotes_array($prod));

  $options = '';

   if(isset($prod['options']) && is_array($prod['options'])){
    if(sizeof($prod['options'])){
     foreach($prod['options'] as $option_id => $option_arr){

      if(is_array($option_arr)){
       if(sizeof($option_arr)){
        $options .= "$option_arr[option_name]: $option_arr[option_value]\x0A";
       }
      }

     }
    }
   }
   
   $options = $db->secstr($options);


  $db->query("INSERT INTO $tbl (oiid, orderid, itemid, sku, title, price, price_pc, quantity, options) VALUES(NULL, $order_info[orderid], $product_id, '$prod[sku]', '$prod[title]', '$prod[price]', '$prod[price_pc]', '$prod[quantity]', '$options')") or die($db->error());
  }

 }








 if($sett['pr_cnt_reduction']){$this->order_products_reduction($order_info['order_id']);}


return 1;
}




function is_available_pay_method($pmid){
global $db, $order_info;
$pmid=intval($pmid);
$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT pmid, pmtitle, advname FROM $tbl WHERE pmid = $pmid AND enabled = 1") or die($db->error());
$row=$db->fetch_array($res);
$order_info['paymethod_title']=$row['pmtitle'];
$order_info['paymethod_advname']=$row['advname'];
if($row['pmid']){return 1;}else{return 0;}
}


function is_available_currency($pmid, $currency_id){
global $db, $order_info;
$pmid=intval($pmid);
$currency_id=intval($currency_id);
$tbl=DB_PREFIX.'currencies';
$res=$db->query("SELECT currency_id, brief, title, course FROM $tbl WHERE currency_id = '$currency_id' AND enabled = '1'") or die($db->error());
$row=$db->fetch_array($res);
$order_info['currency_brief']=$row['brief'];
$order_info['currency_title']=$row['title'];
$order_info['currency_course']=$row['course'];
if(! $row['course']){return 0;}

$tbl=DB_PREFIX.'paymethods_currencies';
$res=$db->query("SELECT COUNT(*) FROM $tbl WHERE pmid = '$pmid' AND currency_id = '$currency_id'") or die($db->error());
if($db->result($res,0,0)>0){return 1;}else{return 0;}
}


function is_available_delivery_method($dmid){
global $db, $order_info, $shop;
$dmid=intval($dmid);
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT dmid, dmname, delivery_cost, free_delivery_sum FROM $tbl WHERE dmid = $dmid AND enabled = 1") or die($db->error());
$row=$db->fetch_array($res);
$order_info['delivery_method_title'] = $row['dmname'];
$order_info['delivery_cost'] = $row['delivery_cost'];
$order_info['delivery_cost_pc'] = $shop->calc_price($row['delivery_cost'], $order_info['currency_id']);
$order_info['free_delivery_sum'] = $row['free_delivery_sum'];
$order_info['free_delivery_sum_pc'] = $shop->calc_price($row['free_delivery_sum'], $order_info['currency_id']);
if($row['dmname']){return 1;}else{return 0;}
}


function get_delivery_method($dmid){
global $db;
$dmid=intval($dmid);
$tbl=DB_PREFIX.'deliverymethods';
$res=$db->query("SELECT * FROM $tbl WHERE dmid = $dmid AND enabled = 1") or die($db->error());
return $db->fetch_array($res);
}


function get_default_currency_title(){
global $db, $sett;
$tbl=DB_PREFIX.'currencies';
$res=$db->query("SELECT title FROM $tbl WHERE currency_id = '$sett[def_currency]'") or die($db->error());
return @$db->result($res,0,'title');
}


function get_country_title($country_id){
global $db;
$country_id=intval($country_id);
if(! $country_id){return '';}
$tbl=DB_PREFIX.'countries';
$res=$db->query("SELECT country_name FROM $tbl WHERE country_id = '$country_id'") or die($db->error());
return @$db->result($res,0,'country_name');
}


function mail_order_info(){
global $order_info, $order_products, $lang, $sett, $shop;
$mailtext = "$lang[order_number]: $order_info[order_id]\n";
$mailtext .= "$lang[order_date]: " . date("d.m.Y H:i:s", $order_info['date'] + $sett['time_diff'] * 3600) . "\n";

 if($order_info['paymethod_title']){
 $mailtext.="$lang[pay_method]: $order_info[paymethod_title]\n";
 }

 if(! empty($order_info['paymethod_advname'])){
 $mailtext .= $lang['payment_link'] . ': ' . $this->get_payment_link($order_info) . "\n";
 }

$mailtext .= $this->pmblanks_maillinks($order_info);

 if($order_info['delivery_method_title']){
 $mailtext.="$lang[delivery_method]: $order_info[delivery_method_title]\n";
 }

 if(! empty($order_info['comment'])){
 $mailtext.="$lang[comment]:\n$order_info[comment]\n";
 }

$mailtext.="\n";

$cost=0;
$total_cost=0;
$total_products_quantity=0;

$mailtext.="$lang[ordered_products]:\n\n";

 foreach($order_products as $product_id => $var_arr){

  foreach($var_arr as $variant => $prod){
  $mailtext.="ID: $product_id\n";

  if($prod['sku']){
  $mailtext.="$lang[sku]: $prod[sku]\n";
  }

  if($prod['title']){
  $mailtext.="$lang[product_name]: $prod[title]\n";
  }

 $fcatname = $shop->categories["$prod[catid]"]['fcat'];
 $mailtext .= $this->site_root_url_without_slash() . @stdi2("product=$product_id", custom::statlink($fcatname, "$prod[itemname].html", "product$product_id.html", 'p')) ."\n";

  if(isset($prod['options']) && is_array($prod['options'])){
   if(sizeof($prod['options'])){
    foreach($prod['options'] as $option_arr){
    $mailtext.="$option_arr[option_name]: $option_arr[option_value]\n";
    }
   }
  }

  $mailtext.="$lang[price]: ".$shop->format_price($prod['price_pc'])." $order_info[currency_brief]\n";

  $mailtext.="$lang[quantity]: $prod[quantity]\n";

   if($prod['quantity']>0){
   $cost = pricef($prod['price'] * $prod['quantity']);
   $cost_pc = pricef($prod['price_pc'] * $prod['quantity']);
   }

  $mailtext.="$lang[cost]: ".$shop->format_price($cost_pc)." $order_info[currency_brief]\n----------------------------------\n\n";

  }

 }

$mailtext.="$lang[selected_currency]: $order_info[currency_title] ($order_info[currency_brief])\n";

$mailtext.="$lang[total_cost]: ".$shop->format_price($order_info['total_pc'])." $order_info[currency_brief]\n";

 if($order_info['discount'] > 0){
 $mailtext.="$lang[discount]: $order_info[discount_percents] % (".$shop->format_price($order_info['discount_pc'])." $order_info[currency_brief])\n";
 $mailtext.="$lang[total_with_discount]: ".$shop->format_price($order_info['total_with_discount_pc'])." $order_info[currency_brief]\n";
 }

 if($order_info['delivery_cost'] > 0){
 $mailtext.="$lang[delivery_cost]: ".$shop->format_price($order_info['delivery_cost_pc'])." $order_info[currency_brief]\n";
 }



$mailtext.="$lang[final_total]: ".$shop->format_price($order_info['final_total_pc'])." $order_info[currency_brief]\n";

$mailtext.="\n";


$mailtext.="$lang[shopper_info]:\n";

 if($order_info['username']){
 $mailtext.="$lang[user_name]: $order_info[username]\n";
 }

 if($order_info['first_name']){
 $mailtext.="$lang[first_name]: $order_info[first_name]\n";
 }

 if($order_info['last_name']){
 $mailtext.="$lang[last_name]: $order_info[last_name]\n";
 }

 if($order_info['patronymic']){
 $mailtext.="$lang[patronymic]: $order_info[patronymic]\n";
 }

 if($order_info['company']){
 $mailtext.="$lang[company]: $order_info[company]\n";
 }

 if($order_info['country']){
 $mailtext.="$lang[country]: $order_info[country]\n";
 }

 if($order_info['city']){
 $mailtext.="$lang[city]: $order_info[city]\n";
 }

 if($order_info['address']){
 $mailtext.="$lang[address]: $order_info[address]\n";
 }

 if($order_info['zip_code']){
 $mailtext.="$lang[zip_code]: $order_info[zip_code]\n";
 }

 if($order_info['phone']){
 $mailtext.="$lang[phone]: $order_info[phone]\n";
 }

 if($order_info['email']){
 $mailtext.="$lang[email]: $order_info[email]\n";
 }

return $mailtext;
}




function order_products_reduction($orderid, $plus=0){
global $db, $sett;
$orderid = intval($orderid);
$tbl = DB_PREFIX.'orders_items';
$res = $db->query("SELECT `itemid`, `quantity` FROM `$tbl` WHERE `orderid` = '$orderid'") or die($db->error());
$order_products = array();

 while($row=$db->fetch_array($res)){
 array_push($order_products, $row);
 }

 if(sizeof($order_products)){
 $tbl = DB_PREFIX.'items';

  foreach($order_products as $arr){
  $res=$db->query("SELECT `itemid`, `quantity` FROM `$tbl` WHERE `itemid` = '$arr[itemid]'") or die($db->error());
  $row = $db->fetch_array($res);
   if($row['itemid'] && $row['quantity'] < 4294967295){

    if(! $plus){
    $quantity = $row['quantity'] - $arr['quantity'];
     if($quantity < 0){
     $quantity = 0;
     }
    }
    else{
    $quantity = $row['quantity'] + $arr['quantity'];
     if($quantity > 4294967295){
     $quantity = 4294967295;
     }
    }

   $db->query("UPDATE `$tbl` SET `quantity` = '$quantity' WHERE `itemid` = '$row[itemid]'") or die($db->error());
   }
  }

 }
return 1;
}


function pmblanks_maillinks($order_info){
global $db, $lang, $sett;
$pmid=intval($order_info['pmid']);
$tbl=DB_PREFIX.'payment_blanks';
$ret = '';
$res=$db->query("SELECT blank_id, blank_title FROM $tbl WHERE paymethod_id = $pmid")or die($db->error());
 while($row=$db->fetch_array($res)){
 $ret.="$lang[view_payment_blank] ($row[blank_title]) " . $this->get_pmblank_url($row['blank_id'], $order_info, 1) . "\n";
 }
return $ret;
}


function get_pmblank_url($blank_id, $order_dt, $use_absolute_url){
global $sett;
 if($use_absolute_url){
 $url  = $sett['url'];
 }
 else{
 $url  = $sett['relative_url'];
 }
return $url . "pages.php?view=payment_blank&orderid=$order_dt[orderid]&pmid=$order_dt[pmid]&blank_id=$blank_id&osk=" . $this->get_osk($order_dt) . '&independ=1';
}


function get_payment_link($order_dt){
global $sett;
return "$sett[url]pages.php?view=pay_order&orderid=$order_dt[orderid]&osk=" . $this->get_osk($order_dt);
}


function get_osk($order_dt){
return  md5('Conversion' . $order_dt['orderid'] . $order_dt['date'] . $order_dt['userid'] . $order_dt['username'] . $order_dt['email']);
}


function get_osk_old1($order_dt){
return  md5('Conversion' . $order_dt['orderid'] . $order_dt['date'] . $order_dt['currency_id'] . $order_dt['final_total'] . $order_dt['email'] . $order_dt['first_name']);
}


function payment_blanks_links($order_dt, &$template){
global $db;
$order_dt['pmid'] = intval($order_dt['pmid']);
$tbl=DB_PREFIX.'payment_blanks';
$cnt = 0;
$template->get_cycle('payment_blanks');
$res=$db->query("SELECT blank_id, blank_title FROM $tbl WHERE paymethod_id = $order_dt[pmid] AND paymethod_id <> 0")or die($db->error());
 while($row=$db->fetch_array($res)){
 $template->assign_cycle('blank_id', $row['blank_id']);
 $template->assign_cycle('blank_title', $row['blank_title']);
 $template->assign_cycle('blank_url', $this->get_pmblank_url($row['blank_id'], $order_dt, 0));
 $template->next_loop();
 $cnt++;
 }

$template->out_cycle();

 if($cnt){
 $template->condition('payment_blank');
 }
 else{
 $template->not_condition('payment_blank');
 }
}


function order_products_arr($cart_products, &$order_info, $limit_quantity){
global $db, $shop;
$tbl_items=DB_PREFIX.'items';
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_match=DB_PREFIX.'item_options_match';
$order_products=array();
$options=$shop->get_product_options();
$total_products_quantity = 0;

 foreach($cart_products as $product_id => $var_arr){
 
 

 $product_id = intval($product_id);

  foreach($var_arr as $variant => $prod){
  $order_products["$product_id"]["$variant"] = array('itemname' => '', 'catid' => 0, 'sku' => '', 'title' => '', 'price' => 0, 'price_pc' => 0, 'quantity' => 0);

  $res = $db->query("SELECT `itemname`, `catid`, `sku`, `title`, `price`, `quantity` FROM `$tbl_items` WHERE `itemid` = $product_id")or die($db->error());
  $row = $db->fetch_array($res);
  $prod['quantity'] = intval($prod['quantity']);
  $row['price_pc'] = $shop->calc_price($row['price'], $order_info['currency_id']);




   $options_str = '';

    if(is_array($cart_products["$product_id"]["$variant"]["options"])){

     if(sizeof($cart_products["$product_id"]["$variant"]["options"])){

     $options_id = '';
     $values_id = '';
      foreach($cart_products["$product_id"]["$variant"]["options"] as $name => $value){
      $name = intval($name);
      $value = intval($value);
      $options_id .= ", $name";
      $values_id .= ", $value";
      }
     if(substr($options_id, 0, 2) === ', '){$options_id = substr($options_id, 2);}
     if(substr($values_id, 0, 2) === ', '){$values_id = substr($values_id, 2);}

     $order_products["$product_id"]["$variant"]["options"] = array();

     $res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference FROM $tbl_options, $tbl_options_match WHERE $tbl_options_match.itemid = $product_id AND $tbl_options_match.option_id IN ($options_id) AND $tbl_options_match.option_value_id IN ($values_id) AND $tbl_options.option_id = $tbl_options_match.option_id ORDER BY $tbl_options.sortid, $tbl_options.option_name")or die($db->error());

      while($row2 = $db->fetch_array($res2)){
      $row2['price_difference_pc'] = $shop->calc_price($row2['price_difference'], $order_info['currency_id']);
      $row['price'] += $row2['price_difference'];
      $row['price_pc'] += $row2['price_difference_pc'];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"] = array();
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["option_name"] = $options["$row2[option_id]"]["option_name"];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["option_value"] = $options["$row2[option_id]"]["$row2[option_value_id]"];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["price_difference"] = $row2["price_difference"];
      $order_products["$product_id"]["$variant"]["options"]["$row2[option_value_id]"]["price_difference_pc"] = $row2["price_difference_pc"];
      }


     }

    }




    if($limit_quantity){
     if($prod['quantity'] > $row['quantity']){
     $prod['quantity'] =  $row['quantity'];
     }
    }

    if($prod['quantity']> 0){
    $cost = pricef($row['price'] * $prod['quantity']);
    $cost_pc = pricef($row['price_pc'] * $prod['quantity']);
    $order_info['total'] += $cost;
    $order_info['total_pc'] += $cost_pc;

    $order_products["$product_id"]["$variant"]['itemname'] = $row['itemname'];
    $order_products["$product_id"]["$variant"]['catid'] = $row['catid'];
    $order_products["$product_id"]["$variant"]['sku'] = $row['sku'];
    $order_products["$product_id"]["$variant"]['title'] = $row['title'];
    $order_products["$product_id"]["$variant"]['price'] = $row['price'];
    $order_products["$product_id"]["$variant"]['price_pc'] = $row['price_pc'];
    $order_products["$product_id"]["$variant"]['quantity'] = $prod['quantity'];

    $total_products_quantity++;
    }
    else{
    unset($order_products["$product_id"]["$variant"]);
    continue;
    }


  }
  
  if(sizeof($order_products["$product_id"]) == 0){
  unset($order_products["$product_id"]);
  }

 }

return $order_products;
}


private function hostname_from_url($url){
$domain = strtolower(trim($url));
$domain = str_replace("\\", '/', $domain);
$pos = strpos($domain, '://');
 if($pos !== false){
 $domain = substr($domain, $pos + 3);
 }
$pos = strpos($domain, '/');
 if($pos !== false){
 $domain = substr($domain, 0, $pos);
 }
 if(substr($domain, strlen($domain) - 1) == '.'){
 $domain = substr($domain, 0, strlen($domain) - 1);
 }
return $domain;
}


private function site_root_url_without_slash(){
global $sett; 
 if(substr($sett['url'], 0, 5) == 'https'){
 $protocol = 'https';
 }
 else{
 $protocol = 'http';
 }
return $protocol . '://' . $this->hostname_from_url($sett['url']);
}



}
?>