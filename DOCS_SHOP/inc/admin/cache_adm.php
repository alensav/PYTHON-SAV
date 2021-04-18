<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class cache_adm{

function clear_cache(){
global $db;
$tbl_cache=DB_PREFIX.'cache';
$db->query("DELETE FROM `$tbl_cache`") or die($db->error());
$db->query("ALTER TABLE `$tbl_cache` AUTO_INCREMENT = 1") or die($db->error());
$dir=SCRIPTCHF_DIR."/ecache";
$dh=opendir($dir);
if(! $dh){return false;}
 while(($fname = readdir($dh)) !== false){
  if($fname !== '.' && $fname !== '..'){
   if(is_dir("$dir/$fname")){
   $dh2=opendir("$dir/$fname");
    if($dh2){
     while(($fname2 = readdir($dh2)) !== false){
      if($fname2 !== '.' && $fname2 !== '..'){
      @unlink("$dir/$fname/$fname2");;
      }
     }
    }
   @rmdir("$dir/$fname");
   }
  }
 }
closedir($dh);
return true;
}


function ceil1000($n){
$l=$n % 1000 ;
if($l>0 && $l<500){$n+=500;}
return round($n, -3);
}


function delete_from_cache($reqid, $request, $clear_only){
global $db, $sett;
$tbl_cache=DB_PREFIX.'cache';
 if($reqid == 0 && $request !== ''){
 $request=$db->secstr(substr($request, strlen($sett['relative_url'])));
 $res=$db->query("SELECT * FROM `$tbl_cache` WHERE `request` = ''") or die($db->error());
 $row=$db->fetch_array($res);
 if(! $row['reqid']){return false;}
 $reqid=$row['reqid'];
 }
 if($clear_only){
 $db->query("UPDATE `$tbl_cache` SET `mdate` = 0 WHERE `reqid` = $reqid") or die($db->error());
 }
 else{
 $db->query("DELETE FROM `$tbl_cache` WHERE `reqid` = $reqid") or die($db->error());
 }
$dir=$this->ceil1000($reqid)/1000;
return unlink(SCRIPT_DIR."/ecache/$dir/$row[reqid].ec");
}


}
?>