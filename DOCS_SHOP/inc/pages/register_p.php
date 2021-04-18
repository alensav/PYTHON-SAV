<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('register');
require_once(INC_DIR."/msg.php");

 if(empty($_SESSION['arwshop_mk']['user']["username"])){

 global $page_tags, $template;
 $custom->get_lang('register');
 $page_tags['meta_title']="$lang[reg_new_user] - $sett[pages_title]";
 require_once(INC_DIR."/register.php");
 global $register;
 $register=new register;
 $err_msg = '';

  if(! empty($_POST['adduser'])){
  $err_msg=$register->check_form();

   if(! empty($err_msg)){
   $err_msg=msg::error($err_msg, $lang['found_errors']);
   include(INC_DIR."/pages/register_form_p.php");
   }
   else{
   $userid=$register->add_user();

   $_SESSION['arwshop_mk']['user']=array();
   $_SESSION['arwshop_mk']['user']['userid']=$userid;
   $_SESSION['arwshop_mk']['user']['username']=$_POST['username'];
   $_SESSION['arwshop_mk']['user']['key'] = md5('value' . intval(date("YmdH", time())) . $userid . $_POST['username'] . $_POST['password1'] . 'Validate User Key');

   $msg=$lang['you_entered_as'] . ' ' .$_SESSION['arwshop_mk']['user']['username'] . '<br>';
    if($lastpage){
    $msg.="<a href=\"$lastpage\">$lang[continue]</a>";
    }
    else{
    $msg .= "<a href=\"?view=profile\">$lang[your_profile]</a>";
    }
   echo msg::success($msg, $lang['thank_for_register']);
   }
  }
  else{
  include(INC_DIR."/pages/register_form_p.php");
  }

 }
 else{
 $msg='';
  if($lastpage){
  $msg.="<a href=\"$lastpage\">$lang[continue]</a><br>";
  }
  else{
  $msg .= "<a href=\"?view=profile\">$lang[your_profile]</a>";
  }
 echo msg::success($msg, $lang['you_already_registered']);
 }
?>