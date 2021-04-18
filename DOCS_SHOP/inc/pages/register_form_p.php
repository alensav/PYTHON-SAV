<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
echo register_form($err_msg);

function register_form($err_msg){
global $custom, $sett, $lastpage, $db, $register;
$user_info = $custom->replace_quotes_array($custom->stripslashes_array($_POST));
$template = new template('register.tpl');

$sett['reg_def_group']=intval($sett['reg_def_group']);
 if(! $sett['reg_def_group']){
 $sett['reg_def_group']=1;
 }
$regallowgroups=$register->reg_allowed_groups();
 if(sizeof($regallowgroups)){
 $template->condition('reg_allow_groups');
 $template->get_cycle('user_groups');
 $in_groups='';
  foreach($regallowgroups as $groupid){
  $in_groups.=$groupid.',';
  }
 $in_groups=substr($in_groups, 0, strlen($in_groups)-1);
 $tbl_users_groups=DB_PREFIX.'users_groups';
 $res=$db->query("SELECT `groupid`, `groupname`, `descript` FROM `$tbl_users_groups` WHERE `groupid` IN($in_groups) ORDER BY `sortid`") or die($db->error());
 $def_class='ttr';
  while($row=$db->fetch_array($res)){

   if(! empty($_POST['adduser'])){
    if(isset($_POST['user_group']) && $row['groupid'] == $_POST['user_group']){
    $checked=' checked="checked"';
    }
    else{
    $checked='';
    }
   }
   else{
    if($row['groupid']==$sett['reg_def_group']){
    $checked=' checked="checked"';
    }
    else{
    $checked='';
    }
   }

  if($def_class==='str'){$def_class='ttr';}else{$def_class='str';}
  $template->assign_cycle('def_class', $def_class);
  $template->assign_cycle('def_groupid', $row['groupid']);
  $template->assign_cycle('group_checked', $checked);
  $template->assign_cycle('groupname', $row['groupname']);
  $template->assign_cycle('group_description', $row['descript']);
  $template->next_loop();
  }
 $template->out_cycle();
 }
 else{
 $template->not_condition('reg_allow_groups');
 }


 if($sett['antibot_register']){
 $template->condition('antibot_register');
 mt_srand((double) microtime() * 1000000);
 $rnd=mt_rand(0,999999).mt_rand(0, 999999);
 $template->assign('random_image_url', "$sett[relative_url]img.php?v=$rnd");
 }
 else{
 $template->not_condition('antibot_register');
 }

$template->assign('error_message', $err_msg);
$template->assign('last_page', urlencode($lastpage));
 if(! isset($user_info['username'])){
 $user_info['username'] = '';
 }
$template->assign('username', $user_info['username']);
 if(! isset($user_info['password1'])){
 $user_info['password1'] = '';
 }
$template->assign('password1', $user_info['password1']);
 if(! isset($user_info['password2'])){
 $user_info['password2'] = '';
 }
$template->assign('password2', $user_info['password2']);

require_once(INC_DIR."/profile.php");
$profile=new profile;
$fields = $profile->get_orderfields();
$template->assign('profile_fields', $profile->get_profile_block($fields, $user_info));


return $template->out_content();
}

?>