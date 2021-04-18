<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $currencies;

echo $shop->check_cookie();
$custom->get_lang('cart');
require_once(INC_DIR."/cart_c.php");
$cart = new cart;

 if(isset($_POST['act']) && $_POST['act'] == 'recalculate'){
 $cart->recalculate();
 }

$template = new template('order_step1.tpl');

$cart_info = $cart->get_cart();

 if(empty($err_msg)){
 $template->assign('cart_info', $cart_info);
 $template->assign('error_message', '');
 }
 else{
 $template->assign('error_message', msg::error($err_msg));
 $template->assign('cart_info', '');
 }

$groupid = isset($_SESSION['arwshop_mk']['user']['groupid']) ? intval($_SESSION['arwshop_mk']['user']['groupid']) : 0;
$min_order_sum = get_min_order_sum($groupid);
$currency_id = def_show_curr_id();
$totalwithdiscount_def_curr = pricef($cart->totalwithdiscount * $currencies["$currency_id"]["course"]);

 if($totalwithdiscount_def_curr < $min_order_sum){
 echo "$lang[small_order_sum] " . $shop->format_price(pricef($min_order_sum / $currencies["$currency_id"]["course"])) . " $sett[show_curr_brief]. $lang[select_else_products]";
 }
 else{

    if(empty($_SESSION['arwshop_mk']['user']['username'])){
    $template->condition('not_authorized');
    $template->assign('last_page', urlencode("$sett[relative_url]pages.php?view=order"));
     if($sett['order_without_register']){
     $template->assign('register_not_mandatory_message', $lang['register_not_mandatory']);
     }
     else{
     $template->assign('register_not_mandatory_message', '');
     }
    }
    else{
    $template->not_condition('not_authorized');
    }



    if(! empty($_SESSION['arwshop_mk']['user']['userid']) || $sett['order_without_register']){
    $template->condition('authorized_or_order_without_register');
    global $db;




    $tbl=DB_PREFIX.'paymethods';
    $res=$db->query("SELECT pmid, pmtitle, short_descript FROM $tbl WHERE enabled = 1 ORDER BY sortid, pmtitle")or die($db->error());
    $num_rows=$db->num_rows($res);

    $def_class='ttr';

    $template->get_cycle('pay_methods');

     while($row=$db->fetch_array($res)){

     if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}
     $checked = '';

     $template->assign_cycle('def_class', $def_class);
     $template->assign_cycle('def_pmid', $row['pmid']);
     $template->assign_cycle('checked', $checked);
     $template->assign_cycle('paymethod_url', @stdi2("view=pay_methods&pm=$row[pmid]", "pay_methods/pm$row[pmid].html"));
     $template->assign_cycle('paymethod_title', $row['pmtitle']);
     $template->assign_cycle('short_descript', $row['short_descript']);
     $template->next_loop();
     }

    $template->out_cycle();

    }
    else{
    $template->not_condition('authorized_or_order_without_register');
    }


 echo $template->out_content();
 }

unset($template);



function get_min_order_sum($groupid){
global $db;
$groupid = intval($groupid);
 if(! $groupid){
 $groupid = 1;
 }
$tbl_users_groups=DB_PREFIX.'users_groups';
$res = $db->query("SELECT min_order_sum FROM $tbl_users_groups WHERE groupid = $groupid") or die($db->error());
$row = $db->fetch_array($res);
return $row['min_order_sum'];
}




?>