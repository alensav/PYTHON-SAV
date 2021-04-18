<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
error_reporting(E_ALL & ~E_NOTICE);
@ini_set('display_errors', 'On');
 if(function_exists('set_time_limit')){
 @set_time_limit(600);
 }

define('SYS_LOADER', 1);
define('UPDATE_DIR', '.');
define('SCRIPT_DIR', '..');
define('SCRIPTCHF_DIR', SCRIPT_DIR);
define('DESIGN_DIR', SCRIPT_DIR.'/design');
define('INC_DIR', SCRIPT_DIR."/inc");
define('DEBUG_MODE', 0);

@ini_set('default_charset', 'utf-8');

$allarrays=array('_GET', '_POST', '_COOKIE', '_SESSION', '_SERVER');
 foreach($allarrays as $defarray){
  if(isset($$defarray)){
  foreach($$defarray as $key => $value){unset($$key);}
  }
 }
unset($allarrays,$defarray,$key,$value);

$db_update = new db_update;
$db_update->product = 'ArwShop Market';

 if(file_exists(INC_DIR."/custom.php")){
 require_once(INC_DIR."/custom.php");
 }
 else{
 die($db_update->err_msg("Can't require ".INC_DIR."/custom.php"));
 }

$custom = new custom;
custom::check_mb();
custom::check_magic_quotes_gpc();
custom::check_timezone();

 if(file_exists(SCRIPTCHF_DIR."/fs.php")){
 require_once(SCRIPTCHF_DIR."/fs.php");
 if(empty($db_conn)){
  $db_conn = $e7uzgxx;
  }
 $db_conn['mysql_charset']='utf8';
 }
 else{
 die($db_update->err_msg("Can't require ".SCRIPTCHF_DIR."/fs.php"));
 }

 if(file_exists(INC_DIR."/db_mysql.php")){
 require_once(INC_DIR."/db_mysql.php");
 }
 else{
 die($db_update->err_msg("Can't require ".INC_DIR."/db_mysql.php"));
 }

$db = new db($db_conn);
$db->connect_combined($db_conn) or die("Can't connect to SQL server!");
$sett = custom::get_settings(2);
$difset = custom::get_settings(8);

 if(isset($sett['db_version']) && $sett['db_version'] == custom::floatVersion()){
 $db->close_connection();
 header("Location: ../index.php");
 exit;
 }

 if(empty($sett['db_version'])){
 $sett['db_version'] = '1.0';
 }

$lang = array();
custom::get_lang('update');

header("Content-type: text/html; charset=$sett[charset]");
?><!DOCTYPE html><html><head><meta charset="<?php echo $sett['charset']; ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo "$lang[update] $db_update->product"; ?></title>
<meta name="Author" content="Igor Anikeev">
<meta name="Copyright" content="Igor Anikeev, www.arwshop.ru">
<meta name="ProductName" content="<?php echo $db_update->product; ?>">
<link href="../adm/admin2.css" rel="stylesheet" type="text/css">
<style type="text/css">
table td{color:#133f66;}
</style>
</head>
<body style="height:100%;">
<table style="width:100%; height:100%; background-color:#ffffff;">
 <tr class="ahdr" style="height:40px;">
  <td>
   <table style="width:100%; border-bottom:1px inset #ffffff;">
    <tr>
     <td style="width:231px;"><a href="http://www.arwshop.ru/" target="_blank"><img src="arwshop.gif" alt="<?php echo $db_update->product; ?>"></a></td>
     <td>
<b style="font-size:18px;margin-left:50px;"><img src="install.gif" style="vertical-align:middle;" alt="">&nbsp;&nbsp;<?php echo $lang['welcome_to_update']; ?></b>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td style="vertical-align:top;">

<table style="width:80%;">
 <tr>
  <td>

<?php
 if(isset($_POST['step'])){
  switch($_POST['step']){

  case 'license_form':
  echo $db_update->check_license_form();
  break;

  case 'start_update_db':
  echo $db_update->update_db_version();
  break;

  default:
  echo $db_update->license_form();

  }
 }
 else{
 echo $db_update->license_form();
 }

$db->close_connection();

?>

</td>
 </tr>
</table>

  </td>
 </tr>
 <tr class="aftr" style="height:30px;">
  <td>
<table style="width:100%; border-top: 1px outset #ffffff; border-bottom: 1px inset #ffffff;"><tr><td style="text-align:center;"><br>
<span style="font-size:12px">Copyright &copy; <a href="http://www.arwshop.ru/" target="_blank">ArwShop.ru</a></span><br><br></td></tr></table>
  </td>
 </tr>
</table>
</body></html>
<?php



function add_sql_err($query){
global $db, $db_update;
$db_update->is_sql_errors = true;
$db_update->update_db_results .= "<div class=\"red\">SQL error: \"$query\". Error " . $db->errno() . ": " . $db->error() . ".</div>";
}


function add_sql_success($query){
global $db_update;
$db_update->update_db_results .= "SQL success: \"$query\".<br>";
}



class db_update{

public $product = '';
public $update_db_results = '';
public $is_sql_errors = false;


function license_form($err = ''){
global $lang, $db;

 if(! file_exists(SCRIPT_DIR."/license.txt")){
 return $this->err_msg("Can't open file ".SCRIPT_DIR."/license.txt");
 }

$license = file_get_contents(SCRIPT_DIR."/license.txt");

custom::get_lang('sys_requirements');
require_once(INC_DIR."/sys_requirements.php");
 if(! sys_req::check_sys_requirements($lang, $db)){
 return sys_req::last_error();
 }

 if(! empty($err)){
 $err = $this->err_msg($err);
 }

$ret = <<<HTMLDATA
$err
<form action="?" method="POST" onsubmit="this.submit.disabled=true;">
<input type="hidden" name="step" value="license_form">
<div style="max-width:620px;">$lang[db_copy_info]</div>
<textarea cols="56" rows="19">$license</textarea><br><br>
<input type="checkbox" id="agree_license" name="agree_license"><label for="agree_license">$lang[im_agree_license]</label><br><br>
<input type="submit" name="submit" value="$lang[continue]">
</form>
HTMLDATA;

return $ret;
}


function check_license_form(){
global $lang;
 if(empty($_POST['agree_license'])){
 return $this->license_form($lang['not_license_agree']);
 }
return $this->check_db_charset();
}

function check_db_charset(){
global $sett, $difset;
 if(floatval($sett['db_version']) < 3.0 && (empty($difset['db_charset']) || $difset['db_charset'] != 'utf8')){
 include(UPDATE_DIR."/convert_charset.php");
 return '';
 }
 else{
 return $this->update_db_version_form();
 }
}

function update_db_version_form(){
global $lang, $sett;
$ret = '';

 if($sett['db_version'] === '1.0'){
 $txt_current_db_version = 'unknown (1.0)';
 }
 else{
 $txt_current_db_version = $sett['db_version'];
 }

 if($sett['db_version'] > custom::floatVersion()){
 return "<h4 class=\"red\">$lang[invalid_version]</h4><p>$lang[current_script_version] <b>".custom::floatVersion()."</b><br>$lang[current_db_version] <b>$txt_current_db_version</b><br><br>$lang[update_program_files]</p>";
 }

$license = file_get_contents(SCRIPT_DIR."/license.txt");

$engine_version = custom::floatVersion();

$ret .= <<<HTMLDATA
<form action="?" method="POST" onsubmit="this.submit.disabled=true;">
<input type="hidden" name="step" value="start_update_db">

<p><b>$lang[update_intended] $this->product $lang[from_version] $txt_current_db_version $lang[to_version] $engine_version</b></p>

<p>
$lang[current_script_version] <b>$engine_version</b><br>
$lang[current_db_version] <b>$txt_current_db_version</b><br>
$lang[new_db_version] <b>$engine_version</b><br>
</p>

<input type="submit" name="submit" value="$lang[start_update_db]">
</form>
HTMLDATA;

return $ret;
}


function update_db_version(){
global $sett, $difset, $lang;
$ret = '';

 if(isset($difset['upd_sql_begin_exec'])){
 return $this->err_msg($lang['prev_update_errors']);
 }

$result = $this->update_database($sett['db_version'], custom::floatVersion());

 if($result){
 $ret .= <<<HTMLDATA
 <h1>$lang[update_completed]</h1>
 <p>$lang[go_to] <a href="$sett[url]" target="_blank">$lang[public_part]<a/></p>
 <p>$lang[go_to] <a href="$sett[url]admin.php" target="_blank">$lang[admin_panel]<a/></p>
 <hr>
HTMLDATA;

  if($this->update_db_results){
  $ret .= <<<HTMLDATA
<p><a name="tech"></a>
<div id="pmdiv" style="cursor:pointer;cursor:hand;" onclick="if(shfr.style.display=='none'){shfr.style.display='block';pmdivimg.src='minus.gif';}else{shfr.style.display='none';pmdivimg.src='plus.gif';}">
<a href="#tech"><img id="pmdivimg" name="pmdivimg" src="minus.gif" border="0" style="vertical-align:middle">&nbsp;<b>$lang[technical_information]</b></a>
</div>
<div id="shfr">$this->update_db_results<hr></div>
</p>
<script type="text/javascript">
shfr.style.display='none';
pmdivimg.src='plus.gif';
</script>
HTMLDATA;
  }

 }
 else{
 $ret .= "<h1 class=\"red\">$lang[update_errors]</h1><p>$this->update_db_results</p>";
 }

return $ret;
}


function update_database($previous_db_version, $new_db_version){
global $db, $db_conn;

$previous_db_version = preg_replace("([^0-9\.])", '', $previous_db_version);
$previous_db_version = preg_replace("(\.\.)", '', $previous_db_version);

$update_versions = array();
$def_ver = $previous_db_version;

 while($def_ver < $new_db_version){
 $def_ver=sprintf("%.1f", $def_ver + 0.1);
 array_push($update_versions, $def_ver);
 }



 $sql_engine_myisam = 'ENGINE=MyISAM';

 if(! empty($db_conn['mysql_charset'])){
 $sql_default_charset = "DEFAULT CHARSET=$db_conn[mysql_charset]";
 }
 else{
 $sql_default_charset = '';
 }

require_once(INC_DIR."/admin/admin_lib.php");
$admin_lib = new admin_lib;

$admin_lib->save_settings(8, array('upd_sql_begin_exec' => '1'), 0);

 foreach($update_versions as $version){
  if(is_file(SCRIPT_DIR."/update/sql/$version.php")){
  $this->update_db_results.="<br><b>Update SQL v$version:</b><br>";
  include(SCRIPT_DIR."/update/sql/$version.php");
  }
 }


 if($this->is_sql_errors){
 return false;
 }

$admin_lib->save_settings(2, array('db_version' => $new_db_version), 0);

$admin_lib->delete_settings(8, array('upd_sql_begin_exec'));

return true;
}


function err_msg($msg){
return "<div class=\"red\">$msg</div>";
}


}

?>