<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/news_adm');
require_once(INC_DIR."/admin/news_adm.php");
$news_adm=new news_adm;

echo "<h3>$lang[news]</h3>";

 switch($act){
 case 'edit':
 include(INC_DIR."/admin/pages/news_form_p.php");
 break;

 case 'add':
 include(INC_DIR."/admin/pages/news_form_p.php");
 break;

 case 'delete':
 echo $news_adm->delete_news($_GET['nid']);

 default:
 echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<b><a href=\"?view=news&act=add\">$lang[add_news]</a></b><br><br></p>";
 echo $news_adm->get_all_news();
 }


?>
