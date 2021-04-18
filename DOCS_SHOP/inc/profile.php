<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class profile{

function get_profile($userid){
global $db;
$userid=intval($userid);
if(! $userid){return '';}
$tbl=DB_PREFIX.'users';
$res = $db->query("SELECT * FROM $tbl WHERE userid = $userid") or die($db->error());
return $db->fetch_array($res);
}


function get_orderfields(){
global $db;
$tbl=DB_PREFIX.'orderfields';
$res=$db->query("SELECT * FROM $tbl WHERE enabled = 1 ORDER BY sortid")or die($db->error());
$ret=array();
 while($row=$db->fetch_array($res)){
 $ret["$row[name]"]=$row;
 }
return $ret;
}


function check_profile_form($user_info, $err_msg, $mk_global_fields=0, $check_email_exist=0){
global $custom, $lang, $register;
if($mk_global_fields){global $fields;}

if($err_msg){$err_msg.="<hr>";}

$userid = isset($_SESSION['arwshop_mk']['user']['userid']) ? intval($_SESSION['arwshop_mk']['user']['userid']) : 0;

$fields=$this->get_orderfields();



 foreach($fields as $fname => $field_arr){

  if($fname=='email'){
   if($fields['email']['required'] || $user_info['email']){
   require_once(INC_DIR."/mailer.php");
   $mailer=new mailer;
    if(! $mailer->valid_email($user_info['email'])){
    $err_msg.="$lang[invalid_email]<br>";
    }
    else{
     if($check_email_exist && $register->email_exist($user_info['email'], $userid)){
     $err_msg.="$lang[user_with_email] \"<b>$_POST[email]</b>\" $lang[already_exist_soe]<br>";
     }
    }
   }
  }

  if($fname=='first_name'){
   if($fields['first_name']['required']){
   if($user_info['first_name']==''){$err_msg.="$lang[not_first_name]<br>";}
   }
  }

  if($fname=='last_name'){
   if($fields['last_name']['required']){
   if($user_info['last_name']==''){$err_msg.="$lang[not_last_name]<br>";}
   }
  }

  if($fname=='patronymic'){
   if($fields['patronymic']['required']){
   if($user_info['patronymic']==''){$err_msg.="$lang[not_patronymic]<br>";}
   }
  }

  if($fname=='company'){
   if($fields['company']['required']){
   if($user_info['company']==''){$err_msg.="$lang[not_company]<br>";}
   }
  }

  if($fname=='country'){
  $user_info['country']=intval($user_info['country']);
   if($fields['country']['required']){
   if(! $user_info['country'] || $user_info['country'] == '-1'){$err_msg.="$lang[not_country]<br>";}
   }
  }

  if($fname=='city'){
   if($fields['city']['required']){
   if($user_info['city']==''){$err_msg.="$lang[not_city]<br>";}
   }
  }

  if($fname=='address'){
   if($fields['address']['required']){
   if($user_info['address']==''){$err_msg.="$lang[not_address]<br>";}
   }
  }

  if($fname=='zip_code'){
   if($fields['zip_code']['required']){
   if($user_info['zip_code']==''){$err_msg.="$lang[not_zip_code]<br>";}
   }
  }

  if($fname=='phone'){
   if($fields['phone']['required']){
   if($user_info['phone']==''){$err_msg.="$lang[not_phone]<br>";}
   }
  }


 }



return $err_msg;
}



function update_profile($userid){
global $db;
$userid=intval($userid);
if(! $userid){return '';}

$_POST = custom::replace_tags_and_quotes_array($_POST);

 if(! isset($_POST['username'])){
 $_POST['username'] = '';
 }

$_POST['username'] = $db->secstr($_POST['username']);
$_POST['username']=$db->cutstr($_POST['username'], 255);
$_POST['email'] = $db->secstr($_POST['email']);
$_POST['email']=$db->cutstr($_POST['email'], 255);
$_POST['first_name'] = $db->secstr($_POST['first_name']);
$_POST['first_name']=$db->cutstr($_POST['first_name'], 255);
$_POST['last_name'] = $db->secstr($_POST['last_name']);
$_POST['last_name']=$db->cutstr($_POST['last_name'], 255);
$_POST['patronymic'] = $db->secstr($_POST['patronymic']);
$_POST['patronymic']=$db->cutstr($_POST['patronymic'], 255);
$_POST['company'] = $db->secstr($_POST['company']);
$_POST['company']=$db->cutstr($_POST['company'], 255);
$_POST['country']=intval($_POST['country']);
 if($_POST['country'] < 0){
 $_POST['country']=0;
 }
$_POST['city'] = $db->secstr($_POST['city']);
$_POST['city']=$db->cutstr($_POST['city'], 255);
$_POST['address'] = $db->secstr($_POST['address']);
$_POST['address']=$db->cutstr($_POST['address'], 65535, true);
$_POST['zip_code'] = $db->secstr($_POST['zip_code']);
$_POST['zip_code']=$db->cutstr($_POST['zip_code'], 255);
$_POST['phone'] = $db->secstr($_POST['phone']);
$_POST['phone']=$db->cutstr($_POST['phone'], 255);

$tbl=DB_PREFIX.'users';
$query = "UPDATE $tbl SET ";

if($_POST['password1']){$query .= "pwd = '" . md5($_POST['password1'] . 'Shopper User Password') . "', ";}

$data = $db->secstr_array($_POST);

$query .= "email = '$data[email]', first_name = '$data[first_name]', last_name = '$data[last_name]', patronymic = '$data[patronymic]', company = '$data[company]', country = '$data[country]', city = '$data[city]', address = '$data[address]', zip_code = '$data[zip_code]', phone = '$data[phone]' WHERE userid = '$userid'";

$db->query($query) or die($db->error());
return '1';
}



function get_user_group_info($userid){
global $db, $lang;
$userid=intval($userid);
if(! $userid){return '';}

$tbl_users=DB_PREFIX.'users';
$tbl_users_groups=DB_PREFIX.'users_groups';

$res=$db->query("SELECT $tbl_users.groupid, $tbl_users_groups.groupname, $tbl_users_groups.descript FROM $tbl_users, $tbl_users_groups WHERE $tbl_users.userid = '$userid' AND $tbl_users_groups.groupid = $tbl_users.groupid") or die($db->error());

return $db->fetch_array($res);
}


function get_profile_block($fields, $user_info){
global $sett, $lang, $register;

 foreach($fields as $field){
  if(! isset($user_info["$field[name]"])){
  $user_info["$field[name]"] = '';
  }
 }

$template = new template('profile_fields.tpl');

$template->get_cycle('profile_fields');

$asterisk = '<span class="red">*</span>';
$text_size = 40;

$def_class='ttr';




 foreach($fields as $fname => $field_arr){

  if($fname=='email'){
   if($fields['email']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['email']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['email'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"email\" size=\"$text_size\" maxlength=\"128\" value=\"$user_info[email]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='first_name'){
   if($fields['first_name']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['first_name']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['first_name'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"first_name\" size=\"$text_size\" maxlength=\"128\" value=\"$user_info[first_name]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='last_name'){
   if($fields['last_name']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['last_name']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['last_name'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"last_name\" size=\"$text_size\" maxlength=\"128\" value=\"$user_info[last_name]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='patronymic'){
   if($fields['patronymic']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['patronymic']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['patronymic'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"patronymic\" size=\"$text_size\" maxlength=\"128\" value=\"$user_info[patronymic]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='company'){
   if($fields['company']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['company']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['company'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"company\" size=\"$text_size\" maxlength=\"64\" value=\"$user_info[company]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='country'){
   $user_info['country']=intval($user_info['country']);
    if(! $user_info['country']){
    $user_info['country']=$sett['def_country'];
    }

   if($fields['country']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['country']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['country'] . $contexthelp);
   $template->assign_cycle('field', "<select name=\"country\"><option value=\"-1\">$lang[not_selected]</option>" . $register->get_countries_list($user_info['country']) . "</select>");
   $template->next_loop();
   }
  }

  if($fname=='city'){
   if($fields['city']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['city']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['city'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"city\" size=\"$text_size\" maxlength=\"128\" value=\"$user_info[city]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='address'){
   if($fields['address']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['address']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['address'] . $contexthelp);
   $template->assign_cycle('field', "<textarea name=\"address\" cols=\"30\" rows=\"5\" placeholder=\"$field_arr[placeholder]\">$user_info[address]</textarea>");
   $template->next_loop();
   }
  }

  if($fname=='zip_code'){
   if($fields['zip_code']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['zip_code']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['zip_code'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"zip_code\" size=\"$text_size\" maxlength=\"64\" value=\"$user_info[zip_code]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }

  if($fname=='phone'){
   if($fields['phone']['enabled']){
   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
   if($fields['phone']['required']){$f_required=$asterisk;}else{$f_required='';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('required', $f_required);
   $contexthelp = '';
    if($field_arr['contexthelp']){
    $contexthelp = ' ' . custom::contextHelp($field_arr['contexthelp']);
    }
   $template->assign_cycle('field_description', $lang['phone'] . $contexthelp);
   $template->assign_cycle('field', "<input type=\"text\" name=\"phone\" size=\"$text_size\" maxlength=\"64\" value=\"$user_info[phone]\" placeholder=\"$field_arr[placeholder]\">");
   $template->next_loop();
   }
  }



 }




$template->out_cycle();

return $template->out_content();
}


function get_all_orders($userid){
global $db, $sett, $lang, $shop;
$userid=intval($userid);
if(! $userid){return '';}

$template = new template('user_orders.tpl');
$template->get_cycle('orders');

$statuses = $this->get_order_statuses();

$tbl = DB_PREFIX.'orders';
$res = $db->query("SELECT orderid, date, status, currency_brief, def_currency_brief, final_total, final_total_pc FROM $tbl WHERE userid = $userid ORDER BY orderid DESC") or die($db->error());
 
$count_orders = 0 ;
$def_class = 'ttr';

 while($row = $db->fetch_array($res)){
 if($def_class === 'str'){$def_class = 'ttr';}else{$def_class = 'str';}
 $template->assign_cycle('order_number', $row['orderid']);
 $template->assign_cycle('order_date', date("d.m.Y H:i", $row['date'] + $sett['time_diff'] * 3600));
 $template->assign_cycle('sum', $shop->format_price($row['final_total_pc']));
 $template->assign_cycle('currency_brief', $row['currency_brief']);
 $template->assign_cycle('def_currency_brief', $row['def_currency_brief']);
 $template->assign_cycle('order_status', $statuses["$row[status]"]["name"]);
 $template->assign_cycle('def_class', $def_class);
 $template->next_loop();
 $count_orders ++ ;
 }

$template->out_cycle();

 if(! $count_orders){
 return "<h3>$lang[orders_not_found]</h3>";
 }

return $template->out_content();
}


function get_order_detail($orderid, $userid){
global $db, $template, $sett, $shop, $custom, $lang;
$tbl_items=DB_PREFIX.'items';
$orderid=intval($orderid);
$userid=intval($userid);
if(! $orderid || ! $userid){return false;}
if(! $this->is_user_order($orderid, $userid)){return '';}

$template = new template('order_detail.tpl');
$template->get_cycle('products');

require_once(INC_DIR."/admin/orders.php");
$orders = new orders;
$order_info = $orders->get_order_info($orderid);
$order_items = $orders->get_order_items($orderid);

$def_class='ttr';

 if(is_array($order_items)){
  if(count($order_items)){
   foreach($order_items as $row){
   $res=$db->query("SELECT `itemname`, `catid` FROM $tbl_items WHERE `itemid` = $row[itemid]") or die($db->error());
   $item_data=$db->fetch_array($res);
   $item_data['fcatname'] = isset($shop->categories[$item_data['catid']]['fcat']) ? $shop->categories[$item_data['catid']]['fcat'] : '';
   if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}
   $template->assign_cycle('def_class', $def_class);
   $template->assign_cycle('product_title', $row['title']);

    if($row['options']){
    $row['options'] = $custom->rn_to_n($row['options']);
    $row['options'] = str_replace("\n", '<br>', $row['options']);
    }

   $template->assign_cycle('product_options', $row['options']);

    if($item_data['fcatname'] && $item_data['itemname']){
    $template->assign_cycle('product_url', @stdi2("product=$row[itemid]", $custom->statlink($item_data['fcatname'], "$item_data[itemname].html", "product$row[itemid].html", 'p')));
    }
    else{
    $template->assign_cycle('product_url', "javascript:alert('$lang[product_not_found]');");
    }
   
   $template->assign_cycle('product_sku', $row['sku']);
   $template->assign_cycle('product_price', $shop->format_price($row['price_pc']));
   $template->assign_cycle('product_quantity', $row['quantity']);
   $template->assign_cycle('product_cost', $shop->format_price($row['price_pc'] * $row['quantity']));
   $template->next_loop();
   }
  }
 }

$template->out_cycle();

$template->assign('order_number', $order_info['orderid']);
$template->assign('order_date', date("d.m.Y H:i:s", $order_info['date'] + $sett['time_diff'] * 3600));
$template->assign('order_status', $orders->statuses["$order_info[status]"]["name"]);
$template->assign('pay_method', $order_info['paymethod']);
$template->assign('delivery_method', $order_info['deliverymethod']);
$template->assign('order_comment', $order_info['comment']);
$template->assign('def_currency_brief', '');
$template->assign('total', $shop->format_price($order_info['total_pc']));
$template->assign('discount_percents', $order_info['discount_percents']);
$template->assign('discount', $shop->format_price($order_info['discount_pc']));
$template->assign('currency', $order_info['currency']);
$template->assign('currency_brief', $order_info['currency_brief']);
$template->assign('currency_course', $order_info['currency_course']);
$template->assign('total_with_discount', $shop->format_price($order_info['total_with_discount_pc']));
$template->assign('def_currency_course', 1 / $order_info['currency_course']
);
$template->assign('final_total', $shop->format_price($order_info['final_total_pc']));
$template->assign('username', $order_info['username']);
$template->assign('first_name', $order_info['first_name']);
$template->assign('last_name', $order_info['last_name']);
$template->assign('patronymic', $order_info['patronymic']);
$template->assign('company', $order_info['company']);
$template->assign('country', $order_info['country']);
$template->assign('city', $order_info['city']);
$template->assign('address', $order_info['address']);
$template->assign('zip_code', $order_info['zip_code']);
$template->assign('phone', $order_info['phone']);
$template->assign('email', $order_info['email']);
$template->assign('delivery_cost', $shop->format_price($order_info['delivery_cost_pc']));
$template->assign('total_with_delivery', $shop->format_price($order_info['final_total_pc']));

 if($order_info['discount_pc'] > 0){
 $template->condition('discount');
 }
 else{
 $template->not_condition('discount');
 }

 if($order_info['delivery_cost_pc'] > 0){
 $template->condition('delivery_cost');
 }
 else{
 $template->not_condition('delivery_cost');
 }

 if($order_info['currency'] !== $order_info['def_currency'] || $order_info['currency_brief'] !== $order_info['def_currency_brief'] || $order_info['currency_course'] != 1){
 $template->condition('not_def_currency');
 }
 else{
 $template->not_condition('not_def_currency');
 }

 if($order_info['adm_pub_comment']){
 $template->condition('admin_comment');
 }
 else{
 $template->not_condition('admin_comment');
 }

$template->assign('admin_comment', $order_info['adm_pub_comment']);

require_once(INC_DIR."/shop_order.php");
$shop_order=new shop_order;

$shop_order->payment_blanks_links($order_info, $template);

 if(! empty($order_info['paymethod_advname']) && $order_info['status'] != intval($sett['paid_order_status'])){
 $template->assign('payment_link', str_replace('&', '&amp;', $shop_order->get_payment_link($order_info)));
 $template->condition('payment_link');
 }
 else{
 $template->assign('payment_link', '');
 $template->not_condition('payment_link');
 }

$paymethod_specialinfo = $shop_order->get_paymethod_specialinfo($order_info['pmid']);
$template->assign('adv_descript', $paymethod_specialinfo['adv_descript']);
 if($paymethod_specialinfo['adv_descript']){
 $template->condition('adv_descript');
 }
 else{
 $template->not_condition('adv_descript');
 }

return $template->out_content();
}


function get_order_statuses(){
global $custom, $lang, $db;
$custom->get_lang("admin_lang/orders");
$statuses = array();
$statuses[0]['name'] = $lang['status0'];
$statuses[0]['auto_change_group'] = 0;

$tbl=DB_PREFIX.'order_statuses';
$res = $db->query("SELECT * FROM $tbl ORDER BY sortid, name, status_id") or die($db->error());

 while($row = $db->fetch_array($res)){
 $statuses["$row[status_id]"]['name'] = $row['name'];
 $statuses["$row[status_id]"]['auto_change_group'] = $row['auto_change_group'];
 }

return $statuses;
}


function is_user_order($orderid, $userid){
global $db;
$orderid=intval($orderid);
$userid=intval($userid);
if(! $orderid || ! $userid){return false;}
$tbl = DB_PREFIX.'orders';
$res = $db->query("SELECT userid FROM $tbl WHERE orderid = $orderid") or die($db->error());
$row = $db->fetch_array($res);
if($row['userid'] != $userid){return false;}
return true;
}


function is_valid_password($userid, $username, $checking_password){
global $db, $custom;
$tbl=DB_PREFIX.'users';
$userid=intval($userid);
 if(! $userid){
 return false;
 }
$username = $custom->del_notalphanum(trim($username));
 if(! $username){
 return false;
 }
$checking_password=trim($checking_password);
 if(! $checking_password){
 return false;
 }
$checking_password = md5($checking_password . 'Shopper User Password');
$res = $db->query("SELECT userid, username, pwd FROM $tbl WHERE userid = $userid AND username = '$username' AND pwd = '$checking_password'") or die($db->error());
$row=$db->fetch_array($res);
 if($checking_password === $row['pwd']){
 return true;
 }
return false;
}


function get_min_max_group_discounts($groupid){
global $db;
$groupid=intval($groupid);
$tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';

$min_discount = 0;
$max_discount = 0;

$res=$db->query("SELECT discount FROM $tbl_users_groups_discounts WHERE groupid = $groupid") or die($db->error());
 while($row=$db->fetch_array($res)){
 
  if($min_discount == 0){
  $min_discount = $row['discount'];
  }
  
  if($row['discount'] > $max_discount){
  $max_discount = $row['discount'];
  }
  elseif($row['discount'] < $min_discount){
  $min_discount = $row['discount'];
  }
  
 }

return array($min_discount, $max_discount);
}


}
?>