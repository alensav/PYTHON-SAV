<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class admin_lib{

public $max_admin_session_time = 24 ;
public $key_server_values = '';


public function __construct(){
$this->key_server_values = $_SERVER['SCRIPT_FILENAME'] . $_SERVER['HTTP_USER_AGENT'];
}


public function check_admin_login(){
global $custom;

 if(empty($_SESSION['arwshop_mk']['mcinfo']['sw1']) || empty($_SESSION['arwshop_mk']['mcinfo']['key'])){
  if($_SERVER['REQUEST_METHOD'] == 'POST' && ! empty($_POST['enter'])){
  return $this->admin_enter();
  }
  else{
  return false;
  }
 }
 else{
 $admin_id = $custom->del_notalphanum(trim($_SESSION['arwshop_mk']['mcinfo']['sw1']));
 $row=$this->get_admin_data($admin_id, '');
 if(! $row['adminid'] || ! $row['name'] || ! $row['password'] || ! $row['status']){return false;}
  if($this->is_valid_sess_key($row) && $this->is_valid_cookie_key($row)){
  $this->set_admin_info($row);
  return true;
  }
  else{
  return false;
  }
 }

}


public function sess_key($row, $time=0){
global $admset;
if($time==0){$time=time();}
$key = 'STRING' . date("YmdH", $time) . $row['password'] . $row['status'] . 'Sys Administrator Validate' . $row['name'] . $this->key_server_values;
 if(! empty($admset['sess_ip'])){
 $key .= getenv('REMOTE_ADDR');
 }
return md5($key);
}


public function cookie_key($row, $time=0){
global $admset;
if($time==0){$time=time();}
$key = 'Shop data 2' . date("YmdH", $time) . $row['password'] . $row['status'] . 'CHECK admin error' . $row['name'] . $this->key_server_values;
 if(! empty($admset['sess_ip'])){
 $key .= getenv('REMOTE_ADDR');
 }
return md5($key);
}


public function is_valid_sess_key($row){
$time=time()+3600;
 for($i=-1; $i < $this->max_admin_session_time;$i++){
 $key = $this->sess_key($row, $time);
  if($_SESSION['arwshop_mk']['mcinfo']['key'] === $key){
  return true;
  }
 $time-=3600;
 }
return false;
}


public function is_valid_cookie_key($row){
$time=time()+3600;
 for($i=-1; $i < $this->max_admin_session_time;$i++){
 $key = $this->cookie_key($row, $time);
  if($_COOKIE['ack2'] === $key){
  return true;
  }
 $time-=3600;
 }
return false;
}


public function admin_enter(){
global $custom;
$_POST['admin_name']=$custom->del_notalphanum(trim($_POST['admin_name']));
$_POST['admin_password']=$custom->del_notalphanum(trim($_POST['admin_password']));
if($_POST['admin_name'] == '' || $_POST['admin_password'] == ''){return false;}
$_POST['admin_name']=md5($_POST['admin_name'] . 'Sys Administrator Login');
$_POST['admin_password']=md5($_POST['admin_password'] . 'Sys Administrator Password');
$row=$this->get_admin_data(0, $_POST['admin_name']);
 if($row['name'] === $_POST['admin_name'] && $row['password'] === $_POST['admin_password']){
 $this->set_admin_info($row);
  if(! empty($_POST['next_loc']) && strpos($_POST['next_loc'], 'del') === false){
  header('Location: ?' . urldecode($_POST['next_loc']));
  exit;  
  }
 return true;
 }
 else{
 return false;
 }
}


public function get_admin_data($admin_id, $admin_name){
global $db;
$admin_id = intval($admin_id);
$admin_name = custom::del_notalphanum($admin_name);
$tbl = DB_PREFIX.'admin';

 if($admin_id){
 $res=$db->query("SELECT `adminid`, `name`, `password`, `status` FROM `$tbl` WHERE `adminid` = '$admin_id'") or die($db->error());
 }
 elseif($admin_name){
 $admin_name = $db->secstr($admin_name);
 $res=$db->query("SELECT `adminid`, `name`, `password`, `status` FROM `$tbl` WHERE `name` = '$admin_name'") or die($db->error());
 }
 else{
 return array();
 }

return $db->fetch_array($res);
}


public function set_admin_info($row){
global $admin;
$admin=array();
$admin['name']=$row['name'];
$admin['status']=$row['status'];
$_SESSION['arwshop_mk']['mcinfo']=array();
$_SESSION['arwshop_mk']['mcinfo']['sw1']=$row['adminid'];
$_SESSION['arwshop_mk']['mcinfo']['key'] = $this->sess_key($row);
$this->adm_set_cookie('ack2', $this->cookie_key($row));
}



public function save_newlogin(){
global $db, $custom, $admin, $lang;
$err = '';
$table=DB_PREFIX.'admin';
$new_admin_name = $custom->del_notalphanum(trim($_POST['new_admin_name']));
if($new_admin_name !== $_POST['new_admin_name']){$err.="$lang[invalid_name]<br>";}
if($new_admin_name && mb_strlen($new_admin_name)<3){$err.="$lang[short_name]<br>";}
if($new_admin_name == 'demo'){$err.="$lang[no_demo]<br>";}
if($new_admin_name){$new_admin_name=md5($new_admin_name . 'Sys Administrator Login');}
$old_admin_password = md5($custom->del_notalphanum(trim($_POST['old_admin_password'] . 'Sys Administrator Password')));
$new_admin_password1 = $_POST['new_admin_password1'];
$new_admin_password1 = $custom->del_notalphanum(trim($new_admin_password1));
if($new_admin_password1 !== $_POST['new_admin_password1']){$err.="$lang[invalid_pass]<br>";}
if(mb_strlen($new_admin_password1)<6){$err.="$lang[short_pass]<br>";}
$new_admin_password1=md5($new_admin_password1 . 'Sys Administrator Password');
$new_admin_password2 = md5($custom->del_notalphanum(trim($_POST['new_admin_password2'] . 'Sys Administrator Password')));
if($new_admin_password1 !== $new_admin_password2){$err.="$lang[different_passwords]<br>";}

$res=$db->query("SELECT password FROM $table WHERE status = 'main_admin'")or die($db->error());
$row=$db->fetch_array($res);
if($old_admin_password !== $row['password']){$err.="$lang[wrong_old_pass]<br>";}

if($err){return "<font class=\"red\">$err</font>";}

if(! $this->check_admin_perms()){return $this->nosave_perms_msg();}

if($new_admin_name){$admin['name']=$new_admin_name;}
$admin['password']=$new_admin_password1;

$res=$db->query("UPDATE $table SET name='$admin[name]', password='$admin[password]' WHERE status = 'main_admin'")or die($db->error());

return "<h3>$lang[changes_success]</h3>";
}



public function show_login($err_msg){
global $sett;
unset($_SESSION['arwshop_mk']['mcinfo']);
 if(isset($_COOKIE['ack2'])){
 setcookie('ack2', '', time() - 3600, '');
 }
include(INC_DIR."/admin/pages/login_p.php");
exit;
}


public function dirurl($file_url){
$pos = strpos($file_url, '?');
 if($pos !== false){
 $file_url = substr($file_url, 0, $pos);
 }
$pos = strrpos($file_url, '/');
 if($pos !== false){
 return substr($file_url, 0, $pos + 1);
 }
return '';
}


public function save_settings($type, $new_sett, $check_perms = true, $replace_quotes = true){
global $db, $lang;
if($check_perms && ! $this->check_admin_perms()){return $this->nosave_perms_msg();}
$tbl=DB_PREFIX.'settings';
$type=intval($type);

 if($type == 2 && isset($new_sett['url'])){
 $new_sett['url']=stripslashes($new_sett['url']);
 $new_sett['url']=str_replace('\\','/',$new_sett['url']);
 if($new_sett['url']==''){$new_sett['url'] = $this->dirurl('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);}
 if(substr($new_sett['url'], strlen($new_sett['url'])-1) !== '/'){$new_sett['url'].='/';}
 }


$oldset = custom::get_settings($type);


 if(is_array($new_sett)){

  foreach($new_sett as $setname => $setvalue){
 
  $setvalue = stripslashes(trim($setvalue));

   if($replace_quotes){
   $setvalue = str_replace('"','&quot;',$setvalue);
   $setvalue = str_replace("'",'&#39;',$setvalue);
   $setvalue = str_replace("`",'&#96;',$setvalue);
   }

  $setvalue = $db->secstr($setvalue);
  $setvalue = $db->cutstr($setvalue, 255);

   if(isset($oldset["$setname"])){
   $db->query("UPDATE $tbl SET setvalue='$setvalue' WHERE type = '$type' AND setname='$setname'") or die($db->error());
   }
   else{
   $db->query("INSERT INTO `$tbl`(`type`, `setname`, `setvalue`) VALUES('$type', '$setname', '$setvalue')") or die($db->error());
   }

  }

 }


 if(isset($lang['changes_success'])){
 return "<h3>$lang[changes_success]</h3>";
 }
 else{
 return 'Changes success';
 }
 
}


public function delete_settings($type, $setnames_arr){
global $db;
$tbl=DB_PREFIX.'settings';
 foreach($setnames_arr as $setname){
 $db->query("DELETE FROM `$tbl` WHERE `type` = '$type' AND `setname` = '$setname'") or die($db->error());
 }
return true;
}


public function save_txtsettings($new_sett, $check_perms = true){
global $db, $lang;
if($check_perms && ! $this->check_admin_perms()){return $this->nosave_perms_msg();}
$tbl = DB_PREFIX.'txtsettings';

 if(is_array($new_sett)){

  foreach($new_sett as $setname => $setvalue){
 
   $setvalue=stripslashes(trim($setvalue));
   $setvalue=str_replace('"','&quot;',$setvalue);
   $setvalue=str_replace("'",'&#39;',$setvalue);
   $setvalue=str_replace("`",'&#96;',$setvalue);
   $setvalue=$db->secstr($setvalue);
   $setvalue = $db->cutstr($setvalue, 16777215, true);

   $q = $db->query("SELECT COUNT(*) AS NUM_ROWS FROM $tbl WHERE setname = '$setname'");

     if($db->result($q) > 0){
     $db->query("UPDATE $tbl SET setvalue='$setvalue' WHERE setname='$setname'") or die($db->error());
     }
     else{
     $db->query("INSERT INTO $tbl(setname, setvalue) VALUES('$setname', '$setvalue')") or die($db->error());
     }

  }

 }

return true; 
}


public function delete_txtsettings($setnames_arr){
global $db;
$tbl=DB_PREFIX.'txtsettings';
 foreach($setnames_arr as $setname){
 $db->query("DELETE FROM `$tbl` WHERE `setname` = '$setname'") or die($db->error());
 }
return true;
}

public function nosave_perms_msg(){
global $lang;
return "<p><img src=\"adm/img/err.gif\" style=\"vertical-align:middle;\">&nbsp;<span class=\"red\">$lang[nosave_perms]</span></p>";
}


public function err_msg($msg, $back = false){
require_once(INC_DIR."/msg.php");
global $lang;
$bk = '';
 if($back){
 $bk = '<br><br><a href="javascript:history.go(-1);">' . $lang['return_back'] . '</a>';
 }
return msg::error($msg . $bk);
}

public function good_msg($msg, $back = false){
require_once(INC_DIR."/msg.php");
global $lang;
$bk = '';
 if($back){
 $bk = '<br><br><a href="javascript:history.go(-1);">' . $lang['return_back'] . '</a>';
 }
return msg::success($msg . $bk);
}

public function err_msg_head($error_msg, $back=0){
global $sett, $lang;
$error_msg="<!DOCTYPE html><html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=$sett[charset]\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>$lang[error]</title><link href=\"adm/pop-up.css\" rel=\"stylesheet\" type=\"text/css\"></head><body>" . $this->err_msg($error_msg, $back) . "</body></html>";
return $error_msg;
}

public function good_msg_head($msg, $back=0){
global $sett;
$msg="<!DOCTYPE html><html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=$sett[charset]\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>Ok</title><link href=\"adm/pop-up.css\" rel=\"stylesheet\" type=\"text/css\"></head><body>" . $this->good_msg($msg,  $back) . "</body></html>";
return $msg;
}


public function fduDvMsg(){
global $lang, $sett;
$mtd = 3 * 10;
$rud = fudrDv();
 if($rud > 25){
 return '';
 }
$percents = round($rud * 100 / $mtd);
$bar_width = round($percents * 300 / 100);
return "<br /><center><table style=\"border-top: 3px outset #f0f0f4;border-right: 3px ridge #f0f0f4;border-bottom: 3px ridge #f0f0f4;border-left: 3px outset #f0f0f4;\"><tr><td align=\"center\"><p class=\"red\" style=\"margin:10px;\"><img src=\"$sett[relative_url]adm/img/\x65\x72\x72\x2E\x67\x69\x66\">&nbsp;$lang[390] $rud $lang[403].</p><p style=\"margin:10px;\"><table width=\"300\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-top: 3px outset #f0f0f4;border-right: 3px ridge #f0f0f4;border-bottom: 3px ridge #f0f0f4;border-left: 3px outset #f0f0f4;\"><tr><td><img src=\"adm/img/bar1.jpg\" width=\"$bar_width\" height=\"18\"></td></tr></table></p></td></tr></table></center>";
}


public function replace_quotes($str){
$str=str_replace('"', '&quot;', $str);
$str=str_replace("'", '&#39;', $str);
$str=str_replace("`", '&#96;', $str);
return $str;
}


public function check_admin_perms(){
global $admin;
if($admin['status'] == 'main_admin'){return 1;}else{return 0;}
}


public function sett_class(){
global $def_class;
if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
return $def_class;
}


public function set_data($tbl, $ifr1, $ifr2, $fname, $fvalue, $iuk){
global $db;

if(! $this->check_admin_perms()){echo $this->nosave_perms_msg();exit;}

 if(is_array($iuk)){

  if(count($iuk)){
  $i = 0;

   foreach($iuk as $name => $value){
   $value=trim($value);

    if($value){
    $value=strtoupper(md5($value));

     if($i > 0){
     $ifr = $ifr2 . $i;
     $db->query("DELETE FROM `$tbl` WHERE `$fname` = '$ifr' AND type = 2") or die($db->error());
     $db->query("INSERT INTO `$tbl`(`type`, `$fname`, `$fvalue`) VALUES(2, '$ifr', '$value')") or die($db->error());
     }
     else{
     $ifr = $ifr1;
     $db->query("UPDATE `$tbl` SET `$fvalue` = '$value' WHERE `$fname` = '$ifr' AND type = 2") or die($db->error());
     }

    $i++;
    }

   }

  }

 }
}


public function site_base_url(){
global $sett;
$url=$sett['url'];
$pos=strpos($url, '//');
if(! $pos){return '/';}
$pos=strpos($url, '/', $pos+2);
return substr($url, 0, $pos+1);
}


public function gzip_file($input_file, $output_file=''){
if(! $output_file){$output_file=$input_file.'.gz';}
if(! file_exists($input_file)){return false;}
$level=9;
$input_fh=@fopen($input_file, "rb");
if(! $input_fh){return false;}
$output_fh=gzopen($output_file, "w$level");
if(! $output_fh){return false;}
 while(! feof($input_fh)){
 $str=fread($input_fh, 2048);
 gzwrite($output_fh, $str);
 }
fclose($input_fh);
gzclose($output_fh);
return true;
}


public function get_modules_arr(){
$modules_arr = array();
 if(is_dir(MODULES_DIR)){
 $dirhandle=opendir(MODULES_DIR);
  while(($dirname = readdir($dirhandle)) !== false){
   if($dirname != '.' && $dirname != '..' && $this->is_valid_mod_name($dirname) && is_dir(MODULES_DIR."/$dirname")){
   $mod_name = $dirname;
   $mod_conf=array();
   $mod_conf['mod_title'] = $dirname;
    if(is_file(MODULES_DIR."/$dirname/mod_conf.php") && is_file(MODULES_DIR."/$dirname/admin/module.php")){
    include(MODULES_DIR."/$dirname/mod_conf.php");
    }
    if(is_file(MODULES_DIR."/$dirname/admin/module.php")){
    array_push($modules_arr, array('mod_name' => $dirname, 'mod_title' => $mod_conf['mod_title']));
    }
   }
  }
 closedir($dirhandle);
 }
return $modules_arr;
}


public function is_valid_mod_name($mod_name){
 if(strlen($mod_name) > 32){
 return false;
 }
 if(! preg_match('([^a-zA-Z0-9\_]{1,})', $mod_name)){
 return true;
 }
return false;
}


public function is_valid_pmmod_name($pmmod_name){
 if(strlen($pmmod_name) > 32){
 return false;
 }
 if(! preg_match('([^a-zA-Z0-9\_]{1,})', $pmmod_name)){
 return true;
 }
return false;
}


public function load_admin_module($mod){
global $custom;
$mod = preg_replace("([^a-z0-9\_\-])", '', $mod);
 if(! $mod){
 return 'Invalid module!';
 }
 if(is_file(MODULES_DIR."/$mod/admin/module.php")){
 include(MODULES_DIR."/$mod/admin/module.php");
 }
 else{
 return 'Unknown module!';
 }
}


public function adm_set_cookie($name, $value){
$max_cookie_time = 0;
$now_time = 0;
 if(phpversion() >= '5.2'){
 setcookie($name, $value, $now_time + $max_cookie_time, '/', '', false, true);
 }
 else{
 setcookie($name, $value, $now_time + $max_cookie_time, '/', '', false);
 }
}


public function replace_amp($str){
return preg_replace("/(\&)(?!(\#[0-9]{1,5}\;|quot\;|amp\;|gt\;|lt\;|apos\;))/", '&amp;', $str);
}


public function is_design_marker_exists($marker, $tpl_file, $design = ''){
global $sett;
 if(empty($design)){
 $design = $sett['design'];
 }
 if(! custom::is_valid_design($design)){
 return false;
 }
$file = DESIGN_DIR."/$design/tpl/$tpl_file";
 if(! is_file($file)){
 return false;
 }
 if(strpos(file_get_contents($file), $marker) !== false){
 return true;
 }
return false;
}



}
?>