<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }
 
global $engineconf, $robokassa, $rcconf, $language;
$engineconf = engine_conf();
require_once(PM_MODULES_DIR."/robokassa/robokassa.php");
$robokassa=new robokassa;
$robokassa->loadlng(1);

 if(sys_version() < 2.1){
 die("<p>$language[version_required]</p>");
 }

$rcconf=$robokassa->getrcconfig();

$rcadmin=new rcadmin;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = $_GET['act'];
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 }
 else{
 $act = '';
 }

$act = preg_replace("([^a-z0-9\_])", '', $act);

 switch($act){
 
 case 'settings':
 include(PM_MODULES_DIR."/robokassa/admin/settings.php");
 break;

 case 'order_info':
 echo $rcadmin->order_info();
 break;
 
 default: echo 'Invalid argument &quot;act&quot;';
 }



class rcadmin{

function updateconfig(){
global $language, $rcconf, $robokassa;

if(! admin_access()){return "<p class=\"red\">$language[nosave_perms]</p>";}

//if($err_msg){return $err_msg;}

$tbl=DB_PREFIX.'pm_settings`';

$_POST['conf']['pass1'] = base64_encode($robokassa->getedd($_POST['conf']['pass1'], 'robokassa'));
$_POST['conf']['pass2'] = base64_encode($robokassa->getedd($_POST['conf']['pass2'], 'robokassa'));

$this->setdbsettings($_POST['conf']);
$rcconf=$robokassa->getrcconfig();
return 1;
}


function setdbsettings($newconf){
global $db;
$tablename=DB_PREFIX.'pm_settings';
 if(is_array($newconf)){
  foreach($newconf as $sname => $svalue){
  $sname = $db->secstr($sname);
  $svalue=stripslashes(trim($svalue));
  $svalue=str_replace('"','&quot;',$svalue);
  $svalue=str_replace("'",'&#39;',$svalue);
  $svalue=str_replace("`",'&#96;',$svalue);
  $svalue=mb_substr($db->secstr($svalue), 0, 255);
  $result = $db->query("SELECT COUNT(*) AS NUM_ROWS FROM `$tablename` WHERE `mod_name` = 'robokassa' AND `sname` = '$sname'");
   if($db->result($result)>0){
   $db->query("UPDATE `$tablename` SET `svalue` = '$svalue' WHERE `mod_name` = 'robokassa' AND `sname` = '$sname'") or die($db->error());
   }
   else{
   $db->query("INSERT INTO `$tablename` (`mod_name`, `sname`, `svalue`) VALUES ('robokassa', '$sname', '$svalue')") or die($db->error());
   }
  }
 }
return true;
}


function order_info(){
global $language;
return "<p>$language[no_pm_info]</p>";
}



}
?>