<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

global $template, $lang, $custom, $db, $page_tags, $lastpage;
$custom->get_lang('login');
require_once(INC_DIR."/msg.php");
$page_tags['meta_title']="$lang[authorization] - $sett[pages_title]";

 if(empty($_SESSION['arwshop_mk']['user']["username"])){

 $template = new template('login_form.tpl');

 $template->assign('last_page', urlencode($lastpage));

  if(! empty($_POST['user_enter'])){
  require_once(INC_DIR."/auth_user.php");
  $auth_user=new auth_user;
   if($auth_user->user_enter()){
   $msg='';
    if($lastpage){
    $msg .= "<a href=\"$lastpage\">$lang[continue]</a>";
    }
    else{
    $msg .= "<a href=\"?view=profile\">$lang[your_profile]</a>";
    }
   echo msg::success($msg, $lang['you_entered_as'] . ' ' . $_SESSION['arwshop_mk']['user']['username']);
   }
   else{
   echo msg::error($lang['invalid_login']);
   echo $template->out_content();
   }
  }
  else{
  echo $template->out_content();
  }

 }
 else{
 $msg='';
  if($lastpage){
  $msg .= "<a href=\"$lastpage\">$lang[continue]</a>";
  }
  else{
  $msg .= "<a href=\"?view=profile\">$lang[your_profile]</a>";
  }
 echo msg::success($msg, $lang['you_entered_as'] . ' ' . $_SESSION['arwshop_mk']['user']['username']);
 }

unset($template);
?>