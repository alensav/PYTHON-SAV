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

//папка медиа клипов
$lstconf['media_folder'] = 'pubfiles' ;

//папка шаблонов
$lstconf['templates_folder'] = 'ht/tmfiles/templates' ;

/*******************************************************/


header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
//@header('Content-type: application/x-javascript');
@header('Content-type: text/javascript');

define('ENGINE_DIR', '../..');

 if(empty($_GET['list'])){
 die('Empty list parameter');
 }

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
 
 case 'media_list':
 echo media_list();
 break;
 
 }


function image_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[images_folder]");
$retval = '';
 if(sizeof($files)){
 $retval = 'tinyMCEImageList = new Array('."\n".'//Name, URL'."\n";
  foreach($files as $file){
  //Name, URL
  $retval .= "['$file', '" . enginebaseurl() . "$lstconf[images_folder]/$file'],\x0A";
  }
 }
 if($retval){
 $retval = substr($retval, 0, strlen($retval)-2)."\n";
 $retval .= ');';
 }
return $retval;
}


function link_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[link_folder]");
$retval = '';
 if(sizeof($files)){
 $retval = 'var tinyMCELinkList = new Array('."\n".'//Name, URL'."\n";
  foreach($files as $file){
  //Name, URL
  $retval .= "['$file', '" . enginebaseurl() . "$lstconf[link_folder]/$file'],\x0A";
  }
 }
 if($retval){
 $retval = substr($retval, 0, strlen($retval)-2)."\n";
 $retval .= ');';
 }
return $retval;
}


function media_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[media_folder]");
$retval = '';
 if(sizeof($files)){
 $retval = 'var tinyMCEMediaList = ['."\n".'//Name, URL'."\n";
  foreach($files as $file){
  //Name, URL
  $retval .= "['$file', '" . enginebaseurl() . "$lstconf[media_folder]/$file'],\x0A";
  }
 }
 if($retval){
 $retval = substr($retval, 0, strlen($retval)-2)."\n";
 $retval .= '];';
 }
return $retval;
}


function template_list(){
global $lstconf;
$files = dirfiles(ENGINE_DIR."/$lstconf[templates_folder]");
$retval = '';
 if(sizeof($files)){
 $retval = 'var tinyMCETemplateList = ['."\n".'//Name, URL, Description'."\n";
  foreach($files as $file){
  //Name, URL, Description
  $retval .= "['$file', '" . enginebaseurl() . "$lstconf[templates_folder]/$file', '$file'],\x0A";
  }
 }
 if($retval){
 $retval = substr($retval, 0, strlen($retval)-2)."\n";
 $retval .= '];';
 }
return $retval;
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