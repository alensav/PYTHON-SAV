<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/db_restore');

 if(! empty($_POST['restore']) && defined('DB_PREFIX') && DB_PREFIX !== ''){
 echo restore_database();
 }

echo <<<HTMLDATA
<script type="text/javascript">
function disable_srv_files(value){
 try{
  for(i=0;i<document.frm.srv_file.length;i++){
  document.frm.srv_file[i].disabled=value;
  }
 }catch(e){}
}
</script>
<form name="frm" action="?" method="POST" enctype="multipart/form-data" onsubmit="document.frm.submit.disabled=true;">
<input type="hidden" name="view" value="tools">
<input type="hidden" name="tname" value="db_restore">
<input type="hidden" name="restore" value="1">
<h3>$lang[db_restore]</h3>

<p>$lang[warning]<br><a href="?view=tools&tname=dbcopy">$lang[make_db_copy]</a></p>

<table class="settbl">
 <tr class="htr">
  <td colspan="2">$lang[select_file_for_restore]</td>
 </tr>
HTMLDATA;


$files=array();
$dirhandle=opendir(SCRIPTCHF_DIR."/adm/dump");
$fcount=0;
 while(($filename = readdir($dirhandle)) !== false){
  $length_filename=strlen($filename);
  if( (substr($filename, $length_filename-4) == '.sql' || substr($filename, $length_filename-3) == '.gz') && (substr($filename, 0, 7) == 'db_copy')  ){
  array_push($files, $filename);
  $fcount++;
  }
 }
closedir($dirhandle);

rsort($files);

 if($fcount){
  foreach($files as $filename){
  $def_class=$admin_lib->sett_class();
  if(isset($_POST['srv_file']) && $_POST['srv_file'] == $filename){$checked=' checked="checked"';}else{$checked='';}
  echo "<tr class=\"$def_class\"><td align=\"center\"><input type=\"radio\" name=\"srv_file\" value=\"$filename\"$checked></td><td>$filename</td></tr>";
  }
 }

echo <<<HTMLDATA
</table>
<h4>$lang[upload_file]</h4>
$lang[select_file_for_restore] (*.sql; *.sql.gz)<br>
<input type="file" name="upload_file" onchange="if(this.value){disable_srv_files(true);}else{disable_srv_files(false);}" class="InputFile"><br><br>
$lang[time_is_required]
<br><br>
<input type="submit" name="submit" value="$lang[db_restore]" class="button1">
</form>
HTMLDATA;



function restore_database(){
global $lang, $admin_lib, $custom, $sett;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(function_exists('set_time_limit')){
 @set_time_limit(600);
 }

require_once(INC_DIR."/upload.php");
$upload = new upload;

$gzip = 0;

 if($upload->is_upload_file("upload_file")){
  if(! $upload->is_allowed_expansion("upload_file", array('.sql', '.gz') ) ){
  return "<span class=\"red\">$lang[allowed_expansions]:<br>.sql<br>.sql.gz<hr></span>";
  }
 $filename = $_FILES['upload_file']['tmp_name'];
 $user_fname = $upload->user_filename('upload_file');
  if(strtolower( substr($user_fname, strlen($user_fname)-3) ) === '.gz'){
  $gzip = 1;
  }
 }
 elseif($_POST['srv_file']){
 $filename = $_POST['srv_file'];
 $filename = preg_replace("([^a-zA-Z0-9\_\.\-])", '', $filename);
 $filename = preg_replace("(\.\.)", '', $filename);
  if(strtolower( substr($filename, strlen($filename)-4) ) !== '.sql' && strtolower( substr($filename, strlen($filename)-3) ) !== '.gz'){
  return "<span class=\"red\">$lang[allowed_expansions]:<br>.sql<br>.gz</span><hr>";
  }
 $filename = SCRIPTCHF_DIR."/adm/dump/$filename";
  if(strtolower( substr($filename, strlen($filename)-3) ) === '.gz'){
  $gzip = 1;
  }
 }
 else{
 return "<span class=\"red\">$lang[file_not_selected]<br></span>";
 }

 if(! file_exists($filename)){
 return "<span class=\"red\">$lang[file_not_found] \"$filename\"<br></span>";
 }

$dump_info = getDumpInfo($filename, $gzip);




  if($dump_info['version'] != $sett['db_version']){
  return "<span class=\"red\">$lang[not_valid_version] ($dump_info[version])<br>$lang[default_version]: ".$sett['db_version']."<br></span>";
  }

 if($dump_info['prefix'] != DB_PREFIX){
 return "<span class=\"red\">$lang[not_valid_prefix] ($dump_info[prefix])<br>$lang[default_prefix]: ".DB_PREFIX."<br>$lang[edit_prefix] $dump_info[prefix] $lang[to] " . DB_PREFIX . '<br></span>';
 }

delete_tables(DB_PREFIX);

exec_sqlfile($filename, $gzip);

return "<h3>$lang[restore_success]</h3>";
}




function delete_tables($prefix){
global $db;
$res = $db->query("SHOW TABLES FROM `$db->dbname`") or die($db->error());
if(! $res){return false;}
$dtables = '';

 while($row=$db->fetch_row($res)){
  if(substr($row[0], 0, strlen($prefix)) == $prefix){
   if(! empty($dtables)){
   $dtables .= ', ';
   }
  $dtables .= "`$row[0]`";
  }
 }

 if(! empty($dtables)){
 $res = $db->query("DROP TABLE $dtables") or die($db->error());
 if(! $res){return false;}
 }

return true;
}




function exec_sqlfile($fname, $gzip=0){
if(! file_exists($fname)){return false;}
global $db;

 if($gzip){
 $fh_input = gzopen($fname, "r") or die("Can't open file $fname");
 }
 else{
 $fh_input = fopen($fname, "r") or die("Can't open file $fname");
 }

$line=0;

 while(! rfile_eof($fh_input, $gzip)){
 $str = rfile_gets($fh_input, 1048576, $gzip);
 $line++;
 if(substr($str, 0, 1) != "\x0D" && substr($str, 0, 1) != "\x0A"){$str=trim($str);}

  if($str && substr($str, 0, 2) != '--' && substr($str, 0, 1) != '#'){
  $query .= $str;

    if(substr($query, strlen($query)-1) == ';'){

      if($query){
      $res = $db->query($query) or die($db->error()." (Line: $line at SQL file)<br>");
      if(! $res){return false;}
      }

    $query = '';
    }

  }
  else{
  $query = '';
  }

 }

 if($gzip){
 gzclose($fh_input);
 }
 else{
 fclose($fh_input);
 }

return true;
}




function rfile_eof($fh_input, $gzip){
 if($gzip){
 return gzeof($fh_input);
 }
 else{
 return feof($fh_input);
 }
}




function rfile_gets($fh_input, $size, $gzip){
 if($gzip){
 return gzgets($fh_input, $size);
 }
 else{
 return fgets($fh_input, $size);
 }
}




function getDumpInfo($filename, $gzip){
 if($gzip){
 $fh = gzopen($filename, "r") or die("Can't open file $fname");
 }
 else{
 $fh = fopen($filename, "r") or die("Can't open file $fname");
 }

$dump_version = rfile_gets($fh, 256, $gzip);
$dump_version = trim(substr(trim($dump_version), 23));
$dump_version = preg_replace("([^0-9\.])", '', $dump_version);
 if(! $dump_version){
 $dump_version = 'unknown version';
 }

$dump_prefix = rfile_gets($fh, 256, $gzip);
 if(strpos($dump_prefix, 'DB_PREFIX:') === false){
 $dump_prefix = 'unknown prefix';
 }
 else{
 $dump_prefix = trim(substr(trim($dump_prefix), 12));
 }

 if($gzip){
 gzclose($fh);
 }
 else{
 fclose($fh);
 }


return array('version' => $dump_version, 'prefix' => $dump_prefix);
}


?>