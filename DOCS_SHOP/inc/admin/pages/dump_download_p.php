<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(! $admin_lib->check_admin_perms()){
 echo $admin_lib->nosave_perms_msg();
 $db->close_connection();
 exit;
 }

$dirname=SCRIPTCHF_DIR."/adm/dump";

$filename=preg_replace("([^a-z0-9\_\.\-])", '', $_GET['df']);
$filename = preg_replace("(\.\.)", '', $filename);

 if(substr($filename, strlen($filename)-4) !== '.sql' && substr($filename, strlen($filename)-3) !== '.gz'){
 $db->close_connection();
 exit;
 }

 if(file_exists("$dirname/$filename")){
 header("Pragma: no-cache");
 header("Cache-Control: no-cache, must-revalidate");
 header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
 header("Content-Type: application/octet-stream; name=\"$filename\"");
 header("Content-disposition: attachment; filename=$filename");
 $fh=@fopen("$dirname/$filename","rb");
  while(! feof($fh)){
  echo @fread($fh, 65536);
  }
 @fclose($fh);
 }
?>