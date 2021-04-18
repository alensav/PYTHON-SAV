<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $shop_order;
require_once(INC_DIR."/shop_order.php");
$shop_order=new shop_order;
$paymethod_specialinfo = $shop_order->get_paymethod_specialinfo($_SESSION['arwshop_mk']['order']['pay_method']);

 if(empty($_SESSION['arwshop_mk']['order_complete'])){
 global $mailer, $order_info;
 require_once(INC_DIR."/mailer.php");
 $mailer = new mailer;
 $err_code = $shop_order->add_order();

  if($err_code==1){

  $add_fields->save_fields_in_db($order_info['order_id'], $order_info['pmid']);

   if($sett['mail_order_admin'] || $sett['mail_order_shopper']){
   $custom->get_lang('cart');
   $custom->get_lang('register');
   $mailorderinfo=$shop_order->mail_order_info();

    if($sett['mail_order_admin'] && $mailer->valid_email($sett['email'])){
     if($order_info['email'] && $mailer->valid_email($order_info['email'])){
     $from_name=$order_info['first_name'];
     $from_email=$order_info['email'];
     }
     else{
     $from_name=$sett['shop_name'];
     $from_email=$sett['email'];
     }
    $mailtext = $mailer->get_tplfile('order_admin');
    $mailtext = str_replace('{first_name}', $order_info['first_name'], $mailtext);
    $mailtext = str_replace('{order_info}', $mailorderinfo, $mailtext);
    $mailtext = str_replace('{additional_fields}', $add_fields->order_email_fields, $mailtext);
    $mailtext = str_replace('{adv_descript_mail}', $paymethod_specialinfo['adv_descript_mail'], $mailtext);
    
     if($sett['admin_order_subj']){
     $subject = str_replace('{order_number}', $order_info['order_id'], $sett['admin_order_subj']);
     }
     else{
     $subject = "$lang[new_order_in] $sett[shop_name]";
     }
    $mailer->sendemail($from_name, $from_email, $sett['shop_name'], $sett['email'], $subject, $mailtext);
     if($sett['email2']){
     $mailer->sendemail($from_name, $from_email, $sett['shop_name'], $sett['email2'], $subject, $mailtext);
     }
    }

    if($sett['mail_order_shopper'] && $mailer->valid_email($order_info['email'])){
    $mailtext = $mailer->get_tplfile('order_shopper');
    $mailtext = str_replace('{first_name}', $order_info['first_name'], $mailtext);
    $mailtext = str_replace('{order_info}', $mailorderinfo, $mailtext);
    $mailtext = str_replace('{additional_fields}', $add_fields->order_email_fields, $mailtext);
    $mailtext = str_replace('{adv_descript_mail}', $paymethod_specialinfo['adv_descript_mail'], $mailtext);
    $mailer->sendemail($sett['shop_name'], $sett['email'], $order_info['first_name'], $order_info['email'], $sett['order_subject'], $mailtext);
    }

   }



  $_SESSION['arwshop_mk']['order']=$order_info;
  unset($_SESSION['arwshop_mk']['cart_products'], $order_info, $mailorderinfo);
  $_SESSION['arwshop_mk']['order_complete']=1;



  }
  else{
  $template = new template;
  $template->load_template('order_complete.tpl');
  $template->content = $err_code;
  }

 }



 if(! is_object($template)){
 $template = new template;
 $template->load_template('order_complete.tpl');
 }
$template->not_condition('new_group');
$template->assign('first_name', $_SESSION['arwshop_mk']['order']['first_name']);
$template->assign('order_number', $_SESSION['arwshop_mk']['order']['order_id']);
$template->assign('adv_descript', $paymethod_specialinfo['adv_descript']);
 if($paymethod_specialinfo['adv_descript']){
 $template->condition('adv_descript');
 }
 else{
 $template->not_condition('adv_descript');
 }

$shop_order->payment_blanks_links($_SESSION['arwshop_mk']['order'], $template);

$paymethod_advname = preg_replace("([^a-z0-9\_])", '', $_SESSION['arwshop_mk']['order']['paymethod_advname']);

 if($paymethod_advname){
 require_once(INC_DIR."/pm_modules.php");
 $pm_mod_content = load_payment_module($paymethod_advname);
 $template->assign('payment_module', $pm_mod_content);
 $template->assign('special_pay_info', $pm_mod_content);
 $template->condition('payment_module');
 }
 else{
 $template->assign('payment_module', '');
 $template->assign('special_pay_info', '');
 $template->not_condition('payment_module');
 }

echo $template->out_content();
unset($template);
?>