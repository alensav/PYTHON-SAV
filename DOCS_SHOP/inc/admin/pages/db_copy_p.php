<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/db_copy');

 if(isset($_POST['act']) && $_POST['act'] == 'do_dump'){
 require(INC_DIR."/admin/dump.php");
 $dump=new dump;
 echo $dump->dump_db();
 }
 elseif(isset($_GET['act']) && $_GET['act'] == 'delete_dump'){
 require(INC_DIR."/admin/dump.php");
 $dump=new dump;
 echo $dump->delete_dump_file();
 }

 echo <<<HTMLDATA
<h3>$lang[db_copy]</h3>
<table class="settbl">
 <tr class="htr">
  <td>$lang[download_file]</td>
  <td class="alignCenter">$lang[delete]</td>
 </tr>
HTMLDATA;

$files = array();
$dirhandle=opendir(SCRIPTCHF_DIR."/adm/dump");
 while(($filename = readdir($dirhandle)) !== false){
  $length_filename=strlen($filename);
  if( (substr($filename, $length_filename-4) == '.sql' || substr($filename, $length_filename-3) == '.gz') && (substr($filename, 0, 7) == 'db_copy')  ){
  array_push($files, $filename);
  }
 }
closedir($dirhandle);
rsort($files);

 if(count($files) > 0){
  foreach($files as $filename){
  $def_class=$admin_lib->sett_class();
  echo "<tr class=\"$def_class\"><td><a href=\"?view=download_dump&df=$filename\">$filename</a></td><td class=\"alignCenter\"><a href=\"?view=tools&tname=dbcopy&act=delete_dump&df=$filename\" onclick=\"return q('$lang[delete_this_file]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
  }
 }
 else{
 echo "<tr><td colspan=\"2\">$lang[no_files]</td></tr>";
 }

 echo <<<HTMLDATA
</table><br>
<form name="frm" action="?" method="POST" onsubmit="document.frm.submit.disabled=true;">
<input type="hidden" name="view" value="tools">
<input type="hidden" name="tname" value="dbcopy">
<input type="hidden" name="act" value="do_dump">
<input type="checkbox" name="gzip_compress" id="gzip_compress"><label for="gzip_compress">$lang[gzip_compress]</label><br><br>
<input type="submit" name="submit" value="$lang[begin_copy]" class="button1">
</form>
HTMLDATA;
?>