<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('pay_order');

echo '<h2>'.$lang['pay_order'];
 if(isset($_GET['orderid']) && $_GET['orderid'] > 0){
 echo " &#8470; $_GET[orderid]";
 }
echo '</h2>';

 if( (isset($_GET['orderid']) && $_GET['orderid'] > 0) || (isset($_GET['osk']) && ! empty($_GET['osk'])) ){
 pmform($_GET['orderid']);
 }
 else{
 echo orderid_form();
 }

function orderid_form($err = ''){
global $lang;
 if(isset($_GET['orderid']) && $_GET['orderid'] > 0){
 $_GET['orderid']=intval($_GET['orderid']);
 }
 if(! empty($err)){
 $err = "<div class=\"red\">$err</div>";
 }
return <<<HTMLDATA
$err
<form name="frmpayorder" action="?" method="GET">
<input type="hidden" name="view" value="pay_order">
<table>
 <tr><td>$lang[order_number]</td><td><input type="text" name="orderid" value="$_GET[orderid]"></td></tr>
 <tr><td>$lang[osk]</td><td><input type="text" name="osk" value="$_GET[osk]"></td></tr>
</table>
<input type="submit" value="$lang[continue]">
</form>
HTMLDATA;
}

function pmform($orderid){
global $lang;
$orderid=intval($orderid);
include(INC_DIR."/pm_modules.php");
$order_data=get_order_data($orderid);
require_once(INC_DIR."/shop_order.php");
$shop_order=new shop_order;
$order_osk = $shop_order->get_osk($order_data['order']);
 if($_GET['osk'] !== $order_osk || $order_data['order']['orderid'] != $orderid){
 echo orderid_form($lang['invalid_data']);
 return;
 }
 if($order_data['order']['paymethod_advname']){
 $_SESSION['arwshop_mk']['order']['order_id']=$orderid;
 $order_data['order']['paymethod_advname'] = preg_replace("([^a-z0-9\_\-])", '', $order_data['order']['paymethod_advname']);
 echo load_payment_module($order_data['order']['paymethod_advname']);
 }
 else{
 echo $lang['order_processing'];
 }
}

?>