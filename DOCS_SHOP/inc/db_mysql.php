<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class db{

public $db_sql_mode = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
public $db_last_query = '';
public $sql_query_count = 0;
public $server_version = 0;
public $handler = 0;
public $dbname = '';

function __construct($conn_data = array()){
 if(isset($conn_data['db_prefix']) && ! defined('DB_PREFIX')){
 define('DB_PREFIX', $conn_data['db_prefix']);
 }
}


function connect_combined($conn_data){
$hndlr = @$this->connect($conn_data);
 if(empty($hndlr)){
 die(@header("HTTP/1.1 503 Service Unavailable")."Can't connect to MySQL!");
 }
 if(! $this->select_db($conn_data['dbname'])){
 die(header("HTTP/1.1 503 Service Unavailable")."Can't select database!");
 }
return $hndlr;
}


function connect($conn_data){
 if(! function_exists('mysqli_connect')){
 global $lang;
 @header("HTTP/1.1 503 Service Unavailable");
 header("Content-type: text/html; charset=utf-8");
 custom::get_lang('errors');
 echo $lang['mysqli_disabled'];
 exit;
 }

$host_port = explode(':', $conn_data['host']);
 if(! empty($host_port[1])){
 $this->handler = mysqli_connect($host_port[0], $conn_data['user'], $conn_data['psw'], '', $host_port[1]);
 }
 else{
 $this->handler = mysqli_connect($conn_data['host'], $conn_data['user'], $conn_data['psw']);
 }

 if(empty($this->handler)){
 return false;
 }


$set_config='';



  if($set_config){
  $set_config .= ', ';
  }
 $set_config.="sql_mode = '$this->db_sql_mode'";

 if(! empty($set_config)){
 $this->query('SET '.$set_config) or die($this->error());
 }

mysqli_set_charset($this->handler, $conn_data['mysql_charset']) or die('Cannot set charset '.$conn_data[mysql_charset].'!');
return $this->handler;
}


function select_db($db_name, $hndlr = 0){
 if($hndlr === 0){
 $hndlr = $this->handler;
 }
$res = mysqli_select_db($hndlr, $db_name);
 if($res){
 $this->dbname = $db_name;
 }
return $res;



}


function close_connection(&$hndlr = 0){
 if($hndlr == 0){
 $hndlr = $this->handler;
 }
$res = false;
 if($hndlr !== 0){
 $res = mysqli_close($hndlr);
  if($this->handler === $hndlr){
  $this->handler = 0;
  }
 $hndlr = 0;
 }
return $res;
}


function query($query, $hndlr = 0){
$this->db_last_query = $query;
$this->sql_query_count++;
 if($hndlr === 0){
 $hndlr = $this->handler;
 }
return mysqli_query($hndlr, $query);
}


function result($res){
$row=$this->fetch_row($res);
return $row[0];
}

function fetch_array($res){
return mysqli_fetch_array($res);
}

function fetch_row($res){
return mysqli_fetch_row($res);
}

function fetch_assoc($res){
return mysqli_fetch_assoc($res);
}

function error($hndlr = 0){
$post_data = '';
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
 $post_data = '<br>POST data: '.print_r($_POST, true);
 }
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$debug_msg = 'Last SQL query: "' . $this->db_last_query . '"<br>SQL query count: ' . $this->sql_query_count . '<br>Request: ' . $_SERVER['REQUEST_URI'] . '<br>Query string: ' . $_SERVER['QUERY_STRING'] . '<br>Referer: ' . $referer . '<br>Method: ' . $_SERVER['REQUEST_METHOD'] . $post_data . '<br>' . $this->debugmsg_tostr(debug_backtrace());
if(DEBUG_MODE == 1){echo $debug_msg.'<br>';}
 if($hndlr === 0){
 $hndlr = $this->handler;
 }
$err_msg = mysqli_error($hndlr);
@ini_set('log_errors', 'On');
$err_log_file = SCRIPTCHF_DIR.'/adm/dump/db_mysql_err.log';
 if(@filesize($err_log_file) > 1048576){
 file_put_contents($err_log_file, '');
 }
@ini_set('error_log', $err_log_file);
@error_log("DB MySQL error: $err_msg\n$debug_msg\n---");
return $err_msg;
}


function num_rows($res){
return mysqli_num_rows($res);
}


function errno($hndlr = 0){
 if($hndlr === 0){
 $hndlr=$this->handler;
 }
return mysqli_errno($hndlr=$this->handler);
}


function insert_id($hndlr = 0){
 if($hndlr === 0){
 $hndlr = $this->handler;
 }
return mysqli_insert_id($hndlr);
}




function sql_server_version(){
 if($this->server_version != 0){
 return $this->server_version;
 }
$res = $this->query("SELECT VERSION()") or die($this->error());
$version = $this->result($res) or die($this->error());
list($major, $minor) = explode('.', $version);
$version = floatval($major . '.' . $minor);
$this->server_version = $version;
return $version;
}


function secstr($value){

 if(is_array($value)){
 return $this->secstr_array($value);
 }

 if(custom::magic_quotes()){
 $value = stripslashes($value);
 }
 if(! is_numeric($value)){
 $value = mysqli_real_escape_string($this->handler, $value);
 }
return $value;
}


function secstr_array($array){
 foreach($array as $field_name => $value){
 $array["$field_name"] = $this->secstr($value);
 }
return $array;
}


function debugmsg_tostr($arr, $recurs=false){
$text='';
 foreach($arr as $key => $value){
   if(is_array($value)){
     if(! $recurs){
     $text.="#";
     }
     if(sizeof($value)){
     $text.="$key => Array(".$this->debugmsg_tostr($value, 1).')';
     }
     if(! $recurs){
     $text.="\n";
     }
   }
   elseif($value && ! is_object($value)){
   $text.="$key => $value, ";
   }
 }
 if(substr($text, strlen($text)-2)===', '){
 $text=substr($text, 0, strlen($text)-2);
 }
return $text;
}


function cutstr($str, $length, $is_big_text = false){
 if($is_big_text){
 $length = floor($length / 2);
 }
return $this->remove_last_slash(mb_substr($str, 0, $length));
}

function remove_last_slash($text){
 while(substr($text, strlen($text)-1) === "\x5C"){
 $text=substr($text, 0, strlen($text)-1);
 }
return $text;
}


}
?>