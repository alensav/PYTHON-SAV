<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(empty($_SESSION['arwshop_mk']['user']['username'])){
 include(INC_DIR."/pages/login_p.php");
 }
 else{

 global $page_tags, $sett;

 $custom->get_lang('profile');
 $page_tags['meta_title']="$lang[change_profile] - $sett[pages_title]";
 require_once(INC_DIR."/profile.php");
 $profile=new profile;
 $custom->get_lang('register');

 $template = new template('profile.tpl');

 if(! empty($_POST['save'])){
 require_once(INC_DIR."/register.php");
 global $register, $fields;
 $register=new register;
 $err_msg=$profile->check_profile_form($_POST, '', 1, 1);



  if($_POST['old_password'] || $_POST['password1'] || $_POST['password2']){

  $_POST['old_password']=trim($_POST['old_password']);
  $_POST['password1']=trim($_POST['password1']);
  $_POST['password2']=trim($_POST['password2']);

   if(! $profile->is_valid_password($_SESSION['arwshop_mk']['user']['userid'], $_SESSION['arwshop_mk']['user']['username'], $_POST['old_password'])){
   $err_msg.="$lang[invalid_old_pass]<br>";
   }

   if(preg_match("([^a-zA-Z0-9\x80-\xFF\x20\_\-])", $_POST['password1'])){
   $err_msg.="$lang[invalid_pass]<br>";
   }

   if(isset($_POST['username']) && $_POST['password1'] == $_POST['username']){
   $err_msg.="$lang[pass_eq_login]<br>";
   }

   if(! $_POST['password1']){
   $err_msg.="$lang[no_pass]<br>";
   }
   elseif(mb_strlen($_POST['password1']) < 6){
   $err_msg.="$lang[short_password]<br>";
   }

   if($_POST['password1'] !== $_POST['password2']){
   $err_msg.="$lang[passwords_not_coincide]<br>";
   }

  }


  if($err_msg){
  $template->assign('error_message', "<p class=\"red\"><b>$lang[found_errors]</b><br>$err_msg</p>");
  }
  else{
  $update_res = $profile->update_profile($_SESSION['arwshop_mk']['user']['userid']);
   if($update_res === '1'){
   $template->assign('error_message', "<h3>$lang[changes_success]</h3>");
   }
   else{
   $template->assign('error_message', "<p class=\"red\">$update_res</p>");
   }
  }
 }
 else{
 $template->assign('error_message', '');
 $fields = $profile->get_orderfields(); 
 }

 require_once(INC_DIR."/register.php");
 global $register;
 $register=new register;

  if(! empty($_POST['save'])){
  $user_info=$custom->stripslashes_array($_POST);
  }
  else{
  $user_info=$profile->get_profile($_SESSION['arwshop_mk']['user']['userid']);
  }


 $user_group_info = $profile->get_user_group_info($_SESSION['arwshop_mk']['user']['userid']);

 $template->assign('username', $_SESSION['arwshop_mk']['user']['username']);
 $template->assign('groupname', $user_group_info['groupname']);
 $min_max_discounts = $profile->get_min_max_group_discounts($user_group_info['groupid']);
  if($min_max_discounts[0] != $min_max_discounts[1]){
  $min_max_discounts_str = "$lang[from] $min_max_discounts[0] $lang[to] $min_max_discounts[1]";
  }
  else{
  $min_max_discounts_str = $min_max_discounts[0];
  }
  
  if($min_max_discounts[0] > 0){
  $template->condition('group_discount');
  }
  else{
  $template->not_condition('group_discount');
  }
  
  if($sett['pub_group_discounts']){
  $template->condition('pub_group_discounts');
  }
  else{
  $template->not_condition('pub_group_discounts'); 
  }
  
 $template->assign('group_discount', $min_max_discounts_str);
 $template->assign('group_discounts_url', @stdi2("view=discounts&dtype=group", "discounts/group.html"));
 $template->assign('discounts_url', @stdi2("view=discounts", "discounts/"));
 $template->assign('group_descript', $user_group_info['descript']);
 $template->assign('user_info', $profile->get_profile_block($fields, $user_info));
 echo $template->out_content();
 unset($template);

 }

?>