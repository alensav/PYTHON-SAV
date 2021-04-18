<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
error_reporting(E_ALL & ~E_NOTICE);
@ini_set('display_errors', 'On');
chdir(dirname(__FILE__));
define('DEBUG_MODE', 0);
define('SYS_LOADER', 1);
define('SCRIPT_DIR', '.');
define('INC_DIR', SCRIPT_DIR.'/inc');
define('SCRIPTCHF_DIR', SCRIPT_DIR);
define('DESIGN_DIR', SCRIPT_DIR.'/design');
define('MAIL_TPL_DIR', SCRIPT_DIR.'/mail_tpl');
define('CACHE', 0);
define('PHP_IN_TPL', 1);
define('MODULES_DIR', SCRIPT_DIR.'/modules');
define('PM_MODULES_DIR', SCRIPT_DIR.'/pm_modules');


@ini_set('default_charset', 'utf-8');

require_once(INC_DIR."/custom.php");
$custom = new custom;

 if(DEBUG_MODE == 1){
 @ini_set('memory_limit', '16M'); 
 }

$custom->check_mb();

if(! file_exists(SCRIPTCHF_DIR."/fs.php")){header("Location: install/index.php");exit;}
if(is_dir(SCRIPTCHF_DIR."/install")){include(INC_DIR."/admin/pages/install_not_removed_p.php");exit;}

 if(CACHE == 1){
 session_cache_limiter('must-revalidate');
 }

@session_start();
if(! session_id()){@session_destroy();}

$allarrays = array('_GET', '_POST', '_COOKIE', '_SESSION', '_SERVER');
 foreach($allarrays as $defarray){
  if(isset($$defarray)  && count($$defarray) > 0){
  foreach($$defarray as $key => $value){unset($$key);}
  }
 }
unset($allarrays, $defarray, $key, $value);

if(php_sapi_name() == 'cli'){die('...error...');}

require_once(SCRIPTCHF_DIR.'/fs.php');
 if(empty($db_conn)){
 $db_conn = $e7uzgxx;
 }
$db_conn['mysql_charset']='utf8';
$custom->check_magic_quotes_gpc();
$custom->check_timezone();
require_once(INC_DIR."/db_mysql.php");
$db = new db($db_conn);
$db->connect_combined($db_conn);
require_once(INC_DIR."/admin/admin_lib.php");
$admin_lib = new admin_lib;
$sett = $custom->get_settings(2);
header("Content-type: text/html; charset=$sett[charset]");
$custom->check_version(1);
$admset = $custom->get_settings(1);

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $mod = isset($_GET['mod']) ? $_GET['mod'] : '';
 $pmmod = isset($_GET['pmmod']) ? $_GET['pmmod'] : '';
 $view = isset($_GET['view']) ? $_GET['view'] : '';
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $mod = isset($_POST['mod']) ? $_POST['mod'] : '';
 $pmmod = isset($_POST['pmmod']) ? $_POST['pmmod'] : '';
 $view = isset($_POST['view']) ? $_POST['view'] : '';
 $act = isset($_POST['act']) ? $_POST['act'] : '';
 }
 else{
 die('Not supported method');
 }

 if($pmmod){
 $view = 'payment_module';
 }

$mod = preg_replace("([^a-z0-9\_\-])", '', $mod);
$pmmod = preg_replace("([^a-z0-9\_\-])", '', $pmmod);
$view = preg_replace("([^a-z\_\-])", '', $view);
$act = preg_replace("([^a-z\_\-])", '', $act);

$lang = array();

require_once(INC_DIR.'/msg.php');

 if(TDTC == 1){
 include(INC_DIR.'/matches.php');
 }

$custom->get_lang('admin_lang/admin');

if($view == 'logout'){$admin_lib->show_login(''); exit;}

 if(! $admin_lib->check_admin_login()){
  if(! empty($_POST['enter'])){
  $admin_lib->show_login('err');
  }
  else{
  $admin_lib->show_login('');
  }
 exit;
 }

custom::contentGts(INC_DIR.'/shop.php');

 switch($view){

 case 'download_dump':
 include(INC_DIR."/admin/pages/dump_download_p.php");
 $db->close_connection();
 exit;

 case 'download_csv':
 include(INC_DIR."/admin/pages/csv_download_p.php");
 $db->close_connection();
 exit;

 default:
  if(! empty($_GET['independ']) || ! empty($_POST['independ'])){
  include(INC_DIR."/admin/pages/independ_p.php");
  }
  else{
  include(INC_DIR."/admin/pages/admin_p.php");
  }

 }



$custom->engine_exit();





function admin_access(){
global $admin_lib;
return $admin_lib->check_admin_perms();
}


?>