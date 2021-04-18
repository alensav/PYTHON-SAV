<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
function mb_substr($str, $start, $length = null, $encoding = ''){
preg_match_all( '/./us', $str, $matches);
 if(count($matches[0]) == 0){
  if($length === null){
  return substr($str, $start);
  }
  else{
  return substr($str, $start, $length);
  }
 }
 if($length === null){
 $chars = array_slice($matches[0], $start);
 }
 else{
 $chars = array_slice($matches[0], $start, $length);
 }
return implode('', $chars);
}


function mb_strlen($str, $encoding = ''){
preg_match_all( '/./us', $str, $matches);
$count = count($matches[0]);
 if($count == 0){
 return strlen($str);
 }
return $count;
}


function mb_strpos($haystack, $needle, $offset = 0, $encoding = ''){
 if($offset < 0){
 echo '<br>mb mb_strpos(): Invalid negative offset!</br>';
 $offset = 0;
 }
 if(! preg_match('/./u', $haystack)){
 return strpos($haystack, $needle, $offset);
 }
 if($offset > 0){
 $haystack = mb_substr($haystack, $offset);
 }
$pos = strpos($haystack, $needle);
 if($pos === false){
 return false;
 }
return $offset + mb_strlen(substr($haystack, 0, $pos));
}


function mb_strrpos($haystack, $needle, $offset = 0, $encoding = ''){
 if(! preg_match('/./u', $haystack)){
 return strrpos($haystack, $needle, $offset);
 }
$start = 0;
 if($offset > 0){
 $start = strlen(mb_substr($haystack, 0, $offset));
 }
 elseif($offset < 0){
 $start = -strlen(mb_substr($haystack, $offset));
 }
$pos = strrpos($haystack, $needle, $start);
 if($pos === false){
 return false;
 }
return mb_strlen(substr($haystack, 0, $pos));
}


function mb_strtolower($str, $encoding = ''){
 if(preg_match('/./u', $str)){
 return setlocale_func::lower_str($str, 'utf-8');
 }
return strtolower($str);
}




class setlocale_func{



private static $utf8_upp_low_chars = array("\x41"=>"\x61","\x42"=>"\x62","\x43"=>"\x63","\x44"=>"\x64","\x45"=>"\x65","\x46"=>"\x66","\x47"=>"\x67","\x48"=>"\x68","\x49"=>"\x69","\x4A"=>"\x6A","\x4B"=>"\x6B","\x4C"=>"\x6C","\x4D"=>"\x6D","\x4E"=>"\x6E","\x4F"=>"\x6F","\x50"=>"\x70","\x51"=>"\x71","\x52"=>"\x72","\x53"=>"\x73","\x54"=>"\x74","\x55"=>"\x75","\x56"=>"\x76","\x57"=>"\x77","\x58"=>"\x78","\x59"=>"\x79","\x5A"=>"\x7A","\xD0\x83"=>"\xD1\x93","\xD0\x82"=>"\xD1\x92","\xD0\x89"=>"\xD1\x99","\xD0\x8A"=>"\xD1\x9A","\xD0\x8C"=>"\xD1\x9C","\xD0\x8B"=>"\xD1\x9B","\xD0\x8F"=>"\xD1\x9F","\xD0\x8E"=>"\xD1\x9E","\xD0\x86"=>"\xD1\x96","\xD2\x90"=>"\xD2\x91","\xD0\x81"=>"\xD1\x91","\xD0\x84"=>"\xD1\x94","\xD0\x88"=>"\xD1\x98","\xD0\x85"=>"\xD1\x95","\xD0\x87"=>"\xD1\x97","\xD0\x90"=>"\xD0\xB0","\xD0\x91"=>"\xD0\xB1","\xD0\x92"=>"\xD0\xB2","\xD0\x93"=>"\xD0\xB3","\xD0\x94"=>"\xD0\xB4","\xD0\x95"=>"\xD0\xB5","\xD0\x96"=>"\xD0\xB6","\xD0\x97"=>"\xD0\xB7","\xD0\x98"=>"\xD0\xB8","\xD0\x99"=>"\xD0\xB9","\xD0\x9A"=>"\xD0\xBA","\xD0\x9B"=>"\xD0\xBB","\xD0\x9C"=>"\xD0\xBC","\xD0\x9D"=>"\xD0\xBD","\xD0\x9E"=>"\xD0\xBE","\xD0\x9F"=>"\xD0\xBF","\xD0\xA0"=>"\xD1\x80","\xD0\xA1"=>"\xD1\x81","\xD0\xA2"=>"\xD1\x82","\xD0\xA3"=>"\xD1\x83","\xD0\xA4"=>"\xD1\x84","\xD0\xA5"=>"\xD1\x85","\xD0\xA6"=>"\xD1\x86","\xD0\xA7"=>"\xD1\x87","\xD0\xA8"=>"\xD1\x88","\xD0\xA9"=>"\xD1\x89","\xD0\xAA"=>"\xD1\x8A","\xD0\xAB"=>"\xD1\x8B","\xD0\xAC"=>"\xD1\x8C","\xD0\xAD"=>"\xD1\x8D","\xD0\xAE"=>"\xD1\x8E","\xD0\xAF"=>"\xD1\x8F");

private static $utf8_low_upp_chars = array();


public static function lower_str($str, $encoding = ''){
 if($encoding === 'utf-8'){
 return strtr($str, self::$utf8_upp_low_chars);
 }
 elseif($encoding === 'windows-1251'){
 return strtolower(strtr($str, self::$win1251_upp_chars, self::$win1251_low_chars));
 }
 else{
 return strtolower($str);
 }
}



}



?>