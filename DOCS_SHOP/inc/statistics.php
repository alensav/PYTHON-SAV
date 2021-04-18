<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class statistics{


function addlog_visit($def_day, $ip){
global $db;
$tablename=DB_PREFIX.'visitlog';

 if($def_day !== date("d", time())){
 $max_visits_logged = 1000 ;
 $query=$db->query("SELECT COUNT(*) FROM $tablename")or die($db->error());
 $visits_logged=$db->result($query,0,0);
  if($visits_logged > $max_visits_logged){
  $last_date = time() - 259200;
  $db->query("DELETE FROM $tablename WHERE date < $last_date")or die($db->error());

  $query=$db->query("SELECT COUNT(*) FROM $tablename")or die($db->error());
  $visits_logged=$db->result($query,0,0);
   if($visits_logged > $max_visits_logged){
   $last_date = time() - 43200;
   $db->query("DELETE FROM $tablename WHERE date < $last_date")or die($db->error());
   }
  }
 }

$forwarded = '';
 if(! empty($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != $_SERVER['REMOTE_ADDR']){
 $forwarded = $db->cutstr($db->secstr($this->del_no_utf_chars(custom::replace_tags_and_quotes($_SERVER['HTTP_X_FORWARDED_FOR']))), 255);
 }

$request = $db->cutstr($db->secstr(custom::replace_tags_and_quotes($_SERVER['HTTP_HOST']) . $this->del_no_utf_chars(custom::replace_tags_and_quotes($_SERVER['REQUEST_URI']))), 255);

$referer = '';
 if(! empty($_SERVER['HTTP_REFERER'])){
 $referer = $db->cutstr($db->secstr($this->del_no_utf_chars(custom::replace_tags_and_quotes($_SERVER['HTTP_REFERER']))), 4096);
 }

$useragent = '';
 if(! empty($_SERVER['HTTP_USER_AGENT'])){
 $useragent = $db->cutstr($db->secstr($this->del_no_utf_chars(custom::replace_tags_and_quotes($_SERVER['HTTP_USER_AGENT']))), 255);
 }

$db->query("INSERT INTO $tablename (date, ip, forwarded, request, referer, useragent) VALUES('" . time() . "','$ip', '$forwarded', '$request', '$referer', '$useragent')") or die($db->error());
}


function visitors_count(){
 if(strpos($_SERVER['REQUEST_URI'], 'independ=1&scarttype=2') !== false){
 return true;
 }
global $sett, $db;
$tablename=DB_PREFIX.'counter';
$query=$db->query("SELECT * FROM $tablename")or die($db->error());
$row=$db->fetch_array($query);

 $row['allvisits']++;
 $row['todayvisits']++;

 if($row['day'] !== date("d", time())){
 $tablename=DB_PREFIX.'cntlastip';
 $db->query("DELETE FROM $tablename")or die($db->error());
 $row['todayvisits']=1;
 $row['todayhosts']=0;
 }

$tablename=DB_PREFIX.'cntlastip';
$ip = $db->secstr(custom::replace_tags_and_quotes($_SERVER['REMOTE_ADDR']));
$query=$db->query("SELECT COUNT(*) FROM $tablename WHERE lastip = '$ip'")or die($db->error());
 if($db->result($query,0,0) < 1){
 $row['allhosts']++;
 $row['todayhosts']++;
 $db->query("INSERT INTO $tablename (lastip) VALUES('$ip')") or die($db->error());
 }

$tablename=DB_PREFIX.'counter';
$db->query("UPDATE $tablename SET allvisits='$row[allvisits]', allhosts='$row[allhosts]', todayvisits='$row[todayvisits]', todayhosts='$row[todayhosts]', day='" . date("d", time()) . "'")or die($db->error());

if($sett['visitlog']){$this->addlog_visit($row['day'], $ip);}
}



function del_no_utf_chars($str){
 if(! preg_match('/./u', $str)){
 $str = preg_replace('/[\x80-\xFF]/', '?', $str);
 }
return $str;
}



}
?>