<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
require_once(INC_DIR."/db_extend_mysql.php");

class dump{

private $output_fh = '';

function dump_db(){
global $admin_lib, $lang, $sett, $admset;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(function_exists('set_time_limit')){
 @set_time_limit(600);
 }

$dirname=SCRIPTCHF_DIR."/adm/dump";

$filename = 'db_copy_'.date("Y-m-d_H-i-s", time() + $sett['time_diff'] * 3600).'.sql';

 if(! empty($_POST['gzip_compress'])){
  if(! extension_loaded('zlib')){
  return $lang['not_zlib_loaded'];
  }
 $filename.='.gz';
 $level=9;
 $this->output_fh=@gzopen("$dirname/$filename", "w$level");
 }
 else{
 $this->output_fh=@fopen("$dirname/$filename", "wb");
 }

 if(! $this->output_fh){
 return "<font class=\"red\">$lang[cant_open_file] \"$dirname/$filename\". $lang[check_folder_chmod] 0777 $lang[on_the_folder] \"$dirname\"</font>";
 }

$this->put_to_file("# ArwShop Market dump v$sett[db_version]\n");
$this->put_to_file('# DB_PREFIX: '.DB_PREFIX."\n\n");
$this->put_to_file("SET NAMES utf8;\n\n\n");

$this->get_db_data();

 if(! empty($_POST['gzip_compress'])){
 gzclose($this->output_fh);
 }
 else{
 fclose($this->output_fh);
 }

$this->output_fh='';

 if($admset['set_rfiles_chmod']){
  if(is_numeric($admset['rfiles_chmod']) && is_file("$dirname/$filename")){
  @chmod("$dirname/$filename", octdec($admset['rfiles_chmod']));
  }
 }

return "<h3>$lang[backup_success]</h3>";
}

function get_db_data(){
global $db;
$dtables = $db->query("SHOW TABLES FROM `$db->dbname`") or die($db->error());
 while($row=$db->fetch_row($dtables)){
  if(substr($row[0], 0, strlen(DB_PREFIX)) == DB_PREFIX){
  $this->table_structure($row[0], DB_PREFIX);
  }
 }
}


function table_structure($tblname, $prefix){
global $db;
$this->put_to_file("# Structure of table $tblname\n");
$this->put_to_file("DROP TABLE IF EXISTS `$tblname`;\n");
$res=$db->query("SHOW CREATE TABLE `$tblname`")or die($db->error());
$row=$db->fetch_array($res);
$this->put_to_file($row['Create Table'].";\n\n\n");
 if(substr($tblname, strlen($prefix)) !== 'visitlog' && substr($tblname, strlen($prefix)) !== 'cache'){
 $this->table_data($tblname);
 }
}


function table_data($tblname){
global $db;

    $this->put_to_file("# Dump Data of table $tblname\n");
    $q_result = $db->query("SELECT * FROM ".$tblname);
    $num_fields = db_extend::num_fields($q_result);
    for($j =0; $j<$db->num_rows($q_result);$j++) {
         if(! db_extend::data_seek($q_result, $j)) {
             printf("Cannot seek to row %d\n", $j);
             continue;
         }
 
     if(!($row = $db->fetch_row($q_result))) continue;
     $this->put_to_file("INSERT INTO ".$tblname." VALUES(");
     for($i=0; $i<$num_fields; $i++) {
       if(isset($row[$i])){
       $row["$i"]=$db->secstr($row["$i"]);
       $this->put_to_file("'$row[$i]'");
       }
       else{
       $this->put_to_file("NULL");
       }
       if($i<($num_fields-1)){$this->put_to_file(",");}
     }    
     $this->put_to_file(sprintf( ");\n"));
    }
    $this->put_to_file("\n\n");
}


function delete_dump_file(){
global $lang, $admin_lib;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$dirname=SCRIPTCHF_DIR."/adm/dump";
$filename=preg_replace("([^a-z0-9\_\.\-])", '', $_GET['df']);

 if(substr($filename, strlen($filename)-4) !== '.sql' && substr($filename, strlen($filename)-3) !== '.gz'){
 return '';
 }

 if(file_exists("$dirname/$filename") && @unlink("$dirname/$filename")){
 return "<h3>$lang[file_deleted]</h3>";
 }
}


function put_to_file($data){
 if(! empty($_POST['gzip_compress'])){
 gzwrite($this->output_fh, $data);
 }
 else{
 fputs($this->output_fh, $data);
 }
}





}
?>