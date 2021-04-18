<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}

 switch($act){

 case 'ed_help':
 include(INC_DIR."/admin/pages/ed_help_p.php");
 break;

 case 'ed_selcolor':
 include(INC_DIR."/admin/pages/ed_selcolor_p.php");
 break;

 case 'ed_ins_link':
 include(INC_DIR."/admin/pages/ed_ins_link_p.php");
 break;

 case 'ed_ins_img':
 include(INC_DIR."/admin/pages/ed_ins_img_p.php");
 break;

 case 'ed_img_list':
 include(INC_DIR."/admin/pages/ed_img_list_p.php");
 break;
 
 default: echo "<h3>$lang[page_not_found]</h3>";
 }

?>