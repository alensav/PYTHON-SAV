<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

class wmmerchant{

private $is_debug = false;

public function payment_form($order_id){
global $language;
$order_data = get_order_data($order_id);

 //если заказ уже оплачен, то форму не выводим, а пишем что заказ уже оплачен
 if(is_paid_order($order_id)){
 return "<h3>$language[paid_successfully]</h3>";
 }

$shop_purse = $this->get_shop_purse($order_data['order']['currency_id']);

 if(! $shop_purse){
 return '<br>'.$language['not_shop_purse'];
 }

return <<<HTMLDATA
$language[final_total] {$order_data['order']['final_total_pc']} {$order_data['order']['currency_brief']}<br>
<form accept-charset="windows-1251" action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST" style="margin:3px;">
<h3>$language[go_to_payment]</h3>
$language[after_submit]<br>
<input type="hidden" name="LMI_PAYMENT_NO" value="{$order_data['order']['orderid']}">
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$order_data['order']['final_total_pc']}">
<input type="hidden" name="LMI_PAYEE_PURSE" value="$shop_purse">
<input type="hidden" name="LMI_PAYMENT_DESC" value="$language[order_n] {$order_data['order']['orderid']}">
<input type="hidden" name="LMI_SIM_MODE" value="0">
<input type="submit" value="$language[continue]"><br>
</form>
<br><br>
HTMLDATA;
}


public function payment_success(){
global $language, $engineconf;
$order_data = get_order_data($_POST['LMI_PAYMENT_NO']);
$wmmdata = $this->wmm_data($order_data['order']['orderid']);
$order_status_name = paid_status_name();

$rettext='';
$err='';

 if($wmmdata['LMI_PAYMENT_NO'] !== $_POST['LMI_PAYMENT_NO']){
 $err.="Error 1.<br>";
 }

 if($wmmdata['LMI_SYS_INVS_NO'] !== $_POST['LMI_SYS_INVS_NO']){
 $err.="Error 2.<br>";
 }

 if($wmmdata['LMI_SYS_TRANS_NO'] !== $_POST['LMI_SYS_TRANS_NO']){
 $err.="Error 3.<br>";
 }

 if($wmmdata['LMI_SYS_TRANS_DATE'] !== $_POST['LMI_SYS_TRANS_DATE']){
 $err.="Error 4.<br>";
 }

 if(! is_paid_order($order_data['order']['orderid'])){
 $err.="Error 5: Заказ не оплачен.<br>";
 }

 if($err){
 $rettext.="<h3 class=\"red\">$language[payment_not_made]</h3><p class=\"red\"><b>$language[payment_errors]:</b><br>$err";
 }
 else{
 $rettext .= <<<HTMLDATA
<h3>$language[paid_successfully]</h3>
$language[thank_you]!<br>
$language[order_number]: {$order_data[order][orderid]}<br>
$language[order_status]: $order_status_name<br>
$language[paid_sum]: {$order_data[order][final_total_pc]} {$order_data[order][currency_brief]}<br><br>
$language[order_is_sended]<br><br>
HTMLDATA;
 }

return $rettext;
}


public function payment_fail(){
global $language;
return "<h3>$language[payment_not_made]</h3>";
}


public function payment_result(){
global $wmconf, $db;
$wmconf = $this->getwmconfig();
$order_data = get_order_data($_POST['LMI_PAYMENT_NO']);
//print_r($order_data);
$order_id = intval($order_data['order']['orderid']);
$shop_purse = $this->get_shop_purse($order_data['order']['currency_id']);

 //BEGIN если предварительный запрос
 if($_POST['LMI_PREREQUEST']){
 header("Content-type: text/html; charset=iso-8859-1");
 $result = $this->check_preliminary_query($order_data['order'], $shop_purse);
  if($result==1){
  return 'YES';
  }
  else{
  return $result;
  }
 }
 //END если предварительный запрос
 

/*****************************/
//далее уведомление о платеже

 if($wmconf['msk']){
 $svl = $this->getedd(base64_decode($wmconf['msk']), $wmconf['ck']);
 }
 else{
 $svl='';
 }

//вычисляем контрольную подпись присланных данных
$post_hash = strtoupper($this->gen_hash($_POST['LMI_PAYEE_PURSE'] . $_POST['LMI_PAYMENT_AMOUNT'] . $_POST['LMI_PAYMENT_NO'] . $_POST['LMI_MODE'] . $_POST['LMI_SYS_INVS_NO'] . $_POST['LMI_SYS_TRANS_NO'] . $_POST['LMI_SYS_TRANS_DATE'] . $svl . $_POST['LMI_PAYER_PURSE'] . $_POST['LMI_PAYER_WM']));

//вычисляем контрольную подпись магазина
$shop_hash = strtoupper($this->gen_hash($shop_purse . $order_data['order']['final_total_pc'] . $order_data['order']['orderid'] . $wmconf['test_mode'] . $_POST['LMI_SYS_INVS_NO'] . $_POST['LMI_SYS_TRANS_NO'] . $_POST['LMI_SYS_TRANS_DATE'] . $svl . $_POST['LMI_PAYER_PURSE'] . $_POST['LMI_PAYER_WM']));

$wmmdata='';
 foreach($_POST as $name => $value){
 $name = $this->del_no_utf_chars($name);
 $value = $this->del_no_utf_chars($value);
  if(substr($name, 0, 4)==='LMI_' && $name !== 'LMI_SECRET_KEY'){
  $wmmdata.="$name=$value<xN>";
  }
 }
$wmmdata.="shop_hash=$post_hash<xN>";
//$wmmdata.="shop_time=".intval(time())."<xN>";
$wmmdata = mb_substr($wmmdata, 0, 32767);

$result = $this->check_preliminary_query($order_data['order'], $shop_purse);
 if($result !== 1){
 return $this->debug_info($result, $wmmdata);
 }

 if($_POST['LMI_HASH'] !== $shop_hash){
 return $this->debug_info('Invalid LMI_HASH.', $wmmdata);
 }

 if($post_hash !== $shop_hash){
 return $this->debug_info('Invalid POST hash.', $wmmdata);
 }

$tablename=DB_PREFIX.'wm_merchant';
$res=$db->query("SELECT COUNT(*) FROM $tablename WHERE orderid = $order_id")or die($db->error());
 if($db->result($res)>0){
 return $this->debug_info("OK, but wm post order($order_id) data is already in the database.", '');
 }
 
//устанавливаем статус оплачен
set_order_paid($order_id);

$wmmdata = $db->secstr($wmmdata);
$db->query("INSERT INTO $tablename (orderid, wmm_data) VALUES ($order_id, '$wmmdata')") or die($db->error());
return $this->debug_info('OK', '');
}


//проверка формы предварительного запроса
public function check_preliminary_query($order_dt, $shop_purse){
global $wmconf;
//номер покупки в соответствии с системой учета продавца
$_POST['LMI_PAYMENT_NO']=intval(trim($_POST['LMI_PAYMENT_NO']));
 if(! $_POST['LMI_PAYMENT_NO']){
 return 'Invalid post order number.';
 }

//Кошелек продавца
$_POST['LMI_PAYEE_PURSE']=trim($_POST['LMI_PAYEE_PURSE']);

//сумма платежа, Дробная часть отделяется точкой.
$_POST['LMI_PAYMENT_AMOUNT']=trim($_POST['LMI_PAYMENT_AMOUNT']);

//тестовый режим (0 - реальный, 1 - тестовый)
$_POST['LMI_MODE']=intval(trim($_POST['LMI_MODE']));

//WMID покупателя
//$_POST['LMI_PAYER_WM']=trim($_POST['LMI_PAYER_WM']);

//кошелек покупателя
$_POST['LMI_PAYER_PURSE']=trim($_POST['LMI_PAYER_PURSE']);

 if($order_dt[orderid] != $_POST['LMI_PAYMENT_NO']){
 return 'Invalid order number.';
 }

 //f(! $this->is_valid_paymethod($order_dt['pmid'])){
 //return "This payment method is not available now.";
 //}

 if($_POST['LMI_PAYEE_PURSE']!==$shop_purse){
 return 'Invalid payee purse.';
 }

 if($_POST['LMI_PAYMENT_AMOUNT'] != $order_dt['final_total_pc']){
 return 'Payment ammount not coincide with order ammount.';
 }

//0 - рабочий режим, 1 - тестовый режим
 if($_POST['LMI_MODE'] != $wmconf['test_mode']){
 return 'LMI_MODE not coincide with shop LMI_MODE.';
 }

 if(substr(strtoupper($_POST['LMI_PAYER_PURSE']), 0, 1) !== substr(strtoupper($shop_purse), 0, 1)){
 return 'Invalid payer purse type.';
 }

return 1;
}


public function get_shop_purse($currency_id){
global $db;
$currency_id=intval($currency_id);
$tablename=DB_PREFIX.'wm_purses';
$res=$db->query("SELECT pursenumber FROM $tablename WHERE currency_id = $currency_id")or die($db->error());
$row=$db->fetch_array($res);
return $row['pursenumber'];
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
 if(! file_exists(PM_MODULES_DIR."/wm_merchant/$admin_dir$default_language".'_lang.lng')){
 $default_language = 'rus';
 }
 if(! file_exists(PM_MODULES_DIR."/wm_merchant/$admin_dir$default_language".'_lang.lng')){
 echo "Invalid language!";
 return false;
 }
$fh=fopen(PM_MODULES_DIR."/wm_merchant/$admin_dir$default_language".'_lang.lng', "r") or die('Can\'t load language file!');
 while(! feof($fh)){
 $language_str=explode('=', fgets($fh, 2048), 2);
 $language_str[0]=trim($language_str[0]);
 if($language_str[0]){$language["$language_str[0]"]=trim($language_str[1]);}
 }
fclose($fh);
return true;
}

public function getwmconfig(){
global $db;
$tablename=DB_PREFIX.'wm_merchant_conf';
$result = $db->query("SELECT sname, svalue FROM $tablename") or die($db->error());
$config=array();
 while($row=$db->fetch_array($result)){
 $config["$row[sname]"]=$row['svalue'];
 }
return $config;
}

public function getedd($sval, $type){
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


public function debug_info($error, $wmmdata){
 if($this->is_debug){
 return $error . '<hr>' . str_replace('<xN>', '<br>', $wmmdata);
 }
return '';
}


public function wmm_data($order_id){
global $db;
$order_id = intval($order_id);
$tablename=DB_PREFIX.'wm_merchant';
$res = $db->query("SELECT wmm_data FROM $tablename WHERE orderid = $order_id") or die($db->error());
$row = $db->fetch_array($res);
 if($row['wmm_data']){
 $data=explode('<xN>', $row['wmm_data']);
 $wmmdata = array();
  if(is_array($data)){
   if(sizeof($data)){
    foreach($data as $str){
    $arr=explode('=', $str);
     if($arr[0]){
     $wmmdata["$arr[0]"] = $arr[1];
     }
    }
   }
  }
 }
return $wmmdata;
}


//если в строке имеются символы не utf-8, то всё в диапазоне от 80-FF заменяется на ?
public function del_no_utf_chars($str){
 //если строка не в кодировке utf-8
 if(! preg_match('/./u', $str)){
 $str = preg_replace('/[\x80-\xFF]/', '?', $str);
 }
return $str;
}


private function gen_hash($str){
return hash('sha256', $str);
}



}
?>