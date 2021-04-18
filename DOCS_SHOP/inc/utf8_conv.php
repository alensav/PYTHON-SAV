<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class utf8_conv{

private static $loaded_charset = '';
private static $to_utf8 = array();
private static $from_utf8 = array();

public static function utf8_to_othercharset($str){
return strtr($str, self::$from_utf8);
}

public static function othercharset_to_utf8($str){
return strtr($str, self::$to_utf8);
}

private static function load_charset($charset){
$charset = preg_replace('/[^a-zA-Z0-9\/\_\-]/', '', $charset);
 if(! is_file(INC_DIR.'/charsets/'.$charset.'.php')){
 die(get_class().': Unsupported charset '.$charset);
 }
include(INC_DIR.'/charsets/'.$charset.'.php');
self::$to_utf8 = $to_utf8_chars;
self::$from_utf8 = array_flip(self::$to_utf8);
self::$loaded_charset = $charset;
return true;
}

public static function convert($str, $from_charset, $to_charset){
$from_charset=strtolower($from_charset);
$to_charset=strtolower($to_charset);
 if($from_charset === $to_charset){
 return $str;
 }

$other_charset = '';
 if($from_charset === 'utf-8'){
 $other_charset = $to_charset;
 }
 elseif($to_charset === 'utf-8'){
 $other_charset = $from_charset;
 }
 else{
 return $str;
 }

 if($other_charset !== self::$loaded_charset){
 self::load_charset($other_charset);
 }

 if($to_charset === 'utf-8'){
 return self::othercharset_to_utf8($str);
 }
 elseif($from_charset === 'utf-8'){
 return self::utf8_to_othercharset($str);
 }

return $str;
}


}

?>