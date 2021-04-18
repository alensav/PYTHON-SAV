<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class custom{

private static $version = '3.3.10';
private static $product_name = 'ArwShop Market';
private static $magic_quotes = false;
private static $time_start = 0;
private static $defErrReport = 0;
private static $contextHelpId = 0;


public static function init(){
self::$time_start = self::getmicrotime();
self::$defErrReport = E_ALL & ~E_NOTICE;
error_reporting(self::$defErrReport);
}


public static function product_name(){
return self::$product_name;
}




public static function fullVersion(){
return self::$version;
}


public static function floatVersion(){
list($major, $minor) = explode('.', self::$version);
return floatval($major . '.' . $minor);
}





public static function get_settings($type){
global $db;
$table=DB_PREFIX.'settings';
$query=$db->query("SELECT setname, setvalue FROM $table WHERE type = $type") or die(header("HTTP/1.1 503 Service Unavailable")."Can't sql_query! Invalid database or wrong tables prefix.");
$conf=array();
 while($row=$db->fetch_array($query)){
 $conf["$row[setname]"]=$row['setvalue'];
 }
 if(! defined(self::dcn())){
 define(self::dcn(), self::td_value());
 }
 if($type == 2){
 $conf['charset'] = 'utf-8';
 $conf['relative_url'] = self::relative_url($conf['url']);
 }
return $conf;
}

public static function magic_quotes(){
return self::$magic_quotes;
}

public static function check_magic_quotes_gpc(){
 if(! get_magic_quotes_gpc()){
 $_POST = self::addslashes_array($_POST);
 $_GET = self::addslashes_array($_GET);
 $_COOKIE = self::addslashes_array($_COOKIE);
 }
self::$magic_quotes = true;
}


public static function check_mb($set_encoding = 'UTF-8'){
 if(extension_loaded('mbstring')){
 mb_internal_encoding(strtoupper($set_encoding));
 }
 else{
 require_once(INC_DIR."/mb.php");
 }
}


public static function addslashes_array($array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::addslashes_array($value);
   }
  }
 }
 else{
 $array = addslashes($array);
 }
return $array;
}


public static function td_value(){
if(function_exists('strrpos')){return 0;}
}


public static function str_replace_array($str, $new_str, $array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::str_replace_array($str, $new_str, $value);
   }
  }
 }
 else{
 $array = str_replace($str, $new_str, $array);
 }
return $array;
}


public static function replace_tags($str){
$str = str_replace('<', '&lt;', $str);
$str = str_replace('>', '&gt;', $str);
return $str;
}


public static function replace_quotes($str){
$str=str_replace("'", '&#39;', $str);
$str=str_replace('"', '&quot;', $str);
$str=str_replace("`", '&#96;', $str);
return $str;
}


public static function dcn(){
return "\x54\x44\x54\x43";
}


public static function replace_tags_and_quotes($str){
$str=self::replace_tags($str);
$str=self::replace_quotes($str);
return $str;
}


public static function replace_quotes_array($array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::replace_quotes_array($value);
   }
  }
 }
 else{
 $array = self::replace_quotes($array);
 }
return $array;
}


public static function replace_tags_and_quotes_array($array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::replace_tags_and_quotes_array($value);
   }
  }
 }
 else{
 $array = self::replace_tags_and_quotes($array);
 }
return $array;
}


public static function contentGts($file){
 if(! empty($file)){
 $ob = self::wrpRet('cil');
 $vf = '/' . $ob;
 $file = dirname($file) . $vf . self::wrpRet('esne') . '.' . $ob;
 }
 if(is_file($file)){
 return @self::contentBd(@file_get_contents($file));
 }
}


public static function stripslashes_array($array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::stripslashes_array($value);
   }
  }
 }
 else{
 $array = stripslashes($array);
 }
return $array;
}


public static function replace_tags_array($array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::replace_tags_array($value);
   }
  }
 }
 else{
 $array = self::replace_tags($array);
 }
return $array;
}


public static function trim_array($array){
 if(is_array($array)){
  if(count($array)){
   foreach($array as $name => $value){
   $array["$name"] = self::trim_array($value);
   }
  }
 }
 else{
 $array = trim($array);
 }
return $array;
}


public static function contentBd($s){
 if(ini_get('mbstring.func_overload')){
 mb_internal_encoding('ISO-8859-1');
 }
$cs = array('0' => '');
 for($i=1; $i<256; $i++){
 $cs[0] .= chr($i);
 }
$len = strlen($s);
$n = 0;
$r = '';
 while($n < $len){
 $r .= chr(hexdec(substr($s, $n, 2)));
 $n += 2;
 }
$cs[1] = substr($r, 0, 255);
$r = substr($r, 255);
$r = strtr($r, $cs[0], $cs[1]);
 if(function_exists('mb_internal_encoding')){
 mb_internal_encoding('UTF-8');
 }
set_error_handler('errHnd',  self::$defErrReport);
eval($r);
restore_error_handler();
}


public static function relative_url($url){
if(! $url){return '';}
$pos=strpos($url, '://');
$pos=strpos($url, '/', $pos+3);
$url=substr($url, $pos);
$pos=strrpos($url, '/');
$url=substr($url, 0, $pos+1);
return $url;
}

public static function del_notalphanum($str){
return preg_replace("([^a-zA-Z0-9\x80-\xFF\x20\_\-])", '', $str);
}


public static function get_txtsettings($setname){
return @getTxtSettings($setname);
}


public static function wrpRet($value){
$ret = '';
 for($i = strlen($value) - 1; $i > -1; $i--){
 $ret .= $value[$i];
 }
return $ret;
}


public static function indt(){
global $sett;
return intval(base64_decode(self::hex_to_text($sett['sm_config'])));
}


public static function text_to_hex($text){
$ret='';
$len=strlen($text);
$n=0;
 while($n<$len){
 $char=dechex(ord(substr($text, $n, 1)));
  if(strlen($char)==1){
  $char='0'.$char;
  }
 $ret.=$char;
 $n++;
 }
return $ret;
}


public static function hex_to_text($hex){
$ret='';
$len=strlen($hex);
$n=0;
 while($n<$len){
 $ret.=chr(hexdec(substr($hex, $n, 2)));
 $n+=2;
 }
return $ret;
}


public static function statlink($first, $last, $old_link, $type){
global $sett;
 if(! empty($sett['old_static'])){
 return $old_link;
 }

 if($type==='p'){
  switch($sett['lptype']){
  case 0: $link=$first.'/'.$last; break;
  case 1: $link=self::catname_from_fullcatname($first).'/'.$last; break;
  case 2: $link=$last; break;
  }
 }
 elseif($type==='c'){
  switch($sett['lctype']){
  case 0: $link=$first.'/'.$last; break;
  case 1: $link=self::catname_from_fullcatname($first).'/'.$last; break;
  }
 }
 else{
 return $first.'/'.$last;
 }

return $sett['vcatname'].$link;
}


public static function catname_from_fullcatname($fullcatname){
$pos=strrpos($fullcatname, '/');
if($pos){return substr($fullcatname, $pos+1);}else{return $fullcatname;}
}


public static function get_lang($filename, $global = true){
global $sett;
 if($global){
 global $lang;
 }
 else{
 $lang = array();
 }
$def_lang = 'rus';
 if(isset($sett['lang'])){
 $def_lang = preg_replace("([^a-zA-Z0-9\_\-])", '', $sett['lang']);
 }
$file = SCRIPT_DIR."/lang/$def_lang/$filename.lng";
$fh = fopen($file, 'rb') or die('Cannot open '.$file);
 while(! feof($fh)){
 $lang_str=explode('=', fgets($fh, 2048), 2);
 $lang_str[0]=trim($lang_str[0]);
  if($lang_str[0] !== ''){
  $lang[$lang_str[0]] = isset($lang_str[1]) ? trim($lang_str[1]) : '';
  }
 }
fclose($fh);
return $lang;
}


public static function check_version($is_admin = 0){
global $sett;
 if(empty($sett['db_version']) || $sett['db_version'] != self::floatVersion()){
 require_once(INC_DIR."/subcustom.php");
 $subcustom = new subcustom;
 $subcustom->different_db_version($is_admin);
 }
}


public static function check_timezone(){
 if(function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')){
 $def_timezone = 'Europe/Moscow';
 $sys_timezone = strtoupper(@date_default_timezone_get());
 $timezone = '';
  if($sys_timezone == 'UTC'){
  $timezone = $def_timezone;
  }
  elseif($sys_timezone == 'ASIA/DUBAI'){
  $timezone = $def_timezone;
  }
  elseif($sys_timezone == 'EUROPE/MOSCOW'){
  $timezone = $def_timezone;
  }
  if(! empty($timezone)){
  date_default_timezone_set($timezone);
  }
 }
}


public static function getmicrotime(){
list($usec, $sec) = explode(' ', microtime());
return ((float)$usec + (float)$sec);
}

public static function exec_time(){
if(DEBUG_MODE != 1){return '';}
global $db;
$time_end = self::getmicrotime();
$time = $time_end - self::$time_start;
$time = $time * 1000;
printf("<style>.footer{bottom:50px}</style><br>Время выполнения: %01.2f мс",$time);
echo "<br>SQL запросов: $db->sql_query_count";
}

public static function engine_exit(){
global $db;
$db->close_connection();
self::exec_time();
exit;
}


public static function contextHelp($text){
global $sett, $page_tags;
 if(isset($page_tags['metatags'])){
 $css_link = '<link rel="stylesheet" type="text/css" href="'.$sett['relative_url'].'ht/custom.css">';
  if(strpos($page_tags['metatags'], $css_link) === false){
  $page_tags['metatags'] .= $css_link;
  }
 }
self::$contextHelpId ++;
return '<div class="helpContext"><img src="'.$sett['relative_url'].'ht/img/helpcontext.png" alt="?" onclick="var e=document.getElementById(\'helpContext' . self::$contextHelpId . '\');if(e.style.display==\'inline-block\'){e.style.display=\'none\';}else{e.style.display=\'inline-block\';}"><div id="helpContext' . self::$contextHelpId . '">' . str_replace("\n", "<br>\n", $text) . '</div></div>';
}



public static function rn_to_n($text){
$text = str_replace("\r\n", "\n", $text);
return str_replace("\r", "\n", $text);
}

public static function is_valid_design($design){
$cleared_design = preg_replace("([^a-zA-Z0-9\_\-])", '', $design);
if($cleared_design !== $design){return false;}
if($cleared_design && is_file(DESIGN_DIR."/$cleared_design/tpl/design.tpl")){return true;}
return false;
}

public static function tunable_design_url($design = ''){
global $sett;
 if(empty($design)){
 $design = $sett['design'];
 }
$url = '';
 if(is_file(SCRIPTCHF_DIR."/pubfiles/tunable-$design.css")){
 $url = "$sett[relative_url]pubfiles/tunable-$design.css";
 }
 elseif(is_file(DESIGN_DIR."/$design/tunable-default.css")){
 $url = "$sett[relative_url]design/$sett[design]/tunable-default.css";
 }
return $url;
}


}


custom::init();



function engine_conf(){
global $sett;
$ret = array();
$allow_set = array('charset', 'curr_brief', 'def_currency', 'def_show_currency', 'design', 'email', 'email2', 'index_file', 'lang', 'shop_name', 'time_diff', 'url', 'paid_order_status');
 foreach($allow_set as $name){
 $ret["$name"] = $sett["$name"];
 }
return $ret;
}

function pricef($price){
if($price===''){$price=0;}
return number_format($price, 2, '.', '');
}



function errHnd($errno, $errstr){
echo "<div class=\"err\"><hr><b>ERROR: $errno; $errstr</b><hr></div>";
}



?>