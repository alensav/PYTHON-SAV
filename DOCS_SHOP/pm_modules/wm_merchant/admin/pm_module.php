<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }
 
global $engineconf, $wmmerchant, $wmconf;
$engineconf = engine_conf();
require_once(PM_MODULES_DIR."/wm_merchant/wm_merchant.php");
$wmmerchant=new wmmerchant;
$wmconf=$wmmerchant->getwmconfig();
$wmmerchant->loadlng(1);

$wmmadmin=new wmmadmin;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = $_GET['act'];
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act = $_POST['act'];
 }
 else{
 $act = '';
 }

$act = preg_replace("([^a-z0-9\_])", '', $act);

 switch($act){
 
 case 'settings':
 include(PM_MODULES_DIR."/wm_merchant/admin/settings.php");
 break;

 case 'order_info':
 echo $wmmadmin->order_info();
 break;
 
 default: echo 'Invalid argument &quot;act&quot;';
 }



class wmmadmin{


function pursesconf(){
global $language, $db;
$tbl=DB_PREFIX.'wm_purses';
$result=$db->query("SELECT * FROM $tbl") or die($db->error());

$ret = '';
$cssclass = 'ttr';

 while($row=$db->fetch_array($result)){
 $ret .= "<table width=\"100%\" class=\"settbl\"><tr class=\"htr\"><td colspan=\"2\">$language[settings] $row[pursetype] $language[of_purse]</td></tr>";

 if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';}
 $ret .= "<tr class=\"$cssclass\"><td>$language[number] <b>$row[pursetype]</b> $language[of_purse]</td><td><input type=\"text\" name=\"pursesconf[$row[pursetype]][pursenumber]\" value=\"$row[pursenumber]\" size=\"34\" maxlength=\"13\"></td></tr>";

 if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';}
 $ret .= "<tr class=\"$cssclass\"><td>$language[currency] <b>$row[pursetype]</b> $language[of_purse]</td><td><select name=\"pursesconf[$row[pursetype]][currency]\"><option value=\"0\">$language[not_selected]</option>" . $this->currencieslist($row['currency_id']) . "</select></td></tr>";

 $ret .= "</table><br>";
 }

return $ret;
}


function currencieslist($currency_id=''){
global $db;
$tbl=DB_PREFIX.'currencies';
$result=$db->query("SELECT currency_id, brief, title FROM $tbl") or die($db->error());
$ret = '';

 while($row=$db->fetch_array($result)){
 if($row['currency_id']==$currency_id){$selected=' selected';}else{$selected='';}
 $ret.="<option value=\"$row[currency_id]\"$selected>$row[title] ($row[brief])</option>";
 }

return $ret;
}


function updateconfig(){
global $language, $wmconf, $wmmerchant, $db;

if(! admin_access()){return "<p class=\"red\">$language[nosave_perms]</p>";}

$err_msg = '';

$_POST['secret_key'] = trim($_POST['secret_key']);

 if($_POST['secret_key'] && $_POST['secret_key'] !== '-'){
 
  if( preg_match("([^a-zA-Z0-9]{1,})", $_POST['secret_key'])){
  $err_msg.="$language[invalid_secret_key]<br>";
  }

  if(strlen($_POST['secret_key']) > 64){
  $err_msg.="$language[secretkey_maxlength] 64 $language[characters]<br>";
  }

 }


if($err_msg){return $err_msg;}

$tbl=DB_PREFIX.'wm_purses';

 if(is_array($_POST['pursesconf'])){
  foreach($_POST['pursesconf'] as $pursetype => $arr){
  $pursetype=preg_replace("([^A-Z])", '', $pursetype);
  $arr['currency']=intval($arr['currency']);
  $arr['pursenumber']=preg_replace("([^A-Z0-9])", '', strtoupper($arr['pursenumber']));
  $result=$db->query("SELECT pursetype FROM $tbl WHERE currency_id = $arr[currency] AND pursetype <> '$pursetype'") or die($db->error());
  $row=$db->fetch_array($result);
   if($row['pursetype'] && $arr['currency']){
   return $language['currency_already_used'];
   }
   else{
   $db->query("UPDATE $tbl SET currency_id = $arr[currency], pursenumber = '$arr[pursenumber]' WHERE pursetype = '$pursetype'") or die($db->error());
   }
  }
 }

 if($_POST['secret_key']){
  if($_POST['secret_key']==='-'){
  $_POST['new_conf']['msk']='';
  }
  else{
  $_POST['new_conf']['msk'] = base64_encode($wmmerchant->getedd($_POST['secret_key'], $wmconf['ck']));
  }
 }


$this->setdbsettings($_POST['new_conf']);
$wmconf=$wmmerchant->getwmconfig();
return 1;
}


function setdbsettings($newconf){
global $db;
$tablename=DB_PREFIX.'wm_merchant_conf';
 if(is_array($newconf)){
  foreach($newconf as $sname => $svalue){
  $sname = $db->secstr($sname);
  $svalue=stripslashes(trim($svalue));
  $svalue=str_replace('"','&quot;',$svalue);
  $svalue=str_replace("'",'&#39;',$svalue);
  $svalue=str_replace("`",'&#96;',$svalue);
  $svalue=mb_substr($db->secstr($svalue), 0, 255);
  $result = $db->query("SELECT COUNT(*) AS NUM_ROWS FROM $tablename WHERE sname = '$sname'");
   if($db->result($result)>0){
   $db->query("UPDATE $tablename SET svalue = '$svalue' WHERE sname = '$sname'") or die($db->error());
   }
   else{
   $db->query("INSERT INTO $tablename (sname, svalue) VALUES ('$sname', '$svalue')") or die($db->error());
   }
  }
 }
return true;
}


function order_info(){
global $language, $db;
$retval = '';
$retval .= "<h3>$language[payment_info]</h3><a href=\"?view=orders&act=detail&orderid=$_GET[orderid]\">$language[order_number] $_GET[orderid]</a><br><br>";

$orderid=intval($_GET['orderid']);
$tbl=DB_PREFIX.'wm_merchant';
$res=$db->query("SELECT wmm_data FROM $tbl WHERE orderid = $orderid") or die($db->error());
$row=$db->fetch_array($res);

 if($row['wmm_data']){

 $data=explode('<xN>', $row['wmm_data']);
 $wmmdata=array();
  if(is_array($data)){
   foreach($data as $str){
   $arr=explode('=', $str);
   if($arr[0]){$wmmdata["$arr[0]"]=htmlspecialchars($arr[1], ENT_QUOTES, 'ISO-8859-1');}
   }
  }
 unset($data);
 
  if(sizeof($wmmdata)){

  $is_admin=admin_access();

  $retval .= <<<HTMLDATA
<table width="100%" class="settbl">
<tr class="htr"><td>$language[description]</td><td>$language[value]</td></tr>
HTMLDATA;

  $retval .= "<tr class=\"str\"><td>$language[shopper_wmid]</td><td>";
   if($is_admin){
   $retval .= "<a href=\"https://passport.webmoney.ru/asp/certview.asp?wmid=$wmmdata[LMI_PAYER_WM]\" target=\"_blank\">$wmmdata[LMI_PAYER_WM]</a>";
   }
   else{
   $retval .= $language['not_accessible_text'];
   }
  $retval .= '</td></tr>';

  $retval .= "<tr class=\"ttr\"><td>$language[shopper_purse]</td><td>";
   if($is_admin){
   $retval .= $wmmdata['LMI_PAYER_PURSE'];
   }
   else{
   $retval .= $language['not_accessible_text'];
   }
  $retval .= '</td></tr>';

  $retval .= "<tr class=\"str\"><td>$language[payment_sum]</td><td>$wmmdata[LMI_PAYMENT_AMOUNT]</td></tr>";
  $retval .= "<tr class=\"ttr\"><td>$language[seller_purse]</td><td>$wmmdata[LMI_PAYEE_PURSE]</td></tr>";
  $retval .= '</table><br>';

  $retval .= <<<HTMLDATA
<table width="100%" class="settbl">
<tr class="htr"><td colspan="2">$language[wmmerchant_data]</td></tr>
<tr class="htr"><td>$language[data_name]</td><td>$language[value]</td></tr>
HTMLDATA;

   if($is_admin){
    foreach($wmmdata as $name => $value){
    if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';}
    if($name==='LMI_SECRET_KEY'){$value=preg_replace("([\x01-\xFF])", '*', $value);}
    $retval .= "<tr class=\"$cssclass\"><td>$name</td><td>$value</td></tr>";
    }
   }
   else{
   $retval .= "<tr class=\"str\"><td colspan=\"2\" align=\"center\"><br>$language[not_accessible_text]<br><br></td></tr>";
   }

  $retval .= '</table>';
  }

 }
 else{
 $retval .= '<br>'.$language['not_wmmerchant_sys_info'].'<hr>';
 }
return $retval;
}



}
?>