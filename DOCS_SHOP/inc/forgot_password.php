<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
require_once(INC_DIR."/msg.php");

class forgot_password{

function user_form($err_msg){
global $lang, $sett;
 if(! empty($err_msg)){
 $err_msg=msg::error($err_msg, $lang['errors_exist']);
 }
$template = new template('forgot_password_form.tpl');
$template->assign('error_message', $err_msg);
$username = isset($_POST['username']) ? $_POST['username'] : '';
$template->assign('username', $username);
$email = isset($_POST['email']) ? $_POST['email'] : '';
$template->assign('email', $email);
return $template->out_content();
}



function send_key(){
global $db, $lang, $sett;
$err_msg = '';
$_POST['username'] = custom::del_notalphanum(trim($_POST['username']));
$_POST['email'] = custom::replace_tags_and_quotes(trim($_POST['email']));

 if(! $_POST['username']){
 $err_msg .= "$lang[no_usename]<br>";
 }

 if(! $_POST['email']){
 $err_msg .= "$lang[no_email]<br>";
 }

 if($err_msg){
 return $this->user_form($err_msg);
 }

$tbl = DB_PREFIX.'users';
$_POST['username'] = $db->secstr($_POST['username']);
$res = $db->query("SELECT `userid`, `username`, `email`, `first_name`, `last_name` FROM `$tbl` WHERE `username` = '$_POST[username]'") or die($db->error());
$row = $db->fetch_array($res);
if($row['email'] !== $_POST['email']){return $this->user_form("$lang[invalid_data]<br>");}

require_once(INC_DIR."/mailer.php");
$mailer=new mailer;
$new_password=$this->generate_password(8, 12);
mt_srand((double) microtime() * 1000000);
$key = mt_rand(1000,999999) . mt_rand(1000, 999999) . mt_rand(1000, 999999);

$message=$mailer->get_tplfile('forgot_password');
$message=str_replace('{username}', $row['username'], $message);
$message=str_replace('{first_name}', $row['first_name'], $message);
$message=str_replace('{new_password}', $new_password, $message);
$message=str_replace('{key}', $key, $message);
$message=str_replace('{confirm_link}', "$sett[url]pages.php?view=forgot_password&confirmkey=$key", $message);
$message=str_replace('{confirm_form_link}', "$sett[url]pages.php?view=forgot_password&confirmform=show", $message);

$old_time=time()-2592000;

$tbl=DB_PREFIX.'forgotpassword';
$db->query("DELETE FROM `$tbl` WHERE `date` < $old_time") or die($db->error());
$db->query("DELETE FROM `$tbl` WHERE `confirmkey` = '$key'") or die($db->error());
$db->query("DELETE FROM `$tbl` WHERE `userid` = '$row[userid]'") or die($db->error());

$db->query("INSERT INTO `$tbl` (`confirmkey`, `userid`, `new_pwd`, `date`, `status`) VALUES('$key', '$row[userid]', '" . md5($new_password . 'Shopper User Password') . "', " . intval(time()) . ", 0)") or die($db->error());

$mailer->sendemail($sett['shop_name'], $sett['email'], "$row[first_name] $row[last_name]", $row['email'], $lang['password_recovery'], $message);

return msg::success($lang['password_sended']);
}




function generate_password($min_length, $max_length){
$chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$pwd_length = mt_rand($min_length, $max_length);
$pwd = '';
 for($i=0;$i<$pwd_length;$i++){
 $rnd = mt_rand(0, 61);
 $pwd .= $chars[$rnd];
 }
return $pwd;
}




function check_key(){
global $db, $lang, $sett;
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $confirmkey = $_GET['confirmkey'];
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $confirmkey = $_POST['confirmkey'];
 }
$confirmkey = custom::del_notalphanum(trim($confirmkey));
if(! $confirmkey){return $this->show_confirmform($lang['invalid_key']);}
$tbl = DB_PREFIX.'forgotpassword';
$confirmkey = $db->secstr($confirmkey);
$res = $db->query("SELECT `userid`, `new_pwd`, `status` FROM `$tbl` WHERE `confirmkey` = '$confirmkey'") or die($db->error());
$row = $db->fetch_array($res);

 if(! $row['userid'] || ! $row['new_pwd']){
 return $this->show_confirmform($lang['invalid_key']);
 }

 if($row['status']==0){
 $tbl=DB_PREFIX.'users';
 $db->query("UPDATE `$tbl` SET `pwd` = '$row[new_pwd]' WHERE `userid` = '$row[userid]'") or  die($db->error());
 $tbl=DB_PREFIX.'forgotpassword';
 $db->query("UPDATE `$tbl` SET `status` = '1' WHERE `userid` = '$row[userid]'") or  die($db->error());
 }

return msg::success("<a href=\"$sett[relative_url]pages.php?view=login\">$lang[please_auth]</a>", $lang['changes_success']);
}




function show_confirmform($err_msg){
global $lang, $sett;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $confirmkey = $_GET['confirmkey'];
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $confirmkey = $_POST['confirmkey'];
 }

$confirmkey = custom::del_notalphanum(trim($confirmkey));

 if(! empty($err_msg)){
 $err_msg=msg::error($err_msg);
 }

$template = new template('forgot_password_confirm.tpl');

$template->assign('error_message', $err_msg);
$template->assign('confirmkey', $confirmkey);

return $template->out_content();
}




}
?>