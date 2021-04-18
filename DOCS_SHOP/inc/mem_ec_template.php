<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class mem_ec_template{

private $tpl = '';

public function __construct($file){
global $sett;
 if(PHP_IN_TPL == 1){
 $this->tpl = $this->include_in_var(DESIGN_DIR."/$sett[design]/tpl/$file");
 }
 else{
 $this->tpl = file_get_contents(DESIGN_DIR."/$sett[design]/tpl/$file");
 }
 if(substr($this->tpl, 0, 3) === "\xEF\xBB\xBF"){
 $this->tpl = substr($this->tpl, 3);
 }
}

public function get_block($cycle_name, $data){
$ret = array();
$ret['body']=' '.$data;
$pos = strpos($ret['body'], "<!--begin:$cycle_name-->");
 if($pos){
 $ret['header'] = substr($ret['body'], 0, $pos);
 $ret['body'] = substr($ret['body'], $pos+strlen("<!--begin:$cycle_name-->"));
 }
$pos=strpos($ret['body'], "<!--end:$cycle_name-->");
 if($pos){
 $ret['footer'] = substr($ret['body'], $pos+strlen("<!--end:$cycle_name-->"));
 $ret['body'] = substr($ret['body'], 0, $pos);
 }
return $ret;
}


private function calbk1($matches){
global $lang;
return $lang[$matches[2]];
}


public function replace_lang($data){
return preg_replace_callback('((\{lang\.)([a-z0-9\_]{1,50})(\}))', array('self', 'calbk1'), $data);
}


public function condition($condition, $data){
$data=str_replace("<!--if:$condition-->", '', $data);
return str_replace("<!--/if:$condition-->", '', $data);
}


public function not_condition($condition, $data){
return preg_replace("((\<\!\-\-if\:$condition\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:$condition\-\-\>))", '', $data);
}


public function between_cycles(&$data){
 if( preg_match("((\<\!\-\-if\:cycle\=$this->cycle_number\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:cycle\=$this->cycle_number\-\-\>))", $data) ){
 $data = str_replace("<!--if:cycle=$this->cycle_number-->", '', $data);
 $data = str_replace("<!--/if:cycle=$this->cycle_number-->", '', $data);
 $this->cycle_number=1;
 return 1;
 }
 else{
 $data = preg_replace("((\<\!\-\-if\:cycle\=)([0-9]{1,3})(\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:cycle\=)([0-9]{1,3})(\-\-\>))", '', $data);
 $this->cycle_number++;
 return 0;
 }
}


public function get_tpl(){
return $this->tpl;
}


public function include_in_var($file){
global $sett;
ob_start();
ob_implicit_flush(0);
include($file);
$ret=ob_get_contents();
ob_end_clean();
return $ret;
}

public function assign($varname, $value){
$this->tpl = str_replace('{' . $varname . '}', $value, $this->tpl);
}


}
?>