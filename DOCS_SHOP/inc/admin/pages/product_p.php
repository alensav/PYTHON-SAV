<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}

 switch($act){

 case 'editem':
 include(INC_DIR."/admin/pages/itemform_p.php");
 break;

 case 'additem':
 include(INC_DIR."/admin/pages/itemform_p.php");
 break;

 case 'gallery':
 include(INC_DIR."/admin/pages/gallery_p.php");
 break;

 case 'item_options':
 include(INC_DIR."/admin/pages/item_options_match_p.php");
 break;
 
 case 'item_similar':
 include(INC_DIR."/admin/pages/item_similar_p.php");
 break;

 case 'addition_categories':
 include(INC_DIR."/admin/pages/addition_categories_p.php");
 break;

 case 'delitem':
 include(INC_DIR."/admin/pages/delitem_p.php");
 break;
 
 case 'comments':
 include(INC_DIR."/admin/pages/product_comments_p.php");
 break;
 
 default: echo "<h3>$lang[page_not_found]</h3>";
 }

?>