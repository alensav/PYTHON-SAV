<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

class interkassa{

private $is_debug = true;

public function payment_form($order_id){
global $language, $engineconf, $pmmod_conf;
$order_data = get_order_data($order_id);

 //если заказ уже оплачен, то форму не выводим, а пишем что заказ уже оплачен
 if(is_paid_order($order_id)){
 return "<h3>$language[paid_successfully]</h3>";
 }

return <<<HTMLDATA
$language[final_total] {$order_data['order']['final_total_pc']} {$order_data['order']['currency_brief']}
<h3>$language[go_to_payment]</h3>
<div>$language[after_submit]</div>
<form method="POST" accept-charset="utf-8" action="https://sci.interkassa.com/">
 <input type="hidden" name="ik_co_id" value="$pmmod_conf[ik_co_id]" />
 <input type="hidden" name="ik_pm_no" value="{$order_data['order']['orderid']}" />
 <input type="hidden" name="ik_am" value="{$order_data['order']['final_total_pc']}" />
 <input type="hidden" name="ik_cur" value="$pmmod_conf[ik_cur]" />
 <input type="hidden" name="ik_desc" value="$language[order_n] {$order_data['order']['orderid']}" />
 <input type="submit" value="$language[continue]">
</form>
HTMLDATA;
}



function payment_success(){
global $language, $pmmod_conf;
$order_data = get_order_data($_POST['ik_pm_no']);
$order_status_name = paid_status_name();
$order_id = intval($order_data['order']['orderid']);

$err = '';

//вычисляем контрольную подпись присланных данных
$my_crc = $this->control_signature($_POST);

 //проверка корректности подписи
 if($my_crc !== $_POST['ik_sign']){
 $err .= 'Error: Invalid hash.<br>';
 }

 //если сумма меньше суммы заказа в базе данных
 if($_POST['ik_am'] < $order_data['order']['final_total_pc']){
 $err .= 'Error: Invalid sum.<br>';
 }

 //если валюта отличается от валюты заданной в настройках модуля
 if($_POST['ik_cur'] !== $pmmod_conf['ik_cur']){
 $err .= 'Error: Invalid currency.<br>';
 }

 if($err){
 return "<h3 class=\"red\">$language[payment_not_made]</h3><p class=\"red\"><b>$language[payment_errors]:</b><br>$err";
 }
 else{
 return "<h3>$language[paid_successfully]</h3>";
 }
}



public function payment_fail(){
global $language;
return "<h3>$language[payment_not_made]</h3>";
}


public function payment_pending(){
global $language;
return "<h3>$language[payment_pending]</h3>";
}


public function payment_interaction(){
global $pmmod_conf;

/*
$tst = '';
 foreach($_POST as $name => $value){
 $tst.="$name=$value\n";
 }
file_put_contents('tst.txt', $tst);
*/

$order_data = get_order_data($_POST['ik_pm_no']);
$order_id = intval($order_data['order']['orderid']);

$err = '';

//вычисляем контрольную подпись присланных данных
$my_crc = $this->control_signature($_POST);

 //проверка корректности подписи
 if($my_crc !== $_POST['ik_sign']){
 return $this->debug_info('Invalid hash.');
 }

 //если сумма меньше суммы заказа в базе данных
 if($_POST['ik_am'] < $order_data['order']['final_total_pc']){
 return $this->debug_info('Invalid sum.');
 }

 //если валюта отличается от валюты заданной в настройках модуля
 if($_POST['ik_cur'] !== $pmmod_conf['ik_cur']){
 return $this->debug_info('Invalid currency.');
 }

//устанавливаем статус оплачен
set_order_paid($order_id);
return $this->debug_info('OK');
}


//вычисляем контрольную подпись присланных данных
private function control_signature($in_arr){
global $pmmod_conf;
$ik_arr = array();
 //удаляем все ключи начинающиеся не с ik_
 foreach($in_arr as $name => $value){
  if(substr($name, 0, 3) === 'ik_'){
  $ik_arr["$name"] = $value;
  }
 }

 if($pmmod_conf['test_mode']){
 $def_key = $pmmod_conf['test_key'];
 }
 else{
 $def_key = $pmmod_conf['secret_key'];
 }

//удаляем из данных строку подписи
unset($ik_arr['ik_sign']);
//сортируем по ключам в алфавитном порядке
ksort($ik_arr, SORT_STRING);
//добавляем в конец массива секр.ключ
array_push($ik_arr, $def_key);
//конкатенируем значения через ":"
$sign = implode(':', $ik_arr);
//base64 md5 в бинарном виде
return base64_encode(md5($sign, true));
}


private function debug_info($error){
 if($this->is_debug){
 return $error;
 }
return '';
}


public function loadlng($admin = false){
global $engineconf, $language;
 if($admin){
 $admin_dir = 'admin/';
 }
 else{
 $admin_dir = '';
 }
$default_language = $engineconf['lang'];
 if(! file_exists(PM_MODULES_DIR."/interkassa/$admin_dir$default_language".'_lang.lng')){
 $default_language = 'rus';
 }
 if(! file_exists(PM_MODULES_DIR."/interkassa/$admin_dir$default_language".'_lang.lng')){
 echo "Invalid language!";
 return false;
 }
$fh=fopen(PM_MODULES_DIR."/interkassa/$admin_dir$default_language".'_lang.lng', "r") or die('Can\'t load language file!');
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