<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('content');
require_once(INC_DIR."/content.php");
$content=new content;

 if(! empty($_GET['pname']) || ! empty($_POST['pname'])){


   if(isset($_POST['pname']) && $_POST['pname'] == 'contacts'){
   include(INC_DIR."/pages/feedback_p.php");
   }
   else{
   $content_text=$content->get_page($_GET['pname']);

   if(! $content_text['pname']){echo header404(); return '';}

   $page_tags['meta_title']="$content_text[title] - $sett[pages_title]";

     if($content_text['description']){
     $page_tags['metatags'].="<meta name=\"description\" content=\"$content_text[description]\">\n";
     }

     if($content_text['keywords']){
     $page_tags['metatags'].="<meta name=\"keywords\" content=\"$content_text[keywords]\">\n";
     }

    $page_tags['metatags'].=$content_text['metatags'];

    $template = new template('content_detail.tpl');
    $template->assign('special_text', $content_text['special']);
    $template->assign('page_title', $content_text['title']);
    $template->assign('page_text', $content_text['text']);
    $template->assign('all_content_url', @stdi2("view=content", "content/"));
    echo $template->out_content();
    unset($template);

     if( (isset($_GET['pname']) && $_GET['pname'] == 'contacts') || (isset($_POST['pname']) && $_POST['pname'] == 'contacts')){
     include(INC_DIR."/pages/feedback_p.php");
     }

    unset($content_text);
   }

 }
 else{
 $page_tags['meta_title']="$lang[content_categories] - $sett[pages_title]";
 echo $content->get_all_content();
 }

?>