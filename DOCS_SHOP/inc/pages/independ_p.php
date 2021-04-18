<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $view;

 switch($view){
 
 case 'sel_currency':
 include(INC_DIR."/pages/sel_currency_p.php");
 break;

 case 'cart':
 require_once(INC_DIR."/shop.php");
 global $shop;
 $shop=new shop;
 include(INC_DIR."/pages/cart_p.php");
 break;

 case 'price':
 include(INC_DIR."/pages/price_p.php");
 break;

 case 'payment_blank':
 require_once(INC_DIR."/payment_blank.php");
 $pm_blank=new pm_blank;
 echo $pm_blank->show_pm_blank(0);
 break;

 case 'payment_module':
 include(INC_DIR."/pages/payment_module_p.php");
 break;

 default: header404();
 }

?>