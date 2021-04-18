<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class auth_user{

function user_enter(){
global $db, $custom;
$_POST['username'] = $custom->del_notalphanum(trim($_POST['username']));
$username = $_POST['username'];
if(! $username){return false;}
$_POST['password'] = trim($_POST['password']);
if(! $_POST['password']){return false;}
$_POST['password'] = md5($_POST['password'] . 'Shopper User Password');
$username = $db->secstr($username);
$tbl = DB_PREFIX.'users';
$res = $db->query("SELECT `userid`, `username`, `pwd`, `groupid`, `email`, `first_name` FROM `$tbl` WHERE username = '$username'") or die($db->error());
$row = $db->fetch_array($res);

$_SESSION['arwshop_mk']['user'] = array();

 if($username !== $row['username'] || $_POST['password'] !== $row['pwd']){
 return false;
 }
 else{
 $_SESSION['arwshop_mk']['user']['userid'] = $row['userid'];
 $_SESSION['arwshop_mk']['user']['username'] = $row['username'];
 $_SESSION['arwshop_mk']['user']['key'] = md5('value' . intval(date("YmdH", time())) . $row['userid'] . $row['username'] . $row['pwd'] . 'Validate User Key');
 $_SESSION['arwshop_mk']['user']['groupid'] = $row['groupid'];
 $this->set_userdata($row);

 return true;
 }

}


function check_auth(){
global $db;

$max_user_session_time = 13 ;

$userid=intval($_SESSION['arwshop_mk']['user']['userid']);
if(! $userid || ! $_SESSION['arwshop_mk']['user']['username'] || ! $_SESSION['arwshop_mk']['user']['key']){return false;}

$tbl=DB_PREFIX.'users';
$res = $db->query("SELECT userid, username, pwd, groupid, email, first_name FROM $tbl WHERE userid = $userid") or die($db->error());
$row=$db->fetch_array($res);

$date=intval(time());

 for($i=0;$i<$max_user_session_time;$i++){
 $key = md5('value' . intval(date("YmdH", $date)) . $row['userid'] . $row['username'] . $row['pwd'] . 'Validate User Key');
  if($_SESSION['arwshop_mk']['user']['key'] === $key){
  $_SESSION['arwshop_mk']['user']['groupid'] = $row['groupid'];
  $this->set_userdata($row);
  return true;
  }
 $date=$date-3600;
 }

return false;
}


function set_userdata($row){
global $user_data;
$user_data = array();
$user_data['userid']=$row['userid'];
$user_data['username']=$row['username'];
$user_data['groupid']=$row['groupid'];
$user_data['email']=$row['email'];
$user_data['first_name']=$row['first_name'];
}


function cookie_set($name, $value = '', $exp = 1){
$exipres = 0;
 if($exp == 1){
 $expires = time() + 31536000;
 }
 elseif($exp > 1){
 $expires = time() + $exp;
 }
 else{
 $expires = time() - 1000;
 }
 setcookie($name, $value, $expires, '/','');
}



}
?>