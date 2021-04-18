<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
require_once(INC_DIR."/crypt.php");

class smtp{

public $authorized = false;
public $handler = '';
public $to_adrs = '';
public $headers = '';
public $timeout = 20;
public $errors = array();
public $is_connected = false;
public $body = '';
public $from = '';
public $host = '';
public $port = '';
public $helo = '';
public $auth = '';
public $user = '';
public $pass = '';
public $crlf = '';



public function __construct(){
global $smtpset, $custom, $sett;
$smtpset = $custom->get_settings(4);
$this->crlf = "\r\n";
$this->is_connected = false;
$this->authorized = false;
$this->errors=array();
$this->timeout=$smtpset['timeout'];
$this->host = $smtpset['host'];
$this->port = $smtpset['port'];
$this->helo = $smtpset['helo'];
$this->auth = $smtpset['auth'];
$this->user = $smtpset['user'];
$this->pass = $smtpset['pass'];

$crypting = new crypting;
$this->pass = $crypting->crypt_data(base64_decode($smtpset['pass']), $sett['index_text']);

  if(DEBUG_MODE == 1){
 $this->connect();
 }
 else{
 @$this->connect();
 }

}


private function connect(){
 if(465 == $this->port && 'ssl://' !== substr($this->host, 0, 6)){
 $this->host = 'ssl://'.$this->host;
 }
$this->handler = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
 if(function_exists('socket_set_timeout')){
 @socket_set_timeout($this->handler, 5, 0);
 }
$greeting = $this->get_data();
 if(is_resource($this->handler)){
 $this->is_connected = true;
 return $this->auth ? $this->write_ehlo() : $this->write_helo();
 }
 else{
 $this->errors[] = 'Cannot connect to SMTP server: ' . $errstr;
 return false;
 }
}



public function mail_send($send_data){
$this->from = $send_data['from'];
$this->to_adrs = $send_data['to_adrs'];
$this->headers = $send_data['headers'];
$this->body = $send_data['body'];

 if($this->is_connected()){

  if($this->auth && !$this->authorized){
   if(! $this->write_auth()){
   return false;
   }
  }

 $this->write_from($this->from);
  if(is_array($this->to_adrs)){
	 foreach($this->to_adrs as $value){
	 $this->write_to($value);
	 }
	}
	else{
	$this->write_to($this->to_adrs);
  }

  if(!$this->write_data()){
	return false;
	}

 $headers = str_replace($this->crlf.'.', $this->crlf.'..', trim(implode($this->crlf, $this->headers)));
 $body    = str_replace($this->crlf.'.', $this->crlf.'..', $this->body);
 $body    = $body[0] == '.' ? '.'.$body : $body;

 $this->write($headers);
 $this->write('');
 $this->write($body);
 $this->write('.');

 $result = (substr(trim($this->get_data()), 0, 3) === '250');
 return $result;
 }
 else{
 $this->errors[] = 'Not connected!';
 return false;
 }

}




private function write_helo(){
 if(is_resource($this->handler) && $this->write('HELO '.$this->helo) && substr(trim($error = $this->get_data()), 0, 3) === '250' ){
 return true;
 }
 else{
 $this->errors[] = 'Error HELO command: ' . trim(substr(trim($error),3));
 return false;
 }
}




private function write_ehlo(){
 if(is_resource($this->handler) && $this->write('EHLO '.$this->helo) && substr(trim($error = $this->get_data()), 0, 3) === '250'){
 return true;
 }
 else{
 $this->errors[] = 'Error EHLO command: ' . trim(substr(trim($error),3));
 return false;
 }
}




public function close(){
 if(is_resource($this->handler) && $this->write('QUIT') && substr(trim($error = $this->get_data()), 0, 3) === '221'){
 fclose($this->handler);
 $this->con_status = false;
 return true;
 }
 else{
 $this->errors[] = 'Error QUIT command: ' . trim(substr(trim($error),3));
 return false;
 }
}




private function write_auth(){
 if(is_resource($this->handler) && $this->write('AUTH LOGIN') && substr(trim($error = $this->get_data()), 0, 3) === '334' && $this->write(base64_encode($this->user)) && substr(trim($error = $this->get_data()),0,3) === '334' && $this->write(base64_encode($this->pass)) && substr(trim($error = $this->get_data()),0,3) === '235'){
 $this->authorized = true;
 return true;
 }
 else{
 $this->errors[] = 'Error AUTH command: ' . trim(substr(trim($error),3));
 return false;
 }
}



private function write_from($from){
 if($this->is_connected() && $this->write('MAIL FROM:<'.$from.'>') && substr(trim($this->get_data()), 0, 2) === '250' ){
 return true;
 }
 else{
 return false;
 }
}



private function write_to($to){
 if($this->is_connected() && $this->write('RCPT TO:<'.$to.'>') && substr(trim($error = $this->get_data()), 0, 2) === '25'){
 return true;
 }
 else{
 $this->errors[] = trim(substr(trim($error), 3));
 return false;
 }
}



private function write_data(){
 if($this->is_connected() && $this->write('DATA') && substr(trim($error = $this->get_data()), 0, 3) === '354' ){
 return true;
 }
 else{
 $this->errors[] = trim(substr(trim($error), 3));
 return false;
 }
}



public function is_connected(){
 if(is_resource($this->handler) && $this->is_connected){
 return true;
 }
return false;
}



private function write($data){
 if(is_resource($this->handler)){
 return fwrite($this->handler, $data.$this->crlf, strlen($data)+2);
 }
 else{
 return false;
 }
}




private function get_data(){
$ret = '';
$str = '';
$cnt = 0;
 if(is_resource($this->handler)){
  while((strpos($ret, $this->crlf) === false || substr($str,3,1) !== ' ') && $cnt < 100){
  $str = fgets($this->handler, 512);
  $ret .= $str;
  $cnt ++;
  }
 return $ret;
 }
 else{
 return false;
 }
}



}
?>