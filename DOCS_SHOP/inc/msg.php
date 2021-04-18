<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class msg{

public static function error($msg, $header = ''){
return self::message('error', $msg, $header);
}

public static function success($msg, $header = ''){
return self::message('success', $msg, $header);
}

private static function message($type, $msg, $header){
global $lang;
 if(empty($header)){
 $header = $lang['msg_header'];
 }
$class = '';
 if($type == 'error'){
 $class = 'errMsg red';
 }
 elseif($type == 'success'){
 $class = 'successMsg';
 }
return '<div class="msg '.$class.'"><div class="msgHdr">'.$header.'</div><div class="msgBody">'.$msg.'</div></div>';
}



}
?>