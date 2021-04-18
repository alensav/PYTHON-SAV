<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php




class sys_req{

private static $req_php_ver = '5.0.5';

private static $req_mysql_ver = '5.0.3';

private static $req_php_extensions = array('mysqli');


private static $last_error = '';


public static function check_sys_requirements($lang, &$db = null){
$err_vesrsions = '';
$err_req_ext = '';
$fail_res = array();
$phpversion = phpversion();
 if(version_compare($phpversion, self::$req_php_ver) < 0){
 $err_vesrsions .= "$lang[sr_req_php_ver]: " . self::$req_php_ver . ". $lang[sr_your_version]: $phpversion.<br>";
 }

 if($db !== null){
 $mysql_version = self::sql_server_full_version($db);
  if(version_compare($mysql_version, self::$req_mysql_ver) < 0){
  $err_vesrsions .= "$lang[sr_req_mysql_ver]: " . self::$req_mysql_ver . ". $lang[sr_your_version]: $mysql_version.<br>";
  }
 }

 if(count(self::$req_php_extensions)){
  foreach(self::$req_php_extensions as $extension){
   if(! extension_loaded($extension)){
   $err_req_ext .= "$extension - $lang[sr_ext_missing].<br>";
   }
  }
 }

 if(! empty($err_req_ext)){
 $err_req_ext = "<b>$lang[sr_req_php_extensions]:</b><br>" . $err_req_ext;
 }

self::$last_error = '';

 if(! empty($err_vesrsions) || ! empty($err_req_ext)){
 self::$last_error = "<div style=\"color:#ff0000;\"><h1>$lang[sr_not_match_requirements]:</h1>$err_vesrsions$err_req_ext</div>";
 $result = false;
 }
 else{
 $result = true;
 }

return $result;
}


public static function last_error(){
return self::$last_error;
}


public static function sql_server_full_version(&$db = null){
$res = $db->query("SELECT VERSION()") or die($db->error());
$version = $db->result($res) or die($db->error());
return $version;
}


}

?>