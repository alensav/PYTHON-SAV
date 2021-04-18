<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class template{

public $global_vars = array();
public $cycles = array();
public $last_cycle_name = '';
public $content = '';


function __construct($file = ''){
 if($file){
 $this->load_template($file);
 }
}


function include_in_var($file){
ob_start();
ob_implicit_flush(0);
include($file);
$ret = ob_get_contents();
ob_end_clean();
return $ret;
}


function condition($condition){
$this->content = str_replace("<!--if:$condition-->", '', $this->content);
$this->content = str_replace("<!--/if:$condition-->", '', $this->content);
}


function not_condition($condition){
$this->content = preg_replace("((\<\!\-\-if\:$condition\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:$condition\-\-\>))", '', $this->content);
}


function condition_cycle($condition, $cycle_name=''){
if(! $cycle_name){$cycle_name = $this->last_cycle_name;}else{$this->last_cycle_name = $cycle_name;}
$this->cycles["$cycle_name"]['work'] = str_replace("<!--if:$condition-->", '', $this->cycles["$cycle_name"]['work']);
$this->cycles["$cycle_name"]['work'] = str_replace("<!--/if:$condition-->", '', $this->cycles["$cycle_name"]['work']);
}


function not_condition_cycle($condition, $cycle_name=''){
if(! $cycle_name){$cycle_name = $this->last_cycle_name;}else{$this->last_cycle_name = $cycle_name;}
$this->cycles["$cycle_name"]['work'] = preg_replace("((\<\!\-\-if\:$condition\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:$condition\-\-\>))", '', $this->cycles["$cycle_name"]['work']);
}


function between_cycles($cycle_name=''){
 if(! $cycle_name){
 $cycle_name = $this->last_cycle_name;
 }
 else{
 $this->last_cycle_name = $cycle_name;
 }

$cycle_number = $this->cycles[$cycle_name]['cycle_number'];

 if( preg_match("((\<\!\-\-if\:cycle\=$cycle_number\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:cycle\=$cycle_number\-\-\>))", $this->cycles[$cycle_name]['work']) ){
 $this->cycles["$cycle_name"]['work'] = preg_replace("((\<\!\-\-if\:cycle\={$this->cycles[$cycle_name]['cycle_number']}\-\-\>)([\x01-\xFF]+?)(\<\!\-\-\/if\:cycle\={$this->cycles[$cycle_name]['cycle_number']}\-\-\>))", '\\2', $this->cycles[$cycle_name]['work']);
 $this->cycles[$cycle_name]['cycle_number'] = 1;
 $result = true;
 }
 else{
 $this->cycles["$cycle_name"]['work'] = preg_replace("((\<\!\-\-if\:cycle\=[0-9]{1,10}\-\-\>)([\x01-\xFF]{0,}?)(\<\!\-\-\/if\:cycle\=[0-9]{1,10}\-\-\>))", '', $this->cycles["$cycle_name"]['work']);
 $this->cycles["$cycle_name"]['cycle_number'] ++;
 $result = false;
 }


return $result;
}


function load_template($file){
global $sett;
 if(PHP_IN_TPL == 1){
 $this->content = $this->include_in_var(DESIGN_DIR."/$sett[design]/tpl/$file");
 }
 else{
 $this->content = file_get_contents(DESIGN_DIR."/$sett[design]/tpl/$file");
 }
 if(substr($this->content, 0, 3) === "\xEF\xBB\xBF"){
 $this->content = substr($this->content, 3);
 }
}


function get_file($file){
 if(PHP_IN_TPL == 1){
 return $this->include_in_var($file);
 }
 else{
 return file_get_contents($file);
 }
}


function assign($varname, $value){
 if(! isset($value)){
 $value = '';
 }
$this->global_vars["$varname"] = $value;
}




function out_content($is_main=0){
global $arr_lvl;

$level = $this->var_max_level();

$reg1='';
$arr_lvl=array();

 for($i=0;$i<$level;$i++){


 $this->content = preg_replace_callback("((\{)([a-zA-Z0-9\_]{1,32})$reg1(\}))", array($this, 'calbk1'), $this->content);


 $reg1 .= "(\.)([a-zA-Z0-9\_]{1,32})";
 array_push($arr_lvl, ($i+2)*2);
 }

 if($is_main){
 $this->content = preg_replace_callback('((\{)([a-zA-Z0-9\_]{1,32})(\}))', array($this, 'calbk2'), $this->content);
 }



return $this->content;
}


function calbk1($matches){
global $arr_lvl;
 if(isset($this->global_vars["$matches[2]"])){
 $tpl_var = $this->global_vars["$matches[2]"];
 }
 if(sizeof($arr_lvl)){
  foreach($arr_lvl as $value){
  $tpl_var = $tpl_var["$matches[$value]"];
  }
 }
return isset($tpl_var) ? $tpl_var : $matches[0];
}


function calbk2($matches){
return isset($this->global_vars["$matches[2]"]) ? $this->global_vars["$matches[2]"] : $matches[0];
}





function var_max_level($variable=''){
$level = 1;
$max_level = 1;

 if(! $variable && ! is_array($variable)){
 $variable = $this->global_vars;
 }

 if(is_array($variable)){
  if(count($variable)){
   foreach($variable as $value){
    if(is_array($value)){
    $level = 1;
    $level += $this->var_max_level($value);
    if($level > $max_level){$max_level = $level;}
    }
   }
  }
 }

return $max_level;
}


function get_cycle($cycle_name, $parent_cycle_name=''){
 if($parent_cycle_name){
 $this->cycles["$cycle_name"]['tpl'] = ' '. $this->cycles["$parent_cycle_name"]['tpl'];
 $this->cycles["$cycle_name"]['parent'] = $parent_cycle_name;
 }
 else{
 $this->cycles["$cycle_name"]['tpl'] = ' '. $this->content;
 $this->cycles["$cycle_name"]['parent'] = '';
 }
$this->last_cycle_name = $cycle_name;
$this->cycles["$cycle_name"]['cycle_number'] = 1;
$pos = strpos($this->cycles["$cycle_name"]['tpl'], "<!--begin:$cycle_name-->");
 if($pos){
 $this->cycles["$cycle_name"]['tpl'] = substr($this->cycles["$cycle_name"]['tpl'], $pos+strlen("<!--begin:$cycle_name-->"));
 }
 else{
 $this->cycles["$cycle_name"]['tpl'] = '';
 return '';
 }
$pos = strpos($this->cycles["$cycle_name"]['tpl'], "<!--end:$cycle_name-->");
 if($pos){
 $this->cycles["$cycle_name"]['tpl'] = substr($this->cycles["$cycle_name"]['tpl'], 0, $pos);
 }
 else{
 $this->cycles["$cycle_name"]['tpl'] = '';
 }
$this->cycles["$cycle_name"]['out'] = '';
$this->cycles["$cycle_name"]['work'] = $this->cycles["$cycle_name"]['tpl'];
}


function get_cycle_virtual($from_cycle_name, $cycle_name){
$this->last_cycle_name = $cycle_name;
$this->cycles["$cycle_name"]['cycle_number'] = 1;
$this->cycles["$cycle_name"]['tpl'] = $this->cycles["$from_cycle_name"]['tpl'];
$this->cycles["$cycle_name"]['out'] = '';
$this->cycles["$cycle_name"]['work'] = $this->cycles["$cycle_name"]['tpl'];
}

function assign_cycle($varname, $new_value, $cycle_name = ''){
 if(! $cycle_name){
 $cycle_name = $this->last_cycle_name;
 }
 else{
 $this->last_cycle_name = $cycle_name;
 }

 if(! isset($new_value)){
 $new_value = '';
 }

 if(isset($this->cycles["$cycle_name"]['work'])){
 $this->cycles["$cycle_name"]['work'] = str_replace('{'.$varname.'}', $new_value, $this->cycles["$cycle_name"]['work']);
 }
 else{
 $this->cycles["$cycle_name"]['work'] = '';
 }
}


function assign_cycle_arr($arr, $cycle_name=''){
if(! $cycle_name){$cycle_name = $this->last_cycle_name;}else{$this->last_cycle_name = $cycle_name;}
 foreach($arr as $name => $value){
 $this->cycles["$cycle_name"]['work'] = str_replace('{'.$name.'}', $value, $this->cycles["$cycle_name"]['work']);
 }
}




function next_loop($cycle_name=''){
 if(! $cycle_name){
 $cycle_name = $this->last_cycle_name;
 }
 else{
 $this->last_cycle_name = $cycle_name;
 }
 if(! isset($this->cycles["$cycle_name"]['out'])){
 $this->cycles["$cycle_name"]['out'] = '';
 }
$this->cycles["$cycle_name"]['out'] .= $this->cycles["$cycle_name"]['work'];
$this->cycles["$cycle_name"]['work'] = $this->cycles["$cycle_name"]['tpl'];
}


function out_cycle($cycle_name=''){
if(! $cycle_name){$cycle_name = $this->last_cycle_name;}else{$this->last_cycle_name = $cycle_name;}
$r1 = "<!--begin:$cycle_name-->";
$r2 = "<!--end:$cycle_name-->";
$parent = $this->cycles["$cycle_name"]['parent'];
 if($parent){
 $this->cycles["$parent"]['work'] = preg_replace("(($r1)([\x01-\xFF]{0,})($r2))", $this->cycles["$cycle_name"]['out'], $this->cycles["$parent"]['work']);
 $this->cycles["$cycle_name"]['out'] = '';
 $this->cycles["$cycle_name"]['work'] = $this->cycles["$cycle_name"]['tpl'];
 $this->cycles["$cycle_name"]['cycle_number'] = 1;
 }
 else{
 $this->content = preg_replace("(($r1)([\x01-\xFF]{0,})($r2))", $this->cycles["$cycle_name"]['out'], $this->content);
 unset($this->cycles["$cycle_name"]);
 }
}


function out_cycle_virtual($cycle_name=''){
if(! $cycle_name){$cycle_name = $this->last_cycle_name;}else{$this->last_cycle_name = $cycle_name;}
$ret = $this->cycles["$cycle_name"]['out'];
unset($this->cycles["$cycle_name"]);
return $ret;
}


function set_content($content){
$this->content = $content;
}


function set_cycle_out($content, $cycle_name=''){
if(! $cycle_name){$cycle_name = $this->last_cycle_name;}else{$this->last_cycle_name = $cycle_name;}
$this->cycles["$cycle_name"]['out'] = $content;
}



}
?>