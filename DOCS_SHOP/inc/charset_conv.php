<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class charset_conv{

private static $def_charset = 'utf-8';
private static $utf8conv_loaded = false;
private static $mb_convert_err = false;


private static function load_utf8conv(){
require_once(INC_DIR."/utf8_conv.php");
self::$utf8conv_loaded = true;
}

public static function detect_charset($str){
$len=strlen($str);
 if($len==0){
 return '';
 }
 if(preg_match('/./u', $str)){
 return 'utf-8';
 }
$charsets = array(
'win1251'=>array('charset'=>'windows-1251', 'count'=>0),
'koi8r'=>array('charset'=>'koi8-r', 'count'=>0),
'koi8u'=>array('charset'=>'koi8-u', 'count'=>0)
);
 for($i=0;$i<$len;$i++){
 $code=ord($str[$i]);
  if(($code>223 and $code<256) or ($code==179) or ($code==180) or ($code==184) or ($code==186) or ($code==191)){
  $charsets['win1251']['count']++;
  }
  if(($code>191 and $code<224) or ($code==163)){
  $charsets['koi8r']['count']++;
  }
  if(($code>191 and $code<224) or ($code==164) or ($code==166) or ($code==167) or ($code==173)){
  $charsets['koi8u']['count']++;
  }
 }
$max=0;
$maxname='';
 foreach($charsets as $name => $arr){
  if($arr['count'] > $max){
  $max=$arr['count'];
  $maxname=$name;
  }
 }
 if($max==0){
 return '';
 }
return $charsets["$maxname"]['charset'];
}


public static function recode_str($str, $from_charset, $to_charset){
 if($str === ''){
 return $str;
 }
$from_charset=strtoupper($from_charset);
$to_charset=strtoupper($to_charset);

 if($from_charset == $to_charset){
 return $str;
 }

 if(function_exists('mb_convert_encoding')){
 self::$mb_convert_err = false;
 set_error_handler(array('self', 'calbk1'), E_ALL);
 $newstr = mb_convert_encoding($str, $to_charset, $from_charset);
 restore_error_handler();
  if(! self::$mb_convert_err && ! empty($newstr)){
  return $newstr;
  }
 }

 if(function_exists('iconv')){
 $newstr = @iconv($from_charset, $to_charset.'//IGNORE', $str);
  if(! empty($newstr)){
  return $newstr;
  }
 }

 if(! self::$utf8conv_loaded){
 self::load_utf8conv();
 }

$newstr = utf8_conv::convert($str, $from_charset, $to_charset);
 if(! empty($newstr)){
 return $newstr;
 }

return $str;  
}


public static function auto_recode($str, $to_charset = ''){
 if(empty($to_charset)){
 $to_charset = self::$def_charset;
 }
$from_charset = self::detect_charset($str);
 if(! empty($from_charset)){
 return self::recode_str($str, $from_charset, $to_charset);
 }
return $str;
}


public static function calbk1($errno, $errstr){
self::$mb_convert_err = true;
}


public static function charsets_selectbox($selected_charset, $show_only_engine_charsets = false){
$selected_charset = strtolower($selected_charset);
$charsets = array('utf-8');

$dirname = INC_DIR."/charsets";
 if(is_dir($dirname)){
 $dh = opendir($dirname);
  while(($file = readdir($dh)) !== false){
  $l = strlen($file);
   if(substr($file, $l - 4) == '.php'){
   array_push($charsets, substr($file, 0, $l - 4));
   }
  }
 closedir($dh);
 }

 if(! $show_only_engine_charsets && function_exists('mb_list_encodings')){
 $charsets_mb = mb_list_encodings();
  foreach($charsets_mb as $charset){
  $charset = strtolower($charset);
   if(! empty($charset) && $charset !== 'auto' && ! in_array($charset, $charsets)){
   array_push($charsets, $charset);
   }
  }
 }

sort($charsets);

$ret = '<select name="sel_charset"><option value=""></option>';
 foreach($charsets as $charset){
  if($charset == $selected_charset){
  $selected = ' selected="selected"';
  }
  else{
  $selected = '';
  }
  if($charset == 'windows-1251'){
  $hint = ' (Cyrillic)';
  }
  elseif($charset == 'utf-8'){
  $hint = ' (default)';
  }
  else{
  $hint = '';
  }
 $ret .= '<option value="'.$charset.'"'.$selected.'>'.$charset.$hint.'</option>';
 }
$ret .= '</select>';
return $ret;
}



}
?>