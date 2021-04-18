<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class editor{

function script_link(){
return '';
}

function is_ie(){
if(preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])){return true;}
if(preg_match('/Trident\//i', $_SERVER['HTTP_USER_AGENT'])){return true;}
return false;
}

function init_js($textareas){
global $admset;
 if(! empty($admset['wysiwyg'])){
  if($admset['wysiwyg'] == 'tinymce3'){
  return $this->init_tinymce3($textareas);
  }
  else{
  return $this->init_tinymce4($textareas);
  }
 }
return '';

}


function init_tinymce3($textareas){
global $sett;
$textareas_str = '';
$elements = implode(',', $textareas);
 foreach($textareas as $textarea_name){
 $textareas_str .= "'$textarea_name',";
 }
$textareas_str = substr($textareas_str, 0, strlen($textareas_str) - 1);
return <<<HTMLDATA
<script type="text/javascript" src="$sett[relative_url]ht/tinymce3/tiny_mce.js"></script>
<script type="text/javascript">
var external_image_list_url='$sett[relative_url]ht/tmfiles/tmlists3.php?list=image_list';
var external_link_list_url='$sett[relative_url]ht/tmfiles/tmlists3.php?list=link_list';
var media_external_list_url='$sett[relative_url]ht/tmfiles/tmlists3.php?list=media_list';
var template_external_list_url='$sett[relative_url]ht/tmfiles/tmlists3.php?list=template_list';
var textareas=new Array($textareas_str);
var elements='$elements';
var document_base_url='$sett[url]';
</script>
<script type="text/javascript" src="$sett[relative_url]ht/tmfiles/tminit3.js"></script>
HTMLDATA;
}


function init_tinymce4($textareas){
global $sett;
$textareas_str = '';
$elements = '';
 foreach($textareas as $textarea_name){
 $textareas_str .= "'$textarea_name',";
 $elements .= "#$textarea_name,";
 }
$textareas_str = substr($textareas_str, 0, strlen($textareas_str) - 1);
$elements = substr($elements, 0, strlen($elements) - 1);
return <<<HTMLDATA
<script type="text/javascript" src="$sett[relative_url]ht/tinymce4/tinymce.min.js"></script>
<script type="text/javascript">
var textareas=new Array($textareas_str);
var elements='$elements';
var document_base_url='$sett[url]';
var engineRelativeUrl='$sett[relative_url]';
</script>
<script type="text/javascript" src="$sett[relative_url]ht/tmfiles/tmlists4.php"></script>
<script type="text/javascript" src="$sett[relative_url]ht/tmfiles/tminit4.js"></script>
HTMLDATA;
}




 
}
?>