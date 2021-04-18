<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class mailer{

private $total_count = 0;

function sendemail($from_name, $from_email, $to_name, $to_email, $subject, $message){
global $sett;

$reply_to_email = $from_email;
$reply_to_name = $from_name;

 if($sett['shop_sender_only']){
 $from_name = $sett['shop_name'];
 $from_email = $sett['email'];
 }

 if($sett['nonames_mailheaders']){
 $to_name = '';
 $from_name = '';
 $reply_to_name = '';
 }

if(! $this->valid_email($from_email)){return 0;}
if(! $this->valid_email($to_email)){return 0;}

if($from_name){$from_name='=?'.$sett['charset'].'?B?'.base64_encode($from_name).'?=';}
if($to_name){$to_name='=?'.$sett['charset'].'?B?'.base64_encode($to_name).'?=';}
if($reply_to_name){$reply_to_name='=?'.$sett['charset'].'?B?'.base64_encode($reply_to_name).'?=';}
if($subject){$subject='=?'.$sett['charset'].'?B?'.base64_encode($subject).'?=';}

$from = $from_email;
$to = $to_email;
$reply_to = $reply_to_email;

 if(! $this->is_windows() || DEBUG_MODE == 1){
  if($from_name){$from = "$from_name <$from_email>";}
  if($to_name){$to = "$to_name <$to_email>";}
  if($reply_to_name){$reply_to = "$reply_to_name <$reply_to_email>";}
 }

$subject = stripslashes($subject);
$message = stripslashes($message);

$message=str_replace('&quot;', '"', $message);
$message=str_replace('&#39;', "'", $message);
$message=str_replace('&#96;', "`", $message);

$message=str_replace('&lt;', '<', $message);
$message=str_replace('&gt;', '>', $message);

 if(! $this->is_windows()){
 $message = custom::rn_to_n($message);
 }

$headers = "From: $from\n";
 if($sett['shop_sender_only']){
 $headers .= "Reply-To: $reply_to\n";
 }
$headers .= "Content-type: text/plain; charset=$sett[charset]\n";
$headers .= "Content-Transfer-Encoding: 8bit\n";

 if($this->total_count > 0){
  if(! isset($sett['mail_delay'])){
  $sett['mail_delay'] = '0.4';
  }
 $md_mks = floatval($sett['mail_delay']) * 1000000;
  if($md_mks > 0){
  usleep($md_mks);
  }
 }

 if(! $sett['use_smtp']){
  if(@mail($to, $subject, $message, $headers)){
  $result = true;
  }
  else{
  $result = false;
  if(DEBUG_MODE==1){echo 'Can\'t send mail() function!<br>';}
  }
 }
 else{
 global $smtp;
  if(! is_object($smtp)){
  require_once(INC_DIR."/smtp.php");
  $smtp=new smtp;
  }
 $smtp_params['from'] = $from_email;
 $smtp_params['to_adrs'] = $to_email;
 $smtp_params['headers'] = array("Content-type: text/plain; charset=$sett[charset]", "From: $from", "To: $to", "Subject: $subject");
 $smtp_params['body'] = $message;
  if($smtp->mail_send($smtp_params)){
  $result = true;
  }
  else{
  $result = false;
  if(DEBUG_MODE==1){echo 'SMTP Error:<br>';print_r($smtp->errors);}
  }
 }

$this->total_count++;

 if(DEBUG_MODE == 1){
 $headers=str_replace('<','&lt;',$headers);
 $headers=str_replace('>','&gt;',$headers);
 $to=str_replace('<','&lt;',$to);
 $to=str_replace('>','&gt;',$to);
 $mail="<table border=1><tr><td>$headers<br>To: $to<br>Subject: $subject<hr>Body:$message</td></tr></table><br><hr><br>";
 $mail = nl2br($mail, false);
 echo $mail;
 }

return $result;
}


function valid_email($email){
 if(strstr($email, '\\')){
 return false;
 }
 if(! preg_match("(^([a-zA-Z0-9_\.\-]{1,255})(\@)([a-zA-Z0-9\.\-]{1,255})(\.)([a-zA-Z0-9\-]{1,255})$)", $email)){
 return false;
 }
return true;
}


function is_windows(){
 if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
 return true;
 }
 else{
 return false;
 }
}


function get_tplfile($file){
global $sett;
 if(PHP_IN_TPL == 1){
 $ret = $this->include_in_var(MAIL_TPL_DIR."/$file.tpl");
 }
 else{
 $ret = file_get_contents(MAIL_TPL_DIR."/$file.tpl");
 }

 if(substr($ret, 0, 3) == "\xEF\xBB\xBF"){
 $ret = substr($ret, 3);
 }

 if(! $this->is_windows()){
 $ret = custom::rn_to_n($ret);
 }

$ret = str_replace('{shop_name}', $sett['shop_name'], $ret);
$ret = str_replace('{shop_url}', $sett['url'], $ret);
$ret = str_replace('{shop_email}', $sett['email'], $ret);
return $ret;
}


function include_in_var($file){
ob_start();
ob_implicit_flush(0);
include($file);
$ret=ob_get_contents();
ob_end_clean();
return $ret;
}



}
?>