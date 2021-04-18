<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('discounts');

 if(isset($_GET['dtype']) && $_GET['dtype'] == 'group'){
 echo show_group_discounts();
 }
 else{
 echo show_all_discounts();
 }
 

 
function show_all_discounts(){
global $db, $page_tags, $sett, $lang, $shop;
 if(! $sett['pub_all_discounts']){
 return header404();
 }
$tbl_users_groups=DB_PREFIX.'users_groups';
$tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';
$page_tags['meta_title']="$lang[discounts] - $sett[pages_title]";
$template = new template('discounts.tpl');

$user_groupid = isset($_SESSION['arwshop_mk']['user']['groupid']) ? intval($_SESSION['arwshop_mk']['user']['groupid']) : 0;
 if(! $user_groupid){
 $user_groupid = 1;
 }
$res = $db->query("SELECT groupname FROM $tbl_users_groups WHERE groupid = $user_groupid") or die($db->error());
$row = $db->fetch_array($res);
$template->assign('user_groupname', $row['groupname']);
$template->assign('discounts_url', @stdi2("view=discounts", "discounts/"));
$template->assign('group_discounts_url', @stdi2("view=discounts&dtype=group", "discounts/group.html"));

$template->get_cycle('groups');
$template->get_cycle('group_discounts', 'groups');

$res = $db->query("SELECT $tbl_users_groups_discounts.groupid, $tbl_users_groups_discounts.order_sum, $tbl_users_groups_discounts.discount, $tbl_users_groups.groupname, $tbl_users_groups.min_order_sum FROM $tbl_users_groups_discounts, $tbl_users_groups WHERE $tbl_users_groups.groupid = $tbl_users_groups_discounts.groupid ORDER BY $tbl_users_groups.sortid, $tbl_users_groups_discounts.groupid, $tbl_users_groups_discounts.order_sum, $tbl_users_groups_discounts.discount") or die($db->error());

$last_groupid = 0;

$def_class = 'ttr';

 while($row=$db->fetch_array($res)){
  if($row['groupid'] != $last_groupid){
   if($last_groupid != 0){
   $template->out_cycle('group_discounts');
   $template->next_loop('groups');
   $def_class='ttr';
   }
  $last_groupid = $row['groupid'];
  $template->assign_cycle('groupname', $row['groupname'], 'groups');
  $template->assign_cycle('min_order_sum', $shop->format_price($shop->calc_price($row['min_order_sum'])));
  $template->assign_cycle('currency_brief', $sett['show_curr_brief']);
  }

 $template->assign_cycle('order_sum', $shop->format_price($shop->calc_price($row['order_sum'])), 'group_discounts');
 $template->assign_cycle('currency_brief', $sett['show_curr_brief']);
 $template->assign_cycle('discount', $row['discount']);
 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
 $template->assign_cycle('def_class', $def_class);
 $template->next_loop();
 
 }

 if($db->num_rows($res) == 0){
 $template->assign('groupname', '');
 $template->assign('min_order_sum', '');
 $template->assign('currency_brief', '');
 }

$template->out_cycle('group_discounts');
$template->next_loop('groups');
$template->out_cycle('groups');
return $template->out_content();
}



function show_group_discounts(){
global $db, $page_tags, $sett, $lang, $shop;
 if(! $sett['pub_group_discounts']){
 return header404();
 }
$tbl_users_groups=DB_PREFIX.'users_groups';
$tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';
$user_groupid = isset($_SESSION['arwshop_mk']['user']['groupid']) ? intval($_SESSION['arwshop_mk']['user']['groupid']) : 0;
 if(! $user_groupid){
 $user_groupid = 1;
 }
 
$template = new template('group_discounts.tpl');
 
$res = $db->query("SELECT groupname, min_order_sum FROM $tbl_users_groups WHERE groupid = $user_groupid") or die($db->error());
$row = $db->fetch_array($res);

$page_tags['meta_title']="$lang[discounts] $lang[of_user_group] &quot;&quot; - $sett[pages_title]";

$template->assign('user_groupname', $row['groupname']);
$template->assign('discounts_url', @stdi2("view=discounts", "discounts/"));
$template->assign('group_discounts_url', @stdi2("view=discounts&dtype=group", "discounts/group.html"));
$template->assign('min_order_sum', $shop->format_price($shop->calc_price($row['min_order_sum'])));
$template->assign('currency_brief', $sett['show_curr_brief']);
  
$template->get_cycle('group_discounts');
$def_class='ttr';

$res = $db->query("SELECT order_sum, discount FROM $tbl_users_groups_discounts WHERE groupid = $user_groupid  ORDER BY order_sum, discount") or die($db->error());

 while($row=$db->fetch_array($res)){
 $template->assign_cycle('order_sum', $shop->format_price($shop->calc_price($row['order_sum'])), 'group_discounts');
 $template->assign_cycle('currency_brief', $sett['show_curr_brief']);
 $template->assign_cycle('discount', $row['discount']);
 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
 $template->assign_cycle('def_class', $def_class);
 $template->next_loop();
 }
 
 if($sett['pub_all_discounts']){
 $template->condition('pub_all_discounts');
 }
 else{
 $template->not_condition('pub_all_discounts');
 }
 
$template->out_cycle();
return $template->out_content();
}


?>