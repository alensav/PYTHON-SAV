<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class filemgr{

public $pubfiles_dname = 'pubfiles' ;

function files_list($dirname){
global $dir, $sort, $lang, $admin_lib, $sett;

 if(! is_dir($dirname)){
 return "Invalid directory: \"$dirname\"";
 }

 if($dir){
 $dir_url = "$sett[url]$this->pubfiles_dname/$dir/";
 }
 else{
 $dir_url = "$sett[url]$this->pubfiles_dname/";
 }

$ret=<<<HTMLDATA
<script type="text/javascript">
var dir_url='$dir_url';
function flink(fname){
var lw=window.open('about:blank','','scrollbars,width=580,height=200');
var code='<!DOCTYPE html><html><head><meta http-equiv="Content-type" content="text/html; charset=$sett[charset]"><meta name="viewport" content="width=device-width, initial-scale=1"><title>$lang[link_on_file] '+fname+'</title></head><body>';
code+='$lang[link_on_file] '+fname+'<br>';
url=dir_url+fname;
code+='<a href="'+url+'" target="_blank">'+url+'</a><br><br>';
code+='$lang[link_html_code]<br><textarea cols="65" rows="4"><a href="'+url+'">$lang[download_file] '+fname+'</a></textarea>';
code+='</body></html>';
lw.document.write(code);
lw.document.close();
return false;
}
</script>
HTMLDATA;

$upload = new upload;

require_once(INC_DIR."/charset_conv.php");

$folders = array();
$files = array();

$dh = opendir($dirname);
$qw_folders=0;
 while(($file = readdir($dh)) !== false){
  if(is_file("$dirname/$file")){
  $file_stat=stat("$dirname/$file");
  $file = charset_conv::auto_recode($file);
  $expansion = mb_strtolower($upload->get_expansion($file));
  array_push($files, array('name' => $file, 'size' => $file_stat['size'], 'mtime' => $file_stat['mtime'], 'type' => $expansion));
  }
  elseif($file !== '.' && is_dir("$dirname/$file")){
  array_push($folders, $file);
   if($file !== '..'){
   $qw_folders++;
   }
  }
 }
closedir($dh);

sort($folders);

if(count($folders)){
 foreach($folders as $value){

  $img_file = 'folder.gif';
  $level_up_text = '';

  if($dir){
  $url_value = "$dir/$value";
  }
  else{
  $url_value = $value;
  }

  if($value === '..' && $dirname !== SCRIPTCHF_DIR."/$this->pubfiles_dname"){
  $url_value = $this->get_parent_dir($dir);
  $img_file = 'parent_folder.gif';
  $level_up_text = ' '.$lang['level_up'];
  }
  elseif($value === '..' && $dirname === SCRIPTCHF_DIR."/$this->pubfiles_dname"){
  $value = '';
  }

  if($value){
  $ret .=  "<a href=\"?view=filemgr&act=ed_pubfiles_list&dir=$url_value&sort=$sort\"><img src=\"adm/img/$img_file\" width=\"15\" height=\"13\" style=\"vertical-align:middle;\" alt=\"\">&nbsp;$value$level_up_text</a><br>";
  }

 }
}


usort($files, array(get_class($this), 'sort_funct'));

$qw_files=0;
 if(count($files)){
 $def_class='ttr';
 $ret .= "<table width=\"100%\"><tr class=\"htr\"><td><a href=\"?view=filemgr&act=ed_pubfiles_list&dir=$dir&sort=name\">$lang[file_name]</a></td><td><a href=\"?view=filemgr&act=ed_pubfiles_list&dir=$dir&sort=mtime\">$lang[modified_date]</a></td><td><a href=\"?view=filemgr&act=ed_pubfiles_list&dir=$dir&sort=type\">$lang[file_type]</a><td><a href=\"?view=filemgr&act=ed_pubfiles_list&dir=$dir&sort=size\">$lang[size]</a></td><td>$lang[delete]</td></tr>";
  foreach($files as $file_info){
  $def_class = $admin_lib->sett_class();
  $file_info['size']=$this->visual_filesize($file_info['size']);
  $file_info['mtime']=date("d.m.Y H:i:s", $file_info['mtime'] + $sett['time_diff'] * 3600);
  $ret .=  "<tr class=\"$def_class\"><td><a href=\"#\" onclick=\"return flink('$file_info[name]')\"><img src=\"adm/img/file.gif\" width=\"9\" height=\"11\" style=\"vertical-align:middle;\" alt=\"\">&nbsp;$file_info[name]</a></td><td>$file_info[mtime]</td><td>$file_info[type]</td><td>$file_info[size]</td><td><input type=\"checkbox\" name=\"del_pubfiles[$qw_files]\" value=\"$file_info[name]\"></td></tr>";
  $qw_files++;
  }
 $ret .= '</table>';
 }

return $ret."<br>$lang[quantity_files]: $qw_files, $lang[quantity_folders]: $qw_folders<br>$lang[link_info]<br>";
}


function filter_dirname($dirname){
global $dir;
$dirname = preg_replace("([^a-zA-Z0-9\/\~\_\-])", '', $dirname);

 if($dirname){
 $dirname = SCRIPTCHF_DIR."/$this->pubfiles_dname/$dirname";
 }
 else{
 $dirname = SCRIPTCHF_DIR."/$this->pubfiles_dname";
 }

$pos=-1;
 while($pos){
 $pos = strpos($dirname, '//');
 if($pos){$dirname = str_replace('//', '/', $dirname);}
 }

if(! is_dir($dirname)){$dirname = SCRIPTCHF_DIR."/$this->pubfiles_dname";}
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


function upload_file($dirname){
global $admset, $lang, $disallow_filemgr_expansions, $admin_lib;

if(! $admin_lib->check_admin_perms()){return '<p>'.$admin_lib->nosave_perms_msg().'</p>';}

$upload = new upload;

 if(! $upload->test_writable($dirname)){
 return "<font class=\"red\">$lang[folder] &quot;$dirname&quot; $lang[not_writable]. $lang[check_chmod].</font><hr>";
 }

$err_msg = '';
$err_msg2 = '';

 if(isset($_POST['del_pubfiles']) && is_array($_POST['del_pubfiles'])){
  if(count($_POST['del_pubfiles'])){
   foreach($_POST['del_pubfiles'] as $filename){
   $filename = preg_replace("([^a-zA-Z0-9\x20\.\~\_\-])", '', $filename);
    if(file_exists("$dirname/$filename")){
    $expansion = strtolower($upload->get_expansion($filename));
     if(in_array($expansion, $disallow_filemgr_expansions) || in_array('*', $disallow_filemgr_expansions)){
     $err_msg2 = "$lang[disallow_expansions]: $expansion.<br>";
     }
     elseif($filename !== '.htaccess'){
     @unlink("$dirname/$filename");
     }
    }
   }
  }
 }

 if($err_msg2){
 $err_msg2 = "<font color=\"#ff0000\">$err_msg2</font><hr>";
 }






 if($upload->is_upload_file('new_pubfiles')){

  if($upload->is_disallowed_expansion('new_pubfiles', $disallow_filemgr_expansions)){
  $err_msg .= $lang['disallow_expansions'] . '.<br>';
  }

 $new_filename = $upload->user_filename('new_pubfiles');
 
  if(! $upload->is_valid_filename($new_filename)){
  $err_msg.="$lang[invalid_filename]: &quot;$new_filename&quot;. $lang[valid_filename_chars]<br>";
  }

  if(file_exists("$dirname/$new_filename")){
  $err_msg.="$lang[file_already_exists]: &quot;$new_filename&quot;. $lang[how_replace_file].<br>";
  }

  if($err_msg){
  return "<font color=\"#ff0000\">$err_msg</font><hr>";
  }
  
  if(! $upload->upload_file('new_pubfiles', $dirname, $new_filename)){
  return "<font color=\"#ff0000\">$lang[cannot_upload_file] &quot;$new_filename&quot;. $lang[error_descript] ($upload->error_code): $upload->error_descript.<br></font><hr>";
  }

 
  if($admset['set_img_chmod']){
   if(is_numeric($admset['img_chmod']) && is_file("$dirname/$new_filename")){
   @chmod("$dirname/$new_filename", octdec($admset['img_chmod']));
   }
  }
  


 return "$err_msg2$lang[file] &quot;$new_filename&quot; $lang[successfully_uploaded]<hr>";
 }
 

 if($err_msg2){
 return $err_msg2;
 }

}




function show_files($dirname){
global $dir, $lang, $disallow_filemgr_expansions, $sort;
$dirname = $this->filter_dirname($dirname);
$show_dirname = substr($dirname, 2);

$upload_max_filesize = @ini_get('upload_max_filesize');
$max_filesize_int = intval($upload_max_filesize);
$max_filesize_txt = '';
 if($max_filesize_int < 8){
 $max_filesize_txt = " ($lang[max_filesize] $upload_max_filesize $lang[limited_directive] upload_max_filesize <a href=\"?view=phpinfo&independ=1\" target=\"_blank\">$lang[in_php_config]</a>)";
 }


$ret=<<<HTMLDATA
<h3>$lang[files]</h3>
<p>$lang[browse_folder] <b>$show_dirname</b></p>
<form action="?" method="POST" enctype="multipart/form-data" style="margin:0px;">
<input type="hidden" name="view" value="filemgr">
<input type="hidden" name="act" value="ed_pubfiles_list">
<input type="hidden" name="dir" value="$dir">
<input type="hidden" name="sort" value="$sort">
<input type="hidden" name="upload_pubfiles" value="1">
&nbsp;$lang[upload_new_file]$max_filesize_txt<br>&nbsp;<input type="file" name="new_pubfiles" class="InputFile">&nbsp;<input type="submit" value="$lang[upload]" class="button1"><hr>
HTMLDATA;
require(INC_DIR."/admin/filemgr_types.php");
 if(isset($_POST['upload_pubfiles'])){
 $ret .= $this->upload_file($dirname);
 }
$ret .= $this->files_list($dirname);
$ret .= "<br><input type=\"submit\" value=\"$lang[delete_selected_files]\" class=\"button1\"></form>";
return $ret;
}



function visual_filesize($size_bytes){
global $lang;
 if($size_bytes < 1024){
 return $size_bytes . ' ' . $lang['bytes'];
 }
 elseif($size_bytes < 1048576){
 return sprintf("%.2f", $size_bytes/1024) . " $lang[kilobytes] ($size_bytes $lang[bytes])";
 }
 else{
 return sprintf("%.2f", $size_bytes/1048576) . " $lang[megabytes] ($size_bytes $lang[bytes])";
 }
}


function sort_funct($str1, $str2){
global $sort;

 switch($sort){
 
 case 'name':
  if($str1['name'] > $str2['name']){
  return 1;
  }
  elseif($str1['name'] < $str2['name']){
  return -1;
  }
  else{
  return 0;
  }
 break;

 case 'mtime':
  if($str1['mtime'] < $str2['mtime']){
  return 1;
  }
  elseif($str1['mtime'] > $str2['mtime']){
  return -1;
  }
  else{
  return 0;
  }
 break;

 case 'type':
  if($str1['type'] > $str2['type']){
  return 1;
  }
  elseif($str1['type'] < $str2['type']){
  return -1;
  }
  else{
  return 0;
  }
 break;

 case 'size':
  if($str1['size'] > $str2['size']){
  return 1;
  }
  elseif($str1['size'] < $str2['size']){
  return -1;
  }
  else{
  return 0;
  }
 break;
 
 }
return 0;
}



}
?>
