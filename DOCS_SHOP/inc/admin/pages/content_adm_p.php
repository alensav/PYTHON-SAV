<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/content_adm');
require_once(INC_DIR."/admin/content_adm.php");
$content_adm=new content_adm;

echo "<h3>$lang[add_pages]</h3>";

 switch($act){
 case 'edit':
 include(INC_DIR."/admin/pages/content_page_form_p.php");
 break;

 case 'add':
 include(INC_DIR."/admin/pages/content_page_form_p.php");
 break;

 case 'delete':
 echo $content_adm->delete_page($_GET['pname']);

 default:
 echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=content&act=add\">$lang[add_page]</a></p>";
 echo $content_adm->get_all_pages();
 }

?>
