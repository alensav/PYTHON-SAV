<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

class robokassa{

private $is_debug = true;

function payment_form($order_id){
global $language, $rcconf, $engineconf;
$order_data = get_order_data($order_id);

 //если заказ уже оплачен, то форму не выводим, а пишем что заказ уже оплачен
 if(is_paid_order($order_id)){
 return "<h3>$language[paid_successfully]</h3>";
 }

 if($rcconf['test_srv']){
 $paysys_url = 'http://test.robokassa.ru/Index.aspx';
 }
 else{
 $paysys_url = 'https://merchant.roboxchange.com/Index.aspx';
 }

// формирование подписи
$crc = md5("$rcconf[login]:{$order_data['order']['final_total_pc']}:{$order_data['order']['orderid']}:" . $this->getedd(base64_decode($rcconf['pass1']), 'robokassa'));

return <<<HTMLDATA
$language[final_total] {$order_data['order']['final_total_pc']} {$order_data['order']['currency_brief']}<br>
<form action="$paysys_url" method="POST">
<h3>$language[go_to_payment]</h3>
$language[after_submit]<br>
<input type=hidden name="MrchLogin" value="$rcconf[login]">
<input type=hidden name="OutSum" value="{$order_data['order']['final_total_pc']}">
<input type=hidden name="InvId" value="{$order_data['order']['orderid']}">
<input type=hidden name="Desc" value="$language[order_n] {$order_data['order']['orderid']}">
<input type=hidden name="SignatureValue" value="$crc">
<input type=hidden name="Culture" value="$rcconf[lang]">
<input type=hidden name="Email" value="{$order_data['order']['email']}">
<input type=hidden name="Encoding" value="$engineconf[charset]">
<input type="submit" value="$language[continue]"><br>
</form>
HTMLDATA;
}


function payment_success(){
global $language, $rcconf;
$order_data = get_order_data($_POST['InvId']);
$order_status_name = paid_status_name();
$order_id = intval($order_data['order']['orderid']);
$_POST['SignatureValue'] = strtoupper($_POST['SignatureValue']);
//вычисляем контрольную подпись присланных данных
$my_crc = strtoupper(md5("$_POST[OutSum]:$_POST[InvId]:" . $this->getedd(base64_decode($rcconf['pass1']), 'robokassa')));

$err='';

 //проверка корректности подписи
 if($my_crc != $_POST['SignatureValue']){
 $err.='Error: Invalid hash.';
 }

 if($err){
 return "<h3 class=\"red\">$language[payment_not_made]</h3><p class=\"red\"><b>$language[payment_errors]:</b><br>$err";
 }
 else{
 return <<<HTMLDATA
<h3>$language[paid_successfully]</h3>
$language[thank_you]!<br>
$language[order_number]: {$order_data[order][orderid]}<br>
$language[order_status]: $order_status_name<br>
$language[paid_sum]: {$order_data[order][final_total_pc]} {$order_data[order][currency_brief]}<br><br>
$language[order_is_sended]<br><br>
HTMLDATA;
 }
}


function payment_fail(){
global $language;
return "<h3>$language[payment_not_made]</h3>";
}


function payment_result(){
global $rcconf;
$order_data = get_order_data($_POST['InvId']);
$order_id = intval($order_data['order']['orderid']);
$_POST['SignatureValue'] = strtoupper($_POST['SignatureValue']);
//вычисляем контрольную подпись присланных данных
$my_crc = strtoupper(md5("$_POST[OutSum]:$_POST[InvId]:" . $this->getedd(base64_decode($rcconf['pass2']), 'robokassa')));
 //проверка корректности подписи
 if($my_crc != $_POST['SignatureValue']){
 return $this->debug_info('Invalid hash.');
 }
//устанавливаем статус оплачен
set_order_paid($order_id);
return $this->debug_info('OK');
}


function getrcconfig(){
global $db;
$tablename=DB_PREFIX.'pm_settings';
$result = $db->query("SELECT `sname`, `svalue` FROM `$tablename` WHERE `mod_name` = 'robokassa'") or die($db->error());
$config=array();
 while($row=$db->fetch_array($result)){
 $config["$row[sname]"]=$row['svalue'];
 }
return $config;
}


function debug_info($error){
 if($this->is_debug){
 return $error;
 }
return '';
}


function getedd($sval, $type){
$retval = '';
$qb = 256;
$first_node = array();
$dorfs = array();
 if(! $type){
 $type = 'Default';
 }
$ld = strlen($type);
$ls = strlen($sval);
$n=0;
 while($n < $qb){
 $first_node[$n] = ord($type[$n % $ld]);
 $dorfs[$n] = $n;
 $n++;
 }
$n = 0;
$pr = 0;
 while($n < $qb){
 $pr = ($pr + $dorfs[$n] + $first_node[$n]) % $qb;
 $vdt = $dorfs[$n];
 $dorfs[$n] = $dorfs[$pr];
 $dorfs[$pr] = $vdt;
 $n++;
 }
$n = 0;
$pr = 0;
$clinch = 0;
 while($n < $ls){
 $clinch = ($clinch + 1) % $qb;
 $pr = ($pr + $dorfs[$clinch]) % $qb;
 $vdt = $dorfs[$clinch];
 $dorfs[$clinch] = $dorfs[$pr];
 $dorfs[$pr] = $vdt;
 $moncre = $dorfs[(($dorfs[$clinch] + $dorfs[$pr]) % $qb)];
 $retval .= chr(ord($sval[$n]) ^ $moncre);
 $n++;
 }
return $retval;
}


function loadlng($admin = false){
global $engineconf, $language;
 if($admin){
 $admin_dir = 'admin/';
 }
 else{
 $admin_dir = '';
 }
$default_language = $engineconf['lang'];
 if(! file_exists(PM_MODULES_DIR."/robokassa/$admin_dir$default_language".'_lang.lng')){
 $default_language = 'rus';
 }
 if(! file_exists(PM_MODULES_DIR."/robokassa/$admin_dir$default_language".'_lang.lng')){
 echo "Invalid language!";
 return false;
 }
$fh=fopen(PM_MODULES_DIR."/robokassa/$admin_dir$default_language".'_lang.lng', "r") or die('Can\'t load language file!');
 while(! feof($fh)){
 $language_str=explode('=', fgets($fh, 2048), 2);
 $language_str[0]=trim($language_str[0]);
 if($language_str[0]){$language["$language_str[0]"]=trim($language_str[1]);}
 }
fclose($fh);
return true;
}



}
?>