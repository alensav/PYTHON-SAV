<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $page_tags, $lang;
$custom->get_lang('forgot_password');
$page_tags['meta_title']="$lang[password_recovery] - $sett[pages_title]";

require_once(INC_DIR."/forgot_password.php");
$forgot_password=new forgot_password;

 if(! empty($_POST['send_forgot_password_key'])){
 echo $forgot_password->send_key();
 }
 elseif(! empty($_GET['confirmkey']) || ! empty($_POST['confirmkey'])){
 echo $forgot_password->check_key();
 }
 elseif(isset($_GET['confirmform']) && $_GET['confirmform'] == 'show'){
 echo $forgot_password->show_confirmform('');
 }
 else{
 echo $forgot_password->user_form('');
 }
?>