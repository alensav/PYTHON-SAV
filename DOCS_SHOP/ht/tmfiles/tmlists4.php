<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 
error_reporting(E_ALL & ~E_NOTICE);

global $lstconf;
$lstconf = array();

/********* настройки для списков файлов TinyMCE *********/

//папка изображений
$lstconf['images_folder'] = 'img' ;

//папка файлов на которые нужно часто устанавливать ссылки
$lstconf['link_folder'] = 'pubfiles' ;

//папка медиа клипов (список медиа не поддерживается в TinyMCE 4)
//$lstconf['media_folder'] = 'pubfiles' ;

//папка шаблонов
$lstconf['templates_folder'] = 'ht/tmfiles/templates' ;

/*******************************************************/


header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
//@header('Content-type: application/x-javascript');
@header('Content-type: text/javascript');

define('ENGINE_DIR', '../..');

 //if(empty($_GET['list'])){
 //die('Empty list parameter');
 //}

echo image_list();
echo link_list();
echo template_list();

/*
 switch($_GET['list']){

 case 'image_list':
 echo image_list();
 break;

 case 'link_list':
 echo link_list();
 break;
 
 case 'template_list':
 echo template_list();
 break;
 
 }
*/

/*
{title: 'Dog', value: 'mydog.jpg'},
{title: 'Cat', value: 'mycat.gif'}
*/
function image_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[images_folder]");
$start = "var tm_image_list = [";
$ret = $start;
 if(sizeof($files)){
  foreach($files as $file){
  $ret .= "{title:'$file',value:'" . enginebaseurl() . "$lstconf[images_folder]/$file'},";
  }
 }
 if($ret != $start){
 $ret = substr($ret, 0, strlen($ret)-1);
 }
$ret .= "];\n";
return $ret;
}


function link_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[link_folder]");
$start = "var tm_link_list = [";
$ret = $start;
 if(sizeof($files)){
  foreach($files as $file){
  $ret .= "{title:'$file',value:'" . enginebaseurl() . "$lstconf[link_folder]/$file'},\n";
  }
 }
 if($ret != $start){
 $ret = substr($ret, 0, strlen($ret)-1);
 }
$ret .= "];\n";
return $ret;
}


function template_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[templates_folder]");
$start = "var tm_templates_list = [";
$ret = $start;
 if(sizeof($files)){
  foreach($files as $file){
  $ret .= "{title:'$file',description:'$file',url:'" . enginebaseurl() . "$lstconf[templates_folder]/$file'},\n";
  }
 }
 if($ret != $start){
 $ret = substr($ret, 0, strlen($ret)-1);
 }
$ret .= "];\n";
return $ret;
}


function dirfiles($dirname){
$files = array();
 if(! is_dir($dirname)){
 return $files;
 }
$handle = opendir($dirname);
 while(($file = readdir($handle)) !== false){
  if(is_file("$dirname/$file")){
   if($file !== 'index.html' && $file !== 'index.htm' && $file !== '.htaccess'){
   $file = str_replace("'", "\\'", $file);
   $file = str_replace('"', "\\\"", $file);
   array_push($files, $file);
   }
  }
 }
closedir($handle);
sort($files);
return $files;
}


function enginebaseurl(){
global $lstconf;
return substr($_SERVER['REQUEST_URI'], 0, strrpos(' '.$_SERVER['REQUEST_URI'], 'ht/tmfiles/')-1);
}


?>