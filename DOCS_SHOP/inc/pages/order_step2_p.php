<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

global $currencies;

 if(! empty($_POST['pay_method'])){
  if(! isset($_SESSION['arwshop_mk']['order'])){
  $_SESSION['arwshop_mk']['order'] = array();
  }
 $_SESSION['arwshop_mk']['order']['pay_method']=$_POST['pay_method'];
 }

$custom->get_lang('register');

$template = new template('order_step2.tpl');
 if(isset($err_msg) && ! empty($err_msg)){
 $err_msg=msg::error($err_msg, $lang['found_errors']);
 }
 else{
 $err_msg='';
 }
$template->assign('error_message', $err_msg);

$asterisk = '<span class="reqFields">*</span>' ;
$text_size = 40 ;
$user_info = $custom->replace_quotes_array($custom->stripslashes_array($_POST));


  if(! empty($_SESSION['arwshop_mk']['user']['userid']) || $sett['order_without_register']){

  require_once(INC_DIR."/shop_order.php");
  $shop_order=new shop_order;

  $custom->get_lang('register');
  require_once(INC_DIR."/register.php");
  global $register;
  $register=new register;

     if(! empty($_SESSION['arwshop_mk']['user']['userid']) && $_POST['step'] == '1'){
     require_once(INC_DIR."/profile.php");
     $profile=new profile;
     $user_info = $profile->get_profile($_SESSION['arwshop_mk']['user']['userid']);
     }


    if($sett['antibot_order']){
    $template->condition('antibot_order');
    mt_srand((double) microtime() * 1000000);
    $rnd=mt_rand(0,999999).mt_rand(0, 999999);
    $template->assign('random_image_url', "$sett[relative_url]img.php?v=$rnd");
    }
    else{
    $template->not_condition('antibot_order');
    }



    $paymethod_specialinfo = $shop_order->get_paymethod_specialinfo($_SESSION['arwshop_mk']['order']['pay_method']);

    $template->assign('selected_pay_method', $paymethod_specialinfo['pmtitle']);

    $template->get_cycle('paymethod_currencies_list');



    global $db;

    $template->get_cycle('paymethod_currencies');

    $pmid=intval($_SESSION['arwshop_mk']['order']['pay_method']);
    $tbl_paymethods_currencies=DB_PREFIX.'paymethods_currencies';
    $tbl_currencies=DB_PREFIX.'currencies';
    $res=$db->query("SELECT $tbl_paymethods_currencies.currency_id, $tbl_currencies.brief, $tbl_currencies.title FROM $tbl_paymethods_currencies, $tbl_currencies WHERE $tbl_paymethods_currencies.pmid = $pmid AND     $tbl_currencies.currency_id = $tbl_paymethods_currencies.currency_id AND $tbl_currencies.enabled = 1") or die($db->error());
    $num_rows=$db->num_rows($res);

    $option_selected = false;

     while($row=$db->fetch_array($res)){

      if($row['currency_id'] && ! $option_selected){
       if(! empty($_POST['order_currency']) && $row['currency_id'] == $_POST['order_currency']){
       $selected=' selected="selected"';
       $option_selected = true;
       }
       elseif(empty($_POST['order_currency']) && $num_rows < 2){
       $selected=' selected="selected"';
       $option_selected = true;
       }
       elseif(empty($_POST['order_currency']) && (isset($_SESSION['arwshop_mk']['show_currency_id']) && $row['currency_id'] == $_SESSION['arwshop_mk']['show_currency_id']) ){
       $selected=' selected="selected"';
       $option_selected = true;
       }
       elseif(empty($_POST['order_currency']) && empty($_SESSION['arwshop_mk']['show_currency_id']) && $row['currency_id'] == $sett['def_show_currency']){
       $selected=' selected="selected"';
       $option_selected = true;
       }
       else{
       $selected='';
       }
      }
      else{
      $selected='';
      }

     $template->assign_cycle('currency_id', $row['currency_id']);
     $template->assign_cycle('selected', $selected);
     $template->assign_cycle('currency_name', $row['title']);
     $template->assign_cycle('currency_brief', $row['brief']);
     $template->next_loop();
     }

$template->out_cycle();





     $template->get_cycle('delivery_methods');
     $tbl_deliverymethods=DB_PREFIX.'deliverymethods';
     $tbl_paymethods_deliverymethods=DB_PREFIX.'paymethods_deliverymethods';
     $res=$db->query("SELECT * FROM $tbl_paymethods_deliverymethods, $tbl_deliverymethods WHERE $tbl_paymethods_deliverymethods.pmid = $pmid AND $tbl_deliverymethods.dmid = $tbl_paymethods_deliverymethods.dmid AND $tbl_deliverymethods.enabled = 1 ORDER BY $tbl_deliverymethods.sortid, $tbl_deliverymethods.dmname") or die($db->error());

     $num_rows=$db->num_rows($res);

      


      if(! empty($_POST['order_currency'])){
      $show_currency_id = $currencies["$_POST[order_currency]"]["currency_id"];
      $show_currency_brief = $currencies["$_POST[order_currency]"]["brief"];
      }
      else{
      $show_currency_id = 0;
      $show_currency_brief = $sett['show_curr_brief'];
      }

     $def_class='ttr';

      while($row=$db->fetch_array($res)){

       if($def_class == 'ttr'){
       $def_class = 'str';
       }
       else{
       $def_class = 'ttr';
       }

       if( (isset($_POST['delivery_method']) && $row['dmid'] == $_POST['delivery_method']) || $num_rows < 2){
       $checked = ' checked="checked"';
       }
       else{
       $checked = '';
       }

      $template->assign_cycle('def_class', $def_class);
      $template->assign_cycle('delivery_method_id', $row['dmid']);
      $template->assign_cycle('checked', $checked);
      $template->assign_cycle('delivery_method_url', @stdi2("view=delivery_methods&dm=$row[dmid]", "delivery_methods/dm$row[dmid].html"));
      $template->assign_cycle('delivery_method_name', $row['dmname']);
      $template->assign_cycle('short_descript', $row['short_descript']);
      $template->assign_cycle('delivery_cost', $shop->format_price($shop->calc_price($row['delivery_cost'], $show_currency_id)));
       if($row['free_delivery_sum'] > 0){
       $template->assign_cycle('free_delivery_sum', $shop->format_price($shop->calc_price($row['free_delivery_sum'])));
       }
       else{
       $template->assign_cycle('free_delivery_sum', $lang['not_free_delivery']);
       }
      $template->assign_cycle('currency_brief', $show_currency_brief);
      
       if($row['delivery_cost'] > 0){
       $template->condition_cycle('delivery_cost');
       }
       else{
       $template->not_condition_cycle('delivery_cost');
       }

      $template->next_loop('delivery_methods');
      }
      
     unset($show_currency_id , $show_currency_brief);

     $template->out_cycle('delivery_methods');






  require_once(INC_DIR."/profile.php");
  $profile=new profile;
  $fields = $profile->get_orderfields();
  $template->assign('user_information', $profile->get_profile_block($fields, $user_info));
  $template = $add_fields->get_fields('order', $template, '', '', $pmid);



   if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}


    if(! empty($fields['agreement']['enabled'])){
    if($fields['agreement']['required']){$f_required=$asterisk;}else{$f_required='';}
    if(! empty($user_info['agreement'])){$checked=' checked="checked"';}else{$checked='';}
    $template->condition('agreement');
    $contexthelp = '';
     if($fields['agreement']['contexthelp']){
     $contexthelp = ' ' . custom::contextHelp($fields['agreement']['contexthelp']);
     }
    $template->assign('agreement', "$f_required&nbsp;<input type=\"checkbox\" name=\"agreement\"$checked><a href=\"" . @stdi2("view=agreement", "agreement.html") . "\" target=\"_blank\">$lang[agreement]</a>&nbsp;$lang[agree]$contexthelp");
    }
    else{
    $template->not_condition('agreement');
    }

   if(isset($user_info['comment'])){
   $template->assign('user_comment', $user_info['comment']);
   }
   else{
   $template->assign('user_comment', '');
   }

  echo $template->out_content();
  unset($template);

  }
  else{
  include(INC_DIR."/pages/order_step1_p.php");
  }


?>