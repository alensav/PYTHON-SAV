<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

$e_conv_charset = new engine_conv_charset;

 if(isset($_POST['cc_act'])){
  switch($_POST['cc_act']){

  case 'do_conv_db':
  echo $e_conv_charset->convert_db();
  break;

  case 'conv_files_form':
  echo $e_conv_charset->convert_files_form();
  break;


  case 'do_conv_files':
   if(isset($_POST['not_conv_files']) && ! empty($_POST['not_conv_files'])){
   $not_conv_files = true;
   }
   else{
   $not_conv_files = false;
   }
  echo $e_conv_charset->convert_files($_POST['sel_charset'], $not_conv_files);
  break;

  }
 }
 else{
 echo $e_conv_charset->convert_db_form();
 }



class engine_conv_charset{

private $conv_directories = array('mail_tpl', 'design');
private $conv_extensions = array('.tpl', '.css', '.txt');
private $conv_dirs_chmod = '0777';
private $conv_files_chmod = '0777';

function convert_db_form($processed_info = ''){
global $lang;

 if(! empty($processed_info)){
 $processed_info = "<div style=\"color:#009d00;font-size:20px;font-weight:bold;margin-bottom:12px;\">$processed_info</div>";
 }
 else{
 $this->pre_cache_db(DB_PREFIX, $exception_tables = array(DB_PREFIX.'cache'));
 }

return <<<HTMLDATA
<script type="text/javascript">
function processed(form){
 try{
 form.submit.disabled=true;
 form.submit.style.cursor='wait';
 document.getElementById('processedImg').style.display='block';
 }catch(e){}
}
</script>
<h1>$lang[cc_convert_db_charset]</h1>
$processed_info
$lang[cc_convert_db_info]<br>
$lang[cc_clear_cache]<br>
$lang[cc_stages_info]<br><br>
<form action="?" method="POST" onsubmit="processed(this);">
<input type="hidden" name="step" value="license_form">
<input type="hidden" name="agree_license" value="On">
<input type="hidden" name="cc_act" value="do_conv_db">
<div id="processedImg" style="margin-bottom:12px;display:none;"><img src="processed.gif" alt="Processed..."></div>
<input type="submit" name="submit" value="$lang[continue]">
</form>
HTMLDATA;
}


function convert_db(){
global $db, $lang;
$max_exec_time = $this->calc_max_exec_time();

$start_time = $this->get_mktime();

$all_tables = $this->get_all_db_tables();
$engine_tables = $this->get_engine_db_tables($all_tables, DB_PREFIX);
sort($all_tables);

$sett_cc_converted_tables = $this->getTxtS('cc_converted_tables');

$converted_tables = array();
 if(! empty($sett_cc_converted_tables)){
 $converted_tables = explode(',', $sett_cc_converted_tables);
 }

 if(in_array(DB_PREFIX.'cache', $engine_tables) && count($converted_tables) == 0){
 require_once(INC_DIR."/admin/cache_adm.php");
 $cache_adm = new cache_adm;
 $cache_adm->clear_cache();
 }

require_once(INC_DIR."/admin/admin_lib.php");
$admin_lib = new admin_lib;

$db->query("SET sql_mode = ''") or die($db->error());

 foreach($engine_tables as $tbl){

  if(! in_array($tbl, $converted_tables)){
  $db->query("ALTER TABLE `$tbl` CONVERT TO CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'") or die($db->error());
  array_push($converted_tables, $tbl);
  }

  if(count($converted_tables) == count($engine_tables)){
  $admin_lib->delete_txtsettings(array('cc_converted_tables'));
  }
  elseif(($this->get_mktime() - $start_time) >= $max_exec_time){
  $converted_str = implode(',', $converted_tables);
  $admin_lib->save_txtsettings(array('cc_converted_tables' => $converted_str), false);
  $processed_percent = round(count($converted_tables) * 100 / count($engine_tables));
  return $this->convert_db_form("$lang[cc_processed] $processed_percent %");
  }

 }

$this->update_pmblanks();

 if(count($engine_tables) == count($all_tables)){
 $db->query("ALTER DATABASE `$db->dbname` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'");
 }

return <<<HTMLDATA
<h1>$lang[cc_conv_db_completed]</h1>
<form action="?" method="POST" onsubmit="this.submit.disabled=true;">
<input type="hidden" name="step" value="license_form">
<input type="hidden" name="agree_license" value="On">
<input type="hidden" name="cc_act" value="conv_files_form">
<input type="submit" name="submit" value="$lang[continue]">
</form>
HTMLDATA;
}



function convert_files_form($err = ''){
global $lang;
$exts = implode($this->conv_extensions, ', ');
require_once(INC_DIR."/charset_conv.php");
$detected_charset = $this->detect_files_charset();
$autodetect_msg = '';
 if(! empty($detected_charset)){
 $autodetect_msg = "$lang[cc_autodetected_charset] <b>$detected_charset</b> ($lang[cc_autodetect_not_accurate]).<br>";
 }


$design_selbox = $this->design_selectbox();

$charset_selbox = charset_conv::charsets_selectbox($detected_charset, true);

 if(! empty($err)){
 $err = '<div class="red">'.$err.'</div>';
 }

return <<<HTMLDATA
$err
<form action="?" method="POST" onsubmit="this.submit.disabled=true;">
<input type="hidden" name="step" value="license_form">
<input type="hidden" name="agree_license" value="On">
<input type="hidden" name="cc_act" value="do_conv_files">
<h1>$lang[cc_conv_files]</h1>
<p>$lang[cc_files_convert] $exts $lang[cc_in_directories]<br>$lang[cc_backup_info]</p>

<p>
$lang[cc_select_design]<br>
$design_selbox<br>
</p>

<p>
$lang[cc_select_charset]<br>
$autodetect_msg
$lang[cc_old_charset_info]<br>
$charset_selbox<br>
</p>

<input type="checkbox" name="not_conv_files" id="not_conv_files" onclick="if(this.checked){alert('$lang[not_conv_files_warning]');}"> <label for="not_conv_files">$lang[cc_not_conv_files]</label><br><br>
<input type="submit" name="submit" value="$lang[continue]">
</form>
HTMLDATA;
}



function convert_files($from_charset, $not_conv_files){
global $lang;
$ret = '';

 if(! $not_conv_files && $from_charset !== 'utf-8'){

 $conv_design = preg_replace("([^a-zA-Z0-9\_\-])", '', $_POST['conv_design']);

  if(empty($conv_design)){
  return $this->convert_files_form('No design selected!');
  }

  if(empty($from_charset)){
  return $this->convert_files_form($lang['cc_charset_not_selected']);
  }

  foreach($this->conv_directories as $key => $dirname){
   if($dirname === 'design'){
   $this->conv_directories["$key"] = "$dirname/$conv_design";  
   break;
   }
  }

require_once(INC_DIR."/external/pclzip/pclzip.lib.php");
$files = $this->conv_files_list();

 $bk_archive_name = SCRIPTCHF_DIR.'/adm/dump/update-backup-'.date('Y-m-d_H-i-s', time()).'.zip';
 $pclzip = new PclZip($bk_archive_name);
 $res = $pclzip->create($files, PCLZIP_OPT_REMOVE_PATH, '..');
  if(! is_array($res)){
  return $this->convert_files_form("$lang[cc_cannot_create_file_in_dir] ".SCRIPTCHF_DIR."/adm/dump. $lang[cc_check_chmod]");
  }



  require_once(INC_DIR."/charset_conv.php");

  $msg = '';

  if(! $this->conv_files_arr($files, $from_charset)){

  $tmpdir = $this->make_conv_dir(SCRIPTCHF_DIR."/adm/dump", $this->conv_dirs_chmod);
   if(empty($tmpdir)){
   return $this->convert_files_form("$lang[cc_cannot_mk_tmp] ".SCRIPTCHF_DIR."/adm/dump. $lang[cc_check_chmod]");
   }

   if(! $this->copy_and_conv_files($tmpdir, $from_charset)){
   return $this->convert_files_form("$lang[cc_cannot_copy_in_tmp] ".SCRIPTCHF_DIR."/adm/dump/$tmpdir");
   }

  $converted_dirs = array();
   foreach($this->conv_directories as $dirname){
   array_push($converted_dirs, SCRIPTCHF_DIR."/adm/dump/$tmpdir/$dirname");
   }

   foreach($converted_dirs as $dirname){
   $this->chmod_folders_and_files($dirname);
   }

  $conv_archive_name = SCRIPTCHF_DIR.'/adm/dump/converted-files-'.date('Y-m-d_H-i-s', time()).'.zip';
  $pclzip = new PclZip($conv_archive_name);
  $res = $pclzip->create($converted_dirs, PCLZIP_OPT_REMOVE_PATH, SCRIPTCHF_DIR."/adm/dump/$tmpdir");
   if(! is_array($res)){
   return $this->convert_files_form("$lang[cc_cannot_create_file_in_dir] ".SCRIPTCHF_DIR."/adm/dump. $lang[cc_check_chmod]");
   }

  @$this->deltree(SCRIPTCHF_DIR."/adm/dump/$tmpdir");

  $ret .= "<p>$lang[cc_converted_files_in_archive] $conv_archive_name.<br>$lang[cc_move_converted_files]</p>";

  }


 $ret .= "<p>$lang[cc_backup_file] $bk_archive_name</p>";


 }
 else{
 $ret .= "<p>$lang[cc_independ_convert_files]</p>";
 }



require_once(INC_DIR."/admin/admin_lib.php");
$admin_lib = new admin_lib;
$admin_lib->save_settings(8, array('db_charset' => 'utf8'), 0);

return <<<HTMLDATA
<h1>$lang[cc_conv_files_completed]</h1>
$ret
<form action="?" method="POST">
<input type="hidden" name="step" value="license_form">
<input type="hidden" name="agree_license" value="On">
<input type="submit" value="$lang[continue]">
</form>
HTMLDATA;
}



function get_all_db_tables(){
global $db;
$tables = array();
$res = $db->query("SHOW TABLES FROM `$db->dbname`") or die($db->error());
 while($row = $db->fetch_row($res)){
 array_push($tables, $row[0]);
 }
return $tables;
}


function get_engine_db_tables($all_tables, $prefix){
global $db;
$engine_tables = array();
$lenprefix = strlen($prefix);
 foreach($all_tables as $tbl){
  if(substr($tbl, 0, $lenprefix) === $prefix){
  array_push($engine_tables, $tbl);
  }
 }
return $engine_tables;
}


function pre_cache_db($prefix, $exception_tables = array()){
global $db;
$tables = $this->get_engine_db_tables($this->get_all_db_tables(), $prefix);
 foreach($tables as $tbl){
  if(! in_array($tbl, $exception_tables)){
  $res = $db->query("SELECT * FROM `$tbl`") or die($db->error());
   while($row = $db->fetch_assoc($res)){}
  }
 }
}


function get_mktime(){
list($usec, $sec) = explode(' ', microtime());
return floatval($usec) + floatval($sec);
}


function calc_max_exec_time(){
$max_exec_time = intval(ini_get('max_execution_time'));
 if($max_exec_time == 0){
 $max_exec_time = 30;
 }
$max_exec_time -= 5;
 if($max_exec_time < 1){
 $max_exec_time = 1;
 }
return $max_exec_time;
}


function update_pmblanks(){
global $db;
$tbl=DB_PREFIX.'payment_blanks';
$res = $db->query("SELECT `blank_id`, `blank_text` FROM `$tbl`") or die($db->error());
 while($row = $db->fetch_assoc($res)){
 $row['blank_text'] = $this->replace_meta_charset($row['blank_text']);
 $row['blank_text'] = $db->secstr($row['blank_text']);
 $db->query("UPDATE `$tbl` SET `blank_text` = '$row[blank_text]' WHERE `blank_id` = '$row[blank_id]'") or die($db->error());
 }
}


function replace_meta_charset($str){
return preg_replace("/(\;[\x20\x09\x0D\x0A]{0,100}charset\=)[a-zA-Z0-9\-]{1,50}([\x22\x27]{1,1})/", '\\1utf-8\\2', $str);
}


function detect_files_charset(){
$detected_charsets = array();
$files = $this->conv_files_list();

 foreach($files as $file){
 $text = file_get_contents($file);

 $charset = charset_conv::detect_charset($text);
  if(! empty($charset) && $charset !== 'utf-8'){
   if(! array_key_exists($charset, $detected_charsets)){
   $detected_charsets["$charset"] = 1;
   }
   else{
   $detected_charsets["$charset"] ++;
   }
  }

 $adv_charset = $this->adv_detect($text);
  if(! empty($adv_charset) && $adv_charset !== 'utf-8'){
   if(! array_key_exists($adv_charset, $detected_charsets)){
   $detected_charsets["$adv_charset"] = 1;
   }
   else{
   $detected_charsets["$adv_charset"] ++;
   }
  }

 }

$maxname='';
 if(count($detected_charsets)){
 $max=0;
  foreach($detected_charsets as $name => $count){
   if($count > $max){
   $max = $count;
   $maxname = $name;
   }
  }
 }

return $maxname;
}


function adv_detect($str){
preg_match("/\;[\x20\x09\x0D\x0A]{0,100}charset\=([a-zA-Z0-9\-]{1,50})[\x22\x27]{1,1}/", $str, $matches);
 if(isset($matches[1])){
 return strtolower($matches[1]);
 }
}


function conv_files_list(){
$files = array();
 foreach($this->conv_directories as $dirname){
 $dirname = SCRIPTCHF_DIR."/$dirname";
 $this->files_lst($dirname, $files);
 }
return $files;
}


function files_lst($dirname, &$files){
 if(is_dir($dirname)){
 $dh = opendir($dirname);
  while(($file = readdir($dh)) !== false){
   if(is_file("$dirname/$file")){
    if(in_array($this->get_expansion($file), $this->conv_extensions)){
    array_push($files, "$dirname/$file");
    }
   }
   elseif($file !== '.' && $file != '..' && is_dir("$dirname/$file")){
   $this->files_lst("$dirname/$file", $files);
   }
  }
 closedir($dh);
 }
return true;
}


function get_expansion($filename){
$filename=str_replace("\\",'/', $filename);
$pos=strrpos(' '.$filename, '/');
if($pos){$filename=substr($filename, $pos);}
$pos=strrpos(' '.$filename, '.');
if($pos){return substr($filename, $pos-1);}
return '';
}


function make_conv_dir($in_dir, $chmod_str){
 if(! is_dir($in_dir)){
 return false;
 }
$tmpname = 'conv-'.date('Y-m-d', time());
 if(is_dir($in_dir.'/'.$tmpname)){
 return $tmpname;
 }
$res = @mkdir($in_dir.'/'.$tmpname);
 if($res){
 @chmod($in_dir.'/'.$tmpname, octdec($chmod_str));
 @mkdir($in_dir.'/'.$tmpname.'/design');
 @chmod($in_dir.'/'.$tmpname.'/design', octdec($chmod_str));
 return $tmpname;
 }
 else{
 return false;
 }
}



function copy_and_conv_files($tmpdir, $from_charset){
 foreach($this->conv_directories as $dirname){
  if(! $this->conv_dircopy(SCRIPTCHF_DIR."/$dirname", SCRIPTCHF_DIR."/adm/dump/$tmpdir/$dirname", $from_charset)){
  return false;
  }
 }
return true;
}



function conv_dircopy($oldname, $newname, $from_charset){
 if(! is_dir($oldname)){
 return false;
 }
 if(! file_exists($newname)){
  if(! @mkdir($newname)){
  return false;
  }
 @chmod($newname, octdec($this->conv_dirs_chmod));
 }
$dh = @opendir($oldname);
 if(! $dh){
 return false;
 }
 while(($file = readdir($dh)) !== false){
  if($file != '.' && $file != '..'){
   if(is_file("$oldname/$file")){
    if(in_array($this->get_expansion($file), $this->conv_extensions)){
     if(! @copy("$oldname/$file", "$newname/$file")){
     closedir($dh);
     return false;
     }
    @chmod("$newname/$file", octdec($this->conv_files_chmod));
    $text = file_get_contents("$newname/$file");
    $text = $this->conv_text($text, $from_charset);
     if(! $this->write_to_file("$newname/$file", $text)){
     closedir($dh);
     return false;
     }
    }
   }
   elseif(is_dir("$oldname/$file")){
    if(! $this->conv_dircopy("$oldname/$file", "$newname/$file", $from_charset)){
    closedir($dh);
    return false;
    }
   }
  }
 }
closedir($dh);
return true;
}


function conv_files_arr($files, $from_charset){
 foreach($files as $file){
 $text = file_get_contents($file);
 $text = $this->conv_text($text, $from_charset);
  if(! $this->write_to_file($file, $text)){
  return false;
  }
 }
return true;
}


function conv_text($str, $from_charset){
 if(preg_match('/./u', $str)){
 return $this->replace_meta_charset($str);
 }
$str = charset_conv::recode_str($str, $from_charset, 'utf-8');
return $this->replace_meta_charset($str);
}


function write_to_file($file, $data){
$fh = @fopen($file, 'wb');
 if(! $fh){
 return false;
 }
 if(@fputs($fh, $data) === false){
 return false;
 }
return fclose($fh);
}


function chmod_folders_and_files($dir, $files_chmod = '0644', $folders_chmod = '0755'){
$res = true;
 if(is_dir($dir)){
 $dh = @opendir($dir);
  if(! $dh){
  @chmod($dir, octdec($folders_chmod));
  return false;
  }
  while(($file = readdir($dh)) !== false){
   if($file !== '.' && $file !== '..'){
    if(is_dir("$dir/$file")){
     if(! $this->chmod_folders_and_files("$dir/$file", $files_chmod, $folders_chmod)){
     $res = false;
     }
    }
    else{
     if(! @chmod("$dir/$file", octdec($files_chmod))){
     $res = false;
     }
    }
   }
  }
 closedir($dh);
  if(! @chmod($dir, octdec($folders_chmod))){
  $res = false;
  }
 }
 else{
  if(! @chmod($dir, octdec($files_chmod))){
  $res = false;
  }
 }
return $res;
}


function getTxtS($setname){
global $db;
$setname = preg_replace('([^a-zA-Z0-9\_\-])', '', $setname);
$tbl = DB_PREFIX.'txtsettings';
$res = $db->query("SELECT setvalue FROM $tbl WHERE setname='$setname'") or die($db->error());
return @$db->result($res);
}


function deltree($dir){
 if(is_dir($dir)){
 $dh=opendir($dir);
  while(($file = readdir($dh)) !== false){
   if($file !== '.' && $file !== '..'){
   $this->deltree("$dir/$file");
   }
  }
 closedir($dh);
 $res=rmdir($dir);
  if($res){
  return true;
  }
  else{
  return false;
  }
 }
 elseif(file_exists($dir)){
 $res=unlink($dir);
  if($res){
  return true;
  }
  else{
  return false;
  }
 }
}


function design_selectbox(){
global $sett, $lang;
 if(isset($_POST['conv_design'])){
 $selected_design = $_POST['conv_design'];
 }
 else{
 $selected_design = $sett['design'];
 }
$ret = '<select name="conv_design">';
if(is_dir(DESIGN_DIR)){
$dirhandle = opendir(DESIGN_DIR);
 while(($dirname = readdir($dirhandle)) !== false){
  if($dirname != '.' && $dirname != '..' && $dirname != 'index.htm' && $dirname != 'index.html' && $dirname != '.htaccess'){
   if(is_dir(DESIGN_DIR."/$dirname")){
    if(is_file(DESIGN_DIR."/$dirname/info.txt")){
     if($dirname === $selected_design){
     $selected = ' selected';
     $now_used = " ($lang[cc_now_used])";
     }
     else{
     $selected = '';
     $now_used = '';
     }
    $ret .= "<option value=\"$dirname\"$selected>$dirname$now_used";
   }
   }
  }
 }
closedir($dirhandle);
}
$ret .= '</select>';
return $ret;
}



}
?>