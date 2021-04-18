<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class ed_images{

function images_list($dirname){
global $allow_imgexpansions, $upload, $dir, $lang, $admin_lib, $dir;


if(! is_dir($dirname)){return '';}

$ret = '';

require_once(INC_DIR."/charset_conv.php");

$folders = array();
$files = array();

$dh = opendir($dirname);
 while(($file = readdir($dh)) !== false){


  if(is_file("$dirname/$file")){
  $file = charset_conv::auto_recode($file);
  $expansion = strtolower($upload->get_expansion("$dirname/$file"));
   if(in_array($expansion, $allow_imgexpansions) || in_array('*', $allow_imgexpansions)){
   array_push($files, $file);
   }
  }
  elseif($file !== '.' && is_dir("$dirname/$file")){
  array_push($folders, $file);
  }

 }
closedir($dh);

if(count($folders)){
 foreach($folders as $value){

  $img_file = 'folder.gif';

  if($dir){
  $url_value = "$dir/$value";
  }
  else{
  $url_value = $value;
  }

  if($value === '..' && $dirname !== SCRIPTCHF_DIR."/img"){
  $url_value = $this->get_parent_dir($dir);
  $img_file = 'parent_folder.gif';
  }
  elseif($value === '..' && $dirname === SCRIPTCHF_DIR."/img"){
  $value = '';
  }

  if($value){
  $ret .=  "<a href=\"?view=editor&act=ed_img_list&dir=$url_value&independ=1\"><img src=\"adm/img/$img_file\" width=\"15\" height=\"13\" style=\"vertical-align:middle;\" alt=\"\">&nbsp;$value</a><br>";
  }

 }
}

 if(count($files)){
 $qw_images=0;
 $def_class='ttr';
 $ret .= "<table width=\"100%\"><tr class=\"htr\"><td>$lang[file]</td><td>$lang[delete]</td></tr>";
  foreach($files as $value){
 $def_class = $admin_lib->sett_class();
  $ret .=  "<tr class=\"$def_class\"><td><a href=\"#\" onclick=\"return sel_file('$value')\"><img src=\"adm/img/file.gif\" width=\"9\" height=\"11\" style=\"vertical-align:middle;\" alt=\"\">&nbsp;$value</a></td><td><input type=\"checkbox\" name=\"del_img[$qw_images]\" value=\"$value\"></td></tr>";
  $qw_images++;
  }
 $ret .= "<tr><td colspan=\"2\" align=\"center\"><br><input type=\"submit\" value=\"$lang[delete_selected_files]\" class=\"InputFileSm\"></td></tr>";
 $ret .= '</table>';
 }

return $ret.'<br>';
}


function filter_dirname($dirname){
$dirname = preg_replace("([^a-zA-Z0-9\/\~\_\-])", '', $dirname);

 if($dirname){
 $dirname = SCRIPTCHF_DIR."/img/$dirname";
 }
 else{
 $dirname = SCRIPTCHF_DIR."/img";
 }

$pos=-1;
 while($pos){
 $pos = strpos($dirname, '//');
 if($pos){$dirname = str_replace('//', '/', $dirname);}
 }

if(! is_dir($dirname)){$dirname = SCRIPTCHF_DIR."/img";}
return $dirname;
}


function get_parent_dir($dir){
$pos=strrpos($dir, '/');
 if($pos){
 return substr($dir, 0, $pos);
 }
 else{
 return '';
 }
}


function upload_image($dirname){
global $admset, $upload, $lang, $allow_imgtypes, $allow_imgexpansions, $admin_lib;
$err_msg = '';

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}


 if(isset($_POST['del_img']) && is_array($_POST['del_img'])){
  if(count($_POST['del_img'])){
   foreach($_POST['del_img'] as $filename){
   $filename = preg_replace("([^a-zA-Z0-9\.\~\_\-])", '', $filename);
   if(file_exists("$dirname/$filename") && $filename !== '.htaccess'){@unlink("$dirname/$filename");}
   }
  }
 }


 if($upload->is_upload_file('new_img')){

  if(! $upload->is_allowed_filetype('new_img', $allow_imgtypes)){
  $err_msg.="$lang[allow_imgtypes] " .implode(' ', $allow_imgtypes). '<br>';
  }

  if(! $upload->is_allowed_expansion('new_img', $allow_imgexpansions)){
  $err_msg.="$lang[allow_expansions] " .implode(' ', $allow_imgexpansions). '<br>';
  }

if($err_msg){return "<font color=\"#ff0000\">$err_msg</font><hr>";}

 $new_filename = $upload->auto_upload_file('new_img', $dirname);
  if($admset['set_img_chmod']){
   if(is_numeric($admset['img_chmod']) && is_file("$dirname/$new_filename")){
   @chmod("$dirname/$new_filename", octdec($admset['img_chmod']));
   }
  }

 return "$lang[file] '$new_filename' $lang[successfully_uploaded]<hr>";
 }
}


}
?>
