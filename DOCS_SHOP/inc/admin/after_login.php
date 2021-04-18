<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

class after_login{


public static function check(){
global $lang, $sett;
custom::get_lang('admin_lang/after_login');
 
$msg = '';

 if(! self::valid_url()){
 $msg .= $lang['al_invalid_engine_url']."<br>";
 }

 if(! file_exists(SCRIPT_DIR.'/.htaccess') || filesize(SCRIPT_DIR.'/.htaccess') == 0){
 $msg .= $lang['no_htaccess']."<br>";
 }
 elseif(! empty($sett['static_urls'])){
 $actual_relative_url = self::actualRelativeUrl();
  if(! preg_match("#RewriteBase[\x20\x09]+$actual_relative_url\n#", custom::rn_to_n(file_get_contents(SCRIPT_DIR.'/.htaccess')))){
  $msg .= $lang['invalid_rewrite_base']." <a href=\"http://www.arwshop.ru/tech-docs/mod_rewrite.html\" target=\"_blank\">$lang[rewrite_base_help]</a><br>";
  }
 }

 if(file_exists(SCRIPT_DIR.'/reset_password.php')){
 $msg .= $lang['reset_password_not_deleted']."<br>";
 }

 if(! empty($msg)){
 require_once(INC_DIR.'/msg.php');
 return msg::error($msg, $lang['al_warning']);
 }

return '';
}


private static function valid_url(){
global $sett;
 if(! isset($_SERVER['HTTP_HOST'])){
 return true;
 }

$true_domain = self::domain_from_url($_SERVER['HTTP_HOST'], true);
 if(! self::in_punycode_domain($true_domain) && self::domain_from_url($sett['url'], true) != $true_domain){
 return false;
 }

 if($sett['relative_url'] != self::actualRelativeUrl()){
 return false;
 }

return true;
}



private static function actualRelativeUrl(){
$actual_relative = $_SERVER['REQUEST_URI'];
$pos = strrpos($actual_relative, '/');
 if($pos !== false){
 $actual_relative = substr($actual_relative, 0, $pos + 1);
 }
return $actual_relative;
}




private static function domain_from_url($url, $delete_www){
$domain = strtolower(trim($url));
$domain = str_replace("\\", '/', $domain);
$pos = strpos($domain, '://');
 if($pos !== false){
 $domain = substr($domain, $pos + 3);
 }
$pos = strpos($domain, '/');
 if($pos !== false){
 $domain = substr($domain, 0, $pos);
 }
 if(substr($domain, strlen($domain) - 1) === '.'){
 $domain = substr($domain, 0, strlen($domain) - 1);
 }
 if($delete_www && substr($domain, 0, 4) === 'www.'){
  if(substr_count($domain, '.') > 1){
  $domain = substr($domain, 4);
  }
 }
return $domain;
}


private static function in_punycode_domain($domain){
$domain = mb_strtolower($domain);
 if(substr($domain, 0, 4) == 'xn--'){
 return true;
 }
return false;
}


}
?>