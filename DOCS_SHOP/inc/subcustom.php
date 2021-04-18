<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class subcustom{

function different_db_version($is_admin){
global $lang, $custom, $sett;
$custom->get_lang('db_version');

 if(empty($sett['db_version'])){
 $current_db_version = 'unknown (1.0)';
 }
 else{
 $current_db_version = $sett['db_version'];
 }

 if(file_exists(SCRIPT_DIR."/update/index.php")){

  if($is_admin && ! empty($_SESSION['arwshop_mk']['mcinfo']['key'])){
  $go_to_update = "$lang[go_to_update_admin] <a href=\"$sett[url]update/index.php\" target=\"_blank\" style=\"color:#0000FF\">$sett[url]update/index.php</a>";
  }
  else{
  $go_to_update = $lang['go_to_update'];
  }

 $this->system_warning("$lang[invalid_db_version]<br>$lang[current_script_version] ".$custom->floatVersion()."<br>$lang[current_db_version] $current_db_version<br>$go_to_update");
 }
 else{
 $this->system_warning("$lang[invalid_db_version]<br>$lang[current_script_version] ".$custom->floatVersion()."<br>$lang[current_db_version] $current_db_version<br>$lang[update_not_found]<br>$lang[db_version_errors] <a href=\"$sett[url]update/index.php\" target=\"_blank\" style=\"color:#0000FF\">$sett[url]update/index.php</a><br>$lang[ftp_client_errors]");
 }
}



function system_warning($msg){
 if(isset($_GET['view']) && $_GET['view'] == 'download_dump'){
 return false;
 }
global $sett, $lang;

 if(isset($lang['system_warning'])){
 $system_warning = $lang['system_warning'];
 }
 else{
 $system_warning = 'System warning!';
 }

 if($sett['relative_url']){
 $err_img = "<img src=\"$sett[relative_url]adm/img/err.gif\">&nbsp;";
 }
 else{
 $err_img = '';
 }

ob_start();
ob_implicit_flush(0);
$ret=ob_get_contents() . "<noindex><div style=\"background-color:#FFFFF0;color:FF0000;padding:4px\"><hr>$err_img<b>$system_warning</b><br>$msg<hr /></div></noindex>";
echo $ret;
}



}
?>