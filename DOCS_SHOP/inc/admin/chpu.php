<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class chpu{

private static $chpu_chars = array();


public static function init(){
self::$chpu_chars = custom::get_lang('translit_url', false);
}


public static function autoName($chpu, $str, $def_value, $add_ending){
global $admset;
$chpu = preg_replace("/[^0-9a-zA-Z\x80-\xFF\x20\_\-]/", '', trim($chpu));
 if($chpu){
 return $chpu;
 }
 if($def_value == '0'){
 $def_value = '';
 }
 if(empty($admset['chpu_auto_translit'])){
 return $def_value;
 }
$str = strip_tags($str);
$str = str_replace('&quot;', '', $str);
$str = str_replace('&#39;', '', $str);
$str = strtr($str, self::$chpu_chars);
$str = preg_replace_callback('/([A-Z]{2,3})([a-z]{1,})/', array('self', 'translit_ucfirst'), $str);
$str = preg_replace("/[^0-9a-zA-Z\x09\x20\_\-]/", ' ', $str);
$str = preg_replace("/[\x09\x20\x0D\x0A]+/", '-', trim($str));
$str = preg_replace("/[\-]+/", '-', $str);
 if($str){
  if($add_ending){
   if(! $def_value){
   $def_value = rand(10000000, 999000000);
   }
  return $str.'-'.$def_value;
  }
  else{
  return $str;
  }
 }
return $def_value;
}



private static function translit_ucfirst($matches){
return ucfirst(strtolower($matches[0]));
}



}
chpu::init();

?>