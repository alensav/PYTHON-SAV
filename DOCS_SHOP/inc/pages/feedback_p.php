<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('feedback');
require_once(INC_DIR."/msg.php");
$err_msg='';

require_once(INC_DIR."/add_fields.php");
$add_fields = new add_fields;

 if(! empty($_POST['send'])){
 $page_tags['meta_title']=$lang['feedback'];
 require_once(INC_DIR."/mailer.php");
 $mailer=new mailer;

$_POST = $custom->stripslashes_array($_POST);

 $_POST['email']=trim($_POST['email']);
  if(! $_POST['email']){
  $err_msg.="$lang[no_email]<br>";
  }
  else{
  if(! $mailer->valid_email($_POST['email'])){$err_msg.="$lang[invalid_email]<br>";}
  }

 $_POST['first_name']=trim($_POST['first_name']);
 if(! $_POST['first_name']){$err_msg.="$lang[no_first_name]<br>";}

 $_POST['subject']=trim($_POST['subject']);
 if(! $_POST['subject']){$err_msg.="$lang[no_subject]<br>";}


 $_POST['mailtext']=trim($_POST['mailtext']);
 if(! $_POST['mailtext']){$err_msg.="$lang[no_mailtext]<br>";}

  if($sett['antibot_feedback']){
  $_POST['protect_code']=trim($_POST['protect_code']);
   if(! $_POST['protect_code']){
   $err_msg.="$lang[not_protect_code]<br>";
   }
   elseif(empty($_SESSION['arwshop_mk']['rnd_botcode']) || $_POST['protect_code'] != $_SESSION['arwshop_mk']['rnd_botcode']){
   $err_msg.="$lang[invalid_protect_code]<br>";
   }
   else{
   unset($_SESSION['arwshop_mk']['rnd_botcode']);
   }
  }

$err_msg .= $add_fields->check_fields('feedback', 'feedback');

$from_info = "$lang[sender_email]: $_POST[email]\n";
 if($_POST['first_name']){
 $from_info .= "$lang[sender_first_name]: $_POST[first_name]\n";
 }
$from_info .= "\n";

$mail_body = "$_POST[mailtext]\n\n$add_fields->order_email_fields\n$from_info";

  if($err_msg){
  echo msg::error($err_msg, $lang['error_found']); 
  }
  else{
  $send_result = $mailer->sendemail($_POST['first_name'], $_POST['email'], $sett['shop_name'], $sett['email'], $_POST['subject'], $mail_body);
   if($send_result){
   echo msg::success("$lang[thank_you] $_POST[first_name], $lang[message_sended].");
   }
   else{
   echo msg::error("$lang[contact_admin] <a href=\"mailto:$sett[email]\">$sett[email]</a>", $lang['cannot_send_message']);
   }
  }

 }
 else{
 $_POST['email'] = '';
 $_POST['first_name'] = '';
 $_POST['subject'] = '';
 $_POST['mailtext'] = '' ;
 }


 if(empty($_POST['send']) || $err_msg){

 $template = new template('feedback_form.tpl');

  if($sett['antibot_feedback']){
  $template->condition('antibot_feedback');
  mt_srand((double) microtime() * 1000000);
  $rnd=mt_rand(0,999999).mt_rand(0, 999999);
  $template->assign('random_image_url', "$sett[relative_url]img.php?v=$rnd");
  }
  else{
  $template->not_condition('antibot_feedback');
  }

 $template = $add_fields->get_fields('feedback', $template, '', '', 0);

 $template->assign('email', $_POST['email']);
 $template->assign('first_name', $_POST['first_name']);
 $template->assign('subject', $_POST['subject']);
 $template->assign('mailtext', $_POST['mailtext']);
 echo $template->out_content();
 unset($template, $err_msg);
 }

?>