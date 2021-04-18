<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

if($_POST['order_currency']){$_SESSION['arwshop_mk']['order']['currency_id']=$_POST['order_currency'];}
if($_POST['delivery_method']){$_SESSION['arwshop_mk']['order']['dmid']=$_POST['delivery_method'];}
if($_POST['first_name']){$_SESSION['arwshop_mk']['order']['first_name']=$_POST['first_name'];}
if($_POST['last_name']){$_SESSION['arwshop_mk']['order']['last_name']=$_POST['last_name'];}
if($_POST['patronymic']){$_SESSION['arwshop_mk']['order']['patronymic']=$_POST['patronymic'];}
if($_POST['company']){$_SESSION['arwshop_mk']['order']['company']=$_POST['company'];}
if($_POST['country']){$_SESSION['arwshop_mk']['order']['country']=$_POST['country'];}
if($_POST['city']){$_SESSION['arwshop_mk']['order']['city']=$_POST['city'];}
if($_POST['address']){$_SESSION['arwshop_mk']['order']['address']=$_POST['address'];}
if($_POST['zip_code']){$_SESSION['arwshop_mk']['order']['zip_code']=$_POST['zip_code'];}
if($_POST['phone']){$_SESSION['arwshop_mk']['order']['phone']=$_POST['phone'];}
if($_POST['email']){$_SESSION['arwshop_mk']['order']['email']=$_POST['email'];}
if($_POST['comment']){$_SESSION['arwshop_mk']['order']['comment']=$_POST['comment'];}

$add_fields->save_fields_in_session($_SESSION['arwshop_mk']['order']['pay_method']);


$custom->get_lang('cart');

echo $shop_order->get_orderinfo_table();
?>