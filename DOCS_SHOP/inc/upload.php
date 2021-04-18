<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class upload{

public $error_code = 0 ;
public $error_descript = '' ;

function __construct(){
global $custom;
$custom->get_lang('upload');
}


function upload_file($fieldname, $dirname, $newfilename){
 if(trim($newfilename)==''){
 return false;
 }
 if(move_uploaded_file($_FILES["$fieldname"]['tmp_name'], "$dirname/$newfilename")){
 $this->set_error($fieldname);
 return true;
 }
$this->set_error($fieldname);
return false;
}


function is_allowed_filetype($fieldname, $allow_types){
 if(in_array('*', $allow_types)){
 return true;
 }
$filetype=strtolower($_FILES["$fieldname"]["type"]);
 foreach($allow_types as $def_type){
  if(strtolower($def_type) === $filetype){
  return true;
  }
 }
return false;
}


function is_allowed_expansion($fieldname, $allow_expansions){
 if(in_array('*', $allow_expansions)){
 return true;
 }
$expansion=strtolower($this->get_expansion($_FILES["$fieldname"]['name']));
 foreach($allow_expansions as $def_expansion){
  if(strtolower($def_expansion) === $expansion){
  return true;
  }
 }
return false;
}


function is_disallowed_expansion($fieldname, $disallow_expansions){
 if(in_array('*', $disallow_expansions)){
 return true;
 }
$expansion=strtolower($this->get_expansion($_FILES["$fieldname"]['name']));
 foreach($disallow_expansions as $def_expansion){
  if(strtolower($def_expansion) === $expansion){
  return true;
  }
 }
return false;
}


function get_expansion($filename){
$filename=str_replace("\\",'/', $filename);
$pos=strrpos(' '.$filename, '/');
if($pos){$filename=substr($filename, $pos);}
$pos=strrpos(' '.$filename, '.');
if($pos){return substr($filename, $pos-1);}
return '';
}


function auto_valid_name($filename){
 if(! $this->is_valid_filename($filename)){
 mt_srand((double) microtime() * 1000000);
 $rnd=mt_rand(0,999999);
 $filename=$rnd.$this->get_expansion($filename);
 }
return $filename;
}


function auto_exists_name($dirname, $filename){
 while(file_exists("$dirname/$filename")){
 $rnd=mt_rand(0,999999);
 $filename=$rnd.$this->get_expansion($filename);
 }
return $filename;
}


function is_valid_filename($filename){
$filename = trim($filename);
 if(! $filename){
 return false;
 }
 if(! preg_match("([^a-zA-Z0-9\.\~\_\-])", $filename)){
 return true;
 }
return false;
}


function is_upload_file($fieldname){
 if(! empty($_FILES["$fieldname"]["name"]) && is_uploaded_file($_FILES["$fieldname"]["tmp_name"]) ){
 $this->set_error($fieldname);
 return true;
 }
$this->set_error($fieldname);
return false;
}


function auto_upload_file($fieldname, $dirname){
$filename=$_FILES["$fieldname"]['name'];
if(trim($filename)==''){return false;}
$filename=$this->auto_valid_name($filename);
$filename=$this->auto_exists_name($dirname, $filename);
if($this->upload_file($fieldname, $dirname, $filename)){return $filename;}
return false;
}


function user_filename($fieldname){
return $_FILES["$fieldname"]["name"];
}



function set_error($fieldname){
global $lang;
$this->error_code = isset($_FILES["$fieldname"]['error']) ? $_FILES["$fieldname"]['error'] : 0;
$this->error_descript = $lang["upload_error$this->error_code"];
}


function test_writable($dirname){
mt_srand((double) microtime() * 1000000);
$rnd_filename="$dirname/~".mt_rand(0, 999).mt_rand(0, 999).'.tmp';
 while(file_exists($rnd_filename)){
 $rnd_filename="$dirname/~".mt_rand(0, 999).mt_rand(0, 999).'.tmp';
 }
$fh=@fopen($rnd_filename,"wb");
 if(! $fh){
 return false;
 }
@fputs($fh,'test');
 if(! @fclose($fh)){
 return false;
 }
return @unlink($rnd_filename);
}


}
?>