<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
error_reporting(E_ALL & ~E_NOTICE);
chdir(dirname(__FILE__));
 if(substr($_SERVER['REMOTE_ADDR'], 0, 8) == '127.0.0.'){
 @ini_set('display_errors', 'On');
 }
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


if(floatval(phpversion()) < 5.0 ){die('Required PHP 5 or higher!');}
@ini_set('default_charset', 'utf-8');

require_once(INC_DIR."/custom.php");
$custom = new custom;



@ini_set('url_rewriter.tags', '');

 if(DEBUG_MODE == 1){
 ini_set('memory_limit', '3M'); 
 }

$custom->check_mb();

if(! file_exists(SCRIPTCHF_DIR."/fs.php")){header("Location: install/index.php");exit;}

 if(CACHE == 1){
  if($_GET['view'] !== 'cart' && $_POST['view'] !== 'cart' && $_GET['view'] !== 'order'){
  session_cache_limiter('must-revalidate');
  }
 }

 if(empty($_GET['nosess'])){
 @session_start();
 if(! session_id()){@session_destroy();}
 }

$allarrays = array('_GET', '_POST', '_COOKIE', '_SESSION', '_SERVER');
 foreach($allarrays as $defarray){
  if(isset($$defarray)  && count($$defarray) > 0){
  foreach($$defarray as $key => $value){unset($$key);}
  }
 }
unset($allarrays, $defarray, $key, $value);

if(php_sapi_name() == 'cli'){die('...error...');}

$http_code = 200;

$custom->check_magic_quotes_gpc();

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $_GET = $custom->replace_tags_and_quotes_array($_GET);
 $mod = isset($_GET['mod']) ? $_GET['mod'] : '';
 $pmmod = isset($_GET['pmmod']) ? $_GET['pmmod'] : '';
 $view = isset($_GET['view']) ? $_GET['view'] : '';
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $_POST = $custom->replace_tags_and_quotes_array($_POST);
 $mod = isset($_POST['mod']) ? $_POST['mod'] : '';
 $pmmod = isset($_POST['pmmod']) ? $_POST['pmmod'] : '';
 $view = isset($_POST['view']) ? $_POST['view'] : '';
 $act = isset($_POST['act']) ? $_POST['act'] : '';
 }
 else{
 die('Not supported method');
 }

$fcat = '';
 if(! empty($_GET['fcat'])){
 $fcat = preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\/\_\-])", '', $_GET['fcat']);
 }

$prname = '';
 if(! empty($_GET['prname'])){
 $prname = preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $_GET['prname']);
 }

 if($pmmod){
 $view = 'payment_module';
 }

$mod = preg_replace("([^a-z0-9\_\-])", '', $mod);
$pmmod = preg_replace("([^a-z0-9\_\-])", '', $pmmod);
$view = preg_replace("([^a-z\_\-])", '', $view);
$act = preg_replace("([^a-z\_\-])", '', $act);

require_once(SCRIPTCHF_DIR."/fs.php");
 if(empty($db_conn)){
 $db_conn = $e7uzgxx;
 }
$db_conn['mysql_charset'] = 'utf8';
require(INC_DIR."/db_mysql.php");
$db = new db($db_conn);
$db->connect_combined($db_conn) or die("Can't connect to SQL server!");
$sett = $custom->get_settings(2);
header("Content-type: text/html; charset=$sett[charset]");
$custom->check_timezone();


 if($sett['counter']){
 require_once(INC_DIR."/statistics.php");
 $statistics = new statistics;
 $statistics->visitors_count();
 }

 if(! empty($sett['cache'])){
 require_once(INC_DIR."/cache.php");
 $cache = new cache;
 echo $cache->get_from_cache();
 }
 else{
 echo get_content();
 }

 if(isset($smtp) && is_object($smtp) && $smtp->is_connected()){
 @$smtp->close();
 }

$custom->engine_exit();


function is_valid_lang($lang){
$cleared_lang = preg_replace("([^a-zA-Z0-9\_\-])", '', $lang);
if($cleared_lang !== $lang){return false;}
if($cleared_lang && is_file(SCRIPT_DIR."/lang/$cleared_lang/lang.lng")){return true;}
return false;
}


function tunable_css(&$template){
global $sett;
$tunable_design_url = custom::tunable_design_url();
 if($tunable_design_url){
 $css_nocache = '';
  if(! empty($_COOKIE['tunable_css_nocache'])){
  $css_nocache = '?nocache=' . intval($_COOKIE['tunable_css_nocache']);
  }
 $template->assign('tunable_css_link', '<link id="tunable_css" rel="stylesheet" type="text/css" href="' . $tunable_design_url . $css_nocache . '">');
 }
 else{
 $template->assign('tunable_css_link', '');
 }
}


function load_design(){
global $sett, $page_tags, $lang, $view, $mod, $pmmod, $shop, $cat, $fcat, $product, $prname, $pg, $http_code, $custom;

$page_tags = array('page_title' => '', 'description' => '', 'image' => '', 'metatags' => '', 'special' => '', 'chain_title' => '', 'inv_chain_title' => '', 'chain_title_link' => '', 'meta_title' => '', 'keywords' => '');


$template = new template('design.tpl');

$shop->get_categories_arr();

$shop->get_manufacturers_arr();

$is_content = false;

 if(TDTC == 1 && fudrDv() <= 0){
 header('HTTP/1.1 503 Service Unavailable');
 $http_code = 503;
 $template->assign('content', mdvExpt());
 }
 elseif($mod){
  
 global $SYS_TEMPLATE_VARS;
 $template->not_condition('currency_selection');
 $template->assign('content', load_module($mod));
 }
 elseif($pmmod){
 $template->not_condition('currency_selection');
 require_once(INC_DIR."/pm_modules.php");
 $template->assign('content', load_payment_module($pmmod));
 }
 else{

  if($_SERVER['REQUEST_METHOD'] == 'GET'){
  
   if(! empty($_GET['cat'])){
    if(is_numeric($_GET['cat'])){
    $cat = intval($_GET['cat']);
    }
    else{
    $cat = '';
    $template->assign('content', header404());
    $is_content = true;
    }
   }

  $product = isset($_GET['product']) ? intval($_GET['product']) : 0;
  $pg = isset($_GET['pg']) ? intval($_GET['pg']) : 0;
  
  }
  elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  $product = isset($_POST['product']) ? intval($_POST['product']) : 0;
  }


  if(! $view){
   if($product > 0 || $prname){
   $view = 'detail';
   }
   elseif($cat > 0 || $fcat){
   $view = 'category';
   }
   else{
   $view = 'main';
   $cat = 0;
   }
  }

 $user_sel_currency_pages = array('main', 'category', 'manufacturers', 'detail', 'search', 'cart', 'delivery_methods', 'discounts');
  if(! empty($sett['currency_selection']) && $_SERVER['REQUEST_METHOD'] == 'GET' && in_array($view, $user_sel_currency_pages)){
  $template->condition('currency_selection');
  $template->assign('sel_currencies_options', $shop->get_sel_currencies_options());
  $template->assign('request_uri_encoded', urlencode($_SERVER['REQUEST_URI']));
  }
  else{
  $template->not_condition('currency_selection');
  }

  if(! $is_content){
  $template->assign('content', $template->include_in_var(INC_DIR."/pages/shop_p.php"));
  }

 }



$template->assign('charset', $sett['charset']);
$template->assign('title', $page_tags['meta_title']);
tunable_css($template);
$template->assign('metatags', $page_tags['metatags']);
$srchtext = isset($_GET['srchtext']) ? $custom->replace_tags_and_quotes($_GET['srchtext']) : '';
$template->assign('search_text', $srchtext);
$template->assign('horizontal_menu', $shop->get_menu(1));
$template->assign('vertical_menu', $shop->get_menu(2));
$template->assign('menu_categories', $shop->get_menu_categories());
$template->assign('menu_manufacturers', $shop->get_menu_manufacturers());
$template->assign('new_products', $shop->get_new_products());
$template->assign('menu_content_pages', $shop->get_menu_content_pages());

 if($view != 'news' || ! empty($_GET['nid'])){
 $template->assign('menu_news', $shop->get_menu_news());
 }
 else{
 $template->assign('menu_news', '');
 }

 if($view !== 'cart' && $view !== 'order'){
 $template->assign('cart_info', $shop->show_cart_info());
 }
 else{
 $template->assign('cart_info', '');
 }

$template->assign('menu_special_offers', $shop->get_special_offers());

 if(empty($_SESSION['arwshop_mk']['user']["username"]) && $shop->showBlock('s_mLoginFrm')){
 $tpl_menu_login_form = new template('menu_login_form.tpl');
 $login_form = $tpl_menu_login_form->out_content();
 $template->assign('login_form', $login_form);
 unset($tpl_menu_login_form, $login_form);
 }
 else{
 $template->assign('login_form', '');
 }



 if(! empty($_GET['fullstr'])){
 $template->assign('fullstr_checked', ' checked');
 }
 else{
 $template->assign('fullstr_checked', '');
 }

 if($sett['search_type'] == 2){
 $template->condition('any_search_type');
 }
 else{
 $template->not_condition('any_search_type');
 }

tpl_assign_custom($template);



 if($mod){
  if(is_array($SYS_TEMPLATE_VARS)){
   if(sizeof($SYS_TEMPLATE_VARS)){
    foreach($SYS_TEMPLATE_VARS as $name => $value){
    $template->assign($name, $value);
    }
   }
  }
 }

$content = $template->out_content(1);
 if(! empty($sett['null_price_text'])){
 $content = replace_null_pices($content, $sett['null_price_text']);
 }
return $content;
}


function tpl_assign_custom(&$template){
global $sett, $lang;
$template->assign('shop_url', $sett['url']);
$template->assign('relative_url', $sett['relative_url']);
$template->assign('shop_index', "$sett[relative_url]$sett[index_file]");
$template->assign('design_url', "$sett[relative_url]design/$sett[design]/");
$template->assign('lang', $lang);
$template->assign('shop_name', $sett['shop_name']);
$template->assign('domain', $_SERVER['HTTP_HOST']);
 if(! empty($sett["logo_image_$sett[design]"])){
 $shop_name = str_replace('"', '&quot;', $sett['shop_name']);
 $template->assign('logo_image', '<img src="' . $sett["logo_image_$sett[design]"] . '" id="logo_image" class="logo_image" alt="' . $shop_name . '" title="' . $shop_name . '">');
 }
 else{
 $template->assign('logo_image', '');
 }
$template->assign('header_text', isset($sett['header_text']) ? $sett['header_text'] : '');
$template->assign('footer_text', isset($sett['footer_text']) ? $sett['footer_text'] : '');
}

function def_show_curr_id(){
global $sett, $currencies;
$sess_def_show_currency = isset($_SESSION['arwshop_mk']['show_currency_id']) ? intval($_SESSION['arwshop_mk']['show_currency_id']) : 0;
 if($sess_def_show_currency > 0 && is_array($currencies[$sess_def_show_currency])){
 $currency_id = $sess_def_show_currency;
 }
 elseif($sett['def_show_currency'] > 0){
 $currency_id = intval($sett['def_show_currency']);
 }
 else{
 $currency_id = intval($sett['def_currency']);
 }
return $currency_id;
}


function def_show_curr_brief(){
global $sett, $currencies;
$sess_def_show_currency = isset($_SESSION['arwshop_mk']['show_currency_id']) ? intval($_SESSION['arwshop_mk']['show_currency_id']) : 0;
 if($sess_def_show_currency > 0  && is_array($currencies[$sess_def_show_currency])){
 $currency_id = $sess_def_show_currency;
 }
 elseif($sett['def_show_currency'] > 0){
 $currency_id = intval($sett['def_show_currency']);
 }
 else{
 $currency_id = intval($sett['def_currency']);
 }
return $currencies["$currency_id"]["brief"];
}


function header404(){
global $sett, $page_tags, $custom, $http_code, $lang;
$custom->get_lang('404');
header("HTTP/1.1 404 Not Found");
$http_code = 404;
$page_tags['meta_title'] = $lang['not_found_404'];
$template = new template('404.tpl');
tpl_assign_custom($template);
return $template->out_content();
}


function load_module($mod){
global $custom, $page_tags, $sett;
$mod = preg_replace("([^a-z0-9\_\-])", '', $mod);
 if(! $mod){
 return header404();
 }
 if(is_file(MODULES_DIR."/$mod/module.php")){
 $page_tags['meta_title'] = $sett['pages_title'];
 $template = new template;
 return $template->include_in_var(MODULES_DIR."/$mod/module.php");
 }
 else{
 return header404();
 }
}


function get_content($cachecall = 0){
global $view, $mod, $sett, $pmmod, $fcat, $shop, $currencies, $lang;

 if($fcat){
  if($sett['vcatname']){
   if(substr($fcat, 0, strlen($sett['vcatname'])-1) === substr($sett['vcatname'], 0, strlen($sett['vcatname'])-1)){
   $fcat = substr($fcat, strlen($sett['vcatname']));
   }
  }
 }

custom::check_version();
custom::contentGts(INC_DIR.'/shop.php');

$request_params = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '?') + 1);
parse_str($request_params, $requiest_uri_vars);

 if(! empty($requiest_uri_vars['design'])){
  if(custom::is_valid_design($requiest_uri_vars['design'])){
  $sett['design'] = $requiest_uri_vars['design'];
  $_SESSION['arwshop_mk']['design'] = $sett['design'];
  $location = str_replace("?design=$sett[design]", '', $_SERVER['REQUEST_URI']);
  $location = str_replace("&design=$sett[design]", '', $location);
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: '.$location);
  exit;
  }
  else{
   if(! custom::is_valid_design($sett['design'])){
   die('Invalid design!');
   }
  }
 }
 elseif(! empty($_SESSION['arwshop_mk']['design'])){
  if(custom::is_valid_design($_SESSION['arwshop_mk']['design'])){
  $sett['design'] = $_SESSION['arwshop_mk']['design'];
  }
  else{
  if(! custom::is_valid_design($sett['design'])){die('Invalid design!');}
  }
 }
 else{
  if(! custom::is_valid_design($sett['design'])){
  die('Invalid design!');
  }
 }

 if(! empty($requiest_uri_vars['lang'])){
  if(is_valid_lang($requiest_uri_vars['lang'])){
  $sett['lang'] = $requiest_uri_vars['lang'];
  $_SESSION['arwshop_mk']['lang'] = $sett['lang'];
  $location = str_replace("?lang=$sett[lang]", '', $_SERVER['REQUEST_URI']);
  $location = str_replace("&lang=$sett[lang]", '', $location);
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: '.$location);
  exit;
  }
  else{
  if(! is_valid_lang($sett['lang'])){exit;}
  }
 }
 elseif(! empty($_SESSION['arwshop_mk']['lang'])){
  if(is_valid_lang($_SESSION['arwshop_mk']['lang'])){
  $sett['lang'] = $_SESSION['arwshop_mk']['lang'];
  }
  else{
  if(! is_valid_lang($sett['lang'])){exit;}
  }
 }
 else{
 if(! is_valid_lang($sett['lang'])){die('Invalid lang!');}
 }


 if(! empty($_SESSION['arwshop_mk']['user']['userid'])){
 require_once(INC_DIR."/auth_user.php");
 $auth_user = new auth_user;
 if(! $auth_user->check_auth()){unset($_SESSION['arwshop_mk']['user']);}
 }

require_once(INC_DIR."/shop.php");
$shop = new shop;
$currencies = $shop->get_currencies(0);
$sett['show_curr_brief'] = def_show_curr_brief();
$lang = array();

 if(TDTC == 1){
 include(INC_DIR.'/matches.php');
 }

require_once(INC_DIR."/template.php");
if($cachecall){$template = new template;}
custom::get_lang('lang');

 if(! empty($_GET['independ']) || ! empty($_POST['independ']) || $view == 'independ'){
  if($mod){
   if($cachecall){
   return load_module($mod);
   }
   else{
   echo load_module($mod);
   custom::engine_exit();
   }
  }
  elseif($pmmod){
  require_once(INC_DIR."/pm_modules.php");
  echo load_payment_module($pmmod);
  custom::engine_exit();
  }
  else{
   if($cachecall){
   return $template->include_in_var(INC_DIR."/pages/independ_p.php");
   }
   else{
   include(INC_DIR."/pages/independ_p.php");
   custom::engine_exit();
   }
  }
 }

return load_design();
}


function replace_null_pices($content, $replacment){
global $shop, $sett, $lang;
$price_tpl = $shop->format_price('0.00');
return preg_replace("/>(\s){0,}($lang[price]:(\x20|&nbsp;)){0,1}$price_tpl(\x20|&nbsp;)$sett[show_curr_brief](\s){0,}</", '>'.$replacment.'<', $content);
}


?>