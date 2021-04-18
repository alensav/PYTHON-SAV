<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class register{

function check_form(){
global $lang, $custom, $sett, $db;

$tbl=DB_PREFIX.'users';

 if(TDTC == 1){
 $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
  if($db->result($res,0,0) >= 10){
  return mdmogrn("$lang[312] 10 $lang[325]");
  }
 }

$err_username = 0;
$err_msg = '';

$_POST['username']=trim($_POST['username']);
 if(preg_match("([^a-zA-Z0-9\x80-\xFF\x20\_\-])", $_POST['username'])){
 $err_msg.="$lang[invalid_username]<br>";
 $err_username=1;
 }

 if($_POST['username']==''){
 $err_msg.="$lang[no_username]<br>";
 $err_username=1;
 }
 elseif(mb_strlen($_POST['username'])<3){
 $err_msg.="$lang[short_username]<br>";
 $err_username=1;
 }

 if($_POST['username'] && ! $err_username){
  if($this->user_exist($_POST['username'])){
  $err_msg.="$lang[user_with_login] \"<b>$_POST[username]</b>\" $lang[already_exist_sol]<br>";
  }
 }

$_POST['password1']=trim($_POST['password1']);
$_POST['password2']=trim($_POST['password2']);

 if(preg_match("([^a-zA-Z0-9\x80-\xFF\x20\_\-])", $_POST['password1'])){
 $err_msg.="$lang[invalid_pass]<br>";
 }

 if($_POST['password1'] == $_POST['username']){
 $err_msg.="$lang[pass_eq_login]<br>";
 }

 if($_POST['password1']==''){
 $err_msg.="$lang[no_pass]<br>";
 }
 elseif(mb_strlen($_POST['password1'])<6){
 $err_msg.="$lang[short_password]<br>";
 }

 if($_POST['password1'] !== $_POST['password2']){
 $err_msg.="$lang[passwords_not_coincide]<br>";
 }

require_once(INC_DIR."/profile.php");
$profile=new profile;
$_POST=$custom->trim_array($_POST);
$err_msg=$profile->check_profile_form($_POST, $err_msg, 0, 1);

 if($sett['antibot_register']){
 $_POST['protect_code']=trim($_POST['protect_code']);
  if(! $_POST['protect_code']){
  $err_msg.="$lang[not_protect_code]<br>";
  }
  elseif($_POST['protect_code'] != $_SESSION['arwshop_mk']['rnd_botcode']){
  $err_msg.="$lang[invalid_protect_code]<br>";
  }
  else{
  unset($_SESSION['arwshop_mk']['rnd_botcode']);
  }
 }

return $err_msg;
}


function user_exist($username){
global $db;
$tbl=DB_PREFIX.'users';
$res=$db->query("SELECT COUNT(*) FROM $tbl WHERE username = '$username'") or die($db->error());
if($db->result($res,0,0)>0){return true;}
return false;
}


function email_exist($email, $userid=0){
global $db;
$tbl=DB_PREFIX.'users';

$query = "SELECT COUNT(*) FROM $tbl WHERE email = '$email'";
$userid=intval($userid);
if($userid){$query .= " AND userid != '$userid'";}

$res=$db->query($query) or die($db->error());
if($db->result($res,0,0)>0){return true;}
return false;
}


function add_user(){
global $db, $sett;
$_POST['password1']=md5($_POST['password1'] . 'Shopper User Password');
$tbl=DB_PREFIX.'users';
$_POST = custom::replace_tags_and_quotes_array($_POST);
$_POST['username'] = mb_substr($_POST['username'], 0, 255);
$_POST['email'] = mb_substr($_POST['email'], 0, 255);
$_POST['first_name'] = mb_substr($_POST['first_name'], 0, 255);
$_POST['last_name'] = mb_substr($_POST['last_name'], 0, 255);
$_POST['patronymic'] = mb_substr($_POST['patronymic'], 0, 255);
$_POST['company'] = mb_substr($_POST['company'], 0, 255);
$_POST['country'] = intval($_POST['country']);
$_POST['city'] = mb_substr($_POST['city'], 0, 255);
$_POST['address'] = mb_substr($_POST['address'], 0, 2048);
$_POST['zip_code'] = mb_substr($_POST['zip_code'], 0, 255);
$_POST['phone'] = mb_substr($_POST['phone'], 0, 255);

$groupid = intval($sett['reg_def_group']);
 if(! $groupid){
 $groupid=1;
 }
$regallowgroups = $this->reg_allowed_groups();
 if(sizeof($regallowgroups)){
  if(isset($_POST['user_group']) && in_array($_POST['user_group'], $regallowgroups)){
   if($this->is_group_exists($_POST['user_group'])){
   $groupid = intval($_POST['user_group']);
   }
  }
 }

$data = $db->secstr_array($_POST);
$tbl = DB_PREFIX.'users';
$db->query("INSERT INTO $tbl (userid, username, pwd, groupid, email, regdate, first_name, last_name, patronymic, company, country, city, address, zip_code, phone) VALUES(NULL, '$data[username]', '$data[password1]', $groupid, '$data[email]', " .time(). ", '$data[first_name]', '$data[last_name]', '$data[patronymic]', '$data[company]', '$data[country]', '$data[city]', '$data[address]', '$data[zip_code]', '$data[phone]')") or die($db->error());
return $db->insert_id();
}


function is_group_exists($groupid){
global $db;
$tbl_users_groups=DB_PREFIX.'users_groups';
$groupid=intval($groupid);
$res=$db->query("SELECT COUNT(*) FROM `$tbl_users_groups` WHERE `groupid` = $groupid") or die($db->error());
 if($db->result($res,0,0)>0){
 return true;
 }
return false;
}


function get_countries_list($selected_id=''){
global $db;
$ret = '';
$tbl=DB_PREFIX.'countries';
$query=$db->query("SELECT * FROM $tbl ORDER BY country_name")or die($db->error());
 while($row=$db->fetch_array($query)){
  if($row['country_id']){
  if($row['country_id']==$selected_id){$sel_value=' selected';}else{$sel_value='';}
  $ret.="<option value=\"".$row['country_id']."\"$sel_value>$row[country_name]</option>";
  }
 }
return $ret;
}


function reg_allowed_groups(){
global $custom;
$regallowgroups=explode(';', $custom->get_txtsettings('reg_allow_groups'));
$ret=array();
 if(sizeof($regallowgroups)){
  foreach($regallowgroups as $value){
   if($value){
   array_push($ret, $value);
   }
  }
 }
return $ret;
}


}
?>