<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
custom::get_lang('admin_lang/tune_styles');

echo cssEditorHtml();


function cssEditorHtml(){
global $sett, $lang;
$ret = '';
$ret .= <<<HTMLDATA
<!DOCTYPE html><html><head>
<meta http-equiv="Content-type" content="text/html; charset=$sett[charset]">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>$lang[tune_styles]</title>
<link href="adm/admin2.css" rel="stylesheet" type="text/css">
<link href="adm/tune_styles.css" rel="stylesheet" type="text/css">
<link href="ht/custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="adm/tune_styles.js"></script>
</head><body>
<div id="wraper" style="padding: 6px;">

 <div id="top_div">
HTMLDATA;

 if(isset($_POST['act']) && $_POST['act'] == 'save'){
 $ret .= saveCssFile($_POST['saved_css']);
 }

$logo_image = isset($sett["logo_image_$sett[design]"]) ? $sett["logo_image_$sett[design]"] : '';
$logo_image = str_replace('{design_url}', "$sett[relative_url]design/$sett[design]/", $logo_image);

$nologo_in_tpl = 'true';
 if(custom::is_valid_design($sett['design'])){
  if(strpos(file_get_contents(DESIGN_DIR."/$sett[design]/tpl/design.tpl"), '{logo_image}') !== false){
  $nologo_in_tpl = 'false';
  }
 }

$display_none = empty($logo_image) ? 'display:none;' : '';

$ret .= <<<HTMLDATA
<script type="text/javascript">
var noLogoInTpl=$nologo_in_tpl;
function setLogo(){
 if(noLogoInTpl){
 alert('$lang[no_logo_in_tpl] {logo_image}');
 return false;
 }
winImgUrlAction='logo_image';
window.open('?view=editor&act=ed_ins_img&editor=1&independ=1', '', 'status,scrollbars,resizable,width=680,height=400');
}
</script>
 <h1 style="display: inline;">$lang[tune_styles]</h1>
  <ul id="top-menu">
   <li><a href="javascript:void(0);" onclick="setLogo();">Выбрать логотип</a> <img src="adm/img/del.gif" id="del_logo" alt="$lang[clear_logo]" title="$lang[clear_logo]" style="vertical-align:middle;cursor:pointer;$display_none" onclick="if(confirm('$lang[clear_logo]? $lang[logo_not_be_removed]')){document.getElementById('logo_image').value='';var ifrLogo=edDoc.getElementById('logo_image');if(ifrLogo!==null){ifrLogo.style.display='none';}this.style.display='none';}"> | </li>
   <li><a href="?">$lang[return_to_home]</a></li>
  </ul>
  </div><!--/top_div-->
 <div class="clear"></div>
HTMLDATA;
$ret .= cssEditorLoad($logo_image);
$ret .= '</div><!--закр.wraper-->';
$ret .= <<<HTMLDATA
<iframe id="design" src="$sett[relative_url]$sett[index_file]" onload="tuneStylesInit();"></iframe>
</body></html>
HTMLDATA;

return $ret;
}


function cssFilePath(){
global $sett, $admset, $lang;
 if(! custom::is_valid_design($sett['design'])){
 die(msg::error('Invalid design!'));
 }
$ret_file = '';
$default_file = DESIGN_DIR."/$sett[design]/tunable-default.css";
$user_file = SCRIPTCHF_DIR."/pubfiles/tunable-$sett[design].css";
 if(is_file($user_file)){
 $ret_file = $user_file;
 }
 elseif(is_file($default_file)){
  if(@copy($default_file, $user_file)){
   if($admset['set_rfiles_chmod']){
    if(is_numeric($admset['rfiles_chmod'])){
    @chmod($user_file, octdec($admset['rfiles_chmod']));
    }
   }
  $ret_file = $user_file;
  }
  else{
  die(msg::error("$lang[cannot_copy_file] &quot;$default_file&quot; $lang[into] &quot;$user_file&quot;.<br>$lang[check_folder_chmod] pubfiles."));
  }
 }
return $ret_file;
}

function is_DogRule($rule){
$rule = ltrim(preg_replace('/\/\*.*?\*\//s', '', $rule));
 if(substr($rule, 0, 1) == '@'){
 return true;
 }
return false;
}

function is_NoBracketsRule($rule){
return preg_match('/\#UNSUPPORDED_RULE\{\@[a-zA-Z0-9\_\-]+[\s]+[^\;\{\}]*\;\}/s', $rule);
}


function formatCssRule($rule){
$unsupported_rule = false;
$unsupportedRuleCssText = '';
 if(strpos($rule, '%OPEN_BRACKET%') !== false || strpos($rule, '%CLOSE_BRACKET%') !== false || is_NoBracketsRule($rule) || is_DogRule($rule)){
 $unsupported_rule = true;
 $rule = preg_replace('/\/\*.*?\*\//s', '', $rule);
 $rule = str_replace('%OPEN_BRACKET%', '{', $rule);
 $rule = str_replace('%CLOSE_BRACKET%', '}', $rule);
 $rule = preg_replace('/\#UNSUPPORDED_RULE\{(\@[a-zA-Z0-9\_\-]+[\s]+[^\;\{\}]*\;)\}/s', '$1', $rule);
 $rule = trim($rule);
 $rule = preg_replace('/\r/', '', $rule);
 $rule = preg_replace('/\n/', '\\n', $rule);
 $unsupportedRuleCssText = $rule;
 }



$rule = preg_replace('/(\/\*[^\{\}]*?\*\/[\s]*){2,}/s', '$1', $rule);



preg_match('/(?:\/\*(.*)\*\/){0,1}[\s]*([\.\#\@]{0,1}[a-zA-Z0-9\_\*\-]{1}[^\{]*)[\s]*\{(.*)\}/s', $rule, $matches);

$comment = isset($matches[1]) ? trim(preg_replace('/\s+/', ' ', $matches[1])) : '';

$selectorText = isset($matches[2]) ? trim(preg_replace('/\s+/', ' ', $matches[2])) : $rule;

$selectorText = preg_replace('/(\S)([\+\>\~]{1})(\S)/', '$1 $2 $3', $selectorText);


$selectorText = str_replace('"', "'", $selectorText);

$matches[3] = isset($matches[3]) ? preg_replace('/\/\*.*?\*\//s', '', $matches[3]) : '';
$matches[3] = trim(preg_replace('/\s+/', ' ', $matches[3]));
$matches[3] = str_replace('"', "'", $matches[3]);
$properties_and_values = explode(';', $matches[3]);

$properties = array();

 if(! $unsupported_rule){
  foreach($properties_and_values as $str){
  $str = trim($str);
   if($str){
    if(strpos($str, ':') === false){
    $str .= ':';
    }
   list($property, $value) = explode(':', $str, 2);
   $property = trim($property);
    if($property){
    $properties[$property] = trim($value);
    }
   }
  }
 }

$ret = array(
'comment' => $comment,
'selectorText' => $selectorText,
'properties' => $properties,
'unsupportedRuleCssText' => $unsupportedRuleCssText
);

return $ret;
}


function replaceBraceFromComments($matches){
$matches[0] = str_replace('{', '&#123;', $matches[0]);
$matches[0] = str_replace('}', '&#125;', $matches[0]);
return $matches[0];
}

function replaceBrackets($matches){
$matches[2] = str_replace('{', '%OPEN_BRACKET%', $matches[2]);
$matches[2] = str_replace('}', '%CLOSE_BRACKET%', $matches[2]);
return $matches[1] . $matches[2] . $matches[3];
}

function parseCss($css_content){
$css_content = preg_replace_callback('/\/\*.*?\*\//s', 'replaceBraceFromComments', $css_content);


$css_content = preg_replace_callback('/(\{[^\{\}]*)(\{.*?\})([^\{\}]*\})/s', 'replaceBrackets', $css_content);



$css_content = preg_replace('/(\@[a-zA-Z0-9\_\-]+[\s]+[^\;\{\}]*\;)/s', '#UNSUPPORDED_RULE{$1}', $css_content);

preg_match_all('/[^\{]+\{.*?\}/s', $css_content, $rules);


$css_data = array();
 foreach($rules[0] as $rule){
 $arr = formatCssRule($rule);
 array_push($css_data, $arr);
 }
return $css_data;
}

function cssEditorLoad($logo_image){
global $sett, $lang;
$ret = '';
$css_file = cssFilePath();
 if(empty($css_file)){
 $ret .= <<<HTMLDATA
<script type="text/javascript">
tuneStylesInit=function(){};
</script>
HTMLDATA;
 $ret .= msg::error("$lang[used_design] &quot;$sett[design]&quot; $lang[not_support_tunes]");
 return $ret;
 }

$style_sheet = parseCss(file_get_contents($css_file));

$lng_css_properties = custom::get_lang('admin_lang/css_properties', false);
$lng_css_properties_values = custom::get_lang('admin_lang/css_properties_values', false);

$ret .= <<<HTMLDATA
 <div id="waitForReadOnly" class="wait">
  <div id="toolbar" class="readOnlyBlock">
<div id="selectorsTextsBlock">
$lang[page_element]
<div id="selector-text-name"></div>
<select id="selectorsTexts" onchange="showPropertiesBlock(this.value);"><option value="" title="">$lang[select]</option>
HTMLDATA;

 foreach($style_sheet as $index => $item){
 $title = custom::replace_tags($item['selectorText']);
 $inner_title = ! empty($item['comment']) ? custom::replace_tags($item['comment']) : custom::replace_tags($item['selectorText']);
 $disabled = '';
  if($item['unsupportedRuleCssText'] !== ''){
  $inner_title = 'Unsupported rule: ' . $inner_title;
  $disabled = ' disabled="disabled"';
  }
 $ret .= "<option value=\"$index\" title=\"$title\"$disabled>$inner_title</option>";
 }

$ret .= '</select></div>';

$ret .= <<<HTMLDATA
<div id="propertiesBlocks">
HTMLDATA;

$all_used_properties = array();

$js_arr = "var cssData = [\n";

 foreach($style_sheet as $index => $item){
 $inner_selector_text = custom::replace_tags($item['selectorText']);
 $ret .= <<<HTMLDATA
 <div id="propertiesBlock_$index" class="propertiesBlock">
 $lang[properties]: <b style="font-size:12px;">$inner_selector_text</b>
 <select id="properties_$index" onchange="showValuesBlock(this.value);"><option value="">$lang[select]</option>
HTMLDATA;

  $title = ! empty($item['comment']) ? $item['comment'] : '';
  $js_arr .= " {\n";
  $js_arr .= " 'browserRuleIndex': [-1],\n";
  $js_arr .= " 'unsupportedRuleCssText': ['" . str_replace("'", "\\'", $item['unsupportedRuleCssText']) . "'],\n";
  $js_arr .= " 'selectorText': ['" . str_replace("'", "\\'", $item['selectorText']) . "'],\n";
  $js_arr .= " 'comment': ['" . str_replace("'", "\\'", $title) . "'],\n";
  $js_arr .= " 'properties': {\n";

   foreach($item['properties'] as $property => $value){
    if(! in_array($property, $all_used_properties)){
    array_push($all_used_properties, $property);
    }
   $property_title = ! empty($lng_css_properties[$property]) ? "$property ($lng_css_properties[$property])" : $property;
   $value = str_replace('\\', "\\\\", $value);
   $js_arr .= "  '" . str_replace("'", "\\'", $property) . "': ['" . str_replace("'", "\\'", $value) . "'],\n";
   $ret .= "<option value=\"$property\" title=\"$property_title\">$property_title</option>";
   }

 $js_arr .= "  },\n";
 $js_arr .= " },\n";
 $ret .= '</select></div><!--/propertiesBlock-->';

 }

$js_arr .= "];\n";

$ret .= '</div>';

$lng_js = custom::get_lang('admin_lang/tune_styles_js', false);
$js_lang = 'var lang=new Array();';
 foreach($lng_js as $key => $value){
 $js_lang .= "lang['$key']='$value';";
 }

$properties_values_html = '';
include(INC_DIR."/admin/css_properties_values.php");
 foreach($all_used_properties as $property){
 $properties_values_html .= "<select id=\"propValues_$property\" class=\"propValues\" onchange=\"if(this.value){if(this.value==':Reset:'){propValueChange(this.value);}else{document.getElementById('prop_value').value=this.value;document.getElementById('prop_value').onchange();}}\"><option value=\"\">$lang[select]</option>";

  if(isset($css_properties_values[$property])){
  $values = $css_properties_values[$property];
   foreach($values as $value){
   $value = str_replace('"', "'", $value);
   $inner_title = isset($lng_css_properties_values[$value]) ? "$value ($lng_css_properties_values[$value])" : $value;
   $title = isset($lng_css_properties_values[$value]) ? $lng_css_properties_values[$value] : '';
   $properties_values_html .= "<option value=\"$value\" title=\"$title\">$inner_title</option>";
   }
  }

 $properties_values_html .= "<option value=\":Reset:\">$lang[reset_value]</option>";
 $properties_values_html .= '</select>';
 }

$properties_values_help = custom::contextHelp($lang['properties_values_help']);
$prop_value_help = custom::contextHelp($lang['prop_value_help']);

$ret .= <<<HTMLDATA
<div id="values_block">
 <div id="property_err"></div><!--В ДАННЫЙ МОМЕНТ НЕ ИСПОЛЬЗУЕТСЯ-->
$lang[property_value]

 <div id="value_tools">
  <div id="sel_color_btn"><input id="color_input" type="color" value="" title="$lang[select_color]" onchange="setPropValueSpecial(this.value);"></div>
  <script type="text/javascript">
  checkColorSupport();
  </script>
  <div id="sel_img_btn" class="tool-btn" onclick="winImgUrlAction='prop_value';window.open('?view=editor&act=ed_ins_img&editor=1&independ=1','','status,scrollbars,resizable,width=680,height=400');"><img src="adm/img/sel-img.gif" alt="$lang[select_image]" title="$lang[select_image]"></div>
 </div><!--закр.value_tools-->

 <div id="properties-values">
  <div class="nowrap" style="display:inline;">
  $properties_values_html
  $properties_values_help
  </div>
 </div>

<br>
 <div class="nowrap" style="display:inline;">
 <input type="text" id="prop_value" onchange="propValueChange(this.value);" onkeydown="if(event.keyCode==13 || event.keyCode==10){propValueChange(this.value);}"> $prop_value_help
 </div>
<br>
$lang[browser_property_value]<br>
<input type="text" id="browser-prop-value" readonly="readonly">
</div><!--закр.values_block-->
<script type="text/javascript">
$js_lang
lang['css_file']='$css_file';
$js_arr
var defDataCss=JSON.parse(JSON.stringify(cssData)); //независимая копия cssData, хранящая все начальные значения, создаётся при загрузке страницы. browserRuleIndex не содержит, вернее он там везде -1
</script>
HTMLDATA;

$ret .= <<<HTMLDATA
<hr>
<form action="?" method="POST" onsubmit="return saveChanges();">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="tune_styles">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="act" value="save">
<input type="hidden" id="saved_css" name="saved_css" value="">
<input type="hidden" id="logo_image" name="logo_image" value="$logo_image">
<input type="submit" id="save_submit" value="$lang[submit]" class="button1">
</form>
  </div><!--закр.toolbar-->
 </div><!--закр.waitForReadOnly-->
 <div id="err_log"></div>
HTMLDATA;

return $ret;
}

function get_filename_from_fullfilename($full_filename){
$pos = strrpos($full_filename, '/');
 if($pos > 0){
 return substr($full_filename, $pos+1);
 }
 else{
 return $full_filename;
 }
}

function saveCssFile($data){
global $lang, $admin_lib, $sett;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$file = cssFilePath();
 if(empty($file)){
 return '';
 }

$backup_msg = '';
$backup_error = false;
$filename_only = get_filename_from_fullfilename($file);
 if(@copy($file, SCRIPTCHF_DIR."/adm/dump/$filename_only.bak")){
 $backup_msg = "<div>$lang[backup_success] &quot;".SCRIPTCHF_DIR."/adm/dump/$filename_only.bak&quot;</div>";
 }
 else{
 $backup_error = true;
 $backup_msg = "<div class=\"red\">$lang[cannot_copy_file] &quot;$file&quot; $lang[into] &quot;".SCRIPTCHF_DIR."/adm/dump/$filename_only.bak&quot;<br>";
  if(file_exists(SCRIPTCHF_DIR."/adm/dump/$filename_only.bak")){
  $backup_msg .= "$lang[check_file_chmod] &quot;".SCRIPTCHF_DIR."/adm/dump/$filename_only.bak&quot;";
  }
  else{
  $backup_msg .= "$lang[check_folder_chmod] &quot;".SCRIPTCHF_DIR."/adm/dump&quot;";
  }
 $backup_msg .= '</div>';
 }

 if(file_put_contents($file, stripslashes($data)) === false){
 return msg::error("$lang[cannot_write_file] &quot;$file&quot;<br>$lang[check_file_chmod]");
 }

$logo_image = isset($_POST['logo_image']) ? $_POST['logo_image'] : '';

$new_sett = array();

setcookie('tunable_css_nocache', rand(1, 2147483647), time() + 15768000, '/', '', false);

 if($logo_image){
 $new_sett["logo_image_$sett[design]"] = $logo_image;
 $sett["logo_image_$sett[design]"] = $logo_image;
 }
 else{
 $admin_lib->delete_settings(2, array("logo_image_$sett[design]"));
 }

$admin_lib->save_settings(2, $new_sett);

$ret = msg::success($lang['changes_success'] . $backup_msg);

 if(! $backup_error){
 $ret = <<<HTMLDATA
 <div id="hide-msg-success">$ret</div>
 <script type="text/javascript">
 setTimeout("document.getElementById('hide-msg-success').style.display = 'none';", 10000);
 </script>
HTMLDATA;
 }

return $ret;
}

?>