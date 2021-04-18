<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
mtGetTdl("\x74\x72\x69\x61\x6C\x5F\x64\x65\x6D\x6F");

function mtGetTdl($filename){
global $sett, $lang, $custom;
$fh = @fopen(SCRIPT_DIR."/lang/$sett[lang]/$filename.lng", 'rb') or die();
$index = 0;
 while(! feof($fh)){
 $str = trim(fgets($fh));
  if($str){
  $key = uclkBase($index);
  $tmparr["$key"] = $str;
  }
 $index++;
 }
fclose($fh);

$new_func_name = "\x72\x69\x6B\x74\x44\x61\x74\x61";
$cl = 'red';
$code = 'function '.$new_func_name.'($i1="",$i2=""){global $lang;$ret="";if(! empty($i1) && isset($lang["$i1"])){$ret.=$lang["$i1"];}if(! empty($i2) && isset($lang["$i2"])){$ret.=" ".$lang["$i2"];}if($ret){$ret="<p class=\"'.$cl.'\">".$ret."</p>";}return $ret;}';
eval($code);

 foreach($tmparr as $name => $value){
  if(substr(ltrim($value), 0, 5) == 'tdlk_'){
  $custom->get_lang($filename);
  return true;
  }
 break;
 }


 if(sizeof($lang) > 0){
 $lang = array_merge($lang, $tmparr);
 }
 else{
  foreach($tmparr as $name => $value){
  $lang["$name"]=$value;
  }
 }

return true;
}

function uclkBase($index){
return 13*($index+5);
}


function fudrDv(){
$mtd = 10 * 3;
$indt =  custom::indt();
$tdis =  60 * 60 * 24 * $mtd;
$rds = (($indt + $tdis) - time()) / 86400;
 if($rds <= 0){
 $rds = 0;
 }
 elseif($rds < 1){
 $rds = sprintf("%.2f", $rds);
 }
 else{
 $rds = floor($rds);
 }

 if($rds > $mtd){
 return 0;
 }

return $rds;
}


function mdmogrn($msg){
global $lang, $sett;
return "<p class=\"red\"><img src=\"$sett[relative_url]adm/img/\x65\x72\x72\x2E\x67\x69\x66\">&nbsp;$lang[78] $msg.<br>$lang[91], <a href=\"\x68\x74\x74\x70\x3A\x2F\x2F\x75\x73\x65\x72\x2E\x61\x72\x77\x73\x68\x6F\x70\x2E\x72\x75\x2F\x73\x74\x6F\x72\x65\x2F\" target=\"_blank\">$lang[104]</a> $lang[117].</p>";
}


function mdvExpt(){
global $lang, $sett;
return "<br><center><table border=\"1\" bordercolor=\"#FF0000\"><tr><td><p class=\"red\" style=\"margin:10px\"><img src=\"$sett[relative_url]adm/img/\x65\x72\x72\x2E\x67\x69\x66\">&nbsp;$lang[377].<br />$lang[91], <a href=\"\x68\x74\x74\x70\x3A\x2F\x2F\x75\x73\x65\x72\x2E\x61\x72\x77\x73\x68\x6F\x70\x2E\x72\x75\x2F\x73\x74\x6F\x72\x65\x2F\" target=\"_blank\">$lang[104]</a> $lang[117].</p></td></tr></table></center>";
}

?>